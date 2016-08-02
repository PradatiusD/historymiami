<?php

function homepage_slider() {

  $timestamp = Utilities::get_timestamp();

  $args = array(
    "post_type"  => array("exhibition","event", "city-tour"),
    "orderby"    => "meta_value_num",
    "meta_key"   => "wpcf-end-time",
    'order'     => 'ASC',
    "meta_query" => array(
      array(
        "key" => "wpcf-end-time",
        "value" => $timestamp,
        "compare" => ">"
      ),
      array(
        "key" => "wpcf-feature-on-slider",
        "value"=> "false",
        "compare" => "NOT EXISTS"
      )
    )
  );

  $query = new WP_Query($args);

  if ($query->have_posts()) { ?>
    <section class="swiper-container">
      <div class="swiper-wrapper">

    <?php
    while ($query->have_posts()) {

      $query->the_post();

      $post_title = get_the_title();
      $post_title = Utilities::split_post_title($post_title);
      $post_type  = str_replace('-', ' ', get_post_type());
    ?>

        <article class="swiper-slide" style="background-image: url('<?php the_post_thumbnail_url('full'); ?>');">
          <div class="container">
            <div class="swiper-overlay">
              <h3>
                <a href="<?php the_permalink(); ?>" title="<?php the_title_attribute(); ?>">
                  <?php 
                    echo '<span class="title">'.$post_title["title"].'</span>';
                    if (isset($post_title["subtitle"])) {
                      echo '<span class="subtitle">'.$post_title["subtitle"].'</span>';
                    }
                  ?>
                </a>
              </h3>
              <span class="badge"><?php echo $post_type;?></span>
              <small class="swiper-dates">
                <?php echo Utilities::get_post_dates(); ?>
              </small>
            </div>
          </div>
        </article>

      <?php
    }  
  ?> 
    </div>
  </section>

  <?php
  } else {
    echo "<p>No Exhibitions found</p>";
  }

  /* Restore original Post Data */
  wp_reset_postdata();
}


add_filter( 'genesis_pre_get_option_site_layout', '__genesis_return_full_width_content' );
add_action( 'genesis_before_content_sidebar_wrap', 'homepage_slider' );
remove_action( 'genesis_loop', 'genesis_do_loop' );

// Slider
wp_enqueue_style('swiper.css', get_stylesheet_directory_uri() . "/bower_components/Swiper/dist/css/swiper.min.css", array(), '3.3.1', 'all' );
wp_enqueue_script('swiper.js', get_stylesheet_directory_uri() . "/bower_components/Swiper/dist/js/swiper.jquery.min.js" , array('jquery'), '3.3.1', true);
wp_enqueue_script('homepage-slider', get_stylesheet_directory_uri() . "/js/homepage-slider.js" , array('jquery','swiper.js'), '1.0.0', true);


genesis();

?>