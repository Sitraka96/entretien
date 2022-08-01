$(function () {
  // alert("SDQ");
  $form = $("#search-form");
  $form.on("submit", function (event) {
    // event.preventDefault();
    $form.addClass("is-submitting disabled");
  });
});
