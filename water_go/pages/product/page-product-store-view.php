<?php 
/**
 * @access THIS IS TAB PRODUCT STORE 
 */

?>

<link rel="stylesheet" href="<?php echo THEME_URI . '/assets/js/jquery_ui_1.13.2.min.css'; ?>">
<script src="<?php echo THEME_URI . '/assets/js/jquery_ui_1.13.2.min.js'; ?>"></script>

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

            <div class='form-title'>Category</div>
            <div class='form-control form-select'>
               <select v-model='select_category'>
                  <option :value="{ value: 0 }" disabled>Select Category</option>
                  <option 
                     v-for='(cat, catIndex) in get_category' :key='catIndex'
                     :value="{ value: cat.id }">{{ cat.name }}</option>
               </select>
            </div>

            <div v-show='product_type == "water"' class='form-title'>Brand</div>
            <div v-show='product_type == "water"' class='form-control form-select'>
               <select v-model='water_brand'>
                  <option :value="{ value: 0 }" disabled>Select Brand</option>
                  <option 
                     v-for='(brand, brandIndex) in get_brand' :key='brandIndex'
                     :value="{ value: brand.id }">{{ brand.name }}</option>
               </select>
            </div>

            <div class='group-form-control'>
               <div class='form-control'>
                  <div class='form-title'>Price</div>
                  <input v-model='product.price' type="text" pattern='[0-9]*' placeholder='0đ'>
               </div>
               <div class='form-control'>
                  <div class='form-title'>Stock</div>
                  <input v-model='product.stock' type="text" pattern='[0-9]*' placeholder='0' :disabled='product.mark_out_of_stock == true ? true : false'>
               </div>
            </div>

            <div class='form-checkbox form-check check-discount'>
               <label>
                  <input @click='discount_toggle' :checked='product.has_discount == 1 ? true : false' type='checkbox'>
                  <span class='text'>Discount</span>
               </label>
            </div>

            <div v-show='product.has_discount == 1' class='form-title'>Percentage Discount</div>
            <div v-show='product.has_discount == 1' class='form-control'>
               <input v-model='product.discount_percent' type="text" pattern='[0-9]*' maxlength='3' max='100' placeholder='Enter Percentage'>
            </div>

            <div v-show='product.has_discount == 1' class='group-form-control'>
               <div class='form-control'>
                  <div class='form-title'>From</div>
                  <input id='discount_from' ref='discount_from' type="text" readonly placeholder='dd-mm-yyyy'>
               </div>
               <div class='form-control'>
                  <div class='form-title'>To</div>
                  <input id='discount_to' ref='discount_to' type="text" readonly placeholder='dd-mm-yyyy'>
               </div>
            </div>


            <div class='form-title'>Size Description</div>

            <!-- SIZE ICE -->
            <div v-show='product_type == "ice"' class='form-title small-size'>Weight</div>
            <div v-show='product_type == "ice"' class='form-control form-select'>
               <select v-model='ice_weight'>
                  <option :value="{ value: 0 }" disabled>Select Weight</option>
                  <option 
                     v-for='(ice_weight, ice_weightIndex) in get_ice_weight' :key='ice_weightIndex'
                     :value="{ value: ice_weight.id }">{{  ice_weight.name }}</option>
               </select>
            </div>

            <div v-show='product_type == "ice"' class='form-title'>Length * Width</div>
            <div v-show='product_type == "ice"' class='form-control'>
               <input v-model='product.length_width' type="text" placeholder='_____ * _____ mm'>
            </div>
            <!-- END SIZE ICE -->

            <!-- SIZE WATER -->
            <div v-show='product_type == "water"' class='form-title small-size'>Quantity</div>
            <div v-show='product_type == "water"' class='form-control form-select'>
               <select v-model='water_quantity'>
                  <option :value="{ value: 0 }" disabled>Select Quantity</option>
                  <option 
                     v-for='(water_quantity, water_quantityIndex) in get_water_quantity' :key='water_quantityIndex'
                     :value="{ value: water_quantity.id }">{{ water_quantity.name }}</option>
               </select>
            </div>

            <div v-show='product_type == "water"' class='form-title small-size'>Water Volume</div>
            <div v-show='product_type == "water"' class='form-control form-select'>
               <select v-model='water_volume'>
                  <option :value="{ value: 0 }" disabled>Select Volume</option>
                  <option 
                     v-for='(water_volume, water_volumeIndex) in get_water_volume' :key='water_volumeIndex'
                     :value="{ value: water_volume.id }">{{ water_volume.name }}</option>
               </select>
            </div>

            <!-- END SIZE WATER -->

            <div class='form-title'>Product Description</div>
            <div class='form-control form-select'>
               <textarea v-model='product.description' placeholder='Enter Product Description'></textarea>
            </div>

            <div class='form-title'>Photo</div>

            <ul class='form-photo'>
               <li class='upload'>
                  <label>
                     <input id='UploadPhoto' type="file" multiple @change="handleFileUpload" />
                     <svg width="104" height="107" viewBox="0 0 104 107" fill="none" xmlns="http://www.w3.org/2000/svg">
                     <rect x="1" y="1" width="102" height="105" rx="4" fill="white" stroke="#2790F9" stroke-width="2" stroke-dasharray="20 20"/>
                     </svg>
                     <span>Add Photo</span>
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

            <div v-show='action =="edit"' class='form-checkbox form-check check-out-of-stock'>
               <label>
                  <input @click='mark_out_of_stock' :checked='product.mark_out_of_stock == true ? true : false' type='checkbox'>
                  <span class='text'>Mark as out of stock</span>
               </label>
            </div>

            <div class='t-red'>{{ text_error }}</div>

            <div class='form-button'>
               <button @click='btn_action_product("add")' v-if='action == "add"' class='btn btn-primary'>Add</button>
               <button @click='btn_action_product("edit")' v-if='action == "edit"' class='btn btn-primary'>Save</button>
               <button @click='btn_modal_open' v-if='action == "edit"' class='btn btn-outline'>Delete</button>
            </div>

            

         </div>
      </div>

   </div>

   <div v-show='popup_delete_product == true' class='modal-popup open'>
      <div class='modal-wrapper'>
         <p class='heading'>Do you want to delete this product?</p>
         <div class='actions'>
            <button @click='btn_modal_cancel' class='btn btn-outline'>Cancel</button>
            <button @click='btn_modal_confirm' class='btn btn-primary'>Confirm</button>
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
            // product_image in visible
         },

         // CHECK USE HAS DISCOUNT
         ref_history_has_discount: 0,

         category: [],
         uploadImages: [],
         productImages: [],
         list_attachment_id_delete: [],

         select_category: { value: 0 },
         water_brand: { value: 0 },
         water_quantity: { value: 0 },
         water_volume: { value: 0 },
         water_volume: { value: 0 },

         ice_weight: { value: 0 },

         action: '',
         product_type: '',
         leading_title: '',
         text_error: ''

      }
   },

   watch: {
      
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
               this.goBack();
            }
         }

      },

      async btn_action_product( event ){
         
         this.loading = true;
         var _discount_from = this.$refs.discount_from.value;
         var _discount_to = this.$refs.discount_to.value;

         var form = new FormData();
         form.append('action', 'atlantis_action_product_store');
         form.append('event', event);
         form.append('product_type', this.product_type);
         form.append('store_id', this.store_id);
         form.append('product_id', this.product_id);
         form.append('list_attachment_id_delete', JSON.stringify(this.list_attachment_id_delete) );

         // FOR EVENT EDIT
         if( event == 'edit' ){
            // WHEN USER WANT REMOVE DISCOUNT
            if(this.ref_history_has_discount == 1 && this.product.has_discount == 0){
               form.append('has_discount',      0);
               form.append('discount_percent',  0);
               form.append('discount_from',     0);
               form.append('discount_to',       0);
               form.append('force_remove_has_discount', 1);
            }
         }

         /**
          * @access PRODUCT TYPE {ICE}
          */
         if( this.product_type  == 'ice' ){
            // check all is empty?
            if(
               this.select_category.value == 0 ||
               ( this.product.price == 0 || this.product.price == null ) ||
               ( this.product.stock == 0 || this.product.stock == null ) ||
               this.ice_weight.value == 0 ||
               this.product.length_width == '' ||
               this.product.description == '' || 
               (this.uploadImages.length == 0 && this.productImages.length == 0)
            ){
               this.text_error = 'All field must be not empty.';
            }else{
               this.text_error = '';
               form.append('category_id', this.select_category.value );
               form.append('price', this.product.price );
               form.append('stock', this.product.stock );
               form.append('ice_weight', this.ice_weight.value);
               form.append('length_width', this.product.length_width);
               form.append('product_description', this.product.description);
               
               this.uploadImages.forEach( file => form.append('uploadImages[]', file.file ));

               var _submit = false;

               // CHECK IF DISCOUNT HAS ENABLE
               if( this.product.has_discount == true ){
                  if( 
                     ( _discount_from == undefined || _discount_from == '' ) ||
                     ( _discount_to == undefined || _discount_to == '' ) ||
                     ( this.product.discount_percent == 0 || this.product.discount_percent == null ) 
                  ){
                     this.text_error = 'All field must be not empty.';
                  }else{
                     this.text_error = '';
                     form.append('has_discount',      1);
                     form.append('discount_percent',  this.product.discount_percent);
                     form.append('discount_from',     _discount_from);
                     form.append('discount_to',       _discount_to);
                     _submit = true;
                  }
               }else{
                  _submit = true;
               }

               if( _submit == true ){
                  var r = await window.request(form);
                  if( r != undefined ){
                     var res = JSON.parse( JSON.stringify( r ));
                     if( res.message == 'action_product_ok'){
                        this.goBack();
                     }
                  }
               }
            }

         }

         /**
          * @access PRODUCT TYPE {WATER}
          */
         if( this.product_type == 'water' ){
            // check all is empty?
            if(
               this.select_category.value == 0 ||
               this.water_brand.value == 0 ||
               ( this.product.price == 0 || this.product.price == null ) ||
               ( this.product.stock == 0 || this.product.stock == null ) ||
               this.water_quantity.value == 0 ||
               this.water_volume.value == 0 ||
               this.product.description == '' || 
               this.uploadImages.length == 0
            ){
               this.text_error = 'All field must be not empty.';
            }else{
               this.text_error = '';
               form.append('category_id', this.select_category.value );
               form.append('water_brand', this.water_brand.value );
               form.append('price', this.product.price );
               form.append('stock', this.product.stock );
               form.append('water_quantity', this.water_quantity.value);
               form.append('water_volume', this.water_volume.value);
               form.append('product_description', this.product.description);
               
               this.uploadImages.forEach( file => form.append('uploadImages[]', file.file ) );

               var _submit = false;

               // CHECK IF DISCOUNT HAS ENABLE
               if( this.product.has_discount == true ){
                  if( 
                     ( _discount_from == undefined || _discount_from == '' ) ||
                     ( _discount_to == undefined || _discount_to == '' ) ||
                     ( this.product.discount_percent == 0 || this.product.discount_percent == null ) 
                  ){
                     this.text_error = 'All field must be not empty.';
                  }else{
                     this.text_error = '';
                     form.append('has_discount',      1);
                     form.append('discount_percent',  this.product.discount_percent);
                     form.append('discount_from',     _discount_from);
                     form.append('discount_to',       _discount_to);
                     _submit = true;
                  }
               }else{
                  _submit = true;
               }

               if( _submit == true ){
                  var r = await window.request(form);
                  if( r != undefined ){
                     var res = JSON.parse( JSON.stringify( r ));
                     if( res.message == 'action_product_ok' ){
                        this.goBack();
                     }
                  }
               }

               

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
         this.product.mark_out_of_stock = !this.product.mark_out_of_stock;
         this.product.stock = 0; 
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
               this.product = res.data;

               this.select_category.value = this.product.category;
               this.water_brand.value = this.product.brand;
               this.water_quantity.value = this.product.quantity;
               this.water_volume.value = this.product.volume;
               this.water_volume.value = this.product.volume;
               this.ice_weight.value = this.product.weight;

               // FILL DISCOUNT
               if(this.product.has_discount == 1){
                  $('#discount_from').attr('value', this.product.discount_from);
                  $('#discount_to').attr('value', this.product.discount_to);
                  this.ref_history_has_discount = 1;
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
         if( product_type == 'water'){ this.leading_title = 'Add Water Product'; }
         if( product_type == 'ice'){ this.leading_title = 'Add Ice Product'; }
      },

      goBack(){ window.goBack(true)},

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
      }

      await this.get_product_category();

      window.appbar_fixed();

      (function($){
         $(document).ready(function(){

            $('#discount_from').click(function(){
               $('.ui-date-picker-wrapper').addClass('active');
            });
            $('#discount_to').click(function(){
               $('.ui-date-picker-wrapper').addClass('active');
            });

            $('#discount_from').datepicker({
               dayNamesMin: [ "Sun", "Mon", "Tue", "Wed", "Thu", "Fri", "Sat" ],
               minDate: 0,
               dateFormat: "dd/mm/yy",
               firstDay: 1,
               onSelect: function(dateText, inst){
                  if(dateText != undefined || dateText != '' || dateText != null){
                     $('#discount_from').attr('value', dateText); 
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
               dayNamesMin: [ "Sun", "Mon", "Tue", "Wed", "Thu", "Fri", "Sat" ],
               minDate: 0,
               dateFormat: "dd/mm/yy",
               firstDay: 1,
               onSelect: function(dateText, inst){
                  if(dateText != undefined || dateText != '' || dateText != null){
                     $('#discount_to').attr('value', dateText); 
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
      this.loading = false;
   },

}).mount('#app');

</script>