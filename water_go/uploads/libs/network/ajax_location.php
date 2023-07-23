<?php

add_action( 'wp_ajax_nopriv_atlantis_get_location', 'atlantis_get_location' );
add_action( 'wp_ajax_atlantis_get_location', 'atlantis_get_location' );


function atlantis_get_location(){
   if( isset($_POST['action']) && $_POST['action'] == 'atlantis_get_location' ){

      $address = $_POST['address'];

      // $url_request = 'https://geocode.search.hereapi.com/v1/geocode';
      // $keyID = 'nJEYTwZNrpgfDSKEA4VzYO2R-NNL1grWFpf3y60aK1k';

      // $response = wp_remote_get( $url_request, [
      //    'q'      => $address,
      //    'apiKey' => $keyID
      // ] );

      // $body     = wp_remote_retrieve_body( $response );

      // wp_send_json_success(['message' => 'testing location', 'res' => $response, 'body' => $body ]);

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
         $position['lat']  = $body->items[0]->position->lat;
         $position['lng']  = $body->items[0]->position->lng;
      }

      // Handle the response
      if (!is_wp_error($response)) {
         // Process the body of the response
         // echo $body;
         wp_send_json_success(['message' => 'testing location', 'res' => $body  ]);
      } else {
         // Handle error case
         $error_message = $response->get_error_message();
      }

   }
}