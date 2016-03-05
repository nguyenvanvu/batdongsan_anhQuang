	// Gallery Blog Slider //
	
function gallery_slider() {			
	jQuery('.gallery-slider[id^="gs-"]').each( function() { 	
	
		var $div = jQuery(this);
		var token = $div.data('token');
		var settingObj = window['dt_gallery_' + token];
		
		jQuery('#gs-'+settingObj.post_id+'').owlCarousel({
			stopOnHover : true,
			navigation:true,
			navigationText: [
				  "<i class='fa fa-angle-left'></i>",
				  "<i class='fa fa-angle-right'></i>"
				  ],		
			paginationSpeed : 1000,
			goToFirstSpeed : 2000,
			singleItem : true,
			transitionStyle:"fade"
		});				
		
	});

}

jQuery(window).bind("load", function() {
	gallery_slider();
});