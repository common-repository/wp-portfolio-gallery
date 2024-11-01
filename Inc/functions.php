<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/*
 * @version       1.0.0
 * @package       JLT_WP_Portfolio
 * @license       Copyright JLT_WP_Portfolio
 */

if ( ! function_exists( 'jlt_wp_portfolio_option' ) ) {
	/**
	 * Get setting database option
	 *
	 * @param string $section default section name jlt_wp_portfolio_general .
	 * @param string $key .
	 * @param string $default .
	 *
	 * @return string
	 */
	function jlt_wp_portfolio_option( $section = 'jlt_wp_portfolio_general', $key = '', $default = '' ) {
		$settings = get_option( $section );

		return isset( $settings[ $key ] ) ? $settings[ $key ] : $default;
	}
}

if ( ! function_exists( 'jlt_wp_portfolio_exclude_pages' ) ) {
	/**
	 * Get exclude pages setting option data
	 *
	 * @return string|array
	 *
	 * @version 1.0.0
	 */
	function jlt_wp_portfolio_exclude_pages() {
		return jlt_wp_portfolio_option( 'jlt_wp_portfolio_triggers', 'exclude_pages', array() );
	}
}

if ( ! function_exists( 'jlt_wp_portfolio_exclude_pages' ) ) {
	/**
	 * Get exclude pages except setting option data
	 *
	 * @return string|array
	 *
	 * @version 1.0.0
	 */
	function jlt_wp_portfolio_exclude_pages_except() {
		return jlt_wp_portfolio_option( 'jlt_wp_portfolio_triggers', 'exclude_pages_except', array() );
	}
}