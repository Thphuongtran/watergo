<?php 

   $user_id = get_current_user_id();

   global $wpdb;
   $sql = "SELECT * from wp_usermeta where meta_key = 'user_store' AND meta_value = 1";
   $res = $wpdb->get_results($sql);
   $store_list = [];
   $store_list_id = [];

   if( !empty($res) ){
      foreach( $res as $k => $vl ){
         $store_list[] = $vl->user_id;
      }
      $store_list       = implode(',', $store_list );
      $sql_get_store_id = "SELECT id FROM wp_watergo_store WHERE user_id IN( $store_list) ";
      $res_get_store_id = $wpdb->get_results($sql_get_store_id);

      if( !empty( $res_get_store_id ) ){
         foreach( $res_get_store_id as $kk => $vll ){
            $store_list_id[] = $vll->id;
         }
      }
   }

   /*
      collection [ messengers ]
         from_user
         from_user_count: 0
         to_user
         to_user_count: 0
         to_user_hidden: false 
         pin_produdct: 0
         time_created: 

      collection [ messages ]
         user_id
         contents
         is_read: false
         timestamp: 
         messenger_id: (document_id from messengers )
   */
   

?>
<div id='app'>
   <div v-show='loading == false' class='page-chat'>

      <div class='appbar'>
         <div class='appbar-top'>
            <div class='leading'>
               <button @click='goBack' class='btn-action'>
                  <svg width="11" height="16" viewBox="0 0 11 16" fill="none" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" clip-rule="evenodd" d="M10.5309 0.375342C10.8759 0.806604 10.806 1.4359 10.3747 1.78091L2.60078 8.00004L10.3747 14.2192C10.806 14.5642 10.8759 15.1935 10.5309 15.6247C10.1859 16.056 9.55657 16.1259 9.12531 15.7809L0.375305 8.78091C0.13809 8.59113 0 8.30382 0 8.00004C0 7.69625 0.13809 7.40894 0.375305 7.21917L9.12531 0.219168C9.55657 -0.125842 10.1859 -0.0559202 10.5309 0.375342Z" fill="#252831"/></svg>
               </button>
               <p class='leading-title'>Chat</p>
            </div>
         </div>

         <div class='appbar-bottom'>
            <div class='inner'>
               <div class='box-search'>
                  <input class='input-search' type="text" v-model='inputSearch' placeholder='Search Store Name'>
                  <span class='icon-search'>
                     <svg width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                     <path fill-rule="evenodd" clip-rule="evenodd" d="M4.90688 0.60506C5.87126 0.205599 6.90488 0 7.94872 0C8.99256 0 10.0262 0.205599 10.9906 0.60506C11.9549 1.00452 12.8312 1.59002 13.5693 2.32813C14.3074 3.06623 14.8929 3.94249 15.2924 4.90688C15.6918 5.87126 15.8974 6.90488 15.8974 7.94872C15.8974 8.99256 15.6918 10.0262 15.2924 10.9906C14.9914 11.7172 14.5848 12.3938 14.0869 12.999L19.7747 18.6868C20.0751 18.9872 20.0751 19.4743 19.7747 19.7747C19.4743 20.0751 18.9872 20.0751 18.6868 19.7747L12.999 14.0869C12.3938 14.5848 11.7172 14.9914 10.9906 15.2924C10.0262 15.6918 8.99256 15.8974 7.94872 15.8974C6.90488 15.8974 5.87126 15.6918 4.90688 15.2924C3.94249 14.8929 3.06623 14.3074 2.32813 13.5693C1.59002 12.8312 1.00452 11.9549 0.60506 10.9906C0.2056 10.0262 0 8.99256 0 7.94872C0 6.90488 0.2056 5.87126 0.60506 4.90688C1.00452 3.94249 1.59002 3.06623 2.32813 2.32813C3.06623 1.59002 3.94249 1.00452 4.90688 0.60506ZM7.94872 1.53846C7.10691 1.53846 6.27335 1.70427 5.49562 2.02641C4.71789 2.34856 4.01123 2.82073 3.41598 3.41598C2.82073 4.01123 2.34856 4.71789 2.02641 5.49562C1.70427 6.27335 1.53846 7.10691 1.53846 7.94872C1.53846 8.79053 1.70427 9.62409 2.02641 10.4018C2.34856 11.1795 2.82073 11.8862 3.41598 12.4815C4.01123 13.0767 4.71789 13.5489 5.49562 13.871C6.27335 14.1932 7.10691 14.359 7.94872 14.359C8.79053 14.359 9.62409 14.1932 10.4018 13.871C11.1795 13.5489 11.8862 13.0767 12.4815 12.4815C13.0767 11.8862 13.5489 11.1795 13.871 10.4018C14.1932 9.62409 14.359 8.79053 14.359 7.94872C14.359 7.10691 14.1932 6.27335 13.871 5.49562C13.5489 4.71789 13.0767 4.01123 12.4815 3.41598C11.8862 2.82073 11.1795 2.34856 10.4018 2.02641C9.62409 1.70427 8.79053 1.53846 7.94872 1.53846Z" fill="#252831"/>
                     </svg>
                  </span>
               </div>
            </div>
         </div>
      </div>
      
      <ul class='list-chat'>
         <li 
            v-for='(cons, conversationIndex) in get_conversations' :key='conversationIndex' class='chat-item'>

            <div class='leading'>
               <img :src="cons.user_avatar">
            </div>
            <div class='contents'>
               <div class='tt01'>
                  <div class='name-chat'>{{ cons.username }}</div>
                  <div class='time'>{{ get_datetime(cons.time_created.seconds)}}</div>
               </div>
               <div class='tt02'>
                  <p class='text'>{{ cons.messages }}</p>
                  <div class='badge-is_read' v-show='cons.count_new_messages > 0'>{{ cons.count_new_messages }}</div>
               </div>
               
            </div>

         </li>
      </ul>

   </div>

   <div v-show='loading == true'>
      <div class='progress-center'>
         <div class='progress-container enabled'><progress class='progress-circular enabled' ></progress></div>
      </div>
   </div>

   <div class='beta-show-store'>
      <div class='list-store'>
         <button class='beta-button' 
            @click='chat_to_store({
               from_user: 
               to_user:
               pin_product: 
            })' 
            v-for='(store, storeIndex ) in get_store_list' :key='storeIndex'>
            Store {{ store }}
         </button>
      </div>
   </div>

</div>

<script type='module'>

import { initializeApp } from "https://www.gstatic.com/firebasejs/10.4.0/firebase-app.js";
import { getFirestore, collection, query, where, orderBy, getDocs, limit, onSnapshot } from 'https://www.gstatic.com/firebasejs/10.4.0/firebase-firestore.js';

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
         conversations: [],
         inputSearch: '',
         database: null,
         user_id: <?php echo $user_id; ?>,

         store_list: '<?php echo implode(',', $store_list_id); ?>'
      }
      
   },

   computed: {

      get_conversations(){
         var _filter = this.conversations;

         return _filter.sort((a, b) => b.time_created - a.time_created);
      },

      get_store_list(){
         return this.store_list.split(',');
      },

      filter_search(){

      }
   },

   methods: {
      goBack(){ window.goBack()},

      gotoChatMessenger(messenger_id){ 
         window.location.href = window.watergo_domain + 'chat/?chat_page=chat-messenger&messenger_id=' + messenger_id + '&appt=N';
      },

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

      shortString(str){ return window.shortString(str)},

      async get_user( user_id ){
         var form = new FormData();
         form.append('action', 'atlantis_get_user_messenger');
         form.append('user_id', user_id);
         var r = await window.request(form);
         if( r != undefined ){
            var res = JSON.parse(JSON.stringify( r));
            if( res.message == 'user_found'){
               return res.data;
            }
         }

      },

   },

   async update(){

   },

   async created(){

      this.loading = true;
      // Initialize Firebase
      const appFireBase = initializeApp(firebaseConfig);
      this.database = getFirestore(appFireBase);

      const messengers = query( 
         collection(this.database, "messengers"), 
         where("from_user", '==', this.user_id),
         where("to_user_hidden", '==', false)
      );

      await onSnapshot(messengers, async (querySnapshot) => {
         const promises = [];
         await querySnapshot.forEach( async (doc) => { 

            if( doc != undefined ){
               var _document_id = doc.id;
               var _findIndex = this.conversations.findIndex( item => item.doc_id == doc.id );
               if( _findIndex == undefined || _findIndex == -1 ){

                  promises.push(
                     this.get_user(doc.data().to_user)
                        .then( _get_user => {
                           this.conversations.push({
                              doc_id: _document_id,
                              user_avatar: _get_user.user_avatar.url,
                              username: _get_user.username,
                              messages: 'Tap to chat',
                              is_read: false,
                              count_new_messages: 0,
                              ...doc.data()
                           });
                        }
                     )
                  );

                  // QUERY GET MESSAGES
                  const messages = query(
                     collection(this.database, "messages"),
                     where("messenger_id", '==', doc.id),
                     orderBy('timestamp', 'desc'), limit(1)
                  );

                  await onSnapshot(messages, async(queryMessagesSnapshot) => {
                     await queryMessagesSnapshot.forEach(async (doc) => {
                        var _findIndex = this.conversations.findIndex(item => item.doc_id == doc.data().messenger_id);
                        if ( _findIndex !== -1) {
                           this.conversations[_findIndex].messages       = doc.data().contents;
                           this.conversations[_findIndex].time_created   = doc.data().timestamp;
                        }
                     });
                  });

               }
            }

         });

         await Promise.all(promises);
         setTimeout(() => {}, 500);
      });

      this.loading = false;

   }

}).mount('#app');
window.app = app;


</script>

<style>
   #btn-testing{
      background: #2790F9;
      color: white;
   }
   .tt02 {
      position: relative;
   }
   .tt02 .badge-is_read {
      z-index: 8;
      position: absolute;
      right: 0;
      top: 4px;
      min-width: 15px;
      height: 15px;
      line-height: 15px;
      color: white;
      font-weight: 700;
      font-size: 10px;
      background: #FF1E1E;
      text-align: center;
      border-radius: 25px;
      padding: 0 4px;
   }

   .tt02 .text{
      word-break: break-word;
      padding-right: 30px;
   }

   /*  */

   .beta-show-store{
      margin-top: 15px;
      padding: 0 15px;
   }

   .beta-button{
      background: #2790F9;
      color: white;
      font-size: 14px;
      outline: none;
      border: none;
      margin-right: 5px;
      margin-bottom: 5px;
      padding: 0 4px;
   }

</style>
