<div id='app'>
   <div v-if='loading == false' class='page-support'>

      <div class='appbar'>
         <div class='appbar-top'>
            <div class='leading'>
               <button @click='gotoSupport' class='btn-action'>
                  <svg width="20" height="16" viewBox="0 0 20 16" fill="none" xmlns="http://www.w3.org/2000/svg">
                  <path fill-rule="evenodd" clip-rule="evenodd" d="M0 8C0 7.44772 0.447715 7 1 7H18.5C19.0523 7 19.5 7.44772 19.5 8C19.5 8.55228 19.0523 9 18.5 9H1C0.447715 9 0 8.55228 0 8Z" fill="#252831"/>
                  <path fill-rule="evenodd" clip-rule="evenodd" d="M10.5309 0.375342C10.8759 0.806604 10.806 1.4359 10.3747 1.78091L2.60078 8.00004L10.3747 14.2192C10.806 14.5642 10.8759 15.1935 10.5309 15.6247C10.1859 16.056 9.55657 16.1259 9.12531 15.7809L0.375305 8.78091C0.13809 8.59113 0 8.30382 0 8.00004C0 7.69625 0.13809 7.40894 0.375305 7.21917L9.12531 0.219168C9.55657 -0.125842 10.1859 -0.0559202 10.5309 0.375342Z" fill="#252831"/>
                  </svg>
               </button>
               <p class='leading-title'>WaterGo Support</p>
            </div>
         </div>
      </div>

      <div v-if='supports.length > 0' class='list-support-notify'>
         <ul v-for='(item, index) in supports' :key='index'>
            <li :class='item.is_read == 0 ? "is_read" : ""' @click='gotoPageSupportNotificationDetail(item.id)'>
               <div class='time'>{{ timestamp_to_date( item.time_answer ) }}</div>
               <div class='question'>{{ item.question }} </div>
            </li>
         </ul>
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
         supports: []
      }
   },
   methods: {
      timestamp_to_date(timestamp){ return window.timestamp_to_date(timestamp);},
      gotoSupport(){ window.gotoSupport();},
      gotoPageSupportNotificationDetail(support_id){ window.gotoPageSupportNotificationDetail(support_id);},
   },
   async created(){
      this.loading = true;
      var form = new FormData();
      form.append('action', 'atlantis_support');
      if( this.supports.length == 0 ){
         var r = await window.request(form);
         if( r != undefined ){
            var res = JSON.parse( JSON.stringify(r));
            if( res.message == 'get_support_ok' ){
               this.supports.push( ...res.data);
            }
         }
      };
      this.loading = false;
   }
}).mount('#app');
</script>