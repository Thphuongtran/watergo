<?php
  // LAYOUT FOR BUSINESS APP
  $business_page = isset($_GET['business_page']) ? $_GET['business_page'] : '';

  if ($business_page == 'products') {
    return get_template_part('pages/business/product/product');
  }

  if ($business_page == 'reports') {
    return get_template_part('pages/business/report/report');
  }

  if ($business_page == 'store') {
    return get_template_part('pages/business/store/store');
  }

  if ($business_page == 'setting') {
    return get_template_part('pages/business/setting/setting');
  }

  if ($business_page == 'support') {
    return get_template_part('pages/business/support/support');
  }

  return get_template_part('pages/business/product/product');
?>
