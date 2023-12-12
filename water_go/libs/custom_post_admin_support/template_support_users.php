<?php

function template_support_users(){

   $event = isset($_GET['event']) ? $_GET['event'] : '';
   $id = isset($_GET['id']) ? $_GET['id'] : '';

   $paged = isset($_GET['paged']) ? $_GET['paged'] : 1;
   $limit = 50;
   $paged = $paged - 1;

   if( $paged < 1 || $paged == 0){
      $paged = 0;
   }

   $paged = $paged * $limit;

   $supports = [];

   if( $event == '' ){
      global $wpdb;
      $sql = "SELECT * FROM wp_watergo_supports WHERE page_manager = 'user' ORDER BY time_created DESC, id DESC LIMIT $paged, $limit";
      $supports = $wpdb->get_results( $sql);
   }

   $page_manager = 'user';

   $supports = json_encode( $supports, true, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE );

   
?>
   <script src="https://cdn.tiny.cloud/1/no-api-key/tinymce/5/tinymce.min.js"></script>
   <script type="text/javascript">
      var get_ajaxadmin = "<?php echo admin_url('admin-ajax.php'); ?>";
   </script>
   <script src="<?php echo THEME_URI . '/assets/js/vue.global.min.js' ?>"></script>
   <script src="<?php echo THEME_URI . '/assets/js/axios.min.js' ?>"></script>
   <script src="<?php echo THEME_URI . '/assets/js/common.min.js' ?>"></script>

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
      .tox-tinymce{
         min-height: 400px;
      }

      .disable_action{
         touch-action: none;
         pointer-events: none;
         opacity: 0.6;
      }
      
   </style>

   <div id='app' class='wrap'>
      <h1 class="wp-heading-inline">Users Page</h1>

      <!-- NON ACTION -->

      <hr class="wp-header-end">

      <table v-show='event == ""' class='wp-list-table widefat fixed striped table-view-list posts' style='margin-top: 30px;'>
         <tr>
            <th class="manage-column column-title"><span>Title</span></th>
            <th class="manage-column column-title"><span>Date</span></th>
            <th class="manage-column column-date"><span>Is Answer Yet</span></th>
         </tr>
         <tr v-if='supports.length > 0' v-for='(support, index ) in supports ' :key='index'>
            <td class='title column-title has-row-actions column-primary page-title'>
               <a :href=" '?page=page_support_users&id=' + support.id  + '&event=edit' ">
                  <span>{{ support.question }}</span>
               </a>
            </td>
            <td>
               {{ timestamp_to_date(support.time_created) }}
            </td>
            <td>
               <span v-show='support.time_answer != null'>Yes</span>
               <span v-show='support.time_answer == null'>No</span>
            </td>
         </tr>
      </table>


      <!-- END NON ACTION  -->

      <!-- ACTION ADD | EDIT -->

      <div v-show='event == "edit"' id="poststaff">
         <h2 class="wp-heading-inline">Question</h2>
         <div class="postbox-container">
            <textarea v-model='question' rows='5' readonly></textarea>
         </div>

         <h2 class="wp-heading-inline">Answer</h2>
         <div class="postbox-container">
            <textarea id='my-custom-textarea' v-model='answer' rows='10'></textarea>
         </div>

         <button v-if='event == "add"' @click='admin_add_question' class="button button-primary button-large" :class='is_can_access == false ? "disable_action" : ""'>Add</button>
         <button v-if='event == "edit"' @click='admin_edit_question' class="button button-primary button-large" :class='is_can_access == false ? "disable_action" : ""'>Update</button>
      </div>
      <!-- END ACTION ADD | EDIT -->


   </div>

   <script>
      
      var app = Vue.createApp({
         data(){
            return {

               supports: [],

               question: '',
               answer: '',
               can_access: false,
               tinymce: null,

               id: 0, // for edit

               event: '',
            }
         },

         watch: {
            
         },

         computed: {

            // LISTENABLE
            is_can_access(){
               if( this.question != '' && this.answer != '' ){
                  this.can_access = true;
                  return true;
               }else{
                  this.can_access = false;
                  return false;
               }
            }
         },

         methods: {

            timestamp_to_date(t){ return window.timestamp_to_date(t); },

            async admin_edit_question(){
               if( this.can_access == true ){
                  var form = new FormData();
                  form.append('action', 'atlantis_action_question_from_admin_page');
                  form.append('id', this.id );
                  form.append('question', this.question );
                  form.append('answer', this.answer );
                  form.append('event', 'edit');               
                  form.append('page_manager', '<?php echo $page_manager ?>');
                  var r = await window.request(form);
                  window.location.href = '?page=page_support_users';
               }
            },

            async admin_get_question(id){

               if( id == null ){ id = this.id; }
               var form = new FormData();
               form.append('action', 'atlantis_action_question_from_admin_page');
               form.append('id', this.id );
               form.append('event', 'get');
               var r = await window.request(form);
               if( r != undefined ){
                  var res = JSON.parse( JSON.stringify( r ));
                  if( res.message == 'question_found' ){
                     this.question = res.data.question;
                     if( res.data.answer != null ){
                        this.answer = res.data.answer;
                     }
                     this.id = res.data.id;
                  }
               }
               
            },

         },

         async created(){

            // INSTANCE

            this.event = '<?php echo $event; ?>';
            this.supports = JSON.parse(JSON.stringify(<?php echo $supports; ?>));
            this.id = '<?php echo $id; ?>';

            if( this.event == 'edit' ){
               // setup data
               await this.admin_get_question(this.id);
            }

            jQuery(document).ready(function () {
               // Initialize TinyMCE
               tinymce.init({
                  selector: "#my-custom-textarea",
                  plugins: "lists link",
                  menubar: true,
                  setup: function (editor) {
                     // editor.setContent( instanceApp.answer );
                     editor.setContent( window.app.answer );
                     editor.on('input change', function () {
                        var editorContent = editor.getContent();
                        window.app.answer = editorContent;
                     });
                  }
               });

               // DO IT LATER
               if( jQuery('.tox-notifications-container').length != 0 ){
                  jQuery('.tox-notifications-container').hide();
               }

            });


            

         }

      }).mount('#app');

      window.app = app;

   </script>
   <style>
      .tox-notifications-container{display: none !important;}
   </style>
<?php
}