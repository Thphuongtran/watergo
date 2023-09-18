<?php 
   $user_id = get_current_user_id();
?>


<div id='app'>
   <div v-show='loading == false' class='page-chat'>

      <div class='appbar'>
         <div class='appbar-top'>
            <div class='leading'>
               <button @click='goBack' class='btn-action'>
                  <svg width="20" height="16" viewBox="0 0 20 16" fill="none" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" clip-rule="evenodd" d="M0 8C0 7.44772 0.447715 7 1 7H18.5C19.0523 7 19.5 7.44772 19.5 8C19.5 8.55228 19.0523 9 18.5 9H1C0.447715 9 0 8.55228 0 8Z" fill="#252831"/><path fill-rule="evenodd" clip-rule="evenodd" d="M10.5309 0.375342C10.8759 0.806604 10.806 1.4359 10.3747 1.78091L2.60078 8.00004L10.3747 14.2192C10.806 14.5642 10.8759 15.1935 10.5309 15.6247C10.1859 16.056 9.55657 16.1259 9.12531 15.7809L0.375305 8.78091C0.13809 8.59113 0 8.30382 0 8.00004C0 7.69625 0.13809 7.40894 0.375305 7.21917L9.12531 0.219168C9.55657 -0.125842 10.1859 -0.0559202 10.5309 0.375342Z" fill="#252831"/></svg>
               </button>
               <div class='leading-group'>
                  <div class='leading-avatar'><img :src='user_group.to_user.avatar' ></div>
                  <div class='user-info'>
                     <div class="tt01">{{ user_group.to_user.name }}</div>
                  </div>
               </div>
            </div>
         </div>
         <div class='appbar-bottom'>
            <div v-if='product != null' class='product-pin'>
               <div class='leading'>
                  <img :src="product.product_image.url">
               </div>
               <div class='contents'>
                  <div v-if='product != null' class='tt01'>{{ product.name }}</div>
                  <div v-if='product != null' class='tt02'>{{ product.name_second }}</div>
                  <div v-if='product != null' class='tt03'>
                     <div v-if='product != null' class='gr-price' :class="has_discount(product) == true ? 'has_discount' : '' ">
                        <span class='price' v-if='product != null'>
                           {{ common_price_show_currency(product.price) }}
                        </span>
                        <span v-if='product != null && has_discount(product) == true' class='price-sub'>
                           {{ common_price_after_discount(product ) }}
                        </span>
                     </div>
                  </div>
               </div>
            </div>
         </div>

      </div>

      <div class='scaffold'>
         
         <div class='scaffold-body'>
            <div class='messenger-time'><span>{{ get_datetime(timestamp) }}</span></div>

            <ul v-if='messages.length > 0' class='list-messenger'>

               <li>
                  <div class='avatar'><img :src='img_dummy'></div>
                  <div class='messages'>Hi, may I ask about your product?</div>
               </li>

               <li class='is-host'>
                  <div class='avatar'><img :src='img_dummy'></div>
                  <div class='messages'>Hi, may I ask about your product?</div>
               </li>

            </ul>

         </div>

      </div>

      

   </div>

   <div class='box-form-chat'>
      <div class='box-chat'>
         <div class='avatar'><img :src='user_group.from_user.avatar'></div>
         
         <label class='input-chat'>
            <input v-model='chat_content' type='text' placeholder='<?php echo __('Message...', 'watergo'); ?>'>
            <span @click='btn_send_message' class='icon'>
               <svg width="28" height="28" viewBox="0 0 28 28" fill="none" xmlns="http://www.w3.org/2000/svg">
               <circle cx="14" cy="14" r="14" fill="#2790F9"/>
               <path d="M8.16226 20.93L22.649 14.7582C22.7988 14.6948 22.9265 14.5891 23.0162 14.4541C23.106 14.3191 23.1538 14.1609 23.1538 13.9991C23.1538 13.8374 23.106 13.6792 23.0162 13.5442C22.9265 13.4092 22.7988 13.3035 22.649 13.2401L8.16226 7.06833C8.03682 7.01395 7.89973 6.99147 7.76336 7.0029C7.627 7.01434 7.49564 7.05934 7.38114 7.13384C7.26664 7.20834 7.1726 7.30999 7.10751 7.42964C7.04242 7.54928 7.00833 7.68315 7.0083 7.81917L7 11.6229C7 12.0354 7.30717 12.3902 7.72226 12.4397L19.4528 13.9991L7.72226 15.5503C7.30717 15.6081 7 15.9629 7 16.3754L7.0083 20.1791C7.0083 20.7649 7.61434 21.1692 8.16226 20.93Z" fill="white"/>
               </svg>
            </span>

         </label>
      </div>
   </div>

   <div v-if='loading == true'>
      <div class='progress-center'>
         <div class='progress-container enabled'><progress class='progress-circular enabled' ></progress></div>
      </div>
   </div>

</div>

<script type='module'>


import { initializeApp } from "https://www.gstatic.com/firebasejs/10.4.0/firebase-app.js";
import { getFirestore, collection, query, where, orderBy, doc, getDocs, onSnapshot } from 'https://www.gstatic.com/firebasejs/10.4.0/firebase-firestore.js';

const firebaseConfig = {
   apiKey: "AIzaSyAIiPyRBqrwY8LVx5AruzKmsjL96j_lzr4",
   authDomain: "watergo-chat.firebaseapp.com",
   projectId: "watergo-chat",
   storageBucket: "watergo-chat.appspot.com",
   messagingSenderId: "663475773045",
   appId: "1:663475773045:web:e71a08bee3a9506c39223c",
   measurementId: "G-4E3CS9NC3T"
};


var app = Vue.createApp({
   data (){
      
      return {
         loading: false,
         messages: [],
         product: null,
         where_app: '', // chat_to_user | chat_to_store

         timestamp: '',

         user_group: {
            from_user: {
               id: null,
               name: 'User Name',
               avatar: '<?php echo THEME_URI . '/assets/images/avatar-dummy.png'; ?>',
            },
            to_user: {
               id: null,
               name: 'Store Name',
               avatar: '<?php echo THEME_URI . '/assets/images/store-dummy.png'; ?>',
            },
         },

         img_dummy: '<?php echo THEME_URI . '/assets/images/store-dummy.png'; ?>'

      }
   },
   methods: {
      

      goBack(){ window.goBack()},
      order_formatDate(t){ return window.order_formatDate(t)},
      has_discount( product ){ return window.has_discount(product); },
      common_price_show_currency(p){ return window.common_price_show_currency(p) },
      common_price_after_discount(p){ return window.common_price_after_discount(p) },

      // 
      get_datetime( timestamp ){
         var date_format = this.timestamp_to_date(timestamp);
         return this.getTimeDifference( date_format);
      },
      
      timestamp_to_date(timestamp) {
         var date = new Date(timestamp * 1000);
         var day = date.getDate().toString().padStart(2, '0');
         var month = (date.getMonth() + 1).toString().padStart(2, '0');
         var year = date.getFullYear();
         var hours = date.getHours().toString().padStart(2, '0');
         var minutes = date.getMinutes().toString().padStart(2, '0');
         var seconds = date.getSeconds().toString().padStart(2, '0');
         // YEAR MONTH DAY H:i:s
         return year + '-' + month + '-' + day + ' ' + hours + ':' + minutes + ':' + seconds;
      },

      getTimeDifference(datetime){ return window.getTimeDifference(datetime)},
      // 

      async get_product( product_id ){
         var form = new FormData();
         form.append('action', 'atlantis_find_product');
         form.append('product_id', product_id);
         var r = await window.request(form);
         if( r != undefined ){
            let res = JSON.parse( JSON.stringify(r));
            if( res.message == 'product_found' ){
               this.product = res.data;
            }
         }
      },

      async get_account_store(user_id){
         var form = new FormData();
         form.append('action', 'atlantis_get_account_store');
         form.append('user_id', user_id);
         var r = await window.request(form);
         if( r != undefined ){
            let res = JSON.parse( JSON.stringify(r));
            if( res.message == 'get_account_store_ok' ){
               return res.data;
            }
         }
      },

      async get_account_user(user_id){
         var form = new FormData();
         form.append('action', 'atlantis_get_account_user');
         form.append('user_id', user_id);
         var r = await window.request(form);
         if( r != undefined ){
            let res = JSON.parse( JSON.stringify(r));
            if( res.message == 'get_account_user_ok' ){
               return res.data;
            }
         }
      }

   },



   async created(){

      this.loading = true;
      const urlParams   = new URLSearchParams(window.location.search);
      this.messenger_id  = urlParams.get('messenger_id');
      this.where_app     = urlParams.get('where_app');

      const appFireBase = initializeApp(firebaseConfig);
      this.database = getFirestore(appFireBase);

      if(  this.messenger_id != undefined ){
         var getMessenger = doc(this.database, "messengers", this.messenger_id);
         var queryGetMessenger = query( getMessenger);

         await onSnapshot( queryGetMessenger, async ( messagesSnapshot ) => {
            const promises = [];
            if( messagesSnapshot.exists() ){
               const messagesItem = messagesSnapshot.data();
               promises.push( this.get_product(messagesItem.pin_product));
               this.timestamp = messagesItem.time_created.seconds;

               if( this.where_app == 'chat_to_store' ){
                  promises.push( this.user_group.to_user = await this.get_account_store(messagesItem.to_user));
                  promises.push( this.user_group.from_user = await this.get_account_user(messagesItem.from_user));

               }
               if( this.where_app == 'chat_to_user' ){
                  promises.push( this.user_group.from_user = await this.get_account_store(messagesItem.to_user));
                  promises.push( this.user_group.to_user = await this.get_account_user(messagesItem.from_user));
               }
            }

            await Promise.all( promises);

         });
      }

      
      setTimeout(() => {
         this.loading = false;
      }, 1000);
      

      



   }
}).mount('#app');
window.app = app;


</script>
