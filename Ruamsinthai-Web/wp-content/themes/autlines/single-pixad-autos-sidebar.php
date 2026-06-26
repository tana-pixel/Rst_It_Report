 <?php /* The Template for displaying all single autos. */
global $post, $PIXAD_Autos;

$Settings = new PIXAD_Settings();
$settings	= $Settings->getSettings( 'WP_OPTIONS', '_pixad_autos_settings', true );
$validate = $Settings->getSettings( 'WP_OPTIONS', '_pixad_autos_validation', true ); // Get validation settings
$validate = pixad::validation( $validate );
$Auto = new PIXAD_Autos();
$Auto->Query_Args( array('auto_id' => $post->ID) );

$auto_translate = unserialize( get_option( '_pixad_auto_translate' ) );

$has_video = false;

$video_attachments = array();
$videos = pixad_get_attach_video($post->ID);
//$videos = explode(',', $videos[0]);
if(isset($videos[0]) && $videos[0] != '') {
	$video_attachments = get_posts( array(
		'post_type' => 'attachment',
		'include' => $videos[0]
	) );
}

if(count($video_attachments)>0 || pixad_get_external_video($post->ID) != '') {
	$has_video = true;
}
$custom_Price ='';
$custom =  get_post_custom($post->ID);
$pix_options = get_option('pix_general_settings');
$pix_dealer_info = get_post_meta( get_the_ID(), 'pixad_auto_dealer_info', true ) != '' ? get_post_meta( get_the_ID(), 'pixad_auto_dealer_info', true ) : 1;
$pix_contact_form = get_post_meta( get_the_ID(), 'pixad_auto_contacts_form', true ) != '' ? get_post_meta( get_the_ID(), 'pixad_auto_contacts_form', true ) : 1;
$pix_auto_form_id = get_post_meta(get_the_ID(), 'pixad_auto_form', true);
$pix_show_calc = get_post_meta( get_the_ID(), 'pixad_auto_calc', true ) != '' ? get_post_meta( get_the_ID(), 'pixad_auto_calc', true ) : 0;
$custom_Price = $PIXAD_Autos->get_meta('custom_price_car_page');
?>
<div class="col-md-4">
	<aside class="sidebar">
        <?php do_action('autlines_booking_auto_table', $post->ID);?>
        <?php 
        // Проверяем, доступен ли плагин букинга
        $booking_plugin_active = class_exists('TMBooking__Helping_Addons');
        
        // Получаем настройку отображения цены
        $price_display_type = get_post_meta($post->ID, 'tmbooking_price_display_type', true);
        if (empty($price_display_type)) {
            $price_display_type = 'booking'; // Значение по умолчанию
        }
        
        // Проверяем настройку отображения формы букинга в теме
        $show_booking_form = autlines_get_theme_mod('booking_car', true) === 'show';
        
        // Если плагин букинга активен, выбран режим отображения цены букинга и включена настройка отображения формы букинга
        if ($booking_plugin_active && $price_display_type === 'booking' && $show_booking_form) {
            // Показываем блок с ценой букинга
        ?>
            <section class="tm-booking-price-wrap">
                <?php echo do_shortcode('[tm_price id="'.$post->ID.'" style="style_one"]'); ?>
            </section>
        <?php } else { 
            // Показываем стандартный блок с ценой
        ?>
            <section class="auto-price-info">
                <?php if(!empty($PIXAD_Autos->get_meta('custom_price_car_page'))){?>
                    <div class="car-price top-info fl-secondary-bg">
                         <span class="price-detail fl-font-style-bolt">
                                <?php echo esc_html($PIXAD_Autos->get_meta('custom_price_car_page'));?>
                         </span>
                    </div>
                    <?php if(autlines_get_theme_mod('after_price_text_car')){?>
                        <div class="bottom-info fl-bg-light">
                            <?php echo esc_html(autlines_get_theme_mod('after_price_text_car')); ?>
                        </div>
                    <?php }?>

                   <?php } else { ?>
                    <?php if( $validate['auto-price_show'] && $PIXAD_Autos->get_meta('_auto_price') ){ ?>
                        <?php $price = is_numeric($PIXAD_Autos->get_meta('_auto_price')) || $PIXAD_Autos->get_meta('_auto_price') == '' ? $PIXAD_Autos->get_price() : $auto_translate[$PIXAD_Autos->get_price()]; ?>
                        <div class="car-price top-info fl-secondary-bg">
                            <span class="price-text"><?php esc_html_e('Price', 'autlines'); ?></span>
                            <span class="price-detail fl-font-style-bolt"><?php
                                if(function_exists('pix_autodealer_output_info')){
                                    echo pix_autodealer_output_info($price);
                                }
                                ?></span>
                        </div>
                        <?php if(autlines_get_theme_mod('after_price_text_car')){?>
                            <div class="bottom-info fl-bg-light">
                                <?php echo esc_html(autlines_get_theme_mod('after_price_text_car')); ?>
                            </div>
                        <?php }?>
                    <?php }?>
                <?php } ?>
            </section>
        <?php } ?>
            
            <?php if ($booking_plugin_active && $show_booking_form) { // Проверяем, активен ли плагин букинга и включена ли настройка отображения формы ?>
                <section class="tm-booking-widget-wrap">
                   
                    <div class="tm-booking-form-container">
                        <?php echo do_shortcode('[tm_booking id="'.$post->ID.'" style="style_one"]'); ?>
                    </div>
                </section>
            
            
              <section class="tm-booking-widget-wrap-discounts">
            
             <?php echo do_shortcode('[tm_booking_discounts id="'.$post->ID.'" layout="list"  show_title="yes"]'); ?>  
                  
            </section>
            <?php } ?>
        
        
        <?php if (!$booking_plugin_active && class_exists('Pixad_Booking_AUTO') && autlines_get_theme_mod('booking_car',true) == 'show') { ?>
            <section class="booking-widget-wrap">
                <div id="booking_car_info" class="booking_car_info">
                    <?php do_action('autlines_end_auto', $post); ?>
                </div>
            </section>
        <?php } elseif (!$booking_plugin_active && !class_exists('Pixad_Booking_AUTO')) { ?>
            <section class="auto-price-info">
                <?php if(!empty($PIXAD_Autos->get_meta('custom_price_car_page'))){?>
                    <div class="car-price top-info fl-secondary-bg">
                         <span class="price-detail fl-font-style-bolt">
                                <?php echo esc_html($PIXAD_Autos->get_meta('custom_price_car_page'));?>
                         </span>
                    </div>
                    <?php if(autlines_get_theme_mod('after_price_text_car')){?>
                        <div class="bottom-info fl-bg-light">
                            <?php echo esc_html(autlines_get_theme_mod('after_price_text_car')); ?>
                        </div>
                    <?php }?>

                   <?php } else { ?>
                    <?php if( $validate['auto-price_show'] && $PIXAD_Autos->get_meta('_auto_price') ){ ?>
                        <?php $price = is_numeric($PIXAD_Autos->get_meta('_auto_price')) || $PIXAD_Autos->get_meta('_auto_price') == '' ? $PIXAD_Autos->get_price() : $auto_translate[$PIXAD_Autos->get_price()]; ?>
                        <div class="car-price top-info fl-secondary-bg">
                            <span class="price-text"><?php esc_html_e('Price', 'autlines'); ?></span>
                            <span class="price-detail fl-font-style-bolt"><?php
                                if(function_exists('pix_autodealer_output_info')){
                                    echo pix_autodealer_output_info($price);
                                }
                                ?></span>
                        </div>
                        <?php if(autlines_get_theme_mod('after_price_text_car')){?>
                            <div class="bottom-info fl-bg-light">
                                <?php echo esc_html(autlines_get_theme_mod('after_price_text_car')); ?>
                            </div>
                        <?php }?>
                    <?php }?>
                <?php } ?>
            </section>
        <?php } ?>



        <?php
        $images = autlines_get_theme_mod('gallery_promo_images',true);
        if( $images ):
        ?>
        <div class="promo-image-gallery">
                <ul class="images-promo">
                    <?php
                        foreach( $images as $image ): ?>
                         <li class="promo-img">
                             <?php echo wp_get_attachment_image( $image['ID'], 'full' ); ?>
                         </li>
                    <?php endforeach; ?>
                </ul>
        </div>
        <?php
          endif;
        ?>



        <?php if ($pix_dealer_info !=0) :
            $author_id = get_the_author_meta( 'ID' );
            $udata = get_userdata( get_the_author_meta( 'ID' ) );
            $author_registration = $udata->user_registered;
            $message =   esc_html__('Member since: ','autlines') . date( "F Y", strtotime( $author_registration ) );
            ?>
            <section class="dealer-info">
                <div class="dealer-top-info fl-primary-bg">
                    <div class="left"><?php echo get_avatar( esc_attr($author_id), '110'); ?></div>
                    <div class="right">
                        <div class="top fl-font-style-bolt dealer-name"><?php echo get_the_author();?></div>
                        <div class="bottom"><?php echo esc_attr($message);?></div>
                    </div>
                </div>
                <div class="dealer-bottom-info">
                        <div class="phone-info">
                            <div class="left"><i class="fl-custom-icon-call fl-primary-color"></i></div>
                            <div class="right">
                                <div class="top"><?php echo esc_html__('Contact Seller','autlines') ?></div>
                                <div class="bottom">
                                    <?php if(get_the_author_meta('phone')){ ?>
                                            <a class="fl-font-style-bolt-two phone-text fl-primary-color-hv" href="tel:<?php the_author_meta('phone'); ?>">
                                                <?php the_author_meta('phone'); ?>
                                            </a>
                                    <?php } ?>
                                    </div>
                            </div>
                        </div>
                        <div class="social-info">
                            <ul>
                                <?php if(get_the_author_meta('instagram')){ ?>
                                    <li>
                                    <a target="_blank" class="fl-secondary-color-hv" href="//instagram.com/<?php the_author_meta('instagram'); ?>">
                                        <i class="fa fa-instagram"></i>
                                    </a>
                                    </li>
                                <?php } ?>

                                <?php if(get_the_author_meta('twitter')){ ?>
                                    <li>
                                        <a target="_blank" class="fl-secondary-color-hv" href="//twitter.com/<?php the_author_meta('twitter'); ?>">
                                            <i class="fa fa-twitter"></i>
                                        </a>
                                    </li>
                                <?php } ?>

                                <?php if(get_the_author_meta('google')){ ?>
                                    <li>
                                        <a target="_blank" class="fl-secondary-color-hv" href="//plus.google.com/<?php the_author_meta('google'); ?>?rel=author">
                                            <i class="fa fa-google"></i>
                                        </a>
                                    </li>
                                <?php } ?>

                                <?php if(get_the_author_meta('facebook')){ ?>
                                    <li>
                                        <a target="_blank" class="fl-secondary-color-hv" href="//facebook.com/<?php the_author_meta('facebook'); ?>">
                                            <i class="fa fa-facebook"></i>
                                        </a>
                                    </li>
                                <?php } ?>

                                <?php if(get_the_author_meta('pinterest')){ ?>
                                    <li>
                                        <a target="_blank" class="fl-secondary-color-hv" href="//pinterest.com/<?php the_author_meta('pinterest'); ?>">
                                            <i class="fa fa-pinterest-p"></i>
                                        </a>
                                    </li>
                                <?php } ?>

                                <?php if(get_the_author_meta('behance')){ ?>
                                    <li>
                                        <a target="_blank" class="fl-secondary-color-hv" href="//www.behance.net/<?php the_author_meta('behance'); ?>">
                                            <i class="fa fa-behance"></i>
                                        </a>
                                    </li>
                                <?php } ?>
                            </ul>
                        </div>
                </div>
            </section>
        <?php endif; ?>



        <?php if ( $pix_auto_form_id !=0 && $pix_contact_form) : ?>

            <section class="widget widget-contact-form">
                <h3 class="widget-title"><?php echo esc_html__('Message Seller','autlines')?></h3>
                <?php echo do_shortcode("[contact-form-7 id=\"$pix_auto_form_id\"]") ?>
            </section>
        <?php endif; ?>


 <?php if($pix_show_calc): ?>
  <?php
     $price_auto = '100000';
     if(is_singular('pixad-autos')){
         $auto_price = $PIXAD_Autos->get_meta('_auto_price');
     }
    $currencies = unserialize( get_option( '_pixad_autos_currencies' ) ); 

		$currency = $currencies[$settings['autos_site_currency']];
		if( !$currency['symbol'] ) $currency['symbol'] = '';
		$price_auto = $auto_price;
    ?>

<section class="widget widget-calculator">
		<h3 class="widget-title"><i class="theme-fonts-icon_calculator_alt"></i><?php echo esc_html__('Financing Calculator','autlines')?></h3>
		
		<div class="widget-content">
			<div class="autlines_calculator">
				<div class="row">
					<input type="hidden" id="pix-thousand" value="<?php echo esc_attr($settings['autos_thousand']) ?>">
					<input type="hidden" id="pix-decimal" value="<?php echo esc_attr($settings['autos_decimal']) ?>">
					<input type="hidden" id="pix-decimal_number" value="<?php echo esc_attr($settings['autos_decimal_number']) ?>">

					<div class="col-md-12">					
						<div class="form-group">
							<div class="labeled fl-font-style-bolt-two"><?php echo esc_html__('Vehicle price','autlines')?> <span class="orange currency">(<?php echo esc_attr($currency['symbol']); ?>)</span></div>
							<input type="text" class="numbersOnly vehicle_price" value="<?php echo esc_attr($price_auto)?>">
						</div>

						<div class="row">
							<div class="col-md-6 col-sm-6">							
								<div class="form-group md-mg-rt">
									<div class="labeled fl-font-style-bolt-two"><?php echo esc_html__('Interest rate','autlines')?> <span class="orange">(%)</span></div>
									<input type="text" class="numbersOnly interest_rate" value="5">
								</div>
							</div>
							<div class="col-md-6 col-sm-6">							
								<div class="form-group md-mg-lt">
									<div class="labeled fl-font-style-bolt-two"><?php echo esc_html__('Period','autlines')?> <span class="orange">(<?php echo esc_html__('month','autlines')?>)</span></div>
									<input type="text" class="numbersOnly period_month" value="36">
								</div>
							</div>
						</div>
						
						<div class="form-group">
							<div class="labeled fl-font-style-bolt-two"><?php echo esc_html__('Down Payment','autlines')?> <span class="orange">(<?php echo esc_attr($currency['symbol']); ?>)</span></div>
							<input type="text" class="numbersOnly down_payment" value="10000">
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
	</section>
 <?php endif; ?>
	</aside>
</div>





