<?php


$store_page = isset($_GET['store_page']) ? $_GET['store_page'] : '';

if( $store_page == 'store-detail'){
   get_template_part('pages/store/page-store-detail');
}


?>