

// preloader
$(window).load(function(){
    $('.preloader').fadeOut(1000); // set duration in brackets    
});

$(function() {
    new WOW().init();
    $('.templatemo-nav').singlePageNav({
    	offset: 70
    });

    /* Hide mobile menu after clicking on a link
    -----------------------------------------------*/
    // $('.navbar-collapse a').click(function(){
    //     $(".navbar-collapse").collapse('hide');
    // });
   
})


$(document).ready(function() {
    $('.submenu').click(function(e) {
      e.preventDefault();
      var selectedTag = $(this).data('tag');
  
      if (selectedTag === 'All') {
        $('.item').show();
      } else {
        $('.item').hide();
        $('.item[data-tags*="' + selectedTag + '"]').show();
      }
  
      // Collapse the navigation menu after clicking on a submenu item on mobile
      if ($(window).width() < 768) {
        $('.navbar-collapse').collapse('hide');
      }
    });
  });