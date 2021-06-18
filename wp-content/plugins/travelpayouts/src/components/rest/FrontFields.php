<?php

namespace Travelpayouts\components\rest;

use DateTime;
use Travelpayouts;
use Travelpayouts\admin\redux\ReduxOptions;
use Travelpayouts\components\LanguageHelper;
use Travelpayouts\helpers\ArrayHelper;
use Travelpayouts\modules\searchForms\components\models\SearchForm;
use Travelpayouts\modules\searchForms\components\SearchFormShortcode;

class FrontFields
{
    const TYPE_INPUT = 'input';
    const TYPE_INPUT_TAG = 'input_tag';
    const TYPE_INPUT_AC = 'input-autocomplete';
    const TYPE_INPUT_NUMBER = 'input-number';
    const TYPE_CHECKBOX = 'checkbox';
    const TYPE_RADIO = 'radio';
    const TYPE_RADIO_WITH_FIELDS = 'radio-with-fields';
    const TYPE_SELECTBOX = 'selectbox';
    const TYPE_SELECTBOX_ASYNC = 'selectbox-async';
    const TYPE_DATEPICKER = 'datepicker';
    const TYPE_HR = 'separation-tag';
    const TYPE_TEXT = 'explanation-text';
    const TYPE_INFO = 'info';
    const ENDPOINT_AIRLINES = '//suggest.travelpayouts.com/search?service=internal_airlines&term=${term}&locale=${locale}';
    const ENDPOINT_CITIES = '//autocomplete.travelpayouts.com/places2?term=${term}&locale=${locale}&types[]=city';
    const ENDPOINT_RAILWAY = '//suggest.travelpayouts.com/search?service=tutu&term=${term}&locale=${locale}';
    const ENDPOINT_SELECTION_TYPE = '/wp-admin/admin-ajax.php?action=travelpayouts_routes&page=hotels/getAvailableSelections/${city}';
    const ENDPOINT_HOTEL_CITIES = '//suggest.travelpayouts.com/search?service=internal_blissey_generator_ac&term=${term}&locale=${locale}&type=city';
    const ENDPOINT_HOTELS = '//suggest.travelpayouts.com/search?service=internal_blissey_generator_ac&term=${term}&locale=${locale}&type=hotel';

    const NUMBER_POSTFIX = '.';

    public static function title($required = false)
    {
        return [
            'title' => [
                'type' => self::TYPE_INPUT,
                'label' => Travelpayouts::__('Alternate title'),
                'default' => '',
                'required' => $required,
            ],
        ];
    }

    public static function buttonTitle($placeholder = null)
    {
        if ($placeholder === null) {
            $placeholder = Travelpayouts::__('Should include {price} to display price');
        }

        return [
            'button_title' => [
                'type' => self::TYPE_INPUT,
                'label' => Travelpayouts::__('Alternate button title'),
                'default' => '',
                'required' => false,
                'placeholder' => $placeholder,
            ],
        ];
    }

    public static function selectionLabel()
    {
        return [
            'type_selections_label' => [
                'type' => self::TYPE_INPUT,
                'label' => Travelpayouts::__('Hotel selection custom name'),
                'default' => '',
                'placeholder' => Travelpayouts::__("Optional. Enter a custom name to display in the table's title"),
                'required' => false,
            ],
        ];
    }

    public static function numberPrefix($number)
    {
        return $number . self::NUMBER_POSTFIX . ' ';
    }

    public static function mapWidth($default, $required = false)
    {
        return [
            'width' => [
                'type' => self::TYPE_INPUT_NUMBER,
                'label' => Travelpayouts::__('Map width'),
                'default' => $default,
                'required' => $required,
            ],
        ];
    }

    public static function scalingWidth($default, $required = true)
    {
        return [
            'scaling_width' => [
                'type' => self::TYPE_INPUT_NUMBER,
                'label' => Travelpayouts::__('Scaling width'),
                'default' => $default,
                'required' => $required,
            ],
        ];
    }

    public static function mapHeight($default, $required = false)
    {
        return [
            'height' => [
                'type' => self::TYPE_INPUT_NUMBER,
                'label' => Travelpayouts::__('Map height'),
                'default' => $default,
                'required' => $required,
            ],
        ];
    }

    public static function hideTitle($required = false)
    {
        return [
            'off_title' => [
                'type' => self::TYPE_CHECKBOX,
                'label' => Travelpayouts::__('Hide title'),
                'default' => false,
                'required' => $required,
            ],
        ];
    }

    public static function referralLink($required = false)
    {
        return [
            'referral_link' => [
                'type' => self::TYPE_CHECKBOX,
                'label' => Travelpayouts::__('Add my referral link'),
                'default' => true,
                'required' => $required,
            ],
        ];
    }

    public static function onlyDirectFlight($required = false)
    {
        return [
            'direct' => [
                'type' => self::TYPE_CHECKBOX,
                'label' => Travelpayouts::__('Direct flights only'),
                'default' => false,
                'required' => $required,
            ],
        ];
    }

    public static function oneWay($required = false)
    {
        return [
            'one_way' => [
                'type' => self::TYPE_CHECKBOX,
                'label' => Travelpayouts::__('One way'),
                'default' => false,
                'required' => $required,
            ],
        ];
    }

    public static function radioOneWay($default, $options, $required = false)
    {
        return [
            'one_way' => [
                'type' => self::TYPE_RADIO_WITH_FIELDS,
                'label' => Travelpayouts::__('Type'),
                'default' => $default,
                'options' => $options,
                'required' => $required,
            ],
        ];
    }

    public static function responsive($default, $required = false)
    {
        return [
            'responsive' => [
                'type' => self::TYPE_CHECKBOX,
                'label' => Travelpayouts::__('Responsive'),
                'default' => filter_var($default, FILTER_VALIDATE_BOOLEAN),
                'required' => $required,
            ],
        ];
    }

    public static function linkWithoutDates($required = false)
    {
        return [
            'link_without_dates' => [
                'type' => self::TYPE_CHECKBOX,
                'label' => Travelpayouts::__('Land without dates'),
                'default' => false,
                'required' => $required,
            ],
        ];
    }

    public static function usePagination($default, $required = false)
    {
        return [
            'paginate' => [
                'type' => self::TYPE_CHECKBOX,
                'label' => Travelpayouts::__('Paginate'),
                'default' => filter_var($default, FILTER_VALIDATE_BOOLEAN),
                'required' => $required,
            ],
        ];
    }

    public static function tableLocale()
    {
        $options = array_merge(
            [
                '' => Travelpayouts::t('Use default language'),
            ],
            Travelpayouts::getInstance()->translator->getSupportedLocales()
        );

        return [
            'locale' => [
                'type' => self::TYPE_SELECTBOX,
                'label' => Travelpayouts::__('Table language'),
                'default' => '',
                'options' => $options,
                'required' => false,
            ],
        ];
    }

    public static function origin($required = true)
    {
        return [
            'origin' => [
                'type' => self::TYPE_INPUT_AC,
                'label' => Travelpayouts::__('Origin'),
                'default' => '',
                'required' => $required,
				'allowClear'=>!$required,
				'async' => [
                    'url' => self::prepareEndpoint(self::ENDPOINT_CITIES),
                    'itemProps' => [
                        'value' => '${code}',
                        'label' => '${name}, ${country_name}',
                    ],
                ],
            ],
        ];
    }

    public static function originRailway($required = true)
    {
        return [
            'origin' => [
                'type' => self::TYPE_INPUT_AC,
                'label' => Travelpayouts::__('Train station of origin'),
                'default' => '',
                'required' => $required,
				'allowClear'=>!$required,
                'async'=>[
                    'url' => self::prepareEndpoint(self::ENDPOINT_RAILWAY),
                    'itemProps' => [
                        'value' => '${value}',
                        'label' => '${title} [${value}]',
                    ],
                ]
            ],
        ];
    }

    public static function city($required = true, $id = 'city')
    {
        return [
            $id => [
                'type' => self::TYPE_INPUT_AC,
                'label' => Travelpayouts::__('City'),
                'default' => '',
                'required' => $required,
				'allowClear'=>!$required,
                'async'=>[
                    'url' => self::prepareEndpoint(self::ENDPOINT_HOTEL_CITIES),
                    'itemProps' => [
                        'value' => '${id}',
                        'label' => '${cityName}, ${countryName} (${hotelsCount})',
                    ],
                ]
            ],
        ];
    }

    public static function coordinates($required = true)
    {
        return [
            'coordinates' => [
                'type' => self::TYPE_INPUT_AC,
                'label' => Travelpayouts::__('City'),
                'default' => '',
                'required' => $required,
				'allowClear'=>!$required,
                'async'=>[
                    'url' => self::prepareEndpoint(self::ENDPOINT_HOTEL_CITIES),
                    'itemProps' => [
                        'value' => '${location.lat}, ${location.lon}',
                        'label' => '${cityName}, ${countryName} (${location.lat}, ${location.lon})',
                    ],
                ]
            ],
        ];
    }

    public static function destination($required = true)
    {
        return [
            'destination' => [
                'type' => self::TYPE_INPUT_AC,
                'label' => Travelpayouts::__('Destination'),
                'default' => '',
                'required' => $required,
				'allowClear'=>!$required,
                'async' => [
                    'url' => self::prepareEndpoint(self::ENDPOINT_CITIES),
                    'itemProps' => [
                        'value' => '${code}',
                        'label' => '${name}, ${country_name}',
                    ],
                ],
            ],
        ];
    }

    public static function destinationRailway($required = true)
    {
        return [
            'destination' => [
                'type' => self::TYPE_INPUT_AC,
                'label' => Travelpayouts::__('Train station of destination'),
                'default' => '',
                'required' => $required,
				'allowClear'=>!$required,
                'async' => [
                    'url' => self::prepareEndpoint(self::ENDPOINT_RAILWAY),
                    'itemProps' => [
                        'value' => '${value}',
                        'label' => '${title} [${value}]',
                    ],
                ],
            ],
        ];
    }

    public static function hotel($required = true)
    {
        return [
            'hotel_id' => [
                'type' => self::TYPE_INPUT_AC,
                'label' => Travelpayouts::__('Hotel'),
                'default' => '',
                'required' => $required,
				'allowClear'=>!$required,
                'async' => [
                    'url' => self::prepareEndpoint(self::ENDPOINT_HOTELS),
                    'itemProps' => [
                        'value' => '${id}',
                        'label' => '${fullName}',
                    ],
                ],
            ],
        ];
    }

    public static function searchFormHotel()
    {
        return [
            'hotel_city' => [
                'type' => self::TYPE_INPUT_AC,
                'label' => Travelpayouts::__('City or hotel'),
                'default' => '',
                'required' => false,
				'allowClear'=>true,
                'async' => [
                    'url' => self::prepareEndpoint(self::ENDPOINT_HOTEL_CITIES),
                    'itemProps' => [
                        'value' => '${cityName}, ${countryName}, ${hotelsCount}, ${id}, city, ${countryName}',
                        'label' => '${cityName}, ${countryName}',
                    ],
                ],
            ],
        ];
    }

    public static function additionalMarker($default, $required = false)
    {
        return [
            'subid' => [
                'type' => self::TYPE_INPUT,
                'label' => Travelpayouts::__('Subid'),
                'default' => $default,
                'required' => $required,
            ],
        ];
    }

    public static function currency($required = false)
    {
        $default_currency = Travelpayouts::getInstance()->settings->section->data->get('currency', ReduxOptions::CURRENCY_USD);
        $currencies = ReduxOptions::table_widget_currencies();

        return [
            'currency' => [
                'type' => self::TYPE_SELECTBOX,
                'label' => Travelpayouts::__('Currency'),
                'default' => isset($currencies[$default_currency])
                    ? $currencies[$default_currency]
                    : ReduxOptions::CURRENCY_USD,
                'options' => ReduxOptions::table_widget_currencies(),
                'required' => $required,
            ],
        ];
    }

    public static function selectionsType($required = true)
    {
        return [
            'type_selections' => [
                'type' => self::TYPE_SELECTBOX_ASYNC,
                'label' => Travelpayouts::__('Selection type'),
                'default' => '',
                'placeholder' => Travelpayouts::__('Selection type'),
                'required' => $required,
                'async' => [
                    'url' => self::prepareEndpoint(self::ENDPOINT_SELECTION_TYPE),
                    'optionsPath' => 'data',
                    'itemProps' => [
                        'value' => '${id}',
                        'label' => '${label}',
                    ],
                ],
            ],
        ];
    }

    public static function selectionsTypeWidget($required = true)
    {
        return [
            'cat1' => [
                'type' => self::TYPE_SELECTBOX_ASYNC,
                'label' => Travelpayouts::__('Selection type'),
                'default' => '3stars',
                'placeholder' => Travelpayouts::__('Selection type'),
                'required' => $required,
                'async' => [
                    'url' => self::prepareEndpoint(self::ENDPOINT_SELECTION_TYPE),
                    'optionsPath' => 'data',
                ],
            ],
            'cat2' => [
                'type' => self::TYPE_SELECTBOX_ASYNC,
                'label' => Travelpayouts::__('Selection type'),
                'default' => 'popularity',
                'placeholder' => Travelpayouts::__('Selection type'),
                'required' => $required,
                'async' => [
                    'url' => self::prepareEndpoint(self::ENDPOINT_SELECTION_TYPE),
                    'optionsPath' => 'data',
                ],
            ],
            'cat3' => [
                'type' => self::TYPE_SELECTBOX_ASYNC,
                'label' => Travelpayouts::__('Selection type'),
                'default' => 'distance',
                'placeholder' => Travelpayouts::__('Selection type'),
                'required' => $required,
                'async' => [
                    'url' => self::prepareEndpoint(self::ENDPOINT_SELECTION_TYPE),
                    'optionsPath' => 'data',
                ],
            ],
        ];
    }

    public static function stopsNumber($default = '0')
    {
        return [
            'stops' => [
                'type' => self::TYPE_SELECTBOX,
                'label' => Travelpayouts::__('Number of stops'),
                'default' => $default,
                'options' => ReduxOptions::stops_number(),
                'required' => false
            ]
        ];
    }

    public static function period($default, $required = true)
    {
        return [
            'period' => [
                'type' => self::TYPE_SELECTBOX,
                'label' => Travelpayouts::__('Calendar period'),
                'default' => $default,
                'options' => ReduxOptions::price_for_period(),
                'required' => $required,
            ],
            'period_day_from' => [
                'type' => self::TYPE_INPUT_NUMBER,
                'label' => Travelpayouts::__('Trip duration from'),
                'default' => 7,
                'required' => false,
                'minimum' => 1,
                'maximum' => 30,
            ],
            'period_day_to' => [
                'type' => self::TYPE_INPUT_NUMBER,
                'label' => Travelpayouts::__('Trip duration to'),
                'default' => 14,
                'required' => false,
                'minimum' => 1,
                'maximum' => 30,
            ],
        ];
    }

    public static function radioFiltering($default, $options, $required = false)
    {
        return [
            'filter' => [
                'type' => self::TYPE_RADIO_WITH_FIELDS,
                'label' => Travelpayouts::__('Filtration'),
                'default' => $default,
                'options' => $options,
                'required' => $required,
            ],
        ];
    }

    public static function widgetType($default, $required = false)
    {
        return [
            'type' => [
                'type' => self::TYPE_SELECTBOX,
                'label' => Travelpayouts::__('Widget type'),
                'default' => $default,
                'options' => ReduxOptions::widget_type(),
                'required' => $required,
            ],
        ];
    }

    public static function widgetDesign($default, $required = false)
    {
        return [
            'type' => [
                'type' => self::TYPE_SELECTBOX,
                'label' => Travelpayouts::__('Widget design'),
                'default' => $default,
                'options' => ReduxOptions::widget_design(),
                'required' => $required,
            ],
        ];
    }

    public static function limit($default, $required = false, $min = 1, $max = 999)
    {
        return [
            'limit' => [
                'type' => self::TYPE_INPUT_NUMBER,
                'label' => Travelpayouts::__('Limit'),
                'default' => $default,
                'required' => $required,
                'minimum' => $min,
                'maximum' => $max,
            ],
        ];
    }

    /**
     * @param $default
     * @param bool $required
     * @return array[]
     * @deprecated
     */
    public static function widgetCount($default, $required = true)
    {
        return [
            'widget_count' => [
                'type' => self::TYPE_INPUT_NUMBER,
                'label' => Travelpayouts::__('Count'),
                'default' => $default,
                'required' => $required,
                'minimum' => 1,
                'maximum' => 3,
            ],
            'destinations' => [
                'type' => self::TYPE_INPUT_AC,
                'label' => Travelpayouts::__('Destinations'),
                'default' => '',
                'required' => $required,
				'allowClear'=>!$required,
                'async' => [
                    'url' => self::prepareEndpoint(self::ENDPOINT_CITIES),
                    'itemProps' => [
                        'value' => '${code}',
                        'label' => '${name}, ${country_name}',
                    ],
                ],
            ],
        ];
    }

    public static function numberResults($required = true)
    {
        return [
            'number_results' => [
                'type' => self::TYPE_INPUT_NUMBER,
                'label' => Travelpayouts::__('Number of results'),
                'default' => 20,
                'required' => $required,
                'minimum' => 1,
                'maximum' => 999,
            ],
        ];
    }

    public static function zoom()
    {
        return [
            'zoom' => [
                'type' => self::TYPE_INPUT_NUMBER,
                'label' => Travelpayouts::__('Zoom'),
                'default' => 12,
                'required' => false,
                'minimum' => 1,
                'maximum' => 19,
            ],
        ];
    }

    public static function enableDragging($default, $required = false)
    {
        return [
            'draggable' => [
                'type' => self::TYPE_CHECKBOX,
                'label' => Travelpayouts::__('Allow dragging'),
                'default' => $default,
                'required' => $required,
            ],
        ];
    }

    public static function disableZoom($default, $required = false)
    {
        return [
            'disable_zoom' => [
                'type' => self::TYPE_CHECKBOX,
                'label' => Travelpayouts::__('Disable zooming'),
                'default' => $default,
                'required' => $required,
            ],
        ];
    }

    public static function periodFrom($default, $required = false)
    {
        return [
            'period_from' => [
                'type' => self::TYPE_INPUT_NUMBER,
                'label' => Travelpayouts::__('From'),
                'default' => $default,
                'required' => $required,
                'minimum' => 1,
                'maximum' => 7,
            ],
        ];
    }

    public static function periodTo($default, $required = false)
    {
        return [
            'period_to' => [
                'type' => self::TYPE_INPUT_NUMBER,
                'label' => Travelpayouts::__('To'),
                'default' => $default,
                'required' => $required,
                'minimum' => 1,
                'maximum' => 14,
            ],
        ];
    }

    public static function filterByAirline($required = true, $id = 'filter_airline')
    {
        return [
            $id => [
                'type' => self::TYPE_INPUT_AC,
                'label' => Travelpayouts::__('Filter by airline'),
                'default' => '',
                'required' => $required,
				'allowClear'=>!$required,
                'async' => [
                    'url' => self::prepareEndpoint(self::ENDPOINT_AIRLINES),
                    'itemProps' => [
                        'value' => '${slug}',
                        'label' => '${title} [${slug}]',
                    ],
                ],
            ],
        ];
    }

    public static function filterByFlightNumber($required = false)
    {
        return [
            'filter_flight_number' => [
                'type' => self::TYPE_INPUT_TAG,
                'label' => Travelpayouts::__('Filter by flight # (enter manually)'),
                'default' => '',
                'required' => $required,
            ],
        ];
    }

    public static function filterByTrain($required = false)
    {
        return [
            'filter_train_number' => [
                'type' => self::TYPE_INPUT_TAG,
                'label' => Travelpayouts::__('Filter by train number or name (enter manually)'),
                'default' => '',
                'placeholder' => Travelpayouts::__('Enter train numbers or names separated by commas'),
                'required' => $required,
                'delimiter' => ',',
            ],
        ];
    }

    public static function checkIn($required = false)
    {
        return [
            'check_in' => [
                'type' => self::TYPE_DATEPICKER,
                'label' => Travelpayouts::__('Check-in date'),
                'default' => self::getDate('d-m-Y', '+7 DAY'),
                'required' => $required,
                'minDate' => self::getDate('d-m-Y'),
                'maxDate' => self::getDate('d-m-Y', '+1 YEAR'),
            ],
        ];
    }

    /**
     * @param string $id
     * @param false $required
     * @return array[]
     * @TODO Возможно стоит изменить id на другое значение
     */
    public static function checkInLink($id = 'check_in', $required = false)
    {
        return [
            $id => [
                'type' => self::TYPE_INPUT_NUMBER,
                'label' => Travelpayouts::__('Check-in: today +'),
                'default' => 1,
                'required' => $required,
                'minimum' => 0,
                'maximum' => 30,
            ],
        ];
    }

    public static function departureLink()
    {
        return [
            'origin_date' => [
                'type' => self::TYPE_INPUT_NUMBER,
                'label' => Travelpayouts::__('Departure: today +'),
                'default' => 1,
                'required' => false,
                'minimum' => 0,
                'maximum' => 30,
            ],
        ];
    }

    public static function checkOut($required = false)
    {
        return [
            'check_out' => [
                'type' => self::TYPE_DATEPICKER,
                'label' => Travelpayouts::__('Check-out date'),
                'default' => self::getDate('d-m-Y', '+10 DAY'),
                'required' => $required,
                'minDate' => self::getDate('d-m-Y'),
                'maxDate' => self::getDate('d-m-Y', '+1 YEAR'),
            ],
        ];
    }

    public static function checkOutLink($id = 'check_out', $required = false)
    {
        return [
            $id => [
                'type' => self::TYPE_INPUT_NUMBER,
                'label' => Travelpayouts::__('Check-out: today +'),
                'default' => 12,
                'required' => $required,
                'minimum' => 1,
                'maximum' => 30,
            ],
        ];
    }

    public static function returnLink()
    {
        return [
            'destination_date' => [
                'type' => self::TYPE_INPUT_NUMBER,
                'label' => Travelpayouts::__('Return: today +'),
                'default' => 12,
                'required' => false,
                'minimum' => 1,
                'maximum' => 30,
            ],
        ];
    }

    public static function text($id, $text)
    {
        return [
            'text_' . $id => [
                'type' => self::TYPE_TEXT,
                'label' => $text,
            ],
        ];
    }

    public static function textLink($required = true)
    {
        return [
            'text_link' => [
                'type' => self::TYPE_INPUT,
                'label' => Travelpayouts::__('Link text'),
                'default' => '',
                'required' => $required,
            ],
        ];
    }

    public static function searchForm($required = true, $type = null)
    {
        $model = new SearchForm();
        switch ($type) {
            case SearchFormShortcode::TYPE_AVIA:
                $forms = $model->getFlightsForms();
                break;
            case SearchFormShortcode::TYPE_HOTEL:
                $forms = $model->getHotelsForms();
                break;
            default:
                $forms = $model->findAll();
        }
        $options = $model->selectData($forms);

        return [
            'id' => [
                'type' => self::TYPE_SELECTBOX,
                'label' => Travelpayouts::__('Select search form'),
                'default' => (string)ArrayHelper::getFirstKey($options),
                'options' => $options,
                'required' => $required,
            ],
        ];
    }

    private static function getDate($format = 'd-m-Y', $modify = '')
    {
        $now = new DateTime();

        $date = $now;
        if (!empty($modify)) {
            $date = $now->modify($modify);
        }

        return $date->format($format);
    }

    public static function hr($id)
    {
        return [
            'hr_' . $id => [
                'type' => self::TYPE_HR,
            ],
        ];
    }

    private static function notArgs()
    {
        return [
            self::TYPE_HR,
            self::TYPE_TEXT,
        ];
    }

    public static function isArg($type)
    {
        return !in_array($type, self::notArgs());
    }

    private static function prepareEndpoint($endpoint)
    {
        return str_replace(
            [
                '${locale}',
            ],
            [
                LanguageHelper::dashboardLocale(),
            ],
            $endpoint
        );
    }

	/**
	 * @param string $key
	 * @param string $label
	 * @param bool $required
	 * @param bool $default
	 * @return array[]
	 */
	public static function checkbox($key, $label, $required = false, $default = false)
	{
		return [
			$key => [
				'type' => self::TYPE_CHECKBOX,
				'label' => $label,
				'default' => $default,
				'required' => $required,
			],
		];
	}
}
