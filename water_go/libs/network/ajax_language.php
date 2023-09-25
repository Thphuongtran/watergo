<?php
add_action( 'wp_ajax_nopriv_get_current_locale_callback', 'get_current_locale_callback' );
add_action( 'wp_ajax_get_current_locale_callback', 'get_current_locale_callback' );

add_action( 'wp_ajax_nopriv_atlantis_get_language', 'atlantis_get_language' );
add_action( 'wp_ajax_atlantis_get_language', 'atlantis_get_language' );

function atlantis_setup_language(){
   $cookie_name   = "site_lang";
   $headers       = getallheaders();
   $language      = isset($headers['app_language']) ? $headers['app_language'] : 'en_US';
   
   // GET DATA AND CONVERT NATIVE APP TO WEB BROWSER
   if($language == 'vi') $language = 'vi';
   if($language == 'ko') $language = 'ko_KR';
   if($language == 'en') $language = 'en_US';

   if ( ! isset($_COOKIE[$cookie_name] ) ) {
      setcookie($cookie_name, $language, time() + 604800, "/", "", 0);
   }
}

function get_current_locale_callback(){
	if( isset( $_POST['action'] ) && $_POST['action'] == 'get_current_locale_callback' ){
		$current_lang = get_locale();
		wp_send_json_success([ 'message' => 'current_locale_found', 'data' => $current_lang ]);
		wp_die();
	}
}

add_action( 'wp_ajax_nopriv_app_change_language_callback', 'app_change_language_callback' );
add_action( 'wp_ajax_app_change_language_callback', 'app_change_language_callback' );

/**
 * @access FOR LANGUAGE CONVERT
 */
function app_change_language_callback(){
	if( isset( $_POST['action'] ) && $_POST['action'] == 'app_change_language_callback' ){
		$language      = $_POST['language'];
		$cookie_name   = "site_lang";

		setcookie($cookie_name, $language, time() + 604800, "/", "", 0);
		if($language == "en_US")   $language = "en";
		if($language == "vi")      $language = "vi";
		if($language == "ko_KR")   $language = "ko";

		wp_send_json_success([ 'message' => 'change_language_successfully', 'data' => $language ]);
		wp_die();
	}
}

function atlantis_get_language(){
   if( isset( $_POST['action'] ) && $_POST['action'] == 'atlantis_get_language' ){
      $cookie  = "site_lang";
      $value   = $_COOKIE[$cookie];

      if (isset($_COOKIE[$cookie] ) ) {
         wp_send_json_success([ 'message' => 'get_language_ok', 'data' => $value ]);
		   wp_die();
      }
   }
}

// 'en_US',
// 'vi',
// 'ko_KR',

function func_quick_app_change_language_callback( $language ){
   $cookie_name   = "site_lang";
   if($language == "en_US") $language = "en";
   if($language == "vi") $language = "vi";
   setcookie($cookie_name, $language, time() + 604800, "/", "", 0);
}

function func_quick_get_current_locale_callback(){
   return get_locale();
}