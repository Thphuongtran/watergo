<?php 
   global $wpdb;

   $sql_category = "SELECT * FROM wp_watergo_product_category
      WHERE category = 'water_category' AND ( category_hidden != 1 || category_hidden IS NULL) 
      ORDER BY wp_watergo_product_category.order ASC
   ";

   $sql_category_parent = "SELECT * FROM wp_watergo_product_category
      WHERE category = 'type_of_water' AND ( category_hidden != 1 || category_hidden IS NULL) 
      ORDER BY wp_watergo_product_category.order ASC";
   $sql_brand      = "SELECT * FROM wp_watergo_product_category WHERE category = 'water_brand' AND ( category_hidden != 1 || category_hidden IS NULL)";


   $category         = $wpdb->get_results($sql_category);
   $category_parent  = $wpdb->get_results($sql_category_parent);
   $brand            = $wpdb->get_results($sql_brand);
   
   foreach($category as $k => $vl ){
      $vl->active = false;

      if( $vl->name == 'Bình vòi'){
         $vl->icon = '<svg width="30" height="30" viewBox="0 0 30 30" fill="none" xmlns="http://www.w3.org/2000/svg">
            <path d="M8.75 27.5C8.0625 27.5 7.47375 27.255 6.98375 26.765C6.49375 26.275 6.24917 25.6867 6.25 25V22.5C6.25 21.8125 6.495 21.2238 6.985 20.7338C7.475 20.2438 8.06334 19.9992 8.75 20V13.75C8.0625 13.75 7.47375 13.505 6.98375 13.015C6.49375 12.525 6.24917 11.9367 6.25 11.25V8.75C6.25 8.0625 6.495 7.47375 6.985 6.98375C7.475 6.49375 8.06334 6.24917 8.75 6.25H12.5V5C12.1458 5 11.8488 4.88 11.6088 4.64C11.3688 4.4 11.2492 4.10334 11.25 3.75C11.25 3.39584 11.37 3.09875 11.61 2.85875C11.85 2.61875 12.1467 2.49917 12.5 2.5H17.5C17.8542 2.5 18.1513 2.62 18.3913 2.86C18.6313 3.1 18.7508 3.39667 18.75 3.75C18.75 4.10417 18.63 4.40125 18.39 4.64125C18.15 4.88125 17.8533 5.00084 17.5 5V6.25H21.25C21.9375 6.25 22.5263 6.495 23.0163 6.985C23.5063 7.475 23.7508 8.06334 23.75 8.75V11.25C23.75 11.9375 23.505 12.5263 23.015 13.0163C22.525 13.5063 21.9367 13.7508 21.25 13.75V20C21.9375 20 22.5263 20.245 23.0163 20.735C23.5063 21.225 23.7508 21.8133 23.75 22.5V25C23.75 25.6875 23.505 26.2763 23.015 26.7663C22.525 27.2563 21.9367 27.5008 21.25 27.5H8.75ZM8.75 25H21.25V22.5H18.75V13.75C18.75 13.75 18.7492 12.9082 18.75 12.5548L18.7656 11.25H21.25V8.75H8.75V11.25H11.25V20H12.5C12.8542 20 13.1513 20.12 13.3913 20.36C13.6313 20.6 13.7508 20.8967 13.75 21.25C13.75 21.6042 13.63 21.9013 13.39 22.1413C13.15 22.3813 12.8533 22.5008 12.5 22.5H8.75V25Z" fill="#2790F9"/>
            <path d="M23.75 22.5V25L25 25C25 25 26 24.7 26 23.6C26 22.5 25 22.5 25 22.5L23.75 22.5Z" fill="#2790F9"/>
            </svg>';
         $vl->extraClass = 'water-1';
      }
      if( $vl->name == 'Bình úp'){
         $vl->icon = '<svg width="30" height="30" viewBox="0 0 30 30" fill="none" xmlns="http://www.w3.org/2000/svg">
            <path d="M21.25 2.5C21.9375 2.5 22.5262 2.745 23.0162 3.235C23.5062 3.725 23.7508 4.31333 23.75 5V7.5C23.75 8.1875 23.505 8.77625 23.015 9.26625C22.525 9.75625 21.9367 10.0008 21.25 10L21.25 16.25C21.9375 16.25 22.5262 16.495 23.0162 16.985C23.5062 17.475 23.7508 18.0633 23.75 18.75V21.25C23.75 21.9375 23.505 22.5262 23.015 23.0162C22.525 23.5062 21.9367 23.7508 21.25 23.75H17.5V25C17.8542 25 18.1512 25.12 18.3912 25.36C18.6312 25.6 18.7508 25.8967 18.75 26.25C18.75 26.6042 18.63 26.9012 18.39 27.1412C18.15 27.3812 17.8533 27.5008 17.5 27.5H12.5C12.1458 27.5 11.8487 27.38 11.6087 27.14C11.3687 26.9 11.2492 26.6033 11.25 26.25C11.25 25.8958 11.37 25.5987 11.61 25.3587C11.85 25.1187 12.1467 24.9992 12.5 25V23.75H8.75C8.0625 23.75 7.47375 23.505 6.98375 23.015C6.49375 22.525 6.24917 21.9367 6.25 21.25V18.75C6.25 18.0625 6.495 17.4737 6.985 16.9837C7.475 16.4937 8.06333 16.2492 8.75 16.25V10C8.0625 10 7.47375 9.755 6.98375 9.265C6.49375 8.775 6.24917 8.18666 6.25 7.5V5C6.25 4.3125 6.495 3.72375 6.985 3.23375C7.475 2.74375 8.06333 2.49916 8.75 2.5L21.25 2.5ZM21.25 5L8.75 5L8.75 7.5L11.25 7.5V16.25H12.5C12.8542 16.25 13.1512 16.37 13.3912 16.61C13.6312 16.85 13.7508 17.1467 13.75 17.5C13.75 17.8542 13.63 18.1512 13.39 18.3912C13.15 18.6312 12.8533 18.7508 12.5 18.75H8.75L8.75 21.25H21.25V18.75H18.75V10H17.5C17.1458 10 16.8487 9.88 16.6087 9.64C16.3687 9.4 16.2492 9.10333 16.25 8.75C16.25 8.39583 16.37 8.09875 16.61 7.85875C16.85 7.61875 17.1467 7.49916 17.5 7.5H21.25V5Z" fill="#2790F9"/>
            </svg>';
         $vl->extraClass = 'water-2';
      }
      if( $vl->name == 'Nước chai'){
         $vl->icon = '<svg width="30" height="30" viewBox="0 0 30 30" fill="none" xmlns="http://www.w3.org/2000/svg">
            <path d="M17.5 7.5C17.8315 7.5 18.1495 7.3683 18.3839 7.13388C18.6183 6.89946 18.75 6.58152 18.75 6.25V5C18.75 4.66848 18.6183 4.35054 18.3839 4.11612C18.1495 3.8817 17.8315 3.75 17.5 3.75H12.5C12.1685 3.75 11.8505 3.8817 11.6161 4.11612C11.3817 4.35054 11.25 4.66848 11.25 5V6.25C11.25 6.58152 11.3817 6.89946 11.6161 7.13388C11.8505 7.3683 12.1685 7.5 12.5 7.5M17.5 7.5H12.5M17.5 7.5V8.725C17.5002 9.25602 17.6887 9.76978 18.032 10.1749C18.3753 10.58 18.8512 10.8502 19.375 10.9375C20.4575 11.1175 21.25 12.0538 21.25 13.15V23.75C21.25 24.413 20.9866 25.0489 20.5178 25.5178C20.0489 25.9866 19.413 26.25 18.75 26.25H11.25C10.587 26.25 9.95107 25.9866 9.48223 25.5178C9.01339 25.0489 8.75 24.413 8.75 23.75V13.15C8.75 12.0538 9.5425 11.1175 10.625 10.9375C11.7075 10.7575 12.5 9.82125 12.5 8.725V7.5M8.75 15H21.25M8.75 22.5H21.25M13.75 18.75H16.25" stroke="#2790F9" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
            </svg>';
         $vl->extraClass = 'water-3';
      }
      if( $vl->name == 'Nước ly'){
         $vl->icon = '<svg width="30" height="30" viewBox="0 0 30 30" fill="none" xmlns="http://www.w3.org/2000/svg">
            <path d="M6.25 5H23.75M6.25 5H5.625M6.25 5L7.5 15M23.75 5H24.375M23.75 5L22.5 15M7.5 15L8.47625 22.81C8.55182 23.4147 8.84569 23.9711 9.30262 24.3743C9.75955 24.7776 10.3481 25.0001 10.9575 25H19.0425C19.6519 25.0001 20.2405 24.7776 20.6974 24.3743C21.1543 23.9711 21.4482 23.4147 21.5237 22.81L22.5 15M7.5 15L10.09 14.1375C10.4512 14.017 10.8351 13.9806 11.2125 14.0311C11.5898 14.0816 11.9507 14.2176 12.2675 14.4288L13.6137 15.325C14.0243 15.5986 14.5066 15.7445 15 15.7445C15.4934 15.7445 15.9757 15.5986 16.3863 15.325L17.7325 14.4288C18.0492 14.2174 18.41 14.0812 18.7874 14.0305C19.1648 13.9798 19.5487 14.016 19.91 14.1363L22.5 15" stroke="#2790F9" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
            </svg>';
         $vl->extraClass = 'water-4';
      }
      if( $vl->name == 'Thiết bị nước'){
         $vl->icon = '<svg width="30" height="30" viewBox="0 0 30 30" fill="none" xmlns="http://www.w3.org/2000/svg">
            <path d="M15.5344 3.52266C15.4684 3.44557 15.3865 3.38369 15.2943 3.34126C15.2021 3.29883 15.1018 3.27686 15.0003 3.27686C14.8988 3.27686 14.7985 3.29883 14.7063 3.34126C14.6141 3.38369 14.5322 3.44557 14.4662 3.52266C12.6111 5.69239 6.5625 13.1936 6.5625 18.75C6.5625 23.9279 9.82266 27.1875 15 27.1875C20.1773 27.1875 23.4375 23.9279 23.4375 18.75C23.4375 13.1936 17.3889 5.69239 15.5344 3.52266ZM15.9375 24.1406C15.8249 24.1409 15.7139 24.1141 15.6138 24.0625C15.5137 24.0109 15.4274 23.936 15.3623 23.8441C15.2972 23.7522 15.2551 23.646 15.2396 23.5345C15.224 23.4229 15.2355 23.3093 15.273 23.2031C15.321 23.0646 15.4114 22.9447 15.5315 22.8605C15.6515 22.7764 15.795 22.7322 15.9416 22.7344C16.8723 22.7324 17.7643 22.3618 18.4224 21.7037C19.0805 21.0456 19.4511 20.1536 19.4531 19.2229C19.451 19.0763 19.4951 18.9327 19.5793 18.8127C19.6635 18.6927 19.7833 18.6022 19.9219 18.5543C20.0281 18.5168 20.1417 18.5053 20.2532 18.5208C20.3648 18.5363 20.471 18.5784 20.5628 18.6436C20.6547 18.7087 20.7296 18.7949 20.7812 18.895C20.8328 18.9951 20.8596 19.1061 20.8594 19.2188C20.858 20.5237 20.339 21.7748 19.4163 22.6975C18.4935 23.6202 17.2424 24.1392 15.9375 24.1406Z" fill="#2790F9"/>
            </svg>';
         $vl->extraClass = 'water-5';
      }
   }


?>
<style>
   .grid-masonry{
      padding-bottom: 30px;
   }
   .navbar .text{ white-space: nowrap; }
   .navbar li{
      cursor: pointer;
   }
   .navbar.navbar-icon li{ width: auto; }
   .navbar.navbar-icon li.active{ width: auto; border: none; }
   .navbar li:after{
      height: 2px; bottom: 0;
   }
   .appbar .btn-text .text{ 
      font-size: 13px;
      font-weight: 500;
      margin-left: 0;
   }
   .filter-type-box {
      display: flex;
      flex-flow: row nowrap;
      align-items: center;
      margin-right: 8px;
      position: relative;
   }
   .filter-type-box .icon{
      height: 18px;
   }
   .filter-type-box .filter-type-placeholder{
      font-size: 13px;
      font-weight: 500;
      color: #2790F9;
      margin-left: 4px;
      position: relative;
      z-index: 8;
      background: none;
      border: none;
      display: flex;
      align-items: center;
   }
   .filter-type-box .filter-type-placeholder .text{
      margin-left: 3px;
   }

   .filter-type-box .filter-modal-wrapper{
      position: absolute;
      z-index: 8;
      width: 152px;
      right: 0; top: 30px;
      display: none;
   }

   .filter-modal-wrapper.active{
      display: block;
   }

   .filter-type-box .filter-modal {
      width: 100%;
      background: white;
      box-shadow: 0 8px 24px 0 #0000001F;
      display: block;
   }
   .filter-type-box .filter-modal .item {
      display: flex;
      flex-flow: column nowrap;
      align-items: center;
      justify-content: center;
      width: 100%;
      height: 38px;
      font-size: 12px;
      font-weight: 400;
   }
   .filter-type-box .filter-modal .item.active {
      background: #2790F9;
      color: white;
   }

   .product-design{
      overflow: hidden;
   }

   .product-design .tt01{
      text-overflow: ellipsis;
      overflow: hidden;
      width: 100%;
      white-space: nowrap;
   }
   .navbar{
      padding-left: 8px;
   }
   .navbar li{
      cursor: pointer;
      padding-left: 0px;
      padding-right: 0px;
      margin-left: 8px;
      margin-right: 8px;
      min-width: auto;
   }
   .navbar.navbar-icon li{
      min-width: auto;
   }
   .navbar li.water-1{width: 62px;}
   .navbar li.water-2{width: 58px;}
   .navbar li.water-3{width: 79px;}
   .navbar li.water-4{width: 59px;}
   .navbar li.water-5{width: 103px;}

   @media screen and (max-width: 375px){
      .navbar.auto-resize-375 li {
         padding-left: 0px;
         padding-right: 0px;
         padding-top: 0;
      }
   }



</style>
<div id='app'>
   <div v-if='loading == false' class='page-product-water' :class='sortFeatureOpen == true ? "add-overlay" : ""'>
      <div class='appbar style01'>
         <div class='appbar-top'>
            <div class='leading'>
               <button @click='goBack' class='btn-action'>
                  <svg width="11" height="16" viewBox="0 0 11 16" fill="none" xmlns="http://www.w3.org/2000/svg">
                  <path fill-rule="evenodd" clip-rule="evenodd" d="M10.5309 0.375342C10.8759 0.806604 10.806 1.4359 10.3747 1.78091L2.60078 8.00004L10.3747 14.2192C10.806 14.5642 10.8759 15.1935 10.5309 15.6247C10.1859 16.056 9.55657 16.1259 9.12531 15.7809L0.375305 8.78091C0.13809 8.59113 0 8.30382 0 8.00004C0 7.69625 0.13809 7.40894 0.375305 7.21917L9.12531 0.219168C9.55657 -0.125842 10.1859 -0.0559202 10.5309 0.375342Z" fill="#252831"/>
                  </svg>
               </button>
               <p v-show='is_water_device_selected == false' class='leading-title'><?php echo __('Water', 'watergo'); ?></p>
               <p v-show='is_water_device_selected == true' class='leading-title'><?php echo __('Thiết bị nước', 'watergo'); ?></p>
            </div>
            <div class='action'>

               <div v-show='is_water_device_selected == false' class='filter-type-box'>

                  <div @click='open_filter_type_box' class='filter-type-placeholder'>
                     <span class='icon'>
                        <svg width="14" height="14" viewBox="0 0 14 14" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <g clip-path="url(#clip0_3436_257)">
                        <path fill-rule="evenodd" clip-rule="evenodd" d="M1.75 2.625C1.75 2.39294 1.84219 2.17038 2.00628 2.00628C2.17038 1.84219 2.39294 1.75 2.625 1.75H11.375C11.6071 1.75 11.8296 1.84219 11.9937 2.00628C12.1578 2.17038 12.25 2.39294 12.25 2.625V3.84183C12.2499 4.15123 12.127 4.44793 11.9082 4.66667L8.75 7.82483V12.1555C8.75002 12.2649 8.72207 12.3725 8.66881 12.468C8.61555 12.5636 8.53875 12.6439 8.4457 12.7014C8.35265 12.7589 8.24644 12.7917 8.13717 12.7966C8.02789 12.8015 7.91917 12.7784 7.82133 12.7295L5.65308 11.6457C5.53197 11.5851 5.4301 11.492 5.35891 11.3768C5.28772 11.2616 5.25 11.1289 5.25 10.9935V7.82483L2.09183 4.66667C1.87303 4.44793 1.75007 4.15123 1.75 3.84183V2.625Z" fill="#2790F9"/>
                        </g>
                        <defs>
                        <clipPath id="clip0_3436_257">
                        <rect width="14" height="14" fill="white"/>
                        </clipPath>
                        </defs>
                        </svg>
                     </span>
                     <span class='text _outside_handler_clicked'><?php echo __('Type of water', 'watergo'); ?></span>
                  </div>

                  <div class='filter-modal-wrapper' :class='filter_type_box_open == true ? "active" : ""'>
                     <div class='filter-modal'>
                        <div 
                           @click='select_category_parent(type_water.name)'
                           v-for='(type_water, type_water_index) in category_parent' :key='type_water_index'
                           class='item _outside_handler_clicked' :class='type_water.active ? "active" : ""'
                        >
                           {{ type_water.name }}
                        </div>
                     </div>
                  </div>

               </div>

               <div @click='buttonSortFeature' class='btn-text'>
                  <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                  <path d="M6 16C6 16.2652 6.10536 16.5196 6.29289 16.7071C6.48043 16.8946 6.73478 17 7 17H17C17.2652 17 17.5196 16.8946 17.7071 16.7071C17.8946 16.5196 18 16.2652 18 16C18 15.7348 17.8946 15.4804 17.7071 15.2929C17.5196 15.1054 17.2652 15 17 15H7C6.73478 15 6.48043 15.1054 6.29289 15.2929C6.10536 15.4804 6 15.7348 6 16ZM8 12C8 12.2652 8.10536 12.5196 8.29289 12.7071C8.48043 12.8946 8.73478 13 9 13H15C15.2652 13 15.5196 12.8946 15.7071 12.7071C15.8946 12.5196 16 12.2652 16 12C16 11.7348 15.8946 11.4804 15.7071 11.2929C15.5196 11.1054 15.2652 11 15 11H9C8.73478 11 8.48043 11.1054 8.29289 11.2929C8.10536 11.4804 8 11.7348 8 12ZM11 9C10.7348 9 10.4804 8.89464 10.2929 8.70711C10.1054 8.51957 10 8.26522 10 8C10 7.73478 10.1054 7.48043 10.2929 7.29289C10.4804 7.10536 10.7348 7 11 7H13C13.2652 7 13.5196 7.10536 13.7071 7.29289C13.8946 7.48043 14 7.73478 14 8C14 8.26522 13.8946 8.51957 13.7071 8.70711C13.5196 8.89464 13.2652 9 13 9H11Z" fill="#2790F9"/>
                  </svg>

                  <span class='text _outside_handler_clicked'><?php echo __('Sort', 'watergo'); ?></span>
               </div>
            </div>
         </div>

         <div class='appbar-bottom'>
            <div v-if='sortFeatureOpen == true' class='box-sort' :class='sortFeatureOpen == true ? "active" : ""'>
               <ul>
                  <li @click='buttonSortFeatureSelected(0)' :class='sortFeatureCurrentValue == 0 ? "active" : ""' class='_outside_handler_clicked'>
                     <?php echo __('Nearest', 'watergo'); ?></li>
                  <li @click='buttonSortFeatureSelected(1)' :class='sortFeatureCurrentValue == 1 ? "active" : ""' class='_outside_handler_clicked'>
                     <?php echo __('Cheapest', 'watergo'); ?></li>
                  <li @click='buttonSortFeatureSelected(2)' :class='sortFeatureCurrentValue == 2 ? "active" : ""' class='_outside_handler_clicked'>
                     <?php echo __('Top Rated', 'watergo'); ?></li>
               </ul>
            </div>

            <ul class='navbar auto-resize-375 navbar-icon'>
               <li @click='select_category(cat.name)' 
                  v-for='(cat, index) in category' :key='index' 
                  :class='[
                     cat.active == true ? "active" : "",
                     cat.extraClass
                  ]'
                  :style='{ "min-width": cat.width + "px" }'
               >
                  <span class='icon' v-html='cat.icon'></span>
                  <span class='text'>{{ cat.name }}</span>
               </li>
            </ul>

            <ul v-show='is_water_device_selected == false' class='navbar brand-resize style01 '>
               <li @click='select_brand(brand.name)' 
                  v-for='(brand, index) in brand' :key='index'
                  :class='brand.active == true ? "active" : ""'>
                  {{ brand.name }}
               </li>
            </ul>

         </div>
      </div>

      <div class='inner'>
         <div class='scaffold'>
            <div v-show='loading_data == false' class='grid-masonry'>
               <div 
                  @click='gotoProductDetail(product.id)' 
                  class='product-design' 
                  v-for='(product, index) in filter_products ' :key='index'
                  :class='product.product_image.dummy != undefined ? "img-dummy" : "" '
               >
                  <div class='img'>
                     <img :src='product.product_image.url'>
                     <span v-if='has_discount(product) == true' class='badge-discount'>-{{ product.discount_percent }}%</span>
                  </div>
                  <div class='box-wrapper'>
                     
                     <p class='tt01'>{{ product.name }} </p>
                     <p class='tt02'>{{ product_name_compact(product) }}</p>

                     <div class='gr-price' :class="has_discount(product) == true ? 'has_discount' : '' ">
                        <span class='price'>
                           {{ common_price_after_discount(product ) }}
                        </span>
                        <span v-if='has_discount(product) == true' class='price-sub'>
                           {{ common_price_show_currency(product.price) }}
                        </span>
                     </div>

                  </div>
               </div>
            </div>

            <div v-show='loading_data == true' class='progress-center'>
               <div class='progress-container enabled'><progress class='progress-circular enabled' ></progress></div>
            </div>
            
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

var { createApp } = Vue;

createApp({
   data(){
      return{

         is_water_device_selected: false,

         loading: false,
         sortFeatureOpen: false,
         sortFeatureCurrentValue: -1,
         latitude: 10.780900239854994,
         longitude: 106.7226271387539,

         products: [],

         category: [],
         category_parent: [],
         brand: [],

         category_id_selected: null,
         category_parent_id_selected: null,
         brand_id_selected: null,

         filter_type_box_open: false,

         arg_get_product: 0,
         loading_data: false,
         
      }
   },

   computed: {

      filter_products(){
         var _products = this.products;
         if(this.sortFeatureCurrentValue == 2 ){
            // Top Rated Filter
            _products.sort((a, b) => b.avg_rating - a.avg_rating);
         }
         else if(this.sortFeatureCurrentValue == 1 ){
            // Top Cheapest
            _products.sort((a, b) => a.price - b.price);
         }
         else if(this.sortFeatureCurrentValue == 0 ){
            // Nearest
            _products.sort((a, b) => a.distance - b.distance);
         }

         if( this.is_water_device_selected == false ){
            _products = _products.filter( item => item.category_parent == this.category_parent_id_selected );
         }

         return _products;
      },
   },

   methods: {

      product_name_compact( product ){
         if( product.name_second == "Cả 2"){
            return "<?php echo __('Làm nóng và lạnh', 'watergo'); ?>";
         }else if( product.product_type == "ice_device"){
            return "<?php echo __('Dung tích', 'watergo') ?> " + product.name_second;
         }else{
            return product.name_second;
         }
      },

      open_filter_type_box(){
         this.filter_type_box_open = !this.filter_type_box_open;
      },

      get_current_location(){
         if( window.appBridge !== undefined ){
            window.appBridge.getLocation().then( (data) => {
               if (Object.keys(data).length === 0) {
                  // alert("Error-1 :Không thể truy cập vị trí");
               }else{
                  let lat = data.lat;
                  let lng = data.lng;
                  this.latitude = data.lat;
                  this.longitude = data.lng;
               }
            }).catch((e) => { })
         }
      },

      has_discount( product ){ return window.has_discount(product); },
      common_price_show_currency(p){ return window.common_price_show_currency(p) },
      common_price_after_discount(p){ return window.common_price_after_discount(p) },

      buttonSortFeatureSelected( index ){
         this.sortFeatureCurrentValue = index;
         this.sortFeatureOpen = false;
         window.bodyScrollToggle('remove');
      },
      buttonSortFeature(){
         this.sortFeatureOpen = !this.sortFeatureOpen;
         window.bodyScrollToggle();
      },

      async select_category(cat_name){
         this.category_id_selected = cat_name;
         this.category.some( cat => { 
            if (cat.name === cat_name) {cat.active = !cat.active;
            } else {cat.active = false;}
         });

         var _itemCategory = this.category.find( item => item.name == cat_name );

         if( _itemCategory && _itemCategory.name == "Thiết bị nước"){
            this.category_parent_id_selected = null;
            this.category_parent.some(item => item.active = false);
            this.brand_id_selected = null;
            this.brand.some(item => item.active = false);
            window.appbar_fixed();
            this.is_water_device_selected    = true;
         }else{
            this.is_water_device_selected = false;
            window.appbar_fixed();
         }
         var _anyCategoryNoActive = this.category.some(item => item.active == true );
         if( _anyCategoryNoActive == false ){
            this.category_id_selected = null;
         }

         this.loading_data = true;
         this.products = [];
         await this.atlantis_get_product_sort_version2();
         this.loading_data = false;

      },
      async select_brand(brand_id){
         this.brand_id_selected = brand_id;
         this.brand.some( brand => { 
            if (brand.name === brand_id) {
               brand.active = !brand.active;
            } else {
               brand.active = false; 
            }
         });
         var _anyExists = this.brand.some(item => item.active == true );
         if(_anyExists == false ){
            this.brand_id_selected = null;
         }
         this.loading_data = true;
         this.products = [];
         await this.atlantis_get_product_sort_version2();
         this.loading_data = false;
      },
      select_category_parent( type_of_water_id ){
         this.open_filter_type_box();
         this.category_parent_id_selected = type_of_water_id;
         this.category_parent.some( cat => { 
            if (cat.name === type_of_water_id) {
               cat.active = !cat.active;
            } else {
               cat.active = false; 
            }
         });
         var _anyExists = this.category_parent.some(item => item.active == true );
         if(_anyExists == false ){
            this.category_parent_id_selected = null;
         }
      },

      async handleScroll() {
         const windowTop            = window.pageYOffset || document.documentElement.scrollTop;
         const scrollEndThreshold   = 50; // Adjust this value as needed
         const scrollPosition       = window.pageYOffset || document.documentElement.scrollTop;
         const windowHeight         = window.innerHeight;
         const documentHeight       = document.documentElement.scrollHeight;
         // const documentHeight       = window.pageYOffset;
         var windowScroll     = scrollPosition + windowHeight + scrollEndThreshold;
         var documentScroll   = documentHeight + scrollEndThreshold;

         if (scrollPosition + windowHeight >= documentHeight ) {
            await this.atlantis_get_product_sort_version2();
         }
      },

      // HANDLE CLICK OUTSIDE
      handleClickOutside(e){
         var el            = jQuery(e.target);
         if( el.hasClass('_outside_handler_clicked') == false ){
            this.filter_type_box_open = false;
            this.sortFeatureOpen = false;
         }
      },

      goBack(){ window.goBack(); },
      gotoProductDetail(product_id){ window.gotoProductDetail(product_id)},

      async atlantis_get_product_sort_version2( ){
         var form = new FormData();
         form.append('action', 'atlantis_get_product_sort_version2');
         form.append('lat', this.latitude);
         form.append('lng', this.longitude);
         form.append('paged', this.products.length);

         var _category  = this.category.find(item => item.name == this.category_id_selected );
         var _brand     = this.brand.find(item => item.name == this.brand_id_selected );
         
         if( this.is_water_device_selected == false ){
            form.append('product_type', 'water');
            // if(this.category_parent_id_selected != 0 ){
            //    form.append('category_parent', this.category_parent_id_selected);
            // }
            if(this.brand_id_selected != null ){
               form.append('brand', _brand.name);
            }
         }else{
            form.append('product_type', 'water_device');
            form.append('brand', 0);
         }

         if(this.category_id_selected != null ){
            form.append('category', _category.name);
         }
         
         var r = await window.request(form);

         if( r != undefined ){
            var res = JSON.parse( JSON.stringify(r));
            if( res.message == 'product_found' ){
               res.data.forEach(item => {
                  if (!this.products.some(existingItem => existingItem.id === item.id)) {
                     this.products.push(item);
                  }
               });
            }
         }
      },

   },

   mounted() {
      window.addEventListener('scroll', this.handleScroll);
      document.addEventListener('click', this.handleClickOutside);
   },
   beforeDestroy() {
      window.removeEventListener('scroll', this.handleScroll);
      document.removeEventListener('click', this.handleClickOutside);
   },


   async created(){

      this.category           = JSON.parse(JSON.stringify(<?php echo json_encode($category, true); ?>));
      // THIS IS FILTER FOR CATEGORY
      this.category_parent    = JSON.parse(JSON.stringify(<?php echo json_encode($category_parent, true); ?>));
      this.brand              = JSON.parse(JSON.stringify(<?php echo json_encode($brand, true); ?>));
         
      this.get_current_location();
      this.loading = true;
      await this.atlantis_get_product_sort_version2();

      this.loading = false;

      window.appbar_fixed();


   },

}).mount('#app');

</script>