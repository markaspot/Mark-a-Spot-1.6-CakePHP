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
 * CakePHP version 1.2
 *
 * @copyright  2010 Holger Kreis <holger@markaspot.org>
 * @license    http://www.gnu.org/licenses/agpl-3.0.txt GNU Affero General Public License
 * @link       http://mark-a-spot.org/
 * @version    1.4 beta 
 */
 
 
class Marker extends AppModel {
	var $name = 'Marker';

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
				'subject', 'descr'
			)
		)
	);

	var $validate = array(
	
		'subject' => array(
			'rule' => array('between', 1, 120),
			'required' => true, 
			'notempty' => true,
			'message'=> 'Worum geht es? Maximal 128 Zeichen'
		),
		'zip' => array(
			'rule' => array('minLength', 5),
			'notempty' => true,
			'message' => 'Bitte geben Sie die korrekte Postleitzahl ein'
		), 
		'category_id'=> array(
			'rule' => array('minLength', 1),
			'notempty' => true,
			'message' => 'Bitte wählen Sie eine Kategorie'
		), 
		'street' => array(
			'rule' => array('maxLength', 255), 
			'required' => true, 
			'message' => 'Ziehen Sie den Marker auf der Karte oder geben Sie eine Straße an'
		),
		'descr' => array(
			'rule' => array('maxLength', 3000),
			//'required' => true, 
			//'allowEmpty' => false,
			'message' => 'Hier können Sie maximal 2000 Zeichen einzugeben'
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
					'checkPixels', '1600x1600')
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
			'	message' => 'Diesen Dateityp können wir nicht annehmen'
		),
		'alternative' => array(
				'rule'       => 'checkRepresent',
				'on'         => 'create',
				'required'   => false,
				'allowEmpty' => true,
		)
	);
	
	
	/**
	 *
	 *  Publish new markers with full content or with placeholder
	 *
	 */ 
	
	function publish($markers){
		// Filter new unpublished Markers as "New marker #" if neccessary 
		if (!Configure::read('Publish.Markers')) {
			//pr($markers);
			$newMarkers = $markers;
			unset($markers);
			foreach ($newMarkers as $marker):
				if ($marker['Status']['id'] == 1) {
					$marker['Marker']['subject'] = __('New Marker ID#',true).''.substr($marker['Marker']['id'], 0, 8);
					$marker['Marker']['descr'] = __('Not yet published',true);
				
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
				$marker['Marker']['subject'] = __('New Marker ID#',true).''.substr($marker['Marker']['id'], 0, 8);
				$marker['Marker']['descr'] = __('Not yet published',true);
			}
		}
		return $marker;
	}		
	
	
	function publishReadJson($marker){
		// Filter new unpublished Markers as "New marker #" if neccessary 
		if (!Configure::read('Publish.Markers')) {
			if ($marker[0]['Status']['id'] == 1) {
				$marker[0]['Marker']['subject'] = __('New Marker ID#',true).''.substr($marker[0]['Marker']['id'], 0, 8);
				$marker[0]['Marker']['descr'] = __('Not yet published',true);
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
        if ($this->find('first', array('conditions' => array($this->alias.'.user_id' => $userId, $this->primaryKey => $primaryKey), 'recursive' => -1)))			{
            return true;
        	}
        return false;
		}
	}



 	function cutWords ( $str = '', $maxWords = 1, $tail = '...' ) { 
      	$pattern = sprintf ( '/^((.+?\b){%s}).*/', 2 * $maxWords - 1 ); 		
		$newString = preg_replace ( $pattern, '$1', $str ); 
		return $newString != $str ? $newString . $tail : $str; 
	} 


?>