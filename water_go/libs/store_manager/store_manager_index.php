<?php

/**
 * @access THIS IS CUSTOM POST SUPPORT FOR ADMIN
 */

// function admin_stylesheets(){
   // wp_enqueue_style('admin-support-stylesheet', THEME_URI . '/custom_post_admin_support/admin_support_stylesheet.css');
// }

// add_action('admin_enqueue_scripts', 'admin_stylesheets');

function setup_atlantis_store_manager(){

   add_menu_page(__('Store Manager', 'watergo'), __('Store Manager', 'watergo'), '', 'store_manager', '', '', 3 );

   add_submenu_page('store_manager', __('Store Manager', 'watergo'), 'Store Manager', 'manage_options', 'store_manager_index', 'template_store_manager_index');
   add_submenu_page('store_manager', __('Store Manager', 'watergo'), 'Add Store', 'manage_options', 'store_manager_add', 'template_store_manager_add');

   // ADD PRODUCT
   // add_submenu_page('store_manager', __('Store Manager', 'watergo'), 'Add Product', 'manage_options', 'store_manager_add_product', 'template_store_manager_add_product');


}

add_action('admin_menu', 'setup_atlantis_store_manager');

require_once THEME_DIR. '/libs/store_manager/template_store_manager_index.php';
require_once THEME_DIR. '/libs/store_manager/template_store_manager_add.php';
// require_once THEME_DIR. '/libs/store_manager/template_store_manager_add_product.php';
