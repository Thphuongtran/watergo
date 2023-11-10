<?php

/**
 * @access THIS IS CUSTOM POST SUPPORT FOR ADMIN
 */

function admin_stylesheets(){
   wp_enqueue_style('admin-support-stylesheet', THEME_URI . '/custom_post_admin_support/admin_support_stylesheet.css');

}

// add_action('admin_enqueue_scripts', 'admin_stylesheets');

function setup_atlantis_admin(){
   add_menu_page('Admin Support', 'Admin Support', '', 'admin_support', '', 'dashicons-admin-page', 3 );
   add_menu_page( 'Admin Support', 'Admin Support', 'manage_options', 'admin_support_users', 'template_admin_support_user','',27 ); 

   // add_submenu_page('admin_support', 'Admin Support All', 'Admin Support All', 'manage_options', 'admin_support_all', 'template_admin_support_all', 1 );
   // add_submenu_page('admin_support', 'Admin Support Users', 'Admin Support Users', 'manage_options', 'admin_support_users', 'template_admin_support_user', 2 );
}

add_action('admin_menu', 'setup_atlantis_admin');


require_once THEME_DIR. '/libs/custom_post_admin_support/template_admin_support_user.php';
//require_once THEME_DIR. '/libs/custom_post_admin_support/template_admin_support_all.php';
