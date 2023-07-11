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
            <label for='uploadAvatar' class='upload-avatar'>

               <svg v-if="previewAvatar == null" width="80" height="85" viewBox="0 0 80 85" fill="none" xmlns="http://www.w3.org/2000/svg">
                  <circle cx="35" cy="35" r="35" fill="#ECECEC"/>
                  <path d="M35 34.6429C39.7581 34.6429 43.6154 30.8053 43.6154 26.0714C43.6154 21.3376 39.7581 17.5 35 17.5C30.2419 17.5 26.3846 21.3376 26.3846 26.0714C26.3846 30.8053 30.2419 34.6429 35 34.6429Z" fill="white"/>
                  <path d="M39.4872 38.2145H30.5128C25.3077 38.2145 21 42.5002 21 47.6788C21 48.9288 21.5385 50.0002 22.6154 50.5359C24.2308 51.4288 27.8205 52.5002 35 52.5002C42.1795 52.5002 45.7692 51.4288 47.3846 50.5359C48.2821 50.0002 49 48.9288 49 47.6788C49 42.3216 44.6923 38.2145 39.4872 38.2145Z" fill="white"/>
                  <g filter="url(#filter0_d_780_35)">
                  <circle cx="61" cy="64" r="15" fill="white"/>
                  </g>
                  <path d="M60.8888 67.556C62.3616 67.556 63.5555 66.3621 63.5555 64.8893C63.5555 63.4166 62.3616 62.2227 60.8888 62.2227C59.4161 62.2227 58.2222 63.4166 58.2222 64.8893C58.2222 66.3621 59.4161 67.556 60.8888 67.556Z" fill="#252831"/>
                  <path d="M68 57.7778H65.1822L64.08 56.5778C63.9143 56.3959 63.7126 56.2506 63.4876 56.1511C63.2626 56.0516 63.0193 56.0002 62.7733 56H59.0044C58.5067 56 58.0267 56.2133 57.6889 56.5778L56.5956 57.7778H53.7778C52.8 57.7778 52 58.5778 52 59.5556V70.2222C52 71.2 52.8 72 53.7778 72H68C68.9778 72 69.7778 71.2 69.7778 70.2222V59.5556C69.7778 58.5778 68.9778 57.7778 68 57.7778ZM60.8889 69.3333C58.4356 69.3333 56.4444 67.3422 56.4444 64.8889C56.4444 62.4356 58.4356 60.4444 60.8889 60.4444C63.3422 60.4444 65.3333 62.4356 65.3333 64.8889C65.3333 67.3422 63.3422 69.3333 60.8889 69.3333Z" fill="#252831"/>
                  <defs>
                  <filter id="filter0_d_780_35" x="42" y="47" width="38" height="38" filterUnits="userSpaceOnUse" color-interpolation-filters="sRGB">
                  <feFlood flood-opacity="0" result="BackgroundImageFix"/>
                  <feColorMatrix in="SourceAlpha" type="matrix" values="0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 127 0" result="hardAlpha"/>
                  <feOffset dy="2"/>
                  <feGaussianBlur stdDeviation="2"/>
                  <feComposite in2="hardAlpha" operator="out"/>
                  <feColorMatrix type="matrix" values="0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0.14 0"/>
                  <feBlend mode="normal" in2="BackgroundImageFix" result="effect1_dropShadow_780_35"/>
                  <feBlend mode="normal" in="SourceGraphic" in2="effect1_dropShadow_780_35" result="shape"/>
                  </filter>
                  </defs>
               </svg>

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

var { createApp } = Vue;

createApp({
   data (){
      return {
         loading: false,
         user: null,
         name: '',
         email: '',

         avatar_user: 'avatar-dummy.png',

         text_err: '',

         previewAvatar: null,
         selectedImage: null,
      }
   },
   methods: {
      get_image_upload(image){ return window.get_image_upload(image); },

      async btn_update_user(){
         this.loading = true;
         this.text_err = '';
         var formData = new FormData();

         formData.append('action', 'atlantis_update_user');

         if( this.selectedImage != null ){
            formData.append('avatar', this.selectedImage );
         }
         
         if( this.email != '' && ( this.name != '' && this.name.length > 0 )  ){
            formData.append('email', this.email);
            formData.append('name', this.name);
            var r = await window.request(formData);
            if(r != undefined ){

               var res = JSON.parse( JSON.stringify( r ));
               if( res.message == 'update_user_ok' ){
                  this.goBack();
               }

               if( res.message == 'email_is_not_correct_format' ){
                  this.text_err = 'Email is not correct format.';
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
               this.email =  this.user.user_email;
            }
         }
      },

      // async get_user_avatar( user_id ){
      //    var form = new FormData();
      //    form.append('action', 'atlantis_user_get_avatar');
      //    form.append('user_id', user_id);
      //    var r = await window.request(form);
      //    if( r != undefined ){
      //       var res = JSON.parse( JSON.stringify( r ));
      //       if( res.message == 'user_avatar_ok' ){
      //          this.avatar_user = res.data;  
      //       }
      //    }

      // },

      goBack(){ window.goBack(); },
   },
   computed: {
      
   },
   async created(){
      this.loading = true;
      await this.initUser();
      // await this.get_user_avatar(this.user.user_id);
      this.loading = false;

      window.appbar_fixed();
   }
}).mount('#app');
</script>