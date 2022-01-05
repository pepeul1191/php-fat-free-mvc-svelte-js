<script>
  import { onMount, tick } from 'svelte';
  export const months = ['Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre'];
  export const days = ['Lun','Mar','Mie','Jue','Vie','Sab','Dom'];
  let calendarDays = [];
  export let date;
  export let selectedDays = [];
  let labelMonth;
  let month;
  let year;
  let actualDay;

  onMount(async () => {
    date = new Date();
    actualDay = date.getDay();
    calendarDays = await fillCalendarDays();
    updateLabelMonthYear();
  });

  const updateLabelMonthYear = () => {
    labelMonth = `${months[date.getMonth()]} ${date.getFullYear()}`;
  };

  const fillCalendarDays = () => {
    var resp = [];
    var first = true;
    var baseDate = date;
    month = date.getMonth();
    year = date.getFullYear();
    date.setDate(1); // go to first day of month
    while(date.getMonth() === month){
      //var t = `${date.getDay()} - ${month} - ${year}`;
      var num = date.getDay();
      var tmp = {};
      var day = date.getDate();
      tmp['day'] = day;
      // date format
      if(day < 10){  
        if(month < 9){
          tmp['date'] = year + '-0' + (month + 1) + '-0' + day;
        }else{
          tmp['date'] = year + '-' + (month + 1) + '-0' + day;
        }
      }else{  
        if(month < 9){
          tmp['date'] = year + '-0' + (month + 1) + '-' + day;
        }else{
          tmp['date'] = year + '-' + (month + 1) + '-' + day;
        }
      }
      // sytles
      tmp['margin'] = ''; 
      if (first) {
        if (num == 0) {
          tmp['margin'] = (6 * 14.28) + "%";
        } else {
          tmp['margin'] = ((num - 1) * 14.28) + "%";
        }
      }
      first = false;
      // check if selected
      if(selectedDays.includes(tmp['date'])){
        tmp['wasActive'] = true;
      }else{
        tmp['wasActive'] = false;
      }
      resp.push(tmp);
      // next day
      date.setDate(date.getDate() + 1);
    }
    date = baseDate;
    // console.log(resp)
    date.setMonth(date.getMonth()-1);
    return resp;
  };

  const nextMonth = async () => {   
    date.setMonth(date.getMonth() + 1);
    calendarDays = await fillCalendarDays();
    //checkDaysSelected();
    updateLabelMonthYear();
  };

  const prevMonth = async () => {
    date.setMonth(date.getMonth() - 1);
    calendarDays = await fillCalendarDays();
    //checkDaysSelected();
    updateLabelMonthYear();
  };

  const clickDay = async (event) => {
    var clickedDay = null;
    var targetDiv = null;
    if(event.target.tagName == 'SPAN'){
      targetDiv = event.target.parentNode;
    }else if(event.target.tagName == 'DIV'){
      targetDiv = event.target;
    }
    clickedDay = targetDiv.getAttribute('date');
    if(selectedDays.includes(clickedDay)){
      var index = selectedDays.indexOf(clickedDay);
      if (index !== -1) {
        selectedDays.splice(index, 1);
      }
    }else{
      selectedDays.push(clickedDay);
    }
    calendarDays = await fillCalendarDays();
    // console.log(selectedDays)
  };
</script>

<div id="calendarioDemo" class="v-cal">
  <div class="vcal-header">
    <button class="vcal-btn" data-calendar-toggle="previous" on:click="{prevMonth}">
      <i class="fa fa-chevron-left" aria-hidden="true"></i>
    </button>
    <div class="vcal-header__label" data-calendar-label="month">
      {labelMonth}
    </div>
    <button class="vcal-btn" data-calendar-toggle="next" on:click="{nextMonth}">
      <i class="fa fa-chevron-right" aria-hidden="true"></i>
    </button>
  </div>
  <div class="vcal-week">
    {#each days as day}
      <span>{day}</span>
    {/each}
  </div>
  <div class="vcal-body" data-calendar-area="month" id="bodyCalendar">
    {#each calendarDays as day}
      <div class="{(day['wasActive'] == true) ? 'vcal-date vcal-date--active v-active b' : 'vcal-date vcal-date--active a'}" style="margin-left:{day['margin']};" date="{day['date']}" on:click="{clickDay}">
        <span>{day['day']}</span>
      </div>
    {/each}
  </div>
</div>
<br>
<p class="demo-picked">
  Date picked:
  <span data-calendar-label="picked"></span>
</p>

<style>
  :root {
    --vcal-bg-color: #fff;
    --vcal-border-radius: 0;
    --vcal-border-color: #e7e9ed;
    --vcal-today-bg-color: #10989E;
    --vcal-today-color: #fff;
    --vcal-selected-bg-color: #E7E9ED;
    --vcal-selected-color: #333;
  }

  .v-cal *, .v-cal *:before, .v-cal *:after {
    box-sizing: border-box;
  }

  .v-cal {
    border-radius: var(--vcal-border-radius);
    border: solid 1px var(--vcal-border-color);
    box-shadow: 0 4px 22px 0 rgba(0, 0, 0, 0.05);
    margin: 0 auto;
    overflow: hidden;
    width: 100%;
  }

  .v-cal .vcal-btn {
    -moz-user-select: none;
    -ms-user-select: none;
    -webkit-appearance: button;
    background: none;
    border: 0;
    color: inherit;
    cursor: pointer;
    font: inherit;
    line-height: normal;
    min-width: 27px;
    outline: none;
    overflow: visible;
    padding: 0;
    text-align: center;
    /*
    &:active {
      border-radius: var(--vcal-border-radius);
      box-shadow: 0 0 0 2px rgba(var(--vcal-today-bg-color), 0.1)
    }
    */
  }

  .v-cal .vcal-header {
    align-items: center;
    display: flex;
    padding: 1.2rem 1.4rem;
  }

  .v-cal .vcal-header__label {
    font-weight: bold;
    text-align: center;
    width: 100%;
  }

  .v-cal .vcal-week {
    background-color: var(--vcal-selected-bg-color);
    display: flex;
    flex-wrap: wrap;
  }

  .v-cal .vcal-week span {
    flex-direction: column;
    flex: 0 0 14.28%;
    font-size: 11px;
    font-weight: bold;
    max-width: 14.28%;
    padding: 10px;
    text-align: center;
    text-transform: uppercase;
  }

  .v-cal .vcal-body {
    background-color: rgba(var(--vcal-selected-bg-color), 0.3);
    display: flex;
    flex-wrap: wrap;
  }

  .v-cal .vcal-date {
    align-items: center;
    background-color: #fff;
    border-radius: var(--vcal-border-radius);
    display: flex;
    flex-direction: column;
    flex: 0 0 14.28%;
    max-width: 14.28%;
    padding: 8px;
  }

  .v-cal .vcal-date--active {
    cursor: pointer;
  }

  .v-cal .vcal-date--today {
    background-color: var(--vcal-today-bg-color);
    color: var(--vcal-today-color);
  }

  .v-cal .vcal-date--selected {
    background-color: var(--vcal-selected-bg-color);
    color: var(--vcal-selected-color);
  }

  .v-cal .vcal-date--disabled {
    border-radius: 0;
    cursor: not-allowed;
    opacity: 0.5;
  }
</style>