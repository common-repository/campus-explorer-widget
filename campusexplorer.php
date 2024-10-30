<?php
/**
 * Plugin Name: Campus Explorer Widget
 * Plugin URI:
 * Description: Help your website users find their ideal college, while you earn a commision.
 * Author: Campus Explorer
 * Version: 1.4
 * Requires at least: 4.2
 * Author URI: https://www.campusexplorer.com
 * License: GPLv2 or later
 * Text Domain: campusexplorer
 * Domain Path:
 *
 * Copyright (C) 2015 - 2016
 *
 */

if ( ! defined( 'ABSPATH' ) ) exit;

// Load plugin class files
require_once( 'includes/class-campusexplorer.php' );
require_once( 'includes/class-campusexplorer-settings.php' );

// Load plugin libraries
require_once( 'includes/lib/class-campusexplorer-admin-api.php' );
require_once( 'includes/lib/class-campusexplorer-widget.php' );
require_once( 'includes/lib/class-campusexplorer-shortcode.php' );

/**
 * Returns the main instance of campusexplorer to prevent the need to use globals.
 *
 * @since  1.0.0
 * @return object campusexplorer
 */
function campusexplorer () {
	$instance = campusexplorer::instance( __FILE__, '1.0.0' );

	if ( is_null( $instance->settings ) ) {
		$instance->settings = campusexplorer_Settings::instance( $instance );
	}

	return $instance;
}

campusexplorer();
