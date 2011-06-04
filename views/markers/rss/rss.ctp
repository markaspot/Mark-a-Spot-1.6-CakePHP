<?php header('Content-type: text/xml'); ?> 
<?php
function transform_rss($markers) {
    return array(
      'title' => $markers['Marker']['subject'],
      'link'  => array('action' => 'view', $markers['Marker']['id']),
      'guid'  => array('action' => 'view', $markers['Marker']['id']),
      'description' => 'Wo: '.$markers['Marker']['street'].', '.$markers['Marker']['zip'].' '.$markers['Marker']['city'].'<br/>Was: '.$markers['Marker']['description'].'<br/>Was ist passiert: '.$markers['Transaction'][0]['name'],
      'author' => "Mark-a-Spot",
      'pubDate' => $markers['Marker']['modified']
    );
  }
  echo $rss->items($markers, 'transform_rss');   
?>