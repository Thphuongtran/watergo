<div id='app'>

   <div v-if='loading == false' class='page-edit'>
      <delivery-address></delivery-address>

   </div>
</div>

<script src='<?php echo THEME_URI . '/pages/module/delivery_address.js' ?>'></script>
<script type='module'>

var { createApp } = Vue;

createApp({

   data (){
      return {
         loading: false,
         delivery_address_open: true
      }
   },

   methods: {
      btn_delivery_address_open(){ window.goBack();}
   }

}).component('delivery-address',PageDeliveryAddress)
.mount('#app');
</script>