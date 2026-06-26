<h2><?php echo esc_html('Booking Settings', 'tm-booking');?></h2>
<div class="tmbooking_settings_container">

    <?php if(!class_exists('WooCommerce')){ ?>
        <div class="notice notice-warning settings-error is-dismissible"><?php echo __('"TM Booking" requires "Woocommerce". Please install and activate "Woocommerce"', 'tm-booking');?></div>
    <?php } ?>
    <?php 
    // Получаем настройки и убеждаемся, что это массив (Get settings and ensure it's an array)
    $booking_settings = get_option('tm_booking_settings', []);
    if (!is_array($booking_settings)) {
        $booking_settings = [];
    }
    $post_types = get_post_types();
    ?>
    <form method="post" class="tmbooking_form">
        <div class="form_item">
            <label><?php echo __('Post Type', 'tm-booking');?></label>
            <select name="tm_booking_settings[post_type]">
                <option value="unset" selected><?php echo __('--Unset--', 'tm-booking');?></option>
                <?php foreach ($post_types as $key => $post_type){ ?>
                    <option value="<?php echo esc_attr($key)?>"  <?php echo esc_attr(isset($booking_settings['post_type']) && $booking_settings['post_type'] == $key ? 'selected' : '')?>><?php echo esc_html($post_type)?></option>
                <?php } ?>
            </select>
        </div>

        <div class="form_item">
            <label><?php echo __('Date format', 'tm-booking');?></label>
            <input type="hidden" value="<?php echo esc_attr(isset($booking_settings['date_format_old']) ? $booking_settings['date_format_old'] : '');?>" name="tm_booking_settings[date_format_old]"/>
            <select name="tm_booking_settings[date_format]">
                <?php $current_date_format = isset($booking_settings['date_format']) ? $booking_settings['date_format'] : ''; ?>
                <option <?php echo esc_attr($current_date_format == 'MM/DD/YYYY' ? 'selected' : '')?> value="MM/DD/YYYY"><?php echo esc_html('MM/DD/YYYY')?></option>
                <option <?php echo esc_attr($current_date_format == 'DD/MM/YYYY' ? 'selected' : '')?> value="DD/MM/YYYY"><?php echo esc_html('DD/MM/YYYY')?></option>

                <option <?php echo esc_attr($current_date_format == 'MM-DD-YYYY' ? 'selected' : '')?> value="MM-DD-YYYY"><?php echo esc_html('MM-DD-YYYY')?></option>
                <option <?php echo esc_attr($current_date_format == 'DD-MM-YYYY' ? 'selected' : '')?> value="DD-MM-YYYY"><?php echo esc_html('DD-MM-YYYY')?></option>

                <option <?php echo esc_attr($current_date_format == 'MM.DD.YYYY' ? 'selected' : '')?> value="MM.DD.YYYY"><?php echo esc_html('MM.DD.YYYY')?></option>
                <option <?php echo esc_attr($current_date_format == 'DD.MM.YYYY' ? 'selected' : '')?> value="DD.MM.YYYY"><?php echo esc_html('DD.MM.YYYY')?></option>
            </select>
        </div>

        <div class="form_item">
            <label><?php echo __('Show Discounts', 'tm-booking');?></label>
            <select name="tm_booking_settings[show_discounts]">
                <?php $show_discounts = isset($booking_settings['show_discounts']) ? $booking_settings['show_discounts'] : 'yes'; ?>
                <option <?php echo esc_attr($show_discounts == 'yes' ? 'selected' : '')?> value="yes"><?php echo esc_html__('Yes', 'tm-booking')?></option>
                <option <?php echo esc_attr($show_discounts == 'no' ? 'selected' : '')?> value="no"><?php echo esc_html__('No', 'tm-booking')?></option>
            </select>
            <p class="description"><?php echo esc_html__('Choose whether to display discount information on booking pages.', 'tm-booking'); ?></p>
        </div>

        <div class="form_item">
            <div class="form_item_inner">
                <label><?php echo __('Drops', 'tm-booking');?></label>
                <select name="tm_booking_settings[drops]">
                    <?php $drops = isset($booking_settings['drops']) ? $booking_settings['drops'] : 'down'; ?>
                    <option <?php echo esc_attr($drops == 'down' ? 'selected' : '')?> value="down"><?php echo esc_html('Down')?></option>
                    <option <?php echo esc_attr($drops == 'up' ? 'selected' : '')?> value="up"><?php echo esc_html('Up')?></option>
                    <option <?php echo esc_attr($drops == 'auto' ? 'selected' : '')?> value="auto"><?php echo esc_html('Auto')?></option>
                </select>
            </div>
            <div class="form_item_inner">
                <label><?php echo __('Week Numbers', 'tm-booking');?></label>
                <select name="tm_booking_settings[showWeekNumbers]">
                    <?php $showWeekNumbers = isset($booking_settings['showWeekNumbers']) ? $booking_settings['showWeekNumbers'] : 'false'; ?>
                    <option <?php echo esc_attr($showWeekNumbers == 'true' ? 'selected' : '')?> value="true"><?php echo esc_html('Show')?></option>
                    <option <?php echo esc_attr($showWeekNumbers == 'false' ? 'selected' : '')?> value="false"><?php echo esc_html('Hide')?></option>
                </select>
            </div>

            <div class="form_item_inner">

                <label><?php echo __('ISO Week Numbers', 'tm-booking');?></label>
                <select name="tm_booking_settings[showISOWeekNumbers]">
                    <?php $showISOWeekNumbers = isset($booking_settings['showISOWeekNumbers']) ? $booking_settings['showISOWeekNumbers'] : 'false'; ?>
                    <option <?php echo esc_attr($showISOWeekNumbers == 'true' ? 'selected' : '')?> value="true"><?php echo esc_html('Show')?></option>
                    <option <?php echo esc_attr($showISOWeekNumbers == 'false' ? 'selected' : '')?> value="false"><?php echo esc_html('Hide')?></option>
                </select>
            </div>

        </div>



        <div class="form_item">
            <label><?php echo __('Calculate periods', 'tm-booking');?></label>
            <select name="tm_booking_settings[calc_periods][]" multiple class="tm_booking_settings_calc_periods">
                <?php
                // Проверяем, что calc_periods существует и является массивом (Check that calc_periods exists and is an array)
                $calc_periods = isset($booking_settings['calc_periods']) && is_array($booking_settings['calc_periods']) ? $booking_settings['calc_periods'] : [];
                ?>
                <option <?php echo esc_attr(in_array("calc_hours", $calc_periods) ? 'selected' : '')?> value="calc_hours"><?php echo esc_html('Hours')?></option>
                <option selected value="calc_days" disabled><?php echo esc_html('Days')?></option>
                <option <?php echo esc_attr(in_array("calc_weeks", $calc_periods) ? 'selected' : '')?> value="calc_weeks"><?php echo esc_html('Weeks')?></option>
                <option <?php echo esc_attr(in_array("calc_month", $calc_periods) ? 'selected' : '')?> value="calc_month"><?php echo esc_html('Month')?></option>
            </select>
        </div>

        <?php if(in_array("calc_hours", $calc_periods)): ?>
        <div class="form_item">
            <label><?php echo __('Time Format', 'tm-booking');?></label>
            <select name="tm_booking_settings[time_format]">
                <option value="24h" <?php echo isset($booking_settings['time_format']) && $booking_settings['time_format'] === '24h' ? 'selected' : ''; ?>><?php echo esc_html('24-hour format (00:00 - 23:59)'); ?></option>
                <option value="12h" <?php echo isset($booking_settings['time_format']) && $booking_settings['time_format'] === '12h' ? 'selected' : ''; ?>><?php echo esc_html('12-hour format with AM/PM (12:00 AM - 11:59 PM)'); ?></option>
            </select>
            <p class="description"><?php echo esc_html__('Choose time format for the booking calendar when hours calculation is enabled.', 'tm-booking'); ?></p>
        </div>
        <?php endif; ?>

        <div class="form_item">
            <label><?php echo __('Working Hours Start', 'tm-booking');
            if(isset($booking_settings['working_hours']['start'])){
                $working_hours_start = $booking_settings['working_hours']['start'];
            } else {
                $working_hours_start = 'disable';
            }

            if(isset($booking_settings['working_hours']['end'])){
                $working_hours_end = $booking_settings['working_hours']['end'];
            } else {
                $working_hours_end = 'disable';
            }

            ?></label>
            <select name="tm_booking_settings[working_hours][start]">
                <option value="disable" <?php echo esc_attr($working_hours_start == 'disable' ? 'selected' : '')?>><?php echo esc_html('Disable')?></option>
                <option value="00:00" <?php echo esc_attr($working_hours_start == '00:00' ? 'selected' : '')?>>00:00</option>
                <option value="01:00" <?php echo esc_attr($working_hours_start == '01:00' ? 'selected' : '')?>>01:00</option>
                <option value="02:00" <?php echo esc_attr($working_hours_start == '02:00' ? 'selected' : '')?>>02:00</option>
                <option value="03:00" <?php echo esc_attr($working_hours_start == '03:00' ? 'selected' : '')?>>03:00</option>
                <option value="04:00" <?php echo esc_attr($working_hours_start == '04:00' ? 'selected' : '')?>>04:00</option>
                <option value="05:00" <?php echo esc_attr($working_hours_start == '05:00' ? 'selected' : '')?>>05:00</option>
                <option value="06:00" <?php echo esc_attr($working_hours_start == '06:00' ? 'selected' : '')?>>06:00</option>
                <option value="07:00" <?php echo esc_attr($working_hours_start == '07:00' ? 'selected' : '')?>>07:00</option>
                <option value="08:00" <?php echo esc_attr($working_hours_start == '08:00' ? 'selected' : '')?>>08:00</option>
                <option value="09:00" <?php echo esc_attr($working_hours_start == '09:00' ? 'selected' : '')?>>09:00</option>
                <option value="10:00" <?php echo esc_attr($working_hours_start == '10:00' ? 'selected' : '')?>>10:00</option>
                <option value="11:00" <?php echo esc_attr($working_hours_start == '11:00' ? 'selected' : '')?>>11:00</option>
                <option value="12:00" <?php echo esc_attr($working_hours_start == '12:00' ? 'selected' : '')?>>12:00</option>
                <option value="13:00" <?php echo esc_attr($working_hours_start == '13:00' ? 'selected' : '')?>>13:00</option>
                <option value="14:00" <?php echo esc_attr($working_hours_start == '14:00' ? 'selected' : '')?>>14:00</option>
                <option value="15:00" <?php echo esc_attr($working_hours_start == '15:00' ? 'selected' : '')?>>15:00</option>
                <option value="16:00" <?php echo esc_attr($working_hours_start == '16:00' ? 'selected' : '')?>>16:00</option>
                <option value="17:00" <?php echo esc_attr($working_hours_start == '17:00' ? 'selected' : '')?>>17:00</option>
                <option value="18:00" <?php echo esc_attr($working_hours_start == '18:00' ? 'selected' : '')?>>18:00</option>
                <option value="19:00" <?php echo esc_attr($working_hours_start == '19:00' ? 'selected' : '')?>>19:00</option>
                <option value="20:00" <?php echo esc_attr($working_hours_start == '20:00' ? 'selected' : '')?>>20:00</option>
                <option value="21:00" <?php echo esc_attr($working_hours_start == '21:00' ? 'selected' : '')?>>21:00</option>
                <option value="22:00" <?php echo esc_attr($working_hours_start == '22:00' ? 'selected' : '')?>>22:00</option>
                <option value="23:00" <?php echo esc_attr($working_hours_start == '23:00' ? 'selected' : '')?>>23:00</option>
            </select>
            <label><?php echo __('Working Hours End', 'tm-booking'); ?></label>
            <select name="tm_booking_settings[working_hours][end]">
                <option value="disable" <?php echo esc_attr($working_hours_end == 'disable' ? 'selected' : '')?>><?php echo esc_html('Disable')?></option>
                <option value="00:00" <?php echo esc_attr($working_hours_end == '00:00' ? 'selected' : '')?>>00:00</option>
                <option value="01:00" <?php echo esc_attr($working_hours_end == '01:00' ? 'selected' : '')?>>01:00</option>
                <option value="02:00" <?php echo esc_attr($working_hours_end == '02:00' ? 'selected' : '')?>>02:00</option>
                <option value="03:00" <?php echo esc_attr($working_hours_end == '03:00' ? 'selected' : '')?>>03:00</option>
                <option value="04:00" <?php echo esc_attr($working_hours_end == '04:00' ? 'selected' : '')?>>04:00</option>
                <option value="05:00" <?php echo esc_attr($working_hours_end == '05:00' ? 'selected' : '')?>>05:00</option>
                <option value="06:00" <?php echo esc_attr($working_hours_end == '06:00' ? 'selected' : '')?>>06:00</option>
                <option value="07:00" <?php echo esc_attr($working_hours_end == '07:00' ? 'selected' : '')?>>07:00</option>
                <option value="08:00" <?php echo esc_attr($working_hours_end == '08:00' ? 'selected' : '')?>>08:00</option>
                <option value="09:00" <?php echo esc_attr($working_hours_end == '09:00' ? 'selected' : '')?>>09:00</option>
                <option value="10:00" <?php echo esc_attr($working_hours_end == '10:00' ? 'selected' : '')?>>10:00</option>
                <option value="11:00" <?php echo esc_attr($working_hours_end == '11:00' ? 'selected' : '')?>>11:00</option>
                <option value="12:00" <?php echo esc_attr($working_hours_end == '12:00' ? 'selected' : '')?>>12:00</option>
                <option value="13:00" <?php echo esc_attr($working_hours_end == '13:00' ? 'selected' : '')?>>13:00</option>
                <option value="14:00" <?php echo esc_attr($working_hours_end == '14:00' ? 'selected' : '')?>>14:00</option>
                <option value="15:00" <?php echo esc_attr($working_hours_end == '15:00' ? 'selected' : '')?>>15:00</option>
                <option value="16:00" <?php echo esc_attr($working_hours_end == '16:00' ? 'selected' : '')?>>16:00</option>
                <option value="17:00" <?php echo esc_attr($working_hours_end == '17:00' ? 'selected' : '')?>>17:00</option>
                <option value="18:00" <?php echo esc_attr($working_hours_end == '18:00' ? 'selected' : '')?>>18:00</option>
                <option value="19:00" <?php echo esc_attr($working_hours_end == '19:00' ? 'selected' : '')?>>19:00</option>
                <option value="20:00" <?php echo esc_attr($working_hours_end == '20:00' ? 'selected' : '')?>>20:00</option>
                <option value="21:00" <?php echo esc_attr($working_hours_end == '21:00' ? 'selected' : '')?>>21:00</option>
                <option value="22:00" <?php echo esc_attr($working_hours_end == '22:00' ? 'selected' : '')?>>22:00</option>
                <option value="23:00" <?php echo esc_attr($working_hours_end == '23:00' ? 'selected' : '')?>>23:00</option>
            </select>
        </div>

        <div class="form_item">
            <label><?php echo __('Minimum Hours to Rent', 'tm-booking');
                if(isset($booking_settings['minimum_hours'])){
                    $minimum_hours = $booking_settings['minimum_hours'];
                } else {
                    $minimum_hours = 'disable';
                }
            ?></label>
            <select name="tm_booking_settings[minimum_hours]">
                <option value="disable" <?php echo esc_attr($minimum_hours == 'disable' ? 'selected' : '')?>><?php echo esc_html('Disable')?></option>
                <option value="1" <?php echo esc_attr($minimum_hours == '1' ? 'selected' : '')?>><?php echo esc_html('1 Hour')?></option>
                <option value="2" <?php echo esc_attr($minimum_hours == '2' ? 'selected' : '')?>><?php echo esc_html('2 Hours')?></option>
                <option value="3" <?php echo esc_attr($minimum_hours == '3' ? 'selected' : '')?>><?php echo esc_html('3 Hours')?></option>
                <option value="4" <?php echo esc_attr($minimum_hours == '4' ? 'selected' : '')?>><?php echo esc_html('4 Hours')?></option>
                <option value="5" <?php echo esc_attr($minimum_hours == '5' ? 'selected' : '')?>><?php echo esc_html('5 Hours')?></option>
                <option value="6" <?php echo esc_attr($minimum_hours == '6' ? 'selected' : '')?>><?php echo esc_html('6 Hours')?></option>
                <option value="7" <?php echo esc_attr($minimum_hours == '7' ? 'selected' : '')?>><?php echo esc_html('7 Hours')?></option>
                <option value="8" <?php echo esc_attr($minimum_hours == '8' ? 'selected' : '')?>><?php echo esc_html('8 Hours')?></option>
                <option value="9" <?php echo esc_attr($minimum_hours == '9' ? 'selected' : '')?>><?php echo esc_html('9 Hours')?></option>
                <option value="10" <?php echo esc_attr($minimum_hours == '10' ? 'selected' : '')?>><?php echo esc_html('10 Hours')?></option>
                <option value="11" <?php echo esc_attr($minimum_hours == '11' ? 'selected' : '')?>><?php echo esc_html('11 Hours')?></option>
                <option value="12" <?php echo esc_attr($minimum_hours == '12' ? 'selected' : '')?>><?php echo esc_html('12 Hours')?></option>
                <option value="13" <?php echo esc_attr($minimum_hours == '13' ? 'selected' : '')?>><?php echo esc_html('13 Hours')?></option>
                <option value="14" <?php echo esc_attr($minimum_hours == '14' ? 'selected' : '')?>><?php echo esc_html('14 Hours')?></option>
                <option value="15" <?php echo esc_attr($minimum_hours == '15' ? 'selected' : '')?>><?php echo esc_html('15 Hours')?></option>
                <option value="16" <?php echo esc_attr($minimum_hours == '16' ? 'selected' : '')?>><?php echo esc_html('16 Hours')?></option>
                <option value="17" <?php echo esc_attr($minimum_hours == '17' ? 'selected' : '')?>><?php echo esc_html('17 Hours')?></option>
                <option value="18" <?php echo esc_attr($minimum_hours == '18' ? 'selected' : '')?>><?php echo esc_html('18 Hours')?></option>
                <option value="19" <?php echo esc_attr($minimum_hours == '19' ? 'selected' : '')?>><?php echo esc_html('19 Hours')?></option>
                <option value="20" <?php echo esc_attr($minimum_hours == '20' ? 'selected' : '')?>><?php echo esc_html('20 Hours')?></option>
                <option value="21" <?php echo esc_attr($minimum_hours == '21' ? 'selected' : '')?>><?php echo esc_html('21 Hours')?></option>
                <option value="22" <?php echo esc_attr($minimum_hours == '22' ? 'selected' : '')?>><?php echo esc_html('22 Hours')?></option>
                <option value="23" <?php echo esc_attr($minimum_hours == '23' ? 'selected' : '')?>><?php echo esc_html('23 Hours')?></option>
            </select>
        </div>

        <div class="form_item">
            <label><?php echo __('Minimum Hours to Calculate as Day', 'tm-booking');
                if(isset($booking_settings['minimum_hours_day'])){
                    $minimum_hours_day = $booking_settings['minimum_hours_day'];
                } else {
                    $minimum_hours_day = 'disable';
                }
                ?></label>
            <select name="tm_booking_settings[minimum_hours_day]">
                <option value="disable" <?php echo esc_attr($minimum_hours_day == 'disable' ? 'selected' : '')?>><?php echo esc_html('Disable')?></option>
                <option value="1" <?php echo esc_attr($minimum_hours_day == '1' ? 'selected' : '')?>><?php echo esc_html('1 Hour')?></option>
                <option value="2" <?php echo esc_attr($minimum_hours_day == '2' ? 'selected' : '')?>><?php echo esc_html('2 Hours')?></option>
                <option value="3" <?php echo esc_attr($minimum_hours_day == '3' ? 'selected' : '')?>><?php echo esc_html('3 Hours')?></option>
                <option value="4" <?php echo esc_attr($minimum_hours_day == '4' ? 'selected' : '')?>><?php echo esc_html('4 Hours')?></option>
                <option value="5" <?php echo esc_attr($minimum_hours_day == '5' ? 'selected' : '')?>><?php echo esc_html('5 Hours')?></option>
                <option value="6" <?php echo esc_attr($minimum_hours_day == '6' ? 'selected' : '')?>><?php echo esc_html('6 Hours')?></option>
                <option value="7" <?php echo esc_attr($minimum_hours_day == '7' ? 'selected' : '')?>><?php echo esc_html('7 Hours')?></option>
                <option value="8" <?php echo esc_attr($minimum_hours_day == '8' ? 'selected' : '')?>><?php echo esc_html('8 Hours')?></option>
                <option value="9" <?php echo esc_attr($minimum_hours_day == '9' ? 'selected' : '')?>><?php echo esc_html('9 Hours')?></option>
                <option value="10" <?php echo esc_attr($minimum_hours_day == '10' ? 'selected' : '')?>><?php echo esc_html('10 Hours')?></option>
                <option value="11" <?php echo esc_attr($minimum_hours_day == '11' ? 'selected' : '')?>><?php echo esc_html('11 Hours')?></option>
                <option value="12" <?php echo esc_attr($minimum_hours_day == '12' ? 'selected' : '')?>><?php echo esc_html('12 Hours')?></option>
                <option value="13" <?php echo esc_attr($minimum_hours_day == '13' ? 'selected' : '')?>><?php echo esc_html('13 Hours')?></option>
                <option value="14" <?php echo esc_attr($minimum_hours_day == '14' ? 'selected' : '')?>><?php echo esc_html('14 Hours')?></option>
                <option value="15" <?php echo esc_attr($minimum_hours_day == '15' ? 'selected' : '')?>><?php echo esc_html('15 Hours')?></option>
                <option value="16" <?php echo esc_attr($minimum_hours_day == '16' ? 'selected' : '')?>><?php echo esc_html('16 Hours')?></option>
                <option value="17" <?php echo esc_attr($minimum_hours_day == '17' ? 'selected' : '')?>><?php echo esc_html('17 Hours')?></option>
                <option value="18" <?php echo esc_attr($minimum_hours_day == '18' ? 'selected' : '')?>><?php echo esc_html('18 Hours')?></option>
                <option value="19" <?php echo esc_attr($minimum_hours_day == '19' ? 'selected' : '')?>><?php echo esc_html('19 Hours')?></option>
                <option value="20" <?php echo esc_attr($minimum_hours_day == '20' ? 'selected' : '')?>><?php echo esc_html('20 Hours')?></option>
                <option value="21" <?php echo esc_attr($minimum_hours_day == '21' ? 'selected' : '')?>><?php echo esc_html('21 Hours')?></option>
                <option value="22" <?php echo esc_attr($minimum_hours_day == '22' ? 'selected' : '')?>><?php echo esc_html('22 Hours')?></option>
                <option value="23" <?php echo esc_attr($minimum_hours_day == '23' ? 'selected' : '')?>><?php echo esc_html('23 Hours')?></option>
            </select>
        </div>


        <div class="form_item">
            <label><?php echo __('Block booked days in the calendar', 'tm-booking');
                $booked_days = '';
                if(isset($booking_settings['booked_days'])){
                    $booked_days = $booking_settings['booked_days'];
                }
                ?></label>
            <select name="tm_booking_settings[booked_days]">
                <option value="enable" <?php echo esc_attr($booked_days == 'enable' ? 'selected' : '')?>><?php echo esc_html('Enable')?></option>
                <option value="disable" <?php echo esc_attr($booked_days == 'disable' ? 'selected' : '')?>><?php echo esc_html('Disable')?></option>
            </select>
        </div>


        <div class="form_item">
            <label><?php echo __('Disable Work Days', 'tm-booking');
                $disable_days = '';
                if(isset($booking_settings['disable_days'])){
                    $disable_days = $booking_settings['disable_days'];
                }
            ?></label>
            <select name="tm_booking_settings[disable_days][]" multiple>
                <option value="0" <?php echo esc_attr(is_array($disable_days) && in_array("0", $disable_days) ? 'selected' : '')?>><?php echo esc_html('Sunday')?></option>
                <option value="1" <?php echo esc_attr(is_array($disable_days) && in_array("1", $disable_days) ? 'selected' : '')?>><?php echo esc_html('Monday')?></option>
                <option value="2" <?php echo esc_attr(is_array($disable_days) && in_array("2", $disable_days) ? 'selected' : '')?>><?php echo esc_html('Tuesday')?></option>
                <option value="3" <?php echo esc_attr(is_array($disable_days) && in_array("3", $disable_days) ? 'selected' : '')?>><?php echo esc_html('Wednesday')?></option>
                <option value="4" <?php echo esc_attr(is_array($disable_days) && in_array("4", $disable_days) ? 'selected' : '')?>><?php echo esc_html('Thursday')?></option>
                <option value="5" <?php echo esc_attr(is_array($disable_days) && in_array("5", $disable_days) ? 'selected' : '')?>><?php echo esc_html('Friday')?></option>
                <option value="6" <?php echo esc_attr(is_array($disable_days) && in_array("6", $disable_days) ? 'selected' : '')?>><?php echo esc_html('Saturday')?></option>
            </select>
        </div>

        <!-- WhatsApp Notification Settings -->
        <h3><?php echo esc_html__('WhatsApp Notifications', 'tm-booking'); ?></h3>
        <div class="form_item">
            <label><?php echo esc_html__('Enable WhatsApp Notifications', 'tm-booking'); ?></label>
            <select name="tm_booking_settings[whatsapp_enabled]">
                <?php $whatsapp_enabled = isset($booking_settings['whatsapp_enabled']) ? $booking_settings['whatsapp_enabled'] : 'no'; ?>
                <option <?php echo esc_attr($whatsapp_enabled == 'yes' ? 'selected' : '')?> value="yes"><?php echo esc_html__('Yes', 'tm-booking')?></option>
                <option <?php echo esc_attr($whatsapp_enabled == 'no' ? 'selected' : '')?> value="no"><?php echo esc_html__('No', 'tm-booking')?></option>
            </select>
            <p class="description"><?php echo esc_html__('Enable or disable WhatsApp notifications for new bookings.', 'tm-booking'); ?></p>
        </div>
        
        <div class="form_item">
            <label><?php echo esc_html__('Admin WhatsApp Number', 'tm-booking'); ?></label>
            <input type="text" name="tm_booking_settings[whatsapp_number]" value="<?php echo esc_attr(isset($booking_settings['whatsapp_number']) ? $booking_settings['whatsapp_number'] : ''); ?>" class="regular-text" />
            <p class="description"><?php echo esc_html__('Enter your WhatsApp number with country code (e.g., +12025551234).', 'tm-booking'); ?></p>
        </div>
        
        <div class="form_item">
            <label><?php echo esc_html__('WhatsApp API Key', 'tm-booking'); ?></label>
            <input type="text" name="tm_booking_settings[whatsapp_api_key]" value="<?php echo esc_attr(isset($booking_settings['whatsapp_api_key']) ? $booking_settings['whatsapp_api_key'] : ''); ?>" class="regular-text" />
            <p class="description">
                <?php echo esc_html__('Enter your WhatsApp API key from the WhatsApp Business API provider.', 'tm-booking'); ?>
                <a href="https://developers.facebook.com/docs/whatsapp/cloud-api/get-started" target="_blank"><?php echo esc_html__('How to get API Key', 'tm-booking'); ?></a>
            </p>
        </div>
        
        <div class="form_item">
            <label><?php echo esc_html__('WhatsApp Phone Number ID', 'tm-booking'); ?></label>
            <input type="text" name="tm_booking_settings[whatsapp_phone_number_id]" value="<?php echo esc_attr(isset($booking_settings['whatsapp_phone_number_id']) ? $booking_settings['whatsapp_phone_number_id'] : ''); ?>" class="regular-text" />
            <p class="description">
                <?php echo esc_html__('Enter your WhatsApp Phone Number ID from Meta Business Dashboard.', 'tm-booking'); ?>
                <a href="https://developers.facebook.com/docs/whatsapp/cloud-api/get-started#step-2---get-the-phone-number-id" target="_blank"><?php echo esc_html__('How to get Phone Number ID', 'tm-booking'); ?></a>
            </p>
        </div>
        
        <!-- Telegram Notification Settings -->
        <h3><?php echo esc_html__('Telegram Notifications', 'tm-booking'); ?></h3>
        <div class="form_item">
            <label><?php echo esc_html__('Enable Telegram Notifications', 'tm-booking'); ?></label>
            <select name="tm_booking_settings[telegram_enabled]">
                <?php $telegram_enabled = isset($booking_settings['telegram_enabled']) ? $booking_settings['telegram_enabled'] : 'no'; ?>
                <option <?php echo esc_attr($telegram_enabled == 'yes' ? 'selected' : '')?> value="yes"><?php echo esc_html__('Yes', 'tm-booking')?></option>
                <option <?php echo esc_attr($telegram_enabled == 'no' ? 'selected' : '')?> value="no"><?php echo esc_html__('No', 'tm-booking')?></option>
            </select>
            <p class="description"><?php echo esc_html__('Enable or disable Telegram notifications for new bookings.', 'tm-booking'); ?></p>
        </div>
        
        <div class="form_item">
            <label><?php echo esc_html__('Telegram Bot Token', 'tm-booking'); ?></label>
            <input type="text" name="tm_booking_settings[telegram_bot_token]" value="<?php echo esc_attr(isset($booking_settings['telegram_bot_token']) ? $booking_settings['telegram_bot_token'] : ''); ?>" class="regular-text" />
            <p class="description">
                <?php echo esc_html__('Enter your Telegram Bot Token from BotFather.', 'tm-booking'); ?>
                <a href="https://core.telegram.org/bots/tutorial#obtain-your-bot-token" target="_blank"><?php echo esc_html__('How to get Bot Token', 'tm-booking'); ?></a>
            </p>
        </div>
        
        <div class="form_item">
            <label><?php echo esc_html__('Telegram Chat ID', 'tm-booking'); ?></label>
            <input type="text" name="tm_booking_settings[telegram_chat_id]" value="<?php echo esc_attr(isset($booking_settings['telegram_chat_id']) ? $booking_settings['telegram_chat_id'] : ''); ?>" class="regular-text" />
            <p class="description">
                <?php echo esc_html__('Enter your Telegram Chat ID where notifications will be sent.', 'tm-booking'); ?>
                <a href="https://telegram.me/userinfobot" target="_blank"><?php echo esc_html__('How to get Chat ID', 'tm-booking'); ?></a>
            </p>
        </div>

        <!-- Twilio SMS Notification Settings -->
        <h3><?php echo esc_html__('SMS Notifications (Twilio)', 'tm-booking'); ?></h3>
        <div class="form_item">
            <label><?php echo esc_html__('Enable SMS Notifications', 'tm-booking'); ?></label>
            <select name="tm_booking_settings[sms_enabled]">
                <?php $sms_enabled = isset($booking_settings['sms_enabled']) ? $booking_settings['sms_enabled'] : 'no'; ?>
                <option <?php echo esc_attr($sms_enabled == 'yes' ? 'selected' : '')?> value="yes"><?php echo esc_html__('Yes', 'tm-booking')?></option>
                <option <?php echo esc_attr($sms_enabled == 'no' ? 'selected' : '')?> value="no"><?php echo esc_html__('No', 'tm-booking')?></option>
            </select>
            <p class="description"><?php echo esc_html__('Enable or disable SMS notifications for new bookings.', 'tm-booking'); ?></p>
        </div>
        
        <div class="form_item">
            <label><?php echo esc_html__('Admin Phone Number', 'tm-booking'); ?></label>
            <input type="text" name="tm_booking_settings[admin_phone_number]" value="<?php echo esc_attr(isset($booking_settings['admin_phone_number']) ? $booking_settings['admin_phone_number'] : ''); ?>" class="regular-text" />
            <p class="description"><?php echo esc_html__('Enter your phone number with country code (e.g., +12025551234).', 'tm-booking'); ?></p>
        </div>
        
        <div class="form_item">
            <label><?php echo esc_html__('Twilio Account SID', 'tm-booking'); ?></label>
            <input type="text" name="tm_booking_settings[twilio_account_sid]" value="<?php echo esc_attr(isset($booking_settings['twilio_account_sid']) ? $booking_settings['twilio_account_sid'] : ''); ?>" class="regular-text" />
            <p class="description">
                <?php echo esc_html__('Enter your Twilio Account SID from your Twilio dashboard.', 'tm-booking'); ?>
                <a href="https://www.twilio.com/console" target="_blank"><?php echo esc_html__('Twilio Console', 'tm-booking'); ?></a>
            </p>
        </div>
        
        <div class="form_item">
            <label><?php echo esc_html__('Twilio Auth Token', 'tm-booking'); ?></label>
            <input type="password" name="tm_booking_settings[twilio_auth_token]" value="<?php echo esc_attr(isset($booking_settings['twilio_auth_token']) ? $booking_settings['twilio_auth_token'] : ''); ?>" class="regular-text" />
            <p class="description">
                <?php echo esc_html__('Enter your Twilio Auth Token from your Twilio dashboard.', 'tm-booking'); ?>
                <a href="https://www.twilio.com/console" target="_blank"><?php echo esc_html__('Twilio Console', 'tm-booking'); ?></a>
            </p>
        </div>
        
        <div class="form_item">
            <label><?php echo esc_html__('Twilio Phone Number', 'tm-booking'); ?></label>
            <input type="text" name="tm_booking_settings[twilio_phone_number]" value="<?php echo esc_attr(isset($booking_settings['twilio_phone_number']) ? $booking_settings['twilio_phone_number'] : ''); ?>" class="regular-text" />
            <p class="description">
                <?php echo esc_html__('Enter your Twilio phone number with country code (e.g., +12025551234).', 'tm-booking'); ?>
                <a href="https://www.twilio.com/console/phone-numbers/incoming" target="_blank"><?php echo esc_html__('Your Twilio Numbers', 'tm-booking'); ?></a>
            </p>
        </div>
        
        <div class="form_item">
            <button class="tmbooking_save_btn"><?php echo esc_html('Save')?></button>
        </div>

    </form>
</div>



<?php
if(isset($_POST['tm_booking_settings'])){
    $_POST['tm_booking_settings']['calc_periods'][] = 'calc_days';
    if($_POST['tm_booking_settings']['date_format_old'] !== $booking_settings['date_format'] ){
        $_POST['tm_booking_settings']['date_format_old'] = $booking_settings['date_format'];
    }
    if(isset($_POST['tm_booking_settings']['date_format']) && $_POST['tm_booking_settings']['date_format'] != ''){
        if($booking_settings['date_format'] != $_POST['tm_booking_settings']['date_format']){
            $custom_posts = get_posts(array(
                'fields'          => 'ids',
                'posts_per_page'  => -1,
                'post_type' => tmbooking_get_post_type()
            ));
            $new_arr = array();
            if(isset($custom_posts) && !empty($custom_posts)){
                foreach ($custom_posts as $cp){
                    $check_booked_days = get_post_meta($cp, '_tmbooking_data', true);
                    if(isset($check_booked_days) && !empty($check_booked_days)){

                        foreach ($check_booked_days as $booked_day){
                            $date_format_old = TMBooking__Helping_Addons::construct_date_format( $_POST['tm_booking_settings']['date_format_old']);
                            $date_format = TMBooking__Helping_Addons::construct_date_format($_POST['tm_booking_settings']['date_format']);
                            $date = DateTime::createFromFormat($date_format_old, $booked_day);
                            $new_arr[] = $date->format($date_format);
                        }
                    }

                    update_post_meta($cp, '_tmbooking_data', $new_arr);
                }
            }
        }
    }



    update_option('tm_booking_settings', $_POST['tm_booking_settings']);


    $redirect_url = get_admin_url() . '?page=tm-booking';
    echo '<script>window.location.href = "' . $redirect_url . '"</script>';
}
?>

<h2><?php echo ucfirst(tmbooking_get_post_type()) . '/Products relation';?></h2>
<div class="tmbooking_settings_container">
    <?php
    if(isset($_GET['reset']) && $_GET['reset'] == 'true'){
        tmbooking_parsing_item_product(true);
    }
    $permalink = admin_url() .'?page=tm-booking&reset=true';
    ?>
    <div class="form_item">
        <a class="tmbooking_save_btn" href="<?php echo esc_url($permalink);?>"><?php echo esc_html('Reset')?></a>
    </div>
</div>
