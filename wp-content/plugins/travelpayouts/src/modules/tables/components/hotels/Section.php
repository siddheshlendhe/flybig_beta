<?php

/**
 * Created by: Andrey Polyakov (andrey@polyakov.im)
 */

namespace Travelpayouts\modules\tables\components\hotels;

use Travelpayouts;
use Travelpayouts\admin\redux\base\ModuleSection;
use Travelpayouts\components\dictionary\Campaigns;

class Section extends ModuleSection
{
    public function __construct(Travelpayouts\modules\tables\components\Section $parent, $config = [])
    {
        parent::__construct($parent, $config);
    }

    /**
     * @inheritdoc
     */
    public function section()
    {
        $campaign = Campaigns::getInstance()->getItem('101');

        return [
            'title' => $campaign ? $campaign->name : Travelpayouts::__('Hotels'),
            'icon' => 'el el-home',
        ];
    }

    /**
     * @inheritDoc
     */
    public function optionPath()
    {
        return 'hotels';
    }
}
