<?php

namespace Travelpayouts\components\tables;

class TableVisibility
{
    CONST DESKTOP = 'desktop';
    CONST NEVER = 'never';
    CONST ALL = 'all';
    const BY_DEFAULT = '';
    CONST NOT_MOBILE = 'not-mobile';
    CONST NOT_TABLE = 'not-table';
    CONST NOT_MOBILE_L = 'not-mobile-l';
    CONST MIN_TABLET_L = 'min-tablet-l';
    CONST MAX_TABLET_L = 'max-tablet-l';

    public static function __callStatic($name, $arguments)
    {
        return self::BY_DEFAULT;
    }

    public static function get_visibility($column_name)
    {
        if (is_string($column_name)) {
            return self::{$column_name}();
        }

        return self::BY_DEFAULT;
    }

    public static function button()
    {
        return self::BY_DEFAULT . ' button-content';
    }

    public static function cut()
    {
        return self::BY_DEFAULT . ' travelpayouts-table-cut control no-sort';
    }
}
