<?php

add_action( 'wp_ajax_nopriv_atlantis_load_post', 'atlantis_load_post' );
add_action( 'wp_ajax_atlantis_load_post', 'atlantis_load_post' );

add_action( 'wp_ajax_nopriv_atlantis_fetch_category', 'atlantis_fetch_category' );
add_action( 'wp_ajax_atlantis_fetch_category', 'atlantis_fetch_category' );

add_action( 'wp_ajax_nopriv_atlantis_code_verification', 'atlantis_code_verification' );
add_action( 'wp_ajax_atlantis_code_verification', 'atlantis_code_verification' );

add_action( 'wp_ajax_nopriv_atlantis_check_useremail', 'atlantis_check_useremail' );
add_action( 'wp_ajax_atlantis_check_useremail', 'atlantis_check_useremail' );

add_action( 'wp_ajax_nopriv_atlantis_register_user', 'atlantis_register_user' );
add_action( 'wp_ajax_atlantis_register_user', 'atlantis_register_user' );

add_action( 'wp_ajax_nopriv_atlantis_reset_password', 'atlantis_reset_password' );
add_action( 'wp_ajax_atlantis_reset_password', 'atlantis_reset_password' );

add_action( 'wp_ajax_nopriv_atlantis_login', 'atlantis_login' );
add_action( 'wp_ajax_atlantis_login', 'atlantis_login' );

add_action( 'wp_ajax_nopriv_atlantis_get_user_tokens', 'atlantis_get_user_tokens' );
add_action( 'wp_ajax_atlantis_get_user_tokens', 'atlantis_get_user_tokens' );

add_action( 'wp_ajax_nopriv_atlantis_update_user', 'atlantis_update_user' );
add_action( 'wp_ajax_atlantis_update_user', 'atlantis_update_user' );

add_action( 'wp_ajax_nopriv_atlantis_user_delivery_address', 'atlantis_user_delivery_address' );
add_action( 'wp_ajax_atlantis_user_delivery_address', 'atlantis_user_delivery_address' );

add_action( 'wp_ajax_nopriv_atlantis_user_delivery_selected', 'atlantis_user_delivery_selected' );
add_action( 'wp_ajax_atlantis_user_delivery_selected', 'atlantis_user_delivery_selected' );

add_action( 'wp_ajax_nopriv_atlantis_testing', 'atlantis_testing' );
add_action( 'wp_ajax_atlantis_testing', 'atlantis_testing' );

function atlantis_get_total_posts(){
   $query = new WP_Query([
      'post_type'       => 'post',
      'post_status'     => 'publish',
      'posts_per_page'  => -1, // get all posts
   ]);
   return $query->post_count;
}

function atlantis_get_total_pages($total_posts, $posts_per_page){
   return ceil($total_posts / $posts_per_page);
}

function atlantis_load_post(){
   sleep(1); // waiting for one second
   if( isset( $_POST['action'] ) && $_POST['action'] == 'atlantis_load_post' ){
      $posts_per_page = isset($_POST['posts_per_page']) ? $_POST['posts_per_page'] : 10;
      $paged = isset($_POST['paged']) ? $_POST['paged'] : 1;

      $total_posts = atlantis_get_total_posts();
      $total_pages = atlantis_get_total_pages($total_posts, $posts_per_page);

      if( $paged > $total_pages ){
         wp_send_json_error(['err' => true]);
         wp_die();
      }

      $query = new WP_Query([
         'post_type'       => 'post',
         'post_status'     => 'publish',
         'paged'           => $paged,
         'posts_per_page'  => $posts_per_page,
         'order'           => 'DESC',
      ]);

      $response = [];
      $posts = $query->get_posts();

      if (empty($posts)) {
         wp_send_json_error(['err' => true]);
         wp_die();
      }

      foreach ($posts as $post) {
         $get_category = get_the_category($post->ID);
         $category = [];
         if( !empty($get_category) ){
            $category['id']   = $get_category[0]->term_id;
            $category['name'] = $get_category[0]->name;
         }

         $response[] = [
            'id' => $post->ID,
            'title' => get_the_title($post->ID),
            'content' => get_the_content($post->ID),
            'category' => $category
         ];
      }
      wp_send_json_success([
         'err' => false,
         'data' => $response
      ]);
   }
}

function atlantis_fetch_category(){
   if( isset($_POST['action']) && $_POST['action'] == 'atlantis_fetch_category'){
      $terms = get_terms([
         'taxonomy'		=> 'category',
         'hide_empty'	=> false,
         'parent'			=> 0, // => GET TOP TAXONOMY
         'exclude'      => [1]
      ]);
      if( empty($terms)){
         wp_send_json_error(['err' => true]);
         wp_die();
      }else{
         $list = [];
         foreach($terms as $k => $vl ){
            $list[$k] = [
               'id'  => $vl->term_id,
               'name' => $vl->name
            ];
         }
         wp_send_json_success(['err' => false, 'data' => $list]);
         wp_die();
      }
   }
}

function atlantis_code_verification(){
   if( isset($_POST['action']) && $_POST['action'] == 'atlantis_code_verification' ){
      $event = isset($_POST['event']) ? $_POST['event'] : ''; // send | verify
      if($event == '') {
         wp_send_json_error(['err' => true, 'message' => 'Event Error']);
         wp_die();
      }
      $email = isset($_POST['email']) ? $_POST['email'] : '';
      if ( ! filter_var($email, FILTER_VALIDATE_EMAIL) && ! email_exists($email) ) {
         wp_send_json_error(['err' => true, 'message' => 'Email Error']);
         wp_die();
      }
      // check email exists in database
      // process event [send | verify ]
      if( $event == 'send'){
         $code = generate_verification_code();
         $get_code = set_transient( 'verification_code_' . $email, $code, 3600 ); // 1 hour
         wp_mail($email, 'Code Verifications', "Code Verification $code Expried for 1 hour.");
         wp_send_json_success(['err' => false, 'message' => 'Send Code Ok']);
         wp_die();
      }

      if( $event == 'verify'){
         $code = isset($_POST['code']) ? $_POST['code'] : 0;
         $get_code = get_transient( 'verification_code_' . $email );
         if( $code == '' || $code == null || $code == 0 || $code != $get_code){
            wp_send_json_error(['err' => true, 'message' => 'Verify Error']);
            wp_die();
         }
         if( $code == $get_code ){
            delete_transient( 'verification_code_' . $email );
            wp_send_json_success(['err' => false, 'message' => 'Verify Ok']);
            wp_die();
         }
      }

   }
}

// CHECK USER EMAIL => for user not exist in database
function atlantis_check_useremail(){
   if( isset($_POST['action']) && $_POST['action'] == 'atlantis_check_useremail' ){
      $email = isset($_POST['email']) ? $_POST['email'] : '';
      if ( ! filter_var($email, FILTER_VALIDATE_EMAIL) ){
         wp_send_json_error(['code' => 102, 'message' => 'Email Error']);
         wp_die();
      }else{
         if( email_exists($email) != false ){
            wp_send_json_success(['code' => 101, 'message' => 'Email Ok' ]);
            wp_die();
         }else{
            wp_send_json_error(['code' => 100, 'message' => 'Email Not Exists']);
            wp_die();
         }
      }
   }
}

function atlantis_register_user(){
   if( isset($_POST['action']) && $_POST['action'] == 'atlantis_register_user' ){

      $email      = isset($_POST['email'])  ? $_POST['email'] : '';
      $password   = isset($_POST['password']) ? $_POST['password'] : '';
      $username   = isset($_POST['username']) ? $_POST['username'] : '';
      $code       = isset($_POST['code']) ? $_POST['code'] : '';

      if ( ! filter_var($email, FILTER_VALIDATE_EMAIL) && email_exists($email) ){
         wp_send_json_error(['err' => true, 'message' => 'Email Error']);
         wp_die();
      }

      $get_code = get_transient( 'verification_code_' . $email );
      if( $code == '' || $code == null || $code == 0 || $code != $get_code){
         wp_send_json_error(['err' => true, 'message' => 'Verify Error']);
         wp_die();
      }
      
      if( $email != '' && $password != '' && $username != '' && $code == $get_code ){
         delete_transient( 'verification_code_' . $email );
         wp_create_user( $username, $password, $email );
         wp_send_json_success(['err' => false, 'message' => 'Register Ok' ]);
         wp_die();
      }else{
         wp_send_json_error(['err' => true, 'message' => 'Register Error']);
         wp_die();
      }

   }
}

function atlantis_reset_password(){
   if( isset($_POST['action']) && $_POST['action'] == 'atlantis_reset_password' ){
      $password   = isset($_POST['password']) ? $_POST['password'] : '';
      $repassword = isset($_POST['repassword']) ? $_POST['repassword'] : '';
      $email = isset($_POST['email']) ? $_POST['email'] : '';

      if ( ! filter_var($email, FILTER_VALIDATE_EMAIL) && email_exists($email) == false ){
         wp_send_json_error(['err' => true, 'message' => 'Email Error']);
         wp_die();
      }

      if( $password != $repassword){
         wp_send_json_error(['err' => true, 'message' => 'Password Error']);
         wp_die();
      }else{
         $get_id_user = get_user_by( 'email', $email )->data->ID;
         delete_transient( 'verification_code_' . $email );
         wp_set_password( $repassword, $get_id_user );
         wp_send_json_success(['err' => false, 'message' => 'Reset Password Ok' ]);
         wp_die();
      }

   }

}

function atlantis_login(){
   if( isset($_POST['action']) && $_POST['action'] == 'atlantis_login' ){
      $username = isset($_POST['username']) ? $_POST['username'] : '';
      $password = isset($_POST['password']) ? $_POST['password'] : '';

      $user_login = wp_signon( array(
         'user_login'    => $username,
         'user_password' => $password,
         'remember'      => true
      ) );

      if ( is_wp_error( $user_login ) ) {
         // authentication failed, display error message
         $error_message = $user_login->get_error_message();
         wp_send_json_error(['err' => true, 'message' => $error_message ]);
         wp_die();
      } else {
         // authentication succeeded, redirect to home page
         wp_send_json_success(['err' => false, 'message' => 'Login Ok']);
         wp_die();
      }
      
   }

}

function atlantis_get_user_tokens(){
   if( isset($_POST['action']) && $_POST['action'] == 'atlantis_get_user_tokens' ){
      $tokens = atlantis_check_login_by_tokens();
      if( $tokens == false ){
         wp_send_json_error(['err' => true, 'message' => 'Get User Error']);
         wp_die();
      }
      $user = get_user_by('id', $tokens->user_id);
      
      // MISSING STORE - CART ...

      /* 
         GROUP DB [ 
            first name 
            last name
            delivery address
            avatar
         ]
      */

      $prefix_user = 'user_' . $user->data->ID;

      $first_name = get_user_meta($user->data->ID, 'first_name', true) != '' ? get_user_meta($user->data->ID, 'first_name', true) : '';
      $avatar = get_field('user_avatar', $prefix_user);
      $delivery_address = !empty( get_field('user_delivery_address', $prefix_user) ) ? get_field('user_delivery_address', $prefix_user) : null;
      
      $final = [
         'user_login' => $user->data->user_login,
         'user_id' => $user->data->ID,
         'user_email' => $user->data->user_email,
         'first_name' => $first_name,
         'avatar' => $avatar,
         'delivery_address' => $delivery_address,
      ];

      wp_send_json_success([ 'err' => false, 'data' => $final ]);
      wp_die();
   }
}


function atlantis_update_user(){

   if( isset($_POST['action']) && $_POST['action'] == 'atlantis_update_user' ){
      $user_id = null;
      
      // CHECK SECURE
      $tokens = atlantis_check_login_by_tokens();
      if( $tokens == false ){
         wp_send_json_error(['err' => true, 'message' => 'Get Update User Error']);
         wp_die();
      }
      $user_id = $tokens->user_id;

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
      
      wp_send_json_success([ 'err' => false, 'message' => 'Update User Ok' ]);
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

      if( $event == '' ){
         wp_send_json_error(['err' => true, 'message' => 'User Delivery Address Error' ]);
         wp_die();
      }

      $tokens = atlantis_check_login_by_tokens();
      if( $tokens == false ){
         wp_send_json_error(['err' => true, 'message' => 'No Tokens' ]);
         wp_die();
      }
      $user_id = $tokens->user_id;
      $delivery = get_field('user_delivery_address', 'user_' . $user_id );

      // ADD EVENT
      if( $event == 'add' ){
         $id = randomString(64);

         $data_delivery = [];

         if( !empty($delivery )){
            $data_delivery = array_merge($data_delivery, $delivery );
         }

         if( $name != '' && $phone != '' && $address != '' ){
            $data_delivery[] = [
               'id' => $id,
               'name' => $name,
               'phone' => $phone,
               'address' => $address
            ];

            // IF SET NEW IS PRIMARY -> ALL IS FALSE
            foreach($data_delivery as $k => $vl ){
               if( $primary == 1 && $vl['id'] == $id ){
                  $data_delivery[$k]['primary'] = 1;
               }else{
                  $data_delivery[$k]['primary'] = 0;
               }
            }

            update_field('user_delivery_address', $data_delivery , 'user_' . $user_id);
            wp_send_json_success([ 'err' => false, 'message' => 'Update User Ok', 'data' => $data_delivery ]);
            wp_die();
         }

         wp_send_json_error(['err' => true, 'message' => 'User Delivery Address Error' ]);
         wp_die();

      }

      // UPDATE EVENT
      if( $event == 'update' ){
         $data_delivery = [];

         if( $name != '' ){
            $data_delivery['name'] = $name;
         }

         if( $phone != '' ){
            $data_delivery['phone'] = $phone;
         }

         if( $address != '' ){
            $data_delivery['address'] = $address;
         }

         $data_delivery['id'] = $id;
         $data_delivery['primary'] = $primary;

         foreach( $delivery as $k => $vl ){
            if( $vl['id'] == $id_delivery ){
               $delivery[$k] = $data_delivery;
               if( $primary == 1 ){
                  $delivery[$k]['primary'] = 1;
               }
            }else{
               $delivery[$k]['primary'] = 0;
            }
         }

         update_field('user_delivery_address', $delivery , 'user_' . $user_id);
  
         wp_send_json_success([ 'err' => false, 'message' => 'Update Delivery Address Ok', 'data' => $delivery ]);
         wp_die();

         // wp_send_json_error(['err' => true, 'message' => 'User Delivery Address Error' ]);
         // wp_die();
      }

      // DELETE EVENT
      if( $event == 'delete' ){

         if( $id_delivery == '' ){
            wp_send_json_error(['err' => true, 'message' => 'User Delivery Address Delete Error' ]);
            wp_die();
         }
         foreach( $delivery as $k => $vl ){
            if( $vl['id'] == $id_delivery ){
               unset($delivery[$k]);
            }
         }
         update_field('user_delivery_address', $delivery, 'user_' . $user_id);
         wp_send_json_success([ 'err' => false, 'message' => 'Update Delivery Address Ok', 'data' => $delivery ]);
         wp_die();
      }

   }
}


function atlantis_testing(){
   if( isset($_POST['action']) && $_POST['action'] == 'atlantis_testing' ){

      global $wpdb;

      $total_post = 'SELECT COUNT(*) total_record FROM wp_watergo_products';


      wp_send_json_success(['message' => 'testing']);
      
   }
}