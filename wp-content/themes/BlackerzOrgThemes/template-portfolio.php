<?php
/*

Template Name: Portfolio

 */
global $smof_data;

	get_header(); 
	get_template_part( 'includes/page-title' ); 

	$categs = get_post_meta($post->ID,'dt_cats_field');
	$layout = get_post_meta($post->ID,'dt_portfolio_columns',true);
	$navig = get_post_meta($post->ID,'dt_portfolio_navigation',true);
	$nav_number = get_post_meta($post->ID,'dt_nav_number',true);	

	$i=0;
	$j=1;
	$count =0;
	$term_list ='';		
	$list = '';
	
	if(empty($categs)) {
		$termeni = get_terms('portfolio_cats');
		foreach ($termeni as $te) {
			$option = $te->name;
			$categs[$j] = $option;
			$j++;	
			
		}
	}

	// Create filter elements
	foreach ($categs as $categ) {
		$i++;

		$to_replace = array(' ', '/', '&');
		$intermediate_replace = strtolower(str_replace($to_replace, '-', $categ));
		$str = preg_replace('/--+/', '-', $intermediate_replace);
		
		$cat_id = get_taxonomy_cat_ID($categ);
		if (function_exists('icl_t')) { 
			$term_list .= '<li><a href="#filter" data-option-value=".'. $cat_id .'">' . esc_html(icl_t('Portfolio Category', 'Term '.get_taxonomy_cat_ID( $categ ).'', $categ)) . '</a></li>';
		}
		else {
			$term_list .= '<li><a href="#filter" data-option-value=".'. $cat_id .'">' . esc_html($categ) . '</a></li>';
		}
		$list .= $categ . ', ';


	}
	// List of Portfolio Categories
	$portfolio_categs = get_terms('portfolio_cats', array('hide_empty' => false));
	
	foreach ($categs as $categ) {
		foreach($portfolio_categs as $portfolio_categ) {
			if($categ === $portfolio_categ->name) {
				$list .= $portfolio_categ->slug . ', ';
			}
		}
		
	}

	?>

	<div class="centered-wrapper">
	<section class="patti-grid" id="gridwrapper_portfolio">		
		<?php 

		// Page Content
		if (have_posts()) : while (have_posts()) : the_post(); 	
			the_content(); 
		endwhile; endif;		
	
		// Portfolio Filter
		if (($i > 1) && ($navig == 'filter')) { ?> 
			<section id="options">
				<ul id="filters" class="option-set clearfix" data-option-key="filter">
					<li class="all-projects"><a href="#filter" data-option-value="*" class="selected active"><?php _e('All', 'delicious'); ?></a></li>
					<?php echo $term_list; ?>
				</ul>
			</section>
			<div class="space"></div>
		<?php } ?>	


		<section id="portfolio-wrapper">		
			<ul class="portfolio <?php echo $layout; ?> isotope grid_portfolio">
			
				<?php
					$show_number = '-1';
				if ($navig == 'no-filter') {
					if (!empty($nav_number)) {
						$show_number = $nav_number;
					}
					else $show_number = 8;
				}
				
				//get post type - portfolio
				query_posts(array(
					'post_type'=>'portfolio',
					'posts_per_page' => $show_number,
					'term' => 'portfolio_cats',
					'portfolio_cats' => $list,
					'paged'=>$paged
				));

				// Begin The Loop
				if (have_posts()) : while (have_posts()) : the_post(); 			

				// Get The Taxonomy 'Filter' Categories
				$terms = get_the_terms( get_the_ID(), 'portfolio_cats' ); 

				$portf_icon = get_post_meta($post->ID,'dt_portf_icon',true);						
				$portf_link = get_post_meta($post->ID,'dt_portf_link',true);						
				$portf_video = get_post_meta($post->ID,'dt_portf_video',true);						
				$portf_thumbnail = get_post_meta($post->ID,'dt_portf_thumbnail',true);	
				
				$lgal = get_post_meta($post->ID,'dt_portf_gallery', true);	

				$gal_output = '';
				if(!empty($lgal)) {
					foreach($lgal as $gal_item) {
						$gal_item_url = $gal_item['dt_gl_url']['url'];
						$gal_item_title = get_post($gal_item['dt_gl_url']['id'])->post_excerpt;
						
						$gal_output .= '<a class="hidden_image" href="'.$gal_item_url.'" rel="prettyPhoto[gallery_'.$post->ID.']" title="'.$gal_item_title.'"></a>';

					}
				}

				$thumb_id = get_post_thumbnail_id($post->ID);
				
				$image_url = wp_get_attachment_url($thumb_id);
				
				$grid_thumbnail = $image_url;
				$item_class = 'item-small';
				
				switch ($portf_thumbnail) {
					case 'portfolio-big':
						$grid_thumbnail = aq_resize($image_url, 762, 592, true);
						$item_class = 'item-wide';
						break;
					case 'portfolio-small':
						$grid_thumbnail = aq_resize($image_url, 379, 295, true);
						$item_class = 'item-small';
						break;
					case 'half-horizontal':
						$grid_thumbnail = aq_resize($image_url, 762, 295, true);
						$item_class = 'item-long';
						break;
					case 'half-vertical':
						$grid_thumbnail = aq_resize($image_url, 379, 592, true);
						$item_class = 'item-high';
						break;									
				}				
					
				
				?>
				<li class="grid-item <?php if($terms) { foreach ($terms as $term) { echo get_taxonomy_cat_ID($term->name) .' '; } } else { echo 'none '; } ?><?php if($layout == 'grid') { echo $item_class; } ?>">
					<?php	
					
					if($layout == 'grid') {
						if ($portf_icon == 'lightbox_to_image') { ?>
							<a href="<?php echo wp_get_attachment_url($thumb_id);?>" rel="prettyPhoto[portfolio_gallery]" title="<?php the_title(); ?>">
						<?php } 
						else if ($portf_icon == 'link_to_page') {  ?>
							<a href="<?php the_permalink(); ?>">
						<?php } 
						else if ($portf_icon == 'link_to_link') {  ?>
							<a href='<?php echo $portf_link; ?>'>
						<?php }	
						else if ($portf_icon == 'lightbox_to_video') {  ?>
							<a rel="prettyPhoto[portfolio_gallery]" href="<?php echo $portf_video; ?>" title="<?php the_title(); ?>">
						<?php }	
						else if ($portf_icon == 'lightbox_to_gallery') {  echo $gal_output; ?> <a href="<?php echo wp_get_attachment_url($thumb_id);?>" rel="prettyPhoto[gallery_<?php echo $post->ID; ?>]" title="<?php the_title(); ?>" >  <?php }																		
						?>

							<div class="grid-item-on-hover">
								<div class="grid-text">
									<h1><?php echo get_the_title(); ?></h1>
								</div>
								<span>
								<?php
								$copy = $terms;
								foreach ( $terms as $term ) {
								if (function_exists('icl_t')) { 
								   echo icl_t('Portfolio Category', 'Term '.get_taxonomy_cat_ID( $term->name ).'', $term->name);
								}
								else 
									echo $term->name;
									if (next($copy )) {
										echo ', ';
									}
								}	
								?>
								</span>
							</div>
							<img src="<?php echo $grid_thumbnail; ?>" alt="" />
						</a>	
						
					<?php
					}
					?>

				</li>

	
				<?php endwhile; endif; // END the Wordpress Loop ?>
			</ul>
			<?php dt_navigation(); ?>
			<?php wp_reset_query(); // Reset the Query Loop ?>			
					
		</section>
	</section>
	</div><!--end centered-wrapper-->

<?php get_footer(); ?>