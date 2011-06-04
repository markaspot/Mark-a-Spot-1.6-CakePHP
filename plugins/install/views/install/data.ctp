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
	<p>
    <?php
        echo $html->link(__('Click here to build your database', true), array(
            'plugin' => 'install',
            'controller' => 'install',
            'action' => 'data',
            'run' => 1,
        ), array('class' => 'button'));
    ?></p>
</div>