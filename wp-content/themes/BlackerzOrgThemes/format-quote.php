<?php
/**
 * The template for displaying posts in the Quote post format.
 *
 * @package WordPress
 * @subpackage Delicious
 *
 */
	global $content_class;	
	
	$time = get_the_time(get_option('date_format'));
	$quote_post_data = get_post_meta($post->ID,'dt_quote_block',true);
	$quote_post_author = get_post_meta($post->ID,'dt_quote_author',true);
?>

<article id="post-<?php the_ID(); ?>" <?php post_class('post post-masonry quote-post'); ?>>

	<div class="post-content">
		<h3><?php echo wp_kses_post($quote_post_data); ?></h3>
		<span class="post-meta">
			<i class="for-sticky fa fa-exclamation"></i><i class="fa fa-quote-right"></i>
			<?php echo '<em>' . $time. '</em>'; ?>
		</span>	
		<span class="quote-author"><?php echo esc_html($quote_post_author); ?></span>

	</div><!--end post-content-->
</article><!-- #post -->