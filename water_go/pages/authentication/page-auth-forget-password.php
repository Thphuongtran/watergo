<style>
   .appbar{
      height: 56px;
   }
   .scaffold{
      height: calc( 100vh - 70px);
      margin-top: 70px;
      overflow-y: scroll;
      overflow-x: hidden;
      padding-bottom: 30px;
   }
</style>
<div id='authentication'>

   <!-- THIS IS STEP PAGE -->
   <div v-if='loading == true'>
      <div class='progress-center'>
         <div class='progress-container enabled'><progress class='progress-circular enabled' ></progress></div>
      </div>
   </div>

   <!-- STEP 0  -->
   <div v-if='step_page == 0 && loading == false' class='page-step'>
      <div class='page-auth-forget-password'>

         <div class='appbar fixed'>
            <div class='appbar-top'>
               <div class='leading'>

               </div>
               <div class='action'>
                  <button @click='goBack' class='btn-action mr0'>
                     <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M18 6L6 18" stroke="black" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                        <path d="M6 6L18 18" stroke="black" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                     </svg>
                  </button>
               </div>
            </div>
         </div>
         
         <div class='scaffold'>
            <div class='inner'>
               <div class='heading-01 t-center mt100'><?php echo __('Forgot Password','watergo'); ?>?</div>
               <p class='t-center'><?php echo __("Don’t worry when it happens <br> Reset your password", 'watergo'); ?></p>

               <div class='form-group'>
                  <span><?php echo __('Email', 'watergo'); ?></span>
                  <input v-model='inputEmail' type="email" placeholder='<?php echo __('Enter your email', 'watergo'); ?>'>
               </div>

               <p class='t-red mt10'>
                  {{ res_text_sendcode }}
               </p>

               <div class='form-group'>
                  <button @click='btn_forget_password' class='btn btn-primary'><?php echo __('Submit', 'watergo'); ?></button>
               </div>


            </div>
         </div>
      </div>
   </div>

   <!-- STEP 2  -->
   <div v-if='step_page == 1 && loading == false' class='page-step'>
      <div class='page-auth-reset-password'>

         <div class='appbar fixed'>
            <div class='appbar-top'>
               <div class='leading'>
                  <button @click='goBackStep' class='btn-action'>
                     <svg width="20" height="16" viewBox="0 0 20 16" fill="none" xmlns="http://www.w3.org/2000/svg">
                     <path fill-rule="evenodd" clip-rule="evenodd" d="M0 8C0 7.44772 0.447715 7 1 7H18.5C19.0523 7 19.5 7.44772 19.5 8C19.5 8.55228 19.0523 9 18.5 9H1C0.447715 9 0 8.55228 0 8Z" fill="#252831"/>
                     <path fill-rule="evenodd" clip-rule="evenodd" d="M10.5309 0.375342C10.8759 0.806604 10.806 1.4359 10.3747 1.78091L2.60078 8.00004L10.3747 14.2192C10.806 14.5642 10.8759 15.1935 10.5309 15.6247C10.1859 16.056 9.55657 16.1259 9.12531 15.7809L0.375305 8.78091C0.13809 8.59113 0 8.30382 0 8.00004C0 7.69625 0.13809 7.40894 0.375305 7.21917L9.12531 0.219168C9.55657 -0.125842 10.1859 -0.0559202 10.5309 0.375342Z" fill="#252831"/>
                     </svg>
                  </button>

               </div>
               <div class='action'></div>
            </div>
         </div>
         <div class='scaffold'>
            <div class='inner'>
               <div class='heading-01 t-center mt100'><?php echo __('Reset your password', 'watergo'); ?></div>
               <p class='t-center'><?php echo __('We have sent a code to your email', 'watergo'); ?></p>
               
               <!-- 
               <div class='box-code-verify'>
                  <input @input="moveFocus($event, 'code02')" @keydown.delete="moveFocus($event, 'code01')" id='code01' v-model='code01' maxlength='1' type="text" pattern='[0-9]*' autocomplete='off'>
                  <input @input="moveFocus($event, 'code03')" @keydown.delete="moveFocus($event, 'code02')" id='code02' v-model='code02' maxlength='1' type="text" pattern='[0-9]*' autocomplete='off'>
                  <input @input="moveFocus($event, 'code04')" @keydown.delete="moveFocus($event, 'code03')" id='code03' v-model='code03' maxlength='1' type="text" pattern='[0-9]*' autocomplete='off'>
                  <input @keydown.delete="moveFocus($event, 'code04')" id='code04' v-model='code04' type="text" maxlength='1' pattern='[0-9]*' autocomplete='off'>
               </div>
               -->
               <div class="box-code-verify">
                  <!-- <input @input="moveFocus($event, 'code01')" @keydown.delete="moveFocus($event, 'code01')" id='code01' ref="code01" v-model="code01" maxlength="1" type="text" pattern="[0-9]*" autocomplete="off">
                  <input @input="moveFocus($event, 'code02')" @keydown.delete="moveFocus($event, 'code02')" @keydown.backspace="moveFocusBack($event, 'code01')" id='code02' ref="code02" v-model="code02" maxlength="1" type="text" pattern="[0-9]*" autocomplete="off">
                  <input @input="moveFocus($event, 'code03')" @keydown.delete="moveFocus($event, 'code03')" @keydown.backspace="moveFocusBack($event, 'code02')" id='code03' ref="code03" v-model="code03" maxlength="1" type="text" pattern="[0-9]*" autocomplete="off">
                  <input @keydown.delete="moveFocus($event, 'code04')" @keydown.backspace="moveFocusBack($event, 'code03')" ref="code04" v-model="code04" id='code04' type="text" maxlength="1" pattern="[0-9]*" autocomplete="off"> -->

                  <!-- <input @input="moveFocus($event, 'code02', 'code01')" @keydown.delete="moveFocus($event, 'code01', 'code01')" id='code01' ref="code01" v-model="code01" maxlength="1" type="text" pattern="[0-9]*" autocomplete="off">
                  <input @input="moveFocus($event, 'code03', 'code02')" @keydown.delete="moveFocus($event, 'code02', 'code02')" @keydown.backspace="moveFocusBack($event, 'code01')" id='code02' ref="code02" v-model="code02" maxlength="1" type="text" pattern="[0-9]*" autocomplete="off">
                  <input @input="moveFocus($event, 'code04', 'code03')" @keydown.delete="moveFocus($event, 'code03', 'code03')" @keydown.backspace="moveFocusBack($event, 'code02')" id='code03' ref="code03" v-model="code03" maxlength="1" type="text" pattern="[0-9]*" autocomplete="off">
                  <input @keydown.delete="moveFocus($event, 'code04', 'code04')" @keydown.backspace="moveFocusBack($event, 'code03')" ref="code04" v-model="code04" id='code04' type="text" maxlength="1" pattern="[0-9]*" autocomplete="off"> -->

                  <input id='code01' ref="code01" v-model="code01" maxlength="1" type="text" pattern="[0-9]*" autocomplete="off">
                  <input id='code02' ref="code02" v-model="code02" maxlength="1" type="text" pattern="[0-9]*" autocomplete="off">
                  <input id='code03' ref="code03" v-model="code03" maxlength="1" type="text" pattern="[0-9]*" autocomplete="off">
                  <input ref="code04" v-model='code04' id='code04' type="text" maxlength="1" pattern="[0-9]*" autocomplete="off">

                  <!-- <input @input='codeInput($event)' @keydown.delete='codeInput($event)' id='code01' data-id='1' ref="code01" v-model="code01" maxlength="1" type="text" pattern="[0-9]*" autocomplete="off">
                  <input @input='codeInput($event)' @keydown.delete='codeInput($event)' id='code02' data-id='2' ref="code02" v-model="code02" maxlength="1" type="text" pattern="[0-9]*" autocomplete="off">
                  <input @input='codeInput($event)' @keydown.delete='codeInput($event)' id='code03' data-id='3' ref="code03" v-model="code03" maxlength="1" type="text" pattern="[0-9]*" autocomplete="off">
                  <input @input='codeInput($event)' @keydown.delete='codeInput($event)' id='code04' data-id='4' ref="code04" v-model="code04" maxlength="1" type="text" pattern="[0-9]*" autocomplete="off"> -->


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
                  <button @click='btn_reset_password' class='btn btn-primary'><?php echo __('Submit', 'watergo'); ?> </button>
               </div>


            </div>
         </div>
      </div>
   </div>

   <!-- BANNER -->
   <div v-if='banner_open == true' class='banner banner-change-password'>
      <div class='banner-head'>
         <svg width="64" height="64" viewBox="0 0 64 64" fill="none" xmlns="http://www.w3.org/2000/svg">
         <circle cx="32" cy="32" r="32" fill="#2790F9"/>
         <path fill-rule="evenodd" clip-rule="evenodd" d="M44.7917 24.8288L42.103 22.1401L27.8578 36.3854L22.2522 30.7798L19.5635 33.4685L27.9506 41.8557L30.6393 39.167L30.5465 39.0741L44.7917 24.8288Z" fill="white"/>
         </svg>

         <h3 class="pb10"><?php echo __('Congratulations', 'watergo');?>!</h3>
         <p><?php echo __('Your password has been reset successfully<br>Now login with your new password', 'watergo'); ?></p>
      </div>

      <div class='banner-footer'>
         <button @click='goBack' class='btn btn-primary'><?php echo __('Log In', 'watergo'); ?></button>
      </div>
   </div>




</div>

<script>

if( window.appBridge != undefined ){
   window.appBridge.setEnableScroll(false);
}

var { createApp } = Vue;
createApp({
   data (){
      return {
         loading: false,
         banner_open: false,

         // 0 => forget-password
         // 1 => reset-password
         step_page: 0,

         res_text_sendcode: '',
         inputEmail: '',
         inputPassword: '',
         inputRepassword: '',

         code01: '',
         code02: '',
         code03: '',
         code04: '',

      }
   },


   methods: {

      goBack(){ window.goBack()},

      goBackStep(){
         this.res_text_sendcode = '';
         this.step_page = 0;
      },

      // FOR STEP 0
      async btn_forget_password(){

         if( this.inputEmail != ''){
            this.loading = true;
            var form = new FormData();
            form.append('action', 'atlantis_forget_password');
            form.append('email', this.inputEmail);
            var r = await window.request(form);

            if( r != undefined ){
               var res = JSON.parse( JSON.stringify(r));

               if( res.message == 'sendcode_success' ){
                  this.res_text_sendcode = '';
                  // done
                  this.loading = false;
                  this.step_page = 1;

               } else if( res.message == 'email_is_not_correct_format' ){
                  this.loading = false;
                  this.res_text_sendcode = '<?php echo __("Email is not correct format.", 'watergo'); ?>';
               } else if( res.message == 'email_non_exists' ){
                  this.loading = false;
                  this.res_text_sendcode = '<?php echo __("Email is not exitst.", 'watergo'); ?>';
               }else{
                  this.loading = false;
                  this.res_text_sendcode = '<?php echo __("Get Code Verify Error.", 'watergo'); ?>';
               }

            }else{
               this.loading = false;
               this.res_text_sendcode = '<?php echo __("Get Code Verify Error.", 'watergo'); ?>';
            }
         }else{
            this.res_text_sendcode = '<?php echo __("Email is not empty.", 'watergo'); ?>';
         }
      },

      // FOR STEP 1
      async btn_resend(){
         this.loading = true;
         this.code01 = '';
         this.code02 = '';
         this.code03 = '';
         this.code04 = '';
         this.res_text_sendcode = '';

         var form = new FormData();
         form.append('action', 'atlantis_send_code_verification');
         form.append('email', this.inputEmail);
         form.append('event', 'email_exists');
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
         if( this.inputPassword != '' && this.inputRepassword != '' && code != ''){
            
            if( this.inputPassword != this.inputRepassword ){
               this.res_text_sendcode = '<?php echo __("Password is not match.", 'watergo'); ?>';
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
                     this.res_text_sendcode = '<?php echo __("Code is not match.", 'watergo'); ?>';
                  }
                  if( res.message == 'reset_password_ok' ){
                     this.banner_open = true;
                  }
               }
            }

         }else{
            this.res_text_sendcode = '<?php echo __("Password and Code is not empty.", 'watergo'); ?>';
         }
      },

      moveFocus(event, nextField, prevField) {

         this.placeCaretToEnd(prevField);
         const input = event.target;
         const value = input.value;
         if ( event.key === 'Backspace' && !value && input.previousElementSibling) {
            input.previousElementSibling.focus();
         } else if (value && nextField) {
            if ( value.length === 1) {
               this.focusNextField(nextField);
            } else {
               input.value = value.slice(0, 1);
            }
         }
      },

      moveFocusBack(event, prevField) {
         if (event.target.value.length === 0 && prevField) {
            this.focusNextField(prevField);
            this.placeCaretToEnd(prevField);
         }
      },

      focusNextField(fieldId) {
         var nextInput = document.getElementById(fieldId);
         console.log(fieldId);
         if (nextInput) {
            nextInput.focus();
            nextInput.select();
         }
      },

      placeCaretToEnd(fieldId) {
         console.log(' placeCaretToEnd ' + fieldId);
         var inputElement = $('#' + fieldId);
         if ( inputElement != undefined && inputElement.val().length > 0 ) {
            inputElement[0].selectionStart = inputElement.val().length;
            inputElement[0].selectionEnd     = inputElement.val().length;
         }
      },
      

   },

}).mount('#authentication');

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