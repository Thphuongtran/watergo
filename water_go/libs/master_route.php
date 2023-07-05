<?php 

/**
 * @access MASTER ROUTE
 */


// HOME
define('WATERGO_HOME', get_bloginfo('url') . '/home' );
// NEAR BY
define('WATERGO_NEARBY', get_bloginfo('url') . '/nearby' );
// ORDER
define('WATERGO_ORDER', get_bloginfo('url') . '/order' );
//

define('WATERGO_ORDER_DETAIL', get_bloginfo('url') . '/order?order_page=order-detail' );
// USER
define('WATERGO_USER',get_bloginfo('url') . '/user' );


// AUTH 
define('WATERGO_LOGIN', get_bloginfo('url') . '/authentication');
// CART
define('WATERGO_CART', get_bloginfo('url') . '/cart' );

// PRODUCT
define('WATERGO_PRODUCT', get_bloginfo('url') . '/product' );

// PRODUCT DETAIL
define('WATERGO_PRODUCT_DETAIL', get_bloginfo('url') . '/product?product_page=product-detail' );

// STORE
define('WATERGO_STORE', get_bloginfo('url') . '/store' );
// BACK
define('WATERGO_BACK', get_bloginfo('url') . '/home?appt=X' );

// NOTIFICATION
define('WATERGO_NOTIFICATION', get_bloginfo('url') . '/notification' );

// BUSINESS
define('WATERGO_BUSINESS', get_bloginfo('url') . '/business');