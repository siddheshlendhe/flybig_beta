<?php

/**
 * Created by: Andrey Polyakov (andrey@polyakov.im)
 */

namespace Travelpayouts\modules\widgets\components\forms\hotels\hotel;

use Travelpayouts;
use Travelpayouts\admin\redux\ReduxFields;
use Travelpayouts\modules\widgets\components\forms\hotels\Fields;

class TpHotelWidget extends Fields
{
    /**
     * @inheritdoc
     */
    public function fields()
    {
        return array_merge(
            [
                ReduxFields::accordion_start(
                    Travelpayouts::__('Hotel widget'),
                    Travelpayouts::__('Brief information about a particular hotel with a choice of accommodation dates, search for prices, and go directly to the booking page (bypassing Hotellook).')
                ),
                ReduxFields::widget_preview(
                    $this->optionPath,
                    ReduxFields::WIDGET_PREVIEW_TYPE_SCRIPT,
                    '//www.travelpayouts.com/chansey/iframe.js?hotel_id=361687&locale={locale}&host=search.hotellook.com&marker=132474.&currency={currency}&powered_by=true'
                ),
            ],
            ReduxFields::width_toggle(
                $this->id,
                661,
                ReduxFields::get_ID(
                    $this->optionPath,
                    'scalling_width_toggle'
                )
            ),
            [
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
        return 'tp_hotel_widget';
    }
}
