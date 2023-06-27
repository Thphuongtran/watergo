<?php
/**
 * @access LOAD CATEGORY AND BRAND
 */

add_action( 'wp_ajax_nopriv_atlantis_load_category', 'atlantis_load_category' );
add_action( 'wp_ajax_atlantis_load_category', 'atlantis_load_category' );

function atlantis_load_category(){
   
   if( isset( $_POST['action'] ) && $_POST['action'] == 'atlantis_load_category' ){
      $category = isset($_POST['category']) ? $_POST['category'] : '';

      if( $category == '' ){
         wp_send_json_error(['message' => 'category_not_found' ]);
         wp_die();
      }

      global $wpdb;
      $sql = "SELECT * FROM wp_watergo_product_category WHERE category='{$category}'";
      $res = $wpdb->get_results($sql);

      if( empty( $res ) ){
         wp_send_json_error(['message' => 'category_not_found', 'data' => $res ]);
         wp_die();
      }
      wp_send_json_success(['message' => 'category_found', 'data' => $res ]);
      wp_die();
      
   }

}