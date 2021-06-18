<?php

namespace Travelpayouts\modules\tables\components\flights\popularRoutesFromCity;
use Travelpayouts\Vendor\DI\Annotation\Inject;
use Travelpayouts;
use Travelpayouts\components\rest\FrontFields;
use Travelpayouts\components\rest\FrontModel;

class Front extends FrontModel
{
    public $currency;
    public $origin;

    public function rules()
    {
        return array_merge(parent::rules(), [
            [
                ['origin'],
                'required',
            ],
            [
                [
                    'origin',
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
        return FrontFields::numberPrefix(9) . Travelpayouts::__('Popular destinations from origin');
    }

    public function getFields()
    {
        return array_merge(
            FrontFields::origin(),

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
                $this->getValue('pagiuse_paginationnate')
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
