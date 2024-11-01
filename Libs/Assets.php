<?php
namespace JLTWPFOLIO\Libs;

// No, Direct access Sir !!!
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( ! class_exists( 'Assets' ) ) {

	/**
	 * Assets Class
	 *
	 * Jewel Theme <support@jeweltheme.com>
	 * @version     1.2.4
	 */
	class Assets {

		/**
		 * Constructor method
		 *
		 * @author Jewel Theme <support@jeweltheme.com>
		 */
		public function __construct() {
			add_action( 'wp_enqueue_scripts', array( $this, 'jlt_wp_portfolio_enqueue_scripts' ), 100 );
		}


		/**
		 * Get environment mode
		 *
		 * @author Jewel Theme <support@jeweltheme.com>
		 */
		public function get_mode() {
			return defined( 'WP_DEBUG' ) && WP_DEBUG ? 'development' : 'production';
		}

		/**
		 * Enqueue Scripts
		 *
		 * @method wp_enqueue_scripts()
		 */
		public function jlt_wp_portfolio_enqueue_scripts() {

			// CSS Files .
			wp_enqueue_style( 'wp-portfolio-gallery-frontend', JLTWPFOLIO_ASSETS . 'css/wp-portfolio-gallery-frontend.css', JLTWPFOLIO_VER, 'all' );

			// JS Files .
			wp_enqueue_script( 'wp-portfolio-gallery-frontend', JLTWPFOLIO_ASSETS . 'js/wp-portfolio-gallery-frontend.js', array( 'jquery' ), JLTWPFOLIO_VER, true );
			wp_enqueue_script('mixitup',  JLTWPFOLIO_ASSETS . 'js/jquery.mixitup.js', array( 'jquery' ), JLTWPFOLIO_VER, true );

			wp_register_script('jquery-mousewheel',  JLTWPFOLIO_ASSETS . 'js/jquery.mousewheel.pack.js' );
			wp_enqueue_script('jquery-mousewheel');

			wp_register_script('jquery-prettyPhoto-js',  JLTWPFOLIO_ASSETS . 'js/jquery.prettyPhoto.js' );
			wp_enqueue_script('jquery-prettyPhoto-js');

			wp_register_style('wp-portfolio-gallery', JLTWPFOLIO_ASSETS . 'css/wp-portfolio-gallery.css' );
			wp_enqueue_style('wp-portfolio-gallery');

			wp_register_style('wp-portfolio-gallery-animation', JLTWPFOLIO_ASSETS . 'css/animation.css' );
			wp_enqueue_style('wp-portfolio-gallery-animation');

			wp_register_style('jquery-prettyPhoto-css',  JLTWPFOLIO_ASSETS . 'css/prettyPhoto.css' );
			wp_enqueue_style('jquery-prettyPhoto-css');
		}
	}
}