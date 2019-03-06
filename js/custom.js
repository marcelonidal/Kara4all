/*
author: Boostraptheme
author URL: https://boostraptheme.com
License: Creative Commons Attribution 4.0 Unported
License URL: https://creativecommons.org/licenses/by/4.0/
*/

// ====================================================
                        // NAVIGATION
// ====================================================
	(function($) {
	    "use strict"; // Start of use strict

	    // Closes responsive menu when a scroll trigger link is clicked
	    $('.js-scroll-trigger').click(function() {
	      $('.navbar-collapse').collapse('hide');
	    });

	    // Activate scrollspy to add active class to navbar items on scroll
	    $('body').scrollspy({
	      target: '#mainNav',
	      offset: 62
	    }); 


      //fixed navbar
      var toggleAffix = function(affixElement, scrollElement, wrapper) {
      
        var height = affixElement.outerHeight(),
            top = wrapper.offset().top;
        
        if (scrollElement.scrollTop() >= top){
            wrapper.height(height);
            affixElement.addClass("affix");
        }
        else {
            affixElement.removeClass("affix");
            wrapper.height('auto');
        }
          
      };

      $('[data-toggle="affix"]').each(function() {
        var ele = $(this),
            wrapper = $('<div></div>');
        
        ele.before(wrapper);
        $(window).on('scroll resize', function() {
            toggleAffix(ele, $(this), wrapper);
        });
        
        // init
        toggleAffix(ele, $(window), wrapper);
      });
      
        // Hover dropdown 
        $('ul.navbar-nav li.dropdown').hover(function() {
          $(this).find('.dropdown-menu').stop(true, true).delay(200).fadeIn(500);
        }, function() {
          $(this).find('.dropdown-menu').stop(true, true).delay(200).fadeOut(500);
        });

	})(jQuery); // End of use strict

//====================================================
// CONFIG DO TOASTR PARA MENSAGENS POPUP
//====================================================
//warning info success error
toastr.options = {
    "preventDuplicates": true,
    "preventOpenDuplicates": true,
    "positionClass": "toast-top-center",
    "timeOut": "5000",
    "onclick": null,
    "progressBar": true,
    "closeButton": false,
    "newestOnTop": false
}

//====================================================
// SCROLL PARA O ELEMENTO
//====================================================

function scrollToElement(e) {
    $('html,body').animate({
        scrollTop: e.offset().top - $(window).height() / 2
    }, 500);
}