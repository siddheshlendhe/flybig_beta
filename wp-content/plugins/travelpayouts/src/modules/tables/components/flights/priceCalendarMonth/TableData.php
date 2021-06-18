<?php

namespace Travelpayouts\modules\tables\components\flights\priceCalendarMonth;
use Travelpayouts\Vendor\DI\Annotation\Inject;
use Travelpayouts\modules\tables\components\flights\BaseTableData;
use Travelpayouts\modules\tables\components\flights\ColumnLabels;
use Travelpayouts\modules\tables\components\flights\FlightsFilterStopsTrait;

class TableData extends BaseTableData
{
    use FlightsFilterStopsTrait;

    public $_data_map = [
        'price' => 'value',
        'departure_at' => 'depart_date',
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
            ColumnLabels::DEPARTURE_AT => 5,
            ColumnLabels::NUMBER_OF_CHANGES => 3,
            ColumnLabels::BUTTON => self::MAX_PRIORITY,
            ColumnLabels::PRICE => 4,
            ColumnLabels::TRIP_CLASS => 2,
            ColumnLabels::DISTANCE => self::MIN_PRIORITY,
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
