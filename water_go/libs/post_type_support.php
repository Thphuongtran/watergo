<?php

/**
 * @access THIS IS CUSTOM POST SUPPORT FOR ADMIN
 */

$post_type_admin_support = tr_post_type('Admin Support');


$post_type_admin_support = tr_meta_box('Post Details');

// PAGE PARENT 
$admin_support_all = tr_page('Admin Support All', 'index', '', ['capability' => 'administrator'] , function(){
   
});
// $admin_support_all->
// $post_type_admin_support->addScreen('post');
// $post_type_admin_support->setCallback(function(){
//     $form = tr_form();
//     echo $form->image('Banner Image');
//     echo $form->text('Subheading');
// });