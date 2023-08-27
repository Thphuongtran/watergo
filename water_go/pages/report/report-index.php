<div id='app'>

   <div v-show='loading == false ' class='page-report'>
      <div class='appbar style01'>
         <div class='appbar-top'>
            <div class='leading'>

               <div class='leading-title'>
                  <?php echo __('Report', 'watergo'); ?>

                  <div class='datetime-wrapper'>
                     
                     <button @click='datepicker' v-show='filter_datetime[0].active' class='datetime-display datetime-report '>
                        <input id='datepicker' readonly><span>{{ display_datetime }}</span>
                     </button>

                     <span @click='btn_select_month' v-show='filter_datetime[1].active' class='datetime-display'>{{display_datemonth}}</span>
                     <span @click='btn_select_year' v-show='filter_datetime[2].active' class='datetime-display'>{{display_dateyear}}</span>

                     <ul v-show='open_datemonth ' class='dropdown-datetime'>
                        <li
                           @click='select_datemonth(date)'
                           v-for='( date, keyMonth) in getPastMonthsInCurrentYears ' :key='keyMonth'
                        >
                           {{ addZeroLeading(date) }}/{{currentYear}}
                        </li>
                     </ul>

                     <ul v-show='open_dateyear' class='dropdown-datetime'>
                        <li @click='select_dateyear(2022)'>2022</li>
                        <li @click='select_dateyear(2023)'>2023</li>
                     </ul>

                     <div class='icon'>
                        <svg width="10" height="6" viewBox="0 0 10 6" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M1 1L5 5L9 1" stroke="#252831" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                        </svg>
                     </div>

                  </div>
               </div>

            </div>
            <div class='action'>

               <!-- <div @click='gotoChat' class='btn-badge ml10'>
                  <svg width="23" height="20" viewBox="0 0 23 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                  <path fill-rule="evenodd" clip-rule="evenodd" d="M15.6817 0H3.40384C2.58977 0 1.80904 0.334446 1.2334 0.929764C0.657759 1.52508 0.33437 2.33251 0.33437 3.17441V9.52324C0.33437 9.94011 0.413763 10.3529 0.568018 10.738C0.722275 11.1232 0.94837 11.4731 1.2334 11.7679C1.51842 12.0627 1.8568 12.2965 2.22921 12.456C2.60161 12.6155 3.00076 12.6977 3.40384 12.6977H5.24553H9.79695H15.6817C16.4958 12.6977 17.2766 12.3632 17.8522 11.7679C18.4278 11.1726 18.7512 10.3652 18.7512 9.52324V3.17441C18.7512 2.33251 18.4278 1.52508 17.8522 0.929764C17.2766 0.334446 16.4958 0 15.6817 0ZM15.6817 1.26977H3.40384C2.9154 1.26977 2.44696 1.47043 2.10158 1.82762C1.75619 2.18482 1.56216 2.66927 1.56216 3.17441V9.52324C1.56216 10.0284 1.75619 10.5128 2.10158 10.87C2.44696 11.2272 2.9154 11.4279 3.40384 11.4279H15.6817C16.1702 11.4279 16.6386 11.2272 16.984 10.87C17.3294 10.5128 17.5234 10.0284 17.5234 9.52324V3.17441C17.5234 2.66927 17.3294 2.18482 16.984 1.82762C16.6386 1.47043 16.1702 1.26977 15.6817 1.26977Z" fill="#2790F9"/>
                  <path d="M3.40384 1.26977H15.6817C16.1702 1.26977 16.6386 1.47043 16.984 1.82762C17.3294 2.18482 17.5234 2.66927 17.5234 3.17441V9.52324C17.5234 10.0284 17.3294 10.5128 16.984 10.87C16.6386 11.2272 16.1702 11.4279 15.6817 11.4279H3.40384C2.9154 11.4279 2.44696 11.2272 2.10158 10.87C1.75619 10.5128 1.56216 10.0284 1.56216 9.52324V3.17441C1.56216 2.66927 1.75619 2.18482 2.10158 1.82762C2.44696 1.47043 2.9154 1.26977 3.40384 1.26977Z" fill="white"/>
                  <path fill-rule="evenodd" clip-rule="evenodd" d="M19.0577 4.76165H6.7798C6.29136 4.76165 5.82292 4.96232 5.47753 5.31951C5.13215 5.6767 4.93812 6.16115 4.93812 6.6663V13.0151C4.93812 13.5203 5.13215 14.0047 5.47753 14.3619C5.82292 14.7191 6.29136 14.9198 6.7798 14.9198H12.9188C12.9994 14.9196 13.0793 14.9359 13.1539 14.9677C13.2285 14.9995 13.2963 15.0462 13.3534 15.1052L15.9882 17.8313V15.5547C15.9882 15.3863 16.0529 15.2248 16.168 15.1057C16.2832 14.9867 16.4393 14.9198 16.6021 14.9198H19.0577C19.5461 14.9198 20.0146 14.7191 20.36 14.3619C20.7054 14.0047 20.8994 13.5203 20.8994 13.0151V6.6663C20.8994 6.16115 20.7054 5.6767 20.36 5.31951C20.0146 4.96232 19.5461 4.76165 19.0577 4.76165ZM6.7798 3.49188H19.0577C19.8718 3.49188 20.6525 3.82633 21.2282 4.42165C21.8038 5.01696 22.1272 5.82439 22.1272 6.6663V13.0151C22.1272 13.432 22.0478 13.8448 21.8935 14.2299C21.7393 14.6151 21.5132 14.965 21.2282 15.2598C20.9431 15.5545 20.6047 15.7884 20.2323 15.9479C19.8599 16.1074 19.4608 16.1895 19.0577 16.1895H17.216V19.364C17.2162 19.4897 17.1804 19.6127 17.1129 19.7173C17.0455 19.8219 16.9495 19.9034 16.8372 19.9516C16.7249 19.9997 16.6013 20.0123 16.4821 19.9877C16.3628 19.9631 16.2533 19.9025 16.1675 19.8135L12.6646 16.1895H6.7798C5.96573 16.1895 5.18499 15.8551 4.60936 15.2598C4.03372 14.6645 3.71033 13.857 3.71033 13.0151V6.6663C3.71033 5.82439 4.03372 5.01696 4.60936 4.42165C5.18499 3.82633 5.96573 3.49188 6.7798 3.49188Z" fill="#2790F9"/>
                  <path d="M19.0577 4.76165H6.7798C6.29136 4.76165 5.82292 4.96232 5.47753 5.31951C5.13215 5.6767 4.93812 6.16115 4.93812 6.6663V13.0151C4.93812 13.5203 5.13215 14.0047 5.47753 14.3619C5.82292 14.7191 6.29136 14.9198 6.7798 14.9198H12.9188C12.9994 14.9196 13.0793 14.9359 13.1539 14.9677C13.2285 14.9995 13.2963 15.0462 13.3534 15.1052L15.9882 17.8313V15.5547C15.9882 15.3863 16.0529 15.2248 16.168 15.1057C16.2832 14.9867 16.4393 14.9198 16.6021 14.9198H19.0577C19.5461 14.9198 20.0146 14.7191 20.36 14.3619C20.7054 14.0047 20.8994 13.5203 20.8994 13.0151V6.6663C20.8994 6.16115 20.7054 5.6767 20.36 5.31951C20.0146 4.96232 19.5461 4.76165 19.0577 4.76165Z" fill="white"/>
                  <path d="M10.4639 9.32349C10.4639 9.70494 10.1546 10.0142 9.77319 10.0142C9.39174 10.0142 9.08252 9.70494 9.08252 9.32349C9.08252 8.94204 9.39174 8.63282 9.77319 8.63282C10.1546 8.63282 10.4639 8.94204 10.4639 9.32349Z" fill="#2790F9"/>
                  <path d="M13.5947 9.30974C13.5947 9.69118 13.2855 10.0004 12.904 10.0004C12.5226 10.0004 12.2133 9.69118 12.2133 9.30974C12.2133 8.92829 12.5226 8.61906 12.904 8.61906C13.2855 8.61906 13.5947 8.92829 13.5947 9.30974Z" fill="#2790F9"/>
                  <path d="M16.7027 9.3235C16.7027 9.70494 16.3935 10.0142 16.012 10.0142C15.6306 10.0142 15.3214 9.70494 15.3214 9.3235C15.3214 8.94205 15.6306 8.63282 16.012 8.63282C16.3935 8.63282 16.7027 8.94205 16.7027 9.3235Z" fill="#2790F9"/>
                  </svg>
                  <span class='badge' :class="message_count > 0 ? 'enable' : '' " >{{ message_count }}</span>
               </div> -->

               <div @click='gotoNotificationIndex' class='btn-badge ml10'>
                  <svg width="19" height="20" viewBox="0 0 19 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                  <path d="M16.1176 14.6055C16.577 15.3164 17.1289 15.9629 17.7587 16.5281V17.2473H0.826953V16.5278C1.44914 15.9599 1.99356 15.3122 2.44603 14.6015L2.46376 14.5737L2.47879 14.5443C2.99231 13.5401 3.30009 12.4435 3.38408 11.3188L3.38602 11.2928V11.2667L3.38602 8.22777L3.38602 8.22636C3.38312 6.7874 3.9018 5.39615 4.84599 4.31028C5.79017 3.22441 7.09589 2.51751 8.5213 2.32051L9.12547 2.23701V1.6271V0.821239C9.12547 0.789084 9.13824 0.758246 9.16098 0.735511C9.18371 0.712773 9.21455 0.7 9.24671 0.7C9.27886 0.7 9.3097 0.712773 9.33243 0.735509C9.35517 0.758248 9.36795 0.789086 9.36795 0.821239V1.6148V2.23105L9.97923 2.30915C11.4175 2.49291 12.7392 3.19556 13.696 4.28509C14.6527 5.37462 15.1787 6.77603 15.1751 8.22601V8.22777V11.2667V11.2928L15.177 11.3188C15.261 12.4435 15.5688 13.5401 16.0823 14.5443L16.0984 14.5758L16.1176 14.6055Z" stroke="#2790F9" stroke-width="1.4"/>
                  <path d="M7.67493 18.5933C7.72887 18.9832 7.92209 19.3404 8.21891 19.599C8.51572 19.8576 8.89607 20 9.28972 20C9.68337 20 10.0637 19.8576 10.3605 19.599C10.6574 19.3404 10.8506 18.9832 10.9045 18.5933H7.67493Z" fill="#2790F9"/>
                  </svg>
                  <span class='badge badge-notification' :class="notification_count > 0 ? 'enable' : '' ">{{notification_count}}</span>
               </div>

            </div>
         </div>
         <div class='appbar-bottom'>
            <ul class='navbar style-expaned'>
               <li @click='select_filter_datetime("d")' :class='filter_datetime[0].active == true ? "active" : ""'><?php echo __('Day', 'watergo'); ?></li>
               <li @click='select_filter_datetime("m")' :class='filter_datetime[1].active == true ? "active" : ""'><?php echo __('Month', 'watergo'); ?></li>
               <li @click='select_filter_datetime("y")' :class='filter_datetime[2].active == true ? "active" : ""'><?php echo __('Year', 'watergo'); ?></li>
            </ul>

         </div>
      </div>

      <div class='inner mt30'>
         
         <div class='box-profit'>
            <div class='order-count'><?php echo __('SOLD', 'watergo')?>: <span class='highlight'>{{ get_data_report.sold }}</span> <?php echo __('Orders', 'watergo'); ?></div>
            <div v-if='report_rank.rank != "today"' class='rank rank_sold' :class='get_data_report.rank_sold'>

               <svg v-if='get_data_report.rank_sold == "up"' width="25" height="20" viewBox="0 0 15 20" fill="none" xmlns="http://www.w3.org/2000/svg">
               <path d="M8.77815 1.29289C8.38763 0.902369 7.75446 0.902369 7.36394 1.29289L0.999977 7.65685C0.609453 8.04738 0.609453 8.68054 0.999977 9.07107C1.3905 9.46159 2.02367 9.46159 2.41419 9.07107L8.07104 3.41421L13.7279 9.07107C14.1184 9.46159 14.7516 9.46159 15.1421 9.07107C15.5326 8.68054 15.5326 8.04738 15.1421 7.65685L8.77815 1.29289ZM9.07104 18V2H7.07104V18H9.07104Z" fill="#13E800"/>
               </svg>

               <svg v-if='get_data_report.rank_sold == "down"' width="25" height="20" viewBox="0 0 15 20" fill="none" xmlns="http://www.w3.org/2000/svg">
               <path d="M8.77815 18.7071C8.38763 19.0976 7.75446 19.0976 7.36394 18.7071L0.999977 12.3431C0.609453 11.9526 0.609453 11.3195 0.999977 10.9289C1.3905 10.5384 2.02367 10.5384 2.41419 10.9289L8.07104 16.5858L13.7279 10.9289C14.1184 10.5384 14.7516 10.5384 15.1421 10.9289C15.5326 11.3195 15.5326 11.9526 15.1421 12.3431L8.77815 18.7071ZM7.07104 18V2H9.07104V18H7.07104Z" fill="#FF5656"/>
               </svg>

               <span v-if='get_data_report.sold_report > 0' class='rank-sum'>{{ get_data_report.sold_report }}</span>
            </div>
         </div>

         <div class='box-profit'>
            <div class='order-count'><?php echo __('CANCELED', 'watergo'); ?>: <span class='highlight'>{{ get_data_report.cancel }}</span> <?php echo __('Orders', 'watergo'); ?></div>
            <div v-if='report_rank.rank != "today"' class='rank rank_cancel' :class='get_data_report.rank_cancel'>

               <svg v-if='get_data_report.rank_cancel == "up"' width="25" height="20" viewBox="0 0 15 20" fill="none" xmlns="http://www.w3.org/2000/svg">
               <path d="M8.77815 1.29289C8.38763 0.902369 7.75446 0.902369 7.36394 1.29289L0.999977 7.65685C0.609453 8.04738 0.609453 8.68054 0.999977 9.07107C1.3905 9.46159 2.02367 9.46159 2.41419 9.07107L8.07104 3.41421L13.7279 9.07107C14.1184 9.46159 14.7516 9.46159 15.1421 9.07107C15.5326 8.68054 15.5326 8.04738 15.1421 7.65685L8.77815 1.29289ZM9.07104 18V2H7.07104V18H9.07104Z" fill="#13E800"/>
               </svg>

               <svg v-if='get_data_report.rank_cancel == "down"' width="25" height="20" viewBox="0 0 15 20" fill="none" xmlns="http://www.w3.org/2000/svg">
               <path d="M8.77815 18.7071C8.38763 19.0976 7.75446 19.0976 7.36394 18.7071L0.999977 12.3431C0.609453 11.9526 0.609453 11.3195 0.999977 10.9289C1.3905 10.5384 2.02367 10.5384 2.41419 10.9289L8.07104 16.5858L13.7279 10.9289C14.1184 10.5384 14.7516 10.5384 15.1421 10.9289C15.5326 11.3195 15.5326 11.9526 15.1421 12.3431L8.77815 18.7071ZM7.07104 18V2H9.07104V18H7.07104Z" fill="#FF5656"/>
               </svg>

               <span v-if='get_data_report.cancel_report > 0' class='rank-sum'>{{ get_data_report.cancel_report }}</span>
            </div>
         </div>

         <div class='box-profit'>
            <div class='order-count'><?php echo __('TOTAL PROFIT', 'watergo'); ?>: <span class='highlight'>{{ get_price_convert(get_data_report.profit) }}</span></div>
         </div>

      </div>
   </div>

   <div v-show='loading == true'>
      <div class='progress-center'>
         <div class='progress-container enabled'><progress class='progress-circular enabled' ></progress></div>
      </div>
   </div>

</div>


<link defer rel="stylesheet" href="<?php echo THEME_URI . '/assets/js/jquery_ui_1.13.2.min.css'; ?>">
<script defer src="<?php echo THEME_URI . '/assets/js/jquery_ui_1.13.2.min.js'; ?>"></script>
<script>

var app = Vue.createApp({
   data (){
      return {
         loading: false,
         message_count: 0,
         notification_count: 0,
         currentDate: new Date(),
         currentYear: 0,
         
         display_datetime: '',
         display_datemonth: '',
         display_dateyear: '',

         filter_datetime: [
            {label: 'Day', value: 'd', active: true},
            {label: 'Month', value: 'm', active: false},
            {label: 'Year', value: 'y', active: false}
         ],

         datetime_day: {value: 0},
         datetime_month: {value: 0},
         datetime_year: {value: 0},

         open_datetime: false,
         open_datemonth: false,
         open_dateyear: false,

         final_datetime: '',

         report_range: {
            sold: 0,
            cancel: 0,
            profit: 0,
         },

         report_today: {
            profit: 0,
            sold: 0,
            cancel: 0,
         },

         report_rank: {
            rank: 'today',
            sold: 0,
            cancel: 0
         }
         
      }
   },


   watch: {


      filter_datetime: {
         async handler( filter ){
            var _find = filter.find( item => item.active == true );

            if( _find.value == 'd' ){
               this.loading = true;
               this.report_rank.rank = 'day';
               var year        = this.currentDate.getFullYear();
               var month       = String(this.currentDate.getMonth() + 1).padStart(2, '0');
               var day         = String(this.currentDate.getDate()).padStart(2, '0');
               var date_from   = `${year}-${month}-${day}`;
               var date_to     = `${year}-${month}-${day}`;
               var current     = `${day}/${month}/${year}`;
               this.display_datetime = current;
               await window.app.get_order_range_day_report(date_from, date_to);
               this.loading = false;
            }

            if( _find.value == 'm' ){
               this.loading = true;
               await this.select_datemonth( this.currentDate.getMonth() + 1);
               this.loading = false;
            }

            if( _find.value == 'y' ){
               this.loading = true;
               await this.select_dateyear(this.currentDate.getFullYear());
               this.loading = false;
            }

         },
         deep: true
      },

   },

   computed: {

      get_data_report(){

         var sold_report   = 0;
         var cancel_report = 0;

         var rank_sold     = 'normal';
         var rank_cancel   = 'normal';

         sold_report       = this.report_today.sold   - this.report_range.sold;
         cancel_report     = this.report_today.cancel - this.report_range.cancel;

         if( sold_report > 0 ){
            rank_sold = 'up';
         }else if( sold_report == 0 ){
            rank_sold = 'normal';
         }else if( sold_report < 0 ){
            rank_sold = 'down';
            sold_report = Math.abs(sold_report);
         }

         if( cancel_report > 0 ){
            rank_cancel = 'up';
         }else if( cancel_report == 0 ){
            rank_cancel = 'normal';
         }else if( cancel_report < 0 ){
            rank_cancel = 'down';
            cancel_report = Math.abs(cancel_report);
         }

         
         return {
            profit:        this.report_today.profit,
            sold:          this.report_today.sold,
            cancel:        this.report_today.cancel,

            rank_sold:     rank_sold,
            rank_cancel:   rank_cancel,

            sold_report:   sold_report,
            cancel_report: cancel_report,
         };

      },

      count_product_in_cart(){ return window.count_product_in_cart(); },
      getPastDaysInMonth(){ return window.getPastDaysInMonth(); },
      getPastMonthsInCurrentYears() {
         const currentDate = new Date();
         const currentMonth = currentDate.getMonth(); // 0-based index (0-11)
         const previousMonths = [];
         for (let i = currentMonth; i >= 0; i--) {
            previousMonths.push(i + 1); // Add 1 to get the correct month number (1-12)
         }
         return previousMonths;
      },

   },

   methods: {

      datePicker(){
         (function($){
            $(document).ready(function(){
               // add wrapper for picker
               
               function select(){
                  $('.ui-date-picker-wrapper').addClass('active');
                  $('.ui-date-picker-wrapper').addClass('schedule-datepicker');

                  $('#datepicker').datepicker({
                     dayNamesMin: [ "Sun", "Mon", "Tue", "Wed", "Thu", "Fri", "Sat" ],
                     dateFormat: "dd/mm/yy",
                     firstDay: 1,
                     maxDate: 0,
                     onSelect: async function(dateText, inst){
                        if(dateText != undefined || dateText != '' || dateText != null){
                           $('#datepicker').attr('value', dateText); 
                           
                           window.app.loading = true;
                           window.app.display_datetime = dateText;
                           window.app.report_rank.rank = 'day';
                           var currentDate = new Date();
                           var year        = currentDate.getFullYear();
                           var month       = String(currentDate.getMonth() + 1).padStart(2, '0');
                           var day         = String(currentDate.getDate()).padStart(2, '0');
                           var date_from   = `${year}-${month}-${day}`;
                           var date_to     = window.reverse_date_to_system_datetime(dateText);
                           await window.app.get_order_range_day_report(date_from, date_to);
                           window.app.loading = false;

                        }
                     },
                     onClose: function(dateText, inst){
                        $('.ui-date-picker-wrapper').removeClass('active');
                        $('.ui-date-picker-wrapper').removeClass('schedule-datepicker');
                     }

                  });

                  if( $('#datepicker').val().length == 0 ){
                     $('#datepicker').datepicker('setDate', new Date() );
                  }

                  if( $('.ui-date-picker-wrapper #ui-datepicker-div').length == 0 ){
                     $('#ui-datepicker-div').wrap('<div class="ui-date-picker-wrapper"></div>');
                  }
               }
               select();

               $('#datepicker').on('click', function(){
                  select();
               });

            });

         })(jQuery);
      },

      addZeroLeading(n){ return window.addZeroLeading(n)},
      gotoNotificationIndex(){ window.gotoNotificationIndex()},
      get_start_and_end_of_month_current(){ window.get_start_and_end_of_month_current()},
      get_start_and_end_of_month(n){ window.get_start_and_end_of_month(n)},
      
      get_price_convert(price){
         if( price > 0){
            return price.toLocaleString('vi-VN') + ' đ';
         }
         return 0 + ' đ';
      },

      reverse_date_to_system_datetime(datetime){ return window.reverse_date_to_system_datetime(datetime) },

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

      btn_select_month(){
         this.open_datemonth  = true;
         this.open_dateyear   = false;
      },
      btn_select_year(){
         this.open_dateyear   = true;
         this.open_datemonth  = false;
      },

      async select_datemonth(val){
         this.open_datemonth  = false;
         this.open_dateyear   = false;
         this.display_datemonth = String(val).padStart(2, '0') + '/' + this.currentYear;
         this.report_rank.rank = 'month';
         var _start_and_end_of_month = window.get_start_and_end_of_month(val);
         var _start_and_end_of_month_current = window.get_start_and_end_of_month_current();
         await this.get_order_range_month_report(_start_and_end_of_month, _start_and_end_of_month_current);
      },

      async select_dateyear(val){
         this.open_datemonth  = false;
         this.open_dateyear   = false;
         this.display_dateyear = val;
         this.report_rank.rank = 'month';
         var start_day     = val + '-01-01';
         var start_end     = val + '-12-31';
         await this.get_order_range_year_report(start_day, start_end);
      },

      select_filter_datetime(value){
         this.open_datemonth = false;
         this.open_dateyear = false;
         this.filter_datetime.forEach(item => {item.active = item.value === value;});
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

      get_full_current_datetime( obj ){
         var _isDay = obj && obj.day !== undefined ? obj.day : null;
         var _isMonth = obj && obj.month !== undefined ? obj.month : null;
         var _isYear = obj && obj.year !== undefined ? obj.year : null;

         var dateObj = new Date();
         var day     = dateObj.getDate().toString().padStart(2, '0');
         var month   = (dateObj.getMonth() + 1).toString().padStart(2, '0');
         var year    = dateObj.getFullYear().toString();
         var formattedDate = '';


         if( _isDay == null || _isMonth == null || _isYear == null ){
            formattedDate = `${day}/${month}/${year}`;
         }

         if( _isDay != null ){
            _isDay = _isDay.toString().padStart(2, '0');
            formattedDate = `${_isDay}/${month}/${year}`;
         }
         if( _isMonth != null ){
            _isMonth = _isMonth.toString().padStart(2, '0');
            formattedDate = `${_isMonth}/${year}`;
         }
         if( _isYear != null ){
            formattedDate = `${_isYear}`;
         }

         return formattedDate;

      },

      // 
      async get_totay_order_report(){

         var form = new FormData();
         form.append('action', 'atlantis_get_today_order_report');
         var r = await window.request(form);
         window.appbar_fixed();
         console.log(r);
         if( r != undefined ){
            var res = JSON.parse( JSON.stringify(r));
            if( res.message == 'get_order_ok' ){
               this.report_today.sold     = res.data.sold;
               this.report_today.cancel   = res.data.cancel;
               this.report_today.profit   = res.data.profit;
            }
         }

      },

      // RANGE DAY
      async get_order_range_day_report(date_from, date_to){
         var form = new FormData();
         form.append('action', 'atlantis_get_range_day_order_report');
         form.append('date_from', date_from);
         form.append('date_to', date_to);
         var r = await window.request(form);
         if( r != undefined ){
            var res = JSON.parse( JSON.stringify(r));
            if( res.message == 'get_order_ok' ){
               this.report_range = res.data.report_range;
               this.report_today = res.data.report_today;
            }
         }
         window.appbar_fixed();
      },

      // RANGE MONTH
      async get_order_range_month_report( range_month, range_month_current ){
         this.loading = true;
         var form = new FormData();
         form.append('action', 'atlantis_get_range_month_order_report');
         form.append('start_day_month', range_month.startDay);
         form.append('end_day_month', range_month.endDay);

         form.append('start_day_month_current', range_month_current.startDay);
         form.append('end_day_month_current', range_month_current.currentDay);

         var r = await window.request(form);
         window.appbar_fixed();

         if( r != undefined ){
            var res = JSON.parse( JSON.stringify(r));
            if( res.message == 'get_order_ok' ){
               this.report_range = res.data.report_range;
               this.report_today = res.data.report_today;
            }
         }
         this.loading = false;
      },

      // RANGE YEAR
      async get_order_range_year_report( start_day, end_day ){
         this.loading = true;
         var form = new FormData();
         form.append('action', 'atlantis_get_range_year_order_report');
         form.append('start_day', start_day );
         form.append('end_day', end_day );

         var currentDate = new Date();
         var currentYear = currentDate.getFullYear();

         var current_start_year   = currentYear + '-01-01';
         var current_end_year     = currentYear + '-12-31';

         form.append('current_start_day', current_start_year );
         form.append('current_end_day', current_end_year );

         var r = await window.request(form);
         window.appbar_fixed();

         if( r != undefined ){
            var res = JSON.parse( JSON.stringify(r));
            if( res.message == 'get_order_ok' ){
               this.report_range = res.data.report_range;
               this.report_today = res.data.report_today;
            }
         }
         this.loading = false;
      },


      gotoChat(){ window.gotoChat(); },
      gotoCart(){ window.gotoCart(); },
      goBack(){window.goBack(); }
   },

   async created(){

      this.loading = true;
      this.currentYear = this.currentDate.getFullYear();
      // await this.get_messages_count();
      var year = this.currentDate.getFullYear();
      var month = String(this.currentDate.getMonth() + 1).padStart(2, '0'); // Months are zero-indexed, so we add 1 and pad with leading zeros if needed
      var day = String(this.currentDate.getDate()).padStart(2, '0'); // Pad with leading zeros if needed

      this.display_datetime      = `${day}/${month}/${year}`;
      this.display_datemonth     = `${month}/${year}`;
      this.display_dateyear      = `${year}`;

      await this.get_totay_order_report();
      await this.get_notification_count();

      this.datePicker();

      setTimeout( () => { 
         window.appbar_fixed();
         this.loading = false; }, 300);

   }
   
}).mount('#app');
window.app = app;

</script>