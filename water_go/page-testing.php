<?php 
get_header();


$user_id = get_current_user_id();
$user = get_user_by('id', $user_id);


if( is_user_logged_in() && $user->data->user_login == 'taiemzo002z' ){
   echo '<pre>';
   print_r(getallheaders());
   echo '</pre>';
}

?>
<h1>PAGE TESTING</h1>
<?php
get_footer();