$(document).ready(function () {
  $pageToPrint = document.querySelector("#ticket-section");
  $pageHead = document.querySelector("head");

  $printBtn = document.querySelector(".print-btn");
  $printBtn?.addEventListener("click", function (event) {
    printIt($pageToPrint);
  });
});

function printIt(printThis) {
  let win = window.open();
  self.focus();
  win.document.open();
  // win.document.write("<!DOCTYPE html>");
  // win.document.write('<html style="display: none;">');
  // win.document.write("<head>");
  // win.document.write('<meta charset="UTF-8" />');
  // win.document.write(
  //   '<meta name="viewport" content="width=device-width, initial-scale=1"/>'
  // );
  // win.document.write('<meta http-equiv="X-UA-Compatible" content="IE=7">');
  // win.document.write('<meta http-equiv="X-UA-Compatible" content="ie=edge">');
  // win.document.write(
  //   '<meta http-equiv="Content-Type" content="text/html;charset=UTF-8">'
  // );
  // win.document.write("<title>Impression du ticket en cours...</title>");
  // win.document.write(
  //   '<link rel="shortcut icon" href="{{asset(\'images/logo.png\')}}" type="image/x-icon">'
  // );
  // win.document.write(
  //   '<link rel="stylesheet" href="/src/entretien/view.css">'
  // );
  // win.document.write("</head>");
  win.document.write($pageHead.innerHTML);
  win.document.write("<body>");
  win.document.write(printThis.innerHTML);
  win.document.write(
    '<button type="button" id="print-btn" class="btn btn-secondary rounded-circle bi bi-printer floating-btn"></button>'
  );
  win.document.write("</body></html>");
  win.document.close();

  // win.document.querySelector("head title").innerHTML = "Impression en cours";

  win.document.querySelectorAll("script").forEach((e) => e.remove());

  if (win.document.readyState === "complete") {
    win.document.querySelector("html").style.display = "block";
    win.document
      .querySelector("#print-btn")
      .addEventListener("click", function (event) {
        event.target.remove();
        win.print();
        win.close();
      });
  }
}
