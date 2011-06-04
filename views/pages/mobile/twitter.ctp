<?php 
/**
 * Mark-a-Spot Mobile Template (Page for additional information)
 *
 * 
 * Copyright (c) 2010 Holger Kreis
 * http://www.mark-a-spot.org
 *
 *
 * PHP version 5
 * CakePHP version 1.3
 *
 * @copyright  2010, 2011 Holger Kreis <holger@markaspot.org>
 * @link       http://mark-a-spot.org/
 * @version    1.5 beta 
 */
echo $this->element('head_mobile');

?>

<div data-role="page" data-theme="b" data-back-btn-text="Start" >
	<div data-role="header">
		<h1><?php __('Twitter Content') ?></h1>
	</div><!-- /header -->

	<div data-role="content">	
		<h2 id="h2_title"><?php __('Twitter Content') ?></h2>
		<ol>
			<li>Schreiben Sie einen Tweet mit Ihrem Beitrag und stellen Sie unseren Twitternamen <strong><?php echo Configure::read('Twitter.Screenname')?></strong> voran</li>
			<?php 
			// Geolocalistation
			if (Configure::read('Twitter.GeoMust')):{}?>
				<li>Wichtig, aktivieren Sie die Geolokalisierung!</li>
			<?php endif;?>
			<?php 
				// additional Hashtag
			if (Configure::read('Twitter.HashGet')):{}?>
				<li>Fügen Sie den Hasthag <?php echo Configure::read('Twitter.HashGet');?> an.</li>
			<?php endif;?>

			<li>Sie ein Foto hinzu und senden Sie den Tweet</li>
		</ol>
	</div><!-- /content -->
</div><!-- /page -->