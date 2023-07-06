<?php

require_once __DIR__ . '/libs/config.php';

function stylesheet(){
   wp_enqueue_style('styles-main', THEME_URI .'/assets/css/styles.css');
   // wp_enqueue_script('vuejs3-browser', THEME_URI . '/assets/js/vue.esm-browser.js');
   wp_enqueue_script('vuejs3-main', THEME_URI . '/assets/js/vue.global.min.js');
   // wp_enqueue_script('common-js', THEME_URI . '/assets/js/common.js');
   // wp_script_add_data( 'common-js', 'defer', true );

   // <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
   // Using unpkg CDN: <script src="https://unpkg.com/axios/dist/axios.min.js"></script>
   wp_enqueue_script('axios-main', THEME_URI . '/assets/js/axios.min.js');
}

add_action('wp_enqueue_scripts', 'stylesheet');
// remove admin bar
add_filter('show_admin_bar', '__return_false');


function generate_verification_code() {
    return rand( 1000, 9999 );
}

function randomString($length) {
  $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
  $randomString = str_shuffle($characters);
  return substr($randomString, 0, $length);
}

function atlantis_check_login_by_tokens(){
   $tokens = isset($_COOKIE['watergo_tokens']) ? $_COOKIE['watergo_tokens'] : '';
   if( $tokens == '' ) return false; 

   // expired ?
   global $wpdb;
   $get_tokens = $wpdb->get_results("SELECT * FROM wp_tokens WHERE tokens='$tokens' ");
   // if not compare
   if( empty($get_tokens) ) return false;
   $get_tokens = $get_tokens[0];
   $explode = explode('|' , $get_tokens->tokens);
   $expired = $get_tokens->expired;

   if( time() > $expired ) {
      // DELETE COOKIE
      setcookie('watergo_tokens', null, -1, '/'); 
      return false;
   };

   return $get_tokens;
}

function convertToShortNumber($num) {
  if ($num >= 1000 && $num < 1000000) {
    return round($num / 1000, 1) . 'k';
  } else if ($num >= 1000000) {
    return round($num / 1000000, 1) . 'm';
  }
  return $num;
}

// echo convertToShortNumber(1234); // Output: "1.2k"
// echo convertToShortNumber(12345); // Output: "12.3k"

function generateProduct(){
   // global $wpdb;

   // // FOR WATER
   $description = "Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book.";

   // $products = [
   //    [
   //       'store_type' => 'ice',
   //       'owner' => 'Blue Wave',
   //       'name' => 'Blue Wave',
   //       'description' => $description,
   //       'address' => '07624 Westend Point',
   //       'phone' => 8888888888,
   //       'email' => 'cdomeny7@amazon.co.jp',
   //    ],
   // ];

   // foreach($products as $product){
   //    $wpdb->insert('wp_watergo_store', $product);
   // }


}

function remove_trailing_slash_from_query_string( $redirect_url, $requested_url ) {
  if ( false !== strpos( $requested_url, '?') ) {
    $redirect_url = untrailingslashit( $redirect_url );
  }
  return $redirect_url;
}
add_filter( 'redirect_canonical', 'remove_trailing_slash_from_query_string', 10, 2 );


/**
 * @access THIS FUNCTION ENABLE FEATURE LOGIN BY EMAIL
 */

// Custom login using email
function email_login_authenticate($user, $username, $password) {
  // Check if the username is an email address
  if (is_email($username)) {
    // Get the user by email
    $user = get_user_by('email', $username);
    if ($user) {
      // Authenticate the user with the provided password
      $user = wp_authenticate_username_password(null, $user->user_login, $password);
      if (is_wp_error($user)) {
        $user = null;
      }
    }
  }
  return $user;
}
add_filter('authenticate', 'email_login_authenticate', 20, 3);

// SETUP URL FROM JAVASCRIPT
function loadDirectory() { ?>
<script type="text/javascript">
   var watergo_domain = '<?php echo get_bloginfo('url'); ?>/';
   var get_template_directory_uri = "<?php echo get_template_directory_uri(); ?>";
   var get_ajaxadmin = "<?php echo admin_url('admin-ajax.php'); ?>";
   var theme_uploads = "<?php echo THEME_UPLOADS; ?>";
</script> 
<?php } 
add_action('wp_head', 'loadDirectory');


function common_js(){
   wp_enqueue_script('query-cdn', 'https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js');
   wp_enqueue_script('common-js', THEME_URI . '/assets/js/common.js' );
}

add_action('wp_enqueue_scripts', 'common_js');



/**
 * 
   WHEN LOGIN SOCIAL NETWORK WITH USER TOKEN | FUNCTION IS TESTING
 */

// add_action('init', 'callback_from_login_social');
function callback_from_login_social(){
   $headers = getallheaders();

   if( !empty($headers['app_name'] ) ){

      // SET LOGIN USER BY TOKEN FROM LOGIN SOCIAL 
      
      $user_token = "";
      if( !empty($headers['user_token']) && $headers['user_token'] != "Token not found" ){

         $user_token = $headers['user_token'];
         $user_token_arr = explode(":", 'user_id');
         if( is_array($user_token_arr )){
            $user_id = $user_token_arr[1];
            wp_clear_auth_cookie();
            $user = wp_set_current_user($user_id);
            wp_set_auth_cookie($user_id,true,is_ssl());
            do_action('wp_login', $user->user_login, $user);

         }


      }
   }

}


add_action('init', 'language_custom');
function language_custom($locale) {
  $locale = "vi";
  $headers = array_change_key_case(getallheaders(),CASE_LOWER);
  if (isset($headers["app_language"]) && !empty($headers["app_language"])) {  
    $locale = $headers["app_language"];
    
  } else if(isset($_COOKIE['site_lang'])){
    $locale = $_COOKIE['site_lang'];
  }

  if($locale == "en") $locale = "en_US";

  switch_to_locale($locale);
}