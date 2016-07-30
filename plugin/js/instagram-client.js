/*
 * https://instagram.com/oauth/authorize/?client_id=af5a51b213344fb6a11574d61f95955d&redirect_uri=http://localhost&response_type=token&scope=public_content
 */

(function ($) {

var sidebarWidth  = $(".sidebar-primary").width();
var contentHeight = $(".content-sidebar-wrap").height();
var imageLimit    = $('body').width() > 640 ? Math.floor(contentHeight / sidebarWidth): 6;

var options = {
  get: 'user',
  userId: '485250559',
  clientId: 'af5a51b213344fb6a11574d61f95955d',
  accessToken: '447873232.af5a51b.433b5866a49e45039be769f70557e171',
  template: '<div class="col-md-12 col-xs-6"><figure><a target="_blank" href="{{link}}"><img class="img-responsive" src="{{image}}" /><p>{{caption}}</p></a></figure></div>',
  resolution: 'standard_resolution',
  limit: imageLimit,
  sortBy: 'none'

};

var feed = new Instafeed(options);

feed.run();


})(jQuery);