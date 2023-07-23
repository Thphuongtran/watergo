<?php


add_action( 'wp_ajax_nopriv_atlantis_user_notification', 'atlantis_user_notification' );
add_action( 'wp_ajax_atlantis_user_notification', 'atlantis_user_notification' );

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

add_action( 'wp_ajax_nopriv_atlantis_get_both_user_messenger', 'atlantis_get_both_user_messenger' );
add_action( 'wp_ajax_atlantis_get_both_user_messenger', 'atlantis_get_both_user_messenger' );

add_action( 'wp_ajax_nopriv_atlantis_user_delivery_address', 'atlantis_user_delivery_address' );
add_action( 'wp_ajax_atlantis_user_delivery_address', 'atlantis_user_delivery_address' );

add_action( 'wp_ajax_nopriv_atlantis_user_change_delivery_address_quick', 'atlantis_user_change_delivery_address_quick' );
add_action( 'wp_ajax_atlantis_user_change_delivery_address_quick', 'atlantis_user_change_delivery_address_quick' );

add_action( 'wp_ajax_nopriv_atlantis_user_get_avatar', 'atlantis_user_get_avatar' );
add_action( 'wp_ajax_atlantis_user_get_avatar', 'atlantis_user_get_avatar' );

add_action( 'wp_ajax_nopriv_atlantis_is_user_login_social', 'atlantis_is_user_login_social' );
add_action( 'wp_ajax_atlantis_is_user_login_social', 'atlantis_is_user_login_social' );

add_action( 'wp_ajax_nopriv_atlantis_get_current_user_id', 'atlantis_get_current_user_id' );
add_action( 'wp_ajax_atlantis_get_current_user_id', 'atlantis_get_current_user_id' );

add_action( 'wp_ajax_nopriv_atlantis_get_user_notification', 'atlantis_get_user_notification' );
add_action( 'wp_ajax_atlantis_get_user_notification', 'atlantis_get_user_notification' );

function atlantis_get_user_notification(){
   if( isset($_POST['action']) && $_POST['action'] == 'atlantis_get_user_notification' ){

      $user_id = get_current_user_id();
      $value   = get_field('user_notification', 'user_' . $user_id );

      wp_send_json_success([ 'message' => 'get_notification_ok', 'data' => $value ]);
      wp_die();
   }
}


function atlantis_user_notification(){
   if( isset($_POST['action']) && $_POST['action'] == 'atlantis_user_notification' ){

      if(is_user_logged_in() == true ){
         $user_id = get_current_user_id();
         $user = get_user_by('id', $user_id);
         $prefix_user = 'user_' . $user->data->ID;
      }else{
         wp_send_json_error(['message' => 'no_Login_invalid' ]);
         wp_die();
      }
      $value = isset($_POST['notification']) ? $_POST['notification'] : 0;
      update_field('user_notification', $value, 'user_' . $user_id );
      wp_send_json_success([ 'message' => 'update_notification_ok', 'data' => $value ]);
      wp_die();
   }
}

// FOR ONLY USER LOGIN
function atlantis_get_current_user_id(){
   if( isset($_POST['action']) && $_POST['action'] == 'atlantis_get_current_user_id'){

      if(is_user_logged_in() == true ){
         $user_id = get_current_user_id();
         $is_user_store = get_user_meta($user_id , 'user_store', true) != '' 
         ? (int) get_user_meta($user_id , 'user_store', true) 
         : null;

         $res = [
            'user_id' => $user_id,
            'is_user_store' => $is_user_store
         ];

         wp_send_json_success(['message' => 'get_current_user_ok', 'data' => $res ]);
         wp_die();

      }else{
         wp_send_json_error(['message' => 'no_login_invalid' ]);
         wp_die();
      }  

   }
}



function atlantis_is_user_login_social(){

   if( isset($_POST['action']) && $_POST['action'] == 'atlantis_is_user_login_social'){

      if(is_user_logged_in() == true ){
         $user_id = get_current_user_id();
         $user = get_user_by('id', $user_id);
         $prefix_user = 'user_' . $user->data->ID;
      }else{
         wp_send_json_error(['message' => 'no_login_invalid' ]);
         wp_die();
      }

      $is_user_login_social = get_user_meta( $user_id , 'user_login_social', true) != '' 
         ? (int) get_user_meta($user_id , 'user_login_social', true) 
         : 0;

      if( $is_user_login_social == 1 || $is_user_login_social == true ){
         wp_send_json_success([ 'message' => 'user_login_social' ]);
         wp_die();
      }

      wp_send_json_error(['message' => 'user_login_normal' ]);
      wp_die();

      
   }

}

/**
 * @access CHANGE QUICKLY DEFAULT DELIVERY ADDRESS by user_id and delivery_id
 */
function atlantis_user_change_delivery_address_quick(){
   if( isset($_POST['action']) && $_POST['action'] == 'atlantis_user_change_delivery_address_quick' ){

      if(is_user_logged_in() == true ){
         $user_id = get_current_user_id();
         $user = get_user_by('id', $user_id);
         $prefix_user = 'user_' . $user->data->ID;
      }else{
         wp_send_json_error(['message' => 'no_login_invalid' ]);
         wp_die();
      }

      $delivery_address_id = isset( $_POST['delivery_address_id'] ) ? $_POST['delivery_address_id'] : 0;

      $sql_is_already_default = "SELECT wp_delivery_address.primary FROM wp_delivery_address 
         WHERE user_id = $user_id AND id = $delivery_address_id";

      global $wpdb;
      $check_default = $wpdb->get_results( $sql_is_already_default );

      if( empty( $check_default )){
         wp_send_json_error(['message' => 'delivery_address_not_found' ]);
         wp_die();
      }

      if( $check_default[0]->primary == 1 ){
         wp_send_json_success([ 'message' => 'delivery_address_already_primary']);
         wp_die();
      }

      // TOGGLE ALL TO FALSE
      $wpdb->update('wp_delivery_address', [ 'primary' => 0], ['user_id' => $user_id]);

      // SET PRIMARY
      $updated = $wpdb->update('wp_delivery_address', [ 'primary' => 1], ['user_id' => $user_id, 'id' => $delivery_address_id]);

      if( $updated ){
         wp_send_json_success([ 'message' => 'delivery_address_primary_ok']);
         wp_die();
      }
         wp_send_json_error(['message' => 'delivery_address_not_found' ]);
         wp_die();
   }
}


function atlantis_user_delivery_address(){
   if( isset($_POST['action']) && $_POST['action'] == 'atlantis_user_delivery_address' ){
      $name    = isset($_POST['name']) ? $_POST['name'] : '';
      $phone   = isset($_POST['phone']) ? $_POST['phone'] : '';
      $address = isset($_POST['address']) ? $_POST['address'] : '';
      $primary = isset($_POST['primary']) ? $_POST['primary'] : '';
      $id_delivery = isset($_POST['id_delivery']) ? $_POST['id_delivery'] : '';
      $event   = isset($_POST['event']) ? $_POST['event'] : '';

      $latitude = isset($_POST['latitude']) ? $_POST['latitude'] : 0;
      $longitude = isset($_POST['longitude']) ? $_POST['longitude'] : 0;


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
         $sql = "SELECT * FROM wp_delivery_address WHERE user_id= {$user_id}";
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
               'primary' => $primary,
               'latitude' => $latitude,
               'longitude' => $longitude
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
               'primary' => $primary,
               'latitude' => $latitude,
               'longitude' => $longitude
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

         $delivery_address = $wpdb->get_results("SELECT * FROM wp_delivery_address WHERE user_id= $user_id");

         $user_notification = get_field('user_notification', 'user_' . $user_id, true) == 1 ? 1 : 0;

         $user_language = get_field('user_language', 'user_' . $user_id, true) != '' ? get_field('user_language', 'user_' . $user_id, true) : '';

         $final = [
            'user_notification' => $user_notification,
            'user_language' => $user_language,
            'user_login' => $user->data->user_login,
            'user_id' => $user->data->ID,
            'user_email' => $user->data->user_email,
            'first_name' => $first_name,
            'delivery_address' => $delivery_address,
         ];

         $final['user_avatar'] = func_atlantis_get_images($user->data->ID, 'user_avatar', true);


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
         wp_send_json_error([ 'message' => 'no_Login_valid' ]);
         wp_die();
      }

      $name   = isset($_POST['name']) ? $_POST['name'] : '';
      $email  = isset($_POST['email']) ? $_POST['email'] : '';
      $avatar = isset($_FILES['avatar']) ? $_FILES['avatar'] : null;
      
      $update_data = [];

      if( $name != '' ){
         $update_data['first_name'] = $name;
      }
      if( $email != '' ){
         $update_data['user_email'] = $email;

         if( ! is_email($email)){
            wp_send_json_success([ 'message' => 'email_is_not_correct_format' ]);
            wp_die();
         }

      }



      // UDDATE AVATAR
      // check attachment user
      if( $avatar != null ){
         global $wpdb;
         $check_atttachment_user = $wpdb->get_results("SELECT * FROM wp_watergo_attachment WHERE related_id = $user_id AND attachment_type = 'user_avatar' ");

         // upload
         if( empty($check_atttachment_user ) ){
            $attachment_id = func_atlantis_upload_no_ajax('user_avatar', $avatar);
            $wpdb->insert('wp_watergo_attachment', [
               'attachment_id'      => $attachment_id[0],
               'attachment_type'    => 'user_avatar',
               'related_id'         => $user_id 
            ]);

         // REPLACE UPLOAD
         }else{
            wp_delete_attachment($check_atttachment_user[0]->attachment_id, true);
            $attachment_id = func_atlantis_upload_no_ajax('user_avatar', $avatar);
            $wpdb->update('wp_watergo_attachment', [
               'attachment_id' => $attachment_id[0],
            ], [
               'related_id'      => $user_id,
               'attachment_type' => 'user_avatar'
            ]);

         }
      }
      


      if( !empty( $update_data ) ){
         $update_data['ID'] = $user_id;

         $email_exists = get_user_by('email', $email);
         $current_user = wp_get_current_user();

         if( $current_user->user_email != $email ){
            if( $email_exists == false ){
               wp_update_user($update_data);
            }else{
               wp_send_json_success([ 'message' => 'email_already_exists' ]);
               wp_die();   
            }
         }
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


      // full name
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
            'current_user_account'  => 
               $is_user_store == null || $is_user_store == false 
               ? 'user' : 'store'
         ] 
      ]);
      wp_die();

   }
}

/**
 * @access FOR CHAT MESSENGER [ get user role ]
 */
function atlantis_get_both_user_messenger(){
   if( isset($_POST['action']) && $_POST['action'] == 'atlantis_get_both_user_messenger' ){  

      $user_id  = isset($_POST['user_id'])   ? $_POST['user_id'] : 0;
      $store_id = isset($_POST['store_id'])  ? $_POST['store_id'] : 0;

      global $wpdb;

      $sql_user = "SELECT 
         user.ID as user_id,
         user.user_nicename,
         user.display_name,
         wp_usermeta.meta_value as first_name
         FROM wp_users as user
         LEFT JOIN wp_usermeta
         ON wp_usermeta.user_id = user.ID AND wp_usermeta.meta_key = 'first_name'
         WHERE user.ID = $user_id
      ";

      $sql_store = "SELECT id as store_id, name as store_name
         FROM wp_watergo_store
         WHERE id = $store_id
      ";

      $user_account  = $wpdb->get_results($sql_user);
      $user_account[0]->image = func_atlantis_get_images($user_id, 'user_avatar', true);

      $store_account = $wpdb->get_results($sql_store);
      $store_account[0]->image = func_atlantis_get_images($store_id, 'store', true);

      $account = [
         'user_account'    => $user_account[0],
         'store_account'   => $store_account[0]
      ];

      wp_send_json_success([ 'message' => 'user_ok', 'data' => $account ]);
      wp_die();


   }
}


/**
 * @access GET SINGLE RECORD DELIVERY ADDRESS
 */
add_action( 'wp_ajax_nopriv_atlantis_get_delivery_address_single', 'atlantis_get_delivery_address_single' );
add_action( 'wp_ajax_atlantis_get_delivery_address_single', 'atlantis_get_delivery_address_single' );
function atlantis_get_delivery_address_single(){
   if( isset($_POST['action']) && $_POST['action'] == 'atlantis_get_delivery_address_single'){

      $delivery_id = isset($_POST['delivery_id']) ? $_POST['delivery_id'] : 0;

      if( $delivery_id == 0){
         wp_send_json_error(['message' => 'get_delivery_address_error']);
         wp_die();
      }
      global $wpdb;
      $res = $wpdb->get_results("SELECT * FROM wp_delivery_address WHERE id = $delivery_id");
      if( empty($res)){
         wp_send_json_error(['message' => 'get_delivery_address_error']);
         wp_die();
      }
      wp_send_json_success(['message' => 'get_delivery_address_ok', 'data' => $res[0] ]);
      wp_die();
   }
}
/**
 * @access GET DELIVERY ADD PRIMARY
 */
add_action( 'wp_ajax_nopriv_atlantis_get_delivery_address_primary', 'atlantis_get_delivery_address_primary' );
add_action( 'wp_ajax_atlantis_get_delivery_address_primary', 'atlantis_get_delivery_address_primary' );
function atlantis_get_delivery_address_primary(){

   if( isset($_POST['action']) && $_POST['action'] == 'atlantis_get_delivery_address_primary'){

      if(is_user_logged_in() ){
         $user_id = get_current_user_id();
      }else{
         wp_send_json_error([ 'message' => 'no_login_invalid' ]);
         wp_die();
      }

      global $wpdb;
      $res = $wpdb->get_results("SELECT * FROM wp_delivery_address WHERE user_id = $user_id AND wp_delivery_address.primary = 1 ");
      if( empty($res)){
         wp_send_json_error(['message' => 'get_delivery_address_error']);
         wp_die();
      }
      wp_send_json_success(['message' => 'get_delivery_address_ok', 'data' => $res[0] ]);
      wp_die();
   }

}
