<?php
   $page_url = 'pages/business/product';
   $product_page = isset($_GET['product_page']) ? $_GET['product_page'] : '';
   $product_id = isset($_GET['product_id']) ? $_GET['product_id'] : '';

   if( $product_page === 'water' ) {
      $page_url .= '/page-product-water';
      return get_template_part($page_url);
   }

   if( $product_page === 'ice' ) {
      $page_url .= '/page-product-ice';
      return get_template_part($page_url);
   }

   if( $product_page === 'product-detail' && is_numeric($product_id)) {
      $page_url .= '/page-product-detail';
      return get_template_part($page_url);
   }

   $page_url .= '/page-products';
   return get_template_part($page_url);
?>