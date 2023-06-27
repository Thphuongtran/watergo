<?php 

// $secure_user_id = md5( md5($user_id) . 'watergo' );


add_action( 'wp_ajax_nopriv_atlantis_upload', 'atlantis_upload' );
add_action( 'wp_ajax_atlantis_upload', 'atlantis_upload' );


function atlantis_upload(){
   // if( isset($_POST['action']) && $_POST['action'] == 'atlantis_upload' ){
      
   //    global $wpdb;

   //    $sql = "SELECT url FROM wp_watergo_photo";

   //    $res = $wpdb->get_results($sql);

   //    $export = [];

   //    $photo_dir = THEME_DIR . '/photo/';

   //    $upload = THEME_DIR . '/uploads/';

   //    foreach( $res as $k => $vl ){

   //    }

   //    wp_send_json_success(['res' => $res]);

   // }

   if (isset($_POST['action']) && $_POST['action'] == 'atlantis_upload') {

      $hash_id = bin2hex(random_bytes(40));

      $user_id = isset($_POST['user_id']) ? $_POST['user_id'] : 0;

      $hash_protect = md5( md5( $user_id . '-user') . 'watergo' );



      // global $wpdb;
      // $photo_dir = THEME_DIR . '/photo/';
      // $upload_dir = THEME_DIR . '/uploads/';

      
      // for( $i = 0; $i < count($export); $i++ ){
      //    $id = $export[$i]['id'];
      //    $url = $export[$i]['url'];

      //    $wpdb->insert('wp_watergo_photo', [
      //       'upload_by' => $id,
      //       'url' => $url,
      //       'time_created' => time(),
      //       'kind_photo' => 'store'
      //    ]);
      // }


      // $sql = "SELECT url FROM wp_watergo_photo";
      // $res = $wpdb->get_results($sql, ARRAY_A); // Fetch results as associative array

      // $export = [];

      // foreach ($res as $item) {
      //    $url = $item['url'];
      //    $file_parts = explode('-', $url);

      //    $filename = $file_parts[1] . '-' . $file_parts[2];
      //    $hash = $file_parts[0];

      //    $sourceFile = $photo_dir . $filename;
      //    $destination_file = $upload_dir . $url;

      //    $export[] = [
      //       'filename' => $filename,
      //       'hash' => $hash,
      //       // 'sourceFile' => $sourceFile,
      //       // 'destination_file' => $destination_file,
      //    ];

      //    // copy($sourceFile, $destination_file);

      // }

      wp_send_json_success(['res' => $hash_protect]);
   }

}


