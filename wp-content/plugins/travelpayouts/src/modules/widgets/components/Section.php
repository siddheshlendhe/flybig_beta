<?php

/**
 * Created by: Andrey Polyakov (andrey@polyakov.im)
 */

namespace Travelpayouts\modules\widgets\components;

use Travelpayouts;
use Travelpayouts\admin\redux\base\ModuleSection;

class Section extends ModuleSection
{
    /**
     * @inheritdoc
     */
    public function section()
    {
        return [
            'title' => Travelpayouts::__('Widgets'),
            'icon' => 'el el-tasks',
        ];
    }

    /**
     * @inheritDoc
     */
    public function optionPath()
    {
        return 'widgets';
    }
}
