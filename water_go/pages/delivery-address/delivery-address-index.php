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
               <p class='leading-title'>Delivery Address</p>
            </div>
            <div class='action'>
               <button class='btn btn-primary small' @click='gotoDeliveryAddressAdd'>Add New</button>
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
               </svg>
               <p class='text'>There is no address</p>
            </div>
         </div>
      </div>

      <ul class='list-tile col3' v-if='delivery_address.length > 0'>
         <li 
            v-for='(delivery, index) in delivery_address' :key='index'
         >
            <div @click='change_default_delivery_address(delivery.id )' class='leading'>
               <div class="radio-button" :class='delivery.primary == true ? "active" : ""'></div>
            </div>
            <div @click='change_default_delivery_address(delivery.id )' class='content'>
               <div class='tt01'>{{ delivery.address }}</div>
               <div class='gr-horizontal'>
                  <span class='tt02'>{{ delivery.name }}</span><span class='tt02'> (+84) {{ removeZeroLeading(delivery.phone) }}</span>
               </div>
               <span v-if='delivery.primary == true' class='badge-default'>Default</span>
            </div>
            <div class='action'>
               <button class='btn-text btn-edit-delivery-address' @click='gotoDeliveryAddressEdit(delivery.id)'>Edit</button>
            </div>
         </li>
      </ul>
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
   data(){
      return{
         loading: false,
         delivery_address: [],
         delivery_id_primary: 0
      }
   },

   watch: {

      delivery_id_primary: async function( delivery_id ){
         var find = this.delivery_address.some( item => item.primary == 1 && item.id == delivery_id );
         
         if( ! find ){
            this.loading = true;
            var form = new FormData();
            form.append('action', 'atlantis_user_change_delivery_address_quick');
            form.append('delivery_address_id', delivery_id);
            var r = await window.request(form);
            if( r != undefined ){
               var res = JSON.parse( JSON.stringify( r ));
               if( res.message == 'delivery_address_primary_ok' ){
                  // force all to false primary
                  this.delivery_address.forEach(item => {
                     if( item.id == delivery_id ){
                        item.primary = 1;
                     }else{
                        item.primary = 0;
                     }
                  });
               }
            }
            setTimeout(() => {
               this.loading = false;
            }, 300);
         }
      }

   },

   methods: {
      goBack(){ window.goBack(true) },
      gotoDeliveryAddressAdd(){ window.gotoDeliveryAddressAdd()},
      gotoDeliveryAddressEdit(delivery_id){ window.gotoDeliveryAddressEdit(delivery_id)},
      removeZeroLeading( n ){ return window.removeZeroLeading(n)},
      
      change_default_delivery_address( delivery_id ){
         this.delivery_id_primary = delivery_id;
      },

      async get_delivery_address(){
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
   },

   async created(){
      this.loading = true;
      await this.get_delivery_address();
      this.loading = false;

      window.appbar_fixed();

   },

   
}).mount('#app');


</script>