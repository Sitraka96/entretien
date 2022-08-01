$(function () {
  $("#login").on("submit", function (e) {
    e.preventDefault();
    var params = $(this).serialize();

    $.post("/user/check", params, function (response) {
      if (response == "ok") {
        window.location.href = "/Accueil";
      } else {
        var txt = "Verifier bien votre identifiant ou votre mot de passe !",
          c =
            '<div class="alert alert-danger alert-dismissible fade show" role="alert">' +
            '<p class="text-center my-0">' +
            txt +
            "</p>" +
            '<button type="button" class="close" data-dismiss="alert" aria-label="Close">' +
            '<span aria-hidden="true">&times;</span>' +
            "</button>" +
            "</div>";
        $("#feedback").html(c);
      }
    });
  });
});
