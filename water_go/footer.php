   <?php wp_footer(); ?>
   <script>
      
   // function callbackResume(data){        
   //    if ( data != "undefined" && data != "" ) {
   //       if (data == 'refresh') {
   //          if( window.appBridge != undefined ){
   //             window.appBridge.refresh();
   //          }
   //       }
   //    }
   // }

   /**
    * @access EXTENSION JS 
    */

   async function get_notification_count(){
      var form = new FormData();
      form.append('action', 'atlantis_notification_count');
      var r = await window.request(form);
      if( r != undefined ){
         var res = JSON.parse( JSON.stringify(r));
         if(res.message == 'notification_found' ){
            return res.data;
         }
      }
   }

   async function get_delivery_address(){
      var form = new FormData();
      form.append('action', 'atlantis_user_delivery_address');
      form.append('event', 'get');
      var r = await window.request(form);
      if( r != undefined ){
         var res = JSON.parse( JSON.stringify( r ));
         if( res.message == 'get_delivery_address_ok' ){
            if( res.data != undefined ){
               return res.data;
            }
         }
      }
   }



   /**
    * @access END EXTENSION JS 
    */

   async function callbackResume(data){
      if ( data != "undefined" && data != "" ) {

         var partial = data.split('|');

         if ( partial[0] == 'refresh') {
            if( window.appBridge != undefined ){
               window.appBridge.refresh();
            }
         }

         if ( partial[0] == 'notification_count') {
            await get_notification_count().then( (data) => window.app.notification_count = data );
         }
         // if( dara == 'notification_update_data' ){}

         if( partial[0] == 'cart_count'){
            window.app.cart_count = window.count_product_in_cart();
         }

         if( partial[0] == 'delivery_update'){
            var _order_delivery_address   = JSON.parse(localStorage.getItem('watergo_order_delivery_address'));
            if( _order_delivery_address != undefined && _order_delivery_address.length > 0 ){
               window.app.delivery_address_primary = {
                  id:         _order_delivery_address[0].id,
                  name:       _order_delivery_address[0].name,
                  phone:      _order_delivery_address[0].phone,
                  address:    _order_delivery_address[0].address,
                  user_id:    _order_delivery_address[0].user_id,
                  latitude:   _order_delivery_address[0].latitude,
                  longitude:  _order_delivery_address[0].longitude
               };
            }
         }

         if( partial[0] == 'delivery_just_add' ){
            window.app.delivery_address = [];
            await get_delivery_address().then( (data) => 
               window.app.delivery_address.push( ...data )
            );
         }

         // SECOND ROUTE
         if( partial[1] != undefined ){
            for( var i = 1; i < partial.length; i++ ){
               var multi_part = partial[i].split('=');

               if( multi_part[0] == 'notification_callback' && multi_part[1] == 'notification_count' ){
                  await get_notification_count().then( (data) => window.app.notification_count = data );  
               }
            }
         }

      }
   }


   async function native_share_link( link ){

      var form = new FormData();
      form.append('action', 'atlantis_share_link');
      form.append('link', link );
      var r = await window.request(form);
      if( r != undefined ){
         var res = JSON.parse( JSON.stringify( r ));
         if( res.message == 'share_success' ){
            var shareData = {
               title: 'WaterGo',
               text: '',
               url: link
            };
            if (navigator.canShare) {
               navigator.share(shareData);
               alert('ok');
            } else {
               // Handle the case where the function is not supported
               alert("Web Share API not supported in this browser.");
            }
            
         }
      }
   }
     
   function callbackLoginSuccess(type, token, information){
      // alert("ok");return;
      $.ajax({
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
         beforeSend: function() {
            //alert('Hieu dep trai');
         },
         success: function(output, textStatus, request) {

            var id = request.getResponseHeader('user_id');

            if ( window.appBridge &&  window.appBridge.setUserToken && id){
               window.appBridge.loginSuccess(id);
               window.appBridge.startMain();
               // window.appBridge.close('refresh');
               // window.appBridge.refresh();
            }

         },
         error: function(xhr, textStatus, errorThrown) {
            //alert('Error:', errorThrown);
            alert('Error:', errorThrown);
         }
      });
   }

   function callbackLoginFail(message){
      console.log('Login Fail ' + message);
   }





   (function($){
      $(document).on('ready', function(){
         
      });

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
   })(jQuery);

   

   
   </script>
   <style>
      .ui-datepicker{
         font-family: "Be Vietnam Pro",sans-serif;
         line-height: 1.7;
         -webkit-font-smoothing: antialiased;
         -moz-osx-font-smoothing: grayscale;
         max-width: 388px !important;
         width: 90%;
      }
      .ui-date-picker-wrapper {
         position: fixed;
         top: 0;
         left: 0;
         width: 100%;
         height: 100%;
         background: rgba(0, 0, 0, 0.2);
         display: none;
         z-index: 888;
      }
      
      .ui-datepicker th{
         font-size: 14px;
         font-weight: 500;
         padding-bottom: 0;
      }
      .ui-date-picker-wrapper.active {
         display: block;
      }
      .ui-date-picker-wrapper #ui-datepicker-div {
         position: absolute;
         top: 50% !important;
         left: 50% !important;
         transform: translate(-50%, -50%);
         border: none;
         box-shadow: 0px 2px 10px 0px #00000029;
         border-radius: 5px;
      }
      .ui-datepicker .ui-datepicker-header {
         background: none;
         border: none;
         padding: 8px 8px 0;
         padding-left: 12px;
         display: flex;
         flex-flow: row nowrap;
         align-items: center;
      }
      .ui-datepicker .ui-datepicker-prev span,
      .ui-datepicker .ui-datepicker-next span {
         display: none;
      }
      .ui-datepicker .ui-datepicker-title {
         text-align: left;
         margin: 0;
         background: none;
         color: #2790F9;
         font-size: 16px;
         font-weight: 500;
      }
      
      .ui-datepicker .ui-datepicker-next:after {
         position: absolute;
         content: '';
         background-image: url("data:image/svg+xml;charset=utf8,%3Csvg width='8' height='14' viewBox='0 0 8 14' fill='none' xmlns='http://www.w3.org/2000/svg'%3E%3Cpath d='M1 13.0389L7 7.18308L1 1.32723' stroke='%23252831' stroke-width='1.5' stroke-linecap='round' stroke-linejoin='round'/%3E%3C/svg%3E");
         width: 8px;
         height: 14px;
         background-repeat: no-repeat;
         background-size: contain;
      }

      .ui-datepicker .ui-datepicker-prev:after {
         position: absolute;
         content: '';
         background-image: url("data:image/svg+xml;charset=utf8,%3Csvg width='8' height='14' viewBox='0 0 8 14' fill='none' xmlns='http://www.w3.org/2000/svg'%3E%3Cpath d='M7 13.0389L1 7.18308L7 1.32723' stroke='%23252831' stroke-width='1.5' stroke-linecap='round' stroke-linejoin='round'/%3E%3C/svg%3E");
         width: 8px;
         height: 14px;
         background-repeat: no-repeat;
         background-size: contain;
      }


      .ui-datepicker .ui-datepicker-prev, 
      .ui-datepicker .ui-datepicker-next{
         width: 20px;
         height: 20px;
         top: 12px;
         left: initial;
      }

      .ui-datepicker .ui-datepicker-prev{
         right: 25px;
      }
      .ui-datepicker .ui-datepicker-next{
         right: 0;
      }

      .ui-datepicker .ui-datepicker-title{ order: 1; }
      .ui-datepicker .ui-datepicker-prev{ order: 2; } 
      .ui-datepicker .ui-datepicker-next{ order: 3; }

      .ui-state-default, 
      .ui-widget-content .ui-state-default, 
      .ui-widget-header .ui-state-default, .ui-button, 
      html .ui-button.ui-state-disabled:hover, 
      html .ui-button.ui-state-disabled:active{

      }

      .ui-state-disabled{
         color: #BDBDBD;
      }

      .ui-datepicker td{
         padding: 0;
         padding: 4px;
      }

      .ui-state-default, 
      .ui-widget-content .ui-state-default, 
      .ui-widget-header .ui-state-default, .ui-button, 
      html .ui-button.ui-state-disabled:hover, 
      html .ui-button.ui-state-disabled:active{
         border: none;
         padding: 0;
         text-align: center;
         font-size: 14px;
         font-weight: 400;
         background: none;
         
         
      }

      .ui-state-highlight,
      .ui-state-active,
      .ui-widget-content .ui-state-highlight,
      .ui-widget-header .ui-state-highlight {
         color: white;
         position: relative;
         z-index: 1;
      }
      .ui-state-highlight:after,
      .ui-state-active:after,
      .ui-widget-content .ui-state-highlight:after,
      .ui-widget-header .ui-state-highlight:after {
         content: '';
         position: absolute;
         z-index: -1;
         width: 26px;
         height: 26px;
         background: #2790F9;
         left: 50%;
         top: -2px;
         transform: translateX(-50%);
         border-radius: 25px;
      }
      

      .ui-date-picker-wrapper.schedule-datepicker .ui-state-highlight {
         color: #454545 !important;
      }
      .ui-date-picker-wrapper.schedule-datepicker .ui-state-active{
         color: white !important;
      }
      .ui-date-picker-wrapper.schedule-datepicker .ui-state-active:before {
         content: '';
         position: absolute;
         z-index: -1;
         width: 26px;
         height: 26px;
         background: #2790F9;
         left: 50%;
         top: -2px;
         transform: translateX(-50%);
         border-radius: 25px;
      }
      .ui-date-picker-wrapper.schedule-datepicker .ui-state-highlight:after {
         display: none;
      }


      .ui-date-picker-wrapper.order-product .ui-state-highlight {
         color: #454545 !important;
      }
      .ui-date-picker-wrapper.order-product .ui-state-active{
         color: white !important;
      }
      .ui-date-picker-wrapper.order-product .ui-state-active:before {
         content: '';
         position: absolute;
         z-index: -1;
         width: 26px;
         height: 26px;
         background: #2790F9;
         left: 50%;
         top: -2px;
         transform: translateX(-50%);
         border-radius: 25px;
      }
      .ui-date-picker-wrapper.order-product .ui-state-highlight:after {
         display: none;
      }

      .ui-date-picker-wrapper.order-product .ui-state-hover{
         position: relative !important;
         color: white !important;
      }
      .ui-date-picker-wrapper.order-product .ui-state-hover:before{
         content: '';
         position: absolute;
         z-index: -1;
         width: 26px;
         height: 26px;
         background: #2790F9;
         left: 50%;
         top: -2px;
         transform: translateX(-50%);
         border-radius: 25px;
      }


   </style>

</body>
</html>