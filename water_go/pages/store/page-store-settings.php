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
               <p class='leading-title'>Settings</p>
            </div>
         </div>
      </div>

      <div class='inner mt20'>
         <ul class='list-settings'>
            <li @click='gotoPageUserLanguage'>
               <span class='title'>Language</span>
               <span class='subtitle'>{{ user_language }}</span>
            </li>
            <li v-if='is_user_login_social == false' @click='gotoPageUserPassword'>
               <span class='title'>Password</span>
            </li>
            <li @click='gotoPageUserDeleteAccount'>
               <span class='title'>Delete Account</span>
            </li>
            <li @click='buttonOpenModalLogout'>
               <span class='title'>Log Out</span>
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
         <p class='heading'>Logout?</p>
         <div class='actions'>
            <button @click='buttonModalLogutCancel' class='btn btn-outline'>Cancel</button>
            <button @click='buttonModalLogutConfirm' class='btn btn-primary'>Okay</button>
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

var { createApp } = Vue;

createApp({
   data (){
      return {
         loading: false,
         user_language: '',
         user_notification: false,
         modalOpenLogout: false,

         is_user_login_social: false,


      }
   },
   methods: {

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
      async initUser(){
         var formData = new FormData();
         formData.append('action', 'atlantis_get_user_login_data');
         var r = await window.request(formData);
         if( r != undefined ){
            var res = JSON.parse( JSON.stringify( r ));
            if( res.message == 'user_found' ){
               this.user_notification = res.data.user_notification == 1 ? true : false;
               this.user_language = res.data.user_language != '' ? res.data.user_language : 'English';
            }
         }
      },

      async buttonModalLogutConfirm(){
         this.modalOpenLogout = false;
         this.loading = true;
         var form = new FormData();
         form.append('action', 'atlantis_logout');
         var r = await window.request(form);
         if( r != undefined ){
            var res = JSON.parse( JSON.stringify(r ));
            if( res.message == 'logout_success' ){
               // location to login
               window.appBridge.logout();
		         window.appBridge.close();
               // window.gotoLogin();
            }
         }
         this.loading = false;
      },

      buttonOpenModalLogout(){ this.modalOpenLogout = true; },
      buttonModalLogutCancel(){ this.modalOpenLogout = false; },


      gotoPageUserLanguage(){ window.gotoPageUserLanguage()},
      gotoPageUserPassword(){ window.gotoPageUserPassword()},
      gotoPageUserDeleteAccount(){ window.gotoPageUserDeleteAccount()},
      gotoPageUserTermConditions(){ window.gotoPageUserTermConditions()},
      goBack(){ window.goBack()},

   },
   async created(){
      this.loading = true;
      await this.initUser();
      this.loading = false;

      window.appbar_fixed();
   }
}).mount('#app');
</script>