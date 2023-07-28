<div id='app'>

   <div v-if='loading == false' class='page-recommend' :class='sortFeatureOpen == true ? "add-overlay" : ""'>
      <div class='appbar style01'>
         <div class='appbar-top'>

            <div class='leading'>
               <button @click='goBack' class='btn-action'>
                  <svg width="11" height="16" viewBox="0 0 11 16" fill="none" xmlns="http://www.w3.org/2000/svg">
                  <path fill-rule="evenodd" clip-rule="evenodd" d="M10.5309 0.375342C10.8759 0.806604 10.806 1.4359 10.3747 1.78091L2.60078 8.00004L10.3747 14.2192C10.806 14.5642 10.8759 15.1935 10.5309 15.6247C10.1859 16.056 9.55657 16.1259 9.12531 15.7809L0.375305 8.78091C0.13809 8.59113 0 8.30382 0 8.00004C0 7.69625 0.13809 7.40894 0.375305 7.21917L9.12531 0.219168C9.55657 -0.125842 10.1859 -0.0559202 10.5309 0.375342Z" fill="#252831"/>
                  </svg>
               </button>
               <span class='leading-title'>Recommend</span>
            </div>
            <div class='action'>
               <div @click='buttonSortFeature' class='btn-text'>
                  <svg width="16" height="14" viewBox="0 0 16 14" fill="none" xmlns="http://www.w3.org/2000/svg">
                  <path d="M1.50197e-05 1.08889V0.252778V1.08889ZM1.50197e-05 1.08889C-0.000569119 1.17459 0.0158907 1.25955 0.0484373 1.33883M1.50197e-05 1.08889L0.0484373 1.33883M0.0484373 1.33883C0.0809839 1.41811 0.128968 1.49013 0.189598 1.55069M0.0484373 1.33883L0.189598 1.55069M0.189598 1.55069L6.02293 7.38403L0.189598 1.55069ZM6.55326 6.8537L0.750015 1.05045V0.75H14.8056V1.05531L9.01691 6.84398L8.79724 7.06365V7.37431V12.7887L6.77293 11.7808V7.38403V7.07337L6.55326 6.8537ZM0.719656 1.02009C0.719747 1.02018 0.719838 1.02027 0.719929 1.02036L0.719656 1.02009Z" fill="#2790F9" stroke="#2790F9" stroke-width="1.5"/>
                  </svg>
                  <span class='text'>Sort</span>
               </div>
            </div>
         </div>
         <div class='appbar-bottom'>
            <div v-if='sortFeatureOpen == true' class='box-sort' :class='sortFeatureOpen == true ? "active" : ""'>
               <ul>
                  <li @click='buttonSortFeatureSelected(0)' :class='sortFeatureCurrentValue == 0 ? "active" : ""'>Nearest</li>
                  <li @click='buttonSortFeatureSelected(1)' :class='sortFeatureCurrentValue == 1 ? "active" : ""'>Cheapest</li>
                  <li @click='buttonSortFeatureSelected(2)' :class='sortFeatureCurrentValue == 2 ? "active" : ""'>Top Rated</li>
               </ul>
            </div>
         </div>
      </div>

      <div v-if='products.length > 0 && loading == false ' class='inner'>
         <div class='grid-masonry'>
            <div @click='gotoProductDetail(product.id)' 
               class='product-design' 
               v-for='(product, index) in filter_products' :key='index'>
               <div class='img'>
                  <img :src='product.product_image.url'>
                  <span v-if='has_discount(product) == true' class='badge-discount'>-{{ product.discount_percent }}%</span>
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
<script type='module'>

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

      }
   },

   methods: {

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
            }).catch((e) => { alert(e); })
         }
      },

      buttonSortFeatureSelected( index ){
         this.sortFeatureCurrentValue = index;
         this.sortFeatureOpen = false;
         window.bodyScrollToggle('remove');
      },

      buttonSortFeature(){
         this.sortFeatureOpen = !this.sortFeatureOpen;
         window.bodyScrollToggle();
      },

      has_discount( product ){ return window.has_discount(product); },
      common_price_show_currency(p){ return window.common_price_show_currency(p) },
      common_price_after_discount(p){ return window.common_price_after_discount(p) },

      gotoProductDetail(product_id){ window.gotoProductDetail(product_id);},
      goBack(){ window.goBack(); },

      get_text_filter(  ){
         switch( this.sortFeatureCurrentValue ){
            case 0: return 'nearest'; break;
            case 1: return 'cheapest'; break;
            case 2: return 'top_rated'; break;
         }
      },

      async handleScroll() {
         const windowTop            = window.pageYOffset || document.documentElement.scrollTop;
         const scrollEndThreshold   = 50; // Adjust this value as needed
         const scrollPosition       = window.pageYOffset || document.documentElement.scrollTop;
         const windowHeight         = window.innerHeight;
         const documentHeight       = document.documentElement.scrollHeight;

         var windowScroll     = scrollPosition + windowHeight + scrollEndThreshold;
         var documentScroll   = documentHeight + scrollEndThreshold;

         if (scrollPosition + windowHeight + 10 >= documentHeight - 10) {
            await this.load_product_sort( this.get_text_filter(), this.paged++);
         }
      },

      async load_product_sort( filter, paged ){


         var form = new FormData();
         form.append('action', 'atlantis_load_product_recommend');
         form.append('lat', this.latitude);
         form.append('lng', this.longitude);
         form.append('filter', filter );
         form.append('paged', paged );
         
         var r = await window.request(form);
         console.log(r);
         if( r != undefined ){
            var res = JSON.parse( JSON.stringify( r));
            if( res.message == 'product_found' ){
               // this.products.push(...res.data );
               res.data.forEach(item => {
                  if (! this.products.some(existingItem => existingItem.id === item.id)) {
                     this.products.push(item);
                  }
               });
            }

         }
         
      }

   },

   computed: {
      filter_products(){
         var _filter = this.products;

         if(this.sortFeatureCurrentValue == 2 ){
            // console.log('Top Rated Filter');
            _filter.sort((a, b) => b.avg_rating - a.avg_rating);
         }
         else if(this.sortFeatureCurrentValue == 1 ){
            // console.log('Top Cheapest');
            _filter.sort((a, b) => a.price - b.price);
         }
         else if(this.sortFeatureCurrentValue == 0 ){
            // console.log('Nearest');
            _filter.sort((a, b) => a.distance - b.distance);
         }

         return _filter;

      }
   },

   // STREAM 
   watch: {

      products: function ( product ){
         console.log('stream product');
      },

      sortFeatureCurrentValue: async function( val ){

         if( val == 0 ){
            this.products = [];
            this.loading = true;
            await this.load_product_sort(this.get_text_filter(), 0);
            this.loading = false;
            window.appbar_fixed();
         }
         if( val == 1 ){
            this.products = [];
            this.loading = true;
            await this.load_product_sort(this.get_text_filter(), 0);
            this.loading = false;
            window.appbar_fixed();
         }
         if( val == 2 ){
            this.products = [];
            this.loading = true;
            await this.load_product_sort(this.get_text_filter(), 0);
            this.loading = false;
            window.appbar_fixed();
         }
      }
   },

   mounted() {
      window.addEventListener('scroll', this.handleScroll);
   },
   beforeDestroy() {
      window.removeEventListener('scroll', this.handleScroll);
   },

   async created() {
      this.get_current_location();
      this.loading = true;
      await this.load_product_sort('nearest', [0]);
      
      this.loading = false;
      window.appbar_fixed();

   },

}).mount('#app');
</script>
