   
   <?php wp_footer(); ?>

   <!-- <footer id='app-bugging'>
      <div v-show='menuOpen' class='menu'>
         <a href="<?php echo WATERGO_HOME; ?>">HOME</a>
         <a href="<?php echo get_bloginfo('url'); ?>/nearby?nearby_page=nearby">NEAR BY</a>
         <a href="<?php echo WATERGO_ORDER; ?>?order_page=order-index">ORDER</a>
         <a href="<?php echo WATERGO_USER; ?>?user_page=user-profile">ME</a>
      </div>
      <button @click='menuToggle'>Bugging</button>
   </footer> -->
   <script>
      // var { createApp } = Vue;
      // createApp({
      //    data(){
      //       return{
      //          menuOpen: false,
      //       }
      //    },

      //    methods: {
      //       menuToggle(){
      //          if( this.menuOpen == true ){
      //             this.menuOpen = false;
      //          }else{
      //             this.menuOpen = true;
      //          }
      //       }
      //    },

      // }).mount('#app-bugging');

   </script>
   <style>
       #app-bugging{
         position: fixed;
         z-index: 999;
         bottom: 40px;
         right: 0;
         display: flex;
         flex-flow: row nowrap;
         align-items: center;
         box-shadow: 0 0 4px 4px #EFEFF4;
         background: white;
      }
      #app-bugging .menu{
         display: flex;
         flex-flow: row nowrap;
         align-items: center;
      }
      #app-bugging button{
         width: 85px;
         background: #D9D9D9;
         font-size: 12px;
         margin: 0;
      }
      #app-bugging a{
         font-size: 12px;
         text-decoration: none;
         background: #D9D9D9;
         margin-right: 5px;
      }
   </style>
   
</body>
</html>