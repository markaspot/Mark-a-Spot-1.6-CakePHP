<?php
  // decision to enable or disable the voting
  $enabled = ($session->check(Configure::read('Voting.sessionUserId') // user or guest is logged in
               || (Configure::read('Voting.guest') && $session->check('Voting.guest_id')))
             && !Configure::read('Voting.disable') // plugin is enabled
             && empty($vote)); // user has not voted yet
             $enabled = true;
?>
<div class="user-feedback">
<?
if (!$session->read('Auth.User.id') && !Configure::read('Voting.guest')) {
	echo __('Your are guest and not allowed to vote here', true);
}
?>
</div>
<?php foreach (Configure::read('Voting.options') as $nr => $option): ?>
 <div class="option<?php echo $enabled ? ' active' : '';?><?php echo $voting->isUserVote($nr, $vote) ? ' vote' : ''; ?> <?php echo ' '.$option['title'];?>">
    <?php // option image
      if (!Configure::read('Voting.showOptionTitles')) {
        $title = $option['title'];
      } else {
        $title = null;
      }
      
      echo $html->image($option['img'], 
                        array('alt' => $option['alt'],
                              'title' => $title));
    ?>

    <?php if (Configure::read('Voting.showOptionTitles')): ?>
      <div class="option-title">
        <?php // option title
          echo $option['title'];
        ?>
      </div>
    <?php endif; ?>
    
    <?php if (Configure::read('Voting.showOptionResults')): ?>
      <div class="option-result">
        <?php // option result
        
        // User may want to see results before voting
          
          
        //   if (!empty($result) && $enabled) {
			
		//if (!empty($result)) {
            echo $voting->format(Configure::read('Voting.optionResultText'), 
                                 $result,
                                 $option['wildcard']);
        //  }
        ?>
      </div>
    <?php endif; ?>
    
    <?php if (Configure::read('Voting.fallback')): ?>
      <noscript>
        <?php // fallback vote button
          if ($enabled) {
            /*
echo $html->link($form->button('Vote', array('type' => 'button')), 
                             array('controller' => 'votings',
                                   'action' => 'vote/'.$model.'/'.$id.'/'.$name.'/'.$config.'/'.$nr.'/true/?'.mt_rand()),
                             array('escape' => false,
                                   'class' => 'fallback'));
*/
          }
        ?>
      </noscript>
    <?php endif; ?>
  </div>
<?php endforeach; ?>

<?php if (Configure::read('Voting.flash')): ?>
  <div class="flash">
    <?php // flash message
      echo $session->flash($model.'_flash_'.$name.'_'.$id);
    ?>
  </div>
<?php endif; ?>

<?php if (Configure::read('Voting.showResult')): ?>
  <div class="result clear">
    <?php // voting result
      if (!empty($result)) {
        echo $voting->format(Configure::read('Voting.resultText'), $result);
      }
    ?>
  </div>
<?php else: ?>
  <div class="clear"></div>
<?php endif; ?>

<?php
  // initialize the voting element
  if ($enabled) {
    echo $javascript->codeBlock("votingInit('".$model."', '".$id."', '".$name."', '".$config."', '".$this->webroot."')");
  }
?>

<?php
  // debug sql dump
  //echo $this->element('sql_dump');
?>