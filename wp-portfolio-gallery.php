<?php
/**
 * Plugin Name: WP Portfolio Gallery
 * Plugin URI:  https://jeweltheme.com
 * Description: WP Portfolio Gallery is awesome Filterable Portfolio Gallery
 * Version:     1.2.4
 * Author:      Jewel Theme
 * Author URI:  https://jeweltheme.com
 * Text Domain: wp-portfolio-gallery
 * Domain Path: languages/
 * License:     GPLv3 or later
 * License URI: https://www.gnu.org/licenses/gpl-3.0.html
 *
 * @package wp-portfolio-gallery
 */

/*
 * don't call the file directly
 */
if ( ! defined( 'ABSPATH' ) ) {
	wp_die( esc_html__( 'You can\'t access this page', 'wp-portfolio-gallery' ) );
}

$jlt_wp_portfolio_plugin_data = get_file_data(
	__FILE__,
	array(
		'Version'     => 'Version',
		'Plugin Name' => 'Plugin Name',
		'Author'      => 'Author',
		'Description' => 'Description',
		'Plugin URI'  => 'Plugin URI',
	),
	false
);

// Define Constants.
if ( ! defined( 'JLTWPFOLIO' ) ) {
	define( 'JLTWPFOLIO', $jlt_wp_portfolio_plugin_data['Plugin Name'] );
}

if ( ! defined( 'JLTWPFOLIO_VER' ) ) {
	define( 'JLTWPFOLIO_VER', $jlt_wp_portfolio_plugin_data['Version'] );
}

if ( ! defined( 'JLTWPFOLIO_AUTHOR' ) ) {
	define( 'JLTWPFOLIO_AUTHOR', $jlt_wp_portfolio_plugin_data['Author'] );
}

if ( ! defined( 'JLTWPFOLIO_DESC' ) ) {
	define( 'JLTWPFOLIO_DESC', $jlt_wp_portfolio_plugin_data['Author'] );
}

if ( ! defined( 'JLTWPFOLIO_URI' ) ) {
	define( 'JLTWPFOLIO_URI', $jlt_wp_portfolio_plugin_data['Plugin URI'] );
}

if ( ! defined( 'JLTWPFOLIO_DIR' ) ) {
	define( 'JLTWPFOLIO_DIR', __DIR__ );
}

if ( ! defined( 'JLTWPFOLIO_FILE' ) ) {
	define( 'JLTWPFOLIO_FILE', __FILE__ );
}

if ( ! defined( 'JLTWPFOLIO_SLUG' ) ) {
	define( 'JLTWPFOLIO_SLUG', dirname( plugin_basename( __FILE__ ) ) );
}

if ( ! defined( 'JLTWPFOLIO_BASE' ) ) {
	define( 'JLTWPFOLIO_BASE', plugin_basename( __FILE__ ) );
}

if ( ! defined( 'JLTWPFOLIO_PATH' ) ) {
	define( 'JLTWPFOLIO_PATH', trailingslashit( plugin_dir_path( __FILE__ ) ) );
}

if ( ! defined( 'JLTWPFOLIO_URL' ) ) {
	define( 'JLTWPFOLIO_URL', trailingslashit( plugins_url( '/', __FILE__ ) ) );
}

if ( ! defined( 'JLTWPFOLIO_INC' ) ) {
	define( 'JLTWPFOLIO_INC', JLTWPFOLIO_PATH . '/Inc/' );
}

if ( ! defined( 'JLTWPFOLIO_LIBS' ) ) {
	define( 'JLTWPFOLIO_LIBS', JLTWPFOLIO_PATH . 'Libs' );
}

if ( ! defined( 'JLTWPFOLIO_ASSETS' ) ) {
	define( 'JLTWPFOLIO_ASSETS', JLTWPFOLIO_URL . 'assets/' );
}

if ( ! defined( 'JLTWPFOLIO_IMAGES' ) ) {
	define( 'JLTWPFOLIO_IMAGES', JLTWPFOLIO_ASSETS . 'images' );
}

if ( ! class_exists( '\\JLTWPFOLIO\\JLT_WP_Portfolio' ) ) {
	// Autoload Files.
	include_once JLTWPFOLIO_DIR . '/vendor/autoload.php';
	// Instantiate JLT_WP_Portfolio Class.
	include_once JLTWPFOLIO_DIR . '/class-wp-portfolio-gallery.php';
}