<?php

   $home_sliders = get_fields(713, 'home_sliders');
   $list_slide = [];
   if( ! empty($home_sliders['home_sliders'])){
      foreach( $home_sliders['home_sliders'] as $k => $vl ){ 
         $list_slide[$k]['img'] = wp_get_attachment_url($vl['item']);
      }
   }


?>
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Poppins&display=swap" rel="stylesheet">
<script src="<?php echo THEME_URI . '/assets/js/slick.min.js'; ?>"></script>
<link rel="stylesheet" href="<?php echo THEME_URI . '/assets/css/slick.min.css'; ?>">
<script src='<?php echo THEME_URI . '/pages/module/location_modal.js?ver=3.0'; ?>'></script>
<script src='<?php echo THEME_URI . '/pages/module/module_get_order_delivering.js?ver=3.0'; ?>'></script>
<style>

   .box-language .dropdown-language{
      position: initial;
      top: initial;
      right: initial;  
   }
   .box-language .dropdown-menu{
      left: 0;
      right: initial;
   }

   .box-language{
      display: flex;
      align-items: center;
   }

   .box-search-home .input-search {
      border: 1px solid #C1CCDC;
      border-radius: 12px;
      background: white;
      padding-left: 0;
      height: 48px;
      padding: 0 20px;
   }
   .box-search-home .input-search:placeholder {
      color: #5E6D83;
      font-weight: 300;
      font-size: 16px;
   }
   .box-search-home .icon-search {
      left: initial;
      right: 20px;
      top: 12px;
      transform: initial;
   }

   /* SLIDE */
   .slider-container{
      position: relative;
      height: 56vw;
      overflow: initial;
      margin-top: 12px;
   }
   .slider-container .slider-container img{height: 100%;}
   .slider-container .slick-track{height: 100%;}
   .slider-container .slick-slider{height: 100%;}
   .slider-container .slick-slider img{
      height: 100%;
      aspect-ratio: 1/1;
      object-fit: cover;
   }
   .slider-container .slick-list{height: 100%;}
   .slider-container .slick-slide{
      height: 100%;
      border-radius: 16px;
      overflow: hidden;
   }
   .slider-container .slick-dots{
      position: absolute;
      bottom: -16px;
      left: 50%;
      transform: translateX(-50%);
      display: flex;
   }
   .slider-container .slick-dots li {
      width: 8px;
      height: 8px;
      background: #E8E8E8;
      border-radius: 100%;
      margin: 0 4px;
   }
   .slider-container .slick-dots li.slick-active {
      background: #2491F5;
   }
   .slider-container .slick-dots li button {
      display: none;
   }

   .gr-btn{
      padding-top: 28px;
   }
   .btn-home{
      height: 44px;
      border: 1px solid #93C4FF;
      border-radius: 12px;
   }
   .btn-home .text{
      font-family: 'Poppins', sans-serif;
      font-weight: 400;
      font-size: 16px;  
      color: #081528;
      bottom: initial;
   }
   .btn-home .icon{
      margin-right: 15px;
   }

   .gr-heading .heading{
      font-weight: 400;
      font-size: 20px;
      white-space: nowrap;
   }

   .home-contents {
      margin-top: 28px;
      padding-bottom: 30px;
   }

   .gr-heading .link{
      font-weight: 500;
      font-size: 16px;
      color: #1A68FF;
   }

   /* PRODUCT NEW DESIGN */

   .list-scroll-horizontal{
      display: flex;
      flex-flow: row nowrap;
      overflow-x: auto;
      overflow-y: hidden;
   }

   .product-container{
      display: flex;
      flex-flow: row nowrap;
      white-space: nowrap;
      padding-bottom: 1px;
   }

   .product-container:last-child .product-block:last-child{
      margin-right: 0;
   }

   .product-block {
      display: flex;
      flex-flow: column nowrap;
      border-radius: 16px;
      border: 1px solid #D3D3D3;
      overflow: hidden;
      margin-right: 16px;
      padding-bottom: 10px;
      width: 164px;
   }

   .product-block .badge-discount{
      width: 60px;
      height: 26px;
      line-height: 26px;
      color: #FF4848;
      border-radius: 16px;
      font-weight: 400;
      font-size: 10px;
      left: 4px;
      top: 4px;
   }

   .product-block .img {
      text-align: center;
      position: relative;
   }
   .product-block img {
      width: 100%;
      height: 100% !important;
      border-top-left-radius: 16px;
      border-top-right-radius: 16px;
      aspect-ratio: 1 / 1;
   }
   .product-block .tt01 {
      padding: 0 16px;
      font-weight: 500;
      font-size: 16px;
      color: #252831;
   }
   .product-block .tt02 {
      padding: 0 16px;
      font-weight: 300;
      font-size: 12px;
      color: #7B7D83;
   }
   .product-block .product-meta {
      padding: 0 16px;
      color: #7B7D83;
      font-weight: 300;
      font-size: 14px;
   }
   .product-block .product-meta svg{
      position: relative;
      top: 1px;
      /* margin-right: 4px; */
   }
   .product-block .store-distance {
      margin-right: 8px;
   }
   .product-block .price {
      padding-right: 8px;
      padding-left: 16px;
      font-weight: 500;
      font-size: 16px;
      color: #2790F9;
   }
   .product-block .price-sub{
		color: #918D8D;
		font-weight: 400;
		font-size: 9px;
		text-decoration: line-through;
      position: relative;
      top: -2px;
      white-space: nowrap;
   }
   .gr-price{
      padding: 0 16px;
      display: flex;
      flex-flow: row wrap;
      align-items: flex-end;
   }
   .product-block .price{
      padding-left: 0;
   }

   .product-block .tt01{
      overflow: hidden;
      text-overflow: ellipsis;
   }
   .product-block .price{
      font-size: 14px;
      font-weight: 600;
   }

   .list-product-recommend-style-1 .product-block {
      width: 179px;
      min-height: 264px;
      padding-bottom: 0;
   }
   .list-product-recommend-style-1 .product-block .img{
      width: 100%;
      height: 179px;
   }
   .list-product-recommend-style-1 .product-block .gr-price,
   .list-product-recommend-style-1 .product-block .tt01,
   .list-product-recommend-style-1 .product-block .tt02{
      padding: 0 12px;
   }

   .list-store .product-block{
      width: 179px;
   }
   .list-store .product-block .img{
      width: 100%;
      height: 179px;
   }

   #btn-zalo{
      width: 50px;
      height: 50px;
      box-shadow: 0px 4px 4px 0px #0000001F;
      border-radius: 100%;
      display: block;
      position: fixed;
      bottom: 10px;
      right: 10px;
   }

   #btn-zalo.add-space{
      bottom: 72px;
   }
   .badge-gift {
      display: flex;
      flex-flow: row nowrap;
      padding-bottom: 5px;
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
</style>
<div id='app'>

   <div v-if='loading == false'>
      <div class='page-home'>
         <div class='appbar'>
            <div class='appbar-top'>
               <div class='leading'>

                  <div class='box-language'>
                     <div class="dropdown dropdown-language">
                        <div class="dropdown-toggle">
                           <div class="selected-option" @click="toggleDropdown">
                              <img :src="getFlagImage(selectedLanguage.id)" class="flag-image" />
                              <svg width="12" height="7" viewBox="0 0 12 7" fill="none" xmlns="http://www.w3.org/2000/svg">
                              <path d="M1 1L6 6L11 1" stroke="#C1CCDC" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                              </svg>
                           </div>
                           <ul class="dropdown-menu" :class="{ 'show': showDropdown == true }">
                              <li v-for="language in languages" :key="language.id" @click="selectLanguage(language)" :class="{ 'selected': currentLocale === language.id }">
                                 <img :src="getFlagImage(language.id)" :alt="language.id" class="flag-image" />
                                 {{ language.name }}
                              </li>
                           </ul>
                        </div>
                     </div>
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
                     <path fill-rule="evenodd" clip-rule="evenodd" d="M19.0577 4.76171H6.7798C6.29136 4.76171 5.82292 4.96238 5.47753 5.31957C5.13215 5.67676 4.93812 6.16121 4.93812 6.66636V13.0152C4.93812 13.5203 5.13215 14.0048 5.47753 14.362C5.82292 14.7192 6.29136 14.9198 6.7798 14.9198H12.9188C12.9994 14.9197 13.0793 14.936 13.1539 14.9678C13.2285 14.9996 13.2963 15.0463 13.3534 15.1052L15.9882 17.8314V15.5547C15.9882 15.3863 16.0529 15.2249 16.168 15.1058C16.2832 14.9867 16.4393 14.9198 16.6021 14.9198H19.0577C19.5461 14.9198 20.0146 14.7192 20.36 14.362C20.7054 14.0048 20.8994 13.5203 20.8994 13.0152V6.66636C20.8994 6.16121 20.7054 5.67676 20.36 5.31957C20.0146 4.96238 19.5461 4.76171 19.0577 4.76171ZM6.7798 3.49194H19.0577C19.8718 3.49194 20.6525 3.82639 21.2282 4.42171C21.8038 5.01703 22.1272 5.82445 22.1272 6.66636V13.0152C22.1272 13.4321 22.0478 13.8448 21.8935 14.23C21.7393 14.6151 21.5132 14.9651 21.2282 15.2598C20.9431 15.5546 20.6047 15.7884 20.2323 15.948C19.8599 16.1075 19.4608 16.1896 19.0577 16.1896H17.216V19.364C17.2162 19.4897 17.1804 19.6127 17.1129 19.7173C17.0455 19.8219 16.9495 19.9035 16.8372 19.9516C16.7249 19.9998 16.6013 20.0124 16.4821 19.9878C16.3628 19.9632 16.2533 19.9025 16.1675 19.8135L12.6646 16.1896H6.7798C5.96573 16.1896 5.18499 15.8552 4.60936 15.2598C4.03372 14.6645 3.71033 13.8571 3.71033 13.0152V6.66636C3.71033 5.82445 4.03372 5.01703 4.60936 4.42171C5.18499 3.82639 5.96573 3.49194 6.7798 3.49194Z" fill="#2790F9"/>
                     <path d="M19.0577 4.76171H6.7798C6.29136 4.76171 5.82292 4.96238 5.47753 5.31957C5.13215 5.67676 4.93812 6.16121 4.93812 6.66636V13.0152C4.93812 13.5203 5.13215 14.0048 5.47753 14.362C5.82292 14.7192 6.29136 14.9198 6.7798 14.9198H12.9188C12.9994 14.9197 13.0793 14.936 13.1539 14.9678C13.2285 14.9996 13.2963 15.0463 13.3534 15.1052L15.9882 17.8314V15.5547C15.9882 15.3863 16.0529 15.2249 16.168 15.1058C16.2832 14.9867 16.4393 14.9198 16.6021 14.9198H19.0577C19.5461 14.9198 20.0146 14.7192 20.36 14.362C20.7054 14.0048 20.8994 13.5203 20.8994 13.0152V6.66636C20.8994 6.16121 20.7054 5.67676 20.36 5.31957C20.0146 4.96238 19.5461 4.76171 19.0577 4.76171Z" fill="white"/>
                     <path d="M10.4639 9.32355C10.4639 9.705 10.1546 10.0142 9.77319 10.0142C9.39174 10.0142 9.08252 9.705 9.08252 9.32355C9.08252 8.9421 9.39174 8.63288 9.77319 8.63288C10.1546 8.63288 10.4639 8.9421 10.4639 9.32355Z" fill="#2790F9"/>
                     <path d="M13.5947 9.3098C13.5947 9.69124 13.2855 10.0005 12.904 10.0005C12.5226 10.0005 12.2133 9.69124 12.2133 9.3098C12.2133 8.92835 12.5226 8.61912 12.904 8.61912C13.2855 8.61912 13.5947 8.92835 13.5947 9.3098Z" fill="#2790F9"/>
                     <path d="M16.7027 9.32356C16.7027 9.70501 16.3935 10.0142 16.012 10.0142C15.6306 10.0142 15.3214 9.70501 15.3214 9.32356C15.3214 8.94211 15.6306 8.63288 16.012 8.63288C16.3935 8.63288 16.7027 8.94211 16.7027 9.32356Z" fill="#2790F9"/>
                     </svg>
                     
                     <span class='badge' :class="message_count > 0 ? 'enable' : '' " >{{ message_count }}</span>
                  </div>

                  <div @click='gotoNotificationIndex' class='btn-badge ml10'>
                     <svg width="19" height="20" viewBox="0 0 19 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                     <path d="M16.1176 14.6055C16.577 15.3164 17.1289 15.9629 17.7587 16.5281V17.2473H0.826953V16.5278C1.44914 15.9599 1.99356 15.3122 2.44603 14.6015L2.46376 14.5737L2.47879 14.5443C2.99231 13.5401 3.30009 12.4435 3.38408 11.3188L3.38602 11.2928V11.2667L3.38602 8.22777L3.38602 8.22636C3.38312 6.7874 3.9018 5.39615 4.84599 4.31028C5.79017 3.22441 7.09589 2.51751 8.5213 2.32051L9.12547 2.23701V1.6271V0.821239C9.12547 0.789084 9.13824 0.758246 9.16098 0.735511C9.18371 0.712773 9.21455 0.7 9.24671 0.7C9.27886 0.7 9.3097 0.712773 9.33243 0.735509C9.35517 0.758248 9.36795 0.789086 9.36795 0.821239V1.6148V2.23105L9.97923 2.30915C11.4175 2.49291 12.7392 3.19556 13.696 4.28509C14.6527 5.37462 15.1787 6.77603 15.1751 8.22601V8.22777V11.2667V11.2928L15.177 11.3188C15.261 12.4435 15.5688 13.5401 16.0823 14.5443L16.0984 14.5758L16.1176 14.6055Z" stroke="#2790F9" stroke-width="1.4"/>
                     <path d="M7.67493 18.5933C7.72887 18.9832 7.92209 19.3404 8.21891 19.599C8.51572 19.8576 8.89607 20 9.28972 20C9.68337 20 10.0637 19.8576 10.3605 19.599C10.6574 19.3404 10.8506 18.9832 10.9045 18.5933H7.67493Z" fill="#2790F9"/>
                     </svg>
                     <span class='badge badge-notification' :class="notification_count > 0 ? 'enable' : '' ">{{ notification_count }}</span>
                  </div>

               </div>
            </div>
            <div class='appbar-bottom style01'>
               <div class='box-search box-search-home'>
                  <input @click='gotoSearch' class='input-search' type="text" v-model='inputSearch' placeholder='<?php echo __('Find products or stores by name', 'watergo'); ?>' readonly>
                  <span class='icon-search'>
                     <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                     <path d="M17.2 17.2L20 20M19.2 11.6C19.2 7.40264 15.7974 4 11.6 4C7.40264 4 4 7.40264 4 11.6C4 15.7974 7.40264 19.2 11.6 19.2C15.7974 19.2 19.2 15.7974 19.2 11.6Z" stroke="#5E6D83" stroke-linecap="round" stroke-linejoin="round"/>
                     </svg>
                  </span>
               </div>
            </div>
         </div>

         <?php if( ! empty($list_slide ) ){ ?>
         <div class='inner'>
            <div class='slider-container'>
               <ul class='sliders'>
                  <?php foreach( $list_slide as $k => $vl ){ 
                  ?>
                  <li class='slide'><img src="<?php echo $vl['img']; ?>"></li>
                  <?php } ?>
               </ul>
            </div>
         </div>
         <?php } ?>

         <div class='inner'>
            <div class='gr-btn'>
               <button @click='gotoProductWater' class='btn-outline btn-home'>
                  <div class='icon'>

                     <svg width="25" height="24" viewBox="0 0 25 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M12.3734 17.6743C13.9512 17.6732 15.4642 17.0463 16.5802 15.9309C17.6962 14.8156 18.3242 13.303 18.3262 11.7252C18.3262 7.96298 12.8835 1.98017 12.651 1.72511C12.6154 1.68769 12.5727 1.6579 12.5253 1.63754C12.4779 1.61718 12.4268 1.60669 12.3753 1.60669C12.3237 1.60669 12.2726 1.61719 12.2252 1.63756C12.1778 1.65792 12.1351 1.68772 12.0996 1.72513C11.867 1.98017 6.42431 7.96298 6.42431 11.7252C6.42549 13.3026 7.05265 14.8151 8.16807 15.9305C9.28348 17.0459 10.796 17.6731 12.3734 17.6743ZM16.4882 10.2886C16.5889 10.2906 16.6847 10.332 16.7552 10.4038C16.8257 10.4757 16.8652 10.5724 16.8652 10.6731C16.8652 10.7737 16.8257 10.8704 16.7552 10.9423C16.6847 11.0142 16.5888 11.0555 16.4882 11.0575C16.3875 11.0555 16.2917 11.0142 16.2212 10.9423C16.1507 10.8704 16.1112 10.7737 16.1112 10.673C16.1112 10.5724 16.1507 10.4757 16.2212 10.4038C16.2917 10.3319 16.3876 10.2906 16.4882 10.2886ZM12.3734 15.3899C13.3455 15.3893 14.2777 15.0031 14.9654 14.3161C15.6531 13.6291 16.0403 12.6973 16.0418 11.7252C16.0433 11.6267 16.0835 11.5327 16.1537 11.4636C16.2239 11.3945 16.3184 11.3558 16.417 11.3558C16.5155 11.3558 16.61 11.3945 16.6802 11.4636C16.7504 11.5328 16.7905 11.6267 16.792 11.7252C16.7899 12.8961 16.3235 14.0183 15.4952 14.8459C14.6669 15.6735 13.5443 16.1389 12.3734 16.1401C12.2741 16.1398 12.179 16.1001 12.1089 16.0298C12.0389 15.9595 11.9995 15.8643 11.9995 15.765C11.9995 15.6657 12.0389 15.5705 12.1089 15.5002C12.179 15.4299 12.2741 15.3902 12.3734 15.3899ZM22.4448 20.1499C20.3779 21.6276 17.8961 22.4128 15.3554 22.393C11.8531 22.4094 7.36027 20.2176 4.26004 21.5265C4.11672 21.5869 3.95817 21.6013 3.80631 21.5677C3.65445 21.5341 3.51678 21.4542 3.41231 21.339L1.96074 19.7936C1.87792 19.7066 1.81684 19.6013 1.78248 19.4862C1.74812 19.3712 1.74146 19.2496 1.76303 19.1315C1.7846 19.0133 1.8338 18.902 1.90661 18.8065C1.97942 18.711 2.07378 18.6341 2.18199 18.582C3.66115 17.9356 5.26459 17.6231 6.87823 17.6668C8.99275 17.5383 13.1604 18.9008 15.3517 18.9646C16.9747 18.9721 18.5579 18.4623 19.8716 17.5092C20.0087 17.4072 20.1761 17.3543 20.3469 17.3591C20.5177 17.3638 20.6819 17.426 20.8131 17.5355L22.486 18.9646C22.5722 19.0389 22.6406 19.1316 22.6862 19.2359C22.7318 19.3402 22.7535 19.4534 22.7495 19.5671C22.7456 19.6809 22.7161 19.7923 22.6634 19.8932C22.6106 19.994 22.5359 20.0817 22.4448 20.1499Z" fill="url(#paint0_linear_3023_61)"/>
                        <defs>
                        <linearGradient id="paint0_linear_3023_61" x1="1.74999" y1="11.9999" x2="22.75" y2="11.9999" gradientUnits="userSpaceOnUse">
                        <stop stop-color="#00C0FF"/>
                        <stop offset="1" stop-color="#5558FF"/>
                        </linearGradient>
                        </defs>
                     </svg>

                  </div>
                  <span class='text'><?php echo __('Water', 'watergo'); ?></span>
               </button>
               <button @click='gotoProductIce' class='btn-outline btn-home'>
                  <div class='icon'>

                     <svg width="25" height="24" viewBox="0 0 25 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M22.4448 20.15C20.3779 21.6276 17.8962 22.4129 15.3555 22.3931C11.8532 22.4095 7.3603 20.2176 4.26007 21.5266C4.11675 21.587 3.9582 21.6014 3.80634 21.5678C3.65448 21.5342 3.51681 21.4542 3.41234 21.339L1.96077 19.7936C1.87795 19.7067 1.81687 19.6014 1.78251 19.4863C1.74815 19.3712 1.74149 19.2497 1.76306 19.1315C1.78463 19.0134 1.83383 18.9021 1.90664 18.8066C1.97945 18.7111 2.07381 18.6341 2.18202 18.5821C3.66118 17.9357 5.26462 17.6232 6.87826 17.6669C8.99278 17.5384 13.1605 18.9009 15.3517 18.9647C16.9747 18.9721 18.5579 18.4623 19.8716 17.5093C20.0087 17.4073 20.1761 17.3544 20.3469 17.3591C20.5177 17.3639 20.682 17.426 20.8131 17.5355L22.4861 18.9647C22.5723 19.039 22.6407 19.1317 22.6863 19.236C22.7319 19.3403 22.7535 19.4535 22.7495 19.5672C22.7456 19.681 22.7161 19.7924 22.6634 19.8932C22.6107 19.9941 22.536 20.0818 22.4448 20.15Z" fill="url(#paint0_linear_3023_66)"/>
                        <path d="M7.57834 12.2517C7.29167 12.5384 7.29167 12.9684 7.57834 13.255C7.865 13.5417 8.295 13.5417 8.58167 13.255C8.86834 12.9684 8.86834 12.5384 8.58167 12.2517C8.295 11.965 7.865 11.965 7.57834 12.2517ZM17.755 4.08167C18.0417 3.795 18.0417 3.365 17.755 3.07834C17.4684 2.79167 17.0384 2.79167 16.7517 3.07834C16.465 3.365 16.465 3.795 16.7517 4.08167C17.0384 4.36834 17.4684 4.36834 17.755 4.08167ZM8.58167 4.08167C8.86834 3.795 8.86834 3.365 8.58167 3.07834C8.295 2.79167 7.865 2.79167 7.57834 3.07834C7.29167 3.365 7.29167 3.795 7.57834 4.08167C7.865 4.36834 8.295 4.36834 8.58167 4.08167ZM16.7517 12.2517C16.465 12.5384 16.465 12.9684 16.7517 13.255C17.0384 13.5417 17.4684 13.5417 17.755 13.255C18.0417 12.9684 18.0417 12.5384 17.755 12.2517C17.4684 11.965 17.0384 11.965 16.7517 12.2517ZM19.1167 7.45001H17.97L18.9017 6.51834C19.1884 6.23167 19.1884 5.80167 18.9017 5.51501C18.615 5.22834 18.185 5.22834 17.8984 5.51501L15.9633 7.45001H14.3867L16.035 5.80167C16.3217 5.51501 16.3217 5.08501 16.035 4.79834C15.7484 4.51167 15.3183 4.51167 15.0317 4.79834L13.3833 6.44668V4.87001L15.3183 2.935C15.605 2.64834 15.605 2.21834 15.3183 1.93167C15.0317 1.645 14.6017 1.645 14.315 1.93167L13.3833 2.86334V1.71667C13.3833 1.28667 13.0967 1 12.6667 1C12.2367 1 11.95 1.28667 11.95 1.71667V2.86334L11.0183 1.93167C10.7317 1.645 10.3017 1.645 10.015 1.93167C9.72834 2.21834 9.72834 2.64834 10.015 2.935L11.95 4.87001V6.44668L10.3017 4.79834C10.015 4.51167 9.58501 4.51167 9.29834 4.79834C9.01167 5.08501 9.01167 5.51501 9.29834 5.80167L10.9467 7.45001H9.37001L7.435 5.51501C7.14834 5.22834 6.71834 5.22834 6.43167 5.51501C6.145 5.80167 6.145 6.23167 6.43167 6.51834L7.36334 7.45001H6.21667C5.78667 7.45001 5.5 7.73668 5.5 8.16668C5.5 8.59668 5.78667 8.88335 6.21667 8.88335H7.36334L6.43167 9.81501C6.145 10.1017 6.145 10.5317 6.43167 10.8183C6.71834 11.105 7.14834 11.105 7.435 10.8183L9.37001 8.88335H10.9467L9.29834 10.5317C9.01167 10.8183 9.01167 11.2484 9.29834 11.535C9.58501 11.8217 10.015 11.8217 10.3017 11.535L11.95 9.88668V11.4633L10.015 13.3984C9.72834 13.685 9.72834 14.115 10.015 14.4017C10.3017 14.6884 10.7317 14.6884 11.0183 14.4017L11.95 13.47V14.6167C11.95 15.0467 12.2367 15.3334 12.6667 15.3334C13.0967 15.3334 13.3833 15.0467 13.3833 14.6167V13.47L14.315 14.4017C14.6017 14.6884 15.0317 14.6884 15.3183 14.4017C15.605 14.115 15.605 13.685 15.3183 13.3984L13.3833 11.4633V9.88668L15.0317 11.535C15.3183 11.8217 15.7484 11.8217 16.035 11.535C16.3217 11.2484 16.3217 10.8183 16.035 10.5317L14.3867 8.88335H15.9633L17.8984 10.8183C18.185 11.105 18.615 11.105 18.9017 10.8183C19.1884 10.5317 19.1884 10.1017 18.9017 9.81501L17.97 8.88335H19.1167C19.5467 8.88335 19.8334 8.59668 19.8334 8.16668C19.8334 7.73668 19.5467 7.45001 19.1167 7.45001Z" fill="url(#paint1_linear_3023_66)"/>
                        <defs>
                        <linearGradient id="paint0_linear_3023_66" x1="1.75002" y1="12" x2="22.75" y2="12" gradientUnits="userSpaceOnUse">
                        <stop stop-color="#00C0FF"/>
                        <stop offset="1" stop-color="#5558FF"/>
                        </linearGradient>
                        <linearGradient id="paint1_linear_3023_66" x1="5.49955" y1="8.16658" x2="19.8334" y2="8.16658" gradientUnits="userSpaceOnUse">
                        <stop stop-color="#00C0FF"/>
                        <stop offset="1" stop-color="#5558FF"/>
                        </linearGradient>
                        </defs>
                     </svg>

                  </div>
                  <span class='text'><?php echo __('Ice', 'watergo'); ?></span>
               </button>
            </div>

            <div class='home-contents'>

               <div v-if='productRecommend.length > 0' class='list-product-recommend list-product-recommend-style-1'>
                  <div class='gr-heading'>
                     <p class='heading'><?php echo __('Recommend product', 'watergo'); ?></p>
                     <span @click='gotoProductRecommend' class='link'><?php echo __('See all', 'watergo'); ?></span>
                  </div>

                  <div class='list-horizontal'>

                     <div class='list-scroll-horizontal'>
                        <div 
                           v-for='(productGroup, productGroupIndex) in splitArray(productRecommend, 2)' :key='productGroupIndex'
                           class='product-container'
                        >
                           <div v-for="(product, index) in productGroup" :key="index" @click="gotoProductDetail(product.id)" class='product-block'>
                              <div class="img" :class='{ "img-dummy": product.product_image.dummy != undefined }'>
                                 <img :src="product.product_image.url">
                                 <span v-if="has_discount(product) == true" class="badge-discount">-{{ product.discount_percent }}%</span>
                              </div>
                              <p class="tt01">{{ product.name }} </p>
                              <p class="tt02">{{ product.name_second }}</p>
                              <div class="gr-price" :class="has_discount(product) == true ? 'has_discount' : ''">
                                 <span class="price">
                                    {{ common_price_after_discount(product) }}
                                 </span>
                                 <span v-if="has_discount(product) == true" class="price-sub">
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
                           </div>
                        </div>

                     </div>

                  </div>

                  <div class='list-horizontal' style='margin-top: 18px;'>

                     <div class='list-scroll-horizontal'>
                        <div 
                           v-for='(productGroup, productGroupIndex) in splitArray2(productRecommend, 2)' :key='productGroupIndex'
                           class='product-container'
                        >
                           <div v-for="(product, index) in productGroup" :key="index" @click="gotoProductDetail(product.id)" class='product-block'>
                              <div class="img" :class='{ "img-dummy": product.product_image.dummy != undefined }'>
                                 <img :src="product.product_image.url">
                                 <span v-if="has_discount(product) == true" class="badge-discount">-{{ product.discount_percent }}%</span>
                              </div>
                              
                              <p class="tt01">{{ product.name }} </p>
                              <p class="tt02">{{ product.name_second }}</p>

                              <div class="gr-price" :class="has_discount(product) == true ? 'has_discount' : ''">
                                 <span class="price">
                                    {{ common_price_after_discount(product) }}
                                 </span>
                                 <span v-if="has_discount(product) == true" class="price-sub">
                                    {{ common_price_show_currency(product.price) }}
                                 </span>
                              </div>
                           </div>
                        </div>

                     </div>

                  </div>

               </div>

               <div v-if='storeNearby.length > 0' class='list-product-recommend list-store' style='margin-top: 28px;'>
                  <div class='gr-heading'>
                     <p class='heading'><?php echo __('Nearby store', 'watergo'); ?></p>
                     <span @click='gotoNearbyStore' class='link'><?php echo __('See all', 'watergo'); ?></span>
                  </div>

                  <div class='list-horizontal'>
                     <div class='list-scroll-horizontal'>
                        <div class='product-container'>
                           <div 
                              class='product-block'
                              @click='gotoStoreDetail(store.id)'
                              v-for='(store, index) in storeNearby' :key='index'
                           >
                              <div class='img' :class='store.store_image.dummy != undefined ? "img-dummy" : "" '
                              >
                                 <img :src='store.store_image.url'>
                              </div>
                              <p class='tt01'>{{ store.name }} </p>
                              <p class='product-meta'>
                                 <span class='store-distance'>{{ mathCeilDistance(store.distance) }} km</span>
                                 <svg v-if='store.avg_rating > 0' width="15" height="14" viewBox="0 0 15 14" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M7.32901 11.7286L3.77618 13.8689C3.61922 13.9688 3.45514 14.0116 3.28391 13.9973C3.11269 13.9831 2.96287 13.926 2.83446 13.8261C2.70604 13.7262 2.60616 13.6012 2.53482 13.4511C2.46348 13.301 2.44921 13.1335 2.49202 12.9486L3.43373 8.9035L0.287545 6.18536C0.144861 6.05695 0.0558259 5.91055 0.0204402 5.74618C-0.0149455 5.58181 -0.00438691 5.42143 0.0521161 5.26505C0.10919 5.1081 0.1948 4.97968 0.308948 4.8798C0.423095 4.77992 0.580048 4.71571 0.779806 4.68718L4.93192 4.32333L6.53712 0.513664C6.60846 0.342443 6.71918 0.214026 6.86928 0.128416C7.01939 0.0428054 7.17263 0 7.32901 0C7.48597 0 7.63921 0.0428054 7.78874 0.128416C7.93827 0.214026 8.049 0.342443 8.12091 0.513664L9.72611 4.32333L13.8782 4.68718C14.078 4.71571 14.2349 4.77992 14.3491 4.8798C14.4632 4.97968 14.5488 5.1081 14.6059 5.26505C14.663 5.422 14.6738 5.58266 14.6384 5.74704C14.6031 5.91141 14.5137 6.05752 14.3705 6.18536L11.2243 8.9035L12.166 12.9486C12.2088 13.1341 12.1945 13.3019 12.1232 13.452C12.0519 13.6021 11.952 13.7268 11.8236 13.8261C11.6952 13.926 11.5453 13.9831 11.3741 13.9973C11.2029 14.0116 11.0388 13.9688 10.8819 13.8689L7.32901 11.7286Z" fill="#FFC83A"/></svg>
                                 <span v-if='store.avg_rating > 0' class='store-rating'>{{ratingNumber(store.avg_rating)}}</span>
                              </p>

                           </div>
                        </div>
                     </div>
                  </div>
               </div>
            </div>
         </div>
      </div>

      <a id='btn-zalo' :class='banner_delivering_active == true ? "add-space" : ""' href="https://zalo.me/0909157151/?appt=D"><img src='<?php echo THEME_URI . '/assets/images/home-zalo-icon.svg'; ?>'></a>

   </div>

   <div v-else>
      <div class='progress-center'>
         <div class='progress-container enabled'><progress class='progress-circular enabled' ></progress></div>
      </div>
   </div>

   <component-location-modal ref='component_location_modal'></component-location-modal>
   <module_get_order_delivering ref='module_get_order_delivering'></module_get_order_delivering>

</div>

<script>

var app = Vue.createApp({
   data (){
      return {
         banner_delivering_active: false,

         popup_filter: false,

         loading: false,
         inputSearch: '',
         latitude: 10.780900239854994,
         longitude: 106.7226271387539,

         notification_count: 0,
         message_count: 0,
         cart_count: 0,

         productRecommend: [],
         storeNearby: [],
         carts: [],

         languages: [
           { id: 'en_US', name: '<?php echo __("English", 'watergo'); ?>'},
           { id: 'vi', name: '<?php echo __("Vietnamese", 'watergo'); ?>'},
           { id: 'ko_KR', name: '<?php echo __("Korean", 'watergo'); ?>'},
         ],

         selectedLanguage: {},
         currentLocale: '',
         showDropdown: false,

         get_locale: '<?php echo get_locale(); ?>',
         
      }
   },

   methods: {

      btn_open_popup_filter(){ this.popup_filter = !this.popup_filter; },

      // 
      splitArray(arr, size) {
         var _arr = arr.slice(0, 10);
         const result = [];
         for (let i = 0; i < _arr.length; i += size) {
            result.push(_arr.slice(i, i + size))
         }
         return result;
      },

      splitArray2(arr, size) {
         var _arr = arr.slice(10, arr.length);
         const result = []
         for (let i = 0; i < _arr.length; i += size) {
            result.push(_arr.slice(i, i + size))
         }
         return result;
      },

      // CHANGE LANGUAGE
      toggleDropdown() { this.showDropdown = !this.showDropdown; },

      selectLanguage(language) {
         if( this.selectedLanguage.id != language.id ){
            this.selectedLanguage = language;
            this.changeLanguage(language.id);
         }
         this.showDropdown = false;
      },

      async changeLanguage(language){
         var form = new FormData();
         form.append('action', 'app_change_language_callback');
         form.append('language', language);
         var r = await window.request(form);
         if( r != undefined ){
            var res = JSON.parse( JSON.stringify(r ));
            if( res.message == 'change_language_successfully' ){
               this.loading = true;
               if( window.appBridge != undefined ){

                  window.appBridge.setLanguage(res.data);
                  window.appBridge.refresh();
               }else{
                  window.location.reload();
               }
            }
         }
      },

      convert_wplang_to_native(l){ return window.convert_wplang_to_native(l)},

      getFlagImage(languageId) {
         if (languageId === 'en_US') {
           return get_template_directory_uri + '/assets/images/flag-us.svg';
         } else if (languageId === 'vi') {
           return get_template_directory_uri + '/assets/images/flag-vi.svg';
         } else if (languageId === 'ko_KR') {
           return get_template_directory_uri + '/assets/images/flag-kr.svg';
         }
         return '';
      },

      async getLocale(){
         var form = new FormData();
         form.append('action', 'get_current_locale_callback');
         var r = await window.request(form);
         if( r != undefined ){
            var res = JSON.parse( JSON.stringify(r ));
            if( res.message == 'current_locale_found' ){
               this.currentLocale = res.data;
               //this.selectLanguage(this.languages.find(language => language.id === this.currentLocale) || this.languages[0]);
            }
         }
      },

      // END CHANGE LANGUAGE

      has_discount( product ){ return window.has_discount( product ); },      
      has_gift( product ){ return window.has_gift( product ); },      
      common_price_show_currency(p){ return window.common_price_show_currency(p) },
      common_price_after_discount(p){ return window.common_price_after_discount(p) },
      
      ratingNumber(rating){ return parseFloat(rating).toFixed(1); },
      mathCeilDistance( distance ){ return parseFloat(distance).toFixed(1); },
      gotoNotificationIndex(){ window.gotoNotificationIndex()},
      gotoSearch(){ window.gotoSearch()},

      gotoProductRecommend(){ window.gotoProductRecommend(); },
      gotoNearbyStore(){ window.gotoNearbyStore() },
      gotoProductWater(){window.gotoProductWater() },
      gotoProductIce(){window.gotoProductIce()},
      gotoProductDetail(product_id){ window.gotoProductDetail(product_id) },
      gotoStoreDetail(store_id){ window.gotoStoreDetail( store_id ) },
      gotoCart(){ window.gotoCart() },
      gotoChat(){ window.gotoChat() },

      async get_current_location(){

         if( window.appBridge != undefined ){
            await window.appBridge.getLocation().then( (data) => {
               if (Object.keys(data).length === 0) {
               }else{
                  let lat = data.lat;
                  let lng = data.lng;
                  this.latitude = data.lat;
                  this.longitude = data.lng;
               }
            });
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

      count_product_in_cart(){ this.cart_count = window.count_product_in_cart(); },

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

      async get_store_nearby(){
         var form = new FormData();
         form.append('action', 'atlantis_get_store_nearby');
         form.append('lat', this.latitude);
         form.append('lng', this.longitude);
         var r = await window.request(form);
         if( r != undefined ){
            var res = JSON.parse( JSON.stringify(r ));
            if( res.message == 'store_location_found' ){
               this.storeNearby.push( ...res.data );
            }
         }
      },

      async atlantis_count_messeage_everytime(){ await window.atlantis_count_messeage_everytime() }

   },

   async created(){

      this.loading = true;
      await this.getLocale();
      setInterval( async () => { await this.atlantis_count_messeage_everytime(); }, 2500);

      this.selectedLanguage = this.languages.find(language => language.id === this.currentLocale) || this.languages[0];

      window.check_cart_is_exists();

      await this.get_current_location();
      await this.get_messages_count();
      await this.get_store_nearby();
      await this.get_notification_count();
      this.count_product_in_cart();

      var form = new FormData();
      form.append('action', 'atlantis_get_product_discount_and_gift');
      form.append('limit', 20);
      var r = await window.request(form);
      if( r != undefined ){
         var res = JSON.parse( JSON.stringify( r));
         if( res.message == 'product_found' ){
            res.data.forEach(item => {
               if (! this.productRecommend.some(existingItem => existingItem.id === item.id)) {
                  this.productRecommend.push( item );
               }
            });
         }
      }
   
      
      jQuery(document).ready(function($){

         jQuery('.slider-container .sliders').slick({
            dots: true,
            arrows: false,
            infinite: true,
            speed: 400,
            slidesToShow: 1,
            slidesToScroll: 1,
            autoplay: true,
            autoplaySpeed: 4000,
         });
      });

      setTimeout(() => {}, 800);
      window.appbar_fixed();
      this.loading = false;

   },

})
.component('component-location-modal', LocationModal)
.component('module_get_order_delivering', module_get_order_delivering)
.mount('#app');

window.app = app;

async function callbackActiveTab(){
   await window.app.get_notification_count();
   window.app.count_product_in_cart();
}
</script>

