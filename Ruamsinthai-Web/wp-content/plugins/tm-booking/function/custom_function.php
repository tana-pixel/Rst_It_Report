<?php
//Modal Form Button

/**
 * Return readable period label like ' / Day' for UI strings.
 *
 * @param string $key One of: hour, day, week, month
 * @return string Localized label with leading space and slash
 */
function tmbooking_format_period_label( $key ) {
    switch ( strtolower( $key ) ) {
        case 'hour':
            return ' ' . esc_html__( '/ Hour', 'tm-booking' );
        case 'day':
            return ' ' . esc_html__( '/ Day', 'tm-booking' );
        case 'week':
            return ' ' . esc_html__( '/ Week', 'tm-booking' );
        case 'month':
            return ' ' . esc_html__( '/ Month', 'tm-booking' );
        default:
            return ' / ' . esc_html( $key );
    }
}

function tmbooking_book_form($ID, $style){
    $tmbooking_result = '';

    $booking_settings = get_option('tm_booking_settings', true);

    // Get extras title from settings if available
    $extras_title = isset($booking_settings['extras_title']) ? $booking_settings['extras_title'] : '';
    $extra_html = tmbooking_get_extra_html($ID, $extras_title);
    $discount_html = tmbooking_get_discount_percent_html($ID);
    $location_html = tmbooking_get_locations_html($ID);
    $location_dr_html = tmbooking_get_dr_locations_html($ID);

    $disable_dates = get_post_meta($ID, '_tmbooking_data', true);



    $disable_dates_js = array();
    if(isset($disable_dates) && !empty($disable_dates)){
        foreach ($disable_dates as $d){
            $d = explode(" ", $d);
            $disable_dates_js[] = $d[0];
        }
        $disable_dates_js = json_encode($disable_dates_js);
    } else {
        $disable_dates_js = json_encode($disable_dates_js);
    }
    $hours = '';
    if(in_array('calc_hours', $booking_settings['calc_periods'])){
        // Проверяем настройку формата времени (Check time format setting)
        $time_format_24h = !isset($booking_settings['time_format']) || $booking_settings['time_format'] !== '12h';
        $hours = 'timePicker: true, timePicker24Hour: ' . ($time_format_24h ? 'true' : 'false') . ',';
    } else {
        $hours = 'timePicker: false, timePicker24Hour: false,';
    }

    $btn_disable_script = $permalink_levels = '';
    if(is_user_logged_in()){
        $user_id = get_current_user_ID();
        $tmreviews_dl_sended = get_user_meta($user_id, 'tmreviews_dl_sended', true);
        $user = get_user_by('ID', $user_id);
        $permalink_levels =  get_site_url() . '/members/' . $user->user_login . '/account_settings/';;
    }


    $btn_disable_script = '$(".book_now_btn").prop("disabled", false);';


    $disable_days = '';
    if(isset($booking_settings['disable_days']) && is_array($booking_settings['disable_days']) && !empty($booking_settings['disable_days'])){
        $b = 1;
        $days = '';

        foreach ($booking_settings['disable_days'] as $day){
            $days .= 'date.day() == ' . $day;
            if(count($booking_settings['disable_days']) != $b){
                $days .= '||';
            }
            $b++;
        }

        $disable_days .= 'isInvalidDate: function(date) {
                      return (' . $days . ');
                    },';
    }



    if(tmbooking_get_price_html($ID, $style) != ''){
        $tmbooking_result .= '<div class="rental-item__price">';
        $tmbooking_result .= '<div class="rental-item__price-btn">
                                       <form class="details-aside-content__inner booking_form booking_form' . $ID . '" data-id="' . $ID . '">
                                           <input type="hidden" class="hidden_id" name="id" value="'. $ID .'"/>
                                           <div class="details-aside-content__datapicker">
                                                <input type="text" id="tm_booking_date'. $ID .'" value="25/08/2022 - 16/09/2022" class="hasDatepicker tm_booking_date tm_booking_date'. $ID .'" placeholder="'.__("Select Dates", "tm-booking") . '">
                                                 
                                                <input type="hidden" name="start_date" class="start_date start_date'. $ID .'"/>
                                                <input type="hidden" name="end_date" class="end_date end_date'. $ID .'"/>
                                                
                                                <input type="hidden" name="start_time" class="start_time start_time'. $ID .'"/>
                                                <input type="hidden" name="end_time" class="end_time end_time'. $ID .'"/>
                                                
                                                <input type="hidden" name="number_days" class="diff'. $ID .'"/>
                                                
                                                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                    <path d="M19 4H5C3.89543 4 3 4.89543 3 6V20C3 21.1046 3.89543 22 5 22H19C20.1046 22 21 21.1046 21 20V6C21 4.89543 20.1046 4 19 4Z" stroke="white" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path>
                                                    <path d="M16 2V6" stroke="white" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path>
                                                    <path d="M8 2V6" stroke="white" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path>
                                                    <path d="M3 10H21" stroke="white" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path>
                                                </svg>
                                            </div>';

        $tmbooking_result .= '              <script>
                                                jQuery.noConflict()(function($) {
                                                      var templines_date_class = [];
                                                      templines_date_class = ' . $disable_dates_js . ';
                                                      $(".tm_booking_date'. $ID .'").daterangepicker(
                                                      {
                                                            drops: "' . $booking_settings["drops"] . '",  
                                                            showWeekNumbers: ' . $booking_settings["showWeekNumbers"] . ',
                                                            showISOWeekNumbers: ' . $booking_settings["showISOWeekNumbers"] . ',  
                                                            startDate: moment().startOf("hour"),
                                                            minDate: new Date(), 
                                                            isInvalidDate: function(ele) {
                                                                var currDate = moment(ele._d).format("'. $booking_settings["date_format"] . '");
                                                                return templines_date_class.indexOf(currDate) != -1;
                                                            },
                                                            
                                                            ' . $hours . '
                                                            '. $disable_days .' 
                                                            locale: { 
                                                                format:"'. $booking_settings["date_format"] . '",
                                                                "applyLabel": "' . __("Apply", "tm-booking") . '",
                                                                "cancelLabel": "' . __("Cancel", "tm-booking") . '",
                                                                "fromLabel": "' . __("From", "tm-booking") . '",
                                                                "toLabel": "' . __("To", "tm-booking") . '",
                                                                "customRangeLabel": "' . __("Custom", "tm-booking") . '",
                                                                "weekLabel": "' . __("W", "tm-booking") . '",
                                                                "daysOfWeek": [
                                                                    "' . __("Su", "tm-booking") . '",
                                                                    "' . __("Mo", "tm-booking") . '",
                                                                    "' . __("Tu", "tm-booking") . '",
                                                                    "' . __("We", "tm-booking") . '",
                                                                    "' . __("Th", "tm-booking") . '",
                                                                    "' . __("Fr", "tm-booking") . '",
                                                                    "' . __("Sa", "tm-booking") . '"
                                                                ],
                                                                "monthNames": [
                                                                    "' . __("January", "tm-booking") . '",
                                                                    "' . __("February", "tm-booking") . '",
                                                                    "' . __("March", "tm-booking") . '",
                                                                    "' . __("April", "tm-booking") . '",
                                                                    "' . __("May", "tm-booking") . '",
                                                                    "' . __("June", "tm-booking") . '",
                                                                    "' . __("July", "tm-booking") . '",
                                                                    "' . __("August", "tm-booking") . '",
                                                                    "' . __("September", "tm-booking") . '",
                                                                    "' . __("October", "tm-booking") . '",
                                                                    "' . __("November", "tm-booking") . '",
                                                                    "' . __("December", "tm-booking") . '"
                                                                ],
                                                            },

                                                      }, function(start, end, label) {
                                                      
                                                           $(".start_date'. $ID .'").val(start.format("' . $booking_settings["date_format"] . '"));
                                                           $(".end_date'. $ID .'").val(end.format("' . $booking_settings["date_format"] . '"));
                                                             
                                                           $(".start_time'. $ID .'").val(start.format("HH:mm"));
                                                           $(".end_time'. $ID .'").val(end.format("HH:mm"));
                                                             
                                                            var unindexed_array = jQuery(".booking_form'. $ID .'").serializeArray();
                                                            var indexed_array = {};
                                                            var extra_ids_val = "";
                                                           
                                                            $.map(unindexed_array, function(n, i){
                                                                indexed_array[n["name"]] = n["value"];
                                                                if(n["name"] === "extra[]"){
                                                                    extra_ids_val += n["value"] + ",";
                                                                } 
                                                                indexed_array["extra_ids"] = extra_ids_val.slice(0,-1);
                                                            });
                                                            formData = indexed_array;
                                                            var data = {
                                                                action: "tmbooking_change_total",
                                                                data: formData
                                                            };

                                                            $.post( tm_booking_ajax.url, data, function(response) {
                                                                console.log(response);
                                                                
                                                                ' . $btn_disable_script . '
                                                                 $(".tm_price_total'. $ID .'").html(response);
                                                            });
                                                      })
                                                });
                                             </script>';


        $tmbooking_result .= '              ' . $location_html . '
                                            
                                            ' . $location_dr_html . '
                                            
                                            ' . $extra_html .'
                                            
                                            <span class="tm_input_container tm_discount_input tm_discount_input'. $ID .'">
                                                 ' . $discount_html . '
                                            </span>
                                            
                                            <span class="booking_count booking_count'. $ID .'"></span>
                                            
                                            <div class="min-days-info-container">
' . apply_filters('tmbooking_before_book_now_button', '', $ID) . '
</div>

<div class="details-aside-content__total tm_input_container tm_price_total tm_price_total'. $ID .'"></div>
                                            <button class="book_now_btn details-aside-content__button" disabled="disabled" onclick="return false;" data-wait="' . __('Please wait', 'tm-booking') . '">
                                            <span>' . tmbooking_get_book_now_text($ID) . '</span>
                                            <span>
                                                <svg width="18" height="18" viewBox="0 0 18 18" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                    <path d="M3.75 9H14.25" stroke="white" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path>
                                                    <path d="M9 3.75L14.25 9L9 14.25" stroke="white" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path>
                                                </svg>
                                            </span>
                                            </button>
                                        </form>
                                </div>';
        $tmbooking_result .= '</div>';
    }


    return $tmbooking_result;
}

//Get Price
function tmbooking_get_price($ID){
    $price['perhour'] = tmbooking_get_metabox( 'price_section_price_perhour', $ID );
    $price['perday'] = tmbooking_get_metabox( 'price_section_price_perday', $ID );
    $price['perweek'] = tmbooking_get_metabox( 'price_section_price_perweek', $ID );
    $price['permonth'] = tmbooking_get_metabox( 'price_section_price_permonth', $ID );
    return $price;
}

//Get Price Html
function tmbooking_get_price_html($ID, $style){
    // Получаем кастомный текст цены, если он задан (Get custom price text if set)
    $custom_price_text = '';
    if (function_exists('tmbooking_get_custom_price_text')) {
        $custom_price_text = tmbooking_get_custom_price_text($ID);
    }

    $show_calculate_price = tmbooking_get_metabox( 'price_section_show_calculate_price', $ID );
    $price = tmbooking_get_metabox( 'price_section_price_per'.$show_calculate_price, $ID );
    $per_html =  '<span class="show_calculate_price">' . __(' per/', 'tm-booking') . $show_calculate_price . '</span>';
    $booking_settings = get_option('tm_booking_settings', true);

    $discount_percent = tmbooking_get_discount_percent_all($ID);
    $discount_price = tmbooking_change_price_by_discount($price, $discount_percent);
    $currency_pos = get_option( 'woocommerce_currency_pos' );
    if(class_exists('WooCommerce')){
        $currency_symbol_html = '<span class="tm_booking_currency_symbol ' . $currency_pos . '">' . get_woocommerce_currency_symbol() . '</span>';
    }

    $price_html = '';
    if($style == 'style_one'){
        $per = '';
        switch ($show_calculate_price) {
            case 'day':
                $per =  __("/Day", "tm-booking");
                break;
            case 'hour':
                $per =  __("/Hour", "tm-booking");
                break;
            case 'week':
                $per =  __("/Week", "tm-booking");
                break;
            case 'month':
                $per =  __("/Month", "tm-booking");
                break;
        }
        $price_html .= '<div class="equipment-order__price">';
        $price_html .= '<span class="current-price">';
        if(isset($discount_percent) && $discount_percent != 0){
            if(class_exists('WooCommerce')){
                $price_html .= tmbooking_get_price_with_currency($discount_price) . $per;
            } else {
                $price_html .= $discount_price . $per;
            }
        } else {
            if(class_exists('WooCommerce')){
                $price_html .=  tmbooking_get_price_with_currency($price) . $per;
            } else {
                $price_html .= $price . $per;
            }
        }
        $price_html .= '</span>';
        if(isset($discount_percent) && $discount_percent != 0){
            $price_html .= '<span class="old-price">';
            if(class_exists('WooCommerce')){
                $price_html .=  tmbooking_get_price_with_currency($price) . $per;
            } else {
                $price_html .= $price . $per;
            }
            $price_html .= '</span>';
        }
        $price_html .= '</div>';
        return $price_html;
    } elseif($style == 'style_two') {
        if ($price != ''){
            $price_html .= '<div class="equipment-item__price-box">';

            $price_html .= ' <div class="equipment-item__price-title">' . __("Total Rental Price", "tm-booking") . '<small>' . __("(Incl. Taxes)", "tm-booking") . '</small></div>';

            $price_html .= '<div class="equipment-item__price">';
            $price_html .= '<div class="equipment-item__price-current">';
            if(isset($discount_percent) && $discount_percent != 0){
                if(class_exists('WooCommerce')){
                    $price_html .= tmbooking_get_price_with_currency($discount_price);
                } else {
                    $price_html .= $discount_price . $per_html;
                }
            } else {
                if(class_exists('WooCommerce')){
                    $price_html .= tmbooking_get_price_with_currency($price);
                } else {
                    $price_html .= $price;
                }
            }

            if(isset($discount_percent) && $discount_percent != 0){
                $price_html .= '<div class="equipment-item__price-old">';
                if(class_exists('WooCommerce')){
                    $price_html .= tmbooking_get_price_with_currency($price);
                } else {
                    $price_html .= $price;
                }
                $price_html .= '</div>';
            }

            $price_html .= '</div>';
            $price_html .= '</div>';


            $price_html .= '</div>';
            $price_html .= '<div class="equipment-item__prices">
                                <ul>';

            if(in_array('calc_days', $booking_settings['calc_periods'])){
                $price_day = tmbooking_get_metabox( 'price_section_price_perday', $ID );
            }
            if(in_array('calc_weeks', $booking_settings['calc_periods'])){
                $price_week = tmbooking_get_metabox( 'price_section_price_perweek', $ID );
            }
            if(in_array('calc_month', $booking_settings['calc_periods'])){
                $price_month = tmbooking_get_metabox( 'price_section_price_permonth', $ID );
            }

            if(tmbooking_get_metabox( 'price_section_price_perday', $ID) != '' && isset($price_day) && $price_day != ''){
                $price_html .= '<li>' . tmbooking_get_price_with_currency($price_day) . __(" / Day", "tm-booking") . '</li>';
            }
            if(tmbooking_get_metabox( 'price_section_price_perweek', $ID ) != '' && isset($price_week) && $price_week != ''){
                $price_html .= '<li>' . tmbooking_get_price_with_currency($price_week) . __(" / Week", "tm-booking"). '</li>';
            }
            if(tmbooking_get_metabox( 'price_section_price_permonth', $ID ) != '' && isset($price_month) && $price_month != ''){
                $price_html .= '<li>' . tmbooking_get_price_with_currency($price_month) . __(" / Month", "tm-booking"). '</li>';
            }

            $price_html .= '  </ul>
                            </div>';

            return $price_html;
        }

    } elseif($style == 'style_three') {

        if ($price != ''){
            $price_html .= '<div class="rental-item__price-box">';
            $price_html .= '<div class="rental-item__price-current">';

            if(isset($discount_percent) && $discount_percent != 0){
                if(class_exists('WooCommerce')){
                    $price_html .= tmbooking_get_price_with_currency($discount_price);
                } else {
                    $price_html .= $discount_price;
                }
            } else {
                if(class_exists('WooCommerce')){
                    $price_html .= tmbooking_get_price_with_currency($price);
                } else {
                    $price_html .= $price;
                }
            }

            if(isset($discount_percent) && $discount_percent != 0){
                $price_html .= '<div class="rental-item__price-old">';
                if(class_exists('WooCommerce')){
                    $price_html .= tmbooking_get_price_with_currency($price);
                } else {
                    $price_html .= $price;
                }
                $price_html .= '</div>';
            }

            $price_html .= '</div>';
            $price_html .= '</div>';
            return $price_html;
        }

    } elseif ($style == 'style_four') {
        $price_html .= '<div class="offer-price">';
        $price_html .= __('Starts', 'tm-booking');
        $price_show =  $price . ' /' . $show_calculate_price;
        $price_html .= '<span>';
        if(class_exists('WooCommerce')){
            $price_html .=  tmbooking_get_price_with_currency($price);
        } else {
            $price_html .= $price_show;
        }
        $price_html .= '</span>';
        $price_html .= '</div>';
        return $price_html;
    }elseif($style == 'style_five') {
        $price_html .= '<div class="car-price top-info fl-primary-bg">';
        $price_html .= '<div class="price-detail fl-font-style-bolt">';
        $price_html .= '<div class="equipment-order__price">';
        $price_html .= '<span class="current-price">';

        $price_show =  '<span class="prc currency_left">'. $price . ' / ' . esc_html( $show_calculate_price ) . '</span>';
        if(class_exists('WooCommerce')){
            $price_html .=  tmbooking_get_price_with_currency($price) . tmbooking_format_period_label($show_calculate_price);
        } else {
            $price_html .= $price_show;
        }

        $price_html .= '</span>';
        $price_html .= '</div>';
        $price_html .= '</div>';
        $price_html .= '</div>';
        return $price_html;
    } elseif($style == 'style_six') {
        if(isset($price) && $price != ''){
            $price_html .= '<span class="b-goods-f__price-group"><span class="b-goods-f__price"><span class="b-goods-f__price-numb">';
            $price_show =  '<span class="prc currency_left">'. $price . ' / ' . esc_html( $show_calculate_price ) . '</span>';
            if(class_exists('WooCommerce')){
                $price_html .=  tmbooking_get_price_with_currency($price) . tmbooking_format_period_label($show_calculate_price);
            } else {
                $price_html .= $price_show;
            }

            $price_html .= '</span></span></span>';
        }

        return $price_html;
    } elseif($style == 'style_all') {
        $price_html .= '<div class="equipment-item__prices">
                                <ul>';
        if(in_array('calc_days', $booking_settings['calc_periods'])){
            $price_day = tmbooking_get_metabox( 'price_section_price_perday', $ID );
        }
        if(in_array('calc_weeks', $booking_settings['calc_periods'])){
            $price_week = tmbooking_get_metabox( 'price_section_price_perweek', $ID );
        }
        if(in_array('calc_month', $booking_settings['calc_periods'])) {
            $price_month = tmbooking_get_metabox( 'price_section_price_permonth', $ID );
        }

        if(tmbooking_get_metabox( 'price_section_price_perday', $ID ) != '' && isset($price_day) && $price_day != ''){
            $price_html .= '<li>' . tmbooking_get_price_with_currency($price_day) . __(" / Day", "tm-booking") . '</li>';
        }
        if(tmbooking_get_metabox( 'price_section_price_perweek', $ID ) != '' && isset($price_week) && $price_week != ''){
            $price_html .= '<li>' . tmbooking_get_price_with_currency($price_week) . __(" / Week", "tm-booking"). '</li>';
        }
        if(tmbooking_get_metabox( 'price_section_price_permonth', $ID ) != '' && isset($price_month) && $price_month != ''){
            $price_html .= '<li>' . tmbooking_get_price_with_currency($price_month) . __(" / Month", "tm-booking"). '</li>';
        }
        $price_html .= '  </ul>
                            </div>';
        return $price_html;
        $price_html .= '<ul class="car_premium_price' . (function_exists("tmbooking_get_price_list_visibility_class") ? " " . tmbooking_get_price_list_visibility_class($ID) : "") . '">';;
        $price_html .= '<ul class="car_premium_price' . (function_exists("tmbooking_get_price_list_visibility_class") ? " " . tmbooking_get_price_list_visibility_class($ID) : "") . '">';;
        if (in_array('calc_days', $booking_settings['calc_periods'])) {
            $price_day = tmbooking_get_metabox('price_section_price_perday', $ID);
        }
        if (in_array('calc_weeks', $booking_settings['calc_periods'])) {
            $price_week = tmbooking_get_metabox('price_section_price_perweek', $ID);
        }
        if (in_array('calc_month', $booking_settings['calc_periods'])) {
            $price_month = tmbooking_get_metabox('price_section_price_permonth', $ID);
        }
        if (tmbooking_get_metabox('price_section_price_perday', $ID) != '' && isset($price_day) && $price_day != '') {
            $price_html .= '<li class="list-grid-item fl-font-style-regular ">' . tmbooking_get_price_with_currency($price_day) . __(" / Day",
                    "tm-booking") . '</li>';
        }
        if (tmbooking_get_metabox('price_section_price_perweek', $ID) != '' && isset($price_week) && $price_week != '') {
            $price_html .= '<li class="list-grid-item fl-font-style-regular ">' . tmbooking_get_price_with_currency($price_week) . __(" / Week",
                    "tm-booking") . '</li>';
        }
        if (tmbooking_get_metabox('price_section_price_permonth', $ID) != '' && isset($price_month) && $price_month != '') {
            $price_html .= '<li class="list-grid-item fl-font-style-regular ">' . tmbooking_get_price_with_currency($price_month) . __(" / Month",
                    "tm-booking") . '</li>';
        }
        $price_html .= '</ul>';
        return $price_html;
    } elseif($style == 'style_all_three') {
        if (in_array('calc_days', $booking_settings['calc_periods'])) {
            $price_day = tmbooking_get_metabox('price_section_price_perday', $ID);
        }
        if (in_array('calc_weeks', $booking_settings['calc_periods'])) {
            $price_week = tmbooking_get_metabox('price_section_price_perweek', $ID);
        }
        if (in_array('calc_month', $booking_settings['calc_periods'])) {
            $price_month = tmbooking_get_metabox('price_section_price_permonth', $ID);
        }

        $price_html .= '<div class="catalog-list-content-item-body-top__box catalog-list-content-item-body-top-box">';
        if (tmbooking_get_metabox('price_section_price_perday', $ID) != '' && isset($price_day) && $price_day != '') {
            $price_html .= '<div class="catalog-list-content-item-body-top-box__inner">
                        <div class="catalog-list-content-item-body-top-box__text">' . __("Rent Per Day", "tm-reviews") . '</div>
                        <div class="catalog-list-content-item-body-top-box__price">'.tmbooking_get_price_with_currency($price_day).'</div>' .
                '</div>';
        }
        if (tmbooking_get_metabox('price_section_price_perweek', $ID) != '' && isset($price_week) && $price_week != '') {
            $price_html .= '<div class="catalog-list-content-item-body-top-box__inner">
                        <div class="catalog-list-content-item-body-top-box__text">' . __("Rent Per Week", "tm-reviews") . '</div>
                        <div class="catalog-list-content-item-body-top-box__price">'.tmbooking_get_price_with_currency($price_week).'</div>' .
                '</div>';
        }
        if (tmbooking_get_metabox('price_section_price_permonth', $ID) != '' && isset($price_month) && $price_month != '') {
            $price_html .= '<div class="catalog-list-content-item-body-top-box__inner">
                        <div class="catalog-list-content-item-body-top-box__text">' . __("Rent Per Month", "tm-reviews") . '</div>
                        <div class="catalog-list-content-item-body-top-box__price">'.tmbooking_get_price_with_currency($price_month).'</div>' .
                '</div>';
        }
        $price_html .= '</div>';

        return $price_html;

    } elseif($style == 'style_seven') {

        if(isset($price) && $price != ''){
            $price_html .= '<p class="catalog-list-content-item-info__box-text">' . __("total rental price Inc. Tax", "tm-reviews") . '</p>';
            $price_html .=  '<div class="catalog-list-content-item-info__box-price">';
            if(class_exists('WooCommerce')){
                $price_html .=  tmbooking_get_price_with_currency($price) . tmbooking_format_period_label($show_calculate_price);
            }
            $price_html .= '</div>';
        }

        return $price_html;
    } elseif($style == 'style_eight') {

        if(isset($price) && $price != ''){
            $price_html .= '<p class="catalog-grid-item-content__row-text">' . __("total rental price Inc. Tax", "tm-reviews") . '</p>';
            $price_html .=  '<p class="catalog-grid-item-content__row-price">';
            if(class_exists('WooCommerce')){
                $price_html .=  tmbooking_get_price_with_currency($price) . '/' . $show_calculate_price;
            }
            $price_html .= '</p>';
        }

        return $price_html;
    } elseif($style == 'style_all_four') {
        if (in_array('calc_days', $booking_settings['calc_periods'])) {
            $price_day = tmbooking_get_metabox('price_section_price_perday', $ID);
        }
        if (in_array('calc_weeks', $booking_settings['calc_periods'])) {
            $price_week = tmbooking_get_metabox('price_section_price_perweek', $ID);
        }
        if (in_array('calc_month', $booking_settings['calc_periods'])) {
            $price_month = tmbooking_get_metabox('price_section_price_permonth', $ID);
        }

        $price_html .= '<ul class="catalog-grid-item__rent catalog-grid-item-rent catalog-grid-item-rent--row">';
        if (tmbooking_get_metabox('price_section_price_perday', $ID) != '' && isset($price_day) && $price_day != '') {
            $price_html .= '<li class="catalog-grid-item-rent__item">
                        <p class="catalog-grid-item-rent__text">' . tmbooking_get_price_with_currency($price_day) . __("/Day", "tm-reviews") . '</p>' .
                '</li>';
        }
        if (tmbooking_get_metabox('price_section_price_perweek', $ID) != '' && isset($price_week) && $price_week != '') {
            $price_html .= '<li class="catalog-grid-item-rent__item">
                        <p class="catalog-grid-item-rent__text">' . tmbooking_get_price_with_currency($price_week) . __("/Week", "tm-reviews") . '</p>' .
                '</li>';
        }
        if (tmbooking_get_metabox('price_section_price_permonth', $ID) != '' && isset($price_month) && $price_month != '') {
            $price_html .= '<li class="catalog-grid-item-rent__item">
                        <p class="catalog-grid-item-rent__text">' . tmbooking_get_price_with_currency($price_month) . __("/Month", "tm-reviews") . '</p>' .
                '</li>';
        }
        $price_html .= '</ul>';

        return $price_html;
    } elseif ($style == 'style_nine') {
        if (in_array('calc_hours', $booking_settings['calc_periods'])) {
            if(tmbooking_get_metabox('price_section_show_calculate_price', $ID) == 'hour') {
                $price = tmbooking_get_metabox('price_section_price_perhour', $ID);
            }
        }
        if (in_array('calc_days', $booking_settings['calc_periods'])) {
            if(tmbooking_get_metabox('price_section_show_calculate_price', $ID) == 'day'){
                $price = tmbooking_get_metabox('price_section_price_perday', $ID);
            }
        }
        if (in_array('calc_weeks', $booking_settings['calc_periods'])) {
            if(tmbooking_get_metabox('price_section_show_calculate_price', $ID) == 'week') {
                $price = tmbooking_get_metabox('price_section_price_perweek', $ID);
            }
        }
        if (in_array('calc_month', $booking_settings['calc_periods'])) {
            if(tmbooking_get_metabox('price_section_show_calculate_price', $ID) == 'month') {
                $price = tmbooking_get_metabox('price_section_price_permonth', $ID);
            }
        }
        if(isset($price) && $price != ''){
            $price_html = '<p class="details-aside-content-top__price">
                            ' . __("Tool Current Price", "tm-booking") . '
                            <span>
                                ' . tmbooking_get_price_with_currency($price) . '
                            </span>
                        </p>';
        }

        return $price_html;
    } elseif ($style == 'style_all_five') {

        if (in_array('calc_days', $booking_settings['calc_periods'])) {
            $price_day = tmbooking_get_metabox('price_section_price_perday', $ID);
        }
        if (in_array('calc_weeks', $booking_settings['calc_periods'])) {
            $price_week = tmbooking_get_metabox('price_section_price_perweek', $ID);
        }
        if (in_array('calc_month', $booking_settings['calc_periods'])) {
            $price_month = tmbooking_get_metabox('price_section_price_permonth', $ID);
        }

        if (tmbooking_get_metabox('price_section_price_perday', $ID) != '' && isset($price_day) && $price_day != '') {
            $price_html .= '<p class="details-aside-content-top__rent-text">' . tmbooking_get_price_with_currency($price_day) . __("/Day", "tm-reviews") . '</p>';
        }
        if (tmbooking_get_metabox('price_section_price_perweek', $ID) != '' && isset($price_week) && $price_week != '') {
            $price_html .= '<p class="details-aside-content-top__rent-text">' . tmbooking_get_price_with_currency($price_week) . __("/Week", "tm-reviews") . '</p>';
        }
        if (tmbooking_get_metabox('price_section_price_permonth', $ID) != '' && isset($price_month) && $price_month != '') {
            $price_html .= '<p class="details-aside-content-top__rent-text">' . tmbooking_get_price_with_currency($price_month) . __("/Month", "tm-reviews") . '</p>';
        }


        return $price_html;
    } elseif($style == 'style_revus') {
        $price_html .= '<ul class="car_premium_price' . (function_exists("tmbooking_get_price_list_visibility_class") ? " " . tmbooking_get_price_list_visibility_class($ID) : "") . '">';;
        if(in_array('calc_hours', $booking_settings['calc_periods'])){
            $price_hour = tmbooking_get_metabox( 'price_section_price_perhour', $ID );
        }
        if(in_array('calc_days', $booking_settings['calc_periods'])){
            $price_day = tmbooking_get_metabox( 'price_section_price_perday', $ID );
        }
        if(in_array('calc_week', $booking_settings['calc_periods'])){
            $price_week = tmbooking_get_metabox( 'price_section_price_perweek', $ID );
        }
        if(in_array('calc_month', $booking_settings['calc_periods'])){
            $price_month = tmbooking_get_metabox( 'price_section_price_permonth', $ID );
        }
        if(tmbooking_get_metabox( 'price_section_price_perhour', $ID) != '' && isset($price_hour) && $price_hour != ''){
            $price_html .= '<li class="list-grid-item fl-font-style-regular '.esc_attr($show_calculate_price == 'hour' ? 'list-grid-item-show-price' : '').'">' . tmbooking_get_price_with_currency($price_hour) . __(" / Hour", "tm-booking") . '</li>';
        }
        if(tmbooking_get_metabox( 'price_section_price_perday', $ID) != '' && isset($price_day) && $price_day != ''){
            $price_html .= '<li class="list-grid-item fl-font-style-regular '.esc_attr($show_calculate_price == 'day' ? 'list-grid-item-show-price' : '').'">' . tmbooking_get_price_with_currency($price_day) . __(" / Day", "tm-booking") . '</li>';
        }
        if(tmbooking_get_metabox( 'price_section_price_perweek', $ID ) != '' && isset($price_week) && $price_week != ''){
            $price_html .= '<li class="list-grid-item fl-font-style-regular '.esc_attr($show_calculate_price == 'week' ? 'list-grid-item-show-price' : '').'">' . tmbooking_get_price_with_currency($price_week) . __(" / Week", "tm-booking"). '</li>';
        }
        if(tmbooking_get_metabox( 'price_section_price_permonth', $ID ) != '' && isset($price_month) && $price_month != ''){
            $price_html .= '<li class="list-grid-item fl-font-style-regular '.esc_attr($show_calculate_price == 'month' ? 'list-grid-item-show-price' : '').'">' . tmbooking_get_price_with_currency($price_month) . __(" / Month", "tm-booking"). '</li>';
        }
        $price_html .= '</ul>';
        return $price_html;
    } elseif($style == 'style_tostate_list') {

        if (isset($price) && $price != '') {
            $price_html .= '<div class="info-price-content">';
                                $price_html .= '<div class="price-item-content templines-font-style-h">';
            if (class_exists('WooCommerce')) {
                $price_html .= '<span class="price-item">'.tmbooking_get_price_with_currency($price) . '</span>' . '<span class="rental-time templines-font-style-normal">' . tmbooking_format_period_label($show_calculate_price) . '</span>';
            }
            $price_html .= '</div>
                            </div>';

        }

        return $price_html;
    } elseif($style == 'style_tostate_grid') {
        if (isset($price) && $price != '') {
            $price_html .= '<div class="price-item-content templines-font-style-h">';
                if (class_exists('WooCommerce')) {
                    $price_html .= '<span class="price-item">'.tmbooking_get_price_with_currency($price) . '</span>' . '<span class="rental-time templines-font-style-normal">' . tmbooking_format_period_label($show_calculate_price) . '</span>';
                }
            $price_html .= '</div>';
        }

        return $price_html;
    }
}


function tmbooking_check_price($ID){
    $show_calculate_price = tmbooking_get_metabox( 'price_section_show_calculate_price', $ID );
    $price = tmbooking_get_metabox( 'price_section_price_per'.$show_calculate_price, $ID );

    if(isset($price) && $price != null && $price != ''){
        return true;
    }
    return false;
}

/**
 * Get applicable discount percent based on booking days
 *
 * @param int $ID Post ID
 * @param int $booking_days Number of days in booking (optional)
 * @return int Discount percent
 */
function tmbooking_get_discount_percent_all($ID, $booking_days = 0){
    $discount = get_the_terms($ID, 'transports-discount');
    $discount_percent = 0;
    $selected_discount_day = -1;
    
    // Если дни бронирования не переданы, пытаемся получить из формы
    if ($booking_days == 0 && isset($_POST['number_days'])) {
        $booking_days = intval($_POST['number_days']);
    }
    
    if (!empty($discount)){
        foreach ($discount as $d){
            $tax_percent = tmbooking_get_term_metabox('discount_percent', $d->term_id);
            $start_day = tmbooking_get_term_metabox('start_day', $d->term_id);
            
            // Если start_day не задан, считаем его равным 0 (скидка применяется с первого дня)
            if (empty($start_day)) {
                $start_day = 0;
            } else {
                $start_day = intval($start_day);
            }
            
            // Проверяем, подходит ли скидка по количеству дней бронирования
            if (!empty($tax_percent) && $booking_days >= $start_day) {
                // Выбираем скидку с наибольшим start_day (последнюю по дню)
                if ($start_day > $selected_discount_day) {
                    $discount_percent = intval($tax_percent);
                    $selected_discount_day = $start_day;
                }
            }
        }
    }
    
    return $discount_percent;
}

/**
 * Get HTML representation of applicable discount based on booking days
 *
 * @param int $ID Post ID
 * @param int $booking_days Number of days in booking (optional)
 * @return string HTML for discount display
 */
function tmbooking_get_discount_percent_html($ID, $booking_days = 0) {
    $discount = get_the_terms($ID, 'transports-discount');
    $discount_html = '';
    $discounts = '';
    
    // Если дни бронирования не переданы, пытаемся получить из формы
    if ($booking_days == 0 && isset($_POST['number_days'])) {
        $booking_days = intval($_POST['number_days']);
    }
    
    if (!empty($discount)){
        // Находим подходящую скидку по дню начала
        $selected_discount_term = null;
        $selected_discount_day = -1;
        
        foreach ($discount as $d){
            $discount_percent = tmbooking_get_term_metabox('discount_percent', $d->term_id);
            $start_day = tmbooking_get_term_metabox('start_day', $d->term_id);
            
            // Если start_day не задан, считаем его равным 0 (скидка применяется с первого дня)
            if (empty($start_day)) {
                $start_day = 0;
            } else {
                $start_day = intval($start_day);
            }
            
            // Проверяем, подходит ли скидка по количеству дней бронирования
            if (!empty($discount_percent) && $booking_days >= $start_day) {
                // Выбираем скидку с наибольшим start_day (последнюю по дню)
                if ($start_day > $selected_discount_day) {
                    $selected_discount_term = $d;
                    $selected_discount_day = $start_day;
                }
            }
        }
        
        // Отображаем выбранную скидку
        if ($selected_discount_term) {
            $discounts = $selected_discount_term->term_id;
            $discount_percent = tmbooking_get_term_metabox('discount_percent', $selected_discount_term->term_id);
            $start_day = tmbooking_get_term_metabox('start_day', $selected_discount_term->term_id);
            
            // Создаем блок с информацией о скидке для вывода в специальный блок
            $discount_html .= '<section class="tm-booking-price-discount">';
            $discount_html .= '<div class="discount-info-block" style="margin: 10px 0; padding: 12px; background-color: #f8f8f8; border-left: 3px solid #e44; border-radius: 3px; box-shadow: 0 1px 3px rgba(0,0,0,0.1);">';
            $discount_html .= '<script>console.log("Discount block created in custom_function.php"); alert("Discount block ID: custom_function.php");</script>';
            $discount_html .= '<div class="discount-title" style="font-weight: bold; color: #e44; margin-bottom: 8px; font-size: 16px;">' . esc_html__('Скидка', 'tm-booking') . ': ' . $discount_percent . '%</div>';
            
            $discount_html .= '<div class="discount-name" style="margin-bottom: 8px; font-size: 14px;">' . $selected_discount_term->name;
            
            // Добавляем информацию о дне начала скидки, если он не равен 0
            if (!empty($start_day) && intval($start_day) > 0) {
                $discount_html .= ' (' . esc_html__('from day', 'tm-booking') . ' ' . $start_day . ')';
            }
            
            $discount_html .= '</div>';
            
            // Добавляем информацию о сумме экономии
            // Получаем базовую цену
            $price = tmbooking_get_price($ID);
            if (isset($price['perday'])) {
                $base_price = $price['perday'] * $booking_days;
                $discounted_price = $base_price * (100 - $discount_percent) / 100;
                $savings = $base_price - $discounted_price;
                
                $discount_html .= '<div class="discount-savings" style="font-weight: bold; font-size: 15px; color: #333;">' . esc_html__('Вы экономите', 'tm-booking') . ': ' . round($savings, 2) . get_woocommerce_currency_symbol() . '</div>';
            }
            
            $discount_html .= '</div>';
            $discount_html .= '</section>';
            
            // Добавляем скрытое поле с ID скидки
            $discount_html .= '<input type="hidden" name="discount" value="' . $discounts . '"/>';
        }
    }
    
    return $discount_html;
}

//Get Location html
function tmbooking_get_locations_html($ID){
    $locations = get_the_terms($ID, 'transports-locations');
    $locations_html = '';
    $is_empty = empty($locations) || is_wp_error($locations);
    if (!empty($locations)){
        $locations_html .= '<div class="details-aside-content__adress">
                                <p class="details-aside-content__adress-text">
                                   ' . __("where:", "tm-booking") . '
                                </p>
                            <select class="tmnice-select" name="location">';
        $locations_html .= '<option value="0">' . __('Pick up Location', 'tm-booking') . '</option>';
        foreach ($locations as $l){
            $locations_html .= '<option value="' . $l->slug .'">';
            $locations_html .=  $l->name;
            $locations_html .= '</option>';
        }
        $locations_html .= '</select>';

        $locationss = get_the_terms($ID, 'transports-dr-locations');
        if (!empty($locationss)){
            $locations_html .= '
                            <select class="js-select tmnice-select" name="location">';
            $locations_html .= '<option value="0">' . __('Drop off Location', 'tm-booking') . '</option>';
            foreach ($locationss as $l){
                $locations_html .= '<option value="' . $l->slug .'">';
                $locations_html .=  $l->name;
                $locations_html .= '</option>';
            }
            $locations_html .= '</select>';
        }
        $locations_html .= '</div>';
    }
    return $locations_html;
}
function tmbooking_get_locations_html_short($ID, $style){
    $locations = get_the_terms($ID, 'transports-locations');

    $locations_html = '';
    if (!empty($locations)){

        if(isset($style) && $style === 'style_one') {
            $locations_html .= '<select class="tm-js-select" name="location">';
            $locations_html .= '<option value="0">' . __('Pick up Location', 'tm-booking') . '</option>';
            foreach ($locations as $l) {
                $locations_html .= '<option value="' . $l->slug . '">';
                $locations_html .= $l->name;
                $locations_html .= '</option>';
            }
            $locations_html .= '</select>';
        }elseif(isset($style) && $style === 'style_two') {
            $locations_html .= '<select class="tm-js-select" name="location">';
                $locations_html .= '<option value="0">' . __('Pick up Location', 'tm-booking') . '</option>';
                foreach ($locations as $l){
                    $locations_html .= '<option value="' . $l->slug .'">';
                    $locations_html .=  $l->name;
                    $locations_html .= '</option>';
                }
                $locations_html .= '</select>';
        }elseif(isset($style) && $style === 'style_three') {
            $locations_html .= '<select name="location">';
            $locations_html .= '<option value="0">' . __('Pick up Location', 'tm-booking') . '</option>';
            foreach ($locations as $l){
                $locations_html .= '<option value="' . $l->slug .'">';
                $locations_html .=  $l->name;
                $locations_html .= '</option>';
            }
            $locations_html .= '</select>';
        }elseif(isset($style) && $style === 'style_four') {
            $locations_html .= '<div class="details-aside-content__adress">
                            <p class="details-aside-content__adress-text">
                               ' . __("where:", "tm-booking") . '
                            </p>
                        <select class="js-select  tm-js-select" name="location">';
            $locations_html .= '<option value="0">' . __('Pick up Location', 'tm-booking') . '</option>';
            foreach ($locations as $l){
                $locations_html .= '<option value="' . $l->slug .'">';
                $locations_html .=  $l->name;
                $locations_html .= '</option>';
            }
            $locations_html .= '</select>';

            $locationss = get_the_terms($ID, 'transports-dr-locations');
            if (!empty($locationss)){
                $locations_html .= '
                        <select class="js-select  tm-js-select" name="dr_location">';
                $locations_html .= '<option value="0">' . __('Drop off Location', 'tm-booking') . '</option>';
                foreach ($locationss as $l){
                    $locations_html .= '<option value="' . $l->slug .'">';
                    $locations_html .=  $l->name;
                    $locations_html .= '</option>';
                }
                $locations_html .= '</select>';
            }
            $locations_html .= '</div>';
        } elseif(isset($style) && $style === 'style_five') {

            $locations_html .= '<div class="details-aside-content__adress">
                                <p class="details-aside-content__adress-text">
                                   ' . __("where:", "tm-booking") . '
                                </p>
                            <select class="tm-js-select" name="location">';
            $locations_html .= '<option value="0">' . __('Pick up Location', 'tm-booking') . '</option>';
            foreach ($locations as $l){
                $locations_html .= '<option value="' . $l->slug .'">';
                $locations_html .=  $l->name;
                $locations_html .= '</option>';
            }
            $locations_html .= '</select>';

            $locationss = get_the_terms($ID, 'transports-dr-locations');
            if (!empty($locationss)){
                $locations_html .= '
                            <select class="tm-js-select" name="location">';
                $locations_html .= '<option value="0">' . __('Drop off Location', 'tm-booking') . '</option>';
                foreach ($locationss as $l){
                    $locations_html .= '<option value="' . $l->slug .'">';
                    $locations_html .=  $l->name;
                    $locations_html .= '</option>';
                }
                $locations_html .= '</select>';
            }

            $locations_html .= '</div>';

        } else {
            $locations_html .= '<div class="details-aside-content__adress">
                                <p class="details-aside-content__adress-text">
                                   ' . __("where:", "tm-booking") . '
                                </p>
                            <select class="js-select " name="location">';
            $locations_html .= '<option value="0">' . __('Pick up Location', 'tm-booking') . '</option>';
            foreach ($locations as $l) {
                $locations_html .= '<option value="' . $l->slug . '">';
                $locations_html .= $l->name;
                $locations_html .= '</option>';
            }
            $locations_html .= '</select>';

            $locationss = get_the_terms($ID, 'transports-dr-locations');
            if (!empty($locationss)) {
                $locations_html .= '
                            <select class="js-select " name="location">';
                $locations_html .= '<option value="0">' . __('Drop off Location', 'tm-booking') . '</option>';
                foreach ($locationss as $l) {
                    $locations_html .= '<option value="' . $l->slug . '">';
                    $locations_html .= $l->name;
                    $locations_html .= '</option>';
                }
                $locations_html .= '</select>';
            }
            $locations_html .= '</div>';
        }


    }
    return $locations_html;
}
function tmbooking_get_dr_locations_html($ID){
    $locations = get_the_terms($ID, 'transports-delivery');
    $locations_html = '';
    if (!empty($locations)){
        $locations_html = '<div class="details-aside-content__radios details-aside-content-radios">';
        foreach ($locations as $l){
            $free = tmbooking_get_metabox('free', $l);
            if(isset($free) && $free == 'free') {
                $locations_html .= '<div class="details-aside-content-radios__row tm_free_radio_order"><label class="container">';
                $locations_html .=  $l->name;
                $locations_html .= '<input type="radio" checked="checked" name="dr_location" value="' . $l->slug .'">
                                    <span class="checkmark"></span>';
                $locations_html .= '</label>';

                $locations_html .= '<p class="details-aside-content-radios__row-text">
                                    ' . __("Free", "tm-booking") . '
                                </p></div>';
            }

            if(isset($free) && $free == 'price'){
                $drop_price = tmbooking_get_metabox('drop_price', $l);
                $locations_html .= '<div class="details-aside-content-radios__row"><label class="container">';
                $locations_html .=  $l->name;
                $locations_html .= '<input type="radio" checked="checked" name="dr_location" value="' . $l->slug .'">
                                        <span class="checkmark"></span>';
                $locations_html .= '</label>';
                if(class_exists('WooCommerce')){
                    //$extra_price_html .= $currency_symbol_html . '<span class="prc">' . $extra_price . '</span>';
                    $drop_price = tmbooking_get_price_with_currency($drop_price);
                } else {
                    $drop_price = tmbooking_get_price_with_currency($drop_price);
                }
                $locations_html .= '<p class="details-aside-content-radios__row-text">
                                    ' . $drop_price . '
                                </p></div>';
            }
        }
        $locations_html .= '</div>';
    }
    return $locations_html;
}

function tmbooking_get_dr_locations_html_short($ID, $style){

    $locations = get_the_terms($ID, 'transports-dr-locations');

    if( class_exists('TMTransport__Helping_Addons') ) {
        $locations = get_the_terms($ID, 'transports-dr-locations');
    }

    $locations_html = '';
    if (!empty($locations)){
        if($style == 'style_one'){
            $locations_html .= '<select class="tm-js-select" name="dr_location">';
            $locations_html .= '<option value="0">' . __('Drop off Location', 'tm-booking') . '</option>';
            foreach ($locations as $l) {
                $locations_html .= '<option value="' . $l->slug . '">';
                $locations_html .= $l->name;
                $locations_html .= '</option>';
            }
            $locations_html .= '</select>';
        } elseif($style == 'style_two'){
            $locations_html .= '<select class="tm-js-select" name="dr_location">';
            $locations_html .= '<option value="0">' . __('Drop off Location', 'tm-booking') . '</option>';
            foreach ($locations as $l){
                $locations_html .= '<option value="' . $l->slug .'">';
                $locations_html .=  $l->name;
                $locations_html .= '</option>';
            }
            $locations_html .= '</select>';
        } elseif($style == 'style_three'){
            $locations_html .= '<select name="dr_location">';
            $locations_html .= '<option value="0">' . __('Drop off Location', 'tm-booking') . '</option>';
            foreach ($locations as $l){
                $locations_html .= '<option value="' . $l->slug .'">';
                $locations_html .=  $l->name;
                $locations_html .= '</option>';
            }
            $locations_html .= '</select>';
        }elseif(isset($style) && $style === 'style_four') {
            $locations_html = '<div class="details-aside-content__radios details-aside-content-radios">';
            foreach ($locations as $l){
                $free = tmbooking_get_metabox('free', $l);
                if(isset($free) && $free == 'free') {
                    $locations_html .= '<div class="details-aside-content-radios__row tm_free_radio_order"><label class="container">';
                    $locations_html .=  $l->name;
                    $locations_html .= '<input type="radio" checked="checked" name="dr_location" value="' . $l->slug .'">
                                    <span class="checkmark"></span>';
                    $locations_html .= '</label>';

                    $locations_html .= '<p class="details-aside-content-radios__row-text">
                                    ' . __("Free", "tm-booking") . '
                                </p></div>';
                }
                if(isset($free) && $free == 'price'){
                    $drop_price = tmbooking_get_metabox('drop_price', $l);
                    $locations_html .= '<div class="details-aside-content-radios__row"><label class="container">';
                    $locations_html .=  $l->name;
                    $locations_html .= '<input type="radio" checked="checked" name="dr_location" value="' . $l->slug .'">
                                        <span class="checkmark"></span>';
                    $locations_html .= '</label>';
                    if(class_exists('WooCommerce')){
                        $drop_price = tmbooking_get_price_with_currency($drop_price);
                    } else {
                        $drop_price = tmbooking_get_price_with_currency($drop_price);
                    }
                    $locations_html .= '<p class="details-aside-content-radios__row-text">
                                    ' . $drop_price . '
                                </p></div>';
                }
            }
            $locations_html .= '</div>';

        } elseif(isset($style) && $style === 'style_five') {


        } else {

        }


    }
    return $locations_html;
}

function tmbooking_get_delivery_html_short($ID, $style){
    $delivery = get_the_terms($ID, 'transports-delivery');
    $delivery_html = '';



    if (!empty($delivery)){
        if(isset($style) && $style === 'style_four') {
            $delivery_html = '<div class="details-aside-content__radios details-aside-content-radios">';
            foreach ($delivery as $l){
                $free = tmbooking_get_term_metabox('free', $l->term_id);


                if(isset($free) && $free == 'free') {
                    $delivery_html .= '<div class="details-aside-content-radios__row tm_free_radio_order"><label class="container">';
                    $delivery_html .=  $l->name;
                    $delivery_html .= '<input type="radio" checked="checked" name="delivery" value="' . $l->slug .'">
                                    <span class="checkmark"></span>';
                    $delivery_html .= '</label>';

                    $delivery_html .= '<p class="details-aside-content-radios__row-text">
                                    ' . __("Free", "tm-booking") . '
                                </p></div>';
                }
                if(isset($free) && $free == 'price'){

                    $drop_price = tmbooking_get_term_metabox('drop_price', $l->term_id);
                    $delivery_html .= '<div class="details-aside-content-radios__row"><label class="container">';


                    $delivery_html .=  $l->name;
                    $delivery_html .= '<input type="radio" checked="checked" name="delivery" value="' . $l->slug .'">
                                        <span class="checkmark"></span>';
                    $delivery_html .= '</label>';
                    if(class_exists('WooCommerce')){
                        $drop_price = tmbooking_get_price_with_currency($drop_price);
                    } else {
                        $drop_price = tmbooking_get_price_with_currency($drop_price);
                    }
                    $delivery_html .= '<p class="details-aside-content-radios__row-text">
                                    ' . $drop_price . '
                                </p></div>';
                }
            }
            $delivery_html .= '</div>';
        }
    }
    return $delivery_html;
}


//Get Extra Html
function tmbooking_get_extra_html($ID, $parent_title = ''){
    $extra = get_the_terms($ID, 'transports-extra');
    $extra_html = '';
    
    // Check if extras exist and not an error (Проверяем наличие дополнительных опций)
    $has_extras = !empty($extra) && !is_wp_error($extra);
    
    // Add container with appropriate class (Добавляем класс для контейнера в зависимости от наличия опций)
    $container_class = $has_extras ? 'tm_input_container tm_extra_input' : 'tm_input_container tm_extra_input tm_empty_extras tm_empty_container';
    $extra_html .= '<span class="' . esc_attr($container_class) . '">';
    
    if ($has_extras){
        $extra_html .= '<div class="details-aside-content__options details-aside-content-options">';
        
        // Add parent title if provided (Добавляем родительский заголовок, если он указан)
        if (!empty($parent_title)) {
            $extra_html .= '<h3 class="tm-extras-parent-title">' . esc_html($parent_title) . '</h3>';
        }
        
        // Organize extras by parent (Группируем опции по родительским элементам)
        $parent_extras = array();
        $child_extras = array();
        
        // First pass: separate parents and children
        foreach ($extra as $e) {
            if ($e->parent == 0) {
                // This is a parent or standalone item
                $parent_extras[$e->term_id] = $e;
            } else {
                // This is a child item
                $child_extras[$e->parent][] = $e;
            }
        }
        
        // Second pass: render parents and their children
        foreach ($parent_extras as $parent_id => $parent) {
            // Check if this parent has children
            if (isset($child_extras[$parent_id])) {
                // This is a parent with children - render as a group header
                $extra_html .= '<div class="tm-extras-group">';
                $extra_html .= '<h4 class="tm-extras-group-title">' . esc_html($parent->name) . '</h4>';
                
                // Render all children of this parent
                foreach ($child_extras[$parent_id] as $child) {
                    $extra_price = tmbooking_get_term_metabox('extra_price', $child->term_id);
                    $extra_price_html = '';
                    if(class_exists('WooCommerce')){
                        $extra_price_html .= tmbooking_get_price_with_currency($extra_price);
                    } else {
                        $extra_price_html .= tmbooking_get_price_with_currency($extra_price);
                    }
                    $per = tmbooking_get_term_metabox('per', $child);

                    $extra_html .= '<div class="details-aside-content-options__box tm-extras-child-item">';
                    $extra_html .= '<label class="container"><span>' . $child->name . '</span>';
                    $extra_html .= '<input type="checkbox" name="extra[]" value="' . $child->term_id . '"/>';
                    $extra_html .= '<span class="checkmark"></span></label>';
                    $extra_html .= '<p class="details-aside-content-options__box-text">
                                    ' . $extra_price_html . '
                                    <span>' . $per . '</span>
                                </p>';
                    $extra_html .= '</div>';
                }
                
                $extra_html .= '</div>'; // Close group
            } else {
                // This is a standalone item (no children) - render normally
                $extra_price = tmbooking_get_term_metabox('extra_price', $parent->term_id);
                $extra_price_html = '';
                if(class_exists('WooCommerce')){
                    $extra_price_html .= tmbooking_get_price_with_currency($extra_price);
                } else {
                    $extra_price_html .= tmbooking_get_price_with_currency($extra_price);
                }
                $per = tmbooking_get_term_metabox('per', $parent);

                $extra_html .= '<div class="details-aside-content-options__box">';
                $extra_html .= '<label class="container"><span>' . $parent->name . '</span>';
                $extra_html .= '<input type="checkbox" name="extra[]" value="' . $parent->term_id . '"/>';
                $extra_html .= '<span class="checkmark"></span></label>';
                $extra_html .= '<p class="details-aside-content-options__box-text">
                                ' . $extra_price_html . '
                                <span>' . $per . '</span>
                            </p>';
                $extra_html .= '</div>';
            }
        }
        $extra_html .= '</div>';
    }
    $extra_html .= '<input type="hidden" name="extra_ids" class="extra_ids_' . $ID . '"/>';
    $extra_html .= '</span>'; // Close container (Закрываем контейнер)
    
    return $extra_html;
}

/**
 * Render selected extras only (for cart and order views)
 *
 * This function outputs only the extras whose term IDs are provided
 * in the comma-separated list $extra_ids_csv. It is intended for
 * use in WooCommerce cart and order meta displays so we do not show
 * unselected extras.
 *
 * @param int    $ID             Post ID of the transport item
 * @param string $extra_ids_csv  Comma-separated term IDs for selected extras
 * @return string                HTML with selected extras only
 */
function tmbooking_get_selected_extra_html($ID, $extra_ids_csv) {
    $output = '';

    if (empty($extra_ids_csv)) {
        return $output; // Nothing selected
    }

    // Normalize and sanitize provided IDs
    $ids = array_filter(array_map('absint', explode(',', $extra_ids_csv)));
    if (empty($ids)) {
        return $output;
    }

    // Get terms by IDs from transports-extra taxonomy
    $terms = get_terms(array(
        'taxonomy' => 'transports-extra',
        'hide_empty' => false,
        'include' => $ids,
    ));

    if (empty($terms) || is_wp_error($terms)) {
        return $output;
    }

    // Build a simple, clear list of selected extras with price and unit
    $output .= '<div class="tm-selected-extras-list">';
    foreach ($terms as $term) {
        // Read price and unit (per)
        $extra_price = tmbooking_get_term_metabox('extra_price', $term->term_id);
        $per = tmbooking_get_term_metabox('per', $term->term_id);

        // Format price with currency helper used in plugin
        $price_html = tmbooking_get_price_with_currency($extra_price);

        $output .= '<div class="tm-selected-extra-item">'
            . '<span class="tm-selected-extra-title">' . esc_html($term->name) . '</span>'
            . '<span class="tm-selected-extra-price">' . $price_html . '</span>'
            . (!empty($per) ? '<span class="tm-selected-extra-per">/' . esc_html($per) . '</span>' : '')
            . '</div>';
    }
    $output .= '</div>';

    return $output;
}
function tmbooking_get_extra_basic_html_short($ID, $style){
    $extra = get_the_terms($ID, 'transports-extra');
    $extra_html = '';

    // Check if extras exist and not an error (Проверяем наличие дополнительных опций)
    $has_extras = !empty($extra) && !is_wp_error($extra);
    if(isset($style) && $style === 'style_six'){
        if (!empty($extra)) {
            $extra_html .= '<div class="details-aside-content__radios details-aside-content-radios">';
            foreach ($extra as $e) {
                $extra_price = tmbooking_get_term_metabox('extra_price', $e->term_id);
                $extra_basic = tmbooking_get_term_metabox('basic', $e->term_id);
                $extra_price_html = '';
                if(isset($extra_basic) && $extra_basic == 'yes'){
                    if (class_exists('WooCommerce')) {
                        //$extra_price_html .= $currency_symbol_html . '<span class="prc">' . $extra_price . '</span>';
                        $extra_price_html .= tmbooking_get_price_with_currency($extra_price);
                    } else {
                        $extra_price_html .= tmbooking_get_price_with_currency($extra_price);
                    }
                    $per = tmbooking_get_term_metabox('per', $e->term_id);

                    $extra_html .= '<div class="details-aside-content-radios__row tm_free_radio_order">';

                    $extra_html .= '<label class="container">
                                                    <input type="radio" checked="checked" name="extra[]" value="' . $e->term_id . '">
                                                    ' . $e->name . '
                                                </label>';

                    $extra_html .= '<p class="details-aside-content-radios__row-text templines-font-style-semi-bolt">
                                        ' . $extra_price_html . '
                                        <span class="templines-font-style-normal time-detail">/ ' . $per . '</span>
                                    </p>';
                    $extra_html .= '</div>';
                }
            }
            $extra_html .= '</div>';

        }
    }
    $extra_html .= '<input type="hidden" name="extra_ids" class="extra_ids_' . $ID . '"/>';
    return $extra_html;
}
function tmbooking_get_extra_html_short($ID, $style, $parent_title = ''){
    $extra = get_the_terms($ID, 'transports-extra');
    $extra_html = '';
    
    // Check if extras exist and not an error (Проверяем наличие дополнительных опций)
    $has_extras = !empty($extra) && !is_wp_error($extra);
    
    // Add container with appropriate class (Добавляем класс для контейнера в зависимости от наличия опций)
    $container_class = $has_extras ? 'tm_input_container tm_extra_input' : 'tm_input_container tm_extra_input tm_empty_extras tm_empty_container';
    $extra_html .= '<span class="' . esc_attr($container_class) . '">';
    if(isset($style) && $style === 'style_one') {
        // Add parent title if provided (Добавляем родительский заголовок, если он указан)
        if (!empty($parent_title)) {
            $extra_html .= '<h3 class="tm-extras-parent-title">' . esc_html($parent_title) . '</h3>';
        }
        
        if (!empty($extra)) {
            // Organize extras by parent (Группируем опции по родительским элементам)
            $parent_extras = array();
            $child_extras = array();
            
            // First pass: separate parents and children
            foreach ($extra as $e) {
                if ($e->parent == 0) {
                    // This is a parent or standalone item
                    $parent_extras[$e->term_id] = $e;
                } else {
                    // This is a child item
                    $child_extras[$e->parent][] = $e;
                }
            }
            
            // Second pass: render parents and their children
            foreach ($parent_extras as $parent_id => $parent) {
                // Check if this parent has children
                if (isset($child_extras[$parent_id])) {
                    // This is a parent with children - render as a group header
                    $extra_html .= '<div class="tm-extras-group">';
                    $extra_html .= '<h4 class="tm-extras-group-title">' . esc_html($parent->name) . '</h4>';
                    
                    // Render all children of this parent
                    foreach ($child_extras[$parent_id] as $child) {
                        $extra_price = tmbooking_get_term_metabox('extra_price', $child->term_id);
                        $extra_price_html = '';
                        if (class_exists('WooCommerce')) {
                            $extra_price_html .= tmbooking_get_price_with_currency($extra_price);
                        } else {
                            $extra_price_html .= tmbooking_get_price_with_currency($extra_price);
                        }
                        $per = tmbooking_get_term_metabox('per', $child->term_id);

                        $extra_html .= '<span class="available_extra_wrap tm-extras-child-item">';
                        $extra_html .= '<input type="checkbox" name="extra[]" value="' . $child->term_id . '"/>';
                        $extra_html .= '<span class="available_extra_title">' . esc_html( $child->name ) . '</span>';
                        $extra_html .= '<span class="available_extra_price">' . $extra_price_html . '/' . $per . '</span>';
                        $extra_html .= '</span>';
                        if ( ! empty( $child->description ) ) {
                            $extra_html .= '<div class="available_extra_desc">' . esc_html( $child->description ) . '</div>';
                        }
                    }
                    
                    $extra_html .= '</div>'; // Close group
                } else {
                    // This is a standalone item (no children) - render normally
                    $extra_price = tmbooking_get_term_metabox('extra_price', $parent->term_id);
                    $extra_price_html = '';
                    if (class_exists('WooCommerce')) {
                        $extra_price_html .= tmbooking_get_price_with_currency($extra_price);
                    } else {
                        $extra_price_html .= tmbooking_get_price_with_currency($extra_price);
                    }
                    $per = tmbooking_get_term_metabox('per', $parent->term_id);

                    $extra_html .= '<span class="available_extra_wrap">';
                    $extra_html .= '<input type="checkbox" name="extra[]" value="' . $parent->term_id . '"/>';
                    $extra_html .= '<span class="available_extra_title">' . esc_html( $parent->name ) . '</span>';
                    $extra_html .= '<span class="available_extra_price">' . $extra_price_html . '/' . $per . '</span>';
                    $extra_html .= '</span>';
                    if ( ! empty( $parent->description ) ) {
                        $extra_html .= '<div class="available_extra_desc">' . esc_html( $parent->description ) . '</div>';
                    }
                }
            }
        }
        $extra_html .= '<input type="hidden" name="extra_ids" class="extra_ids_' . $ID . '"/>';
    } elseif(isset($style) && $style === 'style_two'){
        // Add parent title if provided (Добавляем родительский заголовок, если он указан)
        if (!empty($parent_title)) {
            $extra_html .= '<h3 class="tm-extras-parent-title">' . esc_html($parent_title) . '</h3>';
        }
        
        if (!empty($extra)){
            // Organize extras by parent (Группируем опции по родительским элементам)
            $parent_extras = array();
            $child_extras = array();
            
            // First pass: separate parents and children
            foreach ($extra as $e) {
                if ($e->parent == 0) {
                    // This is a parent or standalone item
                    $parent_extras[$e->term_id] = $e;
                } else {
                    // This is a child item
                    $child_extras[$e->parent][] = $e;
                }
            }
            
            // Second pass: render parents and their children
            foreach ($parent_extras as $parent_id => $parent) {
                // Check if this parent has children
                if (isset($child_extras[$parent_id])) {
                    // This is a parent with children - render as a group header
                    $extra_html .= '<div class="tm-extras-group">';
                    $extra_html .= '<h4 class="tm-extras-group-title">' . esc_html($parent->name) . '</h4>';
                    
                    // Render all children of this parent
                    foreach ($child_extras[$parent_id] as $child) {
                        $extra_price = tmbooking_get_term_metabox('extra_price', $child->term_id);
                        $extra_price_html = '';
                        if (class_exists('WooCommerce')) {
                            $extra_price_html .= tmbooking_get_price_with_currency($extra_price);
                        } else {
                            $extra_price_html .= tmbooking_get_price_with_currency($extra_price);
                        }
                        $per = tmbooking_get_term_metabox('per', $child->term_id);

                        $extra_html .= '<span class="available_extra_wrap tm-extras-child-item">';
                        $extra_html .= '<input type="checkbox" name="extra[]" value="' . $child->term_id . '"/>';
                        $extra_html .= '<span class="available_extra_title">' . esc_html( $child->name ) . '</span>';
                        $extra_html .= '<span class="available_extra_price">' . $extra_price_html . '/' . $per . '</span>';
                        $extra_html .= '</span>';
                        if ( ! empty( $child->description ) ) {
                            $extra_html .= '<div class="available_extra_desc">' . esc_html( $child->description ) . '</div>';
                        }
                    }
                    
                    $extra_html .= '</div>'; // Close group
                } else {
                    // This is a standalone item (no children) - render normally
                    $extra_price = tmbooking_get_term_metabox('extra_price', $parent->term_id);
                    $extra_price_html = '';
                    if (class_exists('WooCommerce')) {
                        $extra_price_html .= tmbooking_get_price_with_currency($extra_price);
                    } else {
                        $extra_price_html .= tmbooking_get_price_with_currency($extra_price);
                    }
                    $per = tmbooking_get_term_metabox('per', $parent->term_id);

                    $extra_html .= '<span class="available_extra_wrap">';
                    $extra_html .= '<input type="checkbox" name="extra[]" value="' . $parent->term_id . '"/>';
                    $extra_html .= '<span class="available_extra_title">' . $parent->name . '</span>';
                    $extra_html .= '<span class="available_extra_price">' . $extra_price_html . '/' . $per . '</span>';
                    $extra_html .= '</span>';
                    if ( ! empty( $parent->description ) ) {
                        $extra_html .= '<div class="available_extra_desc">' . esc_html( $parent->description ) . '</div>';
                    }
                }
            }
        }
        $extra_html .= '<input type="hidden" name="extra_ids" class="extra_ids_' . $ID . '"/>';
    } elseif(isset($style) && $style === 'style_three'){
        if (!empty($extra)){
            foreach ($extra as $e){
                $extra_price = tmbooking_get_term_metabox('extra_price', $e->term_id);
                $extra_price_html = '';
                if(class_exists('WooCommerce')){
                    $extra_price_html .= tmbooking_get_price_with_currency($extra_price);
                } else {
                    $extra_price_html .= tmbooking_get_price_with_currency($extra_price);
                }
                $per = tmbooking_get_term_metabox('per', $e->term_id);
                $extra_html .= '<span class="available_extra_wrap">';
                $extra_html .= '<input type="checkbox" name="extra[]" value="' . $e->term_id . '"/>';
                $extra_html .= '<span class="available_extra_title">' . esc_html( $e->name ) . '</span>';
                $extra_html .= '<span class="available_extra_price">' . $extra_price_html . '/' . $per . '</span>';
                $extra_html .= '</span>';
                if ( ! empty( $e->description ) ) {
                    $extra_html .= '<div class="available_extra_desc">' . esc_html( $e->description ) . '</div>';
                }
            }
        }
        $extra_html .= '<input type="hidden" name="extra_ids" class="extra_ids_' . $ID . '"/>';
    } elseif(isset($style) && $style === 'style_four'){
        if (!empty($extra)){
            $extra_html .= '<div class="details-aside-content__options details-aside-content-options">
                            <p class="details-aside-content-options__text">
                                ' . __("extra options:", "tm-booking") . '
                            </p>';
            foreach ($extra as $e){
                $extra_price = tmbooking_get_term_metabox('extra_price', $e->term_id);
                $extra_price_html = '';
                if(class_exists('WooCommerce')){
                    $extra_price_html .= tmbooking_get_price_with_currency($extra_price);
                } else {
                    $extra_price_html .= tmbooking_get_price_with_currency($extra_price);
                }
                $per = tmbooking_get_term_metabox('per', $e->term_id);
                $extra_html .= '<div class="details-aside-content-options__box">';
                $extra_html .= '<label class="container"><span>' . $e->name . '</span>';
                $extra_html .= '<input type="checkbox" name="extra[]" value="' . $e->term_id . '"/>';
                $extra_html .= '<span class="checkmark"></span></label>';
                $extra_html .= '<p class="details-aside-content-options__box-text">
                                    ' . $extra_price_html . '
                                    <span>' . $per . '</span>
                                </p>';
                $extra_html .= '</div>';
            }
            $extra_html .= '</div>';
        }
        $extra_html .= '<input type="hidden" name="extra_ids" class="extra_ids_' . $ID . '"/>';
    } elseif(isset($style) && $style === 'style_five'){
        if (!empty($extra)) {
            $extra_html .= '<div class="details-aside-content__options details-aside-content-options">
                            <p class="details-aside-content-options__text">
                                ' . __("extra options:", "tm-booking") . '
                            </p>';
            foreach ($extra as $e) {
                $extra_price = tmbooking_get_term_metabox('extra_price', $e->term_id);
                $extra_price_html = '';
                if (class_exists('WooCommerce')) {
                    //$extra_price_html .= $currency_symbol_html . '<span class="prc">' . $extra_price . '</span>';
                    $extra_price_html .= tmbooking_get_price_with_currency($extra_price);
                } else {
                    $extra_price_html .= tmbooking_get_price_with_currency($extra_price);
                }
                $per = tmbooking_get_term_metabox('per', $e->term_id);

                $extra_html .= '<div class="details-aside-content-options__box">';

                $extra_html .= '<label class="container"><span>' . $e->name . '</span>';
                $extra_html .= '<input type="checkbox" name="extra[]" value="' . $e->term_id . '"/>';
                $extra_html .= '<span class="checkmark"></span></label>';

                $extra_html .= '<p class="details-aside-content-options__box-text">
                                    ' . $extra_price_html . '
                                    <span>' . $per . '</span>
                                </p>';
                $extra_html .= '</div>';
            }
            $extra_html .= '</div>';
        }
    } elseif(isset($style) && $style === 'style_six'){
        if (!empty($extra)) {
            $extra_basic_arr = array();
            foreach ($extra as $ex) {
                $extra_basic_arr[] = tmbooking_get_term_metabox('basic', $ex->term_id);
            }
            if(in_array("no", $extra_basic_arr)){
                $extra_html .= '<div class="details-aside-content__options details-aside-content-options">
                            <p class="details-aside-content-options__text templines-font-style-semi-bolt">
                                ' . __("Extra options:", "tm-booking") . '
                            </p>';
            }

            foreach ($extra as $e) {
                $extra_price = tmbooking_get_term_metabox('extra_price', $e->term_id);
                $extra_basic = tmbooking_get_term_metabox('basic', $e->term_id);
                $extra_price_html = '';
                if(isset($extra_basic) && $extra_basic == 'no'){
                    if (class_exists('WooCommerce')) {
                        //$extra_price_html .= $currency_symbol_html . '<span class="prc">' . $extra_price . '</span>';
                        $extra_price_html .= tmbooking_get_price_with_currency($extra_price);
                    } else {
                        $extra_price_html .= tmbooking_get_price_with_currency($extra_price);
                    }
                    $per = tmbooking_get_term_metabox('per', $e->term_id);

                    $extra_html .= '<div class="details-aside-content-options__box">';

                    $extra_html .= '<label class="container"><span>' . $e->name . '</span>';
                    $extra_html .= '<input type="checkbox" name="extra[]" value="' . $e->term_id . '"/>';
                    $extra_html .= '<span class="checkmark"></span></label>';

                    $extra_html .= '<p class="details-aside-content-options__box-text templines-font-style-semi-bolt">
                                        ' . $extra_price_html . '
                                        <span class="templines-font-style-normal time-detail">/ ' . $per . '</span>
                                    </p>';
                    $extra_html .= '</div>';
                }
            }
            $extra_html .= '</div>';

        }
    } else {
        if (!empty($extra)){
            foreach ($extra as $e){
                $extra_price = tmbooking_get_term_metabox('extra_price', $e->term_id);
                $extra_price_html = '';
                if(class_exists('WooCommerce')){
                    //$extra_price_html .= $currency_symbol_html . '<span class="prc">' . $extra_price . '</span>';
                    $extra_price_html .= tmbooking_get_price_with_currency($extra_price);
                } else {
                    $extra_price_html .= tmbooking_get_price_with_currency($extra_price);
                }
                $per = tmbooking_get_term_metabox('per', $e->term_id);

                $extra_html .= '<span class="available_extra_wrap">';
                $extra_html .= '<input type="checkbox" name="extra[]" value="' . $e->term_id . '"/>';
                $extra_html .= '<span class="available_extra_title">' . $e->name . '</span>';
                $extra_html .= '<span class="available_extra_price">' . $extra_price_html . '/' . $per . '</span>';
                $extra_html .= '</span>';
            }
        }
        $extra_html .= '<input type="hidden" name="extra_ids" class="extra_ids_' . $ID . '"/>';
    }
    
    $extra_html .= '</span>'; // Close container (Закрываем контейнер)

    return $extra_html;
}

//price function
function tmbooking_get_price_with_currency($price){
    if(class_exists('WooCommerce')){
        $currency_pos    = get_option( 'woocommerce_currency_pos' );
        $currency_symbol = get_woocommerce_currency_symbol();
        
        // Add additional classes for currency position
        $position_classes = array(
            'currency_' . $currency_pos,
            'tm_currency_position_' . $currency_pos,
            'tm_currency_symbol_' . sanitize_html_class($currency_symbol)
        );
        
        return '<span class="prc ' . implode(' ', $position_classes) . '" data-symbol="' . $currency_symbol . '" data-position="' . $currency_pos . '">' . $price . '</span>';
    } else {
        // Fallback for non-WooCommerce sites
        return '<span class="prc tm_currency_position_right tm_currency_symbol_dollar" data-symbol="$" data-position="right">' . $price . '$' . '</span>';
    }
}

//price function
function tmbooking_get_price_with_currency_two($price){
    if(class_exists('WooCommerce')){
        $currency_pos    = get_option( 'woocommerce_currency_pos' );
        $currency_symbol = get_woocommerce_currency_symbol();
        
        // Add additional classes for currency position
        $position_classes = array(
            'currency_' . $currency_pos,
            'tm_currency_position_' . $currency_pos,
            'tm_currency_symbol_' . sanitize_html_class($currency_symbol)
        );
        
        return '<span class="prc ' . implode(' ', $position_classes) . '" data-symbol="' . $currency_symbol . '" data-position="' . $currency_pos . '">' . $price . '</span>';
    } else {
        // Fallback for non-WooCommerce sites
        return '<span class="prc tm_currency_position_right tm_currency_symbol_dollar" data-symbol="$" data-position="right">' . $price . '$' . '</span>';
    }
}

// Helper to map currency symbol to a safe CSS class suffix
if ( ! function_exists( 'tmbooking_symbol_to_class' ) ) {
    /**
     * Map currency symbol to a safe CSS class suffix.
     *
     * @param string $symbol Currency symbol.
     * @return string Safe class suffix for symbol.
     */
    function tmbooking_symbol_to_class( $symbol ) {
        $map = array(
            '$'  => 'dollar',
            '€'  => 'euro',
            '£'  => 'pound',
            '₽'  => 'rub',
            '₴'  => 'uah',
            '₹'  => 'inr',
            '¥'  => 'yen',
            '₩'  => 'krw',
            '₦'  => 'ngn',
            '₱'  => 'php',
            'R$' => 'brl',
        );
        if ( isset( $map[ $symbol ] ) ) {
            return $map[ $symbol ];
        }
        return sanitize_html_class( strtolower( preg_replace( '/\s+/', '', $symbol ) ) );
    }
}

if ( ! function_exists( 'tmbooking_enqueue_currency_position_classes' ) ) {
    /**
     * Enqueue a tiny inline script that adds currency position classes to the common wrapper.
     * Uses WooCommerce currency position setting. Runs once; no AJAX required.
     */
    function tmbooking_enqueue_currency_position_classes() {
        if ( is_admin() ) {
            return;
        }

        // Defaults
        $pos    = 'right';
        $symbol = '$';

        if ( class_exists( 'WooCommerce' ) ) {
            $pos_opt = get_option( 'woocommerce_currency_pos' );
            if ( is_string( $pos_opt ) && $pos_opt !== '' ) {
                $pos = $pos_opt; // left, right, left_space, right_space
            }
            $symbol = function_exists( 'get_woocommerce_currency_symbol' ) ? get_woocommerce_currency_symbol() : $symbol;
        }

        $symbol_class = tmbooking_symbol_to_class( $symbol );

        $handle = 'tm-booking-currency-position';
        wp_register_script( $handle, false, array(), '1.0', true );
        wp_enqueue_script( $handle );

        $classes = array(
            'currency_' . $pos,
            'tm_currency_position_' . $pos,
            'tm_currency_symbol_' . $symbol_class,
        );
        $classes_js = esc_js( implode( ' ', array_map( 'sanitize_html_class', $classes ) ) );

        $inline_js = 'document.addEventListener("DOMContentLoaded",function(){var nodes=document.querySelectorAll(".tm-booking-widget-wrap, .tm-booking-price-wrap");if(!nodes||nodes.length===0){var fb=document.getElementById("booking_car_info");if(fb){nodes=[fb];}}if(!nodes||nodes.length===0){return;}var cls="' . $classes_js . '".split(" ");nodes.forEach(function(el){cls.forEach(function(c){if(c){el.classList.add(c);}});el.setAttribute("data-position","' . esc_attr( $pos ) . '");el.setAttribute("data-symbol","' . esc_attr( $symbol ) . '");});});';

        wp_add_inline_script( $handle, $inline_js, 'after' );
    }
    add_action( 'wp_enqueue_scripts', 'tmbooking_enqueue_currency_position_classes', 20 );
}

//Woo Body Class
/**
 * Check if price list block should be shown or hidden
 *
 * @param int $post_id Post ID
 * @return string CSS class to add to the price list block
 */
// Функция tmbooking_get_price_list_visibility_class перенесена в файл button-text.php
add_filter('body_class', 'mb_body_class_for_cart_items');
function mb_body_class_for_cart_items( $classes ) {
    if(class_exists('WC')){
        if( !WC()->cart->is_empty() ){
            foreach ( WC()->cart->get_cart() as $cart_item ) {
                $sim_prod = get_post_meta($cart_item['product_id'], 'tmbooking_sim_product_id', true);
                if(isset($sim_prod) && $sim_prod != ''){
                    $classes[] = 'tm_booking_cart';
                    $classes[] = 'tm-booking-cart-has-items';
                    break;
                }
            }
        }
    }
    return $classes;
}










//Parsing
function tmbooking_deleteProduct($id, $force = FALSE){
    $product = wc_get_product($id);

    if(empty($product))
        return new WP_Error(999, sprintf(__('No %s is associated with #%d', 'woocommerce'), 'product', $id));

    // If we're forcing, then delete permanently.
    if ($force) {
        if ($product->is_type('variable'))
        {
            foreach ($product->get_children() as $child_id)
            {
                $child = wc_get_product($child_id);
                $child->delete(true);
            }
        }
        elseif ($product->is_type('grouped'))
        {
            foreach ($product->get_children() as $child_id)
            {
                $child = wc_get_product($child_id);
                $child->set_parent_id(0);
                $child->save();
            }
        }

        $product->delete(true);
        $result = $product->get_id() > 0 ? false : true;
    } else {
        $product->delete();
        $result = 'trash' === $product->get_status();
    }

    if (!$result) {
        return new WP_Error(999, sprintf(__('This %s cannot be deleted', 'woocommerce'), 'product'));
    }

    // Delete parent product transients.
    if ($parent_id = wp_get_post_parent_id($id)) {
        wc_delete_product_transients($parent_id);
    }
    return true;
}
function tmbooking_parsing_item_product($remove_products){
    global $wpdb;


    $custom_posts = get_posts(array(
        'fields'          => 'ids',
        'posts_per_page'  => -1,
        'post_type' => tmbooking_get_post_type(),
        'post_status' => array('publish', 'pending', 'draft', 'future', 'private', 'inherit', 'trash')
    ));





    if($remove_products){
        $custom_posts_for_del = get_posts(array(
            'fields'          => 'ids',
            'posts_per_page'  => -1,
            'post_type' => 'product',
            'post_status' => array('publish', 'pending', 'draft', 'future', 'private', 'inherit', 'trash')
        ));
        if(isset($custom_posts_for_del) && !empty($custom_posts_for_del)){
            foreach ($custom_posts_for_del as $cpd){
                $check_id = get_post_meta($cpd, 'tmbooking_sim_product_id', true);

                if(isset($check_id) && $check_id != ''){
                    wp_delete_post($cpd, true);
                }
            }
        }
    }


    $arr = array();
    if(isset($custom_posts) && !empty($custom_posts)){
        foreach ($custom_posts as $cp){

            //Add tmbooking data
            if(!get_post_meta($cp, '_tmbooking_data', true)){
                update_post_meta($cp, '_tmbooking_data', array());
            }


            $author_id = get_post_field( 'post_author', $cp );
            if(!get_post_meta($cp, 'tmbooking_sim_product_id', true)){
                $post = get_post($cp);
                //var_dump($post->post_title);
                $objProduct = new WC_Product();
                $objProduct->set_name( $post->post_title );
                $objProduct->set_description( $post->post_content );
                $objProduct->set_status( "publish" );
                $objProduct->set_catalog_visibility( 'hidden' );
                $objProduct->set_price( 1 );
                $objProduct->set_regular_price( 1 );
                $objProduct->set_manage_stock( false );
                $objProduct->set_stock_quantity( 11 );
                $objProduct->set_stock_status( 'instock' );
                $objProduct->set_backorders( 'no' );
                $objProduct->set_reviews_allowed( false );
                $objProduct->set_sold_individually( false );
                $objProduct->set_virtual( true );
                $product_id = $objProduct->save();


                wp_update_post(
                    [
                        'ID'          => $product_id,
                        'post_author' => $author_id,
                    ]
                );
                update_post_meta($cp, 'tmbooking_sim_product_id', $product_id);
                update_post_meta($product_id, 'tmbooking_sim_product_id', $cp);

                $arr[$cp] = $product_id;
                $arr[$cp] = 'true';

            } else {
                $check_id = get_post_meta($cp, 'tmbooking_sim_product_id', true);

                if(isset($check_id) && $check_id != ''){
                    $product = get_post($check_id);
                    if(!$product){

                        $post = get_post($cp);
                        $objProduct = new WC_Product();
                        $objProduct->set_name( $post->post_title );
                        $objProduct->set_description( $post->post_content );
                        $objProduct->set_status( "publish" );
                        $objProduct->set_catalog_visibility( 'hidden' );
                        $objProduct->set_price( 1 );
                        $objProduct->set_regular_price( 1 );
                        $objProduct->set_manage_stock( false );
                        $objProduct->set_stock_quantity( 11 );
                        $objProduct->set_stock_status( 'instock' );
                        $objProduct->set_backorders( 'no' );
                        $objProduct->set_reviews_allowed( false );
                        $objProduct->set_sold_individually( false );
                        $objProduct->set_virtual( true );
                        $product_idd = $objProduct->save();
                        $author_id = get_post_field( 'post_author', $cp );
                        wp_update_post(
                            [
                                'ID'          => $product_idd,
                                'post_author' => $author_id,
                                'post_status' => $post->post_status,
                            ]
                        );
                        update_post_meta($cp, 'tmbooking_sim_product_id', $product_idd);
                        update_post_meta($product_idd, 'tmbooking_sim_product_id', $cp);
                        $arr[$cp][] = $product_idd;
                        $arr[$cp][] = 'true';
                    } else {
                        if(is_object($product) && $product->post_status == 'trash'){

                            $product_check_id = get_post_meta($check_id, 'tmbooking_sim_product_id', true);
                            if(isset($product_check_id) && $product_check_id == ''){
                                update_post_meta($check_id, 'tmbooking_sim_product_id', $cp);
                            }
                            $product_check_id = get_post_meta($check_id, 'tmbooking_sim_product_id', true);
                            $product_check = get_post($product_check_id);
                            if($product_check){
                                wp_update_post(
                                    [
                                        'ID'          => $check_id,
                                        'post_status' => $product_check->post_status,
                                        'post_author' => $author_id,
                                    ]
                                );
                            } else {
                                wp_update_post(
                                    [
                                        'ID'          => $check_id,
                                        'post_status' => 'publish',
                                        'post_author' => $author_id,
                                    ]
                                );
                            }

                            $arr[$cp][] = $check_id;
                            $arr[$cp][] = 'true';
                        } else {
                            $arr[$cp][] = $check_id;
                            $arr[$cp][] = 'true';

                            $product_check_id = get_post_meta($check_id, 'tmbooking_sim_product_id', true);
                            if(isset($product_check_id) && $product_check_id == ''){
                                update_post_meta($check_id, 'tmbooking_sim_product_id', $cp);
                            }
                            $product_check_id = get_post_meta($check_id, 'tmbooking_sim_product_id', true);

                            $product_check = get_post($product_check_id);

                            if($product_check){
                                wp_update_post(
                                    [
                                        'ID'          => $check_id,
                                        'post_status' => $product_check->post_status,
                                        'post_author' => $author_id,

                                    ]
                                );
                            }
                            if(!$product_check){
                                tmbooking_deleteProduct($check_id, true);
                            }
                        }
                    }

                } elseif (isset($check_id) && $check_id == ''){
                    $post = get_post($cp);

                    $objProduct = new WC_Product();
                    $objProduct->set_name( $post->post_title );
                    $objProduct->set_description( $post->post_content );
                    $objProduct->set_status( "publish" );
                    $objProduct->set_catalog_visibility( 'hidden' );
                    $objProduct->set_price( 1 );
                    $objProduct->set_regular_price( 1 );
                    $objProduct->set_manage_stock( false );
                    $objProduct->set_stock_quantity( 11 );
                    $objProduct->set_stock_status( 'instock' );
                    $objProduct->set_backorders( 'no' );
                    $objProduct->set_reviews_allowed( false );
                    $objProduct->set_sold_individually( false );
                    $objProduct->set_virtual( true );
                    $product_ida = $objProduct->save();

                    $author_id = get_post_field( 'post_author', $cp );
                    wp_update_post(
                        [
                            'ID'          => $product_ida,
                            'post_author' => $author_id,
                            'post_status' => $post->post_status,
                        ]
                    );
                    update_post_meta($cp, 'tmbooking_sim_product_id', $product_ida);
                    update_post_meta($product_ida, 'tmbooking_sim_product_id', $cp);

                    $arr[$cp][] = $product_ida;
                    $arr[$cp][] = 'true';
                }
            }

        }
    }

    //DataBase clear
    $all_meta = $wpdb->get_results("SELECT * FROM $wpdb->postmeta WHERE (meta_key = 'tmbooking_sim_product_id')");
    if(isset($all_meta) && is_array($all_meta) && !empty($all_meta)){
        foreach ($all_meta as $meta){
            $post = get_post($meta->post_id);

            $check_id = get_post_meta($meta->meta_value, 'tmbooking_sim_product_id', true);
            $post_check = get_post($check_id);
            if(!$post_check){
                tmbooking_deleteProduct($meta->post_id, true);
            }

            if(!$post){
                $wpdb->delete( $wpdb->postmeta, array( 'meta_id' => $meta->meta_id ) );
            }

            if($meta->meta_value == ''){
                $wpdb->delete( $wpdb->postmeta, array( 'meta_value' => $meta->meta_value ) );
            }

            if($post->post_type != tmbooking_get_post_type() && $post->post_type != 'product'){
                $wpdb->delete( $wpdb->postmeta, array( 'meta_id' => $meta->meta_id ) );
            }
        }
    }

    if(isset($arr) && is_array($arr) && !empty($arr)){
        update_option('tmbooking_item_prod', $arr);
    }

}

add_filter('post_class', 'tmbooking_sim_product');
function tmbooking_sim_product($classes)
{
    global $post;

    if($post->post_type == 'product'){
        $sim_trans = get_post_meta($post->ID, 'tmbooking_sim_product_id', true);
        if(isset($sim_trans) && $sim_trans != ''){
            $classes[] = 'tmbooking_sim_product';
        }
    }

    return $classes;
}

//New item
function tmbooking_new_item_redirect($post_id, $post, $update) {
    if ( $post->post_type == tmbooking_get_post_type()) {
        tmbooking_parsing_item_product(false);
        if(!is_admin()){
            if(class_exists('Dokan')){
                $dokan_pages = get_option('dokan_pages');
                if(isset($dokan_pages['dashboard']) && $dokan_pages['dashboard'] != ''){
                    $permalink = get_permalink($dokan_pages['dashboard']) . '/products/';
                    echo '<script>window.location.href = "' . $permalink . '"</script>';
                }
            }
        }
    }
}
add_action( 'wp_after_insert_post', 'tmbooking_new_item_redirect', 10, 3 );

//Update
function tmbooking_post_update($post_ID, $post_after, $post_before) {
    if (get_post_type($post_ID) == tmbooking_get_post_type()) {
        $check_id = get_post_meta($post_ID, 'tmbooking_sim_product_id', true);
        if( get_post_status($post_ID) != 'auto-draft'){
            if(isset($check_id) && $check_id != ''){
                $post_update = array(
                    'ID'         => $check_id,
                    'post_title' => $post_after->post_title,
                    'post_content' => $post_after->post_content
                );
                wp_update_post( $post_update );
            }
        }
        tmbooking_parsing_item_product(false);
    }
}
add_action( 'post_updated', 'tmbooking_post_update', 10, 3 );

//Delete permanently
add_action( 'after_delete_post', 'tmbooking_delete_post_action', 99, 2);
function tmbooking_delete_post_action( $post_ID, $post ){
    if ( $post->post_type == tmbooking_get_post_type()) {
        tmbooking_parsing_item_product(false);
    }
}



//Add booking data meta
add_action( 'wp_after_insert_post', 'tmbooking_add_booking_data_meta', 10, 3 );
function tmbooking_add_booking_data_meta( $post_ID, $post ){
    if ( $post->post_type == tmbooking_get_post_type()) {
        update_post_meta($post_ID, '_tmbooking_data', array());
    }
}


add_action('wp_footer', 'tm_booking_hours_javascript', 99);
function tm_booking_hours_javascript() {

    //Disable Hours
    $booking_settings = get_option('tm_booking_settings', true);
    if(isset($booking_settings['working_hours']['start']) && $booking_settings['working_hours']['start'] != '' && $booking_settings['working_hours']['start'] != 'disable' && 
       isset($booking_settings['working_hours']['end']) && $booking_settings['working_hours']['end'] != '' && $booking_settings['working_hours']['end'] != 'disable'){
        $start = DateTime::createFromFormat('H:i', $booking_settings['working_hours']['start']);
        $end = DateTime::createFromFormat('H:i', $booking_settings['working_hours']['end']);

        $arr = array();
        while($start < $end) {
            $arr[] = intval($start->format('H'));
            $start->modify('+1 hour');
        }

        $t = 24;
        $m = 1;
        $disable_hours_script = '';
        while ($m <= $t){
            if($m == 24){
                if(!in_array(0, $arr)){
                    $disable_hours_script .= "$('select.hourselect option[value=0]').addClass('disabled');";
                    $disable_hours_script .= "$('select.hourselect option[value=0]').prop('disabled', true);";
                }
            } else {
                if(!in_array($m, $arr)){
                    $disable_hours_script .= "$('select.hourselect option[value=".$m."]').addClass('disabled');";
                    $disable_hours_script .= "$('select.hourselect option[value=".$m."]').prop('disabled', true);";
                }
            }
            $m++;
        }
        ?>
        <script>
            jQuery(document).ready(function($) {
                // Применяем ограничения при загрузке страницы
                function applyHoursRestrictions() {
                    <?php echo $disable_hours_script;?>
                }
                
                // Применяем ограничения при загрузке
                applyHoursRestrictions();
                
                // Применяем ограничения при клике на поле даты
                $('.tm_booking_date').click(function() {
                    applyHoursRestrictions();
                });
                
                // Применяем ограничения при открытии календаря
                $(document).on('shown.daterangepicker', function() {
                    applyHoursRestrictions();
                });
            });
        </script>
        <?php
    }
}

//New product
function tm_booking_new_sim_product($cp){
    $post = get_post($cp);
    $arr_opt = get_option('tmbooking_item_prod', true);


    $objProduct = new WC_Product();
    $objProduct->set_name( $post->post_title );
    $objProduct->set_description( $post->post_content );
    $objProduct->set_status( "publish" );
    $objProduct->set_catalog_visibility( 'hidden' );
    $objProduct->set_price( 1 );
    $objProduct->set_regular_price( 1 );
    $objProduct->set_manage_stock( false );
    $objProduct->set_stock_quantity( 11 );
    $objProduct->set_stock_status( 'instock' );
    $objProduct->set_backorders( 'no' );
    $objProduct->set_reviews_allowed( false );
    $objProduct->set_sold_individually( false );
    $objProduct->set_virtual( true );
    $product_ida = $objProduct->save();

    $author_id = get_post_field( 'post_author', $cp );
    wp_update_post(
        [
            'ID'          => $product_ida,
            'post_author' => $author_id,
            'post_status' => $post->post_status,
        ]
    );
    update_post_meta($cp, 'tmbooking_sim_product_id', $product_ida);
    update_post_meta($product_ida, 'tmbooking_sim_product_id', $cp);

    $arr[$cp][] = $product_ida;
    $arr[$cp][] = 'true';

    $arr = array_merge($arr, $arr_opt);
    if(isset($arr) && is_array($arr) && !empty($arr)){
        update_option('tmbooking_item_prod', $arr);
    }
    return $product_ida;
}





//SHORTCODE
function tmbooking_book_form_shortcode($atts){


    if(isset($atts['title']) && $atts['title'] != ''){
        $title = $atts['title'];
    } else {
        $title = __('Rent Sunny Villas Retreat', 'tm-booking');
    }

    if(isset($atts['subtitle']) && $atts['subtitle'] != ''){
        $subtitle = $atts['subtitle'];
    } else {
        $subtitle = __('Enter details or ask for help', 'tm-booking');
    }


    if(isset($atts['id']) && $atts['id'] != ''){
        $ID = $atts['id'];
    } else {
        $ID = get_the_ID();
    }
    if(isset($atts['style']) && $atts['style'] != '') {
        $style = $atts['style'];
    }else {
        $style = 'style_one';
    }
    $tmbooking_result = '';

    $booking_settings = get_option('tm_booking_settings', true);

    // Get extras title from settings if available
    $extras_title = isset($booking_settings['extras_title']) ? $booking_settings['extras_title'] : '';
    $extra_html = tmbooking_get_extra_html_short($ID, $style, $extras_title);
    $extra_basic_html = tmbooking_get_extra_basic_html_short($ID, $style);


    $discount_html = tmbooking_get_discount_percent_html($ID);
    $location_html = tmbooking_get_locations_html_short($ID, $style);
    $location_dr_html = tmbooking_get_dr_locations_html_short($ID, $style);
    $location_del_html = tmbooking_get_delivery_html_short($ID, $style);

    $disable_dates = get_post_meta($ID, '_tmbooking_data', true);
    $disable_dates_js = array();


    if(isset($disable_dates) && !empty($disable_dates)){
        foreach ($disable_dates as $d){
            $d = explode(" ", $d);
            $disable_dates_js[] = $d[0];
        }
        $disable_dates_js = json_encode($disable_dates_js);
    } else {
        $disable_dates_js = json_encode($disable_dates_js);
    }
    $hours = '';
    if(in_array('calc_hours', $booking_settings['calc_periods'])){
        // Проверяем настройку формата времени (Check time format setting)
        $time_format_24h = !isset($booking_settings['time_format']) || $booking_settings['time_format'] !== '12h';
        $hours = 'timePicker: true, timePicker24Hour: ' . ($time_format_24h ? 'true' : 'false') . ',';
    } else {
        $hours = 'timePicker: false, timePicker24Hour: false,';
    }

    $btn_disable_script = $permalink_levels = '';
    if(is_user_logged_in()){
        $user_id = get_current_user_ID();
        $tmreviews_dl_sended = get_user_meta($user_id, 'tmreviews_dl_sended', true);
        $user = get_user_by('ID', $user_id);
        $permalink_levels =  get_site_url() . '/members/' . $user->user_login . '/account_settings/';;
    }

    $btn_disable_script = '$(".book_now_btn").prop("disabled", false);';


    $disable_days = '';
    if(isset($booking_settings['disable_days']) && is_array($booking_settings['disable_days']) && !empty($booking_settings['disable_days'])){
        $b = 1;
        $days = '';

        foreach ($booking_settings['disable_days'] as $day){
            $days .= 'date.day() == ' . $day;
            if(count($booking_settings['disable_days']) != $b){
                $days .= '||';
            }
            $b++;
        }

        $disable_days .= 'isInvalidDate: function(date) {
                      return (' . $days . ');
                    },';
    }


    //Deposit
    $deposit_price_html = '';
    $deposit_enable = get_post_meta($ID, 'deposit_section_deposit_enable', true);
    if(isset($deposit_enable) && $deposit_enable == 'yes'){
        $deposit_section_deposit_type = get_post_meta($ID, 'deposit_section_deposit_type', true);
        $deposit_section_deposit_amount = get_post_meta($ID, 'deposit_section_deposit_amount', true);
        if(isset($deposit_section_deposit_type) && $deposit_section_deposit_type == 'fixed'){
            if(isset($deposit_section_deposit_amount) && $deposit_section_deposit_amount != ''){
                $deposit_price_html = '<span class="tmbooking_deposit_amount_notice"><span>*</span>' . __('You pay only a deposit of ') . $deposit_section_deposit_amount . get_woocommerce_currency_symbol() . '</span>';
            }
        }
        if(isset($deposit_section_deposit_type) && $deposit_section_deposit_type == 'percent'){
            if(isset($deposit_section_deposit_amount) && $deposit_section_deposit_amount != ''){
                $deposit_price_html = '<span class="tmbooking_deposit_amount_notice"><span>*</span>' . __('You pay only a deposit of ') . $deposit_section_deposit_amount . '%' . '</span>';
            }
        }
    }
    if(isset($booking_settings['booked_days']) && $booking_settings['booked_days'] === 'disable'){
        $disable_dates_js = '""';
    }

    if(tmbooking_check_price($ID)){
        if($style == 'style_one') {
            $tmbooking_result .= '<div class="tm_equipment-booking equipment-booking equipment-booking-' . $style . '">';

            $tmbooking_result .= '<div class="rental-item__price">';

            $tmbooking_result .= '<div class="rental-item__price-btn">
                                       <form class="booking_form booking_form' . $ID . '" data-id="' . $ID . '">
                                            <input type="hidden" class="hidden_id" name="id" value="' . $ID . '"/>
                                            <span class="tm_booking_notice" style="display: none">' . __("Please, fill form", "tm-booking") . '</span>
                                            <span class="tm_input_container tm_date_input">
                                                <input id="tm_booking_date' . $ID . '" class="tm_booking_date tm_booking_date' . $ID . '" placeholder="Select Dates"/>
                                                
                                                <input type="hidden" name="start_date" class="start_date start_date' . $ID . '"/>
                                                <input type="hidden" name="end_date" class="end_date end_date' . $ID . '"/>
                                                
                                                <input type="hidden" name="start_time" class="start_time start_time' . $ID . '"/>
                                                <input type="hidden" name="end_time" class="end_time end_time' . $ID . '"/>
                                                
                                                <input type="hidden" name="number_days" class="diff' . $ID . '"/>';

            $tmbooking_result .= '              <script>
                                                    jQuery.noConflict()(function($) {
                                                          var templines_date_class = [];
                                                          templines_date_class = ' . $disable_dates_js . ';
                                                          $(".tm_booking_date' . $ID . '").daterangepicker(
                                                          {
                                                                drops: "' . $booking_settings["drops"] . '", 
                                                                showWeekNumbers: ' . $booking_settings["showWeekNumbers"] . ',
                                                                showISOWeekNumbers: ' . $booking_settings["showISOWeekNumbers"] . ',
                                                                startDate: moment().startOf("hour"),
                                                                minDate: new Date(),
                                                                ' . $hours . '
                                                                locale: { format: "' . $booking_settings["date_format"] . '" },
                                                                  isInvalidDate: function(ele) {
                                                                var currDate = moment(ele._d).format("'. $booking_settings["date_format"] . '");
                                                                return templines_date_class.indexOf(currDate) != -1;
                                                            }, 
                                                          }, function(start, end, label) {
                                                              
                                                               $(".start_date' . $ID . '").val(start.format("' . $booking_settings["date_format"] . '"));
                                                               $(".end_date' . $ID . '").val(end.format("' . $booking_settings["date_format"] . '"));
                                                                 
                                                               $(".start_time' . $ID . '").val(start.format("HH:mm"));
                                                               $(".end_time' . $ID . '").val(end.format("HH:mm"));
                                                                 
                                                                var unindexed_array = jQuery(".booking_form' . $ID . '").serializeArray();
                                                                var indexed_array = {};
                                                                var extra_ids_val = "";
                                                               
                                                                $.map(unindexed_array, function(n, i){
                                                                    indexed_array[n["name"]] = n["value"];
                                                                    if(n["name"] === "extra[]"){
                                                                        extra_ids_val += n["value"] + ",";
                                                                    } 
                                                                    indexed_array["extra_ids"] = extra_ids_val.slice(0,-1);
                                                                });
                                                                formData = indexed_array;
                                                                var data = {
                                                                    action: "tmbooking_change_total",
                                                                    data: formData
                                                                };
                                                                $.post( tm_booking_ajax.url, data, function(response) {
                                                                     $(".book_now_btn").prop("disabled", false);
                                                                     $(".tm_price_total' . $ID . '").html(response.html);
                                                                      $(".booking_form' . $ID . ' .book_now_btn").html(response.deposit_price);
                                                                });
                                                          })
                                                    });
                                                 </script>';

            // Проверяем, пустые ли контейнеры
            $location_empty = empty(trim($location_html));
            $dr_location_empty = empty(trim($location_dr_html));
            $extra_empty = empty(trim($extra_html));
            $discount_empty = empty(trim($discount_html));
            
            // Добавляем класс tm_empty_container для пустых контейнеров
            $location_class = $location_empty ? ' tm_empty_container' : '';
            $dr_location_class = $dr_location_empty ? ' tm_empty_container' : '';
            $extra_class = $extra_empty ? ' tm_empty_container' : '';
            $discount_class = $discount_empty ? ' tm_empty_container' : '';
            
            $tmbooking_result .= '              </span>
                                            
                                            <span class="tm_input_container tm_location_input' . $location_class . '">
                                                ' . $location_html . '
                                            </span>
                                            <span class="tm_input_container tm_dr_location_input' . $dr_location_class . '">
                                                ' . $location_dr_html . '
                                            </span>
                                            ' . $extra_html . '
                                            
                                            <span class="tm_input_container tm_discount_input tm_discount_input' . $ID . $discount_class . '">
                                                 ' . $discount_html . '
                                            </span>
                                            
                                            <span class="booking_count booking_count' . $ID . '"></span>
                                            
                                             <div class="min-days-info-container">
                                             ' . apply_filters('tmbooking_before_book_now_button', '', $ID) . '
                                             </div>
                                             
                                             <span class="tm_input_container tm_price_total tm_price_total' . $ID . ' tm_empty_container"></span>
                                            
                                            <button class="book_now_btn" disabled="disabled" onclick="return false;" data-wait="' . __('Please wait', 'tm-booking') . '">' . tmbooking_get_book_now_text($ID) . '</button>
                                            
                                            ' . $deposit_price_html . '
                                        
                                        </form>
                                </div>';
            $tmbooking_result .= '</div>';
            $tmbooking_result .= '</div>';


        } elseif ($style == 'style_two'){
            $tmbooking_result .= '<div class="tm_equipment-booking equipment-booking equipment-booking-' . $style . '">';
            $tmbooking_result .= '<div class="rental-item__price">';
            $tmbooking_result .= '<div class="rental-item__price-btn">
                                       <form class="booking_form booking_form' . $ID . '" data-id="' . $ID . '">
                                            <input type="hidden" class="hidden_id" name="id" value="'. $ID .'"/>
                                            
                                            <span class="tm_input_container tm_date_input">
                                                <input id="tm_booking_date'. $ID .'" class="tm_booking_date tm_booking_date'. $ID .'" placeholder="Select Dates"/>
                                                
                                                <input type="hidden" name="start_date" class="start_date start_date'. $ID .'"/>
                                                <input type="hidden" name="end_date" class="end_date end_date'. $ID .'"/>
                                                
                                                <input type="hidden" name="start_time" class="start_time start_time'. $ID .'"/>
                                                <input type="hidden" name="end_time" class="end_time end_time'. $ID .'"/>
                                                
                                                <input type="hidden" name="number_days" class="diff'. $ID .'"/>';

            $tmbooking_result .= '              <script>
                                                    jQuery.noConflict()(function($) {
                                                          var templines_date_class = [];
                                                          templines_date_class = ' . $disable_dates_js . ';
                                                            
                                                          $(".tm_booking_date'. $ID .'").daterangepicker(
                                                          {
                                                          
                                                                drops: "' . $booking_settings["drops"] . '", 
                                                                showWeekNumbers: ' . $booking_settings["showWeekNumbers"] . ',
                                                                showISOWeekNumbers: ' . $booking_settings["showISOWeekNumbers"] . ',
                                                                startDate: moment().startOf("hour"),
                                                                minDate: new Date(),
                                                                ' . $hours . '
                                                                locale: { 
                                                                    format: "'. $booking_settings["date_format"] . '",
                                                                    "applyLabel": "' . __("Apply", "tm-booking") . '",
                                                                    "cancelLabel": "' . __("Cancel", "tm-booking") . '",
                                                                    "fromLabel": "' . __("From", "tm-booking") . '",
                                                                    "toLabel": "' . __("To", "tm-booking") . '",
                                                                    "customRangeLabel": "' . __("Custom", "tm-booking") . '",
                                                                    "weekLabel": "' . __("W", "tm-booking") . '",
                                                                    "daysOfWeek": [
                                                                        "' . __("Su", "tm-booking") . '",
                                                                        "' . __("Mo", "tm-booking") . '",
                                                                        "' . __("Tu", "tm-booking") . '",
                                                                        "' . __("We", "tm-booking") . '",
                                                                        "' . __("Th", "tm-booking") . '",
                                                                        "' . __("Fr", "tm-booking") . '",
                                                                        "' . __("Sa", "tm-booking") . '"
                                                                    ],
                                                                    "monthNames": [
                                                                        "' . __("January", "tm-booking") . '",
                                                                        "' . __("February", "tm-booking") . '",
                                                                        "' . __("March", "tm-booking") . '",
                                                                        "' . __("April", "tm-booking") . '",
                                                                        "' . __("May", "tm-booking") . '",
                                                                        "' . __("June", "tm-booking") . '",
                                                                        "' . __("July", "tm-booking") . '",
                                                                        "' . __("August", "tm-booking") . '",
                                                                        "' . __("September", "tm-booking") . '",
                                                                        "' . __("October", "tm-booking") . '",
                                                                        "' . __("November", "tm-booking") . '",
                                                                        "' . __("December", "tm-booking") . '"
                                                                    ],
                                                                },
                                                                
                                                                 isInvalidDate: function(ele) {
                                                                var currDate = moment(ele._d).format("'. $booking_settings["date_format"] . '");
                                                                return templines_date_class.indexOf(currDate) != -1;
                                                            },
                                                          }, function(start, end, label) {
                                                                                                                        

                                                               $(".start_date'. $ID .'").val(start.format("' . $booking_settings["date_format"] . '"));
                                                               $(".end_date'. $ID .'").val(end.format("' . $booking_settings["date_format"] . '"));
                                                                 
                                                               $(".start_time'. $ID .'").val(start.format("HH:mm"));
                                                               $(".end_time'. $ID .'").val(end.format("HH:mm"));
                                                                 
                                                                var unindexed_array = jQuery(".booking_form'. $ID .'").serializeArray();
                                                                var indexed_array = {};
                                                                var extra_ids_val = "";
                                                               
                                                                $.map(unindexed_array, function(n, i){
                                                                    indexed_array[n["name"]] = n["value"];
                                                                    if(n["name"] === "extra[]"){
                                                                        extra_ids_val += n["value"] + ",";
                                                                    } 
                                                                    indexed_array["extra_ids"] = extra_ids_val.slice(0,-1);
                                                                });
                                                                formData = indexed_array;
                                                                var data = {
                                                                    action: "tmbooking_change_total",
                                                                    data: formData
                                                                };
                                                                
                                                                $.post( tm_booking_ajax.url, data, function(response) {
                                                                    ' . $btn_disable_script . '
                                                                    
                                                                     $(".tm_price_total'. $ID .'").html(response);
                                                                });
                                                                
                                                          })
                                                          
                                                    });
                                                 </script>';

            // Проверяем, пустые ли контейнеры для style_two
            $location_empty = empty(trim($location_html));
            $dr_location_empty = empty(trim($location_dr_html));
            $extra_empty = empty(trim($extra_html));
            $discount_empty = empty(trim($discount_html));
            
            // Добавляем класс tm_empty_container для пустых контейнеров
            $location_class = $location_empty ? ' tm_empty_container' : '';
            $dr_location_class = $dr_location_empty ? ' tm_empty_container' : '';
            $extra_class = $extra_empty ? ' tm_empty_container' : '';
            $discount_class = $discount_empty ? ' tm_empty_container' : '';
            
            $tmbooking_result .= '              </span>
                                            
                                            <span class="tm_input_container tm_location_input' . $location_class . '">
                                                ' . $location_html . '
                                            </span>
                                            <span class="tm_input_container tm_dr_location_input' . $dr_location_class . '">
                                                ' . $location_dr_html . '
                                            </span>
                                            
                                            ' . $extra_html . '
                                            
                                            <span class="tm_input_container tm_discount_input tm_discount_input'. $ID . $discount_class . '">
                                                 ' . $discount_html . '
                                            </span>
                                            
                                            <span class="booking_count booking_count'. $ID .'"></span>
                                            
                                            <span class="tm_input_container tm_price_total tm_price_total'. $ID .' tm_empty_container"></span>
                                            
                                            <button class="book_now_btn" disabled="disabled" onclick="return false;" data-wait="' . __('Please wait', 'tm-booking') . '">' . tmbooking_get_book_now_text($ID) . '</button>
                                        </form>
                                </div>';
            $tmbooking_result .= '</div>';
            $tmbooking_result .= '</div>';

        } elseif ($style == 'style_three'){
            $tmbooking_result .= '<div class="tm_equipment-booking equipment-booking equipment-booking-' . $style . '">';
            $tmbooking_result .= '<div class="rental-item__price">';
            $tmbooking_result .= '<div class="rental-item__price-btn">
                                       <form class="booking_form booking_form' . $ID . '" data-id="' . $ID . '">
                                            <input type="hidden" class="hidden_id" name="id" value="'. $ID .'"/>
                                            
                                            <span class="tm_input_container tm_date_input">
                                                <input id="tm_booking_date'. $ID .'" class="tm_booking_date tm_booking_date'. $ID .'" placeholder="Select Dates"/>
                                                
                                                <input type="hidden" name="start_date" class="start_date start_date'. $ID .'"/>
                                                <input type="hidden" name="end_date" class="end_date end_date'. $ID .'"/>
                                                
                                                <input type="hidden" name="start_time" class="start_time start_time'. $ID .'"/>
                                                <input type="hidden" name="end_time" class="end_time end_time'. $ID .'"/>
                                                
                                                <input type="hidden" name="number_days" class="diff'. $ID .'"/>';

            $tmbooking_result .= '              <script>
                                                    jQuery.noConflict()(function($) {
                                                          var templines_date_class = [];
                                                          templines_date_class = ' . $disable_dates_js . ';
                                                            
                                                          $(".tm_booking_date'. $ID .'").daterangepicker(
                                                          {
                                                          
                                                                drops: "' . $booking_settings["drops"] . '", 
                                                                showWeekNumbers: ' . $booking_settings["showWeekNumbers"] . ',
                                                                showISOWeekNumbers: ' . $booking_settings["showISOWeekNumbers"] . ',
                                                                startDate: moment().startOf("hour"),
                                                                minDate: new Date(),
                                                                ' . $hours . '
                                                                locale: { 
                                                                    format: "'. $booking_settings["date_format"] . '",
                                                                    "applyLabel": "' . __("Apply", "tm-booking") . '",
                                                                    "cancelLabel": "' . __("Cancel", "tm-booking") . '",
                                                                    "fromLabel": "' . __("From", "tm-booking") . '",
                                                                    "toLabel": "' . __("To", "tm-booking") . '",
                                                                    "customRangeLabel": "' . __("Custom", "tm-booking") . '",
                                                                    "weekLabel": "' . __("W", "tm-booking") . '",
                                                                    "daysOfWeek": [
                                                                        "' . __("Su", "tm-booking") . '",
                                                                        "' . __("Mo", "tm-booking") . '",
                                                                        "' . __("Tu", "tm-booking") . '",
                                                                        "' . __("We", "tm-booking") . '",
                                                                        "' . __("Th", "tm-booking") . '",
                                                                        "' . __("Fr", "tm-booking") . '",
                                                                        "' . __("Sa", "tm-booking") . '"
                                                                    ],
                                                                    "monthNames": [
                                                                        "' . __("January", "tm-booking") . '",
                                                                        "' . __("February", "tm-booking") . '",
                                                                        "' . __("March", "tm-booking") . '",
                                                                        "' . __("April", "tm-booking") . '",
                                                                        "' . __("May", "tm-booking") . '",
                                                                        "' . __("June", "tm-booking") . '",
                                                                        "' . __("July", "tm-booking") . '",
                                                                        "' . __("August", "tm-booking") . '",
                                                                        "' . __("September", "tm-booking") . '",
                                                                        "' . __("October", "tm-booking") . '",
                                                                        "' . __("November", "tm-booking") . '",
                                                                        "' . __("December", "tm-booking") . '"
                                                                    ],
                                                                },
                                                                
                                                                  isInvalidDate: function(ele) {
                                                                var currDate = moment(ele._d).format("'. $booking_settings["date_format"] . '");
                                                                return templines_date_class.indexOf(currDate) != -1;
                                                            }, 
                                                          }, function(start, end, label) {
                                                                                                                        

                                                               $(".start_date'. $ID .'").val(start.format("' . $booking_settings["date_format"] . '"));
                                                               $(".end_date'. $ID .'").val(end.format("' . $booking_settings["date_format"] . '"));
                                                                 
                                                               $(".start_time'. $ID .'").val(start.format("HH:mm"));
                                                               $(".end_time'. $ID .'").val(end.format("HH:mm"));
                                                                 
                                                                var unindexed_array = jQuery(".booking_form'. $ID .'").serializeArray();
                                                                var indexed_array = {};
                                                                var extra_ids_val = "";
                                                               
                                                                $.map(unindexed_array, function(n, i){
                                                                    indexed_array[n["name"]] = n["value"];
                                                                    if(n["name"] === "extra[]"){
                                                                        extra_ids_val += n["value"] + ",";
                                                                    } 
                                                                    indexed_array["extra_ids"] = extra_ids_val.slice(0,-1);
                                                                });
                                                                formData = indexed_array;
                                                                var data = {
                                                                    action: "tmbooking_change_total",
                                                                    data: formData
                                                                };
                                                                
                                                                $.post( tm_booking_ajax.url, data, function(response) {
                                                                    ' . $btn_disable_script . '
                                                                     $(".tm_price_total'. $ID .'").html(response.html);
                                                                     $(".booking_form'. $ID .' .book_now_btn").html(response.deposit_price);

                                                                });
                                                                
                                                          })
                                                          
                                                    });
                                                 </script>';

            // Check if containers are empty for style_three
            $location_empty = empty(trim($location_html));
            $dr_location_empty = empty(trim($location_dr_html));
            $extra_empty = empty(trim($extra_html));
            $discount_empty = empty(trim($discount_html));
            
            // Add tm_empty_container class for empty containers
            $location_class = $location_empty ? ' tm_empty_container' : '';
            $dr_location_class = $dr_location_empty ? ' tm_empty_container' : '';
            $extra_class = $extra_empty ? ' tm_empty_container' : '';
            $discount_class = $discount_empty ? ' tm_empty_container' : '';
            
            $tmbooking_result .= '              </span>
                                            <span class="tm_input_container tm_location_input' . $location_class . '">
                                                ' . $location_html . '
                                            </span>
                                            <span class="tm_input_container tm_dr_location_input' . $dr_location_class . '">
                                                ' . $location_dr_html . '
                                            </span>
                                            
                                            ' . $extra_html . '
                                            
                                            <span class="tm_input_container tm_discount_input tm_discount_input'. $ID . $discount_class . '">
                                                 ' . $discount_html . '
                                            </span>
                                            
                                            <span class="booking_count booking_count'. $ID .'"></span>
                                            
                                            <span class="tm_input_container tm_price_total tm_price_total'. $ID .' tm_empty_container"></span>
                                            
                                            <button class="book_now_btn" disabled="disabled" onclick="return false;" data-wait="' . __('Please wait', 'tm-booking') . '">' . tmbooking_get_book_now_text($ID) . '</button>
                                        </form>
                                </div>';
            $tmbooking_result .= '</div>';
            $tmbooking_result .= '</div>';
        } elseif ($style == 'style_four'){

            $tmbooking_result .= '<div class="tm_equipment-booking equipment-booking equipment-booking-' . $style . '">';
            $tmbooking_result .= '<div class="rental-item__price">';
            $tmbooking_result .= '<div class="rental-item__price-btn">
                                       <form class="details-aside-content__inner booking_form booking_form' . $ID . '" data-id="' . $ID . '">
                                           <input type="hidden" class="hidden_id" name="id" value="'. $ID .'"/>
                                           <div class="details-aside-content__datapicker">
                                                <input type="text" id="tm_booking_date'. $ID .'" value="25/08/2022 - 16/09/2022" class="hasDatepicker tm_booking_date tm_booking_date'. $ID .'" placeholder="'.__("Select Dates", "tm-booking") . '">
                                                 
                                                <input type="hidden" name="start_date" class="start_date start_date'. $ID .'"/>
                                                <input type="hidden" name="end_date" class="end_date end_date'. $ID .'"/>
                                                
                                                <input type="hidden" name="start_time" class="start_time start_time'. $ID .'"/>
                                                <input type="hidden" name="end_time" class="end_time end_time'. $ID .'"/>
                                                
                                                <input type="hidden" name="number_days" class="diff'. $ID .'"/>
                                                
                                                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                    <path d="M19 4H5C3.89543 4 3 4.89543 3 6V20C3 21.1046 3.89543 22 5 22H19C20.1046 22 21 21.1046 21 20V6C21 4.89543 20.1046 4 19 4Z" stroke="white" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path>
                                                    <path d="M16 2V6" stroke="white" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path>
                                                    <path d="M8 2V6" stroke="white" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path>
                                                    <path d="M3 10H21" stroke="white" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path>
                                                </svg>
                                            </div>';

            $tmbooking_result .= '              <script>
                                                jQuery.noConflict()(function($) {
                                                      var templines_date_class = [];
                                                      templines_date_class = ' . $disable_dates_js . ';
                                                      $(".tm_booking_date'. $ID .'").daterangepicker(
                                                      {
                                                            drops: "' . $booking_settings["drops"] . '",  
                                                            showWeekNumbers: ' . $booking_settings["showWeekNumbers"] . ',
                                                            showISOWeekNumbers: ' . $booking_settings["showISOWeekNumbers"] . ',  
                                                            startDate: moment().startOf("hour"),
                                                            minDate: new Date(), 
                                                            
                                                              isInvalidDate: function(ele) {
                                                                var currDate = moment(ele._d).format("'. $booking_settings["date_format"] . '");
                                                                return templines_date_class.indexOf(currDate) != -1;
                                                            },
                                                            
                                                            
                                                            ' . $hours . '
                                                            '. $disable_days .' 
                                                            locale: { 
                                                                format:"'. $booking_settings["date_format"] . '",
                                                                "applyLabel": "' . __("Apply", "tm-booking") . '",
                                                                "cancelLabel": "' . __("Cancel", "tm-booking") . '",
                                                                "fromLabel": "' . __("From", "tm-booking") . '",
                                                                "toLabel": "' . __("To", "tm-booking") . '",
                                                                "customRangeLabel": "' . __("Custom", "tm-booking") . '",
                                                                "weekLabel": "' . __("W", "tm-booking") . '",
                                                                "daysOfWeek": [
                                                                    "' . __("Su", "tm-booking") . '",
                                                                    "' . __("Mo", "tm-booking") . '",
                                                                    "' . __("Tu", "tm-booking") . '",
                                                                    "' . __("We", "tm-booking") . '",
                                                                    "' . __("Th", "tm-booking") . '",
                                                                    "' . __("Fr", "tm-booking") . '",
                                                                    "' . __("Sa", "tm-booking") . '"
                                                                ],
                                                                "monthNames": [
                                                                    "' . __("January", "tm-booking") . '",
                                                                    "' . __("February", "tm-booking") . '",
                                                                    "' . __("March", "tm-booking") . '",
                                                                    "' . __("April", "tm-booking") . '",
                                                                    "' . __("May", "tm-booking") . '",
                                                                    "' . __("June", "tm-booking") . '",
                                                                    "' . __("July", "tm-booking") . '",
                                                                    "' . __("August", "tm-booking") . '",
                                                                    "' . __("September", "tm-booking") . '",
                                                                    "' . __("October", "tm-booking") . '",
                                                                    "' . __("November", "tm-booking") . '",
                                                                    "' . __("December", "tm-booking") . '"
                                                                ],
                                                            },

                                                      }, function(start, end, label) {
                                                      
                                                           $(".start_date'. $ID .'").val(start.format("' . $booking_settings["date_format"] . '"));
                                                           $(".end_date'. $ID .'").val(end.format("' . $booking_settings["date_format"] . '"));
                                                             
                                                           $(".start_time'. $ID .'").val(start.format("HH:mm"));
                                                           $(".end_time'. $ID .'").val(end.format("HH:mm"));
                                                             
                                                            var unindexed_array = jQuery(".booking_form'. $ID .'").serializeArray();
                                                            var indexed_array = {};
                                                            var extra_ids_val = "";
                                                           
                                                            $.map(unindexed_array, function(n, i){
                                                                indexed_array[n["name"]] = n["value"];
                                                                if(n["name"] === "extra[]"){
                                                                    extra_ids_val += n["value"] + ",";
                                                                } 
                                                                indexed_array["extra_ids"] = extra_ids_val.slice(0,-1);
                                                            });
                                                            formData = indexed_array;
                                                            var data = {
                                                                action: "tmbooking_change_total",
                                                                data: formData
                                                            };

                                                            $.post( tm_booking_ajax.url, data, function(response) {
                                                                console.log(response);
                                                                
                                                                ' . $btn_disable_script . '
                                                                 $(".tm_price_total'. $ID .'").html(response);
                                                            });
                                                      })
                                                });
                                             </script>';


            $tmbooking_result .= '              ' . $location_html . '
                                            
                                            ' . $location_del_html . '
                                            
                                            ' . $extra_html . '
                                            
                                            <span class="tm_input_container tm_discount_input tm_discount_input'. $ID .'">
                                                 ' . $discount_html . '
                                            </span>
                                            
                                            <span class="booking_count booking_count'. $ID .'"></span>
                                            
                                            <div class="min-days-info-container">
                                                ' . apply_filters('tmbooking_before_book_now_button', '', $ID) . '
                                                </div>

<div class="details-aside-content__total tm_input_container tm_price_total tm_price_total'. $ID .'"></div>
                                            <button class="book_now_btn details-aside-content__button" disabled="disabled" onclick="return false;" data-wait="' . __('Please wait', 'tm-booking') . '">
                                            <span>' . tmbooking_get_book_now_text($ID) . '</span>
                                            <span>
                                                <svg width="18" height="18" viewBox="0 0 18 18" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                    <path d="M3.75 9H14.25" stroke="white" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path>
                                                    <path d="M9 3.75L14.25 9L9 14.25" stroke="white" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path>
                                                </svg>
                                            </span>
                                            </button>
                                        </form>
                                </div>';
            $tmbooking_result .= '</div>';
            $tmbooking_result .= '</div>';
        } elseif ($style == 'style_five'){
            $tmbooking_result .= '<div class="tm_equipment-booking equipment-booking equipment-booking-' . $style . '">';

                $tmbooking_result .= '<div class="rental-item__price">';
                $tmbooking_result .= '<div class="rental-item__price-btn">
                                       <form class="details-aside-content__inner booking_form booking_form' . $ID . '" data-id="' . $ID . '">
                                           <input type="hidden" class="hidden_id" name="id" value="'. $ID .'"/>
                                           <div class="details-aside-content__datapicker">
                                                <input type="text" id="tm_booking_date'. $ID .'" value="25/08/2022 - 16/09/2022" class="hasDatepicker tm_booking_date tm_booking_date'. $ID .'" placeholder="'.__("Select Dates", "tm-booking") . '">
                                                 
                                                <input type="hidden" name="start_date" class="start_date start_date'. $ID .'"/>
                                                <input type="hidden" name="end_date" class="end_date end_date'. $ID .'"/>
                                                
                                                <input type="hidden" name="start_time" class="start_time start_time'. $ID .'"/>
                                                <input type="hidden" name="end_time" class="end_time end_time'. $ID .'"/>
                                                
                                                <input type="hidden" name="number_days" class="diff'. $ID .'"/>
                                                
                                                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                    <path d="M19 4H5C3.89543 4 3 4.89543 3 6V20C3 21.1046 3.89543 22 5 22H19C20.1046 22 21 21.1046 21 20V6C21 4.89543 20.1046 4 19 4Z" stroke="white" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path>
                                                    <path d="M16 2V6" stroke="white" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path>
                                                    <path d="M8 2V6" stroke="white" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path>
                                                    <path d="M3 10H21" stroke="white" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path>
                                                </svg>
                                            </div>';

                $tmbooking_result .= '<script>
                                                jQuery.noConflict()(function($) {
                                                      var templines_date_class = [];
                                                      templines_date_class = ' . $disable_dates_js . ';
                                                      jQuery(".tm_booking_date'. $ID .'").daterangepicker(
                                                      {
                                                            drops: "' . $booking_settings["drops"] . '",  
                                                            showWeekNumbers: ' . $booking_settings["showWeekNumbers"] . ',
                                                            showISOWeekNumbers: ' . $booking_settings["showISOWeekNumbers"] . ',  
                                                            startDate: moment().startOf("hour"),
                                                            minDate: new Date(), 
                                                            isInvalidDate: function(ele) {
                                                                var currDate = moment(ele._d).format("'. $booking_settings["date_format"] . '");
                                                                return templines_date_class.indexOf(currDate) != -1;
                                                            },
                                                            ' . $hours . '
                                                            '. $disable_days .' 
                                                            locale: { 
                                                                format:"'. $booking_settings["date_format"] . '",
                                                                "applyLabel": "' . __("Apply", "tm-booking") . '",
                                                                "cancelLabel": "' . __("Cancel", "tm-booking") . '",
                                                                "fromLabel": "' . __("From", "tm-booking") . '",
                                                                "toLabel": "' . __("To", "tm-booking") . '",
                                                                "customRangeLabel": "' . __("Custom", "tm-booking") . '",
                                                                "weekLabel": "' . __("W", "tm-booking") . '",
                                                                "daysOfWeek": [
                                                                    "' . __("Su", "tm-booking") . '",
                                                                    "' . __("Mo", "tm-booking") . '",
                                                                    "' . __("Tu", "tm-booking") . '",
                                                                    "' . __("We", "tm-booking") . '",
                                                                    "' . __("Th", "tm-booking") . '",
                                                                    "' . __("Fr", "tm-booking") . '",
                                                                    "' . __("Sa", "tm-booking") . '"
                                                                ],
                                                                "monthNames": [
                                                                    "' . __("January", "tm-booking") . '",
                                                                    "' . __("February", "tm-booking") . '",
                                                                    "' . __("March", "tm-booking") . '",
                                                                    "' . __("April", "tm-booking") . '",
                                                                    "' . __("May", "tm-booking") . '",
                                                                    "' . __("June", "tm-booking") . '",
                                                                    "' . __("July", "tm-booking") . '",
                                                                    "' . __("August", "tm-booking") . '",
                                                                    "' . __("September", "tm-booking") . '",
                                                                    "' . __("October", "tm-booking") . '",
                                                                    "' . __("November", "tm-booking") . '",
                                                                    "' . __("December", "tm-booking") . '"
                                                                ],
                                                            },

                                                      }, function(start, end, label) {

                                                           jQuery(".start_date'. $ID .'").val(start.format("' . $booking_settings["date_format"] . '"));
                                                           jQuery(".end_date'. $ID .'").val(end.format("' . $booking_settings["date_format"] . '"));
                                                             
                                                           jQuery(".start_time'. $ID .'").val(start.format("HH:mm"));
                                                           jQuery(".end_time'. $ID .'").val(end.format("HH:mm"));
                                                            var unindexed_array = jQuery(".booking_form'. $ID .'").serializeArray();
                                                            var indexed_array = {};
                                                            var extra_ids_val = "";
                                                           
                                                            jQuery.map(unindexed_array, function(n, i){
                                                                indexed_array[n["name"]] = n["value"];
                                                                if(n["name"] === "extra[]"){
                                                                    extra_ids_val += n["value"] + ",";
                                                                } 
                                                                indexed_array["extra_ids"] = extra_ids_val.slice(0,-1);
                                                            });
                                                            formData = indexed_array;
                                                            var data = {
                                                                action: "tmbooking_change_total",
                                                                data: formData
                                                            };

                                                            jQuery.post( tm_booking_ajax.url, data, function(response) {
                                                                console.log(response);
                                                                
                                                                ' . $btn_disable_script . '
                                                                 jQuery(".tm_price_total'. $ID .'").html(response);
                                                            });
                                                      })
                                                });
                                             </script>';
                                            $tmbooking_result .= '              ' . $location_html . '
                                            
                                            ' . $location_dr_html . '
                                            
                                            ' . $extra_html .'
                                            
                                            <span class="tm_input_container tm_discount_input tm_discount_input'. $ID .'">
                                                 ' . $discount_html . '
                                            </span>
                                            
                                            <span class="booking_count booking_count'. $ID .'"></span>
                                            
                                            <div class="min-days-info-container">
                                            ' . apply_filters('tmbooking_before_book_now_button', '', $ID) . '
                                            </div>

                                            <div class="details-aside-content__total tm_input_container tm_price_total tm_price_total'. $ID .'"></div>
                                            
                                            <button class="book_now_btn details-aside-content__button" disabled="disabled" onclick="return false;" data-wait="' . __('Please wait', 'tm-booking') . '">
                                            <span>' . tmbooking_get_book_now_text($ID) . '</span>
                                            <span>
                                                <svg width="18" height="18" viewBox="0 0 18 18" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                    <path d="M3.75 9H14.25" stroke="white" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path>
                                                    <path d="M9 3.75L14.25 9L9 14.25" stroke="white" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path>
                                                </svg>
                                            </span>
                                            </button>
                                        </form>
                                </div>';
                $tmbooking_result .= '</div>';
                $tmbooking_result .= '</div>';
        } elseif ($style == 'style_six'){
            $tmbooking_result .= '<div class="single-property-item-aside">';
            $tmbooking_result .= '<div class="widget widget-property-rent-form">';
            $tmbooking_result .= '<h5 class="widget--title-wrap">
                                    ' . $title . '
                                    <span class="widget--subtitle subtitle-after-inside templines-font-style-normal">' . $subtitle . '</span>
                                </h5>';
            $tmbooking_result .= '<div class="tm_equipment-booking equipment-booking-' . $style . '">';

            $tmbooking_result .= '<div class="rental-item__price">';
            $tmbooking_result .= '<div class="rental-item__price-btn">
                                       <form class="details-aside-content__inner booking_form booking_form' . $ID . '" data-id="' . $ID . '">
                                           <input type="hidden" class="hidden_id" name="id" value="'. $ID .'"/>
                                           <div class="details-aside-content__datapicker">
                                                <input type="text" id="tm_booking_date'. $ID .'" value="25/08/2022 - 16/09/2022" class="hasDatepicker tm_booking_date tm_booking_date'. $ID .'" placeholder="'.__("Select Dates", "tm-booking") . '">
                                                 
                                                <input type="hidden" name="start_date" class="start_date start_date'. $ID .'"/>
                                                <input type="hidden" name="end_date" class="end_date end_date'. $ID .'"/>
                                                
                                                <input type="hidden" name="start_time" class="start_time start_time'. $ID .'"/>
                                                <input type="hidden" name="end_time" class="end_time end_time'. $ID .'"/>
                                                
                                                <input type="hidden" name="number_days" class="diff'. $ID .'"/>
                                            </div>';

            $tmbooking_result .= '<script>
                                                jQuery.noConflict()(function($) {
                                                      var templines_date_class = [];
                                                      templines_date_class = ' . $disable_dates_js . ';
                                                      jQuery(".tm_booking_date'. $ID .'").daterangepicker(
                                                      {
                                                            drops: "' . $booking_settings["drops"] . '",  
                                                            showWeekNumbers: ' . $booking_settings["showWeekNumbers"] . ',
                                                            showISOWeekNumbers: ' . $booking_settings["showISOWeekNumbers"] . ',  
                                                            startDate: moment().startOf("hour"),
                                                            minDate: new Date(), 
                                                            isInvalidDate: function(ele) {
                                                                var currDate = moment(ele._d).format("'. $booking_settings["date_format"] . '");
                                                                return templines_date_class.indexOf(currDate) != -1;
                                                            },
                                                            ' . $hours . '
                                                            '. $disable_days .' 
                                                            locale: { 
                                                                format:"'. $booking_settings["date_format"] . '",
                                                                "applyLabel": "' . __("Apply", "tm-booking") . '",
                                                                "cancelLabel": "' . __("Cancel", "tm-booking") . '",
                                                                "fromLabel": "' . __("From", "tm-booking") . '",
                                                                "toLabel": "' . __("To", "tm-booking") . '",
                                                                "customRangeLabel": "' . __("Custom", "tm-booking") . '",
                                                                "weekLabel": "' . __("W", "tm-booking") . '",
                                                                "daysOfWeek": [
                                                                    "' . __("Su", "tm-booking") . '",
                                                                    "' . __("Mo", "tm-booking") . '",
                                                                    "' . __("Tu", "tm-booking") . '",
                                                                    "' . __("We", "tm-booking") . '",
                                                                    "' . __("Th", "tm-booking") . '",
                                                                    "' . __("Fr", "tm-booking") . '",
                                                                    "' . __("Sa", "tm-booking") . '"
                                                                ],
                                                                "monthNames": [
                                                                    "' . __("January", "tm-booking") . '",
                                                                    "' . __("February", "tm-booking") . '",
                                                                    "' . __("March", "tm-booking") . '",
                                                                    "' . __("April", "tm-booking") . '",
                                                                    "' . __("May", "tm-booking") . '",
                                                                    "' . __("June", "tm-booking") . '",
                                                                    "' . __("July", "tm-booking") . '",
                                                                    "' . __("August", "tm-booking") . '",
                                                                    "' . __("September", "tm-booking") . '",
                                                                    "' . __("October", "tm-booking") . '",
                                                                    "' . __("November", "tm-booking") . '",
                                                                    "' . __("December", "tm-booking") . '"
                                                                ],
                                                            },

                                                      }, function(start, end, label) {

                                                           jQuery(".start_date'. $ID .'").val(start.format("' . $booking_settings["date_format"] . '"));
                                                           jQuery(".end_date'. $ID .'").val(end.format("' . $booking_settings["date_format"] . '"));
                                                             
                                                           jQuery(".start_time'. $ID .'").val(start.format("HH:mm"));
                                                           jQuery(".end_time'. $ID .'").val(end.format("HH:mm"));
                                                            var unindexed_array = jQuery(".booking_form'. $ID .'").serializeArray();
                                                            var indexed_array = {};
                                                            var extra_ids_val = "";
                                                           
                                                            jQuery.map(unindexed_array, function(n, i){
                                                                indexed_array[n["name"]] = n["value"];
                                                                if(n["name"] === "extra[]"){
                                                                    extra_ids_val += n["value"] + ",";
                                                                } 
                                                                indexed_array["extra_ids"] = extra_ids_val.slice(0,-1);
                                                            });
                                                            formData = indexed_array;
                                                            var data = {
                                                                action: "tmbooking_change_total",
                                                                data: formData
                                                            };
                                                            jQuery.post( tm_booking_ajax.url, data, function(response) {
                                                                console.log(response);
                                                                
                                                                ' . $btn_disable_script . '
                                                                 jQuery(".tm_price_total'. $ID .'").html(response);
                                                            });
                                                      })
                                                });
                                             </script>';
            $tmbooking_result .= '              ' . $location_html . '
                                            
                                            ' . $location_dr_html . '
                                            
                                            ' . $extra_basic_html .'
                                            ' . $extra_html .'
                                            
                                            <span class="tm_input_container tm_discount_input tm_discount_input'. $ID .'">
                                                 ' . $discount_html . '
                                            </span>
                                            
                                            <span class="booking_count booking_count'. $ID .'"></span>
                                            
                                            <div class="min-days-info-container">
                                            ' . apply_filters('tmbooking_before_book_now_button', '', $ID) . '
                                            </div>

                                            <div class="details-aside-content__total tm_input_container tm_price_total tm_price_total'. $ID .'"></div>
                                            
                                            
                                            <button class="templines-default-btn-style templines-primary-btn-style templines-small-btn-style templines-submit-btn book_now_btn" type="submit" disabled="disabled" onclick="return false;" data-wait="' . __('Please wait', 'tm-booking') . '">
                                                <div><span data-hover-text="' . tmbooking_get_book_now_text($ID) . '">' . tmbooking_get_book_now_text($ID) . '</span></div>
                                            </button>
                                            
                                            
                                            </button>
                                        </form>
                                </div>';
            $tmbooking_result .= '</div>';
            $tmbooking_result .= '</div>';
            $tmbooking_result .= '</div>';
            $tmbooking_result .= '</div>';
        } else {
            $tmbooking_result .= '<div class="rental-item__price">';
            $tmbooking_result .= '<div class="rental-item__price-btn">
                                       <form class="details-aside-content__inner booking_form booking_form' . $ID . '" data-id="' . $ID . '">
                                           <input type="hidden" class="hidden_id" name="id" value="'. $ID .'"/>
                                           <div class="details-aside-content__datapicker">
                                                <input type="text" id="tm_booking_date'. $ID .'" value="25/08/2022 - 16/09/2022" class="hasDatepicker tm_booking_date tm_booking_date'. $ID .'" placeholder="'.__("Select Dates", "tm-booking") . '">
                                                 
                                                <input type="hidden" name="start_date" class="start_date start_date'. $ID .'"/>
                                                <input type="hidden" name="end_date" class="end_date end_date'. $ID .'"/>
                                                
                                                <input type="hidden" name="start_time" class="start_time start_time'. $ID .'"/>
                                                <input type="hidden" name="end_time" class="end_time end_time'. $ID .'"/>
                                                
                                                <input type="hidden" name="number_days" class="diff'. $ID .'"/>
                                                
                                                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                    <path d="M19 4H5C3.89543 4 3 4.89543 3 6V20C3 21.1046 3.89543 22 5 22H19C20.1046 22 21 21.1046 21 20V6C21 4.89543 20.1046 4 19 4Z" stroke="white" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path>
                                                    <path d="M16 2V6" stroke="white" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path>
                                                    <path d="M8 2V6" stroke="white" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path>
                                                    <path d="M3 10H21" stroke="white" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path>
                                                </svg>
                                            </div>';
            $tmbooking_result .= '<script>
                                                jQuery.noConflict()(function($) {
                                                      var templines_date_class = [];
                                                      templines_date_class = ' . $disable_dates_js . ';
                                                      $(".tm_booking_date'. $ID .'").daterangepicker(
                                                      {
                                                            drops: "' . $booking_settings["drops"] . '",  
                                                            showWeekNumbers: ' . $booking_settings["showWeekNumbers"] . ',
                                                            showISOWeekNumbers: ' . $booking_settings["showISOWeekNumbers"] . ',  
                                                            startDate: moment().startOf("hour"),
                                                            minDate: new Date(), 
                                                            isInvalidDate: function(ele) {
                                                                var currDate = moment(ele._d).format("'. $booking_settings["date_format"] . '");
                                                                return templines_date_class.indexOf(currDate) != -1;
                                                            },
                                                            
                                                            ' . $hours . '
                                                            '. $disable_days .' 
                                                            locale: { 
                                                                format:"'. $booking_settings["date_format"] . '",
                                                                "applyLabel": "' . __("Apply", "tm-booking") . '",
                                                                "cancelLabel": "' . __("Cancel", "tm-booking") . '",
                                                                "fromLabel": "' . __("From", "tm-booking") . '",
                                                                "toLabel": "' . __("To", "tm-booking") . '",
                                                                "customRangeLabel": "' . __("Custom", "tm-booking") . '",
                                                                "weekLabel": "' . __("W", "tm-booking") . '",
                                                                "daysOfWeek": [
                                                                    "' . __("Su", "tm-booking") . '",
                                                                    "' . __("Mo", "tm-booking") . '",
                                                                    "' . __("Tu", "tm-booking") . '",
                                                                    "' . __("We", "tm-booking") . '",
                                                                    "' . __("Th", "tm-booking") . '",
                                                                    "' . __("Fr", "tm-booking") . '",
                                                                    "' . __("Sa", "tm-booking") . '"
                                                                ],
                                                                "monthNames": [
                                                                    "' . __("January", "tm-booking") . '",
                                                                    "' . __("February", "tm-booking") . '",
                                                                    "' . __("March", "tm-booking") . '",
                                                                    "' . __("April", "tm-booking") . '",
                                                                    "' . __("May", "tm-booking") . '",
                                                                    "' . __("June", "tm-booking") . '",
                                                                    "' . __("July", "tm-booking") . '",
                                                                    "' . __("August", "tm-booking") . '",
                                                                    "' . __("September", "tm-booking") . '",
                                                                    "' . __("October", "tm-booking") . '",
                                                                    "' . __("November", "tm-booking") . '",
                                                                    "' . __("December", "tm-booking") . '"
                                                                ],
                                                            },

                                                      }, function(start, end, label) {
                                                      
                                                           $(".start_date'. $ID .'").val(start.format("' . $booking_settings["date_format"] . '"));
                                                           $(".end_date'. $ID .'").val(end.format("' . $booking_settings["date_format"] . '"));
                                                             
                                                           $(".start_time'. $ID .'").val(start.format("HH:mm"));
                                                           $(".end_time'. $ID .'").val(end.format("HH:mm"));
                                                             console.log(unindexed_array);
                                                            var unindexed_array = jQuery(".booking_form'. $ID .'").serializeArray();
                                                            var indexed_array = {};
                                                            var extra_ids_val = "";
                                                           
                                                            $.map(unindexed_array, function(n, i){
                                                                indexed_array[n["name"]] = n["value"];
                                                                if(n["name"] === "extra[]"){
                                                                    extra_ids_val += n["value"] + ",";
                                                                } 
                                                                indexed_array["extra_ids"] = extra_ids_val.slice(0,-1);
                                                            });
                                                            formData = indexed_array;
                                                            var data = {
                                                                action: "tmbooking_change_total",
                                                                data: formData
                                                            };

                                                            $.post( tm_booking_ajax.url, data, function(response) {
                                                                console.log(response);
                                                                
                                                                ' . $btn_disable_script . '
                                                                 $(".tm_price_total'. $ID .'").html(response);
                                                            });
                                                      })
                                                });
                                             </script>';
            $tmbooking_result .= '      ' . $location_html . '
                                    
                                    ' . $location_dr_html . '
                                    
                                    ' . $extra_html .'
                                    
                                    <span class="tm_input_container tm_discount_input tm_discount_input'. $ID .'">
                                         ' . $discount_html . '
                                    </span>
                                    <span class="booking_count booking_count'. $ID .'"></span>
                                    <div class="min-days-info-container">
' . apply_filters('tmbooking_before_book_now_button', '', $ID) . '
</div>

<div class="details-aside-content__total tm_input_container tm_price_total tm_price_total'. $ID .'"></div>
                                    <button class="book_now_btn details-aside-content__button" disabled="disabled" onclick="return false;" data-wait="' . __('Please wait', 'tm-booking') . '">
                                    <span>' . tmbooking_get_book_now_text($ID) . '</span>
                                    <span>
                                        <svg width="18" height="18" viewBox="0 0 18 18" fill="none" xmlns="http://www.w3.org/2000/svg">
                                            <path d="M3.75 9H14.25" stroke="white" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path>
                                            <path d="M9 3.75L14.25 9L9 14.25" stroke="white" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path>
                                        </svg>
                                    </span>
                                    </button>
                                </form>
                                </div>';
            $tmbooking_result .= '</div>';
        }

    }

    return $tmbooking_result;
}
add_shortcode( 'tm_booking', 'tmbooking_book_form_shortcode' );

function tmbooking_get_price_shortcode($atts){
    if(isset($atts['id']) && $atts['id'] != ''){
        $ID = $atts['id'];
    } else {
        $ID = get_the_ID();
    }
    if(isset($atts['style']) && $atts['style'] != '') {
        $style = $atts['style'];
    }else {
        $style = 'style_one';
    }

    $show_calculate_price = tmbooking_get_metabox( 'price_section_show_calculate_price', $ID );
    $price = tmbooking_get_metabox( 'price_section_price_per'.$show_calculate_price, $ID );
    $per_html =  '<span class="show_calculate_price">' . __(' per/', 'tm-booking') . $show_calculate_price . '</span>';
    $booking_settings = get_option('tm_booking_settings', true);

    $discount_percent = tmbooking_get_discount_percent_all($ID);
    $discount_price = tmbooking_change_price_by_discount($price, $discount_percent);
    $currency_pos = get_option( 'woocommerce_currency_pos' );
    if(class_exists('WooCommerce')){
        $currency_symbol_html = '<span class="tm_booking_currency_symbol ' . $currency_pos . '">' . get_woocommerce_currency_symbol() . '</span>';
    }

    $price_html = '';
    if($style == 'style_one'){
        $price_html .= '<div id="booking_car_info" class="tm_booking_car_info booking_car_info booking_car_info_' . $style . '">';
            $price_html .= '<div class="auto-price-info">';
                $price_html .= '<div class="car-price top-info fl-primary-bg">';
                    $price_html .= '<span class="price-text">' . __('Price', 'tm-booking') .'</span>';
                    $price_html .= '<span class="price-detail fl-font-style-bolt">';
                            $per = '';
                            switch ($show_calculate_price) {
                                case 'day':
                                    $per =  __("/Day", "tm-booking");
                                    break;
                                case 'hour':
                                    $per =  __("/Hour", "tm-booking");
                                    break;
                                case 'week':
                                    $per =  __("/Week", "tm-booking");
                                    break;
                                case 'month':
                                    $per =  __("/Month", "tm-booking");
                                    break;
                            }
                            $price_html .= '<div class="equipment-order__price">';
                                $price_html .= '<span class="current-price">';
                                if(isset($discount_percent) && $discount_percent != 0){
                                    if(class_exists('WooCommerce')){
                                        $price_html .= tmbooking_get_price_with_currency($discount_price) . $per;
                                    } else {
                                        $price_html .= $discount_price . $per;
                                    }
                                } else {
                                    if(class_exists('WooCommerce')){
                                        $price_html .=  tmbooking_get_price_with_currency($price) . $per;
                                    } else {
                                        $price_html .= $price . $per;
                                    }
                                }
                                $price_html .= '</span>';

                                if(isset($discount_percent) && $discount_percent != 0){
                                    $price_html .= '<span class="old-price">';
                                    if(class_exists('WooCommerce')){
                                        $price_html .=  tmbooking_get_price_with_currency($price) . $per;
                                    } else {
                                        $price_html .= $price . $per;
                                    }
                                    $price_html .= '</span>';
                                }

                            $price_html .= '</div>';

                    $price_html .= '</span>';
                $price_html .= '</div>';

                $price_html .= '<ul class="car_premium_price' . (function_exists("tmbooking_get_price_list_visibility_class") ? " " . tmbooking_get_price_list_visibility_class($ID) : "") . '">';;
                if(in_array('calc_hours', $booking_settings['calc_periods'])){
                    $price_hour = tmbooking_get_metabox( 'price_section_price_perhour', $ID );
                }
                if(in_array('calc_days', $booking_settings['calc_periods'])){
                    $price_day = tmbooking_get_metabox( 'price_section_price_perday', $ID );
                }
                if(in_array('calc_week', $booking_settings['calc_periods'])){
                    $price_week = tmbooking_get_metabox( 'price_section_price_perweek', $ID );
                }
                if(in_array('calc_month', $booking_settings['calc_periods'])){
                    $price_month = tmbooking_get_metabox( 'price_section_price_permonth', $ID );
                }
                if(tmbooking_get_metabox( 'price_section_price_perhour', $ID) != '' && isset($price_hour) && $price_hour != ''){
                    $price_html .= '<li class="list-grid-item fl-font-style-regular '.esc_attr($show_calculate_price == 'hour' ? 'list-grid-item-show-price' : '').'">' . tmbooking_get_price_with_currency($price_hour) . __(" / Hour", "tm-booking") . '</li>';
                }
                if(tmbooking_get_metabox( 'price_section_price_perday', $ID) != '' && isset($price_day) && $price_day != ''){
                    $price_html .= '<li class="list-grid-item fl-font-style-regular '.esc_attr($show_calculate_price == 'day' ? 'list-grid-item-show-price' : '').'">' . tmbooking_get_price_with_currency($price_day) . __(" / Day", "tm-booking") . '</li>';
                }
                if(tmbooking_get_metabox( 'price_section_price_perweek', $ID ) != '' && isset($price_week) && $price_week != ''){
                    $price_html .= '<li class="list-grid-item fl-font-style-regular '.esc_attr($show_calculate_price == 'week' ? 'list-grid-item-show-price' : '').'">' . tmbooking_get_price_with_currency($price_week) . __(" / Week", "tm-booking"). '</li>';
                }
                if(tmbooking_get_metabox( 'price_section_price_permonth', $ID ) != '' && isset($price_month) && $price_month != ''){
                    $price_html .= '<li class="list-grid-item fl-font-style-regular '.esc_attr($show_calculate_price == 'month' ? 'list-grid-item-show-price' : '').'">' . tmbooking_get_price_with_currency($price_month) . __(" / Month", "tm-booking"). '</li>';
                }
                $price_html .= '</ul>';



            $price_html .= '</div>';
        $price_html .= '</div>';


        return $price_html;
    } elseif($style == 'style_two') {
        if ($price != ''){
            $price_html .= '<div id="booking_car_info" class="tm_booking_car_info booking_car_info booking_car_info_' . $style . '">';
                $price_html .= '<div class="equipment-order">';
                    $price_html .= '<div class="equipment-order__title">' . __('[Equipment Current Price]', 'tm-booking') . '</div>';
                        $price_html .= '<div class="equipment-order__price">';
                        $price_html .= '<span class="current-price">';
                        if(isset($discount_percent) && $discount_percent != 0){
                            if(class_exists('WooCommerce')){
                                $price_html .= tmbooking_get_price_with_currency($discount_price);
                            } else {
                                $price_html .= $discount_price;
                            }
                        } else {
                            if(class_exists('WooCommerce')){
                                $price_html .=  tmbooking_get_price_with_currency($price);
                            } else {
                                $price_html .= $price;
                            }
                        }
                        $price_html .= '</span>';
                        if(isset($discount_percent) && $discount_percent != 0){
                            $price_html .= '<span class="old-price">';
                            if(class_exists('WooCommerce')){
                                $price_html .=  tmbooking_get_price_with_currency($price);
                            } else {
                                $price_html .= $price;
                            }
                            $price_html .= '</span>';
                        }
                        $price_html .= '</div>';

                        $price_html .= '<div class="equipment-item__prices">
                                            <ul>';

                        if(in_array('calc_days', $booking_settings['calc_periods'])){
                            $price_day = tmbooking_get_metabox( 'price_section_price_perday', $ID );
                        }
                        if(in_array('calc_weeks', $booking_settings['calc_periods'])){
                            $price_week = tmbooking_get_metabox( 'price_section_price_perweek', $ID );
                        }
                        if(in_array('calc_month', $booking_settings['calc_periods'])){
                            $price_month = tmbooking_get_metabox( 'price_section_price_permonth', $ID );
                        }

                        if(tmbooking_get_metabox( 'price_section_price_perday', $ID ) != '' && isset($price_day) && $price_day != ''){
                            $price_html .= '<li>' . tmbooking_get_price_with_currency($price_day) . __(" / Day", "tm-booking") . '</li>';
                        }
                        if(tmbooking_get_metabox( 'price_section_price_perweek', $ID ) != '' && isset($price_week) && $price_week != ''){
                            $price_html .= '<li>' . tmbooking_get_price_with_currency($price_week) . __(" / Week", "tm-booking"). '</li>';
                        }
                        if(tmbooking_get_metabox( 'price_section_price_permonth', $ID ) != '' && isset($price_month) && $price_month != ''){
                            $price_html .= '<li>' . tmbooking_get_price_with_currency($price_month) . __(" / Month", "tm-booking"). '</li>';
                        }

                        $price_html .= '  </ul>
                                        </div>';

                $price_html .= '</div>';
            $price_html .= '</div>';

            return $price_html;
        }

    } elseif ($style == 'style_three') {
        if ($price != '') {
            $price_html .= '<div id="booking_car_info" class="tm_booking_car_info booking_car_info booking_car_info_' . $style . '">';
            if (in_array('calc_hours', $booking_settings['calc_periods'])) {
                if (tmbooking_get_metabox('price_section_show_calculate_price', $ID) == 'hour') {
                    $price = tmbooking_get_metabox('price_section_price_perhour', $ID);
                }
            }
            if (in_array('calc_days', $booking_settings['calc_periods'])) {
                if (tmbooking_get_metabox('price_section_show_calculate_price', $ID) == 'day') {
                    $price = tmbooking_get_metabox('price_section_price_perday', $ID);
                }
            }
            if (in_array('calc_weeks', $booking_settings['calc_periods'])) {
                if (tmbooking_get_metabox('price_section_show_calculate_price', $ID) == 'week') {
                    $price = tmbooking_get_metabox('price_section_price_perweek', $ID);
                }
            }
            if (in_array('calc_month', $booking_settings['calc_periods'])) {
                if (tmbooking_get_metabox('price_section_show_calculate_price', $ID) == 'month') {
                    $price = tmbooking_get_metabox('price_section_price_permonth', $ID);
                }
            }
            $price_html .= '<p class="details-aside-content-top__price">
                        ' . __("Tool Current Price", "tm-booking") . '
                        <span>
                            ' . tmbooking_get_price_with_currency($price) . '
                        </span>
                    </p>';

            $price_html .= ' <div class="details-aside-content-top__rent">' . tmbooking_get_price_html(get_the_ID(), 'style_all_five') . '</div>';

            $price_html .= '</div>';
            return $price_html;
        }

    } elseif ($style == 'style_four') {
        $price_html .= '<div id="booking_car_info" class="tm_booking_car_info booking_car_info booking_car_info_' . $style . '">';
        $price_html .= '<div class="details-aside-content__top details-aside-content-top">';
            $price_html .= tmbooking_get_price_html(get_the_ID(), 'style_nine');
            $price_html .= '<div class="details-aside-content-top__rent">';
                $price_html .= tmbooking_get_price_html(get_the_ID(), 'style_all_five');
            $price_html .= '</div>';
        $price_html .= '</div>';
        $price_html .= '</div>';
        return $price_html;
    }elseif($style == 'style_five') {
        $price_html .= '<div class="car-price top-info fl-primary-bg">';
        $price_html .= '<div class="price-detail fl-font-style-bolt">';
        $price_html .= '<div class="equipment-order__price">';
        $price_html .= '<span class="current-price">';

        $price_show =  '<span class="prc currency_left">'. $price . ' /' . $show_calculate_price . '</span>';
        if(class_exists('WooCommerce')){
            $price_html .=  tmbooking_get_price_with_currency($price) . '/ ' . $show_calculate_price;
        } else {
            $price_html .= $price_show;
        }

        $price_html .= '</span>';
        $price_html .= '</div>';
        $price_html .= '</div>';
        $price_html .= '</div>';
        return $price_html;
    } elseif($style == 'style_six') {
        if(isset($price) && $price != ''){
            $price_html .= '<span class="b-goods-f__price-group"><span class="b-goods-f__price"><span class="b-goods-f__price-numb">';
            $price_show =  '<span class="prc currency_left">'. $price . ' /' . $show_calculate_price . '</span>';
            if(class_exists('WooCommerce')){
                $price_html .=  tmbooking_get_price_with_currency($price) . ' / ' . $show_calculate_price;
            } else {
                $price_html .= $price_show;
            }

            $price_html .= '</span></span></span>';
        }

        return $price_html;
    } elseif($style == 'style_all') {
        $price_html .= '<div class="equipment-item__prices">
                                <ul>';
        if(in_array('calc_days', $booking_settings['calc_periods'])){
            $price_day = tmbooking_get_metabox( 'price_section_price_perday', $ID );
        }
        if(in_array('calc_weeks', $booking_settings['calc_periods'])){
            $price_week = tmbooking_get_metabox( 'price_section_price_perweek', $ID );
        }
        if(in_array('calc_month', $booking_settings['calc_periods'])) {
            $price_month = tmbooking_get_metabox( 'price_section_price_permonth', $ID );
        }

        if(tmbooking_get_metabox( 'price_section_price_perday', $ID ) != '' && isset($price_day) && $price_day != ''){
            $price_html .= '<li>' . tmbooking_get_price_with_currency($price_day) . __(" / Day", "tm-booking") . '</li>';
        }
        if(tmbooking_get_metabox( 'price_section_price_perweek', $ID ) != '' && isset($price_week) && $price_week != ''){
            $price_html .= '<li>' . tmbooking_get_price_with_currency($price_week) . __(" / Week", "tm-booking"). '</li>';
        }
        if(tmbooking_get_metabox( 'price_section_price_permonth', $ID ) != '' && isset($price_month) && $price_month != ''){
            $price_html .= '<li>' . tmbooking_get_price_with_currency($price_month) . __(" / Month", "tm-booking"). '</li>';
        }
        $price_html .= '  </ul>
                            </div>';
        return $price_html;
    } elseif($style == 'style_all_two') {
        $price_html .= '<ul class="car_premium_price' . (function_exists("tmbooking_get_price_list_visibility_class") ? " " . tmbooking_get_price_list_visibility_class($ID) : "") . '">';;
        if (in_array('calc_days', $booking_settings['calc_periods'])) {
            $price_day = tmbooking_get_metabox('price_section_price_perday', $ID);
        }
        if (in_array('calc_weeks', $booking_settings['calc_periods'])) {
            $price_week = tmbooking_get_metabox('price_section_price_perweek', $ID);
        }
        if (in_array('calc_month', $booking_settings['calc_periods'])) {
            $price_month = tmbooking_get_metabox('price_section_price_permonth', $ID);
        }
        if (tmbooking_get_metabox('price_section_price_perday', $ID) != '' && isset($price_day) && $price_day != '') {
            $price_html .= '<li class="list-grid-item fl-font-style-regular ">' . tmbooking_get_price_with_currency($price_day) . __(" / Day",
                    "tm-booking") . '</li>';
        }
        if (tmbooking_get_metabox('price_section_price_perweek', $ID) != '' && isset($price_week) && $price_week != '') {
            $price_html .= '<li class="list-grid-item fl-font-style-regular ">' . tmbooking_get_price_with_currency($price_week) . __(" / Week",
                    "tm-booking") . '</li>';
        }
        if (tmbooking_get_metabox('price_section_price_permonth', $ID) != '' && isset($price_month) && $price_month != '') {
            $price_html .= '<li class="list-grid-item fl-font-style-regular ">' . tmbooking_get_price_with_currency($price_month) . __(" / Month",
                    "tm-booking") . '</li>';
        }
        $price_html .= '</ul>';
        return $price_html;
    } elseif($style == 'style_all_three') {
        if (in_array('calc_days', $booking_settings['calc_periods'])) {
            $price_day = tmbooking_get_metabox('price_section_price_perday', $ID);
        }
        if (in_array('calc_weeks', $booking_settings['calc_periods'])) {
            $price_week = tmbooking_get_metabox('price_section_price_perweek', $ID);
        }
        if (in_array('calc_month', $booking_settings['calc_periods'])) {
            $price_month = tmbooking_get_metabox('price_section_price_permonth', $ID);
        }

        $price_html .= '<div class="catalog-list-content-item-body-top__box catalog-list-content-item-body-top-box">';
        if (tmbooking_get_metabox('price_section_price_perday', $ID) != '' && isset($price_day) && $price_day != '') {
            $price_html .= '<div class="catalog-list-content-item-body-top-box__inner">
                        <div class="catalog-list-content-item-body-top-box__text">' . __("Rent Per Day", "tm-reviews") . '</div>
                        <div class="catalog-list-content-item-body-top-box__price">'.tmbooking_get_price_with_currency($price_day).'</div>' .
                '</div>';
        }
        if (tmbooking_get_metabox('price_section_price_perweek', $ID) != '' && isset($price_week) && $price_week != '') {
            $price_html .= '<div class="catalog-list-content-item-body-top-box__inner">
                        <div class="catalog-list-content-item-body-top-box__text">' . __("Rent Per Week", "tm-reviews") . '</div>
                        <div class="catalog-list-content-item-body-top-box__price">'.tmbooking_get_price_with_currency($price_week).'</div>' .
                '</div>';
        }
        if (tmbooking_get_metabox('price_section_price_permonth', $ID) != '' && isset($price_month) && $price_month != '') {
            $price_html .= '<div class="catalog-list-content-item-body-top-box__inner">
                        <div class="catalog-list-content-item-body-top-box__text">' . __("Rent Per Month", "tm-reviews") . '</div>
                        <div class="catalog-list-content-item-body-top-box__price">'.tmbooking_get_price_with_currency($price_month).'</div>' .
                '</div>';
        }
        $price_html .= '</div>';

        return $price_html;

    } elseif($style == 'style_seven') {

        if(isset($price) && $price != ''){
            $price_html .= '<p class="catalog-list-content-item-info__box-text">' . __("total rental price Inc. Tax", "tm-reviews") . '</p>';
            $price_html .=  '<div class="catalog-list-content-item-info__box-price">';
            if(class_exists('WooCommerce')){
                $price_html .=  tmbooking_get_price_with_currency($price) . '/' . $show_calculate_price;
            }
            $price_html .= '</div>';
        }

        return $price_html;
    } elseif($style == 'style_eight') {

        if(isset($price) && $price != ''){
            $price_html .= '<p class="catalog-grid-item-content__row-text">' . __("total rental price Inc. Tax", "tm-reviews") . '</p>';
            $price_html .=  '<p class="catalog-grid-item-content__row-price">';
            if(class_exists('WooCommerce')){
                $price_html .=  tmbooking_get_price_with_currency($price) . '/' . $show_calculate_price;
            }
            $price_html .= '</p>';
        }

        return $price_html;
    } elseif($style == 'style_all_four') {
        if (in_array('calc_days', $booking_settings['calc_periods'])) {
            $price_day = tmbooking_get_metabox('price_section_price_perday', $ID);
        }
        if (in_array('calc_weeks', $booking_settings['calc_periods'])) {
            $price_week = tmbooking_get_metabox('price_section_price_perweek', $ID);
        }
        if (in_array('calc_month', $booking_settings['calc_periods'])) {
            $price_month = tmbooking_get_metabox('price_section_price_permonth', $ID);
        }

        $price_html .= '<ul class="catalog-grid-item__rent catalog-grid-item-rent catalog-grid-item-rent--row">';
        if (tmbooking_get_metabox('price_section_price_perday', $ID) != '' && isset($price_day) && $price_day != '') {
            $price_html .= '<li class="catalog-grid-item-rent__item">
                        <p class="catalog-grid-item-rent__text">' . tmbooking_get_price_with_currency($price_day) . __("/Day", "tm-reviews") . '</p>' .
                '</li>';
        }
        if (tmbooking_get_metabox('price_section_price_perweek', $ID) != '' && isset($price_week) && $price_week != '') {
            $price_html .= '<li class="catalog-grid-item-rent__item">
                        <p class="catalog-grid-item-rent__text">' . tmbooking_get_price_with_currency($price_week) . __("/Week", "tm-reviews") . '</p>' .
                '</li>';
        }
        if (tmbooking_get_metabox('price_section_price_permonth', $ID) != '' && isset($price_month) && $price_month != '') {
            $price_html .= '<li class="catalog-grid-item-rent__item">
                        <p class="catalog-grid-item-rent__text">' . tmbooking_get_price_with_currency($price_month) . __("/Month", "tm-reviews") . '</p>' .
                '</li>';
        }
        $price_html .= '</ul>';

        return $price_html;
    } elseif ($style == 'style_nine') {
        if (in_array('calc_hours', $booking_settings['calc_periods'])) {
            if(tmbooking_get_metabox('price_section_show_calculate_price', $ID) == 'hour') {
                $price = tmbooking_get_metabox('price_section_price_perhour', $ID);
            }
        }
        if (in_array('calc_days', $booking_settings['calc_periods'])) {
            if(tmbooking_get_metabox('price_section_show_calculate_price', $ID) == 'day'){
                $price = tmbooking_get_metabox('price_section_price_perday', $ID);
            }
        }
        if (in_array('calc_weeks', $booking_settings['calc_periods'])) {
            if(tmbooking_get_metabox('price_section_show_calculate_price', $ID) == 'week') {
                $price = tmbooking_get_metabox('price_section_price_perweek', $ID);
            }
        }
        if (in_array('calc_month', $booking_settings['calc_periods'])) {
            if(tmbooking_get_metabox('price_section_show_calculate_price', $ID) == 'month') {
                $price = tmbooking_get_metabox('price_section_price_permonth', $ID);
            }
        }
        if(isset($price) && $price != ''){
            $price_html = '<p class="details-aside-content-top__price">
                            ' . __("Tool Current Price", "tm-booking") . '
                            <span>
                                ' . tmbooking_get_price_with_currency($price) . '
                            </span>
                        </p>';
        }

        return $price_html;
    } elseif ($style == 'style_all_five') {

        if (in_array('calc_days', $booking_settings['calc_periods'])) {
            $price_day = tmbooking_get_metabox('price_section_price_perday', $ID);
        }
        if (in_array('calc_weeks', $booking_settings['calc_periods'])) {
            $price_week = tmbooking_get_metabox('price_section_price_perweek', $ID);
        }
        if (in_array('calc_month', $booking_settings['calc_periods'])) {
            $price_month = tmbooking_get_metabox('price_section_price_permonth', $ID);
        }

        if (tmbooking_get_metabox('price_section_price_perday', $ID) != '' && isset($price_day) && $price_day != '') {
            $price_html .= '<p class="details-aside-content-top__rent-text">' . tmbooking_get_price_with_currency($price_day) . __("/Day", "tm-reviews") . '</p>';
        }
        if (tmbooking_get_metabox('price_section_price_perweek', $ID) != '' && isset($price_week) && $price_week != '') {
            $price_html .= '<p class="details-aside-content-top__rent-text">' . tmbooking_get_price_with_currency($price_week) . __("/Week", "tm-reviews") . '</p>';
        }
        if (tmbooking_get_metabox('price_section_price_permonth', $ID) != '' && isset($price_month) && $price_month != '') {
            $price_html .= '<p class="details-aside-content-top__rent-text">' . tmbooking_get_price_with_currency($price_month) . __("/Month", "tm-reviews") . '</p>';
        }


        return $price_html;
    } elseif($style == 'style_revus') {
        $price_html .= '<ul class="car_premium_price' . (function_exists("tmbooking_get_price_list_visibility_class") ? " " . tmbooking_get_price_list_visibility_class($ID) : "") . '">';;
        if(in_array('calc_hours', $booking_settings['calc_periods'])){
            $price_hour = tmbooking_get_metabox( 'price_section_price_perhour', $ID );
        }
        if(in_array('calc_days', $booking_settings['calc_periods'])){
            $price_day = tmbooking_get_metabox( 'price_section_price_perday', $ID );
        }
        if(in_array('calc_week', $booking_settings['calc_periods'])){
            $price_week = tmbooking_get_metabox( 'price_section_price_perweek', $ID );
        }
        if(in_array('calc_month', $booking_settings['calc_periods'])){
            $price_month = tmbooking_get_metabox( 'price_section_price_permonth', $ID );
        }
        if(tmbooking_get_metabox( 'price_section_price_perhour', $ID) != '' && isset($price_hour) && $price_hour != ''){
            $price_html .= '<li class="list-grid-item fl-font-style-regular '.esc_attr($show_calculate_price == 'hour' ? 'list-grid-item-show-price' : '').'">' . tmbooking_get_price_with_currency($price_hour) . __(" / Hour", "tm-booking") . '</li>';
        }
        if(tmbooking_get_metabox( 'price_section_price_perday', $ID) != '' && isset($price_day) && $price_day != ''){
            $price_html .= '<li class="list-grid-item fl-font-style-regular '.esc_attr($show_calculate_price == 'day' ? 'list-grid-item-show-price' : '').'">' . tmbooking_get_price_with_currency($price_day) . __(" / Day", "tm-booking") . '</li>';
        }
        if(tmbooking_get_metabox( 'price_section_price_perweek', $ID ) != '' && isset($price_week) && $price_week != ''){
            $price_html .= '<li class="list-grid-item fl-font-style-regular '.esc_attr($show_calculate_price == 'week' ? 'list-grid-item-show-price' : '').'">' . tmbooking_get_price_with_currency($price_week) . __(" / Week", "tm-booking"). '</li>';
        }
        if(tmbooking_get_metabox( 'price_section_price_permonth', $ID ) != '' && isset($price_month) && $price_month != ''){
            $price_html .= '<li class="list-grid-item fl-font-style-regular '.esc_attr($show_calculate_price == 'month' ? 'list-grid-item-show-price' : '').'">' . tmbooking_get_price_with_currency($price_month) . __(" / Month", "tm-booking"). '</li>';
        }
        $price_html .= '</ul>';
        return $price_html;
    }
}
add_shortcode( 'tm_price', 'tmbooking_get_price_shortcode' );

function tmbooking_get_price_catalog_shortcode($atts){
    if(isset($atts['id']) && $atts['id'] != ''){
        $ID = $atts['id'];
    } else {
        $ID = get_the_ID();
    }
    if(isset($atts['style']) && $atts['style'] != '') {
        $style = $atts['style'];
    }else {
        $style = 'style_one';
    }

    $show_calculate_price = tmbooking_get_metabox( 'price_section_show_calculate_price', $ID );
    $price = tmbooking_get_metabox( 'price_section_price_per'.$show_calculate_price, $ID );
    $per_html =  '<span class="show_calculate_price">' . __(' per/', 'tm-booking') . $show_calculate_price . '</span>';
    $booking_settings = get_option('tm_booking_settings', true);

    $discount_percent = tmbooking_get_discount_percent_all($ID);
    $discount_price = tmbooking_change_price_by_discount($price, $discount_percent);
    $currency_pos = get_option( 'woocommerce_currency_pos' );
    if(class_exists('WooCommerce')){
        $currency_symbol_html = '<span class="tm_booking_currency_symbol ' . $currency_pos . '">' . get_woocommerce_currency_symbol() . '</span>';
    }

    $price_html = '';


    if($style == 'style_one'){
        /*
        $price_html .= '<div id="booking_car_info" class="tm_booking_car_info booking_car_info booking_car_info_' . $style . '">';
        $price_html .= '<div class="auto-price-info">';
        $price_html .= '<div class="car-price top-info fl-primary-bg">';
        $price_html .= '<span class="price-text">' . __('Price', 'tm-booking') .'</span>';
        $price_html .= '<span class="price-detail fl-font-style-bolt">';
        $per = '';
        switch ($show_calculate_price) {
            case 'day':
                $per =  __("/Day", "tm-booking");
                break;
            case 'hour':
                $per =  __("/Hour", "tm-booking");
                break;
            case 'week':
                $per =  __("/Week", "tm-booking");
                break;
            case 'month':
                $per =  __("/Month", "tm-booking");
                break;
        }
        $price_html .= '<div class="equipment-order__price">';
        $price_html .= '<span class="current-price">';
        if(isset($discount_percent) && $discount_percent != 0){
            if(class_exists('WooCommerce')){
                $price_html .= tmbooking_get_price_with_currency($discount_price) . $per;
            } else {
                $price_html .= $discount_price . $per;
            }
        } else {
            if(class_exists('WooCommerce')){
                $price_html .=  tmbooking_get_price_with_currency($price) . $per;
            } else {
                $price_html .= $price . $per;
            }
        }
        $price_html .= '</span>';
        if(isset($discount_percent) && $discount_percent != 0){
            $price_html .= '<span class="old-price">';
            if(class_exists('WooCommerce')){
                $price_html .=  tmbooking_get_price_with_currency($price) . $per;
            } else {
                $price_html .= $price . $per;
            }
            $price_html .= '</span>';
        }
        $price_html .= '</div>';

        $price_html .= '</span>';
        $price_html .= '</div>';

        $price_html .= '<ul class="car_premium_price' . (function_exists("tmbooking_get_price_list_visibility_class") ? " " . tmbooking_get_price_list_visibility_class($ID) : "") . '">';;
        if(in_array('calc_hours', $booking_settings['calc_periods'])){
            $price_hour = tmbooking_get_metabox( 'price_section_price_perhour', $ID );
        }
        if(in_array('calc_days', $booking_settings['calc_periods'])){
            $price_day = tmbooking_get_metabox( 'price_section_price_perday', $ID );
        }
        if(in_array('calc_week', $booking_settings['calc_periods'])){
            $price_week = tmbooking_get_metabox( 'price_section_price_perweek', $ID );
        }
        if(in_array('calc_month', $booking_settings['calc_periods'])){
            $price_month = tmbooking_get_metabox( 'price_section_price_permonth', $ID );
        }
        if(tmbooking_get_metabox( 'price_section_price_perhour', $ID) != '' && isset($price_hour) && $price_hour != ''){
            $price_html .= '<li class="list-grid-item fl-font-style-regular '.esc_attr($show_calculate_price == 'hour' ? 'list-grid-item-show-price' : '').'">' . tmbooking_get_price_with_currency($price_hour) . __(" / Hour", "tm-booking") . '</li>';
        }
        if(tmbooking_get_metabox( 'price_section_price_perday', $ID) != '' && isset($price_day) && $price_day != ''){
            $price_html .= '<li class="list-grid-item fl-font-style-regular '.esc_attr($show_calculate_price == 'day' ? 'list-grid-item-show-price' : '').'">' . tmbooking_get_price_with_currency($price_day) . __(" / Day", "tm-booking") . '</li>';
        }
        if(tmbooking_get_metabox( 'price_section_price_perweek', $ID ) != '' && isset($price_week) && $price_week != ''){
            $price_html .= '<li class="list-grid-item fl-font-style-regular '.esc_attr($show_calculate_price == 'week' ? 'list-grid-item-show-price' : '').'">' . tmbooking_get_price_with_currency($price_week) . __(" / Week", "tm-booking"). '</li>';
        }
        if(tmbooking_get_metabox( 'price_section_price_permonth', $ID ) != '' && isset($price_month) && $price_month != ''){
            $price_html .= '<li class="list-grid-item fl-font-style-regular '.esc_attr($show_calculate_price == 'month' ? 'list-grid-item-show-price' : '').'">' . tmbooking_get_price_with_currency($price_month) . __(" / Month", "tm-booking"). '</li>';
        }
        $price_html .= '</ul>';

        $price_html .= '</div>';
        $price_html .= '</div>';
        */
        if ($price != ''){
            $price_html .= '<div class="rental-item__price-box">';
            $price_html .= '<div class="rental-item__price-current">';

            if(isset($discount_percent) && $discount_percent != 0){
                if(class_exists('WooCommerce')){
                    $price_html .= tmbooking_get_price_with_currency($discount_price);
                } else {
                    $price_html .= $discount_price;
                }
            } else {
                if(class_exists('WooCommerce')){
                    $price_html .= tmbooking_get_price_with_currency($price);
                } else {
                    $price_html .= $price;
                }
            }

            if(isset($discount_percent) && $discount_percent != 0){
                $price_html .= '<div class="rental-item__price-old">';
                if(class_exists('WooCommerce')){
                    $price_html .= tmbooking_get_price_with_currency($price);
                } else {
                    $price_html .= $price;
                }
                $price_html .= '</div>';
            }

            $price_html .= '</div>';
            $price_html .= '</div>';
            return $price_html;
        }


        return $price_html;
    } elseif($style == 'style_two') {
        if ($price != ''){
            $price_html .= '<div class="equipment-item__price-box">';

            $price_html .= ' <div class="equipment-item__price-title">' . __("Total Rental Price", "tm-booking") . '<small>' . __("(Incl. Taxes)", "tm-booking") . '</small></div>';

            $price_html .= '<div class="equipment-item__price">';
            $price_html .= '<div class="equipment-item__price-current">';
            if(isset($discount_percent) && $discount_percent != 0){
                if(class_exists('WooCommerce')){
                    $price_html .= tmbooking_get_price_with_currency($discount_price);
                } else {
                    $price_html .= $discount_price . $per_html;
                }
            } else {
                if(class_exists('WooCommerce')){
                    $price_html .= tmbooking_get_price_with_currency($price);
                } else {
                    $price_html .= $price;
                }
            }

            if(isset($discount_percent) && $discount_percent != 0){
                $price_html .= '<div class="equipment-item__price-old">';
                if(class_exists('WooCommerce')){
                    $price_html .= tmbooking_get_price_with_currency($price);
                } else {
                    $price_html .= $price;
                }
                $price_html .= '</div>';
            }

            $price_html .= '</div>';
            $price_html .= '</div>';


            $price_html .= '</div>';
            $price_html .= '<div class="equipment-item__prices">
                                <ul>';

            if(in_array('calc_days', $booking_settings['calc_periods'])){
                $price_day = tmbooking_get_metabox( 'price_section_price_perday', $ID );
            }
            if(in_array('calc_weeks', $booking_settings['calc_periods'])){
                $price_week = tmbooking_get_metabox( 'price_section_price_perweek', $ID );
            }
            if(in_array('calc_month', $booking_settings['calc_periods'])){
                $price_month = tmbooking_get_metabox( 'price_section_price_permonth', $ID );
            }

            if(tmbooking_get_metabox( 'price_section_price_perday', $ID) != '' && isset($price_day) && $price_day != ''){
                $price_html .= '<li>' . tmbooking_get_price_with_currency($price_day) . __(" / Day", "tm-booking") . '</li>';
            }
            if(tmbooking_get_metabox( 'price_section_price_perweek', $ID ) != '' && isset($price_week) && $price_week != ''){
                $price_html .= '<li>' . tmbooking_get_price_with_currency($price_week) . __(" / Week", "tm-booking"). '</li>';
            }
            if(tmbooking_get_metabox( 'price_section_price_permonth', $ID ) != '' && isset($price_month) && $price_month != ''){
                $price_html .= '<li>' . tmbooking_get_price_with_currency($price_month) . __(" / Month", "tm-booking"). '</li>';
            }

            $price_html .= '  </ul>
                            </div>';

            return $price_html;
        }

        return $price_html;

    } elseif($style == 'style_three') {
        if ($price != '') {
            $price_html .= '<ul class="ft-rent-item__list">';
            if(in_array('calc_days', $booking_settings['calc_periods'])){
                $price_day = get_field( 'price_section_price_perday', $ID );
            }
            if(in_array('calc_weeks', $booking_settings['calc_periods'])){
                $price_week = get_field( 'price_section_price_perweek', $ID );
            }
            if(in_array('calc_month', $booking_settings['calc_periods'])) {
                $price_month = get_field( 'price_section_price_permonth', $ID );
            }

            if(get_field( 'price_section_price_perday', $ID ) != '' && isset($price_day) && $price_day != ''){
                $price_html .= '<li class="ft-rent-item__item">' . tmbooking_get_price_with_currency($price_day) . __(" /Day", "tm-booking") . '</li>';
            }
            if(get_field( 'price_section_price_perweek', $ID ) != '' && isset($price_week) && $price_week != ''){
                $price_html .= '<li class="ft-rent-item__item">' . tmbooking_get_price_with_currency($price_week) . __(" /Week", "tm-booking"). '</li>';
            }
            if(get_field( 'price_section_price_permonth', $ID ) != '' && isset($price_month) && $price_month != ''){
                $price_html .= '<li class="ft-rent-item__item">' . tmbooking_get_price_with_currency($price_month) . __(" /Month", "tm-booking"). '</li>';
            }

            $price_html .= '</ul>';
        }
        return $price_html;
    } elseif($style == 'style_four') {
        if ($price != '') {
            $price_show =  '<span class="prc currency_left">'. $price . ' /' . $show_calculate_price . '</span>';
            if(class_exists('WooCommerce')){
                $price_html .=  tmbooking_get_price_with_currency($price) . ' / ' . $show_calculate_price;
            } else {
                $price_html .= $price_show;
            }
        }
        return $price_html;
    }
}
add_shortcode( 'tm_price_catalog', 'tmbooking_get_price_catalog_shortcode' );





//NO INDEX
add_action( 'wp_head', function() {
    global $post;
    global $product;
    $product_id = get_post_meta($post->ID, 'tmbooking_sim_product_id', true);
    if(isset($product_id) && $product_id != '' && get_post_type($post->ID) == 'product'){
        echo '<meta name="robots" content="noindex, nofollow" />';
        if ( empty( $product->ID ) || ! $product->ID->is_visible() ) {
            $redirect_url = get_permalink($product_id);
            echo '<script>window.location.href = "' . $redirect_url . '"</script>';
        }
    }
} );



