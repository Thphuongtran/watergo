<style type="text/css">
   .pac-logo:after{display: none}
   .form-group input{font-size: 16px;}
   .form-group .btn{line-height: 38px;}
</style>
<div id='app'>

   <div v-show='loading == false' class='page-edit'>

      <div class='appbar fixed'>

         <div class='appbar-top'>
            <div class='leading'>
               <button @click='goBack' class='btn-action'>
                  <svg width="20" height="16" viewBox="0 0 20 16" fill="none" xmlns="http://www.w3.org/2000/svg">
                     <path fill-rule="evenodd" clip-rule="evenodd" d="M0 8C0 7.44772 0.447715 7 1 7H18.5C19.0523 7 19.5 7.44772 19.5 8C19.5 8.55228 19.0523 9 18.5 9H1C0.447715 9 0 8.55228 0 8Z" fill="#252831"/>
                     <path fill-rule="evenodd" clip-rule="evenodd" d="M10.5309 0.375342C10.8759 0.806604 10.806 1.4359 10.3747 1.78091L2.60078 8.00004L10.3747 14.2192C10.806 14.5642 10.8759 15.1935 10.5309 15.6247C10.1859 16.056 9.55657 16.1259 9.12531 15.7809L0.375305 8.78091C0.13809 8.59113 0 8.30382 0 8.00004C0 7.69625 0.13809 7.40894 0.375305 7.21917L9.12531 0.219168C9.55657 -0.125842 10.1859 -0.0559202 10.5309 0.375342Z" fill="#252831"/>
                  </svg>
               </button>
               <span class='leading-title'>Edit Profile </span>
            </div>
            
         </div>

      </div>

      <div class='inner form-store-style'>
         <div class='avatar-header style02'>
            <label for='uploadAvatar' class='upload-avatar style02'  :class='previewAvatar != null ? "has-preview" : ""'>
               
               <svg v-if='previewAvatar == null' width="388" height="181" viewBox="0 0 388 181" fill="none" xmlns="http://www.w3.org/2000/svg">
               <rect width="388" height="180" rx="8" fill="#F9F9F9"/>
               <circle cx="194" cy="90" r="35" fill="#ECECEC"/>
               <rect x="179.529" y="86.9199" width="28" height="18.0197" rx="1" fill="white" stroke="#C9C9C9" stroke-width="2"/>
               <path d="M210.356 83.0991L210.356 83.0988L206.451 76.4675L206.45 76.4659C206.271 76.1609 205.971 76 205.682 76H181.374C181.085 76 180.785 76.1609 180.607 76.4659L180.606 76.4675L176.701 83.0986C176.701 83.0987 176.701 83.0988 176.701 83.0988C175.187 85.6709 176.261 89.0345 178.539 90.0502C178.84 90.1848 179.167 90.2814 179.519 90.3323C179.741 90.3638 179.971 90.3797 180.201 90.3797C181.658 90.3797 182.964 89.7014 183.876 88.6171L184.641 87.7083L185.407 88.6171C186.319 89.7009 187.631 90.3797 189.082 90.3797C190.538 90.3797 191.844 89.7014 192.757 88.6171L193.522 87.7083L194.287 88.6171C195.2 89.7009 196.511 90.3797 197.963 90.3797C199.419 90.3797 200.725 89.7014 201.638 88.6171L202.401 87.7108L203.166 88.615C204.086 89.7021 205.394 90.3797 206.843 90.3797C207.08 90.3797 207.303 90.3638 207.527 90.3321L210.356 83.0991ZM210.356 83.0991C211.198 84.5276 211.251 86.2502 210.688 87.6735M210.356 83.0991L210.688 87.6735M210.688 87.6735C210.126 89.0913 208.996 90.1228 207.527 90.3321L210.688 87.6735Z" fill="white" stroke="#C9C9C9" stroke-width="2"/>
               <g filter="url(#filter0_d_95_4)">
               <circle cx="367" cy="159" r="16" fill="white"/>
               </g>
               <path d="M366.881 162.793C368.452 162.793 369.726 161.52 369.726 159.949C369.726 158.378 368.452 157.104 366.881 157.104C365.31 157.104 364.037 158.378 364.037 159.949C364.037 161.52 365.31 162.793 366.881 162.793Z" fill="#252831"/>
               <path d="M374.467 152.363H371.461L370.285 151.083C370.109 150.889 369.893 150.734 369.653 150.628C369.413 150.522 369.154 150.467 368.892 150.467H364.871C364.34 150.467 363.828 150.694 363.468 151.083L362.302 152.363H359.296C358.253 152.363 357.4 153.216 357.4 154.259V165.637C357.4 166.68 358.253 167.533 359.296 167.533H374.467C375.51 167.533 376.363 166.68 376.363 165.637V154.259C376.363 153.216 375.51 152.363 374.467 152.363ZM366.881 164.689C364.265 164.689 362.141 162.565 362.141 159.948C362.141 157.331 364.265 155.208 366.881 155.208C369.498 155.208 371.622 157.331 371.622 159.948C371.622 162.565 369.498 164.689 366.881 164.689Z" fill="#252831"/>
               <defs>
               <filter id="filter0_d_95_4" x="347" y="141" width="40" height="40" filterUnits="userSpaceOnUse" color-interpolation-filters="sRGB">
               <feFlood flood-opacity="0" result="BackgroundImageFix"/>
               <feColorMatrix in="SourceAlpha" type="matrix" values="0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 127 0" result="hardAlpha"/>
               <feOffset dy="2"/>
               <feGaussianBlur stdDeviation="2"/>
               <feComposite in2="hardAlpha" operator="out"/>
               <feColorMatrix type="matrix" values="0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0.14 0"/>
               <feBlend mode="normal" in2="BackgroundImageFix" result="effect1_dropShadow_95_4"/>
               <feBlend mode="normal" in="SourceGraphic" in2="effect1_dropShadow_95_4" result="shape"/>
               </filter>
               </defs>
               </svg>


               <input id='uploadAvatar' class='avatarPickerDisable' type="file" @change='avatarSelected'>
               <img class='avatar-circle' :src="previewAvatar" v-if="previewAvatar">
            </label>
         </div>
         
         <div class='form-group'>
            <span>Owner</span>
            <input v-model='owner' type="text" placeholder='Enter owner name'>
         </div>

         <div class='form-group'>
            <span>Store Name</span>
            <input v-model='name' type="text" placeholder='Enter store name'>
         </div>
         
         <div class='form-group form-description'>
            <span>Description</span>
            <textarea v-model='description' placeholder='Describe your store'></textarea>
         </div>

         <div class='form-group'>
            <span>Address</span>
            <input id='search-address' v-model='address' type="text" placeholder='Enter address'>
         </div>

         <div class='form-group'>
            <span>Phone</span>
            <input v-model='phone' type="text" pattern='[0-9]*' placeholder='Enter phone'>
         </div>

         <div class='form-group'>
            <span>Email</span>
            <input v-model='email' type="email" placeholder='Enter your email'>
         </div>

         <span class='d-block t-red mt20'>{{text_err}}</span>

         <!-- <div class='btn-fixed bottom'> -->
            <button @click='btn_update_store' class='btn btn-primary'>Save</button>
         <!-- </div> -->

      </div>

   </div>

   <div v-show='loading == true'>
      <div class='progress-center'>
         <div class='progress-container enabled'><progress class='progress-circular enabled' ></progress></div>
      </div>
   </div>

</div>

<script type="text/javascript" src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBrhkRyBm3jXLkcMmVvd_GNhINb03VSVfI&libraries=places"></script>
<script>

var address = lat = lng = "";

var { createApp } = Vue;

createApp({
   
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

         text_err: '',

         previewAvatar: null,
         selectedImage: null,

         // SEARCH
         box_search: false,
         searchRes: [],
         latitude: 0,
         longitude: 0,

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

      verify_email( email ){
         const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
         if (emailRegex.test(email)) {
            return true;
         }else{
            return false;
         }
      },


      async btn_update_store(){
         this.loading = true;
         this.text_err = '';
         
         // CHECK ALL IS EMPTY ??
         if( 
            this.owner != '' &&
            this.name != '' &&
            this.address != '' &&
            this.phone != '' &&
            this.email != '' && address != "" && lat != "" && lng != ""
         ){
            
            var form = new FormData();
            form.append('action', 'atlantis_store_profile_edit');

            form.append('id', this.store.id);
            form.append('owner', this.owner);
            form.append('name', this.name);
            form.append('address', this.address);
            form.append('phone', this.phone);
            form.append('email', this.email);
            form.append('description', this.description);
            form.append('imageUpload[]', this.selectedImage);
            form.append('latitude', lat);
            form.append('longitude', lng);

            var r = await window.request(form);
            
            if( r != undefined ){
               var res = JSON.parse( JSON.stringify(r));
                // DISPLAY ERROR
               if( res.message == 'email_already_exists' ){
                  this.text_err = 'Email already exists.';
               }
               if( res.message == 'code_is_not_match' ){
                  this.text_err = 'Code is not match.';
               }
               if( res.message == 'phonenumber_is_not_correct_format' ){
                  this.text_err = 'Phone number is not correct format.';
               }
               if( res.message == 'store_edit_error' ){
                  this.text_err = 'Store Edit Error.';
               }

               if( res.message == 'store_profile_update_ok'){
                  this.goBack();
                  if( window.appBridge != undefined ){
                     window.appBridge.refresh();
                  }else{
                     location.reload();
                  }
               }
            }

            this.loading = false;
         }else if( address == "" || lat == "" || lng == ""){
            this.res_text_sendcode = 'Địa chỉ không hợp lệ, vui lòng chọn địa chỉ trong sách đề xuất';
         } else{
            this.res_text_sendcode = 'All field must be not empty.';
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
               this.description = res.data.description;
               this.address = res.data.address;
               this.phone = res.data.phone;
               this.email = res.data.email;
            }
         }

      },

      goBack(){ window.goBack(true); },
   },

   async created(){
      this.loading = true;

      await this.get_store_profile();
      this.loading = false;

      window.appbar_fixed();
   }

}).mount('#app');


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

</script>