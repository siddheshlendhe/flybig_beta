<?php

/**
 * Created by: Andrey Polyakov (andrey@polyakov.im)
 */

namespace Travelpayouts\modules\widgets\components\forms\flights\popularRoutes;

use Travelpayouts;
use Travelpayouts\admin\redux\ReduxFields;
use Travelpayouts\modules\widgets\components\forms\flights\Fields;

class TpPopularRoutesWidget extends Fields
{
    /**
     * @inheritdoc
     */
    public function fields()
    {
        return array_merge(
            [
                ReduxFields::accordion_start(
                    Travelpayouts::__('Flights. Top destinations'),
                    Travelpayouts::__('Prices for flights to the destination from the city of departure and other popular destinations.')
                ),
                ReduxFields::widget_preview(
                    $this->optionPath,
                    ReduxFields::WIDGET_PREVIEW_TYPE_SCRIPT,
                    '//www.travelpayouts.com/weedle/widget.js?marker=132474&host=hydra.aviasales.ru&locale={locale}&currency={currency}&powered_by=true&destination=BKK&destination_name=%D0%91%D0%B0%D0%BD%D0%B3%D0%BA%D0%BE%D0%BA'
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
                    'widget_count',
                    Travelpayouts::__('Number of widgets added to an entry'),
                    [
                        '1' => '1',
                        '2' => '2',
                        '3' => '3',
                    ],
                    1,
                    ReduxFields::RADIO_LAYOUT_INLINE
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
        return 'tp_popular_routes_widget';
    }
}
