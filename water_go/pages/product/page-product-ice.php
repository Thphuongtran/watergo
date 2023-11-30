<?php 

   global $wpdb;

   $sql_category  = "SELECT * FROM wp_watergo_product_category WHERE category IN ('ice_category') AND (category_hidden != 1 OR category_hidden IS NULL ) ORDER BY wp_watergo_product_category.order ASC"; 
   $category      = $wpdb->get_results($sql_category);

   $sql_category_parent = "SELECT * FROM wp_watergo_product_category WHERE category IN ('type_of_ice') AND (category_hidden != 1 OR category_hidden IS NULL )";
   $category_parent     = $wpdb->get_results($sql_category_parent); 

   foreach($category as $k => $vl ){
      $vl->active = false;

      if( $vl->name == 'Đá bi'){
         $vl->icon = 'icon-da-bi.svg';
         $vl->extraClass = 'ice-1';
      }
      if( $vl->name == 'Đá cục'){
         $vl->icon = 'icon-da-cuc.svg';
         $vl->extraClass = 'ice-2';
      }
      if( $vl->name == 'Đá nghiền'){
         $vl->icon = 'icon-da-nghien.svg';
         $vl->extraClass = 'ice-3';
      }
      if( $vl->name == 'Đá công nghiệp'){
         $vl->icon = 'icon-da-cong-nghiep.svg';
         $vl->extraClass = 'ice-4';
      }
      if( $vl->name == 'Thiết bị đá'){
         $vl->icon = 'icon-thiet-bi-da.svg';
         $vl->extraClass = 'ice-5';
      }
   }


?>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.matchHeight/0.7.2/jquery.matchHeight-min.js" integrity="sha512-/bOVV1DV1AQXcypckRwsR9ThoCj7FqTV2/0Bm79bL3YSyLkVideFLE3MIZkq1u5t28ke1c0n31WYCOrO01dsUg==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<style>
   .grid-masonry{
      padding-bottom: 30px;
   }
   .navbar{
      padding-left: 8px;
   }
   .navbar .text{ white-space: nowrap; }
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
   .navbar li.ice-1{width: 42px;}
   .navbar li.ice-2{width: 56px;}
   .navbar li.ice-3{width: 79px;}
   .navbar li.ice-4{width: 124px;}
   .navbar li.ice-5{width: 85px;}

   .navbar.navbar-icon li.active{ width: auto; border: none; }
   .navbar li:after{
      height: 2px; bottom: 0;
   }
   @media screen and (max-width: 375px){
      .navbar.auto-resize-375 li {
         padding-left: 0px;
         padding-right: 0px;
         padding-top: 0;
      }
   }
   .navbar.navbar-icon li.large-size{ min-width: 110px;}

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

   
   .product-design.product-detail .gr-price{
      display: flex;
      flex-flow: row wrap;
      align-items: flex-end;
   }

   .gr-price{
      display: flex;
      flex-flow: row wrap;
      align-items: flex-end;
   }
   .product-design .price{
      padding-right: 5px;
   }
   .product-design .price-sub{
      margin-left: 0;
      position: relative;
      top: -2px;
   }

   .badge-gift {
      position: relative;
      width: 100%;
   }
   .badge-gift .icon {
      position: absolute;
      top: -2px;
   }
   .badge-gift .text {
      padding-left: 25px;
      line-height: 20px;
   }

   .box-sort li.disabled{
      touch-action: none;
      pointer-events: none;
      opacity: 0.6;
   }
   
</style>
<div id='app'>
   
   <div v-show='loading == false' class='page-product-ice' :class='sortFeatureOpen == true ? "add-overlay" : ""'>
      <div class='appbar style01'>
         <div class='appbar-top'>
            <div class='leading'>
               <button @click='goBack' class='btn-action'>
                  <svg width="11" height="16" viewBox="0 0 11 16" fill="none" xmlns="http://www.w3.org/2000/svg">
                  <path fill-rule="evenodd" clip-rule="evenodd" d="M10.5309 0.375342C10.8759 0.806604 10.806 1.4359 10.3747 1.78091L2.60078 8.00004L10.3747 14.2192C10.806 14.5642 10.8759 15.1935 10.5309 15.6247C10.1859 16.056 9.55657 16.1259 9.12531 15.7809L0.375305 8.78091C0.13809 8.59113 0 8.30382 0 8.00004C0 7.69625 0.13809 7.40894 0.375305 7.21917L9.12531 0.219168C9.55657 -0.125842 10.1859 -0.0559202 10.5309 0.375342Z" fill="#252831"/>
                  </svg>
               </button>
               <p v-show='is_ice_device_selected == false' class='leading-title'><?php echo __('Ice', 'watergo'); ?></p>
               <p v-show='is_ice_device_selected == true' class='leading-title'><?php echo __('Thiết bị đá', 'watergo'); ?></p>
            </div>
            <div @click='buttonSortFeature' class='action'>
               <div id='btn-filter-sort' class='btn-text'>
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
                  <li @click='buttonSortFeatureSelected(0)' 
                     :class='[
                        sortFeatureCurrentValue == 0 ? "active" : "",
                        is_user_share_location == false ? "disabled": "",
                     ]' 
                     class='_outside_handler_clicked'><?php echo __('Nearest', 'watergo'); ?></li>
                  <li @click='buttonSortFeatureSelected(1)' :class='sortFeatureCurrentValue == 1 ? "active" : ""' class='_outside_handler_clicked'><?php echo __('Cheapest', 'watergo'); ?></li>
                  <li @click='buttonSortFeatureSelected(2)' :class='sortFeatureCurrentValue == 2 ? "active" : ""' class='_outside_handler_clicked'><?php echo __('Top Rated', 'watergo'); ?></li>
               </ul>
            </div>

            <div class='box-category'>
               <ul class='navbar auto-resize-375 navbar-icon'>
                  <li
                     :style='{ "min-width": cat.width + "px" }'
                     @click='select_category(cat.name)' 
                     v-for='(cat, index) in category' :key='index' 
                     :class='[
                        cat.active == true ? "active" : "",
                        cat.extraClass
                     ]'>
                     <span class='icon'>
                        <img :src='"<?php echo THEME_URI . '/assets/images/'; ?>" + cat.icon'>
                     </span>
                     <span class='text'>{{ cat.name }}</span>
                  </li>
               </ul>
            </div>

         </div>
      </div>


      <div class='overlay-layer'>
         
         <div class='inner'>
            <div class='scaffold'>

               <div v-show='loading_data == false' class='grid-masonry'>
                  <div 
                     @click='gotoProductDetail(product.id)' 
                     class='product-design' 
                     v-for='(product, index) in filter_products' :key='index'
                     :class='product.product_image.dummy != undefined ? "img-dummy" : "" '
                  >
                     <div class='img'>
                        <img :src='product.product_image.url'>
                        <span v-if='has_discount(product) == true' class='badge-discount'>-{{ product.discount_percent }}%</span>
                     </div>
                     <div class='box-wrapper'>
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
                     </div>
                  </div>
               </div>

               <div v-show='loading_data == true' class='progress-center'>
                  <div class='progress-container enabled'><progress class='progress-circular enabled' ></progress></div>
               </div>

            </div>

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
   data(){
      return{ 
         loading: false,
         loading_data: false,
         
         is_ice_device_selected: false,
         sortFeatureOpen: false,

         sortFeatureCurrentValue: -1,
         latitude: null,
         longitude: null,

         products: [],

         category: [],
         category_parent: [],

         category_id_selected: null,
         category_parent_id_selected: null,

         filter_type_box_open: false,
         is_user_share_location: false,

      }
   },

   computed: {

      get_category_parent(){
         if(this.category_id_selected != null){
            var _findCat = this.category.find( item => item.name == this.category_id_selected );
            if( _findCat ){
               return this.category_parent.filter( item => item.parent == _findCat.id);
            }
         }
         return [];
      },

      filter_products(){
         var _products = this.products;
         if(this.sortFeatureCurrentValue == 2 ){
            // 'Top Rated Filter'
            _products.sort((a, b) => b.avg_rating - a.avg_rating);
         }
         else if(this.sortFeatureCurrentValue == 1 ){
            // 'Top Cheapest'
            _products.sort((a, b) => a.price - b.price);
         }
         else if(this.sortFeatureCurrentValue == 0 ){
            // 'Nearest'
            _products.sort((a, b) => a.distance - b.distance);
         }

         // if( this.category_parent_id_selected != null ){
         //    _products = _products.filter( item => item.category_parent == this.category_parent_id_selected );
         // }

         return _products;
      },
   },

   watch: {
      products: {
         async handler(data) {
            jQuery(document).ready(function($){
               jQuery('.box-wrapper').matchHeight({ property: 'min-height' });
            });
         }, deep: true
      },
   },

   methods: {

      open_filter_type_box(){
         this.filter_type_box_open = !this.filter_type_box_open;
      },

      async get_current_location(){
         try{
            if( window.appBridge != undefined ){
               await window.appBridge.getLocation().then( (data) => {
                  if (Object.keys(data).length === 0) {
                     this.is_user_share_location = false;
                     this.sortFeatureCurrentValue = 1;
                  }else{
                     let lat = data.lat;
                     let lng = data.lng;

                     this.latitude = data.lat;
                     this.longitude = data.lng;

                     this.is_user_share_location = true;
                     this.sortFeatureCurrentValue = 0;
                  }
               });
            }else{
               this.is_user_share_location = false;
               this.sortFeatureCurrentValue = 1;
            }

         }catch(e){
            this.is_user_share_location = false;
            this.sortFeatureCurrentValue = 1;
         }
      },

      has_discount( product ){ return window.has_discount(product); },
      has_gift( product ){ return window.has_gift( product ); },
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

      async select_category(cat_id){

         // toggle active
         this.category.some( cat => { 
            if (cat.name == cat_id) {cat.active = !cat.active;}else{
               cat.active = false;
            }
         });

         var cat_active = this.category.find( cat => cat.active == true );
         if( cat_active == undefined ){
            this.category_id_selected = null;
            this.is_ice_device_selected = false;
         }else{
            if( cat_active.name == "Thiết bị đá"){
               this.is_ice_device_selected = true;
               this.category_id_selected = null;
            }else{
               this.is_ice_device_selected = false;
               this.category_id_selected = cat_active.name;
            }
         }
         
         this.loading_data = true;
         this.products = [];

         await this.atlantis_get_product_sort_version2();
         this.loading_data = false;

      },

      // INIT
      async atlantis_get_product_sort_version2(){

         var form = new FormData();
         form.append('action', 'atlantis_get_product_sort_version2');

         if( this.latitude == null && this.longitude == null ){
            form.append('no_location_found', 1);
            this.sortFeatureCurrentValue = 1;
         }else{
            form.append('lat', this.latitude);
            form.append('lng', this.longitude);
         }

         form.append('paged', this.products.length );
         var _category  = this.category.find(item => item.name == this.category_id_selected );

         if( this.is_ice_device_selected == false ){
            form.append('product_type', 'ice');
         }else{
            form.append('product_type', 'ice_device');
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

      goBack(){ window.goBack(); },
      gotoProductDetail(product_id){ window.gotoProductDetail(product_id)},

      async handleScroll() {
         const windowTop = window.pageYOffset || document.documentElement.scrollTop;
         const scrollEndThreshold = 50; // Adjust this value as needed
         const scrollPosition = window.pageYOffset || document.documentElement.scrollTop;
         const windowHeight = window.innerHeight;
         const documentHeight = document.documentElement.scrollHeight;
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

      this.get_current_location();
      this.loading = true;
      await this.atlantis_get_product_sort_version2();
      this.loading = false;
      window.appbar_fixed();
      
   },
}).mount('#app');

</script>
