<link rel="stylesheet" href="<?php echo THEME_URI . '/assets/js/jquery_ui_1.13.2.min.css'; ?>">
<script src="<?php echo THEME_URI . '/assets/js/jquery_ui_1.13.2.min.js'; ?>"></script>

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
               <p class='leading-title'>Order</p>
            </div>
         </div>
         <div class='break-line'></div> 
      </div>

      
      <div class='inner'>
         <div @click='gotoDeliveryAddress' class='list-tile delivery-address' :class='delivery_address_primary != null ? "has-delivery" : ""' >
            <div class='content'>
               <div v-if='delivery_address_primary == null'>
                  <p class='tt01'>Delivery address</p>
                  <p class='tt02'>There is no address</p>
               </div>
               <div v-else>
                  <p class='tt01'>Delivery address</p>
                  <p class='tt03'>{{ delivery_address_primary.address }}</p>
                  <p class='tt02'>{{ delivery_address_primary.name }} | {{ delivery_address_primary.phone }}</p>
               </div>
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

      <ul class='list-tile order'>
         <li  
            v-for='(store, index) in carts' :key='index'>
            <div class='shop-detail'>
               <div class='logo'>
                  <svg width="21" height="17" viewBox="0 0 21 17" fill="none" xmlns="http://www.w3.org/2000/svg">
                     <rect x="2.5" y="6.5" width="16" height="10" rx="1.5" fill="white" stroke="black"/>
                     <path d="M20.096 4.43083L20.0959 4.4307L17.8831 0.787088L17.8826 0.786241C17.7733 0.605479 17.5825 0.5 17.3865 0.5H3.61215C3.41614 0.5 3.22534 0.605479 3.11605 0.786241L3.11554 0.787088L0.902826 4.43061C0.902809 4.43064 0.902792 4.43067 0.902775 4.4307C0.0376853 5.85593 0.639918 7.73588 1.97289 8.31233C2.15024 8.38903 2.34253 8.44415 2.54922 8.47313C2.67926 8.49098 2.81302 8.5 2.9473 8.5C3.80016 8.5 4.5594 8.1146 5.08594 7.50809L5.46351 7.07318L5.84107 7.50809C6.36742 8.11438 7.12999 8.5 7.97971 8.5C8.83258 8.5 9.59181 8.1146 10.1184 7.50809L10.4959 7.07318L10.8735 7.50809C11.3998 8.11438 12.1624 8.5 13.0121 8.5C13.865 8.5 14.6242 8.1146 15.1508 7.50809L15.5273 7.07438L15.905 7.50705C16.4357 8.11494 17.1956 8.5 18.0445 8.5C18.1822 8.5 18.3128 8.49098 18.4433 8.47304L20.096 4.43083ZM20.096 4.43083C21.0907 6.06765 20.1619 8.23575 18.4435 8.47301L20.096 4.43083Z" fill="white" stroke="black"/>
                  </svg>
               </div>
               <span class='shop-name'>{{ store.store_name }}</span>
            </div>

            <div
               v-for="(product, productKey) in store.products" :key="productKey" 
               class='list-items'>
               <div v-if="product.product_select == true" class="list-items-wrapper">
                  <span class='quantity'>{{ product.product_quantity_count }}x</span>
                  <div class='order-gr'>
                     <span class='product-title'>{{ product.product_metadata.product_name }}</span>
                     <span class='product-subtitle'>{{ product.product_metadata.product_name_second }}</span>
                  </div>
                  <div class='order-price'>
                     <span class='price'>

                        {{ common_get_product_price(get_total_price(
                           product.product_price, 
                           product.product_quantity_count, product.product_discount_percent)) }}
                     </span>
                     <span class='od-price-discount' v-if='has_discount(product)'>
                        {{ common_get_product_price(product.product_price, product.product_discount_percent) }}
                     </span>
                  </div>
               </div>
            </div>
         </li>
      </ul>
      
      <div class='select_delivery_time' ref='select_delivery_time'>
         <p class='heading-02'>Select delivery time</p>

         <div class='group-tile'>
            <div class='form-check'>
               <input @click='btn_select_type("once")' :checked='delivery_type.once' id='select_type01' type="radio" class='form-input'>
               <label for='select_type01' >Delivery once</label>
            </div>

            <div v-show='delivery_type.once' class='group-time-delivery-once'>
               <div class='form-group-select'>
                  <div class='form-check'>
                     <input id='select_delivery_time_Immediately' type='checkbox' @click='btn_select_type("once_immediately")' :checked='delivery_type.once_immediately' :disabled='delivery_type.once_immediately'>
                     <label for='select_delivery_time_Immediately'>Immediately (within 1 hour)</label>
                  </div>
                  <div class='form-check'>
                     <input id='select_delivery_time_Date-Time' type='checkbox' @click='btn_select_type("once_date")' :checked='delivery_type.once_date' :disabled='delivery_type.once_date'>
                     <label for='select_delivery_time_Date-Time' class='custom-checkbox'>Select Date & Time</label>
                  </div>
               </div>
            </div>

            <div v-show='delivery_type.once_date' class='group-select-delivery-time'>
               <div class='btn-wrapper-order'>
                  <input type='text' value='' class='btn_select_date_once btn-dropdown' placeholder='Select date' readonly>
               </div>
               <div class='btn-wrapper-order'>
                  <select class='btn_select_time_once btn-dropdown'>
                     <option value="--">Select time</option>
                  </select>
               </div>
            </div>

         </div>

         <!-- weekly -->
         <div class='group-tile'>
            <div class='form-check'>
               <input @click='btn_select_type("weekly")' :checked='delivery_type.weekly' id='select_type02' type="radio" class='form-input'>
               <label for='select_type02'>Delivery weekly</label>
            </div>
            <div v-show='delivery_type.weekly' class='deliverySelect_weekly'>

               <div class='group-select-delivery-time'>
                  <div class='btn-wrapper-order'>
                     <select class='btn_select_weekly_day btn-dropdown'>
                        <option value="">Select day</option>
                        <option value="Monday">Monday</option>
                        <option value="Tuesday">Tuesday</option>
                        <option value="Wednesday">Wednesday</option>
                        <option value="Thursday">Thursday</option>
                        <option value="Friday">Friday</option>
                        <option value="Saturday">Saturday</option>
                        <option value="Sunday">Sunday</option>
                     </select>
                  </div>
                  <div class='btn-wrapper-order'>
                     <select class='btn_select_weekly_time btn-dropdown'>
                        <option value=''>Select time</option>
                        <option value='7:00-8:00'>7:00  -  8:00</option>
                        <option value='8:00-9:00'>8:00  -  9:00</option>
                        <option value='9:00-10:00'>9:00  -   10:00</option>
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
            <button v-show='delivery_type.weekly' @click='btn_add_dom_delivery_weekly' class='button_add_delivery button_add_dom_delivery_weekly'>Add Day</button>
         </div>

         <!-- monthly -->
         <div class='group-tile'>
            <div class='form-check'>
               <input @click='btn_select_type("monthly")' :checked='delivery_type.monthly' id='select_type03' type="radio" class='form-input'>
               <label for='select_type03'>Delivery mothly</label>
            </div>

            <div v-show='delivery_type.monthly' class='deliverySelect_monthly'>
               <div class='group-select-delivery-time'>
                  <div class='btn-wrapper-order'>
                     <input type='text' value='' class='btn_select_monthly btn-dropdown' placeholder='Select date' readonly>
                  </div>
                  <div class='btn-wrapper-order'>
                     <select class='btn_select_monthly_time btn-dropdown'>
                        <option value=''>Select time</option>
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
            <button v-show='delivery_type.monthly' @click='btn_add_dom_delivery_monthly' class='button_add_delivery button_add_dom_delivery_monthly'>Add Date</button>

         </div> 

      </div>

      <div class='break-line'></div>
      <div class='inner'>
         <p class='heading-02'>Payment method </p>
         <p>By Cash</p>
      </div>

      <div class='product-detail-bottomsheet cell-placeorder'>
         <p class='price-total'>Total: <span class='t-primary t-bold'>{{ count_product_total_price.price_discount }}</span></p>
         <button id='buttonPlaceOrder' ref='buttonPlaceOrder' @click='buttonPlaceOrder' class='btn-primary disabled'>Place Order</button>
      </div>

      
   </div>
   

   <div v-show="loading == true">
      <div class='progress-center'>
         <div class='progress-container enabled'><progress class='progress-circular enabled'></progress></div>
      </div>
   </div>

   <div v-show='banner_open == true' class='banner z-index-5'>
      <div class='banner-head'>
         <svg width="64" height="64" viewBox="0 0 64 64" fill="none" xmlns="http://www.w3.org/2000/svg">
         <circle cx="32" cy="32" r="32" fill="#2790F9"/>
         <path fill-rule="evenodd" clip-rule="evenodd" d="M44.7917 24.8288L42.103 22.1401L27.8578 36.3854L22.2522 30.7798L19.5635 33.4685L27.9506 41.8557L30.6393 39.167L30.5465 39.0741L44.7917 24.8288Z" fill="white"/>
         </svg>
         <h3>Order Successfully</h3>
      </div>
      <div class='banner-footer'>
         <button @click='goBackRefresh' class='btn btn-outline'>Exit</button>
      </div>
   </div>
</div>


<script type='module' setup>

var { createApp } = Vue;

createApp({

   data(){
      return {
         loading: false,
         banner_open: false,

         delivery_type: {
            once: false,
            once_date: false,
            once_immediately: false,
            weekly: false,
            monthly: false,
         },

         delivery_address_primary: null,
         carts: []

      }
   },
   methods: { 
      goBack(){ window.goBack() },
      goBackRefresh(){ 
         window.goBack(); 
         if( window.appBridge != undefined ){
            window.appBridge.refresh();
         }
      },

      gotoDeliveryAddress(){ window.gotoDeliveryAddress()},

      get_total_price( price, quantity, discount){ return window.get_total_price( price, quantity, discount); },
      has_discount( product ){ return window.has_discount( product ); },
      common_get_product_price( price, discount_percent ){ return window.common_get_product_price( price, discount_percent ); },

      /**
       * @access DATE FUNCTION
       */

      btn_select_date_once(){

         (function($){
            $(document).ready(function(){

               $(document).on('click', '.btn_select_date_once', function(e){
                  $('.ui-date-picker-wrapper').addClass('active');

                  var targetElement = $(this);

                  targetElement.datepicker({
                     dateFormat: "dd/mm/yy",
                     minDate: 0,
                     firstDay: 1,
                     dayNamesMin: [ "Sun", "Mon", "Tue", "Wed", "Thu", "Fri", "Sat" ],
                     onSelect: function(dateText, inst){
                        if(dateText != undefined || dateText != '' || dateText != null){

                           targetElement.attr('value', dateText);

                           var [day, month, year] = dateText.split('/');
                           var convertToDateEn = month + '/' + day + '/' + year;

                           var _currentSelectDate = new Date( convertToDateEn );
                           var _currentDay  = new Date();

                           var getHourSelected = _currentDay.getHours().toString().padStart(2, '0');
                           

                           var _selectOption = [
                              { label: '7:00  -  8:00', value: '7:00-8:00', time: 7 },
                              { label: '8:00  -  9:00', value: '8:00-9:00', time: 8 },
                              { label: '9:00  -  10:00', value: '9:00-10:00', time: 9 },
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
                           var _selectDom = `<option value=''>Select time</option>`;

                           _currentSelectDate.setHours(0, 0, 0, 0);
                           _currentDay.setHours(0, 0, 0, 0);

                           $('.btn_select_time_once').empty('option');

                           if(_currentSelectDate.getTime() === _currentDay.getTime() ){
                              _selectOption = _selectOption.filter( (item) => item.time >= getHourSelected );
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
                     }
                  });

                  targetElement.datepicker('show');
               });
               
            });
         })(jQuery);

      },

      btn_select_monthly(){
         (function($){
            $(document).ready(function(){

               function month( el ){

                  $('.ui-datepicker .ui-datepicker-title').empty();
                  $('.ui-widget-header a').remove();
                  $('.ui-datepicker-calendar thead').remove();

                  $('.ui-date-picker-wrapper').addClass('active');

                  var targetElement = el;

                  targetElement.datepicker({
                     dateFormat: "dd",
                     changeMonth: false,
                     changeYear: false,
                     stepMonths: 0,
                     showButtonPanel: false,
                     onSelect: function(dateText, inst){
                        if(dateText != undefined || dateText != '' || dateText != null){
                           targetElement.attr('value', dateText);
                           $('.ui-date-picker-wrapper').removeClass('active');
                        }
                     },
                     onClose: function(dateText, inst){
                        $('.ui-date-picker-wrapper').removeClass('active');
                     }
                  });
                  if( targetElement.hasClass('btn_select_monthly_parent') ){
                     targetElement.datepicker('show');
                  }
                  
                  $('.ui-datepicker .ui-datepicker-title').html('Everymonth');
               }

               month( $('.btn_select_monthly'));
               
               $(document).on('click', '.btn_select_monthly', function(e){
                  month($(this));
               });

               
            });
         })(jQuery);

      },

      btn_add_dom_delivery_weekly(){
         var _dom = `
            <div class='group-select-delivery-time group-select-delivery-time_parent'>
               <div class='btn-wrapper-order'>
                  <select class='btn_select_weekly_day btn-dropdown'>
                     <option value="">Select day</option>
                     <option value="Monday">Monday</option>
                     <option value="Tuesday">Tuesday</option>
                     <option value="Wednesday">Wednesday</option>
                     <option value="Thursday">Thursday</option>
                     <option value="Friday">Friday</option>
                     <option value="Saturday">Saturday</option>
                     <option value="Sunday">Sunday</option>
                  </select>
               </div>
               <div class='btn-wrapper-order'>
                  <select class='btn_select_weekly_time btn-dropdown'>
                     <option value=''>Select time</option>
                     <option value='7:00-8:00'>7:00  -  8:00</option>
                     <option value='8:00-9:00'>8:00  -  9:00</option>
                     <option value='9:00-10:00'>9:00 -   10:00</option>
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
               $('.deliverySelect_weekly').append(_dom);
            })
         })(jQuery);


      },

      btn_add_dom_delivery_monthly(){
         var _dom = `
            <div class='group-select-delivery-time group-select-delivery-time_parent'>
               <div class='btn-wrapper-order'>
                  <input type='text' value='' class='btn_select_monthly btn_select_monthly_parent btn-dropdown' placeholder='Select date' readonly>
               </div>
               <div class='btn-wrapper-order'>
                  <select class='btn_select_monthly_time btn-dropdown'>
                     <option value=''>Select time</option>
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
               $('.deliverySelect_monthly').append(_dom);
            })
         })(jQuery);
      },

      btn_select_type( type ){ 

         // force all
         for (let prop in this.delivery_type) {
            if (this.delivery_type.hasOwnProperty(prop)) {
               this.delivery_type[prop] = false;
            }
         }
         switch( type ){
            case 'once': 
               this.delivery_type.once = true;
            break;
            case 'once_date': 
               this.delivery_type.once = true;
               this.delivery_type.once_immediately = false;
               this.delivery_type.once_date = !this.delivery_type.once_date;
            break;
            case 'once_immediately': 
               this.delivery_type.once = true;
               this.delivery_type.once_date = false;
               this.delivery_type.once_immediately = !this.delivery_type.once_immediately;
            break;
            case 'weekly': 
               this.delivery_type.weekly = true;
            break;
            case 'monthly': 
               this.delivery_type.monthly = true;
            break;
            default: 
               for (let prop in this.delivery_type) {
                  if (this.delivery_type.hasOwnProperty(prop)) {
                     this.delivery_type[prop] = false;
                  }
               }
            break;
         }

         this.$refs.select_delivery_time.setAttribute('delivery-type', type);

      },

      async buttonPlaceOrder(){

         var _currentDate = new Date();         
      
         var _watergo_carts = JSON.parse(localStorage.getItem('watergo_carts'));

         var _productSelected = _watergo_carts.filter( store => {
            return store.products.find( product => product.product_select == true );
         });

         if ( ! this.$refs.buttonPlaceOrder.classList.contains('disabled') && this.delivery_address_primary != null ) {
            this.loading = true;
            var delivery_data = this.$refs.select_delivery_time.getAttribute('delivery-data');
            var delivery_type = this.$refs.select_delivery_time.getAttribute('delivery-type');

            if(delivery_type == 'once_date'){
               delivery_type = 'once_date_time';
            }

            // GET DATA
            if( delivery_type == 'weekly' ){
               delivery_data = JSON.parse( delivery_data ).weekly;
            }
            if( delivery_type == 'monthly' ){
               delivery_data = JSON.parse( delivery_data ).monthly;
            }
            if( delivery_type == 'once_date_time' ){
               delivery_data = JSON.parse( delivery_data ).once_date;
            }

            var form = new FormData();
            form.append('action', 'atlantis_add_order');
            form.append('delivery_data', JSON.stringify( delivery_data ) );
            form.append('delivery_address', JSON.stringify(this.delivery_address_primary) );
            form.append('delivery_type', delivery_type );
            form.append('productSelected', JSON.stringify( _productSelected ) );

            var r = await window.request(form);
            console.log(r);

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
            }else{
               this.loading = false;
            }

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
                  primary: true
               };
            }
         }
      }

   },
   
   computed: {

      count_product_total_price(){
         var gr_price = {
            price: 0,
            price_discount: 0
         };

         this.carts.forEach( store => {
            store.products.forEach(product => {
               if( product.product_discount_percent != null || product.product_discount_percent != 0 ){
                  gr_price.price_discount += ( product.product_price - ( product.product_price * ( product.product_discount_percent / 100)) ) * product.product_quantity_count;
               }else{
                  gr_price.price_discount += product.product_price * product.product_quantity_count;
               }
               gr_price.price += product.product_price * product.product_quantity_count;
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
   },

   async created(){

      // SETUP DATE PICKER

      this.loading = true;

      // await this.get_delivery_address_primary();

      var _carts = JSON.parse(localStorage.getItem('watergo_carts'));

      if( _carts.length > 0 ){
         _carts.some( store => {
            var selectedProducts = store.products.filter(product => product.product_select == true);
            if (selectedProducts.length > 0) {
               this.carts.push({
                  store_id: store.store_id,
                  store_name: store.store_name,
                  products: selectedProducts
               });
            }
         });
      }

      // add wrapper for picker
      this.btn_select_date_once();
      this.btn_select_monthly();

      (function($){
         $(document).ready(function(){
            if( $('.ui-date-picker-wrapper #ui-datepicker-div').length == 0 ){
               $('#ui-datepicker-div').wrap('<div class="ui-date-picker-wrapper"></div>');
            }

            var listenable = `.select_delivery_time`;
            var get_type_listenable = null;

            var _delivery_data = {
               once_date: [],
               weekly: [],
               monthly: [],
            };

            function _clear_data_once(){
               _delivery_data.once_date = [];
               $('.btn_select_date_once').val('');
               if ($('.btn_select_time_once option[value="--"]').length === 0) {
                  $('.btn_select_time_once').empty().append('<option value="--">Select time</option>');
               }
            }

            function _clear_data_weekly(){
               _delivery_data.weekly.pop();
               $('.deliverySelect_weekly .group-select-delivery-time_parent').remove();
               $('.deliverySelect_weekly .btn_select_weekly_day option').prop('selected', false);
               $('.deliverySelect_weekly .btn_select_weekly_time option').prop('selected', false);
            }

            function _clear_data_monthly(){
               _delivery_data.monthly.pop();
               $('.deliverySelect_monthly .group-select-delivery-time_parent').remove();
               $('.deliverySelect_monthly .btn_select_monthly_day option').prop('selected', false);
               $('.deliverySelect_monthly .btn_select_monthly_time option').prop('selected', false);
               $('.btn_select_monthly').val('');
            }
            

            $(document).on('input change click', listenable , function(){
               var _type_select = $(this).attr('delivery-type');

               if( _type_select == 'once' ){
                  _clear_data_weekly();
                  _clear_data_monthly();
                  _clear_data_once();
               }

               if( _type_select == 'once_date' ){
                  _clear_data_weekly();
                  _clear_data_monthly();

                  var _date_once = $('.btn_select_date_once').val();
                  var _time_once = $('.btn_select_time_once option:selected').val();

                  if(
                     _date_once != undefined && _date_once != null && _date_once != '' &&
                     _time_once != undefined && _time_once != null && _time_once != '--' && _time_once != '' 
                  ){
                     $('#buttonPlaceOrder').removeClass('disabled');
                     _delivery_data.once_date = {
                        day: _date_once,
                        time: _time_once,
                        datetime: _date_once
                     };

                  }else{
                     $('#buttonPlaceOrder').addClass('disabled');
                  }

               }

               if( _type_select == 'once_immediately' ){
                  _clear_data_once();
                  _clear_data_weekly();
                  _clear_data_monthly();
                  $('#buttonPlaceOrder').removeClass('disabled');
               }

               if( _type_select == 'weekly' ){
                  _clear_data_once();
                  _clear_data_monthly();

                  if( _delivery_data.weekly.length == 0 ){
                        $('#buttonPlaceOrder').addClass('disabled');
                     }else{
                        for(var a = 0; a < _delivery_data.weekly.length; a++  ){
                           if( _delivery_data.weekly[a].day == '' || _delivery_data.weekly[a].time == ''){
                              $('#buttonPlaceOrder').addClass('disabled');
                              break;
                           }else{
                              $('#buttonPlaceOrder').removeClass('disabled');
                           }
                        }
                     }  

                  $(document).on('input change click', '.btn_select_weekly_day, .btn_select_weekly_time, .button_add_dom_delivery_weekly', function(){

                     var _weekly_object = $('.deliverySelect_weekly .group-select-delivery-time');
                     var _weekly_object_total = _weekly_object.length;

                     for (var i = 0; i < _weekly_object_total; i++) {
                        var get_day_weekly = $(_weekly_object[i]).find('.btn_select_weekly_day option:selected').val();
                        var get_time_weekly = $(_weekly_object[i]).find('.btn_select_weekly_time option:selected').val();

                        _delivery_data.weekly[i] = {
                           day: get_day_weekly,
                           time: get_time_weekly,
                           datetime: window.get_fullday_form_dayOfWeek(get_day_weekly)
                        };
                     }

                     if( _delivery_data.weekly.length == 0 ){
                        $('#buttonPlaceOrder').addClass('disabled');
                     }else{
                        for(var a = 0; a < _delivery_data.weekly.length; a++  ){
                           if( _delivery_data.weekly[a].day == '' || _delivery_data.weekly[a].time == ''){
                              $('#buttonPlaceOrder').addClass('disabled');
                              break;
                           }else{
                              $('#buttonPlaceOrder').removeClass('disabled');
                           }
                        }
                     }  

                  });
                     
               }

               if( _type_select == 'monthly' ){
                  _clear_data_once();
                  _clear_data_weekly();

                  if( _delivery_data.monthly.length == 0 ){
                        $('#buttonPlaceOrder').addClass('disabled');
                     }else{
                        for(var a = 0; a < _delivery_data.monthly.length; a++  ){
                           if( _delivery_data.monthly[a].day == '' || _delivery_data.monthly[a].time == ''){
                              $('#buttonPlaceOrder').addClass('disabled');
                              break;
                           }else{
                              $('#buttonPlaceOrder').removeClass('disabled');
                           }
                        }
                     }

                  $(document).on('input change click', '.btn_select_monthly, .btn_select_monthly_time, .button_add_dom_delivery_monthly', function(){


                     var _monthly_object = $('.deliverySelect_monthly .group-select-delivery-time');
                     var _monthly_object_total = _monthly_object.length;

                     for (var i = 0; i < _monthly_object_total; i++) {
                        var get_day_monthly = $(_monthly_object[i]).find('.btn_select_monthly').val();
                        var get_time_monthly = $(_monthly_object[i]).find('.btn_select_monthly_time option:selected').val();

                        _delivery_data.monthly[i] = {
                           day: get_day_monthly,
                           time: get_time_monthly,
                           datetime: window.compare_day_with_currentDate(get_day_monthly)
                        };
                     }

                     if( _delivery_data.monthly.length == 0 ){
                        $('#buttonPlaceOrder').addClass('disabled');
                     }else{
                        for(var a = 0; a < _delivery_data.monthly.length; a++  ){
                           if( _delivery_data.monthly[a].day == '' || _delivery_data.monthly[a].time == ''){
                              $('#buttonPlaceOrder').addClass('disabled');
                              break;
                           }else{
                              $('#buttonPlaceOrder').removeClass('disabled');
                           }
                        }
                     }
                  });
               }

               $('.select_delivery_time').attr('delivery-data', JSON.stringify(_delivery_data));


            });
         
         });
      })(jQuery);

      
      
      this.loading = false;
      window.appbar_fixed();
   },
   

}).mount('#app');
</script>