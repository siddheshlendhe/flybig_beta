<?php

namespace Travelpayouts\modules\tables\components\hotels\selectionsDate;
use Travelpayouts\Vendor\DI\Annotation\Inject;
use Travelpayouts;
use Travelpayouts\components\rest\FrontFields;
use Travelpayouts\components\rest\FrontModel;

class Front extends FrontModel
{
    public $city;
    public $number_results;
    public $type_selections;

    public function rules()
    {
        return array_merge(parent::rules(), [
            [
                [
                    'city',
                    'type_selections',
                ],
                'required',
            ],
            [
                [
                    'city',
                    'type_selections',
                ],
                'string',
            ],
        ]);
    }

    /**
     * @inheritDoc
     */
    public function shortcodeName()
    {
        return Travelpayouts::__('Hotel collections for dates');
    }

    public function getFields()
    {
        return array_merge(
            FrontFields::city(),
            FrontFields::selectionsType(),
            FrontFields::selectionLabel(),
            FrontFields::checkIn(),
            FrontFields::checkOut(),
            FrontFields::text(
                1,
                Travelpayouts::__('If we don’t have prices in our cache for these dates – no table will be shown')
            ),

            FrontFields::hr(1),

            FrontFields::additionalMarker(
                $this->getValue('subid')
            ),
            FrontFields::buttonTitle(),
            FrontFields::title(),
            FrontFields::hideTitle(),

            FrontFields::hr(2),

            FrontFields::numberResults(),
            FrontFields::linkWithoutDates(),

            FrontFields::hr(3),

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
