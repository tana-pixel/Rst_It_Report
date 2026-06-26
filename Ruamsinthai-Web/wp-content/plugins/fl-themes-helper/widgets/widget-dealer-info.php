<?php
/**
 * Blog Widget 
 */
class Fl_Dealer_Info_Widget extends WP_Widget
{

	
	/**
	 * General Setup 
	 */
	public function __construct() {
	
		/* Widget settings. */
		$widget_ops = array(
			'classname'     => 'dealer-info-widget',
			'description'   => esc_html__('A widget that displays a short dealer information', 'fl-themes-helper')
		);

		/* Widget control settings. */
		$control_ops = array(
			'width'		=> '100%',
            'height'	=> '100%',
            'id_base'	=> 'fl_dealer_info_widget'
		);

		/* Create the widget. */
		parent::__construct( 'fl_dealer_info_widget', esc_html__('Custom Widget Dealer Info', 'fl-themes-helper'), $widget_ops, $control_ops );
	}

	/**
	 * Display Widget
	 * @param array $args
	 * @param array $instance 
	 */
	public function widget( $args, $instance ) 
	{
		extract( $args );
		
		$title = apply_filters('widget_title', $instance['title'] );

		$hours_title        = $instance['hours_title'];
        $hours_info_one     = $instance['hours_info_one'];
        $hours_info_two     = $instance['hours_info_two'];

		/* Before widget (defined by themes). */
		echo fl_wp_kses($before_widget);
		
		// Display Widget
		?> 
        <?php /* Display the widget title if one was input (before and after defined by themes). */
				if ( $title )
					echo fl_wp_kses($before_title) . esc_attr($title) . fl_wp_kses($after_title);
				?>
			<div class="dealer-info-wrapper">
                    <?php if( !empty( $hours_title ) ) : ?>
                        <div class="hours--title fl-font-style-bolt-two">
                            <?php echo $hours_title;?>
                        </div>
                    <?php endif; ?>
                <?php if( !empty( $hours_info_one ) ) : ?>
                    <div class="hours--info">
                        <?php echo $hours_info_one;?>
                    </div>
                <?php endif; ?>
                <?php if( !empty( $hours_info_two ) ) : ?>
                    <div class="hours--info">
                        <?php echo $hours_info_two;?>
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
		$instance['hours_title'] = strip_tags( $new_instance['hours_title'] );
        $instance['hours_info_one'] = strip_tags( $new_instance['hours_info_one'] );
        $instance['hours_info_two'] = strip_tags( $new_instance['hours_info_two'] );

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
			'title'		            => '',
            'hours_title'		    => "Sales Hours",
			'hours_info_one'		=> "Mon - Fri: 09:00 am to 06:00 pm",
            'hours_info_two'		=> "Sat: 10:00am to 05:00 pm",
		);
		$instance = wp_parse_args( (array) $instance, $defaults ); 
		
		$image_id   = isset( $instance[$this->image_field]) ? (int) $instance[$this->image_field] : 0;
		$image      = new Fl_WidgetImageField( $this, $image_id );
		?>
		<p>
			<label for="<?php echo esc_attr($this->get_field_id( 'title' )); ?>"><?php esc_html_e('Title:', 'fl-themes-helper') ?></label>
			<input type="text" class="widefat" id="<?php echo esc_attr($this->get_field_id( 'title' )); ?>" name="<?php echo esc_attr($this->get_field_name( 'title' )); ?>" value="<?php echo ''.$instance['title']; ?>" />
		</p>

        <p>
            <label for="<?php echo esc_attr($this->get_field_id( 'number' )); ?>"><?php esc_html_e('Hours title:', 'fl-themes-helper') ?></label>
            <input type="text" class="widefat" id="<?php echo esc_attr($this->get_field_id( 'hours_title' )); ?>" name="<?php echo esc_attr($this->get_field_name( 'hours_title' )); ?>" value="<?php echo ''.$instance['hours_title']; ?>" />
        </p>
        <p>
            <label for="<?php echo esc_attr($this->get_field_id( 'number' )); ?>"><?php esc_html_e('Hours Info One', 'fl-themes-helper') ?></label>
            <input type="text" class="widefat" id="<?php echo esc_attr($this->get_field_id( 'hours_info_one' )); ?>" name="<?php echo esc_attr($this->get_field_name( 'hours_info_one' )); ?>" value="<?php echo ''.$instance['hours_info_one']; ?>" />

        </p>
		<p>
            <label for="<?php echo esc_attr($this->get_field_id( 'number' )); ?>"><?php esc_html_e('Hours Info Two', 'fl-themes-helper') ?></label>
            <input type="text" class="widefat" id="<?php echo esc_attr($this->get_field_id( 'hours_info_two' )); ?>" name="<?php echo esc_attr($this->get_field_name( 'hours_info_two' )); ?>" value="<?php echo ''.$instance['hours_info_two']; ?>" />

        </p>
	<?php
	}
}