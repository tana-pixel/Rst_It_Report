<?php
/**
 * Blog Widget
 */
class Fl_Finance_Calculator extends WP_Widget
{
    /**
     * General Setup
     */
    public function __construct() {

        /* Widget settings. */
        $widget_ops = array(
            'classname' => 'fl_finance_calculator_widget',
            'description' => esc_html__('A widget that displays your Popular posts with image.', 'fl-themes-helper')
        );

        /* Widget control settings. */
        $control_ops = array(
            'width'		=> 300,
            'height'	=> 350,
            'id_base'	=> 'fl_finance_calculator_widget'
        );

        /* Create the widget. */
        parent::__construct( 'fl_finance_calculator_widget', esc_html__('Fl Finance Calculator', 'fl-themes-helper'), $widget_ops, $control_ops );
    }

    /**
     * Display Widget
     * @param array $args
     * @param array $instance
     */
    public function widget( $args, $instance )
    {
        global $post, $PIXAD_Autos;
        extract( $args );

        $title = apply_filters('widget_title', $instance['title'] );

        /* Our variables from the widget settings. */
        $currency_symbol        = $instance['currency_symbol'];
        $autos_thousand         = $instance['autos_thousand'];
        $autos_decimal          = $instance['autos_decimal'];
        $autos_decimal_number   = $instance['autos_decimal_number'];
        $autos_price            = $instance['price_auto'];
        $interest_rate          = $instance['interest_rate'];
        $period                 = $instance['period'];
        $down_payment                 = $instance['down_payment'];

        if(is_singular('pixad-autos')){
            $autos_price = $PIXAD_Autos->get_meta('_auto_price');
        }

        /* Before widget (defined by themes). */
        echo fl_wp_kses($before_widget);

        // Display Widget
        ?>
        <?php /* Display the widget title if one was input (before and after defined by themes). */
        if ( $title )
            echo fl_wp_kses($before_title) . esc_attr($title) . fl_wp_kses($after_title);
        ?>

            <div class="widget-content">
                <div class="autlines_calculator">
                    <div class="row">
                        <input type="hidden" id="pix-thousand" value="<?php echo esc_attr($autos_thousand) ;?>">
                        <input type="hidden" id="pix-decimal" value="<?php echo esc_attr($autos_decimal) ;?>">
                        <input type="hidden" id="pix-decimal_number" value="<?php echo esc_attr($autos_decimal_number) ;?>">

                        <div class="col-md-12">
                            <div class="form-group">
                                <div class="labeled fl-font-style-bolt-two"><?php echo esc_html__('Vehicle price','autlines')?> <span class="orange currency">(<?php echo esc_attr($currency_symbol); ?>)</span></div>
                                <input type="text" class="numbersOnly vehicle_price" value="<?php echo esc_attr($autos_price) ;?>">
                            </div>

                            <div class="row">
                                <div class="col-md-6 col-sm-6">
                                    <div class="form-group md-mg-rt">
                                        <div class="labeled fl-font-style-bolt-two"><?php echo esc_html__('Interest rate','autlines')?> <span class="orange">(%)</span></div>
                                        <input type="text" class="numbersOnly interest_rate" value="<?php echo esc_attr($interest_rate) ;?>">
                                    </div>
                                </div>
                                <div class="col-md-6 col-sm-6">
                                    <div class="form-group md-mg-lt">
                                        <div class="labeled fl-font-style-bolt-two"><?php echo esc_html__('Period','autlines')?> <span class="orange">(<?php echo esc_html__('month','autlines')?>)</span></div>
                                        <input type="text" class="numbersOnly period_month" value="<?php echo esc_attr($period) ;?>">
                                    </div>
                                </div>
                            </div>

                            <div class="form-group">
                                <div class="labeled fl-font-style-bolt-two"><?php echo esc_html__('Down Payment','autlines')?> <span class="orange">(<?php echo esc_attr($currency_symbol); ?>)</span></div>
                                <input type="text" class="numbersOnly down_payment" value="<?php echo esc_attr($down_payment) ;?>">
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
        /* After widget (defined by themes). */
        echo fl_wp_kses($after_widget);
    }

    /**
     * Update Widget
     * @param array $new_instance
     * @param array $old_instance
     * @return array
     */
    public function update( $new_instance, $old_instance )
    {
        $instance = $old_instance;

        $instance['title']                  = strip_tags( $new_instance['title'] );
        $instance['currency_symbol']        = strip_tags( $new_instance['currency_symbol'] );
        $instance['autos_thousand']         = strip_tags( $new_instance['autos_thousand'] );
        $instance['autos_decimal']          = strip_tags( $new_instance['autos_decimal'] );
        $instance['autos_decimal_number']   = strip_tags( $new_instance['autos_decimal_number'] );
        $instance['price_auto']             = strip_tags( $new_instance['price_auto'] );
        $instance['interest_rate']          = strip_tags( $new_instance['interest_rate'] );
        $instance['period']                 = strip_tags( $new_instance['period'] );
        $instance['down_payment']           = strip_tags( $new_instance['down_payment'] );
        return $instance;
    }

    /**
     * Widget Settings
     * @param array $instance
     */
    public function form( $instance )
    {
        //default widget settings.
        $defaults = array(
            'title'                     => esc_html__('Financing Calculator','fl-themes-helper'),
            'currency_symbol'           => '$',
            'autos_thousand'            => ',',
            'autos_decimal'             => '.',
            'autos_decimal_number'      => '0',
            'price_auto'                => '100000',
            'interest_rate'             => '5',
            'period'                    => '36',
            'down_payment'              => '10000'
        );
        $instance = wp_parse_args( (array) $instance, $defaults ); ?>
        <p>
            <label for="<?php echo esc_attr($this->get_field_id( 'title' )); ?>"><?php esc_html_e('Title:', 'fl-themes-helper') ?></label>
            <input type="text" class="widefat" id="<?php echo esc_attr($this->get_field_id( 'title' )); ?>" name="<?php echo esc_attr($this->get_field_name( 'title' )); ?>" value="<?php echo ''.$instance['title']; ?>" />
        </p>
        <p>
            <label for="<?php echo esc_attr($this->get_field_id( 'price_auto' )); ?>"><?php esc_html_e('Auto Price Default', 'fl-themes-helper') ?></label>
            <input type="text" class="widefat" id="<?php echo esc_attr($this->get_field_id( 'price_auto' )); ?>" name="<?php echo esc_attr($this->get_field_name( 'price_auto' )); ?>" value="<?php echo ''.$instance['price_auto']; ?>" />
        </p>
        <p>
            <label for="<?php echo esc_attr($this->get_field_id( 'interest_rate' )); ?>"><?php esc_html_e('Interest rate Default', 'fl-themes-helper') ?></label>
            <input type="text" class="widefat" id="<?php echo esc_attr($this->get_field_id( 'interest_rate' )); ?>" name="<?php echo esc_attr($this->get_field_name( 'interest_rate' )); ?>" value="<?php echo ''.$instance['interest_rate']; ?>" />
        </p>
        <p>
            <label for="<?php echo esc_attr($this->get_field_id( 'period' )); ?>"><?php esc_html_e('Period (month)', 'fl-themes-helper') ?></label>
            <input type="text" class="widefat" id="<?php echo esc_attr($this->get_field_id( 'period' )); ?>" name="<?php echo esc_attr($this->get_field_name( 'period' )); ?>" value="<?php echo ''.$instance['period']; ?>" />
        </p>
        <p>
            <label for="<?php echo esc_attr($this->get_field_id( 'down_payment' )); ?>"><?php esc_html_e('Down Payment', 'fl-themes-helper') ?></label>
            <input type="text" class="widefat" id="<?php echo esc_attr($this->get_field_id( 'down_payment' )); ?>" name="<?php echo esc_attr($this->get_field_name( 'down_payment' )); ?>" value="<?php echo ''.$instance['down_payment']; ?>" />
        </p>

        <p>
            <label for="<?php echo esc_attr($this->get_field_id( 'currency_symbol' )); ?>"><?php esc_html_e('Currency symbol', 'fl-themes-helper') ?></label>
            <input type="text" class="widefat" id="<?php echo esc_attr($this->get_field_id( 'currency_symbol' )); ?>" name="<?php echo esc_attr($this->get_field_name( 'currency_symbol' )); ?>" value="<?php echo ''.$instance['currency_symbol']; ?>" />
        </p>
        <p>
            <label for="<?php echo esc_attr($this->get_field_id( 'autos_thousand' )); ?>"><?php esc_html_e('Thousand', 'fl-themes-helper') ?></label>
            <input type="text" class="widefat" id="<?php echo esc_attr($this->get_field_id( 'autos_thousand' )); ?>" name="<?php echo esc_attr($this->get_field_name( 'autos_thousand' )); ?>" value="<?php echo ''.$instance['autos_thousand']; ?>" />
        </p>
        <p>
            <label for="<?php echo esc_attr($this->get_field_id( 'autos_decimal' )); ?>"><?php esc_html_e('Decimal', 'fl-themes-helper') ?></label>
            <input type="text" class="widefat" id="<?php echo esc_attr($this->get_field_id( 'autos_decimal' )); ?>" name="<?php echo esc_attr($this->get_field_name( 'autos_decimal' )); ?>" value="<?php echo ''.$instance['autos_decimal']; ?>" />
        </p>
        <p>
            <label for="<?php echo esc_attr($this->get_field_id( 'autos_decimal_number' )); ?>"><?php esc_html_e('Decimal number', 'fl-themes-helper') ?></label>
            <input type="text" class="widefat" id="<?php echo esc_attr($this->get_field_id( 'autos_decimal_number' )); ?>" name="<?php echo esc_attr($this->get_field_name( 'autos_decimal_number' )); ?>" value="<?php echo ''.$instance['autos_decimal_number']; ?>" />
        </p>

        <?php
    }
}