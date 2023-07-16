<?php 
/**
 * @access THIS IS TAB PRODUCT STORE 
 */

?>
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

            <div class='form-title'>Brand</div>
            <div class='form-control form-select'>
               <select v-model='select_brand'>
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
                  <input v-model='product.stock' type="text" pattern='[0-9]*' placeholder='0'>
               </div>
            </div>

            <div class='form-checkbox form-check check-discount'>
               <label>
                  <input @click='discount_toggle' :checked='product.has_discount == true ? true : false' type='checkbox'>
                  <span class='text'>Discount</span>
               </label>
            </div>

            <div class='form-title'>Percentage Discount</div>
            <div class='form-control'>
               <input v-model='product.discount_percent' type="text" pattern='[0-9]*' maxlength='3' max='100' placeholder='Enter Percentage'>
            </div>


            <div class='form-title'>Size Description</div>

            <div class='form-title small-size'>Quantity</div>
            <div class='form-control form-select'>
               <select v-model='quantity_water'>
                  <option :value="{ value: 0 }" disabled>Select Quantity</option>
                  <option 
                     v-for='(quantity_water, quantity_waterIndex) in get_quantity_water' :key='quantity_waterIndex'
                     :value="{ value: quantity_water.id }">{{ quantity_water.name }}</option>
               </select>
            </div>

            <div class='form-title small-size'>Water Volume</div>
            <div class='form-control form-select'>
               <select v-model='volume_water'>
                  <option :value="{ value: 0 }" disabled>Select Volume</option>
                  <option 
                     v-for='(volume_water, volume_waterIndex) in get_volume_water' :key='volume_waterIndex'
                     :value="{ value: volume_water.id }">{{ volume_water.name }}</option>
               </select>
            </div>

            <div class='form-title'>Product Description</div>
            <div class='form-control form-select'>
               <textarea v-model='product.description' placeholder='Enter Product Description'></textarea>
            </div>

            <div class='form-title'>Photo</div>

            <ul class='form-photo'>
               <li class='upload'>
                  <label>
                     <input type="file" multiple @change="handleFileUpload" />
                     <svg width="104" height="107" viewBox="0 0 104 107" fill="none" xmlns="http://www.w3.org/2000/svg">
                     <rect x="1" y="1" width="102" height="105" rx="4" fill="white" stroke="#2790F9" stroke-width="2" stroke-dasharray="20 20"/>
                     </svg>
                     <span>Add Photo</span>
                  </label>
               </li>
               <li class='image' v-for="(image, imageIndex) in uploadImages" :key="imageIndex">
                  <img :src="image.imagePreview" alt="Preview Image">
                  <button @click='delete_image(image)'>
                     <svg width="16" height="16" viewBox="0 0 16 16" fill="none" xmlns="http://www.w3.org/2000/svg">
                     <rect width="16" height="16" rx="2" fill="white" fill-opacity="0.7"/>
                     <path d="M12 4L4 12" stroke="#515151" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                     <path d="M4 4L12 12" stroke="#515151" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                     </svg>
                  </button>
               </li>
            </ul>

            <div class='form-checkbox form-check check-out-of-stock'>
               <label>
                  <input @click='mark_out_of_stock' :checked='product.mark_out_of_stock == true ? true : false' type='checkbox'>
                  <span class='text'>Mark as out of stock</span>
               </label>
            </div>

            <div class='form-button'>
               <button @click='btn_add_product' v-if='action == "add"' class='btn btn-primary'>Add</button>
               <button @click='btn_save_product' v-if='action == "edit"' class='btn btn-primary'>Save</button>
               <button @click='btn_delete_product' v-if='action == "edit"' class='btn btn-outline'>Delete</button>
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
   data (){
      return {
         loading: false,
         store_id: null,
         product: {
            id: null,
            product_type: '',
            name: null,
            description: '',
            brand: null,
            price: null,
            stock: null,
            quantity: null,
            volume: null,
            weight: null,
            length_width: null,
            mark_out_of_stock: false,
            has_discount: false,
            discount_from: null,
            discount_to: null,
            discount_percent: null,
            product_image: null
         },

         category: [],
         uploadImages: [],

         select_category: { value: 0 },
         select_brand: { value: 0 },
         quantity_water: { value: 0 },
         volume_water: { value: 0 },


         action: '',
         product_type: '',
         leading_title: ''

      }
   },

   watch: {

   },

   computed: {
      get_category(){
         return this.category.filter( cat => {
            if( cat.category == this.product_type ){
               return cat.category == this.product_type;
            }
         });
      },

      get_brand(){
         return this.category.filter( cat => {
            if( cat.category == 'brand' ) return cat.category == this.product_type;
         });
      },

      get_quantity_water(){
         return this.category.filter( cat => {
            if( cat.category == 'quantity_water' ) return cat.category == 'quantity_water';
         });
      },

      get_volume_water(){
         return this.category.filter( cat => {
            if( cat.category == 'volume_water' ) return cat.category == 'volume_water';
         });
      },
      

   },

   methods: {
      btn_add_product(){
         console.log(this.uploadImages);
      },

      btn_save_product(){

      },

      btn_delete_product(){

      },

      discount_toggle(){
         this.product.has_discount = !this.product.has_discount;
      },
      mark_out_of_stock(){
         this.product.mark_out_of_stock = !this.product.mark_out_of_stock;
      },

      async get_product(product_id){
         var form = new FormData();
         form.append('action', 'atlantis_find_product');
         form.append('product_id', product_id);
         var r = await window.request(form);
         if( r != undefined ){
            var res = JSON.parse( JSON.stringify( r));
            if( res.message == 'product_found' ){
               this.product = res.data;
            }
         }

      },

      async get_product_category(){
         var form = new FormData();
         form.append('action', 'atlantis_get_product_category');
         var r = await window.request(form);
         console.log(r)
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
          // Loop through selected files and read them as data URLs
          for (let i = 0; i < files.length; i++) {
            var file = files[i];
            var reader = new FileReader();
            reader.onload = (e) => {
              this.uploadImages.push( {
                  file: file,
                  imagePreview: e.target.result
               });
            };
            // Read the file as a data URL, triggering the onload event
            reader.readAsDataURL(file);
          }
        } else {
          // If no files are selected, clear the previews
          this.uploadImages = [];
        }
      },

      get_leading_title( product_type ){
         if( product_type == 'water'){
            this.leading_title = 'Add Water Product';
         }
         if( product_type == 'ice'){
            this.leading_title = 'Add Ice Product';
         }
      },

      goBack(){ window.goBack()},

   },

   async created(){
      this.loading = true;
      var urlParams = new URLSearchParams(window.location.search);
      var product_id     = urlParams.get('product_id');
      var product_type   = urlParams.get('product_type');
      var store_id       = urlParams.get('store_id');
      var action         = urlParams.get('action');

      this.action = action;

      this.product_type = product_type;

      if( action == 'add' ){
         this.get_leading_title(product_type);
      }

      if( action == 'edit' ){
         await this.get_product(product_id);
         this.leading_title = this.product.name;
      }

      await this.get_product_category();
      
      this.loading = false;
   },



}).mount('#app');

</script>