jQuery(document).ready(function ($) {
  console.log("JQuery loaded!");

  // START more actions toggle on table
  $(".more-actions-toggle").click(function (e) {
    e.stopPropagation();

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
  //   END more actions toggle on table


  $
});
