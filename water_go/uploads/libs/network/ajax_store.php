<?php

add_action( 'wp_ajax_nopriv_atlantis_load_store', 'atlantis_load_store' );
add_action( 'wp_ajax_atlantis_load_store', 'atlantis_load_store' );

add_action( 'wp_ajax_nopriv_atlantis_find_store', 'atlantis_find_store' );
add_action( 'wp_ajax_atlantis_find_store', 'atlantis_find_store' );

add_action( 'wp_ajax_nopriv_atlantis_load_all_product_by_store', 'atlantis_load_all_product_by_store' );
add_action( 'wp_ajax_atlantis_load_all_product_by_store', 'atlantis_load_all_product_by_store' );

add_action( 'wp_ajax_nopriv_atlantis_get_total_purchase_store', 'atlantis_get_total_purchase_store' );
add_action( 'wp_ajax_atlantis_get_total_purchase_store', 'atlantis_get_total_purchase_store' );

add_action( 'wp_ajax_nopriv_atlantis_get_store_nearby', 'atlantis_get_store_nearby' );
add_action( 'wp_ajax_atlantis_get_store_nearby', 'atlantis_get_store_nearby' );

add_action( 'wp_ajax_nopriv_atlantis_get_location_of_store', 'atlantis_get_location_of_store' );
add_action( 'wp_ajax_atlantis_get_location_of_store', 'atlantis_get_location_of_store' );

add_action( 'wp_ajax_nopriv_atlantis_get_store_id', 'atlantis_get_store_id' );
add_action( 'wp_ajax_atlantis_get_store_id', 'atlantis_get_store_id' );


function atlantis_get_store_id(){
   if( isset( $_POST['action'] ) && $_POST['action'] == 'atlantis_get_store_id' ){
      $store_id = func_get_store_id_from_current_user();
      wp_send_json_success(['message' => 'get_store_id_ok', 'data' => $store_id]);
      wp_die();
   }
}


function atlantis_get_store_nearby(){
   if( isset( $_POST['action'] ) && $_POST['action'] == 'atlantis_get_store_nearby' ){

      $lat = isset($_POST['lat']) ? $_POST['lat'] : 10.780900239854994;
      $lng = isset($_POST['lng']) ? $_POST['lng'] : 106.7226271387539;

      if($lat == 0.0 && $lng == 0.0){
         wp_send_json_error(['message' => 'store_location_not_found']);
         wp_die();
      }
      // sql search with current location
      $sql = "SELECT *,
            (6371 * acos(
               cos(radians($lat)) * cos(radians(latitude)) 
                  * cos(radians(longitude) - radians($lng)) +
               sin(radians($lat)) * sin(radians(latitude))
            )) AS distance
         FROM wp_watergo_store
         HAVING distance <= 5 -- Adjust the distance value as desired (in kilometers)
         ORDER BY distance ASC
         LIMIT 10
      ";
      global $wpdb;
      $res = $wpdb->get_results($sql);

      if( empty($res )){
         wp_send_json_error(['message' => 'store_location_not_found']);
         wp_die();
      }
      $arr = [];
      foreach( $res as $k => $vl ){
         $res[$k]->avg_rating    = func_atlantis_get_avg_rating( (int) $vl->id);
         $res[$k]->store_image   = func_atlantis_get_images( (int) $vl->id, 'store');
      }

      wp_send_json_success(['message' => 'store_location_found', 'data' => $res, 'arr' => $arr ]);
      wp_die();
   }
}

function atlantis_get_total_purchase_store(){
   if( isset( $_POST['action'] ) && $_POST['action'] == 'atlantis_get_total_purchase_store' ){
      $store_id = isset($_POST['store_id']) ? $_POST['store_id'] : 0;

      if( $store_id == 0 ){
         wp_send_json_error(['message' => 'purchase_not_found']);
         wp_die();
      }

      $sql = "SELECT COUNT(wp_watergo_order.hash_id) as store_purchase
         FROM wp_watergo_order
         LEFT JOIN wp_watergo_order_group
         ON wp_watergo_order_group.hash_id = wp_watergo_order.hash_id
         WHERE wp_watergo_order.order_status = 'complete'
         AND wp_watergo_order_group.order_group_store_id = $store_id
      ";

      global $wpdb;
      $res = $wpdb->get_results($sql);

      if( $res[0]->store_purchase == null ){
         wp_send_json_error(['message' => 'purchase_not_found']);
         wp_die();
      }

      wp_send_json_success(['message' => 'purchase_found', 'data' => $res[0]->store_purchase ]);
      wp_die();
   }
}

function atlantis_load_store(){
   if( isset( $_POST['action'] ) && $_POST['action'] == 'atlantis_load_store' ){
      global $wpdb;
      $sql = "SELECT 
         wp_watergo_store.*

         FROM wp_watergo_store 

         ORDER BY id DESC 
         LIMIT 0,10";
      $get_results = $wpdb->get_results($sql);
      if( empty( $get_results ) ){
         wp_send_json_error([ 'message' => 'store_not_found' ]);
         wp_die();
      }else{
         wp_send_json_success(['message' => 'store_found', 'data' => $get_results ]);
         wp_die();
      }
   }
}

function atlantis_find_store(){
   if( isset( $_POST['action'] ) && $_POST['action'] == 'atlantis_find_store' ){
      $store_id = isset($_POST['store_id']) ? $_POST['store_id'] : 0;

      if( $store_id == 0 ){
         wp_send_json_error(['message' => 'store_not_found']);
         wp_die();
      }

      global $wpdb;
      $sql = "SELECT * FROM wp_watergo_store WHERE id = $store_id ";

      $res = $wpdb->get_results($sql);

      foreach( $res as $k => $vl ){
         $res[$k]->store_image = func_atlantis_get_images($vl->id, 'store', true);
      }

      if( empty( $res ) ){
         wp_send_json_error([ 'message' => 'store_not_found' ]);
         wp_die();
      }
      wp_send_json_success(['message' => 'store_found', 'data' => $res[0] ]);
      wp_die();
      
   }

}

function atlantis_get_location_of_store(){
   if( isset( $_POST['action'] ) && $_POST['action'] == 'atlantis_get_location_of_store' ){
      $store_id = isset($_POST['store_id']) ? $_POST['store_id'] : 0;

      if( $store_id == 0 ){
         wp_send_json_error(['message' => 'store_not_found']);
         wp_die();
      }
      global $wpdb;
      
      $sql = "SELECT latitude, longitude FROM wp_watergo_store WHERE id = $store_id";

      $res = $wpdb->get_results($sql);

      if( empty( $res ) ){
         wp_send_json_error([ 'message' => 'store_not_found' ]);
         wp_die();
      }
      wp_send_json_success(['message' => 'store_found', 'data' => $res[0] ]);
      wp_die();

   }
}

/**
 * @access TAB STORE
 */

add_action( 'wp_ajax_nopriv_atlantis_get_store_profile', 'atlantis_get_store_profile' );
add_action( 'wp_ajax_atlantis_get_store_profile', 'atlantis_get_store_profile' );

function atlantis_get_store_profile(){
   if( isset($_POST['action']) && $_POST['action'] == 'atlantis_get_store_profile' ){
      $user_id = get_current_user_id();
      $store_id = func_get_store_id_from_current_user();
      $sql = "SELECT * FROM wp_watergo_store WHERE id = $store_id LIMIT 1";
      global $wpdb;
      $res = $wpdb->get_results($sql);
      if( empty($res )){
         wp_send_json_error(['message' => 'get_store_error', 'sql' => $sql]);
         wp_die();
      }
      $res[0]->store_image = func_atlantis_get_images( $res[0]->id, 'store', true );
      // GET EMAIL FROM current user_id
      $user_data = get_userdata($user_id);
      $res[0]->email = $user_data->user_email;

      wp_send_json_success(['message' => 'get_store_ok', 'data' => $res[0]]);
      wp_die();

   }
}

add_action( 'wp_ajax_nopriv_atlantis_store_profile_edit', 'atlantis_store_profile_edit' );
add_action( 'wp_ajax_atlantis_store_profile_edit', 'atlantis_store_profile_edit' );

function atlantis_store_profile_edit(){
   if( isset($_POST['action']) && $_POST['action'] == 'atlantis_store_profile_edit' ){
      global $wpdb;

      // get location store when update location
      $id = isset($_POST['id']) ? $_POST['id'] : 0;
      $owner = isset($_POST['owner']) ? $_POST['owner'] : '';
      $name = isset($_POST['name']) ? $_POST['name'] : '';
      $description = isset($_POST['description']) ? $_POST['description'] : '';
      $address = isset($_POST['address']) ? $_POST['address'] : '';
      $phone = isset($_POST['phone']) ? $_POST['phone'] : '';
      $email = isset($_POST['email']) ? $_POST['email'] : '';
      
      $imageUpload = isset($_FILES['imageUpload']) ? $_FILES['imageUpload'] : null;

      if( $id == 0 ){
         wp_send_json_error(['message' => 'store_edit_error' ]);
         wp_die();
      } 

      // REMOVE ANY NON-DIGITAL NO UNNESESSORY
      $phone = preg_replace('/\D/', '', $phone);

      if ( preg_match('/^\d+$/', $phone) == false || (strlen($phone) >= 10 && strlen($phone) < 12) == false) {
         wp_send_json_error([ 'message' => 'phonenumber_is_not_correct_format']);
         wp_die();
      }

      if( is_email($email) == false ){
         wp_send_json_error([ 'message' => 'email_is_not_correct_format']);
         wp_die();
      }

      $url_request = 'https://geocode.search.hereapi.com/v1/geocode';
      $keyID = 'nJEYTwZNrpgfDSKEA4VzYO2R-NNL1grWFpf3y60aK1k';

      $query_params = [
         'q'      => $address,
         'apiKey' => $keyID
      ];

      $url = add_query_arg($query_params, $url_request);
      $response = wp_remote_get($url);
      $body = wp_remote_retrieve_body($response);

      if( !empty($body) && $body != '' ){
         $body             = json_decode( $body);
         $position         = [];
         if( $body->items[0]->position->lat != null ){
            $position['lat'] = $body->items[0]->position->lat;
         }else{
            $position['lat'] = 0.0;
         }
         if( $body->items[0]->position->lng != null ){
            $position['lng'] = $body->items[0]->position->lng;
         }else{
            $position['lng'] = 0.0;
         }
      }
      
      $updated = $wpdb->update('wp_watergo_store', [
         'owner'        => $owner,
         'name'         => $name,
         'description'  => $description,
         'address'      => $address,
         'phone'        => $phone,
         'latitude'     => $position['lat'],
         'longitude'    => $position['lng']
      ], ['id' => $id ]);

      // UPDATE EMAIL USER
      if( $email != '' || $email != null){
         
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
      
      // find store already have image?
      // override when upload image
      if( $imageUpload != null ){
         // FIND IMAGE AND REPLACE
         $sql_find_attachment = "SELECT * FROM wp_watergo_attachment WHERE related_id = $id AND attachment_type = 'store' ";
         $attachment_exists = $wpdb->get_results( $sql_find_attachment );

         if( !empty($attachment_exists) ){
            wp_delete_attachment($attachment_exists[0]->attachment_id, true);
            $wpdb->delete('wp_watergo_attachment',[ 'attachment_id' => $attachment_exists[0]->attachment_id ], [ '%d' ]);
         }

         $attachment_id = func_atlantis_upload_no_ajax('store', $imageUpload);
         if($attachment_id != null || !empty( $attachment_id ) ){
            $wpdb->insert('wp_watergo_attachment', [
               'attachment_id'   => $attachment_id[0],
               'related_id'      => $id,
               'attachment_type' => 'store'
            ]);
         }
      }
      wp_send_json_success([ 'message' => 'store_profile_update_ok' ]);
      wp_die();   
   
   }
}



add_action( 'wp_ajax_nopriv_atlantis_get_current_store_profile', 'atlantis_get_current_store_profile' );
add_action( 'wp_ajax_atlantis_get_current_store_profile', 'atlantis_get_current_store_profile' );

function atlantis_get_current_store_profile(){
   if( isset($_POST['action']) && $_POST['action'] == 'atlantis_get_current_store_profile' ){

      $store_id = func_get_store_id_from_current_user();
      $sql = "SELECT * FROM wp_watergo_store WHERE id = $store_id LIMIT 1";

      global $wpdb;
      $store = $wpdb->get_results($sql);
      $store[0]->store_image = func_atlantis_get_images($store[0]->id, 'store', true);

      if( empty( $store )){
         wp_send_json_error([ 'message' => 'get_store_profile_error' ]);
         wp_die();
      }
      wp_send_json_success([ 'message' => 'get_store_profile_ok', 'data' => $store[0] ]);
      wp_die();
   }
}