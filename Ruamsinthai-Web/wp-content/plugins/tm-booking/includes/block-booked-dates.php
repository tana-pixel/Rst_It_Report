<?php
/**
 * Блокировка забронированных дат в календаре для всех стилей форм бронирования
 * 
 * Этот файл подключает JavaScript-скрипт, который блокирует выбор забронированных дат
 * в календаре для всех стилей форм бронирования плагина TM Booking
 */

// Добавляем хук для подключения скрипта
add_action('wp_enqueue_scripts', 'tm_booking_enqueue_block_booked_dates_script');

/**
 * Подключает JavaScript-скрипт для блокировки забронированных дат в календаре
 */
function tm_booking_enqueue_block_booked_dates_script() {
    // Проверяем, загружен ли jQuery
    if (!wp_script_is('jquery', 'enqueued')) {
        wp_enqueue_script('jquery');
    }
    
    // Подключаем наш скрипт
    wp_enqueue_script(
        'tm-booking-block-booked-dates',
        plugins_url('/assets/js/block-booked-dates.js', dirname(__FILE__)),
        array('jquery'),
        '1.0.0',
        true
    );
    
    // Добавляем CSS-стили для блокированных дат
    wp_add_inline_style('tm-booking-main', '
        .daterangepicker td.tm-booking-date-blocked {
            background-color: #ffeeee !important;
            color: #d9534f !important;
            text-decoration: line-through !important;
            cursor: not-allowed !important;
            opacity: 0.7;
            pointer-events: none;
        }
        .daterangepicker td.tm-booking-date-blocked:hover {
            background-color: #ffeeee !important;
        }
    ');
}
