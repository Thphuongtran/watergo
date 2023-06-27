<?php

add_action( 'wp_ajax_nopriv_atlantis_load_post', 'atlantis_load_post' );
add_action( 'wp_ajax_atlantis_load_post', 'atlantis_load_post' );

add_action( 'wp_ajax_nopriv_atlantis_fetch_category', 'atlantis_fetch_category' );
add_action( 'wp_ajax_atlantis_fetch_category', 'atlantis_fetch_category' );

add_action( 'wp_ajax_nopriv_atlantis_user_delivery_address', 'atlantis_user_delivery_address' );
add_action( 'wp_ajax_atlantis_user_delivery_address', 'atlantis_user_delivery_address' );

add_action( 'wp_ajax_nopriv_atlantis_user_notification', 'atlantis_user_notification' );
add_action( 'wp_ajax_atlantis_user_notification', 'atlantis_user_notification' );

add_action( 'wp_ajax_nopriv_atlantis_testing', 'atlantis_testing' );
add_action( 'wp_ajax_atlantis_testing', 'atlantis_testing' );

require_once THEME_DIR . '/libs/network/ajax_product.php';
require_once THEME_DIR . '/libs/network/ajax_store.php';
require_once THEME_DIR . '/libs/network/ajax_change_password.php';
require_once THEME_DIR . '/libs/network/ajax_user.php';
require_once THEME_DIR . '/libs/network/ajax_authentication.php';
require_once THEME_DIR . '/libs/network/ajax_sendcode.php';
require_once THEME_DIR . '/libs/network/ajax_support.php';
require_once THEME_DIR . '/libs/network/ajax_reviews.php';
require_once THEME_DIR . '/libs/network/ajax_category.php';
require_once THEME_DIR . '/libs/network/ajax_order.php';
require_once THEME_DIR . '/libs/network/ajax_notification.php';
require_once THEME_DIR . '/libs/network/ajax_chat.php';
require_once THEME_DIR . '/libs/network/ajax_search.php';
require_once THEME_DIR . '/libs/network/ajax_social.php';
require_once THEME_DIR . '/libs/network/ajax_upload.php';

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







function atlantis_user_delivery_address(){
   if( isset($_POST['action']) && $_POST['action'] == 'atlantis_user_delivery_address' ){
      $name    = isset($_POST['name']) ? $_POST['name'] : '';
      $phone   = isset($_POST['phone']) ? $_POST['phone'] : '';
      $address = isset($_POST['address']) ? $_POST['address'] : '';
      $primary = isset($_POST['primary']) ? $_POST['primary'] : '';
      $id_delivery = isset($_POST['id_delivery']) ? $_POST['id_delivery'] : '';
      $event   = isset($_POST['event']) ? $_POST['event'] : '';


      if(is_user_logged_in() == true ){
         $user_id = get_current_user_id();
         $user = get_user_by('id', $user_id);
         $prefix_user = 'user_' . $user->data->ID;
      }else{
         wp_send_json_error(['message' => 'no_login_invalid' ]);
         wp_die();
      }

      $conditions = [
         'id'        => $id_delivery,
         'user_id'   => $user_id
      ];

      if( $event == '' ){
         wp_send_json_error([ 'message' => 'delivery_address_service_error' ]);
         wp_die();
      }

      global $wpdb;

      // GET EVENT

      if( $event == 'get' ){
         $sql = "SELECT * FROM wp_delivery_address WHERE user_id={$user_id}";
         $res = $wpdb->get_results($sql);
         if( empty( $res )){
            wp_send_json_error([ 'message' => 'no_delivery_address_service_found' ]);
            wp_die();
         }else{
            wp_send_json_success([ 'message' => 'get_delivery_address_ok', 'data' => $res ]);
            wp_die();  
         }
      }

      // ADD EVENT
      if( $event == 'add' ){
         if( $name != '' && $phone != '' && $address != '' ){

            // IF SET PRIMARY TO 1
            if( $primary == 1 || $primary == "1" ){
               $sql_set_primary_all_false = "UPDATE wp_delivery_address SET wp_delivery_address.primary = 0 WHERE user_id = {$user_id}";
               $wpdb->query($sql_set_primary_all_false);
            }

            $args = [
               'name' => $name,
               'phone' => $phone,
               'address' => $address,
               'user_id' => $user_id,
               'primary' => $primary 
            ];
            $add_id = $wpdb->insert('wp_delivery_address', $args);
         }

         wp_send_json_success([ 'message' => 'add_delivery_address_ok', 'data' => $add_id ]);
         wp_die();
      }

      // UPDATE EVENT
      if( $event == 'update' ){
         if( $name != '' && $phone != '' && $address != '' ){
            // IF SET PRIMARY TO 1
            if( $primary == 1 || $primary == "1" ){
               $sql_set_primary_all_false = "UPDATE wp_delivery_address SET wp_delivery_address.primary = 0 WHERE user_id = {$user_id}";
               $wpdb->query($sql_set_primary_all_false);
            }
            $args = [
               'name' => $name,
               'phone' => $phone,
               'address' => $address,
               'primary' => $primary 
            ];
            $wpdb->update('wp_delivery_address', $args, $conditions );
         }
  
         wp_send_json_success(['message' => 'update_delivery_address_ok', 'data' => $args ]);
         wp_die();
      }

      // DELETE EVENT
      if( $event == 'delete' ){
         if( $id_delivery == '' ){
            wp_send_json_error([ 'message' => 'delete_delivery_address_error' ]);
            wp_die();
         }
         $wpdb->delete('wp_delivery_address', $conditions );
         // DELETE
         wp_send_json_success([ 'message' => 'delete_delivery_address_ok' ]);
         wp_die();
      }

   }
}


function atlantis_user_notification(){
   if( isset($_POST['action']) && $_POST['action'] == 'atlantis_user_notification' ){

      if(is_user_logged_in() == true ){
         $user_id = get_current_user_id();
         $user = get_user_by('id', $user_id);
         $prefix_user = 'user_' . $user->data->ID;
      }else{
         wp_send_json_error(['message' => 'no_Login_invalid' ]);
         wp_die();
      }
      $value = isset($_POST['notification']) ? $_POST['notification'] : 0;
      update_field('user_notification', $value, 'user_' . $user_id );
      wp_send_json_success([ 'message' => 'update_notification_ok', 'data' => $value ]);
      wp_die();
   }
}



function atlantis_testing(){
   if( isset($_POST['action']) && $_POST['action'] == 'atlantis_testing' ){
      
      wp_send_json_success([ 'message' => 'THIS IS TESING AJAX']);
      wp_die();
   }
}