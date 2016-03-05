<?php
	$dt_tagline = get_post_meta($post->ID, 'dt_page_tagline', true);
	$dt_title = get_post_meta($post->ID, 'dt_page_title', true);
	$dt_header = get_post_meta($post->ID, 'dt_portf_header', true);

?>			
	<div class="centered-wrapper">
	<?php if(($dt_title != "on") && ('portfolio' != get_post_type())) { ?>
		<div class="page-title-subtitle">
			<?php
			
			if(is_home()) { ?>
				<h2><?php _e("Blog", "delicious"); ?></h2>
			<?php }
			else if (is_archive()) { ?>
				<?php if (have_posts()) : ?>

					<?php $post = $posts[0]; // hack: set $post so that the_date() works ?>
					<?php if (is_category()) { ?>
					<h2><?php _e('Category: ', 'delicious'); ?><strong><?php single_cat_title(); ?></strong></h2>

					<?php } elseif(is_tag()) { ?>
					<h2><?php _e('Tag: ', 'delicious'); ?><?php single_tag_title(); ?></h2>

					<?php } elseif (is_day()) { ?>
					<h2><?php _e('Archive: ', 'delicious'); ?><?php the_time(get_option('date_format')); ?></h2>

					<?php } elseif (is_month()) { ?>
					<h2><?php _e('Archive: ', 'delicious'); ?><?php the_time(get_option('date_format')); ?></h2>

					<?php } elseif (is_year()) { ?>
					<h2><?php _e('Archive: ', 'delicious'); ?><?php the_time(get_option('date_format')); ?></h2>

					<?php } elseif (is_author()) { ?>
					<h2><?php _e('Author Archive: ', 'delicious'); ?></h2>

					<?php } elseif (isset($_GET['paged']) && !empty($_GET['paged'])) { ?>
					<h2><?php _e('Blog Archives: ', 'delicious'); ?></h2>
					<?php }
					
				endif; 					
			}
			
			else if (is_search()) { ?>
				<div class="percent-three-fourth">
					<h2><?php _e('Search Results for: ', 'delicious'); ?>"<?php the_search_query(); ?>"</h2>
				</div>
				<div class="percent-one-fourth column-last">
					<?php get_search_form(); ?>
				</div>
					<?php
			}
			
			else if (is_page()) {
				 echo '<h2>'. get_the_title() . '</h2>'; 
				if(!empty($dt_tagline)) {
				 	echo '<h3>'. $dt_tagline . '</h3>';
				}
			}
			else if (is_single()) {
				$pages = get_pages(array(
					'meta_key' => '_wp_page_template',
					'meta_value' => 'template-blog.php'
				));
				$return = '';
				foreach($pages as $page){
					$return = '<h2>'.$page->post_title.'</h2>';
					$return .= '<h3>'.get_post_meta($page->post_id, 'dt_page_tagline', true).'</h3>';
				}	
				echo $return;
				
			}
			else if (is_404()) {
				echo '<h2>OOOOOOPS</h2>';
			}

			?>		
		</div>
		<?php } ?>
	</div>	

			
	<?php

	$title_class = '';
	if($dt_header == 'left-title') {
		$title_class = 'float-left';
	}

	$text_class = 'darker-overlay';
	$dt_bg_text = get_post_meta($post->ID, 'dt_bg_text', true);			
	if($dt_bg_text == 'dark-text') {
		$text_class = 'lighter-overlay';
	}

	 if ('portfolio' == get_post_type()) {
	 	if($dt_header != 'no-title') {
		 	if($dt_header != 'parallax-title') {
		 		echo '<div class="centered-wrapper">';
			 		echo '<div class="page-title-subtitle">';
						echo '<h1 class="portfolio-title '.$title_class.'">' .get_the_title() .'</h1>';	

						if(!empty($dt_tagline)) {
						 	echo '<h2 class="section-tagline '.$title_class.'">'. $dt_tagline . '</h2>';
						}
					echo '</div>';
				echo '</div>';
			}

			else if($dt_header == 'parallax-title') {
		 		echo '<div class="parallax-section" id="parallax-'.$post->ID.'">';
			 		echo '<div class="parallax-padding '.$text_class.'">';
				 		echo '<div class="centered-wrapper">';
							echo '<h1 class="portfolio-title '.$title_class.'">' .get_the_title() .'</h1>';	

							if(!empty($dt_tagline)) {
							 	echo '<h2 class="section-tagline '.$title_class.'">'. $dt_tagline . '</h2>';
							}
						echo '</div>';
					echo '</div>';				
				echo '</div>';				
			}
		}


	} ?>		