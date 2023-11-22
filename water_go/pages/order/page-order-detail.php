<?php 
   $get_locale = get_locale();

   $order_text = 'Order';
   if( $get_locale == 'vi'){
      $order_text = 'Đơn hàng';
   }else if($get_locale == 'ko_KR'){
      $order_text = '주문번호';
   }
?>
<style>
   .list-tile.order .list-items .list-items-wrapper{
      flex-flow: row wrap;
   }
   @media screen and (max-width: 350px){
      .badge-status{
         min-width: auto;
         font-size: 4vw;
         white-space: nowrap;
      }
   }
   .box-textarea{
      margin-top: 10px;
      padding-bottom: 10px;
   }
   .btn-primary.disabled{
      opacity: 0.6;
      pointer-events: none;
   }
   .box-textarea textarea{
      overflow: hidden;
      height: auto;
   }
</style>
<div id='app'>

   <div v-if='loading == true && order != null && order.order_hidden == 0'>
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
               
               <p v-if='order_number != 0' class='leading-title'><?php echo $order_text; ?> #{{ order_number }}</p>
            </div>
            <div v-show='is_user_can_chat == true' class='action'>
               <!-- <span class='badge-status'>{{ get_status_activity(order_status) }}</span> -->
               <button @click='atlantis_create_conversation_or_get_it(order.order_id, order.store_id)' class='btn-chat'>
                  <svg width="22" height="20" viewBox="0 0 22 20" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M20.4711 0H1.30667C0.960117 0 0.627761 0.137459 0.382714 0.382139C0.137666 0.626819 0 0.958676 0 1.30471V15.2216C0 15.5676 0.137666 15.8995 0.382714 16.1441C0.627761 16.3888 0.960117 16.5263 1.30667 16.5263H7.78229C7.85748 16.5262 7.9314 16.5457 7.99685 16.5826C8.0623 16.6196 8.11705 16.6728 8.15578 16.7372L9.76624 19.3684C9.88246 19.5611 10.0466 19.7205 10.2427 19.8312C10.4389 19.9418 10.6603 20 10.8856 20C11.1109 20 11.3324 19.9418 11.5285 19.8312C11.7246 19.7205 11.8888 19.5611 12.005 19.3684L13.6198 16.7307C13.6585 16.6663 13.7133 16.6131 13.7788 16.5761C13.8442 16.5391 13.9181 16.5197 13.9933 16.5197H20.4711C20.8177 16.5197 21.15 16.3823 21.3951 16.1376C21.6401 15.8929 21.7778 15.5611 21.7778 15.215V1.30471C21.7778 0.958676 21.6401 0.626819 21.3951 0.382139C21.15 0.137459 20.8177 0 20.4711 0ZM20.9067 15.2216C20.9067 15.3369 20.8608 15.4475 20.7791 15.5291C20.6974 15.6106 20.5866 15.6565 20.4711 15.6565H13.9955C13.7705 15.6565 13.5493 15.7146 13.3534 15.8251C13.1575 15.9356 12.9935 16.0947 12.8772 16.2871L11.2624 18.9248C11.2238 18.9897 11.169 19.0434 11.1033 19.0808C11.0377 19.1181 10.9634 19.1377 10.8878 19.1377C10.8122 19.1377 10.738 19.1181 10.6723 19.0808C10.6066 19.0434 10.5518 18.9897 10.5132 18.9248L8.90167 16.2914C8.78586 16.0981 8.62189 15.938 8.42573 15.8267C8.22957 15.7155 8.00789 15.6568 7.78229 15.6565H1.30667C1.19115 15.6565 1.08037 15.6106 0.998682 15.5291C0.917 15.4475 0.871111 15.3369 0.871111 15.2216V1.30471C0.871111 1.18936 0.917 1.07874 0.998682 0.997184C1.08037 0.915624 1.19115 0.869804 1.30667 0.869804H20.4711C20.5866 0.869804 20.6974 0.915624 20.7791 0.997184C20.8608 1.07874 20.9067 1.18936 20.9067 1.30471V15.2216ZM11.76 8.26313C11.76 8.43517 11.7089 8.60333 11.6132 8.74637C11.5175 8.88941 11.3814 9.0009 11.2222 9.06673C11.0631 9.13256 10.8879 9.14979 10.7189 9.11623C10.55 9.08266 10.3947 8.99982 10.2729 8.87818C10.1511 8.75653 10.0681 8.60155 10.0345 8.43283C10.0009 8.2641 10.0182 8.08921 10.0841 7.93027C10.15 7.77134 10.2617 7.63549 10.4049 7.53992C10.5482 7.44434 10.7166 7.39333 10.8889 7.39333C11.1199 7.39333 11.3415 7.48497 11.5049 7.64809C11.6682 7.81121 11.76 8.03245 11.76 8.26313ZM6.96889 8.26313C6.96889 8.43517 6.9178 8.60333 6.82208 8.74637C6.72636 8.88941 6.59031 9.0009 6.43114 9.06673C6.27196 9.13256 6.09681 9.14979 5.92783 9.11623C5.75885 9.08266 5.60364 8.99982 5.48181 8.87818C5.35998 8.75653 5.27702 8.60155 5.2434 8.43283C5.20979 8.2641 5.22704 8.08921 5.29298 7.93027C5.35891 7.77134 5.47056 7.63549 5.61381 7.53992C5.75707 7.44434 5.92549 7.39333 6.09778 7.39333C6.32881 7.39333 6.55038 7.48497 6.71375 7.64809C6.87711 7.81121 6.96889 8.03245 6.96889 8.26313ZM16.5511 8.26313C16.5511 8.43517 16.5 8.60333 16.4043 8.74637C16.3086 8.88941 16.1725 9.0009 16.0134 9.06673C15.8542 9.13256 15.679 9.14979 15.5101 9.11623C15.3411 9.08266 15.1859 8.99982 15.064 8.87818C14.9422 8.75653 14.8592 8.60155 14.8256 8.43283C14.792 8.2641 14.8093 8.08921 14.8752 7.93027C14.9411 7.77134 15.0528 7.63549 15.196 7.53992C15.3393 7.44434 15.5077 7.39333 15.68 7.39333C15.911 7.39333 16.1326 7.48497 16.296 7.64809C16.4593 7.81121 16.5511 8.03245 16.5511 8.26313Z" fill="#2790F9"/></svg>
                  <span class='text'><?php echo __('Chat', 'watergo'); ?></span>
               </button>
            </div>
         </div>
      </div>

      <div class='break-line'></div> 

      <div v-if='order != null' class='inner'>
         <div class='list-tile delivery-address style-order'>
            <div class='content'>
               <p class='tt01'><?php echo __('Delivery address', 'watergo'); ?></p>
               <p class='tt03'>{{ order.order_delivery_address.address }}</p>
               <p class='tt02'>{{ order.order_delivery_address.name }} {{ hasMoreThanTwoZeroes(order.order_delivery_address.phone) ? ' | (+84) ' + removeZeroLeading( order.order_delivery_address.phone ) : '' }}</p>
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
                     <span class='product-title'>{{ product.order_group_product_name }}</span>
                     <span class='product-subtitle'>{{ product.order_group_product_name_second }}</span>
                     <span class='product-subtitle' v-show='product.order_group_product_gift_text != ""'>
                        {{ product.order_group_product_gift_text }}
                     </span>
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
         <p class='tt03' v-if='order.order_delivery_type == "once_immediately"'><?php echo __('Immediately (within 2 hour)', 'watergo'); ?> </p>
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

      <div v-if='order != null && order.order_note != null && order.order_note != ""' class='inner'>
         <div class='box-textarea'>
            <textarea ref='input_order_note'  class='input_order_note' readonly>{{order.order_note}}</textarea>
         </div>
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
            <button  @click='buttonModalSubmit_cancel_order' class='btn btn-primary' :class='is_select_reason_cancel == false ? "disabled" : ""'>
               <?php 
                  // SUBMIT BUTTON 
                  if( get_locale() == 'vi'){ echo 'Gửi';
                  }else if( get_locale() == 'ko_KR'){ echo '보내기';
                  }else{ echo 'Submit'; }
               ?>
            </button>
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

         get_locale: '<?php echo get_locale(); ?>',

         time_shipping: [],

         reason_cancel: [
            {label: '<?php echo __('Misplaced product', 'watergo'); ?>', active: false},
            {label: '<?php echo __('Change delivery information', 'watergo'); ?>', active: false},
            {label: '<?php echo __('Change delivery time', 'watergo'); ?>', active: false},
            {label: '<?php echo __('Store requested cancellation', 'watergo'); ?>', active: false},
            {label: '<?php echo __("Others", 'watergo'); ?>', active: false}
         ],

         order: null
      }
   },

   watch: {
      order: {
         handler( data ){
            if( data.order_note != null && data.order_note.length > 0){
               this.$nextTick(() => {
                  const textarea = this.$refs.input_order_note;
                  const lineHeight = 22;
                  const content = textarea.value;
                  const lineBreaksCount = (content.match(/\n/g) || []).length + (content.match(/<br\s*\/?>/g) || []).length;
                  textarea.style.height = `${lineHeight * (lineBreaksCount + 1)}px`;
               });

            }
         }, deep: true
      }
   },

   methods: {

      async atlantis_create_conversation_or_get_it(order_id, store_id){ 
         var form = new FormData();
         form.append('action', 'atlantis_create_conversation_or_get_it');
         form.append('order_id', order_id);
         form.append('store_id', store_id);
         var r = await window.request(form);
         if( r != undefined ){
            var res = JSON.parse( JSON.stringify( r));
            if( res.message == 'conversation_found' ){
               var conversation_id   = res.data;
               window.location.href = window.watergo_domain + 'chat/?chat_page=chat-messenger&conversation_id=' + conversation_id + '&where_app=chat_to_store&order_id=' + order_id + '&appt=N';
            }
         }
      },

      get_title_weekly_compact( title ){
         if( this.get_locale == 'vi' ){
            if( title == 'Monday' ) return 'Thứ Hai';
            if( title == 'Tuesday' ) return 'Thứ Ba';
            if( title == 'Wednesday' ) return 'Thứ Tư';
            if( title == 'Thursday' ) return 'Thứ Năm';
            if( title == 'Friday' ) return 'Thứ Sáu';
            if( title == 'Saturday' ) return 'Thứ Bảy';
            if( title == 'Sunday' ) return 'Chủ Nhật';

         }else if( this.get_locale == 'ko_KR' ){
            if( title == 'Monday' )    return '월요일';
            if( title == 'Tuesday' )   return '화요일';
            if( title == 'Wednesday' ) return '수요일';
            if( title == 'Thursday' )  return '목요일';
            if( title == 'Friday' )    return '금요일';
            if( title == 'Saturday' )  return '토요일';
            if( title == 'Sunday' )    return '일요일';

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
         }else if( this.get_locale == 'ko_KR' ) {
            if( status == 'ordered') return '주문 완료';
            if( status == 'confirmed') return '준비중';
            if( status == 'delivering') return '배송중';
            if( status == 'complete') return '완료';
            if( status == 'cancel') return '취소';
         }else {
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
      },

      async atlantis_notification_mark_read_notification_hash_id(hash_id){
         var form = new FormData();
         form.append('action', 'atlantis_notification_mark_read_notification_hash_id');
         form.append('hash_id', hash_id);
         var r = await window.request(form);
      },

   },

   computed: {

      is_select_reason_cancel(){
         return this.reason_cancel.some( item => item.active == true);
      },

      is_user_can_chat(){
         if( this.order != null && ( this.order.order_status == "complete" || this.order.order_status == "cancel" ) ){
            return false;
         }
         return true;
      },

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
         return parseInt(_total).toLocaleString() + global_currency;
      },

      get_delivery_time_activity(){
         var _delivery_type = '';

         var text_delivery_once = '<?php echo __("Delivery once", 'watergo'); ?>';
         if( this.get_locale == 'vi' ){
            text_delivery_once = 'Giao thường';
         }

         if( this.order.order_delivery_type == 'once_immediately' ){
            return text_delivery_once;
         } else if( this.order.order_delivery_type == 'once_date_time' ){
            return text_delivery_once;
         } else if( this.order.order_delivery_type == 'weekly' ){
            return '<?php echo __("Delivery weekly", 'watergo'); ?>';
         } else if( this.order.order_delivery_type == 'monthly' ){
            return '<?php echo __("Delivery monthly", 'watergo'); ?>';
         }
      },

      get_payment_method_activity(){
         if( this.order != null && this.order.order_payment_method == 'cash' ){
            return '<?php echo __('By Cash', 'watergo'); ?>';
         }else{
            return '<?php echo __('By Cash', 'watergo'); ?>';
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
      const order_id             = urlParams.get('order_id');
      const hash_id              = urlParams.get('hash_id');

      try {
         if( hash_id != undefined ){
            let requestPromise = await this.atlantis_notification_mark_read_notification_hash_id(hash_id);
            let immediatePromise = new Promise(resolve => resolve());
            await Promise.race([requestPromise, immediatePromise]);
         }
      } catch (error) {
         console.error('Error occurred during the request:', error);
      }

      await this.findOrder(order_id);
      await this.get_time_shipping_order(order_id);
      await this.is_can_review(order_id);

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


      window.appbar_fixed();
      this.loading = false;
   },

}).mount('#app');

</script>