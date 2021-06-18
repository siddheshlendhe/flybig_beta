function vw_travel_menu_open_nav() {
	window.vw_travel_responsiveMenu=true;
	jQuery(".sidenav").addClass('show');
}
function vw_travel_menu_close_nav() {
	window.vw_travel_responsiveMenu=false;
 	jQuery(".sidenav").removeClass('show');
}

jQuery(function($){
 	"use strict";
   	jQuery('.main-menu > ul').superfish({
		delay:       500,
		animation:   {opacity:'show',height:'show'},  
		speed:       'fast'
   	});
});

jQuery(document).ready(function () {
	window.vw_travel_currentfocus=null;
  	vw_travel_checkfocusdElement();
	var vw_travel_body = document.querySelector('body');
	vw_travel_body.addEventListener('keyup', vw_travel_check_tab_press);
	var vw_travel_gotoHome = false;
	var vw_travel_gotoClose = false;
	window.vw_travel_responsiveMenu=false;
 	function vw_travel_checkfocusdElement(){
	 	if(window.vw_travel_currentfocus=document.activeElement.className){
		 	window.vw_travel_currentfocus=document.activeElement.className;
	 	}
 	}
 	function vw_travel_check_tab_press(e) {
		"use strict";
		e = e || event;
		var activeElement;

		if(window.innerWidth < 999){
		if (e.keyCode == 9) {
			if(window.vw_travel_responsiveMenu){
			if (!e.shiftKey) {
				if(vw_travel_gotoHome) {
					jQuery( ".main-menu ul:first li:first a:first-child" ).focus();
				}
			}
			if (jQuery("a.closebtn.mobile-menu").is(":focus")) {
				vw_travel_gotoHome = true;
			} else {
				vw_travel_gotoHome = false;
			}

		}else{

			if(window.vw_travel_currentfocus=="responsivetoggle"){
				jQuery( "" ).focus();
			}}}
		}
		if (e.shiftKey && e.keyCode == 9) {
		if(window.innerWidth < 999){
			if(window.vw_travel_currentfocus=="header-search"){
				jQuery(".responsivetoggle").focus();
			}else{
				if(window.vw_travel_responsiveMenu){
				if(vw_travel_gotoClose){
					jQuery("a.closebtn.mobile-menu").focus();
				}
				if (jQuery( ".main-menu ul:first li:first a:first-child" ).is(":focus")) {
					vw_travel_gotoClose = true;
				} else {
					vw_travel_gotoClose = false;
				}
			
			}else{

			if(window.responsiveMenu){
			}}}}
		}
	 	vw_travel_checkfocusdElement();
	}
});

(function( $ ) {
	jQuery(window).load(function() {
	    jQuery("#status").fadeOut();
	    jQuery("#preloader").delay(1000).fadeOut("slow");
	})
	$(window).scroll(function(){
		var sticky = $('.header-sticky'),
			scroll = $(window).scrollTop();

		if (scroll >= 100) sticky.addClass('header-fixed');
		else sticky.removeClass('header-fixed');
	});
	$(document).ready(function () {
		$(window).scroll(function () {
		    if ($(this).scrollTop() > 100) {
		        $('.scrollup i').fadeIn();
		    } else {
		        $('.scrollup i').fadeOut();
		    }
		});
		$('.scrollup i').click(function () {
		    $("html, body").animate({
		        scrollTop: 0
		    }, 600);
		    return false;
		});
	});
})( jQuery );

jQuery(document).ready(function () {
	  function vw_travel_search_loop_focus(element) {
	  var vw_travel_focus = element.find('select, input, textarea, button, a[href]');
	  var vw_travel_firstFocus = vw_travel_focus[0];  
	  var vw_travel_lastFocus = vw_travel_focus[vw_travel_focus.length - 1];
	  var KEYCODE_TAB = 9;

	  element.on('keydown', function vw_travel_search_loop_focus(e) {
	    var isTabPressed = (e.key === 'Tab' || e.keyCode === KEYCODE_TAB);

	    if (!isTabPressed) { 
	      return; 
	    }

	    if ( e.shiftKey ) /* shift + tab */ {
	      if (document.activeElement === vw_travel_firstFocus) {
	        vw_travel_lastFocus.focus();
	          e.preventDefault();
	        }
	      } else /* tab */ {
	      if (document.activeElement === vw_travel_lastFocus) {
	        vw_travel_firstFocus.focus();
	          e.preventDefault();
	        }
	      }
	  });
	}
	jQuery('.search-box span a').click(function(){
        jQuery(".serach_outer").slideDown(1000);
    	vw_travel_search_loop_focus(jQuery('.serach_outer'));
    });

    jQuery('.closepop a').click(function(){
        jQuery(".serach_outer").slideUp(1000);
    });
});