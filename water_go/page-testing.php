<?php 
get_header();



$res = func_atlantis_get_images(64, 'product', 1);
echo '<pre>';
print_r($res);
echo '</pre>';
?>
<h1>PAGE TESTING</h1>
<?php
get_footer();