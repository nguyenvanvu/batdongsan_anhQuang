<?php get_header(); ?>

	<?php get_template_part( 'includes/page-title' ); ?>

	<?php
	//if there are results to show
	if (have_posts()) : ?>
		<div class="centered-wrapper">
			<section class="percent-blog begin-content <?php if(isset($smof_data['blog_sidebar_pos'])) { if($smof_data['blog_sidebar_pos'] !='') { echo $smof_data['blog_sidebar_pos']; } } else echo 'sidebar-right'; ?>">
				<?php  
					if ( have_posts()) { 
						while (have_posts()) : the_post();
					?>
			
					<?php get_template_part( 'format', get_post_format() );  ?>

					<?php  endwhile;
					
									
					dt_navigation();
					// if there are results, but not from the blog posts
					} else { ?>
						<article>
							<p><?php _e('Sorry, but the requested resource was not found on this site. Try another search:', 'delicious'); ?></p>
							<?php get_search_form(); ?>
						</article>
				
				<?php } ?>
			</section>

			<?php 
				echo '<aside class="percent-sidebar">';
					if(isset($smof_data['blog_sidebar']) && ($smof_data['blog_sidebar'] !='')) { 
						$blog_sidebar_pos = $smof_data['blog_sidebar']; 
						dynamic_sidebar($blog_sidebar_pos); 
					}
				echo '</aside>';
			?>
		</div>
			

			
	<?php
	// if there are no search results
	 else : ?>
		
		<div class="centered-wrapper">
			<section class="percent-blog begin-content <?php if(isset($smof_data['blog_sidebar_pos'])) { if($smof_data['blog_sidebar_pos'] !='') { echo $smof_data['blog_sidebar_pos']; } } else echo 'sidebar-right'; ?>">
				<article>
					<p><?php _e('Sorry, but the requested resource was not found on this site. Try another search.', 'delicious'); ?></p>
				</article>
			</section>
			
			<?php get_sidebar(); ?>
		</div>

	<?php endif; ?>

<?php get_footer(); ?>