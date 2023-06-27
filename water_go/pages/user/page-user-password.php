<div id='app'>
   <div v-if='loading == false' class='page-order-filter'>

      <div class='appbar'>
         <div class='appbar-top'>
            <div class='leading'>
               <button @click='goBack' class='btn-action'>
                  <svg width="20" height="16" viewBox="0 0 20 16" fill="none" xmlns="http://www.w3.org/2000/svg">
                  <path fill-rule="evenodd" clip-rule="evenodd" d="M0 8C0 7.44772 0.447715 7 1 7H18.5C19.0523 7 19.5 7.44772 19.5 8C19.5 8.55228 19.0523 9 18.5 9H1C0.447715 9 0 8.55228 0 8Z" fill="#252831"/>
                  <path fill-rule="evenodd" clip-rule="evenodd" d="M10.5309 0.375342C10.8759 0.806604 10.806 1.4359 10.3747 1.78091L2.60078 8.00004L10.3747 14.2192C10.806 14.5642 10.8759 15.1935 10.5309 15.6247C10.1859 16.056 9.55657 16.1259 9.12531 15.7809L0.375305 8.78091C0.13809 8.59113 0 8.30382 0 8.00004C0 7.69625 0.13809 7.40894 0.375305 7.21917L9.12531 0.219168C9.55657 -0.125842 10.1859 -0.0559202 10.5309 0.375342Z" fill="#252831"/>
                  </svg>
               </button>
               <p class='leading-title'>Change Password</p>
            </div>
         </div>
      </div>

      <div class='inner'>
         <div class='page-change-password'>
            <div class='box-justify-between'>
               
               <div class='form-wrapper'>
                  <div class='form-group style01'>
                     <span>Current Password</span>
                     <input class='input-style02' v-model='current_password' type="password" placeholder='Enter current password'>
                  </div>
                  <div class='form-group style01'>
                     <span>New Password</span>
                     <input v-model='new_password' type="password" placeholder='Enter new password'>
                  </div>
                  <div class='form-group style01'>
                     <span>Confirm New Password</span>
                     <input v-model='confirm_password' type="password" placeholder='Enter new password'>
                  </div>
               </div>
               <p class='t-red'>{{ t_res }}</p>

               <div class='btn-fixed bottom'>
                  <button @click='btn_change_password' class='btn btn-primary'>Save</button>
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
<script type='module'>

var { createApp } = Vue;

createApp({
   data (){
      return {
         loading: false,
         current_password: '',
         new_password: '',
         confirm_password: '',
         t_res: ''
      }
   },

   methods: {
      
      async btn_change_password(){
         this.loading = true;
         var form = new FormData();
         form.append('action', 'atlantis_user_change_password');
         form.append('current_password', this.current_password);
         form.append('new_password', this.new_password);
         form.append('confirm_password', this.confirm_password);
         var r = await window.request(form);
         if( r != undefined ){
            var res = JSON.parse(JSON.stringify(r));
            if(res.message == 'field_must_not_empty' ){
               this.t_res = 'Field must be not empty.';
               this.loading = false;
            }else if( res.message == 'password_is_not_same'){
               this.t_res = 'Password it not same.';
               this.loading = false;
            }else if( res.message == 'current_password_is_not_correct'){
               this.t_res = 'Current Password it not correct.';
               this.loading = false;
            }else if( res.message == 'user_change_password_ok'){
               this.gotoNotification('change-password-success');
            }
         }
         console.log(r);
      },

      gotoNotification(code){ window.gotoNotification(code);},
      goBack(){ window.goBack();}

   }

}).mount('#app');
</script>