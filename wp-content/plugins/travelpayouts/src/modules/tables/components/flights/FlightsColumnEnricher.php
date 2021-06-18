<?php
/**
 * Created by: Andrey Polyakov (andrey@polyakov.im)
 */


namespace Travelpayouts\modules\tables\components\flights;

use Travelpayouts;
use Travelpayouts\admin\redux\ReduxOptions;
use Travelpayouts\components\HtmlHelper as Html;
use Travelpayouts\components\LanguageHelper;
use Travelpayouts\components\tables\enrichment\UrlHelper;
use Travelpayouts\components\tables\enrichment\ApiColumnEnricher;

/**
 * Class FlightsColumnEnricher
 * @property-read string $departure_at
 * @property-read string $number_of_changes
 * @property-read string $button
 * @property-read string $price
 * @property-read string $trip_class
 * @property-read string $distance
 * @property-read string $return_at
 * @property-read string $airline_logo
 * @property-read string $flight_number
 * @property-read string $flight
 * @property-read string $airline
 * @property-read string $destination
 * @property-read string $origin_destination
 * @property-read string $place
 * @property-read string $direction
 * @property-read string $origin
 * @property-read string $found_at
 * @property-read string $price_distance
 * @property-read string $raw_departure_at
 * @property-read string $raw_number_of_changes
 * @property-read string $raw_button
 * @property-read string $raw_price
 * @property-read string $raw_trip_class
 * @property-read string $raw_distance
 * @property-read string $raw_return_at
 * @property-read string $raw_airline_logo
 * @property-read string $raw_flight_number
 * @property-read string $raw_flight
 * @property-read string $raw_airline
 * @property-read string $raw_destination
 * @property-read string $raw_origin_destination
 * @property-read string $raw_place
 * @property-read string $raw_direction
 * @property-read string $raw_origin
 * @property-read string $raw_found_at
 * @property-read string $raw_price_distance
 */
class FlightsColumnEnricher extends ApiColumnEnricher
{
    public function get_airline()
    {
        return $this->raw_airline;
    }

    public function get_raw_airline()
    {
        return $this->get_airline_name($this->data->get('airline'));
    }

    public function get_airline_logo()
    {
        $name = $this->get_airline_name($this->data->get('airline'));

        return Html::tag(
            'img',
            [
                'src' => $this->get_airline_logo_url($this->data->get('airline')),
                'alt' => $name,
                'title' => $name,
            ]
        );
    }

    public function get_distance()
    {
        $postfix = $this->get_distance_unit();
        return $this->raw_distance . ' ' . $postfix;
    }

    public function get_raw_distance()
    {
        return $this->data->get('distance');
    }

    public function get_raw_airline_logo()
    {
        return $this->data->get('airline');
    }

    public function get_number_of_changes()
    {
        $stops = '';
        if ($this->data->has('number_of_changes')) {
            $stops = $this->data->get('number_of_changes');
            return $this->get_stops_name($stops);
        }

        return $stops;
    }

    public function get_raw_number_of_changes()
    {
        return $this->data->get('number_of_changes');
    }


    public function get_flight()
    {
        return $this->raw_flight;
    }

    public function get_raw_flight()
    {
        $flight_variables = [
            'airline_name' => $this->get_airline(),
            'airline_code' => '',
            'flight_number' => '',
        ];
        $flight_text = '{airline_name} ({airline_code} {flight_number})';
        if ($this->data->has('airline')) {
            $flight_variables['airline_code'] = $this->data->get('airline');
        }
        if ($this->data->has('flight_number')) {
            $flight_variables['flight_number'] = $this->data->get('flight_number');
        }

        return str_replace([
            '{airline_name}',
            '{airline_code}',
            '{flight_number}',
        ], $flight_variables, $flight_text);
    }

    public function get_flight_number()
    {
        return $this->raw_flight_number;
    }

    public function get_raw_flight_number()
    {
        return $this->data->get('flight_number');
    }

    const VAR_ORIGIN = '{origin}';
    const VAR_DESTINATION = '{destination}';

    public function get_direction()
    {
        $delimiter = '&#8594;';
        $directions = explode('-', $this->data->get('direction'));

        if (count($directions) <= 1) {
            return $this->data->get('direction');
        } else {
            $origin = $directions[0];
            $destination = $directions[1];
        }

        $origin = $this->get_station_name($origin);
        $destination = $this->get_station_name($destination);

        return str_replace(
            [
                self::VAR_ORIGIN,
                self::VAR_DESTINATION,
            ],
            [
                $origin,
                $destination,
            ],
            self::VAR_ORIGIN . ' ' . $delimiter . ' ' . self::VAR_DESTINATION
        );
    }

    public function get_trip_class()
    {
        return $this->get_trip_class_name($this->raw_trip_class);
    }

    public function get_raw_trip_class()
    {
        return $this->data->get('trip_class');
    }

    public function get_origin_destination()
    {
        return implode(' &#8596; ', [
            $this->get_station_name($this->data->get('origin')),
            $this->get_station_name($this->data->get('destination')),
        ]);
    }

    public function get_raw_origin_destination()
    {
        return json_encode([
            $this->data->get('origin'),
            $this->data->get('destination'),
        ]);
    }

    public function get_price_distance()
    {
        $price = round($this->data->get('price') / $this->data->get('distance'));
        return $this->price_cell_content($price);
    }

    public function get_departure_at()
    {
        return Html::tag(
            'span',
            [
                'class' => 'tp-nowrap'
            ],
            $this->date_time($this->data->get('departure_at'))
        );
    }

    public function get_raw_departure_at()
    {
        return strtotime($this->data->get('departure_at'));
    }

    public function get_return_at()
    {
        return Html::tag(
            'span',
            [
                'class' => 'tp-nowrap'
            ],
            $this->date_time($this->data->get('return_at'))
        );
    }

    public function get_raw_return_at()
    {
        return strtotime($this->data->get('return_at'));
    }

    public function get_found_at()
    {
        return $this->date_time($this->data->get('found_at'));
    }

    public function get_raw_found_at()
    {
        return strtotime($this->data->get('found_at'));
    }


    protected function get_default_host()
    {
        $host_flights = LanguageHelper::optionData(
            $this->settings->data,
            'flights_source',
            $this->locale
        );

        $flights_sources = ReduxOptions::flight_sources();

        return isset($flights_sources[$host_flights])
            ? $flights_sources[$host_flights]
            : null;
    }

    protected function get_button_url()
    {
        $oneWay = $this->shortcode_attributes->get('one_way', false);

        $params = [
            'origin_iata' => $this->get_iata_attribute('origin'),
            'destination_iata' => $this->get_iata_attribute('destination'),
            'currency' => $this->currency_code,
            'locale' => $this->locale,
            'depart_date' => !empty($this->data->get('departure_at'))
                ? $this->date_time($this->data->get('departure_at'), 'Y-m-d')
                : null,
            'return_date' => !empty($this->data->get('return_at'))
                ? $this->date_time($this->data->get('return_at'), 'Y-m-d')
                : null,
            'with_request' => $this->settings->flights_after_url === 'results'
                ? 'true'
                : null,
            'one_way' => true === filter_var(
                $oneWay,
                FILTER_VALIDATE_BOOLEAN
            )
                ? 'true'
                : null,
            'trs' => $this->account->platform
        ];

        $rawHost =
            !empty($this->account->flights_domain)
                ? $this->account->flights_domain
                : $this->get_default_host();

        $mediaParams = [
            'p' => UrlHelper::FLIGHT_P,
            'marker' => !empty($this->account->api_marker)
                ? $this->get_marker()
                : null,
            'u' => UrlHelper::buildUrl($rawHost, $params),
        ];

        return UrlHelper::buildMediaUrl($mediaParams);
    }

    /**
     * Перебираем все возможные источники данных и пытаемся найти нужное значение
     * @param $type [origin|destination]
     * @return mixed|null
     */
    protected function get_iata_attribute($type)
    {
        if (array_key_exists($type, [
            'origin',
            'destination',
        ])) {
            return null;
        }

        $sources = array_filter([
            $this->get_direction_part($type === 'origin'
                ? 0
                : 1),
            $this->data->get($type),
            $this->shortcode_attributes->get($type),
        ]);
        return !empty($sources)
            ? array_shift($sources)
            : null;
    }

    /**
     * Разбираем строчку directions и разделяем на Origin-destination
     * @param $index
     * @return |null
     */
    protected function get_direction_part($index)
    {
        if ($index > 1) return null;

        if (!empty($this->data->get('direction'))) {
            $directions = explode('-', $this->data->get('direction'));

            if (isset($directions[$index])) {
                return $directions[$index];
            }
        }
        return null;
    }

    public function get_origin()
    {
        return $this->raw_origin;
    }

    public function get_raw_origin()
    {
        $content = $this->get_station_name($this->data->get('origin'));

        if (empty($content)) {
            $content = $this->data->get('origin');
        }
        return $content;
    }

    public function get_destination()
    {
        return $this->raw_destination;
    }

    public function get_raw_destination()
    {
        $content = $this->get_station_name($this->data->get('destination'));

        if (empty($content)) {
            $content = $this->data->get('destination');
        }
        return $content;
    }

    public function get_place()
    {
        return $this->raw_place;
    }

    public function get_raw_place()
    {
        return $this->data->get('place');
    }

    protected function get_airline_name($airline)
    {
        $airlineItem = $this->dictionary_airlines->getItem($airline);
        return $airlineItem
            ? $airlineItem->getName()
            : $airline;
    }

    private function get_airline_logo_dimensions()
    {
        $settings_module = $this->settings->data;

        $dimensions = [
            'width' => $settings_module->get('airline_logo_dimensions.width', 100),
            'height' => $settings_module->get('airline_logo_dimensions.height', 35),
        ];
        $unit = $settings_module->get('airline_logo_dimensions.units', 'px');

        return array_map(static function ($value) use ($unit) {
            return str_replace($unit, '', $value);
        }, $dimensions);
    }

    private function get_airline_logo_url($airline)
    {
        $url = 'https://pics.avs.io/{width}/{height}/{airline}@2x.png';

        $dimensions = $this->get_airline_logo_dimensions();

        return str_replace(
            [
                '{width}',
                '{height}',
                '{airline}',
            ],
            [
                $dimensions['width'],
                $dimensions['height'],
                $airline,
            ],
            $url
        );
    }

    protected function get_trip_class_name($trip_class)
    {
        $dictionary = [
            Travelpayouts::t('flights.class_name.Economy', [], 'tables', $this->locale),
            Travelpayouts::t('flights.class_name.Business', [], 'tables', $this->locale),
            Travelpayouts::t('flights.class_name.First class', [], 'tables', $this->locale),
        ];

        return isset($dictionary[$trip_class])
            ? $dictionary[$trip_class]
            : '';
    }

    protected function get_stops_name($stops)
    {
        $dictionary = [
            Travelpayouts::t('flights.stops.Direct', [], 'tables', $this->locale),
            Travelpayouts::t('flights.stops.1 Stop', [], 'tables', $this->locale),
            Travelpayouts::t('flights.stops.2 Stops', [], 'tables', $this->locale),
        ];

        return
            isset($dictionary[$stops])
                ? $dictionary[$stops]
                : $stops;
    }


    /**
     * @param $city
     * @param bool $case
     * @return mixed
     */
    protected function get_station_name($city, $case = false)
    {
        $item = $this->dictionary_cities->getItem($city);
        if ($item) {
            $city_name = $item->getName($case);
            return empty($city_name)
                ? $city
                : $city_name;
        }
        return $city;
    }

    /**
     * Получаем содержимое текста кнопки
     * @return string
     */
    protected function get_button_title()
    {
        $defaultButtonTitle = Travelpayouts::__('Tickets');
        if ($this->table_data && $buttonTitle = $this->table_data->getButtonTitle()) {
            // Ищем значения в словарях, если отсутствует, применяем значение из redux опции
            $dictionaryTitle = $this->findTranslationOrReturnInput($buttonTitle, 'flights.button', 'tables');
            return Travelpayouts::t($dictionaryTitle, $this->getButtonParams(), 'tables');
        }
        return $defaultButtonTitle;
    }

    /**
     * @inheritdoc
     */
    protected function buttonParams()
    {
        return [
            'price' =>
                !empty($this->raw_price)
                    ?
                    $this->price_cell_content($this->raw_price)
                    : null,
        ];
    }
}
