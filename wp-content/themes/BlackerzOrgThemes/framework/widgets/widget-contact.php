<?php
/******************************************
/* Fancy Contact Widget
******************************************/
class dt_fancy_contact extends WP_Widget {
							
    /** constructor */
    function dt_fancy_contact() {
        parent::WP_Widget(false, $name = 'Patti - Fancy Contact');
    }

    /** @see WP_Widget::widget */
    function widget($args, $instance) {		
        extract( $args );
        $title = apply_filters('widget_title', $instance['title']);
        $address = apply_filters('widget_title', $instance['address']);
        $phone = apply_filters('widget_title', $instance['phone']);
        $email = apply_filters('widget_title', $instance['email']);
			echo $before_widget;
                if ( $title )
					echo $before_title . $title . $after_title;
					?>								
						<ul id="contact-widget">
							<li class="address"><i class="fa fa-info-circle"></i><?php _e('Address: ', 'delicious'); echo $address; ?></li>		
							<li class="phone"><i class="fa fa-phone"></i><?php _e('Phone: ', 'delicious'); echo $phone; ?></li>		
							<li class="email"><i class="fa fa-envelope"></i><?php _e('E-mail: ', 'delicious'); ?><a href="mailto:<?php echo $email; ?>"><?php echo $email; ?></a></li>	
						</ul><!--end contact-widget-->
								
					<?php 
					echo $after_widget;
    }

    /** @see WP_Widget::update */
    function update($new_instance, $old_instance) {				
	$instance = $old_instance;
	$instance['title'] = strip_tags($new_instance['title']);
	$instance['address'] = strip_tags($new_instance['address']);
	$instance['phone'] = strip_tags($new_instance['phone']);
	$instance['email'] = strip_tags($new_instance['email']);
        return $instance;
    }

    /** @see WP_Widget::form */
    function form($instance) {
		$instance = wp_parse_args( (array) $instance, array( 'title' => 'Get In Touch With Us', 'address'=> '1600 Amphitheatre Parkway, Mountain View, CA 94043', 'phone' => '+321 123 456 7', 'email' => 'johndoe@ipsum.com'));			
        $title = esc_attr($instance['title']);
        $address = esc_attr($instance['address']);
        $phone = esc_attr($instance['phone']);
        $email = esc_attr($instance['email']);
        ?>
         <p>
          <label for="<?php echo $this->get_field_id('title'); ?>"><?php _e('Title: ', 'delicious'); ?></label> 
          <input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo $title; ?>" />
        </p>
		<p>
          <label for="<?php echo $this->get_field_id('address'); ?>"><?php _e('Address:', 'delicious'); ?></label> 
          <input class="widefat" id="<?php echo $this->get_field_id('address'); ?>" name="<?php echo $this->get_field_name('address'); ?>" type="text" value="<?php echo $address; ?>" />
        </p>
		<p>
          <label for="<?php echo $this->get_field_id('phone'); ?>"><?php _e('Phone:', 'delicious'); ?></label> 
          <input class="widefat" id="<?php echo $this->get_field_id('phone'); ?>" name="<?php echo $this->get_field_name('phone'); ?>" type="text" value="<?php echo $phone; ?>" />
        </p>
		<p>
          <label for="<?php echo $this->get_field_id('email'); ?>"><?php _e('Email:', 'delicious'); ?></label> 
          <input class="widefat" id="<?php echo $this->get_field_id('email'); ?>" name="<?php echo $this->get_field_name('email'); ?>" type="text" value="<?php echo $email; ?>" />
        </p>		
        <?php 
    }

} // class dt_fancy_contact
// register Recent Posts widget
add_action('widgets_init', create_function('', 'return register_widget("dt_fancy_contact");'));	
?>