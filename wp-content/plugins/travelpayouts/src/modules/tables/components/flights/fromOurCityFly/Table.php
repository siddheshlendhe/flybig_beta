<?php

namespace Travelpayouts\modules\tables\components\flights\fromOurCityFly;
use Travelpayouts\Vendor\DI\Annotation\Inject;
use Travelpayouts\components\tables\TableModel;
use Travelpayouts\modules\tables\components\flights\BaseShortcodeModel;


class Table extends BaseShortcodeModel
{
    public $origin;
    public $limit;
    public $stops;
    public $period_type;

    public function rules()
    {
        return array_merge(parent::rules(), [
            [['limit', 'origin'], 'required'],
            [['origin'], 'string', 'length' => 3],
            [['limit', 'stops'], 'number'],
            [['period_type'], 'safe'],
        ]);
    }

    /**
     * @Inject
     * @param TableData $tableData
     */
    public function setTableData($tableData)
    {
        $this->tableData = $tableData;
    }

    /**
     * @inheritDoc
     */
    public static function shortcodeTags()
    {
        return ['tp_from_our_city_fly_shortcodes'];
    }
}
