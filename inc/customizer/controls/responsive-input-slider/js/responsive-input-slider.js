jQuery(document).ready(function ($) {

    $('.wpbf-responsive-input-slider-wrap .customize-control-slider-value').on('keyup', function () {

        var parent = $(this).parents('.wpbf-responsive-input-slider-wrap'),
            dbstore_cache = $('.wpbf-responsive-input-slider-db', parent),
            dbstore = dbstore_cache.val(),
            device_type = $(this).data('device-type');

        dbstore = dbstore === '' ? {} : JSON.parse(dbstore);

        dbstore[device_type] = this.value;

        dbstore_cache.val(JSON.stringify(dbstore)).change();
    })

});
