<?php
/**
 * JavaScript for displaying discount information
 */

if (!defined('ABSPATH')) {
    exit;
}

/**
 * Add JavaScript to display discount information
 */
function tmbooking_discount_js() {
    ?>
    <script type="text/javascript">
    jQuery(document).ready(function($) {
        // Функция для отображения информации о скидке
        function displayDiscountInfo(container, days, percent, description) {
            // Проверяем, есть ли скидка
            if (percent > 0) {
                // Блок скидки создается в discount-calculation.php
                // Здесь только модифицируем отображение цены
                
                // Получаем текущую цену
                var priceElement = container.find('.total_price span');
                if (priceElement.length) {
                    var priceText = priceElement.text();
                    var price = parseFloat(priceText.replace(/[^0-9.]/g, ''));
                    var currency = priceText.replace(price, '');
                    
                    // Рассчитываем исходную цену
                    var originalPrice = price * 100 / (100 - percent);
                    originalPrice = Math.round(originalPrice * 100) / 100;
                    
                    // Обновляем отображение цены
                    priceElement.html('<span class="original-price" style="text-decoration: line-through; color: #999; display: block; font-size: 14px;">' + originalPrice + currency + '</span><span style="color: #e44; font-weight: bold;">' + price + currency + '</span>');
                }
                
                // Не создаем блок скидки здесь, так как он создается в discount-calculation.php
            } else {
                // Если скидки нет, не очищаем блок, так как он должен всегда отображаться
                // Плейсхолдер будет добавлен в discount-persist.js
            }
        }

        // Обработчик события изменения дат
        $(document).on('change', '.tm_booking_date', function() {
            var container = $(this).closest('form');
            var postId = container.data('id');

            // Ждем, пока обновится цена
            setTimeout(function() {
                // Получаем количество дней
                var days = parseInt(container.find('.diff' + postId).val()) || 0;

                // Получаем информацию о скидках через AJAX
                $.ajax({
                    url: tm_booking_ajax.url,
                    type: 'POST',
                    data: {
                        action: 'get_discount_info',
                        post_id: postId,
                        days: days
                    },
                    success: function(response) {
                        if (response.success && response.data) {
                            displayDiscountInfo(
                                container.find('.tm_price_total'),
                                days,
                                response.data.percent,
                                response.data.description
                            );
                        }
                    }
                });
            }, 1000); // Ждем 1 секунду, чтобы дать время для обновления цены
        });
        
        // Также обрабатываем событие обновления цены
        $(document).ajaxComplete(function(event, xhr, settings) {
            if (settings.url.indexOf('tmbooking_change_total') > -1) {
                var data = settings.data;
                var match = data.match(/id=(\d+)/);
                if (match && match[1]) {
                    var postId = match[1];
                    var container = $('.booking_form' + postId);
                    
                    // Получаем количество дней
                    var days = parseInt(container.find('.diff' + postId).val()) || 0;
                    
                    // Получаем информацию о скидках через AJAX
                    $.ajax({
                        url: tm_booking_ajax.url,
                        type: 'POST',
                        data: {
                            action: 'get_discount_info',
                            post_id: postId,
                            days: days
                        },
                        success: function(response) {
                            if (response.success && response.data) {
                                displayDiscountInfo(
                                    container.find('.tm_price_total'),
                                    days,
                                    response.data.percent,
                                    response.data.description
                                );
                            }
                        }
                    });
                }
            }
        });
    });
    </script>
    <?php
}
add_action('wp_footer', 'tmbooking_discount_js');

/**
 * AJAX handler for getting discount information
 */
function tmbooking_get_discount_info_callback() {
    // Проверяем наличие необходимых параметров
    if (!isset($_POST['post_id']) || !isset($_POST['days'])) {
        wp_send_json_error();
    }
    
    $post_id = intval($_POST['post_id']);
    $days = intval($_POST['days']);
    
    // Получаем процент скидки
    $percent = tmbooking_get_discount_percent_all($post_id, $days);
    
    // Получаем информацию о скидке
    $discount_term = null;
    $discount_terms = get_the_terms($post_id, 'transports-discount');
    $selected_discount_day = -1;
    
    if (!empty($discount_terms)) {
        foreach ($discount_terms as $term) {
            $term_percent = tmbooking_get_term_metabox('discount_percent', $term->term_id);
            $start_day = tmbooking_get_term_metabox('start_day', $term->term_id);
            
            if (empty($start_day)) {
                $start_day = 0;
            } else {
                $start_day = intval($start_day);
            }
            
            if (!empty($term_percent) && $days >= $start_day) {
                if ($start_day > $selected_discount_day) {
                    $discount_term = $term;
                    $selected_discount_day = $start_day;
                }
            }
        }
    }
    
    // Формируем ответ
    $response = array(
        'percent' => $percent,
        'description' => $discount_term ? $discount_term->name : '',
        'start_day' => $selected_discount_day
    );
    
    // Removed discount logging
    
    wp_send_json_success($response);
}
add_action('wp_ajax_get_discount_info', 'tmbooking_get_discount_info_callback');
add_action('wp_ajax_nopriv_get_discount_info', 'tmbooking_get_discount_info_callback');
