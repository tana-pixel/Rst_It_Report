<?php 

	$luzuk_royal_banquet_hall_custom_style = '';

	// Logo Size
	$luzuk_royal_banquet_hall_logo_top_padding = get_theme_mod('luzuk_royal_banquet_hall_logo_top_padding');
	$luzuk_royal_banquet_hall_logo_bottom_padding = get_theme_mod('luzuk_royal_banquet_hall_logo_bottom_padding');
	$luzuk_royal_banquet_hall_logo_left_padding = get_theme_mod('luzuk_royal_banquet_hall_logo_left_padding');
	$luzuk_royal_banquet_hall_logo_right_padding = get_theme_mod('luzuk_royal_banquet_hall_logo_right_padding');

	if( $luzuk_royal_banquet_hall_logo_top_padding != '' || $luzuk_royal_banquet_hall_logo_bottom_padding != '' || $luzuk_royal_banquet_hall_logo_left_padding != '' || $luzuk_royal_banquet_hall_logo_right_padding != ''){
		$luzuk_royal_banquet_hall_custom_style .=' .logo {';
			$luzuk_royal_banquet_hall_custom_style .=' padding-top: '.esc_attr($luzuk_royal_banquet_hall_logo_top_padding).'px; padding-bottom: '.esc_attr($luzuk_royal_banquet_hall_logo_bottom_padding).'px; padding-left: '.esc_attr($luzuk_royal_banquet_hall_logo_left_padding).'px; padding-right: '.esc_attr($luzuk_royal_banquet_hall_logo_right_padding).'px;';
		$luzuk_royal_banquet_hall_custom_style .=' }';
	}

	$luzuk_royal_banquet_hall_logo_size = get_theme_mod('luzuk_royal_banquet_hall_logo_size');
	if( $luzuk_royal_banquet_hall_logo_size != '') {
		if($luzuk_royal_banquet_hall_logo_size == 100) {
			$luzuk_royal_banquet_hall_custom_style .=' .custom-logo-link img {';
				$luzuk_royal_banquet_hall_custom_style .=' width: 350px;';
			$luzuk_royal_banquet_hall_custom_style .=' }';
		} else if($luzuk_royal_banquet_hall_logo_size >= 10 && $luzuk_royal_banquet_hall_logo_size < 100) {
			$luzuk_royal_banquet_hall_custom_style .=' .custom-logo-link img {';
				$luzuk_royal_banquet_hall_custom_style .=' width: '.esc_attr($luzuk_royal_banquet_hall_logo_size).'%;';
			$luzuk_royal_banquet_hall_custom_style .=' }';
		}
	}

	// Header Image
	$header_image_url = luzuk_royal_banquet_hall_banner_image( $image_url = '' );
	if( $header_image_url != ''){
		$luzuk_royal_banquet_hall_custom_style .=' #inner-pages-header {';
			$luzuk_royal_banquet_hall_custom_style .=' background-image: url('. esc_url( $header_image_url ).') !important; background-size: cover; background-repeat: no-repeat; background-attachment: fixed;';
		$luzuk_royal_banquet_hall_custom_style .=' }';

		$luzuk_royal_banquet_hall_custom_style .='  #header .top-head {';
			$luzuk_royal_banquet_hall_custom_style .=' background: none ';
		$luzuk_royal_banquet_hall_custom_style .=' }';
	} else {
		$luzuk_royal_banquet_hall_custom_style .=' #inner-pages-header {';
			$luzuk_royal_banquet_hall_custom_style .=' background: radial-gradient(circle at center, rgba(0,0,0,0) 0%, #000000 100%); ';
		$luzuk_royal_banquet_hall_custom_style .=' }';
	}

	$luzuk_royal_banquet_hall_slider_hide_show = get_theme_mod('luzuk_royal_banquet_hall_slider_hide_show',false);
	if( $luzuk_royal_banquet_hall_slider_hide_show == true){
		$luzuk_royal_banquet_hall_custom_style .=' .page-template-custom-home-page #inner-pages-header {';
			$luzuk_royal_banquet_hall_custom_style .=' display:none;';
		$luzuk_royal_banquet_hall_custom_style .=' }';
	}


	$luzuk_royal_banquet_hall_headertopsocialicon_col = get_theme_mod('luzuk_royal_banquet_hall_headertopsocialicon_col');
	if ( $luzuk_royal_banquet_hall_headertopsocialicon_col != '') {
		$luzuk_royal_banquet_hall_custom_style .=' #header .s-media a i {';
			$luzuk_royal_banquet_hall_custom_style .=' color:'.esc_attr($luzuk_royal_banquet_hall_headertopsocialicon_col).';';
		$luzuk_royal_banquet_hall_custom_style .=' }';
	}

	$luzuk_royal_banquet_hall_headertopsocialiconhover_col = get_theme_mod('luzuk_royal_banquet_hall_headertopsocialiconhover_col');
	if ( $luzuk_royal_banquet_hall_headertopsocialiconhover_col != '') {
		$luzuk_royal_banquet_hall_custom_style .=' #header .s-media a:hover i {';
			$luzuk_royal_banquet_hall_custom_style .=' color:'.esc_attr($luzuk_royal_banquet_hall_headertopsocialiconhover_col).';';
		$luzuk_royal_banquet_hall_custom_style .=' }';
	}

	$luzuk_royal_banquet_hall_menu_color = get_theme_mod('luzuk_royal_banquet_hall_menu_color');
	if ( $luzuk_royal_banquet_hall_menu_color != '') {
		$luzuk_royal_banquet_hall_custom_style .=' .primary-menu a, .primary-menu li .icon{';
			$luzuk_royal_banquet_hall_custom_style .=' color:'.esc_attr($luzuk_royal_banquet_hall_menu_color).';';
		$luzuk_royal_banquet_hall_custom_style .=' }';
	}

	$luzuk_royal_banquet_hall_menuhover_color = get_theme_mod('luzuk_royal_banquet_hall_menuhover_color');
	if ( $luzuk_royal_banquet_hall_menuhover_color != '') {
		$luzuk_royal_banquet_hall_custom_style .='.primary-menu li:hover .icon, .primary-menu li a:hover{';
			$luzuk_royal_banquet_hall_custom_style .=' color:'.esc_attr($luzuk_royal_banquet_hall_menuhover_color).';';
		$luzuk_royal_banquet_hall_custom_style .=' }';
	}

	$luzuk_royal_banquet_hall_submenu_color = get_theme_mod('luzuk_royal_banquet_hall_submenu_color');
	if ( $luzuk_royal_banquet_hall_submenu_color != '') {
		$luzuk_royal_banquet_hall_custom_style .='.primary-menu ul a{';
			$luzuk_royal_banquet_hall_custom_style .=' color:'.esc_attr($luzuk_royal_banquet_hall_submenu_color).';';
		$luzuk_royal_banquet_hall_custom_style .=' }';
	}

	$luzuk_royal_banquet_hall_submenubg_color = get_theme_mod('luzuk_royal_banquet_hall_submenubg_color');
	if ( $luzuk_royal_banquet_hall_submenubg_color != '') {
		$luzuk_royal_banquet_hall_custom_style .='.primary-menu ul{';
			$luzuk_royal_banquet_hall_custom_style .=' background:'.esc_attr($luzuk_royal_banquet_hall_submenubg_color).';';
		$luzuk_royal_banquet_hall_custom_style .=' }';
	}

	$luzuk_royal_banquet_hall_header_btntext_color = get_theme_mod('luzuk_royal_banquet_hall_header_btntext_color');
	if ( $luzuk_royal_banquet_hall_header_btntext_color != '') {
		$luzuk_royal_banquet_hall_custom_style .=' .headerbtn a {';
			$luzuk_royal_banquet_hall_custom_style .=' color:'.esc_attr($luzuk_royal_banquet_hall_header_btntext_color).';';
			$luzuk_royal_banquet_hall_custom_style .=' border-color:'.esc_attr($luzuk_royal_banquet_hall_header_btntext_color).';';
		$luzuk_royal_banquet_hall_custom_style .=' }';
	}
	
	$luzuk_royal_banquet_hall_header_btnbghvr_color = get_theme_mod('luzuk_royal_banquet_hall_header_btnbghvr_color');
	if ( $luzuk_royal_banquet_hall_header_btnbghvr_color != '') {
		$luzuk_royal_banquet_hall_custom_style .=' .headerbtn a:hover {';
			$luzuk_royal_banquet_hall_custom_style .=' background:'.esc_attr($luzuk_royal_banquet_hall_header_btnbghvr_color).';';
		$luzuk_royal_banquet_hall_custom_style .=' }';
	}

	$luzuk_royal_banquet_hall_header_btntexthover_color = get_theme_mod('luzuk_royal_banquet_hall_header_btntexthover_color');
	if ( $luzuk_royal_banquet_hall_header_btntexthover_color != '') {
		$luzuk_royal_banquet_hall_custom_style .=' .headerbtn a:hover {';
			$luzuk_royal_banquet_hall_custom_style .=' color:'.esc_attr($luzuk_royal_banquet_hall_header_btntexthover_color).';';
		$luzuk_royal_banquet_hall_custom_style .=' }';
	}


	//site title tagline
	$luzuk_royal_banquet_hall_site_title_color = get_theme_mod('luzuk_royal_banquet_hall_site_title_color');
	if ( $luzuk_royal_banquet_hall_site_title_color != '') {
		$luzuk_royal_banquet_hall_custom_style .=' h1.site-title a, p.site-title a{';
			$luzuk_royal_banquet_hall_custom_style .=' color:'.esc_attr($luzuk_royal_banquet_hall_site_title_color).';';
		$luzuk_royal_banquet_hall_custom_style .=' }';
	}

	$luzuk_royal_banquet_hall_site_tagline_color = get_theme_mod('luzuk_royal_banquet_hall_site_tagline_color');
	if ( $luzuk_royal_banquet_hall_site_tagline_color != '') {
		$luzuk_royal_banquet_hall_custom_style .=' p.site-description{';
			$luzuk_royal_banquet_hall_custom_style .=' color:'.esc_attr($luzuk_royal_banquet_hall_site_tagline_color).';';
		$luzuk_royal_banquet_hall_custom_style .=' }';
	}

	//layout width
	$luzuk_royal_banquet_hall_boxfull_width = get_theme_mod('luzuk_royal_banquet_hall_boxfull_width');
	if ($luzuk_royal_banquet_hall_boxfull_width !== '') {
		switch ($luzuk_royal_banquet_hall_boxfull_width) {
			case 'container':
				$luzuk_royal_banquet_hall_custom_style .= ' body, #header, .bottom-header {
					max-width: 1140px;
					width: 100%;
					padding-right: 15px;
					padding-left: 15px;
					margin-right: auto;
					margin-left: auto;
					}';
				break;
			case 'container-fluid':
				$luzuk_royal_banquet_hall_custom_style .= ' body, #header, .bottom-header { 
					width: 100%;
					padding-right: 15px;
					padding-left: 15px;
					margin-right: auto;
					margin-left: auto;
					}';
				break;
			case 'none':
				// No specific width specified, so no additional style needed.
				break;
			default:
				// Handle unexpected values.
				break;
		}
	}

	//Menu animation
	$luzuk_royal_banquet_hall_dropdown_anim = get_theme_mod('luzuk_royal_banquet_hall_dropdown_anim');

	if ( $luzuk_royal_banquet_hall_dropdown_anim != '') {
		$luzuk_royal_banquet_hall_custom_style .=' .primary-menu ul{';
			$luzuk_royal_banquet_hall_custom_style .=' animation:'.esc_attr($luzuk_royal_banquet_hall_dropdown_anim).' 1s ease;';
		$luzuk_royal_banquet_hall_custom_style .=' }';
	}



	// slider colors

	$luzuk_royal_banquet_hall_slider_title_color = get_theme_mod('luzuk_royal_banquet_hall_slider_title_color');
	if ( $luzuk_royal_banquet_hall_slider_title_color != '') {
		$luzuk_royal_banquet_hall_custom_style .=' #slider h2, #slider p {';
			$luzuk_royal_banquet_hall_custom_style .=' color:'.esc_attr($luzuk_royal_banquet_hall_slider_title_color).';';
		$luzuk_royal_banquet_hall_custom_style .=' }';
	}

	$luzuk_royal_banquet_hall_slider_description_color = get_theme_mod('luzuk_royal_banquet_hall_slider_description_color');
	if ( $luzuk_royal_banquet_hall_slider_description_color != '') {
		$luzuk_royal_banquet_hall_custom_style .=' #slider .content p {';
			$luzuk_royal_banquet_hall_custom_style .=' color:'.esc_attr($luzuk_royal_banquet_hall_slider_description_color).';';
		$luzuk_royal_banquet_hall_custom_style .=' }';
	}

	$luzuk_royal_banquet_hall_slider_btn1text_color = get_theme_mod('luzuk_royal_banquet_hall_slider_btn1text_color');
	if ( $luzuk_royal_banquet_hall_slider_btn1text_color != '') {
		$luzuk_royal_banquet_hall_custom_style .=' #slider .sbtn a {';
			$luzuk_royal_banquet_hall_custom_style .=' color:'.esc_attr($luzuk_royal_banquet_hall_slider_btn1text_color).';';
		$luzuk_royal_banquet_hall_custom_style .=' }';
	}

	$luzuk_royal_banquet_hall_slider_btn1bg_color = get_theme_mod('luzuk_royal_banquet_hall_slider_btn1bg_color');
	if ( $luzuk_royal_banquet_hall_slider_btn1bg_color != '') {
		$luzuk_royal_banquet_hall_custom_style .=' #slider .sbtn a {';
			$luzuk_royal_banquet_hall_custom_style .=' background:'.esc_attr($luzuk_royal_banquet_hall_slider_btn1bg_color).';';
		$luzuk_royal_banquet_hall_custom_style .=' }';
	}

	$luzuk_royal_banquet_hall_slider_btnicon_color = get_theme_mod('luzuk_royal_banquet_hall_slider_btnicon_color');
	if ( $luzuk_royal_banquet_hall_slider_btnicon_color != '') {
		$luzuk_royal_banquet_hall_custom_style .=' #slider .sbtn a i {';
			$luzuk_royal_banquet_hall_custom_style .=' color:'.esc_attr($luzuk_royal_banquet_hall_slider_btnicon_color).';';
		$luzuk_royal_banquet_hall_custom_style .=' }';
	}

	$luzuk_royal_banquet_hall_slider_btniconbg_color = get_theme_mod('luzuk_royal_banquet_hall_slider_btniconbg_color');
	if ( $luzuk_royal_banquet_hall_slider_btniconbg_color != '') {
		$luzuk_royal_banquet_hall_custom_style .=' #slider .sbtn a span {';
			$luzuk_royal_banquet_hall_custom_style .=' background:'.esc_attr($luzuk_royal_banquet_hall_slider_btniconbg_color).';';
		$luzuk_royal_banquet_hall_custom_style .=' }';
	}

	$luzuk_royal_banquet_hall_slider_btn1texthrv_color = get_theme_mod('luzuk_royal_banquet_hall_slider_btn1texthrv_color');
	if ( $luzuk_royal_banquet_hall_slider_btn1texthrv_color != '') {
		$luzuk_royal_banquet_hall_custom_style .=' #slider .sbtn a:hover {';
			$luzuk_royal_banquet_hall_custom_style .=' color:'.esc_attr($luzuk_royal_banquet_hall_slider_btn1texthrv_color).';';
		$luzuk_royal_banquet_hall_custom_style .=' }';
	}

	$luzuk_royal_banquet_hall_slider_btn1bghrv_color = get_theme_mod('luzuk_royal_banquet_hall_slider_btn1bghrv_color');
	if ( $luzuk_royal_banquet_hall_slider_btn1bghrv_color != '') {
		$luzuk_royal_banquet_hall_custom_style .=' #slider .sbtn a:hover {';
			$luzuk_royal_banquet_hall_custom_style .=' background:'.esc_attr($luzuk_royal_banquet_hall_slider_btn1bghrv_color).';';
		$luzuk_royal_banquet_hall_custom_style .=' }';
	}

	$luzuk_royal_banquet_hall_slider_arrowicon_color = get_theme_mod('luzuk_royal_banquet_hall_slider_arrowicon_color');
	if ( $luzuk_royal_banquet_hall_slider_arrowicon_color != '') {
		$luzuk_royal_banquet_hall_custom_style .=' #slider .carousel-control-prev i, #slider .carousel-control-next i {';
			$luzuk_royal_banquet_hall_custom_style .=' color:'.esc_attr($luzuk_royal_banquet_hall_slider_arrowicon_color).';';
		$luzuk_royal_banquet_hall_custom_style .=' }';
	}

	$luzuk_royal_banquet_hall_slider_arrowbg_color = get_theme_mod('luzuk_royal_banquet_hall_slider_arrowbg_color');
	if ( $luzuk_royal_banquet_hall_slider_arrowbg_color != '') {
		$luzuk_royal_banquet_hall_custom_style .=' #slider .carousel-control-prev, #slider .carousel-control-next {';
			$luzuk_royal_banquet_hall_custom_style .=' background:'.esc_attr($luzuk_royal_banquet_hall_slider_arrowbg_color).';';
		$luzuk_royal_banquet_hall_custom_style .=' }';
	}


	// aboutus colors
	$luzuk_royal_banquet_hall_aboutus_heading_color = get_theme_mod('luzuk_royal_banquet_hall_aboutus_heading_color');
	if ( $luzuk_royal_banquet_hall_aboutus_heading_color != '') {
		$luzuk_royal_banquet_hall_custom_style .=' #aboutus-section h6, #aboutus-section h6 i {';
			$luzuk_royal_banquet_hall_custom_style .=' color:'.esc_attr($luzuk_royal_banquet_hall_aboutus_heading_color).';';
		$luzuk_royal_banquet_hall_custom_style .=' }';
	}

	$luzuk_royal_banquet_hall_aboutus_title_color = get_theme_mod('luzuk_royal_banquet_hall_aboutus_title_color');
	if ( $luzuk_royal_banquet_hall_aboutus_title_color != '') {
		$luzuk_royal_banquet_hall_custom_style .=' #aboutus-section h4 {';
			$luzuk_royal_banquet_hall_custom_style .=' color:'.esc_attr($luzuk_royal_banquet_hall_aboutus_title_color).';';
		$luzuk_royal_banquet_hall_custom_style .=' }';
	}

	$luzuk_royal_banquet_hall_aboutus_description_color = get_theme_mod('luzuk_royal_banquet_hall_aboutus_description_color');
	if ( $luzuk_royal_banquet_hall_aboutus_description_color != '') {
		$luzuk_royal_banquet_hall_custom_style .=' #aboutus-section .description p {';
			$luzuk_royal_banquet_hall_custom_style .=' color:'.esc_attr($luzuk_royal_banquet_hall_aboutus_description_color).';';
		$luzuk_royal_banquet_hall_custom_style .=' }';
	}

	$luzuk_royal_banquet_hall_aboutus_boxicon_color = get_theme_mod('luzuk_royal_banquet_hall_aboutus_boxicon_color');
	if ( $luzuk_royal_banquet_hall_aboutus_boxicon_color != '') {
		$luzuk_royal_banquet_hall_custom_style .=' #aboutus-section .icnbx i {';
			$luzuk_royal_banquet_hall_custom_style .=' color:'.esc_attr($luzuk_royal_banquet_hall_aboutus_boxicon_color).';';
		$luzuk_royal_banquet_hall_custom_style .=' }';
	}

	$luzuk_royal_banquet_hall_aboutus_boxtitle_color = get_theme_mod('luzuk_royal_banquet_hall_aboutus_boxtitle_color');
	if ( $luzuk_royal_banquet_hall_aboutus_boxtitle_color != '') {
		$luzuk_royal_banquet_hall_custom_style .=' #aboutus-section .conbx h5 {';
			$luzuk_royal_banquet_hall_custom_style .=' color:'.esc_attr($luzuk_royal_banquet_hall_aboutus_boxtitle_color).';';
		$luzuk_royal_banquet_hall_custom_style .=' }';
	}

	$luzuk_royal_banquet_hall_aboutus_boxdescription_color = get_theme_mod('luzuk_royal_banquet_hall_aboutus_boxdescription_color');
	if ( $luzuk_royal_banquet_hall_aboutus_boxdescription_color != '') {
		$luzuk_royal_banquet_hall_custom_style .=' #aboutus-section .box p {';
			$luzuk_royal_banquet_hall_custom_style .=' color:'.esc_attr($luzuk_royal_banquet_hall_aboutus_boxdescription_color).';';
		$luzuk_royal_banquet_hall_custom_style .=' }';
	}

	$luzuk_royal_banquet_hall_aboutus_signheading_color = get_theme_mod('luzuk_royal_banquet_hall_aboutus_signheading_color');
	if ( $luzuk_royal_banquet_hall_aboutus_signheading_color != '') {
		$luzuk_royal_banquet_hall_custom_style .=' #aboutus-section .s-conbx h3{';
			$luzuk_royal_banquet_hall_custom_style .=' color:'.esc_attr($luzuk_royal_banquet_hall_aboutus_signheading_color).';';
		$luzuk_royal_banquet_hall_custom_style .=' }';
	}

	$luzuk_royal_banquet_hall_aboutus_signdescription_color = get_theme_mod('luzuk_royal_banquet_hall_aboutus_signdescription_color');
	if ( $luzuk_royal_banquet_hall_aboutus_signdescription_color != '') {
		$luzuk_royal_banquet_hall_custom_style .=' #aboutus-section .s-conbx p {';
			$luzuk_royal_banquet_hall_custom_style .=' color:'.esc_attr($luzuk_royal_banquet_hall_aboutus_signdescription_color).';';
		$luzuk_royal_banquet_hall_custom_style .=' }';
	}


	//services colors
	$luzuk_royal_banquet_hall_services_subheading_color = get_theme_mod('luzuk_royal_banquet_hall_services_subheading_color');
	if ( $luzuk_royal_banquet_hall_services_subheading_color != '') {
		$luzuk_royal_banquet_hall_custom_style .=' #services-section .headbx h4 {';
			$luzuk_royal_banquet_hall_custom_style .=' color:'.esc_attr($luzuk_royal_banquet_hall_services_subheading_color).';';
		$luzuk_royal_banquet_hall_custom_style .=' }';
	}

	$luzuk_royal_banquet_hall_services_heading_color = get_theme_mod('luzuk_royal_banquet_hall_services_heading_color');
	if ( $luzuk_royal_banquet_hall_services_heading_color != '') {
		$luzuk_royal_banquet_hall_custom_style .=' #services-section .headbx h2 {';
			$luzuk_royal_banquet_hall_custom_style .=' color:'.esc_attr($luzuk_royal_banquet_hall_services_heading_color).';';
		$luzuk_royal_banquet_hall_custom_style .=' }';
	}

	$luzuk_royal_banquet_hall_services_title_color = get_theme_mod('luzuk_royal_banquet_hall_services_title_color');
	if ( $luzuk_royal_banquet_hall_services_title_color != '') {
		$luzuk_royal_banquet_hall_custom_style .=' #services-section .serbx h4 {';
			$luzuk_royal_banquet_hall_custom_style .=' color:'.esc_attr($luzuk_royal_banquet_hall_services_title_color).';';
		$luzuk_royal_banquet_hall_custom_style .=' }';
	}

	$luzuk_royal_banquet_hall_services_description_color = get_theme_mod('luzuk_royal_banquet_hall_services_description_color');
	if ( $luzuk_royal_banquet_hall_services_description_color != '') {
		$luzuk_royal_banquet_hall_custom_style .=' #services-section .serbx p {';
			$luzuk_royal_banquet_hall_custom_style .=' color:'.esc_attr($luzuk_royal_banquet_hall_services_description_color).';';
		$luzuk_royal_banquet_hall_custom_style .=' }';
	}

	$luzuk_royal_banquet_hall_services_btntext_color = get_theme_mod('luzuk_royal_banquet_hall_services_btntext_color');
	if ( $luzuk_royal_banquet_hall_services_btntext_color != '') {
		$luzuk_royal_banquet_hall_custom_style .=' #services-section .ser-btn a {';
			$luzuk_royal_banquet_hall_custom_style .=' color:'.esc_attr($luzuk_royal_banquet_hall_services_btntext_color).';';
		$luzuk_royal_banquet_hall_custom_style .=' }';
	}

		$luzuk_royal_banquet_hall_services_btnbg_color = get_theme_mod('luzuk_royal_banquet_hall_services_btnbg_color');
	if ( $luzuk_royal_banquet_hall_services_btnbg_color != '') {
		$luzuk_royal_banquet_hall_custom_style .=' #services-section .ser-btn a {';
			$luzuk_royal_banquet_hall_custom_style .=' background:'.esc_attr($luzuk_royal_banquet_hall_services_btnbg_color).';';
		$luzuk_royal_banquet_hall_custom_style .=' }';
	}

	

	//footer colors
	$luzuk_royal_banquet_hall_footertext_color = get_theme_mod('luzuk_royal_banquet_hall_footertext_color');
	if ( $luzuk_royal_banquet_hall_footertext_color != '') {
		$luzuk_royal_banquet_hall_custom_style .=' #colophon h1, #colophon h2, #colophon h3, #colophon h4, #colophon h5,
		 #colophon h6,#colophon,#colophon p,.site-footer a, .site-footer p, #colophon caption, .site-footer .widget_rss .rss-date,
		  .site-footer .widget_rss li cite {';
			$luzuk_royal_banquet_hall_custom_style .=' color: '.esc_attr($luzuk_royal_banquet_hall_footertext_color).';';
		$luzuk_royal_banquet_hall_custom_style .=' }';
	}	

	$luzuk_royal_banquet_hall_footeractivemenu_color = get_theme_mod('luzuk_royal_banquet_hall_footeractivemenu_color');
	if ( $luzuk_royal_banquet_hall_footeractivemenu_color != '') {
		$luzuk_royal_banquet_hall_custom_style .=' .site-footer .current-menu-item a {';
			$luzuk_royal_banquet_hall_custom_style .=' color: '.esc_attr($luzuk_royal_banquet_hall_footeractivemenu_color).';';
		$luzuk_royal_banquet_hall_custom_style .=' }';
	}	

	$luzuk_royal_banquet_hall_footercopyright_color = get_theme_mod('luzuk_royal_banquet_hall_footercopyright_color');
	if ( $luzuk_royal_banquet_hall_footercopyright_color != '') {
		$luzuk_royal_banquet_hall_custom_style .=' #colophon .site-info p {';
			$luzuk_royal_banquet_hall_custom_style .=' color: '.esc_attr($luzuk_royal_banquet_hall_footercopyright_color).' !important;';
		$luzuk_royal_banquet_hall_custom_style .=' }';
	}

	$luzuk_royal_banquet_hall_footercopyrightbrd_color = get_theme_mod('luzuk_royal_banquet_hall_footercopyrightbrd_color');
	if ( $luzuk_royal_banquet_hall_footercopyrightbrd_color != '') {
		$luzuk_royal_banquet_hall_custom_style .=' .copyright {';
			$luzuk_royal_banquet_hall_custom_style .=' border-color: '.esc_attr($luzuk_royal_banquet_hall_footercopyrightbrd_color).' !important;';
		$luzuk_royal_banquet_hall_custom_style .=' }';
	}

	$luzuk_royal_banquet_hall_footerscrolltotoptext_color = get_theme_mod('luzuk_royal_banquet_hall_footerscrolltotoptext_color');
	if ( $luzuk_royal_banquet_hall_footerscrolltotoptext_color != '') {
		$luzuk_royal_banquet_hall_custom_style .=' .back-to-top-text {';
			$luzuk_royal_banquet_hall_custom_style .=' color: '.esc_attr($luzuk_royal_banquet_hall_footerscrolltotoptext_color).';';
		$luzuk_royal_banquet_hall_custom_style .=' }';
	}

	$luzuk_royal_banquet_hall_footerscrolltotopbg_color = get_theme_mod('luzuk_royal_banquet_hall_footerscrolltotopbg_color');
	if ( $luzuk_royal_banquet_hall_footerscrolltotopbg_color != '') {
		$luzuk_royal_banquet_hall_custom_style .=' .back-to-top {';
			$luzuk_royal_banquet_hall_custom_style .=' background: '.esc_attr($luzuk_royal_banquet_hall_footerscrolltotopbg_color).';';
		$luzuk_royal_banquet_hall_custom_style .=' }';
	}

	$luzuk_royal_banquet_hall_footerscrolltotoptexthover_color = get_theme_mod('luzuk_royal_banquet_hall_footerscrolltotoptexthover_color');
	if ( $luzuk_royal_banquet_hall_footerscrolltotoptexthover_color != '') {
		$luzuk_royal_banquet_hall_custom_style .=' .back-to-top:hover .back-to-top-text {';
			$luzuk_royal_banquet_hall_custom_style .=' color: '.esc_attr($luzuk_royal_banquet_hall_footerscrolltotoptexthover_color).';';
		$luzuk_royal_banquet_hall_custom_style .=' }';
	}

	$luzuk_royal_banquet_hall_footerscrolltotophover_color = get_theme_mod('luzuk_royal_banquet_hall_footerscrolltotophover_color');
	if ( $luzuk_royal_banquet_hall_footerscrolltotophover_color != '') {
		$luzuk_royal_banquet_hall_custom_style .=' .back-to-top:hover::after {';
			$luzuk_royal_banquet_hall_custom_style .=' background: '.esc_attr($luzuk_royal_banquet_hall_footerscrolltotophover_color).';';
		$luzuk_royal_banquet_hall_custom_style .=' }';
	}