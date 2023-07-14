<div id='app'>
  <div v-if='!loading'>
    <?php get_template_part('pages/business/report/report-appBar') ?>
    <div class='business-store-page'>
      <div class='profile-section'>
        <div class='profile-image'>
          <img v-bind:src="storeImage" alt="profile image" />
        </div>
        <div class='profile-title'>
          <h2>{{storeName}}</h2>
          <button @click='handleGotoProfileStore'>
            View Store
            <span>
            <svg xmlns="http://www.w3.org/2000/svg" width="7" height="12" viewBox="0 0 7 12" fill="none">
              <path d="M1 11L6 6L1 1" stroke="#2790F9" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
            </svg>
            </span>
          </button>
        </div>
      </div>
      <div class='section notification-section'>
        <div class='notification-icon'>
          <svg xmlns="http://www.w3.org/2000/svg" width="28" height="28" viewBox="0 0 28 28" fill="none">
            <circle cx="14" cy="14" r="14" fill="#2790F9"/>
            <path d="M19.6749 17.7604C20.0378 18.322 20.4716 18.8343 20.9654 19.2846V19.6578H7.7V19.2837C8.18789 18.8312 8.61585 18.3179 8.97336 17.7564L8.99109 17.7286L9.00612 17.6992C9.42542 16.8792 9.67673 15.9838 9.74531 15.0655L9.74725 15.0394V15.0133L9.74726 12.5822L9.74725 12.5808C9.745 11.4635 10.1477 10.3832 10.8809 9.54009C11.614 8.69694 12.6279 8.14806 13.7346 7.99509L14.3106 7.91548L14.8641 7.98619C15.9809 8.12888 17.0071 8.67447 17.75 9.52045C18.4929 10.3664 18.9013 11.4546 18.8985 12.5805V12.5822V15.0133V15.0394L18.9004 15.0655C18.969 15.9838 19.2203 16.8792 19.6396 17.6992L19.6557 17.7307L19.6749 17.7604Z" fill="white" stroke="white" stroke-width="1.4"/>
            <path d="M13.0385 20.8745C13.0816 21.1865 13.2362 21.4723 13.4736 21.6791C13.7111 21.886 14.0154 21.9999 14.3303 21.9999C14.6452 21.9999 14.9495 21.886 15.1869 21.6791C15.4244 21.4723 15.579 21.1865 15.6221 20.8745H13.0385Z" fill="white"/>
          </svg>
        </div>
        <h3 class='section-title'>Notification</h3>
        <div class='notification-toggle-btn'>
          <label class="switch">
            <input type="checkbox">
            <span class="slider round"></span>
          </label>
        </div>
      </div>
      <div class='section reminder-section'>
        <div class='reminder-icon'>
          <svg xmlns="http://www.w3.org/2000/svg" width="28" height="28" viewBox="0 0 28 28" fill="none">
            <circle cx="14" cy="14" r="14" fill="#2790F9"/>
            <path d="M19.2 11.6C20.744 11.6 22 10.344 22 8.8C22 7.256 20.744 6 19.2 6C17.656 6 16.4 7.256 16.4 8.8C16.4 10.344 17.656 11.6 19.2 11.6ZM19.2 13.2C19.6 13.2 20 13.144 20.4 13.032V18C20.4 20.208 18.608 22 16.4 22H10C7.792 22 6 20.208 6 18V11.6C6 9.392 7.792 7.6 10 7.6H14.968C14.782 8.25441 14.7503 8.94305 14.8755 9.61176C15.0008 10.2805 15.2794 10.911 15.6896 11.4538C16.0998 11.9965 16.6303 12.4367 17.2394 12.7398C17.8485 13.0428 18.5197 13.2003 19.2 13.2Z" fill="white"/>
          </svg>
        </div>
        <h3 class='section-title'>Reminder Settings</h3>
        <div class='reminder-btn' @click='handleGoToReminderSettingPage'>
          <svg xmlns="http://www.w3.org/2000/svg" width="8" height="12" viewBox="0 0 8 12" fill="none">
            <path d="M0 10.59L4.58 6L0 1.41L1.41 0L7.41 6L1.41 12L0 10.59Z" fill="#252831"/>
          </svg>
        </div>
      </div>
      <div class='section support-section'>
        <div class='support-icon'>
          <svg xmlns="http://www.w3.org/2000/svg" width="28" height="28" viewBox="0 0 28 28" fill="none">
            <circle cx="14" cy="14" r="14" fill="#2790F9"/>
            <path d="M21.7882 17.5057C21.7878 18.5545 21.4293 19.5718 20.772 20.3891C20.1146 21.2064 19.1979 21.7747 18.1735 22L17.6842 20.5321C18.1323 20.4583 18.5584 20.286 18.9319 20.0276C19.3054 19.7693 19.6169 19.4313 19.844 19.0381H17.9534C17.5466 19.0381 17.1565 18.8765 16.8688 18.5888C16.5812 18.3011 16.4195 17.911 16.4195 17.5042V14.4364C16.4195 14.0296 16.5812 13.6394 16.8688 13.3518C17.1565 13.0641 17.5466 12.9025 17.9534 12.9025H20.2067C20.0196 11.4199 19.2978 10.0566 18.1769 9.0683C17.0561 8.08001 15.6131 7.53471 14.1187 7.53471C12.6244 7.53471 11.1814 8.08001 10.0605 9.0683C8.9396 10.0566 8.21786 11.4199 8.03071 12.9025H10.284C10.6908 12.9025 11.081 13.0641 11.3686 13.3518C11.6563 13.6394 11.8179 14.0296 11.8179 14.4364V17.5042C11.8179 17.911 11.6563 18.3011 11.3686 18.5888C11.081 18.8765 10.6908 19.0381 10.284 19.0381H7.98316C7.57634 19.0381 7.18619 18.8765 6.89853 18.5888C6.61087 18.3011 6.44927 17.911 6.44927 17.5042V13.6694C6.44927 9.43361 9.88288 6 14.1187 6C18.3545 6 21.7882 9.43361 21.7882 13.6694V17.5057Z" fill="white"/>
          </svg>
        </div>
        <h3 class='section-title'>Support</h3>
        <div class='support-btn' @click='handleGoToSupportPage'>
          <svg xmlns="http://www.w3.org/2000/svg" width="8" height="12" viewBox="0 0 8 12" fill="none">
            <path d="M0 10.59L4.58 6L0 1.41L1.41 0L7.41 6L1.41 12L0 10.59Z" fill="#252831"/>
          </svg>
        </div>
      </div>
      <div class='section advertising-section'>
        <div class='Advertising-icon'>
          <svg xmlns="http://www.w3.org/2000/svg" width="28" height="28" viewBox="0 0 28 28" fill="none">
            <circle cx="14" cy="14" r="14" fill="#2790F9"/>
            <path d="M21.7882 17.5057C21.7878 18.5545 21.4293 19.5718 20.772 20.3891C20.1146 21.2064 19.1979 21.7747 18.1735 22L17.6842 20.5321C18.1323 20.4583 18.5584 20.286 18.9319 20.0276C19.3054 19.7693 19.6169 19.4313 19.844 19.0381H17.9534C17.5466 19.0381 17.1565 18.8765 16.8688 18.5888C16.5812 18.3011 16.4195 17.911 16.4195 17.5042V14.4364C16.4195 14.0296 16.5812 13.6394 16.8688 13.3518C17.1565 13.0641 17.5466 12.9025 17.9534 12.9025H20.2067C20.0196 11.4199 19.2978 10.0566 18.1769 9.0683C17.0561 8.08001 15.6131 7.53471 14.1187 7.53471C12.6244 7.53471 11.1814 8.08001 10.0605 9.0683C8.9396 10.0566 8.21786 11.4199 8.03071 12.9025H10.284C10.6908 12.9025 11.081 13.0641 11.3686 13.3518C11.6563 13.6394 11.8179 14.0296 11.8179 14.4364V17.5042C11.8179 17.911 11.6563 18.3011 11.3686 18.5888C11.081 18.8765 10.6908 19.0381 10.284 19.0381H7.98316C7.57634 19.0381 7.18619 18.8765 6.89853 18.5888C6.61087 18.3011 6.44927 17.911 6.44927 17.5042V13.6694C6.44927 9.43361 9.88288 6 14.1187 6C18.3545 6 21.7882 9.43361 21.7882 13.6694V17.5057Z" fill="white"/>
          </svg>
        </div>
        <h3 class='section-title'>Advertising inquery</h3>
        <div class='Advertising-btn'>
          <svg xmlns="http://www.w3.org/2000/svg" width="8" height="12" viewBox="0 0 8 12" fill="none">
            <path d="M0 10.59L4.58 6L0 1.41L1.41 0L7.41 6L1.41 12L0 10.59Z" fill="#252831"/>
          </svg>
        </div>
      </div>
      <div class='section settings-section'>
        <div class='settings-icon'>
          <svg xmlns="http://www.w3.org/2000/svg" width="28" height="28" viewBox="0 0 28 28" fill="none">
            <circle cx="14" cy="14" r="14" fill="#2790F9"/>
            <path d="M21.7882 17.5057C21.7878 18.5545 21.4293 19.5718 20.772 20.3891C20.1146 21.2064 19.1979 21.7747 18.1735 22L17.6842 20.5321C18.1323 20.4583 18.5584 20.286 18.9319 20.0276C19.3054 19.7693 19.6169 19.4313 19.844 19.0381H17.9534C17.5466 19.0381 17.1565 18.8765 16.8688 18.5888C16.5812 18.3011 16.4195 17.911 16.4195 17.5042V14.4364C16.4195 14.0296 16.5812 13.6394 16.8688 13.3518C17.1565 13.0641 17.5466 12.9025 17.9534 12.9025H20.2067C20.0196 11.4199 19.2978 10.0566 18.1769 9.0683C17.0561 8.08001 15.6131 7.53471 14.1187 7.53471C12.6244 7.53471 11.1814 8.08001 10.0605 9.0683C8.9396 10.0566 8.21786 11.4199 8.03071 12.9025H10.284C10.6908 12.9025 11.081 13.0641 11.3686 13.3518C11.6563 13.6394 11.8179 14.0296 11.8179 14.4364V17.5042C11.8179 17.911 11.6563 18.3011 11.3686 18.5888C11.081 18.8765 10.6908 19.0381 10.284 19.0381H7.98316C7.57634 19.0381 7.18619 18.8765 6.89853 18.5888C6.61087 18.3011 6.44927 17.911 6.44927 17.5042V13.6694C6.44927 9.43361 9.88288 6 14.1187 6C18.3545 6 21.7882 9.43361 21.7882 13.6694V17.5057Z" fill="white"/>
          </svg>
        </div>
        <h3 class='section-title'>Settings</h3>
        <div class='settings-btn' @click='handleGoToSettingPage'>
          <svg xmlns="http://www.w3.org/2000/svg" width="8" height="12" viewBox="0 0 8 12" fill="none">
            <path d="M0 10.59L4.58 6L0 1.41L1.41 0L7.41 6L1.41 12L0 10.59Z" fill="#252831"/>
          </svg>
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
    data() {
      return {
        loading: false,
        pageTitle: "Store",
        storeImage: "",
        storeName: "",
        isNotification: false,
      }
    },
    methods: {
      handleGotoProfileStore() {
        window.redirectTo('business?business_page=store&store_page=store_profile');
      },
      handleGoToSettingPage() {
        window.redirectTo('business?business_page=setting');
      },
      handleGoToReminderSettingPage() {
        window.redirectTo('business?business_page=setting&setting_page=reminder_setting');
      },
      handleGoToSupportPage() {
        window.redirectTo('business?business_page=support');
      }
    },
    computed: {},
    async created() {
      this.loading = true;
      this.storeImage = 'https://89khamthien.com/wp-content/uploads/2021/10/Jagermeister-56.jpg';
      this.storeName = 'Store 1';
      this.isNotification = true;
      this.loading = false;
    },
  }).mount("#app");
</script>