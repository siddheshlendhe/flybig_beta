<?php
/**
 * Created by: Andrey Polyakov (andrey@polyakov.im)
 */

namespace Travelpayouts\components\tables\enrichment;

use Exception;
use Travelpayouts;
use Travelpayouts\admin\redux\ReduxOptions;
use Travelpayouts\components\LanguageHelper;
use Travelpayouts\components\Moment;
use Travelpayouts\components\HtmlHelper as Html;

/**
 * Class ApiColumnEnricher
 *
 * @property-read string $raw_price
 * @property-read string $price
 * @property-read string $button
 * @property-read string $button_title
 * @property-read string $button_url
 */
class ApiColumnEnricher extends BaseApiEnricher
{
    /**
     * @Inject
     * @var Moment
     */
    protected $moment;

    /**
     * Оборачиваем содержимое ячейки в span
     * @param $content
     * @return string
     */
    protected function td_wrapper($content, $options = [])
    {
        return Html::tag('span', $options, $content);
    }

    protected function date_time($date, $format = null)
    {
        $locale = $this->table_data->shortcode_attributes->get('locale');
        if (empty($format)) {
            $format = $this->settings->data->get('date_format_radio', 'd.m.Y');
            // Если выбран формат дат 'custom' берем значение из поля date_format
            if ($format === 'custom') {
                $format = $this->settings->data->get(
                    'date_format',
                    'd.m.Y'
                );
            }
        }

        try {
            if (empty($locale)) {
                $locale = LanguageHelper::tableLocale();
            }
            $locale = LanguageHelper::longMomentLocale($locale);

            return $this->moment->create($date)->formatWithLocale($locale, $format);
        } catch (Exception $e) {
            return '';
        }
    }


    protected function get_currency_sign_class($code)
    {
        return 'currency_font--' . strtolower($code);
    }

    protected function get_currency_sign_pattern()
    {
        $currency_position = $this->settings->currency_symbol_display;
        return ReduxOptions::get_currency_pattern($currency_position);
    }


    public function get_button()
    {
        $settingsModuleData = $this->settings->data;
        $buttonText = $this->get_button_title();

        $href = $this->get_button_url();
        if ($settingsModuleData->get('redirect')) {
            $href = site_url(TRAVELPAYOUTS_TEXT_DOMAIN . '_redirect?' . $href);
        }

        $button_attributes = [
            'href' => $href,
        ];

        if ($this->settings->nofollow) {
            $button_attributes['rel'] = 'nofollow';
        }
        if ($this->settings->target_url) {
            $button_attributes['target'] = '_blank';
        }

        $button_attributes['class'] = TRAVELPAYOUTS_TEXT_DOMAIN . '-table-button';

        $html = Html::tag(
            'a',
            $button_attributes,
            $buttonText
        );

        return $html;
    }


    public function get_price()
    {
        return $this->raw_price && !empty($this->raw_price)
            ? $this->price_cell_content($this->raw_price)
            : '';
    }

    public function get_raw_price()
    {
        return $this->data->get('price', '');
    }

    public function get_raw_button()
    {
        return $this->data->get('price', '');
    }

    protected function get_marker()
    {
        // SubId и з аттрибутов шорткода
        $subId = $this->table_data->shortcode_attributes->get('subid');
        // Если SubId не указан, берем из настроек TODO можно добавить в тесты проверку url
        if ($subId === null) {
            $subId = $this->redux_section_data->get('subid');
        }

        return UrlHelper::get_marker(
            $this->account->api_marker,
            $subId,
            $this->table_data->shortcode_attributes->get('linkMarker')
        );
    }

    /**
     * @return string
     * @TODO оптимизировать код, он в трех модулях плюс/минус одинаковый
     */
    protected function get_button_title()
    {
        return '';
    }

    /**
     * Обрабатывем значения полученные из buttonParams и оборачиваем их ключи скобками
     * @return mixed[]
     * @see buttonParams
     */
    protected function getButtonParams()
    {
        $filteredParams = array_filter($this->buttonParams());
        return array_reduce(array_keys($filteredParams), function ($accumulator, $key) use ($filteredParams) {
            // Добавляем ключ скобками
            $newKey = '{' . $key . '}';
            return array_merge($accumulator, [$newKey => $filteredParams[$key]]);
        }, []);
    }

    /**
     * Список параметров, которые будут отданы функции get_button_title при отрисовке кнопки
     * @see get_button_title
     */
    protected function buttonParams()
    {
        return [];
    }


    protected function get_button_url()
    {
        return '#';
    }

    /**
     * Форматируем цену добавляя нужные стили и знак валюты
     * @param $price
     * @return string
     */
    protected function price_cell_content($price)
    {
        if ($price && (is_string($price) || is_float($price) || is_numeric($price))) {
            $price = $this->format_price($price);
            $currency_code = $this->get_currency_code();

            $currency_sign = Html::tag(
                'span',
                ['class' => 'currency_font'],
                Html::tag(
                    'i',
                    ['class' => $this->get_currency_sign_class($currency_code)],
                    ''
                )
            );
            $pattern = $this->get_currency_sign_pattern();
            return $this->format_message($pattern, [
                'price' => $price,
                'currency_sign' => $currency_sign,
                'currency_code' => $currency_code,
            ]);
        }
        return '';
    }

    /**
     * Форматируем цену с разделением групп
     * @param $price
     * @return string
     */
    protected function format_price($price)
    {
        if ($price && (is_string($price) || is_float($price) || is_numeric($price))) {
            return number_format((float)$price, 0, '.', ' ');
        }
        return '';
    }

    /**
     * Получаем код валюты
     * @return string
     */
    protected function get_currency_code()
    {
        $defaultCurrencyCode = $this->settings->data->get('currency', 'USD');
        $shortcodeCurrencyCode = $this->table_data->shortcode_attributes->get('currency', '');
        return !empty($shortcodeCurrencyCode)
            ? $shortcodeCurrencyCode
            : $defaultCurrencyCode;
    }

    protected function get_distance_unit()
    {
        $distance_unit = $this->settings->distance_units;

        if (($this->lang === 'ru') && $distance_unit === 'km') {
            $distance_unit = 'км';
        }

        return $distance_unit;
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
        return $translator->hasTranslation($translatorKey, $domain, $this->locale)
            ? Travelpayouts::t($translatorKey, [], $domain, $this->locale)
            : $input;
    }

}
