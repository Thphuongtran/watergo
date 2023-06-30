<?php

$code = isset($_GET['code']) ? $_GET['code'] : '';

$notificatio_page = isset($_GET['page_notification']) ? $_GET['page_notification']: '';

if( $notificatio_page == 'notification-index' ){
   get_template_part('pages/notification/notification-index');
}

if( $notificatio_page == 'notification' ){
 
if($code == 'order-success'){ 
?>
<div class='banner'>
   <div class='banner-head'>
      <svg width="64" height="64" viewBox="0 0 64 64" fill="none" xmlns="http://www.w3.org/2000/svg">
      <circle cx="32" cy="32" r="32" fill="#2790F9"/>
      <path fill-rule="evenodd" clip-rule="evenodd" d="M44.7917 24.8288L42.103 22.1401L27.8578 36.3854L22.2522 30.7798L19.5635 33.4685L27.9506 41.8557L30.6393 39.167L30.5465 39.0741L44.7917 24.8288Z" fill="white"/>
      </svg>

      <h3>Order Successfully</h3>
   </div>

   <div class='banner-footer'>
      <a href='<?php echo WATERGO_BACK; ?>' class='btn btn-outline'>Exit</a>
   </div>
</div>
<?php } ?>

<?php if($code == 'review-success'){ ?>
<div class='banner'>
   <div class='banner-head'>
      <svg width="130" height="130" viewBox="0 0 130 130" fill="none" xmlns="http://www.w3.org/2000/svg">
      <circle cx="65" cy="65" r="65" fill="#E9E9E9"/>
      <g filter="url(#filter0_d_780_2507)">
      <path d="M48.2256 70.5944C48.2256 72.3887 48.9385 74.1096 50.2073 75.3784C51.4761 76.6473 53.197 77.3601 54.9914 77.3601H95.5857L109.117 90.8915V36.7657C109.117 34.9713 108.404 33.2505 107.136 31.9816C105.867 30.7128 104.146 30 102.351 30H54.9914C53.197 30 51.4761 30.7128 50.2073 31.9816C48.9385 33.2505 48.2256 34.9713 48.2256 36.7657V70.5944Z" fill="#2790F9" stroke="#2790F9" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
      </g>
      <path d="M80.8915 79.7028C80.8915 81.4971 80.1787 83.218 78.9099 84.4868C77.6411 85.7557 75.9202 86.4685 74.1258 86.4685H33.5315L20 99.9999V45.8741C20 44.0797 20.7128 42.3589 21.9816 41.09C23.2505 39.8212 24.9713 39.1084 26.7657 39.1084H74.1258C75.9202 39.1084 77.6411 39.8212 78.9099 41.09C80.1787 42.3589 80.8915 44.0797 80.8915 45.8741V79.7028Z" fill="white" stroke="#2790F9" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
      <circle cx="38.1872" cy="62.883" r="2.85127" fill="#2790F9"/>
      <circle cx="49.9147" cy="62.883" r="2.85127" fill="#2790F9"/>
      <circle cx="61.6413" cy="62.883" r="2.85127" fill="#2790F9"/>
      <defs>
      <filter id="filter0_d_780_2507" x="39.2256" y="25" width="78.8916" height="78.8916" filterUnits="userSpaceOnUse" color-interpolation-filters="sRGB">
      <feFlood flood-opacity="0" result="BackgroundImageFix"/>
      <feColorMatrix in="SourceAlpha" type="matrix" values="0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 127 0" result="hardAlpha"/>
      <feOffset dy="4"/>
      <feGaussianBlur stdDeviation="4"/>
      <feComposite in2="hardAlpha" operator="out"/>
      <feColorMatrix type="matrix" values="0 0 0 0 1 0 0 0 0 1 0 0 0 0 1 0 0 0 0.25 0"/>
      <feBlend mode="normal" in2="BackgroundImageFix" result="effect1_dropShadow_780_2507"/>
      <feBlend mode="normal" in="SourceGraphic" in2="effect1_dropShadow_780_2507" result="shape"/>
      </filter>
      </defs>
      </svg>
      <h3>Review Successfully</h3>
   </div>

   <div class='banner-footer'>
      <a href='<?php echo WATERGO_BACK; ?>' class='btn btn-outline'>Exit</a>
   </div>
</div>
<?php } ?>

<?php if( $code == 'change-password-success'){ ?>
<div class='banner'>
   <div class='banner-head'>
      <svg width="64" height="64" viewBox="0 0 64 64" fill="none" xmlns="http://www.w3.org/2000/svg">
      <circle cx="32" cy="32" r="32" fill="#2790F9"/>
      <path fill-rule="evenodd" clip-rule="evenodd" d="M44.7917 24.8288L42.103 22.1401L27.8578 36.3854L22.2522 30.7798L19.5635 33.4685L27.9506 41.8557L30.6393 39.167L30.5465 39.0741L44.7917 24.8288Z" fill="white"/>
      </svg>
      <h3>Password Changed</h3>
      <p>Your password has been changed successfully</p>
   </div>

   <div class='banner-footer'>
      <a href='<?php echo get_bloginfo('url'); ?>/user?user_page=user-profile' class='btn btn-outline'>Exit</a>
   </div>
</div>

<?php // } ?>

<?php //if( $code == 'register-success'){ ?>
<div class='banner'>
   <div class='banner-head'>
      <svg width="64" height="64" viewBox="0 0 64 64" fill="none" xmlns="http://www.w3.org/2000/svg">
      <circle cx="32" cy="32" r="32" fill="#2790F9"/>
      <path fill-rule="evenodd" clip-rule="evenodd" d="M44.7917 24.8288L42.103 22.1401L27.8578 36.3854L22.2522 30.7798L19.5635 33.4685L27.9506 41.8557L30.6393 39.167L30.5465 39.0741L44.7917 24.8288Z" fill="white"/>
      </svg>
      <h3>Congratulations!</h3>
      <p>Your registration has been successful</p>
   </div>

   <div class='banner-footer'>
      <a href='<?php echo get_bloginfo('url'); ?>/authentication?auth_page=auth-login' class='btn btn-outline'>Exit</a>
   </div>
</div>

<?php } ?>

<?php if( $code == 'reset-password-success'){ ?>
<div class='banner'>
   <div class='banner-head'>
      <svg width="64" height="64" viewBox="0 0 64 64" fill="none" xmlns="http://www.w3.org/2000/svg">
      <circle cx="32" cy="32" r="32" fill="#2790F9"/>
      <path fill-rule="evenodd" clip-rule="evenodd" d="M44.7917 24.8288L42.103 22.1401L27.8578 36.3854L22.2522 30.7798L19.5635 33.4685L27.9506 41.8557L30.6393 39.167L30.5465 39.0741L44.7917 24.8288Z" fill="white"/>
      </svg>

      <h3>Congratulations!</h3>
      <p>Your password has been reset successfully<br>Now login with your new password</p>
   </div>

   <div class='banner-footer'>
      <a href='<?php echo get_bloginfo('url'); ?>/authentication?auth_page=auth-login' class='btn btn-outline'>Exit</a>
   </div>
</div>

<?php } ?>

<?php } // ?>


