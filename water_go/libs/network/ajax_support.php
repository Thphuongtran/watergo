<?php

add_action( 'wp_ajax_nopriv_atlantis_support', 'atlantis_support' );
add_action( 'wp_ajax_atlantis_support', 'atlantis_support' );

add_action( 'wp_ajax_nopriv_atlantis_get_support', 'atlantis_get_support' );
add_action( 'wp_ajax_atlantis_get_support', 'atlantis_get_support' );

add_action( 'wp_ajax_nopriv_atlantis_add_support', 'atlantis_add_support' );
add_action( 'wp_ajax_atlantis_add_support', 'atlantis_add_support' );

add_action( 'wp_ajax_nopriv_atlantis_support_make_as_read', 'atlantis_support_make_as_read' );
add_action( 'wp_ajax_atlantis_support_make_as_read', 'atlantis_support_make_as_read' );


function atlantis_support(){
   if( isset( $_POST['action'] ) && $_POST['action'] == 'atlantis_support' ){

      if(is_user_logged_in() == true ){
         $user_id = get_current_user_id();
         $user = get_user_by('id', $user_id);
         $prefix_user = 'user_' . $user->data->ID;
      }else{
         wp_send_json_error(['message' => 'no_login_invalid' ]);
         wp_die();
      }

      global $wpdb;

      $sql = "SELECT * FROM wp_watergo_supports WHERE user_id = {$user_id} ";
      $res = $wpdb->get_results($sql);
      if( empty( $res )){
         wp_send_json_error([ 'message' => 'no_support_service_found' ]);
         wp_die();
      }else{
         wp_send_json_success([ 'message' => 'get_support_ok', 'data' => $res ]);
         wp_die();  
      }
      
   }
}

function atlantis_add_support(){
   if( isset( $_POST['action'] ) && $_POST['action'] == 'atlantis_add_support' ){
      $question = isset($_POST['question']) ? $_POST['question'] : '';

      if(is_user_logged_in() == true ){
         $user_id = get_current_user_id();
         $user = get_user_by('id', $user_id);
         $prefix_user = 'user_' . $user->data->ID;
      }else{
         wp_send_json_error(['message' => 'no_login_invalid' ]);
         wp_die();
      }

      if( $question == '' ){
         wp_send_json_error([ 'message' => 'question_is_not_empty' ]);
         wp_die();
      }

      global $wpdb;
      $wpdb->insert('wp_watergo_supports', [
         'question' => $question,
         'time_created' => time(),
         'user_id' => $user_id
      ]);

      wp_send_json_success([ 'message' => 'question_add_ok' ]);
      wp_die();  
   }
}

function atlantis_get_support(){
   if( isset( $_POST['action'] ) && $_POST['action'] == 'atlantis_get_support' ){
      $support_id = isset($_POST['support_id']) ? $_POST['support_id'] : 0;

      if(is_user_logged_in() == true ){
         $user_id = get_current_user_id();
         $user = get_user_by('id', $user_id);
         $prefix_user = 'user_' . $user->data->ID;
      }else{
         wp_send_json_error(['message' => 'no_login_invalid' ]);
         wp_die();
      }

      if($support_id == 0){
         wp_send_json_error(['message' => 'support_not_found' ]);
         wp_die();
      }

      global $wpdb;

      $sql = "SELECT * FROM wp_watergo_supports WHERE id = $support_id AND user_id = $user_id";
      $res = $wpdb->get_results($sql);
      if( empty( $res )){
         wp_send_json_error([ 'message' => 'support_not_found' ]);
         wp_die();
      }

      wp_send_json_success([ 'message' => 'support_found', 'data' => $res[0] ]);
      wp_die();
      
   }
         
}

function atlantis_support_make_as_read(){

   if( isset( $_POST['action'] ) && $_POST['action'] == 'atlantis_support_make_as_read' ){
      $support_id = isset($_POST['support_id']) ? $_POST['support_id'] : 0;

      if(is_user_logged_in() == true ){
         $user_id = get_current_user_id();
         $user = get_user_by('id', $user_id);
         $prefix_user = 'user_' . $user->data->ID;
      }else{
         wp_send_json_error(['message' => 'no_login_invalid' ]);
         wp_die();
      }

      if( $support_id == 0 ){
         wp_send_json_error([ 'message' => 'support_not_found' ]);
         wp_die();
      }

      global $wpdb;

      $sql = $wpdb->prepare("UPDATE wp_watergo_supports SET is_read = 1 WHERE is_read = 0 AND user_id = $user_id AND id = $support_id ");
      $wpdb->query($sql);

      wp_send_json_success([ 'message' => 'support_mark_as_read', ]);
      wp_die();
   }
}