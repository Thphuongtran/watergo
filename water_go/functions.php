<?php

require_once __DIR__ . '/libs/config.php';

function stylesheet(){
   wp_enqueue_style('styles-main', THEME_URI .'/assets/css/styles.min.css', [], '3.92');
   // wp_enqueue_script('vuejs3-browser', THEME_URI . '/assets/js/vue.esm-browser.js');
   // wp_enqueue_script('common-js', THEME_URI . '/assets/js/common.js');
   wp_enqueue_script('vuejs3-main', THEME_URI . '/assets/js/vue.global.min.js');
   wp_enqueue_script('axios-main', THEME_URI . '/assets/js/axios.min.js');
   wp_enqueue_script('query-cdn', THEME_URI . '/assets/js/jquery-3.7.1.min.js', [], '1.0');
   // wp_enqueue_script('common-js', THEME_URI . '/assets/js/common.js' , [] , '3.64');
   wp_enqueue_script('common-js', THEME_URI . '/assets/js/common.min.js' , [] , '3.92');
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
function loadDirectory() { 
   $currency = ' đ';
   if( get_locale() == 'ko_KR' ){
      $currency = '동';
   }
   ?>
<script type="text/javascript">
   var watergo_domain = '<?php echo get_bloginfo('url'); ?>/';
   var get_template_directory_uri = "<?php echo get_template_directory_uri(); ?>";
   var get_ajaxadmin = "<?php echo admin_url('admin-ajax.php'); ?>";
   var theme_uploads = "<?php echo THEME_UPLOADS; ?>";
   var global_currency = "<?php echo $currency; ?>";
</script> 
<?php } 
add_action('wp_head', 'loadDirectory');



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


// add_action('init', 'language_custom');
add_action('after_setup_theme', 'language_custom');
function language_custom($locale) {
   $locale = "vi";
   $headers = array_change_key_case(getallheaders(),CASE_LOWER);
   if (isset($headers["app_language"]) && !empty($headers["app_language"]) ) {  
      $locale = $headers["app_language"];
      if( isset( $_COOKIE['site_lang'] ) && $headers["app_language"] == $_COOKIE['site_lang'] ){
         $locale = $headers["app_language"];
      }else{
         $locale = $_COOKIE['site_lang'];
      }
   } else if(isset($_COOKIE['site_lang'])){
      $locale = $_COOKIE['site_lang'];
   }
   if($locale == "en") $locale = "en_US";
   if($locale == "vi") $locale = "vi";
   if($locale == "ko") $locale = "ko_KR";

   switch_to_locale($locale);
}

function adjustDay($day) {
    $currentDay = date('d');
    $currentMonth = date('m');
    $currentYear = date('Y');

    // Convert the day parameter to an integer
    $day = intval($day);

    // Check if the current day is greater than the given day
    if ($currentDay > $day) {
        // Check if the current month is December
        if ($currentMonth === '12') {
            // Increment the current year
            $currentYear++;
        }
        // Adjust the day to the next year with the given day and month
        $adjustedDate = sprintf('%02d/%02d/%04d', $day, $currentMonth, $currentYear);
    } else {
        // Adjust the day to the current year with the given day and month
        $adjustedDate = sprintf('%02d/%02d/%04d', $day, $currentMonth, $currentYear);
    }

    return $adjustedDate;
}

function atlantis_current_datetime(){
   // Create a new DateTime object with the current time in the server's default timezone
   $server_timezone = new DateTimeZone(date_default_timezone_get());
   $current_datetime = new DateTime('now', $server_timezone);

   // Set the desired timezone (UTC+7 in this case)
   $utc_plus_7_timezone = new DateTimeZone('Asia/Bangkok');
   $current_datetime->setTimezone($utc_plus_7_timezone);

   // Format the date and time as 'YYYY-MM-DD HH:mm:ss'
   $formatted_datetime = $current_datetime->format('Y-m-d H:i:s');
   return $formatted_datetime;
}

function atlantis_current_date_only( $format = 'Y-m-d'){
   // Create a new DateTime object with the current time in the server's default timezone
   $server_timezone = new DateTimeZone(date_default_timezone_get());
   $current_datetime = new DateTime('now', $server_timezone);

   // Set the desired timezone (UTC+7 in this case)
   $utc_plus_7_timezone = new DateTimeZone('Asia/Bangkok');
   $current_datetime->setTimezone($utc_plus_7_timezone);

   // Format the date and time as 'YYYY-MM-DD HH:mm:ss'
   $formatted_datetime = $current_datetime->format($format);
   return $formatted_datetime;
}

function get_key_map(){
   return 'n3jhBrFdYLS-WMR8vOmWjLTxW8rZ7QsjQ4TwxHQHvr8';
}


add_filter('wp_mail_from_name', 'custom_wp_mail_from_name');
function custom_wp_mail_from_name($from_name) {
    return 'Watergo';
}

function pv_update_user_token(){

   if( is_user_logged_in() ){
      $current_user_id = get_current_user_id();
      $headers = array_change_key_case(getallheaders(), CASE_LOWER);
      if(!empty($headers["app_push_token"]) && $headers["app_push_token"] != "Token not found"){
         global $wpdb;
         $table = $wpdb->prefix."bj_user_push_token";
         $token = $headers["app_push_token"];
         $check_user_exist = $wpdb->get_results ( $wpdb->prepare(" SELECT * FROM  {$table} WHERE  user_id = %d ",$current_user_id) ,ARRAY_A);
      
         if (!empty($check_user_exist)){
            $result = $wpdb->update($table , ["token" => $token,"status" => ""], ["user_id" => $current_user_id],["%s","%s"],["%d"]);     
         }else{
            $result = $wpdb->insert($table,["user_id" => $current_user_id,"token" => $token],["%d","%s"]);
         }
      }
   }

}

function bj_push_notification($user_id, $title, $content, $link = "#"){
    if($user_id == get_current_user_id() or get_user_meta($user_id,'user_notification', true) == "0") return;
    global $wpdb; 
    $table = $wpdb->prefix.'bj_user_push_token';
    
    $result = $wpdb->get_results( $wpdb->prepare(" SELECT token FROM  {$table} WHERE  user_id = %d AND status ='' LIMIT 1",$user_id) ,ARRAY_A);

    if(!empty($result)){
        $user_token = $result[0]["token"];
    }else{
      return;
    }

    $url = 'http://watergo.net:8080/push-noti';
    $body = array(
        "app"     => "watergo",
        "token"   => $user_token,
        "body"    => $content,
        "title"   => $title,
        "link"    => $link
    );
    
   $headers = array('Content-Type: application/json');

   // $response = wp_remote_post($url, array(
   //    'headers'   => $headers,
   //    'body'      => json_encode($body),
   //    'method'    => 'POST',
   // ));

   // // Check for errors and handle the response
   // if (is_wp_error($response)) {
   //    return;
   // } else {
   //    return json_decode(wp_remote_retrieve_body($response));
   // }
  
   $ch = curl_init ();
   curl_setopt ( $ch, CURLOPT_URL, $url );
   curl_setopt ( $ch, CURLOPT_POST, true );
   curl_setopt ( $ch, CURLOPT_HTTPHEADER, $headers );
   curl_setopt ( $ch, CURLOPT_RETURNTRANSFER, true );
   curl_setopt ( $ch, CURLOPT_POSTFIELDS, json_encode($body) );

   $data = curl_exec ( $ch );
   curl_close ( $ch );   
   return json_decode($data);
}


function addZeroLeadingNumber( $number ){
   if ($number < 1000) {
      $formattedNumber = sprintf('%04d', $number);
   } else {
      $formattedNumber = $number;
   }
   return $formattedNumber;
}

function bj_render_nonce($string){
    return substr(md5("stsriJ8ek".$string), 0,25).substr(md5("sf393sq3fk".$string), 0,20);
}
function bj_verify_nonce($string,$input){
    return $string === bj_render_nonce($input) ? true : false;
}

add_action( 'init', 'login_via_app_data' );
function login_via_app_data(){
    $headers = array_change_key_case(getallheaders(), CASE_LOWER);
    if(!is_user_logged_in()){
        $user_token = "";
        if (!empty($headers["user_token"]) && $headers["user_token"] != "Token not found") {
            $user_token = $headers["user_token"];       
            $user_token_arr = explode("|||", $user_token);
            if(is_array($user_token_arr)){
                $user_id = $user_token_arr[0];
                $user_token = $user_token_arr[1];
                if (bj_verify_nonce($user_token,$user_id)){             
                    wp_clear_auth_cookie();
                    $user = wp_set_current_user($user_id);
                    wp_set_auth_cookie($user_id,true,is_ssl());
                    do_action('wp_login', $user->user_login, $user);
                } 
            }                           
        }
    }
}


function load_language() {
   load_theme_textdomain('watergo', get_template_directory() . '/languages');
}

add_action('after_setup_theme', 'load_language');

/**
 * @access SCHEDULE EVERY MIN (JOB)
 */


function my_schedule_function() {
   global $wpdb;

   // OPTION 1
   // $sql = "SELECT order_id, order_tag_repeat FROM wp_watergo_order WHERE order_status = 'ordered' AND order_hidden != 1 AND TIMESTAMPDIFF(MINUTE, order_time_created, CONVERT_TZ(NOW(), '+00:00', '+07:00') ) > 1";
   // OPTION 2
   $current_time = atlantis_current_datetime();
   $sql = "SELECT order_id, order_tag_repeat FROM wp_watergo_order WHERE order_status = 'ordered' AND order_hidden != 1 
      AND (UNIX_TIMESTAMP(order_time_created) + 3600) < UNIX_TIMESTAMP('$current_time')";

   $res = $wpdb->get_results($sql);

   if (!empty($res)) {
      $wheres = [];
      $order_tag_repeat = [];
      foreach ($res as $k => $vl) {
         $wheres[] = $vl->order_id;
         if( $vl->order_tag_repeat != null && $vl->order_tag_repeat != '' ){
            $order_tag_repeat[] = $vl->order_tag_repeat;
         }
      }
      
      $placeholders = implode(',', array_fill(0, count($wheres), '%d'));
      $placeholders_order_tag = implode(',', array_fill(0, count($order_tag_repeat), "'%s'"));

      $sql_order_cancel = "UPDATE wp_watergo_order SET order_status = 'cancel', order_time_cancel = %s WHERE order_id IN ($placeholders)";
      $exc_order_cancel = $wpdb->prepare($sql_order_cancel, $current_time, ...$wheres);
      $wpdb->query($exc_order_cancel);
      // REMOVE ORDER SETTINGS
      if( !empty($order_tag_repeat) ){
         $sql_change_order_setting = "UPDATE wp_watergo_order_settings SET wp_watergo_order_settings.repeat = 'no' WHERE order_tag_repeat IN ($placeholders_order_tag)";
         $exc_change_order_setting = $wpdb->prepare($sql_change_order_setting, ...$order_tag_repeat);
         $wpdb->query($exc_change_order_setting);
      }

      // SEND NOTIFI AND PUSH FOR 2 BOTH USER
      foreach($wheres as $order_id ){
         protocal_atlantis_notification_to_user([
            'order_status' => 'cancel',
            'order_id'     => $order_id
         ]);

         protocal_atlantis_notification_to_store([
            'order_status' => 'cancel',
            'order_id'     => $order_id
         ]);
      }
      
   }

}
add_action('order_events', 'my_schedule_function');

// Schedule the event on init
function my_schedule_init() {
    if (!wp_next_scheduled('order_events')) {
        wp_schedule_event(time(), 'every_minute', 'order_events');
    }
}
add_action('init', 'my_schedule_init');