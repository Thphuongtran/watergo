<?php

add_action( 'wp_ajax_nopriv_atlantis_load_products', 'atlantis_load_products' );
add_action( 'wp_ajax_atlantis_load_products', 'atlantis_load_products' );

add_action( 'wp_ajax_nopriv_atlantis_load_product_recommend', 'atlantis_load_product_recommend' );
add_action( 'wp_ajax_atlantis_load_product_recommend', 'atlantis_load_product_recommend' );

add_action( 'wp_ajax_nopriv_atlantis_get_product_top_related', 'atlantis_get_product_top_related' );
add_action( 'wp_ajax_atlantis_get_product_top_related', 'atlantis_get_product_top_related' );

add_action( 'wp_ajax_nopriv_atlantis_find_product', 'atlantis_find_product' );
add_action( 'wp_ajax_atlantis_find_product', 'atlantis_find_product' );

add_action( 'wp_ajax_nopriv_atlantis_find_product_newest', 'atlantis_find_product_newest' );
add_action( 'wp_ajax_atlantis_find_product_newest', 'atlantis_find_product_newest' );

add_action( 'wp_ajax_nopriv_atlantis_get_product_sort', 'atlantis_get_product_sort' );
add_action( 'wp_ajax_atlantis_get_product_sort', 'atlantis_get_product_sort' );

add_action( 'wp_ajax_nopriv_atlantis_check_product_discount', 'atlantis_check_product_discount' );
add_action( 'wp_ajax_atlantis_check_product_discount', 'atlantis_check_product_discount' );

add_action( 'wp_ajax_nopriv_atlantis_is_product_out_of_stock', 'atlantis_is_product_out_of_stock' );
add_action( 'wp_ajax_atlantis_is_product_out_of_stock', 'atlantis_is_product_out_of_stock' );


function atlantis_is_product_out_of_stock(){

   if( isset($_POST['action']) && $_POST['action'] == 'atlantis_is_product_out_of_stock' ){
      $product_id       = isset($_POST['product_id'])       ? $_POST['product_id'] : 0;

      $res = func_is_product_out_of_stock($product_id);

      if( $res == true ){
         wp_send_json_success(['message' => 'product_can_order']);
         wp_die();
      }

      wp_send_json_error(['message' => 'product_is_out_of_stock' ]);
      wp_die();

   }

}

/**
 * @access GET PRODUCT + PHOTO
 */
function atlantis_load_products(){
   if( isset( $_POST['action'] ) && $_POST['action'] == 'atlantis_load_products' ){
      $page    = isset($_POST['page']) ? $_POST['page'] : 0;
      $limit   = isset($_POST['limit']) ? $_POST['limit'] : 20;
      $type    = isset($_POST['type']) ? $_POST['type'] : '';
      $lat     = isset($_POST['lat']) ? $_POST['lat'] : 0.0;
      $lng     = isset($_POST['lng']) ? $_POST['lng'] : 0.0;
      

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
            )) AS distance

            --

         FROM wp_watergo_products 

         LEFT JOIN wp_watergo_store
         ON wp_watergo_store.id = wp_watergo_products.store_id

         LEFT JOIN wp_watergo_reviews
         ON wp_watergo_reviews.store_id = wp_watergo_store.id 

         LEFT JOIN wp_watergo_product_category as category
         ON category.id = wp_watergo_products.category

         LEFT JOIN wp_watergo_product_category as brand
         ON brand.id = wp_watergo_products.brand

         WHERE wp_watergo_products.product_type = '{$type}'
         AND wp_watergo_products.product_hidden != 1

         GROUP BY
            -- 
            wp_watergo_products.id,
            wp_watergo_products.store_id,
            wp_watergo_products.name,
            wp_watergo_products.description,
            wp_watergo_products.category,
            wp_watergo_products.brand,
            wp_watergo_products.price,
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

      $lat     = isset($_POST['lat']) ? $_POST['lat'] : 10.780900239854994;
      $lng     = isset($_POST['lng']) ? $_POST['lng'] : 106.7226271387539;

      $paged   = isset($_POST['paged'] )   ? (int) $_POST['paged']   : 0;
      $perPage = isset($_POST['perPage'] ) ? (int) $_POST['perPage'] : 10;

      $filter  = isset($_POST['filter']) ? $_POST['filter'] : '';
      
      global $wpdb;

      $user_id = get_current_user_id();
      $sql_check_has_order_success = "SELECT COUNT(*) AS has_order_success FROM wp_watergo_order WHERE order_by = $user_id AND order_status = 'complete' ";
      $res_check_has_order_success = $wpdb->get_results($sql_check_has_order_success);

      $check = '';

      // $user_id = 50; // demo

      /**
      *  @access HAS ORDER
      */ 

      if( $res_check_has_order_success[0]->has_order_success != null && $res_check_has_order_success[0]->has_order_success > 0 ){
         $sql_has_order = "SELECT
            wp_watergo_products.*,
            wp_watergo_order.order_time_completed,
            (6371 * acos(
               cos(radians($lat)) * cos(radians(wp_watergo_store.latitude)) * cos(radians(wp_watergo_store.longitude) - radians($lng)) +
               sin(radians($lat)) * sin(radians(wp_watergo_store.latitude))
            )) AS distance

            FROM wp_watergo_order
            LEFT JOIN wp_watergo_order_group ON wp_watergo_order_group.hash_id = wp_watergo_order.hash_id
            LEFT JOIN wp_watergo_products ON wp_watergo_order_group.order_group_product_id = wp_watergo_products.id
            LEFT JOIN wp_watergo_store ON wp_watergo_store.id = wp_watergo_order.order_store_id

            LEFT JOIN (
               SELECT store_id, AVG(rating) AS avg_rating
               FROM wp_watergo_reviews
               GROUP BY store_id
            ) AS reviews_avg ON reviews_avg.store_id = wp_watergo_products.store_id

            WHERE wp_watergo_order.order_by = $user_id 
            AND order_status = 'complete' AND wp_watergo_products.mark_out_of_stock = 0
            AND wp_watergo_products.product_hidden != 1
            GROUP BY wp_watergo_products.id
            ORDER BY wp_watergo_order.order_time_completed DESC
            LIMIT {$paged}, {$perPage}

         ";

         $res = $wpdb->get_results( $sql_has_order);

         if( ! empty( $res ) ){
            $res = atlantis_component_extract_product($res);
         }else{
            wp_send_json_error(['message' => 'product_not_found']);
            wp_die();
         }

         wp_send_json_success(['message' => 'product_found', 'data' => $res ]);
         wp_die();

      /**
       * @access NO ORDER SUCCESS
       *  */
      }

      wp_send_json_error(['message' => 'product_not_found']);
      wp_die();
      
   }
}


add_action( 'wp_ajax_nopriv_atlantis_load_product_recommend_discount', 'atlantis_load_product_recommend_discount' );
add_action( 'wp_ajax_atlantis_load_product_recommend_discount', 'atlantis_load_product_recommend_discount' );

function atlantis_load_product_recommend_discount(){
   if ( $_POST['action'] && $_POST['action'] == 'atlantis_load_product_recommend_discount' ){

      $paged   = isset($_POST['paged'] )   ? (int) $_POST['paged']   : 0;
      $perPage = isset($_POST['perPage'] ) ? (int) $_POST['perPage'] : 10;

      $lat     = isset($_POST['lat']) ? $_POST['lat'] : 10.780900239854994;
      $lng     = isset($_POST['lng']) ? $_POST['lng'] : 106.7226271387539;

      $current_time = atlantis_current_date_only();

      $sql = "SELECT 
         wp_watergo_products.*,
         (6371 * acos(
            cos(radians($lat)) * cos(radians(wp_watergo_store.latitude)) * cos(radians(wp_watergo_store.longitude) - radians($lng)) +
            sin(radians($lat)) * sin(radians(wp_watergo_store.latitude))
         )) AS distance

         FROM wp_watergo_products

         LEFT JOIN wp_watergo_store
         ON wp_watergo_store.id = wp_watergo_products.store_id

         LEFT JOIN (
            SELECT store_id, AVG(rating) AS avg_rating
            FROM wp_watergo_reviews
            GROUP BY store_id
         ) AS reviews_avg ON reviews_avg.store_id = wp_watergo_products.store_id

         WHERE DATE_FORMAT(discount_to, '%Y-%m-%d') >= '$current_time'
         AND DATE_FORMAT(discount_from, '%Y-%m-%d') <= '$current_time'
         AND wp_watergo_products.has_discount = 1 
         AND wp_watergo_products.mark_out_of_stock = 0
         AND wp_watergo_products.product_hidden != 1 

         ORDER BY wp_watergo_products.discount_percent DESC
         LIMIT {$paged}, {$perPage}
      ";

      global $wpdb;

      $res = $wpdb->get_results( $sql );

      if( !empty( $res ) ){
         $res = atlantis_component_extract_product($res);

         wp_send_json_success(['message' => 'product_found', 'data' => $res ]);
         wp_die();
      }

      wp_send_json_error(['message' => 'product_not_found']);
      wp_die();

   }
}

add_action( 'wp_ajax_nopriv_atlantis_load_product_recommend_random', 'atlantis_load_product_recommend_random' );
add_action( 'wp_ajax_atlantis_load_product_recommend_random', 'atlantis_load_product_recommend_random' );

function atlantis_load_product_recommend_random(){
   if( isset($_POST['action']) && $_POST['action'] == 'atlantis_load_product_recommend_random'){
      $paged   = isset($_POST['paged'] )   ? (int) $_POST['paged']   : 0;
      $perPage = isset($_POST['perPage'] ) ? (int) $_POST['perPage'] : 10;

      $lat     = isset($_POST['lat']) ? $_POST['lat'] : 10.780900239854994;
      $lng     = isset($_POST['lng']) ? $_POST['lng'] : 106.7226271387539;

      $sql = "SELECT 
         wp_watergo_products.*,
         (6371 * acos(
            cos(radians($lat)) * cos(radians(wp_watergo_store.latitude)) * cos(radians(wp_watergo_store.longitude) - radians($lng)) +
            sin(radians($lat)) * sin(radians(wp_watergo_store.latitude))
         )) AS distance

         FROM wp_watergo_products

         LEFT JOIN wp_watergo_store
         ON wp_watergo_store.id = wp_watergo_products.store_id

         LEFT JOIN (
            SELECT store_id, AVG(rating) AS avg_rating
            FROM wp_watergo_reviews
            GROUP BY store_id
         ) AS reviews_avg ON reviews_avg.store_id = wp_watergo_products.store_id
         
         WHERE wp_watergo_products.mark_out_of_stock = 0
         AND wp_watergo_products.product_hidden != 1

         ORDER BY RAND() DESC
         LIMIT {$paged}, {$perPage}
      ";

      global $wpdb;

      $res = $wpdb->get_results( $sql );

      if( !empty( $res ) ){

         $res = atlantis_component_extract_product($res);

         wp_send_json_success(['message' => 'product_found', 'data' => $res ]);
         wp_die();
      }

      wp_send_json_error(['message' => 'product_not_found']);
      wp_die();

   }
}


function atlantis_find_product(){
   if( isset( $_POST['action'] ) && $_POST['action'] == 'atlantis_find_product' ){
      $product_id       = isset($_POST['product_id'])     ? $_POST['product_id'] : 0;
      $limit_image      = isset($_POST['limit_image'])    ? $_POST['limit_image'] : true;
      $image_size       = isset($_POST['image_size'])     ? $_POST['image_size'] : 'medium';
      $random_product   = isset($_POST['random_product']) ? $_POST['random_product'] : 0;

      $is_get_product_pending = isset($_POST['get_product_pending']) ? (int) $_POST['get_product_pending'] : 0;
      
      if($product_id == 0 ){
         wp_send_json_error(['message' => 'product_not_found']);
         wp_die();
      }

      $product = func_atlantis_get_product_by([
         'id'           => $product_id,
         'get_by'       => $is_get_product_pending == 1 ? 'product_id_pending' : 'product_id',
         'limit_image'  => $limit_image == 1 ? true : false,
         'image_size'   => $image_size
         // 'paged'        => $paged
      ]);

      if( empty($product ) && $random_product == 0){
         wp_send_json_error(['message' => 'product_not_found']);
         wp_die();
      }else if( empty($product) && $random_product == 1 ){

         global $wpdb;
         // GET RANDOM PRODUCT
         $sql_find_store = "SELECT store_id FROM wp_watergo_products WHERE id = $product_id";
         $res_find_store = $wpdb->get_results( $sql_find_store );
         $store_id = (int) $res_find_store[0]->store_id ;

         $sql_random_product = "SELECT * FROM wp_watergo_products WHERE store_id = $store_id AND product_hidden != 1 ORDER BY RAND() LIMIT 1";
         $res_random_product = $wpdb->get_results( $sql_random_product);

         if( empty( $res_random_product )){
            wp_send_json_error(['message' => 'product_not_found']);
            wp_die();
         }

         if( !empty($res_random_product ) ){
            $res_random_product = atlantis_component_extract_product($res_random_product);
         }

         wp_send_json_success(['message' => 'product_found', 'data' => $res_random_product[0] ]);
         wp_die();
      }

      wp_send_json_success(['message' => 'product_found', 'data' => $product[0], 'limit_image' => $limit_image ]);
      wp_die();

      
   }
}


function atlantis_find_product_newest(){
   if( isset( $_POST['action'] ) && $_POST['action'] == 'atlantis_find_product_newest' ){
      $store_id = isset($_POST['store_id']) ? $_POST['store_id'] : 0;
      $product = func_atlantis_get_product_by([
         'get_by' => 'store_id',
         'id'     => $store_id,
         'limit'  => -1
      ]);
      if( empty($product )){
         wp_send_json_error(['message' => 'product_not_found 2']);
         wp_die();  
      }
      wp_send_json_success(['message' => 'product_found', 'data' => $product[0] ]);
      wp_die();
   }
}


// get product rated by category [ water | ice ]
function atlantis_get_product_top_related(){
   if(isset($_POST['action']) && $_POST['action'] == 'atlantis_get_product_top_related' ){
      $category_id = isset($_POST['category_id']) ? $_POST['category_id'] : 0;
      $paged = isset($_POST['paged']) ? $_POST['paged'] : 0;
      $limit = 10;
      
      $res = func_atlantis_get_product_by([
         'id'           => $category_id,
         'get_by'       => 'category_id',
         'limit_image'  => true,
         'paged'        => $paged
      ]);
      if( empty($res )){
         wp_send_json_error(['message' => 'product_not_found']);
         wp_die();  
      }
      wp_send_json_success(['message' => 'product_found' , 'data' => $res, 'paged' => $paged ]);
      wp_die();
   }
}

function atlantis_get_product_sort(){
   if( isset($_POST['action']) && $_POST['action'] == 'atlantis_get_product_sort' ){
      $paged         = isset($_POST['paged'] )        ? (int) $_POST['paged'] : 0;
      $perPage       = isset($_POST['perPage'] )      ? $_POST['perPage'] : 20;

      $paged = $paged * $perPage;

      $product_type  = isset($_POST['product_type'] ) ? $_POST['product_type'] : '';

      $lat = isset($_POST['lat']) ? $_POST['lat'] : 10.780900239854994;
      $lng = isset($_POST['lng']) ? $_POST['lng'] : 106.7226271387539;

      global $wpdb;

      $sql = "SELECT 
         wp_watergo_products.*, 
         (6371 * acos(
            cos(
               radians($lat)) * cos(radians(wp_watergo_store.latitude)) * 
               cos(radians(wp_watergo_store.longitude) - radians($lng)
            ) + sin(radians($lat)) * sin(radians(wp_watergo_store.latitude))
         )) AS distance,
         avg_rating

         FROM wp_watergo_products  
         
         LEFT JOIN wp_watergo_store
         ON wp_watergo_store.id = wp_watergo_products.store_id

         LEFT JOIN (
            SELECT store_id, AVG(rating) AS avg_rating
            FROM wp_watergo_reviews
            GROUP BY store_id
         ) AS reviews_avg ON reviews_avg.store_id = wp_watergo_products.store_id

         WHERE wp_watergo_products.product_type = '$product_type'
         AND wp_watergo_products.mark_out_of_stock != 1
         AND wp_watergo_products.product_hidden != 1 
         
         ORDER BY distance DESC

         LIMIT $paged, $perPage
      ";

      $res = $wpdb->get_results($sql);

      if( !empty( $res )){
         $res = atlantis_component_extract_product($res);
      }

      if( empty( $res ) ){
         wp_send_json_error(['message' => 'product_not_found']);
         wp_die();
      }

      wp_send_json_success(['message' => 'product_found', 'data' => $res]);
      wp_die(); 


   }
}


/**
 * @access GET ALL PROUCT IN STORE
 */

add_action( 'wp_ajax_nopriv_atlantis_get_all_product_by_store', 'atlantis_get_all_product_by_store' );
add_action( 'wp_ajax_atlantis_get_all_product_by_store', 'atlantis_get_all_product_by_store' );

function atlantis_get_all_product_by_store(){
   if( isset( $_POST['action'] ) && $_POST['action'] == 'atlantis_get_all_product_by_store' ){
      $store_id   = isset($_POST['store_id']) ? $_POST['store_id'] : 0;
      $product_id = isset($_POST['product_id']) ? $_POST['product_id'] : 0;
      $limit      = isset($_POST['limit']) ? $_POST['limit'] : 0;

      $args = [
         'id'           => $store_id,
         'get_by'       => 'store_id',
         'exclude_id'   => $product_id,
      ];

      if( $limit == -1){
         $args['limit'] = -1;
      }else if( $limit > 0 && $limit != -1){
         $args['limit'] = $limit;
      }

      $res = func_atlantis_get_product_by($args);

      if( empty($res ) ){
         wp_send_json_error(['message' => 'product_not_found 2']);
         wp_die();
      }

      wp_send_json_success(['message' => 'product_found', 'data' => $res ]);
      wp_die();
      
   }
   
}

function atlantis_check_product_discount(){
   if( isset($_POST['action']) && $_POST['action'] == 'atlantis_check_product_discount'){
      $product_id = isset($_POST['product_id']) ? $_POST['product_id'] : 0;
      if( $product_id == 0 ){
         wp_send_json_error(['message' => 'product_not_found 1']);
         wp_die();
      }

      $sql = "SELECT * FROM wp_watergo_products WHERE id = $product_id AND has_discount = 0";

      global $wpdb;
      $res = $wpdb->get_results($sql);
      if( empty($res)){
         wp_send_json_error(['message' => 'product_not_found 2']);
         wp_die();
      }

      wp_send_json_success(['message' => 'product_found', 'data' => $res ]);
      wp_die();

   }

}

add_action( 'wp_ajax_nopriv_atlantis_product_hidden', 'atlantis_product_hidden' );
add_action( 'wp_ajax_atlantis_product_hidden', 'atlantis_product_hidden' );

function atlantis_product_hidden(){
   if( isset($_POST['action']) && $_POST['action'] == 'atlantis_product_hidden' ){
      $product_id = isset( $_POST['product_id']) ? $_POST['product_id'] : 0;

      if($product_id == 0 ){
         wp_send_json_error(['message' => 'product_not_found']);
         wp_die();
      }
      global $wpdb;
      $updated = $wpdb->update('wp_watergo_products', ['product_hidden' => 1, 'status' => 'delete'], [ 'id' => $product_id ]);
      if($updated ){
         wp_send_json_success(['message' => 'product_found' ]);
         wp_die();
      }

      wp_send_json_error(['message' => 'product_not_found']);
      wp_die();
   }
}

/**
 * @access PRODUCT SORT + FILTER
 */

add_action( 'wp_ajax_nopriv_atlantis_get_product_sort_version2', 'atlantis_get_product_sort_version2' );
add_action( 'wp_ajax_atlantis_get_product_sort_version2', 'atlantis_get_product_sort_version2' );
function atlantis_get_product_sort_version2(){
   if( isset($_POST['action']) && $_POST['action'] == 'atlantis_get_product_sort_version2' ){
      $paged         = isset($_POST['paged'] )        ? $_POST['paged'] : 0;
      $perPage       = isset($_POST['perPage'] )      ? $_POST['perPage'] : 10;
      
      $product_type  = isset($_POST['product_type'] ) ? $_POST['product_type'] : '';
      $category         = isset($_POST['category']) ? $_POST['category'] : null;
      $category_parent  = isset($_POST['category_parent']) ? $_POST['category_parent'] : null;
      $brand            = isset($_POST['brand']) ? $_POST['brand'] : null;
      $volume           = isset($_POST['volume']) ? $_POST['volume'] : null;
      $quantity         = isset($_POST['quantity']) ? $_POST['quantity'] : null;

      $lat           = isset($_POST['lat']) ? $_POST['lat'] : null;
      $lng           = isset($_POST['lng']) ? $_POST['lng'] : null;

      $no_location_found = isset($_POST['no_location_found']) ? $_POST['no_location_found'] : null;

      $where_condition = "WHERE wp_watergo_products.product_type = '$product_type'";
      /**
       * @access WATER
       */

      if( $product_type == 'water' || $product_type == ''){
         $where_condition = "WHERE wp_watergo_products.product_type IN ('water', 'water_device')";
      }else if( $product_type == 'water_device' ){
         $where_condition = "WHERE wp_watergo_products.product_type IN ('water_device') ";
      }
      /**
       * @access ICE
       */

      if( $product_type == 'ice' || $product_type == '' ){
         $where_condition = "WHERE wp_watergo_products.product_type IN ('ice', 'ice_device')";
      }else if( $product_type == 'ice_device' ){
         $where_condition = "WHERE wp_watergo_products.product_type IN ('ice_device') ";
      }


      global $wpdb;

      if( $no_location_found == null || $no_location_found == 0 ){
         // GET SQL WHEN USER SHARE LOCATION
         $sql = "SELECT 
            -- product
            wp_watergo_products.id,
            wp_watergo_products.store_id,
            wp_watergo_products.product_type,
            wp_watergo_products.description,
            wp_watergo_products.price,
            wp_watergo_products.category,
            wp_watergo_products.category_parent,
            wp_watergo_products.brand,
            wp_watergo_products.quantity,
            wp_watergo_products.volume,
            wp_watergo_products.weight,
            wp_watergo_products.length_width,
            -- 
            wp_watergo_products.has_discount,
            wp_watergo_products.discount_percent,
            wp_watergo_products.discount_from,
            wp_watergo_products.discount_to,
            -- 
            wp_watergo_products.created_at,
            wp_watergo_products.mark_out_of_stock,
            wp_watergo_products.product_hidden,
            wp_watergo_products.name_device,
            wp_watergo_products.feature_device,
            wp_watergo_products.capacity_device,
            -- 
            wp_watergo_products.has_gift,
            wp_watergo_products.gift_text,
            wp_watergo_products.gift_from,
            wp_watergo_products.gift_to,
            -- 
            (6371 * acos(
               cos(
                  radians($lat)) * cos(radians(wp_watergo_store.latitude)) * 
                  cos(radians(wp_watergo_store.longitude) - radians($lng)
               ) + sin(radians($lat)) * sin(radians(wp_watergo_store.latitude))
            )) AS distance,
            COALESCE(COUNT(reviews_avg.avg_rating), 0) AS avg_rating

            FROM wp_watergo_products  
            
            LEFT JOIN wp_watergo_store
            ON wp_watergo_store.id = wp_watergo_products.store_id

            LEFT JOIN (
               SELECT store_id, AVG(rating) AS avg_rating
               FROM wp_watergo_reviews
               GROUP BY store_id
            ) AS reviews_avg ON reviews_avg.store_id = wp_watergo_products.store_id
            $where_condition

            AND wp_watergo_products.mark_out_of_stock != 1
            AND wp_watergo_products.product_hidden != 1 
            
         ";
      // GET SQL WHEN USER NOT SHARE LOCATION
      }else{
         $sql ="SELECT 
            -- product
            wp_watergo_products.id,
            wp_watergo_products.store_id,
            wp_watergo_products.product_type,
            wp_watergo_products.description,
            wp_watergo_products.price,
            wp_watergo_products.category,
            wp_watergo_products.category_parent,
            wp_watergo_products.brand,
            wp_watergo_products.quantity,
            wp_watergo_products.volume,
            wp_watergo_products.weight,
            wp_watergo_products.length_width,
            -- 
            wp_watergo_products.has_discount,
            wp_watergo_products.discount_percent,
            wp_watergo_products.discount_from,
            wp_watergo_products.discount_to,
            -- 
            wp_watergo_products.created_at,
            wp_watergo_products.mark_out_of_stock,
            wp_watergo_products.product_hidden,
            wp_watergo_products.name_device,
            wp_watergo_products.feature_device,
            wp_watergo_products.capacity_device,
            -- 
            wp_watergo_products.has_gift,
            wp_watergo_products.gift_text,
            wp_watergo_products.gift_from,
            wp_watergo_products.gift_to,
            -- 
            COALESCE(COUNT(reviews_avg.avg_rating), 0) AS avg_rating

            FROM wp_watergo_products  
            
            LEFT JOIN wp_watergo_store
            ON wp_watergo_store.id = wp_watergo_products.store_id

            LEFT JOIN (
               SELECT store_id, AVG(rating) AS avg_rating
               FROM wp_watergo_reviews
               GROUP BY store_id
            ) AS reviews_avg ON reviews_avg.store_id = wp_watergo_products.store_id
            $where_condition

            AND wp_watergo_products.mark_out_of_stock != 1
            AND wp_watergo_products.product_hidden != 1 ";
      }
      
      /**
       * @access FILTER
       */

      function _convert_to_condition( $wpdb, $data ){
         $array = explode(',', $data); // string to array
         $output = array_map(function($item) use ($wpdb) {
            return $wpdb->prepare('%s', trim($item));
         }, $array);
         return '(' . implode(', ', $output) . ')';
      }

      if( $category != null && $category != '' ){
         $sql .= " AND wp_watergo_products.category = '$category' ";
      }
      
      if( $category_parent != null && $category_parent != ''){
         $sql_category_parent = _convert_to_condition($wpdb, $category_parent);
         $sql .= " AND wp_watergo_products.category_parent IN $sql_category_parent ";
      }

      if( $quantity != null && $quantity != ''){
         $sql_quantity = _convert_to_condition($wpdb, $quantity);
         $sql .= " AND wp_watergo_products.quantity IN $sql_quantity ";
      }

      if( $volume != null && $volume != ''){
         $volume_to_array = explode(',', $volume);
         $arr = [];
         foreach( $volume_to_array as $k => $vl ){
            if( $vl == 'Dưới 350ml' ){ $arr[] = '350 ml'; }
            if( $vl == 'Từ 350ml đến 1L' ){ $arr[] = '500 ml'; }
            if( $vl == 'Chai lớn 1L trở lên' ){ $arr[] = '5L'; }
            if( $vl == 'Bình vòi 18L đến 20L' || $vl == 'Bình úp 18L đến 20L' ){ $arr[] = '15L'; }
         }
         $sql_volume = _convert_to_condition($wpdb, implode(',', $arr ) );
         $sql .= " AND wp_watergo_products.volume IN $sql_volume ";
      }

      if( $brand != null && $brand != ''){
         $sql_brand = _convert_to_condition($wpdb, $brand);
         $sql .= " AND wp_watergo_products.brand IN $sql_brand ";
      }

      // WHEN USER SHARE LOCATION
      if( ($lat != null && $lat != '') && ($lng != null && $lng != '') ){
         $sql .= "
            GROUP BY wp_watergo_products.id
            ORDER BY distance DESC
            LIMIT $paged, $perPage
         ";
      // WHEN USER NOT SHARE LOCATION
      }else{
         $sql .= "
            GROUP BY wp_watergo_products.id
            ORDER BY wp_watergo_products.price ASC
            LIMIT $paged, $perPage
         ";
      }

      $res = $wpdb->get_results($sql);

      if( !empty( $res ) ){
         $res = atlantis_component_extract_product($res);
      }

      if( empty( $res ) ){
         wp_send_json_error(['message' => 'product_not_found' ]);
         wp_die();
      }

      wp_send_json_success(['message' => 'product_found', 'data' => $res,
      'sql' => $sql
      ]);
      wp_die(); 


   }
}

/**
 * @access LOAD PRODUCT DISCOUNT AND GIFT ONLY
 */

add_action( 'wp_ajax_nopriv_atlantis_get_product_discount_and_gift', 'atlantis_get_product_discount_and_gift' );
add_action( 'wp_ajax_atlantis_get_product_discount_and_gift', 'atlantis_get_product_discount_and_gift' );
function atlantis_get_product_discount_and_gift(){
   if( isset($_POST['action']) && $_POST['action'] == 'atlantis_get_product_discount_and_gift'){

      $current_time = atlantis_current_date_only();

      $paged   = isset($_POST['paged'] ) ? (int) $_POST['paged'] : 0;
      $limit   = isset($_POST['limit'] ) ? (int) $_POST['limit'] : 10;

      $current_time = atlantis_current_date_only();

      $sql = "SELECT 
            *
         FROM wp_watergo_products
         WHERE 
         ( 
            ( DATE_FORMAT(discount_to, '%Y-%m-%d') >= NOW() AND DATE_FORMAT(discount_from, '%Y-%m-%d') <= NOW() ) OR
            ( DATE_FORMAT(gift_to, '%Y-%m-%d') >= NOW() AND DATE_FORMAT(gift_from, '%Y-%m-%d') <= NOW() )
         )
         AND wp_watergo_products.mark_out_of_stock = 0
         AND wp_watergo_products.product_hidden != 1 
         AND wp_watergo_products.status = 'publish'

         ORDER BY wp_watergo_products.discount_percent DESC
         LIMIT $paged, $limit
      ";

      global $wpdb;

      $res = $wpdb->get_results( $sql );

      if( !empty( $res ) ){
         $res = atlantis_component_extract_product($res);

         wp_send_json_success(['message' => 'product_found', 'data' => $res ]);
         wp_die();
      }

      wp_send_json_error(['message' => 'product_not_found']);
      wp_die();

   }
}