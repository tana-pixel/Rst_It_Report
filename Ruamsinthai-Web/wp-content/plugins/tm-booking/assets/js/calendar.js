document.addEventListener('DOMContentLoaded', function() {
    var calendarEl = document.getElementById('tm-booking-calendar');
    
    if (calendarEl) {
        // Переменная для отслеживания текущего представления
        // Variable to track current view
        var currentView = 'dayGridMonth';
        
        var calendar = new FullCalendar.Calendar(calendarEl, {
            initialView: 'dayGridMonth',
            headerToolbar: {
                left: 'prev,next today',
                center: 'title',
                right: 'multiMonth,dayGridMonth'
            },
            views: {
                multiMonth: {
                    buttonText: 'Year',
                    multiMonthMaxColumns: 3,
                    multiMonthMinWidth: 350,
                    duration: { months: 12 }
                },
                dayGridMonth: {
                    buttonText: 'Month'
                }
            },
            loading: function(isLoading) {
                if (isLoading) {
                    calendarEl.classList.add('loading');
                } else {
                    calendarEl.classList.remove('loading');
                }
            },
            // Отслеживаем изменение представления
            // Track view changes
            viewDidMount: function(info) {
                currentView = info.view.type;
                console.log('View changed to:', currentView);
            },
            
            events: function(info, successCallback, failureCallback) {
                jQuery.ajax({
                    url: tmBookingCalendar.ajax_url,
                    data: {
                        action: 'tm_booking_get_calendar_events',
                        nonce: tmBookingCalendar.nonce,
                        start: info.startStr,
                        end: info.endStr,
                        view: currentView // Передаем текущее представление
                    },
                    success: function(response) {
                        if (Array.isArray(response)) {
                            // Если это годовое представление, удаляем свойство 'end' у событий
                            // If this is year view, remove 'end' property from events
                            if (currentView === 'multiMonth') {
                                response.forEach(function(event) {
                                    if (event.end) {
                                        delete event.end;
                                    }
                                });
                            }
                            successCallback(response);
                        } else {
                            console.error('Invalid response format:', response);
                            failureCallback(new Error('Invalid response format'));
                        }
                    },
                    error: function(jqXHR, textStatus, errorThrown) {
                        console.error('Error fetching events:', textStatus, errorThrown);
                        failureCallback(errorThrown);
                    }
                });
            },
            eventTimeFormat: {
                hour: '2-digit',
                minute: '2-digit',
                hour12: false
            },
            displayEventTime: true,
            eventDisplay: 'block',
            eventClick: function(info) {
                if (info.event.url) {
                    window.location.href = info.event.url;
                    return false;
                }
            },
            themeSystem: 'standard',
            height: 'auto',
            firstDay: 1,
            locale: 'en',
            
            // Подсветка выходных дней
            // Weekend highlighting
            dayCellClassNames: function(arg) {
                // Добавляем классы для субботы и воскресенья
                // Add classes for Saturday and Sunday
                const day = arg.date.getDay();
                if (day === 0) return ['fc-day-sun'];
                if (day === 6) return ['fc-day-sat'];
                return [];
            },
            buttonText: {
                today: 'Today'
            }
        });
        
        calendar.render();
    }
});

