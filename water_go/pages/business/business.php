<?php
  // LAYOUT FOR BUSINESS APP
  $business_page = isset($_GET['business_page']) ? $_GET['business_page'] : '';

  if ($business_page === 'products') {
    return get_template_part('pages/business/product/product');
  }

  return get_template_part('pages/business/product/product');
?>
