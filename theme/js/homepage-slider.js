
(function ($) {

var isMobile = /Android|webOS|iPhone|iPad|iPod|BlackBerry|IEMobile|Opera Mini/i.test(navigator.userAgent);

var options = {
  loop: true,
  autoplay: 5000,
  duration: 900,
  onSlideChangeStart: function (swiper) {
    // var $slide = $('.swiper-slide-active');
    // $slide.addClass('')
  }
};

var slider = new Swiper('.swiper-container', options);

})(jQuery);