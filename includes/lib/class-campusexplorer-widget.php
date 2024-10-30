<?php

if ( ! defined( 'ABSPATH' ) ) exit;

class campusexplorer_Widget extends WP_Widget{


	public function __construct() {
		$widget_ops = array('classname' => 'campusexplorer_wp_widget', 'description' => __( 'A widget for the campusexplorer widget.') );
		parent::__construct('campusexplorer', __('Campus Explorer'), $widget_ops);

		// Register taxonomy
		add_action('widgets_init', array( $this, 'campusexplorer' ) );
	}

	/**
	 * @param array $args
	 * @param array $instance
	 */
	public function widget( $args, $instance ) {

		/**
		 * Filter the widget title.
		 *
		 * @since 2.6.0
		 *
		 * @param string $title    The widget title. Default 'Pages'.
		 * @param array  $instance An array of the widget's settings.
		 * @param mixed  $id_base  The widget ID.
		 */
		$title = apply_filters( 'widget_title', empty( $instance['title'] ) ? __( '' ) : $instance['title'], $instance, $this->id_base );

		$ce_source =sanitize_title_with_dashes(get_option('ce_pub_source_code'));

		if ($ce_source){

			if( $instance['is_accept_aos_con_from_url'] == '1' ){
				$instance['aos_from_url'] = !empty($_GET['aos'])? sanitize_title($_GET['aos']): '';
				$instance['concentration_from_url'] = !empty($_GET['concentration'])? sanitize_title($_GET['concentration']): '';
			}
			$widget_settings =  ' data-ce-source="' . $ce_source ;
			$widget_settings .= ($instance['sourcecode_append'] != '' ? '-' . $instance['sourcecode_append'] : '');
			$widget_settings .= '"'; // end ce-source
			$widget_settings .= ($instance['tracking'] != '' ? ' data-ce-tracking_code="' . $instance['tracking'] . '"'  : '');

			$widget_settings .= !empty($instance['aos_from_url']) ? ' data-ce-area_of_study="' . $instance['aos_from_url'] . '"'  : (isset($instance['aos']) && $instance['aos'] != '' ? ' data-ce-area_of_study="' . $instance['aos'] . '"'  : '');

			$widget_settings .= (!empty($instance['concentration_from_url']) ? ' data-ce-concentration="' . $instance['concentration_from_url'] . '"'  : ($instance['concentration'] != '' ? ' data-ce-concentration="' . $instance['concentration'] . '"'  : ''));

			$widget_settings .= ($instance['theme'] != '' ? ' data-ce-theme="' . $instance['theme'] . '"'  : '');
			$widget_settings .= ($instance['college'] != '' ? ' data-ce-college="' . $instance['college'] . '"'   : '');
			$widget_settings .= ($instance['header_text'] != '' ? ' data-ce-header_text="' . $instance['header_text'] . '"'  : '');
			$widget_settings .= ($instance['intro_text'] != '' ? ' data-ce-intro_text="' . $instance['intro_text'] . '"'  : '');

			if ($instance['is_lightbox'] == 1){

				$out = '<a class="campusexplorer-widget-launch" ';
				$out .= $widget_settings;
				$out .=  ' title="Get information on the degree program that\'s right for you."  rel="nofollow">';
				$out .= ($instance['lightbox_btn_text'] ?  $instance['lightbox_btn_text']: 'Request Information');
				$out .= '</a>';
			}else{
				$out = '<div class="campusexplorer-widget" '. $widget_settings .'></div>';
			}
		}
		if ( ! empty( $out ) ) {
			echo $args['before_widget'];
			if ( $title ) {
				echo $args['before_title'] . $title . $args['after_title'];
			}
	?>
			<?php echo $out; ?>

		<?php
			echo $args['after_widget'];
		}
	}


	/**
	 * @param array $new_instance
	 * @param array $old_instance
	 * @return array
	 */
	public function update( $new_instance, $old_instance ) {
		$instance = $old_instance;
		$instance['title'] = strip_tags($new_instance['title']);
	/*	if ( in_array( $new_instance['sortby'], array( 'post_title', 'menu_order', 'ID' ) ) ) {
			$instance['sortby'] = $new_instance['sortby'];
		} else {
			$instance['sortby'] = 'menu_order';
		}*/

		$instance['sourcecode_append'] = sanitize_title_with_dashes( $new_instance['sourcecode_append'] );
		$instance['tracking'] = strip_tags( $new_instance['tracking'] );
		$instance['header_text'] = strip_tags( $new_instance['header_text'] );
		$instance['intro_text'] = strip_tags( $new_instance['intro_text'] );
		$instance['theme'] = strip_tags( $new_instance['theme'] );
		$instance['is_accept_aos_con_from_url'] = strip_tags($new_instance['is_accept_aos_con_from_url']);
		$instance['aos'] = sanitize_title_with_dashes( $new_instance['aos'] );
		$instance['concentration'] = sanitize_title_with_dashes( $new_instance['concentration'] );
		$instance['college'] = sanitize_title_with_dashes( $new_instance['college'] );
		$instance['is_lightbox'] = sanitize_title_with_dashes( $new_instance['is_lightbox'] );
		$instance['lightbox_btn_text'] =  sanitize_text_field($new_instance['lightbox_btn_text']);

		return $instance;
	}

	/**
	 * @param array $instance
	 */
	public function form( $instance ) {
		//Defaults
		$instance      = wp_parse_args( (array) $instance, array( 'tracking' => '', 'sourcecode_append' => '', 'title' => '', 'header_text' => '', 'concentration' => '', 'intro_text' => '', 'is_accept_aos_con_from_url' => '0', 'aos' => '', 'concentration' => '', 'college' => '', 'is_lightbox' => '0', 'lightbox_btn_text' => '') );
		$tracking      = esc_attr( $instance['tracking'] );
		$sourcecode_append  = esc_attr( $instance['sourcecode_append'] );
		$title         = esc_attr( $instance['title'] );
		$header_text   = esc_attr( $instance['header_text'] );
		$intro_text    = esc_attr( $instance['intro_text']);
		$is_accept_aos_con_from_url = esc_attr( $instance['is_accept_aos_con_from_url']);
		$aos           = esc_attr( $instance['aos']);
		$concentration = esc_attr( $instance['concentration'] );
		$theme         = esc_attr( $instance['theme'] );
		$college       = esc_attr( $instance['college']);
		$is_lightbox   = esc_attr( $instance['is_lightbox']);
		$lightbox_btn_text = esc_attr( $instance['lightbox_btn_text']);

	?>
		<p><label for="<?php echo $this->get_field_id('title'); ?>"><?php _e('Title:'); ?></label> <input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo $title; ?>" />
		<br /><small><?php _e( 'Title to display above the widget. Can be blank.' ); ?></small></p>

		<p><label for="<?php echo $this->get_field_id('header_text'); ?>"><?php _e('Header Text:'); ?></label> <input class="widefat" id="<?php echo $this->get_field_id('header_text'); ?>" name="<?php echo $this->get_field_name('header_text'); ?>" type="text" value="<?php echo $header_text; ?>" /></p>

		<p><label for="<?php echo $this->get_field_id('intro_text'); ?>"><?php _e('Intro Text:'); ?></label> <input class="widefat" id="<?php echo $this->get_field_id('intro_text'); ?>" name="<?php echo $this->get_field_name('intro_text'); ?>" type="text" value="<?php echo $intro_text; ?>" /></p>


		<p><label for="<?php echo $this->get_field_id('is_accept_aos_con_from_url'); ?>"><?php _e('Accept the area of study or concentration from the url?'); ?></label> <input class="campusexplorer_widget_is_accept_aos_con_from_url_input widefat" id="<?php echo $this->get_field_id('is_accept_aos_con_from_url'); ?>" name="<?php echo $this->get_field_name('is_accept_aos_con_from_url'); ?>" type="checkbox" value="1"  <?php if($is_accept_aos_con_from_url){ echo 'checked';} ?>/>
		<br />
			<small><?php _e( 'Check this if you would like the generated code to accept the Area of Study or Concentration from url parameters. To do this, append the following to the page url: ?aos=xxxxxxx&concentration=yyyyyy' ); ?></small></p>

		<p><label for="<?php echo $this->get_field_id('aos'); ?>"><?php _e('Area of Study:'); ?></label> <input class="widefat" id="<?php echo $this->get_field_id('aos'); ?>" name="<?php echo $this->get_field_name('aos'); ?>" type="text" value="<?php echo $aos; ?>" />
		<br />
			<small><?php _e( 'Use this field if you want to highlight a specific Area of Study. Check your Campus Explorer dashboard for an Area of Study ID.' ); ?></small></p>
		<p><label for="<?php echo $this->get_field_id('concentration'); ?>"><?php _e('Concentration:'); ?></label> <input class="widefat" id="<?php echo $this->get_field_id('concentration'); ?>" name="<?php echo $this->get_field_name('concentration'); ?>" type="text" value="<?php echo $concentration; ?>" />
		<br />
			<small><?php _e( 'Use this field if you want to highlight a specific Concentration. Check your Campus Explorer dashboard for a Concentration ID.' ); ?></small></p>

		<p><label for="<?php echo $this->get_field_id('college'); ?>"><?php _e('College:'); ?></label> <input class="widefat" id="<?php echo $this->get_field_id('college'); ?>" name="<?php echo $this->get_field_name('college'); ?>" type="text" value="<?php echo $college; ?>" />
		<br />
			<small><?php _e( 'Use this field if you want to highlight a specific school. Check your Campus Explorer dashboard for the correct CollegeID.' ); ?></small></p>
		<p><label for="<?php echo $this->get_field_id('is_lightbox'); ?>"><?php _e('Widget as a Lightbox/Panel?'); ?></label> <input class="campusexplorer_widget_is_lightbox_input widefat" id="<?php echo $this->get_field_id('is_lightbox'); ?>" name="<?php echo $this->get_field_name('is_lightbox'); ?>" type="checkbox" value="1"  <?php if($is_lightbox){ echo 'checked';} ?>/>
		<br />
			<small><?php _e( 'Check this if you would like the generated code to output a button, with the widget appearing as a lightbox/panel when user clicks button.' ); ?></small></p>
		<p class="display_lightbox_btn_txt"><label for="<?php echo $this->get_field_id('lightbox_btn_text'); ?>"><?php _e('Button text to display the lightbox:'); ?></label> <input class="widefat" id="<?php echo $this->get_field_id('lightbox_btn_text'); ?>" name="<?php echo $this->get_field_name('lightbox_btn_text'); ?>" type="text" value="<?php echo $lightbox_btn_text; ?>" />
		<br />
			<small><?php _e( 'The text that appears on the button to display the lightbox.' ); ?></small></p>

		<p><label for="<?php echo $this->get_field_id('tracking'); ?>"><?php _e('Tracking:'); ?></label> <input class="widefat" id="<?php echo $this->get_field_id('tracking'); ?>" name="<?php echo $this->get_field_name('tracking'); ?>" type="text" value="<?php echo $tracking; ?>" />
		<br /><small><?php _e( 'Add your custom tracking string here.' ); ?></small></p>

		<p><label for="<?php echo $this->get_field_id('sourcecode_append'); ?>"><?php _e('Source Code Suffix:'); ?></label> <input class="widefat" id="<?php echo $this->get_field_id('sourcecode_append'); ?>" name="<?php echo $this->get_field_name('sourcecode_append'); ?>" type="text" value="<?php echo $sourcecode_append; ?>" />
		<br /><small><?php _e( 'Advanced: If you require additional tracking aside from the tracking code, add it here. If you are unsure, leave blank.' ); ?></small></p>

		<p><label for="<?php echo $this->get_field_id('theme'); ?>"><?php _e('Theme:'); ?></label> <input class="widefat" id="<?php echo $this->get_field_id('theme'); ?>" name="<?php echo $this->get_field_name('theme'); ?>" type="text" value="<?php echo $theme; ?>" />
		<br /><small><?php _e( 'Advanced: Custom styling for the widget. Talk to your account manager about setting this up.' ); ?></small></p>

<?php
	}




}

