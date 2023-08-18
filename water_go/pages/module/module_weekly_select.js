var components_weekly_select = {
   template: `
      <div v-html='html'></div>
   `,
   data(){
      return{
         dateWeekAuto: [],
         max_dom: 7,
         autoincrement: 0,
         html: ''
      }
   },

   methods: {

      createWeekly(){
         this.autoincrement = this.autoincrement + 1;
         if( this.autoincrement < this.max_dom ){
            this.html += `
            <div 
               class='group-select-delivery-time group-select-delivery-time_parent'
            >
               <div class='btn-wrapper-order'>
                  <select class='btn_select_weekly_day btn_select_weekly_day_parent btn-dropdown'>
                     <option value='' selected disabled>Select day</option>
                     <option value="Monday">Monday</option>
                     <option value="Tuesday">Tuesday</option>
                     <option value="Wednesday">Wednesday</option>
                     <option value="Thursday">Thursday</option>
                     <option value="Friday">Friday</option>
                     <option value="Saturday">Saturday</option>
                     <option value="Sunday">Sunday</option>
                  </select>
               </div>
               <div class='btn-wrapper-order'>
                  <select class='btn_select_weekly_time btn-dropdown'>
                     <option value='' selected disabled>Select time</option>
                     <option value='7:00-8:00'>7:00  -  8:00</option>
                     <option value='8:00-9:00'>8:00  -  9:00</option>
                     <option value='9:00-10:00'>9:00 -   10:00</option>
                     <option value='10:00-11:00'>10:00  -  11:00</option>
                     <option value='11:00-12:00'>11:00  -  12:00</option>
                     <option value='12:00-13:00'>12:00  -  13:00</option>
                     <option value='13:00-14:00'>13:00  -  14:00</option>
                     <option value='14:00-15:00'>14:00  -  15:00</option>
                     <option value='15:00-16:00'>15:00  -  16:00</option>
                     <option value='16:00-17:00'>16:00  -  17:00</option>
                     <option value='17:00-18:00'>17:00  -  18:00</option>
                     <option value='18:00-19:00'>18:00  -  19:00</option>
                     <option value='19:00-20:00'>19:00  -  20:00</option>
                     <option value='20:00-21:00'>20:00  -  21:00</option>
                  </select>
               </div>
            </div>`;
         }
      },

      onSelect(e){
         console.log(e);
      }

   },

   update(){
      this.dateWeekAuto = this.$root.dateWeekAuto;
   },

   created(){
      this.dateWeekAuto = this.$root.dateWeekAuto;
   },

   mounted(){
      this.dateWeekAuto = this.$root.dateWeekAuto;
      
      this.$el.addEventListener('change', (event) => {
         if (event.target.classList.contains('btn_select_weekly_day_parent')) {
            this.onSelect(event);
         }
      });

   }

};
