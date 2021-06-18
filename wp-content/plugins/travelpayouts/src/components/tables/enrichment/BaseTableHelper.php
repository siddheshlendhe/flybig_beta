<?php
/**
 * Created by: Andrey Polyakov (andrey@polyakov.im)
 */

namespace Travelpayouts\components\tables\enrichment;

use Exception;
use Travelpayouts;
use Travelpayouts\admin\redux\ReduxOptions;
use Travelpayouts\components\Component;
use Travelpayouts\components\dictionary as Dictionaries;
use Travelpayouts\components\dictionary\TravelpayoutsApiData;
use Travelpayouts\components\HtmlHelper;
use Travelpayouts\components\LanguageHelper;
use Travelpayouts\components\ShortcodesTagHelper;
use Travelpayouts\components\tables\TableDataModel;
use Travelpayouts\helpers\ArrayHelper;
use Travelpayouts\modules\account\AccountForm;
use Travelpayouts\modules\searchForms\components\SearchFormShortcode;
use Travelpayouts\modules\settings\SettingsForm;

/**
 * Class
 * @package Travelpayouts\src\components\tables\enrichment
 * @property-read SettingsForm $settings_module
 * @property-read AccountForm $account_module
 * @property-read Dictionaries\Airlines $dictionary_airlines
 * @property-read Dictionaries\Cities $dictionary_cities
 * @property-read Dictionaries\Railways $dictionary_railways
 * @property-read string $lang
 * @property-read string $table_title
 */
abstract class BaseTableHelper extends Component
{
    use WithTableData;

    public $table_wrapper_class = 'travel tp-table__wrapper tp-table__wrapper--loading';
    /**
     * @var string
     * Префикс для поиска заголовка таблицы в yaml переводчике
     */
    protected $title_prefix;
    protected $_settings_module;
    protected $_account_module;

    public function __construct($table_data_instance = null)
    {
        $this->_table_data_instance = $table_data_instance;
        $this->init();
    }

    public function init($params = [])
    {
        if (isset($params['table_data_instance'])) {
            $this->_table_data_instance = $params['table_data_instance'];
        }
    }

    public function setTableData(TableDataModel $value)
    {
        $this->_table_data_instance = $value;
    }

    /**
     * @return SettingsForm
     */
    protected function get_settings_module()
    {
        if (!$this->_settings_module) {
            $module = Travelpayouts::getInstance()->settings;
            if ($module !== null) {
                $this->_settings_module = $module->section;
            }
        }
        return $this->_settings_module;
    }

    /**
     * @return AccountForm
     */
    protected function get_account_module()
    {
        if (!$this->_account_module) {
            $module = Travelpayouts::getInstance()->account;
            if ($module !== null) {
                $this->_account_module = $module->section;
            }
        }
        return $this->_account_module;
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
     * @throws Exception
     */
    protected function get_dictionary_cities()
    {
        return Dictionaries\Cities::getInstance(['lang' => $this->lang]);
    }

    /**
     * @return Dictionaries\Railways
     * @throws Exception
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


    protected function get_route_name_case($type)
    {
        if (LanguageHelper::useCaseInTables($this->lang)) {
            $cases = CaseHelper::getDefaultCases();
            return $cases[$type];
        }

        return TravelpayoutsApiData::CASE_NOMINATIVE;
    }


    /**
     * Парсим title, забираем оттуда список аттрибутов и ищем по классу геттеры с нужными именами
     * @return string
     */
    public function get_table_title()
    {
        $title = $this->table_data->getTableTitle();
        /**
         * Пробуем найти соответствующий перевод в yaml словарях
         * если найдено, отдаем перевод строки, в ином случае отдаем как есть
         */
        if ($this->title_prefix) {
            $title = $this->findTranslationOrReturnInput($title, $this->title_prefix, 'tables');
        }
        return $this->format_text_using_properties($title);
    }

    /**
     * Форматируем строку используя данные из геттеров класса
     * @param $text
     * @return string
     */
    protected function format_text_using_properties($text)
    {
        $text = $this->prepareRuTextCase($text);
        $scope = [];

        if (preg_match_all('/{(?<attribute>[\w]+)}/', $text, $titleMatches)) {
            $titleAttributes = $titleMatches['attribute'];
            foreach ($titleAttributes as $attributeName) {
                $scope[$attributeName] = $this->get_title_attribute($attributeName);
            }
        }
        return $this->format_message($text, $scope);
    }

    private function prepareRuTextCase($text)
    {
        // Если локаль попадает под русскоязычную
        if (LanguageHelper::useCaseInTables($this->lang)) {
            $destination = $this->table_data
                ->shortcode_attributes
                ->get(CaseHelper::TYPE_DESTINATION, '');

            /*
             * в заголовке есть в destination будет использован винительный падеж так как он по дефолту
             * проверяем значение винительного падежа, если уже есть "в", например в Мосскву убираем "в"
             */
            $patternCaseVi = '/в\s\{' . CaseHelper::TYPE_DESTINATION . '\}/';
            if (preg_match($patternCaseVi, $text)) {
                $destinationVi = $this->dictionary_cities
                    ->getItem($destination)
                    ->getName(TravelpayoutsApiData::CASE_ACCUSATIVE);

                if (preg_match('/^в\s/', $destinationVi)) {
                    $text = strtr($text, [
                        'в {' . CaseHelper::TYPE_DESTINATION . '}' => '{' . CaseHelper::TYPE_DESTINATION . '}'
                    ]);
                }
            }
        }

        return $text;
    }

    /**
     * @param $title_attribute
     * @return mixed|string
     */
    private function get_title_attribute($title_attribute)
    {
        if (empty($this->$title_attribute)) {
            // Если нет значения из геттеров класса
            switch ($title_attribute) {
                case 'dates':
                    $dates = [
                        $this->check_in,
                        $this->check_out,
                    ];

                    return implode(' - ', $dates);
            }
        }

        return $this->$title_attribute;
    }

    public function render_title()
    {
        $title_tag = $this->table_data->redux_section_data->get('title_tag');
        $hide_title = ArrayHelper::getBooleanValue($this->shortcode_attributes, 'off_title');

        $title = $this->table_title;
        if (empty($title) || empty($title_tag) || $hide_title) {
            return '';
        }

        $attributes = [
            'class' => 'tp-table__title',
        ];
        $disableTitleStyles = (bool)$this->redux_module_data->get('title_inline_css', false);
        $customCssClass = $this->redux_module_data->get('title_custom_class', '');
        if ($disableTitleStyles) {
            if (!empty($customCssClass)) {
                $attributes['class'] = $customCssClass;
            }
        } else {
            $typography = $this->redux_module_data->get('typography');
            if (!empty($typography)) {
                $attributes['style'] = $this->get_inline_styles($typography);
            }
        }

        return HtmlHelper::tag($title_tag, $attributes, $title);
    }

    private function get_inline_styles($typography)
    {
        $inline_style = implode('', array_map(
            static function ($v, $k) {
                if (!empty($v)) {
                    return sprintf('%s:%s!important;', $k, $v);
                }
            },
            $typography,
            array_keys($typography)
        ));

        return $inline_style;
    }

    public function get_responsive()
    {
        return $this->redux_section_data->get('responsive');
    }

    public function get_hyperlink()
    {
        return $this->redux_module_data->get('hyperlink');
    }

    public function get_sort_by_field()
    {
        $sort_by_value = $this->table_data->redux_section_data->get('sort_by', true);
        $sort_by = 1;
        $i = 0;

        $columns = $this->table_data->get_columns();
        foreach ($columns as $key => $column) {
            if ($key === $sort_by_value) {
                $sort_by = $i;
            }
            $i++;
        }
        return $sort_by;
    }


    public function wrapper($table_data, $class = null)
    {
        $settingsModule = $this->get_settings_module();

        $classes = [$this->table_wrapper_class];
        if (!empty($class)) {
            $classes[] = $class;
        }
        if (!empty($this->get_responsive())) {
            $classes[] = 'responsive';
        }
        if (!empty($this->get_hyperlink())) {
            $classes[] = 'hyperlink';
        }

        $attributes = [
            'class' => implode(' ', $classes),
        ];

        $table_onload_script = $settingsModule->data->get('table_load_event');

        if (!empty($table_onload_script)) {
            $attributes['data-onload'] = $table_onload_script;
        }

        return HtmlHelper::tag(
            'div',
            $attributes,
            $table_data
        );
    }


    public function get_error_message()
    {
        switch ($this->redux_module_data->get('message_error_switch')) {
            case ReduxOptions::SHOW_MESSAGE:
                return $this->show_empty_data_message();
            case ReduxOptions::SHOW_SEARCH_FROM:
                return $this->show_search_form();
                break;
            default:
                return '';
        }
    }

    /**
     * @return string
     */
    private function show_empty_data_message()
    {
        $tableMessageError = $this->redux_module_data->get('table_message_error');

        $link_attributes = [
            'text_link' => Travelpayouts::__('Find tickets from {origin} {destination}'),
            'origin' => $this->shortcode_attributes->get('origin'),
            'destination' => $this->shortcode_attributes->get('destination'),
            'type' => '1',
        ];

        if (preg_match('/\[link title="(.*)"\]/i', $tableMessageError, $matches)) {
            $link_attributes['text_link'] = $matches[1];
        }

        if (!empty($link_attributes['origin']) || !empty($link_attributes['destination'])) {

            $tableMessageError = preg_replace(
                '/\[link(.*)\]/',
                ShortcodesTagHelper::selfClosing('tp_link', $link_attributes),
                $tableMessageError
            );
        }


        return do_shortcode($this->format_text_using_properties($tableMessageError));
    }

    private function show_search_form()
    {
        if ($flightsSettings = Travelpayouts::getInstance()->tables->settingsFlights) {
            $search_form_id = $flightsSettings->data->get('empty_flights_table_search_form');
        }

        if (isset($search_form_id) && !empty($search_form_id)) {
            $link_attributes = [
                'id' => $search_form_id,
                'origin' => $this->shortcode_attributes->get('origin'),
                'destination' => $this->shortcode_attributes->get('destination'),
                //'hotel_city' => $this->shortcode_attributes->get('destination'),
                'type' => SearchFormShortcode::TYPE_AVIA,
            ];

            return do_shortcode(
                ShortcodesTagHelper::selfClosing('tp_search_shortcodes', $link_attributes)
            );
        }

        return '';
    }

    /**
     * Ищем в yaml словарях перевод строки, в ином случае возвращаем значение $input
     * @param string $input
     * @param string $domain
     * @param string $prefix
     * @return string
     */
    protected function findTranslationOrReturnInput($input, $prefix, $domain = '')
    {
        $translator = Travelpayouts::getInstance()->translator;
        $translatorKey = $prefix . '.' . $input;
        return $translator->hasTranslation($translatorKey, $domain, $this->lang)
            ? Travelpayouts::t($translatorKey, [], $domain, $this->lang)
            : $input;
    }
}
