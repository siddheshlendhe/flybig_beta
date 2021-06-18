<?php

namespace Travelpayouts\modules\tables\components\railway\tutu;
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
        ]);
    }

    /**
     * @inheritDoc
     */
    public function shortcodeName()
    {
        return Travelpayouts::__('Train schedule');
    }

    public function getFields()
    {
        return array_merge(
            FrontFields::originRailway(),
            FrontFields::destinationRailway(),

            FrontFields::hr(1),

            FrontFields::filterByTrain(),

            FrontFields::hr(2),

            FrontFields::additionalMarker(
                $this->getValue('subid')
            ),
            FrontFields::buttonTitle(),
            FrontFields::title(),
            FrontFields::hideTitle(),

            FrontFields::hr(3),

            FrontFields::usePagination(
                $this->getValue('use_pagination')
            )
        );
    }

    /**
     * @inheritdoc
     */
    public static function isActive()
    {
        return Section::isActive();
    }

    /**
     * @Inject
     * @param Section $value
     */
    public function setData($value)
    {
        $this->data = $value->data;
    }
}
