<div id='app'>
  <div v-if='!loading' class='business-delete-account-setting-page'>
    <?php get_template_part('pages/business/components/detailBar') ?>
    <div class='delete-account-setting-container'>
      <h3 class='delete-account-title'>Why do you want to delete your account?</h3>
      <fieldset @change='handleChangeFieldset'>
        <div class='checkbox-item-container'>
          <input type="radio" id='1' name='delete-account-questions' />
          <label for="1">I don't want to use WaterGo app anymore</label>
        </div>
        <div class='checkbox-item-container'>
          <input type="radio" id='2' name='delete-account-questions' />
          <label for="2">I want to create another account</label>
        </div>
        <div class='checkbox-item-container'>
          <input type="radio" id='3' name='delete-account-questions' />
          <label for="3">I have a privacy concern</label>
        </div>
        <div class='checkbox-item-container'>
          <input type="radio" id='4' name='delete-account-questions' />
          <label for="3">Other</label>
          <textarea v-if='isCheckOther' placeholder='Please tell us the reason'></textarea>
        </div>
      </fieldset>
      <div class='btn-container'>
        <button class='btn-reset cancel-btn' @click.stop='goBack'>Cancel</button>
        <button class='btn-reset continue-btn' @click='handleDeleteAccount'>Continue</button>
      </div>

      <!-- popup when submit success -->
      <div v-if='deleteAccountSuccess' class='success-popup'>
        <div class='popup-content'>
          <div class='popup-icon'>
          <svg xmlns="http://www.w3.org/2000/svg" width="24" height="32" viewBox="0 0 24 32" fill="none">
            <path d="M21 10.6667H19.5V7.61905C19.5 3.41333 16.14 0 12 0C7.86 0 4.5 3.41333 4.5 7.61905V10.6667H3C1.35 10.6667 0 12.0381 0 13.7143V28.9524C0 30.6286 1.35 32 3 32H21C22.65 32 24 30.6286 24 28.9524V13.7143C24 12.0381 22.65 10.6667 21 10.6667ZM12 24.381C10.35 24.381 9 23.0095 9 21.3333C9 19.6571 10.35 18.2857 12 18.2857C13.65 18.2857 15 19.6571 15 21.3333C15 23.0095 13.65 24.381 12 24.381ZM16.65 10.6667H7.35V7.61905C7.35 5.01333 9.435 2.89524 12 2.89524C14.565 2.89524 16.65 5.01333 16.65 7.61905V10.6667Z" fill="white"/>
          </svg>
          </div>
          <h3>We are sorry to see you leave</h3>
          <p>When you delete your account, you won't be able to log in again by deleted account.</p>
        </div>
        <div class='btn-container'>
          <button class='btn-reset cancel-btn' @click.stop='goBack'>Cancel</button>
          <button class='btn-reset continue-btn' @click.stop='goBack'>Continue</button>
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
        detailBarTitle: "Delete Account",
        isCheckOther: false,
        deleteAccountSuccess: false,
      }
    },
    methods: {
      goBack() {
        window.redirectBack();
      },
      handleChangeFieldset(event) {
        this.isCheckOther = false;
        if (event.target.id === '4') {
          this.isCheckOther = true;
        }
      },
      handleDeleteAccount() {
        this.deleteAccountSuccess = true;
      },
    },
    computed: {},
    async created() {
      this.loading = true;
      this.loading = false;
    }
  }).mount("#app");
</script>
