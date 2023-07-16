<?php

add_action( 'wp_ajax_nopriv_atlantis_load_store', 'atlantis_load_store' );
add_action( 'wp_ajax_atlantis_load_store', 'atlantis_load_store' );

add_action( 'wp_ajax_nopriv_atlantis_find_store', 'atlantis_find_store' );
add_action( 'wp_ajax_atlantis_find_store', 'atlantis_find_store' );

add_action( 'wp_ajax_nopriv_atlantis_load_product_by_store', 'atlantis_load_product_by_store' );
add_action( 'wp_ajax_atlantis_load_product_by_store', 'atlantis_load_product_by_store' );

add_action( 'wp_ajax_nopriv_atlantis_load_all_product_by_store', 'atlantis_load_all_product_by_store' );
add_action( 'wp_ajax_atlantis_load_all_product_by_store', 'atlantis_load_all_product_by_store' );

add_action( 'wp_ajax_nopriv_atlantis_get_total_purchase_store', 'atlantis_get_total_purchase_store' );
add_action( 'wp_ajax_atlantis_get_total_purchase_store', 'atlantis_get_total_purchase_store' );

add_action( 'wp_ajax_nopriv_atlantis_get_store_location', 'atlantis_get_store_location' );
add_action( 'wp_ajax_atlantis_get_store_location', 'atlantis_get_store_location' );

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


function atlantis_get_store_location(){
   if( isset( $_POST['action'] ) && $_POST['action'] == 'atlantis_get_store_location' ){

      $lat = isset($_POST['lat']) ? $_POST['lat'] : 0.0;
      $lng = isset($_POST['lng']) ? $_POST['lng'] : 0.0;

      if($lat == 0.0 && $lng == 0.0){
         wp_send_json_error(['message' => 'store_location_not_found']);
         wp_die();
      }

      // sql search with current location
      $sql = "SELECT 
            wp_watergo_store.id,
            wp_watergo_store.longitude,
            wp_watergo_store.latitude,
            wp_watergo_store.name,
            wp_watergo_store.store_type,
            AVG(wp_watergo_reviews.rating) AS avg_rating,
            (6371 * acos(
               cos(radians($lat)) * cos(radians(wp_watergo_store.latitude)) * cos(radians(wp_watergo_store.longitude) - radians($lng)) +
               sin(radians($lat)) * sin(radians(wp_watergo_store.latitude))
            )) AS distance,

            wp_watergo_photo.url as store_image

         FROM wp_watergo_store
         LEFT JOIN wp_watergo_reviews
            ON wp_watergo_reviews.related_id = wp_watergo_store.id 

         LEFT JOIN wp_watergo_photo
            ON wp_watergo_photo.upload_by = wp_watergo_store.id AND wp_watergo_photo.kind_photo = 'store'

         GROUP BY
            wp_watergo_store.id,
            wp_watergo_store.longitude,
            wp_watergo_store.latitude,
            wp_watergo_store.name,
            wp_watergo_store.store_type,
            wp_watergo_photo.url

         HAVING distance <= 2 -- Adjust the distance value as desired (in kilometers)
         ORDER BY distance
         LIMIT 20
      ";

      global $wpdb;
      $res = $wpdb->get_results($sql);

      if( empty($res )){
         wp_send_json_error(['message' => 'store_location_not_found']);
         wp_die();
      }

      wp_send_json_success(['message' => 'store_location_found', 'data' => $res]);
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
         wp_watergo_store.*,
         wp_watergo_photo.url as store_image

         FROM wp_watergo_store 

         LEFT JOIN wp_watergo_photo
         ON wp_watergo_photo.upload_by = wp_watergo_store.id AND wp_watergo_photo.kind_photo = 'store'

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


function atlantis_load_product_by_store(){
   if( isset( $_POST['action'] ) && $_POST['action'] == 'atlantis_load_product_by_store' ){
      $store_id = isset($_POST['store_id']) ? $_POST['store_id'] : 0;
      $product_id = isset($_POST['product_id']) ? $_POST['product_id'] : 0;

      if( $store_id == 0 || $product_id == 0 ){
         wp_send_json_error(['message' => 'product_not_found 1']);
         wp_die();
      }

      global $wpdb;
      $sql = "SELECT wp_watergo_products.*, 
            discount.id as discount_id,
            discount.product_id as discount_product_id,
            discount.discount as discount_percent,
            discount.from as discount_from,
            discount.to as discount_to,

            wp_watergo_photo.url as product_image

         FROM wp_watergo_products
         LEFT JOIN wp_watergo_discounts as discount
         ON discount.product_id = wp_watergo_products.id
         LEFT JOIN wp_watergo_photo
         ON wp_watergo_photo.upload_by = wp_watergo_products.id AND wp_watergo_photo.kind_photo = 'product'

         WHERE wp_watergo_products.store_id = $store_id
         AND wp_watergo_products.id != $product_id

         ORDER BY wp_watergo_products.id DESC LIMIT 10
      ";

      $res = $wpdb->get_results( $sql);
      if( empty($res ) ){
         wp_send_json_error(['message' => 'product_not_found 2', 'data' => $res]);
         wp_die();
      }
      wp_send_json_success(['message' => 'product_found', 'data' => $res ]);
      wp_die();
      
   }
   
}

function atlantis_load_all_product_by_store(){
   if( isset( $_POST['action'] ) && $_POST['action'] == 'atlantis_load_all_product_by_store' ){
      $store_id = isset($_POST['store_id']) ? $_POST['store_id'] : 0;

      if( $store_id == 0 ){
         wp_send_json_error(['message' => 'product_not_found']);
         wp_die();
      }

      global $wpdb;
      $sql = "SELECT wp_watergo_products.*, 
         discount.id as discount_id,
         discount.product_id as discount_product_id,
         discount.discount as discount_percent,
         discount.from as discount_from,
         discount.to as discount_to,

         wp_watergo_photo.url as product_image

      FROM wp_watergo_products
      LEFT JOIN wp_watergo_discounts as discount
      ON discount.product_id = wp_watergo_products.id
      
      LEFT JOIN wp_watergo_photo
      ON wp_watergo_photo.upload_by = wp_watergo_products.id AND wp_watergo_photo.kind_photo = 'product'

      WHERE wp_watergo_products.store_id = $store_id
      ORDER BY wp_watergo_products.id DESC";

      $res = $wpdb->get_results( $sql);
      if( empty($res ) ){
         wp_send_json_error(['message' => 'product_not_found', 'data' => $res]);
         wp_die();
      }
      wp_send_json_success(['message' => 'product_found', 'data' => $res ]);
      wp_die();
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
      $sql = "SELECT wp_watergo_store.*,
         wp_watergo_photo.url as store_image

         FROM wp_watergo_store 

         LEFT JOIN wp_watergo_photo
         ON wp_watergo_photo.upload_by = wp_watergo_store.id AND wp_watergo_photo.kind_photo = 'store'

         WHERE wp_watergo_store.id = $store_id 
      ";
      $res = $wpdb->get_results($sql);

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