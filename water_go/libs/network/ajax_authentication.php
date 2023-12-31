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
      $email      = isset($_POST['email']) ? $_POST['email'] : '';
      $password   = isset($_POST['password']) ? $_POST['password'] : '';

      if( !is_email($email) && $email == '' && $password == ''  ){
         wp_send_json_error([ 'message' => 'login_error' ]);
         wp_die();
      }

      $user = get_user_by('email', $email);

      if( $user ){

         $user_id = $user->data->ID;

         $is_user_store = get_user_meta($user_id , 'user_store', true);
            
         if($is_user_store == true || $is_user_store == 1 ){
            wp_send_json_error([ 'message' => 'login_error' ]);
            wp_die();
         }
         
         // ACCOUNT DELETE
         $is_account_hidden = get_user_meta($user_id, 'account_hidden', true);

         if($is_account_hidden != "" && $is_account_hidden == 1){
            wp_send_json_error([ 'message' => 'account_delete' ]);
            wp_die();
         }
      }

      $user_login = wp_signon( [
         'user_login'    => $email,
         'user_password' => $password,
         'remember'      => true
      ]);

      // if(is_user_logged_in() == true ){
      //    $user_id = get_current_user_id();
      //    $user = get_user_by('id', $user_id);
      //    $prefix_user = 'user_' . $user->data->ID;
      // }

      if ( is_wp_error( $user_login ) ) {
         // authentication failed, display error message
         // $error_message = $user_login->get_error_message();
         wp_send_json_error([ 'message' => 'login_error' ]);
         wp_die();
      } else {
         // authentication succeeded, redirect to home page
         $user_id = $user_login->ID;
         wp_send_json_success([ 'message' => 'login_ok','token' => $user_id."|||".bj_render_nonce($user_id) ] );
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
      global $wpdb;
      $table = $wpdb->prefix."bj_user_push_token";  
      $wpdb->update($table , ["token" => "","status" => ""], ["user_id" => $user_id],["%s","%s"],["%d"]);
      
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
      
      if ( email_exists($email) ){
         wp_send_json_error([ 'message' => 'email_already_exists']);
         wp_die();
      }

      if(  username_exists( $username) !== false ){
         wp_send_json_error([ 'message' => 'user_exists']);
         wp_die();
      }
      
      if( $code == '' || $code == null || $code == 0 || $code != $get_code){
         wp_send_json_error([ 'message' => 'code_is_not_match']);
         wp_die();
      }

      if( !empty( $error ) ){
         wp_send_json_error([ 'message' => 'register_error']);
         wp_die();
      }

      // pass all
      delete_transient( 'verification_code_' . $email );
      $user_id = wp_insert_user( [
         'user_login' => $username,
         'user_pass'  => $password,
         'user_email' => $email,
         'first_name' => $username,
         'role'       => 'subscriber'
      ]);

      if ( ! is_wp_error( $user_id ) ) {
         wp_clear_auth_cookie();
         $user = wp_set_current_user($user_id);
         wp_set_auth_cookie($user_id,true,is_ssl());
         do_action('wp_login', $user->user_login, $user);               
         wp_send_json_success([ 'message' => 'register_ok','token' => $user_id."|||".bj_render_nonce($user_id) ]);           
      }     
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

/**
 * @access ACCESS FOR STORE USER
 */

add_action( 'wp_ajax_nopriv_atlantis_store_login', 'atlantis_store_login' );
add_action( 'wp_ajax_atlantis_store_login', 'atlantis_store_login' );

function atlantis_store_login(){
   if( isset($_POST['action']) && $_POST['action'] == 'atlantis_store_login' ){
      
      $email      = isset($_POST['email']) ? $_POST['email'] : '';
      $password   = isset($_POST['password']) ? $_POST['password'] : '';

      if( !is_email($email) && $email == '' && $password == ''  ){
         wp_send_json_error([ 'message' => 'login_error' ]);
         wp_die();
      }

      // USER MUST BE STORE USER

      $user = get_user_by('email', $email);
      $user_id = 0;

      if( $user ){

         $user_id = $user->data->ID;
         $is_user_store = get_user_meta($user_id , 'user_store', true) != '' 
            ? (int) get_user_meta($user_id , 'user_store', true) 
            : null;

         // ACCOUNT DELETE
         $is_account_hidden = get_user_meta($user_id, 'account_hidden', true) != ''
            ? (int) get_user_meta($user_id , 'account_hidden', true) 
            : null;

         if($is_account_hidden == true || $is_account_hidden == 1){
            wp_send_json_error([ 'message' => 'account_delete' ]);
            wp_die();
         }

         // THIS IS STORE USER
         if($is_user_store == true || $is_user_store == 1 ){
            // LOGIN

            $user_login = wp_signon( [
               'user_login'    => $email,
               'user_password' => $password,
               'remember'      => true
            ]);

            if ( is_wp_error( $user_login ) ) {
               wp_send_json_error([ 'message' => 'login_error' ]);
               wp_die();
            } else {
               // authentication succeeded, redirect to home page
               wp_send_json_success([ 'message' => 'login_ok','token' => $user_id."|||".bj_render_nonce($user_id) ]);
               wp_die();
            }

         }else{
            // EVEN current user but make it not store user
            wp_send_json_error([ 'message' => 'user_not_found' ]);
            wp_die();
         }
      // NO USER FOUND
      }else{
         // 
         wp_send_json_error([ 'message' => 'user_not_found' ]);
         wp_die();
      }
      wp_send_json_error([ 'message' => 'login_error' ]);
      wp_die();

   }

}



add_action( 'wp_ajax_nopriv_atlantis_store_register', 'atlantis_store_register' );
add_action( 'wp_ajax_atlantis_store_register', 'atlantis_store_register' );

function atlantis_store_register(){
   if( isset($_POST['action']) && $_POST['action'] == 'atlantis_store_register' ){

      $owner      = isset($_POST['owner']) ? $_POST['owner'] : '';
      $storeType  = isset($_POST['storeType']) ? $_POST['storeType'] : '';
      $storeName  = isset($_POST['storeName']) ? $_POST['storeName'] : '';
      $address    = isset($_POST['address']) ? $_POST['address'] : '';
      $phone      = isset($_POST['phone']) ? $_POST['phone'] : '';
      $email      = isset($_POST['email']) ? $_POST['email'] : '';
      $password   = isset($_POST['password']) ? $_POST['password'] : '';
      $code       = isset($_POST['code']) ? $_POST['code'] : '';
      
      $latitude   = isset($_POST['latitude']) ? $_POST['latitude']   : 10.780900239854994;
      $longitude  = isset($_POST['longitude']) ? $_POST['longitude'] : 106.7226271387539;

      if( $owner == '' && $storeName == '' && $address == '' && $phone == '' && $email == '' && $password == '' && $storeType == '' && $code == '' ){
         wp_json_send_error([ 'message' => 'all_field_empty' ]);
         wp_die();
      }

      // REMOVE ANY NON-DIGITAL NO UNNESESSORY
      $phone = preg_replace('/\D/', '', $phone);

      if ( preg_match('/^\d+$/', $phone) == false || (strlen($phone) >= 10 && strlen($phone) < 12) == false) {
         wp_send_json_error([ 'message' => 'phonenumber_is_not_correct_format']);
         wp_die();
      }

      if( is_email($email) == false ){
         wp_send_json_error([ 'message' => 'email_is_not_correct_format', 'phone_length' => strlen($phone)]);
         wp_die();
      }

      // CHECK IS EXISTS IN DATABASE OR NOT?
      if( email_exists( $email)  ){
         wp_send_json_error([ 'message' => 'email_already_exists']);
         wp_die();
      }

      // CHECK CODE VERIFY
      $get_code = get_transient( 'verification_code_' . $email );

      if( $code != $get_code ){
         wp_send_json_error([ 'message' => 'code_is_not_match']);
         wp_die();
      }else{
         // code ok -> delete
         delete_transient( 'verification_code_' . $email );
      }

      // INSERT USER
      $user_id = wp_insert_user([
         'user_login' => $email,
         'user_email' => $email,
         'user_pass'  => $password,
         'first_name' => $email,
         'role'       => 'subscriber'
      ]);


      if( ! $user_id ){
         wp_send_json_error([ 'message' => 'register_error_1']);
         wp_die();
      }

      // MAKE THIS USER TO STORE USER
      update_user_meta($user_id, 'user_store', true);

      // INSERT TO STORE DB
      global $wpdb;
      $store_id = $wpdb->insert('wp_watergo_store', [
         'store_type'   => $storeType,
         'owner'        => $owner,
         'name'         => $storeName,
         'address'      => $address,
         'phone'        => $phone,
         'user_id'      => $user_id, // same with id
         'latitude'     => $latitude,
         'longitude'    => $longitude
      ]);

      if( ! $store_id ){
         wp_send_json_error([ 'message' => 'register_error_2']);
         wp_die();
      }

      wp_clear_auth_cookie();
      $user = wp_set_current_user($user_id);
      wp_set_auth_cookie($user_id,true,is_ssl());
      do_action('wp_login', $user->user_login, $user);

      wp_send_json_success([ 'message' => 'register_ok','token' => $user_id."|||".bj_render_nonce($user_id) ]);
      wp_die();


   }

}

/**
 * @access REGISTER STORE WITH NO CODE VERIFY
 */
add_action( 'wp_ajax_nopriv_atlantis_store_register_from_admin', 'atlantis_store_register_from_admin' );
add_action( 'wp_ajax_atlantis_store_register_from_admin', 'atlantis_store_register_from_admin' );

function atlantis_store_register_from_admin(){
   if( isset($_POST['action']) && $_POST['action'] == 'atlantis_store_register_from_admin' ){

      $owner      = isset($_POST['owner']) ? $_POST['owner'] : '';
      $storeType  = isset($_POST['storeType']) ? $_POST['storeType'] : '';
      $storeName  = isset($_POST['storeName']) ? $_POST['storeName'] : '';
      $address    = isset($_POST['address']) ? $_POST['address'] : '';
      $phone      = isset($_POST['phone']) ? $_POST['phone'] : '';
      $email      = isset($_POST['email']) ? $_POST['email'] : '';
      $password   = isset($_POST['password']) ? $_POST['password'] : '';
      $description  = isset($_POST['description']) ? $_POST['description'] : '';
      
      $latitude   = isset($_POST['latitude']) ? $_POST['latitude']   : 10.780900239854994;
      $longitude  = isset($_POST['longitude']) ? $_POST['longitude'] : 106.7226271387539;

      $imageUpload   = isset($_FILES['imageUpload']) ? $_FILES['imageUpload'] : null;


      if( $description == '' && $owner == '' && $storeName == '' && $address == '' && $phone == '' && $email == '' && $password == '' && $storeType == ''){
         wp_json_send_error([ 'message' => 'all_field_empty' ]);
         wp_die();
      }

      // REMOVE ANY NON-DIGITAL NO UNNESESSORY
      // $phone = preg_replace('/\D/', '', $phone);

      $phone = str_replace(array('-', '.', ' '), '', $phone);
      $is_phone =  preg_match( '/^(032|033|034|035|036|037|038|039|086|096|097|098|081|082|083|084|085|088|091|094|056|058|092|070|076|077|078|079|089|090|093|099|059)+([0-9]{7})$/', $phone);

      if ( !$is_phone) {
         wp_send_json_error([ 'message' => 'phonenumber_is_not_correct_format']);
         wp_die();
      }

      if ( preg_match('/^\d+$/', $phone) == false || (strlen($phone) >= 10 && strlen($phone) < 12) == false) {
         wp_send_json_error([ 'message' => 'phonenumber_is_not_correct_format']);
         wp_die();
      }

      if( is_email($email) == false ){
         wp_send_json_error([ 'message' => 'email_is_not_correct_format' ]);
         wp_die();
      }

      // CHECK IS EXISTS IN DATABASE OR NOT?
      if( email_exists( $email)  ){
         wp_send_json_error([ 'message' => 'email_already_exists']);
         wp_die();
      }

      // INSERT USER
      $user_id = wp_insert_user([
         'user_login' => $email,
         'user_email' => $email,
         'user_pass'  => $password,
         'first_name' => $email,
         'role'       => 'subscriber'
      ]);

      if( ! $user_id ){
         wp_send_json_error([ 'message' => 'register_error_1']);
         wp_die();
      }

      // MAKE THIS USER TO STORE USER
      update_user_meta($user_id, 'user_store', true);

      // INSERT TO STORE DB
      global $wpdb;
      $store_register = $wpdb->insert('wp_watergo_store', [
         'store_type'   => $storeType,
         'owner'        => $owner,
         'name'         => $storeName,
         'description'  => $description,
         'address'      => $address,
         'phone'        => $phone,
         'user_id'      => $user_id, // same with id
         'latitude'     => $latitude,
         'longitude'    => $longitude
      ]);

      $store_id = $wpdb->insert_id;

      // wp_send_json_success(['message' => 'bug', 'test' => $store_id]);
      // wp_die();

      if( $imageUpload != null ){
         // FIND IMAGE AND REPLACE
         $sql_find_attachment = "SELECT * FROM wp_watergo_attachment WHERE related_id = $store_id AND attachment_type = 'store' ";
         $attachment_exists = $wpdb->get_results( $sql_find_attachment );

         if( !empty($attachment_exists) ){
            wp_delete_attachment($attachment_exists[0]->attachment_id, true);
            $wpdb->delete('wp_watergo_attachment',[ 'attachment_id' => $attachment_exists[0]->attachment_id ], [ '%d' ]);
         }

         $attachment_id = func_atlantis_upload_no_ajax('store', $imageUpload);
         if($attachment_id != null || !empty( $attachment_id ) ){
            $wpdb->insert('wp_watergo_attachment', [
               'attachment_id'   => $attachment_id[0],
               'related_id'      => $store_id,
               'attachment_type' => 'store'
            ]);
         }
      }

      if( ! $store_register ){
         wp_send_json_error([ 'message' => 'register_error_2']);
         wp_die();
      }

      wp_send_json_success([ 'message' => 'register_ok']);
      wp_die();

   }
}
