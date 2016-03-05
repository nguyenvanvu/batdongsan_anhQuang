// Portfolio Gallery Slider
jQuery(window).load(function() {	

	jQuery('.portfolio-slider[id^="owl-slider-"]').each( function() { 	

		var $div = jQuery(this);
		var token = $div.data('token');

		var settingObj = window['dt_slider_' + token];	
		if(settingObj.slider_speed == 'false') {
			settingObj.slider_speed = false;
		}		

		jQuery("#owl-slider-"+settingObj.id+"").owlCarousel({
			stopOnHover : true,
			navigation:true,
			navigationText: [
				  "<i class='fa fa-angle-left'></i>",
				  "<i class='fa fa-angle-right'></i>"
				  ],		
			paginationSpeed : 1000,
			goToFirstSpeed : 2000,
			autoPlay : settingObj.slider_speed,		
			singleItem : true,
			transitionStyle:"fade",
			autoHeight : true,
			afterAction: afterAction
		});		

		function afterAction(){
			jQuery('.slider-nav-'+settingObj.id+'').text(""+(this.owl.currentItem+1)+"/" + this.owl.owlItems.length+"");
		}	

	});
});