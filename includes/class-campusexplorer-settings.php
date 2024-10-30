<?php

if ( ! defined( 'ABSPATH' ) ) exit;

class campusexplorer_Settings {

	/**
	 * The single instance of campusexplorer_Settings.
	 * @var 	object
	 * @access  private
	 * @since 	1.0.0
	 */
	private static $_instance = null;

	/**
	 * The main plugin object.
	 * @var 	object
	 * @access  public
	 * @since 	1.0.0
	 */
	public $parent = null;

	/**
	 * Prefix for plugin settings.
	 * @var     string
	 * @access  public
	 * @since   1.0.0
	 */
	public $base = '';

	/**
	 * Available settings for plugin.
	 * @var     array
	 * @access  public
	 * @since   1.0.0
	 */
	public $settings = array();

	public function __construct ( $parent ) {
		$this->parent = $parent;

		$this->base = 'ce_';

		// Initialise settings
		add_action( 'init', array( $this, 'init_settings' ), 11 );

		// Register plugin settings
		add_action( 'admin_init' , array( $this, 'register_settings' ) );

		// Add settings page to menu
		add_action( 'admin_menu' , array( $this, 'add_menu_item' ) );

		// Add settings link to plugins page
		add_filter( 'plugin_action_links_' . plugin_basename( $this->parent->file ) , array( $this, 'add_settings_link' ) );

	}

	/**
	 * Initialise settings
	 * @return void
	 */
	public function init_settings () {
		$this->settings = $this->settings_fields();
	}

	/**
	 * Add settings page to admin menu
	 * @return void
	 */
	public function add_menu_item () {
		$page = add_options_page( __( 'Campus Explorer Settings', 'campusexplorer' ) , __( 'Campus Explorer', 'campusexplorer' ) , 'manage_options' , $this->parent->_token . '_settings' ,  array( $this, 'settings_page' ) );
		add_action( 'admin_print_styles-' . $page, array( $this, 'settings_assets' ) );
	}

	/**
	 * Load settings JS & CSS
	 * @return void
	 */
	public function settings_assets () {
	// To be added in a later version
		// We're including the farbtastic script & styles here because they're needed for the colour picker
		// If you're not including a colour picker field then you can leave these calls out as well as the farbtastic dependency for the wpt-admin-js script below

		//wp_enqueue_style( 'farbtastic' );
    	//wp_enqueue_script( 'farbtastic' );

    	// We're including the WP media scripts here because they're needed for the image upload field
    	// If you're not including an image upload then you can leave this function call out
    	//wp_enqueue_media();

    	//wp_register_script( $this->parent->_token . '-settings-js', $this->parent->assets_url . 'js/settings' . $this->parent->script_suffix . '.js', array( 'farbtastic', 'jquery' ), '1.0.0' );
    	//wp_enqueue_script( $this->parent->_token . '-settings-js' );
	}

	/**
	 * Add settings link to plugin list table
	 * @param  array $links Existing links
	 * @return array 		Modified links
	 */
	public function add_settings_link ( $links ) {
		$settings_link = '<a href="options-general.php?page=' . $this->parent->_token . '_settings">' . __( 'Settings', 'campusexplorer' ) . '</a>';
  		array_push( $links, $settings_link );
  		return $links;
	}

	/**
	 * Build settings fields
	 * @return array Fields to be displayed on settings page
	 */
	private function settings_fields () {

		$settings['campusexplorer'] = array(
			'title'					=> __( 'Campus Explorer Account', 'campusexplorer' ),
			'description'			=> __( 'Please enter the settings below. If you do not have a source code, please contact your CampusExplorer account manager.', 'campusexplorer' ),
			'fields'				=> array(
				array(
					'id' 			=> 'pub_source_code',
					'label'			=> __( 'Source Code' , 'campusexplorer' ),
					'description'	=> __( 'Your Campus Explorer Publisher Source Code.', 'campusexplorer' ),
					'type'			=> 'text',
					'default'		=> '',
					'placeholder'	=> __( 'e.g. SA-XXXXXXX', 'campusexplorer' )
				),
			)
		);

		$settings['shortcode_builder'] = array(
			'title'					=> __( 'Shortcode Builder', 'campusexplorer' ),
			'description'			=> __( 'Use this form to build your shortcode. The resulting text can be pasted into your posts or pages.', 'campusexplorer' ),
			'fields'				=> array(
				array(
					'id' 			=> 'header_text',
					'label'			=> __( 'Header Text' , 'campusexplorer' ),
					'description'	=> __( 'Text that appears on the top of the widget.', 'campusexplorer' ),
					'type'			=> 'text',
					'default'		=> '',
					'placeholder'	=> __( '', 'campusexplorer' )
				),
				array(
					'id' 			=> 'intro_text',
					'label'			=> __( 'Intro Text' , 'campusexplorer' ),
					'description'	=> __( 'Text that appears beneath the header text.', 'campusexplorer' ),
					'type'			=> 'text',
					'default'		=> '',
					'placeholder'	=> __( '', 'campusexplorer' )
				),
				array(
					'id' 			=> 'is_accept_aos_con_from_url',
					'label'			=> __( 'Accept the area of study or concentration from the url?' , 'campusexplorer' ),
					'description'	=> __( 'Check this if you would like the generated code to accept the Area of Study or Concentration from url parameters. To do this, append the following to the page url: ?aos=xxxxxxx&concentration=yyyyyy', 'campusexplorer' ),
					'type'			=> 'checkbox',
					'value'			=> '1',
					'default'   	=> '0'
				),
				array(
					'id' 			=> 'aos',
					'label'			=> __( 'Area of Study' , 'campusexplorer' ),
					'description'	=> __( 'Use this field if you want to highlight a specific Area of Study. Check your Campus Explorer dashboard for an Area of Study ID.', 'campusexplorer' ),
					'type'			=> 'text',
					'default'		=> '',
					'placeholder'	=> __( '', 'campusexplorer' )
				),
				array(
					'id' 			=> 'concentration',
					'label'			=> __( 'Concentration' , 'campusexplorer' ),
					'description'	=> __( 'Use this field if you want to highlight a specific Concentration. Check your Campus Explorer dashboard for a Concentration ID.', 'campusexplorer' ),
					'type'			=> 'text',
					'default'		=> '',
					'placeholder'	=> __( '', 'campusexplorer' )
				),
				array(
					'id' 			=> 'college',
					'label'			=> __( 'College ID' , 'campusexplorer' ),
					'description'	=> __( 'Use this field if you want to highlight a specific school. Check your Campus Explorer dashboard for the correct CollegeID.', 'campusexplorer' ),
					'type'			=> 'text',
					'default'		=> '',
					'placeholder'	=> __( '', 'campusexplorer' )
				),
				array(
					'id' 			=> 'is_lightbox',
					'label'			=> __( 'Widget as a Lightbox/Panel?' , 'campusexplorer' ),
					'description'	=> __( 'Check this if you would like the generated code to output a button, with the widget appearing as a lightbox/panel when user clicks button.', 'campusexplorer' ),
					'type'			=> 'checkbox',
					'value'		=> '1',
				),
				array(
					'id' 			=> 'lightbox_btn_text',
					'label'			=> __( 'Button text to display the lightbox' , 'campusexplorer' ),
					'description'	=> __( 'The text that appears on the button to display the lightbox.', 'campusexplorer' ),
					'type'			=> 'text',
					'default'		=> '',
					'placeholder'	=> __( '', 'campusexplorer' )
				),
				array(
					'id' 			=> 'tracking',
					'label'			=> __( 'Tracking' , 'campusexplorer' ),
					'description'	=> __( 'Tracking tag', 'campusexplorer' ),
					'type'			=> 'text',
					'default'		=> '',
					'placeholder'	=> __( '', 'campusexplorer' )
				),
				array(
					'id' 			=> 'sourcecode_append',
					'label'			=> __( 'Source Code Suffix' , 'campusexplorer' ),
					'description'	=> __( 'Advanced: If you require additional tracking aside from the tracking code, add it here. If you are unsure, leave blank.', 'campusexplorer' ),
					'type'			=> 'text',
					'default'		=> '',
					'placeholder'	=> __( '', 'campusexplorer' )
				),
				array(
					'id' 			=> 'theme',
					'label'			=> __( 'Theme' , 'campusexplorer' ),
					'description'	=> __( 'Advanced: This is for custom styling for the widget. Please talk to your account manager about setting this up.', 'campusexplorer' ),
					'type'			=> 'text',
					'default'		=> '',
					'placeholder'	=> __( '', 'campusexplorer' )
				),

			)
		);

		$settings = apply_filters( $this->parent->_token . '_settings_fields', $settings );

		return $settings;
	}

	/**
	 * Register plugin settings
	 * @return void
	 */
	public function register_settings () {
		if ( is_array( $this->settings ) ) {

			// Check posted/selected tab
			$current_section = '';
			if ( isset( $_POST['tab'] ) && $_POST['tab'] ) {
				$current_section = $_POST['tab'];
			} else {
				if ( isset( $_GET['tab'] ) && $_GET['tab'] ) {
					$current_section = $_GET['tab'];
				}
			}

			foreach ( $this->settings as $section => $data ) {

				if ( $current_section && $current_section != $section ) continue;

				// Add section to page
				add_settings_section( $section, $data['title'], array( $this, 'settings_section' ), $this->parent->_token . '_settings' );

				foreach ( $data['fields'] as $field ) {

					// Validation callback for field
					$validation = '';
					if ( isset( $field['callback'] ) ) {
						$validation = $field['callback'];
					}

					// Register field
					$option_name = $this->base . $field['id'];
					register_setting( $this->parent->_token . '_settings', $option_name, $validation );

					// Add field to page
					add_settings_field( $field['id'], $field['label'], array( $this->parent->admin, 'display_field' ), $this->parent->_token . '_settings', $section, array( 'field' => $field, 'prefix' => $this->base ) );
				}

				if ( ! $current_section ) break;
			}
		}
	}

	public function settings_section ( $section ) {
		$html = '<p> ' . $this->settings[ $section['id'] ]['description'] . '</p>' . "\n";
		echo $html;
	}

	/**
	 * Load settings page content
	 * @return void
	 */
	public function settings_page () {

		// Build page HTML
		$html = '<div class="wrap" id="' . $this->parent->_token . '_settings">' . "\n";
			$html .= '<h2>' . __( 'Campus Explorer Plugin Settings' , 'campusexplorer' ) . '</h2>' . "\n";
			$html .= '<p>' . __( 'New to Campus Explorer? Learn about how to become a partner here: <a href="http://search.campusexplorer.com/partnership.html">http://search.campusexplorer.com/partnership.html</a>.' , 'campusexplorer' ) . '</p>' . "\n";
			$tab = '';
			if ( isset( $_GET['tab'] ) && $_GET['tab'] ) {
				$tab .= $_GET['tab'];
			}

			// Show page tabs
			if ( is_array( $this->settings ) && 1 < count( $this->settings ) ) {

				$html .= '<h2 class="nav-tab-wrapper">' . "\n";

				$c = 0;
				foreach ( $this->settings as $section => $data ) {

					// Set tab class
					$class = 'nav-tab';
					if ( ! isset( $_GET['tab'] ) ) {
						if ( 0 == $c ) {
							$class .= ' nav-tab-active';
						}
					} else {
						if ( isset( $_GET['tab'] ) && $section == $_GET['tab'] ) {
							$class .= ' nav-tab-active';
						}
					}

					// Set tab link
					$tab_link = add_query_arg( array( 'tab' => $section ) );
					if ( isset( $_GET['settings-updated'] ) ) {
						$tab_link = remove_query_arg( 'settings-updated', $tab_link );
					}

					// Output tab
					$html .= '<a href="' . $tab_link . '" class="' . esc_attr( $class ) . '">' . esc_html( $data['title'] ) . '</a>' . "\n";

					++$c;
				}

				$html .= '</h2>' . "\n";
			}

			$html .= '<form method="post" class="tab-' . $tab . '" action="options.php" enctype="multipart/form-data">' . "\n";

				// Get settings fields
				ob_start();
				settings_fields( $this->parent->_token . '_settings' );
				do_settings_sections( $this->parent->_token . '_settings' );
				$html .= ob_get_clean();
				// we don't want to save shortcode builder info
				if ($tab != 'shortcode_builder'){
					$html .= '<p class="submit">' . "\n";
						$html .= '<input type="hidden" name="tab" value="' . esc_attr( $tab ) . '" />' . "\n";
						$html .= '<input name="Submit" type="submit" class="button-primary" value="' . esc_attr( __( 'Save Settings' , 'campusexplorer' ) ) . '" />' . "\n";
					$html .= '</p>' . "\n";
				}
			$html .= '</form>' . "\n";
			if ($tab == 'shortcode_builder') {
				// add resulting shortcode
				$html .= '<table id="generated-shortcode" class="form-table"><tbody><tr><th scope="row">Your Shortcode</th><td><code>[campusexplorer]</code><span class="description">Copy and paste this into your posts and pages to embed the CampusExplorer Widget.</span></td></tr></tbody><table>';
			}
		$html .= '</div>' . "\n";

		echo $html;
	}


	/**
	 * Main campusexplorer_Settings Instance
	 *
	 * Ensures only one instance of campusexplorer_Settings is loaded or can be loaded.
	 *
	 * @since 1.0.0
	 * @static
	 * @see campusexplorer()
	 * @return Main campusexplorer_Settings instance
	 */
	public static function instance ( $parent ) {
		if ( is_null( self::$_instance ) ) {
			self::$_instance = new self( $parent );
		}
		return self::$_instance;
	} // End instance()

	/**
	 * Cloning is forbidden.
	 *
	 * @since 1.0.0
	 */
	public function __clone () {
		_doing_it_wrong( __FUNCTION__, __( 'Cheatin&#8217; huh?' ), $this->parent->_version );
	} // End __clone()

	/**
	 * Unserializing instances of this class is forbidden.
	 *
	 * @since 1.0.0
	 */
	public function __wakeup () {
		_doing_it_wrong( __FUNCTION__, __( 'Cheatin&#8217; huh?' ), $this->parent->_version );
	} // End __wakeup()

}
