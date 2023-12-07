<?php
/**
 * @access LOAD ORDER
 */

add_action( 'wp_ajax_nopriv_atlantis_add_order', 'atlantis_add_order' );
add_action( 'wp_ajax_atlantis_add_order', 'atlantis_add_order' );

add_action( 'wp_ajax_nopriv_atlantis_get_order_detail', 'atlantis_get_order_detail' );
add_action( 'wp_ajax_atlantis_get_order_detail', 'atlantis_get_order_detail' );

add_action( 'wp_ajax_nopriv_atlantis_get_order_filter', 'atlantis_get_order_filter' );
add_action( 'wp_ajax_atlantis_get_order_filter', 'atlantis_get_order_filter' );

add_action( 'wp_ajax_nopriv_atlantis_delete_order', 'atlantis_delete_order' );
add_action( 'wp_ajax_atlantis_delete_order', 'atlantis_delete_order' );

add_action( 'wp_ajax_nopriv_atlantis_cancel_order', 'atlantis_cancel_order' );
add_action( 'wp_ajax_atlantis_cancel_order', 'atlantis_cancel_order' );

add_action( 'wp_ajax_nopriv_atlantis_order_status', 'atlantis_order_status' );
add_action( 'wp_ajax_atlantis_order_status', 'atlantis_order_status' );

add_action( 'wp_ajax_nopriv_atlantis_order_callback', 'atlantis_order_callback' );
add_action( 'wp_ajax_atlantis_order_callback', 'atlantis_order_callback' );

add_action( 'wp_ajax_nopriv_atlantis_is_product_out_of_stock_from_order', 'atlantis_is_product_out_of_stock_from_order' );
add_action( 'wp_ajax_atlantis_is_product_out_of_stock_from_order', 'atlantis_is_product_out_of_stock_from_order' );

add_action( 'wp_ajax_nopriv_atlantis_get_order_user', 'atlantis_get_order_user' );
add_action( 'wp_ajax_atlantis_get_order_user', 'atlantis_get_order_user' );

add_action( 'wp_ajax_nopriv_atlantis_get_order_store', 'atlantis_get_order_store' );
add_action( 'wp_ajax_atlantis_get_order_store', 'atlantis_get_order_store' );

add_action( 'wp_ajax_nopriv_atlantis_get_order_time_shipping', 'atlantis_get_order_time_shipping' );
add_action( 'wp_ajax_atlantis_get_order_time_shipping', 'atlantis_get_order_time_shipping' );


// FOR ORDER REPEA
add_action( 'wp_ajax_nopriv_atlantis_get_order_schedule', 'atlantis_get_order_schedule' );
add_action( 'wp_ajax_atlantis_get_order_schedule', 'atlantis_get_order_schedule' );

add_action( 'wp_ajax_nopriv_func_atlantis_get_order_time_shipping_single_record', 'func_atlantis_get_order_time_shipping_single_record' );
add_action( 'wp_ajax_func_atlantis_get_order_time_shipping_single_record', 'func_atlantis_get_order_time_shipping_single_record' );

add_action( 'wp_ajax_nopriv_atlantis_count_total_order_by_status', 'atlantis_count_total_order_by_status' );
add_action( 'wp_ajax_atlantis_count_total_order_by_status', 'atlantis_count_total_order_by_status' );

add_action( 'wp_ajax_nopriv_atlantis_get_all_time_shipping_from_order', 'atlantis_get_all_time_shipping_from_order' );
add_action( 'wp_ajax_atlantis_get_all_time_shipping_from_order', 'atlantis_get_all_time_shipping_from_order' );

function sortSettingsByDayOfWeek($settings) {
   $daysOfWeek = ['Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday', 'Sunday'];
   $dayOrder = array_flip($daysOfWeek);
   usort($settings, function ($a, $b) use ($dayOrder) {
      return $dayOrder[$a['day']] - $dayOrder[$b['day']];
   });
   return $settings;
}

function findNextDay_ofWeek($settings, $currentDay, $depth = 0, $check_time = false ) {
   $daysOfWeek = ['Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday', 'Sunday'];
   $lastIndex  = count($daysOfWeek) - 1;
   $findIndex  = array_search($currentDay, $daysOfWeek) + $depth;
   // Set the timezone to GMT+7
   $timezone    = new DateTimeZone('Asia/Bangkok');
   // $currentTime = new DateTime(null, $timezone);
   $currentTime = new DateTimeImmutable('now', $timezone);
   $currentTime = $currentTime->format('H'); // Format as 'H:i'
   
	foreach ($settings as $k => $vl) {
      $_find_index = array_search($vl['day'], $daysOfWeek);
      // current day
      if ($_find_index == $findIndex) {
         // Check the time condition
         if( $check_time == true ){
            list($startTime, $endTime) = explode('-', $vl['time']);
            if ($endTime > $currentTime) {
               return $vl;
            }else{
               return findNextDay_ofWeek($settings, $currentDay, 1);
            }
         }else{
            return $vl;
         }
      // future day
      } elseif ($_find_index > $findIndex) {
         return $vl;
      }
   }
    
   return $settings[0];
}

function findNextDay_ofMonth($settings, $currentDay, $depth = 0, $check_time = false) {
	usort($settings, function ($a, $b) {return $a['day'] - $b['day'];});
	$timezone    = new DateTimeZone('Asia/Bangkok');
	// $currentTime = new DateTime(null, $timezone);
	$currentTime = new DateTimeImmutable('now', $timezone);
	$currentTime = $currentTime->format('H'); // Format as 'H:i'
	
   foreach ($settings as $vl) {
      if ($vl['day'] == $currentDay + $depth) {
         if( $check_time == true ){
            list($startTime, $endTime) = explode('-', $vl['time']);
            if ($endTime > $currentTime) {
               return $vl;
            }else{
               return findNextDay_ofMonth($settings, $currentDay, 1);
            }
         }else{
            return $vl;
         }
      }else{
         if ($vl['day'] == $currentDay + 1 + $depth) {
            return $vl;	
         }
      }
   }
   return $settings[0];
}

function getNextDay($arr) {
   // Get the current date
   $currentDate = new DateTime();
   // Initialize variables to store the minimum difference and the next day
   $minDiff = PHP_INT_MAX;
   $nextDay = null;
   // Loop through the array and calculate the difference with the current date
   foreach ($arr as $item) {
      $date = DateTime::createFromFormat('d/m/Y', $item['datetime']);
      $diff = $date->diff($currentDate)->days;

      // If the difference is less than the minimum difference, update the next day
      if ($diff < $minDiff) {
         $minDiff = $diff;
         $nextDay = $item;
      }
   }
   return $nextDay;
}

function func_atlantis_get_user_id_from_store_id( $store_id ){
   if( $store_id == null || $store_id == 0 ) return 0;
   global $wpdb;
   $sql = "SELECT user_id FROM wp_watergo_store WHERE id = $store_id AND store_hidden != 1 ";
   $res = $wpdb->get_results($sql);
   if( $res[0]->user_id == "" || $res[0]->user_id == null || $res[0]->user_id == 0){
      return 0;
   }
   return $res[0]->user_id;
}

// USE FOR NO AJAX LOCAL PHP ONLY

function return_order_with_group_products( $array_orders ){
   $final = [];

   $total_price_product = 0;

   foreach ($array_orders as $k => $item) {
      $key = $item->hash_id;
      if (isset($final[$key]['order_products'] )) {
         
         $final[$key]['order_products'][] = [
            'product_image'                        => $item->product_image,
            'order_group_id'                       => $item->order_group_id,
            'order_group_product_id'               => $item->order_group_product_id,
            'order_group_product_metadata'         => $item->order_group_product_metadata,
            'order_group_product_quantity_count'   => $item->order_group_product_quantity_count,
            'order_group_product_price'            => $item->order_group_product_price,
            'order_group_product_discount_percent' => $item->order_group_product_discount_percent,
            'order_group_store_id'                 => $item->order_group_store_id,
         ];

         // $price            = $product->order_group_product_price;
         // $quantity         = $product->order_group_product_quantity_count;
         // $discount_percent = $product->order_group_product_discount_percent;
         // $total_price_product += ($price - ( $price * ($discount_percent / 100 ) ) ) * $quantity;
      // $order->total_product         = count($res_products);
      // $order->total_price_product   = $total_price_product;


      } else {
         // Item with the order_id or hash_id does not exist, create a new entry

         $final[$key] = [
            'order_id'                 => $item->order_id,
            'order_delivery_type'      => $item->order_delivery_type,
            'order_payment_method'     => $item->order_payment_method,
            'order_status'             => $item->order_status,
            'order_delivery_address'   => json_decode( json_decode( $item->order_delivery_address, true ), true ),
            'order_time_created'       => $item->order_time_created,
            'order_time_confirmed'     => $item->order_time_confirmed,
            'order_time_cancel'        => $item->order_time_cancel,
            'order_time_completed'     => $item->order_time_completed,
            'order_time_delivery'      => $item->order_time_delivery,
            'order_by'                 => $item->order_by,

            'order_products' => [
               [
                  'order_group_id'                       => $item->order_group_id,
                  'order_group_product_id'               => $item->order_group_product_id,
                  'order_group_product_metadata'         => $item->order_group_product_metadata,
                  'order_group_product_quantity_count'   => $item->order_group_product_quantity_count,
                  'order_group_product_price'            => $item->order_group_product_price,
                  'order_group_product_discount_percent' => $item->order_group_product_discount_percent,
                  'order_group_store_id'                 => $item->order_group_store_id,
               ]
            ]
         ];
      }
   }
   return $final;
}

function atlantis_is_product_out_of_stock_from_order(){
   if( isset( $_POST['action'] ) && $_POST['action'] == 'atlantis_is_product_out_of_stock_from_order' ){

      $order_id = isset($_POST['order_id']) ? $_POST['order_id'] : 0;

      if( $order_id == 0 ){
         wp_send_json_error(['message' => 'order_not_found' ]);
         wp_die();
      }

      global $wpdb;

      $sql_check_stock_already_to_reorder = "SELECT 
         wp_watergo_order_group.order_group_id, 
         wp_watergo_order_group.order_group_product_id,
         wp_watergo_order_group.order_group_product_quantity_count,
         wp_watergo_products.mark_out_of_stock
         FROM wp_watergo_order_group
         LEFT JOIN wp_watergo_order
         ON wp_watergo_order.hash_id = wp_watergo_order_group.hash_id
         LEFT JOIN wp_watergo_products
         ON wp_watergo_products.id = wp_watergo_order_group.order_group_product_id
         WHERE
            wp_watergo_order.order_id = $order_id
      ";
      
      $res = $wpdb->get_results($sql_check_stock_already_to_reorder);


      if( empty( $res ) ){
         wp_send_json_error(['message' => 'reorder_out_of_stock' ]);
         wp_die();
      }

      foreach( $res as $k => $vl ){
         if( $vl->mark_out_of_stock == 1 ){
            wp_send_json_error(['message' => 'reorder_out_of_stock' ]);
            wp_die();
         }
      }

      wp_send_json_success(['message' => 'order_can_reorder' ]);
      wp_die();



   }

}


function func_atlantis_get_order_time_shipping_single_record( $order_time_shipping_id ){
   $sql = "SELECT * FROM wp_watergo_order_time_shipping WHERE order_time_shipping_id = $order_time_shipping_id LIMIT 1";
   global $wpdb;
   $res = $wpdb->get_results($sql);
   if( empty( $res )){
      return [];
   }else{
      return $res[0];
   }
}

function atlantis_get_all_time_shipping_from_order(){
   if( isset($_POST['action']) && $_POST['action'] == 'atlantis_get_all_time_shipping_from_order' ){
      $order_id = isset($_POST['order_id']) ? $_POST['order_id'] : 0;

      if( $order_id == 0 ){
         wp_send_json_error(['message' => 'time_shipping_not_found' ]);
         wp_die();
      }

      global $wpdb;

      // CHECK IF HAS PARENT ID

      $sql_check_has_parent_id = "SELECT * FROM wp_watergo_order_repeat WHERE order_repeat_order_id_parent = $order_id ";
      $res_check_has_parent_id = $wpdb->get_results($sql_check_has_parent_id);

      if( $res_check_has_parent_id[0]->order_repeat_order_id_parent != $res_check_has_parent_id[0]->order_repeat_order_id ){
         $order_id = $res_check_has_parent_id[0]->order_repeat_order_id;
      }

      $sql = "SELECT * FROM wp_watergo_order_time_shipping WHERE order_time_shipping_order_id = $order_id";
      $res = $wpdb->get_results($sql);


      if( empty($res)){
         wp_send_json_error(['message' => 'time_shipping_not_found' ]);
         wp_die();
      }
      wp_send_json_error(['message' => 'time_shipping_found', 'data' => $res ]);
      wp_die();
   }
}

function atlantis_add_order(){
   if( isset( $_POST['action'] ) && $_POST['action'] == 'atlantis_add_order' ){
      
      if(is_user_logged_in() == true ){
         $user_id = get_current_user_id();
         $user = get_user_by('id', $user_id);
         $prefix_user = 'user_' . $user->data->ID;
      }else{
         wp_send_json_error(['message' => 'no_login_invalid' ]);
         wp_die();
      }

      $hash_id = bin2hex(random_bytes(64));

      $delivery_address = isset($_POST['delivery_address']) ? $_POST['delivery_address'] : '';
      $delivery_data    = isset($_POST['delivery_data'])    ? $_POST['delivery_data'] : '';
      /**
       * @access OUTPUT
         {
            "store_id": 22,
            "store_name": "Store 6",
            "store_select": false,
            "products": [
               {
                  "product_id": 35,
                  "product_metadata": {
                     "product_name": "LaVie",
                     "product_name_second": "Thùng 24 chai 500 ml",
                     "product_id": "35"
                  },
                  "product_quantity_count": 1,
                  "product_price": 28000,
                  "product_discount_percent": 0,
                  "product_select": true
               }
            ]
         }
       */
      $productSelected  = isset($_POST['productSelected']) ? $_POST['productSelected'] : '';
      $delivery_type    = isset($_POST['delivery_type']) ? $_POST['delivery_type'] : '';
      $order_note       = isset($_POST['input_order_note']) ? $_POST['input_order_note'] : '';


      global $wpdb;

      $carts = json_decode( stripslashes( $productSelected ));
      
      // wp_send_json_success(['message' => 'bug', 'productSelected' => $carts ]);
      // wp_die();

      if ( 
         $delivery_type != '' && 
         $delivery_address != '' && 
         $delivery_data != '' && 
         $productSelected != '') {

         $delivery_address       = json_encode( stripslashes( $delivery_address), JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES );

         foreach( $carts as $k => $cart ){
            
            $hash_id                = bin2hex(random_bytes(40));
            $store_id               = $cart->store_id;
            $sql_order_number       = "SELECT order_number FROM wp_watergo_order WHERE order_store_id = $store_id ORDER BY order_id DESC LIMIT 1";
            $res_order_number       = $wpdb->get_results($sql_order_number);
            $order_number           = 0;
            if( $res_order_number[0]->order_number == 0 || $res_order_number[0]->order_number == null || $res_order_number[0]->order_number == ''){
               $order_number = 1;
            }else{
               $order_number = $res_order_number[0]->order_number + 1;
            }
            $delivery_data_setting  = json_decode( stripslashes($delivery_data));


            $args_insert = [
               'order_number'             => $order_number,
               'order_store_id'           => $store_id,
               'order_by'                 => $user_id,
               'order_delivery_type'      => $delivery_type,
               'order_payment_method'     => 'cash',
               'order_status'             => 'ordered',
               'order_delivery_address'   => $delivery_address,
               'order_time_created'       => atlantis_current_datetime(),
               'hash_id'                  => (String) $hash_id,
               'order_number_repeat'      => 0
            ];

            if( strlen($order_note) && $order_note != '' ){
               $args_insert['order_note'] = $order_note;
            }

            $wpdb->insert('wp_watergo_order', $args_insert);
            $order_id = $wpdb->insert_id;

            $hash_id_for_link_app = bin2hex(random_bytes(28));
            // SET NOTIFICATION -> send to store
            $link_app = get_bloginfo('url') . '/order/?order_page=order-store-detail&order_id='. $order_id .'&hash_id='. $hash_id_for_link_app .'&appt=N';

            $__product_id              = $cart->products[0]->product_id;
            $get_user_id_from_store_id = $wpdb->get_results("SELECT user_id FROM wp_watergo_store WHERE id = $store_id");
            $get_attachment_url        = $wpdb->get_results("SELECT * FROM wp_watergo_attachment WHERE related_id = $__product_id AND attachment_type = 'product' ORDER BY id DESC LIMIT 1");
            $attachment_url            = '';

            if( ! empty( $get_attachment_url ) ){
               $attachment_url = wp_get_attachment_image_url( $get_attachment_url[0]->attachment_id );
            }

            // protocal_atlantis_notification_to_store([
            //    'order_status'       => 'ordered',
            //    'order_id'           => $order_id,
            //    'user_id'            => $user_id,
            //    'store_id'           => $store_id,
            //    'attachment_url'     => $attachment_url,
            //    'order_number'       => $order_number,
            //    'hash'               => $hash_id_for_link_app
            // ]);

            /**
             * @access FIND ORDER EXISTS IN REPEAT OR NOT?
               */

            if($delivery_type == 'weekly' || $delivery_type == 'monthly'){
               $time_shipping = [];
               $settings      = [];
               $next_day      = '';
               $order_tag_repeat       = bin2hex(random_bytes(40));

               foreach($delivery_data_setting as $k => $vl ){
                  if( $vl->day != '' && $vl->time != '' ){
                     if( $delivery_type == 'monthly'){
                        $settings[] = ['day' => $vl->day, 'time' => $vl->time];
                     }
                     if( $delivery_type == 'weekly'){
                        $settings[] = ['day' => $vl->day_name, 'time' => $vl->time];
                     }
                  }
               }

               if ($delivery_type == 'weekly') {
                  $currentDay             = date('l');
                  $settings               = sortSettingsByDayOfWeek($settings);
                  $day_for_shipping       = findNextDay_ofWeek($settings, $currentDay, 0, true);
                  $datetime_for_shipping  = get_datetime_from_day_name($day_for_shipping['day']);
                  $next_day               = findNextDay_ofWeek($settings, $currentDay, 1);
                  if( !empty( $next_day ) ){
                     $next_day = $next_day['day'];
                  }else{
                     $next_day = '';
                  }
               }

               if($delivery_type == 'monthly'){
                  $currentDate            = date('j');
                  $day_for_shipping       = findNextDay_ofMonth($settings, $currentDate, 0, true);
                  $datetime_for_shipping  = get_datetime_from_day_month($day_for_shipping['day']);
                  $next_day               = findNextDay_ofMonth($settings, $currentDate, 1);
                  if( !empty( $next_day ) ){
                     $next_day = $next_day['day'];
                  }else{
                     $next_day = '';
                  }
               }

               $wpdb->insert('wp_watergo_order_time_shipping', [
                  'order_time_shipping_day'      => $day_for_shipping['day'],
                  'order_time_shipping_time'     => $day_for_shipping['time'],
                  'order_time_shipping_datetime' => $datetime_for_shipping,
                  'order_time_shipping_type'     => 'monthly',
                  'order_time_shipping_order_id' => $order_id
               ]);

               $wpdb->insert('wp_watergo_order_settings', [
                  'order_delivery_type' => $delivery_type,   
                  'settings'            => json_encode($settings, JSON_UNESCAPED_UNICODE),
                  'repeat'              => 'yes',
                  'next_day'            => $next_day,
                  'order_tag_repeat'    => $order_tag_repeat
               ]);

               // ADD TAG REPEAT TO ORDER
               $wpdb->update('wp_watergo_order', [
                  'order_tag_repeat' => $order_tag_repeat
               ], [ 'order_id' => $order_id ]);
               
            }else{
               // FOR IMMIDEALY AND PICK DATE

               if( $delivery_type == 'once_date_time'){
                  $day        = $delivery_data_setting[0]->day;
                  $time       = $delivery_data_setting[0]->time;   
                  $datetime   = $day;
               }

               if( $delivery_type == 'once_immediately' ){
                  date_default_timezone_set('Asia/Bangkok'); // Set the default timezone to UTC+7
                  $day     = time() + 3600; // SHIP AFTER 1 HOUR
                  $currentHour = date('G', $day); // Get the current hour in 24-hour format
                  $nextHour = $currentHour + 1; // Add 1 to the current hour
                  $day = date('d/m/Y', $day);
                  $time = $currentHour . ':00-' . $nextHour . ':00';
                  $datetime = date('d/m/Y');
               }

               $wpdb->insert('wp_watergo_order_time_shipping', [
                  'order_time_shipping_day'        => $day,
                  'order_time_shipping_time'       => $time,
                  'order_time_shipping_datetime'   => $datetime,
                  'order_time_shipping_type'       => $delivery_type,
                  'order_time_shipping_order_id'   => $order_id,
               ]);


            }


            // ADD DATA TO ORDER_GROUP
            foreach( $cart->products as $k => $product ){

               $product_id                = $product->product_id;
               $product_quantity_count    = $product->product_quantity_count;
               $product_price             = $product->price;
               $product_discount_percent  = $product->discount_percent;
               $product_has_discount      = $product->has_discount;
               $product_gift_text         = $product->gift_text;
               $product_gift_to           = $product->gift_to;
               $product_gift_from         = $product->gift_from;

               // ALREADY CHECK DISCOUNT FROM FRONT END
               if( $product_has_discount == 0 ){
                  $product_discount_percent = 0;
               }

               $product_metadata          = $product->product_metadata;
               $product_name              = $product->name;
               $product_name_second       = $product->name_second;
               $product_type              = $product->product_type;
               $discount_from             = $product->discount_from;
               $discount_to               = $product->discount_to;

               // insert record
               $records = $wpdb->insert('wp_watergo_order_group', [
                  'order_group_product_id'               => $product_id,
                  'order_group_product_quantity_count'   => $product_quantity_count,
                  'order_group_product_price'            => $product_price,
                  'order_group_product_discount_percent' => $product_discount_percent,
                  'order_group_store_id'                 => $store_id,
                  'hash_id'                              => $hash_id,
                  'order_group_product_discount_from'    => $discount_from,
                  'order_group_product_discount_to'      => $discount_to,
                  'order_group_product_name'             => $product_name,
                  'order_group_product_name_second'      => $product_name_second,
                  'order_group_product_type'             => $product_type,
                  'order_group_product_gift_text'        => $product_gift_text,
                  'order_group_product_gift_to'          => $product_gift_to,
                  'order_group_product_gift_from'        => $product_gift_from
               ]);

            }
            
         }

         wp_send_json_success([ 'message' => 'insert_order_ok',  
            'data' => $order_id,
            'notification_args' => [
               'order_status'       => 'ordered',
               'order_id'           => $order_id,
               'user_id'            => $user_id,
               'store_id'           => $store_id,
               'attachment_url'     => $attachment_url,
               'order_number'       => $order_number,
               'hash'               => $hash_id_for_link_app,
               'send_to'            => 'store'
            ]
         ]);
         wp_die();
      } else {
         wp_send_json_success(['message' => 'hash_exists' ]);
         wp_die();
      }

   }

}


/**
 * @access THIS IS GET ORDER VERSION 2
 */


function atlantis_get_order_store(){
   if( isset( $_POST['action'] ) && $_POST['action'] == 'atlantis_get_order_store' ){

      global $wpdb;

      // GET STORE ID 
      $store_id = func_get_store_id_from_current_user();

      $paged = isset($_POST['paged']) ? $_POST['paged'] : 0;
      $limit = 10;

      // initial ordered
      $order_status = isset($_POST['order_status']) ? $_POST['order_status'] : '';

      if( $order_status == '' ){
         wp_send_json_error(['message' => 'no_order_found' ]);
         wp_die();
      }

      $orders = func_atlantis_get_order_fullpack([
         'get_by'                   => 'store_id',
         'related_id'               => $store_id,
         'limit'                    => -1,
         'order_status'             => $order_status,
         'is_get_product_related'   => 1,
         'is_get_time_shipping'     => 1
      ]);
      
      if( !empty($orders )){
         wp_send_json_success(['message' => 'get_order_ok', 'data' => $orders]);
         wp_die();         
      }

      wp_send_json_error(['message' => 'no_order_found' ]);
      wp_die();

   }
}

/**
 * @access GET ORDER SCHEDULE
 */
function atlantis_get_order_schedule(){
   if( isset( $_POST['action'] ) && $_POST['action'] == 'atlantis_get_order_schedule' ){
      $store_id   = func_get_store_id_from_current_user();

      $limit      = 10;
      $paged      = isset($_POST['paged']) ? $_POST['paged'] : 0;
      $filter     = isset($_POST['filter']) ? $_POST['filter'] : '';
      $datetime   = isset($_POST['datetime']) ? $_POST['datetime'] : '';

      global $wpdb;

      $sql = "SELECT * FROM wp_watergo_order
         LEFT JOIN wp_watergo_order_time_shipping
         ON wp_watergo_order_time_shipping.order_time_shipping_order_id = wp_watergo_order.order_id
         WHERE wp_watergo_order.order_store_id = $store_id
         -- order_status must be confirmed
         AND wp_watergo_order.order_status = 'confirmed'
         AND wp_watergo_order.order_hidden != 1
      ";

      if( $filter == 'once' ){
         $sql .= "
            AND (
         	   wp_watergo_order.order_delivery_type = 'once_immediately' OR wp_watergo_order.order_delivery_type = 'once_date_time'
            )
         ";
      }

      if( $filter == 'weekly'){
         $sql .= " AND wp_watergo_order.order_delivery_type = 'weekly' ";
      }
      if( $filter == 'monthly'){
         $sql .= " AND wp_watergo_order.order_delivery_type = 'monthly' ";
      }
      $sql .= "AND wp_watergo_order_time_shipping.order_time_shipping_datetime = '$datetime'";
      // DATE TIME

      $sql .= " 
         ORDER BY wp_watergo_order.order_id DESC
         LIMIT $paged, $limit";
         
      $res = $wpdb->get_results($sql);

      if( empty( $res ) ){
         wp_send_json_error(['message' => 'no_order_found 1' ]);
         wp_die();
      }

      // wp_send_json_success(['message' => 'bug', 'data' => $res]);
      // wp_die();

      // GET PRODUCT

      foreach( $res as $k => $vl ){
         $hash_id = $vl->hash_id;
         $_sql_product = "SELECT * FROM wp_watergo_order_group WHERE hash_id = '$hash_id'";
         $_product = $wpdb->get_results( $_sql_product);
         $total_price_product = 0;

         foreach( $_product as $c => $val ){
            $price            = $val->order_group_product_price;
            $quantity         = $val->order_group_product_quantity_count;
            $discount_percent = $val->order_group_product_discount_percent;
            $total_price_product += ($price - ( $price * ($discount_percent / 100 ) ) ) * $quantity;
         }
         $vl->total_product = count($_product);
         $vl->total_price_product = $total_price_product;

         $order_number  = $vl->order_number;
         $number_repeat = $vl->order_number_repeat;

         if( $number_repeat != 0 && $number_repeat != null && $number_repeat != ''){
            $order_number = str_pad( $order_number, 4, "0", STR_PAD_LEFT) . '-' . $number_repeat;
         }else{
            $order_number = str_pad( $order_number, 4, "0", STR_PAD_LEFT);
         }
         $vl->order_number = $order_number;
         
      }

      wp_send_json_success(['message' => 'get_order_ok', 'data' => $res]);
      wp_die();

   }
}

/**
 * @access END ORDER VERSION 2
 */
function atlantis_get_order_user(){
   if( isset( $_POST['action'] ) && $_POST['action'] == 'atlantis_get_order_user' ){
      
      $limit = isset($_POST['limit']) ? $_POST['limit'] : 10;
      $paged = isset($_POST['paged']) ? $_POST['paged'] : 0;
      // [ ordered | comfirmed | delivering | complete | cancel ]
      $order_status = $_POST['order_status'] ? $_POST['order_status'] : 'ordered';
      
      if(is_user_logged_in() == true ){
         $user_id = get_current_user_id();
      }else{
         wp_send_json_error(['message' => 'no_login_invalid' ]);
         wp_die();
      }

      $orders = func_atlantis_get_order_fullpack([
         'get_by'                   => 'user_id',
         'related_id'               => $user_id,
         'order_status'             => $order_status,
         'limit'                    => -1,
         'is_get_product_related'   => 1
      ]);
      
      if( empty( $orders )){
         wp_send_json_error(['message' => 'order_not_found' ]);
         wp_die();
      }
      wp_send_json_success(['message' => 'get_order_ok', 'data' => $orders ]);
      wp_die();
   }
}

/**
 * @access GET ORDER FROM BOTH [user - store]
 */
function atlantis_get_order_detail(){
   if( isset( $_POST['action'] ) && $_POST['action'] == 'atlantis_get_order_detail' ){
      $order_id = isset($_POST['order_id']) ? $_POST['order_id'] : 0;

      $orders = func_atlantis_get_order_fullpack([
         'get_by'                   => 'order_id',
         'related_id'               => $order_id,
         'limit'                    => -1,
         'is_get_product_related'   => 1,
         'is_get_time_shipping'     => 1
      ]);
      
      if( !empty($orders)){
         wp_send_json_success(['message' => 'get_order_ok', 'data' => $orders[0] ]);
         wp_die();
      }

      wp_send_json_error(['message' => 'get_order_error' ]);
      wp_die();

   }
}

function atlantis_get_order_time_shipping(){
   if( isset( $_POST['action'] ) && $_POST['action'] == 'atlantis_get_order_time_shipping' ){
      $order_id = isset($_POST['order_id']) ? $_POST['order_id'] : 0;
      $sql = "SELECT * FROM wp_watergo_order_time_shipping 
         WHERE order_time_shipping_order_id = $order_id
      ";
      global $wpdb;
      $res = $wpdb->get_results($sql);
      
      if( !empty($res)){
         wp_send_json_success(['message' => 'order_time_found', 'data' => $res ]);
         wp_die();
      }
      wp_send_json_error(['message' => 'no_order_time_found' ]);
      wp_die();
   }
}


/**
 * @access ORDER FROM USER FILTER BY [WEEKLY | MONTHLY]
 */

function atlantis_get_order_filter(){
   if( isset( $_POST['action'] ) && $_POST['action'] == 'atlantis_get_order_filter' ){

      $limit = 10;
      $paged = isset($_POST['paged']) ? $_POST['paged'] : 0;
      $user_id = get_current_user_id();

      $filter = isset($_POST['filter']) ? $_POST['filter'] : '';

      if( $filter == ''){
         wp_send_json_error(['message' => 'no_order_found' ]);
         wp_die();
      }

      global $wpdb;

      $sql = "SELECT 
            wp_watergo_order.hash_id,
            wp_watergo_store.name as store_name,
            wp_watergo_order_settings.order_tag_repeat,
            wp_watergo_order_settings.settings as order_time_shipping

         FROM wp_watergo_order_settings
         LEFT JOIN wp_watergo_order 
         ON wp_watergo_order.order_tag_repeat = wp_watergo_order_settings.order_tag_repeat
         LEFT JOIN wp_watergo_store
         ON wp_watergo_store.id = wp_watergo_order.order_store_id

         WHERE wp_watergo_order_settings.repeat = 'yes' 
         AND wp_watergo_order.order_number_repeat = 0
         AND wp_watergo_order.order_by = $user_id
         AND wp_watergo_order.order_delivery_type = '$filter'
         LIMIT $paged, $limit
      ";

      $res = $wpdb->get_results( $sql );
      $orders_filter = [];

      if( empty( $res )){
         wp_send_json_error(['message' => 'no_order_found' ]);
         wp_die();
      }

      foreach( $res as $k => $vl ){
         $sql_get_product = "SELECT * FROM wp_watergo_order_group WHERE hash_id = '$vl->hash_id'";
         $res_get_product = $wpdb->get_results( $sql_get_product);

         $total_price_product = 0;

         foreach( $res_get_product as $kk => $product ){
            $product->product_image = func_atlantis_get_images($product->order_group_product_id, 'product', true);
            $price            = $product->order_group_product_price;
            $quantity         = $product->order_group_product_quantity_count;
            $discount_percent = $product->order_group_product_discount_percent;
            $total_price_product += ($price - ( $price * ($discount_percent / 100 ) ) ) * $quantity;
         }

         $vl->total_product       = count($res_get_product);
         $vl->total_price_product = $total_price_product;
         $vl->order_products = $res_get_product;
         $vl->order_time_shipping = json_decode($vl->order_time_shipping, true);
      }

      wp_send_json_success(['message' => 'get_order_ok', 'data' => $res ]);
      wp_die();

   }
}

/**
 * @access THIS IS NOT A DELETE ORDER , IT JUST CHANGE order_keep_repeat to false , make order cant repeat again
 */

function atlantis_delete_order(){
   if( isset( $_POST['action'] ) && $_POST['action'] == 'atlantis_delete_order' ){
      $order_tag_repeat = isset($_POST['order_tag_repeat']) ? $_POST['order_tag_repeat'] : null;

      if( $order_tag_repeat == null ){
         wp_send_json_error(['message' => 'order_not_found' ]);
         wp_die();
      }
      global $wpdb;

      $updated = $wpdb->update('wp_watergo_order_settings', [
         'repeat' => 'no'
      ], ['order_tag_repeat' => $order_tag_repeat]);

      if( $updated ){
         wp_send_json_success(['message' => 'order_delete_ok' ]);
         wp_die();
      }
      wp_send_json_error(['message' => 'order_not_found' ]);
      wp_die();
   }
}

/**
 * @access CANCEL ORDER FROM USER
 */
function atlantis_cancel_order(){
   if( isset( $_POST['action'] ) && $_POST['action'] == 'atlantis_cancel_order' ){
      $order_id = isset($_POST['order_id']) ? $_POST['order_id'] : 0;
      // weekly | monthly 

      $order_type    = isset($_POST['order_type']) ? $_POST['order_type'] : '';
      $reason_cancel = isset($_POST['reason_cancel']) ? $_POST['reason_cancel'] : null;

      $args = [
         'order_status'       => 'cancel',
         'order_time_cancel'  => atlantis_current_datetime(),
      ];

      if( $reason_cancel != '' && $reason_cancel != null){
         $args['order_reason_cancel']     = $reason_cancel;
         $args['order_reason_cancel_by']  = 'user';
      }

      global $wpdb;
      $wpdb->update('wp_watergo_order', $args,[ 'order_id' => $order_id ]);

      if( $order_type == 'weekly' || $order_type == 'monthly' ){
         $sql_get_tag_repeat = "SELECT order_tag_repeat 
            FROM wp_watergo_order 
            LEFT JOIN wp_watergo_order_settings
            ON wp_watergo_order_settings.order_tag_repeat = wp_watergo_order.order_tag_repeat
            WHERE wp_watergo_order.order_id = $order_id
            LIMIT 1
         ";
         $res_get_tag_repeat = $wpdb->get_results( $sql_get_tag_repeat);
         if( !empty($res_get_tag_repeat)){
            $res_get_tag_repeat = $res_get_tag_repeat[0];
            $wpdb->update('wp_watergo_order_settings', [ 'repeat' => 'no'], [ 'order_tag_repeat' => $res_get_tag_repeat->order_tag_repeat ] );
         }
      }

      // protocal_atlantis_notification_to_store([
      //    'order_status' => 'cancel',
      //    'order_id'     => $order_id
      // ]);
      
      wp_send_json_success(['message' => 'cancel_done']);
      wp_die();

   }
}

/**
 * @access THIS FUNCTION WILL CLONE RECORD FROM DATABASE
 */


function atlantis_clone_order( $order_id, $order_time_shipping_id ){
   global $wpdb;
   $hash_id          = bin2hex(random_bytes(64));
   $time_created     = atlantis_current_datetime();

   $sql_hash_check = "SELECT hash_id FROM wp_watergo_order WHERE order_id = $order_id";
   $get_hash_check = $wpdb->get_results($sql_hash_check);

   if(empty($get_hash_check)) return [];

   $sql_clone = "INSERT INTO wp_watergo_order(
      order_number,
      hash_id,
      order_by,
      order_store_id,
      order_time_shipping_id,
      order_delivery_type,
      order_payment_method,
      order_status,
      order_delivery_address,
      order_time_created,
      order_time_confirmed,
      order_time_cancel,
      order_time_completed,
      order_time_delivery
   )
   SELECT 
      order_number,
      '$hash_id',
      order_by,
      order_store_id,
      $order_time_shipping_id,
      order_delivery_type,
      order_payment_method,
      'ordered',
      order_delivery_address,
      '$time_created',
      NULL,
      NULL,
      NULL,
      NULL
   FROM wp_watergo_order
   WHERE order_id = $order_id";
   $wpdb->query($sql_clone);

   return [ 'hash_id' => $hash_id, 'hash_check' => $get_hash_check[0]->hash_id, 'insert_id' => $wpdb->insert_id ];
}

function alantis_clone_order_group($hash_id_from_new_order, $hash_id_from_old_order){
   global $wpdb;

   $sql_clone_order_group = "INSERT INTO wp_watergo_order_group( 
      hash_id,
      order_group_product_id,
      order_group_product_quantity_count,
      order_group_product_price,
      order_group_product_discount_percent,
      order_group_store_id,
      order_group_product_name,
      order_group_product_name_second,
      order_group_product_discount_from,
      order_group_product_discount_to,
      order_group_product_type,
      order_group_product_gift_text,
      order_group_product_gift_to,
      order_group_product_gift_from
   )
   SELECT 
      '$hash_id_from_new_order',
      order_group_product_id,
      order_group_product_quantity_count,
      order_group_product_price,
      order_group_product_discount_percent,
      order_group_store_id,
      order_group_product_name,
      order_group_product_name_second,
      order_group_product_discount_from,
      order_group_product_discount_to,
      order_group_product_type,
      order_group_product_gift_text,
      order_group_product_gift_to,
      order_group_product_gift_from
   FROM wp_watergo_order_group
   WHERE hash_id = '$hash_id_from_old_order' ";
   $wpdb->query($sql_clone_order_group);

}

// END FUNCTION CLONE

/**
 * @access CHANGE STATUS ORDER
 */
function atlantis_order_status(){
   if( isset( $_POST['action'] ) && $_POST['action'] == 'atlantis_order_status' ){
      
      $order_id   = isset($_POST['order_id']) ? $_POST['order_id'] : '';
      // current datetime
      $timestamp  = atlantis_current_datetime();

      $status = isset($_POST['status']) ? $_POST['status'] : '';

      if($order_id == '' || $status == ''){
         wp_send_json_error(['message' => 'order_not_found' ]);
         wp_die();
      }

      if(is_user_logged_in() == true ){
         $user_id = get_current_user_id();
         $user = get_user_by('id', $user_id);
         $prefix_user = 'user_' . $user->data->ID;
      }else{
         wp_send_json_error(['message' => 'no_login_invalid' ]);
         wp_die();
      }

      $order_ids = json_decode($order_id);
      $wheres = [];

      if( ! empty($order_ids) ){
         foreach( $order_ids as $ids ){
            $wheres[] = $ids;
         }
      }

      $placeholders = implode(',', array_fill(0, count($wheres), '%d'));

      global $wpdb;

      if( ! empty( $wheres )){
         
         $order_time = '';

         if( $status == 'confirmed' ){
            $order_status = 'confirmed';
            $order_time = "order_time_confirmed = %s ";

            for( $i = 0; $i < count($wheres); $i++ ){
               $_order_id        = $wheres[$i];
               
               // protocal_atlantis_notification_to_user([
               //    'order_status' => 'confirmed',
               //    'order_id'     => $_order_id
               // ]);
            }
            
         }
         if( $status == 'delivering' ){
            $order_status = 'delivering';
            $order_time = "order_time_delivery = %s ";

            for( $i = 0; $i < count($wheres); $i++ ){
               $_order_id        = $wheres[$i];
               // protocal_atlantis_notification_to_user([
               //    'order_status' => 'delivering',
               //    'order_id'     => $_order_id
               // ]);
            }

         }

         /**
          * @access CLONE ORDER IF TYPE [weekly - monthly]
          */
         if( $status == 'complete' ){
            $order_status = 'complete';
            $order_time = "order_time_completed = %s ";

            for( $i = 0; $i < count($wheres); $i++ ){
               $_order_id        = $wheres[$i];
               // protocal_atlantis_notification_to_user([
               //    'order_status' => 'completed',
               //    'order_id'     => $_order_id
               // ]);
            }

            // IF ORDER IS WEEKLY OR MONTHLY - MAKE NEW ORDER
            $get_items = $wpdb->get_results(
               $wpdb->prepare(
                  "SELECT * FROM wp_watergo_order
                  WHERE order_id IN (". implode(',', array_fill(0, count($wheres), '%d')) . ")",
                  // FILL DATA
                  ...$wheres
               )
            );

            foreach( $get_items as $k => $vl ){
               if( $vl->order_delivery_type == 'weekly' || $vl->order_delivery_type == 'monthly'){
                  $hash_id                     = bin2hex(random_bytes(40));
                  $order_tag_repeat            = $vl->order_tag_repeat;
                  $store_id                    = $vl->order_store_id;
                  $user_id                     = $vl->order_by;
                  $order_id                    = $vl->order_id;
                  $order_number                = $vl->order_number;

                  $sql_check_order_settings = "SELECT * FROM wp_watergo_order_settings WHERE order_tag_repeat = '$order_tag_repeat' LIMIT 1";
                  $res_order_settings       = $wpdb->get_results($sql_check_order_settings);
                  $res_order_settings       = $res_order_settings[0];

                  if( $res_order_settings->repeat == 'yes' ){
                     $order_number_repeat = 0;
                     // GET ORDER NUMBER REPEAT
                     $sql_order_number_repeat   = "SELECT COUNT(*) as order_tag_repeat FROM wp_watergo_order WHERE order_tag_repeat = '$order_tag_repeat' LIMIT 1";
                     $res_order_number_repeat   = $wpdb->get_results($sql_order_number_repeat);
                     $order_number_repeat       = $res_order_number_repeat[0]->order_tag_repeat;

                     // EXECUTE CLONE ORDER
                     $time_created     = atlantis_current_datetime();

                     $sql_clone_order = "INSERT INTO wp_watergo_order(
                        order_number,
                        hash_id,
                        order_by,
                        order_store_id,
                        order_delivery_type,
                        order_payment_method,
                        order_status,
                        order_delivery_address,
                        order_time_created,
                        order_time_confirmed,
                        order_time_cancel,
                        order_time_completed,
                        order_time_delivery,
                        order_tag_repeat,
                        order_number_repeat
                     )
                     SELECT 
                        $order_number,
                        '$hash_id',
                        order_by,
                        order_store_id,
                        order_delivery_type,
                        order_payment_method,
                        'ordered',
                        order_delivery_address,
                        '$time_created',
                        NULL,
                        NULL,
                        NULL,
                        NULL,
                        '$order_tag_repeat',
                        $order_number_repeat
                     FROM wp_watergo_order
                     WHERE order_id = $order_id";
                     $wpdb->query($sql_clone_order);
                     $order_id_clone = $wpdb->insert_id;

                     // EXECUTE CLONE ORDER_GROUP_PRODUCT
                     alantis_clone_order_group($hash_id, $vl->hash_id);

                     // EXECUTE NEW TIME SHIPPING
                     $currentDay = $res_order_settings->next_day;
                     $settings   = json_decode($res_order_settings->settings, true);

                     $sql_old_datetime_from_shipping = "SELECT order_time_shipping_datetime FROM wp_watergo_order_time_shipping WHERE order_time_shipping_order_id = $order_id LIMIT 1";
                     $res_get_datetime_from_shipping = $wpdb->get_results( $sql_old_datetime_from_shipping);
                     $res_get_datetime_from_shipping = $res_get_datetime_from_shipping[0];

                     if( $vl->order_delivery_type == 'weekly' ){
                        // $currentDay             = date('l');
                        $settings               = sortSettingsByDayOfWeek($settings);
                        $day_for_shipping       = findNextDay_ofWeek($settings, $currentDay, 0);
                        $datetime_for_shipping  = get_next_day_from_datetime( $res_get_datetime_from_shipping->order_time_shipping_datetime , $day_for_shipping['day'], 'weekly');
                        $next_day               = findNextDay_ofWeek($settings, $currentDay, 1);
                        if( !empty( $next_day ) ){
                           $next_day = $next_day['day'];
                        }else{ $next_day = ''; }
                        $wpdb->insert('wp_watergo_order_time_shipping', [
                           'order_time_shipping_day'      => $day_for_shipping['day'],
                           'order_time_shipping_time'     => $day_for_shipping['time'],
                           'order_time_shipping_datetime' => $datetime_for_shipping,
                           'order_time_shipping_type'     => 'weekly',
                           'order_time_shipping_order_id' => $order_id_clone
                        ]);
                        $wpdb->update('wp_watergo_order_settings', [ 'next_day'  => $next_day, ], ['id' => $res_order_settings->id ]);
                     }

                     if( $vl->order_delivery_type == 'monthly' ){
                        // $currentDay            = date('j');
                        $day_for_shipping       = findNextDay_ofMonth($settings, $currentDay, 0);
                        $datetime_for_shipping  = get_next_day_from_datetime($res_get_datetime_from_shipping->order_time_shipping_datetime, $day_for_shipping['day'], 'monthly');
                        $next_day               = findNextDay_ofMonth($settings, $currentDay, 1);
                        if( !empty( $next_day ) ){
                           $next_day = $next_day['day'];
                        }else{ $next_day = ''; }
                        $wpdb->insert('wp_watergo_order_time_shipping', [
                           'order_time_shipping_day'      => $day_for_shipping['day'],
                           'order_time_shipping_time'     => $day_for_shipping['time'],
                           'order_time_shipping_datetime' => $datetime_for_shipping,
                           'order_time_shipping_type'     => 'monthly',
                           'order_time_shipping_order_id' => $order_id_clone
                        ]);
                        $wpdb->update('wp_watergo_order_settings', [ 'next_day'  => $next_day, ], ['id' => $res_order_settings->id ]);
                     }
                  }

               }
            }


         }

         if( $status == 'cancel' ){
            $order_status     = 'cancel';
            $order_time       = "order_time_cancel = %s ";
            $reason_cancel    = isset($_POST['reason_cancel']) ? $_POST['reason_cancel'] : null;
            $cancel_by        = isset($_POST['cancel_by']) ? $_POST['cancel_by'] : null;
            $options_cancel   = isset($_POST['options_cancel']) ? $_POST['options_cancel'] : null;
            $options_cancel   = json_decode( stripslashes($options_cancel), true);

            for( $i = 0; $i < count($wheres); $i++ ){
               $_order_id        = $wheres[$i];
               if( $reason_cancel != '' && $reason_cancel != null && $cancel_by != '' && $cancel_by != null ){
                  $wpdb->update('wp_watergo_order', [
                     'order_reason_cancel' => $reason_cancel,
                     'order_reason_cancel_by' => $cancel_by
                  ], ['order_id' => $_order_id ]);

                  if( !empty($options_cancel) && $options_cancel != null ){
                     foreach( $options_cancel as $vl ){
                        if( $_order_id == $vl['order_id'] && ( $vl['order_type'] == 'weekly' || $vl['order_type'] == 'monthly' ) ) {
                           $wpdb->update('wp_watergo_order_settings', [
                              'repeat' => 'no'
                           ], ['order_tag_repeat' => $vl['order_tag_repeat'] ]);
                        }
                     }
                  }
               }
               // REASON CANCEL ORDER

               // protocal_atlantis_notification_to_user([
               //    'order_status' => 'cancel',
               //    'order_id'     => $_order_id
               // ]);

            }
         }
         
         // IF NOT STATUS COMPLETE DO OTHER WISE
         $updated = $wpdb->query(
            $wpdb->prepare(
               "UPDATE wp_watergo_order
               SET order_status = %s, $order_time
               WHERE order_id IN ($placeholders)",
               // FILL DATA
               $order_status,
               $timestamp,
               ...$wheres
            )
         );


        if ( $updated ) {
            $insert_id = $wpdb->insert_id;
            wp_send_json_success( [ 'message' => 'order_status_ok', 
               'data' => $updated,
               'order_status' => $status,
               'order_ids'    => $wheres
            ] );
         } else {
            wp_send_json_error( [ 'message' => 'order_not_found', 'data' => $updated ] );
         }

         wp_die();
      }

      wp_send_json_error(['message' => 'order_not_found']);
      wp_die();

   }
}

/**
 * @access WHEN ORDER TYPE LIKE weekly | monthly -> get back data when change status to complete
 */
function atlantis_order_callback(){
   if( isset( $_POST['action'] ) && $_POST['action'] == 'atlantis_order_callback' ){
      
      $order_id = isset($_POST['order_id']) ? $_POST['order_id'] : '';

      if($order_id == ''){
         wp_send_json_error(['message' => 'order_not_found' ]);
         wp_die();
      }

      $order_ids = json_decode($order_id);
      $wheres = [];
      if( ! empty($order_ids) ){
         foreach( $order_ids as $ids ){
            $wheres[] = $ids;
         }
      }

      $placeholders = implode(',', array_fill(0, count($wheres), '%d'));

      $sql = "SELECT *,
         wp_watergo_store.name as store_name,
         wp_watergo_products.name a qs product_name,

         p1.url as product_image
         
         FROM wp_watergo_order
         LEFT JOIN wp_watergo_order_group 
            ON wp_watergo_order_group.hash_id = wp_watergo_order.hash_id
         LEFT JOIN wp_watergo_store
            ON wp_watergo_store.id = wp_watergo_order_group.order_group_store_id
         LEFT JOIN wp_watergo_products 
            ON wp_watergo_products.id = wp_watergo_order_group.order_group_product_id

         WHERE
            wp_watergo_order.order_id
         NOT IN ($placeholders)

      ";
      global $wpdb;

      $prepare = $wpdb->prepare($sql, $wheres);
      $res = $wpdb->get_results($prepare);

      if( empty( $res ) ){
         wp_send_json_error(['message' => 'no_order_found 1' ]);
         wp_die();
      }

      $order = return_order_with_group_products( $res );

      if( ! empty( $order ) ){
         sort($order);
         wp_send_json_success(['message' => 'order_callback_ok', 'data' => $order]);
         wp_die();
      }

      wp_send_json_error(['message' => 'order_callback_error'  ]);
      wp_die();


   }
}


add_action( 'wp_ajax_nopriv_atlantis_count_total_order_by_user', 'atlantis_count_total_order_by_user' );
add_action( 'wp_ajax_atlantis_count_total_order_by_user', 'atlantis_count_total_order_by_user' );

function atlantis_count_total_order_by_user(){
   if( isset($_POST['action']) && $_POST['action'] == 'atlantis_count_total_order_by_user'){
      
      $user_id = get_current_user_id();

      global $wpdb;

      $sql = "SELECT statuses.order_status, COALESCE(COUNT(orders.order_status), 0) AS total_count
            FROM
            (
               SELECT 'ordered' AS order_status
               UNION ALL
               SELECT 'confirmed' AS order_status
               UNION ALL
               SELECT 'delivering' AS order_status
               UNION ALL
               SELECT 'complete' AS order_status
               UNION ALL
               SELECT 'cancel' AS order_status
            ) AS statuses
            LEFT JOIN wp_watergo_order AS orders 
            ON statuses.order_status = orders.order_status AND orders.order_by = $user_id 
            AND orders.order_hidden != 1
            GROUP BY statuses.order_status
      ";
      
      $res = $wpdb->get_results($sql);

      if( empty( $res )){
         wp_send_json_error(['message' => 'order_not_found' ]);
         wp_die();
      }
      wp_send_json_success(['message' => 'count_order_by_status', 'data' => $res ]);
      wp_die();  
   }
}

/**
 * @access COUNT HOW MANY ORDER BY ORDER_STATUS
 */
function atlantis_count_total_order_by_status(){
   if( isset($_POST['action']) && $_POST['action'] == 'atlantis_count_total_order_by_status'){
      
      $store_id = func_get_store_id_from_current_user();

      global $wpdb;

      $sql = "SELECT statuses.order_status, COALESCE(COUNT(orders.order_status), 0) AS total_count
         FROM
         (
            SELECT 'ordered' AS order_status 
            UNION ALL
            SELECT 'confirmed' AS order_status 
            UNION ALL
            SELECT 'delivering' AS order_status 
            UNION ALL
            SELECT 'complete' AS order_status 
            UNION ALL
            SELECT 'cancel' AS order_status
         ) AS statuses
         LEFT JOIN wp_watergo_order AS orders 
         ON statuses.order_status = orders.order_status AND orders.order_store_id = $store_id AND orders.order_hidden != 1
         GROUP BY statuses.order_status
      ";

      
      $res = $wpdb->get_results($sql);

      if( empty( $res )){
         wp_send_json_error(['message' => 'order_not_found' ]);
         wp_die();
      }
      wp_send_json_success(['message' => 'count_order_by_status', 'data' => $res ]);
      wp_die();

   }
}


/**
 * @access FEATURE EVERY SINGLE TAB
 */

add_action( 'wp_ajax_atlantis_get_order_multiple_time', 'atlantis_get_order_multiple_time' );

function atlantis_get_order_multiple_time(){
   if( isset($_POST['action']) && $_POST['action'] == 'atlantis_get_order_multiple_time' ){

      $order_ids = isset( $_POST['order_ids'] ) ? $_POST['order_ids'] : '';

      $order_decode  = json_decode($order_ids );
      $wheres = [];
      if( empty( $wheres )){
         $wheres = [0];
      }else{
         foreach( $order_decode as $ids ){
            $wheres[] = $ids;
         }
      }

      $placeholders = implode(',', array_fill(0, count($wheres), '%d'));


      $user_id = get_current_user_id();

      global $wpdb;
      $sql = "SELECT 
            order_id,
            order_number,
            order_status,
            order_number_repeat
         FROM wp_watergo_order WHERE order_status IN ('ordered') AND order_hidden != 1 
         AND order_by = $user_id 
         AND order_id NOT IN ($placeholders)
         ORDER BY order_id DESC
      ";

      $prepare = $wpdb->prepare( $sql, $wheres);
      $res = $wpdb->get_results( $prepare);

      if( empty( $res ) ){
         wp_send_json_error([ 'message' => 'order_not_found']);
         wp_die();
      }

      foreach( $res as $k => $vl ){

         $order_number  = $vl->order_number;
         $number_repeat = $vl->order_number_repeat;

         if( $number_repeat != 0 && $number_repeat != null && $number_repeat != ''){
            $order_number = str_pad( $order_number, 4, "0", STR_PAD_LEFT) . '-' . $number_repeat;
         }else{
            $order_number = str_pad( $order_number, 4, "0", STR_PAD_LEFT);
         }
         $vl->order_number = $order_number;
      }
      
      wp_send_json_success([ 'message' => 'order_found', 'data' => $res, 'is_store' => 0 ]);
      wp_die();

   }
}

add_action( 'wp_ajax_nopriv_atlantis_is_order_confirmed', 'atlantis_is_order_confirmed' );
add_action( 'wp_ajax_atlantis_is_order_confirmed', 'atlantis_is_order_confirmed' );


function atlantis_is_order_confirmed(){
   if( isset($_POST['action']) && $_POST['action'] == 'atlantis_is_order_confirmed'){
      $order_ids = isset( $_POST['order_ids'] ) ? $_POST['order_ids'] : '';

      if( $order_ids == '' ){
         wp_send_json_error([ 'message' => 'order_confirmed_error' ]);
         wp_die();
      }

      $order_decode  = json_decode( stripslashes( $order_ids ), true );
      $placeholders  = 0;
      $wheres = [];
      foreach( $order_decode as $ids ){
         $wheres[] = $ids;
      }

      $placeholders = implode(',', array_fill(0, count($wheres), '%d'));

      global $wpdb;
      $sql = "SELECT order_id FROM wp_watergo_order 
         WHERE order_id IN ($placeholders)
         AND order_hidden != 1
         AND order_status IN ('confirmed', 'delivering', 'complete', 'cancel')
      ";
      $prepare = $wpdb->prepare($sql, $wheres);
      $res = $wpdb->get_results($prepare);

      if( ! empty( $res ) ){
         wp_send_json_success([ 'message' => 'order_confirmed_ok', 'data' => $res ]);
         wp_die();
      }

      wp_send_json_error([ 'message' => 'order_confirmed_error' ]);
      wp_die();
      
   }
}



add_action( 'wp_ajax_atlantis_get_newest_order', 'atlantis_get_newest_order' );
function atlantis_get_newest_order(){
   if( isset($_POST['action']) && $_POST['action'] == 'atlantis_get_newest_order'){

      if( ! is_user_logged_in() ){
         wp_send_json_error([ 'message' => 'order_not_found' ]);
         wp_die();
      }

      $order_ids     = isset($_POST['order_ids'] ) ? $_POST['order_ids'] : '';
      $order_status  = isset($_POST['order_status'] ) ? $_POST['order_status'] : '';
      $last_order_id = isset($_POST['last_order_id'] ) ? $_POST['last_order_id'] : 0;

      $user_id       = get_current_user_id();
      $is_user_store = get_user_meta($user_id, 'user_store', true);
      $store_id      = 0;

      $condition_check_role = "";

      global $wpdb;

      if($is_user_store == 1 || $is_user_store == true){
         $store_id      = func_get_store_id_from_current_user();
         $condition_check_role = "order_store_id = $store_id";
      }else{
         $condition_check_role = "order_by = $user_id";
      }
      

      $res_newest_order    = [];
      $order_need_delete   = [];

      // GET NEW ORDER
      if( $last_order_id != 0 && $last_order_id != null ){
         $sql_get_newest_order = "SELECT * FROM wp_watergo_order 
            WHERE order_id > $last_order_id AND order_status = '$order_status' AND order_hidden != 1
            AND $condition_check_role ORDER BY order_id DESC LIMIT 20
         ";
         $res_newest_order = $wpdb->get_results( $sql_get_newest_order);
      // NO LAST ID
      }else{
         $sql_get_newest_order = "SELECT * FROM wp_watergo_order 
            WHERE order_status = '$order_status' AND order_hidden != 1
            AND $condition_check_role ORDER BY order_id DESC LIMIT 20
         ";
         $res_newest_order = $wpdb->get_results( $sql_get_newest_order);
      }


      // UPDATE ORDER
      $order_decode  = json_decode( stripslashes( $order_ids ), true );
      $placeholders  = 0;
      $wheres = [];
      foreach( $order_decode as $ids ){$wheres[] = $ids;}
      $placeholders = implode(',', array_fill(0, count($wheres), '%d'));

      if( !empty($order_decode) ){
         $sql_order_update = "SELECT order_id FROM wp_watergo_order 
            WHERE order_id IN ($placeholders)
            AND order_status != '$order_status'
            AND order_hidden != 1
            AND $condition_check_role
         ";

         $prepare_order_update  = $wpdb->prepare( $sql_order_update, $wheres);
         $res_order_update      = $wpdb->get_results($prepare_order_update);
      }

      if( !empty($res_order_update)){
         foreach( $res_order_update as $k => $vl ){
            $order_need_delete[] = $vl->order_id;
         }
      }

      if( !empty( $res_newest_order ) ){
         foreach( $res_newest_order as $kOrder => $order){

            $order_number  = $order->order_number;
            $number_repeat = $order->order_number_repeat;
            $order->total_product = 0;
            $order->total_price_product = 0;

            if( $number_repeat != 0 && $number_repeat != null && $number_repeat != ''){
               $order_number = str_pad( $order_number, 4, "0", STR_PAD_LEFT) . '-' . $number_repeat;
            }else{
               $order_number = str_pad( $order_number, 4, "0", STR_PAD_LEFT);
            }
            $order->order_number = $order_number;

            // GET TIME SHIPPING
            $time_shipping = "SELECT * FROM wp_watergo_order_time_shipping WHERE order_time_shipping_order_id = $order->order_id";
            $res_time_shipping = $wpdb->get_results($time_shipping);
            if( !empty($res_time_shipping)){
               $res_newest_order[$kOrder]->order_time_shipping = $res_time_shipping;
            }

            // GET STORE NAME
            $sql_store_name = "SELECT name FROM wp_watergo_store WHERE id = $order->order_store_id ";
            $res_store_name = $wpdb->get_results( $sql_store_name);
            if( !empty( $res_store_name ) ){
               $res_newest_order[$kOrder]->store_name = $res_store_name[0]->name;
            }

            // GET PRODUCTS
            $get_products = "SELECT * FROM wp_watergo_order_group WHERE hash_id = '$order->hash_id'";
            $res_products = $wpdb->get_results($get_products);
            
            if( !empty($res_products) ){
               $total_price_product = 0;
               foreach( $res_products as $kProduct => $product ){
                  $res_newest_order[$kOrder]->order_products[$kProduct] = [
                     'order_group_id'                       => $product->order_group_id,
                     'order_group_product_id'               => $product->order_group_product_id,
                     'order_group_product_quantity_count'   => $product->order_group_product_quantity_count,
                     'order_group_product_price'            => $product->order_group_product_price,
                     'order_group_product_discount_percent' => $product->order_group_product_discount_percent,
                     'order_group_store_id'                 => $product->order_group_store_id,
                     //
                     'order_group_product_name'             => $product->order_group_product_name,
                     'order_group_product_name_second'      => $product->order_group_product_name_second,
                     'order_group_product_type'             => $product->order_group_product_type,
                     // 
                     'order_group_product_image'            => func_atlantis_get_images($product->order_group_product_id, 'product', true),

                     'order_group_product_gift_text'        => $product->order_group_product_gift_text,
                     'order_group_product_gift_to'          => $product->order_group_product_gift_to,
                     'order_group_product_gift_from'        => $product->order_group_product_gift_from
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
      

      wp_send_json_success([
         'message' => 'order_found',
         'order_need_delete' => $order_need_delete,
         'order_need_update' => $res_newest_order,
      ]);
      wp_die();

   }
}


add_action( 'wp_ajax_nopriv_atlantis_reorder', 'atlantis_reorder' );
add_action( 'wp_ajax_atlantis_reorder', 'atlantis_reorder' );
function atlantis_reorder(){
   if( isset($_POST['action']) && $_POST['action'] == 'atlantis_reorder'){
      $re_order_id = isset($_POST['re_order_id']) ? $_POST['re_order_id'] : 0;
      
      global $wpdb;
      $sql = "SELECT hash_id FROM wp_watergo_order WHERE order_id = $re_order_id ";
      $res = $wpdb->get_results($sql);
      if( !empty( $res )){

         $hash_id = $res[0]->hash_id;

         $sql_product = "SELECT * FROM wp_watergo_order_group WHERE hash_id = '$hash_id' ";
         $get_product = $wpdb->get_results( $sql_product );

         $groupedProducts = [];

         foreach( $get_product as $k => $vl ){
            $sql_store_name = "SELECT name FROM wp_watergo_store WHERE id = $vl->order_group_store_id";
            $res_store_name = $wpdb->get_results( $sql_store_name);
            $res_store_name = $res_store_name[0];

            $store_id = $vl->order_group_store_id;

            if (! isset($groupedProducts[$store_id])) {
               $groupedProducts[$store_id] = [
                  'store_id'     => $store_id,
                  'store_name'   => $res_store_name->name,
                  'store_select' => true,
                  'products'     => [],
               ];
            }

            $groupedProducts[$store_id]['products'][]   = [
               'product_id'               => $vl->order_group_product_id,
               'product_quantity_count'   => $vl->order_group_product_quantity_count,
               'product_select'           => true
            ];

         }

         sort($groupedProducts);

         wp_send_json_success([ 'message' => 'order_found', 'data' => $groupedProducts ]);
         wp_die();
      }
      

      wp_send_json_error([ 'message' => 'order_not_found' ]);
      wp_die();

   }
}


add_action( 'wp_ajax_nopriv_atlantis_count_review_not_in_order_complete', 'atlantis_count_review_not_in_order_complete' );
add_action( 'wp_ajax_atlantis_count_review_not_in_order_complete', 'atlantis_count_review_not_in_order_complete' );
function atlantis_count_review_not_in_order_complete(){
   if( isset($_POST['action']) && $_POST['action'] == 'atlantis_count_review_not_in_order_complete'){
      $user_id = get_current_user_id();

      $sql = "SELECT 
         COUNT(wp_watergo_order.order_id) as order_complete
         FROM wp_watergo_order
         LEFT JOIN wp_watergo_reviews 
         ON wp_watergo_reviews.order_id = wp_watergo_order.order_id
         WHERE wp_watergo_order.order_status = 'complete'
         AND wp_watergo_order.order_by = $user_id
         AND (wp_watergo_reviews.order_id IS NULL OR wp_watergo_reviews.order_id != wp_watergo_order.order_id)
      ";

      global $wpdb;
      $res = $wpdb->get_results( $sql);
      if( empty( $res )){
         wp_send_json_error([ 'message' => 'order_not_found' ]);
         wp_die();
      }

      wp_send_json_success([ 'message' => 'order_found', 'data' => (int) $res[0]->order_complete ]);
      wp_die();


   }
}