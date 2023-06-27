<div id='app'>
   <div v-if='loading == false' class='page-nearby-store'>

      <div class='appbar'>
         <div class='appbar-top'>
            <div class='leading'>
               <button @click='goBack' class='btn-action'>
                  <svg width="11" height="16" viewBox="0 0 11 16" fill="none" xmlns="http://www.w3.org/2000/svg">
                  <path fill-rule="evenodd" clip-rule="evenodd" d="M10.5309 0.375342C10.8759 0.806604 10.806 1.4359 10.3747 1.78091L2.60078 8.00004L10.3747 14.2192C10.806 14.5642 10.8759 15.1935 10.5309 15.6247C10.1859 16.056 9.55657 16.1259 9.12531 15.7809L0.375305 8.78091C0.13809 8.59113 0 8.30382 0 8.00004C0 7.69625 0.13809 7.40894 0.375305 7.21917L9.12531 0.219168C9.55657 -0.125842 10.1859 -0.0559202 10.5309 0.375342Z" fill="#252831"/>
                  </svg>
               </button>
               <span class='leading-title'>Nearby</span>
            </div>
         </div>
      </div>

      <div v-if='stores.length > 0' class='inner'>
         <div class='grid-masonry'>
            <div @click='gotoStoreDetail(store.id)' 
               class='product-design' 
               v-for='(store, index) in stores' :key='index'>
               <div class='img'>
                  <img :src='get_image_upload(store.store_image)'>
               </div>
               <div class='box-wrapper'>
                  <p class='tt01'>{{ store.name }} </p>
                  <p class='product-meta'>
                     <span class='store-distance'>{{ mathCeilDistance(store.distance) }} km</span>
                     <svg v-if='store.avg_rating > 0' width="15" height="14" viewBox="0 0 15 14" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M7.32901 11.7286L3.77618 13.8689C3.61922 13.9688 3.45514 14.0116 3.28391 13.9973C3.11269 13.9831 2.96287 13.926 2.83446 13.8261C2.70604 13.7262 2.60616 13.6012 2.53482 13.4511C2.46348 13.301 2.44921 13.1335 2.49202 12.9486L3.43373 8.9035L0.287545 6.18536C0.144861 6.05695 0.0558259 5.91055 0.0204402 5.74618C-0.0149455 5.58181 -0.00438691 5.42143 0.0521161 5.26505C0.10919 5.1081 0.1948 4.97968 0.308948 4.8798C0.423095 4.77992 0.580048 4.71571 0.779806 4.68718L4.93192 4.32333L6.53712 0.513664C6.60846 0.342443 6.71918 0.214026 6.86928 0.128416C7.01939 0.0428054 7.17263 0 7.32901 0C7.48597 0 7.63921 0.0428054 7.78874 0.128416C7.93827 0.214026 8.049 0.342443 8.12091 0.513664L9.72611 4.32333L13.8782 4.68718C14.078 4.71571 14.2349 4.77992 14.3491 4.8798C14.4632 4.97968 14.5488 5.1081 14.6059 5.26505C14.663 5.422 14.6738 5.58266 14.6384 5.74704C14.6031 5.91141 14.5137 6.05752 14.3705 6.18536L11.2243 8.9035L12.166 12.9486C12.2088 13.1341 12.1945 13.3019 12.1232 13.452C12.0519 13.6021 11.952 13.7268 11.8236 13.8261C11.6952 13.926 11.5453 13.9831 11.3741 13.9973C11.2029 14.0116 11.0388 13.9688 10.8819 13.8689L7.32901 11.7286Z" fill="#FFC83A"/></svg>
                     <span v-if='store.avg_rating > 0' class='store-rating'>{{ratingNumber(store.avg_rating)}}</span>
                  </p>
               </div>
            </div>
         </div>
      </div>


   </div>
   <div v-if='loading == true'>
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
         latitude: 10.780900239854994,
         longitude: 106.7226271387539,
         stores: [],
         limit: 10,
         page: 0,
      }
   },
   methods: {
      ratingNumber(rating){ return parseFloat(rating).toFixed(1); },
      mathCeilDistance( distance ){ return parseFloat(distance).toFixed(1); },
      get_current_location(){

         if( window.appBridge != undefined ){
            window.appBridge.getLocation().then( (data) => {
               if (Object.keys(data).length === 0) {
                  alert("Error-1 :Không thể truy cập vị trí");
               }else{
                  let lat = data.lat;
                  let lng = data.lng;
                  this.latitude = data.lat;
                  this.longitude = data.lng;
               }
            }).catch((e) => { alert(e); })
         }
      },

      get_image_upload( i ){ return window.get_image_upload( i );},

      has_discount( product ){ return window.has_discount(product); },
      get_product_quantity( product ) { return window.get_product_quantity(product) },
      common_get_product_price( price, discount_percent ){return window.common_get_product_price(price, discount_percent)},

      gotoStoreDetail(store_id){ window.gotoStoreDetail(store_id)},
      goBack(){ window.goBack(); },
   },
   computed: {
   },
   async created() {
      this.get_current_location();
      this.loading = true;
      var form = new FormData();
      form.append('action', 'atlantis_get_store_location');
      form.append('lat', this.latitude);
      form.append('lng', this.longitude);
      var r = await window.request(form);
      if( r != undefined ){
         var res = JSON.parse( JSON.stringify(r ));
         if( res.message == 'store_location_found' ){
            this.stores.push( ...res.data );
         }
      }
      this.loading = false;
   },

   mounted(){
      
   }
}).mount('#app');
</script>
