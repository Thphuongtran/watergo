<?php 

$search_page = isset($_GET['search_page']) ? $_GET['search_page'] : '';

if($search_page == 'search-index'){
   get_template_part('pages/search/search-index');
}