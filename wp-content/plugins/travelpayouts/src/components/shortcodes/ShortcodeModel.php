<?php
/**
 * Created by: Andrey Polyakov (andrey@polyakov.im)
 */

namespace Travelpayouts\components\shortcodes;

use Travelpayouts;
use Travelpayouts\components\InjectedModel;
use Travelpayouts\components\Model;

abstract class ShortcodeModel extends InjectedModel implements IShortcodeModel
{
    public $tag;

    /**
     * @see render_shortcode_static()
     */
    public static function register()
    {
        if (static::isActive() && is_array(static::shortcodeTags())) {
            foreach (static::shortcodeTags() as $shortcodeTag) {
				Travelpayouts::getInstance()->hooksLoader->add_shortcode(
                    $shortcodeTag,
                    static::class,
                    'render_shortcode_static'
                );
            }
        }
    }

    abstract public function render();

    public static function isActive()
    {
        return true;
    }
}

