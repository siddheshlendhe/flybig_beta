<?php
/**
 * Created by: Andrey Polyakov (andrey@polyakov.im)
 */

namespace Travelpayouts\modules\links\components\flights;
use Travelpayouts\Vendor\DI\Annotation\Inject;
use Travelpayouts\components\rest\BaseRestCampaignModule;
use Travelpayouts\components\Subscriptions;

class RestCampaign extends BaseRestCampaignModule
{
    /**
     * @Inject
     * @var Flights
     */
    public $tp_link;

    /**
     * @inheritDoc
     */
    protected function campaignId()
    {
        return Subscriptions::AVIASALES_ID;
    }
}
