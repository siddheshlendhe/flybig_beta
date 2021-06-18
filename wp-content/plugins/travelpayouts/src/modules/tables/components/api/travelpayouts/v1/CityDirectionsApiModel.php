<?php
/**
 * Created by: Andrey Polyakov (andrey@polyakov.im)
 */

namespace Travelpayouts\modules\tables\components\api\travelpayouts\v1;

use Travelpayouts\modules\tables\components\api\travelpayouts\BaseTravelpayoutsApiModel;

class CityDirectionsApiModel extends BaseTravelpayoutsApiModel
{
    public $currency = 'RUB';
    public $origin;

    public function rules()
    {
        return array_merge(parent::rules(), [
            [['currency', 'origin'], 'required'],
            [['currency', 'origin'], 'string', 'length' => 3],
        ]);
    }

    /**
     * @inheritDoc
     */
    protected function endpointUrl()
    {
        return 'http://api.travelpayouts.com/v1/city-directions';
    }
}
