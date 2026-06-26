<?php
/**
 * Blog Widget 
 */
class Fl_Header_Info_Widget extends WP_Widget
{
	public $image_field = 'image';
	
	/**
	 * General Setup 
	 */
	public function __construct() {
	
		/* Widget settings. */
		$widget_ops = array(
			'classname'         => 'fl_header_info_widget',
			'description'       => esc_html__('A widget that displays a short header information.', 'fl-themes-helper')
		);

		/* Widget control settings. */
		$control_ops = array(
			'width'		=> '100%',
			'height'	=> '100%',
			'id_base'	=> 'fl_header_info_widget'
		);

		/* Create the widget. */
		parent::__construct( 'fl_header_info_widget', esc_html__('Custom Header Info', 'fl-themes-helper'), $widget_ops, $control_ops );
	}

	/**
	 * Display Widget
	 * @param array $args
	 * @param array $instance 
	 */
	public function widget( $args, $instance ) 
	{
		extract( $args );
		
		$title      = apply_filters('widget_title', $instance['title'] );

		$contact_us = $instance['contact_us'];
        $phone_number = $instance['phone_number'];
        $email_text = $instance['email'];
        $email_address = $instance['email_address'];
        $working_text = $instance['working_text'];
        $working_time = $instance['working_time'];

		/* Before widget (defined by themes). */
		echo fl_wp_kses($before_widget);
		
		// Display Widget
		?> 
        <?php /* Display the widget title if one was input (before and after defined by themes). */
				if ( $title )
					echo fl_wp_kses($before_title) . esc_attr($title) . fl_wp_kses($after_title);
				?>
			<div class="fl-header-info-widget">
                <?php if( !empty( $contact_us ) or  !empty( $phone_number )) : ?>
                    <div class="contact-info">
                        <i class="fa fa-phone fl-primary-color"></i>
                        <?php if( !empty( $contact_us ) ) : ?>
                            <span class="info-text"><?php echo $contact_us;?></span>
                        <?php endif; ?>
                        <?php if( !empty( $phone_number ) ) : ?>
                            <a class="fl-font-style-bolt-two info-bolt-text fl-primary-color-hv" href="tel:<?php echo str_replace(' ', '',$phone_number);?>"><?php echo $phone_number;?></a>
                        <?php endif; ?>
                    </div>
                <?php endif; ?>
                <?php if( !empty( $email_text ) or  !empty( $email_address )) : ?>
                    <div class="email-info">
                        <i class="fa fa-envelope fl-primary-color"></i>
                        <?php if( !empty( $email_text ) ) : ?>
                            <span class="info-text"><?php echo $email_text;?></span>
                        <?php endif; ?>
                        <?php if( !empty( $email_address ) ) : ?>
                            <a class="fl-font-style-bolt-two info-bolt-text fl-primary-color-hv" href="mailto:<?php echo $email_address;?>"><?php echo $email_address;?></a>
                        <?php endif; ?>
                    </div>
                <?php endif; ?>

                <?php if( !empty( $working_text ) or  !empty( $working_time )) : ?>
                    <div class="working-info">
                        <i class="fa fa-clock-o fl-primary-color"></i>
                        <?php if( !empty( $working_text ) ) : ?>
                            <span class="info-text"><?php echo $working_text;?></span>
                        <?php endif; ?>
                        <?php if( !empty( $working_time ) ) : ?>
                            <span class="fl-font-style-bolt-two info-bolt-text"><?php echo $working_time;?></span>
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
        $instance['contact_us'] = strip_tags( $new_instance['contact_us'] );
        $instance['phone_number'] = strip_tags( $new_instance['phone_number'] );
        $instance['email'] = strip_tags( $new_instance['email'] );
        $instance['email_address'] = strip_tags( $new_instance['email_address'] );
        $instance['working_text'] = strip_tags( $new_instance['working_text'] );
        $instance['working_time'] = strip_tags( $new_instance['working_time'] );
        $instance['phone_w_spaces'] = strip_tags( $new_instance['phone_w_spaces'] );

		$instance[$this->image_field] = (int) $new_instance[$this->image_field];

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
            'contact_us'		=> "Call Us 24/7!",
            'phone_number'		=> "+1 755 302 8549",
            'email'             => "Email",
            'email_address'     => "support@autlines.com",
            'working_text'      => "Opening Hours",
            'working_time'      => "Mon - Fri 9:00 am to 6:00 pm",
		);
		$instance = wp_parse_args( (array) $instance, $defaults ); 

		?>
		<p>
			<label for="<?php echo esc_attr($this->get_field_id( 'title' )); ?>"><?php esc_html_e('Title:', 'fl-themes-helper') ?></label>
			<input type="text" class="widefat" id="<?php echo esc_attr($this->get_field_id( 'title' )); ?>" name="<?php echo esc_attr($this->get_field_name( 'title' )); ?>" value="<?php echo ''.$instance['title']; ?>" />
		</p>
        <p>
            <label for="<?php echo esc_attr($this->get_field_id( 'number' )); ?>"><?php esc_html_e('Contact info:', 'fl-themes-helper') ?></label>
            <input type="text" class="widefat" id="<?php echo esc_attr($this->get_field_id( 'contact_us' )); ?>" name="<?php echo esc_attr($this->get_field_name( 'contact_us' )); ?>" value="<?php echo ''.$instance['contact_us']; ?>" />
            <input type="text" class="widefat" id="<?php echo esc_attr($this->get_field_id( 'phone_number' )); ?>" name="<?php echo esc_attr($this->get_field_name( 'phone_number' )); ?>" value="<?php echo ''.$instance['phone_number']; ?>" />
        </p>
        <p>
            <label for="<?php echo esc_attr($this->get_field_id( 'number' )); ?>"><?php esc_html_e('Email info:', 'fl-themes-helper') ?></label>
            <input type="text" class="widefat" id="<?php echo esc_attr($this->get_field_id( 'email' )); ?>" name="<?php echo esc_attr($this->get_field_name( 'email' )); ?>" value="<?php echo ''.$instance['email']; ?>" />
            <input type="text" class="widefat" id="<?php echo esc_attr($this->get_field_id( 'email_address' )); ?>" name="<?php echo esc_attr($this->get_field_name( 'email_address' )); ?>" value="<?php echo ''.$instance['email_address']; ?>" />
         </p>
        <p>
            <label for="<?php echo esc_attr($this->get_field_id( 'number' )); ?>"><?php esc_html_e('Working time:', 'fl-themes-helper') ?></label>
            <input type="text" class="widefat" id="<?php echo esc_attr($this->get_field_id( 'working_text' )); ?>" name="<?php echo esc_attr($this->get_field_name( 'working_text' )); ?>" value="<?php echo ''.$instance['working_text']; ?>" />
            <input type="text" class="widefat" id="<?php echo esc_attr($this->get_field_id( 'working_time' )); ?>" name="<?php echo esc_attr($this->get_field_name( 'working_time' )); ?>" value="<?php echo ''.$instance['working_time']; ?>" />
        </p>
	<?php
	}
}