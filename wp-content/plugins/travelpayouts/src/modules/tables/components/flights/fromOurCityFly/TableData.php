<?php

namespace Travelpayouts\modules\tables\components\flights\fromOurCityFly;
use Travelpayouts\Vendor\DI\Annotation\Inject;
use Travelpayouts\modules\tables\components\api\travelpayouts\v2\PricesLatestApiModel;
use Travelpayouts\modules\tables\components\flights\ColumnLabels;
use Travelpayouts\modules\tables\components\flights\BaseTableData;
use Travelpayouts\modules\tables\components\flights\FlightsFilterStopsTrait;

class TableData extends BaseTableData
{
    use FlightsFilterStopsTrait;

    public $_data_map = [
        'price' => 'value',
        'return_at' => 'return_date',
        'departure_at' => 'depart_date',
    ];

    protected function api_attributes()
    {
        return [
            'currency' => $this->shortcode_attributes->get('currency'),
            'origin' => $this->shortcode_attributes->get('origin'),
            'period_type' => $this->shortcode_attributes->get('period_type'),
            'limit' => $this->shortcode_attributes->get('limit'),
            'one_way' => filter_var(
                $this->shortcode_attributes->get('one_way', false),
                FILTER_VALIDATE_BOOLEAN
            ),
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
            ColumnLabels::BUTTON => self::MAX_PRIORITY,
            ColumnLabels::ORIGIN => self::MIN_PRIORITY,
            ColumnLabels::FOUND_AT => 3,
            ColumnLabels::PRICE => 7,
            ColumnLabels::NUMBER_OF_CHANGES => 6,
            ColumnLabels::TRIP_CLASS => 2,
            ColumnLabels::DISTANCE => 4,
            ColumnLabels::PRICE_DISTANCE => 5,
            ColumnLabels::ORIGIN_DESTINATION => self::MIN_PRIORITY,
        ];
    }

    /**
     * @Inject
     * @param PricesLatestApiModel $value
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
