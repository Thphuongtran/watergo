<?php

get_header();

$app_extra_classes = '';

?>

<div id='app'>

   <div v-if='loading == false'>

      <div v-if='navigator == "profile"'>
         <?php get_template_part('pages/user/user-profile'); ?>
      </div>

      <div v-if='navigator == "profile_edit"'>
         <?php get_template_part('pages/user/user-edit'); ?>
      </div>

      <delivery-address-component></delivery-address-component>

      <div v-if='navigator == "settings"'>
         <?php get_template_part('pages/user/user-settings'); ?>

         <div v-show='modalOpenLogout' class='modal-popup open'>
            <div class='modal-wrapper'>
               <div class='modal-close'><div @click='buttonModalLogutCancel' class='close-button'><span></span><span></span></div></div>
               <p class='heading'>Logout?</p>
               <div class='actions'>
                  <button @click='buttonModalLogutCancel' class='button-outline'>Cancel</button>
                  <button @click='buttonModalLogutConfirm' class='button'>Okay</button>
               </div>
            </div>
         </div>
      </div>

      <support-component></support-component>

      <div v-if='navigator == "support-add"'>
         <?php //get_template_part('pages/user/user-support-add'); ?>
      </div>

   </div>

   

   <div v-if='loading == true'>
      <div class='progress-center'>
         <div class='progress-container enabled'><progress class='progress-circular enabled' ></progress></div>
      </div>
   </div>

</div>
<script src='<?php echo THEME_URI . '/pages/module/delivery_address.js'; ?>'></script>
<script src='<?php echo THEME_URI . '/pages/module/watergo_support.js'; ?>'></script>
<script>
   var { createApp } = Vue;

   createApp({
      name: 'user',
      data (){
         return {
            pageNameConnector: 'user',

            loading: false,

            navigator: 'profile', // delivery | settings | support | myreviews

            previewAvatar: null,
            selectedImage: null,

            id: '',
            email: '',
            name: '',
            avatar: '',

            modalOpenLogout: false,
            modalLogoutConfirm: false,

            // FOR DELIVERY
            delivery_actions: null,
            delivery_address: [],

            // FOR SETTINGS
            settings_actions: null, // | languages | password | delete_account
            user_notification: false,

            settings_language: [
               'Vietnamese', // 0
               'English' // 1
            ],
            
            user_language: 'English',

            user_support_question: '',

            user_support_data: [],

            settings_delete_account_step: 0,

            settings_delete_account_question: [
               "I don\'t want to use Social Beauty app anymore",
               'I want to create another account',
               'I have a privacy concern',
               'Other'
            ],
            settings_delete_account_question_selected: 0,
            settings_delete_account_question_other: '',

            setting_current_password: '',
            setting_new_password: '',
            setting_confirm_password: '',

         }
      },



      methods: {
         // FUNCTION REQUEST AJAX
         request( formdata ){
            var ajaxurl = "<?php echo admin_url('admin-ajax.php'); ?>";
            try{
               return axios({ method: 'post', url: ajaxurl, data: formdata
               }).then(function (res) { 
                  return res.status == 200 ? res.data.data : null;
               });
            }catch(e){
               console.log(e);
               return null;
            }
         },

         gotoPage( page ){
            this.navigator = page;
         },

         // CLOSE POPUP REIIEWS
         popup_reivew_action(){
            this.$nextTick(() => {
               this.$refs.popup_reivew_action_dropdown.classList.toggle('active')
            });
         },

         navigatorSettingsBack(){
            this.settings_actions = null;
            this.settings_delete_account_question_other = '';
            this.settings_delete_account_question_selected = 0;
         },

         /**
          * @access PAGE SETTINGS
          */
         buttonUserDeleteAccount(){
            this.settings_delete_account_step = 1;
         },

         buttonUserSettingsQuestionSelected( index ){
            this.settings_delete_account_question_selected = index;
         },

         // UPDATE USER NOTIFICATION
         async updateUserNotification(){
            if( this.user_notification == true ){
               this.user_notification = false;
            }else{
               this.user_notification = true;
            }
            var _notification = this.user_notification == true ? 1 : 0;
            var form = new FormData(); 
            form.append('action', 'atlantis_user_notification');
            form.append('notification', _notification );
            // atlantis_user_notification
            var r = await this.request(form);
            if( r != undefined ){
               var res = JSON.parse( JSON.stringify( r ));
            }
         },

         async updateUserLanguage( language ){
            this.user_language = language;
            var form = new FormData(); 
            form.append('action', 'atlantis_user_language');
            form.append('language', language );
            // atlantis_user_notification
            var r = await this.request(form);
            if( r != undefined ){
               var res = JSON.parse( JSON.stringify( r ));
            }

         },

         userChangeLanguages(){
            this.settings_actions = 'language';
         },
         userChangePassword(){
            this.settings_actions = 'password';
         },
         userDeleteAccount(){
            this.settings_actions = 'delete_account';
         },

         // LOGOUT
         buttonOpenModalLogout(){ this.modalOpenLogout = true; },
         buttonModalLogutCancel(){ this.modalOpenLogout = false; },
         async buttonModalLogutConfirm(){
            this.modalOpenLogout = false;
            this.loading = true;
            var form = new FormData();
            form.append('action', 'atlantis_logout');
            var r = await this.request(form);
            if( r != undefined ){
               var res = JSON.parse( JSON.stringify(r ));
               if( res.message == 'logout_success' ){
                  // location to login
                  window.location.href = "<?php echo WATERGO_LOGIN; ?>";
               }else{
                  this.loading = false;
               }
            }
            this.loading = false;

         },
         /////////////////////////////////////////

         avatarSelected(e){
            var file = e.target.files;
            if( file != undefined && file[0].type.startsWith('image/') ){
               var reader = new FileReader();
               reader.onload = (e) => {
                  this.previewAvatar = e.target.result;
               };
               reader.readAsDataURL(file[0]);
               this.selectedImage = file[0];
            }
         },


         async updateUser(){
            var save_first_name = this.first_name;
            var save_avatar = this.avatar;
            var save_email = this.email;
            var dialog = confirm('Change Profile?');
            if( dialog == true ){
               var formData = new FormData();
               formData.append('action', 'atlantis_update_user');
               if( this.email != '' ){
                  formData.append('email', this.email);
               }
               if( this.name != '' ){
                  formData.append('name', this.name);
               }
               if( this.selectedImage != null ){
                  formData.append('avatar', this.selectedImage );
               }
               if( this.email != '' || this.name != '' || this.selectedImage != null ){
                  var r = await this.request(formData);
                  if(r != undefined ){
                     var res = JSON.parse( JSON.stringify( r ));
                     if( res.err == false ){
                        this.gotoProfile();
                     }
                  }
               }
            }

            
         },

         async initUser(){
            this.loading = true;
            var formData = new FormData();
            formData.append('action', 'atlantis_get_user_login_data');
            var r = await this.request(formData);
            if( r != undefined ){
               var res = JSON.parse( JSON.stringify( r ));
               if( res.err == false ){
                  this.id = res.data.user_id;
                  this.email = res.data.user_email;
                  this.name = res.data.first_name;
                  this.avatar = res.data.avatar;
                  this.user_notification = res.data.user_notification == 1 ? true : false;
                  this.user_language = res.data.user_language != '' ? res.data.user_language : 'English';

                  this.loading = false;
                  // console.log(res);
               }
            }
         },

         gotoProfile(){ this.previewAvatar= null; this.navigator = 'profile'; },
         gotoEdit(){ this.previewAvatar= null; this.navigator = 'profile_edit'; },
         gotoDeliveryAddress(){ 
            this.previewAvatar= null; 
            this.navigator = 'delivery_address'; 
         },
         gotoSettings(){ this.previewAvatar= null; this.navigator = 'settings'; },
         gotoSupport(){ this.previewAvatar= null; this.navigator = 'support'; },
         gotoSupportAdd(){ this.previewAvatar= null; this.navigator = 'support-add'; },

      },

      async mounted(){
         await this.initUser();
      }

   })
   .component('delivery-address-component', PageDeliveryAddress)
   .component('support-component', PageSupport)
   .mount('#app');

</script>

<?php 

get_footer();
