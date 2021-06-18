<?php

namespace Travelpayouts\components\tables;
use Travelpayouts\Vendor\DI\Annotation\Inject;
use Travelpayouts;
use Travelpayouts\admin\redux\ReduxOptions;
use Travelpayouts\components\BaseInjectedObject;

/**
 * Каждая таблица использует настройки, изменение определенных настроек должно приводить к созданию
 * нового кэша для таблицы настройки которой были изменены
 * Класс отвечает за создание ключа кэша $key и получения времени кэширования $time
 * Class BaseTableCache
 * @package Travelpayouts\components\tables
 */
class BaseTableCache extends BaseInjectedObject
{
    public $key;
    public $time;
    protected $_additionalSettings = [];
    protected $_requiredSettings = [
        'date_format_radio',
        'date_format',
        'distance_units',
        'language',
        'currency',
        'currency_symbol_display',
        'redirect',
        'target_url',
        'nofollow',
        'table_btn_event',
        'table_load_event',
    ];

    /**
     * @Inject
     * @var Travelpayouts\modules\settings\Settings
     */
    public $settings;


    public function init()
    {
        $this->setTime();
    }

    /**
     * Создает кэш ключ для таблицы
     *
     * @param $shortcodeAttributes
     * @param $sectionData
     * @param $tableSettings
     */
    public function setKey($shortcodeAttributes, $sectionData, $tableSettings)
    {
        $key_array = [
            TRAVELPAYOUTS_TEXT_DOMAIN,
            'table',
            md5(
                $this->getGlobalSettings() .
                $shortcodeAttributes .
                $sectionData .
                $tableSettings .
                Travelpayouts::getInstance()->multiLang->cacheKey()
            ),
        ];

        $this->key = implode('_', $key_array);
    }

    /**
     * Получает время кэширования, по дефолту значение из настроек перелетов cache_time_key_flights
     */
    protected function setTime()
    {
        $cacheTime = Travelpayouts::getInstance()->settings->section->data->get(
            ReduxOptions::cache_time_key_flights()
        );

        $this->time = $cacheTime * 60 * 60;
    }

    /**
     * @return array
     */
    protected function cacheDataSources()
    {
        return [
            $this->settings->data->all(),
        ];
    }

    /**
     * Общие настройки
     * всегда участвуют _requiredSettings
     * для отдельных случаев, например если hotels, или flights
     * используются свои ключи настроек _additionalSettings
     * @return false|string
     */
    private function getGlobalSettings()
    {
        $keysToPick = array_merge($this->_requiredSettings, $this->_additionalSettings);
        $data = array_merge(...$this->cacheDataSources());
        $params = array_filter($data, static function ($key) use ($keysToPick) {
            return in_array($key, $keysToPick, true);
        }, ARRAY_FILTER_USE_KEY);
        return json_encode($params);
    }
}
