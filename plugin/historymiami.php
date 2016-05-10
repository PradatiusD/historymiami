<?php
/**
 * Plugin Name: History Miami Custom Widgets
 * Plugin URI: http://github.com/PradatiusD/historymiami
 * Description: This plugin adds custom widgets to our wordpress.
 * Version: 1.0.0
 * Author: Daniel Prada
 * Author URI: http://github.com/PradatiusD
 * License: GPL2
 */

// Block direct requests
if ( !defined('ABSPATH') )
  die('-1');


class Address_Widget extends WP_Widget {
  function __construct() {
    parent::__construct(
      'Address_Widget', 'Museum Address', array( 'description' => 'The Address of HistoryMiami')
    );
  }
  
  function widget( $args, $instance ) {
    ob_start();?>
    <h4 class="widget-title">Address</h4>
    <address>
      HistoryMiami<br>
      101 West Flagler Street<br>
      Miami, FL 33130
    <address>
    <?php
    echo ob_get_clean();
  }
} 


class Contact_Widget extends WP_Widget {
  function __construct() {
    parent::__construct(
      'Contact_Widget', 'Museum Contact', array( 'description' => 'Contact Information for HistoryMiami')
    );
  }
  
  function widget( $args, $instance ) {
    ob_start();?>
    <h4 class="widget-title">Contact</h4>
    <a href="tel:3053751492">305-375-1492</a><br>
    <a href="mailto:e.info@historymiami.org"> e.info@historymiami.org</a>
    <?php
    echo ob_get_clean();
  }
} 


class Social_Widget extends WP_Widget {
  function __construct() {
    parent::__construct(
      'Social_Widget', 'Museum Social', array( 'description' => 'Social URLs for HistoryMiami')
    );
  }
  
  function widget( $args, $instance ) {
    ob_start();?>
    <h4 class="widget-title">Connect with Us</h4>
    <a href="http://www.facebook.com/historymiami360" target="_blank"><i class="fa fa-2x fa-facebook" aria-hidden="true"></i></a>
    <a href="http://www.twitter.com/historymiami" target="_blank"><i class="fa fa-2x fa-twitter" aria-hidden="true"></i></a>
    <a href="http://www.flickr.com/photos/historymiami" target="_blank"><i class="fa fa-2x fa-flickr" aria-hidden="true"></i></a>
    <a href="http://www.youtube.com/historymiami" target="_blank"><i class="fa fa-2x fa-youtube" aria-hidden="true"></i></a>
    <a href="http://foursquare.com/venue/1357011" target="_blank"><i class="fa fa-2x fa-foursquare" aria-hidden="true"></i></a>
    <a href="http://www.tripadvisor.com/Attraction_Review-g34438-d592101-Reviews-HistoryMiami-Miami_Florida.html" target="_blank"><i class="fa fa-2x fa-tripadvisor" aria-hidden="true"></i></a>
    <?php
    echo ob_get_clean();
  }
} 


class Affiliate_Widget extends WP_Widget {

  function __construct() {
    parent::__construct(
      'Affiliate_Widget', 'Museum Affiliate', array( 'description' => 'HistoryMiami Museum Affiliate Widgets')
    );
  }
  
  function widget( $args, $instance ) {
    ob_start();?>
    <h4 class="widget-title">Affiliates</h4>
    <img src="<?php echo get_stylesheet_directory_uri().'/images/logo_smithsonian.png';?>" class="img-responsive">
    <?php
    echo ob_get_clean();
  }
} 


function add_history_miami_widgets () {
  register_widget('Address_Widget');
  register_widget('Contact_Widget');
  register_widget('Social_Widget');
  register_widget('Affiliate_Widget');
}


add_action('widgets_init', 'add_history_miami_widgets');