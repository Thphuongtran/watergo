<?php

add_action('wp_ajax_atlantis_share_link', 'atlantis_share_link');
add_action('wp_ajax_nopriv_atlantis_share_link', 'atlantis_share_link');

function atlantis_share_link() {
   if ( isset($_POST['action']) && $_POST['action'] == 'atlantis_share_link' ){
      $link = isset($_POST['link'] ) ? $_POST['link'] : '';
      // $key = 'AIzaSyCVQVjRvIZk42T1pz5huPzkyne4DHvkCeQ';
      
      $key = 'AIzaSyCrzNevcsX8uanA8wxSezqj9aPNi_YGrqk';
      $url = 'https://firebasedynamiclinks.googleapis.com/v1/shortLinks?key=' . $key;
      $data = array(
         "dynamicLinkInfo" => array(
            "dynamicLinkDomain" => "watergo.page.link",
            "link" => $link,
            "socialMetaTagInfo" => array(
               "socialTitle"        => 'Watergo',
               "socialDescription"  => '',
               "socialImageLink"    => ''
            ),
            "androidInfo" => array(
               "androidPackageName"    => "com.watergo.app"
            ),
            "iosInfo" => array(
               "iosBundleId" => "com.watergo.app",
               "iosAppStoreId" => "1639926245"
            )
         )
      );

      $response = wp_remote_post(
         $url,
         array(
            'method' => 'POST',
            'headers' => [ 'Content-Type' => 'application/json' ],
            'body' => json_encode($data),
         )
      );

      if (is_wp_error($response)) {
         // wp_json_send_error( ['message' => 'bug']);
         // wp_die();

      } else {
         $short_url = json_decode(wp_remote_retrieve_body($response));

         // if (isset($short_url->error)) {
         //    echo "error";
         // } else {
         //    echo $short_url->shortLink;
         // }

         wp_send_json_success(['message' => 'share_success', 'data' => $short_url ]);
         wp_die();
      }

      // $headers = array('Content-Type: application/json');

      // $ch = curl_init ();
      // curl_setopt ( $ch, CURLOPT_URL, $url );
      // curl_setopt ( $ch, CURLOPT_POST, true );
      // curl_setopt ( $ch, CURLOPT_HTTPHEADER, $headers );
      // curl_setopt ( $ch, CURLOPT_RETURNTRANSFER, true );
      // curl_setopt ( $ch, CURLOPT_POSTFIELDS, json_encode($data) );

      // $data = curl_exec ( $ch );
      // curl_close ( $ch );

      // $short_url = json_decode($data);
      // if(isset($short_url->error)){
      //    echo "error";
      // } else {
      //    echo $short_url->shortLink;
      // }

      

      // die();
   }

}