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
      $hash_id = isset($_POST['hash_id']) ? $_POST['hash_id'] : 0;

      if( $hash_id == 0 ){
         wp_send_json_error(['message' => 'notification_not_found' ]);
         wp_die();
      }
      global $wpdb;

      $is_read = $wpdb->get_results( "SELECT is_read FROM wp_watergo_notification WHERE hash_id = '$hash_id' AND is_read = 0 ");
      if( ! empty( $is_read )){
         $wpdb->update('wp_watergo_notification', [
            'is_read'   => 1,
            'time_read' => atlantis_current_datetime(),
         ], ['id' => $hash_id ]);
      }

      wp_send_json_success(['message' => 'notification_mark_read', 'is_read' => $is_read ]);
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

      $is_read = $wpdb->get_results( "SELECT is_read FROM wp_watergo_notification WHERE id = $id_notification AND is_read = 0 ");
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
      $paged = $paged * $limit;

      $is_user_store = get_user_meta($user_id , 'user_store', true) != '' 
         ? (int) get_user_meta($user_id , 'user_store', true) 
         : null;

      global $wpdb;

      $get_store_id  = $wpdb->get_results("SELECT id FROM wp_watergo_store WHERE user_id = $user_id ");
      $store_id      = $get_store_id[0]->id;

      $condition  = "user_id = $user_id";
      $condition2 = " send_to = 'user' ";

      if( $is_user_store == 1 || $is_user_store == true ){
         $condition = "store_id = $store_id";
         $condition2 = " send_to = 'store' ";
      }

      $sql = "SELECT * FROM wp_watergo_notification 
         WHERE $condition AND $condition2
         ORDER BY 
            time_created DESC,
            is_read DESC
         LIMIT $paged, $limit
      ";
      $res = $wpdb->get_results( $sql );

      if( ! empty($res) ){
         wp_send_json_success(['message' => 'notification_found', 'data' => $res ]);
         wp_die();
      }

      wp_send_json_error(['message' => 'notification_not_found' ]);
      wp_die();
      
   }
}


function atlantis_notification(){
   if( isset( $_POST['action'] ) && $_POST['action'] == 'atlantis_notification' ){

      

   }
}

function atlantis_notification_count(){
   if( isset( $_POST['action'] ) && $_POST['action'] == 'atlantis_notification_count' ){
      
      $user_id = get_current_user_id();
      $is_user_store = get_user_meta($user_id , 'user_store', true) != '' 
         ? (int) get_user_meta($user_id , 'user_store', true) 
         : null;

      global $wpdb;
      $get_store_id  = $wpdb->get_results("SELECT id FROM wp_watergo_store WHERE user_id = $user_id ");
      $store_id      = $get_store_id[0]->id;
      // $store_id = func_get_store_id_from_current_user();
      
      $condition = "user_id = $user_id";
      $condition2 = "send_to = 'user'";

      if( $is_user_store == 1 || $is_user_store == true ){
         $condition = "store_id = $store_id";
         $condition2 = "send_to = 'store'";
      }

      $sql     = "SELECT COUNT(*) as count FROM wp_watergo_notification WHERE $condition AND is_read = 0 AND $condition2 ";
      // $sql     = "SELECT COUNT(*) as count FROM wp_watergo_notification WHERE ($condition1) AND is_read = 0 AND ($condition2)";

      $res     = $wpdb->get_results( $sql );

      if( $res[0]->count != null && $res[0]->count > 0 ){
         wp_send_json_success(['message' => 'notification_found', 'data' => $res[0]->count ]);
         wp_die();   
      }

      wp_send_json_error(['message' => 'notification_not_found', 'data' => 0, 'sql' => $sql ]);
      wp_die();
      
   }
}