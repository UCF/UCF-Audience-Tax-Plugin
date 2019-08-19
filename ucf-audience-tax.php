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

define( 'UCF_AUDIENCE__VERSION', '1.0.0' );

define( 'UCF_AUDIENCE__FILE', __FILE__ );
define( 'UCF_AUDIENCE__STATIC_URL', plugin_dir_url( UCF_AUDIENCE__FILE ) . '/static' );
define( 'UCF_AUDIENCE__CSS_URL', UCF_AUDIENCE__STATIC_URL . '/css' );
define( 'UCF_AUDIENCE__JS_URL', UCF_AUDIENCE__STATIC_URL . '/js' );

require_once 'admin/class-audience-config.php';
require_once 'admin/class-audience-admin.php';
require_once 'includes/class-audience-taxonomy.php';
require_once 'includes/class-audience-common.php';
require_once 'includes/class-audience-shortcodes.php';

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
		UCF_Audience_Common::add_default_terms();
		flush_rewrite_rules();
	}

	register_activation_hook( UCF_AUDIENCE__FILE, 'ucf_audience_activation' );
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

	register_deactivation_hook( UCF_AUDIENCE__FILE, 'ucf_audience_deactivation' );
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

		// Init actions
		add_action( 'init', array( 'UCF_Audience_Taxonomy', 'register' ), 10, 0 );
		add_action( 'init', array( 'UCF_Audience_Shortcodes', 'add_shortcodes' ), 10, 0 );

		// Content filters
		add_filter( 'the_content', array( 'UCF_Audience_Common', 'fix_shortcode_autop' ), 10, 1 );

		// Enqueue Assets
		add_action( 'admin_enqueue_scripts', array( 'UCF_Audience_Admin', 'admin_enqueue_scripts' ), 10, 0 );
	}

	add_action( 'plugins_loaded', 'ucf_audience_init', 10, 0 );
}
