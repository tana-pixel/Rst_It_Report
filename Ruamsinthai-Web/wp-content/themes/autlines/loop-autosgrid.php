<?php
global $post, $PIXAD_Autos;
$Settings = new PIXAD_Settings();
$settings = $Settings->getSettings( 'WP_OPTIONS', '_pixad_autos_settings', true );

$validate = $Settings->getSettings( 'WP_OPTIONS', '_pixad_autos_validation', true ); // Get validation settings

$showInSidebar = pixad::getsideviewfields($validate);
$validate = pixad::validation( $validate ); // Fix undefined index notice

$auto_translate = unserialize( get_option( '_pixad_auto_translate' ) );
?>

<div class="row">
        <?php while ( have_posts() ) : the_post(); ?>
            <?php 
            $comment_args = array( 'status' => 'approve', 'post_id' => $post->ID, );
            $comments = get_comments($comment_args);
            ?>

            <div class="col-md-4">
                           <div class="slider-grid__inner slider-grid__inner_mod-b">
                               
                                <div class="card__img">
                   <?php if( has_post_thumbnail() ): ?>
                     <a href="<?php the_permalink(); ?>">
                        <?php the_post_thumbnail('autlines_latest_item', array('class' => 'img-responsive')); ?>
                    </a>

                    
                <?php else: ?>
                    <img class="no-image" src="<?php echo PIXAD_AUTO_URI .'assets/img/no_image.jpg'; ?>" alt="<?php esc_attr_e('No Image','autlines')?>">
                <?php endif; ?>


                <?php if (autlines_get_theme_mod('auto_featured_text',true)):
                    $label_bg = '';
                    if(autlines_get_theme_mod('auto_featured_text_background',true)){
                        $label_bg = 'background-color:'.autlines_get_theme_mod('auto_featured_text_background',true).';';
                    }
                    $label_style = ( $label_bg ) ? 'style=' . $label_bg . '' : '';
                    ?>
                    <div class="card__wrap-label"><span class="card__label" <?php echo esc_attr($label_style);?>><?php echo autlines_get_theme_mod('auto_featured_text',true); ?></span></div>
                <?php endif; ?>



                <?php
                if (function_exists('compare_cars_settings_page')) {
                    echo  '<div class="tmpl-list-footer">
                         <a class="add-to-compare" data-id="'.get_the_ID().'" data-action="add">
                           <span class="add-cmpr"> 
                               <i class="icon-speedometer" aria-hidden="true"></i>
                              <em class="cmpr-btn-text">'.esc_attr__('Add To Compare','autlines').'</em>
                            </span>
                            <span class="rem-cmpr">
                              <i class="icon-speedometer" aria-hidden="true"></i>
                              <em class="cmpr-btn-text">'.esc_attr__('Remove From Compare','autlines').'</em>
                            </span>   
                         </a>';
                    if(empty(get_option('compare_cars_templ')) || empty(get_option('compare_cars_templ')['no_favorite'])) :
                        echo  '<a class="car-favorite" data-id="'.get_the_ID().'" data-action="add-favorite">
                           <span class="add-fvrt"> 
                              <i class="fa fa-star-o"></i>
                            </span>
                            <span class="rem-fvrt"> 
                              <i class="fa fa-star-o"></i>
                            </span>
                        </a>';
                    endif;
                    echo '</div>';
                }
                ?>



				<?php do_action( 'autlines_autos_single_auto_img', $post ); ?>
            </div>
                     <div class="tmpl-gray-footer">
                         <div class="top-info-content">
                             <?php if (function_exists('pix_autodealer_output_info')) {?>
                                 <span class="tmpl-slider-grid__name fl-font-style-bolt"><?php echo pix_autodealer_output_info(get_the_title()); ?></span>
                             <?php } ?>
                             <?php if(!empty($PIXAD_Autos->get_meta('custom_price_catalog'))){?>
                                <span class="slider-grid__price_wrap fl-font-style-bolt fl-primary-color"><span class="slider-grid__price "><span><?php echo esc_html($PIXAD_Autos->get_meta('custom_price_catalog'));?></span></span></span>
                             <?php } else { ?>
                                 <?php if( $validate['auto-price_show'] && $PIXAD_Autos->get_meta('_auto_price') ): ?>
                                     <?php if (function_exists('pix_autodealer_output_info')) {?>
                                         <span class="slider-grid__price_wrap fl-font-style-bolt fl-primary-color"><span class="slider-grid__price "><span><?php echo pix_autodealer_output_info($PIXAD_Autos->get_price(false)); ?></span></span></span>
                                     <?php } ?>
                                 <?php endif; ?>
                             <?php } ?>
                         </div>
                         
                    <ul class="tmpl-slider-grid__info list-unstyled">
                            
                             <?php foreach ($showInSidebar as $id => $sideAttribute):?>
                                  <?php   $id='_'.$id; 
                                 $id = str_replace('-', '_', $id); 
                                  ?>
                                 <?php  if( $PIXAD_Autos->get_meta($id) ): ?>
                                <li><i class="<?php echo esc_html($sideAttribute['icon'])?>"></i>
                                    <?php
                                    $val_attr =  $PIXAD_Autos->get_meta($id);
                                    if(!empty($auto_translate[$val_attr])  ){
                                      echo pix_translate_validate_info($auto_translate[$val_attr]);
                                    }else{
                                      echo esc_html($PIXAD_Autos->get_meta($id));
                                    }
                                      ?>
                                </li>
                                 <?php endif; ?>

                             <?php endforeach;?>
                         </ul>
                        </div> 

                     </div>  
            </div>     
        <?php endwhile; ?>
</div>


