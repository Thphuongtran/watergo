<div id='app'>

   <div v-show='loading == false' class='page-notification'>

      <div class='appbar'>
         <div class='appbar-top'>
            <div class='leading'>
               <button @click='goBack' class='btn-action'>
                  <svg width="20" height="16" viewBox="0 0 20 16" fill="none" xmlns="http://www.w3.org/2000/svg">
                  <path fill-rule="evenodd" clip-rule="evenodd" d="M0 8C0 7.44772 0.447715 7 1 7H18.5C19.0523 7 19.5 7.44772 19.5 8C19.5 8.55228 19.0523 9 18.5 9H1C0.447715 9 0 8.55228 0 8Z" fill="#252831"/>
                  <path fill-rule="evenodd" clip-rule="evenodd" d="M10.5309 0.375342C10.8759 0.806604 10.806 1.4359 10.3747 1.78091L2.60078 8.00004L10.3747 14.2192C10.806 14.5642 10.8759 15.1935 10.5309 15.6247C10.1859 16.056 9.55657 16.1259 9.12531 15.7809L0.375305 8.78091C0.13809 8.59113 0 8.30382 0 8.00004C0 7.69625 0.13809 7.40894 0.375305 7.21917L9.12531 0.219168C9.55657 -0.125842 10.1859 -0.0559202 10.5309 0.375342Z" fill="#252831"/>
                  </svg>
               </button>
               <p class='leading-title'><?php echo __('Notification', 'watergo'); ?></p>
            </div>
         </div>
      </div>

      <div v-if='notifications.length > 0 ' class='list-notification'>
         <div class='notification-item '
            v-for='(item, keyItem) in notifications' :key='keyItem'
            :class='item.is_read == 0 ? "is_not_read" : "" '
            @click='gotoOrderDetail(item)'
         >
            <div class='leading'>
               <img :src='item.attachment_url'>
            </div>
            <div class='contents'>
               <div class='tt01' v-html=' title_compact(item )'></div>
               <div class='tt02'>{{ formatDate(item.time_created) }}</div>
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

<script tpye='module'>

var { createApp } = Vue;

createApp({
   data (){
      return {
         loading: false,
         notifications: [],
         paged: 0,
      }
   },

   mounted() { window.addEventListener('scroll', this.handleScroll); },
   beforeDestroy() { window.removeEventListener('scroll', this.handleScroll); },
   
   methods: {

      async gotoOrderDetail( item ){ 
         await this.mark_user_read_notification(item.id);
         item.is_read = 1;
         window.location.href = item.link;
      },

      async mark_user_read_notification(id_notification){
         var form = new FormData();
         form.append('action', 'atlantis_notification_mark_read_notification');
         form.append('id_notification', id_notification);
         var r = await window.request(form);
      },

      formatDate(inputDate) {
         if (inputDate != undefined && inputDate != null) {
            const dateObj = new Date(inputDate);
            const day = dateObj.getDate().toString().padStart(2, '0');
            const month = (dateObj.getMonth() + 1).toString().padStart(2, '0');
            const year = dateObj.getFullYear().toString();
            const hours = dateObj.getHours();
            const minutes = dateObj.getMinutes().toString().padStart(2, '0');

            // Convert hours to 12-hour format and determine AM/PM
            const amPm = hours >= 12 ? 'pm' : 'am';
            const formattedHours = hours % 12 === 0 ? 12 : hours % 12;

            const formattedDate = `${day}/${month}/${year} ${formattedHours}:${minutes} ${amPm}`;
            return formattedDate;
         }
         return false;
      },

      formatNumberWithLeadingZeros(number) {
         if (number < 1000) {
            return ('000' + number).slice(-4);
         } else {
            return number.toString();
         }
      },

      title_compact( item ){
         if( item.order_status == 'ordered' && item.send_to == 'store' ){
            return `You have new order <span class="hightlight-order">#${this.formatNumberWithLeadingZeros(item.order_number)}</span>`;
         }
         if( item.order_status == 'cancel' && item.send_to == 'store' ){
            return `The order <span class="hightlight-order">#${this.formatNumberWithLeadingZeros(item.order_number)}</span> is canceled`;
         }

         if( item.order_status == 'confirmed' && item.send_to == 'user' ){
            return `Your order <span class="hightlight-order">#${this.formatNumberWithLeadingZeros(item.order_number)}</span> is confirmed`;
         }

         if( item.order_status == 'cancel' && item.send_to == 'user' ){
            return `Your order <span class="hightlight-order">#${this.formatNumberWithLeadingZeros(item.order_number)}</span> is canceled`;
         }

      },

      goBack(){ 
         window.location.href = '?appt=X&data=notification_count';
      },

      async load_all_notification( paged ){
         var form = new FormData();
         form.append('action', 'atlantis_notification_load_all');
         form.append('paged', paged);
         var r = await window.request(form);
         if( r != undefined ){
            var res = JSON.parse( JSON.stringify(r));
            if( res.message == 'notification_found' ){
               res.data.forEach(item => {
                  if (!this.notifications.some(existingItem => existingItem.id === item.id)) {
                     this.notifications.push(item);
                  }
               });
            }

         }
      },

      async handleScroll() {
         const windowTop = window.pageYOffset || document.documentElement.scrollTop;
         const scrollEndThreshold = 50; // Adjust this value as needed
         const scrollPosition = window.pageYOffset || document.documentElement.scrollTop;
         const windowHeight = window.innerHeight;
         const documentHeight = document.documentElement.scrollHeight;
         var windowScroll     = scrollPosition + windowHeight + scrollEndThreshold;
         var documentScroll   = documentHeight + scrollEndThreshold;

         if (scrollPosition + windowHeight + 10 >= documentHeight - 10) {
            await this.load_all_notification( this.paged++);
         }
      }
      
      

   },

   async created(){
      this.loading = true;
      await this.load_all_notification(0);

      this.loading = false;

      window.appbar_fixed();
      
   }

}).mount('#app');
</script>