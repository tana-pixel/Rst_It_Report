jQuery.noConflict()(function($) {

    jQuery('.book_now_btn').on('click', function () {
        var btn = $(this);
        var originalText = btn.html();
        btn.html(btn.data('wait'));

        formData = getFormData(jQuery(this).parent('form'));
        var data = {
            action: 'tmbooking_redirect_to_cart',
            data: formData
        };

        jQuery.post( tm_booking_ajax.url, data, function(response) {

             //console.log(response);

            if(response.redirect != undefined){
                document.location.href = response.redirect;
            } else {
                // Возвращаем исходный текст кнопки, если нет перенаправления
                btn.html(originalText);
            }

            if(response.error != undefined){
                $(".tm_price_total").html(response.error).removeClass('tm_empty_container');
            }
        });
    });

    jQuery('.tm-js-select').niceSelect();


    jQuery("form.booking_form").change(function(event){
        var form = jQuery(this);
        formData = getFormData(form);
        var ID = form.children('.hidden_id').val();
        var this_form = jQuery('form.booking_form');
        var button = form.find('.book_now_btn');
        
        // Проверяем, не вызвано ли это событие изменением даты
        var dateChanged = event.target && ($(event.target).hasClass('tm_booking_date') || 
                                          $(event.target).hasClass('start_date') || 
                                          $(event.target).hasClass('end_date'));
        // Если изменились даты, сначала скрываем кнопку до проверки минимальных дней
        if (dateChanged) {
            console.log('Date fields changed, hiding button until min days check completes');
            button.addClass('min-day-hide');
            form.data('min-days-checked', 'pending');
        }

        if(form.find('.start_date').val() !== '' && form.find('.end_date').val() !== ''){
            this_form.addClass('loading');
            var data = {
                action: "tmbooking_change_total",
                data: formData
            };
            $.post(tm_booking_ajax.url, data, function(response) {
                // Удаляем класс tm_empty_container при заполнении контейнера
                $(".tm_price_total" + ID).html(response).removeClass('tm_empty_container');
                this_form.removeClass('loading');
                
                // Не показываем кнопку, если проверка минимальных дней не пройдена
                if (form.data('min-days-checked') !== 'passed') {
                    console.log('Price updated but min days check not passed yet, keeping button hidden');
                    button.addClass('min-day-hide');
                } else {
                    console.log('Price updated and min days check passed, showing button');
                    button.removeClass('min-day-hide');
                }
            });
        }

    });


    function getFormData($form){
        var unindexed_array = $form.serializeArray();
        var indexed_array = {};
        var extra_ids_val = "";

        $.map(unindexed_array, function(n, i){
            indexed_array[n['name']] = n['value'];
            if(n["name"] === "extra[]"){
                extra_ids_val += n["value"] + ",";
            }
            indexed_array["extra_ids"] = extra_ids_val.slice(0,-1);
        });

        return indexed_array;
    }

});