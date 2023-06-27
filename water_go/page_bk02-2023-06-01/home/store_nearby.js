const HomeStoreNearby = {
   name: 'HomeStoreNearby',
   template: `
      <div class='gr-heading mt40'>
         <p class='heading'>Nearby</p>
         <span @click='$root.gotoPage("nearby", {back: "home"})' class='link'>See All</span>
      </div>

      <div class='list-horizontal'>
         <ul>
            <li @click='$root.gotoPage("store-detail", {back: "home", store_id: store.id })' 
            v-if='stores.length > 0' 
            v-for='(store, index) in stores' :key='index' class='product-design store-style'>
               <div class='img'>
                  <img :src='get_image_store(store.id)'>
               </div>
               <p class='tt01'>{{ store.name }} </p>
               <p class='tt02'>
                  2.0 km <svg width="15" height="14" viewBox="0 0 15 14" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M7.32901 11.7286L3.77618 13.8689C3.61922 13.9688 3.45514 14.0116 3.28391 13.9973C3.11269 13.9831 2.96287 13.926 2.83446 13.8261C2.70604 13.7262 2.60616 13.6012 2.53482 13.4511C2.46348 13.301 2.44921 13.1335 2.49202 12.9486L3.43373 8.9035L0.287545 6.18536C0.144861 6.05695 0.0558259 5.91055 0.0204402 5.74618C-0.0149455 5.58181 -0.00438691 5.42143 0.0521161 5.26505C0.10919 5.1081 0.1948 4.97968 0.308948 4.8798C0.423095 4.77992 0.580048 4.71571 0.779806 4.68718L4.93192 4.32333L6.53712 0.513664C6.60846 0.342443 6.71918 0.214026 6.86928 0.128416C7.01939 0.0428054 7.17263 0 7.32901 0C7.48597 0 7.63921 0.0428054 7.78874 0.128416C7.93827 0.214026 8.049 0.342443 8.12091 0.513664L9.72611 4.32333L13.8782 4.68718C14.078 4.71571 14.2349 4.77992 14.3491 4.8798C14.4632 4.97968 14.5488 5.1081 14.6059 5.26505C14.663 5.422 14.6738 5.58266 14.6384 5.74704C14.6031 5.91141 14.5137 6.05752 14.3705 6.18536L11.2243 8.9035L12.166 12.9486C12.2088 13.1341 12.1945 13.3019 12.1232 13.452C12.0519 13.6021 11.952 13.7268 11.8236 13.8261C11.6952 13.926 11.5453 13.9831 11.3741 13.9973C11.2029 14.0116 11.0388 13.9688 10.8819 13.8689L7.32901 11.7286Z" fill="#FFC83A"/></svg> 5.0
               </p>
            </li>
         </ul>
      </div>
   `,
   data(){
      return{
         stores: []
      }
   },
   methods: {

      get_image_store(store_id){
         return get_template_directory_uri + '/assets/images/demo-product01.png';
      }

   },

   async created(){
      var form = new FormData();
      form.append('action', 'atlantis_load_store');
      var r = await window.request(form);
      if( r != undefined ){
         var res = JSON.parse( JSON.stringify(r ));
         if( res.message == 'store_found' ){
            this.stores.push( ...res.data );
         }
      }
   },
   mounted(){
      
   }


}