<?php get_header(); ?>

	<?php get_template_part( 'includes/page-title' ); ?>
		
	<div class="centered-wrapper">
		<section class="percent-blog begin-content <?php if(isset($smof_data['blog_sidebar_pos'])) { if($smof_data['blog_sidebar_pos'] !='') { echo $smof_data['blog_sidebar_pos']; } } else echo 'sidebar-right'; ?>">

		<?php if (have_posts()) : while (have_posts()) : the_post(); ?>
			<div class="blog-page">

						<?php get_template_part( 'format', get_post_format() ); ?>
									
					<?php endwhile; ?>
					
			<?php endif; ?>
					
			<?php if(function_exists('dt_navigation')) {
				dt_navigation(); } 
				else  { ?>
				<?php previous_posts_link(); ?> &bull; <?php next_posts_link(); } ?>
			</div>
		</section>


		<?php 
			echo '<aside class="percent-sidebar">';
				if(isset($smof_data['blog_sidebar'])) {
					if($smof_data['blog_sidebar'] !='') { 
						$blog_sidebar_pos = $smof_data['blog_sidebar']; 
						dynamic_sidebar($blog_sidebar_pos); 
					}
				}
			echo '</aside>';
			
		?>
		
	</div>
<?php get_footer(); ?>