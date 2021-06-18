<?php

namespace Travelpayouts\modules\tables\components\hotels\selectionsDiscount;
use Travelpayouts\Vendor\DI\Annotation\Inject;
use Travelpayouts\modules\tables\components\hotels\BaseShortcodeModel;

class Table extends BaseShortcodeModel
{
    public $city;
    public $number_results;
    public $type_selections;

    public function rules()
    {
        return array_merge(parent::rules(), [
            [['city', 'number_results', 'type_selections'], 'required'],
            [['city', 'type_selections', 'check_in', 'check_out'], 'string'],
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
        return ['tp_hotels_selections_discount_shortcodes'];
    }

    /**
     * @return string
     */
    public function linkMarker()
    {
        return 'tp_hotel_sel_disc';
    }
}
