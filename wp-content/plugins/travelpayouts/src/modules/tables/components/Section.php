<?php

/**
 * Created by: Andrey Polyakov (andrey@polyakov.im)
 */

namespace Travelpayouts\modules\tables\components;

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
            'title' => Travelpayouts::__('Tables'),
            'icon' => 'el el-th-list',
        ];
    }

    /**
     * @inheritDoc
     */
    public function optionPath()
    {
        return 'tables';
    }
}
