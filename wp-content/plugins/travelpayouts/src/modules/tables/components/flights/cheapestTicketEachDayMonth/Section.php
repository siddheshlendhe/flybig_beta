<?php

/**
 * Created by: Andrey Polyakov (andrey@polyakov.im)
 */

namespace Travelpayouts\modules\tables\components\flights\cheapestTicketEachDayMonth;

use Travelpayouts;
use Travelpayouts\admin\redux\ReduxFields;
use Travelpayouts\admin\redux\ReduxOptions;
use Travelpayouts\modules\tables\components\flights\BaseFields;
use Travelpayouts\modules\tables\components\flights\ColumnLabels;

/**
 * Class Section
 * @package Travelpayouts\src\modules\tables\components\flights\cheapestTicketEachDayMonth
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

    /**
     * @inheritdoc
     */
    public function fields()
    {
        return ReduxFields::table_base(
            $this->optionPath,
            Travelpayouts::__('Cheapest flights from origin to destination (next month)'),
            null,
            $this->columnsOptions(),
            [
                ReduxFields::text(
                    'subid',
                    Travelpayouts::__('Sub ID'),
                    '',
                    '',
                    'directionMonth'
                ),
                ReduxFields::select(
                    'stops',
                    Travelpayouts::__('Number of stops'),
                    ReduxOptions::stops_number(),
                    '0'
                ),
            ],
            ReduxFields::sortByData($this->data->get('columns.enabled'), ColumnLabels::DEPARTURE_AT),
            $this->titlePlaceholder(),
            $this->buttonPlaceholder()
        );
    }

    /**
     * @inheritDoc
     */
    public function optionPath()
    {
        return 'tp_cheapest_ticket_each_day_month_shortcodes';
    }

    /**
     * @inheritDoc
     */
    public function titlePlaceholder($locale = null)
    {
        return Travelpayouts::t('flights.title.The cheapest flights for this month from {origin} to {destination}',[], 'tables', $locale);
    }

    /**
     * @inheritDoc
     */
    public function buttonPlaceholder($locale = null)
    {
        return Travelpayouts::t('flights.button.Tickets from {price}', [], 'tables', $locale);
    }
}
