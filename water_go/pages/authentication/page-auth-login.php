<?php
$get = $_GET;
$get["appt"] = "N";
$login_url_par = http_build_query($get);  
?>
<style type="text/css">
   .banner.page-welcome .banner-footer a{ width: 100%; position: absolute; bottom: 15%; }
</style>
<div id='authentication'>

   <div class='banner page-welcome<?php echo isset($_GET["appt"]) ? " d-none" : ""; ?>'>
      <div class='banner-head'>
         <div class='heading'>WELCOME !</div>
         <p class='ttl'>Please login to explode more</p>
         <div class='logo-brand'>
            <img src="<?php echo THEME_URI . '/assets/images/logo-vertical.png'; ?>">
         </div>

      </div>

      <div class='banner-footer'>
         <a href="?<?php echo $login_url_par ?>" class='btn btn-primary'>Login</a>
      </div>
   </div>

   <div v-show='loading == false' class='page-authentication'>

      <div class='appbar'>
         <div class='appbar-top'>
            <div class='leading'>
               <a href="?appt=X" class='btn-action'>
                  <svg width="20" height="16" viewBox="0 0 20 16" fill="none" xmlns="http://www.w3.org/2000/svg">
                  <path fill-rule="evenodd" clip-rule="evenodd" d="M0 8C0 7.44772 0.447715 7 1 7H18.5C19.0523 7 19.5 7.44772 19.5 8C19.5 8.55228 19.0523 9 18.5 9H1C0.447715 9 0 8.55228 0 8Z" fill="#252831"/>
                  <path fill-rule="evenodd" clip-rule="evenodd" d="M10.5309 0.375342C10.8759 0.806604 10.806 1.4359 10.3747 1.78091L2.60078 8.00004L10.3747 14.2192C10.806 14.5642 10.8759 15.1935 10.5309 15.6247C10.1859 16.056 9.55657 16.1259 9.12531 15.7809L0.375305 8.78091C0.13809 8.59113 0 8.30382 0 8.00004C0 7.69625 0.13809 7.40894 0.375305 7.21917L9.12531 0.219168C9.55657 -0.125842 10.1859 -0.0559202 10.5309 0.375342Z" fill="#252831"/>
                  </svg>
               </a>

            </div>
            <div class='action'></div>
         </div>
      </div>

      <div class='inner style01'>


         <div class='t-center'>
            <img class='login-align' width='210' src="<?php echo THEME_URI . '/assets/images/watergo_logo.png'; ?>" alt="Login Image">
         </div>

         <div class='box-language t-center'>
            <div class="dropdown dropdown-language">
               <div class="dropdown-toggle" @click="toggleDropdown">
               <div class="selected-option">
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
         
         <p class='t-red mt10 mb10'>{{ res_text_sendcode }}</p>

         <div class='form-check style01' style="display:flex; align-items: center;column-gap: 4px;">
            <label class='justify-center'>
               <input @click='toggle_term_conditions' :checked='term_conditions' type='checkbox' class='checkbox-login'> 
               <span class='text text-nowrap'> I agree with </span>
            </label>
            <a href="/user-terms-and-conditions/?appt=N" class='t-primary' style="text-decoration: none; height: 26px;padding-top: 4px;">Terms and Conditions</a>
         </div>

         <div class='form-group'>
            <button @click='btn_login' class='btn btn-primary' :class='term_conditions == false ? "disable" : "" '>Log In</button>
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
   <div v-show='loading == true'>
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
         term_conditions: true,
         page_welcome: true,
         languages: [
           { id: 'en_US', name: 'English'},
           { id: 'vi', name: 'Vietnamese'},
           { id: 'ko_KR', name: 'Korean'},
         ],
         selectedLanguage: {},
         currentLocale: '',
         showDropdown: false
      }
   },
   
   methods: {
      toggleDropdown() {
         this.showDropdown = !this.showDropdown;
      },
      selectLanguage(language) {
         this.selectedLanguage = language;
         this.changeLanguage(language.id);
         this.showDropdown = false;
         this.toggleDropdown();
      },

      async changeLanguage(language){
         var form = new FormData();
         form.append('action', 'app_change_language_callback');
         form.append('language', language);
         var r = await window.request(form);

         console.log('get current locale')
         console.log(r)

         if( r != undefined ){
            var res = JSON.parse( JSON.stringify(r ));
            if( res.message == 'change_language_successfully' ){
               if( window.appBridge != undefined ){
                  window.appBridge.setLanguage(res.data);
                  window.appBridge.close('refresh');
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
         console.log(r)
         if( r != undefined ){
            var res = JSON.parse( JSON.stringify(r ));
            if( res.message == 'current_locale_found' ){
               this.currentLocale = res.data;
               //this.selectLanguage(this.languages.find(language => language.id === this.currentLocale) || this.languages[0]);
            }
         }
      },
      
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
      gotoLogin(){this.page_welcome = false;},

      toggle_term_conditions(){ this.term_conditions = !this.term_conditions;},

      gotoAuthForgetPassword(){ window.gotoAuthForgetPassword()},
      gotoAuthRegister(){ window.gotoAuthRegister()},

      async btn_login(){
         if( this.term_conditions == true ){
            if( this.inputEmail != '' && this.inputPassword != ''){
               this.loading = true;
               var form = new FormData();
               form.append('action', 'atlantis_login');
               form.append('email', this.inputEmail);
               form.append('password', this.inputPassword);
               var r = await window.request(form);
               if( r != undefined ){
                  var res = JSON.parse( JSON.stringify( r ));
                  if( res.message == 'login_ok' ){


                     if( window.appBridge != undefined ){
                        window.appBridge.loginSuccess(res.token);
                        window.appBridge.refresh();
                     }
                     
                  }
                  if(res.message == 'login_error' ){
                     this.res_text_sendcode = 'Email or password is incorrect';
                  }
                  if(res.message == 'user_not_found' ){
                     this.res_text_sendcode = 'Email or password is incorrect';
                  }
               }else{
                  this.res_text_sendcode = 'Email or password is incorrect';   
               }
            }else{
               this.res_text_sendcode = 'Username or Password must be not empty.';
            }
         }
         this.loading = false;
         
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

   async created() {
     this.selectedLanguage = this.languages.find(language => language.id === this.currentLocale) || this.languages[0];
     await this.getLocale();
   },

}).mount('#authentication');

</script>