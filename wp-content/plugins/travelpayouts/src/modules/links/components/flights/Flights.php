<?php

namespace Travelpayouts\modules\links\components\flights;

use Travelpayouts;
use Travelpayouts\components\links\LinkModel;
use Travelpayouts\components\rest\FrontFields;
use Travelpayouts\components\rest\FrontModel;

class Flights extends FrontModel
{
    public $text_link;
    public $origin;
    public $destination;

    public function rules()
    {
        return array_merge(parent::rules(), [
            [
                [
                    'text_link',
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
        return Travelpayouts::__('Search for flights');
    }

    public function getFields()
    {
        return array_merge(
            FrontFields::textLink(),
            FrontFields::origin(),
            FrontFields::destination(),
            FrontFields::hr(1),
            FrontFields::radioOneWay(
                'false',
                [
                    'false' => [
                        'name' => Travelpayouts::__('Roundtrip'),
                        'values' => [
                            FrontFields::departureLink(),
                            FrontFields::returnLink(),
                        ],

                    ],
                    'true' => [
                        'name' => Travelpayouts::__('One way'),
                        'values' => [
                            FrontFields::departureLink(),
                        ],

                    ],
                ],
                true
            ),
            FrontFields::hr(2),
            FrontFields::additionalMarker('')
        );
    }

    protected function getRadioOptionsFieldName()
    {
        return 'one_way';
    }

    public function getDefaultAttributes()
    {
        return [
            'type' => LinkModel::TYPE_FLIGHTS,
        ];
    }

    public function setData($value)
    {
        return false;
    }
}
