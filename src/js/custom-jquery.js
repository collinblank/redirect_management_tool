jQuery(document).ready(function ($) {
  console.log("JQuery loaded!");

  $(".more-actions-btn").click(function () {
    $(this).closest(".table-actions").find(".more-actions").toggle();
    console.log("more actions button clicked!");
  });
});
