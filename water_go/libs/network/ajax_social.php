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
      $id = wp_insert_user( $args );
   }else{
      $id = $check_user_name;
   }

   wp_clear_auth_cookie();
   $user = wp_set_current_user($id);
   wp_set_auth_cookie($id, true, is_ssl());
   do_action('wp_login', $user->user_login, $user);
   
   // wp_send_json_success(['success]);
   // ["success",$id_new_user."|||".bj_render_nonce($id_new_user)]
   $token = 'woLYHdBOLNbDGY2UkE';
   
   echo json_decode(['success', $id."|||".$token]);
   // wp_send_json_success([ 'message' => '' ])
   wp_die();
}

function atlantis_social_login(){
   if( isset( $_POST['action'] ) && $_POST['action'] == 'atlantis_social_login' ){

      $type          = isset($_POST["type"]) ? $_POST['type'] : '';
      $accessToken   = isset($_POST['token']) ? $_POST['token'] : '';

      // GOOGLE
      if( $type == 'G' ){
         $request_url = 'https://oauth2.googleapis.com/tokeninfo?id_token='.$accessToken;
         $response_access = file_get_contents($request_url);
         $response_access = json_decode( $response_access, true );

         $email =  isset($response_access["email"]) ? $response_access["email"] : "";
         $name =  isset($response_access["name"]) ? $response_access["name"] : "";
         
         if( $email == "" or $name == "" ){
            // Can't login because of missing parameters
            wp_send_json_error(['message' => 'login_social_not_found' ]);
            wp_die();
         }

         app_social_process_user_login($email, $name );
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