(function ($) {

    'use strict';

    $(window).on('elementor/frontend/init', function () {

            elementorFrontend.hooks.addAction('frontend/element_ready/tmbooking-booking.default', function ($scope) {
                jQuery('.tm-js-select').niceSelect();

            });




    });

})(jQuery);
