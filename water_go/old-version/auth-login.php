<div class='gr-heading'>
   <h3 class='heading-form'>Login</h3>
</div>

<div class='form-wrapper'>
   <div class='form-group'>
      <div class='label'>Username</div>
      <input class='input' v-model='username' type="text" placeholder='Enter your username'>
   </div>

   <div class='form-group'>
      <div class='label'>Password</div>
      <input class='input' v-model='pwd' type="password" placeholder='Enter your password'>
      <button @click='gotoForgotPwd' class='button-link text-right mb0'>Forgot Password</button>
   </div>
   <p class='text-red'>{{ textErrLogin}}</p>

   <div class='group-button col-vetical'>
      <button @click='loginSubmit' class='button' ref='button-login'>Log in</button>
      <button @click='gotoRegister' class='button-outline'>Sign Up</button>
   </div>

   <p class='ttl-01'>Or log in with</p>

   <div class='group-button col-vetical'>
      <button class='button-logo' ref='button-signup'><img src='<?php echo THEME_URI . '/assets/images/apple-logo.png' ?>'><span class='text'>Log in with Apple</span></button>
      <button class='button-logo' ref='button-login'><img src='<?php echo THEME_URI . '/assets/images/gg-logo.png' ?>'><span class='text'>Log in with Google</span></button>
      <button class='button-logo' ref='button-login'><img src='<?php echo THEME_URI . '/assets/images/zalo-logo.png' ?>'><span class='text'>Log in with Zalo</span></button>
   </div>

</div>