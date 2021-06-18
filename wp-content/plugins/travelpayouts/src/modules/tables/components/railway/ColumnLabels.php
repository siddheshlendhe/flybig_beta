<?php
/**
 * Created by: Andrey Polyakov (andrey@polyakov.im)
 */

namespace Travelpayouts\modules\tables\components\railway;

use Travelpayouts;
use Travelpayouts\components\tables\BaseColumnLabels;

/***
 * Class ColumnLabels
 * @package Travelpayouts\modules\tables\components
 */
class ColumnLabels extends BaseColumnLabels
{
    const TRAIN = 'train';
    const ROUTE = 'route';
    const DEPARTURE = 'departure';
    const ARRIVAL = 'arrival';
    const DURATION = 'duration';
    const PRICES = 'prices';
    const DATES = 'dates';
    const ORIGIN = 'origin';
    const DESTINATION = 'destination';
    const DEPARTURE_TIME = 'departure_time';
    const ARRIVAL_TIME = 'arrival_time';
    const ROUTE_FIRST_STATION = 'route_first_station';
    const ROUTE_LAST_STATION = 'route_last_station';

    /**
     * @inheritdoc
     */
    public function columnLabels()
    {
        return [
            self::TRAIN => Travelpayouts::__('Train'),
            self::ROUTE => Travelpayouts::__('Route'),
            self::DEPARTURE => Travelpayouts::__('Departure'),
            self::ARRIVAL => Travelpayouts::__('Arrival'),
            self::DURATION => Travelpayouts::__('Duration'),
            self::PRICES => Travelpayouts::__('Prices'),
            // dates в Tutu таблице = action column (кнопка), выбор даты из расписания рейсов
            self::DATES => Travelpayouts::__('Button'),
            self::ORIGIN => Travelpayouts::__('From'),
            self::DESTINATION => Travelpayouts::__('To'),
            self::DEPARTURE_TIME => Travelpayouts::__('Departure time'),
            self::ARRIVAL_TIME => Travelpayouts::__('Arrival time'),
            self::ROUTE_FIRST_STATION => Travelpayouts::__('Route`s first station'),
            self::ROUTE_LAST_STATION => Travelpayouts::__('Route`s last station'),
        ];
    }
}
