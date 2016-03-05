// Portfolio Gallery Slider
jQuery(window).load(function() {	

	jQuery('.carousel-clients[id^="owl-clients-"]').each( function() { 	

		var $div = jQuery(this);
		var token = $div.data('token');

		var settingObj = window['dt_clients_' + token];	
		if(settingObj.clients_speed == 'false') {
			settingObj.clients_speed = false;
		}

		jQuery("#owl-clients-"+settingObj.id+"").owlCarousel({
			items : settingObj.items_per_row,
			navigation:true,
			autoPlay: settingObj.clients_speed,
			slideSpeed : 1000
		});	
	});
});