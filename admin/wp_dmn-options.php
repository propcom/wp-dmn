<?

	/*
	 * Plugin Name: Wordpress DMN
	 * Version: 1.0.0
	 * Author: Joshua Grierson
	 * Description: This plugin allows you to link your DMN Console within Wordpress.
	 */

	class Wordpress_DMN_Options {

		public $options;

		public static function get_option($set, $property){

			try {

				$option = get_option('prop_dmn_'.$set);

				if(isset($option[$property]) && $option[$property] !== '') {

					return $option[$property];

				} else {

					return false;

				}

			} catch (Exception $e) {}

		}

		public static function print_option($set, $property){

			try {

				$option = get_option('prop_dmn_'.$set);

				if(isset($option[$property])) {

					echo $option[$property];

				} else {

					return false;

				}

			} catch (Exception $e) {}

		}

		function __construct() {

			if ( is_admin() ) {

				add_action( 'admin_menu', [ $this, 'create_menu' ] );
				add_action( 'admin_init', [ $this, 'register_settings' ] );
				add_action( 'admin_init', [ $this, 'define_settings' ] );

			}

		}

		function create_menu() {

			add_menu_page(

				'DMN Manager',
				'DMN',
				'administrator',
				'dmn-manager',
				[ $this, 'render_page' ],
				'dashicons-clock', 2

			);

		}

		function render_page() {

			$this->options = get_option( 'prop_dmn' ); ?>

			<div class="wrap">
				<h1>Propeller's DMN Widget Manager</h1>
				<form method="post" action="options.php">
					<?
						settings_fields( 'propeller_dmn' );
						do_settings_sections( 'dmn-manager' );
						submit_button();
					?>
				</form>
				<? DMN_Api_Tester::forge()->test(); ?>
			</div>

			<?

		}

		function section_text() {

			print 'Enter your site settings below:';

		}

		function register_settings() {

			register_setting(

				'propeller_dmn',
				'prop_dmn'

			);

		}

		function define_settings() {

			/**
			 * @desc Manager Settings
			 */

			add_settings_section(

				'dmn_settings',
				'DMN Settings',
				[ $this, 'print_section_info' ],
				'dmn-manager'

			);

			add_settings_field(

				'uid',
				'DMN Unique Id',
				[ $this, 'add_field' ],
				'dmn-manager',
				'dmn_settings',
				[
					'name'    => 'uid',
					'type'    => 'text',
					'setting' => 'dmn',
					'note' => 'Provide your DMN Unique Id',
				]

			);

			add_settings_field(

				'api_key',
				'DMN API Key',
				[ $this, 'add_field' ],
				'dmn-manager',
				'dmn_settings',
				[
					'name'    => 'api_key',
					'type'    => 'text',
					'setting' => 'dmn',
					'note' => 'Provide you DMN API Key',
				]

			);

			add_settings_field(

				'venue_id',
				'DMN Venue Id\'s',
				[ $this, 'add_field' ],
				'dmn-manager',
				'dmn_settings',
				[
					'name'    => 'venue_id',
					'type'    => 'textarea',
					'setting' => 'dmn',
					'rows' => '3',
					'cols' => '50',
					'note' => 'Provide you DMN Venue Id\'s put each one on a newline and provide a venue name seperated by colon so [venue_name:venue_id],<br> this is required to start your custom widget',
				]

			);

		}

		function add_field( array $args ) {

			switch ( $args['type'] ) {

				case 'textarea' :

					printf(

						'<textarea id="' . $args['name'] . '" name="prop_' . $args['setting'] . '[' . $args['name'] . ']" rows="' . $args['rows'] . '" cols="' . $args['cols'] . '">%s</textarea>',
						isset( $this->options[ $args['name'] ] ) ? esc_attr( $this->options[ $args['name'] ] ) : ''

					);

					if ( isset( $args['note'] ) ) {

						print(

							'<p class="description">' . $args['note'] . '</p>'

						);

					}

					break;

				default :

					printf(

						'<input type="' . $args['type'] . '" id="' . $args['name'] . '" name="prop_' . $args['setting'] . '[' . $args['name'] . ']" value="%s" class="regular-text" />',
						isset( $this->options[ $args['name'] ] ) ? esc_attr( $this->options[ $args['name'] ] ) : ''

					);

					if ( isset( $args['note'] ) ) {

						print(

							'<p class="description">' . $args['note'] . '</p>'

						);

					}

					break;

			}

		}

		function print_section_info( $section ) {

			print 'Please enter your '.$section['title'].' below:';

		}

	}
