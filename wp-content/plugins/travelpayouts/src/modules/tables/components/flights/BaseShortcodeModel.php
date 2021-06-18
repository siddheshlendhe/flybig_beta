<?php
/**
 * Created by: Andrey Polyakov (andrey@polyakov.im)
 */

namespace Travelpayouts\modules\tables\components\flights;


use Travelpayouts\modules\tables\components\BaseTableShortcodeModel;

abstract class BaseShortcodeModel extends BaseTableShortcodeModel
{
    public $table_wrapper_class = 'tp-table-flights';
}
