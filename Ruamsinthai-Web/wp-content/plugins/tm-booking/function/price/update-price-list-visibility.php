<?php
/**
 * Script to update all price list blocks to use the visibility class
 *
 * @package TM-Booking
 */

if (!defined('ABSPATH')) {
    define('ABSPATH', dirname(__FILE__) . '/../../../');
}

// Получаем путь к файлу custom_function.php
$custom_function_file = __DIR__ . '/custom_function.php';

// Проверяем, существует ли файл
if (!file_exists($custom_function_file)) {
    echo "Файл custom_function.php не найден.\n";
    exit;
}

// Читаем содержимое файла
$content = file_get_contents($custom_function_file);

// Заменяем все вхождения <ul class="car_premium_price"> на версию с добавлением класса видимости
$pattern = "/\\\$price_html \.\= '\<ul class\=\"car_premium_price\"\>\'/";
$replacement = "\$price_html .= '<ul class=\"car_premium_price \' . (function_exists('tmbooking_get_price_list_visibility_class') ? tmbooking_get_price_list_visibility_class(\$ID) : '') . '\">'";
$new_content = preg_replace($pattern, $replacement, $content);

// Записываем обновленное содержимое обратно в файл
if (file_put_contents($custom_function_file, $new_content)) {
    echo "Все блоки с ценами успешно обновлены с учетом видимости.\n";
} else {
    echo "Ошибка при записи файла.\n";
}

echo "Готово!\n";
