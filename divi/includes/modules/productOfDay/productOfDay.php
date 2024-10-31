<?php

class ET_Builder_Module_br_product_of_day extends ET_Builder_Module {

	public $slug       = 'et_pb_br_product_of_day';
	public $vb_support = 'on';

	protected $module_credits = array(
		'module_uri' => '',
		'author'     => '',
		'author_uri' => '',
	);

	public function init() {
        $this->name             = __('Products of Day', 'BeRocket_products_of_day_domain' );
		$this->folder_name = 'et_pb_berocket_modules';
		$this->main_css_element = '%%order_class%%';
        
        $this->fields_defaults = array(
            'widget_position' => array('pos1'),
            'products_count' => array('5'),
            'random' => array('off'),
            'type' => array('default'),
            'count_line' => array('1'),
            'thumbnails' => array('on'),
            'add_to_cart' => array('on'),
            'hide_outofstock' => array('off'),
        );

		$this->advanced_fields = array(
			'fonts'           => array(
				'title'   => array(
					'label'        => esc_html__( 'Product Title', 'BeRocket_products_of_day_domain' ),
					'css'          => array(
						'main'      => "{$this->main_css_element} .br_product_for_day .br_product_day h1, {$this->main_css_element} .br_product_for_day .br_product_day h2, {$this->main_css_element} .br_product_for_day .br_product_day h3, {$this->main_css_element} .br_product_for_day .br_product_day h4, {$this->main_css_element} .br_product_for_day .br_product_day h5",
						'important' => true,
					),
                    'hide_font_size' => true,
                    'hide_letter_spacing' => true,
                    'hide_line_height' => true,
                    'hide_text_shadow' => true,
				),
				'price'   => array(
					'label'        => esc_html__( 'Product Price', 'BeRocket_products_of_day_domain' ),
					'css'          => array(
						'main'      => "{$this->main_css_element} .br_product_for_day .br_product_day .br_price",
						'important' => true,
					),
                    'hide_font_size' => true,
                    'hide_letter_spacing' => true,
                    'hide_line_height' => true,
                    'hide_text_shadow' => true,
				),
			),
			'link_options'  => false,
			'visibility'    => false,
			'text'          => false,
			'transform'     => false,
			'animation'     => false,
			'background'    => false,
			'borders'       => false,
			'box_shadow'    => false,
			'button'        => false,
			'filters'       => false,
			'margin_padding'=> false,
			'max_width'     => false,
		);
	}

    function get_fields() {
        $fields = array(
            'widget_position' => array(
                "label"           => esc_html__( 'Widget Position', 'BeRocket_products_of_day_domain' ),
                'type'            => 'select',
                'options'         => array(
                    'pos1' => esc_html__( 'Position 1', 'BeRocket_products_of_day_domain' ),
                    'pos2' => esc_html__( 'Position 2', 'BeRocket_products_of_day_domain' ),
                    'pos3' => esc_html__( 'Position 3', 'BeRocket_products_of_day_domain' ),
                    'pos4' => esc_html__( 'Position 4', 'BeRocket_products_of_day_domain' ),
                    'pos5' => esc_html__( 'Position 5', 'BeRocket_products_of_day_domain' ),
                    'pos6' => esc_html__( 'Position 6', 'BeRocket_products_of_day_domain' ),
                    'pos7' => esc_html__( 'Position 7', 'BeRocket_products_of_day_domain' ),
                    'pos8' => esc_html__( 'Position 8', 'BeRocket_products_of_day_domain' ),
                    'pos9' => esc_html__( 'Position 9', 'BeRocket_products_of_day_domain' ),
                    'pos10' => esc_html__( 'Position 10', 'BeRocket_products_of_day_domain' ),
                )
            ),
            'products_count' => array(
                "label"           => esc_html__( 'Number of Products', 'BeRocket_products_of_day_domain' ),
                'type'            => 'number'
            ),
            'random' => array(
                "label"             => esc_html__( 'Random Products from List', 'BeRocket_products_of_day_domain' ),
                'type'              => 'yes_no_button',
                'options'           => array(
                    'off' => esc_html__( "No", 'et_builder' ),
                    'on'  => esc_html__( 'Yes', 'et_builder' ),
                ),
            ),
            'type' => array(
                "label"           => esc_html__( 'Type', 'BeRocket_products_of_day_domain' ),
                'type'            => 'select',
                'options'         => array(
                    'default' => esc_html__( 'Default', 'BeRocket_products_of_day_domain' ),
                    'slider' => esc_html__( 'Slider', 'BeRocket_products_of_day_domain' ),
                )
            ),
            'count_line' => array(
                "label"           => esc_html__( 'Number of Products per line', 'BeRocket_products_of_day_domain' ),
                'type'            => 'number'
            ),
            'thumbnails' => array(
                "label"             => esc_html__( 'Show Thumbnails', 'BeRocket_products_of_day_domain' ),
                'type'              => 'yes_no_button',
                'options'           => array(
                    'off' => esc_html__( "No", 'et_builder' ),
                    'on'  => esc_html__( 'Yes', 'et_builder' ),
                ),
            ),
            'add_to_cart' => array(
                "label"             => esc_html__( 'Show Add to Cart Button', 'BeRocket_products_of_day_domain' ),
                'type'              => 'yes_no_button',
                'options'           => array(
                    'off' => esc_html__( "No", 'et_builder' ),
                    'on'  => esc_html__( 'Yes', 'et_builder' ),
                ),
            ),
            'hide_outofstock' => array(
                "label"             => esc_html__( 'Hide out of stock products', 'BeRocket_products_of_day_domain' ),
                'type'              => 'yes_no_button',
                'options'           => array(
                    'off' => esc_html__( "No", 'et_builder' ),
                    'on'  => esc_html__( 'Yes', 'et_builder' ),
                ),
            ),
        );

        return $fields;
    }

    function render( $atts, $content = null, $function_name = '' ) {
        $atts = BAPOF_productOfDay_DiviExtension::convert_on_off($atts);
        ob_start();
        the_widget( 'berocket_products_of_day_widget', $atts );
        return ob_get_clean();
    }
}

new ET_Builder_Module_br_product_of_day;
