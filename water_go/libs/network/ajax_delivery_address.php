<?php
add_action( 'wp_ajax_nopriv_atlantis_delivery_address', 'atlantis_delivery_address' );
add_action( 'wp_ajax_atlantis_delivery_address', 'atlantis_delivery_address' );


function wp_ajax_atlantis_delivery_address(){
   if( isset($_POST['action']) && $_POST['action'] == 'wp_ajax_atlantis_delivery_address'){

      if(is_user_logged_in() == true ){
         $user_id = get_current_user_id();
         $user = get_user_by('id', $user_id);
         $prefix_user = 'user_' . $user->data->ID;
      }else{
         wp_send_json_error(['message' => 'no_login_invalid' ]);
         wp_die();
      }

      

   }
}