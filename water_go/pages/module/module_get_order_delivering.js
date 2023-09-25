const module_get_order_delivering = {
   template: `
      <div class='banner-order-delivering-space' v-show='orders.length > 0'></div>
      <div 
         class='banner-order-delivering' :class='banner_delivering_active == true ? "" : "d-none"'>

         <div @click='test_add_item' class='icon-leading'>
            <svg width="39" height="39" viewBox="0 0 39 39" fill="none" xmlns="http://www.w3.org/2000/svg">
            <circle cx="19.5" cy="19.5" r="19.5" fill="white"/>
            <path d="M22.125 11H15.625C15.194 11 14.7807 11.1712 14.476 11.476C14.1712 11.7807 14 12.194 14 12.625V25.625C14 26.056 14.1712 26.4693 14.476 26.774C14.7807 27.0788 15.194 27.25 15.625 27.25H25.375C25.806 27.25 26.2193 27.0788 26.524 26.774C26.8288 26.4693 27 26.056 27 25.625V15.875L22.125 11Z" stroke="#2790F9" stroke-width="1.3" stroke-linecap="round" stroke-linejoin="round"/>
            <path d="M22.125 11V15.875H27" stroke="#2790F9" stroke-width="1.3" stroke-linecap="round" stroke-linejoin="round"/>
            <path d="M23.75 19.9375H17.25" stroke="#2790F9" stroke-width="1.3" stroke-linecap="round" stroke-linejoin="round"/>
            <path d="M23.75 23.1875H17.25" stroke="#2790F9" stroke-width="1.3" stroke-linecap="round" stroke-linejoin="round"/>
            <path d="M18.875 16.6875H18.0625H17.25" stroke="#2790F9" stroke-width="1.3" stroke-linecap="round" stroke-linejoin="round"/>
            </svg>
         </div>

         <div class='order-slide-wrapper'><ul class='order-slider'>

         </ul></div>

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
         orders: [],
         is_store: false,
         is_slick_run: false,

      }
   },

   computed: {
      orders_filter(){
         return this.orders;
      }
   },

   watch: {
      orders: {
         handler( data ){
            if( data.length > 0){
               this.banner_delivering_active = true;
            }else{
               this.banner_delivering_active = false;
            }
         },
         deep: true
      }
   },

   methods: {

      addLeadingZeros(n){ return window.addLeadingZeros( parseInt(n))},

      get_order_number(){
         if( this.order != null && this.order.order_number != null ){
            return '#' + this.addLeadingZeros(this.order.order_number);
         }
      },

      title_compact( order ){
         // console.log( this.$root.get_locale );

         var _order_number = window.addLeadingZeros( parseInt(order.order_number));
         if( this.$root.get_locale == 'vi'){
            return `<p>Đơn <span class='t-primary'>#${_order_number}</span> đang chờ cửa hàng xác nhận</p>`;
         }
         if( this.$root.get_locale == 'ko_KR'){
            return `<p>고객님의 주문 <span class='t-primary'>#${_order_number}</span> 확인 중입니다</p>`;
         }
         return `<p>Order <span class='t-primary'>#${_order_number}</span> is awaiting store confirmation</p>`;
      },

      async get_order_ordered(){
         var form = new FormData();
         form.append('action', 'atlantis_get_order_multiple_time');
         var r = await window.request(form);
         if( r != undefined ){
            var res = JSON.parse( JSON.stringify(r));
            if( res.message == 'order_found' ){

               this.is_store = res.is_store == 0 || res.is_store == null ? false : true;

               res.data.forEach( _order => {
                  var _order_exists = this.orders.find( item => item.order_id == _order.order_id );
                  if( ! _order_exists ){
                     this.orders.push( _order);
                     var _item = '<li id="order-'+ _order.order_id +'">' + this.title_compact(_order) + '</li>';
                     $('.order-slide-wrapper .order-slider').slick('slickAdd', _item);
                     var slickElement = $('.order-slide-wrapper .order-slider');
                     if (slickElement.hasClass('slick-initialized')) {
                        slickElement.slick('refresh');
                        slickElement.on('click', '#order-' + _order.order_id, function() {
                           if( window.app.$refs.module_get_order_delivering.is_store == false ){
                              window.gotoOrderDetail(_order.order_id);
                           }else{
                              window.gotoOrderStoreDetail(_order.order_id);
                           }
                        });
                     }
                  }
               });
               
            }
         }
      },

      async is_order_confirmed(){
         if( this.orders.length > 0 ){
            var lists = [];
            this.orders.forEach(item => {
               if (!lists.includes(item.order_id)) {
                  lists.push(item.order_id);
               }
            });

            var form = new FormData();
            form.append('action', 'atlantis_is_order_confirmed');
            form.append('order_ids', JSON.stringify(lists));
            var r = await window.request(form);
            if( r != undefined ){
               var res = JSON.parse( JSON.stringify(r));
               if( res.message == 'order_confirmed_ok' ){
                  res.data.forEach( item => { 
                     var findIndex = this.orders.findIndex( order => order.order_id == item.order_id );
                     if( findIndex != -1 ){

                        this.orders.splice(findIndex, 1);
                        var liElement = $('#order-' + item.order_id);
                        var dataIndex = liElement.data('slick-index');
                        var slickElement = $('.order-slide-wrapper .order-slider');
                        if (slickElement.hasClass('slick-initialized')) {
                           slickElement.slick('slickRemove', dataIndex);
                           slickElement.slick('refresh');
                        }

                     }
                  });
               }
               
            }
         }
      },

      initializeSlick() {

         $('.order-slide-wrapper .order-slider').slick({
            dots: false,
            arrows: false,
            infinite: true,
            speed: 400,
            slidesToShow: 1,
            slidesToScroll: 1,
            autoplay: true,
            autoplaySpeed: 4000,
         });

      },

   },

   async mounted(){

      this.initializeSlick();
      await setInterval( async () => {
         await this.get_order_ordered();
      }, 1500); 
      await setInterval( async () => {
         await this.is_order_confirmed();
      }, 2000);

   },

};

