<?php
namespace JLTWPFOLIO;

use JLTWPFOLIO\Libs\Assets;
use JLTWPFOLIO\Libs\Helper;
use JLTWPFOLIO\Libs\Featured;
use JLTWPFOLIO\Inc\Classes\Recommended_Plugins;
use JLTWPFOLIO\Inc\Classes\Notifications\Notifications;
use JLTWPFOLIO\Inc\Classes\Pro_Upgrade;
use JLTWPFOLIO\Inc\Classes\Row_Links;
use JLTWPFOLIO\Inc\Classes\Upgrade_Plugin;
use JLTWPFOLIO\Inc\Classes\Feedback;
use JLTWPFOLIO\Inc\Classes\WP_Fortfolio_Gallery;

/**
 * Main Class
 *
 * @WP Portfolio Gallery
 * Jewel Theme <support@jeweltheme.com>
 * @version     1.2.4
 */

// No, Direct access Sir !!!
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * JLT_WP_Portfolio Class
 */
if ( ! class_exists( '\JLTWPFOLIO\JLT_WP_Portfolio' ) ) {

	/**
	 * Class: JLT_WP_Portfolio
	 */
	final class JLT_WP_Portfolio {

		const VERSION            = JLTWPFOLIO_VER;
		private static $instance = null;

		/**
		 * what we collect construct method
		 *
		 * @author Jewel Theme <support@jeweltheme.com>
		 */
		public function __construct() {
			$this->includes();
			add_action( 'plugins_loaded', array( $this, 'jlt_wp_portfolio_plugins_loaded' ), 999 );
			// Body Class.
			add_filter( 'admin_body_class', array( $this, 'jlt_wp_portfolio_body_class' ) );
			// This should run earlier .
			// add_action( 'plugins_loaded', [ $this, 'jlt_wp_portfolio_maybe_run_upgrades' ], -100 ); .
		}

		/**
		 * plugins_loaded method
		 *
		 * @author Jewel Theme <support@jeweltheme.com>
		 */
		public function jlt_wp_portfolio_plugins_loaded() {
			$this->jlt_wp_portfolio_activate();
		}

		/**
		 * Version Key
		 *
		 * @author Jewel Theme <support@jeweltheme.com>
		 */
		public static function plugin_version_key() {
			return Helper::jlt_wp_portfolio_slug_cleanup() . '_version';
		}

		/**
		 * Activation Hook
		 *
		 * @author Jewel Theme <support@jeweltheme.com>
		 */
		public static function jlt_wp_portfolio_activate() {
			global $wpdb;

			$current_jlt_wp_portfolio_version = get_option( self::plugin_version_key(), null );

			if ( get_option( 'jlt_wp_portfolio_activation_time' ) === false ) {
				update_option( 'jlt_wp_portfolio_activation_time', strtotime( 'now' ) );
			}

			if ( is_null( $current_jlt_wp_portfolio_version ) ) {
				update_option( self::plugin_version_key(), self::VERSION );
			}


			$allowed = get_option( Helper::jlt_wp_portfolio_slug_cleanup() . '_allow_tracking', 'no' );

			// if it wasn't allowed before, do nothing .
			if ( 'yes' !== $allowed ) {
				return;
			}
			// re-schedule and delete the last sent time so we could force send again .
			$hook_name = Helper::jlt_wp_portfolio_slug_cleanup() . '_tracker_send_event';
			if ( ! wp_next_scheduled( $hook_name ) ) {
				wp_schedule_event( time(), 'weekly', $hook_name );
			}		
		}


		/**
		 * Add Body Class
		 *
		 * @param [type] $classes .
		 *
		 * @author Jewel Theme <support@jeweltheme.com>
		 */
		public function jlt_wp_portfolio_body_class( $classes ) {
			$classes .= ' wp-portfolio-gallery ';
			return $classes;
		}

		/**
		 * Run Upgrader Class
		 *
		 * @return void
		 */
		public function jlt_wp_portfolio_maybe_run_upgrades() {
			if ( ! is_admin() && ! current_user_can( 'manage_options' ) ) {
				return;
			}

			// Run Upgrader .
			$upgrade = new Upgrade_Plugin();

			// Need to work on Upgrade Class .
			if ( $upgrade->if_updates_available() ) {
				$upgrade->run_updates();
			}
		}

		/**
		 * Include methods
		 *
		 * @author Jewel Theme <support@jeweltheme.com>
		 */
		public function includes() {
			new Assets();
			new Recommended_Plugins();
			new Row_Links();
			new Pro_Upgrade();
			new Notifications();
			new Feedback();
			new WP_Fortfolio_Gallery();
		}


		/**
		 * Initialization
		 *
		 * @author Jewel Theme <support@jeweltheme.com>
		 */
		public function jlt_wp_portfolio_init() {
			$this->jlt_wp_portfolio_load_textdomain();
			new Featured();
		}


		/**
		 * Text Domain
		 *
		 * @author Jewel Theme <support@jeweltheme.com>
		 */
		public function jlt_wp_portfolio_load_textdomain() {
			$domain = 'wp-portfolio-gallery';
			$locale = apply_filters( 'jlt_wp_portfolio_plugin_locale', get_locale(), $domain );

			load_textdomain( $domain, WP_LANG_DIR . '/' . $domain . '/' . $domain . '-' . $locale . '.mo' );
			load_plugin_textdomain( $domain, false, dirname( JLTWPFOLIO_BASE ) . '/languages/' );
		}




		/**
		 * Returns the singleton instance of the class.
		 */
		public static function get_instance() {
			if ( ! isset( self::$instance ) && ! ( self::$instance instanceof JLT_WP_Portfolio ) ) {
				self::$instance = new JLT_WP_Portfolio();
				self::$instance->jlt_wp_portfolio_init();
			}

			return self::$instance;
		}
	}

	// Get Instant of JLT_WP_Portfolio Class .
	JLT_WP_Portfolio::get_instance();
}