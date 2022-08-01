$(function () {
  $("#type_user").prop("selectedIndex", -1);
  $("input[type=file]").change(function (e) {
    $(this).next(".custom-file-label").text(e.target.files[0].name);
  });
  $(".btn-edit").on("click", function () {
    var rw = $(this).parent().parent(),
      type = rw.data("type"),
      i = rw.data("row"),
      user = $("#u" + i).text();
    $("#username").val(user);
    $("#nom").val($("#n" + i).text());
    $("#prenom").val($("#p" + i).text());
    $("#email").val($("#e" + i).text());
    $("#type_user option[value=" + type + "]").prop("selected", true);
    $("#opk").val(user);
    $("#form_type").val("edit");
  });
  $(".btn-del").on("click", function () {
    var rw = $(this).parent().parent(),
      i = rw.data("row"),
      user = $("#u" + i).text();
    (nom = $("#n" + i).text()), (prenom = $("#p" + i).text());
    var c =
      "<b>Suppression de l'utilisateur</b><br/>" +
      "Nom d'utilisateur : " +
      "<em>" +
      user +
      "</em><br/>Nom et prénom(s) : <b>" +
      nom +
      "</b> " +
      prenom;
    $("#c_txt").html(c);
    $("#m_id").val(user);
    $("#cmodal").modal("show");
  });
  $("#cmodal").on("hidden.bs.modal", function (e) {
    $("#c_txt").html("");
    $("#frm_confirm input").val("");
  });

  $("#frm_confirm").on("submit", function (e) {
    e.preventDefault();
    $(this).prop("action", "/Utilisateurs/delete");
    this.submit();
  });

  function getView(index, ei) {
    index++;
    return (
      "<tr>" +
      '<th scope="row" data-type="' +
      ei.TU_id +
      '">' +
      index +
      "</th>" +
      "<td>" +
      ei.username +
      "</td>" +
      "<td>" +
      ei.nom +
      "</td>" +
      "<td>" +
      ei.prenom +
      "</td>" +
      "<td>" +
      ei.email +
      "</td>" +
      "<td>" +
      ei.type +
      "</td>" +
      '<td><button class="btn btn-sm btn-outline-warning btn-edit"><svg width="20" height="20"><use xlink:href="/assets/svg/scrud.svg#edit"></svg></button></td>' +
      '<td><button class="btn btn-sm btn-outline-danger btn-del"><svg width="20" height="20"><use xlink:href="/assets/svg/scrud.svg#delete"></svg></button></td>' +
      "</tr>"
    );
  }

  function init_form() {
    $("input").not(":hidden").val("");
    $("#type_user").prop("selectedIndex", -1);
    $("#form_type").val("insert");
    $("#opk").val("");
  }

  $("#btn-insert").on("click", function () {
    init_form();
  });
});
