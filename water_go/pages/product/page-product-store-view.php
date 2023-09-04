<?php 
/**
 * @access THIS IS TAB PRODUCT STORE 
 */

?>

<link defer rel="stylesheet" href="<?php echo THEME_URI . '/assets/js/jquery_ui_1.13.2.min.css'; ?>">
<script defer src="<?php echo THEME_URI . '/assets/js/jquery_ui_1.13.2.min.js'; ?>"></script>

<div id='app'>
   <div v-show='loading == false' class='page-product-store-view'>

      <div class='appbar'>
         <div class='appbar-top'>
            <div class='leading'>
               <button @click='goBack' class='btn-action'>
                  <svg width="11" height="16" viewBox="0 0 11 16" fill="none" xmlns="http://www.w3.org/2000/svg">
                  <path fill-rule="evenodd" clip-rule="evenodd" d="M10.5309 0.375342C10.8759 0.806604 10.806 1.4359 10.3747 1.78091L2.60078 8.00004L10.3747 14.2192C10.806 14.5642 10.8759 15.1935 10.5309 15.6247C10.1859 16.056 9.55657 16.1259 9.12531 15.7809L0.375305 8.78091C0.13809 8.59113 0 8.30382 0 8.00004C0 7.69625 0.13809 7.40894 0.375305 7.21917L9.12531 0.219168C9.55657 -0.125842 10.1859 -0.0559202 10.5309 0.375342Z" fill="#252831"/>
                  </svg>
               </button>
               <p class='leading-title'>{{ leading_title }}</p>
            </div>

         </div>
      </div>

      <!-- FORM  -->
      <div class='inner'>
         <div class='product-store-view-form'>

            <div class='form-title'><?php echo __('Category', 'watergo'); ?></div>
            <div class='form-control form-select'>
               <select v-model='select_category'>
                  <option :value="{ value: 0 }" disabled><?php echo __('Select Category', 'watergo'); ?></option>
                  <option 
                     v-for='(cat, catIndex) in get_category' :key='catIndex'
                     :value="{ value: cat.id }">{{ cat.name }}</option>
               </select>
               <span class='icon-select'>
                  <svg width="12" height="7" viewBox="0 0 12 7" fill="none" xmlns="http://www.w3.org/2000/svg">
                  <path d="M1 1L6 6L11 1" stroke="#252831" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                  </svg>
               </span>
            </div>

            <div v-show='product_type == "water"' class='form-title'><?php echo __('Brand', 'watergo'); ?></div>
            <div v-show='product_type == "water"' class='form-control form-select'>
               <select v-model='water_brand'>
                  <option :value="{ value: 0 }" disabled><?php echo __('Select Brand', 'watergo'); ?></option>
                  <option 
                     v-for='(brand, brandIndex) in get_brand' :key='brandIndex'
                     :value="{ value: brand.id }">{{ brand.name }}</option>
               </select>
               <span class='icon-select'>
                  <svg width="12" height="7" viewBox="0 0 12 7" fill="none" xmlns="http://www.w3.org/2000/svg">
                  <path d="M1 1L6 6L11 1" stroke="#252831" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                  </svg>
               </span>
            </div>

            <div class='form-control'>
               <div class='form-title'><?php echo __('Price', 'watergo'); ?></div>
               <input inputmode='numeric' v-model='product.price' type="text" pattern='[0-9]*' placeholder='0đ'>
            </div>
               <!-- <div class='form-control'>
                  <div class='form-title'>Stock</div>
                  <input v-model='product.stock' type="text" pattern='[0-9]*' placeholder='0' :disabled='product.mark_out_of_stock == true ? true : false'>
               </div> -->

            <div class='form-checkbox form-check check-discount'>
               <label>
                  <input @click='discount_toggle' :checked='product.has_discount == 1 ? true : false' type='checkbox'>
                  <span class='text'><?php echo __('Discount', 'watergo'); ?></span>
               </label>
            </div>

            <div v-show='product.has_discount == 1' class='form-title'><?php echo __('Percentage Discount', 'watergo'); ?></div>
            <div v-show='product.has_discount == 1' class='form-control'>
               <input 
                  inputmode='numeric' v-model='product.discount_percent' type="text" pattern='[0-9]*' maxlength='3' max='100' placeholder='<?php echo __('Enter Percentage', 'watergo'); ?>'>
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


            <div class='form-title'><?php echo __('Size Description', 'watergo'); ?></div>

            <!-- SIZE ICE -->
            <div v-show='product_type == "ice"' class='form-title small-size'><?php echo __('Weight', 'watergo'); ?></div>
            <div v-show='product_type == "ice"' class='form-control form-select'>
               <select v-model='ice_weight'>
                  <option :value="{ value: 0 }" disabled><?php echo __('Select Weight', 'watergo') ?></option>
                  <option 
                     v-for='( ice_weight_item, ice_weightIndex) in get_ice_weight' :key='ice_weightIndex'
                     :value="{ value: ice_weight_item.id }">{{  ice_weight_item.name }}</option>
               </select>
               <span class='icon-select'>
                  <svg width="12" height="7" viewBox="0 0 12 7" fill="none" xmlns="http://www.w3.org/2000/svg">
                  <path d="M1 1L6 6L11 1" stroke="#252831" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                  </svg>
               </span>
            </div>

            <div v-show='product_type == "ice"' class='form-title'><?php echo __('Length * Width', 'watergo'); ?></div>
            <div v-show='product_type == "ice"' class='form-control'>
               <div class='form-type-length-width'>
                  <div class='form-type-length-width-wrapper'>
                  <input inputmode='numeric' v-model='size_length' class='type-length' pattern='[0-9]*' maxlength='4' type='text' placeholder='____'>
                  <span class='placeholder'>*</span>
                  <input inputmode='numeric' v-model='size_width' class='type-width' pattern='[0-9]*' maxlength='4' type='text' placeholder='____'>
                  <span class='placeholder'> mm</span>
                  </div>
               </div>
            </div>
            <!-- END SIZE ICE -->

            <!-- SIZE WATER -->
            <div v-show='product_type == "water"' class='form-title small-size'><?php echo __('Quantity', 'watergo'); ?></div>
            <div v-show='product_type == "water"' class='form-control form-select'>
               <select v-model='water_quantity'>
                  <option :value="{ value: 0 }" disabled><?php echo __('Select Quantity', 'watergo'); ?></option>
                  <option 
                     v-for='(water_quantity, water_quantityIndex) in get_water_quantity' :key='water_quantityIndex'
                     :value="{ value: water_quantity.id }">{{ water_quantity.name }}</option>
               </select>
               <span class='icon-select'>
                  <svg width="12" height="7" viewBox="0 0 12 7" fill="none" xmlns="http://www.w3.org/2000/svg">
                  <path d="M1 1L6 6L11 1" stroke="#252831" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                  </svg>
               </span>
            </div>

            <div v-show='product_type == "water"' class='form-title small-size'><?php echo __('Water Volume', 'watergo'); ?></div>
            <div v-show='product_type == "water"' class='form-control form-select'>
               <select v-model='water_volume'>
                  <option :value="{ value: 0 }" disabled><?php echo __('Select Volume', 'watergo'); ?></option>
                  <option 
                     v-for='(water_volume, water_volumeIndex) in get_water_volume' :key='water_volumeIndex'
                     :value="{ value: water_volume.id }">{{ water_volume.name }}</option>
               </select>
               <span class='icon-select'>
                  <svg width="12" height="7" viewBox="0 0 12 7" fill="none" xmlns="http://www.w3.org/2000/svg">
                  <path d="M1 1L6 6L11 1" stroke="#252831" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                  </svg>
               </span>
            </div>

            <!-- END SIZE WATER -->

            <div class='form-title'><?php echo __('Product Description', 'watergo'); ?></div>
            <div class='form-control form-select'>
               <textarea @input='autoResize' ref='textarea' v-model='product.description' placeholder='<?php echo __('Enter Product Description', 'watergo'); ?>'></textarea>
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
         store_id: null,
         product: {
            id: null,
            product_type: '',
            description: '',
            brand: null,
            price: null,
            stock: null,
            quantity: null,
            volume: null,
            weight: null,
            length_width: '',
            has_discount: 0,
            discount_percent: null,
            mark_out_of_stock: 0,
            // product_image in visible
         },

         is_can_action: false,

         size_length: null,
         size_width: null,

         category: [],
         uploadImages: [],
         productImages: [],
         list_attachment_id_delete: [],

         select_category: { value: 0 },
         water_brand: { value: 0 },
         water_quantity: { value: 0 },
         water_volume: { value: 0 },

         ice_weight: { value: 0 },

         action: '',
         product_type: '',
         leading_title: '',
         text_error: '',

         check_error: {
            select_category:  false,
            price:            false,
            description:      false,
            // water
            water_brand:      false,
            water_quantity:   false,
            water_volume:     false,
            // ice
            ice_weight:       false,
            size_length:      false,
            size_width:       false,
            //
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
      

      'product.category': function( val ){
         if( val.value != 0){ this.check_error.select_category = true; }
      },
      select_category: function(val){
         if( val.value != 0){ this.check_error.select_category = true; }
      },
      // water
      'product.brand': function( val ){
         if( val != null && val != 0){ this.check_error.water_brand = true; }
      },
      water_brand: function( val ){
         if( val.value != null && val.value != 0 ){ this.check_error.water_brand = true; }
      },
      'product.quantity': function( val ){
         if( val != null && val != 0){ this.check_error.water_quantity = true; }
      },
      water_quantity: function( val ){
         if( val.value != 0){ this.check_error.water_quantity = true; }
      },
      'product.volume': function ( val ){
         if( val != null && val != 0){ this.check_error.water_volume = true; }
      },
      water_volume: function( val ){
         if( val.value != 0){ this.check_error.water_volume = true; }
      },
      // ice
      'product.weight': function( val ){
         if( val != null && val != 0 ){ this.check_error.ice_weight = true; }
      },
      ice_weight: function( val ){
         if( val.value != 0 ){ this.check_error.ice_weight = true; }
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
            if( this.product_type == 'ice'){
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

                  if( val.uploadImages == false && val.productImages == false && this.action == 'edit'){
                     this.is_can_action = false;
                  } else if(val.uploadImages == false && this.action == 'add'){
                     this.is_can_action = false;
                  }

               }else{
                  this.is_can_action = false;
               }
            }

            if( this.product_type == 'water'){
               if(
                  val.select_category == true &&
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

         },
         deep: true,
      },



   },

   computed: {

      get_category(){
         return this.category.filter( cat => {
            if( cat.category == 'water_category' && this.product_type == 'water' ){
               return cat.category == 'water_category';
            }
            else if( cat.category == 'ice_category' && this.product_type == 'ice' ){
               return cat.category == 'ice_category';
            }
         });
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

      get_ice_weight(){
         return this.category.filter( cat => {
            if( cat.category == 'ice_weight') return cat.category == 'ice_weight';
         });
      },
      

   },

   methods: {
      autoResize() {
         const scrollHeight = this.$refs.textarea.scrollHeight;
         const maxHeight = 125;
         if (scrollHeight > maxHeight) {
            this.$refs.textarea.style.height = 'auto';
            this.$refs.textarea.style.height = this.$refs.textarea.scrollHeight + 'px';
         }
      },

      btn_modal_open(){this.popup_delete_product = true;},
      btn_modal_cancel(){this.popup_delete_product = false;},

      async btn_modal_confirm(){
         this.popup_delete_product = false;
         this.loading = true;
         var form = new FormData();
         form.append('action', 'atlantis_action_product_store');
         form.append('event', 'delete');
         form.append('product_type', this.product_type);
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
         form.append('action', 'atlantis_action_product_store');
         form.append('event', event);
         form.append('product_type', this.product_type);
         form.append('store_id', this.store_id);
         form.append('product_id', this.product_id);
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

         // console.log(this.check_error);

         /**
         *  @access PRODUCT TYPE {ICE}
         */
         if( this.product_type == 'ice' && this.is_can_action == true ){

            this.loading = true;
            form.append('category_id', this.select_category.value );
            form.append('price', this.product.price );
            form.append('ice_weight', this.ice_weight.value);
            this.product.length_width = this.size_length + '*' + this.size_width;
            form.append('length_width', this.product.length_width);
            form.append('product_description', this.product.description);

            var r = await window.request(form);

            if( r != undefined ){
               var res = JSON.parse( JSON.stringify( r ));
               if( res.message == 'action_product_ok'){
                  var _product_id = res.data;
                  this.goBackUpdate(_product_id);
               }else{
                  this.loading = false;
               }
            }else{
               this.loading = false;
            }
         }
         
         /**
         *  @access PRODUCT TYPE {WATER}
         */

         if( this.product_type == 'water' && this.is_can_action == true ){
            this.loading = true;
            form.append('category_id',          this.select_category.value );
            form.append('water_brand',          this.water_brand.value );
            form.append('price',                this.product.price );
            form.append('water_quantity',       this.water_quantity.value);
            form.append('water_volume',         this.water_volume.value);
            form.append('product_description',  this.product.description);

            var r = await window.request(form);

            if( r != undefined ){
               var res = JSON.parse( JSON.stringify( r ));
               if( res.message == 'action_product_ok'){
                  var _product_id = res.data;
                  this.goBackUpdate(_product_id);
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

      async get_product(product_id){
         var form = new FormData();
         form.append('action', 'atlantis_find_product');
         form.append('product_id', product_id);
         form.append('limit_image', 0);
         var r = await window.request(form);
         // console.log(r);
         if( r != undefined ){
            var res = JSON.parse( JSON.stringify( r));
            if( res.message == 'product_found' ){
               this.product = res.data;

               this.select_category.value    = this.product.category;
               this.water_brand.value        = this.product.brand;
               this.water_quantity.value     = this.product.quantity;
               this.water_volume.value       = this.product.volume;
               this.ice_weight.value         = this.product.weight;

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
         console.log();

      },

      async get_product_category(){
         var form = new FormData();
         form.append('action', 'atlantis_get_product_category');
         var r = await window.request(form);

         if( r != undefined ){
            var res = JSON.parse( JSON.stringify( r));
            if( res.message == 'product_category_found' ){
               this.category.push(...res.data);
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
      get_leading_title( product_type ){
         if( product_type == 'water'){ this.leading_title = '<?php echo __("Add Water Product", 'watergo'); ?>'; }
         if( product_type == 'ice'){ this.leading_title = '<?php echo __("Add Ice Product", 'watergo'); ?>'; }
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
      this.loading = true;
      var urlParams = new URLSearchParams(window.location.search);
      var product_id     = urlParams.get('product_id');
      var product_type   = urlParams.get('product_type');
      var store_id       = urlParams.get('store_id');
      var action         = urlParams.get('action');

      this.action       = action;
      this.product_type = product_type;
      this.store_id     = store_id;
      this.product_id   = product_id;

      if( action == 'add' ){
         this.get_leading_title(product_type);
      }

      if( action == 'edit' ){

         await this.get_product(product_id);
         this.leading_title = this.product.name;
         if( this.product.mark_out_of_stock == null ){
            this.product.mark_out_of_stock = 0;
         }

         if( product_type == 'ice' && this.product.length_width != null && this.product.length_width.length != '' ){
            var [_length, _width]   = this.product.length_width.split('*');
            this.size_length        = _length;
            this.size_width         = _width;
         }

      }

      await this.get_product_category();

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
      setTimeout( () => {this.autoResize();}, 0);
      this.loading = false;
   },

}).mount('#app');

window.app = app;

</script>