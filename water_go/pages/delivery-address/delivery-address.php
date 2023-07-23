<?php

$delivery_address_page = isset($_GET['delivery_address_page']) ? $_GET['delivery_address_page'] : '';


if($delivery_address_page == 'delivery-address-index'){
   get_template_part('pages/delivery-address/delivery-address-index');
}
if($delivery_address_page == 'delivery-address-add'){
   get_template_part('pages/delivery-address/delivery-address-add');
}
if($delivery_address_page == 'delivery-address-edit'){
   get_template_part('pages/delivery-address/delivery-address-edit');
}

