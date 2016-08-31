<?php

//* Start the Genesis Engine
include_once(get_template_directory() . '/lib/init.php' );

//* Child theme (do not remove)
define('CHILD_THEME_NAME', 'History Miami Child Theme');
define('CHILD_THEME_URL', 'http://github.com/PradatiusD/historymiami');
define('CHILD_THEME_VERSION', '1.0.11');


//* Add HTML5 markup structure
add_theme_support('html5', array('search-form','comment-form','comment-list'));

//* Add viewport meta tag for mobile browsers
add_theme_support('genesis-responsive-viewport');

//* Add support for custom background
add_theme_support('custom-background');

//* Add support for 3-column footer widgets
add_theme_support('genesis-footer-widgets', 4);

//* Add Post Thumbnails
add_theme_support('post-thumbnails');

//* Unregister Header Right & Sidebar Widget Areas
unregister_sidebar('header-right');
unregister_sidebar('sidebar-alt');

//* Remove Post Meta (Example Filed under: )
remove_action('genesis_entry_footer', 'genesis_post_meta');

//* Unregister Secondary Navigation
add_theme_support('genesis-menus', array( 'primary' => __( 'Primary Navigation Menu', 'genesis')));

include_once("navigation.php");
include_once("utilities.php");
include_once("admin-extensions.php");
Utilities::local_livereload();

// Header Stylesheets
wp_enqueue_style( 'fonts.com',   '//fast.fonts.net/cssapi/12c72165-1a50-4e78-97ed-8e1ee71db526.css',      array(), '1.1.1');
wp_enqueue_style('font-awesome', '//maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css', array(), '4.3.0');

// Footer Javascripts
$bower_base = get_stylesheet_directory_uri(). "/bower_components";

wp_enqueue_script('bootstrap3-typeahead', $bower_base. "/bootstrap3-typeahead/bootstrap3-typeahead.min.js", array('jquery'), '1.0.0', true);
wp_enqueue_script('bootstrap-modal', $bower_base. "/bootstrap-sass/assets/javascripts/bootstrap/modal.js", array('jquery'), '1.0.0', true);
wp_enqueue_script('search-bar', get_stylesheet_directory_uri(). "/js/search.js", array('jquery','bootstrap-modal','bootstrap3-typeahead'), '1.0.0', true);


if (gethostname() == "Daniels-MacBook-Pro.local") {
  wp_enqueue_script('local-utils', get_stylesheet_directory_uri(). "/js/utils.js", array('jquery'), '1.0.0', true);
}


function meta_imagery () {
  ?>
    <link rel="apple-touch-icon" href="<?php echo get_stylesheet_directory_uri();?>/images/apple-touch-icon.png" />
    <link rel="shortcut icon" href="<?php echo get_stylesheet_directory_uri();?>/favicon.ico" type="image/x-icon" />
  <?php
}

add_action('wp_head','meta_imagery');

add_action('wp_footer','bootstrap_modal');
function bootstrap_modal () {
 ?>

<!-- Search Input Modal -->
<div class="modal fade" id="search-model" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title">Search The HistoryMiami Website</h4>
      </div>
      <div class="modal-body">
        <input id="search-input" type="text" class="form-control input-lg" autocomplete="off">
      </div>
    </div>
  </div>
</div>

 <?php
}


add_filter( 'genesis_nav_items', 'be_follow_icons', 10, 2 );
add_filter( 'wp_nav_menu_items', 'be_follow_icons', 10, 2 );

function be_follow_icons($menu, $args) {
  if ($args->theme_location !== 'primary') {
    return $menu;
  }

  $providers = array(
    array("icon" => "search",      "url"  => "#", "id" => "global_search"),
    array("icon" => "facebook",    "url"  => "http://www.facebook.com/historymiami360"),     
    array("icon" => "twitter",     "url"  => "http://www.twitter.com/historymiami"),  
    array("icon" => "instagram",   "url"  => "https://www.instagram.com/historymiami/")
 );

  $social = '';

  foreach ($providers as $provider) {
    $id = isset($provider["id"]) ? "id=".$provider["id"]:"";
    $social .= '<li class="menu-item menu-item-type-custom menu-item-social menu-item-object-custom">';
    $social .=   '<a href="'. $provider["url"].'" target="_blank"'.$id.'>';
    $social .=     '<i class="fa fa-'.$provider["icon"].'"></i></a></li>';
  }

  return $menu . $social;
}


add_filter('genesis_footer_creds_text', 'sp_footer_creds_filter');
function sp_footer_creds_filter( $creds ) {
  $creds = '&copy; HistoryMiami. All rights reserved.';
  return $creds;
}


add_action('genesis_after_header','museum_image');
function museum_image() {
  $id = get_the_id();

  $thumb_id = get_post_thumbnail_id($id);

  if ($thumb_id &&  (is_page($id) || is_singular())) {
    $thumb_url_array = wp_get_attachment_image_src($thumb_id, 'full', true);
    $background_image = $thumb_url_array[0];
    echo "<div class=\"featured-image\" style=\"background-image:url(".$background_image.")\"></div>";    
  }
}


add_filter( 'genesis_post_info', 'sp_post_info_filter' );
function sp_post_info_filter($post_info) {
  if ( !is_page()) {

    $post_types = Utilities::$custom_post_types;
    $post_type  = get_post_type();
    $post_info  = '';

    if (in_array($post_type, $post_types)) {
      $post_info .= Utilities::get_post_dates();
    } else {
      $post_info = '[post_date]';
    }

    $post_info .= " [post_edit]";

    return $post_info;
  }
}


remove_action( 'genesis_entry_header', 'genesis_do_post_title' );
add_action( 'genesis_entry_header', 'genesis_do_post_title_with_image');
function genesis_do_post_title_with_image () {

  ob_start();
  genesis_do_post_title();
  $post_title = ob_get_clean();

  if (is_archive() && has_post_thumbnail()) {
    $search = "entry-title";
    $replace = $search . '" style="background-image: url(\''. get_the_post_thumbnail_url(). '\')';
    $post_title = str_replace("entry-title", $replace, $post_title);
  }

  $pattern = "/<a.*>(.*?)<\/a>/";
  preg_match($pattern, $post_title, $matches);

  if (sizeof($matches) > 0) {
    $title = $matches[1];
    $title = Utilities::split_post_title($title);

    $split_title = '';

    $split_title .= '<a href="'.get_the_permalink().'" rel="bookmark"><span class="title">'.$title["title"].'</span>';
    if (isset($title["subtitle"])) {
      $split_title .= '<span class="subtitle">'.$title["subtitle"].'</span></a>';
    }

    $post_title = preg_replace($pattern, $split_title, $post_title);
  }

  echo $post_title;
}


add_filter('pre_get_posts', 'available_post_type');
function available_post_type ($query) {

  $query_has_type = isset($query->query_vars["post_type"]);

  if (!is_main_query() || !$query_has_type) {
    return $query;
  }

  $post_types        = Utilities::$custom_post_types;
  $queried_type      = $query->query_vars["post_type"];
  $is_target_archive = is_archive() && isset($queried_type) && in_array($queried_type, $post_types);
  $has_query_string  = isset($_GET['t']) && in_array($_GET['t'], Utilities::$availability_types);

  if ($is_target_archive && !is_admin()) {

    $timestamp = Utilities::get_timestamp();
    $filter = array();

    if ($has_query_string) {

      $t = $_GET['t'];

      if ($t == 'past') {
        array_push($filter, array(
          'key' => 'wpcf-end-time', 
          'value' => $timestamp, 
          'compare' => '<',
        ));

      } else if ($t == 'current') {

        array_push($filter, array(
          'key' => 'wpcf-start-time', 
          'value' => $timestamp, 
          'compare' => '<=',
        ));

        array_push($filter, array(
          'key' => 'wpcf-end-time', 
          'value' => $timestamp, 
          'compare' => '>=',
        ));

      } else if ($t == 'upcoming') {

        array_push($filter, array(
          'key' => 'wpcf-start-time', 
          'value' => $timestamp, 
          'compare' => '>',
        ));
      } 

    } else {

      array_push($filter, array(
        "relation" => "OR",
        array(
          "key"     => "wpcf-end-time",
          "value"   => $timestamp,
          "compare" => ">"
        ),
        array(
          "key"     => "wpcf-is-permanent",
          "value"   => "true",
          "compare" => "="
        )
      ));
    }



    $query->set('meta_query', $filter);
  }

  return $query;
}


add_action('genesis_before_loop', 'post_type_archive_descriptions');
function post_type_archive_descriptions () {
  ob_start();?>

  <header class="archive-description">
    <?php the_archive_description();?>
  </header>

  <?php
  echo ob_get_clean();
}


add_action( 'pre_get_posts', 'include_all_staff_members' );
function include_all_staff_members( $query ) {

  if ($query->is_main_query() && is_post_type_archive('staff')) {
    $query->set('posts_per_page', -1);
    $query->set('orderby','title');
    $query->set('order','ASC');
  }
}

add_action('pre_get_posts', 'chronological_city_tour_archive');
function chronological_city_tour_archive( $query ) {

  $is_chronological_archive = (is_post_type_archive('city-tour') || is_post_type_archive('event'));

  if ($query->is_main_query() && $is_chronological_archive) {
    remove_filter('posts_orderby', 'CPTOrderPosts', 99, 2);
    $query->set('orderby', 'meta_value_num');
    $query->set('meta_key','wpcf-start-time');
    $query->set('order',   'ASC');
  }
}

remove_action( 'genesis_after_endwhile', 'genesis_posts_nav');
add_action( 'genesis_after_endwhile', 'bootstrap_posts_nav');
function bootstrap_posts_nav () {
  ob_start();
  genesis_posts_nav();
  $nav = ob_get_clean();
  $nav = preg_replace('/<div (class=".*?")>/', '<div class="archive-pagination text-center">', $nav);
  $nav = str_replace("<ul>", "<ul class=\"pagination\">", $nav);
  echo $nav;
}