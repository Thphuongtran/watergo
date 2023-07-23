<?php

add_action( 'wp_ajax_nopriv_atlantis_change_password', 'atlantis_change_password' );
add_action( 'wp_ajax_atlantis_change_password', 'atlantis_change_password' );

function atlantis_change_password(){
   if( isset( $_POST['action'] ) && $_POST['action'] == 'atlantis_change_password' ){

      if(is_user_logged_in() == true ){
         $user_id       = get_current_user_id();
         $user          = get_user_by('id', $user_id);
         $prefix_user   = 'user_' . $user->data->ID;

      }else{
         wp_send_json_error(['err' => true, 'message' => 'change_password_error' ]);
         wp_die();
      }

      $currentPassword  = isset($_POST['currentPassword']) ? $_POST['currentPassword'] : ''; 
      $password         = isset($_POST['password']) ? $_POST['password'] : '';
      $repassword       = isset($_POST['repassword']) ? $_POST['repassword'] : '';

      $valid_password   = wp_check_password( $currentPassword, $user_id );

      if( $valid_password == false ){
         wp_send_json_error(['err' => true, 'message' => 'password_not_match' ]);
         wp_die();
      }

      if( $password != $repassword ){
         wp_send_json_error(['err' => true, 'message' => 'password_not_match' ]);
         wp_die();
      }

      wp_set_password( $repassword, $user_id );
      wp_send_json_success(['err' => false, 'message' => 'password_change_success']);
      wp_die();
      
   }
}