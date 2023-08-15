<?php

add_action( 'wp_ajax_nopriv_atlantis_search_product', 'atlantis_search_product' );
add_action( 'wp_ajax_atlantis_search_product', 'atlantis_search_product' );

add_action( 'wp_ajax_nopriv_atlantis_search_store', 'atlantis_search_store' );
add_action( 'wp_ajax_atlantis_search_store', 'atlantis_search_store' );

/**
 * @access CACULATOR HOW MANY PERCENT WORK
 */
// function fuzzyStringCompare($string1, $string2) {
//     $length1 = mb_strlen($string1, 'UTF-8');
//     $length2 = mb_strlen($string2, 'UTF-8');
    
//     if ($length1 === 0 || $length2 === 0) {
//         return 0; // Avoid division by zero
//     }
    
//     $distance = levenshtein($string1, $string2);
    
//     // Calculate similarity as a percentage
//     $similarity = 100 - ($distance / max($length1, $length2)) * 100;
    
//     return $similarity;
// }



function word_by_word_match( $search, $product_name){

   if( $search == $product_name ) return true;

   for($i = 0; $i < mb_strlen($search, 'UTF-8'); $i++ ){
      $character = mb_substr($search, $i, 1, 'UTF-8');
      $character_product = mb_substr($product_name, $i, 1, 'UTF-8');

      if($character != $character_product ){
         return false;
      }
      
   }
   return true;
}

function func_get_product_category($res_product){
   if( !empty( $res_product) ){
      foreach( $res_product as $k => $product ){
         $res_product[$k]->product_image = func_atlantis_get_images($product->id, 'product', true, 'medium');

         $category = func_atlantis_get_product_category([
            'category'     => $product->category,
            'brand'        => $product->brand,
            'quantity'     => $product->quantity,
            'volume'       => $product->volume,
            'weight'       => $product->weight,
            'product_type' => $product->product_type,
            'product_id'   => $product->id,
         ]);

         $description = $res_product[$k]->description;

         $res_product[$k]->category_name  = $category['category_name'];
         $res_product[$k]->brand_name     = $category['brand_name'];
         $res_product[$k]->quantity_name  = $category['quantity_name'];
         $res_product[$k]->volume_name    = $category['volume_name'];
         $res_product[$k]->weight_name    = $category['weight_name'];
         $res_product[$k]->description    = stripcslashes($description);
         $res_product[$k]->name           = $category['name'];
         $res_product[$k]->name_second    = $category['name_second'];
      }
      return $res_product;
   }else{
      return [];
   }

}




function convertVietnameseToLatin($text) {
   $map = array(
      'á' => 'a', 'à' => 'a', 'ả' => 'a', 'ã' => 'a', 'ạ' => 'a',
      'â' => 'a', 'ấ' => 'a', 'ầ' => 'a', 'ẩ' => 'a', 'ẫ' => 'a', 'ậ' => 'a',
      'ă' => 'a', 'ắ' => 'a', 'ằ' => 'a', 'ẳ' => 'a', 'ẵ' => 'a', 'ặ' => 'a',
      'é' => 'e', 'è' => 'e', 'ẻ' => 'e', 'ẽ' => 'e', 'ẹ' => 'e',
      'ê' => 'e', 'ế' => 'e', 'ề' => 'e', 'ể' => 'e', 'ễ' => 'e', 'ệ' => 'e',
      'í' => 'i', 'ì' => 'i', 'ỉ' => 'i', 'ĩ' => 'i', 'ị' => 'i',
      'ó' => 'o', 'ò' => 'o', 'ỏ' => 'o', 'õ' => 'o', 'ọ' => 'o',
      'ô' => 'o', 'ố' => 'o', 'ồ' => 'o', 'ổ' => 'o', 'ỗ' => 'o', 'ộ' => 'o',
      'ơ' => 'o', 'ớ' => 'o', 'ờ' => 'o', 'ở' => 'o', 'ỡ' => 'o', 'ợ' => 'o',
      'ú' => 'u', 'ù' => 'u', 'ủ' => 'u', 'ũ' => 'u', 'ụ' => 'u',
      'ư' => 'u', 'ứ' => 'u', 'ừ' => 'u', 'ử' => 'u', 'ữ' => 'u', 'ự' => 'u',
      'ý' => 'y', 'ỳ' => 'y', 'ỷ' => 'y', 'ỹ' => 'y', 'ỵ' => 'y',
      'đ' => 'd',
      'Á' => 'A', 'À' => 'A', 'Ả' => 'A', 'Ã' => 'A', 'Ạ' => 'A',
      'Â' => 'A', 'Ấ' => 'A', 'Ầ' => 'A', 'Ẩ' => 'A', 'Ẫ' => 'A', 'Ậ' => 'A',
      'Ă' => 'A', 'Ắ' => 'A', 'Ằ' => 'A', 'Ẳ' => 'A', 'Ẵ' => 'A', 'Ặ' => 'A',
      'É' => 'E', 'È' => 'E', 'Ẻ' => 'E', 'Ẽ' => 'E', 'Ẹ' => 'E',
      'Ê' => 'E', 'Ế' => 'E', 'Ề' => 'E', 'Ể' => 'E', 'Ễ' => 'E', 'Ệ' => 'E',
      'Í' => 'I', 'Ì' => 'I', 'Ỉ' => 'I', 'Ĩ' => 'I', 'Ị' => 'I',
      'Ó' => 'O', 'Ò' => 'O', 'Ỏ' => 'O', 'Õ' => 'O', 'Ọ' => 'O',
      'Ô' => 'O', 'Ố' => 'O', 'Ồ' => 'O', 'Ổ' => 'O', 'Ỗ' => 'O', 'Ộ' => 'O',
      'Ơ' => 'O', 'Ớ' => 'O', 'Ờ' => 'O', 'Ở' => 'O', 'Ỡ' => 'O', 'Ợ' => 'O',
      'Ú' => 'U', 'Ù' => 'U', 'Ủ' => 'U', 'Ũ' => 'U', 'Ụ' => 'U',
      'Ư' => 'U', 'Ứ' => 'U', 'Ừ' => 'U', 'Ử' => 'U', 'Ữ' => 'U', 'Ự' => 'U',
      'Ý' => 'Y', 'Ỳ' => 'Y', 'Ỷ' => 'Y', 'Ỹ' => 'Y', 'Ỵ' => 'Y',
      'Đ' => 'D'
   );

   return preg_replace_callback('/[áàảãạâấầẩẫậăắằẳẵặéèẻẽẹêếềểễệíìỉĩịóòỏõọôốồổỗộơớờởỡợúùủũụưứừửữựýỳỷỹỵđÁÀẢÃẠÂẤẦẨẪẬĂẮẰẲẴẶÉÈẺẼẸÊẾỀỂỄỆÍÌỈĨỊÓÒỎÕỌÔỐỒỔỖỘƠỚỜỞỠỢÚÙỦŨỤƯỨỪỬỮỰÝỲỶỸỴĐ]/u', function ($match) use ($map) {
      return isset($map[$match[0]]) ? $map[$match[0]] : $match[0];
   }, $text);

}


function atlantis_search_product(){
   if( isset( $_POST['action'] ) && $_POST['action'] == 'atlantis_search_product' ){

      $lat     = isset($_POST['lat']) ? $_POST['lat'] : 10.780900239854994;
      $lng     = isset($_POST['lng']) ? $_POST['lng'] : 106.7226271387539;

      $limit   = 10;
      $paged   = isset($_POST['paged']) ?  $_POST['paged'] : 0;
      $paged   = $paged * $limit;

      $search  = isset($_POST['search']) ? strtolower(convertVietnameseToLatin($_POST['search'])) : '';
      // $search  = isset($_POST['search']) ? $_POST['search'] : '';

      global $wpdb;

      $sql_category = "SELECT * FROM wp_watergo_product_category
         WHERE category IN ('water_brand', 'ice_category', 'water_category')
      ";
      // $sql_category = "SELECT * FROM wp_watergo_product_category
      //    WHERE category IN ('water_brand', 'ice_category', 'water_category')
      //    AND name LIKE '%$search%'
      // ";

      $res_category        = $wpdb->get_results($sql_category);
      $res = [];
      if( !empty( $res_category ) ){
         foreach( $res_category as $k => $vl ){
            $wordConvert = strtolower(convertVietnameseToLatin( $vl->name ));
            if( word_by_word_match( $search, $wordConvert ) ){
               $res[$k] = $vl;
            }
            // $res[$k] = $vl;
         }
      }

      if( empty( $res ) ){
         wp_send_json_error(['message' => 'search_not_found 1' ]);
         wp_die();
      }

      // fetch product 

      $sql_product   = "SELECT 
            wp_watergo_products.*,
            wp_watergo_products.id as product_id,

            (6371 * acos(
               cos(radians($lat)) * cos(radians(wp_watergo_store.latitude)) 
                  * cos(radians(wp_watergo_store.longitude) - radians($lng)) +
               sin(radians($lat)) * sin(radians(wp_watergo_store.latitude))
            )) AS distance

         FROM wp_watergo_products 

         LEFT JOIN wp_watergo_store 
         ON wp_watergo_store.id = wp_watergo_products.store_id

      ";

      $res_product   = [];
      $product_query = [];

      foreach( $res as $kCat => $vlCat ){
         $id_category         = (int) $vlCat->id;

         if( $vlCat->category == "ice_category" ){
            $product_query['ice_category']['category']   = 'category';
            $product_query['ice_category']['id'][]       = $id_category;
         }
         if( $vlCat->category == "water_category"){
            $product_query['water_category']['category']   = 'category';
            $product_query['water_category']['id'][]       = $id_category;
         }
         if( $vlCat->category == "water_brand"){
            $product_query['water_brand']['category']   = 'brand';
            $product_query['water_brand']['id'][]       = $id_category;
         }

      }

      sort( $product_query);

      if( !empty( $product_query )){

         $list_id       = implode(',', $product_query[0]['id'] );
         $type          = $product_query[0]['category'];
         $sql_product  .= "
            WHERE $type IN ($list_id) 
            ORDER BY distance ASC
            LIMIT $paged, 10
         ";

         $r = $wpdb->get_results( $sql_product );
         $res_product = func_get_product_category( $r);

         if( ! empty( $res_product ) ){
            wp_send_json_success(['message' => 'search_found', 'data' => $res_product ]);
            wp_die();
         }

         wp_send_json_error(['message' => 'search_not_found 2' ]);
         wp_die();
      }

      wp_send_json_error(['message' => 'search_not_found 3'  ]);
      wp_die();


   }

}


function atlantis_search_store(){
   if( isset( $_POST['action'] ) && $_POST['action'] == 'atlantis_search_store' ){
      $lat     = isset($_POST['lat']) ? $_POST['lat'] : 10.780900239854994;
      $lng     = isset($_POST['lng']) ? $_POST['lng'] : 106.7226271387539;

      $limit   = 10;
      $paged   = isset($_POST['paged']) ?  $_POST['paged'] : 0;
      $paged   = $paged * $limit;

      $search  = isset($_POST['search']) ? strtolower($_POST['search']) : '';
      $search  = isset($_POST['search']) ? $_POST['search'] : '';

      global $wpdb;
      $sql = " SELECT 
            store.*,
            store.id as store_id,

            (6371 * acos(
               cos(radians($lat)) * cos(radians(store.latitude)) 
                  * cos(radians(store.longitude) - radians($lng)) +
               sin(radians($lat)) * sin(radians(store.latitude))
            )) AS distance

         FROM wp_watergo_store as store

         WHERE store.name LIKE '%$search%'
             -- OR LOWER(store.name) LIKE BINARY '%$search%' COLLATE utf8_unicode_ci

         ORDER BY distance ASC
         LIMIT $paged, $limit
      ";

      $res = $wpdb->get_results( $sql );

      if( empty($res) ){
         wp_send_json_error(['message' => 'search_not_found']);
         wp_die();
      }

      foreach( $res as $k => $vl ){
         $res[$k]->avg_rating    = func_atlantis_get_avg_rating( (int) $vl->id);
         $res[$k]->store_image   = func_atlantis_get_images( (int) $vl->id, 'store');
      }

      wp_send_json_success(['message' => 'search_found', 'data' => $res ]);
      wp_die();


   }
}