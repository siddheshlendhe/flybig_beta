<?php

namespace Travelpayouts\modules\tables\components\flights\cheapestTicketsEachMonth;
use Travelpayouts\Vendor\DI\Annotation\Inject;
use Travelpayouts\modules\tables\components\api\travelpayouts\v1\PricesMonthlyApiModel;
use Travelpayouts\modules\tables\components\flights\ColumnLabels;
use Travelpayouts\modules\tables\components\flights\BaseTableData;
use Travelpayouts\modules\tables\components\flights\FlightsFilterFlightTrait;
use Travelpayouts\modules\tables\components\flights\FlightsFilterStopsTrait;

class TableData extends BaseTableData
{
    use FlightsFilterFlightTrait;
    use FlightsFilterStopsTrait;

    public $_data_map = [
        'number_of_changes' => 'transfers',
    ];

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
            ColumnLabels::DEPARTURE_AT => 7,
            ColumnLabels::RETURN_AT => 8,
            ColumnLabels::NUMBER_OF_CHANGES => 4,
            ColumnLabels::AIRLINE_LOGO => 5,
            ColumnLabels::BUTTON => self::MAX_PRIORITY,
            ColumnLabels::FLIGHT_NUMBER => 2,
            ColumnLabels::FLIGHT => 3,
            ColumnLabels::PRICE => 6,
            ColumnLabels::AIRLINE => self::MIN_PRIORITY,
        ];
    }

    /**
     * @Inject
     * @param PricesMonthlyApiModel $value
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
