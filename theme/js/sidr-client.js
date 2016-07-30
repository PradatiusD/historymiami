(function ($) {

var $sidr = $('<div id="sidr"><ul></ul></div>');

function setSidrDropdownClickBehavior ($li) {
  $li.find('> a').append('<span class="fa fa-chevron-down"></span>');

  var $ul = $li.find('> ul');

  $ul.attr('class','submenu');
  $ul.hide();
  $li.find('> a').click(function (e) {
    e.preventDefault();
    $ul.slideToggle(400);
  });
}

$("#menu-primary-menu > li").each(function () {

  var $li = $(this).clone();

  var classes = $li.attr('class')

  if (classes.indexOf('dropdown') > -1) {
    setSidrDropdownClickBehavior($li);
  }

  if(classes.indexOf('social') > - 1) {
    var iconName = $li.find('i').attr('class').replace('fa fa-','');
    iconName = iconName.charAt(0).toUpperCase() + iconName.substring(1, iconName.length);

    if (iconName === "Search") {
      iconName = "Search HistoryMiami";
    } else {
      iconName = "HistoryMiami on "+ iconName;
    }

    $li.find('a').prepend(iconName + " ");
  }

  $sidr.find('> ul').append($li);
});

$('body').append($sidr);

$(document).ready(function () {
  $('#mobile-menu').sidr();  
})
})(jQuery);