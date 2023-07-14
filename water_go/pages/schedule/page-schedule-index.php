<link rel="stylesheet" href="//code.jquery.com/ui/1.13.2/themes/base/jquery-ui.css">
<script src="https://code.jquery.com/ui/1.13.2/jquery-ui.js"></script>


<div id='app'>

   <div v-show='loading == false'>
      <div class='page-schedule'>

         <div class='appbar'>
            <div class='appbar-top'>
               <div class='leading'>
                  <p class='leading-title'>Schedule</p>
               </div>
               <div class='action'>
                  
                  <div @click='gotoChat' class='btn-badge ml10'>
                     <svg width="23" height="20" viewBox="0 0 23 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                     <path fill-rule="evenodd" clip-rule="evenodd" d="M15.6817 0H3.40384C2.58977 0 1.80904 0.334446 1.2334 0.929764C0.657759 1.52508 0.33437 2.33251 0.33437 3.17441V9.52324C0.33437 9.94011 0.413763 10.3529 0.568018 10.738C0.722275 11.1232 0.94837 11.4731 1.2334 11.7679C1.51842 12.0627 1.8568 12.2965 2.22921 12.456C2.60161 12.6155 3.00076 12.6977 3.40384 12.6977H5.24553H9.79695H15.6817C16.4958 12.6977 17.2766 12.3632 17.8522 11.7679C18.4278 11.1726 18.7512 10.3652 18.7512 9.52324V3.17441C18.7512 2.33251 18.4278 1.52508 17.8522 0.929764C17.2766 0.334446 16.4958 0 15.6817 0ZM15.6817 1.26977H3.40384C2.9154 1.26977 2.44696 1.47043 2.10158 1.82762C1.75619 2.18482 1.56216 2.66927 1.56216 3.17441V9.52324C1.56216 10.0284 1.75619 10.5128 2.10158 10.87C2.44696 11.2272 2.9154 11.4279 3.40384 11.4279H15.6817C16.1702 11.4279 16.6386 11.2272 16.984 10.87C17.3294 10.5128 17.5234 10.0284 17.5234 9.52324V3.17441C17.5234 2.66927 17.3294 2.18482 16.984 1.82762C16.6386 1.47043 16.1702 1.26977 15.6817 1.26977Z" fill="#2790F9"/>
                     <path d="M3.40384 1.26977H15.6817C16.1702 1.26977 16.6386 1.47043 16.984 1.82762C17.3294 2.18482 17.5234 2.66927 17.5234 3.17441V9.52324C17.5234 10.0284 17.3294 10.5128 16.984 10.87C16.6386 11.2272 16.1702 11.4279 15.6817 11.4279H3.40384C2.9154 11.4279 2.44696 11.2272 2.10158 10.87C1.75619 10.5128 1.56216 10.0284 1.56216 9.52324V3.17441C1.56216 2.66927 1.75619 2.18482 2.10158 1.82762C2.44696 1.47043 2.9154 1.26977 3.40384 1.26977Z" fill="white"/>
                     <path fill-rule="evenodd" clip-rule="evenodd" d="M19.0577 4.76165H6.7798C6.29136 4.76165 5.82292 4.96232 5.47753 5.31951C5.13215 5.6767 4.93812 6.16115 4.93812 6.6663V13.0151C4.93812 13.5203 5.13215 14.0047 5.47753 14.3619C5.82292 14.7191 6.29136 14.9198 6.7798 14.9198H12.9188C12.9994 14.9196 13.0793 14.9359 13.1539 14.9677C13.2285 14.9995 13.2963 15.0462 13.3534 15.1052L15.9882 17.8313V15.5547C15.9882 15.3863 16.0529 15.2248 16.168 15.1057C16.2832 14.9867 16.4393 14.9198 16.6021 14.9198H19.0577C19.5461 14.9198 20.0146 14.7191 20.36 14.3619C20.7054 14.0047 20.8994 13.5203 20.8994 13.0151V6.6663C20.8994 6.16115 20.7054 5.6767 20.36 5.31951C20.0146 4.96232 19.5461 4.76165 19.0577 4.76165ZM6.7798 3.49188H19.0577C19.8718 3.49188 20.6525 3.82633 21.2282 4.42165C21.8038 5.01696 22.1272 5.82439 22.1272 6.6663V13.0151C22.1272 13.432 22.0478 13.8448 21.8935 14.2299C21.7393 14.6151 21.5132 14.965 21.2282 15.2598C20.9431 15.5545 20.6047 15.7884 20.2323 15.9479C19.8599 16.1074 19.4608 16.1895 19.0577 16.1895H17.216V19.364C17.2162 19.4897 17.1804 19.6127 17.1129 19.7173C17.0455 19.8219 16.9495 19.9034 16.8372 19.9516C16.7249 19.9997 16.6013 20.0123 16.4821 19.9877C16.3628 19.9631 16.2533 19.9025 16.1675 19.8135L12.6646 16.1895H6.7798C5.96573 16.1895 5.18499 15.8551 4.60936 15.2598C4.03372 14.6645 3.71033 13.857 3.71033 13.0151V6.6663C3.71033 5.82439 4.03372 5.01696 4.60936 4.42165C5.18499 3.82633 5.96573 3.49188 6.7798 3.49188Z" fill="#2790F9"/>
                     <path d="M19.0577 4.76165H6.7798C6.29136 4.76165 5.82292 4.96232 5.47753 5.31951C5.13215 5.6767 4.93812 6.16115 4.93812 6.6663V13.0151C4.93812 13.5203 5.13215 14.0047 5.47753 14.3619C5.82292 14.7191 6.29136 14.9198 6.7798 14.9198H12.9188C12.9994 14.9196 13.0793 14.9359 13.1539 14.9677C13.2285 14.9995 13.2963 15.0462 13.3534 15.1052L15.9882 17.8313V15.5547C15.9882 15.3863 16.0529 15.2248 16.168 15.1057C16.2832 14.9867 16.4393 14.9198 16.6021 14.9198H19.0577C19.5461 14.9198 20.0146 14.7191 20.36 14.3619C20.7054 14.0047 20.8994 13.5203 20.8994 13.0151V6.6663C20.8994 6.16115 20.7054 5.6767 20.36 5.31951C20.0146 4.96232 19.5461 4.76165 19.0577 4.76165Z" fill="white"/>
                     <path d="M10.4639 9.32349C10.4639 9.70494 10.1546 10.0142 9.77319 10.0142C9.39174 10.0142 9.08252 9.70494 9.08252 9.32349C9.08252 8.94204 9.39174 8.63282 9.77319 8.63282C10.1546 8.63282 10.4639 8.94204 10.4639 9.32349Z" fill="#2790F9"/>
                     <path d="M13.5947 9.30974C13.5947 9.69118 13.2855 10.0004 12.904 10.0004C12.5226 10.0004 12.2133 9.69118 12.2133 9.30974C12.2133 8.92829 12.5226 8.61906 12.904 8.61906C13.2855 8.61906 13.5947 8.92829 13.5947 9.30974Z" fill="#2790F9"/>
                     <path d="M16.7027 9.3235C16.7027 9.70494 16.3935 10.0142 16.012 10.0142C15.6306 10.0142 15.3214 9.70494 15.3214 9.3235C15.3214 8.94205 15.6306 8.63282 16.012 8.63282C16.3935 8.63282 16.7027 8.94205 16.7027 9.3235Z" fill="#2790F9"/>
                     </svg>
                     <span v-if='message_count > 0' class='badge'>{{message_count}}</span>
                  </div>

                  <div @click='gotoNotificationIndex' class='btn-badge ml10'>
                     <svg width="19" height="20" viewBox="0 0 19 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                     <path d="M16.1176 14.6055C16.577 15.3164 17.1289 15.9629 17.7587 16.5281V17.2473H0.826953V16.5278C1.44914 15.9599 1.99356 15.3122 2.44603 14.6015L2.46376 14.5737L2.47879 14.5443C2.99231 13.5401 3.30009 12.4435 3.38408 11.3188L3.38602 11.2928V11.2667L3.38602 8.22777L3.38602 8.22636C3.38312 6.7874 3.9018 5.39615 4.84599 4.31028C5.79017 3.22441 7.09589 2.51751 8.5213 2.32051L9.12547 2.23701V1.6271V0.821239C9.12547 0.789084 9.13824 0.758246 9.16098 0.735511C9.18371 0.712773 9.21455 0.7 9.24671 0.7C9.27886 0.7 9.3097 0.712773 9.33243 0.735509C9.35517 0.758248 9.36795 0.789086 9.36795 0.821239V1.6148V2.23105L9.97923 2.30915C11.4175 2.49291 12.7392 3.19556 13.696 4.28509C14.6527 5.37462 15.1787 6.77603 15.1751 8.22601V8.22777V11.2667V11.2928L15.177 11.3188C15.261 12.4435 15.5688 13.5401 16.0823 14.5443L16.0984 14.5758L16.1176 14.6055Z" stroke="#2790F9" stroke-width="1.4"/>
                     <path d="M7.67493 18.5933C7.72887 18.9832 7.92209 19.3404 8.21891 19.599C8.51572 19.8576 8.89607 20 9.28972 20C9.68337 20 10.0637 19.8576 10.3605 19.599C10.6574 19.3404 10.8506 18.9832 10.9045 18.5933H7.67493Z" fill="#2790F9"/>
                     </svg>
                     <span v-if='notification_count > 0' class='badge'>{{notification_count}}</span>
                  </div>

               </div>
            </div>
            <div class='appbar-bottom'>

               <ul id='schedule-bar' class='navbar style02 schedule-bar'>

                  <li @click='select_schedule_status_filter("all")' :class='schedule_status_value == "all" ? "active" : "" '>All</li>
                  <li @click='select_schedule_status_filter("once")' :class='schedule_status_value == "once" ? "active" : ""'>Delivery Once</li>
                  <li @click='select_schedule_status_filter("weekly")' :class='schedule_status_value == "weekly" ? "active" : ""'>Delivery Weekly</li>
                  <li @click='select_schedule_status_filter("monthly")' :class='schedule_status_value == "monthly" ? "active" : ""'>Delivery Monthly</li>
               </ul>
               
               <div class='order-store-header style01 border-bottom-large ' stlye=''>
                  <div class='datepicker-wrapper'>
                     <input @click='datePicker(true)' ref='datepicker' id='datepicker' class='btn-filter-date-picker btn-datepicker' disable>
                     <span class='icon-dropdown'></span>
                  </div>
                  <div class='count-order'>Total order: <span>{{ get_total_orders_count }}</span></div>
               </div>

            </div>
         </div>

         <div
            class='order-item-container'
            v-for='(order, index) in filter_order'
            :key='index'
            @click='gotoScheduleOrderDetail(order.order_id)'
         >

            <div class='order-item-title-container'>
               <div class='order-item-title-container-tile01'>
                  <h3 class='order-title'>Order #{{ order.order_number}}</h3>
                  <h3 class='order-type text-order-type' 
                     :class="get_type_order(order.order_delivery_type)"
                  >{{print_type_order_text(order.order_delivery_type)}}</h3>
               </div>

               <div class='order-item-title-container-tile02'>
                  <p v-if="order.order_delivery_type == 'once_immediately' " class='text-xsm'>Delivery Immediately </p>

                  <p 
                     v-if="order.order_delivery_type == 'once_date_time'"
                     class='text-xsm'>Delivery on {{order.order_time_shipping.order_time_shipping_day}} </p>
                  <p 
                     v-if="order.order_delivery_type == 'weekly'"
                     class='text-xsm'>Delivery on {{order.order_time_shipping.order_time_shipping_day}} | {{ order.order_time_shipping.order_time_shipping_datetime }}</p>
                  <p 
                     v-if="order.order_delivery_type == 'monthly'"
                     class='text-xsm'>Delivery on {{order.order_time_shipping.order_time_shipping_day}} | {{ order.order_time_shipping.order_time_shipping_datetime }}</p>
               </div>


            </div>
            <div class='order-item-discount text-sm'>
               <p>{{ total_product_in_order( order )}} products</p>
               <p>Total: <span class='text-price'>{{ total_product_price_in_order(order) }}</span></p>
               <p v-if='order.address_kilometer > 0'>{{ order.address_kilometer }}km</p>
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

<script>

var { createApp } = Vue;

createApp({
   data (){
      return {

         loading: false,
         message_count: 0,
         notification_count: 0,
         currentDate: new Date(),
         
         schedule_status_value: 'all',
         current_date_timestamp: 0,

         orders: [],

         datePickerValue: null,

      }
   },

   methods: {

      gotoNotificationIndex(){ window.gotoNotificationIndex()},
      gotoChat(){ window.gotoChat() },
      gotoScheduleOrderDetail( id) { window.gotoScheduleOrderDetail(id) },
      common_get_product_price( price, discount_percent ){ return window.common_get_product_price( price, discount_percent ); },
      get_image_upload(i){ return window.get_image_upload(i) },
      get_type_order(order_type){ return window.get_type_order(order_type)},
      print_type_order_text(order_type){ return window.print_type_order_text(order_type)},


      async get_notification_count(){
         var form = new FormData();
         form.append('action', 'atlantis_notification_count');
         var r = await window.request(form);
         if( r != undefined ){
            var res = JSON.parse( JSON.stringify(r));
            if(res.message == 'notification_found' ){
               this.notification_count = res.data;
            }
         }
      },

      async get_messages_count(){
         var form_message_count = new FormData();
         form_message_count.append('action', 'atlantis_count_messages');
         var _atlantis_message = await window.request(form_message_count);
         if( _atlantis_message != undefined ){
            let res = JSON.parse( JSON.stringify( _atlantis_message));
            if( res.message == 'message_count_found' ){
               this.message_count = parseInt(res.data);
            }
         }
      },

      async getOrderNumber( order_id ){
         var form = new FormData();
         form.append('action', 'atlantis_get_order_number');
         form.append('order_id', order_id);
         var r = await window.request(form);
         if( r != undefined ){
            var res = JSON.parse( JSON.stringify( r ));
            if( res.message == 'get_order_number_ok'){
               return res.data;
            }
         }
      },

      total_product_in_order( order ){
         return order.order_products != undefined && order.order_products.length > 0 ? order.order_products.length : 0;
      },

      total_product_price_in_order( order ){
         var _total_price = 0;
         order.order_products.forEach( product => {
            var discount_percent = parseInt(product.order_group_product_discount_percent);
            var price            = parseInt(product.order_group_product_price);
            var quantity         = parseInt(product.order_group_product_quantity_count);

            if( discount_percent == undefined || discount_percent == null || discount_percent == 0){
               _total_price += price;
            }else{
               discount_percent = 10; // vi du 10%
               _total_price += price - ( price * ( discount_percent / 100 ) );
            }
            _total_price = _total_price * quantity;
         });
         return _total_price.toLocaleString('vi-VN') + ' đ';;
      },

      save_datetime_from_datepicker(){
         if( this.$refs.datepicker.value == undefined || this.$refs.datepicker.value == null || this.$refs.datepicker.value == ''){
            this.datePickerValue = window.timestamp_to_date( new Date().getTime() / 1000 );
         }else{
            this.datePickerValue = this.$refs.datepicker.value;
         }
      },

      async select_schedule_status_filter(filter_selected){

         this.schedule_status_value = filter_selected;
         if( filter_selected == 'all' ){
            this.save_datetime_from_datepicker();
            this.orders = [];
            this.loading = true;
            await this.schedule_load_product('all', this.datePickerValue, [0]);
            this.loading = false;
         }
         if( filter_selected == 'once' ){
            this.orders = [];
            this.save_datetime_from_datepicker();
            this.loading = true;
            await this.schedule_load_product('once', this.datePickerValue, [0]);
            this.loading = false;
         }
         if( filter_selected == 'weekly' ){
            this.orders = [];
            this.save_datetime_from_datepicker();
            this.loading = true;
            await this.schedule_load_product('weekly', this.datePickerValue, [0]);
            this.loading = false;
         }
         if( filter_selected == 'monthly' ){
            this.orders = [];
            this.save_datetime_from_datepicker();
            this.loading = true;
            await this.schedule_load_product('monthly', this.datePickerValue, [0]);
            this.loading = false;
         }

      },

      datePicker(isPicker){
         (function($){

            $(document).ready(function(){

               $('.ui-date-picker-wrapper').addClass('active');
               
               $('#datepicker').datepicker({
                  dayNamesMin: [ "Sun", "Mon", "Tue", "Wed", "Thu", "Fri", "Sat" ],
                  onSelect: function(dateText, inst){
                     if(dateText != undefined || dateText != '' || dateText != null){
                        $('#datepicker').attr('value', dateText); 
                     }
                  },
                  onClose: function(dateText, inst){
                     $('.ui-date-picker-wrapper').removeClass('active');
                  }
               });

               if( $('#datepicker').val().length == 0 ){
                  $('#datepicker').datepicker('setDate', new Date() );
               }

               // add wrapper for picker
               if( $('.ui-date-picker-wrapper #ui-datepicker-div').length == 0 ){
                  $('#ui-datepicker-div').wrap('<div class="ui-date-picker-wrapper"></div>');
               }
            });

         })(jQuery);

         this.save_datetime_from_datepicker();

         if( isPicker == true ){
            var query = document.querySelectorAll('#ui-datepicker-div a.ui-state-default');

            for (let i = 0; i < query.length; i++) {
               query[i].addEventListener("mousedown", () => {
                  setTimeout(() => {
                     var _getDatePicker = $('#datepicker').val();
                     this.orders = [];
                     this.loading = true;
                     this.schedule_load_product(this.schedule_status_value, _getDatePicker, [0])
                        .then(() => {
                           this.loading = false;
                        })
                        .catch((error) => {
                           console.error(error);
                           this.loading = false;
                        });
                  }, 0);
               });
            }
         }

         

      },


      async schedule_load_product(filter, datetime, product_id_already_exists){
         
         if( product_id_already_exists == undefined || product_id_already_exists == null ){
            product_id_already_exists = [0];
         }

         var form = new FormData();
         form.append('action', 'atlantis_get_order_schedule');
         form.append('filter', filter);
         form.append('datetime', 0);
         form.append('product_id_already_exists', JSON.stringify( product_id_already_exists ) );
         form.append('datetime', String( datetime) );
         var r = await window.request(form);
         console.log(r);
         if( r != undefined ){
            var res = JSON.parse( JSON.stringify( r ));
            if( res.message == 'get_order_ok' ){

               res.data.forEach(item => {
                  if (!this.orders.some(existingItem => existingItem.order_id === item.order_id)) {
                     var _store_lat = item.store_latitude;
                     var _store_lng = item.store_longitude;
                     var _user_lat  = item.order_delivery_address.latitude;
                     var _user_lng  = item.order_delivery_address.longitude;
                     item.address_kilometer = window.calculateDistance(_store_lat, _store_lng, _user_lat, _user_lng);
                     if(item.address_kilometer > 0 ){
                        item.address_kilometer = parseFloat( item.address_kilometer ).toPrecision(2);
                     }
                     this.orders.push(item);
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
            
            var product_id_already_exists = [];
            
            this.orders.forEach(item => {
               product_id_already_exists.push( parseInt( item.order_id ) );
            });

            await this.schedule_load_product(this.schedule_status_value, this.datePickerValue, product_id_already_exists );
         }
      },


   },

   

   async created(){

      this.loading = true;
      await this.get_messages_count();
      var _currentDate = window.timestamp_to_date(new Date().getTime() / 1000 );
      await this.schedule_load_product('all', _currentDate, [0]);

      $.datepicker.setDefaults({
         minDate: 0,
         dateFormat: "dd/mm/yy",
         firstDay: 1,
      });

      await this.datePicker();
      window.appbar_fixed();

      this.loading = false;

   },

   mounted() {
      window.addEventListener('scroll', this.handleScroll);
   },
   beforeDestroy() {
      window.removeEventListener('scroll', this.handleScroll);
   },

   computed: {
      filter_order(){
         return this.orders.sort((a, b) => b.order_time_confirmed - a.order_time_confirmed );
      },
      get_total_orders_count(){ return this.orders.length }
   },


})
.mount('#app');
</script>


