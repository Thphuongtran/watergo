<?php  
$current_user_id = get_current_user_id();
$disable_email = true;
if(!empty(get_user_meta($current_user_id,"user_login_social",true)) && empty(get_user_meta($current_user_id,"changed_email",true))){
   $disable_email = false;
}
?>
<style type="text/css">
   .form-group input:disabled{    border-color: rgb(84, 84, 84) !important;  opacity: 0.6;}
</style>
<div id='app'>
   <div v-if='loading == false' class='page-edit'>

      <div class='appbar fixed'>
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
            <label for='uploadAvatar' class='upload-avatar' style="display:inline-block;position: relative;">

               <svg v-if="previewAvatar == null" width="70" height="70" viewBox="0 0 70 70" fill="none" xmlns="http://www.w3.org/2000/svg">
               <circle cx="35" cy="35" r="35" fill="#ECECEC"/>
               <path d="M35 34.6429C39.7581 34.6429 43.6154 30.8053 43.6154 26.0714C43.6154 21.3376 39.7581 17.5 35 17.5C30.2419 17.5 26.3846 21.3376 26.3846 26.0714C26.3846 30.8053 30.2419 34.6429 35 34.6429Z" fill="white"/>
               <path d="M39.4872 38.2145H30.5128C25.3077 38.2145 21 42.5002 21 47.6788C21 48.9288 21.5385 50.0002 22.6154 50.5359C24.2308 51.4288 27.8205 52.5002 35 52.5002C42.1795 52.5002 45.7692 51.4288 47.3846 50.5359C48.2821 50.0002 49 48.9288 49 47.6788C49 42.3216 44.6923 38.2145 39.4872 38.2145Z" fill="white"/>
               </svg>


               <input id='uploadAvatar' class='avatarPickerDisable' type="file" @change='avatarSelected'>
               <img class='avatar-circle' :src="previewAvatar" v-if="previewAvatar" width='80' height='80' >
               <span class="camera-icon" style="position: absolute;bottom: -13px;right: -13px;">
                  <svg width="38" height="38" viewBox="0 0 38 38" fill="none" xmlns="http://www.w3.org/2000/svg">
                  <g filter="url(#filter0_d_780_5054)">
                  <circle cx="19" cy="17" r="15" fill="white"/>
                  </g>
                  <path d="M18.8888 20.556C20.3616 20.556 21.5555 19.3621 21.5555 17.8893C21.5555 16.4166 20.3616 15.2227 18.8888 15.2227C17.4161 15.2227 16.2222 16.4166 16.2222 17.8893C16.2222 19.3621 17.4161 20.556 18.8888 20.556Z" fill="#252831"/>
                  <path d="M26 10.7778H23.1822L22.08 9.57778C21.9143 9.39591 21.7126 9.25058 21.4876 9.1511C21.2626 9.05161 21.0193 9.00015 20.7733 9H17.0044C16.5067 9 16.0267 9.21333 15.6889 9.57778L14.5956 10.7778H11.7778C10.8 10.7778 10 11.5778 10 12.5556V23.2222C10 24.2 10.8 25 11.7778 25H26C26.9778 25 27.7778 24.2 27.7778 23.2222V12.5556C27.7778 11.5778 26.9778 10.7778 26 10.7778ZM18.8889 22.3333C16.4356 22.3333 14.4444 20.3422 14.4444 17.8889C14.4444 15.4356 16.4356 13.4444 18.8889 13.4444C21.3422 13.4444 23.3333 15.4356 23.3333 17.8889C23.3333 20.3422 21.3422 22.3333 18.8889 22.3333Z" fill="#252831"/>
                  <defs>
                  <filter id="filter0_d_780_5054" x="0" y="0" width="38" height="38" filterUnits="userSpaceOnUse" color-interpolation-filters="sRGB">
                  <feFlood flood-opacity="0" result="BackgroundImageFix"/>
                  <feColorMatrix in="SourceAlpha" type="matrix" values="0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 127 0" result="hardAlpha"/>
                  <feOffset dy="2"/>
                  <feGaussianBlur stdDeviation="2"/>
                  <feComposite in2="hardAlpha" operator="out"/>
                  <feColorMatrix type="matrix" values="0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0.14 0"/>
                  <feBlend mode="normal" in2="BackgroundImageFix" result="effect1_dropShadow_780_5054"/>
                  <feBlend mode="normal" in="SourceGraphic" in2="effect1_dropShadow_780_5054" result="shape"/>
                  </filter>
                  </defs>
                  </svg>
               </span>
            </label>
         </div>
         
         <div class='form-group'>
            <div class='label-style02'>Name</div>
            <input class='input-style02' v-model='name' type="text">
         </div>

         <div class='form-group'>
            <div class='label-style02'>Email</div>
            <input <?php if($disable_email) echo "readonly disabled"; ?>  class='input-style02' v-model='email' type="email">
         </div>

         <span class='t-red'>{{text_err}}</span>
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

var app = Vue.createApp({
   data (){
      return {
         loading: false,
         user: null,
         name: '',
         email: '',

         text_err: '',

         previewAvatar: null,
         selectedImage: null,
      }
   },
   methods: {

      async btn_update_user(){
         this.loading = true;
         this.text_err = '';
         var formData = new FormData();
         formData.append('action', 'atlantis_update_user');

         if( this.selectedImage != null ){
            formData.append('avatar[]', this.selectedImage );
         }
         
         if( this.email != '' && ( this.name != '' && this.name.length > 0 )  ){
            formData.append('email', this.email);
            formData.append('name', this.name);
            var r = await window.request(formData);
            
            if(r != undefined ){
               
               var res = JSON.parse( JSON.stringify( r ));
               if( res.message == 'update_user_ok' ){
                  this.goBackRefresh();
               }

               if( res.message == 'email_is_not_correct_format' ){
                  this.text_err = 'Email is not correct format.';
                  this.loading = false;
               }
               if( res.message == 'email_already_exists' ){
                  this.text_err = 'Email already exists.';
                  this.loading = false;
               }
            }
         }else{
            this.text_err = 'Name or Email is not empty.';
            this.loading = false;
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
               if(this.name == ""){
                  this.name = this.user.display_name;
               }
               <?php if($disable_email) echo 'this.email = this.user.user_email;'; ?>              
               this.previewAvatar = this.user.user_avatar.url;
            }
         }
      },

      goBackRefresh(){
         window.location.href = '?appt=X&data=user_profile_update';
      },

      goBack(){
         window.goBack();
      },
   },
   computed: {
      
   },
   async created(){
      this.loading = true;
      await this.initUser();
      this.loading = false;

      window.appbar_fixed();
   }
}).mount('#app');

window.app = app;




</script>