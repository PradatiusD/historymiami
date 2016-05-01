<?php

class Navigation {  

  public static function insert_bootstrap_classes($nav_output, $nav, $args) {
    ob_start();
    ?>
      <nav class="navbar navbar-default navbar-fixed-top genesis-nav-menu">
        <div class="container-fluid">
          <div class="navbar-header">
            <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
              <span class="sr-only">Toggle navigation</span>
              <span class="icon-bar"></span>
              <span class="icon-bar"></span>
              <span class="icon-bar"></span>
            </button>
            <a class="navbar-brand" href="<?php echo get_home_url(); ?>">
              <?php echo get_bloginfo('name');?>
            </a>
          </div>
          <div id="navbar" class="navbar-collapse collapse">
            <?php 
              $nav = str_replace('genesis-nav-menu', 'nav navbar-nav', $nav);
              echo $nav;
            ?>
          </div><!--/.nav-collapse -->
        </div><!--/.container-fluid -->
      </nav>

    <?php
    return ob_get_clean();
  }
}

add_filter('genesis_do_nav', array('Navigation','insert_bootstrap_classes'), 10, 3);
wp_enqueue_script( 'bootstrap-nav', get_stylesheet_directory_uri().'/global.min.js', array('jquery'), '1.0.0', true );

?>