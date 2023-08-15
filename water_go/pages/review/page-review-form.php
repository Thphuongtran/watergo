<div id='app'>
   <div v-show='loading == false' class='page-review-form'>

      <div class='appbar'>
         <div class='appbar-top'>
            <div class='leading'>
               <button @click='goBack' class='btn-action'>
                  <svg width="20" height="16" viewBox="0 0 20 16" fill="none" xmlns="http://www.w3.org/2000/svg">
                     <path fill-rule="evenodd" clip-rule="evenodd" d="M0 8C0 7.44772 0.447715 7 1 7H18.5C19.0523 7 19.5 7.44772 19.5 8C19.5 8.55228 19.0523 9 18.5 9H1C0.447715 9 0 8.55228 0 8Z" fill="#252831"/>
                     <path fill-rule="evenodd" clip-rule="evenodd" d="M10.5309 0.375342C10.8759 0.806604 10.806 1.4359 10.3747 1.78091L2.60078 8.00004L10.3747 14.2192C10.806 14.5642 10.8759 15.1935 10.5309 15.6247C10.1859 16.056 9.55657 16.1259 9.12531 15.7809L0.375305 8.78091C0.13809 8.59113 0 8.30382 0 8.00004C0 7.69625 0.13809 7.40894 0.375305 7.21917L9.12531 0.219168C9.55657 -0.125842 10.1859 -0.0559202 10.5309 0.375342Z" fill="#252831"/>
                  </svg>
               </button>
               <p class='leading-title'>Write Review</p>
            </div>
         </div>
      </div>

      <div class='inner'>
         <p class='heading'>What's your rate?</p>
         <div class='box-rating-star'>
            <span v-for='i in 5' @click='select_rating_star(i)'
               :class='rating_select >= i ? "active" :""'>
               <svg width="35" height="34" viewBox="0 0 35 34" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M16.5489 1.42705C16.8483 0.50574 18.1517 0.50574 18.4511 1.42705L21.7658 11.6287C21.8996 12.0407 22.2836 12.3197 22.7168 12.3197H33.4434C34.4122 12.3197 34.8149 13.5593 34.0312 14.1287L25.3532 20.4336C25.0027 20.6883 24.8561 21.1396 24.9899 21.5517L28.3046 31.7533C28.604 32.6746 27.5495 33.4407 26.7658 32.8713L18.0878 26.5664C17.7373 26.3117 17.2627 26.3117 16.9122 26.5664L8.23419 32.8713C7.45048 33.4407 6.396 32.6746 6.69535 31.7533L10.0101 21.5517C10.1439 21.1396 9.99728 20.6883 9.64679 20.4336L0.968768 14.1287C0.185055 13.5593 0.58783 12.3197 1.55655 12.3197H12.2832C12.7164 12.3197 13.1004 12.0407 13.2342 11.6287L16.5489 1.42705Z" fill="#C4C4C4"/></svg>
            </span>
         </div>
      </div>

      <div class='inner'>
         <p class='heading'>Your Review</p>
         <label class='input-review'>
            <span class='icon'>
               <svg width="30" height="30" viewBox="0 0 30 30" fill="none" xmlns="http://www.w3.org/2000/svg">
               <circle cx="15" cy="15" r="15" fill="#ECECEC"/>
               <path d="M15 14.8469C17.0392 14.8469 18.6923 13.2023 18.6923 11.1735C18.6923 9.14467 17.0392 7.5 15 7.5C12.9608 7.5 11.3077 9.14467 11.3077 11.1735C11.3077 13.2023 12.9608 14.8469 15 14.8469Z" fill="white"/>
               <path d="M16.9231 16.3776H13.0769C10.8462 16.3776 9 18.2144 9 20.4337C9 20.9695 9.23077 21.4286 9.69231 21.6582C10.3846 22.0409 11.9231 22.5001 15 22.5001C18.0769 22.5001 19.6154 22.0409 20.3077 21.6582C20.6923 21.4286 21 20.9695 21 20.4337C21 18.1378 19.1538 16.3776 16.9231 16.3776Z" fill="white"/>
               </svg>
            </span>
            <textarea v-model='review_text' placeholder='Write your review....'></textarea>
         </label>
      </div>

      <div class='inner'>
         <p class='t-red'>{{ res_text }}</p>
      </div>

      <div class='btn-fixed bottom'>
         <button v-if='event == "add"' @click='submit' class='btn btn-primary'>Add</button>
         <button v-if='event == "edit"' @click='update' class='btn btn-primary'>Save</button>
      </div>

   </div>

   <div v-show='loading == true'>
      <div class='progress-center'>
         <div class='progress-container enabled'><progress class='progress-circular enabled' ></progress></div>
      </div>
   </div>

   <div v-show='banner_open == true' class='banner'>
      <div class='banner-head'>
         <svg width="130" height="130" viewBox="0 0 130 130" fill="none" xmlns="http://www.w3.org/2000/svg">
         <circle cx="65" cy="65" r="65" fill="#E9E9E9"/>
         <g filter="url(#filter0_d_780_2507)">
         <path d="M48.2256 70.5944C48.2256 72.3887 48.9385 74.1096 50.2073 75.3784C51.4761 76.6473 53.197 77.3601 54.9914 77.3601H95.5857L109.117 90.8915V36.7657C109.117 34.9713 108.404 33.2505 107.136 31.9816C105.867 30.7128 104.146 30 102.351 30H54.9914C53.197 30 51.4761 30.7128 50.2073 31.9816C48.9385 33.2505 48.2256 34.9713 48.2256 36.7657V70.5944Z" fill="#2790F9" stroke="#2790F9" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
         </g>
         <path d="M80.8915 79.7028C80.8915 81.4971 80.1787 83.218 78.9099 84.4868C77.6411 85.7557 75.9202 86.4685 74.1258 86.4685H33.5315L20 99.9999V45.8741C20 44.0797 20.7128 42.3589 21.9816 41.09C23.2505 39.8212 24.9713 39.1084 26.7657 39.1084H74.1258C75.9202 39.1084 77.6411 39.8212 78.9099 41.09C80.1787 42.3589 80.8915 44.0797 80.8915 45.8741V79.7028Z" fill="white" stroke="#2790F9" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
         <circle cx="38.1872" cy="62.883" r="2.85127" fill="#2790F9"/>
         <circle cx="49.9147" cy="62.883" r="2.85127" fill="#2790F9"/>
         <circle cx="61.6413" cy="62.883" r="2.85127" fill="#2790F9"/>
         <defs>
         <filter id="filter0_d_780_2507" x="39.2256" y="25" width="78.8916" height="78.8916" filterUnits="userSpaceOnUse" color-interpolation-filters="sRGB">
         <feFlood flood-opacity="0" result="BackgroundImageFix"/>
         <feColorMatrix in="SourceAlpha" type="matrix" values="0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 127 0" result="hardAlpha"/>
         <feOffset dy="4"/>
         <feGaussianBlur stdDeviation="4"/>
         <feComposite in2="hardAlpha" operator="out"/>
         <feColorMatrix type="matrix" values="0 0 0 0 1 0 0 0 0 1 0 0 0 0 1 0 0 0 0.25 0"/>
         <feBlend mode="normal" in2="BackgroundImageFix" result="effect1_dropShadow_780_2507"/>
         <feBlend mode="normal" in="SourceGraphic" in2="effect1_dropShadow_780_2507" result="shape"/>
         </filter>
         </defs>
         </svg>
         <h3>Review Successfully</h3>
      </div>

      <div class='banner-footer'>
         <button @click='goBack' class='btn btn-outline'>Exit</button>
      </div>
   </div>

</div>

<script type='module'>

var { createApp } = Vue;

createApp({
   data (){
      return {
         loading:     false,
         banner_open: false,

         order_id:    0,
         store_id:    0,
         review_id:   0,

         // add - edit
         event: '', 
         rating_select: 0,
         review_text: '',
         res_text: '',

      }
   },
   methods: {

      select_rating_star( rating ){ this.rating_select = rating;},

      async get_review(review_id ){
         var form = new FormData();
         form.append('action', 'atlantis_get_review');
         form.append('review_id', this.review_id);
         var r = await window.request(form);
         if( r != undefined ){
            var res = JSON.parse( JSON.stringify( r));
            if( res.message == 'review_found'){
               this.review_text     = res.data.contents;
               this.rating_select   = res.data.rating;
            }
         }
      },

      async submit(){

         this.loading = true;
         if( this.order_id != 0 && this.store_id != 0 && this.review_text != '' && this.rating_select > 0){
            var form = new FormData();
            form.append('action', 'atlantis_event_review');
            form.append('contents', this.review_text);
            form.append('store_id', this.store_id);
            form.append('order_id', this.order_id);
            form.append('rating', this.rating_select);
            form.append('event', 'add');

            var r = await window.request(form);
            if( r != undefined ){
               var res = JSON.parse( JSON.stringify( r));
               if( res.message == 'review_insert_ok'){
                  this.banner_open = true;
               }
            }
         }else{
            this.res_text = 'All field must be not empty';
         }
         this.loading = false;

      },

      async update(){
         this.loading = true;
         if( this.review_id != 0 && this.review_text != '' && this.rating_select > 0){
            var form = new FormData();
            form.append('action', 'atlantis_event_review');
            form.append('contents', this.review_text);
            form.append('rating', this.rating_select);
            form.append('review_id', this.review_id);
            form.append('event', 'edit');

            var r = await window.request(form);

            if( r != undefined ){
               var res = JSON.parse( JSON.stringify( r));
               if( res.message == 'review_update_ok'){
                  this.goBack();
               }
            }
         }else{
            this.res_text = 'All field must be not empty';
            this.loading = false;
         }
         
      },

      goBack(){ window.goBack(true)}

   },


   async created(){
      var urlParams = new URLSearchParams(window.location.search);
      var order_id = urlParams.get('order_id');
      var store_id = urlParams.get('store_id');
      var review_id = urlParams.get('review_id');
      var event    = urlParams.get('event');  // add - edit

      this.loading = true;

      this.order_id = order_id;
      this.store_id = store_id;
      if( event != undefined ){
         this.event    = event;
      }
      if( event == 'edit' && review_id != undefined ){
         this.review_id = review_id;
         await this.get_review(review_id);
      }

      this.loading = false;

      window.appbar_fixed();

   }
}).mount('#app');
</script>