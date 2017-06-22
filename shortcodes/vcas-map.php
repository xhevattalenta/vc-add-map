<?php
/**
 * File for creating Title Component
 *
 */
 
/**
* Load JS in header
*
* @since 1.0.0
*
* @return void
*/
;
function header_files() {
	wp_enqueue_style('vcadel-ammap-css', plugin_dir_url( __FILE__ ) . '../ammap/ammap.css', array(), '1.0.0');
	wp_enqueue_script('vcadel-ammap-js', plugin_dir_url( __FILE__ ) . '../ammap/ammap.js', array(), '1.0.0');
	wp_enqueue_script('vcadel-macedonia-js', plugin_dir_url( __FILE__ ) . '../ammap/maps/js/macedoniaHigh.js', array(), '1.0.0');
	wp_enqueue_script('vcadel-theme-js', plugin_dir_url( __FILE__ ) . '../ammap/themes/black.js', array(), '1.0.0');
}
add_action('wp_enqueue_scripts', 'header_files');

/*
function vc_adel_enqueue_style() {
	wp_enqueue_style( 'core', 'style.css', false ); 
}

function vc_adel_enqueue_script() {
	wp_enqueue_script( 'my-js', 'filename.js', false );
}

add_action( 'wp_enqueue_scripts', 'themeslug_enqueue_style' );
add_action( 'wp_enqueue_scripts', 'themeslug_enqueue_script' );
*/
/**
 * Function for Adding Title Component on vc_init hook
 *
 * @param void
 *
 * @return void
 */
function vcas_component_map() {

	vc_map( array(
		"name" => __("Your Map", "adel_holding"),
		"category"	=> __( "Adel Map" ),
		"base" => "your_map",
		"as_parent" => array('only' => 'single_project'), // Use only|except attributes to limit child shortcodes (separate multiple values with comma)
		"content_element" => true,
		"show_settings_on_create" => false,
		"is_container" => true,
		"params" => array(
			// add params same as with any other content element
			array(
				"type" => "textfield",
				"heading" => __("Extra class name", "adel_holding"),
				"param_name" => "el_class",
				"description" => __("If you wish to style particular content element differently, then use this field to add a class name and then refer to it in your css file.", "adel_holding")
			)
		),
		"js_view" => 'VcColumnView'
	) );
	vc_map( array(
		"name" => __("Single Project", "adel_holding"),
		"base" => "single_project",
		"content_element" => true,
		"as_child" => array('only' => 'your_map'), // Use only|except attributes to limit parent (separate multiple values with comma)
		"params" => array(
			// add params same as with any other content element
			array(
				"type" => "textfield",
				"heading" => __("Project name", "adel_holding"),
				"param_name" => "name",
				"description" => __("Insert project name. Ex: Skopje", "adel_holding")
			),
			array(
				"type" => "textfield",
				"heading" => __("Latitude", "adel_holding"),
				"param_name" => "latitude",
				"description" => __("Insert latitude. Ex: 41.997682", "adel_holding")
			),
			array(
				"type" => "textfield",
				"heading" => __("Longitude", "adel_holding"),
				"param_name" => "longitude",
				"description" => __("Insert longitude. Ex: 21.428838", "adel_holding")
			),
			array(
				'type' => 'dropdown',
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
	//Your "container" content element should extend WPBakeryShortCodesContainer class to inherit all required functionality
	if ( class_exists( 'WPBakeryShortCodesContainer' ) ) {
		class WPBakeryShortCode_Your_Map extends WPBakeryShortCodesContainer {
		}
	}
	if ( class_exists( 'WPBakeryShortCode' ) ) {
		class WPBakeryShortCode_Single_Project extends WPBakeryShortCode {
		}
	}
}
add_action( 'vc_before_init', 'vcas_component_map' );

/**
 * Function for displaying Title functionality
 *
 * @param array $atts    - the attributes of shortcode
 * @param string $content - the content between the shortcodes tags
 *
 * @return string $html - the HTML content for this shortcode.
 */
function vcas_map_function( $atts, $content ) {
	$atts = shortcode_atts(
		array(
			'title' => __( 'This is the custom shortcode' ),
			'title_color' => '#000000',
		), $atts, 'vcas_title'
	);

	$html = '<h1 class="component title ' . $atts['style']. '" style="color: ' . $atts['title_color'] . '">'. $atts['title'] . '</h1>';
	return $html;
}
add_shortcode( 'vcas_title', 'vcas_map_function' );
