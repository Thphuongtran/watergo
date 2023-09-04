var components_weekly_select = {
   template: `
      <div v-for="slot in slots" :key="slot.id">
         <div class="group-select-delivery-time group-select-delivery-time_parent">
            <div class="btn-wrapper-order">
               <select @change='btn_select_day($event, slot.day)' v-model="slot.day" class="btn_select_weekly_day btn-dropdown">
                  <option value='' selected disabled>{{ title_compact('Select date') }}</option>
                  <option :disabled="isDayDisabled(day_of_week, slot.id)" 
                     v-for="(day_of_week, indexWeek) in dayOfWeeks" 
                     :value="day_of_week" 
                     :key="indexWeek">
                     {{ get_title_weekly_compact(day_of_week) }}
                  </option>
               </select>
            </div>
            <div class="btn-wrapper-order">
               <select v-model="slot.time" class="btn_select_weekly_time btn-dropdown">
                  <option value='' selected disabled>{{ title_compact('Select time') }}</option>
                  <option 
                     v-for="(hour, indexHour) in hourSelect" 
                     :value="hour.value" 
                     :key="indexHour">
                     {{ hour.label }}
                  </option>
               </select>
            </div>
         </div>
      </div>
   `,
   data(){
      return{
         dayOfWeeks: [ 'Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday', 'Sunday' ],

         hourSelect: [
            {hour: 7,  value: '7:00-8:00',   label: '7:00  -  8:00' },
            {hour: 8,  value: '8:00-9:00',   label: '8:00  -  9:00' },
            {hour: 9,  value: '9:00-10:00',  label: '9:00 -   10:00'},
            {hour: 10, value: '10:00-11:00', label: '10:00  -  11:00'},
            {hour: 11, value: '11:00-12:00', label: '11:00  -  12:00'},
            {hour: 12, value: '12:00-13:00', label: '12:00  -  13:00'},
            {hour: 13, value: '13:00-14:00', label: '13:00  -  14:00'},
            {hour: 14, value: '14:00-15:00', label: '14:00  -  15:00'},
            {hour: 15, value: '15:00-16:00', label: '15:00  -  16:00'},
            {hour: 16, value: '16:00-17:00', label: '16:00  -  17:00'},
            {hour: 17, value: '17:00-18:00', label: '17:00  -  18:00'},
            {hour: 18, value: '18:00-19:00', label: '18:00  -  19:00'},
            {hour: 19, value: '19:00-20:00', label: '19:00  -  20:00'},
            {hour: 20, value: '20:00-21:00', label: '20:00  -  21:00'},
         ],

         dateWeekAuto: [],
         max_dom: 7,
         html: '',
         
         slots: [],
      }
   },

   watch: {
      slots: {
         handler( slot ){
            this.$root.delivery_data.weekly = slot;
         },
         deep: true
      }
   },

   methods: {

      get_title_weekly_compact( title ){
         if( this.$root.get_locale == 'vi' ){
            if( title == 'Monday' ) return 'Thứ Hai';
            if( title == 'Tuesday' ) return 'Thứ Ba';
            if( title == 'Wednesday' ) return 'Thứ Tư';
            if( title == 'Thursday' ) return 'Thứ Năm';
            if( title == 'Friday' ) return 'Thứ Sáu';
            if( title == 'Saturday' ) return 'Thứ Bảy';
            if( title == 'Sunday' ) return 'Chủ Nhật';

         }else{
            return title;
         }
      },

      title_compact( title ){
         if( this.$root.get_locale == 'vi' ){
            if( title == 'Select date'){
               return 'Chọn ngày';
            }
            if( title == 'Select time'){
               return 'Chọn thời gian';
            }
         }
         return title;
      },

      btn_select_day(e, day){
         if( day != undefined ){
            this.slots.forEach( ( item, indexSlot ) => {
               if( item.day == day ) {
                  item.datetime = this.get_datetime( day );
               }
            });
         }
      },


      get_datetime( day_of_week ){
         var _find = this.dateWeekAuto.find( item => item.dayOfWeek == day_of_week );
         if( _find ){
            return _find.date;
         }else{
            return '';
         }
      },

      createWeekly( reset = false ){
         if( reset == false ){
            if( this.slots.length < this.max_dom ){
               const newSlot = {
                  id: this.slots.length,
                  day: this.get_datetime(this.slots.day),
                  time: '',
                  datetime: '',
               };
               this.slots.push(newSlot);
            }
         }else{
            this.slots = [];
            const newSlot = {
               id: 0,
               day: '',
               time: '',
               datetime: '',
            };
            this.slots.push(newSlot);
         }
      },

      isDayDisabled(selectedDay, slotIndex) {
         return this.slots.some((slot, index) => index !== slotIndex && slot.day === selectedDay);
      },

   },

   update(){
      this.dateWeekAuto = this.$root.dateWeekAuto;
   },

   created(){
      this.dateWeekAuto = this.$root.dateWeekAuto;
   },

   mounted(){
      this.dateWeekAuto = this.$root.dateWeekAuto;
      this.createWeekly(true);
   }

};
