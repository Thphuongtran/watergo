<div id='app'>
   <div v-if='loading == false' class='page-review-form'>

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
         <p class='heading'>What ‘s your rate?</p>
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

      <div class='btn-fixed bottom'>
         <button @click='submit' class='btn btn-primary'>Save</button>
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
   data (){
      return {
         loading: false,
         rating_select: 0,
         review_text: '',
         review_id: 0,
      }
   },
   methods: {

      select_rating_star( rating ){ this.rating_select = rating;},

      async submit(){
         this.loading = true;
         var form = new FormData();
         form.append('action', 'atlantis_update_review');
         form.append('contents', this.review_text);
         form.append('rating', this.rating_select);
         form.append('review_id', this.review_id);
         
         if(  this.review_text != ''){
            var r = await window.request(form);
            if( r != undefined ){
               var res = JSON.parse( JSON.stringify( r));
               if( res.message == 'review_update_ok'){
                  this.goBack();
               }
            }else{
               this.loading = false;
            }
         }else{
            this.loading = false;
         }
      },

      goBack(){ window.goBack();},
      gotoNotification(code){ window.gotoNotification(code)}

   },
   async created(){
      this.loading = true;
      const urlParams = new URLSearchParams(window.location.search);
      const review_id = urlParams.get('review_id');
      this.review_id = parseInt(review_id);
      var form = new FormData();
      form.append('action', 'atlantis_get_review');
      form.append('review_id', this.review_id);
      var r = await window.request(form);
      if( r != undefined ){
         var res = JSON.parse( JSON.stringify(r));
         if( res.message == 'review_found'){
            this.rating_select = parseInt(res.data.rating);
            this.review_text = res.data.contents;
         }
      }

      this.loading = false;

      window.appbar_fixed();
   }
}).mount('#app');
</script>