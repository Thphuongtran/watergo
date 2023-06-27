<?php 


$nearby_page = isset($_GET['nearby_page']) ? $_GET['nearby_page'] : '';

if($nearby_page == 'nearby-store'){
   get_template_part('pages/nearby/page-nearby-store');

}
if($nearby_page == 'nearby'){
   get_template_part('pages/nearby/page-nearby');
}
