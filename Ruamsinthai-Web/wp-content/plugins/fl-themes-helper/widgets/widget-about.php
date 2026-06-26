<?php
/**
 * Blog Widget 
 */
class Fl_About_Widget extends WP_Widget
{
	public $image_field = 'image';
	
	/**
	 * General Setup 
	 */
	public function __construct() {
	
		/* Widget settings. */
		$widget_ops = array(
			'classname' => 'fl_about_widget',
			'description' => esc_html__('A widget that displays a short information about you.', 'fl-themes-helper')
		);

		/* Widget control settings. */
		$control_ops = array(
			'width'		=> 500, 
			'height'	=> 450, 
			'id_base'	=> 'fl_about_widget'
		);

		/* Create the widget. */
		parent::__construct( 'fl_about_widget', esc_html__('Fl About Me', 'fl-themes-helper'), $widget_ops, $control_ops );
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

		$a_title = $instance['a_tl'];
		$text = apply_filters('the_content', $instance['text']);
        $fb_link = $instance['fb'];
        $tw_link = $instance['tw'];

        $pt_link = $instance['pt'];
        $vk_link = $instance['vk'];
        $bh_link = $instance['bh'];
		
		/* Our variables from the widget settings. */
		$image_id = $instance[$this->image_field];
		
		$image = new Fl_WidgetImageField( $this, $image_id );
		
		/* Before widget (defined by themes). */
		echo fl_wp_kses($before_widget);
		
		// Display Widget
		?> 
        <?php /* Display the widget title if one was input (before and after defined by themes). */
				if ( $title )
					echo fl_wp_kses($before_title) . esc_attr($title) . fl_wp_kses($after_title);
				?>
			<div class="fl-about-widget">
				<?php if( !empty( $image_id ) ) : ?>
					<figure>
						<img src="<?php echo esc_url($image->get_image_src()); ?>" alt="<?php echo esc_attr($title) ?>" />
					</figure>
				<?php endif; ?>
                <?php if( !empty( $a_title ) ) : ?>
                    <h5 class="fl-author-title"><?php echo $a_title;?></h5>
                <?php endif; ?>
				<div class="text">
					<?php echo fl_wp_kses($text); ?>
				</div>
                <ul class="fl-about-social-link">
                    <?php if( !empty( $fb_link ) ) : ?>
                        <li class="about-sc-lnk">
                            <a class="social-link fl-primary-color-hv" href="<?php echo $fb_link;?>">
                                <i class="fa fa-facebook"></i>
                            </a>
                        </li>
                    <?php endif; ?>

                    <?php if( !empty( $tw_link ) ) : ?>
                        <li class="about-sc-lnk">
                            <a class="social-link fl-primary-color-hv" href="<?php echo $tw_link;?>">
                                <i class="fa fa-twitter"></i>
                            </a>
                        </li>
                    <?php endif; ?>

                    <?php if( !empty( $pt_link ) ) : ?>
                        <li class="about-sc-lnk">
                            <a class="social-link fl-primary-color-hv" href="<?php echo $pt_link;?>">
                                <i class="fa fa-pinterest-p"></i>
                            </a>
                        </li>
                    <?php endif; ?>

                    <?php if( !empty( $vk_link ) ) : ?>
                        <li class="about-sc-lnk">
                            <a class="social-link fl-primary-color-hv" href="<?php echo $vk_link;?>">
                                <i class="fa fa-vk"></i>
                            </a>
                        </li>
                    <?php endif; ?>
                    <?php if( !empty( $bh_link ) ) : ?>
                        <li class="about-sc-lnk">
                            <a class="social-link fl-primary-color-hv" href="<?php echo $bh_link;?>">
                                <i class="fa fa-behance"></i>
                            </a>
                        </li>
                    <?php endif; ?>
                </ul>
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
		$instance['text'] = strip_tags( $new_instance['text'] );
        $instance['a_tl'] = strip_tags( $new_instance['a_tl'] );
        $instance['fb'] = strip_tags( $new_instance['fb'] );
        $instance['tw'] = strip_tags( $new_instance['tw'] );
        $instance['pt'] = strip_tags( $new_instance['pt'] );
        $instance['vk'] = strip_tags( $new_instance['vk'] );
        $instance['bh'] = strip_tags( $new_instance['bh'] );

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
			'title'		=> esc_html__('About Me', 'fl-themes-helper'),
            'a_tl'		=> "Johannes Kepler",
			'text'		=> "Ligula id condimentum hendrerit, metus tortor tristique quam.",
			'image'		=> "",
            'fb'        => "",
            'tw'        => "",
            'pt'        => "",
            'vk'        => "",
            'bh'        => "",
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
            <label for="<?php echo esc_attr($this->get_field_id( 'number' )); ?>"><?php esc_html_e('Author Title:', 'fl-themes-helper') ?></label>
            <input type="text" class="widefat" id="<?php echo esc_attr($this->get_field_id( 'a_tl' )); ?>" name="<?php echo esc_attr($this->get_field_name( 'a_tl' )); ?>" value="<?php echo ''.$instance['a_tl']; ?>" />
        </p>
		<p>
            <label for="<?php echo esc_attr($this->get_field_id( 'number' )); ?>"><?php esc_html_e('Text:', 'fl-themes-helper') ?></label>
			<textarea class="widefat" cols="100" rows="5" id="<?php echo esc_attr($this->get_field_id( 'text' )); ?>" name="<?php echo esc_attr($this->get_field_name( 'text' )); ?>" ><?php echo ''.$instance['text']; ?></textarea>
		</p>
        <p>
            <label for="<?php echo esc_attr($this->get_field_id( 'number' )); ?>"><?php esc_html_e('Facebook Link:', 'fl-themes-helper') ?></label>
            <input type="text" class="widefat" id="<?php echo esc_attr($this->get_field_id( 'fb' )); ?>" name="<?php echo esc_attr($this->get_field_name( 'fb' )); ?>" value="<?php echo ''.$instance['fb']; ?>" />
        </p>
        <p>
            <label for="<?php echo esc_attr($this->get_field_id( 'number' )); ?>"><?php esc_html_e('Twitter Link:', 'fl-themes-helper') ?></label>
            <input type="text" class="widefat" id="<?php echo esc_attr($this->get_field_id( 'tw' )); ?>" name="<?php echo esc_attr($this->get_field_name( 'tw' )); ?>" value="<?php echo ''.$instance['tw']; ?>" />
        </p>
        <p>
            <label for="<?php echo esc_attr($this->get_field_id( 'number' )); ?>"><?php esc_html_e('Pinterest Link:', 'fl-themes-helper') ?></label>
            <input type="text" class="widefat" id="<?php echo esc_attr($this->get_field_id( 'pt' )); ?>" name="<?php echo esc_attr($this->get_field_name( 'pt' )); ?>" value="<?php echo ''.$instance['pt']; ?>" />
        </p>
        <p>
            <label for="<?php echo esc_attr($this->get_field_id( 'number' )); ?>"><?php esc_html_e('Vkontakte Link:', 'fl-themes-helper') ?></label>
            <input type="text" class="widefat" id="<?php echo esc_attr($this->get_field_id( 'vk' )); ?>" name="<?php echo esc_attr($this->get_field_name( 'vk' )); ?>" value="<?php echo ''.$instance['vk']; ?>" />
        </p>
        <p>
            <label for="<?php echo esc_attr($this->get_field_id( 'number' )); ?>"><?php esc_html_e('Behance Link:', 'fl-themes-helper') ?></label>
            <input type="text" class="widefat" id="<?php echo esc_attr($this->get_field_id( 'bh' )); ?>" name="<?php echo esc_attr($this->get_field_name( 'bh' )); ?>" value="<?php echo ''.$instance['bh']; ?>" />
        </p>
	<?php
	}
}