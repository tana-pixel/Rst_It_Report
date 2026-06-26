<?php
/**
 * Blog Widget 
 */
class Fl_Image_Widget extends WP_Widget
{
	public $image_field = 'image';
	
	/**
	 * General Setup 
	 */
	public function __construct() {
	
		/* Widget settings. */
		$widget_ops = array(
			'classname' => 'fl_image_widget',
			'description' => esc_html__('A widget that displays image.', 'fl-themes-helper')
		);

		/* Widget control settings. */
		$control_ops = array(
			'id_base'	=> 'fl_image_widget'
		);

		/* Create the widget. */
		parent::__construct( 'fl_image_widget', esc_html__('Custom Image', 'fl-themes-helper'), $widget_ops, $control_ops );
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
		
		/* Our variables from the widget settings. */
		$image_id = $instance[$this->image_field];
		
		$image = new Fl_WidgetImageField( $this, $image_id );

        $max_width = $instance['max-width'];

		/* Before widget (defined by themes). */
		echo fl_wp_kses($before_widget);

        $image_width = '';
        if($max_width !=''){
            $image_width = 'width:'.$max_width.';';
        }

        $style_css = ( $image_width ) ? 'style=' . $image_width . '' : '';
		// Display Widget
		?> 
        <?php /* Display the widget title if one was input (before and after defined by themes). */
				if ( $title )
					echo fl_wp_kses($before_title) . esc_attr($title) . fl_wp_kses($after_title);
				?>
			<div class="fl-image-widget">
				<?php if( !empty( $image_id ) ) : ?>
						<img <?php echo fl_wp_kses($style_css);?> src="<?php echo esc_url($image->get_image_src()); ?>" alt="<?php echo esc_attr($title) ?>" />
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
        $instance['max-width'] = strip_tags( $new_instance['max-width'] );
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
			'title'		=> '',
			'image'		=> "",
            'max-width' => "200px"
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
			<label>Image: </label>
			<?php echo ''.$image->get_widget_field(); ?>
		</p>
        <p>
            <label for="<?php echo esc_attr($this->get_field_id( 'title' )); ?>"><?php esc_html_e('Max width image:', 'fl-themes-helper') ?></label>
            <input type="text" class="widefat" id="<?php echo esc_attr($this->get_field_id( 'max-width' )); ?>" name="<?php echo esc_attr($this->get_field_name( 'max-width' )); ?>" value="<?php echo ''.$instance['max-width']; ?>" />
        </p>
	<?php
	}
}