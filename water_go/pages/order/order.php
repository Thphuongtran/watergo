<?php

/*
   /order?product_id=1
*/

$order_page = isset($_GET['order_page']) ? $_GET['order_page'] : '';

if( $order_page == 'order-product'){  
   get_template_part('pages/order/page-order-product');
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

if( $order_page == 'order-index-store' ){
   get_template_part('pages/order/order-index-store');
}

if( $order_page == 'order-store-detail' ){
   get_template_part('pages/order/page-order-store-detail');
}


