<?php
add_action( 'wp_ajax_nopriv_atlantis_load_chat', 'atlantis_load_chat' );
add_action( 'wp_ajax_atlantis_load_chat', 'atlantis_load_chat' );

add_action( 'wp_ajax_nopriv_atlantis_get_chat', 'atlantis_get_chat' );
add_action( 'wp_ajax_atlantis_get_chat', 'atlantis_get_chat' );

add_action( 'wp_ajax_nopriv_atlantis_load_messenger', 'atlantis_load_messenger' );
add_action( 'wp_ajax_atlantis_load_messenger', 'atlantis_load_messenger' );

add_action( 'wp_ajax_nopriv_atlantis_send_messenger', 'atlantis_send_messenger' );
add_action( 'wp_ajax_atlantis_send_messenger', 'atlantis_send_messenger' );

add_action( 'wp_ajax_nopriv_atlantis_get_newest_messenger', 'atlantis_get_newest_messenger' );
add_action( 'wp_ajax_atlantis_get_newest_messenger', 'atlantis_get_newest_messenger' );


function atlantis_load_chat(){
   if( isset( $_POST['action'] ) && $_POST['action'] == 'atlantis_load_chat' ){

      if(is_user_logged_in() == true ){
         $user_id = get_current_user_id();
         $user = get_user_by('id', $user_id);
         $prefix_user = 'user_' . $user->data->ID;
      }else{
         wp_send_json_error(['message' => 'no_login_invalid' ]);
         wp_die();
      }

      $user_is_store = get_field('user_store', $user_id, true);

      // ACCOUNT USER
      if( $user_is_store == false || $user_is_store == null || $user_is_store == 0){

         global $wpdb;

         $sql = "SELECT 
            wp_watergo_chat.*, 
            wp_watergo_messenger.* ,
            wp_watergo_store.id as store_id,
            wp_watergo_store.name as store_name

            FROM wp_watergo_chat 
            LEFT JOIN wp_watergo_messenger 
            ON wp_watergo_messenger.chat_id = wp_watergo_chat.chat_id 
            LEFT JOIN wp_watergo_store
            ON wp_watergo_store.id = wp_watergo_chat.chat_to_user
            WHERE wp_watergo_chat.chat_from_user = $user_id
            ORDER BY wp_watergo_messenger.messenger_id DESC
            LIMIT 1
         ";

         $res = $wpdb->get_results($sql);

         if( empty($res ) ){
            wp_send_json_error(['message' => 'chat_not_found 1' ]);
            wp_die();
         }

         wp_send_json_success(['message' => 'chat_found', 'data' => $res ]);
         wp_die();

      }

      // ACCOUNT STORE
      if( $user_is_store == true ||  $user_is_store == 1){

         global $wpdb;

         $sql = "SELECT 
            wp_watergo_chat.chat_id,
            wp_watergo_chat.chat_to_user,
            wp_usermeta.meta_value as first_name

            FROM wp_watergo_chat
            LEFT JOIN wp_users
            ON wp_users.ID = wp_watergo_chat.chat_to_user
            LEFT JOIN wp_usermeta
            ON wp_usermeta.user_id = wp_users.ID
            WHERE 
               wp_usermeta.meta_key = 'first_name'
            AND 
               wp_watergo_chat.chat_id = 12
            LIMIT 1
         ";


         $res = $wpdb->get_results($sql);

         if( empty($res ) ){
            wp_send_json_error(['message' => 'chat_not_found 1' ]);
            wp_die();
         }

         wp_send_json_success(['message' => 'chat_found', 'data' => $res ]);
         wp_die();
      }


      // // ACCOUNT USER
      // if($user_is_store == 0 || $user_is_store == null || $user_is_store == false ){
      //    $sql = "SELECT 
      //          wp_watergo_chat.*, 
      //          wp_watergo_messenger.*, 
      //          wp_watergo_store.name as store_name

      //       FROM wp_watergo_chat
      //       LEFT JOIN wp_watergo_messenger
      //       ON wp_watergo_messenger.chat_id = wp_watergo_chat.chat_id
      //       LEFT JOIN wp_watergo_store
      //       ON wp_watergo_store.id = wp_watergo_chat.chat_to_user
      //       WHERE wp_watergo_chat.chat_from_user = {$user_id}
      //       ORDER BY wp_watergo_messenger.messenger_id DESC
      //       LIMIT 1
      //    ";

      //    global $wpdb;
      //    $res = $wpdb->get_results($sql);

      //    if(empty($res)){
      //       wp_send_json_error(['message' => 'chat_not_found' ]);
      //       wp_die();
      //    }
      //    wp_send_json_success(['message' => 'chat_found', 'data' => $res ]);
      //    wp_die();
      // }

      // // ACCOUNT STORE

      // if($user_is_store == 1 || $user_is_store == true){

      // }

      wp_send_json_error(['message' => 'chat_not_found 2' ]);
      wp_die();

   }
}


function atlantis_load_messenger(){
   if( isset( $_POST['action'] ) && $_POST['action'] == 'atlantis_load_messenger' ){

      // LOAD MESSENGER BY USER ID FIRST

      if(is_user_logged_in() == true ){
         $user_id = get_current_user_id();
         $user = get_user_by('id', $user_id);
         $prefix_user = 'user_' . $user->data->ID;
      }else{
         wp_send_json_error(['message' => 'no_login_invalid' ]);
         wp_die();
      }


      // // GET CHAT ID AND CHECK CURRENT USER IS {STORE USER OR NOT}
      // $chat_id = isset($_POST['chat_id']) ? $_POST['chat_id'] : 0;
      // $user_is_store = get_field('user_store', $user_id, true);
      // $store_id = 0;

      // if($chat_id == 0){
      //    wp_send_json_error(['message' => 'messenger_not_found 1' ]);
      //    wp_die();
      // }

      // global $wpdb;

      // $sql_get_messenger = "SELECT * FROM wp_watergo_messenger 
      //    WHERE chat_id = {$chat_id}
      //    ORDER BY messenger_id DESC
      // ";

      // $res = $wpdb->get_results($sql_get_messenger);

      // $sql_store_id = "SELECT chat_to_user as store_id FROM wp_watergo_chat WHERE chat_id = {$chat_id}";
      // $store_id = $wpdb->get_results($sql_store_id)[0]->store_id;

      // if( empty($res) ){
      //    wp_send_json_error(['message' => 'messenger_not_found 2' ]);
      //    wp_die();
      // }

      // wp_send_json_success(['message' => 'messenger_found', 
      //    'data' => $res,
      //    'store_id' => $store_id,
      //    'user_id' => $user->data->ID,
      //    'is_user_store' => $user_is_store
      // ]);

   }
}



function atlantis_send_messenger(){
   if( isset( $_POST['action'] ) && $_POST['action'] == 'atlantis_send_messenger' ){

      if(is_user_logged_in() == true ){
         $user_id = get_current_user_id();
         $user = get_user_by('id', $user_id);
         $prefix_user = 'user_' . $user->data->ID;
      }else{
         wp_send_json_error(['message' => 'no_login_invalid' ]);
         wp_die();
      }

      $chat_id = isset($_POST['chat_id']) ? $_POST['chat_id'] : 0;
      $chat_content = isset($_POST['chat_content']) ? $_POST['chat_content'] : '';

      if($chat_content == ''){
         wp_send_json_error(['message' => 'messenger_not_found 1' ]);
         wp_die();
      }

      if( $chat_id == 0 || !is_numeric($chat_id) ){
         wp_send_json_error(['message' => 'messenger_not_found 2' ]);
         wp_die();
      }

      global $wpdb;

      $args = [
         'chat_id'               => $chat_id,
         'messenger_message'     => $chat_content,
         'messenger_time_send'   => time(),
         'messenger_user_id'     => $user_id
      ];

      $record = $wpdb->insert('wp_watergo_messenger', $args );

      if( $record === false  ){
         wp_send_json_error(['message' => 'messenger_not_found 3' ]);
         wp_die();
      }
      $args['messenger_id'] = $record;
      
      wp_send_json_success(['message' => 'messenger_send_ok', 'data' => $args ]);
      wp_die();

   }
}

function atlantis_get_newest_messenger(){
   if( isset( $_POST['action'] ) && $_POST['action'] == 'atlantis_get_newest_messenger' ){

      if(is_user_logged_in() == true ){
         $user_id = get_current_user_id();
         $user = get_user_by('id', $user_id);
         $prefix_user = 'user_' . $user->data->ID;
      }else{
         wp_send_json_error(['message' => 'no_login_invalid' ]);
         wp_die();
      }

      $chat_id             = isset($_POST['chat_id']) ? $_POST['chat_id'] : 0;
      $list_id_messenger   = isset($_POST['list_id_messenger']) ? $_POST['list_id_messenger'] : '';

      if( ! is_numeric($chat_id) || $chat_id == 0 ){
         wp_send_json_error(['message' => 'chat_not_found' ]);
         wp_die();
      }

      if($list_id_messenger == '' ){
         wp_send_json_error(['message' => 'chat_not_found' ]);
         wp_die();
      }


      // convert json to array php
      $list_id_messenger = json_decode( $list_id_messenger);
      // convert array php to string
      $list_id_messenger = implode(',', $list_id_messenger);
      global $wpdb;
      // $query = $wpdb->prepare("SELECT * FROM wp_watergo_messenger WHERE messenger_id NOT IN (%s) AND chat_id = %d", [ $list_id_messenger, $chat_id]);
      $query = "SELECT * FROM wp_watergo_messenger WHERE messenger_id NOT IN($list_id_messenger) AND chat_id = $chat_id";

      $res = $wpdb->get_results($query);

      if( empty( $res ) ){
         wp_send_json_error(['message' => 'chat_not_found' ]);
         wp_die();
      }

      wp_send_json_success(['message' => 'chat_found', 'data' => $res, 'query' => $query]);
      wp_die();

   }
}


function atlantis_get_chat(){
   if( isset( $_POST['action'] ) && $_POST['action'] == 'atlantis_get_chat' ){

      $chat_id = isset($_POST['chat_id']) ? $_POST['chat_id'] : 0;

      if( ! is_numeric($chat_id) && $chat_id == 0 ){
         wp_send_json_error(['message' => 'chat_not_found' ]);
         wp_die();
      }

      global $wpdb;

      $sql = "SELECT * FROM wp_watergo_chat WHERE chat_id = $chat_id";
      $res = $wpdb->get_results($sql_get_messenger);

      if( empty($res) ){
         wp_send_json_error(['message' => 'chat_not_found' ]);
         wp_die();
      }

      wp_send_json_success(['message' => 'chat_found', 'data' => $res ]);

   }
}

