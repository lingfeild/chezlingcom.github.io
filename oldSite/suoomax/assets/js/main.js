/*========Window Load Function========*/
$(window).on("load", function () {
  "use strict";

  /* smooth scroll
   -------------------------------------------------------*/
  $.scrollIt({

    easing: 'swing',
    scrollTime: 900,
    activeClass: 'active',
    onPageChange: null,
    topOffset: -70,
    upKey: 38,
    downKey: 40
  });

  // instance of fuction while Window Load event
  jQuery(window).on('load', function () {
    (function ($) {
      appScreenshotCarousel();

    })(jQuery);
  });
  /* Navbar
   -------------------------------------------------------*/
  var win = $(window);
  win.on("scroll", function () {
    var wScrollTop = $(window).scrollTop();

    if (wScrollTop > 100) {
      $(".navbar").addClass("navbar-colored");
    } else {
      $(".navbar").removeClass("navbar-colored");
    }
  });

  /* close navbar-collapse when a  clicked */
  $(".navbar-nav a").not('.dropdown-toggle').on('click', function () {
    $(".navbar-collapse").removeClass("show");
  });

  /* close navbar-collapse when a  clicked */
  $('.dropdown').on('click', function () {
    $(this).toggleClass("show");
  });
  // ANSWER AND QUESTIOn
  $('.collapse').on('shown.bs.collapse', function () {
    $(this).prev().addClass('active');
  });

  $('.collapse').on('hidden.bs.collapse', function () {
    $(this).prev().removeClass('active');
  });

  /* Pricing table
   -------------------------------------------------------*/
  var e = document.getElementById("pricing-table-monthly"),
    d = document.getElementById("pricing-table-yearly"),
    t = document.getElementById("switcher"),
    m = document.getElementById("monthly-section"),
    y = document.getElementById("yearly-section");

  $('#pricing-table-monthly').on('click', function () {
    t.checked = false;
    e.classList.add("toggler-pircing-is-active");
    d.classList.remove("toggler-pircing-is-active");
    m.classList.remove("inactive");
    y.classList.add("inactive");
  });

  $('#pricing-table-yearly').on('click', function () {
    t.checked = true;
    e.classList.add("toggler-pircing-is-active");
    d.classList.remove("toggler-pircing-is-active");
    m.classList.remove("inactive");
    y.classList.add("inactive");
  });

  $('#switcher-item').on('click', function () {
    d.classList.toggle("toggler-pircing-is-active");
    e.classList.toggle("toggler-pircing-is-active");
    m.classList.toggle("inactive");
    y.classList.toggle("inactive");
  });

});

$(window).ready(function () {
  $('#preload').delay(200).fadeOut('fade');
});


// Added
$(document).ready(function () {
  /* ==============================================
     Smooth Scroll To Anchor
     =============================================== */
  $('a.has_sub_menu').on('click', function (e) {
    if (window.matchMedia('(max-width: 992px)').matches) {
      e.preventDefault();
      $(this).toggleClass("active_menu");
      $(this).next($('.sub_menu')).slideToggle();
    }
  });
  $('a.nav-link[href^="#"]').on('click', function (event) {
    var $anchor = $(this);
    $('html, body').stop().animate({
      scrollTop: $($anchor.attr('href')).offset().top
    }, 1500, 'easeInOutExpo');
    event.preventDefault();
  });

  /* ==============================================
   STICKY HEADER
   =============================================== */
  $(window).on('scroll', function () {
    if ($(window).scrollTop() < 100) {
      $('.header').removeClass('sticky_header');
      $('#back-to-top').removeClass('active');
    } else {
      $('.header').addClass('sticky_header');
      $('#back-to-top').addClass('active');
    }
  });

  $(window).on('scroll', function () {
    if ($(window).scrollTop() < 400) {
      $('#back-to-top').removeClass('active');
    } else {
      $('#back-to-top').addClass('active');
    }
  });

  //wow animation
  new WOW().init();

  // Scroll to top
  $(window).scroll(function () {
    if ($(this).scrollTop() >= 50) {        // If page is scrolled more than 50px
      $('#return-to-top').fadeIn(200);    // Fade in the arrow
    } else {
      $('#return-to-top').fadeOut(200);   // Else fade out the arrow
    }
  });
  $('#return-to-top').click(function () {      // When arrow is clicked
    $('body,html').animate({
      scrollTop: 0                       // Scroll to top of body
    }, 500);
  });

});