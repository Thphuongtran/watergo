<?php 


$product_page = isset($_GET['product_page']) ? $_GET['product_page'] : '';

$allow_tab_product_user = ['water', 'ice', 'recommend', 'top-products', 'product-detail'];

if( in_array($product_page, $allow_tab_product_user)  ){

   if( $product_page == 'water' ){
      get_template_part('pages/product/page-product-water');
   }

   if( $product_page == 'ice' ){
      get_template_part('pages/product/page-product-ice');
   }

   if( $product_page == 'recommend' ){
      get_template_part('pages/product/page-product-recommend');
   }

   if( $product_page == 'top-products' ){
      get_template_part('pages/product/page-product-top-related');
   }

   if( $product_page == 'product-detail'){
      get_template_part('pages/product/page-product-detail');
   }
   
}


$allow_tab_product_store = ['product-store', 'product-store-view'];

// TAB PRODUCT STORE
if( in_array($product_page, $allow_tab_product_store) ){

   if( is_user_logged_in() ){
      if( $product_page == 'product-store'){
         get_template_part('pages/product/page-product-store');
      }
      if( $product_page == 'product-store-view'){
         get_template_part('pages/product/page-product-store-view');
      }

   }else{
      get_template_part('pages/authentication/page-auth-store-login');
   }
}
?>

