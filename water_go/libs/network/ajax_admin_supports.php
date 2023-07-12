<?php

add_action( 'wp_ajax_nopriv_atlantis_get_admin_supports', 'atlantis_get_admin_supports' );
add_action( 'wp_ajax_atlantis_get_admin_supports', 'atlantis_get_admin_supports' );

add_action( 'wp_ajax_nopriv_atlantis_update_admin_support', 'atlantis_update_admin_support' );
add_action( 'wp_ajax_atlantis_update_admin_support', 'atlantis_update_admin_support' );

function atlantis_get_admin_supports(){
   if( isset($_POST['action']) && $_POST['action'] == 'atlantis_get_admin_supports' ){

      $id = isset($_POST['id']) ? $_POST['id'] : 0;

      // GET SINGLE

      if( $id != 0 ){

         $sql_get_admin_support = "SELECT * FROM wp_watergo_admin_supports WHERE id = $id";
         global $wpdb;
         $res = $wpdb->get_results( $sql_get_admin_support);

         if( empty( $res )){
            wp_send_json_error(['message' => 'admin_supports_not_found']);
            wp_die();
         }

         wp_send_json_success(['message' => 'admin_supports_ok', 'data' => $res[0]]);
         wp_die();

      } 

      if( $id == 0 ){

         if(is_user_logged_in() == true ){
            $user_id = get_current_user_id();
            $user = get_user_by('id', $user_id);
            $prefix_user = 'user_' . $user->data->ID;
            if( !isset ($user->caps['administrator']) && $user->caps['administrator'] != 1 ){
               wp_send_json_error(['message' => 'no_login_valid']);
               wp_die();
            }
         }

         $paged = isset($_POST['paged']) ? $_POST['paged'] : 0;
         $limit = isset($_POST['limit']) ? $_POST['limit'] : 10;

         $paged = $paged * $limit;


         $sql_get_admin_support = "SELECT * FROM wp_watergo_admin_supports WHERE admin_id = $user_id ORDER BY time_modified DESC ";
         global $wpdb;

         $res = $wpdb->get_results( $sql_get_admin_support);

         if( empty( $res )){
            wp_send_json_error(['message' => 'admin_supports_not_found']);
            wp_die();
         }

         wp_send_json_success(['message' => 'admin_supports_ok', 'data' => $res]);
         wp_die();
      }
   }

}

function atlantis_update_admin_support(){
   if( isset($_POST['action']) && $_POST['action'] == 'atlantis_update_admin_support' ){

      $id         = isset($_POST['id']) ? $_POST['id'] : 0;

      $question   = isset($_POST['question']) ? $_POST['question'] : '';
      $answer     = isset($_POST['answer']) ? $_POST['answer'] : '';

      if( $id == 0 ){
         wp_send_json_error(['message' => 'admin_supports_not_found']);
         wp_die();
      }

      global $wpdb;
      $wpdb->update('wp_watergo_admin_supports',[
         'question' => $question,
         'answer' => $answer,
         'time_modified' => time()
      ], ['id' => $id]);

      wp_send_json_success(['message' => 'update_admin_supports_ok']);
      wp_die();

   }
}