<div id='app'>

   <div v-show='loading == false ' class='page-store-profile'>
      <div class='appbar'>
         <div class='appbar-top'>
            <div class='leading'>
               <span class='leading-title'><?php echo __('Store', 'watergo'); ?></span>
            </div>
            <div class='action'>

               <!-- <div @click='gotoChat' class='btn-badge ml10'>
                  <svg width="23" height="20" viewBox="0 0 23 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                  <path fill-rule="evenodd" clip-rule="evenodd" d="M15.6817 0H3.40384C2.58977 0 1.80904 0.334446 1.2334 0.929764C0.657759 1.52508 0.33437 2.33251 0.33437 3.17441V9.52324C0.33437 9.94011 0.413763 10.3529 0.568018 10.738C0.722275 11.1232 0.94837 11.4731 1.2334 11.7679C1.51842 12.0627 1.8568 12.2965 2.22921 12.456C2.60161 12.6155 3.00076 12.6977 3.40384 12.6977H5.24553H9.79695H15.6817C16.4958 12.6977 17.2766 12.3632 17.8522 11.7679C18.4278 11.1726 18.7512 10.3652 18.7512 9.52324V3.17441C18.7512 2.33251 18.4278 1.52508 17.8522 0.929764C17.2766 0.334446 16.4958 0 15.6817 0ZM15.6817 1.26977H3.40384C2.9154 1.26977 2.44696 1.47043 2.10158 1.82762C1.75619 2.18482 1.56216 2.66927 1.56216 3.17441V9.52324C1.56216 10.0284 1.75619 10.5128 2.10158 10.87C2.44696 11.2272 2.9154 11.4279 3.40384 11.4279H15.6817C16.1702 11.4279 16.6386 11.2272 16.984 10.87C17.3294 10.5128 17.5234 10.0284 17.5234 9.52324V3.17441C17.5234 2.66927 17.3294 2.18482 16.984 1.82762C16.6386 1.47043 16.1702 1.26977 15.6817 1.26977Z" fill="#2790F9"/>
                  <path d="M3.40384 1.26977H15.6817C16.1702 1.26977 16.6386 1.47043 16.984 1.82762C17.3294 2.18482 17.5234 2.66927 17.5234 3.17441V9.52324C17.5234 10.0284 17.3294 10.5128 16.984 10.87C16.6386 11.2272 16.1702 11.4279 15.6817 11.4279H3.40384C2.9154 11.4279 2.44696 11.2272 2.10158 10.87C1.75619 10.5128 1.56216 10.0284 1.56216 9.52324V3.17441C1.56216 2.66927 1.75619 2.18482 2.10158 1.82762C2.44696 1.47043 2.9154 1.26977 3.40384 1.26977Z" fill="white"/>
                  <path fill-rule="evenodd" clip-rule="evenodd" d="M19.0577 4.76165H6.7798C6.29136 4.76165 5.82292 4.96232 5.47753 5.31951C5.13215 5.6767 4.93812 6.16115 4.93812 6.6663V13.0151C4.93812 13.5203 5.13215 14.0047 5.47753 14.3619C5.82292 14.7191 6.29136 14.9198 6.7798 14.9198H12.9188C12.9994 14.9196 13.0793 14.9359 13.1539 14.9677C13.2285 14.9995 13.2963 15.0462 13.3534 15.1052L15.9882 17.8313V15.5547C15.9882 15.3863 16.0529 15.2248 16.168 15.1057C16.2832 14.9867 16.4393 14.9198 16.6021 14.9198H19.0577C19.5461 14.9198 20.0146 14.7191 20.36 14.3619C20.7054 14.0047 20.8994 13.5203 20.8994 13.0151V6.6663C20.8994 6.16115 20.7054 5.6767 20.36 5.31951C20.0146 4.96232 19.5461 4.76165 19.0577 4.76165ZM6.7798 3.49188H19.0577C19.8718 3.49188 20.6525 3.82633 21.2282 4.42165C21.8038 5.01696 22.1272 5.82439 22.1272 6.6663V13.0151C22.1272 13.432 22.0478 13.8448 21.8935 14.2299C21.7393 14.6151 21.5132 14.965 21.2282 15.2598C20.9431 15.5545 20.6047 15.7884 20.2323 15.9479C19.8599 16.1074 19.4608 16.1895 19.0577 16.1895H17.216V19.364C17.2162 19.4897 17.1804 19.6127 17.1129 19.7173C17.0455 19.8219 16.9495 19.9034 16.8372 19.9516C16.7249 19.9997 16.6013 20.0123 16.4821 19.9877C16.3628 19.9631 16.2533 19.9025 16.1675 19.8135L12.6646 16.1895H6.7798C5.96573 16.1895 5.18499 15.8551 4.60936 15.2598C4.03372 14.6645 3.71033 13.857 3.71033 13.0151V6.6663C3.71033 5.82439 4.03372 5.01696 4.60936 4.42165C5.18499 3.82633 5.96573 3.49188 6.7798 3.49188Z" fill="#2790F9"/>
                  <path d="M19.0577 4.76165H6.7798C6.29136 4.76165 5.82292 4.96232 5.47753 5.31951C5.13215 5.6767 4.93812 6.16115 4.93812 6.6663V13.0151C4.93812 13.5203 5.13215 14.0047 5.47753 14.3619C5.82292 14.7191 6.29136 14.9198 6.7798 14.9198H12.9188C12.9994 14.9196 13.0793 14.9359 13.1539 14.9677C13.2285 14.9995 13.2963 15.0462 13.3534 15.1052L15.9882 17.8313V15.5547C15.9882 15.3863 16.0529 15.2248 16.168 15.1057C16.2832 14.9867 16.4393 14.9198 16.6021 14.9198H19.0577C19.5461 14.9198 20.0146 14.7191 20.36 14.3619C20.7054 14.0047 20.8994 13.5203 20.8994 13.0151V6.6663C20.8994 6.16115 20.7054 5.6767 20.36 5.31951C20.0146 4.96232 19.5461 4.76165 19.0577 4.76165Z" fill="white"/>
                  <path d="M10.4639 9.32349C10.4639 9.70494 10.1546 10.0142 9.77319 10.0142C9.39174 10.0142 9.08252 9.70494 9.08252 9.32349C9.08252 8.94204 9.39174 8.63282 9.77319 8.63282C10.1546 8.63282 10.4639 8.94204 10.4639 9.32349Z" fill="#2790F9"/>
                  <path d="M13.5947 9.30974C13.5947 9.69118 13.2855 10.0004 12.904 10.0004C12.5226 10.0004 12.2133 9.69118 12.2133 9.30974C12.2133 8.92829 12.5226 8.61906 12.904 8.61906C13.2855 8.61906 13.5947 8.92829 13.5947 9.30974Z" fill="#2790F9"/>
                  <path d="M16.7027 9.3235C16.7027 9.70494 16.3935 10.0142 16.012 10.0142C15.6306 10.0142 15.3214 9.70494 15.3214 9.3235C15.3214 8.94205 15.6306 8.63282 16.012 8.63282C16.3935 8.63282 16.7027 8.94205 16.7027 9.3235Z" fill="#2790F9"/>
                  </svg>
                  <span v-if='message_count > 0' class='badge'>{{ message_count }}</span>
               </div> -->

               <div @click='gotoNotificationIndex' class='btn-badge ml10'>
                  <svg width="19" height="20" viewBox="0 0 19 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                  <path d="M16.1176 14.6055C16.577 15.3164 17.1289 15.9629 17.7587 16.5281V17.2473H0.826953V16.5278C1.44914 15.9599 1.99356 15.3122 2.44603 14.6015L2.46376 14.5737L2.47879 14.5443C2.99231 13.5401 3.30009 12.4435 3.38408 11.3188L3.38602 11.2928V11.2667L3.38602 8.22777L3.38602 8.22636C3.38312 6.7874 3.9018 5.39615 4.84599 4.31028C5.79017 3.22441 7.09589 2.51751 8.5213 2.32051L9.12547 2.23701V1.6271V0.821239C9.12547 0.789084 9.13824 0.758246 9.16098 0.735511C9.18371 0.712773 9.21455 0.7 9.24671 0.7C9.27886 0.7 9.3097 0.712773 9.33243 0.735509C9.35517 0.758248 9.36795 0.789086 9.36795 0.821239V1.6148V2.23105L9.97923 2.30915C11.4175 2.49291 12.7392 3.19556 13.696 4.28509C14.6527 5.37462 15.1787 6.77603 15.1751 8.22601V8.22777V11.2667V11.2928L15.177 11.3188C15.261 12.4435 15.5688 13.5401 16.0823 14.5443L16.0984 14.5758L16.1176 14.6055Z" stroke="#2790F9" stroke-width="1.4"/>
                  <path d="M7.67493 18.5933C7.72887 18.9832 7.92209 19.3404 8.21891 19.599C8.51572 19.8576 8.89607 20 9.28972 20C9.68337 20 10.0637 19.8576 10.3605 19.599C10.6574 19.3404 10.8506 18.9832 10.9045 18.5933H7.67493Z" fill="#2790F9"/>
                  </svg>
                  <span class='badge badge-notification' :class="notification_count > 0 ? 'enable' : '' ">{{notification_count}}</span>
               </div>

            </div>
         </div>
      </div>

      <div class='inner'>
         <div class='profile-user'>
            <img class='avatar-circle' width='80' height='80' :src="store.store_image.url">

            <div class='user-prefs'>
               <div class='username'>{{ store.name }}</div>
               <button @click='gotoStoreDetail(store.id)' class='btn-text arrow-right'>
                  <?php 
                     if( get_locale() == 'vi' ){
                        echo 'Xem Thông Tin';
                     }else{
                        echo 'View Store';
                     }
                  ?>
                  <svg width="7" height="12" viewBox="0 0 7 12" fill="none" xmlns="http://www.w3.org/2000/svg">
                  <path d="M1 11L6 6L1 1" stroke="#2790F9" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                  </svg>
               </button>
            </div>

         </div>

         <div class='list-tile single last-item-effect'>

            <button class='tile-items no-arrow tile-item-2col'>
               <div class='leading-col'>
                  <svg width="28" height="28" viewBox="0 0 28 28" fill="none" xmlns="http://www.w3.org/2000/svg">
                  <circle cx="14" cy="14" r="14" fill="#2790F9"/>
                  <path d="M19.6749 17.7604C20.0378 18.322 20.4716 18.8343 20.9654 19.2846V19.6578H7.7V19.2837C8.18789 18.8312 8.61585 18.3179 8.97336 17.7564L8.99109 17.7286L9.00612 17.6992C9.42542 16.8792 9.67673 15.9838 9.74531 15.0655L9.74725 15.0394V15.0133L9.74726 12.5822L9.74725 12.5808C9.745 11.4635 10.1477 10.3832 10.8809 9.54009C11.614 8.69694 12.6279 8.14806 13.7346 7.99509L14.3106 7.91548L14.8641 7.98619C15.9809 8.12888 17.0071 8.67447 17.75 9.52045C18.4929 10.3664 18.9013 11.4546 18.8985 12.5805V12.5822V15.0133V15.0394L18.9004 15.0655C18.969 15.9838 19.2203 16.8792 19.6396 17.6992L19.6557 17.7307L19.6749 17.7604Z" fill="white" stroke="white" stroke-width="1.4"/>
                  <path d="M13.0385 20.8745C13.0816 21.1865 13.2362 21.4723 13.4736 21.6791C13.7111 21.886 14.0154 21.9999 14.3303 21.9999C14.6452 21.9999 14.9495 21.886 15.1869 21.6791C15.4244 21.4723 15.579 21.1865 15.6221 20.8745H13.0385Z" fill="white"/>
                  </svg>
                  <span class='title'><?php echo __('Notification', 'watergo'); ?></span>
               </div>
               <label @click='updateUserNotification' class="toggle-switch">
                  <input type="checkbox" v-model='user_notification' >
                  <span class="slider"></span>
               </label>
            </button>

            <button @click='gotoSupport' class='tile-items'>
               <svg width="28" height="28" viewBox="0 0 28 28" fill="none" xmlns="http://www.w3.org/2000/svg">
               <circle cx="14" cy="14" r="14" fill="#2790F9"/>
               <path d="M19.2 11.6C20.744 11.6 22 10.344 22 8.8C22 7.256 20.744 6 19.2 6C17.656 6 16.4 7.256 16.4 8.8C16.4 10.344 17.656 11.6 19.2 11.6ZM19.2 13.2C19.6 13.2 20 13.144 20.4 13.032V18C20.4 20.208 18.608 22 16.4 22H10C7.792 22 6 20.208 6 18V11.6C6 9.392 7.792 7.6 10 7.6H14.968C14.782 8.25441 14.7503 8.94305 14.8755 9.61176C15.0008 10.2805 15.2794 10.911 15.6896 11.4538C16.0998 11.9965 16.6303 12.4367 17.2394 12.7398C17.8485 13.0428 18.5197 13.2003 19.2 13.2Z" fill="white"/>
               </svg>
               <span class='title'><?php echo __('Support', 'watergo'); ?></span>
            </button>

            <button @click='gotoPageStoreAdverstising' class='tile-items'>
               <svg width="28" height="28" viewBox="0 0 28 28" fill="none" xmlns="http://www.w3.org/2000/svg">
               <circle cx="14" cy="14" r="14" fill="#2790F9"/>
               <path d="M21.7882 17.5057C21.7878 18.5545 21.4293 19.5718 20.772 20.3891C20.1146 21.2064 19.1979 21.7747 18.1735 22L17.6842 20.5321C18.1323 20.4583 18.5584 20.286 18.9319 20.0276C19.3054 19.7693 19.6169 19.4313 19.844 19.0381H17.9534C17.5466 19.0381 17.1565 18.8765 16.8688 18.5888C16.5812 18.3011 16.4195 17.911 16.4195 17.5042V14.4364C16.4195 14.0296 16.5812 13.6394 16.8688 13.3518C17.1565 13.0641 17.5466 12.9025 17.9534 12.9025H20.2067C20.0196 11.4199 19.2978 10.0566 18.1769 9.0683C17.0561 8.08001 15.6131 7.53471 14.1187 7.53471C12.6244 7.53471 11.1814 8.08001 10.0605 9.0683C8.9396 10.0566 8.21786 11.4199 8.03071 12.9025H10.284C10.6908 12.9025 11.081 13.0641 11.3686 13.3518C11.6563 13.6394 11.8179 14.0296 11.8179 14.4364V17.5042C11.8179 17.911 11.6563 18.3011 11.3686 18.5888C11.081 18.8765 10.6908 19.0381 10.284 19.0381H7.98316C7.57634 19.0381 7.18619 18.8765 6.89853 18.5888C6.61087 18.3011 6.44927 17.911 6.44927 17.5042V13.6694C6.44927 9.43361 9.88288 6 14.1187 6C18.3545 6 21.7882 9.43361 21.7882 13.6694V17.5057Z" fill="white"/>
               </svg>

               <span class='title'><?php echo __('Advertising inquery', 'watergo'); ?></span>
            </button>

            <button @click='gotoPageStoreSettings' class='tile-items'>
               <svg width="28" height="28" viewBox="0 0 28 28" fill="none" xmlns="http://www.w3.org/2000/svg">
               <circle cx="14" cy="14" r="14" fill="#2790F9"/>
               <path d="M15.5009 22H12.4996C12.3115 22 12.1291 21.9377 11.9826 21.8233C11.836 21.709 11.7342 21.5494 11.694 21.3712L11.3584 19.864C10.9107 19.6737 10.4862 19.4357 10.0927 19.1544L8.57799 19.6224C8.3987 19.6779 8.20525 19.6722 8.02976 19.6062C7.85427 19.5403 7.7073 19.4181 7.61326 19.26L6.10927 16.7392C6.01622 16.5809 5.98129 16.3967 6.01019 16.2166C6.0391 16.0365 6.13014 15.8713 6.26841 15.748L7.4434 14.708C7.38997 14.2369 7.38997 13.7615 7.4434 13.2904L6.26841 12.2528C6.12994 12.1294 6.03878 11.9641 6.00987 11.7838C5.98096 11.6036 6.016 11.4192 6.10927 11.2608L7.60996 8.7384C7.704 8.58025 7.85097 8.45807 8.02646 8.39215C8.20195 8.32623 8.3954 8.32053 8.57469 8.376L10.0894 8.844C10.2906 8.7 10.5 8.5656 10.7161 8.444C10.9247 8.3304 11.139 8.2272 11.3584 8.1352L11.6948 6.6296C11.7348 6.45136 11.8365 6.29175 11.9829 6.17724C12.1292 6.06273 12.3115 6.00019 12.4996 6H15.5009C15.689 6.00019 15.8713 6.06273 16.0177 6.17724C16.164 6.29175 16.2657 6.45136 16.3057 6.6296L16.6454 8.136C17.0925 8.32741 17.5169 8.56534 17.9111 8.8456L19.4266 8.3776C19.6058 8.32233 19.7991 8.32814 19.9744 8.39405C20.1497 8.45996 20.2965 8.58202 20.3905 8.74L21.8912 11.2624C22.0825 11.588 22.0166 12 21.7321 12.2536L20.5571 13.2936C20.6105 13.7647 20.6105 14.2401 20.5571 14.7112L21.7321 15.7512C22.0166 16.0056 22.0825 16.4168 21.8912 16.7424L20.3905 19.2648C20.2965 19.4229 20.1495 19.5451 19.974 19.6111C19.7986 19.677 19.6051 19.6827 19.4258 19.6272L17.9111 19.1592C17.5179 19.4403 17.0937 19.678 16.6462 19.868L16.3057 21.3712C16.2655 21.5493 16.1638 21.7087 16.0174 21.8231C15.8711 21.9374 15.6889 21.9998 15.5009 22ZM13.997 10.8C13.1222 10.8 12.2833 11.1371 11.6648 11.7373C11.0462 12.3374 10.6987 13.1513 10.6987 14C10.6987 14.8487 11.0462 15.6626 11.6648 16.2627C12.2833 16.8629 13.1222 17.2 13.997 17.2C14.8717 17.2 15.7106 16.8629 16.3291 16.2627C16.9477 15.6626 17.2952 14.8487 17.2952 14C17.2952 13.1513 16.9477 12.3374 16.3291 11.7373C15.7106 11.1371 14.8717 10.8 13.997 10.8Z" fill="white"/>
               </svg>
               <span class='title'><?php echo __('Settings', 'watergo'); ?></span>
            </button>

         </div>

         
         
      </div>

   </div>

   <div v-show='loading == true'>
      <div class='progress-center'>
         <div class='progress-container enabled'><progress class='progress-circular enabled' ></progress></div>
      </div>
   </div>

</div>

<script>
var is_busy = false;

var app = Vue.createApp({
   data (){
      return {
         loading: false,
         store: null,
         user_notification: false,
         message_count: 0,
         notification_count: 0,

      }
   },

   methods: {
      gotoNotificationIndex(){ window.gotoNotificationIndex()},
      gotoPageStoreEdit(){ window.gotoPageStoreEdit()},
      gotoStoreDetail(store_id){ window.gotoStoreDetail(store_id); },
      
      gotoPageStoreSettings(){ window.gotoPageStoreSettings()},
      gotoSupport(){ window.gotoSupport()},
      gotoCart(){ window.gotoCart()},
      gotoChat(){ window.gotoChat()},
      gotoPageStoreAdverstising(){ window.gotoPageStoreAdverstising()},

      // UPDATE USER NOTIFICATION
      async updateUserNotification(){
         if(is_busy == true) return; is_busy = true;
         this.loading = true;
         this.user_notification = !this.user_notification;
         var _notification = this.user_notification == true ? 1 : 0;
         var form = new FormData(); 
         form.append('action', 'atlantis_user_notification');
         form.append('notification', _notification );
         var r = await window.request(form);
         if( r != undefined ){
            var res = JSON.parse( JSON.stringify( r ));
            if( res.message == 'update_notification_ok' ){
               if( res.data == 0 ){
                  this.user_notification = false;
               }else{
                  this.user_notification = true;
               }
            }
         }
         this.loading = false;
         is_busy = false;
      },

      async get_messages_count(){
         var form_message_count = new FormData();
         form_message_count.append('action', 'atlantis_count_messages');
         var _atlantis_message = await window.request(form_message_count);
         if( _atlantis_message != undefined ){
            let res = JSON.parse( JSON.stringify( _atlantis_message));
            if( res.message == 'message_count_found' ){
               this.message_count = parseInt(res.data);
            }
         }
      },

      async get_store(){
         var form = new FormData();
         form.append('action', 'atlantis_get_current_store_profile')
         var r = await window.request(form);
         if( r != undefined ){
            if( r.message == 'get_store_profile_ok'){
               this.store = r.data;
            }
         }
      },

      async check_user_notification(){
         var form = new FormData();
         form.append('action', 'atlantis_get_user_notification');
         var r = await window.request(form);
         
         if(r != undefined){
            if( r.message == 'get_notification_ok' ){
               if( r.data == 0 ){
                  this.user_notification = false;
               }else{
                  this.user_notification = true;
               }
            }
         }
         
      },

      async get_notification_count(){
         var form = new FormData();
         form.append('action', 'atlantis_notification_count');
         var r = await window.request(form);
         if( r != undefined ){
            var res = JSON.parse( JSON.stringify(r));
            if(res.message == 'notification_found' ){
               this.notification_count = res.data;
            }
         }
      },

   },

   async created(){
      this.loading = true;
      await this.get_store();
      await this.check_user_notification();
      // await this.get_messages_count();
      this.get_notification_count();
      this.loading = false;
      window.appbar_fixed();

   },

}).mount('#app');
window.app = app;

</script>
