<?php echo $this->element('head_nomap', array('cache'=> 3600));?>

<?php		
	echo '<div id="breadcrumb"><div>';
	$html->addcrumb(
		 __('Home', true),
			'/',
			array('escape'=>false)
		);

	$html->addcrumb(
		__('Installation', true),
		array(
		'admin' => true,
		'plugin' => 'install',
		'controller' => 'install',
		'action' => $this->action)
	);
	echo $html->getCrumbs(' / ');
	echo '</div>';
		
	echo '</div>';

?>
	<div id="content" class="full install">
    <h2><?php echo $title_for_layout; ?></h2>

    <p>Login: <?php echo $html->link(Router::url('/admin', true), Router::url('/admin', true)); ?></p>
    <p>Username: sysadmin@markaspot.org</p>
    <p>Password: test123</p>

    <p>Delete the installation directory <strong>/app/plugins/install</strong>.</p>

    <br />
    <br />

    <?php
        echo $html->link(__('Click here to delete installation files', true), array(
            'plugin' => 'install',
            'controller' => 'install',
            'action' => 'finish',
            'delete' => 1,
        ), array('class' => 'button orange'));
    ?>
</div>