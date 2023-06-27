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

      <!-- <div v-if='navigator == "delivery_address"'> -->
         <?php //get_template_part('pages/delivery_address/delivery_address_list'); ?>
      <!-- </div> -->
      <delivery-address ref='page_delivery_address' ></delivery-address>

      <!-- <div v-if='navigator == "delivery_address_add"'> -->
         <?php //get_template_part('pages/delivery_address/delivery_address_add'); ?>
      <!-- </div> -->

      <!-- <div v-if='navigator == "delivery_address_edit"'> -->
         <?php //get_template_part('pages/delivery_address/delivery_address_edit'); ?>
      <!-- </div> -->

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

      <div v-if='navigator == "support"'>
         <?php get_template_part('pages/user/user-support'); ?>
      </div>

      <div v-if='navigator == "support-add"'>
         <?php get_template_part('pages/user/user-support-add'); ?>
      </div>

   </div>

   

   <div v-if='loading == true'>
      <div class='progress-center'>
         <div class='progress-container enabled'><progress class='progress-circular enabled' ></progress></div>
      </div>
   </div>

</div>
<script src='<?php echo THEME_URI . '/pages/module/delivery_address.js'; ?>'></script>
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

            // DELIVERY ADDRESS FORM [add-edit]
            delivery_address_edit_form: false,

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

         ///////////////////////////////////////

         /**
          * @access DELIVERY PAGE
          */
         // OPEN FORM ADD
         // buttonAddDeliveryAddress(){
         //    this.delivery_actions = 'add';
         //    this.gotoDeliveryAddressAdd();
         //    this.delivery_address_id = null;
         //    this.delivery_address_name = null;
         //    this.delivery_address_phone = null;
         //    this.delivery_address_location = null;
         //    this.delivery_address_primary = false;
         // },

         // buttonEditDeliveryAddress( id_delivery ){
         //    this.delivery_actions = 'update';
         //    this.gotoDeliveryAddressEdit(id_delivery);
         //    this.delivery_address.forEach(( delivery, index ) => {
         //       if( delivery.id == id_delivery ){
         //          this.delivery_address_id = delivery.id;
         //          this.delivery_address_name = delivery.name;
         //          this.delivery_address_phone = delivery.phone;
         //          this.delivery_address_location = delivery.address;
         //          this.delivery_address_primary = delivery.primary == 1 ? true : false;
         //       }
         //    });
         // },

         async deleteDeliveryAddress(){
            var _confirm = confirm('Delete Address ?');
            if(_confirm == true ){
               var form = new FormData();
               form.append('action', 'atlantis_user_delivery_address');
               form.append('event', 'delete');
               form.append('id_delivery', this.delivery_address_id);
               var r = await this.request(form);
               if(r != undefined ){
                  var res = JSON.parse( JSON.stringify( r ));
                  if( res.err == false ){
                     this.delivery_address.forEach((e, index) => {
                        if( e.id == this.delivery_address_id ){
                           this.delivery_address.splice(index, 1);
                        }
                     });
                     this.gotoDeliveryAddress();
                     this.delivery_actions = null;
                  }
               }
            }
            this.delivery_actions = null;
         },

         async actionDeliveryAddress(){
            this.loading = true;
            var form = new FormData();
            form.append('action', 'atlantis_user_delivery_address');
            if( this.delivery_actions == null ){
               this.loading = false;
               return;
            }
            if(this.delivery_actions == 'add'){
               form.append('event', 'add');
            }
            if(this.delivery_actions == 'update'){
               form.append('id_delivery', this.delivery_address_id);
               form.append('event', 'update');
            }
            var _primary = this.delivery_address_primary == true ? 1 : 0;
            
            form.append('primary', _primary);
            
            if( this.delivery_address_name != null ){
               form.append('name', this.delivery_address_name);
            }
            if( this.delivery_address_phone != null ){
               form.append('phone', this.delivery_address_phone);
            }
            if( this.delivery_address_location != null ){
               form.append('address', this.delivery_address_location);
            }

            if( this.delivery_address_name != null && this.delivery_address_phone != null && this.delivery_address_location != null){
               var r = await this.request(form);
               if( r != undefined ){
                  var res = JSON.parse( JSON.stringify( r ));
                  if( res.err == false ){ 

                     // FOR UPDATE
                     if( this.delivery_actions == 'update' ){
                        this.delivery_address.forEach((e, index) => {
                           if( _primary == 1 ){
                              // ALL TO FALSE
                              e.primary = 0;
                           }
                           if( e.id == this.delivery_address_id ){
                              e.name = this.delivery_address_name;
                              e.phone = this.delivery_address_phone;
                              e.address = this.delivery_address_location;
                              e.primary = _primary;
                           }
                        });
                     }

                     // FOR ADD
                     if( this.delivery_actions == 'add' ){
                        // ALL TO FALSE
                        if( this.delivery_address.length > 0 && _primary == 1 ){
                           this.delivery_address.forEach((e, index) => {
                              e.primary = 0;
                           });
                        }
                        var obj = {
                           id: res.data,
                           name: this.delivery_address_name,
                           phone: this.delivery_address_phone,
                           address: this.delivery_address_location,
                           primary: _primary,
                        };
                        this.delivery_address.push(obj);
                     }

                     this.gotoDeliveryAddress();
                     // reset form
                     this.loading = false;
                     this.delivery_actions = null;
                     // console.log(this.delivery_address);
                  }
               }
            }else{
               setTimeout(function(){}, 1000);
               this.loading = false;
               this.delivery_actions = null;
            }


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

                  if( res.data.delivery_address != null ) {
                     this.delivery_address = res.data.delivery_address;
                  }
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
         gotoDeliveryAddressEdit( id_delivery ){ 
            this.navigator = 'delivery_address_edit'; 
         },
         gotoDeliveryAddressAdd(){ this.navigator = 'delivery_address_add';  },
         gotoSettings(){ this.previewAvatar= null; this.navigator = 'settings'; },
         gotoSupport(){ this.previewAvatar= null; this.navigator = 'support'; },
         gotoSupportAdd(){ this.previewAvatar= null; this.navigator = 'support-add'; },

      },

      async mounted(){
         await this.initUser();
      }

   })
   .component('delivery-address', PageDeliveryAddress)
   .mount('#app');
</script>

<?php 

get_footer();
