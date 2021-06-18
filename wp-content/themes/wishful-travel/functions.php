<?php
/**
 * Wishful Blog Child theme functions.
 *
 * Functions file for child theme, enqueues parent and child stylesheets by default.
 *
 * @since	1.0.0
 * @package Wishful_Travel
 */

// Exit if accessed directly.


if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if( !function_exists( 'wishful_travel_language' ) ) {
    /*
     * Load child theme language file
     */
    function wishful_travel_language() {

        /*
         * Make theme available for translation.
         * Translations can be filed in the /languages/ directory.
         * If you're building a theme based on Wishful Blog, use a find and replace
         * to change 'wishful-travel' to the name of your theme in all the template files.
         */
        load_child_theme_textdomain( 'wishful-travel', get_stylesheet_directory() . '/languages' );
    }
}

add_action( 'after_setup_theme', 'wishful_travel_language' );

/**
 * Adds custom classes to the array of body classes.
 *
 * @param array $classes Classes for the body element.
 * @return array
 */
function wishful_travel_body_classes( $classes ) {
    // Adds a class of hfeed to non-singular pages.
    $classes[] = 'travel-lite';

    return $classes;
}
add_filter( 'body_class', 'wishful_travel_body_classes' );


if ( !function_exists( 'wishful_travel_enqueue_styles' ) ) {
    /**
     * Enqueue Styles.
     *
     * Enqueue parent style and child styles where parent are the dependency
     * for child styles so that parent styles always get enqueued first.
     *
     * @since 1.0.0
     */

    function wishful_travel_enqueue_styles() {

        // Enqueue Parent theme's stylesheet.

        wp_enqueue_style( 'wishful-travel-parent-style', get_template_directory_uri() . '/style.css' );

        wp_enqueue_style( 'wishful-travel-fonts', wishful_travel_fonts_url() );

        wp_enqueue_style( 'wishful-travel-main-style', get_stylesheet_directory_uri() . '/wishfulthemes/assets/css/main-style.css' );

        wp_enqueue_script( 'wishful-travel-main-scripts', get_stylesheet_directory_uri() . '/wishfulthemes/assets/js/main-scripts.js', array('jquery'), wp_get_theme()->get( 'Version' ), true );
    }
}
// Add enqueue function to the desired action.
add_action( 'wp_enqueue_scripts', 'wishful_travel_enqueue_styles' );

/**
 * Add fonts options
 */
function wishful_travel_fonts_family_array( $fonts ) {

    $child_fonts = array(
        'Fira+Sans+Condensed:400,400i,500,500i,600,600i,700,700i,800,800i' => 'Fira Sans Condensed',
    );

    $child_fonts = array_merge( $child_fonts, $fonts );

	return $child_fonts;
}

if( !defined( 'WISHFULBLOG_PRO_CURRENT_VERSION' ) ) {

    add_filter( 'pro_fonts_family_array', 'wishful_travel_fonts_family_array' );
}

if( !function_exists( 'wishful_travel_customize_register' ) ) {
    /*
     * Load child theme customzier options
     */
    function wishful_travel_customize_register( $wp_customize ) {

        $fonts = wishful_blog_fonts_array();
        $font_weight = wishful_blog_font_weight_array();

        //Option : Enable Child Theme Header
        $wp_customize->add_setting( 'wishful_travel_enable_child_theme_header', array(
            'sanitize_callback'   => 'wp_validate_boolean',
            'default'             => true,
        ) );

        $wp_customize->add_control( 'wishful_travel_enable_child_theme_header', array(
            'label'                  => esc_html__( 'Enable Child Theme Header', 'wishful-travel' ),
            'description'            => esc_html__( 'On enabling this option, child theme header will be shown instead of parent theme.', 'wishful-travel' ),
            'section'                => 'wishful_blog_header_section',
            'type'                   => 'checkbox',
            'priority'               => 1,
        ) );

        //Option : Enable Child Theme Homepage Post listing
        $wp_customize->add_setting( 'wishful_travel_enable_child_theme_homepage_post_listing', array(
            'sanitize_callback'   => 'wp_validate_boolean',
            'default'             => true,
        ) );

        $wp_customize->add_control( 'wishful_travel_enable_child_theme_homepage_post_listing', array(
            'label'                  => esc_html__( 'Enable Child Theme Post Listing', 'wishful-travel' ),
            'description'            => esc_html__( 'On enabling this option, child theme post listing will be shown instead of parent theme.', 'wishful-travel' ),
            'section'                => 'wishful_blog_homepage_post_layout_options',
            'type'                   => 'checkbox',
            'priority'               => 1,
        ) );

        //Option : Enable Child Theme Archive Post listing
        $wp_customize->add_setting( 'wishful_travel_enable_child_theme_archive_post_listing', array(
            'sanitize_callback'   => 'wp_validate_boolean',
            'default'             => true,
        ) );

        $wp_customize->add_control( 'wishful_travel_enable_child_theme_archive_post_listing', array(
            'label'                  => esc_html__( 'Enable Child Theme Post Listing', 'wishful-travel' ),
            'description'            => esc_html__( 'On enabling this option, child theme post listing will be shown instead of parent theme.', 'wishful-travel' ),
            'section'                => 'wishful_blog_archive_post_layout_options',
            'type'                   => 'checkbox',
            'priority'               => 1,
        ) );

        //Option : Enable Child Theme Search Post listing
        $wp_customize->add_setting( 'wishful_travel_enable_child_theme_search_post_listing', array(
            'sanitize_callback'   => 'wp_validate_boolean',
            'default'             => true,
        ) );

        $wp_customize->add_control( 'wishful_travel_enable_child_theme_search_post_listing', array(
            'label'                  => esc_html__( 'Enable Child Theme Post Listing', 'wishful-travel' ),
            'description'            => esc_html__( 'On enabling this option, child theme post listing will be shown instead of parent theme.', 'wishful-travel' ),
            'section'                => 'wishful_blog_search_post_layout_options',
            'type'                   => 'checkbox',
            'priority'               => 1,
        ) );

        //Option : Child Theme Email
        $wp_customize->add_setting( 'wishful_travel_child_theme_email', array(
            'sanitize_callback'   => 'sanitize_email',
            'default'             => esc_html__( 'youremail@domain.com', 'wishful-travel' ),
        ) );

        $wp_customize->add_control( 'wishful_travel_child_theme_email', array(
            'label'                  => esc_html__( 'Email Address', 'wishful-travel' ),
            'section'                => 'wishful_blog_header_section',
            'type'                   => 'email',
            'active_callback'        => 'wishful_blog_is_active_child_header',
            'priority'               => 10,
        ) );

        //Option : Child Theme Number
        $wp_customize->add_setting( 'wishful_travel_child_theme_number', array(
            'sanitize_callback'   => 'sanitize_text_field',
            'default'             => esc_html__( '666 6666 666', 'wishful-travel' ),
        ) );

        $wp_customize->add_control( 'wishful_travel_child_theme_number', array(
            'label'                  => esc_html__( 'Phone Number', 'wishful-travel' ),
            'section'                => 'wishful_blog_header_section',
            'type'                   => 'text',
            'active_callback'        => 'wishful_blog_is_active_child_header',
            'priority'               => 10,
        ) );

        //Option : Child Theme Address
        $wp_customize->add_setting( 'wishful_travel_child_theme_address', array(
            'sanitize_callback'   => 'sanitize_text_field',
            'default'             => esc_html__( 'Street, Country', 'wishful-travel' ),
        ) );

        $wp_customize->add_control( 'wishful_travel_child_theme_address', array(
            'label'                  => esc_html__( 'Address', 'wishful-travel' ),
            'section'                => 'wishful_blog_header_section',
            'type'                   => 'text',
            'active_callback'        => 'wishful_blog_is_active_child_header',
            'priority'               => 10,
        ) );

        //Option : Child Theme Address link
        $wp_customize->add_setting( 'wishful_travel_child_theme_address_link', array(
            'sanitize_callback'   => 'esc_url_raw',
            'default'             => '#',
        ) );

        $wp_customize->add_control( 'wishful_travel_child_theme_address_link', array(
            'label'                  => esc_html__( 'Address Link', 'wishful-travel' ),
            'section'                => 'wishful_blog_header_section',
            'type'                   => 'url',
            'active_callback'        => 'wishful_blog_is_active_child_header',
            'priority'               => 10,
        ) );

        /*-----------------------------------------------------------------------------
							Header top sections
        -----------------------------------------------------------------------------*/

        //Section Header top
        $wp_customize->add_section( 'wishful_travel_header_top_section', array(
            'priority'     => 11,
            'title'        => esc_html__( 'Top Header', 'wishful-travel' ),
            'panel'        => 'wishful_blog_header_options',
            'active_callback' => 'wishful_blog_is_active_child_header',
        ) );

        //Option : Background Color
        $wp_customize->add_setting( 'wishful_travel_header_top_background_color', array(
            'sanitize_callback'   => 'sanitize_hex_color',
            'default'             => '#0fb9b1',
        ) );
        $wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'wishful_travel_header_top_background_color', array(
            'label'                    => esc_html__('Background Color', 'wishful-travel' ),
            'section'                  => 'wishful_travel_header_top_section',
        ) ) );

        //Option : text Color
        $wp_customize->add_setting( 'wishful_travel_header_top_text_color', array(
            'sanitize_callback'   => 'sanitize_hex_color',
            'default'             => '#8aece8',
        ) );
        $wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'wishful_travel_header_top_text_color', array(
            'label'                    => esc_html__('Text &amp; Icon Color', 'wishful-travel' ),
            'section'                  => 'wishful_travel_header_top_section',
        ) ) );

        //Option : text hover Color
        $wp_customize->add_setting( 'wishful_travel_header_top_text_hover_color', array(
            'sanitize_callback'   => 'sanitize_hex_color',
            'default'             => '#151515',
        ) );
        $wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'wishful_travel_header_top_text_hover_color', array(
            'label'                    => esc_html__('Text &amp; Icon Hover Color', 'wishful-travel' ),
            'section'                  => 'wishful_travel_header_top_section',
        ) ) );

        /*------------------------- Header top text Typography -------------------------*/

        //Option : Header top text Font Family
        $wp_customize->add_setting( 'wishful_blog_font_family_header_top_text_typography', array(
            'sanitize_callback'   => 'sanitize_text_field',
            'default'             => 'Fira+Sans+Condensed:400,400i,500,500i,600,600i,700,700i,800,800i',
        ) );

        $wp_customize->add_control( 'wishful_blog_font_family_header_top_text_typography', array(
            'label'                    => esc_html__('Text Font Family', 'wishful-travel' ),
            'section'                  => 'wishful_travel_header_top_section',
            'type'                     => 'select',
            'choices'                  => $fonts,
        ) );

        //Option : Header top text Font Weight
        $wp_customize->add_setting( 'wishful_blog_font_weight_header_top_text_typography', array(
            'sanitize_callback'   => 'wishful_blog_sanitize_select',
            'default'             => '400_w',
        ) );

        $wp_customize->add_control( 'wishful_blog_font_weight_header_top_text_typography', array(
            'label'                    => esc_html__('Text Font Weight', 'wishful-travel' ),
            'section'                  => 'wishful_travel_header_top_section',
            'type'                     => 'select',
            'choices'                  => $font_weight,
        ) );

        //Option : Header top text Font Size
        $wp_customize->add_setting( 'wishful_blog_font_size_header_top_text_typography', array(
            'sanitize_callback'   => 'sanitize_text_field',
            'default'             => '16px',
        ) );

        $wp_customize->add_control( 'wishful_blog_font_size_header_top_text_typography', array(
            'label'                    => esc_html__('Text Font Size', 'wishful-travel' ),
            'description'              => esc_html__( 'You can set font size in pixel or normal. Eg: 24px, 1.3em etc.', 'wishful-travel' ),
            'section'                  => 'wishful_travel_header_top_section',
            'type'                     => 'text',
        ) );

        //Option : Header top icon Font Size
        $wp_customize->add_setting( 'wishful_blog_font_size_header_top_icon_typography', array(
            'sanitize_callback'   => 'sanitize_text_field',
            'default'             => '20px',
        ) );

        $wp_customize->add_control( 'wishful_blog_font_size_header_top_icon_typography', array(
            'label'                    => esc_html__('Icon Font Size', 'wishful-travel' ),
            'description'              => esc_html__( 'You can set font size in pixel or normal. Eg: 24px, 1.3em etc.', 'wishful-travel' ),
            'section'                  => 'wishful_travel_header_top_section',
            'type'                     => 'text',
        ) );

        //Option : Banner hero image
        $wp_customize->add_setting( 'wishful_travel_banner_hero_image', array(
            'sanitize_callback'        => 'wishful_blog_sanitize_image'
        ) );

        $wp_customize->add_control( new WP_Customize_Image_Control( $wp_customize, 'wishful_travel_banner_hero_image', array(
            'label'       		       => esc_html__( 'Upload Hero Image', 'wishful-travel' ),
            'section'     		       => 'wishful_blog_banner_options',
            'active_callback'          => 'wishful_blog_is_active_child_banner',
            'priority'                 => 20,
        ) ) );

        //Option : Banner hero text
        $wp_customize->add_setting( 'wishful_travel_banner_hero_text', array(
            'sanitize_callback'         => 'sanitize_text_field',
            'default'                   => 'Find Your Tour',
        ) );

        $wp_customize->add_control( 'wishful_travel_banner_hero_text', array(
            'label'                     => esc_html__('Hero Text', 'wishful-travel' ),
            'section'     		        => 'wishful_blog_banner_options',
            'active_callback'           => 'wishful_blog_is_active_child_banner',
            'type'                      => 'text',
            'priority'                  => 20,
        ) );

        //Option : Banner hero text color
        $wp_customize->add_setting( 'wishful_travel_banner_hero_text_color', array(
            'sanitize_callback'   => 'sanitize_hex_color',
            'default'             => '#fff',
        ) );
        $wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'wishful_travel_banner_hero_text_color', array(
            'label'                     => esc_html__('Color', 'wishful-travel' ),
            'section'                   => 'wishful_travel_header_top_section',
            'section'     		        => 'wishful_blog_banner_options',
            'active_callback'           => 'wishful_blog_is_active_child_banner',
            'priority'                  => 20,
        ) ) );

        //Option : Banner hero highlight text
        $wp_customize->add_setting( 'wishful_travel_banner_hero_highlight_text', array(
            'sanitize_callback'         => 'sanitize_text_field',
            'default'                   => esc_html__( 'Destinations', 'wishful-travel' ),
        ) );

        $wp_customize->add_control( 'wishful_travel_banner_hero_highlight_text', array(
            'label'                     => esc_html__('Hero Highlight Text', 'wishful-travel' ),
            'section'     		        => 'wishful_blog_banner_options',
            'active_callback'           => 'wishful_blog_is_active_child_banner',
            'type'                      => 'text',
            'priority'                  => 20,
        ) );

        //Option : Banner hero highlight text color
        $wp_customize->add_setting( 'wishful_travel_banner_hero_highlight_text_color', array(
            'sanitize_callback'   => 'sanitize_hex_color',
            'default'             => '#efcda3',
        ) );
        $wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'wishful_travel_banner_hero_highlight_text_color', array(
            'label'                     => esc_html__('Color', 'wishful-travel' ),
            'section'                   => 'wishful_travel_header_top_section',
            'section'     		        => 'wishful_blog_banner_options',
            'active_callback'           => 'wishful_blog_is_active_child_banner',
            'priority'                  => 20,
        ) ) );

        //Option : Banner hero button text
        $wp_customize->add_setting( 'wishful_travel_banner_hero_button_text', array(
            'sanitize_callback'         => 'sanitize_text_field',
            'default'                   => 'Explore More',
        ) );

        $wp_customize->add_control( 'wishful_travel_banner_hero_button_text', array(
            'label'                     => esc_html__('Hero Button Text', 'wishful-travel' ),
            'section'     		        => 'wishful_blog_banner_options',
            'active_callback'           => 'wishful_blog_is_active_child_banner',
            'type'                      => 'text',
            'priority'                  => 20,
        ) );

        //Option : Banner hero button text link
        $wp_customize->add_setting( 'wishful_travel_banner_hero_button_text_link', array(
            'sanitize_callback'         => 'esc_url_raw',
            'default'                   => '#',
        ) );

        $wp_customize->add_control( 'wishful_travel_banner_hero_button_text_link', array(
            'label'                     => esc_html__('Hero Button Text Link', 'wishful-travel' ),
            'section'     		        => 'wishful_blog_banner_options',
            'active_callback'           => 'wishful_blog_is_active_child_banner',
            'type'                      => 'text',
            'priority'                  => 20,
        ) );

        //Option : Banner hero button text color
        $wp_customize->add_setting( 'wishful_travel_banner_hero_button_text_color', array(
            'sanitize_callback'   => 'sanitize_hex_color',
            'default'             => '#fff',
        ) );
        $wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'wishful_travel_banner_hero_button_text_color', array(
            'label'                     => esc_html__('Color', 'wishful-travel' ),
            'section'                   => 'wishful_travel_header_top_section',
            'section'     		        => 'wishful_blog_banner_options',
            'active_callback'           => 'wishful_blog_is_active_child_banner',
            'priority'                  => 20,
        ) ) );
    }
}
add_action( 'customize_register', 'wishful_travel_customize_register' );

/* -------------- Filters for header layout -------------- */

function wisful_travel_header_layout() {

    $header_layout = 'child_header_one';

    return $header_layout;
}

/* -------------- Filters for header layout template -------------- */

function wisful_travel_header_layout_template( $header_layout ) {

    if( $header_layout == 'child_header_one' ) {

        get_template_part( 'template-parts/header/child-header', 'one' );
    }
}

$enable_child_theme_header = get_theme_mod( 'wishful_travel_enable_child_theme_header', true );

if( $enable_child_theme_header ) {

    if( defined( 'WISHFULBLOG_PRO_CURRENT_VERSION' ) ) {

        remove_filter( 'pro_header_layout_options', 'wisfulblog_pro_header_layout_options' );
        add_filter( 'pro_header_layout_options', 'wisful_travel_header_layout' );

        remove_filter( 'pro_header_layout_template', 'wisfulblog_pro_header_layout_template' );
        add_filter( 'pro_header_layout_template', 'wisful_travel_header_layout_template' );

    } else {

        add_filter( 'pro_header_layout_options', 'wisful_travel_header_layout' );
        add_filter( 'pro_header_layout_template', 'wisful_travel_header_layout_template' );
    }
}

/* -------------- Filters for banner layout -------------- */

function wisful_travel_banner_layouts_array( $banner_layouts ) {

	$child_banner_layouts = array(
        'child_banner_one'   => esc_html__( 'Child Banner One', 'wishful-travel' ),
    );

    $child_banner_layouts = array_merge( $child_banner_layouts, $banner_layouts );

	return $child_banner_layouts;
}
add_filter( 'pro_banner_layouts_array', 'wisful_travel_banner_layouts_array' );

/* -------------- Filters for banner layout template -------------- */

function wisful_travel_banner_layout_template( $banner_layout ) {

    if( $banner_layout == 'child_banner_one' ) {

        get_template_part( 'template-parts/banner/child-banner', 'one' );
    }

}
add_filter( 'pro_banner_layout_template', 'wisful_travel_banner_layout_template' );

$child_theme_banner  = get_theme_mod( 'wishful_blog_banner_layout', 'child_banner_one' );

if( $child_theme_banner == 'child_banner_one' ) {

    if( defined( 'WISHFULBLOG_PRO_CURRENT_VERSION' ) ) {

        remove_filter( 'pro_banner_layout_template', 'wisfulblog_pro_banner_layout_template' );
        add_filter( 'pro_banner_layout_template', 'wisful_travel_banner_layout_template' );

        remove_filter( 'pro_header_layout_template', 'wisfulblog_pro_header_layout_template' );
        add_filter( 'pro_header_layout_template', 'wisful_travel_header_layout_template' );

    } else {

        add_filter( 'pro_banner_layout_template', 'wisful_travel_banner_layout_template' );
    }
}

function wisful_travel_post_content_button_style( $button_style ) {

    $button_class = '';

    $status = false;

    switch( $button_style ) {

        case 'default_style':
            if( is_home() ) {
                $status = get_theme_mod( 'wishful_travel_enable_child_theme_homepage_post_listing', true );
            }
            if( is_archive() ) {
                $status = get_theme_mod( 'wishful_travel_enable_child_theme_archive_post_listing', true );
            }
            if( is_search() ) {
                $status = get_theme_mod( 'wishful_travel_enable_child_theme_search_post_listing', true );
            }

            if( $status == true ) {

                $button_class = 'button-more';

            } else {

                $button_class = '';
            }
            break;

        case 'style_one':
            $button_class = 'btn-style1';
            break;

        case 'style_two':
            $button_class = 'btn-style2';
            break;

        case 'style_three':
            $button_class = 'btn-style3';
            break;

        case 'style_four':
            $button_class = 'btn-style4';
            break;

        default:
            $button_class = '';
    }

    return $button_class;
}

if( !function_exists( 'wishful_travel_button_style' ) ) {
	/*
	 * Function to get button style
	 */
	function wishful_travel_button_style() {

        $button_class = 'button-more';

        echo esc_attr( $button_class );
	}
}

if( defined( 'WISHFULBLOG_PRO_CURRENT_VERSION' ) ) {

    remove_filter( 'pro_post_content_button_style', 'wisfulblog_pro_post_content_button_style' );
    add_filter( 'pro_post_content_button_style', 'wisful_travel_post_content_button_style' );

} else {

    add_action( 'pro_button_style', 'wishful_travel_button_style', 20 );
}

/*
 *	Active Callback For Child Header
 */
if( ! function_exists( 'wishful_blog_is_active_child_header' ) ) {

	function wishful_blog_is_active_child_header( $control ) {

		if( $control->manager->get_setting( 'wishful_travel_enable_child_theme_header' )->value() == 1 ) {

			return true;

		} else {

			return false;
		}
	}
}

/*
 *	Active Callback For Child Banner
 */
if( ! function_exists( 'wishful_blog_is_active_child_banner' ) ) {

	function wishful_blog_is_active_child_banner( $control ) {

		if( $control->manager->get_setting( 'wishful_blog_banner_layout' )->value() == 'child_banner_one' ) {

			return true;

		} else {

			return false;
		}
	}
}

/**
 * Funtion To Get Google Fonts
 */
if ( !function_exists( 'wishful_travel_fonts_url' ) ) {
    /**
     * Return Font's URL.
     *
     * @since 1.0.0
     * @return string Fonts URL.
     */
    function wishful_travel_fonts_url() {

        $fonts_url = '';
        $fonts     = array();
        $subsets   = 'latin,latin-ext';

        $font_options = wishful_travel_selected_fonts();

        /* translators: If there are characters in your language that are not supported by Merriweather, translate this to 'off'. Do not translate into your own language. */
        if ('off' !== _x('on', 'Fira Sans Condensed font: on or off', 'wishful-travel')) {
            $fonts[] = 'Fira Sans Condensed:400,400i,500,500i,600,600i,700,700i,800,800i';
        }

        $font_options = array_unique( $font_options );

        foreach ( $font_options as $f) {

            $f_family = explode(':', $f);

            $f_family = str_replace('+', ' ', $f_family);

            $font_family = ( !empty( $f_family[1]) ) ? $f_family[1] : '';

            $fonts[] = $f_family[0].':'.$font_family;

        }

        if ( $fonts ) {
            $fonts_url = add_query_arg( array(
                'family' => urlencode( implode( '|', $fonts ) ),
                'subset' => urlencode( $subsets ),
            ), '//fonts.googleapis.com/css' );
        }
        return $fonts_url;
    }
}

/*
 * Function to get selected dynamic google fonts
 */
if( !function_exists( 'wishful_travel_selected_fonts' ) ) {

	function wishful_travel_selected_fonts() {

		$fonts = array();

        $header_top_text_font_family = get_theme_mod( 'wishful_blog_font_family_header_top_text_typography', 'Fira+Sans+Condensed:400,400i,500,500i,600,600i,700,700i,800,800i' );

        if( !empty( $header_top_text_font_family ) ) {

        	$fonts[] = $header_top_text_font_family;
        }

		$fonts = array_unique( $fonts );

		return $fonts;
	}
}

/**
 * Function to load dynamic styles.
 *
 * @since  1.0.0
 * @access public
 * @return null
 */
function wishful_travel_dynamic_style() {

    ?>
    <style type="text/css">

    <?php

    $fonts = wishful_blog_fonts_array();

    /*-----------------------------------------------------------------------------
                                Theme Color
    -----------------------------------------------------------------------------*/

    $primary_color = get_theme_mod( 'wishful_blog_primary_color', '#0fb9b1' );

    if( !empty( $primary_color ) ) {

        ?>

        .lite-blog .entry-title a:hover,
        .lite-blog .post-category a:hover {

            color: <?php echo esc_attr( $primary_color ); ?>;
        }

        .lite-blog .post-date,
        .post-meta {

            background-color: <?php echo esc_attr( $primary_color ); ?>;
        }


        <?php

    }

    /*-----------------------------------------------------------------------------
                                Post Listing Title Typo
    -----------------------------------------------------------------------------*/

    $post_listing_title_font_family = get_theme_mod( 'wishful_blog_font_family_post_listing_title_typography', 'Montserrat:400,400i,500,500i,600,600i,700,700i,800,800i' );
    $post_listing_title_font_weight = get_theme_mod( 'wishful_blog_font_weight_post_listing_title_typography', '700_w' );
    $post_listing_title_font_size = get_theme_mod( 'wishful_blog_font_size_post_listing_title_typography', '24px' );

    $post_listing_title_line_height = get_theme_mod( 'wishfulblog_pro_line_height_post_listing_title_typography', '1.25' );
    $post_listing_title_letter_spacing = get_theme_mod( 'wishfulblog_pro_letter_spacing_post_listing_title_typography', '0px' );

    ?>
    .lite-blog-list .lite-blog h3.entry-title a
    {

        <?php

        if( !empty( $post_listing_title_font_family ) ) {

            ?>
            font-family: <?php echo esc_attr( $fonts[ $post_listing_title_font_family ] ); ?>;
            <?php
        }

        if( !empty( $post_listing_title_font_weight ) ) {

            ?>
            font-weight: <?php echo esc_attr( wishful_blog_dynamic_font_weight( $post_listing_title_font_weight ) ); ?>;
            <?php
        }

        if( !empty( $post_listing_title_font_size ) ) {

            ?>
            font-size: <?php echo esc_attr( $post_listing_title_font_size ); ?>;
            <?php
        }

        if( !empty( $post_listing_title_line_height ) ) {

            ?>
            line-height: <?php echo esc_attr( $post_listing_title_line_height ); ?>;
            <?php

        }

        if( !empty( $post_listing_title_letter_spacing ) ) {

            ?>
            letter-spacing: <?php echo esc_attr( $post_listing_title_letter_spacing ); ?>;
            <?php

        }

        ?>
    }

    <?php

    /*-----------------------------------------------------------------------------
                                Top Header Color
    -----------------------------------------------------------------------------*/

    $header_top_background_color = get_theme_mod( 'wishful_travel_header_top_background_color', '#0fb9b1' );
    $header_top_text_color = get_theme_mod( 'wishful_travel_header_top_text_color', '#8aece8' );
    $header_top_text_hover_color = get_theme_mod( 'wishful_travel_header_top_text_hover_color', '#151515' );

    if( !empty( $header_top_background_color ) ) {

        ?>

        .lite-topbar {

            background-color: <?php echo esc_attr( $header_top_background_color ); ?>;
        }
        <?php

    }

    if( !empty( $header_top_text_color ) ) {

        ?>

        .lite-topbar .topbar-info a,
        .lite-topbar .top-header .top-social li a {

            color: <?php echo esc_attr( $header_top_text_color ); ?>;
        }
        <?php

    }

    if( !empty( $header_top_text_hover_color ) ) {

        ?>

        .lite-topbar .topbar-info a:hover,
        .lite-topbar .top-header .top-social li a:hover {

            color: <?php echo esc_attr( $header_top_text_hover_color ); ?>;
        }
        <?php

    }

    /*-----------------------------------------------------------------------------
                                Site Title Padding Top
    -----------------------------------------------------------------------------*/

    $site_title_padding_top = get_theme_mod( 'wishful_blog_site_title_padding_top', '15px' );

    if( !empty( $site_title_padding_top ) ) {

        ?>
        .lite-menu {

            padding-top: <?php echo esc_attr( $site_title_padding_top ); ?>;
        }
        <?php

    }

    /*-----------------------------------------------------------------------------
                                Site Title Padding Bottom
    -----------------------------------------------------------------------------*/

    $site_title_padding_bottom = get_theme_mod( 'wishful_blog_site_title_padding_bottom', '15px' );

    if( !empty( $site_title_padding_bottom ) ) {

        ?>
        .lite-menu {

            padding-bottom: <?php echo esc_attr( $site_title_padding_bottom ); ?>;
        }
        <?php

    }

    /*-----------------------------------------------------------------------------
                                Menu Main Background Color
    -----------------------------------------------------------------------------*/

    $menu_main_bg_color = get_theme_mod( 'wishful_blog_menu_main_bg_color', '#f1f1f1' );

    if( !empty( $menu_main_bg_color ) ) {

        ?>
        .lite-menu {

            background-color: <?php echo esc_attr( $menu_main_bg_color ); ?>;
        }
        <?php

    }

    /*-----------------------------------------------------------------------------
                                Header Top Typo
    -----------------------------------------------------------------------------*/

    $header_top_text_font_family = get_theme_mod( 'wishful_blog_font_family_header_top_text_typography', 'Fira+Sans+Condensed:400,400i,500,500i,600,600i,700,700i,800,800i' );
    $header_top_text_font_weight = get_theme_mod( 'wishful_blog_font_weight_header_top_text_typography', '400_w' );
    $header_top_text_font_size = get_theme_mod( 'wishful_blog_font_size_header_top_text_typography', '16px' );
    $header_top_icon_font_size = get_theme_mod( 'wishful_blog_font_size_header_top_icon_typography', '20px' );

    ?>
    .lite-topbar .topbar-info a
    {

        <?php

        if( !empty( $header_top_text_font_family ) ) {

            ?>
            font-family: <?php echo esc_attr( $fonts[ $header_top_text_font_family ] ); ?>;
            <?php
        }

        if( !empty( $header_top_text_font_weight ) ) {

            ?>
            font-weight: <?php echo esc_attr( wishful_blog_dynamic_font_weight( $header_top_text_font_weight ) ); ?>;
            <?php
        }

        if( !empty( $header_top_text_font_size ) ) {

            ?>
            font-size: <?php echo esc_attr( $header_top_text_font_size ); ?>;
            <?php
        }

        ?>
    }

    .top-header .top-social li>a
    {

        <?php

        if( !empty( $header_top_icon_font_size ) ) {

            ?>
            font-size: <?php echo esc_attr( $header_top_icon_font_size ); ?>;
            <?php
        }

        ?>
    }

    <?php

    /*-----------------------------------------------------------------------------
                                Banner Color
    -----------------------------------------------------------------------------*/

    $banner_hero_text_color = get_theme_mod( 'wishful_travel_banner_hero_text_color', '#fff' );
    $banner_hero_highlight_text_color = get_theme_mod( 'wishful_travel_banner_hero_highlight_text_color', '#efcda3' );
    $banner_hero_button_text_color = get_theme_mod( 'wishful_travel_banner_hero_button_text_color', '#fff' );

    if( !empty( $banner_hero_text_color ) ) {

        ?>

        .lite-slider-caption {

            color: <?php echo esc_attr( $banner_hero_text_color ); ?>;
        }
        <?php

    }

    if( !empty( $banner_hero_highlight_text_color ) ) {

        ?>

        .caption-detail h2 span {

            color: <?php echo esc_attr( $banner_hero_highlight_text_color ); ?>;
        }
        <?php

    }

    if( !empty( $banner_hero_button_text_color ) ) {

        ?>

        .banner-lite-slider a.button-more:visited {

            color: <?php echo esc_attr( $banner_hero_button_text_color ); ?>;
        }
        <?php

    }

    ?>

    </style>

    <?php
}
add_action( 'wp_head', 'wishful_travel_dynamic_style' );
