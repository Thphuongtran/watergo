<div class='inner style01'>

   <div class='t-center mt50'>
      <img width='210' src="<?php echo THEME_URI . '/assets/images/watergo_logo.png'; ?>" alt="Login Image">
   </div>

   <div class='heading-01 t-center'>Sign Up</div>

   <div class='form-group'>
      <span>User name</span>
      <input v-model='inputUsername' type="text" placeholder='Enter your username'>
   </div>

   <div class='form-group'>
      <span>Email</span>
      <input v-model='inputEmail' type="email" placeholder='Enter your email'>
   </div>
   
   <p>
      <button @click='btn_verify_email_and_sendcode' class='btn-text' >Verify your email</button>
   </p>
   <p v-if='isCodeSend' class='t-second-12'>
      We have sent a code to your email. <button @click='btn_verify_email_and_sendcode' class='btn-text'>Resend</button>
   </p>

   <div v-if='isCodeSend' class='box-code-verify'>
      <input @input="moveFocus($event, 'code02')" @keydown.delete="moveFocus($event, 'code01')" id='code01' v-model='code01' maxlength='1' type="text" autocomplete='off'>
      <input @input="moveFocus($event, 'code03')" @keydown.delete="moveFocus($event, 'code02')" id='code02' v-model='code02' maxlength='1' type="text" autocomplete='off'>
      <input @input="moveFocus($event, 'code04')" @keydown.delete="moveFocus($event, 'code03')" id='code03' v-model='code03' maxlength='1' type="text" autocomplete='off'>
      <input @keydown.delete="moveFocus($event, 'code04')" id='code04' v-model='code04' type="text" maxlength='1' autocomplete='off'>
   </div>

   <div class='form-group mt10'>
      <span>Password</span>
      <input v-model='inputPassword' type="password" placeholder='Enter your password'>
   </div>

   <p class='t-red mt10'>
      {{ res_text_sendcode }}
   </p>

   <div class='form-group'>
      <button @click='btn_register' class='btn btn-primary'>Sign Up</button>
      <button @click='gotoPage("login")' class='btn btn-second mt15'>Log In</button>
   </div>

   <p class='t-second t-center mt25'>Or log in with</p>

   <div class='form-group mt20'>
      <button class='btn-icon' ref='button-signup'><img src='<?php echo THEME_URI . '/assets/images/apple-logo.png' ?>'><span class='text'>Log in with Apple</span></button>
      <button class='btn-icon' ref='button-login'><img src='<?php echo THEME_URI . '/assets/images/gg-logo.png' ?>'><span class='text'>Log in with Google</span></button>
      <button class='btn-icon' ref='button-login'><img src='<?php echo THEME_URI . '/assets/images/zalo-logo.png' ?>'><span class='text'>Log in with Zalo</span></button>
   </div>

</div>