<?php 


$product_page = isset($_GET['product_page']) ? $_GET['product_page'] : '';

if( $product_page == 'water' ){
   get_template_part('pages/product/page-product-water');
}

if( $product_page == 'ice' ){
   get_template_part('pages/product/page-product-ice');
}

if( $product_page == 'product-detail'){
   get_template_part('pages/product/page-product-detail');
}

if( $product_page == 'recommend' ){
   get_template_part('pages/product/page-product-recommend');
}

if( $product_page == 'top-products' ){
   get_template_part('pages/product/page-product-top-related');
}

if( $product_page == 'top-products' ){
   get_template_part('pages/product/page-product-top-related');
}

// TAB PRODUCT STORE
if(is_user_logged_in() ){

   if( $product_page == 'product-store'){
      get_template_part('pages/product/page-product-store');
   }

}else{
   get_template_part('pages/authentication/page-auth-store-login');
}

?>

