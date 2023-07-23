<?php 

add_action( 'wp_ajax_nopriv_atlantis_upload', 'atlantis_upload' );
add_action( 'wp_ajax_atlantis_upload', 'atlantis_upload' );

add_action( 'wp_ajax_nopriv_atlantis_get_all_image_product', 'atlantis_get_all_image_product' );
add_action( 'wp_ajax_atlantis_get_all_image_product', 'atlantis_get_all_image_product' );


/**
 * @access USING LIBRARY UPLOAD
 */
function atlantis_upload(){
   if( isset($_POST['action']) && $_POST['action'] == 'atlantis_upload' ){
      $files               = isset($_FILES['uploadImages'])    ? $_FILES['uploadImages'] : null;
      $attachment_type     = isset($_POST['attachment_type'])  ? $_POST['attachment_type'] : null;
      // attachment_type [ user_avatar | store | product ]
      
      $res = func_atlantis_upload_no_ajax($attachment_type, $files);
      if( empty($res )){
         wp_send_json_error(['message' => 'upload_fail']);
         wp_die();
      }
      wp_send_json_succes(['message' => 'upload_ok', 'data' => $res]);
      wp_die();

   }
}


/**
 * @access UPLOAD NO AJAX
 * @return [] list attachment
 */

function func_atlantis_upload_no_ajax($attachment_type, $files ){

   // attachment_type [ user_avatar | store | product ]
   if( $attachment_type == null || $files == null ) return [];
   if( !empty( $files ) ){
      $files = sort_image_data($files);
      $list_attachment_id = [];
      global $wpdb;
      
      foreach( $files as $kFile => $file ){

         if ( $file['error'] == UPLOAD_ERR_OK ) {
            require_once(ABSPATH . 'wp-admin/includes/file.php');
            require_once(ABSPATH . 'wp-admin/includes/image.php');
            require_once(ABSPATH . 'wp-admin/includes/media.php');

            $uploaded_file = wp_handle_upload($file, array('test_form' => false));
            $attachment = array(
               'post_mime_type' => $uploaded_file['type'],
               'post_title' => preg_replace('/\.[^.]+$/', '', basename($uploaded_file['file'])),
               'post_content' => '',
               'post_status' => 'inherit'
            );
            $attachment_id = wp_insert_attachment($attachment, $uploaded_file['file']);
            $attachment_data = wp_generate_attachment_metadata($attachment_id, $uploaded_file['file']);
            wp_update_attachment_metadata($attachment_id, $attachment_data);
            // make that group image 
            update_field('attachment_type', $attachment_type, $attachment_id );
            $list_attachment_id[] = $attachment_id;
         }
      }

      return $list_attachment_id;
   }
   return [];
}

function atlantis_get_all_image_product(){
   if( isset($_POST['action']) && $_POST['action'] == 'atlantis_get_all_image_product'){

      $attachment_type   = isset($_POST['attachment_type']) ? $_FILES['attachment_type'] : null;
      // photo album [ user_avatar | store | product ]

      $user_id = get_current_user_id();

      $args = array(
         'author'       => $user_id,
         'post_status'  => 'any',
         'post_type'    => 'attachment',
         'meta_key'     => 'attachment_type',
         'meta_value'   => $attachment_type,
         'meta_compare' => '==',
         'fields'       => 'ids'
      );

      $query = get_posts( $args );
      $new_arr = [];

      if( empty( $query )){
         wp_send_json_error(['message' => 'image_not_found']);
         wp_die();
      }

      foreach( $query as $k => $vl ){
         $attachment = wp_get_attachment_image_url($vl);
         $new_arr[$k]['id'] = $vl;
         $new_arr[$k]['url'] = $attachment;
      }

      wp_send_json_success(['message' => 'image_found', 'data' => $new_arr]);
      wp_die();
      
   }
}
