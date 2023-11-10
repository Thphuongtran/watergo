<?php 

/**
 * @access ADD - EDIT WATER {PRODUCT}
 */

   GLOBAL $wpdb;
   $get_category = "SELECT * FROM wp_watergo_product_category WHERE category IN ('water_category', 'water_brand', 'water_quantity', 'water_volume') AND ( category_hidden != 1 OR category_hidden IS NULL ) ORDER BY wp_watergo_product_category.order ASC";
   $category_primary = $wpdb->get_results($get_category);

   // FOR PARENT
   $get_category_parent = "SELECT * FROM wp_watergo_product_category WHERE category IN ('type_of_water') ";
   $category_parent = $wpdb->get_results($get_category_parent);

   // WATER DEVICE FEATURE
   $get_water_device_feature = "SELECT * FROM wp_watergo_product_category WHERE category IN ('water_device_feature') ";
   $category_feature = $wpdb->get_results($get_water_device_feature);

   $action        = isset($_GET['action']) ? $_GET['action'] : '';
   $allow_action = ['add', 'edit', 'delete'];

   // echo '<pre>';
   // print_r($category_primary);
   // echo '</pre>';

   if( $action == '' && !in_array( $action, $allow_action) ){
      exit();
      // @wp_redirect(get_bloginfo('url') . '/home', 302);
   }
?>

<link defer rel="stylesheet" href="<?php echo THEME_URI . '/assets/js/jquery_ui_1.13.2.min.css'; ?>">
<script defer src="<?php echo THEME_URI . '/assets/js/jquery_ui_1.13.2.min.js'; ?>"></script>
<style>
   .form-checkbox-row {
      display: flex;
      flex-flow: row nowrap;
      margin-bottom: 15px;
   }
   .form-checkbox-row label { margin-right: 12px; }
   .form-checkbox-row label:last-child { margin: 0; }

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
               <p class='leading-title'><?php echo __("Add Water Product", 'watergo'); ?></p>
            </div>

         </div>
      </div>

      <!-- FORM  -->
      <div class='inner'>
         <div class='product-store-view-form'>

            <div class='form-title'><?php echo __('Category', 'watergo'); ?></div>

            <div class='form-control form-select'>
               <select v-model='product.category'>
                  <option :value="null" selected disabled><?php echo __('Select Category', 'watergo'); ?></option>
                  <option 
                     v-for='(cat, catIndex) in get_category' :key='catIndex'
                     :value="cat.name">{{ cat.name }}</option>
               </select>
               <span class='icon-select'>
                  <svg width="12" height="7" viewBox="0 0 12 7" fill="none" xmlns="http://www.w3.org/2000/svg">
                  <path d="M1 1L6 6L11 1" stroke="#252831" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                  </svg>
               </span>
            </div>

            <div v-show='listen_product_type == "water"' class='form-title'><?php echo __('Brand', 'watergo'); ?></div>
            <div v-show='listen_product_type == "water"' class='form-control form-select'>
               <select v-model='product.brand'>
                  <option :value="null" selected disabled><?php echo __('Select Brand', 'watergo'); ?></option>
                  <option 
                     v-for='(brand, brandIndex) in get_brand' :key='brandIndex'
                     :value="brand.name">{{ brand.name }}</option>
               </select>
               <span class='icon-select'>
                  <svg width="12" height="7" viewBox="0 0 12 7" fill="none" xmlns="http://www.w3.org/2000/svg">
                  <path d="M1 1L6 6L11 1" stroke="#252831" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                  </svg>
               </span>
            </div>

            <!-- NAME DEVICE -->
            <div v-show='listen_product_type == "water_device"' class='form-control form-select'>
               <div class='form-title'><?php echo __('Tên thiết bị', 'watergo'); ?></div>
               <input v-model='product.name_device' placeholder='<?php echo __('Nhập tên thiết bị', 'watergo'); ?>'>
            </div>

            <!-- TYPE OF WATER -->
            <div v-show='listen_product_type == "water"' class='form-title'><?php echo __('Type of water', 'watergo'); ?></div>
            <div v-show='listen_product_type == "water"' class='form-control form-select'>
               <select v-model='product.category_parent'>
                  <option :value="null" selected disabled><?php echo __('Select type of water', 'watergo'); ?></option>
                  <option 
                     v-for='(cat, catIndex) in category_parent' :key='catIndex'
                     :value="cat.name">{{ cat.name }}</option>
               </select>
               <span class='icon-select'>
                  <svg width="12" height="7" viewBox="0 0 12 7" fill="none" xmlns="http://www.w3.org/2000/svg">
                  <path d="M1 1L6 6L11 1" stroke="#252831" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                  </svg>
               </span>
            </div>


            <!-- PRICE -->
            <div class='form-control'>
               <div class='form-title'><?php echo __('Price', 'watergo'); ?></div>
               <input inputmode='numeric' v-model='product.price' type="text" pattern='[0-9]*' placeholder='0đ'>
            </div>

            <!-- WATER DEVICE FEATURE -->
            <div v-show='listen_product_type == "water_device"' class='form-title'><?php echo __('Chức năng', 'watergo'); ?></div>
            <div v-show='listen_product_type == "water_device"' class='form-checkbox form-check form-checkbox-row'>
               <label @click='btn_select_category_feature(f.name)' v-for='(f, fIndex) in category_feature' :key='fIndex' >
                  <input type='checkbox' :value='f.name' :checked='product.feature_device == f.name ? true : false' :disabled='product.feature_device == f.name ? true : false'>
                  <span class='text'>{{f.name}}</span>
               </label>
            </div>

            <!-- PRODUCT DESCRIPTION for Water Device * just clone this -->
            <div v-show='listen_product_type == "water_device"' class='form-control form-select'>
               <div class='form-title'><?php echo __('Product Description', 'watergo'); ?></div>
               <textarea @input='autoResize("textarea1")' ref='textarea1' v-model='product.description' placeholder='<?php echo __('Nhập mô tả thiết bị', 'watergo'); ?>'></textarea>
            </div>

            <!-- DISCOUNT BOX -->
            <div class='form-checkbox form-check check-discount'>
               <label>
                  <input @click='discount_toggle' :checked='product.has_discount == 1 ? true : false' type='checkbox'>
                  <span class='text'><?php echo __('Discount', 'watergo'); ?></span>
               </label>
            </div>

            <div v-show='product.has_discount == 1' class='form-title'><?php echo __('Percentage Discount', 'watergo'); ?></div>
            <div v-show='product.has_discount == 1' class='form-control'>
               <input inputmode='numeric' v-model='product.discount_percent' type="text" pattern='[0-9]*' maxlength='3' max='100' placeholder='<?php echo __('Enter Percentage', 'watergo'); ?>'>
            </div>

            <div v-show='product.has_discount == 1' class='group-form-control'>
               <div class='form-control'>
                  <div class='form-title'><?php echo __('From', 'watergo'); ?></div>
                  <input 
                     id='discount_from' ref='discount_from' type="text" readonly placeholder='dd-mm-yyyy'>
               </div>
               <div class='form-control'>
                  <div class='form-title'><?php echo __('To', 'watergo'); ?></div>
                  <input 
                     id='discount_to' ref='discount_to' type="text" readonly placeholder='dd-mm-yyyy'>
               </div>
            </div>


            <div v-show='listen_product_type == "water"' class='form-title'><?php echo __('Size Description', 'watergo'); ?></div>

            <!-- QUANTITY -->
            <div v-show='listen_product_type == "water"' class='form-title small-size'><?php echo __('Quantity', 'watergo'); ?></div>
            <div v-show='listen_product_type == "water"' class='form-control form-select'>
               <select v-model='product.quantity'>
                  <option :value="null" selected disabled><?php echo __('Select Quantity', 'watergo'); ?></option>
                  <option 
                     v-for='(water_quantity, water_quantityIndex) in get_water_quantity' :key='water_quantityIndex'
                     :value="water_quantity.name">{{ water_quantity.name }}</option>
               </select>
               <span class='icon-select'>
                  <svg width="12" height="7" viewBox="0 0 12 7" fill="none" xmlns="http://www.w3.org/2000/svg">
                  <path d="M1 1L6 6L11 1" stroke="#252831" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                  </svg>
               </span>
            </div>

            <!-- VOLUME -->
            <div v-show='listen_product_type == "water"' class='form-title small-size'><?php echo __('Water Volume', 'watergo'); ?></div>
            <div v-show='listen_product_type == "water"' class='form-control form-select'>
               <select v-model='product.volume'>
                  <option :value="null" selected disabled><?php echo __('Select Volume', 'watergo'); ?></option>
                  <option 
                     v-for='(water_volume, water_volumeIndex) in get_water_volume' :key='water_volumeIndex'
                     :value="water_volume.name">{{ water_volume.name }}</option>
               </select>
               <span class='icon-select'>
                  <svg width="12" height="7" viewBox="0 0 12 7" fill="none" xmlns="http://www.w3.org/2000/svg">
                  <path d="M1 1L6 6L11 1" stroke="#252831" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                  </svg>
               </span>
            </div>

            <!-- PRODUCT DESCRIPTION -->
            <div v-show='listen_product_type == "water"' class='form-control form-select'>
               <div class='form-title'><?php echo __('Product Description', 'watergo'); ?></div>
               <textarea @input='autoResize("textarea2")' ref='textarea2' v-model='product.description' placeholder='<?php echo __('Enter Product Description', 'watergo'); ?>'></textarea>
            </div>

            <div class='form-title'><?php echo __('Photo', 'watergo'); ?></div>

            <ul class='form-photo'>
               <li class='upload'>
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
                  <button @click='btn_delete_product_image(imageIndex)'>
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
                  <button @click='btn_delete_upload_image(imageIndex)'>
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
                  <input @click='mark_out_of_stock' :checked='product.mark_out_of_stock == 1 ? true : false' type='checkbox'>
                  <span class='text'><?php echo __('Mark as out of stock', 'watergo'); ?></span>
               </label>
            </div>

            <div class='t-red'>{{ text_error }}</div>

            <div class='form-button'>
               <button @click='btn_action_product("add")' v-if='action == "add"' class='btn btn-primary' :class='is_can_action == false ? "disable" : ""'><?php echo __('Add', 'watergo'); ?></button>
               <button @click='btn_action_product("edit")' v-if='action == "edit"' class='btn btn-primary' :class='is_can_action == false ? "disable" : ""'><?php echo __('Save', 'watergo'); ?></button>
               <button @click='btn_modal_open' v-if='action == "edit"' class='btn btn-outline'><?php echo __('Delete', 'watergo'); ?></button>
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

var app = Vue.createApp({
   data (){

      return {
         popup_delete_product: false,
         loading: false,

         skipforce: '',

         disable_goback: false,

         // LISTENER PRODUCT TYPE 
         listen_product_type: 'water',

         product: {
            id: null,
            category: null,
            category_parent: null,
            product_type: null,
            description: null,
            brand: null,
            price: null,
            quantity: null,
            volume: null,
            has_discount: 0,
            discount_percent: null,
            mark_out_of_stock: 0,

            // THIET BI
            category_parent: null,
            name_device: null,
            feature_device: null,

         },

         store_id: null,

         is_can_action: false,

         category: [],
         category_parent: [],
         category_feature: [],

         uploadImages: [],
         productImages: [],
         list_attachment_id_delete: [],

         action: '',
         product_type: '',
         text_error: '',

         check_error: {
            listen_product_type: 'water',

            select_category:  false,
            select_category_parent: false,

            name_device:      false,
            feature_device:   false,

            price:            false,
            description:      false,

            // water
            water_brand:      false,
            water_quantity:   false,
            water_volume:     false,
           
            has_discount:     false,
            discount_percent: false,
            discount_from:    false,
            discount_to:      false,

            // image upload
            uploadImages:     false,
            productImages:    false,
         }
      }
   },

   watch: {

      // LISTEN EVENT SELECT
      'product.category': function( val ){
         // this.product.category_parent = null;
         if( val != ""){ this.check_error.select_category = true; }
         if( val == "Thiết bị nước" ){
            this.listen_product_type               = 'water_device';
            // RE-BUILD CHECK ERROR 
            this.check_error.listen_product_type   = 'water_device';
         }else{
            this.listen_product_type = 'water';
            // RE-BUILD CHECK ERROR 
            this.check_error.listen_product_type   = 'water';
         }
      },
      // WATCH DEVICE
      'product.category_parent': function( val ){
         if( val != null && val != ''){ this.check_error.select_category_parent = true; }
      },
      'product.name_device': function( val){
         if( val != null && val.length > 0 && val != ''){ this.check_error.name_device = true; }
         else{ this.check_error.name_device = false;}
      },
      'product.feature_device': function( val){
         if( val != null && val != '' ){ this.check_error.feature_device = true; }
      },
      // END WATCH DEVICE

      'product.brand': function( val ){
         if( val != null && val != ''){ this.check_error.water_brand = true; }
      },
      'product.quantity': function( val ){
         if( val != null && val != ''){ this.check_error.water_quantity = true; }
      },
      'product.volume': function ( val ){
         if( val != null && val != ''){ this.check_error.water_volume = true; }
      },

      'product.price': function( val ){
         if(val != undefined && val != null && val != ''){this.check_error.price = true;
         }else{this.check_error.price = false;}
      },
      'product.description': function( val ){
         if(val != undefined && val != null && val != ''){this.check_error.description = true;
         }else{this.check_error.description = false;}
      },
      'product.has_discount': function( val ){
         // discount_to
         if(val == 1 ){
            this.check_error.has_discount = true;
         }else{
            this.check_error.has_discount = false;
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
            // CHECK FOR WATER
            if( this.listen_product_type == 'water' ){
               if(
                  val.select_category == true &&
                  val.select_category_parent == true &&
                  val.price == true &&
                  val.description == true &&
                  ( val.uploadImages == true || val.productImages == true) &&
                  val.water_brand == true &&
                  val.water_quantity == true &&
                  val.water_volume == true
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

                  if( val.uploadImages == false && val.productImages == false && this.action == 'edit'){
                     this.is_can_action = false;
                  } else if(val.uploadImages == false && this.action == 'add'){
                     this.is_can_action = false;
                  }

               }else{
                  this.is_can_action = false;
               }
            }

            // CHECK FOR WATER-DEVICE
            if( this.listen_product_type == 'water_device' ){
               if(
                  val.select_category == true &&
                  val.name_device == true &&
                  val.feature_device == true &&
                  val.price == true &&
                  val.description == true &&
                  ( val.uploadImages == true || val.productImages == true)
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

      get_category(){
         return this.category.filter( cat => cat.category == 'water_category' );
      },

      get_brand(){
         return this.category.filter( cat => {
            if( cat.category == 'water_brand' ) return cat.category == 'water_brand';
         });
      },

      get_water_quantity(){
         return this.category.filter( cat => {
            if( cat.category == 'water_quantity' ) return cat.category == 'water_quantity';
         });
      },

      get_water_volume(){
         return this.category.filter( cat => {
            if( cat.category == 'water_volume' ) return cat.category == 'water_volume';
         });
      },
      //



   },

   methods: {
      autoResize( refName) {
         const maxHeight = 125;
         const textarea = this.$refs[refName];
         scrollHeight = textarea.scrollHeight;
         if (scrollHeight > maxHeight) {
            textarea.style.height = 'auto';
            textarea.style.height = textarea.scrollHeight + 'px';
         }
      },

      btn_select_category_feature( id ){
         this.product.feature_device = id;
      },

      btn_modal_open(){this.popup_delete_product = true;},
      btn_modal_cancel(){this.popup_delete_product = false;},

      async btn_modal_confirm(){
         this.popup_delete_product = false;
         this.loading = true;
         var form = new FormData();
         form.append('action', 'atlantis_action_product_water');
         form.append('event', 'delete' );
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
                  await window.parent.app.btn_delete_product(this.product_id);
               }
               this.goBackDelete(_product_id);
            }
         }

      },

      async btn_action_product( event ){

         var _discount_from   = 0;
         var _discount_to     = 0;

         if( this.product.discount_from != null && this.product.discount_from != 0){
            _discount_from = window.reverse_date_to_system_datetime(this.product.discount_from);
         }
         if( this.$refs.discount_from.value != undefined && this.$refs.discount_from.value != '' ) {
            _discount_from = window.reverse_date_to_system_datetime(this.$refs.discount_from.value);
         }
         if( this.product.discount_to != null && this.product.discount_to != 0){
            _discount_to = window.reverse_date_to_system_datetime(this.product.discount_to) ;
         }
         if( this.$refs.discount_to.value != undefined && this.$refs.discount_to.value != '' ){            
            _discount_to =  window.reverse_date_to_system_datetime( this.$refs.discount_to.value );
         }
         if(_discount_from == undefined || _discount_from == null ){
            _discount_from = null;
         }
         if(_discount_to == undefined || _discount_to == null ){
            _discount_to = null;
         }

         var form = new FormData();
         form.append('action', 'atlantis_action_product_water');
         form.append('event', event);
         form.append('product_type', this.listen_product_type );
         form.append('store_id', this.store_id );

         if( event == 'add' ){
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

         if( this.product.has_discount == undefined || this.product.has_discount == null || this.product.has_discount == 0 ){
            this.product.has_discount     = 0;
            this.product.discount_percent = 0;
            _discount_from                = 0;
            _discount_to                  = 0;
         }

         form.append('has_discount',      this.product.has_discount);
         form.append('discount_percent',  this.product.discount_percent);
         form.append('discount_from',     _discount_from);
         form.append('discount_to',       _discount_to);
         
         if( this.is_can_action == true ){
            this.loading = true;
            form.append('category',        this.product.category );
            form.append('price',           this.product.price );
            form.append('description',     this.product.description);

            if(this.listen_product_type == 'water'){
               form.append('category_parent', this.product.category_parent );
               form.append('brand',     this.product.brand );
               form.append('quantity',  this.product.quantity);
               form.append('volume',    this.product.volume);
            }else if(this.listen_product_type == 'water_device'){
               form.append('name_device', this.product.name_device );
               form.append('feature_device', this.product.feature_device );
            }
            
            var r = await window.request(form);
            
            if( r != undefined ){
               var res = JSON.parse( JSON.stringify( r ));
               if( res.message == 'action_product_ok'){
                  var _product_id = res.data;
                  if(this.disable_goback == true ){
                     window.parent.app.btn_close_popup(_product_id);
                  }else{
                     this.goBackUpdate(_product_id);
                  }
               }else{
                  this.loading = false;
               }
            }else{
               this.loading = true;
            }

         }

      },


      btn_delete_upload_image( indexImage ){ this.uploadImages.splice(indexImage, 1) },
      btn_delete_product_image( indexImage ){ 
         this.list_attachment_id_delete.push(parseInt( this.productImages[indexImage].id) );
         this.productImages.splice(indexImage, 1);
      },

      discount_toggle(){
         if( this.product.has_discount == 1 ){
            this.product.has_discount = 0;
         }else{
            this.product.has_discount = 1;
         }
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
         console.log(r);
         
         if( r != undefined ){
            var res = JSON.parse( JSON.stringify( r));
            if( res.message == 'product_found' ){
               this.product = res.data;

               let _char   = jQuery('.input-trailing').data('trailing');
               $('.input-trailing').val(this.product.weight + ' ' + _char);

               if( this.product.discount_percent == 0 ){
                  this.product.discount_percent = null;
               }
               
               // FILL DISCOUNT
               if(this.product.has_discount == 1){
                  if( this.product.discount_from != null && this.product.discount_from != 0 ) {
                     $('#discount_from').attr('value', window.reverse_system_datetime_to_date(this.product.discount_from) );
                  }
                  if( this.product.discount_to != null && this.product.discount_to != 0 ){
                     $('#discount_to').attr('value', window.reverse_system_datetime_to_date(this.product.discount_to) );
                  }
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

      /**
       * @access CATEGORY SETUP
       */
      this.category           = JSON.parse('<?php echo json_encode($category_primary) ?>');
      this.category_parent    = JSON.parse('<?php echo json_encode($category_parent) ?>');
      this.category_feature   = JSON.parse('<?php echo json_encode($category_feature) ?>');

      this.loading = true;
      var urlParams = new URLSearchParams(window.location.search);
      this.product_id     = urlParams.get('product_id');
      this.store_id       = urlParams.get('store_id');
      this.action         = urlParams.get('action');
      this.skipforce      = urlParams.get('skipforce');

      const disable       = urlParams.get('disable');
      if( disable == 'goback' ){
         this.disable_goback = true;
      }

      if( this.action == 'edit' ){
         await this.atlantis_find_product(this.product_id);
         if( this.product.mark_out_of_stock == null ){
            this.product.mark_out_of_stock = 0;
         }

      }

      window.appbar_fixed();

      (function($){
         $(document).ready(function(){

            // Define an object that holds the month and day names for different locales
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

            $('#discount_from').click(function(){
               $('.ui-date-picker-wrapper').addClass('active');
            });
            $('#discount_to').click(function(){
               $('.ui-date-picker-wrapper').addClass('active');
            });

            $('#discount_from').datepicker({
               // dayNamesMin: [ "Sun", "Mon", "Tue", "Wed", "Thu", "Fri", "Sat" ],
               minDate: 0,
               dateFormat: "dd/mm/yy",
               firstDay: 1,

               monthNames:       localeData[locale].monthNames,
               monthNamesShort:  localeData[locale].monthNamesShort,
               dayNames:         localeData[locale].dayNames,
               dayNamesShort:    localeData[locale].dayNamesShort,
               dayNamesMin:      localeData[locale].dayNamesMin,
               
               onSelect: function(dateText, inst){
                  if(dateText != undefined || dateText != '' || dateText != null){
                     $('#discount_from').attr('value', dateText); 

                     window.app.product.discount_from = dateText;

                     var discount_from = $('#discount_from').datepicker('getDate');
                     // Calculate the next day
                     var nextDay = new Date(discount_from);
                     nextDay.setDate(nextDay.getDate() + 1);
                     var day = nextDay.getDate().toString().padStart(2, '0');
                     var month = (nextDay.getMonth() + 1).toString().padStart(2, '0');
                     var year = nextDay.getFullYear();
                     var fullday = day + '/' + month + '/' + year;
                     if (fullday) {
                        $('#discount_to').datepicker('option', 'minDate', fullday);
                     }
                  }
               },
               onClose: function(dateText, inst){
                  $('.ui-date-picker-wrapper').removeClass('active');
               }
            });
            $('#discount_to').datepicker({
               // dayNamesMin: [ "Sun", "Mon", "Tue", "Wed", "Thu", "Fri", "Sat" ],
               minDate: 0,
               dateFormat: "dd/mm/yy",
               firstDay: 1,

               monthNames:       localeData[locale].monthNames,
               monthNamesShort:  localeData[locale].monthNamesShort,
               dayNames:         localeData[locale].dayNames,
               dayNamesShort:    localeData[locale].dayNamesShort,
               dayNamesMin:      localeData[locale].dayNamesMin,

               onSelect: function(dateText, inst){
                  if(dateText != undefined || dateText != '' || dateText != null){
                     $('#discount_to').attr('value', dateText); 
                     window.app.product.discount_to = dateText;
                  }
               },
               onClose: function(dateText, inst){
                  $('.ui-date-picker-wrapper').removeClass('active');
               }
            });
            // add wrapper for picker
            if( $('.ui-date-picker-wrapper #ui-datepicker-div').length == 0 ){
               $('#ui-datepicker-div').wrap('<div class="ui-date-picker-wrapper"></div>');
            }

         });
      })(jQuery);
      setTimeout( () => {this.autoResize("textarea1");}, 0);
      setTimeout( () => {this.autoResize("textarea2");}, 0);
      this.loading = false;

   },

}).mount('#app');

window.app = app;

</script>
