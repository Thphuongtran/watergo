<?php

add_action( 'wp_ajax_nopriv_atlantis_testing', 'atlantis_testing' );
add_action( 'wp_ajax_atlantis_testing', 'atlantis_testing' );

add_action( 'wp_ajax_nopriv_atlantis_get_images', 'atlantis_get_images' );
add_action( 'wp_ajax_atlantis_get_images', 'atlantis_get_images' );

/**
 * @access GET ORDER BY user_id | store_id | filter by order_status
 */
function func_atlantis_get_order_fullpack( $args ){

   // user_id or store_id or order_id
   $related_id   = isset( $args['related_id'] ) ? $args['related_id'] : 0;

   // [ ordered | comfirmed | delivering | complete | cancel ]
   $order_status = isset( $args['order_status'] ) ? $args['order_status'] : '';

   // GET PRODUCT RELATION BY Order
   $is_get_product_related = isset( $args['is_get_product_related'] ) ? $args['is_get_product_related'] : 0;
   $is_get_time_shipping   = isset( $args['is_get_time_shipping'] ) ? $args['is_get_time_shipping'] : 0;

   // user_id | store_id | order_id
   $get_by     = isset( $args['get_by'] ) ? $args['get_by'] : '';

   $limit      = isset( $args['limit'] ) ? $args['limit'] : 10;
   $paged      = isset( $args['paged'] ) ? $args['paged'] : 0;
   $paged      = $paged * $limit;
   
   
   // GET ALL 

   if( $get_by == 'order_id' ){
      $sql = "SELECT * FROM wp_watergo_order WHERE order_id = $related_id";
   }
   if( $get_by == 'user_id'  ){
      $sql = "SELECT * FROM wp_watergo_order WHERE order_by = $related_id";
   }
   if( $get_by == 'store_id' ){
      $sql = "SELECT * FROM wp_watergo_order WHERE order_store_id = $related_id";
   }

   if( $order_status != '' ){
      $sql .= " AND order_status = '$order_status' ";
   }


   if( $limit != -1){
      $sql .= " 
         ORDER BY order_id DESC
         LIMIT $paged, $limit";
   }

   global $wpdb;
   $orders = $wpdb->get_results($sql);


   if( ! empty( $orders ) ){

      foreach( $orders as $kOrder => $order){
         $orders[$kOrder]->order_number = func_atlantis_get_order_number($order->order_id);
         $orders[$kOrder]->order_delivery_address = json_decode( json_decode( $order->order_delivery_address ) );
      }


      // GET TIME SHIPPING
      if($is_get_time_shipping == 1){
         foreach( $orders as $kOrder => $order){
            // $order_time_shipping_id   = $order->order_time_shipping_id;
            $time_shipping = "SELECT * FROM wp_watergo_order_time_shipping WHERE order_time_shipping_id = $order->order_time_shipping_id";
            $res_time_shipping = $wpdb->get_results($time_shipping);
            if( !empty($res_time_shipping)){
               $orders[$kOrder]->order_time_shipping = $res_time_shipping;
            }

         }
      }

      // GET PRODUCT ??
      if($is_get_product_related == 1 ){
         foreach( $orders as $kOrder => $order){
            $hash_id    = $order->hash_id;
            $store_id   = $order->order_store_id;

            // GET STORE 
            $find_store  = "SELECT 
                  id as store_id, 
                  name as store_name,
                  latitude as store_latitude, longitude as store_longitude, store_type
                  FROM wp_watergo_store WHERE id = $store_id LIMIT 1";

            $res_store   = $wpdb->get_results( $find_store);
            if( !empty($res_store)){
               foreach($res_store as $kStore => $store ){
                  $orders[$kOrder]->store_name     = $store->store_name;
                  $orders[$kOrder]->store_id       = $store->store_id;
                  $orders[$kOrder]->store_latitude       = $store->store_latitude;
                  $orders[$kOrder]->store_longitude      = $store->store_longitude;
                  $orders[$kOrder]->store_type     = $store->store_type;
               }
            }

            // GET PRODUCTS
            $get_products = "SELECT * FROM wp_watergo_order_group WHERE hash_id = '$hash_id'";
            $res_products = $wpdb->get_results($get_products);
            
            if( !empty($res_products) ){
               foreach( $res_products as $kProduct => $product ){
                  $decode_product_metadata                  = json_decode( $product->order_group_product_metadata);
                  $orders[$kOrder]->order_products[$kProduct] = [
                     'order_group_id'                       => $product->order_group_id,
                     'order_group_product_id'               => $product->order_group_product_id,
                     'order_group_product_metadata'         => $decode_product_metadata,
                     'order_group_product_quantity_count'   => $product->order_group_product_quantity_count,
                     'order_group_product_price'            => $product->order_group_product_price,
                     'order_group_product_discount_percent' => $product->order_group_product_discount_percent,
                     'order_group_store_id'                 => $product->order_group_store_id,
                     'order_group_product_image'            => func_atlantis_get_images($product->order_group_product_id, 'product', true)
                  ];
               }
            }

         }
      }

      return $orders;
   }

   return [];

}

/**
 * @access GET ORDER NUMBER
 */

function func_atlantis_get_order_number( $order_id ){
   $sql = "SELECT * FROM wp_watergo_order_repeat WHERE order_repeat_order_id_parent = $order_id LIMIT 1";
   global $wpdb;
   $res = $wpdb->get_results($sql);

   if ( ! empty( $res ) ) {
      $number_repeat = '';

      if( $res[0]->order_repeat_order_id != $res[0]->order_repeat_order_id_parent ){
         $number_repeat = '-' . $res[0]->order_repeat_count;
      }

      $numberWithZeros = str_pad( $res[0]->order_repeat_order_id, 4, "0", STR_PAD_LEFT) . $number_repeat;
      return $numberWithZeros;
   }

   $numberWithZeros = str_pad( $order_id, 4, "0", STR_PAD_LEFT);
   return $numberWithZeros;
}

/**
 * @access GET PRODUCT VERSION 2 -> GET METADATA PRODUCT 
   INCLUDE (image)
 */
function func_atlantis_get_product_by( $args ){
   
   $id                     = $args['id'];
   // get_by [ store_id | product_id | category_id ]
   $get_by                 = $args['get_by'];
   // false is get all
   $limit_image            = isset( $args['limit_image'] ) ? $args['limit_image'] : true;
   // get_by_product_type [ ice | water ]
   $get_by_product_type    = isset( $args['get_by_product_type'] ) ? $args['get_by_product_type'] : null;
   // exclude id
   $exclude_id             = isset($args['exclude_id']) ? $args['exclude_id'] : 0;
   
   // limit
   $limit = isset($args['limit']) ? $args['limit'] : 10;
   // paged
   $paged = isset($args['paged']) ? $args['paged'] : 0;
   $paged = $paged * $limit;



   global $wpdb;

   $sql = "SELECT * FROM wp_watergo_products ";
   if( $get_by == 'store_id' ){
      $sql .= " WHERE wp_watergo_products.store_id = $id";
      if( $exclude_id != null && is_array($exclude_id) && count($exclude_id) > 0 ){
         $exclude_id = implode(',', $exclude_id);
         $sql .= " AND wp_watergo_products.id NOT IN ($exclude_id)";
      }else if ( $exclude_id != null && $exclude_id != 0 ) {
         $sql .= " AND wp_watergo_products.id NOT IN ($exclude_id)";
      }
   }
   if( $get_by == 'product_id'){
      $sql .= " WHERE wp_watergo_products.id = $id";
   }

   if( $get_by == 'category_id' ){
      $sql .= " WHERE wp_watergo_products.category = $id ";
   }

   if( $get_by_product_type != null ){
      $sql .= " AND wp_watergo_products.product_type = '$get_by_product_type' ";
   }

   if( $limit == -1 ){
      $sql .= " ORDER BY wp_watergo_products.id DESC LIMIT 1";
   }else{
      $sql .= " 
         ORDER BY wp_watergo_products.id DESC 
         LIMIT $paged, $limit
      ";
   }


   $products = $wpdb->get_results($sql);

   if( !empty($products ) ){
      foreach($products as $k => $vl){

         $products[$k]->product_image = func_atlantis_get_images($vl->id, 'product', $limit_image);
         $category = func_atlantis_get_product_category([
            'category'     => $vl->category,
            'brand'        => $vl->brand,
            'quantity'     => $vl->quantity,
            'volume'       => $vl->volume,
            'weight'       => $vl->weight,
            'product_type' => $vl->product_type
         ]);

         $products[$k]->category_name  = $category['category_name'];
         $products[$k]->brand_name     = $category['brand_name'];
         $products[$k]->quantity_name  = $category['quantity_name'];
         $products[$k]->volume_name    = $category['volume_name'];
         $products[$k]->weight_name    = $category['weight_name'];

         $products[$k]->name           = $category['name'];
         $products[$k]->name_second    = $category['name_second'];
      }
      return $products;
   }
   return [];
}

/**
 * @access GET STORE OR PRODUCT NEARBY LOCATION
 */

function func_atlantis_caculator_distance( $args ){
   $id = $args['id'];
   // product_id | store_id
   $get_by = $args['get_by'];
   
}

/**
 * @access GET product_category by product
 */

function func_atlantis_get_product_category( $args ){
   global $wpdb;
   $category   = $args['category'];
   $brand      = $args['brand'];
   $quantity   = $args['quantity'];
   $volume     = $args['volume'];
   $weight     = $args['weight'];
   $product_type     = $args['product_type'];

   $res = [];
   $sql_category = $wpdb->prepare("SELECT name as category_name FROM wp_watergo_product_category WHERE id = %d ", $category);
   $res['category_name'] = $wpdb->get_var($sql_category);
   $sql_brand = $wpdb->prepare("SELECT name as brand_name FROM wp_watergo_product_category WHERE id = %d", $brand);
   $res['brand_name'] = $wpdb->get_var($sql_brand);
   $sql_quantity = $wpdb->prepare("SELECT name as quantity_name FROM wp_watergo_product_category WHERE id = %d", $quantity);
   $res['quantity_name'] = $wpdb->get_var($sql_quantity);
   $sql_volume = $wpdb->prepare("SELECT name as volume_name FROM wp_watergo_product_category WHERE id = %d", $volume);
   $res['volume_name'] = $wpdb->get_var($sql_volume);
   $sql_weight = $wpdb->prepare("SELECT name as weight_name FROM wp_watergo_product_category WHERE id = %d", $weight);
   $res['weight_name'] = $wpdb->get_var($sql_weight);

   // BUILD MAME - AND NAME SECOND
   if( $product_type == 'ice' ){
      $res['name'] = $res['category_name'];
      $weight_name_remove_space  = str_replace(' ', '', $res['weight_name']);
      $res['name_second'] = $weight_name_remove_space . ' ' . $res['length_width'] . 'mm';
   }
   if( $product_type == 'water' ){
      $res['name']        = $res['brand_name'];
      $res['name_second'] = $res['quantity_name'] . ' ' . $res['volume_name'];
   }
   return $res;
}

/**
 * @access GET IMAGE PRODUCT -> LIMIT == FALSE -> get all image by product_id
 */
function func_atlantis_get_images($related_id, $attachment_type, $limit = true){
   global $wpdb;
   $sql = "SELECT attachment_id FROM wp_watergo_attachment WHERE related_id = $related_id AND attachment_type = '$attachment_type' 
      ORDER BY id ASC
   ";
   if( $limit == true ){
      $sql .= " LIMIT 1";
   }
   $res = $wpdb->get_results($sql);
   if( !empty($res )){
      $attachment = [];
      foreach( $res as $k => $vl ){
         $url = wp_get_attachment_image_url($vl->attachment_id);
         $attachment[$k]['url']  = $url;
         $attachment[$k]['id']   = $vl->attachment_id;
      }
      
      // GET ONLY ONE RECORD
      if( $limit == true ){
         return [
            'id'  => $attachment[0]['id'],
            'url' => $attachment[0]['url']
         ];
      }
      return $attachment;
   }
   // default image
   if($attachment_type == 'store'){
      $url = THEME_URI . '/assets/images/store-dummy.png';
   }
   if($attachment_type == 'product'){
      $url = THEME_URI . '/assets/images/store-dummy.png';
   }
   if($attachment_type == 'user_avatar'){
      $url = THEME_URI . '/assets/images/avatar-dummy.png';
   }
   return [ 'id'  => null, 'url' => $url ];
}

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

/**
 * @access ACTION FOR PRODUCT
 */

function func_get_category_product( $id_category, $name_category ){
   $sql = "SELECT * FROM wp_watergo_product_category
      WHERE id = $id_category AND category = '$name_category'
   ";
   global $wpdb;
   $res = $wpdb->get_results($sql);
   if( !empty( $res ) ){
      return $res;
   }else{
      return [];
   }
}

/**
 * @access SORT ARRAY file upload $_FILES WHEN USING FormData (Js) to request http
 */
function sort_image_data($data) {
    $sorted_data = array();

    if (isset($data['name']) && isset($data['type']) && isset($data['tmp_name']) && isset($data['error']) && isset($data['size'])) {
        $num_images = count($data['name']);

        for ($i = 0; $i < $num_images; $i++) {
            $sorted_data[] = array(
               'name'      => $data['name'][$i],
               'full_path' => $data['full_path'][$i],
               'type'      => $data['type'][$i],
               'tmp_name'  => $data['tmp_name'][$i],
               'error'     => $data['error'][$i],
               'size'      => $data['size'][$i],
            );
        }
    }

    return $sorted_data;
}

/**
 * @access GET IMAGE
 */
function atlantis_get_images(){
   if( isset($_POST['action']) && $_POST['action'] == 'atlantis_get_images' ){
      $product_id = isset($_POST['product_id']) ? $_POST['product_id'] : 0;
      $store_id = isset($_POST['store_id']) ? $_POST['store_id'] : 0;
      if( $product_id != 0){
         $res = func_atlantis_get_images($product_id, 'product', true);
      }
      if( $store_id != 0){
         $res = func_atlantis_get_images($store_id, 'store', true);
      }
      wp_send_json_success(['message' => 'image_ok', 'data' => $res]);
      wp_die();
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



// TESTING API FOR ALL
function atlantis_testing(){
   if( isset($_POST['action']) && $_POST['action'] == 'atlantis_testing' ){
      
      $description      = 'Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book.';

      $price            = [8000, 12000, 18000, 28000, 68000, 88000, 128000, 160000];
      $stock            = 8;

      $water_category       = [5, 6, 7, 8];
      $ice_category         = [1, 2, 3, 4];
      $water_brand          = [9, 10, 23, 24];
      $water_quantity       = [11, 12, 13, 14];
      $water_volume         = [15, 16, 17, 18];
      $ice_weight           = [19, 20, 21, 22];
      $length_width         = ['100*200', '200*300', '150*200', '250*350', '300*150'];

      $type = 'ice';

      global $wpdb;
      //  12 13
      for( $i = 0; $i < 4; $i++ ){

         $args = [
            'store_id'        => 13,
            'price'           => $price[array_rand($price)],
            'stock'           => $stock,
            'description'     => $description,
            'product_type'    => $type,
            'created_at'      => time()
         ];

         if( $type == 'water' ){
            $args['category']        = $water_category[array_rand($water_category)];
            $args['brand']           = $water_brand[array_rand($water_brand)];
            $args['quantity']        = $water_quantity[array_rand($water_quantity)];
            $args['volume']          = $water_volume[array_rand($water_volume)];
         }

         if( $type == 'ice'){
            $args['category']        = $ice_category[array_rand($ice_category)];
            $args['weight']          = $ice_weight[array_rand($ice_weight)];
            $args['length_width']    = $length_width[array_rand($length_width)];
         }

         $wpdb->insert('wp_watergo_products', $args );

      }
      wp_send_json_success(['message' => 'test']);


   }
}
