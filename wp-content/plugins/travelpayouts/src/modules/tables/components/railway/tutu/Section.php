<?php

namespace Travelpayouts\modules\tables\components\railway\tutu;

use Travelpayouts;
use Travelpayouts\admin\redux\ReduxFields;
use Travelpayouts\modules\tables\components\railway\ColumnLabels;
use Travelpayouts\components\LanguageHelper;

/**
 * Class Section
 * @package Travelpayouts\src\modules\tables\components\railway\tutu
 */
class Section extends Travelpayouts\modules\tables\components\railway\BaseFields
{
    public function columnsOptions()
    {
        return [
            'enabled' => ColumnLabels::getInstance()->getColumnLabels([
                ColumnLabels::TRAIN,
                ColumnLabels::ROUTE,
                ColumnLabels::DEPARTURE,
                ColumnLabels::ARRIVAL,
                ColumnLabels::DURATION,
                ColumnLabels::PRICES,
                ColumnLabels::DATES,
            ]),
            'disabled' => ColumnLabels::getInstance()->getColumnLabels([
                ColumnLabels::ORIGIN,
                ColumnLabels::DESTINATION,
                ColumnLabels::DEPARTURE_TIME,
                ColumnLabels::ARRIVAL_TIME,
                ColumnLabels::ROUTE_FIRST_STATION,
                ColumnLabels::ROUTE_LAST_STATION,
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
            Travelpayouts::__('Train schedule'),
            null,
            $this->columnsOptions(),
            [],
            ReduxFields::sortByData($this->data->get('columns.enabled'), ColumnLabels::ARRIVAL),
            $this->titlePlaceholder(),
            $this->buttonPlaceholder()
        );
    }

    /**
     * @inheritDoc
     */
    public function optionPath()
    {
        return 'tp_tutu_shortcodes';
    }

    /**
     * @inheritDoc
     */
    public function titlePlaceholder($locale = null)
    {
        return Travelpayouts::__('Train schedule {origin} — {destination}');
    }

    /**
     * @inheritDoc
     */
    public function buttonPlaceholder($locale = null)
    {
        return Travelpayouts::__('Select date');
    }
}
