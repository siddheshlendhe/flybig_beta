<?php

namespace Travelpayouts\modules\tables\components\flights;

/**
 * Trait FlightsFilterFlight
 * @package Travelpayouts\src\modules\tables\components\flights
 */
trait FlightsFilterFlightTrait
{
    protected function filterEnrichedByFlight($data)
    {
        $airline = $this->shortcode_attributes->get('filter_airline');
        $flight_number = $this->shortcode_attributes->get('filter_flight_number');

        $filtered = array_filter($data, static function ($value) use ($airline, $flight_number) {

            //TODO убрать или изменить проверку с $value[0] directFlightsRoute
            if(isset($value[0]['airline']) || isset($value[0]['flight_number'])) {
                $value = array_shift($value);
            }

            if (
                (isset($value['airline']) && $value['airline'] == $airline) ||
                (isset($value['flight_number']) && $value['flight_number'] == $flight_number)
            ) {
                return $value;
            }
        });

        if(empty($filtered)) {
            return $data;
        }

        return $filtered;
    }
}
