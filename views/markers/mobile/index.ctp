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

?>

<div data-role="page" id="start" data-theme="b">
	
<!--
	<div data-role="header">
		<h1><?php __('Welcome to Mas-City.com') ?></h1>
	</div>
-->

	<div data-role="content">	

		<?php 
		if ($session->check('Message.flash')) {
			echo $session->flash();  
		}
		if ($session->check('Message.auth')) {
			echo $session->flash('auth');  
		}
		
		?>
		<div id="head">
			<h1 id="logo"><span>Mark-a-Spot</span></h1>
			<p>Mobile Plattform für Bürgeranliegen in Mas-City</p>
		</div>		
		<ul data-role="listview" data-inset="true" data-theme="c" data-dividertheme="b">
			<li data-role="list-divider">Ansicht der Beiträge</li>
			<li><a href="/markers/liste">Liste</a></li>
			<li><a rel="external" href="/karte">Karte</a></li>
		</ul>
		<ul data-role="listview" data-inset="true" data-theme="c" data-dividertheme="b">
			<li data-role="list-divider">Teilnehmen</li>
			<li><a rel="external" href="startup">Hinzufügen</a></li>
			<li><a href="/seiten/twitter">Twitter-App nutzen</a> <span id="twitter"></span></li>
			<li data-role="list-divider">Bereits teilgenommen?</li>
			<?php
			if (!$session->read('Auth.User.id')) {
	
				echo '<li'.$html->link(__('Log in', true), array(
					'plugin' => null, 'controller' => 'users', 'action' => 'login'), array(
						'title' =>'', 'data-rel' => 'dialog', 'data-transition' => 'pop')
						
					);
			}	else {
			
				echo '<li'.$html->link(__('Log out', true), array(
					'plugin' => null, 'controller' => 'users', 'action' => 'logout'), array(
						'title' =>'')
						
					);
			}?>
		</ul>
		<ul data-role="listview" data-inset="true" data-theme="c" data-dividertheme="b">

			<li data-role="list-divider">Informationen</li>
			<li><a href="/seiten/faq">FAQ</a></li>
			<li><a href="/seiten/imprint">Impressum</a></li>

		</ul>
			<a data-role="button" data-rel="dialog" rel="external" href="/website" data-icon="gear" href="/">Website Ansicht</a>
	</div><!-- /content -->
</div><!-- /page -->

