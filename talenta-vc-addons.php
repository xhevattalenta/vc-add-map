<?php
/**
 * Plugin Name: Talenta Map Visual Composer Addons
 * Plugin URI: https://talenta.mk
 * Description: Extra elements for Visual Composer. It was built for Adelholding.com site.
 * Version: 1.0.0
 * Author: Xhevat Ziberi
 * Author URI: http://batlab.tech
 * License: GPL2+
 * Text Domain: talenta
 * Domain Path: /lang/
 */
if ( ! defined( 'ABSPATH' ) ) {
	die( '-1' );
}

if ( ! defined( 'TALENTA_ADDONS_DIR' ) ) {
	define( 'TALENTA_ADDONS_DIR', plugin_dir_path( __FILE__ ) );
}

if ( ! defined( 'TALENTA_ADDONS_URL' ) ) {
	define( 'TALENTA_ADDONS_URL', plugin_dir_url( __FILE__ ) );
}

require_once TALENTA_ADDONS_DIR . '/inc/visual-composer.php';
require_once TALENTA_ADDONS_DIR . '/inc/shortcodes.php';

/**
 * Init
 */
function truckpress_vc_addons_init() {
	load_plugin_textdomain( 'talenta', false, dirname( plugin_basename( __FILE__ ) ) . '/lang' );

	new Talenta_VC;
	new Talenta_Shortcodes;

}

add_action( 'after_setup_theme', 'truckpress_vc_addons_init' );
