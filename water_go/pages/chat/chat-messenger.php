<?php 

   /**
      CHAT CONSTRUCTION
      {  
         chat/?chat_page=chat-messenger (url)
         conversation_id ( conversation_id_hash )
         &appt=N 
      }
   */
?>

<style>
   .list-messenger{
      padding: 0
   }
   .scaffold{
      height: 100%;
      overflow-y: auto;
      padding-bottom: 56px;
   }

   .btn_send_message.disabled{
      pointer-events: none;
   }

   .appbar-top{
      position: relative;
      box-shadow: 0px 1px 0px #EFEFF4;
   }

   .leading-group{
      /* width: 72%;
      position: absolute;
      text-align: center;
      transform: translateX(-50%);
      left: 50%;
      display: flex;
      align-items: center;
      justify-content: center; */
   }

   .page-chat{
	   display: grid;
	   grid-template-rows: 56px 1fr 56px;
	   height: 100vh;
	}

   .order-pin {
      width: 100%;
      display: flex;
      flex-flow: column nowrap;
      justify-content: flex-start;
      background: #F6F3F3;
      padding: 8px 50px;
      font-size: 13px;
      font-weight: 500;
   }
   .order-pin .t01 {
      font-size: 13px;
      font-weight: 500;
      color: #252831;
      padding: 5px 0;
   }
   .order-pin .t02 {
      color: #2790F9;
      padding: 5px 0;
   }

   .list-messenger li{
      padding: 0 16px;
      margin-bottom: 5px;
   }
   .list-messenger li .avatar {
      width: 32px;
      display: flex;
      opacity: 0;
   }

   .list-messenger li .avatar.show-avatar{
      opacity: 1;
   }
   .list-messenger li .message-wrapper {
      position: relative;
   }
   .list-messenger li .content {
      background: #F3F3F3;
      padding: 7px 10px;
      border-radius: 5px;
      max-width: 85%;
   }
   .list-messenger li.current-user .message-wrapper {
      justify-content: flex-end;
   }
   .list-messenger li.current-user .avatar {
      justify-content: flex-end;
   }
   .list-messenger li.current-user .content {
      background: #616DFF;
      color: white;
   }

   .list-messenger li.order-pin-wrapper:first-child{
      margin-top: 0;
   }

   .list-messenger li.order-pin-wrapper{
      padding: 0;
      margin-bottom: 20px;
      margin-top: 20px;
   }

   .list-messenger li.order-pin-wrapper.diff_type{
      margin-top: 0;
   }

   .list-messenger li.expanded{
      margin-bottom: 20px;
   }

   .message-time{
      padding-bottom: 5px;
   }

</style>
<?php 
   $user_id = get_current_user_id();
?>

<div id='app'>
   <div v-if='loading == false && message_not_found == false' class='page-chat'>

      <div class='appbar'>
         <div class='appbar-top'>
            <div class='leading'>
               <button @click='goBack' class='btn-action'>
                  <svg width="20" height="16" viewBox="0 0 20 16" fill="none" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" clip-rule="evenodd" d="M0 8C0 7.44772 0.447715 7 1 7H18.5C19.0523 7 19.5 7.44772 19.5 8C19.5 8.55228 19.0523 9 18.5 9H1C0.447715 9 0 8.55228 0 8Z" fill="#252831"/><path fill-rule="evenodd" clip-rule="evenodd" d="M10.5309 0.375342C10.8759 0.806604 10.806 1.4359 10.3747 1.78091L2.60078 8.00004L10.3747 14.2192C10.806 14.5642 10.8759 15.1935 10.5309 15.6247C10.1859 16.056 9.55657 16.1259 9.12531 15.7809L0.375305 8.78091C0.13809 8.59113 0 8.30382 0 8.00004C0 7.69625 0.13809 7.40894 0.375305 7.21917L9.12531 0.219168C9.55657 -0.125842 10.1859 -0.0559202 10.5309 0.375342Z" fill="#252831"/></svg>
               </button>
               <div class='leading-group'>
                  <div class='leading-avatar'>
                     <img :src='conversation.user_to_chat_avatar.url'>
                  </div>
                  <div class='user-info'>
                     <div class='tt01'>{{ conversation.user_to_chat_name }}</div>
                  </div>
               </div>
            </div>
         </div>
         <!-- <div v-show='order != null' class='order-pin'>
            <span class='t01'><?php echo __('Order', 'watergo'); ?> #{{ order.order_number_id }}</span>
            <span class='t02'>{{ common_price_show_currency(order.order_total_price) }}</span>
         </div> -->
      </div>

      <div class='scaffold'>
         <div class='scaffold-body'>
            <ul class='list-messenger'>

               <li
                  v-for='(message, messageKey ) in filter_messages' :key='messageKey'
                  :class='[
                     is_current_user(message.user_id) == true && message.message_type == "message" ? "current-user" : "",
                     message.message_type == "pin_order" ? "order-pin-wrapper" : "",
                     message.expanded == true ? "expanded" : "",
                     message.diff_type == true ? "diff_type" : "",
                     message.show_date == true ? "show_date" : ""
                  ]'
               >
                  <div v-if='message.message_type == "pin_order"' class='order-pin'>
                     <span class='t01'><?php echo __('Order', 'watergo'); ?> #{{ message.order_number_id }}</span>
                     <span class='t02'>{{ common_price_show_currency(message.order_total_price) }}</span>
                  </div>

                  <div v-if='show_time_chat(message.message_id) != false && message.message_type == "pin_order"' class='message-time'>{{ show_time_chat(message.message_id) }}</div>

                  <div v-if='message.message_type == "message"' 
                     class='message-wrapper'
                  >
                     <div v-if='is_current_user(message.user_id) == false' class="avatar"
                        :class='{ "show-avatar": message.show_avatar }'
                     >
                        <img :src='conversation.user_to_chat_avatar.url' >
                     </div>
                     <div class='content'>{{ message.content }}</div>
                     <div v-if='is_current_user(message.user_id) == true' class="avatar"
                        :class='{ "show-avatar": message.show_avatar }'
                     >
                        <img :src='conversation.current_user_avatar.url'>
                     </div>
                  </div>

                  <div v-if='show_time_chat(message.message_id) != false && message.message_type == "message"' class='message-time'>{{ show_time_chat(message.message_id) }}</div>

               </li>

            </ul>
         </div>
      </div>

      <div v-if='message_not_found == false' class='box-form-chat'>
         <div class='box-chat'>
            <div class='avatar'>
               <img :src='conversation.current_user_avatar.url'>
            </div>
            
            <label class='input-chat'>
               <input 
                  @focusin='handleFocusIn' @focusout='handleFocusOut'
                  v-model='chat_content' type='text' placeholder='<?php echo __('Message...', 'watergo'); ?>'>
               <span @click='atlantis_send_message' class='icon btn_send_message' :class='{ "disabled": is_send == true }'>
                  <svg width="28" height="28" viewBox="0 0 28 28" fill="none" xmlns="http://www.w3.org/2000/svg">
                  <circle cx="14" cy="14" r="14" fill="#2790F9"/>
                  <path d="M8.16226 20.93L22.649 14.7582C22.7988 14.6948 22.9265 14.5891 23.0162 14.4541C23.106 14.3191 23.1538 14.1609 23.1538 13.9991C23.1538 13.8374 23.106 13.6792 23.0162 13.5442C22.9265 13.4092 22.7988 13.3035 22.649 13.2401L8.16226 7.06833C8.03682 7.01395 7.89973 6.99147 7.76336 7.0029C7.627 7.01434 7.49564 7.05934 7.38114 7.13384C7.26664 7.20834 7.1726 7.30999 7.10751 7.42964C7.04242 7.54928 7.00833 7.68315 7.0083 7.81917L7 11.6229C7 12.0354 7.30717 12.3902 7.72226 12.4397L19.4528 13.9991L7.72226 15.5503C7.30717 15.6081 7 15.9629 7 16.3754L7.0083 20.1791C7.0083 20.7649 7.61434 21.1692 8.16226 20.93Z" fill="white"/>
                  </svg>
               </span>

            </label>
         </div>
      </div>
   </div>


   <div v-if='loading == true && message_not_found == false'>
      <div class='progress-center'>
         <div class='progress-container enabled'><progress class='progress-circular enabled' ></progress></div>
      </div>
   </div>

   <div class='modal-popup' :class='message_not_found == true ? "open" : ""'>
      <div class='modal-wrapper'>
         <div class='modal-close'><div @click='goBack' class='close-button'><span></span><span></span></div></div>
         <p class='heading'><?php echo __('Content Not Found', 'watergo'); ?> </p>
      </div>
   </div>

</div>

<script>

// import { initializeApp } from "https://www.gstatic.com/firebasejs/10.4.0/firebase-app.js";
// import { getFirestore, collection, query, where, orderBy, getDocs, updateDoc, onSnapshot } from 'https://www.gstatic.com/firebasejs/10.4.0/firebase-firestore.js';

// const firebaseConfig = {
//    apiKey: "AIzaSyAIiPyRBqrwY8LVx5AruzKmsjL96j_lzr4",
//    authDomain: "watergo-chat.firebaseapp.com",
//    projectId: "watergo-chat",
//    storageBucket: "watergo-chat.appspot.com",
//    messagingSenderId: "663475773045",
//    appId: "1:663475773045:web:e71a08bee3a9506c39223c",
//    measurementId: "G-4E3CS9NC3T"
// };


var app = Vue.createApp({
   data (){
      
      return {

         get_locale: '<?php echo get_locale(); ?>',
         loading: false,
         loading_data: false,
         message_not_found: false,
         messages: [],

         /**
          * { message_id, timestamp }
          */
         time_chat: [],

         conversation_id: 0,
         conversation: null,

         chat_content: '',

         current_user_id: parseInt(<?php echo $user_id; ?>),

         database: null,

         is_send: false,

         product: null,
         order: null,

         is_order_pin: false,
         is_product_pin: false,

      }
   },

   computed: {

      filter_messages(){

         if( this.messages.length > 0){
            const sortedMessages = [...this.messages].sort((a, b) => a.message_id - b.message_id);

            var _filter = sortedMessages.filter( fi => fi.message_type == 'message' );
            _filter.forEach( (item, key) => {
               var _prevItem = _filter[key - 1];
               if( _prevItem != undefined ){
                  if( item.user_id != _prevItem.user_id ){
                     item.show_avatar = true;
                     _prevItem.expanded = true;
                  }else{
                     item.show_avatar = false;
                  }
               }
               if( key == 0 ){
                  item.show_avatar = true;
               }
            });

            sortedMessages.forEach( ( item, key ) => {
               var _nextItem = this.messages[key + 1];
               var _prevItem = this.messages[key - 1];
               if( item.message_type == 'pin_order' && _nextItem != undefined && _prevItem != undefined ){
                  if( _nextItem.user_id != _prevItem.user_id ){
                     item.diff_type = true;
                  }
               }
            });

            return sortedMessages;
         }
      },

      filter_messengers(){
         if( this.messages.length == 0) return [];
         let sortedMessengers = this.messages.sort((a, b) => a.message_id - b.message_id );
         var _groupMessages = this.groupMessagesByUser(sortedMessengers);
         return _groupMessages;
      }

   },

   watch: {
      messages: {
         handler(data){

            data.forEach( item => {
               var _time_chat_exists = this.time_chat.some( time => time.message_id == item.message_id );
               if( ! _time_chat_exists ){
                  var _short_date = item.timestamp.split(' ')[0];
                  this.time_chat.push({ 
                     message_id: item.message_id, 
                     timestamp: item.timestamp,
                     shortdate: _short_date
                  });
               }
            });

            var _filter_time_chat = [];
            this.time_chat = this.time_chat.filter(item => {
               if (!_filter_time_chat.includes(item.shortdate)) {
                  _filter_time_chat.push(item.shortdate);
                  return true;
               } else {
                  return false;
               }
            });

         }, deep: true
      }
   },

   methods: {

      show_time_chat( message_id ){
         var _item = this.time_chat.find( item => item.message_id == message_id );
         if( _item ){
            return this.formatDateTime( _item.timestamp);
         }else{
            return false;
         }
      },
      
      is_current_user( user_id ){
         if( user_id == this.current_user_id ){
            return true;
         }
         return false;
      },

      // ALSO CHECK IS ORDER PIN YET?
      async atlantis_get_chat_order_detail( order_id ){
         var form = new FormData();
         form.append('action', 'atlantis_get_chat_order_detail');
         form.append('order_id', order_id);
         var r = await window.request(form);
         if( r != undefined){
            var res = JSON.parse( JSON.stringify(r));
            if( res.message == 'order_found'){
               this.order = res.data;
            }
         }
      },

      common_price_show_currency(price){ return window.common_price_show_currency(price); },


      get_price_discount_from_message( product ){
         if( product.product_price_discount != null && product.product_price_discount != 0 ){
            return this.common_price_show_currency( product.product_price_discount );
         }else{
            return this.common_price_show_currency( product.product_price );
         }
      },

      handleFocusIn(){
         jQuery(window).on('resize', function(){
            if( jQuery('.scaffold') ){
               jQuery('.scaffold').animate({
                  scrollTop: jQuery('.scaffold')[0].scrollHeight
               }, 0);
            }
         });
      },

      handleFocusOut(){
         
      },

      truncateUTF8String(n){ return window.truncateUTF8String(n)},

      formatDateTime(inputDateTime) {
         if( inputDateTime ){

            const months = [
               "JAN", "FEB", "MAR", "APR", "MAY", "JUN",
               "JUL", "AUG", "SEP", "OCT", "NOV", "DEC"
            ];

            const dateTime = new Date(inputDateTime);
            const month = months[dateTime.getMonth()];

            const day = dateTime.getDate();
            const year = dateTime.getFullYear();
            const hours = dateTime.getHours();
            const minutes = dateTime.getMinutes();
            const ampm = hours >= 12 ? 'pm' : 'am';
            const formattedHours = hours % 12 === 0 ? 12 : hours % 12;
            const formattedMinutes = minutes < 10 ? '0' + minutes : minutes;

            if( this.get_locale == 'en_US' ){
               return `${month} ${day}, ${year} ${formattedHours}:${formattedMinutes} ${ampm}`;
            } else if( this.get_locale == 'ko_KR' ){
               return `${year}년 ${dateTime.getMonth()+1}월 ${day}일 ${formattedHours}:${formattedMinutes} ${ampm}`;
            } else if( this.get_locale == 'vi' ){
               return `Ngày ${day} Tháng ${dateTime.getMonth()+1} Năm ${year} ${formattedHours}:${formattedMinutes} ${ampm}`;
            }else{
               return `${month} ${day}, ${year} ${formattedHours}:${formattedMinutes} ${ampm}`;
            }
         }

         
      },

      groupMessagesByUser(messages) {
         var result = [];
         var currentGroup = [];

         if( messages.length > 0 ){
            for (var i = 0; i < messages.length; i++) {
               var message       = messages[i];
               var nextMessage   = messages[i + 1]; // if possible
               var product       = null;
               var order         = null;

               if( message.timestamp != undefined ){
                  var _exists_time_chat = this.time_chat.some( item => item.message_id == message.message_id );
                  if( _exists_time_chat == false ){
                     this.time_chat.push({
                        message_id: message.message_id,
                        timestamp: message.timestamp
                     });
                  }
               }

               // timestamp format 2023-09-25 13:08:59
               // output NOV 26,2022  18:10 pm

               // IF SAVE PRODUCT
               // if (message.product_id != null) {
               //    product = {
               //       product_id: message.product_id,
               //       product_name: message.product_name,
               //       product_name_second: message.product_name_second,
               //       product_price: parseInt(message.product_price),
               //       product_price_discount:parseInt( message.product_price_discount),
               //       product_image: message.product_image
               //    };
               // }

               // IF SAVE ORDER
               if( this.order != null ){
                  order = {
                     order_id: this.order.order_id,
                     order_number_id: this.order.order_number_id,
                     order_total_price: this.order.order_total_price
                  };
               }

               if (currentGroup.length === 0 || currentGroup[currentGroup.length - 1].user_id != message.user_id) {
                  currentGroup = [];
                  result.push({
                     user_id: message.user_id != undefined ? parseInt(message.user_id) : null,
                     messages: currentGroup,
                     message_id: message.message_id != undefined ? parseInt(message.message_id) : null,
                  });
               }

               currentGroup.push({
                  user_id: parseInt(message.user_id),
                  content: message.content,
                  message_id: parseInt(message.message_id),
                  timestamp: message.timestamp,
                  message_type: message.message_type,
                  order: order
               });
            }
         }

         var uniqueDates = {};
         var filteredMessages = this.time_chat.filter(function (message) {
            var date = message.timestamp.split(' ')[0];
            if (!uniqueDates[date]) {
               uniqueDates[date] = true;
               return true;
            }
            return false;
         });

         uniqueDates = null;
         this.time_chat = filteredMessages;

         // console.log(result);

         return result;
      },

      goBack(){ window.goBack()},
      order_formatDate(t){ return window.order_formatDate(t)},
      has_discount( product ){ return window.has_discount(product); },
      common_price_after_discount(p){ return window.common_price_after_discount(p) },

      // 

      async atlantis_check_chat_pin( conversation_id, kind, id ){
         var form = new FormData();
         form.append('action', 'atlantis_check_chat_pin');
         form.append('kind', kind);
         form.append('conversation_id', conversation_id);
         form.append('id', id );

         var r = await window.request(form);

         if( r != undefined ){
            var res = JSON.parse(JSON.stringify( r));
            if( res.message == 'pin_found' ){
               this.is_order_pin = true;
            }
            if( res.message == 'pin_not_found' ){
               this.is_order_pin = false;
               await this.atlantis_get_chat_order_detail(id);
               var _currentDate = new Date();
               var year = _currentDate.getFullYear();
               var month = String(_currentDate.getMonth() + 1).padStart(2, '0');
               var day = String(_currentDate.getDate()).padStart(2, '0');
               var hours = _currentDate.getHours().toString().padStart(2, '0');
               var minutes = _currentDate.getMinutes().toString().padStart(2, '0');
               var seconds = _currentDate.getSeconds().toString().padStart(2, '0');

               var _full_date = `${year}-${month}-${day} ${hours}:${minutes}:${seconds}`;

               this.messages.unshift({
                  message_id: 999999999999,
                  order_id: this.order.order_id,
                  order_total_price: this.order.order_total_price,
                  order_number_id: this.order.order_number_id,
                  order_price_discount: this.order.order_price_discount,
                  message_type: 'pin_order',
                  user_id: this.current_user_id,
                  timestamp: _full_date,
               });

            }

         }
      },

      async atlantis_get_conversation(){
         
         var form = new FormData();
         form.append('action', 'atlantis_get_conversation');
         form.append('conversation_id', this.conversation_id);
         var r = await window.request(form);

         if( r != undefined ){
            var res = JSON.parse(JSON.stringify(r ));
            if( res.message == 'conversation_found'){
               this.conversation     = res.data;
            }
            if( res.message == 'conversation_not_found' ){
               this.loading = false;
               this.message_not_found = true;
            }
         }
      },

      async atlantis_get_messeges( get_newest = false ){
         var form = new FormData();
         form.append('action', 'atlantis_get_messeges');
         form.append('conversation_id', this.conversation_id);
         if( get_newest == true ){
            form.append( 'get_newest', 1 );
            var _last_item = this.messages.slice().find(item => item.message_id != 999999999999);
            if( _last_item ){
               form.append('last_message_id', _last_item.message_id);
            }else{
               form.append('last_message_id', 0);
            }
         }
         var r = await window.request(form);
         
         if( r != undefined ){
            var res = JSON.parse( JSON.stringify(r));
            if( res.message == 'message_found' ){
               res.data.forEach( (item, itemIndex ) => {
                  var _exists = this.messages.some( message => message.message_id == item.message_id );
                  if(!_exists){
                     this.messages.unshift( item );
                  }
               });
            }
         }
      },

      async atlantis_send_message(){

         if( this.chat_content != '' && this.chat_content.length > 0){
            this.is_send = true;

            // save pin order
            if( this.is_order_pin == false ){
               var save_pin = new FormData();
               save_pin.append('action', 'atlantis_message_save_pin_order');
               save_pin.append('conversation_id', this.conversation_id);
               save_pin.append('order_id', this.order.order_id);
               save_pin.append('order_total_price', this.order.order_total_price);
               save_pin.append('order_number_id', this.order.order_number_id);
               save_pin.append('order_price_discount', this.order.order_price_discount);

               var r = await window.request(save_pin);
               if( r != undefined ){
                  var res = JSON.parse( JSON.stringify( r));
                  if( res.message == 'save_pin_order_ok' ){
                     var _index = this.messages.findIndex( item => item.order_id == this.order.order_id );
                     if( _index != -1 ){
                        this.messages[_index].message_id = res.data;
                     }
                     this.is_order_pin = true;
                  }
               }
            }

            var form = new FormData();
            form.append('action', 'atlantis_send_message');
            form.append('conversation_id', this.conversation_id);
            form.append('chat_content', this.chat_content);
            var r = await window.request(form);

            if( r != undefined ){
               var res = JSON.parse( JSON.stringify(r));
               if( res.message == 'messenge_send_ok' ){
                  this.is_send = false;
                  this.messages.unshift({
                     message_id: res.message_id,
                     content: this.chat_content,
                     message_type: 'message',
                     timestamp: res.timestamp,
                     user_id: this.current_user_id
                  });
                  this.chat_content = '';

                  jQuery(document).ready(function($){
                     if( jQuery('.scaffold') ){
                        jQuery('.scaffold').animate({
                           scrollTop: jQuery('.scaffold')[0].scrollHeight
                        }, 0);
                     }
                  });

                  // COUNT MESSAGES

                  // var chatCollection   = collection( this.database, 'chat');
                  // var queryChat        = query( chatCollection, where('user_id', '==', parseInt( this.conversation.to_user ) ) );

                  // await getDocs(queryChat).then( async ( chatSnapshot ) =>{
                  //    if ( ! chatSnapshot.empty) {
                  //       const chatDoc = chatSnapshot.docs[0];
                  //       // Get the current count_new_messages value
                  //       const currentCount = chatDoc.data().count_new_messages || 0;
                  //       // Increment the count
                  //       const newCount = currentCount + 1;
                  //       const updateData = { count_new_messages: newCount };
                  //       try {
                  //          await updateDoc(chatDoc.ref, updateData);
                  //       } catch (error) { }
                  //    }
                  // }).catch( (error) => {});

               }
            }
         }

      },

      async atlantis_read_all_messages( conversation_id ){
         var form = new FormData();
         form.append('action', 'atlantis_read_all_messages');
         form.append('conversation_id', conversation_id);
         var r = await window.request(form);
      }

   },


   update(){ 
      // window.appbar_fixed(); 
   },

   async mounted(){
      
   },

   async created(){
      // const appFireBase = initializeApp(firebaseConfig);
      // this.database = getFirestore(appFireBase);

      if( window.appBridge != undefined ){
         window.appBridge.setEnableScroll(false);
      }

      this.loading = true;
      const urlParams         = new URLSearchParams(window.location.search);
      this.conversation_id    = urlParams.get('conversation_id');
      var order_id            = urlParams.get('order_id');

      await this.atlantis_get_conversation();

      try {
         if( this.conversation_id != undefined && this.conversation_id != null ){
            let requestPromise = await this.atlantis_read_all_messages(this.conversation_id);
            let immediatePromise = new Promise(resolve => resolve());
            await Promise.race([requestPromise, immediatePromise]);
         }
      } catch (error) {}


      if( this.messages.length == 0 ){
         await this.atlantis_get_messeges();
      }

      if( order_id != undefined && order_id != null ){
         await this.atlantis_check_chat_pin( this.conversation_id, 'order', order_id );
      }else{
         this.is_order_pin = true;
      }

      await setInterval( async () => {
         await this.atlantis_get_messeges(true);
      }, 2000);

      if( this.messages.length > 0 ){
         jQuery(document).ready(function($){
            setTimeout( () => {
               if( jQuery('.scaffold') ){
                  jQuery('.scaffold').animate({
                     scrollTop: jQuery('.scaffold')[0].scrollHeight
                  }, 0);
               }
            }, 1000);
         });
      }

      setTimeout(() => {
         this.loading = false;
         // window.appbar_fixed();
      }, 1000);



   }
}).mount('#app');
window.app = app;


</script>

