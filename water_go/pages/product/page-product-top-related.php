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
.badge-gift {
   position: relative;
   width: 100%;
}
.badge-gift .icon {
   position: absolute;
   top: -2px;
}
.badge-gift .text {
   padding-left: 25px;
   line-height: 20px;
}
.grid-masonry{
   padding-bottom: 50px;
}
</style>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.matchHeight/0.7.2/jquery.matchHeight-min.js" integrity="sha512-/bOVV1DV1AQXcypckRwsR9ThoCj7FqTV2/0Bm79bL3YSyLkVideFLE3MIZkq1u5t28ke1c0n31WYCOrO01dsUg==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<div id='app'>

   <div v-if='loading == false' class='page-recommend' :class='sortFeatureOpen == true ? "add-overlay" : ""'>
      <div class='appbar'>
         <div class='appbar-top'>

            <div class='leading'>
               <button @click='goBack' class='btn-action'>
                  <svg width="11" height="16" viewBox="0 0 11 16" fill="none" xmlns="http://www.w3.org/2000/svg">
                  <path fill-rule="evenodd" clip-rule="evenodd" d="M10.5309 0.375342C10.8759 0.806604 10.806 1.4359 10.3747 1.78091L2.60078 8.00004L10.3747 14.2192C10.806 14.5642 10.8759 15.1935 10.5309 15.6247C10.1859 16.056 9.55657 16.1259 9.12531 15.7809L0.375305 8.78091C0.13809 8.59113 0 8.30382 0 8.00004C0 7.69625 0.13809 7.40894 0.375305 7.21917L9.12531 0.219168C9.55657 -0.125842 10.1859 -0.0559202 10.5309 0.375342Z" fill="#252831"/>
                  </svg>
               </button>
               <span class='leading-title'><?php echo __('Top Products', 'watergo'); ?></span>
            </div>
            <!-- <div class='action'>
               <div @click='buttonSortFeature' class='btn-text'>
                  <svg width="16" height="14" viewBox="0 0 16 14" fill="none" xmlns="http://www.w3.org/2000/svg">
                  <path d="M1.50197e-05 1.08889V0.252778V1.08889ZM1.50197e-05 1.08889C-0.000569119 1.17459 0.0158907 1.25955 0.0484373 1.33883M1.50197e-05 1.08889L0.0484373 1.33883M0.0484373 1.33883C0.0809839 1.41811 0.128968 1.49013 0.189598 1.55069M0.0484373 1.33883L0.189598 1.55069M0.189598 1.55069L6.02293 7.38403L0.189598 1.55069ZM6.55326 6.8537L0.750015 1.05045V0.75H14.8056V1.05531L9.01691 6.84398L8.79724 7.06365V7.37431V12.7887L6.77293 11.7808V7.38403V7.07337L6.55326 6.8537ZM0.719656 1.02009C0.719747 1.02018 0.719838 1.02027 0.719929 1.02036L0.719656 1.02009Z" fill="#2790F9" stroke="#2790F9" stroke-width="1.5"/>
                  </svg>
                  <span class='text'>Sort</span>
               </div>
            </div> -->
         </div>
      </div>

      <!-- <div v-if='sortFeatureOpen == true' class='box-sort' :class='sortFeatureOpen == true ? "active" : ""'>
         <ul>
            <li @click='buttonSortFeatureSelected(0)' :class='sortFeatureCurrentValue == 0 ? "active" : ""'><?php echo __('Nearest'); ?></li>
            <li @click='buttonSortFeatureSelected(1)' :class='sortFeatureCurrentValue == 1 ? "active" : ""'><?php echo __('Cheapest'); ?></li>
            <li @click='buttonSortFeatureSelected(2)' :class='sortFeatureCurrentValue == 2 ? "active" : ""'><?php echo __('Top Rated'); ?></li>
         </ul>
      </div> -->

      <div v-if='products.length > 0 && loading == false ' class='inner'>
         <div class='grid-masonry'>
            <div 
               @click='gotoProductDetail(product.id)' 
               class='product-design' 
               v-for='(product, index) in filter_products' :key='index'
               :class='product.product_image.dummy != undefined ? "img-dummy" : "" '
            >
               <div class='img'>
                  <img :src='product.product_image.url'>
                  <span v-if='has_discount(product) == true' class='badge-discount'>-{{ product.discount_percent }}%</span>
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
   <div v-if='loading == true'>
      <div class='progress-center'>
         <div class='progress-container enabled'><progress class='progress-circular enabled' ></progress></div>
      </div>
   </div>
</div>
<script>

var { createApp } = Vue;

createApp({
   data (){
      return {
         loading: false,
         products: [],
         sortFeatureOpen: false,
         sortFeatureCurrentValue: 0,
         latitude: 10.780900239854994,
         longitude: 106.7226271387539,
         
         paged: 0,
         category_id: 0,
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
      has_gift( product ){ return window.has_gift( product ); },
      
      get_current_location(){

         if( window.appBridge !== undefined ){
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


      async get_top_related_product( paged ){
         var form = new FormData();
         form.append('action', 'atlantis_get_product_top_related');
         form.append('category_id', this.category_id);
         form.append('paged', paged);
         var r = await window.request(form);
         if( r != undefined ){
            var res = JSON.parse( JSON.stringify( r));
            if( res.message == 'product_found' ){
               res.data.forEach( item => {
                  if (!this.products.some(existingItem => existingItem.id === item.id)) {
                     this.products.push( item );
                  }
               });
            }
         }
      },

      async handleScroll() {
         const windowTop = window.pageYOffset || document.documentElement.scrollTop;
         const scrollEndThreshold = 50; // Adjust this value as needed
         const scrollPosition = window.pageYOffset || document.documentElement.scrollTop;
         const windowHeight = window.innerHeight;
         const documentHeight = document.documentElement.scrollHeight;

         var windowScroll     = scrollPosition + windowHeight + scrollEndThreshold;
         var documentScroll   = documentHeight + scrollEndThreshold;

         // if (scrollPosition + windowHeight + scrollEndThreshold >= documentHeight - scrollEndThreshold) {
         if (scrollPosition + windowHeight >= documentHeight ) {
            
            await this.get_top_related_product( this.paged++);
         }
      },

      buttonSortFeatureSelected( index ){
         this.sortFeatureCurrentValue = index;
         this.sortFeatureOpen = false;
      },

      buttonSortFeature(){  
         if( this.sortFeatureOpen == false){
            this.sortFeatureOpen = true;
         }else{
            this.sortFeatureOpen = false;
         }
      },

      has_discount( product ){ return window.has_discount( product ); },      
      product_is_mark_out_of_stock( product ){ return window.product_is_mark_out_of_stock(product); },
      common_price_show_currency(p){ return common_price_show_currency(p) },
      common_price_after_discount(p){ return common_price_after_discount(p) },
      
      
      gotoProductDetail(product_id){ window.gotoProductDetail(product_id);},
      goBack(){ window.goBack(); },

   },

   computed: {
      filter_products(){
         var _filter = this.products;
         // nearest 0 
         // cheapest 1
         // top rated 2

         if(this.sortFeatureCurrentValue == 2 ){
            _filter.sort((a, b) => b.avg_rating - a.avg_rating);
         }
         
         // Sort products by price in ascending order (cheapest first)
         else if(this.sortFeatureCurrentValue == 1 ){
            _filter.sort((a, b) => a.price - b.price);
         }

         // Filter products by distance (assuming you have access to user's location)
         else if(this.sortFeatureCurrentValue == 0 ){
            _filter.sort((a, b) => a.distance - b.distance);
         }

         return _filter;
      }
   },


   mounted() {
      window.addEventListener('scroll', this.handleScroll);
   },
   beforeDestroy() {
      window.removeEventListener('scroll', this.handleScroll);
   },

   async created() {
      this.loading = true; 
      const urlParams = new URLSearchParams(window.location.search);
      const category_id = urlParams.get('category_id');
      this.category_id = category_id;
      await this.get_top_related_product(0 );
      this.get_current_location();
      window.appbar_fixed();
      this.loading = false;
   }

}).mount('#app');
</script>
