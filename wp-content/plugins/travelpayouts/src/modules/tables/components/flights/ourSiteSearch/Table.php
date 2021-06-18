<?php

namespace Travelpayouts\modules\tables\components\flights\ourSiteSearch;
use Travelpayouts\Vendor\DI\Annotation\Inject;
use Travelpayouts\components\tables\TableModel;
use Travelpayouts\modules\tables\components\flights\BaseShortcodeModel;


class Table extends BaseShortcodeModel
{
    public $limit;

    public function rules()
    {
        return array_merge(parent::rules(), [
            [['limit'], 'required'],
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
        return ['tp_our_site_search_shortcodes'];
    }
}
