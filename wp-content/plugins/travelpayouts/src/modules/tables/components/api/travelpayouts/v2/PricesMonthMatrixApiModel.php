<?php
/**
 * Created by: Andrey Polyakov (andrey@polyakov.im)
 */

namespace Travelpayouts\modules\tables\components\api\travelpayouts\v2;

use Travelpayouts\modules\tables\components\api\travelpayouts\BaseTravelpayoutsApiModel;

class PricesMonthMatrixApiModel extends BaseTravelpayoutsApiModel
{
    const TRIP_CLASS_ECONOMY = 0;
    const TRIP_CLASS_BUSINESS = 1;
    const TRIP_CLASS_FIRST = 2;

    const SCENARIO_PRICE_CALENDAR_WEEK = 'priceCalendarWeek';
    public $currency;
    public $origin;
    public $destination;
    /**
     * @var string
     * The beginning of the month in the YYYY-MM-DD format.
     */
    public $month;
    /**
     * @var bool
     * False - all the prices, true - just the prices, found using the partner marker (recommended).
     */
    public $show_to_affiliates;

    /**
     * @var string
     * @deprecated
     */
    public $depart_date;
    /**
     * @var string
     * @deprecated
     */
    public $return_date;

    public function rules()
    {
        return array_merge(parent::rules(), [
            [['currency', 'origin', 'destination'], 'required'],
            [['currency', 'origin', 'destination'], 'string', 'length' => 3],
            // @TODO Проверить
            [['month'], 'required', 'on' => [self::SCENARIO_DEFAULT]],
            [['depart_date', 'return_date'], 'required', 'on' => [self::SCENARIO_PRICE_CALENDAR_WEEK]],
        ]);
    }

    /**
     * @inheritDoc
     */
    protected function endpointUrl()
    {
        return 'http://api.travelpayouts.com/v2/prices/month-matrix';
    }
}
