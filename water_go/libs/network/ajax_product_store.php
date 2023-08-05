<?php

/**
 * @access FOR TAB PRODUCT-STORE
 */
add_action( 'wp_ajax_nopriv_atlantis_get_store_type_product', 'atlantis_get_store_type_product' );
add_action( 'wp_ajax_atlantis_get_store_type_product', 'atlantis_get_store_type_product' );

add_action( 'wp_ajax_nopriv_atlantis_get_product_from_store', 'atlantis_get_product_from_store' );
add_action( 'wp_ajax_atlantis_get_product_from_store', 'atlantis_get_product_from_store' );

add_action( 'wp_ajax_nopriv_atlantis_get_product_category', 'atlantis_get_product_category' );
add_action( 'wp_ajax_atlantis_get_product_category', 'atlantis_get_product_category' );


function atlantis_get_store_type_product(){
   if( isset($_POST['action']) && $_POST['action'] == 'atlantis_get_store_type_product' ){
      $store_id = func_get_store_id_from_current_user();

      global $wpdb;

      $sql_get_store_product_type = "SELECT store_type FROM wp_watergo_store WHERE id = $store_id ";

      $res = $wpdb->get_results( $sql_get_store_product_type);
      if( !empty( $res )){
         wp_send_json_success(['message' => 'get_type_product_ok', 'data' => $res[0]->store_type ]);
         wp_die();
      }

      wp_send_json_error(['message' => 'get_type_product_error']);
      wp_die();

   }
}


function atlantis_get_product_from_store(){
   if( isset($_POST['action']) && $_POST['action'] == 'atlantis_get_product_from_store'){
      
      $store_id = func_get_store_id_from_current_user();
      $type_product  = isset($_POST['type_product']) ? $_POST['type_product'] : null;

      if( $type_product == null){
         wp_send_json_error(['message' => 'product_not_found']);
         wp_die();
      }

      $products = func_atlantis_get_product_by([
         'id' => $store_id,
         'get_by' => 'store_id',
         'get_by_product_type' => $type_product
      ]);
      
      if( empty($products )){
         wp_send_json_error(['message' => 'product_not_found']);
         wp_die();
      }

      // GET SOLD PRODUCT + IMAGE PRODUCT
      foreach( $products as $k => $p ){
         // SOLD PRODUCT
         $sold = func_count_sold_product($p->id, $store_id);
         if( $sold == null ){
            $products[$k]->sold = 0;
         }else{
            $products[$k]->sold = $sold;
         }
      }

      wp_send_json_success(['message' => 'product_found', 'data' => $products ]);
      wp_die();



   }
}

function atlantis_get_product_category(){
   if( isset($_POST['action']) && $_POST['action'] == 'atlantis_get_product_category'){

      $sql = "SELECT * FROM wp_watergo_product_category";
      global $wpdb;

      $res = $wpdb->get_results($sql);

      if( empty( $res )){
         wp_send_json_error(['message' => 'product_category_not_found']);
         wp_die();
      }
      wp_send_json_success(['message' => 'product_category_found', 'data' => $res ]);
      wp_die();
   }
}

/**
 * @access ACTION [ ADD - EDIT - DELETE] product => Tab Product
 */

add_action( 'wp_ajax_nopriv_atlantis_action_product_store', 'atlantis_action_product_store' );
add_action( 'wp_ajax_atlantis_action_product_store', 'atlantis_action_product_store' );

function atlantis_action_product_store(){
   if( isset($_POST['action']) && $_POST['action'] == 'atlantis_action_product_store'){
      $event         = isset($_POST['event'] ) ? $_POST['event'] : '';
      $product_type  = isset($_POST['product_type']) ? $_POST['product_type'] : '';
      $store_id      = isset($_POST['store_id']) ? $_POST['store_id'] : 0;
      $product_id    = isset($_POST['product_id']) ? $_POST['product_id'] : 0;

     

      if( $product_type == '' || $event == ''){
         wp_send_json_error(['message' => 'action_product_store_error']);
         wp_die();
      }

      $category_id = isset($_POST['category_id']) ? $_POST['category_id'] : 0; // from category table
      $price = isset($_POST['price']) ? $_POST['price'] : 0;
      // $stock = isset($_POST['stock']) ? $_POST['stock'] : 0;
      $mark_out_of_stock = isset($_POST['mark_out_of_stock']) ? $_POST['mark_out_of_stock'] : 0;

      // IF DISCOUNT ENABLE
      $has_discount     = isset($_POST['has_discount']) ? $_POST['has_discount'] : 0;
      $discount_percent = isset($_POST['discount_percent']) ? $_POST['discount_percent'] : 0;

      $discount_from    = isset($_POST['discount_from']) ? $_POST['discount_from'] : 0;
      $discount_to      = isset($_POST['discount_to']) ? $_POST['discount_to'] : 0;

      
      // if( $discount_from != null || $discount_from != 0 ){
      //    $discount_from = DateTime::createFromFormat('d/m/Y', $discount_from);
      //    if( $discount_from != false ){
      //       $discount_from = $discount_from->format('Y-m-d');
      //    }
      // }
      // if( $discount_to != null || $discount_to != 0 ){
      //    $discount_to = DateTime::createFromFormat('d/m/Y', $discount_to);
      //    if( $discount_to != false ){
      //       $discount_to = $discount_to->format('Y-m-d');
      //    }
      // }

      $product_description = isset($_POST['product_description']) ? $_POST['product_description'] : '';

      // SIZE DESCRIPTION
         // TYPE ICE
         $ice_weight    = isset($_POST['ice_weight']) ? $_POST['ice_weight'] : 0; // from category table
         $length_width  = isset($_POST['length_width']) ? $_POST['length_width'] : 0; 

         // TYPE WATER
         $water_brand      = isset($_POST['water_brand']) ? $_POST['water_brand'] : 0; // from category table
         $water_quantity   = isset($_POST['water_quantity']) ? $_POST['water_quantity'] : 0; // from category table
         $water_volume     = isset($_POST['water_volume']) ? $_POST['water_volume'] : 0; // from category table
      
      // uploadImages
      $uploadImages = isset($_FILES['uploadImages']) ? $_FILES['uploadImages'] : null;

      

      $arg_discount = [];
      if( $has_discount == 1 ){
         $arg_discount['has_discount']       = $has_discount;
         $arg_discount['discount_percent']   = $discount_percent;
         $arg_discount['discount_from']      = $discount_from;
         $arg_discount['discount_to']        = $discount_to;
      }else if( $has_discount == 0 || $has_discount == null ){
         $arg_discount['has_discount']       = 0;
         $arg_discount['discount_percent']   = 0;
         $arg_discount['discount_from']      = 0;
         $arg_discount['discount_to']        = 0;
      }

      // wp_send_json_success(['message' => 'bug', 'arg_discount' => $arg_discount ]);
      // wp_die();


      /**
      *  @access ADD PRODUCT
      */

      $args = [
         'store_id'           => $store_id,
         'product_type'       => $product_type,
         'description'        => (String) $product_description,
         'price'              => $price,
         'mark_out_of_stock'  => $mark_out_of_stock,
         'created_at'         => atlantis_current_date_only('Y-m-d H:m:s')
         // 'stock'           => $stock,
      ];

      // wp_send_json_success(['message' => 'bug', 'res' => $args ]);
      // wp_die();


      if(!empty($arg_discount)){
         $args = array_merge($args, $arg_discount);
      }

      if( $event == 'add' ){
         global $wpdb;
         $_product_id_insert = null;
         if( $product_type == 'ice' ) {
            $args['category']       = $category_id;
            $args['weight']         = $ice_weight;
            $args['length_width']   = $length_width;
            $wpdb->insert('wp_watergo_products',  $args);
            $_product_id_insert = $wpdb->insert_id;
         }

         if( $product_type == 'water' ) {
            $args['category']  = $category_id;
            $args['brand']     = $water_brand;
            $args['quantity']  = $water_quantity;
            $args['volume']    = $water_volume;
            $wpdb->insert('wp_watergo_products',  $args);
            $_product_id_insert = $wpdb->insert_id;
         }
         if( $_product_id_insert != null ){
            $list_attachment = func_atlantis_upload_no_ajax('product', $uploadImages);
            if( !empty($list_attachment)){
               foreach($list_attachment as $k => $attachment_id ){
                  $wpdb->insert('wp_watergo_attachment', [
                     'attachment_id'   => $attachment_id,
                     'related_id'      => $_product_id_insert,
                     'attachment_type' => 'product'
                  ]);
               }
            }
            wp_send_json_success(['message' => 'action_product_ok' ]);
            wp_die();
         }
         
         wp_send_json_error(['message' => 'action_product_error' ]);
         wp_die();
      }

      /**
      * @access EIDT 
      */
      if( $event == 'edit' ){
         global $wpdb;
         // 1 DELETE ALL

         if($product_type == 'ice'){
            $args['category'] = $category_id;
            $args['weight'] = $ice_weight;
            $args['length_width'] = $length_width;
         }
         if($product_type == 'water'){
            $args['category']  = $category_id;
            $args['brand']     = $water_brand;
            $args['quantity']  = $water_quantity;
            $args['volume']    = $water_volume;
         }

         // DO UPLOAD IMAGE
         if($product_id != null ){
            $list_attachment = func_atlantis_upload_no_ajax('product', $uploadImages);
            if( !empty($list_attachment)){
               foreach($list_attachment as $k => $attachment_id ){
                  $wpdb->insert('wp_watergo_attachment', [
                     'attachment_id'   => $attachment_id,
                     'related_id'      => $product_id,
                     'attachment_type' => 'product'
                  ]);
               }
            }

            // DO DELETE IMAGE
            $list_attachment_id_delete = isset($_POST['list_attachment_id_delete']) ? $_POST['list_attachment_id_delete'] : null;
            if($list_attachment_id_delete != null ){
               $list_attachment_id_delete = json_decode( $list_attachment_id_delete );
               foreach ($list_attachment_id_delete as $attachment_id) {
                  // Delete the attachment
                  wp_delete_attachment($attachment_id, true);
                  $wpdb->delete('wp_watergo_attachment',[
                     'attachment_id' => $attachment_id
                  ], [ '%d' ]);
               }
            }

            // FOR REMOVE DISCOUNT
            $force_remove_has_discount = isset($_POST['force_remove_has_discount']) ? $_POST['force_remove_has_discount'] : null;
            if( $force_remove_has_discount != null && $force_remove_has_discount == 1){
               $args['has_discount']      = 0;
               $args['discount_percent']  = 0;
               $args['discount_from']     = 0;
               $args['discount_to']       = 0;
            }

            // UPDATE FIELD 
            $updated = $wpdb->update('wp_watergo_products', $args, ['id' => $product_id] );

            wp_send_json_success([ 'message' => 'action_product_ok']);
            wp_die();
         }
      }

      /**
       * @access DELETE
       */

      if( $event == 'delete' ){
         global $wpdb;
         // DO DELETE IMAGE
         $list_attachment_id_delete = isset($_POST['list_attachment_id_delete']) ? $_POST['list_attachment_id_delete'] : null;
         if($list_attachment_id_delete != null ){
            $list_attachment_id_delete = json_decode( $list_attachment_id_delete );
            foreach ($list_attachment_id_delete as $attachment_id) {
               // Delete the attachment
               wp_delete_attachment($attachment_id, true);
            }
            $wpdb->delete('wp_watergo_attachment',[ 'related_id' => $product_id ], [ '%d' ]);
         }
         $deleted = $wpdb->delete('wp_watergo_products',[ 'id' => $product_id ], [ '%d' ]);
         if( $deleted ){
            wp_send_json_success([ 'message' => 'action_product_ok']);
            wp_die();
         }
         wp_send_json_error([ 'message' => 'action_product_error']);
         wp_die();
      }
      
   }
}