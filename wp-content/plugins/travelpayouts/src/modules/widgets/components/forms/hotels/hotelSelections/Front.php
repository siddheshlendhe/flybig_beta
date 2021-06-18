<?php

namespace Travelpayouts\modules\widgets\components\forms\hotels\hotelSelections;
use Travelpayouts\Vendor\DI\Annotation\Inject;
use Travelpayouts;
use Travelpayouts\admin\redux\ReduxOptions;
use Travelpayouts\components\rest\FrontFields;
use Travelpayouts\components\rest\FrontModel;

class Front extends FrontModel
{
    public $id;
    public $cat1;
    public $cat2;
    public $cat3;

    public function rules()
    {
        return array_merge(parent::rules(), [
            [
                ['id'],
                'required',
            ],
            [
                [
                    'cat1',
                    'cat2',
                    'cat3',
                ],
                'required',
                'when' => function ($model) {
                    return (empty($model->cat1) && empty($model->cat2) && empty($model->cat3));
                },
            ],
        ]);
    }

    /**
     * @inheritDoc
     */
    public function shortcodeName()
    {
        return Travelpayouts::__('Hotels picks');
    }

    public function getFields()
    {
        return array_merge(
            FrontFields::city(true, 'id'),
            FrontFields::selectionsTypeWidget(),
            FrontFields::hr(1),
            FrontFields::widgetDesign(
                $this->getValue('widget_design', ReduxOptions::WIDGET_DESIGN_FULL)
            ),
            FrontFields::limit(4),
            FrontFields::additionalMarker(
                $this->getValue('subid')
            )
        );
    }

    /**
     * @Inject
     * @param TpHotelSelectionsWidget $value
     */
    public function setData($value)
    {
        $this->data = $value->data;
    }
}
