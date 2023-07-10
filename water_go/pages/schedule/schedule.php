<?php 

$schedule_page = isset($_GET['schedule_page']) ? $_GET['schedule_page'] : '';

if( $schedule_page == 'page-schedule-index' ){
   get_template_part('pages/schedule/page-schedule-index');
}
