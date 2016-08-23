<?php

function custom_login_logo() {

  $img_url = get_stylesheet_directory_uri(). '/images/historymiami-logo.png';
  ob_start();?>

    <style type="text/css">
      #login h1 a {
        background-image: url('<?php echo $img_url; ?>');
        background-size: 100% auto;
        width: 100%;
        margin-bottom: 0;
        height: 44px;
      }
    </style>

  <?php 
  echo ob_get_clean();
}
add_action('login_enqueue_scripts', 'custom_login_logo');


function custom_post_type_headers ($columns) {

  if ($_GET['post_type'] == 'staff') {
    $columns['org-title'] = 'Organizational Title';
    $columns['phone']     = 'Phone Number';
    $columns['email']     = 'Email';    
  } else {
    $columns['start-time'] = 'Start Time';
    $columns['end-time']   = 'End Time';
    $columns['feat-image'] = 'Preview Image';
  }

  return $columns;
}

function custom_columns ($column, $post_id) {

  $meta = get_post_meta($post_id);
  $date_format = 'l,  M j, Y g:i A';

  switch ($column) {
    case 'start-time':
      echo isset($meta['wpcf-start-time']) ? Utilities::timestamp_to_date($meta['wpcf-start-time'][0])->format($date_format): "N/A";
      break;
    case 'end-time':
      echo isset($meta['wpcf-end-time']) ? Utilities::timestamp_to_date($meta['wpcf-end-time'][0])->format($date_format): "N/A";
      break;
    case 'feat-image':
      echo get_the_post_thumbnail($post_id, 'thumb');
      break;
    case 'org-title':
      echo $meta['wpcf-org-title'][0];
      break;
    case 'phone':
      echo $meta['wpcf-phone'][0];
      break;
    case 'email':
      echo $meta['wpcf-email'][0];
      break;
  }
}

foreach (array_merge(Utilities::$custom_post_types, array('staff')) as $post_type) {
  add_filter('manage_edit-'.$post_type.'_columns', 'custom_post_type_headers');
  add_action( 'manage_'.$post_type.'_posts_custom_column' , 'custom_columns', 10, 2 );
}


