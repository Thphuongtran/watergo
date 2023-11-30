<?php 
function template_store_manager_index(){
   $action = isset($_GET['action']) ? $_GET['action'] : '';

   $total_store = 0;
   global $wpdb;
   $sql_get_total_store = "SELECT COUNT(*) as total_store FROM wp_watergo_store WHERE store_hidden != 1";
   $res_get_total_store = $wpdb->get_results( $sql_get_total_store);
   if( $res_get_total_store[0]->total_store != null || $res_get_total_store[0]->total_store != 0 || $res_get_total_store[0]->total_store != "" ){
      $total_store = $res_get_total_store[0]->total_store;
   }

   $currency = ' đ';
   if( get_locale() == 'ko_KR' ){
      $currency = '동';


   }
?>
<script type="text/javascript">
   var get_ajaxadmin = "<?php echo admin_url('admin-ajax.php'); ?>";
   var global_currency = "<?php echo $currency; ?>";
</script>


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

   .subsubsub{
      display: flex;
      flex-flow: row nowrap;
      align-items: center;
      margin-bottom: 10px;
   }
   .subsubsub button{
      top: initial !important;
   }
   .t-red{ color: red; }
   .wp-pwd{
      margin-top: 0;
   }
   .pac-logo:after{display: none}
   .form-group input{font-size: 16px;}
   .form-group .btn{line-height: 38px;}
   .form-group input:disabled{  opacity: 0.6;}

   .mr15{
      margin-right: 15px;
   }
   .avatar-header {
	   text-align: center;
   }
   .avatar-header img {
      width: 70px;
      height: 70px;
      border-radius: 100%;
   }
   .avatar-header input {
      display: none;
   }
   .avatar-header.style02 svg {
      width: 100%;
   }
   .avatar-header .upload-avatar.style02.has-preview {
      width: 100%;
      display: block;
   }
   .avatar-header .upload-avatar.style02.has-preview svg {
      display: none;
   }
   .avatar-header .upload-avatar.style02.has-preview img {
      height: auto;
      width: 100%;
      border-radius: 0;
   }
   /* .ui-datepicker{
      font-family: "Be Vietnam Pro",sans-serif;
      line-height: 1.7;
      -webkit-font-smoothing: antialiased;
      -moz-osx-font-smoothing: grayscale;
      max-width: 388px !important;
      width: 90%;
   }
   .ui-date-picker-wrapper {
      position: fixed;
      top: 0;
      left: 0;
      width: 100%;
      height: 100%;
      background: rgba(0, 0, 0, 0.2);
      display: none;
      z-index: 888888;
   }
   
   .ui-datepicker th{
      font-size: 14px;
      font-weight: 500;
      padding-bottom: 0;
   }
   .ui-date-picker-wrapper.active {
      display: block;
   }
   .ui-date-picker-wrapper #ui-datepicker-div {
      position: absolute;
      top: 50% !important;
      left: 50% !important;
      transform: translate(-50%, -50%);
      border: none;
      box-shadow: 0px 2px 10px 0px #00000029;
      border-radius: 5px;
   }
   .ui-datepicker .ui-datepicker-header {
      background: none;
      border: none;
      padding: 8px 8px 0;
      padding-left: 12px;
      display: flex;
      flex-flow: row nowrap;
      align-items: center;
   }
   .ui-datepicker .ui-datepicker-prev span,
   .ui-datepicker .ui-datepicker-next span {
      display: none;
   }
   .ui-datepicker .ui-datepicker-title {
      text-align: left;
      margin: 0;
      background: none;
      color: #2790F9;
      font-size: 16px;
      font-weight: 500;
   }
   
   .ui-datepicker .ui-datepicker-next:after {
      position: absolute;
      content: '';
      background-image: url("data:image/svg+xml;charset=utf8,%3Csvg width='8' height='14' viewBox='0 0 8 14' fill='none' xmlns='http://www.w3.org/2000/svg'%3E%3Cpath d='M1 13.0389L7 7.18308L1 1.32723' stroke='%23252831' stroke-width='1.5' stroke-linecap='round' stroke-linejoin='round'/%3E%3C/svg%3E");
      width: 8px;
      height: 14px;
      background-repeat: no-repeat;
      background-size: contain;
   }

   .ui-datepicker .ui-datepicker-prev:after {
      position: absolute;
      content: '';
      background-image: url("data:image/svg+xml;charset=utf8,%3Csvg width='8' height='14' viewBox='0 0 8 14' fill='none' xmlns='http://www.w3.org/2000/svg'%3E%3Cpath d='M7 13.0389L1 7.18308L7 1.32723' stroke='%23252831' stroke-width='1.5' stroke-linecap='round' stroke-linejoin='round'/%3E%3C/svg%3E");
      width: 8px;
      height: 14px;
      background-repeat: no-repeat;
      background-size: contain;
   }


   .ui-datepicker .ui-datepicker-prev, 
   .ui-datepicker .ui-datepicker-next{
      width: 20px;
      height: 20px;
      top: 12px;
      left: initial;
   }

   .ui-datepicker .ui-datepicker-prev{
      right: 25px;
   }
   .ui-datepicker .ui-datepicker-next{
      right: 0;
   }

   .ui-datepicker .ui-datepicker-title{ order: 1; }
   .ui-datepicker .ui-datepicker-prev{ order: 2; } 
   .ui-datepicker .ui-datepicker-next{ order: 3; }

   .ui-state-default, 
   .ui-widget-content .ui-state-default, 
   .ui-widget-header .ui-state-default, .ui-button, 
   html .ui-button.ui-state-disabled:hover, 
   html .ui-button.ui-state-disabled:active{

   }

   .ui-state-disabled{
      color: #BDBDBD;
   }

   .ui-datepicker td{
      padding: 0;
      padding: 4px;
   }

   .ui-state-default, 
   .ui-widget-content .ui-state-default, 
   .ui-widget-header .ui-state-default, .ui-button, 
   html .ui-button.ui-state-disabled:hover, 
   html .ui-button.ui-state-disabled:active{
      border: none;
      padding: 0;
      text-align: center;
      font-size: 14px;
      font-weight: 400;
      background: none;
      
      
   }

   .ui-state-highlight,
   .ui-state-active,
   .ui-widget-content .ui-state-highlight,
   .ui-widget-header .ui-state-highlight {
      color: white;
      position: relative;
      z-index: 1;
   }
   .ui-state-highlight:after,
   .ui-state-active:after,
   .ui-widget-content .ui-state-highlight:after,
   .ui-widget-header .ui-state-highlight:after {
      content: '';
      position: absolute;
      z-index: -1;
      width: 26px;
      height: 26px;
      background: #2790F9;
      left: 50%;
      top: -2px;
      transform: translateX(-50%);
      border-radius: 25px;
   }
   

   .ui-date-picker-wrapper.schedule-datepicker .ui-state-highlight {
      color: #454545 !important;
   }
   .ui-date-picker-wrapper.schedule-datepicker .ui-state-active{
      color: white !important;
   }
   .ui-date-picker-wrapper.schedule-datepicker .ui-state-active:before {
      content: '';
      position: absolute;
      z-index: -1;
      width: 26px;
      height: 26px;
      background: #2790F9;
      left: 50%;
      top: -2px;
      transform: translateX(-50%);
      border-radius: 25px;
   }
   .ui-date-picker-wrapper.schedule-datepicker .ui-state-highlight:after {
      display: none;
   }


   .ui-date-picker-wrapper.order-product .ui-state-highlight {
      color: #454545 !important;
   }
   .ui-date-picker-wrapper.order-product .ui-state-active{
      color: white !important;
   }
   .ui-date-picker-wrapper.order-product .ui-state-active:before {
      content: '';
      position: absolute;
      z-index: -1;
      width: 26px;
      height: 26px;
      background: #2790F9;
      left: 50%;
      top: -2px;
      transform: translateX(-50%);
      border-radius: 25px;
   }
   .ui-date-picker-wrapper.order-product .ui-state-highlight:after {
      display: none;
   }

   .ui-date-picker-wrapper.order-product .ui-state-hover{
      position: relative !important;
      color: white !important;
   }
   .ui-date-picker-wrapper.order-product .ui-state-hover:before{
      content: '';
      position: absolute;
      z-index: -1;
      width: 26px;
      height: 26px;
      background: #2790F9;
      left: 50%;
      top: -2px;
      transform: translateX(-50%);
      border-radius: 25px;
   }

   .ui-date-picker-wrapper.datepicker-order-product .ui-datepicker-today a {
      color: #454545;
   }
   .ui-date-picker-wrapper.datepicker-order-product .ui-datepicker-today a:after {
      display: none;
   }
   .ui-date-picker-wrapper.datepicker-order-product .ui-datepicker-current-day a {
      color: white;
   }
   .ui-date-picker-wrapper.datepicker-order-product .ui-datepicker-current-day a:after {
      display: block;
      content: '';
      position: absolute;
      z-index: -1;
      width: 26px;
      height: 26px;
      background: #2790F9;
      left: 50%;
      top: -2px;
      transform: translateX(-50%);
      border-radius: 25px;
   } */

   .product-store-view-form select,
   .product-store-view-form input,
   .product-store-view-form textarea {
      width: 100%;
      border: none;
      background: #F5F5F5;
      outline: none;
      border-radius: 8px;
      padding: 0 10px;
      font-size: 16px;
      font-weight: 400;
   }
   .product-store-view-form select::placeholder,
   .product-store-view-form input::placeholder,
   .product-store-view-form textarea::placeholder {
      color: #7B7D83;
      font-size: 16px;
      font-weight: 400;
   }
   .product-store-view-form select {
      height: 44px;
      padding: 0 10px;
      font-size: 16px;
      font-weight: 400;
      color: #252831;
      appearance: none;
      outline: none;
      border: none;
   }
   .product-store-view-form select:focus {
      color: #252831;
      outline: none;
      border: none;
      box-shadow: none;
   }
   .product-store-view-form select:hover{
      color: #252831;
   }
   .product-store-view-form select:disabled {
      color: #252831;
   }
   .product-store-view-form .form-select {
      position: relative;
   }
   .product-store-view-form .form-select .icon-select {
      position: absolute;
      top: 50%;
      right: 15px;
      transform: translateY(-50%);
   }
   .product-store-view-form textarea {
      padding: 10px;
      height: 125px;
      resize: none;
      font-size: 16px;
      font-weight: 400;
      overflow-y: hidden;
   }
   .product-store-view-form input:focus{
      border: none;
      outline: none;
      box-shadow: none;
   }
   .product-store-view-form input[type='checkbox'] {
      border-radius: 5px;
      width: 26px;
      height: 26px;
      border: 1px solid #A2A2A2;
      background: none;
   }
   .product-store-view-form .form-checkbox {
      padding: 0;
   }
   .product-store-view-form .form-checkbox label {
      padding: 0;
      display: flex;
      align-items: center;
      flex-flow: row nowrap;
   }
   .product-store-view-form .form-checkbox input {
      border: 1px solid #A2A2A2;
      background: none;
      top: initial;
   }
   .product-store-view-form .form-checkbox .text {
      font-weight: 500;
      font-size: 16px;
      color: #252831;
      margin-left: 10px;
   }
   .product-store-view-form .form-checkbox.check-discount {
      margin-bottom: 32px;
      margin-top: 24px;
      width: 120px;
   }
   .product-store-view-form .form-checkbox.check-out-of-stock {
      margin: 10px 0;
   }
   .product-store-view-form input {
      height: 44px;
   }
   .product-store-view-form .form-title {
      color: #252831;
      font-weight: 500;
      font-size: 16px;
      margin-bottom: 5px;
      text-align: left;
   }
   .product-store-view-form .form-title.small-size {
      font-weight: 400;
      font-size: 14px;
      margin-bottom: 0;
   }
   .product-store-view-form .form-control {
      margin-bottom: 15px;
   }
   .product-store-view-form .group-form-control {
      display: flex;
      flex-flow: row nowrap;
      justify-content: space-between;
   }
   .product-store-view-form .group-form-control .form-control {
      width: 48%;
   }
   .product-store-view-form .form-photo {
      display: flex;
      flex-flow: row wrap;
      margin-bottom: 30px;
   }
   .product-store-view-form .form-photo .upload {
      position: relative;
   }
   .product-store-view-form .form-photo .upload input {
      display: none;
   }
   .product-store-view-form .form-photo .upload span {
      width: 100%;
      text-align: center;
      position: absolute;
      color: #2790F9;
      font-size: 14px;
      font-weight: 400;
      top: 50%;
      left: 50%;
      transform: translate(-50%, -50%);
      white-space: wrap;
   }
   .product-store-view-form .form-photo li {
      width: 104px;
      height: 107px;
      margin-right: 10px;
      margin-bottom: 10px;
   }
   .product-store-view-form .form-photo li img {
      width: 100%;
      height: 100%;
      object-fit: cover;
   }
   .product-store-view-form .form-photo li.image {
      position: relative;
   }
   .product-store-view-form .form-photo li.image button {
      width: 16px;
      height: 16px;
      position: absolute;
      background: none;
      right: 6px;
      top: 6px;
      outline: none;
      border: none;
   }
   .product-store-view-form .form-button {
      width: 90%;
      margin: 35px auto;
   }
   .product-store-view-form .form-button button {
      margin-bottom: 10px;
      height: 40px;
      line-height: 40px;
   }
   /*  */

   .form-type-length-width {
      height: 44px;
      padding: 0 10px;
      background: #F5F5F5;
      outline: none;
      border-radius: 8px;
      overflow: hidden;
      position: relative;
      z-index: 1;
      display: flex;
      flex-flow: row nowrap;
   }
   .form-type-length-width .placeholder {
      color: #7B7D83;
      font-size: 16px;
      font-weight: 400;
   }
   .form-type-length-width .form-type-length-width-wrapper {
      display: flex;
      flex-flow: row nowrap;
      align-items: center;
      z-index: 2;
      position: absolute;
      width: 100%;
      padding: 0 8px;
      line-height: 1.7;
      height: 42px;
      left: 0;
   }
   .form-type-length-width .type-length,
   .form-type-length-width .type-width {
      text-align: center;
      background: none;
      width: 55px;
      padding: 0 6px;
   }
   .form-type-length-width .type-length::placeholder,
   .form-type-length-width .type-width::placeholder {
      color: #7B7D83;
      font-size: 16px;
      font-weight: 400;
      font-family: "monospace", sans-serif;
   }
   .form-type-length-width .type-length {
      padding-left: 0;
   }
   .product-store-view-form .form-button button{
      width: 100%;
      margin-bottom: 10px;
      height: 40px;
      line-height: 40px;
      background: #2790F9;
      border: 1px solid #2790F9;
      color: white;
      font-weight: 700;
      font-size: 16px;
      text-align: center;
      display: block;
      text-decoration: none;
      border-radius: 8px;
   }

   .product-store-view-form .form-button button.disable{
      opacity: 0.5;
   }

   .ui-state-default:focus{
      box-shadow: none;
      outline: none;
   }

   iframe{
      height: 100%;
   }

   .text-highlight{
      color: #2271b1;
      font-weight: 600;
      cursor: pointer;
   }

   .text-highlight:hover{
      color: #135e96;
   }

   .box-search-store{
      width: 100%;
      display: flex;
      flex-flow: row nowrap;
      margin-bottom: 15px;
   }
   .box-search-store input{
      margin-right: 10px;
   }

   .pagination-links .first-page,
   .pagination-links .prev-page{
      margin-right: 3px !important;
   }
   .pagination-links .next-page,
   .pagination-links .last-page{
      margin-left: 3px !important;
   }

   .watergo-pagination {
      margin-top: 10px;
      display: flex;
      flex-flow: row wrap;
   }
   .watergo-pagination button {
      display: inline-block;
      vertical-align: baseline;
      min-width: 30px;
      min-height: 30px;
      margin: 0;
      padding: 0 4px;
      font-size: 16px;
      line-height: 1.625;
      text-align: center;
      color: #2271b1;
      border: 1px solid #2271b1;
      background: #f6f7f7;
      outline: none;
      border-radius: 3px;
      appearance: none;
      margin-right: 4px;
      margin-bottom: 4px;
      cursor: pointer;
   }
   .watergo-pagination button:hover {
      background: #f0f0f1;
      border-color: #0a4b78;
      color: #0a4b78;
   }
   .watergo-pagination button.current-page {
      pointer-events: none;
      color: #a7aaad!important;
      border-color: #dcdcde!important;
      background: #f6f7f7!important;
      box-shadow: none!important;
      cursor: default;
      transform: none!important;
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
   .fixed .column-product-pending{
      width: 5%;
   }

   #wpfooter{display: none;}

   .button-primary.disabled{
      pointer-events: none !important;
   }

   </style>

<link defer rel="stylesheet" href="<?php echo THEME_URI . '/assets/js/jquery_ui_1.13.2.min.css'; ?>">
<script defer src="<?php echo THEME_URI . '/assets/js/jquery_ui_1.13.2.min.js'; ?>"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/axios/1.4.0/axios.min.js" integrity="sha512-uMtXmF28A2Ab/JJO2t/vYhlaa/3ahUOgj1Zf27M5rOo8/+fcTUVH0/E0ll68njmjrLqOBjXM3V9NiPFL5ywWPQ==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/vue/3.3.4/vue.global.min.js" integrity="sha512-Wbf9QOX8TxnLykSrNGmAc5mDntbpyXjOw9zgnKql3DgQ7Iyr5TCSPWpvpwDuo+jikYoSNMD9tRRH854VfPpL9A==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<script src='<?php echo THEME_URI . '/assets/js/common.js'; ?>'></script>

<div id='app' class='wrap'>

   <?php if( $action == ''){ ?>
   <h1 class="wp-heading-inline"><?php echo __('Store Manager', 'watergo'); ?></h1>
   <?php } ?>
   <?php if( $action == 'edit'){ ?>
   <h1 class="wp-heading-inline"><?php echo __('Edit Store', 'watergo'); ?></h1>
   <?php } ?>
   <?php if( $action == 'add'){ ?>
   <h1 class="wp-heading-inline"><?php echo __('Add Store', 'watergo'); ?></h1>
   <?php } ?>
   
   <?php if( $action != 'add' ){ ?>
   <a href="?page=store_manager_add&action=add" class="page-title-action"><?php echo __('Add Store', 'watergo'); ?></a>
   <?php } ?>

   <hr class="wp-header-end">
   <?php if( $action == '' ){  ?>

   <ul class="subsubsub">
      <li class="all"><a href="?page=store_manager_index" class="current" aria-current="page"><?php echo __('All', 'watergo'); ?> <span class="count">({{ total_store }})</span></a></li>
      <li>
         <button @click='hidden_store' class="page-title-action"><?php echo __('Hide Store', 'watergo'); ?></button>
      </li>
   </ul>

   <div class='box-search-store'>
	   <input type="search" v-model='search_store_name'>
      <button @click='search_store' class='button'><?php echo __('Search Store', 'watergo'); ?></button>
   </div>

   <table class='wp-list-table widefat fixed striped table-view-list posts'>
      <tr>
         <th id="cb" class="manage-column column-cb check-column">
            <label class="label-covers-full-cell" for="cb-select-all">
               <span class="screen-reader-text"><?php echo __('Select All', 'watergo'); ?></span>
            </label>
            <input @input='select_all_store' id="cb-select-all" type="checkbox" :checked='is_select_all'>
         </th>

         <th class="manage-column column-title"><span><?php echo __('Store Name', 'watergo'); ?></span></th>
         <th class="manage-column column-date"><span><?php echo __('Owner', 'watergo'); ?></span></th>
         <th class="manage-column column-date"><span><?php echo __('Email', 'watergo'); ?></span></th>
         <th class="manage-column column-date"><span><?php echo __('Product', 'watergo'); ?> Type</span></th>
      </tr>

      <tr 
         v-if='stores.length > 0'
         v-for='(store, storeKey ) in stores ' :key='storeKey'
      >
         <th scope="row" class="check-column">			
            <input @click='select_store(store.id)' type="checkbox" :checked='store.is_select == true ? true : false'>
         </th>

         <td class='title column-title has-row-actions column-primary page-title'>
            <a class='row-title' :href=" '?page=store_manager_index&store_id=' + store.id + '&action=edit' "> {{ store.name }} </a>
         </td>
         <td class='title column-title has-row-actions column-primary page-title'>
            {{ store.owner }}
         </td>
         <td class='title column-title has-row-actions column-primary page-title'>
            {{ store.email }}
         </td>
         <td class='title column-title has-row-actions column-primary page-title'>
            {{ store.store_type }}
         </td>

      </tr>

      <tr v-else>
         <td colspan='4'> <?php echo __('No stores found.', 'watergo'); ?> </td>
      </tr>

   </table>


   <div class='watergo-pagination'>
      <button @click='pagination_prev_page' :class="currentPage <= 1 ? 'current-page' : '' ">‹</button>

      <button v-for="page in pages" :key="page" @click="goToPage(page)" :class="{ 'current-page': page == currentPage }">
         {{ page }}
      </button>

      <button @click='pagination_next_page' :class="currentPage >= pages ? 'current-page' : '' ">›</button>
   </div>


   </div>

   <?php } ?>
   <!-- END LOAD STORES -->

   <!-- EDIT STORE -->
   <?php if( $action == 'edit' ){ ?> 
   <table class='form-table'>

      <tr>
         <th><?php echo __('Store Avatar', 'watergo'); ?></th>

         <td>
            <div class='avatar-header style02 regular-text'>
               <label style="position: relative;display: block;" for='uploadAvatar' class='upload-avatar style02'  :class='previewAvatar != null ? "has-preview" : ""'>
                  
                  <svg v-if='previewAvatar == null' width="388" height="181" viewBox="0 0 388 181" fill="none" xmlns="http://www.w3.org/2000/svg">
                  <rect width="388" height="180" rx="8" fill="#F9F9F9"/>
                  <circle cx="194" cy="90" r="35" fill="#ECECEC"/>
                  <rect x="179.529" y="86.9199" width="28" height="18.0197" rx="1" fill="white" stroke="#C9C9C9" stroke-width="2"/>
                  <path d="M210.356 83.0991L210.356 83.0988L206.451 76.4675L206.45 76.4659C206.271 76.1609 205.971 76 205.682 76H181.374C181.085 76 180.785 76.1609 180.607 76.4659L180.606 76.4675L176.701 83.0986C176.701 83.0987 176.701 83.0988 176.701 83.0988C175.187 85.6709 176.261 89.0345 178.539 90.0502C178.84 90.1848 179.167 90.2814 179.519 90.3323C179.741 90.3638 179.971 90.3797 180.201 90.3797C181.658 90.3797 182.964 89.7014 183.876 88.6171L184.641 87.7083L185.407 88.6171C186.319 89.7009 187.631 90.3797 189.082 90.3797C190.538 90.3797 191.844 89.7014 192.757 88.6171L193.522 87.7083L194.287 88.6171C195.2 89.7009 196.511 90.3797 197.963 90.3797C199.419 90.3797 200.725 89.7014 201.638 88.6171L202.401 87.7108L203.166 88.615C204.086 89.7021 205.394 90.3797 206.843 90.3797C207.08 90.3797 207.303 90.3638 207.527 90.3321L210.356 83.0991ZM210.356 83.0991C211.198 84.5276 211.251 86.2502 210.688 87.6735M210.356 83.0991L210.688 87.6735M210.688 87.6735C210.126 89.0913 208.996 90.1228 207.527 90.3321L210.688 87.6735Z" fill="white" stroke="#C9C9C9" stroke-width="2"/>
                  </svg>

                  <span class="camera-icon" style="position: absolute;bottom: 15px;right: 3px;margin-bottom: 0;display: inline-block;width: 38px;">
                     <svg width="38" height="38" viewBox="0 0 38 38" fill="none" xmlns="http://www.w3.org/2000/svg" style="display: block;">
                     <g filter="url(#filter0_d_780_5054)">
                     <circle cx="19" cy="17" r="15" fill="white"/>
                     </g>
                     <path d="M18.8888 20.556C20.3616 20.556 21.5555 19.3621 21.5555 17.8893C21.5555 16.4166 20.3616 15.2227 18.8888 15.2227C17.4161 15.2227 16.2222 16.4166 16.2222 17.8893C16.2222 19.3621 17.4161 20.556 18.8888 20.556Z" fill="#252831"/>
                     <path d="M26 10.7778H23.1822L22.08 9.57778C21.9143 9.39591 21.7126 9.25058 21.4876 9.1511C21.2626 9.05161 21.0193 9.00015 20.7733 9H17.0044C16.5067 9 16.0267 9.21333 15.6889 9.57778L14.5956 10.7778H11.7778C10.8 10.7778 10 11.5778 10 12.5556V23.2222C10 24.2 10.8 25 11.7778 25H26C26.9778 25 27.7778 24.2 27.7778 23.2222V12.5556C27.7778 11.5778 26.9778 10.7778 26 10.7778ZM18.8889 22.3333C16.4356 22.3333 14.4444 20.3422 14.4444 17.8889C14.4444 15.4356 16.4356 13.4444 18.8889 13.4444C21.3422 13.4444 23.3333 15.4356 23.3333 17.8889C23.3333 20.3422 21.3422 22.3333 18.8889 22.3333Z" fill="#252831"/>
                     <defs>
                     <filter id="filter0_d_780_5054" x="0" y="0" width="38" height="38" filterUnits="userSpaceOnUse" color-interpolation-filters="sRGB">
                     <feFlood flood-opacity="0" result="BackgroundImageFix"/>
                     <feColorMatrix in="SourceAlpha" type="matrix" values="0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 127 0" result="hardAlpha"/>
                     <feOffset dy="2"/>
                     <feGaussianBlur stdDeviation="2"/>
                     <feComposite in2="hardAlpha" operator="out"/>
                     <feColorMatrix type="matrix" values="0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0.14 0"/>
                     <feBlend mode="normal" in2="BackgroundImageFix" result="effect1_dropShadow_780_5054"/>
                     <feBlend mode="normal" in="SourceGraphic" in2="effect1_dropShadow_780_5054" result="shape"/>
                     </filter>
                     </defs>
                     </svg>
                  </span>

                  <input id='uploadAvatar' class='avatarPickerDisable' type="file" @change='avatarSelected'>
                  <img class='avatar-circle' :src="previewAvatar" v-if="previewAvatar">
               </label>
            </div>
         </td>

      </tr>

      <tr>
         <th><label for="owner"><?php echo __('Owner', 'watergo'); ?></label></th>
         <td><input v-model='owner' id='onwer' type="text" class="regular-text"></td>
      </tr>

      <tr>
         <th><label for='store_name'><?php echo __('Store Name', 'watergo'); ?></label></th>
         <td><input v-model='name' id='store_name' type="text" class="regular-text"></td>
      </tr>

      <tr>
         <th><label for='description'><?php echo __('Description', 'watergo'); ?></label></th>
         <td><textarea ref='textarea' v-model='description' id='description' class='regular-text' rows="5" cols="30"></textarea></td>
      </tr>

      <tr>
         <th><label for='search-address'><?php echo __('Address', 'watergo'); ?></label></th>
         <td><input id='search-address' type="text" class="regular-text" placeholder=''></td>
      </tr>

      <tr>
         <th><label for='phone'><?php echo __('Phone', 'watergo'); ?></label></th>
         <td><input v-model='phone' id='phone' type="text" class="regular-text" inputmode='numeric' pattern='[0-9]*' maxlength='11'></td>
      </tr>

      <tr>
         <th><label for='email'><?php echo __('Email', 'watergo'); ?></label></th>
         <td><input v-model='email' id='email' type="text" class="regular-text" disabled readonly></td>
      </tr>

      <tr>
         <th><label for='password'><?php echo __('Password', 'watergo'); ?></label></th>
         <td>
            <div class='wp-pwd'>

               <input v-model='password' id='password' :type='show_password == true ? "text" : "password" ' class="regular-text mr15">
               <button @click='toggle_show_password' type="button" class="button wp-hide-pw hide-if-no-js" data-toggle="0">
                  <span class="dashicons dashicons-hidden" aria-hidden="true"></span>
                  <span class="text" v-show='show_password == true'><?php echo __('Hide', 'watergo'); ?></span>
                  <span class="text" v-show='show_password == false'><?php echo __('Show', 'watergo'); ?></span>
               </button>

            </div>
         </td>
      </tr>

      <tr>
         <th><label><?php echo __('Select Product', 'watergo'); ?></label></th>
         <td>
            <div class='form-group style-checkbox-business'>
               <label class='form-checkbox mr15'>
                  <input class='form-check' type='checkbox' @click='btn_select_type_product("water")' :checked='select_type_product.water' :disable='select_type_product.water'> 
                  <span class='text'><?php echo __('Water', 'watergo'); ?></span>
               </label>
               <label class='form-checkbox mr15'>
                  <input type='checkbox' @click='btn_select_type_product("ice")' :checked='select_type_product.ice' :disable='select_type_product.ice'> 
                  <span class='text'><?php echo __('Ice', 'watergo'); ?></span>
               </label>
               <label class='form-checkbox'>
                  <input type='checkbox' @click='btn_select_type_product("both")' :checked='select_type_product.both' :disable='select_type_product.both'> 
                  <span class='text'><?php echo __('Both', 'watergo'); ?></span>
               </label>
            </div>
         </td>
      </tr>

   </table>

   <span class='d-block t-red mt20'>{{text_err}}</span>

   <p class="submit">
      <button v-show='action == "edit"' class='button button-primary' @click='edit_store_submit'><?php echo __('Save', 'watergo'); ?></button>
      <button v-show='action == "add"' class='button button-primary' :class='is_submit_add_store == false ? "disabled" : ""' @click='add_store_submit'><?php echo __('Add', 'watergo'); ?></button>
   </p>

   <h1 class="wp-heading-inline"><?php echo __('Products', 'watergo'); ?></h1>
   <p class="submit btn-product">
      <button @click='btn_open_add_water_product' class='button button-primary'><?php echo __('Add Water Product', 'watergo'); ?></button>
      <button @click='btn_open_add_ice_product' class='button button-primary'><?php echo __('Add Ice Product', 'watergo'); ?></button>
   </p>

   <!-- TABLE FOR WATER -->
   <h3 class="wp-heading-inline"><?php echo __('Sản Phẩm Nước', 'watergo'); ?></h3>
   <table class='wp-list-table widefat fixed striped table-view-list posts'>
      <tr>
         <th class="column-date"><span><?php echo __('Product Name', 'watergo'); ?></span></th>
         <th class="column-price "><span><?php echo __('Brand', 'watergo'); ?></span></th>
         <th class="column-type-of-product "><span><?php echo __('Type of water', 'watergo'); ?></span></th>
         <th class="column-price "><span><?php echo __('Price', 'watergo'); ?></span></th>
         <th class="column-rating column-title"><span><?php echo __('Discount', 'watergo'); ?></span></th>
         <th class="column-rating "><span><?php echo __('Quantity', 'watergo'); ?></span></th>
         <th class="column-rating "><span><?php echo __('Volume', 'watergo'); ?></span></th>

      </tr>

      <tr
         v-if='filter_product_water.length > 0'
         v-for='(product, productKey ) in filter_product_water' :key='productKey'
         >
         <td class='row-title'>
            <strong class='text-highlight' @click='btn_edit_product(product)'>{{ product.category }}</strong>
         </td>
         <td>{{ product.brand}}</td>
         <td>{{ product.category_parent}}</td>
         <td>{{ common_price_show_currency(product.price) }}</td>
         <td v-html='get_date_discount(product)'></td>
         <td>{{ product.quantity }}</td>
         <td>{{ product.volume }}</td>
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
      </tr>
      <tr
         v-if='filter_product_water_device.length > 0'
         v-for='(product, productKey ) in filter_product_water_device' :key='productKey'
      >
         <td class=' row-title'>
            <strong class='text-highlight' @click='btn_edit_product(product)'>{{ product.name }}</strong>
         </td>
         <td>{{ product.feature_device }}</td>
         <td>{{ common_price_show_currency(product.price) }}</td>
         <td v-html='get_date_discount(product)'></td>
      </tr>
      <tr v-else><td colspan='4'> <?php echo __('No products found.', 'watergo');?> </td></tr>
   </table>

   <!-- TABLE ICE -->
   <h3 class="wp-heading-inline"><?php echo __('Sản Phẩm Đá', 'watergo'); ?></h3>
   <table class='wp-list-table widefat fixed striped table-view-list posts'>
      <tr>
         <th><span><?php echo __('Product Name', 'watergo'); ?></span></th>
         <th><span><?php echo __('Type of ice', 'watergo'); ?></span></th>
         <th><span><?php echo __('Price', 'watergo'); ?></span></th>
         <th><span><?php echo __('Discount', 'watergo'); ?></span></th>
         <th><span><?php echo __('Length*Width', 'watergo'); ?></span></th>
         <th><span><?php echo __('Weight', 'watergo'); ?></span></th>
      </tr>
      <tr
         v-if='filter_product_ice.length > 0'
         v-for='(product, productKey ) in filter_product_ice' :key='productKey'
      >
         <td class='row-title'>
            <strong class='text-highlight' @click='btn_edit_product(product)'>{{ product.name }}</strong>
         </td>
         <td>{{ product.category_parent }}</td>
         <td>{{ common_price_show_currency(product.price) }}</td>
         <td v-html='get_date_discount(product)'></td>
         <td>{{ product.length_width }} mm</td>
         <td>{{ product.weight }} kg</td>
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
      </tr>
      <tr
         v-if='filter_product_ice_device.length > 0'
         v-for='(product, productKey ) in filter_product_ice_device' :key='productKey'
      >
         <td class='row-title'>
            <strong class='text-highlight' @click='btn_edit_product(product)'>{{ product.name }}</strong>
         </td>
         <td>{{ product.capacity_device }}</td>
         <td>{{ common_price_show_currency(product.price) }}</td>
         <td v-html='get_date_discount(product)'></td>
      </tr>
      <tr v-else><td colspan='4'> <?php echo __('No products found.', 'watergo');?> </td></tr>
   </table>


   <?php } ?>

   <!-- POPUP ADD PRODUCT  -->
   <div :class='popup_add_ice_product == true || popup_add_water_product == true ? "open" : "" ' class='popup-overlay'>
      <div class="popup-content">
         <span @click='btn_close_popup(undefined)' class="popup-close">&times;</span>
         <div v-show='popup_add_ice_product == true || popup_add_water_product == true' style='height: 100%'>
            <!--  -->
            <iframe width='100%' height='100%' :src='link_iframe'></iframe>
            <!--  -->
         </div>
      </div>
   </div>

   <!-- POPUP UP CHANGE PRODUCT STATUS -->
   <div :class='popup_open_change_product_status == true || popup_open_change_product_status == true ? "open" : "" ' class='popup-overlay popup-product-status'>
      <div class="popup-content">
         <span @click='btn_close_popup(undefined)' class="popup-close">&times;</span>
         <p>Bạn đồng ý muốn duyệt sản phẩm này?</p>
         <div class='popup-action'>
            <button class='button button-secondary' @click='btn_close_popup(undefined)'>Huỷ</button>
            <button class='button button-primary' @click='btn_change_product_status'>Đồng Ý</button>
         </div>
      </div>
   </div>



</div>

<?php if( $action == 'edit' ){ ?>
<script type="text/javascript" src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBrhkRyBm3jXLkcMmVvd_GNhINb03VSVfI&libraries=places"></script>
<?php } ?>

<script>
   
var app = Vue.createApp({
   data(){
      return {

         get_template_directory_uri: '<?php echo THEME_URI; ?>',
         get_locale: '<?php echo get_locale(); ?>',
         link_iframe: '',

         is_submit_add_store: false,

         select_type_product: {
            water: false,
            ice: false,
            both: false
         },
         select_type_product_text: '',
         search_store_name: '',

         /**
          * @access EDIT STORE
          */
         store_id: 0,
         owner: '',
         name: '',
         description: '',
         phone: '',
         password: '',
         email: '',

         previewAvatar: null,
         selectedImage: null,

         lat: 0,
         lng: 0,
         address: '',

         show_password: false,

         text_err: '',
         /**
          * @access END EDIT STORE
          * */

         // paged: 0,
         limit: 20,
         total_store: <?php echo $total_store; ?>,
         currentPage: 1,

         stores: [],

         popup_open_change_product_status: false,

         products: [],

         product_status_memory: null,

         is_select_all: false,
         action: null,

         /**
          * @access ADD PRODUCT
          */
         popup_add_water_product: false,
         popup_add_ice_product: false,

         
      }
   },


   computed: {

      products_computed(){
         return this.products.sort( ( a, b ) => b.id - a.id );
      },

      pages: function() {
         return Math.ceil(this.total_store / this.limit);
      },

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
      
      add_store_submit(){

      },

      common_price_show_currency(p){ return window.common_price_show_currency(p); },

      pagination_prev_page() {
         if (this.currentPage > 1) {
            this.currentPage--;
            this.goToPage(this.currentPage);
         }
      },
      pagination_next_page() {
         if (this.currentPage < this.pages) {
            this.currentPage++;
            this.goToPage(this.currentPage);
         }
      },
      
      goToPage(page) {
         this.currentPage = page;
         var hostname = window.location.hostname;
         if (hostname === 'localhost' || hostname === '127.0.0.1') {
            window.location.href = '/wp-admin/admin.php?page=store_manager_index&paged=' + this.currentPage;
         } else {
            window.location.href = '/wordpress/wp-admin/admin.php?page=store_manager_index&paged=' + this.currentPage;
         }
      },

      // END PAGINATION 

      async search_store(){
         if( this.search_store_name != '' && this.search_store_name.length > 0 ){
            var form = new FormData();
            form.append('action', 'atlantis_search_store_from_admin');
            form.append('store_name', this.search_store_name);
            var r = await window.request(form);
            if( r != undefined){
               var res = JSON.parse( JSON.stringify( r) );
               if( res.message == 'store_found' ){
                  this.stores = [];
                  this.stores.push( ...res.data );
               }else{
                  this.stores = [];
               }
            }
         }
      },

      async hidden_store(){
         var _list = [];
         this.stores.forEach( store => {
            if( store.is_select == true ){ _list.push( store.id); }
         });
         if( _list.length > 0 ){
            var form = new FormData();
            form.append('action', 'atlantis_store_hidden');
            form.append('store_mulitple', JSON.stringify(_list));
            var r = await window.request(form);
            if( r != undefined){
               var res = JSON.parse( JSON.stringify( r));
               if( res.message == 'store_hidden_ok' ){
                  for( var i = 0; i < _list.length; i++ ){
                     var _findIndex = this.stores.findIndex( s => s.id == _list[i] );
                     this.stores.splice(_findIndex, 1);
                  }
               }
            }
         }
      },

      async get_product(product_id){
         var form = new FormData();
         form.append('action', 'atlantis_find_product');
         form.append('product_id', product_id);
         form.append('limit_image', 0);
         var r = await window.request(form);
         if( r != undefined ){
            var res = JSON.parse( JSON.stringify( r));
            if( res.message == 'product_found' ){
               res.data.id = parseInt(res.data.id);
               var _findIndex = this.products.findIndex( p => p.id == res.data.id );
               if(_findIndex == -1){
                  this.products.push(res.data);
               }else{
                  this.products[_findIndex] = res.data;
               }
            }
         }

      },

      btn_open_add_water_product(){ 
         this.popup_add_water_product = true;
         this.link_iframe = `<?php echo get_bloginfo('url'); ?>/product/?product_page=product-water-action&action=add&store_id=${this.store_id}&appt=N&skipforce=publish` + '&disable=goback';
      },

      btn_open_add_ice_product(){ 
         this.popup_add_ice_product = true; 
         this.link_iframe = `<?php echo get_bloginfo('url'); ?>/product/?product_page=product-ice-action&action=add&store_id=${this.store_id}&appt=N&skipforce=publish` + '&disable=goback';
      },

      async btn_close_popup( id_product_callback ){ 
         this.popup_add_water_product = false;
         this.popup_add_ice_product = false;
         this.popup_open_change_product_status = false;
         this.product_status_memory = null;
         this.link_iframe = '';

         if( id_product_callback != undefined ){
            await this.get_product(id_product_callback);
         }

      },

      btn_delete_product( product_id_callback ){
         var _findIndex = this.products.findIndex( p => p.id == product_id_callback );
         if(_findIndex !== -1){
            this.products.splice(_findIndex, 1);
         }
         this.popup_add_water_product = false;
         this.popup_add_ice_product   = false;
         this.link_iframe = '';
      },

      btn_edit_product( product ){
         var _product_id   = product.id;
         var _product_type = product.product_type;

         if(_product_type == 'ice' || _product_type == 'ice_device' ){
            this.popup_add_ice_product = true;
            this.link_iframe = `<?php echo get_bloginfo('url'); ?>/product/?product_page=product-ice-action&action=edit&product_id=${_product_id}&skipforce=publish&appt=N` + '&disable=goback';
         }
         if(_product_type == 'water' || _product_type == 'water_device' ){
            this.popup_add_water_product = true;
            this.link_iframe = `<?php echo get_bloginfo('url'); ?>/product/?product_page=product-water-action&action=edit&product_id=${_product_id}&skipforce=publish&appt=N` + '&disable=goback';
         }
      },

      check_has_discount( product ){
         var is_has_discount = window.has_discount(product);
         if( is_has_discount == true ){
            return 'Còn hạn';
         }else{
            return 'Hết hạn';
         }
      },

      check_discount_date( date ){
         if( date != 0 ) return date;
         return '';
      },

      get_date_discount( product ){
         var _from   = this.check_discount_date(product.discount_from);
         var _to     = this.check_discount_date(product.discount_to);
         if( _from == '' || _to == '' ) return '<?php echo __('Hết hạn', 'watergo'); ?>';
         var _discount = `  `;
         return `<?php echo __('Từ ngày', 'watergo'); ?> ${_from} <br><?php echo __('Đến ngày', 'watergo'); ?> ${_to}`;
      },

      get_product_status( product ){
         if( product.status == 'publish' ){
            return '<?php echo __("Đã Duyệt", "watergo"); ?>';
         }
         if( product.status == 'pending' ){
            return '<?php echo __("Chưa Duyệt", "watergo"); ?>';
         }
      },

      get_product_status_class( product ){
         if( product.status == 'publish' )return 'disabled';
         if( product.status == 'pending' )return '';
      },

      async edit_store_submit(){
      
         this.text_err = '';
         
         // CHECK ALL IS EMPTY ??
         if( 
            this.owner != '' &&
            this.name != '' &&
            this.phone != '' &&
            this.email != '' && 
            this.address != "" && 
            this.lat != "" && 
            this.lng != "" &&
            this.select_type_product_text != ''
         ){
            this.loading = true;
            var form = new FormData();
            form.append('action', 'atlantis_store_profile_edit');

            form.append('id', this.store_id);
            form.append('owner', this.owner);
            form.append('name', this.name);
            form.append('address', this.address);
            form.append('phone', this.phone);
            //form.append('email', this.email);
            form.append('description', this.description);
            form.append('imageUpload[]', this.selectedImage);
            form.append('latitude', this.lat);
            form.append('longitude', this.lng);
            // new update
            form.append('storeType', this.select_type_product_text);

            if(this.password != '' && this.password.length > 0){
               form.append('password', this.password);
            }

            var r = await window.request(form);
            
            if( r != undefined ){
               var res = JSON.parse( JSON.stringify(r));
               // DISPLAY ERROR
               if( res.message == 'email_already_exists' ){
                  this.text_err = '<?php echo __("Email already exists.", 'watergo'); ?>';
               }
               if( res.message == 'phonenumber_is_not_correct_format' ){
                  this.text_err = '<?php echo __("Phone number is not correct format.", 'watergo'); ?>';
               }
               if( res.message == 'store_edit_error' ){
                  this.text_err = '<?php echo __("Store Edit Error.", 'watergo'); ?>';
               }
               if( res.message == 'store_profile_update_ok'){
                  window.location.href = '<?php echo get_bloginfo('url'); ?>' + '/wordpress/wp-admin/admin.php?page=store_manager_index';
               }
            }
            this.loading = false;
         }else if( this.address == "" || this.lat == "" || this.lng == ""){
            // Địa chỉ không hợp lệ, vui lòng chọn địa chỉ trong sách đề xuất
            this.text_err = '<?php echo __("Invalid address, please select the address in the suggestion book", 'watergo'); ?>';
         } else{
            this.text_err = '<?php echo __("All field must be not empty.", 'watergo'); ?>';
         }
      },

      toggle_show_password(){ this.show_password = !this.show_password; },

      async get_store_profile( store_id ){
         var form = new FormData();
         form.append('action', 'atlantis_get_store_profile');
         form.append('store_id', store_id);
         var r = await window.request(form);
         if( r != undefined ){
            var res = JSON.parse( JSON.stringify( r));
            if( res.message == 'get_store_ok'){

               // this.store           = res.data;
               this.owner           = res.data.owner;
               this.name            = res.data.name;
               this.description     = res.data.description.replace(/\\/g, '');

               this.address         = res.data.address;
               if( this.address != undefined && this.address != null && this.address != '' ){
                  var _address_input    = document.getElementById("search-address");
                  _address_input.value = this.address;
               }
               this.lat             = res.data.latitude;
               this.lng             = res.data.longitude;
               this.phone           = res.data.phone;
               this.email           = res.data.email;
               if( res.data.store_image.dummy == undefined ){
                  this.previewAvatar   = res.data.store_image.url;
               }
               this.btn_select_type_product(res.data.store_type);
            }
         }

      },

      verify_email( email ){
         const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
         if (emailRegex.test(email)) {
            return true;
         }else{
            return false;
         }
      },

      autoResize() {
         const scrollHeight = this.$refs.textarea.scrollHeight;
         const maxHeight = 125;
         if (scrollHeight > maxHeight) {
            this.$refs.textarea.style.height = 'auto';
            this.$refs.textarea.style.height = this.$refs.textarea.scrollHeight + 'px';
         }
      },

      avatarSelected(e){
         var file = e.target.files;
         if( file != undefined && file[0].type.startsWith('image/') ){
            var reader = new FileReader();
            reader.onload = (e) => {
               if(e.target.readyState == 2 ){
                  this.previewAvatar = e.target.result;
               }
            };
            reader.readAsDataURL(file[0]);
            this.selectedImage = file[0];
         }
      },

      // 

      btn_select_type_product( type ){
         // force all
         if(this.select_type_product_text != type ){
            for (let prop in this.select_type_product) {
               if (this.select_type_product.hasOwnProperty(prop)) {
                  this.select_type_product[prop] = false;
               }
            }
            switch(type){
               case 'water': 
                  this.select_type_product.water = true; 
                  this.select_type_product_text = 'water';
               break;
               case 'ice': this.select_type_product.ice = true; 
                  this.select_type_product_text = 'ice';
               break;
               case 'both': this.select_type_product.both = true; 
                  this.select_type_product_text = 'both';
               break;
            }
         }
      },

      // 

      select_store( store_id ){
         this.stores.forEach( store => {
            if( store.id == store_id ){
               store.is_select = !store.is_select;
            }
         });
      },

      select_all_store(){
         this.is_select_all = !this.is_select_all;
         this.stores.forEach(item => item.is_select = this.is_select_all );
      },

      async atlantis_load_store_for_admin_page( page ){

         var form = new FormData();
         form.append('action', 'atlantis_load_store_for_admin_page');
         form.append('paged', page );
         form.append('limit', this.limit );
         var r = await window.request(form);
         if( r != undefined ){
            if( r.message == 'store_found' ){
               var res = JSON.parse( JSON.stringify( r ));
               res.data.forEach( store => {
                  var _exists = this.stores.some( s => s.id == store.id );
                  if( ! _exists ){
                     store.is_select = false;
                     this.stores.push( store );
                  }
               });
            }
         }
      },

      async atlantis_get_all_product_by_store_to_admin_page( store_id ){
         var form = new FormData();
         form.append('action', 'atlantis_get_all_product_by_store_to_admin_page');
         form.append('store_id', store_id);
         form.append('status', 'publish');
         var r = await window.request(form);
         if( r != undefined ){
            var res = JSON.parse( JSON.stringify( r));
            if( res.message == 'product_found' ){
               this.products.push(...res.data);
            }
         }
      },


   },

   async created() {

      var urlParams            = new URLSearchParams(window.location.search);
      this.store_id            = urlParams.get('store_id');
      this.action              = urlParams.get('action');
      this.currentPage         = urlParams.get('paged');

      if( this.action == null || this.action == undefined ){
         await this.atlantis_load_store_for_admin_page( this.currentPage );
      }

      if( this.action == 'edit' ){
         // setTimeout( () => {this.autoResize();}, 0);
         await this.get_store_profile( this.store_id );
         await this.atlantis_get_all_product_by_store_to_admin_page( this.store_id );

      }

   }

})
.mount('#app');
window.app = app;


function initialize() {
   var input = document.getElementById('search-address');
   var options = {
      componentRestrictions: { country: "vn" },
   };
   var autocomplete = new google.maps.places.Autocomplete(input, options);

   google.maps.event.addListener(autocomplete, 'place_changed', function () {
      var selectedPlace = autocomplete.getPlace();
      if (selectedPlace && selectedPlace.geometry && selectedPlace.geometry.location) {
         window.app.lat = selectedPlace.geometry.location.lat();
         window.app.lng = selectedPlace.geometry.location.lng();
         window.app.address = selectedPlace.formatted_address;
      }
   });

   input.addEventListener('keydown', function (event) {
      window.app.address = '';
      window.app.lat = '';
      window.app.lng = '';
   });

}


if( window.app.action == 'edit' || window.app.action == 'add' ){
   google.maps.event.addDomListener(window, 'load', initialize);
}


// jQuery(document).ready(function($) {
//     // Open the popup
//     $('.popup-trigger').click(function() {
//         $('.popup-overlay').fadeIn();
//     });

//     // Close the popup
//     $('.popup-close, .popup-overlay').click(function() {
//         $('.popup-overlay').fadeOut();
//     });
// });

</script>

<?php
}

