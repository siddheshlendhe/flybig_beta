<?php

/**
 * The plugin bootstrap file
 * This file is read by WordPress to generate the plugin information in the plugin
 * admin area. This file also includes all of the dependencies used by the plugin,
 * registers the activation and deactivation functions, and defines a function
 * that starts the plugin.
 * @link              http://www.travelpayouts.com/?locale=en
 * @since             1.0.0
 * @package           Travelpayouts
 * @wordpress-plugin
 * Plugin Name:       Travelpayouts
 * Plugin URI:        https://wordpress.org/plugins/travelpayouts/
 * Description:       Earn money and make your visitors happy! Offer them useful tools for their travel needs. Earn on commission for each booking.
 * Version:           1.0.15
 * Author:            travelpayouts
 * Author URI:        http://www.travelpayouts.com/?locale=en
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       travelpayouts
 * Domain Path:       /languages
 */

require_once ABSPATH .'/wp-admin/includes/plugin.php';

// Import vendor
$autoloadPath = __DIR__ . '/vendor/autoload.php';

if (!file_exists($autoloadPath)) {
    deactivate_plugins(plugin_basename(__FILE__));
    wp_die('Main autoloader file is not exist');
}

require 'redux-core/travelpayouts-settings-framework.php';

require_once $autoloadPath;
// If this file is called directly, abort.
if (!defined('WPINC')) {
    die;
}

/**
 * @TODO Желательно вынести методы активации/деактивации в отдельный класс
 * The code that runs during plugin activation.
 * This action is documented in src/includes/class-travelpayouts-activator.php
 */
function activate_travelpayouts()
{
    \Travelpayouts\includes\Activator::activate();
}

/**
 * The code that runs during plugin deactivation.
 * This action is documented in src/includes/class-travelpayouts-deactivator.php
 */
function deactivate_travelpayouts()
{
    \Travelpayouts\includes\Deactivator::deactivate();
}

register_activation_hook(__FILE__, 'activate_travelpayouts');
register_deactivation_hook(__FILE__, 'deactivate_travelpayouts');

/**
 * Begins execution of the plugin.
 * Since everything within the plugin is registered via hooks,
 * then kicking off the plugin from this point in the file does
 * not affect the page life cycle.
 * @since    1.0.0
 */
Travelpayouts::getInstance()->run();
