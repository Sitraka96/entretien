$(function () {
  var iEnCours =
      '<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>',
    sEnCours = iEnCours + '<span class="pl-2">En cours ...</span>';
  $("div.dropdown").on(
    "click",
    ".dropdown-menu button.dropdown-toggle",
    function (e) {
      if (!$(this).next().hasClass("show")) {
        $(this)
          .parents(".dropdown-menu")
          .first()
          .find(".show")
          .removeClass("show");
      }
      $(this).next(".dropdown-menu").toggleClass("show");
      $("div.dropdown.show").on("hidden.bs.dropdown", function (e) {
        $(".dropdown-submenus .show").removeClass("show");
      });
      return false;
    }
  );

  $("#cnp").on("click", ".dropdown-menu button.dropdown-item", function () {
    var item = $(this),
      nivt = item.text(),
      n = item.attr("n"),
      p = item.attr("p"),
      au = $("#cau").attr("sau");
    var params = { au: au, niv: n, gp: p, abd: $("#abandon").prop("checked") };
    $("#ddniv").html(sEnCours);
    $("#cei").html("");
    $.post(
      "/etudiant/getLsE",
      params,
      function (data) {
        var edit = data.edit,
          res = "",
          nbH = 0,
          nbF = 0,
          ls = data.list,
          nbE = ls.length;
        ls.forEach((item) => {
          if (item.sexe == "1") {
            nbH++;
          } else {
            nbF++;
          }
          res += getView(item, edit);
          setCM(item, data.type);
        });
        $("#ddniv").text(nivt);
        $("#ceih").html(
          '<em> Efféctif <span class="text-danger">d\'étudiant trouvé</span> : ' +
            nbE +
            ' (<span class="text-boys"> Homme : ' +
            nbH +
            '</span> , <span class="text-girls">Femme : ' +
            nbF +
            "</span> )</em>"
        );
        $("#cei").html(res);
      },
      "json"
    );
  });

  $("#cau button.dropdown-item").on("click", function () {
    $("#au_ico").addClass("fa fa-spinner fa-spin mr-2 text-primary");
    $("#ceih").html("<i>Efféctifs : ?</i>");
    $("#cei").html("");
    var aui = $(this).attr("ai"),
      aut = $(this).text();
    $.post(
      "/etudiant/check_niv",
      { id: aui },
      function (res) {
        var s = "";
        for (const i in res) {
          const item = res[i];
          s +=
            '<div class="dropdown-submenus">' +
            '<button class="dropdown-item dropdown-toggle">' +
            i +
            "</button>" +
            '<div class="dropdown-menu">';
          var v = "";
          if (item.length > 0) {
            for (const j in item) {
              const el = item[j];
              v +=
                '<button class="dropdown-item " n=' +
                el.ni +
                " p=" +
                el.pi +
                ">" +
                el.niv +
                " " +
                el.gp +
                "</button>";
            }
          } else {
            v += '<button class="dropdown-item" >vide</button>';
          }
          s += v + "</div></div>";
        }
        $("#cau").attr("sau", aui);
        $("#ddau").text(aut);
        $("#au_ico").removeClass("fa fa-spinner fa-spin mr-2 text-primary");
        $("#cnp").html(s);
      },
      "json"
    );
  });

  context.init({
    preventDoubleContext: true,
    compress: false,
  });

  $("#abandon").bootstrapToggle({
    on: "ABD",
    off: "NON ABD",
    onstyle: "danger",
    offstyle: "success",
    size: "normal",
    width: 120,
    heigth: 36,
  });

  function setCM(ei) {
    var id = "#" + ei.num_matr;
    context.attach(id, [
      { header: "ACTIONS " + ei.nie },
      {
        text: "Voir " + ei.nie,
        href: "/Liste/view/" + ei.num_matr,
        target: "_blank",
      },
    ]);
  }

  function getView(ei) {
    if (ei.photo == null) {
      ei.photo = ei.sexe == "1" ? "boys.png" : "girls.png";
    }
    ei.fb =
      ei.fb == null || ei.fb == ""
        ? ""
        : '<a class="text-' +
          ei.color +
          ' ml-2" href="' +
          ei.fb +
          '" target="_blank"><svg><use xlink:href="/assets/svg/list.svg#fbs"></svg></a>';
    ei.email =
      ei.email == null || ei.email == ""
        ? ""
        : '<a class="text-' +
          ei.color +
          '" href="mailto:' +
          ei.email +
          '"><svg><use xlink:href="/assets/svg/list.svg#mail"></svg></a>';

    return (
      '<div class="ei shadow-sm" id=' +
      ei.num_matr +
      ">" +
      '<div class="row no-gutters">' +
      '<div class="eig col-5">' +
      '<img src="/assets/images/students/' +
      ei.photo +
      '" class="eii" alt="Photo récent non disponible">' +
      '<div class="eigc" >' +
      '<div class="text-muted ml-2 mt-1"><span class="badge badge-secondary">' +
      ei.nom_niv +
      "-" +
      ei.nom_gp +
      "</span></div>" +
      '<div style="z-index:2">' +
      '<div class="eigf fr px-1">' +
      '<div><span class="badge badge-' +
      ei.color +
      '">' +
      ei.age +
      '</span> <span class="txt-age">ans</span></div>' +
      '<div class="ml-auto">' +
      ei.email +
      "</div>" +
      "<div>" +
      ei.fb +
      "</div>" +
      "</div>" +
      "</div>" +
      "</div>" +
      "</div>" +
      '<div class="col-7 px-1">' +
      '<div class="fc" style="height:170px;">' +
      '<div class="fr mt-1 mr-1">' +
      '<div class="cne mr-auto"><label for="' +
      ei.nie +
      '">' +
      ei.nie +
      "</label></div>" +
      '<div><input type="checkbox" name="" id="' +
      ei.nie +
      '" nm="' +
      ei.num_matr +
      '"></div>' +
      "</div>" +
      '<div class="text-break cnp">' +
      '<span class="text-' +
      ei.color +
      '">' +
      ei.nom +
      "</span>" +
      '<span class="text-muted"> ' +
      ei.prenom +
      "</span>" +
      "</div>" +
      '<div class="mt-auto fr align-items-end pb-1">' +
      '<div class="cf text-muted">Le : ' +
      ei.dateInscr +
      "<br/>" +
      ei.posteRec +
      " - " +
      ei.dateRec +
      "</div>" +
      '<div class="ml-auto btn-group">' +
      '<a class="btn btn-sm btn-outline-' +
      ei.color +
      '" target="_blank" href="/Liste/View/' +
      ei.num_matr +
      '"><svg><use xlink:href="/assets/svg/list.svg#eye"></svg></a></div>' +
      "</div>" +
      "</div>" +
      "</div>" +
      "</div>" +
      "</div>"
    );
  }

  $("#abandon").change(function () {
    $("#txt_search").val("");
    $("#cei").html("");
  });

  $("#cei").click(function () {
    $("#cm").css("display", "none");
  });

  $("#form_search").on("submit", function (e) {
    e.preventDefault();
    var au = $("#cau").attr("sau");
    if (au) {
      var params = {
        au: au,
        abd: $("#abandon").prop("checked"),
        txt: $(this).find("input:text").val(),
      };
      $("#cei").html(
        '<p class="text-center"><i class="fas fa-spinner fa-pulse"></i></p>'
      );
      $.post(
        "/Liste/getLs4E",
        params,
        function (data) {
          var res = "",
            nbE = data.length,
            nbH = 0,
            nbF = 0;
          for (var i in data) {
            if (data[i].sexe == "1") {
              nbH++;
            } else {
              nbF++;
            }
            res += getView(data[i]);
            setCM(data[i]);
          }
          $("#ceih").html(
            '<em> Efféctif <span class="text-danger">d\'étudiant trouvé</span> : ' +
              nbE +
              ' (<span class="text-boys"> Homme : ' +
              nbH +
              '</span> , <span class="text-girls">Femme : ' +
              nbF +
              "</span> )</em>"
          );
          $("#cei").html(res);
        },
        "json"
      );
    } else {
      $(this).set_alert({
        color: "warning",
        message: "Vous devez choisir l'année universitaire",
      });
    }
  });
});
