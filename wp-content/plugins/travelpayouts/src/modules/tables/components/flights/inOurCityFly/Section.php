<?php

/**
 * Created by: Andrey Polyakov (andrey@polyakov.im)
 */

namespace Travelpayouts\modules\tables\components\flights\inOurCityFly;

use Travelpayouts;
use Travelpayouts\admin\redux\ReduxFields;
use Travelpayouts\admin\redux\ReduxOptions;
use Travelpayouts\modules\tables\components\flights\BaseFields;
use Travelpayouts\modules\tables\components\flights\ColumnLabels;

/**
 * Class Section
 * @package Travelpayouts\src\modules\tables\components\flights\inOurCityFly
 * @property-read Api $api
 */
class Section extends BaseFields
{
    public function columnsOptions()
    {
        return [
            'enabled' => ColumnLabels::getInstance()->getColumnLabels([
                ColumnLabels::ORIGIN,
                ColumnLabels::DEPARTURE_AT,
                ColumnLabels::RETURN_AT,
                ColumnLabels::BUTTON,
            ]),
            'disabled' => ColumnLabels::getInstance()->getColumnLabels([
                ColumnLabels::DESTINATION,
                ColumnLabels::FOUND_AT,
                ColumnLabels::PRICE,
                ColumnLabels::NUMBER_OF_CHANGES,
                ColumnLabels::TRIP_CLASS,
                ColumnLabels::DISTANCE,
                ColumnLabels::PRICE_DISTANCE,
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
            Travelpayouts::__('Cheap flights to destination'),
            null,
            $this->columnsOptions(),
            [
                ReduxFields::text(
                    'subid',
                    Travelpayouts::__('Sub ID'),
                    '',
                    '',
                    'toCity'
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
        return 'tp_in_our_city_fly_shortcodes';
    }

    /**
     * @inheritDoc
     */
    public function titlePlaceholder($locale = null)
    {
        return Travelpayouts::t('flights.title.Cheap flights to {destination}', [], 'tables', $locale);
    }

    /**
     * @inheritDoc
     */
    public function buttonPlaceholder($locale = null)
    {
        return Travelpayouts::t('flights.button.Tickets from {price}', [], 'tables', $locale);
    }
}
