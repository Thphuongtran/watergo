<?php


$store_page = isset($_GET['store_page']) ? $_GET['store_page'] : '';


$allow_user = [];


if( $store_page == 'store-detail'){
   get_template_part('pages/store/page-store-detail');
}



$allow_store = ['store-profile', 'store-edit', 'store-settings' ];

if( in_array($store_page, $allow_store) ){
   
   if( is_user_logged_in() ){
      
      if( $store_page == 'store-profile'){
         get_template_part('pages/store/page-store-profile');
      }

      if( $store_page == 'store-edit'){
         get_template_part('pages/store/page-store-edit');
      }

      if( $store_page == 'store-settings'){
         get_template_part('pages/store/page-store-settings');
      }

   }else{
      get_template_part('pages/authentication/page-auth-store-login');
   }

}


if( $store_page == 'store-adverstising'){
   get_template_part('pages/store/page-store-adverstising-inquery');
}

if( $store_page == 'store-privacy-policy'){
   get_template_part('pages/store/page-store-privacy-policy');
}

if( $store_page == 'store-term-conditions'){
   get_template_part('pages/store/page-store-term-conditions');
}

?>