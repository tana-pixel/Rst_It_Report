jQuery(function($){
    "use strict";

    var button = $('.fl-load-more-cars-vc-enable'),
            page = 2,
            loading = false;
        $('body').on('click', '.fl-load-more-cars-vc-enable', function () {
            button.addClass('loading');
            button.text(autlinesloadmorecarvc.button_loading);
            let car_per_page       = $(this).attr('data-car-per-page');

            if (!loading) {
                loading = true;
                let data = {
                    action:             'autlines_ajax_load_more_car_vc',
                    car_per_page:       car_per_page,
                    nonce:              autlinesloadmorecarvc.nonce,
                    page:               page,
                    query:              autlinesloadmorecarvc.query,
                };
                $.post(autlinesloadmorecarvc.url, data, function (res) {

                    if (res.success) {
                        let $content = $(res.data);

                        $('.vc-cars-wrapper').append($content);
                        fl_theme.initVcCustomFunction();
                        //Hide the Load More button if no more posts to load
                        if (page == autlinesloadmorecarvc.maxpage) {
                            button.text(autlinesloadmorecarvc.button_text_no_post);
                            button.removeClass('fl-load-more-cars-vc-enable');
                        } else {
                            button.text(autlinesloadmorecarvc.button_text);
                        }
                        page = page + 1;

                        loading = false;
                        button.removeClass('loading');
                    } else {
                        // console.log(res);

                    }
                }).fail(function (xhr, textStatus, e) {
                    // console.log(xhr.responseText);
                });
            }
        });

});