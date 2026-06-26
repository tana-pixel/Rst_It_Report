<?php
namespace TMBookingElementorControls;
if (!defined('ABSPATH')) exit; // Exit if accessed directly

class TMBookingElementor_Custom_Controls {

	public function includes() {
		require_once(TMBOOKING_THEME_HELPER_PLUGIN_PATH. '/elementor/custom-controle/image-selector/image-selector-control.php');
	}

	public function register_controls() {
		$this->includes();
		$controls_manager = \Elementor\Plugin::$instance->controls_manager;
		$controls_manager->register_control(\Elementor\CustomControl\TMBookingImageSelector_Control::ImageSelector, new \Elementor\CustomControl\TMBookingImageSelector_Control());
	}

	public function __construct() {
		add_action('elementor/controls/controls_registered', [$this, 'register_controls']);
	}

}
new TMBookingElementor_Custom_Controls();