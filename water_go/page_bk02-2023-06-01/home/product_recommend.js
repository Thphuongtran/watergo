const ProductRecommend = {
   name: 'ProductRecommend',
   template: `
      <div class='list-product-recommend'>

         <div class='gr-heading'>
            <p class='heading'>Recommend</p>
            <span @click='$root.gotoPage("recommend", {back: "home"})' class='link'>See All</span>
         </div>

         <div class='list-horizontal'>
            <ul>
               <li 
               @click='$root.gotoPage("product-detail",{ product_id: product.id, back: "home" })' 
               v-if='productRecommend.length > 0' 
               v-for='(product, index) in productRecommend' :key='index' class='product-design'>
                  <div class='img'>
                     <img :src='get_image_product(product.id)'>
                     <span v-if='has_discount(product) == true' class='badge-discount'>-{{ product.discount_percent }}%</span>
                  </div>
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
               </li>
            </ul>
         </div>

      </div>
   `,
   data(){
      return{
         type: '',
         productRecommend: [],
         limit: 10,
         page: 0
      }
   },
   methods: {
      
      get_image_product(product_id){
         return get_template_directory_uri + '/assets/images/demo-product01.png';
      },

      has_discount( product ){ return window.has_discount( product ); },      
      get_product_quantity( product ){ return window.get_product_quantity( product ); },
      common_get_product_price( price, discount_percent ){ return window.common_get_product_price( price, discount_percent ); },

   },

   async created(){
      if(this.$root.productRecommend.length == 0 ){
         var form = new FormData();
         form.append('action', 'atlantis_load_product_recommend');
         var r = await window.request(form);
         if( r != undefined ){
            var res = JSON.parse( JSON.stringify( r));
            if( res.message == 'product_found' ){
               this.type = res.type;
               this.productRecommend.push(...res.data );
               this.$root.productRecommend.push(...res.data );
            }
         }
      }else{
         this.productRecommend = this.$root.productRecommend;
      }
   },

};