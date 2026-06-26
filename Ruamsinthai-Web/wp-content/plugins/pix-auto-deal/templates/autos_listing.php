<?php
if( ! defined( 'ABSPATH' ) ) 
  exit; // Exit if accessed directly
global  $PIXAD_Autos;
$auto_translate = unserialize( get_option( '_pixad_auto_translate' ) );

if ($autlines_loop->have_posts()) {
while ( $autlines_loop->have_posts() ) : $autlines_loop->the_post();

$comment_args = array( 'status' => 'approve', 'post_id' => get_the_ID(), );
$comments = get_comments($comment_args);
$post_rating = [];
foreach($comments as $comment){
  $post_rating[] = floatval( get_comment_meta( $comment->comment_ID, 'rating', true ) );
}

  $pixad_out .= '

  <article class="card" id="post-'.get_the_ID().'">
    <div class="card__img">';
      if( has_post_thumbnail() ):
        $pixad_out .= '<a href="'.get_the_permalink().'">
          '.get_the_post_thumbnail( get_the_ID(), 'autlines-auto-cat', array('class' => 'img-responsive')).'
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

  $pixad_out .= '</div></div>';

    // Card Inner
    $pixad_out .='<div class="card__inner">';

    //Top content

    $pixad_out .= '<div class="top-content">';
    // Left content
    $pixad_out .= '<div class="left-content">';

    $pixad_out .='<h2 class="card__title ui-title-inner"><a href="'.get_the_permalink().'" title="'.esc_attr($strip_title).'">'.get_the_title().'</a></h2>';

    $pixad_out .= '<div class="card__description">';
    if (autlines_get_theme_mod('list_description_auto', true)) {
        $pixad_out .= autlines_get_theme_mod('list_description_auto', true);
    }
    $pixad_out .= '</div>';

    $pixad_out .= '</div>';
    // Left content End

    // Right Content

    $pixad_out .= '<div class="right-content">';

    if( $validate['auto-price_show'] ):
        $pixad_out .= '<div class="card__price fl-primary-bg"><span class="price-text fl-font-style-bolt-two">'.esc_html__( 'PRICE:' , 'pixad').'</span><span class="card__price-number fl-font-style-bolt">'.wp_kses_post($this->get_price(false)).'</span></div>';
    endif;

    $pixad_out .= '</div>';

    // Right Content End

    $pixad_out .= '</div>';

    //Top content End


    // Bottom Content
    $pixad_out .='<div class="bottom-content">';

   $pixad_out .= '<!-- Car Details -->
      <ul class="card__list list-unstyled">';
         foreach ($showInList as $id => $sideAttribute):
                  
                    $settingName = $showInList[$id]['title'];
                    $id='_'.$id; 
                    $id = str_replace('-', '_', $id); 
          
                    if( $PIXAD_Autos->get_meta($id) ) {
                      $pixad_out .= '<li class="card-list__row">';

                      $val_attr =  $PIXAD_Autos->get_meta($id);
                        $pixad_out.='<i class="'.esc_html($sideAttribute['icon']).'"></i>';
                        $pixad_out .='<div class="right--content">';
                       if(!empty($auto_translate[$val_attr])  ){   
                        //   echo esc_html($auto_translate[$val_attr]);
                            $pixad_out .= '<span class="card-list__title">';
                                     if ($settingName) {
                                      $pixad_out .= pix_translate_validate_info($auto_translate[$settingName]).": ";
                                     } else{
                                         $customId = substr( $id, 1);
                                         $сustomSettingName  = $validate[$customId.'_name'];
                                         $pixad_out .=    $сustomSettingName; 
                                     }

                               $pixad_out .= '  </span>
                               <span class="card-list__info"> ';
                                 
                                  $pixad_out .= pix_translate_validate_info($auto_translate[$val_attr]);
                                 
                               $pixad_out .= ' </span> ';
                      }else{ 
                             $pixad_out .= '   <span class="card-list__title '.$settingName.'"> ';

                                     if ($settingName) {
                                       $pixad_out .= pix_translate_validate_info($auto_translate[$settingName]).": ";;
                                     } else{
                                         $customId = substr( $id, 1);
                                         $сustomSettingName  = $validate[$customId.'_name'];
                                          $pixad_out .=  $сustomSettingName; 

                                     }
                               $pixad_out .= '   </span> 
                               <span class="card-list__info"> ';
                                 if ($id == '_auto_mileage') {
                                     $pixad_out .= number_format($PIXAD_Autos->get_meta('_auto_mileage'), 0, '', "{$settings['autos_thousand']}");                                                
                                 }else{
                                     $pixad_out .= esc_html($PIXAD_Autos->get_meta($id)); 
                                 }
                                  // echo $id
                                     if ($id == '_auto_horsepower') {
                                        $pixad_out .= ' '. __( 'hp', 'pixad' );
                                     }elseif ($id == '_auto_engine') {
                                       $pixad_out .= ' '. __( 'cm3', 'pixad' );
                                     }elseif ($id == '_auto_doors') {
                                       $pixad_out .= ' '. __( 'doors', 'pixad' );
                                     }
                             $pixad_out .= '  </span> ';
                     }
                        $pixad_out .='</div>';
                          $pixad_out .= ' </li> ';    
                  }                     
          endforeach;

        if(array_key_exists('auto-date', $showInList)  && $validate['auto-date_show'] && get_the_date() ){
                  $pixad_out .= ' <li><span class="card-list__title">'. __( 'Updated :', 'pixad' ) .'</span> ';
                  $pixad_out .= ' <span>'. get_the_date() .'</span></li>';
            }
      $pixad_out .= '
      </ul><!-- / Car Details -->';

    $pixad_out .='</div>';
    // Bottom Content End


    // Bottom 2-l

    $pixad_out .='<div class="bottom-dbl-content">';

    $images = autlines_get_theme_mod('gallery_promo_images', true);

    $pixad_out .=' <div class="promo-image-gallery">
                        <ul class="images-promo">';

    if ($images):
        foreach ($images as $image):

        $pixad_out.='<li class="promo-img">';

            $pixad_out.= wp_get_attachment_image($image['ID'], 'full');

        $pixad_out.='</li>';

     endforeach;
    endif;
    $pixad_out .='</div></ul>';

    if (is_plugin_active('compare-cars/compare-cars.php')) {
        $pixad_out .=  '<div class="tmpl-list-footer">
        <a class="add-to-compare" data-id="'.get_the_ID().'"data-action="add">
            <span class="add-cmpr"> 
            <i class="icon-speedometer" aria-hidden="true"></i><em class="cmpr-btn-text">'.esc_attr__('Add To Compare','autlines').'</em></span>
            
            <span class="rem-cmpr">
            <i class="icon-speedometer" aria-hidden="true"></i><em class="cmpr-btn-text">'.esc_attr__('Remove From Compare','autlines').'</em></span>   
        </a>';
        if(empty(get_option('compare_cars_templ')) || empty(get_option('compare_cars_templ')['no_favorite'])) :
            $pixad_out .=  '  <a class="car-favorite" data-id="'.get_the_ID().'" data-action="add-favorite">
             <span class="add-fvrt"> 
            <i class="fa fa-star-o"></i>
            </span>
            <span class="rem-fvrt"> 
            <i class="fa fa-star-o"></i>
            </span>
        </a></div>';
        endif;
    }

    $pixad_out .='</div>';

    $pixad_out .='</div>';
    // Card Inner End

  $pixad_out .= '
 </div>
    </div>

  </article>';
endwhile;
}else{
  $no_found_text = htmlspecialchars_decode($settings['autos_no_found']);
  $pixad_out .= '<div>'.  $no_found_text .' </div>';
}
$pixad_out .= $this->pagenavi($autlines_loop->max_num_pages, $_REQUEST['paged']);

?>
