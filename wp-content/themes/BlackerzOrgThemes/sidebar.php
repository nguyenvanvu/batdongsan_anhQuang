		<aside class="percent-sidebar">
		<?php	
		$dt_sidebars = get_post_meta($post->ID, 'dt_all_sidebars', true);
		if(!empty($dt_sidebars)) { 
				dynamic_sidebar( $dt_sidebars );
		}

		else {
			if ( is_active_sidebar( 'sidebar' ) ) { 
				dynamic_sidebar( 'sidebar' ); 
				}		
			}
		?>
		</aside>