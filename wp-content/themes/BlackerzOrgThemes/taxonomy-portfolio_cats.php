<?php get_header(); ?>

	<div class="centered-wrapper">
		
		<div class="page-title-subtitle">
			<h2><?php _e('Category: ', 'delicious'); ?><strong><?php single_cat_title(); ?></strong></h2>
			<?php
				$categ_desc = category_description( get_the_category( $id ) ); 

				if($categ_desc != '') { 
				?>
					<h3><?php echo $categ_desc ?> </h3>
				<?php } ?>
		</div>

		<section class="patti-grid" id="gridwrapper_portfolio">	
			<section id="portfolio-wrapper">		
				<ul class="portfolio grid isotope grid_portfolio">
				
					<?php
					// Begin The Loop
					if (have_posts()) : while (have_posts()) : the_post(); 	

					$portf_thumbnail = get_post_meta($post->ID,'dt_portf_thumbnail',true);	
					$item_class = 'item-small';

					$thumb_id = get_post_thumbnail_id($post->ID);
					$image_url = wp_get_attachment_url($thumb_id);	

					switch ($portf_thumbnail) {
						case 'portfolio-big':
							$grid_thumbnail = aq_resize($image_url, 566, 440, true);
							$item_class = 'item-wide';
							break;
						case 'portfolio-small':
							$grid_thumbnail = aq_resize($image_url, 281, 219, true);
							$item_class = 'item-small';
							break;
						case 'half-horizontal':
							$grid_thumbnail = aq_resize($image_url, 566, 219, true);
							$item_class = 'item-long';
							break;
						case 'half-vertical':
							$grid_thumbnail = aq_resize($image_url, 281, 440, true);
							$item_class = 'item-high';
							break;							
					}		

					$terms = get_the_terms( get_the_ID(), 'portfolio_cats' );

					?>
					<li class="grid-item <?php echo $item_class; ?>">
						<a href="<?php the_permalink(); ?>">
							<div class="grid-item-on-hover">
								<div class="grid-text">
									<h1><?php echo get_the_title(); ?></h1>
								</div>
								<span>
								<?php
									$copy = $terms;
									foreach ( $terms as $term ) {
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
					</li>

		
					<?php endwhile; endif; // END the Wordpress Loop ?>
				</ul>
				<?php dt_navigation(); ?>		
						
			</section>
		</section>
	</div><!--end centered-wrapper-->
<?php get_footer(); ?>