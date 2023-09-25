
<?php

function template_admin_support_user(){

   if(is_user_logged_in() == true ){
      $user_id = get_current_user_id();
      $user = get_user_by('id', $user_id);
      $prefix_user = 'user_' . $user->data->ID;
      if( !isset ($user->caps['administrator']) && $user->caps['administrator'] != 1 ){
         die();
      }
   }

   $action = isset($_GET['action']) ? $_GET['action'] : '';

   ?>

   <script type="text/javascript">
      var get_ajaxadmin = "<?php echo admin_url('admin-ajax.php'); ?>";;
   </script>
   <script src="https://cdn.tiny.cloud/1/no-api-key/tinymce/5/tinymce.min.js"></script>

   <script src="https://cdnjs.cloudflare.com/ajax/libs/axios/1.4.0/axios.min.js" integrity="sha512-uMtXmF28A2Ab/JJO2t/vYhlaa/3ahUOgj1Zf27M5rOo8/+fcTUVH0/E0ll68njmjrLqOBjXM3V9NiPFL5ywWPQ==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
   <script src="https://cdnjs.cloudflare.com/ajax/libs/vue/3.3.4/vue.global.min.js" integrity="sha512-Wbf9QOX8TxnLykSrNGmAc5mDntbpyXjOw9zgnKql3DgQ7Iyr5TCSPWpvpwDuo+jikYoSNMD9tRRH854VfPpL9A==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
   <script src='<?php echo THEME_URI . '/assets/js/common.js'; ?>'></script>

   <div id='app' class='wrap'>
      <h1 class="wp-heading-inline">Admin Support 
         <?php 
            if( $action == 'edit'){
               echo 'Edit';
            }
            if( $action == 'add'){
               echo 'Add';
            }
         ?>
      </h1>
      <?php if($action == "") echo '<a href="?page=admin_support_users&action=add" class="page-title-action">Add New</a>' ?>

      <hr class="wp-header-end">

      <?php if( $action == '' ){ ?>
      <table class='wp-list-table widefat fixed striped table-view-list posts'>
         <tr>
            <th class="manage-column column-title"><span>Title</span></th>
            <th class="manage-column column-date"><span>From App</span></th>
            <th class="manage-column column-date"><span>Date</span></th>
            <th class="manage-column column-date"><span>Is Answer Yet</span></th>
         </tr>
         <tr v-if='supports.length > 0' v-for='(support, index ) in supports ' :key='index'>
            <td class='title column-title has-row-actions column-primary page-title'>
               <a :href=" '?page=admin_support_users&id=' + support.id  + '&action=edit' ">
                  <span>{{ support.question }}</span>
               </a>
            </td>
            <td>
               <span>{{ get_select_app( support.select_app )}}</span>
            </td>
            <td>
               <span>{{ timestamp_to_date( support.time_created )}}</span>
            </td>
            <td>
               <span>{{ is_anwswer_yet( support.answer )}}</span>
            </td>
         </tr>
      </table>
      <?php } ?>

      <?php if( $action == 'edit' ){ ?>

         <div id="poststaff">
            <h2 class="wp-heading-inline">Question</h2>
            <div class="postbox-container">
               <textarea v-model='question' rows='5'></textarea>
            </div>

            <h2 class="wp-heading-inline">Answer</h2>
            <div class="postbox-container">
               <textarea id='my-custom-textarea' v-model='answer' rows='20'></textarea>
            </div>

            <div class="form-group checkbox-admin-support">
               <label class="form-checkbox mr15">
                  <input type="radio" v-model='selectedApp' value='user_app'>
                  <span class="text">User App</span>
               </label>
               <label class="form-checkbox mr15">
                  <input type='radio' v-model='selectedApp' value='business_app'>
                  <span class="text">Business App</span>
               </label>
            </div>

            <button @click='update' class="button button-primary button-large" :class='{ disabled: can_add == false }'>Update</button>

         </div>

      <?php }else if($action == "add"){ ?>
         <div id="poststaff">
            <h2 class="wp-heading-inline">Question</h2>
            <div class="postbox-container">
               <textarea v-model='question' rows='5' required></textarea>
            </div>

            <h2 class="wp-heading-inline">Answer</h2>
            <div class="postbox-container">
               <textarea id='my-custom-textarea' v-model='answer' rows='20' required></textarea>
            </div>

            <div class="form-group checkbox-admin-support">
               <label class="form-checkbox mr15">
                  <input type="radio" v-model='selectedApp' value='user_app'>
                  <span class="text">User App</span>
               </label>
               <label class="form-checkbox mr15">
                  <input type='radio' v-model='selectedApp' value='business_app'>
                  <span class="text">Business App</span>
               </label>
            </div>

            <button @click='add' class="button button-primary button-large" :class='{ disabled: can_add == false }'>Add</button>

         </div>
      <?php
      } ?>

   </div>
   <script>
      
      var app = Vue.createApp({
         data(){
            return {
               supports: [],
               paged: 0,
               question: '',
               answer: '',
               selectedApp: '',
               id: 0,
               can_add: false,
               tinymce: null
            }
         },

         watch: {
            question: function(data){this.check_all_field_is_empty();},
            answer: function(data){this.check_all_field_is_empty();},
            selectedApp: function(data){this.check_all_field_is_empty();},
         },

         methods: {

            get_select_app( select_app_text ){
               if(select_app_text == 'user_app') return 'User App';
               if(select_app_text == 'business_app') return 'Business App';
            },

            check_all_field_is_empty(){
               if( this.question == '' || this.answer == '' || this.selectedApp == ''){
                  this.can_add = false;
               }else{
                  this.can_add = true;
               }
            },

            timestamp_to_date(t){ return window.timestamp_to_date(t); },
            request(formdata){
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

            is_anwswer_yet(answer ){
               if( answer == undefined || answer == null || answer == '' ){
                  return 'No';
               }else{
                  return 'Yes';
               }
            },

            async update( ){
               // ?page=admin_support_all  
               if( this.can_add == true ){
                  var form = new FormData();
                  form.append('action', 'atlantis_update_user_admin_support');
                  form.append('id', this.id );
                  form.append('question', this.question );
                  form.append('answer', this.answer );
                  form.append('select_app', this.selectedApp)

                  var r = await this.request(form);
                  if( r != undefined ){
                     var res = JSON.parse( JSON.stringify( r ));
                     if( res.message == 'update_admin_supports_ok' ){
                        window.location.href = '?page=admin_support_users';
                     }
                  }
               }
            },

            async add(){
               // ?page=admin_support_all  

               if( this.can_add == true ) {
                  var form = new FormData();
                  form.append('action', 'atlantis_add_admin_support');
                  form.append('question', this.question );
                  form.append('answer', this.answer );
                  form.append('select_app', this.selectedApp)
                  var r = await this.request(form);
                  if( r != undefined ){
                     var res = JSON.parse( JSON.stringify( r ));
                     if( res.message == 'add_admin_supports_ok' ){
                        window.location.href = '?page=admin_support_users';
                     }
                  }
               }
            },

         },

         async created(){

            const urlParams   = new URLSearchParams(window.location.search);
            const id          = urlParams.get('id');
            const action      = urlParams.get('action');

            this.id = id;

            if( id != undefined && action != undefined && action == 'edit' ){

               var form = new FormData();
               form.append('action', 'atlantis_get_user_supports');
               form.append('id', id);
               var r = await this.request(form);
               if( r != undefined ){
                  var res = JSON.parse( JSON.stringify( r ));
                  if( res.message == 'admin_supports_found' ){
                     this.question     = res.data.question;
                     this.answer       = res.data.answer;
                     this.selectedApp  = res.data.select_app;

                  }
               }

            }else{

               var form = new FormData();
               form.append('action', 'atlantis_get_user_supports');
               var r = await this.request(form);
               if( r != undefined ){
                  var res = JSON.parse( JSON.stringify( r ));
                  if( res.message == 'admin_supports_found' ){
                     this.supports.push( ...res.data);
                  }
               }
            }

            // Wait for the DOM to be ready
            jQuery(document).ready(function () {
               // Initialize TinyMCE
               tinymce.init({
                  selector: "#my-custom-textarea",
                  plugins: "lists link",
                  menubar: true,
                  setup: function (editor) {
                     editor.setContent( window.app.answer );
                     editor.on('input change', function () {
                        var editorContent = editor.getContent();
                        window.app.answer = editorContent;
                        
                     });
                  }
               });
            });

         }
      }).mount('#app');
      window.app = app;

   </script>

   <style>
      .postbox-container{
         width: 100%;
      }
      .postbox-container textarea{
         width: 100%;
      }
      .wp-core-ui .button.button-large{
         margin-top: 30px;
      }
      .mr15{
         margin-right: 15px;
      }
      .checkbox-admin-support{
         display: block;
         clear: both;
         padding-top: 18px;
      }
      .tox-notifications-container{display: none;}
   </style>

   <?php
}