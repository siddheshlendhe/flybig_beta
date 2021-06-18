<?php

/**
 * Created by: Andrey Polyakov (andrey@polyakov.im)
 */

namespace Travelpayouts\modules\widgets\components\forms\flights\calendar;

use Travelpayouts;
use Travelpayouts\admin\redux\ReduxFields;
use Travelpayouts\admin\redux\ReduxOptions;
use Travelpayouts\modules\widgets\components\forms\flights\Fields;

class TpCalendarWidget extends Fields
{
    /**
     * @inheritdoc
     */
    public function fields()
    {
        return array_merge(
            [
                ReduxFields::accordion_start(
                    Travelpayouts::__('Flights. Low price calendar'),
                    Travelpayouts::__('Minimum prices for flights in the selected direction 
                    on a variety of dates.')
                ),
                ReduxFields::widget_preview(
                    $this->optionPath,
                    ReduxFields::WIDGET_PREVIEW_TYPE_SCRIPT,
                    '//www.travelpayouts.com/calendar_widget/iframe.js?marker=19812.&origin=MOW&destination=BKK&currency={currency}&searchUrl=hydra.aviasales.ru&one_way={{toBoolean(fields.route_control === "one_way_ticket") || false}}&only_direct={{toBoolean(fields.only_direct_flight) || false}}&locale={locale}&period=year&range=7,14&powered_by=true',
                    [
                        'width' => '{{fields.scalling_width.width}}',
                    ]
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
            ReduxFields::flight_directions(),
            [
                ReduxFields::select(
                    'prices',
                    Travelpayouts::__('Prices for the period'),
                    ReduxOptions::price_for_period(),
                    'current_month'
                ),
                ReduxFields::slider(
                    'travel_time',
                    Travelpayouts::__('Trip duration'),
                    [
                        1 => 7,
                        2 => 14,
                    ],
                    0,
                    1,
                    30,
                    'input',
                    2
                ),
                ReduxFields::radio(
                    'route_control',
                    Travelpayouts::__('Route control'),
                    [
                        'one_way_ticket' => Travelpayouts::__('One way ticket'),
                        'round_trip_ticket' => Travelpayouts::__('Round trip ticket'),
                    ],
                    false,
                    ReduxFields::RADIO_LAYOUT_INLINE
                ),
                ReduxFields::checkbox('only_direct_flight', Travelpayouts::__('Only direct flight')),
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
        return 'tp_calendar_widget';
    }
}
