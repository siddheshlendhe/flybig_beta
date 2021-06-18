<?php

namespace Travelpayouts\components\tables;
use Travelpayouts\Vendor\Adbar\Dot;
use Exception;
use Travelpayouts;
use Travelpayouts\admin\redux\base\SectionFields;
use Travelpayouts\components\ApiModel;
use Travelpayouts\components\LanguageHelper;
use Travelpayouts\components\Model;
use Travelpayouts\components\tables\enrichment\ApiColumnEnricher;
use Travelpayouts\components\tables\enrichment\BaseTableHelper;
use Travelpayouts\helpers\ArrayHelper;
use Travelpayouts\modules\tables\components\BaseTableFields;

/**
 * Class TableDataModel
 * @package Travelpayouts\src\components\tables
 * @property SectionFields|null $redux_module
 * @property BaseTableFields|null $redux_section
 * @property Dot|null $redux_module_data
 * @property Dot|null $redux_section_data
 * @property Dot $shortcode_attributes
 * @property null| SectionFields $redux_module_class
 * @property null| SectionFields $redux_section_class
 * @property string[] $debugData
 * @property-read BaseTableCache|null $cache
 * @property-read string $themeName
 * @property-read string $locale
 */
abstract class TableDataModel extends Model
{
    const MIN_PRIORITY = 1;
    const MAX_PRIORITY = 100;

    /**
     * @var string
     */
    public $table_wrapper_class;

    /**
     * @var ApiColumnEnricher
     */
    protected $columnEnrichment;
    /**
     * @var BaseTableHelper
     */
    protected $tableHelper;
    /**
     * @var SectionFields
     */
    protected $reduxModule;
    /**
     * @var BaseTableCache
     */
    protected $tableCache;
    /**
     * @var ApiModel
     */
    protected $api;
    /**
     * @var SectionFields
     */
    protected $section;

    protected $_shortcode_attributes;
    protected $_columns = [];
    /**
     * data_map используется данными апи например:
     * 'number_of_changes' => 'transfers'
     * ключ апи transfers равен number_of_changes
     * подробное описание в комметариях к методу map_data
     */
    protected $_data_map = [];

    /**
     * @var string[]
     */
    private $_debugData = [];

    /**
     * @return array
     */
    public function rules()
    {
        return [
            [
                [
                    'shortcode_attributes',
                    'table_wrapper_class',
                ],
                'safe',
            ],
        ];
    }

    /**
     * @param $attributes
     */
    public function set_shortcode_attributes($attributes = [])
    {
        if (is_array($attributes)) {
            $this->_shortcode_attributes = new Dot($attributes);

            // Отправляем аттрибуты в api, если присутствует
            if ($this->api) {
                $this->api->attributes = $attributes;
            }
        }
    }

    /**
     * @return Dot
     */
    public function get_shortcode_attributes()
    {
        return $this->_shortcode_attributes;
    }

    /**
     * Возвращает обогащенные данные
     * @return array
     * @throws Exception
     */
    public function enriched_data()
    {
        return $this->enrichment();
    }

    /**
     * Возвращает ответ api
     * @return array|bool
     * @throws Exception
     */
    final protected function get_api_response()
    {
        if ($api = $this->api) {
            $response = $api->sendRequest();
            $this->setDebugData($api->debugData);
            if (empty($response)) {
                $this->add_errors($api->errors);
            }
            return $response;
        }
        return null;
    }

    /**
     * @return SectionFields|null
     */
    public function get_redux_module()
    {
        return $this->reduxModule;
    }

    /**
     * @return SectionFields
     */
    public function get_redux_section()
    {
        return $this->section;
    }

    /**
     * @return Dot|null
     */
    public function get_redux_section_data()
    {
        return $this->redux_section
            ? $this->redux_section->data
            : null;
    }

    /**
     * @return Dot|null
     */
    public function get_redux_module_data()
    {
        return $this->redux_module
            ? $this->redux_module->data
            : null;
    }

    /**
     * Получаем обогощатель колонки для api
     * @return ApiColumnEnricher|null
     */
    public function get_column_enricher()
    {
        return $this->columnEnrichment;
    }


    /**
     * @return BaseTableHelper
     */
    public function get_table_helper()
    {
        $helper = $this->tableHelper;
        $helper->setTableData($this);
        return $helper;
    }

    /**
     * @return BaseTableCache|null
     */
    public function getCache()
    {
        return $this->tableCache;
    }

    /**
     * Обогащает данные api raw_data() или другие данные $api_data
     * @return array
     * @throws Exception
     */
    protected function enrichment()
    {
        if ($this->api) {
            $api = $this->api;
            $api->set_attributes($this->api_attributes(), false);
            return $this->api_data_enrichment($this->get_api_response());
        }

        return [];
    }

    protected function filter_api_data($data)
    {
        if (method_exists($this, 'filterEnrichedByFlight')) {
            $data = $this->filterEnrichedByFlight($data);
        }
        if (method_exists($this, 'filterEnrichedByStops')) {
            $data = $this->filterEnrichedByStops($data);
        }
        if (method_exists($this, 'filterEnrichedByLimit')) {
            $data = $this->filterEnrichedByLimit($data);
        }
        if (method_exists($this, 'filterEnrichedByTrainNumber')) {
            $data = $this->filterEnrichedByTrainNumber($data);
        }
        return $data;
    }

    /**
     * Обогащение ответа api
     * @param $api_data
     * @return array
     */
    protected function api_data_enrichment($api_data)
    {

        $enriched_data = [];
        if (empty($api_data)) {
            return $enriched_data;
        }

        $api_data = $this->filter_api_data($api_data);

        return $this->enrichment_loop($api_data, $enriched_data);
    }

    /**
     * @param $api_data
     * @param $enriched_data
     * @return array
     */
    protected function enrichment_loop($api_data, $enriched_data)
    {
        $columns = $this->get_columns_keys();
        foreach ($api_data as $key => $data) {

            if (!empty($this->_data_map)) {
                $data = $this->map_data($data);
            }

            $enriched_data[] = $this->columns_enrichment($columns, $data);
        }
        return $enriched_data;
    }

    /**
     * Если в рамках ответа от апи значение имеет ключ "value" => 100
     * но из описания ответа api понятно что это цена добавляем значение "price" => 100
     * где $data['price'] получает значение $data['value']
     * @param $data
     * @return mixed
     */
    private function map_data($data)
    {
        foreach ($this->_data_map as $key => $value) {
            $data[$key] = $data[$value];
        }

        return $data;
    }

    /**
     * Обогащение колонки таблицы
     * @param $columns
     * @param $data
     * @return array
     */
    protected function columns_enrichment($columns, $data)
    {
        $columnEnricher = $this->columnEnrichment;
        if ($columnEnricher) {
            $columnEnricher->setTableData($this);
            $columnEnricher->setColumns($columns);
            $columnEnricher->setData($data);
            return $columnEnricher->get_enriched_data();
        }
        return $data;
    }

    /**
     * Отдаем ключи колонок
     * @return array
     */
    public function get_columns_keys()
    {
        return array_keys($this->get_columns());
    }

    /**
     * Отдаем ключи колонок
     * @return array
     */
    public function get_columns()
    {
        if (empty($this->_columns) && $this->redux_section) {
            $sectionData = $this->redux_section->data;
            $enabledColumnsList = $sectionData->get('columns.enabled', []);

            $oneWay = ArrayHelper::getBooleanValue($this->shortcode_attributes, 'one_way');
            if ($oneWay && isset($enabledColumnsList['return_at'])) {
                unset($enabledColumnsList['return_at']);
            }

            $this->_columns = $this->getEnabledColumns($enabledColumnsList, true);
        }
        return $this->_columns;
    }

    /**
     * Фильтруем колонки
     * @param array $columnsList
     * @param bool $cut
     * @return array
     */
    public function getEnabledColumns($columnsList = [], $cut = true)
    {
        if (is_array($columnsList)) {
            if (isset($columnsList['placebo'])) {
                unset($columnsList['placebo']);
            }
            return $columnsList;
        }
        return [];
    }

    /**
     * Назначение атрибутов запроса api
     * @return mixed
     */
    protected function api_attributes()
    {
        return [];
    }

    /**
     * Массив содержащий приоритетность колонок
     * @return array
     */
    protected function columnsPriority()
    {
        return [];
    }

    /**
     * Список колонок для таблиц, используется yaml переводы
     * @param string $locale
     * @return array
     */
    public function columnsLabels($locale = null)
    {
        return [];
    }


    /**
     * @param string $attribute
     * @return mixed|string
     */
    public function getColumnLabel($attribute)
    {
        $labels = $this->columnsLabels($this->locale);
        return array_key_exists($attribute, $labels)
            ? $labels[$attribute]
            : '';
    }

    /**
     * Получаем приоритетность колонки
     * @param string $attribute
     * @return int
     */
    public function getColumnPriority($attribute)
    {
        $priorityList = $this->columnsPriority();
        return array_key_exists($attribute, $priorityList)
            ? $priorityList[$attribute]
            : self::MIN_PRIORITY;
    }

    public function getDebugData()
    {
        return $this->_debugData;
    }

    public function setDebugData($value)
    {
        $this->_debugData = array_merge($this->_debugData, $value);
    }

    /**
     * @param ApiModel $value
     */
    abstract public function setApi($value);

    /**
     * @param SectionFields $value
     */
    abstract public function setSection($value);

    /**
     * Получаем id темы
     * @return mixed|string
     */
    public function getThemeName()
    {
        if ($this->redux_module_data && $this->shortcode_attributes) {
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

    /**
     * Возвращаем текст заголовка таблицы
     * @return string
     */
    public function getTableTitle()
    {
        $titleList = [
            $this->shortcode_attributes->get('title'),
        ];

        if ($this->redux_section) {
            $titleList = array_merge($titleList, [
                $this->redux_section->data->get('title'),
                $this->redux_section->titlePlaceholder($this->locale),
            ]);
        }

        return ArrayHelper::find($titleList, [
            $this,
            'isStringIsNotEmpty',
        ]);
    }

    /**
     * Возвращаем текст кнопки
     * @return string
     */
    public function getButtonTitle()
    {
        // если пользователь установил аттрибут напрямую
        $titleList = [
            $this->shortcode_attributes->get('button_title'),
        ];

        if ($this->redux_section) {
            $titleList = array_merge($titleList, [
                $this->redux_section->data->get('button_title'),
                $this->redux_section->buttonPlaceholder($this->locale),
            ]);
        }

        return ArrayHelper::find($titleList, [
            $this,
            'isStringIsNotEmpty',
        ]);
    }

    public static function isStringIsNotEmpty($value)
    {
        return is_string($value) && $value !== '';

    }

    /**
     * Получаем код локали
     * @return string
     */
    public function getLocale()
    {
        return LanguageHelper::tableLocale(
            $this->shortcode_attributes->get('locale')
        );
    }

    /**
     * Установлен ли параметр locale в аттрибуте шорткода
     * @return bool
     */
    protected function isCustomLocaleSet()
    {
        return $this->shortcode_attributes->has('locale');
    }

    /**
     * Условия, при которых отображается заголовок таблицы
     * @return bool
     */
    protected function isTitleVisible()
    {
        if ($this->isCustomLocaleSet()) {
            return $this->shortcode_attributes->has('title');
        }
        return true;
    }
}
