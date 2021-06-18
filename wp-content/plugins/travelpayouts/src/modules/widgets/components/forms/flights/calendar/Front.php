<?php

namespace Travelpayouts\modules\widgets\components\forms\flights\calendar;
use Travelpayouts\Vendor\DI\Annotation\Inject;
use Travelpayouts;
use Travelpayouts\admin\redux\ReduxOptions;
use Travelpayouts\components\rest\FrontFields;
use Travelpayouts\components\rest\FrontModel;

class Front extends FrontModel
{
    public $origin;
    public $destination;
    public $currency;

    public function rules()
    {
        return array_merge(parent::rules(), [
            [
                ['destination'],
                'required',
            ],
            [
                [
                    'origin',
                    'destination',
                    'currency',
                ],
                'string',
                'length' => 3,
            ],
        ]);
    }

    /**
     * @inheritDoc
     */
    public function shortcodeName()
    {
        return Travelpayouts::__('Flights. Low price calendar');
    }

    public function getFields()
    {
        return array_merge(
            FrontFields::origin(false),
            FrontFields::destination(),
            FrontFields::additionalMarker(
                $this->getValue('subid')
            ),

            FrontFields::hr(1),

            FrontFields::period(ReduxOptions::PERIOD_WHOLE_YEAR, false),
            FrontFields::onlyDirectFlight(),
            FrontFields::oneWay()
        );
    }

    /**
     * @Inject
     * @param TpCalendarWidget $value
     */
    public function setData($value)
    {
        $this->data = $value->data;
    }
}
