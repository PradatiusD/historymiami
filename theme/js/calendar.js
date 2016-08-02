(function ($) {

function formatTime (unixTimestamp) {

  var timestamp = parseInt(unixTimestamp) * 1000;
  return new Date(timestamp);
}

var options = {
  header: {
    left: 'prev,next today',
    center: 'title',
    right: 'month,agendaWeek,agendaDay'
  },
  timezone: 'UTC',
  events: calendarData.map(function (calendarEvent) {

    calendarEvent.start = formatTime(calendarEvent.start);
    calendarEvent.end   = formatTime(calendarEvent.end);

    return calendarEvent;
  })
};


$('#calendar').fullCalendar(options);

})(jQuery);