<?php get_header(); 
	
	get_template_part( 'includes/page-title' );
	
?>	

<?php 
	$ns = '';
	if(isset($smof_data['blog_sidebar_pos'])) {
		if($smof_data['blog_sidebar_pos'] == 'no-blog-sidebar') {
			$ns = 'nu-sidebar'; 
		}
	} 
?>

	<div class="centered-wrapper">	
		<section id="blog" class="post-single">
		
			<?php if (have_posts()) : while (have_posts()) : the_post(); ?>

				<div class="percent-blog begin-content <?php if(isset($smof_data['blog_sidebar_pos'])) { if($smof_data['blog_sidebar_pos'] !='') { echo $smof_data['blog_sidebar_pos']; } } else echo 'sidebar-right'; ?>">
				<?php
					get_template_part( 'format', get_post_format() ); ?>	

					<div class="post-bottom-content">
						<?php $posttags = get_the_tags(); 
						if($posttags) { 
							echo '<h6 class="tag-title">';
							_e('Tags: ', 'delicious'); 
							echo '</h6>';
							the_tags( '<ul class="tags"><li>','</li><li>','</li></ul>'); } 
						?>	
								
						<?php if(isset($smof_data['social_box'])) { if($smof_data['social_box'] =='1') { ?>						
							<div class="share-options">
								<h6><?php _e("Share this post: ", "delicious"); ?></h6>
								<a href="" class="twitter-sharer" onClick="twitterSharer()"><i class="fa fa-twitter"></i></a>
								<a href="" class="facebook-sharer" onClick="facebookSharer()"><i class="fa fa-facebook"></i></a>
								<a href="" class="pinterest-sharer" onClick="pinterestSharer()"><i class="fa fa-pinterest"></i></a>
								<a href="" class="google-sharer" onClick="googleSharer()"><i class="fa fa-google-plus"></i></a>
								<a href="" class="delicious-sharer" onClick="deliciousSharer()"><i class="fa fa-share"></i></a>
								<a href="" class="linkedin-sharer" onClick="linkedinSharer()"><i class="fa fa-linkedin"></i></a>
							</div>
							
						<?php  } } ?>

					<?php if(isset($smof_data['prev_next_posts'])) { if($smof_data['prev_next_posts'] =='1') { ?>	
						<div class="next-prev-posts">
							<div class="previous-post what-post"><?php previous_post_link(); ?></div>
							<div class="next-post what-post"><?php next_post_link(); ?> </div>
						</div>	
					<?php  } } ?>					
						
						<?php if(isset($smof_data['author_box'])) { if($smof_data['author_box'] =='1') { ?>
						
							<div class="author-bio">							
								<?php echo get_avatar( get_the_author_meta('user_email'), '70', '' ); ?>
								<div class="authorp">
									<h2><?php _e('Author: ', 'delicious'); ?><?php the_author_link(); ?></h2>
									<p><?php the_author_meta('description'); ?></p>							
								</div>
							</div>	

							<div class="double-separator"></div>
						
						<?php  } } ?>
					
						<?php comments_template(); ?>
				
					</div><!--end post-bottom-content-->
				</div>
				<?php endwhile; else: ?>
					<div id="posts" class="single-post blog-page <?php echo $sidebar_class; ?>">
						<section>
							<article>
								<p><?php _e('Sorry, no posts matched your criteria. ', 'delicious'); ?></p>
							</article>
						</section>
					</div>
				<?php endif; ?>				

		</section> 
		
		<?php 
			echo '<aside class="percent-sidebar '.$ns.'">';
				if(isset($smof_data['blog_sidebar'])) {
					if($smof_data['blog_sidebar'] !='') { 
						$blog_sidebar_pos = $smof_data['blog_sidebar']; 
						dynamic_sidebar($blog_sidebar_pos); 
					}
				}
			echo '</aside>';
		?>

		<div class="clear"></div>
	</div><!--end centered-wrapper-->	
			
<?php get_footer(); ?>