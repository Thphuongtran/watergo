<div id='app'>

   <div v-show='loading == false' class='page-cart'>
      <div class='appbar style01'>
         <div class='appbar-top'>
         
            <div class='leading'>
               <button @click='goBack' class='btn-action'>
                  <svg width="20" height="16" viewBox="0 0 20 16" fill="none" xmlns="http://www.w3.org/2000/svg">
                  <path fill-rule="evenodd" clip-rule="evenodd" d="M0 8C0 7.44772 0.447715 7 1 7H18.5C19.0523 7 19.5 7.44772 19.5 8C19.5 8.55228 19.0523 9 18.5 9H1C0.447715 9 0 8.55228 0 8Z" fill="#252831"/>
                  <path fill-rule="evenodd" clip-rule="evenodd" d="M10.5309 0.375342C10.8759 0.806604 10.806 1.4359 10.3747 1.78091L2.60078 8.00004L10.3747 14.2192C10.806 14.5642 10.8759 15.1935 10.5309 15.6247C10.1859 16.056 9.55657 16.1259 9.12531 15.7809L0.375305 8.78091C0.13809 8.59113 0 8.30382 0 8.00004C0 7.69625 0.13809 7.40894 0.375305 7.21917L9.12531 0.219168C9.55657 -0.125842 10.1859 -0.0559202 10.5309 0.375342Z" fill="#252831"/>
                  </svg>
               </button>
               <span class='leading-title'>Cart</span>
            </div>
         </div>
         <div v-if='carts.length > 0' class='appbar-bottom'>
            <div class="cart-head">
               <div class="gr-action">

                  <div @click='select_all_item' class='form-check'>
                     <input type='checkbox' :checked='select_all_value'>
                     <label>All</label>
                  </div>

                  <button class='btn-action mr0' @click="btn_delete_item">
                     <svg width="18" height="20" viewBox="0 0 18 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M1 4.59998H2.8H17.2" stroke="black" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                        <path d="M15.3998 4.6V17.2C15.3998 17.6774 15.2102 18.1352 14.8726 18.4728C14.535 18.8104 14.0772 19 13.5998 19H4.5998C4.12242 19 3.66458 18.8104 3.32701 18.4728C2.98945 18.1352 2.7998 17.6774 2.7998 17.2V4.6M5.4998 4.6V2.8C5.4998 2.32261 5.68945 1.86477 6.02701 1.52721C6.36458 1.18964 6.82242 1 7.2998 1H10.8998C11.3772 1 11.835 1.18964 12.1726 1.52721C12.5102 1.86477 12.6998 2.32261 12.6998 2.8V4.6" stroke="black" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                        <path d="M7.2998 9.09998V14.5" stroke="black" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                        <path d="M10.8999 9.09998V14.5" stroke="black" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                     </svg>
                  </button>

               </div>
            </div>
         </div>
      </div>

      <div v-show='carts.length == 0' class='banner banner-cart'>
         <div class='banner-head'>
            <svg width="130" height="130" viewBox="0 0 130 130" fill="none" xmlns="http://www.w3.org/2000/svg">
            <circle cx="65" cy="65" r="65" fill="#E9E9E9"/>
            <path d="M29.4743 29.9926L45.5662 29.7594M29.4743 29.9926L31.7009 46.0556M29.4743 29.9926C29.4743 29.9926 27.8696 21.3746 23.8438 18.2902C18.3203 14.0582 6.02777 18.5484 6.02777 18.5484M38.3012 93.6709L53.962 93.4439M38.3012 93.6709L35.9951 77.0342M38.3012 93.6709C38.3012 93.6709 39.7234 102.56 42.1888 104.105C44.6542 105.65 91.7805 104.967 91.7805 104.967M45.5662 29.7594L53.962 93.4439M45.5662 29.7594L63.9569 29.4928M53.962 93.4439L64.8815 93.2857M82.3477 29.2262L99.8763 28.9722L98.2249 45.0914M82.3477 29.2262L75.801 93.1274M82.3477 29.2262L63.9569 29.4928M75.801 93.1274L93.3297 92.8733L95.0401 76.1784M75.801 93.1274L64.8815 93.2857M63.9569 29.4928L64.8815 93.2857M31.7009 46.0556L98.2249 45.0914M31.7009 46.0556L33.6889 60.3976M98.2249 45.0914L96.7505 59.4835M33.6889 60.3976L96.7505 59.4835M33.6889 60.3976L35.9951 77.0342M96.7505 59.4835L95.0401 76.1784M35.9951 77.0342L95.0401 76.1784" stroke="black"/>
            <circle cx="54.0577" cy="112.102" r="5.02924" transform="rotate(-0.830384 54.0577 112.102)" fill="#2790F9"/>
            <path d="M57.4 112.053C57.4268 113.899 55.9522 115.417 54.1065 115.443C52.2608 115.47 50.7428 113.996 50.7161 112.15C50.6893 110.304 52.1639 108.786 54.0096 108.759C55.8553 108.733 57.3733 110.207 57.4 112.053Z" fill="white" stroke="black" stroke-width="0.5"/>
            <circle cx="79.2608" cy="112.102" r="5.02924" transform="rotate(-0.830384 79.2608 112.102)" fill="#2790F9"/>
            <path d="M82.6032 112.053C82.6299 113.899 81.1553 115.417 79.3096 115.443C77.4639 115.47 75.946 113.996 75.9192 112.15C75.8925 110.304 77.367 108.786 79.2128 108.759C81.0585 108.733 82.5764 110.207 82.6032 112.053Z" fill="white" stroke="black" stroke-width="0.5"/>
            </svg>
            <p class="t-thrid">There is no product in your cart</p>
            <button @click='goBackHome' class='btn btn-outline mt30'>Go Shopping Now</button>
         </div>
      </div>

      <div v-show='carts.length > 0' class='cart-wrapper'>

         <div class="cart-body">

            <ul class="list-tile item-cart">

               <li v-for="(store, storeKey) in carts" :key="storeKey">
                  <div class='cart-store'>

                     <div @click='btn_store_select(store.store_id)' class='form-check'>
                        <input type='checkbox' :checked='store.store_select'>
                     </div>

                     <div @click='gotoStoreDetail(store.store_id)' class='store-container'>
                        <button class='btn-action'>
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
                           <img :src="product.product_image.url">
                        </div>
                     </div>
                     <div class='content'>
                        <div class='product-name'>{{ product.name }}</div>
                        <div class='product-price product-in-cart'>
                           <span class='price'>
                              {{ common_price_after_discount( product ) }}
                           </span>
                           <span v-show='has_discount(product) == true' class='sub-price'>
                              {{ common_price_show_currency( product.price ) }}
                           </span>
                        </div>
                     </div>
                     <div class='action'>
                        <button @click="minQuantityCount(product.product_id)" class='btn-action'>
                           <svg width="16" height="3" viewBox="0 0 16 3" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M14.8571 2.28571H1.14286C0.839753 2.28571 0.549063 2.16531 0.334735 1.95098C0.120408 1.73665 0 1.44596 0 1.14286C0 0.839752 0.120408 0.549063 0.334735 0.334735C0.549063 0.120408 0.839753 0 1.14286 0H14.8571C15.1602 0 15.4509 0.120408 15.6653 0.334735C15.8796 0.549063 16 0.839752 16 1.14286C16 1.44596 15.8796 1.73665 15.6653 1.95098C15.4509 2.16531 15.1602 2.28571 14.8571 2.28571Z" fill="#2790F9"/></svg>
                        </button>
                        <input @change='input_quantity' :id='product.product_id' ref='input_quantity' class='input_quantity' type="number" pattern='[0-9]*' :value="product.product_quantity_count">
                        <button @click="plusQuantityCount(product.product_id)" class='btn-action'>
                           <svg width="16" height="16" viewBox="0 0 16 16" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M14.8571 9.14286H9.14286V14.8571C9.14286 15.1602 9.02245 15.4509 8.80812 15.6653C8.59379 15.8796 8.30311 16 8 16C7.6969 16 7.40621 15.8796 7.19188 15.6653C6.97755 15.4509 6.85714 15.1602 6.85714 14.8571V9.14286H1.14286C0.839753 9.14286 0.549063 9.02245 0.334735 8.80812C0.120408 8.59379 0 8.30311 0 8C0 7.6969 0.120408 7.40621 0.334735 7.19188C0.549063 6.97755 0.839753 6.85714 1.14286 6.85714H6.85714V1.14286C6.85714 0.839753 6.97755 0.549062 7.19188 0.334735C7.40621 0.120407 7.6969 0 8 0C8.30311 0 8.59379 0.120407 8.80812 0.334735C9.02245 0.549062 9.14286 0.839753 9.14286 1.14286V6.85714H14.8571C15.1602 6.85714 15.4509 6.97755 15.6653 7.19188C15.8796 7.40621 16 7.6969 16 8C16 8.30311 15.8796 8.59379 15.6653 8.80812C15.4509 9.02245 15.1602 9.14286 14.8571 9.14286Z" fill="#2790F9"/></svg>
                        </button>
                     </div>
                  </div>

               </li>

            </ul>
         </div>

      </div>
      
      <div v-if='carts.length > 0' class='product-detail-bottomsheet cell-placeorder'>
         <div class='price-total'>
            <div class='line1'>Total: <span class='t-primary t-bold'>{{ count_product_total_price.price_discount }}</span></div>
            <div v-if="count_product_total_price.price != null" class='line2'>
               {{ count_product_total_price.price }}
            </div>
         </div>
         <button @click="gotoPageOrder" :class='count_product_select == 0 ? "disabled": ""' class='btn-primary'>Check Out({{count_product_select}})</button>
      </div>

      <div class='modal-popup' :class='popup_delete_item == true ? "open" : ""'>
         <div class='modal-wrapper'>
            <p class='heading'>Are you sure to remove this product from your cart?</p>
            <div class='actions'>
               <button @click='buttonCloseModal_btn_delete_item' class='btn btn-outline'>Cancel</button>
               <button @click='buttonCloseModal_delete_confirm' class='btn btn-primary'>Delete</button>
            </div>
         </div>
      </div>
   </div>

   <div v-show='loading == true'>
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
         select_all_value: false,
         popup_delete_item: false,
         trigger_btn_delete: false,
         carts: []

      }
   },
   methods: {

      goBackHome(){ 
         window.appBridge.navigateTo("Home");
      },

      has_discount( product ){ return window.has_discount( product ); },      
      common_price_show_currency(p){ return window.common_price_show_currency(p) },
      common_price_after_discount(p){ return window.common_price_after_discount(p) },

      input_quantity( e ){
         var el = e.target;
         var product_id             = el.getAttribute('id');
         var product_quantity_count = el.value;

         if( product_quantity_count > 0 ){
            for (let storeIndex = this.carts.length - 1; storeIndex >= 0; storeIndex--) {
               var store = this.carts[storeIndex];
               if (store.products.length !== 0) {
                  for( var productIndex = 0; productIndex < store.products.length; productIndex++ ){

                     if( this.carts[storeIndex].products[productIndex].product_id == product_id ){
                        this.carts[storeIndex].products[productIndex].product_quantity_count = parseInt(product_quantity_count);
                     }
                  }
               }
            }
         }

      },

      select_all_item(){
         this.select_all_value = !this.select_all_value;
         this.carts.forEach( store => {
            store.store_select = this.select_all_value;
            store.products.forEach( product => product.product_select = this.select_all_value);
         });
         this.cart_stream();
         if(this.select_all_value == false ){
            this.trigger_btn_delete = false;
         }
      },

      btn_delete_item(){
         if( this.trigger_btn_delete == true ){
            this.popup_delete_item = true;
         }
      },

      buttonCloseModal_btn_delete_item(){ this.popup_delete_item = false; },
      buttonCloseModal_delete_confirm(){

         if( this.trigger_btn_delete == true ){
            this.popup_delete_item = false;
            
            if( this.select_all_value == true ){
               this.carts = [];
               localStorage.setItem('watergo_carts', '[]');
            }else{

               var _carts = JSON.parse( localStorage.getItem('watergo_carts') );

               for (let storeIndex = this.carts.length - 1; storeIndex >= 0; storeIndex--) {
                  const store = this.carts[storeIndex];

                  // Condition 1: If store.store_select is true, delete the entire store
                  if (store.store_select === true) {
                     this.carts.splice(storeIndex, 1);
                  } else {
                     // Condition 2: Delete selected products
                     store.products = store.products.filter((product) => !product.product_select);

                     // Check if the store has any products left
                     if (store.products.length === 0) {
                           this.carts.splice(storeIndex, 1);
                     }
                  }
               }

               if( this.carts.length > 0){
                  localStorage.setItem('watergo_carts', JSON.stringify(this.carts));
               }else{
                  localStorage.setItem('watergo_carts', '[]');
               }
            }
         }


      },

      

      cart_stream(){
         var _isAllSelected = this.carts.every(store => store.store_select === true);
         if( _isAllSelected == true ){
            this.select_all_value = true;
         }else{
            this.select_all_value = false;
         }

         this.carts.some( ( store, storeIndex ) => {
            store.products.forEach( ( product, productIndex )  => {
               if( product.product_quantity_count == 0 ){
                  store.products.splice(productIndex, 1);
               }
            });
            if( store.products.length == 0 ){
               this.carts.splice(storeIndex, 1);
            }
         });
         if( this.carts.length > 0){
            localStorage.setItem('watergo_carts', JSON.stringify(this.carts));
         }else{
            localStorage.setItem('watergo_carts', '[]');
         }

      },

      plusQuantityCount( product_id ){
         this.carts.some(( store ) => {
            store.products.find(product => {
               if( product.product_id == product_id ){
                     product.product_quantity_count++;
               }
            });
         });
         this.cart_stream();
      },

      minQuantityCount( product_id ){
         this.carts.some(( store ) => {
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
         if( this.carts.length > 0){
            this.carts.some( store => {
               store.products.some( product => {
                  if( product.product_id == product_id ){
                     store.store_select = false;
                     product.product_select = !product.product_select;
                  }
               });
               var _allProduct = store.products.every( product => product.product_select == true );
               if( _allProduct ){
                  store.store_select = true;
               }
            });
         }
         this.cart_stream();
      },

      btn_store_select(store_id){
         this.select_all_value = false;
         if( this.carts.length > 0){
            this.carts.some( store => {
               if( store.store_id == store_id ){
                  store.store_select = !store.store_select;
                  if( store.store_select == true ){
                     store.products.forEach((product) => product.product_select = true );
                  }else{
                     store.products.forEach((product) => product.product_select = false );
                  }
               }
            });
         }
         this.cart_stream();
      },

      gotoPageOrder(){
         if( this.count_product_select > 0 ){
            this.gotoOrderProduct();
         }
      },

      goBack(){ 
         window.goBack(true);
         window.reset_cart_to_select_false();
      },
      gotoStoreDetail(store_id){ window.gotoStoreDetail(store_id)},
      gotoOrderProduct(){ window.gotoOrderProduct()},

   },

   computed: {

      count_product_total_price(){ 
         this.cart_stream();
         var _cartItems = JSON.parse(localStorage.getItem('watergo_carts'));

         var gr_price = {
            price: 0,
            price_discount: 0
         };

         _cartItems.forEach( store => {
            store.products.forEach(product => {
               if( product.product_select == true ){
                  if( product.has_discount != 0 ){
                     gr_price.price_discount += ( product.price - ( product.price * ( product.discount_percent / 100)) ) * product.product_quantity_count;
                  }else{
                     gr_price.price_discount += product.price * product.product_quantity_count;
                  }
                  gr_price.price += product.price * product.product_quantity_count;
               }
            });

         });
         
         var _final_price = null;

         if( gr_price.price != gr_price.price_discount){
            _final_price = gr_price.price.toLocaleString('vi-VN') + ' đ';
         }

         return {
            price: _final_price,
            price_discount: gr_price.price_discount.toLocaleString('vi-VN') + ' đ'
         };
      },

      count_product_select() {
         var _checkout = 0; // Initialize checkout count to 0
         this.carts.forEach(store => {
            store.products.forEach(product => {
               if (product.product_select) {
                  _checkout += product.product_quantity_count;
               }
            });
         });
         // TRIGGER BUTTON DELETE
         if( _checkout > 0 ){
            this.trigger_btn_delete = true;
         }else{
            this.trigger_btn_delete = false;
         }

         this.cart_stream();
         return _checkout;
      }
   },

   async created(){
      this.loading = true;

      var _carts = JSON.parse(localStorage.getItem('watergo_carts'));
      if( _carts != undefined && _carts.length > 0 ){ 
         // force all false no select from begin
         _carts.forEach(item => {
            item.store_select = false;
            item.products.forEach( product => product.product_select = false);
         });
         for( var i = 0; i < _carts.length; i++ ){
            for( var x = 0; x < _carts[i].products.length; x++ ){
               var _product_id = _carts[i].products[x].product_id;
               var form = new FormData();
               form.append('action', 'atlantis_find_product');
               form.append('product_id', _product_id);
               var r = await window.request(form);
               if( r != undefined ){
                  var res = JSON.parse( JSON.stringify(r));
                  if( res.message == 'product_found' ){
                     _carts[i].products[x].product_image    = res.data.product_image;
                     _carts[i].products[x].discount_from    = res.data.discount_from;
                     _carts[i].products[x].discount_to      = res.data.discount_to;
                     _carts[i].products[x].discount_percent = res.data.discount_percent;
                     _carts[i].products[x].has_discount     = res.data.has_discount;
                     _carts[i].products[x].name             = res.data.name;
                     _carts[i].products[x].price            = res.data.price;

                     // _carts[i].products[x].stock            = res.data.stock;
                     // Check if stock is 0 and remove the product from _carts
                     // if (_carts[i].products[x].stock == 0) {
                     //    _carts[i].products.splice(x, 1);
                        // x--; // Decrement x to handle the next product correctly after the removal
                     // }

                  }
                  
               }
            }
         }
         this.carts.push( ..._carts); 
      }

      this.loading = false;
      window.appbar_fixed();

      // console.log(this.carts)

   },

   mounted(){
      
   }
}).mount('#app');
</script>