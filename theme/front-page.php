<?php 


add_filter( 'genesis_pre_get_option_site_layout', '__genesis_return_full_width_content' );

function homepage_events() {

  $args = array(
      'post_type' => 'event'
  );

  // The Query
  $event_query = new WP_Query( $args );

  // The Loop
  if ($event_query->have_posts()) {
    while ( $event_query->have_posts() ) {
      $event_query->the_post();
      ?>
      <article>
        <h3>
          <a href="<?php the_permalink(); ?>" title="<?php the_title_attribute(); ?>">
            <?php the_title();?>
          </a>
        </h3>
      </article>
      <?php
    }  
  } else {}

  /* Restore original Post Data */
  wp_reset_postdata();
}

remove_action( 'genesis_loop', 'genesis_do_loop' );
add_action( 'genesis_loop',    'homepage_events' );
genesis();

?>