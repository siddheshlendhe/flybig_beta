<?php
/**
 * Created by: Andrey Polyakov (andrey@polyakov.im)
 */

namespace Travelpayouts\modules\tables\components\railway;

use Travelpayouts;
use Travelpayouts\components\HtmlHelper as Html;
use Travelpayouts\components\tables\enrichment as Enrichment;
use Travelpayouts\components\tables\enrichment\UrlHelper;

/**
 * Class RailwayHelper
 * @package Travelpayouts\src\components\tables\enrichment
 * @property-read string $train
 * @property-read string $route
 * @property-read string $departure
 * @property-read string $arrival
 * @property-read string $duration
 * @property-read string $prices
 * @property-read string $dates
 * @property-read string $origin
 * @property-read string $destination
 * @property-read string $departure_time
 * @property-read string $arrival_time
 * @property-read string $route_first_station
 * @property-read string $route_last_station
 * @property-read string $raw_train
 * @property-read string $raw_route
 * @property-read string $raw_departure
 * @property-read string $raw_arrival
 * @property-read string $raw_duration
 * @property-read string $raw_prices
 * @property-read string $raw_dates
 * @property-read string $raw_origin
 * @property-read string $raw_destination
 * @property-read string $raw_departure_time
 * @property-read string $raw_arrival_time
 * @property-read string $raw_route_first_station
 * @property-read string $raw_route_last_station
 */
class ColumnEnricher extends Enrichment\ApiColumnEnricher
{
    public function get_origin()
    {
        return $this->raw_origin;
    }

    public function get_raw_origin()
    {
        $content = $this->get_station_name($this->data['departureStation']);

        if (empty($content)) {
            $content = $this->data['departureStation'];
        }
        return $content;
    }

    public function get_destination()
    {
        return $this->raw_destination;
    }

    public function get_raw_destination()
    {
        $content = $this->get_station_name($this->data['arrivalStation']);

        if (empty($content)) {
            $content = $this->data['arrivalStation'];
        }
        return $content;
    }

    public function get_departure_time()
    {
        return $this->stripSecondsFromTime($this->raw_departure_time);
    }

    public function get_arrival_time()
    {
        return $this->stripSecondsFromTime($this->raw_arrival_time);
    }

    public function get_raw_departure_time()
    {
        return $this->data->get('departureTime', '');
    }

    public function get_raw_arrival_time()
    {
        return $this->data->get('arrivalTime', '');
    }

    public function get_train()
    {
        $trainName = $this->data->get('name', '');

        $html = Html::tag('div', ['class' => 'TP-train-number'], $this->raw_train);
        if (!empty($trainName)) {
            $html .= Html::tag('div', ['class' => 'TP-train-name'], '"' . $trainName . '"');
        }

        return $html;
    }

    public function get_raw_train()
    {
        return $this->data->get('trainNumber', '');
    }

    public function get_duration()
    {
        $content = '';
        $travelTimeKeys = [
            'days',
            'hours',
            'minutes',
        ];

        $travelTimeInSeconds = $this->data->get('travelTimeInSeconds');

        if ($travelTimeInSeconds) {
            $travelTimeToFormat = gmdate('j:G:i', $travelTimeInSeconds);
            $travelTimeData = array_map(static function ($timeValue) {
                return (int)$timeValue;
            }, explode(':', $travelTimeToFormat));

            $travelTimeDataWithKeys = array_combine($travelTimeKeys, $travelTimeData);

            $result = [
                $this->render_duration_item($travelTimeDataWithKeys['hours'], 'ч.', 'TP-train-duration__hours TP-train-duration__item'),
                $this->render_duration_item($travelTimeDataWithKeys['minutes'], 'м.', 'TP-train-duration__minutes TP-train-duration__item'),
            ];

            if ($travelTimeDataWithKeys['days'] > 1) {
                $result = [
                    $this->render_duration_item($travelTimeDataWithKeys['days'] - 1, 'д.', 'TP-train-duration__days TP-train-duration__item'),
                    $this->render_duration_item($travelTimeDataWithKeys['hours'], 'ч.', 'TP-train-duration__hours TP-train-duration__item'),
                ];
            }

            $content = Html::tag('div', ['class' => 'TP-train-duration'], implode(' ', $result));
        }

        return $content;
    }

    public function get_raw_duration()
    {
        return $this->data->get('travelTimeInSeconds');
    }

    protected function render_duration_item($value, $unit, $className = '')
    {
        if (is_int($value) && $value > 0) {
            return Html::tag('div', ['class' => $className], implode('', [
                Html::tag('div', ['class' => 'TP-train-duration-value'], $value),
                Html::tag('div', ['class' => 'TP-train-duration-unit'], $unit),
            ]));
        }
        return '';
    }

    public function get_route()
    {
        $stationIds = array_unique([
            'prefix_dep' => $this->data->get('runDepartureStation'),
            'dep' => $this->data->get('departureStation'),
            'arr' => $this->data->get('arrivalStation'),
            'prefix_arr' => $this->data->get('runArrivalStation'),
        ]);
        // Определяем имеет ли направление неосновные маршруты
        $hasSubroutes = [
            'dep' => isset($stationIds['prefix_dep'], $stationIds['dep']),
            'arr' => isset($stationIds['prefix_arr'], $stationIds['arr']),
        ];


        $stationIdKeys = array_keys($stationIds);
        $stationsCount = count($stationIds);
        $stationNames = array_map(function ($station, $key) use ($stationsCount, $stationIdKeys, $hasSubroutes) {
            // Получаем индекс элемента для корректного вычисления первого и последнего элемента массива
            $index = array_search($key, $stationIdKeys, true);
            // Получаем тип элемента
            $type = strpos($key, 'dep') !== false
                ? 'dep'
                : 'arr';
            // Проверяем наличие неосновных маршрутов
            $hasSubroute = $hasSubroutes[$type];

            $isFirst = $index === 0;
            $isLast = $index + 1 === $stationsCount;

            // Определяем, является ли данная точка неосновным маршрутом
            $isSubroute = $hasSubroute && ($isFirst || $isLast);

            $routeWrapperClass = array_filter([
                'TP-train-route',
                $isFirst
                    ? 'TP-train-route--first'
                    : null,
                $isLast
                    ? 'TP-train-route--last'
                    : null,
                $isSubroute
                    ? 'TP-train-route--secondary'
                    : 'TP-train-route--main',
            ]);

            $stationNameTag = Html::tag('div',
                [
                    'class' => Html::classNames([
                        'TP-train-route__name',
                        !$isSubroute
                            ? 'TP-train-route__name--main'
                            : 'TP-train-route__name--secondary',
                    ]),
                ],
                $this->get_station_name($station));
            // Стрелка маршрута
            $delimiterTag = !$isLast
                ? Html::tag('div', ['class' => 'TP-train-route__delimiter'], '&#8594;')
                : '';

            return Html::tagArrayContent('div', ['class' => Html::classNames($routeWrapperClass)],
                [
                    $stationNameTag,
                    $delimiterTag,
                ]);
        }, $stationIds, $stationIdKeys);

        return Html::tagArrayContent('div', ['class' => 'TP-train-routes'], $stationNames);
    }


    public function get_route_last_station()
    {
        return $this->raw_route_last_station;
    }

    public function get_route_first_station()
    {
        return $this->raw_route_first_station;
    }

    public function get_raw_route_last_station()
    {
        return $this->get_station_name($this->data->get('runArrivalStation'));
    }

    public function get_raw_route_first_station()
    {
        return $this->get_station_name($this->data->get('runDepartureStation'));
    }

    public function get_departure()
    {
        return $this->get_departure_time();
    }

    public function get_arrival()
    {
        return $this->get_arrival_time();
    }

    public function get_raw_departure()
    {
        return $this->raw_departure_time;
    }

    public function get_raw_arrival()
    {
        return $this->raw_arrival_time;
    }

    public function get_prices()
    {
        $categories = $this->data->get('categories', []);
        $currencyRubTag = Html::tagArrayContent('span', ['class' => 'currency_font'], [
            Html::tag('i', ['class' => 'currency_font--rub'], ''),
        ]);

        $prices = array_map(function ($category) use ($currencyRubTag) {
            $type = isset($category['type'])
                ? $category['type']
                : '';
            $typeTranslated = $this->get_wagon_type_name($type);
            $price = isset($category['price'])
                ? $category['price']
                : 0;

            return Html::tagArrayContent('div', ['class' => 'TP-train-price'], [
                Html::tag('div', ['class' => 'TP-train-price__type'], $typeTranslated),
                //                Html::tag('div', ['class' => 'TP-train-price__delimiter'], '~'),
                Html::tagArrayContent('div', ['class' => 'TP-train-price__price'], [
                    number_format($price, 0, '', ' '),
                    $currencyRubTag,
                ]),
            ]);
        }, $categories);
        return Html::tag('div', ['class' => 'TP-train-prices'], implode('', $prices));
    }

    public function get_raw_prices()
    {
        $categories = $this->data->get('categories', []);
        $prices = array_column($categories, 'price');
        return !empty($prices)
            ?
            min($prices)
            : 0;
    }

    /**
     * @return string
     */
    public function get_dates()
    {
        return $this->button;
    }

    public function get_raw_dates()
    {
        return $this->button_url;
    }

    /**
     * @param $code
     * @return string
     */
    protected function get_station_name($code)
    {
        return $this->dictionary_railways->getItem($code)->getName();
    }

    protected function get_wagon_type_name($type)
    {
        switch ($type) {
            case'plazcard':
                return Travelpayouts::_x('Plazcard', 'railway wagon type');
                break;
            case'coupe':
                return Travelpayouts::_x('Coupe', 'railway wagon type');
                break;
            case'sedentary':
                return Travelpayouts::_x('Sedentary', 'railway wagon type');
                break;
            case'lux':
                return Travelpayouts::_x('Lux', 'railway wagon type');
                break;
            case'soft':
                return Travelpayouts::_x('Soft', 'railway wagon type');
                break;
            case'common':
                return Travelpayouts::_x('Common', 'railway wagon type');
                break;
            default:
                return '-';
        }
    }

    /**
     * Получаем содержимое текста кнопки
     * @return string
     */
    protected function get_button_title()
    {
        $defaultButtonTitle = Travelpayouts::__('Tickets');
        $sectionData = $this->get_redux_section_data();
        if ($this->table_data && $buttonTitle = $this->table_data->getButtonTitle()) {
            if (!empty($this->raw_prices)) {
                $priceCellContent = $this->price_cell_content($this->raw_prices);
                return $this->format_message($buttonTitle, ['price' => $priceCellContent]);
            }
            return $sectionData->get('button_title');
        }
        return $defaultButtonTitle;
    }

    protected function get_button_url()
    {
        $customUrlParams = [
            'nnst1' => $this->shortcode_attributes->get('origin'),
            'nnst2' => $this->shortcode_attributes->get('destination'),
        ];

        $params = [
            'shmarker' => !empty($this->account->api_marker)
                ? $this->get_marker()
                : null,
            'promo_id' => UrlHelper::TUTU_PROMO_ID,
            'source_type' => 'customlink',
            'type' => 'click',
            'custom_url' => UrlHelper::buildUrl(UrlHelper::TUTU_CUSTOM_URL_HOST, $customUrlParams),
        ];

        return UrlHelper::buildUrl(UrlHelper::TUTU_URL_HOST, $params);
    }

    protected function stripSecondsFromTime($time)
    {
        return preg_replace('/^(\d{2}):(\d{2}):(\d{2})$/', '$1:$2', $time);
    }
}
