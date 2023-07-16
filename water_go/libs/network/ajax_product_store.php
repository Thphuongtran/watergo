<?php

/**
 * @access FOR TAB PRODUCT-STORE
 */
add_action( 'wp_ajax_nopriv_atlantis_get_store_type_product', 'atlantis_get_store_type_product' );
add_action( 'wp_ajax_atlantis_get_store_type_product', 'atlantis_get_store_type_product' );

add_action( 'wp_ajax_nopriv_atlantis_get_product_from_store', 'atlantis_get_product_from_store' );
add_action( 'wp_ajax_atlantis_get_product_from_store', 'atlantis_get_product_from_store' );

add_action( 'wp_ajax_nopriv_atlantis_get_product_category', 'atlantis_get_product_category' );
add_action( 'wp_ajax_atlantis_get_product_category', 'atlantis_get_product_category' );


function atlantis_get_store_type_product(){
   if( isset($_POST['action']) && $_POST['action'] == 'atlantis_get_store_type_product' ){
      $store_id = func_get_store_id_from_current_user();

      global $wpdb;

      $sql_get_store_product_type = "SELECT store_type FROM wp_watergo_store WHERE id = $store_id ";

      $res = $wpdb->get_results( $sql_get_store_product_type);
      if( !empty( $res )){
         wp_send_json_success(['message' => 'get_type_product_ok', 'data' => $res[0]->store_type ]);
         wp_die();
      }

      wp_send_json_error(['message' => 'get_type_product_error']);
      wp_die();

   }
}

function atlantis_get_product_from_store(){
   if( isset($_POST['action']) && $_POST['action'] == 'atlantis_get_product_from_store'){
      
      $store_id = func_get_store_id_from_current_user();
      $type_product  = isset($_POST['type_product']) ? $_POST['type_product'] : '';

      if( $type_product == ''){
         wp_send_json_error(['message' => 'product_not_found']);
         wp_die();
      }

      $sql = "SELECT 
         wp_watergo_products.*,
         wp_watergo_photo.url as product_image

         
      FROM wp_watergo_store
      LEFT JOIN wp_watergo_products
      ON wp_watergo_products.store_id = wp_watergo_store.id

      LEFT JOIN wp_watergo_photo
      ON wp_watergo_photo.upload_by = wp_watergo_products.id AND wp_watergo_photo.kind_photo = 'product'

      WHERE wp_watergo_store.id = $store_id AND wp_watergo_products.product_type = '$type_product'
      ORDER BY wp_watergo_products.id DESC
      ";

      global $wpdb;
      $res = $wpdb->get_results($sql);
      
      if( empty($res )){
         wp_send_json_error(['message' => 'product_not_found']);
         wp_die();
      }

      // GET SOLD PRODUCT
      foreach( $res as $k => $p ){
         $sold = func_count_sold_product($p->id, $store_id);
         if( $sold == null ){
            $res[$k]->sold = 0;
         }else{
            $res[$k]->sold = $sold;
         }
      }

      wp_send_json_success(['message' => 'product_found', 'data' => $res ]);
      wp_die();



   }
}

function atlantis_get_product_category(){
   if( isset($_POST['action']) && $_POST['action'] == 'atlantis_get_product_category'){

      $sql = "SELECT * FROM wp_watergo_product_category";
      global $wpdb;

      $res = $wpdb->get_results($sql);

      if( empty( $res )){
         wp_send_json_error(['message' => 'product_category_not_found']);
         wp_die();
      }
      wp_send_json_success(['message' => 'product_category_found', 'data' => $res ]);
      wp_die();
   }
}