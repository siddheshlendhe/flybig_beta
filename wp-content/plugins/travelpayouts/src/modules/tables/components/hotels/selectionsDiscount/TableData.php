<?php

namespace Travelpayouts\modules\tables\components\hotels\selectionsDiscount;
use Travelpayouts\Vendor\DI\Annotation\Inject;
use Travelpayouts;
use Travelpayouts\modules\tables\components\api\hotelLook\LocationApiModel;
use Travelpayouts\modules\tables\components\hotels\BaseTableData;
use Travelpayouts\modules\tables\components\hotels\ColumnLabels;

class TableData extends BaseTableData
{
    protected function api_attributes()
    {
        return [
            'id' => $this->shortcode_attributes->get('city'),
            'limit' => $this->shortcode_attributes->get('number_results'),
            'currency' => $this->shortcode_attributes->get('currency'),
            'language' => $this->shortcode_attributes->get(
                'locale',
                Travelpayouts::getInstance()->settings->language
            ),
            'type' => $this->shortcode_attributes->get('type_selections'),
        ];
    }

    /**
     * @Inject
     * @param LocationApiModel $value
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

    /**
     * @inheritdoc
     */
    protected function columnsPriority()
    {
        return [
            ColumnLabels::NAME => 9,
            ColumnLabels::STARS => 8,
            ColumnLabels::DISCOUNT => 6,
            ColumnLabels::OLD_PRICE_AND_NEW_PRICE => 7,
            ColumnLabels::BUTTON => self::MAX_PRIORITY,
            ColumnLabels::PRICE_PN => 3,
            ColumnLabels::OLD_PRICE_AND_DISCOUNT => 2,
            ColumnLabels::DISTANCE => self::MIN_PRIORITY,
            ColumnLabels::OLD_PRICE_PN => 4,
            ColumnLabels::RATING => 5,
        ];
    }
}
