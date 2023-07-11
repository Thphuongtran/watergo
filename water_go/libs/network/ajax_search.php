<?php

add_action( 'wp_ajax_nopriv_atlantis_search_data', 'atlantis_search_data' );
add_action( 'wp_ajax_atlantis_search_data', 'atlantis_search_data' );

function atlantis_search_data(){
   if( isset( $_POST['action'] ) && $_POST['action'] == 'atlantis_search_data' ){

      $lat = isset($_POST['lat']) ? $_POST['lat'] : 10.780900239854994;
      $lng = isset($_POST['lng']) ? $_POST['lng'] : 106.7226271387539;
      $search = isset($_POST['search']) ? $_POST['search'] : '';

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
         wp_watergo_products.product_type,
         wp_watergo_products.quantity,
         wp_watergo_products.weight,
         wp_watergo_products.length_width,
         wp_watergo_products.name,

         p1.url as product_image,
         p2.url as store_image
         
      FROM wp_watergo_store
      LEFT JOIN wp_watergo_reviews
         ON wp_watergo_reviews.related_id = wp_watergo_store.id 
      
      LEFT JOIN wp_watergo_products
         ON wp_watergo_products.store_id = wp_watergo_store.id

      LEFT JOIN wp_watergo_photo as p1
         ON p1.upload_by = wp_watergo_products.id AND p1.kind_photo = 'product'

      LEFT JOIN wp_watergo_photo as p2
         ON p2.upload_by = wp_watergo_store.id AND p2.kind_photo = 'store'
      
      WHERE wp_watergo_products.name LIKE '%{$search}%'
         
      GROUP BY
         wp_watergo_store.id,
         wp_watergo_store.longitude,
         wp_watergo_store.latitude,
         wp_watergo_store.name,
         wp_watergo_store.store_type,
         wp_watergo_products.name,
         wp_watergo_products.product_type,
         wp_watergo_products.quantity,
         wp_watergo_products.weight,
         wp_watergo_products.length_width,

         p1.url,
         p2.url
         
      HAVING distance <= 5 -- Adjust the distance value as desired (in kilometers)
      ORDER BY distance DESC

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