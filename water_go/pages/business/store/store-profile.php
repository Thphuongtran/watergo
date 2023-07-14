<div id='app'>
  <div v-if='!loading' class='business-store-profile-page'>
    <div class='app-bar-section'>
      <button class='btn-reset' @click='goBack'>
        <svg xmlns="http://www.w3.org/2000/svg" width="28" height="28" viewBox="0 0 28 28" fill="none">
          <circle cx="14" cy="14" r="14" fill="black" fill-opacity="0.2"/>
          <path fill-rule="evenodd" clip-rule="evenodd" d="M4 14C4 13.4477 4.44772 13 5 13H22.5C23.0523 13 23.5 13.4477 23.5 14C23.5 14.5523 23.0523 15 22.5 15H5C4.44772 15 4 14.5523 4 14Z" fill="white"/>
          <path fill-rule="evenodd" clip-rule="evenodd" d="M14.5309 6.37534C14.8759 6.8066 14.806 7.4359 14.3747 7.78091L6.60078 14L14.3747 20.2192C14.806 20.5642 14.8759 21.1935 14.5309 21.6247C14.1859 22.056 13.5566 22.1259 13.1253 21.7809L4.3753 14.7809C4.13809 14.5911 4 14.3038 4 14C4 13.6963 4.13809 13.4089 4.3753 13.2192L13.1253 6.21917C13.5566 5.87416 14.1859 5.94408 14.5309 6.37534Z" fill="white"/>
        </svg>
      </button>
      <button class='btn-reset'>
        <svg xmlns="http://www.w3.org/2000/svg" width="28" height="28" viewBox="0 0 28 28" fill="none">
          <circle cx="14" cy="14" r="14" transform="matrix(-1 0 0 1 28 0)" fill="black" fill-opacity="0.2"/>
          <path d="M7 14V20.4C7 20.8243 7.18437 21.2313 7.51256 21.5314C7.84075 21.8314 8.28587 22 8.75 22H19.25C19.7141 22 20.1592 21.8314 20.4874 21.5314C20.8156 21.2313 21 20.8243 21 20.4V14" stroke="white" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"/>
          <path d="M17.3999 8.4L13.9999 5L10.5999 8.4" stroke="white" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"/>
          <path d="M14 5V16.05" stroke="white" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"/>
        </svg>
      </button>
    </div>
    <div class='profile-cover-section'>
      <img src="https://media.discordapp.net/attachments/1034353493638664252/1127880436077576283/Rectangle_11.png?width=801&height=614" alt="store cover image" />
      <button class='btn-reset edit-info-btn' @click='goToEditProfile'>Edit Info</button>
    </div>
    <div class='profile-title-section'>
      <h2>Store 1</h2>
      <p class='bio-txt'>
        Lorem ipsum dolor sit amet, consectetur adipis, con sec tetur adipis, Lorem ipsum dolor sit amet, consectetur adipis, con sec tetur adipis. 
      </p>
    </div>
    <div class='reviews-section'>
      <div class='reviews-container'>
        <div class='reviews-overview'>
          <svg xmlns="http://www.w3.org/2000/svg" width="17" height="16" viewBox="0 0 17 16" fill="none">
            <path d="M8.49958 13.4042L4.37929 15.8502C4.19727 15.9643 4.00698 16.0132 3.80841 15.9969C3.60984 15.9806 3.43609 15.9154 3.28717 15.8013C3.13824 15.6871 3.02241 15.5443 2.93967 15.3727C2.85694 15.2012 2.84039 15.0097 2.89003 14.7984L3.98216 10.1754L0.333471 7.06899C0.167998 6.92222 0.0647422 6.75492 0.0237048 6.56706C-0.0173325 6.37921 -0.00508757 6.19592 0.0604398 6.0172C0.126629 5.83782 0.225913 5.69106 0.358292 5.57692C0.49067 5.46277 0.672691 5.38939 0.904353 5.35677L5.71963 4.94095L7.5812 0.587044C7.66394 0.391363 7.79234 0.244602 7.96642 0.146761C8.1405 0.0489204 8.31822 0 8.49958 0C8.6816 0 8.85932 0.0489204 9.03273 0.146761C9.20615 0.244602 9.33456 0.391363 9.41795 0.587044L11.2795 4.94095L16.0948 5.35677C16.3265 5.38939 16.5085 5.46277 16.6409 5.57692C16.7732 5.69106 16.8725 5.83782 16.9387 6.0172C17.0049 6.19657 17.0175 6.38019 16.9764 6.56804C16.9354 6.7559 16.8318 6.92288 16.6657 7.06899L13.017 10.1754L14.1091 14.7984C14.1588 15.0104 14.1422 15.2022 14.0595 15.3737C13.9767 15.5452 13.8609 15.6878 13.712 15.8013C13.5631 15.9154 13.3893 15.9806 13.1907 15.9969C12.9922 16.0132 12.8019 15.9643 12.6199 15.8502L8.49958 13.4042Z" fill="#FFC83A"/>
          </svg>
          <span class='reviews-scores'>3.6</span>
          <span class='reviews-total'>( 24 reviews )</span>
          <button class='btn-reset reviews-see-all' @click='goToReviewPage'>
            See all
          </button>
        </div>
        <div class='reviews-detail'>
          <div
            v-for='(item, index) in reviews'
            :key='index'
            class='review-item'
          >
            <div class='reviews-text-overflow'>
              <p class='reviews-content'>
                &ldquo;{{reviewContent}}
              </p>
            </div>
            <div class='reviews-item-scores'>
              <svg xmlns="http://www.w3.org/2000/svg" width="13" height="12" viewBox="0 0 13 12" fill="none">
                <path d="M6.28201 10.0531L3.23672 11.8876C3.10219 11.9732 2.96154 12.0099 2.81478 11.9977C2.66802 11.9855 2.53961 11.9366 2.42954 11.8509C2.31947 11.7653 2.23386 11.6582 2.1727 11.5295C2.11155 11.4009 2.09932 11.2573 2.13601 11.0988L2.9432 7.63157L0.246467 5.30174C0.124166 5.19167 0.0478508 5.06619 0.0175202 4.9253C-0.0128104 4.78441 -0.00376021 4.64694 0.0446709 4.5129C0.0935912 4.37837 0.166972 4.2683 0.264812 4.18269C0.362653 4.09708 0.497184 4.04204 0.668405 4.01758L4.22736 3.70571L5.60324 0.440283C5.66439 0.293522 5.7593 0.183451 5.88796 0.110071C6.01662 0.0366903 6.14797 0 6.28201 0C6.41654 0 6.54789 0.0366903 6.67606 0.110071C6.80424 0.183451 6.89914 0.293522 6.96078 0.440283L8.33667 3.70571L11.8956 4.01758C12.0668 4.04204 12.2014 4.09708 12.2992 4.18269C12.3971 4.2683 12.4704 4.37837 12.5194 4.5129C12.5683 4.64743 12.5776 4.78514 12.5472 4.92603C12.5169 5.06692 12.4403 5.19216 12.3176 5.30174L9.62082 7.63157L10.428 11.0988C10.4647 11.2578 10.4525 11.4016 10.3913 11.5303C10.3302 11.6589 10.2446 11.7658 10.1345 11.8509C10.0244 11.9366 9.896 11.9855 9.74924 11.9977C9.60248 12.0099 9.46183 11.9732 9.3273 11.8876L6.28201 10.0531Z" fill="#FFC83A"/>
              </svg>
              <span class='reviews-scores'>3.6</span>
            </div>
          </div>
        </div>
      </div>
    </div>
    <div class='product-section'>
      <h2>Product</h2>
      <div class='product-filter-type'>
        <button
          v-for='(item, index) in productType'
          :key='index'
          class='btn-reset'
          :class='productFilter === item ? "active" : ""'
          @click='handleFilterProduct(item)'
        >
          {{ item }}
        </button>
      </div>
      <div class='product-list'>
        <div
          v-for='(item, index) in products'
          class='product-item'
        >
          <div class='product-image-container'>
            <img src="https://cdn.donmai.us/original/84/e9/84e9f0b1df42b29c28cdd16d17661410.png" alt="product image" />
          </div>
          <div class='product-info'>
            <h3>Aquafina</h3>
            <p>Bình nước 2.5 L</p>
            <p>25.000 đ</p>
          </div>
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
        reviews: [],
        reviewContent: "",
        products: [],
        productFilter: "Water",
        productType: ["Water", "Ice"],
      }
    },
    methods: {
      goToEditProfile() {
        window.redirectTo('business?business_page=store&store_page=store_edit_profile');
      },
      goToReviewPage() {
        window.redirectTo('business?business_page=store&store_page=store_reviews');
      },
      goBack() {
        window.redirectBack();
      },
      handleFilterProduct(productType) {
        this.productFilter = "Water";
        if (productType === "Ice") {
          this.productFilter = "Ice";
        }
      }
    },
    computed: {},
    async created() {
      this.loading = true;
      this.reviews = [...Array(3).keys()];
      this.reviewContent = "It is a long established fact that a reader will be distracted by the readable content of a page when looking at its layout. The point of using Lorem Ipsum is that it has a more-or-less normal distribution of letters, as opposed to using 'Content here, content here', making it look like readable English. Many desktop publishing packages and web page editors now use Lorem Ipsum as their default model text, and a search for 'lorem ipsum' will uncover many web sites still in their infancy. Various versions have evolved over the years, sometimes by accident, sometimes on purpose (injected humour and the like).";
      this.products = [...Array(8).keys()];
      this.loading = false;
    }
  }).mount("#app");
</script>