<div id='app'>
  <div v-if='!loading' class='business-reminder-setting-page'>
    <?php get_template_part('pages/business/components/detailBar') ?>
    <div class='reminder-setting-container'>
      <div class='reminder-setting-item'>
        <div class='setting-section-top'>
          <span>Delivery Weekly & Monthly Order Reminder</span>
          <div class='toggle-btn setting-toggle-btn'>
            <label class="switch">
              <input type="checkbox" :checked='isCheckedWeeklyReminder' @click.self='handleCheckWeeklyReminder'>
              <span class="slider round"></span>
            </label>
          </div>
        </div>
        <div class='setting-section-bottom'>
          <span>15 minutes before</span>
          <svg xmlns="http://www.w3.org/2000/svg" width="12" height="16" viewBox="0 0 12 16" fill="none" @click='handleOpenWeeklyPopup'>
            <path d="M9 0.508789L11.25 2.75879L9.53475 4.47479L7.28475 2.22479L9 0.508789ZM0 9.49979V11.7498H2.25L8.47425 5.53454L6.22425 3.28454L0 9.49979ZM0 13.9998H12V15.4998H0V13.9998Z" fill="#252831"/>
          </svg>
        </div>
      </div>
      <div class='reminder-setting-item'>
        <div class='setting-section-top'>
          <span>Delivery Once Order Reminder</span>
          <div class='toggle-btn setting-toggle-btn'>
            <label class="switch">
              <input type="checkbox" :checked='isCheckedOnceReminder' @click.self='handleCheckOnceReminder'>
              <span class="slider round"></span>
            </label>
          </div>
        </div>
        <div class='setting-section-bottom'>
          <span>15 minutes before</span>
          <svg xmlns="http://www.w3.org/2000/svg" width="12" height="16" viewBox="0 0 12 16" fill="none" @click='handleOpenOncePopup'>
            <path d="M9 0.508789L11.25 2.75879L9.53475 4.47479L7.28475 2.22479L9 0.508789ZM0 9.49979V11.7498H2.25L8.47425 5.53454L6.22425 3.28454L0 9.49979ZM0 13.9998H12V15.4998H0V13.9998Z" fill="#252831"/>
          </svg>
        </div>
      </div>
    </div>

    <!-- weekly reminder setting popup -->
    <div v-if='isOpenWeeklyPopup' class='overlay-container' @click.self='handleOpenWeeklyPopup'>
      <div class='popup-container'>
        <span class='popup-title'>Delivery Weekly & Monthly Order Reminder</span>
        <fieldset>
          <div
            v-for='(item, index) in weeklyReminderSetting'
          >
            <input type="radio" :id='item.label' name='weekly-reminder-setting' :checked='item.isActive' />
            <label :for="item.label">{{ item.label }}</label>
          </div>
        </fieldset>
      </div>
    </div>
    <!-- weekly reminder setting popup -->

    <!-- weekly once reminder setting popup -->
    <div v-if='isOpenOncePopup' class='overlay-container' @click.self='handleOpenOncePopup'>
      <div class='popup-container'>
        <span class='popup-title'>Delivery Once Order Reminder</span>
        <fieldset>
          <div
            v-for='(item, index) in onceReminderSetting'
            :key='index'
          >
            <input type="radio" :id='item.label' name='once-reminder-setting' :checked='item.isActive' />
            <label :for="item.label">{{ item.label }}</label>
          </div>
        </fieldset>
      </div>
    </div>
    <!-- weekly once reminder setting popup -->
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
        detailBarTitle: "Reminder Settings",
        isOpenWeeklyPopup: false,
        isOpenOncePopup: false,
        isCheckedWeeklyReminder: true,
        isCheckedOnceReminder: true,
        weeklyReminderSetting: [
          {
            label: "15 minutes before",
            isActive: true,
            value: 15,
          },
          {
            label: "30 minutes before",
            isActive: true,
            value: 30,
          },
          {
            label: "45 minutes before",
            isActive: true,
            value: 45,
          },
        ],
        onceReminderSetting: [
          {
            label: "15 minutes before",
            isActive: true,
            value: 15,
          },
          {
            label: "30 minutes before",
            isActive: true,
            value: 30,
          },
          {
            label: "45 minutes before",
            isActive: true,
            value: 45,
          },
        ]
      }
    },
    methods: {
      goBack() {
        window.redirectBack();
      },
      handleCheckWeeklyReminder() {
        this.isCheckedWeeklyReminder = !this.isCheckedWeeklyReminder;
      },
      handleCheckOnceReminder() {
        this.isCheckedOnceReminder = !this.isCheckedOnceReminder;
      },
      handleOpenWeeklyPopup() {
        if (this.isCheckedWeeklyReminder) {
          this.isOpenWeeklyPopup = !this.isOpenWeeklyPopup;
        }
      },
      handleOpenOncePopup() {
        if (this.isCheckedOnceReminder) {
        this.isOpenOncePopup = !this.isOpenOncePopup;
        }
      },
    },
    computed: {

    },
    async created() {
      this.loading = true;
      this.loading = false;
    }
  }).mount("#app");
</script>
