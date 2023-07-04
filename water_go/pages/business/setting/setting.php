<?php
  
  $store_page = isset($_GET['setting_page']) ? $_GET['setting_page'] : '';

  $page_url = 'pages/business/setting';
  if ($store_page == 'reminder_setting') {
    $page_url .= '/reminder-setting-page';
    return get_template_part($page_url);
  }

  if ($store_page == 'language_setting') {
    $page_url .= '/setting-language-page';
    return get_template_part($page_url);
  }

  if ($store_page == 'change_password') {
    $page_url .= '/setting-change-password-page';
    return get_template_part($page_url);
  }

  if ($store_page == 'delete_account') {
    $page_url .= '/setting-delete-account-page';
    return get_template_part($page_url);
  }

  $page_url .= '/setting-main';
  return get_template_part($page_url);
?>