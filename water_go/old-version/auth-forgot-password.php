<div v-if='forgotPwdCheckEmailStatus == false'>

   <div class='gr-heading'>
      <h3 class='heading-form'>Forgot Password?</h3>
      <p class='text-center'>Don’t worry when it happens<br>Reset your password</p>
   </div>

   <div class='form-wrapper'>
      <div class='form-group'>
         <div class='label'>Email</div>
         <input class='input' v-model='email' type="email" placeholder='Enter your email'>
         <p class='text-red'>{{ codeForgotPassword }}</p>
      </div>
      <div class='group-button col-vetical'>
         <button @click='forgotpwdCheckEmail' class='button' ref='button-login'>Submit</button>
      </div>
   </div>

</div>

<div v-if='forgotPwdCheckEmailStatus == true'>

   <div class='gr-heading'>
      <h3 class='heading-form'>Reset your password</h3>
      <p class='text-center'>We have sent a code to your email</p>
   </div>

   <div class='form-wrapper'>

      <div class='box-input' ref='box-verify'>
         <input @focus='verifyCode' @blur='verifyCode' @input="moveFocus($event, 'code02')" @keydown.delete="moveFocus($event, 'code01')" id='code01' v-model='code01' maxlength='1' type="text" autocomplete='off'>
         <input @focus='verifyCode' @blur='verifyCode' @input="moveFocus($event, 'code03')" @keydown.delete="moveFocus($event, 'code02')" id='code02' v-model='code02' maxlength='1' type="text" autocomplete='off'>
         <input @focus='verifyCode' @blur='verifyCode' @input="moveFocus($event, 'code04')" @keydown.delete="moveFocus($event, 'code03')" id='code03' v-model='code03' maxlength='1' type="text" autocomplete='off'>
         <input @focus='verifyCode' @blur='verifyCode' @keydown.delete="moveFocus($event, 'code04')" id='code04' v-model='code04' type="text" maxlength='1' autocomplete='off'>
      </div>

      <div class='group-button col-vetical'>
         <button @click='sendCodeVerify' class='button-link text-center'>Resend</button>
      </div>

      <div class='form-group'>
         <div class='label'>Password</div>
         <input class='input' v-model='pwd' type="password" placeholder='Enter password'>
      </div>

      <div class='form-group'>
         <div class='label'>Confirm New Password</div>
         <input class='input' v-model='repwd' type="password" placeholder='Enter password'>
      </div>

      <div class='group-button col-vetical'>
         <button @click='forgotpwdSubmit' class='button' ref='button-login'>Submit</button>
      </div>

   </div>
</div>
