<?php
/**
 * Created by: Andrey Polyakov (andrey@polyakov.im)
 */

namespace Travelpayouts\modules\tables\components\hotels;
use Travelpayouts\Vendor\DI\Annotation\Inject;
use Travelpayouts\components\rest\BaseRestCampaignModule;
use Travelpayouts\components\Subscriptions;

class RestCampaign extends BaseRestCampaignModule
{
    /**
     * @Inject
     * @var selectionsDiscount\Front
     */
    public $tp_hotels_selections_discount_shortcodes;
    /**
     * @Inject
     * @var selectionsDate\Front
     */
    public $tp_hotels_selections_date_shortcodes;

    /**
     * @inheritDoc
     */
    protected function campaignId()
    {
        return Subscriptions::HOTELLOOK_ID;
    }
}
