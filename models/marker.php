<?php
/**
 * Mark-a-Spot Marker Model
 *
 * 
 *
 * Copyright (c) 2010 Holger Kreis
 * http://www.mark-a-spot.org
 *
 *
 * PHP version 5
 * CakePHP version 1.3
 *
 * @copyright  2010, 2011 Holger Kreis <holger@markaspot.org>
 * @link       http://mark-a-spot.org/
 * @version    1.6.0  
 */
 


class Marker extends AppModel {
	
	var $name = 'Marker';
	var $plz = array();
	var $belongsTo = array(
		'User' => array(
			'className' => 'User',
			'foreignKey' => 'user_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		),
		'Category' => array(
			'className' => 'Category',
			'foreignKey' => 'category_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		),
		'Status' => array(
			'className' => 'Status',
			'foreignKey' => 'status_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		),
		'District' => array(
			'className' => 'District',
			'foreignKey' => 'district_id',
			'conditions' => ''
		)
	);


	var $hasMany = array(
		'Comment' => array(
			'className' => 'Comment',
			'foreignKey' => 'marker_id',
			'dependent' => true,
			'conditions' => array('Comment.status' => '1')
		),
		'Transaction' => array(
			'className' => 'Transaction',
			'foreignKey' => 'marker_id',
			'dependent' => true,
			// now we filter view actions for splash pages
			'conditions' => array('NOT' => array('action' => 'view')),
			'order' => 'Transaction.created DESC', // for RSS-Logfile Descendent
		),
		'Attachment' => array(
			'className' => 'Media.Attachment',
			'foreignKey' => 'foreign_key',
			'conditions' => array('Attachment.model' => 'Marker'),
			'dependent' => true
		),

		'Rating' => array(
			'className' => 'Rating.Rating',
			'foreignKey' => 'model_id',
			'dependent' => true
		)
/*
		'Votings' => array(
			'className' => 'Voting.Voting',
			'foreignKey' => 'model_id',
			'dependent' => true
		)
*/
	);
	


	var $actsAs = array(
		'Revision' => array(
			'limit'=>3,
			'ignore'=>array('')
		),
		'Containable',
		'format' => array(
			'caseSentences' => array(
				'subject', 'description'
			)
		)
	);

	var $validate = array(
	
		'subject' => array(
			'rule' => array('between', 1, 128),
			'notempty' => true,
			'message'=> 'Please enter a title'
		),
		'zip' => array(
			'rule1' => array(
				'rule' => array('inList', array()),
				'message' => 'This zip code is not in field list')
				,
			'rule2' => array(
				'rule' => 'postal', null, 'de',
				'message' => 'Please enter a valid zip code')
		),
		
		'city' => array(
			'rule' => array('between', 1, 128),
			'message' => 'Please enter the City\'s Name'
		),
		'street' => array(
			'rule' => array('between', 1, 128),
			'message' => 'Please enter a street name or drag the marker'
		),
		'category_id'=> array(
			'rule' => array('minLength', 1),
			//'notempty' => true,
			'message' => 'Please choose one of the categories'
		),
		'description' => array(
			//'rule' => array('maxLength', 3000),
			//'required' => true, 
			'allowEmpty' => true,
			//'message' => 'Hier können Sie maximal 2000 Zeichen einzugeben'
		),

		'file' => array(
			'resource'   => array(
				'rule' => 'checkResource'),
			'access'     => array(
				'rule' => 'checkAccess'),
			'location' => array(
				'rule' => array(
					'checkLocation', array(
						MEDIA_TRANSFER, '/tmp/', 'http://')
				)
			),
			'permission' => array(
				'rule' => array(
					'checkPermission', '*'
				)
			),
			'size'       => array(
				'rule' => array(
					'checkSize', '5M')
				),
			'pixels'     => array(
				'rule' => array(
					'checkPixels', '3600x3600')
					),
			'extension'  => array(
				'rule' => array(
					'checkExtension', false, array(
						'jpg', 'jpeg', 'png', 'tif', 'tiff', 'gif', 'pdf', 'tmp'
					)
				)
			),
			'mimeType'   => array(
				'rule' => array(
					'checkMimeType', false, array(
						'image/jpeg', 'image/png', 'image/tiff', 'image/gif', 'application/pdf'
						)
					)
				),
			'	message' => 'This file is not valid (extension, bigger than 3600px)'
		),
		'alternative' => array(
				'rule'       => 'checkRepresent',
				'on'         => 'create',
				'required'   => false,
				'allowEmpty' => true,
		)
	);

	function __construct($id = false, $table = null, $ds = null) {
		parent::__construct($id, $table, $ds);
		
		// Overload validation rule with databased configuration for ZIP 
		App::import('Model', 'Configurator.Configuration');
		$Conf = new Configuration;
		$zips = explode(",",$Conf->field('value', array('key' => 'Gov.Zip')));

		$this->validate['zip']['rule1']['rule'][1] = $zips;
	
	}
	
	/**
	 *
	 *  Publish new markers with full content or with placeholder
	 *
	 */ 
	
	function publish($markers){

		// Filter new unpublished Markers as "New marker #" if neccessary 
		if (!Configure::read('Publish.Markers')) {
			$newMarkers = $markers;
			unset($markers);
			foreach ($newMarkers as $marker):
				if ($marker['Marker']['status_id'] == 1) {
					$marker['Marker']['subject'] = __('New Marker ID#',true).''.
						substr($marker['Marker']['id'], 0, 8);
					$marker['Marker']['description'] = __('Not yet published',true);
				
				}
				$markers[]= $marker;
			endforeach;
		}
		if (isset($markers)){
			return $markers;
		}
	}

	function publishRead($marker){
		// Filter new unpublished Markers as "New marker #" if neccessary 
		if (!Configure::read('Publish.Markers')) {
			if ($marker['Status']['id'] == 1) {
				$marker['Marker']['subject'] = __('New Marker ID#',true).''.
					substr($marker['Marker']['id'], 0, 8);
				$marker['Marker']['description'] = __('Not yet published',true);
			}
		}
		return $marker;
	}		
	
	
	function publishReadJson($marker){
		// Filter new unpublished Markers as "New marker #" if neccessary 
		if (!Configure::read('Publish.Markers')) {
			if ($marker[0]['Status']['id'] == 1) {
				$marker[0]['Marker']['subject'] = __('New Marker ID#',true).''.
					substr($marker[0]['Marker']['id'], 0, 8);
				$marker[0]['Marker']['description'] = __('Not yet published',true);
			}
		}
		return $marker;
	}
	
	
	/**
	 *
	 *  CanAccess Funktion zum Check der Berechtigung ob user_id des Objektes dem eingeloggten User entspricht.
	 *
	 */ 
	function canAccess($userId = null, $primaryKey = null) {
		if ($this->find('first', array('conditions' => array(
			$this->alias.'.user_id' => $userId, $this->primaryKey => $primaryKey), 'recursive' => -1)))			{
			return true;
			}
		return false;
	}
	
	
	
	function cutWords ( $str = '', $maxWords = 1, $tail = '...' ) { 
		$pattern = sprintf ( '/^((.+?\b){%s}).*/', 2 * $maxWords - 1 ); 		
		$newString = preg_replace ( $pattern, '$1', $str ); 
		return $newString != $str ? $newString . $tail : $str; 
	} 

}
?>