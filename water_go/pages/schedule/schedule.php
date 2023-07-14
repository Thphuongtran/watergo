<?php 

$schedule_page = isset($_GET['schedule_page']) ? $_GET['schedule_page'] : '';

if( is_user_logged_in() ){
   if( $schedule_page == 'page-schedule-index' ){
      get_template_part('pages/schedule/page-schedule-index');
   }

   if( $schedule_page == 'page-schedule-detail' ){
      get_template_part('pages/schedule/page-schedule-detail');
   }

}else{
   get_template_part('pages/authentication/page-auth-store-login');
}