/**
 * @access UPDATE ADD LOCATION TO DELIVERY ADDRESS
 */

const PageDeliveryAddress = {
   name: 'PageDeliveryAddress',
   template: `
<div v-if='$root.delivery_address_open == true'>
   <div v-if='navigator == "delivery_address"' class='page-delivery-address'>

      <div class='appbar fixed'>
         <div class='appbar-top'>
            <div class='leading'>
               <button @click='$root.btn_delivery_address_open' class='btn-action'>
                  <svg width="20" height="16" viewBox="0 0 20 16" fill="none" xmlns="http://www.w3.org/2000/svg">
                  <path fill-rule="evenodd" clip-rule="evenodd" d="M0 8C0 7.44772 0.447715 7 1 7H18.5C19.0523 7 19.5 7.44772 19.5 8C19.5 8.55228 19.0523 9 18.5 9H1C0.447715 9 0 8.55228 0 8Z" fill="#252831"/>
                  <path fill-rule="evenodd" clip-rule="evenodd" d="M10.5309 0.375342C10.8759 0.806604 10.806 1.4359 10.3747 1.78091L2.60078 8.00004L10.3747 14.2192C10.806 14.5642 10.8759 15.1935 10.5309 15.6247C10.1859 16.056 9.55657 16.1259 9.12531 15.7809L0.375305 8.78091C0.13809 8.59113 0 8.30382 0 8.00004C0 7.69625 0.13809 7.40894 0.375305 7.21917L9.12531 0.219168C9.55657 -0.125842 10.1859 -0.0559202 10.5309 0.375342Z" fill="#252831"/>
                  </svg>
               </button>
               <p class='leading-title'>Delivery Address</p>
            </div>
            <div class='action'>
               <button class='btn btn-primary small' @click='gotoAdd'>Add New</button>
            </div>
         </div>
      </div>


      <div v-if='delivery_address.length == 0' class='box-center'>
         <div class='banner-fixed'>
            <div class='notify-wrapper'>
               <svg width="95" height="95" viewBox="0 0 95 95" fill="none" xmlns="http://www.w3.org/2000/svg">
               <circle cx="47.3684" cy="47.6316" r="47.3684" fill="#E9E9E9"/>
               <path d="M66.3157 67.0649V46.0123V67.0649ZM27.4493 46.0123V67.0649V46.0123ZM59.6831 26.5791H34.0819C31.8764 26.5791 29.8845 27.7937 29.0283 29.6621L24.6457 39.2309C23.17 42.4506 25.6204 46.0983 29.422 46.2147H29.6244C32.8026 46.2147 35.3785 43.6661 35.3785 40.9283C35.3785 43.6611 37.9554 46.2147 41.1335 46.2147C44.3117 46.2147 46.8825 43.8483 46.8825 40.9283C46.8825 43.6611 49.4584 46.2147 52.6366 46.2147C55.8147 46.2147 58.3916 43.8483 58.3916 40.9283C58.3916 43.8483 60.9675 46.2147 64.1457 46.2147H64.343C68.1447 46.0963 70.5951 42.4485 69.1194 39.2309L64.7368 29.6621C63.8805 27.7937 61.8886 26.5791 59.6831 26.5791ZM24.2104 68.6844H69.5546H24.2104ZM34.7368 50.8706H42.8339C43.4782 50.8706 44.096 51.1265 44.5516 51.5821C45.0072 52.0376 45.2631 52.6555 45.2631 53.2997V62.2066H32.3076V53.2997C32.3076 52.6555 32.5635 52.0376 33.0191 51.5821C33.4747 51.1265 34.0925 50.8706 34.7368 50.8706ZM50.1214 68.6844V53.2997C50.1214 52.6555 50.3773 52.0376 50.8329 51.5821C51.2884 51.1265 51.9063 50.8706 52.5505 50.8706H59.0283C59.6725 50.8706 60.2904 51.1265 60.7459 51.5821C61.2015 52.0376 61.4574 52.6555 61.4574 53.2997V68.6844" fill="#E9E9E9"/>
               <path d="M66.3157 67.0649V46.0123M27.4493 46.0123V67.0649M24.2104 68.6844H69.5546M50.1214 68.6844V53.2997C50.1214 52.6555 50.3773 52.0376 50.8329 51.5821C51.2884 51.1265 51.9063 50.8706 52.5505 50.8706H59.0283C59.6725 50.8706 60.2904 51.1265 60.7459 51.5821C61.2015 52.0376 61.4574 52.6555 61.4574 53.2997V68.6844M59.6831 26.5791H34.0819C31.8764 26.5791 29.8845 27.7937 29.0283 29.6621L24.6457 39.2309C23.17 42.4506 25.6204 46.0983 29.422 46.2147H29.6244C32.8026 46.2147 35.3785 43.6661 35.3785 40.9283C35.3785 43.6611 37.9554 46.2147 41.1335 46.2147C44.3117 46.2147 46.8825 43.8483 46.8825 40.9283C46.8825 43.6611 49.4584 46.2147 52.6366 46.2147C55.8147 46.2147 58.3916 43.8483 58.3916 40.9283C58.3916 43.8483 60.9675 46.2147 64.1457 46.2147H64.343C68.1447 46.0963 70.5951 42.4485 69.1194 39.2309L64.7368 29.6621C63.8805 27.7937 61.8886 26.5791 59.6831 26.5791ZM34.7368 50.8706H42.8339C43.4782 50.8706 44.096 51.1265 44.5516 51.5821C45.0072 52.0376 45.2631 52.6555 45.2631 53.2997V62.2066H32.3076V53.2997C32.3076 52.6555 32.5635 52.0376 33.0191 51.5821C33.4747 51.1265 34.0925 50.8706 34.7368 50.8706Z" stroke="#252831" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"/>
               <p class='text'>There is no address</p>
            </div>
         </div>
      </div>

      <ul class='list-tile col3' v-if='delivery_address.length > 0'>
         <li @click='change_default_delivery_address(delivery)' v-for='(delivery, index) in delivery_address' :key='index'>
            <div class='leading'>
               <div class="radio-button" :class='delivery.primary == true ? "active" : ""'></div>
            </div>
            <div class='content'>
               <div class='tt01'>{{ delivery.address }}</div>
               <div class='gr-horizontal'>
                  <span class='tt02'>{{ delivery.name }}</span><span class='tt02'>{{ delivery.phone }}</span>
               </div>
               <span v-if='delivery.primary == true' class='badge-default'>Default</span>
            </div>
            <div class='action'>
               <button class='btn-text' @click='editDeliveryAddress(delivery.id)'>Edit</button>
            </div>
         </li>
      </ul>
   </div>



   <div v-if='navigator == "delivery_address_add"' class='page-delivery-address'>
      <div class='appbar fixed'>
         <div class='appbar-top'>
            <div class='leading'>
               <button @click='goBack' class='btn-action'>
                  <svg width="20" height="16" viewBox="0 0 20 16" fill="none" xmlns="http://www.w3.org/2000/svg">
                  <path fill-rule="evenodd" clip-rule="evenodd" d="M0 8C0 7.44772 0.447715 7 1 7H18.5C19.0523 7 19.5 7.44772 19.5 8C19.5 8.55228 19.0523 9 18.5 9H1C0.447715 9 0 8.55228 0 8Z" fill="#252831"/>
                  <path fill-rule="evenodd" clip-rule="evenodd" d="M10.5309 0.375342C10.8759 0.806604 10.806 1.4359 10.3747 1.78091L2.60078 8.00004L10.3747 14.2192C10.806 14.5642 10.8759 15.1935 10.5309 15.6247C10.1859 16.056 9.55657 16.1259 9.12531 15.7809L0.375305 8.78091C0.13809 8.59113 0 8.30382 0 8.00004C0 7.69625 0.13809 7.40894 0.375305 7.21917L9.12531 0.219168C9.55657 -0.125842 10.1859 -0.0559202 10.5309 0.375342Z" fill="#252831"/>
                  </svg>
               </button>
               <p class='leading-title'>Address Address</p>
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
               <input v-model='delivery_address_phone' type="tel">
            </div>
            <div class='form-group style01'>
               <span>Address</span>
               <input v-model='delivery_address_location' type="text">
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
               <button @click='addDeliveryAddress' class='btn btn-primary'>Add</button>
            </div>
         </div>
      </div>

   </div>


   <div v-if='navigator == "delivery_address_edit"' class='page-delivery-address'>
      <div class='appbar fixed'>
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
               <div>Name</div>
               <input v-model='delivery_address_name' type="text">
            </div>
            <div class='form-group style01'>
               <div>Phone</div>
               <input v-model='delivery_address_phone' type="tel">
            </div>
            <div class='form-group style01'>
               <div>Address</div>
               <input v-model='delivery_address_location' type="text">
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

   <div v-show='popup_confirm_delete' class='modal-popup open'>
      <div class='modal-wrapper'>
         <div class='modal-close'><div @click='buttonModalLogutCancel' class='close-button'><span></span><span></span></div></div>
         <p class='heading'>
         Do you want to delete this delivery address?</p>
         <div class='actions'>
            <button @click='buttonModalLogutCancel' class='btn btn-outline'>Cancel</button>
            <button @click='deleteDeliveryAddress' class='btn btn-primary'>Delete</button>
         </div>
      </div>
   </div>

</div>
   `,

   data(){
      return{

         image: get_template_directory_uri + '/assets/images/icon-store.png',

         navigator: 'delivery_address',
         // navigator: 'list', // add | edit | list
         delivery_address: [],

         text_res: '',

         delivery_address_id: null,
         delivery_address_name: null,
         delivery_address_phone: null,
         delivery_address_location: null,
         delivery_address_primary: false,
         delivery_address_latitude: 0,
         delivery_address_longitude: 0,

         popup_confirm_delete: false,

      }
   },

   methods: {

      resetForm(){
         this.delivery_address_id = null;
         this.delivery_address_name = null;
         this.delivery_address_phone = null;
         this.delivery_address_location = null;
         this.delivery_address_latitude = 0;
         this.delivery_address_longitude = 0;
         this.delivery_address_primary = false;
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

      gotoAdd(){
         this.resetForm();
         this.navigator = 'delivery_address_add';
      },

      goBack(){
         this.resetForm();
         this.navigator = 'delivery_address';
      },

      async change_default_delivery_address( delivery ){
         var delivery_id = parseInt( delivery.id );
         var form = new FormData();
         form.append('action', 'atlantis_user_change_delivery_address_quick');
         form.append('delivery_address_id', delivery_id);
         var r = await window.request(form);
         if( r != undefined ){
            var res = JSON.parse( JSON.stringify( r ));
            if( res.message == 'delivery_address_primary_ok' ){
               // force all to false primary
               this.delivery_address.some(item => item.primary = 0);
               delivery.primary = 1;
               this.$root.delivery_address_primary = delivery;
            }
         }
      },

      async get_location_from_address( address ){ return window.get_location_from_address(address) },

      async addDeliveryAddress(){

         var form = new FormData();
         form.append('action', 'atlantis_user_delivery_address');
         form.append('event', 'add');
         var _primary = this.delivery_address_primary == true ? 1 : 0;


         if( this.delivery_address_name != '' &&
            this.delivery_address_phone != '' &&
            this.delivery_address_location != ''){
               var _phoneNumberString = this.delivery_address_phone;
            if( this.validatePhoneNumber( _phoneNumberString) == false ){
               this.text_res = 'Phone numner is not invalid';
            }else{
               this.text_res = '';

               // UPDATE LATITUDE + LONGITUDE WHEN USER UPDATE LOCATION 
               var _get_address = await this.get_location_from_address(this.delivery_address_location);
               var _latitude = 0;
               var _longitude = 0;
               if(_get_address != undefined ){
                  var _res_address = JSON.parse( JSON.stringify( _get_address ));
                  var _latitude = _res_address.items[0].position.lat;
                  var _longitude = _res_address.items[0].position.lng;
               }

               // this.$root.loading = true;
               form.append('name', this.delivery_address_name);
               form.append('phone', this.delivery_address_phone);
               form.append('address', this.delivery_address_location);
               form.append('longitude', _longitude);
               form.append('latitude', _latitude);

               form.append('primary', _primary);
               var r = await window.request( form);
               if(r != undefined ){
                  var res = JSON.parse( JSON.stringify( r ));
                  if( res.message == 'add_delivery_address_ok' ){
                     // IF CHOOSE PRIMARY SET ALL TO FALS
                     if( _primary == 1 ){
                        this.delivery_address.some(item => item.primary = false);   
                     }
                     this.delivery_address.push({
                        id: res.data,
                        name: this.delivery_address_name,
                        address: this.delivery_address_location,
                        phone: this.delivery_address_phone,
                        primary: _primary,
                        longitude: _longitude,
                        latitude: _latitude
                     });
                  }
               }
               this.goBack();
               this.address_stream();
            }
         }else{
            this.text_res = 'Field must be not empty.';
         }
      },

      async editDeliveryAddress( id_delivery ){
         this.navigator = 'delivery_address_edit';
         this.delivery_address.forEach(( delivery, index ) => {
            if( delivery.id == id_delivery ){
               this.delivery_address_id = delivery.id;
               this.delivery_address_name = delivery.name;
               this.delivery_address_phone = delivery.phone;
               this.delivery_address_location = delivery.address;
               this.delivery_address_latitude = delivery.latitude;
               this.delivery_address_longitude = delivery.longitude;
               this.delivery_address_primary = delivery.primary == 1 ? true : false;
            }
         });
         this.address_stream();
      },


      async updateDeliveryAddress(){
         // UPDATE LATITUDE + LONGITUDE WHEN USER UPDATE LOCATION 
         var _get_address = await this.get_location_from_address(this.delivery_address_location);
         var _latitude = 0;
         var _longitude = 0;
         if(_get_address != undefined ){
            var _res_address = JSON.parse( JSON.stringify( _get_address ));
            var _latitude = _res_address.items[0].position.lat;
            var _longitude = _res_address.items[0].position.lng;
         }

         var form = new FormData();
         var _primary = this.delivery_address_primary == true ? 1 : 0;
         form.append('action', 'atlantis_user_delivery_address');
         form.append('event', 'update');
         if( this.delivery_address_name != '' &&
            this.delivery_address_phone != '' &&
            this.delivery_address_location != ''){
               var _phoneNumberString = String( this.delivery_address_phone);
            if( this.validatePhoneNumber( _phoneNumberString) == false ){
               this.text_res = 'Phone numner is not invalid';

            }else{
               this.text_res = '';
               form.append('longitude', _longitude);
               form.append('latitude', _latitude);

               form.append('name', this.delivery_address_name);
               form.append('phone', this.delivery_address_phone);
               form.append('address', this.delivery_address_location);
               form.append('primary', _primary);
               form.append('id_delivery', this.delivery_address_id);
               var r = await window.request( form);

               if(r != undefined ){
                  var res = JSON.parse( JSON.stringify( r ));
                  if( res.message == 'update_delivery_address_ok' ){
                     this.delivery_address.forEach((e, index) => {
                        if( _primary == 1 ){
                           e.primary = 0;
                        }
                        if( e.id == this.delivery_address_id ){
                           e.name = this.delivery_address_name;
                           e.phone = this.delivery_address_phone;
                           e.address = this.delivery_address_location;
                           e.latitude = this.delivery_address_latitude;
                           e.longitude = this.delivery_address_longitude;
                           e.primary = _primary;
                        }
                     });
                  }
               }
            }
            this.resetForm();
            this.address_stream();
            this.goBack();
         }else{
            this.text_res = 'Field must be not empty.';
         }
      },

      popup_deleteDeliveryAddress(){ this.popup_confirm_delete = true; },
      buttonModalLogutCancel(){ this.popup_confirm_delete = false; },

      async deleteDeliveryAddress(){
         var form = new FormData();
         form.append('action', 'atlantis_user_delivery_address');
         form.append('event', 'delete');
         form.append('id_delivery', this.delivery_address_id);
         var r = await window.request(form);
         if(r != undefined ){
            var res = JSON.parse( JSON.stringify( r ));
            if( res.message == 'delete_delivery_address_ok' ){
               this.delivery_address.forEach((e, index) => {
                  if( e.id == this.delivery_address_id ){
                     this.delivery_address.splice(index, 1);
                  }
               });
               this.buttonModalLogutCancel();
               this.navigator = 'delivery_address';
               this.address_stream();
            }
         }
      },

      address_stream(){
         if( this.delivery_address.length > 0 ){
            this.delivery_address.some( da => {
               if( da.primary == 1 ){
                  this.$root.delivery_address_primary = {
                     name: da.name,
                     phone: da.phone,
                     address: da.address,
                     latitude: da.latitude,
                     longitude: da.longitude
                  };
               }
            });
         }
      }

   },

   async created(){
      if( this.delivery_address.length == 0 ){
         var form = new FormData();
         form.append('action', 'atlantis_user_delivery_address');
         form.append('event', 'get');
         var r = await window.request(form);
         if( r != undefined ){
            var res = JSON.parse( JSON.stringify( r ));
            if( res.message == 'get_delivery_address_ok' ){
               if( res.data != undefined ){
                  this.delivery_address.push( ...res.data);
               }
            }
         }
      }

      if( this.delivery_address.length > 0 ){
         this.delivery_address.some( da => {
            if( da.primary == 1 ){
               this.$root.delivery_address_primary = {
                  name: da.name,
                  phone: da.phone,
                  address: da.address,
                  latitude: da.latitude,
                  longitude: da.longitude
               };
            }
         });
      }
      

   },


   mounted(){
   }
   
};


// COMPONENT EDIT

