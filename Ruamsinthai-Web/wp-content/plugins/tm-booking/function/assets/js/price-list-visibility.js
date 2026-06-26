/**
 * JavaScript for price list visibility
 */
(function($) {
    'use strict';
    
    $(document).ready(function() {
        // Функция для применения класса видимости к блокам с ценами
        function applyPriceListVisibility() {
            // Получаем ID текущего продукта
            var productId = $('input[name="product_id"]').val();
            
            if (productId) {
                // Отправляем AJAX запрос для получения класса видимости
                $.ajax({
                    url: tm_booking_ajax.ajax_url,
                    type: 'POST',
                    data: {
                        action: 'tmbooking_get_price_list_visibility',
                        security: tm_booking_ajax.nonce,
                        product_id: productId
                    },
                    success: function(response) {
                        if (response.success && response.data) {
                            // Если нужно скрыть блок с ценами, добавляем класс
                            if (response.data === 'hide') {
                                $('.car_premium_price').addClass('car_premium_price_hide');
                            } else {
                                $('.car_premium_price').removeClass('car_premium_price_hide');
                            }
                        }
                    }
                });
            }
        }
        
        // Применяем видимость при загрузке страницы
        applyPriceListVisibility();
    });
})(jQuery);
