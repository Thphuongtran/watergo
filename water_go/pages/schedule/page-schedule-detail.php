<?php 
   $currency = ' đ';
   if( get_locale() == 'ko_KR' ){
      $currency = '동';
   }
?>
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
   .product-detail-bottomsheet .price-total{
      padding-right: 15px;
   }
</style>
<div id='app'>

   <div v-if='loading == false' class='page-order-detail'>

      <div class='appbar style01'>
         <div class='appbar-top'>
            <div class='leading'>

               <button @click='goBack' class='btn-action'>
                  <svg width="20" height="16" viewBox="0 0 20 16" fill="none" xmlns="http://www.w3.org/2000/svg">
                  <path fill-rule="evenodd" clip-rule="evenodd" d="M0 8C0 7.44772 0.447715 7 1 7H18.5C19.0523 7 19.5 7.44772 19.5 8C19.5 8.55228 19.0523 9 18.5 9H1C0.447715 9 0 8.55228 0 8Z" fill="#252831"/>
                  <path fill-rule="evenodd" clip-rule="evenodd" d="M10.5309 0.375342C10.8759 0.806604 10.806 1.4359 10.3747 1.78091L2.60078 8.00004L10.3747 14.2192C10.806 14.5642 10.8759 15.1935 10.5309 15.6247C10.1859 16.056 9.55657 16.1259 9.12531 15.7809L0.375305 8.78091C0.13809 8.59113 0 8.30382 0 8.00004C0 7.69625 0.13809 7.40894 0.375305 7.21917L9.12531 0.219168C9.55657 -0.125842 10.1859 -0.0559202 10.5309 0.375342Z" fill="#252831"/>
                  </svg>
               </button>
               <p class='leading-title' v-if='order != null && order.order_number != undefined'>#{{ order.order_number }}</p>
            </div>
         </div>
         <div class='break-line'></div> 
      </div>


      <div class='inner'>
         <div class='list-tile delivery-address style-order style01'>
            <div class='content'>
               <p class='tt01'><?php echo __('Delivery address', 'watergo'); ?></p>
               <p class='tt03'>{{ order.order_delivery_address.address }}</p>
               <p class='tt02'>{{ order.order_delivery_address.name }} | (+84) {{ removeZeroLeading( order.order_delivery_address.phone ) }}</p>
            </div>
         </div>
      </div>

      <div class='break-line'></div> 



      <div class='tt01-schedule-detail'><?php echo __('Order', 'watergo'); ?></div>

      <ul class='list-tile order schedule-detail'>

         <li v-for='(product, product_key) in order.order_products' :key='product_key'
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
                        {{ common_price_after_discount_and_quantity_from_group_order( product ) }}
                     </span>
                     <span v-if='product.order_group_product_discount_percent != 0' class='od-price-discount'>
                        {{ common_price_after_quantity_from_group_order( product ) }}
                     </span>
                  </div>

               </div>


         </li>
      </ul>

      <div class='box-delivery-time'>
         <p class='tt01'><?php echo __('Delivery time', 'watergo'); ?></p>
         <p class='tt02'>{{ get_delivery_time_activity }}</p>
         <p class='tt03' v-if='order.order_delivery_type == "once_immediately"'><?php echo __('Immediately (within 2 hour)', 'watergo'); ?> </p>
         <div
            v-if='order.order_delivery_type == "once_date_time"'
            class='display_delivery_time'
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
            <div v-if='order.order_delivery_type == "weekly"' class='date_time_item'>{{ get_title_weekly_compact(ship_item.day) }}</div>
            <div v-if='order.order_delivery_type == "weekly"' class='date_time_item'>{{ add_extra_space_order_time_shipping_time(ship_item.time) }}</div>
            <div v-if='order.order_delivery_type == "monthly"' class='date_time_item'><?php echo __('Date', 'watergo'); ?> {{ ship_item.day }}</div>
            <div v-if='order.order_delivery_type == "monthly"' class='date_time_item'>{{ add_extra_space_order_time_shipping_time(ship_item.time) }}</div>
         </div>
      </div>

      <div class='break-line'></div>
      <div class='box-payment-method'>
         <p class='heading-02'><?php echo __('Payment method', 'watergo') ?> </p>
         <p class='heading-03'><?php echo __('By Cash', 'watergo'); ?></p>
      </div>

      <div class='break-line'></div>
      <div class='box-time-order'>
         <p class='heading-03'><?php echo __('Ordered Time', 'watergo'); ?>: <span class='t-6 ml5'>{{ order_formatDate(order.order_time_created) }}</span></p>
         <p class='heading-03'><?php echo __('Confirm Time', 'watergo'); ?>: <span class='t-6 ml5'>{{ order_formatDate(order.order_time_confirmed) }}</span></p>
      </div>

      <div v-show='order.order_note != null && order.order_note != ""' class='inner'>
         <div class='box-textarea'>
            <textarea ref='input_order_note' class='input_order_note' readonly>{{order.order_note}}</textarea>
         </div>
      </div>

      <div class='box-extra-function'>
         <div @click='atlantis_create_conversation_or_get_it(order)' class='b-chat'>
            <button class='btn-action'>
               <svg width="22" height="20" viewBox="0 0 22 20" fill="none" xmlns="http://www.w3.org/2000/svg">
               <path fill-rule="evenodd" clip-rule="evenodd" d="M15.3473 0H3.06939C2.25531 0 1.47458 0.334446 0.898939 0.929764C0.323301 1.52508 -8.7738e-05 2.33251 -8.7738e-05 3.17441V9.52324C-8.7738e-05 9.94011 0.0793056 10.3529 0.233561 10.738C0.387817 11.1232 0.613913 11.4731 0.898939 11.7679C1.18397 12.0627 1.52234 12.2965 1.89475 12.456C2.26715 12.6155 2.6663 12.6977 3.06939 12.6977H4.91107H9.46249H15.3473C16.1614 12.6977 16.9421 12.3632 17.5177 11.7679C18.0934 11.1726 18.4168 10.3652 18.4168 9.52324V3.17441C18.4168 2.33251 18.0934 1.52508 17.5177 0.929764C16.9421 0.334446 16.1614 0 15.3473 0ZM15.3473 1.26977H3.06939C2.58094 1.26977 2.1125 1.47043 1.76712 1.82762C1.42174 2.18482 1.2277 2.66927 1.2277 3.17441V9.52324C1.2277 10.0284 1.42174 10.5128 1.76712 10.87C2.1125 11.2272 2.58094 11.4279 3.06939 11.4279H15.3473C15.8357 11.4279 16.3042 11.2272 16.6496 10.87C16.9949 10.5128 17.189 10.0284 17.189 9.52324V3.17441C17.189 2.66927 16.9949 2.18482 16.6496 1.82762C16.3042 1.47043 15.8357 1.26977 15.3473 1.26977Z" fill="#2790F9"/>
               <path d="M3.06939 1.26977H15.3473C15.8357 1.26977 16.3042 1.47043 16.6496 1.82762C16.9949 2.18482 17.189 2.66927 17.189 3.17441V9.52324C17.189 10.0284 16.9949 10.5128 16.6496 10.87C16.3042 11.2272 15.8357 11.4279 15.3473 11.4279H3.06939C2.58094 11.4279 2.1125 11.2272 1.76712 10.87C1.42174 10.5128 1.2277 10.0284 1.2277 9.52324V3.17441C1.2277 2.66927 1.42174 2.18482 1.76712 1.82762C2.1125 1.47043 2.58094 1.26977 3.06939 1.26977Z" fill="white"/>
               <path fill-rule="evenodd" clip-rule="evenodd" d="M18.7232 4.76171H6.44527C5.95682 4.76171 5.48838 4.96238 5.143 5.31957C4.79762 5.67676 4.60358 6.16121 4.60358 6.66636V13.0152C4.60358 13.5203 4.79762 14.0048 5.143 14.362C5.48838 14.7192 5.95682 14.9198 6.44527 14.9198H12.5842C12.6649 14.9197 12.7448 14.936 12.8194 14.9678C12.894 14.9996 12.9617 15.0463 13.0189 15.1052L15.6537 17.8314V15.5547C15.6537 15.3863 15.7184 15.2249 15.8335 15.1058C15.9486 14.9867 16.1048 14.9198 16.2676 14.9198H18.7232C19.2116 14.9198 19.6801 14.7192 20.0254 14.362C20.3708 14.0048 20.5649 13.5203 20.5649 13.0152V6.66636C20.5649 6.16121 20.3708 5.67676 20.0254 5.31957C19.6801 4.96238 19.2116 4.76171 18.7232 4.76171ZM6.44527 3.49194H18.7232C19.5372 3.49194 20.318 3.82639 20.8936 4.42171C21.4693 5.01703 21.7926 5.82445 21.7926 6.66636V13.0152C21.7926 13.4321 21.7133 13.8448 21.559 14.23C21.4047 14.6151 21.1786 14.9651 20.8936 15.2598C20.6086 15.5546 20.2702 15.7884 19.8978 15.948C19.5254 16.1075 19.1263 16.1896 18.7232 16.1896H16.8815V19.364C16.8817 19.4897 16.8458 19.6127 16.7784 19.7173C16.7109 19.8219 16.615 19.9035 16.5027 19.9516C16.3904 19.9998 16.2668 20.0124 16.1475 19.9878C16.0283 19.9632 15.9188 19.9025 15.833 19.8135L12.3301 16.1896H6.44527C5.63119 16.1896 4.85046 15.8552 4.27482 15.2598C3.69918 14.6645 3.37579 13.8571 3.37579 13.0152V6.66636C3.37579 5.82445 3.69918 5.01703 4.27482 4.42171C4.85046 3.82639 5.63119 3.49194 6.44527 3.49194Z" fill="#2790F9"/>
               <path d="M18.7232 4.76171H6.44527C5.95682 4.76171 5.48838 4.96238 5.143 5.31957C4.79762 5.67676 4.60358 6.16121 4.60358 6.66636V13.0152C4.60358 13.5203 4.79762 14.0048 5.143 14.362C5.48838 14.7192 5.95682 14.9198 6.44527 14.9198H12.5842C12.6649 14.9197 12.7448 14.936 12.8194 14.9678C12.894 14.9996 12.9617 15.0463 13.0189 15.1052L15.6537 17.8314V15.5547C15.6537 15.3863 15.7184 15.2249 15.8335 15.1058C15.9486 14.9867 16.1048 14.9198 16.2676 14.9198H18.7232C19.2116 14.9198 19.6801 14.7192 20.0254 14.362C20.3708 14.0048 20.5649 13.5203 20.5649 13.0152V6.66636C20.5649 6.16121 20.3708 5.67676 20.0254 5.31957C19.6801 4.96238 19.2116 4.76171 18.7232 4.76171Z" fill="white"/>
               <path d="M10.1294 9.32355C10.1294 9.705 9.82017 10.0142 9.43872 10.0142C9.05727 10.0142 8.74805 9.705 8.74805 9.32355C8.74805 8.9421 9.05727 8.63288 9.43872 8.63288C9.82017 8.63288 10.1294 8.9421 10.1294 9.32355Z" fill="#2790F9"/>
               <path d="M13.2602 9.3098C13.2602 9.69124 12.951 10.0005 12.5695 10.0005C12.1881 10.0005 11.8789 9.69124 11.8789 9.3098C11.8789 8.92835 12.1881 8.61912 12.5695 8.61912C12.951 8.61912 13.2602 8.92835 13.2602 9.3098Z" fill="#2790F9"/>
               <path d="M16.3682 9.32356C16.3682 9.70501 16.059 10.0142 15.6776 10.0142C15.2961 10.0142 14.9869 9.70501 14.9869 9.32356C14.9869 8.94211 15.2961 8.63288 15.6776 8.63288C16.059 8.63288 16.3682 8.94211 16.3682 9.32356Z" fill="#2790F9"/>
               </svg>
               <span class='text'>Chat</span>
            </button>
         </div>
         <div class='b-call'>
            <a :href='"tel:" + order.order_delivery_address.phone' class='btn-action'>
               <svg width="16" height="20" viewBox="0 0 16 20" fill="none" xmlns="http://www.w3.org/2000/svg">
               <path d="M2.46324 0.532123L3.84663 0.115438C4.47637 -0.0745494 5.15373 -0.028874 5.75226 0.243938C6.35079 0.51675 6.82958 0.998053 7.09927 1.598L7.96014 3.51308C8.1921 4.02899 8.25672 4.60458 8.14493 5.15908C8.03313 5.71358 7.75053 6.21916 7.33678 6.60488L5.83255 8.00743C5.81396 8.0248 5.79871 8.04541 5.78754 8.06827C5.63004 8.38995 5.86921 9.24915 6.61841 10.5475C7.46345 12.0109 8.11598 12.5893 8.41849 12.5001L10.3927 11.8959C10.9334 11.7308 11.5122 11.739 12.048 11.9194C12.5837 12.0998 13.0496 12.4433 13.3804 12.9018L14.6037 14.596C14.9878 15.128 15.1657 15.7813 15.1044 16.4346C15.0431 17.0878 14.7468 17.6966 14.2704 18.1479L13.2179 19.1437C12.8518 19.4904 12.4074 19.7434 11.9224 19.8811C11.4374 20.0189 10.9263 20.0372 10.4327 19.9346C7.50178 19.3246 4.87584 16.9645 2.53241 12.906C0.188144 8.84497 -0.54272 5.38649 0.398986 2.54221C0.556623 2.06602 0.826564 1.63478 1.186 1.28492C1.54544 0.935054 1.98298 0.67685 2.46324 0.532123ZM2.82492 1.72884C2.53675 1.81564 2.27371 1.97052 2.05801 2.18041C1.84232 2.3903 1.68032 2.64903 1.5857 2.93472C0.774002 5.38566 1.43153 8.49912 3.61495 12.2809C5.79671 16.0603 8.16181 18.1854 10.6869 18.7104C10.9832 18.772 11.29 18.761 11.5811 18.6782C11.8723 18.5955 12.139 18.4436 12.3587 18.2354L13.4104 17.2403C13.667 16.9974 13.8266 16.6696 13.8598 16.3179C13.8929 15.9661 13.7971 15.6143 13.5904 15.3277L12.367 13.6327C12.1889 13.3858 11.9381 13.2009 11.6497 13.1038C11.3613 13.0066 11.0497 13.0022 10.7586 13.091L8.77934 13.6968C7.68429 14.0227 6.65425 13.1101 5.53587 11.1717C4.58833 9.53166 4.25998 8.34662 4.665 7.51908C4.74333 7.35907 4.85 7.2149 4.98001 7.09323L6.48424 5.69067C6.70712 5.48298 6.85936 5.21071 6.91959 4.91208C6.97983 4.61345 6.94503 4.30345 6.82009 4.0256L5.95922 2.11136C5.81401 1.78822 5.55615 1.529 5.23379 1.38208C4.91143 1.23516 4.54662 1.2106 4.20748 1.31299L2.82409 1.72967L2.82492 1.72884Z" fill="#2790F9"/>
               </svg>
               <span class='text'><?php echo __('Call', 'watergo'); ?></span>
            </a>
         </div>
      </div>


      <div class='order-bottomsheet'>
         <div class='product-detail-bottomsheet t-right'>
            <p class='price-total'><?php echo __('Total', 'watergo') ?>: <span class='t-primary t-bold'>{{ count_total_product_in_order }}</span></p>
         </div>
      </div>

   </div>

   
   <div v-if='loading == true'>
      <div class='progress-center'>
         <div class='progress-container enabled'><progress class='progress-circular enabled' ></progress></div>
      </div>
   </div>
   


</div>

<script>


var app = Vue.createApp({
   data (){
      return {
         loading: true,
         order_time_shipping: [],
         order: null,
         get_locale: '<?php echo get_locale(); ?>'
      }
   },

   watch: {
      order: {
         handler( data ){
            if( data.order_note != null && data.order_note.length > 0){

                  this.$nextTick(() => {
                     if( this.$refs.input_order_note != undefined ){
                        const textarea = this.$refs.input_order_note;
                        const lineHeight = 22;
                        const content = textarea.value;
                        const lineBreaksCount = (content.match(/\n/g) || []).length + (content.match(/<br\s*\/?>/g) || []).length;
                        textarea.style.height = `${lineHeight * (lineBreaksCount + 1)}px`;
                     }
                  });

            }
         }, deep: true
      }
   },

   mounted(){
   },

   methods: {

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


      get_weekly_day_compact( title ){
         if( this.get_locale == 'vi' ){
            if( title == 'Monday') return 'Thứ Hai';
            if( title == 'Tuesday') return 'Thứ Ba';
            if( title == 'Wednesday') return 'Thứ Tư';
            if( title == 'Thursday') return 'Thứ Năm';
            if( title == 'Friday') return 'Thứ Sáu';
            if( title == 'Saturday') return 'Thứ Bảy';
            if( title == 'Sunday') return 'Chủ Nhật';
         }
         return title;
      },

      add_extra_space_order_time_shipping_time(n){ return window.add_extra_space_order_time_shipping_time(n)},
      removeZeroLeading( n ){ return window.removeZeroLeading(n)},
      gotoChatMessenger(){
         window.gotoChatMessenger({
            product_id: this.order.order_products[0].order_group_product_id,
            user_id: this.order.order_by,
            store_id: this.order.store_id,
            host_chat: 'store'
         });
      },

      has_discount( product ){ return window.has_discount( product ); },

      common_price_after_discount_and_quantity_from_group_order(p){ return window.common_price_after_discount_and_quantity_from_group_order(p)},
      common_price_after_quantity_from_group_order(p){ return window.common_price_after_quantity_from_group_order(p)},

      get_total_price( price, quantity, discount){ return window.get_total_price( price, quantity, discount); },

      order_formatDate(timestamp){ return window.order_formatDate(timestamp);},
      // END CANCEL ORDER

      async findOrder( order_id ){
         var form = new FormData();
         form.append('action', 'atlantis_get_order_detail');
         form.append('order_id', order_id);
         var r = await window.request(form);
         if( r != undefined ){
            var res = JSON.parse( JSON.stringify( r ));
            if( res.message == 'get_order_ok'){
               this.order = res.data;
            }
         }
      },

      async get_order_timeshipping( order_id ){
         var form = new FormData();
         form.append('action', 'atlantis_get_order_time_shipping');
         form.append('order_id', order_id);
         var r = await window.request(form);
         if( r != undefined ){
            var res = JSON.parse( JSON.stringify( r ) );
            if( res.message == 'order_time_found' ){
               this.order_time_shipping.push(...res.data);
            }
         }

      },

      goBack(){ window.goBack();},
      gotoStoreDetail(store_id){ window.gotoStoreDetail(store_id); },

   },

   computed: {

      count_total_product_in_order(){
         var _total = 0;
         this.order.order_products.some ( product => {
            _total += get_total_price(
               product.order_group_product_price, 
               product.order_group_product_quantity_count, 
               product.order_group_product_discount_percent
            );
         });
         return parseInt(_total).toLocaleString() + ' <?php echo $currency; ?>';
      },

      get_delivery_time_activity(){

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
         if( this.order.order_payment_method == 'cash' ){
            return 'By Cash';
         }
      },
   },


   async created(){
      this.loading = true;
      // this.get_current_location();

      const urlParams = new URLSearchParams(window.location.search);
      const order_id = urlParams.get('order_id');
      await this.findOrder(order_id);
      await this.get_order_timeshipping(order_id);

      // console.log(this.order);

      this.loading = false;
      window.appbar_fixed();
   },

}).mount('#app');
window.app = app;
</script>