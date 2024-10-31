(function ($){
    $(document).ready( function () {
        $(document).on('change', '.br_prod_of_day_type', function() {
            $('.br_pod_type_block').hide();
            $('.br_pod_type_block_'+$(this).val()).show();
        });
        $(document).on('change', '.br_pod_use_spec_styles', function() {
            if( $(this).prop('checked') ) {
                $('.berocket_pod_styles_'+$(this).data('id')).show();
            } else {
                $('.berocket_pod_styles_'+$(this).data('id')).hide();
            }
        });
    });
})(jQuery);
