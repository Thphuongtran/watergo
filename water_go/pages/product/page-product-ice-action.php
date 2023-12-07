<?php 
/**
 * @access THIS IS TAB PRODUCT STORE 
 */

   GLOBAL $wpdb;
   $get_category = "SELECT * FROM wp_watergo_product_category WHERE category IN ('ice_category') AND name != 'Đá cây' ";
   $category = $wpdb->get_results($get_category);

   $action        = isset($_GET['action']) ? $_GET['action'] : '';
   $allow_action = ['add', 'edit'];


   if( $action == '' && !in_array( $action, $allow_action) ){
      exit();
      // @wp_redirect(get_bloginfo('url') . '/home', 302);
   }

?>

<link defer rel="stylesheet" href="<?php echo THEME_URI . '/assets/js/jquery_ui_1.13.2.min.css'; ?>">
<script defer src="<?php echo THEME_URI . '/assets/js/jquery_ui_1.13.2.min.js'; ?>"></script>
<style>
   select:disabled ~ .icon-select{
      display: none;
   }

   .force_select_disabled input, 
   .force_select_disabled select,{ 
      pointer-events: none;
      touch-action: none;
   }

   .group-between-box{
      display: flex;
      flex-flow: row nowrap;
      justify-content: space-between;
   }
   
   .product-store-view-form .form-control.box-gift{
      position: relative;
      
   }
   .product-store-view-form .form-control.box-gift input{
      padding-right: 70px;
   }
   .product-store-view-form .form-control.box-gift .text{
      position: absolute;
      right: 16px;
      top: 50%;
      font-size: 16px;
      font-weight: 400;
      color: #7B7D83;
      transform: translateY(-50%);
   }

   .form-control-ice-weight {
      position: relative;
   }
   .form-control-ice-weight .box-select-weight-unit {
      position: absolute;
      right: 0;
      bottom: 0;
      display: flex;
      flex-flow: row nowrap;
      align-items: center;
      background: #F5F5F5;
      border-radius: 8px;
      font-size: 16px;
      padding: 0 10px;
   }
   .form-control-ice-weight .box-select-weight-unit select {
      border: none;
      padding-right: 5px;
   }
   .appbar{
      height: 56px;
   }
   .scaffold{
      height: calc( 100vh - 56px );
      overflow-y: scroll;
      overflow-x: hidden;
   }

</style>
<div id='app'>
   <div v-show='loading == false' class='page-product-store-view'>

      <div class='appbar'>
         <div class='appbar-top'>
            <div class='leading'>
               <button v-show='disable_goback == false' @click='goBack' class='btn-action'>
                  <svg width="11" height="16" viewBox="0 0 11 16" fill="none" xmlns="http://www.w3.org/2000/svg">
                  <path fill-rule="evenodd" clip-rule="evenodd" d="M10.5309 0.375342C10.8759 0.806604 10.806 1.4359 10.3747 1.78091L2.60078 8.00004L10.3747 14.2192C10.806 14.5642 10.8759 15.1935 10.5309 15.6247C10.1859 16.056 9.55657 16.1259 9.12531 15.7809L0.375305 8.78091C0.13809 8.59113 0 8.30382 0 8.00004C0 7.69625 0.13809 7.40894 0.375305 7.21917L9.12531 0.219168C9.55657 -0.125842 10.1859 -0.0559202 10.5309 0.375342Z" fill="#252831"/>
                  </svg>
               </button>
               <p v-if='action == "add"' class='leading-title'><?php echo __("Add Ice Product", 'watergo'); ?></p>
               <p v-if='action == "edit"' class='leading-title'>{{ get_name_product_heading }}</p>
            </div>

         </div>
      </div>

      <div class='scaffold'>
         <!-- FORM  -->
         <div class='inner'>
            <div class='product-store-view-form'>

               <div class='form-title'><?php echo __('Category', 'watergo'); ?></div>

               <div class='form-control form-select'>
                  <select v-model='product.category' :disabled='view_only'>
                     <option :value="null" disabled selected><?php echo __('Select Category', 'watergo'); ?></option>
                     <option 
                        v-for='(cat, catIndex) in category' :key='catIndex'
                        :value="cat.name">{{ cat.name }}</option>
                  </select>
                  <span class='icon-select'>
                     <svg width="12" height="7" viewBox="0 0 12 7" fill="none" xmlns="http://www.w3.org/2000/svg">
                     <path d="M1 1L6 6L11 1" stroke="#252831" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                     </svg>
                  </span>
               </div>

               <!-- NAME DEVICE -->
               <div v-show='listen_product_type == "ice_device"' class='form-control form-select'>
                  <div class='form-title'><?php echo __('Tên thiết bị', 'watergo'); ?></div>
                  <input v-model='product.name_device' placeholder='<?php echo __('Nhập tên thiết bị', 'watergo'); ?>' :disabled='view_only'>
               </div>

               <!-- CAPACITY DEVICE -->
               <div v-show='listen_product_type == "ice_device"' class='form-control form-select'>
                  <div class='form-title'><?php echo __('Dung tích', 'watergo'); ?></div>
                  <input v-model='product.capacity_device' placeholder='<?php echo __('Nhập dung tích thiết bị', 'watergo'); ?>' :disabled='view_only'>
               </div>

               <!-- PRICE -->
               <div class='form-control'>
                  <div class='form-title'><?php echo __('Price', 'watergo'); ?></div>
                  <input inputmode='numeric' v-model='product.price' type="text" pattern='[0-9]*' placeholder='0đ' :disabled='view_only'>
               </div>

               <!-- DISCOUNT BOX AND GIFT BOX -->
               <div class='group-between-box'>
                  <!-- GIFT TOGGLE -->
                  <div class='form-checkbox form-check check-discount'>
                     <label>
                        <input @click='gift_toggle' :checked='open_gift_input' type='checkbox' :disabled='view_only'>
                        <span class='text'><?php echo __('Tặng quà', 'watergo'); ?></span>
                     </label>
                  </div>

                  <!-- DISCOUNT TOGGLE -->
                  <div class='form-checkbox form-check check-discount'>
                     <label>
                        <input @click='discount_toggle' :checked='open_discount_input' type='checkbox' :disabled='view_only'>
                        <span class='text'><?php echo __('Discount', 'watergo'); ?></span>
                     </label>
                  </div>
               </div>

               <div v-show='open_gift_input == true' class='form-control box-gift'>
                  <input v-model='product.gift_text' type="text" maxlength='30' placeholder='<?php echo __('Nhập quà tặng', 'watergo'); ?>' :disabled='view_only'>
                  <span class='text'>{{ get_count_gift_text }}/30</span>
               </div>

               <div v-show='open_gift_input == true' class='group-form-control'>
                  <div class='form-control'>
                     <div class='form-title'><?php echo __('From', 'watergo'); ?></div>
                     <input 
                        @click='select_gift_from_datepicker'
                        id='gift_from' 
                        v-model='product.gift_from'
                        type="text" readonly placeholder='dd-mm-yyyy' :disabled='view_only'
                     >
                  </div>
                  <div class='form-control'>
                     <div class='form-title'><?php echo __('To', 'watergo'); ?></div>
                     <input 
                        @click='select_gift_to_datepicker'
                        id='gift_to' 
                        v-model='product.gift_to'
                        type="text" readonly placeholder='dd-mm-yyyy' :disabled='view_only'>
                  </div>
               </div>

               <div v-show='open_discount_input == true' class='form-title'><?php echo __('Percentage Discount', 'watergo'); ?></div>
               <div v-show='open_discount_input == true' class='form-control'>
                  <input inputmode='numeric' v-model='product.discount_percent' type="text" pattern='[0-9]*' maxlength='3' max='100' placeholder='<?php echo __('Enter Percentage', 'watergo'); ?>' :disabled='view_only'>
               </div>


               <div v-show='open_discount_input == true' class='group-form-control'>
                  <div class='form-control'>
                     <div class='form-title'><?php echo __('From', 'watergo'); ?></div>
                     <input 
                        @click='select_discount_from_datepicker'
                        id='discount_from' 
                        v-model='product.discount_from'
                        type="text" readonly placeholder='dd-mm-yyyy' :disabled='view_only'>
                  </div>
                  <div class='form-control'>
                     <div class='form-title'><?php echo __('To', 'watergo'); ?></div>
                     <input 
                        @click='select_discount_to_datepicker'
                        id='discount_to' 
                        v-model='product.discount_to'
                        type="text" readonly placeholder='dd-mm-yyyy' :disabled='view_only'>
                  </div>
               </div>
               

               <div v-show='listen_product_type == "ice"' class='form-title'><?php echo __('Size Description', 'watergo'); ?></div>

               <!-- WEIGHT -->
               <div v-show='listen_product_type == "ice"' class='form-control form-control-ice-weight'>
                  <div class='form-title small-size'><?php echo __('Weight', 'watergo'); ?></div>
                  <input v-model='product.weight' ref='product_weight' inputmode='numeric' class='input-trailing' data-trailing='kg' type="text" placeholder='<?php echo __('Input Weight', 'watergo'); ?>' :disabled='view_only'>

                  <div class='box-select-weight-unit'>
                     <select v-model='product.weight_unit'>
                        <option :value="'Kg'" selected>Kg</option>
                        <option :value="'Ml'">Ml</option>
                        <option :value="'Box'">Box</option>
                     </select>
                     <span class='icon-select'>
                        <svg width="12" height="7" viewBox="0 0 12 7" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M1 1L6 6L11 1" stroke="#252831" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                        </svg>
                     </span>
                  </div>

               </div>

               <!-- LENGTH WIDTH -->
               <div v-show='listen_product_type == "ice"' class='form-title small-size'><?php echo __('Length * Width', 'watergo'); ?></div>
               <div v-show='listen_product_type == "ice"' class='form-control'>
                  <div class='form-type-length-width'>
                     <div class='form-type-length-width-wrapper'>
                     <input inputmode='numeric' v-model='size_length' class='type-length' pattern='[0-9]*' maxlength='4' type='text' placeholder='____' :disabled='view_only'>
                     <span class='placeholder'>*</span>
                     <input inputmode='numeric' v-model='size_width' class='type-width' pattern='[0-9]*' maxlength='4' type='text' placeholder='____' :disabled='view_only'>
                     <span class='placeholder'> mm</span>
                     </div>
                  </div>
               </div>

               <!-- PRODUCT DESCRIPTION -->
               <div class='form-title'><?php echo __('Product Description', 'watergo'); ?></div>
               <div class='form-control form-select'>
                  <textarea @input='autoResize("textarea1")' ref='textarea1' v-model='product.description' placeholder='<?php echo __('Enter Product Description', 'watergo'); ?>' :disabled='view_only'></textarea>
               </div>

               <div class='form-title'><?php echo __('Photo', 'watergo'); ?></div>

               <ul class='form-photo'>
                  <li v-show='view_only == false' class='upload'>
                     <label>
                        <input id='UploadPhoto' type="file" multiple @change="handleFileUpload" />
                        <!-- <img class='photo-upload-default' src="<?php echo THEME_URI . '/assets/images/banner-add-photo.png' ?>"> -->
                        <img class='photo-upload-default' src="<?php echo THEME_URI . '/assets/images/banner-add-photo-trans.jpeg'; ?>">
                        <span class='text-add-photo'><?php echo __('Add Photo', 'watergo'); ?></span>
                     </label>
                  </li>
                  <!-- IMAGE FROM PRODUCT WHEN EDIT -->
                  <li class='image' v-for="(image, imageIndex) in productImages" :key="imageIndex">
                     <img :src="image.imagePreview" alt="Preview Image">
                     <button v-show='view_only == false' @click='btn_delete_product_image(imageIndex)'>
                        <svg width="16" height="16" viewBox="0 0 16 16" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <rect width="16" height="16" rx="2" fill="white" fill-opacity="0.7"/>
                        <path d="M12 4L4 12" stroke="#515151" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                        <path d="M4 4L12 12" stroke="#515151" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                        </svg>
                     </button>
                  </li>

                  <!-- IMAGE FROM PRODUCT WHEN ADD -->
                  <li class='image' v-for="(image, imageIndex) in uploadImages" :key="imageIndex">
                     <img :src="image.imagePreview" alt="Preview Image">
                     <button v-show='view_only == false' @click='btn_delete_upload_image(imageIndex)'>
                        <svg width="16" height="16" viewBox="0 0 16 16" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <rect width="16" height="16" rx="2" fill="white" fill-opacity="0.7"/>
                        <path d="M12 4L4 12" stroke="#515151" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                        <path d="M4 4L12 12" stroke="#515151" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                        </svg>
                     </button>
                  </li>
               </ul>

               <div v-if='action == "edit"' class='form-checkbox form-check check-out-of-stock'>
                  <label>
                     <input @click='mark_out_of_stock' :checked='product.mark_out_of_stock == 1 ? true : false' type='checkbox' :disabled='view_only'>
                     <span class='text'><?php echo __('Mark as out of stock', 'watergo'); ?></span>
                  </label>
               </div>

               <div class='t-red'>{{ text_error }}</div>

               <div v-show='view_only == false' class='form-button'>
                  <button @click='btn_action_product("add")' v-if='action == "add"' class='btn btn-primary' :class='is_can_action == false ? "disable" : ""'><?php echo __('Add', 'watergo'); ?></button>
                  <button @click='btn_action_product("edit")' v-if='action == "edit"' class='btn btn-primary' :class='is_can_action == false ? "disable" : ""'><?php echo __('Save', 'watergo'); ?></button>
                  <button @click='btn_modal_open' v-if='action == "edit"' class='btn btn-outline'><?php echo __('Delete', 'watergo'); ?></button>
               </div>
            </div>
         </div>
         
      </div>

   </div>

   <div v-show='popup_delete_product == true' class='modal-popup open'>
      <div class='modal-wrapper'>
         <p class='heading'><?php echo __('Do you want to delete this product', 'watergo'); ?>?</p>
         <div class='actions'>
            <button @click='btn_modal_cancel' class='btn btn-outline'><?php echo __('Cancel', 'watergo'); ?></button>
            <button @click='btn_modal_confirm' class='btn btn-primary'><?php echo __('Confirm', 'watergo'); ?></button>
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

if( window.appBridge != undefined ){
   window.appBridge.setEnableScroll(false);
}

var app = Vue.createApp({
   data (){

      return {
         popup_delete_product: false,
         loading: false,

         skipforce: '',
         view_only: false,

         disable_goback: false,

         // LISTENER PRODUCT TYPE 
         listen_product_type: 'ice',

         open_gift_input: false,
         open_discount_input: false,

         product: {
            id: null,
            category: null,
            product_type: null,
            description: '',
            brand: null,
            price: null,
            quantity: null,
            volume: null,
            weight: null,
            length_width: '',

            has_discount: null,
            discount_from: null,
            discount_to: null,
            discount_percent: null,

            mark_out_of_stock: 0,

            has_gift: null,
            gift_text: null,
            gift_from: null,
            gift_to: null,

            // THIET BI

            capacity_device: null,
            feature_device: null,
            name_device: null,
            // product_image in visible

            weight_unit: 'Kg',
         },

         store_id: null,

         is_can_action: false,
         size_length: null,
         size_width: null,

         category: [],

         uploadImages: [],
         productImages: [],
         list_attachment_id_delete: [],

         ice_weight_no_trailing: null,

         action: '',
         text_error: '',

         get_count_gift_text: 0,

         ice_weight_select_unit: {unit: 'Kg'},

         check_error: {
            listen_product_type: 'ice',

            select_category:  false,
            price:            false,
            description:      false,
            
            // ice
            ice_weight:       false,
            size_length:      false,
            size_width:       false,
            //
            has_discount:     false,
            discount_percent: false,
            discount_from:    false,
            discount_to:      false,

            has_gift:         false,
            gift_text:        false,
            gift_from:        false,
            gift_to:          false,

            name_device:      false,
            capacity_device:  false,

            // image upload
            uploadImages:     false,
            productImages:    false,
         }
      }
   },

   watch: {


      
      'product.category': function( val ){
         if( val != ''){ this.check_error.select_category = true; }else{
            this.check_error.select_category = false;
         }
         if( val == "Thiết bị đá" ){
            this.listen_product_type               = 'ice_device';
            // RE-BUILD CHECK ERROR 
            this.check_error.listen_product_type   = 'ice_device';
         }else{
            this.listen_product_type = 'ice';
            // RE-BUILD CHECK ERROR 
            this.check_error.listen_product_type   = 'ice';
         }
      },

      'product.name_device': function( val){
         if( val != null && val.length > 0 && val != ''){ this.check_error.name_device = true; }
         else{ this.check_error.name_device = false;}
      },
      'product.capacity_device': function( val){
         if( val != null && val.length > 0 && val != ''){ this.check_error.capacity_device = true; }
         else{ this.check_error.capacity_device = false;}
      },

      'product.weight': function( val ){
         if( val != null && val != 0 && val != '' ){ this.check_error.ice_weight = true; }
         else{this.check_error.ice_weight = false;}
      },

      length_width: function( val ){
         if(val != undefined && val != null && val != ''){
            this.check_error.size_length = true;
            this.check_error.size_width = true;
         }else{
            this.check_error.size_length = false;
            this.check_error.size_width = false;
         }
      },

      size_length: function ( val ){
         if(val != undefined && val != null && val != ''){this.check_error.size_length = true;
         }else{this.check_error.size_length = false;}
      },
      size_width: function ( val ){
         if(val != undefined && val != null && val != ''){this.check_error.size_width = true;
         }else{this.check_error.size_width = false;}
      },
      'product.price': function( val ){
         if(val != undefined && val != null && val != ''){this.check_error.price = true;
         }else{this.check_error.price = false;}
      },
      'product.description': function( val ){
         if(val != undefined && val != null && val != ''){this.check_error.description = true;
         }else{this.check_error.description = false;}
      },

      // DISCOUNT
      
      open_discount_input: function ( val ){
         if( val == true ){
            this.check_error.has_discount = true;
            this.product.has_discount = 1;
         }else{
            this.check_error.has_discount = false;
            this.product.has_discount = 0;
         }
      },
      'product.has_discount': function( val ){
         if(val == 1 ){
            this.check_error.has_discount = true;
            this.product.has_discount = 1;
         }else{
            this.check_error.has_discount = false;
            this.product.has_discount = 0;
         }
      },
      'product.discount_percent': function ( val ){
         if( val >= 100 ){
            this.product.discount_percent = 100;
         }
         if( val == null ){
            this.product.discount_percent = null;
         }
         if( val != undefined && val != ''){
            this.check_error.discount_percent = true;
         }else{
            this.check_error.discount_percent = false;
         }
      },  
      'product.discount_from': function(val){
         if( val != undefined && val != '' && val != 0){
            this.check_error.discount_from = true;
         }else{
            this.check_error.discount_from = false;
         }
      },
      'product.discount_to': function(val){
         if( val != undefined && val != '' && val != 0){
            this.check_error.discount_to = true;
         }else{
            this.check_error.discount_to = false;
         }
      },

      // GIFT
      open_gift_input: function ( val ){
         if(val == true ){
            this.check_error.has_gift = true;
            this.product.has_gift = 1;
         }else{
            this.check_error.has_gift = false;
            this.product.has_gift = 0;
         }
      },
      'product.has_gift': function( val ){
         if(val == 1 ){
            this.check_error.has_gift = true;
            this.product.has_gift = 1;
         }else{
            this.check_error.has_gift = false;
            this.product.has_gift = 0;
         }
      },
      'product.gift_text': function( val ){
         this.get_count_gift_text = val.length;
         if( this.get_count_gift_text > 0 ){
            this.check_error.gift_text = true;
         }else{
            this.check_error.gift_text = false;
         }
      },
      'product.gift_from': function( val ){
         if( val != 0 && val != null ){
            this.check_error.gift_from = true;
         }else{
            this.check_error.gift_from = false;
         }
      },
      'product.gift_to': function( val ){
         if( val != 0 && val != null ){
            this.check_error.gift_to = true;
         }else{
            this.check_error.gift_to = false;
         }
      },

      uploadImages: {
         handler( image ){
            if( this.uploadImages.length > 0 ){
               this.check_error.uploadImages = true;
            }else{
               this.check_error.uploadImages = false;
            }
         },
         deep: true
      },

      productImages: {
         handler( image ){
            if( this.productImages.length > 0 ){
               this.check_error.productImages = true;
            }else{
               this.check_error.productImages = false;
            }
         },
         deep: true
      },

      check_error: {
         handler( val ){

            // CHECK FOR ICE
            if( this.listen_product_type == 'ice' ){

               if(
                  val.select_category == true &&
                  val.price == true &&
                  val.description == true &&
                  val.ice_weight == true &&
                  val.size_length == true &&
                  val.size_width == true
               ){
                  this.is_can_action = true;
                  // OPTION DISCOUNT
                  if( val.has_discount == true ){
                     if( val.discount_percent == true && val.discount_from == true && val.discount_to == true ){
                        this.is_can_action = true;
                     }else{
                        this.is_can_action = false;
                     }
                  }
                  // GIFT OPTION
                  if( val.has_gift == true ){
                     if( val.gift_text == true && val.gift_from == true && val.gift_to == true ){
                        this.is_can_action = true;
                     }else{
                        this.is_can_action = false;
                     }
                  }

                  if( val.uploadImages == false && val.productImages == false && this.action == 'edit'){
                     this.is_can_action = false;
                  } else if(val.uploadImages == false && this.action == 'add'){
                     this.is_can_action = false;
                  }

               }else{
                  this.is_can_action = false;
               }
            }

            // CHECK FOR ICE-DEVICE
            if( this.listen_product_type == 'ice_device' ){
               if(
                  val.select_category == true &&
                  val.name_device == true &&
                  val.capacity_device == true &&
                  val.price == true &&
                  val.description == true
               ){
                  this.is_can_action = true;
                  // OPTION DISCOUNT
                  if( val.has_discount == true ){
                     if( val.discount_percent == true && val.discount_from == true && val.discount_to == true ){
                        this.is_can_action = true;
                     }else{
                        this.is_can_action = false;
                     }
                  }
                  // GIFT OPTION
                  if( val.has_gift == true ){
                     if( val.gift_text == true && val.gift_from == true && val.gift_to == true ){
                        this.is_can_action = true;
                     }else{
                        this.is_can_action = false;
                     }
                  }

                  if( val.uploadImages == false && val.productImages == false && this.action == 'edit'){
                     this.is_can_action = false;
                  } else if(val.uploadImages == false && this.action == 'add'){
                     this.is_can_action = false;
                  }

               }else{
                  this.is_can_action = false;
               }
            }

         },
         deep: true,
      },


   },

   computed: {
      get_name_product_heading(){
         if( this.product.product_type == 'ice' ){
            return this.product.category;
         }else if( this.product.product_type == 'ice_device' ){
            return this.product.name_device;
         }
      },

   },

   methods: {

      /**
       * @access DATEPICKER
       */
      discount_toggle(){ this.open_discount_input = !this.open_discount_input;},
      gift_toggle(){ this.open_gift_input = !this.open_gift_input; },

      _from_datepicker( el, var_changed, el_to ){

         let instanceApp = this;

          var localeData = {
            'en_US': {
               monthNames: ['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'],
               monthNamesShort: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'],
               dayNames: ['Sunday', 'Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday'],
               dayNamesShort: ['Sun', 'Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat'],
               dayNamesMin: [ "Sun", "Mon", "Tue", "Wed", "Thu", "Fri", "Sat" ],
            },
            'vi': {
               monthNames: ['Tháng 1', 'Tháng 2', 'Tháng 3', 'Tháng 4', 'Tháng 5', 'Tháng 6', 'Tháng 7', 'Tháng 8', 'Tháng 9', 'Tháng 10', 'Tháng 11', 'Tháng 12'],
               monthNamesShort: ['Th.1', 'Th.2', 'Th.3', 'Th.4', 'Th.5', 'Th.6', 'Th.7', 'Th.8', 'Th.9', 'Th.10', 'Th.11', 'Th.12'],
               dayNames: ['Chủ Nhật', 'Thứ Hai', 'Thứ Ba', 'Thứ Tư', 'Thứ Năm', 'Thứ Sáu', 'Thứ Bảy'],
               dayNamesShort: ['CN', 'T2', 'T3', 'T4', 'T5', 'T6', 'T7'],
               dayNamesMin: ['CN', 'T2', 'T3', 'T4', 'T5', 'T6', 'T7']
            }
         };

         // Get the locale-specific month and day names based on this.locale
         var locale = 'en_US'; // Default to English
         var get_locale = '<?php echo get_locale(); ?>';
         if ( get_locale != undefined && localeData[get_locale] != undefined) {
            locale = get_locale;
         }

         $(document).ready(function(){

            $(el).click(function(){$('.ui-date-picker-wrapper').addClass('active');});

            $(el).datepicker({
               // dayNamesMin: [ "Sun", "Mon", "Tue", "Wed", "Thu", "Fri", "Sat" ],
               minDate: 0,
               dateFormat: "dd/mm/yy",
               firstDay: 1,

               monthNames:       localeData[locale].monthNames,
               monthNamesShort:  localeData[locale].monthNamesShort,
               dayNames:         localeData[locale].dayNames,
               dayNamesShort:    localeData[locale].dayNamesShort,
               dayNamesMin:      localeData[locale].dayNamesMin,

               beforeShow: function(element, inst){
                  if( $('.ui-date-picker-wrapper #ui-datepicker-div').length == 0 ){
                     // $('#ui-datepicker-div').wrap('<div class="ui-date-picker-wrapper"></div>');
                     inst.dpDiv.wrap('<div class="ui-date-picker-wrapper"></div>');
                  }
               },
               onSelect: function(dateText, inst){
                  if(dateText != undefined || dateText != '' || dateText != null){
                     $(el).attr('value', dateText); 

                     if( var_changed == 'discount_from' ){
                        console.log('dassd')
                        instanceApp.product.discount_from = dateText;
                     }
                     if( var_changed == 'gift_from' ){
                        instanceApp.product.gift_from = dateText;
                     }

                     var discount_from = $(el).datepicker('getDate');
                     // Calculate the next day
                     var nextDay = new Date(discount_from);
                     nextDay.setDate(nextDay.getDate() + 1);
                     var day = nextDay.getDate().toString().padStart(2, '0');
                     var month = (nextDay.getMonth() + 1).toString().padStart(2, '0');
                     var year = nextDay.getFullYear();
                     var fullday = day + '/' + month + '/' + year;
                     if (fullday) {
                        if( var_changed == 'discount_from' ){
                           instanceApp.product.discount_to = fullday;
                        }
                        if( var_changed == 'gift_from' ){
                           instanceApp.product.gift_to = fullday;
                        }
                        $(el_to).datepicker('option', 'minDate', fullday);
                     }
                  }
               },
               onClose: function(dateText, inst){
                  $('.ui-date-picker-wrapper').removeClass('active');
               }
            });
         });
      },

      _to_discount(el, var_changed){
         let instanceApp = this;

          var localeData = {
            'en_US': {
               monthNames: ['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'],
               monthNamesShort: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'],
               dayNames: ['Sunday', 'Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday'],
               dayNamesShort: ['Sun', 'Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat'],
               dayNamesMin: [ "Sun", "Mon", "Tue", "Wed", "Thu", "Fri", "Sat" ],
            },
            'vi': {
               monthNames: ['Tháng 1', 'Tháng 2', 'Tháng 3', 'Tháng 4', 'Tháng 5', 'Tháng 6', 'Tháng 7', 'Tháng 8', 'Tháng 9', 'Tháng 10', 'Tháng 11', 'Tháng 12'],
               monthNamesShort: ['Th.1', 'Th.2', 'Th.3', 'Th.4', 'Th.5', 'Th.6', 'Th.7', 'Th.8', 'Th.9', 'Th.10', 'Th.11', 'Th.12'],
               dayNames: ['Chủ Nhật', 'Thứ Hai', 'Thứ Ba', 'Thứ Tư', 'Thứ Năm', 'Thứ Sáu', 'Thứ Bảy'],
               dayNamesShort: ['CN', 'T2', 'T3', 'T4', 'T5', 'T6', 'T7'],
               dayNamesMin: ['CN', 'T2', 'T3', 'T4', 'T5', 'T6', 'T7']
            }
         };

         // Get the locale-specific month and day names based on this.locale
         var locale = 'en_US'; // Default to English
         var get_locale = '<?php echo get_locale(); ?>';
         if ( get_locale != undefined && localeData[get_locale] != undefined) {
            locale = get_locale;
         }

         $(document).ready(function(){
            $(el).click(function(){$('.ui-date-picker-wrapper').addClass('active');});

            $(el).datepicker({
               // dayNamesMin: [ "Sun", "Mon", "Tue", "Wed", "Thu", "Fri", "Sat" ],
               minDate: 0,
               dateFormat: "dd/mm/yy",
               firstDay: 1,

               monthNames:       localeData[locale].monthNames,
               monthNamesShort:  localeData[locale].monthNamesShort,
               dayNames:         localeData[locale].dayNames,
               dayNamesShort:    localeData[locale].dayNamesShort,
               dayNamesMin:      localeData[locale].dayNamesMin,
               beforeShow: function(element, inst){
                  if( $('.ui-date-picker-wrapper #ui-datepicker-div').length == 0 ){
                     // $('#ui-datepicker-div').wrap('<div class="ui-date-picker-wrapper"></div>');
                     inst.dpDiv.wrap('<div class="ui-date-picker-wrapper"></div>');
                  }
               },
               onSelect: function(dateText, inst){
                  if(dateText != undefined || dateText != '' || dateText != null){
                     $(el).attr('value', dateText); 
                     if( var_changed == 'discount_to' ){
                        instanceApp.product.discount_to = dateText;
                     }
                     if( var_changed == 'gift_to' ){
                        instanceApp.product.gift_to = dateText;
                     }
                  }
               },
               onClose: function(dateText, inst){
                  $('.ui-date-picker-wrapper').removeClass('active');
               }
            });
         });
      },

      select_gift_from_datepicker(){
         this._from_datepicker('#gift_from', 'gift_from', '#gift_to');
      },
      select_gift_to_datepicker(){
         this._to_discount('#gift_to', 'gift_to');
      },
      select_discount_from_datepicker(){
        this._from_datepicker('#discount_from', 'discount_from', '#discount_to');
      },
      select_discount_to_datepicker(){
         this._to_discount('#discount_to', 'discount_to');
      },

      formatWeightInput(event) {
         let inputValue = event.target.value;
         let char = $(event.target).data('trailing');
         let numericValue = inputValue.replace(/\D/g, '');

         if (numericValue.length > 0) {
            inputValue = numericValue + ' ' + char;
         } else {
            inputValue = '';
         }
         event.target.value = inputValue;
         this.product.weight = inputValue;
         this.ice_weight_no_trailing = numericValue;

         let cursorPosition = inputValue.indexOf(char) - 1;
         event.target.setSelectionRange(cursorPosition, cursorPosition);
      },

      autoResize( refName) {
         const maxHeight = 125;
         const textarea = this.$refs[refName];
         scrollHeight = textarea.scrollHeight;
         if (scrollHeight > maxHeight) {
            textarea.style.height = 'auto';
            textarea.style.height = textarea.scrollHeight + 'px';
         }
      },

      btn_modal_open(){this.popup_delete_product = true;},
      btn_modal_cancel(){this.popup_delete_product = false;},

      async btn_modal_confirm(){
         this.popup_delete_product = false;
         this.loading = true;
         var form = new FormData();
         form.append('action', 'atlantis_action_product_ice');
         form.append('event', 'delete');
         form.append('product_id', this.product_id);

         if( this.productImages.length > 0 ){
            this.productImages.forEach( img => {
               this.list_attachment_id_delete.push( parseInt(img.id) );
            });
            form.append('list_attachment_id_delete', JSON.stringify(this.list_attachment_id_delete) );
         }
         var r = await window.request(form);
         if( r != undefined ){
            var res = JSON.parse( JSON.stringify(r));
            if( res.message == 'action_product_ok' ){
               var _product_id = res.data;

               if( this.disable_goback == true ){
                  window.parent.app.btn_close_popup(_product_id);
               }else{
                  this.goBackDelete(_product_id);
               }
               
            }
         }

      },

      /**
       * @access DO ALL EVENT
       */
      async btn_action_product( event ){

         var form = new FormData();
         form.append('action', 'atlantis_action_product_ice');
         form.append('event', event);
         form.append('product_type', this.listen_product_type);
         form.append('store_id', this.store_id );

         if( this.skipforce != undefined && this.skipforce != '' ){
            form.append('skipforce', this.skipforce );
         }

         if( this.product_id != null ){
            form.append('product_id', this.product_id);
         }
         form.append('mark_out_of_stock', this.product.mark_out_of_stock);

         if( this.uploadImages.length > 0 ){
            this.uploadImages.forEach( file => form.append('uploadImages[]', file.file ));
         }
         
         if( this.list_attachment_id_delete.length > 0 && event == 'edit' ){
            form.append('list_attachment_id_delete', JSON.stringify(this.list_attachment_id_delete) );
         }

         if( this.open_discount_input == true ){
            this.product.discount_from = window.reverse_date_to_system_datetime(this.product.discount_from);
            this.product.discount_to = window.reverse_date_to_system_datetime(this.product.discount_to);
         }else{
            this.product.has_discount     = 0;
            this.product.discount_percent = 0;
            this.product.discount_from    = 0;
            this.product.discount_to      = 0;
         }

         form.append('has_discount',      this.product.has_discount);
         form.append('discount_percent',  this.product.discount_percent);
         form.append('discount_from',     this.product.discount_from);
         form.append('discount_to',       this.product.discount_to);


         if( this.open_gift_input == true ){
            this.product.gift_from = window.reverse_date_to_system_datetime(this.product.gift_from);
            this.product.gift_to = window.reverse_date_to_system_datetime(this.product.gift_to);
         }else{
            this.product.has_gift  = 0;
            this.product.gift_from = 0;
            this.product.gift_to   = 0;
         }

         form.append('has_gift',       this.product.has_gift);
         form.append('gift_text',      this.product.gift_text);
         form.append('gift_from',      this.product.gift_from);
         form.append('gift_to',        this.product.gift_to);

         form.append('category', this.product.category );
         form.append('price', this.product.price );
         form.append('description', this.product.description);

         if(this.listen_product_type == 'ice'){

            form.append('weight', this.product.weight );
            form.append('weight_unit', this.product.weight_unit );
            form.append('length_width', this.size_length + '*' + this.size_width);
         }
         if(this.listen_product_type == 'ice_device'){
            form.append('capacity_device', this.product.capacity_device);
            form.append('name_device', this.product.name_device);
         }
         if( this.is_can_action == true ){
            this.loading = true;
            var r = await window.request(form);

            if( r != undefined ){
               var res = JSON.parse( JSON.stringify( r ));
               if( res.message == 'action_product_ok'){
                  var _product_id = res.data;
                  if( this.disable_goback == true ){
                     window.parent.app.btn_close_popup(_product_id);
                  }else{
                     this.goBackUpdate(_product_id);
                  }
               }else{
                  this.loading = false;
               }
            }else{
               this.loading = false;
            }
         }

      },

      btn_delete_upload_image( indexImage ){ this.uploadImages.splice(indexImage, 1) },
      btn_delete_product_image( indexImage ){ 
         this.list_attachment_id_delete.push(parseInt( this.productImages[indexImage].id) );
         this.productImages.splice(indexImage, 1);
      },

      mark_out_of_stock(){
         if( this.product.mark_out_of_stock == 0 ){
            this.product.mark_out_of_stock = 1;
         }else{
            this.product.mark_out_of_stock = 0;
         }
      },

      async atlantis_find_product(product_id){
         var form = new FormData();
         form.append('action', 'atlantis_find_product');
         form.append('product_id', product_id);
         form.append('limit_image', 0);
         form.append('get_product_pending', 1);

         var r = await window.request(form);
         if( r != undefined ){
            var res = JSON.parse( JSON.stringify( r));
            if( res.message == 'product_found' ){
               this.product = res.data;
               let _char   = jQuery('.input-trailing').data('trailing');
               $('.input-trailing').val(this.product.weight + ' ' + _char);

               // FILL DISCOUNT
               if(this.product.has_discount == 1){
                  this.open_discount_input = true;
                  if( this.product.discount_from != null && this.product.discount_from != 0 ) {
                     this.product.discount_from = window.reverse_system_datetime_to_date(this.product.discount_from)
                     $('#discount_from').attr('value', this.product.discount_from );

                  }
                  if( this.product.discount_to != null && this.product.discount_to != 0 ){
                     this.product.discount_to = window.reverse_system_datetime_to_date(this.product.discount_to)
                     $('#discount_to').attr('value', this.product.discount_to );
                  }
               }else{
                  this.product.has_discount     = null;
                  this.product.discount_to      = null;
                  this.product.discount_from    = null;
                  this.product.discount_percent = null;
               }

               // FILL GIFT
               if(this.product.has_gift == 1){
                  this.open_gift_input = true;
                  if( this.product.gift_from != null && this.product.gift_from != 0 ) {
                     // $('#gift_from').attr('value', window.reverse_system_datetime_to_date(this.product.gift_from) );
                     this.product.gift_from = window.reverse_system_datetime_to_date(this.product.gift_from);
                  }
                  if( this.product.gift_to != null && this.product.gift_to != 0 ){
                     // $('#gift_to').attr('value', window.reverse_system_datetime_to_date(this.product.gift_to) );
                     this.product.gift_to = window.reverse_system_datetime_to_date(this.product.gift_to);
                  }
               }else{
                  this.product.has_gift     = null;
                  this.product.gift_to      = null;
                  this.product.gift_from    = null;
                  this.product.gift_text    = null;
               }

               // PRODUCT IMAGE
               if(this.product.product_image != null && this.product.product_image.length > 0 ){
                  this.product.product_image.forEach( item => {
                     if( item.id != null ){
                        this.productImages.push({
                           id: item.id,
                           imagePreview: item.url
                        });
                     }
                  });
               }

            }
         }
      },

      handleFileUpload(event) {
         var files = event.target.files;
         if (files) {
            for (var i = 0; i < files.length; i++) {
               var file = files[i];
               if (file.type.startsWith('image/')) {
                  var reader = new FileReader();
                  reader.onload = (( file) => (e) => {
                     var cloneFile = new File([file], file.name, { type: file.type, lastModified: file.lastModified });
                     this.uploadImages.push({
                        file: file, imagePreview: e.target.result
                     });
                  })(file);

                  reader.readAsDataURL(file);
                  reader = null;
               }
            }
            // RESET UPLOAD
            $('#UploadPhoto')[0].value = '';
         }

      },

      goBack(){ 
         window.location.href = '?appt=X&data=notification_count'; 
      },

      goBackUpdate(product_id){ 
         window.location.href = `?appt=X&data=product_store_update|product_id=${product_id}`;
      },
      goBackDelete(product_id){ 
         window.location.href = `?appt=X&data=product_store_delete|product_id=${product_id}`;
      },
      

   },


   async created(){

      this._from_datepicker('#discount_from', 'discount_from', '#discount_to');
      this._to_discount('#discount_to', 'discount_to');
      this._from_datepicker('#gift_from', 'gift_from', '#gift_to');
      this._to_discount('#gift_to', 'gift_to');

      this.category        = JSON.parse('<?php echo json_encode($category) ?>');
      
      this.loading = true;
      var urlParams = new URLSearchParams(window.location.search);
      this.product_id     = urlParams.get('product_id');
      this.store_id       = urlParams.get('store_id');
      this.action         = urlParams.get('action');
      this.skipforce      = urlParams.get('skipforce');
      var view_only       = urlParams.get('view_only');

      if(view_only != undefined && parseInt(view_only) == 1){
         this.view_only = true;
      }

      const disable       = urlParams.get('disable');
      if( disable == 'goback' ){
         this.disable_goback = true;
      }

      if( this.action == 'edit' ){

         await this.atlantis_find_product(this.product_id);
         this.listen_product_type = this.product.product_type;

         if( this.product.mark_out_of_stock == null ){
            this.product.mark_out_of_stock = 0;
         }

         if( this.product.product_type == 'ice' && this.product.length_width != null && this.product.length_width.length != '' ){
            var [_length, _width]   = this.product.length_width.split('*');
            this.size_length        = _length;
            this.size_width         = _width;
         }

         if( this.product.product_type == 'ice' || this.product.product_type == 'ice_device'){
            // INIT WHEN NO EXISTS
            if( this.product.weight_unit == null || this.product.weight_unit == '' ){
               this.product.weight_unit = 'Kg'
            }
         }
      }

      window.appbar_fixed();
      
      setTimeout( () => {this.autoResize("textarea1");}, 0);
      this.loading = false;

      
   },

}).mount('#app');

window.app = app;

</script>