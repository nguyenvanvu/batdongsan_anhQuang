<?php

add_action('admin_init', 'retrieve_my_terms', 9999);

function retrieve_my_terms() {
if (is_admin()){

	
	global $termeni;

	$termeni = get_terms('portfolio_cats', array('hide_empty' => false));
	global $catarray;
	$catarray = array();
	foreach ($termeni as $term) {
		$catarray[$term->term_id] = $term->name;
		if (function_exists('icl_register_string')) {
		icl_register_string('Portfolio Category', 'Term '.$term->term_id.'', $term->name);
		}
	}	
  
  //prefix   
  $prefix = 'dt_';
  
  
/*-----------------------------------------------------------------------------------*/
/*	Pages Metaboxes
/*-----------------------------------------------------------------------------------*/  


// Metaboxes for All Pages
	$config = array(
		'id' => 'dt_page_options',	
		'title' => 'Page Options (optional)',	
		'pages' => array('page'),
		'context' => 'normal',	
		'priority' => 'default',	
		'fields' => array(),	
		'local_images' => false,	
		'use_with_theme' => true
	);	
	
	$page_options =  new AT_Meta_Box($config);

	$page_options->addText($prefix.'page_tagline',array('name'=> 'Title Tagline', 'desc' => 'You can set a tagline for the title.', ));	
	$page_options->addCheckbox($prefix.'page_title',array('name'=> 'Disable Title Section', 'desc' => 'You can disable the entire page title section and use Visual Composer to build your page on a blank canvas.', ));

	$page_options->Finish();

	//Portfolio Options Boxes
	$config = array(
		'id' => 'dt_portfolio_options',		
		'title' => 'Portfolio Page Options',		
		'pages' => array('page'),	
		'context' => 'normal',					
		'priority' => 'high',					
		'fields' => array(),					
		'local_images' => false,				
		'use_with_theme' => true				
	);
	
	$portfolio_options =  new AT_Meta_Box($config);	
	
	$portfolio_options->addImageRadio($prefix.'portfolio_columns',array('grid' => 'Grid'),array('name'=> 'Portfolio Layout', 'std'=> array('grid')));
	
	$portfolio_options->addRadio($prefix.'portfolio_navigation',array('filter'=>'With Filter','no-filter'=>'Without Filter'),array('name'=> 'Portfolio Type', 'std'=> array('filter')));
	
	$portfolio_options->addText($prefix.'nav_number',array('name'=> 'How many items would you like to display on this portfolio page? (working only if "Without Filter" option is selected.)', 'desc' => 'Please enter a number in the box (Default number is 8)', 'std'=> '8'));	
	
	
	$portfolio_options->addCheckboxList($prefix.'cats_field', $catarray ,array('name'=> 'Portfolio Categories ', 'desc'=>'Set from which categories to display projects.'));	
	
	$portfolio_options->Finish();
	
	

	// Metaboxes for Blog Page
	$config = array(
		'id' => 'dt_blog_options',	
		'title' => 'Blog Layout Options',	
		'pages' => array('page'),
		'context' => 'normal',	
		'priority' => 'high',	
		'fields' => array(),	
		'local_images' => false,	
		'use_with_theme' => true
	);
	
	$blog_options =  new AT_Meta_Box($config);

	$blog_options->addImageRadio($prefix.'blog_layout',array('masonry-3-cols'=>'Masonry - 3 Columns', 'masonry-2-cols'=>'Masonry - 2 Columns', 'masonry-2-cols-sidebar-right' => 'Masonry - 2 Columns with Right Sidebar', 'masonry-2-cols-sidebar-left' => 'Masonry - 2 Columns with Left Sidebar', 'sidebar-right'=>'Right Sidebar','sidebar-left'=>'Left Sidebar', 'no-blog-sidebar'=>'No Sidebar'),array('name'=> 'Blog Layout (regular or masonry layout)', 'std'=> array('masonry-3-cols')));
	$blog_options->addInfo($prefix.'info_blog_layout',array('name'=> '', 'desc' => 'You can choose whether to use a masonry layout or the regular layout with left or right sidebar for the blog page. If you choose "Right Sidebar" or "Left Sidebar" option, make sure to set a sidebar too, from "Page Layout" metabox(top-right area of the screen). "Sidebar position" option is disabled for this page template.', 'std'=> ''));	
	$blog_options->addTaxonomy($prefix.'blog_categories',array('taxonomy' => 'category', 'type' => 'checkbox_list'),array('name'=> 'Display blog posts only from certain categories ', 'desc' => 'If you want to display blog posts only from certain categories, select them from the list. Choosing none will display posts from all of them.'));
	$blog_options->addText($prefix.'posts_number',array('name'=> 'How many items would you like to display on this blog page? ', 'desc' => 'Default: 10 blog posts', 'std' => '10'));

	$blog_options->Finish();	  
	
	// Metaboxes for Services Page
	$config = array(
		'id' => 'dt_services_options',	
		'title' => 'Service Item Options',	
		'pages' => array('services'),
		'context' => 'normal',	
		'priority' => 'high',	
		'fields' => array(),	
		'local_images' => false,	
		'use_with_theme' => true
	);	

	// Retrieve Fontawesome icons as an array, based on the minimized css file
  	/* 
  	$pattern = '/\.(fa-(?:\w+(?:-)?)+):before{content:"/';
	
	$request = new WP_Http;
	$subject = $request->request( get_template_directory_uri() . '/framework/fonts/font-awesome/css/font-awesome.css' );				
	
	preg_match_all($pattern, $subject['body'], $matches, PREG_SET_ORDER);
	$icons = array();
	
	if(!empty($subject['body'])) {
		foreach($matches as $match){
			$icons[$match[1]] = $match[1];
		}

		foreach ($icons as $icon) {
			printf('"' .$icon.'" => "'. $icon .'" , ');
			// printf('"' .$icon.'" , ');

		}
	}
	/*
	else { 
		*/

		// local fallback
		// fontawesome 4.3.0
		$icons = array("fa-glass" => "fa-glass" , "fa-music" => "fa-music" , "fa-search" => "fa-search" , "fa-envelope-o" => "fa-envelope-o" , "fa-heart" => "fa-heart" , "fa-star" => "fa-star" , "fa-star-o" => "fa-star-o" , "fa-user" => "fa-user" , "fa-film" => "fa-film" , "fa-th-large" => "fa-th-large" , "fa-th" => "fa-th" , "fa-th-list" => "fa-th-list" , "fa-check" => "fa-check" , "fa-times" => "fa-times" , "fa-search-plus" => "fa-search-plus" , "fa-search-minus" => "fa-search-minus" , "fa-power-off" => "fa-power-off" , "fa-signal" => "fa-signal" , "fa-cog" => "fa-cog" , "fa-trash-o" => "fa-trash-o" , "fa-home" => "fa-home" , "fa-file-o" => "fa-file-o" , "fa-clock-o" => "fa-clock-o" , "fa-road" => "fa-road" , "fa-download" => "fa-download" , "fa-arrow-circle-o-down" => "fa-arrow-circle-o-down" , "fa-arrow-circle-o-up" => "fa-arrow-circle-o-up" , "fa-inbox" => "fa-inbox" , "fa-play-circle-o" => "fa-play-circle-o" , "fa-repeat" => "fa-repeat" , "fa-refresh" => "fa-refresh" , "fa-list-alt" => "fa-list-alt" , "fa-lock" => "fa-lock" , "fa-flag" => "fa-flag" , "fa-headphones" => "fa-headphones" , "fa-volume-off" => "fa-volume-off" , "fa-volume-down" => "fa-volume-down" , "fa-volume-up" => "fa-volume-up" , "fa-qrcode" => "fa-qrcode" , "fa-barcode" => "fa-barcode" , "fa-tag" => "fa-tag" , "fa-tags" => "fa-tags" , "fa-book" => "fa-book" , "fa-bookmark" => "fa-bookmark" , "fa-print" => "fa-print" , "fa-camera" => "fa-camera" , "fa-font" => "fa-font" , "fa-bold" => "fa-bold" , "fa-italic" => "fa-italic" , "fa-text-height" => "fa-text-height" , "fa-text-width" => "fa-text-width" , "fa-align-left" => "fa-align-left" , "fa-align-center" => "fa-align-center" , "fa-align-right" => "fa-align-right" , "fa-align-justify" => "fa-align-justify" , "fa-list" => "fa-list" , "fa-outdent" => "fa-outdent" , "fa-indent" => "fa-indent" , "fa-video-camera" => "fa-video-camera" , "fa-picture-o" => "fa-picture-o" , "fa-pencil" => "fa-pencil" , "fa-map-marker" => "fa-map-marker" , "fa-adjust" => "fa-adjust" , "fa-tint" => "fa-tint" , "fa-pencil-square-o" => "fa-pencil-square-o" , "fa-share-square-o" => "fa-share-square-o" , "fa-check-square-o" => "fa-check-square-o" , "fa-arrows" => "fa-arrows" , "fa-step-backward" => "fa-step-backward" , "fa-fast-backward" => "fa-fast-backward" , "fa-backward" => "fa-backward" , "fa-play" => "fa-play" , "fa-pause" => "fa-pause" , "fa-stop" => "fa-stop" , "fa-forward" => "fa-forward" , "fa-fast-forward" => "fa-fast-forward" , "fa-step-forward" => "fa-step-forward" , "fa-eject" => "fa-eject" , "fa-chevron-left" => "fa-chevron-left" , "fa-chevron-right" => "fa-chevron-right" , "fa-plus-circle" => "fa-plus-circle" , "fa-minus-circle" => "fa-minus-circle" , "fa-times-circle" => "fa-times-circle" , "fa-check-circle" => "fa-check-circle" , "fa-question-circle" => "fa-question-circle" , "fa-info-circle" => "fa-info-circle" , "fa-crosshairs" => "fa-crosshairs" , "fa-times-circle-o" => "fa-times-circle-o" , "fa-check-circle-o" => "fa-check-circle-o" , "fa-ban" => "fa-ban" , "fa-arrow-left" => "fa-arrow-left" , "fa-arrow-right" => "fa-arrow-right" , "fa-arrow-up" => "fa-arrow-up" , "fa-arrow-down" => "fa-arrow-down" , "fa-share" => "fa-share" , "fa-expand" => "fa-expand" , "fa-compress" => "fa-compress" , "fa-plus" => "fa-plus" , "fa-minus" => "fa-minus" , "fa-asterisk" => "fa-asterisk" , "fa-exclamation-circle" => "fa-exclamation-circle" , "fa-gift" => "fa-gift" , "fa-leaf" => "fa-leaf" , "fa-fire" => "fa-fire" , "fa-eye" => "fa-eye" , "fa-eye-slash" => "fa-eye-slash" , "fa-exclamation-triangle" => "fa-exclamation-triangle" , "fa-plane" => "fa-plane" , "fa-calendar" => "fa-calendar" , "fa-random" => "fa-random" , "fa-comment" => "fa-comment" , "fa-magnet" => "fa-magnet" , "fa-chevron-up" => "fa-chevron-up" , "fa-chevron-down" => "fa-chevron-down" , "fa-retweet" => "fa-retweet" , "fa-shopping-cart" => "fa-shopping-cart" , "fa-folder" => "fa-folder" , "fa-folder-open" => "fa-folder-open" , "fa-arrows-v" => "fa-arrows-v" , "fa-arrows-h" => "fa-arrows-h" , "fa-bar-chart" => "fa-bar-chart" , "fa-twitter-square" => "fa-twitter-square" , "fa-facebook-square" => "fa-facebook-square" , "fa-camera-retro" => "fa-camera-retro" , "fa-key" => "fa-key" , "fa-cogs" => "fa-cogs" , "fa-comments" => "fa-comments" , "fa-thumbs-o-up" => "fa-thumbs-o-up" , "fa-thumbs-o-down" => "fa-thumbs-o-down" , "fa-star-half" => "fa-star-half" , "fa-heart-o" => "fa-heart-o" , "fa-sign-out" => "fa-sign-out" , "fa-linkedin-square" => "fa-linkedin-square" , "fa-thumb-tack" => "fa-thumb-tack" , "fa-external-link" => "fa-external-link" , "fa-sign-in" => "fa-sign-in" , "fa-trophy" => "fa-trophy" , "fa-github-square" => "fa-github-square" , "fa-upload" => "fa-upload" , "fa-lemon-o" => "fa-lemon-o" , "fa-phone" => "fa-phone" , "fa-square-o" => "fa-square-o" , "fa-bookmark-o" => "fa-bookmark-o" , "fa-phone-square" => "fa-phone-square" , "fa-twitter" => "fa-twitter" , "fa-facebook" => "fa-facebook" , "fa-github" => "fa-github" , "fa-unlock" => "fa-unlock" , "fa-credit-card" => "fa-credit-card" , "fa-rss" => "fa-rss" , "fa-hdd-o" => "fa-hdd-o" , "fa-bullhorn" => "fa-bullhorn" , "fa-bell" => "fa-bell" , "fa-certificate" => "fa-certificate" , "fa-hand-o-right" => "fa-hand-o-right" , "fa-hand-o-left" => "fa-hand-o-left" , "fa-hand-o-up" => "fa-hand-o-up" , "fa-hand-o-down" => "fa-hand-o-down" , "fa-arrow-circle-left" => "fa-arrow-circle-left" , "fa-arrow-circle-right" => "fa-arrow-circle-right" , "fa-arrow-circle-up" => "fa-arrow-circle-up" , "fa-arrow-circle-down" => "fa-arrow-circle-down" , "fa-globe" => "fa-globe" , "fa-wrench" => "fa-wrench" , "fa-tasks" => "fa-tasks" , "fa-filter" => "fa-filter" , "fa-briefcase" => "fa-briefcase" , "fa-arrows-alt" => "fa-arrows-alt" , "fa-users" => "fa-users" , "fa-link" => "fa-link" , "fa-cloud" => "fa-cloud" , "fa-flask" => "fa-flask" , "fa-scissors" => "fa-scissors" , "fa-files-o" => "fa-files-o" , "fa-paperclip" => "fa-paperclip" , "fa-floppy-o" => "fa-floppy-o" , "fa-square" => "fa-square" , "fa-bars" => "fa-bars" , "fa-list-ul" => "fa-list-ul" , "fa-list-ol" => "fa-list-ol" , "fa-strikethrough" => "fa-strikethrough" , "fa-underline" => "fa-underline" , "fa-table" => "fa-table" , "fa-magic" => "fa-magic" , "fa-truck" => "fa-truck" , "fa-pinterest" => "fa-pinterest" , "fa-pinterest-square" => "fa-pinterest-square" , "fa-google-plus-square" => "fa-google-plus-square" , "fa-google-plus" => "fa-google-plus" , "fa-money" => "fa-money" , "fa-caret-down" => "fa-caret-down" , "fa-caret-up" => "fa-caret-up" , "fa-caret-left" => "fa-caret-left" , "fa-caret-right" => "fa-caret-right" , "fa-columns" => "fa-columns" , "fa-sort" => "fa-sort" , "fa-sort-desc" => "fa-sort-desc" , "fa-sort-asc" => "fa-sort-asc" , "fa-envelope" => "fa-envelope" , "fa-linkedin" => "fa-linkedin" , "fa-undo" => "fa-undo" , "fa-gavel" => "fa-gavel" , "fa-tachometer" => "fa-tachometer" , "fa-comment-o" => "fa-comment-o" , "fa-comments-o" => "fa-comments-o" , "fa-bolt" => "fa-bolt" , "fa-sitemap" => "fa-sitemap" , "fa-umbrella" => "fa-umbrella" , "fa-clipboard" => "fa-clipboard" , "fa-lightbulb-o" => "fa-lightbulb-o" , "fa-exchange" => "fa-exchange" , "fa-cloud-download" => "fa-cloud-download" , "fa-cloud-upload" => "fa-cloud-upload" , "fa-user-md" => "fa-user-md" , "fa-stethoscope" => "fa-stethoscope" , "fa-suitcase" => "fa-suitcase" , "fa-bell-o" => "fa-bell-o" , "fa-coffee" => "fa-coffee" , "fa-cutlery" => "fa-cutlery" , "fa-file-text-o" => "fa-file-text-o" , "fa-building-o" => "fa-building-o" , "fa-hospital-o" => "fa-hospital-o" , "fa-ambulance" => "fa-ambulance" , "fa-medkit" => "fa-medkit" , "fa-fighter-jet" => "fa-fighter-jet" , "fa-beer" => "fa-beer" , "fa-h-square" => "fa-h-square" , "fa-plus-square" => "fa-plus-square" , "fa-angle-double-left" => "fa-angle-double-left" , "fa-angle-double-right" => "fa-angle-double-right" , "fa-angle-double-up" => "fa-angle-double-up" , "fa-angle-double-down" => "fa-angle-double-down" , "fa-angle-left" => "fa-angle-left" , "fa-angle-right" => "fa-angle-right" , "fa-angle-up" => "fa-angle-up" , "fa-angle-down" => "fa-angle-down" , "fa-desktop" => "fa-desktop" , "fa-laptop" => "fa-laptop" , "fa-tablet" => "fa-tablet" , "fa-mobile" => "fa-mobile" , "fa-circle-o" => "fa-circle-o" , "fa-quote-left" => "fa-quote-left" , "fa-quote-right" => "fa-quote-right" , "fa-spinner" => "fa-spinner" , "fa-circle" => "fa-circle" , "fa-reply" => "fa-reply" , "fa-github-alt" => "fa-github-alt" , "fa-folder-o" => "fa-folder-o" , "fa-folder-open-o" => "fa-folder-open-o" , "fa-smile-o" => "fa-smile-o" , "fa-frown-o" => "fa-frown-o" , "fa-meh-o" => "fa-meh-o" , "fa-gamepad" => "fa-gamepad" , "fa-keyboard-o" => "fa-keyboard-o" , "fa-flag-o" => "fa-flag-o" , "fa-flag-checkered" => "fa-flag-checkered" , "fa-terminal" => "fa-terminal" , "fa-code" => "fa-code" , "fa-reply-all" => "fa-reply-all" , "fa-star-half-o" => "fa-star-half-o" , "fa-location-arrow" => "fa-location-arrow" , "fa-crop" => "fa-crop" , "fa-code-fork" => "fa-code-fork" , "fa-chain-broken" => "fa-chain-broken" , "fa-question" => "fa-question" , "fa-info" => "fa-info" , "fa-exclamation" => "fa-exclamation" , "fa-superscript" => "fa-superscript" , "fa-subscript" => "fa-subscript" , "fa-eraser" => "fa-eraser" , "fa-puzzle-piece" => "fa-puzzle-piece" , "fa-microphone" => "fa-microphone" , "fa-microphone-slash" => "fa-microphone-slash" , "fa-shield" => "fa-shield" , "fa-calendar-o" => "fa-calendar-o" , "fa-fire-extinguisher" => "fa-fire-extinguisher" , "fa-rocket" => "fa-rocket" , "fa-maxcdn" => "fa-maxcdn" , "fa-chevron-circle-left" => "fa-chevron-circle-left" , "fa-chevron-circle-right" => "fa-chevron-circle-right" , "fa-chevron-circle-up" => "fa-chevron-circle-up" , "fa-chevron-circle-down" => "fa-chevron-circle-down" , "fa-html5" => "fa-html5" , "fa-css3" => "fa-css3" , "fa-anchor" => "fa-anchor" , "fa-unlock-alt" => "fa-unlock-alt" , "fa-bullseye" => "fa-bullseye" , "fa-ellipsis-h" => "fa-ellipsis-h" , "fa-ellipsis-v" => "fa-ellipsis-v" , "fa-rss-square" => "fa-rss-square" , "fa-play-circle" => "fa-play-circle" , "fa-ticket" => "fa-ticket" , "fa-minus-square" => "fa-minus-square" , "fa-minus-square-o" => "fa-minus-square-o" , "fa-level-up" => "fa-level-up" , "fa-level-down" => "fa-level-down" , "fa-check-square" => "fa-check-square" , "fa-pencil-square" => "fa-pencil-square" , "fa-external-link-square" => "fa-external-link-square" , "fa-share-square" => "fa-share-square" , "fa-compass" => "fa-compass" , "fa-caret-square-o-down" => "fa-caret-square-o-down" , "fa-caret-square-o-up" => "fa-caret-square-o-up" , "fa-caret-square-o-right" => "fa-caret-square-o-right" , "fa-eur" => "fa-eur" , "fa-gbp" => "fa-gbp" , "fa-usd" => "fa-usd" , "fa-inr" => "fa-inr" , "fa-jpy" => "fa-jpy" , "fa-rub" => "fa-rub" , "fa-krw" => "fa-krw" , "fa-btc" => "fa-btc" , "fa-file" => "fa-file" , "fa-file-text" => "fa-file-text" , "fa-sort-alpha-asc" => "fa-sort-alpha-asc" , "fa-sort-alpha-desc" => "fa-sort-alpha-desc" , "fa-sort-amount-asc" => "fa-sort-amount-asc" , "fa-sort-amount-desc" => "fa-sort-amount-desc" , "fa-sort-numeric-asc" => "fa-sort-numeric-asc" , "fa-sort-numeric-desc" => "fa-sort-numeric-desc" , "fa-thumbs-up" => "fa-thumbs-up" , "fa-thumbs-down" => "fa-thumbs-down" , "fa-youtube-square" => "fa-youtube-square" , "fa-youtube" => "fa-youtube" , "fa-xing" => "fa-xing" , "fa-xing-square" => "fa-xing-square" , "fa-youtube-play" => "fa-youtube-play" , "fa-dropbox" => "fa-dropbox" , "fa-stack-overflow" => "fa-stack-overflow" , "fa-instagram" => "fa-instagram" , "fa-flickr" => "fa-flickr" , "fa-adn" => "fa-adn" , "fa-bitbucket" => "fa-bitbucket" , "fa-bitbucket-square" => "fa-bitbucket-square" , "fa-tumblr" => "fa-tumblr" , "fa-tumblr-square" => "fa-tumblr-square" , "fa-long-arrow-down" => "fa-long-arrow-down" , "fa-long-arrow-up" => "fa-long-arrow-up" , "fa-long-arrow-left" => "fa-long-arrow-left" , "fa-long-arrow-right" => "fa-long-arrow-right" , "fa-apple" => "fa-apple" , "fa-windows" => "fa-windows" , "fa-android" => "fa-android" , "fa-linux" => "fa-linux" , "fa-dribbble" => "fa-dribbble" , "fa-skype" => "fa-skype" , "fa-foursquare" => "fa-foursquare" , "fa-trello" => "fa-trello" , "fa-female" => "fa-female" , "fa-male" => "fa-male" , "fa-gratipay" => "fa-gratipay" , "fa-sun-o" => "fa-sun-o" , "fa-moon-o" => "fa-moon-o" , "fa-archive" => "fa-archive" , "fa-bug" => "fa-bug" , "fa-vk" => "fa-vk" , "fa-weibo" => "fa-weibo" , "fa-renren" => "fa-renren" , "fa-pagelines" => "fa-pagelines" , "fa-stack-exchange" => "fa-stack-exchange" , "fa-arrow-circle-o-right" => "fa-arrow-circle-o-right" , "fa-arrow-circle-o-left" => "fa-arrow-circle-o-left" , "fa-caret-square-o-left" => "fa-caret-square-o-left" , "fa-dot-circle-o" => "fa-dot-circle-o" , "fa-wheelchair" => "fa-wheelchair" , "fa-vimeo-square" => "fa-vimeo-square" , "fa-try" => "fa-try" , "fa-plus-square-o" => "fa-plus-square-o" , "fa-space-shuttle" => "fa-space-shuttle" , "fa-slack" => "fa-slack" , "fa-envelope-square" => "fa-envelope-square" , "fa-wordpress" => "fa-wordpress" , "fa-openid" => "fa-openid" , "fa-university" => "fa-university" , "fa-graduation-cap" => "fa-graduation-cap" , "fa-yahoo" => "fa-yahoo" , "fa-google" => "fa-google" , "fa-reddit" => "fa-reddit" , "fa-reddit-square" => "fa-reddit-square" , "fa-stumbleupon-circle" => "fa-stumbleupon-circle" , "fa-stumbleupon" => "fa-stumbleupon" , "fa-delicious" => "fa-delicious" , "fa-digg" => "fa-digg" , "fa-pied-piper" => "fa-pied-piper" , "fa-pied-piper-alt" => "fa-pied-piper-alt" , "fa-drupal" => "fa-drupal" , "fa-joomla" => "fa-joomla" , "fa-language" => "fa-language" , "fa-fax" => "fa-fax" , "fa-building" => "fa-building" , "fa-child" => "fa-child" , "fa-paw" => "fa-paw" , "fa-spoon" => "fa-spoon" , "fa-cube" => "fa-cube" , "fa-cubes" => "fa-cubes" , "fa-behance" => "fa-behance" , "fa-behance-square" => "fa-behance-square" , "fa-steam" => "fa-steam" , "fa-steam-square" => "fa-steam-square" , "fa-recycle" => "fa-recycle" , "fa-car" => "fa-car" , "fa-taxi" => "fa-taxi" , "fa-tree" => "fa-tree" , "fa-spotify" => "fa-spotify" , "fa-deviantart" => "fa-deviantart" , "fa-soundcloud" => "fa-soundcloud" , "fa-database" => "fa-database" , "fa-file-pdf-o" => "fa-file-pdf-o" , "fa-file-word-o" => "fa-file-word-o" , "fa-file-excel-o" => "fa-file-excel-o" , "fa-file-powerpoint-o" => "fa-file-powerpoint-o" , "fa-file-image-o" => "fa-file-image-o" , "fa-file-archive-o" => "fa-file-archive-o" , "fa-file-audio-o" => "fa-file-audio-o" , "fa-file-video-o" => "fa-file-video-o" , "fa-file-code-o" => "fa-file-code-o" , "fa-vine" => "fa-vine" , "fa-codepen" => "fa-codepen" , "fa-jsfiddle" => "fa-jsfiddle" , "fa-life-ring" => "fa-life-ring" , "fa-circle-o-notch" => "fa-circle-o-notch" , "fa-rebel" => "fa-rebel" , "fa-empire" => "fa-empire" , "fa-git-square" => "fa-git-square" , "fa-git" => "fa-git" , "fa-hacker-news" => "fa-hacker-news" , "fa-tencent-weibo" => "fa-tencent-weibo" , "fa-qq" => "fa-qq" , "fa-weixin" => "fa-weixin" , "fa-paper-plane" => "fa-paper-plane" , "fa-paper-plane-o" => "fa-paper-plane-o" , "fa-history" => "fa-history" , "fa-circle-thin" => "fa-circle-thin" , "fa-header" => "fa-header" , "fa-paragraph" => "fa-paragraph" , "fa-sliders" => "fa-sliders" , "fa-share-alt" => "fa-share-alt" , "fa-share-alt-square" => "fa-share-alt-square" , "fa-bomb" => "fa-bomb" , "fa-futbol-o" => "fa-futbol-o" , "fa-tty" => "fa-tty" , "fa-binoculars" => "fa-binoculars" , "fa-plug" => "fa-plug" , "fa-slideshare" => "fa-slideshare" , "fa-twitch" => "fa-twitch" , "fa-yelp" => "fa-yelp" , "fa-newspaper-o" => "fa-newspaper-o" , "fa-wifi" => "fa-wifi" , "fa-calculator" => "fa-calculator" , "fa-paypal" => "fa-paypal" , "fa-google-wallet" => "fa-google-wallet" , "fa-cc-visa" => "fa-cc-visa" , "fa-cc-mastercard" => "fa-cc-mastercard" , "fa-cc-discover" => "fa-cc-discover" , "fa-cc-amex" => "fa-cc-amex" , "fa-cc-paypal" => "fa-cc-paypal" , "fa-cc-stripe" => "fa-cc-stripe" , "fa-bell-slash" => "fa-bell-slash" , "fa-bell-slash-o" => "fa-bell-slash-o" , "fa-trash" => "fa-trash" , "fa-copyright" => "fa-copyright" , "fa-at" => "fa-at" , "fa-eyedropper" => "fa-eyedropper" , "fa-paint-brush" => "fa-paint-brush" , "fa-birthday-cake" => "fa-birthday-cake" , "fa-area-chart" => "fa-area-chart" , "fa-pie-chart" => "fa-pie-chart" , "fa-line-chart" => "fa-line-chart" , "fa-lastfm" => "fa-lastfm" , "fa-lastfm-square" => "fa-lastfm-square" , "fa-toggle-off" => "fa-toggle-off" , "fa-toggle-on" => "fa-toggle-on" , "fa-bicycle" => "fa-bicycle" , "fa-bus" => "fa-bus" , "fa-ioxhost" => "fa-ioxhost" , "fa-angellist" => "fa-angellist" , "fa-cc" => "fa-cc" , "fa-ils" => "fa-ils" , "fa-meanpath" => "fa-meanpath" , "fa-buysellads" => "fa-buysellads" , "fa-connectdevelop" => "fa-connectdevelop" , "fa-dashcube" => "fa-dashcube" , "fa-forumbee" => "fa-forumbee" , "fa-leanpub" => "fa-leanpub" , "fa-sellsy" => "fa-sellsy" , "fa-shirtsinbulk" => "fa-shirtsinbulk" , "fa-simplybuilt" => "fa-simplybuilt" , "fa-skyatlas" => "fa-skyatlas" , "fa-cart-plus" => "fa-cart-plus" , "fa-cart-arrow-down" => "fa-cart-arrow-down" , "fa-diamond" => "fa-diamond" , "fa-ship" => "fa-ship" , "fa-user-secret" => "fa-user-secret" , "fa-motorcycle" => "fa-motorcycle" , "fa-street-view" => "fa-street-view" , "fa-heartbeat" => "fa-heartbeat" , "fa-venus" => "fa-venus" , "fa-mars" => "fa-mars" , "fa-mercury" => "fa-mercury" , "fa-transgender" => "fa-transgender" , "fa-transgender-alt" => "fa-transgender-alt" , "fa-venus-double" => "fa-venus-double" , "fa-mars-double" => "fa-mars-double" , "fa-venus-mars" => "fa-venus-mars" , "fa-mars-stroke" => "fa-mars-stroke" , "fa-mars-stroke-v" => "fa-mars-stroke-v" , "fa-mars-stroke-h" => "fa-mars-stroke-h" , "fa-neuter" => "fa-neuter" , "fa-facebook-official" => "fa-facebook-official" , "fa-pinterest-p" => "fa-pinterest-p" , "fa-whatsapp" => "fa-whatsapp" , "fa-server" => "fa-server" , "fa-user-plus" => "fa-user-plus" , "fa-user-times" => "fa-user-times" , "fa-bed" => "fa-bed" , "fa-viacoin" => "fa-viacoin" , "fa-train" => "fa-train" , "fa-subway" => "fa-subway" , "fa-medium" => "fa-medium");	
	// }
	
	$services_options =  new AT_Meta_Box($config);
	$services_options->addTextarea($prefix.'service_text',array('name'=> 'Service Text', 'desc' => 'Add your text for the service item.', 'std'=> ''));	
	$services_options->addSelectIcon($prefix.'service_icon', $icons ,array('name'=> 'Service Icon', 'std'=> array('fa-glass'), 'desc' => 'Select an icon for your service item. Icons belong to <a href="http://fortawesome.github.io/Font-Awesome/" target="_blank">FontAwesome</a>, the iconic font designed for Bootstrap.'));
	// $services_options->addImageRadio($prefix.'service_style',array('service-style-2'=>'Service Style 2', 'service-style-1'=>'Service Style 1'),array('name'=> 'Service Style', 'std'=> array('service-style-2'), 'desc' => ''));

	$services_options->Finish();	  
	
	

/*-----------------------------------------------------------------------------------
/*	Blog Post Formats
/*-----------------------------------------------------------------------------------*/  
  
	// Metaboxes for Standard Post Format
	$config = array(
		'id' => 'dt_standard_post_custom_fields',	
		'title' => 'Standard Post Format Options',	
		'pages' => array('post'),
		'context' => 'normal',	
		'priority' => 'high',	
		'fields' => array(),	
		'local_images' => false,	
		'use_with_theme' => true
	);
	
	$standard_post =  new AT_Meta_Box($config);

	$standard_post->addSelect($prefix.'standard_select',array('selectkey1'=>'Display the featured image','selectkey2'=>'Don`t display the featured image'),array('name'=> 'Featured image options for listing pages(blog pages)', 'std'=> array('selectkey1'), 'desc' => 'Choose whether to display the featured image or not on blog listing pages. Make sure you set a "Featured Image" by using the box from right-bottom side of the screen.'));

	$standard_post->Finish();	  
	
  
  
	// Metaboxes for Gallery Post Format
	$config = array(
		'id' => 'dt_gallery_post_custom_fields',	
		'title' => 'Gallery Post Format Options',	
		'pages' => array('post'),
		'context' => 'normal',	
		'priority' => 'high',	
		'fields' => array(),	
		'local_images' => false,	
		'use_with_theme' => true
	);
	
	$gallery_post =  new AT_Meta_Box($config);

	$gallery_fields[] = $gallery_post->addImage($prefix.'gallery_post',array('desc' => '', 'name'=> 'Photo URL ', 'class'=>'image-field'),true);
	$gallery_fields[] = $gallery_post->addText($prefix.'gallery_photo_name',array('name'=> 'Photo Name '), true);
	$gallery_fields[] = $gallery_post->addText($prefix.'gallery_photo_desc',array('name'=> 'Photo Description '), true);

	
	$gallery_post->addRepeaterBlock($prefix.'gallery_block',array('desc' => 'Upload images for the gallery. They will be grouped into a slider','inline' => true, 'name' => 'Gallery Images','fields' => $gallery_fields, 'sortable' => true));
	
	//$gallery_post->addSelect($prefix.'gallery_select',array('selectkey1'=>'Display the gallery same as on single page','selectkey2'=>'Display only the first image from gallery as featured image', 'selectkey3' => 'Don`t display any image/gallery'),array('name'=> 'Displaying gallery in listing pages(blog page)', 'std'=> array('selectkey1'), 'desc' => 'Choose whether to display the gallery, only the first image or none on blog listing pages.'));

	$gallery_post->Finish();		
	
  
  
	// Metaboxes for Link Post Format
	$config = array(
		'id' => 'dt_link_post_custom_fields',	
		'title' => 'Link Post Format Options',	
		'pages' => array('post'),
		'context' => 'normal',	
		'priority' => 'high',	
		'fields' => array(),	
		'local_images' => false,	
		'use_with_theme' => true
	);
	
	$link_post =  new AT_Meta_Box($config);

	$link_post->addText($prefix.'link_block',array('name'=> 'Link URL', 'desc' => 'Add a link for the "Link Post Format". The title of the post will link to the URL you`ve set.', 'std'=> ''));	
	$link_post->addRadio($prefix.'link_radio',array('blank'=>'_blank: New window or tab','self'=>'_self: Same window or tab'), array('name'=> 'Target of the link', 'desc' => 'Set the target of the link.', 'std'=> array('blank')));	
	$link_post->addText($prefix.'link_relationship',array('name'=> 'Link Relationship (optional)', 'desc' => 'Set the link "rel" attribute(ex: nofollow, dofollow, etc).', 'std'=> ''));
	
	$link_post->Finish();	  
	
  
  
	// Metaboxes for Quote Post Format
	$config = array(
		'id' => 'dt_quote_post_custom_fields',	
		'title' => 'Quote Post Format Options',	
		'pages' => array('post'),
		'context' => 'normal',	
		'priority' => 'high',	
		'fields' => array(),	
		'local_images' => false,	
		'use_with_theme' => true
	);
	
	$quote_post =  new AT_Meta_Box($config);

	$quote_post->addTextarea($prefix.'quote_block',array('name'=> 'Quote', 'desc' => 'Add your text for the quote.', 'std'=> ''));	
	$quote_post->addText($prefix.'quote_author',array('name'=> 'Quote author', 'desc' => 'The person who said that quote.', 'std'=> ''));
	$quote_post->Finish();		
	
  
  
	// Metaboxes for Audio Post Format
	$config = array(
		'id' => 'dt_audio_post_custom_fields',	
		'title' => 'Audio Post Format Options',	
		'pages' => array('post'),
		'context' => 'normal',	
		'priority' => 'high',	
		'fields' => array(),	
		'local_images' => false,	
		'use_with_theme' => true
	);
	
	$audio_post =  new AT_Meta_Box($config);

	$audio_post->addText($prefix.'mp3_audio_block',array('name'=> 'MP3 File URL', 'desc' => '', 'std'=> ''));	
	$audio_post->addText($prefix.'ogg_audio_block',array('name'=> 'OGA/OGG File URL', 'desc' => '', 'std'=> ''));	
	$audio_post->addInfo($prefix.'info_audio_block',array('name'=> '', 'desc' => 'Use the "Featured Image" function to upload a poster image(working like a thumbnail)<br/> for this audio post format.', 'std'=> ''));	

	$audio_post->Finish();	  
	
  
  
	// Metaboxes for Video Post Format
	$config = array(
		'id' => 'dt_video_post_custom_fields',	
		'title' => 'Video Post Format Options',	
		'pages' => array('post'),
		'context' => 'normal',	
		'priority' => 'high',	
		'fields' => array(),	
		'local_images' => false,	
		'use_with_theme' => true
	);
	
	$video_post =  new AT_Meta_Box($config);

	$video_post->addText($prefix.'external_video_block',array('name'=> 'External URL(embed YouTube or Vimeo videos )', 'desc' => 'Use an YouTube or Vimeo page URL(ex: http://www.youtube.com/watch?v=x6qe_kVaBpg). The embed code will be automatically created.', 'std'=> ''));	

	
	$video_post->Finish();



/*-----------------------------------------------------------------------------------*/
/*	Custom Post Types Boxes
/*-----------------------------------------------------------------------------------*/
	

	// Portfolio Title Metabox
	$config = array(
		'id' => 'portfolio_title',						
		'title' => 'Header Options',				
		'pages' => array('portfolio'),					
		'context' => 'normal',							
		'priority' => 'low',							
		'fields' => array(),							
		'local_images' => false,						
		'use_with_theme' => true						
	);

	$port_header =  new AT_Meta_Box($config);

	$port_header->addText($prefix.'page_tagline',array('name'=> 'Title Tagline', 'desc' => 'You can set a tagline for the title.' ));	
	$port_header->addSelect($prefix.'portf_header',array('center-title'=>'Center Aligned Title','left-title'=>'Left Aligned Title', 'no-title'=>'No Title', 'parallax-title'=>'Center Aligned Title on Background Image'),array('name'=> 'Project Title Options', 'std'=> array('center-title')));
	$port_header->Finish();		

	
	$config = array(
		'id' => 'dt_parallax_bg',	
		'title' => 'Background Options',	
		'pages' => array('portfolio'),
		'context' => 'normal',	
		'priority' => 'low',	
		'fields' => array(),	
		'local_images' => false,	
		'use_with_theme' => true
	);	
	
	$bg_options =  new AT_Meta_Box($config);
	$bg_options->addInfo($prefix.'info_parallax_bg',array('name'=> '', 'desc' => 'Upload an image. You mainly have 3 options: upload an image and set it as background; upload an image and make it act like a pattern by choosing options like repeat or pick a color.', 'std'=> ''));		
	$bg_options->addImageSolo($prefix.'bg_img',array('name'=> 'Background Image '));
	
	$bg_options->addRadio($prefix.'bg_repeat',array('repeat'=>'Repeat','repeat-y'=>'Repeat-Y', 'repeat-x' => 'Repeat-X', 'no-repeat' => 'No Repeat'),array('name'=> 'Background Repeat', 'std'=> 'repeat-y'));	

	$bg_options->addColor($prefix.'bg_color',array('name'=> 'Background Color', 'std' => '#111111', 'desc' => 'You can set a color over the background image. You can make it more or less opaque, by using the next setting.'));	
	$bg_options->addText($prefix.'bg_color_opacity',array('name'=> 'Background Color Opacity', 'std' => '70', 'desc' => 'Set an opacity value for the color(values between 0-100). 0 means no color while 100 means solid color.'));	
	$bg_options->addRadio($prefix.'bg_text',array('light-text'=>'Light Text','dark-text'=>'Dark Text'),array('name'=> 'Text Color Scheme', 'std'=> 'light-text', 'desc' => 'Pick a color scheme for the parallax text. "Light Text" looks good on dark bg images while "Dark Text" looks good on light images.'));
	$bg_options->Finish();	


	// Portfolio Icon Metabox
	$config = array(
		'id' => 'portfolio_icon',						
		'title' => 'Thumbnail(Featured Image) options:',				
		'pages' => array('portfolio'),					
		'context' => 'side',							
		'priority' => 'low',							
		'fields' => array(),							
		'local_images' => false,						
		'use_with_theme' => true						
	);

	$port_icon =  new AT_Meta_Box($config);

	$port_icon->addSelect($prefix.'portf_icon',array('link_to_page'=>'Opens the Portfolio Item','lightbox_to_image'=>'Is Opening in a Lightbox', 'link_to_link'=>'Opens a Custom Link', 'lightbox_to_video' => 'Opens a Video in a Lightbox', 'lightbox_to_gallery' => 'Opens an Image Gallery in a Lightbox'),array('name'=> 'What thumbnail does: ', 'std'=> array('link_to_page')));
	$port_icon->addText($prefix.'portf_link',array('name'=> 'Custom Link: ', 'desc' => 'You can set the thumbnail to open a custom link.'));
	$port_icon->addText($prefix.'portf_video',array('name'=> 'Video URL: ', 'desc' => 'You can set the thumbnail to open a video from third-party websites(Vimeo, YouTube) in an URL. Ex: http://www.youtube.com/watch?v=y6Sxv-sUYtM'));

	$gl_fields[] = $port_icon->addImage($prefix.'gl_url',array('desc' => '', 'name'=> 'Photo URL ', 'class'=>'image-field'),true);

	
	$port_icon->addRepeaterBlock($prefix.'portf_gallery',array('desc' => 'Upload images for the gallery. They will appear in lightbox, when the thumbnail will be clicked.','inline' => true, 'name' => 'Gallery Images','fields' => $gl_fields, 'sortable' => true));


	$port_icon->addImageRadio($prefix.'portf_thumbnail',array('portfolio-small'=>'Small Thumbnail', 'portfolio-big'=>'Big Thumbnail', 'half-horizontal'=>'Half Horizontal', 'half-vertical' => 'Half Vertical'),array('name'=> 'Thumbnail Size', 'std'=> array('portfolio-small'), 'desc' => 'Working with the Portfolio Grid layout option'));
	
	$port_icon->Finish();	
	
	
	// Testimonials Metaboxes
	$config = array(
		'id' => 'testimonials_box',	
		'title' => 'Testimonial Details',	
		'pages' => array('testimonials'),
		'context' => 'normal',	
		'priority' => 'high',	
		'fields' => array(),	
		'local_images' => false,	
		'use_with_theme' => true
	);
	
	$test_box =  new AT_Meta_Box($config);

	$test_box->addTextarea($prefix.'testimonial_desc',array('name'=> 'Testimonial Text', 'desc' => 'Write a testimonial into the textarea.'));
	$test_box->addText($prefix.'testimonial_name',array('name'=> 'By who? ', 'desc' => 'Name of the client who gave feedback'));
	$test_box->addText($prefix.'testimonial_details',array('name'=> 'More details about the client: ', 'desc' => 'You can add here the company he/she works in, position in the company, etc.'));

	$test_box->Finish();	
	

	// Page Sidebars Metabox
	$config = array(
		'id' => 'page_sidebars',						
		'title' => 'Page Layout',				
		'pages' => array('page'),					
		'context' => 'side',							
		'priority' => 'high',							
		'fields' => array(),							
		'local_images' => false,						
		'use_with_theme' => true						
	);

	$page_sidebar =  new AT_Meta_Box($config);
	$all_sidebars = array();
	if (class_exists('SidebarGenerator')) {
		$all_sidebars = SidebarGenerator::get_all_sidebars();
	}
	else $all_sidebars = delicious_my_sidebars();
	
	$page_sidebar->addImageRadio($prefix.'sidebar_position',array('sidebar-right'=>'Right Sidebar','sidebar-left'=>'Left Sidebar', 'no-sidebar'=>'No Sidebar'),array('name'=> 'Sidebar position', 'std'=> array('sidebar-right')));
	$page_sidebar->addSelect($prefix.'all_sidebars',$all_sidebars,array('name'=> 'Pick a sidebar '));

	$page_sidebar->Finish();	  
	  
	
	//Team Details Meta Boxes
	$config = array(
		'id' => 'team_details',		
		'title' => 'Team Member Details',		
		'pages' => array('team'),	
		'context' => 'normal',					
		'priority' => 'high',					
		'fields' => array(),					
		'local_images' => false,				
		'use_with_theme' => true				
	);
	
	$team_meta =  new AT_Meta_Box($config);
	$team_meta->addTextarea($prefix.'member_text',array('name'=> 'About the Team Member', 'desc' => 'Some words about the member'));
	$team_meta->addText($prefix.'member_position',array('name'=> 'Company Position ', 'desc' => 'Ex: Web Developer or Sales Manager'));
	$team_meta->addText($prefix.'member_mail',array('name'=> 'Email Address ', 'desc' => 'Ex: email@mywebsite.com'));
	$team_meta->addText($prefix.'member_twitter',array('name'=> 'Twitter URL ', 'desc' => 'Ex: https://twitter.com/#!/deliciousthemes'));
	$team_meta->addText($prefix.'member_facebook',array('name'=> 'Facebook URL', 'desc' => 'Ex: http://www.facebook.com/madalin.tudose'));
	$team_meta->addText($prefix.'member_linkedin',array('name'=> 'LinkedIn URL', 'desc' => 'Ex: http://www.linkedin.com/profile/view?id=163099926'));
	$team_meta->addText($prefix.'member_google',array('name'=> 'Google+ URL', 'desc' => 'Ex: https://plus.google.com/+nettuts/'));
	$team_meta->addText($prefix.'member_pinterest',array('name'=> 'Pinterest URL', 'desc' => 'Ex: http://www.pinterest.com/'));
	$team_meta->addText($prefix.'member_instagram',array('name'=> 'Instagram URL', 'desc' => 'Ex: http://www.instagram.com/'));
	$team_meta->addText($prefix.'member_custom',array('name'=> 'Custom URL', 'desc' => 'Ex: You can add an URL to a custom link'));
	
	$team_meta->Finish();	

	// Member Icon Metabox
	$config = array(
		'id' => 'team_thumbnail',						
		'title' => 'Thumbnail(Featured Image) options:',				
		'pages' => array('team'),					
		'context' => 'side',							
		'priority' => 'low',							
		'fields' => array(),							
		'local_images' => false,						
		'use_with_theme' => true						
	);

	$team_thumb =  new AT_Meta_Box($config);

	$team_thumb->addSelect($prefix.'team_thumb_icon',array('team_to_image'=>'Is Opening in a Lightbox', 'team_to_link'=>'Opens a Custom Link', 'flat_image'=>'Does Nothing'),array('name'=> 'What thumbnail does: ', 'std'=> array('team_to_image')));
	$team_thumb->addText($prefix.'team_link',array('name'=> 'Custom Link: ', 'desc' => 'You can set the thumbnail to open a custom link.'));
	$team_thumb->Finish();	


	}
}