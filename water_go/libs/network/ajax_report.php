<?php

add_action( 'wp_ajax_nopriv_atlantis_get_order_report_by_datetime', 'atlantis_get_order_report_by_datetime' );
add_action( 'wp_ajax_atlantis_get_order_report_by_datetime', 'atlantis_get_order_report_by_datetime' );

function atlantis_get_order_report_by_datetime(){

   if( isset($_POST['action']) && $_POST['action'] == 'atlantis_get_order_report_by_datetime'){

      $store_id      = func_get_store_id_from_current_user();
      $current_date  = isset( $_POST['current_date'] ) ? $_POST['current_date'] : date('Y-m-d');
      $from_date     = isset( $_POST['from_date'] ) ? $_POST['from_date'] : '';

      if( $current_date == '' || $from_date == '' ){
         wp_send_json_error(['message' => 'order_not_found']);
         wp_die();
      }

      $current_date  = date('Y-m-d', strtotime($current_date));
      $from_date     = date('Y-m-d', strtotime($from_date));

      // COUNT SOLD ORDER
      $sql_count_sold = "SELECT 
            COUNT(order_id) AS sold
         FROM wp_watergo_order
         WHERE order_status = 'complete' AND order_store_id = $store_id
         AND DATE_FORMAT(order_time_completed, '%Y-%m-%d') >= '$from_date' 
         AND DATE_FORMAT(order_time_completed, '%Y-%m-%d') <= '$current_date'
      ";

      // COUNT PROFIT 
      $sql_count_profit = "SELECT 
			-- wp_watergo_order_group.order_group_id,
			-- wp_watergo_order_group.order_group_product_id,
         wp_watergo_order_group.order_group_product_price as price,
         wp_watergo_order_group.order_group_product_discount_percent as discount,
         wp_watergo_order_group.order_group_product_quantity_count as quantity

         FROM wp_watergo_order

         LEFT JOIN wp_watergo_order_group
         ON wp_watergo_order_group.hash_id = wp_watergo_order.hash_id

         WHERE order_status = 'complete' AND order_store_id = $store_id
         AND DATE_FORMAT(order_time_completed, '%Y-%m-%d') >= '$from_date' 
         AND DATE_FORMAT(order_time_completed, '%Y-%m-%d') <= '$current_date'
      ";

      // COUNT CANCEL ORDER
      $sql_count_cancel = "SELECT
            COUNT(order_id) AS cancel
         FROM wp_watergo_order
         WHERE order_status = 'cancel' AND order_store_id = $store_id
         AND DATE_FORMAT(order_time_cancel, '%Y-%m-%d') >= '$from_date' 
         AND DATE_FORMAT(order_time_cancel, '%Y-%m-%d') <= '$current_date'
      ";


      global $wpdb;
      $res_count_sold      = $wpdb->get_results($sql_count_sold);
      $res_count_cancel    = $wpdb->get_results($sql_count_cancel);
      $res_count_profit    = $wpdb->get_results($sql_count_profit);

      $total_profit = 0;

      foreach( $res_count_profit as $k => $p ){
         if( $p->discount == null || $p->discount == 0 ){
            $total_profit += $p->price * $p->quantity;
         }
      }


      wp_send_json_success(['message' => 'get_order_ok', 'data' => [
         'sold'         => $res_count_sold[0]->sold,
         'cancel'       => $res_count_cancel[0]->cancel,
         'profit'       => $total_profit,
         'sql_sold'     => $sql_count_sold,
         'sql_cancel'   => $sql_count_cancel,
      ]]);






   }
}