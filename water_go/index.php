<?php 
get_header();

if( is_page( 'authentication') ){
   get_template_part('pages/authentication/authentication');
}

if( is_page('home') ){
   get_template_part('pages/home/home');
}

if( is_page('user') ){
   get_template_part('pages/user/user');
}

if( is_page('order') ){
   get_template_part('pages/order/order');
}

if( is_page('nearby')){
   get_template_part('pages/nearby/nearby');
}

if( is_page('product') ){
   get_template_part('pages/product/product');
}

if( is_page('store') ){
   get_template_part('pages/store/store');
}

if( is_page('cart') ){
   get_template_part('pages/cart/cart');
}

if( is_page('chat') ){
   get_template_part('pages/chat/chat');
}

if( is_page('review') ){
   get_template_part('pages/review/review');
}

if( is_page('support') ){
   get_template_part('pages/support/support');
}

if( is_page('search') ){
   get_template_part('pages/search/search');
}

if( is_page('notification') ){
   get_template_part('pages/notification/notification');
}

if( is_page('delivery-address') ){
   get_template_part('pages/delivery-address/delivery-address');
}



/**
 * @access FOR STORE LOGIN
 */

if( is_page('schedule')){
   get_template_part('pages/schedule/schedule');
}

if( is_page('report') ){
   get_template_part('pages/report/report');
}


get_footer();
?>

