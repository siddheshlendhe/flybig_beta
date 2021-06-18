<?php

/**
 * Created by: Andrey Polyakov (andrey@polyakov.im)
 */

namespace Travelpayouts\modules\widgets\components\forms\flights\map;

use Travelpayouts;
use Travelpayouts\admin\redux\ReduxFields;
use Travelpayouts\modules\widgets\components\forms\flights\Fields;

/**
 * Class TpMapWidget
 * @package Travelpayouts\modules\widgets\components\forms\flights\map
 */
class TpMapWidget extends Fields
{
    /**
     * @inheritdoc
     */
    public function fields()
    {
        return [
            ReduxFields::accordion_start(
                Travelpayouts::__('Flights. Price map'),
                Travelpayouts::__('Interactive map with the flight scheme from a specified or automatically defined city of departure. A click anywhere on the card will redirect the user to map.jetradar.com')
            ),
            ReduxFields::widget_preview(
                $this->optionPath,
                ReduxFields::WIDGET_PREVIEW_TYPE_IFRAME,
                '//maps.avs.io/flights/?auto_fit_map=true&hide_sidebar=true&hide_reformal=true&disable_googlemaps_ui=true&zoom=3&show_filters_icon=true&redirect_on_click=true&small_spinner=true&hide_logo={{not(fields.show_logo, 0)}}&direct={{fields.only_direct_flight || 0}}&lines_type=TpLines&cluster_manager=TpWidgetClusterManager&marker=132474.map&show_tutorial=false&locale={locale}&host=map.aviasales.ru&origin_iata=MOW',
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
            ReduxFields::checkbox(
                'only_direct_flight',
                Travelpayouts::__('Show direct flights only')
            ),
            ReduxFields::checkbox('show_logo', Travelpayouts::__('Show logo')),
            ReduxFields::accordion_end(),
        ];
    }

    /**
     * @inheritDoc
     */
    public function optionPath()
    {
        return 'tp_map_widget';
    }
}
