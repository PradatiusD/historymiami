(function ($) {

$button = $("#hm-newsletter-btn");
$modal  = $("#newsletter-modal");

$button.click(function (e) {
  e.preventDefault();
  $modal.modal('show');
});


})(jQuery);