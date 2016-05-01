<?php

class Utilities {
 
  public static function local_livereload () {

    if (in_array($_SERVER['REMOTE_ADDR'], array('127.0.0.1', '::1'))) {
      // For Debugging on Localhost
      error_reporting(E_ALL);
      ini_set('display_errors', 1);
      
      // For live reloading
      function local_livereload() {
        wp_register_script('livereload', 'http://localhost:35729/livereload.js', null, false, true);
        wp_enqueue_script('livereload');    
      }
      add_action( 'wp_enqueue_scripts', 'local_livereload');
    }  
  } 
}