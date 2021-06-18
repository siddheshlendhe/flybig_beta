<?php

namespace Travelpayouts\modules\tables\components\flights\popularDestinationsAirlines;
use Travelpayouts\Vendor\DI\Annotation\Inject;
use Travelpayouts\modules\tables\components\flights\BaseShortcodeModel;


class Table extends BaseShortcodeModel
{
    public $limit;
    public $airline;

    public function rules()
    {
        return array_merge(parent::rules(), [
            [['limit', 'airline'], 'required'],
            [['airline'], 'string'],
            [['limit'], 'number'],
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
        return ['tp_popular_destinations_airlines_shortcodes'];
    }

}
