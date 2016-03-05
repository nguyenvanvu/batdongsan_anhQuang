<?php global $smof_data; //get theme options ?>

	<footer id="footer">		
	
		<div class="centered-wrapper">
		<?php
			if ( is_active_sidebar( 'top-footer' ) ) : ?>		
			<div id="topfooter">
				<?php dynamic_sidebar( 'top-footer' ); ?>
			</div><!--end topfooter-->
		<?php endif; ?>	
	
		</div><!--end centered-wrapper-->
		
		<?php  
			$fclass = '';
			if(isset($smof_data['footer_layout'])) {
				if($smof_data['footer_layout'] == 2) {
					$fclass = 'cfooter';
				}
			} 
		?>

		<div id="bottomfooter" <?php if($fclass != '') { echo 'class="'. $fclass .'"'; } ?> >		
			<div class="centered-wrapper">	
				<div class="percent-two-third">
					<?php if(isset($smof_data['copyright_textarea']) && ($smof_data['copyright_textarea'] !='')) { ?>
					<p><?php echo wp_kses_post($smof_data['copyright_textarea']);  ?></p>
					<?php } else { ?>
					<p><a href="http://www.mafiashare.net">Wordpress</a></p>
					<?php } ?>
				</div><!--end percent-two-third-->

				<div class="percent-one-third column-last">
					<ul id="social">
						<?php
							$social_links = array('rss','facebook','twitter','flickr','google-plus', 'dribbble' , 'linkedin', 'pinterest', 'youtube', 'github-alt', 'vimeo-square', 'instagram', 'tumblr', 'behance', 'vk', 'xing', 'soundcloud', 'codepen', 'yelp');
							if($social_links) {
								foreach($social_links as $social_link) {
									if(!empty($smof_data[$social_link])) { echo '<li><a href="'. esc_url($smof_data[$social_link]) .'" title="'. $social_link .'" class="'.$social_link.'"  target="_blank"><i class="fa fa-'.$social_link.'"></i></a></li>';
									}								
								}
								if(!empty($smof_data['skype'])) { echo '<li><a href="skype:'. $smof_data['skype'] .'?call" title="'. $smof_data['skype'] .'" class="'.$smof_data['skype'].'"  target="_blank"><i class="fa fa-skype"></i></a></li>';
								}							
							}
						?>					
					</ul>				
					
				</div><!--end percent-one-third-->
			</div><!--end centered-wrapper-->				
		</div><!--end bottomfooter-->
		
		<a href="#" class="totop"><i class="fa fa-angle-double-up"></i></a>

	</footer><!--end footer-->	
</div><!--end wrapper-->

	<?php wp_footer(); ?>

    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
      <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->	
</body> 
</html>