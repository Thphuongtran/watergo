<?php


add_action( 'wp_ajax_nopriv_atlantis_testing', 'atlantis_testing' );
add_action( 'wp_ajax_atlantis_testing', 'atlantis_testing' );

/**
 * @access FUNCTION GET STORE ID -> user must be logged in
 */

function func_get_store_id_from_current_user(){
   if(is_user_logged_in() ){
      $user_id = get_current_user_id();
   }else{
      return 0;
   }
   global $wpdb;
   $sql_get_store_id = "SELECT id FROM wp_watergo_store WHERE user_id = $user_id LIMIT 1";
   $res_get_store_id = $wpdb->get_results($sql_get_store_id);
   if( empty( $res_get_store_id ) ){
      return 0;
   }
   return $res_get_store_id[0]->id;
}

/**
 * @access FUNCTION COUNT SOLD PRODUCT
 */

function func_count_sold_product($product_id, $store_id ){
   $sql = "SELECT 
      COUNT(wp_watergo_order_group.order_group_product_quantity_count) AS sold
      FROM wp_watergo_order
      LEFT JOIN wp_watergo_order_group
      ON wp_watergo_order_group.hash_id = wp_watergo_order.hash_id
      WHERE wp_watergo_order.order_store_id = $store_id
      AND wp_watergo_order.order_status = 'complete'	
      AND wp_watergo_order_group.order_group_product_id = $product_id
   ";
   global $wpdb;
   $count = $wpdb->get_results( $sql);
   return $count[0]->sold;
}







function atlantis_testing(){
   if( isset($_POST['action']) && $_POST['action'] == 'atlantis_testing' ){

   }
}

require_once THEME_DIR . '/libs/network/ajax_product.php';
require_once THEME_DIR . '/libs/network/ajax_store.php';
require_once THEME_DIR . '/libs/network/ajax_change_password.php';
require_once THEME_DIR . '/libs/network/ajax_user.php';
require_once THEME_DIR . '/libs/network/ajax_authentication.php';
require_once THEME_DIR . '/libs/network/ajax_sendcode.php';
require_once THEME_DIR . '/libs/network/ajax_support.php';
require_once THEME_DIR . '/libs/network/ajax_reviews.php';
require_once THEME_DIR . '/libs/network/ajax_category.php';
require_once THEME_DIR . '/libs/network/ajax_order.php';
require_once THEME_DIR . '/libs/network/ajax_notification.php';
require_once THEME_DIR . '/libs/network/ajax_chat.php';
require_once THEME_DIR . '/libs/network/ajax_search.php';
require_once THEME_DIR . '/libs/network/ajax_social.php';
require_once THEME_DIR . '/libs/network/ajax_upload.php';
require_once THEME_DIR . '/libs/network/ajax_language.php';
require_once THEME_DIR . '/libs/network/ajax_admin_supports.php';
require_once THEME_DIR . '/libs/network/ajax_location.php';
require_once THEME_DIR . '/libs/network/ajax_product_store.php';
