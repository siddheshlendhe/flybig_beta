<?php

namespace Travelpayouts\modules\tables\components\flights;

use Travelpayouts\admin\redux\ReduxOptions;

/**
 * Trait FlightsFilterStops
 * @package Travelpayouts\src\modules\tables\components\flights
 */
trait FlightsFilterStopsTrait
{
    protected function filterEnrichedByStops($data)
    {
        $stops = $this->shortcode_attributes->get('stops', 0);

        switch ($stops) {
            case ReduxOptions::STOPS_ALL:
                return $data;
            case ReduxOptions::STOPS_DIRECT:
                $stopsNumber = 0;
                break;
            case ReduxOptions::STOPS_ONLY_ONE:
                $stopsNumber = 1;
                break;
            default:
                $stopsNumber = 2;
                break;
        }

        $keyStops = 'number_of_changes';
        if (isset($this->_data_map[$keyStops])) {
            $keyStops = $this->_data_map[$keyStops];
        }

        return array_filter($data, function ($value) use ($stopsNumber, $keyStops) {
            return isset($value[$keyStops]) && $value[$keyStops] <= $stopsNumber;
        });
    }
}
