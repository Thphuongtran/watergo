<div id='app'>
  <div v-if='!loading' class='business-change-password-setting-page'>
    <?php get_template_part('pages/business/components/detailBar') ?>
    <div class='change-password-setting-container'>
      <div class='password-input-container'>
        <label>Current Password</label>
        <input type="password" placeholder='Enter current password' />
      </div>
      <div class='password-input-container'>
        <label>New Password</label>
        <input type="password" placeholder='Enter new password' />
      </div>
      <div class='password-input-container'>
        <label>Confirm New Password</label>
        <input type="password" placeholder='Enter new password' />
      </div>
      <div class='save-btn-container'>
        <button class='save-btn btn-reset' @click='handleUpdatePassword'>Save</button>
      </div>
    </div>

    <!-- popup when password updated successfully -->
    <div v-if='isUpdatedSuccess' class='password-updated-success-popup'>
      <div class='content'>
        <div class='icon-success'>
          <svg xmlns="http://www.w3.org/2000/svg" width="26" height="20" viewBox="0 0 26 20" fill="none">
            <path fill-rule="evenodd" clip-rule="evenodd" d="M25.7917 2.82884L23.103 0.140137L8.85776 14.3854L3.25218 8.77981L0.563477 11.4685L8.95063 19.8557L11.6393 17.167L11.5465 17.0741L25.7917 2.82884Z" fill="white"/>
          </svg>
        </div>
        <h2>Password Changed</h2>
        <p>Your password has been changed successfully</p>
      </div>
      <div class='exit-btn-container'>
        <button class='btn-reset exit-btn' @click='handleExitSuccessPopup'>Exit</button>
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
  const { createApp } = Vue;

  createApp({
    data() {
      return {
        loading: false,
        detailBarTitle: "Change Password",
        isUpdatedSuccess: false,
      }
    },
    methods: {
      goBack() {
        window.redirectBack();
      },
      handleUpdatePassword() {
        this.isUpdatedSuccess = true;
      },
      handleExitSuccessPopup() {
        window.redirectTo('business?business_page=setting');
      }
    },
    computed: {},
    async created() {
      this.loading = true;
      this.loading = false;
    }
  }).mount("#app");
</script>
