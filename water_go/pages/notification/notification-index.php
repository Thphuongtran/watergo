<div id='app'>
   <div v-if='loading == false' class='page-notification'>

      <div class='appbar'>
         <div class='appbar-top'>
            <div class='leading'>
               <button @click='goBack' class='btn-action'>
                  <svg width="20" height="16" viewBox="0 0 20 16" fill="none" xmlns="http://www.w3.org/2000/svg">
                  <path fill-rule="evenodd" clip-rule="evenodd" d="M0 8C0 7.44772 0.447715 7 1 7H18.5C19.0523 7 19.5 7.44772 19.5 8C19.5 8.55228 19.0523 9 18.5 9H1C0.447715 9 0 8.55228 0 8Z" fill="#252831"/>
                  <path fill-rule="evenodd" clip-rule="evenodd" d="M10.5309 0.375342C10.8759 0.806604 10.806 1.4359 10.3747 1.78091L2.60078 8.00004L10.3747 14.2192C10.806 14.5642 10.8759 15.1935 10.5309 15.6247C10.1859 16.056 9.55657 16.1259 9.12531 15.7809L0.375305 8.78091C0.13809 8.59113 0 8.30382 0 8.00004C0 7.69625 0.13809 7.40894 0.375305 7.21917L9.12531 0.219168C9.55657 -0.125842 10.1859 -0.0559202 10.5309 0.375342Z" fill="#252831"/>
                  </svg>
               </button>
               <p class='leading-title'>Notification</p>
            </div>
         </div>
      </div>

      <div class='list-notification'>

         <div class='notification-item is_not_read'>
            <div class='leading'>
               <img src='<?php echo THEME_URI; ?>/assets/images/demo-notification-01.png'>
            </div>
            <div class='contents'>
               <div class='tt01'>Your order <span class='t-primary'>#1234</span> is confirmed</div>
               <div class='tt02'>18/08/2022  9:45 am</div>
            </div>
         </div>
         <div class='notification-item is_not_read'>
            <div class='leading'>
               <img src='<?php echo THEME_URI; ?>/assets/images/demo-notification-01.png'>
            </div>
            <div class='contents'>
               <div class='tt01'>Your order <span class='t-primary'>#1234</span> is confirmed</div>
               <div class='tt02'>18/08/2022  9:45 am</div>
            </div>
         </div>
         <div class='notification-item is_not_read'>
            <div class='leading'>
               <img src='<?php echo THEME_URI; ?>/assets/images/demo-notification-01.png'>
            </div>
            <div class='contents'>
               <div class='tt01'>Your order <span class='t-primary'>#1234</span> is confirmed</div>
               <div class='tt02'>18/08/2022  9:45 am</div>
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

<script tpye='module'>

var { createApp } = Vue;

createApp({
   data (){
      return {
         loading: false,
         notifications: [],
         
      }
   },


   methods: {
      request(formdata){
         try{
            return axios({ method: 'post', url: get_ajaxadmin, data: formdata
            }).then(function (res) { 
               return res.status == 200 ? res.data.data : null;
            });
         }catch(e){
            console.log(e);
            return null;
         }
      },

      goBack(){ window.goBack()},
      
      async initNotification(){
         var form = new FormData();
         form.append('action', 'atlantis_notification');
         var r = await this.request(form);
         if( r != undefined ){
            var res = JSON.parse( JSON.stringify(r));
            if( res.message == 'notification_found' ){
               this.notifications.push(...res.data);
            }
         }
         console.log(r);
      }

   },

   async created(){
      this.loading = false;
      await this.initNotification();

      this.loading = true;
      
   }

}).mount('#app');
</script>