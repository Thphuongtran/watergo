<div class='page-delivery-address'>

   <div class='page-appbar'>
      <div class='on-left'>

         <button v-if='delivery_address_edit_form == false' @click='gotoProfile' class='btn-back'>
            <img width='18' src='<?php echo THEME_URI . '/assets/images/button-back.png'; ?>'>
         </button>
         <button v-if='delivery_address_edit_form == true' @click='button_close_formDeliveryAddress' class='btn-back'>
            <img width='18' src='<?php echo THEME_URI . '/assets/images/button-back.png'; ?>'>
         </button>

         <p class='title'>
            {{ delivery_actions == null ? "Delivery Address" : "" }}
            {{ delivery_actions == 'add' ? "Add Address" : "" }}
            {{ delivery_actions == 'update' ? "Edit Address" : "" }}
         </p>
      </div>
      <div class='on-right'>
         <div class='actions'>
            <button v-if='delivery_address_edit_form == false' class='button small' @click='buttonAddDeliveryAddress'>Add New</button>
         </div>
      </div>
   </div>

   <div v-if='this.delivery_address.length == 0 && delivery_address_edit_form == false' class='box-center'>
      <div class='banner-notify center'>
         <div class='notify-wrapper'>
            <img width='95' height='95' src="<?php echo THEME_URI . '/assets/images/icon-store.png' ?>" alt="There is no address">
            <p class='text style01'>There is no address</p>
         </div>
      </div>
   </div>

   <ul class='list-tile col3 no-padding' v-if='this.delivery_address.length > 0 && delivery_address_edit_form == false'>
      <li v-for='(delivery, index) in delivery_address' :key='index'>
         <div class='leading'>
            <div class="radio-button" :class='delivery.primary == true ? "active" : ""'></div>
         </div>
         <div class='contents'>
            <div class='address'>{{ delivery.address }}</div>
            <div class='gr-horizontal'>
               <span class='name'>{{ delivery.name }}</span> | <span class='phone'>{{ delivery.phone }}</span>
            </div>
            <span v-if='delivery.primary == true' class='badge-default'>Default</span>
         </div>
         <div class='actions'>
            <button @click='buttonEditDeliveryAddress(delivery.id)'>Edit</button>
         </div>
      </li>
   </ul>

   <!-- DELIVERY FORM -->

   <div class='page-delivery-address-add' v-if='delivery_address_edit_form == true'>
      
      <div class='form-group02'>
         <div class='label-style02'>Name</div>
         <input class='input-style02' v-model='delivery_address_name' type="text">
      </div>

      <div class='form-group02'>
         <div class='label-style02'>Phone</div>
         <input class='input-style02' v-model='delivery_address_phone' type="phone">
      </div>

      <div class='form-group02'>
         <div class='label-style02'>Address</div>
         <input class='input-style02' v-model='delivery_address_location' type="email">
      </div>

      <div class='form-group switch'>
         <p>Select as default address</p>
         <label class="toggle-switch">
            <input type="checkbox" v-model='delivery_address_primary' :value='delivery_address_primary'>
            <span class="slider"></span>
         </label>
      </div>

      <button v-if='delivery_actions == "update" ' class='text-primary' @click='deleteDeliveryAddress'>Delete Address</button>

      <button @click='actionDeliveryAddress' class='button'>
         {{ delivery_actions == 'add' ? "Add" : "" }}
         {{ delivery_actions == 'update' ? "Save" : "" }}
      </button>

   </div>

</div>