var br_pod_init_slider = function() {
    jQuery('.br_pod_slider').not('.br_pod_slider_ready').unslider({
    arrows: {
        prev: '<a class="unslider-arrow prev"></a>',
        next: '<a class="unslider-arrow next"></a>',
    },
    autoplay: true}).addClass('br_pod_slider_ready');
};
(function ($){
    $(document).ready( function () {
        products_of_day_execute_func( the_products_of_day_js_data.script.js_page_load );
        jQuery(document).trigger('berocket_product_of_day-js_page_load');
        br_pod_init_slider();
        jQuery( document ).on( "ajaxComplete", br_pod_init_slider);
        document.addEventListener("br_update_et_product_of_day", br_pod_init_slider);
    });
})(jQuery);
function products_of_day_execute_func ( func ) {
    if( the_products_of_day_js_data.script != 'undefined'
        && the_products_of_day_js_data.script != null
        && typeof func != 'undefined' 
        && func.length > 0 ) {
        try{
            eval( func );
        } catch(err){
            alert('You have some incorrect JavaScript code (Product Of The Day)');
        }
    }
}
