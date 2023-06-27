<?php

add_action( 'wp_ajax_nopriv_atlantis_notification', 'atlantis_notification' );
add_action( 'wp_ajax_atlantis_notification', 'atlantis_notification' );

add_action( 'wp_ajax_nopriv_atlantis_notification_count', 'atlantis_notification_count' );
add_action( 'wp_ajax_atlantis_notification_count', 'atlantis_notification_count' );

function atlantis_notification(){
   if( isset( $_POST['action'] ) && $_POST['action'] == 'atlantis_notification' ){

      if(is_user_logged_in() == true ){
         $user_id = get_current_user_id();
         $user = get_user_by('id', $user_id);
         $prefix_user = 'user_' . $user->data->ID;
      }else{
         wp_send_json_error(['message' => 'no_login_invalid' ]);
         wp_die();
      }

      $sql = "SELECT * FROM wp_watergo_notification WHERE user_id = $user_id";
      $res = $wpdb->get_results($sql);

      if( empty( $res ) ){
         wp_send_json_error(['message' => 'notification_not_found']);
         wp_die();
      }
      wp_send_json_success(['message' => 'notification_found', 'data' => $res ]);
      wp_die();

   }
}

function atlantis_notification_count(){
   if( isset( $_POST['action'] ) && $_POST['action'] == 'atlantis_notification_count' ){

      if(is_user_logged_in() == true ){
         $user_id = get_current_user_id();
         $user = get_user_by('id', $user_id);
         $prefix_user = 'user_' . $user->data->ID;
      }else{
         wp_send_json_error(['message' => 'no_login_invalid' ]);
         wp_die();
      }

      global $wpdb;
      $sql = "SELECT COUNT(id) as notification_count FROM wp_watergo_notification WHERE user_id = $user_id AND is_read = 0";
      $res = $wpdb->get_results($sql);
      
      if( empty( $res ) ){
         wp_send_json_error(['message' => 'notification_not_found']);
         wp_die();
      }
      wp_send_json_success(['message' => 'notification_found', 'data' => $res ]);
      wp_die();
      
   }
}