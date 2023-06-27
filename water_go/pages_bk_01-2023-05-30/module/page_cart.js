const PageCart = {
   name: 'PageCart',
   template: `
<div 
   v-if='$root.navigator == "cart"'
   class='page-cart'>
   <div class='appbar'>
      <div class='leading'>
         <button @click='$root.goBack()' class='btn-action'>
            <svg width="20" height="16" viewBox="0 0 20 16" fill="none" xmlns="http://www.w3.org/2000/svg">
            <path fill-rule="evenodd" clip-rule="evenodd" d="M0 8C0 7.44772 0.447715 7 1 7H18.5C19.0523 7 19.5 7.44772 19.5 8C19.5 8.55228 19.0523 9 18.5 9H1C0.447715 9 0 8.55228 0 8Z" fill="#252831"/>
            <path fill-rule="evenodd" clip-rule="evenodd" d="M10.5309 0.375342C10.8759 0.806604 10.806 1.4359 10.3747 1.78091L2.60078 8.00004L10.3747 14.2192C10.806 14.5642 10.8759 15.1935 10.5309 15.6247C10.1859 16.056 9.55657 16.1259 9.12531 15.7809L0.375305 8.78091C0.13809 8.59113 0 8.30382 0 8.00004C0 7.69625 0.13809 7.40894 0.375305 7.21917L9.12531 0.219168C9.55657 -0.125842 10.1859 -0.0559202 10.5309 0.375342Z" fill="#252831"/>
            </svg>
         </button>
         <span class='leading-title'>Cart</span>
      </div>
   </div>

   <div v-if='$root.count_product_in_cart == 0' class='banner style01'>
      <div class='banner-head'>
         <img width='130' height='130' :src='get_icon_cart_default'>
         <p class="t-thrid">There is no product in your cart</p>
         <button @click='$root.goBack()' class='btn btn-outline mt30'>Go Shopping Now</button>
      </div>
   </div>

   <div v-if='$root.count_product_in_cart > 0' class='cart-wrapper'>
      <div class="cart-head">
         <div class="gr-action">

            <div @click='select_all_item' class='form-check'>
               <input id='select_all' type='checkbox' :checked='select_all_value'>
               <label for='select_all'>All</label>
            </div>

            <button class='btn-action' @click="delete_all_item">
               <svg width="18" height="20" viewBox="0 0 18 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                  <path d="M1 4.59998H2.8H17.2" stroke="black" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                  <path d="M15.3998 4.6V17.2C15.3998 17.6774 15.2102 18.1352 14.8726 18.4728C14.535 18.8104 14.0772 19 13.5998 19H4.5998C4.12242 19 3.66458 18.8104 3.32701 18.4728C2.98945 18.1352 2.7998 17.6774 2.7998 17.2V4.6M5.4998 4.6V2.8C5.4998 2.32261 5.68945 1.86477 6.02701 1.52721C6.36458 1.18964 6.82242 1 7.2998 1H10.8998C11.3772 1 11.835 1.18964 12.1726 1.52721C12.5102 1.86477 12.6998 2.32261 12.6998 2.8V4.6" stroke="black" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                  <path d="M7.2998 9.09998V14.5" stroke="black" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                  <path d="M10.8999 9.09998V14.5" stroke="black" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
               </svg>
            </button>

         </div>
      </div>

      <div class="cart-body">
         <ul class="list-tile item-cart">

            <li v-for="(store, storeKey) in $root.carts" :key="storeKey">
               <div class='cart-store'>

                  <div @click='btn_store_select(store.store_id)' class='form-check'>
                     <input type='checkbox' :checked='store.store_select'>
                  </div>

                  <div class='store-container'>
                     <button @click='$root.gotoPage("store-detail", {back: "cart", store_id: store.store_id })' class='btn-action'>
                        <svg width="21" height="17" viewBox="0 0 21 17" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <rect x="2.5" y="6.5" width="16" height="10" rx="1.5" fill="white" stroke="black"/>
                        <path d="M20.096 4.43083L20.0959 4.4307L17.8831 0.787088L17.8826 0.786241C17.7733 0.605479 17.5825 0.5 17.3865 0.5H3.61215C3.41614 0.5 3.22534 0.605479 3.11605 0.786241L3.11554 0.787088L0.902826 4.43061C0.902809 4.43064 0.902792 4.43067 0.902775 4.4307C0.0376853 5.85593 0.639918 7.73588 1.97289 8.31233C2.15024 8.38903 2.34253 8.44415 2.54922 8.47313C2.67926 8.49098 2.81302 8.5 2.9473 8.5C3.80016 8.5 4.5594 8.1146 5.08594 7.50809L5.46351 7.07318L5.84107 7.50809C6.36742 8.11438 7.12999 8.5 7.97971 8.5C8.83258 8.5 9.59181 8.1146 10.1184 7.50809L10.4959 7.07318L10.8735 7.50809C11.3998 8.11438 12.1624 8.5 13.0121 8.5C13.865 8.5 14.6242 8.1146 15.1508 7.50809L15.5273 7.07438L15.905 7.50705C16.4357 8.11494 17.1956 8.5 18.0445 8.5C18.1822 8.5 18.3128 8.49098 18.4433 8.47304L20.096 4.43083ZM20.096 4.43083C21.0907 6.06765 20.1619 8.23575 18.4435 8.47301L20.096 4.43083Z" fill="white" stroke="black"/>
                        </svg>
                        <span class='store-name'>{{ store.store_name }}</span>
                     </button>
                  </div>

               </div>

               <div v-for="(product, productKey) in store.products" :key="productKey"
                  class='cart-container'>
                  <div class="leading">
                     <div @click='btn_product_select(product.product_id)' class='form-check'>
                        <input type='checkbox' :checked='product.product_select'>
                     </div>
                     <div class='product-image'>
                        <img :src="get_image_product">
                     </div>
                  </div>
                  <div class='content'>
                     <div class='product-name'>{{ product.product_name }}</div>
                     <div class='product-price'>
                        <span v-if="product.product_discount_percent != null" class='price'>
                           {{ common_get_product_price( product.product_price, product.product_discount_percent ) }}
                        </span>
                        <span v-else class='price'>
                           {{ common_get_product_price(product.product_price) }}
                        </span>
                        <span v-if="product.product_discount_percent != null" class='sub-price'>
                           {{ common_get_product_price(product.product_price) }}
                        </span>
                     </div>
                  </div>
                  <div class='action'>
                     <button @click="minQuantityCount(product.product_id)" class='btn-action'>
                        <svg width="16" height="3" viewBox="0 0 16 3" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M14.8571 2.28571H1.14286C0.839753 2.28571 0.549063 2.16531 0.334735 1.95098C0.120408 1.73665 0 1.44596 0 1.14286C0 0.839752 0.120408 0.549063 0.334735 0.334735C0.549063 0.120408 0.839753 0 1.14286 0H14.8571C15.1602 0 15.4509 0.120408 15.6653 0.334735C15.8796 0.549063 16 0.839752 16 1.14286C16 1.44596 15.8796 1.73665 15.6653 1.95098C15.4509 2.16531 15.1602 2.28571 14.8571 2.28571Z" fill="#2040AF"/></svg>
                     </button>
                     <input type="number" disabled :value="product.product_quantity_count" :max="product.product_stock">
                     <button @click="plusQuantityCount(product.product_id)" class='btn-action'>
                        <svg width="16" height="16" viewBox="0 0 16 16" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M14.8571 9.14286H9.14286V14.8571C9.14286 15.1602 9.02245 15.4509 8.80812 15.6653C8.59379 15.8796 8.30311 16 8 16C7.6969 16 7.40621 15.8796 7.19188 15.6653C6.97755 15.4509 6.85714 15.1602 6.85714 14.8571V9.14286H1.14286C0.839753 9.14286 0.549063 9.02245 0.334735 8.80812C0.120408 8.59379 0 8.30311 0 8C0 7.6969 0.120408 7.40621 0.334735 7.19188C0.549063 6.97755 0.839753 6.85714 1.14286 6.85714H6.85714V1.14286C6.85714 0.839753 6.97755 0.549062 7.19188 0.334735C7.40621 0.120407 7.6969 0 8 0C8.30311 0 8.59379 0.120407 8.80812 0.334735C9.02245 0.549062 9.14286 0.839753 9.14286 1.14286V6.85714H14.8571C15.1602 6.85714 15.4509 6.97755 15.6653 7.19188C15.8796 7.40621 16 7.6969 16 8C16 8.30311 15.8796 8.59379 15.6653 8.80812C15.4509 9.02245 15.1602 9.14286 14.8571 9.14286Z" fill="#2040AF"/></svg>
                     </button>
                  </div>
               </div>

            </li>

         </ul>
      </div>

   </div>
   
   <div v-if='$root.count_product_in_cart > 0' class='product-detailt-bottomsheet cell-placeorder'>
      <div class='price-total'>
         <div class='line1'>Total: <span class='t-primary t-bold'>{{ $root.count_product_total_price.price_discount }}</span></div>
         <div v-if="$root.count_product_total_price.price != null" class='line2'>
            {{ $root.count_product_total_price.price }}
         </div>
      </div>
      <button @click="gotoPageOrder" :class='$root.count_product_select == 0 ? "disabled": ""' class='btn-primary'>Check Out({{$root.count_product_select}})</button>
   </div>

   <div v-if='popup_delete_all_item == true' class='modal-popup open'>
      <div class='modal-wrapper'>
         <p class='heading'>Are you sure to remove this product from your cart?</p>
         <div class='actions'>
            <button @click='buttonCloseModal_delete_all_item' class='btn btn-outline'>Cancel</button>
            <button @click='buttonCloseModal_delete_confirm' class='btn btn-primary'>Delete</button>
         </div>
      </div>
   </div>

</div>
   `,
   data(){
      return {
         select_all_value: false,
         popup_delete_all_item: false,
      }
   },
   methods: {

      select_all_item(){
         if( this.select_all_value == false ){
            this.select_all_value = true;
         }else{
            this.select_all_value = false;
         }
         this.$root.carts.forEach( store => {
            store.store_select = this.select_all_value;
            store.products.forEach( product => product.product_select = this.select_all_value);
         });
      },

      delete_all_item(){
        this.popup_delete_all_item = true; 
      },

      buttonCloseModal_delete_all_item(){ this.popup_delete_all_item = false; },
      buttonCloseModal_delete_confirm(){
         this.popup_delete_all_item = false;
         this.$root.carts = [];
      },

      common_get_product_price( price, discount_percent ){
         if( discount_percent == undefined || discount_percent == null || discount_percent == 0){
            return parseInt(price).toLocaleString('vi-VN') + ' đ';
         }
         var _price = price - ( price * ( discount_percent / 100 ) );
         if( _price == 0 ) return 0 + ' đ';
         return parseInt(_price).toLocaleString('vi-VN') + ' đ';
      },

      cart_stream(){
         this.$root.carts.some( ( store, storeIndex ) => {
            store.products.forEach( ( product, productIndex )  => {
               if( product.product_quantity_count == 0 ){
                  store.products.splice(productIndex, 1);
               }
            });
            if( store.products.length == 0 ){
               this.$root.carts.splice(storeIndex, 1);
            }
         });
      },

      plusQuantityCount( product_id ){
         this.$root.carts.some(( store ) => {
            store.products.find(product => {
               if( product.product_id == product_id ){
                  if( product.product_quantity_count < product.product_stock ) {
                     product.product_quantity_count++;
                  }
               }
            });
         });
      },

      minQuantityCount( product_id ){
         this.$root.carts.some(( store ) => {
            store.products.find(product => { 
               if( product.product_id == product_id ){
                  if( product.product_quantity_count == 0 ) {
                     product.product_quantity_count = 0;
                  }else{
                     product.product_quantity_count--;
                  }
               }
            });
         });
         this.cart_stream();
      },

      btn_product_select( product_id ){
         this.select_all_value = false;
         if( this.$root.carts.length > 0){
            this.$root.carts.some( store => {

               store.products.some( product => {
                  if( product.product_id == product_id ){
                     store.store_select = false;
                     if( product.product_select == false ){
                        product.product_select = true;
                     }else{
                        product.product_select = false;
                     }
                  }
               });

               var _allProduct = store.products.every( product => product.product_select == true );
               if( _allProduct ){
                  store.store_select = true;
               }

            });
         }
      },

      btn_store_select(store_id){
         this.select_all_value = false;
         if( this.$root.carts.length > 0){
            this.$root.carts.some( store => {
               if( store.store_id == store_id ){
                  if( store.store_select == false ){
                     store.store_select = true;
                  }else{
                     store.store_select = false;
                  }
                  if( store.store_select == true ){
                     store.products.forEach((product) => product.product_select = true );
                  }else{
                     store.products.forEach((product) => product.product_select = false );
                  }
               }
            });
         }
      },

      gotoPageOrder(){
         if( this.$root.count_product_select > 0 ){

         }
      } 

   },
   computed: {
      get_image_product( product_id ){
         return get_template_directory_uri + '/assets/images/demo-product01.png';
      },

      get_icon_cart_default(){
         return get_template_directory_uri + "/assets/images/icon-cart.png";
      },

   },
   async created(){

   },
   mounted(){

   }
};