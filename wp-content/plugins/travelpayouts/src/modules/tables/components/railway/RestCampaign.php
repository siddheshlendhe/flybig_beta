<?php
/**
 * Created by: Andrey Polyakov (andrey@polyakov.im)
 */

namespace Travelpayouts\modules\tables\components\railway;
use Travelpayouts\Vendor\DI\Annotation\Inject;
use Travelpayouts\components\rest\BaseRestCampaignModule;
use Travelpayouts\components\Subscriptions;

class RestCampaign extends BaseRestCampaignModule
{
    /**
     * @Inject
     * @var tutu\Front
     */
    public $tp_tutu_shortcodes;

    /**
     * @inheritDoc
     */
    protected function campaignId()
    {
        return Subscriptions::TP_TUTU_ID;
    }
}
