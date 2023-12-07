<?php

/**
 * @access THIS IS CUSTOM POST SUPPORT FOR ADMIN
 */

function admin_stylesheets(){
   wp_enqueue_script('vuejs3-main', THEME_URI . '/assets/js/vue.global.min.js');
   wp_enqueue_script('axios-main', THEME_URI . '/assets/js/axios.min.js');
   wp_enqueue_script('axios-main', THEME_URI . '/assets/js/common.js');

}

add_action('admin_enqueue_scripts', 'admin_stylesheets');

function setup_atlantis_admin(){
   add_menu_page('Admin Support', 'Admin Support', '', 'admin_support', '', 'dashicons-admin-page', 3 );
   // add_menu_page( 'Admin Support', 'Admin Support', 'manage_options', 'admin_support_users', 'template_admin_support_user','',27 ); 

   add_submenu_page('admin_support', 'Admin Support All', 'Admin Page', 'manage_options', 'page_support_admin', 'template_support_admin', 1 );
   add_submenu_page('admin_support', 'Admin Support Users', 'Users Page', 'manage_options', 'page_support_users', 'template_support_users', 2 );
}

add_action('admin_menu', 'setup_atlantis_admin');


require_once THEME_DIR . '/libs/custom_post_admin_support/template_support_admin.php';
require_once THEME_DIR . '/libs/custom_post_admin_support/template_support_users.php';

// require_once THEME_DIR. '/libs/custom_post_admin_support/template_admin_support_user.php';
//require_once THEME_DIR. '/libs/custom_post_admin_support/template_admin_support_all.php';
