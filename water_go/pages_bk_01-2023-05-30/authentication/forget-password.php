<div class='appbar'>
   <div class='leading'></div>
   <div class='title'></div>
   <div class='action'>
      <button @click='btn_close_forget_password' class='btn-action t-right'>
         <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
            <path d="M18 6L6 18" stroke="black" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
            <path d="M6 6L18 18" stroke="black" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
         </svg>
      </button>
   </div>
</div>
<div class='inner style01'>
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