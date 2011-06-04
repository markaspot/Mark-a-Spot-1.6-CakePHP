<?php 
/**
 * Mark-a-Spot Startup form (Signup and Add)
 *
 * 
 * Copyright (c) 2010 Holger Kreis
 * http://www.mark-a-spot.org
 *
 *
 * PHP version 5
 * CakePHP version 1.2
 *
 * @copyright  2010, 2011 Holger Kreis <holger@markaspot.org>
 * @link       http://mark-a-spot.org/
 * @version    1.3 beta 
 */
echo $this->element('head_mobile');
echo $javascript->link('jquery/jquery.validation.min.js', false); 

?>

<div data-role="page" data-theme="b" data-back-btn-text="Start" >
	<div data-role="header">
		<h1><?php __('Add a marker') ?></h1>
	</div><!-- /header -->

	<div data-role="content">	
	
		<div id="content">
			<h2 id="h2_title">Imprint</h2>
			<hr class="hidden"/>
			<div id="details">This is just a placeholder.Header-Photo: fotos4people / photocase.com</div>
		</div>
	</div><!-- /content -->
</div><!-- /page -->
	<div data-role="footer">
		<p><a href="#profile">Persönliche Angaben</a></p>	

	</div><!-- /header -->
