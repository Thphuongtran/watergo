<div id='app'>
   
</div>

<script type='module'>

var { createApp } = Vue;

createApp({
   data (){
      return {
         navigator: 'order',
      }
   },
   methods: {
      async gotoPage( page, transport){ 
         // save to history
         this.navigatorHistory.push({ to: page, transport: transport });
         window.scrollTo(0, 0);
         
         // special navigator 
         if( page == 'product-detail'){
            var _product_id = transport.product_id;
            await this.$refs.ref_product_detail.findProduct(_product_id);
            this.navigator = page;
         }else if( page == 'store-detail'){
            var _store_id = transport.store_id;
            await this.$refs.ref_store_detail.findStore(_store_id);
            this.navigator = page;
         }else if( page == 'home-order'){
            this.$refs.ref_home_order.reset_delivery_time();
            this.navigator = page;
         }else{
            this.navigator = page;
         }

         console.log('EXPLODE HISTORY NAVIGATOR ');
         console.log( this.navigatorHistory);
      },

      gotoHome(){
         this.navigatorHistory = [];
         this.navigator = 'home';
      },

      // THIS FUNCTION HELPER AUTOMATIC BACK NAVIGATOR
      goBack(){
         if( this.navigatorHistory.length > 0 ){
            var last = this.navigatorHistory.length - 1;
            var back = this.navigatorHistory[last].transport.back;
            this.navigator = back;
            this.navigatorHistory.pop();
         }
      },
   },

   computed: {

   }
});
</script>