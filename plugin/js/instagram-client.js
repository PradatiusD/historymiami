/*
 * https://instagram.com/oauth/authorize/?client_id=af5a51b213344fb6a11574d61f95955d&redirect_uri=http://localhost&response_type=token&scope=public_content
 */

(function ($) {

var sidebarWidth  = $(".sidebar-primary").width();
var contentHeight = $(".content-sidebar-wrap").height();
var imageLimit    = Math.floor(contentHeight / sidebarWidth);

var options = {
  get: 'user',
  userId: '485250559',
  clientId: 'af5a51b213344fb6a11574d61f95955d',
  accessToken: '447873232.af5a51b.433b5866a49e45039be769f70557e171',
  template: '<figure><a target="_blank" href="{{link}}"><img class="img-responsive" src="{{image}}" /><p>{{caption}}</p></a></figure>',
  resolution: 'standard_resolution',
  limit: imageLimit,
  sortBy: 'none'

};

var feed = new Instafeed(options);

feed.run();


})(jQuery);