<?php
/**
 * Created by: Andrey Polyakov (andrey@polyakov.im)
 */

namespace Travelpayouts\components\rest;

use Travelpayouts\components\dictionary\Campaigns;

/**
 * Class BaseRestCampaignModule
 * @package Travelpayouts\components\rest
 * @property-read string|null $name
 */
abstract class BaseRestCampaignModule extends FrontRestModule
{
    /**
     * @inheritdoc
     */
    protected function id()
    {
        return $this->campaignId();
    }

    /**
     * @return int|string
     */
    abstract protected function campaignId();

    /**
     * @inheritdoc
     */
    protected function name()
    {
        return Campaigns::getInstance()->getItem($this->campaignId())->name;
    }

}
