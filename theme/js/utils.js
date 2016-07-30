(function ($) {

$('#navbar').find('a').each(function () {

  var $a   = $(this);
  var href = $(this).attr('href');

  if (href.charAt(0) === "/") {
    $a.attr('href', "http://localhost/historymiami/" + href);
  }
  console.log()
})

})(jQuery);