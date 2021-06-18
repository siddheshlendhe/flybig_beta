<?php
	
	/*---------------------------First highlight color-------------------*/

	$vw_travel_first_color = get_theme_mod('vw_travel_first_color');

	$vw_travel_custom_css = '';

	if($vw_travel_first_color != false){
		$vw_travel_custom_css .='.box ul.post-categories li, .search-box i, .more-btn a, span.carousel-control-prev-icon i:hover, #footer .custom-social-icons i:hover, span.carousel-control-next-icon i:hover, .more-btn a:hover, .scrollup i, .pagination span, .pagination a, #sidebar .custom-social-icons i:hover, #footer .custom-social-icons i:hover, .main-navigation a:hover, .toggle-nav i, #footer a.custom_read_more, #sidebar a.custom_read_more, .woocommerce nav.woocommerce-pagination ul li a, .nav-previous a, .nav-next a, .wp-block-button__link{';
			$vw_travel_custom_css .='background-color: '.esc_attr($vw_travel_first_color).';';
		$vw_travel_custom_css .='}';
	}
	if($vw_travel_first_color != false){
		$vw_travel_custom_css .='.lower-header i, .logo h1 a, h6.phone-no, #footer h3, .logo h1 a, .logo p.site-title a, .lower-header p a:hover{';
			$vw_travel_custom_css .='color: '.esc_attr($vw_travel_first_color).';';
		$vw_travel_custom_css .='}';
	}
	if($vw_travel_first_color != false){
		$vw_travel_custom_css .='span.carousel-control-prev-icon i:hover, span.carousel-control-next-icon i:hover{';
			$vw_travel_custom_css .='border-color: '.esc_attr($vw_travel_first_color).';';
		$vw_travel_custom_css .='}';
	}
	if($vw_travel_first_color != false){
		$vw_travel_custom_css .='.main-navigation ul ul{';
			$vw_travel_custom_css .='border-top-color: '.esc_attr($vw_travel_first_color).';';
		$vw_travel_custom_css .='}';
	}
	if($vw_travel_first_color != false){
		$vw_travel_custom_css .='#footer h3:after, .header-fixed, .main-navigation ul ul{';
			$vw_travel_custom_css .='border-bottom-color: '.esc_attr($vw_travel_first_color).';';
		$vw_travel_custom_css .='}';
	}

	/*---------------------------Second highlight color-------------------*/

	$vw_travel_second_color = get_theme_mod('vw_travel_second_color');

	if($vw_travel_second_color != false){
		$vw_travel_custom_css .='#header, .more-btn a i, input[type="submit"], #footer-2, #footer .custom-social-icons i, .woocommerce #respond input#submit, .woocommerce a.button, .woocommerce button.button, .woocommerce input.button, .woocommerce #respond input#submit.alt, .woocommerce a.button.alt, .woocommerce button.button.alt, .woocommerce input.button.alt, #sidebar h3, #comments input[type="submit"], nav.woocommerce-MyAccount-navigation ul li, .more-btn a:hover, .pagination .current, .pagination a:hover, #sidebar .tagcloud a:hover, #sidebar .custom-social-icons i, #footer .custom-social-icons i, #footer .tagcloud a:hover, .header-fixed, #comments a.comment-reply-link, #sidebar .widget_price_filter .ui-slider .ui-slider-range, #sidebar .widget_price_filter .ui-slider .ui-slider-handle, #sidebar .woocommerce-product-search button, #footer .widget_price_filter .ui-slider .ui-slider-range, #footer .widget_price_filter .ui-slider .ui-slider-handle, #footer .woocommerce-product-search button, #footer a.custom_read_more i.fas.fa-long-arrow-alt-right, #sidebar a.custom_read_more i.fas.fa-long-arrow-alt-right, #footer a.custom_read_more:hover, #footer input[type="submit"]:hover, #sidebar a.custom_read_more:hover, #sidebar input[type="submit"]:hover, .woocommerce nav.woocommerce-pagination ul li a:hover, .woocommerce nav.woocommerce-pagination ul li span.current, .nav-previous a:hover, .nav-next a:hover, .wp-block-button .wp-block-button__link:hover{';
			$vw_travel_custom_css .='background-color: '.esc_attr($vw_travel_second_color).';';
		$vw_travel_custom_css .='}';
	}
	if($vw_travel_second_color != false){
		$vw_travel_custom_css .='.post-navigation a:hover .post-title, .post-navigation a:focus .post-title, a, .post-main-box:hover h2, #sidebar ul li a:hover, #footer li a:hover, .main-navigation ul.sub-menu a:hover, .entry-content a, .sidebar .textwidget p a, .textwidget p a, #comments p a, .slider .inner_carousel p a, .post-main-box:hover h2 a, .post-main-box:hover .post-info a, .single-post .post-info:hover a, h6.phone-no a:hover{';
			$vw_travel_custom_css .='color: '.esc_attr($vw_travel_second_color).';';
		$vw_travel_custom_css .='}';
	}
	if($vw_travel_second_color != false){
		$vw_travel_custom_css .='.home-page-header{';
			$vw_travel_custom_css .='border-bottom-color: '.esc_attr($vw_travel_second_color).';';
		$vw_travel_custom_css .='}';
	}

	/*---------------------------Width Layout -------------------*/

	$vw_travel_theme_lay = get_theme_mod( 'vw_travel_width_option','Full Width');
    if($vw_travel_theme_lay == 'Boxed'){
		$vw_travel_custom_css .='body{';
			$vw_travel_custom_css .='max-width: 1140px; width: 100%; padding-right: 15px; padding-left: 15px; margin-right: auto; margin-left: auto;';
		$vw_travel_custom_css .='}';
	}else if($vw_travel_theme_lay == 'Wide Width'){
		$vw_travel_custom_css .='body{';
			$vw_travel_custom_css .='width: 100%;padding-right: 15px;padding-left: 15px;margin-right: auto;margin-left: auto;';
		$vw_travel_custom_css .='}';
	}else if($vw_travel_theme_lay == 'Full Width'){
		$vw_travel_custom_css .='body{';
			$vw_travel_custom_css .='max-width: 100%;';
		$vw_travel_custom_css .='}';
	}

	/*--------------------------- Slider Opacity -------------------*/

	$vw_travel_theme_lay = get_theme_mod( 'vw_travel_slider_opacity_color','0.5');
	if($vw_travel_theme_lay == '0'){
		$vw_travel_custom_css .='#slider img{';
			$vw_travel_custom_css .='opacity:0';
		$vw_travel_custom_css .='}';
		}else if($vw_travel_theme_lay == '0.1'){
		$vw_travel_custom_css .='#slider img{';
			$vw_travel_custom_css .='opacity:0.1';
		$vw_travel_custom_css .='}';
		}else if($vw_travel_theme_lay == '0.2'){
		$vw_travel_custom_css .='#slider img{';
			$vw_travel_custom_css .='opacity:0.2';
		$vw_travel_custom_css .='}';
		}else if($vw_travel_theme_lay == '0.3'){
		$vw_travel_custom_css .='#slider img{';
			$vw_travel_custom_css .='opacity:0.3';
		$vw_travel_custom_css .='}';
		}else if($vw_travel_theme_lay == '0.4'){
		$vw_travel_custom_css .='#slider img{';
			$vw_travel_custom_css .='opacity:0.4';
		$vw_travel_custom_css .='}';
		}else if($vw_travel_theme_lay == '0.5'){
		$vw_travel_custom_css .='#slider img{';
			$vw_travel_custom_css .='opacity:0.5';
		$vw_travel_custom_css .='}';
		}else if($vw_travel_theme_lay == '0.6'){
		$vw_travel_custom_css .='#slider img{';
			$vw_travel_custom_css .='opacity:0.6';
		$vw_travel_custom_css .='}';
		}else if($vw_travel_theme_lay == '0.7'){
		$vw_travel_custom_css .='#slider img{';
			$vw_travel_custom_css .='opacity:0.7';
		$vw_travel_custom_css .='}';
		}else if($vw_travel_theme_lay == '0.8'){
		$vw_travel_custom_css .='#slider img{';
			$vw_travel_custom_css .='opacity:0.8';
		$vw_travel_custom_css .='}';
		}else if($vw_travel_theme_lay == '0.9'){
		$vw_travel_custom_css .='#slider img{';
			$vw_travel_custom_css .='opacity:0.9';
		$vw_travel_custom_css .='}';
		}

	/*---------------------------Slider Content Layout -------------------*/

	$vw_travel_theme_lay = get_theme_mod( 'vw_travel_slider_content_option','Center');
    if($vw_travel_theme_lay == 'Left'){
		$vw_travel_custom_css .='#slider .carousel-caption, #slider .inner_carousel h1{';
			$vw_travel_custom_css .='text-align:left; left:10%; right:45%';
		$vw_travel_custom_css .='}';
	}else if($vw_travel_theme_lay == 'Center'){
		$vw_travel_custom_css .='#slider .carousel-caption, #slider .inner_carousel h1{';
			$vw_travel_custom_css .='text-align:center; left:20%; right:20%;';
		$vw_travel_custom_css .='}';
	}else if($vw_travel_theme_lay == 'Right'){
		$vw_travel_custom_css .='#slider .carousel-caption, #slider .inner_carousel h1{';
			$vw_travel_custom_css .='text-align:right; left:45%; right:10%;';
		$vw_travel_custom_css .='}';
	}

	/*---------------------------Slider Height ------------*/

	$vw_travel_slider_height = get_theme_mod('vw_travel_slider_height');
	if($vw_travel_slider_height != false){
		$vw_travel_custom_css .='#slider img{';
			$vw_travel_custom_css .='height: '.esc_attr($vw_travel_slider_height).';';
		$vw_travel_custom_css .='}';
	}

	/*---------------------------Blog Layout -------------------*/

	$vw_travel_theme_lay = get_theme_mod( 'vw_travel_blog_layout_option','Default');
    if($vw_travel_theme_lay == 'Default'){
		$vw_travel_custom_css .='.post-main-box{';
			$vw_travel_custom_css .='';
		$vw_travel_custom_css .='}';
	}else if($vw_travel_theme_lay == 'Center'){
		$vw_travel_custom_css .='.post-main-box, .post-main-box h2, .post-info, .new-text p, .content-bttn{';
			$vw_travel_custom_css .='text-align:center;';
		$vw_travel_custom_css .='}';
		$vw_travel_custom_css .='.post-info{';
			$vw_travel_custom_css .='margin-top:10px;';
		$vw_travel_custom_css .='}';
		$vw_travel_custom_css .='.post-info hr{';
			$vw_travel_custom_css .='margin:10px auto;';
		$vw_travel_custom_css .='}';
	}else if($vw_travel_theme_lay == 'Left'){
		$vw_travel_custom_css .='.post-main-box, .post-main-box h2, .post-info, .new-text p, .content-bttn, #our-services p{';
			$vw_travel_custom_css .='text-align:Left;';
		$vw_travel_custom_css .='}';
		$vw_travel_custom_css .='.post-info hr{';
			$vw_travel_custom_css .='margin-bottom:10px;';
		$vw_travel_custom_css .='}';
		$vw_travel_custom_css .='.post-main-box h2{';
			$vw_travel_custom_css .='margin-top:10px;';
		$vw_travel_custom_css .='}';
	}

	/*------------------------------Responsive Media -----------------------*/

	$vw_travel_resp_topbar = get_theme_mod( 'vw_travel_resp_topbar_hide_show',false);
	if($vw_travel_resp_topbar == true && get_theme_mod( 'vw_travel_topbar_hide_show', false) == false){
    	$vw_travel_custom_css .='.lower-header{';
			$vw_travel_custom_css .='display:none;';
		$vw_travel_custom_css .='} ';
	}
    if($vw_travel_resp_topbar == true){
    	$vw_travel_custom_css .='@media screen and (max-width:575px) {';
		$vw_travel_custom_css .='.lower-header{';
			$vw_travel_custom_css .='display:block;';
		$vw_travel_custom_css .='} }';
	}else if($vw_travel_resp_topbar == false){
		$vw_travel_custom_css .='@media screen and (max-width:575px) {';
		$vw_travel_custom_css .='.lower-header{';
			$vw_travel_custom_css .='display:none;';
		$vw_travel_custom_css .='} }';
	}

	$vw_travel_resp_stickyheader = get_theme_mod( 'vw_travel_stickyheader_hide_show',false);
	if($vw_travel_resp_stickyheader == true && get_theme_mod( 'vw_travel_sticky_header',false) != true){
    	$vw_travel_custom_css .='.header-fixed{';
			$vw_travel_custom_css .='position:static;';
		$vw_travel_custom_css .='} ';
	}
    if($vw_travel_resp_stickyheader == true){
    	$vw_travel_custom_css .='@media screen and (max-width:575px) {';
		$vw_travel_custom_css .='.header-fixed{';
			$vw_travel_custom_css .='position:fixed;';
		$vw_travel_custom_css .='} }';
	}else if($vw_travel_resp_stickyheader == false){
		$vw_travel_custom_css .='@media screen and (max-width:575px){';
		$vw_travel_custom_css .='.header-fixed{';
			$vw_travel_custom_css .='position:static;';
		$vw_travel_custom_css .='} }';
	}

	$vw_travel_resp_slider = get_theme_mod( 'vw_travel_resp_slider_hide_show',false);
	if($vw_travel_resp_slider == true && get_theme_mod( 'vw_travel_slider_arrows', false) == false){
    	$vw_travel_custom_css .='#slider{';
			$vw_travel_custom_css .='display:none;';
		$vw_travel_custom_css .='} ';
	}
    if($vw_travel_resp_slider == true){
    	$vw_travel_custom_css .='@media screen and (max-width:575px) {';
		$vw_travel_custom_css .='#slider{';
			$vw_travel_custom_css .='display:block;';
		$vw_travel_custom_css .='} }';
	}else if($vw_travel_resp_slider == false){
		$vw_travel_custom_css .='@media screen and (max-width:575px) {';
		$vw_travel_custom_css .='#slider{';
			$vw_travel_custom_css .='display:none;';
		$vw_travel_custom_css .='} }';
	}

	$vw_travel_resp_metabox = get_theme_mod( 'vw_travel_metabox_hide_show',true);
    if($vw_travel_resp_metabox == true){
    	$vw_travel_custom_css .='@media screen and (max-width:575px) {';
		$vw_travel_custom_css .='.post-info{';
			$vw_travel_custom_css .='display:block;';
		$vw_travel_custom_css .='} }';
	}else if($vw_travel_resp_metabox == false){
		$vw_travel_custom_css .='@media screen and (max-width:575px) {';
		$vw_travel_custom_css .='.post-info{';
			$vw_travel_custom_css .='display:none;';
		$vw_travel_custom_css .='} }';
	}

	$vw_travel_resp_sidebar = get_theme_mod( 'vw_travel_sidebar_hide_show',true);
    if($vw_travel_resp_sidebar == true){
    	$vw_travel_custom_css .='@media screen and (max-width:575px) {';
		$vw_travel_custom_css .='#sidebar{';
			$vw_travel_custom_css .='display:block;';
		$vw_travel_custom_css .='} }';
	}else if($vw_travel_resp_sidebar == false){
		$vw_travel_custom_css .='@media screen and (max-width:575px) {';
		$vw_travel_custom_css .='#sidebar{';
			$vw_travel_custom_css .='display:none;';
		$vw_travel_custom_css .='} }';
	}

	$vw_travel_resp_scroll_top = get_theme_mod( 'vw_travel_resp_scroll_top_hide_show',true);
	if($vw_travel_resp_scroll_top == true && get_theme_mod( 'vw_travel_hide_show_scroll',true) != true){
    	$vw_travel_custom_css .='.scrollup i{';
			$vw_travel_custom_css .='visibility:hidden !important;';
		$vw_travel_custom_css .='} ';
	}
    if($vw_travel_resp_scroll_top == true){
    	$vw_travel_custom_css .='@media screen and (max-width:575px) {';
		$vw_travel_custom_css .='.scrollup i{';
			$vw_travel_custom_css .='visibility:visible !important;';
		$vw_travel_custom_css .='} }';
	}else if($vw_travel_resp_scroll_top == false){
		$vw_travel_custom_css .='@media screen and (max-width:575px){';
		$vw_travel_custom_css .='.scrollup i{';
			$vw_travel_custom_css .='visibility:hidden !important;';
		$vw_travel_custom_css .='} }';
	}

	/*------------- Top Bar Settings ------------------*/

	$vw_travel_topbar_padding_top_bottom = get_theme_mod('vw_travel_topbar_padding_top_bottom');
	if($vw_travel_topbar_padding_top_bottom != false){
		$vw_travel_custom_css .='.lower-header{';
			$vw_travel_custom_css .='padding-top: '.esc_attr($vw_travel_topbar_padding_top_bottom).'; padding-bottom: '.esc_attr($vw_travel_topbar_padding_top_bottom).';';
		$vw_travel_custom_css .='}';
	}

	/*-------------- Sticky Header Padding ----------------*/

	$vw_travel_sticky_header_padding = get_theme_mod('vw_travel_sticky_header_padding');
	if($vw_travel_sticky_header_padding != false){
		$vw_travel_custom_css .='.header-fixed{';
			$vw_travel_custom_css .='padding: '.esc_attr($vw_travel_sticky_header_padding).';';
		$vw_travel_custom_css .='}';
	}

	/*------------------ Search Settings -----------------*/
	
	$vw_travel_search_padding_top_bottom = get_theme_mod('vw_travel_search_padding_top_bottom');
	$vw_travel_search_padding_left_right = get_theme_mod('vw_travel_search_padding_left_right');
	$vw_travel_search_font_size = get_theme_mod('vw_travel_search_font_size');
	$vw_travel_search_border_radius = get_theme_mod('vw_travel_search_border_radius');
	if($vw_travel_search_padding_top_bottom != false || $vw_travel_search_padding_left_right != false || $vw_travel_search_font_size != false || $vw_travel_search_border_radius != false){
		$vw_travel_custom_css .='.search-box i{';
			$vw_travel_custom_css .='padding-top: '.esc_attr($vw_travel_search_padding_top_bottom).'; padding-bottom: '.esc_attr($vw_travel_search_padding_top_bottom).';padding-left: '.esc_attr($vw_travel_search_padding_left_right).';padding-right: '.esc_attr($vw_travel_search_padding_left_right).';font-size: '.esc_attr($vw_travel_search_font_size).';border-radius: '.esc_attr($vw_travel_search_border_radius).'px;';
		$vw_travel_custom_css .='}';
	}

	/*---------------- Button Settings ------------------*/

	$vw_travel_button_padding_top_bottom = get_theme_mod('vw_travel_button_padding_top_bottom');
	$vw_travel_button_padding_left_right = get_theme_mod('vw_travel_button_padding_left_right');
	if($vw_travel_button_padding_top_bottom != false || $vw_travel_button_padding_left_right != false){
		$vw_travel_custom_css .='.post-main-box .more-btn a{';
			$vw_travel_custom_css .='padding-top: '.esc_attr($vw_travel_button_padding_top_bottom).'; padding-bottom: '.esc_attr($vw_travel_button_padding_top_bottom).';padding-left: '.esc_attr($vw_travel_button_padding_left_right).';padding-right: '.esc_attr($vw_travel_button_padding_left_right).';';
		$vw_travel_custom_css .='}';
	}

	$vw_travel_button_border_radius = get_theme_mod('vw_travel_button_border_radius');
	if($vw_travel_button_border_radius != false){
		$vw_travel_custom_css .='.post-main-box .more-btn a,.more-btn a i{';
			$vw_travel_custom_css .='border-radius: '.esc_attr($vw_travel_button_border_radius).'px;';
		$vw_travel_custom_css .='}';
	}

	/*------------- Single Blog Page------------------*/

	$vw_travel_single_blog_post_navigation_show_hide = get_theme_mod('vw_travel_single_blog_post_navigation_show_hide',true);
	if($vw_travel_single_blog_post_navigation_show_hide != true){
		$vw_travel_custom_css .='.post-navigation{';
			$vw_travel_custom_css .='display: none;';
		$vw_travel_custom_css .='}';
	}

	/*-------------- Copyright Alignment ----------------*/

	$vw_travel_copyright_alingment = get_theme_mod('vw_travel_copyright_alingment');
	if($vw_travel_copyright_alingment != false){
		$vw_travel_custom_css .='.copyright p{';
			$vw_travel_custom_css .='text-align: '.esc_attr($vw_travel_copyright_alingment).';';
		$vw_travel_custom_css .='}';
	}

	$vw_travel_copyright_padding_top_bottom = get_theme_mod('vw_travel_copyright_padding_top_bottom');
	if($vw_travel_copyright_padding_top_bottom != false){
		$vw_travel_custom_css .='#footer-2{';
			$vw_travel_custom_css .='padding-top: '.esc_attr($vw_travel_copyright_padding_top_bottom).'; padding-bottom: '.esc_attr($vw_travel_copyright_padding_top_bottom).';';
		$vw_travel_custom_css .='}';
	}

	/*----------------Sroll to top Settings ------------------*/

	$vw_travel_scroll_to_top_font_size = get_theme_mod('vw_travel_scroll_to_top_font_size');
	if($vw_travel_scroll_to_top_font_size != false){
		$vw_travel_custom_css .='.scrollup i{';
			$vw_travel_custom_css .='font-size: '.esc_attr($vw_travel_scroll_to_top_font_size).';';
		$vw_travel_custom_css .='}';
	}

	$vw_travel_scroll_to_top_padding = get_theme_mod('vw_travel_scroll_to_top_padding');
	$vw_travel_scroll_to_top_padding = get_theme_mod('vw_travel_scroll_to_top_padding');
	if($vw_travel_scroll_to_top_padding != false){
		$vw_travel_custom_css .='.scrollup i{';
			$vw_travel_custom_css .='padding-top: '.esc_attr($vw_travel_scroll_to_top_padding).';padding-bottom: '.esc_attr($vw_travel_scroll_to_top_padding).';';
		$vw_travel_custom_css .='}';
	}

	$vw_travel_scroll_to_top_width = get_theme_mod('vw_travel_scroll_to_top_width');
	if($vw_travel_scroll_to_top_width != false){
		$vw_travel_custom_css .='.scrollup i{';
			$vw_travel_custom_css .='width: '.esc_attr($vw_travel_scroll_to_top_width).';';
		$vw_travel_custom_css .='}';
	}

	$vw_travel_scroll_to_top_height = get_theme_mod('vw_travel_scroll_to_top_height');
	if($vw_travel_scroll_to_top_height != false){
		$vw_travel_custom_css .='.scrollup i{';
			$vw_travel_custom_css .='height: '.esc_attr($vw_travel_scroll_to_top_height).';';
		$vw_travel_custom_css .='}';
	}

	$vw_travel_scroll_to_top_border_radius = get_theme_mod('vw_travel_scroll_to_top_border_radius');
	if($vw_travel_scroll_to_top_border_radius != false){
		$vw_travel_custom_css .='.scrollup i{';
			$vw_travel_custom_css .='border-radius: '.esc_attr($vw_travel_scroll_to_top_border_radius).'px;';
		$vw_travel_custom_css .='}';
	}

	/*----------------Social Icons Settings ------------------*/

	$vw_travel_social_icon_font_size = get_theme_mod('vw_travel_social_icon_font_size');
	if($vw_travel_social_icon_font_size != false){
		$vw_travel_custom_css .='#sidebar .custom-social-icons i, #footer .custom-social-icons i{';
			$vw_travel_custom_css .='font-size: '.esc_attr($vw_travel_social_icon_font_size).';';
		$vw_travel_custom_css .='}';
	}

	$vw_travel_social_icon_padding = get_theme_mod('vw_travel_social_icon_padding');
	if($vw_travel_social_icon_padding != false){
		$vw_travel_custom_css .='#sidebar .custom-social-icons i, #footer .custom-social-icons i{';
			$vw_travel_custom_css .='padding: '.esc_attr($vw_travel_social_icon_padding).';';
		$vw_travel_custom_css .='}';
	}

	$vw_travel_social_icon_width = get_theme_mod('vw_travel_social_icon_width');
	if($vw_travel_social_icon_width != false){
		$vw_travel_custom_css .='#sidebar .custom-social-icons i, #footer .custom-social-icons i{';
			$vw_travel_custom_css .='width: '.esc_attr($vw_travel_social_icon_width).';';
		$vw_travel_custom_css .='}';
	}

	$vw_travel_social_icon_height = get_theme_mod('vw_travel_social_icon_height');
	if($vw_travel_social_icon_height != false){
		$vw_travel_custom_css .='#sidebar .custom-social-icons i, #footer .custom-social-icons i{';
			$vw_travel_custom_css .='height: '.esc_attr($vw_travel_social_icon_height).';';
		$vw_travel_custom_css .='}';
	}

	$vw_travel_social_icon_border_radius = get_theme_mod('vw_travel_social_icon_border_radius');
	if($vw_travel_social_icon_border_radius != false){
		$vw_travel_custom_css .='#sidebar .custom-social-icons i, #footer .custom-social-icons i{';
			$vw_travel_custom_css .='border-radius: '.esc_attr($vw_travel_social_icon_border_radius).'px;';
		$vw_travel_custom_css .='}';
	}

	/*----------------Woocommerce Products Settings ------------------*/

	$vw_travel_products_padding_top_bottom = get_theme_mod('vw_travel_products_padding_top_bottom');
	if($vw_travel_products_padding_top_bottom != false){
		$vw_travel_custom_css .='.woocommerce ul.products li.product, .woocommerce-page ul.products li.product{';
			$vw_travel_custom_css .='padding-top: '.esc_attr($vw_travel_products_padding_top_bottom).'!important; padding-bottom: '.esc_attr($vw_travel_products_padding_top_bottom).'!important;';
		$vw_travel_custom_css .='}';
	}

	$vw_travel_products_padding_left_right = get_theme_mod('vw_travel_products_padding_left_right');
	if($vw_travel_products_padding_left_right != false){
		$vw_travel_custom_css .='.woocommerce ul.products li.product, .woocommerce-page ul.products li.product{';
			$vw_travel_custom_css .='padding-left: '.esc_attr($vw_travel_products_padding_left_right).'!important; padding-right: '.esc_attr($vw_travel_products_padding_left_right).'!important;';
		$vw_travel_custom_css .='}';
	}

	$vw_travel_products_box_shadow = get_theme_mod('vw_travel_products_box_shadow');
	if($vw_travel_products_box_shadow != false){
		$vw_travel_custom_css .='.woocommerce ul.products li.product, .woocommerce-page ul.products li.product{';
				$vw_travel_custom_css .='box-shadow: '.esc_attr($vw_travel_products_box_shadow).'px '.esc_attr($vw_travel_products_box_shadow).'px '.esc_attr($vw_travel_products_box_shadow).'px #ddd;';
		$vw_travel_custom_css .='}';
	}

	$vw_travel_products_border_radius = get_theme_mod('vw_travel_products_border_radius');
	if($vw_travel_products_border_radius != false){
		$vw_travel_custom_css .='.woocommerce ul.products li.product, .woocommerce-page ul.products li.product{';
			$vw_travel_custom_css .='border-radius: '.esc_attr($vw_travel_products_border_radius).'px;';
		$vw_travel_custom_css .='}';
	}