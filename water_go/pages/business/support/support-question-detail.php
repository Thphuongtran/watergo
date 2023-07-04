<div id='app'>
  <div v-if='!loading' class='business-support-question-detail-page'>
    <?php get_template_part('pages/business/components/detailBar') ?>
    <div class='support-question-detail-container'>
      <p v-if='createdAt' class='createdAt-title'>{{ createdAt }}</p>
      <div class='question-title'>
        <h3>Question 1</h3>
      </div>
      <div class='content'>
        <p>
          Exclusive reports and current films: experience a broad range of topics from the fascinating world of Mercedes-Benz. To find out about offers in your location, please go to the local Mercedes-Be.
          Exclusive reports and current films: experience a broad range of topics from the fascinating world of Mercedes-Benz. To find out about offers in your location, please go to the local Mercedes-Be Exclusive reports and current films: experience a broad range of topics from the fascinating world of Mercedes-Benz. To find out about offers in your location, please go to the local Mercedes-Be
        </p>
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
        createdAt: "",
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
