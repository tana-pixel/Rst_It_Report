/**
 * TM Booking Calendar JavaScript
 * 
 * Инициализация календаря xdsoft datetimepicker для виджета Elementor
 */
jQuery(document).ready(function($) {
    "use strict";

    /**
     * Форматирование даты
     * 
     * @param {Date} date Объект даты
     * @param {string} format Формат даты
     * @returns {string} Отформатированная дата
     */
    function formatDate(date, format) {
        var day = date.getDate();
        var month = date.getMonth() + 1;
        var year = date.getFullYear();
        var hours = date.getHours();
        var minutes = date.getMinutes();
        
        // Добавляем ведущие нули
        day = (day < 10) ? '0' + day : day;
        month = (month < 10) ? '0' + month : month;
        hours = (hours < 10) ? '0' + hours : hours;
        minutes = (minutes < 10) ? '0' + minutes : minutes;
        
        // Форматируем дату в зависимости от формата
        switch (format) {
            case 'j/m/Y H:i':
                return day + '/' + month + '/' + year + ' ' + hours + ':' + minutes;
            case 'm/j/Y H:i':
                return month + '/' + day + '/' + year + ' ' + hours + ':' + minutes;
            case 'j/m/Y':
                return day + '/' + month + '/' + year;
            case 'm/j/Y':
                return month + '/' + day + '/' + year;
            default:
                return day + '/' + month + '/' + year + ' ' + hours + ':' + minutes;
        }
    }

    /**
     * Инициализация календарей
     */
    function initBookingCalendars() {
        $('.tmb-booking-calendar-wrapper').each(function() {
            var wrapper = $(this);
            var startInput = wrapper.find('.tmb-start-date');
            var endInput = wrapper.find('.tmb-end-date');
            var whenInput = wrapper.find('input[name="when"]');
            var rangeInput = wrapper.find('input[name="tmb_date_range"]');
            
            // Получаем параметры из data-атрибутов
            var minDateOffset = parseInt(startInput.data('min-date')) || 0;
            var workDays = startInput.data('work-days') || '';
            var workHours = startInput.data('work-hours') || '';
            var dateFormat = startInput.data('format') || 'j/m/Y H:i';
            var showTime = startInput.data('show-time') === '1';
            var autoEndDate = startInput.data('auto-end') === '1';
            
            // Преобразуем строку с рабочими днями в массив чисел
            var disabledWeekDays = [];
            if (workDays) {
                disabledWeekDays = workDays.split(',').map(function(item) {
                    return parseInt(item, 10);
                });
            }
            
            // Преобразуем строку с рабочими часами в массив
            var allowTimes = [];
            if (workHours) {
                allowTimes = workHours.split(',');
            }
            
            // Вычисляем минимальную дату
            var date = new Date();
            date.setDate(date.getDate() + minDateOffset);
            var minDate = date.toISOString().split('T')[0];
            
            // Получаем локаль
            var locale = $('html').attr('lang');
            if (locale) {
                locale = locale.slice(0, 2);
            } else {
                locale = 'en';
            }
            
            // Настройки для datetimepicker
            var pickerOptions = {
                format: dateFormat,
                formatDate: dateFormat.replace(' H:i', ''),
                timepicker: showTime,
                datepicker: true,
                minDate: minDate,
                disabledWeekDays: disabledWeekDays,
                lang: locale,
                scrollInput: false,
                scrollMonth: false,
                validateOnBlur: false,
                dayOfWeekStart: 1, // Неделя начинается с понедельника
                closeOnDateSelect: !showTime,
                closeOnTimeSelect: true
            };
            
            // Добавляем доступные часы, если показываем выбор времени
            if (showTime && allowTimes.length > 0) {
                pickerOptions.allowTimes = allowTimes;
                pickerOptions.step = 60; // Шаг в минутах
            }
            
            // Инициализируем календарь для начальной даты
            startInput.datetimepicker(pickerOptions);
            
            // Инициализируем календарь для конечной даты
            endInput.datetimepicker(pickerOptions);
            
            // Обработчик изменения начальной даты
            startInput.on('change', function() {
                // Устанавливаем минимальную дату для конечной даты
                var startDate = startInput.datetimepicker('getValue');
                
                if (startDate) {
                    // Обновляем минимальную дату для конечного календаря
                    var nextDay = new Date(startDate);
                    nextDay.setDate(nextDay.getDate() + 1);
                    
                    endInput.datetimepicker('setOptions', {
                        minDate: startDate
                    });
                    
                    // Если включено автоматическое заполнение конечной даты
                    if (autoEndDate && !endInput.val()) {
                        var endDate = formatDate(nextDay, dateFormat);
                        endInput.val(endDate);
                    }
                    
                    // Обновляем скрытые поля
                    updateHiddenFields(wrapper);
                }
            });
            
            // Обработчик изменения конечной даты
            endInput.on('change', function() {
                updateHiddenFields(wrapper);
            });
        });
    }
    
    /**
     * Обновление скрытых полей для совместимости с разными форматами
     * 
     * @param {jQuery} wrapper Обертка календаря
     */
    function updateHiddenFields(wrapper) {
        var startInput = wrapper.find('.tmb-start-date');
        var endInput = wrapper.find('.tmb-end-date');
        var whenInput = wrapper.find('input[name="when"]');
        var rangeInput = wrapper.find('input[name="tmb_date_range"]');
        
        var startVal = startInput.val();
        var endVal = endInput.val();
        
        if (startVal && endVal) {
            // Формируем значение для поля when в формате "DD/MM/YYYY - DD/MM/YYYY"
            var startDate = startInput.datetimepicker('getValue');
            var endDate = endInput.datetimepicker('getValue');
            
            // Форматируем даты для поля when
            var startFormatted = formatDate(startDate, 'j/m/Y');
            var endFormatted = formatDate(endDate, 'j/m/Y');
            
            whenInput.val(startFormatted + ' - ' + endFormatted);
            rangeInput.val(startFormatted + ' - ' + endFormatted);
            
            // Вызываем событие изменения для оповещения других скриптов
            wrapper.trigger('tmb:dates_updated', [startDate, endDate]);
        }
    }
    
    // Инициализация при загрузке страницы
    initBookingCalendars();
    
    // Повторная инициализация при AJAX-запросах или динамическом добавлении контента
    $(document).on('elementor/frontend/init', function() {
        if (window.elementorFrontend) {
            elementorFrontend.hooks.addAction('frontend/element_ready/tmb_booking_calendar.default', function() {
                initBookingCalendars();
            });
        }
    });
});
