<?php
$output = $dt_id = $dt_bg_image = $dt_bg_repeat = $dt_bg_color = $dt_color_opacity = $dt_text_scheme = $dt_class = $el_class = $dt_no_mb = $dt_row_type = $dt_youtube_url = $video_raster = '';
extract(shortcode_atts(array(
    'dt_id'        		=> '',
    'bg_image'       	=> '',
    'dt_parallax_inertia'=>'0.4',
    'dt_bg_repeat'      => '',
    'bg_color' 			=> '',
    'dt_color_opacity'  => '',
    'dt_text_scheme'    => '',
    'dt_padding_top'    => '',
    'dt_padding_bottom' => '',
    'dt_class'          => '',
    'el_class'   		=> '',
    'dt_no_mb'  		=> '',
    'dt_row_type'       => '',
    'dt_youtube_url'    => '',
    'video_raster'     => ''
), $atts));

wp_enqueue_style( 'js_composer_front' );
wp_enqueue_script( 'wpb_composer_front_js' );
wp_enqueue_style('js_composer_custom_css');

global $smof_data;

$rnd_id = dt_random_id(3);
$token = wp_generate_password(5, false, false);

    // youtube video bg
    if(($dt_row_type != '') && ($dt_youtube_url != '')) {
        wp_enqueue_script('dt-yotube-video-bg', get_template_directory_uri() . '/js/jquery-ytp.js', array('jquery'), '1.0', true ); 
        wp_localize_script( 'dt-yotube-video-bg', 'dt_vbg_' . $token, array( 'id' => $rnd_id) );
    }

    $video_bg = '';
    $dt_vid = '#'.$dt_id;

    if(($dt_row_type != '') && ($dt_youtube_url != '')) {
        $boolv = 'false';
        if($video_raster != '') {
            $boolv = 'true';
        }
        
        $video_bg = 'data-property="{videoURL: \'' . $dt_youtube_url . '\', containment: \'' .$dt_vid. '\', autoPlay:true, realfullscreen: true, addRaster: '.$boolv.', showControls: false, mute:true, startAt:0, opacity:1}"';
    }

if(isset($smof_data['parallax_enabled']) && ($smof_data['parallax_enabled'] =='1')) { 
    wp_enqueue_script('dt-custom-parallax', get_template_directory_uri() . '/js/custom/custom-parallax.js', array('dt-custom-isotope-blog', 'dt-custom-isotope-portfolio'), '1.0', true ); 
    wp_localize_script( 'dt-custom-parallax', 'dt_parallax_' . $token, array( 'id' => $rnd_id, 'inertia' => $dt_parallax_inertia ) );
}

$dt_class = $this->getExtraClass($dt_class);



	$style = '';
	$parallax_bg = '';
	if(!empty($bg_image)) {
		$parallax_bg = 'parallax-bag-'.$rnd_id;
	}

    $bgv_class = '';
    if(($dt_row_type != '') && ($dt_youtube_url != '')) {
        $bgv_class .= 'ytp-player-'.$rnd_id;
    }

    // Color overlay
    $rgbcolor = '';
    if(!empty($bg_color)) {
        $rgbcolor = hex2rgb($bg_color);
    }

    // Opacity
    $cop = '0.70';
    if(!empty($dt_color_opacity)) { 
        if($dt_color_opacity  == 100) {
            $cop = '1';
        }
        else if($dt_color_opacity  < 100) {
            $cop = '0.'.$dt_color_opacity.'';
        }
    } 

    // BG Image
    $has_image = false;
    if((int)$bg_image > 0 && ($image_url = wp_get_attachment_url( $bg_image, 'large' )) !== false) {
        $has_image = true;

        if(isset($smof_data['lazyload']) && ($smof_data['lazyload'] =='1')) {
            $style .= "background-image: url(".get_template_directory_uri().'/images/grey.gif'.");";
        }
        else {
            $style .= "background-image: url(".$image_url.");";    
        }
        
    }
    if(!empty($dt_bg_repeat) && $has_image) {
        if($dt_bg_repeat === 'no-repeat') {
            $style .= "background-repeat:no-repeat;";
        } elseif($dt_bg_repeat === 'repeat-x') {
            $style .= "background-repeat:repeat-x;";
        } elseif($dt_bg_repeat === 'repeat-y') {
            $style .= 'background-repeat: repeat-y;';
        } elseif($dt_bg_repeat === 'repeat') {
            $style .= 'background-repeat: repeat;';
        }
        $style .= 'background-attachment: fixed;';
        $style .= 'background-position: 50% 0;';
    }

    // Padding
    $padding = '';
    if(!empty($dt_padding_top)) {
        $padding .= 'padding-top: '.$dt_padding_top.'px;';
    }
    if(!empty($dt_padding_bottom)) {
        $padding .= 'padding-bottom: '.$dt_padding_bottom.'px;';
    }  

    // Data Img:original or src for lazyload
    $dataimg = '';
    $lazyclass = '';
    if(!empty($image_url)) {
        if(isset($smof_data['lazyload']) && ($smof_data['lazyload'] =='1')) { 
            $dataimg = 'data-original="'.$image_url.'"';
            $lazyclass = 'lazy';
        }
        else {
           $dataimg = 'src="'.$image_url.'"'; 
        }
    }

    // ID
    $output_id = '';
    if(!empty($dt_id)) {
        $output_id = 'id="'.$dt_id.'"';
    }

$css_class =  apply_filters(VC_SHORTCODE_CUSTOM_CSS_FILTER_TAG, 'wpb_row '.get_row_css_class().$dt_class.' '.$dt_no_mb.' '.$el_class.' '.$dt_row_type, $this->settings['base']);

$output .= '<div '.$output_id.' '.$video_bg.' class="'.$lazyclass.' '.$bgv_class.' '.$parallax_bg.' '.$css_class.'" '.$dataimg.' style="'.$style.'"  data-token="' . $token . '">';
    if( (!empty($bg_image)) || (!empty($bg_color)) || (!empty($dt_padding_top)) || (!empty($dt_padding_bottom)) ) {
        $output .= '<div class="'.$dt_text_scheme.'" style="'.$padding.' background-color: rgba('.$rgbcolor.', '.$cop.');">';
    }
	   $output .= wpb_js_remove_wpautop($content);
    if( (!empty($bg_image)) || (!empty($bg_color)) || (!empty($dt_padding_top)) || (!empty($dt_padding_bottom)) ) {
        $output .= '<div class="clear"></div></div>';
    }       
$output .= '</div>'.$this->endBlockComment('row');

echo $output;