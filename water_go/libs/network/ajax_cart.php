<?php

add_action( 'wp_ajax_nopriv_atlantis_get_cart_product', 'atlantis_get_cart_product' );
add_action( 'wp_ajax_atlantis_get_cart_product', 'atlantis_get_cart_product' );

add_action( 'wp_ajax_nopriv_atlantis_get_cart_store', 'atlantis_get_cart_store' );
add_action( 'wp_ajax_atlantis_get_cart_store', 'atlantis_get_cart_store' );

function atlantis_get_cart_store(){
   if( isset($_POST['action']) && $_POST['action'] == 'atlantis_get_cart_store' ){
      $store_id = isset($_POST['store_id']) ? $_POST['store_id'] : 0;

      if( $store_id == 0 ){
         wp_send_json_error(['message' => 'error']);
         wp_die();
      }
      global $wpdb;
      $sql_store_name = "SELECT name FROM wp_watergo_store WHERE id = $store_id";
      $res_store_name = $wpdb->get_results($sql_store_name);

      wp_send_json_success(['message' => 'get_store_ok', 'data' => $res_store_name[0]->name ]);
      wp_die();

   }
}


function atlantis_get_cart_product(){
   if( isset($_POST['action']) && $_POST['action'] == 'atlantis_get_cart_product' ){
      $product_id = isset($_POST['product_id']) ? $_POST['product_id'] : 0;
      if( $product_id == 0 ){
         wp_send_json_error(['message' => 'error']);
         wp_die();
      }

      global $wpdb;
      $sql_product = "SELECT * FROM wp_watergo_products WHERE id = $product_id ";
      $product = $wpdb->get_results($sql_product);

      if( !empty($product ) ){
         foreach($product as $k => $vl){

            $vl->product_image = func_atlantis_get_images($vl->id, 'product', true, 'medium');

            if( $vl->product_type == 'water'){
               $vl->name                     = $vl->brand;
               $vl->name_second              = $vl->quantity . ' ' . $vl->volume;
            }else if( $vl->product_type == 'ice'){
               $vl->name                     = $vl->category;
               $weight_unit                  = $vl->weight_unit;
               if( !in_array($weight_unit, ['Kg', 'Ml', 'Box']) ){
                  $weight_unit = 'Kg';
               }
               $vl->name_second              = $vl->weight . strtolower($weight_unit) . ' ' . $vl->length_width . ' mm';
            }else if( $vl->product_type == 'water_device'){
               $vl->name                     = $vl->name_device;
               $vl->name_second              = $vl->feature_device;
            }else if( $vl->product_type == 'ice_device'){
               $vl->name                     = $vl->name_device;
               $vl->name_second              = $vl->capacity_device;
            }
         }
      }

      wp_send_json_success(['message' => 'get_product_ok', 'data' => $product[0] ]);
      wp_die();


   }
}