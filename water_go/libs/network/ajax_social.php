<?php

add_action( 'wp_ajax_nopriv_atlantis_social_login', 'atlantis_social_login' );
add_action( 'wp_ajax_atlantis_social_login', 'atlantis_social_login' );


function app_social_process_user_login($email, $name){
   if( !is_email($email ) ) wp_die();
   $check_user = email_exists( $email );
   $check_user_name = username_exists($email);
   
   if($check_user_name == false){

      $user = get_user_by('email', $email);

      // ACCOUNT DELETE
      $is_account_hidden = get_user_meta($user->data->ID, 'account_hidden', true) != ''
         ? (int) get_user_meta($user->data->ID , 'account_hidden', true) 
         : null;

      if($is_account_hidden == true || $is_account_hidden == 1){
         wp_send_json_error([ 'message' => 'account_delete' ]);
         wp_die();
      }

      $args = array (
         'user_login'         =>  $email,
         'user_pass'          =>  md5($email),
         'user_email'         =>  $email,
         'first_name'         =>  strip_tags($name),
         'role'               => 'subscriber'
      );
      $id_new_user = wp_insert_user( $args );
   }else{
      $id_new_user = $check_user_name;
   }

   $sql_user_login_social = "";

   if ( is_wp_error($id_new_user) ){
        echo 'error';
    }else{
         wp_clear_auth_cookie();
         $user = wp_set_current_user($id_new_user);
         wp_set_auth_cookie($id_new_user,true,is_ssl());
         do_action('wp_login', $user->user_login, $user);

         // UPDATE USER META 
         update_field('user_login_social', true, 'user_' . $id_new_user );

         header('user_id: '.$id_new_user);
         setcookie("USER_ID", $id_new_user,time() + 1209600, "/","", 0); 
         setcookie("IS_LOGIN_BY_SN", "true",time()+1209600, "/","", 0);
         setcookie("APP_LOGIN", "true",time()+1209600, "/","", 0);
         if(is_user_logged_in()) echo json_encode(["success",$id_new_user."|||".bj_render_nonce($id_new_user)]) ;
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
                 echo 'error';
             } else {
                 $email =  isset($data["email"]) ? $data["email"] : "";
                 $name =  isset($data["name"]) ? $data["name"] : "";

                 app_social_process_user_login($email, $name );
             }
         } else {
             echo 'error';
         }
         
         if( $email == "" or $name == "" ){
            echo 'error';
         }
      }

      // APPLE
      if($type == 'A'){

         if(!empty($_POST['information']) && is_email(explode(":",$_POST['information'])[1])){
            $email   = explode(":",$_POST['information'])[1];
            $name    = explode("@",$email)[0];
            app_social_process_user_login($email, $name);
         }else{
            echo 'error';
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
               echo 'error';
            }
         }
      }

   }
}

function shorten_URL ($longUrl) {
    //$longUrl = "https://stylevook.com/login?role=shopmanager&email=abc@123.456";
   //  efVXcyBHRwyYS83-zxLDvR:APA91bEB6c0UqQ36EbTiw6KSjUMQVdIQYiiInB9q7bzp1RTz-sqolQe1y73R34aLBQuqG5il81J6Xt7gtzgpTgBeCNDYNMdlVBb0GegmYzVjIOJF
    $key = 'AIzaSyDKpfx1zszLyDt0qmT436xylP3lngf9dTM';
    $url = 'https://firebasedynamiclinks.googleapis.com/v1/shortLinks?key=' . $key;
    $data = array(
      "dynamicLinkInfo" => array(
         "dynamicLinkDomain" => "watergo.page.link",
         "link" => $longUrl,
         "socialMetaTagInfo" => array(
            "socialTitle" => 'WaterGo',
            "socialDescription" => '',
            "socialImageLink" => THEME_URL . 'assets/images/logo-watergo.png'
         ),
         "androidInfo" => array(
            "androidPackageName" => "com.watergo.app"
         ),

         "iosInfo"=> array(
            "iosBundleId"=> "com.watergo.app"
         )
      )
    );

    $headers = array('Content-Type: application/json');
  
    $ch = curl_init ();
    curl_setopt ( $ch, CURLOPT_URL, $url );
    curl_setopt ( $ch, CURLOPT_POST, true );
    curl_setopt ( $ch, CURLOPT_HTTPHEADER, $headers );
    curl_setopt ( $ch, CURLOPT_RETURNTRANSFER, true );
    curl_setopt ( $ch, CURLOPT_POSTFIELDS, json_encode($data) );
  
    $data = curl_exec ( $ch );
    curl_close ( $ch );
  
    $short_url = json_decode($data);
    if(isset($short_url->error)){
        return $short_url->error->message;
    } else {
        return $short_url->shortLink;
    }
  
}