<?php

/**
  ReduxFramework Sample Config File
  For full documentation, please visit: https://docs.reduxframework.com
 * */

if (!class_exists('Redux_Framework_sample_config')) {

    class Redux_Framework_sample_config {

        public $args        = array();
        public $sections    = array();
        public $theme;
        public $ReduxFramework;

        public function __construct() {

            if (!class_exists('ReduxFramework')) {
                return;
            }             

            $this->initSettings();

        }

        public function initSettings() {       

            // Just for demo purposes. Not needed per say.
            $this->theme = wp_get_theme();

            // Set the default arguments
            $this->setArguments();


            // Create the sections and fields
            $this->setSections();

            if (!isset($this->args['opt_name'])) { // No errors please
                return;
            }

            // If Redux is running as a plugin, this will remove the demo notice and links
            //add_action( 'redux/loaded', array( $this, 'remove_demo' ) );
            
            // Function to test the compiler hook and demo CSS output.
            // Above 10 is a priority, but 2 in necessary to include the dynamically generated CSS to be sent to the function.
            //add_filter('redux/options/'.$this->args['opt_name'].'/compiler', array( $this, 'compiler_action' ), 10, 2);
            
            // Change the arguments after they've been declared, but before the panel is created
            //add_filter('redux/options/'.$this->args['opt_name'].'/args', array( $this, 'change_arguments' ) );
            
            // Change the default value of a field after it's been set, but before it's been useds
            //add_filter('redux/options/'.$this->args['opt_name'].'/defaults', array( $this,'change_defaults' ) );
            
            // Dynamically add a section. Can be also used to modify sections/fields
            // add_filter('redux/options/' . $this->args['opt_name'] . '/sections', array($this, 'dynamic_section'));

            $this->ReduxFramework = new ReduxFramework($this->sections, $this->args);
        }

        /**

          This is a test function that will let you see when the compiler hook occurs.
          It only runs if a field	set with compiler=>true is changed.

         * */
        function compiler_action($options, $css) {
            //echo '<h1>The compiler hook has run!';
            //print_r($options); //Option values
            //print_r($css); // Compiler selector CSS values  compiler => array( CSS SELECTORS )

            /*
              // Demo of how to use the dynamic CSS and write your own static CSS file
              $filename = dirname(__FILE__) . '/style' . '.css';
              global $wp_filesystem;
              if( empty( $wp_filesystem ) ) {
                require_once( ABSPATH .'/wp-admin/includes/file.php' );
              WP_Filesystem();
              }

              if( $wp_filesystem ) {
                $wp_filesystem->put_contents(
                    $filename,
                    $css,
                    FS_CHMOD_FILE // predefined mode settings for WP files
                );
              }
             */
        }

        /**

          Custom function for filtering the sections array. Good for child themes to override or add to the sections.
          Simply include this function in the child themes functions.php file.

          NOTE: the defined constants for URLs, and directories will NOT be available at this point in a child theme,
          so you must use get_template_directory_uri() if you want to use any of the built in icons

         * */
        function dynamic_section($sections) {
            //$sections = array();
            $sections[] = array(
                'title' => __('Section via hook', 'redux-framework-demo'),
                'desc' => __('<p class="description">This is a section created by adding a filter to the sections array. Can be used by child themes to add/remove sections from the options.</p>', 'redux-framework-demo'),
                'icon' => 'el-icon-paper-clip',
                // Leave this as a blank section, no options just some intro text set above.
                'fields' => array()
            );

            return $sections;
        }

        /**

          Filter hook for filtering the args. Good for child themes to override or add to the args array. Can also be used in other functions.

         * */
        function change_arguments($args) {
            //$args['dev_mode'] = true;

            return $args;
        }

        /**

          Filter hook for filtering the default value of any given field. Very useful in development mode.

         * */
        function change_defaults($defaults) {
            $defaults['str_replace'] = 'Testing filter hook!';

            return $defaults;
        }

        public function setSections() {                


            $this->sections[] = array(
                'icon'      => 'el-icon-wrench',
                'customizer'=> false,
                'title'     => __('General', 'redux-framework-demo'),
                'fields'    => array(

                    array(
                        'id'        => 'opt-info-field',
                        'type'      => 'info',
                        'title'  => __('Welcome to Patti Options Panel.', 'redux-framework-demo'),
                        'desc'      => __('It is meant to make your life easier by offering you options which will customize your website(upload custom logo and favicon, choose a color scheme, set up footer social icons, etc.).', 'redux-framework-demo')
                    ),

                    array(
                        'id'        => 'responsive_enabled',
                        'type'      => 'switch',
                        'title'     => __('Responsive Layout', 'redux-framework-demo'),
                        'subtitle'  => __('Activate the responsive layout. If enabled, the website will change its shape for mobile devices.', 'redux-framework-demo'),
                        'default'   => 1,
                        'on'        => 'On',
                        'off'       => 'Off',
                    ),  
                   array(
                        'id'        => 'section-media-start',
                        'type'      => 'section',
                        'indent'    => true, // Indent all options below until the next 'section' option is set.
                        'required'  => array('responsive_enabled', '=', '1'),
                    ),
                    array(
                        'id'        => 'layout_type',
                        'type'      => 'button_set',
                        
                        'title'     => __('Responsive Layout Type', 'redux-framework-demo'),
                        'subtitle'  => __('Set the layout type of the responsive state: based on CSS Media Queries or based on a Fluid Grid. You can test the modes by resizing your browser window.', 'redux-framework-demo'),
                        
                        //Must provide key => value pairs for radio options
                        'options'   => array(
                            '1' => 'Media Queries', 
                            '2' => 'Fluid Grid'
                        ), 
                        'default'   => '1'
                    ),     
                    array(
                        'id'        => 'section-media-end',
                        'type'      => 'section',
                        'indent'    => false, // Indent all options below until the next 'section' option is set.
                        'required'  => array('section-media-checkbox', "=", 1),
                    ),
                               
                    array(
                        'id'        => 'lazyload',
                        'type'      => 'switch',
                        'title'     => __('LazyLoad Images', 'redux-framework-demo'),
                        'subtitle'  => __('Enable/Disable lazyLoad for images. This will speed up the loading time of the website.', 'redux-framework-demo'),
                        'hint'      => array(
                            //'title'     => '',
                            'content'   => 'Lazy Load means that the images will be loaded only after they enter the screen(when visitors scrolls down to them) and not immediately after the page loads, making the website load faster. Images outside of viewport are not loaded until user scrolls to them.',
                        ),                        
                        'default'   => 1,
                        'on'        => 'On',
                        'off'       => 'Off',
                    ),                                  

                    array(
                        'id'        => 'custom_favicon',
                        'type'      => 'media',
                        'url'       => true,
                        'title'     => __('Favicon', 'redux-framework-demo'),
                        'subtitle'  => __('Upload a 16px x 16px Png/Gif image that will represent your website`s favicon.', 'redux-framework-demo')                   
                    ),                    

                    array(
                        'id'        => 'custom_logo',
                        'type'      => 'media',
                        'url'       => true,
                        'title'     => __('Main Logo', 'redux-framework-demo'),
                        //'mode'      => false, // Can be set to false to allow any media type, or can also be set to any mime type.
                        'subtitle'  => __('Upload an image that will represent your website`s logo.', 'redux-framework-demo'),
                        'default'   => array('url' => 'http://demo.deliciousthemes.com/patti/wp-content/themes/patti-demo/images/logo.png')                
                    ),

                    array(
                        'id'        => 'alternativelogo_enabled',
                        'type'      => 'switch',
                        'title'     => __('Alternative Logo', 'redux-framework-demo'),
                        'subtitle'  => __('You can choose to display an alternative logo for the scrolling state of the header(when header is scrolled down). Make sure to have the Scrolling Effect enabled in the Theme Options->Header section.', 'redux-framework-demo'),
                        'default'   => 0,
                        'on'        => 'Yes',
                        'off'       => 'No',
                    ),  
                   array(
                        'id'        => 'section-alternativelogo-start',
                        'type'      => 'section',
                        'indent'    => true, // Indent all options below until the next 'section' option is set.
                        'required'  => array('alternativelogo_enabled', '=', '1'),
                    ),

                    array(
                        'id'        => 'alternative_logo',
                        'type'      => 'media',
                        'url'       => true,
                        'title'     => __('Upload Alternative Logo', 'redux-framework-demo'),
                        //'mode'      => false, // Can be set to false to allow any media type, or can also be set to any mime type.
                        'subtitle'  => __('You can upload an alternative logo for the scrolling state of the header.', 'redux-framework-demo'),
                        'default'   => ''                
                    ),  

                    array(
                        'id'        => 'section-alternativelogo-end',
                        'type'      => 'section',
                        'indent'    => false, // Indent all options below until the next 'section' option is set.
                        'required'  => array('section-alternativelogo-checkbox', "=", 1),
                    ),                                      

                    array(
                        'id'        => 'margin_logo',
                        'type'      => 'text',
                        'title'     => __('Margin-Top Value for Header`s Logo', 'redux-framework-demo'),
                        'subtitle'  => __('You can adjust the logo position in header by setting a top-margin to it. You can use negative values as well. For example, if you enter 10, the logo will be lowered by 10px. ', 'redux-framework-demo'),
                        'desc'      => __('Use numbers only', 'redux-framework-demo'),
                        'validate'  => 'numeric',
                        'default'   => '0'
                    ),      

                    array(
                        'id'        => 'copyright_textarea',
                        'type'      => 'editor',
                        'title'     => __('Footer Text', 'redux-framework-demo'),
                        'subtitle'  => __('Place here your copyright line. For ex: Copyright 2014 | My website.', 'redux-framework-demo'),
                        'default'   => 'Copyright 2014 - Patti.All Rights Reserved',
                    ),   

                    array(
                        'id'        => 'footer_layout',
                        'type'      => 'button_set',
                        'title'     => __('Footer Layout', 'redux-framework-demo'),
                        'subtitle'  => __('Set the look of the footer: content on right-left sides, or content centered.', 'redux-framework-demo'),
                        
                        //Must provide key => value pairs for radio options
                        'options'   => array(
                            '1' => 'Content on Sides', 
                            '2' => 'Content Centered'
                        ), 
                        'default'   => '1'
                    ),

                    array(
                        'id'        => 'analytics_enabled',
                        'type'      => 'switch',
                        'title'     => __('Google Analytics Tracking Code', 'redux-framework-demo'),
                        'subtitle'  => __('Enable/Disable Google Analytics for your website. If you enable it, just add your Google Analytics Property ID into the textfield to track your site`s activity.', 'redux-framework-demo'),
                        'default'   => 0,
                        'on'        => 'Enabled',
                        'off'       => 'Disabled'
                    ),
                    array(
                        'id'        => 'ga_id',
                        'type'      => 'text',
                        'required'  => array('analytics_enabled', '=', '1'),
                        'title'     => __('Google Analytics Property ID', 'redux-framework-demo'),
                        'subtitle'  => __('Place here Google Analytics Propery ID. It should look like `UA-XXXXX-X` and you should find it inside your Google Analytics Dashboard.', 'redux-framework-demo')
                    ),

                    array(
                        'id'        => 'parallax_enabled',
                        'type'      => 'switch',
                        'title'     => __('Parallax Effect', 'redux-framework-demo'),
                        'subtitle'  => __('Enable/Disable the section background`s Parallax effect. If disabled, the options available in the page builder for the parallax effect will be ignored.', 'redux-framework-demo'),
                        'default'   => 1,
                        'on'        => 'Enabled',
                        'off'       => 'Disabled'
                    ),    

                    array(
                        'id'        => 'smoothscroll_enabled',
                        'type'      => 'switch',
                        'title'     => __('Smooth Scrolling Effect', 'redux-framework-demo'),
                        'subtitle'  => __('Enable/Disable the Smooth Scrolling effect for the website.', 'redux-framework-demo'),
                        'default'   => 1,
                        'on'        => 'Enabled',
                        'off'       => 'Disabled'
                    ),    

                    array(
                        'id'        => 'adminbar_enabled',
                        'type'      => 'switch',
                        'title'     => __('WordPress Admin Bar', 'redux-framework-demo'),
                        'subtitle'  => __('Enable/Disable the WordPress admin bar(the black top bar which appears on the website when you`re logged into WordPress).', 'redux-framework-demo'),
                        'default'   => 0,
                        'on'        => 'Enabled',
                        'off'       => 'Disabled'
                    ),                                                           

                )
            );

            $this->sections[] = array(
                'icon'      => 'el-icon-brush',
                'title'     => __('Styling', 'redux-framework-demo'),
                'fields'    => array(
                    array(
                        'id'        => 'scheme',
                        'type'      => 'select',
                        'title'     => __('Theme Stylesheet', 'redux-framework-demo'),
                        'subtitle'  => __('Select a predefined color scheme. They`re located in `/css/color-schemes/` theme folder', 'redux-framework-demo'),
                        'options'   => array('orange.css' => 'orange.css', 'red.css' => 'red.css', 'blue.css' => 'blue.css', 'green.css' => 'green.css', 'purple.css' => 'purple.css', 'yellow.css' => 'yellow.css'),
                        'default'   => 'orange.css',
                    ),
                    array(
                        'id'        => 'custom_color_scheme',
                        'type'      => 'color',
                        // 'output'    => array('.site-title'),
                        'title'     => __('Define a Custom Color Scheme', 'redux-framework-demo'),
                        'subtitle'  => __('You can define a new custom color for the scheme.', 'redux-framework-demo'),
                        'default'   => '',
                        'transparent' => false,
                        'validate'  => 'color',
                    ),
                    array(
                        'id'        => 'body_background',
                        'type'      => 'color',
                        // 'output'    => array('.site-title'),
                        'title'     => __('Body Background Color', 'redux-framework-demo'),
                        'subtitle'  => __('Leave blank or pick a color for the body. (default: #efefef).', 'redux-framework-demo'),
                        'default'   => '#efefef',
                        'transparent' => false,
                        'validate'  => 'color',
                    ),
                    array(
                        'id'        => 'wrapper_background',
                        'type'      => 'color',
                        // 'output'    => array('.site-title'),
                        'title'     => __('Content Wrapper Background Color', 'redux-framework-demo'),
                        'subtitle'  => __('Leave blank if you want to keep the default background color or pick a color for the content wrapper (default: #fff).', 'redux-framework-demo'),
                        'default'   => '#ffffff',
                        'transparent' => false,
                        'validate'  => 'color'
                    ),           
                    array(
                        'id'        => 'footer_background',
                        'type'      => 'color',
                        // 'output'    => array('.site-title'),
                        'title'     => __('Footer Background Color', 'redux-framework-demo'),
                        'subtitle'  => __('Leave blank if you want to keep the default background color or pick a color for the footer (default: #ffffff).', 'redux-framework-demo'),
                        'default'   => '#ffffff',
                        'transparent' => false,
                        'validate'  => 'color'
                    ),   
                    array(
                        'id'        => 'selected_text_background',
                        'type'      => 'color',
                        // 'output'    => array('.site-title'),
                        'title'     => __('Selected Text Background Color', 'redux-framework-demo'),
                        'subtitle'  => __('Leave blank if you want to keep the default background color or pick a color for the selected text (default: blue, set by the browser).', 'redux-framework-demo'),
                        'default'   => '',
                        'transparent' => false,
                        'validate'  => 'color'
                    ),                                                   

                    array(
                        'id'        => 'grayscale_effect',
                        'type'      => 'switch',
                        'title'     => __('Grayscale(Black & White) Effect', 'redux-framework-demo'),
                        'subtitle'  => __('You can enable/disable the grayscale effect for images.', 'redux-framework-demo'),
                        'default'   => 1,
                        'on'        => 'Enabled',
                        'off'       => 'Disabled'
                    ),

                    array(
                        'id'        => 'enable_preloader',
                        'type'      => 'switch',
                        'title'     => __('Enable/Disable Preloader', 'redux-framework-demo'),
                        'subtitle'  => __('You can enable/disable the website`s spinning wheel preloader.', 'redux-framework-demo'),
                        'default'   => 1,
                        'on'        => 'Enabled',
                        'off'       => 'Disabled'
                    ), 

                    array(
                        'id'        => 'pattern',
                        'type'      => 'image_select',
                        'title'     => __('Patterns for Background', 'redux-framework-demo'),
                        'subtitle'  => __('Select a pattern and set it as background. Choose between these patterns. More to come...', 'redux-framework-demo'),
                        'options'   => array(
                            'bg12' => array('alt' => '',  'img' => ReduxFramework::$_url . 'assets/img/bg12.png'),
                            'bg1' => array('alt' => '',  'img' => ReduxFramework::$_url . 'assets/img/bg1.png'),
                            'bg2' => array('alt' => '',  'img' => ReduxFramework::$_url . 'assets/img/bg2.png'),
                            'bg3' => array('alt' => '',  'img' => ReduxFramework::$_url . 'assets/img/bg3.png'),
                            'bg4' => array('alt' => '',  'img' => ReduxFramework::$_url . 'assets/img/bg4.png'),
                            'bg5' => array('alt' => '',  'img' => ReduxFramework::$_url . 'assets/img/bg5.png'),
                            'bg6' => array('alt' => '',  'img' => ReduxFramework::$_url . 'assets/img/bg6.png'),
                            'bg7' => array('alt' => '',  'img' => ReduxFramework::$_url . 'assets/img/bg7.png'),
                            'bg8' => array('alt' => '',  'img' => ReduxFramework::$_url . 'assets/img/bg8.png'),
                            'bg9' => array('alt' => '',  'img' => ReduxFramework::$_url . 'assets/img/bg9.png'),
                            'bg10' => array('alt' => '',  'img' => ReduxFramework::$_url . 'assets/img/bg10.png'),
                            'bg11' => array('alt' => '',  'img' => ReduxFramework::$_url . 'assets/img/bg11.png'),
                            'bg14' => array('alt' => '',  'img' => ReduxFramework::$_url . 'assets/img/bg14.png'),
                            'bg15' => array('alt' => '',  'img' => ReduxFramework::$_url . 'assets/img/bg15.png'),
                            'bg16' => array('alt' => '',  'img' => ReduxFramework::$_url . 'assets/img/bg16.png'),
                            'bg17' => array('alt' => '',  'img' => ReduxFramework::$_url . 'assets/img/bg17.png'),
                            'bg18' => array('alt' => '',  'img' => ReduxFramework::$_url . 'assets/img/bg18.png'),
                            'bg19' => array('alt' => '',  'img' => ReduxFramework::$_url . 'assets/img/bg19.png')
                        ),
                        'default'   => 'bg12'
                    ),                                                        
    
                    array(
                        'id'        => 'more_css',
                        'type'      => 'textarea',
                        'title'     => __('Custom CSS', 'redux-framework-demo'),
                        'subtitle'  => __('Quickly add some CSS to your theme by adding it to this block.', 'redux-framework-demo'),
                        'validate'  => 'css',
                    ),

                    array(
                        'id'        => 'js_editor',
                        'type'      => 'ace_editor',
                        'title'     => __('Custom JS', 'redux-framework-demo'),
                        'subtitle'  => __('Paste your JavaScript code here. Use this field to quickly add JS code snippets.', 'redux-framework-demo'),
                        'mode'      => 'javascript',
                        'theme'     => 'chrome',
                        'default'   => ""
                    ),                    

                )
            );

            $this->sections[] = array(
                'icon'      => 'el-icon-filter',
                'title'     => __('Typography', 'redux-framework-demo'),
                'fields'    => array(

                    array(
                        'id'        => 'typo_info',
                        'type'      => 'info',
                        'title'  => __('Typography Options', 'redux-framework-demo'),
                        'desc'      => __('The theme is using Google Fonts to render the typography style for your website. You can however, make use of default fonts.).', 'redux-framework-demo')
                    ),                    

                    array(
                        'id'        => 'body_font_typo',
                        'type'      => 'typography',
                        'output'    => array('html body'),
                        'title'     => __('Body Font Options', 'redux-framework-demo'),
                        'subtitle'  => __('Select font options for the body', 'redux-framework-demo'),
                        'google'    => true,
                        'text-align'=> false,
                        'subsets'   => true,
                        'font-weight' => false,
                        'default'   => array(
                            'google'      => true,
                            'color'         => '#686868',
                            'font-size'     => '15px',
                            'font-family'   => 'Open Sans',
                            'line-height'   => '24px',
                            'font-weight'   => '300',
                        ),
                    ),

                    array(
                        'id'        => 'menu_typo',
                        'type'      => 'typography',
                        'output'    => array('html ul#mainnav li a'),
                        'title'     => __('Menu Font Options', 'redux-framework-demo'),
                        'subtitle'  => __('Select font options for the main menu.', 'redux-framework-demo'),
                        'google'    => true,
                        'text-align'=> false,
                        'subsets'   => true,
                        'font-weight' => false,
                        'default'   => array(
                            'google'      => true,
                            'color'         => '#404040',
                            'font-size'     => '14px',
                            'font-family'   => 'Open Sans',
                            'line-height'   => '25px',
                            'font-weight'   => '700',
                        ),
                    ),

                    array(
                        'id'        => 'h1_typo',
                        'type'      => 'typography',
                        'output'    => array('html h1'),
                        'title'     => __('H1 Font Options', 'redux-framework-demo'),
                        'subtitle'  => __('Select font options for Heading 1.', 'redux-framework-demo'),
                        'google'    => true,
                        'text-align'=> false,
                        'subsets'   => true,
                        'font-weight' => false,
                        'default'   => array(
                            'google'      => true,
                            'color'         => '#444444',
                            'font-size'     => '28px',
                            'font-family'   => 'Open Sans',
                            'line-height'   => '36px',
                            'font-weight'   => '300',
                        ),
                    ),  

                    array(
                        'id'        => 'h2_typo',
                        'type'      => 'typography',
                        'output'    => array('html h2'),
                        'title'     => __('H2 Font Options', 'redux-framework-demo'),
                        'subtitle'  => __('Select font options for Heading 2.', 'redux-framework-demo'),
                        'google'    => true,
                        'text-align'=> false,
                        'subsets'   => true,
                        'font-weight' => false,
                        'default'   => array(
                            'google'      => true,
                            'color'         => '#444444',
                            'font-size'     => '24px',
                            'font-family'   => 'Open Sans',
                            'line-height'   => '32px',
                            'font-weight'   => '300',
                        ),
                    ),  

                    array(
                        'id'        => 'h3_typo',
                        'type'      => 'typography',
                        'output'    => array('html h3'),
                        'title'     => __('H3 Font Options', 'redux-framework-demo'),
                        'subtitle'  => __('Select font options for Heading 3.', 'redux-framework-demo'),
                        'google'    => true,
                        'text-align'=> false,
                        'subsets'   => true,
                        'font-weight' => false,
                        'default'   => array(
                            'google'      => true,
                            'color'         => '#444444',
                            'font-size'     => '18px',
                            'font-family'   => 'Open Sans',
                            'line-height'   => '24px',
                            'font-weight'   => '300',
                        ),
                    ),  

                    array(
                        'id'        => 'h4_typo',
                        'type'      => 'typography',
                        'output'    => array('html h4'),
                        'title'     => __('H4 Font Options', 'redux-framework-demo'),
                        'subtitle'  => __('Select font options for Heading 4.', 'redux-framework-demo'),
                        'google'    => true,
                        'text-align'=> false,
                        'subsets'   => true,
                        'font-weight' => false,
                        'default'   => array(
                            'google'      => true,
                            'color'         => '#444444',
                            'font-size'     => '16px',
                            'font-family'   => 'Open Sans',
                            'line-height'   => '22px',
                            'font-weight'   => '300',
                        ),
                    ),      

                    array(
                        'id'        => 'h5_typo',
                        'type'      => 'typography',
                        'output'    => array('html h5'),
                        'title'     => __('H5 Font Options', 'redux-framework-demo'),
                        'subtitle'  => __('Select font options for Heading 5.', 'redux-framework-demo'),
                        'google'    => true,
                        'text-align'=> false,
                        'subsets'   => true,
                        'font-weight' => false,
                        'default'   => array(
                            'google'      => true,
                            'color'         => '#444444',
                            'font-size'     => '14px',
                            'font-family'   => 'Open Sans',
                            'line-height'   => '20px',
                            'font-weight'   => '300',
                        ),
                    ),       

                    array(
                        'id'        => 'h6_typo',
                        'type'      => 'typography',
                        'output'    => array('html h6'),
                        'title'     => __('H6 Font Options', 'redux-framework-demo'),
                        'subtitle'  => __('Select font options for Heading 6.', 'redux-framework-demo'),
                        'google'    => true,
                        'text-align'=> false,
                        'subsets'   => true,
                        'font-weight' => false,
                        'default'   => array(
                            'google'      => true,
                            'color'         => '#444444',
                            'font-size'     => '13px',
                            'font-family'   => 'Open Sans',
                            'line-height'   => '20px',
                            'font-weight'   => '300',
                        ),
                    ),                                                                                                          

                )
            );



            /**
             *  Note here I used a 'heading' in the sections array construct
             *  This allows you to use a different title on your options page
             * instead of reusing the 'title' value.  This can be done on any
             * section - kp
             */
            $this->sections[] = array(
                'icon'      => 'el-icon-star-empty',
                'title'     => __('Header', 'redux-framework-demo'),
                'customizer'=> false,
                'desc'      => __('<p class="description">Set custom styles for the header</p>', 'redux-framework-demo'),
                'fields'    => array(

                    array(
                        'id'        => 'header_style',
                        'type'      => 'select',
                        'title'     => __('Header Style', 'redux-framework-demo'),
                        'subtitle'  => __('Select an appropriate style for the Header. This is the style for the initial header state, not scrolled.', 'redux-framework-demo'),
                        'options'   => array('solid-header' => 'Solid Header',  'transparent-header' => 'Transparent Header', 'tr-header' => 'Transparent Header - Style 2', 'no-header' => 'No Header'),
                        'default'   => 'solid-header',
                    ),

                    // array(
                    //     'id'        => 'section-transparent-start',
                    //     'type'      => 'section',
                    //     'required' => array('header_style','=','tr-header'),
                    //     'indent'    => true // Indent all options below until the next 'section' option is set.
                    // ),   

                    // array(
                    //     'id'        => 'tr_header_scheme',
                    //     'type'      => 'select',
                    //     'title'     => __('Header Mood Scheme for Initial Position', 'redux-framework-demo'),
                    //     'required' => array('header_style','=','tr-header'),
                    //     'subtitle'  => __('Select a scheme for the transparent header`s initial position. Dark or Light. This will mainly affect the navigation. Light header means black menu items while dark header means white menu items.', 'redux-framework-demo'),
                    //     'options'   => array('tr-light-header' => 'Light Header', 'tr-dark-header' => 'Dark Header'),
                    //     'default'   => 'tr-light-header',
                    // ),                                      

                    // array(
                    //     'id'        => 'transparent_custom_logo',
                    //     'type'      => 'media',
                    //     'url'       => true,
                    //     'required' => array('header_style','=','tr-header'),
                    //     'title'     => __('Logo for Initial Position', 'redux-framework-demo'),
                    //     'subtitle'  => __('If the navigation style for header`s initial position is set to light or dark, make sure to upload a logo which will fit the scheme.', 'redux-framework-demo'),
                    //     'default'   => array('url' => 'http://demo.deliciousthemes.com/patti/wp-content/themes/patti-demo/images/logo.png')                  
                    // ),      

                    // array(
                    //     'id'        => 'section-transparent-end',
                    //     'required' => array('header_style','=','tr-header'),
                    //     'type'      => 'section',
                    //     'indent'    => false // Indent all options below until the next 'section' option is set.
                    // ),                                  

                    array(
                        'id'        => 'header_scheme',
                        'type'      => 'select',
                        'title'     => __('Header Mood Scheme', 'redux-framework-demo'),
                        'subtitle'  => __('Select a scheme for the header. Dark or Light. This will mainly affect the navigation. Then pick a color from below.', 'redux-framework-demo'),
                        'options'   => array('light-header' => 'Light Header', 'dark-header' => 'Dark Header'),
                        'default'   => 'light-header',
                    ),    

                    array(
                        'id'        => 'header_background',
                        'type'      => 'color',
                        // 'output'    => array('.site-title'),
                        'title'     => __('Header Background Color', 'redux-framework-demo'),
                        'subtitle'  => __('Leave blank if you want to keep the default background color or pick a color for the header (default: #fff).', 'redux-framework-demo'),
                        'default'   => '#ffffff',
                        'transparent' => false,
                        'validate'  => 'color',
                    ),           

                    array(
                        'id'            => 'initial_header_padding',
                        'type'          => 'spacing',
                        'mode'          => 'padding',    // absolute, padding, margin, defaults to padding
                        'top'           => true,     // Disable the top
                        'right'         => false,     // Disable the right
                        'bottom'        => true,     // Disable the bottom
                        'left'          => false,     // Disable the left
                        'title'         => __('Padding-Top/Padding-Bottom values for header`s initial position', 'redux-framework-demo'),
                        'subtitle'      => __('Set new padding values for the header`s look on initial position.', 'redux-framework-demo'),
                        'desc'          => __('Values are defined in pixels. Default: 55 with 25', 'redux-framework-demo'),
                        'default'       => array(
                            'padding-top'    => '55', 
                            'padding-bottom' => '25', 
                        )
                    ),    

                    array(
                        'id'        => 'floating_header',
                        'type'      => 'switch',
                        'title'     => __('Enable/Disable Floating Header', 'redux-framework-demo'),
                        'subtitle'  => __('You can enable a floating top-bar header which will include your logo and menu. If disabled, the scrolling effect from below will be ignored.', 'redux-framework-demo'),
                        'default'   => 1,
                        'on'        => 'Enabled',
                        'off'       => 'Disabled'
                    ),                 

                    array(
                        'id'        => 'scrolling_effect',
                        'type'      => 'switch',
                        'title'     => __('Enable/Disable Scrolling Effect', 'redux-framework-demo'),
                        'subtitle'  => __('You can disable the scrolling effect of the header. If disabled, "Padding-Top/Padding-Bottom values for header`s on scroll position" will be ignored.', 'redux-framework-demo'),
                        'default'   => 1,
                        'on'        => 'Enabled',
                        'off'       => 'Disabled'
                    ),   

                    array(
                        'id'            => 'onscroll_header_padding',
                        'type'          => 'spacing',
                        'mode'          => 'padding',    // absolute, padding, margin, defaults to padding
                        'top'           => true,     // Disable the top
                        'right'         => false,     // Disable the right
                        'bottom'        => true,     // Disable the bottom
                        'left'          => false,     // Disable the left
                        'required'  => array('scrolling_effect', '=', '1'),
                        'title'         => __('Padding-Top/Padding-Bottom values for header`s on scroll position', 'redux-framework-demo'),
                        'subtitle'      => __('Set new padding values for the header`s look on scroll position.', 'redux-framework-demo'),
                        'desc'          => __('Values are defined in pixels. Default: 15 with 15', 'redux-framework-demo'),
                        'default'       => array(
                            'padding-top'    => '15', 
                            'padding-bottom' => '15', 
                        )
                    ),   


                    array(
                        'id'            => 'header_scroll_opacity',
                        'type'          => 'slider',
                        'title'         => __('Header Opacity on Scroll', 'redux-framework-demo'),
                        'subtitle'      => __('You can set the header opacity on scroll state.', 'redux-framework-demo'),
                        'default'       => 90,
                        'min'           => 0,
                        'step'          => 1,
                        'max'           => 100,
                        'display_value' => 'text'
                    ),  

                    array(
                        'id'        => 'search_header',
                        'type'      => 'switch',
                        'title'     => __('Enable/Disable Search Widget in Header', 'redux-framework-demo'),
                        'subtitle'  => __('You can enable a search icon widget in the header.', 'redux-framework-demo'),
                        'default'   => 0,
                        'on'        => 'Enabled',
                        'off'       => 'Disabled'
                    ),    

                    array(
                        'id'        => 'scrolloffset',
                        'type'      => 'text',
                        'title'     => __('Navigation ScrollOffset Value', 'redux-framework-demo'),
                        'subtitle'  => __('You can adjust the position at which the scrolling effect stops when a menu item is clicked. You can use it to set an offset value to the top of each section stop. For example, the 100 value will stop the navigation 100px above the section.', 'redux-framework-demo'),
                        'desc'      => __('Use numbers only', 'redux-framework-demo'),
                        'validate'  => 'numeric',
                        'default'   => '0'
                    ),                                                                                                                  

                )
            );


            $this->sections[] = array(
                'icon'      => 'el-icon-briefcase',
                'customizer'=> false,
                'title'     => __('Portfolio', 'redux-framework-demo'),
                'fields'    => array(
                    array(
                        'id'        => 'portfolio_back_link',
                        'type'      => 'text',
                        'title'     => __('Link URL for the portfolio `Back` button icon', 'redux-framework-demo'),
                        'subtitle'  => __('Add an URL for the portfolio Back button.', 'redux-framework-demo'),
                        'hint'      => array(
                            //'title'     => '',
                            'content'   => 'Default URL is set to homepage. Ex: http://website.com#work. The URL will be also used to highlight the menu item in the navigation.',
                        )                        
                    ),

                    array(
                        'id'        => 'portfolio_slug',
                        'type'      => 'text',
                        'default'   => 'portfolio',
                        'title'     => __('Portfolio Slug URL', 'redux-framework-demo'),
                        'subtitle'  => __('Change the default portfolio slug URL. ', 'redux-framework-demo'),
                        'hint'      => array(
                            //'title'     => '',
                            'content'   => 'Currently, this is set to <strong>portfolio</strong>. Ex: http://website.com/portfolio/project-name. Changing it to <strong>works</strong>, the URLs will become http://website.com/works/project-name. Once you`ll change it, you`ll get 404 error pages for projects. To fix this, refresh the permalinks: go to Settings->Permalinks and click on Default. Save. Then click on your custom URL structure and save again.',
                        )                        
                    ),                    

                    array(
                        'id'        => 'portfolio_author',
                        'type'      => 'switch',
                        'title'     => __('Author Bio on projects pages', 'redux-framework-demo'),
                        'subtitle'  => __('You can enable/disable the author bio of the project on the project page.', 'redux-framework-demo'),
                        'default'   => 0,
                        'on'        => 'On',
                        'off'       => 'Off'
                    ),                    

                    array(
                        'id'        => 'grid_layout_manager',
                        'type'      => 'switch',
                        'title'     => __('Portfolio Grid Layout Manager(Advanced)', 'redux-framework-demo'),
                        'subtitle'  => __('Enable/Disable the portfolio grid layout manager. To see how columns are displayed on the grid, check out this <a href="http://deliciousthemes.com/documentations/patti-wp-docs/patti-columns.png" target="_blank">portfolio grid image</a>', 'redux-framework-demo'),
                        'hint'      => array(
                            'content'   => 'You`ll be able to overwrite the current default column layouts with new values. Use it carefully! Manage the look of the grid for multiple screen sizes.',
                        ),                        
                        'default'   => 0,
                        'on'        => 'Enabled',
                        'off'       => 'Disabled'
                    ),                               
               
                    array(
                        'id'        => 'grid_column_very_wide',
                        'type'      => 'slider',
                        'required'  => array('grid_layout_manager', '=', '1'),
                        'title'     => __('Grid Columns for Screens > 1440px', 'redux-framework-demo'),
                        'subtitle'  => __('Set a number of columns for the grid, for screens wider than 1440px.', 'redux-framework-demo'),
                        'default'       => 7,
                        'min'           => 1,
                        'step'          => 1,
                        'max'           => 10,
                        'display_value' => 'text'
                    ),  
                    array(
                        'id'        => 'grid_column_wide',
                        'type'      => 'slider',
                        'required'  => array('grid_layout_manager', '=', '1'),
                        'title'     => __('Grid Columns for Screens > 1366px', 'redux-framework-demo'),
                        'subtitle'  => __('Set a number of columns for the grid, for screens between 1366px and 1440px in width.', 'redux-framework-demo'),
                        'default'       => 5,
                        'min'           => 1,
                        'step'          => 1,
                        'max'           => 10,
                        'display_value' => 'text'
                    ),  
                    array(
                        'id'        => 'grid_column_normal',
                        'type'      => 'slider',
                        'required'  => array('grid_layout_manager', '=', '1'),
                        'title'     => __('Grid Columns for Screens > 1280px', 'redux-framework-demo'),
                        'subtitle'  => __('Set a number of columns for the grid, for screens between 1280px and 1366px in width.', 'redux-framework-demo'),
                        'default'       => 5,
                        'min'           => 1,
                        'step'          => 1,
                        'max'           => 10,
                        'display_value' => 'text'
                    ),   
                    array(
                        'id'        => 'grid_column_small',
                        'type'      => 'slider',
                        'required'  => array('grid_layout_manager', '=', '1'),
                        'title'     => __('Grid Columns for Screens > 1024px', 'redux-framework-demo'),
                        'subtitle'  => __('Set a number of columns for the grid, for screens between 1024px and 1280px in width.', 'redux-framework-demo'),
                        'default'       => 5,
                        'min'           => 1,
                        'step'          => 1,
                        'max'           => 10,
                        'display_value' => 'text'
                    ),
                    array(
                        'id'        => 'grid_column_tablet',
                        'type'      => 'slider',
                        'required'  => array('grid_layout_manager', '=', '1'),
                        'title'     => __('Grid Columns for Screens > 768px', 'redux-framework-demo'),
                        'subtitle'  => __('Set a number of columns for the grid, for screens between 768px and 1024px in width.', 'redux-framework-demo'),
                        'default'       => 3,
                        'min'           => 1,
                        'step'          => 1,
                        'max'           => 10,
                        'display_value' => 'text'
                    ),     
                    array(
                        'id'        => 'grid_column_phone',
                        'type'      => 'slider',
                        'required'  => array('grid_layout_manager', '=', '1'),
                        'title'     => __('Grid Columns for Screens > 480px', 'redux-framework-demo'),
                        'subtitle'  => __('Set a number of columns for the grid, for screens between 480px and 768px in width.', 'redux-framework-demo'),
                        'default'       => 2,
                        'min'           => 1,
                        'step'          => 1,
                        'max'           => 10,
                        'display_value' => 'text'
                    ), 

                    array(
                        'id'        => 'grid_gutter_width',
                        'type'      => 'slider',
                        'required'  => array('grid_layout_manager', '=', '1'),
                        'title'     => __('Grid Gutter Width', 'redux-framework-demo'),
                        'subtitle'  => __('Set the space between the projects, in the grid', 'redux-framework-demo'),
                        'default'       => 4,
                        'min'           => 0,
                        'step'          => 2,
                        'max'           => 50,
                        'display_value' => 'text'
                    ),                                                                                                                                                                
                )
            );
            
            $this->sections[] = array(
                'icon'      => 'el-icon-website',
                'customizer'=> false,
                'title'     => __('Blog', 'redux-framework-demo'),
                'fields'    => array(
                   array(
                        'id'        => 'blog_sidebar_pos',
                        'type'      => 'image_select',
                        'title'     => __('Sidebar Position for Blog Related Pages', 'redux-framework-demo'),
                        'subtitle'  => __('Select a sidebar position for blog related pages. It will be applied to single posts, index page, archive and search pages.', 'redux-framework-demo'),
                        'options'   => array(
                            'sidebar-right' => array('alt' => 'Sidebar Right',  'img' => ReduxFramework::$_url . 'assets/img/2cr.png'),
                            'sidebar-left' => array('alt' => 'Sidebar Left',  'img' => ReduxFramework::$_url . 'assets/img/2cl.png'),
                            'no-blog-sidebar' => array('alt' => 'No Sidebar',  'img' => ReduxFramework::$_url . 'assets/img/1col.png')
                        ),
                        'default'   => 'sidebar-right'
                    ),  
                    array(
                        'id'        => 'blog_sidebar',
                        'type'      => 'select',
                        'title'     => __('Sidebar Name for Blog Related Pages', 'redux-framework-demo'),
                        'subtitle'  => __('Select the sidebar which will be applied to blog related pages, including single posts, index page, archive pages and search result pages.', 'redux-framework-demo'),
                        'data'      => 'sidebars',
                        'default' => 'sidebar',
                    ),
                    array(
                        'id'        => 'social_box',
                        'type'      => 'switch',
                        'title'     => __('Enable Social Share Icons for Blog Posts Inner Pages', 'redux-framework-demo'),
                        'subtitle'  => __('If the option is on, the social icons for sharing the post will be displayed.', 'redux-framework-demo'),
                        'default'   => 1,
                        'on'        => 'On',
                        'off'       => 'Off',
                    ), 
                    array(
                        'id'        => 'author_box',
                        'type'      => 'switch',
                        'title'     => __('Enable Author Box for Blog Posts Inner Pages', 'redux-framework-demo'),
                        'subtitle'  => __('If the option is on, the author box will be displayed.', 'redux-framework-demo'),
                        'default'   => 1,
                        'on'        => 'On',
                        'off'       => 'Off',
                    ),    
                    array(
                        'id'        => 'prev_next_posts',
                        'type'      => 'switch',
                        'title'     => __('Enable Prev/Next Posts Links for Blog Posts', 'redux-framework-demo'),
                        'subtitle'  => __('If the option is on, links for Prev/Next posts will be displayed.', 'redux-framework-demo'),
                        'default'   => 1,
                        'on'        => 'On',
                        'off'       => 'Off',
                    ),   
                    array(
                        'id'        => 'blog_title_subtitle',
                        'type'      => 'switch',
                        'title'     => __('Enable Blog Page Title & Subtitle for Blog Posts Inner Pages', 'redux-framework-demo'),
                        'subtitle'  => __('If the option is on, the main blog page title and tagline will be displayed on blog articles.', 'redux-framework-demo'),
                        'default'   => 0,
                        'on'        => 'On',
                        'off'       => 'Off',
                    ),                                                                                                 
                )
            );

            $this->sections[] = array(
                'icon'      => 'el-icon-network',
                'customizer'=> false,
                'title'     => __('Social', 'redux-framework-demo'),
                'fields'    => array(
                    array(
                        'id'        => 'social_intro',
                        'type'      => 'info',
                        'title'  => __('Social Options.', 'redux-framework-demo'),
                        'desc'      => __('Set your social network references. Add your links for popular platforms like Twitter and Facebook. If you don`t want to include a social icon in the list, just leave the textfield empty.).', 'redux-framework-demo')
                    ),
                    array(
                        'id'        => 'rss',
                        'type'      => 'text',
                        'title'     => __('Your RSS Feed address', 'redux-framework-demo'),
                        'default'   => 'http://feeds.feedburner.com/EnvatoNotes'
                    ),   
                    array(
                        'id'        => 'facebook',
                        'type'      => 'text',
                        'title'     => __('Your Facebook page/profile URL', 'redux-framework-demo'),
                        'default'   => 'http://www.facebook.com/envato'
                    ),  
                    array(
                        'id'        => 'twitter',
                        'type'      => 'text',
                        'title'     => __('Your Twitter URL', 'redux-framework-demo'),
                        'default'   => 'http://twitter.com/envato'
                    ),  
                    array(
                        'id'        => 'flickr',
                        'type'      => 'text',
                        'title'     => __('Your Flickr Page URL', 'redux-framework-demo'),
                    ),    
                    array(
                        'id'        => 'google-plus',
                        'type'      => 'text',
                        'title'     => __('Your Google Plus Page URL', 'redux-framework-demo'),
                    ),  
                    array(
                        'id'        => 'dribbble',
                        'type'      => 'text',
                        'title'     => __('Your Dribbble Profile URL', 'redux-framework-demo'),
                    ), 
                    array(
                        'id'        => 'pinterest',
                        'type'      => 'text',
                        'title'     => __('Your Pinterest URL', 'redux-framework-demo'),
                    ), 
                    array(
                        'id'        => 'linkedin',
                        'type'      => 'text',
                        'title'     => __('Your LinkedIn Profile URL', 'redux-framework-demo'),
                    ), 
                    array(
                        'id'        => 'skype',
                        'type'      => 'text',
                        'title'     => __('Your Skype Username', 'redux-framework-demo'),
                    ), 
                    array(
                        'id'        => 'github-alt',
                        'type'      => 'text',
                        'title'     => __('Your Github URL', 'redux-framework-demo'),
                    ), 
                    array(
                        'id'        => 'youtube',
                        'type'      => 'text',
                        'title'     => __('Your YouTube URL', 'redux-framework-demo'),
                    ), 
                    array(
                        'id'        => 'vimeo-square',
                        'type'      => 'text',
                        'title'     => __('Your Vimeo Page URL', 'redux-framework-demo'),
                    ), 
                    array(
                        'id'        => 'instagram',
                        'type'      => 'text',
                        'title'     => __('Your Instagram Profile URL', 'redux-framework-demo'),
                    ),

                    array(
                        'id'        => 'tumblr',
                        'type'      => 'text',
                        'title'     => __('Your Tumblr URL', 'redux-framework-demo'),
                    ),   

                    array(
                        'id'        => 'behance',
                        'type'      => 'text',
                        'title'     => __('Your Behance Profile URL', 'redux-framework-demo'),
                    ),                      

                    array(
                        'id'        => 'vk',
                        'type'      => 'text',
                        'title'     => __('Your VK URL', 'redux-framework-demo'),
                    ), 

                    array(
                        'id'        => 'xing',
                        'type'      => 'text',
                        'title'     => __('Your Xing URL', 'redux-framework-demo'),
                    ),   
                    array(
                        'id'        => 'soundcloud',
                        'type'      => 'text',
                        'title'     => __('Your SoundCloud URL', 'redux-framework-demo'),
                    ),    
                    array(
                        'id'        => 'codepen',
                        'type'      => 'text',
                        'title'     => __('Your Codepen URL', 'redux-framework-demo'),
                    ),                                                                                              
                    array(
                        'id'        => 'yelp',
                        'type'      => 'text',
                        'title'     => __('Your Yelp URL', 'redux-framework-demo'),
                    ),   

                    array(
                        'id'        => 'header_social',
                        'type'      => 'switch',
                        'title'     => __('Social Icons in Header', 'redux-framework-demo'),
                        'subtitle'  => __('Enable/Disable social icons for the header. If enabled, the social icons block will be displayed in the header nav bar.', 'redux-framework-demo'),
                        'default'   => 0,
                        'on'        => 'Enabled',
                        'off'       => 'Disabled'
                    ),                     
                                                                                                                                                         

               )
            ); 

            if ( class_exists( 'Woocommerce' ) ) {  
               $this->sections[] = array(
                    'icon'      => 'el-icon-shopping-cart',
                    'customizer'=> false,
                    'title'     => __('WooCommerce', 'redux-framework-demo'),
                    'fields'    => array(
                       array(
                            'id'        => 'woo_layout',
                            'type'      => 'image_select',
                            'title'     => __('Sidebar Position for the Shop Page', 'redux-framework-demo'),
                            'subtitle'  => __('Select a sidebar position for the Shop page.', 'redux-framework-demo'),
                            'options'   => array(
                                'sidebar-right' => array('alt' => 'Sidebar Right',  'img' => ReduxFramework::$_url . 'assets/img/2cr.png'),
                                'sidebar-left' => array('alt' => 'Sidebar Left',  'img' => ReduxFramework::$_url . 'assets/img/2cl.png'),
                                'no-sidebar' => array('alt' => 'No Sidebar',  'img' => ReduxFramework::$_url . 'assets/img/1col.png')
                            ),
                            'default'   => 'sidebar-right'
                        ),  
                        array(
                            'id'        => 'woo_sidebar',
                            'type'      => 'select',
                            'title'     => __('Sidebar Name for Shop Page', 'redux-framework-demo'),
                            'subtitle'  => __('Select the sidebar which will be applied to the shop page, if the shop page layout defined from the option from above is set to a sidebar.', 'redux-framework-demo'),
                            'data'      => 'sidebars',
                            'default' => 'sidebar',
                        ),
                    array(
                        'id'        => 'woo_products_per_row',
                        'type'      => 'select',
                        'title'     => __('Products per Row', 'redux-framework-demo'),
                        'subtitle'  => __('Set how many products would you like to display on a single row. In other words, how many columns will the shop page has?', 'redux-framework-demo'),
                        'options'   => array('2' => '2',  '3' => '3', '4' => '4', '5' => '5', '6' => '6'),
                        'default'   => '3',
                    ),                        
                   )
                );       
            }                                             

        }

        

        /**

          All the possible arguments for Redux.
          For full documentation on arguments, please refer to: https://github.com/ReduxFramework/ReduxFramework/wiki/Arguments

         * */
        public function setArguments() {

            $theme = wp_get_theme(); // For use with some settings. Not necessary.

            $this->args = array(
                // TYPICAL -> Change these values as you need/desire
                'opt_name'          => 'smof_data',            // This is where your data is stored in the database and also becomes your global variable name.
                'display_name'      => $theme->get('Name'),     // Name that appears at the top of your panel
                'display_version'   => $theme->get('Version'),  // Version that appears at the top of your panel
                'menu_type'         => 'submenu',                  //Specify if the admin menu should appear or not. Options: menu or submenu (Under appearance only)
                'allow_sub_menu'    => true,                    // Show the sections below the admin menu item or not
                'menu_title'        => __('Theme Options', 'redux-framework-demo'),
                'page_title'        => __('Theme Options', 'redux-framework-demo'),
                
                // You will need to generate a Google API key to use this feature.
                // Please visit: https://developers.google.com/fonts/docs/developer_api#Auth
                'google_api_key' => 'AIzaSyBPVwg6CaFLmKlxYjQu0bJGpxDN1p04S-Q', // Must be defined to add google fonts to the typography module
                
                'async_typography'  => false,                    // Use a asynchronous font on the front end or font string
                'admin_bar'         => true,                    // Show the panel pages on the admin bar
                'global_variable'   => '',                      // Set a different name for your global variable other than the opt_name
                'dev_mode'          => false,                    // Show the time the page took to load, etc
                'customizer'        => true,                    // Enable basic customizer support
                
                // OPTIONAL -> Give you extra features
                'page_priority'     => null,                    // Order where the menu appears in the admin area. If there is any conflict, something will not show. Warning.
                'page_parent'       => 'themes.php',            // For a full list of options, visit: http://codex.wordpress.org/Function_Reference/add_submenu_page#Parameters
                'page_permissions'  => 'manage_options',        // Permissions needed to access the options panel.
                'menu_icon'         => '',                      // Specify a custom URL to an icon
                'last_tab'          => '',                      // Force your panel to always open to a specific tab (by id)
                'page_icon'         => 'icon-themes',           // Icon displayed in the admin panel next to your menu_title
                'page_slug'         => '_options',              // Page slug used to denote the panel
                'save_defaults'     => true,                    // On load save the defaults to DB before user clicks save or not
                'default_show'      => false,                   // If true, shows the default value next to each field that is not the default value.
                'default_mark'      => '',                      // What to print by the field's title if the value shown is default. Suggested: *
                
                // CAREFUL -> These options are for advanced use only
                'transient_time'    => 60 * MINUTE_IN_SECONDS,
                'output'            => true,                    // Global shut-off for dynamic CSS output by the framework. Will also disable google fonts output
                'output_tag'        => true,                    // Allows dynamic CSS to be generated for customizer and google fonts, but stops the dynamic CSS from going to the head
                // 'footer_credit'     => '',                   // Disable the footer credit of Redux. Please leave if you can help it.
                
                // FUTURE -> Not in use yet, but reserved or partially implemented. Use at your own risk.
                'database'              => '', // possible: options, theme_mods, theme_mods_expanded, transient. Not fully functional, warning!
                'show_import_export'    => true, // REMOVE
                'system_info'           => false, // REMOVE

                // HINTS
                'hints' => array(
                    'icon'          => 'icon-question-sign',
                    'icon_position' => 'right',
                    'icon_color'    => 'lightgray',
                    'icon_size'     => 'normal',
                    'tip_style'     => array(
                        'color'         => 'light',
                        'shadow'        => true,
                        'rounded'       => false,
                        'style'         => '',
                    ),
                    'tip_position'  => array(
                        'my' => 'top left',
                        'at' => 'bottom right',
                    ),
                    'tip_effect'    => array(
                        'show'          => array(
                            'effect'        => 'slide',
                            'duration'      => '500',
                            'event'         => 'mouseover',
                        ),
                        'hide'      => array(
                            'effect'    => 'slide',
                            'duration'  => '500',
                            'event'     => 'click mouseleave',
                        ),
                    ),
                )
            );


            // SOCIAL ICONS -> Setup custom links in the footer for quick links in your panel footer icons.
            $this->args['share_icons'][] = array(
                'url'   => 'mailto:deliciousthemes@gmail.com',
                'title' => 'Send an email to DeliciousThemes',
                'icon'  => 'el-icon-envelope'
                //'img'   => '', // You can use icon OR img. IMG needs to be a full URL.
            );
            $this->args['share_icons'][] = array(
                'url'   => 'http://themeforest.net/item/patti-parallax-one-page-wordpress-theme/7068682',
                'title' => 'Theme Official Page',
                'icon'  => 'el-icon-link'
            );
            $this->args['share_icons'][] = array(
                'url'   => 'http://twitter.com/deliciousthemes',
                'title' => 'Follow DeliciousThemes on Twitter',
                'icon'  => 'el-icon-twitter'
            );

        }

    }
    
    global $reduxConfig;
    $reduxConfig = new Redux_Framework_sample_config();
}

/**
  Custom function for the callback referenced above
 */
if (!function_exists('redux_my_custom_field')):
    function redux_my_custom_field($field, $value) {
        print_r($field);
        echo '<br/>';
        print_r($value);
    }
endif;


/**
  Custom function for the callback validation referenced above
 * */
if (!function_exists('redux_validate_callback_function')):
    function redux_validate_callback_function($field, $value, $existing_value) {
        $error = false;
        $value = 'just testing';

        /*
          do your validation

          if(something) {
            $value = $value;
          } elseif(something else) {
            $error = true;
            $value = $existing_value;
            $field['msg'] = 'your custom error message';
          }
         */

        $return['value'] = $value;
        if ($error == true) {
            $return['error'] = $field;
        }
        return $return;
    }
endif;
