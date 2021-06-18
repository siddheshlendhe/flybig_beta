<?php

namespace Travelpayouts\modules\widgets\components\forms\flights\ducklett;

use Travelpayouts;
use Travelpayouts\admin\redux\ReduxOptions;
use Travelpayouts\components\rest\FrontFields;
use Travelpayouts\components\rest\FrontModel;

class Front extends FrontModel
{
    public $origin;
    public $destination;
    public $airlines;
    public $filter;

    public function rules()
    {
        return array_merge(parent::rules(), [
            [
                [
                    'origin',
                    'destination',
                ],
                'required',
                'when' => function ($model) {
                    return $model->filter == Widget::FILTER_BY_ROUTE;
                },
            ],
            [
                ['airlines'],
                'required',
                'when' => function ($model) {
                    return $model->filter == Widget::FILTER_BY_AIRLINE;
                },
            ],
            [
                ['filter'],
                'safe',
            ],
        ]);
    }

    /**
     * @inheritDoc
     */
    public function shortcodeName()
    {
        return Travelpayouts::__('Flights. Special offers');
    }

    public function getFields()
    {
        return array_merge(
            FrontFields::widgetType(
                $this->getValue('widget_design', ReduxOptions::WIDGET_TYPE_SLIDER)
            ),
            FrontFields::radioFiltering(
                $this->getValue('filtering', '0'),
                [
                    [
                        'name' => Travelpayouts::__('For airlines'),
                        'values' => [
                            FrontFields::filterByAirline(true, 'airlines'),
                        ],
                    ],
                    [
                        'name' => Travelpayouts::__('For route'),
                        'values' => [
                            FrontFields::origin(true),
                            FrontFields::destination(true),
                        ],
                    ],
                ],
                true
            ),
            FrontFields::limit(
                $this->getValue('limit_special_offer', 2)
            ),
            FrontFields::hr(1),
            FrontFields::additionalMarker(
                $this->getValue('subid')
            )
        );
    }

    /**
     * @Inject
     * @param TpDucklettWidget $value
     */
    public function setData($value)
    {
        $this->data = $value->data;
    }
}
