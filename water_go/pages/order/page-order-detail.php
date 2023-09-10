<div id='app'>

   <div v-show='loading == true && order != null && order.order_hidden == 0'>
      <div class='progress-center'>
         <div class='progress-container enabled'><progress class='progress-circular enabled' ></progress></div>
      </div>
   </div>
   
   <div v-show='loading == false && order != null && order.order_hidden == 0' class='page-order-detail'>

      <div class='appbar'>
         <div class='appbar-top'>
            <div class='leading'>

               <button @click='goBack' class='btn-action'>
                  <svg width="20" height="16" viewBox="0 0 20 16" fill="none" xmlns="http://www.w3.org/2000/svg">
                  <path fill-rule="evenodd" clip-rule="evenodd" d="M0 8C0 7.44772 0.447715 7 1 7H18.5C19.0523 7 19.5 7.44772 19.5 8C19.5 8.55228 19.0523 9 18.5 9H1C0.447715 9 0 8.55228 0 8Z" fill="#252831"/>
                  <path fill-rule="evenodd" clip-rule="evenodd" d="M10.5309 0.375342C10.8759 0.806604 10.806 1.4359 10.3747 1.78091L2.60078 8.00004L10.3747 14.2192C10.806 14.5642 10.8759 15.1935 10.5309 15.6247C10.1859 16.056 9.55657 16.1259 9.12531 15.7809L0.375305 8.78091C0.13809 8.59113 0 8.30382 0 8.00004C0 7.69625 0.13809 7.40894 0.375305 7.21917L9.12531 0.219168C9.55657 -0.125842 10.1859 -0.0559202 10.5309 0.375342Z" fill="#252831"/>
                  </svg>
               </button>
               
               <p v-if='order_number != 0' class='leading-title'>#{{ order_number }}</p>
            </div>
            <div class='action'>
               <span class='badge-status'>{{ get_status_activity(order_status) }}</span>
            </div>
         </div>
      </div>

      <div class='break-line'></div> 

      <div v-show='order_delivery_address != null' class='inner'>
         <div class='list-tile delivery-address style-order'>
            <div class='content'>
               <p class='tt01'><?php echo __('Delivery address', 'watergo'); ?></p>
               <p class='tt03' v-if='order_delivery_address != null'>{{ order_delivery_address.address }}</p>
               <p class='tt02' v-if='order_delivery_address != null'>{{ order_delivery_address.name }} {{ hasMoreThanTwoZeroes(order_delivery_address.phone) ? ' | (+84) ' + removeZeroLeading( order_delivery_address.phone ) : '' }}</p>
            </div>
         </div>
      </div>

      <div class='break-line'></div> 

      <ul v-if='order != null' class='list-tile order'>

         <li>
            <div @click='gotoStoreDetail(order.store_id)' class='shop-detail add-arrow'>
               <div class='logo'>
                  <svg width="21" height="17" viewBox="0 0 21 17" fill="none" xmlns="http://www.w3.org/2000/svg">
                     <rect x="2.5" y="6.5" width="16" height="10" rx="1.5" fill="white" stroke="black"/>
                     <path d="M20.096 4.43083L20.0959 4.4307L17.8831 0.787088L17.8826 0.786241C17.7733 0.605479 17.5825 0.5 17.3865 0.5H3.61215C3.41614 0.5 3.22534 0.605479 3.11605 0.786241L3.11554 0.787088L0.902826 4.43061C0.902809 4.43064 0.902792 4.43067 0.902775 4.4307C0.0376853 5.85593 0.639918 7.73588 1.97289 8.31233C2.15024 8.38903 2.34253 8.44415 2.54922 8.47313C2.67926 8.49098 2.81302 8.5 2.9473 8.5C3.80016 8.5 4.5594 8.1146 5.08594 7.50809L5.46351 7.07318L5.84107 7.50809C6.36742 8.11438 7.12999 8.5 7.97971 8.5C8.83258 8.5 9.59181 8.1146 10.1184 7.50809L10.4959 7.07318L10.8735 7.50809C11.3998 8.11438 12.1624 8.5 13.0121 8.5C13.865 8.5 14.6242 8.1146 15.1508 7.50809L15.5273 7.07438L15.905 7.50705C16.4357 8.11494 17.1956 8.5 18.0445 8.5C18.1822 8.5 18.3128 8.49098 18.4433 8.47304L20.096 4.43083ZM20.096 4.43083C21.0907 6.06765 20.1619 8.23575 18.4435 8.47301L20.096 4.43083Z" fill="white" stroke="black"/>
                  </svg>
               </div>
               <span class='shop-name' v-if='order.store_name != null'>{{ order.store_name }}</span>
            </div>

            <div v-for='(product, product_key) in order.order_products' :key='product_key'
               class='list-items'>
               <div class="list-items-wrapper">
                  <span class='quantity'>{{ product.order_group_product_quantity_count }}x</span>
                  <div class='order-gr'>
                     <span class='product-title'>{{ product.order_group_product_metadata.product_name }}</span>
                     <span class='product-subtitle'>{{ product.order_group_product_metadata.product_name_second }}</span>
                  </div>
                  <div class='order-price'>
                     <span class='price'>
                        {{ common_price_after_discount_and_quantity_from_group_order(product) }}
                     </span>
                     <span v-show='product.order_group_product_discount_percent != 0' class='od-price-discount'>
                        {{ common_price_after_quantity_from_group_order(product) }}
                     </span>
                  </div>
               </div>
            </div>

         </li>
      </ul>

      <div v-if='order != null && order.order_delivery_type != null' class='box-delivery-time'>
         <p class='tt01'><?php echo __('Delivery time', 'watergo'); ?></p>
         <p class='tt02'>{{ get_delivery_time_activity }}</p>
         <p class='tt03' v-if='order.order_delivery_type == "once_immediately"'><?php echo __('Immediately (within 1 hour)', 'watergo'); ?> </p>
         <div 
            v-if='
               order.order_delivery_type == "once_date_time" ||
               order.order_delivery_type == "weekly" ||
               order.order_delivery_type == "monthly"
            '
            v-for='( time_shipping, date_time_key ) in filter_time_shipping' :key='date_time_key'
            class='display_delivery_time'
            :class='time_shipping.order_time_shipping_id == order.order_time_shipping_id ? "highlight" : ""'
            >
               <div v-if='time_shipping.order_time_shipping_type == "once_date_time"' class='date_time_item'>{{ time_shipping.order_time_shipping_day }}</div>
               <div v-if='time_shipping.order_time_shipping_type == "once_date_time"' class='date_time_item'>{{ add_extra_space_order_time_shipping_time(time_shipping.order_time_shipping_time) }}</div>
               <div v-if='time_shipping.order_time_shipping_type == "weekly"' class='date_time_item'>{{ get_title_weekly_compact(time_shipping.order_time_shipping_day) }}</div>
               <div v-if='time_shipping.order_time_shipping_type == "weekly"' class='date_time_item'>{{ add_extra_space_order_time_shipping_time(time_shipping.order_time_shipping_time) }}</div>
               <div v-if='time_shipping.order_time_shipping_type == "monthly"' class='date_time_item'><?php echo __('Date', 'watergo'); ?> {{ time_shipping.order_time_shipping_day }}</div>
               <div v-if='time_shipping.order_time_shipping_type == "monthly"' class='date_time_item'>{{ add_extra_space_order_time_shipping_time(time_shipping.order_time_shipping_time) }}</div>
         </div>
      </div>

      <div class='break-line'></div>
      <div class='box-payment-method'>
         <p class='heading-02'><?php echo __('Payment method', 'watergo'); ?> </p>
         <p class='heading-03'>{{ get_payment_method_activity }}</p>
      </div>

      <div class='break-line'></div>
      <div v-if='order != null' class='box-time-order'>
         <p class='heading-03'><?php echo __('Ordered Time', 'watergo'); ?>: <span class='t-6 ml5'>{{ order_formatDate(order.order_time_created) }}</span></p>
         <p v-if='order != null && order.order_time_confirmed != null && order.order_time_confirmed != "" && order.order_time_confirmed != 0 ' class='heading-03'><?php echo __('Confirmed Time', 'watergo'); ?>: <span class='t-6 ml5'>{{ order_formatDate(order.order_time_confirmed ) }}</span></p>
         <p v-if='order != null && order.order_time_delivery != null && order.order_time_delivery != "" && order.order_time_delivery != 0 ' class='heading-03'><?php echo __('Delivery Time', 'watergo'); ?>: <span class='t-6 ml5'>{{ order_formatDate(order.order_time_delivery) }}</span></p>
         <p v-if='order != null && order.order_time_completed != null && order.order_time_completed != "" && order.order_time_completed != 0 ' class='heading-03'><?php echo __('Complete Time', 'watergo'); ?>: <span class='t-6 ml5'>{{ order_formatDate(order.order_time_completed) }}</span></p>
         <p v-if='order != null && order.order_time_cancel != null && order.order_time_cancel != "" && order.order_time_cancel != 0 ' class='heading-03'><?php echo __('Cancel Time', 'watergo'); ?>: <span class='t-6 ml5'>{{ order_formatDate(order.order_time_cancel) }}</span></p>
      </div>


      <div v-if='order_status != ""' class='order-bottomsheet'>
         
         <div v-if='order_status == "complete" && can_review == true' class='btn_cancel_order_wrapper'>
            <button @click='gotoAddReview(order.store_id, order.order_id )'
               class='btn btn-outline btn-review-order'><?php echo __('Review Store', 'watergo'); ?></button>
         </div>
         
         <div v-if='order_status == "ordered" || order_status == "confirmed"' class='btn_cancel_order_wrapper'>
            <button @click='btn_cancel_order' 
               v-if='order_status == "ordered" || order_status == "confirmed"' 
               class='btn btn-outline btn-cancel-order'><?php echo __('Cancel', 'watergo'); ?></button>
         </div>

         <div class='product-detail-bottomsheet' :class='get_layout_bottomsheet'>
            <p class='price-total'><?php echo __('Total', 'watergo'); ?>: <span class='t-primary t-bold'>{{ count_total_product_in_order }}</span></p>
            <button 
               v-if='check_can_reorder == true'
               @click='buttonReOrder' 
               class='btn-primary'><?php echo __('Re-Order', 'watergo'); ?></button>
         </div>
         
      </div>

   </div>

   <div v-show='popup_confirm_cancel == true' class='modal-popup style01 open'>
      <div class='modal-wrapper'>
         <div class='modal-close'><div @click='buttonModalCancel' class='close-button'><span></span><span></span></div></div>
         <p class='tt01'><?php echo __('Select Cancellation Reason', 'watergo'); ?></p>
         <ul class='list-Reason'>
            <li @click='btn_select_reason(reason.label)'
               v-for='(reason, index) in reason_cancel' :key='index'>
               <span
                  :class='reason.active == true ? "active" : ""' 
                  class='radio-button'></span>
               <span class='value'>{{ reason.label }}</span>
            </li>
         </ul>
         <div class='actions'>
            <button @click='buttonModalSubmit_cancel_order' class='btn btn-primary'><?php echo __('Submit', 'watergo'); ?></button>
         </div>
      </div>
   </div>
   
   <div v-show='popup_out_of_stock == true' class='modal-popup open'>
      <div class='modal-wrapper'>
         <div class='modal-close'><div @click='buttonCloseModal_store_out_of_stock' class='close-button'><span></span><span></span></div></div>
         <p class='heading'><?php echo __("This Product is <span class='t-primary'>Out of Stock</span>", 'watergo'); ?></p>
      </div>
   </div>

   <div v-show='popup_banner_already_review == true' class='modal-popup open'>
      <div class='modal-wrapper'>
         <div class='modal-close'><div @click='buttonCloseModal_already_review' class='close-button'><span></span><span></span></div></div>
         <p class='heading'><?php echo __('You already review this order', 'watergo'); ?> !</p>
      </div>
   </div>

   <div class='modal-popup' :class=' loading == false && ( order == null || order.order_hidden == 1 ) ? "open" : ""'>
      <div class='modal-wrapper'>
         <div class='modal-close'><div @click='goBack' class='close-button'><span></span><span></span></div></div>
         <p class='heading'><?php echo __('Content Not Found', 'watergo'); ?> </p>
      </div>
   </div>

   <div v-show='banner_open == true' class='banner' :class='banner_open == true ? "z-index-5": ""'>
      <div class='banner-head'>
         <svg width="64" height="64" viewBox="0 0 64 64" fill="none" xmlns="http://www.w3.org/2000/svg">
         <circle cx="32" cy="32" r="32" fill="#2790F9"/>
         <path fill-rule="evenodd" clip-rule="evenodd" d="M44.7917 24.8288L42.103 22.1401L27.8578 36.3854L22.2522 30.7798L19.5635 33.4685L27.9506 41.8557L30.6393 39.167L30.5465 39.0741L44.7917 24.8288Z" fill="white"/>
         </svg>
         <h3><?php echo __('Order Successfully', 'watergo'); ?></h3>
      </div>
      <div class='banner-footer'>
         <button @click='goBackReOrder' ><?php echo __('Exit', 'watergo'); ?></button>
      </div>
   </div>

</div>

<script type='module' setup>

var { createApp } = Vue;

createApp({
   data (){
      return {
         loading: false,
         banner_open: false,
         popup_out_of_stock: false,
         order_is_out_of_stock: false,

         popup_banner_already_review: false,

         can_review: false,

         popup_confirm_cancel: false,

         order_number: 0,
         order_status: '',
         order_delivery_address: null,

         get_locale: '<?php echo get_locale(); ?>',

         time_shipping: [],

         reason_cancel: [
            {label: 'Reason 1', active: false},
            {label: 'Reason 2', active: false},
            {label: 'Reason 3', active: false},
            {label: 'Reason 4', active: false},
            {label: '<?php echo __("Others", 'watergo'); ?>', active: false}
         ],

         order: null
      }
   },

   methods: {

      

      get_title_weekly_compact( title ){
         if( this.get_locale == 'vi' ){
            if( title == 'Monday' ) return 'Thứ Hai';
            if( title == 'Tuesday' ) return 'Thứ Ba';
            if( title == 'Wednesday' ) return 'Thứ Tư';
            if( title == 'Thursday' ) return 'Thứ Năm';
            if( title == 'Friday' ) return 'Thứ Sáu';
            if( title == 'Saturday' ) return 'Thứ Bảy';
            if( title == 'Sunday' ) return 'Chủ Nhật';

         }else{
            return title;
         }
      },

      hasMoreThanTwoZeroes(number) {
         const numStr = number.toString();
         if( !/00{2,}/.test(numStr) ){
            return true;
         }else{
            return false;
         }
      },

      common_price_after_quantity_from_group_order(p){ return common_price_after_quantity_from_group_order(p) },
      common_price_after_discount_and_quantity_from_group_order(p){ return common_price_after_discount_and_quantity_from_group_order(p) },

      add_extra_space_order_time_shipping_time(n){ return window.add_extra_space_order_time_shipping_time(n)},


      buttonCloseModal_store_out_of_stock(){ this.popup_out_of_stock = false; },
      buttonCloseModal_already_review(){ this.popup_banner_already_review = false; },

      removeZeroLeading( n ){ return window.removeZeroLeading(n)},
      get_total_price( price, quantity, discount){ return window.get_total_price( price, quantity, discount); },
      order_formatDate(timestamp){ return window.order_formatDate(timestamp);},
      get_fulldate_from_day(day ){ return window.get_fulldate_from_day(day) },
      get_fullday_form_dayOfWeek(dayOfWeek ){ return window.get_fullday_form_dayOfWeek(dayOfWeek) },
      get_shortname_day_of_week(dayOfWeek ){ return window.get_shortname_day_of_week(dayOfWeek) },

      // PERFORM CANCEL ORDER
      btn_cancel_order(){this.popup_confirm_cancel = true;},
      btn_select_reason( key ){
         this.reason_cancel.some( item => { 
            if( item.label == key ){ item.active = true;
            }else{ item.active = false; }
         });
      },

      buttonModalCancel(){ 
         this.popup_confirm_cancel = false; 
         this.reason_cancel.some(item => item.active = false ); 
      },
      
      async buttonModalSubmit_cancel_order(){
         
         var isCancel = this.reason_cancel.some(item => item.active == true ); 
         if( isCancel == true ){
            this.loading = true;
            var form = new FormData();
            form.append('action', 'atlantis_cancel_order');
            form.append('order_id', this.order.order_id);
            form.append('order_type', this.order.order_delivery_type);
            var r = await window.request(form);
            if( r != undefined ){
               var res = JSON.parse( JSON.stringify(r));
               if( res.message == 'cancel_done' ) {
                  this.goBack();
               }
            }
            this.loading = false;
         }
      },

      // END CANCEL ORDER

      async findOrder( order_id ){
         var form = new FormData();
         form.append('action', 'atlantis_get_order_detail');
         form.append('order_id', order_id);
         var r = await window.request(form);
         if( r != undefined ){
            var res = JSON.parse( JSON.stringify( r ));
            if( res.message == 'get_order_ok'){
               
               this.order_number = res.data.order_number;
               this.order_status = res.data.order_status;
               this.order_delivery_address = res.data.order_delivery_address;

               this.order = res.data;

               setTimeout(() => {}, 1);
            }
         }
      },

      buttonReOrder(){
         if( this.order_is_out_of_stock == false ){
            window.gotoPageReOrder(this.order.order_id);
         }else{
            this.popup_out_of_stock = true;
         }

         // if( this.order_is_out_of_stock == false ){
         //    this.loading = true;
         //    var form = new FormData();
         //    form.append('action', 'atlantis_re_order');
         //    form.append('order_id', this.order.order_id)
         //    var r = await window.request(form);
         //    // console.log(r)
         //    if( r != undefined ){
         //       var res = JSON.parse( JSON.stringify( r ));
         //       if( res.message == 'reorder_ok' ){
         //          this.banner_open == true;
         //       }
         //    }
         //    this.loading = false;
         // }

      },

      goBack(){ 
         window.location.href = '?appt=X';
      },

      goBackReOrder(){window.goBack();},

      gotoStoreDetail(store_id){ 
         window.gotoStoreDetail(store_id); 
      },

      async gotoAddReview(store_id, order_id){ 
         await this.is_can_review(order_id);
         if( this.can_review == true ){
            window.gotoAddReview(store_id, order_id);
         }else{
            this.popup_banner_already_review = true;
         }
      },

      get_status_activity( status ){
         
         if( this.get_locale == 'vi'){
            if( status == 'ordered') return 'Chờ xác nhận';
            if( status == 'confirmed') return 'Chờ giao';
            if( status == 'delivering') return 'Đang giao';
            if( status == 'complete') return 'Đã nhận';
            if( status == 'cancel') return 'Đã hủy ';
         }else{
            if( status == 'ordered') return 'Pending';
            if( status == 'confirmed') return 'Prepare';
            if( status == 'delivering') return 'Delivering';
            if( status == 'complete') return 'Complete';
            if( status == 'cancel') return 'Cancel';
         }
         
      },

      async get_time_shipping_order(order_id){
         var form = new FormData();
         form.append('action', 'atlantis_get_all_time_shipping_from_order');
         form.append('order_id', order_id);
         var r = await window.request(form);
         if( r != undefined ){
            var res = JSON.parse( JSON.stringify( r ));
            if( res.message == 'time_shipping_found'){
               this.time_shipping.push(...res.data);
            }
         }
      },

      async is_can_review( order_id ){
         var form = new FormData();
         form.append('action', 'atlantis_is_user_has_review_store');
         form.append('order_id', order_id);
         var r = await window.request(form);
         if( r != undefined ){
            var res = JSON.parse( JSON.stringify( r));
            if( res.message == 'review_not_found' ){
               this.can_review = true;
            }else{
               this.can_review = false;
            }
         }
      }

   },

   computed: {

      check_can_reorder(){
         if( 
            ( this.order.order_delivery_type == 'once_immediately' || this.order.order_delivery_type == 'once_date_time' ) && 
            ( this.order.order_status == "complete" || this.order.order_status == "cancel" )
         ){
            return true;
         }else{
            return false;
         }
      },

      get_layout_bottomsheet(){
         if( this.order.order_status == "ordered" || this.order.order_status == "confirmed" || this.order.order_status == "delivering" ){
            return "cell-one-column";
         }else if( this.order.order_status == "complete" || this.order.order_status == "cancel" ){
            if( this.order.order_delivery_type == 'once_immediately' || this.order.order_delivery_type == 'once_date_time' ){
               return "cell-re-order";
            }else{
               return "cell-one-column";
            }
         }
      },

      count_total_product_in_order(){
         var _total = 0;
         this.order.order_products.some ( product => {
            _total += get_total_price(
               product.order_group_product_price, 
               product.order_group_product_quantity_count, 
               product.order_group_product_discount_percent
            );
         });
         return _total.toLocaleString('vi-VN') + ' đ';
      },

      get_delivery_time_activity(){
         var _delivery_type = '';

         if( this.order.order_delivery_type == 'once_immediately' ){
            _delivery_type = 'once';
         } else if( this.order.order_delivery_type == 'once_date_time' ){
            _delivery_type = 'once';
         } else if( this.order.order_delivery_type == 'weekly' ){
            _delivery_type = 'weekly';
         } else if( this.order.order_delivery_type == 'monthly' ){
            _delivery_type = 'monthly';
         }

         if(this.get_locale == 'vi'){
            if( this.order.order_delivery_type == 'once_immediately' ){
               return 'Giao một lần';
            } else if( this.order.order_delivery_type == 'once_date_time' ){
               return 'Giao một lần';
            } else if( this.order.order_delivery_type == 'weekly' ){
               return 'Giao hàng tuần';
            } else if( this.order.order_delivery_type == 'monthly' ){
               return 'Giao hàng tháng';
            }
         }else{
            return 'Delivery ' + _delivery_type;
         }
         

      },

      get_payment_method_activity(){
         if( this.order != null && this.order.order_payment_method == 'cash' ){
            if(this.get_locale == 'vi'){
               return 'Tiền mặt';
            }
            return 'By Cash';
         }else{
            if(this.get_locale == 'vi'){
               return 'Tiền mặt';
            }
            return 'By Cash';
         }
      },

      filter_time_shipping(){
         return this.time_shipping;
         // .sort( ( a, b ) => a.order_time_shipping_datetime < b.order_time_shipping_datetime  );
      }

   },


   async created(){
      this.loading = true;
      const urlParams = new URLSearchParams(window.location.search);
      const order_id = urlParams.get('order_id');
      await this.findOrder(order_id);

      await this.get_time_shipping_order(order_id);

      await this.is_can_review(order_id);

      // console.log(this.order)

      // IF THIS IS SUB ORDER FROM PARENT SO DONT DO REORDER
      
      if( this.order != null && ( this.order.order_status == 'complete' || this.order.order_status == 'cancel' ) ){
         if( this.order.order_repeat_id == null || this.order.order_repeat_id == 0){
            var _formCheckReorder = new FormData();
            _formCheckReorder.append('action', 'atlantis_is_product_out_of_stock_from_order');
            _formCheckReorder.append('order_id', order_id);
            var _r = await window.request(_formCheckReorder);
            if( _r != undefined ){
               var _res = JSON.parse( JSON.stringify( _r ) );
               if( _res.message == 'reorder_out_of_stock' ){
                  this.order_is_out_of_stock = true;
               }
            }

         }
      }

      console.log(this.order)

      setTimeout(() => {}, 200);
      
      window.appbar_fixed();
      this.loading = false;
   },

}).mount('#app');

</script>