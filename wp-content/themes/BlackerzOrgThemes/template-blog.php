<?php
/*

Template Name: Blog Page

 */
?>

<?php get_header(); ?>

	<?php get_template_part( 'includes/page-title' ); ?>
	
	<?php
		$dt_template_blog = get_post_meta($post->ID, 'dt_blog_layout', true);
		$dt_blog_categories = get_post_meta($post->ID, 'dt_blog_categories', true);
		$dt_posts_number = get_post_meta($post->ID, 'dt_posts_number', true);
		$blog_type = '';
		$blog_class = '';
		$percent_class = '';
		
		if(($dt_template_blog == 'sidebar-right') || ($dt_template_blog == 'sidebar-left')) {
			$blog_type = 'posts'; 
			$percent_class = 'percent-blog';
		}

		else if (($dt_template_blog == 'masonry-2-cols-sidebar-left') || ($dt_template_blog == 'masonry-2-cols-sidebar-right')) {
			$blog_type = 'blog-masonry';
			$percent_class = 'percent-blog';
			$blog_class = 'on-two-columns';
		}
		else {
			$blog_type = 'blog-masonry';
		}
		
		if(($dt_template_blog == 'sidebar-right') || ($dt_template_blog == 'masonry-2-cols-sidebar-right')) {
			$sidebar_class = 'sidebar-right';
		}
		
		if(($dt_template_blog == 'sidebar-left') || ($dt_template_blog == 'masonry-2-cols-sidebar-left')) {
			$sidebar_class = 'sidebar-left';
		}
		
		if($dt_template_blog == 'masonry-3-cols') {
			$blog_class = 'on-three-columns';
		}
		if($dt_template_blog == 'masonry-2-cols') {
			$blog_class = 'on-two-columns';
		}
	?>
	
	<div class="centered-wrapper">

		<?php
		
			//get blog categories to filter posts from
			$blog_cats = '';
			if(!empty($dt_blog_categories)) {
				$blog_cats = implode(', ', $dt_blog_categories);		
			}

			else {
				$blog_array_cats = get_terms('category', array('hide_empty' => false));
				foreach($blog_array_cats as $blog__array_cat) {
					$blog_cats .= $blog__array_cat->slug .', ';
				}
			}
			
			//items to display on page
			if($dt_posts_number != '') {
				$display_number = $dt_posts_number;
			}
			else {
				$display_number = 10;
			}
			
			//pagination
			if ( get_query_var('paged') ) {
				$paged = get_query_var('paged');

			} elseif ( get_query_var('page') ) {
				$paged = get_query_var('page');

			} else {
				$paged = 1;
			}			
			//query posts
			query_posts(
				array(
				'post_type'=> 'post',
				'posts_per_page' => $display_number,
				'term' => 'category',
				'category' => $blog_cats,
				'post__in' => get_option('sticky_posts'),
				'paged'=>$paged
			));	
		?>
		<div class="blog-wrapper <?php if(!empty( $percent_class )) { echo $percent_class; } ?> <?php if ( !empty( $sidebar_class )) { echo $sidebar_class; }?>">
			<div class="blog-page <?php if(!empty( $blog_type )) { echo $blog_type; } ?> <?php if(!empty( $blog_class )) { echo $blog_class; } ?>">
			
				
					<?php 
					if (have_posts()) :  while (have_posts()) : the_post(); 

						get_template_part( 'format', get_post_format() );
							
						endwhile;
					endif;  
					?>						
			</div>	
			<?php 
				if(($dt_template_blog == 'sidebar-right') || ($dt_template_blog == 'sidebar-left') || ($dt_template_blog == 'masonry-2-cols-sidebar-left') || ($dt_template_blog == 'masonry-2-cols-sidebar-right')) { 
					dt_navigation(); 
				}
			?>
		</div>			
			
			<?php 
			if(($dt_template_blog == 'masonry-3-cols') || ($dt_template_blog == 'masonry-2-cols') || ($dt_template_blog == 'no-blog-sidebar')) { 
				dt_navigation(); 
			}
			?>					
			
			<?php			
		wp_reset_query(); 
		?>

	<?php 

	if(($dt_template_blog == 'sidebar-right') || ($dt_template_blog == 'sidebar-left') || ($dt_template_blog == 'masonry-2-cols-sidebar-left') || ($dt_template_blog == 'masonry-2-cols-sidebar-right')) :
		get_sidebar(); 
	endif;
	?>

	</div><!--end centered-wrapper-->
	<div class="clear"></div>
	<div class="space"></div>


	<?php if (have_posts()) : while (have_posts()) : the_post(); ?>

		<?php the_content(); ?>		

	<?php endwhile; ?>

	<?php endif; ?>	

<?php get_footer(); ?>