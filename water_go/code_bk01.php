
 <?php 
 
 // ------------------- GET ALL ID RELATION 
                  $sql_find_relaship_order_repeat = "SELECT
                     t1.order_repeat_order_id AS order_repeat_order_id,
                     t2.order_repeat_order_id_parent AS order_repeat_order_id_parent,
                     t3.order_repeat_count AS order_repeat_count
                  FROM
                     wp_watergo_order_repeat t1
                  LEFT JOIN
                     wp_watergo_order_repeat t2 
                     ON t1.order_repeat_order_id = t2.order_repeat_order_id
                  LEFT JOIN 
                  	wp_watergo_order_repeat as t3
                  	ON t2.order_repeat_order_id_parent = t3.order_repeat_order_id_parent
                  WHERE
                     t1.order_repeat_order_id_parent = $_order_id
                  ORDER BY t3.order_repeat_count DESC
                  ";

                  $res_find_relaship_order_repeat = $wpdb->get_results( $sql_find_relaship_order_repeat);
                  $list_all_order_id = [];
                  
                  foreach( $res_find_relaship_order_repeat as $k => $vl ){
                     $list_all_order_id[] = $vl->order_repeat_order_id_parent;

                     // is original
                     if( $vl->order_repeat_count == 0 ){
                        $_order_id_original = $vl->order_repeat_order_id;
                     }
                  }

                  // ------------------- GET ORDER + SHIPPING
                  $placeholders = implode(',', array_fill(0, count($list_all_order_id), '%d'));
                  $sql_order_shipping = "SELECT 
                     wp_watergo_order.order_id,
                     wp_watergo_order.order_time_shipping_id,
                     wp_watergo_order_time_shipping.order_time_shipping_day
                  FROM wp_watergo_order
                  LEFT JOIN wp_watergo_order_time_shipping
                  ON wp_watergo_order_time_shipping.order_time_shipping_id = wp_watergo_order.order_time_shipping_id
                  WHERE wp_watergo_order.order_id IN ($placeholders) 
                  AND wp_watergo_order.order_status = 'ordered' OR wp_watergo_order.order_status = 'confirmed'
                  -- ORDER BY wp_watergo_order_time_shipping.order_time_shipping_day DESC
                  ORDER BY wp_watergo_order.order_time_created ASC
                  ";

                  $order_shipping = $wpdb->get_results( $sql_order_shipping);

                  // ------------------- GET LIST SHIPPING
                  $sql_get_all_time_shipping_from_original = "SELECT 
                     order_time_shipping_day,
                     order_time_shipping_id
                     FROM wp_watergo_order_time_shipping 
                     WHERE order_time_shipping_order_id = $_order_id_original";
                  
                  $time_shipping = $wpdb->get_results($sql_get_all_time_shipping_from_original);
                  $time_shipping_day = [];
                  foreach( $time_shipping as $k => $vl ){
                     $time_shipping_day[] = $vl->day;
                  }

                  usort( $time_shipping, function($a , $b ){
                     return $a->order_time_shipping_day <=> $b->order_time_shipping_day;
                  });

                  $last_shipping_day = end($time_shipping)->order_time_shipping_day;
                  $next_shipping_day = reset($time_shipping_day)->order_time_shipping_day;

                  // // Find the next shipping day that is greater than the last shipping day
                  foreach ($key_date as $day) {
                     if ($day > $last_shipping_day) {
                        $next_shipping_day = $day;
                        break;
                     }
                  }

                  // // Find the corresponding shipping ID based on the next shipping day
                  $next_shipping_id = null;
                  foreach ($order_shipping['data'] as $shipping) {
                     if ($shipping['order_time_shipping_day'] == $next_shipping_day) {
                        $next_shipping_id = $shipping['order_time_shipping_id'];
                        break;
                     }
                  }
                  







                  SELECT
    t1.order_repeat_order_id AS child_order_repeat_order_id,
    t1.order_repeat_order_id_parent AS child_order_repeat_order_id_parent,

    t2.order_repeat_order_id AS parent_order_repeat_order_id,
    t2.order_repeat_order_id_parent AS parent_order_repeat_order_id_parent
FROM
    wp_watergo_order_repeat t1

JOIN
    wp_watergo_order_repeat t2 ON t1.order_repeat_order_id = t2.order_repeat_order_id
WHERE
    t1.order_repeat_order_id_parent = 256;








    $id_shipping_from_previous_order = $vl->order_time_shipping_id;
                  
                  $sql_find_shipping_id = "SELECT * FROM wp_watergo_order_time_shipping WHERE order_time_shipping_order_id = $order_id ";
                  $res_find_shipping_id = $wpdb->get_resulsts($sql_find_shipping_id);
                  $shipping_id_next = 0;

                  if( !empty($res_find_shipping_id) && $vl->order_delivery_type == 'monthly' ) {
                     $currentDay = date('j'); // Get the current day (1-31)
                     $closestDay = array_reduce($date_array, function ($closest, $entry) use ($currentDay) {
                        $entryDay = $entry;
                        $closestDay = $closest;
                        // Calculate the absolute difference between the entry day and the current day
                        $entryDiff = abs($entryDay - $currentDay);
                        $closestDiff = abs($closestDay - $currentDay);
                        // Update the closest entry if the current entry is closer
                        if ($entryDiff < $closestDiff) {
                           return $entry;
                        }
                        return $closest;
                     });


                  }









                  function atlantis_order_status(){
   if( isset( $_POST['action'] ) && $_POST['action'] == 'atlantis_order_status' ){
      
      $order_id = isset($_POST['order_id']) ? $_POST['order_id'] : '';
      $timestamp = isset($_POST['timestamp']) ? $_POST['timestamp'] : 0;

      $status = isset($_POST['status']) ? $_POST['status'] : '';

      if($order_id == '' || $status == ''){
         wp_send_json_error(['message' => 'order_not_found' ]);
         wp_die();
      }

      if(is_user_logged_in() == true ){
         $user_id = get_current_user_id();
         $user = get_user_by('id', $user_id);
         $prefix_user = 'user_' . $user->data->ID;
      }else{
         wp_send_json_error(['message' => 'no_login_invalid' ]);
         wp_die();
      }

      $order_ids = json_decode($order_id);
      $wheres = [];

      if( ! empty($order_ids) ){
         foreach( $order_ids as $ids ){
            $wheres[] = $ids;
         }
      }

      global $wpdb;

      if( ! empty( $wheres )){
         
         $order_time = '';

         if( $status == 'confirmed' ){
            $order_status = 'confirmed';
            $order_time = "order_time_confirmed = %d ";
         }
         if( $status == 'delivering' ){
            $order_status = 'delivering';
            $order_time = "order_time_delivery = %d ";
         }
         if( $status == 'complete' ){
            $order_status = 'complete';
            $order_time = "order_time_completed = %d ";


            // IF ORDER IS WEEKLY OR MONTHLY - MAKE NEW ORDER

            $get_items = $wpdb->get_results(
               $wpdb->prepare(
                  "SELECT * FROM wp_watergo_order
                  WHERE order_id IN (". implode(',', array_fill(0, count($wheres), '%d')) . ")",
                  // FILL DATA
                  ...$wheres
               )
            );

            foreach( $get_items as $k => $vl ){

               if( $vl->order_delivery_type == 'weekly' || $vl->order_delivery_type == 'monthly'){
                  
                  $_hash_id = $vl->hash_id;
                  $_order_id = $vl->order_id;

                  // GET FATHER ID 
                  $sql_get_father_id = "SELECT order_repeat_id FROM wp_watergo_order 
                     WHERE order_id = $_order_id 
                     ORDER BY order_repeat_count DESC 
                     LIMIT 1 ";
                  $res_father = $wpdb->get_results($sql_get_father_id);
                  if( empty( $res_father ) ){
                     $id_father = $_order_id;
                  }else{
                     if( $res_father[0]->order_repeat_id != 0 ){
                        $id_father = $res_father[0]->order_repeat_id;
                     }else{
                        $id_father = $_order_id;
                     }
                  }

                  // CHECK FATHER ID still keep automatic repeat order
                  $_is_order_keep_repeat_order = null;

                  $sql_check_order_repeat = "SELECT order_keep_repeat FROM wp_watergo_order
                     WHERE order_id = $id_father
                  ";
                  $res_repeat = $wpdb->get_results($sql_check_order_repeat);
                  if( ! empty( $res_repeat ) ){
                     $_is_order_keep_repeat_order = $res_repeat[0]->order_keep_repeat;
                  }

                  if( $_is_order_keep_repeat_order == 1){
                     $_new_hash_id = '';

                     /**
                      * @access CLONE ORDER
                        */

                     $sql_check_repeat_self = "SELECT order_repeat_id, order_repeat_count FROM 
                        wp_watergo_order
                        WHERE order_id = $_order_id
                        ORDER BY order_repeat_count DESC
                        LIMIT 1
                     ";

                     $res_check_repeat = $wpdb->get_results( $sql_check_repeat_self);
                     $_order_repeat_id    = $res_check_repeat[0]->order_repeat_id;
                     $_order_repeat_count = $res_check_repeat[0]->order_repeat_count;

                     // no relationship
                     if( $_order_repeat_id == 0 && $_order_repeat_count == 0 ){
                        $_new_hash_id = atlantis_clone_order($_order_id, 1 , 1);
                     }else{
                        // 
                        $_new_hash_id = atlantis_clone_order($_order_repeat_id, $_order_repeat_count + 1, 0);
                     }

                     alantis_clone_order_group($_hash_id, $_new_hash_id);
                  }

               }
            }

         }

         if( $status == 'cancel' ){
            $order_status = 'cancel';
            $order_time = "order_time_cancel = %d ";
         }

         $updated = $wpdb->query(
            $wpdb->prepare(
               "UPDATE wp_watergo_order
               SET order_status = %s, 
               $order_time
               WHERE order_id IN (". implode(',', array_fill(0, count($wheres), '%d')) . ")",
               // FILL DATA
               $order_status,
               $timestamp,
               ...$wheres
            )
         );


        if ( $updated ) {
            $insert_id = $wpdb->insert_id;
            wp_send_json_success( array( 'message' => 'order_status_ok', 'data' => $updated ) );
         } else {
            wp_send_json_error( array( 'message' => 'order_not_found', 'data' => $updated ) );
         }


         wp_die();
      }

      wp_send_json_error(['message' => 'order_not_found']);
      wp_die();

   }
}