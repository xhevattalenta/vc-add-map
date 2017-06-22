<?php
/**
 * Custom functions for Visual Composer
 *
 * @package Talenta
 * @subpackage Visual Composer
 */

if ( ! function_exists( 'is_plugin_active' ) ) {
	require_once( ABSPATH . 'wp-admin/includes/plugin.php' );
}

/**
 * Class Talenta_VC
 */
class Talenta_VC {

	/**
	 * List of available icons
	 *
	 * @var array
	 */
	public $icons;

	/**
	 * Construction
	 */
	function __construct() {
		// Stop if VC is not installed
		if ( ! is_plugin_active( 'js_composer/js_composer.php' ) ) {
			return false;
		}

		add_action( 'vc_before_init', array( $this, 'map_shortcodes' ) );
	}

	/**
	 * Add new params or add new shortcode to VC
	 *
	 * @return void
	 */
	function map_shortcodes() {

		vc_map( array(
			'name'            => esc_html__( 'Google MultiMaps', 'truckpress' ),
			'base'            => 'multimaps',
			'as_parent'       => array( 'only' => 'gmap' ),
			'content_element' => true,
			'params'          => array(
				array(
					'type'        => 'attach_image',
					'holder'      => 'div',
					'heading'     => esc_html__( 'Marker', 'truckpress' ),
					'param_name'  => 'marker',
					'value'       => '',
					'description' => esc_html__( 'Select an image from media library', 'truckpress' ),
				),
				array(
					'type'        => 'colorpicker',
					'heading'     => esc_html__( 'Background Color Map', 'truckpress' ),
					'param_name'  => 'bg_color',
					'value'       => ''
				),
				array(
					'type'       => 'textfield',
					'holder'     => 'div',
					'heading'    => esc_html__( 'Width(px)', 'truckpress' ),
					'param_name' => 'width',
					'value'      => '',
				),
				array(
					'type'       => 'textfield',
					'holder'     => 'div',
					'heading'    => esc_html__( 'Height(px)', 'truckpress' ),
					'param_name' => 'height',
					'value'      => '450',
				),
				array(
					'type'       => 'textfield',
					'holder'     => 'div',
					'heading'    => esc_html__( 'Zoom', 'truckpress' ),
					'param_name' => 'zoom',
					'value'      => '13',
				),
				array(
					'type'        => 'textfield',
					'holder'      => 'div',
					'heading'     => esc_html__( 'Extra class name', 'truckpress' ),
					'param_name'  => 'el_class',
					'description' => esc_html__( 'If you wish to style particular content element differently, then use this field to add a class name and then refer to it in your css file.', 'truckpress' ),
				),
			),
			'js_view'         => 'VcColumnView'
		) );
		
		vc_map( array(
			'name'            => esc_html__( 'Google Map', 'truckpress' ),
			'base'            => 'gmap',
			'content_element' => true,
			'as_child'        => array( 'only' => 'multimaps' ),
			'params'          => array(
				array(
					'type'       => 'textarea',
					'holder'     => 'div',
					'heading'    => esc_html__( 'Address', 'truckpress' ),
					'param_name' => 'address',
					'value'      => '',
				),
				array(
					'type'       => 'textarea_html',
					'holder'     => 'div',
					'heading'    => esc_html__( 'Content', 'truckpress' ),
					'param_name' => 'content',
					'value'      => '',
				),
			)
		) );

	}

	/**
	 * Get available image sizes
	 *
	 * @return string
	 */
	function image_sizes() {
		$output                                            = array();
		$output[ esc_html__( 'Full Size', 'truckpress' ) ] = 'full';
		foreach ( $this->get_image_sizes() as $name => $size ) {
			$output[ ucfirst( $name ) . ' (' . $size['width'] . 'x' . $size['height'] . ')' ] = $name;
		}

		return $output;
	}
}


if ( class_exists( 'WPBakeryShortCodesContainer' ) ) {
	class WPBakeryShortCode_multimaps extends WPBakeryShortCodesContainer {
	}
}
if ( class_exists( 'WPBakeryShortCode' ) ) {
	class WPBakeryShortCode_gmap extends WPBakeryShortCode {
	}
}
