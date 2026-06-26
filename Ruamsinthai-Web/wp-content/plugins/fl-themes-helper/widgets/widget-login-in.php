<?php
/**
 * Blog Widget 
 */
class Fl_Login_Form_Widget extends WP_Widget
{
	public $image_field = 'image';
	
	/**
	 * General Setup 
	 */
	public function __construct() {
	
		/* Widget settings. */
		$widget_ops = array(
			'classname'         => 'fl_login_form_widget',
			'description'       => esc_html__('Widget displays login form', 'fl-themes-helper')
		);

		/* Widget control settings. */
		$control_ops = array(
			'width'		=> 500, 
			'height'	=> 450, 
			'id_base'	=> 'fl_login_form_widget'
		);

		/* Create the widget. */
		parent::__construct( 'fl_login_form_widget', esc_html__('Fl Login Form Me', 'fl-themes-helper'), $widget_ops, $control_ops );
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



        $login_form_args = array(
            'label_log_in'          => esc_html__('Sign in', 'fl-themes-helper'),
            'label_lost_password'   => esc_html__('Forgot password?', 'fl-themes-helper'),
        );
		
		/* Before widget (defined by themes). */
		echo fl_wp_kses($before_widget);
		
		// Display Widget
		?> 
        <?php /* Display the widget title if one was input (before and after defined by themes). */
				if ( $title )
					echo fl_wp_kses($before_title) . esc_attr($title) . fl_wp_kses($after_title);

        if (is_user_logged_in()) {
            $this->logout_form();
        } else {
            $this->wp_login_form($login_form_args);
        }

		/* After widget (defined by themes). */
		echo fl_wp_kses($after_widget);
	}



    function lost_password( $args ) {

        return '<p class="login-lost-password"><label>&nbsp;&nbsp;'
            . '<a href="' . wp_lostpassword_url() . '">'.esc_html__('I lost my password', 'fl-themes-helper').'</a>'
            . '</label></p>';
    }

    function wp_login_form( $args = array() ) {

        $registration_redirect = ! empty( $_REQUEST['redirect_to'] ) ? $_REQUEST['redirect_to'] : '';

        $redirect_to = apply_filters( 'registration_redirect', $registration_redirect );


        $defaults = array(
            'redirect'                  => ( is_ssl() ? 'https://' : 'http://' ) . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'], // Default redirect is back to the current page
            'form_id'                   => uniqid('loginform_'),
            'label_username'            => esc_html__( 'Your email', 'fl-themes-helper' ),
            'placeholder_username'      => esc_html__( 'Login', 'fl-themes-helper' ),
            'register_username'         => esc_html__( 'Username', 'fl-themes-helper' ),
            'label_password'            => esc_html__( 'Your password', 'fl-themes-helper' ),
            'placeholder_password'      => esc_html__( 'Password', 'fl-themes-helper' ),
            'label_remember'            => esc_html__( 'Remember Me', 'fl-themes-helper' ),
            'label_lost_password'       => esc_html__( 'Remind the password', 'fl-themes-helper' ),
            'label_log_in'              => esc_html__( 'Log In', 'fl-themes-helper' ),
            'register_submit'           => esc_html__( 'Register', 'fl-themes-helper' ),
            'register_info'             => esc_html__('Registration confirmation will be emailed to you', 'fl-themes-helper' ),
            'id_username'               => uniqid('user_login_'),
            'id_password'               => uniqid('user_pass_'),
            'id_remember'               => uniqid('rememberme_'),
            'id_lost_password'          => uniqid('rememberme_'),
            'id_submit'                 => uniqid('wp-submit_'),
            'id_register_username'      => uniqid('user_login_register_'),
            'id_register_email'         => uniqid('user_email_register_'),
            'remember'                  => true,
            'lost_password'             => true,
            'value_username'            => '',
            'value_remember'            => false, // Set this to true to default the "Remember me" checkbox to checked
        );
        $args = wp_parse_args( $args, apply_filters( 'login_form_defaults', $defaults ) );

        $result = '';

        $result .= '<div class="fl-login-form-entry login-in">';

        $result .= '<div class="fl-login_form">';

        $result .= '<h3 class="login_form_title">'.esc_html__('Sign in', 'fl-themes-helper').'</h3>';

        $result .= '<form name="' . $args['form_id'] . '" id="' . $args['form_id'] . '" action="' . esc_url( site_url( 'wp-login.php', 'login_post' ) ) . '" method="post">';

        $result .= '<p class="login-username">
					    <input type="text" name="log" id="' . esc_attr( $args['id_username'] ) . '" class="input" placeholder="' . esc_html( $args['label_username'] ) . '" value="' . esc_attr( $args['value_username'] ) . '" size="20" />
				    </p>';
        $result .= '<p class="login-password">
					    <input type="password" name="pwd" id="' . esc_attr( $args['id_password'] ) . '" class="input" placeholder="' . esc_html( $args['label_password'] ) . '" value="" size="20" />
				    </p>';
        $result .= '<p class="login-submit text-center"> 
					    <button type="submit" name="wp-submit" id="' . esc_attr( $args['id_submit'] ) . '" class="login-in-btn default-btn fl-font-style-bolt-two">' .esc_attr( $args['label_log_in'] ). '</button>
					    <input type="hidden" name="redirect_to" value="' . esc_url( $args['redirect'] ) . '" />
				    </p>';

        $result .= '<p class="remember--lost-password-wrapper">';

        $result .= ( $args['remember'] ? '<label class="remember-login-checkbox-label">
                                            <input name="rememberme" type="checkbox" id="' . esc_attr( $args['id_remember'] ) . '" class="remember-login-checkbox" value="forever"' . ( $args['value_remember'] ? ' checked="checked"' : '' ) . ' /> ' . esc_html( $args['label_remember'] ) . '</label>' : '' );

        $result .= ( $args['lost_password'] ? '<a href="' . wp_lostpassword_url() . '" class="lost-password-link fl-font-style-medium">' . $args['label_lost_password'] . '</a>' : '' );

        $result .= '</p>';

        $result .= ''.apply_filters( 'login_form_bottom', '', $args ) . '
                    </form>';


        if (get_option('users_can_register')) {

            $result .= '<div class="registration-text-wrapper cf">';

                $result .= '<span class="registration-text">'. esc_html__("Don't have an account?", 'fl-themes-helper') .'</span>';

                $result .= '<a href="#" class="registration-link fl-font-style-medium">'. esc_html__('Register', 'fl-themes-helper') .'</a>';

            $result .= '</div>';

        }

        $result .= '</div>';

        // Register
        if (get_option('users_can_register')) {

            $result .= '<div class="fl-register-sub-menu">';

            $result .= '<h3 class="register_form_title">'.esc_html__('Create account', 'fl-themes-helper').'</h3>';

            $result .= '<form name="registerform" id="fl-registration-form" action="'.esc_url( site_url( 'wp-login.php?action=register', 'login_post' ) ).'" method="post" novalidate="novalidate">';

            $result .= '<p class="email-wrap">
                            <input type="email" id="' . esc_attr( $args['id_register_email'] ) . '" name="user_email" class="input" value="" placeholder="' . esc_html( $args['label_username'] ) . '" size="25" />
                        </p>';
            $result .= '<p class="login-wrap">
                            <input type="text" id="' . esc_attr( $args['id_register_username'] ) . '" name="user_login"  class="input" value="" placeholder="' . esc_html( $args['register_username'] ) . '" size="20" />
                        </p>';

            $result .= do_action( 'register_form' );

            $result .= '<p class="submit">
                             <input type="submit" name="wp-submit" id="wp-submit" class="register-submit-btn btn-effect fl-button fl-btn-primary btn_small_size" value="' . esc_html( $args['register_submit'] ) . '" />
                             <input type="hidden" name="redirect_to" value="'.esc_attr( $redirect_to ).'" />
                        </p>';


            $result .= '<p class="reg_passmail">' . esc_html( $args['register_info'] ) . '</p>';

            $result .= '<div class="register-text-link">';

            $result .= '<span class="registration-text">'. esc_html__("Are you a member?", 'fl-themes-helper') .'</span>';

            $result .= '<a href="#" class="login-in-link fl-font-style-medium">'. esc_html__('Login In', 'fl-themes-helper') .'</a>';

            $result .= '</div>';

            $result .= '</form>';

            $result .= '</div>';

        }
   

        $result .= '</div>';

        echo $result;
    }

    function logout_form() {
        $current_user = wp_get_current_user();
        $user = $current_user->user_firstname;
        $logIn = $current_user->user_login;
        $name = $logIn;
        if(isset($user) && !empty($user)) {
            $name = $user;
        }
        echo '<div class="login-logout text-center"><p class="login-user fl-widget-list-content">'.esc_html__('You are logged in as','fl-themes-helper').' '.esc_html($name).'</p><div class="fl-font-style-bolt-two fl-secondary-bg logout-btn-wrapper"><a class="button default-btn logout-btn" href="'.esc_url(wp_logout_url()).'">'.esc_html__('Logout','fl-themes-helper').'</a></div></div>';
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
			'title'		=> esc_html__('Login Form', 'fl-themes-helper'),
		);
		$instance = wp_parse_args( (array) $instance, $defaults );
		?>
		<p>
			<label for="<?php echo esc_attr($this->get_field_id( 'title' )); ?>"><?php esc_html_e('Title:', 'fl-themes-helper') ?></label>
			<input type="text" class="widefat" id="<?php echo esc_attr($this->get_field_id( 'title' )); ?>" name="<?php echo esc_attr($this->get_field_name( 'title' )); ?>" value="<?php echo ''.$instance['title']; ?>" />
		</p>
	<?php
	}





}