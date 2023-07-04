<div id='app'>
  <div v-if='!loading' class='business-language-setting-page'>
    <?php get_template_part('pages/business/components/detailBar') ?>
    <div class='language-setting-container'>
      <fieldset>
        <div
          v-for='(item, index) in languages'
          :key='index'
        >
          <input type="radio" :id='item.label' name='language-setting' :checked='item.isActive' />
          <label :for="item.label">{{ item.label }}</label>
        </div>
      </fieldset>
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
        detailBarTitle: "Language",
        languages: [
          {
            label: "Vietnamese",
            isActive: true,
            value: "Vietnamese",
          },
          {
            label: "English",
            isActive: false,
            value: "English",
          },
          {
            label: "Korean",
            isActive: false,
            value: "Korean",
          }
        ]
      }
    },
    methods: {
      goBack() {
        window.redirectBack();
      }
    },
    computed: {},
    async created() {
      this.loading = true;
      this.loading = false;
    }
  }).mount("#app");
</script>
