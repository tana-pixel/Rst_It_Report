<?php 
/***
Template Name: Autos
The template for displaying all pages.
***/
get_header();
$css_classes[] =$sidebar_css_classes[]='';
global $post, $PIXAD_Autos, $wp;
$Query = false;
$orderby_arr = array('date', 'title');
$data = array_map( 'esc_attr', $_REQUEST );
$args = array();
foreach($data as $key=>$val){
    if( property_exists('PIXAD_Autos', $key) && $key == 'order' ){
        $temp = explode('-', $val);

        if(isset($temp[0]) && in_array($temp[0], $orderby_arr)){
            $PIXAD_Autos->orderby = $temp[0];
            $PIXAD_Autos->order = strtoupper($temp[1]);
            $PIXAD_Autos->metakey = '';
        }
        elseif(isset($temp[0]) && !in_array($temp[0], $orderby_arr)){
            $PIXAD_Autos->orderby = !in_array($temp[0], array('_auto_price','_auto_year')) ? 'meta_value' : 'meta_value_num';
            $PIXAD_Autos->order = strtoupper($temp[1]);
            $PIXAD_Autos->metakey = $temp[0];
        }
    } elseif( property_exists('PIXAD_Autos', $key) && $key == 'per_page' ) {
        $args[$key] = $val;
    } elseif( $key != 'action' && $key != 'nonce'){
        $args[$key] = $val;
    }
}

$Query = $args;

// Sidebar Option
if ( is_active_sidebar( 'autos-sidebar' ) and autlines_get_theme_mod('car_sidebar_position') !='disable' ) {
    $sidebar_float = autlines_get_theme_mod('car_sidebar_position');
}
if($sidebar_float !='disable'){
    $sidebar_float =='right' ? $css_classes[] = 'col-md-9 right-sidebar' : $css_classes[] = 'col-md-9 left-sidebar';
    $sidebar_css_float = 'right' ? $sidebar_css_classes[] = 'col-md-4 right-sidebar' : $sidebar_css_classes[] = 'col-md-4 left-sidebar';
} else {
    $css_classes[] = 'col-md-12';
}
$css_class = preg_replace( '/\s+/', ' ', implode( ' ', array_filter( array_unique( $css_classes ) ) ) );
$sidebar_css_class = preg_replace( '/\s+/', ' ', implode( ' ', array_filter( array_unique( $sidebar_css_classes ) ) ) );


// Header
$header_enable = 'enable';
if(autlines_get_theme_mod('page_header_custom_style',true ) == 'custom' ) {
    $header_enable = autlines_get_theme_mod('page_header', true);
}

if($header_enable !='disable' ) {
    get_template_part('template-parts/header/header_content');
}

?>
<!--Padding Bottom Start-->
<?php if (autlines_get_theme_mod('page_padding_top',true) != 'false') { ?>
    <div class="fl-page-padding top"></div>
<?php } ?>
<!--Padding Bottom End-->
<div class="container autos-container">

    <div class="row">
        <!--Left sidebar -->
        <?php if($sidebar_float == 'left'){
            get_template_part( 'template-parts/sidebar/sidebar','autos');
        } ?>
        <!--Left sidebar End-->

        <div class="<?php echo esc_attr(trim($css_class)); ?>">

            <main class="main-content">

                <?php get_template_part( 'autos', 'sorting' ); ?>

                <div class="pix-dynamic-content">

                    <?php get_template_part( 'autos', 'loader' ); ?>
                    <div class="pix-auto-wrapper-loader">
					
					<?php 


 if (class_exists('PIXAD_Settings')) { 

		        		$Settings	= new PIXAD_Settings();
						$settings	= $Settings->getSettings( 'WP_OPTIONS', '_pixad_autos_settings', true );
						$list_style = $settings['autos_list_style'];

                     $args = $PIXAD_Autos->Query_Args( $Query );


                    $url = Pix_Autos::helping_form_server_url('');

                    if(strstr($url, 'order=_auto_make-desc')){
                       $args['orderby'] = 'title';
                       $args['order'] = 'DESC'; 
                               
                    }elseif(strstr($url, 'order=_auto_make-asc')){
                       $args['orderby'] = 'title';
                       $args['order'] = 'ASC';         
                    } 
                    
                    
                    if( strstr($url, 'order=_auto_price-desc')  || $order === '_auto_price-desc' ) { 
                      $args['meta_key'] = '_auto_price';
                      $args['orderby'] = 'meta_value_num';
                      $args['order'] = 'DESC';
                    
                      $wp_query = new WP_Query( apply_filters( 'autlines_autos_arg_content_list', $args ) );

                    
                    
                    }elseif(strstr($url, 'order=_auto_price-asc') ||  $order === '_auto_price-asc'){
                      $args['meta_key'] = '_auto_price';
                      $args['orderby'] = 'meta_value_num';
                      $args['order'] = 'ASC';
                    
                      $wp_query = new WP_Query( apply_filters( 'autlines_autos_arg_content_list', $args ) );
                    }else{
                      $wp_query = new WP_Query( apply_filters( 'autlines_autos_arg_content_list', $args ) );
                    }

                    $post_counter = $wp_query->post_count;

                    do_action( 'autlines_start_loop_autos', $PIXAD_Autos);

							 if ( strstr($url, '?view_type=list') ) {?>
								  <div id="pixad-listing" class="list">						
                   					    <?php
                    get_template_part( 'loop', 'autos' );
                    echo pixad_wp_pagenavi();
                    ?>
                    			</div>
							 <?php  } elseif  ( strstr($url, '?view_type=grid') ){?>
								
					 			 <div id="pixad-listing" class="grid">					
                   					 <?php
                                 
                    get_template_part( 'loop', 'autosgrid' );
                    echo pixad_wp_pagenavi();
                    ?>
                  					 
                    			</div>
							 <?php }elseif  ( $list_style == 'Grid'){?>
                
           							 <div id="pixad-listing" class="grid">            
                             <?php

                    get_template_part( 'loop', 'autosgrid' );
                    echo pixad_wp_pagenavi();
                    ?>
                            
                          </div>
               <?php       
                 
               }elseif  ( $list_style == 'List'){?>

                
           							 <div id="pixad-listing" class="list">            
                             <?php
   
                    get_template_part( 'loop', 'autos' );
                    echo pixad_wp_pagenavi();
                    
                    ?>
                            
                          </div>
               <?php       
                 
               }          
            ?> 
            <?php do_action( 'autlines_finish_loop_autos', $post_counter); ?>
					
			<?php  } else { echo "Plugin PixAutoDeal not installed";} ?>
                </div>

            </main><!-- end main-content -->

        </div><!-- end col -->
        <!--Left sidebar -->
        <?php if($sidebar_float == 'right'){
            get_template_part( 'template-parts/sidebar/sidebar','autos');
        } ?>
        <!--Left sidebar End-->
    </div><!-- end Row -->

    </div>
</div>

<?php if (autlines_get_theme_mod('page_padding_bottom',true) != 'false') { ?>
    <!--Padding bottom Start-->
    <div class="fl-page-padding bottom"></div>
    <!--Padding bottom End-->
<?php } ?>
<?php get_footer();?>
