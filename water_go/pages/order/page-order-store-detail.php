<style>
   .list-tile.order .list-items .list-items-wrapper{
      flex-flow: row wrap;
   }
   .box-textarea{
      margin-top: 10px;
      margin-bottom: 20px;
      padding-bottom: 10px;
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

   <div v-if="loading == false && order != null && order.order_hidden == 0" class='page-order-detail'>

      <div class='appbar style01'>
         <div class='appbar-top'>
            <div class='leading'>
               <button @click='goBack' class='btn-action'>
                  <svg width="20" height="16" viewBox="0 0 20 16" fill="none" xmlns="http://www.w3.org/2000/svg">
                  <path fill-rule="evenodd" clip-rule="evenodd" d="M0 8C0 7.44772 0.447715 7 1 7H18.5C19.0523 7 19.5 7.44772 19.5 8C19.5 8.55228 19.0523 9 18.5 9H1C0.447715 9 0 8.55228 0 8Z" fill="#252831"/>
                  <path fill-rule="evenodd" clip-rule="evenodd" d="M10.5309 0.375342C10.8759 0.806604 10.806 1.4359 10.3747 1.78091L2.60078 8.00004L10.3747 14.2192C10.806 14.5642 10.8759 15.1935 10.5309 15.6247C10.1859 16.056 9.55657 16.1259 9.12531 15.7809L0.375305 8.78091C0.13809 8.59113 0 8.30382 0 8.00004C0 7.69625 0.13809 7.40894 0.375305 7.21917L9.12531 0.219168C9.55657 -0.125842 10.1859 -0.0559202 10.5309 0.375342Z" fill="#252831"/>
                  </svg>
               </button>
               <p class='leading-title' v-if='order != null && order.order_number != null'>#{{ order.order_number }}</p>
               <!--  -->
            </div>
         </div>
         <div class='break-line'></div> 
      </div>


      <div v-if='order != null'  class='inner'>
         <div class='list-tile delivery-address style-order style01'>
            <div class='content'>
               <p class='tt01'><?php echo __('Delivery address', 'watergo'); ?></p>
               <p class='tt03' v-if='order.order_delivery_address != null'>{{ order.order_delivery_address.address }}</p>
               <p class='tt02' v-if='order.order_delivery_address != null'>{{ order.order_delivery_address.name }} {{ hasMoreThanTwoZeroes(order.order_delivery_address.phone) ? ' | (+84) ' + removeZeroLeading( order.order_delivery_address.phone ) : '' }}</p>
            </div>
         </div>
      </div>

      <div class='break-line'></div> 

      <ul class='list-tile order order-store-detail'>

         <li>
            <div class='heading'><?php echo __('Order', 'watergo'); ?></div>

            <div 
               v-if='order != null && order.order_products != undefined'
               v-for='(product, product_key) in order.order_products' :key='product_key'
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
                     <span v-if='product.order_group_product_discount_percent != 0' class='od-price-discount'>
                        {{ common_price_after_quantity_from_group_order(product) }}
                     </span>
                  </div>
               </div>
            </div>

         </li>
      </ul>

      <div class='box-delivery-time'>
         <p class='tt01'><?php echo __('Delivery time', 'watergo'); ?></p>
         <p class='tt02' v-if='order != null && get_delivery_time_activity != null'>{{ get_delivery_time_activity }}</p>
         <p class='tt03' v-if='order != null && order.order_delivery_type == "once_immediately"'><?php echo __('Immediately (within 2 hour)', 'watergo'); ?> </p>
         <div
            v-if='order.order_delivery_type == "once_date_time"' class='display_delivery_time'
         >
            <div class='date_time_item'>{{ order.order_time_shipping.order_time_shipping_day }}</div>
            <div class='date_time_item'>{{ add_extra_space_order_time_shipping_time(order.order_time_shipping.order_time_shipping_time) }}</div>
         </div>
         <div
            v-if='order.order_delivery_type == "weekly" || order.order_delivery_type == "monthly"'
            v-for='( ship_item, ship_key ) in order.order_setting_shipping.settings' :key='ship_key'
            class='display_delivery_time'
            :class='ship_item.day == order.order_time_shipping.order_time_shipping_day ? "highlight" : ""'
         >
            <div v-if='order.order_delivery_type == "weekly"' class='date_time_item'>{{ get_shortname_day_of_week(ship_item.day) }} - {{ ship_item.datetime }}</div>
            <div v-if='order.order_delivery_type == "weekly"' class='date_time_item'>{{ add_extra_space_order_time_shipping_time(ship_item.time) }}</div>
            <div v-if='order.order_delivery_type == "monthly"' class='date_time_item'><?php echo __('Date', 'watergo'); ?> {{ ship_item.day }} - {{ ship_item.datetime }}</div>
            <div v-if='order.order_delivery_type == "monthly"' class='date_time_item'>{{ add_extra_space_order_time_shipping_time(ship_item.time) }}</div>
         </div>
      </div>

      <div class='break-line'></div>
      <div class='box-payment-method'>
         <p class='heading-02'><?php echo __('Payment method', 'watergo'); ?> </p>
         <p class='heading-03'><?php echo __('By Cash', 'watergo'); ?> </p>
      </div>

      <div class='break-line'></div>
      <div class='box-time-order'>
         <p class='heading-03' v-if='order != null && order.order_time_created != undefined '><?php echo __('Ordered Time', 'watergo'); ?>: <span class='t-6 ml5'>{{ order_formatDate(order.order_time_created) }}</span></p>
         <p v-if='order != null && order.order_time_confirmed != null && order.order_time_confirmed != "" && order.order_time_confirmed != 0 ' class='heading-03'><?php echo __('Confirmed Time', 'watergo'); ?>: <span class='t-6 ml5'>{{ order_formatDate(order.order_time_confirmed ) }}</span></p>
         <p v-if='order != null && order.order_time_delivery != null && order.order_time_delivery != "" && order.order_time_delivery != 0 ' class='heading-03'><?php echo __('Delivery Time', 'watergo'); ?>: <span class='t-6 ml5'>{{ order_formatDate(order.order_time_delivery) }}</span></p>
         <p v-if='order != null && order.order_time_completed != null && order.order_time_completed != "" && order.order_time_completed != 0 ' class='heading-03'><?php echo __('Complete Time', 'watergo'); ?>: <span class='t-6 ml5'>{{ order_formatDate(order.order_time_completed) }}</span></p>
         <p v-if='order != null && order.order_time_cancel != null && order.order_time_cancel != "" && order.order_time_cancel != 0 ' class='heading-03'><?php echo __('Cancel Time', 'watergo'); ?>: <span class='t-6 ml5'>{{ order_formatDate(order.order_time_cancel) }}</span></p>
      </div>

      <div v-if='order != null && order.order_note != null && order.order_note != ""' class='inner'>
         <div class='box-textarea'>
            <textarea ref='input_order_note' class='input_order_note' readonly>{{order.order_note}}</textarea>
         </div>
      </div>

      <div class='break-line'></div>

      <div class='box-func-order-detail-store'>
         
         <button  
            v-show='is_user_can_chat == true'
            @click='atlantis_create_conversation_or_get_it(order)' 
            class='btn-chat'>
            <span class='icon'>
               <svg width="22" height="20" viewBox="0 0 22 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                  <path fill-rule="evenodd" clip-rule="evenodd" d="M15.3473 0H3.06937C2.2553 0 1.47456 0.334446 0.898924 0.929764C0.323286 1.52508 -0.000102997 2.33251 -0.000102997 3.17441V9.52324C-0.000102997 9.94011 0.0792904 10.3529 0.233545 10.738C0.387802 11.1232 0.613897 11.4731 0.898924 11.7679C1.18395 12.0627 1.52233 12.2965 1.89473 12.456C2.26714 12.6155 2.66628 12.6977 3.06937 12.6977H4.91106H9.46247H15.3473C16.1613 12.6977 16.9421 12.3632 17.5177 11.7679C18.0934 11.1726 18.4167 10.3652 18.4167 9.52324V3.17441C18.4167 2.33251 18.0934 1.52508 17.5177 0.929764C16.9421 0.334446 16.1613 0 15.3473 0ZM15.3473 1.26977H3.06937C2.58093 1.26977 2.11249 1.47043 1.7671 1.82762C1.42172 2.18482 1.22769 2.66927 1.22769 3.17441V9.52324C1.22769 10.0284 1.42172 10.5128 1.7671 10.87C2.11249 11.2272 2.58093 11.4279 3.06937 11.4279H15.3473C15.8357 11.4279 16.3042 11.2272 16.6495 10.87C16.9949 10.5128 17.189 10.0284 17.189 9.52324V3.17441C17.189 2.66927 16.9949 2.18482 16.6495 1.82762C16.3042 1.47043 15.8357 1.26977 15.3473 1.26977Z" fill="#2790F9"/>
                  <path d="M3.06937 1.26977H15.3473C15.8357 1.26977 16.3042 1.47043 16.6495 1.82762C16.9949 2.18482 17.189 2.66927 17.189 3.17441V9.52324C17.189 10.0284 16.9949 10.5128 16.6495 10.87C16.3042 11.2272 15.8357 11.4279 15.3473 11.4279H3.06937C2.58093 11.4279 2.11249 11.2272 1.7671 10.87C1.42172 10.5128 1.22769 10.0284 1.22769 9.52324V3.17441C1.22769 2.66927 1.42172 2.18482 1.7671 1.82762C2.11249 1.47043 2.58093 1.26977 3.06937 1.26977Z" fill="white"/>
                  <path fill-rule="evenodd" clip-rule="evenodd" d="M18.7231 4.76165H6.44521C5.95676 4.76165 5.48832 4.96232 5.14294 5.31951C4.79756 5.6767 4.60352 6.16115 4.60352 6.6663V13.0151C4.60352 13.5203 4.79756 14.0047 5.14294 14.3619C5.48832 14.7191 5.95676 14.9198 6.44521 14.9198H12.5842C12.6648 14.9196 12.7447 14.9359 12.8193 14.9677C12.8939 14.9995 12.9617 15.0462 13.0188 15.1052L15.6536 17.8313V15.5547C15.6536 15.3863 15.7183 15.2248 15.8334 15.1057C15.9486 14.9867 16.1047 14.9198 16.2675 14.9198H18.7231C19.2116 14.9198 19.68 14.7191 20.0254 14.3619C20.3708 14.0047 20.5648 13.5203 20.5648 13.0151V6.6663C20.5648 6.16115 20.3708 5.6767 20.0254 5.31951C19.68 4.96232 19.2116 4.76165 18.7231 4.76165ZM6.44521 3.49188H18.7231C19.5372 3.49188 20.3179 3.82633 20.8936 4.42165C21.4692 5.01696 21.7926 5.82439 21.7926 6.6663V13.0151C21.7926 13.432 21.7132 13.8448 21.5589 14.2299C21.4047 14.6151 21.1786 14.965 20.8936 15.2598C20.6085 15.5545 20.2702 15.7884 19.8977 15.9479C19.5253 16.1074 19.1262 16.1895 18.7231 16.1895H16.8814V19.364C16.8816 19.4897 16.8458 19.6127 16.7783 19.7173C16.7109 19.8219 16.6149 19.9034 16.5026 19.9516C16.3903 19.9997 16.2667 20.0123 16.1475 19.9877C16.0282 19.9631 15.9187 19.9025 15.8329 19.8135L12.33 16.1895H6.44521C5.63113 16.1895 4.8504 15.8551 4.27476 15.2598C3.69912 14.6645 3.37573 13.857 3.37573 13.0151V6.6663C3.37573 5.82439 3.69912 5.01696 4.27476 4.42165C4.8504 3.82633 5.63113 3.49188 6.44521 3.49188Z" fill="#2790F9"/>
                  <path d="M18.7231 4.76165H6.44521C5.95676 4.76165 5.48832 4.96232 5.14294 5.31951C4.79756 5.6767 4.60352 6.16115 4.60352 6.6663V13.0151C4.60352 13.5203 4.79756 14.0047 5.14294 14.3619C5.48832 14.7191 5.95676 14.9198 6.44521 14.9198H12.5842C12.6648 14.9196 12.7447 14.9359 12.8193 14.9677C12.8939 14.9995 12.9617 15.0462 13.0188 15.1052L15.6536 17.8313V15.5547C15.6536 15.3863 15.7183 15.2248 15.8334 15.1057C15.9486 14.9867 16.1047 14.9198 16.2675 14.9198H18.7231C19.2116 14.9198 19.68 14.7191 20.0254 14.3619C20.3708 14.0047 20.5648 13.5203 20.5648 13.0151V6.6663C20.5648 6.16115 20.3708 5.6767 20.0254 5.31951C19.68 4.96232 19.2116 4.76165 18.7231 4.76165Z" fill="white"/>
                  <path d="M10.1294 9.32349C10.1294 9.70494 9.82017 10.0142 9.43872 10.0142C9.05727 10.0142 8.74805 9.70494 8.74805 9.32349C8.74805 8.94204 9.05727 8.63282 9.43872 8.63282C9.82017 8.63282 10.1294 8.94204 10.1294 9.32349Z" fill="#2790F9"/>
                  <path d="M13.2602 9.30974C13.2602 9.69118 12.951 10.0004 12.5695 10.0004C12.1881 10.0004 11.8789 9.69118 11.8789 9.30974C11.8789 8.92829 12.1881 8.61906 12.5695 8.61906C12.951 8.61906 13.2602 8.92829 13.2602 9.30974Z" fill="#2790F9"/>
                  <path d="M16.3682 9.3235C16.3682 9.70494 16.059 10.0142 15.6776 10.0142C15.2961 10.0142 14.9869 9.70494 14.9869 9.3235C14.9869 8.94205 15.2961 8.63282 15.6776 8.63282C16.059 8.63282 16.3682 8.94205 16.3682 9.3235Z" fill="#2790F9"/>
               </svg>
            </span>
            <span class='text'>Chat</span>
         </button>

         <a v-if='order != null && order.order_delivery_address.phone != undefined' :href='"tel:" + order.order_delivery_address.phone' class='btn-call'>
            <span class='icon'>
               <svg width="16" height="20" viewBox="0 0 16 20" fill="none" xmlns="http://www.w3.org/2000/svg">
               <path d="M2.46324 0.532123L3.84663 0.115438C4.47637 -0.0745494 5.15373 -0.028874 5.75226 0.243938C6.35079 0.51675 6.82958 0.998053 7.09927 1.598L7.96014 3.51308C8.1921 4.02899 8.25672 4.60458 8.14493 5.15908C8.03313 5.71358 7.75053 6.21916 7.33678 6.60488L5.83255 8.00743C5.81396 8.0248 5.79871 8.04541 5.78754 8.06827C5.63004 8.38995 5.86921 9.24915 6.61841 10.5475C7.46345 12.0109 8.11598 12.5893 8.41849 12.5001L10.3927 11.8959C10.9334 11.7308 11.5122 11.739 12.048 11.9194C12.5837 12.0998 13.0496 12.4433 13.3804 12.9018L14.6037 14.596C14.9878 15.128 15.1657 15.7813 15.1044 16.4346C15.0431 17.0878 14.7468 17.6966 14.2704 18.1479L13.2179 19.1437C12.8518 19.4904 12.4074 19.7434 11.9224 19.8811C11.4374 20.0189 10.9263 20.0372 10.4327 19.9346C7.50178 19.3246 4.87584 16.9645 2.53241 12.906C0.188144 8.84497 -0.54272 5.38649 0.398986 2.54221C0.556623 2.06602 0.826564 1.63478 1.186 1.28492C1.54544 0.935054 1.98298 0.67685 2.46324 0.532123ZM2.82492 1.72884C2.53675 1.81564 2.27371 1.97052 2.05801 2.18041C1.84232 2.3903 1.68032 2.64903 1.5857 2.93472C0.774002 5.38566 1.43153 8.49912 3.61495 12.2809C5.79671 16.0603 8.16181 18.1854 10.6869 18.7104C10.9832 18.772 11.29 18.761 11.5811 18.6782C11.8723 18.5955 12.139 18.4436 12.3587 18.2354L13.4104 17.2403C13.667 16.9974 13.8266 16.6696 13.8598 16.3179C13.8929 15.9661 13.7971 15.6143 13.5904 15.3277L12.367 13.6327C12.1889 13.3858 11.9381 13.2009 11.6497 13.1038C11.3613 13.0066 11.0497 13.0022 10.7586 13.091L8.77934 13.6968C7.68429 14.0227 6.65425 13.1101 5.53587 11.1717C4.58833 9.53166 4.25998 8.34662 4.665 7.51908C4.74333 7.35907 4.85 7.2149 4.98001 7.09323L6.48424 5.69067C6.70712 5.48298 6.85936 5.21071 6.91959 4.91208C6.97983 4.61345 6.94503 4.30345 6.82009 4.0256L5.95922 2.11136C5.81401 1.78822 5.55615 1.529 5.23379 1.38208C4.91143 1.23516 4.54662 1.2106 4.20748 1.31299L2.82409 1.72967L2.82492 1.72884Z" fill="#2790F9"/>
               </svg>
            </span>
            <span class='text'><?php echo __('Call', 'watergo')?></span>
         </a>
      </div>

      <div class='break-line'></div>

      <div class='order-bottomsheet'>
         
         <div 
            v-if='order != null'
            class='product-detail-bottomsheet'
            :class='[
               order.order_status == "complete" || order.order_status == "cancel" ? "on-right" : "cell-re-order",
            ]'
         >
            <p 
            v-if='order != null '
            class='price-total' 
            :class='order.order_status == "complete" ? "pr15" : "" '><?php echo __('Total', 'watergo'); ?>: <span class='t-primary t-bold'>{{ count_total_product_in_order }}</span></p>
            <button :disabled='is_button_has_pressed' @click='btn_order_status("confirmed")' v-if='order.order_status == "ordered"' class='btn-primary'><?php echo __('Confirm', 'watergo'); ?></button>
            <button :disabled='is_button_has_pressed' @click='btn_order_status("delivering")' v-if='order.order_status == "confirmed"' class='btn-primary'><?php echo __('Delivering', 'watergo'); ?></button>
            <button :disabled='is_button_has_pressed' @click='btn_order_status("complete")' v-if='order.order_status == "delivering"' class='btn-primary'><?php echo __('Complete', 'watergo'); ?></button>

         </div>
      </div>

   </div>

   <div class='modal-popup' :class='loading == false && ( order == null || order.order_hidden == 1 ) ? "open" : ""'>
      <div class='modal-wrapper'>
         <div class='modal-close'><div @click='goBack' class='close-button'><span></span><span></span></div></div>
         <p class='heading'><?php echo __('Content Not Found', 'watergo'); ?> </p>
      </div>
   </div>

</div>

<script>

var app = Vue.createApp({
   data (){
      return {
         loading: true,

         time_shipping: [],

         order: null,

         btn_has_pressed: false,

         get_locale: '<?php echo get_locale();?>'
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

      async atlantis_create_conversation_or_get_it(order){ 
         var form = new FormData();
         form.append('action', 'atlantis_create_conversation_or_get_it');
         form.append('order_id', order.order_id);
         form.append('store_id', order.order_store_id);
         form.append('user_id', order.order_by);
         
         var r = await window.request(form);
         if( r != undefined ){
            var res = JSON.parse( JSON.stringify( r));
            if( res.message == 'conversation_found' ){
               var conversation_id   = res.data;
               window.location.href = window.watergo_domain + 'chat/?chat_page=chat-messenger&conversation_id=' + conversation_id + '&order_id=' + order.order_id + '&appt=N';
            }
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
      calculateDistance(lat1, lon1, lat2, lon2){ return window.calculateDistance(lat1, lon1, lat2, lon2)},

      addLeadingZeros(number) {
         if( number != undefined ){
            if (number <= 1000) return number.toString().padStart(4, '0');
            return number.toString();
         }
      },
      

      removeZeroLeading( n ){ return window.removeZeroLeading(n)},
      
      get_total_price( price, quantity, discount){ return window.get_total_price( price, quantity, discount); },
      order_formatDate(timestamp){ return window.order_formatDate(timestamp)},
      get_fulldate_from_day(day ){ return window.get_fulldate_from_day(day) },
      get_fullday_form_dayOfWeek(dayOfWeek ){ return window.get_fullday_form_dayOfWeek(dayOfWeek) },
      // 
      get_shortname_day_of_week(dayOfWeek ){ 
         if( this.get_locale == 'vi' ){
            if(dayOfWeek == 'Monday') return 'T2';
            if(dayOfWeek == 'Tuesday') return 'T3';
            if(dayOfWeek == 'Wednesday') return 'T4';
            if(dayOfWeek == 'Thursday') return 'T5';
            if(dayOfWeek == 'Friday') return 'T6';
            if(dayOfWeek == 'Saturday') return 'T7';
            if(dayOfWeek == 'Sunday') return 'CN';
         }else{
            return window.get_shortname_day_of_week(dayOfWeek);
         }
      },


      goBack(){ window.goBack() },

      async btn_order_status( order_status ){
         this.btn_has_pressed = true;

         var ods = [ parseInt(this.order.order_id )];

         var form = new FormData();
         form.append('action', 'atlantis_order_status');
         form.append('order_id', JSON.stringify(ods));
         form.append('status', order_status);
         var r = await window.request(form);
         if( r != undefined ){
            var res = JSON.parse( JSON.stringify(r));
            if( res.message == 'order_status_ok'){
               if( window.appBridge != undefined ){
                  window.appBridge.refresh();
               }else{
                  location.reload();
               }
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

      

      get_date_from_day_name(datetime, dayName) {
         const daysOfWeek = ['Sunday', 'Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday'];
         const [day, month, year] = datetime.split('/').map(Number);
         const inputDate = new Date(year, month - 1, day);
         const inputDayIndex = inputDate.getDay();
         const targetDayIndex = daysOfWeek.indexOf(dayName);
         let dayDifference = targetDayIndex - inputDayIndex;
         if (dayDifference <= 0) {
            dayDifference += 7;
         }
         inputDate.setDate(inputDate.getDate() + dayDifference);
         var _day    = String(inputDate.getDate()).padStart(2, '0');
         var _month  = String(inputDate.getMonth() + 1).padStart(2, '0');
         var _year   = inputDate.getFullYear();
         const result = `${_day}/${_month}/${_year}`;
         return result;
      },

      get_date_from_day_of_month(datetime, targetDate) {
         const [day, month, year] = datetime.split('/').map(Number);
         const inputDate = new Date(year, month - 1, 1);

         inputDate.setDate(targetDate);
         if (inputDate.getDate() < targetDate) {
            inputDate.setMonth(inputDate.getMonth() + 1);
         }
         var _day    = String(inputDate.getDate()).padStart(2, '0');
         var _month  = String(inputDate.getMonth() + 1).padStart(2, '0');
         var _year   = inputDate.getFullYear();
         const result = `${_day}/${_month}/${_year}`;
         return result;
      },


      async atlantis_get_order_detail( order_id ){
         var form = new FormData();
         form.append('action', 'atlantis_get_order_detail');
         form.append('order_id', order_id);
         var r = await window.request(form);
         if( r != undefined ){
            var res = JSON.parse( JSON.stringify( r ));
            if( res.message == 'get_order_ok'){
               this.order = res.data;
               
               if( this.order.order_delivery_type == 'weekly' || this.order.order_delivery_type == 'monthly'){
                  var _day_shipping = this.order.order_time_shipping.order_time_shipping_day;
                  var _datime_shipping = this.order.order_time_shipping.order_time_shipping_datetime;

                  this.order.order_setting_shipping.settings.forEach( item => {
                     if( item.day == _day_shipping ){
                        item.datetime = _datime_shipping;
                     }else{
                        if( this.order.order_delivery_type == 'weekly'){
                           item.datetime = this.get_date_from_day_name(_datime_shipping, item.day);
                        }
                        if( this.order.order_delivery_type == 'monthly'){
                           item.datetime = this.get_date_from_day_of_month(_datime_shipping, item.day);
                        }
                     }
                  });
               }

               

            }
         }
      },
 

   },

   computed: {

      is_user_can_chat(){
         if( this.order != null && ( this.order.order_status == "complete" || this.order.order_status == "cancel" ) ){
            return false;
         }
         return true;
      },

      is_button_has_pressed(){ return this.btn_has_pressed; },

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


   },

   update(){
      window.appbar_fixed();
   },

   async created(){

      this.loading = true;

      const urlParams = new URLSearchParams(window.location.search);
      const order_id = urlParams.get('order_id');

      await this.atlantis_get_order_detail(parseInt(order_id));

      setTimeout(() => {
         window.appbar_fixed();
         this.loading = false;
      },200);
   },



}).mount('#app');

window.app = app;

</script>