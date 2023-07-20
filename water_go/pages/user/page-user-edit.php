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

               <svg width="388" height="181" viewBox="0 0 388 181" fill="none" xmlns="http://www.w3.org/2000/svg">
                  <rect width="388" height="180" rx="8" fill="#F9F9F9"/>
                  <g filter="url(#filter0_d_95_4)">
                  <circle cx="367" cy="159" r="16" fill="white"/>
                  </g>
                  <path d="M366.881 162.793C368.452 162.793 369.726 161.52 369.726 159.949C369.726 158.378 368.452 157.104 366.881 157.104C365.31 157.104 364.037 158.378 364.037 159.949C364.037 161.52 365.31 162.793 366.881 162.793Z" fill="#252831"/>
                  <path d="M374.467 152.363H371.461L370.285 151.083C370.109 150.889 369.893 150.734 369.653 150.628C369.413 150.522 369.154 150.467 368.892 150.467H364.871C364.34 150.467 363.828 150.694 363.468 151.083L362.302 152.363H359.296C358.253 152.363 357.4 153.216 357.4 154.259V165.637C357.4 166.68 358.253 167.533 359.296 167.533H374.467C375.51 167.533 376.363 166.68 376.363 165.637V154.259C376.363 153.216 375.51 152.363 374.467 152.363ZM366.881 164.689C364.265 164.689 362.141 162.565 362.141 159.948C362.141 157.331 364.265 155.208 366.881 155.208C369.498 155.208 371.622 157.331 371.622 159.948C371.622 162.565 369.498 164.689 366.881 164.689Z" fill="#252831"/>
                  <defs>
                  <filter id="filter0_d_95_4" x="347" y="141" width="40" height="40" filterUnits="userSpaceOnUse" color-interpolation-filters="sRGB">
                  <feFlood flood-opacity="0" result="BackgroundImageFix"/>
                  <feColorMatrix in="SourceAlpha" type="matrix" values="0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 127 0" result="hardAlpha"/>
                  <feOffset dy="2"/>
                  <feGaussianBlur stdDeviation="2"/>
                  <feComposite in2="hardAlpha" operator="out"/>
                  <feColorMatrix type="matrix" values="0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0.14 0"/>
                  <feBlend mode="normal" in2="BackgroundImageFix" result="effect1_dropShadow_95_4"/>
                  <feBlend mode="normal" in="SourceGraphic" in2="effect1_dropShadow_95_4" result="shape"/>
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