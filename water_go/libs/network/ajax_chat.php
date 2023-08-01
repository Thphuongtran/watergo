<?php

add_action( 'wp_ajax_nopriv_atlantis_load_conversation', 'atlantis_load_conversation' );
add_action( 'wp_ajax_atlantis_load_conversation', 'atlantis_load_conversation' );

add_action( 'wp_ajax_nopriv_atlantis_get_messages', 'atlantis_get_messages' );
add_action( 'wp_ajax_atlantis_get_messages', 'atlantis_get_messages' );

add_action( 'wp_ajax_nopriv_atlantis_send_messenger', 'atlantis_send_messenger' );
add_action( 'wp_ajax_atlantis_send_messenger', 'atlantis_send_messenger' );

add_action( 'wp_ajax_nopriv_atlantis_get_newest_messages', 'atlantis_get_newest_messages' );
add_action( 'wp_ajax_atlantis_get_newest_messages', 'atlantis_get_newest_messages' );

add_action( 'wp_ajax_nopriv_atlantis_is_conversation_created_or_create', 'atlantis_is_conversation_created_or_create' );
add_action( 'wp_ajax_atlantis_is_conversation_created_or_create', 'atlantis_is_conversation_created_or_create' );

add_action( 'wp_ajax_nopriv_atlantis_count_messages', 'atlantis_count_messages' );
add_action( 'wp_ajax_atlantis_count_messages', 'atlantis_count_messages' );

add_action( 'wp_ajax_nopriv_atlantis_get_product_newest_and_store', 'atlantis_get_product_newest_and_store' );
add_action( 'wp_ajax_atlantis_get_product_newest_and_store', 'atlantis_get_product_newest_and_store' );

add_action( 'wp_ajax_nopriv_atlantis_load_conversations_id', 'atlantis_load_conversations_id' );
add_action( 'wp_ajax_atlantis_load_conversations_id', 'atlantis_load_conversations_id' );

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

function atlantis_load_conversation(){

   if( isset($_POST['action']) && $_POST['action'] == 'atlantis_load_conversation' ){

      $host_chat = '';
      $sql_conversation = "SELECT conversation_id, user_id, store_id FROM wp_watergo_conversations ";

      $user_id       = get_current_user_id();
      $is_user_store = get_user_meta($user_id , 'user_store', true);
      
      // GET CURRENT USER ROLE
      if( $is_user_store == 1 || $is_user_store == true ){
         $host_chat         = 'store';
         $user_id           = func_get_store_id_from_current_user();
         $sql_conversation .= " WHERE store_id = $user_id";
      }else{
         $host_chat         = 'user';
         $sql_conversation .= " WHERE user_id = $user_id";
      }

      global $wpdb;
      $res_cons = $wpdb->get_results($sql_conversation);

      if( empty( $res_cons )){
         wp_send_json_error(['message' => 'load_conversation_error']);
         wp_die();
      }

      // LIST CONVERSATION 
      $list_converstations = [];
      foreach( $res_cons as $kCons => $cons ){
         $_user_id            = $cons->user_id;
         $_store_id           = $cons->store_id;
         // HOST IS STORE => GET USER INFO
         if( $host_chat == 'store'){
            $sql_info = "SELECT 
                  
                  wp_usermeta.user_id, 
                  wp_usermeta.meta_value as name,
                  wp_users.display_name 

               FROM wp_usermeta

               LEFT JOIN wp_users
               ON wp_users.ID = wp_usermeta.user_id
               
               WHERE wp_usermeta.user_id = $_user_id AND wp_usermeta.meta_key = 'first_name'
            ";
         }
         // HOST IS USER => GET STORE INFO
         if( $host_chat == 'user'){
            $sql_info = "SELECT 
               id as user_id, name 
               FROM wp_watergo_store 
               -- LEFT JOIN wp_users
               -- ON wp_users.ID = wp_usermeta.user_id
            WHERE id = $_store_id";
         }

         $get_info = $wpdb->get_results( $sql_info );
         
         if( !empty( $get_info ) ){
            foreach($get_info as $k => $vl ){
               if( $host_chat == 'store'){
                  $img = func_atlantis_get_images( $vl->user_id, 'user_avatar', true);
                  $list_converstations[$kCons]['conversation_id']    = $cons->conversation_id;
                  $list_converstations[$kCons]['user_id']            = $vl->user_id;
                  $list_converstations[$kCons]['name']               = $vl->name;
                  $list_converstations[$kCons]['image']              = $img;
                  $list_converstations[$kCons]['content']            = 'Tap to chat';
                  $list_converstations[$kCons]['user_role']          = 'user';
                  $list_converstations[$kCons]['timestamp']          = 0;
               }
               if( $host_chat == 'user'){
                  $img = func_atlantis_get_images( $vl->user_id, 'store', true);
                  $list_converstations[$kCons]['conversation_id']    = $cons->conversation_id;
                  $list_converstations[$kCons]['user_id']            = $vl->user_id;
                  $list_converstations[$kCons]['name']               = $vl->name;
                  $list_converstations[$kCons]['image']              = $img;
                  $list_converstations[$kCons]['content']            = 'Tap to chat';
                  $list_converstations[$kCons]['user_role']          = 'store';
                  $list_converstations[$kCons]['timestamp']          = 0;
               }
            }
         }
      }

      wp_send_json_success([
         'message'   => 'conversation_found',
         'data'      => $list_converstations,
         'host_chat' => $host_chat, 
         'host_id'   => $user_id,
         // 'sql' => $sql_conversation
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


function atlantis_send_messenger(){
   if( isset( $_POST['action'] ) && $_POST['action'] == 'atlantis_send_messenger' ){

      $conversation_id  = isset($_POST['conversation_id']) ? $_POST['conversation_id'] : 0;
      $chat_content     = isset($_POST['chat_content']) ? $_POST['chat_content'] : '';

      if($chat_content == '' || $conversation_id == 0 ){
         wp_send_json_error(['message' => 'messenger_not_found 1' ]);
         wp_die();
      }

      $user_id       = get_current_user_id();
      $is_user_store = get_user_meta($user_id , 'user_store', true);
      $user_role = '';

      if( $is_user_store == 1 || $is_user_store == true ){
         $user_role  = 'store';
         $user_id    = func_get_store_id_from_current_user();
      }else{
         $user_role = 'user';
      }

      global $wpdb;

      $timestamp  = atlantis_current_datetime();

      $args = [
         'conversation_id' => $conversation_id,
         'user_id'         => $user_id,
         'user_role'       => $user_role,
         'content'         => $chat_content,
         'timestamp'       => $timestamp,
         'is_read'         => 0
      ];

      $send_message = $wpdb->insert('wp_watergo_messages', $args );
      $args['message_id'] = $wpdb->insert_id;

      if( $send_message ){
         wp_send_json_success(['message' => 'messenge_send_ok', 'data' => $args ]);
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
function atlantis_load_conversations_id(){

   if( isset( $_POST['action'] ) && $_POST['action'] == 'atlantis_load_conversations_id' ){

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
            'created_at' => time()
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
