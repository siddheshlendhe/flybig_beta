<?php

/**
 * Created by: Andrey Polyakov (andrey@polyakov.im)
 */

namespace Travelpayouts\modules\widgets\components\forms\hotels\hotelMap;

use Travelpayouts;
use Travelpayouts\admin\redux\ReduxFields;
use Travelpayouts\modules\widgets\components\forms\hotels\Fields;

class TpHotelmapWidget extends Fields
{
    /**
     * @inheritdoc
     */
    public function fields()
    {
        return [
            ReduxFields::accordion_start(
                Travelpayouts::__('Hotels Map'),
                Travelpayouts::__('Map showing available hotels in the selected location and their approximate prices.')
            ),
            ReduxFields::widget_preview(
                $this->optionPath,
                ReduxFields::WIDGET_PREVIEW_TYPE_IFRAME,
                '//maps.avs.io/hotels?color={{fields.color_pallete || "#00AFE4"}}&locale={locale}&marker=132474.hotelsmap&changeflag=0&draggable={{toBoolean(fields.allow_dragging)}}&map_styled=false&map_color=#00b1dd&contrast_color=#FFFFFF&disable_zoom={{not(fields.enable_zooming,"1")}}&base_diameter=16&scrollwheel=false&host=hotellook.com&lat=52.5234&lng=13.4114&zoom=12',
                [
                    'width' => '100%',
                    'height' => '300px',
                ]
            ),


            ReduxFields::dimensions(
                'map_dimensions',
                Travelpayouts::__('Map dimensions'),
                500,
                300
            ),
            ReduxFields::color_scheme(
                'color_pallete',
                Travelpayouts::__('Color scheme'),
                Travelpayouts::__('Select last pallet to set custom values'),
                [
                    '#98056A' => [
                        '#98056A',
                    ],
                    '#00AFE4' => [
                        '#00AFE4',
                    ],
                    '#74BA00' => [
                        '#74BA00',
                    ],
                    '#DB5521' => [
                        '#DB5521',
                    ],
                    '#FFBC00' => [
                        '#FFBC00',
                    ],
                    'custom' => [
                        '#A2CCFF',
                    ],
                ],
                '#FFBC00'
            ),
            ReduxFields::color(
                'pins_color',
                Travelpayouts::__('Pin color'),
                null,
                '#A2CCFF',
                [
                    ReduxFields::get_ID($this->optionPath, 'color_pallete'),
                    '=',
                    'custom',
                ]
            ),
            ReduxFields::color(
                'texts_color',
                Travelpayouts::__('Text color'),
                null,
                '#FFFFFF',
                [
                    ReduxFields::get_ID($this->optionPath, 'color_pallete'),
                    '=',
                    'custom',
                ]
            ),
            ReduxFields::checkbox('allow_dragging', Travelpayouts::__('Allow dragging')),
            ReduxFields::checkbox('enable_zooming', Travelpayouts::__('Enable zooming')),
            ReduxFields::simple_text_slider(
                'zoom',
                Travelpayouts::__('Zoom'),
                12,
                1,
                19,
                [
                    ReduxFields::get_ID(
                        'widgets_hotels_' . $this->id,
                        'enable_zooming'
                    ),
                    '=',
                    true
                ]
            ),
            ReduxFields::checkbox(
                'zooming_during_scrolling',
                Travelpayouts::__('Zooming during scrolling')
            ),
            ReduxFields::accordion_end(),
        ];
    }

    /**
     * @inheritDoc
     */
    public function optionPath()
    {
        return 'tp_hotelmap_widget';
    }
}
