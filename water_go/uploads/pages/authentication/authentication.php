<?php

$auth_page = isset($_GET['auth_page']) ? $_GET['auth_page'] : '';

/**
 * @access FOR USER AUTH
 */

if( $auth_page == 'auth-login') {
   get_template_part('pages/authentication/page-auth-login');
}

if( $auth_page == 'auth-register') {
   get_template_part('pages/authentication/page-auth-register');
}

if( $auth_page == 'auth-forget-password') {
   get_template_part('pages/authentication/page-auth-forget-password');
}

// if( $auth_page == 'auth-reset-password') {
//    get_template_part('pages/authentication/page-auth-reset-password');
// }

/**
 * @access FOR STORE AUTH
 */


if( $auth_page == 'auth-store-login') {
   get_template_part('pages/authentication/page-auth-store-login');
}

if( $auth_page == 'auth-store-register') {
   get_template_part('pages/authentication/page-auth-store-register');
}