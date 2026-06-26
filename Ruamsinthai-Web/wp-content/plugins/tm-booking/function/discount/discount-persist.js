/**
 * Script to ensure discount information persists on the page and prevent duplication
 */
jQuery(document).ready(function($) {
    // Store discount information
    var discountInfo = {
        hasDiscount: false,
        html: '',
        lastUpdated: 0
    };
    
    // Функция для проверки наличия блока скидки и его содержимого
    function checkDiscountBlock() {
        var discountBlock = $('.tm-booking-price-discount');
        var hasOriginalPrice = $('.original-price').length > 0;
        
        // Если есть блок скидки и в нем есть содержимое
        if (discountBlock.length && discountBlock.html() && discountBlock.html().trim() !== '') {
            return {
                exists: true,
                hasContent: true,
                element: discountBlock
            };
        }
        // Если блок есть, но он пустой
        else if (discountBlock.length) {
            return {
                exists: true,
                hasContent: false,
                element: discountBlock
            };
        }
        // Если блока нет
        else {
            return {
                exists: false,
                hasContent: false,
                element: null
            };
        }
    }
    
    // Function to check and restore discount information
    function checkAndRestoreDiscount() {
        var blockStatus = checkDiscountBlock();
        var hasOriginalPrice = $('.original-price').length > 0;
        
        // Если есть оригинальная цена (признак скидки), но блок пустой или отсутствует
        if (hasOriginalPrice && (!blockStatus.exists || !blockStatus.hasContent)) {
            // Если у нас есть сохраненная информация о скидке
            if (discountInfo.hasDiscount && discountInfo.html) {
                // Если блок существует, но пустой
                if (blockStatus.exists) {
                    blockStatus.element.html(discountInfo.html);
                }
                // Если блока нет, создаем его
                else {
                    $('.details-aside-content__total-text.total_price_label').before('<section class="tm-booking-price-discount">' + discountInfo.html + '</section>');
                }
            }
        }
        // Если блок существует и имеет содержимое, сохраняем его
        else if (blockStatus.exists && blockStatus.hasContent) {
            discountInfo.hasDiscount = true;
            discountInfo.html = blockStatus.element.html();
            discountInfo.lastUpdated = Date.now();
        }
    }
    
    // Monitor AJAX requests
    $(document).ajaxComplete(function(event, xhr, settings) {
        if (settings.url.indexOf('tmbooking_change_total') > -1) {
            // Wait a short time for DOM to update
            setTimeout(function() {
                // Проверяем состояние блока скидки
                var blockStatus = checkDiscountBlock();
                var hasOriginalPrice = $('.original-price').length > 0;
                
                // Если есть оригинальная цена (признак скидки)
                if (hasOriginalPrice) {
                    // Если блок существует и имеет содержимое
                    if (blockStatus.exists && blockStatus.hasContent) {
                        // Сохраняем информацию о скидке
                        discountInfo.hasDiscount = true;
                        discountInfo.html = blockStatus.element.html();
                        discountInfo.lastUpdated = Date.now();
                    }
                    // Если блок пустой или отсутствует, но у нас есть сохраненная информация
                    else if (discountInfo.hasDiscount && discountInfo.html) {
                        // Восстанавливаем блок скидки
                        if (blockStatus.exists) {
                            blockStatus.element.html(discountInfo.html);
                        } else {
                            $('.details-aside-content__total-text.total_price_label').before('<section class="tm-booking-price-discount">' + discountInfo.html + '</section>');
                        }
                    }
                    // Если блок пустой или отсутствует, и у нас нет сохраненной информации
                    else {
                        // Ждем дополнительное время, чтобы блок мог появиться
                        setTimeout(checkAndRestoreDiscount, 300);
                    }
                } else {
                    // Нет скидки, очищаем сохраненную информацию
                    discountInfo.hasDiscount = false;
                    discountInfo.html = '';
                    
                    // Если блок существует, заменяем его на плейсхолдер
                    if (blockStatus.exists) {
                        // Создаем плейсхолдер блока скидки
                        var placeholderHtml = '<div class="discount-info-block" style="margin: 10px 0; padding: 12px; background-color: #f8f8f8; border-left: 3px solid #e44; border-radius: 3px; box-shadow: 0 1px 3px rgba(0,0,0,0.1);">' +
                            '<div class="discount-title" style="font-weight: bold; color: #e44; margin-bottom: 8px; font-size: 16px;">' + 
                            'Выберите даты для расчета скидки' +
                            '</div>' +
                            '<div class="discount-description" style="font-size: 14px; margin-bottom: 8px;">' +
                            'При длительной аренде предоставляются скидки' +
                            '</div>' +
                            '</div>';
                        
                        // Заменяем содержимое блока на плейсхолдер
                        blockStatus.element.html(placeholderHtml);
                    }
                }
                
                // Make sure the discount block is always visible and doesn't cause page jumps
                if ($('.tm-booking-price-discount').length === 0) {
                    // If no discount block exists, create an empty one
                    $('.details-aside-content__total-text.total_price_label').before('<section class="tm-booking-price-discount" style="min-height: 10px;"></section>');
                    // Created empty discount container to prevent page jumps
                }
            }, 100);
        }
    });
    
    // Check periodically for discount block
    setInterval(checkAndRestoreDiscount, 500);
    
    // Also check when form changes
    $('form.booking_form').on('change', function() {
        // Wait for AJAX to complete
        setTimeout(function() {
            checkAndRestoreDiscount();
            
            // Make sure the discount block is always visible
            if ($('.tm-booking-price-discount').length === 0) {
                // If no discount block exists, create an empty one
                $('.details-aside-content__total-text.total_price_label').before('<section class="tm-booking-price-discount" style="min-height: 10px;"></section>');
                // Created empty discount container after form change
            }
        }, 600);
    });
    
    // Initialize on page load
    $(window).on('load', function() {
        // Make sure the discount block is always visible
        if ($('.tm-booking-price-discount').length === 0) {
            // If no discount block exists, create an empty one with placeholder content
            var placeholderHtml = '<div class="discount-info-block" style="margin: 10px 0; padding: 12px; background-color: #f8f8f8; border-left: 3px solid #e44; border-radius: 3px; box-shadow: 0 1px 3px rgba(0,0,0,0.1);">' +
                '<div class="discount-title" style="font-weight: bold; color: #e44; margin-bottom: 8px; font-size: 16px;">' + 
                'Выберите даты для расчета скидки' +
                '</div>' +
                '<div class="discount-description" style="font-size: 14px; margin-bottom: 8px;">' +
                'При длительной аренде предоставляются скидки' +
                '</div>' +
                '</div>';
            
            $('.details-aside-content__total-text.total_price_label').before('<section class="tm-booking-price-discount">' + placeholderHtml + '</section>');
        }
    });
    
    // Also create the discount block immediately (don't wait for window.load)
    $(function() {
        // Make sure the discount block is always visible
        if ($('.tm-booking-price-discount').length === 0) {
            // If no discount block exists, create an empty one with placeholder content
            var placeholderHtml = '<div class="discount-info-block" style="margin: 10px 0; padding: 12px; background-color: #f8f8f8; border-left: 3px solid #e44; border-radius: 3px; box-shadow: 0 1px 3px rgba(0,0,0,0.1);">' +
                '<div class="discount-title" style="font-weight: bold; color: #e44; margin-bottom: 8px; font-size: 16px;">' + 
                'Выберите даты для расчета скидки' +
                '</div>' +
                '<div class="discount-description" style="font-size: 14px; margin-bottom: 8px;">' +
                'При длительной аренде предоставляются скидки' +
                '</div>' +
                '</div>';
            
            $('.details-aside-content__total-text.total_price_label').before('<section class="tm-booking-price-discount">' + placeholderHtml + '</section>');
        }
    });
});
