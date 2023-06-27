const PageOrder = {
   name: 'PageOrder',
   template: `
      <div v-if='$root.navigator == "order"' class='page-product-order'>
         
         <div class='appbar'>
            <div class='leading'>
               <button @click='$root.goBack' class='btn-action'>
                  <svg width="20" height="16" viewBox="0 0 20 16" fill="none" xmlns="http://www.w3.org/2000/svg">
                  <path fill-rule="evenodd" clip-rule="evenodd" d="M0 8C0 7.44772 0.447715 7 1 7H18.5C19.0523 7 19.5 7.44772 19.5 8C19.5 8.55228 19.0523 9 18.5 9H1C0.447715 9 0 8.55228 0 8Z" fill="#252831"/>
                  <path fill-rule="evenodd" clip-rule="evenodd" d="M10.5309 0.375342C10.8759 0.806604 10.806 1.4359 10.3747 1.78091L2.60078 8.00004L10.3747 14.2192C10.806 14.5642 10.8759 15.1935 10.5309 15.6247C10.1859 16.056 9.55657 16.1259 9.12531 15.7809L0.375305 8.78091C0.13809 8.59113 0 8.30382 0 8.00004C0 7.69625 0.13809 7.40894 0.375305 7.21917L9.12531 0.219168C9.55657 -0.125842 10.1859 -0.0559202 10.5309 0.375342Z" fill="#252831"/>
                  </svg>
               </button>
               <p class='leading-title'>Order</p>
            </div>
         </div>

         <div class='break-line'></div> 
         <div class='inner'>
            <div @click='$root.gotoPage("delivery_address", { back: "order"})' class='list-tile delivery-address'>
               <div class='content'>
                  <div v-if='$root.hasDeliveryAddressPrimary == false'>
                     <p class='tt01'>Delivery address</p>
                     <p class='tt02'>There is no address</p>
                  </div>
                  <div v-else>
                     <p class='tt01'>Delivery address</p>
                     <p class='tt03'>{{ $root.delivery_address_primary.address }}</p>
                     <p class='tt02'>{{ $root.delivery_address_primary.name }} | {{ $root.delivery_address_primary.phone }}</p>
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
               v-for='(store, index) in $root.stores' :key='index'>
               <div v-if="store.carts.length > 0">
                  <div class='shop-detail'>
                     <div class='logo'>
                        <svg width="21" height="17" viewBox="0 0 21 17" fill="none" xmlns="http://www.w3.org/2000/svg">
                           <rect x="2.5" y="6.5" width="16" height="10" rx="1.5" fill="white" stroke="black"/>
                           <path d="M20.096 4.43083L20.0959 4.4307L17.8831 0.787088L17.8826 0.786241C17.7733 0.605479 17.5825 0.5 17.3865 0.5H3.61215C3.41614 0.5 3.22534 0.605479 3.11605 0.786241L3.11554 0.787088L0.902826 4.43061C0.902809 4.43064 0.902792 4.43067 0.902775 4.4307C0.0376853 5.85593 0.639918 7.73588 1.97289 8.31233C2.15024 8.38903 2.34253 8.44415 2.54922 8.47313C2.67926 8.49098 2.81302 8.5 2.9473 8.5C3.80016 8.5 4.5594 8.1146 5.08594 7.50809L5.46351 7.07318L5.84107 7.50809C6.36742 8.11438 7.12999 8.5 7.97971 8.5C8.83258 8.5 9.59181 8.1146 10.1184 7.50809L10.4959 7.07318L10.8735 7.50809C11.3998 8.11438 12.1624 8.5 13.0121 8.5C13.865 8.5 14.6242 8.1146 15.1508 7.50809L15.5273 7.07438L15.905 7.50705C16.4357 8.11494 17.1956 8.5 18.0445 8.5C18.1822 8.5 18.3128 8.49098 18.4433 8.47304L20.096 4.43083ZM20.096 4.43083C21.0907 6.06765 20.1619 8.23575 18.4435 8.47301L20.096 4.43083Z" fill="white" stroke="black"/>
                        </svg>
                     </div>
                     <span class='shop-name'>{{ store.name }}</span>
                  </div>

                  <div v-for="(product, productKey) in load_product_in_cart(store.id)" :key="productKey" class='list-items'>
                     <span class='quantity'>{{ product.product_quantity_count }}x</span>
                     <div class='order-gr'>
                        <span class='product-title'>{{ product.name }}</span>
                        <span class='product-subtitle'>{{ get_product_quantity(product) }}</span>
                     </div>
                     <div class='order-price'>
                        <span class='price'>
                           {{ common_get_product_price(get_total_price(product.price, product.product_quantity_count, product.discount_percent)) }}
                        </span>
                        <span class='od-price-discount' v-if='product.discount_percent != null'>
                           {{ common_get_product_price(product.price, product.discount_percent) }}
                        </span>
                     </div>
                  </div>
               </div>
            </li>
         </ul>
         
         <div class='select_delivery_time'>
            <p class='heading-02'>Select delivery time</p>

            <div class='group-tile'>
               <div class='form-check'>
                  <input @click='buttonDeliverySelectType("once")' :checked='getDeliverySelectType("once")' id='select_type01' type="radio" class='form-input'>
                  <label for='select_type01' >Delivery once</label>
               </div>

               <div v-show='deliverySelectType.once' class='group-time-delivery-once'>
                  <div class='form-group-select'>
                     <div class='form-check'>
                        <input id='select_delivery_time_Immediately' type='checkbox' @click='buttonDeliverySelectTypeTimeOnce("immediately")' :checked='deliverySelectType.timeOnce.immediately == true ? true : false'>
                        <label for='select_delivery_time_Immediately'>Immediately (within 1 hour)</label>
                     </div>
                     <div class='form-check'>
                        <input id='select_delivery_time_Date-Time' type='checkbox' @click='buttonDeliverySelectTypeTimeOnce("selectDate")' :checked='deliverySelectType.timeOnce.selectDate == true ? true : false'>
                        <label for='select_delivery_time_Date-Time' class='custom-checkbox'>Select Date & Time</label>
                     </div>
                  </div>
               </div>

               <div v-show='deliverySelectType.timeOnce.selectDate' class='group-select-delivery-time'>
                  <button class='btn-dropdown' @click='buttonSelectDate'>{{ deliveryTimeData.once.date == null ? "Select date" : deliveryTimeData.once.date }}</button>
                  <button class='btn-dropdown' @click='buttonSelectTime'>
                     {{ deliveryTimeData.once.time == null ? "Select time" : deliveryTimeData.once.time }}
                  </button>
               </div>

               <div class='deliveryDisplay'>
                  
                  <div v-if='datePickerDatePopup'>
                     <div class='date-table' v-for="(item, index ) in getCurrentMonthData" :key='index'>
                        <div class='date-table-head'>
                           <div class='heading'>{{ item.month }}, {{item.year}}</div>
                           <div class='date-actions'>
                              <button class='prevMonth' @click="prevMonth" :disabled="isPrevMonthDisabled"></button>
                              <button class='nextMonth' @click="nextMonth"></button>
                           </div>
                        </div>
                        <div class='date-table-contents'>
                           <table>
                              <tr>
                                 <th v-for="day in daysOfWeek" :key="day">{{ day }}</th>
                              </tr>
                              <tr v-for="(week, index) in item.weeks" :key="index">
                                 <td @click='buttonTableDatePicker(item.year, item.month, dayOfWeek.day )' :class='dayOfWeek.active == true ? "active" : ""' v-for="dayOfWeek in week" :key="dayOfWeek.day">
                                    <span>{{ dayOfWeek.day }}</span>
                                 </td>
                              </tr>
                           </table>
                        </div>
                        <div class='btn-getdate'>
                           <button @click='buttonApplyDate' class='button'>Apply</button>
                        </div>
                     </div>
                  </div>

                  <div class='time-table'>
                     <div v-show='datePickerTimePopup' class='dropdown-order size-half style-time-table right'>
                        <div class='dropdown-contents'>
                           <div v-for="(item, index) in dropdownTime" :key="index"
                              @click='button_get_data_delivery("once", null, "time", item.value)' 
                              class='dropdown-item'>
                                 {{ item.label }}
                           </div>
                        </div>
                     </div>
                  </div>

               </div>

            </div>

            <div class='group-tile'>
               <div class='form-check'>
                  <input @click='buttonDeliverySelectType("weekly")' :checked='getDeliverySelectType("weekly")' id='select_type02' type="radio" class='form-input'>
                  <label for='select_type02'>Delivery weekly</label>
               </div>

               <div class='deliverySelect_weekly' v-show='deliverySelectType.weekly'>
                  <div v-for='i in deliveryWeeklyDomIncrement' :key='i' class='deliverySelect_weekly_dom' :style="{ order: i }">
                     <div class='group-select-delivery-time style01 static'>
                        <button @click='button_open_DeliveryWeekly_day(i)' class='btn-dropdown'>
                           <span class='text'>{{ fill_value_to_texture_deliverySelect("weekly", i, "day", "Select day") }}</span>
                        </button>
                        <button @click='button_open_DeliveryWeekly_time(i)' class='btn-dropdown'>
                           <span class='text'>{{ fill_value_to_texture_deliverySelect("weekly", i, "time", "Select time") }}</span>
                        </button>
                     </div>

                     <div class='deliveryDisplay' :style="{ order : deliveryWeeklyOrder}">

                        <div v-show='deliverySelect_weekly_day' class='day-table'>
                           <div class='dropdown-order size-half style-day-table left'>
                              <div class='dropdown-contents'>
                                 <div 
                                    @click='button_get_data_delivery("weekly", deliveryWeeklyOrder, "day", item)' 
                                    v-for="(item, index) in dropdownDay" :key="index"
                                    class='dropdown-item'>
                                       {{ item }}
                                 </div>
                              </div>
                           </div>
                        </div>

                        <div v-show='deliverySelect_weekly_time' class='time-table'>
                           <div class='dropdown-order size-half style-time-table right'>
                              <div class='dropdown-contents'>
                                 <div 
                                    @click='button_get_data_delivery("weekly", deliveryWeeklyOrder, "time", item.value)' 
                                    v-for="(item, index) in dropdownTime" :key="index"
                                    class='dropdown-item'>
                                       {{ item.label }}
                                 </div>
                              </div>
                           </div>
                        </div>
                     </div>

                     <button @click='createDomDeliveryWeekly' class='button_add_delivery button_add_dom_delivery_weekly' style="order: 99999">Add Day</button>
                  </div>

               </div>
            </div>

            <div class='group-tile'>
               <div class='form-check'>
                  <input @click='buttonDeliverySelectType("monthly")' :checked='getDeliverySelectType("monthly")' id='select_type03' type="radio" class='form-input'>
                  <label for='select_type03'>Delivery mothly</label>
               </div>

               <div class='deliverySelect_monthly' v-show='deliverySelectType.monthly'>
                  
                  <div v-for='i in deliveryMonthlyDomIncrement' :key='i' class='deliverySelect_monthly_dom' :style="{ order: i }">
                     <div class='group-select-delivery-time'>
                        <button @click='button_open_DeliveryMonth_date(i)' class='btn-dropdown'>
                           <span class='text'>{{ fill_value_to_texture_deliverySelect("monthly", i, "date", "Select date") }}</span>
                        </button>
                        <button @click='button_open_DeliveryMonth_time(i)' class='btn-dropdown'>
                           <span class='text'>{{ fill_value_to_texture_deliverySelect("monthly", i, "time", "Select time") }}</span>
                        </button>
                     </div>
                  </div>

                  <div class='deliveryDisplay' :style="{ order : deliveryMonthlyOrder}">
                     <div v-show='popup_deliverySelect_monthly_time' class='time-table'>
                        <div class='dropdown-order size-half style-time-table right'>
                           <div class='dropdown-contents'>
                              <div 
                                 @click='button_get_data_delivery("monthly", deliveryMonthlyOrder, "time", item.value)' 
                                 v-for="(item, index) in dropdownTime" :key="index"
                                 class='dropdown-item'>
                                    {{ item.label }}
                              </div>
                           </div>
                        </div>
                     </div>

                     <div v-show='popup_deliverySelect_monthly_date' class='date-table'>
                        <div class='date-table-head'><div class='heading'>Everymonth</div></div>
                        <div class='date-table-contents'>
                           <table>
                              <tr v-for="row in 5" :key="row">
                                 <td v-for="col in 7" :key="col" :class="" 
                                    @click='button_get_data_delivery("monthly", deliveryMonthlyOrder, "date", countDayTable(row, col) )'>
                                    <span>{{ countDayTable(row, col) }}</span>
                                 </td>
                              </tr>
                           </table>
                        </div>
                        <div class='btn-getdate'><button @click='apply_DeliverySelect_monthly' class='button'>Apply</button></div>
                     </div>

                  </div>

                  <button @click='createDomDeliveryMonthly' class='button_add_delivery button_add_dom_delivery_weekly' style="order: 99999">Add Date</button>
               </div>

            </div>


         </div>


         <div class='break-line'></div>
         <div class='inner'>
            <p class='heading-02'>Payment method </p>
            <p>By Cash</p>
         </div>

         <div class='product-detailt-bottomsheet cell-placeorder'>
            <p class='price-total'>Total: <span class='t-primary t-bold'>{{ common_get_product_price(get_total_price_cart) }}</span></p>
            <button @click='buttonPlaceOrder' class='btn-primary' :class="isCanPlaceOrder == false ? 'disabled' : '' ">Place Order</button>
         </div>

   </div>
   `,
   data(){
      return {
         dropdownTime: [
            { label: '7:00  -  8:00', value: '7:00 - 8:00' },
            { label: '8:00  -  9:00', value: '8:00 - 9:00' },
            { label: '9:00  -  10:00', value: '9:00 - 10:00' },
            { label: '10:00  -  11:00', value: '10:00 - 11:00' },
            { label: '11:00  -  12:00', value: '11:00 - 12:00' },
            { label: '12:00  -  13:00', value: '12:00 - 13:00' },
            { label: '13:00  -  14:00', value: '13:00 - 14:00' },
            { label: '14:00  -  15:00', value: '14:00 - 15:00' },
            { label: '15:00  -  16:00', value: '15:00 - 16:00' },
            { label: '16:00  -  17:00', value: '16:00 - 17:00' },
            { label: '17:00  -  18:00', value: '17:00 - 18:00' },
            { label: '18:00  -  19:00', value: '18:00 - 19:00' },
            { label: '19:00  -  20:00', value: '19:00 - 20:00' },
            { label: '20:00  -  21:00', value: '20:00 - 21:00' }
         ],

         dropdownDay: ['Monday','Tueday','Wednesday','Thursday','Friday','Saturday','Sunday'],

         select_delivery_time: '',

         product_order_delivery_time_once: [
            { id: 0, active: false },
            { id: 1, active: false },
         ],

         product_order_select_date: null,
         product_order_select_day: null,
         product_order_select_time: null,

         datePickerDatePopup: false,
         datePickerTimePopup: false,

         deliverySelectType: {
            once: false,
            timeOnce: {
               immediately: false,
               selectDate: false,
            },
            weekly: false,
            monthly: false,
         },

         deliveryWeeklyDomIncrement: 0,
         deliveryWeeklyOrder: 0,

         deliveryMonthlyDomIncrement: 0,
         deliveryMonthlyOrder: 0,
         deliveryEverymonthOrder: 0,

         deliverySelect_weekly_day: false,
         deliverySelect_weekly_time: false,
         popup_deliverySelect_monthly_date: false,
         popup_deliverySelect_monthly_time: false,

         deliveryTimeData: {
            once: {
               date: null,
               time: null
            },
            weekly: [],
            monthly: []
         },

         currentDate: new Date(),
         currentMonthIndex: 0,
         currentMonthName: '',
         months: ['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'],
         daysOfWeek: ['Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat', 'Sun'],
         calendarData: [],



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

      

      countDayTable(row, col) {return (row - 1) * 7 + col; },

      activeDayTable(row, col){},

      button_get_data_delivery( type, id, whichTable, data ){
         if( type == "once" ){
            if( whichTable == "time" ){
               this.deliveryTimeData.once.time = data;
            }
         }
         if( type == "weekly"){
            //add new
            if( this.deliveryTimeData.weekly[id] == undefined || this.deliveryTimeData.weekly[id] == null ){
               var obj = { id: id, type: type, day: null, time: null };
               if( whichTable == "day" ){ obj.day = data; }
               if( whichTable == "time" ){ obj.time = data; }
               this.deliveryTimeData.weekly[id] = obj;
            }else{
            // edit
               if( whichTable == "day" ){ this.deliveryTimeData.weekly[id].day = data; }
               if( whichTable == "time" ){ this.deliveryTimeData.weekly[id].time = data; }
            }
         }
         if( type == "monthly" ){
            //add new
            if( this.deliveryTimeData.monthly[id] == undefined || this.deliveryTimeData.monthly[id] == null ){
               var obj = { id: id, type: type, date: null, time: null };
               if( whichTable == "date" ){ obj.date = data; this.deliveryEverymonthOrder = data; }
               if( whichTable == "time" ){ obj.time = data; }
               this.deliveryTimeData.monthly[id] = obj;
            }else{
            // edit
               if( whichTable == "date" ){ this.deliveryTimeData.monthly[id].date = data; this.deliveryEverymonthOrder = data; }
               if( whichTable == "time" ){ this.deliveryTimeData.monthly[id].time = data; }
            }
            // HIDDEN OTHER CELL
            if( whichTable == 'time' ){
               this.popup_deliverySelect_monthly_time = false;
            }
         }


         console.log(this.deliveryTimeData);
      },

      get_total_price( price, quantity, discount){
         if( discount != null || discount != undefined){
            var getPriceDiscount = price - ( price * ( discount / 100 ) );
            return quantity * getPriceDiscount;
         }else{
            return quantity * price;
         }
      },

      get_product_quantity( product ){
         if(product.product_type == "water" ) return product.quantity;
         if(product.product_type == "ice" ) return product.weight + "kg " + product.length_width + "mm";
      },

      get_total_price_cart(){
         var _total = 0;
         /*
         if(this.$root.carts.length > 0 ){
            return this.$root.carts.forEach((item) => {
               var _total = 0;
               if( item.product_discount != null ){
                  _total =+ item.product_quantity_count * ( item.product_price - ( item.product_price * ( item.product_discount / 100 ) ) );
               }else{
                  _total =+ item.product_quantity_count * item.product_price;
               }
               console.log(_total);
               return _total;
            });
         }
         */
         if( this.$root.carts.length > 0 ){
            this.$root.carts.forEach((item) => {

            });
         }
         return _total;
      },

      has_discount( product ){
         if( product.discount_id == null ) return false;
         return true;
      },

      common_get_product_price( price, discount_percent ){
         if( discount_percent == undefined || discount_percent == null || discount_percent == 0){
            return parseInt(price).toLocaleString('vi-VN') + ' đ';
         }
         var _price = price - ( price * ( discount_percent / 100 ) );
         if( _price == 0 ) return 0 + ' đ';
         return parseInt(_price).toLocaleString('vi-VN') + ' đ';
      },

      buttonDeliverySelectTypeTimeOnce( type ){
         this.resetDeliveryDataWeekly();
         this.resetDeliveryDataMonthly();
         if( type == 'immediately' ){
            // this.deliveryTimeData
            if( this.deliverySelectType.timeOnce.immediately == true ){
               this.deliverySelectType.timeOnce.immediately = false
            }else{
               this.deliverySelectType.timeOnce.immediately = true;
            }
            this.deliverySelectType.timeOnce.selectDate = false;
         }
         if( type == 'selectDate'){
            if( this.deliverySelectType.timeOnce.selectDate == true ){
               this.deliverySelectType.timeOnce.selectDate = false
            }else{
               this.deliverySelectType.timeOnce.selectDate = true;
            }
            this.deliverySelectType.timeOnce.immediately = false;
         }
      },

      buttonDeliverySelectTypeTimeOnce( type ){
         this.resetDeliveryDataWeekly();
         this.resetDeliveryDataMonthly();
         if( type == 'immediately' ){
            // this.deliveryTimeData
            if( this.deliverySelectType.timeOnce.immediately == true ){
               this.deliverySelectType.timeOnce.immediately = false
            }else{
               this.deliverySelectType.timeOnce.immediately = true;
            }
            this.deliverySelectType.timeOnce.selectDate = false;
         }
         if( type == 'selectDate'){
            if( this.deliverySelectType.timeOnce.selectDate == true ){
               this.deliverySelectType.timeOnce.selectDate = false
            }else{
               this.deliverySelectType.timeOnce.selectDate = true;
            }
            this.deliverySelectType.timeOnce.immediately = false;
         }
      },

      /**
       * @access DATE FUNCTION
       */
      currentMonth() { return this.months[this.currentMonthIndex]; },
      // isPrevMonthDisabled() { return this.currentMonthIndex === 0; },

      generateCalendar(year, month) {
         var firstDayOfMonth = new Date(year, month, 1).getDay();
         var lastDateOfMonth = new Date(year, month + 1, 0).getDate();

         firstDayOfMonth = (firstDayOfMonth === 0 ? 7 : firstDayOfMonth) - 1;

         let date = 1;
         var weeks = [];
         var numWeeks = Math.ceil((lastDateOfMonth + firstDayOfMonth) / 7);
         for (let i = 0; i < numWeeks; i++) {
            var week = [];
            for (let j = 0; j < 7; j++) {
               if (i == 0 && j < firstDayOfMonth || date > lastDateOfMonth) {
                  week.push({ day: '' });
               } else {
                  week.push({ day: date, active: false });
                  date++;
               }
            }
            weeks.push(week);
         }
         return {
            year: year,
            month: this.months[month],
            weeks: weeks
         }; 
      },
      
      getCurrentMonth() { this.currentMonthName = this.calendarData[this.currentMonthIndex].month;},
      nextMonth() {          
         this.getCurrentMonth();
         var _lastIndex = this.calendarData.length - 1;
         if( this.currentMonthIndex != _lastIndex ){
            this.currentMonthIndex++; 
         }else{
            var currentYear = this.currentDate.getFullYear();
            var currentMonth = this.currentDate.getMonth();
         }
      },

      prevMonth() { this.currentMonthIndex--; this.getCurrentMonth(); },

      buttonApplyDate(){this.datePickerDatePopup = false; },

      buttonSelectDate(){
         this.datePickerTimePopup = false;
         if( this.datePickerDatePopup == true){
            this.datePickerDatePopup = false;
         }else{
            this.datePickerDatePopup = true;
         }
      },

      buttonSelectTime(){
         this.datePickerDatePopup = false;
         if( this.datePickerTimePopup == true){
            this.datePickerTimePopup = false;
         }else{
            this.datePickerTimePopup = true;
         }
      },

      buttonTableDatePicker(year, month, day){
         if( day != ''){
            this.calendarData.forEach( ( date, keyDate ) => {
               if( year == date.year && month == date.month){
                  date.weeks.forEach( (week, keyWeek ) => {
                     week.forEach( (dayOfWeek, keyDay ) => {
                        if( dayOfWeek.day == day ){
                           this.calendarData[keyDate].weeks[keyWeek][keyDay].active = true;
                        }else{
                           this.calendarData[keyDate].weeks[keyWeek][keyDay].active = false;  
                        }
                     });
                  });
               }
            });
            // SAVE 
            var month = this.months.indexOf(month);
            this.deliveryTimeData.once.date = `${day}/${month}/${year}`;
         }
      },

      buttonDeliverySelectType( type ){
         this.deliverySelectType.once     = false;
         this.deliverySelectType.weekly   = false;
         this.deliverySelectType.monthly  = false;

         if(type == "once" ){
            this.deliverySelectType.once = true;
            this.resetDeliveryDataWeekly();
            this.resetDeliveryDataMonthly();
         }

         // CREATE DOM FOR WEEKLY - MONTHLY
         if( type == 'weekly'){
            this.deliverySelectType.weekly = true;
            this.resetDeliveryDataMonthly();
            this.resetDeliveryDataOnce();
            if( this.deliveryWeeklyDomIncrement < 1){
               this.deliveryWeeklyDomIncrement++;
            }
         }

         if( type == "monthly" ){
            this.deliverySelectType.monthly = true;
            this.resetDeliveryDataWeekly();
            this.resetDeliveryDataOnce();
            if( this.deliveryMonthlyDomIncrement < 1 ){
               this.deliveryMonthlyDomIncrement++;
            }
         }

         // console.log('bugging deliverySelectType');
         // console.log(this.deliverySelectType);
      },

      button_open_DeliveryMonth_date( i ){
         this.deliveryMonthlyOrder = i;
         if( this.deliveryTimeData.monthly[i] != undefined || this.deliveryTimeData.monthly[i] != null ){
            if( this.deliveryTimeData.monthly[i].date != null ){
               this.deliveryEverymonthOrder = this.deliveryTimeData.monthly[i].date;
            }
         }else{
            this.deliveryEverymonthOrder = 0;
         }

         if( this.popup_deliverySelect_monthly_date == true ){
            this.popup_deliverySelect_monthly_date = false;
         }else{
            this.popup_deliverySelect_monthly_date = true;
            this.popup_deliverySelect_monthly_time = false;
         }
      },

      button_open_DeliveryMonth_time( i){
         this.deliveryMonthlyOrder = i;
         if( this.popup_deliverySelect_monthly_time == true ){
            this.popup_deliverySelect_monthly_time = false;
         }else{
            this.popup_deliverySelect_monthly_time = true;
            this.popup_deliverySelect_monthly_date = false;
         }
      },

      button_open_DeliveryWeekly_day(i){
         this.deliveryWeeklyOrder = i;
         if( this.deliverySelect_weekly_day == true ){
            this.deliverySelect_weekly_day = false;
         }else{
            this.deliverySelect_weekly_day = true;
            this.deliverySelect_weekly_time = false;
         }
      },
      button_open_DeliveryWeekly_time(i){
         this.deliveryWeeklyOrder = i;
         if( this.deliverySelect_weekly_time == true ){
            this.deliverySelect_weekly_time = false;
         }else{
            this.deliverySelect_weekly_time = true;
            this.deliverySelect_weekly_day = false;
         }
      },
      

      // HIDDEN OTHER CELL
      apply_DeliverySelect_monthly(){ this.popup_deliverySelect_monthly_date = false; },

      fill_value_to_texture_deliverySelect(type, id, whichTable, text_default){
         if( type == "weekly"){
            if( this.deliveryTimeData.weekly[id] == undefined || this.deliveryTimeData.weekly[id] == null ){
               return text_default;
            }
            if( whichTable == "day"){
               return this.deliveryTimeData.weekly[id].day != null ? this.deliveryTimeData.weekly[id].day : text_default;
            }
            if( whichTable == "time"){
               return this.deliveryTimeData.weekly[id].time != null ? this.deliveryTimeData.weekly[id].time : text_default;
            }
         }
         if( type == "monthly" ){
            if( this.deliveryTimeData.monthly[id] == undefined || this.deliveryTimeData.monthly[id] == null ){
               return text_default;
            }
            if( whichTable == "date"){
               return this.deliveryTimeData.monthly[id].date != null ? this.deliveryTimeData.monthly[id].date : text_default;
            }
            if( whichTable == "time"){
               return this.deliveryTimeData.monthly[id].time != null ? this.deliveryTimeData.monthly[id].time : text_default;
            }
         }
      },

      resetDeliveryDataOnce(){
         this.deliveryTimeData.once.date = null;
         this.deliveryTimeData.once.time = null;
         this.deliveryTimeData.once.immediately = false;
         this.deliveryTimeData.once.selectDate = false;
      },

      resetDeliveryDataWeekly(){
         this.deliveryWeeklyDomIncrement = 0;
         this.deliveryTimeData.weekly = [];
      },
      resetDeliveryDataMonthly(){
         this.deliveryEverymonthOrder = 0;
         this.deliveryMonthlyDomIncrement = 0;
         this.deliveryTimeData.monthly = [];
      },

      createDomDeliveryWeekly(){ this.deliveryWeeklyDomIncrement++; },
      createDomDeliveryMonthly(){ this.deliveryMonthlyDomIncrement++; },

      getDeliverySelectType( selectType ){
         for (let prop in this.deliverySelectType) {
            if (prop === selectType && this.deliverySelectType[selectType] == true ) return true;
         }
         return false;
      },

      load_product_in_cart( store_id ){
         var _cart = [];
         this.$root.stores.forEach((store) => {
            if( store.id == store_id ){
               store.carts.forEach(( cart ) => {
                  var _lookupProduct = store.products.find(product => product.id == cart);
                  if( _lookupProduct !== undefined ){
                     _cart.push(_lookupProduct);
                  }
               });
            }
         });
         return _cart;
      },


   },
   computed: {
      isPrevMonthDisabled() {
         return this.currentMonthIndex === 0;
      },

      getCurrentMonthData(){
         var _currentDay = this.currentDate.getUTCDate();
         var _currentYear = this.currentDate.getFullYear();
         var _currentMonth = this.currentDate.getMonth();
         var _calendar = { data: this.calendarData[this.currentMonthIndex] };
         _calendar.data.weeks.forEach((week, weekIndex) => {
            week.forEach((day, dayIndex) => {
               if (day.day == _currentDay && _calendar.data.year == _currentYear && _calendar.data.month == this.months[_currentMonth]) {
               _calendar.data.weeks[weekIndex][dayIndex].active = true;
               } else {
               _calendar.data.weeks[weekIndex][dayIndex].active = false;
               }
            });
         });
         return _calendar;
      },

   },
   async created(){
      // console.log( this.$refs.page_delivery_address);

      // BUILD CARLENDAR
      var currentYear = this.currentDate.getFullYear();
      var currentMonth = this.currentDate.getMonth();
      // console.log('CURRENT MONTH ' + currentMonth);
      for (let i = currentMonth; i < 12; i++) {
         var year = i >= currentMonth ? currentYear : currentYear + 1;
         var obj = this.generateCalendar(year, i);
         this.calendarData.push(obj);
      }
      this.getCurrentMonth();

      // var _currentDay = this.currentDate.getUTCDate();
      // var _currentYear = this.currentDate.getFullYear();
      // var _currentMonth = this.currentDate.getMonth()
   },
   update(){

      if(this.$refs.page_delivery_address.delivery_address != undefined ){
         console.log( this.$refs.page_delivery_address.delivery_address);
      }

   },
   mounted(){
   }

};