<?php


add_action( 'wp_ajax_atlantis_add_support', 'atlantis_add_support' );
function atlantis_add_support(){
   if( isset($_POST['action']) && $_POST['action'] == 'atlantis_add_support' ){
      $question = isset($_POST['question']) ? $_POST['question'] : '';

      if( $question == '' ){
         wp_send_json_error(['message' => 'support_not_found']);
         wp_die();
      }
      
      date_default_timezone_set('Asia/Bangkok');
      $user_id = get_current_user_id();

      global $wpdb;
      $wpdb->insert('wp_watergo_supports', [
         'question'  => $question,
         'user_id'   => $user_id,
         'is_read'   => 1,
         'time_created' => time(),
         'page_manager' => 'user'
      ]);
      wp_send_json_success(['message' => 'question_found']);
      wp_die();
   }
}

add_action( 'wp_ajax_atlantis_as_read_support', 'atlantis_as_read_support' );
function atlantis_as_read_support(){
   if( isset($_POST['action']) && $_POST['action'] == 'atlantis_as_read_support' ){
      $id = isset($_POST['id']) ? $_POST['id'] : '';
      global $wpdb;
      $wpdb->update('wp_watergo_supports', ['is_read' => 1], ['id' => $id]);
      wp_send_json_success(['message' => 'question_found' ]);
      wp_die();

   }
}


add_action( 'wp_ajax_atlantis_action_question_from_admin_page', 'atlantis_action_question_from_admin_page' );
// GET QUESTION FROM ADMIN ONLY ( admin wp ) 
function atlantis_action_question_from_admin_page(){
   if( isset($_POST['action']) && $_POST['action'] == 'atlantis_action_question_from_admin_page' ){

      $user_id = get_current_user_id();

      $event = isset($_POST['event']) ? $_POST['event'] : '';

      $page_manager = isset($_POST['page_manager']) ? $_POST['page_manager'] : '';

      if( !in_array( $event, ['add', 'edit', 'get' ] )){
         wp_send_json_error(['message' => 'question_not_found']);
         wp_die();
      }

      $id            = isset($_POST['id']) ? $_POST['id'] : '';
      $question      = isset($_POST['question']) ? $_POST['question'] : '';
      $answer        = isset($_POST['answer']) ? $_POST['answer'] : '';
      $select_app    = isset($_POST['select_app']) ? $_POST['select_app'] : '';

      // SPEC answer_user => from admin
      $answer_user   = isset($_POST['answer_user']) ? $_POST['answer_user'] : 0;

      if( $event == 'get' ){
         global $wpdb;
         $sql = "SELECT * FROM wp_watergo_supports WHERE id = $id";
         $res = $wpdb->get_results( $sql);
         
         if( empty( $res )){
            wp_send_json_error(['message' => 'question_not_found']);
            wp_die();
         }

         wp_send_json_success(['message' => 'question_found', 'data' => $res[0] ]);
         wp_die();
      }

      if( $event == 'add' ){
         global $wpdb;
         // SET GMT+7
         date_default_timezone_set('Asia/Bangkok');
         $wpdb->insert('wp_watergo_supports', [
            'question'     => $question,
            'answer'       => $answer,
            'admin_id'     => $user_id,
            'select_app'   => $select_app,
            'time_created' => time(),
            'page_manager' => $page_manager
         ]);

         wp_send_json_success(['message' => 'question_found', 'data' ]);
         wp_die();
      }

      if( $event == 'edit'){
         global $wpdb;
         if( $page_manager == 'admin' ){
            $update_data = [];
            if( $question ){
               $update_data['question'] = $question;
            }
            if( $answer ){
               $update_data['answer'] = $answer;
            }
            if($select_app ){
               $update_data['select_app'] = $select_app;
            }
            
            $wpdb->update('wp_watergo_supports', $update_data, ['id' => $id ]);
         }
         else if( $page_manager == 'user' ){
            date_default_timezone_set('Asia/Bangkok');
            $wpdb->update('wp_watergo_supports',[ 'admin_id' => $user_id, 'answer' => $answer, 'time_answer' => time() ], ['id' => $id ]);
         }
         else{
            wp_send_json_error(['message' => 'question_not_found']);
            wp_die();
         }

         wp_send_json_success(['message' => 'question_found']);
         wp_die();
      }

      wp_send_json_error(['message' => 'question_not_found']);
      wp_die();



   }
}



/**
 * @access GET ALL QUESTION FROM CURRENT USER
 */
