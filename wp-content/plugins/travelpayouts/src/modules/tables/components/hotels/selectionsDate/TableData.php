<?php

namespace Travelpayouts\modules\tables\components\hotels\selectionsDate;
use Travelpayouts\Vendor\DI\Annotation\Inject;
use DateTime;
use Travelpayouts;
use Travelpayouts\modules\tables\components\hotels\BaseTableData;
use Travelpayouts\modules\tables\components\api\hotelLook\LocationApiModel;

class TableData extends BaseTableData
{
    protected function api_attributes()
    {
        return [
            'id' => $this->shortcode_attributes->get('city'),
            'limit' => $this->shortcode_attributes->get('number_results'),
            'language' => $this->shortcode_attributes->get(
                'locale',
                Travelpayouts::getInstance()->settings->language
            ),
            'type' => $this->shortcode_attributes->get('type_selections'),
            'currency' => $this->shortcode_attributes->get('currency'),
            'check_in' => $this->apiDateFormat($this->shortcode_attributes->get('check_in')),
            'check_out' => $this->apiDateFormat($this->shortcode_attributes->get('check_out')),
        ];
    }

    protected function apiDateFormat($input)
    {
        $date = DateTime::createFromFormat(LocationApiModel::DATE_INPUT_FORMAT, $input);

        return $date
            ? $date->format(LocationApiModel::DATE_OUTPUT_FORMAT)
            : null;
    }

    protected function columnsPriority()
    {
        return [
            'name' => 5,
            'stars' => 4,
            'rating' => 2,
            'price_pn' => 3,
            'button' => self::MAX_PRIORITY,
            'distance' => self::MIN_PRIORITY,
        ];
    }

    /**
     * @Inject
     * @param Api $value
     */
    public function setApi($value)
    {
        $this->api = $value;
    }

    /**
     * @Inject
     * @param Section $value
     */
    public function setSection($value)
    {
        $this->section = $value;
    }
}
