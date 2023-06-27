<div class='page-edit'>

   <div class='page-appbar'>
      <div class='on-left'>

         <button @click='gotoProfile' class='btn-back'><img width='18' src='<?php echo THEME_URI . '/assets/images/button-back.png'; ?>'></button>
         
         <p class='title'>Edit Profile</p>
      </div>
      <div class='on-right'>
         <div class='actions'>
            <a href=""></a>
            <a href=""></a>
         </div>
      </div>
   </div>

   <div class='avatar-header'>
      <label for='uploadAvatar' class='upload-avatar'>
         <img v-if="previewAvatar == null" width='80' height='80' class='avatar-circle' :src="avatar" alt="Avatar">
         <input id='uploadAvatar' class='avatarPickerDisable' type="file" @change='avatarSelected'>
         <img class='avatar-circle' :src="previewAvatar" v-if="previewAvatar" width='80' height='80' >
      </label>
   </div>
   
   <div class='form-group02'>
      <div class='label-style02'>Name</div>
      <input class='input-style02' v-model='name' type="text">
   </div>

   <div class='form-group02'>
      <div class='label-style02'>Email</div>
      <input class='input-style02' v-model='email' type="email">
   </div>

   <button @click='updateUser' class='button button-edit'>Save</button>

</div>