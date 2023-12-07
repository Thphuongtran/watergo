<script src="https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.8.1/slick.min.js" integrity="sha512-XtmMtDEcNz2j7ekrtHvOVR4iwwaD6o/FUJe6+Zq+HgcCsk3kj4uSQQR8weQ2QVj1o0Pk6PwYLohm206ZzNfubg==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.8.1/slick.min.css" integrity="sha512-yHknP1/AwR+yx26cB1y0cjvQUMvEa2PFzt1c9LlS4pRQ5NOTZFWbhBig+X9G9eYW/8m0/4OXNx8pxJ6z57x0dw==" crossorigin="anonymous" referrerpolicy="no-referrer" />
<style>
   .list-tile .meta svg{
      position: relative;
      top: -2px;
   }
   .slick-slider,
   .slick-list,
   .slick-track,
   .slick-slide{
      height: 100%;
   }
   .product-header .main img{
      max-width: 100%;
      width: auto;
      margin: 0 auto;
   }
   .category-parent{
      color: #D4D6DC;
      font-weight: 300;
      font-size: 10px;
      padding: 2px 8px;
      border-radius: 25px;
      border: 1px solid #D4D6DC;
      margin-left: 6px;
   }
   .product-design.product-detail .tt01{
      display: flex;
      align-items: center;
   }
   
   input, input:focus{
      outline: none;
      box-shadow: none;
   }

   .product-design .img{
      padding: 0;
      height: 160px;
   }
   .product-design .img img{
      position: initial;
      left: initial; top: initial;
   }

   .list-horizontal .product-design .tt01{
      text-overflow: ellipsis;
      overflow: hidden;
      line-height: 27px;
      width: 100%;
   }
   .space-top-product .gr-price{
      display: flex;
      flex-flow: row wrap;
      align-items: flex-end;
   }
   .space-top-product .product-design .price{
      padding-right: 5px;
   }
   .space-top-product .product-design .price-sub{
      margin-left: 0;
      position: relative;
      line-height: 22px;
   }

   .badge-discount, .badge-out-of-stock{
      z-index: 88;
   }

   .product-header .main{
      height: 328px;
   }

   .banner-notify-cart{
      z-index: 8888;
   }

   .product-design .price-sub{
      margin-left: 0;
      margin-right: 10px;
      line-height: 22px;
   }
   .product-design.product-detail .price{
      margin-right: 5px;
   }

   .product-detail-bottomsheet {
      z-index: 88
   }
   .badge-gift {
      display: flex;
      flex-flow: row nowrap;
   }
   .badge-gift .icon{
      height: 24px;
   }
   .badge-gift .text{
      white-space: pre-wrap;
      line-height: 26px;
   }
   .product-design.product-detail .gr-price{
      display: flex;
      flex-flow: row wrap;
      align-items: flex-end;
   }

   .space-top-product .badge-gift {
      position: relative;
      width: 100%;
      left: -5px;
      margin-top: 2px;
   }
   .space-top-product .badge-gift .icon {
      position: absolute;
      top: -2px;
   }
   .space-top-product .badge-gift .text {
      padding-left: 25px;
      line-height: 20px;

      white-space: nowrap;
      text-overflow: ellipsis;
      overflow: hidden;
   }
   .list-horizontal ul{
      overflow-y: hidden;
   }

   .product-detail-wrapper{
      overflow-y: scroll;
      overflow-x: hidden;
      height: calc( 100vh - 50px);
      padding-bottom: 30px;
   }
</style>

<div id='app'>

   <div v-if='loading == false && product != null' class='page-product-detail'>
      <div class='product-detail-wrapper'>
         <div class='product-header'>
            <div class='top'>
               <button @click='goBack' class='btn-action'>
                  <svg width="28" height="28" viewBox="0 0 28 28" fill="none" xmlns="http://www.w3.org/2000/svg">
                  <circle cx="14" cy="14" r="14" fill="black" fill-opacity="0.2"/>
                  <path fill-rule="evenodd" clip-rule="evenodd" d="M4 14C4 13.4477 4.44772 13 5 13H22.5C23.0523 13 23.5 13.4477 23.5 14C23.5 14.5523 23.0523 15 22.5 15H5C4.44772 15 4 14.5523 4 14Z" fill="white"/>
                  <path fill-rule="evenodd" clip-rule="evenodd" d="M14.5309 6.37534C14.8759 6.8066 14.806 7.4359 14.3747 7.78091L6.60078 14L14.3747 20.2192C14.806 20.5642 14.8759 21.1935 14.5309 21.6247C14.1859 22.056 13.5566 22.1259 13.1253 21.7809L4.3753 14.7809C4.13809 14.5911 4 14.3038 4 14C4 13.6963 4.13809 13.4089 4.3753 13.2192L13.1253 6.21917C13.5566 5.87416 14.1859 5.94408 14.5309 6.37534Z" fill="white"/>
                  </svg>
               </button>

               <!-- <button @click='btn_share' class='btn-action'>
                  <svg width="28" height="28" viewBox="0 0 28 28" fill="none" xmlns="http://www.w3.org/2000/svg">
                  <circle cx="14" cy="14" r="14" transform="matrix(-1 0 0 1 28 0)" fill="black" fill-opacity="0.2"/>
                  <path fill-rule="evenodd" clip-rule="evenodd" d="M7.9999 12.15C8.46934 12.15 8.8499 12.5306 8.8499 13V19.4C8.8499 19.5989 8.92892 19.7897 9.06957 19.9304C9.21022 20.071 9.40099 20.15 9.5999 20.15H19.1999C19.3988 20.15 19.5896 20.071 19.7302 19.9304C19.8709 19.7897 19.9499 19.5989 19.9499 19.4V13C19.9499 12.5306 20.3305 12.15 20.7999 12.15C21.2693 12.15 21.6499 12.5306 21.6499 13V19.4C21.6499 20.0498 21.3918 20.673 20.9323 21.1324C20.4728 21.5919 19.8497 21.85 19.1999 21.85H9.5999C8.95012 21.85 8.32695 21.5919 7.86749 21.1324C7.40803 20.673 7.1499 20.0498 7.1499 19.4V13C7.1499 12.5306 7.53046 12.15 7.9999 12.15Z" fill="white"/>
                  <path fill-rule="evenodd" clip-rule="evenodd" d="M13.7991 4.39898C14.131 4.06704 14.6692 4.06704 15.0011 4.39898L18.2011 7.59898C18.5331 7.93093 18.5331 8.46912 18.2011 8.80106C17.8692 9.13301 17.331 9.13301 16.9991 8.80106L14.4001 6.20211L11.8011 8.80106C11.4692 9.13301 10.931 9.13301 10.5991 8.80106C10.2671 8.46912 10.2671 7.93093 10.5991 7.59898L13.7991 4.39898Z" fill="white"/>
                  <path fill-rule="evenodd" clip-rule="evenodd" d="M14.3998 4.15002C14.8692 4.15002 15.2498 4.53058 15.2498 5.00002V15.4C15.2498 15.8695 14.8692 16.25 14.3998 16.25C13.9304 16.25 13.5498 15.8695 13.5498 15.4V5.00002C13.5498 4.53058 13.9304 4.15002 14.3998 4.15002Z" fill="white"/>
                  </svg>
               </button> -->

            </div>

            <div class='main'> 
               <div class='product-slider'>
                  <ul>
                     <li
                        v-for='( image, indexImage) in product.product_image' :key='indexImage'>
                        <img :src="image.url">
                     </li>
                  </ul>
               </div>
               <span v-show='has_discount(product) == true' class='badge-discount bottom left size-large'>-{{ product.discount_percent }}%</span>
               <span v-show='product.mark_out_of_stock == 1' class='badge-out-of-stock bottom right size-large'><?php echo __('Out of Stock', 'watergo'); ?></span>
            </div>
            
         </div>

         <div class='inner'>
            <div class='product-design product-detail'>

               <p class='tt01'>
                  {{ product.name }}

                  <!-- <span class='category-parent' 
                     v-if='
                        product.product_type == "ice" && 
                        ( product.category_parent != null && product.category_parent != "null" && product.category_parent != "")
                     '>
                     {{ product.category_parent }}</span> -->
               </p>
               <p class='tt02'>{{ product.name_second }}</p>

               <p v-if='product.description != ""' class='tt03' v-html='formatDescription(product.description)'></p>
               <div class='gr-price' :class="has_discount(product) == true ? 'has_discount' : '' ">
                  <span class='price'>
                     {{ common_price_after_discount(product ) }}
                  </span>
                  <span v-if='has_discount(product) == true' class='price-sub'>
                     {{ common_price_show_currency(product.price) }}
                  </span>
                  <span v-show='has_gift(product) == true' class='badge-gift'>
                     <span class='icon'>
                        <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M12.0002 7.91235V19.3409M5.14307 11.3409H18.8574V17.0552C18.8574 17.6614 18.6165 18.2428 18.1879 18.6715C17.7592 19.1001 17.1778 19.3409 16.5716 19.3409H7.42878C6.82257 19.3409 6.24119 19.1001 5.81254 18.6715C5.38388 18.2428 5.14307 17.6614 5.14307 17.0552V11.3409Z" stroke="#2790F9" stroke-linecap="round" stroke-linejoin="round"/>
                        <path d="M12 7.9123H8.57143C7.67886 7.01973 7.67886 5.3763 8.57143 4.48373C9.464 3.59115 12 3.9123 12 5.62658M12 7.9123V5.62658M12 7.9123H15.4286C16.3211 7.01973 16.3211 5.3763 15.4286 4.48373C14.536 3.59115 12 3.9123 12 5.62658M5.14286 7.9123H18.8571C19.1602 7.9123 19.4509 8.0327 19.6653 8.24703C19.8796 8.46136 20 8.75205 20 9.05515V10.198C20 10.5011 19.8796 10.7918 19.6653 11.0061C19.4509 11.2205 19.1602 11.3409 18.8571 11.3409H5.14286C4.83975 11.3409 4.54906 11.2205 4.33474 11.0061C4.12041 10.7918 4 10.5011 4 10.198V9.05515C4 8.75205 4.12041 8.46136 4.33474 8.24703C4.54906 8.0327 4.83975 7.9123 5.14286 7.9123Z" stroke="#2790F9" stroke-linecap="round" stroke-linejoin="round"/>
                        </svg>
                     </span>
                     <span class='text'>{{ product.gift_text}}</span>
                  </span>
               </div>

               <div class='entry-quantity'>
                  <p v-show='view_only == false'><?php echo __('Quantity', 'watergo'); ?></p>
                  <div v-show='view_only == false' class='quantity-event'>
                     <span @click='minsQuantity'>
                        <svg width="20" height="3" viewBox="0 0 20 3" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M18.5714 2.85714H1.42857C1.04969 2.85714 0.686328 2.70663 0.418419 2.43872C0.15051 2.17081 0 1.80745 0 1.42857C0 1.04969 0.15051 0.686328 0.418419 0.418419C0.686328 0.15051 1.04969 0 1.42857 0H18.5714C18.9503 0 19.3137 0.15051 19.5816 0.418419C19.8495 0.686328 20 1.04969 20 1.42857C20 1.80745 19.8495 2.17081 19.5816 2.43872C19.3137 2.70663 18.9503 2.85714 18.5714 2.85714Z" fill="#A2A2A2"/></svg>
                     </span>
                     <input type="number" v-model='product_quantity_count' pattern='[0-9]*'>
                     <span @click='plusQuantity'>
                        <svg width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M18.5714 11.4286H11.4286V18.5714C11.4286 18.9503 11.2781 19.3137 11.0102 19.5816C10.7422 19.8495 10.3789 20 10 20C9.62112 20 9.25776 19.8495 8.98985 19.5816C8.72194 19.3137 8.57143 18.9503 8.57143 18.5714V11.4286H1.42857C1.04969 11.4286 0.686328 11.2781 0.418419 11.0102C0.15051 10.7422 0 10.3789 0 10C0 9.62112 0.15051 9.25776 0.418419 8.98985C0.686328 8.72194 1.04969 8.57143 1.42857 8.57143H8.57143V1.42857C8.57143 1.04969 8.72194 0.686328 8.98985 0.418419C9.25776 0.150509 9.62112 0 10 0C10.3789 0 10.7422 0.150509 11.0102 0.418419C11.2781 0.686328 11.4286 1.04969 11.4286 1.42857V8.57143H18.5714C18.9503 8.57143 19.3137 8.72194 19.5816 8.98985C19.8495 9.25776 20 9.62112 20 10C20 10.3789 19.8495 10.7422 19.5816 11.0102C19.3137 11.2781 18.9503 11.4286 18.5714 11.4286Z" fill="#2790F9"/></svg>
                     </span>
                  </div>
               </div>
            </div>
         </div>

         <div class='break-line'></div>

         <div class='inner'>
            <div v-if='store != null' class='list-tile shop-card'>

               <div class='leading'>
                  <div class='avatar'><img :src="store.store_image.url"></div>
               </div>
               <div class='content'>

                  <div class='heading'>
                     <span class='tt01'>{{ store.name }}</span>
                     <div class='actions'>
                        <button @click='gotoStoreDetail(store.id)' class='btn-text'><?php echo __('View Store', 'watergo'); ?></button>
                     </div>
                  </div>
                  
                  <div class='meta'> 
                     <svg v-if='averageRating > 0' width="15" height="14" viewBox="0 0 15 14" fill="none" xmlns="http://www.w3.org/2000/svg">
                     <path d="M7.32901 11.7286L3.77618 13.8689C3.61922 13.9688 3.45514 14.0116 3.28391 13.9973C3.11269 13.9831 2.96287 13.926 2.83446 13.8261C2.70604 13.7262 2.60616 13.6012 2.53482 13.4511C2.46348 13.301 2.44921 13.1335 2.49202 12.9486L3.43373 8.9035L0.287545 6.18536C0.144861 6.05695 0.0558259 5.91055 0.0204402 5.74618C-0.0149455 5.58181 -0.00438691 5.42143 0.0521161 5.26505C0.10919 5.1081 0.1948 4.97968 0.308948 4.8798C0.423095 4.77992 0.580048 4.71571 0.779806 4.68718L4.93192 4.32333L6.53712 0.513664C6.60846 0.342443 6.71918 0.214026 6.86928 0.128416C7.01939 0.0428054 7.17263 0 7.32901 0C7.48597 0 7.63921 0.0428054 7.78874 0.128416C7.93827 0.214026 8.049 0.342443 8.12091 0.513664L9.72611 4.32333L13.8782 4.68718C14.078 4.71571 14.2349 4.77992 14.3491 4.8798C14.4632 4.97968 14.5488 5.1081 14.6059 5.26505C14.663 5.422 14.6738 5.58266 14.6384 5.74704C14.6031 5.91141 14.5137 6.05752 14.3705 6.18536L11.2243 8.9035L12.166 12.9486C12.2088 13.1341 12.1945 13.3019 12.1232 13.452C12.0519 13.6021 11.952 13.7268 11.8236 13.8261C11.6952 13.926 11.5453 13.9831 11.3741 13.9973C11.2029 14.0116 11.0388 13.9688 10.8819 13.8689L7.32901 11.7286Z" fill="#FFC83A"/>
                     </svg>
                     <span v-if='averageRating > 0' class='tt02 rating'>{{ averageRating }}</span>
                     <span v-if='totalPurchase > 0' 
                        :class='averageRating == 0 ? "no-dot" : ""'
                        class='tt02 purchase'>{{shortenNumber(totalPurchase)}} <?php echo __('purchase', 'watergo'); ?></span>
                  </div>
                  <div v-if='check_time_validate(store.start_time, store.close_time) == true'>
                     <div class='time-working'>
                        <span class='t-close'><?php echo __('Closed', 'watergo') ?></span>
                        <span class='time-close'>{{ timestamp_to_date(store.close_time) }} - </span>
                        <span class='time-start'>{{ timestamp_to_date(store.start_time) }} </span>
                     </div>
                  </div>
               </div>
            </div>
         </div>

         <div class='break-line'></div>

         <div v-if='product_by_store.length > 0' class='inner space-top-product'>
            <div class='gr-heading'>
               <p class='heading'><?php echo __('Top products', 'watergo'); ?></p><span v-show='view_only == false' @click='gotoProductTop(product.category)' class='link'><?php echo __('See All', 'watergo'); ?></span>
            </div>
            <div class='list-horizontal'>
               <ul>
                  <li @click='gotoProductDetail(product.id)' v-for='(product, index) in product_by_store' class='product-design small-size '>
                     <div class='img'>
                        <img :src='product.product_image.url'>
                        <span v-if='has_discount(product) == true' class='badge-discount'>-{{ product.discount_percent }}%</span>
                        <span v-show='product_is_mark_out_of_stock(product) == true' 
                           class='badge-discount badge-out-of-stock size-large'><?php echo __('Out of Stock', 'watergo'); ?></span>
                     </div>
                     <p class='tt01'>{{ product.name }} </p>
                     <p class='tt02'>{{ product.name_second }}</p>
                     

                     <div class='gr-price' :class="has_discount(product) == true ? 'has_discount' : '' ">
                        <span class='price'>
                           {{ common_price_after_discount(product ) }}
                        </span>
                        <span v-if='has_discount(product) == true' class='price-sub'>
                           {{ common_price_show_currency(product.price) }}
                        </span>
                        <span v-show='has_gift(product) == true' class='badge-gift'>
                           <span class='icon'>
                              <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                              <path d="M12.0002 7.91235V19.3409M5.14307 11.3409H18.8574V17.0552C18.8574 17.6614 18.6165 18.2428 18.1879 18.6715C17.7592 19.1001 17.1778 19.3409 16.5716 19.3409H7.42878C6.82257 19.3409 6.24119 19.1001 5.81254 18.6715C5.38388 18.2428 5.14307 17.6614 5.14307 17.0552V11.3409Z" stroke="#2790F9" stroke-linecap="round" stroke-linejoin="round"/>
                              <path d="M12 7.9123H8.57143C7.67886 7.01973 7.67886 5.3763 8.57143 4.48373C9.464 3.59115 12 3.9123 12 5.62658M12 7.9123V5.62658M12 7.9123H15.4286C16.3211 7.01973 16.3211 5.3763 15.4286 4.48373C14.536 3.59115 12 3.9123 12 5.62658M5.14286 7.9123H18.8571C19.1602 7.9123 19.4509 8.0327 19.6653 8.24703C19.8796 8.46136 20 8.75205 20 9.05515V10.198C20 10.5011 19.8796 10.7918 19.6653 11.0061C19.4509 11.2205 19.1602 11.3409 18.8571 11.3409H5.14286C4.83975 11.3409 4.54906 11.2205 4.33474 11.0061C4.12041 10.7918 4 10.5011 4 10.198V9.05515C4 8.75205 4.12041 8.46136 4.33474 8.24703C4.54906 8.0327 4.83975 7.9123 5.14286 7.9123Z" stroke="#2790F9" stroke-linecap="round" stroke-linejoin="round"/>
                              </svg>
                           </span>
                           <span class='text'>{{ product.gift_text}}</span>
                        </span>

                     </div>

                  </li>
               </ul>
            </div>
         </div>
      </div>

      <div v-show='view_only == false' class='product-detail-bottomsheet cell-order'>

         <button 
            <?php echo is_user_logged_in() == false ? "@click='gotoLogin'" : "@click='addToCart(true)'" ?> 
            class='btn-text'><?php echo __('Add to Cart', 'watergo');?>
         </button>
         <button @click='gotoPageOrder' class='btn-primary' :class='check_can_order == false ? "disabled" : "" '>
            <?php 
               if( get_locale() == 'vi' ){ echo 'Đặt hàng';
               }else if( get_locale() == 'ko_KR' ){ echo '주문';
               }else{ echo 'Order'; }
            ?>
         </button>
      </div>
      
   </div>

   <div v-if='modal_store_working == true' class='modal-popup open'>
      <div class='modal-wrapper'>
         <div class='modal-close'><div @click='buttonCloseModal_store_working' class='close-button'><span></span><span></span></div></div>
         <p class='heading t-primary style01'><?php echo __('Store Closed', 'watergo'); ?>:</p>
         <p>{{ timestamp_to_date(store.close_time) }} - {{ timestamp_to_date(store.start_time) }}</p>
      </div>
   </div>

   <div v-if='modal_store_out_of_stock == true' class='modal-popup open'>
      <div class='modal-wrapper'>
         <div class='modal-close'><div @click='buttonCloseModal_store_out_of_stock' class='close-button'><span></span><span></span></div></div>
         <p class='heading'><?php echo __("This Product is <span class='t-primary'>Out of Stock</span>", 'watergo');?></p>
      </div>
   </div>

   <div class='modal-popup' :class='loading == false && ( product == null || product.product_hidden == 1 ) ? "open" : ""'>
      <div class='modal-wrapper'>
         <div class='modal-close'><div @click='goBack' class='close-button'><span></span><span></span></div></div>
         <p class='heading'><?php echo __('Content Not Found', 'watergo'); ?> </p>
      </div>
   </div>

   <div v-if='loading == true'>
      <div class='progress-center'>
         <div class='progress-container enabled'><progress class='progress-circular enabled' ></progress></div>
      </div>
   </div>

   <div v-show='show_add_cart == true' class='banner-notify-cart'><?php echo __('Add success', 'watergo'); ?></div>


</div>

<script>

// import { initializeApp } from "https://www.gstatic.com/firebasejs/10.4.0/firebase-app.js";
// // import { getFirestore, collection, query, where, orderBy, addDoc, getDocs, limit, onSnapshot } from 'https://www.gstatic.com/firebasejs/10.4.0/firebase-firestore.js';
// import { getFirestore, collection, query, where, getDocs, addDoc, updateDoc, serverTimestamp } from 'https://www.gstatic.com/firebasejs/10.4.0/firebase-firestore.js';


// const firebaseConfig = {
//    apiKey: "AIzaSyAIiPyRBqrwY8LVx5AruzKmsjL96j_lzr4",
//    authDomain: "watergo-chat.firebaseapp.com",
//    projectId: "watergo-chat",
//    storageBucket: "watergo-chat.appspot.com",
//    messagingSenderId: "663475773045",
//    appId: "1:663475773045:web:e71a08bee3a9506c39223c",
//    measurementId: "G-4E3CS9NC3T"
// };

var app = Vue.createApp({
   data (){
      return {

         loading: false,
         product: null,
         store: null,

         view_only: false,

         show_add_cart: false,

         product_type: '',
         product_by_store: [],

         averageRating: 0,
         totalPurchase: 0,

         product_quantity_count: 0,

         modal_store_working: false,
         modal_store_out_of_stock: false,

         canOrder: false,

         product_exists_in_cart: false,

         database: null,

         // memory
         carts: [],

      }
   },

   watch: {
      carts: {
         handler(data){
            if( data.length > 0 ){
               localStorage.setItem('watergo_carts', JSON.stringify(data));
            }
         }, deep: true
      }
   },

   methods: {
      
      formatDescription(description) {return description.replace(/\n/g, '<br>');},

      async btn_share(){
         var _url = window.location.href;
         // alert(_url);
         await window.native_share_link( _url);
      },

      gotoLogin(){ window.gotoLogin() },

      buttonCloseModal_store_working(){ this.modal_store_working = false; },
      buttonCloseModal_store_out_of_stock(){ this.modal_store_out_of_stock = false; },
      
      has_discount( product ){ return window.has_discount( product ); },
      has_gift( product ){ return window.has_gift( product ); },
      product_is_mark_out_of_stock( product ){ return window.product_is_mark_out_of_stock(product); },
      common_price_after_discount(p){ return common_price_after_discount(p) },
      common_price_show_currency(p){ return common_price_show_currency(p) },

      addToCart( show_modal_success ){

         // CHECK PRODUCT IS OUT OF STOCK
         if( this.product.mark_out_of_stock != 1 ){

            if( show_modal_success == true ){
               this.show_add_cart = true;
               var timeoutId = setTimeout(() => {this.show_add_cart = false;}, 1500);
               if (timeoutId) {
                  clearTimeout(timeoutId);
                  this.show_add_cart = true;
                  timeoutId = setTimeout(() => {this.show_add_cart = false;}, 1500);
               }
            }

            // GET CURRENT STORE AND PRODUCT
            var _storeIndex = this.carts.findIndex( store => store.store_id == this.store.id );
            if( _storeIndex == -1 ){
               this.carts.push({
                  store_id: parseInt( this.store.id ),
                  store_select: true,
                  store_name: this.store.name,
                  products: [
                     {
                        product_id: parseInt(this.product.id ),
                        product_quantity_count: this.product_quantity_count,
                        product_select: true
                     }
                  ]
               });
            }else{
               this.carts.some( store => store.store_select = false);
               this.carts[_storeIndex].store_select = true;
               var _productIndex = this.carts[_storeIndex].products.findIndex( product => product.product_id == this.product.id );
               if( _productIndex == -1 ){
                  this.carts[_storeIndex].products.push({
                     product_id: parseInt(this.product.id ),
                     product_quantity_count: this.product_quantity_count,
                     product_select: true
                  });
               }else{
                  this.carts[_storeIndex].products.some( product => product.product_select = false);
                  this.carts[_storeIndex].products[_productIndex].product_select = true;
                  this.carts[_storeIndex].products[_productIndex].product_quantity_count = this.product_quantity_count;
               }
            }
         }else{
            this.modal_store_out_of_stock = true;
         }


      },

      // GO TO PAGE ORDER
      gotoPageOrder(){
         if( this.check_can_order == true ){
            this.addToCart(false);
            this.gotoOrderProduct();
         }
      },

      timestamp_to_date(timestamp) { return window.timestamp_to_date(timestamp); },
      check_time_validate(_startTime, _closeTime){ return window.check_time_validate_timestamp(_startTime, _closeTime); },

      async findProduct( product_id ){
         
         var form = new FormData();
         form.append('action', 'atlantis_find_product');
         form.append('product_id', product_id);
         form.append('limit_image', 0);
         form.append('image_size', 'large');
         var r = await window.request(form);

         if( r != undefined ){
            var res = JSON.parse( JSON.stringify(r));
            if( res.message == 'product_found' ){
               this.product = res.data;

               if( ! Array.isArray( res.data.product_image ) ){
                  this.product.product_image = [ res.data.product_image];
               }

               // out of stock 1 -> true | 0 -> false
               if( this.product.mark_out_of_stock == 1 ){
                  this.modal_store_out_of_stock = true;
                  this.canOrder = false;
               }else{
                  if(this.product.mark_out_of_stock == null ){
                     this.canOrder = true;
                     this.product.mark_out_of_stock = 0;
                  }
                  this.product_quantity_count = 1;
                  this.canOrder = true;
               }


               await this.get_review_rating_average( this.product.store_id);
               await this.get_purchase_store( this.product.store_id);

               await this.findStore(this.product.store_id);
               await this.atlantis_get_all_product_by_store( this.product.store_id, product_id);

            }
         }
      
         
      },

      async findStore( store_id ){
         var form = new FormData();
         form.append('action', 'atlantis_find_store');
         form.append('store_id', store_id);
         var r = await window.request(form);
         if( r != undefined ){
            var res = JSON.parse( JSON.stringify(r));
            if(res.message == 'store_found' ){
               this.store = res.data;
            }
         }
      },

      async atlantis_get_all_product_by_store( store_id, product_id ){
         var form = new FormData();
         form.append('action', 'atlantis_get_all_product_by_store');
         form.append('store_id', store_id);
         form.append('product_id', product_id);
         var r = await window.request(form);
         if( r != undefined ){
            var res = JSON.parse( JSON.stringify(r));
            if( res.message == 'product_found' ){
               this.product_by_store.push( ...res.data);
            }
         }
      },

      plusQuantity(){
         if( this.product.mark_out_of_stock == 0 ){
            this.product_quantity_count++;
         }
      },

      minsQuantity(){
         if( this.product.mark_out_of_stock == 0 ){
            if( this.product_quantity_count == 0 ){
               this.product_quantity_count = 0;
            }else{ 
               this.product_quantity_count--;
            }
         }
      },

      async get_review_rating_average( store_id ){
         var form = new FormData();
         form.append('action', 'atlantis_get_avg_rating');
         form.append('store_id', store_id);
         var r = await window.request(form);
         if( r != undefined ){
            var res = JSON.parse( JSON.stringify(r));
            if(res.message == 'rating_found' ){
               this.averageRating = res.data;
               this.averageRating = parseFloat(this.averageRating).toFixed(1);
            }
         }
      },

      async get_purchase_store( store_id ){
         var form = new FormData();
         form.append('action', 'atlantis_get_total_purchase_store');
         form.append('store_id', store_id);
         var r = await window.request(form);
         if( r != undefined ){
            var res = JSON.parse( JSON.stringify(r));
            if(res.message == 'purchase_found' ){
               this.totalPurchase = res.data;
            }
         }
      },

      shortenNumber(n){return window.shortenNumber(n)},
      gotoProductDetail(product_id){window.gotoProductDetail(product_id)},
      gotoProductTop( category_id){ window.gotoProductTop(category_id) },
      gotoStoreDetail(store_id){window.gotoStoreDetail(store_id)},
      gotoOrderProduct(){window.gotoOrderProduct()},

      goBack(){
         // window.location.href = '?appt=X&data=cart_count|notification_callback=notification_count';
         window.location.href = '?appt=X&data=cart_count|notification_count';
      },

   },

   computed: {
      check_can_order(){
         if( this.canOrder == true && this.product_quantity_count > 0){
            return true;
         }
         return false;
      },
   },

   async created(){

      if( window.appBridge != undefined ){
         window.appBridge.setEnableScroll(false);
      }

      this.loading = true;

      // const appFireBase = initializeApp(firebaseConfig);
      // this.database = getFirestore(appFireBase);

      window.check_cart_is_exists();

      const urlParams = new URLSearchParams(window.location.search);
      const product_id = urlParams.get('product_id');
      const _view_only = urlParams.get('view_only');
      if( _view_only && _view_only == 1){
         this.view_only = true;
      }

      await this.findProduct(product_id);

      if( this.product != null ){

         // GET QUANTITY 
         window.reset_cart_to_select_false();
         var _carts = JSON.parse(localStorage.getItem('watergo_carts'));
         this.carts = _carts;

         window.appbar_fixed();

         jQuery(document).ready(function($){
            $('.product-slider ul').slick({
               dots: false,
               arrows: false,
               infinite: false,
               autoplay: true,
               duration: 1000,
               speed: 300,
               slidesToShow: 1,
               slidesToScroll: 1,
            })
         });
      }

      this.loading = false;


   }
}).mount('#app');
window.app = app;

</script>

