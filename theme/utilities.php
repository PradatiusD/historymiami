<?php

class Utilities {

  public static $custom_post_types  = array('exhibition','event','city-tour');
  public static $availability_types =  array('past','current','upcoming');
 
  public static function local_livereload () {

    if (in_array($_SERVER['REMOTE_ADDR'], array('127.0.0.1', '::1'))) {
      // For Debugging on Localhost
      ini_set('display_errors', 1);
      ini_set('display_startup_errors', 1);
      error_reporting(E_ALL);
      
      // For live reloading
      function local_livereload() {
        wp_register_script('livereload', 'http://localhost:35729/livereload.js', null, false, true);
        wp_enqueue_script('livereload');    
      }
      add_action( 'wp_enqueue_scripts', 'local_livereload');
    }  
  }


  public static function format_date_text($start_time, $end_time) {

    $start_t = new DateTime();
    $start_t->setTimestamp($start_time);

    $end_t   = new DateTime();
    $end_t->setTimestamp($end_time);

    $calendar_f = 'Y-m-d';

    $same_day = ($start_t->format($calendar_f) == $end_t->format($calendar_f));

    if ($same_day) {
      return $start_t->format('l M j, Y g:i A') . " - " . $end_t->format('g:i A');
    } else {
      return $start_t->format('l M j, Y') . " - " . $end_t->format('l M j, Y');
    }
  }


  public static function get_timestamp () {
    $today = date_create();
    $timestamp = date_timestamp_get($today);
    return $timestamp;
  }


  public static function get_post_dates () {

    $date_format = array(
      "output"=>"raw",
    );

    $start_time = types_render_field("start-time",$date_format);
    $end_time   = types_render_field("end-time",$date_format);

    return self::format_date_text($start_time, $end_time);
  }

  public static function split_post_title ($post_title) {

    $colon_pos = strpos($post_title, ':');
    $output    = array();

    if ($colon_pos !== false) {
      $output["title"] = substr($post_title, 0, $colon_pos);
      $output["subtitle"] = substr($post_title, $colon_pos + 1, strlen($post_title));
    } else {
      $output["title"] = $post_title;
    }

    return $output;
  }
}