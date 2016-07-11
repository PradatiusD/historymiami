(function ($) {

var options = {
  header: {
    left: 'prev,next today',
    center: 'title',
    right: 'month,agendaWeek,agendaDay'
  },
  events: calendarData.map(function (calendarEvent) {

    calendarEvent.start = new Date(calendarEvent.start);
    calendarEvent.end   = new Date(calendarEvent.end);

    return calendarEvent;
  })
};


$('#calendar').fullCalendar(options);

})(jQuery);