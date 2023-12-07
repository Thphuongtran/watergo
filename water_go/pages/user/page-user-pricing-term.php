<div id='app'>

   <div class='appbar'>
      <div class='appbar-top'>
         <div class='leading'>
            <button @click='goBack' class='btn-action'>
               <svg width="20" height="16" viewBox="0 0 20 16" fill="none" xmlns="http://www.w3.org/2000/svg">
                  <path fill-rule="evenodd" clip-rule="evenodd" d="M0 8C0 7.44772 0.447715 7 1 7H18.5C19.0523 7 19.5 7.44772 19.5 8C19.5 8.55228 19.0523 9 18.5 9H1C0.447715 9 0 8.55228 0 8Z" fill="#252831"/>
                  <path fill-rule="evenodd" clip-rule="evenodd" d="M10.5309 0.375342C10.8759 0.806604 10.806 1.4359 10.3747 1.78091L2.60078 8.00004L10.3747 14.2192C10.806 14.5642 10.8759 15.1935 10.5309 15.6247C10.1859 16.056 9.55657 16.1259 9.12531 15.7809L0.375305 8.78091C0.13809 8.59113 0 8.30382 0 8.00004C0 7.69625 0.13809 7.40894 0.375305 7.21917L9.12531 0.219168C9.55657 -0.125842 10.1859 -0.0559202 10.5309 0.375342Z" fill="#252831"/>
               </svg>
            </button>
            <p class='leading-title'><?php echo __('Surcharge Policy', 'watergo'); ?></p>
         </div>
      </div>
   </div>
   <div class='inner post-term-conditions'>
      <?php if( get_locale() == 'vi' ){ ?>
         <p>
            1. Phí giao hàng<br> 
            Miễn phí giao hàng dưới 5km.<br> 
            Từ 5km trở lên, bạn có thể phải trả phí giao hàng tùy theo chính sách của cửa hàng.
         </p>
         <p>
            2. Phí vác lầu có thang máy<br> 
            Phụ thu: 20.000 vnd/ lần
         </p>
         <p>
            3. Phí vác lầu không có thang máy (tối đa 3 lầu)<br> 
            Tầng 1 : 2.000 vnd/ bình<br> 
            Tầng 2 : 5.000 vnd/ bình<br> 
            Tầng 3: 10.000 vnd/ bình
         </p>
         <p>
            4. Phí cọc bình<br> 
            Bạn có thể phải trả thêm phí cọc bình cho cửa hàng. Sau khi trả lại bình, cửa hàng sẽ hoàn lại phí cọc này cho bạn.
         </p>
      <?php }else if( get_locale() == 'en_US' || get_locale() == 'ko_KR' ){ ?>
         <p>
            1/Delivery Fee<br>
            Free delivery within 5km.<br>
            For distances beyond 5km, you may be charged a delivery fee according to the store's policy.
         </p>
         <p>
            2/ Elevator Handling Fee<br>
            Surcharge: 20,000 VND/time
         </p>
         <p>
            3/Staircase Handling Fee (up to 3 floors without an elevator)<br>
            1st floor: 2,000 VND/item<br>
            2nd floor: 5,000 VND/item<br>
            3rd floor: 10,000 VND/item
         </p>
         <p>
            4/Bottle Deposit Fee<br>
            You may be required to pay an additional bottle deposit fee to the store. After returning the bottle, the store will refund this deposit fee to you.
         </p>
      <?php } ?>
   </div>

</div>
<script>

var app = Vue.createApp({
   data (){
      return {
      }
   },
   methods: {
      goBack(){window.goBack(); }
   },

   created(){
      window.appbar_fixed();
   }
   
}).mount('#app');
window.app = app;

</script>