/**
 * JavaScript for checking minimum booking days requirement
 * 
 * @package tm-booking
 */

jQuery(document).ready(function($) {
    'use strict';
    
    console.log('Min booking days script initialized');
    
    // Проверяем все формы бронирования при загрузке страницы
    $('form.booking_form').each(function() {
        var form = $(this);
        var minDaysInfo = form.find('.min-days-info');
        var minDaysContainer = form.find('.min-days-info-container');
        var bookButton = form.find('.book_now_btn');
        
        // Добавляем класс min-day-hide к кнопке бронирования по умолчанию
        bookButton.addClass('min-day-hide');
        
        // По умолчанию показываем информацию о минимальном периоде бронирования
        minDaysInfo.show();
        
        console.log('Checking form ID:', form.data('id'));
        console.log('Min days info found:', minDaysInfo.length);
        console.log('Min days container found:', minDaysContainer.length);
        
        // Проверяем выбранные даты при загрузке страницы, если они есть
        var startDate = form.find('.start_date').val();
        var endDate = form.find('.end_date').val();
        
        if (startDate && endDate) {
            console.log('Dates already selected, checking min days');
            checkMinBookingDays(form);
        } else {
            console.log('No dates selected yet');
        }
    });
    
    // Store original button text for each form
    var originalButtonTexts = {};
    
    // Function to check minimum booking days requirement
    function checkMinBookingDays(form) {
        var formData = getFormData(form);
        var postId = form.data('id');
        
        console.log('Checking min days for vehicle ID:', postId);
        
        // If we don't have start date or end date, don't proceed
        if (!formData.start_date || !formData.end_date) {
            console.log('Missing dates, skipping check');
            return;
        }
        
        // Get the button
        var button = form.find('.book_now_btn');
        
        // Store original button text if not already stored
        if (!originalButtonTexts[postId]) {
            originalButtonTexts[postId] = button.text();
        }
        
        // Получаем даты напрямую из полей формы
        var startDateField = form.find('.start_date');
        var endDateField = form.find('.end_date');
        var startDate = startDateField.val();
        var endDate = endDateField.val();
        
       
        // Проверяем, что даты не пустые
        if (!startDate || !endDate) {
            console.log('Empty dates, skipping check');
            return;
        }
        
        // Prepare data for AJAX request
        // Определяем реальный формат даты на основе настроек сайта
        var dateFormatSetting = tm_booking_min_days.date_format_setting || 'DD/MM/YYYY';
        var actualDateFormat;
        
        // Преобразуем формат даты из настроек в PHP формат
        if (dateFormatSetting === 'MM/DD/YYYY') {
            actualDateFormat = 'm/d/Y';
        } else if (dateFormatSetting === 'DD/MM/YYYY') {
            actualDateFormat = 'd/m/Y';
        } else if (dateFormatSetting === 'MM-DD-YYYY') {
            actualDateFormat = 'm-d-Y';
        } else if (dateFormatSetting === 'DD-MM-YYYY') {
            actualDateFormat = 'd-m-Y';
        } else if (dateFormatSetting === 'MM.DD.YYYY') {
            actualDateFormat = 'm.d.Y';
        } else if (dateFormatSetting === 'DD.MM.YYYY') {
            actualDateFormat = 'd.m.Y';
        } else {
            // По умолчанию используем формат d/m/Y
            actualDateFormat = 'd/m/Y';
        }
        
        // Логируем определенный формат
        console.log('DEBUG - Date format setting:', dateFormatSetting);
        console.log('DEBUG - Converted to PHP format:', actualDateFormat);
        
        var data = {
            action: 'tmbooking_check_min_days',
            nonce: tm_booking_min_days.nonce,
            post_id: postId,
            start_date: startDate,
            end_date: endDate,
            date_format: actualDateFormat // Используем определенный формат вместо tm_booking_min_days.date_format
        };
        
        console.log('Sending dates to server:', {
            start_date: startDate,
            end_date: endDate,
            date_format: actualDateFormat
        });
        
        // Detailed logging for debugging
        console.log('DEBUG - Start date type:', typeof startDate);
        console.log('DEBUG - End date type:', typeof endDate);
        console.log('DEBUG - Original date format:', tm_booking_min_days.date_format);
        console.log('DEBUG - Actual date format used:', actualDateFormat);
        
        // Try to parse dates in JavaScript for comparison
        try {
            var jsStartDate = new Date(startDate);
            var jsEndDate = new Date(endDate);
            console.log('DEBUG - JS parsed start date:', jsStartDate);
            console.log('DEBUG - JS parsed end date:', jsEndDate);
            
            // Calculate days difference in JavaScript
            var timeDiff = Math.abs(jsEndDate.getTime() - jsStartDate.getTime());
            var diffDays = Math.ceil(timeDiff / (1000 * 3600 * 24));
            console.log('DEBUG - JS calculated days difference:', diffDays);
        } catch (e) {
            console.error('DEBUG - Error parsing dates in JavaScript:', e);
        }
        
        // Debug data logging to console
        console.log('Debug data for min days check:', {
            'car_id': postId,
            'start_date': startDate,
            'end_date': endDate,
            'date_format': tm_booking_min_days.date_format
        });
        
        console.log('Sending AJAX request to check min days');
        
        // Send AJAX request
        $.ajax({
            url: tm_booking_min_days.url,
            type: 'POST',
            data: data,
            success: function(response) {
                console.log('AJAX response:', response);
                
                if (response.success) {
                    var responseData = response.data;
                    
                    // Выводим все данные из ответа сервера в консоль
                    console.log('Response data details:');
                    for (var key in responseData) {
                        console.log(key + ':', responseData[key]);
                    }
                    
                    // Подробный лог для отладки
                    console.log('DEBUG - Response meets_requirement:', responseData.meets_requirement);
                    console.log('DEBUG - Response min_days:', responseData.min_days);
                    console.log('DEBUG - Response actual_days:', responseData.actual_days);
                    console.log('DEBUG - Response message:', responseData.message);
                    
                    // Проверяем типы данных
                    console.log('DEBUG - Type of meets_requirement:', typeof responseData.meets_requirement);
                    console.log('DEBUG - Type of min_days:', typeof responseData.min_days);
                    console.log('DEBUG - Type of actual_days:', typeof responseData.actual_days);
                    
                    // Log check results to console
                    console.log('Min days check results:', {
                        'requirement_met': responseData.meets_requirement ? 'Yes' : 'No',
                        'actual_days': responseData.actual_days,
                        'min_days': responseData.min_days,
                        'message': responseData.message || ''
                    });
                    
                    // If minimum days requirement is met
                    if (responseData.meets_requirement) {
                        console.log('Min days requirement met');
                        // Mark the form as passed min days check
                        form.data('min-days-checked', 'passed');
                        
                        // Show button by removing min-day-hide class
                        button.removeClass('min-day-hide');
                        
                        // Remove error message if exists
                        form.find('.min-days-error').remove();
                        
                        // Restore original button text
                        button.text(originalButtonTexts[postId]);
                        
                        // Скрываем информацию о минимальном периоде бронирования, когда требования выполнены
                        var minDaysInfo = form.find('.min-days-info');
                        minDaysInfo.removeClass('warning'); // Remove warning class first
                        minDaysInfo.fadeOut(300); // Smooth fadeout animation (Плавное исчезновение)
                    } else {
                        console.log('Min days requirement NOT met');
                        // Mark the form as failed min days check
                        form.data('min-days-checked', 'not-passed');
                        
                        // Hide button by adding min-day-hide class
                        button.addClass('min-day-hide');
                        
                        // Показываем информацию о минимальном периоде бронирования с предупреждением
                        var minDaysInfo = form.find('.min-days-info');
                        minDaysInfo.addClass('warning'); // Add warning class for error styling
                        minDaysInfo.fadeIn(300); // Smooth fadein animation (Плавное появление)
                        
                        // Get message parts or fallback to legacy message format
                        var errorMessage = '';
                        var errorContainer = form.find('.min-days-info-container');
                        
                        // Check if we have the new message_parts format
                        if (responseData.message_parts) {
                            // Create HTML with proper line break
                            errorMessage = responseData.message_parts.first + '<br>' + responseData.message_parts.second;
                        } else {
                            // Fallback to legacy format
                            errorMessage = responseData.message;
                        }
                        
                        // Update min days info with error message
                        // We'll keep it visible but with warning style
                        if (form.find('.min-days-error').length === 0) {
                            // Create new error element
                            errorContainer.html('<div class="min-days-error">' + errorMessage + '</div>');
                        } else {
                            // Update existing error element
                            // Use html() instead of text() to properly render HTML tags
                            form.find('.min-days-error').html(errorMessage);
                        }
                    }
                } else {
                    console.error('AJAX response indicates failure');
                    console.log('AJAX error:', response);
                    
              
                    
                    // Mark the form as error in min days check
                    form.data('min-days-checked', 'error');
                    
                    // Show error message
                    var errorContainer = form.find('.min-days-info-container');
                    var errorMessage = '';
                    
                    // Get error message from response or use default
                    if (response.data && response.data.message) {
                        errorMessage = response.data.message;
                    } else {
                        // Default error message in Russian
                        errorMessage = 'Произошла ошибка при проверке минимального периода бронирования';
                    }
                    
                    // Update min days info to warning style
                    var minDaysInfo = form.find('.min-days-info');
                    minDaysInfo.addClass('warning'); // Add warning class for error styling
                    
                    // Show error message with icon
                    if (form.find('.min-days-error').length === 0) {
                        errorContainer.html('<div class="min-days-error"><i class="fas fa-exclamation-triangle"></i> ' + errorMessage + '</div>');
                    } else {
                        form.find('.min-days-error').html('<i class="fas fa-exclamation-triangle"></i> ' + errorMessage);
                    }
                    
                    // Hide booking button
                    button.addClass('min-day-hide');
                }
            },
            error: function(xhr, status, error) {
                console.error('AJAX error:', status, error);
                console.log('XHR object:', xhr);
                
                // Mark the form as error in min days check
                form.data('min-days-checked', 'error');
                
                // Показываем сообщение об ошибке
                var errorContainer = form.find('.min-days-info-container');
                var errorMessage = 'Ошибка сервера. Пожалуйста, попробуйте позже.';
                
                // Скрываем информацию о минимальных днях, если она есть
                var minDaysInfo = form.find('.min-days-info');
                minDaysInfo.addClass('warning'); // Add warning class for error styling
                
                // Показываем сообщение об ошибке с иконкой
                if (form.find('.min-days-error').length === 0) {
                    errorContainer.html('<div class="min-days-error"><i class="fas fa-exclamation-triangle"></i> ' + errorMessage + '</div>');
                } else {
                    form.find('.min-days-error').html('<i class="fas fa-exclamation-triangle"></i> ' + errorMessage);
                }
                
                // Скрываем кнопку бронирования
                button.addClass('min-day-hide');
            }
        });
    }
    
    // Helper function to get form data
    function getFormData($form) {
        var unindexed_array = $form.serializeArray();
        var indexed_array = {};
        
        $.map(unindexed_array, function(n, i) {
            indexed_array[n['name']] = n['value'];
        });
        
        // Получаем даты напрямую из полей формы для большей надежности
        var startDateField = $form.find('.start_date');
        var endDateField = $form.find('.end_date');
        
        if (startDateField.length && endDateField.length) {
            indexed_array['start_date'] = startDateField.val();
            indexed_array['end_date'] = endDateField.val();
            
            console.log('Direct form field values:', {
                start_date: startDateField.val(),
                end_date: endDateField.val()
            });
        }
        
        return indexed_array;
    }
    
    // Check minimum booking days when form changes
    $(document).on('change', 'form.booking_form', function() {
        console.log('Form changed, checking min days');
        checkMinBookingDays($(this));
    });
    
    // Check minimum booking days on page load for forms with pre-filled dates
    $(document).ready(function() {
        console.log('Document ready, checking forms for min days');
        $('form.booking_form').each(function() {
            var form = $(this);
            var startDate = form.find('.start_date').val();
            var endDate = form.find('.end_date').val();
            
            if (startDate && endDate) {
                console.log('Found form with pre-filled dates');
                checkMinBookingDays(form);
            }
        });
    });
});
