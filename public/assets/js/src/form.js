$(function () {
  animate();
  document.querySelectorAll("[data-otherable]").forEach((element) => {
    makeOtherAble({ target: element });
    // element.parentElement.append(`<option value="*" label="Autre"></option>`);
    $("[data-otherable]").on("change", function (event) {
      makeOtherAble(event);
    });
  });
});

function watcher() {
  document.querySelectorAll("[data-watch]").forEach((viewer) => {
    viewer.watch = watch;
    $targets = viewer.watch();
    if ($targets) {
      $targets.forEach((target) => {
        if (target) {
          target.onchange = function (event) {
            viewer.watch(event.target);
          };
        }
      });
    }
  });
}

function watch() {
  let targetNames, $targets, operation, selector;

  if ($(this).attr("data-watch").includes(":")) {
    targetNames = $(this).attr("data-watch").split(":"); // ex: ['frs', 'info', 'agl', 'react', '+']
    operation = targetNames[targetNames.length - 1];
    $targets = [];
    targetNames.forEach((targetName) => {
      if (operation != targetName) {
        selector = "[name$='" + targetName + "']";
        $targets.push(document.querySelector(selector));
      }
    });
  } else {
    selector = "[name$='" + $(this).attr("data-watch") + "']";
    $targets = document.querySelectorAll(selector);
  }
  let tagName = "";
  if ($targets[0]) {
    tagName = $targets[0].tagName;
  } else {
    console.warn(`Can not find ${selector}`);
  }
  let value;
  switch (tagName) {
    case "SELECT":
      $targets[0].querySelectorAll("option").forEach((option) => {
        if ($(option).prop("selected")) {
          value = $(option).html();
        }
      });
      break;
    case "INPUT":
      switch ($($targets[0]).attr("type")) {
        case "checkbox":
          value = [];
          $targets.forEach((input) => {
            if ($(input).prop("checked")) {
              value.push($(input).val());
            }
          });
          value = value.join(", ");
          break;
        case "range":
          if (operation) {
            value = ["+", "-"].includes(operation) ? 0 : 1;
            $targets.forEach((input) => {
              switch (operation) {
                case "+":
                  value += Number($(input).val());
                  break;
                case "-":
                  value -= Number($(input).val());
                  break;
                case "*":
                  value *= Number($(input).val());
                  break;
                case "/":
                  value /= Number($(input).val());
                  break;

                default:
                  break;
              }
            });
          } else {
            value = $targets[0].value;
          }
          break;
        case "text":
          value = $targets[0].value;
          break;
        default:
          value = $targets[0].value;
          break;
      }
      break;

    default:
      value = $targets[0].value;
      break;
  }
  $(this).html(value).val(value);
  return $targets;
}

const makeOtherAble = (event) => {
  $otherFields = $(
    "[id^='" + event.target.getAttribute("id").split("_")[0] + "_other']"
  );
  if (event.target.value == "*") {
    $otherFields.removeAttr("disabled").attr("required", "required");
    if ($otherFields.get(0)) {
      $($otherFields.get(0)).trigger("focus");
    } else {
    }
  } else {
    $otherFields.attr("disabled", "disabled").removeAttr("required");
  }
};

const animate = () => {
  document.querySelectorAll("form").forEach((form) => {
    form.addEventListener("submit", function (event) {
      event.target.classList.add("loading");
      event.target
        .querySelector('[type="submit"]')
        .setAttribute("disabled", "disabled");
    });
  });
};
