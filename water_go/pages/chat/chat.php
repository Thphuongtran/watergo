<?php 

$chat_page = isset($_GET['chat_page']) ? $_GET['chat_page'] : '';

if( $chat_page == 'chat-index'){
   get_template_part('pages/chat/chat-index');
}

if( $chat_page == 'chat-messenger'){
   get_template_part('pages/chat/chat-messenger');
}