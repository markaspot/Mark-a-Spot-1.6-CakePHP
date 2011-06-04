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
    <?php
        echo $form->create('Install', array('url' => array('plugin' => 'install', 'controller' => 'install', 'action' => 'database')));
        echo $form->input('Install.driver', array(
            'label' => 'Driver',
            'value' => 'mysql',
            'empty' => false,
            'options' => array(
                'mysql' => 'mysql',
                'mysqli' => 'mysqli',
                'sqlite' => 'sqlite',
                'postgres' => 'postgres',
                'mssql' => 'mssql',
                'db2' => 'db2',
                'oracle' => 'oracle',
                'firebird' => 'firebird',
                'sybase' => 'sybase',
                'odbc' => 'odbc',
            ),
        ));
        //echo $form->input('Install.driver', array('label' => 'Driver', 'value' => 'mysql'));
        echo $form->input('Install.host', array('label' => 'Host', 'value' => 'localhost'));
        echo $form->input('Install.login', array('label' => 'User / Login', 'value' => 'root'));
        echo $form->input('Install.password', array('label' => 'Password'));
        echo $form->input('Install.database', array('label' => 'Name', 'value' => 'markaspot'));
        echo $form->input('Install.port', array('label' => 'Port (leave blank if unknown)'));
        echo $form->end('Submit');
    ?>
</div>