<?php

/*
 * Template Name: Press Room
 * Description: Displays Press Room Links
 */

add_action('genesis_entry_content', 'press_room_listing');

function press_room_listing () {

  $args = array(
    "post_type" => "press-release",
    "posts_per_page" => "25"
  );

  $query = new WP_Query($args);

  if ($query->have_posts()) {

    echo "<table class=\"press-room-listing\">";
      echo "<tbody>";

      while ($query->have_posts()) {
        $query->the_post();

        $date = get_the_date("M,j,y");
        $date = explode(",", $date);
        ?>

        <tr>
          <td>
            <aside class="date-container">
              <div class="date-text">
                <span class="month"><?php echo $date[0];?></span>
                <span class="day"><?php echo $date[1];?></span>
                <span class="year"><?php echo $date[2];?></span>              
              </div>
            </aside>
          </td>
          <td class="press-room-link">
            <a href="<?php the_permalink();?>">
              <?php echo the_title();?>        
            </a>          
          </td>
        </tr>

        <?php
      }
      ?>
      </tbody>
    </table>

    <script>
      (function ($) {
        $trs = $('.press-room-listing').find('tr');

        $trs.click(function (e) {
          e.preventDefault();
          var link = $(this).find('a').attr('href');
          window.location.href = link;
        });

      })(jQuery);

    </script>
      
    <?php
  } else {
    echo "<p>No press room articles found</p>";
  }

  wp_reset_postdata();
}

genesis();