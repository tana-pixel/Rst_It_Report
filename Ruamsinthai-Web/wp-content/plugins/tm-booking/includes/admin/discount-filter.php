<?php
/**
 * TM Booking Discount Filter
 *
 * @package TM Booking
 */

// Exit if accessed directly
if (!defined('ABSPATH')) {
    exit;
}

/**
 * Add discount toggle using WordPress filters
 */
function tm_booking_add_discount_filter() {
    // Filter the post data before saving
    add_filter('wp_insert_post_data', 'tm_booking_filter_post_data', 10, 2);
    
    // Add our setting to the form using output buffer
    add_action('admin_head', 'tm_booking_add_discount_style');
    add_action('admin_footer', 'tm_booking_add_discount_script');
    
    // Add hidden field to ensure our setting is always saved
    add_action('edit_form_after_title', 'tm_booking_add_hidden_discount_field');
}
add_action('admin_init', 'tm_booking_add_discount_filter');

/**
 * Add CSS for our setting
 */
function tm_booking_add_discount_style() {
    ?>
    <style type="text/css">
    .tm-booking-discount-row {
        background-color: #f9f9f9;
    }
    </style>
    <?php
}

/**
 * Add script to inject our setting
 */
function tm_booking_add_discount_script() {
    // Only run on post edit screens
    $screen = get_current_screen();
    if (!$screen || $screen->base !== 'post') {
        return;
    }
    
    // Get current settings
    $booking_settings = get_option('tm_booking_settings', []);
    $show_discounts = isset($booking_settings['show_discounts']) ? $booking_settings['show_discounts'] : 'yes';
    
    ?>
    <script type="text/javascript">
    jQuery(document).ready(function($) {
        // Функция для добавления нашей настройки
        function addDiscountSetting() {
            // Находим таблицу в метабоксе Booking
            var $tables = $('.postbox .inside table.form-table');
            
            if ($tables.length) {
                $tables.each(function() {
                    var $table = $(this);
                    // Проверяем, содержит ли таблица поля, связанные с бронированием
                    if ($table.find('select[name="show_booking_form"]').length || 
                        $table.find('select[id="show_booking_form"]').length) {
                        
                        // Проверяем, не добавлена ли уже наша настройка
                        if ($table.find('#tm_booking_show_discounts').length === 0) {
                            // Создаем HTML для нашей настройки
                            var html = '<tr class="tm-booking-discount-row">' +
                                '<th scope="row"><label for="tm_booking_show_discounts"><?php echo esc_js(__('Show Discounts', 'tm-booking')); ?></label></th>' +
                                '<td><select id="tm_booking_show_discounts" name="tm_booking_show_discounts">' +
                                '<option value="yes" <?php echo $show_discounts === 'yes' ? 'selected' : ''; ?>><?php echo esc_js(__('Yes', 'tm-booking')); ?></option>' +
                                '<option value="no" <?php echo $show_discounts === 'no' ? 'selected' : ''; ?>><?php echo esc_js(__('No', 'tm-booking')); ?></option>' +
                                '</select></td>' +
                                '</tr>';
                            
                            // Добавляем нашу настройку в таблицу
                            $table.append(html);
                        }
                        
                        return false; // Прерываем цикл
                    }
                });
            }
            
            // Альтернативный подход - добавляем в любой метабокс с заголовком "Booking"
            $('.postbox').each(function() {
                var $box = $(this);
                var title = $box.find('.hndle').text().trim();
                
                if (title === 'Booking') {
                    var $table = $box.find('table.form-table');
                    if ($table.length && $table.find('#tm_booking_show_discounts').length === 0) {
                        var html = '<tr class="tm-booking-discount-row">' +
                            '<th scope="row"><label for="tm_booking_show_discounts"><?php echo esc_js(__('Show Discounts', 'tm-booking')); ?></label></th>' +
                            '<td><select id="tm_booking_show_discounts" name="tm_booking_show_discounts">' +
                            '<option value="yes" <?php echo $show_discounts === 'yes' ? 'selected' : ''; ?>><?php echo esc_js(__('Yes', 'tm-booking')); ?></option>' +
                            '<option value="no" <?php echo $show_discounts === 'no' ? 'selected' : ''; ?>><?php echo esc_js(__('No', 'tm-booking')); ?></option>' +
                            '</select></td>' +
                            '</tr>';
                        
                        $table.append(html);
                    }
                }
            });
        }
        
        // Добавляем настройку при загрузке страницы
        addDiscountSetting();
        
        // Также добавляем настройку при изменении DOM (например, при сворачивании/разворачивании метабокса)
        var observer = new MutationObserver(function(mutations) {
            addDiscountSetting();
        });
        
        // Наблюдаем за изменениями в DOM
        observer.observe(document.body, { childList: true, subtree: true });
    });
    </script>
    <?php
}

/**
 * Add hidden field to ensure our setting is always present in the form
 */
function tm_booking_add_hidden_discount_field() {
    $booking_settings = get_option('tm_booking_settings', []);
    $show_discounts = isset($booking_settings['show_discounts']) ? $booking_settings['show_discounts'] : 'yes';
    
    echo '<input type="hidden" id="tm_booking_show_discounts_hidden" name="tm_booking_show_discounts" value="' . esc_attr($show_discounts) . '" />';
    
    // Добавляем скрипт для синхронизации скрытого поля с видимым селектом
    ?>
    <script type="text/javascript">
    jQuery(document).ready(function($) {
        $(document).on('change', '#tm_booking_show_discounts', function() {
            $('#tm_booking_show_discounts_hidden').val($(this).val());
        });
    });
    </script>
    <?php
}

/**
 * Filter post data before saving to handle our setting
 */
function tm_booking_filter_post_data($data, $postarr) {
    // Check if our field is set
    if (isset($_POST['tm_booking_show_discounts'])) {
        // Sanitize the value
        $show_discounts = sanitize_text_field($_POST['tm_booking_show_discounts']);
        
        // Save to options
        $booking_settings = get_option('tm_booking_settings', []);
        $booking_settings['show_discounts'] = $show_discounts;
        update_option('tm_booking_settings', $booking_settings);
    }
    
    return $data;
}

/**
 * Initialize discount settings with default values
 */
function tm_booking_initialize_discount_settings() {
    $booking_settings = get_option('tm_booking_settings', []);
    
    // If settings is not an array, create empty array
    if (!is_array($booking_settings)) {
        $booking_settings = [];
    }
    
    // Set default value for show_discounts if not set
    if (!isset($booking_settings['show_discounts'])) {
        $booking_settings['show_discounts'] = 'yes';
        update_option('tm_booking_settings', $booking_settings);
    }
}
add_action('admin_init', 'tm_booking_initialize_discount_settings');
