$(function () {
  const data = {
    AU_id: 1,
    NIV_id: 1,
  };

  imgInput = document.querySelector("#photo");
  imgPreview = document.querySelector("#photo-preview");

  imgInput.onchange = (evt) => {
    const [file] = imgInput.files;
    if (file) {
      imgPreview.src = URL.createObjectURL(file);
    }
  };

  $('[data-submitter$="Gp"]').on("change", function (event) {
    data.AU_id = Number($('[name="AU_id"]').val());
    data.NIV_id = Number($('[name="NIV_id"]').val());
    searchGp(data);
  });

  $('[data-submitter$="Document"]').on("change", function (event) {
    findDocuments();
  });

  $('[name="session"]').on("change", function (event) {
    updateNIE();
  });

  $('[name="AU_id"]').on("change", function (event) {
    updateNIE();
  });

  $("[data-update='nie']").on("click", function (event) {
    updateNIE();
  });

  updateNIE();

  // normalize();

  // $(window).on("resize", function () {
  //   normalize();
  // });

  $("body").attr({
    "data-spy": "scroll",
    "data-target": "#scroll-menu-nav",
    "data-offset": "10",
  });

  watcher();
});

const normalize = () => {
  const formHeight =
    "calc(100vh - " +
    (document.querySelector("#main-header").clientHeight + 3) +
    "px)";

  $("form").css({
    height: formHeight,
  });
};

const updateNIE = () => {
  $sessionInput = $('[name="session"]');
  $auInput = $('[name="AU_id"]');
  $auSelectedOption = $auInput.find("option[value=" + $auInput.val() + "]");
  $nieInput = $('[name="nie"]');

  const AU_id = $auInput.val();
  const au = $auSelectedOption.html()?.split("-")[0];
  const session = $sessionInput.val();

  $nie = session + au + "0000";
  $nieInput.attr("placeholder", $nie);

  $loadingNie = $("[data-nie-loader]");
  $updateNieBtns = $('[data-update="nie"]');

  $nieInput.removeClass("is-valid");
  $loadingNie.show();
  $updateNieBtns.addClass("disabled");

  if (session != undefined && AU_id != undefined) {
    const data = {
      url: `/Etudiant/NewNie?session=${session}&AU_id=${AU_id}`,
      session: session,
    };
    $.ajax({
      type: "get",
      url: data.url,
      data: data,
      dataType: "json",
      contentType: "application/json; charset=utf-8",
      cache: false,
      processData: true,
      success: function (response) {
        if (response.success) {
          $nieInput.val(response.nie);
          watcher();
        } else {
        }
        // setTimeout(() => {
        $nieInput.addClass("is-valid");
        $loadingNie.hide();
        $updateNieBtns.removeClass("disabled");
        // }, 3000);
      },
    });
  }
};

const findDocuments = () => {
  const data = {};
  data.NIV_id = Number($('[name="NIV_id"]').val());
  const url = "/Dossier/List/" + data.NIV_id;
  $.ajax({
    type: "get",
    url: url,
    data: data,
    dataType: "json",
    contentType: "application/json; charset=utf-8",
    cache: false,
    processData: true,
    success: function (response) {
      dossiers = response;
      const dossierTemplate = $(".dossier-template:first");
      const requiredDocumentsList = $("#required-documents-list");
      requiredDocumentsList.html(null);
      const documentsList = $("#list_dossier_watcher");

      dossiers.forEach((dossier) => {
        newDossierTemplate = dossierTemplate.clone();
        dossierId = "dossier" + dossier.idDOS;

        legend = newDossierTemplate.find("legend");
        input = newDossierTemplate.find("input:first");
        label = newDossierTemplate.find("label:first");
        addObservationBtn = newDossierTemplate.find(
          ".add-observation-btn:first"
        );
        observationContainer = newDossierTemplate.find(
          '[id$="ObservationContainer"]'
        );

        input.attr("id", dossierId).val(dossier.idDOS);

        if (
          documentsList &&
          documentsList.val() &&
          documentsList.val().split(", ").includes(String(dossier.idDOS))
        ) {
          input.attr("checked", "checked").prop("checked", true);
        } else {
          input.removeAttr("checked").prop("checked", false);
        }
        if (label.length) {
          label.html(dossier.nom_dos).attr("for", dossierId);
        }
        if (legend.length) {
          legend.html(dossier.nom_dos);
          label.html("").attr("for", dossierId);
        }
        if (addObservationBtn.length) {
          addObservationBtn
            .attr(
              "data-target",
              "#dossier" + dossier.idDOS + "ObservationContainer"
            )
            .attr(
              "aria-controls",
              "dossier" + dossier.idDOS + "ObservationContainer"
            );
        }
        if (observationContainer) {
          observationContainer.attr(
            "id",
            "dossier" + dossier.idDOS + "ObservationContainer"
          );
          observationField = observationContainer.find("textarea");
          observationField
            .val("")
            .attr("name", `list_dossiers[observation][${dossier.idDOS}]`);
        }
        requiredDocumentsList.append(newDossierTemplate);
      });
      watcher();
    },
    error: function (err) {},
  });
};

const searchGp = (data) => {
  const url = "/Gp?AU_id=" + data.AU_id + "&NIV_id=" + data.NIV_id;
  $.ajax({
    type: "get",
    url: url,
    data: data,
    dataType: "json",
    contentType: "application/json; charset=utf-8",
    // cache: false,
    // contentType: false,
    // processData: false,
    success: function (response) {
      $gpSelect = $('[name="GP_id"]');
      $gpSelect.html("");
      gps = response;
      $.each(gps, function (indexInArray, gp) {
        $gpSelect.append(`
          <option value="${
            gp.idGP
          }" ${$gpSelect.val() == gp.idGP ? "selected" : ""}>
            ${gp.nom_gp}
          </option>
        `);
      });
    },
    error: function (err) {},
  });
};
