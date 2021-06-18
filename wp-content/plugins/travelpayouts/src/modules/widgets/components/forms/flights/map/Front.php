<?php

namespace Travelpayouts\modules\widgets\components\forms\flights\map;

use Travelpayouts;
use Travelpayouts\components\rest\FrontFields;
use Travelpayouts\components\rest\FrontModel;

class Front extends FrontModel
{
    public $origin;

    public function rules()
    {
        return array_merge(parent::rules(), [
            [
                ['origin'],
                'required',
            ],
            [
                ['origin'],
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
        return Travelpayouts::__('Flights. Price map');
    }

    public function getFields()
    {
        return array_merge(
            FrontFields::origin(),
            FrontFields::mapWidth(
                $this->getValue('map_dimensions.width')
            ),
            FrontFields::mapHeight(
                $this->getValue('map_dimensions.height')
            ),
            FrontFields::onlyDirectFlight(
                $this->getValue('only_direct_flight')
            ),
            FrontFields::hr(1),
            FrontFields::additionalMarker(
                $this->getValue('subid')
            )
        );
    }

    /**
     * @Inject
     * @param TpMapWidget $value
     */
    public function setData($value)
    {
        $this->data = $value->data;
    }
}
