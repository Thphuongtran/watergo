const PageStoreDetail = {
   name: 'PageStoreDetail',
   template: `
<div 
   v-if='
      $root.navigator == "store-detail" &&
      store != null &&
      loading == false
      ' 
      class="page-store-detail">
   
   <div class='product-detail-wrapper'>
      <div class='product-header'>
         <div class='top'>
            <button @click='$root.goBack' class='btn-action'>
               <svg width="28" height="28" viewBox="0 0 28 28" fill="none" xmlns="http://www.w3.org/2000/svg">
               <circle cx="14" cy="14" r="14" fill="black" fill-opacity="0.2"/>
               <path fill-rule="evenodd" clip-rule="evenodd" d="M4 14C4 13.4477 4.44772 13 5 13H22.5C23.0523 13 23.5 13.4477 23.5 14C23.5 14.5523 23.0523 15 22.5 15H5C4.44772 15 4 14.5523 4 14Z" fill="white"/>
               <path fill-rule="evenodd" clip-rule="evenodd" d="M14.5309 6.37534C14.8759 6.8066 14.806 7.4359 14.3747 7.78091L6.60078 14L14.3747 20.2192C14.806 20.5642 14.8759 21.1935 14.5309 21.6247C14.1859 22.056 13.5566 22.1259 13.1253 21.7809L4.3753 14.7809C4.13809 14.5911 4 14.3038 4 14C4 13.6963 4.13809 13.4089 4.3753 13.2192L13.1253 6.21917C13.5566 5.87416 14.1859 5.94408 14.5309 6.37534Z" fill="white"/>
               </svg>
            </button>

            <button class='btn-action'>
               <svg width="28" height="28" viewBox="0 0 28 28" fill="none" xmlns="http://www.w3.org/2000/svg">
               <circle cx="14" cy="14" r="14" transform="matrix(-1 0 0 1 28 0)" fill="black" fill-opacity="0.2"/>
               <path fill-rule="evenodd" clip-rule="evenodd" d="M7.9999 12.15C8.46934 12.15 8.8499 12.5306 8.8499 13V19.4C8.8499 19.5989 8.92892 19.7897 9.06957 19.9304C9.21022 20.071 9.40099 20.15 9.5999 20.15H19.1999C19.3988 20.15 19.5896 20.071 19.7302 19.9304C19.8709 19.7897 19.9499 19.5989 19.9499 19.4V13C19.9499 12.5306 20.3305 12.15 20.7999 12.15C21.2693 12.15 21.6499 12.5306 21.6499 13V19.4C21.6499 20.0498 21.3918 20.673 20.9323 21.1324C20.4728 21.5919 19.8497 21.85 19.1999 21.85H9.5999C8.95012 21.85 8.32695 21.5919 7.86749 21.1324C7.40803 20.673 7.1499 20.0498 7.1499 19.4V13C7.1499 12.5306 7.53046 12.15 7.9999 12.15Z" fill="white"/>
               <path fill-rule="evenodd" clip-rule="evenodd" d="M13.7991 4.39898C14.131 4.06704 14.6692 4.06704 15.0011 4.39898L18.2011 7.59898C18.5331 7.93093 18.5331 8.46912 18.2011 8.80106C17.8692 9.13301 17.331 9.13301 16.9991 8.80106L14.4001 6.20211L11.8011 8.80106C11.4692 9.13301 10.931 9.13301 10.5991 8.80106C10.2671 8.46912 10.2671 7.93093 10.5991 7.59898L13.7991 4.39898Z" fill="white"/>
               <path fill-rule="evenodd" clip-rule="evenodd" d="M14.3998 4.15002C14.8692 4.15002 15.2498 4.53058 15.2498 5.00002V15.4C15.2498 15.8695 14.8692 16.25 14.3998 16.25C13.9304 16.25 13.5498 15.8695 13.5498 15.4V5.00002C13.5498 4.53058 13.9304 4.15002 14.3998 4.15002Z" fill="white"/>
               </svg>
            </button>
         </div>

         <div class='main'> 
            <img :src="get_image_store(store.id)">
         </div>
      </div>
   </div>

   <div class="inner">
      <div class='product-design product-detail'>
         <p class='tt01'>{{ store.name }}</p>
         <p class='tt02'>{{ get_distance_from_location }}</p>
         <p class='tt03'> {{ store.description }}</p>
      </div>

      <div v-if='reviews.length > 0' class='store-review'>
         <div class='review-head'>

         </div>
         <div class='review-body'>
            <div v-for='(review, reviewKey) in reviews' :key='reviewKey' class='list-tile-review'>
               <div class="review-item">
                  <div class="text">{{ review.contents }}</div>
                  <div class="meta">
                     <svg width="13" height="12" viewBox="0 0 13 12" fill="none" xmlns="http://www.w3.org/2000/svg">
                     <path d="M6.28201 10.0531L3.23672 11.8876C3.10219 11.9732 2.96154 12.0099 2.81478 11.9977C2.66802 11.9855 2.53961 11.9366 2.42954 11.8509C2.31947 11.7653 2.23386 11.6582 2.1727 11.5295C2.11155 11.4009 2.09932 11.2573 2.13601 11.0988L2.9432 7.63157L0.246467 5.30174C0.124166 5.19167 0.0478508 5.06619 0.0175202 4.9253C-0.0128104 4.78441 -0.00376021 4.64694 0.0446709 4.5129C0.0935912 4.37837 0.166972 4.2683 0.264812 4.18269C0.362653 4.09708 0.497184 4.04204 0.668405 4.01758L4.22736 3.70571L5.60324 0.440283C5.66439 0.293522 5.7593 0.183451 5.88796 0.110071C6.01662 0.0366903 6.14797 0 6.28201 0C6.41654 0 6.54789 0.0366903 6.67606 0.110071C6.80424 0.183451 6.89914 0.293522 6.96078 0.440283L8.33667 3.70571L11.8956 4.01758C12.0668 4.04204 12.2014 4.09708 12.2992 4.18269C12.3971 4.2683 12.4704 4.37837 12.5194 4.5129C12.5683 4.64743 12.5776 4.78514 12.5472 4.92603C12.5169 5.06692 12.4403 5.19216 12.3176 5.30174L9.62082 7.63157L10.428 11.0988C10.4647 11.2578 10.4525 11.4016 10.3913 11.5303C10.3302 11.6589 10.2446 11.7658 10.1345 11.8509C10.0244 11.9366 9.896 11.9855 9.74924 11.9977C9.60248 12.0099 9.46183 11.9732 9.3273 11.8876L6.28201 10.0531Z" fill="#FFC83A"/>
                     </svg>
                     <span>{{ review.rating }}</span>
                  </div>
               </div>
            </div>
         </div>
      </div>

      <div class='gr-heading'><p class='heading'>Product</p></div>
      
      <div class="store-product">
         <div class="gr-btn style01">
            <button>Water</button>
            <button>Ice</button>
         </div>
      </div>

      <div class='grid-masonry'>
         <div 
            @click='$root.gotoPage("product-detail",{ product_id: product.id, store_id: store.store_id, back: "store-detail" })' 
            class='product-design' 
            v-for='(product, index) in get_product_water ' :key='index'>
            <div class='img'>
               <img :src='get_image_product(product.id)'>
               <span v-if='has_discount(product) == true' class='badge-discount'>-{{ product.discount_percent }}%</span>
            </div>
            <div class='box-wrapper'>
               <p class='tt01'>{{ product.name }} </p>
               <p class='tt02'>{{ get_product_quantity(product) }}</p>
               <div class='gr-price' :class="has_discount(product) == true ? 'has_discount' : '' ">
                  <span class='price'>
                     {{ has_discount(product) == true 
                        ? common_get_product_price(product.price, product.discount_percent) 
                        : common_get_product_price(product.price)
                     }}
                  </span>
                  <span v-if='has_discount(product) == true' class='price-sub'>
                     {{ common_get_product_price(product.price) }}
                  </span>
               </div>
            </div>
         </div>
      </div>



   </div>

</div>
<div v-if="loading == true">
   <div class='progress-center'>
      <div class='progress-container enabled'><progress class='progress-circular enabled'></progress></div>
   </div>
</div>
   `,

   data(){
      return {
         loading: false,
         reviews: [],
         products: [],
         store: null,
         page: 0,
         limit: 10,
         product_by_store: [],
         total_reviews: 0,
      }
   },

   methods: {
      request( formdata ){
         try{
            return axios({ method: 'post', url: get_ajaxadmin, data: formdata
            }).then(function (res) { 
               return res.status == 200 ? res.data.data : null;
            });
         }catch(e){
            console.log(e);
            return null;
         }
      },

      get_image_product(product_id){
         return get_template_directory_uri + '/assets/images/demo-product01.png';
      },
      has_discount( product ){
         if( product.discount_id == null ) return false;
         return true;
      },

      get_image_store( store_id ){
         return get_template_directory_uri + '/assets/images/demo-home-slide01.png';
      },

      get_product_quantity( product ){
         if(product.product_type == "water" ) return product.quantity;
         if(product.product_type == "ice" ) return product.weight + "kg " + product.length_width + "mm";
      },

      common_get_product_price( price, discount_percent ){
         if( discount_percent == undefined || discount_percent == null || discount_percent == 0){
            return parseInt(price).toLocaleString('vi-VN') + ' đ';
         }
         var _price = price - ( price * ( discount_percent / 100 ) );
         if( _price == 0 ) return 0 + ' đ';
         return parseInt(_price).toLocaleString('vi-VN') + ' đ';
      },


      async findStore( store_id ){
         this.loading = true;
         var _checkStore = this.$root.stores.some( item => item.id == store_id );
         if(_checkStore == true ){
            this.store = this.$root.stores.find( item => item.id == store_id );
         }else{
            var form = new FormData();
            form.append('action', 'atlantis_find_store');
            form.append('store_id', store_id);
            var r = await this.request(form);
            if( r != undefined ){
               var res = JSON.parse( JSON.stringify(r));
               if(res.message == 'store_found' ){
                  this.store = res.data;
                  res.data.products = [];
                  this.$root.stores.push( res.data );
               }
            }
         }
         await this.get_total_review();
         await this.findReview();
         await this.findRelatedProductInStore();
         this.loading = false;
         console.log(this.products);

      },

      async get_total_review(){
         var form = new FormData();
         form.append('action', 'atlantis_count_reviews');
         form.append('store_id', this.store.id);
         var r = await this.request(form);
         if( r != undefined ){
            var res = JSON.parse( JSON.stringify(r));
            if( res.message == 'review_found' ){
               this.total_reviews = res.data;
            }
         }
      },

      async findReview(){
         var form = new FormData();
         form.append('action', 'atlantis_reviews');
         form.append('store_id', this.store.id);
         form.append('page', this.page);
         form.append('limit', this.limit);
         var r = await this.request(form);
         if( r != undefined ){
            var res = JSON.parse( JSON.stringify(r));
            if( res.message == 'review_found' ){
               this.reviews.push( ...res.data );
            }
         }
      },

      async findRelatedProductInStore(){
         var form = new FormData();
         form.append('action', 'atlantis_load_all_product_by_store');
         form.append('store_id', this.store.id);
         var r = await this.request(form);
         if( r != undefined ){
            var res = JSON.parse( JSON.stringify(r));
            if( res.message == 'product_found' ){
               this.products.push( ...res.data);
            }
         }
      }


   },

   
   computed: {
      get_distance_from_location(){
         var latitude = this.store.latitude;
         var longitude = this.store.longitude;
         return '2 km';
      },

      get_product_water(){
         return this.products.filter(product => product.product_type == "water");
      },

      get_product_ice(){
         return this.products.filter(product => product.product_type == "ice");
      }


   },

   created(){

   },

   mounted(){

   }

}