$(function () {
  $.getScript(
    "/assets/js/src/entretien/view.js",
    function (script, textStatus, jqXHR) {
      if (textStatus == "success") {
        $pageToPrint = document.querySelector("#ticket-section");
        $pageHead = document.querySelector("head");
        printIt($pageToPrint);
      }
    }
  );
});
