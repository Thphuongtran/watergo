<div class='gr-heading'>
   <h3 class='heading-form'>Sign Up</h3>
</div>

<div class='form-wrapper'>
   <div class='form-group'>
      <div class='label'>Username</div>
      <input class='input' v-model='username' type="text" placeholder='Enter your username'>
      <p class='text-red'>{{ textErrUsername }}</p>
   </div>

   <div class='form-group'>
      <div class='label'>Email</div>
      <input class='input' type="email" v-model='email' placeholder='Enter your email'>
      <p class='text-red'>{{ textErrEmail }}</p>
      <button class='button-link mb0' @click='verifyEmail'>Verify your email</button>
      <!-- <div class='progress-container' :class='this.verifyLoading == true ? "enabled" : "" '><progress class='progress-circular' :class='this.verifyLoading == true ? "enabled" : "" '></progress></div> -->
         
      <div class='gr-email-verify' v-if='isVerifyEmail == true'>
         <p class='ttl02' v-if='isVerifyEmailStatus == 100'>We have sent a code to your email. </p>
         <p class='ttl02' v-if='isVerifyEmailStatus == 101' >Email already register. </p>
         <button class='button-link style02 mb0' @click='verifyEmail'>Resend</button>
      </div>

   </div>

   <div v-if='this.isVerifyEmail == true' class='group-box'>
      <div class='box-input'>
         <input @focus='verifyCode' @blur='verifyCode' @input="moveFocus($event, 'code02')" @keydown.delete="moveFocus($event, 'code01')" id='code01' v-model='code01' maxlength='1' type="text" autocomplete='off'>
         <input @focus='verifyCode' @blur='verifyCode' @input="moveFocus($event, 'code03')" @keydown.delete="moveFocus($event, 'code02')" id='code02' v-model='code02' maxlength='1' type="text" autocomplete='off'>
         <input @focus='verifyCode' @blur='verifyCode' @input="moveFocus($event, 'code04')" @keydown.delete="moveFocus($event, 'code03')" id='code03' v-model='code03' maxlength='1' type="text" autocomplete='off'>
         <input @focus='verifyCode' @blur='verifyCode' @keydown.delete="moveFocus($event, 'code04')" id='code04' v-model='code04' type="text" maxlength='1' autocomplete='off'>
      </div>
   </div>
   <p class='text-red'>{{textErrCode}}</p>

   <div class='form-group'>
      <div class='label'>Password</div>
      <input class='input' v-model='pwd' type="password" placeholder='Enter your password'>
   </div>

   <div class='group-button col-vetical'>
      <button @click='this.registerSubmit' class='button' ref='button-signup'>Sign Up</button>
      <button @click='this.gotoLogin' class='button-outline'>Log In</button>
   </div>

   <p class='ttl-01'>Or log in with</p>

   <div class='group-button col-vetical'>
      <button class='button-logo' ref='button-signup'><img src='<?php echo THEME_URI . '/assets/images/apple-logo.png' ?>'><span class='text'>Log in with Apple</span></button>
      <button class='button-logo' ref='button-login'><img src='<?php echo THEME_URI . '/assets/images/gg-logo.png' ?>'><span class='text'>Log in with Google</span></button>
      <button class='button-logo' ref='button-login'><img src='<?php echo THEME_URI . '/assets/images/zalo-logo.png' ?>'><span class='text'>Log in with Zalo</span></button>
   </div>
</div>