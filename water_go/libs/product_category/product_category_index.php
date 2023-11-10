<?php

/**
 * @access THIS IS CUSTOM POST SUPPORT FOR ADMIN
 */


function setup_atlantis_product_category(){

   add_menu_page(__('Product Category', 'watergo'), __('Product Category', 'watergo'), '', 'product_category', '', 'dashicons-admin-page', 3 );

   add_submenu_page('product_category', __('Product Category', 'watergo'), 'Product Category', 'manage_options', 'product_category_index', 'template_product_category_index');
   add_submenu_page('product_category', __('Product Category', 'watergo'), 'Add Product Category', 'manage_options', 'product_category_add', 'template_product_category_add');
}

add_action('admin_menu', 'setup_atlantis_product_category');

require_once THEME_DIR. '/libs/product_category/template_product_category_index.php';
require_once THEME_DIR. '/libs/product_category/template_product_category_add.php';
