<?php

add_action( 'wp_ajax_nopriv_atlantis_get_user_by_field', 'atlantis_get_user_by_field' );
add_action( 'wp_ajax_atlantis_get_user_by_field', 'atlantis_get_user_by_field' );

add_action( 'wp_ajax_nopriv_atlantis_get_user_login_data', 'atlantis_get_user_login_data' );
add_action( 'wp_ajax_atlantis_get_user_login_data', 'atlantis_get_user_login_data' );

add_action( 'wp_ajax_nopriv_atlantis_update_user', 'atlantis_update_user' );
add_action( 'wp_ajax_atlantis_update_user', 'atlantis_update_user' );

add_action( 'wp_ajax_nopriv_atlantis_user_language', 'atlantis_user_language' );
add_action( 'wp_ajax_atlantis_user_language', 'atlantis_user_language' );

add_action( 'wp_ajax_nopriv_atlantis_user_change_password', 'atlantis_user_change_password' );
add_action( 'wp_ajax_atlantis_user_change_password', 'atlantis_user_change_password' );

add_action( 'wp_ajax_nopriv_atlantis_user_delete_account', 'atlantis_user_delete_account' );
add_action( 'wp_ajax_atlantis_user_delete_account', 'atlantis_user_delete_account' );

add_action( 'wp_ajax_nopriv_atlantis_get_user', 'atlantis_get_user' );
add_action( 'wp_ajax_atlantis_get_user', 'atlantis_get_user' );

add_action( 'wp_ajax_nopriv_atlantis_get_current_user_account', 'atlantis_get_current_user_account' );
add_action( 'wp_ajax_atlantis_get_current_user_account', 'atlantis_get_current_user_account' );

add_action( 'wp_ajax_nopriv_atlantis_user_delivery_address', 'atlantis_user_delivery_address' );
add_action( 'wp_ajax_atlantis_user_delivery_address', 'atlantis_user_delivery_address' );


function atlantis_user_delivery_address(){
   if( isset($_POST['action']) && $_POST['action'] == 'atlantis_user_delivery_address' ){
      $name    = isset($_POST['name']) ? $_POST['name'] : '';
      $phone   = isset($_POST['phone']) ? $_POST['phone'] : '';
      $address = isset($_POST['address']) ? $_POST['address'] : '';
      $primary = isset($_POST['primary']) ? $_POST['primary'] : '';
      $id_delivery = isset($_POST['id_delivery']) ? $_POST['id_delivery'] : '';
      $event   = isset($_POST['event']) ? $_POST['event'] : '';


      if(is_user_logged_in() == true ){
         $user_id = get_current_user_id();
         $user = get_user_by('id', $user_id);
         $prefix_user = 'user_' . $user->data->ID;
      }else{
         wp_send_json_error(['message' => 'no_login_invalid' ]);
         wp_die();
      }

      $conditions = [
         'id'        => $id_delivery,
         'user_id'   => $user_id
      ];

      if( $event == '' ){
         wp_send_json_error([ 'message' => 'delivery_address_service_error' ]);
         wp_die();
      }

      global $wpdb;

      // GET EVENT

      if( $event == 'get' ){
         $sql = "SELECT * FROM wp_delivery_address WHERE user_id={$user_id}";
         $res = $wpdb->get_results($sql);
         if( empty( $res )){
            wp_send_json_error([ 'message' => 'no_delivery_address_service_found' ]);
            wp_die();
         }else{
            wp_send_json_success([ 'message' => 'get_delivery_address_ok', 'data' => $res ]);
            wp_die();  
         }
      }

      // ADD EVENT
      if( $event == 'add' ){
         if( $name != '' && $phone != '' && $address != '' ){

            // IF SET PRIMARY TO 1
            if( $primary == 1 || $primary == "1" ){
               $sql_set_primary_all_false = "UPDATE wp_delivery_address SET wp_delivery_address.primary = 0 WHERE user_id = {$user_id}";
               $wpdb->query($sql_set_primary_all_false);
            }

            $args = [
               'name' => $name,
               'phone' => $phone,
               'address' => $address,
               'user_id' => $user_id,
               'primary' => $primary 
            ];
            $add_id = $wpdb->insert('wp_delivery_address', $args);
         }

         wp_send_json_success([ 'message' => 'add_delivery_address_ok', 'data' => $add_id ]);
         wp_die();
      }

      // UPDATE EVENT
      if( $event == 'update' ){
         if( $name != '' && $phone != '' && $address != '' ){
            // IF SET PRIMARY TO 1
            if( $primary == 1 || $primary == "1" ){
               $sql_set_primary_all_false = "UPDATE wp_delivery_address SET wp_delivery_address.primary = 0 WHERE user_id = {$user_id}";
               $wpdb->query($sql_set_primary_all_false);
            }
            $args = [
               'name' => $name,
               'phone' => $phone,
               'address' => $address,
               'primary' => $primary 
            ];
            $wpdb->update('wp_delivery_address', $args, $conditions );
         }
  
         wp_send_json_success(['message' => 'update_delivery_address_ok', 'data' => $args ]);
         wp_die();
      }

      // DELETE EVENT
      if( $event == 'delete' ){
         if( $id_delivery == '' ){
            wp_send_json_error([ 'message' => 'delete_delivery_address_error' ]);
            wp_die();
         }
         $wpdb->delete('wp_delivery_address', $conditions );
         // DELETE
         wp_send_json_success([ 'message' => 'delete_delivery_address_ok' ]);
         wp_die();
      }

   }
}


function atlantis_get_user_by_field(){
   if( isset( $_POST['action'] ) && $_POST['action'] == 'atlantis_get_user_by_field' ){
      if(is_user_logged_in() == false ){
         wp_send_json_error([ 'message' => 'user_not_found 1' ]);
         wp_die();
      }
      $field = isset($_POST['field']) ? $_POST['field'] : '';
      $allow_field = ['email', 'delivery_address'];

      if( ! in_array( $field, $allow_field ) ){
         wp_send_json_error([ 'message' => 'user_not_found 2' ]);
         wp_die();
      }
      
      global $wpdb;
      $user_id = get_current_user_id();
      $sql = "SELECT * FROM wp_delivery_address WHERE user_id={$user_id}";
      $get_results = $wpdb->get_results($sql);
      if( empty( $get_results ) ){
         wp_send_json_error([ 'message' => 'delivery_address_not_found' ]);
         wp_die();
      }else{
         wp_send_json_success(['message' => 'delivery_address_found', 'data' => $get_results ]);
         wp_die();
      }
   }
}


function atlantis_get_user_login_data(){
   if( isset($_POST['action']) && $_POST['action'] == 'atlantis_get_user_login_data' ){

      if(is_user_logged_in() == true ){
         global $wpdb;

         $user_id = get_current_user_id();
         $user = get_user_by('id', $user_id);
         $prefix_user = 'user_' . $user->data->ID;

         $first_name = get_user_meta($user->data->ID, 'first_name', true) != '' 
            ? get_user_meta($user->data->ID, 'first_name', true) 
            : '';
         $avatar = get_field('user_avatar', $prefix_user, true);
         if( $avatar == '' ){
            $avatar = THEME_URI . '/assets/images/avatar-dummy.png';
         }

         $delivery_address = $wpdb->get_results("SELECT * FROM wp_delivery_address WHERE user_id={$user_id}");

         $user_notification = get_field('user_notification', 'user_' . $user_id, true) == 1 ? 1 : 0;

         $user_language = get_field('user_language', 'user_' . $user_id, true) != '' ? get_field('user_language', 'user_' . $user_id, true) : '';

         $final = [
            'user_notification' => $user_notification,
            'user_language' => $user_language,
            'user_login' => $user->data->user_login,
            'user_id' => $user->data->ID,
            'user_email' => $user->data->user_email,
            'first_name' => $first_name,
            'avatar' => $avatar,
            'delivery_address' => $delivery_address,
         ];

         wp_send_json_success([ 'message' => 'user_found', 'data' => $final ]);
         wp_die();

      }else{
         wp_send_json_error([ 'message' => 'user_not_found' ]);
         wp_die();
      }
   }
}

function atlantis_update_user(){

   if( isset($_POST['action']) && $_POST['action'] == 'atlantis_update_user' ){
      $user_id = null;

      if( is_user_logged_in() == true ){
         $user_id = get_current_user_id();
         $prefix_user = 'user_' . $user_id;
      }else{
         wp_send_json_error([ 'err' => true, 'message' => 'no_Login_calid' ]);
         wp_die();
      }

      // PROTECT USER ID
      $secure_user_id = md5( md5($user_id) . 'watergo' );

      $name   = isset($_POST['name']) ? $_POST['name'] : '';
      $email  = isset($_POST['email']) ? $_POST['email'] : '';
      $avatar = isset($_FILES['avatar']) ? $_FILES['avatar'] : null;

      $uploadDirectory = THEME_DIR . '/uploads/' . $secure_user_id . '/' ;

      if( !is_dir($uploadDirectory) ){
         mkdir($uploadDirectory, 0755, true);
      }

      // check folder exists or not
      if ( $avatar != null && $avatar['error'] === UPLOAD_ERR_OK) {
         $fileTmpPath      = $avatar['tmp_name'];
         $fileName         = $avatar['name'];
         $extension        = pathinfo($fileName, PATHINFO_EXTENSION);
         $finalPath        = $uploadDirectory . 'avatar.' . $extension;
         move_uploaded_file($fileTmpPath, $finalPath);

         $pathUrl = THEME_URI . '/uploads/' . $secure_user_id . '/avatar.' . $extension;

         // Save to Custom field user
         update_field( 'user_avatar', $pathUrl, 'user_'. $user_id );
      }
      
      $update_data = [];

      if( $name != '' ){
         $update_data['first_name'] = $name;
      }
      if( $email != '' ){
         $update_data['user_email'] = $email;
      }

      if( !empty( $update_data ) ){
         $update_data['ID'] = $user_id;
         wp_update_user($update_data);
      }
      
      wp_send_json_success([ 'message' => 'update_user_ok' ]);
      wp_die();
   }
}


function atlantis_user_language(){
   if( isset($_POST['action']) && $_POST['action'] == 'atlantis_user_language' ){

      $event = isset($_POST['event']) ? $_POST['event'] : 'get';
      if(is_user_logged_in() == true ){
         $user_id = get_current_user_id();
         $user = get_user_by('id', $user_id);
         $prefix_user = 'user_' . $user->data->ID;
      }else{
         wp_send_json_error([ 'message' => 'no_login_invalid' ]);
         wp_die();
      }

      if( $event == 'get'){
         $user_language = get_field('user_language', 'user_' . $user_id, true) != '' ? get_field('user_language', 'user_' . $user_id, true) : '';
         wp_send_json_success([ 'message' => 'get_user_language_ok', 'data' => $user_language ]);
      }else if($event == 'update' ){
         $language = isset($_POST['language']) ? $_POST['language'] : '';
         update_field('user_language', $language, 'user_' . $user_id );
         wp_send_json_success([ 'message' => 'update_language_ok', 'data' => $value ]);
      }
      wp_die();

   }

}

function atlantis_user_change_password(){
   if( isset($_POST['action']) && $_POST['action'] == 'atlantis_user_change_password' ){
      $current_password = isset($_POST['current_password']) ? $_POST['current_password'] : '';
      $new_password     = isset($_POST['new_password']) ? $_POST['new_password'] : '';
      $confirm_password = isset($_POST['confirm_password']) ? $_POST['confirm_password'] : '';

      if(is_user_logged_in() == true ){
         $user_id = get_current_user_id();
         $user = get_user_by('id', $user_id);
         $prefix_user = 'user_' . $user->data->ID;
      }else{
         wp_send_json_error([ 'message' => 'no_login_invalid' ]);
         wp_die();
      }

      $is_password_correct = wp_check_password($current_password, $user->user_pass, $user_id);

      if ($is_password_correct == false) {
         wp_send_json_error([ 'message' => 'current_password_is_not_correct'] );
         wp_die();
      }

      if($current_password == '' || $new_password == '' || $confirm_password == ''){
         wp_send_json_error([ 'message' => 'field_must_not_empty' ]);
         wp_die();
      }

      if( $new_password !== $confirm_password ){
         wp_send_json_error([ 'message' => 'password_is_not_same' ]);
         wp_die();
      }
      wp_set_password($new_password, $user_id);

      $credentials = array(
         'user_login'    => $user->user_login,
         'user_password' => $new_password,
         'remember'      => true,
      );
      
      wp_signon($credentials);
      wp_send_json_success([ 'message' => 'user_change_password_ok', 'data' => $user ]);
      wp_die();
   }

}

function atlantis_user_delete_account(){
   if( isset($_POST['action']) && $_POST['action'] == 'atlantis_user_change_password' ){

   }
}


function atlantis_user_get_avatar(){
   if( isset($_POST['action']) && $_POST['action'] == 'atlantis_user_get_avatar' ){
      $user_id = isset($_POST['user_id']) ? $_POST['user_id'] : '';

      global $wpdb;
      $sql = "SELECT url as user_image FROM wp_watergo_photo WHERE upload_by = $user_id AND kind_photo = 'user_avatar' LIMIT 1";
      $res = $wpdb->get_results($sql);

      if( empty( $res ) ){
         wp_send_json_error([ 'message' => 'user_not_found' ]);
         wp_die();
      }

      wp_send_json_success([ 'message' => 'user_avatar_ok', 'data' => $res[0]->user_image ]);
      wp_die();
   }
}


function atlantis_get_user(){
   if( isset($_POST['action']) && $_POST['action'] == 'atlantis_get_user' ){  
      
      $user_id = isset($_POST['user_id']) ? $_POST['user_id'] : 0;

      if( $user_id == 0 ){
         if(is_user_logged_in() == true ){
            $user_id = get_current_user_id();
            $user = get_user_by('id', $user_id);
            $prefix_user = 'user_' . $user->data->ID;
         }else{
            wp_send_json_error([ 'message' => 'no_login_invalid' ]);
            wp_die();
         }
      }else{
         if(is_user_logged_in() == true ){
            $user = get_user_by('id', $user_id);
            $prefix_user = 'user_' . $user->data->ID;
         }else{
            wp_send_json_error([ 'message' => 'no_login_invalid' ]);
            wp_die();
         }
      }

      // $hash_protect = md5( md5( $user_id . '-user') . 'watergo' );

      // GET AVATAR USER
      global $wpdb;
      $sql = "SELECT url as user_image FROM wp_watergo_photo WHERE upload_by = $user_id AND kind_photo = 'user_avatar' LIMIT 1";
      $res = $wpdb->get_results($sql);

      $avatar = !empty($res) 
         ? $res[0]->user_image 
         : 'avatar-dummy.png';

      // fake full name
      $first_name = get_user_meta($user->data->ID, 'first_name', true);

      if( empty( $user ) ){
         wp_send_json_error([ 'message' => 'user_not_found' ]);
         wp_die();
      }

      $is_user_store = get_user_meta($user_id , 'user_store', true) != '' 
         ? (int) get_user_meta($user_id , 'user_store', true) 
         : null;

      wp_send_json_success([ 'message' => 'user_ok', 'data' => 
         [
            'user_id'               => $user_id,
            'user_fullname'         => 
               $first_name != '' 
               ? $first_name : $user->data->display_name,
            'user_image'            => $avatar,
            'current_user_account'  => 
               $is_user_store == null || $is_user_store == false 
               ? 'user' : 'store'
         ] 
      ]);
      wp_die();

   }
}


function atlantis_get_current_user_account(){
   if( isset($_POST['action']) && $_POST['action'] == 'atlantis_get_current_user_account' ){  

      if(is_user_logged_in() == true ){
         $user_id = get_current_user_id();
         $user = get_user_by('id', $user_id);
         $prefix_user = 'user_' . $user->data->ID;
      }else{
         wp_send_json_error([ 'message' => 'no_login_invalid' ]);
         wp_die();
      }
      $get_account_user = get_user_meta($user_id , 'user_store', true);

      $is_user_store = 'user';
      if($get_account_user == null || $get_account_user == 0){
         $is_user_store = 'user';
      }
      if($get_account_user == true || $get_account_user == 1){
         $is_user_store = 'store';
      }

      $user = [
         'user_id'      => $user_id,
         'user_account' => $is_user_store
      ];

      wp_send_json_success([ 'message' => 'user_ok', 'data' => $user ]);
      wp_die();


   }
}