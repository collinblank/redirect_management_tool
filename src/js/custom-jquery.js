$(document).ready(function () {
  $(".more-actions-btn").click(function () {
    $(this).closest(".table-actions").find(".more-actions").toggle();
  });
});
