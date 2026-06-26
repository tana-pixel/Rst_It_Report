<?php
/**
 * Custom price text functions
 *
 * This file contains functions for handling custom price text display
 * The function tmbooking_get_custom_price_text is defined in button-text.php
 */

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly
}

/**
 * Модифицирует HTML вывод цены, заменяя его на кастомный текст, если он задан
 * (Modifies price HTML output, replacing it with custom text if set)
 */
function tmbooking_modify_price_html() {
    // Запускаем буферизацию вывода (Start output buffering)
    ob_start('tmbooking_replace_price_html_callback');
}

/**
 * Функция обратного вызова для замены HTML цены на кастомный текст
 * (Callback function to replace price HTML with custom text)
 *
 * @param string $buffer HTML content
 * @return string Modified HTML content
 */
function tmbooking_replace_price_html_callback($buffer) {
    // Проверяем, есть ли у нас текущий пост (Check if we have current post)
    global $post;
    if (!isset($post->ID)) {
        return $buffer;
    }
    
    // Получаем кастомный текст цены (Get custom price text)
    $custom_price_text = tmbooking_get_custom_price_text($post->ID);
    
    // Если кастомный текст не задан, возвращаем оригинальный HTML
    // (If custom text is not set, return original HTML)
    if (empty($custom_price_text)) {
        return $buffer;
    }
    
    // Проверяем, содержит ли буфер блок с ценой
    // (Check if buffer contains price block)
    if (strpos($buffer, 'current-price') !== false) {
        // Заменяем содержимое блока с ценой на кастомный текст
        // (Replace price block content with custom text)
        $pattern = '/<span class="current-price">.*?<\/span>/s';
        $replacement = '<span class="current-price">' . $custom_price_text . '</span>';
        $buffer = preg_replace($pattern, $replacement, $buffer);
    }
    
    return $buffer;
}

/**
 * Добавляет JavaScript для замены текста цены на кастомный текст на стороне клиента
 * (Adds JavaScript to replace price text with custom text on client side)
 */
function tmbooking_add_price_text_js() {
    global $post;
    if (!isset($post->ID)) {
        return;
    }
    
    // Получаем кастомный текст цены с поддержкой локализации
    // (Get custom price text with localization support)
    $custom_price_text = tmbooking_get_custom_price_text($post->ID);
    
    if (!empty($custom_price_text)) {
        // Экранируем текст для использования в JavaScript
        // (Escape text for JavaScript use)
        $custom_price_text = esc_js($custom_price_text);
        $post_id = esc_js($post->ID);
        
        // Получаем текущий язык сайта для локализации
        // (Get current site language for localization)
        $current_lang = get_locale();
        $lang_data = json_encode(array(
            'locale' => $current_lang,
            'text' => $custom_price_text
        ));
        
        // Добавляем JavaScript для замены текста цены
        // (Add JavaScript to replace price text)
        ?>
        <script type="text/javascript">
        (function(window, document) {
            // Данные о локализации и кастомном тексте
            // (Localization and custom text data)
            var tmbookingPriceData = <?php echo $lang_data; ?>;
            
            // Функция для получения локализованного текста
            // (Function to get localized text)
            function getLocalizedText() {
                return tmbookingPriceData.text || '';
            }
            // Функция для замены текста цены
            // (Function to replace price text)
            function replacePriceText() {
                // Удаляем элементы с классом price-text (слово "Price")
                // (Remove elements with class price-text (word "Price"))
                var priceTextElements = document.querySelectorAll('.price-text');
                for (var i = 0; i < priceTextElements.length; i++) {
                    if (priceTextElements[i].parentNode) {
                        priceTextElements[i].parentNode.removeChild(priceTextElements[i]);
                    }
                }
                
                // Находим все элементы с классом current-price
                // (Find all elements with class current-price)
                var priceElements = document.querySelectorAll('.current-price');
                
                // Заменяем содержимое каждого элемента на кастомный текст и добавляем кастомный класс
                // (Replace content of each element with custom text and add custom class)
                if (priceElements.length > 0) {
                    var localizedText = getLocalizedText();
                    for (var i = 0; i < priceElements.length; i++) {
                        priceElements[i].innerHTML = localizedText;
                        // Добавляем кастомный класс для стилизации
                        // (Add custom class for styling)
                        priceElements[i].classList.add('tmbooking-custom-price-text');
                    }
                }
                
                // Также находим все элементы с классом equipment-order__price
                // (Also find all elements with class equipment-order__price)
                var priceContainers = document.querySelectorAll('.equipment-order__price');
                
                if (priceContainers.length > 0) {
                    for (var j = 0; j < priceContainers.length; j++) {
                        var currentPriceSpan = priceContainers[j].querySelector('.current-price');
                        if (!currentPriceSpan) {
                            // Если нет элемента с классом current-price, создаем его
                            // (If there's no element with class current-price, create it)
                            currentPriceSpan = document.createElement('span');
                            currentPriceSpan.className = 'current-price tmbooking-custom-price-text';
                            currentPriceSpan.innerHTML = getLocalizedText();
                            
                            // Очищаем контейнер и добавляем новый элемент
                            // (Clear container and add new element)
                            priceContainers[j].innerHTML = '';
                            priceContainers[j].appendChild(currentPriceSpan);
                        }
                    }
                }
            }
            
            // Функция дебаунсинга для предотвращения слишком частых вызовов функции
            // (Debounce function to prevent too frequent function calls)
            function debounce(func, wait) {
                var timeout;
                return function() {
                    var context = this, args = arguments;
                    var later = function() {
                        timeout = null;
                        func.apply(context, args);
                    };
                    clearTimeout(timeout);
                    timeout = setTimeout(later, wait);
                };
            }
            
            // Создаем дебаунсированную версию функции замены текста цены
            // (Create debounced version of price text replacement function)
            var debouncedReplacePriceText = debounce(replacePriceText, 150);
            
            // Выполняем замену после загрузки DOM
            // (Execute replacement after DOM is loaded)
            if (document.readyState === 'loading') {
                document.addEventListener('DOMContentLoaded', replacePriceText);
            } else {
                replacePriceText();
            }
            
            // Также выполняем замену после полной загрузки страницы
            // (Also execute replacement after page is fully loaded)
            window.addEventListener('load', replacePriceText);
            
            // Проверяем только при загрузке страницы и после AJAX-запросов
            // (Check only on page load and after AJAX requests)
            
            // Используем событие jQuery AJAX Complete вместо перехвата XMLHttpRequest
            // (Use jQuery AJAX Complete event instead of intercepting XMLHttpRequest)
            if (window.jQuery) {
                // Счетчик активных AJAX запросов календаря
                // (Counter for active calendar AJAX requests)
                var calendarAjaxCounter = 0;
                
                // Отслеживаем начало AJAX запросов
                // (Track AJAX request start)
                jQuery(document).ajaxSend(function(event, xhr, settings) {
                    if (settings.url && 
                        (settings.url.indexOf('booking_calendar') !== -1 || 
                         settings.url.indexOf('calculate_price') !== -1)) {
                        calendarAjaxCounter++;
                    }
                });
                
                // Обрабатываем завершение AJAX запросов
                // (Handle AJAX request completion)
                jQuery(document).ajaxComplete(function(event, xhr, settings) {
                    // Если это запрос календаря, уменьшаем счетчик
                    // (If this is a calendar request, decrement counter)
                    if (settings.url && 
                        (settings.url.indexOf('booking_calendar') !== -1 || 
                         settings.url.indexOf('calculate_price') !== -1)) {
                        calendarAjaxCounter = Math.max(0, calendarAjaxCounter - 1);
                        
                        // Если все запросы календаря завершены, запускаем замену текста цены
                        // (If all calendar requests are completed, run price text replacement)
                        if (calendarAjaxCounter === 0) {
                            setTimeout(debouncedReplacePriceText, 200);
                        }
                    } else {
                        // Проверяем, содержит ли ответ элементы с ценой
                        // (Check if response contains price elements)
                        if (xhr.responseText && 
                            (xhr.responseText.indexOf('current-price') !== -1 || 
                             xhr.responseText.indexOf('equipment-order__price') !== -1)) {
                            setTimeout(debouncedReplacePriceText, 300);
                        }
                    }
                });
            }
            
            // Добавляем наблюдатель за мутациями DOM
            // (Add observer for DOM mutations)
            if (window.MutationObserver) {
                // Создаем флаг для отслеживания активности календаря
                // (Create flag to track calendar activity)
                var calendarActive = false;
                
                // Функция для проверки наличия элементов цены в узле
                // (Function to check for price elements in a node)
                function checkNodeForPriceElements(node) {
                    if (!node || node.nodeType !== 1) return false;
                    
                    // Проверка на наличие классов цены
                    // (Check for price classes)
                    if (node.classList && (
                        node.classList.contains('current-price') || 
                        node.classList.contains('equipment-order__price')
                    )) {
                        return true;
                    }
                    
                    // Проверка на наличие календаря
                    // (Check for calendar elements)
                    if (node.classList && (
                        node.classList.contains('tm-booking-calendar') ||
                        node.classList.contains('booking-calendar')
                    )) {
                        calendarActive = true;
                    }
                    
                    // Проверка на наличие дочерних элементов цены
                    // (Check for child price elements)
                    try {
                        return !!(node.querySelector && (
                            node.querySelector('.current-price') ||
                            node.querySelector('.equipment-order__price')
                        ));
                    } catch (e) {
                        return false;
                    }
                }
                
                // Создаем наблюдатель с дебаунсингом
                // (Create observer with debouncing)
                var observer = new MutationObserver(function(mutations) {
                    // Пропускаем обработку, если есть активные AJAX запросы календаря
                    // (Skip processing if there are active calendar AJAX requests)
                    if (calendarAjaxCounter > 0) return;
                    
                    var needsUpdate = false;
                    var mutationsProcessed = 0;
                    var maxMutationsToProcess = 20; // Ограничение количества обрабатываемых мутаций
                    
                    // Обрабатываем ограниченное количество мутаций
                    // (Process limited number of mutations)
                    for (var j = 0; j < mutations.length && mutationsProcessed < maxMutationsToProcess; j++) {
                        var mutation = mutations[j];
                        mutationsProcessed++;
                        
                        // Проверяем только добавленные узлы
                        // (Check only added nodes)
                        if (mutation.type === 'childList' && mutation.addedNodes.length > 0) {
                            // Ограничиваем количество проверяемых узлов
                            // (Limit number of nodes to check)
                            var nodesToCheck = Math.min(mutation.addedNodes.length, 10);
                            
                            for (var i = 0; i < nodesToCheck; i++) {
                                if (checkNodeForPriceElements(mutation.addedNodes[i])) {
                                    needsUpdate = true;
                                    break;
                                }
                            }
                            
                            if (needsUpdate) break;
                        }
                    }
                    
                    // Если нужно обновить и нет активного календаря
                    // (If update is needed and no active calendar)
                    if (needsUpdate && !calendarActive) {
                        debouncedReplacePriceText();
                    }
                    
                    // Сбрасываем флаг активности календаря
                    // (Reset calendar activity flag)
                    calendarActive = false;
                });
                
                // Запускаем наблюдение за всем документом с оптимизированными настройками
                // (Start observing the entire document with optimized settings)
                observer.observe(document.body, {
                    childList: true,
                    subtree: true,
                    characterData: false,
                    attributes: false
                });
            }
        })(window, document);
        </script>
        <?php
    }
}



// Добавляем хуки для модификации HTML цены и подключения стилей
// (Add hooks for price HTML modification and styles enqueuing)
add_action('wp_head', 'tmbooking_add_price_text_js', 100);
add_action('wp_footer', 'tmbooking_add_price_text_js', 100);


// Ничего дополнительного не требуется, так как мы используем JavaScript для замены текста цены
// (Nothing additional is required as we use JavaScript to replace price text)
