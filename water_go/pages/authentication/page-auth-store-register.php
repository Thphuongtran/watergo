<div id='authentication'>

   <div v-show='loading == false' class='page-auth-register'>

      <div class='appbar'>
         <div class='appbar-top'>
            <div class='leading'>
               <button @click='goBackForce' class='btn-action'>
                  <svg width="20" height="16" viewBox="0 0 20 16" fill="none" xmlns="http://www.w3.org/2000/svg">
                  <path fill-rule="evenodd" clip-rule="evenodd" d="M0 8C0 7.44772 0.447715 7 1 7H18.5C19.0523 7 19.5 7.44772 19.5 8C19.5 8.55228 19.0523 9 18.5 9H1C0.447715 9 0 8.55228 0 8Z" fill="#252831"/>
                  <path fill-rule="evenodd" clip-rule="evenodd" d="M10.5309 0.375342C10.8759 0.806604 10.806 1.4359 10.3747 1.78091L2.60078 8.00004L10.3747 14.2192C10.806 14.5642 10.8759 15.1935 10.5309 15.6247C10.1859 16.056 9.55657 16.1259 9.12531 15.7809L0.375305 8.78091C0.13809 8.59113 0 8.30382 0 8.00004C0 7.69625 0.13809 7.40894 0.375305 7.21917L9.12531 0.219168C9.55657 -0.125842 10.1859 -0.0559202 10.5309 0.375342Z" fill="#252831"/>
                  </svg>
               </button>
            </div>
         </div>
      </div>

      <div class='inner style01'>

         <div class='t-center'>
            <img class='login-align' width='210' src="<?php echo THEME_URI . '/assets/images/watergo_logo_business.svg'; ?>">
         </div>

         <div class='heading-01 t-center'>Sign Up</div>

         <div class='form-group style-checkbox-business'>
            <label class='form-checkbox'>
               <input class='form-check' type='checkbox' @click='btn_select_type_product("water")' :checked='select_type_product.water' :disable='select_type_product.water'> 
               <span class='text'>Water</span>
            </label>
            <label class='form-checkbox'>
               <input type='checkbox' @click='btn_select_type_product("ice")' :checked='select_type_product.ice' :disable='select_type_product.ice'> 
               <span class='text'>Ice</span>
            </label>
            <label class='form-checkbox'>
               <input type='checkbox' @click='btn_select_type_product("both")' :checked='select_type_product.both' :disable='select_type_product.both'> 
               <span class='text'>Both</span>
            </label>
         </div>

         <div class='form-group'>
            <span>Owner</span>
            <input v-model='inputOwner' type="text" placeholder='Enter owner name'>
         </div>

         <div class='form-group'>
            <span>Store Name</span>
            <input v-model='inputStoreName' type="text" placeholder='Enter store name'>
         </div>

         <div class='form-group'>
            <span>Address</span>
            <input v-model='inputAddress' type="text" placeholder='Enter address'>
         </div>

         <div class='form-group'>
            <span>Phone</span>
            <input v-model='inputPhone' type="text" pattern='[0-9]*' placeholder='Enter phone'>
         </div>

         <div class='form-group'>
            <span>Email</span>
            <!-- <input v-model='inputEmail' type="email" placeholder='Enter your email'> -->

            <div class='form-group-email mb10'>
               <input v-model='inputEmail' type="email" placeholder='Enter you email'>
               <button class='btn-email-verify' @click='btn_verify_email_and_sendcode' class='btn-text' :class='isCodeSend == true ? "is-send": ""' >Verify</button>
            </div>
         </div>
         
         <!-- <p>
            <button @click='btn_verify_email_and_sendcode' class='btn-text' >Verify your email</button>
         </p> -->
         <p v-show='isCodeSend' class='t-second-12 text-code-resend'>
            We have sent a code to your email. <button @click='btn_verify_email_and_sendcode' class='btn-text'>Resend</button>
         </p>

         <div v-if='isCodeSend' class='box-code-verify'>
            <input @input="moveFocus($event, 'code02')" @keydown.delete="moveFocus($event, 'code01')" id='code01' v-model='code01' maxlength='1' type="text" pattern='[0-9]*' autocomplete='off'>
            <input @input="moveFocus($event, 'code03')" @keydown.delete="moveFocus($event, 'code02')" id='code02' v-model='code02' maxlength='1' type="text" pattern='[0-9]*' autocomplete='off'>
            <input @input="moveFocus($event, 'code04')" @keydown.delete="moveFocus($event, 'code03')" id='code03' v-model='code03' maxlength='1' type="text" pattern='[0-9]*' autocomplete='off'>
            <input @keydown.delete="moveFocus($event, 'code04')" id='code04' v-model='code04' type="text" maxlength='1' pattern='[0-9]*' autocomplete='off'>
         </div>

         <div class='form-group mt10'>
            <span>Password</span>
            <input v-model='inputPassword' type="password" placeholder='Enter your password'>
         </div>

         <div class='form-check style01 mt15'>
            <label class='justify-center'>
               <input @click='toggle_term_conditions' :checked='term_conditions' type='checkbox' class='checkbox-login'> 
               <span class='text text-nowrap'> I agree with <span class='t-primary'>Terms and Conditions</span></span>
            </label>
         </div>

         <p class='t-red mt10'>
            {{ res_text_sendcode }}
         </p>

         <div class='form-group mb50' :class='term_conditions == false ? "disable" : ""'>
            <button @click='btn_register' class='btn btn-primary'>Sign Up</button>
            <button @click='goBack' class='btn btn-second mt15'>Log In</button>
         </div>

      </div>

   </div>

   <div v-show='loading == true'>
      <div class='progress-center'>
         <div class='progress-container enabled'><progress class='progress-circular enabled' ></progress></div>
      </div>
   </div>

   <div v-show='banner_open == true' class='banner'>
      <div class='banner-head'>
         <svg width="64" height="64" viewBox="0 0 64 64" fill="none" xmlns="http://www.w3.org/2000/svg">
         <circle cx="32" cy="32" r="32" fill="#2790F9"/>
         <path fill-rule="evenodd" clip-rule="evenodd" d="M44.7917 24.8288L42.103 22.1401L27.8578 36.3854L22.2522 30.7798L19.5635 33.4685L27.9506 41.8557L30.6393 39.167L30.5465 39.0741L44.7917 24.8288Z" fill="white"/>
         </svg>
         <h3>Congratulations!</h3>
         <p>Your registration has been successful</p>
      </div>

      <div class='banner-footer'>
         <button @click='goBackForce' class='btn btn-outline'>Exit</button>
      </div>
   </div>

</div>

<script>

var { createApp } = Vue;
createApp({
   data (){
      return {
         loading: false,
         banner_open: false,

         select_type_product: {
            water: false,
            ice: false,
            both: false
         },
         select_type_product_text: '',

         inputOwner: '',
         inputStoreName: '',
         inputAddress: '',
         inputPhone: '',
         inputEmail: '',
         inputPassword: '',

         res_text_sendcode: '',

         term_conditions: false,

         // CODE VERIFY
         isCodeSend: false,
         code01: '',
         code02: '',
         code03: '',
         code04: '',
      }
   },

   methods: {

      verify_email( email ){
         const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
         if (emailRegex.test(email)) {
            return true;
         }else{
            return false;
         }
      },

      btn_select_type_product( type ){
         // force all
         if(this.select_type_product_text != type ){
            for (let prop in this.select_type_product) {
               if (this.select_type_product.hasOwnProperty(prop)) {
                  this.select_type_product[prop] = false;
               }
            }
            switch(type){
               case 'water': 
                  this.select_type_product.water = true; 
                  this.select_type_product_text = 'water';
               break;
               case 'ice': this.select_type_product.ice = true; 
                  this.select_type_product_text = 'ice';
               break;
               case 'both': this.select_type_product.both = true; 
                  this.select_type_product_text = 'both';
               break;
            }
         }
      },

      goBackForce(){ window.goBack(); },
      goBack(){ if(this.term_conditions == true) { window.goBack(); } },

      toggle_term_conditions(){ this.term_conditions = !this.term_conditions;},
      
      moveFocus(event, nextInput){
         var input = event.target;
         var id = event.target.id;
         if (event.key === "Backspace" && !input.value && input.previousElementSibling) {
            input.previousElementSibling.focus();
         } else if (input.value && input.nextElementSibling) {
            input.nextElementSibling.focus();
         }
      },

      resetCode(){
         this.code01 = '';
         this.code02 = '';
         this.code03 = '';
         this.code04 = '';
         this.res_text_sendcode = '';
      },

      async btn_verify_email_and_sendcode(){
         this.loading = true;
         this.code01 = '';
         this.code02 = '';
         this.code03 = '';
         this.code04 = '';

         if( this.inputEmail != '' && this.inputEmail.length > 0){
            if( this.verify_email(this.inputEmail) == true ){
               var form = new FormData();
               form.append('action', 'atlantis_send_code_verification');
               form.append('email', this.inputEmail);
               form.append('event', 'email_non_exists');
               var r = await window.request(form);
               if( r != undefined ){
                  var res = JSON.parse( JSON.stringify(r));
                     this.loading = false;

                  if( res.message == 'email_is_not_correct_format' ){
                     this.res_text_sendcode = 'Email is not correct format.';
                  }
                  if( res.message == 'email_already_exists' ){
                     this.res_text_sendcode = 'Email already register.';
                  }
                  if( res.message == 'sendcode_success' ){
                     this.res_text_sendcode = '';
                     this.isCodeSend = true;
                  }

               }else{
                  this.res_text_sendcode = 'Get Code Verify Error.';
               }
            }else{
               this.res_text_sendcode = 'Email is not correct format.';
            }
         }
         this.loading = false;

         
      },

      async btn_register(){
         
         var code = this.code01 + this.code02 + this.code03 + this.code04;
         if( this.term_conditions == true){
            this.loading = true;

            if( 
               this.inputOwner != '' && 
               this.select_type_product_text != '' &&
               this.inputStoreName != '' &&
               this.inputAddress != '' &&
               this.inputPhone != '' &&
               this.inputEmail != '' && 
               this.inputPassword != ''
            ){

               if( code != '' ){

                  var form = new FormData();
                  form.append('action', 'atlantis_store_register');
                  form.append('owner', this.inputOwner);
                  form.append('storeType', this.select_type_product_text);
                  form.append('storeName', this.inputStoreName);
                  form.append('address', this.inputAddress );
                  form.append('phone', this.inputPhone);
                  form.append('email', this.inputEmail);
                  form.append('password', this.inputPassword);
                  form.append('code', code);
                  var r = await window.request(form);
                  if( r != undefined ){
                     var res = JSON.parse( JSON.stringify( r ));
                     // DISPLAY ERROR
                     if( res.message == 'email_already_exists' ){
                        this.res_text_sendcode = 'Email already exists.';
                     }
                     
                     if( res.message == 'code_is_not_match' ){
                        this.res_text_sendcode = 'Code is not match.';
                     }

                     if( res.message == 'phonenumber_is_not_correct_format' ){
                        this.res_text_sendcode = 'Phone number is not correct format.';
                     }

                     if( res.message == 'all_field_empty' ){
                        this.res_text_sendcode = 'All field must be not empty.';
                     }
                     if( res.message == 'register_ok' ){
                        this.banner_open = true;
                     }
                  }

               }else{
                  this.res_text_sendcode = 'Email is not verify.';
               }
            }else{
               this.res_text_sendcode = 'All field must be not empty.';
            }
            this.loading = false;
         }

      },

   }

}).mount('#authentication');

</script>