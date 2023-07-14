<div id='app'>
  <div v-if='!loading' class='business-support-self-question-page'>
    <?php get_template_part('pages/business/components/detailBar') ?>
    <div class='support-self-question-container'>
      <div
        v-for='(item, index) in questions'
        :key='index'
        class='question-item'
      >
        <div class='self-question-top-content'>
          <p>{{ item.createdAt }}</p>
          <span v-if='!item.isRead' class='question-read-red-dot'></span>
        </div>
        <div class='self-question-bottom-content'>
          <p>{{ item.question }}</p>
          <button class='btn-reset question-btn' @click='goToQuestionDetailPage(item.id)'>
            <svg xmlns="http://www.w3.org/2000/svg" width="6" height="10" viewBox="0 0 6 10" fill="none">
              <path d="M0.999512 9.00049L4.99951 5.00049L0.999512 1.00049" stroke="#6F6F6F" stroke-linecap="round" stroke-linejoin="round"/>
            </svg>
          </button>
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
        questions: [],
      }
    },
    methods: {
      goBack() {
        window.redirectBack();
      },
      goToQuestionDetailPage(id) {
        window.redirectTo(`business?business_page=support&support_page=support_main&question_id=${id}`);
      },
    },
    computed: {},
    async created() {
      this.loading = true;
      this.questions = [
        {
          id: 1,
          question: "How can I delete contact with seller?",
          answer: "",
          createdAt: "02/24/2023",
          isRead: false,
        },
        {
          id: 2,
          question: "How can I delete contact with seller? ",
          answer: "",
          createdAt: "01/18/2023",
          isRead: true,
        },
        {
          id: 3,
          question: "How can I delete contact with seller? ",
          answer: "",
          createdAt: "12/02/2022",
          isRead: true,
        }
      ]
      this.loading = false;
    }
  }).mount("#app");
</script>
