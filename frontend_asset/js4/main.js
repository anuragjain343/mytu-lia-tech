! function($) {
    "use strict";
    $(document).ready(function() {
	function t(e) {
            O.removeClass("active"), e.addClass("active")
        }
   function t1(e) {
      O1.removeClass("active"), e.addClass("active")
  }
  //Run function when document ready
        var b = $(".owl-features"),
            O = $(".forV");
        b.owlCarousel({
            loop: !0,
            responsiveClass: !0,
            margin: 20,
            autoplay: !0,
            items: 1,
            nav: !1,
            dots: !1,
            animateOut: "slideOutDown",
            animateIn: "fadeInUp"
        }), b.on("changed.owl.carousel", function(e) {
            var o = e.item.index + 1 - e.relatedTarget._clones.length / 2,
                n = e.item.count;
            (o > n || 0 == o) && (o = n - o % n), o--;
            var a = $(".forV:nth(" + o + ")");
            t(a)
        }), O.on("click", function() {
            var e = $(this).data("owl-item");
            b.trigger("to.owl.carousel", e), t($(this))
        });
        var b1 = $(".owl-features1"),
            O1 = $(".forU");
        b1.owlCarousel({
            loop: !0,
            responsiveClass: !0,
            margin: 20,
            autoplay: !0,
            items: 1,
            nav: !1,
            dots: !1,
            animateOut: "slideOutDown",
            animateIn: "fadeInUp"
        }), b1.on("changed.owl.carousel", function(e) {
            var o = e.item.index + 1 - e.relatedTarget._clones.length / 2,
                n = e.item.count;
            (o > n || 0 == o) && (o = n - o % n), o--;
            var a = $(".forU:nth(" + o + ")");
            t1(a)
        }), O1.on("click", function() {
            var e = $(this).data("owl-item");
            b1.trigger("to.owl.carousel", e), t1($(this))
        });

});

}(jQuery);
 
jQuery(document).ready(function($){
	init_gototop();
	init_loader();
	//init_pagescroll();
	init_fullheigh();
});



  /*------------------------------------------*/
  /*           /*. Go to top /*
  /*------------------------------------------*/


  function init_gototop()
  {
    if ($('#back-to-top').length)
    {
      var scrollTrigger = 100,
        backToTop = function ()
        {
          var scrollTop = $(window).scrollTop();
          if (scrollTop > scrollTrigger)
          {
            $('#back-to-top').addClass('show');
          }
          else
          {
            $('#back-to-top').removeClass('show');
          }
        };
      backToTop();
      $(window).on('scroll', function ()
      {
        backToTop();
      });
      $('#back-to-top').on('click', function (e)
      {
        e.preventDefault();
        $('html,body').animate(
        {
          scrollTop: 0
        }, 900);
      });
    }
  };


  /*------------------------------------------*/
  /*      /*. loader /*
  /*------------------------------------------*/


    function init_loader()
  {
		$("#loader").fadeOut("slow", function () {
			$("#preloader").delay(300).fadeOut("slow")
		})
	
  };

   
 	/*------------------------------------------*/
    /*           /*Nav Scroll Fix /*
    /*------------------------------------------*/

		
	$(window).scroll(function() {
		if ($(".navbar").offset().top > 0) {
			$(".navbar-fixed-top").addClass("top-nav-collapse");
		} else {
			$(".navbar-fixed-top").removeClass("top-nav-collapse");
		}
	});
	
		
   // 
  /*------------------------------------------*/
  /*           /*. page scroll /*
  /*------------------------------------------*/
   
   
	function init_pagescroll() {
		$('a.page-scroll').on('click', function(e) {
            if (location.pathname.replace(/^\//, '') === this.pathname.replace(/^\//, '') && location.hostname === this.hostname) {
                var target = $(this.hash);
                target = target.length ? target : $('[name=' + this.hash.slice(1) + ']');
                if (target.length) {
                    $('html,body').animate({
                        scrollTop: target.offset().top
                    }, 500);
                    return false;
                }
            }
        });
	};
	

/*------------------------------------------*/
/*           /* 04. Menu Mobile Toggle /*
/*------------------------------------------*/

 //    $(document).ready(function() {    
 //     $('.navbar-collapse ul li a').click(function() {
 //    $('.navbar-toggle:visible').click();
 //    });   
 // });
 



   /*------------------------------------------*/
    /*           /*. full-heigh banner /*
   /*------------------------------------------*/
	
	
	 function init_fullheigh(){
		 
	 $(".full-height").height($(window).height()), 
	 $(window).on("resize", function () {
     
	  $(".full-height").height($(window).height())
    })
	};
	
 // JavaScript Document

/*Chat js*/

$(function(){
  $(".newMsg").click(function() {
    $(".left_msg").css({
      "display": "block"
    });
  });

  $(".newMsg-back").click(function() {
    $(".left_msg").css({
      "display": "none"
    });
  });
});

/*Video js*/

$(function(){
  $('.video-gallery').lightGallery({
        videojs: true
    }); 
});



/*All popup*/
/*$(".signUp-link a").on('click',function(){
  $(".login-popup .close").click();
  setTimeout(function(){
  $("#ShowSingup").click();
},2000);
});*/
// $(".login-link a").on('click',function(){
//   $(".signup-popup .close").click();
//   setTimeout(function(){
//     $(".loginView a").click();
//     alert("trigger");
//   },500);
// });

/*$(".signUp-link a").on('click',function(){
    $("#ShowSingup").trigger("click");
});*/
// $(document).on('click','[data-toggle*=modal]',function(){
//   $('[role*=dialog]').each(function(){
//     switch($(this).css('display')){
//       case('block'):{$('#'+$(this).attr('id')).modal('hide'); break;}
//     }
//   });
// });


  $('#ourVendors').owlCarousel({
    loop:true,
    margin:10,
    nav:false,
    autoplay:true,
    autoplayTimeout:5000,
    autoplayHoverPause:true,
    dots:true,
    responsive:{
        0:{
            items:1
        },
        600:{
            items:2
        },
        991:{
            items:3
        },
        1200:{
            items:3
        }
    }
});
/*$('#ourBlogs').owlCarousel({
    loop:false,
    nav:false,
    autoplay:true,
    autoplayTimeout:3000,
    autoplayHoverPause:true,
    dots:true,
    responsive:{
        0:{
            items:1
        },
        600:{
            items:2
        },
        991:{
            items:3
        },
        1200:{
            items:3
        }
    }
});*/





var vendorSlider = $('#ourServicesSlide').owlCarousel({
    loop:true,
    nav:false,
    autoplay:true,
    autoplayTimeout:5000,
    autoplayHoverPause:true,
    dots:true,
    responsive:{
        0:{
            items:1
        },
        600:{
            items:1
        },
        991:{
            items:1
        },
        1200:{
            items:1
        }
    }
   
});

    $('#ourServicesSlide').on('mouseenter',function(e){
    $(this).closest('.owl-carousel').trigger('stop.owl.autoplay');
  })
  $('#ourServicesSlide').on('mouseleave',function(e){
    $(this).closest('.owl-carousel').trigger('play.owl.autoplay',[1000]);
  })
   $('#ourVendors').on('mouseenter',function(e){
    $(this).closest('.owl-carousel').trigger('stop.owl.autoplay');
  })
  $('#ourVendors').on('mouseleave',function(e){
    $(this).closest('.owl-carousel').trigger('play.owl.autoplay',[1000]);
  })

/*$('#ourServicesSlide').owlCarousel({
    loop:true,
    nav:false,
    autoplay:true,
    autoplayTimeout:5000,
    autoplayHoverPause:true,
    dots:true,
    responsive:{
        0:{
            items:1
        },
        600:{
            items:1
        },
        991:{
            items:1
        },
        1200:{
            items:1
        }
    }
});
*/