$(function () {
  $alertMessages = $(".alert");
  $.each($alertMessages, function (indexInArray, msg) {
    if (msg) {
      setTimeout(() => {
        $(msg).fadeOut();
      }, (indexInArray + 6) * 1000);
      setTimeout(() => {
        $(msg).remove();
      }, (indexInArray + 7) * 1000);
    }
  });
});
