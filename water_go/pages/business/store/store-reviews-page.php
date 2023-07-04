<div id='app'>
  <div v-if='!loading' class='business-store-reviews-page'>
    <?php get_template_part('pages/business/components/detailBar') ?>
    <div class='review-content-container'>
      <div
        v-for='(item, index) in reviews'
        class='review-content-item'
      >
        <div class='section-profile'>
          <div class='profile-image-wrap'>
            <img src="https://ecdn.game4v.com/g4v-content/uploads/2021/04/One-Piece-nhan-vat-lon-tuoi-1-game4v.jpg" alt="profile image" />
          </div>
          <div class='profile-info-wrap'>
            <p>Broadway</p>
            <p>21/10/2021</p>
          </div>
          <div class='review-item-score'>
            <svg xmlns="http://www.w3.org/2000/svg" width="14.66" height="14" viewBox="0 0 17 16" fill="none">
              <path d="M8.49958 13.4042L4.37929 15.8502C4.19727 15.9643 4.00698 16.0132 3.80841 15.9969C3.60984 15.9806 3.43609 15.9154 3.28717 15.8013C3.13824 15.6871 3.02241 15.5443 2.93967 15.3727C2.85694 15.2012 2.84039 15.0097 2.89003 14.7984L3.98216 10.1754L0.333471 7.06899C0.167998 6.92222 0.0647422 6.75492 0.0237048 6.56706C-0.0173325 6.37921 -0.00508757 6.19592 0.0604398 6.0172C0.126629 5.83782 0.225913 5.69106 0.358292 5.57692C0.49067 5.46277 0.672691 5.38939 0.904353 5.35677L5.71963 4.94095L7.5812 0.587044C7.66394 0.391363 7.79234 0.244602 7.96642 0.146761C8.1405 0.0489204 8.31822 0 8.49958 0C8.6816 0 8.85932 0.0489204 9.03273 0.146761C9.20615 0.244602 9.33456 0.391363 9.41795 0.587044L11.2795 4.94095L16.0948 5.35677C16.3265 5.38939 16.5085 5.46277 16.6409 5.57692C16.7732 5.69106 16.8725 5.83782 16.9387 6.0172C17.0049 6.19657 17.0175 6.38019 16.9764 6.56804C16.9354 6.7559 16.8318 6.92288 16.6657 7.06899L13.017 10.1754L14.1091 14.7984C14.1588 15.0104 14.1422 15.2022 14.0595 15.3737C13.9767 15.5452 13.8609 15.6878 13.712 15.8013C13.5631 15.9154 13.3893 15.9806 13.1907 15.9969C12.9922 16.0132 12.8019 15.9643 12.6199 15.8502L8.49958 13.4042Z" fill="#FFC83A"/>
            </svg>
            <span>3.6</span>
          </div>
        </div>
        <p>
          It is a long established fact that a reader will be distracted by the readable content of a page when looking at its layout. The point of using Lorem Ipsum is that it has a more-or-less normal distribution of letters, as opposed to using 'Content here, content here', making it look like readable English. Many desktop publishing packages and web page editors now use Lorem Ipsum as their default model text, and a search for 'lorem ipsum' will uncover many web sites still in their infancy. Various versions have evolved over the years, sometimes by accident, sometimes on purpose (injected humour and the like).
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
        detailBarTitle: "Reviews",
        countReview: 24,
        reviewScore: 3.6,
        reviews: [],
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
      this.reviews = [...Array(5).keys()];
      this.loading = false;
    }
  }).mount("#app");
</script>
