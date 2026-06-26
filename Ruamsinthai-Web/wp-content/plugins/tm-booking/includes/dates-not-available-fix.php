<?php
/**
 * Исправление для блокировки недоступных дат в календаре для всех стилей форм бронирования
 * 
 * Этот файл модифицирует JavaScript-код инициализации календаря для всех стилей форм бронирования,
 * чтобы недоступные даты полностью блокировались
 */

/**
 * Добавляем фильтр для модификации JavaScript-кода инициализации календаря
 */
add_filter('tmbooking_book_form_shortcode', 'tm_booking_block_unavailable_dates', 999, 2);

/**
 * Модифицирует JavaScript-код инициализации календаря для блокировки недоступных дат
 *
 * @param string $html HTML-код формы бронирования
 * @param array $atts Атрибуты шорткода
 * @return string Модифицированный HTML-код
 */
function tm_booking_block_unavailable_dates($html, $atts) {
    // Получаем стиль из атрибутов
    $style = isset($atts['style']) ? $atts['style'] : 'style_one';
    
    // Ищем скрипт инициализации daterangepicker
    $pattern = '/\$\(".tm_booking_date\'\.\ \$ID\.\'"\)\.daterangepicker\(/';
    
    // Проверяем, найден ли скрипт инициализации
    if (preg_match($pattern, $html)) {
        // Добавляем JavaScript-код для блокировки недоступных дат после загрузки страницы
        $script = '<script type="text/javascript">
        jQuery(document).ready(function($) {
            // Ждем полной загрузки daterangepicker
            setTimeout(function() {
                // Находим все элементы с классом "off" или "disabled"
                $(".daterangepicker td.off, .daterangepicker td.disabled").each(function() {
                    // Добавляем обработчик события, который предотвращает выбор
                    $(this).on("click", function(e) {
                        e.preventDefault();
                        e.stopPropagation();
                        return false;
                    });
                    
                    // Добавляем атрибут disabled
                    $(this).attr("disabled", "disabled");
                    
                    // Добавляем дополнительный класс для визуального отображения
                    $(this).addClass("tm-booking-date-unavailable");
                });
            }, 500);
        });
        </script>';
        
        // Добавляем CSS для стилизации недоступных дат
        $style_css = '<style>
        .daterangepicker td.off, 
        .daterangepicker td.disabled, 
        .daterangepicker td.tm-booking-date-unavailable {
            background-color: #f1f1f1 !important;
            color: #ccc !important;
            text-decoration: line-through !important;
            cursor: not-allowed !important;
            pointer-events: none !important;
        }
        </style>';
        
        // Добавляем скрипт и стили в конец HTML-кода
        $html .= $style_css . $script;
    }
    
    return $html;
}
