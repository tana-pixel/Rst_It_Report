<?php
/**
 * Notifications Tab Content
 * Author: Templines
 * Website: templines.com
 */
?>

<!-- WhatsApp Notifications -->
<div class="tm-booking-form-section">
    <h3><?php echo esc_html__('WhatsApp Notifications', 'tm-booking'); ?></h3>
    <div class="description">
        <?php echo esc_html__('Configure WhatsApp notifications for new bookings using WhatsApp Business API.', 'tm-booking'); ?>
    </div>

    <div class="form_item">
        <label><?php echo esc_html__('Enable WhatsApp Notifications', 'tm-booking'); ?></label>
        <select name="tm_booking_settings[whatsapp_enabled]">
            <?php $whatsapp_enabled = isset($booking_settings['whatsapp_enabled']) ? $booking_settings['whatsapp_enabled'] : 'no'; ?>
            <option <?php echo esc_attr($whatsapp_enabled == 'yes' ? 'selected' : ''); ?> value="yes"><?php echo esc_html__('Yes', 'tm-booking'); ?></option>
            <option <?php echo esc_attr($whatsapp_enabled == 'no' ? 'selected' : ''); ?> value="no"><?php echo esc_html__('No', 'tm-booking'); ?></option>
        </select>
        <div class="description">
            <?php echo esc_html__('Enable or disable WhatsApp notifications for new bookings.', 'tm-booking'); ?>
        </div>
    </div>
    
    <div class="whatsapp-fields-container" style="<?php echo $whatsapp_enabled === 'no' ? 'display: none;' : ''; ?>">
        <div class="form_item">
            <label><?php echo esc_html__('Admin WhatsApp Number', 'tm-booking'); ?></label>
            <input type="text" name="tm_booking_settings[whatsapp_number]" value="<?php echo esc_attr(isset($booking_settings['whatsapp_number']) ? $booking_settings['whatsapp_number'] : ''); ?>" class="regular-text" />
            <div class="description">
                <?php echo esc_html__('Enter your WhatsApp number with country code (e.g., +12025551234).', 'tm-booking'); ?>
            </div>
        </div>
        
        <div class="form_item">
            <label><?php echo esc_html__('WhatsApp API Key', 'tm-booking'); ?></label>
            <input type="text" name="tm_booking_settings[whatsapp_api_key]" value="<?php echo esc_attr(isset($booking_settings['whatsapp_api_key']) ? $booking_settings['whatsapp_api_key'] : ''); ?>" class="regular-text" />
            <div class="description">
                <?php echo esc_html__('Enter your WhatsApp API key from the WhatsApp Business API provider.', 'tm-booking'); ?>
                <a href="https://developers.facebook.com/docs/whatsapp/cloud-api/get-started" target="_blank"><?php echo esc_html__('How to get API Key', 'tm-booking'); ?></a>
            </div>
        </div>
        
        <div class="form_item">
            <label><?php echo esc_html__('WhatsApp Phone Number ID', 'tm-booking'); ?></label>
            <input type="text" name="tm_booking_settings[whatsapp_phone_number_id]" value="<?php echo esc_attr(isset($booking_settings['whatsapp_phone_number_id']) ? $booking_settings['whatsapp_phone_number_id'] : ''); ?>" class="regular-text" />
            <div class="description">
                <?php echo esc_html__('Enter your WhatsApp Phone Number ID from Meta Business Dashboard.', 'tm-booking'); ?>
                <a href="https://developers.facebook.com/docs/whatsapp/cloud-api/get-started#step-2---get-the-phone-number-id" target="_blank"><?php echo esc_html__('How to get Phone Number ID', 'tm-booking'); ?></a>
            </div>
        </div>
    </div>
</div>

<!-- Telegram Notifications -->
<div class="tm-booking-form-section">
    <h3><?php echo esc_html__('Telegram Notifications', 'tm-booking'); ?></h3>
    <div class="description">
        <?php echo esc_html__('Configure Telegram bot notifications for new bookings.', 'tm-booking'); ?>
    </div>

    <div class="form_item">
        <label><?php echo esc_html__('Enable Telegram Notifications', 'tm-booking'); ?></label>
        <select name="tm_booking_settings[telegram_enabled]">
            <?php $telegram_enabled = isset($booking_settings['telegram_enabled']) ? $booking_settings['telegram_enabled'] : 'no'; ?>
            <option <?php echo esc_attr($telegram_enabled == 'yes' ? 'selected' : ''); ?> value="yes"><?php echo esc_html__('Yes', 'tm-booking'); ?></option>
            <option <?php echo esc_attr($telegram_enabled == 'no' ? 'selected' : ''); ?> value="no"><?php echo esc_html__('No', 'tm-booking'); ?></option>
        </select>
        <div class="description">
            <?php echo esc_html__('Enable or disable Telegram notifications for new bookings.', 'tm-booking'); ?>
        </div>
    </div>
    
    <div class="telegram-fields-container" style="<?php echo $telegram_enabled === 'no' ? 'display: none;' : ''; ?>">
        <div class="form_item">
            <label><?php echo esc_html__('Telegram Bot Token', 'tm-booking'); ?></label>
            <input type="text" name="tm_booking_settings[telegram_bot_token]" value="<?php echo esc_attr(isset($booking_settings['telegram_bot_token']) ? $booking_settings['telegram_bot_token'] : ''); ?>" class="regular-text" />
            <div class="description">
                <?php echo esc_html__('Enter your Telegram Bot Token from BotFather.', 'tm-booking'); ?>
                <a href="https://core.telegram.org/bots/tutorial#obtain-your-bot-token" target="_blank"><?php echo esc_html__('How to get Bot Token', 'tm-booking'); ?></a>
            </div>
        </div>
        
        <div class="form_item">
            <label><?php echo esc_html__('Telegram Chat ID', 'tm-booking'); ?></label>
            <input type="text" name="tm_booking_settings[telegram_chat_id]" value="<?php echo esc_attr(isset($booking_settings['telegram_chat_id']) ? $booking_settings['telegram_chat_id'] : ''); ?>" class="regular-text" />
            <div class="description">
                <?php echo esc_html__('Enter your Telegram Chat ID where notifications will be sent.', 'tm-booking'); ?>
                <a href="https://telegram.me/userinfobot" target="_blank"><?php echo esc_html__('How to get Chat ID', 'tm-booking'); ?></a>
            </div>
        </div>
    </div>
</div>

<!-- SMS Notifications (Twilio) -->
<div class="tm-booking-form-section">
    <h3><?php echo esc_html__('SMS Notifications (Twilio)', 'tm-booking'); ?></h3>
    <div class="description">
        <?php echo esc_html__('Configure SMS notifications using Twilio service for new bookings.', 'tm-booking'); ?>
    </div>

    <div class="form_item">
        <label><?php echo esc_html__('Enable SMS Notifications', 'tm-booking'); ?></label>
        <select name="tm_booking_settings[sms_enabled]">
            <?php $sms_enabled = isset($booking_settings['sms_enabled']) ? $booking_settings['sms_enabled'] : 'no'; ?>
            <option <?php echo esc_attr($sms_enabled == 'yes' ? 'selected' : ''); ?> value="yes"><?php echo esc_html__('Yes', 'tm-booking'); ?></option>
            <option <?php echo esc_attr($sms_enabled == 'no' ? 'selected' : ''); ?> value="no"><?php echo esc_html__('No', 'tm-booking'); ?></option>
        </select>
        <div class="description">
            <?php echo esc_html__('Enable or disable SMS notifications for new bookings.', 'tm-booking'); ?>
        </div>
    </div>
    
    <div class="sms-fields-container" style="<?php echo $sms_enabled === 'no' ? 'display: none;' : ''; ?>">
        <div class="form_item">
            <label><?php echo esc_html__('Admin Phone Number', 'tm-booking'); ?></label>
            <input type="text" name="tm_booking_settings[admin_phone_number]" value="<?php echo esc_attr(isset($booking_settings['admin_phone_number']) ? $booking_settings['admin_phone_number'] : ''); ?>" class="regular-text" />
            <div class="description">
                <?php echo esc_html__('Enter your phone number with country code (e.g., +12025551234).', 'tm-booking'); ?>
            </div>
        </div>
        
        <div class="form_item">
            <label><?php echo esc_html__('Twilio Account SID', 'tm-booking'); ?></label>
            <input type="text" name="tm_booking_settings[twilio_account_sid]" value="<?php echo esc_attr(isset($booking_settings['twilio_account_sid']) ? $booking_settings['twilio_account_sid'] : ''); ?>" class="regular-text" />
            <div class="description">
                <?php echo esc_html__('Enter your Twilio Account SID from your Twilio dashboard.', 'tm-booking'); ?>
                <a href="https://www.twilio.com/console" target="_blank"><?php echo esc_html__('Twilio Console', 'tm-booking'); ?></a>
            </div>
        </div>
        
        <div class="form_item">
            <label><?php echo esc_html__('Twilio Auth Token', 'tm-booking'); ?></label>
            <input type="password" name="tm_booking_settings[twilio_auth_token]" value="<?php echo esc_attr(isset($booking_settings['twilio_auth_token']) ? $booking_settings['twilio_auth_token'] : ''); ?>" class="regular-text" />
            <div class="description">
                <?php echo esc_html__('Enter your Twilio Auth Token from your Twilio dashboard.', 'tm-booking'); ?>
                <a href="https://www.twilio.com/console" target="_blank"><?php echo esc_html__('Twilio Console', 'tm-booking'); ?></a>
            </div>
        </div>
        
        <div class="form_item">
            <label><?php echo esc_html__('Twilio Phone Number', 'tm-booking'); ?></label>
            <input type="text" name="tm_booking_settings[twilio_phone_number]" value="<?php echo esc_attr(isset($booking_settings['twilio_phone_number']) ? $booking_settings['twilio_phone_number'] : ''); ?>" class="regular-text" />
            <div class="description">
                <?php echo esc_html__('Enter your Twilio phone number with country code (e.g., +12025551234).', 'tm-booking'); ?>
                <a href="https://www.twilio.com/console/phone-numbers/incoming" target="_blank"><?php echo esc_html__('Your Twilio Numbers', 'tm-booking'); ?></a>
            </div>
        </div>
    </div>
</div>

<div class="tm-booking-form-section">
    <h3><?php echo esc_html__('Notification Status', 'tm-booking'); ?></h3>
    <div class="description">
        <?php echo esc_html__('Current notification settings overview.', 'tm-booking'); ?>
    </div>

    <div class="tm-booking-help-text">
        <strong><?php echo esc_html__('Active Notifications:', 'tm-booking'); ?></strong><br>
        
        <strong><?php echo esc_html__('WhatsApp:', 'tm-booking'); ?></strong>
        <span class="<?php echo $whatsapp_enabled === 'yes' ? 'tm-booking-status-enabled' : 'tm-booking-status-disabled'; ?>">
            <?php echo $whatsapp_enabled === 'yes' ? esc_html__('Enabled', 'tm-booking') : esc_html__('Disabled', 'tm-booking'); ?>
        </span><br>
        
        <strong><?php echo esc_html__('Telegram:', 'tm-booking'); ?></strong>
        <span class="<?php echo $telegram_enabled === 'yes' ? 'tm-booking-status-enabled' : 'tm-booking-status-disabled'; ?>">
            <?php echo $telegram_enabled === 'yes' ? esc_html__('Enabled', 'tm-booking') : esc_html__('Disabled', 'tm-booking'); ?>
        </span><br>
        
        <strong><?php echo esc_html__('SMS:', 'tm-booking'); ?></strong>
        <span class="<?php echo $sms_enabled === 'yes' ? 'tm-booking-status-enabled' : 'tm-booking-status-disabled'; ?>">
            <?php echo $sms_enabled === 'yes' ? esc_html__('Enabled', 'tm-booking') : esc_html__('Disabled', 'tm-booking'); ?>
        </span>
    </div>
</div>
