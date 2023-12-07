<?php 

function template_store_manager_product_pending(){

   $action = isset($_GET['action']) ? $_GET['action'] : '';

   $currency = ' đ';
   if( get_locale() == 'ko_KR' ){
      $currency = '동';
   }

?>
<script type="text/javascript">
   var get_ajaxadmin = "<?php echo admin_url('admin-ajax.php'); ?>";
   var global_currency = "<?php echo $currency; ?>";

</script>
<link defer rel="stylesheet" href="<?php echo THEME_URI . '/assets/js/jquery_ui_1.13.2.min.css'; ?>">
<script defer src="<?php echo THEME_URI . '/assets/js/jquery_ui_1.13.2.min.js'; ?>"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/axios/1.4.0/axios.min.js" integrity="sha512-uMtXmF28A2Ab/JJO2t/vYhlaa/3ahUOgj1Zf27M5rOo8/+fcTUVH0/E0ll68njmjrLqOBjXM3V9NiPFL5ywWPQ==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/vue/3.3.4/vue.global.min.js" integrity="sha512-Wbf9QOX8TxnLykSrNGmAc5mDntbpyXjOw9zgnKql3DgQ7Iyr5TCSPWpvpwDuo+jikYoSNMD9tRRH854VfPpL9A==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<script src='<?php echo THEME_URI . '/assets/js/common.js'; ?>'></script>
<style>

   /* Popup overlay */
   .popup-overlay {
      display: none;
      position: fixed;
      top: 0;
      left: 0;
      width: 100%;
      height: 100%;
      background: rgba(0, 0, 0, 0.7);
      z-index: 999;
   }

   .popup-overlay.open{
      display: block;
   }
   .popup-product-status .popup-content {
      height: 150px;
      display: flex;
      flex-flow: column nowrap;
      justify-content: center;
      align-items: center;
   }
   .popup-product-status .popup-content p {
      font-size: 18px;
   }
   .popup-product-status .popup-content button {
      min-width: 100px;
      margin: 0 5px;
   }
   /* Popup content */
   .popup-content {
      width: 375px;
      height: 80%;
      position: fixed;
      top: 50%;
      left: 50%;
      transform: translate(-50%, -50%);
      background: #fff;
      /* padding: 20px; */
      border-radius: 5px;
      box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.3);
      z-index: 1000;
      text-align: center;
      overflow-y: auto;
   }

   /* Close button */
   .popup-close {
      position: absolute;
      top: 10px;
      right: 10px;
      font-size: 20px;
      cursor: pointer;
   }

   .btn-product{ margin-top: 0px !important; }
   .btn-product button{ margin-right: 15px !important; }
   .popup-action {
      display: flex;
      flex-flow: row nowrap;
      justify-content: center;
      align-items: center;
   }
   .row-title{
      color: #2271b1 !important;
   }
   .list-btn-action{
      display: flex;
      flex-flow: column nowrap;

   }
   .product-appcept{
      margin-bottom: 5px !important;
   }
   .fixed .column-price{
      width: 4%;
   }
   .fixed .column-type-of-product{
      width: 5%;
   }

   .popup-product-status .popup-content {
      height: 150px;
      display: flex;
      flex-flow: column nowrap;
      justify-content: center;
      align-items: center;
   }
   .popup-product-status .popup-content p {
      font-size: 18px;
   }
   .popup-product-status .popup-content button {
      min-width: 100px;
      margin: 0 5px;
   }
   .popup-action {
      display: flex;
      flex-flow: row nowrap;
      justify-content: center;
      align-items: center;
   }

   .fixed .column-price{
      width: 4%;
   }
   .fixed .column-type-of-product{
      width: 5%;
   }

   #wpfooter{display: none;}

   .column-product-pending,
   .fixed .column-product-pending{
      width: 120px;
   }

</style>

<div id='app' class='wrap'>

   <h1 class="wp-heading-inline"><?php echo __('Product Pending', 'watergo'); ?> </h1>

   <!-- TABLE FOR WATER -->
   <h3 class="wp-heading-inline"><?php echo __('Sản Phẩm Nước', 'watergo'); ?></h3>
   <table class='wp-list-table widefat fixed striped table-view-list posts'>
      <tr>
         <th><span><?php echo __('Product Name', 'watergo'); ?></span></th>
         <th><span><?php echo __('Brand', 'watergo'); ?></span></th>
         <th><span><?php echo __('Type of water', 'watergo'); ?></span></th>
         <th><span><?php echo __('Price', 'watergo'); ?></span></th>
         <th><span><?php echo __('Discount', 'watergo'); ?></span></th>
         <th><span><?php echo __('Quantity', 'watergo'); ?></span></th>
         <th><span><?php echo __('Volume', 'watergo'); ?></span></th>
         <th class="column-product-pending "><span><?php echo __('Duyệt Sản Phẩm', 'watergo'); ?></span></th>
      </tr>

      <tr
         v-if='filter_product_water.length > 0'
         v-for='(product, productKey ) in filter_product_water' :key='productKey'
         >
            <td class='row-title'>
               <strong @click='btn_open_view_product(product)'>{{ product.category }}</strong>
         </td>
         <td>{{ product.brand}}</td>
         <td>{{ product.category_parent}}</td>
         <td>{{ common_price_show_currency(product.price) }}</td>
         <td v-html='get_date_discount(product)'></td>
         <td>{{ product.quantity }}</td>
         <td>{{ product.volume }}</td>
         <td>
            <div class='list-btn-action'>
               <button @click='btn_open_modal_pending(product.id, "allow")' class='button button button-primary product-appcept'><?php echo __('Chấp nhận', 'watergo'); ?></button>
               <button @click='btn_open_modal_pending(product.id, "deny")' class='button button-secondary product-deny'><?php echo __('Từ chối', 'watergo'); ?></button>
            </div>
         </td>
      </tr>
      <tr v-else>
         <td colspan='4'> <?php echo __('No products found.', 'watergo');?> </td>
      </tr>

   </table> 

   <!-- TABLE WATER DEVICE -->
   <h3 class="wp-heading-inline"><?php echo __('Sản Phẩm Thiết Bị Nước', 'watergo'); ?></h3>
   <table class='wp-list-table widefat striped table-view-list'>
      <tr>
         <th><span><?php echo __('Product Name', 'watergo'); ?></span></th>
         <th><span><?php echo __('Chức năng', 'watergo'); ?></span></th>
         <th><span><?php echo __('Price', 'watergo'); ?></span></th>
         <th><span><?php echo __('Discount', 'watergo'); ?></span></th>
         <th class="column-product-pending "><span><?php echo __('Duyệt Sản Phẩm', 'watergo'); ?></span></th>
      </tr>
      <tr
         v-if='filter_product_water_device.length > 0'
         v-for='(product, productKey ) in filter_product_water_device' :key='productKey'
      >
         <td class='row-title'>
            <strong class='text-highlight' @click='btn_open_view_product(product)'>{{ product.name }}</strong>
         </td>
         <td>{{ product_ice_compact(product.feature_device) }}</td>
         <td>{{ common_price_show_currency(product.price) }}</td>
         <td v-html='get_date_discount(product)'></td>
         <td>
            <div class='list-btn-action'>
               <button @click='btn_open_modal_pending(product.id, "allow")' class='button button button-primary product-appcept'><?php echo __('Chấp nhận', 'watergo'); ?></button>
               <button @click='btn_open_modal_pending(product.id, "deny")' class='button button-secondary product-deny'><?php echo __('Từ chối', 'watergo'); ?></button>
            </div>
         </td>
      </tr>
      <tr v-else><td colspan='4'> <?php echo __('No products found.', 'watergo');?> </td></tr>
   </table>

   <!-- TABLE ICE -->
   <h3 class="wp-heading-inline"><?php echo __('Sản Phẩm Đá', 'watergo'); ?></h3>
   <table class='wp-list-table widefat fixed striped table-view-list posts'>
      <tr>
         <th><span><?php echo __('Product Name', 'watergo'); ?></span></th>
         <th><span><?php echo __('Price', 'watergo'); ?></span></th>
         <th><span><?php echo __('Discount', 'watergo'); ?></span></th>
         <th><span><?php echo __('Length*Width', 'watergo'); ?></span></th>
         <th><span><?php echo __('Weight', 'watergo'); ?></span></th>
         <th class="column-product-pending "><span><?php echo __('Duyệt Sản Phẩm', 'watergo'); ?></span></th>
      </tr>
      <tr
         v-if='filter_product_ice.length > 0'
         v-for='(product, productKey ) in filter_product_ice' :key='productKey'
      >
         <td class='row-title'>
            <strong class='text-highlight' @click='btn_open_view_product(product)'>{{ product.name }}</strong>
         </td>
         <td>{{ common_price_show_currency(product.price) }}</td>
         <td v-html='get_date_discount(product)'></td>
         <td>{{ product.length_width }} mm</td>
         <td>{{ product.weight }} kg</td>
         <td>
            <div class='list-btn-action'>
               <button @click='btn_open_modal_pending(product.id, "allow")' class='button button button-primary product-appcept'><?php echo __('Chấp nhận', 'watergo'); ?></button>
               <button @click='btn_open_modal_pending(product.id, "deny")' class='button button-secondary product-deny'><?php echo __('Từ chối', 'watergo'); ?></button>
            </div>
         </td>
      </tr>
      <tr v-else><td colspan='4'> <?php echo __('No products found.', 'watergo');?> </td></tr>
   </table>

   <!-- TABLE ICE DEVICE -->
   <h3 class="wp-heading-inline"><?php echo __('Sản Phẩm Thiết Bị Đá', 'watergo'); ?></h3>
   <table class='wp-list-table widefat fixed striped table-view-list posts'>
      <tr>
         <th><span><?php echo __('Product Name', 'watergo'); ?></span></th>
         <th><span><?php echo __('Dung Tích', 'watergo'); ?></span></th>
         <th><span><?php echo __('Price', 'watergo'); ?></span></th>
         <th><span><?php echo __('Discount', 'watergo'); ?></span></th>
         <th class="column-product-pending "><span><?php echo __('Duyệt Sản Phẩm', 'watergo'); ?></span></th>
      </tr>
      <tr
         v-if='filter_product_ice_device.length > 0'
         v-for='(product, productKey ) in filter_product_ice_device' :key='productKey'
      >
         <td class='row-title'>
            <strong class='text-highlight' @click='btn_open_view_product(product)'>{{ product.name }}</strong>
         </td>
         <td><?php echo __('Dung Tích', 'watergo'); ?> {{ product.capacity_device }}</td>
         <td>{{ common_price_show_currency(product.price) }}</td>
         <td v-html='get_date_discount(product)'></td>
         <td>
            <div class='list-btn-action'>
               <button @click='btn_open_modal_pending(product.id, "allow")' class='button button button-primary product-appcept'><?php echo __('Chấp nhận', 'watergo'); ?></button>
               <button @click='btn_open_modal_pending(product.id, "deny")' class='button button-secondary product-deny'><?php echo __('Từ chối', 'watergo'); ?></button>
            </div>
         </td>
      </tr>
      <tr v-else><td colspan='4'> <?php echo __('No products found.', 'watergo');?> </td></tr>
   </table>

   <!-- POPUP UP CHANGE PRODUCT STATUS -->
   <div :class='popup_open_change_product_status == true || popup_open_change_product_status == true ? "open" : "" ' class='popup-overlay popup-product-status'>
      <div class="popup-content">
         <span @click='btn_close_popup(undefined)' class="popup-close">&times;</span>
         <p>Bạn đồng ý muốn duyệt sản phẩm này?</p>
         <div class='popup-action'>
            <button class='button button-secondary' @click='btn_close_popup'>Huỷ</button>
            <button class='button button-primary' @click='btn_change_product_status'>Đồng Ý</button>
         </div>
      </div>
   </div>

   <!-- POPUP VIEW PRODUCT -->
   <div :class='popup_open_view_product == true ? "open" : ""' class='popup-overlay'>
      <div class="popup-content">
         <span @click='btn_close_view_product' class="popup-close">&times;</span>
         <div style='height: 100%'>
            <!--  -->
            <iframe width='100%' height='100%' :src='link_view_product'></iframe>
            <!--  -->
         </div>
      </div>
   </div>

</div>
<script>

var app = Vue.createApp({
   data(){
      return {
         popup_open_change_product_status: false,
         popup_open_view_product: false,

         products: [],
         link_view_product: '',

         product_id: null,
         event: null

      }
   },

   watch: {

   },

   computed: {
      filter_product_water: function(){
         return this.products.filter( item => item.product_type == 'water' );
      },

      filter_product_water_device: function(){
         return this.products.filter( item => item.product_type == 'water_device' );
      },

      filter_product_ice: function(){
         return this.products.filter( item => item.product_type == 'ice' );
      },

      filter_product_ice_device: function(){
         return this.products.filter( item => item.product_type == 'ice_device' );
      }
   },

   methods: {

      product_ice_compact( feature_name ){
         if( feature_name == "Cả 2"){
            return "<?php echo __('Làm nóng và lạnh', 'watergo'); ?>";
         }else {
            return feature_name;
         }
      },

      btn_open_view_product( product ){
         if(product.product_type == 'ice' || product.product_type == 'ice_device' ){
            this.link_view_product = `<?php echo get_bloginfo('url'); ?>/product/?product_page=product-ice-action&action=edit&product_id=${product.id}&view_only=1&appt=N`;
            this.popup_open_view_product = true;
         }
         if(product.product_type == 'water' || product.product_type == 'water_device' ){
            this.link_view_product = `<?php echo get_bloginfo('url'); ?>/product/?product_page=product-water-action&action=edit&product_id=${product.id}&view_only=1&appt=N`;
            this.popup_open_view_product = true;
         }
      },
      btn_close_view_product(){
         this.popup_open_view_product        = false;
         this.link_view_product = '';
      },

      async btn_change_product_status(){
         this.popup_open_change_product_status = false;
         var form = new FormData();
         form.append('action', 'atlantis_change_product_status');
         form.append('product_id', this.product_id);
         form.append('event', this.event);
         var r = await window.request(form);
         if( r != undefined ){
            var res = JSON.parse(JSON.stringify( r));
            if( res.message == 'product_found' ){
               var findIndex = this.products.findIndex( item => item.id == this.product_id );
               this.products.splice(findIndex, 1);

               var user_id = res.notification.user_id
               var text_push_notification = res.notification.text_push_notification
               var link = res.notification.link


               try {
                  var notification_push = new FormData();
                  notification_push.append('action', 'atlantis_push_notification_in_background');
                  notification_push.append('user_id', user_id);
                  notification_push.append('text_push_notification', text_push_notification);
                  notification_push.append('link', link);

                  let requestPromise = await window.request(notification_push);
                  let immediatePromise = new Promise(resolve => resolve());
                  await Promise.race([requestPromise, immediatePromise]);
               } catch (error) {
                  console.error('Error occurred during the request:', error);
               }

            }
         }
      },



      btn_open_modal_pending(product_id, event){
         this.popup_open_change_product_status  = true;
         this.product_id                        = product_id;
         this.event                             = event;
      },

      btn_close_popup(){
         this.popup_open_change_product_status  = false;
         this.product_id                        = null;
         this.event                             = null;
      },
      
      common_price_show_currency(p) { return window.common_price_show_currency(p); },

      check_discount_date( date ){
         if( date != 0 ) return date;
         return '';
      },

      check_has_discount( product ){
         var is_has_discount = window.has_discount(product);
         if( is_has_discount == true ){
            return 'Còn hạn';
         }else{
            return 'Hết hạn';
         }
      },

      get_date_discount( product ){
         var _from   = this.check_discount_date(product.discount_from);
         var _to     = this.check_discount_date(product.discount_to);
         if( _from == '' || _to == '' ) return '<?php echo __('Hết hạn', 'watergo'); ?>';
         var _discount = `  `;
         return `<?php echo __('Từ ngày', 'watergo'); ?> ${_from} <br><?php echo __('Đến ngày', 'watergo'); ?> ${_to}`;
      },

      async atlantis_get_all_product_pending_to_admin_page(){
         var form = new FormData();
         form.append('action', 'atlantis_get_all_product_pending_to_admin_page');
         var r = await window.request(form);
         if( r != undefined ){
            var res = JSON.parse( JSON.stringify( r));
            if( res.message == 'product_found' ){
               this.products.push(...res.data);
            }
         }
      },

   },

   async created(){
      await this.atlantis_get_all_product_pending_to_admin_page();
   }

}).mount('#app');
window.app = app;
</script>
<?php
}