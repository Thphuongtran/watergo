<?php

add_action( 'wp_ajax_nopriv_atlantis_reviews', 'atlantis_reviews' );
add_action( 'wp_ajax_atlantis_reviews', 'atlantis_reviews' );

add_action( 'wp_ajax_nopriv_atlantis_get_total_review', 'atlantis_get_total_review' );
add_action( 'wp_ajax_atlantis_get_total_review', 'atlantis_get_total_review' );

add_action( 'wp_ajax_nopriv_atlantis_get_avg_rating', 'atlantis_get_avg_rating' );
add_action( 'wp_ajax_atlantis_get_avg_rating', 'atlantis_get_avg_rating' );

add_action( 'wp_ajax_nopriv_atlantis_review_average_rating', 'atlantis_review_average_rating' );
add_action( 'wp_ajax_atlantis_review_average_rating', 'atlantis_review_average_rating' );

add_action( 'wp_ajax_nopriv_atlantis_add_review', 'atlantis_add_review' );
add_action( 'wp_ajax_atlantis_add_review', 'atlantis_add_review' );

add_action( 'wp_ajax_nopriv_atlantis_delete_review', 'atlantis_delete_review' );
add_action( 'wp_ajax_atlantis_delete_review', 'atlantis_delete_review' );

add_action( 'wp_ajax_nopriv_atlantis_get_user_review', 'atlantis_get_user_review' );
add_action( 'wp_ajax_atlantis_get_user_review', 'atlantis_get_user_review' );

add_action( 'wp_ajax_nopriv_atlantis_get_review', 'atlantis_get_review' );
add_action( 'wp_ajax_atlantis_get_review', 'atlantis_get_review' );

add_action( 'wp_ajax_nopriv_atlantis_update_review', 'atlantis_update_review' );
add_action( 'wp_ajax_atlantis_update_review', 'atlantis_update_review' );

function atlantis_get_total_review(){
   if( isset( $_POST['action'] ) && $_POST['action'] == 'atlantis_get_total_review' ){
      $store_id = isset($_POST['store_id']) ? $_POST['store_id'] : 0;

      if( $store_id == 0 ){
         wp_send_json_error(['message' => 'total_review_not_found']);
         wp_die();
      }

      $sql = "SELECT COUNT(id) as total_review FROM wp_watergo_reviews 
         WHERE related_id = $store_id 
         AND review_page='review-store' ";
      
      global $wpdb;
      $res = $wpdb->get_results($sql);

      if( $res[0]->total_review == null){
         wp_send_json_error(['message' => 'total_review_not_found']);
         wp_die();
      }
      wp_send_json_success(['message' => 'total_review_found', 'data' => $res[0]->total_review ]);
      wp_die();
   }
}

function atlantis_reviews(){
   if( isset( $_POST['action'] ) && $_POST['action'] == 'atlantis_reviews' ){
      $store_id = isset($_POST['store_id']) ? $_POST['store_id'] : 0;
      $page = isset($_POST['page']) ? $_POST['page'] : 0;
      $limit = isset($_POST['limit']) ? $_POST['limit'] : 10;

      if( $store_id == 0 ){
         wp_send_json_error(['message' => 'review_not_found']);
         wp_die();
      }

      global $wpdb;
      $sql = "SELECT wp_watergo_reviews.*,
         user.user_login as user_username,
         user.display_name as user_display_name
         
         FROM wp_watergo_reviews
         LEFT JOIN wp_users as user
         ON user.ID = wp_watergo_reviews.user_id
         WHERE wp_watergo_reviews.related_id = {$store_id} 
         AND wp_watergo_reviews.review_page = 'review-store'
         LIMIT $page,$limit
      ";

      $res = $wpdb->get_results($sql);
      if( empty( $res ) ){
         wp_send_json_error(['message' => 'review_not_found']);
         wp_die();
      }
      wp_send_json_success(['message' => 'review_found', 'data' => $res ]);
      wp_die();
   }

}

function atlantis_get_avg_rating(){
   if( isset( $_POST['action'] ) && $_POST['action'] == 'atlantis_get_avg_rating' ){
      $store_id = isset($_POST['store_id']) ? $_POST['store_id'] : 0;

      if( $store_id == 0 ){
         wp_send_json_error(['message' => 'rating_not_found']);
         wp_die();
      }

      $sql = "SELECT AVG(rating) as avg_rating FROM wp_watergo_reviews 
         WHERE related_id = $store_id 
         AND review_page = 'review-store' ";
      global $wpdb;
      $res = $wpdb->get_results($sql);

      if( $res[0]->avg_rating == null ){
         wp_send_json_error(['message' => 'rating_not_found']);
         wp_die();
      }

      wp_send_json_success(['message' => 'rating_found', 'data' => $res[0]->avg_rating ]);
      wp_die();
   }
}


function atlantis_add_review(){
   if( isset( $_POST['action'] ) && $_POST['action'] == 'atlantis_add_review' ){
      $user_id = 0;
      if(is_user_logged_in() == true ){
         $user_id = get_current_user_id();
         $user = get_user_by('id', $user_id);
         $prefix_user = 'user_' . $user->data->ID;
      }else{
         wp_send_json_error(['err' => true, 'message' => 'No Login Invalid' ]);
         wp_die();
      }

      $related_id = isset($_POST['related_id']) ? $_POST['related_id'] : 0;
      $contents = isset($_POST['contents']) ? $_POST['contents'] : '';
      $review_page = isset($_POST['review_page']) ? $_POST['review_page'] : '';
      $rating = isset($_POST['rating']) ? $_POST['rating'] : '';

      if( $related_id == 0 && $contents == '' && $user_id == 0 && $review_page != ''){
         wp_send_json_error(['message' => 'review_not_found']);
         wp_die();
      }
      
      // [
      //    review-store
      //    review-product
      // ]

      global $wpdb;
      $wpdb->insert('wp_watergo_reviews',[
         'user_id' => $user_id,
         'review_page' => $review_page,
         'contents' => $contents,
         'related_id' => $related_id,
         'rating' => $rating,
         'time_created' => time()
      ]);

      wp_send_json_success(['message' => 'review_insert_ok' ]);
      wp_die();
   }
}

function atlantis_get_user_review(){
   if( isset( $_POST['action'] ) && $_POST['action'] == 'atlantis_get_user_review' ){
      if(is_user_logged_in() == true ){
         $user_id = get_current_user_id();
         $user = get_user_by('id', $user_id);
         $prefix_user = 'user_' . $user->data->ID;
      }else{
         wp_send_json_error([ 'message' => 'no_login_invalid' ]);
         wp_die();
      }

      global $wpdb;

      $sql = "SELECT 	
            wp_watergo_reviews.id, 
               wp_watergo_reviews.review_page,
               wp_watergo_reviews.contents,
               wp_watergo_reviews.rating,
               wp_watergo_reviews.time_created,
               wp_watergo_store.name as store_name
               
         FROM wp_watergo_reviews
         LEFT JOIN wp_users
         ON wp_watergo_reviews.user_id = wp_users.id
         LEFT JOIN wp_watergo_store
         ON wp_watergo_store.id = wp_watergo_reviews.related_id
         WHERE 
            wp_watergo_reviews.user_id = {$user_id}
         AND 
            wp_watergo_reviews.review_page = 'review-store'
      ";
      $res = $wpdb->get_results($sql);
      if( empty($res ) ){
         wp_send_json_error([ 'message' => 'no_review_found' ]);
         wp_die();
      }
      wp_send_json_success([ 'message' => 'review_found', 'data' => $res ]);
      wp_die();
   }
}

function atlantis_delete_review(){
   if( isset( $_POST['action'] ) && $_POST['action'] == 'atlantis_delete_review' ){
      if(is_user_logged_in() == true ){
         $user_id = get_current_user_id();
         $user = get_user_by('id', $user_id);
         $prefix_user = 'user_' . $user->data->ID;
      }else{
         wp_send_json_error([ 'message' => 'no_login_invalid' ]);
         wp_die();
      }

      $review_id = isset($_POST['review_id']) ? $_POST['review_id'] : 0;
      if( $review_id == 0){
         wp_send_json_error([ 'message' => 'review_not_found' ]);
         wp_die();
      }

      global $wpdb;
      $wpdb->delete('wp_watergo_reviews', array('id' => $review_id, 'user_id' => $user_id));
      wp_send_json_success([ 'message' => 'review_delete_ok' ]);
      wp_die();

   }
}

function atlantis_get_review(){
   if( isset( $_POST['action'] ) && $_POST['action'] == 'atlantis_get_review' ){
      $review_id = isset($_POST['review_id']) ? $_POST['review_id'] : 0;

      if(is_user_logged_in() == true ){
         $user_id = get_current_user_id();
         $user = get_user_by('id', $user_id);
         $prefix_user = 'user_' . $user->data->ID;
      }else{
         wp_send_json_error([ 'message' => 'no_login_invalid' ]);
         wp_die();
      }

      if( $review_id == 0 ){
         wp_send_json_error([ 'message' => 'review_not_found' ]);
         wp_die();
      }

      $sql = "SELECT * FROM wp_watergo_reviews WHERE id = $review_id AND user_id = $user_id";

      global $wpdb;

      $res = $wpdb->get_results($sql);

      if( empty($res ) ){
         wp_send_json_error([ 'message' => 'review_not_found' ]);
         wp_die();
      }
      wp_send_json_success([ 'message' => 'review_found', 'data' => $res[0] ]);
      wp_die();

   }
}

function atlantis_update_review(){
   if( isset( $_POST['action'] ) && $_POST['action'] == 'atlantis_update_review' ){
      $review_id = isset($_POST['review_id']) ? $_POST['review_id'] : 0;
      $contents = isset($_POST['contents']) ? $_POST['contents'] : '';
      $rating = isset($_POST['rating']) ? $_POST['rating'] : 0;

      if(is_user_logged_in() == true ){
         $user_id = get_current_user_id();
         $user = get_user_by('id', $user_id);
         $prefix_user = 'user_' . $user->data->ID;
      }else{
         wp_send_json_error([ 'message' => 'no_login_invalid' ]);
         wp_die();
      }

      if( $review_id == 0 && $contents == '' && $rating == 0){
         wp_send_json_error(['message' => 'review_not_found']);
         wp_die();
      }

      global $wpdb;
      $wpdb->update('wp_watergo_reviews', [
         'contents' => $contents,
         'rating' => $rating,
      ], [ 'id' => $review_id, 'user_id' => $user_id]);

      wp_send_json_success(['message' => 'review_update_ok' ]);
      wp_die();

   }
}