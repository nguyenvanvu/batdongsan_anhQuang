<?php

if (class_exists('WPBakeryVisualComposer')) {

$add_css_animation = array(
  "type" => "dropdown",
  "heading" => __("CSS Animation", "js_composer"),
  "param_name" => "css_animation",
  "admin_label" => true,
  "value" => array(__("No", "js_composer") => '', __("Top to bottom", "js_composer") => "top-to-bottom", __("Bottom to top", "js_composer") => "bottom-to-top", __("Left to right", "js_composer") => "left-to-right", __("Right to left", "js_composer") => "right-to-left", __("Appear from center", "js_composer") => "appear"),
  "description" => __("Select animation type if you want this element to be animated when it enters into the browsers viewport. Note: Works only in modern browsers.", "js_composer")
);


if(function_exists('vc_add_param')) {
   vc_add_param('vc_column_inner', $add_css_animation);
}

if (function_exists('vc_map')) {

// Custom Map
vc_map( array(
  "name" => __("Row", "js_composer"),
  "base" => "vc_row",
  "is_container" => true,
  "icon" => "icon-wpb-row",
  "show_settings_on_create" => true,
  'front_enqueue_js' => get_template_directory_uri().'/js/frontend-scripts.js',
  'admin_enqueue_js' => array(get_template_directory_uri().'/js/custom/custom-row-view.js'),
  "category" => __('Content', 'js_composer'),
  "description" => __('Place content elements inside the row', 'js_composer'),
  "params" => array(
    array(
      "type" => "textfield",
      "heading" => __("ID Name for Navigation", "js_composer"),
      "param_name" => "dt_id",
      "description" => __("If this row wraps the content of one of your sections, set an ID. You can then use it for navigation. Ex: work", "js_composer")
    ),   
     array(
      "type" => "attach_image",
      "heading" => __("Background Image", "js_composer"),
      "param_name" => "bg_image",
      "description" => __("Select backgound image for the row.", "js_composer")
    ),
    array(
      "type" => "dropdown",
      "heading" => __('Background Repeat', 'js_composer'),
      "param_name" => "dt_bg_repeat",
      "value" => array(
                      __("Repeat-Y", 'js_composer') => 'repeat-y',        
                      __("Repeat", 'js_composer') => 'repeat',
                      __('No Repeat', 'js_composer') => 'no-repeat',
                      __('Repeat-X', 'js_composer') => 'repeat-x'
                      )    
    ),
    array(
      "type" => "textfield",
      "heading" => __("Background Image Parallax Inertia", "js_composer"),
      "param_name" => "dt_parallax_inertia",
      "description" => __("Inertia - speed to move relative to vertical scroll. Example: 0.1 is one tenth the speed of scrolling, 2 is twice the speed of scrolling. Default: 0.4", "js_composer")
    ),     
    array(
      "type" => "textfield",
      "heading" => __('YouTube Video Background URL', 'js_composer'),
      "param_name" => "dt_youtube_url",
      "description" => __("You can set the section to run a YouTube Video on background. Make sure to add an ID in 'ID Name for Navigation' box above and a 'Background Image'. The background image will act as a cover, for devices which doesn`t play videos automatically(mobile devices).", "js_composer")
    ),    
    array(
      "type" => "dropdown",
      "heading" => __('YouTube Video Background Raster(dotted overlay)', 'js_composer'),
      "param_name" => "video_raster",
      "description" => __("You can add a black dotted overlay on the video.", "js_composer"),
      "value" => array(
                        __("No", 'js_composer') => '',
                        __("Yes", 'js_composer') => 'yes'
                      )      
    ),

    array(
      "type" => "colorpicker",
      "heading" => __('Background Color', 'js_composer'),
      "param_name" => "bg_color",
      "description" => __("You can set a color over the background image. You can make it more or less opaque, by using the next setting. Default: white ", "js_composer")
    ),
    array(
      "type" => "textfield",
      "heading" => __('Background Color Opacity', 'js_composer'),
      "param_name" => "dt_color_opacity",
      "description" => __("Set an opacity value for the color(values between 0-100). 0 means no color while 100 means solid color. Default: 70 ", "js_composer")
    ),    
    array(
      "type" => "dropdown",
      "heading" => __('Text Color Scheme', 'js_composer'),
      "param_name" => "dt_text_scheme",
      "description" => __("Pick a color scheme for the content text. 'Light Text' looks good on dark bg images while 'Dark Text' looks good on light images.", "js_composer"),
      "value" => array(
                        __("Dark Text", 'js_composer') => 'lighter-overlay',
                        __("Light Text", 'js_composer') => 'darker-overlay'
                      )      
    ),
    array(
      "type" => "textfield",
      "heading" => __("Padding Top", "js_composer"),
      "param_name" => "dt_padding_top",
      "description" => __("Enter a value and it will be used for padding-top(px). As an alternative, use the 'Space' element.", "js_composer")
    ),   
    array(
      "type" => "textfield",
      "heading" => __("Padding Bottom", "js_composer"),
      "param_name" => "dt_padding_bottom",
      "description" => __("Enter a value and it will be used for padding-bottom(px). As an alternative, use the 'Space' element.", "js_composer")
    ),        
    array(
      "type" => "dropdown",
      "heading" => __('Remove margin bottom?', 'js_composer'),
      "param_name" => "dt_no_mb",
      "description" => __("The row has a bottom margin of 20px. You can remove it.", "js_composer"),
      "value" => array(
                        
                        __("No thanks!", 'js_composer') => '',
                        __("Yes Please!", 'js_composer') => 'no-margin'
                      )      
    ),
    array(
      "type" => "textfield",
      "heading" => __("Extra class name", "js_composer"),
      "param_name" => "dt_class",
      "description" => __("If you wish to style particular content element differently, then use this field to add a class name and then refer to it in your css file.", "js_composer")
    ),
    array(
      "type" => "dropdown",
      "heading" => __('Type', 'js_composer'),
      "param_name" => "dt_row_type",
      "description" => __("You can specify whether the row is displayed fullwidth or in container.", "js_composer"),
      "value" => array(
                        
                        __("Fullwidth", 'js_composer') => 'fullwidth',
                        __("In Container", 'js_composer') => 'in_container'
                      )      
    ),               
  ),
  "js_view" => 'VcRowViewCustom'
) );

vc_map( array(
   "name" => __("Space", "js_composer"),
   "icon" => get_template_directory_uri().'/images/composer/splitter_horizontal.png',
   "base" => "dt-space",
   "weight" => 21,
   "description" => "Add space between elements",
   "class" => "space_extended",
   "category" => __("Built for Patti", "js_composer"),
   "params" => array( 
      array(
         "type" => "textfield",
         "admin_label" => true,
         "heading" => __("Height of the space(px)", "js_composer"),
         "param_name" => "height",
		    "value" => 60,
         "description" => __("Set height of the space. You can add white space between elements to separate them beautifully.", "js_composer")
      )
   )
) );


vc_map( array(
   "name" => __("Quote", "js_composer"),
   "weight" => 16,
   "base" => "dt-quote",
   "icon" => get_template_directory_uri().'/images/composer/lightbulb.png',
   "description" => "A dose of inspiration for visitors",
   "class" => "quote_extended",
   "category" => __("Built for Patti", "js_composer"),
   "params" => array( 
      array(
         "type" => "textarea",
         "class" => "",
         "admin_label" => true,
         "heading" => __("Quote text", "js_composer"),
         "param_name" => "text"
      ),
      array(
         "type" => "textfield",
         "class" => "",
         "heading" => __("Quote Author", "js_composer"),
         "param_name" => "author"
      )      
   )
) );



vc_map( array(
   "name" => __("Fun Fact", "js_composer"),
   "icon" => get_template_directory_uri().'/images/composer/numeric_stepper.png',
   "base" => "dt-funfact",
   "weight" => 15,
   "description" => "Values counting to a specified target",
   "class" => "fact_extended",
   "category" => __("Built for Patti", "js_composer"),
   "params" => array( 
      array(
         "type" => "textfield",
         "class" => "",
         "admin_label" => true,
         "heading" => __("Value", "js_composer"),
         "param_name" => "data_to",
         "description" => __("Enter the value of the funfact. Ex: 34", "js_composer"),
         ),
      array(
         "type" => "textfield",
         "heading" => __("Decimals of the Value Number", "js_composer"),
         "param_name" => "data_decimals",
         "value" => 0,
         "description" => __("If you want to display the number with decimals, just insert how many decimals the number should have. Also, make sure that your number was introduced with decimals. For example, setting decimals to 2 and a number to 45.27 will properly display the number.", "js_composer"),
         ),      
      array(
         "type" => "textfield",
         "class" => "",
         "admin_label" => true,
         "heading" => __("FunFact Text", "js_composer"),
         "param_name" => "funfact_text",
         "description" => __("Enter a text for the fact. Ex: 'Projects Completed'.", "js_composer"),
      ),      
      array(
         "type" => "textfield",
         "class" => "",
         "heading" => __("Speed", "js_composer"),
         "param_name" => "data_speed",
         "value" => 2000,
         "description" => __("Speed for the animation(milliseconds).", "js_composer"),
      ),
      array(
         "type" => "dropdown",
         "heading" => __("Add Left Border(optional)?", "js_composer"),
         "param_name" => "border_left",
         "value" => array(__("No, thanks!", "js_composer") => 0, __("Yes, please", "js_composer") => 1 ),
         "description" => __("You can add a left border to the fun fact.", "js_composer"),
      ),      
   )
) );



vc_map( array(
   "name" => __("Section Title", "js_composer"),
   "icon" => get_template_directory_uri().'/images/composer/text.png',
   "weight" => 21,
   "base" => "dt-section-title",
   "class" => "title_extended",
   "description" => "Set a title and subtitle with style",
   "category" => __("Built for Patti", "js_composer"),
   "params" => array( 
      array(
         "type" => "textfield",
         "class" => "",
         "admin_label" => true,
         "heading" => __("Section Title", "js_composer"),
         "param_name" => "title",
         "description" => "Define a title for the section"
      ),
      array(
         "type" => "textfield",
         "class" => "",
         "admin_label" => true,
         "heading" => __("Section Subtitle", "js_composer"),
         "param_name" => "subtitle",
         "description" => "Define a subtitle for the section(optional)"
      )      
   )
) );


$services_list = get_posts(array('post_type' => 'services', 'posts_per_page'=> -1, 'post_status' => 'publish'));

$services_array = array();
foreach($services_list as $service_item) {
   $services_array[$service_item->post_title] = $service_item->ID;
}

vc_map( array(
   "name" => __("Services Section", "js_composer"),
   "icon" => get_template_directory_uri().'/images/composer/wrench.png',
   "description" => "Show them what you got",
   "weight" => 16,
   "base" => "dt-services",
   "class" => "services_extended",
   "category" => __("Built for Patti", "js_composer"),
   "params" => array( 
      array(
         "type" => "checkbox",
         "heading" => __("Services", "js_composer"),
         "param_name" => "ids",
         "admin_label" => true,
         "value" => $services_array,
         "description" => __("Select which services you want to display on the page. For best user experience, select between 4 to 6 services.", "js_composer")    
      )      
   )
) );




$testimonials_list = get_posts(array('post_type' => 'testimonials', 'posts_per_page'=> -1, 'post_status' => 'publish'));

$testimonials_array = array();
foreach($testimonials_list as $testimonial_item) {
   $testimonials_array[$testimonial_item->post_title] = $testimonial_item->ID;
}

vc_map( array(
   "name" => __("Testimonials Slider", "js_composer"),
   "icon" => get_template_directory_uri().'/images/composer/comments.png',
   "description" => "Customer feedback",
   "weight" => 15,
   "base" => "dt-testimonials",
   "class" => "testimonials_extended",
   "category" => __("Built for Patti", "js_composer"),
   "params" => array( 
      array(
         "type" => "checkbox",
         "heading" => __("Testimonials from", "js_composer"),
         "param_name" => "ids",
         "admin_label" => true,
         "value" => $testimonials_array,
         "description" => __("Select which testimonials you want to display on a carousel.", "js_composer")    
      ),
      array(
         "type" => "textfield",
         "heading" => __("Slider Speed", "js_composer"),
         "param_name" => "speed",
         "description" => __("Define the speed of the slider in milliseconds. Default is set to false (no automatic sliding). To have a slider which automatically changes slides, use an integer value inside the textfield(ex: 5000).", "js_composer")
      )            
   )
) );



$teams_list = get_posts(array('post_type' => 'team', 'posts_per_page'=> -1, 'post_status' => 'publish'));

$teams_array = array();
foreach($teams_list as $team_item) {
   $teams_array[$team_item->post_title] = $team_item->ID;
}

vc_map( array(
   "name" => __("Team Slider", "js_composer"),
   "icon" => get_template_directory_uri().'/images/composer/users_3.png',
   "description" => "Team Members Slider Carousel",
   "weight" => 15,
   "base" => "dt-teams",
   'front_enqueue_js' => get_template_directory_uri().'/js/custom/custom-teams.js',
   "class" => "teams_extended",
   "category" => __("Built for Patti", "js_composer"),
   'front_enqueue_css' => get_template_directory_uri().'/css/owl.carousel.css',
   "params" => array( 
      array(
         "type" => "checkbox",
         "heading" => __("Team Members", "js_composer"),
         "param_name" => "ids",
         "admin_label" => true,
         "value" => $teams_array,
         "description" => __("Select which team members you want to display in the carousel.", "js_composer")    
      ),
      array(
        "type" => "dropdown",
        "heading" => __("Items in a Row", "js_composer"),
        "param_name" => "items",
        "admin_label" => true,
        "value" => array("2" => "2", "3" => "3", "4" => "4", "5" => "5"),
        "description" => __("Select how many items a row should have.", "js_composer")
      ),
      array(
         "type" => "textfield",
         "heading" => __("Slider Speed", "js_composer"),
         "param_name" => "speed",
         "description" => __("Define the speed of the slider in milliseconds. Default is set to false (no automatic sliding). To have a slider which automatically changes slides, use an integer value inside the textfield(ex: 5000).", "js_composer")
      )                   
   )
) );


// Social Block

vc_map( array(
   "name" => __("Social Block", "js_composer"),
   "icon" => get_template_directory_uri().'/images/composer/share.png',
   "base" => "dt-social-block",
   "description" => "Sharing on social networks widget",
   "weight" => 16,
   "class" => "social_extended",
   "category" => __("Built for Patti", "js_composer"),
   "params" => array( 
      array(
         "type" => "textfield",
         "class" => "",
         "heading" => __("Title before the social block (optional)", "js_composer"),
         "param_name" => "title",
         "description" => __("If you want to set a title for the social block, add it above. Something like 'Share this post' will work very well. Icons included in the social block: twitter, facebook, pinterest, google+, delicious and linkedin.", "js_composer")
      )
   )
) );


// Blog Post Grid

$blog_cats = get_terms('category', array('hide_empty' => false));
$cats_array = array();
foreach($blog_cats as $blog_cat) {
	$cats_array[$blog_cat->name] = $blog_cat->slug;
}

vc_map( array(
   "name" => __("Blog Grid", "js_composer"),
   "icon" => get_template_directory_uri().'/images/composer/newspaper_add.png',
   "base" => "dt-blog-grid",
   "weight" => 19,
   'front_enqueue_js' => get_template_directory_uri().'/js/custom/custom-isotope-blog.js',
   "description" => "Masonry layout for blog posts",
   "class" => "blog_grid_extended",
   "category" => __("Built for Patti", "js_composer"),
   "params" => array( 
      array(
         "type" => "textfield",
         "class" => "",
         "heading" => __("Number of Blog Posts to Display. Use '-1' to include all your items.", "js_composer"),
         "param_name" => "number",
         "value" => 10,
         "description" => __("Set how many blog items would you like to include in the grid. The grid is built using the masonry style.", "js_composer")
      ),
    array(
      "type" => "dropdown",
      "heading" => __("Grid Columns", "js_composer"),
      "param_name" => "columns",
      "admin_label" => true,
      "value" => array("1" => "1", "2" => "2", "3" => "3"),
      "description" => __("Select Blog grid columns.", "js_composer")
    ),
    array(
      "type" => "checkbox",
      "heading" => __("Select Categories", "js_composer"),
      "param_name" => "categories",
      "value" => $cats_array,
	  "description" => __("Select from which categories to display blog posts(mandatory).", "js_composer")	  
    )	
   )
) );


// Portfolio Grid

$portfolio_categs = get_terms('portfolio_cats', array('hide_empty' => false));
$portfolio_cats_array = array();
$dt_placebo = array('No Thanks!' => NULL);
$term_vals = array();
foreach($portfolio_categs as $portfolio_categ) {
  $term_vals[$portfolio_categ->name] = get_taxonomy_cat_ID($portfolio_categ->name);
	$portfolio_cats_array[$portfolio_categ->name] = $portfolio_categ->name;
}
$dt_initial_filter = $dt_placebo + $term_vals;

vc_map( array(
   "name" => __("Portfolio Grid", "js_composer"),
   "icon" => get_template_directory_uri().'/images/composer/folder_picture.png',
   "base" => "dt-portfolio-grid",
   "description" => "Masonry grid layout for portfolio items",
   "weight" => 20,
   'front_enqueue_js' => get_template_directory_uri().'/js/custom/custom-isotope-portfolio.js',
   "class" => "portfolio_grid_extended",
   "category" => __("Built for Patti", "js_composer"),
   "params" => array( 
      array(
         "type" => "textfield",
         "class" => "",
         "admin_label" => true,
         "heading" => __("Number of Items to Display", "js_composer"),
         "param_name" => "number",
         "value" => 10,
         "description" => __("Set how many portfolio items would you like to include in the grid. Use '-1' to include all your items.", "js_composer")
      ),
      array(
         "type" => "checkbox",
         "class" => "",
         "heading" =>  __("Portfolio Categories", "js_composer"),
         "param_name" => "categories",
         "value" => $portfolio_cats_array,
         "description" => __("Select from which categories to display projects(mandatory).", "js_composer")
      ),
      array(
         "type" => "textfield",
         "heading" => __("Keyword for All Projects Filter", "js_composer"),
         "param_name" => "allword",
         "value" => "All",
         "description" => __("You can replace the default 'All' keyword for the initial filter with another one. If you want to hide it, you can do it with this CSS code: .all-projects {  display: none !important; }", "js_composer")
      ),
      array(
         "type" => "dropdown",
         "heading" => __("'All' filter position.", "js_composer"),
         "param_name" => "allbam",
         "value" => array(__("At the beginning", "js_composer") => '', __("At the end", "js_composer") => 'on-the-end'),
         "description" => __("Set where the 'All' filter should be displayed: at the beginning or at the end of the filter list.", "js_composer")
      ),      
      array(
         "type" => "dropdown",
         "heading" => __("Set Another Initial Filter", "js_composer"),
         "param_name" => "initial_word",
         "value" => $dt_initial_filter,
         "description" => __("You can set the portfolio grid to display projects from a certain category, on the initial state. If you want to reorder the categories, use <a href='http://goo.gl/kCYZ0L'>this plugin</a>", "js_composer")
      )                 	  
   )
) );

// List styles

vc_map( array(
   "name" => __("List", "js_composer"),
   "icon" => get_template_directory_uri().'/images/composer/text_list_bullets.png',
   "description" => "List element with icon style",
   "base" => "dt-list",
   "weight" => 15,
   "class" => "list_extended",
   "category" => __("Built for Patti", "js_composer"),
   "params" => array(
      array(
         "type" => "textfield",
         "admin_label" => true,
         "class" => "",
         "heading" => __("Icon Name", "js_composer"),
         "param_name" => "icon",
         "value" => "check",
         "description" => __("Please set an icon for the custom list. The entire list of icons can be found at <a href='http://fortawesome.github.io/Font-Awesome/icons/' target='_blank'>FontAwesome project page</a>. For example, if an icon is named 'fa-angle-right', the value you have to add inside the field is 'angle-right'.", "js_composer")
      ),   
      array(
         "type" => "textarea_html",
         "class" => "",
		     "admin_label" => true,
         "heading" => __("List Rows", "js_composer"),
         "param_name" => "content",
         "value" => "<ul><li>Lorem ipsum</li><li>Consectetur adipisicing</li><li>Ullamco laboris</li><li>Quis nostrud exercitation</li>",
         "description" => __("Create your list using the WordPress default functionality.", "js_composer")
      )
   )
) );



// Clients
vc_map( array(
   "name" => __("Clients Slider", "js_composer"),
   "icon" => get_template_directory_uri().'/images/composer/tie.png',
   "base" => "dt-clients",
   "weight" => 14,
   "description" => "Slider for clients/partners logos",
   "class" => "clients_extended",
   "category" => __("Built for Patti", "js_composer"),
   "params" => array(   
      array(
         "type" => "attach_images",
         "class" => "",
		     "admin_label" => true,
         "heading" => __("Upload Images", "js_composer"),
         "param_name" => "images",
         "value" => "",
         "description" => __("Upload the images for your clients.", "js_composer")
      ),
      array(
         "type" => "exploded_textarea",
         "class" => "",
         "heading" => __("Clients Links", "js_composer"),
         "param_name" => "links",
         "value" => "",
         "description" => __("Enter links for each client here. Divide links with linebreaks (Enter).", "js_composer")
      ),
      array(
         "type" => "textfield",
         "heading" => __("Image size(Optional)", "js_composer"),
         "param_name" => "thumb_size",
         "description" => __("Enter image size. Example: thumbnail, medium, large, full. Alternatively enter image size in pixels: 200x100 (Width x Height). Leave empty to use 'thumbnail' size. Recommended: full", "js_composer")
      ),
      array(
        "type" => "dropdown",
        "heading" => __("Items in a Row", "js_composer"),
        "param_name" => "items",
        "admin_label" => true,
        "value" => array("2" => "2", "3" => "3", "4" => "4", "5" => "5", "6" => "6"),
        "description" => __("Select how many items a row should have.", "js_composer")
      ),
      array(
         "type" => "textfield",
         "heading" => __("Slider Speed", "js_composer"),
         "param_name" => "speed",
         "description" => __("Define the speed of the slider in milliseconds. Default is set to 5000 (5 seconds). To stop the slider, use 'false' inside the textfield.", "js_composer")
      )                             
   )
) );




// Progress Bar
vc_map( array(
   "name" => __("Progress Bar", "js_composer"),
   "base" => "dt-skillbar",
   "weight" => 16,
   "description" => "Display your skills with style",
   "icon" => get_template_directory_uri().'/images/composer/progressbar.png',
   "class" => "skillbar_extended",
   'front_enqueue_js' => get_template_directory_uri().'/js/waypoints.min.js',
   "category" => __("Built for Patti", "js_composer"),
   "params" => array(   

      array(
         "type" => "exploded_textarea",
         "class" => "",
         "admin_label" => true,
         "heading" => __("Graphic values", "js_composer"),
         "param_name" => "values",
         "value" => "90|Development",
         "description" => __("Input graph values here. Divide values with linebreaks (Enter). Example: 90|Development.", "js_composer")
      ),
      array(
         "type" => "textfield",
         "class" => "",
         "heading" => __("Units", "js_composer"),
         "param_name" => "units",
         "value" => "%",
         "description" => __("Enter measurement units (if needed) Eg. %, px, points, etc. Graph value and unit will be appended to the graph title.", "js_composer")
      ),           
   )
) );




// Portfolio Slider
vc_map( array(
   "name" => __("Project Image Slider", "js_composer"),
   "base" => "dt-portfolio-slider",
   "weight" => 18,
   "icon" => get_template_directory_uri().'/images/composer/photos.png',
   "description" => "Gallery with style",
   "class" => "project_slider_extended",
   "category" => __("Built for Patti", "js_composer"),
   "params" => array( 
      array(
         "type" => "attach_images",
         "class" => "",
         "admin_label" => true,
         "heading" => __("Upload Images", "js_composer"),
         "param_name" => "images",
         "value" => "",
         "description" => __("Upload your images for the slider.", "js_composer")
      ),
      array(
         "type" => "textfield",
         "heading" => __("Image size(Optional)", "js_composer"),
         "param_name" => "thumb_size",
         "description" => __("Enter image size. Example: thumbnail, medium, large, full. Alternatively enter image size in pixels: 200x100 (Width x Height). Leave empty to use 'thumbnail' size. Recommended: full", "js_composer")
      ),
      array(
         "type" => "textfield",
         "heading" => __("Slider Speed", "js_composer"),
         "param_name" => "speed",
         "description" => __("Define the speed of the slider in milliseconds. Default is set to 8000 (8 seconds). To stop the slider, use 'false' inside the textfield.", "js_composer")
      )            
   )
) );



// Buttons
vc_map( array(
   "name" => __("Patti Button", "js_composer"),
   "base" => "dt-button",
   "weight" => 10,
   "icon" => get_template_directory_uri().'/images/composer/button_default.png',
   "description" => "Eye catching button",
   "class" => "buttons_extended",
   "category" => __("Built for Patti", "js_composer"),
   "params" => array( 
      array(
         "type" => "textfield",
         "admin_label" => true,
         "heading" => __("Text on the button", "js_composer"),
         "param_name" => "text",
         "value" => "Button Text",
         "description" => __("Text on the button.", "js_composer")
      ),
      array(
         "type" => "textfield",
         "heading" => __("URL(Link)", "js_composer"),
         "param_name" => "url",
         "description" => __("Button Link.", "js_composer")
      ),
      array(
         "type" => "dropdown",
         "heading" => __("Color", "js_composer"),
         "admin_label" => true,
         "param_name" => "color",
         "value" => array(__("Orange", "js_composer") => 'orange', __("Yellow", "js_composer") => "yellow", __("Green", "js_composer") => "green", __("Blue", "js_composer") => "bleumarin", __("Rose", "js_composer") => "rose", __("Black", "js_composer") => "black", __("Red", "js_composer") => "red", __("Gray", "js_composer") => "gray"),
         "description" => __("Button color.", "js_composer")
      ),

      array(
         "type" => "dropdown",
         "heading" => __("Size", "js_composer"),
         "param_name" => "size",
         "value" => array(__("Regular", "js_composer") => '', __("Large", "js_composer") => "big"),
         "description" => __("Button Size.", "js_composer")
      ),
      array(
         "type" => "dropdown",
         "heading" => __("Style", "js_composer"),
         "param_name" => "style",
         "value" => array(__("Bold - Solid button", "js_composer") => '', __("Thin - Border only", "js_composer") => "alt"),
         "description" => __("Button Style.", "js_composer")
      ),
      array(
         "type" => "dropdown",
         "heading" => __("Target", "js_composer"),
         "param_name" => "target",
         "value" => array(__("Opens the link in the same window", "js_composer") => '', __("Opens the link in a new window", "js_composer") => "yes"),
         "description" => __("Set the target of the button.", "js_composer")
      ),      
      array(
         "type" => "textfield",
         "heading" => __("Icon", "js_composer"),
         "param_name" => "icon",
         "description" => __("You can use icons from FontAwesome for the button. Visit the <a href='http://fontawesome.io/icons/'>Icons List</a> and grab the name of the icon you want to display. Ex: fa-bolt", "js_composer")
      ),  
      array(
         "type" => "dropdown",
         "heading" => __("Icon Position", "js_composer"),
         "param_name" => "icon_right",
         "value" => array(__("Icon on left", "") => '', __("Icon on right", "js_composer") => "icon_right"),
         "description" => __("Display the icon on left or right side of button text.", "js_composer"),
         "dependency" => Array('element' => "icon", 'not_empty' => true)
      ),                              
   )
) );






// Text with Icon
vc_map( array(
   "name" => __("Text with Icon", "js_composer"),
   "base" => "dt-text-icon",
   "weight" => 12,
   "icon" => get_template_directory_uri().'/images/composer/text_with_icon.png',
   "description" => "Text block with eye-catching icon",
   "class" => "twi_extended",
   "category" => __("Built for Patti", "js_composer"),
   "params" => array( 
      array(
         "type" => "textfield",
         "admin_label" => true,
         "heading" => __("Title", "js_composer"),
         "param_name" => "title",
         "value" => "Awesome Title",
         "description" => __("Title of the widget.", "js_composer")
      ),
      array(
         "type" => "dropdown",
         "heading" => __("Title Style", "js_composer"),
         "param_name" => "tbold",
         "value" => array(__("Thin", "js_composer") => '', __("Bold", "js_composer") => "bold"),
         "description" => __("Pick a style for the widget title.", "js_composer")
      ),      
      array(
         "type" => "textarea_html",
         "heading" => __("Text", "js_composer"),
         "param_name" => "content",
         "value"  => "Sed ut perspiciatis unde omnis iste natus error sit voluptatem accusantium.",
         "description" => __("Widget text.", "js_composer")
      ),
      array(
         "type" => "dropdown",
         "heading" => __("Widget Alignment", "js_composer"),
         "param_name" => "align",
         "value" => array(__("Left", "js_composer") => 'left', __("Center", "js_composer") => "center", __("Right", "js_composer") => "right"),
         "description" => __("Set the alignment of the widget content.", "js_composer")
      ),
      array(
         "type" => "dropdown",
         "heading" => __("Media Type", "js_composer"),
         "param_name" => "media_type",
         "value" => array(__("Font Icon", "js_composer") => 'icon-type', __("Standard Image", "js_composer") => "img-type"),
         "description" => __("Pick the media type you want to use for the widget. Font Icon - use an icon from FontAwesome. Standard Image - upload an image(jpg, png, etc.)", "js_composer")
      ),
      array(
         "type" => "textfield",
         "heading" => __("Icon Name", "js_composer"),
         "param_name" => "dicon",
         "value" => "fa-camera",
         "dependency" => Array('element' => "media_type", 'value' => 'icon-type'),
         "description" => __("You can use icons from FontAwesome for the button. Visit the <a href='http://fontawesome.io/icons/'>Icons List</a> and grab the name of the icon you want to display. Ex: fa-bolt", "js_composer")
      ),

      array(
         "type" => "dropdown",
         "heading" => __("Icon Style", "js_composer"),
         "param_name" => "istyle",
         "value" => array(__("Bold", "js_composer") => 'bold', __("Thin", "js_composer") => "thin", __("Free", "js_composer") => "free"),
         "dependency" => Array('element' => "dicon", 'not_empty' => true),
         "description" => __("Pick a style for the icon.", "js_composer")
      ),      
      array(
         "type" => "attach_image",
         "heading" => __("Image", "js_composer"),
         "param_name" => "img",
         "dependency" => Array('element' => "media_type", 'value' => 'img-type'),
         "description" => __("Upload an image for the widget.", "js_composer")
      ),  
   )
) );





// Pricing Table

		$output = '';
		
		// setup the output of our shortcode
		$output .= '<br />';
		$output .= '[dt-pricing-table columns="4"]<br />';
		$output .= '[dt-pricing-column title="BASIC" price="19" currency="$" interval="month"]';
		$output .= '<ul>';
		$output .= '<li>24/7 Support</li>';
		$output .= '<li>Free 10GB Storage</li>';
		$output .= '<li>Documentation &amp; Tutorials</li>';
		$output .= '<li>Google Apps Sync</li>';
		$output .= '<li>Up to 10 Projects</li>';
		$output .= '<li>Free Facebook Page</li>';
		$output .= '<li>Up to 3 Users</li>';
		$output .= '</ul>';
		$output .= '[dt-signup][dt-button url="#"]Sign Up[/dt-button][/dt-signup]<br />';
		$output .= '[/dt-pricing-column]<br />';
		$output .= '[dt-pricing-column title="ADVANCED" featured="yes" price="29" currency="$" interval="month"]';
		$output .= '<ul>';
		$output .= '<li>24/7 Support</li>';
		$output .= '<li>Free 20GB Storage</li>';
		$output .= '<li>Documentation &amp; Tutorials</li>';
		$output .= '<li>Google Apps Sync</li>';
		$output .= '<li>Up to 20 Projects</li>';
		$output .= '<li>Free Facebook Page</li>';
		$output .= '<li>Up to 5 Users</li>';
		$output .= '</ul>';
		$output .= '[dt-signup][dt-button color="red" url="#"]Sign Up[/dt-button][/dt-signup]<br />';
		$output .= '[/dt-pricing-column]<br />';
		$output .= '[dt-pricing-column title="PROFESSIONAL" price="49" currency="$" interval="month"]';
		$output .= '<ul>';
		$output .= '<li>24/7 Support</li>';
		$output .= '<li>Free 50GB Storage</li>';
		$output .= '<li>Documentation &amp; Tutorials</li>';
		$output .= '<li>Google Apps Sync</li>';
		$output .= '<li>Up to 50 Projects</li>';
		$output .= '<li>Free Facebook Page</li>';
		$output .= '<li>Up to 10 Users</li>';
		$output .= '</ul>';
		$output .= '[dt-signup][dt-button url="#"]Sign Up[/dt-button][/dt-signup]<br />';
		$output .= '[/dt-pricing-column]<br />';
		$output .= '[dt-pricing-column title="ULTIMATE" price="99" currency="$" interval="month"]';
		$output .= '<ul>';
		$output .= '<li>24/7 Support</li>';
		$output .= '<li>Unlimited Storage</li>';
		$output .= '<li>Documentation &amp; Tutorials</li>';
		$output .= '<li>Google Apps Sync</li>';
		$output .= '<li>Unlimited Projects</li>';
		$output .= '<li>Free Facebook Page</li>';
		$output .= '<li>Unlimited Users</li>';
		$output .= '</ul>';
		$output .= '[dt-signup][dt-button url="#"]Sign Up[/dt-button][/dt-signup]<br />';
		$output .= '[/dt-pricing-column]<br />';
		$output .= '[/dt-pricing-table]<br />';
		$output .= '[dt-space]<br />';

vc_map( array(
   "name" => __("Pricing Table", "js_composer"),
   "icon" => get_template_directory_uri().'/images/composer/table_money.png',
   "description" => "Pricing table element",
   "base" => "dt-table_placebo",
   "weight" => 12,
   "class" => "pricing_extended",
   "category" => __("Built for Patti", "js_composer"),
   "params" => array(  
      array(
         "type" => "textarea_html",
         "holder" => "div",
         "class" => "",
         "heading" => __("Pricing Table Example", "js_composer"),
         "param_name" => "content",
         "value" => $output,
         "description" => __("This is an example of a pricing table with 4 columns. Edit it and make it your own.", "js_composer")
      )
   )
) );



// Patti Map element
vc_map( array(
   "name" => __("Google Map Widget", "js_composer"),
   "base" => "dt-google-map",
   "icon" => get_template_directory_uri().'/images/composer/map.png',
   "description" => "Google Map Toggle Button",
   'front_enqueue_js' => get_template_directory_uri().'/js/custom/custom-map.js',
   "weight" => 13,
   "class" => "gmap_extended",
   "category" => __("Built for Patti", "js_composer"),
   "params" => array( 
      array(
         "type" => "textfield",
         "class" => "",
          "admin_label" => true,
         "heading" => __("Button Text", "js_composer"),
         "param_name" => "button_text",
          "value" => 'Locate us on Map'
      ),
      array(
         "type" => "textfield",
         "class" => "",
          "admin_label" => true,
         "heading" => __("Location Latitude", "js_composer"),
         "param_name" => "latitude",
         "value" => '37.422117'
      ),
      array(
         "type" => "textfield",
         "class" => "",
          "admin_label" => true,
         "heading" => __("Location Longitude", "js_composer"),
         "param_name" => "longitude",
         "value" => '-122.084053'
      ),
      array(
         "type" => "textfield",
         "class" => "",
          "admin_label" => true,
         "heading" => __("Pin Title", "js_composer"),
         "param_name" => "pin_title",
         "value" => 'Company Headquarters'
      ),
      array(
         "type" => "textfield",
         "class" => "",
          "admin_label" => true,
         "heading" => __("Pin Description", "js_composer"),
         "param_name" => "pin_desc",
         "value" => 'Now that you visited our website, how about <br/> checking out our office too?',
         "description" => __("You can use html tags to split the content in lines.", "js_composer")
      )                         
   )
) );


// Twitter Feed Slider

vc_map( array(
   "name" => __("Twitter Feed Slider", "js_composer"),
   "base" => "dt-twitter-carousel",
   "description" => "Tweets element",
   "icon" => get_template_directory_uri().'/images/composer/comment_twitter.png',
   "class" => "twitter_feed_extended",
   "weight" => 15,
   "category" => __("Built for Patti", "js_composer"),
   "params" => array(
      array(
         "type" => "textfield",
         "heading" => __("Twitter Username", "js_composer"),
         "param_name" => "twitter_username",
         "admin_label" => true
      ),   
      array(
         "type" => "textfield",
         "heading" => __("Number of Tweets", "js_composer"),
         "param_name" => "twitter_postcount",
         "description" => __("How many tweets you want to display into the carousel. 3 should be enough.", "js_composer")
      ),
      array(
         "type" => "textfield",
         "heading" => __("Twitter API Key", "js_composer"),
         "param_name" => "twitter_consumer_key",
         "description" => __("Insert your Twitter API key.", "js_composer")
      ),    
      array(
         "type" => "textfield",
         "heading" => __("Twitter API Secret", "js_composer"),
         "param_name" => "twitter_consumer_secret",
         "description" => __("Insert your Twitter API Secret.", "js_composer")
      ), 
      array(
         "type" => "textfield",
         "heading" => __("Twitter Access Token", "js_composer"),
         "param_name" => "twitter_access_token",
         "description" => __("Insert your Twitter Access Token.", "js_composer")
      ), 
      array(
         "type" => "textfield",
         "heading" => __("Twitter Access Token Secret", "js_composer"),
         "param_name" => "twitter_access_token_secret",
         "description" => __("Insert your Twitter Access Token Secret.", "js_composer")
      )                    
   )
) );



}


if (function_exists('vc_map_update')) {

   $row_update = array (
     'weight' => 100
   );

   $rev_update = array (
     'weight' => 17
   );   
   $c_update = array (
     'weight' => 13
   );     

   $no_animation = array (
      'admin_label' => false
   );

   vc_map_update('vc_row', $row_update);
   vc_map_update('vc_column_text', $row_update);
   vc_map_update('vc_row', $row_update);
   vc_map_update('vc_column_text', $no_animation);

   
   vc_map_update('rev_slider_vc', $rev_update);
   vc_map_update('contact-form-7', $c_update);


$param = WPBMap::getParam('vc_column_text', 'css_animation');
$param['admin_label'] = false;
WPBMap::mutateParam('vc_column_text', $param);


$param2 = WPBMap::getParam('vc_message', 'css_animation');
$param['admin_label'] = false;
WPBMap::mutateParam('vc_message', $param);


}

if (function_exists('vc_remove_element')) {
  vc_remove_element("vc_teaser_grid");
  vc_remove_element("vc_posts_slider");
  vc_remove_element("vc_images_carousel");
  vc_remove_element("vc_progress_bar");
  vc_remove_element("vc_carousel");
  // since vc 4.4
  vc_remove_element("vc_media_grid");
  vc_remove_element("vc_masonry_grid");
  vc_remove_element("vc_masonry_media_grid");
  // vc_remove_element("vc_button");
}

if (function_exists('vc_remove_param')) {
   vc_remove_param('vc_column_text', 'css_animation'); 
   vc_remove_param('vc_message', 'css_animation'); 
   vc_remove_param('vc_toggle', 'css_animation'); 
   vc_remove_param('vc_single_image', 'css_animation'); 

}
 

}


?>