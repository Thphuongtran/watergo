<div id='app'>
   <div v-show='loading == false' class='page-order'>

      <div class='appbar fixed'>
         <div class='appbar-top'>
            <div class='leading'>
               <p class='leading-title'><?php echo __('Order', 'watergo'); ?></p>
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
                  <span class='badge' :class="message_count > 0 ? 'enable' : '' " >{{ message_count }}</span>
               </div>

               <div @click='gotoNotificationIndex' class='btn-badge ml10'>
                  <svg width="19" height="20" viewBox="0 0 19 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                  <path d="M16.1176 14.6055C16.577 15.3164 17.1289 15.9629 17.7587 16.5281V17.2473H0.826953V16.5278C1.44914 15.9599 1.99356 15.3122 2.44603 14.6015L2.46376 14.5737L2.47879 14.5443C2.99231 13.5401 3.30009 12.4435 3.38408 11.3188L3.38602 11.2928V11.2667L3.38602 8.22777L3.38602 8.22636C3.38312 6.7874 3.9018 5.39615 4.84599 4.31028C5.79017 3.22441 7.09589 2.51751 8.5213 2.32051L9.12547 2.23701V1.6271V0.821239C9.12547 0.789084 9.13824 0.758246 9.16098 0.735511C9.18371 0.712773 9.21455 0.7 9.24671 0.7C9.27886 0.7 9.3097 0.712773 9.33243 0.735509C9.35517 0.758248 9.36795 0.789086 9.36795 0.821239V1.6148V2.23105L9.97923 2.30915C11.4175 2.49291 12.7392 3.19556 13.696 4.28509C14.6527 5.37462 15.1787 6.77603 15.1751 8.22601V8.22777V11.2667V11.2928L15.177 11.3188C15.261 12.4435 15.5688 13.5401 16.0823 14.5443L16.0984 14.5758L16.1176 14.6055Z" stroke="#2790F9" stroke-width="1.4"/>
                  <path d="M7.67493 18.5933C7.72887 18.9832 7.92209 19.3404 8.21891 19.599C8.51572 19.8576 8.89607 20 9.28972 20C9.68337 20 10.0637 19.8576 10.3605 19.599C10.6574 19.3404 10.8506 18.9832 10.9045 18.5933H7.67493Z" fill="#2790F9"/>
                  </svg>
                  <span v-if='notification_count > 0' class='badge badge-notification' :class='notification_count > 0 ? "enable" : "" '>{{notification_count}}</span>
                  
               </div>

            </div>
         </div>
         <div class='appbar-bottom' :class='orders.length > 0 ? "style02" : ""'>

            <ul class='navbar style02 navbar-icon navbar-order' >

               <li @click='select_filter(filter.label)' v-for='(filter, index) in order_status_filter' 
                  :key='index' 
                  :class='filter.active == true ? "active" : ""'>
                  <span class='icon mb10'>
                     <span v-html='filter.icon'></span>
                     <span v-show='filter.count > 0' class='count-order-badge'>{{ filter.count }}</span>
                  </span>
                  <span class='text text-small'>{{ filter.label }}</span>
               </li>
               
            </ul>

            <div v-show='loading_data == false'>

               <div v-if='order_filter.length > 0' class='order-store-header'>
                  <div class='select-wrapper'>
                     <select v-model='order_by_filter_select' class='order_filter_select'>
                        <option :value="{ value: 'desc' } "><?php echo __('New first', 'watergo'); ?></option>
                        <option :value="{ value: 'asc' }"><?php echo __('Old first', 'watergo'); ?></option>
                     </select>
                     <div class='icon'>
                        <svg width="11" height="6" viewBox="0 0 11 6" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M1.5 1L5.5 5L9.5 1" stroke="#252831" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                        </svg>
                     </div>
                  </div>

                  <div class='count-order'><?php echo __('Total order', 'watergo'); ?>: <span >{{total_order}}</span> </div>
               </div>

               <div v-show=' order_filter.length > 0 && ( order_status_current != "complete" && order_status_current != "cancel") ' class='order-store-action'>
                  <div class='form-check'>
                     <input @click='select_all_item' type='checkbox' :checked='is_select_all == true ? true : false'>
                     <label @click='select_all_item'><?php echo __('Select All', 'watergo'); ?> </label>
                  </div>

                  <div class='action-all'>
                     <button v-if='order_status_current == "ordered"' @click='btn_action_all("confirmed")' class='btn-action-confirm'><?php echo __('Confirm', 'watergo'); ?></button>
                     <!-- <button v-if='order_status_current == "ordered"' @click='btn_action_all("cancel")' class='btn-action-cancel'>Cancel</button> -->
                     <button v-if='order_status_current == "confirmed"' @click='btn_action_all("delivering")' class='btn-action-cancel'><?php echo __('Delivery', 'watergo'); ?></button>
                     <button v-if='order_status_current == "delivering"' @click='btn_action_all("complete")' class='btn-action-cancel'><?php echo __('Complete', 'watergo'); ?></button>
                  </div>
               </div>
            </div>

         </div>
      </div>

      <div class='scaffold'>

         <ul v-show='loading_data == false' class='list-order style-store'>
            
            <li 
               :class='"order-status-" + order_status_current'
               v-for='( order, keyOrder ) in order_filter':key='keyOrder'>
               <div class='order-head'>
                  <div v-if='order.order_status != "complete" && order.order_status != "cancel"' class='form-check form-check-order'><input @click='select_item(order.order_id)' type='checkbox' :checked='order.select'></div>
                  <div @click='select_item(order.order_id)' class='text-order-number'>#{{ order.order_number }}</div>
                  <div @click='select_item(order.order_id)' class='text-order-type' :class='get_type_order(order.order_delivery_type)'>{{print_type_order_text(order.order_delivery_type)}}</div>
               </div>
               <div class='order-time'>
                  <span class='tt01'><?php echo __('Ordered Time', 'watergo'); ?>: </span>
                  <span class='tt02'>{{ order_formatDate(order.order_time_created) }}</span>
               </div>
               <div v-if='order.order_time_confirmed != null' class='order-time'>
                  <span class='tt01'><?php echo __('Confirm Time', 'watergo'); ?>: </span>
                  <span class='tt02'>{{ order_formatDate(order.order_time_confirmed) }}</span>
               </div>
               <div v-if='order.order_time_delivery != null' class='order-time'>
                  <span class='tt01'><?php echo __('Delivery Time', 'watergo'); ?>: </span>
                  <span class='tt02'>{{ order_formatDate(order.order_time_delivery) }}</span>
               </div>
               <div v-if='order.order_time_cancel != null' class='order-time'>
                  <span class='tt01'><?php echo __('Cancel Time', 'watergo'); ?>: </span>
                  <span class='tt02'>{{ order_formatDate(order.order_time_cancel) }}</span>
               </div>

               <div 
                  v-for='(product, prodKey) in order.order_products' :key='prodKey' class='order-prods'>
                  <div class='leading'>
                     <img :src="product.order_group_product_image.url">
                  </div>
                  <div class='prod-detail'>
                     <span class='prod-name'>{{ product.order_group_product_metadata.product_name }}</span>
                     <span class='prod-quantity'>{{ product.order_group_product_quantity_count }}x</span>
                  </div>
                  <div class='prod-price' :class='product.order_group_product_discount_percent != 0 ? "has-discount" : ""'>
                     <span class='price'>
                        {{ common_price_after_discount_and_quantity_from_group_order(product) }}
                     </span>
                     <span v-if='product.order_group_product_discount_percent != 0' class='sub-price'>
                        {{ common_price_after_quantity_from_group_order(product) }}
                     </span>
                  </div>
               </div>

               <div class='order-bottom'>
                  <span class='total-product'>{{ count_total_product_in_order(order.order_id) }} <?php echo __('product', 'watergo'); ?></span>
                  <span class='total-price'><?php echo __('Total', 'watergo'); ?>: <span class='t-primary'>{{ count_total_price_in_order(order.order_id) }}</span></span>
               </div>

               <div class='order-func'>
                  <button @click='gotoOrderStoreDetail(order.order_id)' class='btn-action-view'><?php echo __('View', 'watergo'); ?></button>
                  <button 
                     v-if='order.order_status == "ordered"'
                     @click='btn_action_order_single_record(order.order_id, "confirmed")' class='btn-action-confirm'><?php echo __('Confirm', 'watergo'); ?></button>
                  <!-- <button 
                     v-if='order.order_status == "ordered"'
                     @click='btn_action_order_single_record(order.order_id, "cancel")' class='btn-action-cancel'>Cancel</button> -->
                  <button 
                     v-if='order.order_status == "confirmed"' 
                     @click='btn_action_order_single_record(order.order_id, "delivering")' class='btn-action-cancel'><?php echo __('Delivery', 'watergo'); ?></button>
                  <button 
                     v-if='order.order_status == "delivering"' 
                     @click='btn_action_order_single_record(order.order_id, "complete")' class='btn-action-cancel'><?php echo __('Complete', 'watergo'); ?></button>
               </div>

            </li>
         </ul>

         <div v-show='loading_data == true' class='progress-center'>
            <div class='progress-container enabled'><progress class='progress-circular enabled' ></progress></div>
         </div>
      </div>

   </div>

   <div v-show='loading == true'>
      <div class='progress-center'>
         <div class='progress-container enabled'><progress class='progress-circular enabled' ></progress></div>
      </div>
   </div>

   <div v-show='popup_confirm_all_item == true' class='modal-popup open'>
      <div class='modal-wrapper'>
         <p class='heading'><?php echo __("Do you want to confirm <span class='t-primary'>All Order</span>", 'watergo'); ?>?</p>
         <div class='actions'>
            <button @click='btn_modal_cancel_all' class='btn btn-outline'><?php echo __('Cancel', 'watergo'); ?></button>
            <button @click='btn_do_all_action' class='btn btn-primary'><?php echo __('Confirm', 'watergo'); ?></button>
         </div>
      </div>
   </div>
   <div v-show='popup_delivering_all_item == true' class='modal-popup open'>
      <div class='modal-wrapper'>
         <p class='heading'><?php echo __("Do you want to delivering <span class='t-primary'>All Order</span>", 'watergo'); ?>?</p>
         <div class='actions'>
            <button @click='btn_modal_cancel_all' class='btn btn-outline'><?php echo __('Cancel', 'watergo'); ?></button>
            <button @click='btn_do_all_action' class='btn btn-primary'><?php echo __('Confirm', 'watergo'); ?></button>
         </div>
      </div>
   </div>
   <div v-show='popup_complete_all_item == true' class='modal-popup open'>
      <div class='modal-wrapper'>
         <p class='heading'><?php echo __("Do you want to complete <span class='t-primary'>All Order</span>", 'watergo'); ?>?</p>
         <div class='actions'>
            <button @click='btn_modal_cancel_all' class='btn btn-outline'><?php echo __('Cancel', 'watergo') ?></button>
            <button @click='btn_do_all_action' class='btn btn-primary'><?php echo __('Confirm', 'watergo') ?></button>
         </div>
      </div>
   </div>
   <div v-show='popup_cancel_all_item == true' class='modal-popup open style01'>
      <div class='modal-wrapper'>
         <div class='modal-close style-static'><div @click='btn_modal_cancel_all' class='close-button'><span></span><span></span></div></div>
         <p class='tt01'><?php echo __("Why do you want to cancel <span class='t-primary'>All Order</span>", 'watergo'); ?>?</p>
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
            <button @click='btn_do_all_action' class='btn btn-primary'>
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


</div>
<script>

var app = Vue.createApp({
   data (){
      return {

         loading: false,
         loading_data: false,
         popup_confirm_all_item: false,
         popup_delivering_all_item: false,
         popup_complete_all_item: false,
         popup_cancel_all_item: false,

         message_count: 0,
         notification_count: 0,

         total_order: 0,

         paged: 0,

         is_select_all: false,
         // IF ORDER SELECT -> BUTTON CAN ACCESS

         status_change_all: '',

         orders: [],

         order_by_filter_select: { value: 'desc' },

         order_id_selected: [],

         get_locale: '<?php echo get_locale(); ?>',

         order_status_current: 'ordered',
         order_status_filter: [ 
            {
               label: `<?php 
                  if(get_locale() == 'vi'){ echo 'Đơn Mới';
                  }else if(get_locale() == 'ko_KR'){ echo 'Ordered'; 
                  }else{ echo 'Ordered'; }
               ?>`, value: 'ordered', active: true, 
               icon: `
                  <svg width="36" height="36" viewBox="0 0 36 36" fill="none" xmlns="http://www.w3.org/2000/svg">
                  <circle cx="18" cy="18" r="17.75" fill="white" stroke="#7B7D83" stroke-width="0.5"/>
                  <mask id="path-2-inside-1_2649_263" fill="white">
                  <path d="M24.7868 13.5737L15.8606 22.5L11.8032 18.4426"/>
                  </mask>
                  <path d="M26.201 14.9879C26.9821 14.2069 26.9821 12.9406 26.201 12.1595C25.42 11.3785 24.1537 11.3785 23.3726 12.1595L26.201 14.9879ZM15.8606 22.5L14.4464 23.9142C14.8215 24.2892 15.3302 24.5 15.8606 24.5C16.391 24.5 16.8997 24.2892 17.2748 23.9142L15.8606 22.5ZM13.2174 17.0284C12.4364 16.2473 11.1701 16.2473 10.389 17.0284C9.60796 17.8094 9.60796 19.0757 10.389 19.8568L13.2174 17.0284ZM23.3726 12.1595L14.4464 21.0857L17.2748 23.9142L26.201 14.9879L23.3726 12.1595ZM17.2748 21.0857L13.2174 17.0284L10.389 19.8568L14.4464 23.9142L17.2748 21.0857Z" fill="#7B7D83" mask="url(#path-2-inside-1_2649_263)"/>
                  </svg>
               `,
               count: 0 
            },
            {
               label: `<?php 
                  if(get_locale() == 'vi'){ echo 'Cần Giao';
                  }else if(get_locale() == 'ko_KR'){ echo 'Confirmed'; 
                  }else{ echo 'Confirmed'; }
               ?>`, value: 'confirmed', active: false,
               icon: `
                  <svg width="38" height="38" viewBox="0 0 38 38" fill="none" xmlns="http://www.w3.org/2000/svg">
                  <circle cx="18.7234" cy="19.2766" r="18.4734" fill="white" stroke="#7B7D83" stroke-width="0.5"/>
                  <mask id="path-2-inside-1_2649_264" fill="white">
                  <path d="M24.5554 17.1279V25.1084H13.5055V17.1279"/>
                  </mask>
                  <path d="M26.0554 17.1279C26.0554 16.2995 25.3838 15.6279 24.5554 15.6279C23.7269 15.6279 23.0554 16.2995 23.0554 17.1279H26.0554ZM24.5554 25.1084V26.6084C25.3838 26.6084 26.0554 25.9368 26.0554 25.1084H24.5554ZM13.5055 25.1084H12.0055C12.0055 25.9368 12.6771 26.6084 13.5055 26.6084V25.1084ZM15.0055 17.1279C15.0055 16.2995 14.3339 15.6279 13.5055 15.6279C12.6771 15.6279 12.0055 16.2995 12.0055 17.1279H15.0055ZM23.0554 17.1279V25.1084H26.0554V17.1279H23.0554ZM24.5554 23.6084H13.5055V26.6084H24.5554V23.6084ZM15.0055 25.1084V17.1279H12.0055V25.1084H15.0055Z" fill="#7B7D83" mask="url(#path-2-inside-1_2649_264)"/>
                  <path d="M13.0277 16.378V14.8086H25.0331V16.378H13.0277Z" stroke="#7B7D83" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                  <path d="M17.8026 19.5835H20.2581" stroke="#7B7D83" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                  </svg>
               `,
               count: 0 
            },
            {
               label: `<?php 
                  if(get_locale() == 'vi'){ echo 'Đang Giao';
                  }else if(get_locale() == 'ko_KR'){ echo 'Delivering'; 
                  }else{ echo 'Delivering'; }
               ?>`, value: 'delivering', active: false, 
               icon: `
                  <svg width="37" height="37" viewBox="0 0 37 37" fill="none" xmlns="http://www.w3.org/2000/svg">
                  <circle cx="18.2553" cy="18.7446" r="18.0053" fill="white" stroke="#7B7D83" stroke-width="0.5"/>
                  <path d="M12.7207 20.6882V14.4072H20.1987V20.6882H12.7207Z" stroke="#7B7D83" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                  <path d="M21.6987 17.3999H23.0322L24.3885 18.7562V20.6882H21.6987V17.3999Z" stroke="#7B7D83" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                  <path d="M15.4105 22.9343C15.4105 23.3465 15.0764 23.6807 14.6642 23.6807C14.252 23.6807 13.9178 23.3465 13.9178 22.9343C13.9178 22.5221 14.252 22.188 14.6642 22.188C15.0764 22.188 15.4105 22.5221 15.4105 22.9343Z" stroke="#7B7D83" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                  <path d="M23.1914 22.9343C23.1914 23.3465 22.8573 23.6807 22.4451 23.6807C22.0329 23.6807 21.6987 23.3465 21.6987 22.9343C21.6987 22.5221 22.0329 22.188 22.4451 22.188C22.8573 22.188 23.1914 22.5221 23.1914 22.9343Z" stroke="#7B7D83" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                  </svg>
               `,
               count: 0 
            },
            {
               label: `<?php 
                  if(get_locale() == 'vi'){ echo 'Đã Giao';
                  }else if(get_locale() == 'ko_KR'){ echo 'Complete'; 
                  }else{ echo 'Complete'; }
               ?>`, value: 'complete', active: false, 
               icon: `
                  <svg width="37" height="37" viewBox="0 0 37 37" fill="none" xmlns="http://www.w3.org/2000/svg">
                  <circle cx="18.5" cy="18.5" r="18.25" fill="white" stroke="#7B7D83" stroke-width="0.5"/>
                  <path d="M18.2623 11.6505C18.3371 11.4202 18.6629 11.4202 18.7378 11.6505L19.8092 14.948C20.0435 15.669 20.7154 16.1572 21.4735 16.1572H24.9407C25.1829 16.1572 25.2836 16.4671 25.0876 16.6094L22.2827 18.6474C21.6693 19.093 21.4127 19.8829 21.6469 20.6039L22.7183 23.9014C22.7932 24.1317 22.5296 24.3233 22.3336 24.1809L19.5286 22.143C18.9153 21.6973 18.0847 21.6973 17.4714 22.143L14.6664 24.1809L15.1072 24.7877L14.6664 24.1809C14.4705 24.3233 14.2069 24.1317 14.2817 23.9014L15.3531 20.604C15.5874 19.8829 15.3307 19.093 14.7174 18.6474L11.9124 16.6094C11.7165 16.4671 11.8172 16.1572 12.0593 16.1572H15.5265C16.2846 16.1572 16.9566 15.669 17.1908 14.948L18.2623 11.6505Z" fill="white" stroke="#7B7D83" stroke-width="1.5"/>
                  </svg>
               `,
               count: 0 
            },
            {
               label: `<?php 
                  if(get_locale() == 'vi'){ echo 'Đã Huỷ';
                  }else if(get_locale() == 'ko_KR'){ echo 'Cancel'; 
                  }else{ echo 'Cancel'; }
               ?>`, value: 'cancel', active: false,
               icon: `
                  <svg width="36" height="36" viewBox="0 0 36 36" fill="none" xmlns="http://www.w3.org/2000/svg">
                  <circle cx="18" cy="18" r="17.75" fill="white" stroke="#7B7D83" stroke-width="0.5"/>
                  <path d="M23.6065 12.3936L12.3934 23.6067" stroke="#7B7D83" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                  <path d="M12.3934 12.3936L23.6065 23.6067" stroke="#7B7D83" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                  </svg>
               `,
               count: 0
            }
         ],

         // Reason for cancellation: 
         // Misplaced product Đặt nhầm sản phẩm
         // Change delivery information Thay đổi thông tin giao hàng
         // Change delivery time Thay đổi thời gian giao hàng
         // The store requested cancellation  Cửa hàng yêu cầu hủy
         reason_cancel: [
            {label: '<?php echo __('Misplaced product', 'watergo');?>', active: false},
            {label: '<?php echo __('Change delivery information', 'watergo'); ?>', active: false},
            {label: '<?php echo __('Change delivery time', 'watergo'); ?>', active: false},
            {label: '<?php echo __('The store requested cancellation', 'watergo'); ?>', active: false},
            {label: '<?php echo __("Others", 'watergo'); ?>', active: false}
         ],

      }
   },

   methods: {

      async atlantis_count_messeage_everytime(){ await window.atlantis_count_messeage_everytime() },

      common_price_after_discount_and_quantity_from_group_order(p){ return window.common_price_after_discount_and_quantity_from_group_order(p)},
      common_price_after_quantity_from_group_order(p){ return window.common_price_after_quantity_from_group_order(p)},

      gotoNotificationIndex(){ window.gotoNotificationIndex()},
      gotoChat(){ window.gotoChat(); },

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


      btn_modal_cancel_all(){ 
         this.popup_confirm_all_item = false;
         this.popup_cancel_all_item = false;
         this.popup_delivering_all_item = false;
         this.popup_complete_all_item = false;
      },

      // FOR SINGLE BUTTON
      async btn_action_order_single_record(order_id, order_status){
         var _arr = [ parseInt(order_id) ];
         await this.btn_action_order_status( _arr, order_status );
      },

      // THIS FUNCTION WILL AJAX ALL ACTION 
      async btn_action_order_status(order_ids, order_status){
         var timestamp = Math.floor(Date.now() / 1000);
         var form = new FormData();
         form.append('action', 'atlantis_order_status');
         form.append('order_id', JSON.stringify(order_ids));
         form.append('status', order_status);
         form.append('timestamp', timestamp);
         var r = await window.request(form);
         // console.log(r)
         if( r != undefined ){
            var res = JSON.parse( JSON.stringify(r));
            if( res.message == 'order_status_ok'){
               await this.reset_get_order_store();
            }
         }
      },

      // BUTTON SHOW POPUP MODEL WHEN TOGGLE SELECT OR SINGLE PRODUCT
      btn_action_all( change_status ){
         var _is_order_select = false;

         this.orders.forEach( od => {
            if( od.select == true ){ _is_order_select = true }
         });

         // CHECK IS ORDER SELECT?
         if( _is_order_select == true ){
            if( change_status == 'confirmed' ) {this.popup_confirm_all_item = true;}
            if( change_status == 'delivering' ) {this.popup_delivering_all_item = true;}
            if( change_status == 'complete' ) {this.popup_complete_all_item = true;}
            if( change_status == 'cancel' ) {this.popup_cancel_all_item = true;}
            this.status_change_all = change_status;
         }
         
      },

      // BUTTON DO ALL ACTION
      async btn_do_all_action(){
         var order_ids = [];

         
         this.orders.forEach( od => {
            if( od.select == true ){ order_ids.push( parseInt( od.order_id) ); }
         });
         
         if( this.status_change_all != 'cancel' ){
            if( order_ids.length > 0 ){
               this.btn_modal_cancel_all();
               await this.btn_action_order_status(order_ids, this.status_change_all );
               await this.reset_get_order_store();
               this.btn_modal_cancel_all();
            }
         }

         // SPECIAL FOR CANCEL ALL ORDER
         if( this.status_change_all == 'cancel' ){
            var _is_reason_select = false;
            this.reason_cancel.forEach( reason => {
               if(reason.active == true ){ _is_reason_select = true; }
            });
            if(_is_reason_select == true ){
               if( order_ids.length > 0 ){
                  this.btn_modal_cancel_all();
                  await this.btn_action_order_status(order_ids, this.status_change_all );
                  await this.reset_get_order_store();
                  this.status_change_all = '';
               }
            }
         }

      },

      async reset_get_order_store(){
         this.loading_data = true;
         this.paged = 0;
         this.orders = [];
         this.total_count = 0;
         this.order_by_filter_select = { value: 'desc' };
         await this.get_count_total_order();
         await this.get_order_store(this.order_status_current, this.paged);
         await this.get_notification_count();
         window.appbar_fixed();
         this.loading_data = false;
         
      },

      select_all_item(){
         this.is_select_all = !this.is_select_all;
         this.orders.forEach(item => item.select = this.is_select_all );
      },

      select_item( order_id ){
         console.log('order_id ' + order_id);
         this.is_select_all = false;
         this.orders.forEach(order => {
            if( order.order_id == order_id ){
               order.select = !order.select;
            }
         });
      },

      select_filter( filter_select ){ 
         this.order_status_filter.some( item => {
            if( item.label == filter_select ){
               item.active = true;
               this.order_status_current = item.value;
            }else{
               this.force_all_select_to_false();
               item.active = false;
            }
         });
      },

      gotoProductDetail(product_id){ window.gotoProductDetail(product_id); },
      gotoStoreDetail(store_id){ window.gotoStoreDetail(store_id); },
      get_type_order(order_type){ return window.get_type_order(order_type)},
      print_type_order_text(order_type){ 
         if( this.get_locale == 'vi' ){
            if( order_type == 'once_date_time' || order_type == 'once_immediately' ) return 'Một Lần';
            if( order_type == 'weekly' ) return 'Hàng tuần';
            if( order_type == 'monthly' ) return 'Hàng tháng';
         }
         return window.print_type_order_text(order_type);
      },
      
      order_formatDate(timestamp){ return window.order_formatDate(timestamp);},

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
               order.order_products.some( product => {
                  _total += parseInt( product.order_group_product_quantity_count );
               });
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
               this.notification_count = parseInt(res.data);
            }
         }
      },

      async get_count_total_order(){
         // this.order_status_filter.some(item => item.count = 0);
         var form = new FormData();
         form.append('action', 'atlantis_count_total_order_by_status');
         var r = await window.request(form);
         
         console.log(r);

         if( r != undefined ){
            var res = JSON.parse( JSON.stringify( r ));
            if( res.message == 'count_order_by_status' ){
               res.data.forEach( item => {
                  var _total_count = item.total_count;
                  var _order_status = this.order_status_filter.find( order_status => order_status.value == item.order_status );
                  _order_status.count = _total_count;
               });
            }
         }
      },

      async get_order_store( order_status, paged ){
         var form = new FormData();
         form.append('action', 'atlantis_get_order_store');
         form.append('order_status', order_status);
         form.append('paged', paged);
         var r = await window.request(form);
         if( r != undefined ){
            var res = JSON.parse( JSON.stringify( r ));
            if( res.message == 'get_order_ok' ){
               res.data.forEach( order => {
                  order.select = false;
                  if( !this.orders.some( existingItem => existingItem.order_id === order.order_id )){
                     this.orders.push( order );
                  }
               });
               this.total_order = this.orders.length;
            }
         }
      },

      gotoOrderStoreDetail(order_id){ window.gotoOrderStoreDetail(order_id)},

      async handleScroll() {
         const windowTop = window.pageYOffset || document.documentElement.scrollTop;
         const scrollEndThreshold = 50; // Adjust this value as needed
         const scrollPosition = window.pageYOffset || document.documentElement.scrollTop;
         const windowHeight = window.innerHeight;
         const documentHeight = document.documentElement.scrollHeight;

         var windowScroll     = scrollPosition + windowHeight + scrollEndThreshold;
         var documentScroll   = documentHeight + scrollEndThreshold;

         // if (scrollPosition + windowHeight + 10 >= documentHeight) {
         if (scrollPosition + windowHeight >= documentHeight ) {

            await this.get_order_store( this.order_status_current, this.paged++ );
         }
      }
      
   },

   mounted() {
      window.addEventListener('scroll', this.handleScroll);
   },
   beforeDestroy() {
      window.removeEventListener('scroll', this.handleScroll);
   }, 

   // STREAM ORDER STATUS -> reload order
   watch: {
      order_status_current: async function( filter ){
         this.loading_data = true;
         await this.get_count_total_order();
         this.paged = 0;
         this.orders = [];
         this.total_count = 0;
         this.order_by_filter_select = { value: 'desc' };
         await this.get_order_store(filter, this.paged);
         window.appbar_fixed();
         this.loading_data = false;
      },
   },

   computed: {
      
      order_filter(){
         var _filter_orders = this.orders;
         if(this.order_by_filter_select.value == 'asc'){
            _filter_orders.sort((a,b) => a.order_id - b.order_id );
         }
         if(this.order_by_filter_select.value == 'desc'){
            _filter_orders.sort((a,b) => b.order_id - a.order_id );
         }
         if( _filter_orders.length == 0 ){ return []; }
         return _filter_orders;
      }
   },

   async created(){
      
      this.loading = true;

      setInterval( async () => { await this.atlantis_count_messeage_everytime(); }, 1500);
      
      await this.get_count_total_order();
      await this.get_order_store( this.order_status_current, 0 );
      await this.get_notification_count();

      // console.log(this.orders)
      
      this.loading = false;

      window.appbar_fixed();
   },
   
}).mount('#app');

window.app = app;


</script>
