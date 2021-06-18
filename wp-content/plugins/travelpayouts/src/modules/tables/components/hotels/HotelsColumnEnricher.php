<?php
/**
 * Created by: Andrey Polyakov (andrey@polyakov.im)
 */

namespace Travelpayouts\modules\tables\components\hotels;
use Travelpayouts\Vendor\DI\Annotation\Inject;
use Travelpayouts;
use Travelpayouts\components\HtmlHelper as Html;
use Travelpayouts\components\LanguageHelper;
use Travelpayouts\components\tables\enrichment\ApiColumnEnricher;
use Travelpayouts\components\tables\enrichment\UrlHelper;
use Travelpayouts\helpers\ArrayHelper;
use Travelpayouts\modules\tables\components\settings\HotelSettingsSection;

/**
 * Class HotelsHelper
 * @property-read string $name
 * @property-read string $stars
 * @property-read string $discount
 * @property-read string $old_price_and_new_price
 * @property-read string $button
 * @property-read string $price_pn
 * @property-read string $old_price_and_discount
 * @property-read string $distance
 * @property-read string $old_price_pn
 * @property-read string $rating
 * @property-read string $raw_name
 * @property-read string $raw_stars
 * @property-read string $raw_discount
 * @property-read string $raw_old_price_and_new_price
 * @property-read string $raw_button
 * @property-read string $raw_price_pn
 * @property-read string $raw_old_price_and_discount
 * @property-read string $raw_distance
 * @property-read string $raw_old_price_pn
 * @property-read string $raw_rating
 */
class HotelsColumnEnricher extends ApiColumnEnricher
{
    /**
     * @Inject
     * @var HotelSettingsSection
     */
    public $hotelSettings;

    public function get_stars()
    {
        $stars = $this->raw_stars;
        $stars_icons = '';
        for ($i = 1; $i <= $stars; $i++) {
            $stars_icons .= '★';
        }

        return Html::tag(
            'span',
            ['class' => 'stars'],
            $stars_icons
        );
    }

    public function get_raw_stars()
    {
        return $this->data->get('stars');
    }

    public function get_rating()
    {
        return $this->raw_rating;
    }

    public function get_raw_rating()
    {
        return $this->data->get('rating', 0) / 10;
    }

    protected function format_old_price($old_price)
    {
        return Html::tag(
            'span',
            ['class' => 'cross-out'],
            $this->price_cell_content($old_price)
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

    public function get_old_price_pn()
    {
        return $this->price_cell_content($this->raw_old_price);
    }

    public function get_raw_old_price_pn()
    {
        return $this->raw_old_price;
    }

    public function get_raw_old_price()
    {
        return $this->data->get('last_price_info.old_price');
    }

    public function get_old_price_and_discount()
    {
        $old_price = '';
        if ($this->raw_old_price) {
            $old_price = $this->format_old_price($this->raw_old_price);
        }
        $currentPrice = $this->format_price($this->data->get('price'));
        $discount = $this->raw_discount
            ? $this->discount
            : '';

        return implode(' ', [
            $old_price,
            $discount,
            $this->td_wrapper($currentPrice),
        ]);
    }

    public function get_raw_old_price_and_discount()
    {
        return $this->raw_discount;
    }

    public function get_price_pn()
    {
        if ($this->raw_price_pn) {
            return $this->price_cell_content($this->raw_price_pn);
        }
        return '';
    }

    public function get_raw_price_pn()
    {
        return $this->data->get('last_price_info.price');
    }

    public function get_discount()
    {
        $rawDiscount = $this->raw_discount;
        if ($rawDiscount > 0) {
            $prefix = '-';
            $postfix = '%';
            return $prefix . $rawDiscount . $postfix;
        }

        return '';
    }

    public function get_raw_discount()
    {
        return (int)$this->data->get('discount', 0) > 0
            ? $this->data->get('discount')
            : 0;
    }

    public function get_old_price_and_new_price()
    {
        $price = $this->get_price();
        $oldPrice = $this->data->get('last_price_info.old_price', '');

        return !empty($oldPrice)
            ?
            implode(' ', [
                $this->format_old_price($oldPrice),
                $price,
            ])
            : $price;
    }

    public function get_raw_old_price_and_new_price()
    {
        return $this->data->get('price');
    }

    public function get_name()
    {
        return $this->raw_name;
    }

    public function get_raw_name()
    {
        return $this->data->get('name');
    }

    protected function get_button_url()
    {
        $mediaParams = [
            'p' => UrlHelper::HOTELS_P,
            'marker' => !empty($this->account->api_marker)
                ? $this->get_marker()
                : null,
            'u' => $this->getRedirectUrl(),
        ];

        return UrlHelper::buildMediaUrl($mediaParams);
    }

    /**
     * @return string
     */
    protected function getRedirectUrl()
    {
        return UrlHelper::buildUrl($this->getRedirectHost(), $this->getRedirectParams());
    }

    /**
     * @return string
     */
    protected function getRedirectHost()
    {
        $hotelsDomain = $this->account->hotels_domain;

        if (!empty($hotelsDomain)) {
            return $hotelsDomain;
        }

        return $this->getUseBooking()
            ? 'https://yasen.hotellook.com/adaptors/location_deeplink'
            : 'https://search.hotellook.com';
    }

    /**
     * @return bool
     */
    protected function getUseBooking()
    {
        return (bool)$this->hotelSettings->use_booking_com && empty($this->account->hotels_domain);
    }

    /**
     * @return array
     */
    protected function getRedirectParams()
    {
        $useBooking = $this->getUseBooking();
        $linkWithoutDates = ArrayHelper::getBooleanValue($this->shortcode_attributes, 'link_without_dates');
        $hotelId = $this->settings->hotels_after_url === 'hotel'
            ? $this->data->get('hotel_id')
            : null;
        $locale = empty($this->account->hotels_domain)
            ? $this->settings->data->get(
                LanguageHelper::optionWithLanguage('hotels_source')
            )
            : null;
        $locationId = $this->shortcode_attributes->get('city');

        $params = array_filter([
            'locationId' => $locationId,
            'hotelId' => $hotelId,
            'locale' => $locale,
            'currency' => $this->currency_code,
        ]);

        if ($useBooking) {
            $params = [
                'gateId' => 2,
                'selectedHotelId' => $hotelId,
                'locationId' => $locationId,
                'language' => str_replace('-', '_', $locale),
                'currency' => $this->currency_code,
                'adults' => 2,
                'children' => 0,
                'skipRulerCheck' => 'skip',
                'flags' => ['utm' => 'tp_wp_plugin'],
                'utm_source' => 'tp_wp_plugin',
                'utm_medium' => 'table',
                'utm_campaign' => $linkWithoutDates
                    ? 'selection'
                    : 'selection with dates',
            ];
        }


        if (!$linkWithoutDates) {
            $checkIn = $this->data->get('last_price_info.search_params.checkIn');
            $checkOut = $this->data->get('last_price_info.search_params.checkOut');
            $params = array_merge($params, [
                'checkIn' => !empty($checkIn)
                    ? $this->date_time(
                        $checkIn,
                        'Y-m-d'
                    )
                    : null,
                'checkOut' => !empty($checkOut)
                    ? $this->date_time(
                        $checkOut,
                        'Y-m-d'
                    )
                    : null,
            ]);

        }

        $params['trs'] = $this->account->platform;

        return $params;
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
            $dictionaryTitle = $this->findTranslationOrReturnInput($buttonTitle, 'hotel.button', 'tables');
            return Travelpayouts::t($dictionaryTitle, $this->getButtonParams(), 'tables');
        }
        return $defaultButtonTitle;
    }


    /**
     * @inheritdoc
     */
    protected function buttonParams()
    {
        $result = [];
        $prices = array_filter([
            $this->raw_price,
            $this->raw_price_pn,
        ]);

        if (!empty($prices)) {
            $currentPrice = array_shift($prices);
            $result = array_merge($result, [
                'price' => $this->price_cell_content($currentPrice),
            ]);
        }
        return $result;
    }
}
