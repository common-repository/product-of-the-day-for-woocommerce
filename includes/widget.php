<?php
/**
 * List/Grid widget
 */
class BeRocket_products_of_day_Widget extends WP_Widget 
{
    public static $defaults = array(
        'title'             => '',
        'type'              => 'default',
        'products_count'    => '5',
        'count_line'        => '1',
        'random'            => '',
        'thumbnails'        => '1',
        'add_to_cart'       => '1',
        'quick_view'        => '0',
        'hide_outofstock'   => '0',
        'widget_position'   => 'pos1',
    );
	public function __construct() {
        parent::__construct("berocket_products_of_day_widget", "WooCommerce Products of Day",
            array("description" => ""));
    }
    /**
     * WordPress widget
     */
    public function widget($args, $instance)
    {
        $instance = wp_parse_args( (array) $instance, self::$defaults );
        $instance['products_count'] = intval($instance['products_count']);
        if( $instance['products_count'] <= 0 ) {
            $instance['products_count'] = 1;
        }
        $instance['count_line'] = intval($instance['count_line']);
        if( $instance['count_line'] <= 0 ) {
            $instance['count_line'] = 1;
        }
        $instance['title'] = apply_filters( 'widget_title', empty($instance['title']) ? '' : $instance['title'], $instance );
        $query_var = array();
        $query_var['title'] = apply_filters( 'products_of_day_widget_title', $instance['title'] );
        $query_var['products_count'] = apply_filters( 'products_of_day_widget_products_count', $instance['products_count'] );
        $query_var['random'] = apply_filters( 'products_of_day_widget_random', $instance['random'] );
        $query_var['type'] = apply_filters( 'products_of_day_widget_type', $instance['type'] );
        $query_var['count_line'] = apply_filters( 'products_of_day_widget_count_line', $instance['count_line'] );
        $query_var['thumbnails'] = apply_filters( 'products_of_day_widget_thumbnails', $instance['thumbnails'] );
        $query_var['add_to_cart'] = apply_filters( 'products_of_day_widget_add_to_cart', $instance['add_to_cart'] );
        $query_var['quick_view'] = apply_filters( 'products_of_day_widget_quick_view', $instance['quick_view'] );
        $query_var['hide_outofstock'] = apply_filters( 'products_of_day_widget_hide_outofstock', $instance['hide_outofstock'] );
        $query_var['widget_position'] = apply_filters( 'products_of_day_widget_widget_position', $instance['widget_position'] );
        $query_var['args'] = $args;
        set_query_var('berocket_products_of_day_widget', $query_var);
        ob_start();
        $BeRocket_products_of_day = BeRocket_products_of_day::getInstance();
        $BeRocket_products_of_day->br_get_template_part( apply_filters( 'products_of_day_widget_template', 'widget' ) );
        $content = ob_get_clean();
        if( $content ) {
            if( ! empty($args['before_widget']) ) echo $args['before_widget'];
            echo $content;
            if( ! empty($args['after_widget']) ) echo $args['after_widget'];
        }
	}
    /**
     * Update widget settings
     */
	public function update( $new_instance, $old_instance ) {
		$instance = $old_instance;
		$instance['title'] = strip_tags( $new_instance['title'] );
		$instance['type'] = strip_tags( $new_instance['type'] );
		$instance['products_count'] = strip_tags( $new_instance['products_count'] );
		$instance['widget_position'] = strip_tags( $new_instance['widget_position'] );
		$instance['count_line'] = (int)strip_tags( $new_instance['count_line'] );
		$instance['widget_position'] = strip_tags( $new_instance['widget_position'] );
        if( isset($new_instance['random']) && $new_instance['random'] ) {
            $instance['random'] = 1;
        } else {
            $instance['random'] = 0;
        }
        if( isset($new_instance['thumbnails']) && $new_instance['thumbnails'] ) {
            $instance['thumbnails'] = 1;
        } else {
            $instance['thumbnails'] = 0;
        }
        if( isset($new_instance['add_to_cart']) && $new_instance['add_to_cart'] ) {
            $instance['add_to_cart'] = 1;
        } else {
            $instance['add_to_cart'] = 0;
        }
        if( isset($new_instance['quick_view']) && $new_instance['quick_view'] ) {
            $instance['quick_view'] = 1;
        } else {
            $instance['quick_view'] = 0;
        }
        if( isset($new_instance['hide_outofstock']) && $new_instance['hide_outofstock'] ) {
            $instance['hide_outofstock'] = 1;
        } else {
            $instance['hide_outofstock'] = 0;
        }
		return $instance;
	}
    /**
     * Widget settings form
     */
	public function form($instance)
	{
        $instance = wp_parse_args( (array) $instance, self::$defaults );
		$title = strip_tags($instance['title']);
		$products_count = strip_tags($instance['products_count']);
		$count_line = strip_tags($instance['count_line']);
		$random = strip_tags($instance['random']);
		$thumbnails = strip_tags($instance['thumbnails']);
		$add_to_cart = strip_tags($instance['add_to_cart']);
		$quick_view = strip_tags($instance['quick_view']);
		$type = strip_tags($instance['type']);
		$hide_outofstock = strip_tags($instance['hide_outofstock']);
		$widget_position = strip_tags($instance['widget_position']);
		?>
		<p>
            <label for="<?php echo $this->get_field_id('title'); ?>"><?php _e('Title:'); ?></label> 
            <input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo esc_attr( $title ); ?>">
        </p>
        <p>
            <label><?php _e('Widget Position', 'BeRocket_products_of_day_domain'); ?></label>
            <select id="<?php echo $this->get_field_id('widget_position'); ?>" name="<?php echo $this->get_field_name('widget_position'); ?>">
            <?php            
            for($i = 1; $i < 11; $i++) {
                echo '<option value="pos'.$i.'"'.($widget_position == "pos".$i ? ' selected' : '').'>'.__('Position', 'BeRocket_products_of_day_domain').' '.$i.'</option>';
            }
            ?>
            </select>
        </p>
        <p>
            <label><?php _e('Number of Products:', 'BeRocket_products_of_day_domain'); ?></label>
            <input class="widefat" id="<?php echo $this->get_field_id('products_count'); ?>" name="<?php echo $this->get_field_name('products_count'); ?>" type="number" value="<?php echo esc_attr( $products_count ); ?>">
        </p>
        <p>
            <label><?php _e('Random Products from List', 'BeRocket_products_of_day_domain'); ?></label>
            <input class="widefat" id="<?php echo $this->get_field_id('random'); ?>" name="<?php echo $this->get_field_name('random'); ?>" type="checkbox" value="1"<?php if( $random ) echo ' checked'; ?>>
        </p>
        <p>
            <label><?php _e('Type:', 'BeRocket_products_of_day_domain'); ?></label> 
            <?php 
            $types = array(
                'default' => __('Default', 'BeRocket_products_of_day_domain'),
                'slider' => __('Slider', 'BeRocket_products_of_day_domain'),
            );
            echo '<select class="br_prod_of_day_type" id="'.$this->get_field_id('type').'" name="'.$this->get_field_name('type').'">';
                foreach($types as $type_id => $type_name) {
                    echo '<option value="'.$type_id.'"'.($type == $type_id ? ' selected' : '').'>'.$type_name.'</option>';
                }
            echo '</select>';
            ?>
        </p>
        <p>
            <label><?php _e('Number of Products per line:', 'BeRocket_products_of_day_domain'); ?></label>
            <input class="widefat" id="<?php echo $this->get_field_id('count_line'); ?>" name="<?php echo $this->get_field_name('count_line'); ?>" type="number" value="<?php echo esc_attr( $count_line ); ?>">
        </p>
        <p>
            <label><?php _e('Show Thumbnails', 'BeRocket_products_of_day_domain'); ?></label>
            <input class="widefat" id="<?php echo $this->get_field_id('thumbnails'); ?>" name="<?php echo $this->get_field_name('thumbnails'); ?>" type="checkbox" value="1"<?php if( $thumbnails ) echo ' checked'; ?>>
        </p>
        <p>
            <label><?php _e('Show Add to Cart Button', 'BeRocket_products_of_day_domain'); ?></label>
            <input class="widefat" id="<?php echo $this->get_field_id('add_to_cart'); ?>" name="<?php echo $this->get_field_name('add_to_cart'); ?>" type="checkbox" value="1"<?php if( $add_to_cart ) echo ' checked'; ?>>
        </p>
        <?php if(defined("BeRocket_Product_Preview_version")) { ?>
        <p>
            <label><?php _e('Show Qiuck View Button', 'BeRocket_products_of_day_domain'); ?></label>
            <input class="widefat" id="<?php echo $this->get_field_id('quick_view'); ?>" name="<?php echo $this->get_field_name('quick_view'); ?>" type="checkbox" value="1"<?php if( $quick_view ) echo ' checked'; ?>>
        </p>
        <?php } ?>
        <p>
            <label><?php _e('Hide out of stock products', 'BeRocket_products_of_day_domain'); ?></label>
            <input class="widefat" id="<?php echo $this->get_field_id('hide_outofstock'); ?>" name="<?php echo $this->get_field_name('hide_outofstock'); ?>" type="checkbox" value="1"<?php if( $hide_outofstock ) echo ' checked'; ?>>
        </p>
		<?php
	}
}
?>
