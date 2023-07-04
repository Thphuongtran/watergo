<div id='app'>
  <div v-if='!loading' class='business-support-add-question-page'>
    <?php get_template_part('pages/business/components/detailBar') ?>
    <div class='support-add-question-container'>
      <label>Your Question</label>
      <textarea placeholder='Enter your question'></textarea>
      <div class='send-btn-container'>
        <button class='btn-reset send-btn'>Send Message</button>
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
        detailBarTitle: "WaterGo Support",
      }
    },
    methods: {
      goBack() {
        window.redirectBack();
      },
    },
    computed: {},
    async created() {
      this.loading = true;
      this.loading = false;
    }
  }).mount("#app");
</script>
