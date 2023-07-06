
<div id='app'>

   <div v-if='loading == false' class='page-nearby'>

       <div class='appbar'>
         <div class='appbar-top'>
            <span class='leading-title'>Map</span>
            <div class='action'>
               <div @click='gotoCart' class='btn-badge'>
                  <svg width="23" height="20" viewBox="0 0 23 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                  <path d="M9.05036 18.4583C9.05036 18.7244 8.97134 18.9846 8.82329 19.2058C8.67524 19.4271 8.46481 19.5996 8.21861 19.7015C7.97241 19.8033 7.7015 19.83 7.44014 19.778C7.17878 19.7261 6.9387 19.5979 6.75027 19.4098C6.56184 19.2216 6.43352 18.9818 6.38153 18.7208C6.32954 18.4597 6.35622 18.1892 6.4582 17.9433C6.56018 17.6974 6.73288 17.4873 6.95445 17.3394C7.17602 17.1915 7.43652 17.1126 7.703 17.1126C8.06034 17.1126 8.40305 17.2544 8.65573 17.5067C8.9084 17.7591 9.05036 18.1014 9.05036 18.4583ZM17.7119 17.1126C17.4455 17.1126 17.185 17.1915 16.9634 17.3394C16.7418 17.4873 16.5691 17.6974 16.4672 17.9433C16.3652 18.1892 16.3385 18.4597 16.3905 18.7208C16.4425 18.9818 16.5708 19.2216 16.7592 19.4098C16.9477 19.5979 17.1877 19.7261 17.4491 19.778C17.7105 19.83 17.9814 19.8033 18.2276 19.7015C18.4738 19.5996 18.6842 19.4271 18.8322 19.2058C18.9803 18.9846 19.0593 18.7244 19.0593 18.4583C19.0593 18.1014 18.9174 17.7591 18.6647 17.5067C18.412 17.2544 18.0693 17.1126 17.7119 17.1126ZM22.113 4.78659L19.3682 13.6976C19.2367 14.1303 18.9691 14.5091 18.605 14.778C18.241 15.0468 17.8 15.1914 17.3472 15.1903H8.0947C7.63433 15.1886 7.18695 15.0378 6.81974 14.7604C6.45253 14.4831 6.18533 14.0943 6.05826 13.6524L2.57823 1.48882C2.56669 1.44855 2.54231 1.41315 2.50878 1.38799C2.47525 1.36283 2.43442 1.3493 2.39248 1.34945H0.773728C0.620582 1.34945 0.473708 1.28869 0.365417 1.18054C0.257126 1.07238 0.196289 0.925697 0.196289 0.772746C0.196289 0.619796 0.257126 0.473109 0.365417 0.364957C0.473708 0.256804 0.620582 0.196045 0.773728 0.196045H2.39248C2.68501 0.196833 2.9694 0.292344 3.20296 0.468247C3.43652 0.64415 3.60667 0.890957 3.68787 1.17163L4.5088 4.04072H21.5615C21.6518 4.04081 21.7408 4.06204 21.8214 4.1027C21.902 4.14336 21.9719 4.20232 22.0255 4.27485C22.0791 4.34738 22.115 4.43146 22.1302 4.52033C22.1454 4.6092 22.1395 4.70039 22.113 4.78659ZM20.7801 5.19412H4.8389L7.16887 13.34C7.22639 13.5409 7.34788 13.7176 7.51493 13.8433C7.68199 13.969 7.88551 14.037 8.0947 14.0369H17.3443C17.5502 14.0369 17.7506 13.971 17.9162 13.8489C18.0818 13.7268 18.2038 13.5548 18.2644 13.3583L20.7801 5.19412Z" fill="#2790F9"/>
                  <path fill-rule="evenodd" clip-rule="evenodd" d="M22.3002 4.84434L19.5556 13.7547C19.4118 14.2275 19.1191 14.6419 18.7213 14.9357C18.3234 15.2296 17.8413 15.3876 17.3465 15.3864H8.09448C7.59174 15.3845 7.10242 15.2198 6.70136 14.917C6.3003 14.6141 6.00841 14.1894 5.86961 13.7066L2.39029 1.54556H0.773518C0.568449 1.54556 0.371729 1.4642 0.226647 1.31931C0.0815564 1.1744 0 0.977815 0 0.77278C0 0.567745 0.0815563 0.371158 0.226647 0.226253C0.371729 0.0813567 0.568449 0 0.773518 0H2.39227C2.72716 0.000902557 3.05328 0.110242 3.32071 0.311653C3.58815 0.513066 3.78301 0.795701 3.87602 1.11717L4.65643 3.84467H21.5613C21.6822 3.8448 21.8016 3.87322 21.9095 3.92768C22.0174 3.98214 22.1111 4.06113 22.1829 4.15832C22.2548 4.25551 22.3028 4.36819 22.3232 4.48731C22.3436 4.60644 22.3357 4.72881 22.3002 4.84434ZM22.1128 4.78662L19.368 13.6976L22.1128 4.78662ZM18.2642 13.3583L20.7799 5.19416H4.83869L7.16866 13.3401C7.22618 13.5409 7.34767 13.7176 7.51472 13.8433C7.68178 13.9691 7.8853 14.037 8.09448 14.0369H17.3441C17.55 14.0369 17.7504 13.9711 17.916 13.8489C18.0816 13.7268 18.2036 13.5548 18.2642 13.3583ZM9.24622 18.4583C9.24622 18.7633 9.15567 19.0614 8.98604 19.3149C8.81642 19.5685 8.57535 19.766 8.29335 19.8827C8.01136 19.9993 7.70107 20.0299 7.40173 19.9704C7.10238 19.9109 6.82737 19.7641 6.6115 19.5485C6.39563 19.3329 6.24859 19.0582 6.18902 18.7591C6.12944 18.46 6.16002 18.15 6.27687 17.8682C6.39372 17.5865 6.59158 17.3457 6.8454 17.1763C7.09921 17.007 7.39758 16.9166 7.70279 16.9166C8.11205 16.9166 8.50461 17.0789 8.79408 17.368C9.08355 17.6572 9.24622 18.0493 9.24622 18.4583ZM16.8543 17.1763C17.1082 17.007 17.4065 16.9166 17.7117 16.9166C18.121 16.9166 18.5136 17.0789 18.803 17.368C19.0925 17.6571 19.2552 18.0493 19.2552 18.4583C19.2552 18.7633 19.1646 19.0614 18.995 19.3149C18.8254 19.5685 18.5843 19.766 18.3023 19.8827C18.0203 19.9993 17.71 20.0299 17.4107 19.9704C17.1113 19.9109 16.8363 19.7641 16.6205 19.5485C16.4046 19.3329 16.2575 19.0582 16.198 18.7591C16.1384 18.46 16.169 18.15 16.2858 17.8682C16.4027 17.5865 16.6005 17.3457 16.8543 17.1763ZM8.82308 19.2059C8.97113 18.9846 9.05015 18.7244 9.05015 18.4583C9.05015 18.1014 8.90819 17.7591 8.65552 17.5068C8.40284 17.2544 8.06013 17.1126 7.70279 17.1126C7.43631 17.1126 7.17581 17.1916 6.95424 17.3394C6.73266 17.4873 6.55997 17.6974 6.45799 17.9433C6.35601 18.1892 6.32933 18.4598 6.38132 18.7208C6.43331 18.9818 6.56163 19.2216 6.75006 19.4098C6.93849 19.598 7.17857 19.7261 7.43993 19.7781C7.70129 19.83 7.9722 19.8033 8.2184 19.7015C8.4646 19.5996 8.67503 19.4272 8.82308 19.2059ZM16.9632 17.3394C17.1848 17.1916 17.4453 17.1126 17.7117 17.1126C18.0691 17.1126 18.4118 17.2544 18.6645 17.5068C18.9171 17.7591 19.0591 18.1014 19.0591 18.4583C19.0591 18.7244 18.9801 18.9846 18.832 19.2059C18.684 19.4272 18.4735 19.5996 18.2273 19.7015C17.9812 19.8033 17.7102 19.83 17.4489 19.7781C17.1875 19.7261 16.9474 19.598 16.759 19.4098C16.5706 19.2216 16.4423 18.9818 16.3903 18.7208C16.3383 18.4598 16.365 18.1892 16.4669 17.9433C16.5689 17.6974 16.7416 17.4873 16.9632 17.3394ZM4.50859 4.04075H21.5613H4.50859ZM21.5613 4.04075C21.6516 4.04084 21.7406 4.06207 21.8212 4.10273L21.5613 4.04075ZM21.8212 4.10273C21.9017 4.1434 21.9716 4.20236 22.0253 4.27489L21.8212 4.10273ZM22.0253 4.27489C22.0789 4.34742 22.1147 4.43149 22.1299 4.52036L22.0253 4.27489ZM22.1299 4.52036C22.1451 4.60923 22.1393 4.70043 22.1128 4.78662L22.1299 4.52036Z" fill="#2790F9"/>
                  </svg>
                  <span v-if='count_product_in_cart > 0' class='badge'>{{ count_product_in_cart }}</span>
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
                  <span class='badge'></span>
               </div>
            </div>

         </div>
         <div class='appbar-bottom'>
            <div class="gr-btn style01">
               <button @click='select_product_type(product.label)' v-for='(product, keyProduct) in searchType' :key='keyProduct' :class='product.active == true ? "active" : ""'>
                  {{ product.label }}
               </button>
            </div>
         </div>
      </div>

      <div class='store-wrapper'>

         <div id="mapContainer">

            <button @click='toggleMap' id='toggleMap'>
               <svg v-if='isToggle == false' width="16" height="20" viewBox="0 0 16 20" fill="none" xmlns="http://www.w3.org/2000/svg">
               <path fill-rule="evenodd" clip-rule="evenodd" d="M8 0C8.55228 0 9 0.447715 9 1L9 18.5C9 19.0523 8.55228 19.5 8 19.5C7.44772 19.5 7 19.0523 7 18.5L7 1C7 0.447715 7.44772 0 8 0Z" fill="#2790F9"/>
               <path fill-rule="evenodd" clip-rule="evenodd" d="M15.6247 10.5309C15.1934 10.8759 14.5641 10.806 14.2191 10.3747L7.99996 2.60078L1.78083 10.3747C1.43582 10.806 0.80653 10.8759 0.375268 10.5309C-0.055994 10.1859 -0.125916 9.55657 0.219094 9.12531L7.21909 0.375305C7.40887 0.13809 7.69618 0 7.99996 0C8.30375 0 8.59106 0.13809 8.78083 0.375305L15.7808 9.12531C16.1258 9.55657 16.0559 10.1859 15.6247 10.5309Z" fill="#2790F9"/>
               </svg>
               <svg v-if='isToggle == true' width="16" height="20" viewBox="0 0 16 20" fill="none" xmlns="http://www.w3.org/2000/svg">
               <path fill-rule="evenodd" clip-rule="evenodd" d="M8 20C7.44772 20 7 19.5523 7 19L7 1.5C7 0.947716 7.44772 0.5 8 0.5C8.55228 0.5 9 0.947716 9 1.5L9 19C9 19.5523 8.55228 20 8 20Z" fill="#2790F9"/>
               <path fill-rule="evenodd" clip-rule="evenodd" d="M0.375342 9.46913C0.806604 9.12412 1.4359 9.19404 1.78091 9.62531L8.00004 17.3992L14.2192 9.62531C14.5642 9.19404 15.1935 9.12412 15.6247 9.46913C16.056 9.81414 16.1259 10.4434 15.7809 10.8747L8.78091 19.6247C8.59113 19.8619 8.30382 20 8.00004 20C7.69625 20 7.40894 19.8619 7.21917 19.6247L0.219168 10.8747C-0.125842 10.4434 -0.0559202 9.81414 0.375342 9.46913Z" fill="#2790F9"/>
               </svg>
            </button>

         </div>
         <div class='store-list'>
            <div class='list-wrapping' :class='isToggle == true ? "isToggle" : ""'>

               <div class='column' 
                  v-for='(storeGroup, keyGroupStore) in group_the_stores' :key='keyGroupStore'>

                  <div 
                     @click='gotoStoreDetail(store.id)'
                     class='store-item' v-for='( store, keyStore ) in storeGroup'>

                     <div class='leading'>
                        <img src="<?php echo THEME_URI; ?>/assets/images/demo-store-nearby.png">
                     </div>
                     <div class='content'>
                        <div class='tt01'>{{ store.name }}</div>
                        <div class='tt02'>
                           <span class='store-distance'>{{ mathCeilDistance(store.distance) }} km</span>
                           <svg v-if='store.avg_rating > 0' width="15" height="14" viewBox="0 0 15 14" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M7.32901 11.7286L3.77618 13.8689C3.61922 13.9688 3.45514 14.0116 3.28391 13.9973C3.11269 13.9831 2.96287 13.926 2.83446 13.8261C2.70604 13.7262 2.60616 13.6012 2.53482 13.4511C2.46348 13.301 2.44921 13.1335 2.49202 12.9486L3.43373 8.9035L0.287545 6.18536C0.144861 6.05695 0.0558259 5.91055 0.0204402 5.74618C-0.0149455 5.58181 -0.00438691 5.42143 0.0521161 5.26505C0.10919 5.1081 0.1948 4.97968 0.308948 4.8798C0.423095 4.77992 0.580048 4.71571 0.779806 4.68718L4.93192 4.32333L6.53712 0.513664C6.60846 0.342443 6.71918 0.214026 6.86928 0.128416C7.01939 0.0428054 7.17263 0 7.32901 0C7.48597 0 7.63921 0.0428054 7.78874 0.128416C7.93827 0.214026 8.049 0.342443 8.12091 0.513664L9.72611 4.32333L13.8782 4.68718C14.078 4.71571 14.2349 4.77992 14.3491 4.8798C14.4632 4.97968 14.5488 5.1081 14.6059 5.26505C14.663 5.422 14.6738 5.58266 14.6384 5.74704C14.6031 5.91141 14.5137 6.05752 14.3705 6.18536L11.2243 8.9035L12.166 12.9486C12.2088 13.1341 12.1945 13.3019 12.1232 13.452C12.0519 13.6021 11.952 13.7268 11.8236 13.8261C11.6952 13.926 11.5453 13.9831 11.3741 13.9973C11.2029 14.0116 11.0388 13.9688 10.8819 13.8689L7.32901 11.7286Z" fill="#FFC83A"/></svg>
                           <span v-if='store.avg_rating > 0' class='store-rating'>{{ratingNumber(store.avg_rating)}}</span>
                        </div>
                     </div>

                  </div>

               </div>

            </div>
         </div>
      </div>


   </div>

   <div v-if='loading == true'>
      <div class='progress-center'>
         <div class='progress-container enabled'><progress class='progress-circular enabled' ></progress></div>
      </div>
   </div>

   <component-location-modal ref='component_location_modal'></component-location-modal>

   
</div>

<script src='<?php echo THEME_URI . '/pages/module/location_modal.js'; ?>'></script>

<script type='module'>

var { createApp } = Vue;

createApp({
   data (){
      return {
         loading: false,
         keyID: 'nJEYTwZNrpgfDSKEA4VzYO2R-NNL1grWFpf3y60aK1k',
         latitude: 10.780900239854994,
         longitude: 106.7226271387539,

         isToggle: false,

         map: null,

         stores: [],
         searchType: [
            {label: 'Water', value: 'water', active: true},
            {label: 'Ice', value: 'ice', active: false}
         ]
      }
   },
   computed: {
      get_stores(){
         return this.stores.filter(item => {
            
            if( item.store_type == 'both' ){
               console.log('item here ');
               return item.store_type == 'both';
            }else{
               var type = this.searchType.find(t => t.active == true);
               if(type){
                  return type.value == item.store_type;
               }else{
                  return item;
               }
            }

         }).sort((a, b) => a.distance - b.distance);

      },

      group_the_stores(){
         var _stores = [];
         for (let i = 0; i < this.get_stores.length; i += 3) {
            const group = this.get_stores.slice(i, i + 3);
            _stores.push(group);
         }
         return _stores;
      },

      count_product_in_cart(){ return window.count_product_in_cart()},

   },

   methods: {

      gotoCart(){ window.gotoCart()},
      gotoChat(){ window.gotoChat()},
      gotoStoreDetail(store_id){ window.gotoStoreDetail(store_id)},
      
      calculateDistance(lat1, lon1, lat2, lon2){ return window.calculateDistance(lat1, lon1, lat2, lon2);},
      ratingNumber(rating){ return parseFloat(rating).toFixed(1); },
      mathCeilDistance( distance ){ return parseFloat(distance).toFixed(1); },


      async get_all_store_location(){
         var form = new FormData();
         form.append('action', 'atlantis_get_store_location');
         form.append('lat', this.latitude);
         form.append('lng', this.longitude);

         var r = await window.request(form);
         if(r != undefined ){
            var res = JSON.parse( JSON.stringify( r));
            if( res.message == 'store_location_found' ){
               this.stores.push(...res.data);
               
            }
         }
      },


      select_product_type( type ){
         this.searchType.some( item => {
            if( item.label == type ){
               item.active = !item.active;
            }else{
               item.active = false;
            }
         });
         this.map.removeObjects(this.map.getObjects());
         this.fill_maker_to_map();

      },

      marker_store(store_name, rating, location){

         // Create the outer div element with class 'location'
         var locationDiv = document.createElement('div');
         locationDiv.classList.add('marker-store');

         // Create the store span element
         var storeSpan = document.createElement('span');
         storeSpan.classList.add('store');
         storeSpan.textContent = store_name;

         // Create the SVG element
         var svgElement = document.createElementNS('http://www.w3.org/2000/svg', 'svg');
         svgElement.setAttribute('width', '13');
         svgElement.setAttribute('height', '12');
         svgElement.setAttribute('viewBox', '0 0 13 12');
         svgElement.setAttribute('fill', 'none');

         // Create the path element within the SVG element
         var pathElement = document.createElementNS('http://www.w3.org/2000/svg', 'path');
         pathElement.setAttribute('d', 'M6.28201 10.0531L3.23672 11.8876C3.10219 11.9732 2.96154 12.0099 2.81478 11.9977C2.66802 11.9855 2.53961 11.9366 2.42954 11.8509C2.31947 11.7653 2.23386 11.6582 2.1727 11.5295C2.11155 11.4009 2.09932 11.2573 2.13601 11.0988L2.9432 7.63157L0.246467 5.30174C0.124166 5.19167 0.0478508 5.06619 0.0175202 4.9253C-0.0128104 4.78441 -0.00376021 4.64694 0.0446709 4.5129C0.0935912 4.37837 0.166972 4.2683 0.264812 4.18269C0.362653 4.09708 0.497184 4.04204 0.668405 4.01758L4.22736 3.70571L5.60324 0.440283C5.66439 0.293522 5.7593 0.183451 5.88796 0.110071C6.01662 0.0366903 6.14797 0 6.28201 0C6.41654 0 6.54789 0.0366903 6.67606 0.110071C6.80424 0.183451 6.89914 0.293522 6.96078 0.440283L8.33667 3.70571L11.8956 4.01758C12.0668 4.04204 12.2014 4.09708 12.2992 4.18269C12.3971 4.2683 12.4704 4.37837 12.5194 4.5129C12.5683 4.64743 12.5776 4.78514 12.5472 4.92603C12.5169 5.06692 12.4403 5.19216 12.3176 5.30174L9.62082 7.63157L10.428 11.0988C10.4647 11.2578 10.4525 11.4016 10.3913 11.5303C10.3302 11.6589 10.2446 11.7658 10.1345 11.8509C10.0244 11.9366 9.896 11.9855 9.74924 11.9977C9.60248 12.0099 9.46183 11.9732 9.3273 11.8876L6.28201 10.0531Z');
         pathElement.setAttribute('fill', '#FFC83A');

         // Append the path element to the SVG element
         svgElement.appendChild(pathElement);

         // Create the rating span element
         var ratingSpan = document.createElement('span');
         ratingSpan.classList.add('rating');
         ratingSpan.textContent = rating;

         // Append the child elements to the locationDiv
         locationDiv.appendChild(storeSpan);
         if( rating > 0 && rating != null ){
            locationDiv.appendChild(svgElement);
            locationDiv.appendChild(ratingSpan);
         }

         var icon = new H.map.DomIcon(locationDiv, {
            // the function is called every time marker enters the viewport
            onAttach: function(clonedElement, domIcon, domMarker) {
               clonedElement.addEventListener('mouseover', this.onTouch);
               clonedElement.addEventListener('mouseout', this.onLeave);
            },
            // the function is called every time marker leaves the viewport
            onDetach: function(clonedElement, domIcon, domMarker) {
               clonedElement.removeEventListener('mouseover', this.onTouch);
               clonedElement.removeEventListener('mouseout', this.onLeave);
            }
         });

         return new H.map.DomMarker({ lat: location.lat, lng: location.lng }, {icon: icon, volatility: true });
      },

      onTouch(e){
         // evt.target.style.opacity
         console.log('ON TOUCH EVENT');
         console.log(e);
      },

      onLeave(e){
         console.log('ON LEAVE EVENT');
         console.log(e);
      },

      toggleMap(){

         this.isToggle = !this.isToggle;

         var appbar = document.getElementsByClassName('appbar');
         var appbarHeight = 0.0;
         var storeWrapper = document.getElementsByClassName('store-wrapper');
         var storeList = document.getElementsByClassName('store-list');
         var mapContainer = document.getElementById('mapContainer');

         if( appbar != undefined ){
            appbarHeight = appbar[0].clientHeight;
         }
         var _heightWrapper = window.innerHeight - appbarHeight;
         storeWrapper[0].style.height = _heightWrapper + 'px';

         var _body = _heightWrapper * 0.8;
         var _footer = _heightWrapper * 0.2;

         if( this.isToggle == true ){
            _body = ( _heightWrapper - 15.0) * 0.5;
            _footer = _heightWrapper * 0.5;
         }else{
            _body = ( _heightWrapper - 15.0) * 0.8;
            _footer = _heightWrapper * 0.2;
         }

         mapContainer.style.height = _body + 'px';
         storeList[0].style.height = _footer + 'px';

         this.map.getViewPort().resize();

      },

      fill_maker_to_map(){
         if( this.get_stores.length > 0 ){
         
            this.get_stores.forEach((item ) => {
               var _latitude = parseFloat(item.latitude);
               var _longitude = parseFloat(item.longitude);

               var _rating = item.avg_rating != null ? this.ratingNumber( item.avg_rating) : 0;
               item.id_maker = this.map.addObject(this.marker_store( 
                  item.name, _rating, 
                  { lat: _latitude, lng: _longitude }
               )).getId();

            });

            this.map.setZoom(14);
         }
      },

      get_location_store(lat, lng){
         this.map.setCenter({
            lat: lat, lng: lng
         });
         this.map.setZoom(16);
      },

   },

   created(){
      
   },

   async mounted(){
      
      this.get_current_location_per_second();
      await this.get_all_store_location();

      var appbar = document.getElementsByClassName('appbar');
      var appbarHeight = 0.0;
      var storeWrapper = document.getElementsByClassName('store-wrapper');
      var storeList = document.getElementsByClassName('store-list');
      var mapContainer = document.getElementById('mapContainer');

      if( appbar != undefined ){
         appbarHeight = appbar[0].clientHeight;
      }
      var _heightWrapper = window.innerHeight - appbarHeight;
      var _body = _heightWrapper * 0.8;
      var _footer = _heightWrapper * 0.2;
      storeWrapper[0].style.height = _heightWrapper + 'px';
      mapContainer.style.height = _body + 'px';
      storeList[0].style.height = _footer + 'px';
     
      var platform = new H.service.Platform({
         apikey: this.keyID
      });
      var defaultLayers = platform.createDefaultLayers();

      var map = new H.Map(document.getElementById('mapContainer'),
         defaultLayers.vector.normal.map,
         {
            center: {lat: this.latitude, lng: this.longitude},
            zoom: 16,
            pixelRatio: window.devicePixelRatio || 1
         }
      );

      window.addEventListener('resize', () => map.getViewPort().resize());
      var behavior = new H.mapevents.Behavior(new H.mapevents.MapEvents(map));
      // var ui = H.ui.UI.createDefault(map, defaultLayers);

      if( this.get_stores.length > 0 ){
         
         this.get_stores.forEach((item ) => {
            var _latitude = parseFloat(item.latitude);
            var _longitude = parseFloat(item.longitude);

            var _rating = item.avg_rating != null ? this.ratingNumber( item.avg_rating) : 0;
            item.id_maker = map.addObject(this.marker_store( 
               item.name, _rating, 
               { lat: _latitude, lng: _longitude }
            )).getId();

         });

         map.setZoom(16);
      }

      this.map = map;

   }

})
.component('component-location-modal', LocationModal)
.mount('#app');
</script>