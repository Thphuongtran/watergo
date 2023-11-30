<?php

function template_product_category_index(){
   $action = isset($_GET['action']) ? $_GET['action'] : '';

   GLOBAL $wpdb;
   $sql_product_category = "SELECT * FROM wp_watergo_product_category";
   $res_product_category = $wpdb->get_results( $sql_product_category);

   // echo '<pre>';
   // print_r($res_product_category);
   // echo '</pre>';


?>

<script src="https://cdnjs.cloudflare.com/ajax/libs/axios/1.4.0/axios.min.js" integrity="sha512-uMtXmF28A2Ab/JJO2t/vYhlaa/3ahUOgj1Zf27M5rOo8/+fcTUVH0/E0ll68njmjrLqOBjXM3V9NiPFL5ywWPQ==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/vue/3.3.4/vue.global.min.js" integrity="sha512-Wbf9QOX8TxnLykSrNGmAc5mDntbpyXjOw9zgnKql3DgQ7Iyr5TCSPWpvpwDuo+jikYoSNMD9tRRH854VfPpL9A==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<script src='<?php echo THEME_URI . '/assets/js/common.js'; ?>'></script>
<style>
   .table-view-list{
      max-width: 768px;
      width: 100%;
      margin-top: 20px;
   }
   .badge-red{color: red;}
   .category-child{
      padding-left: 30px !important;
   }
   .column-action{
      width: 50px !important;
   }
   
</style>

<div id='app' class='wrap'>

   <?php if( $action == ''){ ?>
   <h1 class="wp-heading-inline"><?php echo __('Product Category', 'watergo'); ?></h1>
   <?php } ?>


   <?php if( $action != 'add' ){ ?>
   <a href="?page=product_category_add" class="page-title-action"><?php echo __('Add Product Category', 'watergo'); ?></a>
   <?php } ?>
   
   <p><button class="button button-primary">Add Category Parent</button></p>

   <table class='wp-list-table widefat fixed striped table-view-list posts'>
      <tr>
         <th class="manage-column column-date"><span><?php echo __('Name Category', 'watergo'); ?></span></th>
         <th class="manage-column column-date"><span><?php echo __('Category', 'watergo'); ?></span></th>
         <th class="manage-column column-date"><span><?php echo __('Has Parent', 'watergo'); ?></span></th>
         <th class="manage-column column-action"><span><?php echo __('Edit', 'watergo'); ?></span></th>
      </tr>

      <template v-for="(cat, catIndex) in product_category_filter" :key="catIndex">
         <!-- Parent Category Row -->
         <tr>
            <td class='title column-title column-primary page-title'>{{ cat.name }}</td>
            <td class='title column-title column-primary page-title'>{{ cat.category }}</td>
            <td class='title column-title column-primary page-title'>
               <span v-if='cat.parent != 0' class='badge-red'>YES</span>
            </td>
            <td class='title column-title column-primary page-title'>
               <p><button class="button button-primary">EDIT</button></p>
            </div>
         </tr>
         <!-- Children Categories Rows -->
         <tr v-for="(childCat, childIndex) in cat.children" :key="'child-' + childIndex">
            <td class='title column-title column-primary page-title category-child'>{{ childCat.name }}</td>
            <td class='title column-title column-primary page-title'>{{ childCat.category }}</td>
            <td class='title column-title column-primary page-title'>
               <span v-if='childCat.parent != 0' class='badge-red'>YES</span>
            </td>
            <td class='title  '>
               <p><button class="button button-primary">EDIT</button></p>
            </div>
         </tr>
      </template>
   </table>

   


</div>

<script>
   
var app = Vue.createApp({
   data(){
      return {
         product_category: []
      }
   },

   computed: {
      product_category_filter() {
        let result = [];
        let topLevelItems = this.product_category.filter(item => item.parent == 0);
        topLevelItems.forEach(parentItem => {
            let children = this.product_category.filter(item => item.parent === parentItem.id);
            result.push({
               ...parentItem,
               children: children
            });
        });
        return result;
      }
   },

   methods: {

   },

   mounted(){

   },

   created(){
      this.product_category = JSON.parse('<?php echo json_encode( $res_product_category); ?>');

      // console.log(this.product_category);

   }
})
.mount('#app');
window.app = app;

</script>

<?php }  ?>