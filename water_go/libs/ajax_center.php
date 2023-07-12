<?php

add_action( 'wp_ajax_nopriv_atlantis_load_post', 'atlantis_load_post' );
add_action( 'wp_ajax_atlantis_load_post', 'atlantis_load_post' );

add_action( 'wp_ajax_nopriv_atlantis_fetch_category', 'atlantis_fetch_category' );
add_action( 'wp_ajax_atlantis_fetch_category', 'atlantis_fetch_category' );

add_action( 'wp_ajax_nopriv_atlantis_user_notification', 'atlantis_user_notification' );
add_action( 'wp_ajax_atlantis_user_notification', 'atlantis_user_notification' );

add_action( 'wp_ajax_nopriv_atlantis_testing', 'atlantis_testing' );
add_action( 'wp_ajax_atlantis_testing', 'atlantis_testing' );


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

      $datetime = isset($_POST['datetime']) ? $_POST['datetime'] : 0;

      $sql = "SELECT *,
         wp_watergo_store.name as store_name,
         -- latitude
         wp_watergo_store.latitude as store_latitude,
         -- longitude
         wp_watergo_store.longitude as store_longitude,
            
         -- order_time_shipping_id
         wp_watergo_order.order_time_shipping_id as store_order_time_shipping_id,

         wp_watergo_products.name as product_name,
         wp_watergo_photo.url as product_image

         -- time shipping
         FROM wp_watergo_order
         LEFT JOIN wp_watergo_order_group 
            ON wp_watergo_order_group.hash_id = wp_watergo_order.hash_id
         LEFT JOIN wp_watergo_store
            ON wp_watergo_store.id = wp_watergo_order_group.order_group_store_id
         LEFT JOIN wp_watergo_products 
            ON wp_watergo_products.id = wp_watergo_order_group.order_group_product_id
         LEFT JOIN wp_watergo_photo
            ON wp_watergo_photo.upload_by = wp_watergo_products.id AND wp_watergo_photo.kind_photo = 'product'
         LEFT JOIN wp_watergo_order_time_shipping
            ON wp_watergo_order_time_shipping.order_time_shipping_id = wp_watergo_order.order_time_shipping_id
         -- 

         WHERE
            wp_watergo_store.id = 22
         AND 
            wp_watergo_order.order_status = 'confirmed'
         AND
            wp_watergo_order.order_id NOT IN (0)
         AND 
            wp_watergo_order_time_shipping.order_time_shipping_datetime = '$datetime'
      ";

      global $wpdb;
      $res = $wpdb->get_results($sql);

      wp_send_json_success(['message' => 'ok', 'res' => $res, 'datetime' => $datetime ]);


   }
}

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
require_once THEME_DIR . '/libs/network/ajax_language.php';
require_once THEME_DIR . '/libs/network/ajax_admin_supports.php';
