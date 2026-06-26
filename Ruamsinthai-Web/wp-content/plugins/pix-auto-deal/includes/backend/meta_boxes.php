<?php
// Exit if accessed directly
if( ! defined( 'ABSPATH' ) ) exit;


function pixad_cf7_forms(){
    $cf7 = get_posts( 'post_type="wpcf7_contact_form"&numberposts=-1' );
    $contact_forms = array();
    if ( $cf7 ) {
        foreach ( $cf7 as $cform ) {
            $contact_forms[ $cform->post_title ] = $cform->ID;
        }
    } else
        $contact_forms[ __( 'No contact forms found install Contact Form Plugin and Create your form', 'pixad' ) ] = 0;

    return $contact_forms;
}

/**
 * Add Auto Classifieds Meta Boxes
 *
 * $id
 * $title
 * $callback
 * $post_type
 * $context
 * $priority
 * $callback_args 
 *
 * @since 0.1
 */

function add_pixad_auto_meta_boxes() {
	add_meta_box( 'pixad_auto_details', esc_html__( 'Auto Details', 'pixad' ), 'pixad_auto_details', 'pixad-autos', 'normal', 'high' ); // Auto details metabox
	//add_meta_box( 'pixad_auto_gallery', esc_html__( 'Gallery', 'pixad' ), 'pixad_auto_gallery', 'pixad-autos', 'side', 'low' );
	//add_meta_box( 'pixad_auto_gallery_2', esc_html__( 'Gallery "Promo Images" ', 'pixad' ), 'pixad_auto_gallery_2', 'pixad-autos', 'side', 'low' );
	add_meta_box( 'pixad_auto_videos', esc_html__( 'YouTube Video URL', 'pixad' ), 'pixad_auto_videos', 'pixad-autos', 'side', 'low' );
	// add_meta_box( 'pixad_auto_gal_vid', esc_html__( 'Gallery Viodeo', 'pixad' ), 'pixad_auto_gallery_video', 'pixad-autos', 'side', 'low' );
	add_meta_box( 'pixad_auto_sidebar', esc_html__( 'Auto Layout', 'pixad'), 'pixad_auto_sidebar', 'pixad-autos', 'side', 'low');

	add_meta_box( 'pixad_auto_contacts', esc_html__( 'Contact Info', 'pixad' ), 'pixad_auto_contacts', 'pixad-autos', 'normal', 'low' );
	add_meta_box( 'pixad_auto_custom_1', esc_html__( 'Custom Tab 1', 'pixad' ), 'pixad_auto_custom_1', 'pixad-autos', 'normal', 'low' );
	add_meta_box( 'pixad_auto_custom_2', esc_html__( 'Custom Tab 2', 'pixad' ), 'pixad_auto_custom_2', 'pixad-autos', 'normal', 'low' );
	add_meta_box( 'pixad_auto_custom_3', esc_html__( 'Custom Tab 3', 'pixad' ), 'pixad_auto_custom_3', 'pixad-autos', 'normal', 'low' );

}
// The function that outputs the metabox html
function pixad_auto_gallery() {
    global $post;
    // Here we get the current images ids of the gallery
    $values = get_post_custom($post->ID);

    if(isset($values['pixad_auto_gallery'])) {
        $ids = json_decode(base64_decode( $values['pixad_auto_gallery'][0]));

    }
    else {
        $ids = array();
    }

    wp_nonce_field('pixad_meta_box_nonce', 'meta_box_nonce'); // Security
    // Implode the array to a comma separated list
    $cs_ids = is_array($ids) ? implode(",", $ids) : '';
    // We display the gallery
    $html  = do_shortcode('[gallery ids="'.$cs_ids.'"]');
    // Here we store the image ids which are used when saving the auto
    $html .= '<input id="pixad_auto_gallery_ids" type="hidden" name="pixad_auto_gallery_ids" value="'.$cs_ids. '" />';
    // A button which we will bind to later on in JavaScript
    $html .= '<input id="manage_gallery" title="Manage gallery" type="button" value="Manage gallery" />';
    $html .= '<input id="clear_gallery" title="Clear gallery" type="button" value="Clear gallery" />';
    echo $html;
}


function pixad_auto_gallery_2() {
    global $post;
    // Here we get the current images ids of the gallery
    $values = get_post_custom($post->ID);

    if(isset($values['pixad_auto_gallery_2'])) {
        $ids = json_decode(base64_decode( $values['pixad_auto_gallery_2'][0]));

    }
    else {
        $ids = array();
    }

    wp_nonce_field('pixad_meta_box_nonce', 'meta_box_nonce'); // Security
    // Implode the array to a comma separated list
    $cs_ids = is_array($ids) ? implode(",", $ids) : '';
    // We display the gallery
    $html  = do_shortcode('[gallery ids="'.$cs_ids.'"]');
    // Here we store the image ids which are used when saving the auto
    $html .= '<input id="pixad_auto_gallery_2_ids" type="hidden" name="pixad_auto_gallery_2_ids" value="'.$cs_ids. '" />';
    // A button which we will bind to later on in JavaScript
    $html .= '<input id="manage_gallery_2" title="Manage gallery" type="button" value="Manage gallery" />';
    $html .= '<input id="clear_gallery_2" title="Clear gallery" type="button" value="Clear gallery" />';
    echo $html;
}



// function pixad_auto_gallery_video() {
//     global $post;
//     // Here we get the current images ids of the gallery
//     $values = get_post_custom($post->ID);
//     if(isset($values['pixad_auto_gallery_video'])) {
// 	   	$str_ids = $values['pixad_auto_gallery_video'][0];
// 		$ids_video = explode(",", $str_ids);
// 		wp_nonce_field('pixad_meta_box_nonce', 'meta_box_nonce'); // Security

// 	    $html  = do_shortcode('[playlist type="video"  ids="'.$str_ids.'"]');
// 	    $html .= '<input id="pixad_auto_gallery_video" type="hidden" name="pixad_auto_gallery_video" value="'.$str_ids. '" />';
//     	$html .= '<input id="manage_gallery_video" title="Manage gallery" type="button" value="Manage gallery" />';
//     	$html .= '<input id="clear_gallery_video" title="Clear gallery" type="button" value="Clear gallery" />';
// 	    echo $html;
//     }else{
//     	echo '';
//     }
// }

function vardd($var) {
  echo '<pre class="aaaa" style="display:none">';
  var_dump($var);
  echo '</pre>';
}



// The function that outputs the metabox html
function pixad_auto_sidebar() {
    global $post;

    $sel_l = get_post_meta( get_the_ID(), 'pixad_auto_sidebar_layout', true );
	?>
	    <p><strong><?php echo esc_html__('Sidebar Position', 'pixad')?></strong></p>
		<select class="rwmb-select" name="pixad_auto_sidebar_layout" />
    	    <option value="" <?php selected( $sel_l, '', true ); ?> ><?php esc_html_e( 'Right', 'pixad') ?></option>
            <option value="left" <?php selected( $sel_l, 'left', true ); ?> ><?php esc_html_e( 'Left', 'pixad') ?></option>
			<option value="none" <?php selected( $sel_l, 'none', true ); ?> ><?php esc_html_e( 'None', 'pixad') ?></option>
        </select>
    <?php

    $sel_dl = get_post_meta( get_the_ID(), 'pixad_auto_dealer_info', true ) != '' ? get_post_meta( get_the_ID(), 'pixad_auto_dealer_info', true ) : 1;
    ?>
    <p><strong><?php echo esc_html__('Dealer Info', 'pixad')?></strong></p>
    <select class="rwmb-select" name="pixad_auto_dealer_info" />
    <option value="1" <?php selected( $sel_dl, '1', true ); ?> ><?php esc_html_e( 'Show', 'pixad') ?></option>
    <option value="0" <?php selected( $sel_dl, '0', true ); ?> ><?php esc_html_e( 'Hide', 'pixad') ?></option>
    </select>

    <?php

    $sel_cf = get_post_meta( get_the_ID(), 'pixad_auto_contacts_form', true ) != '' ? get_post_meta( get_the_ID(), 'pixad_auto_contacts_form', true ) : 1;
    ?>
    <p><strong><?php echo esc_html__('Contacts Form', 'pixad')?></strong></p>
    <select class="rwmb-select" name="pixad_auto_contacts_form" />
    <option value="1" <?php selected( $sel_cf, '1', true ); ?> ><?php esc_html_e( 'Show', 'pixad') ?></option>
    <option value="0" <?php selected( $sel_cf, '0', true ); ?> ><?php esc_html_e( 'Hide', 'pixad') ?></option>
    </select>
    <?php $sel_l = get_post_meta( get_the_ID(), 'pixad_auto_form', true )?>

    <select class="rwmb-select" name="pixad_auto_form" />
        <?php

        $contact_forms = pixad_cf7_forms();
        foreach($contact_forms as $key => $value)
        { ?>

            <option value="<?php echo $value ?>" <?php selected( $sel_l, $value, true ); ?> > <?php  echo  $key  ?></option>
        <?php }
        ?>
    </select>


    <?php

    $sel_calc = get_post_meta( get_the_ID(), 'pixad_auto_calc', true ) != '' ? get_post_meta( get_the_ID(), 'pixad_auto_calc', true ) : 0;
    ?>
    <p><strong><?php echo esc_html__('Financing Calculator', 'pixad')?></strong></p>
    <select class="rwmb-select" name="pixad_auto_calc" />
    <option value="0" <?php selected( $sel_calc, '0', true ); ?> ><?php esc_html_e( 'Hide', 'pixad') ?></option>
    <option value="1" <?php selected( $sel_calc, '1', true ); ?> ><?php esc_html_e( 'Show', 'pixad') ?></option>
    </select>


	<?php

	$sel_d = get_post_meta( get_the_ID(), 'pixad_auto_description_tab', true ) != '' ? get_post_meta( get_the_ID(), 'pixad_auto_description_tab', true ) : 1;
	?>
	    <p><strong><?php echo esc_html__('Vehicle Description Tab', 'pixad')?></strong></p>
		<select class="rwmb-select" name="pixad_auto_description_tab" />
    	    <option value="1" <?php selected( $sel_d, '1', true ); ?> ><?php esc_html_e( 'Show', 'pixad') ?></option>
            <option value="0" <?php selected( $sel_d, '0', true ); ?> ><?php esc_html_e( 'Hide', 'pixad') ?></option>
        </select>
	<?php




	$sel_f = get_post_meta( get_the_ID(), 'pixad_auto_features_tab', true ) != '' ? get_post_meta( get_the_ID(), 'pixad_auto_features_tab', true ) : 1;
	?>
	    <p><strong><?php echo esc_html__('Features Tab', 'pixad')?></strong></p>
		<select class="rwmb-select" name="pixad_auto_features_tab" />
    	    <option value="1" <?php selected( $sel_f, '1', true ); ?> ><?php esc_html_e( 'Show', 'pixad') ?></option>
            <option value="0" <?php selected( $sel_f, '0', true ); ?> ><?php esc_html_e( 'Hide', 'pixad') ?></option>
        </select>
	<?php

	$sel_c = get_post_meta( get_the_ID(), 'pixad_auto_contacts_tab', true ) != '' ? get_post_meta( get_the_ID(), 'pixad_auto_contacts_tab', true ) : 1;
	?>
	    <p><strong><?php echo esc_html__('Contacts Tab', 'pixad')?></strong></p>
		<select class="rwmb-select" name="pixad_auto_contacts_tab" />
    	    <option value="1" <?php selected( $sel_c, '1', true ); ?> ><?php esc_html_e( 'Show', 'pixad') ?></option>
            <option value="0" <?php selected( $sel_c, '0', true ); ?> ><?php esc_html_e( 'Hide', 'pixad') ?></option>
        </select>


	<?php


}


function pixad_auto_videos() {
	global $post;
	?>
	<div id="auto_video_container">
	<?php
	$auto_video_code = get_post_meta( $post->ID, '_auto_video_code', true );
	$video = wp_unslash( json_decode(pixad_get_meta('_auto_video_code')));
?>
	<div class="auto_iframe_video">
		<?php $auto_video_code = json_encode($auto_video_code); ?>
		<input name="auto_video_code" id="auto_video_code" value="<?php echo esc_attr( $video ); ?>" ></input>
		
	</div>
	<script>
		jQuery(document).ready(function($){

			// Uploading files
			var auto_gallery_frame;
			var $image_gallery_ids = $('#auto_video_gallery');
			var $auto_images = $('#auto_video_container ul.auto_video');

			jQuery('.add_auto_video').on( 'click', 'a', function( event ) {

				var $el = $(this);
				var attachment_ids = $image_gallery_ids.val();

				event.preventDefault();

				// If the media frame already exists, reopen it.
				if ( auto_gallery_frame ) {
					auto_gallery_frame.open();
					return;
				}

				// Create the media frame.
				auto_gallery_frame = wp.media.frames.downloadable_file = wp.media({
					// Set the title of the modal.
					title: '<?php _e( 'Add Images to Product Gallery', 'pixad' ); ?>',
					button: {
						text: '<?php _e( 'Add to gallery', 'pixad' ); ?>',
					},
					multiple: true,
					library : { type : 'video'}
				});

				// When an image is selected, run a callback.
				auto_gallery_frame.on( 'select', function() {

					var selection = auto_gallery_frame.state().get('selection');

					selection.map( function( attachment ) {

						attachment = attachment.toJSON();

						if ( attachment.id ) {
							attachment_ids = attachment_ids ? attachment_ids + "," + attachment.id : attachment.id;

							$auto_images.append('\
								<li class="video" data-attachment_id="' + attachment.id + '">\
									Video\
									<ul class="actions">\
										<li><a href="#" class="delete" title="<?php _e( 'Delete video', 'pixad' ); ?>"><?php _e( 'Delete', 'pixad' ); ?></a></li>\
									</ul>\
								</li>');
						}

					} );

					$image_gallery_ids.val( attachment_ids );
				});

				// Finally, open the modal.
				auto_gallery_frame.open();
			});

			// Image ordering
			$auto_images.sortable({
				items: 'li.video',
				cursor: 'move',
				scrollSensitivity:40,
				forcePlaceholderSize: true,
				forceHelperSize: false,
				helper: 'clone',
				opacity: 0.65,
				placeholder: 'wc-metabox-sortable-placeholder',
				start:function(event,ui){
					ui.item.css('background-color','#f6f6f6');
				},
				stop:function(event,ui){
					ui.item.removeAttr('style');
				},
				update: function(event, ui) {
					var attachment_ids = '';

					$('#auto_video_container ul li.video').css('cursor','default').each(function() {
						var attachment_id = jQuery(this).attr( 'data-attachment_id' );
						attachment_ids = attachment_ids + attachment_id + ',';
					});

					$image_gallery_ids.val( attachment_ids );
				}
			});

			// Remove images
			$('#auto_video_container').on( 'click', 'a.delete', function() {

				$(this).closest('li.video').remove();

				var attachment_ids = '';

				$('#auto_video_container ul li.video').css('cursor','default').each(function() {
					var attachment_id = jQuery(this).attr( 'data-attachment_id' );
					attachment_ids = attachment_ids + attachment_id + ',';
				});

				$image_gallery_ids.val( attachment_ids );

				return false;
			} );

		});
	</script>
	</div>
	<?php
}


function pixad_auto_contacts( $post ){
    //so, dont ned to use esc_attr in front of get_post_meta
    $value =  get_post_meta($_GET['post'], 'pixad_auto_contact' , true ) ;
    wp_editor( $value, 'pixad_auto_contacts_editor', $settings = array('textarea_name'=>'pixad_auto_contact_info', 'editor_height'=>100) );
}

function pixad_auto_custom_1( $post ){

    $custom_title_1 = get_post_meta( $post->ID, 'pixad_auto_custom_title_1', true );
    ?>
    <div class="pixad-panel">
		<div class="pixad-panel-body">
			<div class="pixad-form-horizontal">
			    <div class="">
				    <label class="col-lg-1 pixad-control-label">
						<?php _e( 'Tab Title', 'pixad' ); ?>
					</label>
					<div class="col-lg-10">
						<input name="pixad_auto_custom_title_1" type="text" value="<?php echo esc_attr($custom_title_1); ?>" class="pixad-form-control">
					</div>
				</div>
			</div>
		</div>
	</div>
	<?php

    $value =  get_post_meta($post->ID, 'pixad_auto_custom_content_1' , true ) ;
    wp_editor( $value, 'pixad_auto_custom_editor_1', $settings = array('textarea_name'=>'pixad_auto_custom_info_1', 'editor_height'=>150) );

}

function pixad_auto_custom_2( $post ){

    $custom_title_2 = get_post_meta( $post->ID, 'pixad_auto_custom_title_2', true );
    ?>
    <div class="pixad-panel">
		<div class="pixad-panel-body">
			<div class="pixad-form-horizontal">
			    <div class="">
				    <label class="col-lg-1 pixad-control-label">
						<?php _e( 'Tab Title', 'pixad' ); ?>
					</label>
					<div class="col-lg-10">
						<input name="pixad_auto_custom_title_2" type="text" value="<?php echo esc_attr($custom_title_2); ?>" class="pixad-form-control">
					</div>
				</div>
			</div>
		</div>
	</div>
	<?php

    $value =  get_post_meta($post->ID, 'pixad_auto_custom_content_2' , true ) ;
    wp_editor( $value, 'pixad_auto_custom_editor_2', $settings = array('textarea_name'=>'pixad_auto_custom_info_2', 'editor_height'=>150) );

}

function pixad_auto_custom_3( $post ){

    $custom_title_3 = get_post_meta( $post->ID, 'pixad_auto_custom_title_3', true );
    ?>
    <div class="pixad-panel">
		<div class="pixad-panel-body">
			<div class="pixad-form-horizontal">
			    <div class="">
				    <label class="col-lg-1 pixad-control-label">
						<?php _e( 'Tab Title', 'pixad' ); ?>
					</label>
					<div class="col-lg-10">
						<input name="pixad_auto_custom_title_3" type="text" value="<?php echo esc_attr($custom_title_3); ?>" class="pixad-form-control">
					</div>
				</div>
			</div>
		</div>
	</div>
	<?php

    $value =  get_post_meta($post->ID, 'pixad_auto_custom_content_3' , true ) ;
    wp_editor( $value, 'pixad_auto_custom_editor_3', $settings = array('textarea_name'=>'pixad_auto_custom_info_3', 'editor_height'=>150) );

}




/**
 * Get Meta Value
 *
 * @since 0.1
 */
function pixad_get_meta( $key ) {
	return sanitize_text_field( get_post_meta( get_the_ID(), $key, true ) );
}
/**
 * Auto Details MetaBox
 *
 * @since 0.1
 */
function pixad_auto_details() {
	global $post;
	$Settings = new PIXAD_Settings();
	$validate = $Settings->getSettings( 'WP_OPTIONS', '_pixad_autos_validation', true ); // Get validation settings

	$validate = pixad::validation( $validate );
	$currencies = unserialize( get_option( '_pixad_autos_currencies' ) ); ?>
	
<input name="pixad_autos-meta" type="hidden" value="save">

<div class="pixad-panel">
	<div class="pixad-panel-body">
		<div class="pixad-form-horizontal">

			<?php if( $validate['auto-version_show'] || $validate['auto-version_req'] ): ?>
			<div class="pixad-form-group">
				<label class="col-lg-2 pixad-control-label">
					<?php _e( 'Auto Version', 'pixad' ); ?>
				</label>
				<div class="col-lg-9">
					<input name="auto-version" type="text" placeholder="eg: 1.6 hdi" value="<?php echo pixad_get_meta( '_auto_version' ); ?>" class="pixad-form-control">
				</div>
			</div>
			<?php endif; ?>

			<?php if( $validate['auto-year_show'] || $validate['auto-year_req'] ): ?>
			<div class="pixad-form-group">
				<label class="col-lg-2 pixad-control-label">
					<?php _e( 'Made Year', 'pixad' ); ?>
				</label>
				<div class="col-lg-9">
				    <input name="auto-year" type="number" min="1930" max="<?php echo (date('Y')+1) ?>" placeholder="eg: 2017" value="<?php echo pixad_get_meta('_auto_year'); ?>" class="pixad-form-control">
				</div>
			</div>
			<?php endif; ?>

			<?php if( $validate['auto-transmission_show'] || $validate['auto-transmission_req'] ): ?>
			<div class="pixad-form-group">
				<label class="col-lg-2 pixad-control-label">
					<?php _e( 'Transmission', 'pixad' ); ?>
				</label>
				<div class="col-lg-9">
					<select name="auto-transmission" class="pixad-form-control">
						<option value=""><?php _e( '-- Please Select --', 'pixad' ); ?></option>
						<option value="automatic" <?php if(pixad_get_meta('_auto_transmission')=='automatic') echo 'selected'; ?>><?php _e( 'Automatic', 'pixad' ); ?></option>
						<option value="manual" <?php if(pixad_get_meta('_auto_transmission')=='manual') echo 'selected'; ?>><?php _e( 'Manual', 'pixad' ); ?></option>
						<option value="semi-automatic" <?php if(pixad_get_meta('_auto_transmission')=='semi-automatic') echo 'selected'; ?>><?php _e( 'Semi-Auto', 'pixad' ); ?></option>
					</select>
				</div>
			</div>
			<?php endif; ?>

			<?php if( $validate['auto-doors_show'] || $validate['auto-doors_req'] ): ?>
			<div class="pixad-form-group">
				<label class="col-lg-2 pixad-control-label">
					<?php _e( 'Doors', 'pixad' ); ?>
				</label>
				<div class="col-lg-9">
					<select name="auto-doors" class="pixad-form-control">
						<option value=""><?php _e( '-- Please Select --', 'pixad' ); ?></option>
						<?php pixad_get_options_range( 2, 5, pixad_get_meta('_auto_doors') ); ?>
					</select>
				</div>
			</div>
			<?php endif; ?>

			<?php if( $validate['auto-fuel_show'] || $validate['auto-fuel_req'] ): ?>
			<div class="pixad-form-group">
				<label class="col-lg-2 pixad-control-label">
					<?php _e( 'Fuel Type', 'pixad' ); ?>
				</label>
				<div class="col-lg-9">
					<select name="auto-fuel" class="pixad-form-control">
						<option value=""><?php _e( '-- Please Select --', 'pixad' ); ?></option>
                        <option value="petrol" <?php if(pixad_get_meta('_auto_fuel')=='petrol') echo 'selected'; ?>><?php _e( 'Petrol', 'pixad' ); ?></option>
                        <option value="diesel" <?php if(pixad_get_meta('_auto_fuel')=='diesel') echo 'selected'; ?>><?php _e( 'Diesel', 'pixad' ); ?></option>
						<option value="electric" <?php if(pixad_get_meta('_auto_fuel')=='electric') echo 'selected'; ?>><?php _e( 'Electric', 'pixad' ); ?></option>
						<option value="petrol" <?php selected( 'petrol', pixad_get_meta('_auto_fuel'), true ); ?>><?php _e( 'Petrol', 'pixad' ); ?></option>
						<option value="hybrid" <?php if(pixad_get_meta('_auto_fuel')=='hybrid') echo 'selected'; ?>><?php _e( 'Hybrid', 'pixad' ); ?></option>
						<option value="petrol+cng" <?php if(pixad_get_meta('_auto_fuel')=='petrol+cng') echo 'selected'; ?>><?php _e( 'Petrol+CNG', 'pixad' ); ?></option>
						<option value="lpg" <?php if(pixad_get_meta('_auto_fuel')=='lpg') echo 'selected'; ?>><?php _e( 'LPG', 'pixad' ); ?></option>
					</select>
				</div>
			</div>
			<?php endif; ?>

			<?php if( $validate['auto-condition_show'] || $validate['auto-condition_req'] ): ?>
			<div class="pixad-form-group">
				<label class="col-lg-2 pixad-control-label">
					<?php _e( 'Auto Condition', 'pixad' ); ?>
				</label>
				<div class="col-lg-9">
					<select name="auto-condition" class="pixad-form-control">
						<option value=""><?php _e( '-- Please Select --', 'pixad' ); ?></option>
						<option value="new" <?php if(pixad_get_meta('_auto_condition')=='new') echo 'selected'; ?>><?php _e( 'New', 'pixad' ); ?></option>
						<option value="used" <?php if(pixad_get_meta('_auto_condition')=='used') echo 'selected'; ?>><?php _e( 'Used', 'pixad' ); ?></option>
						<option value="driver" <?php if(pixad_get_meta('_auto_condition')=='driver') echo 'selected'; ?>><?php _e( 'Driver', 'pixad' ); ?></option>
						<option value="non driver" <?php if(pixad_get_meta('_auto_condition')=='non driver') echo 'selected'; ?>><?php _e( 'Non driver', 'pixad' ); ?></option>
						<option value="projectcar" <?php if(pixad_get_meta('_auto_condition')=='projectcar') echo 'selected'; ?>><?php _e( 'Projectcar', 'pixad' ); ?></option>
						<option value="barnfind" <?php if(pixad_get_meta('_auto_condition')=='barnfind') echo 'selected'; ?>><?php _e( 'Barnfind', 'pixad' ); ?></option>
					</select>
				</div>
			</div>
            <?php endif; ?>

			<?php if( $validate['auto-purpose_show'] || $validate['auto-purpose_req'] ): ?>
			<div class="pixad-form-group">
				<label class="col-lg-2 pixad-control-label">
					<?php _e( 'Auto Purpose', 'pixad' ); ?>
				</label>
				<div class="col-lg-9">
					<select name="auto-purpose" class="pixad-form-control">
						<option value=""><?php _e( '-- Please Select --', 'pixad' ); ?></option>
						<option value="rent" <?php if(pixad_get_meta('_auto_purpose')=='rent') echo 'selected'; ?>><?php _e( 'Rent', 'pixad' ); ?></option>
						<option value="experience" <?php if(pixad_get_meta('_auto_purpose')=='experience') echo 'selected'; ?>><?php _e( 'Experience', 'pixad' ); ?></option>
						<option value="sell" <?php if(pixad_get_meta('_auto_purpose')=='sell') echo 'selected'; ?>><?php _e( 'Sell', 'pixad' ); ?></option>
					</select>
				</div>
			</div>
			<?php endif; ?>
			
			<?php if( $validate['auto-drive_show'] || $validate['auto-drive_req'] ): ?>
			<div class="pixad-form-group">
				<label class="col-lg-2 pixad-control-label">
					<?php _e( 'Auto Drive', 'pixad' ); ?>
				</label>
				<div class="col-lg-9">
					<select name="auto-drive" class="pixad-form-control">
						<option value=""><?php _e( '-- Please Select --', 'pixad' ); ?></option>
						<option value="front" <?php if(pixad_get_meta('_auto_drive')=='front') echo 'selected'; ?>><?php _e( 'Front', 'pixad' ); ?></option>
						<option value="rear" <?php if(pixad_get_meta('_auto_drive')=='rear') echo 'selected'; ?>><?php _e( 'Rear', 'pixad' ); ?></option>
						<option value="4x4" <?php if(pixad_get_meta('_auto_drive')=='4x4') echo 'selected'; ?>><?php _e( '4x4', 'pixad' ); ?></option>
					</select>
				</div>
			</div>
			<?php endif; ?>

			<?php if( $validate['auto-color_show'] || $validate['auto-color_req'] ): ?>
			<div class="pixad-form-group">
				<label class="col-lg-2 pixad-control-label">
					<?php _e( 'Color', 'pixad' ); ?>
				</label>
				<div class="col-lg-9">
					<input name="auto-color" type="text" placeholder="eg: red" value="<?php echo pixad_get_meta('_auto_color'); ?>" list="color_option" class="pixad-form-control">
					<datalist id="color_option">
                        <option value="white"><?php esc_attr_e( 'white', 'pixad' ); ?></option>
                        <option value="silver"><?php esc_attr_e( 'silver', 'pixad' ); ?></option>
                        <option value="black"><?php esc_attr_e( 'black', 'pixad' ); ?></option>
                        <option value="grey"><?php esc_attr_e( 'grey', 'pixad' ); ?></option>
                        <option value="blue"><?php esc_attr_e( 'blue', 'pixad' ); ?></option>
                        <option value="red"><?php esc_attr_e( 'red', 'pixad' ); ?></option>
                        <option value="brown"><?php esc_attr_e( 'brown', 'pixad' ); ?></option>
                        <option value="green"><?php esc_attr_e( 'green', 'pixad' ); ?></option>
                        <option value="yellow"><?php esc_attr_e( 'yellow', 'pixad' ); ?></option>
                        <option value="orange"><?php esc_attr_e( 'orange', 'pixad' ); ?></option>
                        <option value="purple"><?php esc_attr_e( 'purple', 'pixad' ); ?></option>
					</datalist>
				</div>
			</div>
			<?php endif; ?>

			<?php if( $validate['auto-color-int_show'] || $validate['auto-color-int_req'] ): ?>
			<div class="pixad-form-group">
				<label class="col-lg-2 pixad-control-label">
					<?php _e( 'Interior Color', 'pixad' ); ?>
				</label>
				<div class="col-lg-9">
					<input name="auto-color-int" type="text" placeholder="eg: black" value="<?php echo pixad_get_meta('_auto_color_int'); ?>" list="color_int_option" class="pixad-form-control">
					<datalist id="color_int_option">
					    <option value="white"><?php esc_attr_e( 'white', 'pixad' ); ?></option>
                        <option value="silver"><?php esc_attr_e( 'silver', 'pixad' ); ?></option>
                        <option value="black"><?php esc_attr_e( 'black', 'pixad' ); ?></option>
                        <option value="grey"><?php esc_attr_e( 'grey', 'pixad' ); ?></option>
                        <option value="blue"><?php esc_attr_e( 'blue', 'pixad' ); ?></option>
                        <option value="red"><?php esc_attr_e( 'red', 'pixad' ); ?></option>
                        <option value="brown"><?php esc_attr_e( 'brown', 'pixad' ); ?></option>
                        <option value="beige"><?php esc_attr_e( 'beige', 'pixad' ); ?></option>
					</datalist>
				</div>
			</div>
			<?php endif; ?>

			<?php if( $validate['auto-price_show'] || $validate['auto-price_req'] ): ?>
			<div class="pixad-form-group">
				<label class="col-lg-2 pixad-control-label">
					<?php _e( 'Price', 'pixad' ); ?>
				</label>
				<div class="col-lg-9">
					<input name="auto-price" type="text" placeholder="eg: 10000" value="<?php echo pixad_get_meta('_auto_price'); ?>" list="price_option" class="pixad-form-control">
					<datalist id="price_option">
					  <option value="Request"><?php esc_attr_e( 'Request', 'pixad' ); ?></option>
					  <option value="Reserved"><?php esc_attr_e( 'Reserved', 'pixad' ); ?></option>
					  <option value="POA"><?php esc_attr_e( 'POA', 'pixad' ); ?></option>
					</datalist>
					<span class="errprice"></span>
				</div>
			</div>
            <?php endif; ?>

            <?php if( $validate['auto-sale-price_show'] ): ?>
			<div class="pixad-form-group">
				<label class="col-lg-2 pixad-control-label">
					<?php _e( 'Sale Price', 'pixad' ); ?>
				</label>
				<div class="col-lg-9">
					<input name="auto-sale-price" type="text" placeholder="eg: 9000" value="<?php echo pixad_get_meta('_auto_sale_price'); ?>" class="pixad-form-control">
					<span class="errprice"></span>
				</div>
			</div>
            <?php endif; ?>

			<?php if( $validate['auto-stock-status_show'] || $validate['auto-stock-status_req'] ): ?>
			<div class="pixad-form-group">
				<label class="col-lg-2 pixad-control-label">
					<?php _e( 'Stock status', 'pixad' ); ?>
				</label>
				<div class="col-lg-9">
					<select name="auto-stock-status" class="pixad-form-control">
						<option value="in stock" <?php selected( 'in stock', pixad_get_meta('_auto_stock_status'), true ); ?>><?php _e( 'In stock', 'pixad' ); ?></option>
						<option value="expected" <?php selected( 'expected', pixad_get_meta('_auto_stock_status'), true ); ?>><?php _e( 'Expected', 'pixad' ); ?></option>
						<option value="out of stock" <?php selected( 'out of stock', pixad_get_meta('_auto_stock_status'), true ); ?>><?php _e( 'Out of stock', 'pixad' ); ?></option>
					</select>
				</div>
			</div>
            <?php endif; ?>

			<?php if( $validate['auto-price-type_show'] || $validate['auto-price-type_req'] ): ?>
			<div class="pixad-form-group">
				<label class="col-lg-2 pixad-control-label">
					<?php _e( 'Price Type', 'pixad' ); ?>
				</label>
				<div class="col-lg-9">
					<select name="auto-price-type" class="pixad-form-control">
						<option value="fixed" <?php selected( 'fixed', pixad_get_meta('_auto_price_type'), true ); ?>><?php _e( 'Fixed', 'pixad' ); ?></option>
						<option value="negotiable" <?php selected( 'negotiable', pixad_get_meta('_auto_price_type'), true ); ?>><?php _e( 'Negotiable', 'pixad' ); ?></option>
					</select>
				</div>
			</div>
			<?php endif; ?>

			<?php if( $validate['auto-warranty_show'] || $validate['auto-warranty_req'] ): ?>
			<div class="pixad-form-group">
				<label class="col-lg-2 pixad-control-label">
					<?php _e( 'Warranty', 'pixad' ); ?>
				</label>
				<div class="col-lg-9">
					<select name="auto-warranty" class="pixad-form-control">
						<option value="no" <?php selected( 'no', pixad_get_meta('_auto_warranty'), true ); ?>><?php _e( 'No', 'pixad' ); ?></option>
						<option value="yes" <?php selected( 'yes', pixad_get_meta('_auto_warranty'), true ); ?>><?php _e( 'Yes', 'pixad' ); ?></option>
					</select>
				</div>
			</div>
			<?php endif; ?>

<?php /* ?>
			<div class="pixad-form-group">
				<label class="col-lg-2 pixad-control-label">
					<?php _e( 'Currency', 'pixad' ); ?>
				</label>
				<div class="col-lg-9">
					<select name="currency" class="pixad-form-control">
					<?php if( $currencies ): foreach( $currencies as $currency ): ?>

						<option value="<?php echo $currency['iso']; ?>" <?php selected( pixad_get_meta('_auto_currency'), $currency['iso'], true ); ?>><?php echo $currency['iso']; ?></option>

					<?php endforeach; else: ?>

						<option value="EUR" <?php selected( pixad_get_meta('_auto_currency'), 'EUR', true ); ?>><?php echo 'EUR'; ?></option>
						<option value="USD" <?php selected( pixad_get_meta('_auto_currency'), 'USD', true ); ?>><?php echo 'USD'; ?></option>

					<?php endif; ?>
					</select>
				</div>
			</div>
<?php */ ?>
            <?php if( $validate['auto-mileage_show'] || $validate['auto-mileage_req'] ): ?>
			<div class="pixad-form-group">
				<label class="col-lg-2 pixad-control-label">
					<?php _e( 'Mileage', 'pixad' ); ?>
				</label>
				<div class="col-lg-9">
					<input name="auto-mileage" type="text" placeholder="eg: 100000" value="<?php echo pixad_get_meta('_auto_mileage'); ?>" class="pixad-form-control">
					<span class="errmileage"></span>
				</div>
			</div>
			<?php endif; ?>

			<?php if( $validate['auto-vin_show'] || $validate['auto-vin_req'] ): ?>
			<div class="pixad-form-group">
				<label class="col-lg-2 pixad-control-label">
					<?php _e( 'VIN', 'pixad' ); ?>
				</label>
				<div class="col-lg-9">
					<input name="auto-vin" type="text" placeholder="eg: 1VXBR12EXCP901213" value="<?php echo pixad_get_meta('_auto_vin'); ?>" class="pixad-form-control">
				</div>
			</div>
			<?php endif; ?>

			<?php if( $validate['auto-engine_show'] || $validate['auto-engine_req'] ): ?>
			<div class="pixad-form-group">
				<label class="col-lg-2 pixad-control-label">
					<?php _e( 'Engine, cm3', 'pixad' ); ?>
				</label>
				<div class="col-lg-9">
					<input name="auto-engine" type="text" placeholder="eg: 1900" value="<?php echo pixad_get_meta('_auto_engine'); ?>" class="pixad-form-control">
					<span class="errengine"></span>
				</div>
			</div>
			<?php endif; ?>

			<?php if( $validate['auto-horsepower_show'] || $validate['auto-horsepower_req'] ): ?>
			<div class="pixad-form-group">
				<label class="col-lg-2 pixad-control-label">
					<?php _e( 'Horsepower, hp', 'pixad' ); ?>
				</label>
				<div class="col-lg-9">
					<input name="auto-horsepower" type="text" placeholder="eg: 200" value="<?php echo pixad_get_meta('_auto_horsepower'); ?>" class="pixad-form-control">
					<span class="errhorsepower"></span>
				</div>
			</div>
			<?php endif; ?>

			<?php if( $validate['auto-seats_show'] || $validate['auto-seats_req'] ): ?>
			<div class="pixad-form-group">
				<label class="col-lg-2 pixad-control-label">
					<?php _e( 'Seating Capacity', 'pixad' ); ?>
				</label>
				<div class="col-lg-9">
					<input name="auto-seats" type="text" placeholder="eg: 5" value="<?php echo pixad_get_meta('_auto_seats'); ?>" class="pixad-form-control">
					<span class="errseats"></span>
				</div>
			</div>
			<?php endif; ?>

			<?php if( $validate['first-name_show'] || $validate['first-name_req'] ): ?>
			<div class="pixad-form-group">
				<label class="col-lg-2 pixad-control-label">
					<?php _e( 'Seller first name', 'pixad' ); ?>
				</label>
				<div class="col-lg-9">
					<input name="seller-first-name" type="text" placeholder="eg: John" value="<?php echo pixad_get_meta('_seller_first_name'); ?>" class="pixad-form-control">
				</div>
			</div>
			<?php endif; ?>

			<?php if( $validate['last-name_show'] || $validate['last-name_req'] ): ?>
			<div class="pixad-form-group">
				<label class="col-lg-2 pixad-control-label">
					<?php _e( 'Seller last name', 'pixad' ); ?>
				</label>
				<div class="col-lg-9">
					<input name="seller-last-name" type="text" placeholder="eg: Doe" value="<?php echo pixad_get_meta('_seller_last_name'); ?>" class="pixad-form-control">
				</div>
			</div>
			<?php endif; ?>

			<?php if( $validate['seller-email_show'] || $validate['seller-email_req'] ): ?>
			<div class="pixad-form-group">
				<label class="col-lg-2 pixad-control-label">
					<?php _e( 'Seller email', 'pixad' ); ?>
				</label>
				<div class="col-lg-9">
					<input name="seller-email" type="text" placeholder="eg: johndoe@gmail.com" value="<?php echo pixad_get_meta('_seller_email'); ?>" class="pixad-form-control">
				</div>
			</div>
			<?php endif; ?>

			<?php if( $validate['seller-phone_show'] || $validate['seller-phone_req'] ): ?>
			<div class="pixad-form-group">
				<label class="col-lg-2 pixad-control-label">
					<?php _e( 'Seller phone', 'pixad' ); ?>
				</label>
				<div class="col-lg-9">
					<input name="seller-phone" type="text" placeholder="eg: +38160656545" value="<?php echo pixad_get_meta('_seller_phone'); ?>" class="pixad-form-control">
				</div>
			</div>
			<?php endif; ?>

			<?php if( $validate['seller-company_show'] || $validate['seller-company_req'] ): ?>
			<div class="pixad-form-group">
				<label class="col-lg-2 pixad-control-label">
					<?php _e( 'Seller company', 'pixad' ); ?>
				</label>
				<div class="col-lg-9">
					<input name="seller-company" type="text" placeholder="eg: General Motors" value="<?php echo pixad_get_meta('_seller_company'); ?>" class="pixad-form-control">
				</div>
			</div>
			<?php endif; ?>

			<?php if( $validate['seller-country_show'] || $validate['seller-country_req'] ): ?>
			<div class="pixad-form-group">
				<label class="col-lg-2 pixad-control-label">
					<?php _e( 'Seller country', 'pixad' ); ?>
				</label>
				<div class="col-lg-9">
					<select name="seller-country" class="pixad-form-control">
						<option value=""><?php _e( '-- Please Select --', 'pixad' ); ?></option>
						<?php $country = new PIXAD_Country(); $country->option_output( pixad_get_meta('_seller_country') ); ?>
					</select>
				</div>
			</div>
			<?php endif; ?>

			<?php if( $validate['seller-state_show'] || $validate['seller-state_req'] ): ?>
			<div class="pixad-form-group">
				<label class="col-lg-2 pixad-control-label">
					<?php _e( 'Seller state', 'pixad' ); ?>
				</label>
				<div class="col-lg-9">
					<input name="seller-state" type="text" placeholder="eg: Texas" value="<?php echo pixad_get_meta('_seller_state'); ?>" class="pixad-form-control">
				</div>
			</div>
			<?php endif; ?>

			<?php if( $validate['seller-town_show'] || $validate['seller-town_req'] ): ?>
			<div class="pixad-form-group">
				<label class="col-lg-2 pixad-control-label">
					<?php _e( 'Seller town', 'pixad' ); ?>
				</label>
				<div class="col-lg-9">
					<input name="seller-town" type="text" placeholder="eg: Atlanta" value="<?php echo pixad_get_meta('_seller_town'); ?>" class="pixad-form-control">
				</div>
			</div>
            <?php endif; ?>

			<?php if( $validate['seller-location_show'] || $validate['seller-location_req'] ): ?>
			<div class="pixad-form-group">
				<label class="col-lg-2 pixad-control-label">
					<?php _e( 'Seller location label', 'pixad' ); ?>
				</label>
				<div class="col-lg-9">
					<input name="seller-location" type="text" placeholder="eg: 1410 W Cheltenham Ave, Philadelphia, PA 19126, United States" value="<?php echo pixad_get_meta('_seller_location'); ?>" class="pixad-form-control">
				</div>
			</div>
            <?php endif; ?>

			<?php if( $validate['seller-location-lat_show'] || $validate['seller-location-lat_req'] ): ?>
			<div class="pixad-form-group">
				<label class="col-lg-2 pixad-control-label">
					<?php _e( 'Seller location latitude', 'pixad' ); ?>
				</label>
				<div class="col-lg-9">
					<input name="seller-location-lat" type="text" placeholder="eg: 40.0632723" value="<?php echo pixad_get_meta('_seller_location_lat'); ?>" class="pixad-form-control">
				</div>
			</div>
            <?php endif; ?>

			<?php if( $validate['seller-location-long_show'] || $validate['seller-location-long_req'] ): ?>
			<div class="pixad-form-group">
				<label class="col-lg-2 pixad-control-label">
					<?php _e( 'Seller location longitude', 'pixad' ); ?>
				</label>
				<div class="col-lg-9">
					<input name="seller-location-long" type="text" placeholder="eg: -75.1411223" value="<?php echo pixad_get_meta('_seller_location_long'); ?>" class="pixad-form-control">
				</div>
			</div>
			<?php endif; ?>

		<?php 
			$custom_settings_quantity = 1;
			$max_custom_settings_quantity = 10;
			$group_custom_settings_quantity = 1;

			while ($group_custom_settings_quantity <= 8) {?>
<?php if($validate['custom_'. $custom_settings_quantity .'_show']): ?>
			<div class="pixad-form-group"> <h3><?php echo $validate['group_'. $group_custom_settings_quantity .'_title']; ?> ( <small><?php echo $validate['group_'. $group_custom_settings_quantity .'_sub_title']; ?></small>)</h3> </div>
<?php endif; ?>
 			<?php  while ($custom_settings_quantity <= $max_custom_settings_quantity): ?>
					<?php if( $validate['custom_'. $custom_settings_quantity .'_show'] || $validate['custom_'. $custom_settings_quantity .'_req'] ): ?>
					<div class="pixad-form-group">
						<label class="col-lg-2 pixad-control-label">
							<?php echo $validate['custom_'. $custom_settings_quantity .'_name']; ?>
						</label>
						<div class="col-lg-9">
							<input name="custom_<?php echo $custom_settings_quantity; ?>" type="text" placeholder="" value="<?php echo pixad_get_meta('_custom_'. $custom_settings_quantity .''); ?>" class="pixad-form-control">
						</div>
					</div>
					<?php endif; ?>
					<?php	$custom_settings_quantity++ ; ?>
			<?php endwhile; 

				$group_custom_settings_quantity++ ;
				$max_custom_settings_quantity = $max_custom_settings_quantity + 10;

			} ?>

		</div>
	</div>
</div>
<?php } // End auto details

/**
 * Save Custom MetaBox fields
 *
 * @since 0.1
 * @return boolean
 */
function save_pixad_autos_meta_boxes( $post_id ) {
	
	// Checks save status
    $is_autosave = wp_is_post_autosave( $post_id );
    $is_revision = wp_is_post_revision( $post_id );
	
	if( isset( $_POST['pixad_autos-meta'] ) && $_POST['pixad_autos-meta'] == 'save' ) {
		$term_name = '';

		if(isset($_POST['tax_input']['auto-model'][1])){
			$term = get_term( $_POST['tax_input']['auto-model'][1] );
			$term_name = $term->name;
		}
        $encode_video = '';
        if (isset($_POST['auto_video_code']) && $_POST['auto_video_code'] != '') {
            $encode_video = json_encode($_POST['auto_video_code']);
        }

		$options = array(
			'_auto_make'			=> sanitize_text_field( $term_name ),
			'_auto_version'			=> sanitize_text_field( $_POST['auto-version'] ),
			'_auto_year'			=> sanitize_text_field( $_POST['auto-year'] ),
			'_auto_transmission'	=> sanitize_text_field( $_POST['auto-transmission'] ),
			'_auto_doors'			=> sanitize_text_field( $_POST['auto-doors'] ),
			'_auto_fuel'			=> sanitize_text_field( $_POST['auto-fuel'] ),
			'_auto_condition'		=> sanitize_text_field( $_POST['auto-condition'] ),
			'_auto_purpose'		    => sanitize_text_field( $_POST['auto-purpose'] ),
			'_auto_drive'			=> sanitize_text_field( $_POST['auto-drive'] ),
			'_auto_color'			=> sanitize_text_field( $_POST['auto-color'] ),
			'_auto_color_int'		=> sanitize_text_field( $_POST['auto-color-int'] ),
			'_auto_price'			=> sanitize_text_field( $_POST['auto-price'] ),
			'_auto_sale_price'		=> sanitize_text_field( $_POST['auto-sale-price'] ),
			'_auto_stock_status'	=> sanitize_text_field( $_POST['auto-stock-status'] ),
			'_auto_price_type'		=> sanitize_text_field( $_POST['auto-price-type'] ),
			'_auto_warranty'		=> sanitize_text_field( $_POST['auto-warranty'] ),
			//'_auto_currency'		=> sanitize_text_field( $_POST['currency'] ),
			'_auto_mileage'			=> sanitize_text_field( $_POST['auto-mileage'] ),
			'_auto_vin'				=> sanitize_text_field( $_POST['auto-vin'] ),
			'_auto_engine'			=> sanitize_text_field( $_POST['auto-engine'] ),
			'_auto_horsepower'		=> sanitize_text_field( $_POST['auto-horsepower'] ),
			'_auto_seats'			=> sanitize_text_field( $_POST['auto-seats'] ),
			'_auto_images'			=> sanitize_text_field( $_POST['auto-images'] ),
			'_seller_first_name'	=> sanitize_text_field( $_POST['seller-first-name'] ),
			'_seller_last_name'		=> sanitize_text_field( $_POST['seller-last-name'] ),
			'_seller_email'			=> sanitize_text_field( $_POST['seller-email'] ),
			'_seller_phone'			=> sanitize_text_field( $_POST['seller-phone'] ),
			'_seller_company'		=> sanitize_text_field( $_POST['seller-company'] ),
			'_seller_country'		=> sanitize_text_field( $_POST['seller-country'] ),
			'_seller_state'			=> sanitize_text_field( $_POST['seller-state'] ),
			'_seller_town'			=> sanitize_text_field( $_POST['seller-town'] ),
			'_seller_location'	    => sanitize_text_field( $_POST['seller-location'] ),
			'_seller_location_lat'	=> sanitize_text_field( $_POST['seller-location-lat'] ),
			'_seller_location_long'	=> sanitize_text_field( $_POST['seller-location-long'] ),
			'_auto_video_code'		=> sanitize_text_field( $encode_video ),
			'_custom_1'	            => sanitize_text_field( $_POST['custom_1'] ),
			'_custom_2'	            => sanitize_text_field( $_POST['custom_2'] ),
			'_custom_3'	            => sanitize_text_field( $_POST['custom_3'] ),
			'_custom_4'	            => sanitize_text_field( $_POST['custom_4'] ),
			'_custom_5'	            => sanitize_text_field( $_POST['custom_5'] ),
			'_custom_6'	            => sanitize_text_field( $_POST['custom_6'] ),
			'_custom_7'	            => sanitize_text_field( $_POST['custom_7'] ),
			'_custom_8'	            => sanitize_text_field( $_POST['custom_8'] ),
			'_custom_9'	            => sanitize_text_field( $_POST['custom_9'] ),
			'_custom_10'	        => sanitize_text_field( $_POST['custom_10'] ),
			'_custom_11'	        => sanitize_text_field( $_POST['custom_11'] ),
			'_custom_12'	        => sanitize_text_field( $_POST['custom_12'] ),
			'_custom_13'	        => sanitize_text_field( $_POST['custom_13'] ),
			'_custom_14'	        => sanitize_text_field( $_POST['custom_14'] ),
			'_custom_15'	        => sanitize_text_field( $_POST['custom_15'] ),
			'_custom_16'	        => sanitize_text_field( $_POST['custom_16'] ),
			'_custom_17'	        => sanitize_text_field( $_POST['custom_17'] ),
			'_custom_18'	        => sanitize_text_field( $_POST['custom_18'] ),
			'_custom_19'	        => sanitize_text_field( $_POST['custom_19'] ),
			'_custom_20'	        => sanitize_text_field( $_POST['custom_20'] ),
			'_custom_21'	        => sanitize_text_field( $_POST['custom_21'] ),
			'_custom_22'	        => sanitize_text_field( $_POST['custom_22'] ),
			'_custom_23'	        => sanitize_text_field( $_POST['custom_23'] ),
			'_custom_24'	        => sanitize_text_field( $_POST['custom_24'] ),
			'_custom_25'	        => sanitize_text_field( $_POST['custom_25'] ),
			'_custom_26'	        => sanitize_text_field( $_POST['custom_26'] ),
			'_custom_27'	        => sanitize_text_field( $_POST['custom_27'] ),
			'_custom_28'	        => sanitize_text_field( $_POST['custom_28'] ),
			'_custom_29'	        => sanitize_text_field( $_POST['custom_29'] ),
			'_custom_30'	        => sanitize_text_field( $_POST['custom_30'] ),
			'_custom_31'	        => sanitize_text_field( $_POST['custom_31'] ),
			'_custom_32'	        => sanitize_text_field( $_POST['custom_32'] ),
			'_custom_33'	        => sanitize_text_field( $_POST['custom_33'] ),
			'_custom_34'	        => sanitize_text_field( $_POST['custom_34'] ),
			'_custom_35'	        => sanitize_text_field( $_POST['custom_35'] ),
			'_custom_36'	        => sanitize_text_field( $_POST['custom_36'] ),
			'_custom_37'	        => sanitize_text_field( $_POST['custom_37'] ),
			'_custom_38'	        => sanitize_text_field( $_POST['custom_38'] ),
			'_custom_39'	        => sanitize_text_field( $_POST['custom_39'] ),
			'_custom_40'	        => sanitize_text_field( $_POST['custom_40'] ),
			'_custom_41'	        => sanitize_text_field( $_POST['custom_41'] ),
			'_custom_42'	        => sanitize_text_field( $_POST['custom_42'] ),
			'_custom_43'	        => sanitize_text_field( $_POST['custom_43'] ),
			'_custom_44'	        => sanitize_text_field( $_POST['custom_44'] ),
			'_custom_45'	        => sanitize_text_field( $_POST['custom_45'] ),
			'_custom_46'	        => sanitize_text_field( $_POST['custom_46'] ),
			'_custom_47'	        => sanitize_text_field( $_POST['custom_47'] ),
			'_custom_48'	        => sanitize_text_field( $_POST['custom_48'] ),
			'_custom_49'	        => sanitize_text_field( $_POST['custom_49'] ),
			'_custom_50'	        => sanitize_text_field( $_POST['custom_50'] ),
			'_custom_51'	        => sanitize_text_field( $_POST['custom_51'] ),
			'_custom_52'	        => sanitize_text_field( $_POST['custom_52'] ),
			'_custom_53'	        => sanitize_text_field( $_POST['custom_53'] ),
			'_custom_54'	        => sanitize_text_field( $_POST['custom_54'] ),
			'_custom_55'	        => sanitize_text_field( $_POST['custom_55'] ),
			'_custom_56'	        => sanitize_text_field( $_POST['custom_56'] ),
			'_custom_57'	        => sanitize_text_field( $_POST['custom_57'] ),
			'_custom_58'	        => sanitize_text_field( $_POST['custom_58'] ),
			'_custom_59'	        => sanitize_text_field( $_POST['custom_59'] ),
			'_custom_60'	        => sanitize_text_field( $_POST['custom_60'] ),
			'_custom_61'	        => sanitize_text_field( $_POST['custom_61'] ),
			'_custom_62'	        => sanitize_text_field( $_POST['custom_62'] ),
			'_custom_63'	        => sanitize_text_field( $_POST['custom_63'] ),
			'_custom_64'	        => sanitize_text_field( $_POST['custom_64'] ),
			'_custom_65'	        => sanitize_text_field( $_POST['custom_65'] ),
			'_custom_66'	        => sanitize_text_field( $_POST['custom_66'] ),
			'_custom_67'	        => sanitize_text_field( $_POST['custom_67'] ),
			'_custom_68'	        => sanitize_text_field( $_POST['custom_68'] ),
			'_custom_69'	        => sanitize_text_field( $_POST['custom_69'] ),
			'_custom_70'	        => sanitize_text_field( $_POST['custom_70'] ),
			'_custom_71'	        => sanitize_text_field( $_POST['custom_71'] ),
			'_custom_72'	        => sanitize_text_field( $_POST['custom_72'] ),
			'_custom_73'	        => sanitize_text_field( $_POST['custom_73'] ),
			'_custom_74'	        => sanitize_text_field( $_POST['custom_74'] ),
			'_custom_75'	        => sanitize_text_field( $_POST['custom_75'] ),
			'_custom_76'	        => sanitize_text_field( $_POST['custom_76'] ),
			'_custom_77'	        => sanitize_text_field( $_POST['custom_77'] ),
			'_custom_78'	        => sanitize_text_field( $_POST['custom_78'] ),
			'_custom_79'	        => sanitize_text_field( $_POST['custom_79'] ),
			'_custom_80'	        => sanitize_text_field( $_POST['custom_80'] ),
		);

		foreach( $options as $key => $value ) {
			update_post_meta( $post_id, $key, $value );
		}

	}

	if (isset($_POST['pixad_auto_gallery_ids']) && $_POST['pixad_auto_gallery_ids'] != '') {
        // Encode so it can be stored an retrieved properly
        $encode = base64_encode( json_encode(explode(',',$_POST['pixad_auto_gallery_ids'])));
        update_post_meta($post_id, 'pixad_auto_gallery', $encode);
    }
    	if (isset($_POST['pixad_auto_gallery_2_ids']) && $_POST['pixad_auto_gallery_2_ids'] != '') {
        // Encode so it can be stored an retrieved properly
        $encode = base64_encode( json_encode(explode(',',$_POST['pixad_auto_gallery_2_ids'])));
        update_post_meta($post_id, 'pixad_auto_gallery_2', $encode);
    }
    if (isset($_POST['pixad_auto_gallery_video']) && $_POST['pixad_auto_gallery_video'] != '') {
        update_post_meta($post_id, 'pixad_auto_gallery_video', $_POST['pixad_auto_gallery_video']);
        //video
        update_post_meta($post_id, 'pixad_auto_gallery_video', $_POST['pixad_auto_gallery_video']);
    }
    

    if (isset($_POST['pixad_auto_featured_text'])){
        update_post_meta($post_id, 'pixad_auto_featured_text', $_POST['pixad_auto_featured_text'] );
    } else {
        delete_post_meta($post_id, 'pixad_auto_featured_text');
    }

    if (isset($_POST['pixad_auto_sidebar_layout'])) {
        update_post_meta($post_id, 'pixad_auto_sidebar_layout', $_POST['pixad_auto_sidebar_layout']);
    }
    if (isset($_POST['pixad_auto_related'])) {
        update_post_meta($post_id, 'pixad_auto_related', $_POST['pixad_auto_related']);
    }

    if (isset($_POST['pixad_auto_dealer_info'])) {
        update_post_meta($post_id, 'pixad_auto_dealer_info', $_POST['pixad_auto_dealer_info']);
    }
    if (isset($_POST['pixad_auto_contacts_form'])) {
        update_post_meta($post_id, 'pixad_auto_contacts_form', $_POST['pixad_auto_contacts_form']);
    }

    if (isset($_POST['pixad_auto_description_tab'])) {
        update_post_meta($post_id, 'pixad_auto_description_tab', $_POST['pixad_auto_description_tab']);
    }
    if (isset($_POST['pixad_auto_features_tab'])) {
        update_post_meta($post_id, 'pixad_auto_features_tab', $_POST['pixad_auto_features_tab']);
    }
    if (isset($_POST['pixad_auto_contacts_tab'])) {
        update_post_meta($post_id, 'pixad_auto_contacts_tab', $_POST['pixad_auto_contacts_tab']);
    }
    if (isset($_POST['pixad_auto_calc'])) {
        update_post_meta($post_id, 'pixad_auto_calc', $_POST['pixad_auto_calc']);
    }


    if (isset($_POST['auto_video_gallery'])) {
		$video_ids =  explode( ',',  $_POST['auto_video_gallery']  ) ;
		update_post_meta( $post_id, '_auto_video_gallery', implode( ',', $video_ids ) );
		update_post_meta( $post_id, '_auto_video_code',  $_POST['auto_video_code']  );
	}

	if (isset($_POST['pixad_auto_contact_info'])){
        $data = $_POST['pixad_auto_contact_info'];
        update_post_meta($post_id, 'pixad_auto_contact', $data );
    }

	if (isset($_POST['pixad_auto_custom_title_1'])){
        update_post_meta($post_id, 'pixad_auto_custom_title_1', $_POST['pixad_auto_custom_title_1'] );
    } else {
        delete_post_meta($post_id, 'pixad_auto_custom_title_1');
    }
	if (isset($_POST['pixad_auto_custom_info_1'])){
        $data = $_POST['pixad_auto_custom_info_1'];
        update_post_meta($post_id, 'pixad_auto_custom_content_1', $data );
    }

    if (isset($_POST['pixad_auto_custom_title_2'])){
        update_post_meta($post_id, 'pixad_auto_custom_title_2', $_POST['pixad_auto_custom_title_2'] );
    } else {
        delete_post_meta($post_id, 'pixad_auto_custom_title_2');
    }
	if (isset($_POST['pixad_auto_custom_info_2'])){
        $data = $_POST['pixad_auto_custom_info_2'];
        update_post_meta($post_id, 'pixad_auto_custom_content_2', $data );
    }

    if (isset($_POST['pixad_auto_custom_title_3'])){
        update_post_meta($post_id, 'pixad_auto_custom_title_3', $_POST['pixad_auto_custom_title_3'] );
    } else {
        delete_post_meta($post_id, 'pixad_auto_custom_title_3');
    }
	if (isset($_POST['pixad_auto_custom_info_3'])){
        $data = $_POST['pixad_auto_custom_info_3'];
        update_post_meta($post_id, 'pixad_auto_custom_content_3', $data );
    }

    if (isset($_POST['pixad_auto_banner_info'])){
        $data = $_POST['pixad_auto_banner_info'];
        update_post_meta($post_id, 'pixad_auto_banner', $data );
    }

    if (isset($_POST['pixad_auto_banner_link'])){
        update_post_meta($post_id, 'pixad_auto_banner_link', $_POST['pixad_auto_banner_link'] );
    } else {
        delete_post_meta($post_id, 'pixad_auto_banner_link');
    }
	if (isset($_POST['pixad_auto_form'])) {
        update_post_meta($post_id, 'pixad_auto_form', $_POST['pixad_auto_form']);
    }
  if (isset($_POST['pixad_auto_form_style'])) {
        update_post_meta($post_id, 'pixad_auto_form_style', $_POST['pixad_auto_form_style']);
    }

}
add_action( 'save_post', 'save_pixad_autos_meta_boxes' );


function pixad_get_external_video($post_id) {
	if(!$post_id) return false;
	$auto_video_code = str_replace('https://', 'http://', get_post_meta( $post_id, '_auto_video_code', true ));

	return $auto_video_code;
}

function pixad_get_external_video_img($post_id) {
	if(!$post_id) return false;
	$auto_video_code = get_post_meta( $post_id, '_auto_video_code', true );
	$vendor = parse_url($auto_video_code);
	if ($vendor['host'] == 'www.youtube.com' || $vendor['host'] == 'youtu.be' || $vendor['host'] == 'www.youtu.be' || $vendor['host'] == 'youtube.com'){
		return 'http://img.youtube.com/vi'.esc_attr($vendor['path']).'/hqdefault.jpg';
	} elseif ($vendor['host'] == 'vimeo.com'){
		$imgid = esc_attr($vendor['path']);
		$hash = unserialize(file_get_contents("http://vimeo.com/api/v2/video$imgid.php"));
		return $hash[0]['thumbnail_large'];
	} else {
		return '';
	}

}

function pixad_get_attach_video($post_id) {
	if(!$post_id) return false;
	$auto_video_code = get_post_meta( $post_id, '_auto_video_gallery', false );

	return $auto_video_code;
}

?>