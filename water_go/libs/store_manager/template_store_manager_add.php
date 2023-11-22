<?php 

function template_store_manager_add(){

?>
<style>
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
   .button-primary.disabled{
      pointer-events: none;
   }

</style>
<script type="text/javascript">
   var get_ajaxadmin = "<?php echo admin_url('admin-ajax.php'); ?>";;
</script>

<script src="https://cdnjs.cloudflare.com/ajax/libs/axios/1.4.0/axios.min.js" integrity="sha512-uMtXmF28A2Ab/JJO2t/vYhlaa/3ahUOgj1Zf27M5rOo8/+fcTUVH0/E0ll68njmjrLqOBjXM3V9NiPFL5ywWPQ==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/vue/3.3.4/vue.global.min.js" integrity="sha512-Wbf9QOX8TxnLykSrNGmAc5mDntbpyXjOw9zgnKql3DgQ7Iyr5TCSPWpvpwDuo+jikYoSNMD9tRRH854VfPpL9A==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<script src='<?php echo THEME_URI . '/assets/js/common.js'; ?>'></script>
<div id='app' class='wrap'>

   <h1 class="wp-heading-inline">Add Store</h1>
   <hr class="wp-header-end">

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
         <td><textarea @input='autoResize' ref='textarea' v-model='description' id='description' class='regular-text' rows="5" cols="30"></textarea></td>
      </tr>

      <tr>
         <th><label for='search-address'><?php echo __('Address', 'watergo'); ?></label></th>
         <!-- <td><input id='search-address' type="text" class="regular-text" placeholder='' value=''></td> -->
         <td><input id='search-address' type="text" class="regular-text" placeholder=''></td>
      </tr>

      <tr>
         <th><label for='phone'><?php echo __('Phone', 'watergo'); ?></label></th>
         <td><input v-model='phone' id='phone' type="text" class="regular-text" inputmode='numeric' pattern='[0-9]*' maxlength='11'></td>
      </tr>

      <tr>
         <th><label for='email'><?php echo __('Email', 'watergo'); ?></label></th>
         <td><input v-model='email' id='email' type="text" class="regular-text"></td>
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
      <button class='button button-primary' :class='is_submit_add_store == false ? "disabled" : ""' @click='add_store_submit'>Add</button>
   </p>

   <!--  -->

</div>
<!-- <script type="text/javascript" src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBrhkRyBm3jXLkcMmVvd_GNhINb03VSVfI&libraries=places"></script> -->
<script type="text/javascript" src="https://maps.googleapis.com/maps/api/js?key=&libraries=places"></script>

<script>
   
   var app = Vue.createApp({
      data(){
         return {
            is_submit_add_store: false,

            select_type_product: {
               water: false,
               ice: false,
               both: false
            },
            select_type_product_text: '',

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

         }
      },

      watch: {
         owner: function(val){ this.force_check_all_field(); },
         name: function(val){ this.force_check_all_field(); },
         description: function(val){ this.force_check_all_field(); },
         phone: function(val){ this.force_check_all_field(); },
         password: function(val){ this.force_check_all_field(); },
         email: function(val){ this.force_check_all_field(); },
         selectedImage: function(val){ this.force_check_all_field(); },
         address: function(val){ this.force_check_all_field(); },
         select_type_product_text: function(val){ this.force_check_all_field(); },

      },

      computed: {
         stores_computed(){
            return this.stores.sort( ( a, b ) => b.id - a.id );
         }
      },

      methods: {

         force_check_all_field(){

            if(
               this.owner != '' &&
               this.name != '' &&
               this.phone != '' &&
               this.email != '' && 
               this.description != '' && 
               this.password != '' &&
               this.address != '' &&
               this.selectedImage != null &&
               this.select_type_product_text != ''
            ){
               this.is_submit_add_store = true;
            }else{
               this.is_submit_add_store = false;
            }
         },

         async add_store_submit(){
            this.text_err = '';
            
            if( this.is_submit_add_store == true){
               
               var form = new FormData();
               form.append('action', 'atlantis_store_register_from_admin');
               form.append('owner', this.owner);
               form.append('storeName', this.name);
               form.append('phone', this.phone);
               form.append('email', this.email);
               form.append('description', this.description);
               form.append('storeType', this.select_type_product_text);
               form.append('address', this.address );
               form.append('password', this.password);
               form.append('latitude', this.lat);
               form.append('longitude', this.lng);
               form.append('imageUpload[]', this.selectedImage);

               var r = await window.request(form);

               if( r != undefined ){
                  var res = JSON.parse( JSON.stringify( r ));

                  if( res.message == 'email_already_exists' ){
                     this.text_err = '<?php echo __("Email already exists.", 'watergo'); ?>';
                  }

                  if( res.message == 'phonenumber_is_not_correct_format' ){
                     this.text_err = '<?php echo __("Phone number is not correct format.", 'watergo'); ?>';
                  }

                  if( res.message == 'all_field_empty' ){
                     this.text_err = '<?php echo __("All field must be not empty.", 'watergo'); ?>';
                  }

                  if( res.message == 'email_is_not_correct_format' ){
                     this.text_err = '<?php echo __("Email is not correct format.", 'watergo'); ?>';
                  }

                  if( res.message == 'register_error_1' || res.message == 'register_error_2' ){
                     this.text_err = '<?php echo __("Register Error.", 'watergo'); ?>';
                  }

                  if( res.message == 'register_ok' ){
                     window.location.href = '<?php echo get_bloginfo('url'); ?>' + '/wordpress/wp-admin/admin.php?page=store_manager_index';
                  }
               }
            }else if( this.address != '' && this.lat != '' && this.lng != '' ){
               this.text_err = '<?php echo __("Invalid address, please select the address in the suggestion book", 'watergo'); ?>';
            }else{
               this.text_err = '<?php echo __("All field must be not empty.", 'watergo'); ?>';
            }
         },

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


         toggle_show_password(){ this.show_password = !this.show_password; },

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




      },

      async created() {
         setTimeout( () => {this.autoResize();}, 0);

      }

   }).mount('#app');

   window.app = app;


   // function initialize() {
   //    var input = document.getElementById('search-address');
   //    var options = {
   //       componentRestrictions: { country: "vn" },
   //    };

   //    try {
   //       var autocomplete = new google.maps.places.Autocomplete(input, options);

   //       google.maps.event.addListener(autocomplete, 'place_changed', function () {
   //          var selectedPlace = autocomplete.getPlace();
   //          if (selectedPlace && selectedPlace.geometry && selectedPlace.geometry.location) {
   //             window.app.lat = selectedPlace.geometry.location.lat();
   //             window.app.lng = selectedPlace.geometry.location.lng();
   //             window.app.address = selectedPlace.formatted_address;
   //          }
   //       });

   //       input.addEventListener('keydown', function (event) {
   //          window.app.address = '';
   //          window.app.lat = '';
   //          window.app.lng = '';
   //       });
   //    } catch (error) {
   //       console.error('Error initializing Google Places Autocomplete:', error);
   //       return false;
   //    }
   // }

   // google.maps.event.addDomListener(window, 'load', initialize);

</script>



<?php
}

