<?php

namespace Travelpayouts\components\tables;
use Travelpayouts\Vendor\DI\Annotation\Inject;
use Travelpayouts;
use Travelpayouts\admin\redux\ReduxOptions;
use Travelpayouts\components\base\cache\Cache;
use Travelpayouts\components\shortcodes\ShortcodeModel;

/**
 * Class TableModel
 * @package Travelpayouts\src\components\tables
 * @property-write array $shortcode_attributes
 */
abstract class TableModel extends ShortcodeModel implements ITableModel
{
    use TableModelCachedTrait;

    public $shortcodeName;
    public $linkMarker;
    public $currency;
    public $table_wrapper_class = '';
    /**
     * @var TableDataModel
     */
    protected $tableData;

    /**
     * @Inject
     * @var Cache
     */
    protected $cache;

    public function init()
    {
        parent::init();
        $this->currency = $this->get_currency();
    }

    public function rules()
    {
        return [
            [
                [
                    'shortcodeName',
                    'linkMarker',
                    'currency',
                    'locale',
                    'shortcode_attributes',
                    'table_wrapper_class',
                ],
                'safe',
            ],
            [
                ['currency'],
                'string',
                'length' => 3,
            ],
            [
                ['shortcodeName'],
                'required',
            ],
        ];
    }

    protected function get_currency()
    {
        $settingsModule = Travelpayouts::getInstance()->settings;

        return $settingsModule !== null
            ? $settingsModule->section->data->get('currency')
            : ReduxOptions::getDefaultCurrencyCode();
    }

    /**
     * @param $attributes
     */
    public function set_shortcode_attributes($attributes = [])
    {
        if (is_array($attributes)) {
            $this->attributes = $attributes;
            if ($this->tableData) {
                $this->tableData->shortcode_attributes = apply_filters(
                    'travelpayouts_tables_attributes_wp_filter',
                    array_merge($this->attributes, $attributes)
                );
            }
        }
    }

    public function render($runCacheFirst = true)
    {
        $this->cache_table_template = !TRAVELPAYOUTS_DEBUG;
        if ($runCacheFirst && $this->cache_table_template && method_exists($this, 'render_cached')) {
            $this->registerAssets();
            return $this->render_cached();
        }

        if (!$this->validate()) {
            return $this->render_errors();
        }

        if ($this->tableData) {
            $tableData = $this->tableData;
            $tableData->table_wrapper_class = $this->table_wrapper_class;
            if ($tableData->validate()) {
                $table = new TableView($tableData, $this);
                $this->registerAssets();
                return $table->render();
            }
            return $this->render_errors($tableData->getErrors());
        }

        return '';
    }

    protected function registerAssets()
    {
        Travelpayouts::getInstance()->assets->loader->registerAsset('public-tables');
    }

    private function render_errors($errorsList = null)
    {
        if (!$errorsList) {
            $errorsList = $this->getErrors();
        }

        $errors[] = '[' . $this->shortcodeName . ']';
        foreach ($errorsList as $key => $error) {
            $errors[] = implode(' ', $error);
        }

        return implode('<br>', $errors);
    }

    /**
     * Маркер таблицы по умолчанию - имя шорткода
     *
     * @return string
     */
    public function linkMarker()
    {
        return $this->tag;
    }
}
