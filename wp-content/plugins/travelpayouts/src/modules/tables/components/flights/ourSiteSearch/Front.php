<?php

namespace Travelpayouts\modules\tables\components\flights\ourSiteSearch;
use Travelpayouts\Vendor\DI\Annotation\Inject;
use Travelpayouts;
use Travelpayouts\components\rest\FrontFields;
use Travelpayouts\components\rest\FrontModel;

class Front extends FrontModel
{
    public $limit;
    public $stops;
    public $one_way;

    public function rules()
    {
        return array_merge(parent::rules(), [
            [
                [
                    'limit',
                    'stops',
                    'one_way',
                ],
                'safe',
            ],
        ]);
    }

    /**
     * @inheritDoc
     */
    public function shortcodeName()
    {
        return FrontFields::numberPrefix(10) . Travelpayouts::__('Searched on our website');
    }

    public function getFields()
    {
        return array_merge(
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
