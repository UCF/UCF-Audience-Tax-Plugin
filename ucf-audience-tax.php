<?php
/*
Plugin Name: UCF Audience Taxonomy
Description: Provides the Audience taxonomy for WordPress.
Version: 1.0.0
Author: UCF Web Communications
License: GPL3
GitHub Plugin URI: UCF/UCF-Audience-Tax-Plugin
*/

if ( ! defined( 'WPINC' ) ) {
    die;
}

define( 'UCF_AUDIENCE__FILE', __FILE__ );

require_once 'admin/class-audience-config.php';
require_once 'includes/class-audience-taxonomy.php';

if ( ! function_exists( 'ucf_audience_activation' ) ) {
	/**
	 * Function that runs on plugin activation
	 * @author Jim Barnes
	 * @since 1.0.0
	 * @return void
	 */
	function ucf_audience_activation() {
		UCF_Audience_Config::add_options();
		UCF_Audience_Taxonomy::register();
		flush_rewrite_rules();
	}

	register_activation_hook( 'ucf_audience_activation', UCF_AUDIENCE__FILE );
}

if ( ! function_exists( 'ucf_audience_deactivation' ) ) {
	/**
	 * Function that runs on plugin deactivation
	 * @author Jim Barnes
	 * @since 1.0.0
	 * @return void
	 */
	function ucf_audience_deactivation() {
		UCF_Audience_Config::delete_options();
		flush_rewrite_rules();
	}
}

if ( ! function_exists( 'ucf_audience_init' ) ) {
	/**
	 * Function that runs after plugins are loaded.
	 * @author Jim Barnes
	 * @since 1.0.0
	 * @return void
	 */
	function ucf_audience_init() {
		// Add admin menu item
		add_action( 'admin_init', array( 'UCF_Audience_Config', 'settings_init' ) );
		add_action( 'admin_menu', array( 'UCF_Audience_Config', 'add_options_page' ) );

		add_action( 'init', array( 'UCF_Audience_Taxonomy', 'register' ), 10, 0 );
	}

	add_action( 'plugins_loaded', 'ucf_audience_init', 10, 0 );
}
