<div id='app'>

   <div v-if='loading == false && carts.length > 0' class='page-product-order'>
      
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
      
      <div v-if='loading == false && carts.length > 0' class='inner'>
         <div id='delivery_address_primary' @click='gotoDeliveryAddress' class='list-tile delivery-address' :class='delivery_address_primary != null ? "has-primary" : ""' >
            <div class='content'>
               <p class='tt01'><?php echo __('Delivery address', 'watergo'); ?></p>
               <p v-if='delivery_address_primary == null' class='tt02'><?php echo __('There is no address', 'watergo'); ?></p>
               <p class='tt03' v-if='delivery_address_primary != null'>{{ delivery_address_primary.address }}</p>
               <p class='tt02' v-if='delivery_address_primary != null'>{{ delivery_address_primary.name }} {{ hasMoreThanTwoZeroes(delivery_address_primary.phone) == true ? ' | (+84) ' + removeZeroLeading( delivery_address_primary.phone ) : "" }}</p>
            </div>
            <div class='action'>
               <button class='btn-action'>
                  <svg width="8" height="14" viewBox="0 0 8 14" fill="none" xmlns="http://www.w3.org/2000/svg">
                  <path d="M1 13L7 7L1 1" stroke="#7B7D83" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                  </svg>
               </button>
            </div>
         </div>
      </div>

      <div class='break-line'></div> 

      <ul v-if='loading == false && carts.length > 0' class='list-tile order'>
         <li  
            v-for='(store, index) in carts' :key='index'>
            <div @click='gotoStoreDetail(store.store_id)' class='shop-detail add-arrow'>
               <div class='logo'>
                  <svg width="21" height="17" viewBox="0 0 21 17" fill="none" xmlns="http://www.w3.org/2000/svg">
                     <rect x="2.5" y="6.5" width="16" height="10" rx="1.5" fill="white" stroke="black"/>
                     <path d="M20.096 4.43083L20.0959 4.4307L17.8831 0.787088L17.8826 0.786241C17.7733 0.605479 17.5825 0.5 17.3865 0.5H3.61215C3.41614 0.5 3.22534 0.605479 3.11605 0.786241L3.11554 0.787088L0.902826 4.43061C0.902809 4.43064 0.902792 4.43067 0.902775 4.4307C0.0376853 5.85593 0.639918 7.73588 1.97289 8.31233C2.15024 8.38903 2.34253 8.44415 2.54922 8.47313C2.67926 8.49098 2.81302 8.5 2.9473 8.5C3.80016 8.5 4.5594 8.1146 5.08594 7.50809L5.46351 7.07318L5.84107 7.50809C6.36742 8.11438 7.12999 8.5 7.97971 8.5C8.83258 8.5 9.59181 8.1146 10.1184 7.50809L10.4959 7.07318L10.8735 7.50809C11.3998 8.11438 12.1624 8.5 13.0121 8.5C13.865 8.5 14.6242 8.1146 15.1508 7.50809L15.5273 7.07438L15.905 7.50705C16.4357 8.11494 17.1956 8.5 18.0445 8.5C18.1822 8.5 18.3128 8.49098 18.4433 8.47304L20.096 4.43083ZM20.096 4.43083C21.0907 6.06765 20.1619 8.23575 18.4435 8.47301L20.096 4.43083Z" fill="white" stroke="black"/>
                  </svg>
               </div>
               <span class='shop-name' v-if='store.store_name != null'>{{ store.store_name }}</span>
            </div>

            <div
               v-for="(product, productKey) in store.products" :key="productKey" 
               class='list-items'
               v-show='product.name != null'
            >
               <div class="list-items-wrapper">
                  <span class='quantity'>{{ product.product_quantity_count }}x</span>
                  <div class='order-gr'>
                     <span class='product-title'>{{ product.name }}</span>
                     <span class='product-subtitle'>{{ product.name_second }}</span>
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
      
      <div class='select_delivery_time' ref='select_delivery_time'>
         <p class='heading-02'><?php echo __('Select delivery time', 'watergo'); ?></p>

         <div class='group-tile'>
            <div class='form-check'>
               <input @click='btn_select_type("once")' :checked='delivery_type.once' id='select_type01' type="radio" class='form-input'>
               <label for='select_type01' ><?php echo __('Delivery once', 'watergo'); ?></label>
            </div>

            <div v-show='delivery_type.once' class='group-time-delivery-once'>
               <div class='form-group-select'>
                  <div class='form-check'>
                     <input id='select_delivery_time_Immediately' type='checkbox' @click='btn_select_type("once_immediately")' :checked='delivery_type.once_immediately' :disabled='delivery_type.once_immediately'>
                     <label for='select_delivery_time_Immediately'><?php echo __('Immediately (within 1 hour)', 'watergo'); ?></label>
                  </div>
                  <div class='form-check'>
                     <input id='select_delivery_time_Date-Time' type='checkbox' @click='btn_select_type("once_date_time")' :checked='delivery_type.once_date_time' :disabled='delivery_type.once_date_time'>
                     <label for='select_delivery_time_Date-Time' class='custom-checkbox'><?php echo __('Select Date & Time', 'watergo'); ?></label>
                  </div>
               </div>
            </div>

            <div v-show='delivery_type.once_date_time == true' class='group-select-delivery-time'>
               <div class='btn-wrapper-order'>
                  <input data-id='0' type='text' value='' class='btn_select_date_once btn-dropdown' placeholder='<?php echo __('Select date', 'watergo'); ?>' readonly>
               </div>
               <div class='btn-wrapper-order'>
                  <select data-id='0' class='btn_select_time_once btn-dropdown'>
                     <option value="--"><?php echo __('Select time', 'watergo'); ?></option>
                  </select>
               </div>
            </div>

         </div>

         <!-- weekly -->
         <div class='group-tile'>
            <div class='form-check'>
               <input @click='btn_select_type("weekly")' :checked='delivery_type.weekly' id='select_type02' type="radio" class='form-input'>
               <label for='select_type02'><?php echo __('Delivery weekly', 'watergo'); ?></label>
            </div>
            <div v-show='delivery_type.weekly == true' class='deliverySelect_weekly'>
               <components_weekly_select ref='components_weekly_select'></components_weekly_select>
            </div>

            <button v-show='delivery_type.weekly' @click='btn_add_dom_delivery_weekly' class='button_add_delivery button_add_dom_delivery_weekly'><?php echo __('Add Day', 'watergo'); ?></button>
         </div>

         <!-- monthly -->
         <div class='group-tile'>
            <div class='form-check'>
               <input @click='btn_select_type("monthly")' :checked='delivery_type.monthly' id='select_type03' type="radio" class='form-input'>
               <label for='select_type03'><?php echo __('Delivery monthly', 'watergo'); ?></label>
            </div>

            <div v-show='delivery_type.monthly == true' class='deliverySelect_monthly'>
               <div class='group-select-delivery-time'>
                  <div class='btn-wrapper-order'>
                     <input data-id='0' type='text' value='' class='btn_select_monthly_primary btn_select_monthly btn-dropdown' placeholder='<?php echo __('Select date', 'watergo'); ?>' readonly>
                  </div>
                  <div class='btn-wrapper-order'>
                     <select data-id='0' class='btn_select_monthly_time btn-dropdown'>
                        <option value='' selected disabled><?php echo __('Select time', 'watergo'); ?></option>
                        <option value='7:00-8:00'>7:00  -  8:00</option>
                        <option value='8:00-9:00'>8:00  -  9:00</option>
                        <option value='9:00-10:00'>9:00  -  10:00</option>
                        <option value='10:00-11:00'>10:00  -  11:00</option>
                        <option value='11:00-12:00'>11:00  -  12:00</option>
                        <option value='12:00-13:00'>12:00  -  13:00</option>
                        <option value='13:00-14:00'>13:00  -  14:00</option>
                        <option value='14:00-15:00'>14:00  -  15:00</option>
                        <option value='15:00-16:00'>15:00  -  16:00</option>
                        <option value='16:00-17:00'>16:00  -  17:00</option>
                        <option value='17:00-18:00'>17:00  -  18:00</option>
                        <option value='18:00-19:00'>18:00  -  19:00</option>
                        <option value='19:00-20:00'>19:00  -  20:00</option>
                        <option value='20:00-21:00'>20:00  -  21:00</option>
                     </select>
                  </div>
               </div>
            </div>

            <button v-show='delivery_type.monthly' @click='btn_add_dom_delivery_monthly' class='button_add_delivery button_add_dom_delivery_monthly'><?php echo __('Add Date', 'watergo'); ?></button>
         </div>
      </div>

      <div class='break-line'></div>
      <div class='inner'><p class='heading-02'><?php echo __('Payment method', 'watergo'); ?> </p><p><?php echo __('By Cash', 'watergo'); ?></p></div>

      <div class='product-detail-bottomsheet cell-placeorder'>
         <p class='price-total'><?php echo __('Total', 'watergo'); ?>: <span class='t-primary t-bold'>{{ count_product_total_price.price_discount }} </span></p>
         <button id='buttonPlaceOrder' @click='buttonPlaceOrder' class='btn-primary btn-order' :class='canPlaceOrder == false ? "disable" : "" '><?php echo __('Place Order', 'watergo'); ?></button>
      </div>

   </div>

   <div v-if='modal_store_out_of_stock == true && canPlaceOrder == false' class='modal-popup' :class='modal_store_out_of_stock == true && canPlaceOrder == false ? "open" : ""'>
      <div class='modal-wrapper'>
         <div class='modal-close'><div @click='buttonCloseModal_store_out_of_stock' class='close-button'><span></span><span></span></div></div>
         <p class='heading'><?php echo __("This Product is <span class='t-primary'>Out of Stock</span", 'watergo'); ?>></p>
      </div>
   </div>

   <div v-if="loading == true">
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
         <h3><?php echo __('Order Successfully', 'watergo'); ?></h3>
      </div>
      <div class='banner-footer'>
         <button @click='goBackRefresh' class='btn btn-outline'><?php echo __('Exit', 'watergo'); ?></button>
      </div>
   </div>


</div>


<script src="<?php echo THEME_URI . '/pages/module/module_weekly_select.js'; ?>"></script>
<link defer rel="stylesheet" href="<?php echo THEME_URI . '/assets/js/jquery_ui_1.13.2.min.css'; ?>">
<script defer src="<?php echo THEME_URI . '/assets/js/jquery_ui_1.13.2.min.js'; ?>"></script>

<script setup>

var app = Vue.createApp({

   data(){
      return {

         get_locale: '<?php echo get_locale(); ?>',

         loading:       true,
         banner_open:   false,

         delivery_type: {
            once:             false,
            once_immediately: false,
            once_date_time:   false,
            weekly:           false,
            monthly:          false,
         },

         delivery_data: {
            once_date:  [],
            weekly:     [],
            monthly:    [],
         },

         dayOfWeeks: [ 
            'Monday', 
            'Tuesday', 
            'Wednesday', 
            'Thursday', 
            'Friday', 
            'Saturday', 
            'Sunday'
         ],

         delivery_address_primary: null,
         carts: [],

         // FOR RE-ORDER
         time_shipping: [],

         // modal out of stock
         modal_store_out_of_stock: false,

         dom_monthly: 0,

         canPlaceOrder: false,

         dateWeekAuto: [],

      }
      
      
   },

   watch: {
      delivery_address_primary: {
         handler( val ){
            if( val != undefined || val != null ){
               if( this.delivery_type.once_immediately == true ){
                  this.canPlaceOrder = true;
               }else{
                  this.canPlaceOrder = false;
               }
               if( this.delivery_type.once_date_time == true ){
                  if( 
                     this.delivery_data.once_date.length > 0 &&
                     ( this.delivery_data.once_date[0].day && this.delivery_data.once_date[0].day !== '' ) &&
                     ( this.delivery_data.once_date[0].time && this.delivery_data.once_date[0].time !== '' )
                  ){
                     this.canPlaceOrder = true;
                  }else{
                     this.canPlaceOrder = false;
                  }
               }
            }
         },
         deep: true
      },

      delivery_data: {
         handler( val ){

            if( this.delivery_address_primary != null ){

               if( this.delivery_type.once_immediately == true ){
                  this.canPlaceOrder = true;
               }else{
                  this.canPlaceOrder = false;
               }

               if( this.delivery_type.once_date_time == true ){
                  if( 
                     val.once_date.length > 0 && 
                     ( val.once_date[0].day && val.once_date[0].day !== '' ) &&
                     ( val.once_date[0].time && val.once_date[0].time !== '' )
                  ){
                     console.log('Can Order Once date time');
                     this.canPlaceOrder = true;
                  }else{
                     this.canPlaceOrder = false;
                  }
               }

               if( this.delivery_type.weekly == true ){
                  for( var i = 0; i < val.weekly.length; i++ ){
                     if( 
                        ( val.weekly[i].day && val.weekly.day !== '' ) &&
                        ( val.weekly[i].time && val.weekly.time !== '' )
                     ){
                        this.canPlaceOrder = true;
                     }else{
                        this.canPlaceOrder = false;
                        break;
                     }
                  }
               }

               if( this.delivery_type.monthly == true ){
                  for( var i = 0; i < val.monthly.length; i++ ){
                     if( 
                        ( val.monthly[i].day && val.monthly.day !== '' ) &&
                        ( val.monthly[i].time && val.monthly.time !== '' )
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
         },
         deep: true,

      },

      // UPDATE FIX CHECK CAN ORDER FOR once_date_time
      delivery_type: {
         handler( type ){
            if( type.once_date_time == true  ){
               if( 
                  this.delivery_data.once_date.length > 0 &&
                  ( this.delivery_data.once_date[0].day && this.delivery_data.once_date[0].day !== '' ) &&
                  ( this.delivery_data.once_date[0].time && this.delivery_data.once_date[0].time !== '' )
               ){
                  this.canPlaceOrder = true;
               }else{
                  this.canPlaceOrder = false;
               }
            }
         },
         deep: true
      }      
   },

   methods: { 
      
      title_select_time_compact( title ){
         if( this.get_locale == 'vi' ){
            return 'Chọn thời gian';
         }
         return title;
      },
      

      isTimeRange(startTime, endTime) {
         // startTime 00:00 endTime 00:00
         var currentDate = new Date();
         var currentHours = currentDate.getHours();
         // var currentMinutes = currentDate.getMinutes();
         var currentMinutes = 1;

         var [startHours, startMinutes] = startTime.split(':').map(Number);
         var [endHours, endMinutes] = endTime.split(':').map(Number);

         if (
            (currentHours > startHours || (currentHours === startHours && currentMinutes >= startMinutes)) &&
            (currentHours < endHours || (currentHours === endHours && currentMinutes <= endMinutes))
         ) {
            return true;
         } else {
            return false;
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

      hasMoreThanTwoZeroes(number) {
         const numStr = number.toString();
         if( !/00{2,}/.test(numStr) ){
            return true;
         }else{
            return false;
         }
      },

      buttonCloseModal_store_out_of_stock(){ this.modal_store_out_of_stock = false },

      goBack(){ 
         localStorage.setItem( 'watergo_order_delivery_address', '[]' );
         window.reset_cart_to_select_false();
         window.goBack();
      },

      goBackRefresh(){ 
         localStorage.setItem( 'watergo_order_delivery_address', '[]' );
         window.reset_cart_to_select_false();
         // window.goBack(true);
         // appBridge.navigateTo("Order");
         appBridge.navigateTo("Home", "data");
      },

      gotoStoreDetail(store_id){ window.gotoStoreDetail(store_id)},

      removeZeroLeading( n ){ return window.removeZeroLeading(n)},
      gotoDeliveryAddress(){ window.gotoDeliveryAddress(true)},

      has_discount( product ){ return window.has_discount( product ); },
      common_price_after_discount_and_quantity(p){ return window.common_price_after_discount_and_quantity(p)},
      common_price_after_quantity(p){ return window.common_price_after_quantity(p)},
      
      /**
       * @access DATE ONE
       */
      
      func_add_date_once_data( id, data ){
         var _find = app.$data.delivery_data.once_date.find( item => item.id == id );
         if( _find ){
            Object.assign( _find, data);
         }else{
            app.$data.delivery_data.once_date.push( data );
         }
      },

      btn_select_date_once(){

         

         $(function(){

            function date_once( targetElement ){
               $('.ui-date-picker-wrapper').addClass('active');
               $('.ui-date-picker-wrapper').addClass('datepicker-order-product');

               var id   = targetElement.data('id');
               
               // Define an object that holds the month and day names for different locales
               var localeData = {
                  'en_US': {
                     monthNames: ['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'],
                     monthNamesShort: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'],
                     dayNames: ['Sunday', 'Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday'],
                     dayNamesShort: ['Sun', 'Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat'],
                     dayNamesMin: [ "Sun", "Mon", "Tue", "Wed", "Thu", "Fri", "Sat" ],
                  },
                  'vi': {
                     monthNames: ['Tháng 1', 'Tháng 2', 'Tháng 3', 'Tháng 4', 'Tháng 5', 'Tháng 6', 'Tháng 7', 'Tháng 8', 'Tháng 9', 'Tháng 10', 'Tháng 11', 'Tháng 12'],
                     monthNamesShort: ['Th.1', 'Th.2', 'Th.3', 'Th.4', 'Th.5', 'Th.6', 'Th.7', 'Th.8', 'Th.9', 'Th.10', 'Th.11', 'Th.12'],
                     dayNames: ['Chủ Nhật', 'Thứ Hai', 'Thứ Ba', 'Thứ Tư', 'Thứ Năm', 'Thứ Sáu', 'Thứ Bảy'],
                     dayNamesShort: ['CN', 'T2', 'T3', 'T4', 'T5', 'T6', 'T7'],
                     dayNamesMin: ['CN', 'T2', 'T3', 'T4', 'T5', 'T6', 'T7']
                  },
                  'ko_KR': {
                     monthNames: ['1월', '2월', '3월', '4월', '5월', '6월', '7월', '8월', '9월', '10월', '11월', '12월'],
                     monthNamesShort: ['1월', '2월', '3월', '4월', '5월', '6월', '7월', '8월', '9월', '10월', '11월', '12월'],
                     dayNames: ['일요일', '월요일', '화요일', '수요일', '목요일', '금요일', '토요일'],
                     dayNamesShort: ['일요일', '월요일', '화요일', '수요일', '목요일', '금요일', '토요일'],
                     dayNamesMin: ['일요일', '월요일', '화요일', '수요일', '목요일', '금요일', '토요일']
                  }
               };

               // Get the locale-specific month and day names based on this.locale
               var locale = 'en_US'; // Default to English
               var get_locale = '<?php echo get_locale(); ?>';
               if ( get_locale != undefined && localeData[get_locale] != undefined) {
                  locale = get_locale;
               }

               targetElement.datepicker({
                  dateFormat: "dd/mm/yy",
                  minDate: 0,
                  firstDay: 1,

                  monthNames:       localeData[locale].monthNames,
                  monthNamesShort:  localeData[locale].monthNamesShort,
                  dayNames:         localeData[locale].dayNames,
                  dayNamesShort:    localeData[locale].dayNamesShort,
                  dayNamesMin:      localeData[locale].dayNamesMin,

                  // dayNamesMin: [ "Sun", "Mon", "Tue", "Wed", "Thu", "Fri", "Sat" ],

                  onSelect: function(dateText, inst){
                     if(dateText != undefined || dateText != '' || dateText != null){

                        targetElement.attr('value', dateText);

                        window.app.func_add_date_once_data(id, { id: id, day: dateText, datetime: dateText } );

                        var [day, month, year] = dateText.split('/');
                        var convertToDateEn = month + '/' + day + '/' + year;

                        var _currentSelectDate = new Date( convertToDateEn );
                        var _currentDay  = new Date();

                        var getHourSelected = _currentDay.getHours().toString().padStart(2, '0');
                        getHourSelected = parseInt( getHourSelected ) + 2;

                        var _selectOption = [
                           { label: '7:00  -  8:00',   value: '7:00-8:00',   time: 7 },
                           { label: '8:00  -  9:00',   value: '8:00-9:00',   time: 8 },
                           { label: '9:00  -  10:00',  value: '9:00-10:00',  time: 9 },
                           { label: '10:00  -  11:00', value: '10:00-11:00', time: 10},
                           { label: '11:00  -  12:00', value: '11:00-12:00', time: 11},
                           { label: '12:00  -  13:00', value: '12:00-13:00', time: 12},
                           { label: '13:00  -  14:00', value: '13:00-14:00', time: 13},
                           { label: '14:00  -  15:00', value: '14:00-15:00', time: 14},
                           { label: '15:00  -  16:00', value: '15:00-16:00', time: 15},
                           { label: '16:00  -  17:00', value: '16:00-17:00', time: 16},
                           { label: '17:00  -  18:00', value: '17:00-18:00', time: 17},
                           { label: '18:00  -  19:00', value: '18:00-19:00', time: 18},
                           { label: '19:00  -  20:00', value: '19:00-20:00', time: 19},
                           { label: '20:00  -  21:00', value: '20:00-21:00', time: 20}
                        ];
                        var _selectDom = `<option value=''><?php echo __('Select time', 'watergo'); ?></option>`;

                        _currentSelectDate.setHours(0, 0, 0, 0);
                        _currentDay.setHours(0, 0, 0, 0);

                        $('.btn_select_time_once').empty('option');

                        if(_currentSelectDate.getTime() === _currentDay.getTime() ){
                           _selectOption = _selectOption.filter( item => item.time >= getHourSelected );
                        }

                        _selectOption.forEach( item => {
                           _selectDom += `
                              <option value='${item.value}'>${item.label}</option>
                           `;
                        });

                        $('.btn_select_time_once').append(_selectDom);
                     }
                  },
                  onClose: function(dateText, inst){
                     $('.ui-date-picker-wrapper').removeClass('active');
                     $('.ui-date-picker-wrapper').removeClass('datepicker-order-product');
                  }

               });

               if( $('.ui-date-picker-wrapper #ui-datepicker-div').length == 0 ){
                  $('#ui-datepicker-div').wrap('<div class="ui-date-picker-wrapper"></div>');
               }

               targetElement.datepicker('show');

               
            }

            $('.btn_select_date_once').on('click', function(){
               date_once( $(this));
            });
            // $(document).ready(function(){
            //    date_once( $('.btn_select_date_once'));
            // });
            
         });

      },

      btn_select_time_once(){
         $(document).on('change', '.btn_select_time_once', function(e){
            var id   = $(this).data('id');
            var time = $(this).find('option:selected').val();
            app.func_add_date_once_data(id, { id: id, time: time } );
         });
      },

      /**
       * @access MONTHLY
       */
      func_add_monthly_data( id, data ){
         var _find = app.$data.delivery_data.monthly.find( item => item.id == id );
         if( _find ){
            Object.assign( _find, data);
         }else{
            app.$data.delivery_data.monthly.push( data );
         }
      },

      btn_select_monthly(){

         function month( el ){
            $('.ui-datepicker .ui-datepicker-title').empty();
            $('.ui-date-picker-wrapper').addClass('active');
            $('.ui-date-picker-wrapper').addClass('datepicker-monthly');
            $('.ui-datepicker .ui-datepicker-title').html('<?php echo __("Everymonth", 'watergo'); ?>');

            var id     = el.data('id');
            var date   = el.val();

            el.datepicker({
               dateFormat: "dd",
               changeMonth: false,
               changeYear: false,
               stepMonths: 0,
               showButtonPanel: false,
               maxDate: new Date(new Date().getFullYear(), new Date().getMonth(), 28),
               
               beforeShowDay: function( date ) {

                  $('.ui-datepicker .ui-datepicker-title').empty();
                  $('.ui-widget-header a').remove();
                  $('.ui-datepicker-calendar thead').remove();

                  var disabledDays = [];
                  if( app.$data.delivery_data.monthly.length > 0  ) {
                     app.$data.delivery_data.monthly.forEach( m => {
                        disabledDays.push(m.datetimeDisable);
                     });
                  }
                  var string     = jQuery.datepicker.formatDate('dd/mm/yy', date);
                  var isDisabled = ($.inArray( string, disabledDays) != -1);
                  var isMaxDate  = date < new Date(new Date().getFullYear(), new Date().getMonth(), 29);
                  var extraClass = isMaxDate ? "datepicker-month-selected" : "datepicker-month-disabled";
                  //day != 0 disables all Sundays
                  return [ date && !isDisabled, extraClass ];
               },

               onSelect: function(dateText, inst){

                  if(dateText != undefined || dateText != '' || dateText != null){
                     el.attr('value', dateText);

                     $('.ui-date-picker-wrapper').removeClass('active');
                     $('.ui-date-picker-wrapper').removeClass('datepicker-monthly');
                     let currentDate = new Date();
                     let year = currentDate.getFullYear();
                     let month = String(currentDate.getMonth() + 1).padStart(2, '0');
                     let day = String(dateText).padStart(2, '0');
                     let fulldate = `${day}/${month}/${year}`;

                     app.func_add_monthly_data(id, {
                        id: id,
                        day: dateText,
                        datetime: window.compare_day_with_currentDate(dateText),
                        datetimeDisable: fulldate,
                     });

                  }
               },
               onClose: function(dateText, inst){
                  $('.ui-date-picker-wrapper').removeClass('active');
                  $('.ui-date-picker-wrapper').removeClass('datepicker-monthly');
               }
            });

            
            if( el.hasClass('btn_select_monthly_parent') ){
               el.datepicker('show');
            }

            $('.ui-datepicker .ui-datepicker-title').html('<?php echo __("Everymonth", 'watergo'); ?>');
            $('.ui-datepicker-calendar thead').remove();
            $('.ui-widget-header a').remove();

            if( $('.ui-date-picker-wrapper #ui-datepicker-div').length == 0 ){
               $('#ui-datepicker-div').wrap('<div class="ui-date-picker-wrapper"></div>');
            }
         }

         $(function(){

            $(document).on('input change click', '.btn_select_monthly, .btn_select_monthly_parent', function(){
               $('.ui-datepicker .ui-datepicker-title').empty();
               $('.ui-widget-header a').remove();
               $('.ui-datepicker-calendar thead').remove();
               month($(this));
            });
            month( $('.btn_select_monthly') );


            
         });

            
      },

      btn_select_monthly_time(){

         $(document).on('change', '.btn_select_monthly_time', function(e){
            var id   = $(this).data('id');
            var time = $(this).find('option:selected').val();
            app.func_add_monthly_data(id, { id: id, time: time } );
         });

      },

      btn_add_dom_delivery_weekly(){this.$refs.components_weekly_select.createWeekly();},
      btn_add_dom_delivery_monthly(){
         if(this.dom_monthly <= 28 ){
            this.dom_monthly = this.dom_monthly + 1;
            var _dom = `
               <div class='group-select-delivery-time group-select-delivery-time_parent'>
                  <div class='btn-wrapper-order'>
                     <input data-id='${this.dom_monthly}' type='text' value='' class='btn_select_monthly_parent btn-dropdown' placeholder='<?php echo __("Select date", 'watergo'); ?>' readonly>
                  </div>
                  <div class='btn-wrapper-order'>
                     <select data-id='${this.dom_monthly}' class='btn_select_monthly_time btn-dropdown'>
                        <option value='' selected disabled><?php echo __("Select time", 'watergo'); ?></option>
                        <option value='7:00-8:00'>7:00  -  8:00</option>
                        <option value='8:00-9:00'>8:00  -  9:00</option>
                        <option value='9:00-10:00'>9:00  -  10:00</option>
                        <option value='10:00-11:00'>10:00  -  11:00</option>
                        <option value='11:00-12:00'>11:00  -  12:00</option>
                        <option value='12:00-13:00'>12:00  -  13:00</option>
                        <option value='13:00-14:00'>13:00  -  14:00</option>
                        <option value='14:00-15:00'>14:00  -  15:00</option>
                        <option value='15:00-16:00'>15:00  -  16:00</option>
                        <option value='16:00-17:00'>16:00  -  17:00</option>
                        <option value='17:00-18:00'>17:00  -  18:00</option>
                        <option value='18:00-19:00'>18:00  -  19:00</option>
                        <option value='19:00-20:00'>19:00  -  20:00</option>
                        <option value='20:00-21:00'>20:00  -  21:00</option>
                     </select>
                  </div>
               </div>
            `;
            (function($){
               $(document).ready(function(){
                  if( $('.deliverySelect_monthly .group-select-delivery-time').length < 28 ){
                     $('.deliverySelect_monthly').append(_dom);
                  }
               })
            })(jQuery);
         }
      },


      btn_select_type( type ){ 

         // force all
         for (let prop in this.delivery_type) {
            if (this.delivery_type.hasOwnProperty(prop) && prop != type ) {
               this.delivery_type[prop] = false;
            }
         }
         
         switch( type ){
            case 'once': 
               this.delivery_type.once = true;
               this.$refs.components_weekly_select.createWeekly(true);

               this.delivery_data.monthly    = [];
               $('.deliverySelect_monthly .group-select-delivery-time_parent').remove();

               $('.btn_select_monthly').val('');
               $('.btn_select_monthly_time').val('');

            break;
            case 'once_date_time': 
               this.delivery_type.once             = true;
               this.delivery_type.once_date_time   = true;

               
            break;
            case 'once_immediately': 
               this.delivery_type.once             = true;
               this.delivery_type.once_immediately = true;
               this.delivery_data.once_date  = [];

               $('.btn_select_date_once').val('');
               if ($('.btn_select_time_once option[value="--"]').length === 0) {
                  $('.btn_select_time_once').empty().append('<option value="--"><?php echo __('Select time', 'watergo'); ?></option>');
               }

            break;
            case 'weekly': 

               this.delivery_type.weekly  = true;

               this.delivery_data.once_date  = [];
               this.delivery_data.monthly    = [];
               $('.deliverySelect_monthly .group-select-delivery-time_parent').remove();

               $('.btn_select_date_once').val('');
               if ($('.btn_select_time_once option[value="--"]').length === 0) {
                  $('.btn_select_time_once').empty().append('<option value="--"><?php echo __('Select time', 'watergo'); ?></option>');
               }

               $('.btn_select_monthly').val('');
               $('.btn_select_monthly_time').val('');

            break;
            case 'monthly': 

               this.delivery_type.monthly    = true;
               this.delivery_data.once_date  = [];

               this.$refs.components_weekly_select.createWeekly(true);

               $('.btn_select_date_once').val('');
               if ($('.btn_select_time_once option[value="--"]').length === 0) {
                  $('.btn_select_time_once').empty().append('<option value="--"><?php echo __('Select time', 'watergo'); ?></option>');
               }

            break;
            default: 
               for (let prop in this.delivery_type) {
                  if (this.delivery_type.hasOwnProperty(prop)) {
                     this.delivery_type[prop] = false;
                  }
               }
            break;
         }
      },

      async buttonPlaceOrder(){

         var _currentDate = new Date();
         var _watergo_carts = JSON.parse(localStorage.getItem('watergo_carts'));

         var _productSelected = this.carts.filter( store => {
            return store.products.find( product => product.product_select == true );
         });

         if ( this.canPlaceOrder == true && this.delivery_address_primary != null ) {
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

               // delivery_type = 'once_date_time';

            // GET DATA
            if( this.delivery_type.weekly == true ){
               delivery_type = 'weekly';
               delivery_data = this.$refs.components_weekly_select.slots;

               var currentDate      = new Date();
               var currentHour      = currentDate.getHours();
               var currentHourFixed = currentDate.getHours();
               var currentMinute    = currentDate.getMinutes();
               var currentDay       = currentDate.toLocaleString('en-us', { weekday: 'long' });

               for (let i = 0; i < delivery_data.length; i++) {
                  var delivery = delivery_data[i];
                  if (delivery.day === currentDay) {
                     var [hStart, hEnd] = delivery.time.split('-');
                     var [h1, h2]   = hStart.split(':').map(Number);
                     var [e1, e2]   = hEnd.split(':').map(Number);

                     var _nextDay = false;

                     if( currentHour > h1 ){
                        _nextDay = true;
                     }
                     if(currentHour == h1 && currentMinute > 0){
                        _nextDay = true;
                     }
                     if(currentHour + 1 == h1 && currentMinute > 0){
                        _nextDay = true;
                     }

                     if(_nextDay == true ){
                        delivery.datetime = this.addWeekForDatetime(delivery.datetime);
                     }
                  }
               }
            }

            if( this.delivery_type.monthly == true ){
               delivery_type = 'monthly';
               delivery_data = this.delivery_data.monthly;

               var currentDate      = new Date();
               var currentHour      = currentDate.getHours();
               var currentHourFixed = currentDate.getHours();
               var currentMinute    = currentDate.getMinutes();
               var currentDay       = currentDate.getDate().toString().padStart(2, '0');
               
               for (let i = 0; i < delivery_data.length; i++) {
                  var delivery = delivery_data[i];

                  if (delivery.day === currentDay) {
                     var [hStart, hEnd]   = delivery.time.split('-');
                     var [h1, h2]   = hStart.split(':').map(Number);
                     var [e1, e2]   = hEnd.split(':').map(Number);
                     var _nextDay = false;

                     if( currentHour > h1 ){
                        _nextDay = true;
                     }
                     if(currentHour == h1 && currentMinute > 0){
                        _nextDay = true;
                     }
                     if(currentHour + 1 == h1 && currentMinute > 0){
                        _nextDay = true;
                     }

                     if(_nextDay == true ){
                        delivery.datetime = this.addWeekForDatetime(delivery.datetime);
                        var [d,m,y]       = delivery.datetime.split('/');
                        delivery.day      = d;
                     }
                  }
               }
            }

            var form = new FormData();
            form.append('action',            'atlantis_add_order');
            form.append('delivery_data',     JSON.stringify( delivery_data ) );
            form.append('delivery_address',  JSON.stringify(this.delivery_address_primary) );
            form.append('delivery_type',     delivery_type );
            form.append('productSelected',   JSON.stringify( _productSelected ) );

            var r = await window.request(form);
            // console.log(r)
            // var r = null;

            if( r != undefined ){
               var res = JSON.parse( JSON.stringify( r ));
               if( res.message == 'insert_order_ok' ){

                  for (let i = _watergo_carts.length - 1; i >= 0; i--) {
                     var _carts = _watergo_carts[i];
                     for (let j = _carts.products.length - 1; j >= 0; j--) {
                        var _product = _carts.products[j];
                        if ( _product.product_select == true ) {
                           _carts.products.splice(j, 1);
                        }
                     }
                     // remove store when no product in cart
                     if (_carts.products.length === 0) { _watergo_carts.splice(i, 1); }
                  }
                  localStorage.setItem('watergo_carts', JSON.stringify(_watergo_carts));
                  // 
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

      async get_delivery_address_primary(){
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

      // FIND ORDER
      async find_order( order_id ){
         var form = new FormData();
         form.append('action', 'atlantis_get_order_detail');
         form.append('order_id', order_id);
         var r = await window.request(form);
         if( r != undefined ){
            var res = JSON.parse( JSON.stringify(r ));
            if( res.message == 'get_order_ok'){
               return res.data;
            }
         }

      },
      
      // GET ALL TIME SGIPPING FROM ORDER
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

      // FIND PRODUCT
      async find_product( product_id ){
         var form = new FormData();
         form.append('action', 'atlantis_find_product');
         form.append('product_id', product_id);
         var r = await window.request(form);
         if( r != undefined ){
            var res = JSON.parse( JSON.stringify( r));
            if( res.message == 'product_found' ){
               return res.data;
            }
         }
      },

      dateFormatToDDMMYY(date){
         var day = date.getDate().toString().padStart(2, '0');
         var month = (date.getMonth() + 1).toString().padStart(2, '0');
         var year = date.getFullYear().toString();
         return day + '/' + month + '/' + year;
      },

      addWeekForDatetime(inputDateStr) {
         // Parse the input date
         var parts = inputDateStr.split('/');
         var day = parseInt(parts[0], 10);
         var month = parseInt(parts[1], 10) - 1; // Note: Months are 0-based
         var year = parseInt(parts[2], 10);

         // Create a Date object from the parsed values
         var inputDate = new Date(year, month, day);

         // Add 7 days to the date
         inputDate.setDate(inputDate.getDate() + 7);

         // Format the new date as "dd/mm/yyyy"
         return `${inputDate.getDate().toString().padStart(2, '0')}/${(inputDate.getMonth() + 1).toString().padStart(2, '0')}/${inputDate.getFullYear()}`;
      }

   },
   
   computed: {
      count_product_total_price(){
         var gr_price = { price: 0, price_discount: 0 };

         this.carts.forEach( store => {

            store.products.forEach(product => {

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
            _final_price = gr_price.price.toLocaleString('vi-VN') + ' đ';
         }

         return {
            price: _final_price,
            price_discount: gr_price.price_discount.toLocaleString('vi-VN') + ' đ'
         };
      },
   },

   update(){
      window.appbar_fixed();
      if( $('.ui-date-picker-wrapper #ui-datepicker-div').length == 0 ){
         $('#ui-datepicker-div').wrap('<div class="ui-date-picker-wrapper"></div>');
      }
   },

   async created(){

      this.loading = true;
      this.automatic_count_date_week();
      // console.log(this.dateWeekAuto);

      // IF PASS ORDER_ID => this is re-order product
      const urlParams = new URLSearchParams(window.location.search);
      const order_id = urlParams.get('re_order_id');

      var _order_delivery_address   = JSON.parse(localStorage.getItem('watergo_order_delivery_address'));
      if( _order_delivery_address != undefined && _order_delivery_address.length > 0 ){

         // alert(_order_delivery_address[0].id);
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
         await this.get_delivery_address_primary();
      }

      /**
       * @access FOR ORDER PRODUCT
       */
      if( order_id == undefined ){
         // INIT TIME PICKER FOR USER
         this.delivery_type.once = true;
         this.delivery_type.once_immediately = true;
         if( 
            this.delivery_address_primary != null &&
            this.delivery_type.once == true && 
            this.delivery_type.once_immediately == true
         ){
            this.btn_select_type('once_immediately');
         }
         
         var _carts = JSON.parse(localStorage.getItem('watergo_carts'));

         if( _carts.length > 0 ){
            _carts.forEach( store => {
               if (store.store_select == true ) {
                  this.carts.push({ ...store, products: [...store.products] });
               } else {
                  const selectedProducts = store.products.filter(product => product.product_select);
                  if (selectedProducts.length > 0) {
                     // If there are selected products, push the store with only selected products to this.carts
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
                        this.carts[storeIndex].products[productIndex].has_discount     = res.data.has_discount;
                        this.carts[storeIndex].products[productIndex].discount_to      = res.data.discount_to;
                        this.carts[storeIndex].products[productIndex].discount_from    = res.data.discount_from;
                        this.carts[storeIndex].products[productIndex].discount_percent = res.data.discount_percent;
                        this.carts[storeIndex].products[productIndex].price            = res.data.price;
                        this.carts[storeIndex].products[productIndex].product_metadata = {
                           product_name: res.data.name,
                           product_name_second: res.data.name_second
                        };
                     }
                  }
               });
            });
            setTimeout(() => {}, 200);
         }
      }

      /**
       * @access FOR RE-ORDER
       */
      if( order_id != undefined ){
         this.canPlaceOrder = false;
         var order = await this.find_order(order_id);

         if( order.order_products != undefined && order.order_products.length > 0 ){
            
            this.carts.push({
               store_id:      order.store_id,
               store_name:    order.store_name,
               store_select:  false,
               products:      []
            });

            // SET TYPE SHIPPING FOR WEEKLY
            
            if( order.order_delivery_type == 'once_immediately'){
               this.btn_select_type('once_immediately');

            }
            if( order.order_delivery_type == 'once_date_time'){
               this.btn_select_type('once_date_time');
            }
            if( order.order_delivery_type == 'weekly'){
               this.btn_select_type('weekly');
            }

            if( order.order_delivery_type == 'monthly' ){
               this.btn_select_type('monthly');
            }

            // SET TYPE SHIPPING FOR MONTHLY


            for (var p of order.order_products) {
               var _find_product = await this.find_product(p.order_group_product_id);
               this.carts[0].products.push({ // Assuming you want to push the product to the first cart in the array
                  product_id: _find_product.id,
                  product_quantity_count: p.order_group_product_quantity_count,
                  product_select: true,
                  name: _find_product.name,
                  name_second: _find_product.name_second,
                  has_discount: _find_product.has_discount,
                  discount_to: _find_product.discount_to,
                  discount_from: _find_product.discount_from,
                  discount_percent: _find_product.discount_percent,
                  price: _find_product.price,
                  product_metadata: {
                     product_name: _find_product.name,
                     product_name_second: _find_product.name_second
                  }
               });
            }
         }

      }

      setTimeout( () => {
         this.btn_select_date_once();
         this.btn_select_time_once();

         this.btn_select_monthly();
         this.btn_select_monthly_time();
      }, 300);
      $(function(){
         if( $('.ui-date-picker-wrapper #ui-datepicker-div').length == 0 ){
            $('#ui-datepicker-div').wrap('<div class="ui-date-picker-wrapper"></div>');
         }
      });
      window.appbar_fixed();
      this.loading = false;
   },
   

})
.component('components_weekly_select', components_weekly_select)
.mount('#app');

window.app = app;
</script>

