<?php

namespace Travelpayouts\modules\tables\components\flights\popularRoutesFromCity;
use Travelpayouts\Vendor\DI\Annotation\Inject;
use Travelpayouts\admin\redux\base\SectionFields;
use Travelpayouts\components\ApiModel;
use Travelpayouts\modules\tables\components\api\travelpayouts\v1\CityDirectionsApiModel;
use Travelpayouts\modules\tables\components\flights\ColumnLabels;
use Travelpayouts\modules\tables\components\flights\BaseTableData;

class TableData extends BaseTableData
{
    protected function api_attributes()
    {
        return [
            'currency' => $this->shortcode_attributes->get('currency'),
            'origin' => $this->shortcode_attributes->get('origin'),
            'destination' => $this->shortcode_attributes->get('destination'),
        ];
    }

    /**
     * @inheritdoc
     */
    protected function columnsPriority()
    {
        return [
            ColumnLabels::DESTINATION => 9,
            ColumnLabels::DEPARTURE_AT => 7,
            ColumnLabels::RETURN_AT => 8,
            ColumnLabels::AIRLINE_LOGO => 5,
            ColumnLabels::BUTTON => self::MAX_PRIORITY,
            ColumnLabels::FLIGHT_NUMBER => 3,
            ColumnLabels::FLIGHT => 2,
            ColumnLabels::PRICE => 6,
            ColumnLabels::AIRLINE => 1,
            ColumnLabels::ORIGIN_DESTINATION => 4,
        ];
    }

    /**
     * @Inject
     * @param CityDirectionsApiModel $value
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
