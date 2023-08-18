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
               <button @click='goBack' class='btn-action'>
                  <svg width="20" height="16" viewBox="0 0 20 16" fill="none" xmlns="http://www.w3.org/2000/svg">
                  <path fill-rule="evenodd" clip-rule="evenodd" d="M0 8C0 7.44772 0.447715 7 1 7H18.5C19.0523 7 19.5 7.44772 19.5 8C19.5 8.55228 19.0523 9 18.5 9H1C0.447715 9 0 8.55228 0 8Z" fill="#252831"/>
                  <path fill-rule="evenodd" clip-rule="evenodd" d="M10.5309 0.375342C10.8759 0.806604 10.806 1.4359 10.3747 1.78091L2.60078 8.00004L10.3747 14.2192C10.806 14.5642 10.8759 15.1935 10.5309 15.6247C10.1859 16.056 9.55657 16.1259 9.12531 15.7809L0.375305 8.78091C0.13809 8.59113 0 8.30382 0 8.00004C0 7.69625 0.13809 7.40894 0.375305 7.21917L9.12531 0.219168C9.55657 -0.125842 10.1859 -0.0559202 10.5309 0.375342Z" fill="#252831"/>
                  </svg>
               </button>
               <p class='leading-title'>Edit Address</p>
            </div>
         </div>
      </div>

      <div class='inner'>
         <div class='page-delivery-address-add'>
            <div class='form-group style01 mt0'>
               <span>Name</span>
               <input v-model='delivery_address_name' type="text">
            </div>
            <div class='form-group style01'>
               <span>Phone</span>
               <input v-model='delivery_address_phone' type="text" pattern='[0-9]*' maxlength='11'>
            </div>
            <div class='form-group style01'>
               <span>Address</span>
               
               <input v-model='delivery_address_location' type="text" name="" id="search-address" placeholder="">
            </div>

            <div class='form-group switch'>
               <p>Select as default address</p>
               <label class="toggle-switch">
                  <input type="checkbox" v-model='delivery_address_primary' :value='delivery_address_primary'>
                  <span class="slider"></span>
               </label>
            </div>
            <p class='t-red mt15'>{{ text_res }}</p>
            <div class='button-expanded mt80'>
               <button class='btn-text-2' @click='popup_deleteDeliveryAddress'>Delete Address</button>
               <button @click='updateDeliveryAddress' class='btn btn-primary mt10'>Save</button>
            </div>
         </div>
      </div>

   </div>

   <div v-show='loading == true'>
      <div class='progress-center'>
         <div class='progress-container enabled'><progress class='progress-circular enabled' ></progress></div>
      </div>
   </div>

   <div v-show='popup_confirm_delete' class='modal-popup open'>
      <div class='modal-wrapper'>
         <div class='modal-close'><div @click='buttonModalCancel' class='close-button'><span></span><span></span></div></div>
         <p class='heading'>Do you want to delete this delivery address?</p>
         <div class='actions'>
            <button @click='buttonModalCancel' class='btn btn-outline'>Cancel</button>
            <button @click='buttonModalConfirm' class='btn btn-primary'>Delete</button>
         </div>
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

         delivery_address_id: 0,
         delivery_address_name: '',
         delivery_address_phone: '',
         delivery_address_location: '',
         delivery_address_primary: false,

         popup_confirm_delete: false,

         // SEARCH
         searchRes: [],
         latitude: 0,
         longitude: 0,
         
      }
   },


   methods: {

      popup_deleteDeliveryAddress(){this.popup_confirm_delete = true;},
      buttonModalCancel(){ this.popup_confirm_delete = false; },
      async buttonModalConfirm(){ 
         this.loading = true;
         await this.deleteDeliveryAddress();
      },

      validatePhoneNumber(phoneNumber) {
         // Regular expression for phone number validation
         const phoneRegex = /^\d{10,11}$/; // Assumes 11-digit phone number format
         return phoneRegex.test(phoneNumber);
      },

      async updateDeliveryAddress(){
         this.loading = true;

         var form = new FormData();
         var _primary = this.delivery_address_primary == true ? 1 : 0;
         form.append('action', 'atlantis_user_delivery_address');
         form.append('event', 'update');
         if( this.delivery_address_name != '' &&
            this.delivery_address_phone != '' &&

            address != ''){
               var _phoneNumberString = String( this.delivery_address_phone);
            if( this.validatePhoneNumber( _phoneNumberString) == false ){
               this.text_res = 'Phone numner is not invalid';
               this.loading = false;

            }else{
               this.text_res = '';
               form.append('longitude', lng);
               form.append('latitude', lat);

               form.append('name', this.delivery_address_name);
               form.append('phone', this.delivery_address_phone);
               form.append('address', address );
               form.append('primary', _primary);
               form.append('id_delivery', this.delivery_address_id);

               // if( _primary == 1 ){
               //    localStorage.setItem( 'watergo_order_delivery_address', '[]' );
               // }

               var r = await window.request( form);

               if(r != undefined ){
                  var res = JSON.parse( JSON.stringify( r ));
                  if( res.message == 'update_delivery_address_ok' ){
                     this.goBackUpdate(this.delivery_address_id);

                  }
               }

            }
         }else{
            this.text_res = 'Field must be not empty.';
            this.loading = false;
         }
      },

      async deleteDeliveryAddress(){
         var form = new FormData();
         form.append('action', 'atlantis_user_delivery_address');
         form.append('event', 'delete');
         form.append('id_delivery', this.delivery_address_id);
         var r = await window.request(form);
         if(r != undefined ){
            var res = JSON.parse( JSON.stringify( r ));
            if( res.message == 'delete_delivery_address_ok' ){
               this.goBackDelete(this.delivery_address_id);
            }
         }
      },

      async get_delivery_address( delivery_id ){
         var form = new FormData();
         form.append('action', 'atlantis_get_delivery_address_single');
         form.append('delivery_id', delivery_id);
         var r = await window.request(form);
         if( r != undefined ){
            var res = JSON.parse( JSON.stringify(r));
            if( res.message == 'get_delivery_address_ok'){
               this.delivery_address_name       = res.data.name;
               this.delivery_address_phone      = res.data.phone;
               this.delivery_address_location   = res.data.address;
               this.delivery_address_primary    = res.data.primary == 1 ? true : false;
               this.latitude                    = res.data.latitude;
               this.longitude                   = res.data.longitude;
               address                          = this.delivery_address_location;
               lat                              = res.data.latitude;
               lng                              = res.data.longitude;

            }
         }
      },


      goBack(){
         window.location.href = '?appt=X'; 
      },
      goBackUpdate(id_delivery){
         window.location.href = `?appt=X&data=delivery_just_update|id_delivery=${id_delivery}`;
      },
      goBackDelete(id_delivery){
         window.location.href = `?appt=X&data=delivery_just_delete|id_delivery=${id_delivery}`;
      },


      validateEmail(email) {
         // Regular expression for email validation
         const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
         return emailRegex.test(email);
      },

      validatePhoneNumber(phoneNumber) {
         // Regular expression for phone number validation
         const phoneRegex = /^\d{10,12}$/; // Assumes 11-digit phone number format
         return phoneRegex.test(phoneNumber);
      },

      async get_location_from_address( address ){ return window.get_location_from_address(address) },

   },

   async created(){
      this.loading = true;
      const urlParams = new URLSearchParams(window.location.search);
      this.delivery_address_id = urlParams.get('delivery_id');
      await this.get_delivery_address(this.delivery_address_id);
      this.loading = false;
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