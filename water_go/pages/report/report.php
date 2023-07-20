<?php 

$report_page = isset($_GET['report_page']) ? $_GET['report_page'] : '';

if( is_user_logged_in() ){
   if( $report_page == 'report-index'){
      get_template_part('pages/report/report-index');
   }
}else{
   get_template_part('pages/authentication/page-auth-store-login');
}