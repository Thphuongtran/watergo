<div id='app'>

   <div v-if='loading == false' class='inner style01'>

      <div class='t-center mt50'>
         <img width='210' src="<?php echo THEME_URI . '/assets/images/watergo_logo.png'; ?>" alt="Login Image">
      </div>

      <div class='heading-01 t-center'><?php echo __('Sign Up', 'watergo'); ?></div>

      <div class='form-group'>
         <span><?php echo __('User name', 'watergo'); ?></span>
         <input v-model='inputUsername' type="text" placeholder='<?php echo __('Enter your username', 'watergo'); ?>'>
      </div>

      <div class='form-group'>
         <span>Email</span>
         <input v-model='inputEmail' type="email" placeholder='<?php echo __('Enter your email', 'watergo'); ?>'>
      </div>
      
      <p>
         <button @click='btn_verify_email_and_sendcode' class='btn-text' ><?php echo __('Verify your email', 'watergo'); ?>'</button>
      </p>

      <p v-if='isCodeSend' class='t-second-12'>
         <?php echo __('We have sent a code to your email.', 'watergo'); ?> <button @click='btn_verify_email_and_sendcode' class='btn-text'><?php echo __('Resend', 'watergo'); ?></button>
      </p>

      <div v-if='isCodeSend' class='box-code-verify'>
         <input id='code01' v-model='code01' maxlength='1' type="text" pattern='[0-9]*' autocomplete='off'>
         <input id='code02' v-model='code02' maxlength='1' type="text" pattern='[0-9]*' autocomplete='off'>
         <input id='code03' v-model='code03' maxlength='1' type="text" pattern='[0-9]*' autocomplete='off'>
         <input id='code04' v-model='code04' type="text" maxlength='1' pattern='[0-9]*' autocomplete='off'>
      </div>

      <div class='form-group mt10'>
         <span><?php echo __('Password', 'watergo'); ?></span>
         <input v-model='inputPassword' type="password" placeholder='<?php echo __('Enter your password', 'watergo'); ?>'>
      </div>

      <p class='t-red mt10'>
         {{ res_text_sendcode }}
      </p>

      <div class='form-group'>
         <button @click='btn_register' class='btn btn-primary'><?php echo __('Sign Up', 'watergo'); ?></button>
         <button @click='gotoLogin' class='btn btn-second mt15'><?php echo __('Log In', 'watergo'); ?></button>
      </div>

      <p class='t-second t-center mt25'><?php echo __('Or log in with', 'watergo'); ?></p>

      <div class='form-group mt20'>
         <button class='btn-icon' ref='button-signup'><img src='<?php echo THEME_URI . '/assets/images/apple-logo.png' ?>'><span class='text'><?php echo __('Log in with Apple', 'watergo'); ?></span></button>
         <button class='btn-icon' ref='button-login'><img src='<?php echo THEME_URI . '/assets/images/gg-logo.png' ?>'><span class='text'><?php echo __('Log in with Google', 'watergo'); ?></span></button>
         <button class='btn-icon' ref='button-login'><img src='<?php echo THEME_URI . '/assets/images/zalo-logo.png' ?>'><span class='text'><?php echo __('Log in with Zalo', 'watergo'); ?></span></button>
      </div>

   </div>

   <div v-if='loading == true'>
      <div class='progress-center'>
         <div class='progress-container enabled'><progress class='progress-circular enabled' ></progress></div>
      </div>
   </div>

</div>

<script>

var { createApp } = Vue;
createApp({
   data (){
      return {
         loading: false,

         inputEmail: '',
         inputUsername: '',

         inputPassword: '',
         inputRepassword: '',

         res_text_sendcode: '',

         // CODE VERIFY
         isCodeSend: false,
         code01: '',
         code02: '',
         code03: '',
         code04: '',
      }
   },

   methods: {
      gotoLogin(){window.gotoLogin()},
      gotoNotification(code){ window.gotoNotification(code)},

      moveFocus(event, nextInput){
         var input = event.target;
         var id = event.target.id;
         if (event.key === "Backspace" && !input.value && input.previousElementSibling) {
            input.previousElementSibling.focus();
         } else if (input.value && input.nextElementSibling) {
            input.nextElementSibling.focus();
         }
      },

      resetCode(){
         this.code01 = '';
         this.code02 = '';
         this.code03 = '';
         this.code04 = '';
         this.res_text_sendcode = '';
      },

      async btn_verify_email_and_sendcode(){
         this.code01 = '';
         this.code02 = '';
         this.code03 = '';
         this.code04 = '';

         if( this.inputEmail != ''){
            this.loading = true;
            var form = new FormData();
            form.append('action', 'atlantis_code_verification');
            form.append('email', this.inputEmail);
            var r = await window.request(form);
            if( r != undefined ){
               var res = JSON.parse( JSON.stringify(r));

               if( res.message == 'error_email_format' ){
                  this.res_text_sendcode = '<?php echo __("Email format error.", 'watergo'); ?>';
                  this.loading = false;
               }
               else if( res.message == 'email_already_exists' ){
                  this.res_text_sendcode = '<?php echo __("Email already register.", 'watergo'); ?>';
                  this.loading = false;
               }
               else if( res.message == 'sendcode_success' ){
                  this.res_text_sendcode = '';
                  this.isCodeSend = true;
                  this.loading = false;
               }

            }else{
               this.res_text_sendcode = '<?php echo __("Get Code Verify Error.", 'watergo'); ?>';
               this.loading = false;
            }
         }else{
            this.loading = false;
         }

         
      },

      async btn_register(){
         var code = this.code01 + this.code02 + this.code03 + this.code04;
         if( this.inputUsername != '' && this.inputEmail != '' && this.inputPassowrd != '' && code != '' ){
            this.loading = true;
            var form = new FormData();
            form.append('action', 'atlantis_register_user');
            form.append('username', this.inputUsername);
            form.append('email', this.inputEmail);
            form.append('password', this.inputPassword);
            form.append('code', code);
            var r = await window.request(form);

            if(r != undefined ){
               var res = JSON.parse( JSON.stringify(r));
               if( res.message == 'register_ok'){
                  // goto homepage
                  this.gotoNotification('register-success');
               }
               else if( res.message == 'resgiter_error' ){
                  this.res_text_sendcode = '<?php echo __("Register Error.", 'watergo'); ?>';
                  this.loading = false;
               }
            }else{
               this.res_text_sendcode = '<?php echo __("Register Error.", 'watergo'); ?>';
               this.loading = false;
            }
         }else{
            this.res_text_sendcode = '<?php echo __("Field is not empty.", 'watergo'); ?>';
            this.loading = false;
         }
      },

   }

}).mount('#app');

</script>
<script type="text/javascript">
   jQuery(document).ready(function($){
      $(document).on("keyup",".box-code-verify input",function (e) {         
         if(e.keyCode != 46 && e.keyCode != 32 && e.keyCode != 8) {
         $(this).next("input").focus();  
         }   
      });
   })
</script>