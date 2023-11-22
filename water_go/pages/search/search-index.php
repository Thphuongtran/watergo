<style>
   .gr-price{
      display: flex;
      flex-flow: row wrap;
      align-items: flex-end;
   }
   .product-design .price{
      padding-right: 5px;
   }
   .product-design .price-sub{
      margin-left: 0;
      position: relative;
      top: -2px;
   }

   .box-search.style01 .input-search{
      padding-right: 15px;
   }

   .search-data{
      overflow-y: scroll;
      overflow-x: hidden;
      height: calc( 100vh - 56px);
      padding-top: 20px;
      padding-bottom: 30px;
   }
   .grid-masonry{
      margin-top: 0;
   }
</style>

<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.matchHeight/0.7.2/jquery.matchHeight-min.js" integrity="sha512-/bOVV1DV1AQXcypckRwsR9ThoCj7FqTV2/0Bm79bL3YSyLkVideFLE3MIZkq1u5t28ke1c0n31WYCOrO01dsUg==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<div id='app'>

   <div class='page-search'>
      <div class='page-appbar-support'>
         <div class='appbar'>

            <div class='appbar-top'>
               <div class='leading'>

                  <button @click='goBack' class='btn-action'>
                     <svg width="20" height="16" viewBox="0 0 20 16" fill="none" xmlns="http://www.w3.org/2000/svg">
                     <path fill-rule="evenodd" clip-rule="evenodd" d="M0 8C0 7.44772 0.447715 7 1 7H18.5C19.0523 7 19.5 7.44772 19.5 8C19.5 8.55228 19.0523 9 18.5 9H1C0.447715 9 0 8.55228 0 8Z" fill="white"/>
                     <path fill-rule="evenodd" clip-rule="evenodd" d="M10.5309 0.375342C10.8759 0.806604 10.806 1.4359 10.3747 1.78091L2.60078 8.00004L10.3747 14.2192C10.806 14.5642 10.8759 15.1935 10.5309 15.6247C10.1859 16.056 9.55657 16.1259 9.12531 15.7809L0.375305 8.78091C0.13809 8.59113 0 8.30382 0 8.00004C0 7.69625 0.13809 7.40894 0.375305 7.21917L9.12531 0.219168C9.55657 -0.125842 10.1859 -0.0559202 10.5309 0.375342Z" fill="white"/>
                     </svg>
                  </button>

                  <div class='box-search style01'>

                     <input class='input-search' type='text' v-model='inputSearch' placeholder='<?php echo __('Search by product or store name', 'watergo'); ?>'>
                     <span class='icon-search'>
                        <svg width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path fill-rule="evenodd" clip-rule="evenodd" d="M4.90688 0.60506C5.87126 0.205599 6.90488 0 7.94872 0C8.99256 0 10.0262 0.205599 10.9906 0.60506C11.9549 1.00452 12.8312 1.59002 13.5693 2.32813C14.3074 3.06623 14.8929 3.94249 15.2924 4.90688C15.6918 5.87126 15.8974 6.90488 15.8974 7.94872C15.8974 8.99256 15.6918 10.0262 15.2924 10.9906C14.9914 11.7172 14.5848 12.3938 14.0869 12.999L19.7747 18.6868C20.0751 18.9872 20.0751 19.4743 19.7747 19.7747C19.4743 20.0751 18.9872 20.0751 18.6868 19.7747L12.999 14.0869C12.3938 14.5848 11.7172 14.9914 10.9906 15.2924C10.0262 15.6918 8.99256 15.8974 7.94872 15.8974C6.90488 15.8974 5.87126 15.6918 4.90688 15.2924C3.94249 14.8929 3.06623 14.3074 2.32813 13.5693C1.59002 12.8312 1.00452 11.9549 0.60506 10.9906C0.2056 10.0262 0 8.99256 0 7.94872C0 6.90488 0.2056 5.87126 0.60506 4.90688C1.00452 3.94249 1.59002 3.06623 2.32813 2.32813C3.06623 1.59002 3.94249 1.00452 4.90688 0.60506ZM7.94872 1.53846C7.10691 1.53846 6.27335 1.70427 5.49562 2.02641C4.71789 2.34856 4.01123 2.82073 3.41598 3.41598C2.82073 4.01123 2.34856 4.71789 2.02641 5.49562C1.70427 6.27335 1.53846 7.10691 1.53846 7.94872C1.53846 8.79053 1.70427 9.62409 2.02641 10.4018C2.34856 11.1795 2.82073 11.8862 3.41598 12.4815C4.01123 13.0767 4.71789 13.5489 5.49562 13.871C6.27335 14.1932 7.10691 14.359 7.94872 14.359C8.79053 14.359 9.62409 14.1932 10.4018 13.871C11.1795 13.5489 11.8862 13.0767 12.4815 12.4815C13.0767 11.8862 13.5489 11.1795 13.871 10.4018C14.1932 9.62409 14.359 8.79053 14.359 7.94872C14.359 7.10691 14.1932 6.27335 13.871 5.49562C13.5489 4.71789 13.0767 4.01123 12.4815 3.41598C11.8862 2.82073 11.1795 2.34856 10.4018 2.02641C9.62409 1.70427 8.79053 1.53846 7.94872 1.53846Z" fill="#252831"/>
                        </svg>
                     </span>

                     <span @click='removeText' v-if='inputSearch.length > 0' class='icon-delete'>
                        <svg width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                           <circle cx="10" cy="10" r="10" fill="#DEDEDE"/>
                           <path d="M14 6L6 14" stroke="#252831" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                           <path d="M6 6L14 14" stroke="#252831" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                        </svg>
                     </span>

                  </div>
               </div>
            </div>
         </div>
      </div>

      <div v-if='get_search_data.length > 0' class='search-data'>
         <div class='inner'>

            <div class='grid-masonry'>
               <div 
                  @click='findPlace(searchItem)' 
                  class='product-design' 
                  v-for='(searchItem, index) in get_search_data' :key='index'>
                  
                  <!-- PRODUCT -->
                  <div v-if='searchItem.search_type == "product"' class='img'>
                     <img :src='searchItem.product_image.url'>
                     <span v-if='has_discount(searchItem) == true' class='badge-discount'>-{{ searchItem.discount_percent }}%</span>
                  </div>
                  <div v-if='searchItem.search_type == "product"'  class='box-wrapper'>
                     <p class='tt01'>{{ searchItem.name }} </p>
                     <p class='tt02'>{{ searchItem.name_second }}</p>
                     <div class='gr-price' :class="has_discount(searchItem) == true ? 'has_discount' : '' ">
                        <span class='price'>
                           {{ common_price_after_discount(searchItem ) }}
                        </span>
                        <span v-if='has_discount(searchItem) == true' class='price-sub'>
                           {{ common_price_show_currency(searchItem.price) }}
                        </span>
                        <span v-show='has_gift(searchItem) == true' class='badge-gift'>
                           <span class='icon'>
                              <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                              <path d="M12.0002 7.91235V19.3409M5.14307 11.3409H18.8574V17.0552C18.8574 17.6614 18.6165 18.2428 18.1879 18.6715C17.7592 19.1001 17.1778 19.3409 16.5716 19.3409H7.42878C6.82257 19.3409 6.24119 19.1001 5.81254 18.6715C5.38388 18.2428 5.14307 17.6614 5.14307 17.0552V11.3409Z" stroke="#2790F9" stroke-linecap="round" stroke-linejoin="round"/>
                              <path d="M12 7.9123H8.57143C7.67886 7.01973 7.67886 5.3763 8.57143 4.48373C9.464 3.59115 12 3.9123 12 5.62658M12 7.9123V5.62658M12 7.9123H15.4286C16.3211 7.01973 16.3211 5.3763 15.4286 4.48373C14.536 3.59115 12 3.9123 12 5.62658M5.14286 7.9123H18.8571C19.1602 7.9123 19.4509 8.0327 19.6653 8.24703C19.8796 8.46136 20 8.75205 20 9.05515V10.198C20 10.5011 19.8796 10.7918 19.6653 11.0061C19.4509 11.2205 19.1602 11.3409 18.8571 11.3409H5.14286C4.83975 11.3409 4.54906 11.2205 4.33474 11.0061C4.12041 10.7918 4 10.5011 4 10.198V9.05515C4 8.75205 4.12041 8.46136 4.33474 8.24703C4.54906 8.0327 4.83975 7.9123 5.14286 7.9123Z" stroke="#2790F9" stroke-linecap="round" stroke-linejoin="round"/>
                              </svg>
                           </span>
                           <span class='text'>{{ searchItem.gift_text}}</span>
                        </span>
                     </div>
                  </div>

                  <!-- STORE -->
                  <div v-if='searchItem.search_type == "store"' class='img'>
                     <img :src='searchItem.store_image.url'>
                  </div>
                  <div v-if='searchItem.search_type == "store"'  class='box-wrapper'>
                     <p class='tt01'>{{ searchItem.name }} </p>
                     <p class='product-meta'>
                        <span class='store-distance'>{{ mathCeilDistance(searchItem.distance) }} km</span>
                        <svg v-if='searchItem.avg_rating > 0' width="15" height="14" viewBox="0 0 15 14" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M7.32901 11.7286L3.77618 13.8689C3.61922 13.9688 3.45514 14.0116 3.28391 13.9973C3.11269 13.9831 2.96287 13.926 2.83446 13.8261C2.70604 13.7262 2.60616 13.6012 2.53482 13.4511C2.46348 13.301 2.44921 13.1335 2.49202 12.9486L3.43373 8.9035L0.287545 6.18536C0.144861 6.05695 0.0558259 5.91055 0.0204402 5.74618C-0.0149455 5.58181 -0.00438691 5.42143 0.0521161 5.26505C0.10919 5.1081 0.1948 4.97968 0.308948 4.8798C0.423095 4.77992 0.580048 4.71571 0.779806 4.68718L4.93192 4.32333L6.53712 0.513664C6.60846 0.342443 6.71918 0.214026 6.86928 0.128416C7.01939 0.0428054 7.17263 0 7.32901 0C7.48597 0 7.63921 0.0428054 7.78874 0.128416C7.93827 0.214026 8.049 0.342443 8.12091 0.513664L9.72611 4.32333L13.8782 4.68718C14.078 4.71571 14.2349 4.77992 14.3491 4.8798C14.4632 4.97968 14.5488 5.1081 14.6059 5.26505C14.663 5.422 14.6738 5.58266 14.6384 5.74704C14.6031 5.91141 14.5137 6.05752 14.3705 6.18536L11.2243 8.9035L12.166 12.9486C12.2088 13.1341 12.1945 13.3019 12.1232 13.452C12.0519 13.6021 11.952 13.7268 11.8236 13.8261C11.6952 13.926 11.5453 13.9831 11.3741 13.9973C11.2029 14.0116 11.0388 13.9688 10.8819 13.8689L7.32901 11.7286Z" fill="#FFC83A"/></svg>
                        <span v-if='searchItem.avg_rating > 0' class='store-rating'>{{ratingNumber(searchItem.avg_rating)}}</span>
                     </p>
                  </div>


               </div>
            </div>
            
         </div>
      </div>
   </div>
   
</div>
<script>

var { createApp } = Vue;

createApp({
   data (){
      return {
         loading: false,
         searchs: [],
         inputSearch: '',
         latitude: 10.780900239854994,
         longitude: 106.7226271387539,

         product_length: 0,
         store_length: 0,

         paged: 0,
      }
   },

   watch: {
      
      inputSearch: async function ( val ){
         this.paged = 0;
         this.searchs = [];
         if (this.timeoutId) { clearTimeout(this.timeoutId); }
         this.timeoutId = setTimeout( await this.futuredDelayed, 600);
      },

      searchs: {
         handler(data){
            jQuery(document).ready(function($){
               jQuery('.box-wrapper').matchHeight({ property: 'min-height' });
            });

            var _filter_product = this.searchs.filter( item => item.search_type == 'product' );
            this.product_length = _filter_product.length;

            var _filter_store = this.searchs.filter( item => item.search_type == 'store' );
            this.store_length = _filter_store.length;

         }, deep: true
      },


   },

   computed: {
      get_search_data(){
         var data = this.searchs;
         data.sort( (a, b) => a.distance - b.distance );
         return data;
      }
   },

   methods: {
      
      gotoProductDetail(id){ window.gotoProductDetail(id)},
      gotoStoreDetail(store_id){ window.gotoStoreDetail( store_id ) },
      findPlace( searchItem ){
         if( searchItem.search_type == 'store' ){
            this.gotoStoreDetail(searchItem.store_id);
         }
         if( searchItem.search_type == 'product' ){
            this.gotoProductDetail(searchItem.product_id);
         }
      },
      ratingNumber(rating){ return parseFloat(rating).toFixed(1); },
      mathCeilDistance( distance ){ return parseFloat(distance).toFixed(1); },

      async handleScroll() {
         const windowTop = window.pageYOffset || document.documentElement.scrollTop;
         const scrollEndThreshold = 50; // Adjust this value as needed
         const scrollPosition = window.pageYOffset || document.documentElement.scrollTop;
         const windowHeight = window.innerHeight;
         const documentHeight = document.documentElement.scrollHeight;

         var windowScroll     = scrollPosition + windowHeight + scrollEndThreshold;
         var documentScroll   = documentHeight + scrollEndThreshold;

         // if (scrollPosition + windowHeight + 10 >= documentHeight - 10) {
         if (scrollPosition + windowHeight >= documentHeight ) {
            await this.futuredDelayed();
         }
      },

      async futuredDelayed(){

         if( this.inputSearch != undefined && this.inputSearch != '' && this.inputSearch != ' '){
            
            var latin = window.convertVietnameseToLatin(this.inputSearch);
            var form = new FormData();
            form.append('action', 'atlantis_search_product');
            form.append('search', this.inputSearch );
            form.append('lat', this.latitude);
            form.append('lng', this.longitude);
            form.append('paged', this.product_length);

            var r = await window.request(form);
            if( r != undefined){
               var res = JSON.parse( JSON.stringify( r));
               if(res.message == 'search_found'){
                  res.data.forEach(item => {
                     if (!this.searchs.some(existingItem => existingItem.product_id === item.product_id)) {
                        item.search_type = 'product';
                        this.searchs.push(item);
                     }
                  });
               }
            }

            var formStore = new FormData();
            formStore.append('action', 'atlantis_search_store');
            formStore.append('search', this.inputSearch );
            formStore.append('lat', this.latitude);
            formStore.append('lng', this.longitude);
            formStore.append('paged', this.store_length);
            var rStore = await window.request(formStore);
            if( rStore != undefined){
               var resStore = JSON.parse( JSON.stringify( rStore));
               if(resStore.message == 'search_found'){
                  resStore.data.forEach(item => {
                     if (!this.searchs.some(existingItem => existingItem.store_id === item.store_id)) {
                        item.search_type = 'store';
                        this.searchs.push(item);
                     }
                  });
               }
            }


         }

      },

      has_discount(p){ return window.has_discount(p); },
      has_gift(p){ return window.has_gift(p); },
      
      common_price_after_discount(p){ return window.common_price_after_discount(p)},
      common_price_show_currency(p){ return window.common_price_show_currency(p)},
      
      goBack(){window.goBack()},
      removeText(){ this.inputSearch = ''; },

      get_current_location(){

         if( window.appBridge != undefined ){
            window.appBridge.getLocation().then( (data) => {
               if (Object.keys(data).length === 0) {
                  // alert("Error-1 :Không thể truy cập vị trí");
               }else{
                  let lat = data.lat;
                  let lng = data.lng;
                  this.latitude = data.lat;
                  this.longitude = data.lng;

               }
            }).catch((e) => { })
         }
      },

   },

   mounted() {window.addEventListener('scroll', this.handleScroll);},
   beforeDestroy() {window.removeEventListener('scroll', this.handleScroll);},


   update(){
      (function($){
         $(document).ready(function(){
            var _appbar = $('.page-appbar-support');
            _appbar.addClass('fixed');
            $('#app').css('padding-top', _appbar.height());
         });
      })(jQuery);
   },


   async created(){
      if( window.appBridge != undefined ){
         window.appBridge.setEnableScroll(false);
      }

      this.get_current_location();

      jQuery(document).ready(function($){
         var _appbar = $('.page-appbar-support');
         _appbar.addClass('fixed');
         $('#app').css('padding-top', _appbar.height());
      });

   }
}).mount('#app');
</script>