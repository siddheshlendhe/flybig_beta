<?php

/**
 * Created by: Andrey Polyakov (andrey@polyakov.im)
 */

namespace Travelpayouts\modules\tables\components\flights\ourSiteSearch;

use Travelpayouts;
use Travelpayouts\admin\redux\ReduxFields;
use Travelpayouts\admin\redux\ReduxOptions;
use Travelpayouts\modules\tables\components\flights\BaseFields;
use Travelpayouts\modules\tables\components\flights\ColumnLabels;

/**
 * Class Section
 * @package Travelpayouts\src\modules\tables\components\flights\ourSiteSearch
 */
class Section extends BaseFields
{
    public function columnsOptions()
    {
        return [
            'enabled' => ColumnLabels::getInstance()->getColumnLabels([
                ColumnLabels::ORIGIN_DESTINATION,
                ColumnLabels::DEPARTURE_AT,
                ColumnLabels::RETURN_AT,
                ColumnLabels::BUTTON,
            ]),
            'disabled' => ColumnLabels::getInstance()->getColumnLabels([
                ColumnLabels::ORIGIN,
                ColumnLabels::DESTINATION,
                ColumnLabels::FOUND_AT,
                ColumnLabels::PRICE,
                ColumnLabels::NUMBER_OF_CHANGES,
                ColumnLabels::TRIP_CLASS,
                ColumnLabels::DISTANCE,
                ColumnLabels::PRICE_DISTANCE,
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
            Travelpayouts::__('Searched on our website'),
            null,
            $this->columnsOptions(),
            [
                ReduxFields::text(
                    'subid',
                    Travelpayouts::__('Sub ID'),
                    '',
                    '',
                    'onOurWebsite'
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
        return 'tp_our_site_search_shortcodes';
    }

    /**
     * @inheritDoc
     */
    public function titlePlaceholder($locale = null)
    {
        return Travelpayouts::t('flights.title.Flights that have been found on our website', [], 'tables', $locale);
    }

    /**
     * @inheritDoc
     */
    public function buttonPlaceholder($locale = null)
    {
        return Travelpayouts::t('flights.button.Tickets from {price}', [], 'tables', $locale);
    }
}
