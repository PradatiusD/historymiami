<?php

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

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


//* Add Post Thumbnails
add_theme_support( 'post-thumbnails' );

//* Unregister Header Right & Sidebar Widget Areas
unregister_sidebar( 'header-right' );
unregister_sidebar( 'sidebar-alt' );



//* Remove Post Meta (Example Filed under: )
remove_action('genesis_entry_footer', 'genesis_post_meta');

//* Unregister Secondary Navigation
add_theme_support('genesis-menus', array( 'primary' => __( 'Primary Navigation Menu', 'genesis')));

include_once("navigation.php");
include_once("utilities.php");
Utilities::local_livereload();

// Header Stylesheets
wp_enqueue_style( 'google-font', '//fast.fonts.net/cssapi/12c72165-1a50-4e78-97ed-8e1ee71db526.css',      array(), '1.0.0');
wp_enqueue_style('font-awesome', '//maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css', array(), '4.3.0');


function meta_imagery () {
  ?>
    <link rel="apple-touch-icon" href="<?php echo get_stylesheet_directory_uri();?>/images/apple-touch-icon.png" />
    <link rel="shortcut icon" href="<?php echo get_stylesheet_directory_uri();?>/favicon.ico" type="image/x-icon" />
  <?php
}

add_action('wp_head','meta_imagery');


add_filter( 'genesis_nav_items', 'be_follow_icons', 10, 2 );
add_filter( 'wp_nav_menu_items', 'be_follow_icons', 10, 2 );

function be_follow_icons($menu, $args) {
  if ($args->theme_location !== 'primary') {
    return $menu;
  }

  $providers = array(
    array("icon" => "facebook",    "url"  => "http://www.facebook.com/historymiami360"),     
    array("icon" => "twitter",     "url"  => "http://www.twitter.com/historymiami"),  
    array("icon" => "flickr",      "url"  => "http://www.flickr.com/photos/historymiami"),
    array("icon" => "youtube",     "url"  => "http://www.youtube.com/historymiami"),
    array("icon" => "foursquare",  "url"  => "http://foursquare.com/venue/1357011"),
    array("icon" => "tripadvisor", "url"  => "http://www.tripadvisor.com/Attraction_Review-g34438-d592101-Reviews-HistoryMiami-Miami_Florida.html")
  );


  $social = '';

  foreach ($providers as $provider) {
    $social .= '<li class="menu-item menu-item-type-custom menu-item-social menu-item-object-custom"><a><i class="fa fa-'.$provider["icon"].'"></i></a></li>';
  }

  return $menu . $social;
}



add_filter('genesis_footer_creds_text', 'sp_footer_creds_filter');
function sp_footer_creds_filter( $creds ) {
  $creds = '&copy; HistoryMiami. All rights reserved.';
  return $creds;
}


function museum_image() {
  $id = get_the_id();

  $thumb_id = get_post_thumbnail_id($id);

  if ($thumb_id &&  (is_page($id) || is_singular())) {
    $thumb_url_array = wp_get_attachment_image_src($thumb_id, 'full', true);
    $background_image = $thumb_url_array[0];
    echo "<div class=\"featured-image\" style=\"background-image:url(".$background_image.")\"></div>";    
  }
}

add_action('genesis_after_header','museum_image');
