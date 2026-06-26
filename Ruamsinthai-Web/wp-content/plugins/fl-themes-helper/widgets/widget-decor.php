<?php
/**
 * Blog Widget 
 */
class Fl_Decor_Widget extends WP_Widget
{


	/**
	 * General Setup 
	 */
	public function __construct() {
	
		/* Widget settings. */
		$widget_ops = array(
			'classname'     => 'decor-widget',
			'description'   => esc_html__('A widget that displays decor line.', 'fl-themes-helper')
		);

		/* Widget control settings. */
		$control_ops = array(
			'id_base'	=> 'fl_decor_widget'
		);

		/* Create the widget. */
		parent::__construct( 'fl_decor_widget', esc_html__('Custom Decor Widget', 'fl-themes-helper'), $widget_ops, $control_ops );
	}

	/**
	 * Display Widget
	 * @param array $args
	 * @param array $instance 
	 */
	public function widget( $args, $instance ) 
	{
		extract( $args );

        $title = '';
		/* Before widget (defined by themes). */
		echo fl_wp_kses($before_widget);

		// Display Widget
		?> 
        <?php /* Display the widget title if one was input (before and after defined by themes). */
				if ( $title )
					echo fl_wp_kses($before_title) . esc_attr($title) . fl_wp_kses($after_title);
				?>
			<div class="fl-decor-widget">
               <div class="decor"></div>
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

		);
		$instance = wp_parse_args( (array) $instance, $defaults ); 
		

		?>

	<?php
	}
}