<?php
/**
 * Blog Widget 
 */
class Fl_Social_Widget extends WP_Widget
{
	public $image_field = 'image';
	
	/**
	 * General Setup 
	 */
	public function __construct() {
	
		/* Widget settings. */
		$widget_ops = array(
			'classname'     => 'social-widget',
			'description'   => esc_html__('A widget that displays a social profile icon.', 'fl-themes-helper')
		);

		/* Widget control settings. */
		$control_ops = array(

			'id_base'	=> 'fl_social_widget'
		);

		/* Create the widget. */
		parent::__construct( 'fl_social_widget', esc_html__('Custom Social', 'fl-themes-helper'), $widget_ops, $control_ops );
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

        $fb_link    = $instance['fb'];
        $tw_link    = $instance['tw'];
        $pt_link    = $instance['pt'];
        $vk_link    = $instance['vk'];
        $bh_link    = $instance['bh'];
        $yt_link    = $instance['yt'];
        $ins_link   = $instance['ins'];


		/* Before widget (defined by themes). */
		echo fl_wp_kses($before_widget);
		
		// Display Widget
		?> 
        <?php /* Display the widget title if one was input (before and after defined by themes). */
				if ( $title )
					echo fl_wp_kses($before_title) . esc_attr($title) . fl_wp_kses($after_title);
				?>
                <ul class="social-links">

                    <?php if( !empty( $tw_link ) ) : ?>
                        <li>
                            <a class="social-link fl-primary-color-hv" href="<?php echo $tw_link;?>">
                                <i class="fa fa-twitter"></i>
                            </a>
                        </li>
                    <?php endif; ?>
                    <?php if( !empty( $bh_link ) ) : ?>
                        <li>
                            <a class="social-link fl-primary-color-hv" href="<?php echo $bh_link;?>">
                                <i class="fa fa-behance"></i>
                            </a>
                        </li>
                    <?php endif; ?>

                    <?php if( !empty( $fb_link ) ) : ?>
                        <li>
                            <a class="social-link fl-primary-color-hv" href="<?php echo $fb_link;?>">
                                <i class="fa fa-facebook"></i>
                            </a>
                        </li>
                    <?php endif; ?>
                    <?php if( !empty( $ins_link) ) : ?>
                        <li>
                            <a class="social-link fl-primary-color-hv" href="<?php echo $ins_link;?>">
                                <i class="fa fa-instagram"></i>
                            </a>
                        </li>
                    <?php endif; ?>
                    <?php if( !empty( $yt_link) ) : ?>
                        <li>
                            <a class="social-link fl-primary-color-hv" href="<?php echo $yt_link;?>">
                                <i class="fa fa-youtube-play"></i>
                            </a>
                        </li>
                    <?php endif; ?>


                    <?php if( !empty( $pt_link ) ) : ?>
                        <li>
                            <a class="social-link fl-primary-color-hv" href="<?php echo $pt_link;?>">
                                <i class="fa fa-pinterest-p"></i>
                            </a>
                        </li>
                    <?php endif; ?>

                    <?php if( !empty( $vk_link ) ) : ?>
                        <li>
                            <a class="social-link fl-primary-color-hv" href="<?php echo $vk_link;?>">
                                <i class="fa fa-vk"></i>
                            </a>
                        </li>
                    <?php endif; ?>



                </ul>
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
        $instance['fb'] = strip_tags( $new_instance['fb'] );
        $instance['tw'] = strip_tags( $new_instance['tw'] );
        $instance['pt'] = strip_tags( $new_instance['pt'] );
        $instance['vk'] = strip_tags( $new_instance['vk'] );
        $instance['bh'] = strip_tags( $new_instance['bh'] );
        $instance['yt'] = strip_tags( $new_instance['yt'] );
        $instance['ins'] = strip_tags( $new_instance['ins'] );

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
            'fb'        => "",
            'tw'        => "",
            'pt'        => "",
            'vk'        => "",
            'bh'        => "",
            'yt'        => "",
            'ins'       => "",

		);
		$instance = wp_parse_args( (array) $instance, $defaults );
		?>
		<p>
			<label for="<?php echo esc_attr($this->get_field_id( 'title' )); ?>"><?php esc_html_e('Title:', 'fl-themes-helper') ?></label>
			<input type="text" class="widefat" id="<?php echo esc_attr($this->get_field_id( 'title' )); ?>" name="<?php echo esc_attr($this->get_field_name( 'title' )); ?>" value="<?php echo ''.$instance['title']; ?>" />
		</p>
        <p>
            <label for="<?php echo esc_attr($this->get_field_id( 'number' )); ?>"><?php esc_html_e('Twitter Link:', 'fl-themes-helper') ?></label>
            <input type="text" class="widefat" id="<?php echo esc_attr($this->get_field_id( 'tw' )); ?>" name="<?php echo esc_attr($this->get_field_name( 'tw' )); ?>" value="<?php echo ''.$instance['tw']; ?>" />
        </p>
        <p>
            <label for="<?php echo esc_attr($this->get_field_id( 'number' )); ?>"><?php esc_html_e('Behance Link:', 'fl-themes-helper') ?></label>
            <input type="text" class="widefat" id="<?php echo esc_attr($this->get_field_id( 'bh' )); ?>" name="<?php echo esc_attr($this->get_field_name( 'bh' )); ?>" value="<?php echo ''.$instance['bh']; ?>" />
        </p>
        <p>
            <label for="<?php echo esc_attr($this->get_field_id( 'number' )); ?>"><?php esc_html_e('Facebook Link:', 'fl-themes-helper') ?></label>
            <input type="text" class="widefat" id="<?php echo esc_attr($this->get_field_id( 'fb' )); ?>" name="<?php echo esc_attr($this->get_field_name( 'fb' )); ?>" value="<?php echo ''.$instance['fb']; ?>" />
        </p>
        <p>
            <label for="<?php echo esc_attr($this->get_field_id( 'number' )); ?>"><?php esc_html_e('Instagram Link:', 'fl-themes-helper') ?></label>
            <input type="text" class="widefat" id="<?php echo esc_attr($this->get_field_id( 'ins' )); ?>" name="<?php echo esc_attr($this->get_field_name( 'ins' )); ?>" value="<?php echo ''.$instance['ins']; ?>" />
        </p>
        <p>
            <label for="<?php echo esc_attr($this->get_field_id( 'number' )); ?>"><?php esc_html_e('Youtube Link:', 'fl-themes-helper') ?></label>
            <input type="text" class="widefat" id="<?php echo esc_attr($this->get_field_id( 'yt' )); ?>" name="<?php echo esc_attr($this->get_field_name( 'yt' )); ?>" value="<?php echo ''.$instance['yt']; ?>" />
        </p>
        <p>
            <label for="<?php echo esc_attr($this->get_field_id( 'number' )); ?>"><?php esc_html_e('Pinterest Link:', 'fl-themes-helper') ?></label>
            <input type="text" class="widefat" id="<?php echo esc_attr($this->get_field_id( 'pt' )); ?>" name="<?php echo esc_attr($this->get_field_name( 'pt' )); ?>" value="<?php echo ''.$instance['pt']; ?>" />
        </p>
        <p>
            <label for="<?php echo esc_attr($this->get_field_id( 'number' )); ?>"><?php esc_html_e('Vkontakte Link:', 'fl-themes-helper') ?></label>
            <input type="text" class="widefat" id="<?php echo esc_attr($this->get_field_id( 'vk' )); ?>" name="<?php echo esc_attr($this->get_field_name( 'vk' )); ?>" value="<?php echo ''.$instance['vk']; ?>" />
        </p>

	<?php
	}
}