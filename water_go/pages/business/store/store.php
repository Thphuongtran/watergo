<div id='app'>
  <div v-if='!loading'>
    <div class='store-page'>
      <?php get_template_part('pages/business/report/report-appBar') ?>
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
        pageTitle: "Store"
      }
    },
    methods: {},
    computed: {},
    async created() {
      this.loading = true;
      this.loading = false;
    },
  }).mount("#app")
</script>