<?php
/**
 * Helper for the AJAX star rating plugin.
 *
 * @author Michael Schneidt <michael.schneidt@arcor.de>
 * @copyright Copyright 2009, Michael Schneidt
 * @license http://www.opensource.org/licenses/mit-license.php
 * @link http://bakery.cakephp.org/articles/view/ajax-star-rating-plugin-1
 * @version 2.4
 */
class RatingHelper extends AppHelper {
  var $helpers = array('Html', 'Form', 'Session');

  /**
   * Creates the stars for a rating.
   *
   * @param string $model Model name
   * @param integer $id Model id
   * @param array $data Rating data
   * @param array $options Options
   * @param boolean $enable Enable element
   * @return Stars as HTML images
   */
  function stars($model, $id, $data, $options, $enable) {
    $output = '';
    $starImage = Configure::read('Rating.starEmptyImageLocation');
    
    if (Configure::read('Rating.showUserRatingStars')) {
      $stars = $data['%RATING%'];
    } else {
      $stars = $data['%AVG%'];
    }
    
    for ($i = 1; $i <= $data['%MAX%']; $i++) {
      if ($i <= floor($stars)) {
        $starImage = Configure::read('Rating.starFullImageLocation');
      } else if ($i == floor($stars) + 1 && preg_match('/[0-9]\.[5-9]/', $stars)) {
        $starImage = Configure::read('Rating.starHalfImageLocation');
      } else {
        $starImage = Configure::read('Rating.starEmptyImageLocation');
      }
      
      if (Configure::read('Rating.showUserRatingMark') && $i <= $data['%RATING%']) {
        $class = 'rating-user';
      } else {
        $class = 'rating';
      }
      
      if (!$enable) {
        $class .= '-disabled';
      }
      
      $htmlImage = $this->Html->image('/'.$starImage, 
                                      array('class' => $class,
                                            'id' => $model.'_rating_'.$options['name'].'_'.$id.'_'.$i,
                                            'alt' => __('Rate it with ', true).$i));

      if (Configure::read('Rating.fallback')) {
        $output .= $this->Form->label($model.'.rating', 
                                      $htmlImage, 
                                      array('for' => $model.'Rating'.ucfirst($options['name']).$id.$i,
                                            'class' => 'fallback'));
      } else {
        $output .= $htmlImage;
      }
    }

    return $output;
  }
  
  /**
   * Formats a text in replacing data wildcards.
   *
   * @param string $text
   * @param array $data
   * @return Formatted text
   */
  function format($text, $data) {
    foreach ($data as $wildcard => $value) {
      $text = str_replace($wildcard, $value, $text);
    }
    
    // fix lost blanks in js (excluding blanks between html tags)
    $text = preg_replace('/(?!(?:[^<]+>|[^>]+<\/(.*)>))( )/', '&nbsp;', $text);
    
    return $text;
  }
  
  /**
   * Creates options for fallback radio buttons.
   * 
   * @return Radio options
   */
  function options() {
    $options = array();
    
    if (Configure::read('Rating.showMouseOverMessages')) {
      $options = Configure::read('Rating.mouseOverMessages');
      unset($options['login'], $options['rated'], $options['delete']);
    } else {
      $options = range(0, Configure::read('Rating.maxRating'));
      unset($options[0]);
    }
    
    return $options;
  }
}
?>