<div class='page-settings' :class='settings_actions == null ? "extra-color" : ""'>
   
   <div class='appbar'>
      <div class='leading'>
         <button v-if='settings_actions == null' @click='gotoProfile' class='btn-action'>
            <svg width="20" height="16" viewBox="0 0 20 16" fill="none" xmlns="http://www.w3.org/2000/svg">
            <path fill-rule="evenodd" clip-rule="evenodd" d="M0 8C0 7.44772 0.447715 7 1 7H18.5C19.0523 7 19.5 7.44772 19.5 8C19.5 8.55228 19.0523 9 18.5 9H1C0.447715 9 0 8.55228 0 8Z" fill="#252831"/>
            <path fill-rule="evenodd" clip-rule="evenodd" d="M10.5309 0.375342C10.8759 0.806604 10.806 1.4359 10.3747 1.78091L2.60078 8.00004L10.3747 14.2192C10.806 14.5642 10.8759 15.1935 10.5309 15.6247C10.1859 16.056 9.55657 16.1259 9.12531 15.7809L0.375305 8.78091C0.13809 8.59113 0 8.30382 0 8.00004C0 7.69625 0.13809 7.40894 0.375305 7.21917L9.12531 0.219168C9.55657 -0.125842 10.1859 -0.0559202 10.5309 0.375342Z" fill="#252831"/>
            </svg>
         </button>

         <button v-if='settings_actions != null' @click='navigatorSettingsBack' class='btn-action'>
            <svg width="20" height="16" viewBox="0 0 20 16" fill="none" xmlns="http://www.w3.org/2000/svg">
            <path fill-rule="evenodd" clip-rule="evenodd" d="M0 8C0 7.44772 0.447715 7 1 7H18.5C19.0523 7 19.5 7.44772 19.5 8C19.5 8.55228 19.0523 9 18.5 9H1C0.447715 9 0 8.55228 0 8Z" fill="#252831"/>
            <path fill-rule="evenodd" clip-rule="evenodd" d="M10.5309 0.375342C10.8759 0.806604 10.806 1.4359 10.3747 1.78091L2.60078 8.00004L10.3747 14.2192C10.806 14.5642 10.8759 15.1935 10.5309 15.6247C10.1859 16.056 9.55657 16.1259 9.12531 15.7809L0.375305 8.78091C0.13809 8.59113 0 8.30382 0 8.00004C0 7.69625 0.13809 7.40894 0.375305 7.21917L9.12531 0.219168C9.55657 -0.125842 10.1859 -0.0559202 10.5309 0.375342Z" fill="#252831"/>
            </svg>
         </button>

         <p class='leading-title'>
            {{ settings_actions == null ? "Settings" : "" }}
            {{ settings_actions == "language" ? "Language" : "" }}
            {{ settings_actions == "password" ? "Change Password" : "" }}
            {{ settings_actions == "delete_account" ? "Delete Account" : "" }}
         </p>
      </div> 
      
   </div>


   <div class='inner'>
      <ul v-if='settings_actions == null' class='list-settings'>
         <li @click='updateUserNotification' class='no-arrow'>
            <span class='title'>Notification</span>
            <span class='subtitle'>
               <label class="toggle-switch">
                  <input type="checkbox" v-model='user_notification' >
                  <span class="slider"></span>
               </label>
            </span>
         </li>
         <li @click='userChangeLanguages'>
            <span class='title'>Language</span>
            <span class='subtitle'>{{ user_language }}</span>
         </li>
         <li @click='userChangePassword'>
            <span class='title'>Password</span>
         </li>
         <li @click='userDeleteAccount'>
            <span class='title'>Delete Account</span>
         </li>
         <li @click='buttonOpenModalLogout'>
            <span class='title'>Log Out</span>
         </li>
      </ul>
      
      <!-- CHANGE LANGUAGES -->
      <div v-if='settings_actions == "language" '>
         <ul class='list-settings style01'>

            <li @click='updateUserLanguage(language)' class='no-arrow' v-for='(language , index) in settings_language' :key='index'>
               <span class='title'><span class='radio-button small' :class='language == user_language ? "active" : ""'></span>{{ language }}</span>
            </li>
         </ul>
      </div>

      <!-- CHANGE PASSWORD -->
      <div v-if='settings_actions == "password" '>
         <div class='page-change-password'>

            <div class='box-justify-between'>
               
               <div class='form-wrapper'>
                  <div class='form-group02'>
                     <div class='label-style02'>Current Password</div>
                     <input class='input-style02' v-model='settings_current_password' type="password" placeholder='Enter current password'>
                  </div>
                  <div class='form-group02'>
                     <div class='label-style02'>New Password</div>
                     <input class='input-style02' v-model='settings_new_password' type="password" placeholder='Enter new password'>
                  </div>
                  <div class='form-group02'>
                     <div class='label-style02'>Confirm New Password</div>
                     <input class='input-style02' v-model='settings_confirm_password' type="password" placeholder='Enter new password'>
                  </div>
               </div>

               <button class='button'>Save</button>

            </div>
         </div>
      </div>

      <!-- DELETE ACCOUNT -->
      <div v-if='settings_actions == "delete_account" '>
         <div class='page-delete-account'>
            <div class='box-justify-between'>
               <div v-if='settings_delete_account_step == 0' class='contents-wrapper'>
                  <p class='heading'>Why do you want to delete your account?</p>
                  <ul class='list-delete-account'>
                     <li @click='buttonUserSettingsQuestionSelected(index)' v-for='(question, index) in settings_delete_account_question' :key='index'>
                        <div class='leading'><span class='radio-button small' :class='settings_delete_account_question_selected == index ? "active" : ""'></span></div>
                        <span class='text'>{{ question }}</span>
                     </li>

                     <li v-if='settings_delete_account_question_selected == 3'>
                        <textarea v-model='settings_delete_account_question_other' placeholder='Please tell us the reason'></textarea>
                     </li>

                  </ul>
               </div>

               <div v-if='settings_delete_account_step == 1' class='banner-notify'>
                  <div class='notify-wrapper'>
                     <img width='80' src='<?php echo THEME_URI . '/assets/images/icon-password.png'; ?>'>
                     <p class='heading style01'>We are sorry to see you leave</p>
                     <p class='text'>When you delete your account, you won't <br>be able to log in again by deleted account.</p>
                  </div>
               </div>


               <div class='group-button-horizontal'>
                  <button class='button btn-cancel'>Cancel</button>
                  <button @click='buttonUserDeleteAccount' class='button-outline btn-continue'>Continue</button>
               </div>
            </div>

         </div>
      </div>
   </div>

   
</div>