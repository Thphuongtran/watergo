<?php 

function atlantis_encryption( $key , $cipher_algo = 'aes-256-cbc' ){
   // Generate a random encryption key
   $encryption_key = openssl_random_pseudo_bytes(32);
   return openssl_encrypt($key, $cipher_algo, $encryption_key);
}

function atlantis_decryption( $encrypted_key, $key = '', $cipher_algo = 'aes-256-cbc' ){
   return openssl_decrypt($encrypted_key, $cipher_algo, base64_decode( $key ) );
}

// Generate a random encryption key
// $encryption_key = openssl_random_pseudo_bytes(32);

// Encrypt the user ID with the encryption key
// $encrypted_user_id = openssl_encrypt($user_id, 'aes-256-cbc', $encryption_key);

// Decrypt the user ID using the encryption key
// $user_id = openssl_decrypt($encrypted_user_id, 'aes-256-cbc', $encryption_key);
