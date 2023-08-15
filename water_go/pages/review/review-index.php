<div id='app'>
   <div v-if='loading == false' class="page-review-index">

      <div class='appbar'>
         <div class='appbar-top'>
            <div class='leading'>
               <button @click='goBack' class='btn-action'>
                  <svg width="20" height="16" viewBox="0 0 20 16" fill="none" xmlns="http://www.w3.org/2000/svg">
                     <path fill-rule="evenodd" clip-rule="evenodd" d="M0 8C0 7.44772 0.447715 7 1 7H18.5C19.0523 7 19.5 7.44772 19.5 8C19.5 8.55228 19.0523 9 18.5 9H1C0.447715 9 0 8.55228 0 8Z" fill="#252831"/>
                     <path fill-rule="evenodd" clip-rule="evenodd" d="M10.5309 0.375342C10.8759 0.806604 10.806 1.4359 10.3747 1.78091L2.60078 8.00004L10.3747 14.2192C10.806 14.5642 10.8759 15.1935 10.5309 15.6247C10.1859 16.056 9.55657 16.1259 9.12531 15.7809L0.375305 8.78091C0.13809 8.59113 0 8.30382 0 8.00004C0 7.69625 0.13809 7.40894 0.375305 7.21917L9.12531 0.219168C9.55657 -0.125842 10.1859 -0.0559202 10.5309 0.375342Z" fill="#252831"/>
                  </svg>
               </button>
               <p class='leading-title'>Reviews<span class='badge'>({{total_reviews}})</span></p>
            </div>
            <div class='action'>
               <svg width="20" height="18" viewBox="0 0 20 18" fill="none" xmlns="http://www.w3.org/2000/svg">
               <path d="M9.56202 15.0797L4.9267 17.8315C4.72193 17.9599 4.50785 18.0149 4.28446 17.9966C4.06107 17.9782 3.86561 17.9048 3.69806 17.7764C3.53052 17.648 3.40021 17.4873 3.30713 17.2943C3.21406 17.1013 3.19544 16.8859 3.25129 16.6482L4.47993 11.4474L0.375155 7.95261C0.188997 7.7875 0.072835 7.59928 0.0266679 7.38795C-0.0194991 7.17661 -0.00572352 6.97041 0.0679948 6.76935C0.142458 6.56755 0.254152 6.40245 0.403078 6.27403C0.552004 6.14561 0.756777 6.06306 1.0174 6.02637L6.43458 5.55857L8.52885 0.660425C8.62193 0.440283 8.76639 0.275177 8.96222 0.165106C9.15806 0.0550355 9.358 0 9.56202 0C9.7668 0 9.96673 0.0550355 10.1618 0.165106C10.3569 0.275177 10.5014 0.440283 10.5952 0.660425L12.6895 5.55857L18.1066 6.02637C18.3673 6.06306 18.572 6.14561 18.721 6.27403C18.8699 6.40245 18.9816 6.56755 19.0561 6.76935C19.1305 6.97115 19.1447 7.17771 19.0985 7.38905C19.0523 7.60038 18.9358 7.78824 18.7489 7.95261L14.6441 11.4474L15.8728 16.6482C15.9286 16.8867 15.91 17.1024 15.8169 17.2954C15.7238 17.4884 15.5935 17.6487 15.426 17.7764C15.2584 17.9048 15.063 17.9782 14.8396 17.9966C14.6162 18.0149 14.4021 17.9599 14.1973 17.8315L9.56202 15.0797Z" fill="#FFC83A"/>
               </svg>
               <span class='avg-review'>{{averageRating}}</span>
            </div>
         </div>
      </div>

      <ul class='list-review'>
         <li v-for='(review, reviewKey ) in reviews ' :key='reviewKey'>
            <div class='tile-review-head'>
               <div class='leading'>
                  <img :src="review.user_avatar.url">
               </div>
               <div class='content'>
                  <div class='tt01'>
                     <div class='username'>{{ get_username(review) }}</div>
                  </div>
                  <div class='tt02'>{{ formatDateToDDMMYY(review)}}</div>
               </div>
               <div class='action'>
                  <svg width="15" height="14" viewBox="0 0 15 14" fill="none" xmlns="http://www.w3.org/2000/svg">
                  <path d="M7.32901 11.7286L3.77618 13.8689C3.61922 13.9688 3.45514 14.0116 3.28391 13.9973C3.11269 13.9831 2.96288 13.926 2.83446 13.8261C2.70604 13.7262 2.60616 13.6012 2.53482 13.4511C2.46348 13.301 2.44921 13.1335 2.49202 12.9486L3.43373 8.9035L0.287545 6.18536C0.144861 6.05695 0.0558259 5.91055 0.0204402 5.74618C-0.0149455 5.58181 -0.00438691 5.42143 0.0521161 5.26505C0.10919 5.1081 0.1948 4.97968 0.308948 4.8798C0.423095 4.77992 0.580048 4.71572 0.779806 4.68718L4.93192 4.32333L6.53712 0.513664C6.60846 0.342443 6.71918 0.214026 6.86929 0.128416C7.01939 0.0428054 7.17263 0 7.32901 0C7.48597 0 7.63921 0.0428054 7.78874 0.128416C7.93828 0.214026 8.049 0.342443 8.12091 0.513664L9.72611 4.32333L13.8782 4.68718C14.078 4.71572 14.2349 4.77992 14.3491 4.8798C14.4632 4.97968 14.5488 5.1081 14.6059 5.26505C14.663 5.422 14.6738 5.58266 14.6384 5.74704C14.6031 5.91141 14.5137 6.05752 14.3705 6.18536L11.2243 8.9035L12.166 12.9486C12.2088 13.1341 12.1945 13.3019 12.1232 13.452C12.0519 13.6021 11.952 13.7268 11.8236 13.8261C11.6952 13.926 11.5453 13.9831 11.3741 13.9973C11.2029 14.0116 11.0388 13.9688 10.8819 13.8689L7.32901 11.7286Z" fill="#FFC83A"/>
                  </svg>
                  <span>{{ ratingNumber(review.rating) }}</span>
               </div>
            </div>
            <div class='tile-review-text'>{{ review.contents }}</div>
         </li>
      </ul>

   </div>

   <div v-if="loading == true">
      <div class='progress-center'>
         <div class='progress-container enabled'><progress class='progress-circular enabled'></progress></div>
      </div>
   </div>
</div>


<script type='module'>

var { createApp } = Vue;

createApp({
   data (){
      return {
         loading: false,
         reviews: [],

         store_id: 0,
         paged: 0,
         total_reviews: 0,
         averageRating: 0,

      }
   },

   methods: {

      goBack(){ window.goBack(); },

      get_username( review ){
         if( review.first_name == undefined || review.first_name == ''){
            return review.nickname;
         }else{
            console.log('first name not empty')
            return review.first_name;
         }
      },

      formatDateToDDMMYY(t){ 
         if(t != undefined && t != null){
            if( t.date_modified != null ){
               return window.formatDateToDDMMYY(t.date_modified);
            }else{
               return window.formatDateToDDMMYY(t.date_created);
            }
         }
      },

      async findReview( paged ){
         var form = new FormData();
         form.append('action', 'atlantis_get_review_store');
         form.append('store_id', this.store_id);
         form.append('paged', paged);
         
         var r = await window.request(form);
         if( r != undefined ){
            var res = JSON.parse( JSON.stringify(r));
            if( res.message == 'review_found' ){
               res.data.forEach(item => {
                  if (!this.reviews.some(existingItem => existingItem.id === item.id)) {
                     this.reviews.push(item);
                  }
               });
               
            }
         }
      },

      async get_total_review( store_id ){
         var form = new FormData();
         form.append('action', 'atlantis_get_total_review');
         form.append('store_id', store_id );
         var r = await window.request(form);
         if( r != undefined ){
            var res = JSON.parse( JSON.stringify(r));
            if( res.message == 'total_review_found' ){
               this.total_reviews = res.data;
            }
         }
      },

      async get_review_rating_average( store_id ){
         var form = new FormData();
         form.append('action', 'atlantis_get_avg_rating');
         form.append('store_id', store_id);
         var r = await window.request(form);
         if( r != undefined ){
            var res = JSON.parse( JSON.stringify(r));
            if(res.message == 'rating_found' ){
               this.averageRating = res.data;
               this.averageRating = parseFloat(this.averageRating).toFixed(1);
            }
         }
      },

      ratingNumber(rating){ return parseInt(rating).toFixed(1); },

      async handleScroll() {
         const windowTop          = window.pageYOffset || document.documentElement.scrollTop;
         const scrollEndThreshold = 50; // Adjust this value as needed
         const scrollPosition = window.pageYOffset || document.documentElement.scrollTop;
         const windowHeight   = window.innerHeight;
         const documentHeight = document.documentElement.scrollHeight;
         var windowScroll     = scrollPosition + windowHeight + scrollEndThreshold;
         var documentScroll   = documentHeight + scrollEndThreshold;
         if (scrollPosition + windowHeight + 10 >= documentHeight - 10) {
            await this.findReview( this.paged++);
         }
      }

   },

   computed: {

   },

   mounted() {
      window.addEventListener('scroll', this.handleScroll);
   },
   beforeDestroy() {
      window.removeEventListener('scroll', this.handleScroll);
   },

   async created(){
      this.loading = true;
      const urlParams = new URLSearchParams(window.location.search);
      const store_id  = urlParams.get('store_id'); 
      this.store_id   = store_id;

      await this.findReview( 0);
      await this.get_total_review(store_id);
      await this.get_review_rating_average(store_id);

      console.log(this.reviews)

      this.loading = false;

      window.appbar_fixed();
   },

}).mount('#app');
</script>
