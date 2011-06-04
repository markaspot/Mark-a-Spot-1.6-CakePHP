<?php
		if (isset($this->params['pass'][0])) {
			echo $form->input('Marker.id', array("type" => "hidden","value" => $this->params['pass'][0]));
		}
		
		echo $form->input('Marker.subject', array('div' => 'input text required', 'before' => __('<div>Enter a short subject</div>',true), 'maxlength'=>'128', 'label' => __('Subject',true)));
		echo $form->input('Marker.street', array('div' => 'input text required', 'before' => __('<div>Enter address or drag marker</div>',true), 'label' => __('Address',true)));
		echo $form->input('Marker.zip', array(
			'div' => 'input text required', 'maxlength'=>'5', 'label' => __('Zip',true)));
		echo $form->input('Marker.city', array(
			'div' => 'input text required', 'readonly' => true, 'label' => __('City',true)));
		echo $form->input('Marker.description', array(
			'div' => 'input text', 'label' => __('Describe the situation',true)));
		echo $form->input('Marker.category_id',array(
			'div' => 'input text required', 'before' => __('<div>Please take a look at the categories</div>',true), 'label' => __('Category',true), 'empty' => __('Please choose',true)));
		
		echo '<div id="addFormMedia"><a class="showLink" href="#addFormMedia">'.__('Add some images or media?', true).'</a>';
		echo '<div id="addFormMediaDiv">';
		echo $this->element('attachments', array('plugin' => 'media', 'model' => 'Marker'));
		echo '</div>';
		echo '</div>';	

//echo $form->input('Marker.status_id',array('label' => __('Status',true), 'disabled' => true));
?>