<?php
/**
 * This file adds the Single Post Template to any Genesis child theme.
 *
 * @author Brad Dalton
 * @example  http://wpsites.net/
 * @copyright 2014 WP Sites
 */

//* Add custom body class to the head
add_filter( 'body_class', 'single_posts_body_class' );
function single_posts_body_class( $classes ) {

   $classes[] = 'zalo-employee-single';
   return $classes;

}

remove_action( 'genesis_entry_content', 'genesis_do_post_content' );
remove_action( 'genesis_entry_header', 'genesis_post_info', 12 );
remove_action( 'genesis_entry_footer', 'genesis_post_meta' );

add_action('genesis_entry_header', 'entry_title_wrap_open', 4);
function entry_title_wrap_open() {
  $employeephone = genesis_get_custom_field('zalo-employeephone-text'); //genesis_get_custom_field('zalo-title-text')
  $employeemail = genesis_get_custom_field('zalo-employeemail-text'); //genesis_get_custom_field('zalo-title-text')
  $employeelinkedin = genesis_get_custom_field('zalo-employeelinkedin-text'); //genesis_get_custom_field('zalo-title-text')
  $employeebungie = genesis_get_custom_field('zalo-employeebungie-text'); //genesis_get_custom_field('zalo-title-text')

  if ( $employeephone == '' && $employeemail == '' && $employeelinkedin == '' && $employeebungie == '' ) {
    echo '<div class="full">';
  } else {
    echo '<div class="two-thirds first">';
  }
}
add_action('genesis_entry_header', 'entry_title_wrap_close', 16);
function entry_title_wrap_close() {
  echo '</div>';
}

add_action('genesis_entry_header', 'zalo_employee_title');
function zalo_employee_title() {
  $employeetitle = genesis_get_custom_field('zalo-title-text'); //genesis_get_custom_field('zalo-title-text')
  echo '<h3 class="zalo-employee-title">' . $employeetitle . '</h3>';
}

add_action( 'genesis_entry_header', 'zalo_employee_header_wrap_open', 2 );
function zalo_employee_header_wrap_open() {
  echo '<div class="zalo-employee-header-wrap">';
}

add_action( 'genesis_entry_header', 'zalo_employee_contact', 20 );
function zalo_employee_contact() {
  $employeephone = genesis_get_custom_field('zalo-employeephone-text'); //genesis_get_custom_field('zalo-title-text')
  $replacechars = array(" ", "-", "–");
  $employeephonecleaned = str_replace($replacechars, "", $employeephone);
  $employeemail = genesis_get_custom_field('zalo-employeemail-text'); //genesis_get_custom_field('zalo-title-text')
  $employeelinkedin = genesis_get_custom_field('zalo-employeelinkedin-text'); //genesis_get_custom_field('zalo-title-text')
  $employeebungie = genesis_get_custom_field('zalo-employeebungie-text'); //genesis_get_custom_field('zalo-title-text')

  if ( $employeephone != '' || $employeemail != '' || $employeelinkedin != '' || $employeebungie != '' ) {
    echo '<div class="zalo-employee-contact-info one-third">';
    if ( $employeephone != '' ) {
      echo '<a class="zalo-employee-contact-link" href="tel:' . $employeephonecleaned . '"><span class="zalo-employee-contact-icon fa fa-phone"></span><span class="zalo-employee-contact fa">' . $employeephone . '</span></a>';
    }
    if ( $employeemail != '' ) {
      echo '<a class="zalo-employee-contact-link" href="mailto:' . $employeemail . '"><span class="zalo-employee-contact-icon fa fa-envelope"></span><span class="zalo-employee-contact fa">' . $employeemail . '</span></a>';
    }
    if ( $employeelinkedin != '' ) {
      echo '<a class="zalo-employee-contact-link" href="' . $employeelinkedin . '" target="_blank"><span class="zalo-employee-contact-icon fa fa-linkedin"></span><span class="zalo-employee-contact fa">LinkedIn</span></a>';
    }
    if ( $employeebungie != '' ) {
      echo '<a class="zalo-employee-contact-link" href="' . $employeebungie . '" target="_blank"><span class="zalo-employee-contact-icon fa bungie"></span><span class="zalo-employee-contact fa">Bungie.net</span></a>';
    }
    echo '</div>';
  }
}

add_action( 'genesis_entry_header', 'zalo_employee_header_wrap_close', 25 );
function zalo_employee_header_wrap_close() {
  echo '</div>';
}

add_action('genesis_entry_content', 'add_genesis_entry_content');
function add_genesis_entry_content() {

  $zalowhyilove = genesis_get_custom_field('zalo_whyilove_field_box');

  $zalojavascript = genesis_get_custom_field('zalo-javascript-checkbox');
  $zalohtml5 = genesis_get_custom_field('zalo-html5-checkbox');
  $zalocss3 = genesis_get_custom_field('zalo-css3-checkbox');
  $zalovisualstudio = genesis_get_custom_field('zalo-visualstudio-checkbox');
  $zalocsharp = genesis_get_custom_field('zalo-csharp-checkbox');
  $zalosharepoint = genesis_get_custom_field('zalo-sharepoint-checkbox');
  $zaloazure = genesis_get_custom_field('zalo-azure-checkbox');
  $zalooffice = genesis_get_custom_field('zalo-office-checkbox');
  $zalooffice365 = genesis_get_custom_field('zalo-office365-checkbox');
  $zalopowershell = genesis_get_custom_field('zalo-powershell-checkbox');
  $zaloscrum = genesis_get_custom_field('zalo-scrum-checkbox');

  if ( $zalowhyilove == '') {
    $nolove = ' full';
  }

  echo '<div class="zalo-employee-upper-row">';
    $placeholder = plugins_url( 'images/placeholder.png', __FILE__ );
    echo '<div class="zalo-employee-image one-half first">';
      if(has_post_thumbnail()) {
        //echo get_the_post_thumbnail($post->ID,'zalo_employee_single', array( 'class' => 'lazy-ignore' ));
        echo get_the_post_thumbnail($post->ID,'zalo_employee_single');
      } else {
        //echo '<img src="' . $placeholder . '" class="attachment-featured_image wp-post-image" alt="" />';
        $img_html = '<img src="' . $placeholder . '" class="attachment-featured_image wp-post-image" alt="" />';
        $img_html = apply_filters( 'bj_lazy_load_html', $img_html );
        echo $img_html;
      }
    echo '</div>';
    echo '<div class="zalo-employee-about one-half">';
      echo '<div class="position-text">';
        //echo '<h2>' . __('A little bit about me', 'zalo-employees-plugin' ) . '</h2>';
        the_content();
      echo '</div>';
    echo '</div>';
  echo '</div>';

  echo '<div class="zalo-employee-lower-row">';
  if ( $zalowhyilove != '') {
    echo '<div class="zalo-employee-whyilove one-half first">';
        echo '<div class="whyilove-wrap">';
        //echo '<h2>' . __('Why I love what I do', 'zalo-employees-plugin') . '</h2>';
        $content = $zalowhyilove;
        $content = apply_filters('the_content', $content);
        $content = str_replace(']]>', ']]&gt;', $content);
        echo $content;
        echo '</div>';
    echo '</div>';
  }
    echo '<div class="zalo-employee-skills one-half' . $nolove . '">';
      echo '<div class="zalo-employee-skills-wrap">';
      if ( $zalojavascript == 'yes' ) {
        echo '<div class="zalo-employee-skill zalo-javascript">';
        echo '<span class="zalo-employee-skill-title">Javascript</span>';
        echo '</div>';
      }
      if ( $zalohtml5 == 'yes' ) {
        echo '<div class="zalo-employee-skill zalo-html5">';
        echo '<span class="zalo-employee-skill-title">HTML5</span>';
        echo '</div>';
      }
      if ( $zalocss3 == 'yes' ) {
        echo '<div class="zalo-employee-skill zalo-css3">';
        echo '<span class="zalo-employee-skill-title">CSS3</span>';
        echo '</div>';
      }
      if ( $zalovisualstudio == 'yes' ) {
        echo '<div class="zalo-employee-skill zalo-visualstudio">';
        echo '<span class="zalo-employee-skill-title">Visual&nbsp;Studio</span>';
        echo '</div>';
      }
      if ( $zalocsharp == 'yes' ) {
        echo '<div class="zalo-employee-skill zalo-csharp">';
        echo '<span class="zalo-employee-skill-title">C#</span>';
        echo '</div>';
      }
      if ( $zalosharepoint == 'yes' ) {
        echo '<div class="zalo-employee-skill zalo-sharepoint">';
        echo '<span class="zalo-employee-skill-title">SharePoint</span>';
        echo '</div>';
      }
      if ( $zaloazure == 'yes' ) {
        echo '<div class="zalo-employee-skill zalo-azure">';
        echo '<span class="zalo-employee-skill-title">Azure</span>';
        echo '</div>';
      }
      if ( $zalooffice == 'yes' ) {
        echo '<div class="zalo-employee-skill zalo-office">';
        echo '<span class="zalo-employee-skill-title">Office</span>';
        echo '</div>';
      }
      if ( $zalooffice365 == 'yes' ) {
        echo '<div class="zalo-employee-skill zalo-office365">';
        echo '<span class="zalo-employee-skill-title">Office365</span>';
        echo '</div>';
      }
      if ( $zalopowershell == 'yes' ) {
        echo '<div class="zalo-employee-skill zalo-powershell">';
        echo '<span class="zalo-employee-skill-title">PowerShell</span>';
        echo '</div>';
      }
      if ( $zaloscrum == 'yes' ) {
        echo '<div class="zalo-employee-skill zalo-scrum">';
        echo '<span class="zalo-employee-skill-title">Scrum</span>';
        echo '</div>';
      }
      echo '</div>';
    echo '</div>';
  echo '</div>';
};


//* Run the Genesis loop
genesis();
