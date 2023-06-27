<div id='app'>

   <div v-if='loading == false' class='page-edit'>

      <div class='appbar'>
         <div class='appbar-top'>
            <div class='leading'>
               <button @click='goBack' class='btn-action'>
                  <svg width="20" height="16" viewBox="0 0 20 16" fill="none" xmlns="http://www.w3.org/2000/svg">
                     <path fill-rule="evenodd" clip-rule="evenodd" d="M0 8C0 7.44772 0.447715 7 1 7H18.5C19.0523 7 19.5 7.44772 19.5 8C19.5 8.55228 19.0523 9 18.5 9H1C0.447715 9 0 8.55228 0 8Z" fill="#252831"/>
                     <path fill-rule="evenodd" clip-rule="evenodd" d="M10.5309 0.375342C10.8759 0.806604 10.806 1.4359 10.3747 1.78091L2.60078 8.00004L10.3747 14.2192C10.806 14.5642 10.8759 15.1935 10.5309 15.6247C10.1859 16.056 9.55657 16.1259 9.12531 15.7809L0.375305 8.78091C0.13809 8.59113 0 8.30382 0 8.00004C0 7.69625 0.13809 7.40894 0.375305 7.21917L9.12531 0.219168C9.55657 -0.125842 10.1859 -0.0559202 10.5309 0.375342Z" fill="#252831"/>
                  </svg>
               </button>
               <span class='leading-title'>Edit Profile </span>
            </div>
            
         </div>
      </div>

      <div class='inner'>
         <div class='avatar-header'>
            <label for='uploadAvatar' class='upload-avatar'>
               <img v-if="previewAvatar == null" width='80' height='80' class='avatar-circle' :src="user.avatar" alt="Avatar">
               <input id='uploadAvatar' class='avatarPickerDisable' type="file" @change='avatarSelected'>
               <img class='avatar-circle' :src="previewAvatar" v-if="previewAvatar" width='80' height='80' >
            </label>
         </div>
         
         <div class='form-group'>
            <div class='label-style02'>Name</div>
            <input class='input-style02' v-model='name' type="text">
         </div>

         <div class='form-group'>
            <div class='label-style02'>Email</div>
            <input class='input-style02' v-model='email' type="email">
         </div>
      </div>

      <div class='btn-fixed bottom'>
         <button @click='btn_update_user' class='btn btn-primary'>Save</button>
      </div>


   </div>

   <div v-if='loading == true'>
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
         user: null,
         name: '',
         email: '',

         previewAvatar: null,
         selectedImage: null,
      }
   },
   methods: {
      async btn_update_user(){
         this.loading = true;
         var formData = new FormData();
         formData.append('action', 'atlantis_update_user');

         if( this.email != '' ){
            formData.append('email', this.email);
         }
         if( this.name != '' ){
            formData.append('name', this.name);
         }

         if( this.selectedImage != null ){
            formData.append('avatar', this.selectedImage );
         }
         
         if( this.email != '' || this.name != '' || this.selectedImage != null ){
            var r = await window.request(formData);
            if(r != undefined ){
               var res = JSON.parse( JSON.stringify( r ));
               if( res.message == 'update_user_ok' ){
                  this.gotoPageUserProfile();
               }
            }
         }
      },

      avatarSelected(e){
         var file = e.target.files;
         if( file != undefined && file[0].type.startsWith('image/') ){
            var reader = new FileReader();
            reader.onload = (e) => {
               if(e.target.readyState == 2 ){
                  this.previewAvatar = e.target.result;
               }
            };
            reader.readAsDataURL(file[0]);
            this.selectedImage = file[0];
         }
      },
      
      async initUser(){
         var form = new FormData();
         form.append('action', 'atlantis_get_user_login_data');
         var r = await window.request(form);
         if( r != undefined ){
            var res = JSON.parse( JSON.stringify(r));
            if( res.message == 'user_found'){
               this.user = res.data;
               this.name = this.user.first_name;
               this.email =  this.user.user_email;
            }
            console.log(this.user);
         }
      },

      goBack(){ window.goBack(); },
      gotoPageUserProfile(){ window.gotoPageUserProfile();}
   },
   computed: {
      
   },
   async created(){
      this.loading = true;
      await this.initUser();
      this.loading = false;
   }
}).mount('#app');
</script>