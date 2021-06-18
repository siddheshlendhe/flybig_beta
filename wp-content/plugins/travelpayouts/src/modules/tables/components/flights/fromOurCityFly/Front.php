<?php

namespace Travelpayouts\modules\tables\components\flights\fromOurCityFly;
use Travelpayouts\Vendor\DI\Annotation\Inject;
use Travelpayouts;
use Travelpayouts\components\rest\FrontFields;
use Travelpayouts\components\rest\FrontModel;

class Front extends FrontModel
{
    public $origin;
    public $limit;
    public $stops;

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
        return FrontFields::numberPrefix(11) . Travelpayouts::__('Cheap Flights from origin');
    }

    public function getFields()
    {
        return array_merge(
            FrontFields::origin(),
            FrontFields::oneWay(),
            FrontFields::stopsNumber(
                $this->getValue('stops')
            ),
            FrontFields::limit(10),

            FrontFields::hr(1),

            FrontFields::additionalMarker(
                $this->getValue('subid')
            ),
            FrontFields::buttonTitle(),
            FrontFields::title(),
            FrontFields::hideTitle(),

            FrontFields::hr(2),

            FrontFields::currency(),
            FrontFields::tableLocale(),
            FrontFields::usePagination(
                $this->getValue('use_pagination')
            )
        );
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
