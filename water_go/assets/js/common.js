/**
 * @access GLOBAL FUNCTION JS COMMON
 */

function get_translate_datepicker(){
   return {
      'en_US': {
         monthNames: ['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'],
         monthNamesShort: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'],
         dayNames: ['Sunday', 'Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday'],
         dayNamesShort: ['Sun', 'Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat'],
         dayNamesMin: [ "Sun", "Mon", "Tue", "Wed", "Thu", "Fri", "Sat" ],
      },
      'vi': {
         monthNames: ['Tháng 1', 'Tháng 2', 'Tháng 3', 'Tháng 4', 'Tháng 5', 'Tháng 6', 'Tháng 7', 'Tháng 8', 'Tháng 9', 'Tháng 10', 'Tháng 11', 'Tháng 12'],
         monthNamesShort: ['Th.1', 'Th.2', 'Th.3', 'Th.4', 'Th.5', 'Th.6', 'Th.7', 'Th.8', 'Th.9', 'Th.10', 'Th.11', 'Th.12'],
         dayNames: ['Chủ Nhật', 'Thứ Hai', 'Thứ Ba', 'Thứ Tư', 'Thứ Năm', 'Thứ Sáu', 'Thứ Bảy'],
         dayNamesShort: ['CN', 'T2', 'T3', 'T4', 'T5', 'T6', 'T7'],
         dayNamesMin: ['CN', 'T2', 'T3', 'T4', 'T5', 'T6', 'T7']
      },
      'ko_KR': {
         monthNames: ['1월', '2월', '3월', '4월', '5월', '6월', '7월', '8월', '9월', '10월', '11월', '12월'],
         monthNamesShort: ['1월', '2월', '3월', '4월', '5월', '6월', '7월', '8월', '9월', '10월', '11월', '12월'],
         dayNames: ['일요일', '월요일', '화요일', '수요일', '목요일', '금요일', '토요일'],
         dayNamesShort: ['일요일', '월요일', '화요일', '수요일', '목요일', '금요일', '토요일'],
         dayNamesMin: ['일요일', '월요일', '화요일', '수요일', '목요일', '금요일', '토요일']
      }
   };
}

function generateRandomString(length) {
   const charset = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789';
   let randomString = '';

   for (let i = 0; i < length; i++) {
      const randomIndex = Math.floor(Math.random() * charset.length);
      randomString += charset[randomIndex];
   }

   return randomString;
}

function hasMoreThanTwoZeroes(number){
   const numStr = number.toString();
   if( !/00{2,}/.test(numStr) ){
      return true;
   }else{
      return false;
   }
}

function truncateUTF8String(inputString, maxLength) {
   if (inputString.length <= maxLength) {
      return inputString;
   }

   let truncatedString = inputString.slice(0, maxLength);
   while (truncatedString.length > 0 && (truncatedString.charCodeAt(maxLength - 1) & 0xc0) === 0x80) {
      maxLength--;
      truncatedString = inputString.slice(0, maxLength);
   }

   return truncatedString;
}

async function atlantis_count_messeage_everytime(){
   var form = new FormData();
   form.append('action', 'atlantis_count_messeage_everytime');
   var r = await window.request(form);
   if( r != undefined ){
      var res = JSON.parse( JSON.stringify( r));
      if( res.message == 'count_messages_ok' ) {
         window.app.message_count = res.data;
      }else{
         window.app.message_count = 0;
      }
   }
}

function formatDateToDDMMYY(inputDateString) {
  const parts = inputDateString.split(/[- :]/);
  const year = parts[0].slice(-2);
  const month = parts[1];
  const day = parts[2];
  return `${day}/${month}/${year}`;
}

function convertVietnameseToLatin(text) {
    const map = {
        'á': 'a', 'à': 'a', 'ả': 'a', 'ã': 'a', 'ạ': 'a',
        'â': 'a', 'ấ': 'a', 'ầ': 'a', 'ẩ': 'a', 'ẫ': 'a', 'ậ': 'a',
        'ă': 'a', 'ắ': 'a', 'ằ': 'a', 'ẳ': 'a', 'ẵ': 'a', 'ặ': 'a',
        'é': 'e', 'è': 'e', 'ẻ': 'e', 'ẽ': 'e', 'ẹ': 'e',
        'ê': 'e', 'ế': 'e', 'ề': 'e', 'ể': 'e', 'ễ': 'e', 'ệ': 'e',
        'í': 'i', 'ì': 'i', 'ỉ': 'i', 'ĩ': 'i', 'ị': 'i',
        'ó': 'o', 'ò': 'o', 'ỏ': 'o', 'õ': 'o', 'ọ': 'o',
        'ô': 'o', 'ố': 'o', 'ồ': 'o', 'ổ': 'o', 'ỗ': 'o', 'ộ': 'o',
        'ơ': 'o', 'ớ': 'o', 'ờ': 'o', 'ở': 'o', 'ỡ': 'o', 'ợ': 'o',
        'ú': 'u', 'ù': 'u', 'ủ': 'u', 'ũ': 'u', 'ụ': 'u',
        'ư': 'u', 'ứ': 'u', 'ừ': 'u', 'ử': 'u', 'ữ': 'u', 'ự': 'u',
        'ý': 'y', 'ỳ': 'y', 'ỷ': 'y', 'ỹ': 'y', 'ỵ': 'y',
        'đ': 'd',
        'Á': 'A', 'À': 'A', 'Ả': 'A', 'Ã': 'A', 'Ạ': 'A',
        'Â': 'A', 'Ấ': 'A', 'Ầ': 'A', 'Ẩ': 'A', 'Ẫ': 'A', 'Ậ': 'A',
        'Ă': 'A', 'Ắ': 'A', 'Ằ': 'A', 'Ẳ': 'A', 'Ẵ': 'A', 'Ặ': 'A',
        'É': 'E', 'È': 'E', 'Ẻ': 'E', 'Ẽ': 'E', 'Ẹ': 'E',
        'Ê': 'E', 'Ế': 'E', 'Ề': 'E', 'Ể': 'E', 'Ễ': 'E', 'Ệ': 'E',
        'Í': 'I', 'Ì': 'I', 'Ỉ': 'I', 'Ĩ': 'I', 'Ị': 'I',
        'Ó': 'O', 'Ò': 'O', 'Ỏ': 'O', 'Õ': 'O', 'Ọ': 'O',
        'Ô': 'O', 'Ố': 'O', 'Ồ': 'O', 'Ổ': 'O', 'Ỗ': 'O', 'Ộ': 'O',
        'Ơ': 'O', 'Ớ': 'O', 'Ờ': 'O', 'Ở': 'O', 'Ỡ': 'O', 'Ợ': 'O',
        'Ú': 'U', 'Ù': 'U', 'Ủ': 'U', 'Ũ': 'U', 'Ụ': 'U',
        'Ư': 'U', 'Ứ': 'U', 'Ừ': 'U', 'Ử': 'U', 'Ữ': 'U', 'Ự': 'U',
        'Ý': 'Y', 'Ỳ': 'Y', 'Ỷ': 'Y', 'Ỹ': 'Y', 'Ỵ': 'Y',
        'Đ': 'D'
    };
    
    return text.replace(/[áàảãạâấầẩẫậăắằẳẵặéèẻẽẹêếềểễệíìỉĩịóòỏõọôốồổỗộơớờởỡợúùủũụưứừửữựýỳỷỹỵđÁÀẢÃẠÂẤẦẨẪẬĂẮẰẲẴẶÉÈẺẼẸÊẾỀỂỄỆÍÌỈĨỊÓÒỎÕỌÔỐỒỔỖỘƠỚỜỞỠỢÚÙỦŨỤƯỨỪỬỮỰÝỲỶỸỴĐ]/g, function(match) {
        return map[match] || match;
    });
}

function product_is_mark_out_of_stock( product ){
   if( product.mark_out_of_stock != undefined && product.mark_out_of_stock != null && product.mark_out_of_stock == 1 ) return true;
   return false;
}

function get_start_and_end_of_year(year) {
   function formatDate(date) {
      const year = date.getFullYear();
      const month = String(date.getMonth() + 1).padStart(2, '0'); // Months are zero-indexed, so we add 1 and pad with leading zeros if needed
      const day = String(date.getDate()).padStart(2, '0'); // Pad with leading zeros if needed

      return `${year}-${month}-${day}`;
   }
   
   // Validate the input year
   if (typeof year !== 'number' || isNaN(year) || year < 1) {
      throw new Error("Invalid year. Please provide a valid positive number for the year.");
   }

   // Create an array to store the start and end days for each month
   const monthsData = [];

   for (let monthNumber = 1; monthNumber <= 12; monthNumber++) {
      const startDate = new Date(year, monthNumber - 1, 1);
      const endDate = new Date(year, monthNumber, 0); // Note: Day 0 gives the last day of the previous month

      const startDay = formatDate(startDate);
      const endDay = formatDate(endDate);

      monthsData.push({ startDay, endDay });
   }

   return monthsData;
}


function get_start_and_end_of_month(monthNumber) {

   function formatDate(date) {
      const year = date.getFullYear();
      const month = String(date.getMonth() + 1).padStart(2, '0'); // Months are zero-indexed, so we add 1 and pad with leading zeros if needed
      const day = String(date.getDate()).padStart(2, '0'); // Pad with leading zeros if needed

      return `${year}-${month}-${day}`;
   }

   // Validate the input month number (1 to 12)
   if (monthNumber < 1 || monthNumber > 12) {
      throw new Error("Invalid month number. Please provide a number between 1 and 12.");
   }

   // Create a new Date object for the provided month and the current year
   const currentDate = new Date();
   const currentYear = currentDate.getFullYear();
   const startDate   = new Date(currentYear, monthNumber - 1, 1);
   const endDate     = new Date(currentYear, monthNumber, 0); // Note: Day 0 gives the last day of the previous month

   // Format dates as "YYYY-MM-DD"
   const startDay = formatDate(startDate);
   const endDay = formatDate(endDate);

   return {
      startDay: startDay,
      endDay: endDay,
      currentYear: currentYear
   };
}

function get_start_and_end_of_month_current() {
   function formatDate(date) {
      const year = date.getFullYear();
      const month = String(date.getMonth() + 1).padStart(2, '0'); // Months are zero-indexed, so we add 1 and pad with leading zeros if needed
      const day = String(date.getDate()).padStart(2, '0'); // Pad with leading zeros if needed

      return `${year}-${month}-${day}`;
   }

   // Get the current date
   const currentDate = new Date();
   const currentYear = currentDate.getFullYear();
   const currentMonth = currentDate.getMonth() + 1; // Months are zero-indexed, so we add 1

   // Get the start day of the current month
   const startDate = new Date(currentYear, currentMonth - 1, 1); // First day of the current month
   const startDay = formatDate(startDate);

   // Format the current day as "YYYY-MM-DD"
   const currentDay = formatDate(currentDate);

   return {
      startDay: startDay,
      currentDay: currentDay,
      currentYear: currentYear,
      currentMonth: currentMonth
   };
}
 

function removeZeroLeading(number) {
  let numberStr = number.toString();
  if (numberStr.charAt(0) === '0') {
    return parseInt(numberStr.slice(1), 10);
  }
  return number;
}

function addLeadingZeros(number) {
   if( number != undefined ){
      if (number <= 1000) return number.toString().padStart(4, '0');
      return number.toString();
   }
}

function addZeroLeading(number) {
  if (number < 10) {
    return '0' + number;
  } else {
    return '' + number;
  }
}

// async function native_share_link( link ){
//    var form = new FormData();
//    form.append('action', 'atlantis_share_link');
//    form.append('link', link );
//    var r = await window.request(form);
//    if( r != undefined ){
//       var res = JSON.parse( JSON.parse( r ));
//       if( res.message == 'share_success' ){

//          var shareData = {
//             title: 'WaterGo',
//             text: '',
//             url: link
//          };
//          // navigator.share(shareData);
//          navigator.share(shareData);
//       }
//    }
// }

function getPastDaysInMonth() {
  const currentDate = new Date();
  const currentMonth = currentDate.getMonth();
  const currentYear = currentDate.getFullYear();
  const daysInMonth = new Date(currentYear, currentMonth + 1, 0).getDate();
  const pastDaysArray = [];
  for (let day = 1; day <= daysInMonth; day++) {
    const checkDate = new Date(currentYear, currentMonth, day);
    if (checkDate < currentDate) {
      pastDaysArray.push(day);
    }
  }
  return pastDaysArray;
}

function isValidDateFormat(dateString) {
  // Attempt to parse the date using JavaScript's Date object
  const dateObj = new Date(dateString);
  // Check if the parsed date is a valid date
  // The condition isNaN(dateObj) will be true if dateObj is an Invalid Date
  if (isNaN(dateObj) || dateObj === undefined ) {
    return false;
  }
  // Check if the date string matches the parsed date
  // This is an additional check to ensure that the date format is correct
  // Some browsers may still parse invalid date strings, so we double-check here
  const formattedDate = dateObj.toISOString().slice(0, 10); // Format: "yyyy-mm-dd"
  return dateString === formattedDate;
}

function get_key_map(){
   return 'n3jhBrFdYLS-WMR8vOmWjLTxW8rZ7QsjQ4TwxHQHvr8';
}

/*
 * @access REVERSE DATE (dd/mm/yyyy) to (yyyy-mm-dd)
 */
function reverse_date_to_system_datetime( inputDate){
   if(inputDate != undefined && inputDate != null ){
      var [d, m, y] = inputDate.split('/');
      const formattedDate = `${y}-${m}-${d}`;
      return formattedDate;
   }
   return false;
}

function reverse_system_datetime_to_date( inputDate){
   if(inputDate != undefined && inputDate != null ){
      var [y, m, d] = inputDate.split('-');
      const formattedDate = `${d}/${m}/${y}`;
      return formattedDate;
   }
   return false;
}


/**
 * @access REVERSE DATE TO yyyy-mm-dd hh:ii:ss to  dd-mm-yyyy hh:ii
 */
function order_formatDate(inputDate){
   if(inputDate != undefined && inputDate != null ){
      const dateObj = new Date(inputDate);
      const day = dateObj.getDate().toString().padStart(2, '0');
      const month = (dateObj.getMonth() + 1).toString().padStart(2, '0');
      const year = dateObj.getFullYear().toString();
      const hours = dateObj.getHours().toString().padStart(2, '0');
      const minutes = dateObj.getMinutes().toString().padStart(2, '0');
      const formattedDate = `${day}-${month}-${year} ${hours}:${minutes}`;
      return formattedDate;
   }
   return false;
}

function reset_cart_to_select_false(){
   var _cartItems = JSON.parse(localStorage.getItem('watergo_carts'));
   if( _cartItems.length > 0 ){
      _cartItems.forEach( store => {
         store.store_select = false;
         store.products.forEach( product => product.product_select = false );
      });
      localStorage.setItem('watergo_carts', JSON.stringify(_cartItems));
   }
}

function check_cart_is_exists(){
   var _cartItems                = JSON.parse(localStorage.getItem('watergo_carts'));
   var _order_delivery_address   = JSON.parse(localStorage.getItem('watergo_order_delivery_address'));

   localStorage.setItem('watergo_order_delivery_address', '[]');

   if( _cartItems == undefined ){
      localStorage.setItem('watergo_carts', '[]');
   }
   // if( _order_delivery_address == undefined){
   //    localStorage.setItem('watergo_order_delivery_address', '[]');
   // }

}

function explode_product_metadata( product_metadata ){
   return JSON.parse(product_metadata);
}

/**
 * @access CART
 */



function add_quantity_to_cart_with_stock( product_id, quantity, maxStock ) {
   if( product_id != undefined && quantity > 0 && maxStock > 0 ){
      var _findProduct = get_product_from_cart(product_id);
      if( _findProduct != null ){
         var _quantity_product = _findProduct.product_quantity_count; 
         var new_quantity = _quantity_product + quantity;
         if( new_quantity > maxStock ){
            new_quantity = parseInt( maxStock );
         }
         var _carts = JSON.parse(localStorage.getItem('watergo_carts'));
         _carts.forEach( store => {
            store.products.forEach( product => {
               if( product.product_id == product_id ){
                  product.product_quantity_count = new_quantity;
               }
            });
         });
         localStorage.setItem('watergo_carts', JSON.stringify(_carts));
         return true;
      }
      return false;
   }
   return false;
}

function get_product_from_cart( product_id ){
   var _carts = JSON.parse(localStorage.getItem('watergo_carts'));
   let productExists = null;
   _carts.forEach( store => {
      store.products.forEach( product => {
         if( product.product_id == parseInt( product_id ) ){
            productExists = product;
         }
      });
   });
   return productExists;
}

function check_product_exists_in_cart( product_id ){
   var _carts = JSON.parse(localStorage.getItem('watergo_carts'));
   let productExists = false;
   _carts.forEach( store => {
      store.products.forEach( product => {
         if( product.product_id == parseInt( product_id ) ){
            productExists = true;
         }
      });
   });
   return productExists;
}

function add_item_to_cart( item ){
   var _cartItems = JSON.parse(localStorage.getItem('watergo_carts'));
   if( _cartItems && _cartItems.length == 0 ){
      _cartItems.push({
         store_id: item.store_id,
         store_name: item.store_name,
         store_select: false,
         products: [
            {
               product_id: item.product_id,
               product_quantity_count: item.product_quantity_count,
               product_select: false
            }
         ]
      });
      localStorage.setItem('watergo_carts', JSON.stringify(_cartItems));
      
   }else{

      var _findStore = _cartItems.some( store => store.store_id == item.store_id );
      if( _findStore ){
         _cartItems.forEach( store => {
            if( store.store_id == item.store_id  ){
               var _findProduct = store.products.find( product => product.product_id === item.product_id );
               if( _findProduct ){
                  _findProduct.product_quantity_count = item.product_quantity_count;
                  localStorage.setItem('watergo_carts', JSON.stringify(_cartItems));
               }else{
                  // NO
                  store.products.push({
                     product_id: item.product_id,
                     product_quantity_count: item.product_quantity_count,
                     product_select: false
                  });
                  localStorage.setItem('watergo_carts', JSON.stringify(_cartItems));
               }
            }
         });
      }else{
         _cartItems.push({
            store_id: item.store_id,
            store_name: item.store_name,
            store_select: false,
            products: [
               {
                  product_id: item.product_id,
                  product_quantity_count: item.product_quantity_count,
                  product_select: false
               }
            ]
         });
         localStorage.setItem('watergo_carts', JSON.stringify(_cartItems));
      }
      
   }
   
}

/** --------------------------------------------- */

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
         $('#app').css('padding-top', parseInt(_appbar.height()) );
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

/**
 * @access UPDATE Put product and output print
 */

function common_price_after_discount( product ){
   var price = product.price;

   if( product.has_discount == 1 && product.discount_percent > 0 ){
      var currentDate = new Date();
      var discount_from = new Date(product.discount_from);
      var discount_to   = new Date(product.discount_to);
      currentDate.setHours(0,0,0,0);
      discount_from.setHours(0,0,0,0);
      discount_to.setHours(0,0,0,0);
      currentDate    = parseInt(currentDate.getTime() / 1000);
      discount_from  = parseInt(discount_from.getTime() / 1000);
      discount_to    = parseInt(discount_to.getTime() / 1000);

      var discount_percent = product.discount_percent;

      if (currentDate >= discount_from && currentDate <= discount_to) {
         price = price - ( price * ( discount_percent / 100 ) );
      }

      return parseInt(price).toLocaleString() + global_currency;
   }
   return parseInt(price).toLocaleString() + global_currency;
}

function common_price_after_discount_and_quantity( product ){

   var price      = product.price      != undefined ? product.price : 0;
   var quantity   = product.quantity   == undefined ? product.product_quantity_count : product.quantity;
   
   if( product.has_discount == 1 && product.discount_percent > 0 ){
      var currentDate = new Date();
      var discount_from = new Date(product.discount_from);
      var discount_to   = new Date(product.discount_to);
      currentDate.setHours(0,0,0,0);
      discount_from.setHours(0,0,0,0);
      discount_to.setHours(0,0,0,0);
      currentDate    = parseInt(currentDate.getTime() / 1000);
      discount_from  = parseInt(discount_from.getTime() / 1000);
      discount_to    = parseInt(discount_to.getTime() / 1000);

      var discount_percent = product.discount_percent;
      if ( currentDate >= discount_from && currentDate <= discount_to ) {
         price = price - ( price * ( discount_percent / 100 ) );
         price = price * quantity;
      }else{
         price = price * quantity;
      }
      return parseInt(price).toLocaleString() + global_currency;
   }
   price = price * quantity;
   return parseInt(price).toLocaleString() + global_currency;
}

function common_price_after_quantity( product){
   var price      = product.price      != undefined ? product.price : 0;
   var quantity   = product.quantity   == undefined ? product.product_quantity_count : product.quantity;
   price          = price * quantity;
   return parseInt(price).toLocaleString() + global_currency;
}

/**
 * @access FOR ORDER STORE
 */
function common_price_after_discount_and_quantity_from_group_order( product ){
   var price            = product.order_group_product_price;
   var quantity         = product.order_group_product_quantity_count;
   var discount_percent = product.order_group_product_discount_percent;
   price = price - ( price * ( discount_percent / 100 ) );
   price = price * quantity;
   return parseInt(price).toLocaleString() + global_currency;
}

function common_price_after_quantity_from_group_order( product){
   var price      = product.order_group_product_price;
   var quantity   = product.order_group_product_quantity_count;
   price          = price * quantity;
   return parseInt(price).toLocaleString() + global_currency;
}




function add_extra_space_order_time_shipping_time(shipping_time){
   var [ start, end ] = shipping_time.split('-');
   return start + ' - ' + end;
}

function common_price_show_currency(price){ return parseInt(price).toLocaleString() + global_currency; }



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
      case 'Monday': return 'Mon'
      case 'Tuesday': return 'Tue';
      case 'Wednesday': return 'Wed';
      case 'Thursday': return 'Thu';
      case 'Friday': return 'Fri';
      case 'Saturday': return 'Sat';
      case 'Sunday': return 'Sun';
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


function gotoPageUserPrivacyPolicy(){
   window.location.href = window.watergo_domain + 'user/?user_page=user-privacy-policy&appt=N';
}

function gotoHome(){
   window.location.href = window.watergo_domain + 'home';
}


function gotoPageStoreTermConditions(){
   window.location.href = window.watergo_domain + 'store/?store_page=store-term-conditions&appt=N';   
}
function gotoPageStorePrivacyPolicy(){
   window.location.href = window.watergo_domain + 'store/?store_page=store-privacy-policy&appt=N';   
}

function has_discount( product ){
   if( product.has_discount == null || parseInt(product.has_discount) == 0 ) return false;
   if( product.has_discount == 1 && parseInt( product.discount_percent ) == 0 ) return false;

   var currentDate = new Date();
   var discount_from = new Date(product.discount_from);
   var discount_to   = new Date(product.discount_to);
   currentDate.setHours(0,0,0,0);
   discount_from.setHours(0,0,0,0);
   discount_to.setHours(0,0,0,0);
   currentDate    = parseInt(currentDate.getTime() / 1000);
   discount_from  = parseInt(discount_from.getTime() / 1000);
   discount_to    = parseInt(discount_to.getTime() / 1000);
   if ( currentDate >= discount_from && currentDate <= discount_to ) {
      return true;
   }else{
      return false;
   }
}

function has_gift( product ){
   if( product.has_gift == null || product.has_gift == 0 ) return false;

   var currentDate = new Date();
   var gift_from = new Date(product.gift_from);
   var gift_to   = new Date(product.gift_to);
   currentDate.setHours(0,0,0,0);
   gift_from.setHours(0,0,0,0);
   gift_to.setHours(0,0,0,0);
   currentDate    = parseInt(currentDate.getTime() / 1000);
   gift_from  = parseInt(gift_from.getTime() / 1000);
   gift_to    = parseInt(gift_to.getTime() / 1000);
   if ( currentDate >= gift_from && currentDate <= gift_to ) {
      return true;
   }else{
      return false;
   }
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
   var day = date.getDate().toString().padStart(2, '0');
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
            
            if( product.has_discount != 0 ){
               gr_price.price_discount += ( product.price - ( product.price * ( product.discount_percent / 100)) ) * product.product_quantity_count;
            }else{
               gr_price.price_discount += product.price * product.product_quantity_count;
            }
            gr_price.price += product.price * product.product_quantity_count;
         }
      });

   });
   
   var _final_price = null;

   if( gr_price.price != gr_price.price_discount){
      _final_price = gr_price.price.toLocaleString() + global_currency;
   }

   return {
      price: _final_price,
      price_discount: gr_price.price_discount.toLocaleString() + global_currency
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

function getTimeDifference(datetimeInput) {
   // if (datetimeInput != undefined && datetimeInput && typeof datetimeInput === "string" && datetimeInput.trim() !== "") {
   if (datetimeInput != undefined ) {
   
      var unpack = datetimeInput.split(' ');
      var [year, month, day] = unpack[0].split('-');
      var [hour, min, sec] = unpack[1].split(':');
      var datetime = new Date(year, month - 1, day, hour, min, sec); // Month is 0-indexed in Date constructor

      var currentTimestamp = Date.now(); // Current timestamp in milliseconds
      var messageTimestamp = datetime.getTime(); // Provided timestamp in milliseconds

      var timeDifferenceInMs = currentTimestamp - messageTimestamp;
      var timeDifferenceInSeconds = Math.floor(timeDifferenceInMs / 1000);

      var seconds = timeDifferenceInSeconds;
      var minutes = Math.floor(seconds / 60);
      var hours = Math.floor(minutes / 60);
      var days = Math.floor(hours / 24);

      if (days > 0) {
         return days + (days === 1 ? " day ago" : " days ago");
      } else if (hours > 0) {
         return hours + (hours === 1 ? " hour ago" : " hours ago");
      } else if (minutes > 0) {
         return minutes + (minutes === 1 ? " min ago" : " mins ago");
      } else {
         return seconds + (seconds === 1 ? " second ago" : " seconds ago");
      }
   }
   return '';
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
   if( order_type == 'once_date_time' || order_type == 'once_immediately') return 'Once';
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
   window.location.href = window.watergo_domain + 'store/?store_page=store-detail&store_id='+ store_id +'&appt=N';
}
function gotoCart(){
   window.location.href = window.watergo_domain + 'cart/?appt=N';
}
function goBack(){ window.location.href = '?appt=X'; }
// function goBack() {
//   var newURL = window.location.href.split('?')[0] + '?appt=X';
//   window.history.pushState({}, '', newURL);
// }
// function goBack() {
//   window.history.back();
// }
function goBackRefresh(){ window.location.href = '?appt=X&data=refresh'; }

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

/**
 * @access REVIEWS
 */
// function gotoReview(review_page, related_id){
//    window.location.href = window.watergo_domain + 'review/?review_page=' + review_page +'&related_id=' + related_id + '&appt=N';
// }

function gotoReviewIndex( store_id){
   window.location.href = window.watergo_domain +  'review/?review_page=review-index&store_id=' + store_id + '&appt=N';
}

function gotoAddReview(store_id, order_id ){
   window.location.href = window.watergo_domain + 'review/?review_page=review-store&event=add&order_id=' + order_id + '&store_id='+ store_id +'&appt=N';
}
function gotoEditReview( review_id ){
   window.location.href = window.watergo_domain + 'review/?review_page=review-store&event=edit&review_id=' + review_id + '&appt=N';
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
 * @param [ from_user + to_user + product_id ] for chat messenger || conversation for chat-index page
 */
function gotoChatMessenger( args ){

   if( args != undefined || args != null ){
      var product_id          = args.product_id != undefined ? parseInt(args.product_id) : null;
      var from_user           = args.from_user != undefined ? parseInt(args.from_user) : null;
      var to_user             = args.to_user != undefined ? parseInt(args.to_user) : null;
      var document_id         = args.document_id != undefined ? parseInt(args.document_id) : null;

      // chat_to_user | chat_to_store
      var where_app = args.where_app != undefined ? String( args.where_app ) : null;

      var url =  window.watergo_domain + 'chat/?chat_page=chat-messenger';

      if( product_id != null ){url += '&product_id=' + product_id;}
      if( from_user != null ){ url += '&from_user=' + from_user; }
      if( to_user != null ){ url += '&to_user=' + to_user; }
      if( document_id != null ){ url += '&document_id=' + document_id; }
      if( where_app != null ){ url += '&where_app=' + where_app; }

      window.location.href = url + '&appt=N';   
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
   var url = window.watergo_domain + 'product/?product_page=product-store-view&appt=N';

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

/**
 * @access TAB STORE
 */

function gotoPageStoreEdit(){
   window.location.href = window.watergo_domain + 'store/?store_page=store-edit&appt=N';
}

function gotoPageStoreSettings(){
   window.location.href = window.watergo_domain + 'store/?store_page=store-settings&appt=N';
}

function gotoPageStoreAdverstising(){
   window.location.href = window.watergo_domain + 'store/?store_page=store-adverstising&appt=N';
}

/**
 * @access DELIVERY ADDRESS
 */
function gotoDeliveryAddress( order_select = false ){
   if( order_select == true){
      window.location.href = window.watergo_domain + 'delivery-address/?delivery_address_page=delivery-address-index&is_order_select=1&appt=N';
   }else{
      window.location.href = window.watergo_domain + 'delivery-address/?delivery_address_page=delivery-address-index&appt=N';
   }
}
function gotoDeliveryAddressEdit( delivery_id ){
   window.location.href = window.watergo_domain + 'delivery-address/?delivery_address_page=delivery-address-edit&delivery_id=' + delivery_id +'&appt=N';
}
function gotoDeliveryAddressAdd(){
   window.location.href = window.watergo_domain + 'delivery-address/?delivery_address_page=delivery-address-add&appt=N';
}

/**
 * @access RE-ORDER => page order_page=order-product
 */

function gotoPageReOrder( order_id ){

   window.location.href = window.watergo_domain + 'order/?order_page=order-product&re_order_id=' + order_id + '&appt=N';
}


