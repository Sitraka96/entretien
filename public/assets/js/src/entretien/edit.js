$(function () {
  const stepperEl = document.querySelector(".bs-stepper");
  const form = $("#entretien-form");
  if (stepperEl) {
    const stepper = new Stepper(stepperEl, {
      linear: false,
      animation: true,
      selectors: {
        steps: ".step",
        trigger: ".step-trigger",
        stepper: ".bs-stepper",
      },
    });

    stepper.validation = {
      /**
       * Ajouter les [name] des champs à valider et non pas les [id]
       */
      0: [
        // "date_entretien",
        "NIV_id",
        "AU_id",
        "nom",
        "prenom",
        "contact",
        "datenaiss",
        "lieunaiss",
        "religion",
        "etablissement",
        "DO_id",
        "MB_id",
      ],
      1: ["presentation_soi", "ecole", "college", "lycee"],
      2: [
        "nom_pere",
        "prenom_pere",
        "contact_pere",
        "nom_mere",
        "prenom_mere",
        "contact_mere",
      ],
      3: [
        "domaine_souhaite",
        "connaissance_esmia",
        "motivation",
        "attentes",
        "problemes",
        "vision",
        "projets",
        "loisirs",
        "qualites",
        "defauts",
      ],
      4: [],
      invalidFields: [],
    };

    stepper.fieldIsRequired = (field, stepId) => {
      return stepper.validation[stepId].includes(field.attr("name"));
    };

    stepper.isEmpty = (field) => {
      return [null, ""].includes($(field).val());
    };

    stepper.fieldIsValid = (field, stepId) => {
      dateIsValid = true;
      $field = $(field);
      if (
        $field.attr("type") == "date" ||
        $field.attr("type") == "datetime-local"
      ) {
        dateIsValid =
          $field.attr("min") <= $field.val() &&
          $field.val() <= $field.attr("max");
      }
      return (
        !stepper.fieldIsRequired(field, stepId) ||
        (stepper.fieldIsRequired(field, stepId) &&
          !stepper.isEmpty(field) &&
          dateIsValid)
      );
    };

    stepper.hasValidStep = (stepId) => {
      const stepFields = stepper.validation[stepId];
      let fieldName,
        field,
        result = true;

      for (let i = 0; i < stepFields.length; i++) {
        fieldName = stepFields[i]; // ex: date_entretien
        field = $(`[name="${fieldName}"]`);
        if (stepper.fieldIsValid(field, stepId)) {
        } else {
          field.trigger("focus");
          return false;
        }
      }

      return result;
    };

    stepper.handlePrevNext = (event) => {
      const $prevBtn = $("#prev-btn");
      const $nextBtn = $("#next-btn");
      const $submitBtn = $("#submit-btn");

      $prevBtn.on("click", () => {
        stepper.previous();
      });

      $nextBtn.on("click", () => {
        stepper.next();
      });

      switch (event.detail.to) {
        case 0:
          $prevBtn.addClass("disabled").attr("disabled", "disabled");
          $nextBtn.removeClass("disabled").removeAttr("disabled");
          $submitBtn.hide();
          break;

        case stepper._steps.length - 1:
          $prevBtn.removeClass("disabled").removeAttr("disabled");
          $nextBtn.addClass("disabled").attr("disabled", "disabled");
          $submitBtn.show();
          break;

        default:
          $prevBtn.removeClass("disabled").removeAttr("disabled");
          $nextBtn.removeClass("disabled").removeAttr("disabled");
          $nextBtn.show();
          $submitBtn.hide();
          break;
      }
    };

    stepperEl.addEventListener("show.bs-stepper", function (event) {
      // You can call prevent to stop the rendering of your step
      // event.preventDefault()
      const currentStepId = event.detail.from;

      if (stepper.hasValidStep(currentStepId)) {
      } else {
        event.preventDefault();
        /**
         * event.detail => { from: 0, to: 1, indexStep: 1 } // Si on passe de l'étape 0 à 1
         * Vérifier les champs dans step 0
         */
        const allSteps = form.find(".bs-stepper-content [role='tabpanel']");
        const currentStep = allSteps[currentStepId];
        const fieldsInCurrentStep = $(currentStep).find(
          "input, select, textarea"
        );
        $.each(fieldsInCurrentStep, function (indexInArray, field) {
          $field = $(field);
          //   `#${$field.attr(
          //     "id"
          //   )} => ${$field.val()} => required: ${stepper.fieldIsRequired(
          //     $field,
          //     currentStepId
          //   )} => valid: ${stepper.fieldIsValid($field, currentStepId)}`
          // );
          if (stepper.fieldIsValid($field, currentStepId)) {
            $field.removeClass("is-invalid");
          } else {
            stepper.validation.invalidFields.push($field);
            $field.addClass("is-invalid");
            $field.on("keyup", function (event) {
              $(event.target).removeClass("is-invalid");
            });
          }
        });
        /**
         * Focus into the first invalid field
         */
        // stepper.validation.invalidFields.at(0).focusin();
      }
    });

    stepperEl.addEventListener("shown.bs-stepper", function (event) {
      stepper.handlePrevNext(event);
      const indexStep = event.detail.indexStep;
      switch (indexStep) {
        case 0:
          break;
        case 1:
          $('[name="SB_id"]').on("change", function (event) {
            if (event.target.value == "*") {
              stepper.validation[1].push("SB_other");
            } else {
              stepper.validation[1] = stepper.validation[1].filter(
                (field_name) => {
                  return field_name != "SB_other";
                }
              );
              $('[name="SB_other"]').removeClass("is-invalid");
            }
          });
          break;
        case 4:
          $('[name="favorable"]').on("change", function (event) {
            $input = $(event.target);
            $label = $input.parent();
            // $label = $('[for="' + $input.attr("id") + '"]');

            $labels = $('[for^="favorable"]');
            $labels.removeClass(
              "btn-danger btn-outline-danger btn-success btn-outline-success text-white"
            );

            $label.addClass("text-white");

            if ($input.val() == "1" && $input.prop("checked")) {
              $label.addClass("btn-success");
            } else if ($input.val() == "1" && !$input.prop("checked")) {
              $label.addClass("btn-outline-success");
            } else if ($input.val() == "" && $input.prop("checked")) {
              $label.addClass("btn-danger");
            } else if ($input.val() == "" && !$input.prop("checked")) {
              $label.addClass("btn-outline-danger");
            }
          });
          // Animate notes
          watcher();
          break;

        default:
          break;
      }
      form.find('[type="submit"]').on("click", function (clickEvent) {
        if (indexStep == 4) {
          form.trigger("submit");
        } else {
          clickEvent.preventDefault();
          stepper.next();
        }
      });
      form.on("submit", function (submitEvent) {
        form
          .addClass("loading")
          .find('[type="submit"]')
          .addClass("disabled")
          .attr("disabled", "disabled");
      });
      if (indexStep > 0) {
        window.scrollTo(0, 0);
      }
    });

    $("#confirm-delete").on("keyup", function (event) {
      $target = $(event.target);
      if ($target.val() == $target.attr("data-confirm-value")) {
        $("#delete-submit-btn").removeClass("disabled").removeAttr("disabled");
      } else {
        $("#delete-submit-btn")
          .addClass("disabled")
          .attr("disabled", "disabled");
      }
    });
  } else {
    console.warn("Element to stepper not found");
  }

  // stepper.next();
  // stepper.to(5);
});
