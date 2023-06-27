<div class='inner style01'>

   <div class='t-center mt50'>
      <img width='210' src="<?php echo THEME_URI . '/assets/images/watergo_logo.png'; ?>" alt="Login Image">
   </div>

   <div class='heading-01 t-center'>Log In</div>

   <div class='form-group'>
      <span>Email</span>
      <input v-model='inputEmail' type="email" placeholder='Enter your email'>
   </div>

   <div class='form-group'>
      <span>Password</span>
      <input v-model='inputPassword' type="password" placeholder='Enter your password'>
   </div>
   
   <p class='t-right'>
      <button @click='gotoPage("forget-password")' class='btn-text'>Forget Password</button>
   </p>
   
   <p class='t-red mt10'>
      {{ res_text_sendcode }}
   </p>

   <div class='form-group'>
      <button @click='btn_login' class='btn btn-primary'>Log In</button>
      <button @click='gotoPage("register")' class='btn btn-second mt15'>Sign Up</button>
   </div>

   <p class='t-second t-center mt25'>Or log in with</p>

   <div class='form-group mt20'>
      <button class='btn-icon' ref='button-signup'><img src='<?php echo THEME_URI . '/assets/images/apple-logo.png' ?>'><span class='text'>Log in with Apple</span></button>
      <button class='btn-icon' ref='button-login'><img src='<?php echo THEME_URI . '/assets/images/gg-logo.png' ?>'><span class='text'>Log in with Google</span></button>
      <button class='btn-icon' ref='button-login'><img src='<?php echo THEME_URI . '/assets/images/zalo-logo.png' ?>'><span class='text'>Log in with Zalo</span></button>
   </div>

</div>