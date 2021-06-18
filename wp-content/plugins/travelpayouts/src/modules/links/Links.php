<?php

namespace Travelpayouts\modules\links;

use Travelpayouts\components\Module;
use Travelpayouts\components\shortcodes\ShortcodeHelper;

class Links extends Module
{
    /**
     * Список классов шорткодов подлежащих регистрации
     * @var string[]
     */
    protected $shortcodeList = [
        Link::class,
    ];

    /**
     * Регистрация шорткодов указанных в shortcodeList
     * @see $shortcodeList
     */
    public function registerShortcodes()
    {
        ShortcodeHelper::registerShortcodeList($this->shortcodeList);
    }
}
