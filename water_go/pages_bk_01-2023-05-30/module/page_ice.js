const PageIce = {
   name: 'PageIce',
   template: `
      <div v-if='$root.navigator == "ice"' class='page-home-ice'>

         <div class='appbar'>
            <div class='leading'>
               <button @click='$root.goBack' class='btn-action'>
                  <svg width="11" height="16" viewBox="0 0 11 16" fill="none" xmlns="http://www.w3.org/2000/svg">
                  <path fill-rule="evenodd" clip-rule="evenodd" d="M10.5309 0.375342C10.8759 0.806604 10.806 1.4359 10.3747 1.78091L2.60078 8.00004L10.3747 14.2192C10.806 14.5642 10.8759 15.1935 10.5309 15.6247C10.1859 16.056 9.55657 16.1259 9.12531 15.7809L0.375305 8.78091C0.13809 8.59113 0 8.30382 0 8.00004C0 7.69625 0.13809 7.40894 0.375305 7.21917L9.12531 0.219168C9.55657 -0.125842 10.1859 -0.0559202 10.5309 0.375342Z" fill="#252831"/>
                  </svg>
               </button>
               <p class='leading-title'>Ice</p>
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
            <div class='box-category'>
               <ul class='navbar'>
                  <li v-for='(cat, index) in categoryIce' :key='index' :class='index == 0 ? "active" : ""'>
                     {{ cat.name }}
                  </li>
               </ul>
            </div>
            
            <div class='inner'>
               <div class='grid-masonry'>
                  <div @click='$root.gotoPage("product-detail",{ product_id: product.id, back: "ice" })' class='product-design' v-for='(product, index) in productIce ' :key='index'>
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

      </div>
   `,
   data(){
      return {
         connector: '',
         sortFeatureOpen: false,
         sortFeatureCurrentValue: '',
         productIce: [],
         limit: 10,
         page: 0,

         categoryIce: [
            { id: 1, name: 'Đá bi'},
            { id: 2, name: 'Đá nghiền'},
            { id: 3, name: 'Đá cục'},
            { id: 4, name: 'Đá cây'}
         ],
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

      get_product_quantity( product ){
         return product.weight + "kg " + product.length_width + "mm";
      },

      common_get_product_price( price, discount_percent ){
         if( discount_percent == undefined || discount_percent == null || discount_percent == 0){
            return parseInt(price).toLocaleString('vi-VN') + ' đ';
         }
         var _price = price - ( price * ( discount_percent / 100 ) );
         if( _price == 0 ) return 0 + ' đ';
         return parseInt(_price).toLocaleString('vi-VN') + ' đ';
      },

   },

   async created(){
      var form = new FormData();
      form.append('action', 'atlantis_load_product_type');
      form.append('type', 'ice');
      form.append('limit', this.limit);
      form.append('page', this.page);
      var r = await this.request(form);
      if( r != undefined ){
         var res = JSON.parse( JSON.stringify(r));
         if( res.message == 'product_found' ){
            this.productIce.push( ...res.data);
         }
      }
   },
   mounted(){
      if( this.$root.pageNameConnector != undefined ){
         this.connector = this.$root.pageNameConnector;
      }
   }
};