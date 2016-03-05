<?php get_header(); ?>

	<?php if (have_posts()) : while (have_posts()) : the_post(); ?>
	
		<section>
			<article id="templatera-<?php the_ID(); ?>" class="begin-content">
				<section>
					<?php the_content(); ?>
				</section>
			</article>
		</section>

	<?php endwhile; ?>

	<?php endif; ?>


<?php get_footer(); ?>