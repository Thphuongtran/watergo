<?php
  $page_url = 'pages/business/support';
  $support_page = isset($_GET['support_page']) ? $_GET['support_page'] : '';
  $question_id = isset($_GET['question_id']) ? $_GET['question_id'] : '';

  if ($support_page == 'store_profile') {
    $page_url .= '/store-profile';
    return get_template_part($page_url);
  }

  if ($support_page == 'add_question') {
    $page_url .= '/support-add-question';
    return get_template_part($page_url);
  }


  if ($support_page == 'self_question') {
    $page_url .= '/support-self-question';
    return get_template_part($page_url);
  }

  if (is_numeric($question_id)) {
    $page_url .= '/support-question-detail';
    return get_template_part($page_url);
  }

  $page_url .= '/support-main';
  return get_template_part($page_url);
?>