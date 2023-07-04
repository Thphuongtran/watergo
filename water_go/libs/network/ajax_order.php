<?php
/**
 * @access LOAD ORDER
 */

add_action( 'wp_ajax_nopriv_atlantis_add_order', 'atlantis_add_order' );
add_action( 'wp_ajax_atlantis_add_order', 'atlantis_add_order' );

add_action( 'wp_ajax_nopriv_atlantis_get_order', 'atlantis_get_order' );
add_action( 'wp_ajax_atlantis_get_order', 'atlantis_get_order' );

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
      $productSelected = isset($_POST['productSelected']) ? $_POST['productSelected'] : '';
      $delivery_type = isset($_POST['delivery_type']) ? $_POST['delivery_type'] : '';

      // TESTING 
      global $wpdb;

      $carts = json_decode( stripslashes( $productSelected ));

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
            $is_order_repeat = false;

            $delivery_new = [];            

            $delivery_data_convert = json_decode( stripslashes( $delivery_data));
            $delivery_address = json_encode( stripslashes( $delivery_address), JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);

            if( $check_hash == 0 ){

               $wpdb->insert('wp_watergo_order', [
                  'order_by' => $user_id,
                  'order_delivery_type' => $delivery_type,
                  'order_payment_method' => 'cash',
                  'order_status' => 'ordered',
                  'order_delivery_address' => $delivery_address,
                  'order_time_created' => time(),
                  'hash_id' => (String) $hash_id,
               ]);

               $order_id = $wpdb->insert_id;

               if($delivery_type == 'weekly' || $delivery_type == 'monthly'){
                  $is_order_repeat = true;
                  foreach($delivery_data_convert as $k => $vl ){

                     $dt = new DateTime("@$vl->currentDate");
                     
                     $day     = $vl->day;
                     $month   = $dt->format('m');
                     $year    = $dt->format('y');

                     $wpdb->insert('wp_watergo_order_time_shipping', [
                        'order_time_shipping_day'        => $day,
                        'order_time_shipping_month'      => $month,
                        'order_time_shipping_year'       => $year,
                        'order_time_shipping_time'       => $vl->time,
                        'order_time_shipping_type'       => $delivery_type,
                        'order_time_shipping_is_done'    => 0,
                        'order_time_shipping_timestamp'  => $vl->currentDate,
                        'order_time_shipping_order_id'   => $order_id,
                     ]);

                  }
               }

               foreach( $cart->products as $k => $product ){

                  $product_id                = (int) $product->product_id;
                  $product_quantity_count    = (int) $product->product_quantity_count;
                  $product_price             = (int) $product->product_price;
                  $product_discount_percent  = (int) $product->product_discount_percent;

                  // insert record
                  $records = $wpdb->insert('wp_watergo_order_group', [
                     'order_group_product_id' => $product_id,
                     'order_group_product_quantity_count' => $product_quantity_count,
                     'order_group_product_price' => $product_price,
                     'order_group_product_discount_percent' => $product_discount_percent,
                     'order_group_store_id' => $store_id,
                     'hash_id' => (String) $hash_id
                  ]);

                  // REDUCE STOCK PER ITEM ORDER
                  $data = array(
                     'stock' => $wpdb->get_var( $wpdb->prepare( "SELECT stock FROM wp_watergo_products WHERE id = %d", 1 ) ) - $product->product_quantity_count,
                  );
                  $wpdb->update( 'wp_watergo_products', $data, ['id' => $product->product_id]  );
               }

               // ADD DATE SHIPPING TO watergo_order_repeat
               /**
                  1. hash_id - delivery_type
               */
               if( $is_order_repeat == true ) {

                  $wpdb->insert('wp_watergo_order_repeat', [
                     'order_repeat_is_keep_repeat' => 1,
                     'order_repeat_order_id'       => $order_id,
                     'order_repeat_count'          => 0, // IT IS FIRST ORDER
                     'order_repeat_type'           => $delivery_type,
                     'order_hash_id'               => (String) $hash_id,
                     'order_repeat_id_previous'    => 0, // THIS IS PREVIOUS ID WHEN RE-ORDER BEEN CREATED
                  ]);
                  
               }

            }
         }

         

         wp_send_json_success(['message' => 'insert_order_ok']);
         wp_die();
      } else {
         wp_send_json_success(['message' => 'hash_exists' ]);
         wp_die();
      }

   }

}


function atlantis_get_order(){
   if( isset( $_POST['action'] ) && $_POST['action'] == 'atlantis_get_order' ){
      $order_id = isset($_POST['order_id']) ? $_POST['order_id'] : 0;
      $user_id = isset($_POST['user_id']) ? $_POST['user_id'] : 0;

      if(is_user_logged_in() == true ){
         $user_id = get_current_user_id();
         $user = get_user_by('id', $user_id);
         $prefix_user = 'user_' . $user->data->ID;
      }else{
         wp_send_json_error(['message' => 'no_login_invalid' ]);
         wp_die();
      }

      $is_user_store = get_user_meta($user_id , 'user_store', true) != '' 
         ? (int) get_user_meta($user_id , 'user_store', true) 
         : null;

      global $wpdb;

      // GET ORDER FOR USER
      if( $is_user_store == null || $is_user_store == 0 ){
         $sql = "SELECT *,
            wp_watergo_store.name as store_name,
            wp_watergo_products.name as product_name,

            wp_watergo_photo.url as product_image
            
            FROM wp_watergo_order
            LEFT JOIN wp_watergo_order_group 
               ON wp_watergo_order_group.hash_id = wp_watergo_order.hash_id
            LEFT JOIN wp_watergo_store
               ON wp_watergo_store.id = wp_watergo_order_group.order_group_store_id
            LEFT JOIN wp_watergo_products 
               ON wp_watergo_products.id = wp_watergo_order_group.order_group_product_id

            LEFT JOIN wp_watergo_photo
               ON wp_watergo_photo.upload_by = wp_watergo_products.id AND wp_watergo_photo.kind_photo = 'product'

            WHERE
               wp_watergo_order.order_by = $user_id
         ";
      }

      // GET ORDER FOR STORE
      if( $is_user_store != null && $is_user_store == 1 ){
         $sql = "SELECT *,
            wp_watergo_store.name as store_name,
            wp_watergo_products.name as product_name,

            wp_watergo_photo.url as product_image
            FROM wp_watergo_order
            LEFT JOIN wp_watergo_order_group 
            ON wp_watergo_order_group.hash_id = wp_watergo_order.hash_id

            LEFT JOIN wp_watergo_store
            ON wp_watergo_store.id = wp_watergo_order_group.order_group_store_id

            LEFT JOIN wp_watergo_products 
            ON wp_watergo_products.id = wp_watergo_order_group.order_group_product_id

            LEFT JOIN wp_watergo_photo
            ON wp_watergo_photo.upload_by = wp_watergo_products.id AND wp_watergo_photo.kind_photo = 'product'

            WHERE 
               wp_watergo_order_group.order_group_store_id = $user_id
            ORDER BY wp_watergo_order.order_time_created ASC
         ";
      }

      // ORDER FOR USER
      if( $order_id != 0 && ($is_user_store == null || $is_user_store == 0) ){
      
         $sql = "SELECT *,
            wp_watergo_store.name as store_name,
            wp_watergo_products.name as product_name,

            wp_watergo_photo.url as product_image
            
            FROM wp_watergo_order
            LEFT JOIN wp_watergo_order_group 
               ON wp_watergo_order_group.hash_id = wp_watergo_order.hash_id
            LEFT JOIN wp_watergo_store
               ON wp_watergo_store.id = wp_watergo_order_group.order_group_store_id
            LEFT JOIN wp_watergo_products 
               ON wp_watergo_products.id = wp_watergo_order_group.order_group_product_id

            LEFT JOIN wp_watergo_photo
            ON wp_watergo_photo.upload_by = wp_watergo_products.id AND wp_watergo_photo.kind_photo = 'product'

            WHERE
               wp_watergo_order.order_by = $user_id
            AND 
               wp_watergo_order.order_id = $order_id
         ";
      }
      // ORDER FOR STORE
      if( $order_id != 0 && ($is_user_store != null && $is_user_store == 1) ){
         $sql = "SELECT *,
            wp_watergo_store.name as store_name,
            wp_watergo_products.name as product_name,

            wp_watergo_photo.url as product_image
            
            FROM wp_watergo_order
            LEFT JOIN wp_watergo_order_group 
               ON wp_watergo_order_group.hash_id = wp_watergo_order.hash_id
            LEFT JOIN wp_watergo_store
               ON wp_watergo_store.id = wp_watergo_order_group.order_group_store_id
            LEFT JOIN wp_watergo_products 
               ON wp_watergo_products.id = wp_watergo_order_group.order_group_product_id

            LEFT JOIN wp_watergo_photo
               ON wp_watergo_photo.upload_by = wp_watergo_products.id AND wp_watergo_photo.kind_photo = 'product'

            WHERE
               wp_watergo_store.id = $user_id
            AND 
               wp_watergo_order.order_id = $order_id ";
      }


      $res = $wpdb->get_results($sql);

      if( empty( $res ) ){
         wp_send_json_error(['message' => 'no_order_found 1 ' ]);
         wp_die();
      }
      $final = [];

      foreach ($res as $k => $item) {
         $key = $item->hash_id;

         $product_quantity = '';
         if( $item->product_type == 'water'){
            $product_quantity = $item->quantity;
         }else if($item->product_type == 'ice'){
            $product_quantity = $item->weight . 'kg ' . $item->length_width . 'mm';
         }

         if (isset($final[$key]['order_products'] )) {
            
            $final[$key]['order_products'][] = [
               'product_image'                        => $item->product_image,
               'order_group_id'                       => $item->order_group_id,
               'order_group_product_id'               => $item->order_group_product_id,
               'order_group_product_name'             => $item->product_name,
               'order_group_product_quantity'         => $product_quantity,
               'order_group_product_quantity_count'   => $item->order_group_product_quantity_count,
               'order_group_product_price'            => $item->order_group_product_price,
               'order_group_product_discount_percent' => $item->order_group_product_discount_percent,
               'order_group_store_id'                 => $item->order_group_store_id,
            ];


         } else {
            // Item with the order_id or hash_id does not exist, create a new entry
            $final[$key] = [
               'order_id'                 => $item->order_id,
               'order_delivery_type'      => $item->order_delivery_type,
               'order_delivery_data'      => json_decode( json_decode( $item->order_delivery_data, true), true ) ,
               'order_payment_method'     => $item->order_payment_method,
               'order_status'             => $item->order_status,
               'order_delivery_address'   => json_decode( json_decode( $item->order_delivery_address, true ), true ),
               'order_time_created'       => $item->order_time_created,
               'order_time_confirmed'     => $item->order_time_confirmed,
               'order_time_cancel'        => $item->order_time_cancel,
               'order_time_completed'     => $item->order_time_completed,
               'order_time_delivery'      => $item->order_time_delivery,
               'order_by'                 => $item->order_by,
               'store_name'               => $item->store_name,
               'store_id'                 => $item->order_group_store_id,
               'order_products' => [
                  [
                     'product_image'                        => $item->product_image,
                     'order_group_id'                       => $item->order_group_id,
                     'order_group_product_id'               => $item->order_group_product_id,
                     'order_group_product_name'             => $item->product_name,
                     'order_group_product_quantity'         => $product_quantity,
                     'order_group_product_quantity_count'   => $item->order_group_product_quantity_count,
                     'order_group_product_price'            => $item->order_group_product_price,
                     'order_group_product_discount_percent' => $item->order_group_product_discount_percent,
                     'order_group_store_id'                 => $item->order_group_store_id,
                  ]
               ]
            ];
         }
      }

      if( ! empty( $final ) ){
         sort($final);
         if( $order_id == 0 ){
            wp_send_json_success(['message' => 'get_order_ok', 'data' => $final]);
         }else{
            wp_send_json_success(['message' => 'get_order_ok', 'data' => $final[0]]);
         }
         wp_die();
      }


      wp_send_json_error(['message' => 'no_order_found 2' ]);
      wp_die();



   }
}

/**
 * @access ORDER FROM USER FILTER BY [WEEKLY | MONTHLY]
 */

function atlantis_get_order_filter(){
   if( isset( $_POST['action'] ) && $_POST['action'] == 'atlantis_get_order_filter' ){
      $filter = isset($_POST['filter']) ? $_POST['filter'] : '';

      if(is_user_logged_in() == true ){
         $user_id = get_current_user_id();
         $user = get_user_by('id', $user_id);
         $prefix_user = 'user_' . $user->data->ID;
      }else{
         wp_send_json_error(['message' => 'no_login_invalid' ]);
         wp_die();
      }

      if( $filter == ''){
         wp_send_json_error(['message' => 'no_order_found' ]);
         wp_die();
      }

      global $wpdb;

      $sql = "SELECT *,
            wp_watergo_store.name as store_name,
            wp_watergo_products.name as product_name,

            wp_watergo_photo.url as product_image
            
            FROM wp_watergo_order
            LEFT JOIN wp_watergo_order_group 
               ON wp_watergo_order_group.hash_id = wp_watergo_order.hash_id
            LEFT JOIN wp_watergo_store
               ON wp_watergo_store.id = wp_watergo_order_group.order_group_store_id
            LEFT JOIN wp_watergo_products 
               ON wp_watergo_products.id = wp_watergo_order_group.order_group_product_id
            LEFT JOIN wp_watergo_photo
               ON wp_watergo_photo.upload_by = wp_watergo_products.id AND wp_watergo_photo.kind_photo = 'product'

            WHERE
               wp_watergo_order.order_by = $user_id
            AND 
               wp_watergo_order.order_delivery_type = '$filter'
            AND
               wp_watergo_order.order_keep_repeat = 1
            AND 
               wp_watergo_order.order_status IN ('ordered', 'confirmed')
      ";

      $res = $wpdb->get_results($sql);

      if( empty( $res ) ){
         wp_send_json_error(['message' => 'no_order_found 1 ' ]);
         wp_die();
      }
      $final = [];

      foreach ($res as $k => $item) {
         $key = $item->order_id ?: $item->hash_id;

         $product_quantity = '';
         if( $item->product_type == 'water'){
            $product_quantity = $item->quantity;
         }else if($item->product_type == 'ice'){
            $product_quantity = $item->weight . 'kg ' . $item->length_width . 'mm';
         }

         if (isset($final[$key]['order_products'] )) {
            
            $final[$key]['order_products'][] = [
               'product_image'                        => $item->product_image,
               'order_group_hash_id'                  => $item->hash_id,
               'order_group_id'                       => $item->order_group_id,
               'order_group_product_id'               => $item->order_group_product_id,
               'order_group_product_name'             => $item->product_name,
               'order_group_product_quantity'         => $product_quantity,
               'order_group_product_quantity_count'   => $item->order_group_product_quantity_count,
               'order_group_product_price'            => $item->order_group_product_price,
               'order_group_product_discount_percent' => $item->order_group_product_discount_percent,
               'order_group_store_id'                 => $item->order_group_store_id,
               'order_group_repeat'                   => $item->order_group_repeat
            ];


         } else {
            // Item with the order_id or hash_id does not exist, create a new entry
            $final[$key] = [
               'order_hash_id'                        => $item->hash_id,
               'order_id'                 => $item->order_id,
               'order_delivery_type'      => $item->order_delivery_type,
               'order_delivery_data'      => json_decode( json_decode( $item->order_delivery_data, true), true ) ,
               'order_payment_method'     => $item->order_payment_method,
               'order_status'             => $item->order_status,
               'order_delivery_address'   => json_decode( json_decode( $item->order_delivery_address, true ), true ),
               'order_time_created'       => $item->order_time_created,
               'order_time_cancel'        => $item->order_time_cancel,
               'order_time_completed'     => $item->order_time_completed,
               'order_time_delivery'      => $item->order_time_delivery,
               'order_by'                 => $item->order_by,
               'store_name'               => $item->store_name,
               'store_id'                 => $item->order_group_store_id,
               'order_products' => [
                  [
                     'product_image'                        => $item->product_image,
                     'order_group_hash_id'                  => $item->hash_id,
                     'order_group_id'                       => $item->order_group_id,
                     'order_group_product_id'               => $item->order_group_product_id,
                     'order_group_product_name'             => $item->product_name,
                     'order_group_product_quantity'         => $product_quantity,
                     'order_group_product_quantity_count'   => $item->order_group_product_quantity_count,
                     'order_group_product_price'            => $item->order_group_product_price,
                     'order_group_product_discount_percent' => $item->order_group_product_discount_percent,
                     'order_group_store_id'                 => $item->order_group_store_id,
                     'order_group_repeat'                   => $item->order_group_repeat
                  ]
               ]
            ];
         }
      }

      if( ! empty( $final ) ){
         sort($final);
         wp_send_json_success(['message' => 'get_order_ok', 'data' => $final]);
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

      $id_update = 0;

      $sql = "SELECT order_repeat_id FROM wp_watergo_order 
         WHERE order_id = $order_id 
         ORDER BY order_repeat_count DESC 
         LIMIT 1 ";

      $res = $wpdb->get_results($sql);

      if( empty( $res ) ){
         $id_update = $order_id;
      }else{
         if( $res[0]->order_repeat_id != 0 ){
            $id_update = $res[0]->order_repeat_id;
         }else{
            $id_update = $order_id;
         }
      }

      $updated = $wpdb->update( 'wp_watergo_order',
         ['order_keep_repeat' => 0],
         ['order_id' => $id_update]
      );

      if ( $updated ) {
         wp_send_json_success( array( 'message' => 'order_delete_ok', 'data' => $res ) );
         wp_die();
      } else {
         wp_send_json_error( array( 'message' => 'order_not_found' ) );
         wp_die();
      }

      wp_send_json_error(['message' => 'order_not_found' ]);
      wp_die();
   }
}

function atlantis_cancel_order(){
   if( isset( $_POST['action'] ) && $_POST['action'] == 'atlantis_cancel_order' ){
      $order_id = isset($_POST['order_id']) ? $_POST['order_id'] : 0;

      if(is_user_logged_in() == true ){
         $user_id = get_current_user_id();
         $user = get_user_by('id', $user_id);
         $prefix_user = 'user_' . $user->data->ID;
      }else{
         wp_send_json_error(['message' => 'no_login_invalid' ]);
         wp_die();
      }

      global $wpdb;
      
      $d = $wpdb->update('wp_watergo_order', [
         'order_status' => 'cancel',
         'order_keep_repeat' => 0,
         'order_time_cancel' => time()
      ],[ 'order_id' => $order_id ]);

      wp_send_json_success(['message' => 'cancel_done']);
      wp_die();

   }
}

/**
 * @access THIS FUNCTION WILL CLONE RECORD FROM DATABASE
 */
// can use multiple id

function atlantis_clone_order( $order_id, $order_repeat_count, $order_keep_repeat ){
   // order_keep_repeat 0 for all, clone order no function to repeat
   global $wpdb;

   $hash_id = bin2hex(random_bytes(64));
   $time_created     = time();
   $time_confirmed   = time();

   $sql_clone = "INSERT INTO wp_watergo_order(
      hash_id,
      order_by,
      order_delivery_type,
      order_delivery_data,
      order_payment_method,
      order_status,
      order_delivery_address,
      order_time_created,
      order_time_confirmed,
      order_time_cancel,
      order_time_completed,
      order_time_delivery,
      order_repeat_count,
      order_repeat_id,
      order_keep_repeat
   )
   SELECT 
      '$hash_id',
      order_by,
      order_delivery_type,
      order_delivery_data,
      order_payment_method,
      'ordered',
      order_delivery_address,
      $time_created,
      0,
      0,
      0,
      0,
      $order_repeat_count,
      $order_id,
      $order_keep_repeat
   FROM wp_watergo_order
   WHERE  order_id = $order_id";

   $wpdb->query($sql_clone);

   return $hash_id;
}

function alantis_clone_order_group($hash_id_check, $hash_id_insert){
   global $wpdb;

   $sql = "INSERT INTO wp_watergo_order_group( 
         order_group_product_id,
         order_group_product_quantity_count,
         order_group_product_price,
         order_group_product_discount_percent,
         order_group_store_id,
         hash_id
      )
      SELECT 
         order_group_product_id,
         order_group_product_quantity_count,
         order_group_product_price,
         order_group_product_discount_percent,
         order_group_store_id,
         '$hash_id_insert'
      FROM wp_watergo_order_group
      WHERE hash_id = '$hash_id_check' ";

   $wpdb->query($sql);
}

// END FUNCTION CLONE

/**
 * @access CHANGE STATUS ORDER
 */
function atlantis_order_status(){
   if( isset( $_POST['action'] ) && $_POST['action'] == 'atlantis_order_status' ){
      
      $order_id = isset($_POST['order_id']) ? $_POST['order_id'] : '';
      $timestamp = isset($_POST['timestamp']) ? $_POST['timestamp'] : 0;

      $status = isset($_POST['status']) ? $_POST['status'] : '';

      if($order_id == ''){
         wp_send_json_error(['message' => 'order_not_found' ]);
         wp_die();
      }

      if($status == ''){
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

      global $wpdb;

      if( ! empty( $wheres )){
         
         $order_time = '';

         if( $status == 'confirmed' ){
            $order_status = 'confirmed';
            $order_time = "order_time_confirmed = %d ";
         }
         if( $status == 'delivering' ){
            $order_status = 'delivering';
            $order_time = "order_time_delivery = %d ";
         }
         if( $status == 'complete' ){
            $order_status = 'complete';
            $order_time = "order_time_completed = %d ";


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

                  // GET FATHER ID 
                  $sql_get_father_id = "SELECT order_repeat_id FROM wp_watergo_order 
                     WHERE order_id = $_order_id 
                     ORDER BY order_repeat_count DESC 
                     LIMIT 1 ";
                  $res_father = $wpdb->get_results($sql_get_father_id);
                  if( empty( $res_father ) ){
                     $id_father = $_order_id;
                  }else{
                     if( $res_father[0]->order_repeat_id != 0 ){
                        $id_father = $res_father[0]->order_repeat_id;
                     }else{
                        $id_father = $_order_id;
                     }
                  }

                  // CHECK FATHER ID still keep automatic repeat order
                  $_is_order_keep_repeat_order = null;

                  $sql_check_order_repeat = "SELECT order_keep_repeat FROM wp_watergo_order
                     WHERE order_id = $id_father
                  ";
                  $res_repeat = $wpdb->get_results($sql_check_order_repeat);
                  if( ! empty( $res_repeat ) ){
                     $_is_order_keep_repeat_order = $res_repeat[0]->order_keep_repeat;
                  }

                  if( $_is_order_keep_repeat_order == 1){
                     $_new_hash_id = '';

                     /**
                      * @access CLONE ORDER
                        */

                     $sql_check_repeat_self = "SELECT order_repeat_id, order_repeat_count FROM 
                        wp_watergo_order
                        WHERE order_id = $_order_id
                        ORDER BY order_repeat_count DESC
                        LIMIT 1
                     ";

                     $res_check_repeat = $wpdb->get_results( $sql_check_repeat_self);
                     $_order_repeat_id    = $res_check_repeat[0]->order_repeat_id;
                     $_order_repeat_count = $res_check_repeat[0]->order_repeat_count;

                     // no relationship
                     if( $_order_repeat_id == 0 && $_order_repeat_count == 0 ){
                        $_new_hash_id = atlantis_clone_order($_order_id, 1 , 1);
                     }else{
                        // 
                        $_new_hash_id = atlantis_clone_order($_order_repeat_id, $_order_repeat_count + 1, 0);
                     }

                     alantis_clone_order_group($_hash_id, $_new_hash_id);
                  }

               }
            }

         }

         if( $status == 'cancel' ){
            $order_status = 'cancel';
            $order_time = "order_time_cancel = %d ";
         }

         $updated = $wpdb->query(
            $wpdb->prepare(
               "UPDATE wp_watergo_order
               SET order_status = %s, 
               $order_time
               WHERE order_id IN (". implode(',', array_fill(0, count($wheres), '%d')) . ")",
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
 * @access WHEN ORDER TYPE LIKE weekly | monthly -> get back data
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
         wp_watergo_products.name as product_name,

         p1.url as product_image
         #p2.url as store_image
         
         FROM wp_watergo_order
         LEFT JOIN wp_watergo_order_group 
            ON wp_watergo_order_group.hash_id = wp_watergo_order.hash_id
         LEFT JOIN wp_watergo_store
            ON wp_watergo_store.id = wp_watergo_order_group.order_group_store_id
         LEFT JOIN wp_watergo_products 
            ON wp_watergo_products.id = wp_watergo_order_group.order_group_product_id
            
         LEFT JOIN wp_watergo_photo as p1
            ON p1.upload_by = wp_watergo_products.id AND p1.kind_photo = 'product'
         #LEFT JOIN wp_watergo_photo as p2
            #ON p2.upload_by = wp_watergo_store.id AND p2.kind_photo = 'store'

         WHERE
            wp_watergo_order.order_id
         NOT IN ($placeholders)

      ";
      global $wpdb;

      $prepare = $wpdb->prepare($sql, $wheres);
      $res = $wpdb->get_results($prepare);

      $final = [];
      
      if( !empty($res ) ){
         foreach ($res as $k => $item) {
            $key = $item->hash_id;

            $product_quantity = '';
            if( $item->product_type == 'water'){
               $product_quantity = $item->quantity;
            }else if($item->product_type == 'ice'){
               $product_quantity = $item->weight . 'kg ' . $item->length_width . 'mm';
            }

            if (isset($final[$key]['order_products'] )) {
               
               $final[$key]['order_products'][] = [
                  'product_image'                        => $item->product_image,
                  'order_group_id'                       => $item->order_group_id,
                  'order_group_product_id'               => $item->order_group_product_id,
                  'order_group_product_name'             => $item->product_name,
                  'order_group_product_quantity'         => $product_quantity,
                  'order_group_product_quantity_count'   => $item->order_group_product_quantity_count,
                  'order_group_product_price'            => $item->order_group_product_price,
                  'order_group_product_discount_percent' => $item->order_group_product_discount_percent,
                  'order_group_store_id'                 => $item->order_group_store_id,
               ];


            } else {
               // Item with the order_id or hash_id does not exist, create a new entry
               $final[$key] = [
                  'order_id'                 => $item->order_id,
                  'order_delivery_type'      => $item->order_delivery_type,
                  'order_delivery_data'      => json_decode( json_decode( $item->order_delivery_data, true), true ) ,
                  'order_payment_method'     => $item->order_payment_method,
                  'order_status'             => $item->order_status,
                  'order_delivery_address'   => json_decode( json_decode( $item->order_delivery_address, true ), true ),
                  'order_time_created'       => $item->order_time_created,
                  'order_time_confirmed'     => $item->order_time_confirmed,
                  'order_time_cancel'        => $item->order_time_cancel,
                  'order_time_completed'     => $item->order_time_completed,
                  'order_time_delivery'      => $item->order_time_delivery,
                  'order_by'                 => $item->order_by,
                  'store_name'               => $item->store_name,
                  'store_id'                 => $item->order_group_store_id,
                  // REPEAT ORDER
                  'order_products' => [
                     [
                        'product_image'                        => $item->product_image,
                        'order_group_id'                       => $item->order_group_id,
                        'order_group_product_id'               => $item->order_group_product_id,
                        'order_group_product_name'             => $item->product_name,
                        'order_group_product_quantity'         => $product_quantity,
                        'order_group_product_quantity_count'   => $item->order_group_product_quantity_count,
                        'order_group_product_price'            => $item->order_group_product_price,
                        'order_group_product_discount_percent' => $item->order_group_product_discount_percent,
                        'order_group_store_id'                 => $item->order_group_store_id,
                     ]
                  ]
               ];
            }
         }
      }

      if( ! empty($final )){
         sort($final);
         wp_send_json_success(['message' => 'order_callback_ok', 'data' => $final]);
         wp_die();
      }

      wp_send_json_error(['message' => 'order_callback_error'  ]);
      wp_die();


   }
}