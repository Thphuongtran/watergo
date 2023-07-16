<?php

add_action( 'wp_ajax_nopriv_atlantis_load_products', 'atlantis_load_products' );
add_action( 'wp_ajax_atlantis_load_products', 'atlantis_load_products' );

add_action( 'wp_ajax_nopriv_atlantis_load_product_recommend', 'atlantis_load_product_recommend' );
add_action( 'wp_ajax_atlantis_load_product_recommend', 'atlantis_load_product_recommend' );

add_action( 'wp_ajax_nopriv_atlantis_load_product_top_related', 'atlantis_load_product_top_related' );
add_action( 'wp_ajax_atlantis_load_product_top_related', 'atlantis_load_product_top_related' );

add_action( 'wp_ajax_nopriv_atlantis_find_product', 'atlantis_find_product' );
add_action( 'wp_ajax_atlantis_find_product', 'atlantis_find_product' );

add_action( 'wp_ajax_nopriv_atlantis_find_product_newest', 'atlantis_find_product_newest' );
add_action( 'wp_ajax_atlantis_find_product_newest', 'atlantis_find_product_newest' );

add_action( 'wp_ajax_nopriv_atlantis_get_product_image', 'atlantis_get_product_image' );
add_action( 'wp_ajax_atlantis_get_product_image', 'atlantis_get_product_image' );

add_action( 'wp_ajax_nopriv_atlantis_get_product_sort', 'atlantis_get_product_sort' );
add_action( 'wp_ajax_atlantis_get_product_sort', 'atlantis_get_product_sort' );

/**
 * @access GET PRODUCT + PHOTO
 */
function atlantis_load_products(){
   if( isset( $_POST['action'] ) && $_POST['action'] == 'atlantis_load_products' ){
      $page = isset($_POST['page']) ? $_POST['page'] : 0;
      $limit = isset($_POST['limit']) ? $_POST['limit'] : 20;
      $type = isset($_POST['type']) ? $_POST['type'] : '';

      $lat = isset($_POST['lat']) ? $_POST['lat'] : 0.0;
      $lng = isset($_POST['lng']) ? $_POST['lng'] : 0.0;
      

      if( $type == '' ){
         wp_send_json_error(['message' => 'product_not_found' ]);
         wp_die();
      }

      global $wpdb;
      // PRODUCT + CATEGORY + PHOTO?
      $sql = "SELECT 
            -- 
            wp_watergo_products.*,
            category.id as category_id,
            category.name as category_name,
            category.category as category_group,
            brand.id as brand_id,
            brand.name as brand_name,
            brand.category as brand_group,
            -- 
            wp_watergo_store.latitude as lat,
            wp_watergo_store.longitude as lng,

            AVG(wp_watergo_reviews.rating) AS avg_rating,

            (6371 * acos(
               cos(radians($lat)) * cos(radians(wp_watergo_store.latitude)) * cos(radians(wp_watergo_store.longitude) - radians($lng)) +
               sin(radians($lat)) * sin(radians(wp_watergo_store.latitude))
            )) AS distance,

            --
            wp_watergo_photo.url as product_image

         FROM wp_watergo_products 

         LEFT JOIN wp_watergo_store
         ON wp_watergo_store.id = wp_watergo_products.store_id

         LEFT JOIN wp_watergo_reviews
         ON wp_watergo_reviews.related_id = wp_watergo_store.id 

         LEFT JOIN wp_watergo_product_category as category
         ON category.id = wp_watergo_products.category

         LEFT JOIN wp_watergo_product_category as brand
         ON brand.id = wp_watergo_products.brand

         LEFT JOIN wp_watergo_photo
         ON wp_watergo_photo.upload_by = wp_watergo_products.id AND wp_watergo_photo.kind_photo = 'product'

         WHERE wp_watergo_products.product_type = '{$type}'
         GROUP BY
            -- 
            wp_watergo_products.id,
            wp_watergo_products.store_id,
            wp_watergo_products.name,
            wp_watergo_products.description,
            wp_watergo_products.category,
            wp_watergo_products.brand,
            wp_watergo_products.price,
            wp_watergo_products.stock,
            wp_watergo_products.quantity,
            wp_watergo_products.volume,
            wp_watergo_products.weight,
            wp_watergo_products.length_width,
            wp_watergo_products.mark_out_of_stock,
            -- 
            category.id,
            category.name,
            category.category,
            brand.id,
            brand.name,
            brand.category,
            -- 
            wp_watergo_store.latitude,
            wp_watergo_store.longitude,
            -- 
            wp_watergo_photo.url

         ORDER BY wp_watergo_products.id DESC
         LIMIT {$page},{$limit}
      ";
      
      $get_results = $wpdb->get_results($sql);
      if( empty( $get_results ) ){
         wp_send_json_error(['message' => 'product_not_found' ]);
         wp_die();
      }
      wp_send_json_success(['message' => 'product_found', 'data' => $get_results ]);
      wp_die();
      
   }
}

/*
1. list all product when user order success
2. if no order user make before, let make piority product discount
3. if no discount product yet. just random product by location nearby

*/
function atlantis_load_product_recommend(){
   if( isset( $_POST['action'] ) && $_POST['action'] == 'atlantis_load_product_recommend' ){

      global $wpdb;
      $sql_type = '';

      $lat = isset($_POST['lat']) ? $_POST['lat'] : 10.780900239854994;
      $lng = isset($_POST['lng']) ? $_POST['lng'] : 106.7226271387539;

      $filter = isset($_POST['filter']) ? $_POST['filter'] : 'nearest';

      if( $filter == '' || $filter == null ){
         wp_send_json_error(['message' => 'product_not_found 2' ]);
         wp_die();
      }

      $product_id_already_exists = isset($_POST['product_id_already_exists']) ? $_POST['product_id_already_exists'] : 0;
      $product_id_already_exists = json_decode( $product_id_already_exists );
      $placeholders = 0;

      $wheres = [];

      if( is_array($product_id_already_exists) && ! empty($product_id_already_exists) ){
         foreach( $product_id_already_exists as $ids ){
            $wheres[] = $ids;
         }
         $placeholders = implode(',', $wheres);
      }

      $sql_order_success = "SELECT 
         wp_watergo_order_group.order_group_store_id as store_id,
         wp_watergo_order_group.order_group_product_id as product_id,
         wp_watergo_products.*,
         -- 

         wp_watergo_photo.url as product_image,

         AVG(wp_watergo_reviews.rating) AS avg_rating,

         (6371 * acos(
            cos(radians($lat)) * cos(radians(wp_watergo_store.latitude)) * cos(radians(wp_watergo_store.longitude) - radians($lng)) +
            sin(radians($lat)) * sin(radians(wp_watergo_store.latitude))
         )) AS distance
      
      FROM wp_watergo_order
      
      LEFT JOIN wp_watergo_order_group
      ON wp_watergo_order.hash_id = wp_watergo_order_group.hash_id

      LEFT JOIN wp_watergo_products
      ON wp_watergo_products.id = wp_watergo_order_group.order_group_product_id

      LEFT JOIN wp_watergo_store
      ON wp_watergo_store.id = wp_watergo_products.store_id

      LEFT JOIN wp_watergo_photo
      ON wp_watergo_photo.upload_by = wp_watergo_products.id AND wp_watergo_photo.kind_photo = 'product'

      LEFT JOIN wp_watergo_reviews
      ON wp_watergo_reviews.related_id = wp_watergo_store.id 

      WHERE wp_watergo_order.order_status = 'complete'
      AND wp_watergo_products.id NOT IN ($placeholders) -- FAKE LIMIT

      GROUP BY 
         wp_watergo_order_group.order_group_store_id,
         wp_watergo_order_group.order_group_product_id,
         wp_watergo_products.id,

         watergo.wp_watergo_store.latitude,
         watergo.wp_watergo_store.longitude,
                        
         wp_watergo_products.store_id,
         wp_watergo_products.name,
         wp_watergo_products.product_type,
         wp_watergo_products.description,
         wp_watergo_products.category,
         wp_watergo_products.brand,
         wp_watergo_products.price,
         wp_watergo_products.stock,
         wp_watergo_products.quantity,
         wp_watergo_products.volume,
         wp_watergo_products.weight,
         wp_watergo_products.length_width,
         wp_watergo_products.mark_out_of_stock,

         wp_watergo_photo.url
      ";

      if( $filter == 'nearest' ){
         $sql_order_success .= " ORDER BY distance ASC ";
      }
      if( $filter == 'cheapest' ){
         $sql_order_success .= " ORDER BY wp_watergo_products.price ASC ";
      }
      if( $filter == 'top_rated' ){
         $sql_order_success .= " ORDER BY avg_rating DESC ";
      }

      $sql_order_success .= ' LIMIT 10 ';

      $res = $wpdb->get_results($sql_order_success);

      if( ! empty( $res ) ){
         wp_send_json_success(['message' => 'product_found', 'data' => $res ]);
         wp_die();
      }

      $sql_unique = "SELECT
         wp_watergo_products.id,
         wp_watergo_products.store_id,
         wp_watergo_products.product_type,
         wp_watergo_products.name,
         wp_watergo_products.description,
         wp_watergo_products.category,
         wp_watergo_products.brand,
         wp_watergo_products.price,
         wp_watergo_products.stock,
         wp_watergo_products.quantity,
         wp_watergo_products.volume,
         wp_watergo_products.weight,
         wp_watergo_products.length_width,
         wp_watergo_products.mark_out_of_stock,
         wp_watergo_store.latitude,
         wp_watergo_store.longitude,
         p1.url as product_image,
         AVG(wp_watergo_reviews.rating) AS avg_rating,
         (6371 * acos(
            cos(radians($lat)) * cos(radians(wp_watergo_store.latitude)) * 
            cos(radians(wp_watergo_store.longitude) - radians($lng)) + 
            sin(radians($lat)) * sin(radians(wp_watergo_store.latitude))
         )) AS distance
      FROM wp_watergo_products
      LEFT JOIN wp_watergo_photo as p1 ON p1.upload_by = wp_watergo_products.id AND p1.kind_photo = 'product'
      LEFT JOIN wp_watergo_store ON wp_watergo_store.id = wp_watergo_products.store_id
      LEFT JOIN wp_watergo_reviews ON wp_watergo_reviews.related_id = wp_watergo_products.id
      WHERE wp_watergo_products.id NOT IN ($placeholders) -- FAKE LIMIT
      GROUP BY
         wp_watergo_products.id,
         wp_watergo_products.store_id,
         wp_watergo_products.product_type,
         wp_watergo_products.name,
         wp_watergo_products.description,
         wp_watergo_products.category,
         wp_watergo_products.brand,
         wp_watergo_products.price,
         wp_watergo_products.stock,
         wp_watergo_products.quantity,
         wp_watergo_products.volume,
         wp_watergo_products.weight,
         wp_watergo_products.length_width,
         wp_watergo_products.mark_out_of_stock,
         wp_watergo_store.latitude,
         wp_watergo_store.longitude,
         p1.url
      ORDER BY RAND() DESC,

      ";

      if( $filter == 'nearest' ){
         $sql_unique .= " distance ASC ";
      }
      if( $filter == 'cheapest' ){
         $sql_unique .= " wp_watergo_products.price ASC ";
      }
      if( $filter == 'top_rated' ){
         $sql_unique .= " avg_rating DESC ";
      }

      $sql_unique .= ' LIMIT 10 ';


      $res = $wpdb->get_results($sql_unique);

      if( empty( $res ) ){
         wp_send_json_error(['message' => 'product_not_found 1' ]);
         wp_die();
      }

      wp_send_json_success(['message' => 'product_found', 'data' => $res, 'test' => $sql_unique ]);
      wp_die();


   }
}

function atlantis_find_product(){
   if( isset( $_POST['action'] ) && $_POST['action'] == 'atlantis_find_product' ){
      $product_id = isset($_POST['product_id']) ? $_POST['product_id'] : 0;

      if($product_id == 0 ){
         wp_send_json_error(['message' => 'product_not_found']);
         wp_die();
      }

      $sql = "SELECT wp_watergo_products.*,
         wp_watergo_photo.url as product_image

         FROM wp_watergo_products 
         LEFT JOIN wp_watergo_photo
         ON wp_watergo_photo.upload_by = wp_watergo_products.id AND wp_watergo_photo.kind_photo = 'product'
         WHERE wp_watergo_products.id = $product_id
      ";

      global $wpdb;
      $res = $wpdb->get_results($sql);

      if( empty($res )){
         wp_send_json_error(['message' => 'product_not_found']);
         wp_die();  
      }

      wp_send_json_success(['message' => 'product_found', 'data' => $res[0] ]);
      wp_die();
   }
}


function atlantis_find_product_newest(){
   if( isset( $_POST['action'] ) && $_POST['action'] == 'atlantis_find_product_newest' ){
      $store_id = isset($_POST['store_id']) ? $_POST['store_id'] : 0;

      if( !is_numeric($store_id) && $store_id == 0){
         wp_send_json_error(['message' => 'product_not_found 1']);
         wp_die();
      }

      $sql = "SELECT wp_watergo_products.*,
            wp_watergo_photo.url as product_image

         FROM wp_watergo_products 

         LEFT JOIN wp_watergo_photo
         ON wp_watergo_photo.upload_by = wp_watergo_products.id AND wp_watergo_photo.kind_photo = 'product'

         WHERE wp_watergo_products.store_id = $store_id
         ORDER BY wp_watergo_products.id DESC
         LIMIT 1";

      global $wpdb;
      $res = $wpdb->get_results( $sql );

      if( empty($res )){
         wp_send_json_error(['message' => 'product_not_found 2']);
         wp_die();  
      }

      wp_send_json_success(['message' => 'product_found', 'data' => $res[0] ]);
      wp_die();

   }
}


function atlantis_get_product_image(){
   if( isset( $_POST['action'] ) && $_POST['action'] == 'atlantis_get_product_image' ){

      $product_id = isset($_POST['product_id']) ? $_POST['product_id'] : 0;

      $sql = "SELECT url FROM wp_watergo_photo
         WHERE upload_by = $product_id AND kind_photo = 'product'";

      global $wpdb;
      $res = $wpdb->get_results($sql);
      
      if( empty($res )){
         wp_send_json_error(['message' => 'image_not_found']);
         wp_die();  
      }

      wp_send_json_success(['message' => 'image_found', 'data' => $res[0] ]);
      wp_die();
   }
}


// get product rated by category [ water | ice ]
function atlantis_load_product_top_related(){
   if(isset($_POST['action']) && $_POST['action'] == 'atlantis_load_product_top_related' ){
      
      $category_id = isset($_POST['category_id']) ? $_POST['category_id'] : 0;
      $page = isset($_POST['page']) ? $_POST['page'] : 0;
      $limit = isset($_POST['limit']) ? $_POST['limit'] : 10;

      if($category_id == 0){

         wp_send_json_success(['message' => 'product_not_found' ]);
         wp_die();
      }

      $sql = "SELECT wp_watergo_products.*,

         wp_watergo_photo.url as product_image

      FROM wp_watergo_products 

      LEFT JOIN wp_watergo_photo
      ON wp_watergo_photo.upload_by = wp_watergo_products.id AND wp_watergo_photo.kind_photo = 'product'

      WHERE wp_watergo_products.category = $category_id
      ORDER BY wp_watergo_products.id DESC
      ";


      global $wpdb;
      $res = $wpdb->get_results($sql);
      
      if( empty($res )){
         wp_send_json_error(['message' => 'product_not_found']);
         wp_die();  
      }

      wp_send_json_success(['message' => 'product_found' , 'data' => $res ]);
      wp_die();
   }
}

function atlantis_get_product_sort(){
   if( isset($_POST['action']) && $_POST['action'] == 'atlantis_get_product_sort' ){

      // nearest | cheapest | top_rated
      $filter        = isset($_POST['filter'])        ? $_POST['filter'] : 'nearest';
      $paged         = isset($_POST['paged'] )        ? (int) $_POST['paged'] : 0;
      $perPage       = isset($_POST['perPage'] )      ? $_POST['perPage'] : 10;
      $product_type  = isset($_POST['product_type'] ) ? $_POST['product_type'] : '';

      $product_id_already_exists = isset($_POST['product_id_already_exists']) ? $_POST['product_id_already_exists'] : 0;

      $lat = isset($_POST['lat']) ? $_POST['lat'] : 10.780900239854994;
      $lng = isset($_POST['lng']) ? $_POST['lng'] : 106.7226271387539;

      if( $filter == '' || $filter == null ){
         wp_send_json_error(['message' => 'product_not_found' ]);
         wp_die();
      }

      $product_id_already_exists = json_decode( $product_id_already_exists );
      $placeholders = 0;

      $wheres = [];

      if( is_array($product_id_already_exists) && ! empty($product_id_already_exists) ){
         foreach( $product_id_already_exists as $ids ){
            $wheres[] = $ids;
         }
         $placeholders = implode(',', $wheres);
      }


      global $wpdb;

      $sql = "SELECT 
            -- 
            wp_watergo_products.*,
            category.id as category_id,
            category.name as category_name,
            category.category as category_group,
            brand.id as brand_id,
            brand.name as brand_name,
            brand.category as brand_group,
            -- 
            wp_watergo_store.latitude as lat,
            wp_watergo_store.longitude as lng,

            AVG(wp_watergo_reviews.rating) AS avg_rating,

            (6371 * acos(
               cos(
                  radians($lat)) * cos(radians(wp_watergo_store.latitude)) * 
                  cos(radians(wp_watergo_store.longitude) - radians($lng)
               ) + sin(radians($lat)) * sin(radians(wp_watergo_store.latitude))
            )) AS distance,

            --
            wp_watergo_photo.url as product_image

         FROM wp_watergo_products 

         LEFT JOIN wp_watergo_store
         ON wp_watergo_store.id = wp_watergo_products.store_id

         LEFT JOIN wp_watergo_reviews
         ON wp_watergo_reviews.related_id = wp_watergo_store.id 

         LEFT JOIN wp_watergo_product_category as category
         ON category.id = wp_watergo_products.category

         LEFT JOIN wp_watergo_product_category as brand
         ON brand.id = wp_watergo_products.brand

         LEFT JOIN wp_watergo_photo
         ON wp_watergo_photo.upload_by = wp_watergo_products.id AND wp_watergo_photo.kind_photo = 'product'

         WHERE wp_watergo_products.product_type = '$product_type'
         AND wp_watergo_products.id NOT IN ($placeholders) -- FAKE LIMIT
         GROUP BY
            -- 
            wp_watergo_products.id,
            wp_watergo_products.store_id,
            wp_watergo_products.name,
            wp_watergo_products.description,
            wp_watergo_products.category,
            wp_watergo_products.brand,
            wp_watergo_products.price,
            wp_watergo_products.stock,
            wp_watergo_products.quantity,
            wp_watergo_products.volume,
            wp_watergo_products.weight,
            wp_watergo_products.length_width,
            wp_watergo_products.mark_out_of_stock,
            -- 
            category.name,
            category.category,
            brand.id,
            brand.name,
            brand.category,
            -- 
            wp_watergo_store.latitude,
            wp_watergo_store.longitude,
            -- 
            wp_watergo_photo.url
      ";


      if( $filter == 'nearest' ){
         $sql .= " ORDER BY distance ASC ";
      }
      if( $filter == 'cheapest' ){
         $sql .= " ORDER BY wp_watergo_products.price ASC ";
      }
      if( $filter == 'top_rated' ){
         $sql .= " ORDER BY avg_rating DESC ";
      }

      $sql .= " LIMIT 10 ";
      
      $res = $wpdb->get_results($sql);

      if( empty( $res ) ){
         wp_send_json_error(['message' => 'product_not_found' ]);
         wp_die();
      }

      wp_send_json_success(['message' => 'product_found', 'data' => $res ]);
      wp_die();

   }
}