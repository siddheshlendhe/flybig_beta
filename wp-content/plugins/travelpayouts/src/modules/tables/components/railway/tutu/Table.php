<?php

namespace Travelpayouts\modules\tables\components\railway\tutu;
use Travelpayouts\Vendor\DI\Annotation\Inject;
use Travelpayouts\modules\tables\components\railway\BaseShortcodeModel;

class Table extends BaseShortcodeModel
{
    public $origin;
    public $destination;
    public $filter_train_number;

    public function init()
    {
        $this->theme = 'default-theme';
    }

    public function rules()
    {
        return array_merge(parent::rules(), [
            [['origin', 'destination'], 'required'],
            [['origin', 'destination'], 'number'],
            [['filter_train_number'], 'string']
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
        return [
            'tp_tutu',
            'tp_tutu_shortcodes',
        ];
    }

    /**
     * @inheritdoc
     */
    public static function isActive()
    {
        return Section::isActive();
    }
}
