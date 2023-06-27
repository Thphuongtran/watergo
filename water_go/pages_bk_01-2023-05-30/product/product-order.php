<?php
   // PAGE PRODUCT ORDER [ home ]
?>

<div v-if='navigator == "order" && product_details != null ' class='page-product-order'>

   <div class='appbar'>

      <div class='leading'>
         <a v-if='delivery_address_form == false' class='btn-action' href="#">
            <svg width="20" height="16" viewBox="0 0 20 16" fill="none" xmlns="http://www.w3.org/2000/svg">
            <path fill-rule="evenodd" clip-rule="evenodd" d="M0 8C0 7.44772 0.447715 7 1 7H18.5C19.0523 7 19.5 7.44772 19.5 8C19.5 8.55228 19.0523 9 18.5 9H1C0.447715 9 0 8.55228 0 8Z" fill="#252831"/>
            <path fill-rule="evenodd" clip-rule="evenodd" d="M10.5309 0.375342C10.8759 0.806604 10.806 1.4359 10.3747 1.78091L2.60078 8.00004L10.3747 14.2192C10.806 14.5642 10.8759 15.1935 10.5309 15.6247C10.1859 16.056 9.55657 16.1259 9.12531 15.7809L0.375305 8.78091C0.13809 8.59113 0 8.30382 0 8.00004C0 7.69625 0.13809 7.40894 0.375305 7.21917L9.12531 0.219168C9.55657 -0.125842 10.1859 -0.0559202 10.5309 0.375342Z" fill="#252831"/>
            </svg>
         </a>

         <button @click='gotoPage("product-details")' class='btn-action'>
            <svg width="20" height="16" viewBox="0 0 20 16" fill="none" xmlns="http://www.w3.org/2000/svg">
            <path fill-rule="evenodd" clip-rule="evenodd" d="M0 8C0 7.44772 0.447715 7 1 7H18.5C19.0523 7 19.5 7.44772 19.5 8C19.5 8.55228 19.0523 9 18.5 9H1C0.447715 9 0 8.55228 0 8Z" fill="#252831"/>
            <path fill-rule="evenodd" clip-rule="evenodd" d="M10.5309 0.375342C10.8759 0.806604 10.806 1.4359 10.3747 1.78091L2.60078 8.00004L10.3747 14.2192C10.806 14.5642 10.8759 15.1935 10.5309 15.6247C10.1859 16.056 9.55657 16.1259 9.12531 15.7809L0.375305 8.78091C0.13809 8.59113 0 8.30382 0 8.00004C0 7.69625 0.13809 7.40894 0.375305 7.21917L9.12531 0.219168C9.55657 -0.125842 10.1859 -0.0559202 10.5309 0.375342Z" fill="#252831"/>
            </svg>
         </button>

         <p class='leading-title'>Order</p>
      </div>

   </div>

   <div class='break-line'></div> 
   <div class='inner'>
      <div @click='gotoPage("delivery_address")' class='list-tile delivery-address'>

         <div class='content'>
            <div v-if='hasDeliveryAddressPrimary == false'>
               <p class='tt01'>Delivery address</p>
               <p class='tt02'>There is no address</p>
            </div>
            <div v-else>
               <p class='tt01'>Delivery address</p>
               <p class='tt03'>{{ get_delivery_primary.address }}</p>
               <p class='tt02'>{{ get_delivery_primary.name }} | {{ get_delivery_primary.phone }}</p>
            </div>
         </div>
         <div class='action'>
            <button class='btn-action'>
               <svg width="8" height="14" viewBox="0 0 8 14" fill="none" xmlns="http://www.w3.org/2000/svg">
               <path d="M1 13L7 7L1 1" stroke="#7B7D83" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
               </svg>
            </button>
         </div>

      </div>
   </div>

   <div class='break-line'></div>
   <div class='inner'>

      <div class='list-tile order'>

         <div class='shop-detail'>
            <div class='logo'>
               <svg width="21" height="17" viewBox="0 0 21 17" fill="none" xmlns="http://www.w3.org/2000/svg">
               <rect x="2.5" y="6.5" width="16" height="10" rx="1.5" fill="white" stroke="black"/>
               <path d="M20.096 4.43083L20.0959 4.4307L17.8831 0.787088L17.8826 0.786241C17.7733 0.605479 17.5825 0.5 17.3865 0.5H3.61215C3.41614 0.5 3.22534 0.605479 3.11605 0.786241L3.11554 0.787088L0.902826 4.43061C0.902809 4.43064 0.902792 4.43067 0.902775 4.4307C0.0376853 5.85593 0.639918 7.73588 1.97289 8.31233C2.15024 8.38903 2.34253 8.44415 2.54922 8.47313C2.67926 8.49098 2.81302 8.5 2.9473 8.5C3.80016 8.5 4.5594 8.1146 5.08594 7.50809L5.46351 7.07318L5.84107 7.50809C6.36742 8.11438 7.12999 8.5 7.97971 8.5C8.83258 8.5 9.59181 8.1146 10.1184 7.50809L10.4959 7.07318L10.8735 7.50809C11.3998 8.11438 12.1624 8.5 13.0121 8.5C13.865 8.5 14.6242 8.1146 15.1508 7.50809L15.5273 7.07438L15.905 7.50705C16.4357 8.11494 17.1956 8.5 18.0445 8.5C18.1822 8.5 18.3128 8.49098 18.4433 8.47304L20.096 4.43083ZM20.096 4.43083C21.0907 6.06765 20.1619 8.23575 18.4435 8.47301L20.096 4.43083Z" fill="white" stroke="black"/>
               </svg>
            </div>
            <span class='shop-name'>{{ product_details.store.name }}</span>
         </div>

         <div class='list-items'>
            <span class='quantity'>{{ product_details_quantity_order }}x</span>
            <div class='order-gr'>
               <span class='product-title'>{{ product_details.name }}</span>
               <span class='product-subtitle'>{{ get_product_quantity(product_details) }}</span>
            </div>
            <div class='order-price'>
               <span>{{ get_price_order }}</span>
               <span class='od-price-discount' v-if='has_discount(product_details) == true '>{{ get_product_price(product_details.price) }}</span>
            </div>
         </div>

      </div>

   </div>

   <div class='break-line'></div>
   <div class='select_delivery_time'>
      <p class='heading-02'>Select delivery time</p>
      <div class='list-delivery'>

         <!-- DELIVERY SELECT TYPE -->
         <!-- DELIVERY ONCE -->
         <div class='group-tile'>

            <div class='form-check'>
               <input @click='buttonDeliverySelectType("once")' :checked='getDeliverySelectType("once")' id='select_type01' type="radio" class='form-input'>
               <label for='select_type01' >Delivery once</label>
            </div>

            <div v-show='deliverySelectType.once' class='group-time-delivery-once'>

               <div class='form-group-select'>
                  <div class='form-check'>
                     <input id='select_delivery_time_Immediately' type='checkbox' @click='buttonDeliverySelectTypeTimeOnce("immediately")' :checked='deliverySelectType.timeOnce.immediately == true ? true : false'>
                     <label for='select_delivery_time_Immediately'>Immediately (within 1 hour)</label>
                  </div>
                  <div class='form-check'>
                     <input id='select_delivery_time_Date-Time' type='checkbox' @click='buttonDeliverySelectTypeTimeOnce("selectDate")' :checked='deliverySelectType.timeOnce.selectDate == true ? true : false'>
                     <label for='select_delivery_time_Date-Time' class='custom-checkbox'>Select Date & Time</label>
                  </div>

               </div>

               <div v-show='deliverySelectType.timeOnce.selectDate' class='group-select-delivery-time'>
                  <button class='btn-dropdown' @click='buttonSelectDate'>{{ deliveryTimeData.once.date == null ? "Select date" : deliveryTimeData.once.date }}</button>
                  <button class='btn-dropdown' @click='buttonSelectTime'>
                     {{ deliveryTimeData.once.time == null ? "Select time" : deliveryTimeData.once.time }}
                  </button>
               </div>

               <div class='deliveryDisplay'>
                  
                  <div v-if='datePickerDatePopup'>
                     <?php get_template_part('pages/user/datetime-table'); ?>
                  </div>

                  <div class='time-table'>
                     <div v-show='datePickerTimePopup' class='dropdown-order size-half style-time-table right'>
                        <div class='dropdown-contents'>
                           <div @click='button_get_data_delivery("once", null, "time", "7:00 - 8:00")' class='dropdown-item'><span>7:00</span>-<span>8:00</span></div>
                           <div @click='button_get_data_delivery("once", null, "time", "8:00 - 9:00")' class='dropdown-item'><span>8:00</span>-<span>9:00</span></div>
                           <div @click='button_get_data_delivery("once", null, "time", "9:00 - 10:00")' class='dropdown-item'><span>9:00</span>-<span>10:00</span></div>
                           <div @click='button_get_data_delivery("once", null, "time", "10:00 - 11:00")' class='dropdown-item'><span>10:00</span>-<span>11:00</span></div>
                           <div @click='button_get_data_delivery("once", null, "time", "11:00 - 12:00")' class='dropdown-item'><span>11:00</span>-<span>12:00</span></div>
                           <div @click='button_get_data_delivery("once", null, "time", "12:00 - 13:00")' class='dropdown-item'><span>12:00</span>-<span>13:00</span></div>
                           <div @click='button_get_data_delivery("once", null, "time", "13:00 - 14:00")' class='dropdown-item'><span>13:00</span>-<span>14:00</span></div>
                           <div @click='button_get_data_delivery("once", null, "time", "14:00 - 15:00")' class='dropdown-item'><span>14:00</span>-<span>15:00</span></div>
                           <div @click='button_get_data_delivery("once", null, "time", "15:00 - 16:00")' class='dropdown-item'><span>15:00</span>-<span>16:00</span></div>
                           <div @click='button_get_data_delivery("once", null, "time", "16:00 - 17:00")' class='dropdown-item'><span>16:00</span>-<span>17:00</span></div>
                           <div @click='button_get_data_delivery("once", null, "time", "17:00 - 18:00")' class='dropdown-item'><span>17:00</span>-<span>18:00</span></div>
                           <div @click='button_get_data_delivery("once", null, "time", "18:00 - 19:00")' class='dropdown-item'><span>18:00</span>-<span>19:00</span></div>
                           <div @click='button_get_data_delivery("once", null, "time", "19:00 - 20:00")' class='dropdown-item'><span>19:00</span>-<span>20:00</span></div>
                           <div @click='button_get_data_delivery("once", null, "time", "20:00 - 21:00")' class='dropdown-item'><span>20:00</span>-<span>21:00</span></div>
                        </div>
                     </div>
                  </div>
               </div>               
            </div>
         </div>
            

         <div class='group-tile'>
            <div class='form-check'>
               <input @click='buttonDeliverySelectType("weekly")' :checked='getDeliverySelectType("weekly")' id='select_type02' type="radio" class='form-input'>
               <label for='select_type02'>Delivery weekly</label>
            </div>

            <!-- DELIVERY WEEKLY -->
            <div class='deliverySelect_weekly' v-show='deliverySelectType.weekly'>
               
               <div v-for='i in deliveryWeeklyDomIncrement' :key='i' class='deliverySelect_weekly_dom' :style="{ order: i }">
                  <div class='group-select-delivery-time style01 static'>
                     <button @click='button_open_DeliveryWeekly_day(i)' class='btn-dropdown'>
                        <span class='text'>{{ fill_value_to_texture_deliverySelect("weekly", i, "day", "Select day") }}</span>
                     </button>
                     <button @click='button_open_DeliveryWeekly_time(i)' class='btn-dropdown'>
                        <span class='text'>{{ fill_value_to_texture_deliverySelect("weekly", i, "time", "Select time") }}</span>
                     </button>
                  </div>
               </div>

               <div class='deliveryDisplay' :style="{ order : deliveryWeeklyOrder}">
                  
                  <div v-show='deliverySelect_weekly_day' class='day-table'>
                     <div class='dropdown-order size-half style-day-table left'>
                        <div class='dropdown-contents'>
                           <div @click='button_get_data_delivery("weekly", deliveryWeeklyOrder, "day", "Monday")' class='dropdown-item'>Monday</div>
                           <div @click='button_get_data_delivery("weekly", deliveryWeeklyOrder, "day", "Tueday")' class='dropdown-item'>Tueday</div>
                           <div @click='button_get_data_delivery("weekly", deliveryWeeklyOrder, "day", "Wednesday")' class='dropdown-item'>Wednesday</div>
                           <div @click='button_get_data_delivery("weekly", deliveryWeeklyOrder, "day", "Thursday")' class='dropdown-item'>Thursday</div>
                           <div @click='button_get_data_delivery("weekly", deliveryWeeklyOrder, "day", "Friday")' class='dropdown-item'>Friday</div>
                           <div @click='button_get_data_delivery("weekly", deliveryWeeklyOrder, "day", "Saturday")' class='dropdown-item'>Saturday</div>
                           <div @click='button_get_data_delivery("weekly", deliveryWeeklyOrder, "day", "Sunday")' class='dropdown-item'>Sunday</div>
                        </div>
                     </div>
                  </div>
                  
                  <div v-show='deliverySelect_weekly_time' class='time-table'>
                     <div class='dropdown-order size-half style-time-table right'>
                        <div class='dropdown-contents'>
                           <div @click='button_get_data_delivery("weekly", deliveryWeeklyOrder, "time", "7:00 - 8:00")' class='dropdown-item'><span>7:00</span>-<span>8:00</span></div>
                           <div @click='button_get_data_delivery("weekly", deliveryWeeklyOrder, "time", "8:00 - 9:00")' class='dropdown-item'><span>8:00</span>-<span>9:00</span></div>
                           <div @click='button_get_data_delivery("weekly", deliveryWeeklyOrder, "time", "9:00 - 10:00")' class='dropdown-item'><span>9:00</span>-<span>10:00</span></div>
                           <div @click='button_get_data_delivery("weekly", deliveryWeeklyOrder, "time", "10:00 - 11:00")' class='dropdown-item'><span>10:00</span>-<span>11:00</span></div>
                           <div @click='button_get_data_delivery("weekly", deliveryWeeklyOrder, "time", "11:00 - 12:00")' class='dropdown-item'><span>11:00</span>-<span>12:00</span></div>
                           <div @click='button_get_data_delivery("weekly", deliveryWeeklyOrder, "time", "12:00 - 13:00")' class='dropdown-item'><span>12:00</span>-<span>13:00</span></div>
                           <div @click='button_get_data_delivery("weekly", deliveryWeeklyOrder, "time", "13:00 - 14:00")' class='dropdown-item'><span>13:00</span>-<span>14:00</span></div>
                           <div @click='button_get_data_delivery("weekly", deliveryWeeklyOrder, "time", "14:00 - 15:00")' class='dropdown-item'><span>14:00</span>-<span>15:00</span></div>
                           <div @click='button_get_data_delivery("weekly", deliveryWeeklyOrder, "time", "15:00 - 16:00")' class='dropdown-item'><span>15:00</span>-<span>16:00</span></div>
                           <div @click='button_get_data_delivery("weekly", deliveryWeeklyOrder, "time", "16:00 - 17:00")' class='dropdown-item'><span>16:00</span>-<span>17:00</span></div>
                           <div @click='button_get_data_delivery("weekly", deliveryWeeklyOrder, "time", "17:00 - 18:00")' class='dropdown-item'><span>17:00</span>-<span>18:00</span></div>
                           <div @click='button_get_data_delivery("weekly", deliveryWeeklyOrder, "time", "18:00 - 19:00")' class='dropdown-item'><span>18:00</span>-<span>19:00</span></div>
                           <div @click='button_get_data_delivery("weekly", deliveryWeeklyOrder, "time", "19:00 - 20:00")' class='dropdown-item'><span>19:00</span>-<span>20:00</span></div>
                           <div @click='button_get_data_delivery("weekly", deliveryWeeklyOrder, "time", "20:00 - 21:00")' class='dropdown-item'><span>20:00</span>-<span>21:00</span></div>
                        </div>
                     </div>
                  </div>

               </div>
               <button @click='createDomDeliveryWeekly' class='button_add_delivery button_add_dom_delivery_weekly' style="order: 99999">Add Day</button>
            </div>
         </div>

         <div class='group-tile'>

            <!-- DELIVERY MONTHLY -->
            <div class='form-check'>
               <input @click='buttonDeliverySelectType("monthly")' :checked='getDeliverySelectType("monthly")' id='select_type03' type="radio" class='form-input'>
               <label for='select_type03'>Delivery mothly</label>
            </div>

            <div class='deliverySelect_monthly' v-show='deliverySelectType.monthly'>

               <div v-for='i in deliveryMonthlyDomIncrement' :key='i' class='deliverySelect_monthly_dom' :style="{ order: i }">
                  <div class='group-select-delivery-time'>
                     <button @click='button_open_DeliveryMonth_date(i)' class='btn-dropdown'>
                        <span class='text'>{{ fill_value_to_texture_deliverySelect("monthly", i, "date", "Select date") }}</span>
                     </button>
                     <button @click='button_open_DeliveryMonth_time(i)' class='btn-dropdown'>
                        <span class='text'>{{ fill_value_to_texture_deliverySelect("monthly", i, "time", "Select time") }}</span>
                     </button>
                  </div>
               </div>

               <div class='deliveryDisplay' :style="{ order : deliveryMonthlyOrder}">
                  <div v-show='popup_deliverySelect_monthly_time' class='time-table'>
                     <div class='dropdown-order size-half style-time-table right'>
                        <div class='dropdown-contents'>
                           <div @click='button_get_data_delivery("monthly", deliveryMonthlyOrder, "time", "7:00 - 8:00")' class='dropdown-item'><span>7:00</span>-<span>8:00</span></div>
                           <div @click='button_get_data_delivery("monthly", deliveryMonthlyOrder, "time", "8:00 - 9:00")' class='dropdown-item'><span>8:00</span>-<span>9:00</span></div>
                           <div @click='button_get_data_delivery("monthly", deliveryMonthlyOrder, "time", "9:00 - 10:00")' class='dropdown-item'><span>9:00</span>-<span>10:00</span></div>
                           <div @click='button_get_data_delivery("monthly", deliveryMonthlyOrder, "time", "10:00 - 11:00")' class='dropdown-item'><span>10:00</span>-<span>11:00</span></div>
                           <div @click='button_get_data_delivery("monthly", deliveryMonthlyOrder, "time", "11:00 - 12:00")' class='dropdown-item'><span>11:00</span>-<span>12:00</span></div>
                           <div @click='button_get_data_delivery("monthly", deliveryMonthlyOrder, "time", "12:00 - 13:00")' class='dropdown-item'><span>12:00</span>-<span>13:00</span></div>
                           <div @click='button_get_data_delivery("monthly", deliveryMonthlyOrder, "time", "13:00 - 14:00")' class='dropdown-item'><span>13:00</span>-<span>14:00</span></div>
                           <div @click='button_get_data_delivery("monthly", deliveryMonthlyOrder, "time", "14:00 - 15:00")' class='dropdown-item'><span>14:00</span>-<span>15:00</span></div>
                           <div @click='button_get_data_delivery("monthly", deliveryMonthlyOrder, "time", "15:00 - 16:00")' class='dropdown-item'><span>15:00</span>-<span>16:00</span></div>
                           <div @click='button_get_data_delivery("monthly", deliveryMonthlyOrder, "time", "16:00 - 17:00")' class='dropdown-item'><span>16:00</span>-<span>17:00</span></div>
                           <div @click='button_get_data_delivery("monthly", deliveryMonthlyOrder, "time", "17:00 - 18:00")' class='dropdown-item'><span>17:00</span>-<span>18:00</span></div>
                           <div @click='button_get_data_delivery("monthly", deliveryMonthlyOrder, "time", "18:00 - 19:00")' class='dropdown-item'><span>18:00</span>-<span>19:00</span></div>
                           <div @click='button_get_data_delivery("monthly", deliveryMonthlyOrder, "time", "19:00 - 20:00")' class='dropdown-item'><span>19:00</span>-<span>20:00</span></div>
                           <div @click='button_get_data_delivery("monthly", deliveryMonthlyOrder, "time", "20:00 - 21:00")' class='dropdown-item'><span>20:00</span>-<span>21:00</span></div>
                        </div>
                     </div>
                  </div>

                  <?php get_template_part('pages/user/everymonth-table'); ?>

               </div>

               <button @click='createDomDeliveryMonthly' class='button_add_delivery button_add_dom_delivery_weekly' style="order: 99999">Add Date</button>
            </div>

         </div>

      </div>

   </div>

   <div class='break-line'></div>
   <div class='inner'>
      <p class='heading-02'>Payment method </p>
      <p>By Cash</p>
   </div>

   <div class='product-detailt-bottomsheet cell-placeorder'>
      <p class='price-total'>Total: <span class='t-primary t-bold'>{{ get_price_order }}</span></p>
      <button @click='buttonPlaceOrder' class='btn-primary' :class="isCanPlaceOrder == false ? 'disabled' : '' ">Place Order</button>
   </div>


</div>