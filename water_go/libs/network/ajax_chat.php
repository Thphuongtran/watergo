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

function atlantis_load_conversation(){
   if( isset($_POST['action']) && $_POST['action'] == 'atlantis_load_conversation' ){

      $host_chat = null;
      $sql_get_host = '';

      if(is_user_logged_in() == true ){
         $user_id = get_current_user_id();
         $is_user_store = get_user_meta($user_id , 'user_store', true) != '' 
         ? (int) get_user_meta($user_id , 'user_store', true) 
         : null;
         if( $is_user_store == 1 || $is_user_store == true ){
            $host_chat = 'store';
            $sql_get_host = " WHERE store_id = $user_id";
         }else{
            $host_chat = 'user';
            $sql_get_host = " WHERE user_id = $user_id";
         }
      }else{
         wp_send_json_error(['message' => 'no_login_invalid' ]);
         wp_die();
      }
      // GET CONVERSATION 
      $sql_conversation = "SELECT conversation_id, user_id, store_id FROM wp_watergo_conversations ";
      $sql_conversation .= $sql_get_host;

      global $wpdb;
      $res_conversation = $wpdb->get_results($sql_conversation);

      if( empty( $res_conversation )){
         wp_send_json_error(['message' => 'conversation_not_found' ]);
         wp_die();
      }
      

      // LIST CONVERSATION 
      $list_conversation = [];
      foreach($res_conversation as $k => $conversation ){

         $_user_id   = $conversation->user_id;
         $_store_id  = $conversation->store_id;
         $_conversation_id  = $conversation->conversation_id;
         
         // CURRENT IS USER => GET STORE_ID CHAT
         if( $host_chat == 'user' ){
            $sql_list_conversation = "SELECT
               wp_watergo_messages.*,
               wp_watergo_store.id as store_id,
               wp_watergo_store.name as name

            FROM wp_watergo_messages
            LEFT JOIN wp_watergo_store
            ON wp_watergo_store.id = wp_watergo_messages.user_id
            WHERE wp_watergo_messages.user_id = $_store_id AND wp_watergo_messages.conversation_id = $_conversation_id
            ORDER BY wp_watergo_messages.timestamp DESC
            LIMIT 1";
         }

         // CURRENT IS STORE => GET USER_ID CHAT
         if( $host_chat == 'store' ){
            $sql_list_conversation = "SELECT
               wp_watergo_messages.*,
               wp_usermeta.meta_value as name

            FROM wp_watergo_messages

            LEFT JOIN wp_usermeta
            ON wp_usermeta.user_id = wp_watergo_messages.user_id AND wp_usermeta.meta_key = 'first_name'

            WHERE wp_watergo_messages.user_id = $_user_id 
            AND wp_watergo_messages.conversation_id = $_conversation_id
            ORDER BY wp_watergo_messages.timestamp DESC
            LIMIT 1";
         }

         $_res = $wpdb->get_results($sql_list_conversation);
         if( ! empty( $_res ) ){
            // get store avatar
            if( $host_chat == 'user'){
               $_res[0]->image = func_atlantis_get_images( $_store_id, 'store', true);
            }
            if( $host_chat == 'store'){
               $_res[0]->image = func_atlantis_get_images( $_user_id, 'user_avatar', true);
            }
            array_push($list_conversation, ...$_res);
         }
      }

      wp_send_json_success(['message' => 'conversation_found', 'data' => $list_conversation, 'host_chat' => $host_chat, 'host_id' => $user_id]);
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

// GET CONVERSATION ID IF NO FOUND -> CREATE
function atlantis_is_conversation_created_or_create(){
   if( isset($_POST['action']) && $_POST['action'] == 'atlantis_is_conversation_created_or_create' ){

      $user_id = isset($_POST['user_id']) ? $_POST['user_id'] : 0;
      $store_id = isset($_POST['store_id']) ? $_POST['store_id'] : 0;

      if( $store_id == 0 || $user_id == 0){
         wp_send_json_error(['message' => 'conversation_not_found 1' ]);
         wp_die();
      }

      global $wpdb;
      $sql = "SELECT conversation_id FROM wp_watergo_conversations WHERE store_id = $store_id AND user_id = $user_id LIMIT 1";
      $res = $wpdb->get_results($sql);

      // CREATE NEW CONVERSATION
      if( empty( $res) ){
         $args = [
            'user_id' => $user_id,
            'store_id' => $store_id,
            'created_at' => time()
         ];
         $inserted = $wpdb->insert('wp_watergo_conversations', $args);

         if( $inserted ){
            wp_send_json_success(['message' => 'conversation_create_ok', 'data' => $wpdb->insert_id ]);
         }else{
            wp_send_json_error(['message' => 'conversation_not_found 2' ]);
         }
         wp_die();
      }

      $conversation_id = $res[0]->conversation_id;

      wp_send_json_success(['message' => 'conversation_found', 'data' => $conversation_id ]);
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
         wp_watergo_messages.timestamp
         
      FROM wp_watergo_conversations

      LEFT JOIN wp_watergo_messages
      ON wp_watergo_messages.conversation_id = wp_watergo_conversations.conversation_id
      
      WHERE wp_watergo_conversations.conversation_id = $conversation_id

      ORDER BY wp_watergo_messages.timestamp DESC
      LIMIT 0, 20
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
      $user_id          = isset($_POST['user_id']) ? $_POST['user_id'] : 0;

      if($chat_content == '' || $conversation_id == 0 || $user_id == 0 ){
         wp_send_json_error(['message' => 'messenger_not_found 1' ]);
         wp_die();
      }

      global $wpdb;

      $args = [
         'conversation_id' => $conversation_id,
         'user_id'         => $user_id,
         'content'         => $chat_content,
         'timestamp'       => time(),
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
