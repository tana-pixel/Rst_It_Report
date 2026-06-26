<?php
if( ! defined( 'ABSPATH' ) ) 
    exit; // Exit if accessed directly
global  $PIXAD_Autos;
    $Settings = new PIXAD_Settings();
    $settings = $Settings->getSettings( 'WP_OPTIONS', '_pixad_autos_settings', true );
$auto_translate = unserialize( get_option( '_pixad_auto_translate' ) );
$pixad_out .= '<div class="row">';
if ($autlines_loop->have_posts()) {
while ( $autlines_loop->have_posts() ) : $autlines_loop->the_post();
$comment_args = array( 'status' => 'approve', 'post_id' => get_the_ID(), );
$comments = get_comments($comment_args);
$post_rating = [];
foreach($comments as $comment){
  $post_rating[] = floatval( get_comment_meta( $comment->comment_ID, 'rating', true ) );
}


    $pixad_out .= ' <div class="col-md-4">
                           <div class="slider-grid__inner slider-grid__inner_mod-b">
                               
                                <div class="card__img">';
    if( has_post_thumbnail() ):
            $pixad_out .= '<a href="'.get_the_permalink().'">
                    '.get_the_post_thumbnail( get_the_ID(), 'autlines_latest_item', array('class' => 'img-responsive')).'
                </a>';
    else:
        $pixad_out .= '<img class="no-image" src="'.PIXAD_AUTO_URI .'assets/img/no_image.jpg" alt="no-image">';
    endif;



    if (autlines_get_theme_mod('auto_featured_text',true)):
        $label_bg = '';
        if(autlines_get_theme_mod('auto_featured_text_background',true)){
            $label_bg = 'background-color:'.autlines_get_theme_mod('auto_featured_text_background',true).';';
        }
        $label_style = ( $label_bg ) ? 'style=' . $label_bg . '' : '';

        $pixad_out .= '<div class="card__wrap-label"><span class="card__label" '.$label_style.'>'.autlines_get_theme_mod('auto_featured_text',true).'</span></div>';
    endif;

    if (is_plugin_active('compare-cars/compare-cars.php')) {
        $pixad_out .=  '<div class="tmpl-list-footer">
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
         $pixad_out .=  '<a class="car-favorite" data-id="'.get_the_ID().'" data-action="add-favorite">
                           <span class="add-fvrt"> 
                              <i class="fa fa-star-o"></i>
                            </span>
                            <span class="rem-fvrt"> 
                              <i class="fa fa-star-o"></i>
                            </span>
                        </a>';
 endif;
$pixad_out .=  '</div>';
}


$pixad_out .= '</div><div class="tmpl-gray-footer">';
$pixad_out .='<div class="top-info-content">';
$pixad_out .= '<span class="tmpl-slider-grid__name fl-font-style-bolt">'.get_the_title().'</span>';

if( $validate['auto-price_show'] && $this->get_meta('_auto_price') ):
    $pixad_out .= '<span class="slider-grid__price_wrap fl-font-style-bolt fl-primary-color"><span class="slider-grid__price"><span>'.wp_kses_post($this->get_price(false)).'</span></span></span>';
endif;

$pixad_out .='</div>';

$pixad_out .= '<ul class="tmpl-slider-grid__info list-unstyled">';

   foreach ($showInSidebar as $id => $sideAttribute):
             $id='_'.$id; 
             $id = str_replace('-', '_', $id);
             if( $PIXAD_Autos->get_meta($id) ): 
                    
        $pixad_out .= '<li><i class="'.  esc_html($sideAttribute['icon']).'"></i>'.  
         wp_kses_post(ucfirst($PIXAD_Autos->get_meta($id))) .
         '</li>';
                    
                  endif; 
       endforeach;


$pixad_out .= '</ul></div></div></div>';




endwhile;
}else{
$no_found_text = htmlspecialchars_decode($settings['autos_no_found']);
$pixad_out .= '<div>'.  $no_found_text .' </div>';

}

$pixad_out .= '</div>';
$pixad_out .= $this->pagenavi($autlines_loop->max_num_pages, $_REQUEST['paged']);

?>
