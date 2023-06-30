<?php

add_action( 'wp_ajax_nopriv_atlantis_logout', 'atlantis_logout' );
add_action( 'wp_ajax_atlantis_logout', 'atlantis_logout' );

add_action( 'wp_ajax_nopriv_atlantis_login', 'atlantis_login' );
add_action( 'wp_ajax_atlantis_login', 'atlantis_login' );

add_action( 'wp_ajax_nopriv_atlantis_register_user', 'atlantis_register_user' );
add_action( 'wp_ajax_atlantis_register_user', 'atlantis_register_user' );

add_action( 'wp_ajax_nopriv_atlantis_reset_password', 'atlantis_reset_password' );
add_action( 'wp_ajax_atlantis_reset_password', 'atlantis_reset_password' );

add_action( 'wp_ajax_nopriv_atlantis_forget_password', 'atlantis_forget_password' );
add_action( 'wp_ajax_atlantis_forget_password', 'atlantis_forget_password' );

function atlantis_login(){
   if( isset($_POST['action']) && $_POST['action'] == 'atlantis_login' ){
      $email = isset($_POST['email']) ? $_POST['email'] : '';
      $password = isset($_POST['password']) ? $_POST['password'] : '';

      if( !is_email($email) && $email == '' && $password == ''  ){
         wp_send_json_error([ 'message' => 'login_error' ]);
         wp_die();
      }

      $user_login = wp_signon( [
         'user_login'    => $email,
         'user_password' => $password,
         'remember'      => true
      ]);

      if ( is_wp_error( $user_login ) ) {
         // authentication failed, display error message
         // $error_message = $user_login->get_error_message();
         wp_send_json_error([ 'message' => 'login_error' ]);
         wp_die();
      } else {
         // authentication succeeded, redirect to home page
         wp_send_json_success([ 'message' => 'login_ok']);
         wp_die();
      }

   }
}

function atlantis_logout(){
   if( isset($_POST['action']) && $_POST['action'] == 'atlantis_logout' ){
      if(is_user_logged_in() == true ){
         $user_id = get_current_user_id();
         $user = get_user_by('id', $user_id);
         $prefix_user = 'user_' . $user->data->ID;
      }else{
         wp_send_json_error(['message' => 'no_login_invalid' ]);
         wp_die();
      }
      wp_logout();
      wp_send_json_success(['message' => 'logout_success']);
      wp_die();
   }

}

function atlantis_register_user(){
   if( isset($_POST['action']) && $_POST['action'] == 'atlantis_register_user' ){

      $email      = isset($_POST['email'])      ? $_POST['email'] : '';
      $password   = isset($_POST['password'])   ? $_POST['password'] : '';
      $username   = isset($_POST['username'])   ? $_POST['username'] : '';
      $code       = isset($_POST['code'])       ? $_POST['code'] : '';
      
      $get_code = get_transient( 'verification_code_' . $email );
      
      $error = [];

      // if ( ! filter_var($email, FILTER_VALIDATE_EMAIL) && email_exists($email) ){
      if ( ! is_email($email) && email_exists($email) ){
         $error['email'] = 'Email is not invalid';
      }

      if(  username_exists( $username) !== false ){
         $error['username'] = 'Username already exists';
      }
      
      if( $code == '' || $code == null || $code == 0 || $code != $get_code){
         $error['code'] = 'Verify Error';
      }

      if( !empty( $error ) ){
         wp_send_json_error([ 'message' => 'register_error']);
         wp_die();
      }

      // pass all
      delete_transient( 'verification_code_' . $email );
      wp_insert_user( [
         'user_login' => $username,
         'user_pass' => $password,
         'user_email' => $email,
         'first_name' => $email,
      ]);

      wp_send_json_success([ 'message' => 'register_ok' ]);
      wp_die();

   }
}

function atlantis_forget_password(){
   if( isset($_POST['action']) && $_POST['action'] == 'atlantis_forget_password' ){
      $email = isset($_POST['email']) ? $_POST['email'] : '';

      $res = atlantis_code_verification($email, 'email_exists' );

      if( $res['message'] == 'sendcode_success' ){
         wp_send_json_success( $res );
         wp_die();
      }else{
         wp_send_json_error( $res );
         wp_die();  
      }

   }

}

// CHANGE PASSWORD
function atlantis_reset_password(){
   if( isset($_POST['action']) && $_POST['action'] == 'atlantis_reset_password' ){

      $password   = isset($_POST['password']) ? $_POST['password'] : '';
      $repassword = isset($_POST['repassword']) ? $_POST['repassword'] : '';
      $email      = isset($_POST['email']) ? $_POST['email'] : '';
      $code       = isset($_POST['code']) ? $_POST['code'] : '';

      if( is_email( $email ) == false ){
         wp_send_json_error([ 'message' => 'email_is_not_correct_format']);
         wp_die();
      }
      
      if( email_exists($email) == false ){
         wp_send_json_error([ 'message' => 'email_non_exists']);
         wp_die();
      }

      if( $password != $repassword){
         wp_send_json_error([ 'message' => 'password_is_not_match']);
         wp_die();
      }

      $get_code = get_transient( 'verification_code_' . $email );

      

      if( $get_code != $code ){
         wp_send_json_error([ 'message' => 'code_is_not_correct']);
         wp_die();
      }else{
         
         $get_id_user = get_user_by( 'email', $email )->data->ID;
         delete_transient( 'verification_code_' . $email );
         wp_set_password( $repassword, $get_id_user );
         wp_send_json_success([ 'message' => 'reset_password_ok' ]);
         wp_die();
      }

      wp_send_json_error([ 'message' => 'reset_password_error']);
      wp_die();
   }

}