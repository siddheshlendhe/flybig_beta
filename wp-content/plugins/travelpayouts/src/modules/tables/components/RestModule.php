<?php
/**
 * Created by: Andrey Polyakov (andrey@polyakov.im)
 */

namespace Travelpayouts\modules\tables\components;

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
            flights\RestCampaign::class,
            hotels\RestCampaign::class,
            railway\RestCampaign::class,
        ];
    }

    /**
     * @return string
     */
    protected function id()
    {
        return 'tables';
    }

    /**
     * @return string
     */
    protected function title()
    {
        return Travelpayouts::__('Tables');
    }

    /**
     * @return array[]
     */
    protected function getExtraData()
    {
        return [
            'modal' => [
                'title' => Travelpayouts::__('Tables'),
            ],
            'select' => [
                'title' => Travelpayouts::__('Select a table'),
            ],
            'program' => [
                'title' => Travelpayouts::__('Select a program'),
            ],
        ];
    }
}
