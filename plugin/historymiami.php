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

    $icons = array(
      array("icon" => "facebook",    "url"  => "http://www.facebook.com/historymiami360"),     
      array("icon" => "twitter",     "url"  => "http://www.twitter.com/historymiami"),  
      array("icon" => "instagram",   "url"  => "https://www.instagram.com/historymiami/"),
      array("icon" => "flickr",      "url"  => "http://www.flickr.com/photos/historymiami"),
      array("icon" => "youtube",     "url"  => "http://www.youtube.com/historymiami"),
      array("icon" => "foursquare",  "url"  => "http://foursquare.com/venue/1357011"),
      array("icon" => "tripadvisor", "url"  => "http://www.tripadvisor.com/Attraction_Review-g34438-d592101-Reviews-HistoryMiami-Miami_Florida.html")
    );

    ob_start();?>
    <h4 class="widget-title">Connect with Us</h4>
      <?php foreach ($icons as $icon):?>
          <a target="_blank" href="<?php echo $icon['url'];?>">
            <i class="fa fa-<?php echo $icon['icon'];?>" aria-hidden="true"></i>
          </a>
      <?php endforeach;?>

    <?php
    echo ob_get_clean();
  }
} 


class Affiliate_Widget extends WP_Widget {

  function __construct() {
    parent::__construct(
      'Affiliate_Widget', 'Museum Affiliate', array( 'description' => 'HistoryMiami Museum Affiliate Widget')
    );
  }
  
  function widget( $args, $instance ) {
    ob_start();?>
    <h4 class="widget-title">Affiliates</h4>
    <img src="<?php echo get_stylesheet_directory_uri().'/images/smithsonian-logo.png';?>" class="img-responsive">
    <?php
    echo ob_get_clean();
  }
}

class Instagram_Widget extends WP_Widget {
  function __construct() {
    parent::__construct(
      'Instagram_Widget', 'Instagram Feed', array('description' => 'Instagram Feed for HistoryMiami')
    );
  }
  
  function widget( $args, $instance ) {
    $base = plugin_dir_url( __FILE__ );
    wp_enqueue_script('instafeed', $base."bower_components/instafeed.js/instafeed.min.js", array('jquery'), '1.0.0', true);
    wp_enqueue_script('instafeed-client', $base."js/instagram-client.js", array('instafeed'), '1.0.0', true);
    ob_start();
  ?>
    <h4 class="widget-title">
      From <a href="https://www.instagram.com/historymiami/" target="_blank">@HistoryMiami</a> on <i class="fa fa-instagram"></i>
    </h4>
    <div id="instafeed"></div>
    
    <?php
    echo ob_get_clean();
  } 
}


function add_history_miami_widgets () {
  register_widget('Address_Widget');
  register_widget('Contact_Widget');
  register_widget('Social_Widget');
  register_widget('Affiliate_Widget');
  register_widget('Instagram_Widget');
}


add_action('widgets_init', 'add_history_miami_widgets');