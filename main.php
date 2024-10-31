<?php
define( "BeRocket_products_of_day_domain", 'BeRocket_products_of_day_domain'); 
define( "products_of_day_TEMPLATE_PATH", plugin_dir_path( __FILE__ ) . "templates/" );
load_plugin_textdomain('BeRocket_products_of_day_domain', false, dirname( plugin_basename( __FILE__ ) ) . '/languages/');
require_once(plugin_dir_path( __FILE__ ).'berocket/framework.php');
include_once( ABSPATH . 'wp-admin/includes/plugin.php' );

class BeRocket_products_of_day extends BeRocket_Framework {
    public static $settings_name = 'br-products_of_day-options';
    protected $plugin_version_capability = 15;
    protected static $instance;
    public $metadata_table;
    protected $disable_settings_for_admin = array(
        array('script', 'js_page_load'),
    );
    protected $check_init_array = array(
        array(
            'check' => 'woocommerce_version',
            'data' => array(
                'version' => '3.0',
                'operator' => '>=',
                'notice'   => 'Plugin WooCommerce Terms and Conditions Popup required WooCommerce version 3.0 or higher'
            )
        ),
        array(
            'check' => 'framework_version',
            'data' => array(
                'version' => '2.1',
                'operator' => '>=',
                'notice'   => 'Please update all BeRocket plugins to the most recent version. WooCommerce Terms and Conditions Popup is not working correctly with older versions.'
            )
        ),
    );
    function __construct () {
        global $berocket_unique_value;
        $berocket_unique_value = 1;
        $this->info = array(
            'id'          => 16,
            'lic_id'      => 35,
            'version'     => BeRocket_products_of_day_version,
            'plugin'      => '',
            'slug'        => '',
            'key'         => '',
            'name'        => '',
            'plugin_name' => 'products_of_day',
            'full_name'   => 'Product of the Day for WooCommerce',
            'norm_name'   => 'Product of the Day',
            'price'       => '24',
            'domain'      => 'BeRocket_products_of_day_domain',
            'templates'   => products_of_day_TEMPLATE_PATH,
            'plugin_file' => BeRocket_products_of_day_file,
            'plugin_dir'  => __DIR__,
        );
        $this->defaults = array(
            'custom_css'      => '',
            'script'          => array(
                'js_page_load'  => '',
            ),
        );
        $this->values = array(
            'settings_name' => 'br-products_of_day-options',
            'option_page'   => 'br-products_of_day',
            'premium_slug'  => 'woocommerce-products-of-day',
            'free_slug'     => '',
            'hpos_comp'     => true
        );
        $this->framework_data['fontawesome_frontend'] = true;
        if( method_exists($this, 'include_once_files') ) {
            $this->include_once_files();
        }
        if( $this->init_validation() ) {
            new BeRocket_products_of_day_post();
        }
        parent::__construct( $this );
        if( $this->init_validation() ) {
            $options = $this->get_option();
            add_action('widgets_init', array($this, 'widgets_init'));
            add_shortcode( 'br_products_of_day', array( $this, 'shortcode' ) );
            if( isset($options['positions']) && is_array($options['positions']) ) {
                if( in_array('before_content', $options['positions']) ) {
                    add_filter( 'the_content', array( $this, 'before_content') );
                }
                if( in_array('after_content', $options['positions']) ) {
                    add_filter( 'the_content', array( $this, 'after_content') );
                }
                if( in_array('before_footer', $options['positions']) ) {
                    add_action( 'get_footer', array( $this, 'before_footer') );
                }
            }
            add_action( 'divi_extensions_init', array($this, 'divi_extensions_init') );
        }
    }
    public function admin_init() {
        parent::admin_init();
        wp_enqueue_script( 'berocket_products_of_day_admin', 
            plugins_url( 'js/admin.js', __FILE__ ), 
            array( 'jquery' ), 
            BeRocket_products_of_day_version );
    }
    public function init() {
        $options = $this->get_option();
        parent::init();
        wp_register_style( 'berocket_cart_suggestion_slider', plugins_url( 'css/unslider.css', __FILE__ ) );
        wp_enqueue_style( 'berocket_cart_suggestion_slider' );
        wp_enqueue_script( 'berocket_cart_suggestion_slider_js', plugins_url( 'js/unslider-min.js', __FILE__ ), array( 'jquery' ) );
        wp_enqueue_script( 'berocket_products_of_day_main', 
            plugins_url( 'js/frontend.js', __FILE__ ), 
            array( 'jquery' ), 
            BeRocket_products_of_day_version );
        wp_register_style( 'berocket_products_of_day_style', 
            plugins_url( 'css/frontend.css', __FILE__ ), 
            "", 
            BeRocket_products_of_day_version );
        wp_enqueue_style( 'berocket_products_of_day_style' );

        wp_localize_script(
            'berocket_products_of_day_main',
            'the_products_of_day_js_data',
            array(
                'script' => apply_filters( 'berocket_products_of_day_user_func', $options['script'] ),
            )
        );
    }
    public function admin_settings( $tabs_info = array(), $data = array() ) {
        wp_register_style( 'berocket_products_of_day_style_admin', 
            plugins_url( 'css/admin.css', __FILE__ ), 
            "", 
            BeRocket_products_of_day_version );
        wp_enqueue_style( 'berocket_products_of_day_style_admin' );
        parent::admin_settings(
            array(
                'General' => array(
                    'icon' => 'cog',
                ),
                'Styles' => array(
                    'icon' => 'eye',
                ),
                'Products of Day' => array(
                    'icon' => 'plus-square',
                    'link' => admin_url( 'edit.php?post_type=br_products_of_day' ),
                ),
                'CSS/JavaScript' => array(
                    'icon' => 'css3',
                ),
            ),
            array(
                'General' => array(
                    'position' => array(
                        'label' => __('Position to display products of day', 'BeRocket_products_of_day_domain'),
                        'items' => array(
                            array(
                                "label"   => "Custom CSS",
                                "name"    => array("positions", "1"),
                                "type"    => "checkbox",
                                "value"   => "before_content",
                                "label_for" => __('Before content', 'BeRocket_products_of_day_domain')
                            ),
                            array(
                                "label"   => "Custom CSS",
                                "name"    => array("positions", "2"),
                                "type"    => "checkbox",
                                "value"   => "after_content",
                                "label_for" => __('After content', 'BeRocket_products_of_day_domain')
                            ),
                            array(
                                "label"   => "Custom CSS",
                                "name"    => array("positions", "3"),
                                "type"    => "checkbox",
                                "value"   => "before_footer",
                                "label_for" => __('Before footer', 'BeRocket_products_of_day_domain')
                            ),
                        )
                    ),
                    'shortcode' => array(
                        'label'   => '',
                        'section' => 'shortcode'
                    ),
                ),
                'Styles' => array(
                    array(
                        'label' => '',
                        'section' => 'styles'
                    )
                ),
                'CSS/JavaScript' => array(
                    'global_font_awesome_disable' => array(
                        "label"     => __( 'Disable Font Awesome', "BeRocket_products_of_day_domain" ),
                        "type"      => "checkbox",
                        "name"      => "fontawesome_frontend_disable",
                        "value"     => '1',
                        'label_for' => __('Don\'t load Font Awesome css files on site front end. Use it only if you don\'t use Font Awesome icons in widgets or your theme has Font Awesome.', 'BeRocket_products_of_day_domain'),
                    ),
                    'global_fontawesome_version' => array(
                        "label"    => __( 'Font Awesome Version', "BeRocket_products_of_day_domain" ),
                        "name"     => "fontawesome_frontend_version",
                        "type"     => "selectbox",
                        "options"  => array(
                            array('value' => '', 'text' => __('Font Awesome 4', 'BeRocket_products_of_day_domain')),
                            array('value' => 'fontawesome5', 'text' => __('Font Awesome 5', 'BeRocket_products_of_day_domain')),
                        ),
                        "value"    => '',
                        "label_for" => __('Version of Font Awesome that will be used on front end. Please select version that you have in your theme', 'BeRocket_products_of_day_domain'),
                    ),
                    array(
                        "label"   => "Custom CSS",
                        "name"    => "custom_css",
                        "type"    => "textarea",
                        "value"   => "",
                    ),
                    array(
                        "label"   => "JavaScript",
                        "name"    => array("script", "js_page_load"),
                        "type"    => "textarea",
                        "value"   => "",
                    ),
                )
            )
        );
    }
    function section_shortcode($item, $options) {
        $html = '<tr>
        <td colspan="2">
            <h3>' .__('Shortcode', 'BeRocket_products_of_day_domain') . '</h3>
            <h4>[br_products_of_day]</h4>
            <p><strong>'.__('Parameters:', 'BeRocket_products_of_day_domain').'</strong></p>
            <ul>
                <li><i>title</i> - '.__('title of widget', 'BeRocket_products_of_day_domain').'</li>
                <li><i>type</i> - '.__('Display type: default or slider', 'BeRocket_products_of_day_domain').'</li>
                <li><i>products_count</i> - '.__('count of products that will be displayed', 'BeRocket_products_of_day_domain').'</li>
                <li><i>count_line</i> - '.__('products per line/slide', 'BeRocket_products_of_day_domain').'</li>
                <li><i>random</i> - '.__('displays random products with random sorting (0 - disable, 1 - enable)', 'BeRocket_products_of_day_domain').'</li>
                <li><i>thumbnails</i> - '.__('show products thumbnails (0 - disable, 1 - enable)', 'BeRocket_products_of_day_domain').'</li>
                <li><i>add_to_cart</i> - '.__('show add to cart button for each (0 - disable, 1 - enable)', 'BeRocket_products_of_day_domain').'</li>
                <li><i>hide_outofstock</i> - '.__('hide products that out of stock (0 - disable, 1 - enable)', 'BeRocket_products_of_day_domain').'</li>
                <li><i>widget_position</i> - '.__('widget position that can be used as condition (pos1, pos2, pos3, pos4, pos5, pos6, pos7, pos8, pos9, pos10)', 'BeRocket_products_of_day_domain').'</li>
            </ul>
            <p><strong>'.__('Examples:', 'BeRocket_products_of_day_domain').'</strong></p>
            <ul>
                <li><i>[br_products_of_day title="Products of day" products_count=4 count_line=2 thumbnails=1 random=1]</i> - '.
                __('Display 4 Products of day in 2 lines, uses random products from list for current day', 'BeRocket_products_of_day_domain').'</li>
                <li><i>[br_products_of_day title="Buy right now" add_to_cart=1 products_count=4 count_line=1 thumbnails=1 type="slider"]</i> - '.
                __('Products of day slider with 1 product per slide with add to cart button', 'BeRocket_products_of_day_domain').'</li>
                <li><i>[br_products_of_day title="Products" hide_outofstock=1 add_to_cart=1 products_count=12 thumbnails=1 count_line=3]</i> - '.
                __('Display products like in WooCommerce shop page', 'BeRocket_products_of_day_domain').'</li>
            </ul>
        </td>
        </tr>';
        return $html;
    }
    function section_styles($item, $options) {
        ob_start();
        include('templates/styles.php');
        $html = ob_get_clean();
        $html = '<tr><td>'.$html.'</td></tr>';
        return $html;
    }
    public function widgets_init() {
        register_widget("berocket_products_of_day_widget");
    }

    public function shortcode($atts = array()) {
        ob_start();
        the_widget( 'berocket_products_of_day_widget', $atts );
        $return = ob_get_clean();
        return $return;
    }

    public function before_footer( $content ) {
        echo '<div style="clear:both;">';
        echo $this->hook_return(array('widget_position' => 'beforefooter'), true);
        echo '</div>';
    }

    public function before_content( $content ) {
        $content = $this->hook_return(array('widget_position' => 'beforecontent')) . $content;
        return $content;
    }

    public function after_content( $content ) {
        $content = $content . $this->hook_return(array('widget_position' => 'aftercontent'));
        return $content;
    }

    public function hook_return($args = array(), $force = false) {
        global $br_wp_query_not_main;
        $args = array_merge(array('type' => 'slider'), $args);
        $return = '';
        if( ! $br_wp_query_not_main || $force ) {
            ob_start();
            echo $this->shortcode($args);
            $return = ob_get_contents();
            ob_end_clean();
        }
        return $return;
    }
    public function set_styles () {
        $options = $this->get_option();
        echo '<style>'.$options['custom_css'];
        if( br_get_value_from_array($options, 'fontawesome_frontend_version') == 'fontawesome5' ) {
            echo '.unslider-arrow.prev, .unslider-arrow.next {
                font-family: "Font Awesome 5 Free";
                font-weight: 900;
            }';
        } 
        if( isset($options['use_styles']) && is_array($options['use_styles']) ) {
            if( in_array( 'global', $options['use_styles'] ) ) {
                if( isset($options['buttons']['global']['default']) && is_array($options['buttons']['global']['default']) &&
                isset($options['buttons']['global']['hover']) && is_array($options['buttons']['global']['hover']) ) {
                    echo '.br_product_for_day .br_product_day {';
                    $this->array_to_style ( $options['buttons']['global']['default'] );
                    echo '}';
                    echo '.br_product_for_day .br_product_day:hover {';
                    $this->array_to_style ( $options['buttons']['global']['hover'] );
                    echo '}';
                }
            }
            if( in_array( 'add_to_cart', $options['use_styles'] ) ) {
                if( isset($options['buttons']['add_to_cart']['default']) && is_array($options['buttons']['add_to_cart']['default']) &&
                isset($options['buttons']['add_to_cart']['hover']) && is_array($options['buttons']['add_to_cart']['hover']) ) {
                    echo '.br_product_for_day .br_product_day .add_to_cart_button {';
                    $this->array_to_style ( $options['buttons']['add_to_cart']['default'] );
                    echo '}';
                    echo '.br_product_for_day .br_product_day .add_to_cart_button:hover {';
                    $this->array_to_style ( $options['buttons']['add_to_cart']['hover'] );
                    echo '}';
                }
            }
            if( in_array( 'price', $options['use_styles'] ) ) {
                if( isset($options['buttons']['price']['default']) && is_array($options['buttons']['price']['default']) &&
                isset($options['buttons']['price']['hover']) && is_array($options['buttons']['price']['hover']) ) {
                    echo '.br_product_for_day .br_product_day .br_price {';
                    $this->array_to_style ( $options['buttons']['price']['default'] );
                    echo '}';
                    echo '.br_product_for_day .br_product_day .br_price:hover {';
                    $this->array_to_style ( $options['buttons']['price']['hover'] );
                    echo '}';
                    echo '.br_product_for_day .br_product_day .br_price {
                        color: inherit;
                        background-color: inherit;
                    }';
                }
            }
            if( in_array( 'quick_view', $options['use_styles'] ) ) {
                if( isset($options['buttons']['quick_view']['default']) && is_array($options['buttons']['quick_view']['default']) &&
                isset($options['buttons']['quick_view']['hover']) && is_array($options['buttons']['quick_view']['hover']) ) {
                    echo '.br_product_for_day .br_product_day .br_product_preview_button {';
                    $this->array_to_style ( $options['buttons']['quick_view']['default'] );
                    echo '}';
                    echo '.br_product_for_day .br_product_day .br_product_preview_button:hover {';
                    $this->array_to_style ( $options['buttons']['quick_view']['hover'] );
                    echo '}';
                }
            }
        }
        echo '</style>';
    }

    public function array_to_style ( $styles ) {
        $color = array( 'color', 'background-color', 'border-color' );
        $size = array( 'border-top-width', 'border-bottom-width', 'border-left-width', 'border-right-width',
            'padding-top', 'padding-bottom', 'padding-left', 'padding-right',
            'border-top-left-radius', 'border-top-right-radius', 'border-bottom-right-radius', 'border-bottom-left-radius',
            'margin-top', 'margin-bottom', 'margin-left', 'margin-right', 'top', 'bottom', 'left', 'right' );
        foreach( $styles as $name => $value ) {
            if ( isset( $value ) && strlen($value) > 0 ) {
                if ( in_array( $name, $color ) ) {
                    if ( $value[0] != '#' ) {
                        $value = '#' . $value;
                    }
                    echo $name . ':' . $value . '!important;';
                } else if ( in_array( $name, $size ) ) {
                    if ( strpos( $value, '%' ) || strpos( $value, 'em' ) || strpos( $value, 'px' ) ) {
                        echo $name . ':' . $value . '!important;';
                    } else {
                        echo $name . ':' . $value . 'px!important;';
                    }
                } else {
                    echo $name . ':' . $value . '!important;';
                }
            }
        }
    }
    function init_validation() {
        return parent::init_validation() && $this->check_framework_version();
    }
    function check_framework_version() {
        return ( ! empty(BeRocket_Framework::$framework_version) && version_compare(BeRocket_Framework::$framework_version, 2.1, '>=') );
    }
    public function update_version($previous, $current) {
        if( version_compare($previous, '3.0', '<') ) {
            $options = $this->get_option();
            if( ! empty($options['products']) && is_array($options['products']) ) {
                $week_days = array(
                    '1' => 'Monday',
                    '2' => 'Tuesday',
                    '3' => 'Wednesday',
                    '4' => 'Thursday',
                    '5' => 'Friday',
                    '6' => 'Saturday',
                    '7' => 'Sunday',
                );
                foreach($options['products'] as $product_day => $products) {
                    if( is_array($products) && count($products) ) {
                        $BeRocket_products_of_day_post = BeRocket_products_of_day_post::getInstance();
                        $BeRocket_products_of_day_post->create_new_post(
                            array(
                                'post_title' => 'PoD for '.$week_days[$product_day]
                            ), 
                            array(
                                'data' => array(
                                    '1' => array(
                                        '1' => array(
                                            'type' => 'week_day',
                                            'day'.$product_day => '1'
                                        )
                                    )
                                ),
                                'products' => $products
                            )
                        );
                    }
                }
            }
        }
    }
    public function divi_extensions_init() {
        include_once dirname( __FILE__ ) . '/divi/includes/ProductOfDayExtension.php';
    }
}

new BeRocket_products_of_day;
