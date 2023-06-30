<div id='app'>
   <div v-if='loading == false' class='page-auth-forget-password'>
      <div class='appbar'>
         <div class='appbar-top'>
            <div class='leading'>

            </div>
            <div class='action'>
               <button @click='goBack' class='btn-action mr0'>
                  <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                     <path d="M18 6L6 18" stroke="black" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                     <path d="M6 6L18 18" stroke="black" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                  </svg>
               </button>
            </div>
         </div>
      </div>
      <div class='inner'>
         <div class='heading-01 t-center mt100'>Forgot Password?</div>
         <p class='t-center'>Don’t worry when it happens <br> Reset your password</p>

         <div class='form-group'>
            <span>Email</span>
            <input v-model='inputEmail' type="email" placeholder='Enter your email'>
         </div>

         <p class='t-red mt10'>
            {{ res_text_sendcode }}
         </p>

         <div class='form-group'>
            <button @click='btn_forget_password' class='btn btn-primary'>Submit</button>
         </div>


      </div>
   </div>
   <div v-if='loading == true'>
      <div class='progress-center'>
         <div class='progress-container enabled'><progress class='progress-circular enabled' ></progress></div>
      </div>
   </div>
</div>

<script>
var { createApp } = Vue;
createApp({
   data (){
      return {
         loading: false,
         
         res_text_sendcode: '',
         inputEmail: '',
      }
   },
   methods: {
      goBack(){ window.goBack()},
      gotoAuthResetPassword(email){ window.gotoAuthResetPassword(email)},

      async btn_forget_password(){

         if( this.inputEmail != ''){
            this.loading = true;
            var form = new FormData();
            form.append('action', 'atlantis_forget_password');
            form.append('email', this.inputEmail);
            var r = await window.request(form);
            if( r != undefined ){
               var res = JSON.parse( JSON.stringify(r));

               if( res.message == 'sendcode_success' ){
                  this.res_text_sendcode = '';
                  this.gotoAuthResetPassword(this.inputEmail);
               } else if( res.message == 'email_is_not_correct_format' ){
                  this.loading = false;
                  this.res_text_sendcode = 'Email is not correct format.';
               } else if( res.message == 'email_is_not_exists' ){
                  this.loading = false;
                  this.res_text_sendcode = 'Email is not exitst.';
               }else{
                  this.loading = false;
                  this.res_text_sendcode = 'Get Code Verify Error.';
               }

            }else{
               this.loading = false;
               this.res_text_sendcode = 'Get Code Verify Error.';
            }
         }
      },

   }
}).mount('#app');

</script>
</script>