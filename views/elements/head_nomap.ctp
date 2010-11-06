<?php
echo $html->meta('Feed','/rss', array('inline' => false, 'type' => 'rss'));
echo $html->css('styles', null, array('inline'=>false));


echo $javascript->link('http://ajax.googleapis.com/ajax/libs/jquery/1.4/jquery.min.js', false);
echo $javascript->link('http://ajax.googleapis.com/ajax/libs/jqueryui/1.8/jquery-ui.min.js', false);
echo $javascript->link('jquery/jquery.form.js', false);
echo $javascript->link('jquery/jquery.cycle.lite.1.0.min.js', false);
echo $javascript->link('jquery/fancybox/jquery.fancybox-1.3.1.pack.js', false);
echo $javascript->link('jquery/jquery.tipTip.min', false);
echo $javascript->link('/rating/js/rating_jquery.js',false); 
echo $javascript->link('/voting/js/voting_jquery.js',false); 
echo $javascript->link('common.js', false);


?>