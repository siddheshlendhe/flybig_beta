<?php
/**
 * Created by: Andrey Polyakov (andrey@polyakov.im)
 */

namespace Travelpayouts\modules\tables\components\flights;

use Travelpayouts;
use Travelpayouts\components\tables\BaseColumnLabels;

/***
 * Class ColumnLabels
 * @package Travelpayouts\modules\tables\components
 */
class ColumnLabels extends BaseColumnLabels
{
    const DEPARTURE_AT = 'departure_at';
    const NUMBER_OF_CHANGES = 'number_of_changes';
    const BUTTON = 'button';
    const PRICE = 'price';
    const TRIP_CLASS = 'trip_class';
    const DISTANCE = 'distance';
    const RETURN_AT = 'return_at';
    const AIRLINE_LOGO = 'airline_logo';
    const FLIGHT_NUMBER = 'flight_number';
    const FLIGHT = 'flight';
    const AIRLINE = 'airline';
    const DESTINATION = 'destination';
    const ORIGIN_DESTINATION = 'origin_destination';
    const PLACE = 'place';
    const DIRECTION = 'direction';
    const ORIGIN = 'origin';
    const FOUND_AT = 'found_at';
    const PRICE_DISTANCE = 'price_distance';

    /**
     * @inheritdoc
     */
    public function columnLabels()
    {
        return [
            self::DEPARTURE_AT => Travelpayouts::__('Departure date'),
            self::NUMBER_OF_CHANGES => Travelpayouts::__('Stops'),
            self::BUTTON => Travelpayouts::__('Button'),
            self::PRICE => Travelpayouts::__('Price'),
            self::TRIP_CLASS => Travelpayouts::__('Flight class'),
            self::DISTANCE => Travelpayouts::__('Distance'),
            self::RETURN_AT => Travelpayouts::__('Return date'),
            self::AIRLINE_LOGO => Travelpayouts::__('Logo airlines'),
            self::FLIGHT_NUMBER => Travelpayouts::__('Flight number'),
            self::FLIGHT => Travelpayouts::__('Flight'),
            self::AIRLINE => Travelpayouts::__('Airlines'),
            self::DESTINATION => Travelpayouts::__('Destination'),
            self::ORIGIN_DESTINATION => Travelpayouts::__('Origin - Destination'),
            self::PLACE => Travelpayouts::__('Rank'),
            self::DIRECTION => Travelpayouts::__('Direction'),
            self::ORIGIN => Travelpayouts::__('Origin'),
            self::FOUND_AT => Travelpayouts::__('When found'),
            self::PRICE_DISTANCE => Travelpayouts::__('Price/distance'),
        ];
    }
}
