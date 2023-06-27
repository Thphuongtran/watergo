const ProductRecommend = {
   name: 'ProductRecommend',
   template: `
      <div class='list-product-recommend'>

         <div class='gr-heading'>
            <p class='heading'>Recommend</p><span class='link'>See All</span>
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
         connector: '',
         type: '',
         productRecommend: [],
         limit: 10,
         page: 0
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

   },

   async created(){

      if( this.$root.productRecommend.length > 0 ){
         this.productRecommend.push( ...this.$root.productRecommend );
      }else{
         var form = new FormData();
         form.append('action', 'atlantis_load_product_recommend');
         var r = await this.request(form);
         if( r != undefined ){
            var res = JSON.parse( JSON.stringify( r));
            if( res.message == 'product_found' ){
               this.type = res.type;
               this.productRecommend.push( ...res.data );
               this.$root.productRecommend.push( ...res.data);
            }
         }
      }
   },
   mounted(){
      if( this.$root.pageNameConnector != undefined ){
         this.connector = this.$root.pageNameConnector;
      }
   }
};