<?php
/**
 * Script to fix all price list blocks in custom_function.php
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

// Находим все вхождения блока с ценами
$pattern = '/\$price_html \.\= \'<ul class="car_premium_price.*?>\'/';
$matches = [];
preg_match_all($pattern, $content, $matches);

if (!empty($matches[0])) {
    echo "Найдено " . count($matches[0]) . " блоков с ценами.\n";
    
    // Заменяем все найденные блоки на корректную версию
    $content = preg_replace(
        $pattern,
        '$price_html .= \'<ul class="car_premium_price">\';',
        $content
    );
    
    // Записываем исправленное содержимое обратно в файл
    if (file_put_contents($custom_function_file, $content)) {
        echo "Все блоки с ценами успешно исправлены.\n";
    } else {
        echo "Ошибка при записи файла.\n";
    }
} else {
    echo "Блоки с ценами не найдены.\n";
}

echo "Готово!\n";
