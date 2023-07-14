<?php
  $page_url = 'pages/business/store';
  $store_page = isset($_GET['store_page']) ? $_GET['store_page'] : '';

  if ($store_page == 'store_profile') {
    $page_url .= '/store-profile';
    return get_template_part($page_url);
  }

  if ($store_page == 'store_edit_profile') {
    $page_url .= '/store-edit-profile';
    return get_template_part($page_url);
  }

  if ($store_page == 'store_reviews') {
    $page_url .= '/store-reviews-page';
    return get_template_part($page_url);
  }

  $page_url .= '/store-main';
  return get_template_part($page_url);
?>