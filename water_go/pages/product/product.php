<?php 


   $product_page = isset($_GET['product_page']) ? $_GET['product_page'] : '';

   $product_id = isset($_GET['product_id']) ? $_GET['product_id'] : '';

   if( $product_page == 'water' ){
      get_template_part('pages/product/page-product-water');
   }

   if( $product_page == 'ice' ){
      get_template_part('pages/product/page-product-ice');
   }

   if( $product_page == 'product-detail' && is_numeric($product_id)){
      get_template_part('pages/product/page-product-detail');
   }

   if( $product_page == 'recommend' ){
      get_template_part('pages/product/page-product-recommend');
   }

?>