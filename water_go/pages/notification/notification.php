<?php

$code = isset($_GET['code']) ? $_GET['code'] : '';

$notificatio_page = isset($_GET['page_notification']) ? $_GET['page_notification']: '';

if( $notificatio_page == 'notification-index' ){
   get_template_part('pages/notification/notification-index');
}
