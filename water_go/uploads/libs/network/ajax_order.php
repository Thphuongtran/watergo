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

add_action( 'wp_ajax_nopriv_atlantis_re_order', 'atlantis_re_order' );
add_action( 'wp_ajax_atlantis_re_order', 'atlantis_re_order' );

add_action( 'wp_ajax_nopriv_atlantis_is_product_out_of_stock_from_order', 'atlantis_is_product_out_of_stock_from_order' );
add_action( 'wp_ajax_atlantis_is_product_out_of_stock_from_order', 'atlantis_is_product_out_of_stock_from_order' );

add_action( 'wp_ajax_nopriv_atlantis_get_order_user', 'atlantis_get_order_user' );
add_action( 'wp_ajax_atlantis_get_order_user', 'atlantis_get_order_user' );

add_action( 'wp_ajax_nopriv_atlantis_get_order_store', 'atlantis_get_order_store' );
add_action( 'wp_ajax_atlantis_get_order_store', 'atlantis_get_order_store' );

add_action( 'wp_ajax_nopriv_atlantis_get_order_time_shipping', 'atlantis_get_order_time_shipping' );
add_action( 'wp_ajax_atlantis_get_order_time_shipping', 'atlantis_get_order_time_shipping' );

// FOR ORDER REPEAT
add_action( 'wp_ajax_nopriv_atlantis_get_order_number', 'atlantis_get_order_number' );
add_action( 'wp_ajax_atlantis_get_order_number', 'atlantis_get_order_number' );

add_action( 'wp_ajax_nopriv_atlantis_get_order_schedule', 'atlantis_get_order_schedule' );
add_action( 'wp_ajax_atlantis_get_order_schedule', 'atlantis_get_order_schedule' );

add_action( 'wp_ajax_nopriv_func_atlantis_get_order_time_shipping_single_record', 'func_atlantis_get_order_time_shipping_single_record' );
add_action( 'wp_ajax_func_atlantis_get_order_time_shipping_single_record', 'func_atlantis_get_order_time_shipping_single_record' );

add_action( 'wp_ajax_nopriv_atlantis_count_total_order_by_status', 'atlantis_count_total_order_by_status' );
add_action( 'wp_ajax_atlantis_count_total_order_by_status', 'atlantis_count_total_order_by_status' );


// USE FOR NO AJAX LOCAL PHP ONLY



function return_order_with_group_products( $array_orders ){
   $final = [];
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


      } else {
         // Item with the order_id or hash_id does not exist, create a new entry
         if( $item->store_order_time_shipping_id ){
            // $final[$key]['store_order_time_shipping_id'] = $item->store_order_time_shipping_id;
         }
         if( $item->store_latitude ){
            // $final[$key]['store_latitude'] = $item->store_latitude;
         }
         if( $item->store_longitude ){
            // $final[$key]['store_longitude'] = $item->store_longitude;
         }

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
            // 
            'order_by'                 => $item->order_by,
            'store_name'               => $item->store_name,
            'store_id'                 => $item->order_group_store_id,
            'store_order_time_shipping_id' => $item->store_order_time_shipping_id,
            'store_latitude'           => $item->store_latitude,
            'store_longitude'          => $item->store_longitude,
            'address_kilometer'        => 0,

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
         wp_watergo_products.stock
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

      $total_product = count($res);
      $check_stock = 0;

      foreach( $res as $k => $vl ){
         $stock = $vl->stock;
         $quantity = $vl->order_group_product_quantity_count;
         // if stock > quantity
         if( $stock >= $quantity ){
            $check_stock++;
         }
      }

      if( $total_product == $check_stock){
         wp_send_json_success(['message' => 'order_can_reorder' ]);   
         wp_die();
      }

      wp_send_json_error(['message' => 'reorder_out_of_stock' ]);
      wp_die();



   }

}

function atlantis_re_order(){
   if( isset( $_POST['action'] ) && $_POST['action'] == 'atlantis_re_order' ){

      $order_id = isset($_POST['order_id']) ? $_POST['order_id'] : 0;

      if( $order_id == 0 ){
         wp_send_json_error(['message' => 'order_not_found' ]);
         wp_die();
      }

      global $wpdb;

      $sql_hash_check = "SELECT hash_id FROM wp_watergo_order WHERE order_id = $order_id ";

      $res = $wpdb->get_results( $sql_hash_check);

      if( empty( $res )){
         wp_send_json_error(['message' => 'order_not_found' ]);
         wp_die();
      }


      $hash_insert = atlantis_clone_order($order_id, 0, 1);
      alantis_clone_order_group( $res[0]->hash_id, $hash_insert );

      wp_send_json_success(['message' => 'reorder_ok' ]);
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
      $delivery_data = isset($_POST['delivery_data']) ? $_POST['delivery_data'] : '';
      /**
       * @access OUTPUT
         {
            "store_id": 22,
            "store_name": "Store 6",
            "store_select": false,
            "products": [
               {
                  "product_id": 35,
                  "product_max_stock": 8,
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
      $productSelected = isset($_POST['productSelected']) ? $_POST['productSelected'] : '';
      $delivery_type = isset($_POST['delivery_type']) ? $_POST['delivery_type'] : '';

      // TESTING 
      global $wpdb;

      $carts = json_decode( stripslashes( $productSelected ));

      // wp_send_json_success(['message' => 'bug', 'productSelected' => $carts ]);
      // wp_die();

      if ( 
         $delivery_type != '' && 
         $delivery_address != '' && 
         $delivery_data != '' && 
         $productSelected != '') {

         foreach( $carts as $k => $cart ){
            
            $hash_id = bin2hex(random_bytes(64));
            $query_check_hash = $wpdb->prepare("SELECT COUNT(*) FROM wp_watergo_order_group WHERE hash_id = %s", (String) $hash_id);
            $check_hash = $wpdb->get_var($query_check_hash);
            $store_id = $cart->store_id;

            $delivery_new = [];            

            $delivery_data_convert = json_decode( stripslashes($delivery_data));
            $delivery_address = json_encode( stripslashes( $delivery_address), JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);

            $dayOfWeek = ['Monday','Tuesday','Wednesday','Thursday','Friday','Saturday','Sunday'];

            

            if( $check_hash == 0 ){
               $wpdb->insert('wp_watergo_order', [
                  'order_by'                 => $user_id,
                  'order_store_id'           => $store_id,
                  'order_delivery_type'      => $delivery_type,
                  'order_payment_method'     => 'cash',
                  'order_status'             => 'ordered',
                  'order_delivery_address'   => $delivery_address,
                  'order_time_created'       => atlantis_current_datetime(),
                  'hash_id'                  => (String) $hash_id,
               ]);

               $order_id = $wpdb->insert_id;

               /**
                * @access FIND ORDER EXISTS IN REPEAT OR NOT?
                */
               $is_order_parent_exists = false;

               $sql = "";

               if($delivery_type == 'weekly' || $delivery_type == 'monthly'){
                  $date_array = [];

                  foreach($delivery_data_convert as $k => $vl ){

                     $wpdb->insert('wp_watergo_order_time_shipping', [
                        'order_time_shipping_day'        => $vl->day,
                        'order_time_shipping_time'       => $vl->time,
                        'order_time_shipping_datetime'   => $vl->datetime,
                        'order_time_shipping_type'       => $delivery_type,
                        'order_time_shipping_order_id'   => $order_id,
                     ]);
                     $date_array[$k]['day'] = $day;
                     $date_array[$k]['insert_id'] = $wpdb->insert_id;
                  }
                  
                  // MONTHLY
                  if( $delivery_type == 'monthly' ){
                     $currentDay = intval(date('j')); // Get the current day (1-31)
                     // Sort the $date_array based on the "day" value in ascending order
                     usort($date_array, function ($a, $b) { return $a['day'] - $b['day']; });
                     // Find the index of the current day in the sorted $date_array
                     $currentDayIndex = null;
                     foreach ($date_array as $index => $entry) {
                        if ($entry['day'] >= $currentDay) {
                           $currentDayIndex = $index;
                           break;
                        }
                     }
                     // Get the next day, considering the wrap-around from the last item to the first item
                     $nextDayIndex = $currentDayIndex !== null ? $currentDayIndex % count($date_array) : 0;
                     $nextDay = $date_array[$nextDayIndex];

                     $update_time_shipping = $wpdb->update('wp_watergo_order', [
                        'order_time_shipping_id' => $nextDay['insert_id']
                     ], [ 'order_id' => $order_id ]);

                  }

                  // WEEKLY
                  if( $delivery_type == 'weekly' ){

                     $nextDay = null;
                     // Get current day by week
                     $currentDay = date('l');

                     // Sort the date_array based on the order of days in dayOfWeek
                     usort($date_array, function ($a, $b) use ($dayOfWeek) {
                        return array_search($a['day'], $dayOfWeek) - array_search($b['day'], $dayOfWeek);
                     });

                     // Find the index of the current day in the sorted date_array
                     $currentDayIndex = array_search($currentDay, array_column($date_array, 'day'));

                     // Get the next day element from the date_array
                     $nextDayIndex = ($currentDayIndex + 1) % count($date_array);
                     $nextDay = $date_array[$nextDayIndex];

                     if( $nextDay ){
                        $update_time_shipping = $wpdb->update('wp_watergo_order', [
                           'order_time_shipping_id' => $nextDay['insert_id']
                        ], [ 'order_id' => $order_id ]);
                     }

                  }
                  
                  $wpdb->insert('wp_watergo_order_repeat', [
                     'order_repeat_is_keep_repeat'    => 1,
                     'order_repeat_order_id'          => $order_id,
                     'order_repeat_count'             => 0, // IT IS FIRST ORDER
                     'order_repeat_type'              => $delivery_type,
                     'order_hash_id'                  => (String) $hash_id,
                     'order_repeat_order_id_parent'   => $order_id // THIS IS PARENT OF ORDER_ID
                  ]);
                  
               }else{
                  // FOR IMMIDEALY AND PICK DATE

                  if( $delivery_type == 'once_date_time'){
                     $day        = $delivery_data_convert->day;
                     $time       = $delivery_data_convert->time;   
                     $datetime   = $delivery_data_convert->datetime;
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

                  $wpdb->update('wp_watergo_order', [
                     'order_time_shipping_id' => $wpdb->insert_id
                  ], [ 'order_id' => $order_id ]);


               }


               foreach( $cart->products as $k => $product ){

                  $product_id                = (int) $product->product_id;
                  $product_quantity_count    = (int) $product->product_quantity_count;
                  $product_price             = (int) $product->product_price;
                  $product_discount_percent  = (int) $product->product_discount_percent;

                  $product_metadata          = $product->product_metadata;

                  // wp_send_json_success(['message' => 'bug', 'product_metadata' => $product_metadata ]);
                  // wp_die();

                  // insert record
                  $records = $wpdb->insert('wp_watergo_order_group', [
                     'order_group_product_id'               => $product_id,
                     'order_group_product_quantity_count'   => $product_quantity_count,
                     'order_group_product_price'            => $product_price,
                     'order_group_product_discount_percent' => $product_discount_percent,
                     'order_group_store_id'                 => $store_id,
                     'hash_id'                              => (String) $hash_id,
                     'order_group_product_metadata'         => json_encode($product_metadata, JSON_UNESCAPED_UNICODE)
                  ]);

                  // REDUCE STOCK PER ITEM ORDER
                  $sql_get_stock    = "SELECT stock FROM wp_watergo_products WHERE id = $product->product_id";
                  $res_stock        = $wpdb->get_results($sql_get_stock);
                  $_reducer_stock   = null; 
                  if( !empty( $res_stock ) ){
                     $_reducer_stock = $res_stock[0]->stock - $product->product_quantity_count;
                     if( $_reducer_stock != null ){
                        $wpdb->update( 'wp_watergo_products', ['stock' => $_reducer_stock ], ['id' => $product->product_id]  );
                     }
                  }
               }

            }
         }

         wp_send_json_success(['message' => 'insert_order_ok' ]);
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
      $paged = $paged * $limit;

      // initial ordered
      $order_status = isset($_POST['order_status']) ? $_POST['order_status'] : '';

      if( $order_status == '' ){
         wp_send_json_error(['message' => 'no_order_found 1' ]);
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

      wp_send_json_error(['message' => 'no_order_found 3' ]);
      wp_die();

   }
}

/**
 * @access GET ORDER SCHEDULE
 */
function atlantis_get_order_schedule(){
   if( isset( $_POST['action'] ) && $_POST['action'] == 'atlantis_get_order_schedule' ){
      $store_id = func_get_store_id_from_current_user();

      $paged      = isset($_POST['paged']) ? $_POST['paged'] : 0;
      $filter     = isset($_POST['filter']) ? $_POST['filter'] : '';
      $datetime   = isset($_POST['datetime']) ? $_POST['datetime'] : '';

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

      global $wpdb;

      $sql = "SELECT *,
         wp_watergo_store.name as store_name,
         -- latitude
         wp_watergo_store.latitude as store_latitude,
         -- longitude
         wp_watergo_store.longitude as store_longitude,
            
         -- order_time_shipping_id
         wp_watergo_order.order_time_shipping_id as store_order_time_shipping_id

         -- time shipping
         FROM wp_watergo_order
         LEFT JOIN wp_watergo_order_group 
            ON wp_watergo_order_group.hash_id = wp_watergo_order.hash_id
         LEFT JOIN wp_watergo_store
            ON wp_watergo_store.id = wp_watergo_order_group.order_group_store_id
         LEFT JOIN wp_watergo_products 
            ON wp_watergo_products.id = wp_watergo_order_group.order_group_product_id

         -- COMPARE today with time shipping
         LEFT JOIN wp_watergo_order_time_shipping
            ON wp_watergo_order_time_shipping.order_time_shipping_id = wp_watergo_order.order_time_shipping_id

         WHERE
            wp_watergo_store.id = $store_id
         AND 
            wp_watergo_order.order_status = 'confirmed'
         AND
            wp_watergo_order.order_id NOT IN ($placeholders)
         
         
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
         ORDER BY wp_watergo_order.order_time_confirmed DESC
         LIMIT 10";

      // SORT

      $res = $wpdb->get_results($sql);

      if( empty( $res ) ){
         wp_send_json_error(['message' => 'no_order_found 1',  'datetime' => $datetime, 'filter' => $filter, 'sql' => $sql ]);
         wp_die();
      }

      $orders = return_order_with_group_products( $res );

      if( ! empty( $orders ) ){
         // GET ORDER NUMBER
         sort($orders);
         foreach( $orders as $k => $vl ){
            $get_order_number = func_atlantis_get_order_number($vl['order_id']);
            $orders[$k]['order_number'] = $get_order_number;
            $orders[$k]['order_time_shipping'] = func_atlantis_get_order_time_shipping_single_record( $vl['store_order_time_shipping_id'] );
         }

         wp_send_json_success(['message' => 'get_order_ok', 'data' => $orders]);
         wp_die();         
      }

      wp_send_json_error(['message' => 'no_order_found 2']);
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
         'paged'                    => $paged,
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

      if(is_user_logged_in() == true ){
         $user_id = get_current_user_id();
         $user = get_user_by('id', $user_id);
         $prefix_user = 'user_' . $user->data->ID;
      }else{
         wp_send_json_error(['message' => 'no_login_invalid' ]);
         wp_die();
      }

      $filter = isset($_POST['filter']) ? $_POST['filter'] : '';
      if( $filter == ''){
         wp_send_json_error(['message' => 'no_order_found' ]);
         wp_die();
      }

      global $wpdb;

      $sql = "SELECT *,
            wp_watergo_store.name as store_name,
            wp_watergo_products.name as product_name
            
            FROM wp_watergo_order
            LEFT JOIN wp_watergo_order_group 
               ON wp_watergo_order_group.hash_id = wp_watergo_order.hash_id
            LEFT JOIN wp_watergo_store
               ON wp_watergo_store.id = wp_watergo_order_group.order_group_store_id
            LEFT JOIN wp_watergo_products 
               ON wp_watergo_products.id = wp_watergo_order_group.order_group_product_id
            
            LEFT JOIN wp_watergo_order_repeat
               ON wp_watergo_order_repeat.order_repeat_order_id = wp_watergo_order.order_id
            WHERE
               wp_watergo_order.order_by = $user_id
            AND 
               wp_watergo_order.order_delivery_type = '$filter'
            AND 
               wp_watergo_order_repeat.order_repeat_is_keep_repeat = 1
      ";

      $res = $wpdb->get_results($sql);

      if( empty( $res ) ){
         wp_send_json_error(['message' => 'no_order_found 1 ' ]);
         wp_die();
      }
      
      $orders = return_order_with_group_products( $res );

      if( ! empty( $orders ) ){
         sort($orders);
         wp_send_json_success(['message' => 'get_order_ok', 'data' => $orders]);
         wp_die();
      }


      wp_send_json_error(['message' => 'no_order_found 2' ]);
      wp_die();

   }
}

/**
 * @access THIS IS NOT A DELETE ORDER , IT JUST CHANGE order_keep_repeat to false , make order cant repeat again
 */

function atlantis_delete_order(){
   if( isset( $_POST['action'] ) && $_POST['action'] == 'atlantis_delete_order' ){
      $order_id = isset($_POST['order_id']) ? $_POST['order_id'] : 0;

      if( $order_id == 0 ){
         wp_send_json_error(['message' => 'order_not_found' ]);
         wp_die();
      }

      global $wpdb;

      $updated = $wpdb->update('wp_watergo_order_repeat', [
         'order_repeat_is_keep_repeat' => 0
      ], [ 'order_repeat_order_id_parent' => $order_id  ] );

      if( $updated ){
         wp_send_json_success(['message' => 'order_delete_ok' ]);
         wp_die();
      }

      wp_send_json_error(['message' => 'order_not_found' ]);
      wp_die();
   }
}

function atlantis_cancel_order(){
   if( isset( $_POST['action'] ) && $_POST['action'] == 'atlantis_cancel_order' ){
      $order_id = isset($_POST['order_id']) ? $_POST['order_id'] : 0;
      // weekly | monthly 

      $order_type = isset($_POST['order_type']) ? $_POST['order_type'] : '';

      global $wpdb;
      $wpdb->update('wp_watergo_order', [
         'order_status' => 'cancel',
         'order_time_cancel' => time()
      ],[ 'order_id' => $order_id ]);

      if( $order_type == 'weekly' || $order_type == 'monthly' ){
         $wpdb->update('wp_watergo_order_repeat',[
            'order_repeat_is_keep_repeat' => 0
         ], ['order_repeat_order_id_parent' => $order_id]);
      }

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
   $time_created     = time();

   $sql_clone = "INSERT INTO wp_watergo_order(
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
      '$hash_id',
      order_by,
      order_store_id,
      $order_time_shipping_id,
      order_delivery_type,
      order_payment_method,
      'ordered',
      order_delivery_address,
      $time_created,
      0,
      0,
      0,
      0
   FROM wp_watergo_order
   WHERE order_id = $order_id";
   $wpdb->query($sql_clone);
   return [
      'hash_id' => $hash_id,
      'insert_id' => $wpdb->insert_id
   ];
}

function alantis_clone_order_group($hash_id_check, $hash_id_insert){
   global $wpdb;

   $sql = "INSERT INTO wp_watergo_order_group( 
         order_group_product_id,
         order_group_product_metadata,
         order_group_product_quantity_count,
         order_group_product_price,
         order_group_product_discount_percent,
         order_group_store_id,
         hash_id
      )
      SELECT 
         order_group_product_id,
         order_group_product_metadata,
         order_group_product_quantity_count,
         order_group_product_price,
         order_group_product_discount_percent,
         order_group_store_id,
         '$hash_id_insert'
      FROM wp_watergo_order_group
      WHERE hash_id = '$hash_id_check' ";

   $wpdb->query($sql);
}

function atlantis_clone_order_repeat($order_repeat_order_id, $order_repeat_count, $order_repeat_order_id_parent){
   global $wpdb;
   $sql = "INSERT INTO wp_watergo_order_repeat( 
         order_repeat_is_keep_repeat,
         order_repeat_order_id,
         order_repeat_count,
         order_repeat_type,
         order_hash_id,
         order_repeat_order_id_parent
      )
      SELECT 
         0, -- no repeat because this is parent order
         order_repeat_order_id,
         $order_repeat_count,
         order_repeat_type,
         order_hash_id,
         $order_repeat_order_id_parent
      FROM wp_watergo_order_repeat
      WHERE order_repeat_order_id = $order_repeat_order_id";
   $wpdb->query($sql);
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
         }
         if( $status == 'delivering' ){
            $order_status = 'delivering';
            $order_time = "order_time_delivery = %s ";
         }
         if( $status == 'complete' ){
            $order_status = 'complete';
            $order_time = "order_time_completed = %s ";


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
                  
                  $_hash_id = $vl->hash_id;
                  $_order_id = $vl->order_id;
                  $_order_time_shipping_id = $vl->order_time_shipping_id;
                  $_order_delivery_type = $vl->order_delivery_type;

                  $_order_id_original = $_order_id;

                  // BECAUSE CHANGE STATUS IT MEAN, U ALREADY HAVE DATA, AND THIS COMMAND WILL FIND WHERE IS YOUR ID_PARENT

                  // ------------------- GET ALL ID RELATION 
                  $sql_find_relaship_order_repeat = "SELECT
                     t1.order_repeat_order_id AS order_repeat_order_id,
                     t2.order_repeat_order_id_parent AS order_repeat_order_id_parent,
                     t3.order_repeat_count AS order_repeat_count
                  FROM
                     wp_watergo_order_repeat as t1
                  LEFT JOIN
                     wp_watergo_order_repeat as t2 
                     ON t1.order_repeat_order_id = t2.order_repeat_order_id
                  LEFT JOIN 
                  	wp_watergo_order_repeat as t3
                  	ON t2.order_repeat_order_id_parent = t3.order_repeat_order_id_parent
                  WHERE
                     t1.order_repeat_order_id_parent = $_order_id
                  ORDER BY t3.order_repeat_count DESC
                  ";

                  $res_find_relaship_order_repeat = $wpdb->get_results( $sql_find_relaship_order_repeat);
                  $order_repeat_count = $res_find_relaship_order_repeat[0]->order_repeat_count + 1;

                  

                  // GET ID ORIGINAL
                  foreach($res_find_relaship_order_repeat as $k => $vl ){
                     if( $vl->order_repeat_order_id_parent == $vl->order_repeat_order_id ){
                        $_order_id_original = $vl->order_repeat_order_id_parent;
                     }else{
                        $_order_id_original = $vl->order_repeat_order_id;
                     }
                  }


                  // GET LIST SHIPPING
                  $sql_get_list_shipping = "SELECT order_time_shipping_id, order_time_shipping_day FROM wp_watergo_order_time_shipping WHERE order_time_shipping_order_id = $_order_id_original";
                  $res_get_list_shipping = $wpdb->get_results($sql_get_list_shipping);

                  $_find_time_shipping_day_from_current_order = 0;

                  // FIND ID TIME SHIPPING
                  foreach ($res_get_list_shipping as $data) {
                     if ($data->order_time_shipping_id === $_order_time_shipping_id) {
                        $_find_time_shipping_day_from_current_order = $data->order_time_shipping_day;
                        break;
                     }
                  }

                  /**
                   * @access FIND NEXT ID SHIPPING BY TYPE MONTHLY
                   */

                  $get_next_time_shipping_id = null; // this is object
                  /*
                     {
                        order_time_shipping_id
                        order_time_shipping_day
                     }
                  */

                  if(  $_order_delivery_type == 'monthly' ){
                     
                     function findNextClosestDay_byMonthly($arr, $_current_order_time_shipping_day) {
                        if (count($arr) === 1) {
                           return $arr[0];
                        }

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
                     $get_next_time_shipping_id = findNextClosestDay_byMonthly( $res_get_list_shipping, $_find_time_shipping_day_from_current_order);
                  }

                  /**
                   * @access FIND NEXT ID SHIPPING BY TYPE WEEKLY
                   */

                  if(  $_order_delivery_type == 'weekly' ){
                                          
                     function findNextClosestDay_byWeekly($arr, $_current_order_time_shipping_day) {
                        if (count($arr) === 1) {
                           return $arr[0];
                        }

                        $weekDays = [
                           'Monday',
                           'Tuesday',
                           'Wednesday',
                           'Thursday',
                           'Friday',
                           'Saturday',
                           'Sunday',
                        ];

                        $currentDayIndex = array_search($_current_order_time_shipping_day, array_column($arr, 'order_time_shipping_day'));

                        if ($currentDayIndex === false) {
                           return null;
                        }

                        $arrCount = count($arr);

                        for ($i = 1; $i <= $arrCount; $i++) {
                           $index = ($currentDayIndex + $i) % $arrCount;
                           if ($arr[$index]->order_time_shipping_day !== $_current_order_time_shipping_day) {
                                 return $arr[$index];
                           }
                        }

                        return null;
                     }
                     $get_next_time_shipping_id = findNextClosestDay_byWeekly($res_get_list_shipping, $_find_time_shipping_day_from_current_order);
                  }

                  // CLONE ORDER
                  $insert_clone = atlantis_clone_order((int) $_order_id_original, (int) $get_next_time_shipping_id->order_time_shipping_id);
                  // CLONE ORDER GROUP - PRODUCT
                  alantis_clone_order_group($_hash_id, $insert_clone['hash_id']);
                  atlantis_clone_order_repeat($_order_id_original, $order_repeat_count, $insert_clone['insert_id']);

                  /**
                   *  @access  END SHIPPING LIST
                   * */

               }
            }

         }

         if( $status == 'cancel' ){
            $order_status = 'cancel';
            $order_time = "order_time_cancel = %s ";
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
            wp_send_json_success( array( 'message' => 'order_status_ok', 'data' => $updated ) );
         } else {
            wp_send_json_error( array( 'message' => 'order_not_found', 'data' => $updated ) );
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

/**
 * @access COUNT HOW MANY ORDER BY ORDER_STATUS
 */
function atlantis_count_total_order_by_status(){
   if( isset($_POST['action']) && $_POST['action'] == 'atlantis_count_total_order_by_status'){
      
      $store_id = func_get_store_id_from_current_user();

      global $wpdb;

      $sql = "SELECT statuses.order_status, COUNT(orders.order_status) AS total_count
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
         ON statuses.order_status = orders.order_status
         WHERE orders.order_store_id = $store_id
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