<?php header('Content-type: text/html; charset=UTF-8') ;?>
<!DOCTYPE html>
<?php
if (Configure::Read('Social.FB') != false) {
	echo $facebook->html(); 
} else {
	echo '<html xmlns="http://www.w3.org/1999/xhtml">';
}?>
<head>
<?php echo $this->Html->charset();?>
<title><?php echo $title_for_layout?></title>
<link rel="shortcut icon" href="/favicon.ico" type="image/x-icon"/>
<!-- Include external files and scripts here (See HTML helper for more info.) -->
<?php echo $scripts_for_layout ?>
</head>
<body>
<?php    
if ($session->check('Message.flash')) {
	echo $session->flash();  
}
if ($session->check('Message.auth')) {
	echo $session->flash('auth');  
}
echo $content_for_layout;
?>

<?php 
/*
if (Configure::Read('Social.FB') != false) {
	echo $facebook->init(); 
}
*/
?>
</body>
</html>