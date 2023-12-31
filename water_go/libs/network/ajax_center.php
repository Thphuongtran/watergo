<?php

add_action( 'wp_ajax_nopriv_atlantis_testing', 'atlantis_testing' );
add_action( 'wp_ajax_atlantis_testing', 'atlantis_testing' );

add_action( 'wp_ajax_nopriv_atlantis_get_images', 'atlantis_get_images' );
add_action( 'wp_ajax_atlantis_get_images', 'atlantis_get_images' );

/**
 * @access caculator avg rating review
 */
function func_atlantis_get_avg_rating( $store_id ){
   global $wpdb;
   $sql = "SELECT AVG(rating) as avg_rating FROM wp_watergo_reviews WHERE store_id = $store_id ";
   $res = $wpdb->get_results($sql);
   if( $res[0]->avg_rating == null ){
      return 0;
   }
   return $res[0]->avg_rating;
}


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
      $sql .= " ORDER BY order_id DESC LIMIT $paged, $limit";
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
            $order->total_product = 0;
            $order->total_price_product = 0;

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
               $total_price_product = 0;
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
                  $price            = $product->order_group_product_price;
                  $quantity         = $product->order_group_product_quantity_count;
                  $discount_percent = $product->order_group_product_discount_percent;
                  $total_price_product += ($price - ( $price * ($discount_percent / 100 ) ) ) * $quantity;
               }
               $order->total_product         = count($res_products);
               $order->total_price_product   = $total_price_product;
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

function func_get_order_number_in_by_order_id( $order_id ){
   global $wpdb;
   $sql_order_number = "SELECT order_number FROM wp_watergo_order WHERE order_id = $order_id ";
   $res_order_number = $wpdb->get_results($sql_order_number);
   if( empty( $res_order_number ) ){
      return 0;
   }
   return $res_order_number[0]->order_number;
}

function func_atlantis_get_order_number( $order_id ){
   $sql = "SELECT * FROM wp_watergo_order_repeat WHERE order_repeat_order_id_parent = $order_id LIMIT 1";
   global $wpdb;
   $res = $wpdb->get_results($sql);
   
   if ( ! empty( $res ) ) {

      if( $res[0]->order_repeat_type == 'weekly' || $res[0]->order_repeat_type == 'monthly' ){
         $number_repeat = '';
         $order_number = 0;

         if( $res[0]->order_repeat_order_id != $res[0]->order_repeat_order_id_parent ){
            $number_repeat = '-' . $res[0]->order_repeat_count;
            $order_number  = func_get_order_number_in_by_order_id($res[0]->order_repeat_order_id_parent);
         }else{
            $order_number  = func_get_order_number_in_by_order_id($res[0]->order_repeat_order_id_parent);
         }

         $numberWithZeros = str_pad( $order_number, 4, "0", STR_PAD_LEFT) . $number_repeat;
         return $numberWithZeros;
      }
   }

   $order_number = func_get_order_number_in_by_order_id($order_id);

   $numberWithZeros = str_pad( $order_number , 4, "0", STR_PAD_LEFT);
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

   $image_size             = isset( $args['image_size']) ? $args['image_size'] : 'medium';
   
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

         $vl->product_image = func_atlantis_get_images($vl->id, 'product', $limit_image, $image_size);
         $vl->description   = stripcslashes($vl->description);

         if( $vl->product_type == 'water'){
            $vl->name                     = $vl->brand;
            $vl->name_second              = $vl->quantity . ' ' . $vl->volume;
         }else if( $vl->product_type == 'ice'){
            $vl->name                     = $vl->category;
            $weight_unit                  = $vl->weight_unit;
            if( !in_array($weight_unit, ['Kg', 'Ml', 'Box']) ){
               $weight_unit = 'Kg';
            }
            $vl->name_second              = $vl->weight . strtolower($weight_unit) . ' ' . $vl->length_width . ' mm';
         }else if( $vl->product_type == 'water_device'){
            $vl->name                     = $vl->name_device;
            $vl->name_second              = $vl->feature_device;
         }else if( $vl->product_type == 'ice_device'){
            $vl->name                     = $vl->name_device;
            $vl->name_second              = $vl->capacity_device;
         }
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
 * @access GET IMAGE PRODUCT -> LIMIT == FALSE -> get all image by product_id
 */
function func_atlantis_get_images($related_id, $attachment_type, $limit = true, $image_size = 'medium'){
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
         // make image crop size 200x200
         $url = wp_get_attachment_image_url($vl->attachment_id, $image_size);
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
   return [ 'id'  => null, 'url' => $url, 'dummy' => 1 ];
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

/**
 * @access CHECK REPEAT ORDER CAN CREATE?
 */

// function func_check_repeat_order_can_create( $order_id ){
//    global $wpdb;
//    $sql_get_id_parent = "SELECT 
//       order_repeat_order_id
//       FROM wp_watergo_order_repeat 
//       WHERE order_repeat_order_id_parent = $order_id";
//    $res_get_id_parent = $wpdb->get_results($sql_get_id_parent);


//    if( $res_get_id_parent[0]->order_repeat_order_id != null ){
//       $order_id_parent = $res_get_id_parent[0]->order_repeat_order_id;

//       $sql_is_repeat = "SELECT 
//          order_repeat_is_keep_repeat
//          FROM wp_watergo_order_repeat 
//          WHERE order_repeat_order_id_parent = $order_id_parent
//          AND order_repeat_order_id = $order_id_parent
//       ";
//       $get_is_repeat = $wpdb->get_results($sql_is_repeat);
//       if( $get_is_repeat[0]->order_repeat_is_keep_repeat == 1 ){
//          return 1;
//       }
//       return 0;
//    }
//    return 0;
// }

function func_get_repeat_order_id( $order_id ){
   global $wpdb;
   $sql_get_repeat_order = "SELECT *
      FROM wp_watergo_order_repeat 
      WHERE order_repeat_order_id_parent = $order_id";
   $repeat_order = $wpdb->get_results($sql_get_repeat_order);

   if( !empty( $repeat_order ) ){
      $order_id_parent = $repeat_order[0]->order_repeat_order_id;

      $sql_order_primary = "SELECT *
         FROM wp_watergo_order_repeat 
         WHERE order_repeat_order_id_parent = $order_id_parent
         AND order_repeat_order_id = $order_id_parent
      ";

      $get_order_primary = $wpdb->get_results($sql_order_primary);

      if( !empty($get_order_primary) )return $get_order_primary[0];
      return [];
   }
   return [];
}

function func_get_repeat_count( $order_id, $order_parent_id ){
   global $wpdb;
   $sql = "SELECT order_repeat_count
      FROM wp_watergo_order_repeat 
      WHERE order_repeat_order_id_parent = $order_parent_id
      AND order_repeat_order_id = $order_id
   ";
   $res = $wpdb->get_results( $sql);
   if( $res[0]->order_repeat_count != null ){
      return $res[0]->order_repeat_count;
   }
   return 0;
}

/**
 * @access FIND NEXT CLOSEST DAY BY DAY OF WEEK
 */
function findNextClosestDay_byWeekly($arr, $_current_order_time_shipping_day) {
   if (count($arr) === 1) return $arr[0];

   $weekDays = [ 'Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday', 'Sunday' ];

   $currentDayIndex = array_search($_current_order_time_shipping_day, array_column($arr, 'order_time_shipping_day'));

   if ($currentDayIndex === false) return null;

   $arrCount = count($arr);

   for ($i = 1; $i <= $arrCount; $i++) {
      $index = ($currentDayIndex + $i) % $arrCount;
      if ($arr[$index]->order_time_shipping_day !== $_current_order_time_shipping_day) {
            return $arr[$index];
      }
   }

   return null;
}

/**
 * @access FIND NEXT CLOSEST DAY BY DAY OF MONTHLY
 */
function findNextClosestDay_byMonthly($arr, $_current_order_time_shipping_day) {
   if (count($arr) === 1) return $arr[0];

   usort($arr, function ($a, $b) {
      return $a->order_time_shipping_day - $b->order_time_shipping_day;
   });

   $sortedArray = array_column($arr, 'order_time_shipping_day');
   $index = array_search($_current_order_time_shipping_day, $sortedArray);

   if ($index === false) {
      $sortedArray[] = $_current_order_time_shipping_day;
      sort($sortedArray);
      $index = array_search($_current_order_time_shipping_day, $sortedArray);
   }

   $arrayCount = count($sortedArray);

   if ($index < $arrayCount - 1) {
      $next_index = $index + 1;
   } else {
      $next_index = 0;
   }

   $next_closest_day = $sortedArray[$next_index];

   // PREVIOUS DAY - FUTURE DAY

   foreach ($arr as $item) {
      if ($item->order_time_shipping_day === $next_closest_day) {
         return $item;
      }
   }

   return null;
}

/**
 * @access CHECK PRODUCT IS NOT OUT OF STOCK
 */

function func_is_product_out_of_stock( $product_id ){
   global $wpdb;
   $sql = "SELECT COUNT(*) as is_out_of_stock FROM wp_watergo_products WHERE id = $product_id AND mark_out_of_stock = 1";
   $res = $wpdb->get_results($sql);
   
   if( $res[0]->is_out_of_stock != null && $res[0]->is_out_of_stock == 0 ){
      return true;
   }
   return false;
}

require_once THEME_DIR . '/libs/network/ajax_upload.php';
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
require_once THEME_DIR . '/libs/network/ajax_language.php';
require_once THEME_DIR . '/libs/network/ajax_admin_supports.php';
require_once THEME_DIR . '/libs/network/ajax_location.php';
require_once THEME_DIR . '/libs/network/ajax_product_store.php';
require_once THEME_DIR . '/libs/network/ajax_report.php';
require_once THEME_DIR . '/libs/network/ajax_share.php';



// TESTING API FOR ALL
function atlantis_testing(){
   if( isset($_POST['action']) && $_POST['action'] == 'atlantis_testing' ){
      

      $user = get_user_by('id', 1);
      $first_name = get_user_meta( $user->data->ID, 'first_name', true );
      
      wp_send_json_success(['message' => 'bug', 'user_id' => $user->ID , 'user' => $user, 'data' => $first_name]);
      wp_die();

   }
}
