<?php
/**
 * Created by: Andrey Polyakov (andrey@polyakov.im)
 */

namespace Travelpayouts\modules\tables\components\flights\popularDestinationsAirlines;

use Travelpayouts\components\dictionary as Dictionaries;
use Travelpayouts\components\LanguageHelper;
use Travelpayouts\modules\tables\components\api\travelpayouts\v1\AirlineDirectionsApiModel;

class Api extends AirlineDirectionsApiModel
{
    public function afterRequest()
    {
        parent::afterRequest();

        $response = $this->response;
        if (is_array($response)) {
            $responseDirections = array_keys($response);
            $result = array_map(static function ($direction, $key) use ($response) {
                $popularity = $response[$direction];

                return [
                    'place' => $key + 1,
                    'direction' => self::airportsToCities($direction),
                    'popularity' => $popularity,
                ];

            }, $responseDirections, array_keys($responseDirections));
            $this->response = $result;
        }
    }

    private static function airportsToCities($directions)
    {
        if (!preg_match('/^[A-Z]{3}-[A-Z]{3}$/', $directions)) {
            return $directions;
        }

        $directionsArray = explode('-', $directions);
        $dictionary = Dictionaries\Airports::getInstance([
            'lang' => LanguageHelper::TABLE_DEFAULT
        ]);

        $cities = array_map(function ($code) use ($dictionary) {
            return $dictionary->getItem($code)->getCityCode();
        }, $directionsArray);

        return implode('-', $cities);
    }
}
