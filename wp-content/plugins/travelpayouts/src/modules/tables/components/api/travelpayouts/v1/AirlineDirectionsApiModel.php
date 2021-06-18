<?php
/**
 * Created by: Andrey Polyakov (andrey@polyakov.im)
 */

namespace Travelpayouts\modules\tables\components\api\travelpayouts\v1;

use Travelpayouts\modules\tables\components\api\travelpayouts\BaseTravelpayoutsApiModel;

class AirlineDirectionsApiModel extends BaseTravelpayoutsApiModel
{
    /**
     * @var string|int
     * Records limit per page. Default value is 100. Not less than 1000.
     */
    public $limit = 100;
    /**
     * @var string
     * IATA code of airline.
     */
    public $airline_code;

    /**
     * @return array|array[]
     * @see $airline_code
     * @see $limit
     */
    public function rules()
    {
        return array_merge(parent::rules(), [
            [['limit', 'airline_code'], 'required'],
            [['limit'], 'number']
        ]);
    }

    /**
     * @inheritDoc
     */
    protected function endpointUrl()
    {
        return 'http://api.travelpayouts.com/v1/airline-directions';
    }
}
