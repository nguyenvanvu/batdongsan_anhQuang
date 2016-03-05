<?php
/**
 * The template for displaying posts in the Audio post format.
 *
 * @package WordPress
 * @subpackage Delicious
 *
 */
 
	$time = get_the_time(get_option('date_format'));
	?>

<article id="post-<?php the_ID(); ?>" <?php post_class('post post-masonry'); ?>>

	<?php
		$thumb_id = get_post_thumbnail_id($post->ID);
		$image_url = wp_get_attachment_url($thumb_id);		
 		
 		if ( has_post_thumbnail() ) { 
 			if(is_single()) {
 				?>
				<div class="post-thumbnail">
					<a href="<?php echo $image_url; ?>" rel="prettyPhoto" title="<?php the_title(); ?>">
						<span class="item-on-hover"><span class="hover-link"><i class="fa fa-search"></i></span></span>
						
						<?php if(isset($smof_data['lazyload']) && ($smof_data['lazyload'] =='1')) { ?>
							<img class="lazy" data-original="<?php echo $image_url; ?>" width="<?php echo $image_vals[1];?>"  height="<?php echo $image_vals[2];?>" alt="<?php echo $alt; ?>" />

						<?php } else {  the_post_thumbnail('blog-thumb', array('alt'   => $alt));  } ?>
					</a>
				</div><!--end post-thumbnail-->		
			<?php 
			}
			else 
			{ ?>
				<div class="post-thumbnail">
					<a href="<?php the_permalink(); ?>">
						<span class="item-on-hover"><span class="hover-link"><i class="fa fa-external-link"></i></span></span>
						<?php the_post_thumbnail('blog-thumb'); ?>
					</a>
				</div><!--end post-thumbnail-->		
				<?php 
			}
		}  ?>


	<div class="audio-item">
		<?php delicious_audio($post->ID); ?>
	</div>		
			
	<div class="post-content">

		<h1 class="masonry-title">
			<?php if(!is_single()) { ?>
			<a href="<?php the_permalink(); ?>" rel="bookmark" title="Permanent Link to <?php the_title_attribute(); ?>"><?php the_title(); ?></a>
			<?php } else { the_title(); } ?>
		</h1>
		<span class="post-meta">
		<i class="for-sticky fa fa-exclamation"></i><i class="fa fa-music"></i>
		<?php 
			echo '<em>' . $time. '</em>';
			
			if(is_single()) {
				echo '<div class="single-extra">';
				echo '<em>' . get_the_category_list( __( ', ', 'delicious' ) ) . '</em>';
				comments_popup_link(__('No Comments', 'delicious'), __('1 Comment', 'delicious'), __('% Comments', 'delicious')); 
				echo '</div>';
			}
		?>
		</span>			
		<div class="clear"></div>

		<?php if(is_single()) { ?> <div class="half-space"></div> <?php } ?>
			<?php  
			global $more; 
			if(!is_single()) { $more = 0; }
			the_content(__('Read More', 'delicious')); ?> 
			
	</div><!--end post-content-->
	
</article><!-- #post -->