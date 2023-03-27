<?php

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) exit;

if ( ! class_exists( 'Ie_Exlink' ) ) :

	/**
	 * Main Ie_Exlink Class.
	 *
	 * @package		IELINK
	 * @subpackage	Classes/Ie_Exlink
	 * @since		1.0.0
	 * @author		99839
	 */
	final class Ie_Exlink {

		/**
		 * The real instance
		 *
		 * @access	private
		 * @since	1.0.0
		 * @var		object|Ie_Exlink
		 */
		private static $instance;

		/**
		 * IELINK helpers object.
		 *
		 * @access	public
		 * @since	1.0.0
		 * @var		object|Ie_Exlink_Helpers
		 */
		public $helpers;

		/**
		 * IELINK settings object.
		 *
		 * @access	public
		 * @since	1.0.0
		 * @var		object|Ie_Exlink_Settings
		 */
		public $settings;

		/**
		 * Throw error on object clone.
		 *
		 * Cloning instances of the class is forbidden.
		 *
		 * @access	public
		 * @since	1.0.0
		 * @return	void
		 */
		public function __clone() {
			_doing_it_wrong( __FUNCTION__, __( 'You are not allowed to clone this class.', 'ie-exlink' ), '1.0.0' );
		}

		/**
		 * Disable unserializing of the class.
		 *
		 * @access	public
		 * @since	1.0.0
		 * @return	void
		 */
		public function __wakeup() {
			_doing_it_wrong( __FUNCTION__, __( 'You are not allowed to unserialize this class.', 'ie-exlink' ), '1.0.0' );
		}

		/**
		 * Main Ie_Exlink Instance.
		 *
		 * Insures that only one instance of Ie_Exlink exists in memory at any one
		 * time. Also prevents needing to define globals all over the place.
		 *
		 * @access		public
		 * @since		1.0.0
		 * @static
		 * @return		object|Ie_Exlink	The one true Ie_Exlink
		 */
		public static function instance() {
			if ( ! isset( self::$instance ) && ! ( self::$instance instanceof Ie_Exlink ) ) {
				self::$instance					= new Ie_Exlink;
				self::$instance->base_hooks();
				self::$instance->includes();
				self::$instance->helpers		= new Ie_Exlink_Helpers();
				self::$instance->settings		= new Ie_Exlink_Settings();

				//Fire the plugin logic
				new Ie_Exlink_Run();

				/**
				 * Fire a custom action to allow dependencies
				 * after the successful plugin setup
				 */
				do_action( 'IELINK/plugin_loaded' );
			}

			return self::$instance;
		}

		/**
		 * Include required files.
		 *
		 * @access  private
		 * @since   1.0.0
		 * @return  void
		 */
		private function includes() {
			require_once IELINK_PLUGIN_DIR . 'core/includes/classes/class-ie-exlink-helpers.php';
			require_once IELINK_PLUGIN_DIR . 'core/includes/classes/class-ie-exlink_settings_api.php';
			require_once IELINK_PLUGIN_DIR . 'core/includes/classes/class-ie-exlink-settings.php';

			require_once IELINK_PLUGIN_DIR . 'core/includes/classes/class-ie-exlink-run.php';
		}

		/**
		 * Add base hooks for the core functionality
		 *
		 * @access  private
		 * @since   1.0.0
		 * @return  void
		 */
		private function base_hooks() {
			add_action( 'plugins_loaded', array( self::$instance, 'load_textdomain' ) );
		}

		/**
		 * Loads the plugin language files.
		 *
		 * @access  public
		 * @since   1.0.0
		 * @return  void
		 */
		public function load_textdomain() {
			load_plugin_textdomain( 'ie-exlink', FALSE, dirname( plugin_basename( IELINK_PLUGIN_FILE ) ) . '/languages/' );
		}

	}

endif; // End if class_exists check.