(function ($) {
    'use strict';

    $(document).on('change', '.bms-menu-options input[type="checkbox"]', function () {
        $(this).closest('.bms-menu-options').find('.bms-mega-extra').toggle(this.checked);
    });

    $(document).on('click', '.bms-select-image', function (e) {
        e.preventDefault();
        var $wrap = $(this).closest('.bms-menu-options');
        var frame = wp.media({
            title: 'Select Mega Menu Image',
            button: { text: 'Use this image' },
            multiple: false,
            library: { type: 'image' }
        });

        frame.on('select', function () {
            var image = frame.state().get('selection').first().toJSON();
            var url = image.sizes && image.sizes.thumbnail ? image.sizes.thumbnail.url : image.url;
            $wrap.find('.bms-image-id').val(image.id);
            $wrap.find('.bms-image-preview').html('<img src="' + url + '" alt="" style="max-width:120px;height:auto;display:block;">');
            $wrap.find('.bms-remove-image').show();
        });

        frame.open();
    });

    $(document).on('click', '.bms-remove-image', function (e) {
        e.preventDefault();
        var $wrap = $(this).closest('.bms-menu-options');
        $wrap.find('.bms-image-id').val('');
        $wrap.find('.bms-image-preview').empty();
        $(this).hide();
    });
}(jQuery));
