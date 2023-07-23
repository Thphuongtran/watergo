 function get_day_of_month(){
   var currentDate = new Date();
   var currentYear = currentDate.getFullYear();
   var currentMonth = currentDate.getMonth();
   var totalDays = this.getDaysInMonth(currentYear, currentMonth);

   for (let day = 1; day <= totalDays; day++) {
      var isActive = day === currentDate.getDate();
      this.day_of_month.push({ 
         isActive: isActive,
         datetime: day,
         value: day 
      });
   }
}

function get_week_of_month(){
   var currentDate = new Date();
   var currentYear = currentDate.getFullYear();
   var currentMonth = currentDate.getMonth();
   var totalDays = this.getDaysInMonth(currentYear, currentMonth);
   let weekStart = 1;

   while (weekStart <= totalDays) {
      var weekEnd = Math.min(weekStart + (7 - (new Date(currentYear, currentMonth, weekStart).getDay())), totalDays);
      var week_1 = `${this.formatDate_for_week(new Date(currentYear, currentMonth, weekStart))}`;
      var week_2 = `${this.formatDate_for_week(new Date(currentYear, currentMonth, weekEnd))}`;
      var isActive = weekStart <= currentDate.getDate() && currentDate.getDate() <= weekEnd;
      this.week_of_month.push({ 
         isActive: isActive,
         weekStart: week_1,
         weekEnd: week_2,
         value: week_1 + ' - ' + week_2
      });
      weekStart = weekEnd + 1;
   }
}

function get_month_of_year(){
   var currentDate = new Date();
   var shortMonths = ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'];
   var currentMonth = currentDate.getMonth();
   var currentYear = currentDate.getFullYear();

   function formatDate(date) {
      const year = date.getFullYear();
      const month = (date.getMonth() + 1).toString().padStart(2, '0');
      const day = date.getDate().toString().padStart(2, '0');
      return `${year}-${month}-${day}`;
   }

   for (let month = 0; month < 12; month++) {
      const firstDayOfMonth = new Date(currentYear, month, 1);
      const lastDayOfMonth = new Date(currentYear, month + 1, 0);
      var shortMonthName = shortMonths[month];
      var isActive = month === currentMonth;
      this.month_of_year.push({
         isActive: isActive,
         datetime: month + 1,
         dayStart: formatDate(firstDayOfMonth),
         dayEnd: formatDate(lastDayOfMonth),
         value: `${shortMonthName}, ${currentYear}`,
      });
   }
}

function getDaysInMonth(year, month) {
   return new Date(year, month + 1, 0).getDate();
}

function formatDate_for_week(date) {
   const day = date.getDate().toString().padStart(2, '0');
   const month = (date.getMonth() + 1).toString().padStart(2, '0');
   return `${day}/${month}`;
}


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