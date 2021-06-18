<?php

/**
 * Created by: Andrey Polyakov (andrey@polyakov.im)
 */

namespace Travelpayouts\modules\widgets\components\forms\flights\ducklett;

use Travelpayouts;
use Travelpayouts\admin\redux\ReduxFields;
use Travelpayouts\admin\redux\ReduxOptions;
use Travelpayouts\modules\widgets\components\forms\flights\Fields;

class TpDucklettWidget extends Fields
{
    const FILTER_TYPE_FOR_AIRCOMPANIES = '0';
    const FILTER_TYPE_FOR_ROUTE = '1';

    /**
     * @inheritdoc
     */
    public function fields()
    {
        return array_merge(
            [
                ReduxFields::accordion_start(
                    Travelpayouts::__('Flights. Special offers'),
                    Travelpayouts::__('Beautiful and convenient visualization of data related to special offers from airlines.')
                ),
                ReduxFields::widget_preview(
                    $this->optionPath,
                    ReduxFields::WIDGET_PREVIEW_TYPE_SCRIPT,
                    '//www.travelpayouts.com/ducklett/{scripts_locale}.js?widget_type={{fields.widget_design}}&currency={currency}&host=hydra.aviasales.ru&marker=132474.&limit={{fields.limit_special_offer || 2}}&powered_by=true'
                ),
                ReduxFields::widget_design(
                    ReduxOptions::widget_type(),
                    ReduxOptions::WIDGET_TYPE_SLIDER
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
                ReduxFields::radio(
                    'filtering',
                    Travelpayouts::__('Filtration'),
                    $this->filterTypes(),
                    self::FILTER_TYPE_FOR_ROUTE,
                    ReduxFields::RADIO_LAYOUT_INLINE
                ),
                ReduxFields::simple_text_slider(
                    'limit_special_offer',
                    Travelpayouts::__('Limit for a special offer'),
                    2,
                    1,
                    9
                ),
                ReduxFields::poweredBy(),
                ReduxFields::accordion_end(),
            ]
        );
    }


    public function filterTypes()
    {
        return [
            self::FILTER_TYPE_FOR_ROUTE => Travelpayouts::__('For route'),
            self::FILTER_TYPE_FOR_AIRCOMPANIES => Travelpayouts::__('For aircompanies'),
        ];
    }

    /**
     * @inheritDoc
     */
    public function optionPath()
    {
        return 'tp_ducklett_widget';
    }
}
