<div id='app'>
   <div v-if='loading == false' class='page-review-form'>

      <div class='appbar'>
         <div class='appbar-top'>
            <div class='leading'>
               <button @click='goBack' class='btn-action'>
                  <svg width="20" height="16" viewBox="0 0 20 16" fill="none" xmlns="http://www.w3.org/2000/svg">
                     <path fill-rule="evenodd" clip-rule="evenodd" d="M0 8C0 7.44772 0.447715 7 1 7H18.5C19.0523 7 19.5 7.44772 19.5 8C19.5 8.55228 19.0523 9 18.5 9H1C0.447715 9 0 8.55228 0 8Z" fill="#252831"/>
                     <path fill-rule="evenodd" clip-rule="evenodd" d="M10.5309 0.375342C10.8759 0.806604 10.806 1.4359 10.3747 1.78091L2.60078 8.00004L10.3747 14.2192C10.806 14.5642 10.8759 15.1935 10.5309 15.6247C10.1859 16.056 9.55657 16.1259 9.12531 15.7809L0.375305 8.78091C0.13809 8.59113 0 8.30382 0 8.00004C0 7.69625 0.13809 7.40894 0.375305 7.21917L9.12531 0.219168C9.55657 -0.125842 10.1859 -0.0559202 10.5309 0.375342Z" fill="#252831"/>
                  </svg>
               </button>
               <p class='leading-title'><?php echo __('Delete Account', 'watergo' ); ?></p>
            </div>
         </div>
      </div>

      <div class='inner'>

         <div class='page-delete-account'>
            <div class='box-justify-between'>

               <div v-show='settings_delete_account_step == 0' class='contents-wrapper'>
                  <p class='heading'><?php echo __('Why do you want to delete your account', 'watergo'); ?>?</p>
                  <ul class='list-delete-account'>

                     <li @click='buttonUserSettingsQuestionSelected(0)'>
                        <div class='radio-button small' :class='settings_delete_account_question_selected == 0 ? "active" : ""'></div>
                        <span class='text'><?php echo __("I don't want to use WaterGo app anymore", 'watergo'); ?></span>
                     </li>
                     <li @click='buttonUserSettingsQuestionSelected(1)'>
                        <div class='radio-button small' :class='settings_delete_account_question_selected == 1 ? "active" : ""'></div>
                        <span class='text'><?php echo __("I want to create another account", 'watergo'); ?></span>
                     </li>
                     <li @click='buttonUserSettingsQuestionSelected(2)'>
                        <div class='radio-button small' :class='settings_delete_account_question_selected == 2 ? "active" : ""'></div>
                        <span class='text'><?php echo __("I have a privacy concern", 'watergo'); ?></span>
                     </li>
                     <li @click='buttonUserSettingsQuestionSelected(3)'>
                        <div class='radio-button small' :class='settings_delete_account_question_selected == 3 ? "active" : ""'></div>
                        <span class='text'><?php echo __("Other", 'watergo'); ?></span>
                     </li>

                     <li v-if='settings_delete_account_question_selected == 3'>
                        <textarea v-model='settings_delete_account_question_other' placeholder='<?php echo __('Please tell us the reason', 'watergo');?>'></textarea>
                     </li>

                  </ul>
               </div>

               <div v-show='settings_delete_account_step == 1' class='banner-notify'>
                  <div class='notify-wrapper'>
                     <svg width="80" height="80" viewBox="0 0 80 80" fill="none" xmlns="http://www.w3.org/2000/svg"><circle cx="40" cy="40" r="40" fill="#2790F9"/><path d="M49 34.6667H47.5V31.619C47.5 27.4133 44.14 24 40 24C35.86 24 32.5 27.4133 32.5 31.619V34.6667H31C29.35 34.6667 28 36.0381 28 37.7143V52.9524C28 54.6286 29.35 56 31 56H49C50.65 56 52 54.6286 52 52.9524V37.7143C52 36.0381 50.65 34.6667 49 34.6667ZM40 48.381C38.35 48.381 37 47.0095 37 45.3333C37 43.6571 38.35 42.2857 40 42.2857C41.65 42.2857 43 43.6571 43 45.3333C43 47.0095 41.65 48.381 40 48.381ZM44.65 34.6667H35.35V31.619C35.35 29.0133 37.435 26.8952 40 26.8952C42.565 26.8952 44.65 29.0133 44.65 31.619V34.6667Z" fill="white"/></svg>
                     <p class='heading'><?php echo __('We are sorry to see you leave', 'watergo'); ?></p>
                     <p class='text'><?php echo __("When you delete your account, you won't <br>be able to log in again by deleted account.", 'watergo'); ?></p>
                  </div>
               </div>


               <div class='btn-fixed bottom style01'>
                  <button @click='buttonUserCancelDeleteAccount' class='btn btn-outline'><?php echo __('Cancel', 'watergo'); ?></button>
                  <button @click='buttonUserDeleteAccount' class='btn btn-primary'><?php echo __('Continue', 'watergo'); ?></button>
               </div>
            </div>
         </div>


      </div>

   </div>

</div>

<script type='module'>

var { createApp } = Vue;

createApp({
   data (){
      return {
         loading: false,
         settings_delete_account_step: 0,

         settings_delete_account_question: [
            "I don\'t want to use WaterGo app anymore",
            'I want to create another account',
            'I have a privacy concern',
            'Other'
         ],
         settings_delete_account_question_selected: 0,
         settings_delete_account_question_other: '',
      }
   },

   methods: {
      buttonUserCancelDeleteAccount(){
         if( this.settings_delete_account_step == 0 ){
            this.goBack();
         }
         this.settings_delete_account_step = 0;
      },

      buttonUserDeleteAccount(){
         this.settings_delete_account_step = 1;
      },

      buttonUserSettingsQuestionSelected( index ){
         this.settings_delete_account_question_selected = index;
      },

      goBack(){ window.goBack();}
   },

   async created(){

      window.appbar_fixed();
      
   }

}).mount('#app');
</script>