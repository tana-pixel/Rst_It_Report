<?php

if ( ! function_exists( 'vc_fl_finance_calculator_function' ) ) {
    function vc_fl_finance_calculator_function($atts, $content = null)
    {

        $css_classes[] = 'fl-finance-calculator-wrap-vc';

        global $fl_helping_responsive_style, $fl_helping_css_style, $PIXAD_Autos;

        $atts = vc_map_get_attributes('vc_fl_finance_calculator', $atts);
        extract($atts);

        //Button sizes
        $result = $wrapper_attributes[] =$button_container_wrapper_attributes[]= $responsive_style = $css = '';


        $custom_html_class = uniqid('fl-custom-html-').'-'.rand(100,9999);

        $css_classes[] .= fl_get_css_tab_class($atts);

        if(isset($id) && $id != '') {
            $wrapper_attributes[] = 'id="'.fl_sanitize_class($id).'"';
        }

        if(isset($class) && $class != '') {
            $css_classes[] .= fl_sanitize_class($class);
        }



        // Responsive CSS Box
        if(isset($custom_responsive_option) && $custom_responsive_option !='off') {
            if( !empty( $responsive_css ) && $responsive_css != '' ) {
                $responsive_id = $idf = uniqid('fl-helping-responsive-').'-'.rand(100,9999);
                $column_selector = $responsive_id;
                $responsive_style = fl_helping__addons_get_responsive_style($responsive_css, $column_selector);
                $css_classes[] .= $responsive_id;
            }
        }

        // Animation option
        if ( ! empty( $animation ) and ($animation !='none')) {
            $css_classes[] = 'fl-animated-item-velocity';
            $wrapper_attributes[] = 'data-animate-type="'.$animation.'"';


            if ( ! empty( $custom_delay ) and ( $custom_delay !='off')) {
                if ( ! empty( $animation_delay ) and ($animation_delay !='')) {
                    $wrapper_attributes[] = 'data-item-delay="'.$animation_delay.'"';
                }
            }
        }
        // Bg Position Option
        if ( ! empty( $desktop_bg_image_position ) and $desktop_bg_image_position !='' ) {
            $css_classes[] = $desktop_bg_image_position;
        }
        // Min Height Option
        if ( ! empty( $desktop_height ) and $desktop_height !='' ) {
            $wrapper_attributes[]   = 'style="min-height:'.$desktop_height.';"';
        }

        $auto_price = $price_auto;
        $interest_rate_auto = $interest_rate;
        $period_auto = $period;
        $down_payment_auto = $down_payment;
        if(is_singular('pixad-autos')){
            $auto_price = $PIXAD_Autos->get_meta('_auto_price');
        }
        $css_class = preg_replace( '/\s+/', ' ', implode( ' ', array_filter( array_unique( $css_classes ) ) ) );

        ob_start();

        $result .= '<div class="' . esc_attr( trim( $css_class ) ) . '" '. implode( ' ', $wrapper_attributes ).'>';

        ?>
            <div class="autlines_calculator">
            <div class="row">
                <input type="hidden" id="pix-thousand" value="<?php echo esc_attr($autos_thousand) ;?>">
                <input type="hidden" id="pix-decimal" value="<?php echo esc_attr($autos_decimal) ;?>">
                <input type="hidden" id="pix-decimal_number" value="<?php echo esc_attr($autos_decimal_number) ;?>">

                <div class="col-md-12">
                    <div class="form-group">
                        <div class="labeled fl-font-style-bolt-two"><?php echo esc_html__('Vehicle price','autlines')?> <span class="orange currency">(<?php echo esc_attr($currency_symbol); ?>)</span></div>
                        <input type="text" class="numbersOnly vehicle_price" value="<?php echo $auto_price;?>">
                    </div>

                    <div class="row">
                        <div class="col-md-6 col-sm-6">
                            <div class="form-group md-mg-rt">
                                <div class="labeled fl-font-style-bolt-two"><?php echo esc_html__('Interest rate','autlines')?> <span class="orange">(%)</span></div>
                                <input type="text" class="numbersOnly interest_rate" value="<?php echo $interest_rate_auto;?>">
                            </div>
                        </div>
                        <div class="col-md-6 col-sm-6">
                            <div class="form-group md-mg-lt">
                                <div class="labeled fl-font-style-bolt-two"><?php echo esc_html__('Period','autlines')?> <span class="orange">(<?php echo esc_html__('month','autlines')?>)</span></div>
                                <input type="text" class="numbersOnly period_month" value="<?php echo $period_auto;?>">
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="labeled fl-font-style-bolt-two"><?php echo esc_html__('Down Payment','autlines')?> <span class="orange">(<?php echo esc_attr($currency_symbol); ?>)</span></div>
                        <input type="text" class="numbersOnly down_payment" value="<?php echo $down_payment_auto;?>">
                    </div>

                    <div class="submit-btn-container">
                        <div class="fl-secondary-bg">
                            <a href="javascript:void(0)" class="fl-font-style-bolt-two default-btn submit-comment autlines_calculate_btn"><?php echo esc_html__('Calculate Finance','autlines')?></a>
                        </div>
                    </div>


                    <div class="calculator-alert alert alert-danger">

                    </div>

                </div>

                <div class="col-md-12">
                    <div class="autlines_calculator_results" style="display: block;">
                        <div class="autlines_calculator_report">
                            <dl class="list-descriptions list-unstyled">
                                <dt class="fl-font-style-semi-bolt"><?php echo esc_html__('Monthly Payment','autlines')?></dt>
                                <dd class="monthly_payment fl-font-style-semi-bolt"><span class="currency"></span><span class="val"></dd>

                                <dt class="fl-font-style-semi-bolt"><?php echo esc_html__('Total Interest Payment','autlines')?></dt>
                                <dd class="total_interest_payment fl-font-style-semi-bolt"><span class="currency"></span><span class="val"></dd>

                                <dt class="fl-font-style-semi-bolt"><?php echo esc_html__('Total Amount to Pay','autlines')?></dt>
                                <dd class="total_amount_to_pay fl-font-style-semi-bolt"><span class="currency"></span><span class="val"></span></dd>
                            </dl>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        </div>
<?php

        $result .= ob_get_clean();
        // Responsive CSS Box
        if(isset($custom_responsive_option) && $custom_responsive_option !='off') {
            $fl_helping_responsive_style .= $responsive_style;
        }
        $result .= '</div>';
        return $result;
    }
}

add_shortcode('vc_fl_finance_calculator', 'vc_fl_finance_calculator_function');