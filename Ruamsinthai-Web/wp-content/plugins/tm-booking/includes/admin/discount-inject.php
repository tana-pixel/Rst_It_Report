<?php
/**
 * TM Booking Discount Inject
 *
 * @package TM Booking
 */

// Exit if accessed directly
if (!defined('ABSPATH')) {
    exit;
}

/**
 * Add discount toggle directly to the Booking metabox
 */
function tm_booking_add_discount_inject() {
    // Add our script to the admin footer
    add_action('admin_footer', 'tm_booking_inject_discount_setting');
    
    // Save our setting when the post is saved
    add_action('save_post', 'tm_booking_save_discount_setting', 10, 2);
    
    // Initialize settings
    add_action('admin_init', 'tm_booking_initialize_discount_inject');
}
add_action('admin_init', 'tm_booking_add_discount_inject');

/**
 * Inject discount setting into the Booking metabox
 */
function tm_booking_inject_discount_setting() {
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
        // Функция для добавления настройки
        function injectDiscountSetting() {
            // Находим метабокс Booking
            var $bookingBox = $('#booking');
            
            // Если метабокс найден
            if ($bookingBox.length > 0) {
                // Находим таблицу внутри метабокса
                var $table = $bookingBox.find('.inside table.form-table');
                
                // Если таблица найдена и наша настройка еще не добавлена
                if ($table.length > 0 && $table.find('#tm_booking_show_discounts').length === 0) {
                    // Создаем строку с нашей настройкой
                    var $row = $('<tr></tr>');
                    var $th = $('<th scope="row"></th>').appendTo($row);
                    var $label = $('<label for="tm_booking_show_discounts"><?php echo esc_js(__('Show Discounts', 'tm-booking')); ?></label>').appendTo($th);
                    var $td = $('<td></td>').appendTo($row);
                    var $select = $('<select id="tm_booking_show_discounts" name="tm_booking_show_discounts"></select>').appendTo($td);
                    
                    // Добавляем опции
                    $('<option value="yes" <?php echo $show_discounts === 'yes' ? 'selected="selected"' : ''; ?>><?php echo esc_js(__('Yes', 'tm-booking')); ?></option>').appendTo($select);
                    $('<option value="no" <?php echo $show_discounts === 'no' ? 'selected="selected"' : ''; ?>><?php echo esc_js(__('No', 'tm-booking')); ?></option>').appendTo($select);
                    
                    // Добавляем строку в таблицу
                    $table.append($row);
                    
                    // Добавляем скрытое поле для сохранения настройки
                    if ($('#tm_booking_show_discounts_hidden').length === 0) {
                        $('<input type="hidden" id="tm_booking_show_discounts_hidden" name="tm_booking_show_discounts" value="<?php echo esc_attr($show_discounts); ?>" />').appendTo('form#post');
                        
                        // Синхронизируем значение скрытого поля с селектом
                        $select.on('change', function() {
                            $('#tm_booking_show_discounts_hidden').val($(this).val());
                        });
                    }
                }
            }
        }
        
        // Запускаем функцию при загрузке страницы
        injectDiscountSetting();
        
        // Запускаем функцию при изменении DOM
        var observer = new MutationObserver(function(mutations) {
            injectDiscountSetting();
        });
        
        // Наблюдаем за изменениями в DOM
        observer.observe(document.body, { childList: true, subtree: true });
        
        // Также запускаем функцию при клике на метабокс (на случай, если он был свернут)
        $(document).on('click', '#booking .handlediv', function() {
            setTimeout(injectDiscountSetting, 100);
        });
    });
    </script>
    <?php
}

/**
 * Save discount setting
 */
function tm_booking_save_discount_setting($post_id, $post) {
    // Check if our field is set
    if (!isset($_POST['tm_booking_show_discounts'])) {
        return;
    }
    
    // Check user permissions
    if (!current_user_can('edit_post', $post_id)) {
        return;
    }
    
    // Sanitize and save the setting
    $show_discounts = sanitize_text_field($_POST['tm_booking_show_discounts']);
    $booking_settings = get_option('tm_booking_settings', []);
    $booking_settings['show_discounts'] = $show_discounts;
    update_option('tm_booking_settings', $booking_settings);
}

/**
 * Initialize discount settings with default values
 */
function tm_booking_initialize_discount_inject() {
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
