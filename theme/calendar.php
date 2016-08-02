<?php 
/* Template Name: Calendar */ 

add_action('genesis_after_entry', 'output_post_data_json');
function output_post_data_json () {

$args = array(
  "post_type" => array('city-tour','event'),
  "nopaging"  => true,
  "orderby"   => "meta_value_num",
  "meta_key"  => "wpcf-start-time",
  "order"     => "ASC"
);

$post_query = new WP_Query($args);
$json       = array();

// The Loop
if ( $post_query->have_posts() ) {
  while ( $post_query->have_posts() ) {

    $post_query->the_post();

    $date_format = array("format"=>"U");

    $json_post = array(
      "title" => get_the_title(),
      "type"  => get_post_type(),
      "url"   => get_the_permalink(),
      "start" => types_render_field('start-time', $date_format),
      "end"   => types_render_field('end-time', $date_format)
    );

    array_push($json, $json_post);
  }

  wp_reset_postdata();
}

  echo "<script> var calendarData = ".json_encode($json).";</script>";
  echo "<div id=\"calendar\"></div>";
}

add_filter( 'genesis_pre_get_option_site_layout', '__genesis_return_full_width_content' );

$bower_base = get_stylesheet_directory_uri() . "/bower_components";

wp_enqueue_style('fullcalendar.css', $bower_base ."/fullcalendar/dist/fullcalendar.css", array(), '2.9.2', 'all' );
wp_enqueue_script('moment',          $bower_base ."/moment/min/moment.min.js", array(), '2.14.1', true);
wp_enqueue_script('fullcalendar.js', $bower_base ."/fullcalendar/dist/fullcalendar.min.js" , array('jquery', 'moment'), '2.9.2', true);
wp_enqueue_script('fullcalendar-client', get_stylesheet_directory_uri() . "/js/calendar.js" , array('fullcalendar.js'), '2.9.2', true);

genesis();

?>