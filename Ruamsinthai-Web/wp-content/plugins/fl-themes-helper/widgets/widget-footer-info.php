<?php
/**
 * Blog Widget 
 */
class Fl_Footer_Info_Widget extends WP_Widget
{

	
	/**
	 * General Setup 
	 */
	public function __construct() {
	
		/* Widget settings. */
		$widget_ops = array(
			'classname'         => 'footer-info-widget',
			'description'       => esc_html__('A widget that displays a short footer information.', 'fl-themes-helper')
		);

		/* Widget control settings. */
		$control_ops = array(

			'id_base'	=> 'fl_footer_info_widget'
		);

		/* Create the widget. */
		parent::__construct( 'fl_footer_info_widget', esc_html__('Custom Footer Info', 'fl-themes-helper'), $widget_ops, $control_ops );
	}

	/**
	 * Display Widget
	 * @param array $args
	 * @param array $instance 
	 */
	public function widget( $args, $instance ) 
	{
		extract( $args );
		
		$title          = apply_filters('widget_title', $instance['title'] );

		$contact_text   = $instance['contact_text'];
        $phone_number   = $instance['phone_number'];
        $email_address  = $instance['email_address'];
        $address        = $instance['address'];

		/* Before widget (defined by themes). */
		echo fl_wp_kses($before_widget);
		
		// Display Widget
		?> 
        <?php /* Display the widget title if one was input (before and after defined by themes). */
				if ( $title )
					echo fl_wp_kses($before_title) . esc_attr($title) . fl_wp_kses($after_title);
				?>
			<div class="footer-info-widget-wrapper">
                <?php if( !empty( $address )) : ?>
                    <div class="address-info">
                        <i class="ic icon-location-pin"></i>
                        <span class="info-text"><?php echo $address;?></span>
                    </div>
                <?php endif; ?>

                <?php if( !empty( $email_address )) : ?>
                    <div class="email-info">
                        <i class="ic icon-envelope"></i>

                        <?php if( !empty( $email_address ) ) : ?>
                            <a class="fl-primary-color-hv" href="mailto:<?php echo $email_address;?>"><?php echo $email_address;?></a>
                        <?php endif; ?>
                    </div>
                <?php endif; ?>

                <?php if( !empty( $contact_text ) or  !empty( $phone_number )) : ?>
                    <div class="contact-info">
                        <i class="ic icon-earphones-alt"></i>
                        <?php if( !empty( $contact_text ) ) : ?>
                            <span class="info-text"><?php echo $contact_text;?></span>
                        <?php endif; ?>
                        <?php if( !empty( $phone_number ) ) : ?>
                            <a class="fl-font-style-bolt-two fl-primary-color-hv" href="tel:<?php echo str_replace(' ', '',$phone_number);?>"><?php echo $phone_number;?></a>
                        <?php endif; ?>
                    </div>
                <?php endif; ?>
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
		
		$instance['title'] = strip_tags( $new_instance['title'] );
        $instance['contact_text'] = strip_tags( $new_instance['contact_text'] );
        $instance['phone_number'] = strip_tags( $new_instance['phone_number'] );
        $instance['email_address'] = strip_tags( $new_instance['email_address'] );
        $instance['address'] = strip_tags( $new_instance['address'] );

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
			'title'		        => "",
            'address'           => 'Fairview Ave, El Monte, CA 91732',
            'contact_text'		=> "Phone:",
            'phone_number'		=> "+1 755 302 8549",
            'email_address'     => "support@autlines.com",
		);
		$instance = wp_parse_args( (array) $instance, $defaults ); 

		?>
		<p>
			<label><?php esc_html_e('Title:', 'fl-themes-helper') ?></label>
			<input type="text" class="widefat" id="<?php echo esc_attr($this->get_field_id( 'title' )); ?>" name="<?php echo esc_attr($this->get_field_name( 'title' )); ?>" value="<?php echo ''.$instance['title']; ?>" />
		</p>
        <p>
            <label><?php esc_html_e('Address:', 'fl-themes-helper') ?></label>
            <input type="text" class="widefat" id="<?php echo esc_attr($this->get_field_id( 'address' )); ?>" name="<?php echo esc_attr($this->get_field_name( 'address' )); ?>" value="<?php echo ''.$instance['address']; ?>" />
        </p>
        <p>
            <label><?php esc_html_e('Email:', 'fl-themes-helper') ?></label>
            <input type="text" class="widefat" id="<?php echo esc_attr($this->get_field_id( 'email_address' )); ?>" name="<?php echo esc_attr($this->get_field_name( 'email_address' )); ?>" value="<?php echo ''.$instance['email_address']; ?>" />
        </p>
        <p>
            <label><?php esc_html_e('Contact info:', 'fl-themes-helper') ?></label>
            <input type="text" class="widefat" id="<?php echo esc_attr($this->get_field_id( 'contact_text' )); ?>" name="<?php echo esc_attr($this->get_field_name( 'contact_text' )); ?>" value="<?php echo ''.$instance['contact_text']; ?>" />
            <input type="text" class="widefat" id="<?php echo esc_attr($this->get_field_id( 'phone_number' )); ?>" name="<?php echo esc_attr($this->get_field_name( 'phone_number' )); ?>" value="<?php echo ''.$instance['phone_number']; ?>" />

        </p>

	<?php
	}
}