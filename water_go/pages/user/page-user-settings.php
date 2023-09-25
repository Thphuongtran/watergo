<div id='app'>
   <div v-show='loading == false' class='page-review-form'>

      <div class='appbar'>
         <div class='appbar-top'>
            <div class='leading'>
               <button @click='goBack' class='btn-action'>
                  <svg width="20" height="16" viewBox="0 0 20 16" fill="none" xmlns="http://www.w3.org/2000/svg">
                     <path fill-rule="evenodd" clip-rule="evenodd" d="M0 8C0 7.44772 0.447715 7 1 7H18.5C19.0523 7 19.5 7.44772 19.5 8C19.5 8.55228 19.0523 9 18.5 9H1C0.447715 9 0 8.55228 0 8Z" fill="#252831"/>
                     <path fill-rule="evenodd" clip-rule="evenodd" d="M10.5309 0.375342C10.8759 0.806604 10.806 1.4359 10.3747 1.78091L2.60078 8.00004L10.3747 14.2192C10.806 14.5642 10.8759 15.1935 10.5309 15.6247C10.1859 16.056 9.55657 16.1259 9.12531 15.7809L0.375305 8.78091C0.13809 8.59113 0 8.30382 0 8.00004C0 7.69625 0.13809 7.40894 0.375305 7.21917L9.12531 0.219168C9.55657 -0.125842 10.1859 -0.0559202 10.5309 0.375342Z" fill="#252831"/>
                  </svg>
               </button>
               <p class='leading-title'><?php echo __('Settings', 'watergo'); ?></p>
            </div>
         </div>
      </div>

      <div class='inner mt20'>
         <ul class='list-settings'>
            <li @click='updateUserNotification' class='no-arrow'>
               <span class='title'><?php echo __('Notification', 'watergo'); ?></span>
               <span class='subtitle'>
                  <label class="toggle-switch">
                     <input type="checkbox" v-model='user_notification' >
                     <span class="slider"></span>
                  </label>
               </span>
            </li>
            <li @click='gotoPageUserLanguage'>
               <span class='title'><?php echo __('Language', 'watergo'); ?></span>
               <span class='subtitle'>{{ get_language_compact }}</span>
            </li>
            <li v-if='is_user_login_social == false' @click='gotoPageUserPassword'>
               <span class='title'><?php echo __('Password', 'watergo'); ?></span>
            </li>
            <li @click='gotoPageUserTermConditions'>
               <span class='title'><?php echo __('Terms & Conditions', 'watergo'); ?></span>
            </li>
            <li @click='gotoPageUserPrivacyPolicy'>
               <span class='title'><?php echo __('Privacy Policy', 'watergo'); ?></span>
            </li>
            <li @click='gotoPageUserDeleteAccount'>
               <span class='title'><?php echo __('Delete Account', 'watergo'); ?></span>
            </li>
            <li @click='buttonOpenModalLogout'>
               <span class='title'><?php echo __('Log Out', 'watergo'); ?></span>
            </li>
         </ul>
      </div>
   </div>

   <div v-show='loading == true'>
      <div class='progress-center'>
         <div class='progress-container enabled'><progress class='progress-circular enabled' ></progress></div>
      </div>
   </div>

   <div v-show='modalOpenLogout' class='modal-popup open'>
      <div class='modal-wrapper'>
         <div class='modal-close'><div @click='buttonModalLogutCancel' class='close-button'><span></span><span></span></div></div>
         <p class='heading'><?php echo __('Logout', 'watergo'); ?>?</p>
         <div class='actions'>
            <button @click='buttonModalLogutCancel' class='btn btn-outline'><?php echo __('Cancel', 'watergo'); ?></button>
            <button @click='buttonModalLogutConfirm' class='btn btn-primary'><?php echo __('Okay', 'watergo'); ?></button>
         </div>
      </div>
   </div>

   


</div>
<style>
   body{
      background: #F5F5F5;
   }
</style>
<script type='module'>

var app = Vue.createApp({
   data (){
      return {
         loading: false,
         user_language: '',
         user_notification: false,
         modalOpenLogout: false,

         is_user_login_social: false,

         get_locale: '<?php echo get_locale(); ?>',


      }
   },

   computed: {

      get_language_compact(){
         if( this.get_locale == 'vi'){
            if( this.user_language == 'Vietnamese') return 'Tiếng Việt';
            if( this.user_language == 'English') return 'Tiếng Anh';
            if( this.user_language == 'Korean') return 'Tiếng Hàn';
         }
         if( this.get_locale == 'ko_KR'){
            if( this.user_language == 'Vietnamese') return '베트남어';
            if( this.user_language == 'English') return '영어';
            if( this.user_language == 'Korean') return '한국어';
         }
         return this.user_language;
      },
   },

   methods: {

      gotoPageUserPrivacyPolicy(){ window.gotoPageUserPrivacyPolicy()},

      // CHECK USER LOGIN IS SOCIAL 
      async check_user_login_social(){
         var form = new FormData();
         form.append('action', 'atlantis_is_user_login_social');
         var r = await window.request(form);
         if( r != undefined ){
            var res = JSON.parse( JSON.stringify( r));
            if( res.message == 'user_login_social'){
               this.is_user_login_social = true;
            }
         }
      },

      gotoPageUserLanguage(){ window.gotoPageUserLanguage()},
      gotoPageUserPassword(){ window.gotoPageUserPassword()},
      gotoPageUserDeleteAccount(){ window.gotoPageUserDeleteAccount()},
      gotoPageUserTermConditions(){ window.gotoPageUserTermConditions()},
      goBack(){ window.goBack()},

      async buttonModalLogutConfirm(){
         this.modalOpenLogout = false;
         this.loading = true;
         var form = new FormData();
         form.append('action', 'atlantis_logout');
         var r = await window.request(form);
         if( r != undefined ){
            var res = JSON.parse( JSON.stringify(r ));
            if( res.message == 'logout_success' ){
               localStorage.setItem('watergo_carts', '[]');
               // location to login
               window.appBridge.logout();
		         window.appBridge.close();
               // window.gotoLogin();
            }else{
               this.loading = false;
            }
         }
         this.loading = false;
      },

      buttonOpenModalLogout(){ this.modalOpenLogout = true; },
      buttonModalLogutCancel(){ this.modalOpenLogout = false; },

      // UPDATE USER NOTIFICATION
      async updateUserNotification(){
         this.user_notification = !this.user_notification;
         var _notification = this.user_notification == true ? 1 : 0;
         var form = new FormData(); 
         form.append('action', 'atlantis_user_notification');
         form.append('notification', _notification );
         var r = await window.request(form);
         if( r != undefined ){
            var res = JSON.parse( JSON.stringify( r ));
            if( res.message == 'update_notification_ok' ){
               if( res.data == 0 ){
                  this.user_notification = false;
               }else{
                  this.user_notification = true;
               }
            }
         }
      },

      async initUser(){
         var formData = new FormData();
         formData.append('action', 'atlantis_get_user_login_data');
         var r = await window.request(formData);
         if( r != undefined ){
            var res = JSON.parse( JSON.stringify( r ));
            if( res.message == 'user_found' ){
               this.user_notification = res.data.user_notification == 1 ? true : false;
            }
         }
      },

      async atlantis_get_language(){
         var form = new FormData();
         form.append('action', 'atlantis_get_language');
         var r = await window.request(form);
         if( r != undefined ){
            var res = JSON.parse( JSON.stringify(r ));

            if( res.data == 'en_US' ){
               this.user_language = 'English';
            } if( res.data == 'vi' ){
               this.user_language = 'Vietnamese';
            } if( res.data == 'ko_KR' ){
               this.user_language = 'Korean';
            }

         }
      },

   },
   async created(){
      this.loading = true;
      await this.initUser();
      await this.check_user_login_social();
      await this.atlantis_get_language();
      this.loading = false;

      window.appbar_fixed();
   }
}).mount('#app');

window.app = app;

</script>