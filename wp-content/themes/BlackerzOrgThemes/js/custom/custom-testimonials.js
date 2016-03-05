	// Gallery Blog Slider //

// Testimonials Slider
jQuery(window).load(function() {	

	jQuery('.testimonials-slider[id^="owl-testimonials"]').each( function() { 	

		var $div = jQuery(this);
		var token = $div.data('token');

		var settingObj = window['dt_testimonials_' + token];	
		if((settingObj.testimonial_speed == '') || (settingObj.testimonial_speed == 'false')) {
			settingObj.testimonial_speed = false;
		}
		jQuery("#owl-testimonials-"+settingObj.id+"").owlCarousel({
			autoHeight : true,
			singleItem : true,
			autoPlay: settingObj.testimonial_speed,
			navigation:true,
			slideSpeed : 1000
		});
	});
});