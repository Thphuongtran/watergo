const module_get_order_delivering = {
   template: `
      <div v-show='order != null' class='banner-order-delivering-space' :class='banner_delivering_active == true && order != null ? "d-block" : ""'></div>
      <div 
         @click='gotoOrderDetail(order.order_id)'
         v-show='order != null' class='banner-order-delivering' :class='banner_delivering_active == true && order != null ? "" : "d-none"'>

         <div class='icon-leading'>
            <svg width="39" height="39" viewBox="0 0 39 39" fill="none" xmlns="http://www.w3.org/2000/svg">
            <circle cx="19.5" cy="19.5" r="19.5" fill="white"/>
            <path d="M22.125 11H15.625C15.194 11 14.7807 11.1712 14.476 11.476C14.1712 11.7807 14 12.194 14 12.625V25.625C14 26.056 14.1712 26.4693 14.476 26.774C14.7807 27.0788 15.194 27.25 15.625 27.25H25.375C25.806 27.25 26.2193 27.0788 26.524 26.774C26.8288 26.4693 27 26.056 27 25.625V15.875L22.125 11Z" stroke="#2790F9" stroke-width="1.3" stroke-linecap="round" stroke-linejoin="round"/>
            <path d="M22.125 11V15.875H27" stroke="#2790F9" stroke-width="1.3" stroke-linecap="round" stroke-linejoin="round"/>
            <path d="M23.75 19.9375H17.25" stroke="#2790F9" stroke-width="1.3" stroke-linecap="round" stroke-linejoin="round"/>
            <path d="M23.75 23.1875H17.25" stroke="#2790F9" stroke-width="1.3" stroke-linecap="round" stroke-linejoin="round"/>
            <path d="M18.875 16.6875H18.0625H17.25" stroke="#2790F9" stroke-width="1.3" stroke-linecap="round" stroke-linejoin="round"/>
            </svg>
         </div>

         <div class='title' v-html='title_compact(get_order_number)'></div>

         <div class='icon-arrow'>
            <svg width="8" height="13" viewBox="0 0 8 13" fill="none" xmlns="http://www.w3.org/2000/svg">
            <path d="M1.5 12L7 6.5L1.5 1" stroke="black" stroke-width="1.2" stroke-linecap="round" stroke-linejoin="round"/>
            </svg>
         </div>

      </div>
   `,
   data(){
      return {
         banner_delivering_active: false,
         order: null,
      }
   },

   computed: {
      get_order_number(){
         if( this.order != null && this.order.order_number != null ){
            return '#' + this.addLeadingZeros(this.order.order_number);
         }
      }
   },

   methods: {
      gotoOrderDetail(order_id){ window.gotoOrderDetail(order_id)},

      addLeadingZeros(n){ return window.addLeadingZeros( parseInt(n))},

      title_compact( order_number ){
         if( this.$root.get_locale == 'vi'){
            return `Đơn <span class='t-primary'>${order_number}</span> đang chờ cửa hàng xác nhận`;
         }else{
            return `Order <span class='t-primary'>${order_number}</span> is awaiting store confirmation`;
         }
      },

      async get_order_ordered(){
         var form = new FormData();
         form.append('action', 'atlantis_get_order_ordered');
         var r = await window.request(form);
         if( r != undefined ){
            var res = JSON.parse( JSON.stringify(r));
            if( res.message == 'order_delivering_found' ){
               this.order                    = res.data;
               this.banner_delivering_active = true;
               setTimeout(() => {}, 100);
            }
         }
      },

   },

   async mounted(){
      await setInterval( async () => {
         console.log('every 5 second')
         await this.get_order_ordered();
      }, 5000); // demo 5second
   },

};