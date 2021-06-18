<?php

namespace Travelpayouts\modules\tables\components\hotels\selectionsDate;
use Travelpayouts\Vendor\DI\Annotation\Inject;
use Travelpayouts\modules\tables\components\hotels\BaseShortcodeModel;

class Table extends BaseShortcodeModel
{
    public $city;
    public $number_results;
    public $type_selections;
    public $check_in;
    public $check_out;

    public function rules()
    {
        return array_merge(parent::rules(), [
            [['city', 'number_results', 'type_selections', 'check_in', 'check_out'], 'required'],
            [['city', 'type_selections'], 'string'],
            [['number_results'], 'number'],
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
        return ['tp_hotels_selections_date_shortcodes'];
    }

    /**
     * @return string
     */
    public function linkMarker()
    {
        return 'tp_hotel_sel_dates';
    }
}
