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
			'name'            => esc_html__( 'Ammap Map', 'talenta' ),
			"category"				=> __( "Adel Map" ),
			'base'            => 'ammap_map',
			'as_parent'       => array( 'only' => 'single_project' ),
			'content_element' => true,
			'params'          => array(
				array(
					'type'       => 'textfield',
					'heading'    => esc_html__( 'Map ID', 'talenta' ),
					'param_name' => 'map_id',
					'value'      => '',
				),
				array(
					'type'       => 'textfield',
					'holder'     => 'div',
					'heading'    => esc_html__( 'Map Title', 'talenta' ),
					'param_name' => 'big_title',
					'value'      => '',
				),
				array(
					'type'       => 'textfield',
					'holder'     => 'div',
					'heading'    => esc_html__( 'Map Subtitle', 'talenta' ),
					'param_name' => 'small_title',
					'value'      => '',
				),
				array(
					'type'        => 'colorpicker',
					'heading'     => esc_html__( 'Area color', 'talenta' ),
					'param_name'  => 'area_color',
					'value'       => '#d8854f'
				),
				array(
					'type'       => 'textfield',
					'holder'     => 'div',
					'heading'    => esc_html__( 'Minimum Bullet Size', 'talenta' ),
					'param_name' => 'minBulletSize',
					'value'      => '10',
				),
				array(
					'type'       => 'textfield',
					'holder'     => 'div',
					'heading'    => esc_html__( 'Max Bullet Size', 'talenta' ),
					'param_name' => 'maxBulletSize',
					'value'      => '50',
				)
			),
			'js_view'         => 'VcColumnView'
		) );

		vc_map( array(
			'name'            => esc_html__( 'Single Project', 'talenta' ),
			'base'            => 'single_project',
			'content_element' => true,
			'as_child'        => array( 'only' => 'ammap_map' ),
			'params'          => array(
				array(
					"type" => "textfield",
					'holder'     => 'div',
					"heading" => __("Project name", "adel_holding"),
					"param_name" => "name",
					'value'      => '',
					"description" => __("Insert project name. Ex: Skopje", "adel_holding")
				),
				array(
					"type" => "textfield",
					'holder'     => 'div',
					"heading" => __("Latitude", "adel_holding"),
					"param_name" => "latitude",
					'value'      => '',
					"description" => __("Insert latitude. Ex: 41.997682", "adel_holding")
				),
				array(
					"type" => "textfield",
					'holder'     => 'div',
					"heading" => __("Longitude", "adel_holding"),
					"param_name" => "longitude",
					'value'      => '',
					"description" => __("Insert longitude. Ex: 21.428838", "adel_holding")
				),
				array(
					'type' => 'dropdown',
					'holder'     => 'div',
					"heading" => __("Bubble Size", "adel_holding"),
					"param_name" => "value",
					'value' => array( 1,2,3,4,5,6,7,8,9,10 ),
					'description' => __( "Choose the size of the Project", "adel_holding" )
				),
				array(
					'type' => 'colorpicker',
					"heading" => __("Bubble Color", "adel_holding"),
					'param_name' => 'color',
					'value' => '#eea638',
					'description' => __( "Choose color for the project", "adel_holding" ),
				),
				array(
					"type" => "textarea_html",
					"holder" => "div",
					"class" => "",
					"heading" => __( "Project Description", "my-text-domain" ),
					"param_name" => "content", // Important: Only one textarea_html param per content element allowed and it should have "content" as a "param_name"
					"value" => __( "<p>Write here the project description.</p>", "adel_holding" ),
					"description" => __( "Enter your content.", "adel_holding" )
				 )
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
		$output[ esc_html__( 'Full Size', 'talenta' ) ] = 'full';
		foreach ( $this->get_image_sizes() as $name => $size ) {
			$output[ ucfirst( $name ) . ' (' . $size['width'] . 'x' . $size['height'] . ')' ] = $name;
		}

		return $output;
	}
}


if ( class_exists( 'WPBakeryShortCodesContainer' ) ) {
	class WPBakeryShortCode_ammap_map extends WPBakeryShortCodesContainer {
	}
}
if ( class_exists( 'WPBakeryShortCode' ) ) {
	class WPBakeryShortCode_single_project extends WPBakeryShortCode {
	}
}
