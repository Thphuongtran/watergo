<?php 
get_header();


   $email = 'vtry.tainv11@gmail.com';

           $user_by_email_1 = get_user_by('email', $email);


           if($user_by_email_1){
            echo 'email exists';
           }else{
            echo 'email non exists';
           }



  
         
// if ($email !== '' && $email !== null) {
    $user_id = get_current_user_id();
    $current_user = wp_get_current_user();

   echo '<pre>';
   //  echo $current_user->user_email;
   echo '</pre>';

    // Check if the new email is different from the current email
    if ($email != $current_user->user_email) {
        // Check if the email already belongs to another user
        $user_by_email = get_user_by('email', $email);
        if ($user_by_email && $user_by_email->ID !== $user_id) {
            echo "Email already exists for another user.";
            // Handle the case when the email already exists for another user
            // You can redirect back to the profile page or display an error message.
        } else {
            // Update the user's email
            // wp_update_user([
            //     'ID'           => $user_id,
            //     'user_email'   => $email
            // ]);
            echo "Email updated successfully.";
        }
    } else {
        echo "Email is the same. No update needed.";
    }
// }

?>
<h1>PAGE TESTING</h1>
<?php
get_footer();