<div id='app'>

   <div v-if='loading == false'>
      <div class='inner'>
         <div v-if='navigator == "forgot_pwd" && codeStatus == 0' class='page-appbar fixed auth'>
            <div class='on-left'>
               <button v-if='forgotPwdCheckEmailStatus == true' @click='backToForgotPwd' class='btn-back'>
                  <img width='18' src="<?php echo THEME_URI . '/assets/images/button-back.png'; ?>" alt="">
               </button>
            </div>
            <div class='on-right'>
               <button v-if='forgotPwdCheckEmailStatus == false' @click='resetForm' class='btn-back'>
                  <img widht='24' height='24' src="<?php echo THEME_URI . '/assets/images/icon-close.png'; ?>" alt="">
               </button>
            </div>
         </div>
      </div>

      <div class='container'>
         <div class='wrapper'>
            <div v-if='navigator == "login" || navigator == "register"' class='logo-brand'>
               <img src="<?php echo THEME_URI . '/assets/images/watergo_logo.png'; ?>" alt="Logo">
            </div>
            <div v-if='codeStatus == 0'>
               
               <div v-if='navigator == "login"' class='page-auth-login'>
                  <?php get_template_part('pages/user/auth-login'); ?>
               </div>

               <div v-if='navigator == "register"' class='page-auth-register'>
                  <?php get_template_part('pages/user/auth-register'); ?>
               </div>

               <div v-if='navigator == "forgot_pwd"' class='page-auth-forgot-password'>
                  <?php get_template_part('pages/user/auth-forgot-password'); ?>
               </div>

            </div>

            <div v-if='codeStatus != 0'>
               <div class='form-wrapper'>
                  <div class='badge-banner'>
                     <img src="<?php echo THEME_URI . '/assets/images/icon-check.png'; ?>" alt="Icon Check">
                     <h3>Congratulations!</h3>
                     <p v-if='codeStatus == 100'>Your Login successfully</p>
                     <p v-if='codeStatus == 102'>Your registration has been sent successfully</p>
                     <p v-if='codeStatus == 103'>Your password has been reset successfully<br>Now login with your new password</p>
                  </div>
                  <div class='group-button col-vetical'>
                     <button @click='gotoLogin' class='button'>Log In</button>
                  </div>
               </div>
            </div>

         </div>
      </div>
   </div>

   <div v-if='loading == true'>
      <div class='progress-center'>
         <div class='progress-container enabled'><progress class='progress-circular enabled' ></progress></div>
      </div>
   </div>


</div>
<script>
   const { createApp } = Vue;

   createApp({
      data() {
         return{
            isVerifyEmail: false,
            verifyLoading: false, 
            loading: false,

            // NAVIGATE PAGE
            navigator: 'login', // register | forgot_pwd | reset_pwd

            // 100 We have sent a code to your email. 
            // 101 The code does not match. 
            // 102 email already register
            isVerifyEmailStatus: 0,

            username: '',
            textErrUsername: '',

            pwd: '',
            repwd: '',
            
            email: '',
            textErrEmail: '',

            // CODE VERIFY EMAIL
            code01: '',
            code02: '',
            code03: '',
            code04: '',
            textErrCode: '',

            textErrLogin: '',

            // FOR STATUS
            // 100 login ok
            // 101 login err
            // 102 register ok
            // 103 forgot passsword ok
            codeStatus: 0,

            // forgot pwd check
            forgotPwdCheckEmailStatus: false,
            codeForgotPassword: ''
         }
      },

      methods: {
         // FUNCTION REQUEST AJAX
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

         validateEmail(email) {
            const emailRegex = /^(([^<>()[\]\\.,;:\s@\"]+(\.[^<>()[\]\\.,;:\s@\"]+)*)|(\".+\"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
            return emailRegex.test(email);
         },

         async sendCodeVerify(){
            this.code01 = '';
            this.code02 = '';
            this.code03 = '';
            this.code04 = '';

            var formSendCodeVerify = new FormData();
            formSendCodeVerify.append('action', 'atlantis_code_verification');
            formSendCodeVerify.append('event', 'send');
            formSendCodeVerify.append('email', this.email);
            var r = await this.request(formSendCodeVerify);
            if( r != undefined ){
               var res = JSON.parse( JSON.stringify( r ));
               // send ok
               if( res.err == false ) {
                  return true;
               }
               this.textErrCode = 'Verify Error';
               return false;
            }
            this.textErrCode = 'Verify Error';
            return false;
         },

         // 2step
         async verifyEmail(){
            // reset
            this.code01 = '';
            this.code02 = '';
            this.code03 = '';
            this.code04 = '';
            this.textErrEmail = '';

            if( this.email.length > 0 && this.validateEmail(this.email) == true){
               var formCheckEmail = new FormData();
               formCheckEmail.append('action', 'atlantis_check_useremail');
               formCheckEmail.append('email', this.email);
               var checkEmailRequest = await this.request(formCheckEmail);
               if( checkEmailRequest != undefined ){
                  var checkEmailRes = JSON.parse( JSON.stringify( checkEmailRequest ));
                  if( checkEmailRes.code == 100 ){
                     var sendCode = await this.sendCodeVerify();
                     if( sendCode == true ){
                        this.textErrEmail = '';
                        this.isVerifyEmail = true;
                        this.isVerifyEmailStatus = 100;
                     }else{
                        this.textErrEmail = 'Email is not invalid';
                     }
                  }else{
                     this.textErrEmail = 'Email is not invalid';
                  }
               }else{
                  this.textErrEmail = 'Email is not invalid';
               }

            }else{
               this.textErrEmail = 'Email is not invalid';
               this.isVerifyEmail = false;
            }
            
         },

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

         async loginSubmit(){
            this.loading = true;
            this.textErrLogin = '';
            var formLogin = new FormData();
            formLogin.append('action', 'atlantis_login');
            formLogin.append('username', this.username);
            formLogin.append('password', this.pwd);
            var r = await this.request(formLogin);
            if( r != undefined ){
               var res = JSON.parse( JSON.stringify( r ));
               if( res.err == false ){
                  setTimeout(function(){
                     window.location.href = '<?php echo WATERGO_HOME; ?>';
                  }, 1000);
               }else{
                  this.loading = false;
                  this.textErrLogin = 'Username or Password is not correct';
               }
            }else{
               this.loading = false;
               this.textErrLogin = 'Username or Password is not correct';
            }

         },

         async registerSubmit(){
            var code = this.code01 + this.code02 + this.code03 + this.code04;
            this.textErrUsername = '';
            this.textErrEmail = '';
            this.textErrCode = '';

            var register = new FormData();
            register.append('action', 'atlantis_register_user');
            register.append('username', this.username);
            register.append('email', this.email);
            register.append('password', this.pwd);
            register.append('code', code);
            if( this.username.length > 0 && this.email.length > 0 && code.length > 0 && this.pwd.length > 0){
               var formRequest = await this.request(register);
               if( formRequest != undefined ){
                  var res = JSON.parse( JSON.stringify( formRequest ));
                  if( res.err == false ){
                     this.codeStatus = 102;
                  }else{
                     // REGISTER ERR
                     if( res.data.username != undefined ){
                        this.textErrUsername = res.data.username;
                     }
                     if( res.data.email != undefined ){
                        this.textErrEmail = res.data.email;
                     }
                     if( res.data.code != undefined ){
                        this.textErrCode = res.data.code;
                     }
                  }
               }
               this.loading = false;
            }
         },

         async forgotpwdCheckEmail(){
            this.loading = true;

            // this.codeStatus = 103;
            var checkEmailExists = new FormData();
            checkEmailExists.append('action', 'atlantis_check_useremail');
            checkEmailExists.append('email', this.email);

            if(this.email.length > 0 && this.validateEmail(this.email) == true ){
               var r = await this.request(checkEmailExists);
               if(r != undefined ){
                  var res = JSON.parse( JSON.stringify( r ));
                  // email exist
                  if( res.code == 101 ){
                     await this.sendCodeVerify();
                     this.loading = false;
                     this.forgotPwdCheckEmailStatus = true;
                     this.codeForgotPassword = '';

                  }else{
                     this.loading = false;
                     this.codeForgotPassword = 'Email is not exists';
                  }
               }
            }else{
               this.loading = false;
               this.codeForgotPassword = 'Email is not invalid';
            }

         },

         async forgotpwdSubmit(){
            var formResetPassword = new FormData();
            formResetPassword.append('action', 'atlantis_reset_password');
            formResetPassword.append('email', this.email);
            formResetPassword.append('password', this.pwd);
            formResetPassword.append('repassword', this.repwd);
            var r = await this.request(formResetPassword);
            if(r != undefined ){
               var res = JSON.parse( JSON.stringify( r ));
               if(res.err == false ){
                  this.codeStatus = 103;
               }else{
                  // error form
                  this.code01 = '';
                  this.code02 = '';
                  this.code03 = '';
                  this.code04 = '';
               }
            }

         },
         
         resetCodeStatus(){ this.codeStatus = 0; },

         gotoRegister(){ this.resetForm(); this.resetCodeStatus(); this.navigator = 'register'; },
         gotoLogin(){ this.resetForm(); this.resetCodeStatus(); this.navigator = 'login'; },
         gotoForgotPwd(){ this.resetForm(); this.resetCodeStatus(); this.navigator = 'forgot_pwd'; },
         backToForgotPwd(){
            this.username = '';
            this.pwd = '';
            this.repwd = '';
            this.email = '';

            this.code01 = '';
            this.code02 = '';
            this.code03 = '';
            this.code04 = '';
            this.forgotPwdCheckEmailStatus = false;
         },

         resetForm(){
            this.username = '';
            this.pwd = '';
            this.repwd = '';
            this.email = '';

            this.code01 = '';
            this.code02 = '';
            this.code03 = '';
            this.code04 = '';
            this.navigator = 'login';
         }

      },

      computed: {
      }

   }).mount('#app');
</script>