<div id='app'>
  <div v-if='!loading'>
    <div class='report-page-container'>
      <?php get_template_part('pages/business/report/report-appBar') ?>
      <?php get_template_part('pages/business/components/filterBar') ?>
      <div class='date-filter'>
        <span
          v-for='(item, index) in dateFilterData'
          :key='index'
          :class='item.active ? "active" : ""'
        >{{ item.day }}</span>
      </div>
      <div class='report-page-content'>
        <div>
          <div>
            <span>SOLD:</span>
            <span>{{ reportData.sold }}</span>
            <span>Orders</span>
          </div>
          <div>
            <svg v-if='reportData.soldDifference > 0' xmlns="http://www.w3.org/2000/svg" width="16" height="17" viewBox="0 0 16 17" fill="none">
              <path d="M8.77815 0.292892C8.38763 -0.0976315 7.75446 -0.0976315 7.36394 0.292892L0.999977 6.65685C0.609453 7.04738 0.609453 7.68054 0.999977 8.07107C1.3905 8.46159 2.02367 8.46159 2.41419 8.07107L8.07104 2.41421L13.7279 8.07107C14.1184 8.46159 14.7516 8.46159 15.1421 8.07107C15.5326 7.68054 15.5326 7.04738 15.1421 6.65685L8.77815 0.292892ZM9.07104 17V1H7.07104V17H9.07104Z" fill="#13E800"/>
            </svg>
            <svg v-if='reportData.soldDifference < 0' xmlns="http://www.w3.org/2000/svg" width="16" height="17" viewBox="0 0 16 17" fill="none">
              <path d="M8.77815 16.7071C8.38763 17.0976 7.75446 17.0976 7.36394 16.7071L0.999977 10.3431C0.609453 9.95262 0.609453 9.31946 0.999977 8.92893C1.3905 8.53841 2.02367 8.53841 2.41419 8.92893L8.07104 14.5858L13.7279 8.92893C14.1184 8.53841 14.7516 8.53841 15.1421 8.92893C15.5326 9.31946 15.5326 9.95262 15.1421 10.3431L8.77815 16.7071ZM7.07104 16V0H9.07104V16H7.07104Z" fill="#FF5656"/>
            </svg>
            <span :class='reportData.soldDifference >= 0 ? "up" : "down"'>{{ Math.abs(reportData.soldDifference) }}</span>
          </div>
        </div>
        <div>
          <div>
            <span>CANCELED:</span>
            <span>{{ reportData.canceled }}</span>
            <span>Orders</span>
          </div>
          <div>
            <svg v-if='reportData.canceledDifference > 0' xmlns="http://www.w3.org/2000/svg" width="16" height="17" viewBox="0 0 16 17" fill="none">
              <path d="M8.77815 0.292892C8.38763 -0.0976315 7.75446 -0.0976315 7.36394 0.292892L0.999977 6.65685C0.609453 7.04738 0.609453 7.68054 0.999977 8.07107C1.3905 8.46159 2.02367 8.46159 2.41419 8.07107L8.07104 2.41421L13.7279 8.07107C14.1184 8.46159 14.7516 8.46159 15.1421 8.07107C15.5326 7.68054 15.5326 7.04738 15.1421 6.65685L8.77815 0.292892ZM9.07104 17V1H7.07104V17H9.07104Z" fill="#13E800"/>
            </svg>
            <svg v-if='reportData.canceledDifference < 0' xmlns="http://www.w3.org/2000/svg" width="16" height="17" viewBox="0 0 16 17" fill="none">
              <path d="M8.77815 16.7071C8.38763 17.0976 7.75446 17.0976 7.36394 16.7071L0.999977 10.3431C0.609453 9.95262 0.609453 9.31946 0.999977 8.92893C1.3905 8.53841 2.02367 8.53841 2.41419 8.92893L8.07104 14.5858L13.7279 8.92893C14.1184 8.53841 14.7516 8.53841 15.1421 8.92893C15.5326 9.31946 15.5326 9.95262 15.1421 10.3431L8.77815 16.7071ZM7.07104 16V0H9.07104V16H7.07104Z" fill="#FF5656"/>
            </svg>
            <span :class='reportData.canceledDifference >= 0 ? "up" : "down"'>{{ Math.abs(reportData.canceledDifference) }}</span>
          </div>
        </div>
        <div>
          <span>TOTAL PROFIT:</span>
          <span>{{ priceFormat(reportData.totalProfit) }}</span>
        </div>
      </div>
    </div>


    <!-- overlay popup -->
    <!-- <div
      v-if='isOpenDatePickerPopup'
      class='overlay-popup'
      @click.self="setOpenDatePickerPopup"
    >
      <div v-if='isOpenDatePickerPopup' class='date-picker-popup'>
        <div class='date-table' v-for="(item, index ) in getCurrentMonthData" :key='index'>
          <div class='date-table-head'>
            <div class='heading'>{{ item.month }}, {{ item.year }}</div>
            <div class='date-actions'>
              <button class='prevMonth' @click='handlePrevMonth'></button>
              <button class='nextMonth' @click='handleNextMonth'></button>
            </div>
          </div>
          <div class='date-table-contents'>
            <table>
              <tr>
                <th v-for="day in calendarData.daysOfWeek" :key="day">{{ day }}</th>
              </tr>
              <tr v-for="(week, index) in item.weeks" :key="index">
                <td :class='dayOfWeek.active == true ? "active" : ""' v-for="dayOfWeek in week" :key="dayOfWeek.day">
                    <span>{{ dayOfWeek.day }}</span>
                </td>
              </tr>
            </table>
          </div>
          <div class='btn-getdate'>
            <button class='button'>Apply</button>
          </div>
        </div>
      </div>
    </div> -->
    <!-- end overlay popup -->
  </div>


  <div v-if='loading'>
    <div class='progress-center'>
      <div class='progress-container enabled'><progress class='progress-circular enabled' ></progress></div>
    </div>
  </div>
</div>
<script type='module'>
  const { createApp } = Vue;

  createApp({
    data() {
      return {
        loading: false,
        pageTitle: 'Report',
        message_count: 0,
        notification_count: 0,
        // TODO implement button dateTime in appBar
        // isOpenDatePickerPopup: false,
        calendarData: {
          monthData: ['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'],
          daysOfWeek: ['Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat', 'Sun'],
          currentDate: new Date(),
          days: new Date().getDate(),
          months: new Date().getMonth(),
          years: new Date().getFullYear(),
          isPrevMonthDisabled: false,
          calendar: null,
        },
        header_filter: [
          { label: 'Day', active: true, count: 0 },
          { label: 'Week', active: false, count: 0 },
          { label: 'Month', active: false, count: 0 },
          { label: 'Year', active: false, count: 0 },
        ],
        filterDateData: [],
        reportData: {
          sold: 435,
          soldDifference: 50,
          canceled: 35,
          canceledDifference: -10,
          totalProfit: 40000000,
        }
      }
    },
    methods: {
      gotoChat() {
        window.gotoChat();
      },
      gotoNotificationIndex() {
        window.gotoNotificationIndex();
      },

      // setOpenDatePickerPopup() {
      //   this.isOpenDatePickerPopup = !this.isOpenDatePickerPopup;
      // },
      // generateCalendar(year, month) {
      //   const lastDateOfMonth = new Date(year, month + 1, 0).getDate();

      //   const firstDayOfMonth = new Date(year, month, 1).getDay();
      //   const transformFirstDayOfMonth = (firstDayOfMonth === 0 ? 7 : firstDayOfMonth) - 1;

      //   let date = 1;
      //   const weeks = [];
      //   const numWeeks = Math.ceil((lastDateOfMonth + transformFirstDayOfMonth) / 7);
      //   for (let i = 0; i < numWeeks; i++) {
      //     const week = [];
      //     for (let j = 0; j < 7; j++) {
      //         if (i == 0 && j < transformFirstDayOfMonth || date > lastDateOfMonth) {
      //           week.push({ day: '' });
      //         } else {
      //           const isCurrentDate = month === this.calendarData.currentDate.getMonth() && date === this.calendarData.currentDate.getDate();
      //           week.push({ day: date, active: isCurrentDate });
      //           date++;
      //         }
      //     }
      //     weeks.push(week);
      //   }
      //   return {
      //     year,
      //     month: this.calendarData.monthData[month],
      //     weeks: weeks
      //   };
      // },
      // handleNextMonth() {
      //   if (this.calendarData.months >= 11) {
      //     this.calendarData.months = 0;
      //     this.calendarData.years = this.calendarData.years + 1;
      //   }

      //   this.calendarData.months = this.calendarData.months + 1;
      // },
      // handlePrevMonth() {
      //   if (this.calendarData.months <= 0) {
      //     this.calendarData.months = 11;
      //     this.calendarData.years = this.calendarData.years - 1;
      //   }
      //   this.calendarData.months = this.calendarData.months - 1;
      // },
      select_header_filter(tabName) {
        this.header_filter.some((item) => {
          item.active = false;
          if (tabName === item.label) {
            item.active = true;
          }
        })
      },
      formatMonthAndYear(month, year) {
        const monthsData = this.calendarData.monthData[month];
        return monthsData.substring(0, 3) + ', ' + year;
      },
      dayFilterData(day, month, year) {
        const firstDayOfWeekInMonth = new Date(year, month, 1).getDay();
        const lastDateInMonth = new Date(year, month + 1, 0).getDate();
        return Array.from({length: lastDateInMonth}, (_, i) => ({ day: i + 1, active: i + 1 === day }));
      },
      weekFilterData(day, month, year) {
        const firstDayOfWeekInMonth = new Date(year, month, 1).getDay();
        const lastDateInMonth = new Date(year, month + 1, 0).getDate();
        const numberOfWeek = Math.ceil(lastDateInMonth / 7);
        const weeks = Array.from(Array(numberOfWeek - 1).keys());

        const startAndEndWeek = weeks.reduce((data, item) => {
          const startWeek = data[data.length -1].endWeek + 1;
          const endWeek = data[data.length -1].endWeek + 1 + 6;
          data.push({startWeek, endWeek});
          return data;
        }, [{startWeek: 1, endWeek: 7}]);
        
        const result = startAndEndWeek.reduce((data, item) => {
          const monthOfWeek = month + 1 < 10 ? `0${month + 1}` : `${month + 1}`
          const startWeek = item.startWeek < 10 ? `0${item.startWeek}` : `${item.startWeek}`;
          let endWeek = item.endWeek < 10 ? `0${item.endWeek}` : `${item.endWeek}`;
          if (item.endWeek > lastDateInMonth) {
            endWeek = 31;
          }
          const dayWeek = `${startWeek}/${monthOfWeek} - ${endWeek}/${monthOfWeek}`;
          const isActive = day <= item.endWeek && day >= item.startWeek ? true : false;
          data.push({
            day: dayWeek,
            active: isActive,
          });
          return data
        }, []);

        return result;
      },
      monthFilterData(month, year) {
        return Array.from({length: 11}, (_, i) => ({ day: this.formatMonthAndYear(i, year), active: i === month }));
      },
      yearFilterData(year) {
        const years = [2023, 2024];
        return years.map((item) => ({
          day: item,
          active: item === year,
        }));
      },
      priceFormat(price) {
        return price === 0 ? 0 + "đ" : parseInt(price).toLocaleString('vi-VN') + "đ";
      }
    },
    computed: {
      appBarDateTitle() {
        const months = this.calendarData.months;
        const years = this.calendarData.years;
        const tabHeaderSelected = this.header_filter.find((item) => item.active);
        if (tabHeaderSelected.label === 'Month') {
          return `${years}`;
        }

        if (tabHeaderSelected.label === 'Year') {
          return "";
        }
        return this.formatMonthAndYear(months, years);
      },
      dateFilterData() {
        const days = this.calendarData.days;
        const months = this.calendarData.months;
        const years = this.calendarData.years;
        const tabHeaderSelected = this.header_filter.find((item) => item.active);

        if (tabHeaderSelected.label === 'Week') {
          const data = this.weekFilterData(days, months, years);
          return data;
        }

        if (tabHeaderSelected.label === 'Month') {
          return this.monthFilterData(months, years);
        }

        if (tabHeaderSelected.label === 'Year') {
          return this.yearFilterData(years);
        }

        
        const data = this.dayFilterData(days, months, years);
        return data;
      }
      // getCurrentMonthData() {
      //   const currentMonths = this.calendarData.months;
      //   const currentYears = this.calendarData.years;
      //   const calendar = this.generateCalendar(currentYears, currentMonths);

      //   return {
      //     data: calendar,
      //   };
      // },
    },
    async create() {
      this.loading = true;
      this.loading = false;
    },
  }).mount('#app');
</script>

