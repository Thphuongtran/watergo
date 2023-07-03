<div id='app'>

   <div v-if='loading == false' class='inner style01'>

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
         <input @input="moveFocus($event, 'code02')" @keydown.delete="moveFocus($event, 'code01')" id='code01' v-model='code01' maxlength='1' type="text" pattern='[0-9]*' autocomplete='off'>
         <input @input="moveFocus($event, 'code03')" @keydown.delete="moveFocus($event, 'code02')" id='code02' v-model='code02' maxlength='1' type="text" pattern='[0-9]*' autocomplete='off'>
         <input @input="moveFocus($event, 'code04')" @keydown.delete="moveFocus($event, 'code03')" id='code03' v-model='code03' maxlength='1' type="text" pattern='[0-9]*' autocomplete='off'>
         <input @keydown.delete="moveFocus($event, 'code04')" id='code04' v-model='code04' type="text" maxlength='1' pattern='[0-9]*' autocomplete='off'>
      </div>

      <div class='form-group mt10'>
         <span>Password</span>
         <input v-model='inputPassword' type="password" placeholder='Enter your password'>
      </div>

      <div class='form-check style01 mt15'>
         <label >
            <input @click='toggle_term_conditions' :checked='term_conditions' type='checkbox' class='checkbox-login'> 
            <span class='text'> I agree with <span class='t-primary'>Terms and Conditions</span></span>
         </label>
      </div>

      <p class='t-red mt10'>
         {{ res_text_sendcode }}
      </p>

      <div class='form-group'>
         <button @click='btn_register' class='btn btn-primary'>Sign Up</button>
         <button @click='goBack' class='btn btn-second mt15'>Log In</button>
      </div>

      <p class='t-second t-center mt25'>Or log in with</p>

      <div class='form-group mt20'>
         <button class='btn-icon' ref='button-signup'><img src='<?php echo THEME_URI . '/assets/images/apple-logo.png' ?>'><span class='text'>Log in with Apple</span></button>
         <button class='btn-icon' ref='button-login'><img src='<?php echo THEME_URI . '/assets/images/gg-logo.png' ?>'><span class='text'>Log in with Google</span></button>
         <button class='btn-icon' ref='button-login'><img src='<?php echo THEME_URI . '/assets/images/zalo-logo.png' ?>'><span class='text'>Log in with Zalo</span></button>
      </div>

   </div>

   <div v-if='loading == true'>
      <div class='progress-center'>
         <div class='progress-container enabled'><progress class='progress-circular enabled' ></progress></div>
      </div>
   </div>

   <div v-if='banner_open == true' class='banner'>
      <div class='banner-head'>
         <svg width="64" height="64" viewBox="0 0 64 64" fill="none" xmlns="http://www.w3.org/2000/svg">
         <circle cx="32" cy="32" r="32" fill="#2790F9"/>
         <path fill-rule="evenodd" clip-rule="evenodd" d="M44.7917 24.8288L42.103 22.1401L27.8578 36.3854L22.2522 30.7798L19.5635 33.4685L27.9506 41.8557L30.6393 39.167L30.5465 39.0741L44.7917 24.8288Z" fill="white"/>
         </svg>
         <h3>Congratulations!</h3>
         <p>Your registration has been successful</p>
      </div>

      <div class='banner-footer'>
         <button @click='goBack' class='btn btn-outline'>Exit</button>
      </div>
   </div>

</div>

<script>

var { createApp } = Vue;
createApp({
   data (){
      return {
         loading: false,
         banner_open: false,

         inputEmail: '',
         inputUsername: '',

         inputPassword: '',
         inputRepassword: '',

         res_text_sendcode: '',

         term_conditions: false,

         // CODE VERIFY
         isCodeSend: false,
         code01: '',
         code02: '',
         code03: '',
         code04: '',
      }
   },

   methods: {
      goBack(){ window.goBack()},
      gotoNotification(code){ window.gotoNotification(code)},

      toggle_term_conditions(){ this.term_conditions = !this.term_conditions;},

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
            form.append('action', 'atlantis_send_code_verification');
            form.append('email', this.inputEmail);
            form.append('event', 'email_non_exists');
            var r = await window.request(form);
            console.log(r);
            if( r != undefined ){
               var res = JSON.parse( JSON.stringify(r));
                  this.loading = false;

               if( res.message == 'email_is_not_correct_format' ){
                  this.res_text_sendcode = 'Email is not correct format.';
               }
               else if( res.message == 'email_already_exists' ){
                  this.res_text_sendcode = 'Email already register.';
               }
               else if( res.message == 'sendcode_success' ){
                  this.res_text_sendcode = '';
                  this.isCodeSend = true;
               }

            }else{
               this.res_text_sendcode = 'Get Code Verify Error.';
               this.loading = false;
            }
         }else{
            this.loading = false;
         }

         
      },

      async btn_register(){
         var code = this.code01 + this.code02 + this.code03 + this.code04;
         if( this.inputUsername != '' && this.inputEmail != '' && this.inputPassowrd != '' ){

            if( this.term_conditions == true){
               if( code != '' ){
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
                        this.banner_open = true;
                        // this.gotoNotification('register-success');
                     }
                     else if( res.message == 'resgiter_error' ){
                        this.res_text_sendcode = 'Register Error.'; 
                        this.loading = false;
                     }
                  }else{
                     this.res_text_sendcode = 'Register Error.';   
                     this.loading = false;
                  }
               }else{
                  this.loading = false;
                  this.res_text_sendcode = 'Email is not verify.';
               }
            }else{
               this.loading = false;
               this.res_text_sendcode = 'Please agree Terms and Conditions.';
            }
         }else{
            this.loading = false;
            this.res_text_sendcode = 'All field is not empty.';
         }
      },

   }

}).mount('#app');

</script>