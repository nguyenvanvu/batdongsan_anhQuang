<?php global $smof_data; //get theme options ?>
<!DOCTYPE html>
<html <?php language_attributes(); ?>>
	<head>

		<meta http-equiv="Content-Type" content="<?php bloginfo('html_type'); ?>; charset=<?php bloginfo('charset'); ?>">
		
		<!-- mobile meta tag -->
		<?php if(isset($smof_data['responsive_enabled']) && ($smof_data['responsive_enabled'] =='1')) {  ?>		
			<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
		<?php } else {  ?> 
			<meta name="viewport" content="width=1150">
			<?php } ?>

		<title><?php bloginfo('name'); ?> <?php wp_title(); ?></title>
		
		<!-- Custom Favicon -->
		<?php if(!empty($smof_data['custom_favicon']['url'])) { ?><link rel="icon" type="image/png" href="<?php echo esc_url($smof_data['custom_favicon']['url']); ?>" /><?php } ?>			
				
		<link rel="alternate" type="text/xml" title="<?php bloginfo('name'); ?> RSS 0.92 Feed" href="<?php bloginfo('rss_url'); ?>">
		<link rel="alternate" type="application/atom+xml" title="<?php bloginfo('name'); ?> Atom Feed" href="<?php bloginfo('atom_url'); ?>">
		<link rel="alternate" type="application/rss+xml" title="<?php bloginfo('name'); ?> RSS 2.0 Feed" href="<?php bloginfo('rss2_url'); ?>">
		<link rel="pingback" href="<?php bloginfo('pingback_url'); ?>">

		<?php wp_head(); ?>			

	</head>
	
<body <?php body_class(); ?>>

	<!-- preloader-->
<?php 
	if(isset($smof_data['enable_preloader'])) {
		if($smof_data['enable_preloader'] != 0) { ?>
	<div id="qLoverlay"></div>

	<?php }} ?>

	<header id="header" class="<?php if(isset($smof_data['header_style'])) { echo $smof_data['header_style']; } else { echo 'solid-header'; } ?>">
		<div class="centered-wrapper">
			<div class="percent-one-fourth">
				<?php if(isset($smof_data['custom_logo']['url']) && ($smof_data['custom_logo']['url'] !='')) { ?>
					<div class="logo"><a href="<?php echo home_url(); ?>" title="<?php bloginfo( 'name' ); ?>" rel="home"><img src="<?php echo $smof_data['custom_logo']['url']; ?>" alt="<?php bloginfo( 'name' ) ?>" /></a></div>
				<?php } 
				
				else { ?>			
			
					<div class="logo"><a href="<?php echo home_url(); ?>"><img src="<?php echo get_template_directory_uri(); ?>/images/logo.png" alt="<?php bloginfo( 'name' ) ?>" /></a></div>
				<?php } ?>				
				
			</div><!--end one-fourth-->
			
			<?php if(isset($smof_data['responsive_enabled']) && ($smof_data['responsive_enabled'] =='1')) {  ?>	
				<a class="nav-btn <?php if(isset($smof_data['header_scheme']) && ($smof_data['header_scheme'] == 'dark-header')) { echo 'dark-things'; } ?>"><i class="fa fa-bars"></i></a>
			<?php } ?>

			<div class="percent-three-fourth column-last">			

			<?php if(isset($smof_data['header_social']) && ($smof_data['header_social'] != 0)) { ?>
				<ul id="header-social">
					<?php
						$social_links = array('rss','facebook','twitter','flickr','google-plus', 'dribbble' , 'linkedin', 'pinterest', 'youtube', 'github-alt', 'vimeo-square', 'instagram', 'tumblr', 'behance', 'vk', 'xing', 'soundcloud', 'codepen', 'yelp');
						if($social_links) {
							foreach($social_links as $social_link) {
								if(!empty($smof_data[$social_link])) { echo '<li><a href="'. esc_url($smof_data[$social_link]) .'" title="'. $social_link .'" class="'.$social_link.'"  target="_blank"><i class="fa fa-'.$social_link.'"></i></a></li>';
								}								
							}
							if(!empty($smof_data['skype'])) { echo '<li><a href="skype:'. $smof_data['skype'] .'?call" title="'. $smof_data['skype'] .'" class="'.$smof_data['skype'].'"  target="_blank"><i class="fa fa-skype"></i></a></li>';
							}							
						}
					?>					
				</ul>
				<?php } ?>	

			<?php if($smof_data['search_header'] === '1') { ?>
				<div class="searchform-switch">
					<i class="fa fa-search"></i>
					<i class="fa fa-times-circle"></i>
				</div>
				
				<form class="header-search-form display-none" method="get" action="<?php echo home_url(); ?>/">
					<input class="header-search-input" type="text" placeholder="<?php echo __("Search...", "delicious"); ?>" id="s" name="s" value="<?php the_search_query(); ?>">
					<button type="submit">
						<i class="fa fa-search"></i>
					</button>
				</form>		
			<?php } ?>								

				<?php if (function_exists('delicious_language_selector')) { ?>
					<div class="flags_language_selector <?php if(isset($smof_data['header_scheme']) && ($smof_data['header_scheme'] == 'dark-header')) { echo 'dark-things'; } ?>"><?php delicious_language_selector(); ?></div>
				<?php } ?>				

				<nav id="navigation" class="<?php if(isset($smof_data['header_scheme'])) { echo $smof_data['header_scheme']; } else { echo 'light-header'; } ?>">
					<?php wp_nav_menu( array(
						'theme_location' => 'top_menu',
						'menu_id' => 'mainnav',
						'menu_class' => 'sf-menu',
						'sort_column' => 'menu_order',
						'fallback_cb' => ''
					)); ?>
				</nav><!--end navigation-->				
			
				
			</div><!--end three-fourth-->
			<div class="clear"></div>
		</div><!--end centered-wrapper-->
	</header>		
	
	<div id="wrapper">	
		
	<?php

	if(is_front_page()) { echo '<div id="hello"></div>';  }

	if(isset($smof_data['header_style'])) {
		if(($smof_data['header_style'] == 'solid-header') && (is_page_template('template-homepage.php'))) { 
			echo '<div class="menu-fixer"></div>';
		} 
	}
	else if(!isset($smof_data['header_style'])) {
		echo '<div class="menu-fixer"></div>';
	}
	if(!is_page_template('template-homepage.php'))   {
		if(isset($smof_data['header_style'])) {
			echo '<div class="menu-fixer"></div>';
		}
	}

	?>