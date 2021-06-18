<?php
/**
 * Created by: Andrey Polyakov (andrey@polyakov.im)
 */

namespace Travelpayouts\modules\tables\components\hotels;

use Travelpayouts\modules\tables\components\BaseTableFields;

abstract class BaseFields extends BaseTableFields
{
    public function __construct(Section $parent, $config = [])
    {
        parent::__construct($parent, $config);
    }
}
