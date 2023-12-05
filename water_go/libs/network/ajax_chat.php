<?php

add_action( 'wp_ajax_nopriv_atlantis_load_all_conversation', 'atlantis_load_all_conversation' );
add_action( 'wp_ajax_atlantis_load_all_conversation', 'atlantis_load_all_conversation' );

add_action( 'wp_ajax_nopriv_atlantis_send_message', 'atlantis_send_message' );
add_action( 'wp_ajax_atlantis_send_message', 'atlantis_send_message' );

add_action( 'wp_ajax_nopriv_atlantis_get_newest_messages', 'atlantis_get_newest_messages' );
add_action( 'wp_ajax_atlantis_get_newest_messages', 'atlantis_get_newest_messages' );

add_action( 'wp_ajax_nopriv_atlantis_count_messages', 'atlantis_count_messages' );
add_action( 'wp_ajax_atlantis_count_messages', 'atlantis_count_messages' );

add_action( 'wp_ajax_nopriv_atlantis_get_product_newest_and_store', 'atlantis_get_product_newest_and_store' );
add_action( 'wp_ajax_atlantis_get_product_newest_and_store', 'atlantis_get_product_newest_and_store' );

add_action( 'wp_ajax_nopriv_atlantis_messenger_test', 'atlantis_messenger_test' );
add_action( 'wp_ajax_atlantis_messenger_test', 'atlantis_messenger_test' );

add_action( 'wp_ajax_nopriv_atlantis_ping_user_to_get_last_message', 'atlantis_ping_user_to_get_last_message' );
add_action( 'wp_ajax_atlantis_ping_user_to_get_last_message', 'atlantis_ping_user_to_get_last_message' );

/**
 * @access USER FOR CHAT-INDEX PAGE
 */
function atlantis_ping_user_to_get_last_message(){
   if( isset( $_POST['action'] ) && $_POST['action'] == 'atlantis_ping_user_to_get_last_message' ){

      $list_conversation = isset($_POST['list_conversation']) ? $_POST['list_conversation'] : '';
      $list_conversation = json_decode( stripslashes( $list_conversation ) );

      if( ! empty( $list_conversation ) ){
         global $wpdb;

         foreach( $list_conversation as $kCons => $vl  ){
            $sql = "SELECT * FROM wp_watergo_messages
               WHERE conversation_id = $vl->conversation_id
               ORDER BY message_id DESC
               LIMIT 1
            ";
            $res = $wpdb->get_results( $sql );
            if( ! empty( $res )) {
               foreach( $res as $kM => $message ){
                  $list_conversation[$kCons]->message_id = $message->message_id;
                  $list_conversation[$kCons]->content    = $message->content;
                  $list_conversation[$kCons]->timestamp  = $message->timestamp;
               }
            }
         }
         wp_send_json_success(['message' => 'get_message_ok', 'data' => $list_conversation ]);
         wp_die();
      }
      wp_send_json_error(['message' => 'no_message_found']);
      wp_die();

   }
}

function atlantis_load_all_conversation(){
   if( isset($_POST['action']) && $_POST['action'] == 'atlantis_load_all_conversation' ){
      $user_id       = get_current_user_id();
      $is_user_store = get_user_meta($user_id , 'user_store', true);

      $flag_current_account = 'user';
      $sql = "";

      if( $is_user_store == 1 || $is_user_store == true ){
         $sql = "SELECT from_user_count_messages, to_user_count_messages, from_user, to_user, conversation_id_hash FROM wp_watergo_conversations
            WHERE to_user = $user_id
            AND conversation_hidden != 1
         ";
         $flag_current_account = 'store';
      }else{
         $sql = "SELECT from_user_count_messages, to_user_count_messages, from_user, to_user, conversation_id_hash FROM wp_watergo_conversations
            WHERE from_user = $user_id
            AND conversation_hidden != 1
         ";
         $flag_current_account = 'user';
      }

      global $wpdb;
      $res   = $wpdb->get_results($sql);

      if( empty( $res )){
         wp_send_json_error(['message' => 'conversation_not_found']); wp_die();
      }

      // GET LAST MESSAGE
      foreach( $res as $k => $vl ){

         // -> GET STORE USER WHEN CURRENT IS ACCOUNT USER
         if( $flag_current_account == 'user' ){
            $sql_get_store = "SELECT name, id FROM wp_watergo_store WHERE user_id = $vl->to_user ";
            $res_get_store = $wpdb->get_results($sql_get_store);
            $vl->chat_user_name    = $res_get_store[0]->name;
            $vl->chat_user_avatar  = func_atlantis_get_images( $res_get_store[0]->id, 'store', true);
            $vl->count_new_message = $vl->from_user_count_messages;
         }
         // -> GET USER WHEN CURRENT IS ACCOUNT STORE
         if( $flag_current_account == 'store' ){
            $user_name = get_user_meta( (int) $vl->from_user, 'first_name', true);
            if($user_name == null || $user_name == ''){
               $user       = get_user_by('id', (int) $vl->from_user);
               $user_name  = $user->data->display_name;
            }
            $vl->chat_user_name = $user_name;
            $vl->chat_user_avatar = func_atlantis_get_images( $vl->from_user, 'user_avatar', true);
            $vl->count_new_message = $vl->to_user_count_messages;
         }
         
         $sql_message = "SELECT * FROM wp_watergo_messages 
            WHERE conversation_hash_id = '$vl->conversation_id_hash'
            AND message_type = 'message'
            ORDER BY message_id DESC
            LIMIT 1
         ";

         $res_message = $wpdb->get_results( $sql_message);

         if( !empty( $res_message )){
            $vl->message      = $res_message[0]->content;
            $vl->timestamp    = $res_message[0]->timestamp;
         }else{
            $vl->message      = '';
            $vl->timestamp    = '';
         }
      }

      wp_send_json_success(['message'   => 'conversation_found', 'data' => $res]);
      wp_die();
   }
}

/**
 * @access COUNT TOAL MESSAGE FOR EVERY SCREEN
 */
function atlantis_count_messages(){
   if( isset( $_POST['action'] ) && $_POST['action'] == 'atlantis_count_messages' ){

      if( ! is_user_logged_in() ){
         wp_send_json_error(['message' => 'message_count_found', 'data' => 0 ]);
         wp_die();
      }

      $user_id = get_current_user_id();
      $is_user_store = get_user_meta($user_id, 'user_store', true);

      $sql = "";

      if( $is_user_store == 1 || $is_user_store == true ){
         $sql = "SELECT SUM(to_user_count_messages) as total_messages FROM wp_watergo_conversations WHERE to_user = $user_id";
      }else{
         $sql = "SELECT SUM(from_user_count_messages) as total_messages FROM wp_watergo_conversations WHERE from_user = $user_id";
      }

      global $wpdb;
      $res = $wpdb->get_results($sql);

      if( !empty( $res )){

         wp_send_json_success(['message' => 'message_count_found', 'data' => $res[0]->total_messages ]);
         wp_die();
      }

      wp_send_json_success(['message' => 'message_count_found', 'data' => 0 ]);
      wp_die();



   }
}


function atlantis_send_message(){
   if( isset( $_POST['action'] ) && $_POST['action'] == 'atlantis_send_message' ){

      $conversation_id  = isset($_POST['conversation_id']) ? $_POST['conversation_id'] : '';
      $chat_content     = isset($_POST['chat_content']) ? $_POST['chat_content'] : '';

      if($chat_content == '' || $conversation_id == '' ){
         wp_send_json_error(['message' => 'messenger_not_found' ]);
         wp_die();
      }

      $user_id       = get_current_user_id();
      $is_user_store = get_user_meta($user_id , 'user_store', true);

      global $wpdb;

      $timestamp  = atlantis_current_datetime();

      $chat_content        = stripcslashes(nl2br($chat_content));

      $args = [
         'conversation_hash_id'   => $conversation_id,
         'user_id'                => $user_id,
         'content'                => $chat_content,
         'timestamp'              => $timestamp,
         'is_read'                => 0,
         'message_type'           => 'message'
      ];

      $send_message     = $wpdb->insert('wp_watergo_messages', $args );
      $sql_get_count    = "SELECT * FROM wp_watergo_conversations WHERE conversation_id_hash = '$conversation_id'";
      $res_get_count    = $wpdb->get_results($sql_get_count);
      $count_messages   = 0;

      // INCREMENT COUNT MESSAGE
      // WHEN STORE LOGIN
      if( $is_user_store == 1 || $is_user_store == true ){
         $count_messages      = $res_get_count[0]->from_user_count_messages;
         $count_messages      = $count_messages + 1;
         $wpdb->update( 'wp_watergo_conversations', [
            'from_user_count_messages'   => $count_messages++
         ], ['conversation_id_hash'    => $conversation_id]);
      }else{
      // WHEN USER LOGIN
         $count_messages      = $res_get_count[0]->to_user_count_messages;
         $count_messages      = $count_messages + 1;
         $wpdb->update( 'wp_watergo_conversations', [
            'to_user_count_messages' => $count_messages++
         ], ['conversation_id_hash'    => $conversation_id]);
      }
      
      if( $send_message ){
         wp_send_json_success(['message' => 'messenge_send_ok', 
            'message_id' => (int) $wpdb->insert_id,
            'timestamp'  => atlantis_current_datetime()
         ]);
         wp_die();
      }

      wp_send_json_error(['message' => 'messenger_not_found 3' ]);
      wp_die();

   }
}

add_action( 'wp_ajax_atlantis_message_save_pin_order', 'atlantis_message_save_pin_order' );
function atlantis_message_save_pin_order(){
   if( isset($_POST['action']) && $_POST['action'] == 'atlantis_message_save_pin_order'){
      if( !is_user_logged_in()){
         wp_send_json_error(['message' => 'messenger_not_found' ]);
         wp_die();
      }

      $order_id = isset($_POST['order_id']) ? $_POST['order_id'] : '';
      $order_total_price = isset($_POST['order_total_price']) ? $_POST['order_total_price'] : '';
      $order_number_id = isset($_POST['order_number_id']) ? $_POST['order_number_id'] : '';
      $order_price_discount = isset($_POST['order_price_discount']) ? $_POST['order_price_discount'] : '';

      $conversation_id  = isset($_POST['conversation_id']) ? $_POST['conversation_id'] : '';
      $timestamp        = atlantis_current_datetime();
      $user_id          = get_current_user_id();

      global $wpdb;

      $message_id = 0;
      
      $wpdb->insert('wp_watergo_messages', [
         'conversation_hash_id'  => $conversation_id,
         'user_id'               => $user_id,
         'timestamp'             => $timestamp,
         'is_read'               => 0,
         'message_type'          => 'pin_order',
         'order_id'              => $order_id,
         'order_total_price'     => $order_total_price,
         'order_number_id'       => $order_number_id,
         'order_price_discount'  => $order_price_discount,
      ]);

      $message_id = $wpdb->insert_id;

      $wpdb->insert('wp_watergo_chat_pin', [
         'conversation_hash_id'  => $conversation_id,
         'order_id'              => $order_id
      ]);

      wp_send_json_success(['message' => 'save_pin_order_ok', 'data' => (int) $message_id ]);
      wp_die();

   }
}


function atlantis_get_newest_messages(){
   if( isset( $_POST['action'] ) && $_POST['action'] == 'atlantis_get_newest_messages' ){

      $conversation_id        = isset($_POST['conversation_id']) ? $_POST['conversation_id'] : 0;
      $list_id_messenger      = isset($_POST['list_id_messenger']) ? $_POST['list_id_messenger'] : 0;

      if($conversation_id == '' || $list_id_messenger == ''){
         wp_send_json_error(['message' => 'newest_messenger_not_found' ]);
         wp_die();
      }

      // convert json to array php
      $list_id_messenger = json_decode( stripslashes( $list_id_messenger ) );
      // convert array php to string
      $list_id_messenger = implode(',', $list_id_messenger);

      if($list_id_messenger == '' ){
         $list_id_messenger = 0;
      }


      global $wpdb;
      $sql = "SELECT * FROM wp_watergo_messages 
         WHERE message_id NOT IN ($list_id_messenger) AND conversation_id = $conversation_id
      ";


      $res = $wpdb->get_results($sql);
      // wp_send_json_success(['message' => 'ok', 'test' => $res ]);
      if( empty( $res ) ){
         wp_send_json_error(['message' => 'newest_messenger_not_found', 'list_id' => $list_id_messenger ]);
         wp_die();
      }
      wp_send_json_success(['message' => 'newest_messenger_ok', 'data' => $res]);
      wp_die();

   }
}

function atlantis_get_product_newest_and_store(){
   if( isset( $_POST['action'] ) && $_POST['action'] == 'atlantis_get_product_newest_and_store' ){

      $store_id = isset($_POST['store_id']) ? $_POST['store_id'] : 0;

      if($store_id == 0 ){
         wp_send_json_error(['message' => 'product_and_store_not_found' ]);
         wp_die();
      }

      $sql = "SELECT 
         wp_watergo_store.name as store_name,
         wp_watergo_products.name as product_name,
         wp_watergo_products.quantity,
         wp_watergo_products.price,
         wp_watergo_products.weight,
         wp_watergo_products.length_width,
         wp_watergo_products.product_type,
         
         FROM wp_watergo_store

         LEFT JOIN wp_watergo_products
         ON wp_watergo_products.store_id = wp_watergo_store.id

         WHERE wp_watergo_store.id = $store_id 
         ORDER BY wp_watergo_products.id DESC
         LIMIT 1
      ";

      global $wpdb;
      $res = $wpdb->get_results($sql);
      if( empty($res )){
         wp_send_json_error(['message' => 'product_and_store_not_found' ]);
         wp_die();
      }

      wp_send_json_success(['message' => 'product_and_store_found', 'data' => $res[0] ]);
      wp_die();


   }

}

add_action( 'wp_ajax_nopriv_atlantis_get_account_store', 'atlantis_get_account_store' );
add_action( 'wp_ajax_atlantis_get_account_store', 'atlantis_get_account_store' );

function atlantis_get_account_store(){
   if( isset($_POST['action']) && $_POST['action'] == 'atlantis_get_account_store' ){
      $user_id       = isset($_POST['user_id']) ? $_POST['user_id'] : 0;
      $store_avatar  = func_atlantis_get_images( $user_id, 'store', true);
      $store_name    = '';
      global $wpdb;
      $sql = "SELECT name FROM wp_watergo_store WHERE user_id = $user_id LIMIT 1";
      $res = $wpdb->get_results( $sql);
      $store_name = $res[0]->name;
      wp_send_json_success(['message' => 'get_account_store_ok', 'data' => [
         'avatar' => $store_avatar['url'],
         'name'   => $store_name,
      ]]);
      wp_die();
   }
}

add_action( 'wp_ajax_nopriv_atlantis_get_account_user', 'atlantis_get_account_user' );
add_action( 'wp_ajax_atlantis_get_account_user', 'atlantis_get_account_user' );

function atlantis_get_account_user(){
   if( isset($_POST['action']) && $_POST['action'] == 'atlantis_get_account_user' ){

      $user_id = isset($_POST['user_id']) ? $_POST['user_id'] : 0;
      $user_avatar  = func_atlantis_get_images( $user_id, 'user_avatar', true);
      $user_name    = '';
      global $wpdb;
      $user_name = get_user_meta($user_id, 'first_name', true);
      if($user_name == null || $user_name == ''){
         $user       = get_user_by('id', $user_id);
         $user_name  = $user->data->display_name;
      }

      wp_send_json_success(['message' => 'get_account_user_ok', 'data' => [
         'avatar' => $user_avatar['url'],
         'name'   => $user_name,
      ]]);
      wp_die();
   }
}

add_action( 'wp_ajax_nopriv_atlantis_create_or_get_conversation', 'atlantis_create_or_get_conversation' );
add_action( 'wp_ajax_atlantis_create_or_get_conversation', 'atlantis_create_or_get_conversation' );


function atlantis_create_or_get_conversation(){
   if( isset($_POST['action']) && $_POST['action'] == 'atlantis_create_or_get_conversation' ){

      $from_user = isset($_POST['from_user']) ? $_POST['from_user'] : 0;
      $to_user    = isset($_POST['to_user']) ? $_POST['to_user'] : 0;


      if( $from_user == 0){
         $from_user  = get_current_user_id();
      }

      global $wpdb;
      $sql_check_conversation = "SELECT * FROM wp_watergo_conversations WHERE from_user = $from_user AND to_user = $to_user LIMIT 1";
      $res_check_conversation = $wpdb->get_results($sql_check_conversation);

      if( !empty( $res_check_conversation ) ){
         wp_send_json_success(['message' => 'get_conversation_ok', 'data' => $res_check_conversation[0]->conversation_id_hash ]);
         wp_die();
      }

      $conversation_id_hash   = bin2hex(random_bytes(32));
      $created_at             = atlantis_current_datetime();

      $inserted = $wpdb->insert( 'wp_watergo_conversations', [
         'conversation_id_hash'     => $conversation_id_hash,
         'from_user'                => $from_user,
         'to_user'                  => $to_user,
         'created_at'               => $created_at,
         'from_user_count_messages' => 0,
         'to_user_count_messages'   => 0

      ]);

      if( $inserted ){
         wp_send_json_success(['message' => 'get_conversation_ok', 'data' => $conversation_id_hash ]);
         wp_die();
      }

      wp_send_json_error(['message' => 'conversation_not_found']);
      wp_die();

   }
}


add_action( 'wp_ajax_nopriv_atlantis_get_conversation', 'atlantis_get_conversation' );
add_action( 'wp_ajax_atlantis_get_conversation', 'atlantis_get_conversation' );
function atlantis_get_conversation(){
   if( isset($_POST['action']) && $_POST['action'] == 'atlantis_get_conversation'){
      $conversation_id = isset($_POST['conversation_id']) ? $_POST['conversation_id'] : null;

      if( $conversation_id == null || is_user_logged_in() == false ){
         wp_send_json_error(['message' => 'conversation_not_found']);
         wp_die();
      }

      global $wpdb;

      $sql = "SELECT * FROM wp_watergo_conversations WHERE conversation_id_hash = '$conversation_id' AND conversation_hidden != 1";
      $res = $wpdb->get_results($sql);

      if( empty( $res )){
         wp_send_json_error(['message' => 'conversation_not_found']);
         wp_die();
      }

      $res = $res[0];
      $user_id          = get_current_user_id();

      $from_user        = (int) $res->from_user;
      $to_user          = (int) $res->to_user;

      $account_user  = [];
      $account_store = [];


      $sql_store                  = "SELECT name, id FROM wp_watergo_store WHERE user_id = $to_user ";
      $res_store                  = $wpdb->get_results($sql_store);
      $account_store['avatar']   = func_atlantis_get_images( $res_store[0]->id , 'store', true);
      $account_store['name']     = $res_store[0]->name;

      $account_user['avatar']    = func_atlantis_get_images( $from_user, 'user_avatar', true);
      $user_name = get_user_meta($from_user, 'first_name', true);
      if($user_name == null || $user_name == ''){
         $user       = get_user_by('id', $from_user);
         $user_name  = $user->data->display_name;
      }
      $account_user['name']   = $user_name;
      $flag_account = 'user';

      if( $user_id == $to_user ){
         $res->current_user_avatar = $account_store['avatar'];
         $res->current_user_name   = $account_store['name'];
         $flag_account = 'store';
      }
      if( $user_id == $from_user ){
         $res->current_user_avatar  = $account_user['avatar'];
         $res->current_user_name    = $account_user['name'];
         $flag_account = 'user';
      }

      if( $flag_account == 'store' ){
         $res->user_to_chat_avatar = $account_user['avatar'];
         $res->user_to_chat_name   = $account_user['name'];
      }else if ( $flag_account == 'user' ){
         $res->user_to_chat_avatar = $account_store['avatar'];
         $res->user_to_chat_name   = $account_store['name'];
      }

      wp_send_json_success(['message' => 'conversation_found', 'data' => $res ]);
      wp_die();
   }
}


add_action( 'wp_ajax_nopriv_atlantis_get_messeges', 'atlantis_get_messeges' );
add_action( 'wp_ajax_atlantis_get_messeges', 'atlantis_get_messeges' );
function atlantis_get_messeges(){
   if( isset($_POST['action']) && $_POST['action'] == 'atlantis_get_messeges' ){

      $limit            = isset($_POST['limit']) ? $_POST['limit'] : 25;
      $conversation_id  = isset($_POST['conversation_id']) ? $_POST['conversation_id'] : '';
      $get_newest       = isset($_POST['get_newest']) ? $_POST['get_newest'] : 0;
      $last_message_id  = isset($_POST['last_message_id']) ? $_POST['last_message_id'] : 0;

      if( $conversation_id == '' ){
         wp_send_json_error([ 'message' => 'message_not_found' ] );
         wp_die();
      }
      
      global $wpdb;

      if( $get_newest == 0 ){
         $sql = "SELECT * FROM wp_watergo_messages 
            WHERE conversation_hash_id = '$conversation_id'
            ORDER BY message_id DESC
            LIMIT 0, $limit
         ";
      }else if( $get_newest == 1 && ( $last_message_id > 0 && $last_message_id != null )  ){
         $sql = "SELECT * FROM wp_watergo_messages 
            WHERE conversation_hash_id = '$conversation_id'
            AND message_id > $last_message_id
            ORDER BY message_id DESC
         ";
      }else{
         wp_send_json_error([ 'message' => 'message_not_found' ] );
         wp_die();
      }
      $res = $wpdb->get_results($sql);

      if( empty($res )){
         wp_send_json_error([ 'message' => 'message_not_found' ] );
         wp_die();
      }

      wp_send_json_success([ 'message' => 'message_found', 'data' => $res ] );
      wp_die();

   }
}


add_action( 'wp_ajax_nopriv_atlantis_read_all_messages', 'atlantis_read_all_messages' );
add_action( 'wp_ajax_atlantis_read_all_messages', 'atlantis_read_all_messages' );
function atlantis_read_all_messages(){
   if( isset($_POST['action']) && $_POST['action'] == 'atlantis_read_all_messages' ){
      $conversation_id = isset($_POST['conversation_id']) ? $_POST['conversation_id'] : '';

      if( $conversation_id == '' ){
         wp_send_json_error(['message' => 'messages_not_found' ]);
         wp_die();
      }
      $user_id          = get_current_user_id();
      $is_user_store    = get_user_meta($user_id , 'user_store', true);

      global $wpdb;
      
      if($is_user_store == 1 || $is_user_store == true ){
         $updated = $wpdb->update('wp_watergo_conversations', [ 'to_user_count_messages' => 0], ['conversation_id_hash' => $conversation_id ]);
      }else{
         $updated = $wpdb->update('wp_watergo_conversations', [ 'from_user_count_messages' => 0], ['conversation_id_hash' => $conversation_id ]);
      }

      if( ! $updated ){
         wp_send_json_error(['message' => 'messages_not_found' ]);
         wp_die();
      }
      wp_send_json_success(['message' => 'messages_found' ]);
      wp_die();

   }  
}

add_action( 'wp_ajax_nopriv_atlantis_count_messeage_everytime', 'atlantis_count_messeage_everytime' );
add_action( 'wp_ajax_atlantis_count_messeage_everytime', 'atlantis_count_messeage_everytime' );

function atlantis_count_messeage_everytime(){
   if( isset($_POST['action']) && $_POST['action'] == 'atlantis_count_messeage_everytime' ){

      if( is_user_logged_in() == false ){
         wp_send_json_error(['message' => 'count_messages_not_found' ]);
         wp_die();
      }

      $user_id          = get_current_user_id();
      $is_user_store    = get_user_meta($user_id , 'user_store', true);

      $sql = "";
      global $wpdb;

      if($is_user_store == 1 || $is_user_store == true ){
         $sql = "SELECT SUM(to_user_count_messages) as count_message 
            FROM wp_watergo_conversations 
            WHERE to_user = $user_id
         ";
      }else{
         $sql = "SELECT SUM(from_user_count_messages) as count_message 
            FROM wp_watergo_conversations 
            WHERE from_user = $user_id
         ";
      }

      $res = $wpdb->get_results( $sql );
      $count_message = 0;
      if( $res[0]->count_message != "" || $res[0]->count_message != null || $res[0]->count_message != 0 ){
         $count_message = (int) $res[0]->count_message;
      }
      wp_send_json_success(['message' => 'count_messages_ok', 'data' => $count_message ]);
      wp_die();

   }
}


add_action( 'wp_ajax_nopriv_atlantis_count_messeage_from_conversation_id', 'atlantis_count_messeage_from_conversation_id' );
add_action( 'wp_ajax_atlantis_count_messeage_from_conversation_id', 'atlantis_count_messeage_from_conversation_id' );
function atlantis_count_messeage_from_conversation_id(){
   if( isset($_POST['action']) && $_POST['action'] == 'atlantis_count_messeage_from_conversation_id'){
      $conversation_id  = isset($_POST['conversation_id'])  ? $_POST['conversation_id'] : '';
      $user_id          = get_current_user_id();
      $is_user_store    = get_user_meta($user_id , 'user_store', true);

      global $wpdb;
      if( $is_user_store == 1 || $is_user_store == true ){
         $sql = "SELECT * FROM 
            wp_watergo_conversations 

         ";
      }

      $res = $wpdb->get_results( $sql);

      

      wp_send_json_success(['message' => 'count_new_messages']);
      wp_die();

   
      
   }
}


add_action( 'wp_ajax_nopriv_atlantis_get_message_realtime_per_second', 'atlantis_get_message_realtime_per_second' );
add_action( 'wp_ajax_atlantis_get_message_realtime_per_second', 'atlantis_get_message_realtime_per_second' );
function atlantis_get_message_realtime_per_second(){
   if( isset($_POST['action']) && $_POST['action'] == 'atlantis_get_message_realtime_per_second'){

      $placeholders     = isset( $_POST['placeholders'])    ? $_POST['placeholders'] : 0;
      $conversation_id  = isset( $_POST['conversation_id']) ? $_POST['conversation_id'] : 0;
      $paged            = isset( $_POST['paged'])            ? $_POST['paged'] : 0;

      global $wpdb;

      $wheres = [];
      if( $placeholders != 0 ){
         $placeholders = json_decode( stripslashes($placeholders), true);
         if( ! empty($placeholders) ){
            foreach( $placeholders as $ids ){
               $wheres[] = (int) $ids;
            }
         }
         $placeholders = implode(',', array_fill(0, count($wheres), '%d'));
      }


      $sql = "SELECT * FROM wp_watergo_messages 
         WHERE conversation_id_hash = '$conversation_id' 
         AND message_id NOT IN ($placeholders)
         ORDER BY timestamp DESC
         LIMIT $paged , 20";
      
      $prepare  = $wpdb->prepare( $sql, $wheres );
      $res      = $wpdb->get_results( $prepare );

      if( empty( $res )){
         wp_send_json_error(['message' => 'message_not_found' ]);
         wp_die();
      }

      wp_send_json_success(['message' => 'message_found', 'data' => $res ]);
      wp_die();

   }
}


/**
 * @access UPGRADE FUNCTION GET CONVERSATION * create when it not exists
 * @chat version 2
 */

add_action( 'wp_ajax_atlantis_create_conversation_or_get_it', 'atlantis_create_conversation_or_get_it' );
function atlantis_create_conversation_or_get_it(){
   if( isset($_POST['action']) && $_POST['action'] == 'atlantis_create_conversation_or_get_it' ){

      $order_id         = isset($_POST['order_id']) ? $_POST['order_id'] : null;
      $conversation_id  = isset($_POST['conversation_id']) ? $_POST['conversation_id'] : null; // check by hash_id

      // store
      $to_user          = 0;

      $store_id = isset($_POST['store_id']) ? $_POST['store_id'] : null;
      $user_id  = isset($_POST['user_id']) ? $_POST['user_id'] : null;

      global $wpdb;
      $sql_get_user_id_from_store_id = "SELECT user_id FROM wp_watergo_store WHERE id = $store_id LIMIT 1";
      $res_get_user_id_from_store_id = $wpdb->get_results($sql_get_user_id_from_store_id);
      $to_user                       = $res_get_user_id_from_store_id[0]->user_id;

      // GET CONVERSATION BY ORDER ID
      $sql_get_conversation_by_user_and_store = "SELECT * FROM wp_watergo_conversations WHERE to_user = $to_user AND from_user = $user_id LIMIT 1";
      $conversation_id = $wpdb->get_results( $sql_get_conversation_by_user_and_store);

      if( empty( $conversation_id ) ){
         $converation_id_hash = bin2hex(random_bytes(32));
         $create_at           = atlantis_current_datetime();
         $wpdb->insert('wp_watergo_conversations', [
            // user_id
            'from_user'             => $user_id,
            // user_id from store id
            'to_user'               => $to_user,
            'conversation_id_hash'  => $converation_id_hash,
            'created_at'            => $create_at,
         ]);

         wp_send_json_success(['message' => 'conversation_found', 'data' => $converation_id_hash ]);
         wp_die();
      }

      wp_send_json_success(['message' => 'conversation_found', 'data' => $conversation_id[0]->conversation_id_hash ]);
      wp_die();


   }
}


add_action( 'wp_ajax_atlantis_get_chat_order_detail', 'atlantis_get_chat_order_detail' );
function atlantis_get_chat_order_detail(){
   if( isset($_POST['action']) && $_POST['action'] == 'atlantis_get_chat_order_detail' ){
      $order_id = isset($_POST['order_id']) ? $_POST['order_id'] : 0;

      if($order_id == 0 ){
         wp_send_json_error(['message' => 'order_not_found']);
         wp_die();
      }

      global $wpdb;
      $sql = "SELECT 
            wp_watergo_order_group.order_group_product_quantity_count,
            wp_watergo_order_group.order_group_product_price,
            wp_watergo_order_group.order_group_product_discount_percent,
            wp_watergo_order.order_number,
            wp_watergo_order.order_number_repeat,
            wp_watergo_order.order_id

         FROM wp_watergo_order_group

         LEFT JOIN wp_watergo_order
         ON wp_watergo_order.hash_id = wp_watergo_order_group.hash_id
         WHERE wp_watergo_order.order_id = $order_id
      ";

      $res = $wpdb->get_results( $sql);
      if( empty($res ) ){
         wp_send_json_error(['message' => 'order_not_found']);
         wp_die();
      }

      $order = null;
      $order_total_price = 0;
      foreach( $res as $k => $vl ){
         $order_number  = $vl->order_number;
         $number_repeat = $vl->order_number_repeat;

         if( $number_repeat != 0 && $number_repeat != null && $number_repeat != ''){
            $order_number = str_pad( $order_number, 4, "0", STR_PAD_LEFT) . '-' . $number_repeat;
         }else{
            $order_number = str_pad( $order_number, 4, "0", STR_PAD_LEFT);
         }
         
         $price            = $vl->order_group_product_price;
         $quantity         = $vl->order_group_product_quantity_count;
         $discount_percent = $vl->order_group_product_discount_percent;
         $order_total_price += ($price - ( $price * ($discount_percent / 100 ) ) ) * $quantity;

         $order['order_number_id']    = $order_number;
         $order['order_id']           = (int) $vl->order_id;
      }
      $order['order_total_price']  = $order_total_price;

      wp_send_json_success(['message' => 'order_found', 'data' => $order]);
      wp_die();

   }
}

/**
 * @access IF PIN NOT SAVE -> JUST SAVE IT
 */

add_action( 'wp_ajax_atlantis_check_chat_pin', 'atlantis_check_chat_pin' );
function atlantis_check_chat_pin(){
   if( isset($_POST['action']) && $_POST['action'] == 'atlantis_check_chat_pin'){
      $id               = isset($_POST['id']) ? $_POST['id'] : null;
      $conversation_id  = isset($_POST['conversation_id']) ? $_POST['conversation_id'] : null; // HASH_ID
      $kind             = isset($_POST['kind']) ? $_POST['kind'] : null;

      if( 
         $id == null && $conversation_id == null && in_array( $kind, ['product', 'order'] )
      ){
         wp_send_json_error(['message' => 'pin_not_found' ]);
         wp_die();
      }

      global $wpdb;
      if( $kind == 'product'){
         $sql = "SELECT * FROM wp_watergo_chat_pin WHERE product_id = $id AND conversation_hash_id = '$conversation_id' LIMIT 1";
         $res = $wpdb->get_results($sql);
         if( ! empty( $res ) ){
            wp_send_json_success(['message' => 'pin_found']);
            wp_die();
         }else{
            wp_send_json_error(['message' => 'pin_not_found']);
            wp_die();
         }
      }
      if( $kind == 'order'){
         $sql = "SELECT * FROM wp_watergo_chat_pin WHERE order_id = $id AND conversation_hash_id = '$conversation_id' LIMIT 1";
         $res = $wpdb->get_results($sql);
         if( ! empty( $res ) ){
            wp_send_json_success(['message' => 'pin_found']);
            wp_die();
         }else{
            wp_send_json_error(['message' => 'pin_not_found']);
            wp_die();
         }
      }

      wp_send_json_error(['message' => 'pin_not_found']);
      wp_die();

      

   }
}