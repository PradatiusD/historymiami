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


wp_enqueue_style( 'google-font', 'https://fonts.googleapis.com/css?family=Lora:400,400italic,700,700italic', array(), '1.0.0', true );