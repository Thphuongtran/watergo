   
   <!-- <script src='<?php echo THEME_URI . '/assets/js/common.js'; ?>'></script> -->
   <?php wp_footer(); ?>

   <script>
     
   function callbackLoginSuccess(type, token, information){
      //alert("ok");return;
      jQuery.ajax({
         url: get_ajaxadmin,
         type: "post",
         dataType: "text",
         data: {           
            action: 'atlantis_social_login',
            token: token,  
            type: type,
            //web_token:jQuery("#login-token").val(),  
            information:information,             
         },

         success: function(output, textStatus, request) {
            /**
             {
               
             } 
             */
            //window.appBridge.loginSuccess(1)
            var id = request.getResponseHeader('user_id');

              if ( window.appBridge &&  window.appBridge.setUserToken && id){
                  window.appBridge.loginSuccess(id);
                  // window.appBridge.refresh();
              }
            // let result = jQuery.parseJSON(output);
            // if(result[0] == "success"){ 
            //    alert('login success');
               // window.appBridge.setUserToken(result[1]);
               // reload_in_current_tab();
            // }
         },
         error: function(xhr, textStatus, errorThrown) {
            //alert('Error:', errorThrown);
            alert('Error:', errorThrown);
         }
      });
   }

   function callbackLoginFail(message){
      alert('Login Fail ' + message);
   }


   // (function($){

   //    $("body").on("click", ".share-btn", function(e) {
   //       let linkShare = $(this).data("link") ;
   //       $("body").addClass("loading");
   //       $.ajax({
   //          url: define.ajax_url,
   //          type: "post",
   //          dataType: "text",
   //          data: {                  
   //             action: 'get_short_link_to_share',
   //             link: linkShare,
   //             token: $("#verify-token").val(),                                                         
   //          },
   //          success: function(link) {
   //             let shareData = {
   //                title: 'Table On',
   //                text: '',
   //                url: link,
   //             }
   //             $("body").removeClass("loading");
   //             navigator.share(shareData);
   //          },
   //          error: function () {
   //             alert('error')
   //          }

   //       });
   //    });
   // })(jQuery);

   

   
   </script>


</body>
</html>