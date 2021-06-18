<?php

namespace Travelpayouts\modules\tables\components\flights\ourSiteSearch;
use Travelpayouts\Vendor\DI\Annotation\Inject;
use Travelpayouts\helpers\ArrayHelper;
use Travelpayouts\modules\tables\components\api\travelpayouts\v2\PricesLatestApiModel;
use Travelpayouts\modules\tables\components\flights\BaseTableData;
use Travelpayouts\modules\tables\components\flights\ColumnLabels;
use Travelpayouts\modules\tables\components\flights\FlightsFilterStopsTrait;

class TableData extends BaseTableData
{
    use FlightsFilterStopsTrait;

    protected $_data_map = [
        'price' => 'value',
        'return_at' => 'return_date',
        'departure_at' => 'depart_date',
    ];

    protected function api_attributes()
    {

        return [
            'one_way' => ArrayHelper::getBooleanValue($this->shortcode_attributes,'one_way'),
            'currency' => $this->shortcode_attributes->get('currency'),
            'limit' => $this->shortcode_attributes->get('limit'),
            'period_type' => $this->shortcode_attributes->get('period_type', 'month'),
        ];
    }

    /**
     * @inheritdoc
     */
    protected function columnsPriority()
    {
        return [
            ColumnLabels::ORIGIN_DESTINATION => 11,
            ColumnLabels::DEPARTURE_AT => 9,
            ColumnLabels::RETURN_AT => 10,
            ColumnLabels::BUTTON => self::MAX_PRIORITY,
            ColumnLabels::ORIGIN => 7,
            ColumnLabels::DESTINATION => 6,
            ColumnLabels::FOUND_AT => 2,
            ColumnLabels::PRICE => 8,
            ColumnLabels::NUMBER_OF_CHANGES => 5,
            ColumnLabels::TRIP_CLASS => self::MIN_PRIORITY,
            ColumnLabels::DISTANCE => 3,
            ColumnLabels::PRICE_DISTANCE => 4,
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
