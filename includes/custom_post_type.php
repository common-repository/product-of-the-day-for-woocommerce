<?php
class BeRocket_conditions_products_of_day extends BeRocket_conditions {
    public static function get_conditions() {
        $conditions = parent::get_conditions();
        $conditions['condition_week_day'] = array(
            'func' => 'check_condition_week_day',
            'type' => 'week_day',
            'name' => __('Week Day', 'BeRocket_products_of_day_domain')
        );
        $conditions['condition_widget_position'] = array(
            'func' => 'check_condition_widget_position',
            'type' => 'widget_position',
            'name' => __('Widget Position', 'BeRocket_products_of_day_domain')
        );
        $conditions['condition_day_time'] = array(
            'func' => 'check_condition_day_time',
            'type' => 'day_time',
            'name' => __('Day Time', 'BeRocket_products_of_day_domain')
        );
        $conditions['condition_user_status'] = array(
            'func' => 'check_condition_user_status',
            'type' => 'user_status',
            'name' => __('User Status', 'BeRocket_products_of_day_domain')
        );
        $conditions['condition_user_role'] = array(
            'func' => 'check_condition_user_role',
            'type' => 'user_role',
            'name' => __('User Role', 'BeRocket_products_of_day_domain')
        );
        $conditions['condition_shipping_zone'] = array(
            'func' => 'check_condition_shipping_zone',
            'type' => 'shipping_zone',
            'name' => __('Shipping Zone', 'BeRocket_products_of_day_domain')
        );
        $conditions['condition_country'] = array(
            'func' => 'check_condition_country',
            'type' => 'country',
            'name' => __('Country', 'BeRocket_products_of_day_domain')
        );
        $conditions['condition_country'] = array(
            'func' => 'check_condition_country',
            'type' => 'country',
            'name' => __('Country', 'BeRocket_products_of_day_domain')
        );
        $conditions['condition_product_in_cart'] = array(
            'save' => 'save_condition_product',
            'func' => 'check_condition_product_in_cart',
            'type' => 'product_in_cart',
            'name' => __('Product In Cart', 'BeRocket_products_of_day_domain')
        );
        return $conditions;
    }
    //Week Days
    public static function condition_week_day($html, $name, $options) {
        $def_options = array('day1' => '', 'day2' => '', 'day3' => '', 'day4' => '', 'day5' => '', 'day6' => '', 'day7' => '');
        $options = array_merge($def_options, $options);
        $html = '<p>
            <label><input type="checkbox" name="'.$name.'[day1]"'.(empty($options['day1']) ? '' : ' checked').'>'.__('Monday', 'BeRocket_products_of_day_domain').'</label>
            <label><input type="checkbox" name="'.$name.'[day2]"'.(empty($options['day2']) ? '' : ' checked').'>'.__('Tuesday', 'BeRocket_products_of_day_domain').'</label>
            <label><input type="checkbox" name="'.$name.'[day3]"'.(empty($options['day3']) ? '' : ' checked').'>'.__('Wednesday', 'BeRocket_products_of_day_domain').'</label>
            <label><input type="checkbox" name="'.$name.'[day4]"'.(empty($options['day4']) ? '' : ' checked').'>'.__('Thursday', 'BeRocket_products_of_day_domain').'</label>
            <label><input type="checkbox" name="'.$name.'[day5]"'.(empty($options['day5']) ? '' : ' checked').'>'.__('Friday', 'BeRocket_products_of_day_domain').'</label>
            <label><input type="checkbox" name="'.$name.'[day6]"'.(empty($options['day6']) ? '' : ' checked').'>'.__('Saturday', 'BeRocket_products_of_day_domain').'</label>
            <label><input type="checkbox" name="'.$name.'[day7]"'.(empty($options['day7']) ? '' : ' checked').'>'.__('Sunday', 'BeRocket_products_of_day_domain').'</label>
        </p>';
        return $html;
    }
    public static function check_condition_week_day($show, $condition, $additional) {
        $week_day = current_time('N');
        $show = ! empty($condition['day'.$week_day]);
        return $show;
    }
    //Widget Position
    public static function condition_widget_position($html, $name, $options) {
        $def_options = array('positions' => array());
        $options = array_merge($def_options, $options);
        if( ! is_array($options['positions']) ) {
            $options['positions'] = array();
        }
        $html = '<p>';
        $positions = array();
        for($i = 1; $i < 11; $i++) {
            $positions[] = array('value' => 'pos'.$i, 'label' => __('Position', 'BeRocket_products_of_day_domain').' '.$i);
        }
        $positions[] = array('value' => 'beforecontent', 'label' => __('Before content', 'BeRocket_products_of_day_domain'));
        $positions[] = array('value' => 'aftercontent', 'label' => __('After content', 'BeRocket_products_of_day_domain'));
        $positions[] = array('value' => 'beforefooter', 'label' => __('Before footer', 'BeRocket_products_of_day_domain'));
        foreach($positions as $position) {
            $html .= '<label><input type="checkbox" value="'.$position['value'].'" name="'.$name.'[positions][]"'.(in_array($position['value'], $options['positions']) ? ' checked' : '').'>'.$position['label'].'</label>
            ';
        }
        $html .= '</p>';
        return $html;
    }
    public static function check_condition_widget_position($show, $condition, $additional) {
        if( isset($additional['widget_position']) ) {
            $def_options = array('positions' => array());
            $condition = array_merge($def_options, $condition);
            if( ! is_array($condition['positions']) ) {
                $condition['positions'] = array();
            }
            if( count($condition['positions']) ) {
                $show = in_array($additional['widget_position'], $condition['positions']);
            }
        }
        return $show;
    }
    //Day Time
    public static function condition_day_time($html, $name, $options) {
        $def_options = array('from' => '00:00', 'till' => '23:59');
        $options = array_merge($def_options, $options);
        $html = '<p>
            <label>'.__('From: ', 'BeRocket_products_of_day_domain').'<input type="time" name="'.$name.'[from]" value="'.(empty($options['from']) ? '' : $options['from']).'"></label>
            <label>'.__('Till: ', 'BeRocket_products_of_day_domain').'<input type="time" name="'.$name.'[till]" value="'.(empty($options['till']) ? '' : $options['till']).'"></label>
        </p>';
        return $html;
    }
    public static function check_condition_day_time($show, $condition, $additional) {
        $def_options = array('from' => '00:00', 'till' => '23:59');
        $condition = array_merge($def_options, $condition);
        $from_time = floatval(str_replace(':', '.', $condition['from']));
        $till_time = floatval(str_replace(':', '.', $condition['till']));
        $current_time = floatval(current_time('G.i'));
        if( $from_time <= $till_time) {
            $show = ($current_time >= $from_time && $current_time <= $till_time );
        } else {
            $show = ($current_time >= $from_time || $current_time <= $till_time );
        }
        return $show;
    }
    //User Status
    public static function condition_user_status($html, $name, $options) {
        $def_options = array('not_logged_page' => '', 'customer_page' => '', 'logged_page' => '');
        $options = array_merge($def_options, $options);
        $html = '<p>
            <label><input type="checkbox" name="'.$name.'[not_logged_page]"'.(empty($options['not_logged_page']) ? '' : ' checked').'>'.__('Not Logged In', 'BeRocket_products_of_day_domain').'</label>
            <label><input type="checkbox" name="'.$name.'[customer_page]"'.(empty($options['customer_page']) ? '' : ' checked').'>'.__('Logged In Customers', 'BeRocket_products_of_day_domain').'</label>
            <label><input type="checkbox" name="'.$name.'[logged_page]"'.(empty($options['logged_page']) ? '' : ' checked').'>'.__('Logged In Not Customers', 'BeRocket_products_of_day_domain').'</label>
        </p>';
        return $html;
    }
    public static function check_condition_user_status($show, $condition, $additional) {
        $orders = get_posts( array(
            'meta_key'    => '_customer_user',
            'meta_value'  => get_current_user_id(),
            'post_type'   => 'shop_order',
            'post_status' => array( 'wc-processing', 'wc-completed' ),
        ) );
        $is_logged_in = is_user_logged_in();
        if( ! $is_logged_in ) {
            $show = ! empty($condition['not_logged_page']);
        } elseif( $orders ) {
            $show = ! empty($condition['customer_page']);
        } else {
            $show = ! empty($condition['logged_page']);
        }
        return $show;
    }
    public static function condition_user_role($html, $name, $options) {
        $def_options = array('role' => '');
        $options = array_merge($def_options, $options);
        $html .= static::supcondition($name, $options);
        $html .= '<select name="' . $name . '[role]">';
        $editable_roles = array_reverse( get_editable_roles() );
        foreach ( $editable_roles as $role => $details ) {
            $name = translate_user_role($details['name'] );
            $html .= "<option " . ($options['role'] == $role ? ' selected' : '') . " value='" . esc_attr( $role ) . "'>{$name}</option>";
        }
        $html .= '</select>';
        return $html;
    }
    public static function check_condition_user_role($show, $condition, $additional) {
        $post_author_id = get_current_user_id();
        $user_info = get_userdata($post_author_id);
        if( ! empty($user_info) ) {
            $show = in_array($condition['role'], $user_info->roles);
        } else {
            $show = false;
        }
        if( $condition['equal'] == 'not_equal' ) {
            $show = ! $show;
        }
        return $show;
    }
    public static function condition_shipping_zone($html, $name, $options) {
        $def_options = array('zone_id' => '');
        $options = array_merge($def_options, $options);
        $html .= static::supcondition($name, $options);
        $html .= '<select name="' . $name . '[zone_id]">';
        $shipping_zone = WC_Shipping_Zones::get_zones();
        foreach ( $shipping_zone as $shipping ) {
            $html .= "<option " . ($options['zone_id'] == $shipping['id'] ? ' selected' : '') . " value='".$shipping['id']."'>".$shipping['zone_name']."</option>";
        }
        $html .= '</select>';
        return $html;
    }
    public static function check_condition_shipping_zone($show, $condition, $additional) {
        $def_options = array('zone_id' => '');
        $condition = array_merge($def_options, $condition);
        $cart_shipping = WC()->cart->get_shipping_packages();
        $cart_shipping = $cart_shipping[0];
        $shipping_zone = WC_Shipping_Zones::get_zone_matching_package($cart_shipping);
        $show = $shipping_zone->get_id() == $condition['zone_id'];
        if( $condition['equal'] == 'not_equal' ) {
            $show = ! $show;
        }
        return $show;
    }
    public static function condition_country($html, $name, $options) {
        $def_options = array('country' => array());
        $options = array_merge($def_options, $options);
        $html .= static::supcondition($name, $options);
        $countries = WC()->countries->get_countries();
        $html .= '<div style="max-height:150px;overflow:auto;border:1px solid #ccc;padding: 5px;">';
        foreach ( $countries as $country_code => $country_name ) {
            $html .= '<div><label>
            <input type="checkbox" name="' . $name . '[country][]" value="' . $country_code . '"' . ( (! empty($options['country']) && is_array($options['country']) && in_array($country_code, $options['country']) ) ? ' checked' : '' ) . '>
            ' . $country_name . '
            </label></div>';
        }
        $html .= '</div>';
        return $html;
    }
    public static function check_condition_country($show, $condition, $additional) {
        $def_options = array('country' => array());
        $condition = array_merge($def_options, $condition);
        $location = WC_Geolocation::geolocate_ip();
        $location = (isset($location['country']) ? $location['country'] : '');
        $show = in_array($location, $condition['country']);
        if( $condition['equal'] == 'not_equal' ) {
            $show = ! $show;
        }
        return $show;
    }
    public static function condition_product_in_cart($html, $name, $options) {
        return self::condition_product($html, $name, $options);
    }
    public static function check_condition_product_in_cart($show, $condition, $additional) {
        $cart = WC()->cart;
        if( empty($cart) ) {
            return false;
        }
        $get_cart = $cart->get_cart();
        $product_list = array();
        foreach($get_cart as $cart_item_key => $values) {
            //INIT PRODUCT VARIABLES
            $_product = $values['data'];
            $check_additional = array();
            if ( $_product->is_type( 'variation' ) ) {
                $_product = wc_get_product($values['variation_id']);
                $check_additional['var_id'] = br_wc_get_product_id($_product);
                $check_additional['id'] = $_product->get_parent_id();
            } else {
                $_product_post = br_wc_get_product_post($_product);
                $_product_id = br_wc_get_product_id($_product);
                $check_additional['id'] = br_wc_get_product_id($_product);
            }
            $product_list[$cart_item_key] = $check_additional;
        }
        if( ! empty($product_list) ) {
            foreach($product_list as $product) {
                if( self::check_condition_product($show, $condition, array('product_id' => $product['id'])) ) {
                    return true;
                }
                if( ! empty($product['var_id']) && self::check_condition_product($show, $condition, array('product_id' => $product['var_id'])) ) {
                    return true;
                }
            }
            return false;
        }
    }
}
class BeRocket_products_of_day_post extends BeRocket_custom_post_class {
    public $hook_name = 'berocket_policy_cond_popup_post';
    public $conditions;
    public $post_type_parameters = array(
        'sortable' => true,
        'can_be_disabled' => true
    );
    protected static $instance;
    function __construct() {
        $this->post_name = 'br_products_of_day';
        $this->post_settings = array(
            'label' => __( 'Products List', 'BeRocket_products_of_day_domain' ),
            'labels' => array(
                'name'               => __( 'Products Lists', 'BeRocket_products_of_day_domain' ),
                'singular_name'      => __( 'Products List', 'BeRocket_products_of_day_domain' ),
                'menu_name'          => _x( 'Products Lists', 'Admin menu name', 'BeRocket_products_of_day_domain' ),
                'add_new'            => __( 'Add Products List', 'BeRocket_products_of_day_domain' ),
                'add_new_item'       => __( 'Add New Products List', 'BeRocket_products_of_day_domain' ),
                'edit'               => __( 'Edit', 'BeRocket_products_of_day_domain' ),
                'edit_item'          => __( 'Edit Products List', 'BeRocket_products_of_day_domain' ),
                'new_item'           => __( 'New Products List', 'BeRocket_products_of_day_domain' ),
                'view'               => __( 'View Products Lists', 'BeRocket_products_of_day_domain' ),
                'view_item'          => __( 'View Products List', 'BeRocket_products_of_day_domain' ),
                'search_items'       => __( 'Search Products Lists', 'BeRocket_products_of_day_domain' ),
                'not_found'          => __( 'No Products Lists found', 'BeRocket_products_of_day_domain' ),
                'not_found_in_trash' => __( 'No Products Lists found in trash', 'BeRocket_products_of_day_domain' ),
            ),
            'description'     => __( 'This is where you can add Products Lists.', 'BeRocket_products_of_day_domain' ),
            'public'          => true,
            'show_ui'         => true,
            'capability_type' => 'product',
            'map_meta_cap'    => true,
            'publicly_queryable'  => false,
            'exclude_from_search' => true,
            'show_in_menu'        => 'berocket_account',
            'hierarchical'        => false,
            'rewrite'             => false,
            'query_var'           => false,
            'supports'            => array( 'title' ),
            'show_in_nav_menus'   => false,
        );
        add_action('products_of_day_framework_construct', array($this, 'init_conditions'));
        $this->default_settings = array(
            'page'    => '',
        );
        $this->add_meta_box('conditions', __( 'Conditions', 'BeRocket_products_of_day_domain' ));
        $this->add_meta_box('settings', __( 'Products List Settings', 'BeRocket_products_of_day_domain' ));
        parent::__construct();
        add_filter ( 'BeRocket_updater_menu_order_custom_post', array($this, 'menu_order_custom_post') );
        add_filter ( 'BeRocket_get_product_of_day_array', array($this, 'product_of_day_array'), 10, 3 );
    }
    public function product_of_day_array($products = array(), $args = array(), $additional = array()) {
        if( ! is_array($products) ) {
            $products = array();
        }
        if( ! is_array($args) ) {
            $args = array();
        }
        $args = array_merge(
            array(
                'count'  => 5,
                'random' => false
            ),
            $args
        );
        extract($args);
        $posts = $this->get_custom_posts_frontend();
        if( is_array($posts) && count($posts) ) {
            foreach($posts as $post_id) {
                $options = $this->get_option($post_id);
                if( empty($options['data']) || $this->conditions->check($options['data'], $this->hook_name, $additional) && ! empty($options['products']) && is_array($options['products']) ) {
                    $products = array_merge($products, $options['products']);
                }
                if( count($products) >= $count && ! $random ) {
                    $products = array_unique($products);
                    if( count($products) > $count ) {
                        break;
                    }
                }
            }
        }
        $products = array_unique($products);
        if( count($products) >= $count ) {
            if( $random ) {
                $products = array_intersect_key( $products, array_flip( array_rand( $products, $count ) ) );
            } else {
                $products = array_slice($products, 0, $count);
            }
        }
        return $products;
    }
    public function init_conditions() {
        $this->conditions = new BeRocket_conditions_products_of_day($this->post_name.'[data]', $this->hook_name, array(
            'condition_week_day',
            'condition_widget_position',
            'condition_day_time',
            'condition_user_status',
            'condition_user_role',
            'condition_shipping_zone',
            'condition_country',
            'condition_product_in_cart',
            'condition_page_id',
            'condition_page_woo_category',
            'condition_page_woo_attribute',
            'condition_page_woo_search'
        ));
    }
    public function conditions($post) {
        $options = $this->get_option( $post->ID );
        echo $this->conditions->build($options['data']);
    }
    public function meta_box_shortcode($post) {
        global $pagenow;
        if( in_array( $pagenow, array( 'post-new.php' ) ) ) {
            _e( 'You need save it to get shortcode', 'BeRocket_products_of_day_domain' );
        } else {
            echo "[br_filter_single filter_id={$post->ID}]";
        }
    }
    public function settings($post) {
        $options = $this->get_option( $post->ID );
        echo '<div class="br_framework_settings br_alabel_settings">';
        $BeRocket_products_of_day = BeRocket_products_of_day::getInstance();
        $BeRocket_products_of_day->display_admin_settings(
            array(
                'General' => array(
                    'icon' => 'cog',
                ),
            ),
            array(
                'General' => array(
                    'page' => array(
                        "label"     => __( "Products", 'BeRocket_products_of_day_domain' ),
                        "name"     => 'products',   
                        "type"     => "products",
                        "value"    => '',
                    ),
                ),
            ),
            array(
                'name_for_filters' => $this->hook_name,
                'hide_header' => true,
                'hide_form' => true,
                'hide_additional_blocks' => true,
                'hide_save_button' => true,
                'settings_name' => $this->post_name,
                'options' => $options
            )
        );
        echo '</div>';
    }

    public function menu_order_custom_post($compatibility) {
        $compatibility[$this->post_name] = 'br-products_of_day';
        return $compatibility;
    }
}
