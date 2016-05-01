<?php

//* Start the Genesis Engine
include_once( get_template_directory() . '/lib/init.php' );

//* Child theme (do not remove)
define( 'CHILD_THEME_NAME', 'History Miami Child Theme' );
define( 'CHILD_THEME_URL', 'http://github.com/PradatiusD/historymiami' );
define( 'CHILD_THEME_VERSION', '1.0.0' );


//* Add HTML5 markup structure
add_theme_support('html5', array('search-form','comment-form','comment-list'));

//* Add viewport meta tag for mobile browsers
add_theme_support('genesis-responsive-viewport');

//* Add support for custom background
add_theme_support('custom-background');

//* Add support for 3-column footer widgets
add_theme_support('genesis-footer-widgets', 4);

//* Remove Post Meta (Example Filed under: )
remove_action('genesis_entry_footer', 'genesis_post_meta');

//* Unregister Secondary Navigation
add_theme_support( 'genesis-menus', array( 'primary' => __( 'Primary Navigation Menu', 'genesis' ) ) );

include_once("navigation.php");
include_once("utilities.php");
Utilities::local_livereload();

// Header Stylesheets
wp_enqueue_style( 'google-font', '//fonts.googleapis.com/css?family=Lora:400,400italic,700,700italic',    array(), '1.0.0');
wp_enqueue_style('font-awesome', '//maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css', array(), '4.3.0');



add_filter('genesis_footer_creds_text', 'sp_footer_creds_filter');
function sp_footer_creds_filter( $creds ) {
  $creds = '&copy; HistoryMiami. All rights reserved.';
  return $creds;
}


function museum_image() {
  $has_thumbnail = is_single() && has_post_thumbnail() ? true: false;
  $background_image = '';

  if ($has_thumbnail) {
    $thumb_id = get_post_thumbnail_id();
    $thumb_url_array = wp_get_attachment_image_src($thumb_id, 'full', true);
    $background_image = $thumb_url_array[0];

  } else {
    $background_image = get_stylesheet_directory_uri().'/images/buidling-exterior.jpg';
  }
  ?>

  <div class="featured-image" <?php echo "style=\"background-image:url(".$background_image.")\""?> ></div>
  <?php
}

add_action('genesis_after_header','museum_image');
