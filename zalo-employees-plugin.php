<?php
/**
 * Plugin Name: Zalo Employees
 * Plugin URI:
 * Description: Plugin for adding employees
 * Version: 0.1
 * Author: Tor Raswill
 * Author URI: http://tor.raswill.se
 * Text Domain: zalo-employees-plugin
 */

include_once( ABSPATH . 'wp-admin/includes/plugin.php' );

add_action( 'plugins_loaded', 'zalo_employees_plugin_load_plugin_textdomain' );
function zalo_employees_plugin_load_plugin_textdomain() {
  load_plugin_textdomain( 'zalo-employees-plugin', FALSE, basename( dirname( __FILE__ ) ) . '/languages/' );
}

//* Enqueue Scripts
add_action( 'wp_enqueue_scripts', 'add_employees_styling' );
function add_employees_styling() {

  $pluginversion = '0.7.1';

  wp_enqueue_style( 'zalo-employees', plugins_url( 'zalo-employees.css', __FILE__ ), array(), $pluginversion, false );
  if ( is_singular( 'zalo_employees' ) ) {
    //wp_enqueue_script( 'zalo-employees-imagesloaded', plugins_url( 'imagesloaded.js', __FILE__ ), array( 'jquery' ), $pluginversion, false );
    wp_enqueue_script( 'zalo-employees-js', plugins_url( 'zalo-employees.js', __FILE__ ), array( 'jquery', 'zalo-imagesloaded', 'BJLL' ), $pluginversion, true );
  }

}

add_action( 'init', 'zalo_employees_add_new_image_size' );
function zalo_employees_add_new_image_size() {
    add_image_size( 'zalo_employee_front', 600, 400, true ); //mobile
    add_image_size( 'zalo_employee_single', 900, 600, true ); //mobile
}

add_action( 'init', 'create_post_type_employees' );
function create_post_type_employees() {
  register_post_type( 'zalo_employees',
    array(
      'supports' => array( 'title', 'editor', 'comments', 'excerpt', 'custom-fields', 'thumbnail' ),
      'labels' => array(
        'name' => __( 'Employees', 'zalo-employees-plugin' ),
        'singular_name' => __( 'Employee', 'zalo-employees-plugin' )
      ),
      'public' => true,
      'has_archive' => true,
      'rewrite' => array('slug' => 'employees'),
      'menu_icon' => plugins_url( 'images/icon.png', __FILE__ ),
    )
  );
}

function get_zalo_employees_template($single_template) {
     global $post;

     if ($post->post_type == 'zalo_employees') {
          $single_template = dirname( __FILE__ ) . '/single-zalo_employees.php';
     }
     return $single_template;
}
add_filter( 'single_template', 'get_zalo_employees_template' );

/**
 * Add the Why I love box
 */
add_action( 'add_meta_boxes_zalo_employees', 'zalo_employees_add_meta_box' );
function zalo_employees_add_meta_box() {
  add_meta_box(
    'zalo_whyilove',
    'Why I love',
    'create_zalo_whyilove_nonce_output_box',
    'zalo_employees',
    'normal',
    'high'
  );
  add_meta_box(
    'zalo_title',
    'Title',
    'create_zalo_title_nonce_output_box',
    'zalo_employees',
    'side'
  );
  add_meta_box(
  'zalo_contact',
  'Contact',
  'create_zalo_contact_nonce_output_box',
  'zalo_employees',
  'side'
);
  add_meta_box(
    'zalo_skills',
    'Skills',
    'create_zalo_skills_nonce_output_box',
    'zalo_employees',
    'side'
  );
}

function create_zalo_whyilove_nonce_output_box( $post ) {
  $nonce = wp_create_nonce( 'zalo_whyilove_meta_box_nonce' );
  echo "<input type='hidden' name='zalo_whyilove_meta_box_nonce' value='$nonce' />";
  $value = get_post_meta($post->ID, 'zalo_whyilove_field_box', TRUE );
  wp_editor( $value,'zalo_whyilove_field_box', array ('textarea_rows' => 10));
}

function create_zalo_title_nonce_output_box( $post ) {
  wp_nonce_field( basename( __FILE__ ), 'title_nonce' );
  $zaloemployee_stored_meta = get_post_meta( $post->ID );
  ?>
  <p>
    <label for="meta-text" class="prfx-row-title"><?php _e( 'Title', 'zalo-employees-plugin' )?></label>
    <input type="text" name="zalo-title-text" id="zalo-title-text" value="<?php if ( isset ( $zaloemployee_stored_meta['zalo-title-text'] ) ) echo $zaloemployee_stored_meta['zalo-title-text'][0]; ?>" />
  </p>
  <?php
}

function create_zalo_contact_nonce_output_box( $post ) {
  wp_nonce_field( basename( __FILE__ ), 'title_nonce' );
  $zaloemployee_stored_meta = get_post_meta( $post->ID );
  ?>
  <p>
    <label for="meta-text" class="prfx-row-title"><?php _e( 'Phone', 'zalo-employees-plugin' )?></label>
    <input type="text" name="zalo-employeephone-text" id="zalo-employeephone-text" value="<?php if ( isset ( $zaloemployee_stored_meta['zalo-employeephone-text'] ) ) echo $zaloemployee_stored_meta['zalo-employeephone-text'][0]; ?>" />
  </p>
  <p>
    <label for="meta-text" class="prfx-row-title"><?php _e( 'Email', 'zalo-employees-plugin' )?></label>
    <input type="text" name="zalo-employeemail-text" id="zalo-employeemail-text" value="<?php if ( isset ( $zaloemployee_stored_meta['zalo-employeemail-text'] ) ) echo $zaloemployee_stored_meta['zalo-employeemail-text'][0]; ?>" />
  </p>
  <p>
    <label for="meta-text" class="prfx-row-title"><?php _e( 'LinkedIn', 'zalo-employees-plugin' )?></label>
    <input type="text" name="zalo-employeelinkedin-text" id="zalo-employeelinkedin-text" value="<?php if ( isset ( $zaloemployee_stored_meta['zalo-employeelinkedin-text'] ) ) echo $zaloemployee_stored_meta['zalo-employeelinkedin-text'][0]; ?>" />
  </p>
  <p>
    <label for="meta-text" class="prfx-row-title"><?php _e( 'Bungie', 'zalo-employees-plugin' )?></label>
    <input type="text" name="zalo-employeebungie-text" id="zalo-employeebungie-text" value="<?php if ( isset ( $zaloemployee_stored_meta['zalo-employeebungie-text'] ) ) echo $zaloemployee_stored_meta['zalo-employeebungie-text'][0]; ?>" />
  </p>
  <?php
}

function create_zalo_skills_nonce_output_box( $post ) {
  wp_nonce_field( basename( __FILE__ ), 'prfx_nonce' );
  $zaloemployee_stored_meta = get_post_meta( $post->ID );

  ?>
  <p>
    <div class="prfx-row-content">
      <label for="zalo-javascript-checkbox">
        <input type="checkbox" name="zalo-javascript-checkbox" id="zalo-javascript-checkbox" value="yes" <?php if ( isset ( $zaloemployee_stored_meta['zalo-javascript-checkbox'] ) ) checked( $zaloemployee_stored_meta['zalo-javascript-checkbox'][0], 'yes' ); ?> />
        <?php _e( 'Javascript', 'zalo-employees-plugin' )?>
      </label><br />
      <label for="zalo-html5-checkbox">
        <input type="checkbox" name="zalo-html5-checkbox" id="zalo-html5-checkbox" value="yes" <?php if ( isset ( $zaloemployee_stored_meta['zalo-html5-checkbox'] ) ) checked( $zaloemployee_stored_meta['zalo-html5-checkbox'][0], 'yes' ); ?> />
        <?php _e( 'HTML5', 'zalo-employees-plugin' )?>
      </label><br />
      <label for="zalo-css3-checkbox">
        <input type="checkbox" name="zalo-css3-checkbox" id="zalo-css3-checkbox" value="yes" <?php if ( isset ( $zaloemployee_stored_meta['zalo-css3-checkbox'] ) ) checked( $zaloemployee_stored_meta['zalo-css3-checkbox'][0], 'yes' ); ?> />
        <?php _e( 'CSS3', 'zalo-employees-plugin' )?>
      </label><br />
      <label for="zalo-visualstudio-checkbox">
        <input type="checkbox" name="zalo-visualstudio-checkbox" id="zalo-visualstudio-checkbox" value="yes" <?php if ( isset ( $zaloemployee_stored_meta['zalo-visualstudio-checkbox'] ) ) checked( $zaloemployee_stored_meta['zalo-visualstudio-checkbox'][0], 'yes' ); ?> />
        <?php _e( 'Visual Studio', 'zalo-employees-plugin' )?>
      </label><br />
      <label for="zalo-csharp-checkbox">
        <input type="checkbox" name="zalo-csharp-checkbox" id="zalo-csharp-checkbox" value="yes" <?php if ( isset ( $zaloemployee_stored_meta['zalo-csharp-checkbox'] ) ) checked( $zaloemployee_stored_meta['zalo-csharp-checkbox'][0], 'yes' ); ?> />
        <?php _e( 'C#', 'zalo-employees-plugin' )?>
      </label><br />
      <label for="zalo-sharepoint-checkbox">
        <input type="checkbox" name="zalo-sharepoint-checkbox" id="zalo-sharepoint-checkbox" value="yes" <?php if ( isset ( $zaloemployee_stored_meta['zalo-sharepoint-checkbox'] ) ) checked( $zaloemployee_stored_meta['zalo-sharepoint-checkbox'][0], 'yes' ); ?> />
        <?php _e( 'SharePoint', 'zalo-employees-plugin' )?>
      </label><br />
      <label for="zalo-azure-checkbox">
        <input type="checkbox" name="zalo-azure-checkbox" id="zalo-azure-checkbox" value="yes" <?php if ( isset ( $zaloemployee_stored_meta['zalo-azure-checkbox'] ) ) checked( $zaloemployee_stored_meta['zalo-azure-checkbox'][0], 'yes' ); ?> />
        <?php _e( 'Azure', 'zalo-employees-plugin' )?>
      </label><br />
      <label for="zalo-office-checkbox">
        <input type="checkbox" name="zalo-office-checkbox" id="zalo-office-checkbox" value="yes" <?php if ( isset ( $zaloemployee_stored_meta['zalo-office-checkbox'] ) ) checked( $zaloemployee_stored_meta['zalo-office-checkbox'][0], 'yes' ); ?> />
        <?php _e( 'Office', 'zalo-employees-plugin' )?>
      </label><br />
      <label for="zalo-office365-checkbox">
        <input type="checkbox" name="zalo-office365-checkbox" id="zalo-office365-checkbox" value="yes" <?php if ( isset ( $zaloemployee_stored_meta['zalo-office365-checkbox'] ) ) checked( $zaloemployee_stored_meta['zalo-office365-checkbox'][0], 'yes' ); ?> />
        <?php _e( 'Office365', 'zalo-employees-plugin' )?>
      </label><br />
      <label for="zalo-powershell-checkbox">
        <input type="checkbox" name="zalo-powershell-checkbox" id="zalo-powershell-checkbox" value="yes" <?php if ( isset ( $zaloemployee_stored_meta['zalo-powershell-checkbox'] ) ) checked( $zaloemployee_stored_meta['zalo-powershell-checkbox'][0], 'yes' ); ?> />
        <?php _e( 'PowerShell', 'zalo-employees-plugin' )?>
      </label><br />
      <label for="zalo-scrum-checkbox">
        <input type="checkbox" name="zalo-scrum-checkbox" id="zalo-scrum-checkbox" value="yes" <?php if ( isset ( $zaloemployee_stored_meta['zalo-scrum-checkbox'] ) ) checked( $zaloemployee_stored_meta['zalo-scrum-checkbox'][0], 'yes' ); ?> />
        <?php _e( 'Scrum', 'zalo-employees-plugin' )?>
      </label><br />
    </div>
  </p>
  <?php
}

add_action( 'save_post', 'save_meta_box_content', 10, 2);
function save_meta_box_content( $post_id ) {
  // If this is an autosave, our form has not been submitted, so we don't want to do anything.
	if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
		return;
	}
  if ( isset( $_POST['post_type'] ) && 'page' == $_POST['post_type'] ) {
  	if ( ! current_user_can( 'edit_page', $post_id ) ) {
  		return;
  	}
  } else {

  	if ( ! current_user_can( 'edit_post', $post_id ) ) {
  		return;
  	}
  }

  if ( isset ( $_POST['zalo_whyilove_field_box'] ) && wp_verify_nonce( $_POST[ 'zalo_whyilove_meta_box_nonce' ], 'zalo_whyilove_meta_box_nonce') ) {
    update_post_meta( $post_id, 'zalo_whyilove_field_box', $_POST['zalo_whyilove_field_box'] );
  } else {
    delete_post_meta( $post_id, 'zalo_whyilove_field_box' );
  }

 // Checks for input and sanitizes/saves if needed
  if( isset( $_POST[ 'zalo-title-text' ] ) ) {
      update_post_meta( $post_id, 'zalo-title-text', sanitize_text_field( $_POST[ 'zalo-title-text' ] ) );
  }
  if( isset( $_POST[ 'zalo-employeephone-text' ] ) ) {
    update_post_meta( $post_id, 'zalo-employeephone-text', sanitize_text_field( $_POST[ 'zalo-employeephone-text' ] ) );
  }
  if( isset( $_POST[ 'zalo-employeemail-text' ] ) ) {
    update_post_meta( $post_id, 'zalo-employeemail-text', sanitize_text_field( $_POST[ 'zalo-employeemail-text' ] ) );
  }
  if( isset( $_POST[ 'zalo-employeelinkedin-text' ] ) ) {
    update_post_meta( $post_id, 'zalo-employeelinkedin-text', sanitize_text_field( $_POST[ 'zalo-employeelinkedin-text' ] ) );
  }
  if( isset( $_POST[ 'zalo-employeebungie-text' ] ) ) {
    update_post_meta( $post_id, 'zalo-employeebungie-text', sanitize_text_field( $_POST[ 'zalo-employeebungie-text' ] ) );
  }

  // Checks for input and saves
  if( isset( $_POST[ 'zalo-javascript-checkbox' ] ) ) {
      update_post_meta( $post_id, 'zalo-javascript-checkbox', 'yes' );
  } else {
      update_post_meta( $post_id, 'zalo-javascript-checkbox', '' );
  }
  if( isset( $_POST[ 'zalo-html5-checkbox' ] ) ) {
      update_post_meta( $post_id, 'zalo-html5-checkbox', 'yes' );
  } else {
      update_post_meta( $post_id, 'zalo-html5-checkbox', '' );
  }
  if( isset( $_POST[ 'zalo-css3-checkbox' ] ) ) {
      update_post_meta( $post_id, 'zalo-css3-checkbox', 'yes' );
  } else {
      update_post_meta( $post_id, 'zalo-css3-checkbox', '' );
  }
  if( isset( $_POST[ 'zalo-visualstudio-checkbox' ] ) ) {
      update_post_meta( $post_id, 'zalo-visualstudio-checkbox', 'yes' );
  } else {
      update_post_meta( $post_id, 'zalo-visualstudio-checkbox', '' );
  }
  if( isset( $_POST[ 'zalo-csharp-checkbox' ] ) ) {
      update_post_meta( $post_id, 'zalo-csharp-checkbox', 'yes' );
  } else {
      update_post_meta( $post_id, 'zalo-csharp-checkbox', '' );
  }
  if( isset( $_POST[ 'zalo-sharepoint-checkbox' ] ) ) {
      update_post_meta( $post_id, 'zalo-sharepoint-checkbox', 'yes' );
  } else {
      update_post_meta( $post_id, 'zalo-sharepoint-checkbox', '' );
  }
  if( isset( $_POST[ 'zalo-azure-checkbox' ] ) ) {
      update_post_meta( $post_id, 'zalo-azure-checkbox', 'yes' );
  } else {
      update_post_meta( $post_id, 'zalo-azure-checkbox', '' );
  }
  if( isset( $_POST[ 'zalo-office-checkbox' ] ) ) {
      update_post_meta( $post_id, 'zalo-office-checkbox', 'yes' );
  } else {
      update_post_meta( $post_id, 'zalo-office-checkbox', '' );
  }
  if( isset( $_POST[ 'zalo-office365-checkbox' ] ) ) {
      update_post_meta( $post_id, 'zalo-office365-checkbox', 'yes' );
  } else {
      update_post_meta( $post_id, 'zalo-office365-checkbox', '' );
  }
  if( isset( $_POST[ 'zalo-powershell-checkbox' ] ) ) {
      update_post_meta( $post_id, 'zalo-powershell-checkbox', 'yes' );
  } else {
      update_post_meta( $post_id, 'zalo-powershell-checkbox', '' );
  }
  if( isset( $_POST[ 'zalo-scrum-checkbox' ] ) ) {
    update_post_meta( $post_id, 'zalo-scrum-checkbox', 'yes' );
  } else {
    update_post_meta( $post_id, 'zalo-scrum-checkbox', '' );
  }

}

class ZaloEmployeesWidget extends WP_Widget
{
  function ZaloEmployeesWidget()
  {
    $widget_ops = array('classname' => 'zaloemployeeswidget featuredpage', 'description' => __( 'Displays the Zalo employees', 'zalo-employees-plugin' ) );
    $this->WP_Widget('ZaloEmployeesWidget', 'Zalo employees widget', $widget_ops);
  }

  function form($instance)
  {
    $instance = wp_parse_args( (array) $instance, array( 'title' => '' ) );
    $title = $instance['title'];
    echo '<p><label for="' . $this->get_field_id('title') . '">' . __( 'Title', 'zalo-employees-plugin' ) . ': <input class="widefat" id="' . $this->get_field_id('title') . '" name="' . $this->get_field_name('title') . '" type="text" value="' . attribute_escape($title) . '" /></label></p>';
  }

  function update($new_instance, $old_instance)
  {
    $instance = $old_instance;
    $instance['title'] = $new_instance['title'];
    return $instance;
  }

  function widget($args, $instance)
  {
    extract($args, EXTR_SKIP);

    echo $before_widget;
    //$title = empty($instance['title']) ? ' ' : apply_filters('widget_title', $instance['title']);
    $title = empty($instance['title']) ? '' : $instance['title'];

    echo '<div id="zalo-employees" class="zalo-section-target"></div>';

    if (!empty($title)) {
      echo '<header class="entry-header"><h2 class="entry-title">' . $title . '</h2></header>';
    }

    $output = '';
    //$employee_query = new WP_Query('post_type=zalo_employees&showposts=10&orderby=\'ID\'&order=\'ASC\'');
    $employee_query = new WP_Query( array ( 'post_type' => 'zalo_employees', 'orderby' => 'date', 'order' => 'ASC' ) );
    if ($employee_query->have_posts()) :
      $output .= '<div class="zalo-employees">';

      while ($employee_query->have_posts()) : $employee_query->the_post();
        $output .= '<a href="' . get_permalink($post->ID) . '">';
        $output .= '<div class="employee">';
        $employeetitle = genesis_get_custom_field('zalo-title-text'); //genesis_get_custom_field('zalo-title-text')

        $placeholder = plugins_url( 'images/placeholder.png', __FILE__ );

        $output .= '<div class="employee-image">';
        if(has_post_thumbnail()) {

          $output .= get_the_post_thumbnail($post->ID,'zalo_employee_front');
        } else {
          //$output .= '<img width="600" height="400" src="' . $placeholder . '" class="attachment-featured_image wp-post-image" alt="" />';
          $img_html = '<img width="600" height="400" src="' . $placeholder . '" class="attachment-featured_image wp-post-image" alt="" />';
          $img_html = apply_filters( 'bj_lazy_load_html', $img_html );
          $output .= $img_html;
        }
        $output .= '</div>';
        $output .= '<div class="employee-info">';
        $output .= '<header class="entry-header"><h4>' . get_the_title() . '</h4></header>';
        $output .= '<span class="employee-title">' . $employeetitle . '</span>';
        $output .= '</div>';
        $output .= '</div>';
        $output .= '</a>';
      endwhile;

      $output .= '</div>';
    endif;
    wp_reset_postdata();

    echo $output;

    echo $after_widget;
  }

}
add_action( 'widgets_init', create_function('', 'return register_widget("ZaloEmployeesWidget");') );

/* Stop Adding Functions Below this Line */
?>
