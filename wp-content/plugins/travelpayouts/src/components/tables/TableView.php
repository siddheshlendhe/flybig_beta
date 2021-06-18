<?php

namespace Travelpayouts\components\tables;

use Exception;
use Travelpayouts\Vendor\Glook\YiiGrid\Data\ArrayDataProvider;
use Travelpayouts\Vendor\Glook\YiiGrid\DataView\GridView;
use Travelpayouts;
use Travelpayouts\components\Component;
use Travelpayouts\components\HtmlHelper;
use Travelpayouts\components\tables\enrichment\BaseTableHelper;
use Travelpayouts\components\tables\enrichment\WithTableData;
use Travelpayouts\helpers\ArrayHelper;

/**
 * Class TableView
 * @package Travelpayouts\src\components\tables
 * @property-read TableDataModel $table_data
 * @property-read ArrayDataProvider $data_provider
 * @property-read string $theme
 * @property-read integer $pagination_size
 * @property-read boolean $show_pagination
 * @property-read array $table_columns
 * @property-read string $table_name
 * @property-read string $table_wrapper_classname
 * @property-read bool $isDebug
 */
class TableView extends Component
{
    use WithTableData;

    protected $_table_helper;
    /**
     * @var TableModel
     */
    private $tableModel;

    public function __construct(TableDataModel $tableData, TableModel $tableModel)
    {
        $this->_table_data_instance = $tableData;
        $this->tableModel = $tableModel;
    }

    /**
     * @return BaseTableHelper
     */
    protected function get_table_helper()
    {
        if (!$this->_table_helper && $this->table_data->table_helper) {
            $this->_table_helper = $this->table_data->table_helper;
        }
        return $this->_table_helper;
    }

    /**
     * @return ArrayDataProvider|null
     * @throws Exception
     */
    protected function get_data_provider()
    {
        if ($this->table_data) {
            $enrichedData = $this->table_data->enriched_data();
            if (!empty($enrichedData)) {
                return new ArrayDataProvider([
                    'allModels' => $enrichedData,
                ]);
            }
        }
        return null;
    }

    /**
     * Получаем id темы
     * @return mixed|string
     */
    protected function get_theme()
    {
        if ($this->redux_module_data) {
            $attributes = array_filter([
                $this->shortcode_attributes->get('theme'),
                $this->redux_module_data->get('theme'),
            ]);
            if (!empty($attributes)) {
                return array_shift($attributes);
            }
        }
        return '';
    }

    protected function get_pagination_size($defaultValue = 10)
    {
        if ($this->redux_section_data) {
            return (int)$this->redux_section_data->get('pagination_size', $defaultValue);
        }
        return $defaultValue;
    }

    /**
     * Получаем параметр "Отображать пагинацию"
     * @param bool $defaultValue
     * @return bool|mixed
     */
    protected function get_show_pagination($defaultValue = true)
    {
        if ($this->table_data->redux_section_data) {
            return filter_var(
                $this->table_data->redux_section_data->get('paginate', $defaultValue),
                FILTER_VALIDATE_BOOLEAN
            );
        }
        return $defaultValue;
    }

    /**
     * Получаем id таблицы
     * @return mixed|null
     */
    protected function get_table_name()
    {
        if ($this->shortcode_attributes && isset($this->shortcode_attributes['table'])) {
            return $this->shortcode_attributes['table'];
        }
        return null;
    }


    /**
     * Получаем заголовок таблицы
     * @return mixed|string
     */
    protected function get_table_title()
    {
        if ($this->redux_section_data) {
            return $this->redux_section_data->get('title', '');
        }
        return '';
    }

    protected function get_table_wrapper_classname()
    {
        return implode(' ', [
            $this->table_data
                ? $this->table_data->table_wrapper_class
                : null,
            $this->theme,
        ]);
    }

    protected function getWrapperClassNames()
    {
        $classNameList = ArrayHelper::filterEmpty([
            $this->table_wrapper_classname,
            ArrayHelper::getBooleanValue($this->shortcode_attributes, 'scroll')
                ? 'tp-table__wrapper--scroll'
                : null,
        ]);
        return implode(' ', $classNameList);
    }

    public function render()
    {
        $this->getWrapperClassNames();
        if ($this->table_data) {
            $tableData = $this->table_data;
            $dataProvider = $this->data_provider;

            $columns = $tableData->get_columns();
            $tableHelper = $this->get_table_helper();

            if (!$tableHelper) {
                return Travelpayouts::__('Can\'t find the table helper component');
            }

            if (!$dataProvider || (empty($columns) || count($columns) < 2)) {
                return $tableHelper->get_error_message();
            }

            $show_pagination = filter_var(
                $this->shortcode_attributes->get('paginate', $this->show_pagination),
                FILTER_VALIDATE_BOOLEAN
            );

            $sort_by = $tableHelper->get_sort_by_field();

            $table = new GridView([
                'tableOptions' => [
                    'class' => 'tp-table',
                    'data-options' => json_encode([
                        'showPagination' => $show_pagination,
                        'pageSize' => $this->pagination_size,
                        'sortBy' => $sort_by,
                        'sortOrder' => 'asc',
                    ]),
                ],
                'emptyText' => $tableHelper->get_error_message(),
                'dataProvider' => $dataProvider,
                'columns' => $this->getTableColumns(),
            ]);

            $table_data = [
                $this->getDebugDataTemplate(),
                $tableHelper->render_title(),
                $table->run(),
            ];
            return $tableHelper->wrapper(implode('', $table_data), $this->getWrapperClassNames());
        }

        return '';
    }

    /**
     * Получаем список колонок с необходимыми данными
     * @return array
     */
    protected function getTableColumns()
    {
        $result = [];
        if ($this->table_data) {
            $tableDataInstance = $this->table_data;
            $columns = $tableDataInstance->get_columns();

            return array_reduce(array_keys($columns), static function ($accumulator, $attribute) use ($tableDataInstance) {
                $label = $tableDataInstance->getColumnLabel($attribute);
                $columnValue = [
                    'label' => $label,
                    'attribute' => $attribute,
                    'headerOptions' => [
                        'class' => TableVisibility::get_visibility($attribute),
                        'data-priority' => -$tableDataInstance->getColumnPriority($attribute),
                    ],
                    'contentOptions' => static function ($model) use ($attribute, $label) {
                        $options = [];
                        $rawAttributeName = $attribute . '_raw';
                        $options['data-label'] = $label;
                        if (isset($model[$rawAttributeName]) && $model[$rawAttributeName] !== null) {
                            $options['data-order'] = $model[$rawAttributeName];
                        }
                        if ($attribute === 'button') {
                            $options['class'] = 'button-content';
                        }

                        return $options;
                    },
                ];
                return array_merge($accumulator, [$columnValue]);
            }, []);
        }
        return $result;
    }

    /**
     * @return bool
     */
    protected function getIsDebug()
    {
        return ArrayHelper::getBooleanValue($this->shortcode_attributes, 'debug');
    }

    /**
     * @return array|null
     */
    protected function getDebugData()
    {
        if ($this->isDebug) {
            return [
                'shortcodeName' => $this->tableModel->tag,
                'shortcodeAttributes' => $this->table_data->shortcode_attributes->all(),
                'tableDataDebugData' => $this->table_data->getDebugData(),
            ];
        }
        return null;
    }

    /**
     * Оборачиваем debug данные в pre и отдаем
     * @return string
     */
    public function getDebugDataTemplate()
    {
        $debugData = $this->getDebugData();
        return $debugData
            ?
            HtmlHelper::tagArrayContent('pre', [], print_r($this->getDebugData(), true))
            : '';
    }
}
