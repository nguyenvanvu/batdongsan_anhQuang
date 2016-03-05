<?php
/**
 * The template for displaying posts in the Link post format.
 *
 * @package WordPress
 * @subpackage Delicious
 *
 */
	global $content_class;	
	
	$time = get_the_time(get_option('date_format'));
	$link_post_data = get_post_meta($post->ID,'dt_link_block',true);
	$link_post_target = get_post_meta($post->ID,'dt_link_radio',true);
	$link_post_relationship = get_post_meta($post->ID,'dt_link_relationship',true);
?>

<article id="post-<?php the_ID(); ?>" <?php post_class('post post-masonry'); ?>>

	<div class="post-content format-link">
		
		<h1 class="masonry-title"><a href="<?php echo esc_url($link_post_data); ?>"  rel="<?php echo esc_attr($link_post_relationship); ?>"  title="<?php the_title_attribute(); ?>" target="_<?php echo $link_post_target; ?>" ><?php the_title(); ?></a></h1>
	
		<span class="post-meta">
			<i class="for-sticky fa fa-exclamation"></i><i class="fa fa-link"></i>
			<?php echo '<em>' . $time. '</em>'; ?>
		</span>					
		<div class="clear"></div>
	
	</div><!--end post-content-->
	
</article><!-- #post -->