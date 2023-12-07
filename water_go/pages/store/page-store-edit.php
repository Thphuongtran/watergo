<style type="text/css">
   .pac-logo:after{display: none}
   .form-group input{font-size: 16px;}
   .form-group .btn{line-height: 38px;}
   .form-group input:disabled{  opacity: 0.6;}
   .forcehidden{
      display: none;
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

   <div v-if='loading == false' class='page-edit'>

      <div class='appbar fixed'>

         <div class='appbar-top'>
            <div class='leading'>
               <button @click='goBack' class='btn-action'>
                  <svg width="20" height="16" viewBox="0 0 20 16" fill="none" xmlns="http://www.w3.org/2000/svg">
                     <path fill-rule="evenodd" clip-rule="evenodd" d="M0 8C0 7.44772 0.447715 7 1 7H18.5C19.0523 7 19.5 7.44772 19.5 8C19.5 8.55228 19.0523 9 18.5 9H1C0.447715 9 0 8.55228 0 8Z" fill="#252831"/>
                     <path fill-rule="evenodd" clip-rule="evenodd" d="M10.5309 0.375342C10.8759 0.806604 10.806 1.4359 10.3747 1.78091L2.60078 8.00004L10.3747 14.2192C10.806 14.5642 10.8759 15.1935 10.5309 15.6247C10.1859 16.056 9.55657 16.1259 9.12531 15.7809L0.375305 8.78091C0.13809 8.59113 0 8.30382 0 8.00004C0 7.69625 0.13809 7.40894 0.375305 7.21917L9.12531 0.219168C9.55657 -0.125842 10.1859 -0.0559202 10.5309 0.375342Z" fill="#252831"/>
                  </svg>
               </button>
               <span class='leading-title'><?php echo __('Edit Profile', 'watergo'); ?> </span>
            </div>
            
         </div>

      </div>

      <div class='scaffold'>

         <div class='inner form-store-style'>
            <div class='avatar-header style02'>
               <label style="position: relative;display: block;" for='uploadAvatar' class='upload-avatar style02'  :class='previewAvatar != null ? "has-preview" : ""'>
                  
                  <svg v-if='previewAvatar == null' width="388" height="181" viewBox="0 0 388 181" fill="none" xmlns="http://www.w3.org/2000/svg">
                  <rect width="388" height="180" rx="8" fill="#F9F9F9"/>
                  <circle cx="194" cy="90" r="35" fill="#ECECEC"/>
                  <rect x="179.529" y="86.9199" width="28" height="18.0197" rx="1" fill="white" stroke="#C9C9C9" stroke-width="2"/>
                  <path d="M210.356 83.0991L210.356 83.0988L206.451 76.4675L206.45 76.4659C206.271 76.1609 205.971 76 205.682 76H181.374C181.085 76 180.785 76.1609 180.607 76.4659L180.606 76.4675L176.701 83.0986C176.701 83.0987 176.701 83.0988 176.701 83.0988C175.187 85.6709 176.261 89.0345 178.539 90.0502C178.84 90.1848 179.167 90.2814 179.519 90.3323C179.741 90.3638 179.971 90.3797 180.201 90.3797C181.658 90.3797 182.964 89.7014 183.876 88.6171L184.641 87.7083L185.407 88.6171C186.319 89.7009 187.631 90.3797 189.082 90.3797C190.538 90.3797 191.844 89.7014 192.757 88.6171L193.522 87.7083L194.287 88.6171C195.2 89.7009 196.511 90.3797 197.963 90.3797C199.419 90.3797 200.725 89.7014 201.638 88.6171L202.401 87.7108L203.166 88.615C204.086 89.7021 205.394 90.3797 206.843 90.3797C207.08 90.3797 207.303 90.3638 207.527 90.3321L210.356 83.0991ZM210.356 83.0991C211.198 84.5276 211.251 86.2502 210.688 87.6735M210.356 83.0991L210.688 87.6735M210.688 87.6735C210.126 89.0913 208.996 90.1228 207.527 90.3321L210.688 87.6735Z" fill="white" stroke="#C9C9C9" stroke-width="2"/>
                  </svg>

                  <span class="camera-icon" style="position: absolute;bottom: 6px;right: 0px;margin-bottom: 0;display: inline-block;width: 38px;">
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
            
            <div class='form-group'>
               <span><?php echo __('Owner', 'watergo'); ?></span>
               <input v-model='owner' type="text" placeholder='<?php echo __('Enter owner name', 'watergo'); ?>'>
            </div>

            <div class='form-group'>
               <span><?php echo __('Store Name', 'watergo'); ?></span>
               <input v-model='name' type="text" placeholder='<?php echo __('Enter store name', 'watergo'); ?>'>
            </div>
            
            <div class='form-group form-description'>
               <span><?php echo __('Description', 'watergo'); ?></span>
               <textarea @input='autoResize' ref='textarea' v-model='description' placeholder='<?php echo __('Describe your store', 'watergo'); ?>'></textarea>
            </div>

            <div class='form-group'>
               <span><?php echo __('Address', 'watergo'); ?></span>
               <input id='search-address' v-model='address' type="text" placeholder='<?php echo __('Enter address', 'watergo') ?>'>
            </div>

            <div class='form-group'>
               <span><?php echo __('Phone', 'watergo'); ?></span>
               <input v-model='phone' type="text" inputmode='numeric' pattern='[0-9]*' placeholder='<?php echo __('Enter phone', 'watergo'); ?> '>
            </div>

            <div class='form-group'>
               <span>Email</span>
               <input v-model='email' type="email" placeholder='<?php echo __('Enter your email', 'watergo'); ?>' disabled readonly>
            </div>

            <div class='form-group'>
               <span><?php echo __('Password', 'watergo') ;?></span>
               <input v-model='inputPassword' type="password" placeholder='<?php echo __('Enter your password', 'watergo'); ?>'>
            </div>

            <span class='mt20 d-block'><?php echo __('Select Product', 'watergo'); ?></span>
            <div class='form-group style-checkbox-business style-store-edit'>
               <label class='form-checkbox'>
                  <input class='form-check' type='checkbox' @click='btn_select_type_product("water")' :checked='select_type_product.water' :disable='select_type_product.water'> 
                  <span class='text'><?php echo __('Water', 'watergo'); ?></span>
               </label>
               <label class='form-checkbox'>
                  <input type='checkbox' @click='btn_select_type_product("ice")' :checked='select_type_product.ice' :disable='select_type_product.ice'> 
                  <span class='text'><?php echo __('Ice', 'watergo'); ?></span>
               </label>
               <label class='form-checkbox'>
                  <input type='checkbox' @click='btn_select_type_product("both")' :checked='select_type_product.both' :disable='select_type_product.both'> 
                  <span class='text'><?php echo __('Both', 'watergo'); ?></span>
               </label>
            </div>

            <span class='d-block t-red mt20'>{{text_err}}</span>

            <!-- <div class='btn-fixed bottom'> -->
               <button @click='btn_update_store' class='btn btn-primary'><?php echo __('Save', 'watergo'); ?></button>
            <!-- </div> -->

         </div>

      </div>

   </div>

   <div v-if='loading == true'>
      <div class='progress-center'>
         <div class='progress-container enabled'><progress class='progress-circular enabled' ></progress></div>
      </div>
   </div>

</div>

<script type="text/javascript" src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBrhkRyBm3jXLkcMmVvd_GNhINb03VSVfI&libraries=places"></script>
<script>

if( window.appBridge != undefined ){
   window.appBridge.setEnableScroll(false);
}

var address = lat = lng = "";

var app = Vue.createApp({ 
   
   data (){
      return {
         loading: false,
         store: null,

         owner: '',
         name: '',
         description: '',
         address: '',
         phone: '',
         email: '',
         inputPassword: '',

         text_err: '',

         previewAvatar: null,
         selectedImage: null,

         searchRes: [],
         latitude: 0,
         longitude: 0,

         select_type_product: {
            water: false,
            ice: false,
            both: false
         },

         select_type_product_text: '',

      }
   },



   watch : {

      email : function(val){
         if(this.verify_email(val)){
            $(".btn-email-verify").addClass("is-send");
         }else{
            $(".btn-email-verify").removeClass("is-send");
         }
      }
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

      verify_email( email ){
         const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
         if (emailRegex.test(email)) {
            return true;
         }else{
            return false;
         }
      },


      async btn_update_store(){
         
         this.text_err = '';
         
         // CHECK ALL IS EMPTY ??
         if( 
            this.owner != '' &&
            this.name != '' &&
            this.phone != '' &&
            this.email != '' && address != "" && lat != "" && lng != "" &&
            this.select_type_product_text != ''
         ){
            this.loading = true;
            var form = new FormData();
            form.append('action', 'atlantis_store_profile_edit');

            form.append('id', this.store.id);
            form.append('owner', this.owner);
            form.append('name', this.name);
            form.append('address', address);
            form.append('phone', this.phone);
            //form.append('email', this.email);
            form.append('description', this.description);
            form.append('imageUpload[]', this.selectedImage);
            form.append('latitude', lat);
            form.append('longitude', lng);
            // new update
            form.append('storeType', this.select_type_product_text);

            if(this.inputPassword != '' && this.inputPassword.length > 0){
               form.append('password', this.inputPassword);
               form.append('change_password_no_login_back', 0);
            }

            var r = await window.request(form);
            
            if( r != undefined ){
               var res = JSON.parse( JSON.stringify(r));
                // DISPLAY ERROR
               if( res.message == 'email_already_exists' ){
                  this.text_err = '<?php echo __("Email already exists.", 'watergo'); ?>';
               }
               if( res.message == 'code_is_not_match' ){
                  this.text_err = '<?php echo __("Code is not match.", 'watergo'); ?>';
               }
               if( res.message == 'phonenumber_is_not_correct_format' ){
                  this.text_err = '<?php echo __("Phone number is not correct format.", 'watergo'); ?>';
               }
               if( res.message == 'store_edit_error' ){
                  this.text_err = '<?php echo __("Store Edit Error.", 'watergo'); ?>';
               }
               if( res.message == 'store_profile_update_ok'){
                  this.goBackUpdate(this.store.id);
               }
            }

            this.loading = false;
         }else if( address == "" || lat == "" || lng == ""){
            // Địa chỉ không hợp lệ, vui lòng chọn địa chỉ trong sách đề xuất
            this.text_err = this.res_text_sendcode = '<?php echo __("Invalid address, please select the address in the suggestion book", 'watergo'); ?>';
         } else{
            this.text_err = this.res_text_sendcode = '<?php echo __("All field must be not empty.", 'watergo'); ?>';
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
      
      async get_store_profile(){
         var form = new FormData();
         form.append('action', 'atlantis_get_store_profile');
         var r = await window.request(form);

         if( r != undefined ){
            var res = JSON.parse( JSON.stringify( r));
            if( res.message == 'get_store_ok'){
               this.store = res.data;

               this.owner = res.data.owner;
               this.name = res.data.name;
               this.description = res.data.description.replace(/\\/g, '');
               this.address = address = res.data.address;
               lat = res.data.latitude;
               lng = res.data.longitude;
               this.phone = res.data.phone;
               this.email = res.data.email;
               this.previewAvatar = this.store.store_image.url;

               this.btn_select_type_product(res.data.store_type);
            }
         }

      },

      goBack(){ window.goBack(); },
      goBackUpdate( store_id ){ 
         window.location.href = `?appt=X&data=store_detail_update|store_id=${store_id}`;
      },

   },

   async created(){
      this.loading = true;

      await this.get_store_profile();
      window.appbar_fixed();
      setTimeout( () => {this.autoResize();}, 0);

      this.loading = false;
   }

}).mount('#app');

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
         lat = selectedPlace.geometry.location.lat();
         lng = selectedPlace.geometry.location.lng();
         address = selectedPlace.formatted_address;
      }
   });

   input.addEventListener('keydown', function (event) {
      address = lat = lng = "";
   });

}

google.maps.event.addDomListener(window, 'load', initialize);

jQuery(document).ready(function($){
   $(document).on('click', 'button.dismissButton', function(){
      $('.pac-container').addClass('forcehidden');
   });
});
</script>