<div id='app'>
   <div v-show='loading == false && account != null' class='page-chat'>

      <div class='appbar'>
         <div class='appbar-top'>
            <div class='leading'>
               <button @click='goBack' class='btn-action'>
                  <svg width="20" height="16" viewBox="0 0 20 16" fill="none" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" clip-rule="evenodd" d="M0 8C0 7.44772 0.447715 7 1 7H18.5C19.0523 7 19.5 7.44772 19.5 8C19.5 8.55228 19.0523 9 18.5 9H1C0.447715 9 0 8.55228 0 8Z" fill="#252831"/><path fill-rule="evenodd" clip-rule="evenodd" d="M10.5309 0.375342C10.8759 0.806604 10.806 1.4359 10.3747 1.78091L2.60078 8.00004L10.3747 14.2192C10.806 14.5642 10.8759 15.1935 10.5309 15.6247C10.1859 16.056 9.55657 16.1259 9.12531 15.7809L0.375305 8.78091C0.13809 8.59113 0 8.30382 0 8.00004C0 7.69625 0.13809 7.40894 0.375305 7.21917L9.12531 0.219168C9.55657 -0.125842 10.1859 -0.0559202 10.5309 0.375342Z" fill="#252831"/></svg>
               </button>
               <div v-if='account != null' class='leading-group'>
                  <div class='leading-avatar'>
                     <img :src="get_leading_avatar">
                  </div>
                  <div v-if='host_chat == "store" && account != null ' class='user-info'>
                     <div class="tt01">{{ account.user_account.first_name }}</div>
                     <div class="tt02">Active</div>
                  </div>
                  <div v-if='host_chat == "user" && account != null' class='user-info'>
                     <div class="tt01">{{ account.store_account.store_name }}</div>
                     <div class="tt02">Active</div>
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
                  <div class='tt01'>{{ product.name }}</div>
                  <div class='tt02'>{{ product.name_second }}</div>
                  <div class='tt03'>
                     <div class='gr-price' :class="has_discount(product) == true ? 'has_discount' : '' ">
                        <span class='price'>
                           {{ common_price_show_currency(product.price) }}
                        </span>
                        <span v-if='has_discount(product) == true' class='price-sub'>
                           {{ common_price_after_discount(product ) }}
                        </span>
                     </div>
                  </div>
               </div>
            </div>
         </div>

      </div>

      <div class='messenger-time'><span>{{ getCurrentDateTime }}</span></div>

      <ul class='list-messenger'>
         <li
            v-if='messengers.length > 0'
            v-for='(messenger, messengerKey) in filter_messengers' :key='messengerKey'
            :class='get_class_layout_for_message(messenger)'
         >
            <div class='avatar'>
               <img :src="get_avatar_user_chat(messenger)" >
            </div>

            <div class='gr-messenger'>
               <div class='messages'
                  v-for='(messages, messagesKey) in messenger.messages' :key='messagesKey'
               >
               {{ messages.content }}
               </div>
            </div>

         </li>
      </ul>

   </div>

   <div class='box-form-chat'>
      <div class='box-chat'>
         <div v-if='host_chat == "store" && account != null ' class='avatar'><img :src="account.store_account.image.url"></div>
         <div v-if='host_chat == "user" && account != null ' class='avatar'><img :src="account.user_account.image.url"></div>
         
         <label class='input-chat'>
            <input v-model='chat_content' type='text' placeholder='Message...'>
            <span @click='btn_send_message' class='icon'>
               <svg width="28" height="28" viewBox="0 0 28 28" fill="none" xmlns="http://www.w3.org/2000/svg">
               <circle cx="14" cy="14" r="14" fill="#2790F9"/>
               <path d="M8.16226 20.93L22.649 14.7582C22.7988 14.6948 22.9265 14.5891 23.0162 14.4541C23.106 14.3191 23.1538 14.1609 23.1538 13.9991C23.1538 13.8374 23.106 13.6792 23.0162 13.5442C22.9265 13.4092 22.7988 13.3035 22.649 13.2401L8.16226 7.06833C8.03682 7.01395 7.89973 6.99147 7.76336 7.0029C7.627 7.01434 7.49564 7.05934 7.38114 7.13384C7.26664 7.20834 7.1726 7.30999 7.10751 7.42964C7.04242 7.54928 7.00833 7.68315 7.0083 7.81917L7 11.6229C7 12.0354 7.30717 12.3902 7.72226 12.4397L19.4528 13.9991L7.72226 15.5503C7.30717 15.6081 7 15.9629 7 16.3754L7.0083 20.1791C7.0083 20.7649 7.61434 21.1692 8.16226 20.93Z" fill="white"/>
               </svg>
            </span>

         </label>
      </div>
   </div>

   <div v-show='loading == true'>
      <div class='progress-center'>
         <div class='progress-container enabled'><progress class='progress-circular enabled' ></progress></div>
      </div>
   </div>
</div>

<script type='module'>

var { createApp } = Vue;

createApp({
   data (){
      
      return {
         loading: false,

         product_id: null,
         store_id: null,
         user_id: null,
         conversation_id: 0,

         account: null,
         host_chat: '',

         messengers: [],
         
         product: null,

         chat_content: '',
         list_id_messenger: [],

      }
   },
   methods: {
      

      goBack(){ window.goBack();},
      order_formatDate(t){ return window.order_formatDate(t)},
      has_discount( product ){ return window.has_discount(product); },
      common_price_show_currency(p){ return window.common_price_show_currency(p) },
      common_price_after_discount(p){ return window.common_price_after_discount(p) },

      get_avatar_user_chat( messenger ){
         if( messenger.user_role == 'store' ){
            return this.account.store_account.image.url;
         }
         if( messenger.user_role == 'store' ){
            return this.account.store_account.image.url;
         }else {
            return this.account.user_account.image.url;
         }
         if( messenger.user_role == 'user' ){
            return this.account.user_account.image.url;
         }else {
            return this.account.store_account.image.url;
         }
      },

      get_class_layout_for_message( messenger ){
         if( messenger.user_role == this.host_chat ){ return 'is-host'; }
      },

      handleScroll() {
         (function($){
            $(document).ready(function(){
               $('html, body').animate({scrollTop: $(document).height()}, 800);
            });
         })(jQuery);
      },

      async get_new_messenger_per_second(){
         var list_id_messenger = [];
         this.messengers.forEach( message => {
            list_id_messenger.push( message.message_id );
         });

         var form = new FormData();
         form.append('action', 'atlantis_get_newest_messages');
         form.append('conversation_id', this.conversation_id);
         form.append('list_id_messenger', JSON.stringify(list_id_messenger ));
         var r = await window.request(form);
         if(r != undefined){
            var res = JSON.parse( JSON.stringify( r) );
            if( res.message == 'newest_messenger_ok' ){
               if( res.data != undefined ){
                  res.data.forEach( item => {
                     this.messengers.push(item );
                  });

               }
            }
         }
      },

      async btn_send_message(){

         if( this.chat_content.length > 0 ){
            var form = new FormData();
            form.append('action', 'atlantis_send_messenger');
            form.append('conversation_id', this.conversation_id);
            form.append('chat_content', this.chat_content);
            var r = await window.request(form);
            if( r != undefined){
               var res = JSON.parse( JSON.stringify(r));
               if( res.message == 'messenge_send_ok' ){
                  this.messengers.push( res.data );
                  this.handleScroll();
               }
            }
            this.chat_content = '';
         }

      },

      async get_messages( ){
         var form = new FormData();
         form.append('action', 'atlantis_get_messages');
         form.append('conversation_id', this.conversation_id);
         var r = await window.request(form);

         if( r != undefined ){
            var res = JSON.parse( JSON.stringify( r));
            if(res.message == 'message_found'){
               this.messengers.push( ...res.data ); 
            }
         }

      },

      get_username( user ){
         if( user.first_name == undefined ) return user.display_name;
         return user.first_name;
      }, 

      async get_product(){
         var form = new FormData();
         form.append('action', 'atlantis_find_product');
         form.append('product_id', this.product_id);
         var r = await window.request(form);
         if( r != undefined ){
            let res = JSON.parse( JSON.stringify(r));
            if( res.message == 'product_found' ){
               this.product = res.data;
            }
         }

      },

      async get_product_newest(){
         var form = new FormData();
         form.append('action', 'atlantis_find_product_newest');
         form.append('store_id', this.store_id);
         var r = await window.request(form);
         if( r != undefined ){
            let res = JSON.parse( JSON.stringify(r));
            if( res.message == 'product_found' ){
               this.product= res.data;
            }
         }
      },

      async get_both_user(user_id, store_id){
         var form = new FormData();
         form.append('action', 'atlantis_get_both_user_messenger');
         form.append('user_id', user_id);
         form.append('store_id', store_id);
         var r = await window.request(form);
         if( r != undefined ){
            var res = JSON.parse( JSON.stringify(r));
            if( res.message == 'user_ok'){
               this.account = res.data;
            }
         }
      },

      async atlantis_load_conversations_id(user_id, store_id){
         var form = new FormData();
         form.append('action', 'atlantis_load_conversations_id');
         form.append('user_id', parseInt(user_id));
         form.append('store_id', parseInt(store_id));
         var r = await window.request(form);
         if( r != undefined ){
            var res = JSON.parse( JSON.stringify(r));
            if( res.message == 'conversation_found' ){
               this.conversation_id = res.data;
            }
         }
      },

      groupMessagesByUser(messages) {
         var result = [];
         var currentGroup = [];

         for (var i = 0; i < messages.length; i++) {
            var message = messages[i];

            if (  currentGroup.length === 0 || currentGroup[currentGroup.length - 1].user_role != message.user_role ) {
               currentGroup = [];
               result.push({
                  user_role: message.user_role,
                  user_id: parseInt( message.user_id ),
                  messages: currentGroup
               });
            }

            currentGroup.push({
               user_role: message.user_role,
               conversation_id: message.conversation_id,
               content: message.content,
               message_id: message.message_id,
               user_id: message.user_id,
               timestamp: message.timestamp
            });
         }
         return result;
      }
   },

   computed: {
      getCurrentDateTime(){ return window.getCurrentDateTime(); },

      get_leading_avatar(){
         if( this.account != null ){
            if( this.host_chat == 'user' ){
               return this.account.store_account.image.url;
            }
            if( this.host_chat == 'store' ){
               return this.account.user_account.image.url;
            }
         }
      },

      filter_messengers(){
         if( this.messengers.length == 0) return [];
         let sortedMessengers = this.messengers.sort((a, b) => a.message_id - b.message_id );
         var _groupMessages = this.groupMessagesByUser(sortedMessengers);
         return _groupMessages;
      }

   },

   async created(){

      this.loading = true;
      const urlParams   = new URLSearchParams(window.location.search);
      this.conversation_id  = urlParams.get('conversation_id');
      this.product_id       = urlParams.get('product_id');
      
      var store_id         = urlParams.get('store_id');
      var user_id          = urlParams.get('user_id');
      var host_chat        = urlParams.get('host_chat');
      
      this.store_id = store_id;
      this.user_id = user_id;
      this.host_chat = host_chat;

      // GET USER ACCOUNT
      await this.get_both_user(user_id, store_id);

      // GET CONVERSATION ID 
      if(this.conversation_id == undefined || this.conversation_id == null ){
         await this.atlantis_load_conversations_id(user_id, store_id);
      }

      // GET PRODUCT
      if( this.product_id != null ){
         await this.get_product();
      }else{
         await this.get_product_newest();
      }

      // // GET MESSAGES
      await this.get_messages( [0] );

      window.appbar_fixed();

      (function($){
         $(document).ready(function(){
            $('html, body').animate({
               scrollTop: $(document).height()
            }, 800);
         });
      })(jQuery);


      setTimeout( () => {  }, 1000);
      setInterval( async () => {
         await this.get_new_messenger_per_second();
      }, 5000);

      console.log(this.product)

      
      this.loading = false; 



   }
}).mount('#app');
</script>