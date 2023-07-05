<?php
add_action( 'wp_ajax_nopriv_get_current_locale', 'get_current_locale_callback' );
add_action( 'wp_ajax_get_current_locale', 'get_current_locale_callback' );

function get_current_locale_callback(){
	if( isset( $_POST['action'] ) && $_POST['action'] == 'get_current_locale' ){
		$current_lang =  get_locale();

		wp_send_json_error([ 'message' => 'current_locale_found', 'data' => $current_lang ]);
		wp_die();
	}
}

add_action( 'wp_ajax_nopriv_app_change_language', 'app_change_language_callback' );
add_action( 'wp_ajax_app_change_language', 'app_change_language_callback' );

function app_change_language_callback(){
	if( isset( $_POST['action'] ) && $_POST['action'] == 'app_change_language' ){
		$language = $_POST['language'];
		$cookie_name = "site_lang";		
		setcookie($cookie_name, $language, time() + 604800, "/", "", 0);
		if($language == "en_US") $language = "en";

		wp_send_json_error([ 'message' => 'change_language_successfully', 'data' => $language ]);
		wp_die();
	}
}