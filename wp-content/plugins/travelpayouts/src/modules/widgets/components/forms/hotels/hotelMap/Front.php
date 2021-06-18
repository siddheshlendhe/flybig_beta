<?php

namespace Travelpayouts\modules\widgets\components\forms\hotels\hotelMap;
use Travelpayouts\Vendor\DI\Annotation\Inject;
use Travelpayouts;
use Travelpayouts\components\rest\FrontFields;
use Travelpayouts\components\rest\FrontModel;

class Front extends FrontModel
{
    public $coordinates;

    public function rules()
    {
        return array_merge(parent::rules(), [
            [
                ['coordinates'],
                'required',
            ],
        ]);
    }

    /**
     * @inheritDoc
     */
    public function shortcodeName()
    {
        return Travelpayouts::__('Hotels Map');
    }

    public function getFields()
    {
        return array_merge(
            FrontFields::coordinates(),
            FrontFields::mapWidth($this->getValue('map_dimensions.width')),
            FrontFields::mapHeight($this->getValue('map_dimensions.height')),
            FrontFields::zoom(),
            FrontFields::additionalMarker('')
        );
    }

    /**
     * @Inject
     * @param TpHotelmapWidget $value
     */
    public function setData($value)
    {
        $this->data = $value->data;
    }
}
