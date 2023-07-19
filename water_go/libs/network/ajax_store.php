<?php

add_action( 'wp_ajax_nopriv_atlantis_load_store', 'atlantis_load_store' );
add_action( 'wp_ajax_atlantis_load_store', 'atlantis_load_store' );

add_action( 'wp_ajax_nopriv_atlantis_find_store', 'atlantis_find_store' );
add_action( 'wp_ajax_atlantis_find_store', 'atlantis_find_store' );

add_action( 'wp_ajax_nopriv_atlantis_load_all_product_by_store', 'atlantis_load_all_product_by_store' );
add_action( 'wp_ajax_atlantis_load_all_product_by_store', 'atlantis_load_all_product_by_store' );

add_action( 'wp_ajax_nopriv_atlantis_get_total_purchase_store', 'atlantis_get_total_purchase_store' );
add_action( 'wp_ajax_atlantis_get_total_purchase_store', 'atlantis_get_total_purchase_store' );

add_action( 'wp_ajax_nopriv_atlantis_get_store_nearby', 'atlantis_get_store_nearby' );
add_action( 'wp_ajax_atlantis_get_store_nearby', 'atlantis_get_store_nearby' );

add_action( 'wp_ajax_nopriv_atlantis_get_location_of_store', 'atlantis_get_location_of_store' );
add_action( 'wp_ajax_atlantis_get_location_of_store', 'atlantis_get_location_of_store' );

add_action( 'wp_ajax_nopriv_atlantis_get_store_id', 'atlantis_get_store_id' );
add_action( 'wp_ajax_atlantis_get_store_id', 'atlantis_get_store_id' );


function atlantis_get_store_id(){
   if( isset( $_POST['action'] ) && $_POST['action'] == 'atlantis_get_store_id' ){
      $store_id = func_get_store_id_from_current_user();
      wp_send_json_success(['message' => 'get_store_id_ok', 'data' => $store_id]);
      wp_die();
   }
}


function atlantis_get_store_nearby(){
   if( isset( $_POST['action'] ) && $_POST['action'] == 'atlantis_get_store_nearby' ){

      $lat = isset($_POST['lat']) ? $_POST['lat'] : 10.780900239854994;
      $lng = isset($_POST['lng']) ? $_POST['lng'] : 106.7226271387539;

      if($lat == 0.0 && $lng == 0.0){
         wp_send_json_error(['message' => 'store_location_not_found']);
         wp_die();
      }
      // sql search with current location
      $sql = "SELECT *,
            (6371 * acos(
               cos(radians($lat)) * cos(radians(latitude)) 
                  * cos(radians(longitude) - radians($lng)) +
               sin(radians($lat)) * sin(radians(latitude))
            )) AS distance
         FROM wp_watergo_store
         HAVING distance <= 5 -- Adjust the distance value as desired (in kilometers)
         ORDER BY distance ASC
         LIMIT 10
      ";
      global $wpdb;
      $res = $wpdb->get_results($sql);

      if( empty($res )){
         wp_send_json_error(['message' => 'store_location_not_found']);
         wp_die();
      }
      $arr = [];
      foreach( $res as $k => $vl ){
         $res[$k]->avg_rating    = func_atlantis_get_avg_rating( (int) $vl->id);
         $res[$k]->store_image   = func_atlantis_get_images( (int) $vl->id);
      }

      wp_send_json_success(['message' => 'store_location_found', 'data' => $res, 'arr' => $arr ]);
      wp_die();
   }
}

function atlantis_get_total_purchase_store(){
   if( isset( $_POST['action'] ) && $_POST['action'] == 'atlantis_get_total_purchase_store' ){
      $store_id = isset($_POST['store_id']) ? $_POST['store_id'] : 0;

      if( $store_id == 0 ){
         wp_send_json_error(['message' => 'purchase_not_found']);
         wp_die();
      }

      $sql = "SELECT COUNT(wp_watergo_order.hash_id) as store_purchase
         FROM wp_watergo_order
         LEFT JOIN wp_watergo_order_group
         ON wp_watergo_order_group.hash_id = wp_watergo_order.hash_id
         WHERE wp_watergo_order.order_status = 'complete'
         AND wp_watergo_order_group.order_group_store_id = $store_id
      ";

      global $wpdb;
      $res = $wpdb->get_results($sql);

      if( $res[0]->store_purchase == null ){
         wp_send_json_error(['message' => 'purchase_not_found']);
         wp_die();
      }

      wp_send_json_success(['message' => 'purchase_found', 'data' => $res[0]->store_purchase ]);
      wp_die();
   }
}

function atlantis_load_store(){
   if( isset( $_POST['action'] ) && $_POST['action'] == 'atlantis_load_store' ){
      global $wpdb;
      $sql = "SELECT 
         wp_watergo_store.*

         FROM wp_watergo_store 

         ORDER BY id DESC 
         LIMIT 0,10";
      $get_results = $wpdb->get_results($sql);
      if( empty( $get_results ) ){
         wp_send_json_error([ 'message' => 'store_not_found' ]);
         wp_die();
      }else{
         wp_send_json_success(['message' => 'store_found', 'data' => $get_results ]);
         wp_die();
      }
   }
}

function atlantis_find_store(){
   if( isset( $_POST['action'] ) && $_POST['action'] == 'atlantis_find_store' ){
      $store_id = isset($_POST['store_id']) ? $_POST['store_id'] : 0;

      if( $store_id == 0 ){
         wp_send_json_error(['message' => 'store_not_found']);
         wp_die();
      }

      global $wpdb;
      $sql = "SELECT * FROM wp_watergo_store WHERE id = $store_id ";

      $res = $wpdb->get_results($sql);

      foreach( $res as $k => $vl ){
         $res[$k]->store_image = func_atlantis_get_images($vl->id, true);
      }

      if( empty( $res ) ){
         wp_send_json_error([ 'message' => 'store_not_found' ]);
         wp_die();
      }
      wp_send_json_success(['message' => 'store_found', 'data' => $res[0] ]);
      wp_die();
      
   }

}


function atlantis_get_location_of_store(){
   if( isset( $_POST['action'] ) && $_POST['action'] == 'atlantis_get_location_of_store' ){
      $store_id = isset($_POST['store_id']) ? $_POST['store_id'] : 0;

      if( $store_id == 0 ){
         wp_send_json_error(['message' => 'store_not_found']);
         wp_die();
      }
      global $wpdb;
      
      $sql = "SELECT latitude, longitude FROM wp_watergo_store WHERE id = $store_id";

      $res = $wpdb->get_results($sql);

      if( empty( $res ) ){
         wp_send_json_error([ 'message' => 'store_not_found' ]);
         wp_die();
      }
      wp_send_json_success(['message' => 'store_found', 'data' => $res[0] ]);
      wp_die();

   }
}