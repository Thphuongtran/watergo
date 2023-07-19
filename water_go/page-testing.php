<?php 
get_header();




   echo '<pre>';
      // print_r(func_atlantis_get_order_fullpack([
      //    'get_by' => 'store_id',
      //    'related_id' => 22,
      //    'order_status' => '',
      //    'is_get_product_related' => 1
      // ]));
      print_r( func_atlantis_get_order_fullpack([
         'get_by'                   => 'order_id',
         'related_id'               => 395,
         'order_status'             => '',
         'limit'                    => -1,
         'is_get_product_related'   => 1,
         'is_get_time_shipping'     => 1

      ]) );
   echo '</pre>';


?>
<h1>PAGE TESTING</h1>
<?php
get_footer();