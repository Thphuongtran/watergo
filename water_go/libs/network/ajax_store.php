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


/**
 * @access TAB NREABY 
 */


function atlantis_get_store_nearby(){
   if( isset( $_POST['action'] ) && $_POST['action'] == 'atlantis_get_store_nearby' ){

      $lat     = isset($_POST['lat'])     ? $_POST['lat'] : 0;
      $lng     = isset($_POST['lng'])     ? $_POST['lng'] : 0;
      $how_far = isset($_POST['how_far']) ? $_POST['how_far'] : 10; // 5km default
      $limit   = isset($_POST['limit'])   ? $_POST['limit'] : 10;
      $offset  = isset($_POST['offset'])  ? $_POST['offset'] : 0;


      if($lat == 0 && $lng == 0){
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
         WHERE store_hidden = 0
         HAVING distance <= $how_far -- Adjust the distance value as desired (in kilometers)
         -- HAVING distance <= 1 -- testinng current store
         ORDER BY distance ASC
         LIMIT $offset, $limit
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

      $limit = isset($_POST['limit']) ? intval($_POST['limit']) : 10;
      $paged = isset($_POST['paged']) ? intval($_POST['paged']) : 1;
      // $paged = $paged * $limit;
      if( $paged == 0 || $paged == null){
         $paged = 1;
      }
      $offset = ($paged - 1) * $limit;

      global $wpdb;
      $sql = "SELECT 
         wp_watergo_store.*
         FROM wp_watergo_store
         WHERE store_hidden = 0
         ORDER BY id DESC 
         LIMIT $offset, $limit";
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
      
      if( empty( $res ) ){
         wp_send_json_error([ 'message' => 'store_not_found' ]);
         wp_die();
      }

      foreach( $res as $k => $vl ){
         $res[$k]->store_image = func_atlantis_get_images($vl->id, 'store', true);
         $res[$k]->description = stripcslashes($res[$k]->description);
      }

      $res[0]->store_image_full = func_atlantis_get_images($vl->id, 'store', true,"large");

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

      $store_id   = isset($_POST['store_id']) ? $_POST['store_id'] : 0;

      // no id get current store
      if( $store_id == 0 ){
         $store_id = func_get_store_id_from_current_user();
      }

      $sql = "SELECT * FROM wp_watergo_store WHERE id = $store_id LIMIT 1";
      global $wpdb;
      $res = $wpdb->get_results($sql);
      if( empty($res )){
         wp_send_json_error(['message' => 'get_store_error', 'sql' => $sql]);
         wp_die();
      }
      $res[0]->store_image = func_atlantis_get_images( $res[0]->id, 'store', true, "large" );

      // GET EMAIL FROM current user_id
      $user_data = get_userdata( $res[0]->user_id );
      $res[0]->email = $user_data->user_email;

      wp_send_json_success(['message' => 'get_store_ok', 'data' => $res[0] ]);
      wp_die();

   }
}

add_action( 'wp_ajax_nopriv_atlantis_store_profile_edit', 'atlantis_store_profile_edit' );
add_action( 'wp_ajax_atlantis_store_profile_edit', 'atlantis_store_profile_edit' );

function atlantis_store_profile_edit(){
   if( isset($_POST['action']) && $_POST['action'] == 'atlantis_store_profile_edit' ){
      global $wpdb;

      // get location store when update location
      $id            = isset($_POST['id']) ? $_POST['id'] : 0;
      $owner         = isset($_POST['owner']) ? $_POST['owner'] : '';
      $name          = isset($_POST['name']) ? $_POST['name'] : '';
      $description   = isset($_POST['description']) ? $_POST['description'] : '';
      $address       = isset($_POST['address']) ? $_POST['address'] : '';
      $phone         = isset($_POST['phone']) ? $_POST['phone'] : '';

      $password      = isset($_POST['password']) ? $_POST['password'] : '';
      $storeType     = isset($_POST['storeType']) ? $_POST['storeType'] : '';
      
      $imageUpload   = isset($_FILES['imageUpload']) ? $_FILES['imageUpload'] : null;

      $change_password_no_login_back = isset($_POST['change_password_no_login_back']) ? $_POST['change_password_no_login_back'] : 1;

      if( $id == 0 ){
         wp_send_json_error(['message' => 'store_edit_error' ]);
         wp_die();
      }

      if( $storeType == '' ){
         wp_send_json_error(['message' => 'store_edit_error' ]);
         wp_die();
      }

      $phone = str_replace(array('-', '.', ' '), '', $phone);
      $is_phone =  preg_match( '/^(032|033|034|035|036|037|038|039|086|096|097|098|081|082|083|084|085|088|091|094|056|058|092|070|076|077|078|079|089|090|093|099|059)+([0-9]{7})$/', $phone);

      if ( !$is_phone) {
         wp_send_json_error([ 'message' => 'phonenumber_is_not_correct_format']);
         wp_die();
      }

      // if( is_email($email) == false ){
      //    wp_send_json_error([ 'message' => 'email_is_not_correct_format']);
      //    wp_die();
      // }

      // $latitude   = 0;
      // $longitude  = 0;

      //$res_location = func_atlantis_get_location( $address );

      $latitude   = isset($_POST['latitude']) ? $_POST['latitude'] : 0;
      $longitude  = isset($_POST['longitude']) ? $_POST['longitude'] : 0;

      // wp_send_json_success(['message' => 'bug', 'res' => $res_location]);
      // wp_die();
      
      $updated = $wpdb->update('wp_watergo_store', [
         'owner'        => $owner,
         'name'         => $name,
         'description'  => $description,
         'address'      => $address,
         'phone'        => $phone,
         'latitude'     => $latitude,
         'longitude'    => $longitude,
         'store_type'   => $storeType
      ], ['id' => $id ]);

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

      // CHANGE PASSWORD
      if( $password != '' ){
         global $wpdb;
         $get_user_id = "SELECT user_id FROM wp_watergo_store WHERE id = $id ";
         $res_user_id = $wpdb->get_results($get_user_id);
         // $user = get_user_by('id', $res_user_id[0]->user_id );
         wp_set_password($password, $res_user_id[0]->user_id );
         $credentials = array(
            'user_login'    => $user->user_login,
            'user_password' => $password,
            'remember'      => true,
         );
         if($change_password_no_login_back == 1){
            wp_signon($credentials);
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

      $store_id   = func_get_store_id_from_current_user();
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


add_action( 'wp_ajax_nopriv_atlantis_get_store_email', 'atlantis_get_store_email' );
add_action( 'wp_ajax_atlantis_get_store_email', 'atlantis_get_store_email' );

function atlantis_get_store_email(){
   if( isset($_POST['action']) && $_POST['action'] == 'atlantis_get_store_email' ){
      
      $user_id   = isset($_POST['user_id']) ? $_POST['user_id'] : 0;

      if($user_id == 0 ){
         wp_send_json_error([ 'message' => 'get_store_email_error' ]);
         wp_die();
      }
      // $user       = get_user_by('id', $user_id);

      global $wpdb;
      $sql = "SELECT user_email FROM wp_users WHERE ID = $user_id ";
      $res = $wpdb->get_results($sql);
      if(!empty($res)){
         wp_send_json_success([ 'message' => 'get_store_email_ok', 'data' => $res[0] ]);
         wp_die();
      }

      wp_send_json_error([ 'message' => 'get_store_email_error' ]);
      wp_die();

   }
}

add_action( 'wp_ajax_nopriv_atlantis_store_hidden', 'atlantis_store_hidden' );
add_action( 'wp_ajax_atlantis_store_hidden', 'atlantis_store_hidden' );

function atlantis_store_hidden(){
   if( isset($_POST['action']) && $_POST['action'] == 'atlantis_store_hidden' ){
      $store_mulitple   = isset($_POST['store_mulitple']) ? $_POST['store_mulitple'] : '';

      if( $store_mulitple == ''){
         wp_send_json_error([ 'message' => 'get_store_error' ]);
         wp_die();
      }

      if( $store_mulitple != '' ){

         $store_decode  = json_decode( stripslashes( $store_mulitple ), true );
         $placeholders  = 0;
         $wheres = [];
         foreach( $store_decode as $ids ){
            $wheres[] = $ids;
         }
         $placeholders = implode(',', array_fill(0, count($wheres), '%d'));

         // STORE
         global $wpdb;
         $sql              = "UPDATE wp_watergo_store SET store_hidden = 1 WHERE id IN( $placeholders ) ";
         $prepare          = $wpdb->prepare($sql, $wheres);
         $wpdb->get_results($prepare);

         // PRODUCT
         $sql_products     = "UPDATE wp_watergo_products SET product_hidden = 1 WHERE store_id IN( $placeholders ) ";
         $prepare_products = $wpdb->prepare($sql_products, $wheres);
         $wpdb->get_results($prepare_products);

         // ORDER
         $sql_order        = "UPDATE wp_watergo_order SET order_hidden = 1 WHERE order_store_id IN( $placeholders ) ";
         $prepare_order    = $wpdb->prepare($sql_order, $wheres);
         $wpdb->get_results($prepare_order);

         // NOTIFICATION
         $sql_notification    = "UPDATE wp_watergo_notification SET notification_hidden = 1 WHERE store_id IN( $placeholders ) ";
         $prepare_notification = $wpdb->prepare($sql_notification, $wheres);
         $wpdb->get_results($prepare_notification);

         // ACCOUNT USER
         $sql_list_id_user = "SELECT user_id FROM wp_watergo_store WHERE id IN ( $placeholders ) ";
         $get_list_id_user = $wpdb->prepare($sql_list_id_user, $wheres);
         $res = $wpdb->get_results($get_list_id_user);
         if( ! empty( $res) ){
            foreach( $res as $k => $vl){
               update_user_meta( (int) $vl->user_id, 'account_hidden', 1 );
               // FORCE ACCOUNT TO LOGOUT -> DELETE from wp_usermeta [ column - session_tokens ]
               update_user_meta( (int) $vl->user_id, 'session_tokens', "" );
               $table = $wpdb->prefix."bj_user_push_token";
               $wpdb->update($table , ["token" => "","status" => ""], ["user_id" => $vl->user_id],["%s","%s"],["%d"]);
            }
         }
         


         wp_send_json_success([ 'message' => 'store_hidden_ok', 'res' => $res ]);
         wp_die();

      }

      wp_send_json_error([ 'message' => 'get_store_error' ]);
      wp_die();
   }
}


add_action( 'wp_ajax_nopriv_atlantis_count_store_pagination', 'atlantis_count_store_pagination' );
add_action( 'wp_ajax_atlantis_count_store_pagination', 'atlantis_count_store_pagination' );
function atlantis_count_store_pagination(){
   if( isset($_POST['action']) && $_POST['action'] == 'atlantis_count_store_pagination'){
      $limit = isset($_POST['limit']) ? $_POST['limit'] : 0;
      global $wpdb;
      $sql = "SELECT COUNT(*) AS total FROM wp_watergo_store WHERE store_hidden = 0";
      $res = $wpdb->get_results($sql);
      $total_pages = 0;
      if( $res[0]->total != null && $res[0]->total > 0 ){
         $total_pages = ceil($res[0]->total / $limit);
      }
      wp_send_json_success([ 'message' => 'store_pagination', 
         'data'         => $total_pages,
         'total_items'  => $res[0]->total
      ]);
      wp_die();
   }
}