<?php 
$dplugin_name = 'WooCommerce Products of Day';
$dplugin_link = 'http://berocket.com/product/woocommerce-products-of-day';
$dplugin_price = 20;
$dplugin_desc = '';
@ include 'settings_head.php';
?>
<div class="wrap br_settings br_products_of_day_settings">
    <?php settings_errors(); ?>

    <h2 class="nav-tab-wrapper">
        <a href="#general" class="nav-tab nav-tab-active general-tab" data-block="general"><?php _e('General', 'BeRocket_products_of_day_domain') ?></a>
        <a href="#styles" class="nav-tab general-tab" data-block="styles"><?php _e('Styles', 'BeRocket_products_of_day_domain') ?></a>
        <a href="#css" class="nav-tab css-tab" data-block="css"><?php _e('CSS', 'BeRocket_products_of_day_domain') ?></a>
        <a href="#javascript" class="nav-tab javascript-tab" data-block="javascript"><?php _e('JavaScript', 'BeRocket_products_of_day_domain') ?></a>
        <a href="#license" class="nav-tab license-tab" data-block="license"><?php _e('License', 'BeRocket_products_of_day_domain') ?></a>
    </h2>

    <form class="products_of_day_submit_form" method="post" action="options.php">
        <?php 
        $options = BeRocket_products_of_day::get_option(); ?>
        <div class="nav-block general-block nav-block-active">
            <table class="form-table license">
                <tr>
                    <th><?php _e('Position to display products of day', 'BeRocket_products_of_day_domain'); ?></th>
                    <td>
                        <?php 
                        $positions = array(
                            'before_content' => __('Before content', 'BeRocket_products_of_day_domain'),
                            'after_content' => __('After content', 'BeRocket_products_of_day_domain'),
                            'before_footer' => __('Before footer', 'BeRocket_products_of_day_domain'),
                        );
                        foreach($positions as $pos_id => $pos_name) {
                            echo '<p><label><input name="br-products_of_day-options[positions][]" type="checkbox" value="'.$pos_id.'"'.(isset($options['positions']) && is_array($options['positions']) && in_array($pos_id, $options['positions']) ? ' checked' : '').'>'.$pos_name.'</label></p>';
                        }
                        ?>
                    </td>
                </tr>
            <?php 
            $day_weeks = array(
                '0' => __('Sunday', 'BeRocket_products_of_day_domain'),
                '1' => __('Monday', 'BeRocket_products_of_day_domain'),
                '2' => __('Tuesday', 'BeRocket_products_of_day_domain'),
                '3' => __('Wednesday', 'BeRocket_products_of_day_domain'),
                '4' => __('Thursday', 'BeRocket_products_of_day_domain'),
                '5' => __('Friday', 'BeRocket_products_of_day_domain'),
                '6' => __('Saturday', 'BeRocket_products_of_day_domain'),
                '7' => __('Sunday', 'BeRocket_products_of_day_domain'),
            );
            for( $i = 1; $i < 8; $i++ ) {
                echo '<tr><th>', $day_weeks[$i], '</th><td>';
                br_generate_product_selector( array( 
                    'option' => $options['products'][$i], 
                    'block_name' => 'products_of_day', 
                    'name' => 'br-products_of_day-options[products]['.$i.'][]',
                    'action' => 'woocommerce_json_search_products'
                ) );
                echo '</td></tr>';
            }
            ?>
                <tr>
                    <th><?php _e('Shortcode', 'BeRocket_products_of_day_domain'); ?></th>
                    <td>
                        <ul class="br_shortcode_info">
                            <li><strong>[br_products_of_day]</strong>
                                <ul>
                                    <li><i>title</i> - title of widget</li>
                                    <li><i>type</i> - Display type: default or slider</li>
                                    <li><i>products_count</i> - count of products that will be displayed</li>
                                    <li><i>count_line</i> - products per line/slide</li>
                                    <li><i>random</i> - displays random products with random sorting (0 - disable, 1 - enable)</li>
                                    <li><i>thumbnails</i> - show products thumbnails (0 - disable, 1 - enable)</li>
                                    <li><i>add_to_cart</i> - show add to cart button for each (0 - disable, 1 - enable)</li>
                                    <li><i>hide_outofstock</i> - hide products that out of stock (0 - disable, 1 - enable)</li>
                                </ul>
                            </li>
                            <li><strong>[br_products_of_day title="Products of day" products_count=4 count_line=2 thumbnails=1 random=1]</strong> - Display 4 Products of day in 2 lines, uses random products from list for current day</li>
                            <li><strong>[br_products_of_day title="Buy right now" add_to_cart=1 products_count=4 count_line=1 thumbnails=1 type="slider"]</strong> - Products of day slider with 1 product per slide with add to cart button</li>
                            <li><strong>[br_products_of_day title="Products" hide_outofstock=1 add_to_cart=1 products_count=12 thumbnails=1 count_line=3]</strong> - Display products like in WooCommerce shop page</li>
                        </ul>
                        <ul>
                        </ul>
                    </td>
                </tr>
            </table>
            <script>
                (function ($){
                    $(document).ready( function () {
                        jQuery( ".br_products_search" ).sortable({
                            items: "li:not(.br_products_suggest_search)",
                            distance: 5
                        });
                    });
                })(jQuery);
            </script>
        </div>
        <div class="nav-block styles-block">
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
            <div class="colorpicker_field" data-color="<?php echo ( empty($options['buttons'][$button_id]['default']['color']) ) ? '000000' : $options['buttons'][$button_id]['default']['color'];?>"></div>
            <input type="hidden" value="<?php echo ( @ $options['buttons'][$button_id]['default']['color'] ) ? $options['buttons'][$button_id]['default']['color'] : '' ?>" name="br-products_of_day-options[buttons][<?php echo $button_id; ?>][default][color]" />
            <input type="button" value="<?php _e('Default', 'BeRocket_products_of_day_domain') ?>" class="theme_default button">
        </td>
        <th><?php _e( 'Border width', 'BeRocket_products_of_day_domain' ) ?></th>
        <th><?php _e( 'Paddings', 'BeRocket_products_of_day_domain' ) ?></th>
        <th><?php _e( 'Border round', 'BeRocket_products_of_day_domain' ) ?></th>
    </tr>
    <tr>
        <td>
            <h4><?php _e( 'Text color on mouse over', 'BeRocket_products_of_day_domain' ) ?></h4>
            <div class="colorpicker_field" data-color="<?php echo ( ! empty( $options['buttons'][$button_id]['hover']['color'] ) ) ? $options['buttons'][$button_id]['hover']['color'] : '000000' ?>"></div>
            <input type="hidden" value="<?php echo ( ! empty($options['buttons'][$button_id]['hover']['color']) ) ? $options['buttons'][$button_id]['hover']['color'] : '' ?>" name="br-products_of_day-options[buttons][<?php echo $button_id; ?>][hover][color]" />
            <input type="button" value="<?php _e('Default', 'BeRocket_products_of_day_domain') ?>" class="theme_default button">
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
            <div class="colorpicker_field" data-color="<?php echo ( ! empty($options['buttons'][$button_id]['default']['background-color']) ) ? $options['buttons'][$button_id]['default']['background-color'] : '000000' ?>"></div>
            <input type="hidden" value="<?php echo ( ! empty($options['buttons'][$button_id]['default']['background-color']) ) ? $options['buttons'][$button_id]['default']['background-color'] : '' ?>" name="br-products_of_day-options[buttons][<?php echo $button_id; ?>][default][background-color]" />
            <input type="button" value="<?php _e('Default', 'BeRocket_products_of_day_domain') ?>" class="theme_default button">
        </td>
    </tr>
    <tr>
        <td>
            <h4><?php _e( 'Background color on mouse over', 'BeRocket_products_of_day_domain' ) ?></h4>
            <div class="colorpicker_field" data-color="<?php echo ( ! empty($options['buttons'][$button_id]['hover']['background-color']) ) ? $options['buttons'][$button_id]['hover']['background-color'] : '000000' ?>"></div>
            <input type="hidden" value="<?php echo ( ! empty($options['buttons'][$button_id]['hover']['background-color']) ) ? $options['buttons'][$button_id]['hover']['background-color'] : '' ?>" name="br-products_of_day-options[buttons][<?php echo $button_id; ?>][hover][background-color]" />
            <input type="button" value="<?php _e('Default', 'BeRocket_products_of_day_domain') ?>" class="theme_default button">
        </td>
    </tr>
    <tr>
        <td>
            <h4><?php _e( 'Border color', 'BeRocket_products_of_day_domain' ) ?></h4>
            <div class="colorpicker_field" data-color="<?php echo ( ! empty($options['buttons'][$button_id]['default']['border-color']) ) ? $options['buttons'][$button_id]['default']['border-color'] : '000000' ?>"></div>
            <input type="hidden" value="<?php echo ( ! empty($options['buttons'][$button_id]['default']['border-color']) ) ? $options['buttons'][$button_id]['default']['border-color'] : '' ?>" name="br-products_of_day-options[buttons][<?php echo $button_id; ?>][default][border-color]" />
            <input type="button" value="<?php _e('Default', 'BeRocket_products_of_day_domain') ?>" class="theme_default button">
        </td>
    </tr>
    <tr>
        <td>
            <h4><?php _e( 'Border color on mouse over', 'BeRocket_products_of_day_domain' ) ?></h4>
            <div class="colorpicker_field" data-color="<?php echo ( ! empty($options['buttons'][$button_id]['hover']['border-color']) ) ? $options['buttons'][$button_id]['hover']['border-color'] : '000000' ?>"></div>
            <input type="hidden" value="<?php echo ( ! empty($options['buttons'][$button_id]['hover']['border-color']) ) ? $options['buttons'][$button_id]['hover']['border-color'] : '' ?>" name="br-products_of_day-options[buttons][<?php echo $button_id; ?>][hover][border-color]" />
            <input type="button" value="<?php _e('Default', 'BeRocket_products_of_day_domain') ?>" class="theme_default button">
        </td>
    
    </tr>
</table>
<?php } ?>
        </div>
        <div class="nav-block css-block">
            <table class="form-table license">
                <tr>
                    <th scope="row"><?php _e('Disable Font Awesome', 'BeRocket_products_of_day_domain') ?></th>
                    <td>
                        <label>
                            <input name="br-products_of_day-options[fontawesome_frontend_disable]" value="1" type="checkbox"<?php echo ($options['fontawesome_frontend_disable'] ? ' checked' : ''); ?>>
                            <?php _e('Don\'t loading css file for Font Awesome on site front end. Use it only if you doesn\'t uses Font Awesome icons in widgets or you have Font Awesome in your theme.', 'BeRocket_products_of_day_domain') ?>
                        </label>
                    </td>
                </tr>
                <tr>
                    <th scope="row"><?php _e('Font Awesome Version', 'BeRocket_products_of_day_domain') ?></th>
                    <td>
                        <select name="br-products_of_day-options[fontawesome_frontend_version]">
                            <option value=""<?php if(isset($options['fontawesome_frontend_version']) && $options['fontawesome_frontend_version'] == '') echo ' selected'; ?>><?php _e('Font Awesome 4', 'BeRocket_products_of_day_domain') ?></option>
                            <option value="fontawesome5"<?php if(isset($options['fontawesome_frontend_version']) && $options['fontawesome_frontend_version'] == 'fontawesome5') echo ' selected'; ?>><?php _e('Font Awesome 5', 'BeRocket_products_of_day_domain') ?></option>
                        </select>
                        <?php _e('Version of Font Awesome that will be used on front end. Please select version that you have in your theme', 'BeRocket_products_of_day_domain'); ?>
                    </td>
                </tr>
                <tr>
                    <th scope="row"><?php _e('Custom CSS', 'BeRocket_products_of_day_domain') ?></th>
                    <td>
                        <textarea name="br-products_of_day-options[custom_css]"><?php echo $options['custom_css']?></textarea>
                    </td>
                </tr>
            </table>
        </div>
        <div class="nav-block javascript-block">
            <table class="form-table license">
                <tr>
                    <th scope="row"><?php _e('On Page Load', 'BeRocket_products_of_day_domain') ?></th>
                    <td>
                        <textarea name="br-products_of_day-options[script][js_page_load]"><?php echo $options['script']['js_page_load']?></textarea>
                    </td>
                </tr>
            </table>
        </div>
        <div class="nav-block license-block">
            <table class="form-table license">
                <tr>
                    <th scope="row"><?php _e('Plugin key', 'BeRocket_products_of_day_domain') ?></th>
                    <td>
                        <input id="berocket_product_key" size="50" name="br-products_of_day-options[plugin_key]" type='text' value='<?php echo $options['plugin_key']?>'/>
                        <br />
                        <span style="color:#666666;margin-left:2px;"><?php _e('Key for plugin from BeRocket.com', 'BeRocket_products_of_day_domain') ?></span>
                        <br />
                        <input class="berocket_test_account_product button-secondary" data-id="16" type="button" value="Test">
                        <div class="berocket_test_result"></div>
                    </td>
                </tr>
            </table>
        </div>
        <input type="submit" class="button-primary" value="<?php _e('Save Changes', 'BeRocket_products_of_day_domain') ?>" />
        <div class="br_save_error"></div>
    </form>
</div>
<?php
$feature_list = array();
@ include 'settings_footer.php';
?>
