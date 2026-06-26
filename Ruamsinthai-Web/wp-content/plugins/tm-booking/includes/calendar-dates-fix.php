<?php
/**
 * Унификация обработки недоступных дат в календаре для всех стилей форм бронирования
 * 
 * Этот файл модифицирует JavaScript-код инициализации календаря для всех стилей форм бронирования,
 * чтобы недоступные даты полностью блокировались, как в стиле equipment-booking-style_four
 */

/**
 * Добавляем фильтр для модификации JavaScript-кода инициализации календаря
 */
add_filter('tmbooking_book_form_shortcode', 'tm_booking_unify_calendar_dates_handling', 10, 2);

/**
 * Модифицирует JavaScript-код инициализации календаря для всех стилей форм бронирования
 *
 * @param string $html HTML-код формы бронирования
 * @param array $atts Атрибуты шорткода
 * @return string Модифицированный HTML-код
 */
function tm_booking_unify_calendar_dates_handling($html, $atts) {
    // Получаем стиль из атрибутов
    $style = isset($atts['style']) ? $atts['style'] : 'style_one';
    
    // Если это не стиль four или five, заменяем isCustomDate на isInvalidDate
    if ($style !== 'style_four' && $style !== 'style_five') {
        // Ищем функцию isCustomDate
        $pattern = '/isCustomDate:\s*function\s*\(\s*data\s*\)\s*\{\s*var\s*date_text\s*=\s*moment\(\s*data\s*\)\.format\([^)]+\);\s*return\s*templines_date_class\[\s*date_text\s*\];\s*\}/';
        
        // Заменяем на функцию isInvalidDate, как в стиле four
        $replacement = 'isInvalidDate: function(ele) {
                                                                 var currDate = moment(ele._d).format("' . (isset($atts['date_format']) ? $atts['date_format'] : 'DD/MM/YYYY') . '");
                                                                 return templines_date_class.indexOf(currDate) != -1;
                                                             }';
        
        $html = preg_replace($pattern, $replacement, $html);
    }
    
    return $html;
}

/**
 * Добавляем фильтр для модификации массива недоступных дат
 */
add_filter('tmbooking_disable_dates_js', 'tm_booking_format_disable_dates_for_invalid', 10, 2);

/**
 * Модифицирует формат массива недоступных дат для использования с isInvalidDate
 *
 * @param string $disable_dates_js JavaScript-код с массивом недоступных дат
 * @param array $atts Атрибуты шорткода
 * @return string Модифицированный JavaScript-код
 */
function tm_booking_format_disable_dates_for_invalid($disable_dates_js, $atts) {
    // Получаем стиль из атрибутов
    $style = isset($atts['style']) ? $atts['style'] : 'style_one';
    
    // Если это не стиль four или five, преобразуем формат массива недоступных дат
    if ($style !== 'style_four' && $style !== 'style_five') {
        // Заменяем ассоциативный массив на обычный массив
        $disable_dates_js = str_replace(
            ['templines_date_class = {', ': "off disabled",', ': "weekend off disabled",', '}'],
            ['templines_date_class = [', ',', ',', ']'],
            $disable_dates_js
        );
        
        // Удаляем кавычки вокруг ключей
        $disable_dates_js = preg_replace('/"([^"]+)"(?=,)/', '$1', $disable_dates_js);
    }
    
    return $disable_dates_js;
}
