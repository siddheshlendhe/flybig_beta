<?php

namespace Travelpayouts\modules\tables\components\flights;

use Travelpayouts\components\tables\BaseTableCache;

class FlightsTableCache extends BaseTableCache
{
    /*
     * Дополнительные настройки которые связаны только с Flights
     */
    protected $_additionalSettings = [
        'flights_source',
        'flights_after_url',
        'airline_logo_dimensions'
    ];
}