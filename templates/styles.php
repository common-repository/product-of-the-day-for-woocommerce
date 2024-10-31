<?php 
$buttons = array(
    'global'        => __( 'Global styles', 'BeRocket_products_of_day_domain' ),
    'add_to_cart'   => __( 'Add to cart button', 'BeRocket_products_of_day_domain' ),
    'price'      => __( 'Price', 'BeRocket_products_of_day_domain' ),
);
if(defined("BeRocket_Product_Preview_version")) {
    $buttons['quick_view'] = __( 'Quick View button', 'BeRocket_products_of_day_domain' );
}
foreach($buttons as $button_id => $button_name) {
?>
<p>
    <label>
        <input class="br_pod_use_spec_styles br_pod_use_styles_<?php echo $button_id; ?>" data-id="<?php echo $button_id; ?>" name="br-products_of_day-options[use_styles][]" type="checkbox" value="<?php echo $button_id; ?>"<?php if ( isset($options['use_styles']) && is_array($options['use_styles']) && in_array($button_id, $options['use_styles']) ) echo ' checked'; ?>>
        <?php echo __( 'Use', 'BeRocket_products_of_day_domain' ).' '.$button_name; ?>
    </label>
</p>
<table class="berocket_pagination_style berocket_pod_styles_<?php echo $button_id; ?>"<?php if ( ! isset($options['use_styles']) || ! is_array($options['use_styles']) || ! in_array($button_id, $options['use_styles']) ) echo ' style="display: none;"'; ?>>
    <tr><th colspan="5" style="border-bottom: 1px solid #999;"><h3><?php echo $button_name; ?></h3></th></tr>
    <tr>
        <td>
            <h4><?php _e( 'Text color', 'BeRocket_products_of_day_domain' ) ?></h4>
            <?php 
            echo br_color_picker(
                'br-products_of_day-options[buttons][' . $button_id . '][default][color]', 
                br_get_value_from_array($options, array('buttons', $button_id, 'default', 'color')), 
                -1
            );
            ?>
        </td>
        <th><?php _e( 'Border width', 'BeRocket_products_of_day_domain' ) ?></th>
        <th><?php _e( 'Paddings', 'BeRocket_products_of_day_domain' ) ?></th>
        <th><?php _e( 'Border round', 'BeRocket_products_of_day_domain' ) ?></th>
    </tr>
    <tr>
        <td>
            <h4><?php _e( 'Text color on mouse over', 'BeRocket_products_of_day_domain' ) ?></h4>
            <?php 
            echo br_color_picker(
                'br-products_of_day-options[buttons][' . $button_id . '][hover][color]', 
                br_get_value_from_array($options, array('buttons', $button_id, 'hover', 'color')), 
                -1
            );
            ?>
        </td>
        <td rowspan="5">
            <p><?php _e( 'Top', 'BeRocket_products_of_day_domain' ) ?></p>
            <input name="br-products_of_day-options[buttons][<?php echo $button_id; ?>][default][border-top-width]" type="text" value="<?php echo ( isset($options['buttons'][$button_id]['default']['border-top-width']) ? $options['buttons'][$button_id]['default']['border-top-width'] : '' ); ?>">
            <p><?php _e( 'Bottom', 'BeRocket_products_of_day_domain' ) ?></p>
            <input name="br-products_of_day-options[buttons][<?php echo $button_id; ?>][default][border-bottom-width]" type="text" value="<?php echo ( isset($options['buttons'][$button_id]['default']['border-bottom-width']) ? $options['buttons'][$button_id]['default']['border-bottom-width'] : '' ); ?>">
            <p><?php _e( 'Left', 'BeRocket_products_of_day_domain' ) ?></p>
            <input name="br-products_of_day-options[buttons][<?php echo $button_id; ?>][default][border-left-width]" type="text" value="<?php echo ( isset($options['buttons'][$button_id]['default']['border-left-width']) ? $options['buttons'][$button_id]['default']['border-left-width'] : '' ); ?>">
            <p><?php _e( 'Right', 'BeRocket_products_of_day_domain' ) ?></p>
            <input name="br-products_of_day-options[buttons][<?php echo $button_id; ?>][default][border-right-width]" type="text" value="<?php echo ( isset($options['buttons'][$button_id]['default']['border-right-width']) ? $options['buttons'][$button_id]['default']['border-right-width'] : '' ); ?>">
        </td>
        <td rowspan="5">
            <p><?php _e( 'Top', 'BeRocket_products_of_day_domain' ) ?></p>
            <input name="br-products_of_day-options[buttons][<?php echo $button_id; ?>][default][padding-top]" type="text" value="<?php echo ( isset($options['buttons'][$button_id]['default']['padding-top']) ? $options['buttons'][$button_id]['default']['padding-top'] : '' ); ?>">
            <p><?php _e( 'Bottom', 'BeRocket_products_of_day_domain' ) ?></p>
            <input name="br-products_of_day-options[buttons][<?php echo $button_id; ?>][default][padding-bottom]" type="text" value="<?php echo ( isset($options['buttons'][$button_id]['default']['padding-bottom']) ? $options['buttons'][$button_id]['default']['padding-bottom'] : '' ); ?>">
            <p><?php _e( 'Left', 'BeRocket_products_of_day_domain' ) ?></p>
            <input name="br-products_of_day-options[buttons][<?php echo $button_id; ?>][default][padding-left]" type="text" value="<?php echo ( isset($options['buttons'][$button_id]['default']['padding-left']) ? $options['buttons'][$button_id]['default']['padding-left'] : '' ); ?>">
            <p><?php _e( 'Right', 'BeRocket_products_of_day_domain' ) ?></p>
            <input name="br-products_of_day-options[buttons][<?php echo $button_id; ?>][default][padding-right]" type="text" value="<?php echo ( isset($options['buttons'][$button_id]['default']['padding-right']) ? $options['buttons'][$button_id]['default']['padding-right'] : '' ); ?>">
        </td>
        <td rowspan="5">
            <p><?php _e( 'Top-Left', 'BeRocket_products_of_day_domain' ) ?></p>
            <input name="br-products_of_day-options[buttons][<?php echo $button_id; ?>][default][border-top-left-radius]" type="text" value="<?php echo ( isset($options['buttons'][$button_id]['default']['border-top-left-radius']) ? $options['buttons'][$button_id]['default']['border-top-left-radius'] : '' ); ?>">
            <p><?php _e( 'Top-Right', 'BeRocket_products_of_day_domain' ) ?></p>
            <input name="br-products_of_day-options[buttons][<?php echo $button_id; ?>][default][border-top-right-radius]" type="text" value="<?php echo ( isset($options['buttons'][$button_id]['default']['border-top-right-radius']) ? $options['buttons'][$button_id]['default']['border-top-right-radius'] : '' ); ?>">
            <p><?php _e( 'Bottom-Right', 'BeRocket_products_of_day_domain' ) ?></p>
            <input name="br-products_of_day-options[buttons][<?php echo $button_id; ?>][default][border-bottom-right-radius]" type="text" value="<?php echo ( isset($options['buttons'][$button_id]['default']['border-bottom-right-radius']) ? $options['buttons'][$button_id]['default']['border-bottom-right-radius'] : '' ); ?>">
            <p><?php _e( 'Bottom-Left', 'BeRocket_products_of_day_domain' ) ?></p>
            <input name="br-products_of_day-options[buttons][<?php echo $button_id; ?>][default][border-bottom-left-radius]" type="text" value="<?php echo ( isset($options['buttons'][$button_id]['default']['border-bottom-left-radius']) ? $options['buttons'][$button_id]['default']['border-bottom-left-radius'] : '' ); ?>">
        </td>
    </tr>
    <tr>
        <td>
            <h4><?php _e( 'Background color', 'BeRocket_products_of_day_domain' ) ?></h4>
            <?php 
            echo br_color_picker(
                'br-products_of_day-options[buttons][' . $button_id . '][default][background-color]', 
                br_get_value_from_array($options, array('buttons', $button_id, 'default', 'background-color')), 
                -1
            );
            ?>
        </td>
    </tr>
    <tr>
        <td>
            <h4><?php _e( 'Background color on mouse over', 'BeRocket_products_of_day_domain' ) ?></h4>
            <?php 
            echo br_color_picker(
                'br-products_of_day-options[buttons][' . $button_id . '][hover][background-color]', 
                br_get_value_from_array($options, array('buttons', $button_id, 'hover', 'background-color')), 
                -1
            );
            ?>
        </td>
    </tr>
    <tr>
        <td>
            <h4><?php _e( 'Border color', 'BeRocket_products_of_day_domain' ) ?></h4>
            <?php 
            echo br_color_picker(
                'br-products_of_day-options[buttons][' . $button_id . '][default][border-color]', 
                br_get_value_from_array($options, array('buttons', $button_id, 'default', 'border-color')), 
                -1
            );
            ?>
        </td>
    </tr>
    <tr>
        <td>
            <h4><?php _e( 'Border color on mouse over', 'BeRocket_products_of_day_domain' ) ?></h4>
            <?php 
            echo br_color_picker(
                'br-products_of_day-options[buttons][' . $button_id . '][hover][border-color]', 
                br_get_value_from_array($options, array('buttons', $button_id, 'hover', 'border-color')), 
                -1
            );
            ?>
        </td>
    
    </tr>
</table>
<?php } ?>
<script>
    jQuery(document).ready(function() {
        jQuery(document).on('change', '.br_prod_of_day_type', function() {
            jQuery('.br_pod_type_block').hide();
            jQuery('.br_pod_type_block_'+jQuery(this).val()).show();
        });
        jQuery(document).on('change', '.br_pod_use_spec_styles', function() {
            if( jQuery(this).prop('checked') ) {
                jQuery('.berocket_pod_styles_'+jQuery(this).data('id')).show();
            } else {
                jQuery('.berocket_pod_styles_'+jQuery(this).data('id')).hide();
            }
        });
    });
</script>
<style>
.berocket_pagination_style .br_colorpicker_default.button {
    margin: 0;
    padding: 0;
}
.berocket_pagination_style .colorpicker_field {
    display: inline-block;
}
</style>
