<?php

	/**
	 * The admin-specific functionality of the plugin.
	 *
	 * @link       http://example.com
	 * @since      1.0.0
	 *
	 * @package    Wordpress DMN
	 * @subpackage Wordpress DMN/admin
	 */

	/**
	 * The admin-specific functionality of the plugin.
	 *
	 * Defines the plugin name, version, and two examples hooks for how to
	 * enqueue the admin-specific stylesheet and JavaScript.
	 *
	 * @package    Wordpress DMN
	 * @subpackage Wordpress DMN/admin
	 * @author     Josh Grierson <joshua.grierson@propcom.co.uk>
	 */
	class Wordpress_DMN_Admin {

		/**
		 * The ID of this plugin.
		 *
		 * @since    1.0.0
		 * @access   private
		 * @var      string    $Wordpress_DMN    The ID of this plugin.
		 */
		private $Wordpress_DMN;

		/**
		 * The version of this plugin.
		 *
		 * @since    1.0.0
		 * @access   private
		 * @var      string    $version    The current version of this plugin.
		 */
		private $version;

		/**
		 * The options for this plugin.
		 *
		 * @since    1.0.0
		 * @access   private
		 * @var      string    $options    The options for this plugin.
		 */
		private $options;

		/**
		 * Initialize the class and set its properties.
		 *
		 * @since    1.0.0
		 * @param      string    $plugin_name       The name of this plugin.
		 * @param      string    $version    The version of this plugin.
		 */
		public function __construct( $Wordpress_DMN, $version ) {

			$this->load_dependencies();

			$this->Wordpress_DMN = $Wordpress_DMN;
			$this->version = $version;

			$this->options = new Wordpress_DMN_Options();

		}

		public function load_dependencies() {

			require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/wp_dmn-exception.php';

			require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/api/wp_dmn-api.php';

			require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/wp_dmn-tester.php';

			require_once plugin_dir_path( dirname( __FILE__ ) ) . 'admin/wp_dmn-options.php';

			require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/api/wp_dmn-rest.php';

		}

		/**
		 * Register the stylesheets for the admin area.
		 *
		 * @since    1.0.0
		 */
		public function enqueue_styles() {

			/**
			 * This function is provided for demonstration purposes only.
			 *
			 * An instance of this class should be passed to the run() function
			 * defined in Plugin_Name_Loader as all of the hooks are defined
			 * in that particular class.
			 *
			 * The Plugin_Name_Loader will then create the relationship
			 * between the defined hooks and the functions defined in this
			 * class.
			 */

			wp_enqueue_style( $this->Wordpress_DMN, plugin_dir_url( __FILE__ ) . 'css/wp_dmn-admin.css', array(), $this->version, 'all' );

		}

		/**
		 * Register the JavaScript for the admin area.
		 *
		 * @since    1.0.0
		 */
		public function enqueue_scripts() {

			/**
			 * This function is provided for demonstration purposes only.
			 *
			 * An instance of this class should be passed to the run() function
			 * defined in Plugin_Name_Loader as all of the hooks are defined
			 * in that particular class.
			 *
			 * The Plugin_Name_Loader will then create the relationship
			 * between the defined hooks and the functions defined in this
			 * class.
			 */

			wp_enqueue_script( $this->Wordpress_DMN, plugin_dir_url( __FILE__ ) . 'js/wp_dmn-admin.js', array( 'jquery' ), $this->version, false );

		}

	}
