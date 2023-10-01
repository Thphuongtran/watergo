<style>
   .list-messenger{
      padding-bottom: 0px;
   }
   .scaffold{
      padding-bottom: 55px;
   }

   .btn_send_message.disabled{
      pointer-events: none;
   }
   .appbar-top{
      position: relative;
   }

   .leading-group{
      width: 72%;
      position: absolute;
      text-align: center;
      transform: translateX(-50%);
      left: 50%;
      display: flex;
      align-items: center;
      justify-content: center;
   }

   .list-messenger li{
      margin-bottom: 0;
   }
   
   .list-messenger li .message-wrapper:last-child{
      margin-bottom: 30px;
   }

   .list-messenger li .messages{
      white-space: pre-wrap;
      word-break: break-word;
   }
   .list-messenger li .gr-messenger{
      max-width: 75%;
   }
   .t-center{
      justify-content: center;
   }
   .list-messenger li.messenger-time{
      margin-bottom: 0;
   }
   .list-messenger{
      padding: 0;
      overflow-y: scroll;
   }
   .appbar-top{
      border-bottom: 1px solid #DADADA;
   }
   .message-wrapper{
      padding: 0 16px;
   }

   .message-wrapper {
      display: flex;
      flex-flow: column nowrap;
   }
   .message-wrapper .message-context {
      position: relative;
      display: flex;
      flex-flow: row wrap;
      position: relative;
      padding-left: 32px;
   }
   .message-wrapper .message-context .avatar {
      position: absolute;
      top: 0;
      left: 0;
   }
   .message-wrapper .message-context .contens {
      white-space: pre-wrap;
      word-break: break-word;
      background: #F3F3F3;
      border-radius: 5px;
      padding: 4px 10px;
      margin: 4px 0;
   }
   .is-host .message-wrapper {
      justify-content: flex-end;
   }
   .is-host .message-context {
      margin-left: auto;
      padding-right: 32px;
   }
   .is-host .message-context .contens {
      background: #616DFF;
      color: white;
      text-align: right;
   }
   .is-host .message-context .avatar {
      left: initial;
      right: 0;
   }

   .product-pin{
      margin: 0 -16px;
      margin-bottom: 16px;
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
                     <img v-if='where_app == "chat_to_store"' :src='to_user.avatar'>
                     <img v-if='where_app == "chat_to_user"' :src='from_user.avatar'>
                  </div>
                  <div class='user-info'>
                     <div v-if='where_app == "chat_to_store"' class="tt01">{{ truncateUTF8String(to_user.name ) }}</div>
                     <div v-if='where_app == "chat_to_user"' class="tt01">{{ truncateUTF8String(from_user.name ) }}</div>
                  </div>
               </div>
            </div>
         </div>

      </div>

      <div class='scaffold'>
         
         <div class='scaffold-body'>

            <ul class='list-messenger'>
               
               <!-- PIN PRODUCT  -->
               <li v-if='messages.length == 0 && product != null' class='product-pin'>
                  <div class='leading'>
                     <img :src="product.product_image.url">
                  </div>
                  <div class='contents'>
                     <div v-if='product != null' class='tt01'>{{ product.name }}</div>
                     <div v-if='product != null' class='tt02'>{{ product.name_second }}</div>
                     <div v-if='product != null' class='tt03'>
                        <div class='gr-price' :class="has_discount(product) == true ? 'has_discount' : '' ">
                           <span class='price'>
                              {{ common_price_after_discount(product ) }}
                           </span>
                           <span v-if='has_discount(product) == true' class='price-sub'>
                              {{ common_price_show_currency(product.price) }}
                           </span>
                        </div>
                     </div>
                  </div>

               </li>

               <li
                  v-if='filter_messengers.length > 0'
                  v-for='(messenger, messengerKey) in filter_messengers' :key='messengerKey'
                  :class='messenger.user_id == current_user_id ? "is-host" : "" '
               >

                  <div class='message-wrapper'
                     v-for='(messages, messagesKey) in messenger.messages' :key='messagesKey'
                  >

                     <div v-if='messages.product != null' class='product-pin'>
                        <div class='leading'>
                           <img :src="messages.product.product_image">
                        </div>
                        <div class='contents'>
                           <div class='tt01'>{{ messages.product.product_name }}</div>
                           <div class='tt02'>{{ messages.product.product_name_second }}</div>
                           <div class='tt03'>
                              <div class='gr-price' :class=" messages.product.product_price_discount != null ? 'has_discount' : '' ">
                                 <span class='price'>{{ get_price_discount_from_message(messages.product) }}</span>
                                 <span v-if='messages.product.product_price_discount != null' class='price-sub'>
                                    {{ common_price_show_currency(messages.product.product_price) }}
                                 </span>
                              </div>
                           </div>
                        </div>
                     </div>

                     <div v-if='messages.show_time == true' class='message-time'>{{ formatDateTime(messages.timestamp) }}</div>

                     <div class='message-context'>
                        <div v-if='messenger.message_id == messages.message_id' class='avatar'><img :src="get_avatar_user_chat(messenger)" ></div>
                        <div class='contens'>{{ messages.content }}</div>
                     </div>
                  </div>

               </li>



            </ul>
         </div>

      </div>
   </div>

   <div v-if='message_not_found == false' class='box-form-chat'>
      <div class='box-chat'>
         <div class='avatar'>
            <img v-if='where_app == "chat_to_store"' :src='from_user.avatar'>
            <img v-if='where_app == "chat_to_user"' :src='to_user.avatar'>
         </div>
         
         <label class='input-chat'>
            <input v-model='chat_content' type='text' placeholder='<?php echo __('Message...', 'watergo'); ?>'>
            <span @focusin='handleFocusIn' @focusout='handleFocusOut' @click='atlantis_send_message' class='icon btn_send_message' :class='{ "disabled": is_send == true }'>
               <svg width="28" height="28" viewBox="0 0 28 28" fill="none" xmlns="http://www.w3.org/2000/svg">
               <circle cx="14" cy="14" r="14" fill="#2790F9"/>
               <path d="M8.16226 20.93L22.649 14.7582C22.7988 14.6948 22.9265 14.5891 23.0162 14.4541C23.106 14.3191 23.1538 14.1609 23.1538 13.9991C23.1538 13.8374 23.106 13.6792 23.0162 13.5442C22.9265 13.4092 22.7988 13.3035 22.649 13.2401L8.16226 7.06833C8.03682 7.01395 7.89973 6.99147 7.76336 7.0029C7.627 7.01434 7.49564 7.05934 7.38114 7.13384C7.26664 7.20834 7.1726 7.30999 7.10751 7.42964C7.04242 7.54928 7.00833 7.68315 7.0083 7.81917L7 11.6229C7 12.0354 7.30717 12.3902 7.72226 12.4397L19.4528 13.9991L7.72226 15.5503C7.30717 15.6081 7 15.9629 7 16.3754L7.0083 20.1791C7.0083 20.7649 7.61434 21.1692 8.16226 20.93Z" fill="white"/>
               </svg>
            </span>

         </label>
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
         loading: false,
         loading_data: false,

         message_not_found: false,
         messages: [],
         product: null,
         product_newest: null,

         where_app: '', // chat_to_user | chat_to_store

         timestamp: '',

         conversation_id: 0,
         conversation: null,
         chat_content: '',

         current_user_id: parseInt(<?php echo $user_id; ?>),

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

         img_dummy: '<?php echo THEME_URI . '/assets/images/store-dummy.png'; ?>',

         database: null,

         pin_product: null,
         is_save_pin_product: false,

         is_send: false,

      }
   },

   computed: {

      filter_messengers(){
         if( this.messages.length == 0) return [];
         let sortedMessengers = this.messages.sort((a, b) => a.message_id - b.message_id );
         this.timestamp = this.messages[0].timestamp;
         var _groupMessages = this.groupMessagesByUser(sortedMessengers);

         // console.log( _groupMessages );

         return _groupMessages;
      }

   },

   methods: {

      get_price_discount_from_message( product ){
         if( product.product_price_discount != null ){
            return this.common_price_show_currency( product.product_price_discount );
         }else{
            return this.common_price_show_currency( product.product_price );
         }
      },

      show_datetime_from_message( current, next ){
         var _current = current.split(' ');
         var _next    = next.split(' ');

      },

      handleFocusIn(){
         if( window.appBridge != undefined ){
            window.appBridge.setEnableScroll(false);
         }
      },
      handleFocusOut(){
         if( window.appBridge != undefined ){
            window.appBridge.setEnableScroll(true);
         }
      },

      truncateUTF8String(n){ return window.truncateUTF8String(n)},

      get_avatar_user_chat( messenger ){

         if( this.where_app == 'chat_to_user' && messenger.user_id == this.current_user_id ){
            return this.to_user.avatar;
         }else if( this.where_app == 'chat_to_user' && messenger.user_id != this.current_user_id ){
            return this.from_user.avatar;
         }
         
         if( this.where_app == 'chat_to_store' && messenger.user_id == this.current_user_id){
            return this.from_user.avatar;
         }else if( this.where_app == 'chat_to_store' && messenger.user_id != this.current_user_id){
            return this.to_user.avatar;
         }
      },

      formatDateTime(inputDateTime) {
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

         return `${month} ${day}, ${year} ${formattedHours}:${formattedMinutes} ${ampm}`;
      },

      groupMessagesByUser(messages) {
         var result = [];
         var currentGroup = [];
         var show_time = null; // Initialize outside the loop

         if( messages.length > 0 ){
            for (var i = 0; i < messages.length; i++) {
               var message = messages[i];
               var nextMessage = messages[i + 1]; // if possible
               var product = null;

               if (i == 0 ) {
                  show_time = true;
               } else {
                  if (nextMessage && nextMessage !== undefined) {
                     const currentDay = message.timestamp.split(' ')[0];
                     const nextDay = nextMessage.timestamp.split(' ')[0];

                     if (currentDay !== nextDay) {
                        show_time = true;
                     }else{
                        show_time = false;
                     }
                  }
               }

               // timestamp format 2023-09-25 13:08:59
               // output NOV 26,2022  18:10 pm

               if (message.product_id != null) {
                     product = {
                        product_id: message.product_id,
                        product_name: message.product_name,
                        product_name_second: message.product_name_second,
                        product_price: message.product_price,
                        product_price_discount: message.product_price_discount,
                        product_image: message.product_image
                     };
               }

               if (currentGroup.length === 0 || currentGroup[currentGroup.length - 1].user_id != message.user_id) {
                  currentGroup = [];
                  result.push({
                     user_id: parseInt(message.user_id),
                     messages: currentGroup,
                     message_id: parseInt(message.message_id), // FIRST MESSAGE_ID
                  });
               }

               currentGroup.push({
                  user_id: parseInt(message.user_id),
                  content: message.content,
                  message_id: parseInt(message.message_id),
                  timestamp: message.timestamp,
                  product: product,
                  show_time: show_time
               });
            }
         }

         console.log(result);

         return result;
      },

      goBack(){ window.goBack()},
      order_formatDate(t){ return window.order_formatDate(t)},
      has_discount( product ){ return window.has_discount(product); },
      common_price_show_currency(p){ return window.common_price_show_currency(p) },
      common_price_after_discount(p){ return window.common_price_after_discount(p) },

      // 
      getTimeDifference(datetimeInput) {

         if (datetimeInput != undefined ) {
         
            var unpack = datetimeInput.split(' ');
            var [year, month, day] = unpack[0].split('-');
            var [hour, min, sec] = unpack[1].split(':');
            var datetime = new Date(year, month - 1, day, hour, min, sec); // Month is 0-indexed in Date constructor

            var currentTimestamp = Date.now(); // Current timestamp in milliseconds
            var messageTimestamp = datetime.getTime(); // Provided timestamp in milliseconds

            var timeDifferenceInMs = currentTimestamp - messageTimestamp;
            var timeDifferenceInSeconds = Math.floor(timeDifferenceInMs / 1000);

            var seconds = timeDifferenceInSeconds;
            var minutes = Math.floor(seconds / 60);
            var hours = Math.floor(minutes / 60);
            var days = Math.floor(hours / 24);

            if (days > 0) {
               // Check if more than 24 hours have passed
               var currentDate = new Date();
               var messageDate = new Date(datetime);

               if (
                  currentDate.getDate() !== messageDate.getDate() ||
                  currentDate.getMonth() !== messageDate.getMonth() ||
                  currentDate.getFullYear() !== messageDate.getFullYear()
               ) {
                  var months = [
                     "JAN", "FEB", "MAR", "APR", "MAY", "JUN", "JUL", "AUG", "SEP", "OCT", "NOV", "DEC"
                  ];
                  return (
                     months[messageDate.getMonth()] + " " +
                     messageDate.getDate() + ", " +
                     messageDate.getFullYear() + " " +
                     messageDate.toLocaleTimeString([], { hour: '2-digit', minute: '2-digit' })
                  );
               } else {
                  return days + (days === 1 ? " day ago" : " days ago");
               }
            } else if (hours > 0) {
               return hours + (hours === 1 ? " hour ago" : " hours ago");
            } else if (minutes > 0) {
               return minutes + (minutes === 1 ? " min ago" : " mins ago");
            } else {
               return seconds + (seconds === 1 ? " second ago" : " seconds ago");
            }
         }
         return '';
      }, 

      async atlantis_get_product_and_check( product_id ){
         var form = new FormData();
         form.append('action', 'atlantis_get_product_and_check');
         form.append('product_id', product_id);
         var r = await window.request(form);
         if( r != undefined ){
            let res = JSON.parse( JSON.stringify(r));
            if( res.message == 'product_found' ){
               this.product = res.data;
            }
         }
      },

      async atlantis_get_conversation(){
         
         var form = new FormData();
         form.append('action', 'atlantis_get_conversation');
         form.append('conversation_id', this.conversation_id);
         form.append('where_app', this.where_app);
         var r = await window.request(form);
         if( r != undefined ){
            var res = JSON.parse(JSON.stringify(r ));
            if( res.message == 'conversation_found'){
               this.conversation     = res.data;
               this.from_user.avatar = res.data.user_avatar.url;
               this.from_user.name   = res.data.user_name;
               this.to_user.avatar   = res.data.store_avatar.url;
               this.to_user.name     = res.data.store_name;
            }
            if( res.message == 'conversation_not_found' ){
               this.loading = false;
               this.message_not_found = true;
            }
         }
      },

      async atlantis_get_messeges(){
         var form = new FormData();
         form.append('action', 'atlantis_get_messeges');
         form.append('conversation_id', parseInt(this.conversation_id));
         var r = await window.request(form);
         if( r != undefined ){
            var res = JSON.parse( JSON.stringify(r));
            if( res.message == 'message_found' ){
               res.data.forEach( (item, itemIndex ) => {
                  var _exists = this.messages.some( message => message.message_id == item.message_id );
                  if(!_exists){
                     this.messages.push( item );
                  }
               });
            }
         }
      },

      async atlantis_send_message(){
         // console.log(this.product);
         if( this.chat_content != '' && this.chat_content.length > 0){
            this.is_send = true;
            var form = new FormData();
            form.append('action', 'atlantis_send_message');
            form.append('conversation_id', this.conversation_id);
            form.append('chat_content', this.chat_content);
            form.append('where_app', this.where_app);
            // save product
            if( this.is_save_pin_product == false && this.product != null  ){
               form.append('product_id', parseInt( this.product.id) );
               form.append('product_name', this.product.name);
               form.append('product_name_second', this.product.name_second );
               form.append('product_price', parseInt( this.product.price ) );
               form.append('product_image', this.product.product_image.url );
               if( this.has_discount( this.product) == true ){
                  var _discount_percent      = this.product.discount_percent;
                  var _price_after_discount  = this.product.price - ( this.product.price * ( this.product.discount_percent / 100 ) );
                  form.append('product_price_discount', parseInt(_price_after_discount) );
               }else{
                  form.append('product_price_discount', 0);
               }

            }

            var r = await window.request(form);

            if( r != undefined ){
               var res = JSON.parse( JSON.stringify(r));
               if( res.message == 'messenge_send_ok' ){
                  this.chat_content = '';
                  this.messages.push( res.data );
                  this.is_send = false;
                  this.is_save_pin_product = true;

                  // if( window.appBridge != undefined ){
                  //    window.appBridge.setEnableScroll(true);
                  // }

                  // jQuery(document).ready(function($){
                  //    $('html, body').animate({
                  //       scrollTop: $(document).height()
                  //    }, 0);
                  // });

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

      async atlantis_read_all_messages(){
         var form = new FormData();
         form.append('action', 'atlantis_read_all_messages');
         form.append('conversation_id', this.conversation_id );
         var r = await window.request(form);
         if( r != undefined ){
            var res = JSON.parse( JSON.stringify( r));
            if( res.message == 'messages_found' ){

               // var chatCollection   = collection( this.database, 'chat');
               // var queryChat        = query( chatCollection, where('user_id', '==', parseInt( <?php echo $user_id; ?> ) ) );

               // await getDocs(queryChat).then( async ( chatSnapshot ) =>{
               //       console.log(chatSnapshot);
               //    if ( ! chatSnapshot.empty ) {
               //       const chatDoc = chatSnapshot.docs[0];
               //       const updateData = { count_new_messages: 0 };
               //       try {
               //          await updateDoc(chatDoc.ref, updateData);
               //       } catch (error) { }
               //    }
               // }).catch( (error) => {});
            }
         }
      },

      async atlantis_get_message_realtime_per_second( paged ){
         var form = new FormData();
         form.append('action', 'atlantis_get_message_realtime_per_second');
         form.append('conversation_id', this.conversation_id);
         form.append('paged', paged);
         
         var placeholders = [];
         if( this.messages.length > 0 ){
            this.messages.forEach( item => {
               placeholders.push( item.message_id);
            });
            form.append('placeholders', JSON.stringify(placeholders) );
         }
         var r = await window.request(form);

         if( r != undefined ){
            var res = JSON.parse(JSON.stringify( r));
            if( res.message == 'message_found' ){
               res.data.forEach( mess => {
                  var _exists = this.messages.some( item => item.message_id == mess.message_id );
                  if( ! _exists ){
                     this.messages.push( mess );
                  }
               });

            }
         }
      },

      scrollToBottom(){
         // Calculate the height of the document
         const documentHeight = document.documentElement.scrollHeight || document.body.scrollHeight;
         
         // Set the scroll position to the document height, which is the bottom of the page
         console.log(documentHeight);
         window.scrollTo(0, documentHeight);
      },

   },


   update(){ 
      window.appbar_fixed(); 
   },

   async mounted(){
      setInterval( async () => {
         await this.atlantis_get_message_realtime_per_second(0);
      }, 1800);
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
      this.where_app          = urlParams.get('where_app');
      this.pin_product        = urlParams.get('pin_product');

      await this.atlantis_get_conversation();
      await this.atlantis_read_all_messages();
      await this.atlantis_get_product_and_check( this.pin_product );

      if( this.messages.length == 0 ){
         await this.atlantis_get_messeges();
      }

      await setInterval( async () => {
         await this.atlantis_get_messeges();
      }, 1800);

      console.log(this.messages);

      setTimeout(() => {
         this.loading = false;
         window.appbar_fixed();
      }, 1000);

      jQuery(document).ready(function($){
         // $('body').animate({
         //    scrollTop: $(document).height()
         // }, 0);
         var documentHeight = $(document).height();
         $(window).scrollTop(documentHeight);

      });

      


      

   }
}).mount('#app');
window.app = app;

</script>

