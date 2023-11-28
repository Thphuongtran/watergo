<?php 

   $text_surchage_policy = 'The invoice only reflects the subtotal amount for the products. The store may additionally charge delivery fees or bottle deposit fees.';
   if( get_locale() == 'vi'){
      $text_surchage_policy = 'Hoá đơn chỉ thể hiện tổng tiền tạm tính trên sản phẩm. Cửa hàng có thể sẽ phụ thu thêm phí giao hàng hoặc phí cọc bình.';
   }else if( get_locale() == 'ko_KR' ){

   }

?>
<link defer rel="stylesheet" href="<?php echo THEME_URI . '/assets/js/jquery_ui_1.13.2.min.css'; ?>">
<script defer src="<?php echo THEME_URI . '/assets/js/jquery_ui_1.13.2.min.js'; ?>"></script>
<style>
   .ui-date-picker-wrapper.active #ui-datepicker-div{display: block;}

   .list-tile.order .list-items .list-items-wrapper{
      flex-flow: row wrap;
   }
   .bg-blue{
      background: #2179FB;
   }
   .box-pricing-term {
      padding: 10px 0;
      color: white;
   }
   .box-pricing-term .tt01 {
      font-size: 14px;
      font-weight: 500;
      margin-bottom: 10px;
      line-height: 16px;
   }
   .box-pricing-term .tt02 {
      font-size: 14px;
      font-weight: 500;
      color: white;
      display: inline-flex;
      flex-flow: row wrap;
      align-items: center;
   }
   .box-pricing-term .tt02 .text {
      margin-right: 6px;
   }
   .box-pricing-term .btn-goto-pricing-term {
      display: inline-flex;
      flex-flow: row wrap;
      align-items: center;
   }
   .box-pricing-term .btn-goto-pricing-term .icon {
      height: 16px;
   }
   .box-pricing-term .btn-goto-pricing-term button {
      color: white;
      background: none;
      outline: none;
      border: none;
      font-size: 12px;
      font-weight: 300;
      text-decoration: underline;
   }
   .banner .text-order-success-heading{
      font-size: 20px;
      font-weight: 700;
      text-align: center;
      padding: 0 16px;
   }

   .banner .text-order-success-second{
      font-size: 14px;
      font-weight: 500;
      padding: 0 16px;
      margin-bottom: 15px;
   }

   .banner .banner-head{
      height: auto;
   }


   /* .product-detail-bottomsheet.cell-placeorder button, 
   .product-detail-bottomsheet.cell-re-order button{
      width: 50%;
   }
   .product-detail-bottomsheet{
      justify-content: flex-end;
   } */

   .scaffold{
      height: calc( 100vh - 112px);
      overflow-y: scroll;
      overflow-x: hidden;
      padding-bottom: 40px;
   }

</style>
<div id='app'>

   <div v-show='loading == false' class='page-product-order'>
      
      <div class='appbar style01 fixed'>
         <div class='appbar-top'>
            <div class='leading'>
               <button @click='goBack' class='btn-action'>
                  <svg width="20" height="16" viewBox="0 0 20 16" fill="none" xmlns="http://www.w3.org/2000/svg">
                  <path fill-rule="evenodd" clip-rule="evenodd" d="M0 8C0 7.44772 0.447715 7 1 7H18.5C19.0523 7 19.5 7.44772 19.5 8C19.5 8.55228 19.0523 9 18.5 9H1C0.447715 9 0 8.55228 0 8Z" fill="#252831"/>
                  <path fill-rule="evenodd" clip-rule="evenodd" d="M10.5309 0.375342C10.8759 0.806604 10.806 1.4359 10.3747 1.78091L2.60078 8.00004L10.3747 14.2192C10.806 14.5642 10.8759 15.1935 10.5309 15.6247C10.1859 16.056 9.55657 16.1259 9.12531 15.7809L0.375305 8.78091C0.13809 8.59113 0 8.30382 0 8.00004C0 7.69625 0.13809 7.40894 0.375305 7.21917L9.12531 0.219168C9.55657 -0.125842 10.1859 -0.0559202 10.5309 0.375342Z" fill="#252831"/>
                  </svg>
               </button>
               <p class='leading-title'><?php echo __('Order', 'watergo'); ?></p>
            </div>
         </div>
         <div class='break-line'></div>
      </div>

      <div class='scaffold'>
      
         <div class='inner'>
            <div id='delivery_address_primary' @click='gotoDeliveryAddress' class='list-tile delivery-address' :class='delivery_address_primary != null ? "has-primary" : ""' >
               <div class='content'>
                  <p class='tt01'><?php echo __('Delivery address', 'watergo'); ?></p>
                  <p v-if='delivery_address_primary == null' class='tt02'><?php echo __('There is no address', 'watergo'); ?></p>
                  <p class='tt03' v-if='delivery_address_primary != null'>{{ delivery_address_primary.address }}</p>
                  <p class='tt02' v-if='delivery_address_primary != null'>{{ delivery_address_primary.name }} {{ hasMoreThanTwoZeroes(delivery_address_primary.phone) == true ? ' | (+84) ' + removeZeroLeading( delivery_address_primary.phone ) : "" }}</p>
               </div>            
               <div class='action'>
                  <div class='btn-action'>
                     <svg width="8" height="14" viewBox="0 0 8 14" fill="none" xmlns="http://www.w3.org/2000/svg">
                     <path d="M1 13L7 7L1 1" stroke="#7B7D83" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                     </svg>
                  </div>
               </div>
            </div>
         </div>

         <div class='break-line'></div> 

         <div @click='goto_pricing_term' class='inner bg-blue'>
            <div class='box-pricing-term'>
               <div class='tt01'><?php echo $text_surchage_policy; ?></div>
               <div class='tt02'>
                  <span class='text'><?php echo __('Click here to view', 'watergo'); ?></span>
                  <span class='btn-goto-pricing-term'>
                     <span class='icon'>
                        <svg width="16" height="16" viewBox="0 0 16 16" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M7.99967 10.8199C8.09434 10.8199 8.17367 10.7881 8.23767 10.7246C8.30123 10.6606 8.33301 10.5815 8.33301 10.4872V7.38458C8.33301 7.28991 8.30101 7.2108 8.23701 7.14724C8.17301 7.08324 8.09367 7.05124 7.99901 7.05124C7.90434 7.05124 7.82523 7.08324 7.76167 7.14724C7.69812 7.2108 7.66634 7.28991 7.66634 7.38458V10.4872C7.66634 10.5815 7.69834 10.6606 7.76234 10.7246C7.82634 10.7886 7.90567 10.8206 8.00034 10.8206L7.99967 10.8199ZM7.99967 5.99991C8.11612 5.99991 8.21345 5.96058 8.29167 5.88191C8.37034 5.80324 8.40967 5.70591 8.40967 5.58991C8.40967 5.47347 8.37034 5.37591 8.29167 5.29724C8.21345 5.21858 8.11612 5.17924 7.99967 5.17924C7.88323 5.17924 7.7859 5.21858 7.70767 5.29724C7.62901 5.37591 7.58967 5.47347 7.58967 5.58991C7.58967 5.70591 7.62901 5.80324 7.70767 5.88191C7.7859 5.96058 7.88323 5.99991 7.99967 5.99991ZM7.99967 13.8946C7.93879 13.8946 7.87501 13.889 7.80834 13.8779C7.74167 13.8668 7.67945 13.8501 7.62167 13.8279C6.30923 13.3279 5.26634 12.4799 4.49301 11.2839C3.71967 10.0879 3.33301 8.79324 3.33301 7.39991V4.54458C3.33301 4.31613 3.39812 4.11036 3.52834 3.92724C3.65856 3.74413 3.82679 3.61147 4.03301 3.52924L7.62301 2.19591C7.75279 2.1488 7.87834 2.12524 7.99967 2.12524C8.12101 2.12524 8.24656 2.1488 8.37634 2.19591L11.9663 3.52924C12.1726 3.61147 12.3408 3.74413 12.471 3.92724C12.6012 4.11036 12.6663 4.31613 12.6663 4.54458V7.39991C12.6663 8.79324 12.2797 10.0879 11.5063 11.2839C10.733 12.4799 9.69034 13.3279 8.37834 13.8279C8.32012 13.8501 8.25767 13.8668 8.19101 13.8779C8.12434 13.889 8.06056 13.8946 7.99967 13.8946ZM7.99967 13.2666C9.15523 12.8999 10.1108 12.1666 10.8663 11.0666C11.6219 9.96658 11.9997 8.74436 11.9997 7.39991V4.53191C11.9997 4.44658 11.9761 4.36969 11.929 4.30124C11.8819 4.2328 11.8157 4.18169 11.7303 4.14791L8.14101 2.81458C8.0979 2.7968 8.05079 2.78791 7.99967 2.78791C7.94856 2.78791 7.90145 2.7968 7.85834 2.81458L4.26901 4.14791C4.18367 4.18169 4.11745 4.2328 4.07034 4.30124C4.02323 4.36969 3.99967 4.44658 3.99967 4.53191V7.39991C3.99967 8.74436 4.37745 9.96658 5.13301 11.0666C5.88856 12.1666 6.84412 12.8999 7.99967 13.2666Z" fill="white"/>
                        </svg>
                     </span>
                     <button><?php echo __('View Surcharge Policy', 'watergo'); ?></button>
                  </span>
               </div>
            </div>
         </div>

         <ul v-if='carts.length > 0' class='list-tile order'>
            <li  
               v-for='(store, index) in carts' :key='index'
               >
               <div @click='gotoStoreDetail(store.store_id)' class='shop-detail add-arrow'>
                  <div class='logo'>
                     <svg width="21" height="17" viewBox="0 0 21 17" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <rect x="2.5" y="6.5" width="16" height="10" rx="1.5" fill="white" stroke="black"/>
                        <path d="M20.096 4.43083L20.0959 4.4307L17.8831 0.787088L17.8826 0.786241C17.7733 0.605479 17.5825 0.5 17.3865 0.5H3.61215C3.41614 0.5 3.22534 0.605479 3.11605 0.786241L3.11554 0.787088L0.902826 4.43061C0.902809 4.43064 0.902792 4.43067 0.902775 4.4307C0.0376853 5.85593 0.639918 7.73588 1.97289 8.31233C2.15024 8.38903 2.34253 8.44415 2.54922 8.47313C2.67926 8.49098 2.81302 8.5 2.9473 8.5C3.80016 8.5 4.5594 8.1146 5.08594 7.50809L5.46351 7.07318L5.84107 7.50809C6.36742 8.11438 7.12999 8.5 7.97971 8.5C8.83258 8.5 9.59181 8.1146 10.1184 7.50809L10.4959 7.07318L10.8735 7.50809C11.3998 8.11438 12.1624 8.5 13.0121 8.5C13.865 8.5 14.6242 8.1146 15.1508 7.50809L15.5273 7.07438L15.905 7.50705C16.4357 8.11494 17.1956 8.5 18.0445 8.5C18.1822 8.5 18.3128 8.49098 18.4433 8.47304L20.096 4.43083ZM20.096 4.43083C21.0907 6.06765 20.1619 8.23575 18.4435 8.47301L20.096 4.43083Z" fill="white" stroke="black"/>
                     </svg>
                  </div>
                  <span class='shop-name'>{{ store.store_name }}</span>
               </div>

               <div v-for="(product, productKey) in store.products" :key="productKey" class='list-items'>
                  <div class="list-items-wrapper">
                     <span class='quantity'>{{ product.product_quantity_count }}x</span>
                     <div class='order-gr'>
                        <span class='product-title'>{{ product.name }}</span>
                        <span class='product-subtitle'>{{ product.name_second }}</span>
                        <span v-show='has_gift(product) == true' class='product-subtitle product-gift' >{{ product.gift_text }}</span>
                     </div>
                     <div class='order-price'>
                        <span class='price' >
                           {{ common_price_after_discount_and_quantity(product) }}
                        </span>
                        <span v-show='has_discount(product) == true' class='od-price-discount'>
                           {{ common_price_after_quantity(product) }}
                        </span>
                     </div>
                  </div>
               </div>
            </li>
         </ul>
         
         <div class='select_delivery_time'>
            <p class='heading-02'><?php echo __('Select delivery time', 'watergo'); ?></p>
            <!-- once -->
            <div class='group-tile'>
               <div class='form-check'>
                  <input @click='select_delivery_type("once")' :checked='delivery_type.once' id='select_type01' type="radio" class='form-input'>
                  <label for='select_type01' ><?php 
                     if( get_locale() == 'vi' ){
                        echo 'Giao thường';
                     }else{
                        echo __('Delivery once', 'watergo'); 
                     }
                  ?></label>
               </div>

               <div v-show='delivery_type.once' class='group-time-delivery-once'>
                  <div class='form-group-select'>
                     <div class='form-check'>
                        <input id='select_delivery_time_Immediately' type='checkbox' @click='select_delivery_once_type("once_immediately")' :checked='delivery_type.once_immediately' :disabled='delivery_type.once_immediately'>
                        <label for='select_delivery_time_Immediately'><?php echo __('Immediately (within 2 hour)', 'watergo'); ?></label>
                     </div>
                     <div class='form-check'>
                        <input id='select_delivery_time_Date-Time' type='checkbox' @click='select_delivery_once_type("once_date_time")' :checked='delivery_type.once_date_time' :disabled='delivery_type.once_date_time'>
                        <label for='select_delivery_time_Date-Time' class='custom-checkbox'><?php echo __('Select Date & Time', 'watergo'); ?></label>
                     </div>
                  </div>
               </div>

               <div v-show='delivery_type.once_date_time == true' class='group-select-delivery-time'>
                  <div class='btn-wrapper-order'>
                     <input @click='select_once_date_time(".select_once_date_time")' type='text' :value='delivery_data.once_date[0].day' class='select_once_date_time btn-dropdown' placeholder='<?php echo __('Select date', 'watergo'); ?>' readonly>
                  </div>
                  <div class='btn-wrapper-order'>
                     <select v-model="delivery_data.once_date[0].time" class="btn_select_time_once btn-dropdown">
                        <option value='' selected disabled><?php echo __('Select time', 'watergo'); ?></option>
                        <option v-for="(hour, indexHour) in get_once_date_time_allow" :key="indexHour" :value="hour.value" :selected='delivery_data.once_date[0].time == hour.time ? true : false'> 
                           {{ hour.label }}
                        </option>
                     </select>
                  </div>
               </div>

            </div>

            <!-- weekly -->
            <div class='group-tile'>
               <div class='form-check'>
                  <input @click='select_delivery_type("weekly")' :checked='delivery_type.weekly' id='select_type02' type="radio" class='form-input'>
                  <label for='select_type02'><?php echo __('Delivery weekly', 'watergo'); ?></label>
               </div>

               <div v-show='delivery_type.weekly == true' class='deliverySelect_weekly'>
                  <div v-for="slot in delivery_data.weekly" :key="slot.id">
                     <div class="group-select-delivery-time group-select-delivery-time_parent">
                        <div class="btn-wrapper-order">
                           <select @change='btn_select_slot_weekly_day($event, slot.day)' v-model="slot.day" class="btn_select_weekly_day btn-dropdown">
                              <option value='' selected disabled><?php echo __('Select date', 'watergo'); ?></option>
                              <option :disabled="isDayDisabled(day_of_week, slot.id)" 
                                 v-for="(day_of_week, indexWeek) in dayOfWeeks" :key="indexWeek" 
                                 :value="day_of_week"
                                 :selected="slot.day == day_of_week ? true : false"
                              >
                                 {{ day_of_week }}
                              </option>
                           </select>
                        </div>
                        <div class="btn-wrapper-order">
                           <select v-model="slot.time" class="btn_select_weekly_time btn-dropdown">
                              <option value='' selected disabled><?php echo __('Select time', 'watergo'); ?></option>
                              <option v-for="(hour, indexHour) in total_hour" :key="indexHour" :value="hour.value" :selected='slot.time == hour.time ? true : false'> 
                                 {{ hour.label }}
                              </option>
                           </select>
                        </div>
                     </div>
                  </div>
               </div>

               <button v-show='delivery_type.weekly' @click='btn_add_dom_delivery_weekly' class='button_add_delivery button_add_dom_delivery_weekly' :style='{ opacity: delivery_data.weekly.length == 7 ? "0.5" : "1.0" }'><?php echo __('Add Day', 'watergo'); ?></button>
            </div>

            <!-- monthly -->
            <div class='group-tile'>
               <div class='form-check'>
                  <input @click='select_delivery_type("monthly")' :checked='delivery_type.monthly' id='select_type03' type="radio" class='form-input'>
                  <label for='select_type03'><?php echo __('Delivery monthly', 'watergo'); ?></label>
               </div>

               <div v-show='delivery_type.monthly == true' class='deliverySelect_monthly'>

                  <div v-for="slot in delivery_data.monthly" :key="slot.id">
                     <div class='group-select-delivery-time'>
                        <div class='btn-wrapper-order'>
                           <input @click='select_monthly_time(slot.id, true)' type='text' :value='slot.day'
                              class='btn_select_monthly_primary btn_select_monthly btn-dropdown' 
                              :class='"btn_select_monthly_slot_" + slot.id'
                              placeholder='<?php echo __('Select date', 'watergo'); ?>' readonly>
                        </div>
                        <div class='btn-wrapper-order'>
                           <select v-model="slot.time" class="btn_select_monthly_time btn-dropdown">
                              <option value='' selected disabled><?php echo __('Select time', 'watergo'); ?></option>
                              <option v-for="(hour, indexHour) in total_hour" :key="indexHour" :value="hour.value" :selected='slot.time == hour.time ? true : false'> 
                                 {{ hour.label }}
                              </option>
                           </select>
                        </div>
                     </div>
                  </div>

               </div>

               <button v-show='delivery_type.monthly' @click='btn_add_dom_delivery_monthly' class='button_add_delivery button_add_dom_delivery_monthly' :style='{ opacity: delivery_data.monthly.length == 7 ? "0.5" : "1.0" }'><?php echo __('Add Date', 'watergo'); ?></button>
            </div>
            
         </div>

         <div class='break-line'></div>

         <div class='inner'>
            <div class='box-textarea'>
               <textarea @input='resize_input_order_note' ref='resize_input_order_note' class='input_order_note' v-model='input_order_note' maxlength='120' placeholder='<?php echo __('Note your shipping address', 'watergo'); ?>'></textarea>
               <span class='count-text'>{{ input_order_note.length }}/120</span>
            </div>
         </div>

         <div class='inner'>
            <div class='box-payment'>
               <p class='heading-02'><?php echo __('Payment method', 'watergo'); ?> </p><p class='tt1'><?php echo __('By Cash', 'watergo'); ?></p>
            </div>
         </div>
         <!-- <div class='box-price'>
            <span class='tt1'><?php echo __('Total', 'watergo'); ?>:</span> <span class='tt2'>{{ count_product_total_price.price_discount }} </span>
         </div> -->
      </div>


      <div class='product-detail-bottomsheet cell-placeorder'>
         <p class='price-total'><?php echo __('Total', 'watergo'); ?>: <span class='t-primary t-bold'>{{ count_product_total_price.price_discount }} </span></p>
         <button id='buttonPlaceOrder' @click='buttonPlaceOrder' class='btn-primary btn-order' :class='canPlaceOrder == false ? "disable" : "" '><?php echo __('Place Order', 'watergo'); ?></button>
      </div>

   </div>

   <div v-if='modal_store_out_of_stock == true' class='modal-popup' :class='modal_store_out_of_stock == true && canPlaceOrder == false ? "open" : ""'>
      <div class='modal-wrapper'>
         <div class='modal-close'><div @click='buttonCloseModal_store_out_of_stock' class='close-button'><span></span><span></span></div></div>
         <p class='heading'><?php echo __("This Product is <span class='t-primary'>Out of Stock</span>", 'watergo'); ?></p>
      </div>
   </div>

   <div v-show="loading == true">
      <div class='progress-center'>
         <div class='progress-container enabled'><progress class='progress-circular enabled'></progress></div>
      </div>
   </div>

   <div v-show='banner_open == true' class='banner disable' :class='banner_open == true ? "banner-open z-index-5" : "" '>
      <div class='banner-head'>
         <svg width="64" height="64" viewBox="0 0 64 64" fill="none" xmlns="http://www.w3.org/2000/svg">
         <circle cx="32" cy="32" r="32" fill="#2790F9"/>
         <path fill-rule="evenodd" clip-rule="evenodd" d="M44.7917 24.8288L42.103 22.1401L27.8578 36.3854L22.2522 30.7798L19.5635 33.4685L27.9506 41.8557L30.6393 39.167L30.5465 39.0741L44.7917 24.8288Z" fill="white"/>
         </svg>
         <p class='text-order-success-heading'><?php echo __('Order Successfully<br>Please wait for the store to confirm.', 'watergo'); ?></p>
         <p class='text-order-success-second'><?php echo __('The order will be automatically canceled after 60 minutes if the store does not confirm.', 'watergo'); ?></p>
      </div>
      <div class='banner-footer'>
         <button @click='goBackRefresh' class='btn btn-outline'><?php echo __('Exit', 'watergo'); ?></button>
      </div>
   </div>


</div>

<script type='module'>

var app = Vue.createApp({

   data(){
      return {

         get_locale: '<?php echo get_locale(); ?>',

         loading:       true,
         banner_open:   false,

         input_order_note: '',

         delivery_type: {
            once:             false,
            once_immediately: false,
            once_date_time:   false,
            weekly:           false,
            monthly:          false,
         },

         once_date_time_allow: [],

         delivery_data: {
            once_date:  [{ day: '', time: '' }],
            weekly:     [],
            monthly:    [],
         },

         dayOfWeeks: [  'Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday', 'Sunday' ],
         total_hour: [
            {hour: 7,  value: '7:00-8:00',   label: '7:00  -  8:00' },
            {hour: 8,  value: '8:00-9:00',   label: '8:00  -  9:00' },
            {hour: 9,  value: '9:00-10:00',  label: '9:00 -   10:00'},
            {hour: 10, value: '10:00-11:00', label: '10:00  -  11:00'},
            {hour: 11, value: '11:00-12:00', label: '11:00  -  12:00'},
            {hour: 12, value: '12:00-13:00', label: '12:00  -  13:00'},
            {hour: 13, value: '13:00-14:00', label: '13:00  -  14:00'},
            {hour: 14, value: '14:00-15:00', label: '14:00  -  15:00'},
            {hour: 15, value: '15:00-16:00', label: '15:00  -  16:00'},
            {hour: 16, value: '16:00-17:00', label: '16:00  -  17:00'},
            {hour: 17, value: '17:00-18:00', label: '17:00  -  18:00'},
            {hour: 18, value: '18:00-19:00', label: '18:00  -  19:00'},
            {hour: 19, value: '19:00-20:00', label: '19:00  -  20:00'},
            {hour: 20, value: '20:00-21:00', label: '20:00  -  21:00'},
         ],

         delivery_address_primary: null,
         carts: [],

         // FOR RE-ORDER
         time_shipping: [],

         // modal out of stock
         modal_store_out_of_stock: false,
         canPlaceOrder: false,
         dateWeekAuto: [],

      }
   },

   watch: {
      delivery_type: {
         handler( data ){
            this.canPlaceOrder = false;
            var current_selected = '';
            for (let prop in this.delivery_type) {
               if( this.delivery_type[prop] == true ) {
                  current_selected = prop;
                  break;
               }
            }
            // RESET DATA WHEN DOESNT NEEDED
            if( current_selected == 'once'){
               this.create_init_once_data();
               if( this.delivery_type.once_immediately == true){
                  this.canPlaceOrder = true;
               }else{
                  this.canPlaceOrder = false;
               }
            }else if( current_selected == 'weekly'){
               this.create_init_weekly_data();
            }else if( current_selected == 'monthly'){
               this.create_init_monthly_data();
            }
         }, deep: true
      },

      delivery_data: {
         handler( data){
            if( this.delivery_address_primary != null ){

               if( this.delivery_type.once_date_time == true ){
                  if( data.once_date[0].day != '' && data.once_date[0].time != '' ){
                     this.canPlaceOrder = true;
                  }else{
                     this.canPlaceOrder = false;
                  }
               }
               if( this.delivery_type.weekly == true ){

                  for( let i = 0; i < data.weekly.length; i++ ){
                     if( 
                        ( data.weekly[i].day !== '' && data.weekly.day !== '' ) &&
                        ( data.weekly[i].time !== '' && data.weekly.time !== '' )
                     ){
                        this.canPlaceOrder = true;
                     }else{
                        this.canPlaceOrder = false;
                        break;
                     }
                  }

               } 
               if( this.delivery_type.monthly == true ){
                  for( let i = 0; i < data.monthly.length; i++ ){
                     if( 
                        ( data.monthly[i].day !== '' && data.monthly.day !== '' ) &&
                        ( data.monthly[i].time !== '' && data.monthly.time !== '' )
                     ){
                        this.canPlaceOrder = true;
                     }else{
                        this.canPlaceOrder = false;
                        break;
                     }
                  }
               }

            }else{
               this.canPlaceOrder = false;
            }
         }, deep: true
      },
   },

   
   computed: {

      count_product_total_price(){
         var gr_price = { price: 0, price_discount: 0 };

         this.carts.forEach( store => {

            store.products.forEach( product => {

               var currentDate = new Date();
               var discount_from = new Date(product.discount_from);
               var discount_to   = new Date(product.discount_to);
               currentDate.setHours(0,0,0,0);
               discount_from.setHours(0,0,0,0);
               discount_to.setHours(0,0,0,0);
               currentDate    = parseInt(currentDate.getTime() / 1000);
               discount_from  = parseInt(discount_from.getTime() / 1000);
               discount_to    = parseInt(discount_to.getTime() / 1000);

               if( product.has_discount == 1 && ( currentDate >= discount_from && currentDate <= discount_to ) ){
                  gr_price.price_discount += ( product.price - ( product.price * ( product.discount_percent / 100)) ) * product.product_quantity_count;
               }else{
                  product.has_discount = 0;
                  gr_price.price_discount += product.price * product.product_quantity_count;
               }

               gr_price.price += product.price * product.product_quantity_count;
            });

         });
         
         var _final_price = null;

         if( gr_price.price != gr_price.price_discount){
            _final_price = gr_price.price.toLocaleString('vi-VN') + ' đ'
         }

         return {
            price: _final_price,
            price_discount: gr_price.price_discount.toLocaleString('vi-VN') + ' đ'
         };
      },

      // JUST AUTO UPDATE {time} WHEN SELECT DATE ONCE -> pick date
      get_once_date_time_allow(){ return this.once_date_time_allow }
   },

   methods: { 

      has_gift( p){ return window.has_gift(p); },

      resize_input_order_note(){
         const maxHeight = 40;
         const textarea = this.$refs.resize_input_order_note;
         var scrollHeight = textarea.scrollHeight;
         if (scrollHeight > maxHeight) {
            textarea.style.height = 'auto';
            textarea.style.height = textarea.scrollHeight + 'px';
         }
      },


      goto_pricing_term(){
         window.location.href = '/user/?user_page=user-pricing-term&appt=N';
      },

      async buttonPlaceOrder(){
         var _currentDate = new Date();
         var _watergo_carts = JSON.parse(localStorage.getItem('watergo_carts'));
         
         if( this.canPlaceOrder == true && this.delivery_address_primary != null  ){


            this.loading = true;
            var delivery_data = [];
            var delivery_type = '';

            if( this.delivery_type.once_date_time == true ){
               delivery_type = 'once_date_time';
               delivery_data = this.delivery_data.once_date;
            }

            if( this.delivery_type.once_immediately == true ){
               delivery_type = 'once_immediately';
            }
            
            if( this.delivery_type.weekly == true ){
               delivery_type = 'weekly';
               delivery_data = this.delivery_data.weekly;
            }
            
            if( this.delivery_type.monthly == true ){
               delivery_type = 'monthly';
               delivery_data = this.delivery_data.monthly;
            }

            var form = new FormData();
            form.append('action',            'atlantis_add_order');
            form.append('delivery_data',     JSON.stringify( delivery_data ) );
            form.append('delivery_address',  JSON.stringify(this.delivery_address_primary) );
            form.append('delivery_type',     delivery_type );
            form.append('productSelected',   JSON.stringify( this.carts ) );
            form.append('input_order_note',  this.input_order_note  );
            
            var r = await window.request(form);

            if( r != undefined ){
               var res = JSON.parse(JSON.stringify(r));
               if( res.message == 'insert_order_ok' ){
                  for (let i = this.carts.length - 1; i >= 0; i--) {
                     var _carts = this.carts[i];
                     for (let j = _carts.products.length - 1; j >= 0; j--) {
                        var _product = _carts.products[j];
                        if ( _product.product_select == true ) {
                           _carts.products.splice(j, 1);
                        }
                     }
                     // remove store when no product in cart
                     if (_carts.products.length === 0) { this.carts.splice(i, 1); }
                  }
                  localStorage.setItem('watergo_carts', JSON.stringify(this.carts));
                  // 

                  // SEND NOTIFCATION IN BACKGROUND
                  // try {
                  //    var form_background_notification = new FormData();
                  //    form_background_notification.append('action', 'atlantis_protocal_notification_in_background');
                  //    form_background_notification.append('send_to', 'store');
                  //    form_background_notification.append('order_status', res.notification_args.order_status);
                  //    form_background_notification.append('order_id', res.notification_args.order_id);
                  //    form_background_notification.append('user_id', res.notification_args.user_id);
                  //    form_background_notification.append('store_id', res.notification_args.store_id);
                  //    form_background_notification.append('attachment_url', res.notification_args.attachment_url);
                  //    form_background_notification.append('order_number', res.notification_args.order_number);
                  //    form_background_notification.append('hash', res.notification_args.hash);
                  //    const requestPromise = window.request(form_background_notification);
                  //    const immediatePromise = new Promise(resolve => resolve());
                  //    // Use Promise.race to determine which promise resolves first
                  //    await Promise.race([requestPromise, immediatePromise]);
                  // } catch (error) {}

                  this.loading = false;
                  this.banner_open = true;
               }else{
                  this.loading = false;
               }
            }
            this.loading = false;
         }else{
            this.canPlaceOrder = false;
         }
      },

      select_monthly_time( slot_id, isOpen = false ){

         let instanceApp = this;

         if( isOpen == true){
            jQuery('.ui-datepicker .ui-datepicker-title').empty();
            jQuery('.ui-date-picker-wrapper').addClass('active');
            jQuery('.ui-date-picker-wrapper').addClass('datepicker-monthly');
            jQuery('.ui-datepicker .ui-datepicker-title').html('<?php echo __("Everymonth", 'watergo'); ?>');
            jQuery('.ui-datepicker-calendar thead').remove();
            jQuery('.ui-widget-header a').remove();
         }
         
         jQuery(document).ready(function($) {
            jQuery('.btn_select_monthly_slot_' + slot_id).datepicker({
               dateFormat: "dd",
               changeMonth: false,
               changeYear: false,
               stepMonths: 0,
               showButtonPanel: false,
               maxDate: new Date(new Date().getFullYear(), new Date().getMonth(), 28),
               autoOpen: isOpen,
               
               beforeShow: function(dateText, inst){
                  if( jQuery('.ui-date-picker-wrapper').length == 0 ){
                     inst.dpDiv.wrap($("<div class='ui-date-picker-wrapper'></div>"));
                  }
               },
               
               beforeShowDay: function( date ) {

                  jQuery('.ui-datepicker .ui-datepicker-title').empty();
                  jQuery('.ui-widget-header a').remove();
                  jQuery('.ui-datepicker-calendar thead').remove();

                  var disabledDays = [];
                  if( instanceApp.delivery_data.monthly.length > 0  ) {
                     instanceApp.delivery_data.monthly.forEach( m => {
                        disabledDays.push(m.datetimeDisable);
                     });
                  }
                  var string     = jQuery.datepicker.formatDate('dd/mm/yy', date);
                  var isDisabled = ($.inArray( string, disabledDays) != -1);
                  var isMaxDate  = date < new Date(new Date().getFullYear(), new Date().getMonth(), 29);
                  var extraClass = isMaxDate ? "datepicker-month-selected" : "datepicker-month-disabled";
                  //day != 0 disables all Sundays
                  return [ date && !isDisabled, extraClass ];
                  return date;
               },

               onSelect: function(dateText, inst){
                  if(dateText != undefined || dateText != '' || dateText != null){

                     let currentDate = new Date();
                     let year = currentDate.getFullYear();
                     let month = String(currentDate.getMonth() + 1).padStart(2, '0');
                     let day = String(dateText).padStart(2, '0');
                     let fulldate = `${day}/${month}/${year}`;

                     instanceApp.delivery_data.monthly[slot_id].day = dateText;
                     instanceApp.delivery_data.monthly[slot_id].datetime = window.compare_day_with_currentDate(dateText);
                     instanceApp.delivery_data.monthly[slot_id].datetimeDisable = fulldate;
                  }
               },
               onClose: function(dateText, inst){
                  jQuery('.ui-date-picker-wrapper').removeClass('active');
                  jQuery('.ui-date-picker-wrapper').removeClass('datepicker-monthly');
               }
            });
         });

      },

      select_once_date_time( targetElement ){
         let instanceApp = this;

         jQuery(document).ready(function($){

            var translate_datepicker = window.get_translate_datepicker();

            var locale = 'en_US'; // Default to English
            var get_locale = '<?php echo get_locale(); ?>';

            if ( get_locale != undefined && translate_datepicker[get_locale] != undefined) {
               locale = get_locale;
            }

            $(targetElement).datepicker({
               dateFormat: "dd/mm/yy",
               minDate: 0,
               firstDay: 1,
               monthNames:       translate_datepicker[locale].monthNames,
               monthNamesShort:  translate_datepicker[locale].monthNamesShort,
               dayNames:         translate_datepicker[locale].dayNames,
               dayNamesShort:    translate_datepicker[locale].dayNamesShort,
               dayNamesMin:      translate_datepicker[locale].dayNamesMin,
               beforeShow: function(dateText, inst){
                  if( $('.ui-date-picker-wrapper').length == 0 ){
                     inst.dpDiv.wrap($("<div class='ui-date-picker-wrapper'></div>"));
                  }
                  $('.ui-date-picker-wrapper').addClass('active');
                  $('.ui-date-picker-wrapper').addClass('datepicker-order-product');
               },
               onSelect: function(dateText, inst){
                  
                  if(dateText != undefined || dateText != '' || dateText != null){
                     var [_day, _month, _year] = dateText.split('/');
                     var convertToDateEn = _month + '/' + _day + '/' + _year;
                     instanceApp.delivery_data.once_date[0].day = convertToDateEn;

                     // var _currentSelectDate = new Date( convertToDateEn );
                     var selectedDate = new Date(convertToDateEn);
                     var _currentDate = new Date();
                     const day = _currentDate.getDate().toString().padStart(2, '0');
                     const month = (_currentDate.getMonth() + 1).toString().padStart(2, '0');
                     const year = _currentDate.getFullYear().toString();
                     const hours = _currentDate.getHours().toString().padStart(2, '0');
                     const minutes = _currentDate.getMinutes().toString().padStart(2, '0');
                     const formattedDate = `${day}-${month}-${year} ${hours}:${minutes}`;

                      // Check if the selected date is the current day
                     if (
                        selectedDate.getDate() === _currentDate.getDate() &&
                        selectedDate.getMonth() === _currentDate.getMonth() &&
                        selectedDate.getFullYear() === _currentDate.getFullYear()
                     ) {
                        selectedDate.setHours(0, 0, 0, 0);
                        _currentDate.setHours(0, 0, 0, 0);
                        var getHourSelected = parseInt( hours ) + 2;
                        if(selectedDate.getTime() === _currentDate.getTime() ){
                           instanceApp.once_date_time_allow = instanceApp.total_hour.filter( item => item.hour >= getHourSelected );
                        }
                     } else {
                        instanceApp.once_date_time_allow = instanceApp.total_hour;
                     }

                  }
               },
               onClose: function(dateText, inst){
                  $('.ui-date-picker-wrapper').removeClass('active');
                  $('.ui-date-picker-wrapper').removeClass('datepicker-order-product');
               }

            });


         });

      },


      create_init_once_data(){
         this.delivery_data.once_date.push({ day: '', time: '' });
      },
      
      /**
       * @access WEEKLY CONSTRUCTION
       */
      isDayDisabled(selectedDay, slotIndex) {
         return this.delivery_data.weekly.some((slot, index) => index !== slotIndex && slot.day === selectedDay);
      },
      btn_add_dom_delivery_weekly(){
         if( this.delivery_data.weekly.length < 7){
            this.delivery_data.weekly.push({ id: this.delivery_data.weekly.length, day: '', time: '', datetime: '', });
         }
      },
      btn_select_slot_weekly_day(e, day_of_week){
         var _find = this.dateWeekAuto.find( item => item.dayOfWeek == day_of_week );
         this.delivery_data.weekly.forEach( ( item, indexSlot ) => {
            if( item.day == day_of_week ) {
               item.datetime = _find.date;
            }
         });
      },
      create_init_weekly_data(){
         this.delivery_data.weekly = [];
         this.delivery_data.weekly.push({ id: 0, day: '', time: '', datetime: '' });
         
         // this.delivery_type.once             = false;
         // this.delivery_type.once_immediately = false;
         // this.delivery_type.once_date_time   = false;
         // this.delivery_type.monthly          = false;

      },


      /**
       * @access MONTHLY CONSTRUCTION
       */
      

      create_init_monthly_data(){
         this.delivery_data.monthly = [];
         this.delivery_data.monthly.push({ id: 0, day: '', time: '', datetime: '', });
         this.select_monthly_time(0, false);
      },
      btn_add_dom_delivery_monthly(){
         if( this.delivery_data.monthly.length < 7){
            this.delivery_data.monthly.push({ id: this.delivery_data.monthly.length, day: '', time: '', datetime: '', });
            this.select_monthly_time(this.delivery_data.monthly.length - 1, false);
         }
      },


      automatic_count_date_week(){
         function formatDate(date) {
            const day = String(date.getDate()).padStart(2, '0');
            const month = String(date.getMonth() + 1).padStart(2, '0');
            const year = date.getFullYear();
            return `${day}/${month}/${year}`;
         }
         function getDayOfWeek(date) {
            const daysOfWeek = ['Sunday', 'Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday'];
            return daysOfWeek[date.getDay()];
         }
         function getNextDay(date) {
            const nextDate = new Date(date);
            nextDate.setDate(date.getDate() + 1);
            return nextDate;
         }
         var today = new Date();
         for (let i = 0; i < 7; i++) {
            var currentDate = getNextDay(today);
            // const currentDate = new Date(today);
            currentDate.setDate(today.getDate() + i);
            var isToday = i === 0; // Check if it's the first iteration (today)
            this.dateWeekAuto.push({
               dayOfWeek : getDayOfWeek(currentDate),
               date      : formatDate(currentDate),
               isToday   : isToday,
               isSelect  : false,
            });
            today.setDate(today.getDate()); // Move to the next day
         }
      },

      select_delivery_type(type){
         if( this.delivery_type[type] == false ){
            for ( let prop in this.delivery_type) {
               if( prop == type) {
                  this.delivery_type[prop] = true;
                  if( type == "once"){this.delivery_type.once_immediately = true; }
               }else{
                  this.delivery_type[prop] = false;
                  if( type == "once"){this.delivery_type.once_immediately = true; }
               }
            }
         }
      },

      select_delivery_once_type(type){
         if( type == "once_immediately"){
            this.delivery_type.once_immediately = true;
            this.delivery_type.once_date_time = false;
         }else if( type == "once_date_time"){
            this.delivery_type.once_immediately = false;
            this.delivery_type.once_date_time = true;
         }
      },

      hasMoreThanTwoZeroes(number) { return window.hasMoreThanTwoZeroes(number) },
      removeZeroLeading(number) { return window.removeZeroLeading(number) },

      buttonCloseModal_store_out_of_stock(){ this.modal_store_out_of_stock = false },
      gotoDeliveryAddress(){ window.gotoDeliveryAddress(true)},

      has_discount( product ){ return window.has_discount( product ); },
      common_price_after_discount_and_quantity(p){ return window.common_price_after_discount_and_quantity(p)},
      
      common_price_after_quantity(p){ return window.common_price_after_quantity(p)},

      goBack(){ 
         localStorage.setItem( 'watergo_order_delivery_address', '[]' );
         window.reset_cart_to_select_false();
         window.goBack();
      },

      // BACK HOME WHEN ORDER SUCCESS
      goBackRefresh(){ 
         localStorage.setItem( 'watergo_order_delivery_address', '[]' );
         window.reset_cart_to_select_false();
         appBridge.navigateTo("Order", "order_refresh");
      },

      async atlantis_get_delivery_address_primary(){
         var form = new FormData();
         form.append('action', 'atlantis_get_delivery_address_primary');
         var r = await window.request(form);
         if( r != undefined ){
            var res = JSON.parse( JSON.stringify(r));
            if(res.message == 'get_delivery_address_ok' ){
               this.delivery_address_primary = {
                  name: res.data.name,
                  phone: res.data.phone,
                  address: res.data.address,
                  latitude: res.data.latitude,
                  longitude: res.data.longitude,
               };
            }
         }
      },

      async initial_delivery_address(){
         var _order_delivery_address   = JSON.parse(localStorage.getItem('watergo_order_delivery_address'));
         if( _order_delivery_address != undefined && _order_delivery_address.length > 0 ){
            this.delivery_address_primary = {
               id:         _order_delivery_address[0].id,
               name:       _order_delivery_address[0].name,
               phone:      _order_delivery_address[0].phone,
               address:    _order_delivery_address[0].address,
               user_id:    _order_delivery_address[0].user_id,
               latitude:   _order_delivery_address[0].latitude,
               longitude:  _order_delivery_address[0].longitude,
            };
         }else{
            await this.atlantis_get_delivery_address_primary();
         }
      }


   },

   update(){
      window.appbar_fixed();
   },

   async created(){

      if( window.appBridge != undefined ){
         window.appBridge.setEnableScroll(false);
      }

      // IF PASS ORDER_ID => this is re-order product
      const urlParams      = new URLSearchParams(window.location.search);
      const re_order_id    = urlParams.get('re_order_id');
      // const order_page     = urlParams.get('order_init');

      // if( order_page != undefined && order_page == 'init_delivery' ){
         await this.initial_delivery_address();
      // }


      // INITIAL order_delivery
     

      // INITIAL carts
      var _carts = JSON.parse(localStorage.getItem('watergo_carts'));
      if( _carts.length > 0 ){

         _carts.forEach( store => {
            if (store.store_select == true ) {
               this.carts.push({ ...store, products: [...store.products.filter( product => product.product_select == true )] });
            } else {
               const selectedProducts = store.products.filter(product => product.product_select == true);
               if (selectedProducts.length > 0) {
                  this.carts.push({
                     store_id: store.store_id,
                     store_name: store.store_name,
                     store_select: false,
                     products: [...selectedProducts],
                  });
               }
            }
         });

         this.carts.forEach( ( store, storeIndex ) => {
            store.products.forEach( async ( product, productIndex ) => {
               var form = new FormData();
               form.append('action', 'atlantis_find_product');
               form.append('product_id', product.product_id);
               var r = await window.request(form);
               if( r != undefined ){
                  var res = JSON.parse( JSON.stringify(r));
                  if( res.message == 'product_found' ){
                     this.carts[storeIndex].products[productIndex].name_second      = res.data.name_second;
                     this.carts[storeIndex].products[productIndex].name             = res.data.name;
                     // DISCOUNT
                     this.carts[storeIndex].products[productIndex].has_discount     = res.data.has_discount;
                     this.carts[storeIndex].products[productIndex].discount_to      = res.data.discount_to;
                     this.carts[storeIndex].products[productIndex].discount_from    = res.data.discount_from;
                     this.carts[storeIndex].products[productIndex].discount_percent = res.data.discount_percent;
                     // GIFT
                     this.carts[storeIndex].products[productIndex].has_gift         = res.data.has_gift;
                     this.carts[storeIndex].products[productIndex].gift_to          = res.data.gift_to;
                     this.carts[storeIndex].products[productIndex].gift_from        = res.data.gift_from;
                     this.carts[storeIndex].products[productIndex].gift_text        = res.data.gift_text;

                     this.carts[storeIndex].products[productIndex].price            = res.data.price;
                     this.carts[storeIndex].products[productIndex].product_type     = res.data.product_type;
                  }
               }
            });
         });
         
      }      

      this.delivery_type.once = true;
      this.delivery_type.once_immediately = true;
      this.automatic_count_date_week();

      if( re_order_id != undefined ){
         this.delivery_type.once = false;
         this.delivery_type.once_immediately = false;
      }

      let instanceApp = this;

      jQuery(document).ready(function($){
         instanceApp.select_once_date_time(".select_once_date_time");
      });

      window.appbar_fixed();

      this.loading = false;



   },
   

})
.mount('#app');

window.app = app;


// window.onerror = function(msg, url, linenumber) {
//     alert('Error message: '+msg+'\nURL: '+url+'\nLine Number: '+linenumber);
//     return true;
// }
</script>

