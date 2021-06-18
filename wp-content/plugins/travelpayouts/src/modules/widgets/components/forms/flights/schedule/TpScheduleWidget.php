<?php

namespace Travelpayouts\modules\widgets\components\forms\flights\schedule;

use Travelpayouts;
use Travelpayouts\admin\redux\ReduxFields;
use Travelpayouts\modules\widgets\components\forms\flights\Fields;

class TpScheduleWidget extends Fields
{
    /**
     * @inheritdoc
     */
    public function fields()
    {
        return array_merge(
            [
                ReduxFields::accordion_start(
                    Travelpayouts::__('Flights. Schedule widget'),
                    'tp_schedule_widget'
                ),
                ReduxFields::widget_preview(
                    $this->optionPath,
                    ReduxFields::WIDGET_PREVIEW_TYPE_SCRIPT,
                    '//tp.media/content?promo_id=2811&shmarker=19812&campaign_id=100&target_host=search.jetradar.com&locale=ru&airline=&min_lines={{fields.min_lines}}&border_radius={{fields.border_radius}}&color_background={{fields.color_background}}&color_text={{fields.color_text}}&color_border={{fields.color_border}}&origin=MOW&destination=BKK&powered_by=true',
                    []
                ),
                ReduxFields::text(
                    'subid',
                    Travelpayouts::__('Sub ID'),
                    '',
                    '',
                    ''
                ),
                ReduxFields::simple_text_slider(
                    'min_lines',
                    Travelpayouts::__('Default rows count'),
                    10,
                    1,
                    100
                ),
                ReduxFields::simple_text_slider(
                    'border_radius',
                    Travelpayouts::__('Border radius, px'),
                    0,
                    0,
                    30
                ),
                ReduxFields::color(
                    'color_background',
                    Travelpayouts::__('Background color'),
                    '',
                    '#FFFFFF',
                    false
                ),
                ReduxFields::color(
                    'color_text',
                    Travelpayouts::__('Text color'),
                    '',
                    '#000000',
                    false
                ),
                ReduxFields::color(
                    'color_border',
                    Travelpayouts::__('Border color'),
                    '',
                    '#FFFFFF',
                    false
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
        return 'tp_schedule_widget';
    }
}
