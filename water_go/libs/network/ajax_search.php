<?php

add_action( 'wp_ajax_nopriv_atlantis_search_data', 'atlantis_search_data' );
add_action( 'wp_ajax_atlantis_search_data', 'atlantis_search_data' );

function atlantis_search_data(){
   if( isset( $_POST['action'] ) && $_POST['action'] == 'atlantis_search_data' ){

      $lat = isset($_POST['lat']) ? $_POST['lat'] : 10.780900239854994;
      $lng = isset($_POST['lng']) ? $_POST['lng'] : 106.7226271387539;
      $search = isset($_POST['search']) ? $_POST['search'] : '';

      $multiple_word = implode(',', $search);


      $sql = "SELECT *
         FROM wp_watergo_products
         WHERE 
      ";

      global $wpdb;

      $res = $wpdb->get_results($sql);
      if( empty($res )){
         wp_send_json_error(['message' => 'search_not_found' ]);
         wp_die();
      }
      wp_send_json_error(['message' => 'search_found', 'data' => $res ]);
      wp_die();
   }

}