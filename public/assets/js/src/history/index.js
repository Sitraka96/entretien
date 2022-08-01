$(function () {
  timelines = document.querySelectorAll(".timeline-li");
  timelines.forEach((timeline) => {
    timelineChanges = timeline.querySelectorAll(".history-change");
    timelineFooter = timeline.querySelector(".timeline-footer");
    timelineFooter.classList.add("d-flex");
    timelineFooter.classList.add("justify-content-between");
    switch (timeline.getAttribute("data-action")) {
      case "CREATE":
        break;
      case "UPDATE":
        if (timelineChanges.length > 3) {
          timeline.toggle = toggleTimeline;
          seeMoreBtn = document.createElement("button");
          seeMoreBtn.setAttribute("type", "button");
          seeMoreBtn.setAttribute(
            "class",
            "expand-btn bi bi-arrow-down-circle-fill text-primary"
          );
          seeMoreBtn.onclick = function (event) {
            timeline.toggle();
          };
          timelineFooter.prepend(seeMoreBtn);
        }
        break;
      case "DELETE":
        timeline.restore = restore;
        restoreBtn = document.createElement("button");
        restoreBtn.setAttribute("type", "button");
        restoreBtn.setAttribute(
          "class",
          "restore-btn bi bi-arrow-counterclockwise text-warning"
        );
        restoreBtn.onclick = function (event) {
          timeline.restore();
        };
        timelineFooter.prepend(restoreBtn);
        break;

      default:
        break;
    }
  });
});

const restore = function () {
  const id = this.getAttribute("data-id");
  const url = `/History/Restore/${id}`;
  console.log(`Restoring ${id}`, url);

  $.post(
    url,
    { id: id },
    function (data, textStatus, jqXHR) {
      console.log(res);
    },
    "json"
  );
};

const toggleTimeline = function () {
  this.classList.toggle("expanded");
};
