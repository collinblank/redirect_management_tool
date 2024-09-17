jQuery(document).ready(function ($) {
  console.log("JQuery loaded!");

  $(".more-actions-toggle").click(function (e) {
    e.stopPropagation();
    console.log("toggled!");

    // Hide all other menus
    $(".more-actions-menu").not($(this).siblings(".more-actions-menu")).hide();

    // Toggle this menu
    $(this).siblings(".more-actions-menu").toggle();
  });

  $(document).click(function () {
    $(".more-actions-menu").hide();
  });

  // Prevent clicks inside the menu from closing it
  $(".more-actions-menu").click(function (e) {
    e.stopPropagation();
  });
});