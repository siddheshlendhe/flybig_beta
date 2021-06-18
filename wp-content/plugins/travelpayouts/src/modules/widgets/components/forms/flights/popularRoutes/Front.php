<?php

namespace Travelpayouts\modules\widgets\components\forms\flights\popularRoutes;
use Travelpayouts\Vendor\DI\Annotation\Inject;
use Travelpayouts;
use Travelpayouts\components\rest\FrontFields;
use Travelpayouts\components\rest\FrontModel;

class Front extends FrontModel
{
    public $destinations;

    public function rules()
    {
        return array_merge(parent::rules(), [
            [
                ['destinations'],
                'required',
                'when' => function ($model) {
                    return !is_array($model->destinations) || empty($model->destinations);
                },
            ],
        ]);
    }

    /**
     * @inheritDoc
     */
    public function shortcodeName()
    {
        return Travelpayouts::__('Flights. Top destinations');
    }

    public function getFields()
    {
        return array_merge(
            FrontFields::widgetCount($this->getValue('widget_count', 1)),
            FrontFields::hr(1),
            FrontFields::additionalMarker(
                $this->getValue('subid')
            )
        );
    }

    /**
     * @Inject
     * @param TpPopularRoutesWidget $value
     */
    public function setData($value)
    {
        $this->data = $value->data;
    }
}
