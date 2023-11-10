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
      $store_id      = isset($_POST['store_id']) ? $_POST['store_id'] : null;
      if( ! is_user_logged_in() || $store_id == null){
         wp_send_json_error(['message' => 'get_type_product_error']);
         wp_die();
      }
      global $wpdb;
      $sql_get_store_product_type = "SELECT store_type FROM wp_watergo_store WHERE id = $store_id";
      $res = $wpdb->get_results( $sql_get_store_product_type);
      if( !empty( $res )){
         wp_send_json_success(['message' => 'get_type_product_ok', 'data' => $res[0]->store_type ]);
         wp_die();
      }

      wp_send_json_error(['message' => 'get_type_product_error']);
      wp_die();

   }
}


add_action( 'wp_ajax_nopriv_atlantis_get_single_product_from_store', 'atlantis_get_single_product_from_store' );
add_action( 'wp_ajax_atlantis_get_single_product_from_store', 'atlantis_get_single_product_from_store' );

function atlantis_get_single_product_from_store(){
   if( isset($_POST['action']) && $_POST['action'] == 'atlantis_get_single_product_from_store'){
      
      $store_id      = func_get_store_id_from_current_user();
      // $type_product  = isset($_POST['type_product']) ? $_POST['type_product'] : null;
      $product_id    = isset($_POST['product_id']) ? $_POST['product_id'] : null;
      $is_get_product_pending = isset($_POST['get_product_pending']) ? $_POST['get_product_pending'] : 0;

      if( $product_id == null || $product_id == 0){
         wp_send_json_error(['message' => 'product_not_found']);
         wp_die();
      }

      $products = func_atlantis_get_product_by([
         'id'                    => $product_id,
         'get_by'                => $is_get_product_pending == 1 ? 'product_id_pending' : 'product_id',
         'limit_image'           => true
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

      wp_send_json_success(['message' => 'product_found', 'data' => $products[0] ]);
      wp_die();
   }
}

function atlantis_get_product_from_store(){
   if( isset($_POST['action']) && $_POST['action'] == 'atlantis_get_product_from_store'){
      
      $store_id      = isset($_POST['store_id']) ? $_POST['store_id'] : null;
      $product_type  = isset($_POST['product_type']) ? $_POST['product_type'] : null;
      $offset        = isset($_POST['offset']) ? $_POST['offset'] : 0;
      $limit         = isset($_POST['limit']) ? $_POST['limit'] : 10;

      if( $product_type == null || $store_id == null ){
         wp_send_json_error(['message' => 'product_not_found']);
         wp_die();
      }

      $type_product_arr = [];

      if( $product_type == 'water'){ $type_product_arr = ['water', 'water_device']; }
      if( $product_type == 'ice'){ $type_product_arr = ['ice', 'ice_device']; }

      // $type_product_string = implode('", "', array_map('esc_sql', $type_product_arr));
      $type_product_string = "'" . implode("', '", array_map('esc_sql', $type_product_arr)) . "'";

      global $wpdb;

      $sql = "SELECT * FROM wp_watergo_products 
         WHERE store_id = $store_id 
         AND ( product_hidden != 1 OR ( product_hidden = 1 AND status = 'pending' ) )
         AND product_type IN ($type_product_string)
         ORDER BY id DESC
         LIMIT $offset, $limit
      ";

      $products = $wpdb->get_results($sql);
      // wp_send_json_error(['message' => 'bug', 'res' => $products ]);
      // wp_die();

      if( !empty($products ) ){
         foreach($products as $k => $vl){
            // IMAGE PRODUCT
            $products[$k]->product_image  = func_atlantis_get_images($vl->id, 'product', true, 'medium');
            $products[$k]->description    = stripcslashes($description);

            if( $vl->product_type == 'water'){
               $vl->name                     = $vl->brand;
               $vl->name_second              = $vl->quantity . ' ' . $vl->volume;
            }else if( $vl->product_type == 'ice'){
               $vl->name                     = $vl->category;
               $vl->name_second              = $vl->weight . 'kg ' . $vl->length_width . ' mm';
            }else if( $vl->product_type == 'water_device'){
               $vl->name                     = $vl->name_device;
               $vl->name_second              = $vl->feature_device;
            }else if( $vl->product_type == 'ice_device'){
               $vl->name                     = $vl->name_device;
               $vl->name_second              = $vl->capacity_device;
            }
         }
         // GET SOLD PRODUCT
         foreach( $products as $k => $p ){
            // SOLD PRODUCT
            $sold = func_count_sold_product($p->id, $store_id);
            if( $sold == null ){
               $products[$k]->sold = 0;
            }else{
               $products[$k]->sold = $sold;
            }
         }
      }

      if( !empty($products)){
         wp_send_json_success(['message' => 'product_found', 'data' => $products ]);
         wp_die();
      }

      wp_send_json_error(['message' => 'product_not_found']);
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
      $event         = isset($_POST['event'] )        ? $_POST['event'] : '';
      $product_type  = isset($_POST['product_type'])  ? $_POST['product_type'] : '';
      $store_id      = isset($_POST['store_id'])      ? $_POST['store_id'] : 0;
      $product_id    = isset($_POST['product_id'])    ? $_POST['product_id'] : 0;


      wp_send_json_error(['message' => 'bug', 'res' => $_POST ]);
      wp_die();

      $allow_event = ['add', 'edit', 'delete'];

      if( $product_type == '' || $event == '' || !in_array( $event, $allow_event)){
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
         'description'        => $product_description,
         'price'              => $price,
         'mark_out_of_stock'  => $mark_out_of_stock,
         'created_at'         => atlantis_current_date_only('Y-m-d H:m:s')
      ];


      if(!empty($arg_discount)){
         $args = array_merge($args, $arg_discount);
      }

      if( $event == 'add' ){
         global $wpdb;
         $_product_id_insert = null;
         if( $product_type == 'ice' ) {
            $args['category']       = $category_id;
            $args['weight']         = (int) $ice_weight;
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
            wp_send_json_success(['message' => 'action_product_ok', 'data' => $_product_id_insert ]);
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
            $args['category']       = $category_id;
            $args['weight']         = (int) $ice_weight;
            $args['length_width']   = $length_width;
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
            $updated = $wpdb->update('wp_watergo_products', $args, ['id' => $product_id ] );

            wp_send_json_success([ 'message' => 'action_product_ok', 'data' => $product_id]);
            wp_die();
         }
      }

      /**
       * @access DELETE
       */

      if( $event == 'delete' ){
         global $wpdb;

         $updated = $wpdb->update('wp_watergo_products', ['product_hidden' => 1, 'status' => 'delete' ], [ 'id' => $product_id ]);
         if($updated ){
            wp_send_json_success(['message' => 'action_product_ok' ]);
            wp_die();
         }

         wp_send_json_error([ 'message' => 'action_product_error']);
         wp_die();
      }
      
   }
}

/**
 * @access UPDATE ADD PRODUCT * 2023-10-29 18:00
 */


add_action( 'wp_ajax_atlantis_action_product_ice', 'atlantis_action_product_ice' );
function atlantis_action_product_ice(){
   if( isset($_POST['action']) && $_POST['action'] == 'atlantis_action_product_ice'){

      $product_id    = isset($_POST['product_id']) ? $_POST['product_id'] : null;
      $store_id      = isset($_POST['store_id']) ? $_POST['store_id'] : null;
      $product_type  = isset($_POST['product_type']) ? $_POST['product_type'] : null;
      $event         = isset($_POST['event']) ? $_POST['event'] : null;

      $$skipforce    = isset($_POST['$skipforce']) ? $_POST['$skipforce'] : null;

      $allow_event = ['add', 'edit', 'delete'];

      if( !in_array($event, $allow_event ) && !is_user_logged_in()){
         wp_send_json_error(['message' => 'action_product_store_error']);
         wp_die();
      }

      // META DATA
      $description = isset($_POST['description']) ? $_POST['description'] : null;
      $price = isset($_POST['price']) ? $_POST['price'] : null;
      $category = isset($_POST['category']) ? $_POST['category'] : null;
      $category_parent = isset($_POST['category_parent']) ? $_POST['category_parent'] : null;
      $weight = isset($_POST['weight']) ? $_POST['weight'] : null;
      $length_width = isset($_POST['length_width']) ? $_POST['length_width'] : null;
      

      $has_discount = isset($_POST['has_discount']) ? $_POST['has_discount'] : null;
      $discount_percent = isset($_POST['discount_percent']) ? $_POST['discount_percent'] : null;
      $discount_from = isset($_POST['discount_from']) ? $_POST['discount_from'] : null;
      $discount_to = isset($_POST['discount_to']) ? $_POST['discount_to'] : null;

      $mark_out_of_stock = isset($_POST['mark_out_of_stock']) ? $_POST['mark_out_of_stock'] : null;
      $capacity_device = isset($_POST['capacity_device']) ? $_POST['capacity_device'] : null;
      $name_device = isset($_POST['name_device']) ? $_POST['name_device'] : null;

      // UPLOAD IMAGE
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

      $args = [
         'category'           => $category,
         'has_discount'       => $has_discount,
         'discount_percent'   => $discount_percent,
         'discount_from'      => $discount_from,
         'discount_to'        => $discount_to,
         'mark_out_of_stock'  => $mark_out_of_stock,
         'description'        => $description,
         'price'              => $price
      ];

      // MERGE DATA DISCOUNT
      if(!empty($arg_discount)){
         $args = array_merge($args, $arg_discount);
      }

      if($category_parent != null ) { $args['category_parent'] = $category_parent; }
      if($weight != null ) { $args['weight'] = $weight; }
      if($length_width != null ){$args['length_width'] = $length_width;}

      if($capacity_device != null ){$args['capacity_device'] = $capacity_device;}
      if($name_device != null ){$args['name_device'] = $name_device;}

      // wp_send_json_success(['message' => 'bug', 'data' => $args, 'file' => $_FILES]);
      // wp_die();

      global $wpdb;

      if( $event == 'add'){
         $args['store_id']       = $store_id;
         $args['product_type']   = $product_type;
         $args['created_at']     = atlantis_current_date_only('Y-m-d H:m:s');
         $args['product_hidden'] = 1;

         if( $skipforce != 'pending' ){
            $args['status']         = 'pending';
         }else{
            $args['status']         = 'publish';
         }

         $wpdb->insert('wp_watergo_products', $args);
         $product_id = $wpdb->insert_id;

         if( $product_id != false && !empty($uploadImages) ){
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
            wp_send_json_success(['message' => 'action_product_ok', 'data' => $product_id ]);
            wp_die();
         }

         wp_send_json_error([ 'message' => 'action_product_error']);
         wp_die();
      }

      if( $event == 'edit'){


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

         $updated = $wpdb->update('wp_watergo_products', $args, ['id' => $product_id ]);

         if( $updated === false ){
            wp_send_json_error(['message' => 'action_product_store_error 2']);
            wp_die();
         }

         wp_send_json_success(['message' => 'action_product_ok', 'data' => $product_id ]);
         wp_die();

      }
      if( $event == 'delete'){
         $updated = $wpdb->update('wp_watergo_products', ['product_hidden' => 1, 'status' => 'delete' ], [ 'id' => $product_id ]);
         if($updated ){
            wp_send_json_success(['message' => 'action_product_ok' ]);
            wp_die();
         }
      }

      wp_send_json_error([ 'message' => 'action_product_error']);
      wp_die();


   }
}


add_action( 'wp_ajax_atlantis_action_product_water', 'atlantis_action_product_water' );
function atlantis_action_product_water(){
   if( isset($_POST['action']) && $_POST['action'] == 'atlantis_action_product_water'){
      $product_id    = isset($_POST['product_id']) ? $_POST['product_id'] : null;
      $store_id      = isset($_POST['store_id']) ? $_POST['store_id'] : null;
      $product_type  = isset($_POST['product_type']) ? $_POST['product_type'] : null;
      $event         = isset($_POST['event']) ? $_POST['event'] : null;

      $skipforce     = isset($_POST['skipforce']) ? $_POST['skipforce'] : null;

      $allow_event = ['add', 'edit', 'delete'];

      if(!in_array($event, $allow_event )){
         wp_send_json_error(['message' => 'action_product_store_error']);
         wp_die();
      }


      // META DATA
      $brand = isset($_POST['brand']) ? $_POST['brand'] : null;
      $quantity = isset($_POST['quantity']) ? $_POST['quantity'] : null;
      $volume = isset($_POST['volume']) ? $_POST['volume'] : null;

      $description = isset($_POST['description']) ? $_POST['description'] : null;
      $price = isset($_POST['price']) ? $_POST['price'] : null;
      $category = isset($_POST['category']) ? $_POST['category'] : null;
      $category_parent = isset($_POST['category_parent']) ? $_POST['category_parent'] : null;
      $has_discount = isset($_POST['has_discount']) ? $_POST['has_discount'] : null;
      $discount_percent = isset($_POST['discount_percent']) ? $_POST['discount_percent'] : null;
      $discount_from = isset($_POST['discount_from']) ? $_POST['discount_from'] : null;
      $discount_to = isset($_POST['discount_to']) ? $_POST['discount_to'] : null;

      $mark_out_of_stock = isset($_POST['mark_out_of_stock']) ? $_POST['mark_out_of_stock'] : 0;

      $name_device = isset($_POST['name_device']) ? $_POST['name_device'] : null;
      $feature_device = isset($_POST['feature_device']) ? $_POST['feature_device'] : null;

      // UPLOAD IMAGE
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

      $args = [
         'category'           => $category,
         'has_discount'       => $has_discount,
         'discount_percent'   => $discount_percent,
         'discount_from'      => $discount_from,
         'discount_to'        => $discount_to,
         'mark_out_of_stock'  => $mark_out_of_stock,
         'description'        => $description,
         'price'              => $price,
      ];

      // MERGE DATA DISCOUNT
      if(!empty($arg_discount)){
         $args = array_merge($args, $arg_discount);
      }

      if( $category_parent != null ) { $args['category_parent'] = $category_parent; }
      if( $name_device != null ){$args['name_device']     = $name_device;}

      if( $brand != null ){ $args['brand'] = $brand; }
      if( $quantity != null ){ $args['quantity'] = $quantity; }
      if( $volume != null ){ $args['volume'] = $volume; }
      if( $feature_device != null ){ $args['feature_device'] = $feature_device; }

      global $wpdb;
      
      // wp_send_json_success(['message' => 'bug', 'res' => $args ]);
      // wp_die();

      if($event == 'add'){
         $args['store_id']       = $store_id;
         $args['product_type']   = $product_type;
         $args['created_at']     = atlantis_current_date_only('Y-m-d H:m:s');
         $args['product_hidden'] = 1;

         
         if( $skipforce != 'pending' ){
            $args['status']         = 'pending';
         }else{
            $args['status']         = 'publish';
         }

         $wpdb->insert('wp_watergo_products', $args);
         $product_id = $wpdb->insert_id;

         if( $product_id != false && !empty($uploadImages) ){
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
            wp_send_json_success(['message' => 'action_product_ok', 'data' => $product_id ]);
            wp_die();
         }

         wp_send_json_error(['message' => 'action_product_store_error']);
         wp_die();
      }
      if($event == 'edit'){
         
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
         // $force_remove_has_discount = isset($_POST['force_remove_has_discount']) ? $_POST['force_remove_has_discount'] : null;
         // if( $force_remove_has_discount != null && $force_remove_has_discount == 1){
         //    $args['has_discount']      = 0;
         //    $args['discount_percent']  = 0;
         //    $args['discount_from']     = 0;
         //    $args['discount_to']       = 0;
         // }

         $updated = $wpdb->update('wp_watergo_products', $args, ['id' => $product_id ]);

         if( $updated === false ){
            wp_send_json_error(['message' => 'action_product_store_error 2']);
            wp_die();
         }

         wp_send_json_success(['message' => 'action_product_ok', 'data' => $product_id ]);
         wp_die();

      }
      if($event == 'delete'){
         $updated = $wpdb->update('wp_watergo_products', ['product_hidden' => 1, 'status' => 'delete'], [ 'id' => $product_id ]);
         if($updated ){
            wp_send_json_success(['message' => 'action_product_ok', 'data' => $product_id ]);
            wp_die();
         }
      }

   }
}


/**
 * @access ADMIN FUNCTION
 */

add_action( 'wp_ajax_nopriv_atlantis_get_all_product_by_store_to_admin_page', 'atlantis_get_all_product_by_store_to_admin_page' );
add_action( 'wp_ajax_atlantis_get_all_product_by_store_to_admin_page', 'atlantis_get_all_product_by_store_to_admin_page' );

function atlantis_get_all_product_by_store_to_admin_page(){
   if( isset( $_POST['action'] ) && $_POST['action'] == 'atlantis_get_all_product_by_store_to_admin_page' ){
      $store_id   = isset($_POST['store_id']) ? $_POST['store_id'] : 0;
      $product_id = isset($_POST['product_id']) ? $_POST['product_id'] : 0;
      $limit      = isset($_POST['limit']) ? $_POST['limit'] : 0;
      $status     = isset($_POST['status']) ? $_POST['status'] : 'publish';

      global $wpdb;

      $sql = "SELECT * FROM wp_watergo_products 
         WHERE store_id = $store_id  
         AND product_hidden != 1 AND status = '$status'
         ORDER BY id DESC
      ";

      $products = $wpdb->get_results($sql);;

      if( !empty($products ) ){
         foreach($products as $k => $vl){
            // IMAGE PRODUCT
            $products[$k]->product_image  = func_atlantis_get_images($vl->id, 'product', true, 'medium');
            $products[$k]->description    = stripcslashes($description);

            if( $vl->product_type == 'water'){
               $vl->name                     = $vl->brand;
               $vl->name_second              = $vl->quantity . ' ' . $vl->volume;
            }else if( $vl->product_type == 'ice'){
               $vl->name                     = $vl->category;
               $vl->name_second              = $vl->weight . 'kg ' . $vl->length_width . ' mm';
            }else if( $vl->product_type == 'water_device'){
               $vl->name                     = $vl->name_device;
               $vl->name_second              = $vl->feature_device;
            }else if( $vl->product_type == 'ice_device'){
               $vl->name                     = $vl->name_device;
               $vl->name_second              = $vl->capacity_device;
            }
         }
      }

      if( empty($products ) ){
         wp_send_json_error(['message' => 'product_not_found']);
         wp_die();
      }

      wp_send_json_success(['message' => 'product_found', 'data' => $products ]);
      wp_die();
      
   }
   
}

add_action( 'wp_ajax_nopriv_atlantis_get_all_product_pending_to_admin_page', 'atlantis_get_all_product_pending_to_admin_page' );
add_action( 'wp_ajax_atlantis_get_all_product_pending_to_admin_page', 'atlantis_get_all_product_pending_to_admin_page' );

function atlantis_get_all_product_pending_to_admin_page(){
   if( isset( $_POST['action'] ) && $_POST['action'] == 'atlantis_get_all_product_pending_to_admin_page' ){

      global $wpdb;

      $sql = "SELECT * FROM wp_watergo_products 
         WHERE status = 'pending'
         ORDER BY id DESC
      ";

      $products = $wpdb->get_results($sql);;

      if( !empty($products ) ){
         foreach($products as $k => $vl){
            // IMAGE PRODUCT
            $products[$k]->product_image  = func_atlantis_get_images($vl->id, 'product', true, 'medium');
            $products[$k]->description    = stripcslashes($description);

            if( $vl->product_type == 'water'){
               $vl->name                     = $vl->brand;
               $vl->name_second              = $vl->quantity . ' ' . $vl->volume;
            }else if( $vl->product_type == 'ice'){
               $vl->name                     = $vl->category;
               $vl->name_second              = $vl->weight . 'kg ' . $vl->length_width . ' mm';
            }else if( $vl->product_type == 'water_device'){
               $vl->name                     = $vl->name_device;
               $vl->name_second              = $vl->feature_device;
            }else if( $vl->product_type == 'ice_device'){
               $vl->name                     = $vl->name_device;
               $vl->name_second              = $vl->capacity_device;
            }
         }
      }

      if( empty($products ) ){
         wp_send_json_error(['message' => 'product_not_found']);
         wp_die();
      }

      wp_send_json_success(['message' => 'product_found', 'data' => $products ]);
      wp_die();

   }
}

/**
 * @access CHANGE STATUS PRODUCT
 */

add_action( 'wp_ajax_nopriv_atlantis_change_product_status', 'atlantis_change_product_status' );
add_action( 'wp_ajax_atlantis_change_product_status', 'atlantis_change_product_status' );

function atlantis_change_product_status(){
   if( isset( $_POST['action'] ) && $_POST['action'] == 'atlantis_change_product_status' ){
      $product_id = isset($_POST['product_id']) ? $_POST['product_id'] : null;
      $event = isset($_POST['event']) ? $_POST['event'] : null;


      if( $product_id == null && $event == null ){
         wp_send_json_error(['message' => 'product_not_found']);
         wp_die();
      }

      global $wpdb;
      if( $event == 'allow' ){
         $updated = $wpdb->update('wp_watergo_products', ['product_hidden' => 0, 'status' => 'publish' ], [ 'id' => $product_id ]);
      }
      if( $event == 'deny' ){
         $updated = $wpdb->update('wp_watergo_products', ['product_hidden' => 1, 'status' => 'delete' ], [ 'id' => $product_id ]);
      }

      if($updated){
         wp_send_json_success(['message' => 'product_found']);
         wp_die();
      }
      wp_send_json_error(['message' => 'product_not_found']);
         wp_die();
   }
}