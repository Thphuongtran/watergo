<?php

add_action( 'wp_ajax_nopriv_atlantis_get_order_report_by_datetime', 'atlantis_get_order_report_by_datetime' );
add_action( 'wp_ajax_atlantis_get_order_report_by_datetime', 'atlantis_get_order_report_by_datetime' );

function atlantis_get_order_report_by_datetime(){

   if( isset($_POST['action']) && $_POST['action'] == 'atlantis_get_order_report_by_datetime'){

      $store_id      = func_get_store_id_from_current_user();
      $current_date  = isset( $_POST['current_date'] ) ? $_POST['current_date'] : atlantis_current_date_only();
      $from_date     = isset( $_POST['from_date'] ) ? $_POST['from_date'] : '';

      if( $current_date == '' || $from_date == '' ){
         wp_send_json_error(['message' => 'order_not_found']);
         wp_die();
      }

      $current_date  = date('Y-m-d', strtotime($current_date));
      $from_date     = date('Y-m-d', strtotime($from_date));

      // COUNT TOTAL SOLD ORDER
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

      // COUNT TOTAL CANCEL ORDER
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
      $total_profit        = 0;

      $sold_range             = $res_count_sold[0]->sold != null ? $res_count_sold[0]->sold : 0;
      $cancel_range           = $res_count_cancel[0]->cancel != null ? $res_count_cancel[0]->cancel : 0;

      foreach( $res_count_profit as $k => $p ){
         $price = $p->price - ( ( $p->price * $p->discount ) / 100 );
         $total_profit += $price * $p->quantity;
      }

      // TOTAL SOLD
      $total_order_complete   = $wpdb->get_results(sql_atlantis_brand_report([
         'order_status' => 'complete',
         'from_date'    => $from_date,
         'current_date' => $current_date,
      ]));
      // TOTAL CANCEL
      $total_order_cancel     = $wpdb->get_results(sql_atlantis_brand_report([
         'order_status' => 'cancel',
         'from_date'    => $from_date,
         'current_date' => $current_date,
      ]));

      // TODAY SOLD
      $today_sold   = $wpdb->get_results(sql_atlantis_brand_report([
         'order_status' => 'complete',
         'from_date'    => $current_date,
         'current_date' => $current_date,
      ]));

      $today_sold = ! empty( $today_sold ) ? $today_sold[0]->total_order_complete : 0;

      // TODAY CANCEL
      $today_cancel     = $wpdb->get_results(sql_atlantis_brand_report([
         'order_status' => 'cancel',
         'from_date'    => $current_date,
         'current_date' => $current_date,
      ]));

      $today_cancel = ! empty( $today_cancel ) ? $today_cancel[0]->total_order_cancel : 0;

      // Calculate order comparison
      // $order_complete_Comparison = calculateOrderComparison( $today_sold, $total_order_complete);
      // $order_cancel_Comparison = calculateOrderComparison( $today_cancel, $total_order_cancel);
      $order_complete_Comparison = $sold_range - $today_sold;
      $order_cancel_Comparison   = $cancel_range - $today_cancel;
      
      $sold_rank     = 'normal';
      $cancel_rank   = 'normal';
      /**
         RANK normal high low
       */

      if( $sold_range > $order_complete_Comparison ){
         $sold_rank = 'low';
      }else {
         $sold_rank = 'high';
      }
      
      if( $cancel_range > $order_cancel_Comparison ){
         $cancel_rank = 'low';
      }else{
         $cancel_rank = 'high';
      }

      ////////////////////////////////////

      wp_send_json_success(['message' => 'get_order_ok', 'data' => [
         'sold'                        => $sold_range,
         'cancel'                      => $cancel_range,
         'profit'                      => $total_profit,

         'sold_rank'                   => $sold_rank,
         'cancel_rank'                 => $cancel_rank,

         'order_complete_Comparison'   => abs($order_complete_Comparison),
         'order_cancel_Comparison'     => abs($order_cancel_Comparison),
         'total_order_complete'        => $total_order_complete,
         'total_order_cancel'          => $total_order_cancel,
      ]]);


   }
}

function calculateOrderComparison($todayOrders, $totalArray) {
   $result = array();
   $totalComparisonResult = 0; // Initialize total comparison result

   foreach ($totalArray as $order) {
      $orderDate = $order->order_date;
      $totalOrder = (int)$order->total_order_complete;

      $comparisonResult = $todayOrders - $totalOrder;
      $totalComparisonResult += $comparisonResult; // Accumulate comparison results

      // $result[] = array(
      //    'order_date' => $orderDate,
      //    'comparison_result' => $comparisonResult
      // );
   }

   // Add the total comparison result to the result array
   // $result[] = array(
   //    'order_date' => 'Total',
   //    'comparison_result' => $totalComparisonResult
   // );

   // return $result;
   return $totalComparisonResult;
}

function sql_atlantis_brand_report( $args ){


   $order_status     = $args['order_status'];
   $from_date        = $args['from_date'];
   $current_date     = $args['current_date'];

   $sql = '';
   if( $order_status == 'complete' ){
      $sql = "SELECT
         DATE(order_time_completed) AS order_date,
         COUNT(CASE WHEN order_status = 'complete' THEN order_id END) AS total_order_complete
      FROM
         wp_watergo_order
      WHERE
         DATE_FORMAT(order_time_completed, '%Y-%m-%d') >= '$from_date'
         AND DATE_FORMAT(order_time_completed, '%Y-%m-%d') <= '$current_date'
      GROUP BY
         DATE(order_time_completed)
      ORDER BY
         order_date DESC
      ";
   }
   if( $order_status == 'cancel' ){
      $sql = "SELECT
         DATE(order_time_cancel) AS order_date,
         COUNT(CASE WHEN order_status = 'cancel' THEN order_id END) AS total_order_cancel
      FROM
         wp_watergo_order
      WHERE
         DATE_FORMAT(order_time_cancel, '%Y-%m-%d') >= '$from_date'
         AND DATE_FORMAT(order_time_cancel, '%Y-%m-%d') <= '$current_date'
      GROUP BY
         DATE(order_time_cancel)
      ORDER BY
         order_date DESC;
      ";
   }
   return $sql;

}


function getFullDate($day) {
   // Validate the input day
   if ($day < 1 || $day > 31) {
      return "Invalid input day";
   }

   // Get the current time in GMT+7 (Indochina Time)
   date_default_timezone_set('Asia/Bangkok');
   $current_time_gmt7 = time();

   // Get the current year and month
   $current_year = date('Y', $current_time_gmt7);
   $current_month = date('m', $current_time_gmt7);

   // Get the current day (without leading zeros) to use in strtotime function
   $current_day = date('j', $current_time_gmt7);

   // Create the full date for the input day (minus one day) in the format 'yyyy-mm-dd'
   $day_from = date('Y-m-d', strtotime("$current_year-$current_month-$day -1 day"));

   // Create the current full date (minus one day) in the format 'yyyy-mm-dd'
   $day_current = date('Y-m-d', strtotime("$current_year-$current_month-$current_day -1 day"));

   return array( 'day_from' => $day_from, 'day_current' => $day_current );
}


function getFirstAndLastDayOfMonth($month) {
   // Validate the input month
   if ($month < 1 || $month > 12) { return "Invalid input month"; }

   // Get the current year and current month
   date_default_timezone_set('Asia/Bangkok');
   $current_year = date('Y');
   $current_month = date('m');

   // Create the first day of the input month
   $first_day = date('Y-m-d', strtotime("$current_year-$month-01"));

   // Create the last day of the input month
   $last_day = date('Y-m-t', strtotime("$current_year-$month-01"));

   // Create the first day of the current month
   $current_first_day = date('Y-m-01');

   // Create the last day of the current month
   $current_last_day = date('Y-m-t');

   return array(
      'month_start'         => $first_day,
      'month_end'           => $last_day,
      'current_month_start' => $current_first_day,
      'current_month_end'   => atlantis_current_date_only()
   );
}

/**
 * @access VERSION 2
 */

function func_atlantis_build_query_report( $store_id, $date_from, $date_to ){
   $sql_profit = "SELECT 
      wp_watergo_order_group.order_group_product_price as price,
      wp_watergo_order_group.order_group_product_discount_percent as discount,
      wp_watergo_order_group.order_group_product_quantity_count as quantity
      FROM wp_watergo_order
      LEFT JOIN wp_watergo_order_group
      ON wp_watergo_order_group.hash_id = wp_watergo_order.hash_id
      WHERE order_status = 'complete' AND order_store_id = $store_id
      AND DATE_FORMAT(order_time_completed, '%Y-%m-%d') >= '$date_from' 
      AND DATE_FORMAT(order_time_completed, '%Y-%m-%d') <= '$date_to'
   ";
   $sql_sold = "SELECT COUNT(order_id) AS sold
      FROM wp_watergo_order
      WHERE order_status = 'complete' AND order_store_id = $store_id
      AND DATE_FORMAT(order_time_completed, '%Y-%m-%d') >= '$date_from' 
      AND DATE_FORMAT(order_time_completed, '%Y-%m-%d') <= '$date_to'
   ";
   $sql_cancel = "SELECT COUNT(order_id) AS cancel
      FROM wp_watergo_order
      WHERE order_status = 'cancel' AND order_store_id = $store_id
      AND DATE_FORMAT(order_time_cancel, '%Y-%m-%d') >= '$date_from' 
      AND DATE_FORMAT(order_time_cancel, '%Y-%m-%d') <= '$date_to'
   ";

   global $wpdb;
   $profit  = $wpdb->get_results($sql_profit);
   $sold    = $wpdb->get_results($sql_sold);
   $cancel  = $wpdb->get_results($sql_cancel);

   $data = [
      'profit' => 0,
      'sold'   => 0,
      'cancel' => 0
   ];

   if( !empty( $profit)){
      $total_profit = 0;
      foreach( $profit as $k => $p ){
         $price = $p->price - ( $p->price * ( $p->discount  / 100 ) );
         $total_profit += $price * $p->quantity;
      }
      $data['profit'] = $total_profit;
   }

   if( !empty( $sold)){
      if( $sold[0]->sold != null && $sold[0]->sold > 0 ){
         $data['sold'] = (int) $sold[0]->sold;
      }
   }

   if( !empty( $cancel)){
      if( $cancel[0]->cancel != null && $cancel[0]->cancel > 0 ){
         $data['cancel'] = (int) $cancel[0]->cancel;
      }
   }

   return $data;

}

add_action( 'wp_ajax_nopriv_atlantis_get_today_order_report', 'atlantis_get_today_order_report' );
add_action( 'wp_ajax_atlantis_get_today_order_report', 'atlantis_get_today_order_report' );

function atlantis_get_today_order_report(){
   if( isset($_POST['action']) && $_POST['action'] == 'atlantis_get_today_order_report'){

      $store_id      = func_get_store_id_from_current_user();
      $current_date  = atlantis_current_date_only();
      $res           = func_atlantis_build_query_report($store_id, $current_date, $current_date);

      wp_send_json_success(['message' => 'get_order_ok', 'data' => $res ]);
      wp_die();

   }
}


add_action( 'wp_ajax_nopriv_atlantis_get_range_day_order_report', 'atlantis_get_range_day_order_report' );
add_action( 'wp_ajax_atlantis_get_range_day_order_report', 'atlantis_get_range_day_order_report' );

function atlantis_get_range_day_order_report(){
   if( isset($_POST['action']) && $_POST['action'] == 'atlantis_get_range_day_order_report'){
      $store_id         = func_get_store_id_from_current_user();
      $current_date     = atlantis_current_date_only();

      $date_from        = isset($_POST['date_from'])  ? $_POST['date_from'] : 0;
      $date_to          = isset($_POST['date_to'])    ? $_POST['date_to'] : 0;

      $day              = func_atlantis_build_query_report($store_id, $date_from, $date_to);
      $day_current      = func_atlantis_build_query_report($store_id, $current_date, $current_date);

      wp_send_json_success(['message' => 'get_order_ok', 
         'data' => [

            'report_range' => [
               'profit' => $day['profit'],
               'sold'   => $day['sold'],
               'cancel' => $day['cancel'],
            ],
            'report_today' => [
               'profit' => $day_current['profit'],
               'sold'   => $day_current['sold'],
               'cancel' => $day_current['cancel'],
            ]
         ]
      ]);
      wp_die();

   }
}

add_action( 'wp_ajax_nopriv_atlantis_get_range_month_order_report', 'atlantis_get_range_month_order_report' );
add_action( 'wp_ajax_atlantis_get_range_month_order_report', 'atlantis_get_range_month_order_report' );

function atlantis_get_range_month_order_report(){
   if( isset($_POST['action']) && $_POST['action'] == 'atlantis_get_range_month_order_report' ){
      $store_id                  = func_get_store_id_from_current_user();

      // start - end day of month
      $start_day_month           = isset($_POST['start_day_month']) ? $_POST['start_day_month'] : 0;
      $end_day_month             = isset($_POST['end_day_month']) ? $_POST['end_day_month'] : 0;
      
      // start - end day of current month
      $start_day_month_current   = isset($_POST['start_day_month_current']) ? $_POST['start_day_month_current'] : 0;
      $end_day_month_current     = isset($_POST['end_day_month_current']) ? $_POST['end_day_month_current'] : 0;

      $month                     = func_atlantis_build_query_report($store_id, $start_day_month, $end_day_month);
      $month_current             = func_atlantis_build_query_report($store_id, $start_day_month_current, $end_day_month_current);

      wp_send_json_success(['message' => 'get_order_ok', 
         'data' => [

            'report_range' => [
               'profit' => $month['profit'],
               'sold'   => $month['sold'],
               'cancel' => $month['cancel'],
            ],
            'report_today' => [
               'profit' => $month_current['profit'],
               'sold'   => $month_current['sold'],
               'cancel' => $month_current['cancel'],
            ]
         ]
      ]);

      wp_die();


   }
}


add_action( 'wp_ajax_nopriv_atlantis_get_range_year_order_report', 'atlantis_get_range_year_order_report' );
add_action( 'wp_ajax_atlantis_get_range_year_order_report', 'atlantis_get_range_year_order_report' );

function atlantis_get_range_year_order_report(){
   if( isset($_POST['action']) && $_POST['action'] == 'atlantis_get_range_year_order_report' ){
      $store_id            = func_get_store_id_from_current_user();

      $start_day           = isset($_POST['start_day']) ? $_POST['start_day'] : 0;
      $end_day             = isset($_POST['end_day']) ? $_POST['end_day'] : 0;

      $current_start_day   = isset($_POST['current_start_day']) ? $_POST['current_start_day'] : 0;
      $current_end_day     = isset($_POST['current_end_day']) ? $_POST['current_end_day'] : 0;

      $year                = func_atlantis_build_query_report($store_id, $start_day, $end_day);
      $year_current        = func_atlantis_build_query_report($store_id, $current_start_day, $current_end_day);

      wp_send_json_success(['message' => 'get_order_ok', 
         'data' => [
            'report_range' => [
               'profit' => $year['profit'],
               'sold'   => $year['sold'],
               'cancel' => $year['cancel'],
            ],
            'report_today' => [
               'profit' => $year_current['profit'],
               'sold'   => $year_current['sold'],
               'cancel' => $year_current['cancel'],
            ]
         ]
      ]);

      wp_die();

   }
}
