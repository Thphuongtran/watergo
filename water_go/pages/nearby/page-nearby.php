<script src='<?php echo THEME_URI . '/pages/module/module_get_order_delivering.js?ver=3.0'; ?>'></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.8.1/slick.min.js" integrity="sha512-XtmMtDEcNz2j7ekrtHvOVR4iwwaD6o/FUJe6+Zq+HgcCsk3kj4uSQQR8weQ2QVj1o0Pk6PwYLohm206ZzNfubg==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.8.1/slick.min.css" integrity="sha512-yHknP1/AwR+yx26cB1y0cjvQUMvEa2PFzt1c9LlS4pRQ5NOTZFWbhBig+X9G9eYW/8m0/4OXNx8pxJ6z57x0dw==" crossorigin="anonymous" referrerpolicy="no-referrer" />
<link rel="stylesheet" href="<?php echo THEME_URI ?>/assets/css/owl.carousel.min.css"/>
<link rel="stylesheet" href="<?php echo THEME_URI ?>/assets/css/owl.theme.default.min.css"/>
<style type="text/css">
   #mapContainer *{outline: 0 !important}
   .store-list{height: 110px;padding: 15px;}
   .store-item{text-decoration: none;color: #252831}
   .store-list.showed{height: 300px}
   #toggleMap.active svg{transform: rotate(180deg);}
   .back_to_mylocation{position: absolute;top: -58px;right: 55px;border:none;background: transparent;outline: 0;height: 60px;}
   .marker-store{padding: 1px 12px 0;outline: 0 !important;}
   .marker-store .rate{color: #8F8F8F; font-size: 12px;}
   .marker-store svg{top: 0}
   .list-wrapping .store-item,.item._col-3{width: 80vw}
   .item._col-3{display: flex; flex-direction: column; row-gap: 10px;}
   .item._col-3 .store-item{width: 100%}
   .gmnoprint,[rel="noopener"]{display: none !important;}
   .dot-icon{border: 2px solid #FFFFFF;width: 18px;height: 18px;border-radius: 100%;background-color: #2790F9;display: inline-block;box-shadow: 0px 4px 4px 0px rgba(0, 0, 0, 0.25);}
</style>
<div id='app'>

   <div class="progress-wp">
      <div class='progress-center'>
         <div class='progress-container enabled'><progress class='progress-circular enabled' ></progress></div>
      </div>
   </div>

   <div class='page-nearby'>

      <div class='appbar'>
         <div class='appbar-top'>
            <span class='leading-title'><?php echo __('Map', 'watergo'); ?></span>
            <div class='action'>
               <a href="/cart/?appt=N" class='btn-badge'>
                  <svg width="23" height="20" viewBox="0 0 23 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                  <path d="M9.05036 18.4583C9.05036 18.7244 8.97134 18.9846 8.82329 19.2058C8.67524 19.4271 8.46481 19.5996 8.21861 19.7015C7.97241 19.8033 7.7015 19.83 7.44014 19.778C7.17878 19.7261 6.9387 19.5979 6.75027 19.4098C6.56184 19.2216 6.43352 18.9818 6.38153 18.7208C6.32954 18.4597 6.35622 18.1892 6.4582 17.9433C6.56018 17.6974 6.73288 17.4873 6.95445 17.3394C7.17602 17.1915 7.43652 17.1126 7.703 17.1126C8.06034 17.1126 8.40305 17.2544 8.65573 17.5067C8.9084 17.7591 9.05036 18.1014 9.05036 18.4583ZM17.7119 17.1126C17.4455 17.1126 17.185 17.1915 16.9634 17.3394C16.7418 17.4873 16.5691 17.6974 16.4672 17.9433C16.3652 18.1892 16.3385 18.4597 16.3905 18.7208C16.4425 18.9818 16.5708 19.2216 16.7592 19.4098C16.9477 19.5979 17.1877 19.7261 17.4491 19.778C17.7105 19.83 17.9814 19.8033 18.2276 19.7015C18.4738 19.5996 18.6842 19.4271 18.8322 19.2058C18.9803 18.9846 19.0593 18.7244 19.0593 18.4583C19.0593 18.1014 18.9174 17.7591 18.6647 17.5067C18.412 17.2544 18.0693 17.1126 17.7119 17.1126ZM22.113 4.78659L19.3682 13.6976C19.2367 14.1303 18.9691 14.5091 18.605 14.778C18.241 15.0468 17.8 15.1914 17.3472 15.1903H8.0947C7.63433 15.1886 7.18695 15.0378 6.81974 14.7604C6.45253 14.4831 6.18533 14.0943 6.05826 13.6524L2.57823 1.48882C2.56669 1.44855 2.54231 1.41315 2.50878 1.38799C2.47525 1.36283 2.43442 1.3493 2.39248 1.34945H0.773728C0.620582 1.34945 0.473708 1.28869 0.365417 1.18054C0.257126 1.07238 0.196289 0.925697 0.196289 0.772746C0.196289 0.619796 0.257126 0.473109 0.365417 0.364957C0.473708 0.256804 0.620582 0.196045 0.773728 0.196045H2.39248C2.68501 0.196833 2.9694 0.292344 3.20296 0.468247C3.43652 0.64415 3.60667 0.890957 3.68787 1.17163L4.5088 4.04072H21.5615C21.6518 4.04081 21.7408 4.06204 21.8214 4.1027C21.902 4.14336 21.9719 4.20232 22.0255 4.27485C22.0791 4.34738 22.115 4.43146 22.1302 4.52033C22.1454 4.6092 22.1395 4.70039 22.113 4.78659ZM20.7801 5.19412H4.8389L7.16887 13.34C7.22639 13.5409 7.34788 13.7176 7.51493 13.8433C7.68199 13.969 7.88551 14.037 8.0947 14.0369H17.3443C17.5502 14.0369 17.7506 13.971 17.9162 13.8489C18.0818 13.7268 18.2038 13.5548 18.2644 13.3583L20.7801 5.19412Z" fill="#2790F9"/>
                  <path fill-rule="evenodd" clip-rule="evenodd" d="M22.3002 4.84434L19.5556 13.7547C19.4118 14.2275 19.1191 14.6419 18.7213 14.9357C18.3234 15.2296 17.8413 15.3876 17.3465 15.3864H8.09448C7.59174 15.3845 7.10242 15.2198 6.70136 14.917C6.3003 14.6141 6.00841 14.1894 5.86961 13.7066L2.39029 1.54556H0.773518C0.568449 1.54556 0.371729 1.4642 0.226647 1.31931C0.0815564 1.1744 0 0.977815 0 0.77278C0 0.567745 0.0815563 0.371158 0.226647 0.226253C0.371729 0.0813567 0.568449 0 0.773518 0H2.39227C2.72716 0.000902557 3.05328 0.110242 3.32071 0.311653C3.58815 0.513066 3.78301 0.795701 3.87602 1.11717L4.65643 3.84467H21.5613C21.6822 3.8448 21.8016 3.87322 21.9095 3.92768C22.0174 3.98214 22.1111 4.06113 22.1829 4.15832C22.2548 4.25551 22.3028 4.36819 22.3232 4.48731C22.3436 4.60644 22.3357 4.72881 22.3002 4.84434ZM22.1128 4.78662L19.368 13.6976L22.1128 4.78662ZM18.2642 13.3583L20.7799 5.19416H4.83869L7.16866 13.3401C7.22618 13.5409 7.34767 13.7176 7.51472 13.8433C7.68178 13.9691 7.8853 14.037 8.09448 14.0369H17.3441C17.55 14.0369 17.7504 13.9711 17.916 13.8489C18.0816 13.7268 18.2036 13.5548 18.2642 13.3583ZM9.24622 18.4583C9.24622 18.7633 9.15567 19.0614 8.98604 19.3149C8.81642 19.5685 8.57535 19.766 8.29335 19.8827C8.01136 19.9993 7.70107 20.0299 7.40173 19.9704C7.10238 19.9109 6.82737 19.7641 6.6115 19.5485C6.39563 19.3329 6.24859 19.0582 6.18902 18.7591C6.12944 18.46 6.16002 18.15 6.27687 17.8682C6.39372 17.5865 6.59158 17.3457 6.8454 17.1763C7.09921 17.007 7.39758 16.9166 7.70279 16.9166C8.11205 16.9166 8.50461 17.0789 8.79408 17.368C9.08355 17.6572 9.24622 18.0493 9.24622 18.4583ZM16.8543 17.1763C17.1082 17.007 17.4065 16.9166 17.7117 16.9166C18.121 16.9166 18.5136 17.0789 18.803 17.368C19.0925 17.6571 19.2552 18.0493 19.2552 18.4583C19.2552 18.7633 19.1646 19.0614 18.995 19.3149C18.8254 19.5685 18.5843 19.766 18.3023 19.8827C18.0203 19.9993 17.71 20.0299 17.4107 19.9704C17.1113 19.9109 16.8363 19.7641 16.6205 19.5485C16.4046 19.3329 16.2575 19.0582 16.198 18.7591C16.1384 18.46 16.169 18.15 16.2858 17.8682C16.4027 17.5865 16.6005 17.3457 16.8543 17.1763ZM8.82308 19.2059C8.97113 18.9846 9.05015 18.7244 9.05015 18.4583C9.05015 18.1014 8.90819 17.7591 8.65552 17.5068C8.40284 17.2544 8.06013 17.1126 7.70279 17.1126C7.43631 17.1126 7.17581 17.1916 6.95424 17.3394C6.73266 17.4873 6.55997 17.6974 6.45799 17.9433C6.35601 18.1892 6.32933 18.4598 6.38132 18.7208C6.43331 18.9818 6.56163 19.2216 6.75006 19.4098C6.93849 19.598 7.17857 19.7261 7.43993 19.7781C7.70129 19.83 7.9722 19.8033 8.2184 19.7015C8.4646 19.5996 8.67503 19.4272 8.82308 19.2059ZM16.9632 17.3394C17.1848 17.1916 17.4453 17.1126 17.7117 17.1126C18.0691 17.1126 18.4118 17.2544 18.6645 17.5068C18.9171 17.7591 19.0591 18.1014 19.0591 18.4583C19.0591 18.7244 18.9801 18.9846 18.832 19.2059C18.684 19.4272 18.4735 19.5996 18.2273 19.7015C17.9812 19.8033 17.7102 19.83 17.4489 19.7781C17.1875 19.7261 16.9474 19.598 16.759 19.4098C16.5706 19.2216 16.4423 18.9818 16.3903 18.7208C16.3383 18.4598 16.365 18.1892 16.4669 17.9433C16.5689 17.6974 16.7416 17.4873 16.9632 17.3394ZM4.50859 4.04075H21.5613H4.50859ZM21.5613 4.04075C21.6516 4.04084 21.7406 4.06207 21.8212 4.10273L21.5613 4.04075ZM21.8212 4.10273C21.9017 4.1434 21.9716 4.20236 22.0253 4.27489L21.8212 4.10273ZM22.0253 4.27489C22.0789 4.34742 22.1147 4.43149 22.1299 4.52036L22.0253 4.27489ZM22.1299 4.52036C22.1451 4.60923 22.1393 4.70043 22.1128 4.78662L22.1299 4.52036Z" fill="#2790F9"/>
                  </svg>
                  <span class='badge count-cart'></span>
               </a>
               <a href='/chat/?chat_page=chat-index&appt=N' class='btn-badge ml10'>
                  <svg width="23" height="20" viewBox="0 0 23 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                  <path fill-rule="evenodd" clip-rule="evenodd" d="M15.6817 0H3.40384C2.58977 0 1.80904 0.334446 1.2334 0.929764C0.657759 1.52508 0.33437 2.33251 0.33437 3.17441V9.52324C0.33437 9.94011 0.413763 10.3529 0.568018 10.738C0.722275 11.1232 0.94837 11.4731 1.2334 11.7679C1.51842 12.0627 1.8568 12.2965 2.22921 12.456C2.60161 12.6155 3.00076 12.6977 3.40384 12.6977H5.24553H9.79695H15.6817C16.4958 12.6977 17.2766 12.3632 17.8522 11.7679C18.4278 11.1726 18.7512 10.3652 18.7512 9.52324V3.17441C18.7512 2.33251 18.4278 1.52508 17.8522 0.929764C17.2766 0.334446 16.4958 0 15.6817 0ZM15.6817 1.26977H3.40384C2.9154 1.26977 2.44696 1.47043 2.10158 1.82762C1.75619 2.18482 1.56216 2.66927 1.56216 3.17441V9.52324C1.56216 10.0284 1.75619 10.5128 2.10158 10.87C2.44696 11.2272 2.9154 11.4279 3.40384 11.4279H15.6817C16.1702 11.4279 16.6386 11.2272 16.984 10.87C17.3294 10.5128 17.5234 10.0284 17.5234 9.52324V3.17441C17.5234 2.66927 17.3294 2.18482 16.984 1.82762C16.6386 1.47043 16.1702 1.26977 15.6817 1.26977Z" fill="#2790F9"/>
                  <path d="M3.40384 1.26977H15.6817C16.1702 1.26977 16.6386 1.47043 16.984 1.82762C17.3294 2.18482 17.5234 2.66927 17.5234 3.17441V9.52324C17.5234 10.0284 17.3294 10.5128 16.984 10.87C16.6386 11.2272 16.1702 11.4279 15.6817 11.4279H3.40384C2.9154 11.4279 2.44696 11.2272 2.10158 10.87C1.75619 10.5128 1.56216 10.0284 1.56216 9.52324V3.17441C1.56216 2.66927 1.75619 2.18482 2.10158 1.82762C2.44696 1.47043 2.9154 1.26977 3.40384 1.26977Z" fill="white"/>
                  <path fill-rule="evenodd" clip-rule="evenodd" d="M19.0577 4.76171H6.7798C6.29136 4.76171 5.82292 4.96238 5.47753 5.31957C5.13215 5.67676 4.93812 6.16121 4.93812 6.66636V13.0152C4.93812 13.5203 5.13215 14.0048 5.47753 14.362C5.82292 14.7192 6.29136 14.9198 6.7798 14.9198H12.9188C12.9994 14.9197 13.0793 14.936 13.1539 14.9678C13.2285 14.9996 13.2963 15.0463 13.3534 15.1052L15.9882 17.8314V15.5547C15.9882 15.3863 16.0529 15.2249 16.168 15.1058C16.2832 14.9867 16.4393 14.9198 16.6021 14.9198H19.0577C19.5461 14.9198 20.0146 14.7192 20.36 14.362C20.7054 14.0048 20.8994 13.5203 20.8994 13.0152V6.66636C20.8994 6.16121 20.7054 5.67676 20.36 5.31957C20.0146 4.96238 19.5461 4.76171 19.0577 4.76171ZM6.7798 3.49194H19.0577C19.8718 3.49194 20.6525 3.82639 21.2282 4.42171C21.8038 5.01703 22.1272 5.82445 22.1272 6.66636V13.0152C22.1272 13.4321 22.0478 13.8448 21.8935 14.23C21.7393 14.6151 21.5132 14.9651 21.2282 15.2598C20.9431 15.5546 20.6047 15.7884 20.2323 15.948C19.8599 16.1075 19.4608 16.1896 19.0577 16.1896H17.216V19.364C17.2162 19.4897 17.1804 19.6127 17.1129 19.7173C17.0455 19.8219 16.9495 19.9035 16.8372 19.9516C16.7249 19.9998 16.6013 20.0124 16.4821 19.9878C16.3628 19.9632 16.2533 19.9025 16.1675 19.8135L12.6646 16.1896H6.7798C5.96573 16.1896 5.18499 15.8552 4.60936 15.2598C4.03372 14.6645 3.71033 13.8571 3.71033 13.0152V6.66636C3.71033 5.82445 4.03372 5.01703 4.60936 4.42171C5.18499 3.82639 5.96573 3.49194 6.7798 3.49194Z" fill="#2790F9"/>
                  <path d="M19.0577 4.76171H6.7798C6.29136 4.76171 5.82292 4.96238 5.47753 5.31957C5.13215 5.67676 4.93812 6.16121 4.93812 6.66636V13.0152C4.93812 13.5203 5.13215 14.0048 5.47753 14.362C5.82292 14.7192 6.29136 14.9198 6.7798 14.9198H12.9188C12.9994 14.9197 13.0793 14.936 13.1539 14.9678C13.2285 14.9996 13.2963 15.0463 13.3534 15.1052L15.9882 17.8314V15.5547C15.9882 15.3863 16.0529 15.2249 16.168 15.1058C16.2832 14.9867 16.4393 14.9198 16.6021 14.9198H19.0577C19.5461 14.9198 20.0146 14.7192 20.36 14.362C20.7054 14.0048 20.8994 13.5203 20.8994 13.0152V6.66636C20.8994 6.16121 20.7054 5.67676 20.36 5.31957C20.0146 4.96238 19.5461 4.76171 19.0577 4.76171Z" fill="white"/>
                  <path d="M10.4639 9.32355C10.4639 9.705 10.1546 10.0142 9.77319 10.0142C9.39174 10.0142 9.08252 9.705 9.08252 9.32355C9.08252 8.9421 9.39174 8.63288 9.77319 8.63288C10.1546 8.63288 10.4639 8.9421 10.4639 9.32355Z" fill="#2790F9"/>
                  <path d="M13.5947 9.3098C13.5947 9.69124 13.2855 10.0005 12.904 10.0005C12.5226 10.0005 12.2133 9.69124 12.2133 9.3098C12.2133 8.92835 12.5226 8.61912 12.904 8.61912C13.2855 8.61912 13.5947 8.92835 13.5947 9.3098Z" fill="#2790F9"/>
                  <path d="M16.7027 9.32356C16.7027 9.70501 16.3935 10.0142 16.012 10.0142C15.6306 10.0142 15.3214 9.70501 15.3214 9.32356C15.3214 8.94211 15.6306 8.63288 16.012 8.63288C16.3935 8.63288 16.7027 8.94211 16.7027 9.32356Z" fill="#2790F9"/>
                  </svg>
                  
                  <span class='badge-messages badge'>0</span>
               </a>

            </div>


         </div>
         <div class='appbar-bottom pb15'>
            <div class="gr-btn style01">
               <button class="active filter-button" data-type='water'><?php echo __('Water', 'watergo'); ?></button>
               <button class="filter-button" data-type="ice"><?php echo __('Ice', 'watergo'); ?></button>
            </div>
         </div>
      </div>

      <div class='store-wrapper' style="flex-direction: column; height: calc(100vh - 111px);">
         
         <div id="mapContainer"></div>
         
         <div class='store-list' style="position:relative;transition: all 0.3s;">
            <button class="back_to_mylocation" style="border-radius: 100%;outline: 0;background-color: transparent !important;">
               <svg width="60" height="60" viewBox="0 0 60 60" fill="none" xmlns="http://www.w3.org/2000/svg">
               <g filter="url(#filter0_d_2594_1758)">
               <circle cx="31" cy="29" r="21" fill="white"/>
               </g>
               <path d="M31.0001 24.9577C28.7665 24.9577 26.9573 26.7668 26.9573 29.0005C26.9573 31.2341 28.7665 33.0432 31.0001 33.0432C33.2337 33.0432 35.0429 31.2341 35.0429 29.0005C35.0429 26.7668 33.2337 24.9577 31.0001 24.9577ZM40.0357 27.9898C39.8068 25.9402 38.8877 24.0294 37.4294 22.5711C35.9712 21.1128 34.0604 20.1938 32.0108 19.9648V17.8828H29.9894V19.9648C27.9398 20.1938 26.029 21.1128 24.5708 22.5711C23.1125 24.0294 22.1934 25.9402 21.9645 27.9898H19.8824V30.0112H21.9645C22.1934 32.0607 23.1125 33.9715 24.5708 35.4298C26.029 36.8881 27.9398 37.8071 29.9894 38.0361V40.1181H32.0108V38.0361C34.0604 37.8071 35.9712 36.8881 37.4294 35.4298C38.8877 33.9715 39.8068 32.0607 40.0357 30.0112H42.1177V27.9898H40.0357ZM31.0001 36.0753C27.0887 36.0753 23.9252 32.9118 23.9252 29.0005C23.9252 25.0891 27.0887 21.9256 31.0001 21.9256C34.9115 21.9256 38.075 25.0891 38.075 29.0005C38.075 32.9118 34.9115 36.0753 31.0001 36.0753Z" fill="#3B4249"/>
               <defs>
               <filter id="filter0_d_2594_1758" x="0" y="0" width="62" height="62" filterUnits="userSpaceOnUse" color-interpolation-filters="sRGB">
               <feFlood flood-opacity="0" result="BackgroundImageFix"/>
               <feColorMatrix in="SourceAlpha" type="matrix" values="0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 127 0" result="hardAlpha"/>
               <feOffset dy="2"/>
               <feGaussianBlur stdDeviation="5"/>
               <feComposite in2="hardAlpha" operator="out"/>
               <feColorMatrix type="matrix" values="0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0.12 0"/>
               <feBlend mode="normal" in2="BackgroundImageFix" result="effect1_dropShadow_2594_1758"/>
               <feBlend mode="normal" in="SourceGraphic" in2="effect1_dropShadow_2594_1758" result="shape"/>
               </filter>
               </defs>
               </svg>
            </button>
            <button id='toggleMap' style="bottom: inherit; top: -50px;outline: 0 !important;box-shadow:none !important;">
               <svg  width="16" height="20" viewBox="0 0 16 20" fill="none" xmlns="http://www.w3.org/2000/svg">
               <path fill-rule="evenodd" clip-rule="evenodd" d="M8 0C8.55228 0 9 0.447715 9 1L9 18.5C9 19.0523 8.55228 19.5 8 19.5C7.44772 19.5 7 19.0523 7 18.5L7 1C7 0.447715 7.44772 0 8 0Z" fill="#2790F9"/>
               <path fill-rule="evenodd" clip-rule="evenodd" d="M15.6247 10.5309C15.1934 10.8759 14.5641 10.806 14.2191 10.3747L7.99996 2.60078L1.78083 10.3747C1.43582 10.806 0.80653 10.8759 0.375268 10.5309C-0.055994 10.1859 -0.125916 9.55657 0.219094 9.12531L7.21909 0.375305C7.40887 0.13809 7.69618 0 7.99996 0C8.30375 0 8.59106 0.13809 8.78083 0.375305L15.7808 9.12531C16.1258 9.55657 16.0559 10.1859 15.6247 10.5309Z" fill="#2790F9"/>
               </svg>
            </button>
            <div class='list-wrapping'>
               <div class="owl-carousel owl-theme list-store-carousel"></div>
            </div>
         </div>


      </div>


   </div>
   
</div>
<div class='modal-popup open access-location-modal d-none'>
   <div class='modal-wrapper'>
      <div class='modal-close'><div class='close-button'><span></span><span></span></div></div>
      <p class='heading pt20'><?php echo __('Location information is not available', 'watergo'); ?></p>
      <p><?php echo __('Please share your location for a better experience on Watergo', 'watergo'); ?></p>
      <button onclick="window.appBridge.openAppSetting()" class='btn btn-primary mt20'><?php echo __('Allow Access', 'watergo'); ?></button>
   </div>
</div>
<div id='app-nearby'>
   <module_get_order_delivering ref='module_get_order_delivering'></module_get_order_delivering>
</div>

<script>
var app = Vue.createApp({
   data (){
      return {
         get_locale: '<?php echo get_locale(); ?>',
      }
   }
})
.component('module_get_order_delivering', module_get_order_delivering)
.mount('#app-nearby');
window.app = app;
</script>

<script src="<?php echo THEME_URI."/assets/js/owl.carousel.min.js?" ?>"></script>

<!-- <script src="https://maps.googleapis.com/maps/api/js?key=&callback=initMap&libraries=marker&v=beta"  async defer ></script> -->
<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBrhkRyBm3jXLkcMmVvd_GNhINb03VSVfI&callback=initMap&libraries=marker&v=beta"  async defer ></script>
<script type="text/javascript">
   // Nhập key to continue
   var icon = `<svg width="13" height="12" viewBox="0 0 13 12" fill="none" xmlns="http://www.w3.org/2000/svg">
<path d="M6.28201 10.0531L3.23672 11.8876C3.10219 11.9732 2.96154 12.0099 2.81478 11.9977C2.66802 11.9855 2.53961 11.9366 2.42954 11.8509C2.31947 11.7653 2.23386 11.6582 2.1727 11.5295C2.11155 11.4009 2.09932 11.2573 2.13601 11.0988L2.9432 7.63157L0.246467 5.30174C0.124166 5.19167 0.0478508 5.06619 0.0175202 4.9253C-0.0128104 4.78441 -0.00376021 4.64694 0.0446709 4.5129C0.0935912 4.37837 0.166972 4.2683 0.264812 4.18269C0.362653 4.09708 0.497184 4.04204 0.668405 4.01758L4.22736 3.70571L5.60324 0.440283C5.66439 0.293522 5.7593 0.183451 5.88796 0.110071C6.01662 0.0366903 6.14797 0 6.28201 0C6.41654 0 6.54789 0.0366903 6.67606 0.110071C6.80424 0.183451 6.89914 0.293522 6.96078 0.440283L8.33667 3.70571L11.8956 4.01758C12.0668 4.04204 12.2014 4.09708 12.2992 4.18269C12.3971 4.2683 12.4704 4.37837 12.5194 4.5129C12.5683 4.64743 12.5776 4.78514 12.5472 4.92603C12.5169 5.06692 12.4403 5.19216 12.3176 5.30174L9.62082 7.63157L10.428 11.0988C10.4647 11.2578 10.4525 11.4016 10.3913 11.5303C10.3302 11.6589 10.2446 11.7658 10.1345 11.8509C10.0244 11.9366 9.896 11.9855 9.74924 11.9977C9.60248 12.0099 9.46183 11.9732 9.3273 11.8876L6.28201 10.0531Z" fill="#FFC83A"/>
</svg>`;
   var map;
   var lat = 10.7809029;
   var lng = 106.7243988;
   var current_center = center = {
        lat: lat , 
        lng: lng 
    };
   var data_json, data_water,data_ice;
   var type = "water";
   // function initMap_() {           
   //    map = new google.maps.Map(document.getElementById("mapContainer"), {
   //        zoom: 17,
   //        center,
   //        mapId: "4504f8b37365c3d0",
   //        mapTypeControl: false,
   //        fullscreenControl: false,
   //        streetViewControl: false,
   //        zoomControl: false
   //    });
       
   //     var my_local_icon = new google.maps.marker.AdvancedMarkerView({
   //             map,
   //             content: build_icon(),
   //             position: {
   //                lat: lat,
   //                lng: lng,
   //            }
   //         });
 
   // }// end initMap

   async function initMap() {
     const { Map } = await google.maps.importLibrary("maps");

     map = new google.maps.Map(document.getElementById("mapContainer"), {
          zoom: 17,
          center,
          mapId: "4504f8b37365c3d0",
          mapTypeControl: false,
          fullscreenControl: false,
          streetViewControl: false,
          zoomControl: false
      });
       
       var my_local_icon = new google.maps.marker.AdvancedMarkerView({
               map,
               content: build_icon(),
               position: {
                  lat: lat,
                  lng: lng,
              }
           });
   }

   //initMap();
   if( window.appBridge !== undefined ){
      window.appBridge.getLocation().then( (data) => {
         if (Object.keys(data).length === 0) {
            $(".progress-wp").addClass("d-none");
            $(".access-location-modal").removeClass("d-none");
         }else{
            //alert(JSON.stringify(data));
            lat = data.lat;
            lng = data.lng;
            center = {
               lat: Number(lat) , 
               lng: Number(lng)  
            }
           //initMap()
            load_store_to_map(center)
            .then(data => {
               data_water = filter_data();
               data_ice = filter_data("ice");
               setTimeout(function() {
                  add_item(data_water);
                  jQuery(".progress-wp").addClass("d-none")
               }, 1000);
               jQuery(".access-location-modal").addClass("d-none")
            })
            .catch(error => {
             console.error("AJAX request failed:", error);
            }
         );
         }
      }).catch((e) => { 
         lat = window.appBridge.getLatitude();
         lng = window.appBridge.getLongitude();
         
         if ( lat == 'undefined' || lng == "undefined") {
            jQuery(".progress-wp").addClass("d-none");
            jQuery(".access-location-modal").removeClass("d-none");
         }else{
            load_store_to_map(center)
            .then(data => {
               data_water = filter_data();
               data_ice = filter_data("ice");
               setTimeout(function() {
                  add_item(data_water);
                  jQuery(".progress-wp").addClass("d-none")
               }, 1000);
               jQuery(".access-location-modal").addClass("d-none")
            })
            .catch(error => {
             console.error("AJAX request failed:", error);
            }
         );
         }
         
      })
   }else{
      //initMap()
      load_store_to_map(current_center)
         .then(data => {
            data_water = filter_data();
            data_ice = filter_data("ice");
            setTimeout(function() {
               add_item(data_water);
               $(".progress-wp").addClass("d-none");
            }, 100);
            
         })
         .catch(error => {
          console.error("AJAX request failed:", error);
         }
      );
   }
   function add_item(input){
       //let bounds = new google.maps.LatLngBounds();
       for (const property of input) {
           let var_name = "item_"+ property.id;
           let lat = Number(property.latitude);
           let lng = Number(property.longitude);
           window[var_name] = new google.maps.marker.AdvancedMarkerView({
               map,
               content: build_content(property),
               position: {
                  lat: lat,
                  lng: lng,
              }
           });
           window[var_name].addListener("click", () => {});
           //bounds.extend(property.position);

           jQuery(".list-store-carousel").html("").owlCarousel('destroy'); 
           add_item_to_carowsel(input) ;
           $('.list-store-carousel').owlCarousel({ margin:10,autoWidth:true, dots:false,items:1,onTranslated: function(event) {
             owl_callback(event);
           }})
       }
        //map.fitBounds(bounds);

   }

   function remove_item(input){
      for (const property of input) {
          let var_name = "item_"+ property.id;
          eval(var_name).map = null;
      }  
  }
   function build_content(property) {
      const content = document.createElement("div");
      content.classList.add("property","property-"+property.id);
      content.setAttribute("data-id", property.id);
      content.innerHTML = `<div class="marker-store"><span class="store">`+property.name+`</span><span class="rate">`+icon+round(property.avg_rating,true)+`</span></div>`;
     return content;
   }

   function build_icon(){
      let content = document.createElement("span");
      content.classList.add("dot-icon-wp");
      content.innerHTML = `<span class="dot-icon"></span>`;
     return content;
   }
   

   function load_store_to_map(latLng) {
     return new Promise((resolve, reject) => {
       // Thực hiện AJAX request ở đây
       jQuery.ajax({
           url: get_ajaxadmin,
           type: "post",
           dataType: "json",
           data: {                  
               action: 'atlantis_get_store_nearby',                                                         
               lat:latLng.lat,
               lng:latLng.lng                                                                                                    
           },
          
           success: function(output) { 
            if(output != "error"){
               data_json = output.data.data;
               resolve (output.data.data);
            }
           }          
              
      });

     });
   }

   function owl_callback(event,row = 1){    
      setTimeout(function() {         
         if(row == 3){
            var bounds = new google.maps.LatLngBounds();
            jQuery("#mapContainer .marker-store").removeClass("store_active");
            jQuery('[slot="visible-gmp-advanced-markers"]').css("z-index","0");
            jQuery(".list-store-carousel .owl-item:eq("+event.item.index+")").find(".store-item").each(function(index){
               let id = $(this).attr("data-id");
               
               setTimeout(function() {   
                  jQuery(".property-"+id +" .marker-store").addClass("store_active");
                  jQuery(".property-"+id +" .marker-store").parent().parent().parent().css("z-index","2");
               }, 100);

               let lat = $(this).attr("data-lat");
               let lng = $(this).attr("data-lng");
               bounds.extend(new google.maps.LatLng(lat, lng));
            });
            map.fitBounds(bounds);
            
         }else{
            let select = jQuery(".list-store-carousel .owl-item:eq("+event.item.index+")").find(".store-item");
            let lat = select.attr("data-lat");
            let lng = select.attr("data-lng");
            map.panTo(new google.maps.LatLng(lat, lng));

            let id = select.attr("data-id");
            jQuery("#mapContainer .marker-store").removeClass("store_active");
            jQuery('[slot="visible-gmp-advanced-markers"]').css("z-index","0");
            setTimeout(function() {   
               jQuery(".property-"+id +" .marker-store").addClass("store_active");
               jQuery(".property-"+id +" .marker-store").parent().parent().parent().css("z-index","2");
            }, 100);
         }
          
      }, 100);
   }
   function add_item_to_carowsel(input,row = 1){
      if(row == 3){
          var divIndex = 1;

          for (var i = 0; i < input.length; i += 3) {
              var group = input.slice(i, i + 3);

              var div = $("<div>").addClass("item _col-3");
              for (var j = 0; j < group.length; j++) {
                  let property = group[j];
                  let element = `<a href="/store/?store_page=store-detail&store_id=`+property.id+`&appt=N" class="store-item" data-lat="`+property.latitude+`" data-lng="`+property.longitude+`" data-id="`+property.id+`">
                       <div class="leading">
                         <img src="`+property.store_image.url+`">
                       </div>
                       <div class="content">
                         <div class="tt01">`+property.name+`</div>
                         <div class="tt02">
                           <span class="store-distance">`+round(property.distance,true)+` km</span>
                           <svg width="15" height="14" viewBox="0 0 15 14" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M7.32901 11.7286L3.77618 13.8689C3.61922 13.9688 3.45514 14.0116 3.28391 13.9973C3.11269 13.9831 2.96287 13.926 2.83446 13.8261C2.70604 13.7262 2.60616 13.6012 2.53482 13.4511C2.46348 13.301 2.44921 13.1335 2.49202 12.9486L3.43373 8.9035L0.287545 6.18536C0.144861 6.05695 0.0558259 5.91055 0.0204402 5.74618C-0.0149455 5.58181 -0.00438691 5.42143 0.0521161 5.26505C0.10919 5.1081 0.1948 4.97968 0.308948 4.8798C0.423095 4.77992 0.580048 4.71571 0.779806 4.68718L4.93192 4.32333L6.53712 0.513664C6.60846 0.342443 6.71918 0.214026 6.86928 0.128416C7.01939 0.0428054 7.17263 0 7.32901 0C7.48597 0 7.63921 0.0428054 7.78874 0.128416C7.93827 0.214026 8.049 0.342443 8.12091 0.513664L9.72611 4.32333L13.8782 4.68718C14.078 4.71571 14.2349 4.77992 14.3491 4.8798C14.4632 4.97968 14.5488 5.1081 14.6059 5.26505C14.663 5.422 14.6738 5.58266 14.6384 5.74704C14.6031 5.91141 14.5137 6.05752 14.3705 6.18536L11.2243 8.9035L12.166 12.9486C12.2088 13.1341 12.1945 13.3019 12.1232 13.452C12.0519 13.6021 11.952 13.7268 11.8236 13.8261C11.6952 13.926 11.5453 13.9831 11.3741 13.9973C11.2029 14.0116 11.0388 13.9688 10.8819 13.8689L7.32901 11.7286Z" fill="#FFC83A"></path></svg>
                           <span class="store-rating">`+round(property.avg_rating,true)+`</span>
                         </div>
                       </div>
                     </a>`;
                  div.append(element);
              }

              jQuery(".list-store-carousel").append(div);         
              divIndex++;
          }
      }else{
         for (const property of input) {
            let div = `<a href="/store/?store_page=store-detail&store_id=`+property.id+`&appt=N" class="store-item" data-lat="`+property.latitude+`" data-lng="`+property.longitude+`" data-id="`+property.id+`">
                       <div class="leading">
                         <img src="`+property.store_image.url+`">
                       </div>
                       <div class="content">
                         <div class="tt01">`+property.name+`</div>
                         <div class="tt02">
                           <span class="store-distance">`+round(property.distance,true)+` km</span>
                           <svg width="15" height="14" viewBox="0 0 15 14" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M7.32901 11.7286L3.77618 13.8689C3.61922 13.9688 3.45514 14.0116 3.28391 13.9973C3.11269 13.9831 2.96287 13.926 2.83446 13.8261C2.70604 13.7262 2.60616 13.6012 2.53482 13.4511C2.46348 13.301 2.44921 13.1335 2.49202 12.9486L3.43373 8.9035L0.287545 6.18536C0.144861 6.05695 0.0558259 5.91055 0.0204402 5.74618C-0.0149455 5.58181 -0.00438691 5.42143 0.0521161 5.26505C0.10919 5.1081 0.1948 4.97968 0.308948 4.8798C0.423095 4.77992 0.580048 4.71571 0.779806 4.68718L4.93192 4.32333L6.53712 0.513664C6.60846 0.342443 6.71918 0.214026 6.86928 0.128416C7.01939 0.0428054 7.17263 0 7.32901 0C7.48597 0 7.63921 0.0428054 7.78874 0.128416C7.93827 0.214026 8.049 0.342443 8.12091 0.513664L9.72611 4.32333L13.8782 4.68718C14.078 4.71571 14.2349 4.77992 14.3491 4.8798C14.4632 4.97968 14.5488 5.1081 14.6059 5.26505C14.663 5.422 14.6738 5.58266 14.6384 5.74704C14.6031 5.91141 14.5137 6.05752 14.3705 6.18536L11.2243 8.9035L12.166 12.9486C12.2088 13.1341 12.1945 13.3019 12.1232 13.452C12.0519 13.6021 11.952 13.7268 11.8236 13.8261C11.6952 13.926 11.5453 13.9831 11.3741 13.9973C11.2029 14.0116 11.0388 13.9688 10.8819 13.8689L7.32901 11.7286Z" fill="#FFC83A"></path></svg>
                           <span class="store-rating">`+round(property.avg_rating,true)+`</span>
                         </div>
                       </div>
                     </a>`;
            jQuery(".list-store-carousel").append(div);               
         } 
      }
      
   }

   function round(number,distance = false) {
      if(distance){
         let factor = Math.pow(10, 1);
         let roundedNumber = Math.round(number * factor) / factor;
         return roundedNumber;
      }else{
         let decimalPart = number - Math.floor(number); 
         if (decimalPart >= 0.5) {
            return Math.ceil(number);
         } else {
            return Math.floor(number);
         }
      }
     
   }

   function filter_data(type = "water"){
      let data = [];
      if(type == "water"){
         jQuery.each(data_json, function( index, value ) {
           if(value.store_type === "water" || value.store_type === "both") data.push(value);
         });
      }else{
         jQuery.each(data_json, function( index, value ) {
           if(value.store_type == "ice" || value.store_type == "both") data.push(value);
         });
      }
      return data;
   }


   function calculateDistance(lat1, lng1, lat2, lng2) {
      var earthRadius = 6371; 
      var dLat = degToRad(lat2 - lat1);
      var dLng = degToRad(lng2 - lng1);
      var a =
          Math.sin(dLat / 2) * Math.sin(dLat / 2) +
          Math.cos(degToRad(lat1)) * Math.cos(degToRad(lat2)) *
          Math.sin(dLng / 2) * Math.sin(dLng / 2);
      var c = 2 * Math.atan2(Math.sqrt(a), Math.sqrt(1 - a));
      var distance = earthRadius * c;
      return distance;
   }

   
   function degToRad(deg) {
      return deg * (Math.PI / 180);
   }
   
   jQuery( document ).ready(function($) {
      var row_store = 1;
      
      $("#toggleMap").click(function(){
         $(this).toggleClass("active");
         $(".store-list").toggleClass("showed");
         row_store = (row_store == 1) ? 3 : 1;
         jQuery(".list-store-carousel").html("").owlCarousel('destroy'); 
         if(type == "water"){
            add_item_to_carowsel(data_water,row_store) ;
         }else{
            add_item_to_carowsel(data_ice,row_store) ;
         }
         
         $('.list-store-carousel').owlCarousel({ margin:10,autoWidth:true, dots:false,items:1,onTranslated: function(event) {
            owl_callback(event,row_store);
         }})
      });
      $(".back_to_mylocation").click(function(){
         map.panTo(center);
         map.setZoom(16)
      });

      $(".filter-button").click(function(){
         if($(this).hasClass("active")) return;
         type = $(this).data("type");
         $(".filter-button").removeClass("active");
         $(this).addClass("active");
         $("#toggleMap").removeClass("active");
         $(".store-list").removeClass("showed");
         row_store = 1;
         jQuery(".list-store-carousel").html("").owlCarousel('destroy'); 
         if($(this).data("type") == "water"){
            remove_item(data_ice);
            add_item(data_water);
         }else{
            remove_item(data_water);
            add_item(data_ice);
         }

      });

      $("#mapContainer").on("click",".property",function(){
         let targetId = $(this).attr("data-id");
         let objectArray  = (type == "water") ? data_water : data_ice;
         let nearestPoints;
         var targetIndex = -1;
         for (var i = 0; i < objectArray.length; i++) {
            if (objectArray[i].id === targetId) {
               targetIndex = i;
               break;
            }
         }

         if (targetIndex !== -1) {
            map.panTo({lat: Number(objectArray[targetIndex].latitude), lng:Number(objectArray[targetIndex].longitude) });
            
            var targetObject = objectArray[targetIndex];

            if (targetObject) {
                nearestPoints = objectArray
                    .filter(function (item) {
                        return item.id !== targetId;
                    })
                    .sort(function (a, b) {
                        let distanceToA = calculateDistance(targetObject.latitude, targetObject.longitude, a.latitude, a.longitude);
                        let distanceToB = calculateDistance(targetObject.latitude, targetObject.longitude, b.latitude, b.longitude);
                        return distanceToA - distanceToB;
                    })
                    .slice(0, 2); 
               nearestPoints.push(targetObject);
            } 

            $("#mapContainer .marker-store").removeClass("store_active");
            $('[slot="visible-gmp-advanced-markers"]').css("z-index","0");
            $.each(nearestPoints, function( index, value ) {
               if (typeof value != 'undefined') {
                  let id = value.id;
               
                  setTimeout(function() {   
                     $(".property-"+id +" .marker-store").addClass("store_active");
                     $(".property-"+id +" .marker-store").parent().parent().parent().css("z-index","2");
                  }, 100);
               }
            });
         } 
      })
      var count_cart = window.count_product_in_cart();
      if(count_cart > 0){
         $('.count-cart').text(count_cart).addClass("enable");
      }else{
         $('.count-cart').text("").removeClass("enable");
      }

      $(".modal-close").click(function(){
         $(".access-location-modal").addClass("d-none")
      })
   })//end ready

   window.onerror = function(msg, url, linenumber) {
       // alert('Error message: '+msg+'\nURL: '+url+'\nLine Number: '+linenumber);
       // return true;
   }

   async function atlantis_count_messeage_everytime(){
      var form = new FormData();
      form.append('action', 'atlantis_count_messeage_everytime');
      var r = await window.request(form);
      if( r != undefined ){
         var res = JSON.parse( JSON.stringify( r));
         if( res.message == 'count_messages_ok' ) {
            if( res.data > 0 ){
               $('.badge-messages').addClass('enable');
               $('.badge-messages').text(res.data);
            }else{
               $('.badge-messages').removeClass('enable');
               $('.badge-messages').text(0);
            }
         }
      }
   }

   setInterval( async () => { await this.atlantis_count_messeage_everytime(); }, 1800);

   async function callbackActiveTab(){
      var count_cart = window.count_product_in_cart();
      if(count_cart > 0){
         jQuery('.count-cart').text(count_cart).addClass("enable");
      }else{
         jQuery('.count-cart').text("").removeClass("enable");
      }
      await window.app.get_notification_count();
   }
</script>

