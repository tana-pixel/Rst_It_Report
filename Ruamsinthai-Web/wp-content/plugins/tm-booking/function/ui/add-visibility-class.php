<?php
/**
 * Script to add visibility class to all price list blocks in custom_function.php
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

// Заменяем все вхождения блока с ценами на версию с добавлением класса видимости
$pattern = '/\$price_html \.\= \'<ul class="car_premium_price">\';/';
$replacement = '$price_html .= \'<ul class="car_premium_price\' . (function_exists("tmbooking_get_price_list_visibility_class") ? " " . tmbooking_get_price_list_visibility_class($ID) : "") . \'">\';';

$new_content = preg_replace($pattern, $replacement, $content);

// Проверяем, что замена произошла
if ($new_content !== $content) {
    // Записываем обновленное содержимое обратно в файл
    if (file_put_contents($custom_function_file, $new_content)) {
        echo "Все блоки с ценами успешно обновлены с учетом видимости.\n";
    } else {
        echo "Ошибка при записи файла.\n";
    }
} else {
    echo "Замена не произошла. Проверьте шаблон поиска.\n";
}

echo "Готово!\n";
