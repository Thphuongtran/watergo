<div class='page-user-support'>

   <div class='inner'>
      <div class='page-appbar'>
         <div class='on-left'>

            <button @click='gotoProfile' class='btn-back'>
               <img width='18' src='<?php echo THEME_URI . '/assets/images/button-back.png'; ?>'>
            </button>

            <p class='title'>WaterGo Support</p>
         </div>
         <div class='on-right'>
            <div class='actions auto-resize'>
               <div class='btn-icon'>
                  <img width='20' src="<?php echo THEME_URI . '/assets/images/icon-support-notification.png'; ?>" alt="Notification">
                  <span class='badge-circle'></span>
               </div>
            </div>
         </div>
      </div>

      <div class='user-support-form-add'>
         <p>Your Question</p>
         <textarea v-name='user_support_question' placeholder='Enter your question'></textarea>
      </div>
      
   </div>

   <div class='support-bottomsheet'>
      <button class='button style01'>Send Message</button>
   </div>




   <!-- icon-support-search.png -->
</div>