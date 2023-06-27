<?php

$support_page = isset($_GET['support_page']) ? $_GET['support_page'] : '';

if( $support_page == 'support-index'){
   get_template_part('pages/support/support-index');
}

if( $support_page == 'page-support-detail'){
   get_template_part('pages/support/page-support-detail');
}

if( $support_page == 'page-support-add'){
   get_template_part('pages/support/page-support-add');
}

if( $support_page == 'page-support-notification'){
   get_template_part('pages/support/page-support-notification');
}

if( $support_page == 'page-support-notification-detail'){
   get_template_part('pages/support/page-support-notification-detail');
}
