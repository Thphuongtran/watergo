<div id='authentication'>

   <div v-show='loading == false' class='page-auth-register'>

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
         </div>
      </div>

      <div class='inner style01'>

         <div class='t-center'>
            <img class='login-align' width='210' src="<?php echo THEME_URI . '/assets/images/watergo_logo.png'; ?>" alt="Login Image">
         </div>

         <div class='box-language t-center'>
            <div class="dropdown dropdown-language">
               <div class="dropdown-toggle">
               <div class="selected-option" @click="toggleDropdown">
                  <img :src="getFlagImage(selectedLanguage.id)" :alt="selectedLanguage.id" class="flag-image" />
                  <svg width="12" height="7" viewBox="0 0 12 7" fill="none" xmlns="http://www.w3.org/2000/svg">
                     <path d="M1 1L6 6L11 1" stroke="#181E32" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                  </svg>
               </div>
               <ul class="dropdown-menu" :class="{ 'show': showDropdown }">
                  <li v-for="language in languages" :key="language.id" @click="selectLanguage(language)" :class="{ 'selected': currentLocale === language.id }">
                     <img :src="getFlagImage(language.id)" :alt="language.id" class="flag-image" />
                     {{ language.name }}
                  </li>
               </ul>
               </div>
            </div>
         </div>

         <div class='heading-01 t-center'><?php echo __('Sign Up', 'watergo'); ?></div>

         <div class='form-group'>
            <span><?php echo __('User name', 'watergo'); ?></span>
            <input v-model='inputUsername' type="text" placeholder='<?php echo __('Enter your username', 'watergo'); ?>'>
         </div>

         <div class='form-group'>
            <span>Email</span>
            <div class='form-group-email'>
               <input v-model='inputEmail' type="email" placeholder='<?php echo __('Enter you email', 'watergo'); ?>'>
               <button class='btn-email-verify' @click='btn_verify_email_and_sendcode' class='btn-text' :class='isCodeSend == true ? "is-send": ""' ><?php echo __('Verify', 'watergo'); ?></button>
            </div>
         </div>
         
         <!-- <p>
            <button @click='btn_verify_email_and_sendcode' class='btn-text' >Verify your email</button>
         </p> -->

         <p v-show='isCodeSend' class='t-second-12 text-code-resend'>
            <?php echo __('We have sent a code to your email.', 'watergo'); ?><button @click='btn_verify_email_and_sendcode' class='btn-text'><?php echo __('Resend', 'watergo'); ?></button>
         </p>

         <!-- <div v-if='isCodeSend' class='box-code-verify'> 
            <input @input="moveFocus($event, 'code02')" @keydown.delete="moveFocus($event, 'code01')" id='code01' v-model='code01' maxlength='1' type="text" pattern='[0-9]*' autocomplete='off'>
            <input @input="moveFocus($event, 'code03')" @keydown.delete="moveFocus($event, 'code02')" id='code02' v-model='code02' maxlength='1' type="text" pattern='[0-9]*' autocomplete='off'>
            <input @input="moveFocus($event, 'code04')" @keydown.delete="moveFocus($event, 'code03')" id='code03' v-model='code03' maxlength='1' type="text" pattern='[0-9]*' autocomplete='off'>
            <input @keydown.delete="moveFocus($event, 'code04')" id='code04' v-model='code04' type="text" maxlength='1' pattern='[0-9]*' autocomplete='off'>
         </div> -->
         <div v-if="isCodeSend" class="box-code-verify">
            <input ref="code01" v-model="code01" maxlength="1" type="text" pattern="[0-9]*" autocomplete="off">
            <input ref="code02" v-model="code02" maxlength="1" type="text" pattern="[0-9]*" autocomplete="off">
            <input ref="code03" v-model="code03" maxlength="1" type="text" pattern="[0-9]*" autocomplete="off">
            <input ref="code04" v-model="code04" type="text" maxlength="1" pattern="[0-9]*" autocomplete="off">
         </div>

         <div class='form-group mt10'>
            <span><?php echo __('Password', 'watergo');?></span>
            <input v-model='inputPassword' type="password" placeholder='<?php echo __('Enter your password', 'watergo'); ?>'>
         </div>

         <div class='form-check style01 mt15' style="display:flex; align-items: center;column-gap: 4px;">
            <label class='justify-center'>
               <input @click='toggle_term_conditions' :checked='term_conditions' type='checkbox' class='checkbox-login'> 
               <span class='text text-nowrap'><?php echo __('I agree with', 'watergo'); ?> </span>
            </label>
            <button @click='gotoPageUserTermConditions' class='link-term-condition t-primary'><?php echo __('Terms and Conditions', 'watergo'); ?></button>
         </div>

         <p class='t-red mt15'>{{ res_text_sendcode }}</p>

         <div class='form-group'>
            <button @click='btn_register' class='btn btn-primary' :class='term_conditions == false ? "disable" : "" '><?php echo __('Sign Up', 'watergo'); ?></button>
            <button @click='btn_goto_login' class='btn btn-second mt15'><?php echo __('Log In', 'watergo'); ?></button>
         </div>

         <!-- <p class='t-second t-center mt25'><?php echo __('Or log in with', 'watergo'); ?></p> -->

         <!-- <div class='form-group mt20'>
            <button @click='login_social_apple' class='btn-icon' ref='button-signup'><img src='<?php echo THEME_URI . '/assets/images/apple-logo.png' ?>'><span class='text'><?php echo __('Log in with Apple', 'watergo'); ?></span></button>
            <button @click='login_social_google' class='btn-icon' ref='button-login'><img src='<?php echo THEME_URI . '/assets/images/gg-logo.png' ?>'><span class='text'><?php echo __('Log in with Google', 'watergo'); ?></span></button>
            <button @click='login_social_zalo' class='btn-icon' ref='button-login'><img src='<?php echo THEME_URI . '/assets/images/zalo-logo.png' ?>'><span class='text'><?php echo __('Log in with Zalo', 'watergo'); ?></span></button>
         </div> -->

      </div>

   </div>

   <div v-show='loading == true'>
      <div class='progress-center'>
         <div class='progress-container enabled'><progress class='progress-circular enabled' ></progress></div>
      </div>
   </div>

   <div v-show='banner_open == true' class='banner'>
      <div class='banner-head'>
         <svg width="64" height="64" viewBox="0 0 64 64" fill="none" xmlns="http://www.w3.org/2000/svg">
         <circle cx="32" cy="32" r="32" fill="#2790F9"/>
         <path fill-rule="evenodd" clip-rule="evenodd" d="M44.7917 24.8288L42.103 22.1401L27.8578 36.3854L22.2522 30.7798L19.5635 33.4685L27.9506 41.8557L30.6393 39.167L30.5465 39.0741L44.7917 24.8288Z" fill="white"/>
         </svg>
         <h3><?php echo __('Congratulations', 'watergo'); ?>!</h3>
         <p><?php echo __('Your registration has been successful', 'watergo'); ?></p>
      </div>

      <div class='banner-footer'>
         <button @click='goBack' class='btn btn-primary'><?php echo __('Log In', 'watergo'); ?></button>
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

         term_conditions: true,

         // CODE VERIFY
         isCodeSend: false,
         code01: '',
         code02: '',
         code03: '',
         code04: '',

         // LANGUAGE
         languages: [
           { id: 'en_US', name: '<?php echo __("English", 'watergo'); ?>'},
           { id: 'vi', name: '<?php echo __("Vietnamese", 'watergo'); ?>'},
         //   { id: 'ko_KR', name: 'Korean'},
         ],
         selectedLanguage: {},
         currentLocale: '',
         showDropdown: false


      }
   },
   watch : {
      inputEmail : function(val){
         if(this.verify_email(val)){
            $(".btn-email-verify").addClass("is-send");
         }else{
            $(".btn-email-verify").removeClass("is-send");
         }
      }
   },

   methods: {
      
      gotoPageUserTermConditions(){ window.gotoPageUserTermConditions()},

      toggleDropdown() { this.showDropdown = !this.showDropdown; },

      selectLanguage(language) {
         if( this.selectedLanguage.id != language.id ){
            this.selectedLanguage = language;
            this.changeLanguage(language.id);
         }
         this.showDropdown = false;
      },

      async changeLanguage(language){
         var form = new FormData();
         form.append('action', 'app_change_language_callback');
         form.append('language', language);
         var r = await window.request(form);
         if( r != undefined ){
            var res = JSON.parse( JSON.stringify(r ));
            if( res.message == 'change_language_successfully'){
               if( window.appBridge != undefined ){
                  window.appBridge.setLanguage(res.data);
                  window.appBridge.refresh();
               }else{
                  window.location.reload();
               }
            }
         }
      },

      getFlagImage(languageId) {
         if (languageId === 'en_US') {
           return get_template_directory_uri + '/assets/images/flag-us.svg';
         } else if (languageId === 'vi') {
           return get_template_directory_uri + '/assets/images/flag-vi.svg';
         } else if (languageId === 'ko_KR') {
           return get_template_directory_uri + '/assets/images/flag-kr.svg';
         }
         return '';
      },

      async getLocale(){
         var form = new FormData();
         form.append('action', 'get_current_locale_callback');
         var r = await window.request(form);
         if( r != undefined ){
            var res = JSON.parse( JSON.stringify(r ));
            if( res.message == 'current_locale_found' ){
               this.currentLocale = res.data;
               //this.selectLanguage(this.languages.find(language => language.id === this.currentLocale) || this.languages[0]);
            }
         }
      },
      // 


      goBack(){ window.goBack()},

      verify_email( email ){
         const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
         if (emailRegex.test(email)) {
            return true;
         }else{
            return false;
         }
      },

      btn_goto_login(){ window.goBack() },

      toggle_term_conditions(){ this.term_conditions = !this.term_conditions;},
      
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

      // moveFocus(event, nextInput){
      //    var input = event.target;
      //    var id = event.target.id;
      //    if (event.key === "Backspace" && !input.value && input.previousElementSibling) {
      //       input.previousElementSibling.focus();
      //    } else if (input.value && input.nextElementSibling) {
      //       input.nextElementSibling.focus();
      //    }
      // },

      moveFocus(event, nextField) {
         if (event.target.value.length >= 1) {
            this.$refs[nextField].focus();
         }
      },
      moveFocusBack(event, prevField) {
         if (event.target.value.length === 0) {
            this.$refs[prevField].focus();
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
         this.loading = true;
         this.code01 = '';
         this.code02 = '';
         this.code03 = '';
         this.code04 = '';
         
         if( this.inputEmail != '' && this.inputEmail.length > 0 ){
            if( this.verify_email(this.inputEmail) == true ){
               var form = new FormData();
               form.append('action', 'atlantis_send_code_verification');
               form.append('email', this.inputEmail);
               form.append('event', 'email_non_exists');
               var r = await window.request(form);
               if( r != undefined ){
                  var res = JSON.parse( JSON.stringify(r));
                     this.loading = false;

                  if( res.message == 'email_is_not_correct_format' ){
                     this.res_text_sendcode = '<?php echo __("Email is not correct format.", 'watergo'); ?>';
                  }
                  else if( res.message == 'email_already_exists' ){
                     this.res_text_sendcode = '<?php echo __("Email already register.", 'watergo'); ?>';
                  }
                  else if( res.message == 'sendcode_success' ){
                     this.res_text_sendcode = '';
                     this.isCodeSend = true;
                  }

               }else{
                  this.res_text_sendcode = '<?php echo __("Get Code Verify Error.", 'watergo'); ?>';
               }
            }else{
               this.res_text_sendcode = '<?php echo __("Email is not correct format.", 'watergo'); ?>';
            }
         }
         
         this.loading = false;

         
      },

      async btn_register(){
         var code = this.code01 + this.code02 + this.code03 + this.code04;
         if( this.term_conditions == true ){
            if( this.inputUsername != '' && this.inputEmail != '' && this.inputPassowrd != '' ){
               this.loading = true;

               if( code != '' ){
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

                        window.appBridge.loginSuccess(res.token);                 
                        window.appBridge.setUserToken(res.token); 
                        window.appBridge.navigateTo("Home");
                        //this.banner_open = true;
                        // this.gotoNotification('register-success');
                     }

                     if( res.message == 'resgiter_error' ){
                        this.res_text_sendcode = '<?php echo __("Register Error.", 'watergo'); ?>';
                     }
                     if( res.message == 'email_already_exists' ){
                        this.res_text_sendcode = '<?php echo __("Email already exists.", 'watergo'); ?>';
                     }
                     if( res.message == 'user_exists' ){
                        this.res_text_sendcode = '<?php echo __("Username already exists.", 'watergo'); ?>';
                     }
                     if( res.message == 'code_is_not_match' ){
                        this.res_text_sendcode = '<?php echo __("Code is not match.", 'watergo'); ?>';
                     }


                  }else{
                     this.res_text_sendcode = '<?php echo __("Register Error.", 'watergo'); ?>';
                  }
               }else{
                  this.res_text_sendcode = '<?php echo __("Email is not verify.", 'watergo');?>';
               }
            }else{
               this.res_text_sendcode = '<?php echo __("All field must be not empty.", 'watergo'); ?>';
            }
         }
         this.loading = false;
      },

   },

   async created() {
     await this.getLocale();
     this.selectedLanguage = this.languages.find(language => language.id === this.currentLocale) || this.languages[0];
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