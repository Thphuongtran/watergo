<?php 
get_header();


global $wpdb;

$currentDate   = '2023-07-23 00:00:00'; 
$dateSelect    = '2023-07-01 00:00:00'; 

$datePart1 = date('Y-m-d', strtotime($dateSelect));
$datePart2 = date('Y-m-d', strtotime($currentDate));

global $wpdb;

$sql_count_order_success = "SELECT * FROM wp_watergo_order 
   WHERE DATE_FORMAT(order_time_completed, '%Y-%m-%d') >= '2023-07-20' 
   AND DATE_FORMAT(order_time_completed, '%Y-%m-%d') <= '2023-07-23' 
   AND order_store_id = 5
";

$sql_count_order_cancel = "SELECT * FROM wp_watergo_order 
   WHERE DATE_FORMAT(order_time_cancel, '%Y-%m-%d') >= '2023-07-20' 
   AND DATE_FORMAT(order_time_cancel, '%Y-%m-%d') <= '2023-07-23' 
   AND order_store_id = 5
";


$results = $wpdb->get_results($sql);
echo '<pre>';
print_r($results);
echo '</pre>';

?>
<h1>PAGE TESTING</h1>
<?php
get_footer();