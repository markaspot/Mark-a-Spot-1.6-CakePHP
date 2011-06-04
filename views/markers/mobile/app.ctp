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
 * @copyright  2010 Holger Kreis <holger@markaspot.org>
 * @license    http://www.gnu.org/licenses/agpl-3.0.txt GNU Affero General Public License
 * @link       http://mark-a-spot.org/
 * @version    1.3 beta 
 */
echo $this->element('head_mobile');

?>
<div data-role="page" data-fullscreen="true" data-theme="b">
	<div data-role="header" data-position="fixed">
		<a data-role="button" data-icon="arrow-l" rel="external" href="/">Start</a><h1><?php __('Map') ?></h1>
	</div><!-- /header -->

	<div data-role="content">
		<div id="map_wrapper_xl"></div>
		<div id="moptions">
			<div id="views"></div>
		</div>
	</div>
</div>