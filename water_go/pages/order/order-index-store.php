<div id='app'>
   <div v-if='loading == false' class='page-order'>

      <div class='appbar'>
         <div class='appbar-top'>
            <div class='leading'>
               <p class='leading-title'>Order</p>
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
            <ul class='navbar style02'>
               <li @click='select_filter(filter.label)' v-for='(filter, index) in order_status_filter' 
                  :key='index' 
                  :class='filter.active == true ? "active" : ""'>{{ filter.label }} <span class='count'>({{filter.count}})</span></li>
            </ul>
         </div>
      </div>

      <div v-if='order_filter.length > 0' class='order-store-header'>
         <button @click='filter_order_by_select' class='btn-filter'>
            <span class='filter-text'>{{filter_order_by}}</span>
            <span class='filter-icon'>
               <svg width="11" height="6" viewBox="0 0 11 6" fill="none" xmlns="http://www.w3.org/2000/svg">
               <path d="M1.5 1L5.5 5L9.5 1" stroke="#252831" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
               </svg>
            </span>
         </button>

         <div class='count-order'>Total order: <span>{{total_order}}</span></div>
      </div>

      <div v-if='
         order_filter.length > 0 && 
         get_order_status_filter_value != "complete" && 
         get_order_status_filter_value != "cancel"
         ' class='order-store-action'>
         <div class='form-check'>
            <input @click='select_all_item' type='checkbox' :checked='is_select_all == true ? true : false'>
            <label @click='select_all_item'>Select All</label>
         </div>

         <div class='action-all'>
            <button v-if='get_order_status_filter_value == "ordered" ' @click='btn_action_confirm_all' class='btn-action-confirm'>Confirm</button>
            <button v-if='get_order_status_filter_value == "ordered"' @click='btn_action_cancel_all' class='btn-action-cancel'>Cancel</button>
            
            <button v-if='get_order_status_filter_value == "confirmed"' @click='btn_action_delivery_all' class='btn-action-cancel'>Delivery</button>
            <button v-if='get_order_status_filter_value == "delivering"' @click='btn_action_complete_all' class='btn-action-cancel'>Complete</button>

         </div>
      </div>
      <div v-if='get_order_status_filter_value == "complete" || get_order_status_filter_value == "cancel"' class='break-line'></div>

      <ul class='list-order style-store'>
         
         <li v-for='( order, keyOrder ) in order_filter':key='keyOrder'>
            <label @click='select_item(order.order_id)' class='order-head'>
               <div v-if='order.order_status != "complete" && order.order_status != "cancel"' class='form-check'><input disabled type='checkbox' :checked='order.is_select'></div>
               <!--  -->
               <span v-if='order.order_repeat_id == 0' class='text-order-number'>#{{ addLeadingZeros(order.order_id)}}</span>
               <!--  -->
               <span v-if='order.order_repeat_id != 0' class='text-order-number'>#{{ addLeadingZeros(order.order_repeat_id)}}-{{ order.order_repeat_count}}</span>
               <!--  -->

               <span class='text-order-type' :class='get_type_order(order.order_delivery_type)'>{{print_type_order_text(order.order_delivery_type)}}</span>
            </label>
            <div class='order-time'>
               <span class='tt01'>Ordered Time: </span>
               <span class='tt02'>{{ timestamp_to_fulldate(order.order_time_created) }}</span>
            </div>
            <div v-if='order.order_time_confirmed != 0' class='order-time'>
               <span class='tt01'>Confirm Time: </span>
               <span class='tt02'>{{ timestamp_to_fulldate(order.order_time_confirmed) }}</span>
            </div>
            <div v-if='order.order_time_delivery != 0' class='order-time'>
               <span class='tt01'>Delivery Time: </span>
               <span class='tt02'>{{ timestamp_to_fulldate(order.order_time_delivery) }}</span>
            </div>
            <div v-if='order.order_time_cancel != 0' class='order-time'>
               <span class='tt01'>Cancel Time: </span>
               <span class='tt02'>{{ timestamp_to_fulldate(order.order_time_cancel) }}</span>
            </div>

            <div 
               v-for='(product, prodKey) in order.order_products' :key='prodKey' class='order-prods'>
               <div class='leading'>
                  <img :src="get_image_upload(product.product_image)">
               </div>
               <div class='prod-detail'>
                  <span class='prod-name'>{{ product.order_group_product_name }}</span>
                  <span class='prod-quantity'>{{ product.order_group_product_quantity_count }}x</span>
               </div>
               <div class='prod-price'>{{ common_get_product_price(product.order_group_product_price) }}</div>
            </div>

            <div class='order-bottom'>
               <span class='total-product'>{{ count_total_product_in_order(order.order_id) }} product</span>
               <span class='total-price'>Total: <span class='t-primary'>{{ count_total_price_in_order(order.order_id) }}</span></span>
            </div>
            <div class='order-func'>
               <button @click='gotoOrderStoreDetail(order.order_id)' class='btn-action-view'>View</button>
               <button 
                  v-if='order.order_status == "ordered"'
                  @click='btn_action_order_status(order.order_id, "confirmed")' class='btn-action-confirm'>Confirm</button>
               <button 
                  v-if='order.order_status == "ordered"'
                  @click='btn_action_order_status(order.order_id, "cancel")' class='btn-action-cancel'>Cancel</button>
               <button 
                  v-if='order.order_status == "confirmed"' 
                  @click='btn_action_order_status(order.order_id, "delivering")' class='btn-action-cancel'>Delivery</button>
               <button 
                  v-if='order.order_status == "delivering"' 
                  @click='btn_action_order_status(order.order_id, "complete")' class='btn-action-cancel'>Complete</button>
            </div>

         </li>


      </ul>

   </div>
   <div v-if='loading == true'>
      <div class='progress-center'>
         <div class='progress-container enabled'><progress class='progress-circular enabled' ></progress></div>
      </div>
   </div>

   <div v-if='popup_confirm_all_item == true' class='modal-popup open'>
      <div class='modal-wrapper'>
         <p class='heading'>Do you want to confirm <span class='t-primary'>All Order</span>?</p>
         <div class='actions'>
            <button @click='btn_modal_cancel_all' class='btn btn-outline'>Cancel</button>
            <button @click='btn_modal_confirm_all' class='btn btn-primary'>Confirm</button>
         </div>
      </div>
   </div>
   <div v-if='popup_delivering_all_item == true' class='modal-popup open'>
      <div class='modal-wrapper'>
         <p class='heading'>Do you want to delivering <span class='t-primary'>All Order</span>?</p>
         <div class='actions'>
            <button @click='btn_modal_cancel_all' class='btn btn-outline'>Cancel</button>
            <button @click='btn_submit_delivering_all' class='btn btn-primary'>Confirm</button>
         </div>
      </div>
   </div>
   <div v-if='popup_complete_all_item == true' class='modal-popup open'>
      <div class='modal-wrapper'>
         <p class='heading'>Do you want to compete <span class='t-primary'>All Order</span>?</p>
         <div class='actions'>
            <button @click='btn_modal_cancel_all' class='btn btn-outline'>Cancel</button>
            <button @click='btn_submit_complete_all' class='btn btn-primary'>Confirm</button>
         </div>
      </div>
   </div>
   

   <div v-if='popup_cancel_all_item == true' class='modal-popup style01 open'>
      <div class='modal-wrapper'>
         <p class='tt01'>Why do you want to cancel <span class='t-primary'>All Order</span>?</p>
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
            <button @click='btn_submit_cancel_all' class='btn btn-primary'>Submit</button>
         </div>
      </div>
   </div>


</div>
<script type='module'>

var { createApp } = Vue;

createApp({
   data (){
      return {
         loading: false,
         popup_confirm_all_item: false,
         popup_cancel_all_item: false,
         popup_delivering_all_item: false,
         popup_complete_all_item: false,

         message_count: 0,
         notification_count: 0,
         total_order: 0,

         is_select_all: false,

         filter_order_by: 'Old first',

         orders: [],
         order_status_filter: [ 
            { label: 'ordered', active: true, count: 0 },
            { label: 'confirmed', active: false, count: 0 },
            { label: 'delivering', active: false, count: 0 },
            { label: 'complete', active: false, count: 0 },
            { label: 'cancel', active: false, count: 0}
         ],

         reason_cancel: [
            {label: 'Reason 1', active: false},
            {label: 'Reason 2', active: false},
            {label: 'Reason 3', active: false},
            {label: 'Reason 4', active: false},
            {label: 'Others', active: false}
         ],

      }
   },

   methods: {
      btn_select_reason( key ){
         this.reason_cancel.some( item => { 
            item.active = false;
            if( item.label == key ){
               item.active = true;
            }
         });
      },

      force_all_select_to_false(){
         this.is_select_all = false;
         this.orders.some(item => item.is_select = false);
      },

      async btn_modal_confirm_all(){ 
         var order_ids = this.get_all_ids_order();
         if( order_ids.length > 0 ){
            await this.btn_action_order_status(order_ids, 'confirmed');
         }
         // this.popup_confirm_all_item = false;
         location.reload();
      },

      async btn_submit_cancel_all(){
         var order_ids = this.get_all_ids_order();
         if( order_ids.length > 0 ){
            await this.btn_action_order_status(order_ids, 'cancel');
         }
         // this.popup_cancel_all_item = false;
         location.reload();
      },

      async btn_submit_delivering_all(){
         
         var order_ids = this.get_all_ids_order();
         if( order_ids.length > 0 ){
            await this.btn_action_order_status(order_ids, 'delivering');
         }
         // this.popup_delivering_all_item = false;
         location.reload();
      },

      async btn_submit_complete_all(){
         var order_ids = this.get_all_ids_order();
         if( order_ids.length > 0 ){
            await this.btn_action_order_status(order_ids, 'complete');
         }
         // this.popup_complete_all_item = false;
         location.reload();
      },

      btn_modal_cancel_all(){ 
         this.popup_confirm_all_item = false;
         this.popup_cancel_all_item = false;
         this.popup_delivering_all_item = false;
         this.popup_complete_all_item = false;
      },
      btn_action_confirm_all(){ if(this.is_select_all == true) this.popup_confirm_all_item = true; },
      btn_action_cancel_all(){ if(this.is_select_all == true) this.popup_cancel_all_item = true;},
      btn_action_delivery_all(){ if(this.is_select_all == true) this.popup_delivering_all_item = true;},
      btn_action_complete_all(){ if(this.is_select_all == true) this.popup_complete_all_item = true;},

      get_all_ids_order(){
         var list_ids = [];
         if( this.is_select_all == true ){
            this.popup_select_all_item = true;
            this.orders.forEach(item => {
               if(item.is_select == true ){
                  list_ids.push(parseInt(item.order_id));
               }
            });
         }
         return list_ids;
      },


      async btn_action_order_status(order_id, order_status){
         var ods = [];
         if (Array.isArray(order_id)) {
            ods = order_id.map(id => parseInt(id));
         } else {
            ods.push(parseInt(order_id));
         }
         var timestamp = Math.floor(Date.now() / 1000);

         var form = new FormData();
         form.append('action', 'atlantis_order_status');
         form.append('order_id', JSON.stringify(ods));
         form.append('status', order_status);
         form.append('timestamp', timestamp);
         var r = await window.request(form);
         if( r != undefined ){
            var res = JSON.parse( JSON.stringify(r));
            if( res.message == 'order_status_ok'){
               for(var i = 0; i < ods.length; i++ ){
                  var _getOrder = this.orders.find(item => item.order_id == ods[i] );
                  if( _getOrder ){
                     if(order_status == 'confirmed'){
                        _getOrder.order_status = 'confirmed';
                        _getOrder.order_time_confirmed = timestamp;
                     }
                     if(order_status == 'cancel'){
                        _getOrder.order_status = 'cancel';
                        _getOrder.order_time_cancel = timestamp;
                     }
                     if(order_status == 'delivering'){
                        _getOrder.order_status = 'delivering';
                        _getOrder.order_time_delivery = timestamp;
                     }
                     if(order_status == 'complete'){
                        _getOrder.order_status = 'complete';
                        _getOrder.order_time_completed = timestamp;
                        // callback order
                        if( _getOrder.order_delivery_type == 'weekly' ||
                           _getOrder.order_delivery_type == 'monthly'
                        ){
                           // GET BACK ORDER
                           var _list_id = [];
                           this.orders.forEach(item => {
                              _list_id.push( parseInt( item.order_id ));
                           });

                           var callback = new FormData();
                           callback.append('action', 'atlantis_order_callback');
                           callback.append('order_id', JSON.stringify(_list_id));
                           var _r = await window.request(callback);
                           if( _r != undefined ){
                              var _res = JSON.parse( JSON.stringify( _r ));
                              if( _res.message == 'order_callback_ok' ){
                                 this.orders.push(..._res.data);
                              }
                           }
                        }

                     }
                     
                  }
               }
               this.re_order_status();
            }
            console.log(r);
         }
      },


      select_all_item(){
         this.is_select_all = !this.is_select_all;
         this.orders.forEach(item => {
            var activeStatus = this.order_status_filter.find(status => status.active == true && status.label == item.order_status );
            if( this.is_select_all && activeStatus ){
               item.is_select = true;
            }else{
               item.is_select = false;
            }
         });

         console.log(this.orders);
      },

      filter_order_by_select(){
         if(this.filter_order_by == 'Old first'){
            this.filter_order_by = 'New first';
         }else{
            this.filter_order_by = 'Old first';
         }
      },

      select_item( order_id ){
         this.orders.forEach(order => {
            this.is_select_all = false;
            if( order.order_id == order_id ){
               order.is_select = !order.is_select;
            }
         });
      },
      select_filter( filter_select ){ 
         this.order_status_filter.some( item => {
            if( item.label == filter_select ){
               item.active = true;
            }else{
               this.force_all_select_to_false();
               item.active = false;
            }
         });
         
      },

      get_image_upload( i ){ return window.get_image_upload( i ) },
      common_get_product_price( price, discount_percent ){return window.common_get_product_price( price, discount_percent );},
      gotoProductDetail(product_id){ window.gotoProductDetail(product_id); },
      gotoStoreDetail(store_id){ window.gotoStoreDetail(store_id); },
      get_type_order(order_type){ return window.get_type_order(order_type)},
      print_type_order_text(order_type){ return window.print_type_order_text(order_type)},
      timestamp_to_fulldate(timestamp){ return window.timestamp_to_fulldate(timestamp);},
      count_total_price_in_order(order_id ){
         var _total = 0;

         this.orders.some( order => {
            if( order.order_id == order_id ){
               order.order_products.some ( product => {
                  _total += get_total_price(
                     product.order_group_product_price, 
                     product.order_group_product_quantity_count, 
                     product.order_group_product_discount_percent
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
               _total += order.order_products.length;
            }
         });
         return _total;
      },
      

      addLeadingZeros(number) {
         if( number != undefined ){
            if (number <= 1000) return number.toString().padStart(4, '0');
            return number.toString();
         }
      },

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
      
      // refresh
      re_order_status(){
         this.order_status_filter.some(item => item.count = 0);
         this.orders.some(item => {
            if(item.order_status == 'ordered'){
               this.order_status_filter[0].count++;
            }
            if(item.order_status == 'confirmed'){
               this.order_status_filter[1].count++;
            }
            if(item.order_status == 'delivering'){
               this.order_status_filter[2].count++;
            }
            if(item.order_status == 'complete'){
               this.order_status_filter[3].count++;
            }
            if(item.order_status == 'cancel'){
               this.order_status_filter[4].count++;
            }
         });
      },

      gotoOrderStoreDetail(order_id){ window.gotoOrderStoreDetail(order_id)}
      
   }, 

   computed: {
      
      get_order_status_filter_value(){
         var _value = this.order_status_filter.find(item => item.active == true );
         if(_value){
            return _value.label;
         }
         return '';
      },

      order_filter(){
         var _filter_orders = this.orders.filter( item => {
            var findFilter = this.order_status_filter.find(item => item.active == true);
            this.total_order = findFilter.count;
            if(item.order_status == findFilter.label ){
               return item.order_status == findFilter.label;
            }
         });
         if(this.filter_order_by == 'Old first'){
            _filter_orders.sort((a,b) => a.order_time_created - b.order_time_created );
         }
         else if(this.filter_order_by == 'New first'){
            _filter_orders.sort((a,b) => b.order_time_created - a.order_time_created );
         }

         return _filter_orders;
      }
   },

   async created(){
      this.loading = true;
      var form = new FormData();
      form.append('action', 'atlantis_get_order');
      var r = window.request(form);
      var r = await window.request(form);
      if( r != undefined ){
         var res = JSON.parse( JSON.stringify( r ));
         if( res.message == 'get_order_ok' ){
            // GROUP PRODUCT 
            res.data.some(item => {
               item.is_select = false;
               if(item.order_status == 'ordered'){
                  this.order_status_filter[0].count++;
               }
               if(item.order_status == 'confirmed'){
                  this.order_status_filter[1].count++;
               }
               if(item.order_status == 'delivering'){
                  this.order_status_filter[2].count++;
               }
               if(item.order_status == 'complete'){
                  this.order_status_filter[3].count++;
               }
               if(item.order_status == 'cancel'){
                  this.order_status_filter[4].count++;
               }
            });

            this.orders.push(...res.data);
         }
         if( res.message == 'no_order_found'){
            this.loading = true;
         }
      }

      console.log(this.orders);
      
      this.loading = false;
   },
   
}).mount('#app');
</script>
