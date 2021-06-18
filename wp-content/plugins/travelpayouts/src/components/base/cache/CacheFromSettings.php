<?php

namespace Travelpayouts\components\base\cache;

use Travelpayouts\components\DisabledRedux;
use Travelpayouts\admin\redux\ReduxOptions;

class CacheFromSettings
{
    /**
     * @return string
     */
    public static function getCacheClass()
    {
        if (DisabledRedux::getOption(ReduxOptions::getFileCacheOption(true), false)) {
            return FileCache::class;
        }

        return TransientCache::class;
    }
}