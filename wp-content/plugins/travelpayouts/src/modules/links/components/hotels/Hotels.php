<?php

namespace Travelpayouts\modules\links\components\hotels;

use Travelpayouts;
use Travelpayouts\components\links\LinkModel;
use Travelpayouts\components\rest\FrontFields;
use Travelpayouts\components\rest\FrontModel;

class Hotels extends FrontModel
{
    public $text_link;
    public $hotel_id;

    public function rules()
    {
        return array_merge(parent::rules(), [
            [
                [
                    'text_link',
                    'hotel_id',
                ],
                'required',
            ],
        ]);
    }

    /**
     * @inheritDoc
     */
    public function shortcodeName()
    {
        return Travelpayouts::__('Search for hotels');
    }

    public function getFields()
    {
        return array_merge(
            FrontFields::textLink(),
            FrontFields::hotel(),
            FrontFields::hr(1),
            FrontFields::checkInLink(),
            FrontFields::checkOutLink(),
            FrontFields::hr(2),
            FrontFields::additionalMarker('')
        );
    }

    public function getDefaultAttributes()
    {
        return [
            'type' => LinkModel::TYPE_HOTELS,
        ];
    }

    public function setData($value)
    {
        return false;
    }
}
