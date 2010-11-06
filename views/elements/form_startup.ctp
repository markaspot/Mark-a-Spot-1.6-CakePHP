<?php
echo $form->input('Marker.subject', array('div' => 'input text required', 'before' => __('<div>Enter a short subject</div>',true), 'maxlength'=>'128', 'label' => __('Subject',true)));
echo $form->input('Marker.street', array('div' => 'input text required', 'before' => __('<div>Enter address or drag marker</div>',true), 'label' => __('Address',true)));
echo $form->input('Marker.zip', array('div' => 'input text required', 'maxlength'=>'5', 'label' => __('Zip',true)));
// City Input can be disabled or not (it's not submitted, if disabled)
echo $form->input('Marker.city', array('div' => 'input text required', 'readonly' => true, 'label' => __('City',true)));

echo $form->input('Marker.descr', array('div' => 'input text', 'label' => __('Describe the situation',true)));
echo '<div id="addFormMedia"><a class="showLink" href="#addFormMedia">'.__('Add some images or media?', true).'</a>';
echo '<div id="addFormMediaDiv">';
echo $this->element('attachments', array('plugin' => 'media', 'model' => 'Marker'));
echo '</div>';
echo '</div>';	

echo $form->input('Marker.category_id',array('div' => 'input text required', 'before' => __('<div>Please take a look at the categories</div>',true), 'label' => __('Category',true), 'empty' => __('Please choose',true)));
//echo $form->input('Marker.status_id',array('label' => __('Status',true), 'disabled' => true));

if (!$session->read('Auth.User.id')) {
	echo $form->input('User.email_address',array('div' => 'input text required', 'label' => __('E-Mail',true), 'between'=>'<br/>', 'class'=>'text'));
	echo $form->input('User.nickname',array('div' => 'input text required', 'label' => __('Nickname',true), 'between'=>'<br/>', 'class'=>'text'));
	echo $form->input('User.password' ,array('div' => 'input text required', 'label' => __('Password',true), 'between'=>'<br/>', 'class'=>'text'));
	echo $form->input('User.passwd',array('div' => 'input text required', 'label' => __('Password Repeat',true), 'between'=>'<br/>', 'class'=>'text'));
	echo '<div id="addFormPersonals"><a class="showLink" href="#addFormPersonals">'.__('Want to tell us more about you?', true).'</a>';
	
	echo '<div id="addFormPersonalsDiv">';
	echo $form->input('Profile.sirname',array('label' => __('Sirname',true), 'between'=>'<br/>', 'class'=>'text'));
	echo $form->input('Profile.prename',array('label' => __('Name',true), 'between'=>'<br/>', 'class'=>'text'));
	echo $form->input('Profile.fon',array('label' => __('Phone',true), 'between'=>'<br/>', 'class'=>'text'));
	echo '</div>';	
	echo '</div>';	
	//echo $form->input('Profile.newsletter',array('div' => 'input text required', 'type' => 'checkbox', 'before' => __('<div>Newsletter?</div>',true),'label' => __('Newsletter?',true), 'between'=>'<br/>', 'class'=>'text'));	
	//echo $form->input('Profile.community',array('div' => 'input text required', 'type' => 'checkbox', 'before' => __('<div>Agree Community?</div>',true),'label' => __('agree',true), 'between'=>'<br/>', 'class'=>'text'));


	//$recaptcha->display_form('echo');

}
?>
	