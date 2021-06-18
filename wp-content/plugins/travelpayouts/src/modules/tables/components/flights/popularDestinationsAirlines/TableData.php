<?php

namespace Travelpayouts\modules\tables\components\flights\popularDestinationsAirlines;
use Travelpayouts\Vendor\DI\Annotation\Inject;
use Travelpayouts\modules\tables\components\flights\ColumnLabels;
use Travelpayouts\modules\tables\components\flights\BaseTableData;

class TableData extends BaseTableData
{
    protected function api_attributes()
    {
        return [
            'limit' => $this->shortcode_attributes->get('limit'),
            'airline_code' => $this->shortcode_attributes->get('airline'),
        ];
    }

    /**
     * @inheritdoc
     */
    protected function columnsPriority()
    {
        return [
            ColumnLabels::PLACE => self::MIN_PRIORITY,
            ColumnLabels::DIRECTION => 2,
            ColumnLabels::BUTTON => self::MAX_PRIORITY,
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
