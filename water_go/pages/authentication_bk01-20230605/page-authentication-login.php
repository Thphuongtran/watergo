<?php 
/**
 * @access AUTHENTICATION
 * @role [login | register | forget password | reset password ]
 */



get_header(); ?>

<div id='app'>
   <div v-if='loading == false' class='page-authentication'>

      <!-- BANNER -->
      <div v-if='showBanner' class='banner'>
         <div class='banner-head'>
            <svg width="64" height="64" viewBox="0 0 64 64" fill="none" xmlns="http://www.w3.org/2000/svg">
               <circle cx="32" cy="32" r="32" fill="#2040AF"/>
               <path fill-rule="evenodd" clip-rule="evenodd" d="M44.7917 24.8288L42.103 22.1401L27.8578 36.3854L22.2522 30.7798L19.5635 33.4685L27.9506 41.8557L30.6393 39.167L30.5465 39.0741L44.7917 24.8288Z" fill="white"/>
            </svg>
            <h3>Congratulations!</h3>
            <p v-if='codeTextBanner == 1'>Your registration has been successful</p>
            <p v-if='codeTextBanner == 2'>
               Your password has been reset successfully <br>Now login with your new password
            </p>
         </div>

         <div class='banner-footer'>
            <button @click='gotoLogin' class='btn btn-primary'>Log In</button>
         </div>
      </div>

      <!-- PAGES -->

      <div v-if='navigator == "login" && showBanner == false' class='page-user-login'>
         <?php get_template_part('pages/authentication/user-login'); ?>
      </div>

      <div v-if='navigator == "register" && showBanner == false' class='page-user-register'>
         <?php get_template_part('pages/authentication/user-register'); ?>
      </div>

      <div v-if='navigator == "forget-password" && showBanner == false' class='page-forget-password'>
         <?php get_template_part('pages/authentication/forget-password'); ?>
      </div>

      <div v-if='navigator == "reset-password" && showBanner == false' class='page-reset-password'>
         <?php get_template_part('pages/authentication/reset-password'); ?>
      </div>

      
   </div>
   <div v-if='loading == true'>
      <div class='progress-center'>
         <div class='progress-container enabled'><progress class='progress-circular enabled' ></progress></div>
      </div>
   </div>
</div>
<script>
'use strict'; 
var { createApp } = Vue;
createApp({
   data (){
      return {
         loading: false,
         showBanner: false,
         navigator: 'login', // register | forget password | reset password | store-register

         inputEmail: '',
         inputUsername: '',

         inputPassword: '',
         inputRepassword: '',

         res_text_sendcode: '',

         // TEXT BANNER
         // 1 Your registration has been successful
         // 2 Your password has been reset successfully Now login with your new password
         codeTextBanner: 0,

         // CODE VERIFY
         isCodeSend: false,
         code01: '',
         code02: '',
         code03: '',
         code04: '',

      }
   },
   methods: {
      request( formdata ){
         var ajaxurl = "<?php echo admin_url('admin-ajax.php'); ?>";
         try{
            return axios({ method: 'post', url: ajaxurl, data: formdata
            }).then(function (res) { 
               return res.status == 200 ? res.data.data : null;
            });
         }catch(e){
            console.log(e);
            return null;
         }
      },

      // 
      resetAllInput(){
         this.code01 = '';
         this.code02 = '';
         this.code03 = '';
         this.code04 = '';
         this.inputEmail = '';
         this.inputPassword = '';
         this.inputUsername = '';
         this.inputRepassword = '';
         this.res_text_sendcode = '';
      },
      gotoPage( page ){ 
         this.navigator = page;
      },
      gotoLogin(){
         this.resetAllInput();
         this.navigator = 'login';
         this.showBanner = false;
      },
      btn_close_forget_password(){
         this.resetAllInput();
         this.navigator = 'login';
      },
      btn_close_reset_password(){
         this.resetAllInput();
         this.navigator = 'forget-password';
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
            var r = await this.request(form);
            if(r != undefined ){
               this.loading = false;
               var res = JSON.parse( JSON.stringify(r));
               if( res.message == 'register_ok'){
                  // goto homepage
                  this.codetextBanner = 1;
                  this.showBanner = true;
               }
               if( res.message == 'resgiter_error' ){
                  this.res_text_sendcode = 'Register Error.'; 
               }
            }else{
               this.loading = false;
               this.res_text_sendcode = 'Register Error.';   
            }
         }else{
            this.res_text_sendcode = 'Field is not empty.';
         }
      },

      async btn_login(){
         if( this.inputEmail != '' && this.inputPassword != '' ){
            this.loading = true;
            var form = new FormData();
            form.append('action', 'atlantis_login');
            form.append('email', this.inputEmail);
            form.append('password', this.inputPassword);
            var r = await this.request(form);
            if( r != undefined ){
               var res = JSON.parse( JSON.stringify( r ));
               if( res.message == 'login_ok' ){
                  window.location.href = '<?php echo WATERGO_HOME; ?>';
               }
               if(res.message == 'login_error' ){
                  this.res_text_sendcode = 'Login Error.';
               }
               this.loading = false;
            }else{
               this.loading = false;
               this.res_text_sendcode = 'Login Error.';   
            }
            console.log(r);
         }else{
            this.res_text_sendcode = 'Username or Password must be not empty.';
         }
         
      },

      async btn_forget_password(){
         this.code01 = '';
         this.code02 = '';
         this.code03 = '';
         this.code04 = '';

         if( this.inputEmail != ''){
            this.loading = true;
            var form = new FormData();
            form.append('action', 'atlantis_forget_password');
            form.append('email', this.inputEmail);
            var r = await this.request(form);
            if( r != undefined ){
               var res = JSON.parse( JSON.stringify(r));
               if( res.message == 'sendcode_success' ){
                  this.res_text_sendcode = '';
                  this.loading = false;
                  this.navigator = 'reset-password';
               }else{
                  this.loading = false;
                  this.res_text_sendcode = 'Get Code Verify Error.';
               }
            }else{
               this.loading = false;
               this.res_text_sendcode = 'Get Code Verify Error.';
            }
         }
      },

      async btn_reset_password(){
         var code = this.code01 + this.code02 + this.code03 + this.code04;
         if( this.inputPassword != '' && this.inputRepassword != '' ){
            this.res_text_sendcode = 'Password is not empty';
            if( this.inputPassword != this.inputRepassword ){
               this.res_text_sendcode = 'Password is not match';
            }else{
               this.loading = true;
               this.res_text_sendcode = '';
               var form = new FormData();
               form.append('action', 'atlantis_reset_password');
               form.append('email', this.inputEmail);
               form.append('password', this.inputPassword);
               form.append('repassword', this.inputRepassword);
               form.append('code', code);
               var r = await this.request(form);
               if( r != undefined ){
                  this.loading = false;
                  var res = JSON.parse( JSON.stringify(r));
                  if( res.message == 'code_is_not_correct' ){
                     this.res_text_sendcode = 'Password is not match';
                  }
                  if( res.message == 'reset_password_ok' ){
                     this.res_text_sendcode = '';
                     this.showBanner = true;
                     this.textBanner = 2;
                  }
               }
            }
         }
      },

      async btn_verify_email_and_sendcode(){
         this.code01 = '';
         this.code02 = '';
         this.code03 = '';
         this.code04 = '';

         if( this.inputEmail != ''){
            var form = new FormData();
            form.append('action', 'atlantis_code_verification');
            form.append('email', this.inputEmail);
            var r = await this.request(form);
            if( r != undefined ){
               var res = JSON.parse( JSON.stringify(r));
               if( res.message == 'error_email_format' ){
                  this.res_text_sendcode = 'Email format error.';   
               }
               if( res.message == 'email_already_exists' ){
                  this.res_text_sendcode = 'Email already register.';   
               }
               if( res.message == 'sendcode_success' ){
                  this.res_text_sendcode = '';
                  this.isCodeSend = true;
               }
               console.log(res);
            }else{
               this.res_text_sendcode = 'Get Code Verify Error.';
            }
         }
         
      },

      // async btn_sendcode(){

      // },

      // FORM
      moveFocus(event, nextInput){
         var input = event.target;
         var id = event.target.id;

         if (event.key === "Backspace" && !input.value && input.previousElementSibling) {
            input.previousElementSibling.focus();
         } else if (input.value && input.nextElementSibling) {
            input.nextElementSibling.focus();
            // if (nextInput === 'code02' && !input.value) {
            //    this.code01 = ''
            // }
            // if (nextInput === 'code03' && !input.value) {
            //    this.code02 = ''
            // }
            // if (nextInput === 'code04' && !input.value) {
            //    this.code03 = ''
            // }
         }

      },
   },


   mounted(){

   },

}).mount('#app');

</script>
<?php get_footer(); ?>