<?php 
/**
 * @access THIS IS TAB PRODUCT STORE 
 */


$tab = isset($_GET['tab']) ? $_GET['tab'] : '';

?>
<style>
   .product-image{
      position: relative;
   }
   .product-image-badge{
      position: absolute;
      bottom: 7px; left: 0;
      width: 46px;
      height: 14px;
      background: #FFC83A;
      color: white;
      font-size: 9px;
      font-weight: 400;
      letter-spacing: 0px;
      text-align: center;
   }
</style>
<div id='app'>
   <div v-show='loading == false' class='page-product-store'>
      <div class='appbar style01'>
         <div class='appbar-top'>
            <div class='leading'>
               <p class='leading-title'><?php echo __('Product', 'watergo'); ?></p>
            </div>
            <div class='action'>
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

               <div @click='gotoNotificationIndex' class='btn-badge ml10'>
                  <svg width="19" height="20" viewBox="0 0 19 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                  <path d="M16.1176 14.6055C16.577 15.3164 17.1289 15.9629 17.7587 16.5281V17.2473H0.826953V16.5278C1.44914 15.9599 1.99356 15.3122 2.44603 14.6015L2.46376 14.5737L2.47879 14.5443C2.99231 13.5401 3.30009 12.4435 3.38408 11.3188L3.38602 11.2928V11.2667L3.38602 8.22777L3.38602 8.22636C3.38312 6.7874 3.9018 5.39615 4.84599 4.31028C5.79017 3.22441 7.09589 2.51751 8.5213 2.32051L9.12547 2.23701V1.6271V0.821239C9.12547 0.789084 9.13824 0.758246 9.16098 0.735511C9.18371 0.712773 9.21455 0.7 9.24671 0.7C9.27886 0.7 9.3097 0.712773 9.33243 0.735509C9.35517 0.758248 9.36795 0.789086 9.36795 0.821239V1.6148V2.23105L9.97923 2.30915C11.4175 2.49291 12.7392 3.19556 13.696 4.28509C14.6527 5.37462 15.1787 6.77603 15.1751 8.22601V8.22777V11.2667V11.2928L15.177 11.3188C15.261 12.4435 15.5688 13.5401 16.0823 14.5443L16.0984 14.5758L16.1176 14.6055Z" stroke="#2790F9" stroke-width="1.4"/>
                  <path d="M7.67493 18.5933C7.72887 18.9832 7.92209 19.3404 8.21891 19.599C8.51572 19.8576 8.89607 20 9.28972 20C9.68337 20 10.0637 19.8576 10.3605 19.599C10.6574 19.3404 10.8506 18.9832 10.9045 18.5933H7.67493Z" fill="#2790F9"/>
                  </svg>
                  <span v-if='notification_count > 0' class='badge badge-notification' :class='notification_count > 0 ? "enable" : "" '>{{notification_count}}</span>
               </div>
            </div>

         </div>

         <div class='appbar-bottom'>

            <ul class='navbar style-expaned' :class='is_single_tab == true ? "single-tab" : "" '>
               <li 
                  @click='product_tab_select(tab.value)'
                  v-for='( tab, index ) in product_tab' :key='index' 
                  :class='[
                     tab.active == true ? "active" : "",
                     tab.shown == false ? "disable" : ""
                  ]'
               >
                  {{ tab.label }}
               </li>
            </ul>

            <div class='box-search box-search-home'>
               <input class='input-search' type="text" v-model='productSearch' placeholder='<?php echo __("Search product", 'watergo'); ?>'>
               <span class='icon-search'>
                  <svg width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                  <path fill-rule="evenodd" clip-rule="evenodd" d="M4.90688 0.60506C5.87126 0.205599 6.90488 0 7.94872 0C8.99256 0 10.0262 0.205599 10.9906 0.60506C11.9549 1.00452 12.8312 1.59002 13.5693 2.32813C14.3074 3.06623 14.8929 3.94249 15.2924 4.90688C15.6918 5.87126 15.8974 6.90488 15.8974 7.94872C15.8974 8.99256 15.6918 10.0262 15.2924 10.9906C14.9914 11.7172 14.5848 12.3938 14.0869 12.999L19.7747 18.6868C20.0751 18.9872 20.0751 19.4743 19.7747 19.7747C19.4743 20.0751 18.9872 20.0751 18.6868 19.7747L12.999 14.0869C12.3938 14.5848 11.7172 14.9914 10.9906 15.2924C10.0262 15.6918 8.99256 15.8974 7.94872 15.8974C6.90488 15.8974 5.87126 15.6918 4.90688 15.2924C3.94249 14.8929 3.06623 14.3074 2.32813 13.5693C1.59002 12.8312 1.00452 11.9549 0.60506 10.9906C0.2056 10.0262 0 8.99256 0 7.94872C0 6.90488 0.2056 5.87126 0.60506 4.90688C1.00452 3.94249 1.59002 3.06623 2.32813 2.32813C3.06623 1.59002 3.94249 1.00452 4.90688 0.60506ZM7.94872 1.53846C7.10691 1.53846 6.27335 1.70427 5.49562 2.02641C4.71789 2.34856 4.01123 2.82073 3.41598 3.41598C2.82073 4.01123 2.34856 4.71789 2.02641 5.49562C1.70427 6.27335 1.53846 7.10691 1.53846 7.94872C1.53846 8.79053 1.70427 9.62409 2.02641 10.4018C2.34856 11.1795 2.82073 11.8862 3.41598 12.4815C4.01123 13.0767 4.71789 13.5489 5.49562 13.871C6.27335 14.1932 7.10691 14.359 7.94872 14.359C8.79053 14.359 9.62409 14.1932 10.4018 13.871C11.1795 13.5489 11.8862 13.0767 12.4815 12.4815C13.0767 11.8862 13.5489 11.1795 13.871 10.4018C14.1932 9.62409 14.359 8.79053 14.359 7.94872C14.359 7.10691 14.1932 6.27335 13.871 5.49562C13.5489 4.71789 13.0767 4.01123 12.4815 3.41598C11.8862 2.82073 11.1795 2.34856 10.4018 2.02641C9.62409 1.70427 8.79053 1.53846 7.94872 1.53846Z" fill="#252831"/>
                  </svg>
               </span>
            </div>

            <div class='product-tab-filter'>
               <div class='product_tab_filter_select'>
                  <div class="icon">
                     <svg width="16" height="14" viewBox="0 0 16 14" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M1.50197e-05 1.08889V0.252778V1.08889ZM1.50197e-05 1.08889C-0.000569119 1.17459 0.0158907 1.25955 0.0484373 1.33883M1.50197e-05 1.08889L0.0484373 1.33883M0.0484373 1.33883C0.0809839 1.41811 0.128968 1.49013 0.189598 1.55069M0.0484373 1.33883L0.189598 1.55069M0.189598 1.55069L6.02293 7.38403L0.189598 1.55069ZM6.55326 6.8537L0.750015 1.05045V0.75H14.8056V1.05531L9.01691 6.84398L8.79724 7.06365V7.37431V12.7887L6.77293 11.7808V7.38403V7.07337L6.55326 6.8537ZM0.719656 1.02009C0.719747 1.02018 0.719838 1.02027 0.719929 1.02036L0.719656 1.02009Z" fill="#2790F9" stroke="#2790F9" stroke-width="1.5"></path></svg>
                  </div>
                  <select v-model='product_tab_filter_select'>
                     <option :value="{ value: ''}" disabled><?php echo __('Filter', 'watergo'); ?></option>
                     <option :value="{ value: 'out_of_stock' }"><?php echo __('Out of Stock', 'watergo'); ?></option>
                     <option :value="{ value: 'available' }"><?php echo __('Available', 'watergo'); ?></option>
                  </select>
               </div>
               <button @click='gotoProductStoreAdd(store_id, get_product_tab_value)' class='btn btn-outline'>
                  <?php 
                     // echo __('Add New', 'watergo'); 
                     if( get_locale() == 'vi' ){
                        echo 'Thêm mới';
                     }else{
                        echo 'Add New';
                     }
                  ?>
               </button>
            </div>

         </div>

      </div>



      <div class='scaffold'>
         <div v-show='loading_data == false'>

            <ul class='list-type-product'>
               <li 
                  v-for='( product, productIndex) in filter_products' :key='productIndex'
                  @click='gotoProductStoreEdit(product.id)'
               >
                  <div class='product-l'>
                     <div class='product-image'>
                        <img :src='product.product_image.url'>
                        <div class='product-image-badge' v-if='is_product_pending(product) != ""'><?php echo __('Pending', 'watergo'); ?></div>
                     </div>
                  </div>

                  <div class='product-r'>
                     <div class='tt1'>{{ product.name }}</div>
                     <div class='tt2'>{{ product_name_compact(product) }}</div>

                     <div class='tt3'>

                        <div 
                           class='gr-price' 
                           :class="has_discount(product) == true ? 'has_discount' : '' ">
                           <span class='price'>{{ common_price_after_discount(product ) }}</span>
                           <span v-show='has_discount(product) == true' class='price-sub'>
                              {{ common_price_show_currency(product.price) }}
                           </span>
                        </div>

                        <!-- <button class="btn-action-view">View</button> -->
                     </div>
                     <div class='tt4'>
                        <div class='product-analytics'>
                           <div class='product-sold'><?php echo __('Sold', 'watergo'); ?>: <span class='t-primary'>{{ product.sold }}</span></div>
                           <!-- <div class='product-stock'>Stock: <span class='t-primary'>{{ product.stock }}</span></div> -->
                        </div>
                        <div class='product-bagde'>
                           <div v-show='product_is_availble(product) == "available" ' class='availble'><?php echo __('Available', 'watergo'); ?></div>
                           <div v-show='product_is_availble(product) == "out_of_stock" ' class='out-of-stock'><?php echo __('Out of Stock', 'watergo'); ?></div>
                        </div>
                     </div>
                  </div>

               </li>
            </ul>
         </div>

         <div v-show='loading_data == true' class='progress-center'>
            <div class='progress-container enabled'><progress class='progress-circular enabled' ></progress></div>
         </div>
      </div>


   </div>

   <div v-show='loading == true'>
      <div class='progress-center'>
         <div class='progress-container enabled'><progress class='progress-circular enabled' ></progress></div>
      </div>
   </div>

</div>

<script>

var app = Vue.createApp({
   data (){
      return {
         loading: false,
         loading_data: false,
         store_id: <?php echo func_get_store_id_from_current_user(); ?>,
         notification_count: 0,
         message_count: 0,
         productSearch: '',

         product_tab_filter_select: { value: '' },

         product_tab: [
            { label: '<?php echo __("Water", 'watergo'); ?>', value: 'water', shown: false, active: false},
            { label: '<?php echo __("Ice", 'watergo'); ?>', value: 'ice', shown: false, active: false}
         ],
         product_tab_value: '',

         products: [],

         test: [],

      }
   },

   computed: {

      is_single_tab(){
         if( this.product_tab[0].shown == false || this.product_tab[1].shown == false  ){
            return true;
         }
         return false;
      },

      get_product_tab_value(){
         var find = this.product_tab.find( item => item.active == true );
         return find.value;
      },
      
      filter_products(){
         var _filter = this.products;
         if(this.product_tab_filter_select.value == 'available'){
            _filter = _filter.filter( p => p.is_availble == true );
         }
         if(this.product_tab_filter_select.value == 'out_of_stock'){
            _filter = _filter.filter( p => p.is_availble == false );
         }
         _filter.sort( (a, b) => b.id - a.id );
         if( this.productSearch != '' ){
            _filter = _filter.filter( p => p.name != null && p.name.toLowerCase().includes( this.productSearch.toLowerCase()) );
         }
         return _filter;
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

      async atlantis_count_messeage_everytime(){ await window.atlantis_count_messeage_everytime() },

      gotoProductStoreAdd(store_id){ 
         var url = window.watergo_domain;
         if( this.product_tab_value == 'ice' ){
            url += 'product/?product_page=product-ice-action&action=add&store_id=' + store_id;
         } else if( this.product_tab_value == 'water' ){
            url += 'product/?product_page=product-water-action&action=add&store_id=' + store_id;
         }
         window.location.href = url + '&appt=N';
      },

      gotoProductStoreEdit( product_id){ 
         var url = window.watergo_domain;
         if( this.product_tab_value == 'ice' ){
            url += 'product/?product_page=product-ice-action&action=edit&product_id=' + product_id;
         } else if( this.product_tab_value == 'water' ){
            url += 'product/?product_page=product-water-action&action=edit&product_id=' + product_id;
         }
         window.location.href = url + '&appt=N';
      },

      async atlantis_get_product_from_store( type ){
         var form = new FormData();
         form.append('action', 'atlantis_get_product_from_store');
         form.append('product_type', type);
         form.append('offset', this.products.length);
         form.append('store_id', this.store_id);
         form.append('limit', 10);
         var r = await window.request(form);
         if( r != undefined){
            var res = JSON.parse( JSON.stringify(r));
            if( res.message == 'product_found'){
               res.data.forEach( product => {
                  if( product.mark_out_of_stock == null ) product.mark_out_of_stock = 0;
                  if( product.mark_out_of_stock == 0 ) {
                     product.is_availble = true;
                  }else{
                     product.is_availble = false;
                  }
                  var _existsProduct = this.products.some( item => item.id == product.id);
                  if( !_existsProduct ){
                     this.products.push( product);
                  }

               });
            }
         }
      },

      update_data_from_callback(product_id, data ){
         var _indexItem = this.products.findIndex( item => item.id == product_id );
         if( _indexItem != -1){
            this.products[_indexItem] = data;
         }else{
            this.products.push( data);
         }
      },
      update_delete_data_from_callback(product_id ){
         var _indexItem = this.products.findIndex( item => item.id == product_id );
         if( _indexItem != -1){
            this.products.splice(_indexItem, 1);
         }
      },

      async handleScroll(){
         const windowTop = window.pageYOffset || document.documentElement.scrollTop;
         const scrollEndThreshold = 50; // Adjust this value as needed
         const scrollPosition = window.pageYOffset || document.documentElement.scrollTop;
         const windowHeight = window.innerHeight;
         const documentHeight = document.documentElement.scrollHeight;
         var windowScroll     = scrollPosition + windowHeight + scrollEndThreshold;
         var documentScroll   = documentHeight + scrollEndThreshold;

         if (scrollPosition + windowHeight >= documentHeight ) {
            await this.atlantis_get_product_from_store( this.product_tab_value );
         }
      },

      async product_tab_select( val ){
         let _do_execute = false;
         if( this.product_tab_value != val ){
            _do_execute = true;
         }
         this.product_tab.some(tab => {
            if( tab.value == val ){ 
               tab.active = true; 
               this.product_tab_value = tab.value;
            }else{ 
               tab.active = false; 
            }
         });

         if( _do_execute == true ){
            this.loading_data = true;
            this.products = [];
            await this.atlantis_get_product_from_store( val );
            this.loading_data = false;
         }
      },

      async get_product_type(){
         var form = new FormData();
         form.append('action', 'atlantis_get_store_type_product');
         form.append('store_id', this.store_id);
         var r = await window.request(form);
         if( r != undefined){
            var res = JSON.parse( JSON.stringify(r));
            if( res.message == 'get_type_product_ok' ){
               var _type = res.data;

               if( _type == 'both' ){
                  this.product_tab[0].active = true;
                  this.product_tab[0].shown = true;
                  this.product_tab[1].shown = true;
               }
               if( _type == 'water' ){
                  this.product_tab[0].active = true;
                  this.product_tab[0].shown = true;
                  this.product_tab[1].shown = false;
               }
               if( _type == 'ice' ){
                  this.product_tab[1].active = true;
                  this.product_tab[0].shown = false;
                  this.product_tab[1].shown = true;
               }
            }
         }
      },

      is_product_pending( product ){
         if( product.status == "pending") return "pending";
         return '';
      },

      product_is_availble( product ){
         // GET STATUS PRODUCT FIRST
         if( product.mark_out_of_stock == null || product.mark_out_of_stock == 0) {
            product.mark_out_of_stock = 0;
            return 'available';
         }
         if( product.mark_out_of_stock == 1 ) return 'out_of_stock';
      },

      has_discount( product ){ return window.has_discount( product ); },
      common_price_show_currency(p){ return common_price_show_currency(p) },
      common_price_after_discount(p){ return common_price_after_discount(p) },

      gotoNotificationIndex(){ window.gotoNotificationIndex()},
      goBack(){ window.goBack()},
      gotoChat(){ window.gotoChat()},

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

   },

   mounted() { window.addEventListener('scroll', this.handleScroll); },
   beforeDestroy() { window.removeEventListener('scroll', this.handleScroll); },

   async created(){

      this.loading = true;
      setInterval( async () => { await this.atlantis_count_messeage_everytime(); }, 1500);
      
      await this.get_product_type();
      await this.get_notification_count();
      
      var _findTabSelected = this.product_tab.find( item => item.active );
      if( _findTabSelected ){
         await this.atlantis_get_product_from_store( _findTabSelected.value );
         this.product_tab_value = _findTabSelected.value;
      }

      setTimeout( () => { 
         this.loading = false;
         window.appbar_fixed();
      }, 200);


   },


}).mount('#app');
window.app = app;
</script>