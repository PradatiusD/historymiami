<?php

$connection = mysqli_connect('127.0.0.1','root','password', 'history_miami_fastspot');
$query      = 'SELECT start_date, start_time, end_date, end_time, title, location, description, image FROM plugin_events_events';
$result     = mysqli_query($connection, $query);

$rows = array();
while($r = mysqli_fetch_assoc($result)) {
    $rows[] = $r;
}

mysqli_close($connection);

include('../../../wp-load.php'); 

foreach ($rows as $event) {

  if ($event) {
    $e = array(
      'post_title'=> $event["title"],
      'post_type'=> 'event',
      'post_status' => 'publish',
      'post_content' => $event["description"],
      'post_date' =>  $event["start_date"]
    );

    // print_r($event);
    // wp_insert_post($e);
  }
}

?>
