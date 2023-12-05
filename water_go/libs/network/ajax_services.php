<?php

add_action('wp_ajax_atlantis_send_job', 'atlantis_send_job');
function atlantis_send_job() {
   if( isset($_POST['action']) && $_POST['action'] == 'atlantis_send_job' ){

      // if( ! is_user_logged_in() ){
      //    wp_die();
      // }
      wp_send_json_success(['message' => 'job_is_running' ]);
      wp_die();

      $client = new GearmanClient();
      $client->addServer();

      $job_name   = 'process_order';
      $payload    = isset($_POST['payload']) ? $_POST['payload'] : '';

      $client->doBackground($job_name, $payload);

   }
}
