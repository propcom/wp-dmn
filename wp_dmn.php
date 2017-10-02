<?php

	/**
	 * The plugin bootstrap file
	 *
	 * This file is read by WordPress to generate the plugin information in the plugin
	 * admin area. This file also includes all of the dependencies used by the plugin,
	 * registers the activation and deactivation functions, and defines a function
	 * that starts the plugin.
	 *
	 * @link              https://github.com/propcom/wp_dmn
	 * @since             1.0.0
	 * @package           Wordpress DMN
	 *
	 * @wordpress-plugin
	 * Plugin Name:       WordPress DMN Plugin
	 * Plugin URI:        https://github.com/propcom/wp_dmn
	 * Description:       Connects wordpress with DMN
	 * Version:           1.1.6
	 * Author:            Josh Grierson
	 * Author URI:        https://github.com/propcom
	 * License:           GPL-2.0+
	 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
	 * Text Domain:       wp_dmn
	 * Domain Path:       /languages
	 */

	// If this file is called directly, abort.
	if ( ! defined( 'WPINC' ) ) {
		die;
	}

	function activate_Wordpress_DMN() {

		require_once plugin_dir_path( __FILE__ ) . 'includes/wp_dmn-activator.php';
		Wordpress_DMN_Activator::activate();

	}

	function deactivate_Wordpress_DMN() {

		require_once plugin_dir_path( __FILE__ ) . 'includes/wp_dmn-deactivator.php';
		Wordpress_DMN_Deactivator::deactivate();

	}

	register_activation_hook( __FILE__, 'activate_Wordpress_DMN' );
	register_deactivation_hook( __FILE__, 'deactivate_Wordpress_DMN' );

	require plugin_dir_path( __FILE__ ) . 'includes/wp_dmn.php';

	function run_Wordpress_DMN() {

		$plugin = new Wordpress_DMN();
		$plugin->run();

	}

	run_Wordpress_DMN();
