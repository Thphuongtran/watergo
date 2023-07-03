<?php

add_action( 'wp_ajax_nopriv_atlantis_social_login', 'atlantis_social_login' );
add_action( 'wp_ajax_atlantis_social_login', 'atlantis_social_login' );


function app_social_process_user_login($email, $name){
   if( !is_email($email ) ) wp_die();
   $check_user = email_exists( $email );
   $check_user_name = username_exists($email);

   if($check_user_name == false){
      $args = array (
         'user_login'         =>  $email,
         'user_pass'          =>  md5($email),
         'user_email'         =>  $email,
         'display_name'       =>  strip_tags($name),
         'role'               => 'subscriber'
      );
      $id_new_user = wp_insert_user( $args );
   }else{
      $id_new_user = $check_user_name;
   }

   if ( is_wp_error($id_new_user) ){
        echo $id_new_user->get_error_message();
    }else{
      wp_clear_auth_cookie();
        $user = wp_set_current_user($id_new_user);
        wp_set_auth_cookie($id_new_user,true,is_ssl());
        do_action('wp_login', $user->user_login, $user);
      header('user_id: '.$id_new_user);
      setcookie("USER_ID", $id_new_user,time() + 1209600, "/","", 0); 
        setcookie("IS_LOGIN_BY_SN", "true",time()+1209600, "/","", 0);
        setcookie("APP_LOGIN", "true",time()+1209600, "/","", 0);
      if(is_user_logged_in()) echo 'success'; 
      die();
    }
}

function atlantis_social_login(){
   if( isset( $_POST['action'] ) && $_POST['action'] == 'atlantis_social_login' ){

      $type          = isset($_POST["type"]) ? $_POST['type'] : '';
      $accessToken   = isset($_POST['token']) ? $_POST['token'] : '';
      // GOOGLE
      if( $type == 'G' ){
         $request_url = 'https://oauth2.googleapis.com/tokeninfo?id_token='.$accessToken;
         $response_access = file_get_contents($request_url);
         if ($response_access !== false) {
             $data = json_decode($response_access, true);
             if (isset($data['error'])) {
                 echo 'Lỗi: ' . $data['error'];
             } else {
                 $email =  isset($data["email"]) ? $data["email"] : "";
                 $name =  isset($data["name"]) ? $data["name"] : "";

                 app_social_process_user_login($email, $name );
             }
         } else {
             echo 'Có lỗi xảy ra khi gửi yêu cầu.';
         }
         
         if( $email == "" or $name == "" ){
            // Can't login because of missing parameters
            wp_send_json_error(['message' => 'login_social_not_found' ]);
            wp_die();
         }
      }

      // APPLE
      if($type == 'A'){

         if(!empty($_POST['information']) && is_email(explode(":",$_POST['information'])[1])){
            $email   = explode(":",$_POST['information'])[1];
            $name    = explode("@",$email)[0];
            app_social_process_user_login($email, $name);
         }else{
            // _e('Email is required',"umm");
            wp_send_json_error(['message' => 'login_social_not_found' ]);
            wp_die();
         }
      }

      // ZALO
      if($type == 'Z'){
         $profile_json = file_get_contents('https://graph.zalo.me/v2.0/me?access_token='.$accessToken.'&fields=id,name');
         if (!empty($profile_json)){
            $profile = json_decode( $profile_json, true );
            $email = $profile['id'].'-zalo@'.$_SERVER['HTTP_HOST'];
            if(isset($profile['id'])){
               $email = $profile['id'].'-zalo@'.$_SERVER['HTTP_HOST'];
               app_social_process_user_login($email, $profile['name']);
            }else{
               // die("error");
               wp_send_json_error(['message' => 'login_social_not_found' ]);
               wp_die();
            }
         }
      }

   }
}