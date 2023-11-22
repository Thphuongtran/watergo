<?php
/**
 * @access LOAD ORDER
 */

add_action( 'wp_ajax_nopriv_atlantis_add_order', 'atlantis_add_order' );
add_action( 'wp_ajax_atlantis_add_order', 'atlantis_add_order' );

add_action( 'wp_ajax_nopriv_atlantis_get_order', 'atlantis_get_order' );
add_action( 'wp_ajax_atlantis_get_order', 'atlantis_get_order' );

// USING ONLY 3 EVENT [GET - ADD - UPDATE]

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


            if( $check_hash == 0 ){

               $wpdb->insert('wp_watergo_order', [
                  'order_by' => $user_id,
                  'order_delivery_type' => $delivery_type,
                  'order_delivery_data' => json_encode( stripslashes( $delivery_data), JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES),
                  'order_payment_method' => 'cash',
                  'order_status' => 'ordered',
                  'order_delivery_address' => json_encode( stripslashes( $delivery_address), JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES),
                  'order_time_created' => time(),
                  'hash_id' => (String) $hash_id
               ]);

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

      // if(is_user_logged_in() == true ){
      //    $user_id = get_current_user_id();
      //    $user = get_user_by('id', $user_id);
      //    $prefix_user = 'user_' . $user->data->ID;
      // }else{
      //    wp_send_json_error(['message' => 'no_login_invalid' ]);
      //    wp_die();
      // }

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
            WHERE
               wp_watergo_order.order_by = $user_id
      ";

      if( $order_id != 0 ){
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
            WHERE
               wp_watergo_order.order_by = $user_id
            AND 
               wp_watergo_order.order_id = $order_id
         ";
      }

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

         if (isset($final[$key])) {
            // Item with the same order_id or hash_id already exists, merge the product data
            $storeIndex = array_search($item->order_group_store_id, array_column($final[$key]['order_products'], 'store_id'));

            if ($storeIndex !== false) {
               // Store with the same store_id already exists, add the product
               $final[$key]['order_products'][$storeIndex]['products'][] = [
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
               // Store with the order_group_store_id does not exist, create a new store entry
               $final[$key]['order_products'][] = [
                  'store_id'     => $item->order_group_store_id,
                  'store_name'   => $item->store_name,
                  'products' => [
                     [
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
               'order_time_cancel'        => $item->order_time_cancel,
               'order_time_completed'     => $item->order_time_completed,
               'order_time_delivery'      => $item->order_time_delivery,
               'order_by'                 => $item->order_by,
               'order_products' => [
                  [
                     'store_id'     => $item->order_group_store_id,
                     'store_name'   => $item->store_name,
                     'products'     => [
                        [
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
                  ]
               ]
            ];
         }
      }

      if( ! empty( $final ) ){
         sort($final);
         if( $order_id == 0 ){
            wp_send_json_success(['message' => 'get_order_ok', 'data' => $final, 'res' => $res]);
         }else{
            wp_send_json_success(['message' => 'get_order_ok', 'data' => $final[0], 'res' => $res ]);
         }
         wp_die();
      }


      wp_send_json_error(['message' => 'no_order_found 2' ]);
      wp_die();



}
   }