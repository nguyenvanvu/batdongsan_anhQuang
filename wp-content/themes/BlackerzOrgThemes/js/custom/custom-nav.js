function pattinav() {
	
	// Menu Superfish Call //
	jQuery('ul#mainnav').superfish({
		delay: 800,
		speed: 'normal', 
		autoArrows: false,
		animation: {opacity:'show'},   
		animationOut: {opacity:'hide'}
	});		
}

function pattinav_extend() {


	jQuery("ul#mainnav li").css({ "overflow":"visible"});

	jQuery('#mainnav > li > a').wrapInner('<span></span>');	

	jQuery('#mainnav li.external').each(function() {
		jQuery(this).children('a').addClass('external');
		jQuery(this).removeClass('external');
	});


	var navn = jQuery("#navigation");
	jQuery("#navigation a").click(function () {
		if (navn.is(":visible") && navn.hasClass("mobile")) {
			navn.slideUp();
		}
	});		

	jQuery('.home #mainnav li').each(function() { 
		if(jQuery(this).hasClass('section-id')) {
			jQuery(this).addClass('current-menu-item')
		}
	});

	jQuery('#mainnav li').each(function() { 
		if(jQuery(this).hasClass('current-menu-item')) {
			jQuery(this).children('a').removeClass('external')
		}
		else {
			jQuery(this).children('a').addClass('external');
		}
	});

	// initial hello state
	if(jQuery('body').hasClass('home')) {
		jQuery('#mainnav li.initial').addClass('current')
	}

	// highlight on page
	if(!jQuery('body').hasClass('home')) {	
		jQuery('#mainnav li.current-menu-item').addClass('highlighted-state');
		jQuery('#mainnav li.current-menu-parent').addClass('highlighted-state')
	}

	//Scroll Nav
	jQuery('#mainnav').onePageNav({
		currentClass: 'current',
		filter: ':not(.external)',
		scrollOffset: dt_handler.scrolloffset
	});		

	// Fixed Element Height
	var headerheight = jQuery('#header').outerHeight();
	jQuery('.menu-fixer').css({'height': headerheight});		

}

jQuery(document).ready(function() {

	pattinav_extend();	
	
	jQuery('.single-portfolio #mainnav a[href*="' + dt_handler.curlink + '"]').parent('li').addClass('current');

});

jQuery(window).load(function() {

	pattinav();	
	
});