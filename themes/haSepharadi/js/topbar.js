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




  // if($(window).width()<=959){
  //   $("#topbar").sticky({topSpacing:0});
  // }


  // $(window).on('scroll',function() {
  //    if($(this).width()>767 ){

  //         /*Shrinking the header*/
  //         if($(document).scrollTop() > $('#cn_content').offset().top - parseFloat($('#cn_content').css('marginTop').replace(/auto/, 100))){
  //         $('#top').addClass('shrinked');
  //         $('#backtoTop').fadeIn();
  //     }else{
  //       $('#top').removeClass('shrinked');
  //       $('#backtoTop').fadeOut();
  //     }

  //   }
  //  });

  //  $('#start-read').on('click',function(){
  //    $('body').animate({scrollTop:$('#main').offset().top-40},'slow');
  //  });

  //  /*Set the overlay size*/
  //  function overlay_size(){
  //    $('.post .thumbnail').each(function(){
  //        $('#masonry_blog .post,#masonry_channel_3col .channel,.masonry_channel .channel').show();
  //      var overlay_width,overlay_height,marginTop,marginLeft;
  //        var wrapper_width=$(this).width();
  //        var wrapper_height=$(this).height();

  //      if($(this).children('img').height()<wrapper_height){
  //        $(window).load(function(){
  //       wrapper_height=$(this).children('img').height();
  //         if(wrapper_height==0){
  //           wrapper_height=200;
  //         }
  //       $(this).css('height',wrapper_height);
  //        })

  //      }

  //      if($(window).width()>800){
  //          overlay_width=wrapper_width-20;
  //        overlay_height=wrapper_height-20;
  //      }else{
  //        overlay_width=wrapper_width;
  //        overlay_height=wrapper_height;
  //      }
  //        marginTop=overlay_height/2;
  //        marginLeft=overlay_width/2;

  //        $(this).children('.overlay').css({
  //        width:overlay_width+'px',
  //        height:overlay_height+'px',
  //        marginTop:'-'+marginTop+'px',
  //        marginLeft:'-'+marginLeft+'px'
  //        });
  //      $(this).children('.overlay').children('i').css({
  //        width:'20px',
  //        height:'20px',
  //        display:'block',
  //        left:'50%',
  //        top:'50%',
  //        position:'absolute',
  //        marginTop:'-10px',
  //        marginLeft:'-10px'
  //        });
  //    });
  //  }


})
