<?php

add_action( 'wp_ajax_nopriv_atlantis_get_location', 'atlantis_get_location' );
add_action( 'wp_ajax_atlantis_get_location', 'atlantis_get_location' );


function atlantis_get_location(){
   if( isset($_POST['action']) && $_POST['action'] == 'atlantis_get_location' ){

      $address = isset($_POST['address']) ? $_POST['address'] : '';

      $keyID       = get_key_map();
      $url_request = 'https://geocode.search.hereapi.com/v1/geocode';

      $query_params = [
         'q'      => $address,
         'apiKey' => $keyID,
         'in'     => 'countryCode:VNM',
         'limit'  => 1
      ];

      $url        = add_query_arg($query_params, $url_request);
      $response   = wp_remote_get($url);
      $body       = wp_remote_retrieve_body($response);
      $latitude   = 0;
      $longitude  = 0;

      if( !empty($body) && $body != '' ){
         $body             = json_decode( $body);
         if( $body->items[0]->position->lat != null){
            $latitude = $body->items[0]->position->lat;
         }
         if( $body->items[0]->position->lng != null ){
            $longitude = $body->items[0]->position->lng;
         }
      }

      // Handle the response
      if (!is_wp_error($response)) {
         // Process the body of the response
         wp_send_json_success( [ 'message' => 'location_found', 'res' => [
            'latitude'  => $latitude,
            'longitude' => $longitude
         ] ]);
         wp_die();
      }

      // Handle error case
      wp_send_json_error(['message' => $response->get_error_message() ]);
      wp_die();

   }
}

function func_atlantis_get_location( $address ){

   $keyID         = get_key_map();
   $url_request   = 'https://geocode.search.hereapi.com/v1/geocode';

   $query_params  = [
      'q'      => $address,
      'apiKey' => $keyID,
      'in'     => 'countryCode:VNM',
      'limit'  => 1
   ];

   $url        = add_query_arg($query_params, $url_request);
   $response   = wp_remote_get($url);
   $body       = wp_remote_retrieve_body($response);
   $latitude   = 0;
   $longitude  = 0;

   if( !empty($body) && $body != '' ){
      $body             = json_decode( $body);
      if( $body->items[0]->position->lat != null){
         $latitude = $body->items[0]->position->lat;
      }
      if( $body->items[0]->position->lng != null ){
         $longitude = $body->items[0]->position->lng;
      }
   }

   // Handle the response
   return [ 'latitude' => $latitude, 'longitude' => $longitude ];

   // Handle error case
   // return $response->get_error_message();
}