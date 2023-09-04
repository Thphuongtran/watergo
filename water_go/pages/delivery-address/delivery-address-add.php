<style type="text/css">
   .pac-logo:after{display: none}
   .form-group input{font-size: 16px;}
   .form-group .btn{line-height: 38px;}
</style>
<div id='app'>

   <div v-show='loading == false' class='page-delivery-address'>
      <div class='appbar'>
         <div class='appbar-top'>
            <div class='leading'>
               <button @click='goBack(false)' class='btn-action'>
                  <svg width="20" height="16" viewBox="0 0 20 16" fill="none" xmlns="http://www.w3.org/2000/svg">
                  <path fill-rule="evenodd" clip-rule="evenodd" d="M0 8C0 7.44772 0.447715 7 1 7H18.5C19.0523 7 19.5 7.44772 19.5 8C19.5 8.55228 19.0523 9 18.5 9H1C0.447715 9 0 8.55228 0 8Z" fill="#252831"/>
                  <path fill-rule="evenodd" clip-rule="evenodd" d="M10.5309 0.375342C10.8759 0.806604 10.806 1.4359 10.3747 1.78091L2.60078 8.00004L10.3747 14.2192C10.806 14.5642 10.8759 15.1935 10.5309 15.6247C10.1859 16.056 9.55657 16.1259 9.12531 15.7809L0.375305 8.78091C0.13809 8.59113 0 8.30382 0 8.00004C0 7.69625 0.13809 7.40894 0.375305 7.21917L9.12531 0.219168C9.55657 -0.125842 10.1859 -0.0559202 10.5309 0.375342Z" fill="#252831"/>
                  </svg>
               </button>
               <p class='leading-title'><?php echo __('Add Address', 'watergo'); ?></p>
            </div>
         </div>
      </div>

      <div class='inner'>
         <div class='page-delivery-address-add'>
            <div class='form-group style01 mt0'>
               <span><?php echo __('Name', 'watergo'); ?></span>
               <input v-model='delivery_address_name' type="text">
            </div>
            <div class='form-group style01'>
               <span><?php echo __('Phone', 'watergo'); ?></span>
               <input v-model='delivery_address_phone' type="text" pattern='[0-9]*' maxlength='11'>
            </div>
            <div class='form-group style01'>
               <span><?php echo __('Address', 'watergo'); ?></span>
               <!-- <input 
                  v-model='delivery_address_location' type="text"
                  @blur='select_address_focus_out'
                  @focus='select_address_focus_in'
               > -->
               <input type="text" name="" id="search-address" placeholder="">
            </div>

            <div class='form-group switch'>
               <p><?php echo __('Select as default address', 'watergo'); ?></p>
               <label class="toggle-switch">
                  <input type="checkbox" v-model='delivery_address_primary' :value='delivery_address_primary'>
                  <span class="slider"></span>
               </label>
            </div>
            <p class='t-red mt15'>{{ text_res }}</p>
            <div class='button-expanded mt80'>
               <button @click='addDeliveryAddress' class='btn btn-primary'><?php echo __('Add', 'watergo'); ?></button>
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

<script type="text/javascript" src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBrhkRyBm3jXLkcMmVvd_GNhINb03VSVfI&libraries=places"></script>
<script type='module'>

var address = "";
var lat = "";
var lng = "";

var app = Vue.createApp({
   data(){
      return{
         loading: false,
         text_res: '',
         delivery_address: [],
         delivery_address_name: '',
         delivery_address_phone: '',
         delivery_address_email: '',
         delivery_address_location: '',
         delivery_address_primary: false,

         // SEARCH
         box_search: false,
         // searchRes: [],
         latitude: 0,
         longitude: 0,

      }
   },

   methods: {

      goBack( refresh = false){ 
         if( refresh == false ){
            window.location.href = '?appt=X';
         }else{
            window.location.href = '?appt=X&data=delivery_just_add';
         }
      },
      
      validatePhoneNumber(phoneNumber) {
         // Regular expression for phone number validation
         const phoneRegex = /^\d{10,12}$/; // Assumes 11-digit phone number format
         return phoneRegex.test(phoneNumber);
      },

      async get_location_from_address( address ){ return window.get_location_from_address(address) },

      async addDeliveryAddress(){
         this.loading = true;
         var form = new FormData();
         form.append('action', 'atlantis_user_delivery_address');
         form.append('event', 'add');
         var _primary = this.delivery_address_primary == true ? 1 : 0;
         
         if( this.delivery_address_name != '' &&
            this.delivery_address_phone != '' &&
            address != ''){
               var _phoneNumberString = this.delivery_address_phone;
            if( this.validatePhoneNumber( _phoneNumberString) == false ){
               this.text_res = '<?php echo __("Phone number is invalid", 'watergo'); ?>';
               this.loading = false;
            }else{
               this.text_res = '';

               // UPDATE LATITUDE + LONGITUDE WHEN USER UPDATE LOCATION 

               form.append('name', this.delivery_address_name);
               form.append('phone', this.delivery_address_phone);
               form.append('address', address);
               form.append('latitude', lat);
               form.append('longitude', lng);
               form.append('primary', _primary);

               // if( _primary == 1 ){
               //    localStorage.setItem( 'watergo_order_delivery_address', '[]' );
               // }

               var r = await window.request( form);
               if(r != undefined ){
                  var res = JSON.parse( JSON.stringify( r ));
                  if( res.message == 'add_delivery_address_ok' ){
                     this.goBack(true);
                  }
               }
            }
         }else{
            this.text_res = '<?php echo __("Field must be not empty", 'watergo'); ?>';
            this.loading = false;
         }

         
         
      },

   },

   created(){

      var _watergo_delivery_address_update   = JSON.parse(localStorage.getItem('watergo_delivery_address_update'));
      if( _watergo_delivery_address_update == undefined ){
         localStorage.setItem('watergo_delivery_address_update', '[]');
      }

      window.appbar_fixed();

   },

}).mount('#app');

window.app = app;

function initialize() {
   const input = document.getElementById('search-address');
   const options = {
      componentRestrictions: { country: "vn" },
   };
   const autocomplete = new google.maps.places.Autocomplete(input, options);

// Lắng nghe sự kiện khi người dùng chọn một địa chỉ từ danh sách
   google.maps.event.addListener(autocomplete, 'place_changed', function () {
      const selectedPlace = autocomplete.getPlace();
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