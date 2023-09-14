<?php wp_footer(); ?>
<footer></footer>
<script>

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

   async function get_delivery_address_by_id( delivery_id ){
      var form = new FormData();
      form.append('action', 'atlantis_get_delivery_address_single');
      form.append('delivery_id', delivery_id);
      var r = await window.request(form);
      if( r != undefined ){
         var res = JSON.parse( JSON.stringify(r));
         if( res.message == 'get_delivery_address_ok'){
            return res.data;
         }
      }
   }


   async function atlantis_get_language(){
      var form = new FormData();
      form.append('action', 'atlantis_get_language');
      var r = await window.request(form);
      if( r != undefined ){
         var res = JSON.parse( JSON.stringify(r ));

         if( res.data == 'en_US' ){
            return 'English';
         } if( res.data == 'vi' ){
            return 'Vietnamese';
         } if( res.data == 'ko_KR' ){
            return 'Korean';
         }

      }
   }


   async function atlantis_user_profile_update(){
      var form = new FormData();
      form.append('action', 'atlantis_user_profile_update');
      var r = await window.request(form);
      if( r != undefined ){
         var res = JSON.parse( JSON.stringify(r ));
         return res.data;
      }

   }

   async function atlantis_find_product (product_id ){
      var form = new FormData();
      form.append('action', 'atlantis_get_single_product_from_store');
      form.append('product_id', product_id);
      var r = await window.request(form);
      if( r != undefined ){
         var res = JSON.parse( JSON.stringify(r ));
         if( res.message == 'product_found'){
            return res.data;
         }else{
            return null;
         }
      }
   }

   async function get_review(review_id ){
      var form = new FormData();
      form.append('action', 'atlantis_get_review');
      form.append('review_id', review_id);
      var r = await window.request(form);
      if( r != undefined ){
         var res = JSON.parse( JSON.stringify( r));
         if( res.message == 'review_found'){
            return res.data;
         }
      }
   }

   async function findStore( store_id ){
      var form = new FormData();
      form.append('action', 'atlantis_find_store');
      form.append('store_id', store_id);
      var r = await window.request(form);
      if( r != undefined ){
         var res = JSON.parse( JSON.stringify(r));
         if(res.message == 'store_found' ){
            return res.data;
         }
      }
   }
   

   /**
    * @access END EXTENSION JS 
    */

   async function callbackResume(data){

      if ( data != "undefined" && data != "" ) {
         var partial = data.split('|');
         // alert(data);

         if ( partial[0] == 'refresh') {
            alert('refresh');
            if( window.appBridge != undefined ){
               window.appBridge.refresh();
            }
         }
         
         if( partial[0] == 'store_detail_profile_update'){
            var multi_part    = partial[1].split('=');
            var store_id      = multi_part[1];

            await findStore( parseInt(store_id)).then( (res) => {
               window.app.store.name          = res.name;
               window.app.store.store_image   = res.store_image;
            });
            await get_notification_count().then( (data) => window.app.notification_count = data );

         }

         if( partial[0] == 'store_detail_update' ){
            var multi_part    = partial[1].split('=');
            var store_id      = multi_part[1];
            await get_notification_count().then( (data) => window.app.notification_count = data );
            await findStore( parseInt(store_id)).then( (res) => {
               window.app.store.name               = res.name;
               window.app.store.description        = res.description;
               window.app.store.store_image_full   = res.store_image_full;
            });
         }

         if( partial[0] == 'review_update' ){
            var multi_part    = partial[1].split('=');
            var review_id     = multi_part[1];
            
            await get_notification_count().then( (data) => window.app.notification_count = data );

            await get_review(review_id).then( (res) => {
               var _indexReview = window.app.reviews.findIndex( item => item.id == review_id );
               if( _indexReview == -1 ){
                  // alert('new review');
                  window.app.reviews.push( res);
               }else{
                  window.app.reviews[_indexReview].contents = res.contents;
                  window.app.reviews[_indexReview].rating = res.rating;
                  // alert('review update ' + res.contents);
               }
            });

         }

         if( partial[0] == 'product_store_update' ){
            var multi_part    = partial[1].split('=');
            var product_id    = multi_part[1];

            await get_notification_count().then( (data) => window.app.notification_count = data );
            await atlantis_find_product(product_id).then( (res) => {
               var _indexProduct = window.app.products.findIndex( item => item.id == product_id );
               if( _indexProduct == -1 ){
                  window.app.products.push( res);
               }else{
                  window.app.products[_indexProduct] = res;
               }
            });
         }

         if( partial[0] == 'product_store_delete' ){
            var multi_part   = partial[1].split('=');
            var product_id   = multi_part[1];

            await get_notification_count().then( (data) => window.app.notification_count = data );
            window.app.products.forEach( (item, indexProduct) => {
               if( item.id == product_id){
                  window.app.products.splice(indexProduct, 1);
               }
            });

         }

         if( partial[0] == 'user_profile_update' ){
            await atlantis_user_profile_update().then( (res) => {
               // alert(res);
               window.app.name = res.name;
               if( res.user_avatar ){
                  window.app.user.user_avatar.url = res.user_avatar.url;
               }
            });
         }

         if ( partial[0] == 'notification_count' || ( partial[1] != undefined && partial[1] == 'notification_count' ) ) {
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

            // FOR ROLE USER ORDER
            if( partial[1] != undefined && partial[1] == 'is_order_select'){
               await get_delivery_address().then( (data) => {
                  data.forEach( item => {
                     var _exists = window.app.delivery_address.some( address => address.id == item.id );
                     if( ! _exists ){
                     //    if ( item.primary == 1 ){
                           // window.app.delivery_address.forEach( item => item.primary = 0);
                           window.app.delivery_address.push(item);
                     }
                  });
               });
            }else{

               await get_delivery_address().then( (data) => {
                  data.forEach( item => {
                     var _exists = window.app.delivery_address.some( address => address.id == item.id );
                     if( ! _exists ){
                        if ( item.primary == 1 ){
                           window.app.delivery_address.forEach( item => item.primary = 0);
                           window.app.delivery_address.push(item);
                        }else{
                           window.app.delivery_address.push(item);
                        }
                     }
                  });
               });
            }
         }

         if( partial[0] == 'delivery_just_delete'){
            var multi_part    = partial[1].split('=');
            var id_delivery   = multi_part[1];
            window.app.delivery_address.forEach( ( item, index ) => {
               if( item.id == parseInt(id_delivery) ){
                  window.app.delivery_address.splice(index, 1);
               }
            });
         }

         if( partial[0] == 'delivery_just_update'){
            var multi_part    = partial[1].split('=');
            var id_delivery   = multi_part[1];

            await get_delivery_address_by_id( id_delivery).then( (data) => {

               var _findIndex = window.app.delivery_address.findIndex( address => address.id == data.id);
               if( _findIndex != -1 ){
                  if( data.primary == 1 ){
                     window.app.delivery_address.forEach( _ar => _ar.primary = 0);
                     window.app.delivery_address[_findIndex] = data;
                  }else{
                     window.app.delivery_address[_findIndex] = data;
                  }

               }
            });
         }

         if( partial[0] == 'change_language_update' ){
            await atlantis_get_language().then( (data) => window.app.user_language = data );  
         }

         // SECOND ROUTE
         // if( partial[1] != undefined ){
         //    for( var i = 1; i < partial.length; i++ ){
         //       var multi_part = partial[i].split('=');
         //       if( multi_part[0] == 'notification_callback' && multi_part[1] == 'notification_count' ){
         //          await get_notification_count().then( (data) => window.app.notification_count = data );  
         //       }
         //    }
         // }

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

            if(output != "error"){
               let result = jQuery.parseJSON(output);
               if ( window.appBridge && result[0] == "success"){
                  window.appBridge.loginSuccess(result[1]);
                  window.appBridge.startMain();
                  // window.appBridge.close('refresh');
                  // window.appBridge.refresh();
               }
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

      .ui-date-picker-wrapper.datepicker-order-product .ui-datepicker-today a {
         color: #454545;
      }
      .ui-date-picker-wrapper.datepicker-order-product .ui-datepicker-today a:after {
         display: none;
      }
      .ui-date-picker-wrapper.datepicker-order-product .ui-datepicker-current-day a {
         color: white;
      }
      .ui-date-picker-wrapper.datepicker-order-product .ui-datepicker-current-day a:after {
         display: block;
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