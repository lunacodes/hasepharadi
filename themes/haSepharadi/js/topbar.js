jQuery(document).ready(function function_name($) {
  "use strict";

  /* Back to Top*/
  $('#backToTop').on('click',function(){
    $("html, body").animate({scrollTop:0},'slow');
    return false;
  });

  $(window).on('scroll',function() {
     if($(this).width()>250){

          /*Shrinking the header*/
          // if($(document).scrollTop() > $('#genesis-content').offset().top - 200){
          if($(document).scrollTop() > $('#genesis-content').offset().top - parseFloat($('#genesis-content').css('marginTop').replace(/auto/, 100))){
            // console.log($('#genesis-content').offset().top);
            // console.log($('#genesis-content').offset().top - 200);
            $('#topbar').addClass('shrinked');
            $('#top').addClass('header-shrinked');
            $('#top-search').addClass('search-shrinked');
            $('#genesis-nav-primary').addClass('nav-shrinked');
            $('#genesis-mobile-nav-primary').addClass('mobile-menu-shrinked');
            $('#header-date').addClass('date-shrinked');
            $('#backToTop').fadeIn();
            $('#backToTop').addClass('btt-shrinked');

            // if ($('#wpadminbar')) {
            //   console.log("Wp Admin Bar Exists");
            //   if ($('nav-shrinked')) {
            //     console.log('nav-shrinked exists');
            //     // return;
            //   }

              // $('nav-shrinked').style.top = "initial";
              // console.log("Wp Admin Bar Exists");
            // }
          }

          else{
            $('#topbar').removeClass('shrinked');
            $('#top').removeClass('header-shrinked');
            $('#top-search').removeClass('search-shrinked');
            $('#genesis-nav-primary').removeClass('nav-shrinked');
            $('#genesis-mobile-nav-primary').removeClass('mobile-menu-shrinked');
            $('#header-date').removeClass('date-shrinked');
            $('#backToTop').removeClass('btt-shrinked');
            $('#backToTop').fadeOut();
          }
      }
   });

});
