<?php
    if (function_exists('vc_map')) {
        $forms_list = array( '' => '', );

        if ( function_exists( 'mc4wp_get_forms' ) ) {
            $forms = mc4wp_get_forms();

            if ( ! empty( $forms ) ) {
                foreach ( $forms as $form ) {
                    if ( isset( $form->name ) && isset( $form->ID ) ) {
                        $forms_list[ $form->name ] = $form->ID;
                    }
                }
            }
        }

        vc_map(
            array(
            'name'      => esc_html__('Mail Chimp', 'fl-themes-helper'),
            'base'      => 'vc_mail_chimp',
                'icon' => 'fl-icon icon-fl-vc-icon',
            'category'  => esc_html__('Fl Theme', 'fl-themes-helper'),
            'weight'    => 400,
            'controls'  => 'full',
            'params' => array_merge(array(
                array(
                    'type'        => 'dropdown',
                    'heading'     => esc_html__( 'Form', 'fl-themes-helper' ),
                    'param_name'  => 'form_id_mail_chimp',
                    'admin_label' => true,
                    'tooltip'     => esc_html__( 'Select form you want to style and display.', 'fl-themes-helper' ),
                    'value'       => $forms_list,
                    'std'         => '',
                    'description' => __( 'Make sure you are using <a href="https://wordpress.org/plugins/mailchimp-for-wp/" target="_blank">MailChimp for WordPress</a>.', 'fl-themes-helper' ),
                ),
                array(
                    "type"              => "textfield",
                    "heading"           => esc_html__("Title", 'fl-themes-helper'),
                    "param_name"        => "mailchimp_title",
                    "value"             => "Newsletter",
                ),

            ), fl_helping_get_animation_option(), fl_helping_get_animation_delay_option(), fl_helping_get_design_tab()),
        ));
    }