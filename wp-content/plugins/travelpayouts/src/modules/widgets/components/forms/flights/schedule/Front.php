<?php

namespace Travelpayouts\modules\widgets\components\forms\flights\schedule;
use Travelpayouts\Vendor\DI\Annotation\Inject;
use Travelpayouts;
use Travelpayouts\components\rest\FrontFields;
use Travelpayouts\components\rest\FrontModel;

class Front extends FrontModel
{
    public $origin;
    public $destination;

    public function rules()
    {
        return array_merge(parent::rules(), [
            [
                [
                    'origin',
                    'destination',
                ],
                'required',
            ],
            [
                [
                    'origin',
                    'destination',
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
        return Travelpayouts::__('Flights schedule');
    }

    public function getFields()
    {
        return array_merge(
            FrontFields::origin(),
            FrontFields::destination(),
            FrontFields::filterByAirline(false, 'airline'),
            FrontFields::additionalMarker(
                $this->getValue('subid')
            )
        );
    }

    /**
     * @Inject
     * @param TpScheduleWidget $value
     */
    public function setData($value)
    {
        $this->data = $value->data;
    }
}
