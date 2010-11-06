<?php
		echo '<div>';
		echo '<h3>'.__('Search in Mas-City', true).'</h3>';
		echo '<div class="search">';
		echo $form->create('Search', array('url' => array(
			'plugin' => 'search', 
			'controller' => 'searches',
			'action' => 'index'
			)));
		echo '<fieldset>';
		echo $form->input('q', array('label' => __('Search', true),'div'=>false));
        echo $form->submit(__('search', true), array('class'=>'searchbutton','div'=> false));
		echo '</fieldset>';
		echo $form->end();
		echo '</div>';

		echo '</div>';
?>
