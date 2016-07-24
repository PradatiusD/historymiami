<?php 

add_filter( 'genesis_pre_get_option_site_layout', '__genesis_return_full_width_content');
remove_action('genesis_loop', 'genesis_do_loop');

add_action('genesis_loop','staff_directory');

function staff_directory() {

  $directory = array();
  ?>

  <?php
  if ( have_posts() ) {
    while ( have_posts() ) {
      the_post();
      $phone_number = types_render_field('phone');
      $category = get_the_terms(get_the_id(), 'department');
      ob_start();
      ?>
        <tr>
          <td>
            <?php the_title();?>
          </td>
          <td><?php echo types_render_field('org-title');?></td>
          <td><?php echo types_render_field('email');?></td>
          <td>
            <a href="tel:<?php echo $phone_number;?>">
              <?php echo substr($phone_number, 0, 3)."-".substr($phone_number, 4,3)."-".substr($phone_number, 6);?>
            </a>
          </td>
        </tr>
      <?php
      $data = ob_get_clean();
      if (!isset($directory[$category[0]->name])) {
        $directory[$category[0]->name] = array();
      }
      array_push($directory[$category[0]->name], $data);
    }
  }

  ksort($directory);

  foreach ($directory as $team => $list) {?>

    <h3><?php echo $team;?></h3>
    <table class="table table-striped table-bordered">
      <thead>
        <th>Name</th>
        <th>Position</th>
        <th>Email</th>
        <th>Phone Number</th>
      </thead>
      <tbody>
      <?php
        for ($i=0; $i < count($directory[$team]); $i++) { 
          echo $directory[$team][$i];
        }
      ?>
      </tbody>
    </table>
  <?php
  }
}

genesis();

?>