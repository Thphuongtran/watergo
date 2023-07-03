   
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
              }
            // let result = jQuery.parseJSON(output);
            // if(result[0] == "success"){ 
            //    alert('login success');
               // window.appBridge.setUserToken(result[1]);
               // reload_in_current_tab();
            // }
         },
         error: function(xhr, textStatus, errorThrown) {
            alert('Error:', errorThrown);
         }
      });
   }

   function callbackLoginFail(message){
      alert('Login Fail ' + message);
   }

   
   </script>


</body>
</html>