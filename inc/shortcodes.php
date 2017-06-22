<?php

/**
 * Define theme shortcodes
 *
 * @package TruckPress
 */
class Talenta_Shortcodes {
    /**
     * Store variables for js
     *
     * @var array
     */
    public $l10n = array();


    /**
     * Construction
     *
     * @return Talenta_Shortcodes
     */
    function __construct() {
        $shortcodes = array(
            'single_project',
            'ammap_map'
        );

        foreach ($shortcodes as $shortcode) {
            add_shortcode($shortcode, array($this, $shortcode));
        }

        add_action('wp_enqueue_scripts', array($this, 'header'));
        add_action('wp_footer', array($this, 'footer'));
    }

    /**
     * Load custom js in footer
     *
     * @return void
     */
    public function footer() {
        wp_register_script('ammap', TALENTA_ADDONS_URL . '/ammap/ammap.jss', array(), '1.0.0');
        wp_register_script('macedonia', TALENTA_ADDONS_URL . '/ammap/maps/js/macedoniaHigh.js', array(), '1.0.0');
        wp_register_script('theme', TALENTA_ADDONS_URL . '/ammap/themes/black.js', array(), '1.0.0');
        wp_enqueue_script('theScript', TALENTA_ADDONS_URL . '/assets/js/theScript.js', array(), '1.0.0', true);
    }

    /**
     * Load JS in header
     *
     * @return void
     */
    public function header() {
        wp_enqueue_style('ammap', TALENTA_ADDONS_URL . '/ammap/ammap.css', array(), '1.0.0');
    }


    /**
     * Icon box tabs shortcode
     *
     * @param  array $atts
     * @param  string $content
     *
     * @return string
     */
    function ammap_map($atts, $content) {
        var_dump($atts);
        echo '<br>';
        $atts = shortcode_atts(
            array(
                'map_id'   => '',
                'big_title'   => '',
                'small_title'   => '',
                'area_color'   => '#d8854f',
                'minBulletSize'   => '10',
                'maxBulletSize'   => '50',

                'marker'   => '',
                'width'    => '',
                'bg_color' => '',
                'height'   => '450',
                'zoom'     => '13',
                'css'      => '',
            ), $atts
        );
        $html = '<div id="mapdiv" style="width: 100%; height: 600px;"></div>';


        $mapData = '[{
        	//"code": "SK",
        	"name": "Skopje",
        	"latitude": 41.997682,
        	"longitude": 21.428838,
        	"value": 3,
        	"color": "#eea638",
        	"description": "Write here the project description.",
        },  {
        	//"code": "TE",
        	"name": "Tetovo",
        	"latitude": 42.0069,
        	"longitude": 20.9715,
        	"value": 2,
        	"color": "#d8854f",
        	"description": "Write here the project description.",
        }]';

        $html .= '<script type="text/javascript">';
        $html .= 'document.write("Hello World!");';
        $html .= 'var mapData = ' . $mapData . ';';
        $html .= '</script>';
        return $html;
        /*
        $class = array(
            'tp-map-shortcode',
            $atts['css'],
        );

        $style = '';
        if ($atts['width']) {
            $unit = 'px';
            if (strpos($atts['width'], '%')) {
                $unit = '%;';
            }

            $atts['width'] = intval($atts['width']);
            $style .= 'width: ' . $atts['width'] . $unit;
        }
        if ($atts['height']) {
            $unit = 'px';
            if (strpos($atts['height'], '%')) {
                $unit = '%;';
            }

            $atts['height'] = intval($atts['height']);
            $style .= 'height: ' . $atts['height'] . $unit;
        }
        if ($atts['zoom']) {
            $atts['zoom'] = intval($atts['zoom']);
        }

        $id = uniqid('ta_map_');
        $html = sprintf(
            '<div class="%s"><div id="%s" class="truckpress-map" style="%s"></div></div>',
            implode(' ', $class),
            $id,
            $style
        );

        $this->maps = array();
        do_shortcode($content);

        if (empty($this->maps)) {
            return '';
        }

        $output = array();
        $total = count($this->maps);

        if (!$total) {
            return '';
        }

        $lats = array();
        $lng = array();
        $info = array();
        $i = 0;

        foreach ($this->maps as $index => $map) {

            $coordinates ="";
            $lats[] = '42.00';
            $lng[] = '42.00';
            $info[] = $map['content'];

            if (isset($coordinates['error'])) {
                return $coordinates['error'];
            }

            $i++;

        }

        $marker = '';
        if ($atts['marker']) {
            if (filter_var($atts['marker'], FILTER_VALIDATE_URL)) {
                $marker = $atts['marker'];
            } else {
                $attachment_image = wp_get_attachment_image_src(intval($atts['marker']), 'full');
                $marker = $attachment_image ? $attachment_image[0] : '';
            }
        }

        $bg_color = '#f0e246';


        $this->l10n['map'][$id] = array(
            'type'     => 'normal',
            'lat'      => $lats,
            'lng'      => $lng,
            'zoom'     => $atts['zoom'],
            'bg_color' => $bg_color,
            'marker'   => $marker,
            'height'   => $atts['height'],
            'info'     => $info,
            'number'   => $i
        );

        return $html;*/
    }

    /**
     * Icon box tab shortcode
     *
     * @param  array $atts
     * @param  string $content
     *
     * @return string
     */
    function single_project($atts, $content) {
        var_dump($atts);
        $atts = shortcode_atts(array(
            'name' => '',
            'latitude' => '',
            'longitude' => '',
            'value' => array( 1,2,3,4,5,6,7,8,9,10 ),
            'colorpicker' => '#eea638',
            'content' => '',
        ), $atts);

        return '';
    }
}
