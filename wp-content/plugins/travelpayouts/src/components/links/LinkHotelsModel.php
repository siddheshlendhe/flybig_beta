<?php

namespace Travelpayouts\components\links;
use Travelpayouts\Vendor\Adbar\Dot;
use Travelpayouts\components\tables\enrichment\UrlHelper;

/**
 * Class LinkHotelsModel
 */
class LinkHotelsModel extends LinkModel
{
    const CHECK_IN_DEFAULT = 1;
    const CHECK_OUT_DEFAULT = 12;

    public $hotel_id;
    public $check_in;
    public $check_out;
    public $subid;

    public function rules()
    {
        return array_merge(parent::rules(), [
            [['hotel_id'], 'required'],
            [['check_in', 'check_out', 'subid'], 'safe'],
        ]);
    }

    /**
     * Формирования урл для отелей из параметров шорткода link
     * @return string
     */
    protected function get_url()
    {
        if (empty($this->check_in)) {
            $this->check_in = self::CHECK_IN_DEFAULT;
        }
        $checkIn = $this->date_time_add_days($this->check_in);

        if (empty($this->check_out)) {
            $this->check_out = self::CHECK_OUT_DEFAULT;
        }
        $checkOut = $this->date_time_add_days($this->check_out);

        $marker = UrlHelper::get_marker(
            $this->accountModule->marker,
            $this->subid,
            self::LINK_MARKER
        );

        $params = array_filter([
            $this->location() => $this->clearHotelId(),
            'checkIn' => $checkIn,
            'checkOut' => $checkOut,
            'locale' => $this->settingsModule->language,
            'currency' => $this->settingsModule->currency,
        ]);


        $rawHost = !empty($this->accountModule->whiteLabelHotels)
            ? $this->accountModule->whiteLabelHotels
            : 'https://search.hotellook.com';

        return UrlHelper::buildMediaUrl([
            'p' => UrlHelper::LINKS_P,
            'marker' => $marker,
            'u' => UrlHelper::buildUrl($rawHost, $params),
        ]);
    }

    /**
     * Убирает "locationId=" из поля hotel_id оставляя только id, значения старого плагина приходят
     * в виде locationId=123, достаточно просто 123
     * @return mixed
     */
    private function clearHotelId()
    {
        return str_replace('locationId=', '', $this->hotel_id);
    }

    private function location()
    {
        if (preg_match('/^locationId.*/',$this->hotel_id)) {
            return 'locationId';
        }

        return 'hotelId';
    }
}
