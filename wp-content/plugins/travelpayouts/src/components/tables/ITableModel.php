<?php
/**
 * Created by: Andrey Polyakov (andrey@polyakov.im)
 */

namespace Travelpayouts\components\tables;

interface ITableModel
{
    /**
     * Выполняем Inject TableDataModel в TableModel
     * @param TableDataModel $tableData
     * @return void
     */
    public function setTableData($tableData);
}
