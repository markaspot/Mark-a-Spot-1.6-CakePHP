<?php
/**
 * Model for the AJAX star rating plugin.
 *
 * @author Michael Schneidt <michael.schneidt@arcor.de>
 * @copyright Copyright 2009, Michael Schneidt
 * @license http://www.opensource.org/licenses/mit-license.php
 * @link http://bakery.cakephp.org/articles/view/ajax-star-rating-plugin-1
 * @version 2.4
 */
class Rating extends Model {
  var $name = 'Rating';
  
  var $validate = array('user_id' => array('rule' => array('maxLength', 36),
                                           'required' => true),
                        'model_id' => array('rule' => array('maxLength', 36),
                                            'required' => true),
                        'model' => array('rule' => 'alphaNumeric',
                                         'required' => true));
}
?>