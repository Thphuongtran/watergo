<?php

add_action( 'wp_ajax_nopriv_atlantis_reviews', 'atlantis_reviews' );
add_action( 'wp_ajax_atlantis_reviews', 'atlantis_reviews' );

add_action( 'wp_ajax_nopriv_atlantis_get_total_review', 'atlantis_get_total_review' );
add_action( 'wp_ajax_atlantis_get_total_review', 'atlantis_get_total_review' );

add_action( 'wp_ajax_nopriv_atlantis_get_avg_rating', 'atlantis_get_avg_rating' );
add_action( 'wp_ajax_atlantis_get_avg_rating', 'atlantis_get_avg_rating' );

add_action( 'wp_ajax_nopriv_atlantis_review_average_rating', 'atlantis_review_average_rating' );
add_action( 'wp_ajax_atlantis_review_average_rating', 'atlantis_review_average_rating' );

add_action( 'wp_ajax_atlantis_add_review', 'atlantis_add_review' );

add_action( 'wp_ajax_atlantis_delete_review', 'atlantis_delete_review' );

add_action( 'wp_ajax_nopriv_atlantis_get_user_review', 'atlantis_get_user_review' );
add_action( 'wp_ajax_atlantis_get_user_review', 'atlantis_get_user_review' );

add_action( 'wp_ajax_atlantis_get_review', 'atlantis_get_review' );

add_action( 'wp_ajax_atlantis_update_review', 'atlantis_update_review' );


function atlantis_get_total_review(){
   if( isset( $_POST['action'] ) && $_POST['action'] == 'atlantis_get_total_review' ){
      $store_id = isset($_POST['store_id']) ? $_POST['store_id'] : 0;

      if( $store_id == 0 ){
         wp_send_json_error(['message' => 'total_review_not_found']);
         wp_die();
      }

      $sql = "SELECT COUNT(id) as total_review FROM wp_watergo_reviews WHERE store_id = $store_id";

      global $wpdb;
      $res = $wpdb->get_results($sql);

      if( $res[0]->total_review == null || $res[0]->total_review == 0 ){
         wp_send_json_error(['message' => 'total_review_not_found']);
         wp_die();
      }

      wp_send_json_success(['message' => 'total_review_found', 'data' => $res[0]->total_review ]);
      wp_die();
   }
}

function atlantis_reviews(){
   if( isset( $_POST['action'] ) && $_POST['action'] == 'atlantis_reviews' ){
      $order_id = isset($_POST['order_id']) ? $_POST['order_id'] : 0;
      $paged = isset($_POST['paged']) ? $_POST['paged'] : 0;
      $limit = 10;
      $paged = $paged * $limit;

      if( $order_id == 0 ){
         wp_send_json_error(['message' => 'review_not_found']);
         wp_die();
      }

      global $wpdb;
      $sql = "SELECT 
            wp_watergo_reviews.*,
            user.user_login as user_username,
            user.display_name as user_display_name
         FROM wp_watergo_reviews
         
         LEFT JOIN wp_users as user
         ON user.ID = wp_watergo_reviews.user_id

         WHERE wp_watergo_reviews.related_id = $order_id
         ORDER BY wp_watergo_reviews.id DESC
         LIMIT $paged, $limit
      ";

      $res = $wpdb->get_results($sql);
      foreach( $res as $k => $vl ){
         $res[$k]->user_avatar = func_atlantis_get_images($vl->user_id, 'user_avatar');
      }

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
      $avg_rating = func_atlantis_get_avg_rating($store_id);
      wp_send_json_success(['message' => 'rating_found', 'data' => $avg_rating ]);
      wp_die();
   }
}

function atlantis_get_user_review(){
   if( isset( $_POST['action'] ) && $_POST['action'] == 'atlantis_get_user_review' ){

      $paged = isset($_POST['paged']) ? $_POST['paged'] : 0;
      $limit = isset($_POST['limit']) ? $_POST['limit'] : 10;

      $paged = $paged * $limit;
      $user_id = get_current_user_id();

      global $wpdb;

      $sql = "SELECT 
            wp_watergo_reviews.id, 
            wp_watergo_reviews.contents,
            wp_watergo_reviews.rating,
            wp_watergo_reviews.date_created,
            wp_watergo_store.id as store_id,
            wp_watergo_store.name as store_name
         --
         FROM wp_watergo_reviews
         LEFT JOIN wp_watergo_store
         ON wp_watergo_store.id = wp_watergo_reviews.store_id
         WHERE wp_watergo_reviews.user_id = $user_id

         ORDER BY wp_watergo_reviews.date_created DESC
         LIMIT $paged, $limit
      ";

      $res = $wpdb->get_results($sql);

      if( empty($res ) ){
         wp_send_json_error([ 'message' => 'no_review_found' ]);
         wp_die();
      }

      foreach( $res as $k => $vl ){
         $res[$k]->store_image = func_atlantis_get_images($vl->store_id, 'store', true);
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
      $review_id  = isset($_POST['review_id']) ? $_POST['review_id'] : 0;
      $user_id    = get_current_user_id();

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

/**
*  @access REVIEW VERSION 2
*/

add_action( 'wp_ajax_nopriv_atlantis_is_user_has_review_store', 'atlantis_is_user_has_review_store' );
add_action( 'wp_ajax_atlantis_is_user_has_review_store', 'atlantis_is_user_has_review_store' );

function atlantis_is_user_has_review_store(){
   if(isset($_POST['action'])  && $_POST['action'] == 'atlantis_is_user_has_review_store' ){
      $user_id    = get_current_user_id();
      $order_id   = isset($_POST['order_id' ]) ? (int) $_POST['order_id'] : 0;
      global $wpdb;
      $sql = "SELECT COUNT(*) as has_review FROM wp_watergo_reviews WHERE user_id = $user_id AND order_id = $order_id LIMIT 1";
      $res = $wpdb->get_results($sql);

      if( $res[0]->has_review != null && $res[0]->has_review > 0 ){
         wp_send_json_success(['message' => 'review_found' ]);
         wp_die();
      }
      wp_send_json_error(['message' => 'review_not_found' ]);
      wp_die();
   }
}


add_action( 'wp_ajax_nopriv_atlantis_event_review', 'atlantis_event_review' );
add_action( 'wp_ajax_atlantis_event_review', 'atlantis_event_review' );

function atlantis_event_review(){
   if( isset($_POST['action']) && $_POST['action'] == 'atlantis_event_review' ){
      
      $user_id    = get_current_user_id();
      $store_id   = isset($_POST['store_id']) ? $_POST['store_id'] : 0;
      $order_id   = isset($_POST['order_id']) ? $_POST['order_id'] : 0;
      $review_id  = isset($_POST['review_id']) ? $_POST['review_id'] : 0;
      $event      = isset($_POST['event']) ? $_POST['event'] : '';

      $contents   = isset($_POST['contents']) ? $_POST['contents'] : '';
      $rating     = isset($_POST['rating']) ? $_POST['rating'] : 0;

      if( $event == '' || $rating == 0 || $contents == '' ){
         wp_send_json_error(['message' => 'review_not_found']);
         wp_die();
      }

      $args = [
         'contents'  => $contents,
         'rating'    => $rating,
      ];

      global $wpdb;

      if( $event == 'add' ){
         $args['user_id']        = $user_id;
         $args['order_id']       = $order_id;
         $args['store_id']       = $store_id;
         $args['date_created']   = atlantis_current_datetime();

         $inserted = $wpdb->insert('wp_watergo_reviews', $args );

         if($inserted ){
            wp_send_json_success(['message' => 'review_insert_ok', 'data' => $wpdb->insert_id ]);
            wp_die();
         }else{
            wp_send_json_error(['message' => 'review_not_found']);
            wp_die();
         }

      }

      if( $event == 'edit' ){
         $args['date_modified']   = atlantis_current_datetime();
         $updated = $wpdb->update('wp_watergo_reviews', $args, [
            'user_id'   => $user_id,
            'id'        => $review_id
         ]);
         if( $updated ){
            wp_send_json_success(['message' => 'review_update_ok', 'data' => $review_id]);
            wp_die();
         }else{
            wp_send_json_error(['message' => 'review_not_found 2']);
            wp_die();
         }
      }

      wp_send_json_error(['message' => 'review_not_found']);
      wp_die();

      

   }
}

add_action( 'wp_ajax_nopriv_atlantis_get_review_store', 'atlantis_get_review_store' );
add_action( 'wp_ajax_atlantis_get_review_store', 'atlantis_get_review_store' );

function atlantis_get_review_store(){
   if( isset($_POST['action']) && $_POST['action'] == 'atlantis_get_review_store' ){
      $store_id   = isset($_POST['store_id']) ? $_POST['store_id'] : 0;
      $limit      = isset($_POST['limit']) ? $_POST['limit'] : 10;
      $paged      = isset($_POST['paged']) ? $_POST['paged'] : 0;
      $extension  = isset($_POST['extension']) ? $_POST['extension'] : 0;

      if( $store_id == 0 ){
         wp_send_json_error(['message' => 'review_not_found']);
         wp_die();
      }

      $sql = "SELECT * FROM wp_watergo_reviews 
         WHERE store_id = $store_id ORDER BY id DESC 
         LIMIT $paged, $limit
      ";

      global $wpdb;
      $res = $wpdb->get_results( $sql);

      if( empty($res )){
         wp_send_json_error(['message' => 'review_not_found']);
         wp_die();
      }

      // 75
      foreach( $res as $k => $vl ){
         $res[$k]->first_name    = get_user_meta( $vl->user_id, 'first_name', true );
         $res[$k]->nickname      = get_user_meta( $vl->user_id, 'nickname', true );
         $res[$k]->user_avatar   = func_atlantis_get_images($vl->user_id, 'user_avatar', true);
         // wp_send_json_error(['message' => 'bug', 'data' => strlen( $vl->contents) ]);
         // wp_die();

         if( $extension == 'small' ){
            if( mb_strlen($vl->contents, 'UTF-8') >= 72  ){
               $res[$k]->contents = mb_substr($vl->contents, 0, 72, 'UTF-8') . '...';
            }
         }
      }

      wp_send_json_success(['message' => 'review_found', 'data' => $res ]);
      wp_die();

   }
}

