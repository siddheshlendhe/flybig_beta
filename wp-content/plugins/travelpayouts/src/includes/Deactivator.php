<?php

namespace Travelpayouts\includes;

use Travelpayouts;
use Travelpayouts\components\snowplow\Tracker;

/**
 * Fired during plugin deactivation
 *
 * @link       http://www.travelpayouts.com/?locale=en
 * @since      1.0.0
 *
 * @package    Travelpayouts
 * @subpackage Travelpayouts/includes
 */

/**
 * Fired during plugin deactivation.
 *
 * This class defines all code necessary to run during the plugin's deactivation.
 *
 * @since      1.0.0
 * @package    Travelpayouts
 * @subpackage Travelpayouts/includes
 * @author     travelpayouts < wpplugin@travelpayouts.com>
 */
class Deactivator {

	/**
	 * Short Description. (use period)
	 *
	 * Long Description.
	 *
	 * @since    1.0.0
	 */
	public static function deactivate()
    {
        Travelpayouts::getInstance()->snowTracker->trackStructEvent(
            Tracker::CATEGORY_INSTALL,
			Tracker::ACTION_UNINSTALLED,
            null,
            null,
            null,
            [
                'marker' => Travelpayouts::getInstance()->account->getMarker()
            ]
        );
	}

}
