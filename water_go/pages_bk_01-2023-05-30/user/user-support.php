<div class='page-user-support'>

   <div class='page-appbar-support'>
      <div class='appbar'>
         <div class='on-left'>

            <button @click='gotoProfile' class='btn-back'>
               <img width='18' src='<?php echo THEME_URI . '/assets/images/button-back-white.png'; ?>'>
            </button>

            <p class='title'>WaterGo Support</p>
         </div>
         <div class='on-right'>
            <div class='actions auto-resize'>
               <div class='btn-icon'>
                  <img width='20' src="<?php echo THEME_URI . '/assets/images/icon-support-notification.png'; ?>" alt="Notification">
                  <span class='badge-circle'></span>
               </div>
            </div>
         </div>
      </div>

      <div class='box-search'>
         <input class='input-search' type="text" v-model='textEditingController' placeholder='Search by product or store name'>
         <span class='icon-search'><img width='20' src='<?php echo THEME_URI . '/assets/images/icon-search.png';?>'></span>
      </div>
   </div>

   <div class='user-support-list'>
      <ul>
         <li v-for='i in 20 '>Question {{ i }}?</li>
      </ul>

   </div>

   <div class='support-bottomsheet'>
      <p>Send message to tell us more and we’ll help you </p>
      <button class='btn btn-primary'>Send a Message</button>
   </div>

</div>