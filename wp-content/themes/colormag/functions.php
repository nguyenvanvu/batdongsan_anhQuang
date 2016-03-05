<?php
/**
 * ColorMag functions related to defining constants, adding files and WordPress core functionality.
 *
 * Defining some constants, loading all the required files and Adding some core functionality.
 * @uses add_theme_support() To add support for post thumbnails and automatic feed links.
 * @uses register_nav_menu() To add support for navigation menu.
 * @uses set_post_thumbnail_size() To set a custom post thumbnail size.
 *
 * @package ThemeGrill
 * @subpackage ColorMag
 * @since ColorMag 1.0
 */

/**
 * Set the content width based on the theme's design and stylesheet.
 */
if ( ! isset( $content_width ) )
   $content_width = 800;

/**
 * $content_width global variable adjustment as per layout option.
 */
function colormag_content_width() {
   global $post;
   global $content_width;

   if( $post ) { $layout_meta = get_post_meta( $post->ID, 'colormag_page_layout', true ); }
   if( empty( $layout_meta ) || is_archive() || is_search() ) { $layout_meta = 'default_layout'; }
   $colormag_default_layout = get_theme_mod( 'colormag_default_layout', 'right_sidebar' );

   if( $layout_meta == 'default_layout' ) {
      if ( $colormag_default_layout == 'no_sidebar_full_width' ) { $content_width = 1140; /* pixels */ }
      else { $content_width = 800; /* pixels */ }
   }
   elseif ( $layout_meta == 'no_sidebar_full_width' ) { $content_width = 1140; /* pixels */ }
   else { $content_width = 800; /* pixels */ }
}
add_action( 'template_redirect', 'colormag_content_width' );

add_action( 'after_setup_theme', 'colormag_setup' );
/**
 * All setup functionalities.
 *
 * @since 1.0
 */
if( !function_exists( 'colormag_setup' ) ) :
function colormag_setup() {

	/*
	 * Make theme available for translation.
	 * Translations can be filed in the /languages/ directory.
	 */
	load_theme_textdomain( 'colormag', get_template_directory() . '/languages' );

	// Add default posts and comments RSS feed links to head
	add_theme_support( 'automatic-feed-links' );

	// This theme uses Featured Images (also known as post thumbnails) for per-post/per-page.
	add_theme_support( 'post-thumbnails' );

	// Registering navigation menu.
	register_nav_menu( 'primary', __( 'Primary Menu', 'colormag' ) );

	// Cropping the images to different sizes to be used in the theme
   add_image_size( 'colormag-highlighted-post', 392, 272, true );
   add_image_size( 'colormag-featured-post-medium', 390, 205, true );
   add_image_size( 'colormag-featured-post-small', 130, 90, true );
   add_image_size( 'colormag-featured-image', 800, 445, true );

	// Setup the WordPress core custom background feature.
	add_theme_support( 'custom-background', apply_filters( 'colormag_custom_background_args', array(
		'default-color' => 'eaeaea'
	) ) );

	/*
    * Let WordPress manage the document title.
    * By adding theme support, we declare that this theme does not use a
    * hard-coded <title> tag in the document head, and expect WordPress to
    * provide it for us.
    */
   add_theme_support('title-tag');

	// Enable support for Post Formats.
	add_theme_support( 'post-formats', array( 'aside', 'image', 'video', 'quote', 'link', 'gallery', 'chat', 'audio', 'status' ) );

	// Adding excerpt option box for pages as well
	add_post_type_support( 'page', 'excerpt' );

   /*
    * Switch default core markup for search form, comment form, and comments
    * to output valid HTML5.
    */
   add_theme_support('html5', array(
       'search-form', 'comment-form', 'comment-list', 'gallery', 'caption',
   ));
}
endif;

/**
 * Define Directory Location Constants
 */
define( 'COLORMAG_PARENT_DIR', get_template_directory() );
define( 'COLORMAG_CHILD_DIR', get_stylesheet_directory() );

define( 'COLORMAG_INCLUDES_DIR', COLORMAG_PARENT_DIR. '/inc' );
define( 'COLORMAG_CSS_DIR', COLORMAG_PARENT_DIR . '/css' );
define( 'COLORMAG_JS_DIR', COLORMAG_PARENT_DIR . '/js' );
define( 'COLORMAG_LANGUAGES_DIR', COLORMAG_PARENT_DIR . '/languages' );

define( 'COLORMAG_ADMIN_DIR', COLORMAG_INCLUDES_DIR . '/admin' );
define( 'COLORMAG_WIDGETS_DIR', COLORMAG_INCLUDES_DIR . '/widgets' );

define( 'COLORMAG_ADMIN_IMAGES_DIR', COLORMAG_ADMIN_DIR . '/images' );

/**
 * Define URL Location Constants
 */
define( 'COLORMAG_PARENT_URL', get_template_directory_uri() );
define( 'COLORMAG_CHILD_URL', get_stylesheet_directory_uri() );

define( 'COLORMAG_INCLUDES_URL', COLORMAG_PARENT_URL. '/inc' );
define( 'COLORMAG_CSS_URL', COLORMAG_PARENT_URL . '/css' );
define( 'COLORMAG_JS_URL', COLORMAG_PARENT_URL . '/js' );
define( 'COLORMAG_LANGUAGES_URL', COLORMAG_PARENT_URL . '/languages' );

define( 'COLORMAG_ADMIN_URL', COLORMAG_INCLUDES_URL . '/admin' );
define( 'COLORMAG_WIDGETS_URL', COLORMAG_INCLUDES_URL . '/widgets' );

define( 'COLORMAG_ADMIN_IMAGES_URL', COLORMAG_ADMIN_URL . '/images' );

/** Load functions */
require_once( COLORMAG_INCLUDES_DIR . '/custom-header.php' );
require_once( COLORMAG_INCLUDES_DIR . '/functions.php' );
require_once( COLORMAG_INCLUDES_DIR . '/header-functions.php' );
require_once( COLORMAG_INCLUDES_DIR . '/customizer.php' );

require_once( COLORMAG_ADMIN_DIR . '/meta-boxes.php' );

/** Load Widgets and Widgetized Area */
require_once( COLORMAG_WIDGETS_DIR . '/widgets.php' );



// Creating the widget 
class wpb_widget extends WP_Widget {

	function __construct() {
		$widget_ops = array( 
		'classname' => 'widget_featured_posts widget_featured_posts_vertical widget_featured_meta', 
		'description' => __( 'Sample widget based on WPBeginner Tutorial', 'colormag') );
	parent::__construct(
			// Base ID of your widget
			'wpb_widget', 

			// Widget name will appear in UI
			__('WPBeginner Widget', 'wpb_widget_domain'), 
			

			// Widget description
			$widget_ops
		);
	}

	// Creating widget front-end
	// This is where the action happens
	public function widget( $args, $instance ) {
		$title = apply_filters( 'widget_title', $instance['title'] );
		// before and after widget arguments are defined by themes
		echo $args['before_widget'];
		if ( ! empty( $title ) )
			echo $args['before_title'] . $title . $args['after_title'];

		// This is where you run the code and display the output
		?>
			
		<?php
		echo __( 'Hello, World!', 'wpb_widget_domain' );
		echo $args['after_widget'];
	}
		
	// Widget Backend 
	public function form( $instance ) {
		if ( isset( $instance[ 'title' ] ) ) {
			$title = $instance[ 'title' ];
		}
		else {
			$title = __( 'New title', 'wpb_widget_domain' );
		}
		// Widget admin form
?>
	<p>
	<h3 class="widget-title" style="border-bottom-color:;">
		<label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e( 'Title:' ); ?></label> 
	</h3>
	<input class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" type="text" value="<?php echo esc_attr( $title ); ?>" />
	</p>
<?php 
	}
	
	// Updating widget replacing old instances with new
	public function update( $new_instance, $old_instance ) {
		$instance = array();
		$instance['title'] = ( ! empty( $new_instance['title'] ) ) ? strip_tags( $new_instance['title'] ) : '';
		return $instance;
	}
}
 // Class wpb_widget ends here
// Register and load the widget
	function wpb_load_widget() {
		register_widget( 'wpb_widget' );
	}
	add_action( 'widgets_init', 'wpb_load_widget' );


?>