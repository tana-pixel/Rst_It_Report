<?php
/**
 * Blog Widget
 */
class Fl_Button_Widget extends WP_Widget
{
    /**
     * General Setup
     */
    public function __construct() {

        /* Widget settings. */
        $widget_ops = array(
            'classname' => 'button_widget',
            'description' => esc_html__('A widget that displays button.', 'fl-themes-helper')
        );

        /* Widget control settings. */
        $control_ops = array(
            'width'		=> 300,
            'height'	=> 350,
            'id_base'	=> 'fl_button_widget'
        );

        /* Create the widget. */
        parent::__construct( 'fl_button_widget', esc_html__('Custom Button Widget', 'fl-themes-helper'), $widget_ops, $control_ops );
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
        $button_text = $instance['button_text'];
        $button_link = $instance['button_link'];
        /* Before widget (defined by themes). */
        echo fl_wp_kses($before_widget);

        // Display Widget
        ?>
        <?php /* Display the widget title if one was input (before and after defined by themes). */
        if ( $title )
            echo fl_wp_kses($before_title) . esc_attr($title) . fl_wp_kses($after_title);
        ?>
        <?php if( !empty( $button_text ) and !empty( $button_link )) : ?>
            <div class="widget-btn-wrapper fl-font-style-bolt-two">
                <a class="default-btn fl-primary-color-hv" href="<?php echo $button_link;?>"><?php echo $button_text;?></a>
            </div>
        <?php endif; ?>


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

        $instance['title']          = strip_tags( $new_instance['title'] );
        $instance['button_text']    = strip_tags( $new_instance['button_text'] );
        $instance['button_link']    = strip_tags( $new_instance['button_link'] );
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
            'title'             => '',
            'button_text'       => 'Take a test drive',
            'button_link'       => '#',
        );
        $instance = wp_parse_args( (array) $instance, $defaults ); ?>
        <p>
            <label for="<?php echo esc_attr($this->get_field_id( 'title' )); ?>"><?php esc_html_e('Title:', 'fl-themes-helper') ?></label>
            <input type="text" class="widefat" id="<?php echo esc_attr($this->get_field_id( 'title' )); ?>" name="<?php echo esc_attr($this->get_field_name( 'title' )); ?>" value="<?php echo ''.$instance['title']; ?>" />
        </p>
        <p>
            <label><?php esc_html_e('Button Text:', 'fl-themes-helper') ?></label>
            <input type="text" class="widefat" id="<?php echo esc_attr($this->get_field_id( 'button_text' )); ?>" name="<?php echo esc_attr($this->get_field_name( 'button_text' )); ?>" value="<?php echo ''.$instance['button_text']; ?>" />
        </p>

        <p>
            <label><?php esc_html_e('Button Link:', 'fl-themes-helper') ?></label>
            <input type="text" class="widefat" id="<?php echo esc_attr($this->get_field_id( 'button_link' )); ?>" name="<?php echo esc_attr($this->get_field_name( 'button_link' )); ?>" value="<?php echo ''.$instance['button_link']; ?>" />
        </p>
        <?php
    }
}