<?php
/**
 * Универсальное решение для добавления контейнера min-days-info-container во все стили
 * 
 * Этот файл обеспечивает отображение информации о минимальном количестве дней бронирования
 * во всех стилях форм бронирования плагина TM Booking
 */

/**
 * Добавляем фильтр для модификации шорткода tm_booking
 * Этот фильтр вызывается в function/custom_function.php перед возвратом результата шорткода
 */
add_filter('tmbooking_book_form_shortcode', 'tm_booking_ensure_min_days_container', 10, 2);

/**
 * Добавляет контейнер min-days-info-container во все стили форм бронирования,
 * если он отсутствует
 *
 * @param string $html HTML-код формы бронирования
 * @param array $atts Атрибуты шорткода
 * @return string Модифицированный HTML-код
 */
function tm_booking_ensure_min_days_container($html, $atts) {
    // Получаем стиль из атрибутов
    $style = isset($atts['style']) ? $atts['style'] : 'style_one';
    
    // Проверяем наличие контейнера min-days-info-container
    if (strpos($html, 'min-days-info-container') === false) {
        // Определяем паттерны поиска и замены в зависимости от стиля
        switch ($style) {
            case 'style_four':
            case 'style_five':
                // Для стилей four и five ищем после booking_count и перед details-aside-content__total
                $pattern = '/<span class="booking_count booking_count\'\.[\s\S]*?\$ID[\s\S]*?\'">[\s\S]*?<\/span>[\s\n]*<div class="details-aside-content__total/';
                $replacement = '<span class="booking_count booking_count\'\. $ID .\'">[\s\S]*?<\/span>\n\n                                             <div class="min-days-info-container">\n                                             \'\. apply_filters(\'tmbooking_before_book_now_button\', \'\', $ID) .\'\n                                             <\/div>\n                                             \n                                             <div class="details-aside-content__total';
                break;
                
            case 'style_two':
            case 'style_three':
                // Для стилей two и three ищем после booking_count и перед tm_price_total
                $pattern = '/<span class="booking_count booking_count\'\.[\s\S]*?\$ID[\s\S]*?\'">[\s\S]*?<\/span>[\s\n]*<span class="tm_input_container tm_price_total/';
                $replacement = '<span class="booking_count booking_count\'\. $ID .\'">[\s\S]*?<\/span>\n\n                                             <div class="min-days-info-container">\n                                             \'\. apply_filters(\'tmbooking_before_book_now_button\', \'\', $ID) .\'\n                                             <\/div>\n                                             \n                                             <span class="tm_input_container tm_price_total';
                break;
                
            default:
                // Для других стилей не делаем ничего, так как контейнер уже должен быть
                return $html;
        }
        
        // Применяем замену
        $html = preg_replace($pattern, $replacement, $html);
    }
    
    return $html;
}

/**
 * Добавляем фильтр для модификации HTML-кода формы бронирования
 * Этот подход используется как запасной вариант, если первый фильтр не сработает
 */
add_filter('tmbooking_before_book_now_button', 'tm_booking_add_min_days_info', 10, 2);

/**
 * Добавляет информацию о минимальном количестве дней бронирования
 *
 * @param string $html Текущий HTML-код
 * @param int $post_id ID поста
 * @return string Модифицированный HTML-код
 */
function tm_booking_add_min_days_info($html, $post_id) {
    // Получаем минимальное количество дней бронирования
    $min_days = get_post_meta($post_id, 'min_booking_days', true);
    
    // Если минимальное количество дней задано, добавляем информацию
    if (!empty($min_days) && is_numeric($min_days) && intval($min_days) > 1) {
        $message = sprintf(
            esc_html__('Minimum booking period: %s days', 'tm-booking'),
            esc_html($min_days)
        );
        
        $html .= '<div class="min-days-info">' . $message . '</div>';
    }
    
    return $html;
}
