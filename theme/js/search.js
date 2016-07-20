(function ($) {

$search = $("#global_search");
$modal  = $('#search-model');
$input  = $("#search-input");

$input.typeahead({
  items: 20,
  afterSelect: function (item) {
    window.location.href = item.url;
  },
  displayText: function (item) {
    // Remove HTML Entities
    var title = $('<textarea />').html(item.title).text();
    return title;
  },
  source: function (query, process) {

    var base = (window.location.hostname === "localhost" ? "/historymiami/" : '/');
    var url = base + "?json=get_search_results&search=" + query;

    $.getJSON(url, function (data) {
      var posts = data.posts || [];
      process(posts);
    });
  }
});

$search.click(function (e) {
  e.preventDefault();
  $modal.modal('show');
});


})(jQuery);