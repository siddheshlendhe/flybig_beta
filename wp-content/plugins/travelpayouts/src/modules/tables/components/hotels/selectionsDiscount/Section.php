<?php

/**
 * Created by: Andrey Polyakov (andrey@polyakov.im)
 */

namespace Travelpayouts\modules\tables\components\hotels\selectionsDiscount;

use Travelpayouts;
use Travelpayouts\admin\redux\ReduxFields;
use Travelpayouts\modules\tables\components\hotels\BaseFields;
use Travelpayouts\modules\tables\components\hotels\ColumnLabels;

class Section extends BaseFields
{
    public function columnsOptions()
    {
        return [
            'enabled' => ColumnLabels::getInstance()->getColumnLabels([
                ColumnLabels::NAME,
                ColumnLabels::STARS,
                ColumnLabels::DISCOUNT,
                ColumnLabels::OLD_PRICE_AND_NEW_PRICE,
                ColumnLabels::BUTTON,
            ]),
            'disabled' => ColumnLabels::getInstance()->getColumnLabels([
                ColumnLabels::PRICE_PN,
                ColumnLabels::OLD_PRICE_AND_DISCOUNT,
                ColumnLabels::DISTANCE,
                ColumnLabels::OLD_PRICE_PN,
                ColumnLabels::RATING,
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
            Travelpayouts::__('Hotel collection - Discounts'),
            null,
            $this->columnsOptions(),
            [
                ReduxFields::checkbox(
                    'assign_dates',
                    Travelpayouts::__('Assign dates'),
                    '',
                    true
                ),
                ReduxFields::text(
                    'subid',
                    Travelpayouts::__('Sub ID'),
                    '',
                    '',
                    'hotelsSelections'
                ),
            ],
            ReduxFields::sortByData($this->data->get('columns.enabled'), ColumnLabels::STARS),
            $this->titlePlaceholder(),
            $this->buttonPlaceholder(),
            Travelpayouts::__('Use {location} variable for city autoset')
        );
    }

    /**
     * @inheritDoc
     */
    public function optionPath()
    {
        return 'tp_hotels_selections_discount_shortcodes';
    }

    /**
     * @inheritDoc
     */
    public function titlePlaceholder($locale = null)
    {
        return Travelpayouts::t('hotel.title.Hotels in {location}: {selection_name}', [], 'tables', $locale);
    }

    /**
     * @inheritDoc
     */
    public function buttonPlaceholder($locale = null)
    {
        return Travelpayouts::t('hotel.button.View Hotel', [], 'tables', $locale);
    }
}
