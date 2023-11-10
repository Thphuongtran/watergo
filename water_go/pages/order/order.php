<?php

/*
   /order?product_id=1
*/

$order_page = isset($_GET['order_page']) ? $_GET['order_page'] : '';

$order_user    = [ 'order-product' , 'order-detail', 'order-filter', 'order-index' ];
$order_store   = [ 'order-index-store', 'order-store-detail' ];

if( in_array( $order_page, $order_user )){

   if( is_user_logged_in() ){

      if( $order_page == 'order-product'){  
         get_template_part('pages/order/page-order-product');
      }
      if( $order_page == 'order-product-test'){  
         get_template_part('pages/order/page-order-product-test');
      }

      if( $order_page == 'order-detail'){  
         get_template_part('pages/order/page-order-detail');
      }

      if( $order_page == 'order-filter' ){
         get_template_part('pages/order/page-order-filter');
      }

      if( $order_page == 'order-index' ){
         get_template_part('pages/order/order-index');
      }

   }else{
      get_template_part('pages/authentication/page-auth-login');

   }

}




/**
 * @access FOR STORE
 */

if( in_array( $order_page, $order_store )){

   if( is_user_logged_in() ){
      if( $order_page == 'order-index-store' ){
         get_template_part('pages/order/order-index-store');
      }

      if( $order_page == 'order-store-detail' ){
         get_template_part('pages/order/page-order-store-detail');
      }

   }else{
      get_template_part('pages/authentication/page-auth-store-login');
   }

}

