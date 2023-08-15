<?php 

$review_page = isset($_GET['review_page']) ? $_GET['review_page'] : '';

if( $review_page == 'review-store' ){
   get_template_part('pages/review/page-review-form');
}

if( $review_page == 'review-index' ){
   get_template_part('pages/review/review-index');
}