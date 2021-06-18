<?php
/**
 * Created by: Andrey Polyakov (andrey@polyakov.im)
 */

namespace Travelpayouts\components\tables\enrichment;
use Travelpayouts\Vendor\Adbar\Dot;
use Travelpayouts\Vendor\DI\Annotation\Inject;
use Exception;
use Travelpayouts\components\BaseInjectedObject;
use Travelpayouts\components\dictionary as Dictionaries;
use Travelpayouts\components\LanguageHelper;
use Travelpayouts\components\tables\TableDataModel;
use Travelpayouts\modules\account\AccountForm;
use Travelpayouts\modules\settings\SettingsForm;

/**
 * Class ApiEnricher
 * @property Dot $data
 * @property array $columns
 * @property-read SettingsForm $settings_module
 * @property-read AccountForm $account_module
 * @property-read Dictionaries\Airlines $dictionary_airlines
 * @property-read Dictionaries\Cities $dictionary_cities
 * @property-read Dictionaries\Railways $dictionary_railways
 * @property-read string $lang
 * @property-read null|Dot $shortcode_attributes
 * @property-read string $locale
 */
abstract class BaseApiEnricher extends BaseInjectedObject
{
    use WithTableData;

    protected $_item;
    protected $_columns;
     /**
     * @Inject
     * @var SettingsForm
     */
    protected $settings;

    /**
     * @Inject
     * @var AccountForm
     */
    protected $account;

    public function setTableData(TableDataModel $value)
    {
        $this->_table_data_instance = $value;
    }

    public function setColumns(array $columns)
    {
        $this->columns = $columns;
    }

    public function setData($value)
    {
        $this->data = $value;
    }

    /**
     * @param array $data
     */
    public function set_data($data)
    {
        if (is_array($data)) {
            $this->_item = new Dot($data);
        } else {
            $this->_item = new Dot([]);

        }
    }

    public function get_data()
    {
        return $this->_item;
    }

    /**
     * @return mixed
     */
    public function get_columns()
    {
        return $this->_columns;
    }

    /**
     * @param array $data
     */
    public function set_columns($data)
    {
        if (is_array($data)) {
            $this->_columns = $data;
        }
    }

    /**
     * Создаем колонки с обогащенными данными
     * @return array
     */
    public function get_enriched_data()
    {
        $result = [];
        $columns = $this->columns;
        foreach ($columns as $column) {
            $rawColumnName = 'raw_' . $column;
            $textColumnData = $this->$column;
            $processedColumnData = $this->after_get_column($column, $textColumnData);
            $result[$column] = $processedColumnData;
            $result[$column . '_raw'] = $this->$rawColumnName;
        }
        return $result;
    }

    /**
     * @return bool|mixed|string|void
     */
    protected function get_lang()
    {
        return LanguageHelper::tableLocale(
            $this->table_data->shortcode_attributes->get('locale')
        );
    }

    /**
     * @return Dictionaries\Airlines
     * @throws Exception
     */
    protected function get_dictionary_airlines()
    {
        return Dictionaries\Airlines::getInstance(['lang' => $this->lang]);
    }

    /**
     * @return Dictionaries\Cities
     */
    protected function get_dictionary_cities()
    {
        return Dictionaries\Cities::getInstance(['lang' => $this->lang]);
    }

    /**
     * @return Dictionaries\Railways
     */
    protected function get_dictionary_railways()
    {
        return Dictionaries\Railways::getInstance();
    }

    /**
     * Formats a message using
     * @param string $message
     * @param array $params
     * @return string
     */
    protected function format_message($message, $params)
    {
        $placeholders = [];
        foreach ((array)$params as $name => $value) {
            $placeholders['{' . $name . '}'] = $value;
        }

        return ($placeholders === [])
            ? $message
            : strtr($message, $placeholders);
    }

    /*
     * Действия выполняемые с полученными ячейками после подстановки данных
     * (например обернуть каждую ячейку с помощью td_wrapper
     */
    public function after_get_column($columnName, $value)
    {
        return !empty($value)
            ? $this->td_wrapper($value, ['class' => "tp-table-cell-$columnName"])
            : $value;
    }

    public function getLocale()
    {
        return $this->table_data->locale;
    }
}
