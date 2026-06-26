<?php
/**
 * Script to fix price list visibility in custom_function.php
 *
 * @package TM-Booking
 */

// Получаем путь к файлу custom_function.php
$custom_function_file = __DIR__ . '/custom_function.php';

// Проверяем, существует ли файл
if (!file_exists($custom_function_file)) {
    echo "Файл custom_function.php не найден.\n";
    exit;
}

// Читаем содержимое файла
$content = file_get_contents($custom_function_file);

// Создаем функцию для получения класса видимости
$visibility_function = <<<'EOD'
/**
 * Check if price list block should be shown or hidden
 *
 * @param int $post_id Post ID
 * @return string CSS class to add to the price list block
 */
function tmbooking_get_price_list_visibility_class($post_id = null) {
    if (is_null($post_id)) {
        global $post;
        if (isset($post->ID)) {
            $post_id = $post->ID;
        }
    }
    
    $show_price_list = get_post_meta($post_id, 'price_section_show_price_list', true);
    
    if ($show_price_list === 'hide') {
        return 'car_premium_price_hide';
    }
    
    return '';
}

EOD;

// Проверяем, есть ли уже эта функция в файле
if (strpos($content, 'function tmbooking_get_price_list_visibility_class') === false) {
    // Находим позицию последней функции перед началом хуков
    $pos = strpos($content, 'add_filter(');
    if ($pos !== false) {
        // Вставляем нашу функцию перед первым хуком
        $content = substr_replace($content, $visibility_function, $pos, 0);
    }
}

// Заменяем все вхождения <ul class="car_premium_price"> на версию с проверкой видимости
$pattern = '/\$price_html \.\= \'<ul class="car_premium_price">\'/';
$replacement = '$price_html .= \'<ul class="car_premium_price\' . (function_exists("tmbooking_get_price_list_visibility_class") ? " " . tmbooking_get_price_list_visibility_class($ID) : "") . \'">\';';
$content = preg_replace($pattern, $replacement, $content);

// Записываем обновленное содержимое обратно в файл
if (file_put_contents($custom_function_file, $content)) {
    echo "Блоки с ценами успешно обновлены с учетом видимости.\n";
} else {
    echo "Ошибка при записи файла.\n";
}

echo "Готово!\n";
