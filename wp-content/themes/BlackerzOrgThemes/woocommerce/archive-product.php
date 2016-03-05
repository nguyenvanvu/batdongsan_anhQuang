<?php
/**
 * The Template for displaying product archives, including the main shop page which is a post type archive.
 *
 * Override this template by copying it to yourtheme/woocommerce/archive-product.php
 *
 * @author 		WooThemes
 * @package 	WooCommerce/Templates
 * @version     2.0.0
 */

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

global $smof_data;
	$sidebar_class = '';
	$page_class = '';
	if($smof_data['woo_layout'] == 'sidebar-left') {
		$sidebar_class = 'sidebar-left';
		$page_class = 'percent-blog';
	}
	else if($smof_data['woo_layout'] == 'sidebar-right') {
		$sidebar_class = 'sidebar-right';
		$page_class = 'percent-blog';
	}
	
	if($smof_data['woo_layout'] == 'no-sidebar') {
		$page_class = 'fullwidth-shop';
	}
get_header( 'shop' ); 

?>

<div class="centered-wrapper">
	
	<?php
		/**
		 * woocommerce_before_main_content hook
		 *
		 * @hooked woocommerce_output_content_wrapper - 10 (outputs opening divs for the content)
		 * @hooked woocommerce_breadcrumb - 20
		 */
		
	?>

	<div class="page-title-subtitle">
		<?php do_action( 'woocommerce_before_main_content', 'woocommerce_breadcrumb' );?>

		<?php if ( apply_filters( 'woocommerce_show_page_title', true ) ) : ?>

			<h2><?php woocommerce_page_title(); ?></h2>

		<?php endif; ?>
	</div>

	<?php do_action( 'woocommerce_after_main_content'); ?>
	<div class="<?php echo $page_class;?> <?php echo $sidebar_class; ?>">


		<?php do_action( 'woocommerce_archive_description' ); ?>

		<?php if ( have_posts() ) : ?>

			<?php
				/**
				 * woocommerce_before_shop_loop hook
				 *
				 * @hooked woocommerce_result_count - 20
				 * @hooked woocommerce_catalog_ordering - 30
				 */
				do_action( 'woocommerce_before_shop_loop' );
			?>

			<?php woocommerce_product_loop_start(); ?>

				<?php woocommerce_product_subcategories(); ?>

				<?php while ( have_posts() ) : the_post(); ?>

					<?php wc_get_template_part( 'content', 'product' ); ?>

				<?php endwhile; // end of the loop. ?>

			<?php woocommerce_product_loop_end(); ?>

			<?php
				/**
				 * woocommerce_after_shop_loop hook
				 *
				 * @hooked woocommerce_pagination - 10
				 */
				do_action( 'woocommerce_after_shop_loop' );
			?>

		<?php elseif ( ! woocommerce_product_subcategories( array( 'before' => woocommerce_product_loop_start( false ), 'after' => woocommerce_product_loop_end( false ) ) ) ) : ?>

			<?php wc_get_template( 'loop/no-products-found.php' ); ?>

		<?php endif; ?>

	<?php
		/**
		 * woocommerce_after_main_content hook
		 *
		 * @hooked woocommerce_output_content_wrapper_end - 10 (outputs closing divs for the content)
		 */
		// do_action( 'woocommerce_after_main_content' );
	?>
	</div><!--end percent-blog-->
	<?php
		/**
		 * woocommerce_sidebar hook
		 *
		 * @hooked woocommerce_get_sidebar - 10
		 */

		if($smof_data['woo_layout'] != 'no-sidebar') {
			echo '<div class="percent-sidebar">';
				if(isset($smof_data['woo_sidebar'])) { 
					dynamic_sidebar( $smof_data['woo_sidebar'] ); 
				}
				else dynamic_sidebar('sidebar');
			echo '</div>';
		}
	?>

</div>	

<?php get_footer( 'shop' ); ?>