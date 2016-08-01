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

console.log(options.events.length)


$('#calendar').fullCalendar(options);

})(jQuery);