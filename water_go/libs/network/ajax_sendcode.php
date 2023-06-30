<?php
// add_action( 'wp_ajax_nopriv_atlantis_code_verification', 'atlantis_code_verification' );
// add_action( 'wp_ajax_atlantis_code_verification', 'atlantis_code_verification' );

function _atlantis_send_code( $email ){
   $code = generate_verification_code();
   $get_code = set_transient( 'verification_code_' . $email, $code, 3600 ); // 1 hour
   wp_mail($email, 'Code Verifications', "Code Verification $code Expried for 1 hour.");
}

function atlantis_code_verification( $email, $event ){
   // if( isset($_POST['action']) && $_POST['action'] == 'atlantis_code_verification' ){

   $json = [];
   $json['message'] = '';
   
   // $email = isset($_POST['email']) ? $_POST['email'] : '';

   if( is_email( $email ) == false ){
      $json[ 'message' ] = 'email_is_not_correct_format';
   }

   // EMAIL-EXSITS EMAIL-NON-EXISTS
   // $event = isset($_POST['event']) ? $_POST['event'] : '';

   if( $event == '' || $email == ''){
      $json['message'] = 'verify_code_error';
   }

   if ( ! is_email( $email ) ){
      $json['message'] = 'error_email_format';
   }

   // CHECK EMAIL EXIST IN DATABASE
   if( $event == 'email_exists' ){
      if( email_exists($email) != false ){
         $json['message'] = 'sendcode_success';
         _atlantis_send_code($email);
         return $json;
      }else{
         $json['message'] = 'email_non_exists';
      }
   }
   
   // CHECK EMAIL NON EXIST IN DATABASE
   if( $event == 'email_non_exists' ){
      if( email_exists($email) == false ){
         $json['message'] = 'sendcode_success';
         _atlantis_send_code($email);
         return $json;
      }else{
         $json['message'] = 'email_already_exists';
      }
   }

   return $json;

   // }
}


add_action( 'wp_ajax_nopriv_atlantis_send_code_verification', 'atlantis_send_code_verification' );
add_action( 'wp_ajax_atlantis_send_code_verification', 'atlantis_send_code_verification' );

function atlantis_send_code_verification(){
   if( isset($_POST['action']) && $_POST['action'] == 'atlantis_send_code_verification'){
      
      $email = isset($_POST['email']) ? $_POST['email'] : '';
      $event = isset($_POST['event']) ? $_POST['event'] : '';

      $res = atlantis_code_verification($email, $event );

      if( $res['message'] == 'sendcode_success' ){
         wp_send_json_success( $res );
         wp_die();
      }else{
         wp_send_json_error( $res );
         wp_die();  
      }
      
   }
}