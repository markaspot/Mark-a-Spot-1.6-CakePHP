<?php
/**
 * Mark-a-Spot Marker Controller
 *
 * Everything about controlling markers
 *
 * Copyright (c) 2010 Holger Kreis
 * http://www.mark-a-spot.org
 *
 *
 * PHP version 5
 * CakePHP version 1.3
 *
 * @copyright  2010, 2011 Holger Kreis <holger@markaspot.org>
 * @license	http://www.gnu.org/licenses/agpl-3.0.txt GNU Affero General Public License
 * @link   	http://mark-a-spot.org/
 * @version	1.5.1 
 */

class ApiController extends AppController {

	var $name = 'Api';
	var $uses = array('Marker','User');
	var $helpers = array(
		'Session','Form', 'Rss', 'Html', 'Javascript', 'Time', 
			'Text', 'Xml', 'Datum', 'Htmlcleaner',
				'Media.Media' => array(
					'versions' => array(
					's', 'xl'
				)
			),
		'Csv','Cache'
		);
	
	
	var $components = array(
	
		'RequestHandler', 'Geocoder', 'Cookie', 'Notification', 'Transaction',
			
		/*
		 * Rest Plugin by KVZ load it as needed
		 *
		 *
		 */
		'Rest.Rest' => array(
			'catchredir' => false, // Recommended unless you implement something yourself

			'ratelimit' => null, array(
				'classlimits' => array(
					'Marker' => array('-1 hour', 100)
				),
			'	identfield' => 'apikey',
			'	ip_limit' => array('-1 hour', 60),  // For those not logged in
			),

			'view' => array(
				'extract' => array(
				'marker' => 'marker'),
			),

			'index' => array(
				'extract' => array(
					'markers' => 'markers'
				),
			),
			'log' => array(
				'model' => 'Rest.RestLog',
				'dump' => false, // Saves entire in + out dumps in log. Also see config/schema/rest_logs.sql
			),
			'debug' => 0,
		),
		
	);
	
	public function beforeFilter () {

		
		// Try to login user via REST
	
		if ($this->Rest->isActive()) {

			//$this->Auth->autoRedirect = false;
			$credentials = $this->Rest->credentials();
		
			$credentials["email_address"] = $credentials["username"];
			$credentials["password"] = $this->Auth->password($credentials["password"]);
			$this->Auth->fields = array('username' => 'email_address', 'password' => 'password');
			
			$success = $this->Auth->login($credentials);
			
			if (!$success) {
				$msg = sprintf('Unable to log you in with the supplied credentials. ');
				return $this->Rest->abort(array('status' => '401', 'error' => $msg));
			} 
			
			// Additionally Check API key 
			$apikey = "MasAPIkey";
			if ($apikey !== $credentials['apikey']) {
				$this->Auth->logout();
				$msg = sprintf('Invalid API key: "%s"', $credentials['apikey']);
				return $this->Rest->abort(array('status' => '401', 'error' => $msg));
			}
		}
		parent::beforeFilter();
	}

	
	/**
	* Shortcut so you can check in your Controllers wether
	* REST Component is currently active.
	*
	* Use it in your ->redirect() and ->flash() methods
	* to forward errors to REST with e.g. $this->Rest->error()
	*
	* @return boolean
	*/
	
	protected function _isRest() {
		return !empty($this->Rest) && is_object($this->Rest) && $this->Rest->isActive();
	}


	/**
	* Handle Geocoding and Files Uploaded
	*
	* @return array
	*/

	protected function _prepare($data) {

		if ($this->data['Marker']['zip'] != "") {

			$address  = $data['Marker']['street'];
			$address .= ' '.$data['Marker']['zip'];
			$address .= ' '.$data['Marker']['city'];
		}
		
		$latlng = $this->Geocoder->getLatLng($address);
		//$this->data['Marker']['id'] = $this->Marker->id;
		$this->data['Marker']['lat'] = $latlng['lat'];
		$this->data['Marker']['lon'] = $latlng['lng'];

		// If no user_id is given, set user_id with logged in Session posted by registered user
		if (!$this->data['Marker']['user_id']) {
			$this->data['Marker']['user_id'] = $this->Auth->user('id');
		}
		// If no status is given push marker to 1, as if posted by registered user
		
		if (!isset($this->data['Marker']['status_id'])) {
		
			$this->data['Marker']['status_id'] = 1;
		
		}

		$this->data['Marker']['feedback'] =  Configure::read('Publish.Feedback');
		
		if ($data['Marker']['attachment'] !=""){

			$this->data['Attachment'][0]['model'] = "Marker";
			$this->data['Attachment'][0]['group'] = "attachment";
			
			$tmpfname = tempnam("/tmp", "");
			$tmpfname = $tmpfname.".jpg";
			$handle = fopen($tmpfname, "w");

			fwrite($handle, base64_decode($data['Marker']['attachment']));
			$this->data['Attachment'][0]['file'] = $tmpfname;
			
			
			$exif = exif_read_data($handle);
			$ort = $exif['IFD0']['Orientation'];
				switch($ort)
				{
					case 1: // nothing
					break;
			
					case 2: // horizontal flip
						$image->flipImage($public,1);
					break;
											
					case 3: // 180 rotate left
						$image->rotateImage($public,180);
					break;
								
					case 4: // vertical flip
						$image->flipImage($public,2);
					break;
							
					case 5: // vertical flip + 90 rotate right
						$image->flipImage($public, 2);
							$image->rotateImage($public, -90);
					break;
							
					case 6: // 90 rotate right
						$image->rotateImage($public, -90);
					break;
							
					case 7: // horizontal flip + 90 rotate right
						$image->flipImage($public,1);	
						$image->rotateImage($public, -90);
					break;
							
					case 8:	// 90 rotate left
						$image->rotateImage($public, 90);
					break;
				}
		}
		
		return $this->data;
	}
	
	public function redirect($url, $status = null, $exit = true) {
		
		if ($this->_isRest()) {
			// Just don't redirect.. Let REST die gracefully
			// Do set the HTTP code though
			parent::redirect(null, $status, false);
			$this->Rest->abort(compact('url', 'status', 'exit'));
		}
		parent::redirect($url, $status, $exit);
	}
	
	

	function index() {
		// define markers by role later, this one for readonly user level
		$markers = $this->Marker->find('all',array( 
			'contain' => array('Category','Status','Attachment', 'User'),
			'fields' => array('Marker.id', 'Marker.subject', 'Marker.street','Marker.zip','Marker.city',
					'Marker.status_id', 'Marker.description', 'Marker.lat', 'Marker.lon',
						'Marker.rating', 'Marker.votes', 'Marker.created', 'Marker.modified', 'Category.name',
							'Status.id', 'Status.name', 'Category.hex', 'Status.hex', 'User.nickname'),
			'order' => 'Marker.modified DESC')
			);
			
		
		$this->set(compact('markers'));
	}

	function view($id) {
		$marker = $this->Marker->findById($id);
		$this->set(compact('marker'));
	}

	function edit($id) {	
		if (isset($this->data)){
			$this->_prepare($this->data);
		} else {
			die();
		}
		$this->Marker->id = $id; 

		
		if ($this->Marker->save($this->data)) {

			$this->Transaction->log($this->data['Marker']['id']);
			
			$message = array(
				'success' => true,
				'message' => __('The marker marker has been updated.', true));
			$this->Rest->info($message);
			
		} else {
			// get errors from  model
			
			$errors = $this->Marker->invalidFields();
			
			// $this->Rest->error($response);
			// As long as jquery does not support responseText on error header (400)
			// we have to distinguish between ajax requests and normal curl requests
			
			if ($this->RequestHandler->isAjax()) {
				return $this->Rest->error($response);
			} else {
				return $this->Rest->abort(array('status' => '400', 'error' => $errors));

			}

		}

		$this->set(compact("message"));
	}


	function add() {
		if (isset($this->data)){
			$this->_prepare($this->data);
		} else {
			die();
		}
		if ($this->Marker->saveAll($this->data)) {
			
			$id = $this->Marker->id;
			// Now read E-Mail Adress which is assigned to category (just saved in form)
			$categoryId = $this->data['Marker']['category_id'];
			
			$categoryUserId = $this->Marker->Category->read(array('user_id'),$categoryId);
			$catUserId = $categoryUserId['Category']['user_id'];
			
			if ($catUserId != ""){
				$recipient = $this->User->field('email_address',array('id =' => $catUserId));
			} else {
				$stringOfAdmins = implode(',', $this->_getAdminMail());
				$recipient = $stringOfAdmins;
			}

			//
			// call Notification Component and send mail to all Admins
			//

			$nickname = "Iphone App User";

			$cc[] = "";
			$this->Notification->sendMessage("markerinfoadmin",$id, $nickname, $recipient,$cc);
				
			// create object for ReST Response
			$response = array(
				'success' => true,
				'message' => 	sprintf(__('The Marker ID# %s has been saved.',true),
				substr($id, 0, 8)),
			);
			$this->Rest->info($response);

			$this->Transaction->log($id);

			
			
		} else {
		
			// get errors from  model
			$errors = $this->Marker->invalidFields();
			
			// create object for ReST Response
			$response = array(
				'success' => false,
				'message' => $errors,
			);
			
			// $this->Rest->error($response);
			// As long as jquery does not support responseText on error header (400)
			// we have to distinguish between ajax requests and normal curl requests
			
			if ($this->RequestHandler->isAjax()) {
				return $this->Rest->error($response);
			} else {
				return $this->Rest->abort(array('status' => '400', 'error' => $errors));

			}
			
		}
	

	} 



	function delete($id) {
		if($this->Marker->delete($id, $cascade = true)) {

			$message = array(
				'message' => __('Marker deleted.', true));
			$this->Rest->info($message);
			
		} else {
		
			$errors = "MarkerId not valid";

			return $this->Rest->abort(array('status' => '400', 'error' => $errors));
		}
	}
	
} 
?>
