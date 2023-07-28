<div id='app'>
   <div v-show='loading == false' class='page-order-filter'>

      <div class='appbar'>
         <div class='appbar-top'>
            <div class='leading'>
               <button @click='goBack' class='btn-action'>
                  <svg width="20" height="16" viewBox="0 0 20 16" fill="none" xmlns="http://www.w3.org/2000/svg">
                  <path fill-rule="evenodd" clip-rule="evenodd" d="M0 8C0 7.44772 0.447715 7 1 7H18.5C19.0523 7 19.5 7.44772 19.5 8C19.5 8.55228 19.0523 9 18.5 9H1C0.447715 9 0 8.55228 0 8Z" fill="#252831"/>
                  <path fill-rule="evenodd" clip-rule="evenodd" d="M10.5309 0.375342C10.8759 0.806604 10.806 1.4359 10.3747 1.78091L2.60078 8.00004L10.3747 14.2192C10.806 14.5642 10.8759 15.1935 10.5309 15.6247C10.1859 16.056 9.55657 16.1259 9.12531 15.7809L0.375305 8.78091C0.13809 8.59113 0 8.30382 0 8.00004C0 7.69625 0.13809 7.40894 0.375305 7.21917L9.12531 0.219168C9.55657 -0.125842 10.1859 -0.0559202 10.5309 0.375342Z" fill="#252831"/>
                  </svg>
               </button>
               <p v-if='filter == "weekly"' class='leading-title'>Weekly order list</p>
               <p v-if='filter == "monthly"' class='leading-title'>Monthly order list</p>
            </div>
         </div>
      </div>

      <div v-if="orders.length == 0" class='banner-order-no-found'>
         <svg width="130" height="130" viewBox="0 0 130 130" fill="none" xmlns="http://www.w3.org/2000/svg">
         <circle cx="65" cy="65" r="65" fill="#E9E9E9"/>
         <path d="M44 32H71.1716L91 51.8284V93C91 94.3261 90.4732 95.5979 89.5355 96.5355C88.5979 97.4732 87.3261 98 86 98H44C42.6739 98 41.4021 97.4732 40.4645 96.5355C39.5268 95.5979 39 94.3261 39 93V37C39 35.6739 39.5268 34.4021 40.4645 33.4645C41.4021 32.5268 42.6739 32 44 32Z" stroke="#2790F9" stroke-width="4" stroke-linecap="round" stroke-linejoin="round"/>
         <path d="M69 32V55H91" stroke="#2790F9" stroke-width="4" stroke-linecap="round" stroke-linejoin="round"/>
         <path d="M79 79H51" stroke="#2790F9" stroke-width="4" stroke-linecap="round" stroke-linejoin="round"/>
         <path d="M61.5 65H56.25H51" stroke="#2790F9" stroke-width="4" stroke-linecap="round" stroke-linejoin="round"/>
         </svg>

         <p v-if='filter == "weekly"' class='t-thrid'>There is no weekly order</p>
         <p v-if='filter == "monthly"'class='t-thrid'>There is no monthly order</p>
      </div>

      <ul class='list-order'>
         <li v-for='(order, orderKey) in orders' :key='orderKey'>

            <div class='order-head'>
               <svg width="21" height="17" viewBox="0 0 21 17" fill="none" xmlns="http://www.w3.org/2000/svg"><rect x="2.5" y="6.5" width="16" height="10" rx="1.5" fill="white" stroke="black"/><path d="M20.096 4.43083L20.0959 4.4307L17.8831 0.787088L17.8826 0.786241C17.7733 0.605479 17.5825 0.5 17.3865 0.5H3.61215C3.41614 0.5 3.22534 0.605479 3.11605 0.786241L3.11554 0.787088L0.902826 4.43061C0.902809 4.43064 0.902792 4.43067 0.902775 4.4307C0.0376853 5.85593 0.639918 7.73588 1.97289 8.31233C2.15024 8.38903 2.34253 8.44415 2.54922 8.47313C2.67926 8.49098 2.81302 8.5 2.9473 8.5C3.80016 8.5 4.5594 8.1146 5.08594 7.50809L5.46351 7.07318L5.84107 7.50809C6.36742 8.11438 7.12999 8.5 7.97971 8.5C8.83258 8.5 9.59181 8.1146 10.1184 7.50809L10.4959 7.07318L10.8735 7.50809C11.3998 8.11438 12.1624 8.5 13.0121 8.5C13.865 8.5 14.6242 8.1146 15.1508 7.50809L15.5273 7.07438L15.905 7.50705C16.4357 8.11494 17.1956 8.5 18.0445 8.5C18.1822 8.5 18.3128 8.49098 18.4433 8.47304L20.096 4.43083ZM20.096 4.43083C21.0907 6.06765 20.1619 8.23575 18.4435 8.47301L20.096 4.43083Z" fill="white" stroke="black"/></svg>
               <div class='leading'><span>{{ order.store_name }}</span></div>
               <div @click='btn_delete_order(order.order_id)' class='status'> Delete </div>
            </div>

            <div 
               v-for='(product, prodKey) in order.order_products' :key='prodKey' class='order-prods'>
               <div class='leading'>
                  <img :src="product.product_image.url">
               </div>
               <div class='prod-detail'>
                  <span class='prod-name'>{{ product.name }}</span>
                  <span class='prod-quantity'>{{ product.order_group_product_quantity_count }}x</span>
               </div>
               <div class='prod-price' :class='product.has_discount != 0 ? "has-discount" : ""'>
                  <span class='price'>
                     {{ common_price_show_currency(product.price) }}
                  </span>
                  <span v-if='product.has_discount != 0' class='sub-price'>
                     
                  </span>
               </div>
            </div>

            <div class='order-bottom'>
               <span class='total-product'>{{ count_total_product_in_order(order.order_id) }} product</span>
               <span class='total-price'>Total: <span class='t-primary'>{{ count_total_price_in_order(order.order_id) }}</span></span>
            </div>

            <div class='order-delivery-time'>
               <table>
                  <tr v-for='( shipping, shippingKey ) in order.order_time_shipping' :key='shippingKey'>
                     <td v-if='shipping.order_time_shipping_type == "monthly" '>Date {{shipping.order_time_shipping_day}}</td>
                     <td v-if='shipping.order_time_shipping_type == "weekly" '>{{shipping.order_time_shipping_day}}</td>
                     <td class='td-left'> | {{shipping.order_time_shipping_time}}</td>
                  </tr>
               </table>
            </div>

         </li>
      </ul>
   </div>

   <div v-show='loading == true'>
      <div class='progress-center'>
         <div class='progress-container enabled'><progress class='progress-circular enabled' ></progress></div>
      </div> 
   </div>

   <div v-show='popup_delete_all_item == true' class='modal-popup open'>
      <div class='modal-wrapper'>
         <p v-if='filter == "weekly"' class='heading'>Are you sure to delete this<br> weekly order?</p>
         <p v-if='filter == "monthly"' class='heading'>Are you sure to delete this<br> monthly order?</p>
         <div class='actions'>
            <button @click='buttonCloseModal_delete_all_item' class='btn btn-outline'>Cancel</button>
            <button @click='buttonCloseModal_delete_confirm' class='btn btn-primary'>Delete</button>
         </div>
      </div>
   </div>

</div>

<script type='module'>

var { createApp } = Vue;

createApp({
   data (){
      return {
         popup_delete_all_item: false,
         loading: false,
         filter: '',
         orders: [],
         order_id_delete: null,
         paged: 0,
      }
   },

   methods: {
      common_price_show_currency(p){return common_price_show_currency(p)},

      get_price_after_discount( p ){
         var price      = p.price;
         var discount   = p.order_group_product_discount_percent;
         var quantity   = p.order_group_product_quantity_count;
      },

      common_price_after_discount_and_quantity_from_group_order(p){ return common_price_after_discount_and_quantity_from_group_order(p) },

      async buttonCloseModal_delete_confirm(){
         this.loading = true;
         if(this.order_id_delete != null || this.order_id_delete != 0 ){
            var form = new FormData();
            form.append('action', 'atlantis_delete_order');
            form.append('order_id', this.order_id_delete);
            var r = await window.request(form);
            if( r != undefined ){
               var res = JSON.parse( JSON.stringify( r) );
               if( res.message == 'order_delete_ok' ){
                  this.popup_delete_all_item = false;
                  this.orders.forEach( (item, index ) => {
                     if( item.order_id == this.order_id_delete ){
                        this.orders.splice(index ,1);
                     }
                  });
               }
            }
            this.order_id_delete = null;
         }
         window.appbar_fixed();
         this.loading = false;
      },

      btn_delete_order(order_id){
         this.popup_delete_all_item = !this.popup_delete_all_item;
         this.order_id_delete = order_id;
      },

      buttonCloseModal_delete_all_item(){ this.order_id_delete = 0; this.popup_delete_all_item = false; },

      count_total_price_in_order(order_id ){
         var _total = 0;

         this.orders.some( order => {
            if( order.order_id == order_id ){
               order.order_products.some ( product => {
                  _total += get_total_price(
                     product.price, 
                     product.order_group_product_quantity_count, 
                     0
                     // product.order_group_product_discount_percent
                  )
               });
            }
         });
         return _total.toLocaleString('vi-VN') + ' đ';
      },

      count_total_product_in_order(order_id){
         var _total = 0;
         this.orders.some( order => {
            if( order.order_id == order_id ){
               order.order_products.some( product => {
                  _total += parseInt( product.order_group_product_quantity_count );
               });
            }
         });
         return _total;
      },

      gotoOrderFilter(filter){ window.gotoOrderFilter(filter); },

      select_filter( filter_select ){ this.order_status_select = filter_select; },
      gotoProductDetail(product_id){ window.gotoProductDetail(product_id); },
      gotoStoreDetail(store_id){ window.gotoStoreDetail(store_id); },
      gotoOrderDetail(order_id){ window.gotoOrderDetail(order_id); },
      goBack(){ window.goBack(); },

      async get_order_filter(paged){
         var form = new FormData();
         form.append('action', 'atlantis_get_order_filter');
         form.append('filter', this.filter);
         form.append('paged', paged);
         var r = await window.request(form);
         if( r != undefined ){
            var res = JSON.parse( JSON.stringify( r ));
            if( res.message == 'get_order_ok' ){
               // GROUP PRODUCT 
               res.data.forEach(item => {
                  if (!this.orders.some(existingItem => existingItem.order_id === item.order_id)) {
                     this.orders.push( item );
                  }
               });
            }
         }
      },

      async handleScroll(){
         const windowTop = window.pageYOffset || document.documentElement.scrollTop;
         const scrollEndThreshold = 50; // Adjust this value as needed
         const scrollPosition = window.pageYOffset || document.documentElement.scrollTop;
         const windowHeight = window.innerHeight;
         const documentHeight = document.documentElement.scrollHeight;

         var windowScroll     = scrollPosition + windowHeight + scrollEndThreshold;
         var documentScroll   = documentHeight + scrollEndThreshold;

         if (scrollPosition + windowHeight + 10 >= documentHeight - 10) {
            await this.get_order_filter( this.paged++);
         }
      }
   },

   mounted() {
      window.addEventListener('scroll', this.handleScroll);
   },
   beforeDestroy() {
      window.removeEventListener('scroll', this.handleScroll);
   },

   async created(){

      const urlParams = new URLSearchParams(window.location.search);
      const filter = urlParams.get('filter');

      this.filter = filter;
      this.loading = true;
      await this.get_order_filter(0);
      console.log(this.orders);
      window.appbar_fixed();
      this.loading = false;
      
   },
}).mount('#app');
</script>