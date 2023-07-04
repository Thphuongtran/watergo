<div id='app'>

   <div v-if='page_welcome == true' class='banner page-welcome'>
      <div class='banner-head'>
         <h3>WELCOME !</h3>
         <p>Please login to explode more</p>

         <div class='t-center mt30 mb30'>
            <img src="<?php echo THEME_URI . '/assets/images/logo-vertical.png'; ?>">
         </div>

      </div>

      <div class='banner-footer'>
         <button @click='gotoLogin' class='btn btn-primary'>Login</button>
      </div>
   </div>

   <div v-if='loading == false' class='page-authentication'>

      <div class='appbar'>
         <div class='appbar-top'>
            <div class='leading'>
               <button @click='goBack' class='btn-action'>
                  <svg width="20" height="16" viewBox="0 0 20 16" fill="none" xmlns="http://www.w3.org/2000/svg">
                  <path fill-rule="evenodd" clip-rule="evenodd" d="M0 8C0 7.44772 0.447715 7 1 7H18.5C19.0523 7 19.5 7.44772 19.5 8C19.5 8.55228 19.0523 9 18.5 9H1C0.447715 9 0 8.55228 0 8Z" fill="#252831"/>
                  <path fill-rule="evenodd" clip-rule="evenodd" d="M10.5309 0.375342C10.8759 0.806604 10.806 1.4359 10.3747 1.78091L2.60078 8.00004L10.3747 14.2192C10.806 14.5642 10.8759 15.1935 10.5309 15.6247C10.1859 16.056 9.55657 16.1259 9.12531 15.7809L0.375305 8.78091C0.13809 8.59113 0 8.30382 0 8.00004C0 7.69625 0.13809 7.40894 0.375305 7.21917L9.12531 0.219168C9.55657 -0.125842 10.1859 -0.0559202 10.5309 0.375342Z" fill="#252831"/>
                  </svg>
               </button>

            </div>
            <div class='action'></div>
         </div>
      </div>

      <div class='inner style01'>


         <div class='t-center'>
            <img class='login-align' width='210' src="<?php echo THEME_URI . '/assets/images/watergo_logo.png'; ?>" alt="Login Image">
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
            <button @click='gotoAuthForgetPassword' class='btn-text'>Forget Password</button>
         </p>
         
         <p class='t-red mt10'>
            {{ res_text_sendcode }}
         </p>

         <div class='form-check style01'>
            <label >
               <input @click='toggle_term_conditions' :checked='term_conditions' type='checkbox' class='checkbox-login'> 
               <span class='text'> I agree with <span class='t-primary'>Terms and Conditions</span></span>
            </label>
         </div>

         <div class='form-group'>
            <button @click='btn_login' class='btn btn-primary'>Log In</button>
            <button @click='gotoAuthRegister' class='btn btn-second mt15'>Sign Up</button>
         </div>


         <p class='t-second t-center mt25'>Or log in with</p>

         <div class='form-group mt20'>
            <button @click='login_social_apple' class='btn-icon'><img src='<?php echo THEME_URI . '/assets/images/apple-logo.png' ?>'><span class='text'>Log in with Apple</span></button>
            <button @click='login_social_google' class='btn-icon'><img src='<?php echo THEME_URI . '/assets/images/gg-logo.png' ?>'><span class='text'>Log in with Google</span></button>
            <button @click='login_social_zalo' class='btn-icon'><img src='<?php echo THEME_URI . '/assets/images/zalo-logo.png' ?>'><span class='text'>Log in with Zalo</span></button>
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
var { createApp } = Vue;
createApp({
   data (){

      return {
         loading: false,
         inputEmail: '',
         inputPassword: '',
         res_text_sendcode: '',
         term_conditions: false,
         
         page_welcome: true,

      }
   },
   
   methods: {
      
      login_social_apple(){
         try{ window.appBridge.socialLogin('A'); // google
         }catch{}
      },
      login_social_google(){
         try{ window.appBridge.socialLogin('G'); // google
         }catch{}
      },
      login_social_zalo(){
         try{ window.appBridge.socialLogin('Z'); // google
         }catch{}
      },

      goBack(){this.page_welcome = true;},
      gotoLogin(){
         this.page_welcome = false;
      },

      toggle_term_conditions(){ this.term_conditions = !this.term_conditions;},

      gotoAuthForgetPassword(){ window.gotoAuthForgetPassword()},
      gotoAuthRegister(){ window.gotoAuthRegister()},

      async btn_login(){
         if( this.inputEmail != '' && this.inputPassword != ''){
            if( this.term_conditions == true){
               this.loading = true;
               var form = new FormData();
               form.append('action', 'atlantis_login');
               form.append('email', this.inputEmail);
               form.append('password', this.inputPassword);
               var r = await window.request(form);

               if( r != undefined ){
                  var res = JSON.parse( JSON.stringify( r ));
                  if( res.message == 'login_ok' ){

                     var _cookie = 'email:' + this.inputEmail;

                     if( window.appBridge != undefined ){
                        window.appBridge.loginSuccess(_cookie);
                        window.appBridge.refresh();
                     }
                  }
                  else if(res.message == 'login_error' ){
                     this.res_text_sendcode = 'Login Error.';
                     this.loading = false;
                  }else{
                     this.loading = false;
                  }
               }else{
                  this.loading = false;
                  this.res_text_sendcode = 'Login Error.';   
               }
            }else{
               this.loading = false;
               this.res_text_sendcode = 'Please agree Terms and Conditions.';
            }
         }else{
            this.loading = false;
            this.res_text_sendcode = 'Username or Password must be not empty.';
         }
         
      },


      moveFocus(event, nextInput){
         var input = event.target;
         var id = event.target.id;

         if (event.key === "Backspace" && !input.value && input.previousElementSibling) {
            input.previousElementSibling.focus();
         } else if (input.value && input.nextElementSibling) {
            input.nextElementSibling.focus();
         }

      },
   },

}).mount('#app');

</script>