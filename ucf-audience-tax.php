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

require_once 'includes/class-audience-taxonomy.php';

if ( ! function_exists( 'ucf_audience_activation' ) ) {
	/**
	 * Function that runs on plugin activation
	 * @author Jim Barnes
	 * @since 1.0.0
	 * @return void
	 */
	function ucf_audience_activation() {
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
		add_action( 'init', array( 'UCF_Audience_Taxonomy', 'register' ), 10, 0 );
	}

	add_action( 'plugins_loaded', 'ucf_audience_init', 10, 0 );
}
