
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
	<div data-role="content">	
			<h2 id="h2_title">Mark-a-Spot kann auch in der normalen Ansicht bedient und angesehen werden</h2>
			<a data-role="button" data-rel="dialog" rel="external" href="/website" data-icon="gear" href="/">Website Ansicht</a>

			<a href="http://maslocal/website" target="top" data-role="button" data-theme="b">Zur Website Ansicht wechseln</a>
			<a href="#" data-role="button" data-theme="b">close</a>

	</div><!-- /content -->
</div><!-- /page -->