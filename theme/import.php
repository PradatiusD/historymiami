<?php

include('../../../wp-load.php'); 

// SELECT title FROM plugin_events_events INTO OUTFILE '/Users/dprada/GitHub/historymiami/theme/events.csv' LINES TERMINATED BY '\n';

$events = file_get_contents('events.csv');
$events_array = explode("\n", $events);

foreach ($events_array as $event) {

  if ($event) {
    $e = array(
      'post_title'=> $event,
      'post_type'=> 'event',
      'post_status' => 'publish'
    );

    // wp_insert_post($e);
  }
}

?>