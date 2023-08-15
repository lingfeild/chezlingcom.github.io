(function ($) {
  "use strict";

  /*------------------------------------------------------------------
  [Table of contents]
    
  1. my owl function
  2. smooth scroll
  3. custom input type number function
  4. custom input type select function
  5. email patern 
  6. equalheight function
  7. pricing fixedtable function
  8. content to center banner section
  9. prelaoder
  10. preloader close button
  11. mega navigation menu init
  12. twitter api init
  13. client slider
  14. testimonial slider
  15. blog post gallery slider
  16. contact form init
  17. video popup init
  18. Side Offset cart menu open
  19.	wow animation init
  20. my custom select init
  21. tab swipe indicator
  22. pricing matrix expand slider
  23. feature section prev class get function
  24. pricing expand function
  25. accordion add class "isActive" function
  26. click and go to current section init
  27. input number increase
  28. right click , ctrl+u and ctrl+shift+i disabled
  29. image dragable false setup
  30. ajaxchimp init
    
  -------------------------------------------------------------------*/

  /*==========================================================
                  1. my owl function
  ======================================================================*/
  $.fn.myOwl = function (options) {

    var settings = $.extend({
      items: 1,
      dots: false,
      loop: true,
      mouseDrag: true,
      touchDrag: true,
      nav: false,
      autoplay: true,
      navText: ['', ''],
      margin: 0,
      stagePadding: 0,
      autoplayTimeout: 5000,
      autoplayHoverPause: true,
      navRewind: false,
      responsive: {},
      animateOut: '',
      animateIn: '',
      smartSpeed: 900,
      center: ''
    }, options);

    return this.owlCarousel({
      items: settings.items,
      loop: settings.loop,
      mouseDrag: settings.mouseDrag,
      touchDrag: settings.touchDrag,
      nav: settings.nav,
      navText: settings.navText,
      dots: settings.dots,
      margin: settings.margin,
      stagePadding: settings.stagePadding,
      autoplay: settings.autoplay,
      autoplayTimeout: settings.autoplayTimeout,
      autoplayHoverPause: settings.autoplayHoverPause,
      animateOut: settings.animateOut,
      animateIn: settings.animateIn,
      responsive: settings.responsive,
      navRewind: settings.navRewind,
      center: settings.center,
      smartSpeed: settings.smartSpeed
    });
  };

  /*==========================================================
                  2. smooth scroll
  ======================================================================*/
  $.fn.scrollView = function () {
    return this.each(function () {
      $('html, body').animate({
        scrollTop: $(this).offset().top
      }, 1000);
    });
  }


  /*==========================================================
                  3. custom input type number function
  ======================================================================*/
  $.fn.customNumber = function (options) {
    var settings = $.extend({
      plusIcon: '',
      minusIcon: ''
    }, options);

    this.append('<span class="add">' + settings.plusIcon + '</span>');
    this.append('<span class="sub">' + settings.minusIcon + '</span>');

    return this.each(function () {
      var spinner = $(this),
        input = spinner.find('input[type="number"]'),
        add = spinner.find('.add'),
        sub = spinner.find('.sub');

      input.parent().on('click', '.sub', function (event) {
        event.preventDefault();
        if (input.val() > parseInt(input.attr('min'), 10)) {
          input.val(function (i, oldvalue) {
            return --oldvalue;
          })
        }
      });
      input.parent().on('click', '.add', function (event) {
        event.preventDefault();
        if (input.val() < parseInt(input.attr('max'), 10)) {
          input.val(function (i, oldvalue) {
            return ++oldvalue;
          })
        }
      });
    });
  }


  /*==========================================================
                  4. custom input type select function
  ======================================================================*/

  $.fn.mySelect = function (option) {
    var $this = $(this);
    var numberOfOptions = $(this).children('option');

    $this.addClass('select-hidden');
    $this.wrap('<div class="select"></div>');
    $this.after('<div class="select-styled"></div>');

    var styledSelect = $this.next('.select-styled');
    styledSelect.text($this.children('option').eq(0).text());

    var list = $('<ul />', {
      'class': 'select-options'
    }).insertAfter(styledSelect);

    for (var i = 0; i < numberOfOptions.length; i++) {
      $('<li />', {
        text: $this.children('option').eq(i).text(),
        rel: $this.children('option').eq(i).val()
      }).appendTo(list);
    }

    var listItems = list.children('li');

    styledSelect.on('click', function (e) {
      e.stopPropagation();
      $('.select-styled.active').not(this).each(function () {
        $(this).removeClass('active').next('.select-options').fadeIn();
      });
      $(this).toggleClass('active').next('.select-options').toggle();
      $(this).parent().toggleClass('focus');
    });

    listItems.on('click', function (e) {
      e.stopPropagation();
      styledSelect.text($(this).text()).removeClass('active');
      $this.val($(this).attr('rel'));
      list.hide();
      if ($(this).parent().parent().hasClass('focus')) {
        $(this).parent().parent().removeClass('focus');
      }
    });

    $(document).on('click', function () {
      styledSelect.removeClass('active');
      list.hide();
    });
  }

  /*=============================================================
              20. my custom select init
  =========================================================================*/
  // if ($('select').length > 0) {
  //   $('select').mySelect();
  // }

  $("#product-additional").mySelect();

  $('#product-location-d-b').mySelect();
  $("#product-additional-d-b").mySelect();
  $('#product-location-d-s').mySelect();
  $('#product-additional-d-s').mySelect();
  $('#product-location-d-g').mySelect();
  $('#product-additional-d-g').mySelect();
  $('#product-location-d-p').mySelect();
  $('#product-additional-d-p').mySelect();

  $('#product-location-s-b').mySelect();
  // $('.product-additional-s-b').mySelect();
  $('#product-location-s-s').mySelect();
  $('.product-additional-s-s').mySelect();
  $('#product-location-s-g').mySelect();
  $('.product-additional-s-g').mySelect();
  $('#product-location-s-p').mySelect();
  $('.product-additional-s-p').mySelect();

  $('#product-location-v-b').mySelect();
  $('.product-additional-v-b').mySelect();
  $('#product-location-v-s').mySelect();
  $('.product-additional-v-s').mySelect();
  $('#product-location-v-g').mySelect();
  $('.product-additional-v-g').mySelect();
  $('#product-location-v-p').mySelect();
  $('.product-additional-v-p').mySelect();
  


  /*==========================================================
                  5. email patern 
  ======================================================================*/
  function email_pattern(email) {
    var regex = /^([a-zA-Z0-9_.+-])+\@(([a-zA-Z0-9-])+\.)+([a-zA-Z0-9]{2,4})+$/;
    return regex.test(email);
  }


  /*==========================================================
                  6. equalheight function
  ======================================================================*/
  var equalHeight = () => {
    var pricingImage = $('.pricing-image'),
      pricingFeature = $('.pricing-feature-group');

    if ($(window).width() > 991) {
      pricingFeature.css('height', pricingImage.outerHeight());
    } else {
      pricingFeature.css('height', 100 + '%');
    }
  }


  /*==========================================================
                  7. pricing fixedtable function
      ======================================================================*/
  function fixedtabel() {

    var table = $('.xs-table');

    if (!($(window).width() > 576)) {
      if ($('.xs-table.fixed-column').length === 0) {
        var fixedCol = table.clone().insertBefore(table).addClass('fixed-column');
      }
    } else {
      $('.xs-table.fixed-column').remove();
    }
    var fixedCol = $('.xs-table.fixed-column');
    fixedCol.find('th:not(:first-child),td:not(:first-child)').remove();

    fixedCol.find('tr').each(function (i, elem) {
      $(this).height(table.find('tr:eq(' + i + ')').height());
    });
  };

  /*==========================================================
                  8. content to center banner section
  ======================================================================*/
  function centerContent() {
    var content = $('.contet-to-center > .container'),
      header = $('.header-transparent');

    if ($(window).width() > 991) {
      content.css('margin-top', header.outerHeight());
    } else {
      content.css('margin-top', 0 + 'px');
    }
  }

  function stickyHeader() {
    var mainheader = $('.nav-sticky'),
      height = mainheader.outerHeight(),
      scroll = $(document).scrollTop();
    $(window).on('load', function () {
      if ($(document).scrollTop() > height) {
        if (mainheader.hasClass('sticky-header')) {
          mainheader.removeClass('sticky-header');
        } else {
          mainheader.addClass('sticky-header');
        }
      }
    })
    $(window).on('scroll', function () {
      var scrolled = $(document).scrollTop(),
        header = $('.sticky-header');
      if (scrolled > scroll) {
        header.addClass('sticky');
      } else {
        header.removeClass('sticky');
      }
      if (scrolled === 0) {
        mainheader.removeClass('sticky-header');
      } else {
        mainheader.addClass('sticky-header');
      }
      scroll = $(document).scrollTop();
    });
  }

  $(window).on('load', function () {

    // equal hight init
    equalHeight();
    // fixedtable init
    fixedtabel();
    // center content
    centerContent();

    // sticky header init
    stickyHeader();

    /*==========================================================
                9. prelaoder
    ======================================================================*/
    $('#preloader').addClass('loaded');

  }); // END load Function 

  $(document).ready(function () {
    // equal hight init
    equalHeight();
    // fixedtable init
    fixedtabel();
    // center content
    centerContent();

    // sticky header init
    stickyHeader();

    /*==========================================================
                10. preloader close button	
    ======================================================================*/
    $('.prelaoder-btn').on('click', function (e) {
      e.preventDefault();
      if (!($('#preloader').hasClass('loaded'))) {
        $('#preloader').addClass('loaded');
      }
    })

    /*==========================================================
            11. mega navigation menu init
    ======================================================================*/
    if ($('.xs-menus').length > 0) {
      $('.xs-menus').xs_nav({
        mobileBreakpoint: 992,
      });
    }



    /*==========================================================
            13. client slider
    ======================================================================*/
    if ($('.xs-client-slider').length > 0) {
      $('.xs-client-slider').myOwl({
        items: 5,
        responsive: {
          0: {
            items: 1
          },
          768: {
            items: 3
          },
          1024: {
            items: 5
          }
        }
      });
    }

    /*==========================================================
            14. testimonial slider
    ======================================================================*/
    if ($('.xs-testimonial-slider').length > 0) {
      $('.xs-testimonial-slider').myOwl({
        items: 3,
        center: true,
        animateOut: 'fadeOut',
        animateIn: 'fadeIn',
        responsive: {
          0: {
            items: 1
          },
          768: {
            items: 2
          },
          1024: {
            items: 3
          }
        }
      });
    }

    /*==========================================================
                15. blog post gallery slider
    ======================================================================*/
    if ($('.post-gallery-slider').length > 0) {
      $('.post-gallery-slider').myOwl({
        nav: true,
        navText: ['<i class="icon icon-arrow-left"></i>', '<i class="icon icon-arrow-right"></i>'],
        responsive: {
          0: {
            nav: false
          }
        }
      });
    }

    /*==========================================================
            17. video popup init
    ======================================================================*/
    if ($('.xs-video-popup').length > 0) {
      $('.xs-video-popup').magnificPopup({
        disableOn: 700,
        type: 'iframe',
        mainClass: 'mfp-fade',
        removalDelay: 160,
        preloader: false,
        fixedContentPos: false
      });
    }

    /*==========================================================
         18. Side Offset cart menu open
    ======================================================================*/
    if ($('.offset-side-bar').length > 0) {
      $('.offset-side-bar').on('click', function (e) {
        e.preventDefault();
        e.stopPropagation();
        $('.cart-group').addClass('isActive');
      });
    }
    if ($('.close-side-widget').length > 0) {
      $('.close-side-widget').on('click', function (e) {
        e.preventDefault();
        $('.cart-group').removeClass('isActive');
      });
    }
    if ($('.navSidebar-button').length > 0) {
      $('.navSidebar-button').on('click', function (e) {
        e.preventDefault();
        e.stopPropagation();
        $('.info-group').addClass('isActive');
      });
    }
    if ($('.close-side-widget').length > 0) {
      $('.close-side-widget').on('click', function (e) {
        e.preventDefault();
        $('.info-group').removeClass('isActive');
      });
    }
    $('body').on('click', function (e) {
      $('.info-group').removeClass('isActive');
      $('.cart-group').removeClass('isActive');
    });
    $('.xs-sidebar-widget').on('click', function (e) {
      e.stopPropagation();
    });

    /*=============================================================
                19.	wow animation init
    =========================================================================*/
    $(function () {
      var wow = new WOW({
        boxClass: 'wow',
        animateClass: 'animated',
        offset: 0,
        mobile: false,
        live: true,
        scrollContainer: null,
      });
      wow.init();
    });


    /*=============================================================
                21. tab swipe indicator
    =========================================================================*/
    if ($('.tab-swipe').length > 0) {
      $('.tab-swipe').append('<li class="indicator"></li>');
      if ($('.tab-swipe li a').hasClass('active')) {
        var cLeft = $('.tab-swipe li a.active').position().left + 'px',
          cWidth = $('.tab-swipe li a.active').css('width');
        $('.indicator').css({
          left: cLeft,
          width: cWidth
        })
      }
      $('.tab-swipe li a').on('click', function () {
        $('.tab-swipe li a').removeClass('isActive');
        $(this).addClass('isActive');
        var cLeft = $('.tab-swipe li a.isActive').position().left + 'px',
          cWidth = $('.tab-swipe li a.isActive').css('width');
        $('.indicator').css({
          left: cLeft,
          width: cWidth
        })
      });
    }

    /*=============================================================
                22. pricing matrix expand slider
    =========================================================================*/
    if ($('.pricing-matrix-slider').length > 0) {
      $('.pricing-matrix-slider').on('initialized.owl.carousel translated.owl.carousel', function () {
        var $this = $(this);
        $this.find('.owl-item.last-child').each(function () {
          $(this).removeClass('last-child');
        });
        $(this).find('.owl-item.active').last().addClass('last-child');
      });
      $('.pricing-matrix-slider').myOwl({
        items: 3,
        mouseDrag: false,
        autoplay: false,
        nav: true,
        navText: ['<i class="icon icon-arrow-left"></i>', '<i class="icon icon-arrow-right"></i>'],
        responsive: {
          0: {
            items: 1,
            mouseDrag: true,
            loop: true,
          },
          768: {
            items: 2,
            mouseDrag: true
          },
          1024: {
            items: 3,
            mouseDrag: false,
            loop: false
          }
        }
      });
    }

    /*=============================================================
                23. feature section prev class get function
    =========================================================================*/
    if ($('.xs-feature-section').length > 0) {
      if ($('.xs-feature-section').prev().hasClass('xs-bg-gray')) {
        $('.xs-feature-section').addClass('xs-bg-gray');
      } else {
        $('.xs-feature-section').removeClass('xs-bg-gray');
      }
      if ($('.xs-footer-section').prev().hasClass('xs-bg-gray')) {
        $('.xs-footer-section').children('.xs-feature-section').addClass('xs-bg-gray');
      } else {
        $('.xs-footer-section').children('.xs-feature-section').removeClass('xs-bg-gray');
      }
    };

    /*=============================================================
                24. pricing expand function
    =========================================================================*/
    if ($('.pricing-expand').length > 0) {
      if ($(window).width() > 991) {
        var pricingContainer = $('.pricing-expand.pricing-matrix'),
          height = Math.floor(pricingContainer.height()),
          children = $('.pricing-expand.pricing-matrix .pricing-matrix-slider'),
          childreHeight = children.height(),
          gap = $('.pricing-expand.pricing-matrix .gap'),
          gapHeight = gap.height(),
          mini = Math.floor((height - ((childreHeight / 2) + (gap.length * 1)))),
          animSpeed = 500;

        pricingContainer.attr('data-height', height + 'px');
        pricingContainer.attr('data-min', mini + 'px');
        pricingContainer.css('height', mini + 'px');

        if ($('.content-collapse-wraper').length === 0) {
          pricingContainer.after(
            '<div class="content-collapse-wraper"><a href="#" class="btn btn-primary expand-btn">Load More <i class="icon icon-arrow_down"></i></a></div>'
          );
        }

        $('.expand-btn').on('click', function (e) {
          e.preventDefault();
          var content = $(this).parent().prev();
          content.animate({
            'height': content.attr('data-height')
          }, animSpeed);
          content.addClass('expand');
          $(this).addClass('hide');
        });
      } else {
        if ($('.pricing-matrix').hasClass('pricing-expand')) {
          $('.pricing-matrix').removeClass('pricing-expand');
          console.log('hi')
        } else {
          $('.pricing-matrix').removeClass('pricing-expand');
        }
      }
    }
    $('.pricing-matrix .gap').prev().addClass('border-bottom-0');

    /*=============================================================
                25. accordion add class "isActive" function
    =========================================================================*/
    if ($('.xs-accordion .card-header > a').length > 0) {
      $('.xs-accordion .card-header > a').on('click', function () {
        if (!$(this).parent().parent().hasClass('isActive')) {
          $(this).parent().parent().prevAll().removeClass('isActive');
          $(this).parent().parent().nextAll().removeClass('isActive');
          $(this).parent().parent().addClass('isActive');
        }
      });
    }

    /*=============================================================
                26. click and go to current section init
    =========================================================================*/
    $('.comment-reply-link').on('click', function (event) {
      event.preventDefault();
      $('#comment-form').scrollView();
    });

    /*=============================================================
             27. input number increase
    =========================================================================*/

    $('.custom_number').customNumber({
      plusIcon: '<i class="icon icon-plus"></i>',
      minusIcon: '<i class="icon icon-minus"></i>'
    });

    /*=============================================================
             30. ajaxchimp init
    =========================================================================*/
    if ($('#subscribe-form').length > 0) {
      $('#subscribe-form').ajaxChimp({
        url: 'https://facebook.us8.list-manage.com/subscribe/post?u=85f515a08b87483d03fee7755&amp;id=66389dc38b'
      });
    }

    if ($('.wave_animation').length > 0) {
      $('.wave_animation').parallax();
    }

    if ($('.xs-modal-popup').length > 0) {
      $('.xs-modal-popup').magnificPopup({
        type: 'inline',
        fixedContentPos: false,
        fixedBgPos: true,
        overflowY: 'auto',
        closeBtnInside: false,
        callbacks: {
          beforeOpen: function () {
            this.st.mainClass = "my-mfp-slide-bottom xs-promo-popup";
          }
        }
      });
    }

    $('[data-toggle="tooltip"]').tooltip();

  }); // end ready function

  $(window).on('scroll', function () {

  }); // END Scroll Function 

  $(window).on('resize', function () {
    // equal hight init
    equalHeight();
    // fixedtable init
    fixedtabel();
    // center content
    centerContent();
  }); // End Resize

})(jQuery);


