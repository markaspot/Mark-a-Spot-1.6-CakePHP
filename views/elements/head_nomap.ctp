<?php
echo $this->Html->meta('Feed','/rss', array('inline' => false, 'type' => 'rss'));
echo $this->Html->css('styles', null, array('inline'=>false));


if (App::pluginPath('Configuration')) {
	echo $this->Html->script('/js/conf/index.js',false); 
}


echo $this->Html->script('http://ajax.googleapis.com/ajax/libs/jquery/1.4/jquery.min.js', false);
echo $this->Html->script('http://ajax.googleapis.com/ajax/libs/jqueryui/1.8/jquery-ui.min.js', false);
echo $this->Html->script('jquery/jquery.jeditable.min.js', false);
echo $this->Html->script('jquery/jquery.form.js', false);
echo $this->Html->script('jquery/jquery.cycle.lite.1.0.min.js', false);
echo $this->Html->script('jquery/fancybox/jquery.fancybox-1.3.1.pack.js', false);
echo $this->Html->script('jquery/jquery.tipTip.min', false);
echo $this->Html->script('/rating/js/rating_jquery.js',false); 
echo $this->Html->script('/voting/js/voting_jquery.js',false); 
echo $this->Html->script('common.js', false);


?>