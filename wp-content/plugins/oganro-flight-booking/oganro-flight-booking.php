<?php

/**
 * Plugin Name:       Oganro Flight Booking
 * Plugin URI:        wordpress.org/plugins/oganro-flight-booking
 * Description:       Flight search box and widget for WordPress travel agency website developements.
 * Version:           1.00
 * Requires at least: 5.2
 * Requires PHP:      7.2
 * Author:            Oganro Limited. 
 * Author URI:        https://www.oganro.com/
 * License:           GPL v2 or later
 * License URI:       https://www.gnu.org/licenses/gpl-2.0.html
 */


//  exit if access directly
if (!defined('ABSPATH')) {
    exit;
}

// import scripts
function otb_admin_scripts()
{
    wp_enqueue_style('otb-main-style', plugin_dir_url(__FILE__) . '/css/private/style.css');
    wp_enqueue_script('otb_js_function_gen', plugin_dir_url(__FILE__) . '/js/main.js');
    wp_enqueue_style('otb-main-style');
}

add_action('admin_enqueue_scripts', 'otb_admin_scripts');

// front end
function otb_frontend_scripts()
{
    wp_register_style('tb-main-style', plugins_url('/css/style.css', __FILE__));
}

add_action('wp_enqueue_scripts', 'otb_frontend_scripts');

function otb_plugin_top_menu()
{
    // icon (menu) footer
    $icon_menu = plugin_dir_url(__FILE__) . '/img/pic28.png';

    add_menu_page('Oganro Flight Booking', 'Oganro Flight Booking', null, __FILE__, 'otb_menu_page', $icon_menu, 3);
    add_submenu_page(__FILE__, 'Contact', 'Contact', 'manage_options', __FILE__ . '/contact', 'otb_about_page');
    add_submenu_page(__FILE__, 'Short Code', 'Short Code', 'manage_options', __FILE__ . '/shortcode', 'otb_shortcode_page');
}

// About page
function otb_about_page()
{
    // image footer
    $footer_img = plugin_dir_url(__FILE__) . '/img/Oganro.png';
    // image header 
    $header_img = plugin_dir_url(__FILE__) . '/img/header_logo.png';
?>

    <div class='wrap'>

        <div class="top-image"></div>
        <img src="<?php echo $header_img ?>" alt="Oganro Limited">
        <h1 class="text-center">Oganro Limited. </h1>
        <h2>OFFICIAL FLIGHT SEARCH BOX AND WIDGET FOR WORDPRESS TRAVEL AGENCY WEBSITE DEVELOPMENTS. <br />
            <a href="http://booking.oganro.com/" target="_blank">Visit Our Demo</a> </h2>
        <Important>Oganro Flight Search Widget is useful to create WordPress based B2C travel agency websites, which can be integrated to any travel industry wholesale supplier. <br />Important – We do not make commercial agreements with wholesale suppliers. It is always clients should make sure to complete commercials with respective suppliers.</p>

            <div class="inline-block">
                <div class="">
                    <img src="<?php echo $footer_img ?>" alt="Oganro Limited" class="footer-img">
                </div>
                <div class="">
                    <div class="footer-img-content"><span class="dashicons dashicons-admin-site-alt custom-icon"></span><a href="https://www.oganro.com/" target="_blank">Oganro Web Site</a></div>
                    <div class="footer-img-content"><span class="dashicons dashicons-email custom-icon"></span><a href=" mail:info@oganro.com" style="margin-bottom: 25px;">info@oganro.com</a></div>
                    <div class="footer-img-content"><span class="dashicons dashicons-phone custom-icon"></span><a href="tel:+94115238525">+94 11 5 238525</a></div>
                </div>
            </div>
    </div>

<?php
}

// shortcode page
function otb_shortcode_page()
{
    $v = '[oganro_flight_booking]';
?>

    <div class='wrap'>
        <h1>Short Code Page</h1>

        <h4>Copy and paste the code in any Wordpress page as a shortcode.</h4>

        <table class="form-table">
            <tr>
                <th scope="row"><label for="blogname"><input class="short-code" type="text" value="<?php echo $v ?>" id="myInput" readonly></label></th>
                <td><button class="button button-primary button-hero " onclick="otb_js_function_main()">Click Here To Copy</button></td>
            </tr>
        </table>

        <div>
            <h2>Widget Options</h2>

            <table class="form-table">
                <tr>
                    <th scope="row"><label for="shortcode-height">Height</label></th>
                    <td><input name="shortcode-height" type="text" maxlength="6" id="shortcodeHeight" aria-describedby="tagline-description-height" class="regular-text" />
                        <p class="description" id="tagline-description-height"><?php _e('Enter with pixels or precentage. (eg: 500px or 80%)'); ?></p>
                    </td>
                </tr>

                <tr>
                    <th scope="row"><label for="shortcode-width">Width</label></th>
                    <td><input name="shortcode-width" type="text" maxlength="6" id="shortcodeWidth" aria-describedby="tagline-description-width" class="regular-text" />
                        <p class="description" id="tagline-description-width"><?php _e('Enter with pixels or precentage. (eg: 500px or 80%)'); ?></p>
                    </td>
                </tr>
            </table>

            <button class="button button-primary" onclick="otb_js_function_gen()">Generate and Copy</button>
        </div>
    </div>

<?php
}

add_action('admin_menu', 'otb_plugin_top_menu');

// shortcode generate function
function otb_short_code($atts)
{
    // shortcode attributes
    extract(shortcode_atts(array(
        'width'    => '100%',
        'height'  => '680px'
    ), $atts));

    $iframeurl = 'https://booking.oganro.com/booking-engine/search-widget/flight';

    $link_attr = array(
        'width'   => esc_attr($width),
        'height'  => esc_attr($height)
    );

    $link_attrs_str = '';

    foreach ($link_attr as $key => $val) {
        if ($val) {
            $link_attrs_str .= ' ' . $key . '="' . $val . '"';
        }
    }

    return '<iframe class="search-widget-flight" scrolling="yes" allowtransparency="true" 
    frameBorder="0" src="https://booking.oganro.com/booking-engine/search-widget/flight" ' . do_shortcode($link_attrs_str) . '></iframe>';
}

add_shortcode('oganro_flight_booking', 'otb_short_code');
