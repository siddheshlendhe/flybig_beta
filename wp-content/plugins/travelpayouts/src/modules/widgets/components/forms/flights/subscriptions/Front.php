<?php

namespace Travelpayouts\modules\widgets\components\forms\flights\subscriptions;
use Travelpayouts\Vendor\DI\Annotation\Inject;
use Travelpayouts;
use Travelpayouts\components\rest\FrontFields;
use Travelpayouts\components\rest\FrontModel;

class Front extends FrontModel
{
    /**
     * @inheritDoc
     */
    public function shortcodeName()
    {
        return Travelpayouts::__('Flights. Subscribe to price changes.');
    }

    public function getFields()
    {
        return array_merge(
            FrontFields::origin(false),
            FrontFields::destination(false),
            FrontFields::additionalMarker(
                $this->getValue('subid')
            )
        );
    }

    /**
     * @inheritdoc
     */
    public static function isActive()
    {
        return TpSubscriptionsWidget::isActive();
    }

    /**
     * @Inject
     * @param TpSubscriptionsWidget $value
     */
    public function setData($value)
    {
        $this->data = $value->data;
    }

}
