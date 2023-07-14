<div id='app'>
  <div v-if='!loading' class='business-setting-page'>
    <?php get_template_part('pages/business/components/detailBar') ?>
    <div class='setting-container'>
      <div class='setting-item'>
        <h3 class='section-title'>Language</h3>
        <span class='section-subtitle'>Vietnammese</span>
        <div class='settings-btn' @click='handleGoToLanguageSetting'>
          <svg xmlns="http://www.w3.org/2000/svg" width="8" height="12" viewBox="0 0 8 12" fill="none">
            <path d="M0 10.59L4.58 6L0 1.41L1.41 0L7.41 6L1.41 12L0 10.59Z" fill="#252831"/>
          </svg>
        </div>
      </div>
      <div class='setting-item'>
        <h3 class='section-title'>Password</h3>
        <div class='settings-btn' @click='handleGoToChangePasswordSetting'>
          <svg xmlns="http://www.w3.org/2000/svg" width="8" height="12" viewBox="0 0 8 12" fill="none">
            <path d="M0 10.59L4.58 6L0 1.41L1.41 0L7.41 6L1.41 12L0 10.59Z" fill="#252831"/>
          </svg>
        </div>
      </div>
      <div class='setting-item'>
        <h3 class='section-title'>Delete Account</h3>
        <div class='settings-btn' @click='handleGoToDeleteAccountSetting'>
          <svg xmlns="http://www.w3.org/2000/svg" width="8" height="12" viewBox="0 0 8 12" fill="none">
            <path d="M0 10.59L4.58 6L0 1.41L1.41 0L7.41 6L1.41 12L0 10.59Z" fill="#252831"/>
          </svg>
        </div>
      </div>
      <div class='setting-item'>
        <h3 class='section-title'>Log Out</h3>
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
  const { createApp } = Vue;

  createApp({
    data() {
      return {
        loading: false,
        detailBarTitle: "Settings",
      }
    },
    methods: {
      goBack() {
        window.redirectBack();
      },
      handleGoToLanguageSetting() {
        window.redirectTo('business?business_page=setting&setting_page=language_setting');
      },
      handleGoToChangePasswordSetting() {
        window.redirectTo('business?business_page=setting&setting_page=change_password');
      },
      handleGoToDeleteAccountSetting() {
        window.redirectTo('business?business_page=setting&setting_page=delete_account');
      },
    },
    computed: {},
    async created() {
      this.loading = true;
      this.loading = false;
    }
  }).mount("#app");
</script>
