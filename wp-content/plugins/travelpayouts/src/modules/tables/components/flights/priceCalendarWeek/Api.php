<?php
/**
 * Created by: Andrey Polyakov (andrey@polyakov.im)
 */

namespace Travelpayouts\modules\tables\components\flights\priceCalendarWeek;

use DateTimeImmutable;
use Travelpayouts\modules\tables\components\api\travelpayouts\v2\PricesMonthMatrixApiModel;

class Api extends PricesMonthMatrixApiModel
{
    public $depart_date_days;
    public $return_date_days;

    public function __construct()
    {
        parent::__construct();
        $this->scenario = self::SCENARIO_PRICE_CALENDAR_WEEK;
        $this->show_to_affiliates = true;
        $this->depart_date = date('Y-m-d');
        $this->return_date = date('Y-m-d');
    }

    public function rules()
    {
        return array_merge(parent::rules(), [
            [['depart_date_days', 'return_date_days'], 'safe'],
        ]);
    }

    public function before_validate()
    {
        if ($this->depart_date_days && !is_int($this->depart_date_days)) {
            $this->add_error('depart_date_days', 'depart_date_days must be an integer');
            return false;
        }
        if ($this->return_date_days && !is_int($this->return_date_days)) {
            $this->add_error('return_date_days', 'return_date_days must be an integer');
            return false;
        }

        $currentDate = new DateTimeImmutable();

        if ($this->depart_date_days) {
            $departDateDays = $this->depart_date_days;
            $this->depart_date = $currentDate
                ->modify("+ $departDateDays day")
                ->format('d-m-Y');
        }

        if ($this->return_date_days) {
            $returnDateDays = $this->return_date_days;
            $this->return_date = $currentDate
                ->modify("+ $returnDateDays day")
                ->format('d-m-Y');
        }
        return true;
    }

}
