<?php 

   $store_id = isset($_GET['store_id']) ? $_GET['store_id'] : 0;
   $current_store_id = func_get_store_id_from_current_user();
   $is_user_store = 0;
   if( $store_id == $current_store_id ){
      $is_user_store = 1;
   }

   
?>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.matchHeight/0.7.2/jquery.matchHeight-min.js?ver=1.0" integrity="sha512-/bOVV1DV1AQXcypckRwsR9ThoCj7FqTV2/0Bm79bL3YSyLkVideFLE3MIZkq1u5t28ke1c0n31WYCOrO01dsUg==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<style>
   .product-header .main{
      text-align: center;
   }
   .product-header .main img{
      max-width: 100%;
      width: auto;
      margin: 0 auto;
   }
   .list-product-by-store .product-design .tt01{
      text-overflow: ellipsis;
      display: -webkit-box;
      -webkit-line-clamp: 1;
      -webkit-box-orient: vertical;
      overflow: hidden;
   }

   .product-header .main{
      height: 328px;
   }

   .product-design.product-detail .gr-price{
      display: flex;
      flex-flow: row wrap;
      align-items: flex-end;
   }

   .list-product-by-store .badge-gift {
      position: relative;
      width: 100%;
   }
   .list-product-by-store .badge-gift .icon {
      position: absolute;
      top: -2px;
   }
   .list-product-by-store .badge-gift .text {
      padding-left: 25px;
      line-height: 20px;
   }
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

   .store-product{
      padding-bottom: 50px;
   }

</style>

<div id='app'>

   <div v-show='loading == false && store != null' class="page-store-detail">
   
      <div class='product-detail-wrapper'>
         <div class='product-header'>
            <div class='top'>
               <button v-if='store_id > 0 ' @click='goBackUpdate(store_id)' class='btn-action'>
                  <svg width="28" height="28" viewBox="0 0 28 28" fill="none" xmlns="http://www.w3.org/2000/svg">
                  <circle cx="14" cy="14" r="14" fill="black" fill-opacity="0.6"/>
                  <path fill-rule="evenodd" clip-rule="evenodd" d="M4 14C4 13.4477 4.44772 13 5 13H22.5C23.0523 13 23.5 13.4477 23.5 14C23.5 14.5523 23.0523 15 22.5 15H5C4.44772 15 4 14.5523 4 14Z" fill="white"/>
                  <path fill-rule="evenodd" clip-rule="evenodd" d="M14.5309 6.37534C14.8759 6.8066 14.806 7.4359 14.3747 7.78091L6.60078 14L14.3747 20.2192C14.806 20.5642 14.8759 21.1935 14.5309 21.6247C14.1859 22.056 13.5566 22.1259 13.1253 21.7809L4.3753 14.7809C4.13809 14.5911 4 14.3038 4 14C4 13.6963 4.13809 13.4089 4.3753 13.2192L13.1253 6.21917C13.5566 5.87416 14.1859 5.94408 14.5309 6.37534Z" fill="white"/>
                  </svg>
               </button>
            </div>

            <div v-if='store != null' class='main' :class='is_store_avatar_dummy(store.store_image)'>
               <img :src="store.store_image_full.url">
               <button v-if='user_current_is_store == 1' @click='gotoPageStoreEdit' class='btn-edit-store-info'><?php echo __('Edit Info', 'watergo'); ?></button>
            </div>
         </div>
      </div>

      <div v-if='store != null' class="inner">
         <div class='product-design product-detail'>
            <p class='tt01'>{{ store.name }}</p>
            <p class='tt02' v-if='user_current_is_store == 0'>{{ store.distance }}</p>
            <p class='tt03'> {{ store.description }}</p>
         </div>

         <div v-if='reviews.length > 0' class='store-review'>
            <div class='review-head'>
               <svg width="17" height="16" viewBox="0 0 17 16" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M8.49958 13.4042L4.37929 15.8502C4.19727 15.9643 4.00698 16.0132 3.80841 15.9969C3.60984 15.9806 3.43609 15.9154 3.28717 15.8013C3.13824 15.6871 3.02241 15.5443 2.93967 15.3727C2.85694 15.2012 2.84039 15.0097 2.89003 14.7984L3.98216 10.1754L0.333471 7.06899C0.167998 6.92222 0.0647422 6.75492 0.0237048 6.56706C-0.0173325 6.37921 -0.00508757 6.19592 0.0604398 6.0172C0.126629 5.83782 0.225913 5.69106 0.358292 5.57692C0.49067 5.46277 0.672691 5.38939 0.904353 5.35677L5.71963 4.94095L7.5812 0.587044C7.66394 0.391363 7.79234 0.244602 7.96642 0.146761C8.1405 0.0489204 8.31822 0 8.49958 0C8.6816 0 8.85932 0.0489204 9.03273 0.146761C9.20615 0.244602 9.33456 0.391363 9.41795 0.587044L11.2795 4.94095L16.0948 5.35677C16.3265 5.38939 16.5085 5.46277 16.6409 5.57692C16.7732 5.69106 16.8725 5.83782 16.9387 6.0172C17.0049 6.19657 17.0175 6.38019 16.9764 6.56804C16.9354 6.7559 16.8318 6.92288 16.6657 7.06899L13.017 10.1754L14.1091 14.7984C14.1588 15.0104 14.1422 15.2022 14.0595 15.3737C13.9767 15.5452 13.8609 15.6878 13.712 15.8013C13.5631 15.9154 13.3893 15.9806 13.1907 15.9969C12.9922 16.0132 12.8019 15.9643 12.6199 15.8502L8.49958 13.4042Z" fill="#FFC83A"/></svg>
               <span class='rating-average'>{{averageRating}}</span>
               <span class='total-review'>( {{total_reviews}} <?php echo __('reviews', 'watergo'); ?>)</span>
               <button class='btn-action' @click='gotoReviewIndex(store.id)'><?php echo __('See all', 'watergo'); ?></button>
            </div>
            <div class='review-body'>
               <div v-for='(review, reviewKey) in reviews' :key='reviewKey'>
                  <div class='list-tile-review'>
                     <div class="text">{{ review.contents }}</div>
                     <div class="meta">
                        <svg width="13" height="12" viewBox="0 0 13 12" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M6.28201 10.0531L3.23672 11.8876C3.10219 11.9732 2.96154 12.0099 2.81478 11.9977C2.66802 11.9855 2.53961 11.9366 2.42954 11.8509C2.31947 11.7653 2.23386 11.6582 2.1727 11.5295C2.11155 11.4009 2.09932 11.2573 2.13601 11.0988L2.9432 7.63157L0.246467 5.30174C0.124166 5.19167 0.0478508 5.06619 0.0175202 4.9253C-0.0128104 4.78441 -0.00376021 4.64694 0.0446709 4.5129C0.0935912 4.37837 0.166972 4.2683 0.264812 4.18269C0.362653 4.09708 0.497184 4.04204 0.668405 4.01758L4.22736 3.70571L5.60324 0.440283C5.66439 0.293522 5.7593 0.183451 5.88796 0.110071C6.01662 0.0366903 6.14797 0 6.28201 0C6.41654 0 6.54789 0.0366903 6.67606 0.110071C6.80424 0.183451 6.89914 0.293522 6.96078 0.440283L8.33667 3.70571L11.8956 4.01758C12.0668 4.04204 12.2014 4.09708 12.2992 4.18269C12.3971 4.2683 12.4704 4.37837 12.5194 4.5129C12.5683 4.64743 12.5776 4.78514 12.5472 4.92603C12.5169 5.06692 12.4403 5.19216 12.3176 5.30174L9.62082 7.63157L10.428 11.0988C10.4647 11.2578 10.4525 11.4016 10.3913 11.5303C10.3302 11.6589 10.2446 11.7658 10.1345 11.8509C10.0244 11.9366 9.896 11.9855 9.74924 11.9977C9.60248 12.0099 9.46183 11.9732 9.3273 11.8876L6.28201 10.0531Z" fill="#FFC83A"/>
                        </svg>
                        <span>{{ ratingNumber(review.rating) }}</span>
                     </div>
                  </div>
               </div>
            </div>
         </div>

         <div v-if='products.length > 0' class="store-product mt30">
            <div class='gr-heading'><p class='heading'><?php echo __('Product', 'watergo'); ?></p></div>

            <div class="gr-btn style01">
               <button 
                  v-for='(type, keyType) in store_type' :key='keyType'
                  @click='select_product_type(type.value)' 
                  :class='type.active == true ? "active" : ""'
               >{{ type.label}}</button>
            </div>


            <div v-if='products.length > 0' class='grid-masonry list-product-by-store'>

               <div 
                  @click='gotoProductDetail(product.id)' 
                  class='product-design' 
                  v-for='(product, index) in filter_product ' :key='index'
                  :class='product.product_image.dummy != undefined ? "img-dummy" : "" '
               >
                  <div class='img'>
                     <img :src='product.product_image.url'>
                     <span v-show='has_discount(product) == true' class='badge-discount'>-{{ product.discount_percent }}%</span>
                     <span v-show='product_is_mark_out_of_stock(product) == true' 
                        class='badge-discount badge-out-of-stock size-large'><?php echo __('Out of Stock', 'watergo'); ?></span>
                  </div>
                  <div class='box-wrapper'>
                     <p class='tt01'>{{ product.name }} </p>
                     <p class='tt02'>{{ product.name_second }}</p>
                     <div class='gr-price' :class="has_discount(product) == true ? 'has_discount' : '' ">
                        <span class='price'>
                           {{ common_price_after_discount(product ) }}
                        </span>
                        <span v-if='has_discount(product) == true' class='price-sub'>
                           {{ common_price_show_currency(product.price) }}
                        </span>
                        <span v-show='has_gift(product) == true' class='badge-gift'>
                           <span class='icon'>
                              <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                              <path d="M12.0002 7.91235V19.3409M5.14307 11.3409H18.8574V17.0552C18.8574 17.6614 18.6165 18.2428 18.1879 18.6715C17.7592 19.1001 17.1778 19.3409 16.5716 19.3409H7.42878C6.82257 19.3409 6.24119 19.1001 5.81254 18.6715C5.38388 18.2428 5.14307 17.6614 5.14307 17.0552V11.3409Z" stroke="#2790F9" stroke-linecap="round" stroke-linejoin="round"/>
                              <path d="M12 7.9123H8.57143C7.67886 7.01973 7.67886 5.3763 8.57143 4.48373C9.464 3.59115 12 3.9123 12 5.62658M12 7.9123V5.62658M12 7.9123H15.4286C16.3211 7.01973 16.3211 5.3763 15.4286 4.48373C14.536 3.59115 12 3.9123 12 5.62658M5.14286 7.9123H18.8571C19.1602 7.9123 19.4509 8.0327 19.6653 8.24703C19.8796 8.46136 20 8.75205 20 9.05515V10.198C20 10.5011 19.8796 10.7918 19.6653 11.0061C19.4509 11.2205 19.1602 11.3409 18.8571 11.3409H5.14286C4.83975 11.3409 4.54906 11.2205 4.33474 11.0061C4.12041 10.7918 4 10.5011 4 10.198V9.05515C4 8.75205 4.12041 8.46136 4.33474 8.24703C4.54906 8.0327 4.83975 7.9123 5.14286 7.9123Z" stroke="#2790F9" stroke-linecap="round" stroke-linejoin="round"/>
                              </svg>
                           </span>
                           <span class='text'>{{ product.gift_text}}</span>
                        </span>
                     </div>
                  </div>
               </div>


            </div>
         </div>
      </div>

   </div>

   <div class='modal-popup' :class=' loading == false && ( store == null || store.store_hidden == 1 ) ? "open" : ""'>
      <div class='modal-wrapper'>
         <div class='modal-close'><div @click='goBack' class='close-button'><span></span><span></span></div></div>
         <p class='heading'><?php echo __('Content Not Found', 'watergo'); ?> </p>
      </div>
   </div>

   <div v-show="loading == true">
      <div class='progress-center'>
         <div class='progress-container enabled'><progress class='progress-circular enabled'></progress></div>
      </div>
   </div>

</div>

<script>
var app = Vue.createApp({
   data (){
      return {
         loading: false,
         store_id: 0,
         latitude: 10.780900239854994,
         longitude: 106.7226271387539,

         reviews: [],
         products: [],
         store: null,
         page: 0,
         limit: 10,

         product_by_store: [],
         total_reviews: 0,
         averageRating: 0,

         store_type: [],

         // 0 -> false 1 -> true 
         user_current_is_store: 0,

         callback_cart_count: 0,
         callback_notification_count: 0,
      }
   },

   watch: {
      products: {
         handler(data){
            jQuery(document).ready(function($){
               jQuery('.box-wrapper').matchHeight({ property: 'min-height' });
            });
         }, deep: true
      }
   },

   methods: {
      
      is_store_avatar_dummy( store_image ){
         if( this.store != null && store_image != undefined && store_image.dummy != undefined ){
            return 'dummy';
         }
      },

      async get_current_location(){

         if( window.appBridge != undefined ){
            await window.appBridge.getLocation().then( (data) => {
               if (Object.keys(data).length === 0) {
                  // alert("Error-1 :Không thể truy cập vị trí");
               }else{
                  let lat = data.lat;
                  let lng = data.lng;
                  this.latitude = data.lat;
                  this.longitude = data.lng;
               }
            });
         }
      },

      has_discount( product ){return window.has_discount(product);},
      has_gift( product ){return window.has_gift(product);},
      product_is_mark_out_of_stock( product ){ return window.product_is_mark_out_of_stock(product); },
      common_price_show_currency(p){ return window.common_price_show_currency(p) },
      common_price_after_discount(p){ return window.common_price_after_discount(p) },
      ratingNumber(rating){ return parseInt(rating).toFixed(1); },

      async findStore( store_id ){

         var form = new FormData();
         form.append('action', 'atlantis_find_store');
         form.append('store_id', store_id);
         var r = await window.request(form);

         if( r != undefined ){
            var res = JSON.parse( JSON.stringify(r));
            if(res.message == 'store_found' ){
               var _distance = window.calculateDistance(
                  this.latitude,
                  this.longitude,
                  res.data.latitude,
                  res.data.longitude
               );

               res.data.distance = parseFloat(_distance).toFixed(1) + ' km';
               this.store = res.data;

               await this.findReview(store_id);
               await this.get_total_review(store_id);


               if( this.store.store_type == "both" ){

                  var _both = [
                     {label: '<?php echo __("Water", 'watergo'); ?>', value: "water", active: false},
                     {label: '<?php echo __("Ice", 'watergo'); ?>', value: "ice", active: false}
                  ];

                  this.store_type.push(..._both);
                  this.store_type[0].active = true;

               }else if(this.store.store_type == "water"){
                  this.store_type.push({label: '<?php echo __("Water", 'watergo'); ?>', value: "water", active: true});   
               }else if(this.store.store_type == "ice"){
                  this.store_type.push({label: '<?php echo __("Ice", 'watergo'); ?>', value: "ice", active: true });
               }


               await this.get_all_product_by_store(store_id)
               await this.get_review_rating_average(store_id);

            }
         }
         


      },

      async findReview( store_id){
         var form = new FormData();
         form.append('action', 'atlantis_get_review_store');
         form.append('store_id', store_id);
         form.append('extension', 'small');
         var r = await window.request(form);
         if( r != undefined ){
            var res = JSON.parse( JSON.stringify(r));
            if( res.message == 'review_found' ){
               this.reviews.push( ...res.data );
            }
         }
      },

      async get_all_product_by_store( store_id){
         var form = new FormData();
         form.append('action', 'atlantis_get_all_product_by_store');
         form.append('store_id', store_id);
         form.append('limit', -1);
         var r = await window.request(form);
         console.log()
         if( r != undefined ){
            var res = JSON.parse( JSON.stringify(r));
            if( res.message == 'product_found' ){
               this.products.push( ...res.data);
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

      select_product_type( value ){
         this.store_type.some( item => {
            if( item.value == value ){
               item.active = true;
            }else{
               item.active = false;
            }
         });
      },

      async atlantis_notification_mark_read_notification_hash_id(hash_id){
         var form = new FormData();
         form.append('action', 'atlantis_notification_mark_read_notification_hash_id');
         form.append('hash_id', hash_id);
         var r = await window.request(form);
      },

      gotoProductDetail(product_id){
         if( this.user_current_is_store == 0 ){
            window.gotoProductDetail(product_id);   
         }
      },

      gotoReviewIndex( store_id){ window.gotoReviewIndex(store_id);},
      gotoPageStoreEdit(){ window.gotoPageStoreEdit()},

      goBack(){ 
         window.location.href = '?appt=X&data=notification_count';
      },
      goBackUpdate( store_id ){ 
         window.location.href = `?appt=X&data=store_detail_profile_update|store_id=${store_id}`;
      },

   },

   
   computed: {
      get_distance_from_location(){
         var _d = 0;
         _d = setTimeout( () => {
            if( this.user_current_is_store == 0 ){
               var _distance = window.calculateDistance(
                  this.latitude,
                  this.longitude,
                  this.store.latitude,
                  this.store.longitude
               );

               if( parseFloat(_distance).toFixed(1) > 0){
                  return parseFloat(_distance).toFixed(1) + ' km';
               }else{
                  return 0;
               }
            }
         }, 200);
         if( _d !== 0){
            return _d;
         }
      },

      filter_product(){
         return this.products.filter( product => {
            var _findType = this.store_type.find( type => type.active == true );

            if(_findType.value == 'water'){
               return product.product_type == 'water' || product.product_type == 'water_device';
            }else if(_findType.value == 'ice'){
               return product.product_type == 'ice' || product.product_type == 'ice_device';
            }else{
               return product;
            }
         });
      },

      
   },

   async created(){

      this.user_current_is_store = <?php echo $is_user_store; ?>;

      const urlParams            = new URLSearchParams(window.location.search);
      this.store_id              = urlParams.get('store_id');
      const hash_id              = urlParams.get('hash_id');

      if( hash_id != undefined ){
         await this.atlantis_notification_mark_read_notification_hash_id(hash_id);
      }

      this.loading = true;

      await this.get_current_location();
      await this.findStore(this.store_id);

      window.appbar_fixed();

      jQuery(document).ready(function($){
         jQuery('.box-wrapper').matchHeight({ property: 'min-height' });
      });

      this.loading = false;
   }

}).mount('#app');
window.app = app;

</script>