<?php 

$user_page = isset($_GET['user_page']) ? $_GET['user_page'] : '';


if( is_user_logged_in() ){

   if( $user_page == 'user-profile' ){
      get_template_part('pages/user/page-user-profile');
   }

   if( $user_page == 'user-edit' ){
      get_template_part('pages/user/page-user-edit');
   }

   if( $user_page == 'user-delivery-address' ){
      get_template_part('pages/user/page-user-delivery-address');
   }

   if( $user_page == 'user-settings' ){
      get_template_part('pages/user/page-user-settings');
   }

   if( $user_page == 'user-language' ){
      get_template_part('pages/user/page-user-language');
   }

   if( $user_page == 'user-password' ){
      get_template_part('pages/user/page-user-password');
   }

   if( $user_page == 'user-review-edit' ){
      get_template_part('pages/user/page-user-review-edit');
   }

   if( $user_page == 'user-delete-account' ){
      get_template_part('pages/user/page-user-delete-account');
   }

   if( $user_page == 'user-term-conditions' ){
      get_template_part('pages/user/page-user-term-conditions');
   }

}else{

   get_template_part('pages/authentication/page-auth-login');
}

