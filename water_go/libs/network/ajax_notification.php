<?php

add_action( 'wp_ajax_nopriv_atlantis_notification', 'atlantis_notification' );
add_action( 'wp_ajax_atlantis_notification', 'atlantis_notification' );

add_action( 'wp_ajax_nopriv_atlantis_notification_count', 'atlantis_notification_count' );
add_action( 'wp_ajax_atlantis_notification_count', 'atlantis_notification_count' );

add_action( 'wp_ajax_nopriv_atlantis_notification_load_all', 'atlantis_notification_load_all' );
add_action( 'wp_ajax_atlantis_notification_load_all', 'atlantis_notification_load_all' );

add_action( 'wp_ajax_nopriv_atlantis_notification_mark_read_notification', 'atlantis_notification_mark_read_notification' );
add_action( 'wp_ajax_atlantis_notification_mark_read_notification', 'atlantis_notification_mark_read_notification' );

add_action( 'wp_ajax_nopriv_atlantis_notification_mark_read_notification_hash_id', 'atlantis_notification_mark_read_notification_hash_id' );
add_action( 'wp_ajax_atlantis_notification_mark_read_notification_hash_id', 'atlantis_notification_mark_read_notification_hash_id' );

function atlantis_notification_mark_read_notification_hash_id(){
   if( isset($_POST['action']) && $_POST['action'] == 'atlantis_notification_mark_read_notification_hash_id' ){
      $hash_id = isset($_POST['hash_id']) ? $_POST['hash_id'] : null;

      if( $hash_id == null || $hash_id == '' || $hash_id == 0 ){
         wp_send_json_error(['message' => 'notification_not_found' ]);
         wp_die();
      }
      global $wpdb;

      $is_read = $wpdb->get_results( "SELECT is_read FROM wp_watergo_notification WHERE hash_id = '$hash_id' AND is_read = 0 AND notification_hidden != 1 ");
      if( ! empty( $is_read )){
         $wpdb->update('wp_watergo_notification', [
            'is_read'   => 1,
            'time_read' => atlantis_current_datetime(),
         ], ['hahs_id' => $hash_id ]);
      }

      wp_send_json_success(['message' => 'notification_mark_read']);
      wp_die();
   }
}

function atlantis_notification_mark_read_notification(){
   if( isset($_POST['action']) && $_POST['action'] == 'atlantis_notification_mark_read_notification' ){
      $id_notification = isset($_POST['id_notification']) ? $_POST['id_notification'] : 0;

      if( $id_notification == 0 ){
         wp_send_json_error(['message' => 'notification_not_found' ]);
         wp_die();
      }

      global $wpdb;

      $is_read = $wpdb->get_results( "SELECT is_read FROM wp_watergo_notification WHERE id = $id_notification AND is_read = 0");
      if( ! empty( $is_read )){
         $wpdb->update('wp_watergo_notification', [
            'is_read'   => 1,
            'time_read' => atlantis_current_datetime(),
         ], ['id' => $id_notification ]);
      }

      wp_send_json_success(['message' => 'notification_mark_read', 'is_read' => $is_read ]);
      wp_die();

   }
}

function func_atlantis_add_notification( $user_id, $store_id, $order_status, $order_id, $link, $attachment_url, $order_number, $send_to, $hash_id  ){
   global $wpdb;
   $wpdb->insert('wp_watergo_notification', [
      'order_status'       => $order_status,
      'time_created'       => atlantis_current_datetime(),
      'user_id'            => $user_id,
      'store_id'           => $store_id, // note this is user_id
      'notification_type'  => 'order',
      'is_read'            => 0,
      'link'               => $link,
      'order_id'           => $order_id,
      'attachment_url'     => $attachment_url,
      'order_number'       => $order_number,
      'send_to'            => $send_to,
      'hash_id'            => $hash_id
   ]);
}


function func_atlantis_order_status_notification( $order_id, $send_to, $status ){
   if( $order_id == null || $order_id == 0 ) return false;

   global $wpdb;

   $sql = "SELECT * FROM wp_watergo_notification WHERE order_id = $order_id AND order_status = 'ordered' ";
   $get_noti = $wpdb->get_results($sql);

   // BUG

   if( empty($get_noti) ) return false;

   $attachment_url   = $get_noti[0]->attachment_url;
   $order_number     = $get_noti[0]->order_number;
   $order_id         = $get_noti[0]->order_id;
   $hash_id          = $get_noti[0]->hash_id;
   $user_id          = $get_noti[0]->user_id;
   $store_id         = $get_noti[0]->store_id;

   $id_notification  = $get_noti[0]->id;
   
   $link             = get_bloginfo('home') . "/order/?order_page=order-detail&order_id=$order_id&hash_id=". $hash_id ."&appt=N";

   // LINK CANCEL
   if( $send_to == 'store' && $status == 'cancel'){
      $link      = get_bloginfo('home') . '/order/?order_page=order-store-detail&order_id='. $order_id .'&hash_id='. $hash_id .'&appt=N';
   }

   $time_created     = atlantis_current_datetime();

   $sql_clone = "INSERT INTO wp_watergo_notification(
      order_status,
      time_created,
      user_id,
      store_id,
      is_read,
      link,
      notification_type,
      order_id,
      attachment_url,
      order_number,
      send_to,
      hash_id
   )
   SELECT 
      '$status',
      '$time_created',
      user_id,
      store_id,
      0,
      '$link',
      notification_type,
      order_id,
      attachment_url,
      order_number,
      '$send_to',
      hash_id

   FROM wp_watergo_notification
   WHERE id = $id_notification";
   $wpdb->query($sql_clone);

   return [
      'link_app'        => $link,
      'attachment_url'  => $attachment_url,
      'order_id'        => $order_id,
      'order_number'    => $order_number,
      'user_id'         => $user_id,
      'store_id'        => $store_id
   ];
}

function atlantis_notification_load_all(){
   if( isset($_POST['action']) && $_POST['action'] == 'atlantis_notification_load_all' ){

      $user_id = get_current_user_id();

      $limit = isset($_POST['limit']) ? $_POST['limit'] : 10;
      $paged = isset($_POST['paged']) ? $_POST['paged'] : 0;

      $is_user_store = get_user_meta($user_id , 'user_store', true) != '' 
         ? (int) get_user_meta($user_id , 'user_store', true) 
         : null;

      global $wpdb;

      $get_store_id  = $wpdb->get_results("SELECT id FROM wp_watergo_store WHERE user_id = $user_id 
         AND store_hidden != 1
      ");
      $store_id      = $get_store_id[0]->id;

      $condition  = "user_id = $user_id";
      $condition2 = " send_to = 'user' ";

      if( $is_user_store == 1 || $is_user_store == true ){
         $condition = "store_id = $store_id";
         $condition2 = " send_to = 'store' ";
      }

      $sql = "SELECT * FROM wp_watergo_notification 
         WHERE $condition AND $condition2 
         AND notification_hidden != 1
         ORDER BY 
            time_created DESC,
            is_read DESC
         LIMIT $paged, $limit
      ";
      $res = $wpdb->get_results( $sql );


      if( ! empty($res) ){
         foreach( $res as $k => $vl ){
            $text = __($vl->text, 'watergo');
            $number_order = str_pad( $vl->order_number , 4, "0", STR_PAD_LEFT);
            $vl->text = sprintf($text, $number_order );
         }
         wp_send_json_success(['message' => 'notification_found', 'data' => $res ]);
         wp_die();
      }

      wp_send_json_error(['message' => 'notification_not_found' ]);
      wp_die();
      
   }
}


function atlantis_notification_count(){
   if( isset( $_POST['action'] ) && $_POST['action'] == 'atlantis_notification_count' ){
      
      $user_id = get_current_user_id();
      $is_user_store = get_user_meta($user_id , 'user_store', true) != '' 
         ? (int) get_user_meta($user_id , 'user_store', true) 
         : null;

      global $wpdb;
      $get_store_id  = $wpdb->get_results("SELECT id FROM wp_watergo_store WHERE user_id = $user_id AND store_hidden != 1");
      $store_id      = $get_store_id[0]->id;
      // $store_id = func_get_store_id_from_current_user();
      
      $condition = "user_id = $user_id";
      $condition2 = "send_to = 'user'";

      if( $is_user_store == 1 || $is_user_store == true ){
         $condition = "store_id = $store_id";
         $condition2 = "send_to = 'store'";
      }

      $sql     = "SELECT COUNT(*) as count FROM wp_watergo_notification WHERE $condition AND is_read = 0 AND $condition2 AND notification_hidden != 1";
      // $sql     = "SELECT COUNT(*) as count FROM wp_watergo_notification WHERE ($condition1) AND is_read = 0 AND ($condition2)";

      $res     = $wpdb->get_results( $sql );

      if( $res[0]->count != null && $res[0]->count > 0 ){
         wp_send_json_success(['message' => 'notification_found', 'data' => (int) $res[0]->count ]);
         wp_die();   
      }

      wp_send_json_success(['message' => 'notification_found', 'data' => 0]);
      wp_die();
      
   }
}


/**
 * @access PROTOCAL
 */

function protocal_atlantis_notification_to_user( $args ){
   $args = isset($args) ? $args : [];

   $time_created     = atlantis_current_datetime();

   $order_status     = $args['order_status'];
   $order_id         = $args['order_id'];

   $hash_id          = bin2hex(random_bytes(32));

   global $wpdb;

   $sql = "SELECT * FROM wp_watergo_notification WHERE order_id = $order_id AND order_status = 'ordered' ";
   $get_order = $wpdb->get_results($sql);

   if( empty( $get_order )) return;

   $get_order              = $get_order[0];
   $link                   = get_bloginfo('home') . '/order/?order_page=order-detail&order_id='. $order_id .'&hash_id='. $hash_id .'&appt=N';

   $number_order = str_pad( $get_order->order_number , 4, "0", STR_PAD_LEFT);

   if( $order_status == 'confirmed'){
      // $user_id_from_store_id  = func_atlantis_get_user_id_from_store_id($get_order->order_id);
      
      $wpdb->insert('wp_watergo_notification', [
         'order_status'       => 'confirmed',
         'time_created'       => $time_created,
         'user_id'            => $get_order->user_id,
         'store_id'           => $get_order->store_id, // note this is user_id
         'notification_type'  => 'order',
         'is_read'            => 0,
         'link'               => $link,
         'order_id'           => $get_order->order_id,
         'attachment_url'     => $get_order->attachment_url,
         'order_number'       => $get_order->order_number,
         'send_to'            => 'user',
         'hash_id'            => $hash_id,
         'text'               => "Your order <span class='hightlight-order'>#%s</span> is confirmed"
      ]);

      $text_push = sprintf(__("Your order #%s is confirmed", 'watergo'), $number_order);

      bj_push_notification( 
         $get_order->user_id,
         'Watergo',
         $text_push,
         $link 
      );
   }

   if( $order_status == 'delivering' ){

      $wpdb->insert('wp_watergo_notification', [
         'order_status'       => 'delivering',
         'time_created'       => $time_created,
         'user_id'            => $get_order->user_id,
         'store_id'           => $get_order->store_id, // note this is user_id
         'notification_type'  => 'order',
         'is_read'            => 0,
         'link'               => $link,
         'order_id'           => $get_order->order_id,
         'attachment_url'     => $get_order->attachment_url,
         'order_number'       => $get_order->order_number,
         'send_to'            => 'user',
         'hash_id'            => $hash_id,
         'text'               => "Your order <span class='hightlight-order'>#%s</span> is delivering",
      ]);

      $text_push = sprintf(__("Your order #%s is delivering", 'watergo'), $number_order);

      bj_push_notification( 
         $get_order->user_id,
         'Watergo',
         $text_push,
         $link 
      );

   }

   if( $order_status == 'completed' ){
      $wpdb->insert('wp_watergo_notification', [
         'order_status'       => 'completed',
         'time_created'       => $time_created,
         'user_id'            => $get_order->user_id,
         'store_id'           => $get_order->store_id, // note this is user_id
         'notification_type'  => 'order',
         'is_read'            => 0,
         'link'               => $link,
         'order_id'           => $get_order->order_id,
         'attachment_url'     => $get_order->attachment_url,
         'order_number'       => $get_order->order_number,
         'send_to'            => 'user',
         'hash_id'            => $hash_id,
         'text'               => "Your order <span class='hightlight-order'>#%s</span> is completed"
      ]);

      $text_push = sprintf(__("Your order #%s is completed", 'watergo'), $number_order);

      bj_push_notification( 
         $get_order->user_id,
         'Watergo',
         $text_push,
         $link 
      );

   
   }

   if( $order_status == 'cancel' ){

      $sql = "SELECT * FROM wp_watergo_notification WHERE order_id = $order_id AND order_status = 'ordered' ";
      $get_order = $wpdb->get_results($sql);

      if( !empty($get_order)){
         $get_order              = $get_order[0];
         $link_user              = get_bloginfo('home') . '/order/?order_page=order-store-detail&order_id='. $order_id .'&hash_id='. $hash_id .'&appt=N';
         $store_id               = $get_order->store_id;
         $user_id_from_store_id  = func_atlantis_get_user_id_from_store_id($store_id);
         $order_number_pad       = str_pad( $get_order->order_number , 4, "0", STR_PAD_LEFT);

         // SEND {cancel} NOTI TO USER
         $inserted_for_user = $wpdb->insert('wp_watergo_notification', [
            'order_status'       => 'cancel',
            'time_created'       => $time_created,
            'user_id'            => $get_order->user_id,
            'store_id'           => $store_id,
            'notification_type'  => 'order',
            'is_read'            => 0,
            'link'               => $link_user,
            'order_id'           => $order_id,
            'attachment_url'     => $get_order->attachment_url,
            'order_number'       => $get_order->order_number,
            'send_to'            => 'user',
            'hash_id'            => $hash_id,
            'text'               => 'Your order <span class="hightlight-order">#%s</span> is canceled',
         ]);
         $text_push_for_user  = sprintf(__('Your order #%s is canceled', 'watergo' ), $order_number_pad );

         bj_push_notification( 
            (int) $get_order->user_id,
            'Watergo',
            $text_push_for_user,
            $link_store
         );


      }

   }

}

// THIS PROTOCAL CAN CANCEL ORDER FROM BOTH USER { user - store }
function protocal_atlantis_notification_to_store( $args ){
   $args = isset($args) ? $args : [];

   $time_created     = atlantis_current_datetime();

   $order_status     = $args['order_status'];
   $store_id         = $args['store_id'];
   $order_id         = $args['order_id'];
   $user_id          = $args['user_id'];
   $order_number     = $args['order_number'];
   $attachment_url   = $args['attachment_url'];
   $hash_id          = bin2hex(random_bytes(32));

   $link             = get_bloginfo('home') . '/order/?order_page=order-store-detail&order_id='. $order_id .'&hash_id='. $hash_id .'&appt=N';
   $user_id_from_store_id = func_atlantis_get_user_id_from_store_id($store_id);

   $order_number_pad = str_pad( $order_number , 4, "0", STR_PAD_LEFT);

   global $wpdb;

   if( $order_status == 'ordered' ){

      $wpdb->insert('wp_watergo_notification', [
         'order_status'       => $order_status,
         'time_created'       => $time_created,
         'user_id'            => $user_id,
         'store_id'           => $store_id, // note this is user_id
         'notification_type'  => 'order',
         'is_read'            => 0,
         'link'               => $link,
         'order_id'           => $order_id,
         'attachment_url'     => $attachment_url,
         'order_number'       => $order_number,
         'send_to'            => 'store',
         'hash_id'            => $hash_id,
         'text'               => 'You have new order <span class="hightlight-order">#%s</span>'
      ]);
      
      $text_push = sprintf(__('You have new order #%s', 'watergo' ), $order_number_pad );

      $ordered = bj_push_notification( 
         (int) $user_id_from_store_id,
         'Watergo',
         $text_push,
         $link 
      );
   }

   if( $order_status == 'cancel' ){

      $sql = "SELECT * FROM wp_watergo_notification WHERE order_id = $order_id AND order_status = 'ordered' ";
      $get_order = $wpdb->get_results($sql);

      if( !empty($get_order)){
         $get_order              = $get_order[0];
         $link_store             = get_bloginfo('home') . '/order/?order_page=order-store-detail&order_id='. $order_id .'&hash_id='. $hash_id .'&appt=N';
         $store_id               = $get_order->store_id;
         $user_id_from_store_id  = func_atlantis_get_user_id_from_store_id($store_id);
         $order_number_pad       = str_pad( $get_order->order_number , 4, "0", STR_PAD_LEFT);

        
         // SEND {cancel} NOTI TO STORE
         $inserted_for_store = $wpdb->insert('wp_watergo_notification', [
            'order_status'       => 'cancel',
            'time_created'       => $time_created,
            'user_id'            => $get_order->user_id,
            'store_id'           => $store_id,
            'notification_type'  => 'order',
            'is_read'            => 0,
            'link'               => $link_store,
            'order_id'           => $order_id,
            'attachment_url'     => $get_order->attachment_url,
            'order_number'       => $get_order->order_number,
            'send_to'            => 'store',
            'hash_id'            => $hash_id,
            'text'               => 'The order <span class="hightlight-order">#%s</span> was canceled'
         ]);
         $text_push_for_store = sprintf(__('The order #%s was canceled', 'watergo'), $order_number_pad );

         bj_push_notification( 
            (int) $user_id_from_store_id,
            'Watergo',
            $text_push_for_store,
            $link_user
         );

      }


   }

}

/**
 * @access PROTOCAL IN BACKGROUND
 */
add_action( 'wp_ajax_atlantis_protocal_notification_in_background', 'atlantis_protocal_notification_in_background' );
function atlantis_protocal_notification_in_background(){
   if( isset($_POST['action']) && $_POST['action'] == 'atlantis_protocal_notification_in_background'){
      $send_to = isset($_POST['send_to']) ? $_POST['send_to'] : null;

      $order_status     = isset($_POST['order_status']) ? $_POST['order_status'] : null;
      $order_id         = isset($_POST['order_id']) ? $_POST['order_id'] : null;
      $user_id          = isset($_POST['user_id']) ? $_POST['user_id'] : null;
      $store_id         = isset($_POST['store_id']) ? $_POST['store_id'] : null;
      $attachment_url   = isset($_POST['attachment_url']) ? $_POST['attachment_url'] : null;
      $order_number     = isset($_POST['order_number']) ? $_POST['order_number'] : null;
      $hash             = isset($_POST['hash']) ? $_POST['hash'] : null;

      $args = [];

      if($order_status){ 
         $args['order_status'] = $order_status;
      }
      if($order_id){ 
         $args['order_id'] = $order_id;
      }
      if($user_id){ 
         $args['user_id'] = $user_id;
      }
      if($store_id){ 
         $args['store_id'] = $store_id;
      }
      if($attachment_url){ 
         $args['attachment_url'] = $attachment_url;
      }
      if($order_number){ 
         $args['order_number'] = $order_number;
      }
      if($hash){ 
         $args['hash'] = $hash;
      }

      if( $send_to == 'user' && !empty($args) ){
         protocal_atlantis_notification_to_user( $args );
      }

      if( $send_to == 'store' && !empty($args) ){
         protocal_atlantis_notification_to_store( $args );
      }

   }
}

add_action( 'wp_ajax_atlantis_push_notification_in_background', 'atlantis_push_notification_in_background' );
function atlantis_push_notification_in_background(){
   if( isset($_POST['action']) && $_POST['action'] == 'atlantis_push_notification_in_background' ){
      $user_id = isset($_POST['user_id']) ? $_POST['user_id'] : 0;
      $text_push_notification = isset($_POST['text_push_notification']) ? $_POST['text_push_notification'] : 'Watergo';
      $link                   = isset($_POST['link']) ? $_POST['link'] : 'http://watergo.net/home/?&appt=N';

      bj_push_notification( 
         (int) $user_id,
         'Watergo',
         $text_push_notification,
         $link 
      );
      
   }
}