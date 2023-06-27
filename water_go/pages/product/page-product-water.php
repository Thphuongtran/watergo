<div id='app'>
   <div v-if='loading == false' class='page-product-water' :class='sortFeatureOpen == true ? "add-overlay" : ""'>
      <div class='appbar'>
         <div class='appbar-top'>
            <div class='leading'>
               <button @click='goBack' class='btn-action'>
                  <svg width="11" height="16" viewBox="0 0 11 16" fill="none" xmlns="http://www.w3.org/2000/svg">
                  <path fill-rule="evenodd" clip-rule="evenodd" d="M10.5309 0.375342C10.8759 0.806604 10.806 1.4359 10.3747 1.78091L2.60078 8.00004L10.3747 14.2192C10.806 14.5642 10.8759 15.1935 10.5309 15.6247C10.1859 16.056 9.55657 16.1259 9.12531 15.7809L0.375305 8.78091C0.13809 8.59113 0 8.30382 0 8.00004C0 7.69625 0.13809 7.40894 0.375305 7.21917L9.12531 0.219168C9.55657 -0.125842 10.1859 -0.0559202 10.5309 0.375342Z" fill="#252831"/>
                  </svg>
               </button>
               <p class='leading-title'>Water</p>
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
      </div>

      <div v-if='sortFeatureOpen == true' class='box-sort' :class='sortFeatureOpen == true ? "active" : ""'>
         <ul>
            <li @click='buttonSortFeatureSelected(0)' :class='sortFeatureCurrentValue == 0 ? "active" : ""'>Nearest</li>
            <li @click='buttonSortFeatureSelected(1)' :class='sortFeatureCurrentValue == 1 ? "active" : ""'>Cheapest</li>
            <li @click='buttonSortFeatureSelected(2)' :class='sortFeatureCurrentValue == 2 ? "active" : ""'>Top Rated</li>
         </ul>
      </div>

      <div class='overlay-layer' :class='sortFeatureOpen == true ? "active" : ""'>

         <ul class='navbar'>
            <li @click='select_category(cat.id)' 
               v-for='(cat, index) in categoryWater' :key='index' 
               :class='cat.active == true ? "active" : ""'>
               {{ cat.name }}
            </li>
         </ul>
         <ul class='navbar style01'>
            <li @click='select_brand(brand.id)' 
               v-for='(brand, index) in brandWater' :key='index'
               :class='brand.active == true ? "active" : ""'>
               {{ brand.name }}
            </li>
         </ul>
      </div>

      <div class='inner'>
         <div class='grid-masonry'>
            <div @click='gotoProductDetail(product.id)' class='product-design' v-for='(product, index) in filter_products ' :key='index'>
               <div class='img'>
                  <img :src='get_image_upload(product.product_image)'>
                  <span v-if='has_discount(product) == true' class='badge-discount'>-{{ product.discount_percent }}%</span>
               </div>
               <div class='box-wrapper'>
                  <p class='tt01'>{{ product.name }} </p>
                  <p class='tt02'>{{ get_product_quantity(product) }}</p>
                  <div class='gr-price' :class="has_discount(product) == true ? 'has_discount' : '' ">
                     <span class='price'>
                        {{ has_discount(product) == true 
                           ? common_get_product_price(product, product.discount_percent) 
                           : common_get_product_price(product.price)
                        }}
                     </span>
                     <span v-if='has_discount(product) == true' class='price-sub'>
                        {{ common_get_product_price(product.price) }}
                     </span>

                     <!-- <span class='demo-font'>
                        Rate {{ product.avg_rating }}<br>
                        Distance {{ product.distance }}
                     </span> -->

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
   data(){
      return{ 
         loading: false,
         sortFeatureOpen: false,
         sortFeatureCurrentValue: 0,
         latitude: 10.780900239854994,
         longitude: 106.7226271387539,
         limit: 10,
         page: 0,

         products: [],
         categoryWater: [],
         brandWater: [],
      }
   },

   methods: {
      get_current_location(){

         if( window.appBridge !== undefined ){
            window.appBridge.getLocation().then( (data) => {
               if (Object.keys(data).length === 0) {
                  alert("Error-1 :Không thể truy cập vị trí");
               }else{
                  let lat = data.lat;
                  let lng = data.lng;
                  this.latitude = data.lat;
                  this.longitude = data.lng;
               }
            }).catch((e) => { alert(e); })
         }
      },

      get_image_upload( i ){ return window.get_image_upload( i ) },

      has_discount( product ){ return window.has_discount(product); },
      get_product_quantity( product ) { return window.get_product_quantity(product) },
      common_get_product_price( price, discount_percent ){return window.common_get_product_price(price, discount_percent)},

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

      select_category(cat_id){
         this.categoryWater.some( cat => { 
            if (cat.id === cat_id) {
               cat.active = !cat.active;
            } else {
               cat.active = false;
            }
         });
      },
      select_brand(brand_id){
         this.brandWater.some( brand => { 
            if (brand.id === brand_id) {
               brand.active = !brand.active;
            } else {
               brand.active = false; 
            }
         });
      },

      // INIT
      async load_product(){
         var form = new FormData();
         form.append('action', 'atlantis_load_products');
         form.append('type', 'water');
         form.append('lat', this.latitude);
         form.append('lng', this.longitude);
         form.append('limit', this.limit);
         form.append('page', this.page);
         var r = await window.request(form);
         if( r != undefined ){
            var res = JSON.parse( JSON.stringify(r));
            if( res.message == 'product_found' ){
               res.data.some(item => {
                  var _avg_rating = (Math.random() * 4.9) + 0.1;
                  var _distance = (Math.random() * 4.9) + 0.1;

                  item.price = parseInt(item.price);
                  item.avg_rating = parseFloat(_avg_rating).toFixed(1);
                  item.distance = parseFloat(_distance).toFixed(2);
                  item.category_id = parseInt(item.category_id);
                  item.brand_id = parseInt(item.brand_id);

               });
               this.products.push( ...res.data);
            }
         }
      },

      async load_category(){
         var form = new FormData();
         form.append('action', 'atlantis_load_category');
         form.append('category', 'water');
         var r = await window.request(form);
         if( r != undefined ){
            var res = JSON.parse( JSON.stringify(r));
            if( res.message == 'category_found' ){
               res.data.some( (item, index) => item.active = false);
               this.categoryWater.push( ...res.data);
            }
         }

      },

      async load_brand(){
         var form = new FormData();
         form.append('action', 'atlantis_load_category');
         form.append('category', 'brand');
         var r = await window.request(form);
         if( r != undefined ){
            var res = JSON.parse( JSON.stringify(r));
            if( res.message == 'category_found' ){
               res.data.some( (item, index) => item.active = false );
               this.brandWater.push( ...res.data);
            }
         }
      },

      calculateDistance(lat1, lon1, lat2, lon2 ){ return window.calculateDistance(lat1, lon1, lat2, lon2 )},

      goBack(){ window.goBack(); },
      gotoProductDetail(product_id){ window.gotoProductDetail(product_id)},
   },
   computed: {
      filter_products(){
         var _filter = this.products.filter( product => {
            // Filter products based on category and brand
            var cat = this.categoryWater.find(c => c.active == true);
            var brand = this.brandWater.find(b => b.active == true);
            if (cat && brand) {
               return product.category_id == parseInt(cat.id) && product.brand_id == parseInt(brand.id);
            } else if(cat) {
               return product.category_id == parseInt(cat.id);
            } else if(brand) {
               return product.brand_id == parseInt(brand.id);
            } else{
               return product;
            }
         });

         // nearest 0 
         // cheapest 1
         // top rated 2

         if(this.sortFeatureCurrentValue == 2 ){
            // console.log('Top Rated Filter');
            _filter.sort((a, b) => b.avg_rating - a.avg_rating);
         }
         
         // Sort products by price in ascending order (cheapest first)
         else if(this.sortFeatureCurrentValue == 1 ){
            // console.log('Top Cheapest');
            _filter.sort((a, b) => a.price - b.price);
         }

         // Filter products by distance (assuming you have access to user's location)
         else if(this.sortFeatureCurrentValue == 0 ){
            // console.log('Nearest');
            _filter.sort((a, b) => a.distance - b.distance);
         }

         return _filter;

      }
   },
   async created(){
      this.get_current_location();
      this.loading = true;
      await this.load_product();
      await this.load_category();
      await this.load_brand();
      this.loading = false;


   },

}).mount('#app');

</script>