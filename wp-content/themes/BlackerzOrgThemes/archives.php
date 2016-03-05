<?php
/*
Template Name: Archives
*/
?>

<?php get_header(); ?>

	<?php get_template_part( 'includes/page-title' ); ?>
	
	<div class="centered-wrapper">
		<?php if (have_posts()) : while (have_posts()) : the_post(); ?>

		<section class="percent-page <?php echo dt_sidebar_position($post->ID); ?>">
			<article id="post-<?php the_ID(); ?>">
				<section>
					<div class="percent-one-half">
						<h3><?php _e('Latest 15 Posts', 'delicious') ?></h3>
						<ul>
						<?php
						$args = array( 'posts_per_page' => 15);

						$myposts = get_posts( $args );
						foreach ( $myposts as $post ) : setup_postdata( $post ); ?>
							<li>
								<a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
							</li>
						<?php endforeach; 
						wp_reset_postdata();?>
						</ul>			
					</div>
					<div class="percent-one-half column-last">
						<div class="percent-one-half">
							<h3><?php _e('Posts by Category', 'delicious'); ?></h3>
							<ul class="archive-list">
								<?php wp_list_categories('title_li='); ?>
							</ul>
						</div>
						
						<div class="percent-one-half column-last">
							<h3><?php _e('Posts by Month', 'delicious'); ?></h3>
							<ul class="archive-list">
								<?php wp_get_archives('type=monthly'); ?>
						</div>
					</div>
				</section>
			</article>
		</section>

	<?php endwhile;?>

	<?php endif; ?>

	<?php
	global $dt_sidebar_pos;
	if(($dt_sidebar_pos == 'sidebar-right') || ($dt_sidebar_pos == 'sidebar-left')) 
		get_sidebar(); 
	?>
	</div><!--end centered-wrapper-->
<?php get_footer(); ?>