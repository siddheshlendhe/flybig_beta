<?php

namespace Travelpayouts\modules\tables\components\flights\cheapestTicketEachDayMonth;
use Travelpayouts\Vendor\DI\Annotation\Inject;
use Travelpayouts\components\tables\TableModel;
use Travelpayouts\modules\tables\components\flights\BaseShortcodeModel;


class Table extends BaseShortcodeModel
{
    public $origin;
    public $destination;

    public function rules()
    {
        return array_merge(parent::rules(), [
            [['origin', 'destination'], 'required'],
            [['origin', 'destination'], 'string', 'length' => 3],
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
        return ['tp_cheapest_ticket_each_day_month_shortcodes'];
    }
}
