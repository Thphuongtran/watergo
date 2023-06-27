<div id='app'>
   <div v-if='loading == false' class='page-authentication'>

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

      toggle_term_conditions(){ this.term_conditions = !this.term_conditions;},

      gotoHome(){ window.gotoHome();},
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
                     this.gotoHome();
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