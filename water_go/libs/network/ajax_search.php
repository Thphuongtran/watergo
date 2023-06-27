<?php

add_action( 'wp_ajax_nopriv_atlantis_search_data', 'atlantis_search_data' );
add_action( 'wp_ajax_atlantis_search_data', 'atlantis_search_data' );

function atlantis_search_data(){
   if( isset( $_POST['action'] ) && $_POST['action'] == 'atlantis_search_data' ){

      $lat = isset($_POST['lat']) ? $_POST['lat'] : 0.0;
      $lng = isset($_POST['lng']) ? $_POST['lng'] : 0.0;
      $search = isset($_POST['search']) ? $_POST['search'] : '';

      if( $lat == 0.0 && $lng == 0.0 ){
         wp_send_json_error(['message' => 'search_not_found' ]);
         wp_die();
      }

      $sql = "SELECT 
         -- STORE
         wp_watergo_store.id,
         wp_watergo_store.longitude,
         wp_watergo_store.latitude,
         wp_watergo_store.name,
         wp_watergo_store.store_type,
         
         -- REVIEW
         AVG(wp_watergo_reviews.rating) AS avg_rating,

         -- LOCATION
         (6371 * acos(
            cos(radians($lat)) * cos(radians(wp_watergo_store.latitude)) * cos(radians(wp_watergo_store.longitude) - radians($lng)) +
            sin(radians($lat)) * sin(radians(wp_watergo_store.latitude))
         )) AS distance,

         -- PRODUCT
         wp_watergo_products.id,
         wp_watergo_products.name as product_name,
         wp_watergo_products.price,
         wp_watergo_products.name,

         wp_watergo_photo.url as product_image,
         wp_watergo_photo.url as store_image
         
      FROM wp_watergo_store
      LEFT JOIN wp_watergo_reviews
         ON wp_watergo_reviews.related_id = wp_watergo_store.id 
      
      LEFT JOIN wp_watergo_products
         ON wp_watergo_products.store_id = wp_watergo_store.id

      LEFT JOIN wp_watergo_photo
         ON wp_watergo_photo.upload_by = wp_watergo_products.id AND wp_watergo_photo.kind_photo = 'product'
      LEFT JOIN wp_watergo_photo
         ON wp_watergo_photo.upload_by = wp_watergo_store.id AND wp_watergo_photo.kind_photo = 'store'
      
      WHERE wp_watergo_products.name LIKE '%{$search}%'
         
      GROUP BY
         wp_watergo_store.id,
         wp_watergo_store.longitude,
         wp_watergo_store.latitude,
         wp_watergo_store.name,
         wp_watergo_store.store_type,
         wp_watergo_products.name,

         wp_watergo_photo.url
         
      HAVING distance <= 2 -- Adjust the distance value as desired (in kilometers)
      ORDER BY distance
      LIMIT 20

      ";

      global $wpdb;

      $res = $wpdb->get_results($sql);
      if( empty($res )){
         wp_send_json_error(['message' => 'search_not_found' ]);
         wp_die();
      }
      wp_send_json_error(['message' => 'search_found', 'data' => $res ]);
      wp_die();
   }

}