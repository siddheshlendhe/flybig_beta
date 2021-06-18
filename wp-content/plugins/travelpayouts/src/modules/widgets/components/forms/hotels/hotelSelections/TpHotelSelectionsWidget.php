<?php

/**
 * Created by: Andrey Polyakov (andrey@polyakov.im)
 */

namespace Travelpayouts\modules\widgets\components\forms\hotels\hotelSelections;

use Travelpayouts;
use Travelpayouts\admin\redux\ReduxFields;
use Travelpayouts\admin\redux\ReduxOptions;
use Travelpayouts\modules\widgets\components\forms\hotels\Fields;

class TpHotelSelectionsWidget extends Fields
{
    /**
     * @inheritdoc
     */
    public function fields()
    {
        return array_merge(
            [
                ReduxFields::accordion_start(
                    Travelpayouts::__('Hotels picks'),
                    Travelpayouts::__('Automatic or manually created collections of hotels within a given city.')
                ),
                ReduxFields::widget_preview(
                    $this->optionPath,
                    ReduxFields::WIDGET_PREVIEW_TYPE_SCRIPT,
                    '//www.travelpayouts.com/blissey/{scripts_locale}.js?categories=5stars%2Csea_view%2Cluxury&id=30553&type={{fields.widget_design}}&currency={currency}&host=search.hotellook.com&marker=132474.&limit={{fields.selection_hotel_count}}&powered_by=true'
                ),
                ReduxFields::widget_design(
                    ReduxOptions::widget_design(),
                    ReduxOptions::WIDGET_DESIGN_FULL
                ),
            ],
            ReduxFields::width_toggle(
                $this->id,
                800,
                ReduxFields::get_ID(
                    $this->optionPath,
                    'scalling_width_toggle'
                )
            ),
            [
                ReduxFields::simple_text_slider(
                    'selection_hotel_count',
                    Travelpayouts::__('Number of hotels in the selection'),
                    4,
                    1,
                    15
                ),
                ReduxFields::poweredBy(),
                ReduxFields::accordion_end(),
            ]
        );
    }

    /**
     * @inheritDoc
     */
    public function optionPath()
    {
        return 'tp_hotel_selections_widget';
    }
}
