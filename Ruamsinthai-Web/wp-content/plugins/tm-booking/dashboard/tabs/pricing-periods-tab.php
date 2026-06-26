<?php
/**
 * Pricing & Period Calculation Tab Content
 * Author: Templines
 * Website: templines.com
 */
?>

<div class="tm-booking-form-section">
    <h3><?php echo esc_html__('Calculation Periods', 'tm-booking'); ?></h3>
    <div class="description">
        <?php echo esc_html__('Select which time periods can be used for price calculation.', 'tm-booking'); ?>
    </div>

    <div class="form_item">
        <label><?php echo esc_html__('Calculate Periods', 'tm-booking'); ?></label>
        <select name="tm_booking_settings[calc_periods][]" multiple class="tm_booking_settings_calc_periods">
            <?php
            $calc_periods = isset($booking_settings['calc_periods']) && is_array($booking_settings['calc_periods']) ? $booking_settings['calc_periods'] : [];
            ?>
            <option <?php echo esc_attr(in_array("calc_hours", $calc_periods) ? 'selected' : ''); ?> value="calc_hours"><?php echo esc_html__('Hours', 'tm-booking'); ?></option>
            <option selected value="calc_days" disabled><?php echo esc_html__('Days', 'tm-booking'); ?></option>
            <option <?php echo esc_attr(in_array("calc_weeks", $calc_periods) ? 'selected' : ''); ?> value="calc_weeks"><?php echo esc_html__('Weeks', 'tm-booking'); ?></option>
            <option <?php echo esc_attr(in_array("calc_month", $calc_periods) ? 'selected' : ''); ?> value="calc_month"><?php echo esc_html__('Month', 'tm-booking'); ?></option>
        </select>
        <div class="description">
            <?php echo esc_html__('Hold Ctrl/Cmd to select multiple periods. Days calculation is always enabled.', 'tm-booking'); ?>
        </div>
    </div>

    <?php if(in_array("calc_hours", $calc_periods)): ?>
    <div class="form_item time-format-container">
        <label><?php echo esc_html__('Time Format', 'tm-booking'); ?></label>
        <select name="tm_booking_settings[time_format]">
            <option value="24h" <?php echo isset($booking_settings['time_format']) && $booking_settings['time_format'] === '24h' ? 'selected' : ''; ?>>
                <?php echo esc_html__('24-hour format (00:00 - 23:59)', 'tm-booking'); ?>
            </option>
            <option value="12h" <?php echo isset($booking_settings['time_format']) && $booking_settings['time_format'] === '12h' ? 'selected' : ''; ?>>
                <?php echo esc_html__('12-hour format with AM/PM (12:00 AM - 11:59 PM)', 'tm-booking'); ?>
            </option>
        </select>
        <div class="description">
            <?php echo esc_html__('Choose time format for the booking calendar when hours calculation is enabled.', 'tm-booking'); ?>
        </div>
    </div>
    <?php endif; ?>
</div>

<div class="tm-booking-form-section">
    <h3><?php echo esc_html__('Extra Options Settings', 'tm-booking'); ?></h3>
    <div class="description">
        <?php echo esc_html__('Configure settings for extra options display.', 'tm-booking'); ?>
    </div>

    <div class="form_item">
        <label><?php echo esc_html__('Extra Options Title', 'tm-booking'); ?></label>
        <input type="text" name="tm_booking_settings[extras_title]" value="<?php echo isset($booking_settings['extras_title']) ? esc_attr($booking_settings['extras_title']) : ''; ?>" />
        <div class="description">
            <?php echo esc_html__('Enter a title that will appear above the extra options list. Leave empty for no title.', 'tm-booking'); ?>
        </div>
    </div>
</div>

<div class="tm-booking-form-section">
    <h3><?php echo esc_html__('Rental Duration Limits', 'tm-booking'); ?></h3>
    <div class="description">
        <?php echo esc_html__('Set minimum rental durations and calculation thresholds.', 'tm-booking'); ?>
    </div>

    <div class="form_item">
        <label><?php echo esc_html__('Minimum Hours to Rent', 'tm-booking'); ?></label>
        <select name="tm_booking_settings[minimum_hours]">
            <?php 
            $minimum_hours = isset($booking_settings['minimum_hours']) ? $booking_settings['minimum_hours'] : 'disable';
            ?>
            <option value="disable" <?php echo esc_attr($minimum_hours == 'disable' ? 'selected' : ''); ?>>
                <?php echo esc_html__('Disable', 'tm-booking'); ?>
            </option>
            <?php for($i = 1; $i <= 23; $i++): ?>
            <option value="<?php echo $i; ?>" <?php echo esc_attr($minimum_hours == $i ? 'selected' : ''); ?>>
                <?php echo sprintf(esc_html__('%d Hour%s', 'tm-booking'), $i, $i > 1 ? 's' : ''); ?>
            </option>
            <?php endfor; ?>
        </select>
        <div class="description">
            <?php echo esc_html__('Set the minimum number of hours required for a rental.', 'tm-booking'); ?>
        </div>
    </div>

    <div class="form_item">
        <label><?php echo esc_html__('Minimum Hours to Calculate as Day', 'tm-booking'); ?></label>
        <select name="tm_booking_settings[minimum_hours_day]">
            <?php 
            $minimum_hours_day = isset($booking_settings['minimum_hours_day']) ? $booking_settings['minimum_hours_day'] : 'disable';
            ?>
            <option value="disable" <?php echo esc_attr($minimum_hours_day == 'disable' ? 'selected' : ''); ?>>
                <?php echo esc_html__('Disable', 'tm-booking'); ?>
            </option>
            <?php for($i = 1; $i <= 23; $i++): ?>
            <option value="<?php echo $i; ?>" <?php echo esc_attr($minimum_hours_day == $i ? 'selected' : ''); ?>>
                <?php echo sprintf(esc_html__('%d Hour%s', 'tm-booking'), $i, $i > 1 ? 's' : ''); ?>
            </option>
            <?php endfor; ?>
        </select>
        <div class="description">
            <?php echo esc_html__('When hourly rental reaches this threshold, it will be calculated as a full day.', 'tm-booking'); ?>
        </div>
    </div>
</div>

<div class="tm-booking-form-section">
    <h3><?php echo esc_html__('Pricing Information', 'tm-booking'); ?></h3>
    <div class="description">
        <?php echo esc_html__('These settings affect how prices are displayed and calculated.', 'tm-booking'); ?>
    </div>

    <div class="tm-booking-help-text">
        <strong><?php echo esc_html__('Note:', 'tm-booking'); ?></strong>
        <?php echo esc_html__('Individual product prices are set in the product edit page. These settings control the calculation logic and display format.', 'tm-booking'); ?>
    </div>

    <div class="form_item">
        <label><?php echo esc_html__('Price Calculation Priority', 'tm-booking'); ?></label>
        <div class="description">
            <?php echo esc_html__('When multiple periods are enabled, the system will calculate the most cost-effective combination for the customer.', 'tm-booking'); ?>
        </div>
        <ul style="margin-left: 20px; color: #666;">
            <li><?php echo esc_html__('Monthly rates are applied first for long rentals', 'tm-booking'); ?></li>
            <li><?php echo esc_html__('Weekly rates are used for 7+ day periods', 'tm-booking'); ?></li>
            <li><?php echo esc_html__('Daily rates fill remaining days', 'tm-booking'); ?></li>
            <li><?php echo esc_html__('Hourly rates are used for short-term rentals', 'tm-booking'); ?></li>
        </ul>
    </div>
</div>
