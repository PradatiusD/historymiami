<?php

class Navigation {  

  public static function insert_bootstrap_classes($nav_output, $nav, $args) {
    ob_start();
    ?>
      <nav class="navbar navbar-default navbar-fixed-top genesis-nav-menu">
        <div class="container-fluid">
          <div class="navbar-header">
            <a class="navbar-brand" href="<?php echo get_home_url(); ?>" title="<?php echo get_bloginfo('name');?>"></a>
            <button type="button" class="navbar-toggle collapsed" id="mobile-menu">
              <span class="sr-only">Toggle navigation</span>
              <span class="icon-bar"></span>
              <span class="icon-bar"></span>
              <span class="icon-bar"></span>
            </button>
          </div>
          <div id="navbar" class="navbar-collapse collapse">
            <?php 
              $nav = str_replace('genesis-nav-menu', 'nav navbar-nav navbar-right', $nav);
              $nav = str_replace('menu-item-has-children', 'dropdown', $nav);
              $nav = str_replace('sub-menu','dropdown-menu', $nav);
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

wp_enqueue_script('sidr', get_stylesheet_directory_uri(). "/bower_components/sidr/dist/jquery.sidr.min.js", array('jquery'), '1.0.0', true);
wp_enqueue_script('sidr-client', get_stylesheet_directory_uri(). "/js/sidr-client.js", array('sidr'), '1.0.0', true);

?>