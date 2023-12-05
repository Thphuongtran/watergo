<?php 
   // bj_push_notification(1, 'title', 'content');
?>
<script src='<?php echo THEME_URI . '/pages/module/module_get_order_delivering.js?ver=3.0'; ?>'></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.8.1/slick.min.js" integrity="sha512-XtmMtDEcNz2j7ekrtHvOVR4iwwaD6o/FUJe6+Zq+HgcCsk3kj4uSQQR8weQ2QVj1o0Pk6PwYLohm206ZzNfubg==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.8.1/slick.min.css" integrity="sha512-yHknP1/AwR+yx26cB1y0cjvQUMvEa2PFzt1c9LlS4pRQ5NOTZFWbhBig+X9G9eYW/8m0/4OXNx8pxJ6z57x0dw==" crossorigin="anonymous" referrerpolicy="no-referrer" />
<style>
   .navbar.navbar-icon li .icon,
   .navbar.navbar-icon li .icon-svg{
      height: 36px;
   }
   .list-order li .order-prods{
      flex-flow: row wrap;
   }
   .list-order li .order-bottom{
      flex-flow: row wrap
   }
   @media screen and (max-width: 375px){
      .navbar.navbar-icon li .count-order-badge{
         right: -20%;
      }
      .navbar.navbar-icon li .icon{
         margin-bottom: 17px !important;
      }
      .navbar.navbar-icon li .icon, 
      .navbar.navbar-icon li .icon-svg,
      .navbar.navbar-icon li .icon-svg svg{
         height: 26px;
         width: 26px;
      }
      .navbar.navbar-icon li .text-small{
         font-size: 10px;
      }
      .navbar.navbar-icon li{
         /* min-width: 67px; */
      }
   }
   .navbar.navbar-icon li{
      min-width: 20%;
   }
   @media screen and (max-width: 360px){
      .appbar .leading-filter .btn-action{
         font-size: 3.9vw;
      }
   }
</style>
<div id='app'>

   <div v-if="loading == true">
      <div class='progress-center'>
         <div class='progress-container enabled'><progress class='progress-circular enabled' ></progress></div>
      </div>
   </div>

   <div v-if="loading == false" class='page-order'>

      <div class='appbar'>
         <div class='appbar-top'>
            <div class='leading'>
               <p class='leading-title'><?php 
                  if( get_locale() == 'ko_KR' ){echo '주문';
                  }else{echo __('Order', 'watergo'); }
               ?></p>
               <div class='leading-filter'>
                  <button @click='gotoOrderFilter("weekly")' class='btn-action pr10'><?php echo __('Week', 'watergo'); ?></button> | <button @click='gotoOrderFilter("monthly")' class='btn-action pl10'><?php echo __('Month', 'watergo'); ?></button>
               </div>
            </div>
            <div class='action'>

               <div @click='gotoCart' class='btn-badge'>
                  <svg width="23" height="20" viewBox="0 0 23 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                  <path d="M9.05036 18.4583C9.05036 18.7244 8.97134 18.9846 8.82329 19.2058C8.67524 19.4271 8.46481 19.5996 8.21861 19.7015C7.97241 19.8033 7.7015 19.83 7.44014 19.778C7.17878 19.7261 6.9387 19.5979 6.75027 19.4098C6.56184 19.2216 6.43352 18.9818 6.38153 18.7208C6.32954 18.4597 6.35622 18.1892 6.4582 17.9433C6.56018 17.6974 6.73288 17.4873 6.95445 17.3394C7.17602 17.1915 7.43652 17.1126 7.703 17.1126C8.06034 17.1126 8.40305 17.2544 8.65573 17.5067C8.9084 17.7591 9.05036 18.1014 9.05036 18.4583ZM17.7119 17.1126C17.4455 17.1126 17.185 17.1915 16.9634 17.3394C16.7418 17.4873 16.5691 17.6974 16.4672 17.9433C16.3652 18.1892 16.3385 18.4597 16.3905 18.7208C16.4425 18.9818 16.5708 19.2216 16.7592 19.4098C16.9477 19.5979 17.1877 19.7261 17.4491 19.778C17.7105 19.83 17.9814 19.8033 18.2276 19.7015C18.4738 19.5996 18.6842 19.4271 18.8322 19.2058C18.9803 18.9846 19.0593 18.7244 19.0593 18.4583C19.0593 18.1014 18.9174 17.7591 18.6647 17.5067C18.412 17.2544 18.0693 17.1126 17.7119 17.1126ZM22.113 4.78659L19.3682 13.6976C19.2367 14.1303 18.9691 14.5091 18.605 14.778C18.241 15.0468 17.8 15.1914 17.3472 15.1903H8.0947C7.63433 15.1886 7.18695 15.0378 6.81974 14.7604C6.45253 14.4831 6.18533 14.0943 6.05826 13.6524L2.57823 1.48882C2.56669 1.44855 2.54231 1.41315 2.50878 1.38799C2.47525 1.36283 2.43442 1.3493 2.39248 1.34945H0.773728C0.620582 1.34945 0.473708 1.28869 0.365417 1.18054C0.257126 1.07238 0.196289 0.925697 0.196289 0.772746C0.196289 0.619796 0.257126 0.473109 0.365417 0.364957C0.473708 0.256804 0.620582 0.196045 0.773728 0.196045H2.39248C2.68501 0.196833 2.9694 0.292344 3.20296 0.468247C3.43652 0.64415 3.60667 0.890957 3.68787 1.17163L4.5088 4.04072H21.5615C21.6518 4.04081 21.7408 4.06204 21.8214 4.1027C21.902 4.14336 21.9719 4.20232 22.0255 4.27485C22.0791 4.34738 22.115 4.43146 22.1302 4.52033C22.1454 4.6092 22.1395 4.70039 22.113 4.78659ZM20.7801 5.19412H4.8389L7.16887 13.34C7.22639 13.5409 7.34788 13.7176 7.51493 13.8433C7.68199 13.969 7.88551 14.037 8.0947 14.0369H17.3443C17.5502 14.0369 17.7506 13.971 17.9162 13.8489C18.0818 13.7268 18.2038 13.5548 18.2644 13.3583L20.7801 5.19412Z" fill="#2790F9"/>
                  <path fill-rule="evenodd" clip-rule="evenodd" d="M22.3002 4.84434L19.5556 13.7547C19.4118 14.2275 19.1191 14.6419 18.7213 14.9357C18.3234 15.2296 17.8413 15.3876 17.3465 15.3864H8.09448C7.59174 15.3845 7.10242 15.2198 6.70136 14.917C6.3003 14.6141 6.00841 14.1894 5.86961 13.7066L2.39029 1.54556H0.773518C0.568449 1.54556 0.371729 1.4642 0.226647 1.31931C0.0815564 1.1744 0 0.977815 0 0.77278C0 0.567745 0.0815563 0.371158 0.226647 0.226253C0.371729 0.0813567 0.568449 0 0.773518 0H2.39227C2.72716 0.000902557 3.05328 0.110242 3.32071 0.311653C3.58815 0.513066 3.78301 0.795701 3.87602 1.11717L4.65643 3.84467H21.5613C21.6822 3.8448 21.8016 3.87322 21.9095 3.92768C22.0174 3.98214 22.1111 4.06113 22.1829 4.15832C22.2548 4.25551 22.3028 4.36819 22.3232 4.48731C22.3436 4.60644 22.3357 4.72881 22.3002 4.84434ZM22.1128 4.78662L19.368 13.6976L22.1128 4.78662ZM18.2642 13.3583L20.7799 5.19416H4.83869L7.16866 13.3401C7.22618 13.5409 7.34767 13.7176 7.51472 13.8433C7.68178 13.9691 7.8853 14.037 8.09448 14.0369H17.3441C17.55 14.0369 17.7504 13.9711 17.916 13.8489C18.0816 13.7268 18.2036 13.5548 18.2642 13.3583ZM9.24622 18.4583C9.24622 18.7633 9.15567 19.0614 8.98604 19.3149C8.81642 19.5685 8.57535 19.766 8.29335 19.8827C8.01136 19.9993 7.70107 20.0299 7.40173 19.9704C7.10238 19.9109 6.82737 19.7641 6.6115 19.5485C6.39563 19.3329 6.24859 19.0582 6.18902 18.7591C6.12944 18.46 6.16002 18.15 6.27687 17.8682C6.39372 17.5865 6.59158 17.3457 6.8454 17.1763C7.09921 17.007 7.39758 16.9166 7.70279 16.9166C8.11205 16.9166 8.50461 17.0789 8.79408 17.368C9.08355 17.6572 9.24622 18.0493 9.24622 18.4583ZM16.8543 17.1763C17.1082 17.007 17.4065 16.9166 17.7117 16.9166C18.121 16.9166 18.5136 17.0789 18.803 17.368C19.0925 17.6571 19.2552 18.0493 19.2552 18.4583C19.2552 18.7633 19.1646 19.0614 18.995 19.3149C18.8254 19.5685 18.5843 19.766 18.3023 19.8827C18.0203 19.9993 17.71 20.0299 17.4107 19.9704C17.1113 19.9109 16.8363 19.7641 16.6205 19.5485C16.4046 19.3329 16.2575 19.0582 16.198 18.7591C16.1384 18.46 16.169 18.15 16.2858 17.8682C16.4027 17.5865 16.6005 17.3457 16.8543 17.1763ZM8.82308 19.2059C8.97113 18.9846 9.05015 18.7244 9.05015 18.4583C9.05015 18.1014 8.90819 17.7591 8.65552 17.5068C8.40284 17.2544 8.06013 17.1126 7.70279 17.1126C7.43631 17.1126 7.17581 17.1916 6.95424 17.3394C6.73266 17.4873 6.55997 17.6974 6.45799 17.9433C6.35601 18.1892 6.32933 18.4598 6.38132 18.7208C6.43331 18.9818 6.56163 19.2216 6.75006 19.4098C6.93849 19.598 7.17857 19.7261 7.43993 19.7781C7.70129 19.83 7.9722 19.8033 8.2184 19.7015C8.4646 19.5996 8.67503 19.4272 8.82308 19.2059ZM16.9632 17.3394C17.1848 17.1916 17.4453 17.1126 17.7117 17.1126C18.0691 17.1126 18.4118 17.2544 18.6645 17.5068C18.9171 17.7591 19.0591 18.1014 19.0591 18.4583C19.0591 18.7244 18.9801 18.9846 18.832 19.2059C18.684 19.4272 18.4735 19.5996 18.2273 19.7015C17.9812 19.8033 17.7102 19.83 17.4489 19.7781C17.1875 19.7261 16.9474 19.598 16.759 19.4098C16.5706 19.2216 16.4423 18.9818 16.3903 18.7208C16.3383 18.4598 16.365 18.1892 16.4669 17.9433C16.5689 17.6974 16.7416 17.4873 16.9632 17.3394ZM4.50859 4.04075H21.5613H4.50859ZM21.5613 4.04075C21.6516 4.04084 21.7406 4.06207 21.8212 4.10273L21.5613 4.04075ZM21.8212 4.10273C21.9017 4.1434 21.9716 4.20236 22.0253 4.27489L21.8212 4.10273ZM22.0253 4.27489C22.0789 4.34742 22.1147 4.43149 22.1299 4.52036L22.0253 4.27489ZM22.1299 4.52036C22.1451 4.60923 22.1393 4.70043 22.1128 4.78662L22.1299 4.52036Z" fill="#2790F9"/>
                  </svg>
                  <span class='badge' :class="cart_count > 0 ? 'enable' : '' ">{{ cart_count }}</span>
               </div>

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

            </div>
         </div>
         <div class='appbar-bottom navbar-bottom-border'>
            <ul class='navbar style02 navbar-icon navbar-order'>

               <li @click='select_filter(filter.value)' v-for='(filter, index) in order_status_filter' :key='index' 
                  :class='[
                     filter.active == true ? "active" : "", extraClass
                  ]'>
                  <span class='icon mb10'>
                     <span class='icon-svg' v-html='filter.icon'></span>
                     <span v-show='filter.count > 0' class='count-order-badge'>{{ filter.count }}</span>
                  </span>
                  <span class='text text-small'>{{ filter.label }}</span>
               </li>

            </ul>
         </div>
      </div>

      <div class='scaffold'>

         <ul v-show='loading_data == false && orders.length > 0' class='list-order' >
            <li v-for='(order, orderKey) in filter_orders' :key='orderKey'>

               <div class='order-head exapend-size'>
                  <svg width="21" height="17" viewBox="0 0 21 17" fill="none" xmlns="http://www.w3.org/2000/svg"><rect x="2.5" y="6.5" width="16" height="10" rx="1.5" fill="white" stroke="black"/><path d="M20.096 4.43083L20.0959 4.4307L17.8831 0.787088L17.8826 0.786241C17.7733 0.605479 17.5825 0.5 17.3865 0.5H3.61215C3.41614 0.5 3.22534 0.605479 3.11605 0.786241L3.11554 0.787088L0.902826 4.43061C0.902809 4.43064 0.902792 4.43067 0.902775 4.4307C0.0376853 5.85593 0.639918 7.73588 1.97289 8.31233C2.15024 8.38903 2.34253 8.44415 2.54922 8.47313C2.67926 8.49098 2.81302 8.5 2.9473 8.5C3.80016 8.5 4.5594 8.1146 5.08594 7.50809L5.46351 7.07318L5.84107 7.50809C6.36742 8.11438 7.12999 8.5 7.97971 8.5C8.83258 8.5 9.59181 8.1146 10.1184 7.50809L10.4959 7.07318L10.8735 7.50809C11.3998 8.11438 12.1624 8.5 13.0121 8.5C13.865 8.5 14.6242 8.1146 15.1508 7.50809L15.5273 7.07438L15.905 7.50705C16.4357 8.11494 17.1956 8.5 18.0445 8.5C18.1822 8.5 18.3128 8.49098 18.4433 8.47304L20.096 4.43083ZM20.096 4.43083C21.0907 6.06765 20.1619 8.23575 18.4435 8.47301L20.096 4.43083Z" fill="white" stroke="black"/></svg>
                  <div class='leading'><span>{{ order.store_name }}</span></div>
                  <div class='status'>
                     <button v-show="show_chat_when == true" @click='atlantis_create_conversation_or_get_it(order)' class='btn-chat'>
                        <svg width="22" height="20" viewBox="0 0 22 20" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M20.4711 0H1.30667C0.960117 0 0.627761 0.137459 0.382714 0.382139C0.137666 0.626819 0 0.958676 0 1.30471V15.2216C0 15.5676 0.137666 15.8995 0.382714 16.1441C0.627761 16.3888 0.960117 16.5263 1.30667 16.5263H7.78229C7.85748 16.5262 7.9314 16.5457 7.99685 16.5826C8.0623 16.6196 8.11705 16.6728 8.15578 16.7372L9.76624 19.3684C9.88246 19.5611 10.0466 19.7205 10.2427 19.8312C10.4389 19.9418 10.6603 20 10.8856 20C11.1109 20 11.3324 19.9418 11.5285 19.8312C11.7246 19.7205 11.8888 19.5611 12.005 19.3684L13.6198 16.7307C13.6585 16.6663 13.7133 16.6131 13.7788 16.5761C13.8442 16.5391 13.9181 16.5197 13.9933 16.5197H20.4711C20.8177 16.5197 21.15 16.3823 21.3951 16.1376C21.6401 15.8929 21.7778 15.5611 21.7778 15.215V1.30471C21.7778 0.958676 21.6401 0.626819 21.3951 0.382139C21.15 0.137459 20.8177 0 20.4711 0ZM20.9067 15.2216C20.9067 15.3369 20.8608 15.4475 20.7791 15.5291C20.6974 15.6106 20.5866 15.6565 20.4711 15.6565H13.9955C13.7705 15.6565 13.5493 15.7146 13.3534 15.8251C13.1575 15.9356 12.9935 16.0947 12.8772 16.2871L11.2624 18.9248C11.2238 18.9897 11.169 19.0434 11.1033 19.0808C11.0377 19.1181 10.9634 19.1377 10.8878 19.1377C10.8122 19.1377 10.738 19.1181 10.6723 19.0808C10.6066 19.0434 10.5518 18.9897 10.5132 18.9248L8.90167 16.2914C8.78586 16.0981 8.62189 15.938 8.42573 15.8267C8.22957 15.7155 8.00789 15.6568 7.78229 15.6565H1.30667C1.19115 15.6565 1.08037 15.6106 0.998682 15.5291C0.917 15.4475 0.871111 15.3369 0.871111 15.2216V1.30471C0.871111 1.18936 0.917 1.07874 0.998682 0.997184C1.08037 0.915624 1.19115 0.869804 1.30667 0.869804H20.4711C20.5866 0.869804 20.6974 0.915624 20.7791 0.997184C20.8608 1.07874 20.9067 1.18936 20.9067 1.30471V15.2216ZM11.76 8.26313C11.76 8.43517 11.7089 8.60333 11.6132 8.74637C11.5175 8.88941 11.3814 9.0009 11.2222 9.06673C11.0631 9.13256 10.8879 9.14979 10.7189 9.11623C10.55 9.08266 10.3947 8.99982 10.2729 8.87818C10.1511 8.75653 10.0681 8.60155 10.0345 8.43283C10.0009 8.2641 10.0182 8.08921 10.0841 7.93027C10.15 7.77134 10.2617 7.63549 10.4049 7.53992C10.5482 7.44434 10.7166 7.39333 10.8889 7.39333C11.1199 7.39333 11.3415 7.48497 11.5049 7.64809C11.6682 7.81121 11.76 8.03245 11.76 8.26313ZM6.96889 8.26313C6.96889 8.43517 6.9178 8.60333 6.82208 8.74637C6.72636 8.88941 6.59031 9.0009 6.43114 9.06673C6.27196 9.13256 6.09681 9.14979 5.92783 9.11623C5.75885 9.08266 5.60364 8.99982 5.48181 8.87818C5.35998 8.75653 5.27702 8.60155 5.2434 8.43283C5.20979 8.2641 5.22704 8.08921 5.29298 7.93027C5.35891 7.77134 5.47056 7.63549 5.61381 7.53992C5.75707 7.44434 5.92549 7.39333 6.09778 7.39333C6.32881 7.39333 6.55038 7.48497 6.71375 7.64809C6.87711 7.81121 6.96889 8.03245 6.96889 8.26313ZM16.5511 8.26313C16.5511 8.43517 16.5 8.60333 16.4043 8.74637C16.3086 8.88941 16.1725 9.0009 16.0134 9.06673C15.8542 9.13256 15.679 9.14979 15.5101 9.11623C15.3411 9.08266 15.1859 8.99982 15.064 8.87818C14.9422 8.75653 14.8592 8.60155 14.8256 8.43283C14.792 8.2641 14.8093 8.08921 14.8752 7.93027C14.9411 7.77134 15.0528 7.63549 15.196 7.53992C15.3393 7.44434 15.5077 7.39333 15.68 7.39333C15.911 7.39333 16.1326 7.48497 16.296 7.64809C16.4593 7.81121 16.5511 8.03245 16.5511 8.26313Z" fill="#2790F9"/></svg>
                        <span class='text'><?php echo __('Chat', 'watergo'); ?></span>
                     </button>
                  </div>
               </div>

               <div 
                  v-for='(product, prodKey) in order.order_products' :key='prodKey'
                  @click='gotoOrderDetail(order.order_id)' class='order-prods'>
                  <div class='leading'>
                     <img :src="product.order_group_product_image.url">
                  </div>
                  <div class='prod-detail'>
                     <span class='prod-name'>{{ product.order_group_product_name }}</span>
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

            </li>
         </ul>

         <div v-show='loading_data == true' class='progress-center'>
            <div class='progress-container enabled'><progress class='progress-circular enabled' ></progress></div>
         </div>
      </div>
      

   </div>

   <module_get_order_delivering ref='module_get_order_delivering'></module_get_order_delivering>

</div>

<script type='text/javascript'>

var app = Vue.createApp({
   data (){
      return {
         loading_data: false,
         loading: true,
         notification_count: 0,
         message_count: 0,
         isCancel: false,
         paged: 0,
         order_status: 'ordered',
         orders: [],
         last_order_id: 0,
         orders_count: 0,
         cart_count: 0,
         get_locale: '<?php echo get_locale(); ?>',
         
         order_status_filter: [ 
            { 
               label: `
                  <?php 
                     if( get_locale() == 'vi' ){echo 'Đã Đặt';
                     }else if( get_locale() == 'ko_KR'){ echo '주문 완료';
                     }else{ echo 'Ordered';}
                  ?>
               `, value: 'ordered', active: true,
               icon: `
                  <svg width="36" height="36" viewBox="0 0 36 36" fill="none" xmlns="http://www.w3.org/2000/svg">
                  <circle cx="18" cy="18" r="17.75" fill="white" stroke="#7B7D83" stroke-width="0.5"/>
                  <mask id="path-2-inside-1_2649_263" fill="white">
                  <path d="M24.7868 13.5737L15.8606 22.5L11.8032 18.4426"/>
                  </mask>
                  <path d="M26.201 14.9879C26.9821 14.2069 26.9821 12.9406 26.201 12.1595C25.42 11.3785 24.1537 11.3785 23.3726 12.1595L26.201 14.9879ZM15.8606 22.5L14.4464 23.9142C14.8215 24.2892 15.3302 24.5 15.8606 24.5C16.391 24.5 16.8997 24.2892 17.2748 23.9142L15.8606 22.5ZM13.2174 17.0284C12.4364 16.2473 11.1701 16.2473 10.389 17.0284C9.60796 17.8094 9.60796 19.0757 10.389 19.8568L13.2174 17.0284ZM23.3726 12.1595L14.4464 21.0857L17.2748 23.9142L26.201 14.9879L23.3726 12.1595ZM17.2748 21.0857L13.2174 17.0284L10.389 19.8568L14.4464 23.9142L17.2748 21.0857Z" fill="#7B7D83" mask="url(#path-2-inside-1_2649_263)"/>
                  </svg>
               `,
               count: 0,
               extraClass: 'icon-1'
            },
            {
               label: `
                  <?php 
                     if( get_locale() == 'vi' ){echo 'Chờ Giao';
                     }else if( get_locale() == 'ko_KR' ){ echo '준비중';
                     }else{ echo 'Prepare';}
                  ?>
               `, value: 'confirmed', active: false,
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
               count: 0,
               extraClass: 'icon-2'
               
            },
            { 
               label: `
                  <?php 
                     if( get_locale() == 'vi' ){echo 'Đang Giao';
                     }else if( get_locale() == 'ko_KR' ){ echo '배송중';
                     }else{echo 'Delivering';}
                  
                  ?>
               `, value: 'delivering', active: false,
               icon: `
                  <svg width="37" height="37" viewBox="0 0 37 37" fill="none" xmlns="http://www.w3.org/2000/svg">
                  <circle cx="18.2553" cy="18.7446" r="18.0053" fill="white" stroke="#7B7D83" stroke-width="0.5"/>
                  <path d="M12.7207 20.6882V14.4072H20.1987V20.6882H12.7207Z" stroke="#7B7D83" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                  <path d="M21.6987 17.3999H23.0322L24.3885 18.7562V20.6882H21.6987V17.3999Z" stroke="#7B7D83" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                  <path d="M15.4105 22.9343C15.4105 23.3465 15.0764 23.6807 14.6642 23.6807C14.252 23.6807 13.9178 23.3465 13.9178 22.9343C13.9178 22.5221 14.252 22.188 14.6642 22.188C15.0764 22.188 15.4105 22.5221 15.4105 22.9343Z" stroke="#7B7D83" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                  <path d="M23.1914 22.9343C23.1914 23.3465 22.8573 23.6807 22.4451 23.6807C22.0329 23.6807 21.6987 23.3465 21.6987 22.9343C21.6987 22.5221 22.0329 22.188 22.4451 22.188C22.8573 22.188 23.1914 22.5221 23.1914 22.9343Z" stroke="#7B7D83" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                  </svg>
               `,
               count: 0,
               extraClass: 'icon-3'
            },
            { 
               label: `
                  <?php 
                     if( get_locale() == 'vi' ){echo 'Đã Nhận';
                     }else if( get_locale() == 'ko_KR' ){ echo '완료';
                     }else{ echo 'Complete'; }
                   ?>
               `, value: 'complete', active: false,
               icon: `
                  <svg width="37" height="37" viewBox="0 0 37 37" fill="none" xmlns="http://www.w3.org/2000/svg">
                  <circle cx="18.5" cy="18.5" r="18.25" fill="white" stroke="#7B7D83" stroke-width="0.5"/>
                  <path d="M18.2623 11.6505C18.3371 11.4202 18.6629 11.4202 18.7378 11.6505L19.8092 14.948C20.0435 15.669 20.7154 16.1572 21.4735 16.1572H24.9407C25.1829 16.1572 25.2836 16.4671 25.0876 16.6094L22.2827 18.6474C21.6693 19.093 21.4127 19.8829 21.6469 20.6039L22.7183 23.9014C22.7932 24.1317 22.5296 24.3233 22.3336 24.1809L19.5286 22.143C18.9153 21.6973 18.0847 21.6973 17.4714 22.143L14.6664 24.1809L15.1072 24.7877L14.6664 24.1809C14.4705 24.3233 14.2069 24.1317 14.2817 23.9014L15.3531 20.604C15.5874 19.8829 15.3307 19.093 14.7174 18.6474L11.9124 16.6094C11.7165 16.4671 11.8172 16.1572 12.0593 16.1572H15.5265C16.2846 16.1572 16.9566 15.669 17.1908 14.948L18.2623 11.6505Z" fill="white" stroke="#7B7D83" stroke-width="1.5"/>
                  </svg>
               `,
               count: 0,
               extraClass: 'icon-4'
            },
            { 
               label: `<?php 
                  if( get_locale() == 'vi'){ echo 'Đã Huỷ';
                  }else if( get_locale() == 'ko_KR'){ echo '취소';
                  }else{ echo 'Cancel'; }
               ?>`, value: 'cancel', active: false,
               icon: `
                  <svg width="36" height="36" viewBox="0 0 36 36" fill="none" xmlns="http://www.w3.org/2000/svg">
                  <circle cx="18" cy="18" r="17.75" fill="white" stroke="#7B7D83" stroke-width="0.5"/>
                  <path d="M23.6065 12.3936L12.3934 23.6067" stroke="#7B7D83" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                  <path d="M12.3934 12.3936L23.6065 23.6067" stroke="#7B7D83" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                  </svg>
               `,
               count: 0,
               extraClass: 'icon-5'
            }
         ],

      }
   },

   computed: {

      filter_orders(){
         if(this.order_status == 'ordered'){
            return this.orders.sort( (a, b) => b.order_time_created - a.order_time_created );
         }
         if(this.order_status == 'confirmed'){
            return this.orders.sort( (a, b) => b.order_time_confirmed - a.order_time_confirmed );
         }
         if(this.order_status == 'delivering'){
            return this.orders.sort( (a, b) => b.order_time_delivery - a.order_time_delivery );
         }
         if(this.order_status == 'complete'){
            return this.orders.sort( (a, b) => b.order_time_completed - a.order_time_completed );
         }
         if(this.order_status == 'cancel'){
            return this.orders.sort( (a, b) => b.order_time_cancel - a.order_time_cancel );
         }

      },

      show_chat_when(){
         var _active_tab = this.order_status_filter.find( item => item.active == true );
         if(_active_tab) {
            if( _active_tab.value == "cancel" || _active_tab.value == "complete" ){
               return false;
            }else{
               return true;
            }
         } return false
      },
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

      common_price_after_discount_and_quantity_from_group_order(p){ return window.common_price_after_discount_and_quantity_from_group_order(p)},
      common_price_after_quantity_from_group_order(p){ return window.common_price_after_quantity_from_group_order(p)},

      gotoChat(){ window.gotoChat(); },

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

      async select_filter( filter_select ){ 
         this.order_status_filter.some(item => {
            if( item.value == filter_select ){ 
               item.active = true;
               this.order_status = item.value;
            }else{ item.active = false; }
         });
      },

      gotoProductDetail(product_id){ window.gotoProductDetail(product_id); },
      gotoStoreDetail(store_id){ window.gotoStoreDetail(store_id); },

      count_total_price_in_order(order_id ){
         var _total = 0;

         this.orders.some( order => {
            if( order.order_id == order_id ){
               if( order.order_products != undefined && order.order_products.length > 0 ){
                  order.order_products.some ( product => {
                     _total += get_total_price(
                        product.order_group_product_price, 
                        product.order_group_product_quantity_count, 
                        product.order_group_product_discount_percent
                     )
                  });
               }
            }
         });
         return _total.toLocaleString() + global_currency;
      },

      count_total_product_in_order(order_id){
         var _total = 0;
         if( this.orders.length > 0 ){
            this.orders.some( order => {
               if( order.order_id == order_id ){
                  if( order.order_products != undefined && order.order_products.length > 0 ){
                     order.order_products.some( product => {
                        _total += parseInt( product.order_group_product_quantity_count );
                     });
                  }
               }
            });
         }
         return _total;
      },

      change_name_status( status ){
         var _status = status;

         if( _status == 'confirmed' ){
            _status = 'Prepare';
         }

         if(this.get_locale == 'vi' ){
            if( _status == 'ordered'){ _status = 'Đã Đặt'; }
            if( _status == 'Prepare'){ _status = 'Chờ Giao'; }
            if( _status == 'delivering'){ _status = 'Đang Giao'; }
            if( _status == 'complete'){ _status = 'Hoàn Thành';}
            if( _status == 'cancel'){ _status = 'Đã Huỷ'; }
         }

         if(this.get_locale == 'ko_KR' ){
            if( _status == 'ordered'){ _status = '주문 완료'; }
            if( _status == 'Prepare'){ _status = '준비중'; }
            if( _status == 'delivering'){ _status = '배송중'; }
            if( _status == 'complete'){ _status = '완료';}
            if( _status == 'cancel'){ _status = '취소'; }
         }


         return _status;
      },

      gotoCart(){ window.gotoCart(); },
      gotoOrderDetail(order_id){ window.gotoOrderDetail(order_id); },
      gotoOrderFilter(filter){ window.gotoOrderFilter(filter); },

      async handleScroll() {
         const windowTop = window.pageYOffset || document.documentElement.scrollTop;
         const scrollEndThreshold = 50; // Adjust this value as needed
         const scrollPosition = window.pageYOffset || document.documentElement.scrollTop;
         const windowHeight   = window.innerHeight;
         const documentHeight = document.documentElement.scrollHeight;
         var windowScroll     = scrollPosition + windowHeight + scrollEndThreshold;
         var documentScroll   = documentHeight + scrollEndThreshold;
         // if (scrollPosition + windowHeight + 10 >= documentHeight - 10) {
         if (scrollPosition + windowHeight >= documentHeight ) {
            await this.get_order(this.order_status);
         }
      },

      async get_order(order_status ){
         var form = new FormData();
         form.append('action', 'atlantis_get_order_user');
         form.append('paged', this.orders.length );
         form.append('order_status', order_status);
         var r = await window.request(form);
         if( r != undefined ){
            var res = JSON.parse( JSON.stringify( r ));
            if( res.message == 'get_order_ok' ){
               res.data.forEach(item => {
                  if (!this.orders.some(existingItem => existingItem.order_id === item.order_id)) {
                     this.orders.push(item);
                  }
               });
            }
         }
      },

      async get_count_total_order(){
         // this.order_status_filter.some(item => item.count = 0);
         var form = new FormData();
         form.append('action', 'atlantis_count_total_order_by_user');
         var r = await window.request(form);
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

      async atlantis_get_newest_order(){
         var order_ids = [];
         
         if( this.orders.length > 0){
            this.orders.forEach( item => {
               order_ids.push( parseInt(item.order_id) );
            });
            this.last_order_id = this.orders.slice().reverse()[this.orders.length - 1].order_id;
         }

         var form = new FormData();
         form.append('action', 'atlantis_get_newest_order');
         form.append('order_status',  this.order_status);
         form.append('order_ids', JSON.stringify(order_ids));
         form.append('last_order_id', this.last_order_id);

         var r = await window.request(form);

         if( r != undefined ){
            var res = JSON.parse( JSON.stringify( r));
            if( res.message == 'order_found' ){
               if(res.order_need_delete.length > 0 ){
                  res.order_need_delete.forEach( order => {
                     var index = this.orders.findIndex( item => item.order_id == order );
                     if( index != -1){
                        this.orders.splice(index, 1);
                     }
                  });
               }
               if(res.order_need_update.length > 0 ){
                  res.order_need_update.forEach( order => {
                     var _exists = this.orders.some( item => item.order_id == order.order_id );
                     if( !_exists ){
                        this.orders.unshift( order);
                     }
                  });
               }
            }
         }

      },

      count_product_in_cart(){ this.cart_count = window.count_product_in_cart() },
      async atlantis_count_messeage_everytime(){ await window.atlantis_count_messeage_everytime() }

   }, 

   watch: {

      orders: {
         handler( data ){

         }, deep: true
      },

      order_status: async function( status ){
         // this.loading = true;
         this.loading_data = true;
         this.orders = [];
         await this.get_count_total_order();
         await this.get_order(status );
         this.loading_data = false;
         // this.loading = false;
         window.appbar_fixed();
      }
   },

   async created(){
      this.loading = true;
      setInterval( async () => { await this.atlantis_count_messeage_everytime(); }, 1500);

      await this.get_count_total_order();
      this.count_product_in_cart();

      setTimeout( async () => {
         await this.get_order( this.order_status);
         await this.get_notification_count();
         this.loading = false;
      }, 400);

      // setInterval( async () => { await this.get_count_total_order();, 2000 })

      // console.log(this.orders)
      window.appbar_fixed();
   },

   mounted() { window.addEventListener('scroll', this.handleScroll); },
   beforeDestroy() {window.removeEventListener('scroll', this.handleScroll); },


})
.component('module_get_order_delivering', module_get_order_delivering)
.mount('#app');

window.app = app;

async function callbackActiveTab(){
//  callbackResume()
   // var _get_order_status = window.app.order_status;
   // window.app.loading_data = true;
   // window.app.orders = [];
   // await window.app.get_count_total_order();
   // await window.app.get_order(_get_order_status );
   // window.app.loading_data = false;

   window.app.count_product_in_cart();
   await window.app.get_notification_count();
   await window.app.atlantis_get_newest_order();
   await window.app.get_count_total_order();
   window.appbar_fixed();
}
</script>
