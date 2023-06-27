<?php
   // PAGE DETAILS PRODUCT
?>

<div v-if='navigator == "product-details" && product_details != null ' class='page-product-detail'>

   <div class='product-detail-wrapper'>

      <div class='product-header'>
         <div class='top'>

            <button v-if='product_details.product_type == "water"' @click='gotoPage("water")' class='btn-action'>
               <svg width="28" height="28" viewBox="0 0 28 28" fill="none" xmlns="http://www.w3.org/2000/svg">
               <circle cx="14" cy="14" r="14" fill="black" fill-opacity="0.2"/>
               <path fill-rule="evenodd" clip-rule="evenodd" d="M4 14C4 13.4477 4.44772 13 5 13H22.5C23.0523 13 23.5 13.4477 23.5 14C23.5 14.5523 23.0523 15 22.5 15H5C4.44772 15 4 14.5523 4 14Z" fill="white"/>
               <path fill-rule="evenodd" clip-rule="evenodd" d="M14.5309 6.37534C14.8759 6.8066 14.806 7.4359 14.3747 7.78091L6.60078 14L14.3747 20.2192C14.806 20.5642 14.8759 21.1935 14.5309 21.6247C14.1859 22.056 13.5566 22.1259 13.1253 21.7809L4.3753 14.7809C4.13809 14.5911 4 14.3038 4 14C4 13.6963 4.13809 13.4089 4.3753 13.2192L13.1253 6.21917C13.5566 5.87416 14.1859 5.94408 14.5309 6.37534Z" fill="white"/>
               </svg>
            </button>

            <button v-if='product_details.product_type == "ice"' @click='gotoPage("ice")' class='btn-action'>
               <svg width="28" height="28" viewBox="0 0 28 28" fill="none" xmlns="http://www.w3.org/2000/svg">
               <circle cx="14" cy="14" r="14" fill="black" fill-opacity="0.2"/>
               <path fill-rule="evenodd" clip-rule="evenodd" d="M4 14C4 13.4477 4.44772 13 5 13H22.5C23.0523 13 23.5 13.4477 23.5 14C23.5 14.5523 23.0523 15 22.5 15H5C4.44772 15 4 14.5523 4 14Z" fill="white"/>
               <path fill-rule="evenodd" clip-rule="evenodd" d="M14.5309 6.37534C14.8759 6.8066 14.806 7.4359 14.3747 7.78091L6.60078 14L14.3747 20.2192C14.806 20.5642 14.8759 21.1935 14.5309 21.6247C14.1859 22.056 13.5566 22.1259 13.1253 21.7809L4.3753 14.7809C4.13809 14.5911 4 14.3038 4 14C4 13.6963 4.13809 13.4089 4.3753 13.2192L13.1253 6.21917C13.5566 5.87416 14.1859 5.94408 14.5309 6.37534Z" fill="white"/>
               </svg>
            </button>

            <button class='btn-action'>
               <svg width="28" height="28" viewBox="0 0 28 28" fill="none" xmlns="http://www.w3.org/2000/svg">
               <circle cx="14" cy="14" r="14" transform="matrix(-1 0 0 1 28 0)" fill="black" fill-opacity="0.2"/>
               <path fill-rule="evenodd" clip-rule="evenodd" d="M7.9999 12.15C8.46934 12.15 8.8499 12.5306 8.8499 13V19.4C8.8499 19.5989 8.92892 19.7897 9.06957 19.9304C9.21022 20.071 9.40099 20.15 9.5999 20.15H19.1999C19.3988 20.15 19.5896 20.071 19.7302 19.9304C19.8709 19.7897 19.9499 19.5989 19.9499 19.4V13C19.9499 12.5306 20.3305 12.15 20.7999 12.15C21.2693 12.15 21.6499 12.5306 21.6499 13V19.4C21.6499 20.0498 21.3918 20.673 20.9323 21.1324C20.4728 21.5919 19.8497 21.85 19.1999 21.85H9.5999C8.95012 21.85 8.32695 21.5919 7.86749 21.1324C7.40803 20.673 7.1499 20.0498 7.1499 19.4V13C7.1499 12.5306 7.53046 12.15 7.9999 12.15Z" fill="white"/>
               <path fill-rule="evenodd" clip-rule="evenodd" d="M13.7991 4.39898C14.131 4.06704 14.6692 4.06704 15.0011 4.39898L18.2011 7.59898C18.5331 7.93093 18.5331 8.46912 18.2011 8.80106C17.8692 9.13301 17.331 9.13301 16.9991 8.80106L14.4001 6.20211L11.8011 8.80106C11.4692 9.13301 10.931 9.13301 10.5991 8.80106C10.2671 8.46912 10.2671 7.93093 10.5991 7.59898L13.7991 4.39898Z" fill="white"/>
               <path fill-rule="evenodd" clip-rule="evenodd" d="M14.3998 4.15002C14.8692 4.15002 15.2498 4.53058 15.2498 5.00002V15.4C15.2498 15.8695 14.8692 16.25 14.3998 16.25C13.9304 16.25 13.5498 15.8695 13.5498 15.4V5.00002C13.5498 4.53058 13.9304 4.15002 14.3998 4.15002Z" fill="white"/>
               </svg>
            </button>

         </div>
         <div class='main'> 
            <img src="<?php echo THEME_URI . '/assets/images/demo-product03.png'; ?>" alt="">
            <span v-if='has_discount(product_details) == true' class='badge-discount bottom'>-{{ product_details.discount_percent }}%</span>
            <span v-if='product_details.stock == 0' class='badge-discount bottom right'>Out of Stock</span>
         </div>

      </div>

      <div class='inner'>
         <div class='product-design product-detail'>
            <p class='tt01'>{{ product_details.name }}</p>
            <p class='tt02'>{{ get_product_quantity(product_details) }}</p>
            <p class='tt03'> {{ product_details.description }}</p>
            <div class='gr-price' :class="has_discount(product_details) == true ? 'has_discount' : '' ">
               <span class='price'>
                  {{ has_discount(product_details) == true 
                     ? get_product_price_discount(product_details) 
                     : get_product_price(product_details.price)
                  }}
               </span>
               <span v-if='has_discount(product_details) == true' class='price-sub'>{{ get_product_price(product_details.price) }}</span>
            </div>
            <div class='entry-quantity'>
               <p>Quantity</p>
               <div class='quantity-event'>
                  <span @click='minsQuantity()'>
                     <svg width="20" height="3" viewBox="0 0 20 3" fill="none" xmlns="http://www.w3.org/2000/svg">
                     <path d="M18.5714 2.85714H1.42857C1.04969 2.85714 0.686328 2.70663 0.418419 2.43872C0.15051 2.17081 0 1.80745 0 1.42857C0 1.04969 0.15051 0.686328 0.418419 0.418419C0.686328 0.15051 1.04969 0 1.42857 0H18.5714C18.9503 0 19.3137 0.15051 19.5816 0.418419C19.8495 0.686328 20 1.04969 20 1.42857C20 1.80745 19.8495 2.17081 19.5816 2.43872C19.3137 2.70663 18.9503 2.85714 18.5714 2.85714Z" fill="#A2A2A2"/>
                     </svg>
                  </span>
                  <input type="number" v-model='product_details_quantity_order' :max='product_details.stock' disabled>
                  <span @click='plusQuantity(product_details.stock)'>
                     <svg width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                     <path d="M18.5714 11.4286H11.4286V18.5714C11.4286 18.9503 11.2781 19.3137 11.0102 19.5816C10.7422 19.8495 10.3789 20 10 20C9.62112 20 9.25776 19.8495 8.98985 19.5816C8.72194 19.3137 8.57143 18.9503 8.57143 18.5714V11.4286H1.42857C1.04969 11.4286 0.686328 11.2781 0.418419 11.0102C0.15051 10.7422 0 10.3789 0 10C0 9.62112 0.15051 9.25776 0.418419 8.98985C0.686328 8.72194 1.04969 8.57143 1.42857 8.57143H8.57143V1.42857C8.57143 1.04969 8.72194 0.686328 8.98985 0.418419C9.25776 0.150509 9.62112 0 10 0C10.3789 0 10.7422 0.150509 11.0102 0.418419C11.2781 0.686328 11.4286 1.04969 11.4286 1.42857V8.57143H18.5714C18.9503 8.57143 19.3137 8.72194 19.5816 8.98985C19.8495 9.25776 20 9.62112 20 10C20 10.3789 19.8495 10.7422 19.5816 11.0102C19.3137 11.2781 18.9503 11.4286 18.5714 11.4286Z" fill="#2040AF"/>
                     </svg>
                  </span>
               </div>
            </div>
         </div>
      </div>

      <div class='break-line'></div>
      
      <div class='inner'>
         <div class='list-tile shop-card'>

            <div class='leading'>
               <div class='avatar'>
                  <img src="<?php echo THEME_URI . '/assets/images/icon-store-sm.png'; ?>" alt="STORE Logo">
               </div>
            </div>
            
            <div class='content'>
               <span class='tt01'>{{ product_details.store.name}}</span>
               <div class='meta'> 
                  <svg width="15" height="14" viewBox="0 0 15 14" fill="none" xmlns="http://www.w3.org/2000/svg">
                  <path d="M7.32901 11.7286L3.77618 13.8689C3.61922 13.9688 3.45514 14.0116 3.28391 13.9973C3.11269 13.9831 2.96287 13.926 2.83446 13.8261C2.70604 13.7262 2.60616 13.6012 2.53482 13.4511C2.46348 13.301 2.44921 13.1335 2.49202 12.9486L3.43373 8.9035L0.287545 6.18536C0.144861 6.05695 0.0558259 5.91055 0.0204402 5.74618C-0.0149455 5.58181 -0.00438691 5.42143 0.0521161 5.26505C0.10919 5.1081 0.1948 4.97968 0.308948 4.8798C0.423095 4.77992 0.580048 4.71571 0.779806 4.68718L4.93192 4.32333L6.53712 0.513664C6.60846 0.342443 6.71918 0.214026 6.86928 0.128416C7.01939 0.0428054 7.17263 0 7.32901 0C7.48597 0 7.63921 0.0428054 7.78874 0.128416C7.93827 0.214026 8.049 0.342443 8.12091 0.513664L9.72611 4.32333L13.8782 4.68718C14.078 4.71571 14.2349 4.77992 14.3491 4.8798C14.4632 4.97968 14.5488 5.1081 14.6059 5.26505C14.663 5.422 14.6738 5.58266 14.6384 5.74704C14.6031 5.91141 14.5137 6.05752 14.3705 6.18536L11.2243 8.9035L12.166 12.9486C12.2088 13.1341 12.1945 13.3019 12.1232 13.452C12.0519 13.6021 11.952 13.7268 11.8236 13.8261C11.6952 13.926 11.5453 13.9831 11.3741 13.9973C11.2029 14.0116 11.0388 13.9688 10.8819 13.8689L7.32901 11.7286Z" fill="#FFC83A"/>
                  </svg>
                  <span class='tt02 rating'>6.0</span>
                  <span class='tt02 purchase'>1.2k purchase</span>
               </div>
               <!-- <div 
               v-if='product_details.store.store_working == false'  -->
               <div class='time-working'>
                  <span class='t-close'>Closed</span>
                  <span class='time-close'>{{ product_details.store.close_time}} - </span>
                  <span class='time-start'>{{ product_details.store.start_time}} </span>
               </div>
            </div>

            <div class='actions'>
               <button class='btn-text'>View Store</button>
            </div>

         </div>

      </div>

      <div class='break-line'></div>
      
      <div class='inner space-top-product'>

         <div class='gr-heading'>
            <p class='heading'>Top products</p><span class='link'>See All</span>
         </div>

         <div class='list-horizontal'>
            <ul>
               <li @click='gotoProductDetails(product)' v-for='(product, index) in topProducts' class='product-design'>
                  <div class='img'>
                     <img src='<?php echo THEME_URI . '/assets/images/demo-product01.png'; ?>'>
                     <span v-if='has_discount(product) == true' class='badge-discount'>-{{ product.discount_percent }}%</span>
                  </div>
                  <p class='tt01'>{{ product.name }} </p>
                  <p class='tt02'>{{ get_product_quantity(product) }}</p>
                  <div class='gr-price' :class="has_discount(product) == true ? 'has_discount' : '' ">
                     <span class='price'>
                        {{ has_discount(product) == true 
                           ? get_product_price_discount(product) 
                           : get_product_price(product.price)
                        }}
                     </span>
                     <span v-if='has_discount(product) == true' class='price-sub'>
                        {{ get_product_price(product.price) }}
                     </span>
                  </div>
               </li>
               
            </ul>
         </div>

      </div>
   </div>


   <div class='product-detailt-bottomsheet'>
      <button class='btn-icon'>
         <svg width="22" height="20" viewBox="0 0 22 20" fill="none" xmlns="http://www.w3.org/2000/svg">
         <path d="M20.4711 0H1.30667C0.960117 0 0.627761 0.137459 0.382714 0.382139C0.137666 0.626819 0 0.958676 0 1.30471V15.2216C0 15.5676 0.137666 15.8995 0.382714 16.1441C0.627761 16.3888 0.960117 16.5263 1.30667 16.5263H7.78229C7.85748 16.5262 7.9314 16.5457 7.99685 16.5826C8.0623 16.6196 8.11705 16.6728 8.15578 16.7372L9.76624 19.3684C9.88246 19.5611 10.0466 19.7205 10.2427 19.8312C10.4389 19.9418 10.6603 20 10.8856 20C11.1109 20 11.3324 19.9418 11.5285 19.8312C11.7246 19.7205 11.8888 19.5611 12.005 19.3684L13.6198 16.7307C13.6585 16.6663 13.7133 16.6131 13.7788 16.5761C13.8442 16.5391 13.9181 16.5197 13.9933 16.5197H20.4711C20.8177 16.5197 21.15 16.3823 21.3951 16.1376C21.6401 15.8929 21.7778 15.5611 21.7778 15.215V1.30471C21.7778 0.958676 21.6401 0.626819 21.3951 0.382139C21.15 0.137459 20.8177 0 20.4711 0ZM20.9067 15.2216C20.9067 15.3369 20.8608 15.4475 20.7791 15.5291C20.6974 15.6106 20.5866 15.6565 20.4711 15.6565H13.9955C13.7705 15.6565 13.5493 15.7146 13.3534 15.8251C13.1575 15.9356 12.9935 16.0947 12.8772 16.2871L11.2624 18.9248C11.2238 18.9897 11.169 19.0434 11.1033 19.0808C11.0377 19.1181 10.9634 19.1377 10.8878 19.1377C10.8122 19.1377 10.738 19.1181 10.6723 19.0808C10.6066 19.0434 10.5518 18.9897 10.5132 18.9248L8.90167 16.2914C8.78586 16.0981 8.62189 15.938 8.42573 15.8267C8.22957 15.7155 8.00789 15.6568 7.78229 15.6565H1.30667C1.19115 15.6565 1.08037 15.6106 0.998682 15.5291C0.917 15.4475 0.871111 15.3369 0.871111 15.2216V1.30471C0.871111 1.18936 0.917 1.07874 0.998682 0.997184C1.08037 0.915624 1.19115 0.869804 1.30667 0.869804H20.4711C20.5866 0.869804 20.6974 0.915624 20.7791 0.997184C20.8608 1.07874 20.9067 1.18936 20.9067 1.30471V15.2216ZM11.76 8.26313C11.76 8.43517 11.7089 8.60333 11.6132 8.74637C11.5175 8.88941 11.3814 9.0009 11.2222 9.06673C11.0631 9.13256 10.8879 9.14979 10.7189 9.11623C10.55 9.08266 10.3947 8.99982 10.2729 8.87818C10.1511 8.75653 10.0681 8.60155 10.0345 8.43283C10.0009 8.2641 10.0182 8.08921 10.0841 7.93027C10.15 7.77134 10.2617 7.63549 10.4049 7.53992C10.5482 7.44434 10.7166 7.39333 10.8889 7.39333C11.1199 7.39333 11.3415 7.48497 11.5049 7.64809C11.6682 7.81121 11.76 8.03245 11.76 8.26313ZM6.96889 8.26313C6.96889 8.43517 6.9178 8.60333 6.82208 8.74637C6.72636 8.88941 6.59031 9.0009 6.43114 9.06673C6.27196 9.13256 6.09681 9.14979 5.92783 9.11623C5.75885 9.08266 5.60364 8.99982 5.48181 8.87818C5.35998 8.75653 5.27702 8.60155 5.2434 8.43283C5.20979 8.2641 5.22704 8.08921 5.29298 7.93027C5.35891 7.77134 5.47056 7.63549 5.61381 7.53992C5.75707 7.44434 5.92549 7.39333 6.09778 7.39333C6.32881 7.39333 6.55038 7.48497 6.71375 7.64809C6.87711 7.81121 6.96889 8.03245 6.96889 8.26313ZM16.5511 8.26313C16.5511 8.43517 16.5 8.60333 16.4043 8.74637C16.3086 8.88941 16.1725 9.0009 16.0134 9.06673C15.8542 9.13256 15.679 9.14979 15.5101 9.11623C15.3411 9.08266 15.1859 8.99982 15.064 8.87818C14.9422 8.75653 14.8592 8.60155 14.8256 8.43283C14.792 8.2641 14.8093 8.08921 14.8752 7.93027C14.9411 7.77134 15.0528 7.63549 15.196 7.53992C15.3393 7.44434 15.5077 7.39333 15.68 7.39333C15.911 7.39333 16.1326 7.48497 16.296 7.64809C16.4593 7.81121 16.5511 8.03245 16.5511 8.26313Z" fill="#2040AF"/>
         </svg>
         <span>Chat</span>
      </button>
      <button @click='gotoPageOrder' class='btn-primary' :class='product_details_quantity_order == 0 ? "disabled" : "" '>Order</button>
   </div>

   <!-- STORE WORKING MODAL -->
   <div v-if='modal_store_working == true' class='modal-popup open'>
      <div class='modal-wrapper'>
         <div class='modal-close'><div @click='buttonCloseModal_store_working' class='close-button'><span></span><span></span></div></div>
         <p class='heading text-primary'>Store Closed:</p>
         <p>{{ product_details.store.close_time }} - {{ product_details.store.start_time }}</p>
      </div>
   </div>

   <!-- STORE OUT OF STOCK -->
   <div v-if='modal_store_out_of_stock == true' class='modal-popup open'>
      <div class='modal-wrapper'>
         <div class='modal-close'><div @click='buttonCloseModal_store_out_of_stock' class='close-button'><span></span><span></span></div></div>
         <p class='heading'>This Product is <span class='text-primary'>Out of Stock</span></p>
      </div>
   </div>
     
</div>