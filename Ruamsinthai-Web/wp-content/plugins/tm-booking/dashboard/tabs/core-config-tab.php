<?php
/**
 * Core Booking Configuration Tab Content
 * Author: Templines
 * Website: templines.com
 */
?>

<div class="tm-booking-form-section">
    <h3><?php echo esc_html__('Basic Configuration', 'tm-booking'); ?></h3>
    <div class="description">
        <?php echo esc_html__('Configure the fundamental settings for your booking system.', 'tm-booking'); ?>
    </div>

    <div class="form_item">
        <label><?php echo esc_html__('Post Type', 'tm-booking'); ?></label>
        <select name="tm_booking_settings[post_type]">
            <option value="unset" selected><?php echo esc_html__('--Select Post Type--', 'tm-booking'); ?></option>
            <?php foreach ($post_types as $key => $post_type): ?>
                <option value="<?php echo esc_attr($key); ?>" <?php echo esc_attr(isset($booking_settings['post_type']) && $booking_settings['post_type'] == $key ? 'selected' : ''); ?>>
                    <?php echo esc_html($post_type); ?>
                </option>
            <?php endforeach; ?>
        </select>
        <div class="description">
            <?php echo esc_html__('Select the post type that will be used for bookable items.', 'tm-booking'); ?>
        </div>
    </div>

    <div class="form_item">
        <label><?php echo esc_html__('Date Format', 'tm-booking'); ?></label>
        <input type="hidden" value="<?php echo esc_attr(isset($booking_settings['date_format_old']) ? $booking_settings['date_format_old'] : ''); ?>" name="tm_booking_settings[date_format_old]"/>
        <select name="tm_booking_settings[date_format]">
            <?php $current_date_format = isset($booking_settings['date_format']) ? $booking_settings['date_format'] : 'MM/DD/YYYY'; ?>
            <option <?php echo esc_attr($current_date_format == 'MM/DD/YYYY' ? 'selected' : ''); ?> value="MM/DD/YYYY">MM/DD/YYYY</option>
            <option <?php echo esc_attr($current_date_format == 'DD/MM/YYYY' ? 'selected' : ''); ?> value="DD/MM/YYYY">DD/MM/YYYY</option>
            <option <?php echo esc_attr($current_date_format == 'MM-DD-YYYY' ? 'selected' : ''); ?> value="MM-DD-YYYY">MM-DD-YYYY</option>
            <option <?php echo esc_attr($current_date_format == 'DD-MM-YYYY' ? 'selected' : ''); ?> value="DD-MM-YYYY">DD-MM-YYYY</option>
            <option <?php echo esc_attr($current_date_format == 'MM.DD.YYYY' ? 'selected' : ''); ?> value="MM.DD.YYYY">MM.DD.YYYY</option>
            <option <?php echo esc_attr($current_date_format == 'DD.MM.YYYY' ? 'selected' : ''); ?> value="DD.MM.YYYY">DD.MM.YYYY</option>
        </select>
        <div class="description">
            <?php echo esc_html__('Choose the date format for the booking calendar.', 'tm-booking'); ?>
        </div>
    </div>

    <div class="form_item">
        <label><?php echo esc_html__('Show Discounts', 'tm-booking'); ?></label>
        <select name="tm_booking_settings[show_discounts]">
            <?php $show_discounts = isset($booking_settings['show_discounts']) ? $booking_settings['show_discounts'] : 'yes'; ?>
            <option <?php echo esc_attr($show_discounts == 'yes' ? 'selected' : ''); ?> value="yes"><?php echo esc_html__('Yes', 'tm-booking'); ?></option>
            <option <?php echo esc_attr($show_discounts == 'no' ? 'selected' : ''); ?> value="no"><?php echo esc_html__('No', 'tm-booking'); ?></option>
        </select>
        <div class="description">
            <?php echo esc_html__('Choose whether to display discount information on booking pages.', 'tm-booking'); ?>
        </div>
    </div>
</div>

<div class="tm-booking-form-section">
    <h3><?php echo esc_html__('Calendar Display Settings', 'tm-booking'); ?></h3>
    <div class="description">
        <?php echo esc_html__('Customize how the booking calendar appears to users.', 'tm-booking'); ?>
    </div>

    <div class="form_item_inner">
        <label><?php echo esc_html__('Calendar Position', 'tm-booking'); ?></label>
        <select name="tm_booking_settings[drops]">
            <?php $drops = isset($booking_settings['drops']) ? $booking_settings['drops'] : 'down'; ?>
            <option <?php echo esc_attr($drops == 'down' ? 'selected' : ''); ?> value="down"><?php echo esc_html__('Down', 'tm-booking'); ?></option>
            <option <?php echo esc_attr($drops == 'up' ? 'selected' : ''); ?> value="up"><?php echo esc_html__('Up', 'tm-booking'); ?></option>
            <option <?php echo esc_attr($drops == 'auto' ? 'selected' : ''); ?> value="auto"><?php echo esc_html__('Auto', 'tm-booking'); ?></option>
        </select>
    </div>

    <div class="form_item_inner">
        <label><?php echo esc_html__('Week Numbers', 'tm-booking'); ?></label>
        <select name="tm_booking_settings[showWeekNumbers]">
            <?php $showWeekNumbers = isset($booking_settings['showWeekNumbers']) ? $booking_settings['showWeekNumbers'] : 'false'; ?>
            <option <?php echo esc_attr($showWeekNumbers == 'true' ? 'selected' : ''); ?> value="true"><?php echo esc_html__('Show', 'tm-booking'); ?></option>
            <option <?php echo esc_attr($showWeekNumbers == 'false' ? 'selected' : ''); ?> value="false"><?php echo esc_html__('Hide', 'tm-booking'); ?></option>
        </select>
    </div>

    <div class="form_item_inner">
        <label><?php echo esc_html__('ISO Week Numbers', 'tm-booking'); ?></label>
        <select name="tm_booking_settings[showISOWeekNumbers]">
            <?php $showISOWeekNumbers = isset($booking_settings['showISOWeekNumbers']) ? $booking_settings['showISOWeekNumbers'] : 'false'; ?>
            <option <?php echo esc_attr($showISOWeekNumbers == 'true' ? 'selected' : ''); ?> value="true"><?php echo esc_html__('Show', 'tm-booking'); ?></option>
            <option <?php echo esc_attr($showISOWeekNumbers == 'false' ? 'selected' : ''); ?> value="false"><?php echo esc_html__('Hide', 'tm-booking'); ?></option>
        </select>
    </div>
</div>

<div class="tm-booking-form-section">
    <h3><?php echo esc_html__('Booking Restrictions', 'tm-booking'); ?></h3>
    <div class="description">
        <?php echo esc_html__('Control booking availability and restrictions.', 'tm-booking'); ?>
    </div>

    <div class="form_item">
        <label><?php echo esc_html__('Block Booked Days in Calendar', 'tm-booking'); ?></label>
        <select name="tm_booking_settings[booked_days]">
            <?php $booked_days = isset($booking_settings['booked_days']) ? $booking_settings['booked_days'] : 'enable'; ?>
            <option <?php echo esc_attr($booked_days == 'enable' ? 'selected' : ''); ?> value="enable"><?php echo esc_html__('Enable', 'tm-booking'); ?></option>
            <option <?php echo esc_attr($booked_days == 'disable' ? 'selected' : ''); ?> value="disable"><?php echo esc_html__('Disable', 'tm-booking'); ?></option>
        </select>
        <div class="description">
            <?php echo esc_html__('When enabled, already booked dates will be blocked in the calendar.', 'tm-booking'); ?>
        </div>
    </div>
</div>
