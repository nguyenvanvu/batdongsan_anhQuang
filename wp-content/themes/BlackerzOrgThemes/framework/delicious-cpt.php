<?php
/*
Plugin Name: Delicious Custom Post Types
Plugin URI: http://themeforest.net/user/DeliciousThemes
Description: Custom post types for DeliciousThemes WordPress Themes
Version: 1.0
Author: DeliciousThemes
Author URI: http://themeforest.net/user/DeliciousThemes
*/

/**
* 
*/

class DT_Post_Types {
	
	public function __construct()
	{
		$this->register_post_type();
		$this->taxonomies();
		$this->delicious_link_to_cpt();
	}

	public function register_post_type()
	{
		$args = array();
		global $smof_data; //get theme options
		// Portfolio
		$args['post-type-portfolio'] = array(
			'labels' => array(
				'name' => __( 'Projects', 'delicious' ),
				'singular_name' => __( 'Portfolio Item', 'delicious' ),
				'all_items' => 'Projects',
				'add_new' => __( 'Add New', 'delicious' ),
				'add_new_item' => __( 'Add New Portfolio Item', 'delicious' ),
				'edit_item' => __( 'Edit Project', 'delicious' ),
				'new_item' => __( 'New Project', 'delicious' ),
				'view_item' => __( 'View Project', 'delicious' ),
				'search_items' => __( 'Search Projects', 'delicious' ),
				'not_found' => __( 'No projects found', 'delicious' ),
				'not_found_in_trash' => __( 'No projects found in Trash', 'delicious' ),
				'parent_item_colon' => __( 'Parent Portfolio:', 'delicious' ),
				'menu_name' => __( 'Portfolio', 'delicious' ),
			),		  
			'hierarchical' => true,
	        'description' => 'Add your Projects',
	        'supports' => array( 'title', 'editor', 'thumbnail', 'revisions' ),
			'taxonomies' => array('portfolio_cats'),
			'menu_icon' =>  'dashicons-portfolio',
			'show_ui' => true,
	        'public' => true,
	        'publicly_queryable' => true,
	        'exclude_from_search' => false,
	        'query_var' => 'portfolio',
	        'rewrite' => array('slug' => $smof_data['portfolio_slug'], 'with_front' => false)
			);

		// Services
		$args['post-type-services'] = array(
			'labels' => array(
				'name' => __( 'Services', 'delicious' ),
				'singular_name' => __( 'Services Item', 'delicious' ),
				'add_new' => __( 'Add New', 'delicious' ),
				'add_new_item' => __( 'Add New Services Item', 'delicious' ),
				'edit_item' => __( 'Edit Services Item', 'delicious' ),
				'new_item' => __( 'New Services Item', 'delicious' ),
				'view_item' => __( 'View Services Item', 'delicious' ),
				'search_items' => __( 'Search Services Items', 'delicious' ),
				'not_found' => __( 'No service found', 'delicious' ),
				'not_found_in_trash' => __( 'No service found in Trash', 'delicious' ),
				'parent_item_colon' => __( 'Parent Service:', 'delicious' ),				
			),		  
			'hierarchical' => false,
	        'description' => __( 'Add Your Services Items', 'delicious' ),
	        'supports' => array('title'),
	        'menu_icon' =>  'dashicons-lightbulb',
	        'public' => true,
	        'publicly_queryable' => true,
	        'exclude_from_search' => false,
	        'query_var' => true,
	        'rewrite' => true 
			);

		// Team
		$args['post-type-team'] = array(
			'labels' => array(
				'name' => __( 'Team Members', 'delicious' ),
				'singular_name' => __( 'Team Member', 'delicious' ),
				'all_items' => 'Team Members',
				'add_new' => __( 'Add New', 'delicious' ),
				'add_new_item' => __( 'Add New Team Member', 'delicious' ),
				'edit_item' => __( 'Edit Team Member', 'delicious' ),
				'new_item' => __( 'New Team Member', 'delicious' ),
				'view_item' => __( 'View Team Member', 'delicious' ),
				'search_items' => __( 'Search Through Team Members', 'delicious' ),
				'not_found' => __( 'No members found', 'delicious' ),
				'not_found_in_trash' => __( 'No members found in Trash', 'delicious' ),
				'parent_item_colon' => __( 'Parent Team Member:', 'delicious' ),
				'menu_name' => __( 'Team', 'delicious' ),
				
			),		  
			'hierarchical' => false,
	        'description' => __( 'Add a team member', 'delicious' ),
	        'supports' => array( 'title', 'thumbnail'),
	        'menu_icon' =>  'dashicons-businessman',
	        'public' => true,
	        'publicly_queryable' => true,
	        'exclude_from_search' => false,
	        'query_var' => true,
	        'rewrite' => array('slug' => 'member', 'with_front' => false)
			);	  

		// Testimonials
		$args['post-type-testimonials'] = array(
			'labels' => array(
				'name' => __( 'Testimonials', 'delicious' ),
				'singular_name' => __( 'Testimonial', 'delicious' ),
				'add_new' => __( 'Add New', 'delicious' ),
				'add_new_item' => __( 'Add New Testimonial', 'delicious' ),
				'edit_item' => __( 'Edit Testimonial', 'delicious' ),
				'new_item' => __( 'New Testimonial', 'delicious' ),
				'view_item' => __( 'View Testimonial', 'delicious' ),
				'search_items' => __( 'Search Through Testimonials', 'delicious' ),
				'not_found' => __( 'No testimonials found', 'delicious' ),
				'not_found_in_trash' => __( 'No testimonials found in Trash', 'delicious' ),
				'parent_item_colon' => __( 'Parent Testimonial:', 'delicious' ),
				'menu_name' => __( 'Testimonials', 'delicious' ),
				
			),		  
			'hierarchical' => false,
	        'description' => __( 'Add a Testimonial', 'delicious' ),
	        'supports' => array( 'title'),
	        'menu_icon' =>  'dashicons-testimonial',
	        'public' => true,
	        'publicly_queryable' => true,
	        'exclude_from_search' => false,
	        'query_var' => true,
	        'rewrite' => true 
			);	

		// Register post type: name, arguments
		register_post_type('portfolio', $args['post-type-portfolio']);
		register_post_type('services', $args['post-type-services']);
		register_post_type('team', $args['post-type-team']);
		register_post_type('testimonials', $args['post-type-testimonials']);
	}

	public function taxonomies() {
		$taxonomies = array();

		$taxonomies['taxonomy-portfolio_cats'] = array(
			'labels' => array(
				'name' => __( 'Portfolio Categories', 'delicious' ),
				'singular_name' => __( 'Portfolio Category', 'delicious' ),
				'search_items' =>  __( 'Search Portfolio Categories', 'delicious' ),
				'all_items' => __( 'All Portfolio Categories', 'delicious' ),
				'parent_item' => __( 'Parent Portfolio Category', 'delicious' ),
				'parent_item_colon' => __( 'Parent Portfolio Category:', 'delicious' ),
				'edit_item' => __( 'Edit Portfolio Category', 'delicious' ),
				'update_item' => __( 'Update Portfolio Category', 'delicious' ),
				'add_new_item' => __( 'Add New Portfolio Category', 'delicious' ),
				'new_item_name' => __( 'New Portfolio Category Name', 'delicious' ),
				'choose_from_most_used'	=> __( 'Choose from the most used portfolio categories', 'delicious' )
			),
			'hierarchical' => true,
			'query_var' => true,
			'rewrite' => array( 'slug' => 'portfolio-category' )
		);

		// Register taxonomy: name, cpt, arguments
		register_taxonomy('portfolio_cats', array('portfolio'), $taxonomies['taxonomy-portfolio_cats']);
	}


	// Link taxonomy to cpt
	public function delicious_link_to_cpt() {
	    register_taxonomy_for_object_type('portfolio_cats', 'portfolio');
	}	

}

function delicious_types() { new DT_Post_Types(); }

add_action( 'init', 'delicious_types' );




	// Remove Tags Meta Boxes from Project Pages
	if (is_admin()) :
		function delicious_remove_meta_boxes() {
				remove_meta_box('tagsdiv-portfolio_cats', 'portfolio', 'side');
		}
	add_action( 'admin_menu', 'delicious_remove_meta_boxes' );
	endif;

	// Get Portfolio category ID
	function get_taxonomy_cat_ID( $cat_name='General' ) {
		$cat = get_term_by( 'name', $cat_name, 'portfolio_cats' );
		if ( $cat )
			return $cat->term_id;
		return 0;
	}



/*-----------------------------------------------------------------------------------*/
/*	Create Custom Boxes for Custom Post Types
/*-----------------------------------------------------------------------------------*/

function delicious_services_meta_boxes(){
	add_meta_box('services', __('Service Item ID!', 'delicious'), 'delicious_services_metabox', 'services', 'side', 'core');
}

function delicious_member_meta_boxes(){
	add_meta_box('team', __('Team Member ID!', 'delicious'), 'delicious_member_metabox', 'team', 'side', 'core');
}

function delicious_testimonial_meta_boxes(){
	add_meta_box('testimonials', __('Testimonial ID!', 'delicious'), 'delicious_testimonial_metabox', 'testimonials', 'side', 'core');
}

add_action( 'add_meta_boxes', 'delicious_services_meta_boxes' );
add_action( 'add_meta_boxes', 'delicious_member_meta_boxes' );
add_action( 'add_meta_boxes', 'delicious_testimonial_meta_boxes' );



/*-----------------------------------------------------------------------------------*/
/*	Create Custom Spaces for Custom Post Types on admin pages
/*-----------------------------------------------------------------------------------*/

function delicious_services_metabox($post, $metabox){
	?>
		<code>[dt-service id=<?php print $post->ID ?>]</code>
		<small class="description"><?php _e('Get the shortcode code to display the service item on another page!', 'delicious') ?></small>
	<?php
}

function delicious_member_metabox($post, $metabox){
	?>
		<code>[dt-team-member id=<?php print $post->ID ?>]</code>
		<small class="description"><?php _e('Get the shortcode code to display the team member on another page!', 'delicious') ?></small>
	<?php
}

function delicious_testimonial_metabox($post, $metabox){
	?>
		<code>[dt-testimonial id=<?php print $post->ID ?>]</code>
		<small class="description"><?php _e('Get the shortcode code to display the testimonial on another page!', 'delicious') ?></small>
	<?php
}


//modify Services admin page structure
add_filter( 'manage_edit-services_columns', 'delicious_edit_services_columns' ) ;

function delicious_edit_services_columns( $columns ) {

	$columns = array(
		'cb' => '<input type="checkbox" />',
		'title' => __( 'Services', 'delicious' ),
		'shortcode' => __( 'Embed Code', 'delicious' ),
		'date' => __( 'Date', 'delicious' )
	);

	return $columns;
}


add_action( 'manage_services_posts_custom_column', 'delicious_manage_services_columns', 10, 2 );

function delicious_manage_services_columns( $column, $post_id ) {
	global $post;

	switch( $column ) {
		case 'shortcode' :
			echo "<input type=text readonly=readonly value='[dt-service id={$post->ID}]' size=35 style='font-weight:bold;text-align:Center;' onclick='this.select()' />";
			break;

		default :
			break;
	}
}


//modify Team admin page structure
add_filter( 'manage_edit-team_columns', 'delicious_edit_team_columns' ) ;

function delicious_edit_team_columns( $columns ) {

	$columns = array(
		'cb' => '<input type="checkbox" />',
		'title' => __( 'Team Members', 'delicious' ),
		'shortcode' => __( 'Embed Code', 'delicious' ),
		'date' => __( 'Date', 'delicious' )
	);

	return $columns;
}


add_action( 'manage_team_posts_custom_column', 'delicious_manage_team_columns', 10, 2 );

function delicious_manage_team_columns( $column, $post_id ) {
	global $post;

	switch( $column ) {
		case 'shortcode' :
			echo "<input type=text readonly=readonly value='[dt-team-member id={$post->ID}]' size=35 style='font-weight:bold;text-align:Center;' onclick='this.select()' />";
			break;

		default :
			break;
	}
}


//modify Testimonials admin page structure
add_filter( 'manage_edit-testimonials_columns', 'delicious_edit_testimonials_columns' ) ;

function delicious_edit_testimonials_columns( $columns ) {

	$columns = array(
		'cb' => '<input type="checkbox" />',
		'title' => __( 'testimonials', 'delicious' ),
		'shortcode' => __( 'Embed Code', 'delicious' ),
		'date' => __( 'Date', 'delicious' )
	);

	return $columns;
}


add_action( 'manage_testimonials_posts_custom_column', 'delicious_manage_testimonials_columns', 10, 2 );

function delicious_manage_testimonials_columns( $column, $post_id ) {
	global $post;

	switch( $column ) {
		case 'shortcode' :
			echo "<input type=text readonly=readonly value='[dt-testimonial id={$post->ID}]' size=35 style='font-weight:bold;text-align:Center;' onclick='this.select()' />";
			break;

		default :
			break;
	}
}


?>
