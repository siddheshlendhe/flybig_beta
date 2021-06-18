<?php

namespace Travelpayouts\modules\tables\components\flights\cheapestTicketsEachMonth;
use Travelpayouts\Vendor\DI\Annotation\Inject;
use Travelpayouts;
use Travelpayouts\components\rest\FrontFields;
use Travelpayouts\components\rest\FrontModel;

class Front extends FrontModel
{
    public $origin;
    public $destination;
    public $currency;

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
            [
                [
                    'origin',
                    'destination',
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
        return FrontFields::numberPrefix(5) . Travelpayouts::__('Cheapest flights from origin to destination (next year)');
    }

    public function getFields()
    {
        return array_merge(
            FrontFields::origin(),
            FrontFields::destination(),

            FrontFields::hr(1),

            FrontFields::additionalMarker(
                $this->getValue('subid')
            ),
            FrontFields::buttonTitle(),
            FrontFields::title(),
            FrontFields::hideTitle(),

            FrontFields::hr(2),

            FrontFields::filterByAirline(false),
            FrontFields::filterByFlightNumber(),
            FrontFields::stopsNumber(
                $this->getValue('stops')
            ),

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
