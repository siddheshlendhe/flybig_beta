<?php

namespace Travelpayouts\modules\tables\components\flights\popularDestinationsAirlines;
use Travelpayouts\Vendor\DI\Annotation\Inject;
use Travelpayouts;
use Travelpayouts\components\rest\FrontFields;
use Travelpayouts\components\rest\FrontModel;

class Front extends FrontModel
{
    public $limit;
    public $airline;

    public function rules()
    {
        return array_merge(parent::rules(), [
            [
                ['airline'],
                'required',
            ],
            [
                ['airline'],
                'string',
            ],
        ]);
    }

    /**
     * @inheritDoc
     */
    public function shortcodeName()
    {
        return FrontFields::numberPrefix(8) . Travelpayouts::__('Most popular flights via this airlines');
    }

    public function getFields()
    {
        return array_merge(
            FrontFields::filterByAirline(true, 'airline'),
            FrontFields::limit(10),

            FrontFields::hr(1),

            FrontFields::additionalMarker(
                $this->getValue('subid')
            ),
            FrontFields::buttonTitle(''),
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
