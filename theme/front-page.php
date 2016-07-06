<?php


function homepage_slider() {

  $args = array('post_type' => 'exhibition');

  // The Query
  $query = new WP_Query( $args );

  // The Loop
  if ($query->have_posts()) { ?>
    <section class="swiper-container">
      <div class="swiper-wrapper">

    <?php
    while ($query->have_posts()) {
      $query->the_post();

      $post_title = get_the_title();

      $colon_pos  = strpos($post_title, ':');

      if ($colon_pos !== false) {
        $title = substr($post_title, 0, $colon_pos + 1);
        $subtitle = substr($post_title, $colon_pos + 1, strlen($post_title));
      } else {
        $title = $post_title;
      }

      $date_format = array(
        "style"=>"text",
        "format"=> "l M j, Y"
      );

    ?>

        <article class="swiper-slide" style="background-image: url('<?php the_post_thumbnail_url(); ?>');">
          <div class="container">
            <div class="swiper-overlay">
              <h3>
                <a href="<?php the_permalink(); ?>" title="<?php the_title_attribute(); ?>">
                  <?php 
                    echo '<span class="title">'.$title.'</span>';
                    if (isset($subtitle)) {
                      echo '<span class="subtitle">'.$subtitle.'</span>';
                    }
                  ?>
                </a>
              </h3>
              <span class="badge"><?php echo get_post_type();?></span>
              <small class="swiper-dates">
                <?php echo types_render_field("start-time", $date_format);?> - 
                <?php echo types_render_field("end-time", $date_format);?>
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