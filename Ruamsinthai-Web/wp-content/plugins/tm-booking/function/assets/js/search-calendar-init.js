/**
 * Search Calendar Initialization
 * 
 * Initializes the date range picker for the search calendar shortcode
 * for general search across all vehicles.
 */
(function($) {
    'use strict';
    
    $(document).ready(function() {
        // Initialize date range picker if the element exists
        if ($('#tmb-date-range').length) {
            initSearchCalendar();
        }
    });
    
    /**
     * Initialize the search calendar
     */
    function initSearchCalendar() {
        // Get calendar settings from localized data
        const dateFormat = tmbSearchCalendarData.dateFormat || 'MM/DD/YYYY';
        const calendarId = tmbSearchCalendarData.calendarId || '';
        const i18n = tmbSearchCalendarData.i18n || {};
        
        // Initialize daterangepicker without blocking dates (for general search)
        $('#tmb-date-range').daterangepicker({
            autoApply: false,
            minDate: moment(),
            startDate: moment(),
            endDate: moment().add(1, 'days'),
            showCustomRangeLabel: false,
            alwaysShowCalendars: true,
            showDropdowns: true,
            opens: 'center',
            linkedCalendars: false,
            showWeekNumbers: false,
            locale: {
                format: dateFormat,
                applyLabel: i18n.apply || 'Apply',
                cancelLabel: i18n.cancel || 'Cancel',
                fromLabel: i18n.from || 'From',
                toLabel: i18n.to || 'To',
                daysOfWeek: i18n.daysOfWeek || ['Su', 'Mo', 'Tu', 'We', 'Th', 'Fr', 'Sa'],
                monthNames: i18n.monthNames || ['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'],
                firstDay: tmbSearchCalendarData.firstDay || 0
            }
        }, function(start, end, label) {
            // Update hidden fields with selected dates
            $('#tmb-start-date').val(start.format('YYYY-MM-DD'));
            $('#tmb-end-date').val(end.format('YYYY-MM-DD'));
            
            // Синхронизируем значение с полем tmb_date_range для совместимости
            // Копируем значение из поля when в скрытое поле tmb_date_range
            var dateRangeValue = start.format('MM/DD/YYYY') + ' - ' + end.format('MM/DD/YYYY');
            $('#tmb-date-range-hidden').val(dateRangeValue);
        });
        
        // Дополнительно обрабатываем календарь после его инициализации
        setTimeout(function() {
            // Удаляем класс off со всех ячеек календаря
            $('.daterangepicker td.off').removeClass('off').addClass('available');
            
            // Добавляем обработчик события для обновления календаря при смене месяца
            $('.daterangepicker').on('mousedown', '.prev, .next', function() {
                setTimeout(function() {
                    $('.daterangepicker td.off').removeClass('off').addClass('available');
                }, 5);
            });
        }, 100);
    }
    
    // Функции для блокировки дат удалены, так как это общий поиск по всем автомобилям
    
})(jQuery);
