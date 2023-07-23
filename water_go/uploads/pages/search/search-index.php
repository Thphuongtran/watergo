<div id='app'>

   <div v-if='loading == false' class='page-search'>

      <div class='page-appbar-support'>
         <div class='appbar'>

            <div class='appbar-top'>
               <div class='leading'>

                  <button @click='goBack' class='btn-action'>
                     <svg width="20" height="16" viewBox="0 0 20 16" fill="none" xmlns="http://www.w3.org/2000/svg">
                     <path fill-rule="evenodd" clip-rule="evenodd" d="M0 8C0 7.44772 0.447715 7 1 7H18.5C19.0523 7 19.5 7.44772 19.5 8C19.5 8.55228 19.0523 9 18.5 9H1C0.447715 9 0 8.55228 0 8Z" fill="white"/>
                     <path fill-rule="evenodd" clip-rule="evenodd" d="M10.5309 0.375342C10.8759 0.806604 10.806 1.4359 10.3747 1.78091L2.60078 8.00004L10.3747 14.2192C10.806 14.5642 10.8759 15.1935 10.5309 15.6247C10.1859 16.056 9.55657 16.1259 9.12531 15.7809L0.375305 8.78091C0.13809 8.59113 0 8.30382 0 8.00004C0 7.69625 0.13809 7.40894 0.375305 7.21917L9.12531 0.219168C9.55657 -0.125842 10.1859 -0.0559202 10.5309 0.375342Z" fill="white"/>
                     </svg>
                  </button>

                  <div class='box-search style01'>

                     <input class='input-search' type='text' v-model='inputSearch' placeholder='Search by product or store name'>
                     <span class='icon-search'>
                        <svg width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path fill-rule="evenodd" clip-rule="evenodd" d="M4.90688 0.60506C5.87126 0.205599 6.90488 0 7.94872 0C8.99256 0 10.0262 0.205599 10.9906 0.60506C11.9549 1.00452 12.8312 1.59002 13.5693 2.32813C14.3074 3.06623 14.8929 3.94249 15.2924 4.90688C15.6918 5.87126 15.8974 6.90488 15.8974 7.94872C15.8974 8.99256 15.6918 10.0262 15.2924 10.9906C14.9914 11.7172 14.5848 12.3938 14.0869 12.999L19.7747 18.6868C20.0751 18.9872 20.0751 19.4743 19.7747 19.7747C19.4743 20.0751 18.9872 20.0751 18.6868 19.7747L12.999 14.0869C12.3938 14.5848 11.7172 14.9914 10.9906 15.2924C10.0262 15.6918 8.99256 15.8974 7.94872 15.8974C6.90488 15.8974 5.87126 15.6918 4.90688 15.2924C3.94249 14.8929 3.06623 14.3074 2.32813 13.5693C1.59002 12.8312 1.00452 11.9549 0.60506 10.9906C0.2056 10.0262 0 8.99256 0 7.94872C0 6.90488 0.2056 5.87126 0.60506 4.90688C1.00452 3.94249 1.59002 3.06623 2.32813 2.32813C3.06623 1.59002 3.94249 1.00452 4.90688 0.60506ZM7.94872 1.53846C7.10691 1.53846 6.27335 1.70427 5.49562 2.02641C4.71789 2.34856 4.01123 2.82073 3.41598 3.41598C2.82073 4.01123 2.34856 4.71789 2.02641 5.49562C1.70427 6.27335 1.53846 7.10691 1.53846 7.94872C1.53846 8.79053 1.70427 9.62409 2.02641 10.4018C2.34856 11.1795 2.82073 11.8862 3.41598 12.4815C4.01123 13.0767 4.71789 13.5489 5.49562 13.871C6.27335 14.1932 7.10691 14.359 7.94872 14.359C8.79053 14.359 9.62409 14.1932 10.4018 13.871C11.1795 13.5489 11.8862 13.0767 12.4815 12.4815C13.0767 11.8862 13.5489 11.1795 13.871 10.4018C14.1932 9.62409 14.359 8.79053 14.359 7.94872C14.359 7.10691 14.1932 6.27335 13.871 5.49562C13.5489 4.71789 13.0767 4.01123 12.4815 3.41598C11.8862 2.82073 11.1795 2.34856 10.4018 2.02641C9.62409 1.70427 8.79053 1.53846 7.94872 1.53846Z" fill="#252831"/>
                        </svg>
                     </span>

                     <span @click='removeText' v-if='inputSearch.length > 0' class='icon-delete'>
                        <svg width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                           <circle cx="10" cy="10" r="10" fill="#DEDEDE"/>
                           <path d="M14 6L6 14" stroke="#252831" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                           <path d="M6 6L14 14" stroke="#252831" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                        </svg>
                     </span>

                  </div>
               </div>
            </div>
         </div>
      </div>

      <div class='search-data'>
         <div class='inner'>

            <div class='grid-masonry'>
               <div @click='gotoProductDetail(product.id)' 
               class='product-design' 
               v-for='(product, index) in searchs' :key='index'>
                  <div class='img'>
                     <img :src='product.product_image.url'>
                  </div>
                  <div class='box-wrapper'>
                     <p class='tt01'>{{ product.name }} </p>
                     <p class='tt02'>{{ product.name_second }}</p>
                     <div class='gr-price'>
                        <span class='price'> {{ common_get_product_price(product.price) }} </span>
                     </div>
                  </div>
               </div>
            </div>
            
         </div>
      </div>



   </div>
   
</div>
<script type='module'>

var { createApp } = Vue;

createApp({
   data (){
      return {
         loading: false,
         searchs: [],
         inputSearch: '',
         latitude: 10.780900239854994,
         longitude: 106.7226271387539,
      }
   },

   computed: {
      
      
   },

   watch: {
      inputSearch: async function (){
         await this.filteredData()
      }
   },

   methods: {
      gotoProductDetail(id){ window.gotoProductDetail(id)},
      common_get_product_price(p, p2){ return window.common_get_product_price(p, p2)},
      goBack(){window.goBack()},
      removeText(){ this.inputSearch = ''; },

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

      async filteredData() {
         
         console.log(this.search)
         if( this.search != '' ){
            var form = new FormData();
            form.append('action', 'atlantis_search_data');
            form.append('lat', this.latitude);
            form.append('lng', this.longitude);
            form.append('search', this.inputSearch);

            var r = await window.request(form);
            console.log(r);

            if( r != undefined){
               var res = JSON.parse( JSON.stringify( r));
               if(res.message == 'search_found'){
                  this.searchs = res.data;
               }
               if( res.message == 'search_not_found'){
                  this.searchs = [];
               }
            }else{
               this.searchs = [];
            }

         }
      }

   },

   update(){
      console.log('update life cycle');
   },

   created(){
      this.get_current_location();

      (function($){
         $(document).ready(function(){
            var _appbar = $('.page-appbar-support');
            _appbar.addClass('fixed');
            $('#app').css('padding-top', _appbar.height());
         });
      })(jQuery);
   }
}).mount('#app');
</script>