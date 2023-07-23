<link rel="stylesheet" href="<?php echo THEME_URI . '/assets/js/jquery_ui_1.13.2.min.css'; ?>">
<script src="<?php echo THEME_URI . '/assets/js/jquery_ui_1.13.2.min.js'; ?>"></script>

<div id='app'>

   <div v-show='loading == false ' class='page-report'>
      <div class='appbar style01'>
         <div class='appbar-top'>
            <div class='leading'>
               <p class='leading-title'>
                  Report

                  <div class='datetime-wrapper'>
                     <span @click='btn_open_datetime' class='datetime-display'>{{display_datetime}}</span>

                     <ul v-show='open_datetime' class='dropdown-datetime'>
                        <li
                           @click='select_date(date)'
                           v-for='( date, keyDate) in getPastDaysInMonth ' :key='keyDate'
                        >
                           {{ date }}   
                        </li>
                     </ul>


                     <ul v-show='open_datemonth ' class='dropdown-datetime'>
                        <li
                           @click='select_date(date)'
                           v-for='( date, keyMonth) in getPastMonthsInCurrentYears ' :key='keyMonth'
                        >
                           {{ date }}   
                        </li>

                     </ul>

                     <ul v-show='open_dateyear' class='dropdown-datetime'>
                        <li @click='select_date(2022)'>2022</li>
                        <li @click='select_date(2023)'>2023</li>
                     </ul>

                     <div class='icon'>
                        <svg width="10" height="6" viewBox="0 0 10 6" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M1 1L5 5L9 1" stroke="#252831" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                        </svg>
                     </div>
                  </div>
               </p>
            </div>
            <div class='action'>
               <div @click='gotoCart' class='btn-badge'>
                  <svg width="23" height="20" viewBox="0 0 23 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                  <path d="M9.05036 18.4583C9.05036 18.7244 8.97134 18.9846 8.82329 19.2058C8.67524 19.4271 8.46481 19.5996 8.21861 19.7015C7.97241 19.8033 7.7015 19.83 7.44014 19.778C7.17878 19.7261 6.9387 19.5979 6.75027 19.4098C6.56184 19.2216 6.43352 18.9818 6.38153 18.7208C6.32954 18.4597 6.35622 18.1892 6.4582 17.9433C6.56018 17.6974 6.73288 17.4873 6.95445 17.3394C7.17602 17.1915 7.43652 17.1126 7.703 17.1126C8.06034 17.1126 8.40305 17.2544 8.65573 17.5067C8.9084 17.7591 9.05036 18.1014 9.05036 18.4583ZM17.7119 17.1126C17.4455 17.1126 17.185 17.1915 16.9634 17.3394C16.7418 17.4873 16.5691 17.6974 16.4672 17.9433C16.3652 18.1892 16.3385 18.4597 16.3905 18.7208C16.4425 18.9818 16.5708 19.2216 16.7592 19.4098C16.9477 19.5979 17.1877 19.7261 17.4491 19.778C17.7105 19.83 17.9814 19.8033 18.2276 19.7015C18.4738 19.5996 18.6842 19.4271 18.8322 19.2058C18.9803 18.9846 19.0593 18.7244 19.0593 18.4583C19.0593 18.1014 18.9174 17.7591 18.6647 17.5067C18.412 17.2544 18.0693 17.1126 17.7119 17.1126ZM22.113 4.78659L19.3682 13.6976C19.2367 14.1303 18.9691 14.5091 18.605 14.778C18.241 15.0468 17.8 15.1914 17.3472 15.1903H8.0947C7.63433 15.1886 7.18695 15.0378 6.81974 14.7604C6.45253 14.4831 6.18533 14.0943 6.05826 13.6524L2.57823 1.48882C2.56669 1.44855 2.54231 1.41315 2.50878 1.38799C2.47525 1.36283 2.43442 1.3493 2.39248 1.34945H0.773728C0.620582 1.34945 0.473708 1.28869 0.365417 1.18054C0.257126 1.07238 0.196289 0.925697 0.196289 0.772746C0.196289 0.619796 0.257126 0.473109 0.365417 0.364957C0.473708 0.256804 0.620582 0.196045 0.773728 0.196045H2.39248C2.68501 0.196833 2.9694 0.292344 3.20296 0.468247C3.43652 0.64415 3.60667 0.890957 3.68787 1.17163L4.5088 4.04072H21.5615C21.6518 4.04081 21.7408 4.06204 21.8214 4.1027C21.902 4.14336 21.9719 4.20232 22.0255 4.27485C22.0791 4.34738 22.115 4.43146 22.1302 4.52033C22.1454 4.6092 22.1395 4.70039 22.113 4.78659ZM20.7801 5.19412H4.8389L7.16887 13.34C7.22639 13.5409 7.34788 13.7176 7.51493 13.8433C7.68199 13.969 7.88551 14.037 8.0947 14.0369H17.3443C17.5502 14.0369 17.7506 13.971 17.9162 13.8489C18.0818 13.7268 18.2038 13.5548 18.2644 13.3583L20.7801 5.19412Z" fill="#2790F9"/>
                  <path fill-rule="evenodd" clip-rule="evenodd" d="M22.3002 4.84434L19.5556 13.7547C19.4118 14.2275 19.1191 14.6419 18.7213 14.9357C18.3234 15.2296 17.8413 15.3876 17.3465 15.3864H8.09448C7.59174 15.3845 7.10242 15.2198 6.70136 14.917C6.3003 14.6141 6.00841 14.1894 5.86961 13.7066L2.39029 1.54556H0.773518C0.568449 1.54556 0.371729 1.4642 0.226647 1.31931C0.0815564 1.1744 0 0.977815 0 0.77278C0 0.567745 0.0815563 0.371158 0.226647 0.226253C0.371729 0.0813567 0.568449 0 0.773518 0H2.39227C2.72716 0.000902557 3.05328 0.110242 3.32071 0.311653C3.58815 0.513066 3.78301 0.795701 3.87602 1.11717L4.65643 3.84467H21.5613C21.6822 3.8448 21.8016 3.87322 21.9095 3.92768C22.0174 3.98214 22.1111 4.06113 22.1829 4.15832C22.2548 4.25551 22.3028 4.36819 22.3232 4.48731C22.3436 4.60644 22.3357 4.72881 22.3002 4.84434ZM22.1128 4.78662L19.368 13.6976L22.1128 4.78662ZM18.2642 13.3583L20.7799 5.19416H4.83869L7.16866 13.3401C7.22618 13.5409 7.34767 13.7176 7.51472 13.8433C7.68178 13.9691 7.8853 14.037 8.09448 14.0369H17.3441C17.55 14.0369 17.7504 13.9711 17.916 13.8489C18.0816 13.7268 18.2036 13.5548 18.2642 13.3583ZM9.24622 18.4583C9.24622 18.7633 9.15567 19.0614 8.98604 19.3149C8.81642 19.5685 8.57535 19.766 8.29335 19.8827C8.01136 19.9993 7.70107 20.0299 7.40173 19.9704C7.10238 19.9109 6.82737 19.7641 6.6115 19.5485C6.39563 19.3329 6.24859 19.0582 6.18902 18.7591C6.12944 18.46 6.16002 18.15 6.27687 17.8682C6.39372 17.5865 6.59158 17.3457 6.8454 17.1763C7.09921 17.007 7.39758 16.9166 7.70279 16.9166C8.11205 16.9166 8.50461 17.0789 8.79408 17.368C9.08355 17.6572 9.24622 18.0493 9.24622 18.4583ZM16.8543 17.1763C17.1082 17.007 17.4065 16.9166 17.7117 16.9166C18.121 16.9166 18.5136 17.0789 18.803 17.368C19.0925 17.6571 19.2552 18.0493 19.2552 18.4583C19.2552 18.7633 19.1646 19.0614 18.995 19.3149C18.8254 19.5685 18.5843 19.766 18.3023 19.8827C18.0203 19.9993 17.71 20.0299 17.4107 19.9704C17.1113 19.9109 16.8363 19.7641 16.6205 19.5485C16.4046 19.3329 16.2575 19.0582 16.198 18.7591C16.1384 18.46 16.169 18.15 16.2858 17.8682C16.4027 17.5865 16.6005 17.3457 16.8543 17.1763ZM8.82308 19.2059C8.97113 18.9846 9.05015 18.7244 9.05015 18.4583C9.05015 18.1014 8.90819 17.7591 8.65552 17.5068C8.40284 17.2544 8.06013 17.1126 7.70279 17.1126C7.43631 17.1126 7.17581 17.1916 6.95424 17.3394C6.73266 17.4873 6.55997 17.6974 6.45799 17.9433C6.35601 18.1892 6.32933 18.4598 6.38132 18.7208C6.43331 18.9818 6.56163 19.2216 6.75006 19.4098C6.93849 19.598 7.17857 19.7261 7.43993 19.7781C7.70129 19.83 7.9722 19.8033 8.2184 19.7015C8.4646 19.5996 8.67503 19.4272 8.82308 19.2059ZM16.9632 17.3394C17.1848 17.1916 17.4453 17.1126 17.7117 17.1126C18.0691 17.1126 18.4118 17.2544 18.6645 17.5068C18.9171 17.7591 19.0591 18.1014 19.0591 18.4583C19.0591 18.7244 18.9801 18.9846 18.832 19.2059C18.684 19.4272 18.4735 19.5996 18.2273 19.7015C17.9812 19.8033 17.7102 19.83 17.4489 19.7781C17.1875 19.7261 16.9474 19.598 16.759 19.4098C16.5706 19.2216 16.4423 18.9818 16.3903 18.7208C16.3383 18.4598 16.365 18.1892 16.4669 17.9433C16.5689 17.6974 16.7416 17.4873 16.9632 17.3394ZM4.50859 4.04075H21.5613H4.50859ZM21.5613 4.04075C21.6516 4.04084 21.7406 4.06207 21.8212 4.10273L21.5613 4.04075ZM21.8212 4.10273C21.9017 4.1434 21.9716 4.20236 22.0253 4.27489L21.8212 4.10273ZM22.0253 4.27489C22.0789 4.34742 22.1147 4.43149 22.1299 4.52036L22.0253 4.27489ZM22.1299 4.52036C22.1451 4.60923 22.1393 4.70043 22.1128 4.78662L22.1299 4.52036Z" fill="#2790F9"/>
                  </svg>

                  <span class='badge' :class="count_product_in_cart > 0 ? 'enable' : '' ">{{ count_product_in_cart }}</span>
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
         <div class='appbar-bottom'>
            <ul class='navbar style-expaned'>
               <li
                  @click='select_filter_datetime(date.value)'
                  v-for=' ( date, keyDate ) in filter_datetime' :key='keyDate'
                  :class='date.active == true ? "active" : ""'>{{ date.label }}</li>
            </ul>

         </div>
      </div>

      <div class='inner mt30'>
         
         <div class='box-profit'>
            <div class='order-count'>SOLD: <span class='highlight'>{{ report.sold }}</span> Orders</div>
            <div class='rank rank-up'>
               <svg v-if='report.order_complete_Comparison > 0 && report.sold_rank == "low"' width="25" height="20" viewBox="0 0 15 20" fill="none" xmlns="http://www.w3.org/2000/svg">
               <path d="M8.77815 1.29289C8.38763 0.902369 7.75446 0.902369 7.36394 1.29289L0.999977 7.65685C0.609453 8.04738 0.609453 8.68054 0.999977 9.07107C1.3905 9.46159 2.02367 9.46159 2.41419 9.07107L8.07104 3.41421L13.7279 9.07107C14.1184 9.46159 14.7516 9.46159 15.1421 9.07107C15.5326 8.68054 15.5326 8.04738 15.1421 7.65685L8.77815 1.29289ZM9.07104 18V2H7.07104V18H9.07104Z" fill="#13E800"/>
               </svg>
               <svg v-if='report.order_complete_Comparison > 0 && report.sold_rank == "high"' width="25" height="20" viewBox="0 0 15 20" fill="none" xmlns="http://www.w3.org/2000/svg">
               <path d="M8.77815 18.7071C8.38763 19.0976 7.75446 19.0976 7.36394 18.7071L0.999977 12.3431C0.609453 11.9526 0.609453 11.3195 0.999977 10.9289C1.3905 10.5384 2.02367 10.5384 2.41419 10.9289L8.07104 16.5858L13.7279 10.9289C14.1184 10.5384 14.7516 10.5384 15.1421 10.9289C15.5326 11.3195 15.5326 11.9526 15.1421 12.3431L8.77815 18.7071ZM7.07104 18V2H9.07104V18H7.07104Z" fill="#FF5656"/>
               </svg>
               <span v-if='report.order_complete_Comparison > 0' class='rank-sum'>{{ report.order_complete_Comparison }}</span>
            </div>
         </div>

         <div class='box-profit'>
            <div class='order-count'>CANCELED: <span class='highlight'>{{ report.cancel }}</span> Orders</div>
            <div class='rank rank-down'>

               <svg v-if='report.order_cancel_Comparison > 0 && report.cancel_rank == "low"' width="25" height="20" viewBox="0 0 15 20" fill="none" xmlns="http://www.w3.org/2000/svg">
               <path d="M8.77815 1.29289C8.38763 0.902369 7.75446 0.902369 7.36394 1.29289L0.999977 7.65685C0.609453 8.04738 0.609453 8.68054 0.999977 9.07107C1.3905 9.46159 2.02367 9.46159 2.41419 9.07107L8.07104 3.41421L13.7279 9.07107C14.1184 9.46159 14.7516 9.46159 15.1421 9.07107C15.5326 8.68054 15.5326 8.04738 15.1421 7.65685L8.77815 1.29289ZM9.07104 18V2H7.07104V18H9.07104Z" fill="#13E800"/>
               </svg>
               <svg v-if='report.order_cancel_Comparison > 0 && report.cancel_rank == "high"' width="25" height="20" viewBox="0 0 15 20" fill="none" xmlns="http://www.w3.org/2000/svg">
               <path d="M8.77815 18.7071C8.38763 19.0976 7.75446 19.0976 7.36394 18.7071L0.999977 12.3431C0.609453 11.9526 0.609453 11.3195 0.999977 10.9289C1.3905 10.5384 2.02367 10.5384 2.41419 10.9289L8.07104 16.5858L13.7279 10.9289C14.1184 10.5384 14.7516 10.5384 15.1421 10.9289C15.5326 11.3195 15.5326 11.9526 15.1421 12.3431L8.77815 18.7071ZM7.07104 18V2H9.07104V18H7.07104Z" fill="#FF5656"/>
               </svg>

               <span v-if='report.order_cancel_Comparison > 0' class='rank-sum'>{{ report.order_cancel_Comparison }}</span>
            </div>
         </div>

         <div class='box-profit'>
            <div class='order-count'>TOTAL PROFIT: <span class='highlight'>{{ get_price_convert(report.profit) }}</span></div>
         </div>

      </div>
   </div>

   <div v-show='loading == true'>
      <div class='progress-center'>
         <div class='progress-container enabled'><progress class='progress-circular enabled' ></progress></div>
      </div>
   </div>

</div>
<script type='module'>

var { createApp } = Vue;

createApp({
   data (){
      return {
         loading: false,
         message_count: 0,
         currentDate: new Date(),
         
         display_datetime: '',
         filter_datetime: [
            {label: 'Day', value: 'd', active: true},
            {label: 'Month', value: 'm', active: false},
            {label: 'Year', value: 'y', active: false}
         ],
         stream_datetime_value: '',

         datetime_day: {value: 0},
         datetime_month: {value: 0},
         datetime_year: {value: 0},

         open_datetime: false,
         open_datemonth: false,
         open_dateyear: false,

         final_datetime: '',

         report: {
            sold: 0,
            cancel: 0,
            order_complete_Comparison: 0,
            order_cancel_Comparison: 0,
            profit: 0,
            sold_rank: 'normal',
            cancel_rank: 'normal'
         },
         
      }
   },

   watch: {

      stream_datetime_value: function ( val ){
         var dateObj = new Date();
         var day     = dateObj.getDate().toString().padStart(2, '0');
         var month   = (dateObj.getMonth() + 1).toString().padStart(2, '0');
         var year    = dateObj.getFullYear().toString();

         if( val == 'd' ){
            this.display_datetime   = this.get_full_current_datetime({ day: day });
            this.final_datetime     = this.get_full_current_datetime({ day: day });
         }
         if( val == 'm' ){
            this.display_datetime   = this.get_full_current_datetime({ month: month });
            this.final_datetime     = '01/' + this.get_full_current_datetime({ month: month });
         }
         if( val == 'y' ){
            this.display_datetime   = this.get_full_current_datetime({ year: year });
            this.final_datetime     = '01/01/' + this.get_full_current_datetime({ year: year });
         }
      }

   },

   computed: {

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
      get_price_convert(price){
         if( price > 0){
            return price.toLocaleString('vi-VN') + ' đ';
         }
         return 0 + ' đ';
      },

      reverse_date_to_system_datetime(datetime){ return window.reverse_date_to_system_datetime(datetime) },

      btn_open_datetime(){

         if( this.stream_datetime_value == 'd' ){
            this.open_datetime = !this.open_datetime;
         }
         if( this.stream_datetime_value == 'm' ){
            this.open_datemonth = !this.open_datemonth;
         }
         if( this.stream_datetime_value == 'y' ){
            this.open_dateyear = !this.open_dateyear;
         }
      },

      async select_date( date ){
         
         if( this.stream_datetime_value == 'd' ){
            this.open_datetime      = false;
            this.display_datetime   = this.get_full_current_datetime({ day: date });
            this.final_datetime     = this.get_full_current_datetime({ day: date });
         }
         if( this.stream_datetime_value == 'm' ){
            this.open_datemonth     = false;
            this.display_datetime   = this.get_full_current_datetime({ month: date });
            this.final_datetime     = '01/' + this.get_full_current_datetime({ month: date });
         }
         if( this.stream_datetime_value == 'y' ){
            this.open_dateyear      = false;
            this.display_datetime   = this.get_full_current_datetime({ year: date });
            this.final_datetime     = '01/01/' + this.get_full_current_datetime({ year: date });
         }
            await this._re_get_order_report( this.reverse_date_to_system_datetime( this.final_datetime ) );

         

         console.log( this.final_datetime );
         
      },

      select_filter_datetime(value){

         this.stream_datetime_value = value;
         this.open_datetime = false;
         this.open_datemonth = false;
         this.open_dateyear = false;
         this.filter_datetime.forEach(item => {
            item.active = item.value === value;
         });
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

      async _re_get_order_report( from_date){
         this.loading = true;
         await this.get_order_report(from_date);
         this.loading = false;
      },

      // 
      async get_order_report( from_date ){
         var form = new FormData();
         form.append('action', 'atlantis_get_order_report_by_datetime');
         form.append('from_date', from_date );
         var r = await window.request(form);
         console.log( r );
         if( r != undefined ){
            var res = JSON.parse( JSON.stringify(r));
            if( res.message == 'get_order_ok' ){
               
               this.report.sold     = res.data.sold;
               this.report.cancel   = res.data.cancel;
               this.report.profit   = res.data.profit;
               this.report.order_complete_Comparison   = res.data.order_complete_Comparison;
               this.report.order_cancel_Comparison     = res.data.order_cancel_Comparison;

               this.report.sold_rank         = res.data.sold_rank;
               this.report.cancel_rank       = res.data.cancel_rank;

            }
         }
      },


      // count_product_in_cart(){ return window.count_product_in_cart(); },
      gotoChat(){ window.gotoChat(); },
      gotoCart(){ window.gotoCart(); },
      goBack(){window.goBack(); }
   },

   async created(){

      this.loading = true;
      await this.get_messages_count();
      this.loading = false;

      window.appbar_fixed();

      var _findFilter = this.filter_datetime.find(item => item.active == true);

      if( _findFilter.value == 'd' ){
         this.display_datetime      = this.get_full_current_datetime();
         this.stream_datetime_value = _findFilter.value;
         this.final_datetime        = this.display_datetime;
      }

      var _time_reverse = this.reverse_date_to_system_datetime(this.final_datetime);

      await this.get_order_report( _time_reverse );

      

   }
   
}).mount('#app');
</script>