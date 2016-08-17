<?php

require_once('lib/autoload.php');
use Ctct\Components\Contacts\Contact;
use Ctct\ConstantContact;
use Ctct\Exceptions\CtctException;

define("CC_API_KEY", "8f23jvzdce5cegkvgxdusab6");
define("CC_ACCESS_TOKEN", "2495e328-b0ab-4b2a-b0e7-4c944f8f72c3");


class Constant_Contact_Widget extends WP_Widget {

  function __construct() {
    parent::__construct(
      'Constant_Contact_Widget', 'Constant Contact Widget', array( 'description' => 'Custom Constant Contact E-mail Subscribe Form for HistoryMiami')
    );
  }

  function getActiveLists ($lists) {
    
    $active_list_ids = array(137, 134, 162, 175, 19, 131);
    $active_lists    = array();

    foreach ($lists as $list) {
      if (in_array($list->id, $active_list_ids)) {
        array_push($active_lists, array(
          "id"   => $list->id,
          "name" => $list->name
        ));   
      }
    }
  }


  public function form( $instance ) {
    $title  = !empty($instance['title'])       ? $instance['title'] : __('Form Title', 'text_domain');
    $desc   = !empty($instance['description']) ? $instance['description'] : __('Form description', 'text_domain');
    $button = !empty($instance['button-label'])? $instance['button-label'] : __('Form button label', 'text_domain');
    ?>
    <p>
    <label for="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>"><?php _e( esc_attr( 'Title:' ) ); ?></label> 
    <input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'title' ) ); ?>" type="text" value="<?php echo esc_attr( $title ); ?>">
    </p>

    <label for="<?php echo esc_attr( $this->get_field_id( 'description' ) ); ?>"><?php _e( esc_attr( 'Description:' ) ); ?></label> 
    <textarea class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'description' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'description' ) ); ?>"><?php echo esc_html( $desc ); ?></textarea>
    </p>

    <p>
    <label for="<?php echo esc_attr( $this->get_field_id( 'button-label' ) ); ?>"><?php _e( esc_attr( 'Button Label:' ) ); ?></label> 
    <input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'button-label' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'button-label' ) ); ?>" type="text" value="<?php echo esc_attr( $button ); ?>">
    </p>

    <?php 
  }

  public function update( $new_instance, $old_instance ) {
    $instance = array();
    $instance['title']        = (!empty($new_instance['title'])) ? strip_tags( $new_instance['title']) : '';
    $instance['description']  = (!empty($new_instance['description'])) ? strip_tags( $new_instance['description']) : '';
    $instance['button-label'] = (!empty($new_instance['button-label'])) ? strip_tags( $new_instance['button-label']) : '';

    return $instance;
  }

  function addUserToLists ($cc) {

    $email      = $_POST['email'];
    $first_name = $_POST['first_name'];
    $last_name  = $_POST['last_name'];
    $list       = $_POST['list'];

    $action = "Retrieving Contact";

    try {

      // check to see if a contact with the email address already exists in the account
      $response = $cc->contactService->getContacts(CC_ACCESS_TOKEN, array("email" => $email));

      if (empty($response->results)) {

        // create a new contact if one does not exist

        $action = "Creating Contact";
        $contact = new Contact();
        $contact->addEmail($email);

        foreach ($list as $l) {
          $contact->addList($l);
        }

        $contact->first_name = $first_name;
        $contact->last_name  = $last_name;
        $returnContact = $cc->contactService->addContact(CC_ACCESS_TOKEN, $contact);

      } else {

        // update the existing contact if address already existed
        $action = "Updating Contact";
        $contact = $response->results[0];

        if ($contact instanceof Contact) {

          foreach ($list as $l) {
            $contact->addList($l);
          }

          $contact->first_name = $first_name;
          $contact->last_name  = $last_name;
          $returnContact       = $cc->contactService->updateContact(CC_ACCESS_TOKEN, $contact);
        } else {
          $e = new CtctException();
          $e->setErrors(array("type", "Contact type not returned"));
          throw $e;
        }
      }
    } catch (CtctException $ex) {
      echo '<div class="alert alert-warning">Error ' . $action . '</div>';
    }

    if (isset($returnContact)) {
      echo '<div class="alert alert-success">';
      echo "Thank you for signing up ". $returnContact->first_name . "!";
      echo '</pre></div>';
    }
  }
  
  function widget( $args, $instance) {

    ob_start();

    $cc = new ConstantContact(CC_API_KEY);

    $lists = array(
        array("id" => 19,  "name" => "HM News"),
        array("id" => 131, "name" => "Media List"),
        array("id" => 134, "name" => "Exhibitions"),
        array("id" => 137, "name" => "City Tours"),
        array("id" => 162, "name" => "Family Events"),
        array("id" => 175, "name" => "Folklife Programs")
    );

    $path = "http://" . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];


    if (isset($_POST['email']) && strlen($_POST['email']) > 1) {
      $this->addUserToLists($cc);
    }

    $title  = !empty($instance['title'])       ? $instance['title']      :'Newsletter Signup';
    $desc   = !empty($instance['description']) ? $instance['description']:'Please go to the widget menu to customize this title.';
    $button = !empty($instance['button-label'])? $instance['button-label']:'Sign Up';

    ?>

      <h4><?php echo $title;?></h4>
      <p><?php echo $desc;?></p>

      <a id="hm-newsletter-btn" class="btn btn-block btn-primary" href="#"><?php echo $button;?></a>

      <!-- Newsletter Sign Up Modal -->
      <div class="modal fade" id="newsletter-modal" tabindex="-1" role="dialog" aria-labelledby="newsletter-modal">
        <div class="modal-dialog" role="document">
          <div class="modal-content">
            <div class="modal-header">
              <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
              <h4 class="modal-title"><?php echo $title;?></h4>
            </div>
            <div class="modal-body">
              <p><?php echo $desc;?></p>

              <form name="submitContact" id="submitContact" method="POST" action="<?php echo $path;?>">

                <div class="form-group">
                  <label for="email">Email</label>
                  <input class="form-control" type="email" id="email" name="email" placeholder="Email Address">
                </div>
                <div class="form-group">
                  <label for="first_name">First Name</label>
                  <input class="form-control" type="text" id="first_name" name="first_name" placeholder="First Name">
                </div>
                <div class="form-group">
                  <label for="last_name">Last Name</label>
                  <input class="form-control" type="text" id="last_name" name="last_name" placeholder="Last Name">
                </div>
                <div class="form-group">

                  <label for="list">Email List</label>
                    <?php foreach ($lists as $list):?>
                      <div class="checkbox">
                        <label>
                          <input type="checkbox" value="<?php echo $list["id"];?>" name="list[]">
                          <?php echo $list["name"];?>
                        </label>
                      </div>
                    <?php endforeach;?>
                </div>
                <div class="form-group">
                  <input type="submit" value="<?php echo $button;?>" class="btn btn-primary btn-block"/>
                </div>
              </form>
            </div>
          </div>
        </div>
      </div>


    <?php

    wp_enqueue_script('hm-newsletter', plugins_url( 'js/newsletter-form.js', __FILE__ ), array('jquery','bootstrap-modal'), '1.0.0', true);
    echo ob_get_clean();
  }
} 
?>
