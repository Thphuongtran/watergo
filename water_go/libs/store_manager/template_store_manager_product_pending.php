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
</style>

<div id='app' class='wrap'>

   <?php if( $action == ''){ ?>
   <h1 class="wp-heading-inline"><?php echo __('Product Pending', 'watergo'); ?></h1>
   <?php } ?>

   <table class='wp-list-table widefat fixed striped table-view-list posts'>
      <tr>
         <th class="manage-column column-date"><span><?php echo __('Product Name', 'watergo'); ?></span></th>
         <th class="manage-column column-date"><span><?php echo __('Chức năng', 'watergo'); ?></span></th>
         <th class="manage-column column-date"><span><?php echo __('Price', 'watergo'); ?></span></th>
         <th class="manage-column column-date"><span><?php echo __('Discount', 'watergo'); ?></span></th>
      </tr>
      <tr
         v-if='product_ice_device.length > 0'
         v-for='(product, productKey ) in product_ice_device' :key='productKey'
      >
         <td class='title column-title column-primary page-title row-title'>
            <strong class='text-highlight' @click='btn_edit_product(product)'>{{ product.name }}</strong>
         </td>
         <td class='title column-title column-primary page-title'>{{ product.capacity_device }}</td>
         <td class='title column-title column-primary page-title'>{{ common_price_show_currency(product.price) }}</td>
         <td class='title column-title column-primary page-title' v-html='get_date_discount(product)'></td>
      </tr>
   </table>

</div>
<script>

var app = Vue.createApp({
   data(){
      return {

      }
   }
});
window.app = app;

</script>
<?php
}