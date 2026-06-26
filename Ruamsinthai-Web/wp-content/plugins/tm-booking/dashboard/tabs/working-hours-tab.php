<?php
/**
 * Working Hours & Availability Tab Content
 * Author: Templines
 * Website: templines.com
 */
?>

<div class="tm-booking-form-section">
    <h3><?php echo esc_html__('Working Hours', 'tm-booking'); ?></h3>
    <div class="description">
        <?php echo esc_html__('Set the operating hours for your rental business.', 'tm-booking'); ?>
    </div>

    <div class="form_item_inner">
        <label><?php echo esc_html__('Working Hours Start', 'tm-booking'); ?></label>
        <select name="tm_booking_settings[working_hours][start]">
            <?php 
            $working_hours_start = isset($booking_settings['working_hours']['start']) ? $booking_settings['working_hours']['start'] : 'disable';
            ?>
            <option value="disable" <?php echo esc_attr($working_hours_start == 'disable' ? 'selected' : ''); ?>>
                <?php echo esc_html__('Disable', 'tm-booking'); ?>
            </option>
            <?php for($i = 0; $i < 24; $i++): ?>
                <?php $time = sprintf('%02d:00', $i); ?>
                <option value="<?php echo $time; ?>" <?php echo esc_attr($working_hours_start == $time ? 'selected' : ''); ?>>
                    <?php echo $time; ?>
                </option>
            <?php endfor; ?>
        </select>
    </div>

    <div class="form_item_inner">
        <label><?php echo esc_html__('Working Hours End', 'tm-booking'); ?></label>
        <select name="tm_booking_settings[working_hours][end]">
            <?php 
            $working_hours_end = isset($booking_settings['working_hours']['end']) ? $booking_settings['working_hours']['end'] : 'disable';
            ?>
            <option value="disable" <?php echo esc_attr($working_hours_end == 'disable' ? 'selected' : ''); ?>>
                <?php echo esc_html__('Disable', 'tm-booking'); ?>
            </option>
            <?php for($i = 0; $i < 24; $i++): ?>
                <?php $time = sprintf('%02d:00', $i); ?>
                <option value="<?php echo $time; ?>" <?php echo esc_attr($working_hours_end == $time ? 'selected' : ''); ?>>
                    <?php echo $time; ?>
                </option>
            <?php endfor; ?>
        </select>
    </div>

    <div class="description">
        <?php echo esc_html__('Set your business operating hours. Bookings outside these hours may be restricted.', 'tm-booking'); ?>
    </div>
</div>

<div class="tm-booking-form-section">
    <h3><?php echo esc_html__('Disabled Days', 'tm-booking'); ?></h3>
    <div class="description">
        <?php echo esc_html__('Select days of the week when bookings are not available.', 'tm-booking'); ?>
    </div>

    <div class="form_item">
        <label><?php echo esc_html__('Disable Work Days', 'tm-booking'); ?></label>
        <select name="tm_booking_settings[disable_days][]" multiple>
            <?php 
            $disable_days = isset($booking_settings['disable_days']) ? $booking_settings['disable_days'] : [];
            if (!is_array($disable_days)) {
                $disable_days = [];
            }
            ?>
            <option value="0" <?php echo esc_attr(in_array("0", $disable_days) ? 'selected' : ''); ?>>
                <?php echo esc_html__('Sunday', 'tm-booking'); ?>
            </option>
            <option value="1" <?php echo esc_attr(in_array("1", $disable_days) ? 'selected' : ''); ?>>
                <?php echo esc_html__('Monday', 'tm-booking'); ?>
            </option>
            <option value="2" <?php echo esc_attr(in_array("2", $disable_days) ? 'selected' : ''); ?>>
                <?php echo esc_html__('Tuesday', 'tm-booking'); ?>
            </option>
            <option value="3" <?php echo esc_attr(in_array("3", $disable_days) ? 'selected' : ''); ?>>
                <?php echo esc_html__('Wednesday', 'tm-booking'); ?>
            </option>
            <option value="4" <?php echo esc_attr(in_array("4", $disable_days) ? 'selected' : ''); ?>>
                <?php echo esc_html__('Thursday', 'tm-booking'); ?>
            </option>
            <option value="5" <?php echo esc_attr(in_array("5", $disable_days) ? 'selected' : ''); ?>>
                <?php echo esc_html__('Friday', 'tm-booking'); ?>
            </option>
            <option value="6" <?php echo esc_attr(in_array("6", $disable_days) ? 'selected' : ''); ?>>
                <?php echo esc_html__('Saturday', 'tm-booking'); ?>
            </option>
        </select>
        <div class="description">
            <?php echo esc_html__('Hold Ctrl/Cmd to select multiple days. Selected days will be disabled for bookings.', 'tm-booking'); ?>
        </div>
    </div>
</div>

<div class="tm-booking-form-section">
    <h3><?php echo esc_html__('Availability Status', 'tm-booking'); ?></h3>
    <div class="description">
        <?php echo esc_html__('Current availability settings overview.', 'tm-booking'); ?>
    </div>

    <div class="tm-booking-help-text">
        <strong><?php echo esc_html__('Current Settings:', 'tm-booking'); ?></strong><br>
        
        <strong><?php echo esc_html__('Working Hours:', 'tm-booking'); ?></strong>
        <?php if ($working_hours_start !== 'disable' && $working_hours_end !== 'disable'): ?>
            <span class="tm-booking-status-enabled">
                <?php echo sprintf(esc_html__('%s to %s', 'tm-booking'), $working_hours_start, $working_hours_end); ?>
            </span>
        <?php else: ?>
            <span class="tm-booking-status-disabled"><?php echo esc_html__('24/7 Available', 'tm-booking'); ?></span>
        <?php endif; ?>
        <br>
        
        <strong><?php echo esc_html__('Disabled Days:', 'tm-booking'); ?></strong>
        <?php if (!empty($disable_days)): ?>
            <span class="tm-booking-status-disabled">
                <?php 
                $day_names = [
                    '0' => __('Sunday', 'tm-booking'),
                    '1' => __('Monday', 'tm-booking'),
                    '2' => __('Tuesday', 'tm-booking'),
                    '3' => __('Wednesday', 'tm-booking'),
                    '4' => __('Thursday', 'tm-booking'),
                    '5' => __('Friday', 'tm-booking'),
                    '6' => __('Saturday', 'tm-booking')
                ];
                $disabled_day_names = array_map(function($day) use ($day_names) {
                    return $day_names[$day];
                }, $disable_days);
                echo implode(', ', $disabled_day_names);
                ?>
            </span>
        <?php else: ?>
            <span class="tm-booking-status-enabled"><?php echo esc_html__('All days available', 'tm-booking'); ?></span>
        <?php endif; ?>
    </div>
</div>
