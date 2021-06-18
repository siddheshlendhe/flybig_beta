<?php
/**
 * Created by: Andrey Polyakov (andrey@polyakov.im)
 */

namespace Travelpayouts\modules\widgets\components;

use Travelpayouts;
use Travelpayouts\components\rest\BaseRestModule;

class RestModule extends BaseRestModule
{
    /**
     * @return string[]
     */
    protected function campaignList()
    {
        return [
            forms\flights\RestCampaign::class,
            forms\hotels\RestCampaign::class,
        ];
    }

    /**
     * @return string
     */
    protected function id()
    {
        return 'widgets';
    }

    /**
     * @return string
     */
    protected function title()
    {
        return Travelpayouts::__('Widgets');
    }

    /**
     * @return array[]
     */
    protected function getExtraData()
    {
        return [
            'modal' => [
                'title' => Travelpayouts::__('Widgets'),
            ],
            'select' => [
                'title' => Travelpayouts::__('Select the widget'),
            ],
            'program' => [
                'title' => Travelpayouts::__('Select the campaign'),
            ],
        ];
    }
}
