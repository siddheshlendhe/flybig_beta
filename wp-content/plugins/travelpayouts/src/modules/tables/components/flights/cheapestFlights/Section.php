<?php

/**
 * Created by: Andrey Polyakov (andrey@polyakov.im)
 */

namespace Travelpayouts\modules\tables\components\flights\cheapestFlights;

use Travelpayouts;
use Travelpayouts\admin\redux\ReduxFields;
use Travelpayouts\modules\tables\components\flights\BaseFields;
use Travelpayouts\modules\tables\components\flights\ColumnLabels;

/**
 * Class Section
 * @package Travelpayouts\src\modules\tables\components\flights\cheapestFlights
 * @property-read string $titlePlaceholder
 * @property-read string $buttonPlaceholder
 */
class Section extends BaseFields
{
    public function columnsOptions()
    {
        return [
            'enabled' => ColumnLabels::getInstance()->getColumnLabels([
                ColumnLabels::DEPARTURE_AT,
                ColumnLabels::RETURN_AT,
                ColumnLabels::NUMBER_OF_CHANGES,
                ColumnLabels::AIRLINE_LOGO,
                ColumnLabels::BUTTON,
            ]),
            'disabled' => ColumnLabels::getInstance()->getColumnLabels([
                ColumnLabels::FLIGHT_NUMBER,
                ColumnLabels::FLIGHT,
                ColumnLabels::PRICE,
                ColumnLabels::AIRLINE,
            ]),
        ];
    }

    public function titlePlaceholder($locale = null)
    {
        return Travelpayouts::t('flights.title.The cheapest round-trip tickets from {origin} to {destination}', [], 'tables', $locale);
    }

    public function buttonPlaceholder($locale = null)
    {
        return Travelpayouts::t('flights.button.Tickets from {price}', [], 'tables', $locale);
    }

    /**
     * @inheritdoc
     */
    public function fields()
    {
        return ReduxFields::table_base(
            $this->optionPath,
            Travelpayouts::__('Cheapest flights from origin to destination, round-trip'),
            null,
            $this->columnsOptions(),
            [
                ReduxFields::text(
                    'subid',
                    Travelpayouts::__('Sub ID'),
                    '',
                    '',
                    'direction'
                ),
            ],
            ReduxFields::sortByData($this->data->get('columns.enabled'), ColumnLabels::DEPARTURE_AT),
            $this->titlePlaceholder(),
            $this->buttonPlaceholder()
        );
    }

    /**
     * @inheritdoc
     */
    public function optionPath()
    {
        return 'tp_cheapest_flights_shortcodes';
    }
}
