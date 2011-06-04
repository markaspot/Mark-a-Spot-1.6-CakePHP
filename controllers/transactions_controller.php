<?php
/**
 * Mark-a-Spot TransactionsController
 *
 * Log Transaction for Updates
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


class TransactionsController extends AppController {
    var $name = 'Transactions';
    //var $scaffold;
    
    
	/**
	 *
	 * delete by admin via ajax
	 *
	 */
	function delete($id = null) {
		$this->layout = 'ajax'; 
		
		if (!$id) {
			$this->Session->setFlash(__('Invalid id for Transaction', true));
			//$this->redirect(array('action'=>'index'));
		}
		
		if ($this->Transaction->delete($id)) {
			//$this->Session->setFlash(__('Comment deleted', true));
			$this->set('delete', 1);
		} else {
			$this->set('delete', 0);
		}
	}


}
?>