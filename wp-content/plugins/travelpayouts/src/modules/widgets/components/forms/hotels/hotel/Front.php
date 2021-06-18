<?php

namespace Travelpayouts\modules\widgets\components\forms\hotels\hotel;
use Travelpayouts\Vendor\DI\Annotation\Inject;
use Travelpayouts;
use Travelpayouts\components\rest\FrontFields;
use Travelpayouts\components\rest\FrontModel;

class Front extends FrontModel
{

    public $hotel_id;

    public function rules()
    {
        return array_merge(parent::rules(), [
            [
                ['hotel_id'],
                'required',
            ],
        ]);
    }

    /**
     * @inheritDoc
     */
    public function shortcodeName()
    {
        return Travelpayouts::__('Hotel widget');
    }

    public function getFields()
    {
        return array_merge(
            FrontFields::hotel(),
            FrontFields::additionalMarker('')
        );
    }

    /**
     * @Inject
     * @param TpHotelWidget $value
     */
    public function setData($value)
    {
        $this->data = $value->data;
    }
}
