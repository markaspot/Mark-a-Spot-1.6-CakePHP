<?php
/**
 * View for the AJAX star rating plugin.
 *
 * @author Michael Schneidt <michael.schneidt@arcor.de>
 * @copyright Copyright 2009, Michael Schneidt
 * @license http://www.opensource.org/licenses/mit-license.php
 * @link http://bakery.cakephp.org/articles/view/ajax-star-rating-plugin-1
 * @version 2.4
 */
?>
 
<?php
  // decision to enable or disable the rating
  $enable = ($session->check(Configure::read('Rating.sessionUserId')) // logged in user or guest
               || (Configure::read('Rating.guest') && $session->check('Rating.guest_id')))
             && !Configure::read('Rating.disable') // plugin is enabled
             && (Configure::read('Rating.allowChange') // changing is allowed or it's the first rating
                 || (!Configure::read('Rating.allowChange') && $data['%RATING%'] == 0));

  // the images are displayed here before js initialization to avoid flickering.
  echo $rating->stars($model, $id, $data, $options, $enable);
  
  // format the statusText and write it back
  $text = $rating->format(Configure::read('Rating.statusText'), $data);
  Configure::write('Rating.statusText', $text);
?>
<?
if (!$enable) {?>
	<div class="user-feedback">
		<?php //echo __('Thank you for voting', true);?>
	</div>
<?php }?>
<?php if (!$session->read('Auth.User.id') and !Configure::read('Rating.guest')) {?>
	<div class="user-feedback">
	<?php echo __('Your are guest and not allowed to vote here', true);?>
	</div>
<?php }?>

<div id="<?php echo $model.'_rating_'.$options['name'].'_'.$id.'_text'; ?>" class="<?php echo !empty($text) ? 'rating-text' : 'rating-notext'; ?>">
  <?php
    echo $text;
  ?>
</div>

<?php
  // initialize the rating element
  if (!Configure::read('Rating.disable')) {
    echo $javascript->codeBlock("ratingInit('".$model.'_rating_'.$options['name'].'_'.$id."', "
                                           ."'".addslashes(json_encode($data))."'," 
                                           ."'".addslashes(json_encode(Configure::read('Rating')))."',"
                                           ."'".addslashes(json_encode($options))."',"
                                           .intval($enable).");");
  }
?>

<?php if (Configure::read('Rating.fallback')): ?>
<noscript>
  <div class="fallback">
    <?php
      if ($enable) {
        // show fallback form
        echo $form->create('Rating', 
                           array('type' => 'get',
                                 'url' => array('action' => 'save')));
        echo $form->radio('value',
                          $rating->options(), 
                          array('legend' => false,
                                'id' => $model.'_rating_'.$options['name'].'_'.$id,
                                'value' => $data['%RATING%']));
        echo $form->hidden('model', array('value' => $model));
        echo $form->hidden('rating', array('value' => $id));
        echo $form->hidden('name', array('value' => $options['name']));
        echo $form->hidden('config', array('value' => $options['config']));
        echo $form->hidden('fallback', array('value' => true));
        echo $form->submit(__('Vote', true),
                           array('div' => false,
                                 'title' => __('Vote', true)));
        
        echo $form->end();
      }
    ?>
  </div>
  
  <?php
    // get mouseover messages for showing
    $mouseOverMessages = Configure::read('Rating.mouseOverMessages');
  ?>
  
  <?php // show login message
        if (!$enable && Configure::read('Rating.showMouseOverMessages')
            && !empty($mouseOverMessages['login'])
            && !Configure::read('Rating.disable')
            && $data['%RATING%'] == 0): ?>
    <div id="<?php echo $model.'_rating_'.$options['name'].'_'.$id.'_text'; ?>" class="<?php echo !empty($text) ? 'rating-text' : 'rating-notext'; ?>">
      <?php
        echo $mouseOverMessages['login'];
      ?>
    </div>
  <?php endif; ?>
  
  <?php // show rated message
        if (!$enable && Configure::read('Rating.showMouseOverMessages')
            && !empty($mouseOverMessages['rated'])
            && $data['%RATING%'] > 0): ?>
    <div id="<?php echo $model.'_rating_'.$options['name'].'_'.$id.'_text'; ?>" class="<?php echo !empty($text) ? 'rating-text' : 'rating-notext'; ?>">
      <?php
        echo $mouseOverMessages['rated'];
      ?>
    </div>
  <?php endif; ?>
</noscript>
<?php endif; ?>

<?php
  // show flash message
  if (Configure::read('Rating.flash')) {
    $session->flash('rating');
  }
  
  // debug sql dump
?>