<?php
/******************************************
/* Twitter Widget using API V1.1
******************************************/

/**
 * Register the Widget
 */
add_action( 'widgets_init', create_function( '', 'register_widget("dt_twitter_widget");' ) );

/**
 * Create the widget class and extend from the WP_Widget
 */
 class dt_twitter_widget extends WP_Widget {

	private $twitter_title = "Recent Tweets";
	private $twitter_username = "deliciousthemes";
	private $twitter_postcount = "3";
	private $twitter_consumer_key = "";
	private $twitter_consumer_secret = "";
	private $twitter_access_token = "";
	private $twitter_access_token_secret = "";

	/**
	 * Register widget with WordPress.
	 */
	public function __construct() {

		parent::__construct(
			'dt_twitter_widget',		// Base ID
			'Patti - Twitter Widget',		// Name
			array(
				'classname'		=>	'dt_twitter_widget',
				'description'	=>	__('A widget that displays your latest tweets.', 'delicious')
			)
		);

		// Load JavaScript and stylesheets
		$this->register_scripts_and_styles();

	} // end constructor

	/**
	 * Registers and enqueues stylesheets for the administration panel and the
	 * public facing site.
	 */
	public function register_scripts_and_styles() {

	} // end register_scripts_and_styles

	/**
	 * Front-end display of widget.
	 *
	 * @see WP_Widget::widget()
	 *
	 * @param array $args     Widget arguments.
	 * @param array $instance Saved values from database.
	 */
	public function widget( $args, $instance ) {
		extract( $args );

		/* Our variables from the widget settings. */
		$this->twitter_title = apply_filters('widget_title', $instance['title'] );

		$this->twitter_username = $instance['username'];
		$this->twitter_postcount = $instance['postcount'];
		$this->twitter_consumer_key = $instance['consumerkey'];
		$this->twitter_consumer_secret = $instance['consumersecret'];
		$this->twitter_access_token = $instance['accesstoken'];
		$this->twitter_access_token_secret = $instance['accesstokensecret'];

		$transName = 'list_tweets';
	    $cacheTime = 20;

	    if(false === ($twitterData = get_transient($transName) ) ){
	    	require_once 'twitteroauth.php';
			$twitterConnection = new TwitterOAuth(
								$this->twitter_consumer_key,			// Consumer Key
								$this->twitter_consumer_secret,   		// Consumer secret
								$this->twitter_access_token,       		// Access token
								$this->twitter_access_token_secret    	// Access token secret
								);

			$twitterData = $twitterConnection->get(
					  'statuses/user_timeline',
					  array(
					    'screen_name'     => $this->twitter_username,
					    'count'           => $this->twitter_postcount,
					    'exclude_replies' => false
					  )
					);

			if($twitterConnection->http_code != 200)
			{
				$twitterData = get_transient($transName);
			}

	        // Save our new transient.
	        set_transient($transName, $twitterData, 60 * $cacheTime);
	    }

		/* Before widget (defined by themes). */
		echo $before_widget;
		?>
		<div class="twitter-box"><?php

		/* Display the widget title if one was input (before and after defined by themes). */
		if ( $this->twitter_title )
			echo $before_title . $this->twitter_title . $after_title;

		/* Display Latest Tweets */
		 ?>

            <?php
            	if(!empty($twitterData) || !isset($twitterData['error'])){
            		$i=0;
					$hyperlinks = true;
					$encode_utf8 = true;
					$twitter_users = true;
					$update = true;
					
					echo '<ul class="widget-tweet-list">';

		            foreach($twitterData as $item){

		                    $msg = $item->text;
		                    $permalink = 'http://twitter.com/#!/'. $this->twitter_username .'/status/'. $item->id_str;
							$retweet = 'http://twitter.com/intent/retweet?tweet_id='. $item->id_str;
							$tweet_reply = 'http://twitter.com/intent/tweet?in_reply_to='. $item->id_str;
		                    if($encode_utf8) $msg = utf8_encode($msg);
                                    $msg = $this->encode_tweet($msg);
		                    $link = $permalink;
		                     echo '<li>';

		                      if ($hyperlinks) {    $msg = $this->hyperlinks($msg); }
		                      if ($twitter_users)  { $msg = $this->twitter_users($msg); }

		                      echo '<div class="widget-tweet-text">'.$msg.'</div>';

		                    if($update) {
		                      $time = strtotime($item->created_at);

		                      if ( ( abs( time() - $time) ) < 86400 )
		                        $h_time = sprintf( __('%s ago', 'delicious'), human_time_diff( $time ) );
		                      else
		                        $h_time = date(__('Y/m/d', 'delicious'), $time);

		                      echo sprintf( __('%s', 'delicious'),' <span class="widget-tweet-time"><a href="'.$link.'"><abbr title="' . date(__('Y/m/d H:i:s', 'delicious'), $time) . '">' . $h_time . '</abbr></a></span>' );
							  echo '<a class="widget-tweet-action widget-tweet-reply" href="'.$tweet_reply.'">Reply</a>';
							  echo '<a class="widget-tweet-action widget-tweet-retweet" href="'.$retweet.'">Retweet</a>';
		                     }

		                    echo '</li>';

		                    $i++;
		                    if ( $i >= $this->twitter_postcount ) break;
		            }

					echo '</ul>';

            	}
            ?>
       		</div>
		<?php

		/* After widget (defined by themes). */
		echo $after_widget;
	}

	/**
	 * Sanitize widget form values as they are saved.
	 *
	 * @see WP_Widget::update()
	 *
	 * @param array $new_instance Values just sent to be saved.
	 * @param array $old_instance Previously saved values from database.
	 *
	 * @return array Updated safe values to be saved.
	 */
	function update( $new_instance, $old_instance ) {
		$instance = $old_instance;

		// Strip tags to remove HTML (important for text inputs)
		foreach($new_instance as $k => $v){
			$instance[$k] = strip_tags($v);
		}

		return $instance;
	}

	/**
	 * Create the form for the Widget admin
	 *
	 * @see WP_Widget::form()
	 *
	 * @param array $instance Previously saved values from database.
	 */
	function form( $instance ) {

		/* Set up some default widget settings. */
		$defaults = array(
		'title' => $this->twitter_title,
		'username' => $this->twitter_username,
		'postcount' => $this->twitter_postcount,
		'consumerkey' => $this->twitter_consumer_key,
		'consumersecret' => $this->twitter_consumer_secret,
		'accesstoken' => $this->twitter_access_token,
		'accesstokensecret' => $this->twitter_access_token_secret,
		);
		$instance = wp_parse_args( (array) $instance, $defaults ); ?>

		<!-- Widget Title: Text Input -->
		<p>
			<label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e('Title:', 'delicious') ?></label>
			<input type="text" class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" value="<?php echo $instance['title']; ?>" />
		</p>

		<!-- Username: Text Input -->
		<p>
			<label for="<?php echo $this->get_field_id( 'username' ); ?>"><?php _e('Twitter Username', 'delicious') ?></label>
			<input type="text" class="widefat" id="<?php echo $this->get_field_id( 'username' ); ?>" name="<?php echo $this->get_field_name( 'username' ); ?>" value="<?php echo $instance['username']; ?>" />
		</p>

		<!-- Postcount: Text Input -->
		<p>
			<label for="<?php echo $this->get_field_id( 'postcount' ); ?>"><?php _e('Number of tweets', 'delicious') ?></label>
			<input type="text" class="widefat" id="<?php echo $this->get_field_id( 'postcount' ); ?>" name="<?php echo $this->get_field_name( 'postcount' ); ?>" value="<?php echo $instance['postcount']; ?>" />
		</p>
		
		<!-- Consumer Key: Text Input -->
		<p>
			<label for="<?php echo $this->get_field_id( 'consumerkey' ); ?>"><?php _e('Consumer Key', 'delicious') ?></label>
			<input type="text" class="widefat" id="<?php echo $this->get_field_id( 'consumerkey' ); ?>" name="<?php echo $this->get_field_name( 'consumerkey' ); ?>" value="<?php echo $instance['consumerkey']; ?>" />
		</p>		

		<!-- Consumer Secret: Text Input -->
		<p>
			<label for="<?php echo $this->get_field_id( 'consumersecret' ); ?>"><?php _e('Consumer Secret', 'delicious') ?></label>
			<input type="text" class="widefat" id="<?php echo $this->get_field_id( 'consumersecret' ); ?>" name="<?php echo $this->get_field_name( 'consumersecret' ); ?>" value="<?php echo $instance['consumersecret']; ?>" />
		</p>			

		<!-- Access Token: Text Input -->
		<p>
			<label for="<?php echo $this->get_field_id( 'accesstoken' ); ?>"><?php _e('Access Token', 'delicious') ?></label>
			<input type="text" class="widefat" id="<?php echo $this->get_field_id( 'accesstoken' ); ?>" name="<?php echo $this->get_field_name( 'accesstoken' ); ?>" value="<?php echo $instance['accesstoken']; ?>" />
		</p>

		<!-- Access Token Secret: Text Input -->
		<p>
			<label for="<?php echo $this->get_field_id( 'accesstokensecret' ); ?>"><?php _e('Access Token Secret', 'delicious') ?></label>
			<input type="text" class="widefat" id="<?php echo $this->get_field_id( 'accesstokensecret' ); ?>" name="<?php echo $this->get_field_name( 'accesstokensecret' ); ?>" value="<?php echo $instance['accesstokensecret']; ?>" />
		</p>		
	<?php
	}

	/**
	 * Find links and create the hyperlinks
	 */
	private function hyperlinks($text) {
	    $text = preg_replace('/\b([a-zA-Z]+:\/\/[\w_.\-]+\.[a-zA-Z]{2,6}[\/\w\-~.?=&#038;%#+$*!]*)\b/i',"<a href=\"$1\" class=\"twitter-link\">$1</a>", $text);
	    $text = preg_replace('/\b(?<!:\/\/)(www\.[\w_.\-]+\.[a-zA-Z]{2,6}[\/\w\-~.?=&#038;%#+$*!]*)\b/i',"<a href=\"http://$1\" class=\"twitter-link\">$1</a>", $text);

	    // match name@address
	    $text = preg_replace("/\b([a-zA-Z][a-zA-Z0-9\_\.\-]*[a-zA-Z]*\@[a-zA-Z][a-zA-Z0-9\_\.\-]*[a-zA-Z]{2,6})\b/i","<a href=\"mailto://$1\" class=\"twitter-link\">$1</a>", $text);
	        //mach #trendingtopics. Props to Michael Voigt
	    $text = preg_replace('/([\.|\,|\:|\|\|\>|\{|\(]?)#{1}(\w*)([\.|\,|\:|\!|\?|\>|\}|\)]?)\s/i', "$1<a href=\"http://twitter.com/#search?q=$2\" class=\"twitter-link\">#$2</a>$3 ", $text);
	    return $text;
	}

	/**
	 * Find twitter usernames and link to them
	 */
	private function twitter_users($text) {
	       $text = preg_replace('/([\.|\,|\:|\|\|\>|\{|\(]?)@{1}(\w*)([\.|\,|\:|\!|\?|\>|\}|\)]?)\s/i', "$1<a href=\"http://twitter.com/$2\" class=\"twitter-user\">@$2</a>$3 ", $text);
	       return $text;
	}

        /**
         * Encode single quotes in your tweets
         */
        private function encode_tweet($text) {
                $text = mb_convert_encoding( $text, "HTML-ENTITIES", "UTF-8");
                return $text;
        }

 }
?>