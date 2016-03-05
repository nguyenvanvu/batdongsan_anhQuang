<?php
/******************************************
/* Recent Posts Widget
******************************************/
class dt_recent_posts extends WP_Widget {
							
    /** constructor */
    function dt_recent_posts() {
        parent::WP_Widget(false, $name = 'Patti - Recent Posts');
    }

    /** @see WP_Widget::widget */
    function widget($args, $instance) {		
        extract( $args );
        $title = apply_filters('widget_title', $instance['title']);
        $number = apply_filters('widget_title', $instance['number']);
			echo $before_widget;
                if ( $title )
					echo $before_title . $title . $after_title;
						$recPosts = new WP_Query();
						$recPosts->query('showposts='.$number.'');
							while ($recPosts->have_posts()) : $recPosts->the_post(); ?>								
								<div class="sidebar-post">
									<h5><a href="<?php the_permalink(); ?>"><?php the_title();?></a></h5><span><?php the_time(get_option('date_format')); ?> / <?php comments_popup_link(__('No Comments', 'delicious'), __('1 Comment', 'delicious'), __('% Comments', 'delicious')); ?></span>					
								</div><!--end sidebar-post-->
								
							<?php endwhile; 
						wp_reset_query();
					echo $after_widget;
    }

    /** @see WP_Widget::update */
    function update($new_instance, $old_instance) {				
	$instance = $old_instance;
	$instance['title'] = strip_tags($new_instance['title']);
	$instance['number'] = strip_tags($new_instance['number']);
        return $instance;
    }

    /** @see WP_Widget::form */
    function form($instance) {
		$instance = wp_parse_args( (array) $instance, array( 'title' => 'Recent Posts', 'number'=> 3));			
        $title = esc_attr($instance['title']);
        $number = esc_attr($instance['number']);
        ?>
         <p>
          <label for="<?php echo $this->get_field_id('title'); ?>"><?php _e('Title: ', 'delicious'); ?></label> 
          <input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo $title; ?>" />
        </p>
		<p>
          <label for="<?php echo $this->get_field_id('number'); ?>"><?php _e('Number of Posts to Show:', 'delicious'); ?></label> 
          <input class="widefat" id="<?php echo $this->get_field_id('number'); ?>" name="<?php echo $this->get_field_name('number'); ?>" type="text" value="<?php echo $number; ?>" />
        </p>
        <?php 
    }

} // class dt_recent_posts
// register Recent Posts widget
add_action('widgets_init', create_function('', 'return register_widget("dt_recent_posts");'));	
?>