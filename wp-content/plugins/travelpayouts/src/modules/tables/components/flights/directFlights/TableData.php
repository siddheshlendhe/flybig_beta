<?php

namespace Travelpayouts\modules\tables\components\flights\directFlights;
use Travelpayouts\Vendor\DI\Annotation\Inject;
use Travelpayouts\modules\tables\components\api\travelpayouts\v1\PricesDirectApiModel;
use Travelpayouts\modules\tables\components\flights\ColumnLabels;
use Travelpayouts\modules\tables\components\flights\BaseTableData;
use Travelpayouts\modules\tables\components\flights\FlightsFilterFlightTrait;
use Travelpayouts\modules\tables\components\flights\FlightsFilterLimitTrait;

class TableData extends BaseTableData
{
    use FlightsFilterFlightTrait;
    use FlightsFilterLimitTrait;

    protected function api_attributes()
    {
        return [
            'currency' => $this->shortcode_attributes->get('currency'),
            'origin' => $this->shortcode_attributes->get('origin'),
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
            ColumnLabels::AIRLINE => self::MIN_PRIORITY,
            ColumnLabels::ORIGIN_DESTINATION => 4,
        ];
    }

    /**
     * @Inject
     * @param PricesDirectApiModel $value
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
