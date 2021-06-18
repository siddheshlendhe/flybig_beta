<?php
/**
 * Created by: Andrey Polyakov (andrey@polyakov.im)
 */

namespace Travelpayouts\modules\widgets\components\forms\hotels;
use Travelpayouts\Vendor\DI\Annotation\Inject;
use Travelpayouts\components\rest\BaseRestCampaignModule;
use Travelpayouts\components\Subscriptions;

class RestCampaign extends BaseRestCampaignModule
{
    /**
     * @Inject
     * @var \Travelpayouts\modules\searchForms\front\Hotels
     */
    public $tp_search_shortcodes;

    /**
     * @inheritDoc
     */
    protected function campaignId()
    {
        return Subscriptions::HOTELLOOK_ID;
    }
}
