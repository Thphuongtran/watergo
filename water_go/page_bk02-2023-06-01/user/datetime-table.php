<div class='date-table' v-for="(item, index ) in getCurrentMonthData" :key='index'>
   <div class='date-table-head'>
      <div class='heading'>
         {{ item.month }}, {{item.year}}
      </div>
      <div class='date-actions'>
         <button class='prevMonth' @click="prevMonth" :disabled="isPrevMonthDisabled"></button>
         <button class='nextMonth' @click="nextMonth"></button>
      </div>
   </div>
   <div class='date-table-contents'>
      <table>
         <tr>
            <th v-for="day in daysOfWeek" :key="day">{{ day }}</th>
         </tr>
         <tr v-for="(week, index) in item.weeks" :key="index">
            <td @click='buttonTableDatePicker(item.year, item.month, dayOfWeek.day )' :class='dayOfWeek.active == true ? "active" : ""' v-for="dayOfWeek in week" :key="dayOfWeek.day">
               <span>{{ dayOfWeek.day }}</span>
            </td>
         </tr>
      </table>
   </div>
   <div class='btn-getdate'>
      <button @click='buttonApplyDate' class='button'>Apply</button>
   </div>
</div>
