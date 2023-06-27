const PageWater = {
   name: 'PageWater',
   template: `
      <div v-if='$root.navigator == "water" && 
      loading == false && 
      products.length > 0' 
      class='page-home-water'>
         <div class='appbar'>
            <div class='leading'>
               <button @click='$root.goBack' class='btn-action'>
                  <svg width="11" height="16" viewBox="0 0 11 16" fill="none" xmlns="http://www.w3.org/2000/svg">
                  <path fill-rule="evenodd" clip-rule="evenodd" d="M10.5309 0.375342C10.8759 0.806604 10.806 1.4359 10.3747 1.78091L2.60078 8.00004L10.3747 14.2192C10.806 14.5642 10.8759 15.1935 10.5309 15.6247C10.1859 16.056 9.55657 16.1259 9.12531 15.7809L0.375305 8.78091C0.13809 8.59113 0 8.30382 0 8.00004C0 7.69625 0.13809 7.40894 0.375305 7.21917L9.12531 0.219168C9.55657 -0.125842 10.1859 -0.0559202 10.5309 0.375342Z" fill="#252831"/>
                  </svg>
               </button>
               <p class='leading-title'>Water</p>
            </div>
            <div class='action'>
               <div @click='buttonSortFeature' class='btn-text'>
                  <svg width="16" height="14" viewBox="0 0 16 14" fill="none" xmlns="http://www.w3.org/2000/svg">
                  <path d="M1.50197e-05 1.08889V0.252778V1.08889ZM1.50197e-05 1.08889C-0.000569119 1.17459 0.0158907 1.25955 0.0484373 1.33883M1.50197e-05 1.08889L0.0484373 1.33883M0.0484373 1.33883C0.0809839 1.41811 0.128968 1.49013 0.189598 1.55069M0.0484373 1.33883L0.189598 1.55069M0.189598 1.55069L6.02293 7.38403L0.189598 1.55069ZM6.55326 6.8537L0.750015 1.05045V0.75H14.8056V1.05531L9.01691 6.84398L8.79724 7.06365V7.37431V12.7887L6.77293 11.7808V7.38403V7.07337L6.55326 6.8537ZM0.719656 1.02009C0.719747 1.02018 0.719838 1.02027 0.719929 1.02036L0.719656 1.02009Z" fill="#2040AF" stroke="#2040AF" stroke-width="1.5"/>
                  </svg>
                  <span class='text'>Sort</span>
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
               <div @click='$root.gotoPage("product-detail",{ product_id: product.id, back: "water" })' class='product-design' v-for='(product, index) in filter_products ' :key='index'>
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
                              ? common_get_product_price(product, product.discount_percent) 
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
      <div v-if='loading == true'>
         <div class='progress-center'>
            <div class='progress-container enabled'><progress class='progress-circular enabled' ></progress></div>
         </div>
      </div>
   `,
   data(){
      return{ 
         loading: false,
         sortFeatureOpen: false,
         sortFeatureCurrentValue: '',
         limit: 10,
         page: 0,

         products: [],
         categoryWater: [],
         brandWater: [],
      }
   },
   methods: {

      get_image_product(product_id){
         return get_template_directory_uri + '/assets/images/demo-product01.png';
      },

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
         form.append('limit', this.limit);
         form.append('page', this.page);
         var r = await window.request(form);
         if( r != undefined ){
            var res = JSON.parse( JSON.stringify(r));
            if( res.message == 'product_found' ){
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
   },

   computed: {
      filter_products(){
         return this.products.filter( product => {
            var cat = this.categoryWater.find(c => c.active == true);
            var brand = this.brandWater.find(b => b.active == true);
            if (cat && brand) {
               return product.category_id == cat.id && product.brand_id == brand.id;
            } else if (cat) {
               return product.category_id == cat.id;
            } else if (brand) {
               return product.brand_id == brand.id;
            } else {
               return this.products;
            }
         });
      }
   },
   async created(){

      this.loading = true;
      await this.load_product();
      await this.load_category();
      await this.load_brand();
      this.loading = false;
   },
   mounted(){
   }
}