<?php
  // default name
  if (empty($name)) {
    $name = 'default';
  }
  
  // default config
  if (empty($config)) {
    $config = 'plugin_voting';
  }
  
  // store overloaded config settings
  if (is_array($config)) {
    $key = array_shift(array_keys($config));
    Configure::write($model.'_'.$name.'_'.$id, $config[$key]);
    $config = $key;
  }
?>

<?php if (!empty($title)): ?>
  <div class="voting-title">
    <?php echo $title; ?>
  </div>
<?php endif; ?>

<div id="<?php echo $model.'_voting_'.$name.'_'.$id; ?>" class="voting">
  <?php
    echo $this->requestAction('voting/votings/view/'.$model.'/'.$id.'/'.$name.'/'.$config, array('return'));
  ?>
</div>