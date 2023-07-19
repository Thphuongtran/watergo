/**
 * @access GLOBAL FUNCTION JS COMMON
 */
function check_cart_is_exists(){
   var _cartItems = JSON.parse(localStorage.getItem('watergo_carts'));
   if( _cartItems == undefined ){
      localStorage.setItem('watergo_carts', '[]');
   }
}

function explode_product_metadata( product_metadata ){
   return JSON.parse(product_metadata);
}

function add_item_to_cart( item ){

   var _cartItems = JSON.parse(localStorage.getItem('watergo_carts'));

   if( _cartItems && _cartItems.length == 0 ){
      _cartItems.push(item);
      localStorage.setItem('watergo_carts', JSON.stringify(_cartItems));
   }else{
      var _store_id     = item.store_id;
      var _product_id   = item.products[0].product_id;
      var _product_quantity_count = item.products[0].product_quantity_count;
      var _product_max_stock = item.products[0].product_max_stock;

      _cartItems.forEach( ( cart, indexCart ) => {
         // NO STORE in cart
         if( cart.store_id != _store_id ){
            _cartItems.push( item );
            localStorage.setItem('watergo_carts', JSON.stringify(_cartItems));
         // Store EXISTS => update product_quantity_count
         }else{

            var _findProduct = cart.products.find( p => p.product_id == _product_id );
            if( _findProduct ){
               _findProduct.product_quantity_count = _product_quantity_count;
               _findProduct.product_max_stock      = _product_max_stock;
            }else{
               _cartItems[indexCart].products.push( item.products[0] );
            }

            localStorage.setItem('watergo_carts', JSON.stringify(_cartItems));
         }
      });
   }
}

function compare_day_with_currentDate(day) {
  var currentDate = new Date();
  var currentDay = currentDate.getDate();
  var currentMonth = currentDate.getMonth() + 1;
  var currentYear = currentDate.getFullYear();
  // Convert the day parameter to an integer
  day = parseInt(day);
  // Check if the current day is greater than the given day
  if (currentDay > day) {
    // Check if the current month is December
    if (currentMonth === 12) {
      // Increment the current year
      currentYear++;
      currentMonth = 1; // Set the month to January
    } else {
      currentMonth++;
    }
  }
  
  var paddedDay = day.toString().padStart(2, '0');
  var paddedMonth = currentMonth.toString().padStart(2, '0');

  // Adjust the day to the current year and month
  var adjustedDate = paddedDay + '/' + paddedMonth + '/' + currentYear;
  return adjustedDate;
}

function getCurrentDateTime() {
  const months = ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'];

  const currentDate = new Date();
  const month = months[currentDate.getMonth()];
  const day = currentDate.getDate();
  const year = currentDate.getFullYear();
  let hours = currentDate.getHours();
  let minutes = currentDate.getMinutes();

  const amOrPm = hours >= 12 ? 'pm' : 'am';
  hours %= 12;
  hours = hours || 12; // Convert 0 to 12 for 12-hour format
  minutes = minutes < 10 ? '0' + minutes : minutes;

  const formattedDateTime = `${month} ${day},${year} ${hours}:${minutes} ${amOrPm}`;
  return formattedDateTime;
}

function appbar_fixed( callback ){

   (function($){
      $(document).ready(function(){
         var _appbar = $('.appbar');
         _appbar.addClass('fixed');
         $('#app').css('padding-top', _appbar.height());
      });
   })(jQuery);

}

function count_howmany_timestamp_left_to_nextday( timestamp ){
   // Convert the timestamp to milliseconds
   const timestampMs = timestamp * 1000;

   // Create a Date object using the timestamp
   const currentDate = new Date(timestampMs);

   // Get the current date values
   const currentYear = currentDate.getFullYear();
   const currentMonth = currentDate.getMonth();
   const currentDay = currentDate.getDate();

   // Create a new Date object for the next day
   const nextDay = new Date(currentYear, currentMonth, currentDay + 1);

   // Calculate the time remaining until the next day
   const timeRemaining = nextDay.getTime() - currentDate.getTime();

   // Calculate the remaining timestamp
   const remainingTimestamp = Math.floor(timeRemaining / 1000);

   // console.log('Time remaining until next day:', timeRemaining);
   // console.log('Remaining timestamp:', remainingTimestamp);
   
}

function bodyScrollToggle( check ){
   var el = document.querySelector('body.stop-scroll');

   if( check == undefined || check == null ){
      document.querySelector('body').classList.toggle('stop-scroll');
   }else{
      if( el == null && check == 'add' ){
         document.querySelector('body').classList.add('stop-scroll');
      } if( el != null && check == 'remove'){
         document.querySelector('body').classList.remove('stop-scroll');
      }
   }
}

function calculateDistance(lat1, lon1, lat2, lon2) {
   if( lat1 == 0 || lon1 == 0 || lat2 == 0 || lon2 == 0 ) return 0;
   var earthRadius = 6371; // Radius of the Earth in kilometers (from chat gpt)
   // var earthRadius = 6366; // Radius of the Earth in kilometers (from nasa)
   var dLat = window.toRadians(lat2 - lat1);
   var dLon = window.toRadians(lon2 - lon1);
   var a =
      Math.sin(dLat / 2) * Math.sin(dLat / 2) +
      Math.cos(window.toRadians(lat1)) *
      Math.cos(window.toRadians(lat2)) *
      Math.sin(dLon / 2) *
      Math.sin(dLon / 2);
   var c = 2 * Math.atan2(Math.sqrt(a), Math.sqrt(1 - a));
   var distance = earthRadius * c;
   
   return distance;
}

function toRadians(degrees) { return degrees * (Math.PI / 180); }

function get_location_from_address( address ){
   var keyID = 'nJEYTwZNrpgfDSKEA4VzYO2R-NNL1grWFpf3y60aK1k';

   try{
      return axios.get('https://geocode.search.hereapi.com/v1/geocode',{
         params: { q: address, apiKey: keyID }
      }).then(function (res) { 
         return res.status == 200 ? res.data : null;
      });
   }catch(e){
      console.log(e);
      return null;
   }
}

function shortenNumber(number) {
   if( number > 999 ){
      const suffixes = ['', 'k', 'm', 'b', 't'];
      const suffixNum = Math.floor((String(number).length - 1) / 3);
      let shortNumber = parseFloat((suffixNum != 0 ? (number / Math.pow(1000, suffixNum)) : number).toPrecision(3));
      
      if (shortNumber % 1 !== 0) {
         shortNumber = shortNumber.toFixed(1);
      }
      
      return shortNumber + suffixes[suffixNum];
   }else{
      return number;
   }
}

function common_get_product_price( price, discount_percent ){
   if( discount_percent == undefined || discount_percent == null || discount_percent == 0){
      return parseInt(price).toLocaleString('vi-VN') + ' đ';
   }
   var _price = price - ( price * ( discount_percent / 100 ) );
   if( _price == 0 ) return 0 + ' đ';
   return parseInt(_price).toLocaleString('vi-VN') + ' đ';
}

function get_fulldate_from_day( day ){
   const currentDate = new Date(); // Get the current date
   const currentMonth = currentDate.getMonth() + 1; // Months are zero-based, so we add 1
   const currentYear = currentDate.getFullYear();

   // Pad the day and month with leading zeros if necessary
   const paddedDay = String(day).padStart(2, '0');
   const paddedMonth = String(currentMonth).padStart(2, '0');

   // Combine the day, month, and year to form the full date
   const fullDate = `${paddedDay}/${paddedMonth}/${currentYear}`;

   return fullDate;
}

function get_shortname_day_of_week( dayOfWeek ){
   switch( dayOfWeek ){
      case 'Monday': return 'Mon'; break;
      case 'Tuesday': return 'Tue'; break;
      case 'Wednesday': return 'Wed'; break;
      case 'Thursday': return 'Thu'; break; 
      case 'Friday': return 'Fri'; break;
      case 'Saturday': return 'Sat'; break;
      case 'Sunday': return 'Sun'; break;
   }
}

function get_fullday_form_dayOfWeek(dayOfWeek) {
  const currentDate = new Date(); // Get the current date
  const currentDay = currentDate.getDate();
  const currentMonth = currentDate.getMonth() + 1; // Months are zero-based, so we add 1
  const currentYear = currentDate.getFullYear();

  const weekdays = ['Sunday', 'Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday'];
  const targetDayIndex = weekdays.findIndex(day => day.toLowerCase() === dayOfWeek.toLowerCase());

  if (targetDayIndex === -1) {
    return 'Invalid day of the week';
  }

  const currentDayOfWeekIndex = currentDate.getDay();
  const daysUntilTargetDay = (targetDayIndex + 7 - currentDayOfWeekIndex) % 7;
  const targetDate = new Date(currentYear, currentMonth - 1, currentDay + daysUntilTargetDay);

  // Pad the day and month with leading zeros if necessary
  const paddedDay = String(targetDate.getDate()).padStart(2, '0');
  const paddedMonth = String(targetDate.getMonth() + 1).padStart(2, '0');

  // Combine the day, month, and year to form the full date
  const fullDate = `${paddedDay}/${paddedMonth}/${targetDate.getFullYear()}`;

  return fullDate;
}

function request(formdata){
   try{
      return axios({ method: 'post', url: get_ajaxadmin, data: formdata
      }).then(function (res) { 
         return res.status == 200 ? res.data.data : null;
      });
   }catch(e){
      console.log(e);
      return null;
   }
}

function gotoHome(){
   window.location.href = window.watergo_domain + 'home';
}


function has_discount( product ){
   if( product.has_discount == 0 ) return false;
   var currentDate = new Date();

   var discount_from = new Date(product.discount_from);
   var discount_to   = new Date(product.discount_to);
   discount_from.setHours(0,0,0);
   discount_to.setHours(0,0,0);

   if (currentDate >= discount_from && currentDate <= discount_to) {
      return true;
   }else{
      return false;
   }
   return false;
}

/**
 * @access TOTAL PRICE WITH QUANTITY + DISCOUNT
 */
function get_total_price( price, quantity, discount){
   if( discount != null || discount != undefined){
      var getPriceDiscount = price - ( price * ( discount / 100 ) );
      return quantity * getPriceDiscount;
   }else{
      return quantity * price;
   }
}


function timestamp_to_date(timestamp) {
   var date = new Date(timestamp * 1000);
   var day = date.getDate();
   var month = (date.getMonth() + 1).toString().padStart(2, '0');
   var year = date.getFullYear();
   return day + '/' + month + '/' + year;
}

function check_time_validate_timestamp(_startTime, _closeTime){
   if( _startTime == 0 || _closeTime == 0 ) return false;
   var currentDate = new Date();
   var currentTime = parseInt( currentDate.getTime() / 1000 );
   if (currentTime >= _closeTime || currentTime < _startTime) {
      return false;
   } else {
      return true;
   }
}

function count_product_in_cart(){
   var _totalItem = 0;
   var _cartItems = JSON.parse(localStorage.getItem('watergo_carts'));
   if( _cartItems != undefined && _cartItems.length > 0 ){
      _cartItems.forEach(( item ) => _totalItem += item.products.length );
   }
   return _totalItem;
}

function count_product_total_price(){

   var _cartItems = JSON.parse(localStorage.getItem('watergo_carts'));

   var gr_price = {
      price: 0,
      price_discount: 0
   };

   _cartItems.forEach( store => {
      store.products.forEach(product => {
         if( product.product_select == true ){
            
            if( product.product_discount_percent != null || product.product_discount_percent != 0 ){
               gr_price.price_discount += ( product.product_price - ( product.product_price * ( product.product_discount_percent / 100)) ) * product.product_quantity_count;
            }else{
               gr_price.price_discount += product.product_price * product.product_quantity_count;
            }
            gr_price.price += product.product_price * product.product_quantity_count;
         }
      });

   });
   
   var _final_price = null;

   if( gr_price.price != gr_price.price_discount){
      _final_price = gr_price.price.toLocaleString('vi-VN') + ' đ';
   }

   return {
      price: _final_price,
      price_discount: gr_price.price_discount.toLocaleString('vi-VN') + ' đ'
   };
}


function timestamp_to_fulldate(timestamp){
   if(timestamp == undefined || timestamp == null || timestamp == 0 ) return false;
   var date = new Date(parseInt(timestamp) * 1000);
   var day = date.getDate().toString().padStart(2, '0');
   var month = (date.getMonth() + 1).toString().padStart(2, '0');
   var year = date.getFullYear();
   var hours = date.getHours().toString().padStart(2, '0');
   var minutes = date.getMinutes().toString().padStart(2, '0');

   var formattedDate = day + '-' + month + '-' + year + ' ' + hours + ':' + minutes;
   return formattedDate;
}

function getTimeDifference(timestamp) {
  var currentTimestamp = Math.floor(Date.now() / 1000); // Current timestamp in seconds
//   var messageTimestamp = Math.floor(timestamp / 1000); // Provided timestamp in seconds
  var messageTimestamp = Math.floor( parseInt(timestamp)); // Provided timestamp in seconds

  var timeDifference = currentTimestamp - messageTimestamp;

  var seconds = timeDifference;
  var minutes = Math.floor(seconds / 60);
  var hours = Math.floor(minutes / 60);
  var days = Math.floor(hours / 24);

  if (days > 0) {
    return days + " days ago";
  } else if (hours > 0) {
    return hours + " hours ago";
  } else if (minutes > 0) {
    return minutes + " minutes ago";
  } else {
    return seconds + " seconds ago";
  }
}

function shortString(str) {
   if (str.length > 50) {
      str = str.substring(0, 50);
      // Add ellipsis (...) at the end if desired
      str += "...";
   }
   return str;
}

// FOR ORDER STORE DETAIL
function get_type_order(order_type){
   if( order_type == 'once_date_time') return 'type-once';
   if( order_type == 'once_immediately') return 'type-once';
   if( order_type == 'weekly') return 'type-weekly';
   if( order_type == 'monthly') return 'type-monthly';
}

function print_type_order_text(order_type){
   if( order_type == 'once_date_time') return 'Once';
   if( order_type == 'once_immediately') return 'Once';
   if( order_type == 'weekly') return 'Weekly';
   if( order_type == 'monthly') return 'Monthly';
}
// END FOR ORDER STORE DETAIL

function gotoProductRecommend(){
   window.location.href = window.watergo_domain + 'product/?product_page=recommend&appt=N';
}
function gotoNearby(){
   window.location.href = window.watergo_domain + 'nearby/?nearby_page=nearby&appt=N';
}
function gotoNearbyStore(){
   window.location.href = window.watergo_domain + 'nearby/?nearby_page=nearby-store&appt=N';
}
function gotoProductWater(){
   window.location.href = window.watergo_domain + 'product/?product_page=water&appt=N';
}
function gotoProductIce(){
   window.location.href = window.watergo_domain + 'product/?product_page=ice&appt=N';
}
function gotoProductDetail(product_id){
   window.location.href = window.watergo_domain + 'product/?product_page=product-detail&product_id='+ product_id + '&appt=N';
}

function gotoProductTop( category_id ){
   window.location.href = window.watergo_domain + 'product/?product_page=top-products&category_id=' + category_id + '&appt=N';
}

function gotoStoreDetail(store_id){
   window.location.href = window.watergo_domain + 'store/?store_page=store-detail&store_id='+ store_id + '&appt=N';
}
function gotoCart(){
   window.location.href = window.watergo_domain + 'cart/?appt=N';
}
function goBack(){
   window.location.href = '?appt=X';
}

function gotoOrderProduct(){
   window.location.href = window.watergo_domain + 'order/?order_page=order-product&appt=N';
}

function gotoOrder(){
   window.location.href = window.watergo_domain + 'order/?order_page=order-index';
}

function gotoOrderDetail(order_id){
   window.location.href = window.watergo_domain + 'order/?order_page=order-detail&order_id=' + order_id + '&appt=N';
}

function gotoOrderStoreDetail(order_id){
   window.location.href = window.watergo_domain + 'order/?order_page=order-store-detail&order_id=' + order_id + '&appt=N';
}

function gotoReview(review_page, related_id){
   window.location.href = window.watergo_domain + 'review/?review_page=' + review_page +'&related_id=' + related_id + '&appt=N';
}

function gotoReviewIndex( store_id){
   window.location.href = window.watergo_domain +  'review/?review_page=review-index&store_id=' + store_id + '&appt=N';
}

function gotoNotification(code){
   window.location.href = window.watergo_domain + 'notification/?page_notification=notification&code='+ code + '&appt=N';
}

function gotoNotificationIndex(){
   window.location.href = window.watergo_domain + 'notification/?page_notification=notification-index&appt=N';
}

function gotoOrderFilter(filter){
   window.location.href = window.watergo_domain + 'order/?order_page=order-filter&filter=' + filter + '&appt=N';
}

function gotoPageUserDeliveryAddress(){
   window.location.href = window.watergo_domain + 'user/?user_page=user-delivery-address&appt=N';

}

function gotoSupport(){
   window.location.href = window.watergo_domain + 'support/?support_page=support-index&appt=N';
}

/**
* @access USER
*/

function gotoPageUserProfile(){
   window.location.href = window.watergo_domain + 'user/?user_page=user-profile&appt=N';
}
function gotoPageUserSettings(){
   window.location.href = window.watergo_domain + 'user/?user_page=user-settings&appt=N';
}
function gotoPageUserEditProfile(){
   window.location.href = window.watergo_domain + 'user/?user_page=user-edit&appt=N';
}
function gotoPageUserLanguage(){
   window.location.href = window.watergo_domain + 'user/?user_page=user-language&appt=N';
}
function gotoPageUserPassword(){
   window.location.href = window.watergo_domain + 'user/?user_page=user-password&appt=N';
}
function gotoPageUserTermConditions(){
   window.location.href = window.watergo_domain + 'user/?user_page=user-term-conditions&appt=N';
}
function gotoPageUserDeleteAccount(){
   window.location.href = window.watergo_domain + 'user/?user_page=user-delete-account&appt=N';
}

function gotoPageUserReviewEdit( review_id){
   window.location.href = window.watergo_domain + 'user/?user_page=user-review-edit&review_id=' + review_id + '&appt=N';
}

/*

*/

function gotoPageSupportDetail( support_id){
   window.location.href = window.watergo_domain + 'support/?support_page=page-support-detail&support_id=' + support_id + '&appt=N';
}

function gotoPageSupportAdd(){
   window.location.href = window.watergo_domain + 'support/?support_page=page-support-add&appt=N';
}

function gotoPageSupportNotification(){
   window.location.href = window.watergo_domain + 'support/?support_page=page-support-notification&appt=N';
}

function gotoPageSupportNotificationDetail(support_id){
   window.location.href = window.watergo_domain + 'support/?support_page=page-support-notification-detail&support_id=' + support_id + '&appt=N';
}

/**
 * @access AUTHENTICATION
 */

function gotoLogin(){
   window.location.href = window.watergo_domain + 'authentication/?auth_page=auth-login&appt=N';
}

function gotoAuthForgetPassword(){
   window.location.href = window.watergo_domain + 'authentication/?auth_page=auth-forget-password&appt=N';
}

function gotoAuthResetPassword( email ){
   window.location.href = window.watergo_domain + 'authentication/?auth_page=auth-reset-password&email=' + email + '&appt=N';
}

function gotoAuthRegister(){
   window.location.href = window.watergo_domain + 'authentication/?auth_page=auth-register&appt=N';
}

/**
 * @access CHAT
 */

function gotoChat(){
   window.location.href = window.watergo_domain + 'chat/?chat_page=chat-index&appt=N';
}

function gotoSearch(){
   window.location.href = window.watergo_domain + 'search/?search_page=search-index&appt=N';
}

async function get_current_user_by_network(){
   var form = new FormData();
   form.append('action', 'atlantis_get_user');
   var r = await window.request(form);
   if( r != undefined ){
      var res = JSON.parse( JSON.stringify(r));
      if( res.message == 'user_ok'){
         return res.data;
      }else{
         return null;
      }
   }
}

/**
 * @access UPDATE
 * @param [ user_id + store_id + product_id ] for chat messenger || conversation for chat-index page
 */
function gotoChatMessenger( args ){

   if( args != undefined || args != null ){
      var product_id          = args.product_id != undefined ? parseInt(args.product_id) : null;
      var store_id            = args.store_id != undefined ? parseInt(args.store_id) : null;
      var conversation_id     = args.conversation_id != undefined ? parseInt(args.conversation_id) : null;
      var user_id             = args.user_id != undefined ? parseInt(args.user_id) : null;
      // USER | STORE
      var host_chat           = args.host_chat != undefined ? String(args.host_chat) : null;

      var url =  window.watergo_domain + 'chat/?chat_page=chat-messenger';

      if( conversation_id != null ){
         url += '&conversation_id=' + conversation_id;
      }

      if( store_id != null ){
         url += '&store_id=' + store_id;
      }

      if( product_id != null ){
         url += '&product_id=' + product_id;
      }

      if( user_id != null ){
         url += '&user_id=' + user_id;
      }

      if( host_chat != null ){
         url += '&host_chat=' + host_chat;
      }

      window.location.href = url + '&appt=N';
      
   }else{
      window.location.href = window.watergo_domain + 'chat/?chat_page=chat-messenger&appt=N';
   }
}


async function is_conversation_created_or_create( user_id, store_id){
   var form = new FormData();
   form.append('action', 'atlantis_is_conversation_created_or_create');
   form.append('user_id', user_id);
   form.append('store_id', store_id);
   var _r = await window.request(form);

   if( _r != undefined ){
      var res = JSON.parse( JSON.stringify( _r));
      if(res.message == 'conversation_found'){
         return res.data;
      } if(res.message == 'conversation_create_ok'){
         return res.data;
      }else{
         return false;
      }

   }
}  


// SCHEDULE Order Detail
function gotoScheduleOrderDetail( order_id ){
   window.location.href = window.watergo_domain + 'schedule/?schedule_page=page-schedule-detail&order_id=' + order_id + '&appt=N';
}

/**
 * @access AUTH STORE
 */

function gotoStoreLogin(){
   window.location.href = window.watergo_domain + 'authentication/?auth_page=auth-store-login&appt=N';
}
function gotoStoreRegister(){
   window.location.href = window.watergo_domain + 'authentication/?auth_page=auth-store-register&appt=N';
}
function gotoStoreForgetPassword(){
   window.location.href = window.watergo_domain + 'authentication/?auth_page=auth-store-forget-password&appt=N';
}

/**
 * @access TAB PRODUCT STORE
 */
function gotoProductStoreEdit(action, product_type, product_id, store_id){
   var url = window.watergo_domain + 'product/?product_page=product-store-view';

   if( action != undefined ){
      url += '&action=' + action;
   }
   if( product_type != undefined ){
      url += '&product_type=' + product_type;
   }
   if( product_id != undefined ){
      url += '&product_id=' + product_id;
   }
   if( store_id != undefined ){
      url += '&store_id=' + store_id;
   }
   window.location.href = url + '&appt=N';
}

function gotoProductStoreAdd( store_id, product_type){
   var url = window.watergo_domain + 'product/?product_page=product-store-view';
   if( product_type != undefined ){
      url += '&product_type=' + product_type;
   }
   if( store_id != undefined ){
      url += '&store_id=' + store_id;
   }
   window.location.href = url + '&action=add&appt=N';
}

