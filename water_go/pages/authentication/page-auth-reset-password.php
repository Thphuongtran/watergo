<div id='app'>
   <div v-if='loading == false' class='page-auth-reset-password'>

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

      <div class='inner'>
         <div class='heading-01 t-center mt100'><?php echo __('Reset your password', 'watergo'); ?></div>
         <p class='t-center'><?php echo __('We have sent a code to your email', 'watergo'); ?></p>

         <div class='box-code-verify'>
            <input id='code01' v-model='code01' maxlength='1' type="text" pattern='[0-9]*' autocomplete='off'>
            <input id='code02' v-model='code02' maxlength='1' type="text" pattern='[0-9]*' autocomplete='off'>
            <input id='code03' v-model='code03' maxlength='1' type="text" pattern='[0-9]*' autocomplete='off'>
            <input id='code04' v-model='code04' type="text" maxlength='1' pattern='[0-9]*' autocomplete='off'>
         </div>
         <p class='t-center'>
            <button @click='btn_resend' class='btn-text'><?php echo __('Resend', 'watergo'); ?></button>
         </p>

         <div class='form-group'>
            <span><?php echo __('New Password', 'watergo'); ?></span>
            <input v-model='inputPassword' type="password" placeholder='<?php echo __('Enter password', 'watergo'); ?>'>
         </div>

         <div class='form-group'>
            <span><?php echo __('Confirm New Password', 'watergo'); ?></span>
            <input v-model='inputRepassword' type="password" placeholder='<?php echo __('Enter password', 'watergo'); ?> '>
         </div>

         <p class='t-red mt10'>
            {{ res_text_sendcode }}
         </p>

         <div class='form-group'>
            <button @click='btn_reset_password' class='btn btn-primary'><?php echo __('Submit', 'watergo'); ?></button>
         </div>


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
         <h3><?php echo __('Password Changed', 'watergo'); ?></h3>
         <p><?php echo __('Your password has been changed successfully', 'watetgo'); ?></p>
      </div>

      <div class='banner-footer'>
         <button @click='goBack' class='btn btn-outline'><?php echo __('Exit', 'watergo'); ?></button>
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
         
         res_text_sendcode: '',

         inputPassword: '',
         inputRepassword: '',

         inputEmail: '',

         code01: '',
         code02: '',
         code03: '',
         code04: '',

      }
   },
   methods: {
      goBack(){window.goBack()},

      async btn_resend(){
         this.loading = true;
         this.code01 = '';
         this.code02 = '';
         this.code03 = '';
         this.code04 = '';

         var form = new FormData();
         form.append('action', 'atlantis_code_verification');
         form.append('email', this.inputEmail);
         var r = await window.request(form);
         if( r != undefined ){
            var res = JSON.parse( JSON.stringify(r));
            if( res.message == 'email_already_exists' ){
               this.res_text_sendcode = '<?php echo __("Email already register.", 'watergo'); ?>';
            }
            else if( res.message == 'sendcode_success' ){
               this.res_text_sendcode = '';
            }
         }else{
            this.res_text_sendcode = '<?php echo __("Get Code Verify Error.", 'watergo'); ?>';
         }
         this.loading = false;
         
      },

      async btn_reset_password(){
         var code = this.code01 + this.code02 + this.code03 + this.code04;
         if( this.inputPassword != '' && this.inputRepassword != '' ){
            this.res_text_sendcode = '<?php echo __("Password is not empty", 'watergo'); ?>';
            if( this.inputPassword != this.inputRepassword ){
               this.res_text_sendcode = '<?php echo __("Password is not match", 'watergo'); ?>';
            }else{
               this.loading = true;
               this.res_text_sendcode = '';
               var form = new FormData();
               form.append('action', 'atlantis_reset_password');
               form.append('email', this.inputEmail);
               form.append('password', this.inputPassword);
               form.append('repassword', this.inputRepassword);
               form.append('code', code);
               var r = await window.request(form);
               if( r != undefined ){
                  this.loading = false;
                  var res = JSON.parse( JSON.stringify(r));
                  if( res.message == 'code_is_not_correct' ){
                     this.res_text_sendcode = '<?php echo __("Password is not match", 'watergo'); ?>';
                  }
                  if( res.message == 'reset_password_ok' ){
                     this.banner_open = true;
                  }
               }
            }
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


   created(){
      const urlParams = new URLSearchParams(window.location.search);
      this.inputEmail = urlParams.get('email');   


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