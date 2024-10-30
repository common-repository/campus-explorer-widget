<?php

if ( ! defined( 'ABSPATH' ) ) exit;

class campusexplorer_Shortcode {

	public static function content( $atts, $content = "" ) {

		if(!empty($atts['is_accept_aos_con_from_url'])){
			$aos_from_url = !empty($_GET['aos'])? sanitize_title($_GET['aos']): '';
			$concentration_from_url = !empty($_GET['concentration'])? sanitize_title($_GET['concentration']): '';
		}

		$ce_source = sanitize_title_with_dashes(get_option('ce_pub_source_code'));

		if ($ce_source){

			$widget_settings =  ' data-ce-source="' . $ce_source ;
			$widget_settings .= (isset($atts['sourcecode_append']) && $atts['sourcecode_append'] != '' ? '-' . $atts['sourcecode_append'] : '');
			$widget_settings .= '"'; // end ce-source
			$widget_settings .= (isset($atts['tracking']) && $atts['tracking'] != '' ? ' data-ce-tracking_code="' . $atts['tracking'] . '"'  : '');

			$widget_settings .= !empty($aos_from_url) ? ' data-ce-area_of_study="' . $aos_from_url . '"'  : (isset($atts['aos']) && $atts['aos'] != '' ? ' data-ce-area_of_study="' . $atts['aos'] . '"'  : '');

			$widget_settings .= !empty($concentration_from_url) ? ' data-ce-concentration="' . $concentration_from_url . '"'  : (isset($atts['concentration']) && $atts['concentration'] != '' ? ' data-ce-concentration="' . $atts['concentration'] . '"'  : '');
			$widget_settings .= (isset($atts['college']) && $atts['college'] != '' ? ' data-ce-college="' . $atts['college'] . '"'   : '');
			$widget_settings .= (isset($atts['theme']) && $atts['theme'] != '' ? ' data-ce-theme="' . $atts['theme'] . '"'   : '');
			$widget_settings .= (isset($atts['header_text']) && $atts['header_text'] != '' ? ' data-ce-header_text="' . $atts['header_text'] . '"'  : '');
			$widget_settings .= (isset($atts['intro_text']) && $atts['intro_text'] != '' ? ' data-ce-intro_text="' . $atts['intro_text'] . '"'  : '');

			if (isset($atts['is_lightbox']) && $atts['is_lightbox'] == 1){
				$out = '<a class="campusexplorer-widget-launch" ';
				$out .= $widget_settings;
				$out .=  ' title="Get information on the degree program that\'s right for you."  rel="nofollow">';
				$out .= (isset($atts['lightbox_btn_text']) && $atts['lightbox_btn_text'] ?  $atts['lightbox_btn_text']: 'Request Information');
				$out .= '</a>';
			}else{
				$out = '<div class="campusexplorer-widget" '. $widget_settings .'></div>';
			}
		}

		return $out;
	}

}

