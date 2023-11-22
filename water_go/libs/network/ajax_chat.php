<?php

add_action( 'wp_ajax_nopriv_atlantis_load_all_conversation', 'atlantis_load_all_conversation' );
add_action( 'wp_ajax_atlantis_load_all_conversation', 'atlantis_load_all_conversation' );

add_action( 'wp_ajax_nopriv_atlantis_get_messages', 'atlantis_get_messages' );
add_action( 'wp_ajax_atlantis_get_messages', 'atlantis_get_messages' );

add_action( 'wp_ajax_nopriv_atlantis_send_message', 'atlantis_send_message' );
add_action( 'wp_ajax_atlantis_send_message', 'atlantis_send_message' );

add_action( 'wp_ajax_nopriv_atlantis_get_newest_messages', 'atlantis_get_newest_messages' );
add_action( 'wp_ajax_atlantis_get_newest_messages', 'atlantis_get_newest_messages' );

add_action( 'wp_ajax_nopriv_atlantis_is_conversation_created_or_create', 'atlantis_is_conversation_created_or_create' );
add_action( 'wp_ajax_atlantis_is_conversation_created_or_create', 'atlantis_is_conversation_created_or_create' );

add_action( 'wp_ajax_nopriv_atlantis_count_messages', 'atlantis_count_messages' );
add_action( 'wp_ajax_atlantis_count_messages', 'atlantis_count_messages' );

add_action( 'wp_ajax_nopriv_atlantis_get_product_newest_and_store', 'atlantis_get_product_newest_and_store' );
add_action( 'wp_ajax_atlantis_get_product_newest_and_store', 'atlantis_get_product_newest_and_store' );

add_action( 'wp_ajax_nopriv_atlantis_load_all_conversations_id', 'atlantis_load_all_conversations_id' );
add_action( 'wp_ajax_atlantis_load_all_conversations_id', 'atlantis_load_all_conversations_id' );

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

      $placeholders = isset($_POST['placeholders']) ? $_POST['placeholders'] : 0;

      $sql_conversation = "SELECT 
         wp_watergo_conversations.*,
         wp_watergo_messages.content as message,
         wp_watergo_messages.timestamp

         FROM wp_watergo_conversations
         JOIN wp_watergo_messages
         ON wp_watergo_messages.conversation_id_hash = wp_watergo_conversations.conversation_id_hash 
      ";

      if( $placeholders != 0 ){
         $placeholders = json_decode($placeholders);
         $wheres = [];
         if( ! empty($placeholders) ){
            foreach( $placeholders as $ids ){
               $wheres[] = $ids;
            }
         }
         $placeholders = implode(',', array_fill(0, count($wheres), '%d'));
      }


      $user_id       = get_current_user_id();
      $is_user_store = get_user_meta($user_id , 'user_store', true);
      $where_app     = isset($_POST['where_app']) ? $_POST['where_app'] : 0;

      // if( $where_app == 'chat_to_store'){
      //    $sql = "SELECT from_user_count_messages as count_new_messages 
      //       FROM wp_watergo_conversations 
      //       WHERE conversation_id_hash = '$conversation_id'
      //    ";
      // }

      // if( $where_app == 'chat_to_user'){
      //    $sql_get_ = "SELECT to_user_count_messages as count_new_messages 
      //       FROM wp_watergo_conversations 
      //       WHERE conversation_id_hash = '$conversation_id'
      //    ";
      // }

      // $res = $wpdb->get_results( $sql);

      // if( $res[0]->count_new_messages != null || $res[0]->count_new_messages != '' && $res[0]->count_new_messages != 0){
         
      //    $sql_new_message = "SELECT content as message, timestamp FROM wp_watergo_messages WHERE conversation_id_hash = '$conversation_id' ORDER BY timestamp DESC LIMIT 1 ";
      //    $res_new_message = $wpdb->get_results( $sql_new_message );

      //    wp_send_json_success(['message' => 'count_new_messages', 
      //       'data'    => [
      //          'count'     => (int) $res[0]->count_new_messages,
      //          'message'   => $res_new_message[0]->message,
      //          'timestamp' => $res_new_message[0]->timestamp
      //       ],
      //    ]);
      //    wp_die();
      // }
      
      // WHEN STORE LOGIN
      if( $is_user_store == 1 || $is_user_store == true ){
         $where_app         = 'chat_to_user';
         $sql_conversation .= " WHERE to_user = $user_id 
            AND wp_watergo_conversations.conversation_id NOT IN ($placeholders)
            ORDER BY wp_watergo_messages.timestamp DESC
         ";
      }else{
      // WHEN USER LOGIN
         $where_app         = 'chat_to_store';
         $sql_conversation .= " WHERE from_user = $user_id 
            AND wp_watergo_conversations.conversation_id NOT IN ($placeholders)
            ORDER BY wp_watergo_messages.timestamp DESC
         ";
      }

      global $wpdb;
      // $res_cons = $wpdb->get_results($sql_conversation);
      $prepare    = $wpdb->prepare($sql_conversation, $wheres);
      $res_cons   = $wpdb->get_results($prepare);


      if( empty( $res_cons )){
         wp_send_json_error(['message' => 'conversation_not_found']);
         wp_die();
      }

      // VL->STORE_ID IS user-id
      foreach( $res_cons as $k => $vl ){

         if( $where_app == 'chat_to_store' ){
            $sql_name = "SELECT name, id FROM wp_watergo_store WHERE user_id = $vl->to_user ";
            $res = $wpdb->get_results($sql_name);
            $vl->name   = $res[0]->name;
            $vl->avatar = func_atlantis_get_images( $res[0]->id, 'store', true);
            $vl->count_new_messages = $vl->from_user_count_messages;
         }

         if( $where_app == 'chat_to_user' ){
            $vl->avatar = func_atlantis_get_images( $vl->from_user, 'user_avatar', true);
            $user_name = get_user_meta($vl->from_user, 'first_name', true);
            if($user_name == null || $user_name == ''){
               $user       = get_user_by('id', $user_id);
               $user_name  = $user->data->display_name;
            }
            $vl->name = $user_name;
            $vl->count_new_messages = $vl->to_user_count_messages;
         }
      }


      wp_send_json_success([
         'message'   => 'conversation_found',
         'data'      => $res_cons,
         'where_app' => $where_app,
      ]);
      wp_die();



   }
}

function atlantis_count_messages(){
   if( isset( $_POST['action'] ) && $_POST['action'] == 'atlantis_count_messages' ){
      if(is_user_logged_in() == true ){
         $user_id = get_current_user_id();
         $user = get_user_by('id', $user_id);
         $prefix_user = 'user_' . $user->data->ID;
      }else{
         wp_send_json_error(['message' => 'no_login_invalid' ]);
         wp_die();
      }


      $sql = "SELECT COUNT(*) as total_messages 
         FROM wp_watergo_messages 
         LEFT JOIN wp_watergo_conversations
         ON wp_watergo_conversations.conversation_id = wp_watergo_messages.conversation_id
         WHERE wp_watergo_messages.user_id = $user_id";

      global $wpdb;
      $res = $wpdb->get_results($sql);
      if( $res[0]->total_messages == 0 ){
         wp_send_json_error(['message' => 'message_count_not_found' ]);
         wp_die();
      }
      wp_send_json_success(['message' => 'message_count_found', 'data' => $res[0]->total_messages ]);
      wp_die();

   }
}


function atlantis_get_messages(){
   if( isset( $_POST['action'] ) && $_POST['action'] == 'atlantis_get_messages' ){

      // USE conversation_id
      $conversation_id  = isset($_POST['conversation_id']) ? $_POST['conversation_id'] : 0;
      $paged   = isset($_POST['paged']) ? $_POST['paged'] : 0;
      $id_already_exists   = isset($_POST['id_already_exists']) ? $_POST['id_already_exists'] : 0;

      if( $conversation_id == 0 ){
         wp_send_json_error(['message' => 'message_not_found 1' ]);
         wp_die();
      }

      $id_already_exists = json_decode( $id_already_exists );
      $placeholders = 0;

      $wheres = [];

      if( is_array($id_already_exists) && ! empty($id_already_exists) ){
         foreach( $id_already_exists as $ids ){
            $wheres[] = $ids;
         }
         $placeholders = implode(',', $wheres);
      }

      $sql = "SELECT 
         wp_watergo_messages.conversation_id,
         wp_watergo_messages.message_id,  
         wp_watergo_messages.content,
         wp_watergo_messages.user_id,
         wp_watergo_messages.timestamp,
         wp_watergo_messages.user_role
         
      FROM wp_watergo_conversations

      LEFT JOIN wp_watergo_messages
      ON wp_watergo_messages.conversation_id = wp_watergo_conversations.conversation_id
      
      WHERE wp_watergo_conversations.conversation_id = $conversation_id

      ORDER BY wp_watergo_messages.message_id DESC
      LIMIT 20
      ";

      global $wpdb;
      $res = $wpdb->get_results($sql);

      if( empty( $res ) ){
         wp_send_json_error(['message' => 'message_not_found 2' ]);
         wp_die();
      }

      // USING LEFT JOIN - REMOVE EFFECT LEFT JOIN
      if( $res[0]->conversation_id == null ){
         wp_send_json_error(['message' => 'message_not_found 3' ]);
         wp_die();
      }

      wp_send_json_success(['message' => 'message_found', 'data' => $res ]);
      wp_die();

   }
}


function atlantis_send_message(){
   if( isset( $_POST['action'] ) && $_POST['action'] == 'atlantis_send_message' ){

      $conversation_id  = isset($_POST['conversation_id']) ? $_POST['conversation_id'] : '';
      $chat_content     = isset($_POST['chat_content']) ? $_POST['chat_content'] : '';
      $where_app        = isset($_POST['where_app']) ? $_POST['where_app'] : '';

      if($chat_content == '' || $conversation_id == '' || $where_app == '' ){
         wp_send_json_error(['message' => 'messenger_not_found 1' ]);
         wp_die();
      }

      $user_id       = get_current_user_id();
      $is_user_store = get_user_meta($user_id , 'user_store', true);

      global $wpdb;

      $timestamp  = atlantis_current_datetime();

      $product_id          = isset($_POST['product_id']) ? $_POST['product_id'] : '';
      $product_name        = isset($_POST['product_name']) ? $_POST['product_name'] : '';
      $product_name_second = isset($_POST['product_name_second']) ? $_POST['product_name_second'] : '';
      $product_price       = isset($_POST['product_price']) ? $_POST['product_price'] : '';
      $product_price_discount = isset($_POST['product_price_discount']) ? $_POST['product_price_discount'] : '';
      $product_image       = isset($_POST['product_image']) ? $_POST['product_image'] : '';

      $chat_content        = stripcslashes(nl2br($chat_content));

      $args = [
         'conversation_id_hash'   => $conversation_id,
         'user_id'                => $user_id,
         'content'                => $chat_content,
         'timestamp'              => $timestamp,
         'is_read'                => 0
      ];

      if( 
         $product_id != '' &&
         $product_name != '' &&
         $product_name_second != '' &&
         $product_price != '' &&
         $product_image != '' 
      ){
         $args['product_id']              = $product_id;
         $args['product_name']            = $product_name;
         $args['product_name_second']     = $product_name_second;
         $args['product_price']           = $product_price;
         $args['product_price_discount']  = $product_price_discount;
         $args['product_image']           = $product_image;
      }

      $send_message     = $wpdb->insert('wp_watergo_messages', $args );
      $sql_get_count    = "SELECT * FROM wp_watergo_conversations WHERE conversation_id_hash = '$conversation_id'";
      $res_get_count    = $wpdb->get_results($sql_get_count);
      $count_messages   = 0;

      // INCREMENT COUNT MESSAGE
      // WHEN STORE LOGIN
      if( $is_user_store == 1 || $is_user_store == true ){
         $where_app           = 'chat_to_user';
         $count_messages      = $res_get_count[0]->from_user_count_messages;
         $count_messages      = $count_messages + 1;
         $wpdb->update( 'wp_watergo_conversations', [
            'from_user_count_messages'   => $count_messages++
         ], ['conversation_id_hash'    => $conversation_id]);
      }else{
      // WHEN USER LOGIN
         $where_app           = 'chat_to_store';
         $count_messages      = $res_get_count[0]->to_user_count_messages;
         $count_messages      = $count_messages + 1;
         $wpdb->update( 'wp_watergo_conversations', [
            'to_user_count_messages' => $count_messages++
         ], ['conversation_id_hash'    => $conversation_id]);
      }
      
      if( $send_message ){
         wp_send_json_success(['message' => 'messenge_send_ok', 'data' => [
            'message_id'             => $wpdb->insert_id,
            'conversation_id'        => $conversation_id,
            'user_id'                => $user_id,
            'content'                => $chat_content,
            'timestamp'              => $timestamp,
            'is_read'                => 0,
            'product_id'             => $product_id != '' ? $product_id : null,
            'product_name'           => $product_name != '' ? $product_name : null,
            'product_name_second'    => $product_name_second != '' ? $product_name_second : null,
            'product_price'          => $product_price != '' ? $product_price : null,
            'product_price_discount' => $product_price_discount != '' ? $product_price_discount : null,
            'product_image'          => $product_image != '' ? $product_image : null,
         ] ]);
         wp_die();
      }

      wp_send_json_error(['message' => 'messenger_not_found 3' ]);
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

// AUTO CREATE WWHEN NO ID FOUND
function atlantis_load_all_conversations_id(){

   if( isset( $_POST['action'] ) && $_POST['action'] == 'atlantis_load_all_conversations_id' ){

      $store_id   = isset($_POST['store_id']) ? $_POST['store_id'] : 0;
      $user_id    = isset($_POST['user_id']) ? $_POST['user_id'] : 0;

      if($store_id == 0 || $user_id == 0){
         wp_send_json_error(['message' => 'conversation_not_found']);
         wp_die();
      }

      $sql = "SELECT conversation_id
         FROM wp_watergo_conversations
         WHERE user_id = $user_id AND store_id = $store_id
      ";

      global $wpdb;
      $res = $wpdb->get_results($sql);

      if( empty($res )){
         $insert = $wpdb->insert('wp_watergo_conversations', [
            'user_id' => $user_id,
            'store_id' => $store_id,
            'created_at' => atlantis_current_datetime()
         ]);
         if( $insert ){
            wp_send_json_success(['message' => 'conversation_found', 'data' => $wpdb->insert_id ]);
            wp_die();
         }else{
            wp_send_json_error(['message' => 'conversation_not_found']);
            wp_die();
         }
      }

      wp_send_json_success(['message' => 'conversation_found', 'data' => $res[0]->conversation_id ]);
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
      if( $from_user == 0){
         $from_user  = get_current_user_id();
      }
      $to_user    = isset($_POST['to_user']) ? $_POST['to_user'] : 0;
      // $where_app = isset($_POST['where_app']) ? $_POST['where_app'] : '';

      // if( $where_app == '' ){
      //    wp_send_json_error(['message' => 'conversation_not_found']);
      //    wp_die();
      // }

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
         'conversation_id_hash'  => $conversation_id_hash,
         'from_user'             => $from_user,
         'to_user'               => $to_user,
         'created_at'            => $created_at,
         'user_product_count'    => 0,
         'store_product_count'   => 0,
      ]);

      // $pin_product_to_message = $wpdb->insert('wp_watergo_messages', [
      //    'conversation_id_hash'  => $conversation_id_hash,
      //    'timestamp'             => atlantis_current_datetime(),
      // ]);

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
      $conversation_id = isset($_POST['conversation_id']) ? (String) $_POST['conversation_id'] : 0;
      $where_app       = isset($_POST['where_app'])       ? (String) $_POST['where_app'] : '';

      if( $where_app == '' || $conversation_id == 0 ){
         wp_send_json_error(['message' => 'conversation_not_found']);
         wp_die();
      }

      global $wpdb;
      $sql = "SELECT * FROM wp_watergo_conversations WHERE conversation_id_hash = '$conversation_id'";
      $res = $wpdb->get_results($sql);

      if( empty( $res )){
         wp_send_json_error(['message' => 'conversation_not_found']);
         wp_die();
      }

      foreach( $res as $k => $vl ){
         // GET AVATAR + NAME STORE
         $sql_name   = "SELECT name, id FROM wp_watergo_store WHERE user_id = $vl->to_user ";
         $res_name   = $wpdb->get_results($sql_name);
         $vl->store_name   = $res_name[0]->name;
         $vl->store_avatar = func_atlantis_get_images( $res_name[0]->id , 'store', true);

         // GET AVATAR + NAME USER
         $vl->user_avatar    = func_atlantis_get_images( $vl->from_user, 'user_avatar', true);
         $user_name     = get_user_meta($vl->from_user, 'first_name', true);
         if($user_name == null || $user_name == ''){
            $user       = get_user_by('id', $vl->from_user);
            $user_name  = $user->data->display_name;
         }
         $vl->user_name = $user_name;
      }

      wp_send_json_success(['message' => 'conversation_found', 'data' => $res[0]]);
      wp_die();
   }
}


add_action( 'wp_ajax_nopriv_atlantis_get_messeges', 'atlantis_get_messeges' );
add_action( 'wp_ajax_atlantis_get_messeges', 'atlantis_get_messeges' );
function atlantis_get_messeges(){
   if( isset($_POST['action']) && $_POST['action'] == 'atlantis_get_messeges' ){

      $limit            = isset($_POST['limit']) ? $_POST['limit'] : 25;
      $paged            = isset($_POST['paged']) ? $_POST['paged'] : 0;
      $conversation_id  = isset($_POST['conversation_id']) ? $_POST['conversation_id'] : '';
      $get_newest       = isset($_POST['get_newest']) ? $_POST['get_newest'] : 0;

      if( $conversation_id == '' ){
         wp_send_json_error([ 'message' => 'message_not_found' ] );
         wp_die();
      }
      
      global $wpdb;

      if( $get_newest == 0 ){
         $sql = "SELECT * FROM wp_watergo_messages 
            WHERE conversation_id_hash = '$conversation_id'
            ORDER BY message_id DESC
            LIMIT $paged, $limit
         ";
      }else if( $get_newest == 1 ){
         $sql = "SELECT * FROM wp_watergo_messages 
            WHERE conversation_id_hash = '$conversation_id'
            ORDER BY message_id DESC
            LIMIT 1
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
      // $sql = "SELECT * FROM wp_watergo_conversations WHERE conversation_id_hash = '$conversation_id' ";
      // $res = $wpdb->get_results($sql);
      
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
      $where_app        = isset($_POST['where_app'])        ? $_POST['where_app'] : '';
      $user_id          = get_current_user_id();

      global $wpdb;
      $sql = '';

      if( $where_app == 'chat_to_store'){
         $sql = "SELECT from_user_count_messages as count_new_messages 
            FROM wp_watergo_conversations 
            WHERE conversation_id_hash = '$conversation_id'
         ";
      }

      if( $where_app == 'chat_to_user'){
         $sql = "SELECT to_user_count_messages as count_new_messages 
            FROM wp_watergo_conversations 
            WHERE conversation_id_hash = '$conversation_id'
         ";
      }

      $res = $wpdb->get_results( $sql);

      if( $res[0]->count_new_messages != null || $res[0]->count_new_messages != '' && $res[0]->count_new_messages != 0){
         
         $sql_new_message = "SELECT content as message, timestamp FROM wp_watergo_messages WHERE conversation_id_hash = '$conversation_id' ORDER BY timestamp DESC LIMIT 1 ";
         $res_new_message = $wpdb->get_results( $sql_new_message );

         wp_send_json_success(['message' => 'count_new_messages', 
            'data'    => [
               'count'     => (int) $res[0]->count_new_messages,
               'message'   => $res_new_message[0]->message,
               'timestamp' => $res_new_message[0]->timestamp
            ],
         ]);
         wp_die();
      }

      wp_send_json_success(['message' => 'count_new_messages', 'data' => [
         'count'   => 0,
         'message' => ''
      ] ]);
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

add_action( 'wp_ajax_nopriv_atlantis_get_last_time_message', 'atlantis_get_last_time_message' );
add_action( 'wp_ajax_atlantis_get_last_time_message', 'atlantis_get_last_time_message' );

function atlantis_get_last_time_message(){
   if( isset($_POST['action']) && $_POST['action'] == 'atlantis_get_last_time_message'){
      $conversation_id = isset($_POST['conversation_id']) ? $_POST['conversation_id'] : '';
      if( $conversation_id == '' ){
         wp_send_json_error(['message' => 'message_time_not_found' ]);
         wp_die();
      }

      global $wpdb;
      $sql = "SELECT timestamp FROM wp_watergo_messages WHERE conversation_id_hash = '$conversation_id' ORDER BY timestamp DESC LIMIT 1 ";
      $res = $wpdb->get_results( $sql);
      if( empty( $res )){
         wp_send_json_error(['message' => 'message_time_not_found' ]);
         wp_die();
      }

      wp_send_json_error(['message' => 'message_time_found', 'data' => $res[0]->timestamp ]);
      wp_die();
   }
}


add_action( 'wp_ajax_nopriv_atlantis_get_product_and_check', 'atlantis_get_product_and_check' );
add_action( 'wp_ajax_atlantis_get_product_and_check', 'atlantis_get_product_and_check' );

function atlantis_get_product_and_check(){
   if( isset( $_POST['action'] ) && $_POST['action'] == 'atlantis_get_product_and_check' ){
      $product_id       = isset($_POST['product_id']) ? (int) $_POST['product_id'] : 0;
      $conversation_id  = isset($_POST['conversation_id']) ? $_POST['conversation_id'] : 0;
      $user_id          = get_current_user_id();
      
      if($product_id == 0 && $conversation_id == 0){
         wp_send_json_error(['message' => 'product_not_found 1']);
         wp_die();
      }
      $product = null;

      global $wpdb;

      $sql_check_product_already_in_message = "SELECT * FROM wp_watergo_messages 
         WHERE product_id = $product_id AND conversation_id_hash = '$conversation_id' LIMIT 1
      ";

      $res = $wpdb->get_results( $sql_check_product_already_in_message );

      // PRODUCT ALREADY INSERT IN MESSAGE -> SKIP 
      if( empty( $res )){

         $product = func_atlantis_get_product_by([
            'id'           => $product_id,
            'get_by'       => 'product_id',
            'limit_image'  => true,
            'image_size'   => 'medium'
         ]);

         if( empty($product) ){
            wp_send_json_error(['message' => 'product_not_found 2']);
            wp_die();
         }

         wp_send_json_success(['message' => 'product_found', 'data' => $product[0] ]);
         wp_die();
      }

      wp_send_json_error(['message' => 'product_not_found 3']);
      wp_die();


      

      
   }
}


/**
 * @access UPGRADE FUNCTION GET CONVERSATION * create when it not exists
 * @chat version 2
 */
add_action( 'wp_ajax_nopriv_atlantis_create_conversation_or_get_it', 'atlantis_create_conversation_or_get_it' );
add_action( 'wp_ajax_atlantis_create_conversation_or_get_it', 'atlantis_create_conversation_or_get_it' );
function atlantis_create_conversation_or_get_it(){
   if( isset($_POST['action']) && $_POST['action'] == 'atlantis_create_conversation_or_get_it' ){

      $order_id         = isset($_POST['order_id']) ? $_POST['order_id'] : null;
      $conversation_id  = isset($_POST['conversation_id']) ? $_POST['conversation_id'] : null; // check by hash_id
      $from_user        = get_current_user_id();
      $store_id         = isset($_POST['store_id']) ? $_POST['store_id'] : null;
      $get_by           = isset($_POST['get_by']) ? $_POST['get_by'] : null;
      // $get_by_allow     = ['order_id'];

      if( $order_id == null){
         wp_send_json_error(['message' => 'conversation_not_found' ]);
         wp_die();
      }

      global $wpdb;
      $get_user_id_from_store_id = "SELECT user_id FROM wp_watergo_store WHERE id = $store_id";
      $res_user_id               = $wpdb->get_results( $get_user_id_from_store_id);
      $to_user                   = $res_user_id[0]->user_id;

      // GET CONVERSATION BY ORDER ID
      // $sql_get_conversation_by_order_id = "SELECT * FROM wp_watergo_conversations WHERE order_id = $order_id LIMIT 1";
      // $conversation_id = $wpdb->get_results( $sql_get_conversation_by_order_id);
      // GET CONVERSATION BY user and store
      $sql_get_conversation_by_user_and_store = "SELECT * FROM wp_watergo_conversations WHERE to_user = $to_user AND from_user = $from_user LIMIT 1";
      $conversation_id = $wpdb->get_results( $sql_get_conversation_by_user_and_store);

      if( empty( $conversation_id ) ){
         $converation_id_hash = bin2hex(random_bytes(32));
         // CONVERT STORE_ID TO {from_user} 
         $create_at     = atlantis_current_datetime();
         $order_detail  = "SELECT * FROM wp_watergo_order_group WHERE order_group_store_id = $store_id ORDER BY order_group_id ASC LIMIT 1";
         $wpdb->insert('wp_watergo_conversations', [
            'from_user'             => $from_user,
            'to_user'               => $to_user,
            'conversation_id_hash'  => $converation_id_hash,
            'created_at'            => $create_at,
         ]);

         // ADD PIN PRODUCT FIRST MESSAGE
         // $wpdb->insert('wp_watergo_messages', [
         //    'conversation_id_hash'   => $converation_id_hash,
         //    'timestamp'              => $create_at,
         //    'product_id'             => '',
         //    'product_name'           => '',
         //    'product_name_second'    => '',
         //    'product_price'          => '',
         //    'product_price_discount' => '',
         //    'product_image'          => '',
         //    'message_type'           => 'pin_product'
         // ]);


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
            wp_watergo_order.order_number

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

      wp_send_json_error(['message' => 'order_found', 'data' => $res]);
      wp_die();

   }
}