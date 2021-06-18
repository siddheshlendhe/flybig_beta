<?php

/**
 * Created by: Andrey Polyakov (andrey@polyakov.im)
 */

namespace Travelpayouts\modules\tables\components\flights\popularRoutesFromCity;

use Travelpayouts;
use Travelpayouts\admin\redux\ReduxFields;
use Travelpayouts\modules\tables\components\flights\BaseFields;
use Travelpayouts\modules\tables\components\flights\ColumnLabels;

/**
 * Class Section
 * @package Travelpayouts\src\modules\tables\components\flights\popularRoutesFromCity
 */
class Section extends BaseFields
{
    public function columnsOptions()
    {
        return [
            'enabled' => ColumnLabels::getInstance()->getColumnLabels([
                ColumnLabels::DESTINATION,
                ColumnLabels::DEPARTURE_AT,
                ColumnLabels::RETURN_AT,
                ColumnLabels::AIRLINE_LOGO,
                ColumnLabels::BUTTON,
            ]),
            'disabled' => ColumnLabels::getInstance()->getColumnLabels([
                ColumnLabels::FLIGHT_NUMBER,
                ColumnLabels::FLIGHT,
                ColumnLabels::PRICE,
                ColumnLabels::AIRLINE,
                ColumnLabels::ORIGIN_DESTINATION,
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
            Travelpayouts::__('Popular destinations from origin'),
            null,
            $this->columnsOptions(),
            [
                ReduxFields::text(
                    'subid',
                    Travelpayouts::__('Sub ID'),
                    '',
                    '',
                    'fromCity'
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
        return 'tp_popular_routes_from_city_shortcodes';
    }

    /**
     * @inheritDoc
     */
    public function titlePlaceholder($locale = null)
    {
        return Travelpayouts::t('flights.title.Flights from {origin}',[], 'tables', $locale);
    }

    /**
     * @inheritDoc
     */
    public function buttonPlaceholder($locale = null)
    {
        return Travelpayouts::t('flights.button.Tickets from {price}', [], 'tables', $locale);
    }
}
