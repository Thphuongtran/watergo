<?php
add_action( 'wp_ajax_nopriv_atlantis_code_verification', 'atlantis_code_verification' );
add_action( 'wp_ajax_atlantis_code_verification', 'atlantis_code_verification' );

function atlantis_code_verification(){
   if( isset($_POST['action']) && $_POST['action'] == 'atlantis_code_verification' ){
      
      $email = isset($_POST['email']) ? $_POST['email'] : '';
   
      // if ( ! filter_var($email, FILTER_VALIDATE_EMAIL) ) {
      if ( ! is_email( $email ) ){
         wp_send_json_error(['message' => 'error_email_format', 'email' => $email]);
         wp_die();
      }
      // CHECK EMAIL EXIST IN DATABASE
      if( email_exists($email) != false ){
         wp_send_json_error(['message' => 'email_already_exists']);
         wp_die();
      }

      $code = generate_verification_code();
      $get_code = set_transient( 'verification_code_' . $email, $code, 3600 ); // 1 hour
      wp_mail($email, 'Code Verifications', "Code Verification $code Expried for 1 hour.");
      wp_send_json_success(['message' => 'sendcode_success']);
      wp_die();

   }
}